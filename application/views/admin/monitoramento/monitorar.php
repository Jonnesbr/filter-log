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
        </div>

        <div class="row">
            <div class="col-md-7">
                <input name="submitCadastro" class="btn btn-primary" id="submitCadastro" type="submit" value="Atualizar"/>
                <input name="btnVoltar" class="btn-redirect btn btn-default" type="button" data-url="<?php echo base_url(); ?>Admin/Monitoramento" value="<?php echo $this->lang->line('voltar'); ?>"/>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
