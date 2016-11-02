<?php
include_once 'model.php';

class modelUnidade extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('unidade');
    }

}