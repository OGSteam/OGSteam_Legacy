<?php
/**
 * anlyse.php 

Page Analyse

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Initialisation des Champs
global $user_data,$mod_name;
if(!isset($pub_nb_rapport)||($pub_nb_rapport<2)) 
	$pub_nb_rapport = get_qms_config('nbrapport',$user_data['user_id']); 
else 
	$pub_nb_rapport = mysql_real_escape_string(intval($pub_nb_rapport));	
if(!isset($pub_periodes)) 
	$pub_periodes = get_qms_config('periode',$user_data['user_id']); 
else 
	$pub_periodes =  mysql_real_escape_string(intval($pub_periodes));	
$radioJ = $lang['qms_joueurs'];
$radioA = $lang['qms_alliances'];
$radioP = $lang['qms_positions'];
$boutonM = $lang['qms_analyse_sur_moi'];
$boutonT = $lang['qms_analyse_sur_tous'];
if(!isset($pub_recherche)){
	echo"<fieldset><legend><b><font color='#80FFFF'>".$lang['qms_menu_analyse'].help('qms_analyses')."</font></b></legend>\n";
	echo"<form action='index.php?action=$mod_name&page=analyse' method='post'>\n<table width='350' align='center'>\n";
	echo"\t\t<th witdh='300'>".$lang['qms_config_nbrapport']." : ".help('qms_analyses nombre requis')."</th>\n";
	echo"\t\t<td align='center' witdh='50'>\n";
	echo"\t\t\t<input type='text' name='nb_rapport' id='nb_rapport' value='$pub_nb_rapport' onchange='chk_nb(\"nb_rapport\",$pub_nb_rapport);' width='50'>\n";
	echo"\t\t</td>\n\t</tr>\n\t<tr>\n";
	echo"\t\t<th>".$lang['qms_config_periode']." : ".help('qms_analyses periode')."</th>\n";
	echo"\t\t<td align='center'>\n";
	echo"\t\t\t<input type='text' name='periodes' id='periodes' value='$pub_periodes' onchange='chk_nb(\"periodes\",$pub_periodes);' witdh='50'>\n";
	echo"\t\t</td>\n\t</tr>\n\t<tr>\n";
	echo"\t\t<th>".$lang['qms_analyse_show_result_in']." : ".help('qms_analyses affichage')."</th>\n";
	echo"\t\t<td align='right' class='c'>\n";
	echo"\t\t\t".$lang['qms_joueurs']."<input type='radio' name='show_result' value='$radioJ' checked><br/>\n";
	echo"\t\t\t".$lang['qms_alliances']."<input type='radio' name='show_result' value='$radioA'><br/>\n";
	echo"\t\t\t".$lang['qms_positions']."<input type='radio' name='show_result' value='$radioP'><br/>\n";
	echo"\t\t</td>\n\t</tr>\n\t<tr>\n\t\t<th colspan='2' align='center'>\n";
	echo"\t\t\t".$lang['qms_analyse_submit']." : ".help('qms_analyses rechercher')."<br/>\n";
	echo"\t\t\t<input type='submit' name='recherche' value='$boutonM' witdh='45''>\n";
	echo"\t\t\t<input type='submit' name='recherche' value='$boutonT' width='45'>\n";
	echo"\t\t</th>\n";
	echo"\t</tr>\n";
	echo"</table></form></fieldset><br />\n";


}else{
	// Affichage du Résultat
	if($pub_recherche==$boutonM){
		if($pub_show_result==$radioP)
			list($tableau,$titre,$help_txt) = 
			Array (analyse_espionnage($pub_nb_rapport,$pub_periodes),$lang['qms_analyse_perso'].$lang['qms_positions'],"qms_resultat analyse planetes");
		if($pub_show_result==$radioJ)
			list($tableau,$titre,$help_txt) = 
			Array (Interpolation("joueur",$pub_nb_rapport,$pub_periodes),$lang['qms_analyse_perso'].$lang['qms_joueurs'],"qms_resultat analyse joueurs");
		if($pub_show_result==$radioA)
			list($tableau,$titre,$help_txt) = 
			Array (Interpolation("alliance",$pub_nb_rapport,$pub_periodes),$lang['qms_analyse_perso'].$lang['qms_alliances'],"qms_resultat analyse alliances");
	}
	if($pub_recherche==$boutonT)	{
		if($pub_show_result==$radioP)
			list($tableau,$titre,$help_txt) = 
			Array ($lang['qms_analyse_fonction_non_dispo'],$lang['qms_analyse_globale'].$lang['qms_positions'],"qms_resultat analyse planetes global");
		if($pub_show_result==$radioJ)
			list($tableau,$titre,$help_txt) = 
			Array (analyse_globale($pub_periodes,$pub_nb_rapport,"joueur"),$lang['qms_analyse_globale'].$lang['qms_joueurs'],"qms_resultat analyse joueurs global");
		if($pub_show_result==$radioA)
			list($tableau,$titre,$help_txt) = 
			Array (analyse_globale($pub_periodes,$pub_nb_rapport,"alliance"),$lang['qms_analyse_globale'].$lang['qms_alliances'],"qms_resultat analyse alliances global");
	}
	echo"\n<fieldset><legend><b><font color='#80FFFF'>".$titre." ".help($help_txt)."</font></b></legend>\n";
	echo $tableau;
	echo"<br/><form action='index.php?action=$mod_name&page=analyse' method='post'>";
	echo"<input type='submit' name='beback' value='".$lang['qms_analyse_beback']."' ></form>";
	echo "</fieldset>\n";
}

?>

<script type="text/javascript">
function chk_nb(name,defaut_value) {
	var txt_zone = document.getElementById(name);
	if (isNaN(txt_zone.value))
	{
		alert("Il faut sasir des chiffres...");
		txt_zone.value = defaut_value;
		return false;
	}
	return true;
}
</script>