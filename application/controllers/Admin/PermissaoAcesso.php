<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceControllerAdmin.php';

class PermissaoAcesso extends InterfaceControllerAdmin
{

    protected $id_perfil = null;

    public function __construct()
    {
        parent::__construct();
        $this->viewsDirectory = 'admin/permissaoacesso';
    }

    public function cadastro($argIdPerfil)
    {
        if ($argIdPerfil == PERFIL_ADMINISTRADOR)
            return $this->perfilAdministrador();

        $this->id_perfil = $argIdPerfil;

        if (!$this->id_perfil || !is_numeric($this->id_perfil))
            redirect(base_url().'Admin/Perfil', 'refresh');

        $this->carregarPerfilRegras();
        $this->carregarPerfilRegraPermissoes();

        if ($this->input->post())
            $this->processarCadastroPost();

        if ($this->session->flashdata('retorno'))
            $this->templateAddItem('principal', 'retorno', $this->session->flashdata('retorno'));

        $this->carregarDadosPerfil();

        $this->addBreadCrumbs($this->lang->line('cadastro'));
        $this->WriteTemplates('cadastro');
    }

    private function carregarDadosPerfil()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelperfil');
        $this->libcrud->campos = 'nome';
        $perfil = $this->libcrud->buscarPorId($this->id_perfil);

        $this->templateAddItem('principal', 'id_perfil', $this->id_perfil);
        $this->templateAddItem('principal', 'perfil', $perfil['nome']);
    }

    private function perfilAdministrador()
    {
        $this->addBreadCrumbs($this->lang->line('cadastro'));
        $this->WriteTemplates('perfil_admin');
    }

    private function carregarPerfilRegras()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelperfilregra');
        $this->libcrud->campos = '*';
        $this->libcrud->order = 'contexto ASC, descricao ASC';
        $rs = $this->libcrud->buscar();

        $this->templateAddItem('principal', 'perfilRegras', $rs);
    }

    private function carregarPerfilRegraPermissoes()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelperfilregrapermissao');
        $this->libcrud->campos = 'perfil_regra_id as id';
        $this->libcrud->where = array('perfil_id' => $this->id_perfil);
        $this->libcrud->order = 'id ASC';
        $rs = $this->libcrud->buscar();
        $retorno = array();

        foreach ($rs as $permissao)
            $retorno[] = $permissao['id'];

        $this->templateAddItem('principal', 'perfilRegraPermissoes', $retorno);
    }

    private function processarCadastroPost()
    {
        if ($this->validarFormCadastro()) {
            $this->cadastrar();
        } else {
            $retorno = array('sucesso'=>false, 'mensagem'=>$this->form_validation->error_string());
            $this->templateAddItem('principal', 'retorno', $retorno);
        }
    }

    public function validarFormCadastro()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('perfil_regra[]', $this->lang->line('regra'), "is_natural_no_zero");
        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('regra_invalida'));

        return $this->form_validation->run();
    }

    private function cadastrar()
    {
        $this->load->library('LibPerfil');

        $post = $this->getCadastroPost();

        if ($this->libperfil->cadastrarPerfilRegras($this->id_perfil, $post['perfil_regra'])) {
            $this->session->set_flashdata('retorno', array('sucesso'=>true, 'mensagem'=>$this->lang->line('sucesso_cadastro')));
            redirect(base_url().'Admin/PermissaoAcesso/cadastro/' . $this->id_perfil, 'refresh');
        }
    }

    private function getCadastroPost()
    {
        $this->load->library('AppBase/LibInfraFormatador');

        $dadosPost = array();
        $dadosPost['perfil_regra'] = $this->input->post('perfil_regra');

        return $dadosPost;
    }

}
