<?php
if (isset($retorno['mensagem']) && $retorno['mensagem']) :
    $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
    echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
endif;
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Atualizar Eventos</h3>
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
				    			<th class="text-center"><b>Eventos</b></th>
				    			<th class="text-center"><b>Ações</b></th>
				    		</tr>
				    	</thead>
				    	<tbody>
				    	<?php foreach($dadosEventos as $dado){ ?>
				    		<tr>
				    			<td><?php echo $dado['nome'] ?></td>
				    			<td><?php echo $dado['cliente_ip'] ?></td>
                                <?php
                                if (intval($dado['qtde']) <= SINAL_VERDE) : ?>
                                    <td class="text-center" ><span class="label label-success"><?php echo $dado['qtde']; ?></span></td>
                                <?php
                                elseif (intval($dado['qtde']) >= SINAL_AMARELO_MIN && intval($dado['qtde']) <= SINAL_AMARELO_MAX) : ?>
                                    <td class="text-center"><span class="label label-warning"><?php echo $dado['qtde']; ?></span></td>
                                <?php
                                elseif (intval($dado['qtde']) >= SINAL_VERMELHO) : ?>
                                    <td class="text-center"><span class="label label-danger"><?php echo $dado['qtde']; ?></span></td>
                                <?php endif;
                                ?>
                                <td class="center-vertical">
                                    <div class="btn-group" role="group" aria-label="...">
                                        <a type="button" class="btn btn-primary btn-sm" href="<?php echo base_url().'Admin/Monitoramento/eventos/' . $dado['cliente_ip'];?>" title="Visualizar Eventos"><i class="fa fa-search" aria-hidden="true"></i></a>
                                        <a type="button" class="btn btn-success btn-sm" href="<?php echo base_url().'Admin/Monitoramento/resolucao/' . $dado['cliente_ip'];?>" title="Informar Resolução"><i class="fa fa-check" aria-hidden="true"></i></a>
                                    </div>
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
			
