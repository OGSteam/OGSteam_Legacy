<?php
/***************************************************************************
*	filename	: page_header.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 08/12/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if ($link_css == "") {
	$link_css = $server_config["default_skin"];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="language" content="fr">
<title><?php echo $server_config["servername"]." - OGSpy ".$server_config["version"];?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $link_css;?>formate.css" />
</head>
<body>
<table border="0" width="100%" cellpadding="10" cellspacing="0" align="center">
<tr>
	<td width="150" align="center" valign="top" rowspan="2"><?php require_once("menu.php");?></td>
	<td height="70"><div align="center"><img src="images/<?php echo $banner_selected;?>"></div></td>
</tr>
<tr>
	<td align="center" valign="top">