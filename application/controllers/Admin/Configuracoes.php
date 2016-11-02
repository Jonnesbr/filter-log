<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceControllerAdmin.php';

class Configuracoes extends InterfaceControllerAdmin
{

    protected $id = null;

    public function __construct()
    {
        parent::__construct();
        $this->viewsDirectory = 'admin/configuracoes';
        $this->addBreadCrumbs($this->lang->line('configuracoes'), true);
    }

    public function index()
    {
        if ($this->input->post())
            $this->processarCadastroPost();

        if ($this->session->flashdata('retorno'))
            $this->templateAddItem('principal', 'retorno', $this->session->flashdata('retorno'));

        $this->WriteTemplates('index');
    }

    private function processarCadastroPost()
    {
        if ($this->validarFormCadastro()) {
            if ($this->alterar())
                redirect(base_url().'Admin/Dashboard');
        } else {
            $retorno = array('sucesso'=>false, 'mensagem'=>$this->form_validation->error_string());
            $this->templateAddItem('principal', 'retorno', $retorno);
        }
    }

    public function validarFormCadastro()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('senha_atual', $this->lang->line('senha_atual'), "callback_validar_senha_atual");
        $this->form_validation->set_rules('nova_senha', $this->lang->line('nova_senha'), "trim|required|valid_senha");
        $this->form_validation->set_rules('repetir_senha', $this->lang->line('repetir_senha'), "trim|required|matches[nova_senha]");

        return $this->form_validation->run();
    }

    public function validar_senha_atual($argData)
    {
        if (!$argData)
            return false;

        $this->form_validation->set_message('validar_senha_atual', $this->lang->line('senha_atual_nao_confere'));

        $this->load->library('LibAutenticacao');
        $this->libautenticacao->setModel('modelusuario');
        $this->libautenticacao->campos = 'senha';
        $usuario = $this->libautenticacao->buscarPorId($this->adminLogadoId);

        return ($usuario['senha'] == $this->libautenticacao->criptografarSenha($argData));
    }

    private function alterar()
    {
        $post = $this->getDadosPost();

        $this->load->library('LibAutenticacao');
        if ($this->libautenticacao->configurarSenhaAdmin($this->adminLogadoId, $post['nova_senha'])) {
            $this->session->set_flashdata('retorno', array('sucesso' => true, 'mensagem' => $this->lang->line('sucesso_alteracao')));
            return true;
        }

        return false;
    }

    private function getDadosPost()
    {
        $dadosPost['senha_atual'] = $this->input->post('senha_atual');
        $dadosPost['nova_senha'] = $this->input->post('nova_senha');

        return $dadosPost;
    }

}
