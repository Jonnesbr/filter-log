<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class InterfaceController extends CI_Controller{

    protected $titulo;
    protected $cabecalho;
    protected $principal;
    protected $rodape;

    protected $breadcrumbs = '';

    protected $viewTitulo = 'titulo';
    protected $viewCabecalho = 'cabecalho';
    protected $viewRodape = 'rodape';

    private $paginacaoView;
    private $paginacaoMetodoAjax;
    private $paginacaoMetodoBusca = 'buscaPaginada';
    private $paginacaoMetodoCount = 'buscaPaginada';
    private $paginacaoClasseBusca = '';
    private $paginacaoClasseMetodoBusca = 'buscaPaginada';
    private $paginacaoSemWhere = 0;

    protected $ajaxdata;
    protected $ar_campos;
    protected $awheres;
    protected $aorder;
    protected $afields;
    protected $alimit;
    protected $agroupby;
    protected $ahaving;

    protected $viewsDirectory = '';

    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(!true);
    }

    protected function WriteTemplates($argPrincipal) {
        $argPrincipal = ($this->viewsDirectory) ? $this->viewsDirectory . '/' . $argPrincipal : $argPrincipal;
        $this->templateAddItem('principal', 'breadcrumbs', $this->prepareBreadcrumbs());

        $this->template->write_view('titulo', $this->viewTitulo, $this->titulo);
        $this->template->write_view('cabecalho', $this->viewCabecalho,$this->cabecalho);
        $this->template->write_view('principal', $argPrincipal,$this->principal);
        $this->template->write_view('rodape', $this->viewRodape,$this->rodape);
        $this->template->render();
    }

    protected function WriteTemplatesLogin($argPrincipal){
        $argPrincipal = ($this->viewsDirectory) ? $this->viewsDirectory . '/' . $argPrincipal : $argPrincipal;

        $this->template->set_template('template_login');
        $this->template->write_view('titulo', 'titulo', $this->titulo);
        $this->template->write_view('principal', $argPrincipal,$this->principal);
        $this->template->render();
    }

    protected function WriteTemplatesJson($argData) {
//        $this->load->helper('charset');
//        $retorno = array_to_utf8($argData);
        echo json_encode($argData); exit;
    }

    protected function templateAddItem($template, $indice, $valor) {
        if (!array_key_exists($template, get_object_vars($this)))
            return ;
        $this->{$template}[$indice] = $valor;
    }

    protected function getPaginacaoView() {
        return $this->paginacaoView;
    }

    protected function setPaginacaoView($argFile) {
        $this->paginacaoView = $argFile;
    }

    protected function setPaginacaoMetodoAjax($argPath) {
        $this->paginacaoMetodoAjax = $argPath;
    }

    protected function getPaginacaoMetodoAjax() {
        return $this->paginacaoMetodoAjax;
    }

    protected function setPaginacaoMetodoBusca($argMetodo) {
        $this->paginacaoMetodoBusca = $argMetodo;
    }

    protected function getPaginacaoMetodoBusca() {
        return $this->paginacaoMetodoBusca;
    }

    protected function setPaginacaoMetodoCount($argMetodoCount) {
        $this->paginacaoMetodoCount = $argMetodoCount;
    }

    protected function getPaginacaoMetodoCount() {
        return $this->paginacaoMetodoCount;
    }

    protected function setPaginacaoClasseBusca($argClasse) {
        $this->paginacaoClasseBusca = $argClasse;
    }

    protected function getPaginacaoClasseBusca() {
        return $this->paginacaoClasseBusca;
    }

    protected function setPaginacaoClasseMetodoBusca($argMetodo) {
        $this->paginacaoClasseMetodoBusca = $argMetodo;
    }

    protected function getPaginacaoClasseMetodoBusca() {
        return $this->paginacaoClasseMetodoBusca;
    }

    protected function ativaPaginacaoSemWhere() {
        $this->paginacaoSemWhere = 1;
    }

    protected function getCountField()
    {
        return 'count(1)';
    }

    public function AjaxPage($argOffset = 0) {

        $this->load->library('Jquery_pagination');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('html');

        $config['base_url'] = site_url(). $this->paginacaoMetodoAjax;
        $config['div'] = '#contentPaginacao';

        //	$this->ar_campos = $this->GetFieldLangAssoc();
        $ar_params = $this->session->userdata(get_class($this));
        if (isset($ar_params['wheres']))
            $this->awheres = $ar_params['wheres'];
        if( $this->awheres || $this->paginacaoSemWhere) {
            if (isset($ar_params['order']))
                $this->aorder = $ar_params['order'];

            $this->alimit  = isset($ar_params['limit'])?$ar_params['limit']:20;
            $this->afields = isset($ar_params['fields'])?$ar_params['fields']:'';

            if (isset($ar_params['groupby'])) $this->agroupby = $ar_params['groupby'];
            if (isset($ar_params['having'])) $this->ahaving	= $ar_params['having'];
            $total = $this->{$this->paginacaoMetodoCount}($this->awheres, $this->getCountField() . ' as total');
            $config['total_rows'] = $total[0]['total'];
            $config['uri_segment'] = 4;
            $config['uri_segment_pagination'] = 3;

            $config['per_page'] = $this->alimit;
            $this->setAjaxPageCss($config);

            $this->jquery_pagination->initialize($config);
            $this->ajaxdata['links'] = $this->jquery_pagination->create_links();
            $this->ajaxdata['result']  = $this->{$this->paginacaoMetodoBusca}($this->awheres,$this->afields,  $this->aorder, $this->alimit , $argOffset, $this->agroupby, $this->ahaving);
            $this->ajaxdata['total_rows'] = $total[0]['total'];
            $this->ajaxdata['limit'] = $this->alimit;
            $this->ajaxdata['fields']  = $this->afields;
        }
        $this->load->view($this->paginacaoView,$this->ajaxdata);
    }

    protected function setAjaxPageCss(&$config){
        $config['cur_tag_open'] =  '<li class="ls-active"><a class="color-custom-bg-blue" href="#">';
        $config['cur_tag_close'] =  '</a></li>';
        $config['num_tag_open'] =  '<li>';
        $config['num_tag_close'] =  '</li>';
        $config['next_tag_open'] =  '<li>';
        $config['next_tag_close'] =  '</li>';
        $config['prev_tag_open'] =  '<li>';
        $config['prev_tag_close'] =  '</li>';
        // $config['next_link'] = '&gt;';
        // $config['prev_link'] = '&lt;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] =  '&laquo;';
        $config['last_link'] =  '&raquo;';
    }

    public function buscaPaginada($argWhere = '', $argCampos = '', $argOrder = '', $argLimit= '', $argOffset=0, $argGroupBy = null, $argHaving = null){
        if (!empty($this->paginacaoClasseBusca)){
            $this->load->library($this->paginacaoClasseBusca);
            return $this->{$this->paginacaoClasseBusca}->{$this->paginacaoClasseMetodoBusca}($argWhere, $argCampos, $argOrder, $argLimit , $argOffset, $argGroupBy, $argHaving);
        }
    }

    protected function initAjaxPage()
    {
        ob_start();
        $this->AjaxPage(0);
        ob_end_clean();
    }

    protected function addBreadCrumbs($argBreadCrumb, $argDefault = false, $argLink = null)
    {
        if (!$argLink) {
            $argLink = BASE_URL . $this->router->directory . $this->router->class;
            if (!$argDefault)
                $argLink .= '/' . $this->router->method;
        }
        $this->breadcrumbs[] = array('link' => $argLink, 'title' => $argBreadCrumb);
    }

    private function prepareBreadcrumbs()
    {
        $breadcrumbs = '';
        if ($this->breadcrumbs) {
            for ($i = 0; $i < count($this->breadcrumbs); $i++) {
                if ($i == count($this->breadcrumbs) - 1) {
                    $breadcrumbs .= "<li class='active'>{$this->breadcrumbs[$i]['title']}</li>";
                } else {
                    $breadcrumbs .= "<li><a href='{$this->breadcrumbs[$i]['link']}''>{$this->breadcrumbs[$i]['title']}</a></li>";
                }
            }
        }
        return $breadcrumbs;
    }

}