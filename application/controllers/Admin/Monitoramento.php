<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceControllerAdmin.php';

class Monitoramento extends InterfaceControllerAdmin
{

    public function __construct()
    {
        parent::__construct();
        $this->viewsDirectory = 'admin/monitoramento';
        $this->addBreadCrumbs($this->lang->line('monitoramento'), true);
    }

    public function index()
    {
        if ($this->session->flashdata('retorno'))
            $this->templateAddItem('principal', 'retorno', $this->session->flashdata('retorno'));

        $this->WriteTemplates('index');
    }

    public function tempoReal(){
        $this->WriteTemplates('tempoReal');
    }

    public function filtro(){
        $this->WriteTemplates('filtro');
    }

}
