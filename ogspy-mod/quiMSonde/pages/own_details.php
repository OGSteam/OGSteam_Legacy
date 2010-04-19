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
global $user_data,$bbcode_global;

// Vision global ?
if(!isset($pub_viewall)) $pub_viewall = 0;

// On récupére les dates enregistrées
$date_end = get_qms_config('time_end',$user_data['user_id']);
$date_start = get_qms_config('time_start',$user_data['user_id']);

// Si elles ne sont pas valable, on les adapte
if($date_end<1) $date_end = time();
if($date_start<1) $date_start = $date_end-3600*24*30;

// Si la date de fin a moins de 36h on l'ajuste a la date actuelle
if((time()-$date_end)<(3600*36)) $date_end = time();


// Si l'utilisateur les a modifiée
if(isset($pub_user_time_end)&&preg_match_all($lang['qms_format_date_regex'],$pub_user_time_end,$date)) 
	$date_end = mktime(0,0,0,intval($date[2][0]),intval($date[1][0]),intval($date[3][0]));
if(isset($pub_user_time_start)&&preg_match_all($lang['qms_format_date_regex'],$pub_user_time_start,$date)) 
	$date_start = mktime(0,0,0,intval($date[2][0]),intval($date[1][0]),intval($date[3][0]));

// Inversion
if($date_start > $date_end){
	$retour .= sprintf($lang['qms_details_date_error'],$pub_user_time_start,$pub_user_time_end);
	$temp = $date_start;
	$date_start = $date_end;
	$date_end = $temp;
}

// Sauvegarde des dates définitives
set_qms_config($date_start,'time_start',$user_data['user_id']);
set_qms_config($date_end,'time_end',$user_data['user_id']);
$pub_user_time_end = date("d/m/Y",$date_end);
$pub_user_time_start = date("d/m/Y",$date_start);
if (isset($retour))	echo"<blink>$retour</blink>";

// Début du cadre
echo"<fieldset>\n<legend><b><font color='#80FFFF'>".($pub_viewall==0?$lang['qms_menu_mes_details']:$lang['qms_menu_hall_of_fame']);
echo help($pub_viewall==0?'qms_mes détails':'qms_hall of fame')."</font></b></legend>\n";
// Dessin du formulaire de choix de l'intervalle
echo"<form action='index.php?action=$mod_name&page=$pub_page' method='post'>";
echo $lang['qms_details_intervalle'];
$param = "type='text' size='11' maxlength='10' align='center'";
echo"du <input name='user_time_start' id='user_time_start' value='$pub_user_time_start' $param  > ";
echo"au <input name='user_time_end' id='user_time_end' value='$pub_user_time_end' $param  > ";
echo"<input value='envoyer' type='submit'></th>\n";
echo"</form>";
define("FROM_DETAILS",1);
include_once "calendar.php";

/*/ Choix de la cible des stats
echo"<br/>\n";
echo"<form action='index.php?action=$mod_name&page=$pub_page' method='post'>";
echo"<b>Statistiques pour : </b><br /> ";
echo"<select name='user_filtre_by'>\n";
echo make_liste_string('cible',$pub_user_filtre_by,isset($pub_viewall)?'0':'1'); 
echo"</select>\n";
echo"</form>";//*/
echo"<br/>\n";
// On récupére la liste complète des espionnations du joueurs
$table_spy=get_spies($pub_viewall==0?$user_data['user_id']:0,"`datadate`> '$date_start' AND `datadate` < '$date_end'");

