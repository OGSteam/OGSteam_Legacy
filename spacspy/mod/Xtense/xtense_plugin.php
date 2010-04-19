<?php

define("IN_SPACSPY", true);
@import_request_variables('GP', "pub_");
define("OGSPY_0301B_VERCONST","0.301b", true);
define("OGSPY_0302_VERCONST","3.02", true);
define("OGSPY_031_VERCONST","3.1", true);
	
//if ($_SERVER['HTTP_USER_AGENT']!='OGSClient') exit('Vous devez installer la barre Xtense pour vous connecter via ce plugin Firefox<br><a href="http://www.ogsteam.fr/ogspyxtense/ogspyxtense109.xpi">Xtense Toolbar</a>');


// vidage des précédents tampons éventuels
while (@ob_end_clean());

// ignore any echos to be sure that header() works      
ob_start();

//vérification de la version pour compatibilité 
if (!isset($num_of_galaxies) || !isset($num_of_systems)) { 
$num_of_galaxies = 9;
$num_of_systems = 499;
}

//Appel des fonctions d'OGSpy
require_once("parameters/id.php");
require_once("includes/config.php");
require_once("includes/functions.php");
require_once("includes/mysql.php");
require_once("includes/log.php");
require_once("includes/galaxy.php");
require_once("includes/user.php");
require_once("includes/sessions.php");


//Appel des fonctions du plugin
require_once("mod/Xtense/xtense_ogsinc.php");
require_once("mod/Xtense/xtense_functions.php");           
require_once("mod/Xtense/xtense_plugin_inc.php");

//initialisation variables locales //tirées de function user_ogs_login() user.php
global $user_data, $user_info, $user_auth, $user_name;

$totalplanet=0;
$totalupdated=0;
$totalinserted=0;
$totalfailed=0;
$totalcanceled=0;

$playerranktables301 = array(TABLE_RANK_POINTS,  			TABLE_RANK_FLEET, TABLE_RANK_RESEARCH);
$playerranktables302 = array(TABLE_RANK_PLAYER_POINTS,	TABLE_RANK_PLAYER_FLEET, TABLE_RANK_PLAYER_RESEARCH);
$allyranktables302 = array(TABLE_RANK_ALLY_POINTS,		TABLE_RANK_ALLY_FLEET, TABLE_RANK_ALLY_RESEARCH);
$statsranktypestrings = array ('general', 'fleet', 'research');

// EST-CE UN APPEL DE LA BARRE XTENSE ?
if ((isset($pub_webagent) and ($pub_webagent=="ogsplugin") or ($_SERVER['HTTP_USER_AGENT']=='OGSClient'))) $is_ogsplugin = true; 
else $is_ogsplugin = false;

//On vérifie si la barre est à jour
if( ($pub_pluginversion == "1.0.0") || ($pub_pluginversion == "1.0.1") || ($pub_pluginversion == "1.0.2") || ($pub_pluginversion == "1.0.3") || ($pub_pluginversion == "1.0.4") || ($pub_pluginversion == "1.0.5") || ($pub_pluginversion == "1.0.6") || ($pub_pluginversion == "1.0.7")  || ($pub_pluginversion == "1.0.8") || ($pub_pluginversion == "1.0.9") || ($pub_pluginversion == "1.1.0") || ($pub_pluginversion == "1.1.1") || ($pub_pluginversion == "1.1.2") ) SendHttpStatusCode("793");

// Connexion au serveur SQL et vérification disponibilité //
$db = false;
if (is_array($db_host)) 
{
	for ($i=0 ; $i<sizeof($db_host) ; $i++) 
	{
		$db = new sql_db($db_host[$i], $db_user[$i], $db_password[$i], $db_database[$i]);
		if ($db->db_connect_id) 
		{
			break;
		}
	}
}
else 
{
	$db = new sql_db($db_host, $db_user, $db_password, $db_database);
}

// serveur mysql indisponible
if (!$db->db_connect_id) SendHttpStatusCode("750");

//Récupération et encodage de l'adresse ip
$user_ip = $_SERVER['REMOTE_ADDR'];

//On recupère la configuration du serveur OGSpy
init_serverconfig();

//On s'occupe de vérifier si le mode debug est activé
if ($server_config["xtense_debug"] == 1) define("XTENSE_PLUGIN_DEBUG", true);

if (defined("XTENSE_PLUGIN_DEBUG") && !is_dir("Xtense_debug")) mkdir("Xtense_debug");
if (defined("XTENSE_PLUGIN_DEBUG")) $fp = fopen("Xtense_debug/xtense_plugin.txt","w");

//Maintenant que l'on sais si le debug est activé ou non, on met la ligne de debug pour la récupération de la config serveur
if(isset($server_config) == 1) $etat = "terminée\n";
else $etat = "echouée\n";
if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "Récupération de la configuration du serveur OGSpy : ".$etat."");

//On regarde si la maintenance est activée
if ($server_config["xtense_maintenance"] == 1) define("MAINTENANCE_SCRIPT", true); // en cas de maintenance

//Maintenant on s'occupe de la configuration du plugin
if (isset($server_config["xtense_logogssqlfailure"])) $log_sql_errors = $server_config["xtense_logogssqlfailure"];
else $log_sql_error=true;

if (isset($server_config["xtense_logogsplayerstats"])) $log_ogsplayerstats = $server_config["xtense_logogsplayerstats"];
else $log_ogsplayerstats=true;

if (isset($server_config["xtense_logogsallystats"])) $log_ogsallystats = $server_config["xtense_logogsallystats"];
else $log_ogsallystats=true;

if (isset($server_config["xtense_logogslogon"])) $log_ogslogon = $server_config["xtense_logogslogon"];
else $log_ogslogon=true;

if (isset($server_config["xtense_logogsspyadd"])) $log_ogsspyadd = $server_config["xtense_logogsspyadd"];
else $log_ogsspyadd=true;

if (isset($server_config["xtense_logogsgalview"])) $log_ogsgalview = $server_config["xtense_logogsgalview"];
else $log_ogsgalview=true;

if (isset($server_config["xtense_logogsallyhistory"])) $log_ogsallyhistory = $server_config["xtense_logogsallyhistory"];
else $log_ogsallyhistory=true;
   
if (isset($server_config["xtense_logogsuserbuildings"])) $log_logogsuserbuildings = $server_config["xtense_logogsuserbuildings"];
else $log_logogsuserbuildings=true;
 
if (isset($server_config["xtense_logogsusertechnos"])) $log_logogsusertechnos = $server_config["xtense_logogsusertechnos"];
else $log_logogsusertechnos=true;

if (isset($server_config["xtense_logogsuserdefence"])) $log_logogsuserdefence = $server_config["xtense_logogsuserdefence"];
else $log_logogsuserdefence=true;

if (isset($server_config["xtense_forcestricnameuniv"])) $log_forcestricnameuniv = $server_config["xtense_forcestricnameuniv"];
else $log_forcestricnameuniv=true;

if (isset($server_config["xtense_logunallowedconnattempt"])) $log_logunallowedconnattempt = $server_config["xtense_logunallowedconnattempt"];
else $log_logunallowedconnattempt=true;

if (isset($server_config["xtense_ogsplugin_nameuniv"])) $log_ogsplugin_nameuniv = $server_config["xtense_ogsplugin_nameuniv"];
else $log_ogsplugin_nameuniv='';

if (isset($server_config["xtense_handlegalaxyviews"])) $plug_handlegalaxyviews = $server_config["xtense_handlegalaxyviews"];
else $plug_handlegalaxyviews=true;
// if (!$plug_handlegalaxyviews) SendHttpStatusCode("780");      

if (isset($server_config["xtense_handleplayerstats"])) $plug_handleplayerstats = $server_config["xtense_handleplayerstats"];
else $plug_handleplayerstats=true;
// if (!$plug_handleplayerstats) SendHttpStatusCode("781");

if (isset($server_config["xtense_handleallystats"])) $plug_handleallystats = $server_config["xtense_handleallystats"];
else $plug_handleallystats=true;
// if (!$plug_handleallystats) SendHttpStatusCode("782");  

