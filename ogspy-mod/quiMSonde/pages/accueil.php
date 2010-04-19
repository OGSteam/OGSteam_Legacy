<?php
/**
 * accueil.php 

Page Accueil

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Pour savoir qui affiche la page
global $user_data;

// Definition
$most = Array();

// On récupére les données
$table_spy=get_spies($user_data['user_id'],"","");
$max_spy=count($table_spy['cible']);
$temp1=array('cible','joueur');
foreach($temp1 as $temp2)
{
	$temp3 = get_most($temp2,$table_spy);
	$most[$temp2] = $temp3['data'][0];
	$most[$temp2."_cnt"]=isset($temp3['cnt'][1])?$temp3['cnt'][1]:0;
}
// Ouverture du FiledSet
echo"<fieldset>\n<legend><b><font color='#80FFFF'>".$lang['qms_menu_accueil'].help('qms_accueil')."</font></b></legend>\n\n";

// Résumé des espionnages.
echo "\n\n<!-- Resumé des Espionnages -->\n<table width='60%%'>\n<tr><td class='l'><p>";
if($max_spy>0)
	echo sprintf($lang['qms_resume_2_lignes'],$max_spy,$most['joueur_cnt'],$most['joueur'],$most['cible_cnt'],$most['cible']);
else
	echo $lang['qms_resume_rien_du_tout'];
echo "</p></td></tr>\n</table>\n<br/>\n";
// S'il y a des espionnages, on affiche les 1 à 3 premiers
if($max_spy>0)
{	
	// 1, 2 ou 3 ?
	if($max_spy>3) {$nb_last=3;$s_1='des 3';$s_0='s';}
	elseif($max_spy>2) {$nb_last=2;$s_1='des 2';$s_0='s';}
	else {$nb_last=1;$s_1='du';$s_0='';}

	// Depart du tableau des 1, 2 ou 3 derniers espionnages
	echo"\n\n<!-- Les Derniers Espionnages -->\n<table width='569'>\n";
	
	// Titre
	echo"<tr><td class='l' colspan='4'>".($nb_last==1?$lang['qms_le_dernier']:sprintf($lang['qms_les3derniers'],$nb_last))."</td></tr>\n";
	
	// Pour le, les 2 ou les 3 espionnages
	for($j=0;$j<$nb_last;$j++) echo make_spy_OGameStyle($table_spy,$j);

	// Fin du tableau
	echo"</table>\n";
}

// Fin du FieldSet
echo"</fieldset>\n";
	
// Faut-il afficher le bloc d'insertion ?
if(get_qms_config("add_home",$user_data['user_id'])=='yes'){
	echo "<br/><br/>";
	include("insertion.php");
}
// Fin de la page
echo"\n\n<!-- fin page ".$pub_page.".php -->\n";
?>