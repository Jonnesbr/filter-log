<?php
include_once 'model.php';

class modelCausa extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->setTable('causa');
    }

}