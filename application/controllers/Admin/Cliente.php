<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceControllerAdmin.php';

class Cliente extends InterfaceControllerAdmin
{

    protected $id = null;

    public function __construct()
    {
        parent::__construct();
        $this->viewsDirectory = 'admin/cliente';
        $this->setPaginacaoMetodoAjax('Admin/Cliente/AjaxPage/');
        $this->setPaginacaoView($this->viewsDirectory . '/list');
        $this->ativaPaginacaoSemWhere();
        $this->addBreadCrumbs($this->lang->line('cliente'), true);
    }

    public function index()
    {
        
    }
}