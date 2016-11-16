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

    public function monitorar()
    {
        $this->carregarSelectCliente();

        if ($this->input->post())
            $this->processarMonitoramentoPost();

        $this->WriteTemplates('monitorar');
    }

    private function processarMonitoramentoPost()
    {
        if ($this->validarFormCadastro()) {
            $this->atualizar();
            redirect(base_url().'Admin/Monitoramento/index', 'refresh');
        } else {
            $retorno = array('sucesso'=>false, 'mensagem'=>$this->form_validation->error_string());
            $this->templateAddItem('principal', 'retorno', $retorno);
        }
    }

    public function validarFormCadastro()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cliente', 'Cliente', "trim|required");

        return $this->form_validation->run();
    }

    private function atualizar()
    {
        $this->load->library('LibMonitoramento');

        if ($this->libmonitoramento->gerarRegistro(($this->getClientPost())))
            $this->session->set_flashdata('retorno', array('sucesso'=>true, 'mensagem'=>'Novos dados gerados com sucesso'));
    }

    private function getClientPost()
    {
        $dadosPost = array();
        $dadosPost['ip'] = $this->input->post('cliente');

        return $dadosPost;
    }

    private function carregarSelectCliente()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelcliente');
        $this->libcrud->campos = 'id, ip, nome';
        $this->libcrud->order = 'nome ASC';
        $rs = $this->libcrud->buscar();

        $clientes = array('' => $this->lang->line('selecione'));

        foreach ($rs as $cliente)
            $clientes[$cliente['ip']] = $cliente['nome'];

        $this->templateAddItem('principal', 'optionsCliente', $clientes);
    }

}
