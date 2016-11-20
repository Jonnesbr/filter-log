<?php header("Content-Type: text/html; charset=UTF-8", true); ?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left title-custom-button">Eventos</h3>
    </div>
    <div class="panel-body">
        <div id="contentPaginacao">
            <table id="table_perfil" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="">Cliente</th>
                    <th class="text-center">Endereço IP</th>
                    <th class="text-center">Syslog ID</th>
                    <th class="text-center">Data Ínicio</th>
                    <th class="text-center">Data Fim</th>
                    <th class="text-center">Duração (Minutos)</th>
                    <th class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($dadosEventosCliente as $row) :?>
                    <tr>
                        <td><?php echo $row['nome']?></td>
                        <td class="text-center"><?php echo $row['cliente_ip']?></td>
                        <td class="text-center"><?php echo $row['syslog_id']?></td>
                        <td class="text-center"><?php echo $row['data_inicio']?></td>
                        <td class="text-center"><?php echo $row['data_fim']?></td>
                        <td class="text-center"><?php echo $row['duracao']?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-7 text-left">
                <input name="btnVoltar" class="btn-redirect btn btn-default" type="button" data-url="<?php echo base_url(); ?>Admin/Monitoramento" value="<?php echo $this->lang->line('voltar'); ?>"/>
            </div>
        </div>
    </div>
</div>



