<?php
include_once 'model.php';

class modelPerfilRegra extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('perfil_regra');
    }

}