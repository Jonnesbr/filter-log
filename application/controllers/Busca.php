<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceController.php';

class Busca extends InterfaceController {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('AppBase/LibCrud');
    }

    public function cidadeSelectAjax()
    {
        $estado = $this->input->post('estado');
        header("Content-Type: text/html;");
        $this->libcrud->setModel('modelcidade');
        $this->libcrud->campos = 'id, nome';
        $this->libcrud->where = array('estado' => $estado);
        $this->libcrud->order = 'nome ASC';
        $cidades = $this->libcrud->buscar();

        foreach ($cidades as $cidade)
            echo "<option value='" . $cidade['id'] . "'>" . $cidade['nome'] . "</option>";
    }

}
