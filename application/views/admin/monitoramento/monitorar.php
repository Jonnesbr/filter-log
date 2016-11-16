<style type="text/css">
    .glyphicon-refresh-animate {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
}

@-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
}

@keyframes spin {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
}
</style>

<script type="text/javascript">
    $( "#submitCadastro" ).click(function() {
      $(document).find(#carregando).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate></span> Loading...");
    });
</script>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Atualizar Eventos Manualmente</h3>
    </div>
    <div class="panel-body">
        <?php
        if (isset($retorno['mensagem']) && $retorno['mensagem']) {
            $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
            echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
        }
        $id = (isset($dadosUsuario['id'])) ? $dadosUsuario['id'] : '';
        ?>
        <?php echo form_open(base_url() . 'Admin/Monitoramento/monitorar/' . $id); ?>
        <div class="row">
            <div class="col-md-3 form-group">
                <label for="cliente">Cliente*:</label>
                <?php
                $selected = set_value('cliente', '');
                echo form_dropdown('cliente', $optionsCliente, $selected, "id='cliente' class='form-control'");
                ?>
            </div>

<!--            <div class="col-md-2 form-group">-->
<!--                <label for="data_inicio">--><?php //echo $this->lang->line('data_inicio');?><!--:</label>-->
<!--                <input type="text" class="data-inicial form-control" name="data_inicio" id="data_inicio" value="--><?php //echo set_value('data_inicio'); ?><!--" />-->
<!--            </div>-->
<!--            <div class="col-md-2 form-group">-->
<!--                <label for="data_fim">--><?php //echo $this->lang->line('data_fim');?><!--:</label>-->
<!--                <input type="text" class="data-final form-control" name="data_fim" id="data_fim" value="--><?php //echo set_value('data_fim'); ?><!--" />-->
<!--            </div>-->

        </div>

        <div class="row">
            <div class="col-md-7">
                <input name="submitCadastro" class="btn btn-primary" id="submitCadastro" type="submit" value="Atualizar"/>
                <input name="btnVoltar" class="btn-redirect btn btn-default" type="button" data-url="<?php echo base_url(); ?>Admin/Monitoramento" value="<?php echo $this->lang->line('voltar'); ?>"/>
            </div>
        </div>
        <div id="carregando"></div>
        <?php echo form_close(); ?>
    </div>
</div>
