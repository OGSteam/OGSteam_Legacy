<?php
/***************************************************************************
*	filename	: changelog.php
*	package		: Mod Energie
*	version		: 0.8
*	desc.			: changelog du mod Energie
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 10:12 08/11/2007
*	modified	: 09:53 05/09/2009

TODO
- Rien

[Fix] : supression d'un bug
[Add] : rajout d'une fonction
[Imp] : amélioration d'une fonction

***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

echo "<p align='center'><a href='index.php?action=".$mod_name."'>".$lang['energy_back']."</a><br /><br />".$lang['energy_legend']."</p><br />";
echo "<fieldset><legend><b><u>".$lang['energy_version']." 0.8 :</u></b> <i>(".date($lang['energy_date_format'],mktime(0, 0, 0, 9, 5, 2009)).")</i></legend>
<p align='left'><font size='2'>".$lang['energy_version_0.8']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['energy_version']." 0.7b :</u></b> <i>(".date($lang['energy_date_format'],mktime(0, 0, 0, 8, 30, 2008)).")</i></legend>
<p align='left'><font size='2'>".$lang['energy_version_0.7b']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['energy_version']." 0.6b :</u></b> <i>(".date($lang['energy_date_format'],mktime(0, 0, 0, 1, 31, 2008)).")</i></legend>
<p align='left'><font size='2'>".$lang['energy_version_0.6b']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['energy_version']." 0.6 :</u></b> <i>(".date($lang['energy_date_format'],mktime(0, 0, 0, 1, 27, 2008)).")</i></legend>
<p align='left'><font size='2'>".$lang['energy_version_0.6']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['energy_version']." 0.5 :</u></b> <i>(".date($lang['energy_date_format'],mktime(0, 0, 0, 1, 13, 2008)).")</i></legend>
<p align='left'><font size='2'>".$lang['energy_version_0.5']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['energy_version']." 0.4 :</u></b> <i>(".date($lang['energy_date_format'],mktime(0, 0, 0, 1, 11, 2008)).")</i></legend>
<p align='left'><font size='2'>".$lang['energy_version_0.4']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['energy_version']." 0.3b :</u></b> <i>(".date($lang['energy_date_format'],mktime(0, 0, 0, 12, 20, 2007)).")</i></legend>
<p align='left'><font size='2'>".$lang['energy_version_0.3b']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['energy_version']." 0.3 :</u></b> <i>(".date($lang['energy_date_format'],mktime(0, 0, 0, 12, 20, 2007)).")</i></legend>
<p align='left'><font size='2'>".$lang['energy_version_0.3']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['energy_version']." 0.2b :</u></b> <i>(".date($lang['energy_date_format'],mktime(0, 0, 0, 11, 22, 2007)).")</i></legend>
<p align='left'><font size='2'>".$lang['energy_version_0.2b']."</br></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['energy_version']." 0.2 :</u></b> <i>(".date($lang['energy_date_format'],mktime(0, 0, 0, 11, 22, 2007)).")</i></legend>
<p align='left'><font size='2'>".$lang['energy_version_0.2']."</br></font></p></fieldset>";
echo "<br /><br />";
?>
