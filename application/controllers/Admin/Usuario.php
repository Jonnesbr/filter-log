<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceControllerAdmin.php';

class Usuario extends InterfaceControllerAdmin
{

    protected $id = null;

    public function __construct()
    {
        parent::__construct();
        $this->viewsDirectory = 'admin/usuario';
        $this->setPaginacaoMetodoAjax('Admin/Usuario/AjaxPage/');
        $this->setPaginacaoView($this->viewsDirectory . '/lista');
        $this->ativaPaginacaoSemWhere();
        $this->addBreadCrumbs($this->lang->line('usuario'), true);
    }

    public function index()
    {
        $this->montaBusca();
        $this->initAjaxPage();

        if ($this->session->flashdata('retorno'))
            $this->templateAddItem('principal', 'retorno', $this->session->flashdata('retorno'));

        $this->carregarSelectPerfil();
        $this->WriteTemplates('index');
    }

    public function cadastro($argId = null)
    {
        $this->id = $argId;

        if ($this->id && !is_numeric($this->id))
            redirect(base_url().'Admin/Usuario', 'refresh');

        $this->carregarSelectPerfil();
        $this->carregarSelectEstado();
        $this->carregaSelectCidade($this->input->post('estado'));
        $this->carregarSelectStatus();

        if ($this->input->post())
            $this->processarCadastroPost();

        if ($this->id)
            $this->carregarDadosPorId();

        $this->addBreadCrumbs($this->lang->line('cadastro'));
        $this->WriteTemplates('cadastro');
    }

    private function carregarSelectPerfil()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelperfil');
        $this->libcrud->campos = 'id, nome';
        $this->libcrud->order = 'nome ASC';
        $rs = $this->libcrud->buscar();

        $perfis = array('' => $this->lang->line('selecione'));

        foreach ($rs as $perfil)
            $perfis[$perfil['id']] = $perfil['nome'];

