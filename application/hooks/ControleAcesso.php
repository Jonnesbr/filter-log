<?php

class ControleAcesso {

   CONST PERFIL_SESSION_ID = 'id_perfil';
   CONST PERFIL_SESSION_ID_USER = 'id_admin'; 

   private $ci;
   private $diretoriosPublicos = array() ; 
   private $classesPublicas = array('admin/login','admin/acessonegado') ; 
   
   public function ControleAcesso(){
      $this->ci = &get_instance();
   }
   
   private function isValidPerfilMetodo($perfil,$regra) {
      $this->ci->db->select('*');
      $this->ci->db->from('perfil_regra_permissao');
      $this->ci->db->join('perfil_regra', 'perfil_regra.id = perfil_regra_permissao.perfil_regra_id');
      $this->ci->db->where('perfil_id',$perfil);
      $this->ci->db->where('regra',$regra);
      return count($this->ci->db->get()->result_array());
   }
   
   public function validarPerfil($redirect = true, $argDirectory = null, $argController = null, $argMetodo = null)
   {
       if ($this->ci->session->userdata(self::PERFIL_SESSION_ID) == PERFIL_ADMINISTRADOR)
           return true;

      $this->ci->load->helper('url');
      // Converte a URI para minusculas para comparação
      $directory  = ($argDirectory) ? strtolower($argDirectory) : strtolower($this->ci->router->fetch_directory());
      $controller = ($argController) ? strtolower($argController) : strtolower($this->ci->router->fetch_class());
      $metodo     = ($argMetodo) ? strtolower($argMetodo) : strtolower($this->ci->router->fetch_method());

      if (!$metodo) $metodo = 'index';

      if (in_array($directory,$this->diretoriosPublicos))
          return true;
      if (in_array($directory .$controller,$this->classesPublicas))
          return true;
      if ($this->ci->session->userdata(self::PERFIL_SESSION_ID_USER) && $this->isValidPerfilMetodo($this->ci->session->userdata(self::PERFIL_SESSION_ID), str_replace("/", "", $directory) . '_' . $controller . '_' .$metodo ))
          return true;
      if ($redirect)
         $this->redirectLogin();
      return false;
   }

   public function redirectLogin()
   {
      $authdata['redirect'] = true;
      $authdata['mensagem'] = "Acesso restrito.";
      $this->ci->session->set_flashdata($authdata);
      redirect(base_url().'Admin/AcessoNegado'); 
      exit;
   }

}