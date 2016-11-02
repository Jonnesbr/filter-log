<?php
include_once 'model.php';

class modelCidade extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('cidade');
    }

}