if (isset($server_config["xtense_handleespioreports"])) $plug_handleespioreports = $server_config["xtense_handleespioreports"];
else $plug_handleespioreports=true;

//On verifie que l'univers est le bon
if ($log_forcestricnameuniv==true && isset($pub_realogameserver)  && strcasecmp($pub_realogameserver,$log_ogsplugin_nameuniv)!=0) 
{
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "Incohérence d'univers : ".$pub_realogameserver."/".$log_ogsplugin_nameuniv."\n");
	// unattendedogameserver_OGS
	log_plugin_("unattendedogameserver_OGS", array( mysql_escape_string($pub_user), $pub_password, $_SERVER['REMOTE_ADDR']));
	SendHttpStatusCode("795");
}

// gestion des commandes toolbar
require("mod/Xtense/xtense_cmdsman.php");  
if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "Execution des commandes de la barre terminée\n\n");
  
// décommenter pour signifier redirection manuelle
  if ($plug_notifyplugredirect==true) 
{
    $newurlstring=$plug_plugredirectmsg;
    $baliseserverdown="<|===/-!-\===|>"; // idem dans ogsplugin.js
    SendHttpStatusCode("798", true, true, "798".$baliseserverdown.$newurlstring);
} 
  
//Test si le serveur OGSpy est bien activé
if (isset($server_config) && (int)$server_config['server_active']==0 && $is_ogsplugin) 
{
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "Serveur OGSpy désactivé par l'admin pour la raison suivante : ".$server_config["reason"]."\n");
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "ob_content: ".ob_get_contents()."\n\n");
	$baliseserverdown="<|===/-!-\===|>";
    SendHttpStatusCode("794", true, true, "794".$baliseserverdown.$server_config["reason"]);
}

//Définition de la durée de la session
$session_time = $server_config['session_time'];

if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Browser utilisateur : ".$_SERVER['HTTP_USER_AGENT']."\nIP utilisateur :".$_SERVER['REMOTE_ADDR']."\n");
if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Univers d'origine : ".$pub_realogameserver."\n\n");

//Action à effectuer si le script est en maintenance
if (defined("MAINTENANCE_SCRIPT")) 
{
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,$pub_user." a tenté de se connecter - script en maintenance\n\n");
	if (defined("XTENSE_PLUGIN_DEBUG")) fclose($fp);
	SendHttpStatusCode("790") ;
}

// détection version serveur
$ogspy_server_version = Get_OGServer_Version();
if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "Version serveur détectée: (".Get_OGServer_Version().") $server_config:".$server_config["version"]." \n Version plugin détectée: ".$pub_pluginversion."\n");

// revoir le code suivant
if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Type des données soumises : ".$pub_typ."\n\n");
if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"POST[webagent]: ".$pub_webagent."\nwebbrowser: ".$_POST['webbrowser']."\ncount post: ".count($_POST)."-".count($SESSION)."\n\n");

// VERIFICATION CHAMPS LOGIN - MOT DE PASSE PRESENT
if ((!isset($pub_user) or !isset($pub_password) or empty($pub_user) or empty($pub_password)) && count($_POST)>2) 
{
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Identifiant ou mot de passe incorrect - Accès au serveur OGSpy refusé !\n\n");
  	SendHttpStatusCode("753") ;
}

// AUTHENTIFICATION
$user_name = $pub_user;
$motdepasse=md5(sha1($pub_password));

if (($ogspy_server_version==OGSPY_0302_VERCONST || $ogspy_server_version==OGSPY_031_VERCONST) &&  $is_ogsplugin) 
{
	$request = "select ".TABLE_USER.".user_id, ".TABLE_USER.".user_active, ".TABLE_USER.".user_lastvisit, MAX(".TABLE_GROUP.".ogs_connection), MAX(".TABLE_GROUP.".ogs_set_system), MAX(".TABLE_GROUP.".ogs_set_spy), MAX(".TABLE_GROUP.".ogs_set_ranking) "
    ."from ".TABLE_GROUP.", ".TABLE_USER_GROUP.", ".TABLE_USER." "
	."where ".TABLE_USER.".user_name = '".mysql_escape_string($pub_user)."' and ".TABLE_USER.".user_password = '".$motdepasse."' "
    ."and ".TABLE_USER.".user_id=".TABLE_USER_GROUP.".user_id "
    ."and ".TABLE_USER_GROUP.".group_id=".TABLE_GROUP.".group_id "
    ."group by ".TABLE_USER.".user_id, ".TABLE_USER.".user_active;";
	
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "Requête authentification :".$request."\n\n");
		
    $res = $db->sql_query($request, false, $log_sql_errors);
	
	// si mot de passe ou login incorrect
    if ( $db->sql_numrows($res)==0) SendHttpStatusCode("752");
    
	// si résultat requête vide!    
    if (list($user_id, $user_active, $user_lastvisit, $ogs_connection, $ogs_set_system, $ogs_set_spy, $ogs_set_ranking) = $db->sql_fetch_row($res)) 
	{
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Récupération des variable effectuée -> user_id : ".$user_id."\n");
	} 
	else 
	{
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Echec d'authenfitication, erreur sql no:".mysql_error($db->$dbselect)."\n");
	 	if ($log_logunallowedconnattempt) log_plugin_("unallowedconnattempt_OGS", array( mysql_escape_string($pub_user), $pub_password, $_SERVER['REMOTE_ADDR']));
		SendHttpStatusCode("752");
	}
}

// récupération infos utilisateur et droits
if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Définition des variables utilisateurs\n");
$user_data["user_id"] =	$user_id;
$user_data["user_name"] = $pub_user;

$now = time();
if ($now==0) 
{
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Réinitialisation de la variable now\n");
    $now = time();
}

// VERIFICATION COMPTE ACTIF
if ($user_active == 0) 
{
	SendHttpStatusCode("755") ;
} 
else 
{ 
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Connexion Xtense plugin : session expirée\n");
	$request = "update ".TABLE_USER." set user_lastvisit = ".$now." where user_id = ".$user_id;
    $db->sql_query($request, false, $log_sql_errors);
    $request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + 1";
    $request .= " where statistic_name = 'connection_ogs'";
    $res = $db->sql_query($request, false, $log_sql_errors);
    if ($res==0) 
	{
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Erreur durant la mise à jour des stats de connexion de : ".$user_id."\n");
    	$request = "insert ignore into ".TABLE_STATISTIC." values ('connection_ogs', '1')";
    	$db->sql_query($request, false, $log_sql_errors);
	}
}

// VERIFICATION AUTORISATION CONNEXION OGS 0.302
if (($ogspy_server_version==OGSPY_0302_VERCONST || $ogspy_server_version==OGSPY_031_VERCONST)) 
{
	if ((isset($ogs_connection)) && ($ogs_connection==0)) {
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Connexion OGS interdite par le serveur !\n");
	SendHttpStatusCode("756") ;
		}
	  // liste vars ogspy 0.302 : ogs_connexion /	ogs_set_system / ogs_set_spy / ogs_set_ranking
	  if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,($ogs_set_system ? 'Autorisation importation des systèmes ' : 'Refus importation des systèmes')+"\n");
}

// à revoir
// récupération toutes les variable session/user pour traitement ultérieur
$request = "select session_id, session_user_id, session_start, session_expire, session_ip, session_ogs from ".TABLE_SESSIONS
." where session_user_id = ".$user_id. " or (session_ip='".encode_ip($user_ip).  "' and session_user_id = 0);";
$result = $db->sql_query($request, false, $log_sql_errors);

$cookie_name = COOKIE_NAME;
$cookie_time = $server_config["session_time"];
$cookie_id = md5(uniqid(mt_rand(), true)); // à revoir ne devrait pas avoir besoin de créer nouvel cookie_id
$cookie_expire = $now+$cookie_time*60;  //retiré Axel test raison déco

