<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LibCrud
{

    protected $CI;
    protected $model = '';
    public $where = array();
    public $campos = null;
    public $order = null;
    public $limit = null;
    public $offSet = null;
    public $groupBy = null;
    public $having = null;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function setModel($argModel)
    {
        $this->CI->load->model($argModel, '', TRUE);
        $this->model = $argModel;
    }

    public function inserir($argDados)
    {
        $retorno = $this->CI->{$this->model}->insert($argDados);
        $this->limpar();
        return $retorno;
    }

    public function inserirBatch($argDados)
    {
        return $this->CI->{$this->model}->insertBatch($argDados);
    }

    public function alterar($argDados)
    {
        $retorno = $this->CI->{$this->model}->update($argDados, $this->where);
        $this->limpar();
        return $retorno;
    }

    private function limpar()
    {
        $this->where = array();
        $this->campos = null;
        $this->order = null;
        $this->limit = null;
        $this->offSet = null;
        $this->groupBy = null;
        $this->having = null;
    }

    public function buscar()
    {
        $this->CI->{$this->model}->where = $this->where;
        $this->CI->{$this->model}->order = $this->order;
        $this->CI->{$this->model}->limit = $this->limit;
        $this->CI->{$this->model}->offset = $this->offSet;
        $this->CI->{$this->model}->groupBy = $this->groupBy;
        $this->CI->{$this->model}->having = $this->having;
        return $this->efetuarBusca();
    }

    public function efetuarBusca()
    {
        $this->CI->{$this->model}->campos = $this->campos;
        $retorno = $this->CI->{$this->model}->find();

        $this->limpar();

        return $retorno;
    }

    public function buscarPorId($argId)
    {
        $this->CI->{$this->model}->where = array('id' => $argId);
        $retorno = $this->efetuarBusca();

        if (count($retorno) > 0) {
            $retorno = $retorno[0];
        }

        return $retorno;
    }

    public function deletar()
    {
        $this->CI->db->delete($this->CI->{$this->model}->getTable(), $this->where);
        $retorno = $this->CI->db->affected_rows();
        $this->limpar();
        return $retorno;
    }

}