if($table_spy!=false){
	// Calcul des statistiques des Joueurs espions pour affichage du Top5
	$table_espion = get_spy_statistique_of_type($table_spy,'joueur',10);
	$table_espion['link'] = get_spy_type_tooltip($table_espion,10,$lang['qms_details_graphic_of'].$lang['qms_joueurs']);
	$table_espion['titre'] = $lang['qms_details_top5_player'];
	$table_espion['id'] = "espion";
	
	// Calcul des statistiques des Alliances pour affichage du Top5
	$table_ally = get_spy_statistique_of_type($table_spy,'alliance',10);
	$table_ally['link'] = get_spy_type_tooltip($table_ally,10,$lang['qms_details_graphic_of'].$lang['qms_alliances'],1);
	$table_ally['titre'] = $lang['qms_details_top5_ally'];
	$table_ally['id'] = "ally";

	// Calcul des statistiques des Cibles pour affichage du Top5
	$table_cible = get_spy_statistique_of_type($table_spy,'cible',($pub_viewall?10:0));
	$table_cible['link'] = get_spy_type_tooltip($table_cible,($pub_viewall?10:0),$lang['qms_details_graphic_of'].$lang['qms_cibles']);
	$table_cible['titre'] = $lang['qms_details_top5_position'];
	$table_cible['id'] = "cible";
	foreach($table_cible['data'] as $key => $cible)
		if($pub_viewall)
			$table_cible['data'][$key] = $cible." - ".get_user_name_by_id(get_user_data_from_coord('user_id',$cible));
		else
			$table_cible['data'][$key] = $cible." - ".get_user_data_from_coord('planet_name',$cible);

	// Calcul des statistiques des horraires pour affichage du Top5
	$table_heure = get_spy_statistique_of_type($table_spy,'heure',0,'data','asc');
	$table_heure['link'] = get_spy_type_tooltip($table_heure,0,$lang['qms_details_graphic_of'].$lang['qms_hours'],1);
	$tmp = $table_heure['link'];
	$table_heure = get_spy_statistique_of_type($table_spy,'heure');
	$table_heure['link'] = $tmp;
	$table_heure['titre'] = $lang['qms_details_top5_hour'];
	$table_heure['id'] = "heure";

	// Calcul des statistiques des jours pour affichage du Top5
	$table_jour = get_spy_statistique_of_type($table_spy,'jour',0,'data','asc');
	$tmp = get_spy_type_tooltip($table_jour,0,$lang['qms_details_graphic_of'].$lang['qms_days']);
	$table_jour = get_spy_statistique_of_type($table_spy,'jour');
	$table_jour['link'] = $tmp;
	$jour_intense = $table_jour['data'][0];
	$jour_intense_cnt = $table_jour['count'][0];
	$i = count($table_jour['data'])-1;
	$jour_calme = $table_jour['data'][$i];
	$jour_calme_cnt = $table_jour['count'][$i];
	$table_jour['titre'] = $lang['qms_details_top5_day'];
	$table_jour['id'] = "jour";
	$table_distance2 = get_spy_statistique_of_type($table_spy,'distance');
	$table_distance2['titre'] = $lang['qms_details_top5_distance'];
	$table_distance2['id'] = "distance";

	// Calcul des statistiques des galaxies et des distances pour en sortir les 2 records
	$table_galaxy = get_spy_statistique_of_type($table_spy,'galaxie');
	$table_galaxy['link'] = get_spy_type_tooltip($table_galaxy,0,$lang['qms_details_graphic_of'].$lang['qms_galaxies'],1);
	$table_distance = get_spy_statistique_of_type($table_spy,'distance',0,'data','desc');
	$table_distance2['link'] = get_spy_type_tooltip($table_distance,0,$lang['qms_details_graphic_of'].$lang['qms_distances'],1);
	foreach($table_distance['data'] as $key => $distance)
		$table_distance['data'][$key] = $distance." (".get_clear_distance($distance).")";
	foreach($table_distance2['data'] as $key => $distance)
		$table_distance2['data'][$key] = $distance." (".get_clear_distance($distance).")";

	// Calcul des variables des statistiques générales
	$pourcent_moyen = get_pourcentage_moyen($table_spy);
	$distance_moyen = get_distance_moyen($table_spy);
	$time_analyse = get_time_analyse($table_spy);

	// Definition des statistiques générale
	$table_statistique = Array (
	Array (	
	'labelG' => $lang['qms_details_most_curious_player'], 
	'linkG' => '', 
	'dataG' => $table_espion['data'][0], 
	'countG' => $table_espion['count'][0],
	'labelD' => $lang['qms_details_most_curious_ally'], 
	'linkD' => '', 
	'dataD' => $table_ally['data'][($table_ally['data'][0]==""&&isset($table_ally['data'][1])?1:0)], 
	'countD' => $table_ally['count'][($table_ally['data'][0]==""&&isset($table_ally['data'][1])?1:0)] ),
	Array (	
	'labelG' => $lang['qms_details_most_spyed_position'], 
	'linkG' => '', 'dataG' => $table_cible['data'][0], 
	'countG' => $table_cible['count'][0],
	'labelD' => $lang['qms_details_coolest_position'], 
	'linkD' => '', 
	'dataD' => $table_cible['data'][count($table_cible['data'])-1], 
	'countD' => $table_cible['count'][count($table_cible['data'])-1] ),
	Array (	
	'labelG' => $lang['qms_details_pourcent_moy'],
	'linkG' => '', 
	'dataG' => "<font color='".get_color($pourcent_moyen)."'>$pourcent_moyen%</font>", 
	'countG' => '',
	'labelD' => $lang['qms_details_distance_moy'], 
	'linkD' => '', 
	'dataD' => 
"<font color='".get_color($distance_moyen,$table_distance['data'][count($table_distance['data'])-1],$table_distance['data'][0])."'>$distance_moyen ".($distance_moyen<=1000?"":"(".get_clear_distance($distance_moyen).")")."</font>" , 
	'countD' => '' ),
	Array (	
	'labelG' => $lang['qms_details_distance_max'], 
	'linkG' => '', 
	'dataG' => "<font color='red'>".$table_distance['data'][0]."</font>", 'countG' => $table_distance['count'][0],
	'labelD' => $lang['qms_details_distance_min'], 
	'linkD' => '', 
	'dataD' => "<font color='white'>".$table_distance['data'][count($table_distance['data'])-1]."</font>", 
	'countD' => $table_distance['count'][count($table_distance['data'])-1] ),
	Array (	
	'labelG' => $lang['qms_details_cool_depuis'], 
	'linkG' => $time_analyse['link_moyenne'], 
	'dataG' => $time_analyse['since'], 
	'countG' => '',
	'labelD' => $lang['qms_details_cool_le_plus'], 
	'linkD' => $time_analyse['link_table+cool'], 
	'dataD' => $time_analyse['+cool'], 
	'countD' => '' ),
	Array (	
	'labelG' => $lang['qms_details_coolest_hour'], 
	'linkG' => '', 
	'dataG' => $table_heure['data'][count($table_heure['data'])-1]."h", 
	'countG' => $table_heure['data'][count($table_heure['data'])-1],
	'labelD' => $lang['qms_details_horny_hour'], 
	'linkD' => '', 
	'dataD' => $table_heure['data'][0]."h", 
	'countD' => $table_heure['count'][0] ),
	Array (	
	'labelG' => $lang['qms_details_horny_day'], 
	'linkG' => '', 
	'dataG' => $jour_intense, 
	'countG' => $jour_intense_cnt,
	'labelD' => $lang['qms_details_coolest_day'], 
	'linkD' => '', 
	'dataD' => $jour_calme, 
	'countD' => $jour_calme_cnt ),
	Array (	
	'labelG' => $lang['qms_details_horny_galaxy'], 
	'linkG' => $table_galaxy['link'], 
	'dataG' => $table_galaxy['data'][0], 
	'countG' => $table_galaxy['count'][0],
	'labelD' => $lang['qms_details_nb_spy'], 
	'linkD' => '', 
	'dataD' => count($table_spy['cible']), 
	'countD' => '' )
	);

	// Affichage du tableau des stats
	$bbcode_global = "";
	$stats_bbcode_link = draw_textbox_for_bbcode('stats',$lang['qms_details_statistique'],get_bbcode_statistique($table_statistique,$pub_viewall));
	echo"\n\n<!-- Les Statistiques -->\n";
	echo"<table>\n<tr>\n\t<td class='l' colspan='4'>".$lang['qms_details_statistique']."</td>\n";

	// Affichage du tableau des stats
	foreach($table_statistique as $a){
		echo"<tr>\n";
		echo"\t<td class='b' align='center' width='150'><b>".$a['labelG']."</b></td>\n";
		$data = "<b>".$a['dataG']."</b>";
		if($a['linkG']!='') $data = "<a ".$a['linkG'].">".$data."</a>";
		if($a['countG']!='') $data = $data." <sup>".$a['countG']."</sup>";
		echo"\t<td class='c' align='center' width='150'>".$data."</td>\n";
		echo"\t<td class='b' align='center' width='150'><b>".$a['labelD']."</b></td>\n";
		$data = "<b>".$a['dataD']."</b>";
		if($a['linkD']!='') $data = "<a ".$a['linkD'].">".$data."</a>";
		if($a['countD']!='') $data = $data." <sup>".$a['countD']."</sup>";
		echo"\t<td class='c' align='center' width='150'>".$data."</td>\n";
		echo"</tr>\n";
	}
	echo"</table>\n";
	echo"<br/><br/>\n";


	// Affichage des TOP5
	echo"\n\n<!-- Les TOP5 -->\n\n";

	// Top Espion et Alliance
	echo"<table width='600'><tr><td align='center'>\n";
	echo draw_table_top5($table_espion,"",$pub_viewall);
	echo"</td><td align='center'>\n";
	echo draw_table_top5($table_ally,"",$pub_viewall);
	echo"</td></tr></table><br/>\n\n";

	// Top Cible et Heure
	echo"<table width='600'><tr><td align='center'>\n";
	echo draw_table_top5($table_cible,"",$pub_viewall);
	echo"</td><td align='center'>\n";
	echo draw_table_top5($table_heure,"h",$pub_viewall);
	echo"</td></tr></table><br/>\n\n";

	// Top jour
	echo"<table width='600'><tr><td align='center'>\n";
	echo draw_table_top5($table_jour,"",$pub_viewall);
	echo"</td><td align='center'>\n";
	echo draw_table_top5($table_distance2,"",$pub_viewall);
	echo"</td></tr></table>\n\n";
	$bbcode_link = draw_tooltip_for_bbcode_global(
			Array('stats',$table_espion['id'],$table_ally['id'],$table_cible['id'],$table_heure['id'],$table_jour['id'],$table_distance2['id']),
			Array('Les Statistiques',$table_espion['titre'],$table_ally['titre'],$table_cible['titre'],$table_heure['titre'],$table_jour['titre'],$table_distance2['titre'])
																	);
	echo "<br/> BBCode de toute la page : <a style=\"cursor: pointer;\" ".$bbcode_link."><img src=".$image_bbcode."></a><br/>";
} else 
	echo $lang['qms_details_no_statistique']."<br/>\n";
