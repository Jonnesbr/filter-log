<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceControllerAdmin.php';

class AcessoNegado extends InterfaceControllerAdmin {

    public function __construct()
    {
        parent::__construct();
        $this->viewsDirectory = 'admin/acessonegado';
    }

    public function index()
    {
        $this->WriteTemplates('index');
    }

}

