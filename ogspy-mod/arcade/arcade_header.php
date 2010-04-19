<?php
/**
* arcade_header.php Fichier Header pour le mod Arcade 
* @package Arcade
* @author ericalens <ericalens@ogsteam.fr> 
* @link http://www.ogsteam.fr
* @version 2.1
*/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

require_once("mod/Arcade/arcade_functions.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="language" content="fr">
<title>Arcade - <?php echo $server_config["servername"]." - OGSpy ".$server_config["version"];?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $link_css;?>formate.css" />
</head>
<body>
<table border="0" width="100%" cellpadding="10" cellspacing="0" align="center">
<tr>
<?php

	if ($server_config['arcade_fullscreen']!='1') {

		echo "<td width='150' align='center' valign='top' rowspan='2'>";
		require_once('views/menu.php');
		echo "</td>";
	}
	else {
		echo "<td width='1' align='center' valign='top' rowspan='2'>&nbsp;</td>";
	}
	echo "<td><div align='center'>";
	ShowArcadeMenu2();
	echo "</div></td>";
	echo "</tr>";

?>
<tr>
	<td align=center valign="top">
