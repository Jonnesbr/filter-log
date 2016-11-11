<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/InterfaceController.php';
require_once APPPATH . 'hooks/ControleAcesso.php';

abstract class InterfaceControllerAdmin extends InterfaceController {

    protected $adminLogadoId = 0;

    public function __construct()
    {
        parent::__construct();
        $this->verificaAdminLogado();
        $this->setaLoginAdmin();
    }

    protected function verificaAdminLogado()
    {
        if (!$this->session->userdata('id_admin'))
            redirect(base_url().'Admin/Login');
    }

    private function setaLoginAdmin()
    {
        $this->adminLogadoId = $this->session->userdata('id_admin');

        $this->templateAddItem('cabecalho','adminLogadoId', $this->adminLogadoId);
        $this->templateAddItem('cabecalho','adminLogadoNome', $this->session->userdata('admin_nome'));

        $menuLogadoAdmin = $this->montarMenu();
        $this->templateAddItem('cabecalho','menuLogadoAdmin', $menuLogadoAdmin);
    }

    private function montarMenu()
    {
        $itensMenu = $this->recuperarItensMenu();
        $menu = null;
        $this->validarPermissoesMenu($menu, $itensMenu);
        return $menu;
    }

    private function validarPermissoesMenu(&$argMenu, &$argItensMenu, $argChave=null)
    {
        foreach ($argItensMenu as $descricao => $item) {
            if (is_array($item)) {
                $this->validarPermissoesMenu($argMenu, $item, $descricao);
            } else {
                $uri = explode('/', $item);
                $controleAcesso = new ControleAcesso();
                if ($controleAcesso->validarPerfil(false, 'Admin', $uri[0], $uri[1])) {
                    if ($argChave)
                        $argMenu[$argChave][$descricao] = $item;
                    else
                        $argMenu[$descricao] = $item;
                }
            }
        }
    }

    private function recuperarItensMenu()
    {
        return array(
            'Dashboard' => 'Dashboard/index',
            'Perfis' => array(
                'Cadastro' => 'Perfil/cadastro',
                'Lista'    => 'Perfil/index'
            ),
            'Usuários' => array(
                'Cadastro' => 'Usuario/cadastro',
                'Lista'    => 'Usuario/index'
            ),
            'Clientes' => array(
                'Cadastro' => 'Cliente/cadastro',
                'Lista'    => 'Cliente/index'
            ),
            'Configurações' => 'Configuracoes/index'
        );
    }

}
