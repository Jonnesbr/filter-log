<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $this->lang->line('configuracao_permissoes_acesso');?></h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12 form-group">
          <div class='alert alert-warning'><?php echo $this->lang->line('perfil_admin_configuracoes_acesso'); ?></div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7 text-right">
        <input name="btnVoltar" class="btn-redirect btn btn-default" type="button" data-url="<?php echo base_url(); ?>Admin/Perfil" value="<?php echo $this->lang->line('voltar'); ?>"/>
      </div>
  </div>
</div>