        $this->templateAddItem('principal', 'optionsPerfil', $perfis);
    }

    private function carregarSelectEstado()
    {
        $this->load->library('AppBase/libBase');
        $rs = $this->libbase->estados();

        $estados = array('' => $this->lang->line('selecione'));

        foreach ($rs as $sigla => $nome)
            $estados[$sigla] = $nome;

        $this->templateAddItem('principal', 'optionsEstado', $estados);
    }

    private function carregaSelectCidade($argEstado='')
    {
        $cidades = array('' => $this->lang->line('selecione_estado'));

        if ($argEstado) {
            $this->load->library('AppBase/LibCrud');
            $this->libcrud->setModel('modelcidade');
            $this->libcrud->campos = 'id, nome';
            $this->libcrud->where  = array('estado' => $argEstado);
            $this->libcrud->order  = 'nome ASC';
            $rs = $this->libcrud->buscar();

            foreach ($rs as $cidade)
                $cidades[$cidade['id']] = $cidade['nome'];
        }
        $this->templateAddItem('principal', 'optionsCidade', $cidades);
    }

    private function carregarSelectStatus()
    {
        $status = array(
            STATUS_INATIVO => strtoupper($this->lang->line('inativo')),
            STATUS_ATIVO   => strtoupper($this->lang->line('ativo'))
        );

        $this->templateAddItem('principal', 'optionsStatus', $status);
    }

    private function processarCadastroPost()
    {
        if ($this->validarFormCadastro()) {
            (is_numeric($this->id) && $this->id) ? $this->alterar($this->id) : $this->cadastrar();
            redirect(base_url().'Admin/Usuario/index', 'refresh');
        } else {
            $retorno = array('sucesso'=>false, 'mensagem'=>$this->form_validation->error_string());
            $this->templateAddItem('principal', 'retorno', $retorno);
        }
    }

    public function validarFormCadastro()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('perfil', $this->lang->line('perfil'), "required|is_natural_no_zero");
        $this->form_validation->set_rules('nome', $this->lang->line('nome_completo'), "trim|required|max_lengh[50]|is_full_name");
        $this->form_validation->set_rules('cpf', $this->lang->line('cpf'), "trim|valid_cpf");
        $this->form_validation->set_rules('data_nascimento', $this->lang->line('data_nascimento'), "trim|valid_data[/]");
        $this->form_validation->set_rules('email', $this->lang->line('email'), "trim|required|max_lengh[50]|valid_email|is_unique[usuario.email.id.$this->id]");
        $this->form_validation->set_rules('telefone', $this->lang->line('telefone'), "trim|valid_telefone");
        $this->form_validation->set_rules('status', $this->lang->line('status'), "trim|required|is_natural");
        $this->form_validation->set_message('is_unique', $this->lang->line('usuario_email_duplicado'));

        return $this->form_validation->run();
    }

    private function cadastrar()
    {
        $this->load->library('LibUsuario');

        if ($this->libusuario->cadastrar($this->getCadastroPost()))
            $this->session->set_flashdata('retorno', array('sucesso'=>true, 'mensagem'=>$this->lang->line('sucesso_cadastro')));
    }

    private function alterar()
    {
        $this->load->library('LibUsuario');
        $this->libusuario->where = array('id' => $this->id);

        if ($this->libusuario->alterar($this->getCadastroPost()))
            $this->session->set_flashdata('retorno', array('sucesso'=>true, 'mensagem'=>$this->lang->line('sucesso_alteracao')));
    }

    private function getCadastroPost()
    {
        $this->load->library('AppBase/LibInfraFormatador');

        $dadosPost = array();
        $dadosPost['id_perfil']       = $this->input->post('perfil');
        $dadosPost['nome']            = $this->input->post('nome');
        $dadosPost['cpf']             = ($this->input->post('cpf')) ? $this->libinfraformatador->retiraCaracteresEspeciais($this->input->post('cpf')) : null;
        $dadosPost['data_nascimento'] = ($this->input->post('data_nascimento')) ? $this->libinfraformatador->formatarPadraoBanco($this->input->post('data_nascimento')) : null;
        $dadosPost['email']           = $this->input->post('email');
        $dadosPost['telefone']        = ($this->input->post('telefone')) ? $this->libinfraformatador->retiraCaracteresEspeciais($this->input->post('telefone')) : null;
        $dadosPost['id_cidade']       = '9348';
        $dadosPost['status']          = $this->input->post('status');
        return $dadosPost;
    }

    private function carregarDadosPorId()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelusuario');
        $this->libcrud->campos = 'id, id_perfil, cpf, nome, email, telefone, celular, data_nascimento, cep, endereco, numero, complemento, bairro, id_cidade, status';
        $dados = $this->libcrud->buscarPorId($this->id);

        if(!$dados)
            redirect(base_url().'Admin/Usuario');

        $this->formatarDadosInterface($dados);

        if ($dados['id_cidade']) {
            $this->libcrud->setModel('modelcidade');
            $this->libcrud->campos = 'estado';
            $this->libcrud->where = array('id' => $dados['id_cidade']);

            if ($cidade = $this->libcrud->buscar()) {
                $dados['estado'] = $cidade[0]['estado'];
                $this->carregaSelectCidade($cidade[0]['estado']);
            }
        }

        $this->templateAddItem('principal', 'dadosUsuario', $dados);
    }

    private function formatarDadosInterface(&$argDados)
    {
        $argDados = array($argDados);
        $this->load->library('AppBase/LibInfraFormatador');
        $this->libinfraformatador->campos_data     = array('data_nascimento');
        $this->libinfraformatador->campos_cpfcnpj  = array('cpf');
        $this->libinfraformatador->campos_telefone = array('telefone', 'celular');
        $this->libinfraformatador->formatarDados($argDados);
        $argDados = $argDados[0];
    }

    private function montaBusca()
    {
        $arrBusca = array(
            'order'  => 'usuario.nome ASC',
            'fields' => 'usuario.id, usuario.nome, usuario.email, perfil.nome as perfil, usuario.status',
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
                $arrBusca['wheres']['usuario.nome like'] = "%{$this->input->post('nome')}%";
            if ($this->input->post('perfil'))
                $arrBusca['wheres']['usuario.id_perfil'] = $this->input->post('perfil');
        } else
            $this->templateAddItem('principal', 'retorno', array('sucesso' => false, 'mensagem' => $this->form_validation->error_string()));
    }

    public function validarFormBusca()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('perfil', $this->lang->line('perfil'), "is_natural_no_zero");
        $this->form_validation->set_rules('nome', $this->lang->line('nome'), "is_valid_text");

        return $this->form_validation->run();
    }

    public function buscaPaginada($argWhere = '', $argCampos = '', $argOrder = null, $argLimit= null, $argOffset=0, $argGroupBy = null, $argHaving = null)
    {
        $this->load->library('LibUsuario');
        $this->libusuario->where   = $argWhere;
        $this->libusuario->campos  = $argCampos;
        $this->libusuario->order   = $argOrder;
        $this->libusuario->limit   = $argLimit;
        $this->libusuario->offSet  = $argOffset;
        $this->libusuario->groupBy = $argGroupBy;
        $this->libusuario->having  = $argHaving;
        $resultSet = $this->libusuario->buscarLista();

        return $resultSet;
    }

}
