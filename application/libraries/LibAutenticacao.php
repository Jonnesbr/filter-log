<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/AppBase/LibCrud.php';

class LibAutenticacao extends LibCrud {

    public function __construct()
    {
        parent::__construct();
    }

    public function geraSenhaAleatoria($argCriptografar = false, $argTamanho = 8, $argMaiusculas = true, $argNumeros = true, $argSimbolos = false)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;
        if ($argMaiusculas) $caracteres .= $lmai;
        if ($argNumeros) $caracteres .= $num;
        if ($argSimbolos) $caracteres .= $simb;
        $len = strlen($caracteres);
        for ($n = 1; $n <= $argTamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
        }

        if ($argCriptografar)
            $retorno = $this->criptografarSenha($retorno);

        return $retorno;
    }

    public function efetuarLoginAdmin($argEmail, $argSenha)
    {
        $this->setModel('modelusuario');
        $this->campos = 'id, nome, senha, email, id_perfil, status';
        $this->where  = array('email' => $argEmail);
        $dadosAdmin   = $this->buscar();

        if (empty($dadosAdmin))
            return array('sucesso' => false, 'mensagem' => $this->CI->lang->line('dados_invalidos'));

        if ($this->verificarContaInativa($dadosAdmin[0]['status']))
            return array('sucesso' => false, 'mensagem' => $this->CI->lang->line('conta_inativa'));

        if ($dadosAdmin[0]['senha'] != $this->criptografarSenha($argSenha))
            return array('sucesso' => false, 'mensagem' => $this->CI->lang->line('dados_invalidos'));

        $this->setarDadosAminSessao($dadosAdmin[0]);

        return array('sucesso' => true, 'mensagem' => '');
    }

    private function setarDadosAminSessao($argDadosAdmin)
    {
        $this->CI->session->set_userdata('id_admin', $argDadosAdmin['id']);
        $this->CI->session->set_userdata('id_perfil', $argDadosAdmin['id_perfil']);
        $this->CI->session->set_userdata('admin_nome', $argDadosAdmin['nome']);
        $this->CI->session->set_userdata('admin_email', $argDadosAdmin['email']);
    }

    public function criptografarSenha($argSenha){
        return sha1($argSenha);
    }

    public function efetuarLogoutAdmin()
    {
        $this->CI->session->unset_userdata('id_admin');
        $this->CI->session->unset_userdata('id_perfil');
        $this->CI->session->unset_userdata('admin_nome');
        $this->CI->session->unset_userdata('admin_email');
        session_start();
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        session_destroy();
    }

    public function enviarRecuperacaoSenhaAdmin($argEmail)
    {
        $this->setModel('modelusuario');
        $this->campos = 'email, id, nome, status';
        $this->where  = array('email' => $argEmail);
        $dadosAdmin   = $this->buscar();

        if (empty($dadosAdmin))
            return array('sucesso' => false, 'mensagem' => $this->CI->lang->line('usuario_nao_encontrado'));

        if ($this->verificarContaInativa($dadosAdmin[0]['status']))
            return array('sucesso' => false, 'mensagem' => $this->CI->lang->line('conta_inativa'));

        $hash = $this->gerarHashRecuperacaoSenha($dadosAdmin[0]['id']);

        $this->where = array('id' => $dadosAdmin[0]['id']);
        $this->alterar(array('hash_recuperar_senha' => $hash));

        $linkRecuperacao = base_url()."Admin/Login/recuperarSenha/{$hash}";

        if (!$this->enviarEmailRecuperacaoSenha($argEmail, $linkRecuperacao))
            return array('sucesso' => false, 'mensagem' => $this->CI->lang->line('error_mensagem_email'));

        return array('sucesso' => true, 'mensagem' => $this->CI->lang->line('success_mensagem_email', array($dadosAdmin[0]['email'])));
    }

    private function enviarEmailRecuperacaoSenha($argEmail, $argLink)
    {
        $this->CI->load->library('email');
        $this->CI->email->from(EMAIL_RECUPERACAO, EMAIL_RECUPERACAO_NOME);
        $this->CI->email->to($argEmail);
        $this->CI->email->subject($this->CI->lang->line('recuperacao_senha'));

        $mensagem = $this->CI->lang->line('email_recuperacao', array($argLink, $argLink));
        $this->CI->email->message($mensagem);

        return $this->CI->email->send();
    }

    public function validarHashRecuperacaoSenhaAdmin($argHash)
    {
        $this->setModel('modelusuario');
        $this->campos = 'email, hash_recuperar_senha';
        $this->where  = array('hash_recuperar_senha'=>$argHash);
        $dadosAdmin   = $this->buscar();

        if(empty($dadosAdmin))
            return array('sucesso' => false, 'mensagem' => $this->CI->lang->line('dados_invalidos'), "email"=>'', "hash"=>"");

        if($argHash != $dadosAdmin[0]['hash_recuperar_senha'])
            return array('sucesso' => false, 'mensagem' => $this->CI->lang->line('dados_invalidos'), "email"=>'', "hash"=>"");

        if(!$this->verificarValidadeHashRecuperacaoSenha($argHash)){
            $linkRecuperacao = "<a href='" . BASE_URL . "Admin/Login' id='recuperar_senha'>aqui</a>";
            return array('sucesso' => false, 'mensagem' => $this->CI->lang->line('recuperacao_chave', array($linkRecuperacao)), "email" => $dadosAdmin[0]['email'], "hash" => "");
        }

        return array('sucesso'=>TRUE, 'mensagem'=>"", 'email'=>'', 'hash'=>$argHash);
    }

    private function verificarValidadeHashRecuperacaoSenha($argHash)
    {
        $hash = substr($argHash, 0, (strlen($argHash)-5));
        $time = base64_decode($hash);
        return (time() <= $time);
    }

    private function gerarHashRecuperacaoSenha($argId)
    {
        $now      = strtotime(date('Y-m-d H:i:s'));
        $time     = strtotime('+1 day', $now);
        $hashTime = base64_encode($time);
        $hashId   = substr(sha1($argId), 0, 5);
        return $hashTime.$hashId;
    }

    public function recadastarSenhaAdmin($argHash, $argSenha)
    {
        $validacaoHash = $this->validarHashRecuperacaoSenhaAdmin($argHash);

        if (!$validacaoHash['sucesso'])
            return $validacaoHash;

        $this->setModel('modelusuario');
        $this->campos = 'id, data_cadastro';
        $this->where  = array('hash_recuperar_senha'=>$argHash);
        $dadosAdmin   = $this->buscar();

        $this->alterarSenhaAdmin($dadosAdmin[0]['id'], $argSenha, $dadosAdmin[0]['data_cadastro']);

        $loginLink = base_url('Admin/Login');
        $linkLogin = "<a href='{$loginLink}' id='retorno_login'>{$this->CI->lang->line('efetuar_login')}</a>";
        return array('sucesso' => true, 'mensagem' => $this->CI->lang->line('senha_alterada', array($linkLogin)));
    }

    private function alterarSenhaAdmin($argId, $argSenha, $argDataCadastro)
    {
        $senhaCript = $this->criptografarSenha($argSenha, $argDataCadastro);
        $this->setModel('modelusuario');
        $this->where = array('id'=>$argId);
        return $this->alterar(array('senha'=>$senhaCript));
    }

    private function verificarContaInativa($argStatus)
    {
        return $argStatus == false;
    }

    public function configurarSenhaAdmin($argId, $argSenha)
    {
        $this->setModel('modelusuario');
        $this->campos = 'id, data_cadastro';
        $dadosAdmin = $this->buscarPorId($argId);

        return $this->alterarSenhaAdmin($dadosAdmin['id'], $argSenha, $dadosAdmin['data_cadastro']);
    }

}
