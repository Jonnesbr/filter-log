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

    public function buscarEvento()
    {
        $this->setSelect($this->campos);
        $this->setLimit($this->limit,$this->offset);
        $this->setWhere($this->where);
        $this->setOrderBy($this->order);
        $this->setGroupBy($this->groupBy);
        $this->db->join('cliente', 'monitoramento.cliente_ip = cliente.ip');
        return $this->resultArray();
    }

    public function buscarTotalCliente()
    {
        $this->setSelect($this->campos);
        $this->setLimit($this->limit,$this->offset);
        $this->setWhere($this->where);
        $this->setOrderBy($this->order);
        $this->setGroupBy($this->groupBy);
        $this->db->join('cliente', 'monitoramento.cliente_ip = cliente.ip');
        $this->db->join('resolucao_cliente', 'resolucao_cliente.cliente_ip = monitoramento.cliente_ip');
        $this->db->join('causa', 'resolucao_cliente.causa_id = causa.id');
        return $this->resultArray();
    }

}