echo"<!-- fin page ".$pub_page.".php -->\n";
echo"</fieldset>";

//-------------------------------------------------------------------------------------------------------------------
// Renvoi un tableau composé de la liste $colonne et du count de chacune des lignes
function get_spy_statistique_of_type($table,$type,$limite = 0,$sort_by='count',$sort_ord='desc'){
	global $day_array;
	$spy_type_list = get_spy_type_liste($table,$type);
	$spy_type_list = get_spy_type_sorted($spy_type_list,$sort_by,$sort_ord);
	$max=$min=0;
	for($i=0;$i<count($spy_type_list['count']);$i++){
		if($spy_type_list['count'][$max]<$spy_type_list['count'][$i]) $max=$i;
		if($spy_type_list['count'][$min]>$spy_type_list['count'][$i]) $min=$i;
	}
	$spy_type_list['min'] = $min;
	$spy_type_list['max'] = $max;
	if($type=='jour'){
		foreach($spy_type_list['data'] as $key=> $tmp)
			$spy_type_list['data'][$key] = $day_array[$tmp];
	}
	return $spy_type_list;
}
function get_spy_type_sorted($table,$sort_by,$sort_ord){
	$tmp_tab = get_list_order($table,$sort_by,$sort_ord);
	for($i=0;$i<count($tmp_tab);$i++){
		$tab['count'][$i] = $table['count'][$tmp_tab[$i]];
		$tab['data'][$i] = $table['data'][$tmp_tab[$i]];
	}
	return $tab;
}
function get_spy_type_tooltip($table,$limite,$titre,$ttLeft=0){
	global $mod_name,$graphid,$lang;
	$graphid+=1;
	$notab = false;$cnt=0;
	$ligne1=$ligne2=$ligne3=$legend=$value="";
	if($limite==0 || $limite>count($table['data'])) $limite = count($table['data']);
	$notab = ($limite>25);
	for($i=0;$i<$limite;$i++){
		if(!$notab){
			$ligne1 .= "<td class=\"c\" align=\"center\">".$table['data'][$i]."</td>";
			$color = get_color($table['count'][$i],$table['count'][$table['min']],$table['count'][$table['max']]);
			$ligne2 .= "<th><font color=\"".$color."\">".$table['count'][$i]."</font></th>";
		}
		$data_tmp=str_replace(Array(' ',':','?'),Array('%20','%20',$lang['qms_joueur_inconnu']),$table['data'][$i]);
		if($data_tmp=="") $data_tmp="-";
		if($value=="") $value = $table['count'][$i]; else $value .= "_x_".$table['count'][$i];
		if($legend=="") $legend = $data_tmp; 
		else 
			if(!$notab) 
				$legend .= "_x_".$data_tmp; 
			else {
				$cnt++;
				if($cnt==round($limite/7)){
					$legend .= "_x_".$data_tmp;
					$cnt=0;
				}else
					$legend .= "_x_";
			}
	}
	$ligne3 .= "<th colspan=\'$limite\'><center><img alt=\'".$lang['qms_nograph']."\' title=\'$titre\' src=\'index.php?action=$mod_name&page=graph&values=".$value."&legend=".$legend."&title=".$titre."\'></center></th>";
	$link = "<table witdh=\'350px\'>".($notab?"":"<tr>$ligne1</tr><tr>$ligne2</tr>")."<tr>$ligne3</tr></table>";
	$code = "<table id=\'graph_$graphid\'> ";
	$code .= "<tr><td>".$link."</td></tr>";
	$code .= "</table>";
	$code = htmlentities($code);
	$link = " onmouseover=\"this.T_WIDTH=220;this.T_TEMP=15000;".($ttLeft==1?"this.T_LEFT=true;":"")."return escape('".$code."')\"";
	return $link;
}
function get_spy_type_liste($spy_list,$type){
	global $mod_name;
	$max_spy=count($spy_list['cible']);
	$nb_type = $total = $galaxie= 0;
	$legend = $titre = $value ="";
	$tab_out['type'] = $type;
	if($type=='heure'){ $type='datadate'; $date="H";}
	if($type=='jour'){ $type='datadate'; $date="J";	}
	if($type=='galaxie'){ $type='position'; $galaxie=1;}
	foreach($spy_list[$type] as $data_type){
		if($type=='datadate'&&$date=="H") $data_type = date("G",$data_type);
		if($type=='datadate'&&$date=="J") $data_type = date("w",$data_type);
		if($type=='position'&&$galaxie==1){ $tmp = get_coord($data_type); $data_type = "G".$tmp[0];}
		$done=false;
		for($i=0;$i<$nb_type;$i++){
			if($tab_out['data'][$i]==$data_type){
				$tab_out['count'][$i]+=1;
				$done = true;
			}
		}
		if(!$done){
			$tab_out['data'][$nb_type]=$data_type;
			$tab_out['count'][$nb_type]=1;
			$nb_type+=1;
		}
	}
	return $tab_out;
}

