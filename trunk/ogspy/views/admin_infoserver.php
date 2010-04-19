<?php
/** $Id$ **/
/**
* Panneau d'administration : vue d'information
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Statistiques du serveur
$connection_server = 0;
$connection_ogs = 0;
$planetimport_server = 0;
$spyimport_server = 0;
$planetimport_ogs = 0;
$spyimport_ogs = 0;
$rankimport_ogs = 0;
$rankimport_server = 0;

$request = "select statistic_name, statistic_value from ".TABLE_STATISTIC;
$result = $db->sql_query($request);
while (list($statistic_name, $statistic_value) = $db->sql_fetch_row($result)) {
	switch ($statistic_name) {
		case "connection_server":	$connection_server = $statistic_value;		break;
		case "connection_ogs":		$connection_ogs = $statistic_value;			break;

		case "planetimport_server":	$planetimport_server = $statistic_value;	break;
		case "spyimport_server":	$spyimport_server = $statistic_value;		break;

		case "planetimport_ogs":	$planetimport_ogs = $statistic_value;		break;

		case "spyimport_ogs":		$spyimport_ogs = $statistic_value;			break;

		case "rankimport_ogs":		$rankimport_ogs = $statistic_value;			break;
		case "rankimport_server":	$rankimport_server = $statistic_value;		break;
	}
}

if(isset($pub_ajax)){
		//Vérification version installée et envoi de statistiques
	preg_match("#^(\d+).(\d+)([_a-z]*)?$#", $server_config["version"], $current_version);
	//@list($current_version, $head_revision, $minor_revision, $extension_revision) = $current_version;
	foreach(array('current_version','head_revision','minor_revision','extension_revision') as $i => $tmp)
		${$tmp} = isset($current_version[$i])?$current_version[$i]:NULL;

	$errno = 0;
	$errstr = $version_info = '';

		//proxy patch by Cerber 
	//based on http://us2.php.net/manual/en/function.fsockopen.php#58196 
	//vrai si on doit passer par un proxy, faux sinon 
	$proxy_use  = FALSE; 
	//Nom du serveur de proxy 
	$proxy_name = 'proxy'; 
	//port utilisé par le serveur proxy 
	$proxy_port = 3128; 
	//utilisateur du proxy 
	$proxy_user = ''; 
	//mot de passe de l'utilisateur 
	$proxy_pass = ''; 

	//Adresse du serveur a contacter 
	$url_server = "ogsteam.fr";
	//port du serveur spécifié en hard dans le code 

	$fsock = FALSE; 
	if($proxy_use){ 
		//on utlise le proxy 
		$fsock = @fsockopen($proxy_name, $proxy_port, $errno, $errstr, 3); 
	}else{ 
		//pas de proxy 
		$fsock = @fsockopen($url_server, 80, $errno, $errstr, 3); 
	} 
	$ajax_return['up_to_date'] = false;
	$ajax_return['version'] = "";
	$ajax_return['link'] = "http://board.ogsteam.fr/";
	$ajax_return['linkmessage'] = "Forum OGSteam";

	if ($fsock) { 
		//paramètres de la requete
		$link = "/updatecheck/latest.php";
		$link .= "?version=".$server_config["version"];

		$link .= "&connection_server=".$connection_server;
		$link .= "&connection_ogs=".$connection_ogs;

		$link .= "&planetimport_server=".$planetimport_server;
		$link .= "&spyimport_server=".$spyimport_server;

		$link .= "&planetimport_ogs=".$planetimport_ogs;
		$link .= "&planetexport_ogs=0"; // Compatibility Update script

		$link .= "&spyimport_ogs=".$spyimport_ogs;
		$link .= "&spyexport_ogs=0"; // Compatibility Update script

		$link .= "&rankimport_ogs=".$rankimport_ogs;
		$link .= "&rankexport_ogs=0"; // Compatibility Update script
		$link .= "&rankimport_server=".$rankimport_server;
  
		if($proxy_use){ 
			//si on passe par le proxy ==> requête sauce proxy 

			//création de l'url réellement recherchée 
			$request_url = "http://$url_server:80$link"; 
			//appel de l'url via le proxy 
			@fputs($fsock, "GET $request_url HTTP/1.0\r\nHost: $proxy_name\r\n"); 
			if(isset($proxy_user) && $proxy_user!=''){ 
			//ajout du login + pass si dispo 
			@fputs($fsock, "Proxy-Authorization: Basic ". base64_encode ("$proxy_user:$proxy_pass")."\r\n"); 
			} 
			//demande de cloture de connexion 
			@fputs($fsock, "Connection: close\r\n\r\n"); 
		}else{ 
			//pas de proxy ==> code standard 
			@fputs($fsock, "GET ".$link." HTTP/1.1\r\n"); 
			@fputs($fsock, "HOST: ".$url_server."\r\n"); 
			@fputs($fsock, "Connection: close\r\n\r\n"); 
		} 

		$get_info = false;
		while (!@feof($fsock)) {
			if ($get_info) {
				$version_info .= @fread($fsock, 1024);
			}
			else {
				if (@fgets($fsock, 1024) == "\r\n") {
					$get_info = true;
				}
			}
		}
		@fclose($fsock);
		$ajax_return['version_checked'] = true;
		if (preg_match("#€(\d+\.\d+[_a-z]*)€#m", $version_info, $version_info)) {
			preg_match("#(\d+).(\d+)([_a-z]*)?#", $version_info[1], $version_info);

			@list($latest_version, $latest_head_revision, $latest_minor_revision, $latest_extension_revision) = $version_info;
//			$version_info = $latest_version;
			$ajax_return['version'] = $latest_version;

			if ($head_revision == $latest_head_revision && $minor_revision == $latest_minor_revision && $extension_revision == $latest_extension_revision) {
//				$version_info = "<font color='lime'><b>".L_("admin_ServerUpToDate")."</b></font>";
				$ajax_return['message'] = L_("admin_ServerUpToDate");
				$ajax_return['message2'] = L_('admin_ServerUpToDateMessage');
				$ajax_return['up_to_date'] = true;
			}
			else {
//				$version_info = "<blink><b><font color='red'>".L_("admin_ServerNeedUpDate")."</font></blink>";
//				$version_info .= "<br />".L_("admin_ServerUpDateMessage")."<font color='red'>".$latest_version."</b>";
				$ajax_return['message'] = L_("admin_ServerNeedUpDate");
				$ajax_return['message2'] = L_("admin_ServerUpDateMessage");
				$ajax_return['up_to_date'] = false;
			}
		}
		else {
//			$version_info = "<blink><b><font color='orange'>".L_("admin_ServerUpDateCheckError")."</font></blink>";
//			$version_info .= "<br />".L_("admin_ServerUpDateMessage")."</b>";
			$ajax_return['message'] = L_("admin_ServerUpDateCheckError");
			$ajax_return['message2'] = L_("admin_ServerUpDateMessage");
		}
	}
	else {
//		$version_info = "<blink><b><font color='orange'>".L_("admin_CantCheckVersion")."</font></blink>";
//		$version_info .= "<br />".L_("admin_CantCheckReason");
//		$version_info .= "<br />".L_("admin_ServerUpDateMessage")."</b>";
		$ajax_return['version_checked'] = false;
		$ajax_return['message'] = L_("admin_CantCheckVersion");
		$ajax_return['message2'] = L_("admin_CantCheckReason");
		
	}
	//ajax_return($version_info);
	
	if (isset($ajax_return))
		die(json_encode($ajax_return));
	
	exit();
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	redirection("?action=message&amp;id_message=forbidden&info");
}

//Statistiques concernant la base de données
$db_size_info = db_size_info();
if ($db_size_info["Server"] == $db_size_info["Total"]) {
	$db_size_info = $db_size_info["Server"];
}
else {
	$db_size_info = $db_size_info["Server"]." sur ".$db_size_info["Total"];
}

//Statistiques concernant les fichiers journal
$log_size_info = log_size_info();
$log_size_info = $log_size_info["size"]." ".$log_size_info["type"];

//Statistisques concernant l'univers
$galaxy_statistic = galaxy_statistic();

//Statistics concernant les membres
$users_info = sizeof(user_statistic());

//on compte le nombre de personnes en ligne
$connectes_req = $db->sql_query("SELECT COUNT(session_ip) FROM ".TABLE_SESSIONS);
list ($connectes) = $db->sql_fetch_row ($connectes_req);

//Personne en ligne
$online = session_whois_online();
if (file_exists($user_data['user_skin'].'\templates\admin_infoserver.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\admin_infoserver.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\admin_infoserver.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\admin_infoserver.tpl');
}
else
{
    $tpl = new template('admin_infoserver.tpl');
}
$tpl->SimpleVar(Array(
	'admin_Column1' => L_("admin_Column1"),
	'admin_Column2' => L_("admin_Column2"),
	'admin_CountMember' => L_("admin_CountMember"),
	'users_info' => $users_info,
	'admin_CountFreePlanet' => L_("admin_CountFreePlanet"),
	'nb_planets_free' => formate_number($galaxy_statistic["nb_planets_free"]),
	'admin_CountPlanet' => L_("admin_CountPlanet"),
	'nb_planets' => formate_number($galaxy_statistic["nb_planets"]),
	'admin_DBSize' => L_("admin_DBSize"),
	'db_size_info' => $db_size_info,
	'admin_LogSize' => L_("admin_LogSize"),
	'log_size_info' => $log_size_info,
	'admin_OptimizeDB_link' => '?action=db_optimize',
	'admin_OptimizeDB' => L_("admin_OptimizeDB"),
	'admin_CountSessionOpen' => L_("admin_CountSessionOpen"),
	'connectes' => $connectes,
	'admin_drop_sessions_link' => '?action=drop_sessions',
	'admin_drop_sessions' => L_('admin_drop_sessions')."&nbsp;".help("drop_sessions"),
	'admin_update_RE' => L_('admin_update_RE'),
	'admin_ServerConnection' => L_("admin_ServerConnection"),
	'connection_server' => formate_number($connection_server),
	'admin_OGSConnection' => L_("admin_OGSConnection"),
	'connection_ogs' => formate_number($connection_ogs),
	'admin_ServerPlanets' => L_("admin_ServerPlanets"),
	'planetimport_server' => formate_number($planetimport_server)."&nbsp;".L_("admin_import"),
	'admin_OGSPlanets' => L_("admin_OGSPlanets"),
	'planetimport_ogs' => formate_number($planetimport_ogs)."&nbsp;".L_("admin_import"),
	'admin_ServerSpy' => L_("admin_ServerSpy"),
	'spyimport_server' => formate_number($spyimport_server)."&nbsp;".L_("admin_import"),
	'admin_OGSSpy' => L_("admin_OGSSpy"),
	'spyimport_ogs' => formate_number($spyimport_ogs)."&nbsp;".L_("admin_import"),
	'admin_ServerRanking' => L_("admin_ServerRanking"),
	'rankimport_server' => formate_number($rankimport_server)."&nbsp;".L_("admin_import"),
	'admin_OGSRanking' => L_("admin_OGSRanking"),
	'rankimport_ogs' => formate_number($rankimport_ogs)."&nbsp;".L_("admin_import"),
	'admin_VersionInformation' => L_("admin_VersionInformation"),
	'admin_MemberName' => L_("admin_MemberName"),
	'admin_Connection' => L_("admin_Connection"),
	'admin_LastActivity' => L_("admin_LastActivity"),
	'admin_IPAddress' => L_("admin_IPAddress")
	));


foreach ($online as $v) {
	$user = $v["user"];
	if ( $v['time_start'] == 0 ) $v['time_start'] = $v["time_lastactivity"];
	$time_start = strftime("%d %b %Y %H:%M:%S", $v["time_start"]);
	$time_lastactivity =  strftime("%d %b %Y %H:%M:%S", $v["time_lastactivity"]);
	$ip = $v["ip"];
	$ogs = $v["ogs"] == 1 ? "(OGS)" : "";
	$tpl->loopVar('users_list',Array(
		'name'=>$user." ".$ogs,
		'connexion'=>$time_start,
		'time'=>$time_lastactivity,
		'ip'=>$ip
		));
}
//make_ajax_script(false, 'ajax','ajax');
$tpl->parse();
?>
