<?php
if (isset($retorno['mensagem']) && $retorno['mensagem']) :
    $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
    echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
endif;
?>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6">
				<div class="jumbotron"></div>		
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6">
				<div class="jumbotron"></div>
			</div>
		</div>
		<br>
			

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDMHvCmWwSu_6qwIlf0KzkFfh61wbE092c&amp;sensor=false"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/js/mapa.js"></script>
	
	