// Dessin d'une table TOP5
function draw_table_top5($table,$add_to_data="",$pub_viewall){
	global $image_bbcode,$image_graph;
	$bbcode = get_bbcode_top5($table,$add_to_data,$pub_viewall);
	$bbcode_link = draw_textbox_for_bbcode($table['id'],$table['titre'],$bbcode);
	$ligne = "<!-- ".$table['titre']." -->\n";
	$ligne .= "<table width='280'>\n<tr>";
	$ligne .="<td colspan='2' class='l'><b>".$table['titre']."</b></td>";
	$max_i = count($table['count']);
	if($max_i>5) $max_i = 5;
	for($i=0;$i<$max_i;$i++)
		$ligne .="</tr>\n<tr><td class='c' align='center' width='80%'>".($table['data'][$i]==""?"-":$table['data'][$i]).$add_to_data."</td><th>".$table['count'][$i]."</th>";
	$ligne .="</tr>\n<tr>";
	$ligne .="<td align='left'><a  style=\"cursor: cross;\" ".$table['link']."><img src=".$image_graph."></a></td>";
	$ligne .= "</tr>\n</table>\n";
 return $ligne;
}

// Dessin du cadre qui va afficher le BBCode avec un renoi du lien pour l'afficher
function draw_textbox_for_bbcode($id,$titre,$bbcode){
	$prm="'bbcode_".$id."_textbrut','bbcode_".$id."_text','bbcode_".$id."_list','bbcode_".$id."_color1','bbcode_".$id."_color2'";
	$code = "<!-- ".$titre." en BBCode -->\n";
	$code .= "<textarea id=\"bb_".$id."_textbrut\" style=\"position:fixed; visibility:hidden;\">\n";
	$code .= $bbcode;
	$code .= "\n</textarea>";
	echo $code;
	$link = " onclick=\"update_bbcode($prm); document.getElementById('bbcode_".$id."_div').style.visibility = 'visible';\"";
	return $link;
}

