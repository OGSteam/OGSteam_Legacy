<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct

// Version du Mod
$mod_version = "0";
$query = "SELECT version FROM ".TABLE_MOD." WHERE `action`='eXchange'";
$result = mysql_query($query);
list($mod_version) = mysql_fetch_row($result);


//définition de la page
$pageFooter = <<<HEREFOOTER



<!-- DEBUT Insertion mod eXchange : Footer -->


<br />
<br />
<p align='center'>Mod eXchange | 
	Version $mod_version |
	<a href="http://paradoxxx.zero.free.fr/">paradoxxx.zero</a> | 
	<a href="http://ogsteam.fr/forums/sujet-4226-mod-exchange">Post sur la board</a> | © 2008
</p>



<!-- FIN Insertion mod eXchange : Footer -->

HEREFOOTER;

//affichage de la page
echo($pageFooter);

?>

