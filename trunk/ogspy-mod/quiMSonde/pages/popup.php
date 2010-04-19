<?php
/**
 * popup.php 

Affiche un espionnage en détail

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// On récupére les données
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Globale
global $mod_name,$user_data,$pub_choix_private;
global $pub_save_cfg,$pub_color_spy,$pub_color_cbl,$pub_export_tab,$pub_export_links;

// Controle si une cible est bien définie et si elle est vallable
if(!isset($pub_target)) exit();
$table_spy = get_spies(0,"id",$pub_target);
if(count($table_spy['id'])<1){ echo sprintf($lang['qms_popup_spy_not_found'],$pub_target); exit(); }

// Ouverture du filedset
echo"<fieldset><legend><b><font color='#80FFFF'>Détail de l'espionnage #$pub_target de ";
echo $table_spy['joueur'][0]." sur ".get_user_name_by_id($table_spy['sender_id'][0])." ".help('qms_vue detail');
echo "</font></b></legend><center>\n";

// Affichage de l'espionnage en style OGame
echo"\t<table width='569'>\n";
echo"\t\t<tr>\n\t\t\t<td class='l' colspan='4' align='center'>";
echo "Espionnage de <b>".$table_spy['joueur'][0]."</b> sur <b>".get_user_name_by_id($table_spy['sender_id'][0])."</b>";
echo"</td>\n\t\t</tr>\n";
echo make_spy_OGameStyle($table_spy,0,1);
echo"\t</table>\n<br/>\n";

// Formulaire: sur le membre ou sur tout le serveur?
if(isset($pub_choix_private)&&$pub_choix_private=='false') $private=false; else $private=true;
echo"<form action='index.php?action=$mod_name&page=popup&target=$pub_target' method='post'>\n";
echo"\t<p>".$lang['qms_popup_analyse_sur']."\n";
echo"\t<input type='radio' name='choix_private' value='true' ".($private?"checked":"")." onchange='this.form.submit()' />".$lang['qms_popup_only_me']."\n";
echo"\t<input type='radio' name='choix_private' value='false' ".(!$private?"checked":"")." onchange='this.form.submit()' />".$lang['qms_popup_everyone']."</p>\n";
echo"</form><br/>\n";

// On récupére les espionnages de ce joueur sur la cible choisi
$table_spy = get_spies($private?$user_data['user_id']:0,'joueur',$table_spy['joueur'][0]);

// S'il y a au moins 2 espionnages, Affichage du graphique des horraires
$titre=($private?sprintf($lang['qms_popup_analyse_on'],get_user_name_by_id($table_spy['sender_id'][0])):$lang['qms_popup_analyse_everyone']);
if(count($table_spy['joueur'])>1){
	echo get_top_hour($table_spy,$titre)."\n";
} else {
	echo "<table><tr>";
	echo "<td class=\"l\" align=\"center\">$titre</td>";
	echo "</tr><tr>";
	echo "<td class=\"c\" align=\"center\">".$lang['qms_popup_un_seul_espionnage']."</td>";
	echo "</tr></table>";
}

// On recupére les stats
$distance_moy = get_distance_moyen($table_spy);
$pourcent_moy = get_pourcentage_moyen($table_spy);
	
// Recherche de la distance la plus grande
$tmp=0;
for($i=0;$i<count($table_spy['distance']);$i++)
	if($table_spy['distance'][$i]>$tmp) $tmp=$table_spy['distance'][$i];
$distance_max = $tmp;

// Recherche de la distance la plus courte
$tmp=9999999999;
for($i=0;$i<count($table_spy['distance']);$i++)
	if($table_spy['distance'][$i]<$tmp) $tmp=$table_spy['distance'][$i];
$distance_min = $tmp;

// On créé le tableau qui va accueillir les 3 petits
echo"<br/><br/>\n<table width='569'><tr>";
echo"<td width=\"33%\" align=\"center\">";

// On affiche les stats
echo"\n<table>";
echo"<tr><td class='l' colspan='2' align='center'>".$lang['qms_details_statistique']."</td></tr><tr>";
echo"<td class=\"c\" align=\"center\">	".$lang['qms_details_distance_moy']."</td>";
echo"<th class=\"d\" align=\"center\">$distance_moy</th>";
echo"</tr><tr>";
echo"<td class=\"c\" align=\"center\">".$lang['qms_details_distance_max']."</td>";
echo"<th class=\"d\" align=\"center\">$distance_max</th>";
echo"</tr><tr>";
echo"<td class=\"c\" align=\"center\">".$lang['qms_details_distance_min']."</td>";
echo"<th class=\"d\" align=\"center\">$distance_min</th>";
echo"</tr><tr>";
echo"<td class=\"c\" align=\"center\">	".$lang['qms_details_pourcent_moy']."</td>";
echo"<th class=\"d\" align=\"center\">$pourcent_moy%</th>";
echo"</tr>";
echo"</table>\n";

// On change de case dans le tableau
echo"</td><td width=\"33%\" align=\"center\">";

// On affiche les cibles
// On recupére les favorites
$cible_most=get_most('cible',$table_spy);
$cible_str1=isset($cible_most['data'][0])?"<a>".$cible_most['data'][0]."</a> <sup>".$cible_most['cnt'][0]."</sup>":"&nbsp";
$cible_str2=isset($cible_most['data'][1])?"<a>".$cible_most['data'][1]."</a> <sup>".$cible_most['cnt'][1]."</sup>":"&nbsp";
$cible_str3=isset($cible_most['data'][2])?"<a>".$cible_most['data'][2]."</a> <sup>".$cible_most['cnt'][2]."</sup>":"&nbsp";
$nb_cible_lst = get_list("cible",$private,"`joueur` = '".$table_spy['joueur'][0]."'");
$nb_cible = count($nb_cible_lst);

echo"\n<table>";
echo"<tr><td class='l' colspan='2' align='center'>".$lang['qms_popup_ses_cibles']."</td></tr><tr>";
echo"<td class=\"c\" align=\"center\">".$lang['qms_popup_nombre']."</td>";
echo"<th class=\"d\" align=\"center\">$nb_cible</th>";
echo"</tr><tr>";
echo"<td class=\"c\" align=\"center\">".$lang['qms_popup_la_1ere']."</td>";
echo"<th class=\"d\" align=\"center\">$cible_str1</th>";
echo"</tr><tr>";
echo"<td class=\"c\" align=\"center\">	".$lang['qms_popup_la_2nd']."</td>";
echo"<th class=\"d\" align=\"center\">$cible_str2</th>";
echo"</tr><tr>";
echo"<td class=\"c\" align=\"center\">	".$lang['qms_popup_la_3e']."</td>";
echo"<th class=\"d\" align=\"center\">$cible_str3</th>";
echo"</tr>";
echo"</table>\n";

// On change de case dans le tableau
echo"</td><td width=\"33%\" align=\"center\">";

// On affiche les positions
// On recupére les favorites
$cible_most=get_most('position',$table_spy);
$pos_str1=isset($cible_most['data'][0])?"<a>".$cible_most['data'][0]."</a> <sup>".$cible_most['cnt'][0]."</sup>":"&nbsp";
$pos_str2=isset($cible_most['data'][1])?"<a>".$cible_most['data'][1]."</a> <sup>".$cible_most['cnt'][1]."</sup>":"&nbsp";
$pos_str3=isset($cible_most['data'][2])?"<a>".$cible_most['data'][2]."</a> <sup>".$cible_most['cnt'][2]."</sup>":"&nbsp";
$nb_pos_lst = get_list("position",$private,"`joueur` = '".$table_spy['joueur'][0]."'");
$nb_pos = count($nb_pos_lst);

echo"\n<table>";
echo"<tr><td class='l' colspan='2' align='center'>	".$lang['qms_popup_ses_positions']."</td></tr><tr>";
echo"<td class=\"c\" align=\"center\">	".$lang['qms_popup_nombre']."</td>";
echo"<th class=\"d\" align=\"center\">$nb_pos</th>";
echo"</tr><tr>";
echo"<td class=\"c\" align=\"center\">	".$lang['qms_popup_la_1ere']."</td>";
echo"<th class=\"d\" align=\"center\">".$pos_str1."</th>";
echo"</tr><tr>";
echo"<td class=\"c\" align=\"center\">		".$lang['qms_popup_la_2nd']."</td>";
echo"<th class=\"d\" align=\"center\">".$pos_str2."</th>";
echo"</tr><tr>";
echo"<td class=\"c\" align=\"center\">	".$lang['qms_popup_la_3e']."</td>";
echo"<th class=\"d\" align=\"center\">".$pos_str3."</th>";
echo"</tr>";
echo"</table>\n";

// On ferme le tableau
echo"</td></tr></table>\n";

// Script D'exportation

// Définition des variables
if(isset($pub_save_cfg)) 
	set_qms_config("$pub_color_spy|$pub_color_cbl|".($pub_export_tab?"1":"0")."|".($pub_export_links?"1":"0"),'bbc_pup',$user_data['user_id']);

$link = " onchange='update_bbcode()'";
$cfg=get_qms_config('bbc_pup',$user_data['user_id'],1);
if($cfg) $data=explode("|",$cfg);
else $data = Array ("FF6633","11FF22",1,0);
echo"\n<br/><br/>\n<table width='100%'>";
echo"<tr><td class='l' align='center'>".$lang['qms_popup_bbcode_titre']."</td>";
echo"</tr><tr>";
echo"<td class=\"c\" align=\"center\">";
echo"<form method='post' action='index.php?action=QuiMSonde&page=popup&target=$pub_target'>";
echo $lang['qms_popup_bbcode_spy_color']."<input id='color_spy' name='color_spy' value='".$data[0]."' type='text' size='6' $link>";
echo $lang['qms_popup_bbcode_cible_color']."<input id='color_cbl' name='color_cbl' value='".$data[1]."' type='text' size='6' $link>\n";
echo"<input id='export_tab' name='export_tab' value='1' type='checkbox' ".($data[2]==1?"checked='checked'":"")."$link>".$lang['qms_popup_bbcode_en_tableau']."\n";
echo"<input id='export_links' name='export_links' value='1' type='checkbox' ".($data[3]==1?"checked='checked'":"")."$link>".$lang['qms_popup_bbcode_with_link']."\n";
echo"<input name='save_cfg' value='".$lang['qms_details_form_save']."' type='submit'>\n";
echo"</form>";
echo"</td></tr>";
// Zone BBCode ou HTML
$data=$tag="<>";			// 0 - 1
if(isset($_SERVER['HTTP_HOST']))
	$hote = "http://".$_SERVER['HTTP_HOST'];
else
	$hote = "http://".$HTTP_HOST;
if(isset($_SERVER['PHP_SELF'])){
	$temp_phpself = $_SERVER['PHP_SELF'];
	$hote .= $temp_phpself;
}else
	$hote .= $PHP_SELF;
$table_spy = get_spies(0,"id",$pub_target); // On récupére l'espionnage en question
$data.=$tag.$color_spy = "#FF6633";			// 2
$data.=$tag.$color_cbl = "#11FF22";			// 3
$data.=$tag.$color_proba = "#".get_color($table_spy["pourcentage"][0]);			// 4
$data.=$tag.$chaine_date = date("m-d H:i:s",$table_spy["datadate"][0]);			// 5
$data.=$tag.$chaine_joueur = $table_spy['joueur'][0];			// 6
$data.=$tag.$chaine_alliance = $table_spy['alliance'][0];			// 7
$data.=$tag.$chaine_position = $table_spy['position'][0];			// 8
$data.=$tag.$chaine_nomcible = get_user_data_from_coord('planet_name',$table_spy['cible'][0]);			// 9
$data.=$tag.$chaine_cible = $table_spy['cible'][0];			// 10
$data.=$tag.$chaine_victime = get_user_name_by_id($table_spy['sender_id'][0]);			// 11
$data.=$tag.$chaine_proba = $table_spy['pourcentage'][0];			// 12
$link_joueur = "$hote?action=search&type_search=player&string_search=".$table_spy['joueur'][0]."&strict=on";
$data.=$tag.$link_joueur = str_replace(" ","%20",$link_joueur);			// 13
$link_victime = "$hote?action=search&type_search=player&string_search=".$chaine_victime."&strict=on";
$data.=$tag.$link_victime = str_replace(" ","%20",$link_victime);			// 14
$link_alliance = "$hote?action=search&type_search=ally&string_search=".$table_spy['alliance'][0]."&strict=on";
$data.=$tag.$link_alliance = str_replace(" ","%20",$link_alliance);			// 15
$data.=$tag.$link_position = "$hote?action=galaxy&galaxy=".get_galaxy_link($table_spy["position"][0]);			// 16
$data.=$tag.$link_cible = "$hote?action=galaxy&galaxy=".get_galaxy_link($table_spy["cible"][0]);			// 17
echo"<tr><td class=\"c\" align=\"center\">\n";
echo"<textarea rows='10' id='texte'>"; 
echo"</textarea>\n";
echo"</td></tr></table>";
echo"<input type=\"text\" id=\"data\" value=\"$data\" style=\"visibility:hidden;\">";
echo"<textarea rows='10' id='texte_brut' style=\"visibility:hidden; position:fixed\">"; 
echo"{tab_start}\n";
echo"{tr}{th}{chaine_date}{/th}{th}Contrôle aérospatial{/th}{th}[color=#ff9933]Activité d'espionnage[/color]{/th}{/tr}\n";
echo $lang['qms_popup_bbcode_1'];
if($chaine_alliance!="") 
	echo $lang['qms_popup_bbcode_2'];
echo $lang['qms_popup_bbcode_3'];
echo"</textarea>\n";
// On ferme le cadre
echo "</center></fieldset>\n";

//-------------------------------------------------------------------------------------------------------------------
// Renvoi un tableau recoupant le nombre d'espionnage en fonction des heures
function get_top_hour($tableau,$titre=""){
	global $mod_name,$image_graph,$day_array,$lang;
	$value=$legend=$ligne=$ligne0=$ligne1=$ligne2=$ligne3=$ligne4=$ligne5=$ligne6=$ligne7="";
	$hit0=9999; 
	$hit1=$lemoins=$leplus=$total0=$total1=$total2=$total3=$total4=$total5=$total6=$total7=0;

	// initialisation du tableau et création 1ere ligne : les 24 heures et le total
	$ligne = "<td class=\"c\">".$lang['qms_popup_table_hour_1st_case']."</td>";
	for($i=0;$i<24;$i++){
		$ligne .="<td class=\"c\" align=\"center\">".sprintf($lang['qms_popup_table_hour_case'],$i)."</td>";
	}
	$ligne .= "<td class=\"c\">".$lang['qms_total']."</td>";

	// Création du tableau
	foreach($tableau['datadate'] as $id => $newdate){ 
		$hour=date("G",$newdate);
		$day=date("w",$newdate);
		if(!isset($tab[$hour][$day]['cnt'])){
			$tab[$hour][$day]['cnt'] = 1;
			$tab[$hour][$day]['id'] = $tableau['id'][$id];
		}else{
			$tab[$hour][$day]['cnt'] += 1;
			$tab[$hour][$day]['id'] .= "<>".$tableau['id'][$id];
		}
		if(isset($total_jour_[$day])) $total_jour_[$day] += 1; else $total_jour_[$day] = 1;
		if(isset($total_hour_[$hour])) $total_hour_[$hour] += 1; else $total_hour_[$hour] = 1;
		if(isset($total_jour_[7])) $total_jour_[7] += 1; else $total_jour_[7] = 1;
	}

	// Recherche des maximums et minimums
	foreach($tab as $key_hour => $tab_hour){
		foreach($tab_hour as $key_day => $tab_day){
			if(($a=$tab_day['cnt'])<$hit0){$hit0=$a;$lemoins=Array($a,$key_hour,$key_day);}
			if($a>$hit1){$hit1=$a;$leplus=Array($a,$key_hour,$key_day);}
		}
	}
	$hit0=9999;$hit1=0;
	foreach($total_hour_ as $key => $value){
		if(($a=$value)<$hit0){$hit0=$a;$totalH_min=$a;}
		if($a>$hit1){$hit1=$a;$totalH_max=$a;}
	}
	$hit0=9999;$hit1=0;
	for($i=0;$i<7;$i++){
		if(isset($total_jour_[$i])&&$total_jour_[$i]<$hit0){$hit0=$total_jour_[$i];$totalJ_min=$total_jour_[$i];}
		if(isset($total_jour_[$i])&&$total_jour_[$i]>$hit1){$hit1=$total_jour_[$i];$totalJ_max=$total_jour_[$i];}
	}

	// Création de la table
	for($i=0;$i<24;$i++){
		for($j=0;$j<7;$j++) ${'case'.$j} = "<th>&nbsp</th>";
		$case7 = "<td class=\"c\">&nbsp</td>";
		$total=0;
		if(isset($tab[$i])){
			foreach($tab[$i] as $k_day => $t_day){
				$spy_list=explode("<>",$t_day['id']);
				if(count($spy_list)>6) $height="style=\"overflow-y:scroll;height:".(6*25).";width:275\""; else $height="";
				$tooltip = "<div  $height><center><table width=\"255\"><tr><td class=\"c\">date</td><td class=\"c\">".$lang['qms_from']."</td><td class=\"c\">".$lang['qms_to']."</td></tr>";
				foreach($spy_list as $spy_id){
					$aa=get_spies(0,"id",$spy_id);
					$tooltip .= "<tr><th>".date($lang['qms_format_full'],$aa['datadate'][0])."</th><th>".$aa['position'][0]."</th><th>".$aa['cible'][0]."</th></tr>";
				}
				$tooltip .= "</table></center></div>";
				$tooltip = htmlentities($tooltip);
				$tooltip = " onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip."')\"";
				${'case'.$k_day} = "<th align=\"center\"><a href=\"javascript:void(0)\" $tooltip>";
				${'case'.$k_day} .= "<font color=\"".get_color($t_day['cnt'],$lemoins[0],$leplus[0])."\">".$t_day['cnt']."</font></a></th>";
			}
		}
		if(isset($total_hour_[$i])&&$total_hour_[$i]>0) 
			$case7="<td class=\"c\"><font color=\"".get_color($total_hour_[$i],$totalH_min,$totalH_max)."\">".$total_hour_[$i]."</font></td>";
		for($j=0;$j<8;$j++) ${'ligne'.$j} .= ${'case'.$j};
	}

	// Finalisation : affichage de la derniere colonne.
	for($j=0;$j<7;$j++) 
		${'ligne'.$j} = "<td class=\"c\">".$day_array[$j]."</td>".${'ligne'.$j}."<td class=\"c\">".(isset($total_jour_[$j])?"<font color=\"".($j!=7?get_color($total_jour_[$j],$totalJ_min,$totalJ_max):'#FFFFFF')."\">".$total_jour_[$j]."</font>":"&nbsp")."</td>";

	// Retour du code de la table
	$retour = "<table><tr><td class='c' colspan='26'>$titre</td><tr>$ligne</tr>";
	for($j=0;$j<8;$j++) $retour .= "<tr>".${'ligne'.$j}."</tr>";
	$retour .= "</table>";
	return $retour;
}
?>

<script type='text/javascript'>
	function update_bbcode()
	{
		var texte=document.getElementById("texte_brut").innerHTML;
		var donnees=document.getElementById("data").value;
		var color_spy=document.getElementById("color_spy").value;
		var color_cbl=document.getElementById("color_cbl").value;
		var table=document.getElementById("export_tab").checked;
		var link=document.getElementById("export_links").checked;
		donnees = donnees.split('<>');
		texte = texte.replace(RegExp('{color_spy}', 'g'),color_spy);
		texte = texte.replace(RegExp('{color_cbl}', 'g'),color_cbl);
		texte = texte.replace(RegExp('{color_proba}', 'g'),donnees[4]);
		texte = texte.replace(RegExp('{chaine_date}', 'g'),donnees[5]);
		texte = texte.replace(RegExp('{chaine_joueur}', 'g'),donnees[6]);
		texte = texte.replace(RegExp('{chaine_allliance}', 'g'),donnees[7]);
		texte = texte.replace(RegExp('{chaine_position}', 'g'),donnees[8]);
		texte = texte.replace(RegExp('{chaine_nomcible}', 'g'),donnees[9]);
		texte = texte.replace(RegExp('{chaine_cible}', 'g'),donnees[10]);
		texte = texte.replace(RegExp('{chaine_victim}', 'g'),donnees[11]);
		texte = texte.replace(RegExp('{chaine_proba}', 'g'),donnees[12]);
		if(link){
			texte = texte.replace(RegExp('{link_joueur}', 'g'),"[url="+donnees[13]+"]");
			texte = texte.replace(RegExp('{link_victim}', 'g'),"[url="+donnees[14]+"]");
			texte = texte.replace(RegExp('{link_alliance}', 'g'),"[url="+donnees[15]+"]");
			texte = texte.replace(RegExp('{link_position}', 'g'),"[url="+donnees[16]+"]");
			texte = texte.replace(RegExp('{link_cible}', 'g'),"[url="+donnees[17]+"]");
			texte = texte.replace(RegExp('{link_end}', 'g'),"[/url]");
		}else{
			texte = texte.replace(RegExp('{link_joueur}', 'g'),"");
			texte = texte.replace(RegExp('{link_victim}', 'g'),"");
			texte = texte.replace(RegExp('{link_alliance}', 'g'),"");
			texte = texte.replace(RegExp('{link_position}', 'g'),"");
			texte = texte.replace(RegExp('{link_cible}', 'g'),"");
			texte = texte.replace(RegExp('{link_end}', 'g'),"");
		}
		if(table){
			texte = texte.replace(RegExp('{tab_start}', 'g'),"[table cellspacing='1']");
			texte = texte.replace(RegExp('{td_span}', 'g'),"[td colspan='3']");
			texte = texte.replace(RegExp('{/td}', 'g'),"[/td]");
			texte = texte.replace(RegExp('{tr}', 'g'),"[tr]");
			texte = texte.replace(RegExp('{/tr}', 'g'),"[/tr]");
			texte = texte.replace(RegExp('{th}', 'g'),"[th]");
			texte = texte.replace(RegExp('{/th}', 'g'),"[/th]");
			texte = texte.replace(RegExp('{/table}', 'g'),"[/table]");
		}else{
			texte = texte.replace(RegExp('{tab_start}', 'g'),"");
			texte = texte.replace(RegExp('{td_span}', 'g'),"");
			texte = texte.replace(RegExp('{/td}', 'g'),"");
			texte = texte.replace(RegExp('{tr}', 'g'),"");
			texte = texte.replace(RegExp('{/tr}', 'g'),"");
			texte = texte.replace(RegExp('{th}', 'g'),"");
			texte = texte.replace(RegExp('{/th}', 'g'),"");
			texte = texte.replace(RegExp('{/table}', 'g'),"");
		}
		document.getElementById("texte").innerHTML = texte;
	}
	update_bbcode();
</script>
