<?php
/***********************************************************************
 * filename	:	functions.php
 * desc.	:	Fonctions diverses
 * created	: 	04/06/2006
 *
 * *********************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

/* Redirection Page web (kyser)*/
function redirection($url){
	if (headers_sent()) {
		die('<meta http-equiv="refresh" content="2; URL='.$url.'">');
	} else {
		header("Location: ".$url);
		exit();
	}
}


/* Chronometrage des fonctions (kyser) */
function benchmark() {
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];

	return $mtime;
}

function init_serverconfig() {
    global $db, $server_config, $infos_config;

    $request_config = "select name,value from ".TABLE_CONFIG;
    $result_config = $db->sql_query($request_config);
    $request_infos = "select name,value from ".TABLE_INFOS;
    $result_infos = $db->sql_query($request_infos);

    while (list($name, $value) = $db->sql_fetch_row($result_config)) {
        $server_config[$name] = $value;
    }
    while (list($name, $value) = $db->sql_fetch_row($result_infos)) {
        $infos_config[$name] = $value;
    }
}
function db_size_info() {
	global $db;

	$dbSize = 0;

	$request = "SHOW TABLE STATUS";
	$result = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc($result)) {
		$dbSize += $row['Data_length'] + $row['Index_length'];
	}

	$bytes = array('Octets', 'Ko', 'Mo', 'Go', 'To');

	if ($dbSize < 1024) $dbSize = 1;

	for ($i = 0; $dbSize > 1024; $i++)
	$dbSize /= 1024;

	$db_size_info['size'] = round($dbSize, 2);
	$db_size_info['type'] = $bytes[$i];

	return $db_size_info;
}

function text_datediff($fromtime,$totime=''){
	$Delay=bib_datediff($fromtime,$totime);
	$retvals='';
	if ($Delay["days"]) $retvals .= $Delay["days"]." j ";
	if ($Delay["hours"]) $retvals .= $Delay["hours"]." h ";
	if ($Delay["minutes"]) $retvals .= $Delay["minutes"]." min ";
	if ($Delay["seconds"]) $retvals .= $Delay["seconds"]." sec ";
	return $retvals;
}
// http://fr3.php.net/manual/fr/function.mktime.php#61259
function bib_datediff($fromtime, $totime=''){
	if($totime=='')        $totime = time();

	if($fromtime>$totime){
		$tmp = $totime;
		$totime = $fromtime;
		$fromtime = $tmp;
	}

	$timediff = $totime-$fromtime;
	//check for leap years in the middle
	for($i=date('Y',$fromtime); $i<=date('Y',$totime); $i++){
		if ((($i%4 == 0) && ($i%100 != 0)) || ($i%400 == 0)) {
			$timediff -= 24*60*60;
		}
	}
	$remain = $timediff;
	$ret['years']    = intval($remain/(365*24*60*60));
	$remain            = $remain%(365*24*60*60);
	$ret['days']    = intval($remain/(24*60*60));
	$remain            = $remain%(24*60*60);

	$m[0]    = 31;        $m[1]    = 28;        $m[2]    = 31;        $m[3]    = 30;
	$m[4]    = 31;        $m[5]    = 30;        $m[6]    = 31;        $m[7]    = 31;
	$m[8]    = 30;        $m[9]    = 31;        $m[10]    = 30;        $m[11]    = 31;
	//if leap year, february has 29 days
	if (((date('Y',$totime)%4 == 0) && (date('Y',$totime)%100 != 0)) || (date('Y',$totime)%400 == 0)){

		$m[1] = 29;
	}
	$ret['months']        = 0;
	foreach($m as $value){
		if($ret['days']>$value){
			$ret['months']++;
			$ret['days'] -=$value;
		} else {
			break;
		}
	}
	$ret['hours']    = intval($remain/(60*60));
	$remain            = $remain%(60*60);
	$ret['minutes']    = intval($remain/60);
	$ret['seconds']    = $remain%60;
	return $ret;
}
function get_htmlspecialchars( $given, $quote_style = ENT_QUOTES ){
   return htmlspecialchars( html_entity_decode( $given, $quote_style ), $quote_style );
}



?>