// Création du BBCode pour les statistiques 
function remove_html($text){
	return ereg_replace("<[^>]*>","",$text);
}
function get_bbcode_footer(){
	global $version,$lang;
	$foot = sprintf($lang['qms_details_bbcode_footer'],$version,date($lang['qms_format_full'], time()))."\n";
	return $foot;
}
function get_bbcode_statistique($tab,$pub_viewall){
	global $user_data,$bbcode_global,$lang;
	$bbcode="";
	if($pub_viewall==0)
		$bbcode.=sprintf($lang['qms_details_bbcode_stat_titre'],get_user_name_by_id($user_data['user_id']))."\n";
	else
		$bbcode.=$lang['qms_details_bbcode_hof_titre'];
	$bbcode.="{list_start_stat}";
	foreach($tab as $a){
		$bbcode .= "{list}[color={color1}][b]".remove_html($a['labelG'])."[/b] :[/color] [color={color2}]".remove_html($a['dataG'])."[/color]";
		$bbcode .=($a['countG']!=""?" [color={color3}]([i]".remove_html($a['countG'])."[/i])[/color]\n":"\n");
		$bbcode .= "{list}[color={color1}][b]".remove_html($a['labelD'])."[/b] :[/color] [color={color2}]".remove_html($a['dataD'])."[/color]";
		$bbcode .=($a['countD']!=""?" [color={color3}]([i]".remove_html($a['countD'])."[/i])[/color]\n":"\n");
	}
	$bbcode.="{list_end}\n";
	$bbcode_global .= "\n\n".$bbcode;
	return $bbcode;
}
// Création du BBCode pour les TOP5
function get_bbcode_top5($tab,$add_to_data,$pub_viewall){
	global $user_data, $bbcode_global,$lang;
	if($pub_viewall==0)
		$bbcode=sprintf($lang['qms_details_bbcode_top5_for_one'],$tab['titre'],get_user_name_by_id($user_data['user_id']))."\n";
	else
		$bbcode=sprintf($lang['qms_details_bbcode_top5_for_all'],$tab['titre'])."\n";
	$bbcode.="{list_start}";
	for($i=0;$i<(count($tab['data'])>5?5:count($tab['data']));$i++){
		$data = remove_html($tab['data'][$i]);
		if($data=="") $data = "-";
		$bbcode .= "{list}[color={color1}][b]".$data.$add_to_data."[/b] :[/color] [color={color2}]".remove_html($tab['count'][$i])."[/color]\n";
	}
	$bbcode.="{list_end}\n";
	$bbcode_global .= $bbcode;
	return $bbcode;
}

