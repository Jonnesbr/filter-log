<?php
if (isset($retorno['mensagem']) && $retorno['mensagem']) :
    $class = $retorno['sucesso'] ? 'alert alert-success' : 'alert alert-danger';
    echo "<div class='{$class}'>{$retorno['mensagem']}</div>";
endif;
?>
		  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		  <script type="text/javascript">
		    google.charts.load("current", {packages:['corechart']});
		    google.charts.setOnLoadCallback(drawChart);
		    function drawChart() {
		      var data = google.visualization.arrayToDataTable([
		        ["Element", "Density", { role: "style" } ],
		        ["Cabo Rompido", 8.94, "#b87333"],
		        ["Switch Queimado", 10.49, "silver"],
		        ["Problemas com o switch principal", 19.30, "gold"],
		        ["Cascateamento", 21.45, "color: #e5e4e2"],
		        ["Defeito no cliente", 21.45, "color: #e5e4e2"],
		        ["Problema de energia", 21.45, "color: #e5e4e2"]
		      ]);

		      var view = new google.visualization.DataView(data);
		      view.setColumns([0, 1,
		                       { calc: "stringify",
		                         sourceColumn: 1,
		                         type: "string",
		                         role: "annotation" },
		                       2]);

		      var options = {
		        title: "Resoluções",
		        width: 900,
		        height: 400,
		        bar: {groupWidth: "95%"},
		        legend: { position: "none" },
		      };
		      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
		      chart.draw(view, options);
		  	}
		  </script>

	  	<div class="row">
	  		<div class="col-xs-12 col-sm-12 col-md-4">
	  			<div class="jumbotron">
	  				<h2 class="text-center">Causas e frequências</h2>
	  				<ul>
	  					<li>Cabo Rompido</li>
	  					<li>Switch Queimado</li>
	  					<li>Problemas com o switch principal</li>
	  					<li>Cascateamento</li>
	  					<li>Defeito no cliente</li>
	  					<li>Problema de energia</li>
	  				</ul>
	  				<h3 class="text-center">Cidade: Pompéia</h3>
	  			</div>
	  		</div>
	  		<div class="col-xs-12 col-sm-12 col-md-8">
	  			<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
	  		</div>
	  	</div>
	  	
	    

			
