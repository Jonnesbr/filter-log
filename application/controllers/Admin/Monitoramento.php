<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceControllerAdmin.php';

class Monitoramento extends InterfaceControllerAdmin
{

    public function __construct()
    {
        parent::__construct();
        $this->viewsDirectory = 'admin/monitoramento';
        $this->addBreadCrumbs('Monitoramento', true);
    }

    public function index()
    {
        $this->carregarEventos();
        $this->carregarClientesSemEventos();

        //Capturar eventos no banco da Life
        $this->carregarSelectCliente();

        if ($this->input->post())
            $this->processarMonitoramentoPost();

        if ($this->session->flashdata('retorno'))
            $this->templateAddItem('principal', 'retorno', $this->session->flashdata('retorno'));

        $this->WriteTemplates('index');
    }

    /**
     * Inicio do processo de captura de eventos no banco Life
     */
    public function monitorar()
    {
        $this->carregarSelectCliente();

        if ($this->input->post())
            $this->processarMonitoramentoPost();

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
        $this->libcrud->where = array('status' => STATUS_ATIVO);
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
        $this->libmonitoramento->where = array('monitoramento.resolucao' => STATUS_INATIVO, 'cliente.status' => STATUS_ATIVO);
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
        $this->libmonitoramento->where = array('monitoramento.resolucao' => STATUS_ATIVO, 'cliente.status' => STATUS_ATIVO);
        $this->libmonitoramento->order = 'cliente_ip ASC';
        $rs = $this->libmonitoramento->buscarEvento();

        $this->templateAddItem('principal', 'dadosSemEventos', $rs);
    }


    /**
     * Inicio resolucao
     */

    public function resolucao($argId = null)
    {
        $this->carregarSelectCausa();

        if ($this->input->post())
            $this->processarResolucao();

        $this->templateAddItem('principal', 'dadosCliente', $argId);
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
        $this->libcrud->setModel('modelresolucaocliente');

        if ($this->libcrud->inserir($dadosPost)) {
            $this->libcrud->setModel('modelmonitoramento');
            $this->libcrud->where = array('cliente_ip' => $dadosPost['cliente_ip'], 'resolucao' => STATUS_INATIVO);
            if ($this->libcrud->alterar(array('resolucao' => STATUS_ATIVO))) {
                $this->session->set_flashdata('retorno', array('sucesso' => true, 'mensagem' => 'Resolução Informada com Sucesso'));
                redirect(base_url() . 'Admin/Monitoramento/index', 'refresh');
            }
        }
    }

    /**
     * Listagem de eventos não resolvidos por cliente
     * @param null $argId
     */
    public function eventos($argId = null)
    {
        if ($argId == null)
            redirect(base_url().'Admin/Monitoramento/index', 'refresh');
        $this->carregarEventosCliente($argId);
        $this->WriteTemplates('eventos');
    }

    public function carregarEventosCliente($argId)
    {
        $this->load->library('LibMonitoramento');
        $this->libmonitoramento->setModel('modelmonitoramento');
        $this->libmonitoramento->campos = 'cliente.nome, monitoramento.cliente_ip, monitoramento.syslog_id, monitoramento.data_inicio, monitoramento.data_fim, monitoramento.duracao, monitoramento.resolucao';
        $this->libmonitoramento->where = array('monitoramento.cliente_ip' => $argId, 'cliente.status' => STATUS_ATIVO, 'monitoramento.resolucao' => STATUS_INATIVO);
        $this->libmonitoramento->order = 'cliente_ip ASC';
        $data = $this->libmonitoramento->buscarEvento();

        if (isset($data[0]['cliente_ip'])) {
            $this->load->library('AppBase/LibInfraFormatador');
            $this->libinfraformatador->campos_data = array('data_inicio', 'data_fim');
            $this->libinfraformatador->formatarPadraoInterface($data, 'd/m/Y', 'H:i:s');
        }

        $this->templateAddItem('principal', 'dadosEventosCliente', $data);
    }

}
