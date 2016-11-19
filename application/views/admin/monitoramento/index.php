<?php
if (isset($retorno['mensagem']) && $retorno['mensagem']) :
    $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
    echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
endif;
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Atualizar Eventos Manualmente</h3>
	</div>
	<div class="panel-body">
		<?php
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
		<div id="carregando"></div>
		<?php echo form_close(); ?>
	</div>
</div>


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
				    			<td>
				    			<a role="button" data-toggle="collapse" href="#eventos" aria-expanded="false" aria-controls="eventos">
				    				<?php echo $dado['qtde'] ?>
				    			</a>
				    			</td>
				    			<td class="text-center">
				    				<a href="<?php echo base_url().'Admin/Monitoramento/resolucao/'.$dado['cliente_ip'];?>" title=""><i class="glyphicon glyphicon-ok"></i> Resolução</a>
				    			</td>
				    		</tr>
				    		<?php } ?>
				    	</tbody>
				    </table>
			    </div>
			</div>
		</div>
		<!--Fim-->

		<!--Tabela que listará todos os evendos daquela localização-->
		<div class="row">
			<div class="collapse col-xs-12 col-sm-12 col-md-6" id="eventos">
				<div class="well">
					<table class="table table-bordered table-stripped">
						<thead>
							<tr>
								<th><b>Início</b></th>
								<th><b>Fim</b></th>
								<th><b>Valor do Intervalo</b></th>
							</tr>
						</thead>
						<tbody>
							<tr>
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
			
