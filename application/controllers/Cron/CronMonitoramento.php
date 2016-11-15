<?php

class CronMonitoramento extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function verificarLog()
    {
        $this->load->library('LibMonitoramento');
        // Buscar registros no syslog, tratar e salvar em monitoramento
    }
}