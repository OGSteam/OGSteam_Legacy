<?php

define("IMPORT_TEST", false);

if(!IMPORT_TEST && !defined("IN_SPYOGAME"))
	die("Hacking attempt");

function import_rcsave($sources) {
	
	global $db, $table_prefix, $user_data, $server_config;
	
	if(IMPORT_TEST) echo "<br>mod actif";
	//On vérifie que le mod est activé
    $query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='rc_save' AND `active`='1' LIMIT 1";
    if (!$db->sql_numrows($db->sql_query($query))) return 0;
	
	if($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && !IMPORT_TEST) {
		$request = "SELECT group_id FROM ".TABLE_GROUP." WHERE group_name='RC_Save'";
		$result = $db->sql_query($request);
	
		if(list($group_id) = $db->sql_fetch_row($result)) {
			$request = "SELECT COUNT(*) FROM ".TABLE_USER_GROUP." WHERE group_id=".$group_id." AND user_id=".$user_data['user_id'];
			$result = $db->sql_query($request);
			list($row) = $db->sql_fetch_row($result);
			if($row == 0) return 4;
		}
	}
	
	if(IMPORT_TEST) echo "<br>rc valide";
	// vérif, ce RC est bien un RC (code sources)
	if(preg_match("/.*Les\sflottes\ssuivantes\sse\ssont\saffrontées\sle\s(\d{2})\-(\d{2})\s(\d{2}):(\d{2}):(\d{2}).*<br>.*Attaquant.*Type.*Nombre.*Défenseur.*/i", $sources, $date)) {
		
		if(!preg_match("/<html>.*<body>/si", $sources)) {
			$rapport = "<body>\n<center>\n<table width='99%'>\n" . $sources;
			$rapport = "<html>\n<head>\n<meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\" />\n</head>\n" . $rapport;
			$rapport .= "</table>\n</center>\n</body>\n</html>";
		}
		
		$rapport = trim(preg_replace('@<a href="#" onclick="showGalaxy\([0-9,\s]*?\);">\[([0-9:]{5,9})\]</a>@si', '$1', $rapport));
		
		if(IMPORT_TEST) echo "<br>att";
		if(!preg_match('#Attaquant\s(.{3,20})\s\(.{5,9}\)#i',$rapport,$pre_com))
			return 1;
		$commentaire = $pre_com[1];
		if(IMPORT_TEST) echo "<br>def";
		if(!preg_match('#Défenseur\s(.{3,20})\s\(.{5,9}\)#i',$rapport,$pre_com))
			return 1;
		$commentaire .= " VS ".$pre_com[1];
		if(IMPORT_TEST) echo "<br>titre=".$commentaire;
		
		if(IMPORT_TEST) echo "<br>date";
		$timestamp = mktime(intval($date[3]),intval($date[4]),intval($date[5]),intval($date[1]),intval($date[2]));
		if($timestamp<0 || !$timestamp)
			return 1;
		
		if(IMPORT_TEST) echo "<br>rc exite?";
		$request = "SELECT COUNT(*) FROM ".($table_prefix."rc_save")." WHERE user_id=".$user_data["user_id"]." AND rc_comment='".mysql_escape_string($commentaire)."' AND time=".$timestamp;
		if(!($result = $db->sql_query($request))) 
			return 5;
		
		list($row) = $db->sql_fetch_row($result);
		if($row>0)
			return 3;
		
		$rapport = trim(preg_replace('@<div id="overDiv" [^>]*?>(.*?</div>)?@si', "", stripcslashes($rapport)));
		$rapport = trim(preg_replace('@<script[^>]*?>(.*?</script>)?@si', "", stripcslashes($rapport)));
		$rapport = trim(preg_replace('@<object[^>]*?>(.*?</object>)?@si', "", stripcslashes($rapport)));
		$rapport = trim(preg_replace('@<vbscript[^>]*?>(.*?</vbscript>)?@si', "", stripcslashes($rapport)));
		$rapport = trim(preg_replace('@<link[^>]*?>(.*?</link>)?@si', "", stripcslashes($rapport)));
		$rapport = trim(preg_replace('@<iframe[^>]*?>(.*?</iframe>)?@si', "", $rapport));
		$rapport = trim(preg_replace('@</?tbody>@si', "", $rapport));
		
		$style = $server_config["default_skin"];
		
		$rapport = preg_replace("/<head>/i", "<head>\n\t<link rel=\"stylesheet\" type=\"text/css\" href=\"".$style."formate.css\">", $rapport); // changement du skin
		$rapport = preg_replace("/(<title>.*<\/title>\s*)*<\/head>/si", "<title>".$commentaire."</title></head>", $rapport); // titre du RC
		if(!preg_match("/<\/body>/i", $rapport))
			$rapport .= "</body>\n</html>";
		if(!preg_match("/<html>/i", $rapport))
			$rapport = "<html>\n".$rapport;
		
	} else return 1;
	if(IMPORT_TEST) echo "<br>traitement rc ok";
	
	// gération de l'id ou ouverture du RC pour modification:
	$r_id = rand(1000, 1000000);
	while(file_exists("./mod/RC_save/datas/" . $r_id . ".html")) {
		$r_id = rand(1000, 1000000);
	}
	
	if(!IMPORT_TEST) {
	
		$filename = "./mod/RC_save/datas/" . $r_id . ".html";
		
		if (!$handle = fopen($filename, 'w')) {
				return 5;
		}
	
		// Chmod du fichier:
		chmod ($filename, 0644);
	
		// Ecriture du RC
		if (fwrite($handle, $rapport) === FALSE) {
			return 5;
		}
		fclose($handle);
	}
	
	if(IMPORT_TEST) echo "<br>insert db";
		// sauvegarde dans la base de donnée
		$request = "INSERT INTO " . ($table_prefix."rc_save") . "(user_id, rc_id, rc_comment, time) VALUES (" . $user_data["user_id"] . " , " . $r_id . ", '" . mysql_escape_string($commentaire) . "', " . $timestamp . ")";
		if(!$db->sql_query($request)) {
			unlink($filename);
			return 5;
		}
	
	return 4;
}

