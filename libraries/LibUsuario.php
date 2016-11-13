<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/AppBase/LibCrud.php';

class LibUsuario extends LibCrud
{

    public function __construct()
    {
        parent::__construct();
        $this->setModel('modelusuario');
    }

    public function cadastrar($argDados)
    {
        $this->CI->load->library('LibAutenticacao');
        $senha = $this->CI->libautenticacao->geraSenhaAleatoria(false, 6);
        $argDados['senha'] = $this->CI->libautenticacao->criptografarSenha($senha);

        if ($id = $this->inserir($argDados)) {
            $this->CI->load->library('email');
            $this->CI->email->from(EMAIL_CADASTRO, EMAIL_CADASTRO_NOME);
            $this->CI->email->to($argDados['email']);
            $this->CI->email->subject($this->CI->lang->line('email_cadastro_assunto'));

            $mensagem = $this->CI->lang->line('email_cadastro_mensagem', array($argDados['nome'], $argDados['email'], $senha));
            $this->CI->email->message($mensagem);
            $this->CI->email->send();

            return $id;
        }

        return false;
    }

    public function buscarLista()
    {
        $this->CI->{$this->model}->where = $this->where;
        $this->CI->{$this->model}->campos = $this->campos;
        $this->CI->{$this->model}->limit = $this->limit;
        $this->CI->{$this->model}->order = $this->order;
        $this->CI->{$this->model}->offset = $this->offSet;
        $this->CI->{$this->model}->groupBy = $this->groupBy;
        $this->CI->{$this->model}->having = $this->having;
        return $this->CI->{$this->model}->buscarLista();
    }

}