<?php
include_once 'model.php';

class modelResolucaoCliente extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('resolucao_cliente');
    }

}