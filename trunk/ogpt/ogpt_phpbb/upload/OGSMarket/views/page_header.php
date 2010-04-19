<?php
/***************************************************************************
*	filename	: page_header.php
*	desc.		:
*	Author		:	ericalens 
*	created		: 	04/06/2006
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $server_config["servername"]." - ".$server_config["version"];?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $link_css;?>formate.css" />
<link rel="alternate" type="application/rss+xml" title="Flux RSS des Offres" href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>?action=rss" /></head>
<body onload="javascript:bodyOnLoad()">
<script type="text/javascript" src="js/prototype.js"> </script>
<script type="text/javascript" src="js/rico.js"> </script>

<script>

var onloads = new Array();
function bodyOnLoad() {
	for ( var i = 0 ; i < onloads.length ; i++ )
		onloads[i]();
}
</script>
<table border="0" width="100%" cellpadding="10" cellspacing="0" align="center">
<tr>
<td width="150" align="center" valign="top" rowspan="2"><?php require_once("views/menu.php");?></td>
	<td height="70"><div align="center"><a href='index.php'><img src="http://img85.imageshack.us/img85/1166/ogsmarkets3qo.gif" border="0"></a></div></td>
</tr>
<tr>
	<td align="center" valign="top">

