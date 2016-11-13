<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/AppBase/LibCrud.php';

class LibPerfil extends LibCrud
{

    public function __construct()
    {
        parent::__construct();
    }

    public function cadastrarPerfilRegras($argIdPerfil, $argRegras)
    {
        $this->setModel('modelperfilregrapermissao');
        $this->campos = 'id, perfil_regra_id';
        $this->where  = array('perfil_id' => $argIdPerfil);
        $permissoes   = $this->buscar();

        if (count($argRegras) == 0) {
            if (count($permissoes) == 0)
                return true;

            return $this->removerTodasPermissoes($argIdPerfil);
        }

        if (!$argRegras && count($permissoes) >= 1) {
            $this->removerTodasPermissoes($argIdPerfil);
            return true;
        }

        $this->removerPermissoesNaoPostadas($permissoes, $argRegras);

        if (!$insertArray = $this->prepararArrayInsert($argIdPerfil, $argRegras))
            return true;

        return $this->inserirBatch($insertArray);
    }

    private function removerTodasPermissoes($argIdPerfil)
    {
        $this->where = array('perfil_id' => $argIdPerfil);

        return $this->deletar();
    }

    private function removerPermissoesNaoPostadas($argPermissoes, &$argRegras)
    {
        foreach ($argPermissoes as $permissao) {
            if (!in_array($permissao['perfil_regra_id'], $argRegras)) {
                $this->where = array('id' => $permissao['id']);
                $this->deletar();
            } else
                unset($argRegras[array_search($permissao['perfil_regra_id'], $argRegras)]);
        }
    }

    private function prepararArrayInsert($argIdPerfil, $argRegras)
    {
        $insertArray = array();
        foreach ($argRegras as $indice => $perfil_regra_id) {
            $insertArray[] = array(
                'perfil_id'       => $argIdPerfil,
                'perfil_regra_id' => $perfil_regra_id
            );
        }

        return $insertArray;
    }

}