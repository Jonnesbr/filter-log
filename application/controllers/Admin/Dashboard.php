<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceControllerAdmin.php';

class Dashboard extends InterfaceControllerAdmin
{

    public function __construct()
    {
        parent::__construct();
        $this->viewsDirectory = 'admin/dashboard';
        $this->addBreadCrumbs($this->lang->line('dashboard'), true);
    }

    public function index()
    {
        if ($this->session->flashdata('retorno'))
            $this->templateAddItem('principal', 'retorno', $this->session->flashdata('retorno'));

        $this->WriteTemplates('index');
    }

}
