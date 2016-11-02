<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceControllerAdmin.php';

class Perfil extends InterfaceControllerAdmin
{

    protected $id = null;

    public function __construct()
    {
        parent::__construct();
        $this->viewsDirectory = 'admin/perfil';
        $this->setPaginacaoMetodoAjax('Admin/Perfil/AjaxPage/');
        $this->setPaginacaoView($this->viewsDirectory . '/lista');
        $this->ativaPaginacaoSemWhere();
        $this->addBreadCrumbs($this->lang->line('perfil'), true);
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
            redirect(base_url().'Admin/Perfil', 'refresh');

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
            redirect(base_url().'Admin/Perfil/index', 'refresh');
        } else {
            $retorno = array('sucesso'=>false, 'mensagem'=>$this->form_validation->error_string());
            $this->templateAddItem('principal', 'retorno', $retorno);
        }
    }

    public function validarFormCadastro()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', $this->lang->line('nome'), "trim|required|max_lengh[20]|valid_text|is_unique[perfil.nome.id.$this->id]");
        $this->form_validation->set_message('is_unique', 'Já existe um perfil com este nome');

        return $this->form_validation->run();
    }

    private function cadastrar()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelperfil');

        if ($this->libcrud->inserir($this->getCadastroPost()))
            $this->session->set_flashdata('retorno', array('sucesso'=>true, 'mensagem'=>$this->lang->line('sucesso_cadastro')));
    }

    private function alterar()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelperfil');
        $this->libcrud->where = array('id' => $this->id);

        if ($this->libcrud->alterar($this->getCadastroPost()))
            $this->session->set_flashdata('retorno', array('sucesso'=>true, 'mensagem'=>$this->lang->line('sucesso_alteracao')));
    }

    private function getCadastroPost()
    {
        $dadosPost = array();
        $dadosPost['nome'] = $this->input->post('nome');

        return $dadosPost;
    }

    private function carregarDadosPorId()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelperfil');
        $this->libcrud->campos = 'id, nome';
        $dados = $this->libcrud->buscarPorId($this->id);

        if(!$dados)
            redirect(base_url().'Admin/Perfil');

        $this->templateAddItem('principal', 'dadosPerfil', $dados);
    }

    private function montaBusca()
    {
        $arrBusca = array(
            'order'  => 'perfil.nome ASC',
            'fields' => 'perfil.id, perfil.nome',
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
        $this->libcrud->setModel('modelperfil');
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
