<?php
/** market_functions.php Ensemble des fonctions communes pour le Mod Market
* @package MOD_Market
* @author Jey2k <jey2k.ogsteam@gmail.com>
* @version 1.0
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
// Renvoie le nom de l'univers choisi sur une instance de serveur donné
function get_active_universe_name($server) {
	$univers_array=get_universes_array($server);
	foreach($univers_array as $univers)
	{
		if ($server["active_universe"]==$univers["id"]) {return $univers["name"];}
	}
	return null;
}

// Renvoie une instance de serveur sur base de son id
function get_server_from_id($server_id){
	global $db;
	$query = "SELECT `server_id`,`server_url`, `server_name`, `server_password`, `server_active`, `universes_list`, `universes_list_timestamp`, `trades_list`, `trades_list_timestamp`, `server_refresh`, `active_universe`, `trades_count`, UNIX_TIMESTAMP() as maintenant FROM ".TABLE_MARKET." WHERE server_id='".$server_id."'";
	$result = $db->sql_query($query);
	$server = $db->sql_fetch_assoc($result);
  return $server;
}

function get_tag_content($chaine_depart, $tag_a_chercher) {
	$ret=array();
	$p=true;
	$q=0;
	$i=0;
	while(!($p===false)) {
		$p = strpos($chaine_depart,"<".$tag_a_chercher.">",$q);
		if (!($p===false)) {
$i++;
			$p+=strlen($tag_a_chercher)+2;
			$q = strpos($chaine_depart,"</".$tag_a_chercher.">",$p);
			$ret[] = substr($chaine_depart,$p,$q-$p);
		}
	}
	return $ret;
}

function get_tag_value($chaine_depart, $tag_a_chercher) {
	$ret="";
	$p = strpos($chaine_depart,"<".$tag_a_chercher.">");
	if (!($p===false)) {
		$p+=strlen($tag_a_chercher)+2;
		$q = strpos($chaine_depart,"</".$tag_a_chercher.">",$p);
		$ret = substr($chaine_depart,$p,$q-$p);
	}
	return $ret;
}

// Récupère via XML les offres d'une instance de serveur donné
function update_server_offers($server){
	global $db;
	global $OGSMarket_trade_url;
	$url_to_open=$server["server_url"].$OGSMarket_trade_url.$server["active_universe"];
	if (!($server["server_password"]==null)&&($server["server_password"]!="")) $url_to_open.="&marketpwd=".md5($server["server_password"]);
	$url_to_open.="&ogspyurl=http://".$_SERVER["HTTP_HOST"].substr($_SERVER["PHP_SELF"], 0, -10);
	$f = fopen($url_to_open, "r");
	$xml = '';
	while (!feof($f)) $xml .= fread($f, 4096);
	fclose($f);
	$vartime=time();
	$query = "UPDATE ".TABLE_MARKET." SET trades_list='".mysql_escape_string($xml)."',  trades_list_timestamp='".$vartime."' WHERE server_id='".$server["server_id"]."' LIMIT 1";
	$db->sql_query($query);
	$server["trades_list_timestamp"]=$vartime;
	$server["trades_list"]=mysql_escape_string($xml);
	return $server;
}

// Récupère via XML la liste des Univers disponibles sur une instance de serveur
function update_server_universes($server){
	global $db;
	global $OGSMarket_uni_url;
	$f = fopen($server["server_url"].$OGSMarket_uni_url, "r");
	//echo "\n<br>Requete univers sur:".$server["server_url"].$OGSMarket_uni_url;
	$xml = '';
	while (!feof($f)) $xml .= fread($f, 4096);
	fclose($f);
	$vartime=time();
	$query = "UPDATE ".TABLE_MARKET." SET universes_list='".mysql_escape_string($xml)."',  universes_list_timestamp='".$vartime."' WHERE server_id='".$server["server_id"]."' LIMIT 1";
	$db->sql_query($query);
	$server["universes_list_timestamp"]=$vartime;
	$server["universes_list"]=mysql_escape_string($xml);
	return $server;
}

// Parse une instance de serveur pour retourner les offres disponibles sous forme de tableau
function get_trades_array($server){
	$val["trades_list"]=$server["trades_list"];
	$liste_offres_serveur=get_tag_content($val["trades_list"], 'offers_list');
	$offres_array = array();
	foreach($liste_offres_serveur as $liste_offres) {
		$offres=get_tag_content($liste_offres, 'offer');
		foreach($offres as $offre) {
			$offre_courante["offer_crystal"]=get_tag_value($offre,'offer_crystal');
			$offre_courante["id"]=get_tag_value($offre, 'id');
			$offre_courante["traderid"]=get_tag_value($offre, 'traderid');
			$offre_courante["universid"]=get_tag_value($offre, 'universid');
			$offre_courante["offer_metal"]=get_tag_value($offre, 'offer_metal');
			$offre_courante["offer_deuterium"]=get_tag_value($offre, 'offer_deuterium');
			$offre_courante["want_metal"]=get_tag_value($offre, 'want_metal');
			$offre_courante["want_crystal"]=get_tag_value($offre, 'want_crystal');
			$offre_courante["want_deuterium"]=get_tag_value($offre, 'want_deuterium');
			$offre_courante["creation_date"]=get_tag_value($offre, 'creation_date');
			$offre_courante["expiration_date"]=get_tag_value($offre, 'expiration_date');
			$offre_courante["note"]=get_tag_value($offre, 'note');
			$offre_courante["username"]=get_tag_value($offre, 'username');
			$offre_courante["market_server_url"]=$server["server_url"];
			$offre_courante["market_server_name"]=$server["server_name"];
			$offre_courante["deliver_g1"]=get_tag_value($offre, 'deliver_g1');
			$offre_courante["deliver_g2"]=get_tag_value($offre, 'deliver_g2');
			$offre_courante["deliver_g3"]=get_tag_value($offre, 'deliver_g3');
			$offre_courante["deliver_g4"]=get_tag_value($offre, 'deliver_g4');
			$offre_courante["deliver_g5"]=get_tag_value($offre, 'deliver_g5');
			$offre_courante["deliver_g6"]=get_tag_value($offre, 'deliver_g6');
			$offre_courante["deliver_g7"]=get_tag_value($offre, 'deliver_g7');
			$offre_courante["deliver_g8"]=get_tag_value($offre, 'deliver_g8');
			$offre_courante["deliver_g9"]=get_tag_value($offre, 'deliver_g9');
			$offre_courante["refunding_g1"]=get_tag_value($offre, 'refunding_g1');
			$offre_courante["refunding_g2"]=get_tag_value($offre, 'refunding_g2');
			$offre_courante["refunding_g3"]=get_tag_value($offre, 'refunding_g3');
			$offre_courante["refunding_g4"]=get_tag_value($offre, 'refunding_g4');
			$offre_courante["refunding_g5"]=get_tag_value($offre, 'refunding_g5');
			$offre_courante["refunding_g6"]=get_tag_value($offre, 'refunding_g6');
			$offre_courante["refunding_g7"]=get_tag_value($offre, 'refunding_g7');
			$offre_courante["refunding_g8"]=get_tag_value($offre, 'refunding_g8');
			$offre_courante["refunding_g9"]=get_tag_value($offre, 'refunding_g9');
			
			$offres_array[]=$offre_courante;
		}
	}
	return $offres_array;
}

// Parse une instance de serveur pour retourner les univers disponibles soous forme de tableau
function get_universes_array($server) {
	$val["universes_list"]=$server["universes_list"];
	$liste_univers_serveur=get_tag_content($val["universes_list"], 'universes_list');
	$univers_array = array();
	foreach($liste_univers_serveur as $liste_univers) {
		$univers=get_tag_content($liste_univers, 'universe');
		foreach($univers as $univerxml) {
			$univer["id"]=get_tag_value($univerxml,'id');
			$univer["url"]=get_tag_value($univerxml,'url');
			$univer["name"]=get_tag_value($univerxml,'name');
			$univer["server_id"]=$server["server_id"];
			$univers_array[]=$univer;
		}
	}
	return $univers_array;
}

// Fonction de mise à jour d'un univers
function update_universe($server_id,$server_url,$server_password	,$server_name,$server_refresh,$active_universe,$server_active) {
	global $db;
	$query="UPDATE ".TABLE_MARKET." SET `server_url`='".$server_url."', `server_password`='".$server_password."', `server_name`='".$server_name."', `server_refresh`='".$server_refresh."', `active_universe`='".$active_universe."', server_active='".$server_active."' WHERE `server_id`='".$server_id."'";
	$db->sql_query($query);
	
	return true;
}

// Fonction de suppresion d'un serveur
function delete_server($server_id) {
	global $db;
	$query="DELETE FROM ".TABLE_MARKET." WHERE `server_id`='".$server_id."'";
	$db->sql_query($query);
	
	return true;
}

// Fonction de création d'un univers
function create_universe($server_url,$server_password	,$server_name,$server_refresh,$server_active){
	global $db;
	$query="INSERT INTO ".TABLE_MARKET."(`server_url`, `server_password`, `server_name`, `server_refresh`, `server_active`) VALUES ('".$server_url."','".$server_password."','".$server_name."','".$server_refresh."','".$server_active."')";
	$db->sql_query($query);
	
	return true;
}

// Affichage de l'image valide ou non pour les galaxies
function affiche_icone($ouinon) {
	if ($ouinon=="1")
	{
		echo "<img src=\"images/graphic_ok.gif\" width=\"20\"/>";
	} else {
		echo "<img src=\"images/graphic_cancel.gif\" width=\"20\"/>";
	}
}
?>