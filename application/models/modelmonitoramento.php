<?php
include_once 'model.php';

class modelMonitoramento extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('monitoramento');
    }

    public function buscarLista()
    {
        $this->setSelect($this->campos);
        $this->setLimit($this->limit,$this->offset);
        $this->setWhere($this->where);
        $this->setOrderBy($this->order);
        return $this->resultArray();
    }

}