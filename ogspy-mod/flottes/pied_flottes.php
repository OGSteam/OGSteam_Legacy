<?php
/***************************************************************************
*	filename	: pied_flottes.php
*	desc.		: 1.08b
*	Author		: Conrad des Dragons
*	created		: 17/12/2005
*	modified	: AirBat, Zanfib
*	last modif. : 20/04/2008
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$query = "SELECT version FROM ".TABLE_MOD." WHERE action='flottes'";
$result=$db->sql_query($query);
list($vers)=mysql_fetch_array($result);
echo '<div align="center" style="margin-top:20px;">';
echo '<div class="footer">';
echo 'Mod Flottes créé par <a href="mailto:conraddesdragons@free.fr">Conrad des Dragons</a><br>';
echo 'Repris par Zanfib et AirBat<br>';
echo 'Mise à jour par Shad pour OGSpy 3.0.7<br>';
echo 'Version '.$vers.' , &copy;2011';
echo '</div>';
echo '</div>';
?>