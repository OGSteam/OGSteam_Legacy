<?php
/**
 * qms_sql.php 

Procédures et Fonctions liées aux accès sql

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
function get_spies($userID,$filtre="",$filtre_data="",$sort="",$ord="",$limit=""){	// Création du tableau d'espionnage
	global $db;
	$sort_list = Array('id', 'sender_id','position','joueur','alliance','distance','cible','datadate','pourcentage');
	if(!in_Array($sort,$sort_list)) $sort = "datadate";
	$ord_list = Array('desc' , 'asc' );
	if(!in_Array($ord,$ord_list)) $ord = "desc";
	if($userID==0&&$filtre=='cible'&&count($test = explode('>',$filtre_data))>1)
		list($userID,$filtre,$filtre_data) = Array(get_user_id_by_name(trim($test[1])),"","");
	$s_where = "WHERE `sender_id` ".($userID==0?"<>":"=")." '$userID'";
	$s_where .= ($filtre!=""?" AND ".($filtre_data!=""?"`$filtre`='$filtre_data'":"$filtre"):"");
	$query_limit = "SELECT  `id`, `sender_id` , `position` , `position_name` ,  `joueur` , `alliance` , `distance` , `cible` , `cible_name` , `datadate` ,  `pourcentage` ";
	$query_limit .= "FROM `".TABLE_QMS."` $s_where ORDER BY `$sort` $ord $limit";
	qms_debug("get_spies : ".$query_limit);
	$result=$db->sql_query($query_limit);
	if($result=$db->sql_numrows($result)==0){
		$max_spy=0;
		$table_spy=false;
	}else{
		$i = 0;
		while(list($id, $sender_id, $position, $position_name, $joueur, $alliance, $distance, $cible, $cible_name, $datadate, $pourcentage)=$db->sql_fetch_row($result)){
			$table_spy['id'][$i] = $id;
			$table_spy['sender_id'][$i] = $sender_id;
			$table_spy['position'][$i]	= $position;
			$table_spy['position_name'][$i]	= $position_name;
			$table_spy['joueur'][$i]	= $joueur; 
			$table_spy['alliance'][$i]	= $alliance;
			$table_spy['distance'][$i] = $distance;
			$table_spy['cible'][$i]	= $cible;
			$table_spy['cible_name'][$i]	= $cible_name;
			$table_spy['datadate'][$i]	= $datadate;
			$table_spy['pourcentage'][$i]	= $pourcentage;
			$i++;
		}
		$max_spy = $i;
	}
	return $table_spy;
}
function delete_espionnage($index){													// Effacer un espionnage donné
		global $db;
		$query = "SELECT  `sender_id`  FROM `".TABLE_QMS."` WHERE `id` = '".$index."'";
		$result=$db->sql_query($query);
		list($sender_id)=$db->sql_fetch_row($result);
		$query = "DELETE FROM ".TABLE_QMS." WHERE `id`=".$index." LIMIT 1";
		$db->sql_query($query);
		return 1;
}
function modify_espionnage($index){													// Modifier un espionnage donné
	global $db,$user_data;
	static $result;
	if($index!=0){
		$query = "SELECT joueur, alliance, position FROM ".TABLE_QMS." WHERE `id`='$index' LIMIT 1";
		$db->sql_query($query);
		$nb = $db->sql_numrows($result);
		if ($nb == 0){	
			// Non trouvé
			return 2;
		}
		list($joueur,$alliance,$position)=$db->sql_fetch_row($result);
		list($name,$ally)=get_user_id($position);
		if($name=="") $name = "?";
		if($joueur!=$name || $alliance!=$ally){
			$query = "UPDATE ".TABLE_QMS." SET `joueur`='$name', `alliance`='$ally' WHERE `id`='$index' LIMIT 1";
			$db->sql_query($query);
			return 1;
		}
	}
	return 0;
}
function modify_all_espionnage($index_tab){											// Modifier plusieurs espionnage
	$indexx = explode('_x_', $index_tab);
	foreach($indexx as $index)
		modify_espionnage($index);
	return 1;
}
function Interpolation($data,$nombre_mini,$periodes){								// Procédure d'interpolation Joueur/Alliance (MERCI SANTORY!!!!!)
	global $db; global $user_data,$lang;
	static $tableau;
	$leave=0;
	$retour = "";
	$timestamp = time()-(24*60*60*$periodes);
	$datadate = mktime (0,0,0,date("m",$timestamp),date("d",$timestamp),date("y",$timestamp));
	$query_limit = "SELECT `position` , count(*) as num, `$data` FROM `".TABLE_QMS."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." GROUP BY `$data` HAVING num >= ".$nombre_mini." ORDER BY $data ASC";
 	$result=$db->sql_query($query_limit);
	if($result=$db->sql_numrows($result)==0){
		if($periodes>1)
			$retour .= "<div align='center'>".sprintf($lang['qms_analyse_nothing_found'],$periodes)."</div>";
		elseif($periodes==1)
			$retour .= "<div align='center'>".$lang['qms_analyse_nothing_found_one_day']."</div>";
		else
			$retour .= "<div align='center'>".$lang['qms_analyse_0_day_selected']."</div>";
		$leave=1;
	}else{
		unset($tableau['cible']);
		$tableau['alliance']=Array();
		while(list($position,$num,$alliance)=$db->sql_fetch_row($result)){
			if($alliance != ''){
	 			$tableau['alliance'][]="'".$alliance."'";
				$alliance_vide = "";
			}else{
				$alliance_vide = " `$data` IS NULL ";
			}
		}
	 	$result_query_limit = join(",", $tableau['alliance']);
		$having = "";
		if($result_query_limit != "")
			$having = "`$data` in (".$result_query_limit.")";
		if($alliance_vide != "")
			if($having != "")
				$having .= " OR ".$alliance_vide;
			else
				$having .= $alliance_vide;
		$query = "SELECT DISTINCT(`cible`) as cible FROM `".TABLE_QMS."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." ORDER BY `cible` asc";
		$result2=$db->sql_query($query);
		$i=0;
		unset($tableau['cible']);
		while(list($cible)=$db->sql_fetch_row($result2))
			 $tableau['cible'][$i++]=$cible;
		$query = "SELECT `position` , `cible` , `datadate`, `$data`, `pourcentage`	FROM `".TABLE_QMS."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." 	HAVING ".$having." ORDER BY `$data` asc, `cible` asc, `position` asc , `datadate` asc";
		$result=$db->sql_query($query);
		$retour .= "<table width='100%'>";
		$retour .= "<tr>";
		$retour .= "<td class='c' align='center'><b>$data</b></td>";
		$retour .= "<td class='c' align='center'><b>".$lang['qms_nombre_total']."</b></td>";
		reset($tableau['cible']);
		foreach($tableau['cible'] as $cible)
 			$retour .= "<td class='c' align='center'><b>".$cible."</b></td>";
		$retour .= "</tr>";
		$lalliance = "-";
		$position_init = "";
		$cible_init = "";
		while(list($position, $cible, $datadate,$alliance,$pourcentage)=$db->sql_fetch_row($result)){
			if($lalliance != $alliance){
				//generation du tableau avec les info du joueur d avant
				if($lalliance!="-"){
					$total = $info['total'];
					$tab[$total][$lalliance]=$info;
					unset($info);
				}
				$lalliance = $alliance;
				$position_init=$position;
				$cible_init = $cible;
				$info['total']=1;
				$info[$cible]['total']=1;
				$info[$cible][$position]['date']=date($lang['qms_format_full'], $datadate)." ( ".$pourcentage."% )";
				$info[$cible][$position]['num']=1;
			}elseif($cible!=$cible_init){
				$cible_init = $cible;
				$position_init=$position;
				$info['total']+=1;
				$info[$cible]['total']=1;
				$info[$cible][$position]['date']=date($lang['qms_format_full'], $datadate)." ( ".$pourcentage."% )";
				$info[$cible][$position]['num']=1;
			}elseif($position!=$position_init){
				$position_init = $position;
				$info['total']+=1;
				$info[$cible]['total']+=1;
				$info[$cible][$position]['date']=date($lang['qms_format_full'], $datadate)." ( ".$pourcentage."% )";
				$info[$cible][$position]['num']=1;
			}else{
				$info['total']+=1;
				$info[$cible]['total']+=1;
				$info[$cible][$position]['date'].="<br />".date($lang['qms_format_full'], $datadate)." ( ".$pourcentage."% )";
				$info[$cible][$position]['num']+=1;
			}
		}
	}
	if($leave==0){
		$total = isset($info['total'])?$info['total']:0;
		$tab[$total][$lalliance] = isset($info)?$info:Array ();
		@krsort($tab);
		$flux = "";
		foreach ($tab as $num => $alliances){
			foreach($alliances as $alliance => $cible){
				$flux .= "<tr>\n";
				$flux .= "<td class='c' align='center'><a  ".get_tooltip($alliance,$data)."><b>".$alliance."</b></a></td>\n";
				$flux .= "<th align='center'>".$num."</th>\n";
				reset($tableau['cible']);
 				foreach($tableau['cible'] as $key){
					if(array_key_exists($key, $cible)){
						$bubule = "";
			 			foreach($cible[$key] as $espion => $info){
							if($espion!="total"){
								$bubule .= "<u>".$espion."</u> : ".sprintf($lang['qms_analyse_nb_scans'],$info['num'])."<br>";
								$bubule .= $info['date']."<br />";
							}
						}
						$text = "<table width=\"200\">";
						$text .= "<tr><td align=\"center\" class=\"c\">".$lang['qms_analyse_horraire_des_sondages']."</td></tr>";
						$text .= "<tr><th align=\"center\">".$bubule."</th></tr>";
						$text .= "</table>";
						$text = htmlentities($text);
						$text = "this.T_WIDTH=210;this.T_TEMP=0;return escape('".$text."')";
			 			$flux .= "<th><a onmouseover=\"".$text."\">".$cible[$key]['total']."</a></th>\n";
					}else{
			 			$flux .= "<th>&nbsp;</th>\n";
					}
				}
				$flux .= "</tr>\n";	
 			}
		}
		$retour .= $flux;
		$retour .= "</table>\n";
	}
	return $retour;
}
function analyse_espionnage($pub_nombre_mini,$pub_periodes){						// Analyse de l'espionnage par planete (MERCI SANTORY!!!)
	global $db; global $user_data,$lang;
	static $tableau;
	$retour = "";
	$timestamp = time()-(24*60*60*$pub_periodes);
	$datadate = mktime (0,0,0,date("m",$timestamp),date("d",$timestamp),date("y",$timestamp));
	$query_limit = "SELECT `position` , count(*) as num  FROM `".TABLE_QMS."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." GROUP BY `position` HAVING num >= ".$pub_nombre_mini;
	$result=$db->sql_query($query_limit);
	if($result=$db->sql_numrows($result)==0){
		if($pub_periodes>1)
			$retour .= "<div align='center'>".sprintf($lang['qms_analyse_nothing_found'],$pub_periodes)."</div>";
		elseif($pub_periodes==1)
			$retour .= "<div align='center'>".$lang['qms_analyse_nothing_found_one_day']."</div>";
		else
			$retour .= "<div align='center'>".$lang['qms_analyse_0_day_selected']."</div>";
	}else{
		unset($tableau['position']);
		while(list($position,$num)=$db->sql_fetch_row($result))
			$tableau['position'][]="'".$position."'";
		$result_query_limit = join(",", $tableau['position']);
		$query = "SELECT `position` , `cible` , `datadate`, `pourcentage` FROM `".TABLE_QMS."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']."	AND `position` in (".$result_query_limit.") ORDER BY `position` asc, `cible` asc, `datadate` asc ";
		$result=$db->sql_query($query);
		$query = "SELECT DISTINCT(`cible`) as cible FROM `".TABLE_QMS."` WHERE `datadate` >= $datadate and `sender_id` = ".$user_data['user_id']." ORDER BY `cible` asc";
		$result2=$db->sql_query($query);
		$i=0;
		unset($tableau['cible']);
		while(list($cible)=$db->sql_fetch_row($result2))
			$tableau['cible'][$i++]=$cible;
		$retour .= "<table width='100%'>
				<tr>
					<td class='c' align='center'>
						<b>Planètes Espion</b>
					</td>
					<td class='c' align='center'>
						<b>Nombre Total</b>
					</td>";
		reset($tableau['cible']);
		foreach($tableau['cible'] as $cible)
			$retour .= "<td class='c' align='center'><b>$cible</b></td>";
		$retour .= "</tr>";
		$position_init = "";
		$cible_init = "";
		while(list($position, $cible, $datadate, $pourcentage)=$db->sql_fetch_row($result)){
			if($position!=$position_init){
				$position_init=$position;
				$cible_init = $cible;
				$info[$position]['total']=1;
				$info[$position][$cible]['date']=date($lang['qms_format_full'], $datadate)." ( ".$pourcentage."% )";
				$info[$position][$cible]['num']=1;      
			}elseif($cible!=$cible_init){
				$cible_init = $cible;
				$info[$position]['total']+=1;
				$info[$position][$cible]['date']=date($lang['qms_format_full'], $datadate)." ( ".$pourcentage."% )";
				$info[$position][$cible]['num']=1;
			}else{
				$info[$position]['total']+=1;
				$info[$position][$cible]['date'].="<br />".date($lang['qms_format_full'], $datadate)." ( ".$pourcentage."% )";
				$info[$position][$cible]['num']+=1;
			}
		}
		$flux = "";
		foreach ($info as $cible => $sub_info){
			$flux .= "<tr>\n";
			$temp = " href='index.php?action=galaxy&galaxy=".
				get_galaxy_link($cible)."'".
				get_tooltip($cible,'Position');
			$flux .= "<td class='c' align='center'><b><a".$temp.">".$cible."</a>".get_spies_string($cible)."</b></td>\n";
			$flux .= "<th align='center'>".$sub_info['total']."</th>\n";
			reset($tableau['cible']);
			foreach($tableau['cible'] as $key){
				if(array_key_exists($key, $sub_info)){
					$text = "<table width=\"200\">";
					$text .= "<tr><td align=\"center\" class=\"c\">".$lang['qms_analyse_horraire_des_sondages']."</td></tr>";
					$text .= "<tr><th align=\"center\">".$sub_info[$key]['date']."</th></tr>";
					$text .= "</table>";
					$text = htmlentities($text);
					$text = "this.T_WIDTH=210;this.T_TEMP=0;return escape('".$text."')";
					$link = "";
					$flux .= "<th><a style='cursor:pointer' $link onmouseover=\"".$text."\">".$sub_info[$key]['num']."</a></th>\n";
				}else{
					$flux .= "<th>&nbsp;</th>\n";
				}
			}
			$flux .= "</tr>\n";   	
		}
		$retour .= $flux;
		$retour .= "</table>\n";
	}
	return $retour;
}
function get_tooltip_spy($spyer,$userid,$datadate,$JorA){							// Renvoi un code de tooltip affichant un tableau listant les espionnages de $spyer sur $userid;
	global $db,$lang;
	static $spies;
	$tooltip = "<table width=\"250\">";
	if($JorA=="Alliance"){
		$colspan="5";
		$ally_string=$lang['qms_analyse_espionnage_de_alliance'];
	}else{
		$colspan="4";
		$ally_string="";
	}
	$tooltip .= "<tr><td colspan=\"$colspan\" class=\"c\" align=\"center\">";
	$tooltip .= sprintf($lang['qms_analyse_espionnage_de_sur'],$ally_string,$spyer,get_user_name_by_id($userid))."</td></tr>";

	$tooltip .= "<tr><td class=\"c\" align=\"center\">".$lang['qms_analyse_tableau_date']."</td>";
	if($JorA=="Alliance")
		$tooltip .= "<td class=\"c\" align=\"center\">".$lang['qms_analyse_tableau_joueur']."</td>";
	$tooltip .= "<td class=\"c\" align=\"center\">".$lang['qms_analyse_tableau_de']."</td>";
	$tooltip .= "<td class=\"c\" align=\"center\">".$lang['qms_analyse_tableau_vers']."</td>";
	$tooltip .= "<td class=\"c\" align=\"center\">".$lang['qms_analyse_tableau_pourcent']."</td></tr>";
	if($JorA=="Alliance")
		$JorA_string = "alliance`,`joueur";
	else
		$JorA_string = $JorA;
	$query_limit = "SELECT `datadate`,`position`, `cible`,`pourcentage`,`alliance`,`joueur` FROM `".TABLE_QMS."` WHERE `sender_id` = ".$userid." AND `$JorA`='".$spyer."' AND `datadate` >= $datadate   ORDER BY `datadate` DESC";
	$result=$db->sql_query($query_limit);
	if($result=$db->sql_numrows($result)==0){
		// Nothing...
	}else{
		while(list($datadate,$position,$cible,$pourcentage,$alliance,$joueur)=$db->sql_fetch_row($result)){
			$tooltip .= "<tr><th>".date($lang['qms_format_full'], $datadate)."</th>";
			if($JorA=="Alliance")
				$tooltip .= "<th>".$joueur."</th>";
			$linking = get_galaxy_link($position);
			$spies = get_spies_string($cible);
			if($spies!="") $spies = " ".$spies;
			$tooltip .= "<th><a href=\"index.php?action=galaxy&galaxy=$linking\">$position</a>$spies</th>";
			$linking = get_galaxy_link($cible);
			$tooltip .= "<th><a href=\"index.php?action=galaxy&galaxy=$linking\">$cible</a></th>";
			$tooltip .= "<th>$pourcentage%</th></tr>";
		}
	}
	$tooltip .= "</table>";
	$tooltip = htmlentities($tooltip);
	$retour = " onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip."')\"";
	return $retour;
}
function analyse_globale($periodes,$nb_rapport,$JorA){								// Analyse des espionnages de TOUT le serveur.
	global $db,$user_data,$lang;
	static $count_spy;
	$retour = "";
	$leave=0;
	$timestamp = time()-(24*60*60*$periodes);
	$datadate = mktime (0,0,0,date("m",$timestamp),date("d",$timestamp),date("y",$timestamp));
	$query_limit = "SELECT DISTINCT `$JorA` FROM ".TABLE_QMS." WHERE `datadate` >= $datadate";
 	$result=$db->sql_query($query_limit);
	if($result=$db->sql_numrows($result)==0) return "<div align='center'>".sprintf($lang['qms_analyse_no_spy_to_recoup'],$periodes)."</div>";

	$i=0;
	while(list($joueur)=$db->sql_fetch_row($result)){
		$tab['joueur'][$i++]=$joueur;
	}
	if($i<2) return "<div align='center'>".sprintf($lang['qms_analyse_no_spy_to_recoup'],$periodes)."</div>";

	$got_one=$i=0;
	foreach($tab['joueur'] as $joueur){
		$query_limit = "SELECT DISTINCT `sender_id`  FROM ".TABLE_QMS." WHERE `datadate` >= $datadate AND `$JorA`='$joueur'";
		$result=$db->sql_query($query_limit);
		if($result=$db->sql_numrows($result)<$nb_rapport){
			// Pas d'espionnage multiple chez ce membre
		}else{
			$got_one = 1;
			$joueurs_trouve[$i++] = "'$joueur'";
		}
	}
	if(!$got_one){
		$retour .= "<div align='center'>".sprintf($lang['qms_analyse_no_spy_for_this_periode'],$nb_rapport,$periodes)."</div>";
		return;
	}
	$joueurs_trouve_list = join(",",$joueurs_trouve);
	$having = "`$JorA` in ($joueurs_trouve_list)";
	$query = "SELECT `id`,`position`,`sender_id`,`$JorA`,`cible`  FROM `".TABLE_QMS."` WHERE `datadate` >= $datadate  HAVING $having ORDER BY $JorA";
	$result=$db->sql_query($query);
	$i=0;
	while(list($id,$position,$sender_id,$joueur,$cible)=$db->sql_fetch_row($result)){
		$tableau['id'][$i]=$id;
		$tableau['sender_id'][$i]=$sender_id;
		$tableau['joueur'][$i]=$joueur;
		if(isset($count_spy[$joueur][$sender_id]))
			$count_spy[$joueur][$sender_id] += 1;
		else
			$count_spy[$joueur][$sender_id] = 1;
		if(isset($count_spy[$joueur]['total']))
			$count_spy[$joueur]['total'] += 1;
		else
			$count_spy[$joueur]['total'] = 1;
		$i++;
	}
	$l=0; $k=0;
	$sender_list = array("","","");
	$spyer_list = array("","","");
	for($i=0;$i<count($tableau['id']);$i++){
		$hit=0;
		for($j=0;$j<count($sender_list);$j++)
			if($tableau['sender_id'][$i]==$sender_list[$j])
				$hit=1;
		if($hit==0)
			$sender_list[$l++] = $tableau['sender_id'][$i];
		$hit=0;
		for($j=0;$j<count($spyer_list);$j++)
			if($tableau['joueur'][$i]==$spyer_list[$j])
				$hit=1;
		if($hit==0){
			$show_order[$k] = $i;
			$spyer_list[$k++] = $tableau['joueur'][$i];
		}
	}
	// Classement de la liste en fonction du nombre d'espionnage.
	for($i=0;$i<count($show_order);$i++){
		$a = $i;
		for($j=$i+1;$j<count($show_order);$j++){
			$b = $j;
			$tmpA = $count_spy[$tableau['joueur'][$show_order[$a]]]['total'];
			$tmpB = $count_spy[$tableau['joueur'][$show_order[$b]]]['total'];
			if($tmpA<$tmpB)
				$a=$b;
		}
		if($a!=$i){
			$tmp = $show_order[$i];
			$show_order[$i]=$show_order[$a];
			$show_order[$a]=$tmp;
		}
	}
	$retour .= "<table width='100%'>\n";
	$retour .= "<tr>\n";
	$retour .= "<td class='c' align='center'><b>$JorA</b></td>\n";
	$retour .= "<td class='c' align='center'><b>".$lang['qms_nombre']."</b></td>\n";
	for($i=0;$i<count($sender_list);$i++)
		$retour .= "<td class='c' align='center'><b>".get_user_name_by_id($sender_list[$i])."</b></td>\n";
	$retour .= "</tr>";
	$final_line=-1;
	for($i=0;$i<count($show_order);$i++){
		if($tableau['joueur'][$show_order[$i]]!="?"){
				$name = $tableau['joueur'][$show_order[$i]];
				$retour .= "<tr>\n";
				$retour .= "<td class='c' align='center'><a ".get_tooltip($name,$JorA)."><b>$name</b></a></th>\n";
				$retour .= "<td class='c' align='center'><b>".$count_spy[$name]['total']."</b></th>\n";
				for($j=0;$j<count($sender_list);$j++){
					$s_id = $sender_list[$j];
					if(isset($count_spy[$name][$s_id])){
						$tooltip="";//get_tooltip_spy($name,$sender_list[$j],$datadate,$JorA);
						$retour .= "<th><a $tooltip><b>".$count_spy[$name][$s_id]."</b></a></th>\n";
					}else
						$retour .= "<th>&nbsp</th>\n";
				}
				$retour .= "</tr>\n";
			}else
			$final_line=$show_order[$i];
	}
	if($final_line!=-1){
		$lastone = $tableau['joueur'][$final_line];
		$retour .= "<tr>\n";
		$retour .= "<td class='c' align='center'><a><b>".$lastone."</b></a></th>\n";
		$retour .= "<td class='c' align='center'><b>".$count_spy[$lastone]['total']."</b></th>\n";
		for($j=0;$j<count($sender_list);$j++){
			$s_id = $sender_list[$j];
			if(isset($count_spy[$lastone][$s_id])){
				$tooltip="";//get_tooltip_spy("?",$sender_list[$j],$datadate,$JorA);
				$retour .= "<th><a $tooltip><b>".$count_spy[$lastone][$s_id]."</b></a></th>\n";
			}else
				$retour .= "<th>&nbsp</th>\n";
		}
		$retour .= "</tr>\n";
	}
	$retour .= "</table>\n";
	return $retour;
}
function get_spies_string($position,$texte="<color=red>E</color>"){					// Renvoi le lien vers le popup qui affiche les espionnages fait sur cette planete
	global $db;
	list($galaxy,$system,$row)=get_coord($position);
	$report_spy = 0;
	$request = "select id_spy from ".TABLE_PARSEDSPY." where active = '1' and coordinates = '$galaxy:$system:$row'";
	if ($db->sql_numrows($result_2) > 0)
        $report_spy = $db->sql_numrows($result_2);
	if ($report_spy > 0) $spy = " <A HREF=\'#\' onClick=\"window.open(\'index.php?action=show_reportspy&galaxy=$galaxy&system=$system&row=$row\',\'_blank\',\'width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0\');return(false)\"><i>$texte</i></A>";
	else $spy = "";
	return $spy;
}
function get_moon_string($position){												// Renvoi le texte d'affiche d'une lune ou pas selon la position
	global $db;
	list($galaxy,$system,$row)=get_coord($position);
	$type = Array("","M","M-3");
	return /*$type[intval(rand(0,2))]; //*/ "";
}
function delete_oldspies(){															// Efface les espionnages des joueurs qui n'ont plus de compte OGSpy
	global $db; global $table_prefix,$lang;
	$query = "SELECT DISTINCT `sender_id` FROM ".TABLE_QMS;
 	$result=$db->sql_query($query);
	if($result=$db->sql_numrows($result)==0){
		// Pas d'espionnages a effacer.
		$result="<i>".$lang['qms_aucun']."</i>";
	}else{
		$i=0;
 	 	while(list($id)=$db->sql_fetch_row($result)){
			$tab[$i]=$id;
			$i++;
		}
		$i=0; $number = "";
		foreach($tab as $index)	{
			$query = "SELECT  `user_name` FROM ".$table_prefix."user WHERE `user_id`=".$index;
		 	$result=$db->sql_query($query);
	 	 	if($result=$db->sql_numrows($result)==0){
				$to_remove[$i++] = $index;
				if($number) $number.=", #$index"; else $number = "#$index";
			}
		}
		if($number){
			foreach($to_remove as $index){
				$query = "DELETE FROM ".TABLE_QMS." WHERE `sender_id`=".$index;
				$db->sql_query($query);
			}
			$result="<font color='00FF40' size='2'>".sprintf($lang['qms_admin_spies_form_IDs_delete'],$number)."</font>";
		}else
			$result="<font color='FF0000' size='2'>".$lang['qms_admin_no_spies_to_delete']."</font>";
	}
	return $result;
}
function delete_qms_config($userid){
	global $db;
	$query = "DELETE FROM ".TABLE_QMS_config." WHERE `user_id`=".$userid." AND `config`!='search'";
	$db->sql_query($query);
}
?>