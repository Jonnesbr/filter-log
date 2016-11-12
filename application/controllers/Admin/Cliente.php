<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceControllerAdmin.php';

class Cliente extends InterfaceControllerAdmin
{

    protected $id = null;

    public function __construct()
    {
        parent::__construct();
        $this->viewsDirectory = 'admin/cliente';
        $this->setPaginacaoMetodoAjax('Admin/Cliente/AjaxPage/');
        $this->setPaginacaoView($this->viewsDirectory . '/lista');
        $this->ativaPaginacaoSemWhere();
        $this->addBreadCrumbs($this->lang->line('cliente'), true);
    }

    public function index()
    {
        $this->montaBusca();
        $this->initAjaxPage();

        if ($this->session->flashdata('retorno'))
            $this->templateAddItem('principal', 'retorno', $this->session->flashdata('retorno'));

        $this->WriteTemplates('index');
    }

    public function cadastro($argId = null)
    {
        $this->id = $argId;

        if ($this->id && !is_numeric($this->id))
            redirect(base_url().'Admin/Cliente', 'refresh');

        if ($this->input->post())
            $this->processarCadastroPost();

        if ($this->id)
            $this->carregarDadosPorId();

        $this->addBreadCrumbs($this->lang->line('cadastro'));
        $this->WriteTemplates('cadastro');
    }

    private function processarCadastroPost()
    {
        if ($this->validarFormCadastro()) {
            (is_numeric($this->id) && $this->id) ? $this->alterar($this->id) : $this->cadastrar();
            redirect(base_url().'Admin/Cliente/index', 'refresh');
        } else {
            $retorno = array('sucesso'=>false, 'mensagem'=>$this->form_validation->error_string());
            $this->templateAddItem('principal', 'retorno', $retorno);
        }
    }

    public function validarFormCadastro()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', 'Nome', "trim|required|valid_text");
        $this->form_validation->set_rules('ip', 'Endereço IP', "trim|required|valid_ip");

        return $this->form_validation->run();
    }

    private function cadastrar()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelcliente');

        if ($this->libcrud->inserir($this->getCadastroPost()))
            $this->session->set_flashdata('retorno', array('sucesso'=>true, 'mensagem'=>$this->lang->line('sucesso_cadastro')));
    }

    private function alterar()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelcliente');
        $this->libcrud->where = array('id' => $this->id);

        if ($this->libcrud->alterar($this->getCadastroPost()))
            $this->session->set_flashdata('retorno', array('sucesso'=>true, 'mensagem'=>$this->lang->line('sucesso_alteracao')));
    }

    private function getCadastroPost()
    {
        $dadosPost = array();
        $dadosPost['nome'] = $this->input->post('nome');
        $dadosPost['ip'] = $this->input->post('ip');

        return $dadosPost;
    }

    private function carregarDadosPorId()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelcliente');
        $this->libcrud->campos = 'id, nome, ip';
        $dados = $this->libcrud->buscarPorId($this->id);

        if(!$dados)
            redirect(base_url().'Admin/Cliente');

        $this->templateAddItem('principal', 'dadosCliente', $dados);
    }

    private function montaBusca()
    {
        $arrBusca = array(
            'order'  => 'cliente.nome ASC',
            'fields' => 'cliente.id, cliente.nome, cliente.ip',
            'limit'  => 10
        );

        if ($this->input->post())
            $this->processarBuscaPost($arrBusca);

        $this->session->set_userdata(array(get_class($this)=>$arrBusca));
    }

    private function processarBuscaPost(&$arrBusca)
    {
        if ($this->validarFormBusca()) {
            if ($this->input->post('nome'))
                $arrBusca['wheres']['nome like'] = "%{$this->input->post('nome')}%";
        } else
            $this->templateAddItem('principal', 'retorno', array('sucesso' => false, 'mensagem' => $this->form_validation->error_string()));
    }

    private function validarFormBusca()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', $this->lang->line('nome'), "trim|valid_text");

        return $this->form_validation->run();
    }

    public function buscaPaginada($argWhere = '', $argCampos = '', $argOrder = null, $argLimit= null, $argOffset=0, $argGroupBy = null, $argHaving = null)
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelcliente');
        $this->libcrud->where = $argWhere;
        $this->libcrud->campos = $argCampos;
        $this->libcrud->order = $argOrder;
        $this->libcrud->limit = $argLimit;
        $this->libcrud->offSet = $argOffset;
        $this->libcrud->groupBy = $argGroupBy;
        $this->libcrud->having = $argHaving;
        $resultSet = $this->libcrud->buscar();

        return $resultSet;
    }

}