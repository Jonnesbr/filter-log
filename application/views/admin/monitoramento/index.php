<?php
if (isset($retorno['mensagem']) && $retorno['mensagem']) :
    $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
    echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
endif;
?>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-4">
				<div class="jumbotron">
				<h3 class="text-center">Monitramento</h3>
				<br>
					<form class="form-horizontal">
						<div class="form-group">
							<label class="col-xs-2 control-label">Nome: </label>
							<div class="col-xs-10">	
								<input type="text" name="nome" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-2 control-label">IP: </label>
							<div class="col-xs-10">
								<input type="text" name="ip" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary">Monitorar</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-8">
				<div id="mapa" style="height: 320px; width: 920px;"></div>
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
					    		<tr>
					    			<td></td>
					    			<td></td>
					    		</tr>
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
				    		<tr>
				    			<td></td>
				    			<td></td>
				    			<td>
					    			<a role="button" data-toggle="collapse" href="#eventos" aria-expanded="false" aria-controls="eventos">
									  Quantidade de eventos
									</a>
				    			</td>
				    			<td></td>
				    			<td class="text-center">
				    				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Resolução</button>
				    			</td>
				    		</tr>
				    	</tbody>
				    </table>
			    </div>
			</div>
		</div>
		<!--Fim-->

		<!-- Modal -->
		  <div class="modal fade" id="myModal" role="dialog">
		    <div class="modal-dialog">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Qual foi o problema?</h4>
		        </div>
		        <div class="modal-body">
		          <form action="#">
		          	<label>Causa da falha: </label>
		          	<input type="text" name="erro">
		          	<input class="btn btn-primary" type="submit" value="Registrar">
		          </form>
		        </div>
		      </div>
		      
		    </div>
		  </div>

		<!--Tabela que listará todos os eventos-->
		<div class="container-fluid">
			<div class="row">
				<div class="collapse" id="eventos">
					<div class="jumbotron">
					<h3 class="text-center" style="color: red">Detalhes dos eventos</h3>
						<table class="table table-bordered table-stripped">
							<thead>
								<tr>
									<th><b>Seq</b></th>
									<th><b>Data Hora</b></th>
									<th><b>Cliente</b></th>
									<th><b>Número</b></th>
									<th><b>IP</b></th>
									<th><b>Hora início</b></th>
									<th><b>Hora fim</b></th>
									<th><b>Valor do intervalo</b></th>

								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
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
	
	