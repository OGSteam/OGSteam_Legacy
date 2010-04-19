<?php
/***************************************************************************
*	filename	: page_header_2.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 15/12/2005
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
<title><?php echo $server_config["servername"]." - UniSpy ".$server_config["version"];?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $link_css;?>formate.css" />
</head>
<body>
<table width="100%" align="center" cellpadding="20">
<tr>
	<td height="70"><div align="center"><img src="images/<?php echo $banner_selected;?>"></div></td>
</tr>
<tr>
	<td>