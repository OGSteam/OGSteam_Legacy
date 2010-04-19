<?php
/**
 * qms_main.php 

Procédures et Fonctions générales

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
function get_qms_config($key,$userid=0,$strict=0){	// Renvoi la valeur de la configuration "$key"
	global $db, $result;
	$where='AND `user_id`= '.$userid;
	$query_limit = "SELECT  `valeur`  FROM `".TABLE_QMS_config."` WHERE `config` = '".$key."' ".$where;
	$result=$db->sql_query($query_limit);
	$nb = $db->sql_numrows($result);
	list($valeur)=$db->sql_fetch_row($result);
	if(!$valeur && $userid!=0 && $strict==0){
		$query_limit = "SELECT  `valeur`  FROM `".TABLE_QMS_config."` WHERE `config` = '".$key."' AND `user_id`= 0";
		$result=$db->sql_query($query_limit);
		$nb = $db->sql_numrows($result);
		list($valeur)=$db->sql_fetch_row($result);
		$count=$db->sql_numrows($result);
	}
	return (!$valeur?false:$valeur);
}
function set_qms_config($value,$key,$userid=0){		// Modifie la valeur de la configuration "$key"
	global $db;
	$test=get_qms_config($key,$userid,1);
	qms_debug("set_qms_config : La valeur ".$test);
	if($test!=false)
		$query = "UPDATE `".TABLE_QMS_config."` SET `valeur` = '".stripslashes($value)."' WHERE `config`= '".$key."' AND `user_id`= ".$userid;
	else
		$query = "INSERT INTO ".TABLE_QMS_config." ( `user_id`,`config` , `valeur`) VALUES ( '".$userid."' , '".$key."' , '".$value."' )";
	$result=$db->sql_query($query);
	return $result;
}
function get_coord($position){						// Renvoi le rang de la planète par rapport à une position formatée GG:SS:RR
	$dPoint = strpos($position,":");	
	$galaxy = substr ($position,0,$dPoint);
	$tmp = substr ($position,$dPoint+1);	
	$dPoint2 = strpos($tmp,":");	
	$system = substr($tmp,0,$dPoint2); 	
	$row = substr ($tmp,$dPoint2+1);	
	return array($galaxy,$system,$row); 
}
function get_distance($depart,$arrive){				// Renvoi la distance entre 2 planètes
	$c_dep=get_coord($depart);
	$c_arr=get_coord($arrive);
	if($c_dep[0]==$c_arr[0])							// De la meme galaxie
		if($c_dep[1]==$c_arr[1])						// Du meme système
			$dist=1000+abs($c_dep[2]-$c_arr[2])*5;		// Distance entre 2 planètes d'un meme systèmes.
		else											// Pas du même système
			$dist=2700+abs($c_dep[1]-$c_arr[1])*95;		// Distance entre 2 systèmes.
	else												// Pas la même galaxie.
			$dist=abs($c_dep[0]-$c_arr[0])*20000;		// Distance entre 2 Galaxie.
	return $dist;
}
function prepare_espionnage($pub_espionage){		// Préparer un espionnage à l'importation (MERCI SANTORY!!!!)
	global $lang;
	$pub_espionage = mysql_real_escape_string($pub_espionage);
	$pub_espionage = trim($pub_espionage);
	//Compatibilité UNIX/Windows
	$pub_espionage = str_replace("\r\n","\n",$pub_espionage);
	//Compatibilité IE/Firefox
	$pub_espionage = str_replace("\t",' ',$pub_espionage);
	$retour = 0;
	//on recupere un tableau avec tous les raports.
	 preg_match_all($lang['regex_import_spy'], $pub_espionage,$matches);
	foreach ($matches[1] as $key => $val)
		$retour = add_espionnage($matches[0][$key]);
	return ($retour==0)?$lang['qms_insertion_error']:($retour==2)?$lang['qms_insertion_doublon']:$lang['qms_insertion_ok'];
}
function quimsonde_log($message){
	$fichier = "log_".date("ymd").'.log';
	$line = "/*".date("d/m/Y H:i:s")."*/ [QuiMSonde] - ".$message;
	write_file(PATH_LOG_TODAY.$fichier, "a", $line);
}
function qms_debug($string=""){
	if (!defined('QMS_DEBUG')) return 0;
	global $qms_debug_out;
	if($string!=""){
		$test = $string;
		if(is_array($test)){
			$string = "";
			foreach($test as $key => $value){
				$string .= "[$key] => ";
				if(is_array($value)){
					$string .= " { ";
					foreach($value as $key2 => $value2){
						$string .= "[$key2] => ";
						if(is_array($value2)){
							$string .= " { ";
							foreach($value2 as $key3 => $value3){
								$string .= "[$key3] => $value3 ";
							}
							$string .= " } ";
						} else
								$string .= "$value2 ";
					}
					$string .= " }<br />";
				}else
					$string .= " $value<br />";
			}
		}
		return $qms_debug_out .= "\n<br/>".$string;
	}else
		print($qms_debug_out);
}
function get_search_list(){
	$search_idlist = get_qms_config("searchID");
	if($search_idlist!=""){
		$search_idlist = explode('|',$search_idlist);
		foreach($search_idlist as $id){
			$search = (get_qms_config("search",$id));
			list($name,$link,$type,$actif) = explode("<|>",$search);
			$return[] = Array('id'=>$id,'name'=>addslashes($name),'link'=>addslashes($link),'type'=>$type,'actif'=>$actif);
		}
	} else return false;
	return $return;
}
function set_new_search($name,$link,$type){
	$newid = 0; $found=false;
	$searchID = get_qms_config("searchID");
	$searchID_list = explode('|',$searchID);
	do{
		$newid++;
	}while(in_array($newid,$searchID_list));
	set_qms_config($name."<|>".$link."<|>".$type."<|>1","search",$newid);
	$searchID = ($searchID!="")?$searchID."|".$newid:$newid;
	set_qms_config($searchID,"searchID",0);
	return true;
}
function update_search(){
	if(($searchs=get_search_list())==true){
		foreach($searchs as $s){
			global ${'pub_search_name'.$s['id']};
			global ${'pub_search_link'.$s['id']};
			global ${'pub_search_type'.$s['id']};
			global ${'pub_search_actif'.$s['id']};	
			set_qms_config(
					addslashes(${'pub_search_name'.$s['id']})."<|>".
					${'pub_search_link'.$s['id']}."<|>".
					${'pub_search_type'.$s['id']}."<|>".
					(isset(${'pub_search_actif'.$s['id']})?'1':'0'),"search",$s['id']);
		}
	} else return false;
	return true;
}
function check_for_newnames(){						// Recherche les noms des espions inconnus
	global $db,$lang;
	$query = "SELECT `id`,`position` FROM ".TABLE_QMS." WHERE `joueur`='?'";
 	$result=$db->sql_query($query);
	if($result=$db->sql_numrows($result)==0)
		$retour = "<font color='FF0000' size='2'>".$lang['qms_func_sql_no_unknown']."</font>";
	else{
		$i = 0;
		while(list($id, $position)=$db->sql_fetch_row($result)){
			$temp['id'][$i]=$id;
			$temp['position'][$i]=$position;
			$i++;
		}
		$nb_rec=$i;
		for($i=0;$i<$nb_rec;$i++){
			$tmp=get_user_id($temp['position'][$i]);
			if ($tmp[0]=="") $tmp[0]="?";
			$temp['joueur'][$i]=$tmp[0];
			$temp['alliance'][$i]=$tmp[1];
		}
		$count=0;
		for($i=0;$i<$nb_rec;$i++){
			if($temp['joueur']!="?"){
				$query = "UPDATE `".TABLE_QMS."` SET `joueur` = '".$temp['joueur'][$i]."', `alliance`='".$temp['alliance'][$i]."' WHERE `id`= '".$temp["id"][$i]."'";
				$db->sql_query($query) or die(sql_error());
				$count++;
			}
		}
		if($count==1)
			$retour = "<font color='00FF40' size='2'>".$lang['qms_func_sql_only_one_updated']."</font>";
		elseif($count>1)
			$retour = "<font color='00FF40' size='2'>".sprintf($lang['qms_func_sql_many_updated'],$count)."</font>";
		else
			$retour = "<font color='FF000' size='2'>".$lang['qms_func_sql_none_updated']."</font>";
	}
	return $retour;
}
function import_from_qmo(){							// Importation des espionnages de la base de donnée QuiMObserve
	global $db; global $table_prefix,$lang;
	$nb_jours=get_qms_config('jours');
	$timestamp = time()-(24*60*60*$nb_jours);
	$datadate = mktime (0,0,0,date("m",$timestamp),date("d",$timestamp),date("y",$timestamp));
	$query_limit = "SELECT  `spy_planetteEspion`,`spy_maplanette`,`sender_id`,`datadate`,`pourcentage`  FROM `".$table_prefix."MOD_quimobserve` WHERE  `datadate`>=$datadate ORDER BY `datadate` DESC";
	$result=$db->sql_query($query_limit);
	if($result=$db->sql_numrows($result)==0)
		$retour = '<font color="FF0000" size="2">'.$lang['qms_func_sql_import_from_quimobserve_none'].'</font>';
	else{
		$i = 0;
		while(list($position, $cible, $sender_id, $datadate, $pourcentage)=$db->sql_fetch_row($result)){
			$tab['sender_id'][$i] = $sender_id;
			$tab['position'][$i]	= $position;
			$tab['cible'][$i]	= $cible;
			$tab['datadate'][$i]	= $datadate;
			$tab['pourcentage'][$i]	= $pourcentage;
			$i++;
		}
		$nb_rec=$i;
		for($i=0;$i<$nb_rec;$i++){
			$tmp=get_user_id($tab['position'][$i]);
			$tab['joueur'][$i]	= $tmp[0];
			$tab['alliance'][$i]	= $tmp[1];
			if($tab['joueur'][$i]=="") $tab['joueur'][$i] = "?";
		}
		for($i=0;$i<$nb_rec;$i++){
			$query = "SELECT `id` FROM ".TABLE_QMS." WHERE `sender_id`='".$tab['sender_id'][$i]."' AND `datadate`='".$tab['datadate'][$i]."' AND cible='".$tab['cible'][$i]."' ";
			$result = $db->sql_query($query);
			$nb = $db->sql_numrows($result);
			if($nb!=0) $tab['datadate'][$i]=0;
		}
		$dejafait=0;
		for($i=0;$i<$nb_rec;$i++){
			if($tab['datadate'][$i]!=0){
				$table_spy['distance'][$i] = get_distance($table_spy['position'][$i],$table_spy['cible'][$i]);
				$query = "INSERT INTO ".TABLE_QMS." ( `id` , `sender_id` , `position` , `joueur`,`alliance`,`distance`,`cible` ,  `datadate`,  `pourcentage`) VALUES ( NULL, '".$tab['sender_id'][$i]."' , '".$tab['position'][$i]."', '".$tab['joueur'][$i]."', '".$tab['alliance'][$i]."', '".$tab['distance'][$i]."', '".$tab['cible'][$i]."', '".$tab['datadate'][$i]."', '".$tab['pourcentage'][$i]."' 	)";
				$db->sql_query($query);
			} else 
				$dejafait++;
		}
		$nb_add=$nb_rec-$dejafait;
		$retour = '<font color="00FF40" size="2">'.sprintf($lang['qms_func_sql_import_from_quimobserve_ok'],$nb_add,$nb_rec,$nb_jours).'</font>';
	}
	return $retour;
}
function clear_old_rapport(){						// efface les rapports trop ancien (en fonction du nombre de jour choisi par l'admin)
	global $db;
	$nb_jours=get_qms_config('jours');
	if(!$nb_jours) $nb_jours = 365;
	$timestamp = time()-(24*60*60*$nb_jours);
	$datadate = mktime (0,0,0,date("m",$timestamp),date("d",$timestamp),date("y",$timestamp));
	$query = "SELECT `id` FROM ".TABLE_QMS." WHERE  `datadate`<$datadate";
 	$result=$db->sql_query($query);
	if($result=$db->sql_numrows($result)==0){
		// Pas d'espionnages a effacer.
	}else{
		$i=0;
 	 	while(list($id)=$db->sql_fetch_row($result)){
			$tab[$i]=$id;
			$i++;
		}
		foreach($tab as $spyindex)
			delete_espionnage($spyindex);
	}
}
function add_espionnage($string,$fp=""){     		// Ajoute un rapport d'espionnage dans la table sql
	global $db, $user_data, $lang;
	//on recupere heure date et probabilité.
	preg_match_all($lang['regex_xtense1_date_heure'], $string,$out);
	//on verifie si le mois en cours est inferieur au mois du sondage (pour eviter le bug du changement d année)
	$year = date('Y');
	if(date('m') < $out[2][0])	$year -= 1; 
	$date = mktime($out[4][0],$out[5][0],$out[6][0],$out[2][0],$out[3][0],$year);
	//on recherche les coordonnées
	$test = preg_match_all($lang['regex_xtense1_coord'],$out[7][0],$position);
	$esp_name = $position[1][0];
	$esp_coor = $position[2][0];
	$cib_name = $position[1][1];
	$cib_coor = $position[2][1];
	if((strlen($esp_coor)+strlen($cib_coor)>=10)){	// si on a bien trouve les position
		$retour = 2;
		$real_sender_id = get_real_sender_id($cib_coor);
		if($real_sender_id==0) $real_sender_id = $user_data['user_id'];
		$where = "sender_id='".$real_sender_id."' AND datadate='".$date."' AND position='".$esp_coor."'";
		$query = "SELECT id FROM ".TABLE_QMS." WHERE ".$where;
		$result = $db->sql_query($query);
		$nb = $db->sql_numrows($result);
		if ($nb == 0){	// et que le rapport n'existe pas deja
			$userid=get_user_id($esp_coor);
			if(!$userid[0]) $userid[0]="?";
			// on l'ajoute à la table
			$distance=get_distance($esp_coor,$cib_coor);
			$query = "INSERT INTO ".TABLE_QMS." ( `id` , `sender_id` , `position` , `position_name`, `joueur`,`alliance`,`distance`,`cible` , `cible_name`,  `datadate`,  `pourcentage`) VALUES ( NULL, '".$real_sender_id."' , '".$esp_coor."', '".$esp_name."', '".$userid[0]."', '".$userid[1]."', '".$distance."', '".$cib_coor."', '".$cib_name."', '".$date."', '".$out[8][0]."' 	)";
			$result = $db->sql_query($query);
			$retour=1;//$result;
		} else {	// Si le rapport existe déjà, bah on met à jour les planètes au cas où le 1er envoi s'est fait par xtense et que le nom des planetes n'a pas été renvoyé
			$query = "UPDATE ".TABLE_QMS." SET `position_name`='".$esp_name."',`cible_name`='".$cib_name."' WHERE ".$where;
			$result = $db->sql_query($query);
		}
	} else
		$retour = 0;
	return $retour;
}
function get_QMS_version(){							// Renvoi le numéro de version
	global $db; global $mod_name;
	$result = $db->sql_query("SELECT version FROM ".TABLE_MOD." WHERE action='$mod_name'");
	list($version) = $db->sql_fetch_row($result);
	return $version;
}

?>
