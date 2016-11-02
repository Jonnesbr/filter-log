<?php
include_once 'model.php';

class modelPerfil extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('perfil');
    }

}