<?php
include_once 'model.php';

class modelPg extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('syslog', TRUE);
    }

}
