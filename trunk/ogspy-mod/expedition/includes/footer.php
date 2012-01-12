<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct

// Version du Mod
$mod_version = "0";
$query = "SELECT version FROM ".TABLE_MOD." WHERE `action`='eXpedition'";
$result = mysql_query($query);
list($mod_version) = mysql_fetch_row($result);

//définition de la page
$pageFooter = <<<HEREFOOTER

<!-- DEBUT Insertion mod eXpedition : Footer -->
<br />
<br />
<p align='center'>Mod eXpedition | 
	Version $mod_version |
	<a href="http://varius9.free.fr/">Varius9</a> | 
	<a href="http://ogsteam.fr/forums/sujet-4095-mod-expedition">Post sur la board</a> | © 2012
</p>
<!-- FIN Insertion mod eXpedition : Footer -->
HEREFOOTER;
//affichage de la page
echo($pageFooter);
?>

