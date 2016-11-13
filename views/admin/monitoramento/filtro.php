<?php

// Filtro.php version SQL


	define("SLASH", "\\");
	
	if (isset($_REQUEST['q']) || isset($_REQUEST['c']) ){
		
	$q		= (isset($_REQUEST['q'])? $_REQUEST['q'] : null);
  	$c		= (isset($_REQUEST['c'])? $_REQUEST['c'] : null);

	$de = (isset($_REQUEST['de'])? $_REQUEST['de'] : null);
	$ate = (isset($_REQUEST['ate'])? $_REQUEST['ate'] : null);
	$datesearch = (isset($_REQUEST['datesearch'])? $_REQUEST['datesearch'] : null);
	$indsearch = (isset($_REQUEST['indsearch'])? $_REQUEST['indsearch'] : null);
	$indices = (isset($_REQUEST['indices'])? $_REQUEST['indices'] : null);
		

	}else {
		$q = $c = $results = null;
		
		}
		
		
		echo '
	<html>
	<head>
	<meta charset="utf-8">
	<body>
	<pre>
		<form method=post>
		<label>Data: </label> De <input name="de" size=30 value="'. @$de .'" placeholder="AAAA-MM-DD"/> até <input name="ate" size=30 value="'. @$ate .'" placeholder="AAAA-MM-DD" /> 
		<label>Filtro:	</label><input name=q size=40 value="'. $q .'" />  <input name="datesearch" value="Busca por data" type=submit class="btn btn-primary">
		<label>Consultar por indices:	</label><input name="indices" size=100 style="width: 84px;" value="'. ($indices?$indices:1000000) .'" /> <input name="indsearch" value="Buscar" type=submit class="btn btn-primary"> ( 1 dia tem aproximadamente 1.000.000 de índices )
		</form>
		
	';
	if (isset($_REQUEST['q']) || isset($_REQUEST['c']) ){

	$conn = pg_connect("host=localhost port=5432 dbname=syslog user=syslog password=joVEEe1mHQ0VBtv");
		
	if (!$conn) {
	  echo "An error occurred.\n";
	  echo pg_last_error($conn);
	  exit;
	}
	if($indsearch){
	if($indices > 5000000){echo "indice tem que ser menor do que 5 milhoes";exit();}
	//$query = "SELECT id, devicereportedtime, fromhost, syslogtag, message FROM systemevents WHERE message like '%" . pg_escape_string($q) . "%' ORDER BY id DESC LIMIT ".preg_replace('/\D/','',$indices);}
	$query = "SELECT * FROM (SELECT id, devicereportedtime, fromhost, syslogtag, message FROM systemevents ORDER BY id DESC LIMIT ".preg_replace('/\D/','',$indices).") as events WHERE message like '%" . pg_escape_string($q) . "%'";}
	elseif($datesearch){
	if(!@$de){
		$dataquery = "devicereportedtime > current_date - interval '2' day";
	} else {
		$dataquery = "devicereportedtime > '". pg_escape_string($de) ."'";
		if(@$ate){
			$dataquery .= " AND devicereportedtime < '". pg_escape_string((strlen($ate) == 10?$ate.' 23:59:59':$ate)) ."'";
		}
	}

	$query = "SELECT id, devicereportedtime, fromhost, syslogtag, message FROM systemevents WHERE ". $dataquery ." AND message like '%" . pg_escape_string($q) . "%'";
	}


	//echo 'query: '.$query; exit();


	$result = pg_query($conn, $query);

	if (!$result) {
	  echo "Aconteceu um erro.\n" . pg_last_error();

	  exit;
	}

	while ($row = pg_fetch_row($result)) {
	  echo "$row[0]    $row[1] $row[2] $row[3] $row[4]\n";
	}
		
		
		
		echo '</pre>';


	}

?>

