<?php
include_once 'model.php';

class modelUsuario extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('usuario');
    }

    public function buscarLista()
    {
        $this->setSelect($this->campos);
        $this->setLimit($this->limit,$this->offset);
        $this->setWhere($this->where);
        $this->setOrderBy($this->order);
        $this->db->join('perfil', 'id_perfil= perfil.id');
        return $this->resultArray();
    }

}