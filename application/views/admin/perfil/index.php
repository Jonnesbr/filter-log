<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left title-custom-button"><?php echo $this->lang->line('perfis');?></h3>
        <a href="<?php echo base_url().'Admin/Perfil/cadastro';?>" class="btn btn-primary pull-right"><?php echo $this->lang->line('cadastrar');?></a>
    </div>
    <div class="panel-body">
        <?php
        if (isset($retorno)) :
            $class = ($retorno['sucesso']) ? 'alert alert-success' : 'alert alert-danger';
            echo "<div class='{$class} alert-dismissable' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><p>{$retorno['mensagem']}</p></div>";
        endif;
        ?>
        <form id="form_perfil_busca" name="form_perfil_busca" method="post" action="<?php echo base_url().'Admin/Perfil/index';?>" >
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="nome"><?php echo $this->lang->line('nome');?>:</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="<?php echo set_value('nome');?>";>
                </div>
                <div class="col-md-2 form-group">
                    <button id="buscar" name="buscar" class="btn btn-primary button-form-horizontal"><?php echo $this->lang->line('buscar')?></button>
                </div>
            </div>
        </form>
        <div id="contentPaginacao">
            <?php
            if (isset($result) && is_array($result) && count($result)>0 ) {
                require 'lista.php';
            } else { ?>
                <div class="alert alert-warning"><?php echo $this->lang->line('nenhum_registo_encontrado');?></div>
            <?php } ?>
        </div>
    </div>
</div>

