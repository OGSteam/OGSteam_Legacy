<?php
/***************************************************************************
*	filename	: page_header_2.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 15/12/2005
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
<table width="100%" align="center" cellpadding="20">
<tr>
	<td height="70"><div align="center"><img src="images/<?php echo $banner_selected;?>"></div></td>
</tr>
<tr>
	<td>