if (($db->sql_affectedrows() == 0)  || $result==0  ) 
{
	// PAS DE SESSION EN COURS
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"pas de session en cours\n");
	if ($is_ogsplugin == true) 
	{
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Initialisation session Xtense\n");
        $request = "insert into ".TABLE_SESSIONS." (session_id, session_user_id, session_start, session_expire, session_ip, session_ogs, session_lastvisit) values ("
		."'".$cookie_id."', ".$user_id.", ".$now.", ".$cookie_expire.", '".encode_ip($user_ip)."', '1', ".$now.")";
		
		$db->sql_query($request, false, $log_sql_errors); // sql_query($request, true, false);
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"fin requète création session Xtense\n");
        if (!isset($server_config["xtense_logogslogon"]) || $server_config["xtense_logogslogon"]=='1')  log_plugin_('login_ogsplugin_new');
	}
}
else 
{ 
	// une session existe
	if (list($session_id, $session_user_id, $session_start, $session_expire, $session_ip, $session_ogs) = $db->sql_fetch_row($result)) 
	{
		if ($now > $session_expire) 
		{ 
			// REACTUALISATION SESSION EXPIREE
			if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"la session a expirée\n");
			$request = "UPDATE ".TABLE_SESSIONS." SET session_start=".$cookie_time.", session_expire=".$cookie_expire.", session_ip='".encode_ip($user_ip)."', 
			session_ogs = '1', session_lastvisit=".$now;
			$request .=" WHERE session_user_id=".$user_id." ;";
			
			if (!isset($server_config["xtense_logogslogon"]) || $server_config["xtense_logogslogon"]=='1')  log_plugin_('login_ogsplugin_upd');
		} 
		else 
		{ 
			// MISE A JOUR PARAMETRES SESSIONS
			if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"session en cours valide->mise à jour\n");
			$request = "UPDATE ".TABLE_SESSIONS." SET session_ip='".encode_ip($user_ip)."', session_ogs = '1', session_lastvisit=".$now;
			$request .=" WHERE session_user_id=".$user_id." ;";
		}
		$db->sql_query($request, false, $log_sql_errors); // sql_query($request, true, false);
	}
}

if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"récupération validité date session éventuelle\n\n");


// TEST TYPE OPERATION REQUISE
$timerankdata = To_Std_Update_Time(time()) ;
if (isset($pub_typ) && $pub_typ=="stats" && isset($pub_content) && !empty($pub_content)&& isset($pub_who) && is_numeric($pub_who) && isset($pub_what) && is_numeric($pub_what))
{

	// OGS 0.302, VERIFICATION DROIT IMPORTER STATS
	if (isset($ogs_set_ranking) && ($ogs_set_ranking==0)) 
	{ 
		// accès interdit
		if ($is_ogsplugin == true) 
		{
			if ($ogspy_server_version==OGSPY_0301B_VERCONST) 
			{
				SendHttpStatusCode("754");
			}  
			elseif (($ogspy_server_version==OGSPY_0302_VERCONST || $ogspy_server_version==OGSPY_031_VERCONST)) 
			{
				SendHttpStatusCode("724");
			} 
			else SendHttpStatusCode("703");
		} 
		else SendHttpStatusCode("703");
	}
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"stats...\n"); // ligne débug , commentaire si pas utile


	// STATS RANKING 

	$statstext = stripslashes($pub_content);
	$who = (int)$pub_who;
	$what = (int)$pub_what;
	$type_classement = array('points','flotte','research');
	$stats_array = explode("<==||==>",$statstext);

	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"splitting tableau stats en ".count($stats_array)." élements\n");

	$numbuffer_iter = 0;

	// DEBUT BOUCLE BUFFER STATS
	$num_stattabs_updated=0;
	$num_stattabs_notupdated=0;
	$num_stattabs_partialyupdated=0;
	$num_stattabs_alreadyupdated=0;

	foreach($stats_array as $curr_statstext) 
	{
		$countrank = 0; // initialisation nombre de lignes insérées
		$already_update = 0; // init nb ligne déjà à jour
		
		if ($who == 0) 
		{
			// stats joueurs	- possibilité de mélanger les deux codes player / alliance -> structure identique
			if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"playerstats...\n");
			
			// test prise en charge sur le serveur
			if (!$plug_handleplayerstats) SendHttpStatusCode("781");
			
			// Playerstats
			$newarray = preg_split("/&\w+=/",$curr_statstext);
			
			$stats_array['rank']	   = explode("|",$newarray[1]);
			$stats_array['playername'] = explode("|",$newarray[2]);
			$stats_array['pID'] 	   = explode("|",$newarray[3]);
			$stats_array['alliance']   = explode("|",$newarray[4]);
			$stats_array['points']	   = explode("|",str_replace('.','',$newarray[5]));
			unset($newarray);
			
			if ($ogspy_server_version==OGSPY_0301B_VERCONST) $ranktable = $playerranktables301[$what];
			elseif (($ogspy_server_version==OGSPY_0302_VERCONST || $ogspy_server_version==OGSPY_031_VERCONST)) $ranktable = $playerranktables302 [$what];
			
			if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"player rank table: ".$ranktable."\n");
			
			if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"**Début boucle analyse ligne classement\n");
			$max_count_statsrows = count($stats_array['playername']);
			for ($i=0; $i < $max_count_statsrows; $i++) 
			{
				// PREPARATION DES DONNEES
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"what: ".$what.", ".$ranktable.", ".$timerankdata.", ".$stats_array['rank'][$i].", ".$stats_array[
				'playername'][$i].", ".$stats_array['alliance'][$i].", ".$stats_array['points'][$i]."\n");
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"__".$entry."\n");
				
				if (isset($stats_array['rank'][$i]) && isset($stats_array['playername'][$i]) && isset($stats_array['alliance'][$i]) && isset($stats_array['points'][
				$i]))
				{
					plg_ImportRanking_player( $ranktable, $timerankdata, $stats_array['rank'][$i], $stats_array['playername'][$i], $stats_array['alliance'][$i], 
					$stats_array['points'][$i]);
					
					// gestions codes retour sql, cas enregiustrement déjà à jour
					$res_sql_error = $db->sql_error();
					if ($res_sql_error["code"]==1062) $already_update++;
					elseif ($res_sql_error["code"]==0) $countrank++;
				}
				
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"résult requète stats player: ".$res_sql_error.", déjà à jour: ".$already_update.", countrank: ".
				$countrank."\n");
				
			}
			
			if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"**Fin boucle analyse ligne classement\n");
			if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"plg_statsranking_update who: ".$who." , ".$statsranktypestrings[$what].", countrank: ".$countrank." \n");
		} 
		elseif ($who == 1) 
		{
			// STATS ALLIANCES
			if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"allystats...\n");// ligne débug , commentaire si pas utile
			
			// test handle ally stats on mod server
			if (!$plug_handleallystats) SendHttpStatusCode("782");
			
			$newarray = preg_split("/&\w+=/",$curr_statstext);
			
			$stats_array['rank']	   = explode("|",$newarray[1]);
			$stats_array['alliance'] = explode("|",$newarray[2]);
			$stats_array['member']	 = explode("|",$newarray[3]);
			$stats_array['points']	 = explode("|",str_replace('.','',$newarray[4]));
			unset($newarray);
			
			$ranktable = $allyranktables302 [$what];
			
			if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"début boucle (->".count($stats_array['alliance']).")\n");
			
			$max_count_statsrows = count($stats_array['alliance']);
			for ($i=0; $i < $max_count_statsrows; $i++) 
			{
				// PREPARATION DES DONNEES
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"what: ".$what.",". $ranktable.",". $timerankdata.",".$stats_array['rank'][$i].",". $stats_array[
				'alliance'][$i].",". $stats_array['member'][$i].",". $stats_array['points'][$i].", ". $per_member_points." \n");
				
				if (isset($stats_array['rank'][$i]) && isset($stats_array['alliance'][$i]) && isset($stats_array['member'][$i]) && isset($stats_array['points'][$i]))
				{
					$per_member_points = round($stats_array['points'][$i] / $stats_array['member'][$i]);
					plg_ImportRanking_ally( $allyranktables302[$what], $timerankdata, $stats_array['rank'][$i], $stats_array['alliance'][$i], $stats_array['member'][
					$i], 
					$stats_array['points'][$i], $per_member_points);
					$res_sql_error = $db->sql_error();
					if ($res_sql_error["code"]==1062) $already_update++;
					elseif ($res_sql_error["code"]==0) $countrank++;
					if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"résult requète stats ally: ".mysql_errno($db).", countrank: ".$countrank."\n");
				}
			}
				
		} 
		else SendHttpStatusCode("722");
			
		// actions gestion classement généraux players/alliances communes
		// JOURNALISATION
		if (($par_whoseranking==0 && ($log_ogsplayerstats=='1' )) || ($par_whoseranking==1 && ($log_ogsallystats=='1' )))
		if ($countrank>0) log_plugin_("load_rank_OGS", array( $who, $statsranktypestrings[$what], $timerankdata, $countrank));
		if ($countrank>0) plg_stats_update($pub_typ, $who, $statsranktypestrings[$what], $countrank);
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"enr journal stats joueur ok\n");
			
		if ($already_update==$max_count_statsrows) 
		{
			$num_stattabs_alreadyupdated++;
			$http_statsreturncode="726";
		} 
		elseif ( $countrank == $max_count_statsrows) 
		{
			$num_stattabs_updated++;
			$http_statsreturncode="721";
		} 
		elseif ( $countrank < 0 ) 
		{
			$num_stattabs_partialyupdated++;
			$http_statsreturncode="725";
		} 
		elseif ( $countrank ==0 ) 
		{
			$num_stattabs_notupdated++;
			$http_statsreturncode="722";
		}
		$numbuffer_iter++;
	} // fin boucle buffering
		
	if ($numbuffer_iter>1) 
	{
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Valeur indices tampons: num_stattabs_updated: $num_stattabs_updated-num_stattabs_partialyupdated:
		$num_stattabs_partialyupdated-num_stattabs_notupdated:$num_stattabs_notupdated-num_stattabs_alreadyupdated:$num_stattabs_alreadyupdated\n");
		if ($num_stattabs_alreadyupdated == $numbuffer_iter) 
		{
			SendHttpStatusCode("730");
		}
		elseif ( $num_stattabs_updated == $numbuffer_iter) 
		{
			SendHttpStatusCode("727");
		}
		elseif ( $num_stattabs_updated < $numbuffer_iter ) 
		{
			SendHttpStatusCode("729");
		}
		elseif ( $num_stattabs_updated ==0 ) 
		{
			SendHttpStatusCode("728");
		}
	} 
	else 
	{
		SendHttpStatusCode($http_statsreturncode);
	}
	
	// fin actions communes classements
} 


