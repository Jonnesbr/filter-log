<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $this->lang->line('alterar_senha');?></h3>
    </div>
    <div class="panel-body">
        <?php
        if (isset($retorno['mensagem']) && $retorno['mensagem']) :
            $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
            echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
        endif;
        ?>
        <?php echo form_open(base_url() . 'Admin/Configuracoes'); ?>
        <div class="row">
            <div class="col-md-3 form-group">
                <label for="senha_atual"><?php echo $this->lang->line('senha_atual'); ?>*:</label>
                <input type="password" name="senha_atual" class="form-control" id="senha_atual" value="" maxlength="20" />
                <label for="nova_senha"><?php echo $this->lang->line('nova_senha'); ?>*:</label>
                <input type="password" name="nova_senha" class="form-control" id="nova_senha" value="" maxlength="20" />
                <label for="repetir_senha"><?php echo $this->lang->line('repetir_senha'); ?>*:</label>
                <input type="password" name="repetir_senha" class="form-control" id="repetir_senha" value="" maxlength="20" />
                <p class="help-block"><?php echo $this->lang->line('help_senha'); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 text-left">
                <input name="submitCadastro" class="btn btn-primary" id="submitCadastro" type="submit" value="<?php echo $this->lang->line('salvar'); ?>"/>
                <input name="btnVoltar" class="btn-redirect btn btn-default" type="button" data-url="<?php echo base_url(); ?>Admin/Dashboard" value="<?php echo $this->lang->line('voltar'); ?>"/>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
