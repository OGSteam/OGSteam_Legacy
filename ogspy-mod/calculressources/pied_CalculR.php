<?php
/***************************************************************************
*	filename	: pied_CalculR.php
*	Author		: varius9
*	created		: 21/09/2008
*	modified	: Janvier 2011 par Varius9
***************************************************************************/

if (!defined('IN_SPYOGAME')) {die("Hacking attempt");}

$query = "SELECT version FROM ".TABLE_MOD." WHERE action='CalculRessources'";
$result=$db->sql_query($query);
list($vers)=mysql_fetch_array($result);
echo '<div align="center" style="margin-top:20px;">';
echo '<div class="footer">';
echo 'Mod <font COLOR="#FFFF00">Calcul Ressources</font> cr�� par Aeris Repris par <a href=mailto:varius9@free.fr>Varius9</a><br>';
echo 'Version '.$vers.' , &copy;2008-2012';
echo '</div>';
echo '</div>';
?>