elseif (isset($pub_typ) && $pub_typ=="galaxy" && isset($pub_content) && !empty($pub_content) && isset($_POST['galaxy']) && is_numeric($_POST['galaxy'])&& isset($_POST['system']) && is_numeric($_POST['system'])) 
{
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"galaxyview...\n"); // ligne débug , commentaire si pas utile
	
	// VERIFICATION DROIT IMPORTER GALAXIE
	if (isset($ogs_set_system) && ($ogs_set_system==0))  SendHttpStatusCode("704");				
	
	// test handle galaxy view on server - mod option
	if (!$plug_handlegalaxyviews) SendHttpStatusCode("780");

	// GALAXY VIEW //
	
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Données de galaxie en traitement\n");
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Données brutes soumises : ".$pub_content."\n");

	$galaxy = (int)$pub_galaxy;
	$system = (int)$pub_system;
	$galaxies_array = explode("<==||==>",$pub_content);
	
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"\n______________________________________________________________________________\n");
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"\n==>Split tampon galaxies en ".count($galaxies_array)." éléments\n");
	
	$numbuffer_iter = 0;
	foreach($galaxies_array as $curr_gal_buf) 
	{
		// découpage du tampon
		$gv_source = str_replace("&nbsp;"," ",stripslashes($curr_gal_buf));
		$gv_array = explode("\n",$gv_source);
		$solarstring = $gv_array[0];
		
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"\n=>chaîne brute système solaire: ".$solarstring."\n");
		if (preg_match("#.*?\s([0-9]):([0-9]{1,3})#", $solarstring, $solarstring_array)) 
		{
			if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"parse ss: ".$solarstring_array[1]."-".$solarstring_array[2]."\n");
			$galaxy = (int)$solarstring_array[1];
			$system = (int)$solarstring_array[2];
		}
		unset ($gv_array[1]);
		unset ($gv_array[0]);
		
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"array count: ".count($gv_array)."...\n"); // ligne débug , commentaire si pas utile
		
		$totalinserted = 0;
		$totalupdated = 0;
		foreach ($gv_array as $gv_row) 
		{
			$gv_entries = explode("|",$gv_row);
			
			// determine moonsize
			$moon = ($gv_entries[2] > 0) ? 1 : 0;
			
			$playerstatus = $gv_entries[6];
			
			if ($gv_entries[0] > 0 && $gv_entries[0] < 16)	
			{
				// PREPARATION DES DONNEES
				// préparation données pour envoie vers ogs::galaxy_add_system(includes...)
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,$galaxy.":".$system.":".$position."||".date("Y-m-d")." ".date("H:i:s")."||".$planetname."||".$moon.
				"||".$playername."||".$allyname."<|>"."\n");
				
				// CONCATENATION SOUS FORME DE BLOC
				//$HTTP_RAW_POST_DATA = $HTTP_RAW_POST_DATA.$galaxy.":".$system.":".$position."||".date("Y-m-d")." ".date("H:i:s")."||".$planetname."||".$moon."||".$playername."||".$allyname."<|>";
				// vérification ligne / pb conflit foxgame
				if ((trim($playername)!='') && (trim($planetname)=='')) 
				{
					// send http header -> partial update
					if (defined("XTENSE_PLUGIN_DEBUG"))	fwrite($fp,"foxgame conflict...\n"); // ligne débug , commentaire si pas utile
					SendHttpStatusCode("792");
				}
				
				$timestamp = mktime(); // utilisaiton date et heure en cours // fonction ogs
				//if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"maketime ok\n");
				
				// INSERTION LIGNE DANS BASE DE DONNEES //
				
				if (defined("XTENSE_PLUGIN_DEBUG"))  fwrite($fp,"juste avant galaxy_add_system...\n");
				if (defined("XTENSE_PLUGIN_DEBUG"))  fwrite($fp,"vars galaxy_add_system:".$galaxy."-".$system."-".$position."-". $moon."-". $planetname."-". 
				$allyname."-". $playername."-". $playerstats."-". $timestamp."\n");
				
				SendHttpStatusCode("702", true, false);
				
				$result = galaxy_add_system ($galaxy, $system, $gv_entries[0], $moon, utf8_decode($gv_entries[1]), trim($gv_entries[7]),$gv_entries[5], $playerstatus
				, $timestamp, true);
				
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"retour func galaxy_add_system \n");
				if (isset($result)) 
				{ 
					// pas forcément que des insertions, sinon des mises à jour !!!
					list($inserted, $updated, $canceled) = $result; // $result -> gas_result test
					if ($inserted) $totalinserted++;
					if ($updated) $totalupdated++;
					if ($canceled) $totalcanceled++;
					if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"ajout ligner réussie totalinserted: ".$totalinserted."(".$inserted."-".$updated."-".$canceled."\n");
				} 
				else 
				{
					$totalfailed++;
					if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"ajout ligner annulé\n");
				}
				
			} // fin test valeur position
		}
			
		//log_plugin_("load_system_OGS", array($totalplanet, $totalinserted, $totalupdated, $totalcanceled, $totalfailed, $totaltime));
		if (!isset($server_config["xtense_logogsgalview"]) || $server_config["xtense_logogsgalview"]=='1')
		{
            log_plugin_("load_system_OGS", array($galaxy.":".$system, ($totalinserted+$totalupdated)));
            $numbuffer_iter++;
		}
  	} // fin foreach
		
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"all entries finished... ->".$totalinserted."+".$totalupdated."\n");
	
	if (($totalinserted+$updated) > 0) 
	{
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"numinserted+updated: ".$totalinserted."+".$totalupdated."\n");
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"gv updated...\n"); // ligne débug , commentaire si pas utile
		//if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"ob_get_contents: |". ob_get_contents()."|\n");
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"______________________________________________________\n");
		
		// send http header
		if ($numbuffer_iter>1) SendHttpStatusCode("705" ,true,true);
		else SendHttpStatusCode("701" ,true,true);
	} 
	else 
	{
		if ($numbuffer_iter>1) SendHttpStatusCode("706" ,true,true);
		else SendHttpStatusCode("702");
	}

}

 
elseif (isset($pub_typ) && $pub_typ=="galaxyraw" && isset($pub_content) && !empty($pub_content) && isset($pub_galaxy) && is_numeric($pub_galaxy) && isset($pub_system) && is_numeric($pub_system) )
{
    $lines = stripslashes(utf8_decode($pub_content));
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"galaxyraw: ".$lines."\n");
    $lines = explode(chr(10), $lines);
    $system_added = galaxy_system($lines);
                
    if (isset($system_added[0]) && $system_added[0]!="" && isset($system_added[1]) && $system_added[1]!="") 
	{
		if ($log_ogsgalview==true) log_plugin_("load_system_OGS", array($galaxy.":".$system. "(".$system_added[0].":".$system_added[1].")", (((int)$system_added[0]==
		$galaxy && (int)$system_added[1]==$system)? 15:0 ) ));
        SendHttpStatusCode("701" ,true,true);
    }
    else SendHttpStatusCode("702" ,true,true);
}


