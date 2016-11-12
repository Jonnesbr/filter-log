<?php
include_once 'model.php';

class modelCliente extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('cliente');
    }

}