if(IMPORT_TEST) {
	define("IN_SPYOGAME", true);
	define("OGSIGN", true);
	
	require_once("../../parameters/id.php");
	require_once("../../includes/config.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/mysql.php");
	require_once("../../includes/log.php");
	$db = new sql_db($db_host, $db_user, $db_password, $db_database);
	
	init_serverconfig();
	
	$request = "DELETE FROM " . $table_prefix . "rc_save" . " WHERE user_id=-1";
	$db->sql_query($request);
	
	$user_data['user_id'] = -1;
	$rapport_error1 = "";
	echo "<html><head></head><body><br>\ndata incorrect(1): ".import_rcsave($rapport_error1);
	$rapport_error1 = "<tr>\n\n    <td>\n\nLes flottes >>erreur<< se sont affrontées le 04-01 00:40:25 .:<br><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<br>Armes: 150% Bouclier: 140% Coque: 150% <table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<br>Armes: 100% Bouclier: 100% Coque: 100% <table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Can.Gauss</th><th>Art.ions</th><th>Lanc.plasma</th><th>P.bouclier</th><th>G.bouclier</th></tr><tr><th>Nombre</th><th>297</th><th>732</th><th>102</th><th>6</th><th>14</th><th>9</th><th>1</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>2.200</th><th>300</th><th>6.000</th><th>2</th><th>2</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>400</th><th>1.000</th><th>600</th><th>4.000</th><th>20.000</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>7.000</th><th>1.600</th><th>20.000</th><th>4.000</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 638 fois avec une puissance totale de 319.000.000 sur le défenseur. Les boucliers du défenseur absorbent 44.260 points de dégâts<br>La flotte défensive tire au total 1.162 fois avec une puissance totale de 316.324 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 316.324 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Can.Gauss</th><th>Art.ions</th><th>Lanc.plasma</th><th>G.bouclier</th></tr><tr><th>Nombre</th><th>178</th><th>418</th><th>52</th><th>2</th><th>7</th><th>7</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>2.200</th><th>300</th><th>6.000</th><th>2</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>400</th><th>1.000</th><th>600</th><th>20.000</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>7.000</th><th>1.600</th><th>20.000</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 644 fois avec une puissance totale de 322.000.000 sur le défenseur. Les boucliers du défenseur absorbent 51.380 points de dégâts<br>La flotte défensive tire au total 665 fois avec une puissance totale de 186.582 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 186.582 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Art.ions</th><th>Lanc.plasma</th></tr><tr><th>Nombre</th><th>76</th><th>156</th><th>19</th><th>2</th><th>4</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>300</th><th>6.000</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>1.000</th><th>600</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>1.600</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 453 fois avec une puissance totale de 226.500.000 sur le défenseur. Les boucliers du défenseur absorbent 15.970 points de dégâts<br>La flotte défensive tire au total 257 fois avec une puissance totale de 77.460 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 77.460 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Lanc.plasma</th></tr><tr><th>Nombre</th><th>18</th><th>23</th><th>3</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>6.000</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>600</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 507 fois avec une puissance totale de 253.500.000 sur le défenseur. Les boucliers du défenseur absorbent 3.070 points de dégâts<br>La flotte défensive tire au total 45 fois avec une puissance totale de 14.980 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 14.980 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<br>Détruit</center></th></th></tr></table><p> L\'attaquant a gagné la bataille !<br>Il emporte<br>242.293 unités de métal, 231.515 unités de cristal et 358.258 unités de deutérium<br><p><br>L\'attaquant a perdu au total 0 unités.<br>Le défenseur a perdu au total 4.216.000 unités.<br>Un champ de débris contenant 0 unités de métal et 0 unités de cristal se forme dans l\'orbite de cette planète.\n    </td>\n\n   </tr>";
	echo "<br>\ndata incorrect(1): ".import_rcsave($rapport_error1);
	$rapport_error1 = "<tr>\n\n    <td>\n\nLes flottes suivantes se sont affrontées le 04-01 e0:40:25 .:<br><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<br>Armes: 150% Bouclier: 140% Coque: 150% <table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<br>Armes: 100% Bouclier: 100% Coque: 100% <table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Can.Gauss</th><th>Art.ions</th><th>Lanc.plasma</th><th>P.bouclier</th><th>G.bouclier</th></tr><tr><th>Nombre</th><th>297</th><th>732</th><th>102</th><th>6</th><th>14</th><th>9</th><th>1</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>2.200</th><th>300</th><th>6.000</th><th>2</th><th>2</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>400</th><th>1.000</th><th>600</th><th>4.000</th><th>20.000</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>7.000</th><th>1.600</th><th>20.000</th><th>4.000</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 638 fois avec une puissance totale de 319.000.000 sur le défenseur. Les boucliers du défenseur absorbent 44.260 points de dégâts<br>La flotte défensive tire au total 1.162 fois avec une puissance totale de 316.324 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 316.324 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Can.Gauss</th><th>Art.ions</th><th>Lanc.plasma</th><th>G.bouclier</th></tr><tr><th>Nombre</th><th>178</th><th>418</th><th>52</th><th>2</th><th>7</th><th>7</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>2.200</th><th>300</th><th>6.000</th><th>2</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>400</th><th>1.000</th><th>600</th><th>20.000</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>7.000</th><th>1.600</th><th>20.000</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 644 fois avec une puissance totale de 322.000.000 sur le défenseur. Les boucliers du défenseur absorbent 51.380 points de dégâts<br>La flotte défensive tire au total 665 fois avec une puissance totale de 186.582 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 186.582 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Art.ions</th><th>Lanc.plasma</th></tr><tr><th>Nombre</th><th>76</th><th>156</th><th>19</th><th>2</th><th>4</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>300</th><th>6.000</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>1.000</th><th>600</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>1.600</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 453 fois avec une puissance totale de 226.500.000 sur le défenseur. Les boucliers du défenseur absorbent 15.970 points de dégâts<br>La flotte défensive tire au total 257 fois avec une puissance totale de 77.460 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 77.460 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Lanc.plasma</th></tr><tr><th>Nombre</th><th>18</th><th>23</th><th>3</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>6.000</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>600</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 507 fois avec une puissance totale de 253.500.000 sur le défenseur. Les boucliers du défenseur absorbent 3.070 points de dégâts<br>La flotte défensive tire au total 45 fois avec une puissance totale de 14.980 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 14.980 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<br>Détruit</center></th></th></tr></table><p> L\'attaquant a gagné la bataille !<br>Il emporte<br>242.293 unités de métal, 231.515 unités de cristal et 358.258 unités de deutérium<br><p><br>L\'attaquant a perdu au total 0 unités.<br>Le défenseur a perdu au total 4.216.000 unités.<br>Un champ de débris contenant 0 unités de métal et 0 unités de cristal se forme dans l\'orbite de cette planète.\n    </td>\n\n   </tr>";
	echo "<br>\ndata incorrect(1): ".import_rcsave($rapport_error1);
	
	$rapport_error4 = "<tr>\n\n    <td>\n\nLes flottes suivantes se sont affrontées le 04-01 00:40:25 .:<br><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<br>Armes: 150% Bouclier: 140% Coque: 150% <table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<br>Armes: 100% Bouclier: 100% Coque: 100% <table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Can.Gauss</th><th>Art.ions</th><th>Lanc.plasma</th><th>P.bouclier</th><th>G.bouclier</th></tr><tr><th>Nombre</th><th>297</th><th>732</th><th>102</th><th>6</th><th>14</th><th>9</th><th>1</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>2.200</th><th>300</th><th>6.000</th><th>2</th><th>2</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>400</th><th>1.000</th><th>600</th><th>4.000</th><th>20.000</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>7.000</th><th>1.600</th><th>20.000</th><th>4.000</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 638 fois avec une puissance totale de 319.000.000 sur le défenseur. Les boucliers du défenseur absorbent 44.260 points de dégâts<br>La flotte défensive tire au total 1.162 fois avec une puissance totale de 316.324 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 316.324 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Can.Gauss</th><th>Art.ions</th><th>Lanc.plasma</th><th>G.bouclier</th></tr><tr><th>Nombre</th><th>178</th><th>418</th><th>52</th><th>2</th><th>7</th><th>7</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>2.200</th><th>300</th><th>6.000</th><th>2</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>400</th><th>1.000</th><th>600</th><th>20.000</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>7.000</th><th>1.600</th><th>20.000</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 644 fois avec une puissance totale de 322.000.000 sur le défenseur. Les boucliers du défenseur absorbent 51.380 points de dégâts<br>La flotte défensive tire au total 665 fois avec une puissance totale de 186.582 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 186.582 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Art.ions</th><th>Lanc.plasma</th></tr><tr><th>Nombre</th><th>76</th><th>156</th><th>19</th><th>2</th><th>4</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>300</th><th>6.000</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>1.000</th><th>600</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>1.600</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 453 fois avec une puissance totale de 226.500.000 sur le défenseur. Les boucliers du défenseur absorbent 15.970 points de dégâts<br>La flotte défensive tire au total 257 fois avec une puissance totale de 77.460 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 77.460 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Lanc.plasma</th></tr><tr><th>Nombre</th><th>18</th><th>23</th><th>3</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>6.000</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>600</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 507 fois avec une puissance totale de 253.500.000 sur le défenseur. Les boucliers du défenseur absorbent 3.070 points de dégâts<br>La flotte défensive tire au total 45 fois avec une puissance totale de 14.980 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 14.980 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<br>Détruit</center></th></th></tr></table><p> L\'attaquant a gagné la bataille !<br>Il emporte<br>242.293 unités de métal, 231.515 unités de cristal et 358.258 unités de deutérium<br><p><br>L\'attaquant a perdu au total 0 unités.<br>Le défenseur a perdu au total 4.216.000 unités.<br>Un champ de débris contenant 0 unités de métal et 0 unités de cristal se forme dans l\'orbite de cette planète.\n    </td>\n\n   </tr>";
	echo "<br>\nno error(rc_id(4)): ".($rc_id = import_rcsave($rapport_error4));
	
	$rapport_error3 = "<tr>\n\n    <td>\n\nLes flottes suivantes se sont affrontées le 04-01 00:40:25 .:<br><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<br>Armes: 150% Bouclier: 140% Coque: 150% <table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<br>Armes: 100% Bouclier: 100% Coque: 100% <table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Can.Gauss</th><th>Art.ions</th><th>Lanc.plasma</th><th>P.bouclier</th><th>G.bouclier</th></tr><tr><th>Nombre</th><th>297</th><th>732</th><th>102</th><th>6</th><th>14</th><th>9</th><th>1</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>2.200</th><th>300</th><th>6.000</th><th>2</th><th>2</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>400</th><th>1.000</th><th>600</th><th>4.000</th><th>20.000</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>7.000</th><th>1.600</th><th>20.000</th><th>4.000</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 638 fois avec une puissance totale de 319.000.000 sur le défenseur. Les boucliers du défenseur absorbent 44.260 points de dégâts<br>La flotte défensive tire au total 1.162 fois avec une puissance totale de 316.324 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 316.324 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Can.Gauss</th><th>Art.ions</th><th>Lanc.plasma</th><th>G.bouclier</th></tr><tr><th>Nombre</th><th>178</th><th>418</th><th>52</th><th>2</th><th>7</th><th>7</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>2.200</th><th>300</th><th>6.000</th><th>2</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>400</th><th>1.000</th><th>600</th><th>20.000</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>7.000</th><th>1.600</th><th>20.000</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 644 fois avec une puissance totale de 322.000.000 sur le défenseur. Les boucliers du défenseur absorbent 51.380 points de dégâts<br>La flotte défensive tire au total 665 fois avec une puissance totale de 186.582 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 186.582 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Art.ions</th><th>Lanc.plasma</th></tr><tr><th>Nombre</th><th>76</th><th>156</th><th>19</th><th>2</th><th>4</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>300</th><th>6.000</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>1.000</th><th>600</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>1.600</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 453 fois avec une puissance totale de 226.500.000 sur le défenseur. Les boucliers du défenseur absorbent 15.970 points de dégâts<br>La flotte défensive tire au total 257 fois avec une puissance totale de 77.460 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 77.460 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<table border=1><tr><th>Type</th><th>Missile</th><th>L.léger.</th><th>L.lourd</th><th>Lanc.plasma</th></tr><tr><th>Nombre</th><th>18</th><th>23</th><th>3</th><th>1</th></tr><tr><th>Armes:</th><th>160</th><th>200</th><th>500</th><th>6.000</th></tr><tr><th>Bouclier</th><th>40</th><th>50</th><th>200</th><th>600</th></tr><tr><th>Coque</th><th>400</th><th>400</th><th>1.600</th><th>20.000</th></tr></table></center></th></th></tr></table><br><center>La flotte attaquante tire 507 fois avec une puissance totale de 253.500.000 sur le défenseur. Les boucliers du défenseur absorbent 3.070 points de dégâts<br>La flotte défensive tire au total 45 fois avec une puissance totale de 14.980 sur l\'attaquant. Les boucliers de l\'attaquant absorbent 14.980 points de dégâts</center><table border=1 width=100%><tr><th><br><center>Attaquant Scratch (7:72:5)<table border=1><tr><th>Type</th><th>Rip</th></tr><tr><th>Nombre</th><th>10</th></tr><tr><th>Armes:</th><th>500.000</th></tr><tr><th>Bouclier</th><th>120.000</th></tr><tr><th>Coque</th><th>2.250.000</th></tr></table></center></th></tr></table><table border=1 width=100%><tr><th><br><center>Défenseur rebel L (7:73:11)<br>Détruit</center></th></th></tr></table><p> L\'attaquant a gagné la bataille !<br>Il emporte<br>242.293 unités de métal, 231.515 unités de cristal et 358.258 unités de deutérium<br><p><br>L\'attaquant a perdu au total 0 unités.<br>Le défenseur a perdu au total 4.216.000 unités.<br>Un champ de débris contenant 0 unités de métal et 0 unités de cristal se forme dans l\'orbite de cette planète.\n    </td>\n\n   </tr>";
	echo "<br>\nexiste déjà(3): ".import_rcsave($rapport_error3);
	
	$request = "DELETE FROM " . $table_prefix . "rc_save" . " WHERE user_id=-1";
	$db->sql_query($request);

	
	echo "</body></html>";
}

?>