function draw_tooltip_for_bbcode_global($id_list,$titre_list){
	global $bbcode_global,$mod_name,$pub_page,$user_data,$lang;
	global $pub_bb_valid,$pub_bb_list,$pub_bb_color1,$pub_bb_color2,$pub_bb_color3,$pub_bb_color4;
	// Changement de réglages pour le BBCode ?
	if(isset($pub_bb_valid)){ 
		$out = "";
		foreach($id_list as $key => $id){
			global ${'pub_ch'.$id};
			$out .= $out==""?(isset(${'pub_ch'.$id})?'1':'0'):"<>".(isset(${'pub_ch'.$id})?'1':'0');
		}
		$out .= "<>".$pub_bb_color1;
		$out .= "<>".$pub_bb_color2;
		$out .= "<>".$pub_bb_color3;
		$out .= "<>".$pub_bb_color4;
		$out .= "<>".(isset($pub_bb_list)?'1':'0');
		set_qms_config($out,"bbc_tab",$user_data['user_id']);
	}
	$cfg=get_qms_config("bbc_tab",$user_data['user_id'],1);
	if($cfg) $data=explode("<>",$cfg);
	else $data = Array (1,1,1,1,1,1,1,"#FF6633","#11FF22","#000000","#FFFFFF",1);
	$id="global";
	$code = "<!-- Toute la page en BBCode -->\n";
	$code .= "<div id=\"bb_div\" name=\"bbcode\" style=\"visibility:hidden;position: fixed; top: 80px; left: 200;z-index: 100;\"> ";
	$code .= "<table width=\"750\"><tr><td class=\"b\" align=\"center\" colspan=\"2\">";
	$code .= $lang['qms_details_bbcode_titre'];
	$code .= "</td></tr><tr><th height=\"100%\" width=\"400\">";
	$code .= "<form method='post' action='index.php?action=$mod_name&page=$pub_page'>";
	$code .= "<textarea id=\"bb_text\" cols=\"100\" rows=\"8\" wrap=\"soft\" readonly=\"readonly\" onClick=\"this.focus(); this.select();\">\n";
	$code .= "\n</textarea>";
	$code .= "</th><td class=\"c\"  width=\"250\" rowspan=\"2\" align=\"right\">";
	$code .= $lang['qms_details_bccode_form_title'];
	$check=$textarea="";
	foreach($id_list as $key => $id){
		if($data[$key]==1) $checked = " checked";
		else $checked = "";
		$code .= $titre_list[$key].
			" <input type=\"checkbox\" name=\"ch$id\" id=\"bb_show_$id\" value=\"1\" onchange=\"update_bbcode()\"$checked><br/>";
		$check .= ($check==""?"bb_show_".$id:"<>bb_show_".$id);
		$textarea .= ($textarea==""?"bb_".$id."_textbrut":"<>bb_".$id."_textbrut");
	}
	$styl = " onchange='update_bbcode()' maxlength ='7' size='7' style='border-style: solid; border-width: 1; color: #C0C0C0;'";
	$code .= $lang['qms_details_bbcode_form_color']."<br/>";
	$code .= $lang['qms_details_bbcode_color_titre'];
	$code .= "<input type=\"text\" id=\"bb_color1\" name=\"bb_color1\" $styl value=\"".$data[7]."\"><br/>";
	$code .= $lang['qms_details_bbcode_color_data'];
	$code .= "<input type=\"text\" id=\"bb_color2\" name=\"bb_color2\" $styl value=\"".$data[8]."\"><br/>";
	$code .= $lang['qms_details_bbcode_color_text'];
	$code .= "<input type=\"text\" id=\"bb_color3\" name=\"bb_color3\" $styl value=\"".$data[9]."\"><br/>";
	$code .= $lang['qms_details_bbcode_form_option_titre']."<br/>";
	$code .= $lang['qms_details_bbcode_form_use_list'];
	if($data[11]==1) $checked = " checked";
	else $checked = "";
	$code .= "<input type=\"checkbox\" id=\"bb_list\" name=\"bb_list\" value=\"Liste\" onchange=\"update_bbcode()\"$checked><br/>";
	$code .= $lang['qms_details_show_apercu'];
	$code .= "<input type=\"checkbox\" id=\"bb_html\" name=\"bb_html\" value=\"Aperçu\" onchange=\"update_html()\"><br/>";
	$code .= $lang['qms_details_apercu_bgcolor'];
	$code .= "<input type=\"text\" id=\"bb_color4\" name=\"bb_color4\" $styl value=\"".$data[10]."\" onchange=\"update_bbcode()\"><br/>";
	$code .= "<br/><input type=\"submit\" name=\"bb_valid\" value=\"".$lang['qms_details_form_save']."\"></form><br/>";
	$code .= "</td></tr><tr><th height=\"100%\" style=\"background-color:#FFFFFF\">";
	$code .= "<div id=\"apercu_div\" style=\"text-align:left; height:150px; width=380px; overflow:scroll; color:#FFFFFF; background-color:#000000;\">&nbsp</div>";
	$code .= "</th></tr><tr><td class=\"b\" align=\"center\" colspan=\"2\">";
	$code .= "<input type=\"submit\" onclick=\"document.getElementById('bb_div').style.visibility = 'hidden';\" value=\"Cacher...\">";
	$code .= "</td></tr></table>";
	$code .= "<input type=\"text\" id=\"bb_check\" value=\"$check\" style=\"visibility:hidden;\"><br/>";
	$code .= "<input type=\"text\" id=\"bb_textarea\" value=\"$textarea\" style=\"visibility:hidden;\"><br/>";
	$code .= "<textarea id=\"bb_footer\" style=\"position:fixed; visibility:hidden;\">\n";
	$code .= get_bbcode_footer();
	$code .= "\n</textarea>";
	$code .= "</div>\n";
	echo $code;
	$link = " onclick=\"update_bbcode(); document.getElementById('bb_div').style.visibility = 'visible';\"";
	return $link;
}
?>
<script type='text/javascript'>
	function update_html()
	{
		var apercu = document.getElementById("bb_html").checked;
		if(apercu)
		{
			var bbcode = bb2html(document.getElementById("bb_text").value);
		}
		else
		{
			var bbcode = "<?php echo $lang['qms_details_apercu_warning']; ?>";
		}
		document.getElementById("apercu_div").style.background = document.getElementById("bb_color4").value;
		document.getElementById("apercu_div").innerHTML = bbcode;
	}
	function update_bbcode()
	{
		var check = document.getElementById("bb_check").value;
		var textarea = document.getElementById("bb_textarea").value;
		var color1=document.getElementById('bb_color1').value;
		var color2=document.getElementById('bb_color2').value;
		var color3=document.getElementById('bb_color3').value;
		var do_list=document.getElementById('bb_list').checked;
		var texte = "";
		if(do_list)
		{
			var list_start='[list=1]';
			var list_start_stat='[list]';
			var list_end='[/list]';
			var list='[*]';
		}else{
			var list_start='';
			var list_start_stat='';
			var list_end='';
			var list='';
		}
		check = check.split('<>');
		textarea = textarea.split('<>');
		for(i=0;i<check.length;i++)
			if(document.getElementById(check[i]).checked)
				texte += document.getElementById(textarea[i]).innerHTML;
		texte += document.getElementById("bb_footer").value;
		texte = texte.replace(RegExp('{color1}', 'g'),color1);
		texte = texte.replace(RegExp('{color2}', 'g'),color2);
		texte = texte.replace(RegExp('{color3}', 'g'),color3);
		texte = texte.replace(RegExp('{list_start_stat}', 'g'),list_start_stat);
		texte = texte.replace(RegExp('{list_start}', 'g'),list_start);
		texte = texte.replace(RegExp('{list_end}', 'g'),list_end);
		texte = texte.replace(RegExp('{list}', 'g'),list);
		if(texte)
			document.getElementById("bb_text").innerHTML = texte;
		else
			document.getElementById("bb_text").innerHTML = "<?php echo $lang['qms_details_no_selection']; ?>";
	update_html()
}

