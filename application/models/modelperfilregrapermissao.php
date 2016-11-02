<?php
include_once 'model.php';

class modelPerfilRegraPermissao extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('perfil_regra_permissao');
    }

}