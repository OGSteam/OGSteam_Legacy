<?php
/***************************************************************************
*	filename	: changelog.php
*	package		: Mod Ressources
*	version		: 0.2
*	desc.			: changelog du mod Ressources
*	Author		: Scaler - http://ogsteam.fr
*	created		: 16:48 13/09/2009
*	modified	: 20:58 19/01/2010

TODO
- Rien

[Fix] : supression d'un bug
[Add] : rajout d'une fonction
[Imp] : amélioration d'une fonction

***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

echo "<p align='center'><a href='?action=".$mod_name."'>".$lang['ressources_back']."</a><br /><br />".$lang['ressources_legend']."</p><br />";
echo "<fieldset><legend><b><u>".$lang['ressources_version']." 0.2 :</u></b> <i>(".date($lang['ressources_date_format'],mktime(0, 0, 0, 1, 19, 2010)).")</i></legend>
<p align='left'><font size='2'>".$lang['ressources_version_0.2']."</br></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['ressources_version']." 0.1 :</u></b> <i>(".date($lang['ressources_date_format'],mktime(0, 0, 0, 1, 17, 2010)).")</i></legend>
<p align='left'><font size='2'>".$lang['ressources_version_0.1']."</br></font></p></fieldset>";
echo "<br /><br />";
?>