// BBCode to HTML Script by WindPower [aka WindyPower]
// Please do not remove these comments
function bb2html(vari)
{
	vari=vari.replace(/\[img]/g,'<img src="');
	vari=vari.replace(/\[\/img]/g,'" />');
	vari=vari.replace(/\[imgleft]/g,'<img style="float:left;" src="');
	vari=vari.replace(/\[\/imgleft]/g,'" />');
	vari=vari.replace(/\[imgright]/g,'<img style="float:right;" src="');
	vari=vari.replace(/\[\/imgright]/g,'" />');
	vari=vari.replace(/\[imgmap]/g,'<img ismap="ismap" src="');
	vari=vari.replace(/\[\/imgmap]/g,'" />');
	vari=vari.replace(/\[quote]/g,'<div style="background-color:#F0F0F0;"><blockquote>');
	vari=vari.replace(/\[\/quote]/g,'</blockquote></div>');
	vari=vari.replace(/\[code]/g,'<div style="color:#006600;font-weight:bold;">Code :</div><div style="color:#333333;background-color:#F0F0F0;"><code>');
	vari=vari.replace(/\[\/code]/g,'</code></div>');
	vari=vari.replace(/\[b]/g,'<strong>');
	vari=vari.replace(/\[\/b]/g,'</strong>');
	vari=vari.replace(/\[center]/g,'<center>');
	vari=vari.replace(/\[\/center]/g,'</center>');
	vari=vari.replace(/\[i]/g,'<i>');
	vari=vari.replace(/\[\/i]/g,'</i>');
	vari=vari.replace(/\[u]/g,'<u>');
	vari=vari.replace(/\[\/u]/g,'</u>');
	vari=vari.replace(/\[strike]/g,'<strike>');
	vari=vari.replace(/\[\/strike]/g,'</strike>');
	vari=vari.replace(/\[\/color]/g,'</font>');
	vari=vari.replace(/\[\/size]/g,'</div>');
	vari=vari.replace(/\[\/align]/g,'</div>');
	vari=vari.replace(/\[\*]/g,'<li>');
	vari=vari.replace(/\r\n|\r|\n/g, '<br />')
	for(var i=0;i<=vari.length;i++)
	{
		if(vari.substr(i,5)=='[url=')
		{
			var n=0;
			var m=0;
			for(var j=i+4;j<=vari.length;j++)
			{
				if(vari.substr(j,1)==']' && n==0)
				{
					n=j;
				}
			}
			if(n!=0)
			{
				var ur=vari.substring(i+5,n);
				for(var k=n;k<=vari.length;k++)
				{
					if(vari.substr(k,6)=='[/url]' && m==0)
					{
						m=k;
					}
				}
				if(m!=0)
				{
					var st=vari.substring(n+1,m);
					var fina='<a href="'+ur+'" target="_blank">'+st+'</a>';
					vari=vari.substr(0,i)+fina+vari.substr(m+6);
				}
			}
		}
	}
	for(var i=0;i<=vari.length;i++)
	{
		if(vari.substr(i,5)=='[url]')
		{
			var b=0;
			for(var k=i;k<=vari.length;k++)
			{
				if(vari.substr(k,6)=='[/url]' && b==0)
				{
					b=k;
				}
			}
			if(b!=0)
			{
				var ur=vari.substring(i+5,b);
				var fina='<a href="'+ur+'" target="_blank">'+ur+'</a>';
				vari=vari.substr(0,i)+fina+vari.substr(b+6);
			}
		}
	}
	for(var i=0;i<=vari.length;i++)
	{
		if(vari.substr(i,8)=='[quote="')
		{
			var n=0;
			for(var j=i+8;j<=vari.length;j++)
			{
				if(vari.substr(j,2)=='"]' && n==0)
				{
					n=j;
				}
			}
			if(n!=0)
			{
				var au=vari.substring(i+8,n);
				var fina='<div style="color:#006600;font-weight:bold;">'+au+' wrote :</div><div style="background-color:#F0F0F0;"><blockquote>';
				vari=vari.substr(0,i)+fina+vari.substr(n+2);
			}
		}
	}
	for(var i=0;i<=vari.length;i++)
	{
		if(vari.substr(i,7)=='[color=')
		{
			var n=0;
			for(var j=i+7;j<=vari.length;j++)
			{
				if(vari.substr(j,1)==']' && n==0)
				{
					n=j;
				}
			}
			if(n!=0)
			{
				var co=vari.substring(i+7,n);
				var fina='<font color="'+co+'">';
				vari=vari.substr(0,i)+fina+vari.substr(n+1);
			}
		}
	}
	for(var i=0;i<=vari.length;i++)
	{
		if(vari.substr(i,6)=='[size=')
		{
			var n=0;
			for(var j=i+7;j<=vari.length;j++)
			{
				if(vari.substr(j,1)==']' && n==0)
				{
					n=j;
				}
			}
			if(n!=0)
			{
				var si=vari.substring(i+6,n);
				var fina='<div style="font-size:'+si+'px;line-height:normal;">';
				vari=vari.substr(0,i)+fina+vari.substr(n+1);
			}
		}
	}
	for(var i=0;i<=vari.length;i++)
	{
		if(vari.substr(i,7)=='[align=')
		{
			var n=0;
			for(var j=i+7;j<=vari.length;j++)
			{
				if(vari.substr(j,1)==']' && n==0)
				{
					n=j;
				}
			}
			if(n!=0)
			{
				var al=vari.substring(i+7,n);
				var fina='<div align="'+al+'">';
				vari=vari.substr(0,i)+fina+vari.substr(n+1);
			}
		}
	}
	for(var i=0;i<=vari.length;i++)
	{
		if(vari.substr(i,6)=='[list]')
		{
			var n=0;
			for(var j=i+6;j<=vari.length;j++)
			{
				if(vari.substr(j,7)=='[/list]' && n==0)
				{
					n=j;
				}
			}
			if(n!=0)
			{
				var li=vari.substring(i+6,n);
				var fina='<ul>'+li+'</ul>';
				vari=vari.substr(0,i)+fina+vari.substr(n+7);
			}
		}
	}
	for(var i=0;i<=vari.length;i++)
	{
		if(vari.substr(i,8)=='[list=1]')
		{
			var n=0;
			for(var j=i+6;j<=vari.length;j++)
			{
				if(vari.substr(j,7)=='[/list]' && n==0)
				{
					n=j;
				}
			}
			if(n!=0)
			{
				var li=vari.substring(i+8,n);
				var fina='<ol>'+li+'</ol>';
				vari=vari.substr(0,i)+fina+vari.substr(n+7);
			}
		}
	}
	for(var i=0;i<=vari.length;i++)
	{
		if(vari.substr(i,8)=='[list=a]')
		{
			var n=0;
			for(var j=i+6;j<=vari.length;j++)
			{
				if(vari.substr(j,7)=='[/list]' && n==0)
				{
					n=j;
				}
			}
			if(n!=0)
			{
				var li=vari.substring(i+8,n);
				var fina='<ol type="a">'+li+'</ol>';
				vari=vari.substr(0,i)+fina+vari.substr(n+7);
			}
		}
	}
	return vari;
}
</script>