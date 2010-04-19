<?php
/***************************************************************************
*	filename	: changelog.php
*	version		: 0.5
*	desc.			: changelog du mod Pandore
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 12:55 01/11/2007
*	modified	: 14:03 08/01/2010

TODO
- Rien.

[Fix] : supression d'un bug
[Add] : rajout d'une fonction
[Imp] : amélioration d'une fonction

***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

echo "<p align='center'><br />".$lang['pandore_legend']."</p><br /><br />";
echo "<fieldset><legend><b><u>".$lang['pandore_pandore']."</u></b></legend>".
	"<p align='center'><font size='2'>".$lang['pandore_intro']."</font></fieldset><br /><br />";
echo "<fieldset><legend><b><u>".$lang['pandore_version']." 0.5 :</u></b> <i>(".date($lang['pandore_changelog_date_format'],mktime(0, 0, 0, 1, 9, 2010)).")</i></legend>
<p align='left'><font size='2'>".$lang['pandore_version_0.5']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['pandore_version']." 0.4 :</u></b> <i>(".date($lang['pandore_changelog_date_format'],mktime(0, 0, 0, 9, 6, 2009)).")</i></legend>
<p align='left'><font size='2'>".$lang['pandore_version_0.4']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['pandore_version']." 0.3 :</u></b> <i>(".date($lang['pandore_changelog_date_format'],mktime(0, 0, 0, 3, 22, 2008)).")</i></legend>
<p align='left'><font size='2'>".$lang['pandore_version_0.3']."<br /></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['pandore_version']." 0.2 :</u></b> <i>(".date($lang['pandore_changelog_date_format'],mktime(0, 0, 0, 3, 20, 2008)).")</i></legend>
<p align='left'><font size='2'>".$lang['pandore_version_0.2']."</br></font></p></fieldset>";
echo "<fieldset><legend><b><u>".$lang['pandore_version']." 0.1 :</u></b> <i>(".date($lang['pandore_changelog_date_format'],mktime(0, 0, 0, 3, 19, 2008)).")</i></legend>
<p align='left'><font size='2'>".$lang['pandore_version_0.1']."</br></font></p></fieldset>";
echo "<br /><br />";
