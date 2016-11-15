<div class="login-content well">
    <div class="text-center">
        <img src="<?php echo base_url();?>assets/dist/img/logo.png" alt="HEM">
    </div>
    <?php
    if (isset($retorno['mensagem']) && $retorno['mensagem']) :
        $class = $retorno['sucesso']? 'alert alert-success' : 'alert alert-danger';
        echo "<div id='retorno_login_mensagem' class='{$class}'>{$retorno['mensagem']}</div>";
    endif;
    ?>
    <div id="retorno_login"></div>
    <form id="form_login" method="post" action="">
        <div class="input-group margin-bottom-1">
            <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
            <input type="text" class="form-control" name="email" id="email" placeholder="<?php echo $this->lang->line('email'); ?>" value="<?php echo set_value('email'); ?>" />
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
            <input type="password" class="form-control" name="senha" id="senha" placeholder="<?php echo $this->lang->line('senha'); ?>" value="" />
        </div>
        <div class="form-group actions">
            <button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo $this->lang->line('entrar')?></button>
<!--            <div class="text-right">-->
<!--            <a class="link-block link-esqueci-senha" href="--><?php //echo base_url();?><!--Admin/Login/solicitarRecuperacaoSenhaRest">--><?php //echo $this->lang->line('esqueci_minha_senha')?><!--</a>-->
<!--            </div>-->
        </div>
    </form>
</div>