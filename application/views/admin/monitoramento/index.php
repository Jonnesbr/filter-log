<?php
if (isset($retorno['mensagem']) && $retorno['mensagem']) :
    $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
    echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
endif;
?>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div id="mapa" style="height: 320px; width: 1410px;"></div>
			</div>
		</div>
		<br>
		<!--Tabela de monitoramento-->
		<div class="container-fluid">
			<div class="row">
				<div class="jumbotron">
					<h3 class="text-center" style="color: blue">Clientes em monitoramento</h3>
					    <table class="table table-bordered table-stripped">
					    	<thead>
					    		<tr>
					    			<th><b>Cliente</b></th>
					    			<th><b>IP</b></th>
					    		</tr>
					    	</thead>
					    	<tbody>
					    	<?php foreach($dadosSemEventos as $dados){ ?>
					    		<tr>
					    			<td><?php echo $dados['nome'] ?></td>
					    			<td><?php echo $dados['cliente_ip'] ?></td>
					    		</tr>
					    	<?php } ?>
					    	</tbody>
					    </table>
				    </div>
			</div>
		</div>
		<!--Fim-->

		<!--Tabela de quarentena-->
		<div class="container-fluid">
			<div class="row">
				<div class="jumbotron">
					<h3 class="text-center" style="color: red">Clientes em quarentena</h3>
				    <table class="table table-bordered table-stripped">
				    	<thead>
				    		<tr>
				    			<th><b>Cliente</b></th>
				    			<th><b>IP</b></th>
				    			<th><b>Eventos</b></th>
				    			<th></th>
				    		</tr>
				    	</thead>
				    	<tbody>
				    	<?php foreach($dadosEventos as $dado){ ?>
				    		<tr>
				    			<td><?php echo $dado['nome'] ?></td>
				    			<td><?php echo $dado['cliente_ip'] ?></td>
				    			<td><?php echo $dado['qtde'] ?></td>
				    			<td class="text-center">
				    				<a href="<?php echo base_url().'Admin/Monitramento/resolucao/'.$dado['cliente_ip'];?>" title=""><i class="glyphicon glyphicon-ok"></i> Resolução</a>
				    			</td>
				    		</tr>
				    		<?php } ?>
				    	</tbody>
				    </table>
			    </div>
			</div>
		</div>
		<!--Fim-->

		</div>
	<br>
			

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDMHvCmWwSu_6qwIlf0KzkFfh61wbE092c&amp;sensor=false"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/js/mapa.js"></script>
	
	