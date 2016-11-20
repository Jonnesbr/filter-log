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

        /**
         * Carrega para o Dashboard dados para os gŕaficos.
         */
        $this->getDashboardData();

        $this->WriteTemplates('index');
    }

    /**
     * Concentrar todos os métodos de busca de informações.
     */
    public function getDashboardData()
    {
        /**
         * Carrega CAUSAS x CLIENTES
         */
        $this->templateAddItem('principal', 'dadosCausaCliente', $this->carregarCausaCliente());

        /**
         * Carrega CAUSAS x QUANTIDADE
         */
        $this->templateAddItem('principal', 'dadosQtdeCausa', $this->carregarQtdeCausa());
    }

    private function carregarCausaCliente()
    {
        $this->load->library('LibMonitoramento');
        $this->libmonitoramento->setModel('modelmonitoramento');
        $this->libmonitoramento->campos = 'cliente.nome, cliente.ip, causa.descricao';
        $this->libmonitoramento->groupBy = 'cliente.ip, causa.descricao';
        $this->libmonitoramento->where = array('cliente.status' => STATUS_ATIVO);
        $dados = $this->libmonitoramento->buscarCausaCliente();

        if (!$dados)
            return false;

        return $dados;
    }

    private function carregarQtdeCausa()
    {
        $this->load->library('LibMonitoramento');
        $this->libmonitoramento->setModel('modelmonitoramento');
        $this->libmonitoramento->campos = 'causa.id as resolucao_id, causa.descricao, count(resolucao_cliente.causa_id) as qtde';
        $this->libmonitoramento->groupBy = 'causa.descricao';
        $this->libmonitoramento->where = array('cliente.status' => STATUS_ATIVO);
        $dados = $this->libmonitoramento->buscarCausaCliente();

        if (!$dados)
            return false;

        return $dados;
    }

}
