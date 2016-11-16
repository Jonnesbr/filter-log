<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $this->lang->line('cadastro_perfil');?></h3>
    </div>
    <div class="panel-body">
        <?php
        if (isset($retorno['mensagem']) && $retorno['mensagem']) :
            $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
            echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
        endif;

        $id = (isset($dadosPerfil['id'])) ? $dadosPerfil['id'] : '';
        ?>
        <?php echo form_open(base_url() . 'Admin/Perfil/cadastro/' . $id); ?>
        <div class="row">
            <div class="col-md-3 form-group">
                <?php $nome = set_value('nome', (isset($dadosPerfil['nome']) ? $dadosPerfil['nome'] : '')); ?>
                <label for="nome"><?php echo $this->lang->line('nome'); ?>*:</label>
                <input type="text" name="nome" class="form-control" id="nome" value="<?php echo $nome; ?>" maxlength="20" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 text-left">
                <input name="submitCadastro" class="btn btn-primary" id="submitCadastro" type="submit" value="<?php echo $this->lang->line('salvar'); ?>"/>
                <input name="btnVoltar" class="btn-redirect btn btn-default" type="button" data-url="<?php echo base_url(); ?>Admin/Perfil" value="<?php echo $this->lang->line('voltar'); ?>"/>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