elseif (isset($pub_typ) && $pub_typ=="reports" && isset($pub_content) && !empty($pub_content))
{
	// VERIFICATION DROIT IMPORTER RAPPORTS
	if (isset($ogs_set_spy) && ($ogs_set_spy==0)) 
	{
		// accès interdit
		if ($is_ogsplugin == true) 
		{
			if (($ogspy_server_version==OGSPY_0302_VERCONST || $ogspy_server_version==OGSPY_031_VERCONST)) 
			{
				SendHttpStatusCode("714");
			}
		}
	}

	// test prise en charge acceptée sur le serveur - option mod
	if (!$plug_handleespioreports) SendHttpStatusCode("783");
	
	// SPY REPORTS / RAPPORTS 
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"spy reports...\n"); // ligne débug , commentaire si pas utile	

	// vérification si les données reçues du plugin sont au format HTML
    $spyreports_areHTMLData = IsHTMLData($pub_content);
    
    if (strpos($pub_content,"Surowce na") === false) 
	{
		$reportstring = str_replace("&nbsp;"," ",utf8_decode(stripslashes($pub_content)));
	} 
	else 
	{
		if ($spyreports_areHTMLData == true) 
        $reportstring = str_replace("&nbsp;"," ",stripslashes($pub_content));
	}

    if ($spyreports_areHTMLData==true) 
	{
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"=> données brutes rapport espionnage sont html...\n");
        $reportstring = str_replace("</td>"," </td>",$reportstring);
		$reportstring = str_replace("\n","",$reportstring);
    	$reportstring = str_replace("</tr>","</tr>|\n",$reportstring);
    	$reportarray = explode("<td colspan=\"3\" class=\"b\">",$reportstring);
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Nombre de lignes dans Reportarray: ".count($reportarray)."\n");        
	}
	
	$error = false;
	$newreport = array();
    $num_spyadded=0;
	
	foreach ($reportarray as $row) 
	{
		if ($spyreports_areHTMLData == true) 
		{
			$row = html_entity_decode($row);
    		$row = strip_tags($row); // retire tags html
		}
		
		$found = true;
		
		if (strpos($row,"Matières premières sur") !== false || strpos($row,"a été aperçue à proximité de votre") !== false) 
		{
			// $_SESSION['lang'] = "french";
		} 
		else 
		{
			$found = false;
		}
		
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "séparation reportarray -----------------------------------------\n");
		
		// FONCTION galaxy_spy($lines)
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "Found: ".$found."\n"); // ligne débug , commentaire si pas utile
		if ($found) 
		{
			if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Épuration lignes rapport\n");
			
			$search_strings = array ('Matières premières sur ([a-z,A-Z,0-9]{2,20}) ([\[]\d{1,3}:\d{1,3}:\d{1,2}[\]]) le (\040{0,50})(\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})(\040{0,50})',
                                                         '(\040{0,50})(\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})(\040{0,50})Quartier Général(\040{0,50})Retour de flotte',
							 '(\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})\040\040\011(Alliance)\040([\[][a-z,A-Z,0-9]{2,20}[\]])\040\040\011(Message de votre alliance)\040([\[][a-z,A-Z,0-9]{2,20}[\]])',
							 '(\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})\040\040\011(Tour de contrôle)\040\040\011(Rapport de combat) ([\(]\d+[\,]\d+[\)]) ([\[]\d{1,3}:\d{1,3}:\d{1,2}[\]]) ([\(]V[\:]\d{1,10}[\,]A[\:]\d{1,10}[\)])',
                                                         '(\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})\040\040\011([a-z,A-Z,0-9,\040]{2,20})\040([?\[]\d{1,3}:\d{1,3}:\d{1,2}[?\]])\040\040\011([\(][a-z,A-Z,0-9]{2,20}[\)])(Répondre)',
							 '(\040{0,50})(\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})(\040{0,50})(Quartier Général)(\040{0,50})(Espionnage de) ([a-z,A-Z,0-9]{2,20}) ([\[]\d{1,3}:\d{1,3}:\d{1,2}[\]])');
			
			//$replace_strings = array ('','','','','');
			//if (count(preg_replace ($search_strings,'', $row))>1) fwrite($fp,"motif trouvé\n");
			//if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Élement rapport espio: ".$row."\n");
			// épurer rapport des lignes superflues
            
			$inespioreport = false;
			$outespioreport= false;
			$rowtab =	explode("|", $row); // string -> tableau
			if (defined("XTENSE_PLUGIplg_ImportRanking_ally()N_DEBUG")) fwrite($fp,"Éclatement réussi: ".count($rowtab)." lignes\n");
			$newreport = "";
			SendHttpStatusCode("713", true, false);
			
			for ($cpt=0; $cpt<count($rowtab) ; $cpt++ ) 
			{
				$lignerow = trim($rowtab[$cpt]);
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Sous-ligne ".$cpt." rapport: ".$lignerow."\n");
				
				if (preg_match('#Mati.res\spremi.res\ssur\s([a-z, A-Z, 0-9, \040, é, à, è, _, \, , ;, \( ,\) ,\[ , \]]{2,20})#', $lignerow)==1) 
				{
					// resultat positif
					$inespioreport = true;
					$newreport[]=str_replace('.', '', $lignerow)."\r\n";
					if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Etiquette 'Matières premières' détecté\n");
					//$outespioreport = false;
				} 
				elseif (preg_match("#a\sété\saperçue\sà\sproximité\sde\s#", $lignerow) ==1) 
				{
					// resultat positif
					$outespioreport = true;
					$newreport[]=$lignerow.chr(13).chr(10);
					if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"flotte espion détectée\n");
					break;
					//if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"NewRapLgn: ".$lignerow."\n");
					//$inespioreport = false;
				} 
				elseif ($inespioreport == true) 
				{
					//if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"NewRapLgn: ".$lignerow."\n");
					$newreport[]=str_replace('.', '', $lignerow)."\r\n"; //$newreport.chr(13).chr(10).$lignerow;
				}
			}
			if($inespioreport)
			{
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Nouveau rapport: ".$newreport."\n");
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Fin Épuration lignes rapport\n");
			
				SendHttpStatusCode("712", true, false);
				ob_start();
			
				//if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"appel à galaxy_ImportSpy -");
				$spy_added = galaxy_spy($newreport);
				//galaxy_getsource;
				//if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp," fin galaxy_ImportSpy\n");
				if (!isset($spy_added) or count($spy_added)==0 /*$spy_added[2]=1*/) $error = true;
				else $num_spyadded+=1;
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "spy_added: ".count($spy_added)."\n");
			
				$recup="SELECT spy_added_ogs FROM ".TABLE_USER." WHERE user_id =".$user_id;
				$resultion=$db->sql_query($recup);
				$valeur=mysql_fetch_row($resultion);
				$resulta=$valeur[0];
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Ancienne valeur: ".$resulta."\n");
				$nouvellevaleur=$resulta + 1;
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Nouvelle valeur: ".$nouvellevaleur."\n");
				$query="Update `".TABLE_USER."` SET `spy_added_ogs` = '".$nouvellevaleur."' WHERE `user_id` = '".$user_id."'";
				$result=$db->sql_query($query);
				if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Requête d'insertion :\n".$query."\nResultat : ".$result."\n");
			} // if(înespioreport)
			if($outespioreport)
			{
			    $quimsonde_mod_exists = file_exists("mod/QuiMSonde/qms_plugin.php");
				if($quimsonde_mod_exists)
				{
					if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "Mod QuiMSonde trouvé\n");
					require_once("mod/QuiMSonde/qms_plugin.php");
					$hit=0;
					for($i=0;$i<count($reportarray);$i++)
					{
						$test_row =$reportarray[$i];
						$test_row = html_entity_decode($test_row);
			    		$test_row = strip_tags($test_row);
						if($test_row==$row)
						{
							$hit=$i;
							break;
						}
					}
					$test_row =$reportarray[$hit-1];
		    		$test_row = strip_tags($test_row);
					$test_tab =	explode("|", $test_row);
					$sendstring = trim($test_tab[count($test_tab)-2])." ".$lignerow;
					$retour=add_espionnage($sendstring,$fp);
					if (!isset($retour)) $error = true;
					else if($retour<2) $num_spyadded+=$retour;
				}
				else
				{
					if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "Mod QuiMSonde non trouvé\n");
				}
			} // if($outespioreport)
			//if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "$tmp = $parser->parseEntry: ".$tmp."\n");
		} // fin f ($found)
	} // fin boucle for
	
	if (!isset($server_config["xtense_logogsspyadd"]) || $server_config["xtense_logogsspyadd"]=='1')  log_plugin_("load_spy_OGS",$num_spyadded);
	if ($error or ($num_spyadded=0)) 
	{
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Fehler aufgetreten: ".$tmp->error."\n");
		SendHttpStatusCode("712", true, true);
	}
	
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"okay ".$num_spyadded."\n");
	SendHttpStatusCode("711", true, true);
}
elseif (isset($pub_typ) && $pub_typ=="combreports" && isset($pub_content) && !empty($pub_content))
{    
      // COMBAT REPORTS - RAPPORTS DE COMBAT
    $attaques_mod_exists = file_exists("mod/Attaques/import_rc.php"); ///Ogame/OGSpy/mod/Attaques
    $rc_save_mod_exists = file_exists("mod/RC_save/import_rcsave.php"); ///Ogame/OGSpy/mod/Attaques
    
    if ($attaques_mod_exists==true) 
    {
        include "mod/Attaques/import_rc.php";
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Le fichier d'importation pour le mod Attaques existe !\n");
    } 
    
    if ($rc_save_mod_exists==true) 
    {
        include "mod/RC_save/import_rcsave.php";
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Le fichier d'importation pour le mod RC Save existe !\n");
    }
    
    
    if ($attaques_mod_exists==false && $rc_save_mod_exists==false) 
    {
       SendHttpStatusCode("799"); // non implémenté        
    }
    
    $rapport_content = stripslashes(utf8_decode($pub_content));
    
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"rapport de combat :\n".$rapport_content."\n");            
    
    $result_rc = 4;
    if ($attaques_mod_exists==true) {
        $result_rc = import_rc($rapport_content);         
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"résultat traitement rapport Mod Attaque:".$result_rc."\n");
      }
    
    $result_rc2 = 4;
    if ($rc_save_mod_exists==true) {
        $result_rc2 = import_rcsave($rapport_content);         
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"résultat traitement rapport Mod RC Save:".$result_rc2."\n");
    }
    
    if ($result_rc==0 && $result_rc2==0) SendHttpStatusCode("800");
      elseif($result_rc==1 || $result_rc2==1) SendHttpStatusCode("801"); 
      elseif($result_rc==2 || $result_rc2==2) SendHttpStatusCode("802"); 
      elseif($result_rc==3 || $result_rc2==3) SendHttpStatusCode("803"); 
      elseif($result_rc==4 && $result_rc2==4) SendHttpStatusCode("804"); 
    else SendHttpStatusCode("751");
}
elseif (isset($pub_typ) && $pub_typ=="allyhistory" && isset($pub_content) && !empty($pub_content) && isset($ogs_set_ranking) && ($ogs_set_ranking==1))
{ 
	
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"allyhistory : ".$pub_alliance."...\n"); // ligne débug , commentaire si pas utile
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"history content: ".$pub_content."\n");
	
	// ALLY HISTORY
	$allyrank_mod_exists = file_exists("mod/allyRanking/ARinclude.php"); ///Ogame/OGSpy/mod/allyRanking
    if ($allyrank_mod_exists==true) include "mod/allyRanking/ARinclude.php";
    
	if (!defined("TABLE_RANK_MEMBERS") or $allyrank_mod_exists==false) 
	{
		SendHttpStatusCode("799"); // non implémenté
	}
		
	if (!isset($pub_alliance) || $pub_alliance=='undefined' || trim($pub_alliance)=='') SendHttpStatusCode("732");
        
    // traitement code html classement alliance perso //
	$tr_array = explode("<tr>",utf8_decode($pub_content));
    	
	// remove first three rows - less memory wasted
    unset($pub_content); // libération contenu variable $pub_content
    unset($tr_array[0]);
    unset($tr_array[1]);
    unset($tr_array[2]);
    	
	// modifié pour util params ogsspy
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"allyparse db select ok\n");
	$failed_inserts = 0;
    $already_update = 0;
	$total_ally_members = count($tr_array);
        
	foreach ($tr_array as $row) 
	{
        $th_array = explode("<th>",$row);
        // extract data
        $playername  = strip_tags($th_array[2]);
        $playerscore = (int)str_replace('.','',strip_tags($th_array[5]));
        $th_array[3] = substr($th_array[3],strpos($th_array[3],"messageziel=")+strlen("messageziel="));
        $th_array[3] = substr($th_array[3],0,strpos($th_array[3],"\""));
        $ogame_playerid = $th_array[3];
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"là insérer dans ".TABLE_RANK_MEMBERS." ".$playername." ".$playerscore."\n");
          	
		// insert entry and ignore error message (appears if entry for this day exists)
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"date ally: ".$timerankdata."\n");
        $query = "INSERT INTO ".TABLE_RANK_MEMBERS." (datadate, player, points, ally, sender_id) ". // date("Y-m-d")." ".date("H:i:s")
		"VALUES ( $timerankdata, '$playername', $playerscore, '$pub_alliance', $user_id)";
        $res = $db->sql_query($query, false, $log_sql_errors);
          	
		if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"requete : ".$query." - ".$res."\n");
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"code res sql : ".mysql_errno($res)."\n");
			
        if (!res) $failed_inserts++;
        $res_sql_error = $db->sql_error();
        if ($res_sql_error["code"]==1062) $already_update++;
    }
	    if ($already_update==$total_ally_members) SendHttpStatusCode("733");
      
	if ($failed_inserts>0) 
	{
		// certaines lignes non mises à jour
		SendHttpStatusCode("732");
	} 
	else 
	{
		// toutes les lignes mises à jour:  $failed_inserts==0
        if ($log_ogsallyhistory) log_plugin_("load_allyhistory_OGS", array($pub_alliance,  $timerankdata, ($total_ally_members-$failed_inserts)));
        SendHttpStatusCode("731");
	}
}


