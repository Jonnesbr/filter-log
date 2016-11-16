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
        $this->carregarEventos();
        $this->carregarClientesSemEventos();

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

    /**
     * Inicio do processo de captura de eventos no banco Life
     */
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

    private function carregarEventos()
    {
        $this->load->library('LibMonitoramento');
        $this->libmonitoramento->setModel('modelmonitoramento');
        $this->libmonitoramento->campos = 'cliente.nome, monitoramento.cliente_ip, COUNT(monitoramento.cliente_ip) as qtde, cliente.id as cliente_id';
        $this->libmonitoramento->groupBy = 'cliente_ip';
        $this->libmonitoramento->order = 'cliente_ip ASC';
        $rs = $this->libmonitoramento->buscarEvento();

        $this->templateAddItem('principal', 'dadosEventos', $rs);
    }

    private function carregarClientesSemEventos()
    {
        $this->load->library('LibMonitoramento');
        $this->libmonitoramento->setModel('modelmonitoramento');
        $this->libmonitoramento->campos = 'cliente.nome, monitoramento.cliente_ip, monitoramento.resolucao';
        $this->libmonitoramento->where = array('monitoramento.resolucao' => STATUS_ATIVO);
        $this->libmonitoramento->order = 'cliente_ip ASC';
        $rs = $this->libmonitoramento->buscarEvento();

        $this->templateAddItem('principal', 'dadosSemEventos', $rs);
    }


    /**
     * Inicio resolucao
     */

    public function resolucao($argId)
    {
        $this->carregarSelectCausa();

        if ($this->input->post())
            $this->processarResolucao();

        $this->WriteTemplates('resolucao');
    }

    private function carregarSelectCausa()
    {
        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelcausa');
        $this->libcrud->campos = 'id, descricao';
        $this->libcrud->order = 'descricao ASC';
        $rs = $this->libcrud->buscar();

        $causas = array('' => $this->lang->line('selecione'));

        foreach ($rs as $causa)
            $causas[$causa['id']] = $causa['descricao'];

        $this->templateAddItem('principal', 'optionsCausa', $causas);
    }

    private function processarResolucao()
    {
        $dadosPost = array();
        $dadosPost['cliente_ip'] = $this->input->post('cliente_ip');
        $dadosPost['causa_id'] = $this->input->post('causa');

        $this->load->library('AppBase/LibCrud');
        $this->libcrud->setModel('modelcliente');

        if ($this->libcrud->inserir($dadosPost)) {
            $this->session->set_flashdata('retorno', array('sucesso' => true, 'mensagem' => $this->lang->line('sucesso_cadastro')));
            redirect(base_url().'Admin/Monitoramento/index', 'refresh');
        }
    }

}
