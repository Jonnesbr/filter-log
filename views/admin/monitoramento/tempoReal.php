<?php
// Monitoramento.php SQL version


$p = @$_REQUEST['p'];
$lastsize = @$_REQUEST['lastsize'];


if (!function_exists('json_encode')) {
	require_once('JSON.php');
	$GLOBALS['JSON_OBJECT'] = new Services_JSON();
	function json_encode($value)
	{
		return $GLOBALS['JSON_OBJECT']->encode($value); 
	}
	
/*	function json_decode($value)
	{
		return $GLOBALS['JSON_OBJECT']->decode($value); 
	}
	*/
}
	
	

if ($p == 'log'){
	//$logfile = '/var/log/httpd/access_log';

	$conn = pg_connect("host=localhost port=5432 dbname=syslog user=syslog password=joVEEe1mHQ0VBtv");

if (!$conn) {
  echo "An error occurred. could not connect to DB.\n";
  exit;
}

//pega o id do ultimo valor no banco
$result = pg_query($conn, "select last_value from systemevents_id_seq;");
if (!$result) {
  echo "An error occurred. could not select sequence\n";
  exit;
}

$row = pg_fetch_row($result);





	//set_time_limit(0);

	clearstatcache();
	$currsize = $row[0];
	
	if (!$lastsize || $lastsize == 'null'){
		echo json_encode( array('filesize' => $currsize	));
		exit();
	}
	else {
$lastid = preg_replace('/\D*/','', $lastsize);

$result = pg_query($conn, "SELECT id, devicereportedtime, fromhost, syslogtag, message FROM systemevents where id > $lastid ");
if (!$result) {
  echo "An error occurred. could not select table.\n" . $lastid;
  exit;
}

while ($row = pg_fetch_row($result)) {
  $chunk .= "$row[0]    $row[1] $row[2] $row[3] $row[4]\n";
}
			echo json_encode( array('filesize' => $currsize, 'filedata'=> $chunk));
	}
		
	
	exit();
}

?>
<html>
<head>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript" >

filesize = null;
waittime = 1000; //milliseconds
loglines = 1;
firstsize = 0;

filterword = "";

function createFilter (name, label, regex) {
	this.name = name;
	this.label = label;
	this.regex = regex;
};

var filter = new Array();

filter[0] = new createFilter ('AliasNotFound', 'Alias Not Found', /Registrar: .* User for alias.* not found/);
filter[1] = new createFilter ('Response404', 'RX SIP Response 404', /RX SIP Response FROM:[^:]*: 404/);
filter[2] = new createFilter ('Response480', 'RX SIP Response 480', /RX SIP Response FROM:[^:]*: 480/);
filter[3] = new createFilter ('Response503', 'RX SIP Response 503', /RX SIP Response FROM:[^:]*: 503/);
filter[4] = new createFilter ('Response603', 'RX SIP Response 603', /RX SIP Response FROM:[^:]*: 603/);
filter[5] = new createFilter ('InvalidDigest', 'Invalid Digest', /Registrar: .* User for alias.* invalid digest/);
filter[6] = new createFilter ('Unabletologin', 'unable to log in', /VSC.* unable to log in.*/);


function request_log(){
	$.post("<?php echo $_SERVER['PHP_SELF']; ?>", { p: "log", lastsize: filesize },
   	function(data) {
   		filesize = data.filesize;
   		if(firstsize == 0) {firstsize = filesize;}
   		//else{$('#logsize').text(((filesize-firstsize)/1024).toFixed(1));} //atualiza o tamanho do log  		
   		if(data.filedata){
   			lines = data.filedata.split("\n");
   			for (var key in lines){
   				if (lines[key] != "" && lines[key].length > 1){
   					var nfilter = 0;
   					var p = $("<pre id='log-"+ loglines +"' />");
   					for (var fk in filter){
   						if(lines[key].match(filter[fk].regex)){
   							p.addClass(filter[fk].name); //add class to <p>
   							nfilter++;
   						}
   					}
   					if (nfilter == 0){
   						p.addClass('NoFilter');
   					}
						p.text(lines[key]);
						p.hover(add_linkto_sipkey);
   					$('#log-div').append(filter_line(p,filterword));
   					loglines++;
					if(loglines > 2000){$('#log-div :first').remove();}
   				}
   			}
   			$('#lognlines').text(loglines);
   		}
   		setTimeout ( request_log, waittime );
     }, "json");
     
};