elseif (isset($pub_typ) && $pub_typ=="buildings" && isset($pub_content) && !empty($pub_content) && isset($pub_planetsource) && $pub_planetsource!="")
{       
	// GESTION PAGE BATIMENTS //
    if (preg_match('#([a-z,A-Z,0-9,\040,é,à,è]{2,20})\040\[(\d{1,3}:\d{1,3}:\d{1,2})\]#', utf8_decode($pub_planetsource), $user_planetsource_vars)==1)
    {
		// resultat positif
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"planetsource found: ".$user_planetsource_vars[1]." - ".$user_planetsource_vars[2]."\n");
    }
	$buildings_content = html_entity_decode(utf8_decode($pub_content));
    
	if (preg_match('#<\/?[^>]+>#',$buildings_content)>0) 
	{
        if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"déformatage html...\n");
        $buildings_content = html2text($buildings_content);
    } 
    $buildings_content = stripslashes($buildings_content);
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"buildings: ".$buildings_content."\n");

    SendHttpStatusCode("741", true, false); // au cas où... pas de maj batiments
    ob_start();
	
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"retour SendHttpStatusCode\n");
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Nom planètes reçu: ".$user_planetsource_vars[1]."\n");
    
	// test bâtiment de planète          
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"\n=> Recherche de Base lunaire dans pub_content\n");          
    
	// pas au point
    if (strpos($buildings_content, 'Base lunaire')===false) 
	{
		// test sur faux, cf manuel php, si pas lune est planète!
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"=>la composition des bâtiments semble celle d'une planète! \n");
        $seemsaplanet = true; // ne pas fixer pour l'instant
    }
	else if (strpos($buildings_content, 'Mine de métal')===false) 
	{
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"=>la composition des bâtiments semble celle d'une lune!\n");
        $seemsaplanet = false; // ne pas fixer pour l'instant
    } 
	else $seemsaplanet = null;
	
	// recherche de l'emplacement d'insertion dans l'espace personnal empire
    $target_planet_id = plg_getplanetidbycoord($user_planetsource_vars[1] , $user_planetsource_vars[2], $seemsaplanet);

	if ($target_planet_id!=0) 
	{
		// fields entre `` et pas '' sinon ça marche pas
        $query = "SELECT planet_id, `fields`, temperature, Sat FROM ".TABLE_USER_BUILDING." WHERE user_id=".$user_id." and planet_id=".$target_planet_id.";";
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"\nrequète recherche valeur à récupérer : ".$query."\n");
        $res = $db->sql_query($query, true, $log_sql_errors);
        list($prev_planetid, $prev_fields, $prev_temperature, $prev_satellite) = $db->sql_fetch_row($res);
		
		if ($ogspy_server_version==OGSPY_0302_VERCONST) $res_set_building=plg_set_user_building($buildings_content, $target_planet_id,$user_planetsource_vars[1], 
		$prev_fields,  $user_planetsource_vars[2], $prev_temperature, $prev_satellite);

		elseif($ogspy_server_version==OGSPY_031_VERCONST) $res_set_building=user_set_building($buildings_content, $target_planet_id,$user_planetsource_vars[1], 
		$prev_fields,  $user_planetsource_vars[2], $prev_temperature, $prev_satellite, true);
                     
        if ($res_set_building==true) 
		{
            if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"résultat insert building ok\n");
            SendHttpStatusCode("740");
        }
        else SendHttpStatusCode("741");
	}
    else 
	{
		// résultat requète vide -pas de colo correcpondate coord trouvée
        // cas bâtiments, obligé de l'insérer
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"la planète/lune dont les batiments sont reçus n'existe pas dans la base!\n");
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"substr($user_planetsource_vars[1],0,4): ".substr($user_planetsource_vars[1],0,4)."\n");

		if (substr($user_planetsource_vars[1],0,6)=='lune') 
		{
            SendHttpStatusCode("743");
            if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"cas lune, necessaire inserer planète avant!!");
        }
        $free_planet_id=1;
        
		// récupération toutes id planet max pour déterminer emplacements libres
        $query = "SELECT planet_id FROM ".TABLE_USER_BUILDING." 
		WHERE user_id=".$user_id." and planet_id>=".$free_planet_id." and planet_id<=".($free_planet_id+8).";";
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"\nrequète recherche id planet libres : ".$query."\n");
        $res = $db->sql_query($query, true, $log_sql_errors);
        
        $set_planet_id_start=$free_planet_id;
        if ( $db->sql_numrows($res)>0) // des résultat?
        
		while (list($set_planet_id) = $db->sql_fetch_row($res)) 
		{
            if ($set_planet_id<=$free_planet_id) $free_planet_id++;
            else if ($set_planet_id>$free_planet_id) break;
            if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"planet_id utilisé: ".$set_planet_id."\n");
        }
        // fin examen planet ids, aucun emplacement dispo!
        if ($free_planet_id==$set_planet_id_start+9) 
		{
            if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"aucun id de planète libre set_planet_id".$set_planet_id." / ".$set_planet_id_start."\n");
            SendHttpStatusCode("745"); // nombres colos max déjà sur ogspy
        }
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"planet id libre: ".$free_planet_id."\n");
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"insertion planète en position: ".$free_planet_id." de la planète: ".$user_planetsource_vars[1]."\n");
        
		if (plg_set_user_building($buildings_content, $free_planet_id,$user_planetsource_vars[1], null,  $user_planetsource_vars[2], null, null)==true) 
		{
            if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"résulat insert building ok\n");
            SendHttpStatusCode("740");
        }
        else SendHttpStatusCode("741");
    }
	if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"si non trouvé en test: ".$user_planets[$user_planetsource_vars[1]]."\n");
} 


