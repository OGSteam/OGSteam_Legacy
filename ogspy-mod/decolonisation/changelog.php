<?php
/***************************************************************************
*	filename	: changelog.php
*	package		: Mod Decolonisation
*	version		: 0.7d
*	desc.			: changelog du mod Decolonisation
*	Authors		: Jojo.lam44 & Scaler - http://ogsteam.fr
*	created		: 11/08/2006
*	modified	: 09:38 05/09/2009

TODO
- Rien

[Fix] : supression d'un bug
[Add] : rajout d'une fonction
[Imp] : amélioration d'une fonction

***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

echo "<p align='center'><a href='index.php?action=".$mod_name."'>".$lang['decolo_back']."</a><br /><br />".$lang['decolo_legend']."</p><br />";
echo "<fieldset><legend><b><u>".$lang['decolo_version']." 0.7c :</u></b> <i>(".date($lang['decolo_date_format'],mktime(0, 0, 0, 6, 1, 2009)).")</i></legend>
<p align='left'><font size='2'>".$lang['decolo_version_0.7c']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['decolo_version']." 0.7b :</u></b> <i>(".date($lang['decolo_date_format'],mktime(0, 0, 0, 8, 30, 2008)).")</i></legend>
<p align='left'><font size='2'>".$lang['decolo_version_0.7b']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['decolo_version']." 0.6 :</u></b> <i>(".date($lang['decolo_date_format'],mktime(0, 0, 0, 2, 24, 2008)).")</i></legend>
<p align='left'><font size='2'>".$lang['decolo_version_0.6']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['decolo_version']." 0.5 :</u></b> <i>(".date($lang['decolo_date_format'],mktime(0, 0, 0, 12, 20, 2007)).")</i></legend>
<p align='left'><font size='2'>".$lang['decolo_version_0.5']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['decolo_version']." 0.4 :</u></b> <i>(".date($lang['decolo_date_format'],mktime(0, 0, 0, 11, 9, 2007)).")</i></legend>
<p align='left'><font size='2'>".$lang['decolo_version_0.4']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['decolo_version']." 0.3b :</u></b> <i>(".date($lang['decolo_date_format'],mktime(0, 0, 0, 11, 4, 2007)).")</i></legend>
<p align='left'><font size='2'>".$lang['decolo_version_0.3b']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['decolo_version']." 0.3 :</u></b> <i>(".date($lang['decolo_date_format'],mktime(0, 0, 0, 11, 4, 2007)).")</i></legend>
<p align='left'><font size='2'>".$lang['decolo_version_0.3']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['decolo_version']." 0.2 :</u></b> <i>(".date($lang['decolo_date_format'],mktime(0, 0, 0, 11, 1, 2007)).")</i></legend>
<p align='left'><font size='2'>".$lang['decolo_version_0.2']."</br></font></p></fieldset>";
echo "<br /><br />";
?>
