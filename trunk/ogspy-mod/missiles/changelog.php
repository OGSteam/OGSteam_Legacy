<?php
/*
 * missiles changelog.php
 */

// Rest si le module est active
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='missiles' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

?>
<style type="text/css">
fieldset.mis_fieldset_changelog {border:1px solid #344566; font-size:12px; font-family: Helvetica, Verdana, Arial, sans-serif; color:white}
fieldset legend.mis_legend_changelog {border: 1px solid #344566; color:#5CCCE8}
</style>

<?php

$out  = "";
$out .= "<fieldset class=\"mis_fieldset_changelog\"><legend class=\"mis_legend_changelog\"><b>v0.2c</font></b></legend>\n";
$out .= "<p align='left'>\n";
$out .= "\t- Corrections mineurs dans le code.<br />\n";
$out .= "\t- Suppression de l'affichage de la galaxie 1 par défaut.<br />\n";
$out .= "</p></fieldset>\n";
$out .= "<br />\n";
$out .= "<fieldset class=\"mis_fieldset_changelog\"><legend class=\"mis_legend_changelog\"><b>v0.2b</font></b></legend>\n";
$out .= "<p align='left'>\n";
$out .= "\t- Ajout dans les tooltips des cibles leur classement si il existe.<br />\n";
$out .= "\t- Corrections dans le code.<br />\n";
$out .= "\t- Mise à jour du css du menu pour éviter qu'il passe sur 2 lignes de temps en temps.<br />\n";
$out .= "</p></fieldset>\n";
$out .= "<br />\n";
$out .= "<fieldset class=\"mis_fieldset_changelog\"><legend class=\"mis_legend_changelog\"><b>v0.2a</font></b></legend>\n";
$out .= "<p align='left'>\n";
$out .= "\t- Correction mineur dans le code.<br />\n";
$out .= "</p></fieldset>\n";
$out .= "<br />\n";
$out .= "<fieldset class=\"mis_fieldset_changelog\"><legend class=\"mis_legend_changelog\"><b>v0.2</font></b></legend>\n";
$out .= "<p align='left'>\n";
$out .= "\t- Changement du nom dans le menu d'OGSpy.<br />\n";
$out .= "\t- Changement du fichier 'index' du module.<br />\n";
$out .= "\t- Affichage des cibles ne pouvant être touchées.<br />\n";
$out .= "\t- Ajout d'un menu.<br />\n";
$out .= "\t- Ajout d'un 'checkbox' pour une sélection/déselection globale des galaxies cibles.\n";
$out .= "</p></fieldset>\n";
$out .= "<br />\n";
$out .= "<fieldset class=\"mis_fieldset_changelog\"><legend class=\"mis_legend_changelog\"><b>2007-01-11</font></b></legend>\n";
$out .= "<p align='left'>\n";
$out .= "\t- Reprise du projet d'origine.<br />\n";
$out .= "\t- Affichage de la portée max des MIP des joueurs de l'alliance.<br />\n";
$out .= "\t- Sélection de la galaxie à afficher.<br />\n";
$out .= "</p></fieldset>\n";
print($out);

?>