elseif (isset($pub_typ) && $pub_typ=="technos" && isset($pub_content) && isset($pub_planetsource) && $pub_planetsource!="")
{
    // GESTION PAGE TECHNOS
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Page technos...\n");
    
	if (empty($pub_content)) 
	{
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"pub_content vide..\n");
        SendHttpStatusCode("747");
    } 
     
    $technos_content = html_entity_decode(utf8_decode($pub_content));
	if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,$technos_content);
	if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"\n");
    if (preg_match('#<\/?[^>]+>#',$technos_content)>0) 
	{
        if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"déformatage html...\n");
        $technos_content = html2text($technos_content);
    }    
    
	// stripslashes
    $technos_content = stripslashes($technos_content);
	if ($ogspy_server_version==OGSPY_0302_VERCONST) $res_set_technology =plg_user_set_technology($technos_content);
    elseif($ogspy_server_version==OGSPY_031_VERCONST) $res_set_technology =user_set_technology($technos_content, true);         
	if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,$res_set_technology);
    if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"\n");
    if ($res_set_technology=='1') 
	//if ($res_set_technology==true) pas au point, n'apparait pas dans le debug, à revoir (Bousteur)
	{
      	if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"retour set_technology OK\n");
      	SendHttpStatusCode("746");
	} 
	else SendHttpStatusCode("747");
}


elseif (isset($pub_typ) && $pub_typ=="shipyard" && isset($pub_content) && !empty($pub_content) && isset($pub_planetsource) && $pub_planetsource!="")
{
	// GESTION PAGE CHANTIER SPATIAL
    SendHttpStatusCode("799"); // pas de fonction d'importation des données chantier spatial
    
	// decode utf8
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"traitement chantier spatial...\n");
    $flotten_precontent = html_entity_decode(utf8_decode($pub_content));
    
	if (preg_match('#<\/?[^>]+>#',$flotten_precontent)>0) 
	{
        if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"déformatage html...\n");
        $flotten_precontent = html2text($flotten_precontent);
    }
    
	$flotten_precontent = stripslashes($flotten_precontent);           
    // pas d'appel de fonction
}


