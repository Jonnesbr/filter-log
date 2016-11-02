<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceController.php';

class Login extends InterfaceController {

    public function __construct()
    {
        parent::__construct();
        $this->viewsDirectory = 'admin/login';
    }

    public function index()
    {
        $retorno = array();

        if ($this->input->post()) {
            $retorno = array('sucesso'=>false, 'mensagem'=>$this->lang->line('dados_invalidos'));

            if ($this->validarFormLogin()) {
                $this->load->library('LibAutenticacao');
                $email = $this->input->post('email');
                $senha = $this->input->post('senha');
                $retorno = $this->libautenticacao->efetuarLoginAdmin($email, $senha);

                if ($retorno['sucesso'])
                    redirect(base_url().'Admin/Dashboard', 'refresh');
            }
        }
        $this->templateAddItem('principal', 'retorno', $retorno);
        $this->WriteTemplatesLogin('login');
    }

    private function validarFormLogin()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'required|is_valid_email');
        $this->form_validation->set_rules('senha', $this->lang->line('senha'), 'required');

        return $this->form_validation->run();
    }

    public function logout()
    {
        $this->load->library('LibAutenticacao');
        $this->libautenticacao->efetuarLogoutAdmin();

        redirect(base_url().'Admin/Login', 'refresh');

        return false;
    }

    public function solicitarRecuperacaoSenhaRest()
    {
        $retorno = array('sucesso' => false,'mensagem' => $this->lang->line('informe_email'));

        if ($this->input->post()) {
            if ($this->validarCamposRecuperarSenhaRest()) {
                $this->load->library('LibAutenticacao');

                $retorno = $this->libautenticacao->enviarRecuperacaoSenhaAdmin($this->input->post('email'));
            }
        }

        $this->WriteTemplatesJson($retorno);
    }

    private function validarCamposRecuperarSenhaRest()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', $this->lang->line('email'), "trim|required|is_valid_email");

        return $this->form_validation->run();
    }

    public function recuperarSenha($argHash)
    {
        $retorno = array('sucesso' => false, 'mensagem' => $this->lang->line('dados_invalidos'), 'email'=>'', 'hash'=>'');
        $this->load->library('LibAutenticacao');
        $retorno = $this->libautenticacao->validarHashRecuperacaoSenhaAdmin($argHash);

        $this->templateAddItem('principal', 'sucesso', $retorno['sucesso']);
        $this->templateAddItem('principal', 'mensagem', $retorno['mensagem']);
        $this->templateAddItem('principal', 'email', $retorno['email']);
        $this->templateAddItem('principal', 'hash', $retorno['hash']);
        $this->WriteTemplatesLogin('recuperar_senha');
    }

    public function recadastrarSenhaRest()
    {
        $retorno = array('sucesso' => false, 'mensage' => $this->lang->line('dados_invalidos'));

        if ($this->input->post()) {
            $hash  = $this->input->post('hash');
            $senha = $this->input->post('senha');
            $senha_confirmacao = $this->input->post('senha_confirmacao');

            $retorno = $this->validarCamposRecadastrarSenha($hash);
            if ($retorno['sucesso']) {
                $this->load->library('LibAutenticacao');
                $retorno = $this->libautenticacao->recadastarSenhaAdmin($hash, $senha);
            }
        }

        $this->WriteTemplatesJson($retorno);
    }

    private function validarCamposRecadastrarSenha($argHash)
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('hash', $this->lang->line('hash'),'required');
        if (!$this->form_validation->run())
            return array('sucesso' => false, 'mensagem' => $this->lang->line('hash_nao_informado'));

        if (!$this->form_validation->valid_base64(substr($argHash, 0, (strlen($argHash)-5))))
            return array('sucesso' => false, 'mesangem' => $this->lang->line('chave_recuperacao_invalida'));

        $this->form_validation->set_rules('senha', $this->lang->line('senha'), 'trim|required|valid_senha');

        if ($this->input->post('senha'))
            $this->form_validation->set_rules('senha_confirmacao', $this->lang->line('confirmacao_senha'), 'trim|required|matches[senha]');

        if (!$this->form_validation->run())
            return array('sucesso' => false, 'mensagem' => validation_errors());

        return array('sucesso' => true, 'mensagem' => '');
    }

}

