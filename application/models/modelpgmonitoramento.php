<?php
include_once 'modelpg.php';

class modelPgMonitoramento extends ModelPg
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('systemevents');
    }

    public function executeQuery($argQuery)
    {
        $query = $this->db->query($argQuery);
        return $query->result_array();
    }
}