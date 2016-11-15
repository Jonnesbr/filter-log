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
         <div class="col-md-2 form-group">
            <?php $celular = set_value('celular', (isset($dadosUsuario['celular']) ? $dadosUsuario['celular'] : '')); ?>
            <label for="celular"><?php echo $this->lang->line('celular');?>:</label>
            <input type="text" class="mask-celular form-control" name="celular" id="celular" value="<?php echo $celular; ?>" />
         </div>
    </div>
    <div class="row">
        <div class="col-md-3 form-group">
            <?php $endereco = set_value('endereco', (isset($dadosUsuario['endereco']) ? $dadosUsuario['endereco'] : '')); ?>
            <label for="endereco"><?php echo $this->lang->line('endereco');?>:</label>
            <input type="text" class="form-control" name="endereco" id="endereco" value="<?php echo $endereco; ?>" />
        </div>
        <div class="col-md-2 form-group">
            <?php $numero = set_value('numero', (isset($dadosUsuario['numero']) ? $dadosUsuario['numero'] : '')); ?>
            <label for="numero"><?php echo $this->lang->line('numero');?>:</label>
            <input type="text" class="form-control" name="numero" id="numero" value="<?php echo $numero; ?>" maxlength="5" />
        </div>
         <div class="col-md-2 form-group">
            <?php $complemento = set_value('complemento', (isset($dadosUsuario['complemento']) ? $dadosUsuario['complemento'] : '')); ?>
            <label for="complemento"><?php echo $this->lang->line('complemento');?>:</label>
            <input type="text" class="form-control" name="complemento" id="complemento" value="<?php echo $complemento; ?>" maxlength="30" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 form-group">
            <?php $bairro = set_value('bairro', (isset($dadosUsuario['bairro']) ? $dadosUsuario['bairro'] : '')); ?>
            <label for="bairro"><?php echo $this->lang->line('bairro');?>:</label>
            <input type="text" class="form-control" name="bairro" id="bairro" value="<?php echo $bairro; ?>" maxlength="50" />
        </div>
          <div class="col-md-2 form-group">
            <label for="estado"><?php echo $this->lang->line('estado');?>:</label>
            <?php
            $selected = set_value('estado', (isset($dadosUsuario['estado']) ? $dadosUsuario['estado'] : ''));
            echo form_dropdown('estado', $optionsEstado, $selected, "id='estado' class='form-control'");
            ?>
        </div>
          <div class="col-md-2 form-group">
            <label for="cidade"><?php echo $this->lang->line('cidade');?>:</label>
            <?php
            $selected = set_value('cidade', (isset($dadosUsuario['id_cidade']) ? $dadosUsuario['id_cidade'] : ''));
            echo form_dropdown('cidade', $optionsCidade, $selected, "id='cidade' class='form-control'");
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 form-group">
            <?php $cep = set_value('cep', (isset($dadosUsuario['cep']) ? $dadosUsuario['cep'] : '')); ?>
            <label for="cep"><?php echo $this->lang->line('cep');?>:</label>
            <input type="text" class="mask-cep form-control" name="cep" id="cep" value="<?php echo $cep; ?>" />
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
        <div class="col-md-7 text-right">
            <input name="submitCadastro" class="btn btn-success" id="submitCadastro" type="submit" value="<?php echo $this->lang->line('salvar'); ?>"/>
            <input name="btnVoltar" class="btn-redirect btn btn-default" type="button" data-url="<?php echo base_url(); ?>Admin/Usuario" value="<?php echo $this->lang->line('voltar'); ?>"/>
        </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
