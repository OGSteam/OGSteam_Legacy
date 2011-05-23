<?php
/**
 * qms_statistique.php 

Procédures et Fonctions liées aux statistiques

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
function get_espionnage_count($userID=0,$where="",$filtre="",$filtre_data=""){	// Renvoi le nombre total d'espionnage
	global $db;
	if($userID==0&&$filtre=='cible'&&count($test = explode('>',$filtre_data))>1)
		list($userID,$filtre,$filtre_data) = Array(get_user_id_by_name(trim($test[1])),"","");
	$where = "WHERE `sender_id` ".($userID==0?"<>":"=")." '$userID'";
	$where .= ($filtre!=""?" AND `$filtre`":"").($filtre_data!=""?"='$filtre_data'":"");
	$query = "SELECT * FROM ".TABLE_QMS . " " . $where;
	qms_debug("get_espionnage_count : ".$query);
 	$result=$db->sql_query($query);
	$result=$db->sql_numrows($result);
	return $result;
}
function get_list($type,$private,$filtre_where=""){								// Renvoi la liste de tous les $type different
	global $db,$user_data;
	$where = ($private==1?"WHERE `sender_id` = ".$user_data['user_id']:"");
	if($filtre_where!="")
		if($where=="")
			$where = "WHERE ".$filtre_where;
		else
			$where .= " AND ".$filtre_where;
	if($type=='cible')
			$query_limit = "SELECT DISTINCT  `$type`,`sender_id`  FROM `".TABLE_QMS."` $where ORDER BY `sender_id` ASC";
	else
			$query_limit = "SELECT DISTINCT `$type`  FROM `".TABLE_QMS."` $where ORDER BY `$type` ASC";
	$result=$db->sql_query($query_limit);
	if($result=$db->sql_numrows($result)==0)
		$tab = Array ("","");
	else{
		if($type=='cible' && $private!=1){
			$i = 0; $previd = 0;
			while(list($type_data,$sender_id_data)=$db->sql_fetch_row($result)){
				if($sender_id_data!=$previd)
					$tab[$i++] = "---> ".$sender_id_data;
				$tab[$i++] = $type_data;
				$previd = $sender_id_data;
			}
			for($j=0;$j<count($tab);$j++)
				if(count($getsid=explode('>',$tab[$j]))>1)
					$tab[$j] = '---> '.get_user_name_by_id($getsid[1]);
		}else{
			$i = 0;
			while(list($type_data)=$db->sql_fetch_row($result))
				$tab[$i++] = $type_data;
		}
	}
	return $tab;
}
function get_most($data,$tableau){												//Renvoi de la valeur et le nombre de $data le plus trouvé
	static $top1,$cnt1,$top2,$cnt2,$top3,$cnt3;
	$max_spy=count($tableau[$data]);
	$i=0;
	// On defile tous les champ du tableau
	for($a=0;$a<$max_spy;$a++){
		// On recupére le champ de la donnée $data
		$cible=$tableau[$data][$a];
		// Si l'on a une donnée
		if($cible){
			$ok=0;
			// On regarde dans le tableau $tmp si elle y est deja
			for($j=0;$j<$i;$j++)	
				if($tmp['data'][$j]==$cible){
					// Si oui, on incrémente le compte
					$tmp['cnt'][$j]+=1;
					$ok=1;
				}
			if(!$ok){
				// Si non, on ajoute la donnée a la fin du tableau $tmp,
				$tmp['data'][$i]=$cible;
				// Et avec un count à 1.
				$tmp['cnt'][$i]=1;
				$i+=1;
			}
		}
	}	
	if(isset($tmp)) {
		array_multisort($tmp['cnt'], SORT_DESC, SORT_NUMERIC, $tmp['data'], SORT_ASC);
		return $tmp;//array($top1,$cnt1,$top2,$cnt2,$top3,$cnt3);
	}else
		return false;
}
function get_list_order($tableau,$sort="",$ord=""){								// Classer le tableau en fonction d'une donnée ($sort) et d'un sens ($ord)
	if(($sort=='')||($sort=='date')) $sort='datadate';
	if($ord=='') $ord='desc';
	$max_spy=count($tableau[$sort]);
	for($i=0;$i<$max_spy;$i++)
		$tableau_index[$i] = $i;
	for($i=0;$i<$max_spy;$i++){
		$w=$i;
		for($j=$i+1;$j<$max_spy;$j++)	{
			if($sort=="distance"){
				$a=get_distance($tableau["position"][$tableau_index[$j]],$tableau["cible"][$tableau_index[$j]]);
				$b=get_distance($tableau["position"][$tableau_index[$w]],$tableau["cible"][$tableau_index[$w]]);
			}else{
				$a=strtolower($tableau[$sort][$tableau_index[$j]]);
				$b=strtolower($tableau[$sort][$tableau_index[$w]]);
			}
			if( ($a > $b) && ($ord=="desc") ){
				$w=$j;
			}
			if( ($a < $b) && ($ord=="asc") ) {
				$w=$j;
			}
		}
		if($w!=$i){
			$k=$tableau_index[$i];
			$tableau_index[$i]=$tableau_index[$w];
			$tableau_index[$w]=$k;
		}
	}
	return $tableau_index;
}
function get_distance_moyen($tableau){											// Calcul de la distance moyenne des espionnages du $tableau
	$cnt=0; $total=0;
	$max_spy=count($tableau['cible']);
	for($i=0;$i<$max_spy;$i++){
		$dist=get_distance($tableau["cible"][$i],$tableau["position"][$i]);
		$total+=$dist;
		$cnt++;
	}
	if($cnt!=0)
		$retour =  ceil($total/$cnt);
	else
		$retour = 0;
	return $retour;
}
function get_pourcentage_moyen($tableau){										// Renvoi le pourcentage de destruction moyen du $tableau
	$cnt=0; $total=0;
	if(count($tableau['pourcentage'])>0){
		foreach($tableau['pourcentage'] as $pourcent){
			$total+=$pourcent;
			$cnt++;
		}
	}
	if($cnt!=0) $retour =  ceil($total/$cnt);
	else $retour = 0;
	return $retour;
}
function get_time_analyse($tableau){											// Renvoi la période sans espionnage la plus longue
// retour : 
// [0] : Période tranquille la plus longue
// [1] : tag de <a> pour popup sur la période la plus tranquille (qui donne les 3 plus longues période)
// [2] : Temps depuis lequel il n'y a pas eu d'espionnage
// [3] : tag de <a> pour un popup donnant le temps moyen entre les espionnages
	global $lang;
	$best_time1=Array(0,0,0,"");
	$best_time2=Array(0,0,0,"");
	$best_time3=Array(0,0,0,"");
	$prev=0;
	$moyenne_total = 0;
	$moyenne = 0;
	if(count($tableau['id'])>1){
	//	$tab=get_list_order($tableau);
	//	foreach($tab as $i){ 
		for($i=0;$i<count($tableau['id']);$i++){
			$now=$tableau['datadate'][$i];
			$diff = $prev-$now;
			if($prev!=0){
				$moyenne_total += $diff;
				if($best_time1[0]<$diff){
					$best_time3 = $best_time2;
					$best_time2 = $best_time1;
					$best_time1 = Array( $diff, $now, $prev);
				}else if($best_time2[0]<$diff){
					$best_time3 = $best_time2;
					$best_time2 = Array( $diff, $now, $prev);
				}else if($best_time3[0]<$diff){
					$best_time3 = Array( $diff, $now, $prev);
				}
			}
			$prev = $now;
		}
		$moyenne = $moyenne_total/count($tableau['datadate']);
	}
	$last = $tableau['datadate'][0];
	if($last>0){
		$now = time();
		$last_cool_time = $now-$last;
		$last_cool_time = get_format_time($last_cool_time);
	} else
		$last_cool_time = "-";
	$link="";
	if($best_time1[0]>0) {
		$best_time1[3] = get_format_time($best_time1[0]);
		if($best_time2[0]>0) $best_time2[3] = get_format_time($best_time2[0]);
		if($best_time3[0]>0) $best_time3[3] = get_format_time($best_time3[0]);
		$link = "<table width=\"250\"><tr>";
		$link .= "<td class=\"c\" align=\"center\">".$lang['qms_time_analyse_duree']."</td>";
		$link .= "<td class=\"c\" align=\"center\">".$lang['qms_time_analyse_du']."</td>";
		$link .= "<td class=\"c\" align=\"center\">".$lang['qms_time_analyse_au']."</td>";
		$link .= "</tr><tr>";
		$link .= "<th align=\"center\">".$best_time1[3]."</td>";
		$link .= "<th align=\"center\">".date($lang['qms_format_full'], $best_time1[1])."</td>";
		$link .= "<th align=\"center\">".date($lang['qms_format_full'], $best_time1[2])."</td>";
		$link .= "</tr>";
		if($best_time2[0]>0){
			$link .= "<tr>";
			$link .= "<th align=\"center\">".$best_time2[3]."</td>";
			$link .= "<th align=\"center\">".date($lang['qms_format_full'], $best_time2[1])."</td>";
			$link .= "<th align=\"center\">".date($lang['qms_format_full'], $best_time2[2])."</td>";
			$link .= "</tr>";
		}
		if($best_time3[0]>0){
			$link .= "<tr>";
			$link .= "<th align=\"center\">".$best_time3[3]."</td>";
			$link .= "<th align=\"center\">".date($lang['qms_format_full'], $best_time3[1])."</td>";
			$link .= "<th align=\"center\">".date($lang['qms_format_full'], $best_time3[2])."</td>";
			$link .= "</tr>";
		}
		$link .= "</table>";
		$link = htmlentities($link);
		$link = " onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$link."')\"";
	} else
		$best_time1[3] = "-";
	if($moyenne>0){
		$link2 = "<table>";
		$link2 .= "<tr><td class=\"c\" align=\"center\">".$lang['qms_time_analyse_temps_moy']."</td></tr>";
		$link2 .= "<tr><th align=\"center\">".get_format_time($moyenne)."</td></tr>";
		$link2 .= "</table>";
		$link2 = htmlentities($link2);
		$link2 = " onmouseover=\"this.T_WIDTH=180;this.T_TEMP=15000;return escape('".$link2."')\"";
	} else
		$link2 = "";
	return Array("+cool" => $best_time1[3],"link_table+cool" => $link, "since" => $last_cool_time,"link_moyenne" => $link2);
}
function get_format_time($time){												// Renvoi une durée sous la forme de xj xh xm xs.
	$retour = "";
	$time -= 3600;
	if(date("z",$time)>0)	 $retour .= date("z",$time)."j ";
	if(date("h",$time)>0) $retour .= date("H",$time)."h ";
	if(date("i",$time)>0)	$retour .= date("i",$time)."m ";
	$retour .= date("s",$time)."s ";
	return $retour;
}
function get_color($poucentage,$mini=0,$max=100){								// Renvoi la couleur en fonction du pourcentage (0% = blanc, 100% = rouge)
		$valeur = (int) $poucentage - $mini;
		$div=$max-$mini;
		if($div<1) $div=1;
		$couleur=255-($valeur*255/($div));
		if($couleur>16) $couleur=dechex($couleur);
		else $couleur="0".dechex($couleur);
		$couleurHexa="FF".$couleur.$couleur;
		return $couleurHexa;
}
function get_clear_distance($distance){											// Renvoi le nombre de système, galaxie ou planetes correspondant à une distance
	global $lang;
	if($distance>=20000){
		// Plusieurs galaxie
		$retour['nb'] = $distance/20000;
		$retour['type'] = $retour['nb']==1?$lang['qms_galaxie']:$lang['qms_galaxies'];
	}elseif($distance<=1070){
		// Meme systeme
		$retour['nb'] = ($distance-1000)/5;
		$retour['type'] = $retour['nb']==1?$lang['qms_position']:$lang['qms_positions'];
	}else{
		// Plusieurs système
		$retour['nb'] = ($distance-2700)/95;
		$retour['type'] = $retour['nb']==1?$lang['qms_systeme']:$lang['qms_systemes'];
	}
	return round($retour['nb'])." ".$retour['type'];
}
?>