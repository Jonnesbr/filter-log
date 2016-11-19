<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $this->lang->line('cadastro_usuario');?></h3>
    </div>
    <div class="panel-body">
        <?php
        if (isset($retorno['mensagem']) && $retorno['mensagem']) {
            $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
            echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
        }
        $id = (isset($dadosUsuario['id'])) ? $dadosUsuario['id'] : '';
        ?>
        <?php echo form_open(base_url() . 'Admin/Usuario/cadastro/' . $id); ?>
        <div class="row">
            <div class="col-md-2 form-group">
                <label for="perfil"><?php echo $this->lang->line('perfil'); ?>*:</label>
                <?php
                $selected = set_value('perfil', (isset($dadosUsuario['id_perfil']) ? $dadosUsuario['id_perfil'] : ''));
                echo form_dropdown('perfil', $optionsPerfil, $selected, "id='perfil' class='form-control'");
                ?>
            </div>

            <div class="col-md-2 form-group">
                <label for="status"><?php echo $this->lang->line('status');?>:</label>
                <?php
                $selected = set_value('status', (isset($dadosUsuario['status']) ? $dadosUsuario['status'] : STATUS_ATIVO));
                echo form_dropdown('status', $optionsStatus, $selected, "id='status' class='form-control'");
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                <?php $nome = set_value('nome', (isset($dadosUsuario['nome']) ? $dadosUsuario['nome'] : '')); ?>
                <label for="nome"><?php echo $this->lang->line('nome_completo'); ?>*:</label>
                <input type="text" name="nome" class="form-control" id="nome" value="<?php echo $nome; ?>" maxlength="50" />
            </div>
            <div class="col-md-2 form-group">
                <?php $cpf = set_value('cpf', (isset($dadosUsuario['cpf']) ? $dadosUsuario['cpf'] : '')); ?>
                <label for="cpf"><?php echo $this->lang->line('cpf');?>:</label>
                <input type="text" class="form-control mask-cpf" name="cpf" id="cpf" value="<?php echo $cpf; ?>" />
            </div>
            <div class="col-md-2 form-group">
                <?php $data_nascimento = set_value('data_nascimento', (isset($dadosUsuario['data_nascimento']) ? $dadosUsuario['data_nascimento'] : '')); ?>
                <label for="data_nascimento"><?php echo $this->lang->line('data_nascimento');?>:</label>
                <input type="text" class="mask-date form-control" name="data_nascimento" id="data_nascimento" value="<?php echo $data_nascimento; ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                <?php $email = set_value('email', (isset($dadosUsuario['email']) ? $dadosUsuario['email'] : '')); ?>
                <label for="email"><?php echo $this->lang->line('email');?>*:</label>
                <input type="text" class="form-control" name="email" id="email" value="<?php echo $email; ?>" />
            </div>
            <div class="col-md-2 form-group">
                <?php $telefone = set_value('telefone', (isset($dadosUsuario['telefone']) ? $dadosUsuario['telefone'] : '')); ?>
                <label for="telefone"><?php echo $this->lang->line('telefone');?>:</label>
                <input type="text" class="mask-fone form-control" name="telefone" id="telefone" value="<?php echo $telefone; ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 text-right">
                <input name="submitCadastro" class="btn btn-success" id="submitCadastro" type="submit" value="<?php echo $this->lang->line('salvar'); ?>"/>
                <input name="btnVoltar" class="btn-redirect btn btn-default" type="button" data-url="<?php echo base_url(); ?>Admin/Usuario" value="<?php echo $this->lang->line('voltar'); ?>"/>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
