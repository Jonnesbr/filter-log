<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Resolução de Eventos</h3>
    </div>
    <div class="panel-body">
        <?php
        if (isset($retorno['mensagem']) && $retorno['mensagem']) :
            $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
            echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
        endif;

        $id = (isset($dadosCliente)) ? $dadosCliente : '';
        ?>
        <?php echo form_open(base_url() . 'Admin/Monitoramento/resolucao/' . $id);
        echo form_hidden('cliente_ip', $id);
        ?>
        <div class="row">
            <div class="col-md-3 form-group">
                <label for="causa">Causa*:</label>
                <?php
                $selected = set_value('causa', '');
                echo form_dropdown('causa', $optionsCausa, $selected, "id='causa' class='form-control'");
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 text-left">
                <input name="submitCadastro" class="btn btn-primary" id="submitCadastro" type="submit" value="<?php echo $this->lang->line('salvar'); ?>"/>
                <input name="btnVoltar" class="btn-redirect btn btn-default" type="button" data-url="<?php echo base_url(); ?>Admin/Monitoramento" value="<?php echo $this->lang->line('voltar'); ?>"/>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
