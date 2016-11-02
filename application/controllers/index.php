<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceController.php';

class Index extends InterfaceController {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect(base_url().'Admin/Dashboard', 'refresh');
    }

}

