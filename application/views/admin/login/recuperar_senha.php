<div class="login-content well">
    <div class="text-center">
        <img src="<?php echo base_url();?>assets/dist/img/logo.png" alt="HEM">
    </div>
    <?php
    if (isset($mensagem) && $mensagem) :
        $class = ($sucesso) ? 'alert alert-success' : 'alert alert-danger';
        echo "<div id='retorno_login_mensagem' class='{$class}'>{$mensagem}</div>";
    endif;

    if ($sucesso) :
        ?>
        <div id="retorno_ativacao"></div>
        <h3><?php echo $this->lang->line('cadastre_senha_nova');?></h3>
        <form class="form_admin_recuperar_senha" method="post" action="">
            <input type="hidden" name="hash" id="hash" value="<?php echo $hash;?>" />
            <input type="hidden" name="email" id="email" value="<?php echo $email;?>" />
            <div id="div_ativacao">
                <div class="input-group margin-bottom-1">
                    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                    <input type="password" class="form-control" name="senha" id="senha" placeholder="<?php echo $this->lang->line('nova_senha');?>" value="" />
                </div>
                <div class="input-group margin-bottom-1">
                    <span class="input-group-addon"><i class="fa fa-repeat fa-fw"></i></span>
                    <input type="password" class="form-control" name="senha_confirmacao" id="senha_confirmacao" placeholder="<?php echo $this->lang->line('repetir_senha')?>" value="" />
                </div>
                <p class="help-block"><?php echo $this->lang->line('help_senha'); ?></p>
                <div class="form-group">
                    <input class="btn btn-primary btn-lg btn-block submit-nova-senha" type="button" data-url="<?php echo base_url() . 'Admin/Login/recadastrarSenhaRest'; ?>" name="submitNovaSenhaAdmin" value="<?php echo $this->lang->line('salvar');?>" />
                </div>
            </div>
        </form>
        <?php
    endif;
    ?>
</div>