elseif (isset($pub_typ) && $pub_typ=="flotten" && isset($pub_content) && !empty($pub_content) && isset($pub_planetsource) && $pub_planetsource!="") 
{
    // GESTION PAGE FLOTTE
    //Ogame/OGSpy/mod/flottes/flottes_plugin.php
	// vérification si mod flotte existe
    $flottes_mod_exists = file_exists("mod/flottes/flottes_plugin.php"); ///Ogame/OGSpy/mod/flottes
	
	    if (preg_match('#([a-z,A-Z,0-9,\040,é,à,è]{2,20})\040\[(\d{1,3}:\d{1,3}:\d{1,2})\]#', utf8_decode($pub_planetsource), $user_planetsource_vars)==1)
    {
		// resultat positif
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"planetsource found: ".$user_planetsource_vars[1]." - ".$user_planetsource_vars[2]."\n");
    }
    
	if ($flottes_mod_exists==true) 
	{
        if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"==> fichier mod flotte détecté\n");
        require_once ("mod/flottes/flottes_plugin.php");
    }
      
    // données déjà brutes
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"traitement flotte...\n");          
    
    $flotten_precontent = utf8_decode($pub_content); // décodage des données du plugin
    $fleetdata_areHTMLData = IsHTMLData($flotten_precontent);
    
	if ($fleetdata_areHTMLData==true) 
	{
        $flotten_precontent = html_entity_decode($flotten_precontent);
        
		if (preg_match('#<\/?[^>]+>#',$flotten_precontent)>0 || $fleetdata_areHTMLData==true) 
		{
            if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"déformatage html...\n");
            $flotten_precontent = html2text($flotten_precontent);
        }
    }
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"flotte déformaté:|".$flotten_precontent."\n");

    $flotten_precontent = stripslashes($flotten_precontent); // (*1)
  	
    // appel fonction        
	if ($flottes_mod_exists==true && function_exists('mod_flottes_plugin_shipbyid')) 
	{
	    if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp," appel fonction mod_flottes_plugin_ship(".$pub_planetsource.")\n");
        $target_planet_id = plg_getplanetidbycoord($user_planetsource_vars[1], $user_planetsource_vars[2], $seemsaplanet);
		if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp," appel fonction plg_getplanetidbycoord(".$user_planetsource_vars[1]." - ".$user_planetsource_vars[2]." - ".$seemsaplanet.")\n");
        $resflotten = mod_flottes_plugin_shipbyid($target_planet_id,$flotten_precontent);
		if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp," appel fonction mod_flottes_plugin_shipbyid ==> ".$resflotten."\n");
        
        if ($resflotten==0 || $resflotten==2)  SendHttpStatusCode("735");
        elseif ($resflotten==1)  SendHttpStatusCode("736");
    }        
         
}


elseif (isset($pub_typ) && $pub_typ=="defence" && isset($pub_content) && !empty($pub_content) && isset($pub_planetsource) && $pub_planetsource!="") 
{
    // GESTION PAGE DEFENSE
    if (preg_match('#([a-z,A-Z,0-9,\040,é,à,è]{2,20})\040\[(\d{1,3}:\d{1,3}:\d{1,2})\]#', utf8_decode($pub_planetsource), $user_planetsource_vars)==1)
    {
		// resultat positif
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"planetsource found: ".$user_planetsource_vars[1]." - ".$user_planetsource_vars[2]."\n");
    }
    
	// decode utf8
    $buildings_content = html_entity_decode(utf8_decode($pub_content));
    
	if (preg_match('#<\/?[^>]+>#',$buildings_content)>0) 
	{
        if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"déformatage html...\n");
        $buildings_content = html2text($buildings_content);
    }
	// stripslashes
    $buildings_content = stripslashes($buildings_content);
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"defence: ".$buildings_content."\n");
    
	$target_planet_id = plg_getplanetidbycoord($user_planetsource_vars[1] , $user_planetsource_vars[2]);
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"get defense planet id pour ".$user_planetsource_vars[1]."(".$user_planetsource_vars[2].") -> (".$target_planet_id.")\n");

    if ($target_planet_id!=0) 
	{
      	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"insertion defense en ".$target_planet_id."\n");
      	$query = "SELECT planet_id, `fields`, temperature, Sat FROM ".TABLE_USER_BUILDING." WHERE user_id=".$user_id." and planet_id=".$target_planet_id.";";
        if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"\nrequète recherche valeur à récupérer : ".$query."\n");
        $res = $db->sql_query($query, true, $log_sql_errors);
        list($prev_planetid, $prev_fields, $prev_temperature, $prev_satellite) = $db->sql_fetch_row($res);
		if ($ogspy_server_version==OGSPY_0302_VERCONST) $res_user_defence=plg_user_set_defence($buildings_content, $target_planet_id,$user_planetsource_vars[1], $prev_fields,  $user_planetsource_vars[2], $prev_temperature, $prev_satellite);
        
		elseif($ogspy_server_version==OGSPY_031_VERCONST) $res_user_defence=user_set_defence($buildings_content, $target_planet_id,$user_planetsource_vars[1], $prev_fields,  $user_planetsource_vars[2], $prev_temperature, $prev_satellite, true);                   
          
        if ($res_user_defence==true) SendHttpStatusCode("765");
      	else SendHttpStatusCode("766");
    }
	else 
	{
      	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"inserer planete avant\n");
		SendHttpStatusCode("743");
    }
    
	if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"retour setdefence\n");
    SendHttpStatusCode("766");
}


elseif (isset($pub_typ) && $pub_typ=="planetempire" && isset($pub_content) && !empty($pub_content))
{
	// GESTION PAGE EMPIRE PLANÉTES
	$empire_precontent = html_entity_decode(utf8_decode($pub_content));

    // si detection balise html, déformater...
    $empire_precontent = stripslashes($empire_precontent);
    if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"empire planètes: ".$empire_precontent."\n");

    if ($ogspy_server_version==OGSPY_0302_VERCONST) $res_user_empire=plg_user_set_all_empire($empire_precontent, "planets");
    elseif($ogspy_server_version==OGSPY_031_VERCONST) $res_user_empire=user_set_all_empire($empire_precontent, "planets", true);

    if ($res_user_empire==true) 
	{
      	SendHttpStatusCode("770");
	}
	else SendHttpStatusCode("771");
}


elseif (isset($pub_typ) && $pub_typ=="moonempire" && isset($pub_content) && !empty($pub_content))
{
	// GESTION PAGE EMPIRE LUNES 
	$empire_precontent = html_entity_decode(utf8_decode($pub_content));
	$empire_precontent = stripslashes($empire_precontent);
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"empire lunes: ".$empire_precontent."\n");	  
    
    if ($ogspy_server_version==OGSPY_0302_VERCONST) $res_user_empire=plg_user_set_all_empire($empire_precontent, "moons");
    elseif($ogspy_server_version==OGSPY_031_VERCONST) $res_user_empire=user_set_all_empire($empire_precontent, "moons", true);
    
    if ($res_user_empire==true) 
	{    
		SendHttpStatusCode("775");
    }
	else SendHttpStatusCode("776");
}


else
{ 
	// aucun param exploitable trouvé
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"nothing found...\n");
	if (defined("XTENSE_PLUGIN_DEBUG") && !isset($pub_content)) fwrite($fp,"pub_content non défini...\n");
    if (defined("XTENSE_PLUGIN_DEBUG") && !$pub_content=="") fwrite($fp,"pub_content vide...\n");
    if (defined("XTENSE_PLUGIN_DEBUG") && !isset($pub_planetsource)) fwrite($fp,"pub_planetsource non défini ...\n");
    if (defined("XTENSE_PLUGIN_DEBUG") && $pub_planetsource=="") fwrite($fp,"pub_planetsource vide ...\n");
	SendHttpStatusCode("757", true, true);
}


// FIN SCRIPT
if (defined("XTENSE_PLUGIN_DEBUG")) fclose($fp);
if (defined("XTENSE_PLUGIN_DEBUG")) fclose($fp_plgcmds);
if (defined("XTENSE_PLUGIN_DEBUG")) $sqlcodefile= fopen("tests/sqlerrorcodes.txt","w");
if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($sqlcodefile,"code erreur slq(fin script): ".mysql_errno($db->$dbselect)."-".mysql_error($db->$dbselect)."\n");
if (defined("XTENSE_PLUGIN_DEBUG")) fclose($sqlcodefile);

@ob_end_clean(); // vidage tampon;
?>
