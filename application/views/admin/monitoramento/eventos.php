<?php header("Content-Type: text/html; charset=UTF-8", true); ?>

<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left title-custom-button">Informações do Cliente</h3>
    </div>
    <div class="panel-body">

        <div class="row col-md-6">
            <div class="">
                <label>Nome:</label>
                <span><?php echo $dadosCliente['nome'];?></span>
            </div>
            <div class="">
                <label>IP:</label>
                <span><?php echo $dadosCliente['ip'];?></span>
            </div>
            <div class="">
                <label>Cidade:</label>
                <span><?php echo $dadosCliente['cidade'];?></span>
            </div>
        </div>
        <div class="row col-md-6">
                <style>
                    #map {
                        height: 300px;
                        width: 100%;
                    }
                </style>
            <div class="mapa" id="map"></div>
            <script>
                function initMap() {
                    var uluru = {lat: <?php echo $dadosCliente['latitude'];?>, lng: <?php echo $dadosCliente['longitude'];?>};
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: <?php echo $dadosCliente['zoom'];?>,
                        center: uluru
                    });
                    var marker = new google.maps.Marker({
                        position: uluru,
                        map: map
                    });
                }
            </script>
            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBd5c2VN64eckyuLatFL17skWYrAyuIqi4&callback=initMap">
            </script>
        </div>

    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left title-custom-button">Eventos</h3>
    </div>
    <div class="panel-body">
        <div id="contentPaginacao">
            <table id="table_perfil" class="table table-striped table-hover">
                <thead>
                <tr>
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



