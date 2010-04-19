<?php
/***************************************************************************
*	filename	: page_header.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 08/12/2005
*	modified	: 30/07/2006 00:00:00
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
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $LANG['ENCODING'];?>" />
<meta name="language" content="<?php $LANG['LANGUAGE'];?>">
<LINK REL="SHORTCUT ICON" HREF="./favicon.ico">
<title><?php echo $server_config["servername"]." - UniSpy ".$server_config["version"];?></title>
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
