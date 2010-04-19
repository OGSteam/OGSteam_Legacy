<?php
//    © 2006 GEOLOC
include('config.php');
$timeoutsecondes = (60*$min);$tps=time();$time=(date("H",time())+(date("i",time())/60));
$timeout  = $tps - $timeoutsecondes;$host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
$elem=explode( ".", $host);$howm=count($elem);$dom=$elem[$howm-1];
if (is_numeric($dom) OR empty($dom) OR ($dom=='local') OR ($dom=='loca') OR ($dom=='com') OR ($dom=='arpa') OR ($dom=='mil') OR ($dom=='prowin13') OR ($dom=="") OR ($dom=='net') OR ($dom=='edu') OR ($dom=='org') OR ($dom=='gov') OR ($dom=='nato') OR ($dom=='un') OR ($dom=='DANN') OR ($dom=='arpa')){$dom="rien";}
if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];elseif(isset($_SERVER['HTTP_CLIENT_IP']))$ip = $_SERVER['HTTP_CLIENT_IP'];
else $ip = $_SERVER['REMOTE_ADDR'];$dotted = preg_split( "/[.]+/", $ip);$ip2 = (double) ($dotted[0]*16777216)+($dotted[1]*65536)+($dotted[2]*256)+($dotted[3]);
if(empty($ip)){$ip2="unknow";}include('mysql_connect.php');
$req2=mysql_query("INSERT INTO `".$table_prefix."geo2` (`time` , `ip`  )VALUES ('$tps', '$ip2' )");
mysql_close($link);
echo"document.write('<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"180\" height=\"100\"><param name=\"movie\" value=\"http://".$url_site."/compteur_geoloc/geoloc.swf?".$tps."\"><param name=\"menu\" value=\"false\"><param name=\"quality\" value=\"high\"><param name=\"FLASHVARS\" value = \"dom=".$dom."&url=".$url_site."\"><embed src=\"http://".$url_site."/compteur_geoloc/geoloc.swf?dom=".$dom."&url=".$url_site."&".$tps."\" quality=\"high\"  menu=\"false\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"180\" height=\"100\"></embed></object>')";
?>