<?php
include_once 'model.php';

class modelResolucaoCliente extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('resolucao_cliente');
    }

    public function buscarCausaCliente()
    {
        $this->setSelect($this->campos);
        $this->setLimit($this->limit,$this->offset);
        $this->setWhere($this->where);
        $this->setOrderBy($this->order);
        $this->setGroupBy($this->groupBy);
        $this->db->join('cliente', 'resolucao_cliente.cliente_ip = cliente.ip');
        $this->db->join('causa', 'resolucao_cliente.causa_id = causa.id');
        return $this->resultArray();
    }

}