request_log();

function escapeRegExp(str) {
  return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
}

function add_linkto_sipkey (e){
	line = $(this)
	var ma = line.text().match(/\[([^@\]]{5,})@?\S*\]/);
	//console.log();
	if (ma && line.find('.subfilter').size() == 0){// filter_all(\\\''+ ma[1] +'\\\');
		//console.log(line.find('.subfilter').size());
		line.html(line.html().split(ma[1]).join('<span class="subfilter">'+ma[1]+'</span>'));
		line.find('.subfilter').click(function(){  filter_all(escapeRegExp($(this).text())); });//  filter_all($(this).text());
	}
}

function filter_line(line,filtertxt){
	var classes = line.attr("class").toString().split(' ');
	var visible = 0;
	for (var k in classes){
		if($('#f-'+ classes[k]).prop('checked')){
			visible = 1;
		}
	}
	if(visible == 0){line.hide(); return line;}
	try{
		var re = new RegExp(filtertxt,'g');
	}catch(e){
		//Invalid REGEX
		//so show everything
		var re = new RegExp("",'g');
		filtertxt = '';
	}
	var ma = line.text().match(re);
	if (ma){
		if(filtertxt != ''){
			line.html(line.text().split(ma[0]).join('<span style="background: yellow;">'+ma[0]+'</span>'));
		}
		else{
			line.html(line.text());
		}
	 	line.show();
	}
	else{
	 		line.hide();
	}
	return line;
}

function filter_all(filtertxt){
	$('#in-filter').val(filtertxt);
	filterword = filtertxt;
	var kids = $('#log-div').children();
/*	if(filtertxt == ''){
		kids.each(function(index) {
			$(this).html($(this).text()).show();

		});
	}else{*/
		kids.each(function(index) {
			filter_line($(this),filtertxt)
		});
	//}
	
};

function showhide_ckbx (){
	var filtername = this.id.split('-')[1];
		if(this.checked) {
			$('.'+filtername).css('display', 'block');
		}
		else{
			$('.'+filtername).css('display', 'none');
		}
}

$(document).ready(function() {
	
	for (var key in filter){
		var filtername = filter[key].name;
		$('#filterbxs').append('<li><label><input type="checkbox" id="f-'+ filter[key].name +'" checked />'+ filter[key].label +'</label></<li> - ');
		$('#f-'+ filter[key].name).change(showhide_ckbx);
	}	
	$('#filterbxs').append('<li><label><input type="checkbox" id="f-NoFilter" checked/>NoFilter</label></li>');
	$('#f-NoFilter').change(showhide_ckbx);
	
	$('#in-filter').change(function() {
		filterword = $('#in-filter').val();
		setTimeout ( function(){
				filterword = $('#in-filter').val();
				filter_all(filterword);
			}, 1 );

	});

});

</script>

<style type="text/css">
#log-div {
	overflow: scroll;
	height: 500px;
	resize: both;
}
pre,p {
	margin: 0px;
	font-family: monospace;
}
pre:hover {
	margin: 0px;
/*	background-color: #DADAF1;*/
}
#filterbxs {
	list-style-type: none;
}
ul,li {
	display: inline;
}
.subfilter:hover{
	background-color: #F7EBA8;
	border: 1px solid red;
	font-weight: bold;
	cursor:pointer;
}



.AliasNotFound{color:blue;}
.Response404{color:red}
.Response480{color:red}
.Response503{color:red}
.Response603{color:red}
.InvalidDigest{color:purple;}
.Unabletologin{color:brown;}

</style>

</head>
<body>
<div class="jumbotron">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-2">
			<input class="form-control" type="text" id="in-filter" placeholder="Filtrar" />
		</div>
		<button class="btn btn-primary" onclick="filter_all('');">Limpar</button>
	</div>
	<br>
	<ul id='filterbxs'></ul>
	<div id='log-div' style="height: 90%;" ></div>
	<lable class="control-label">Tamanho do log: ~<span id="logsize"></span> Kb</label>
	<br>
	<lable class="control-label">Linhas: <span id="lognlines"></span></label>	
</div>
</body>
</html>	
