<?php
include_once 'model.php';

class modelPesquisa extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('pesquisa');
    }

    public function buscarLista()
    {
        $this->setSelect($this->campos);
        $this->setLimit($this->limit,$this->offset);
        $this->setWhere($this->where);
        $this->setOrderBy($this->order);
        $this->db->join('unidade', 'id_unidade_hem = unidade.id');
        $this->db->join('usuario', 'id_usuario = usuario.id');
        return $this->resultArray();
    }

}