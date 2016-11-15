<?php
if (isset($retorno['mensagem']) && $retorno['mensagem']) :
    $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
    echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
endif;
?>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	    <script type="text/javascript">
	      google.charts.load("current", {packages:["corechart"]});
	      google.charts.setOnLoadCallback(drawChart);
	      function drawChart() {
	        var data = google.visualization.arrayToDataTable([
	          ['Causas', 'Frequência'],
	          ['Cabo rompido',     11],
	          ['Switch queimado',      2],
	          ['Problema switch principal',  2],
	          ['Cascateamento', 2],
	          ['Defeito no cliente',    7],
	          ['Problema de energia', 8]
	        ]);

	        var options = {
	          title: 'Estatísticas de erros',
	          is3D: true,
	        };

	        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
	        chart.draw(data, options);
	      	}
	    </script>
	  
	  	<div class="row">
	  		<div class="col-xs-12 col-sm-12 col-md-4">
	  			<div class="jumbotron">
	  				<h2 class="text-center">Causas e frequências</h2>
	  				<h2 class="text-center">Cidade: Pompéia</h2>
	  			</div>
	  		</div>
	  		<div class="col-xs-12 col-sm-12 col-md-8">
	  			<div id="piechart_3d" style="width: 920px; height: 500px;"></div>
	  		</div>
	  	</div>
	  	
	    

			
