<?php
/***************************************************************************
*	filename	: admin_members.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 16/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}

//Statistiques concernant la base de donn�es
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

//Statistiques du serveur
$connection_server = 0;
$connection_spacs = 0;
$planetimport_server = 0;
$spyimport_server = 0;
$planetimport_spacs = 0;
$planetexport_spacs = 0;
$spyimport_spacs = 0;
$spyexport_spacs = 0;
$rankimport_spacs = 0;
$rankexport_spacs = 0;
$rankimport_server = 0;

$request = "select statistic_name, statistic_value from ".TABLE_STATISTIC;
$result = $db->sql_query($request);
while (list($statistic_name, $statistic_value) = $db->sql_fetch_row($result)) {
	switch ($statistic_name) {
		case "connection_server":	$connection_server = $statistic_value;		break;
		case "connection_spacs":		$connection_spacs = $statistic_value;			break;

		case "planetimport_server":	$planetimport_server = $statistic_value;	break;
		case "spyimport_server":	$spyimport_server = $statistic_value;		break;

		case "planetimport_spacs":	$planetimport_spacs = $statistic_value;		break;
		case "planetexport_spacs":	$planetexport_spacs = $statistic_value;		break;

		case "spyimport_spacs":		$spyimport_spacs = $statistic_value;			break;
		case "spyexport_spacs":		$spyexport_spacs = $statistic_value;			break;

		case "rankimport_spacs":		$rankimport_spacs = $statistic_value;			break;
		case "rankexport_spacs":		$rankexport_spacs = $statistic_value;			break;
		case "rankimport_server":	$rankimport_server = $statistic_value;		break;
	}
}

//Personne en ligne
$online = session_whois_online();


//V�rification version install�e et envoi de statistiques
preg_match("#^(\d+).(\d+)([_a-z]*)?$#", $server_config["version"], $current_version);
@list($current_version, $head_revision, $minor_revision, $extension_revision) = $current_version;

$errno = 0;
$errstr = $version_info = '';

	//proxy patch by Cerber 
//based on http://us2.php.net/manual/en/function.fsockopen.php#58196 
//vrai si on doit passer par un proxy, faux sinon 
$proxy_use  = FALSE; 
//Nom du serveur de proxy 
$proxy_name = 'proxy'; 
//port utilis� par le serveur proxy 
$proxy_port = 3128; 
//utilisateur du proxy 
$proxy_user = ''; 
//mot de passe de l'utilisateur 
$proxy_pass = ''; 

//Adresse du serveur a contacter 
$url_server = "wepper.free.fr";
//port du serveur sp�cifi� en hard dans le code 

$fsock = FALSE; 
if($proxy_use){ 
	//on utlise le proxy 
	$fsock = @fsockopen($proxy_name, $proxy_port, $errno, $errstr, 3); 
}else{ 
	//pas de proxy 
	$fsock = @fsockopen($url_server, 80, $errno, $errstr, 3); 
} 

if ($fsock) { 
	//param�tres de la requete
	$link = "/spacspyversion/latest_version.php";
  
	if($proxy_use){ 
		//si on passe par le proxy ==> requ�te sauce proxy 

		//cr�ation de l'url r�ellement recherch�e 
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
			$version_info_link .= @fread($fsock, 1024);
		}
		else {
			if (@fgets($fsock, 1024) == "\r\n") {
				$get_info = true;
			}
		}
	}
	@fclose($fsock);

	if (preg_match("#�(\d+\.\d+[_a-z]*)�([^�]+)�#m", $version_info_link, $version_info_link)) {
		@list($version_info_link, $version_info, $version_link) = $version_info_link;
		preg_match("#(\d+).(\d+)([_a-z]*)?#", $version_info, $version_info);

		@list($latest_version, $latest_head_revision, $latest_minor_revision, $latest_extension_revision) = $version_info;
		$version_info = $latest_version;

		if ($head_revision == $latest_head_revision && $minor_revision == $latest_minor_revision && $extension_revision == $latest_extension_revision) {
			$version_info = "<font color='lime'><b>Votre serveur SpacSpy est � jour.</b></font>";
		}
		else {
			$version_info = "<blink><b><font color='red'>Votre serveur SpacSpy n'est pas � jour.</font></blink>";
			$version_info .= "<br />Downloader la derni�re version ici: <a href='".$version_link."' target='_blank'>".$latest_version."</a>";
		}
	}
	else {
		$version_info = "<blink><b><font color='orange'>Une incoh�rence a �t� rencontr�e avec le serveur de contr�le de version.</font></blink>";
		$version_info .= "<br />Consulter le <a href='http://ogsteam.fr/forums/index.php' target='_blank'>forum</a> d�di� au support d'SpacSpy pour en conna�tre la raison.</b>";
	}
}
else {
	$version_info = "<blink><b><font color='orange'>Impossible de r�cup�rer le num�ro de la derni�re version car le lien n'a pas pu �tre �tablie avec le serveur de contr�le.</font></blink>";
	$version_info .= "<br />Il se peut que ce soit votre h�bergeur qui n'autorise pas cette action.";
	$version_info .= "<br />Il vous faudra consulter r�guli�rement le <a href='http://ogsteam.fr/forums/index.php' target='_blank'>forum</a> d�di� au support d'SpacSpy pour prendre connaissance des nouvelles versions.</b>";
}
?>

<table width="100%">
<tr>
	<td class="c" width="25%">Statistiques</td><td class="c" width="25%">Valeur</td>
	<td class="c" width="25%">Statistiques</td><td class="c" width="25%">Valeur</td>
</tr>
<tr>
	<th><a>Nombre de membres</a></th><th><?php echo $users_info;?></th>
	<th>&nbsp;</th><th>&nbsp;</th>
</tr>
<tr>
	<th><a>Nombre de plan�tes r�pertori�es</a></th><th><?php echo formate_number($galaxy_statistic["nb_planets"]);?></th>
	<th><a>Nombre de plan�tes r�pertori�es libres</a></th><th><?php echo formate_number($galaxy_statistic["nb_planets_free"]);?></th>
</tr>
<tr>
	<th><a>Espace occup� par les lspacs</a></th><th><?php echo $log_size_info;?></th>
	<th rowspan="2"><a>Espace occup� par la base de donn�es</a></th><th><?php echo $db_size_info;?></th>
</tr>
<tr>
	<th>&nbsp;</th><th>&nbsp;</th>
	<th><a href="index.php?action=db_optimize"><i>Optimiser la base de donn�es</i></a></th>
</tr>
<tr>
	<th>&nbsp;</th><th>&nbsp;</th>
	<th>&nbsp;</th><th>&nbsp;</th>
</tr>
<tr>
	<th><a>Connexions [Serveur]</a></th><th><?php echo formate_number($connection_server);?></th>
	<th><a>Connexions [spacs]</a></th><th><?php echo formate_number($connection_spacs);?></th>
</tr>
<tr>
	<th><a>Plan�tes [Serveur]</a></th><th><?php echo formate_number($planetimport_server);?> importations</th>
	<th><a>Plan�tes [spacs]</a></th><th><?php echo formate_number($planetimport_spacs);?> importations - <?php echo formate_number($planetexport_spacs);?> exportations</th>
</tr>
<tr>
	<th><a>Rapports espionnage [Serveur]</a></th><th><?php echo formate_number($spyimport_server);?> importations</th>
	<th><a>Rapports espionnage [spacs]</a></th><th><?php echo formate_number($spyimport_spacs);?> importations - <?php echo formate_number($spyexport_spacs);?> exportations</th>
</tr>
<tr>
	<th><a>Classement (nombre de lignes) [Serveur]</a></th><th><?php echo formate_number($rankimport_server);?> importations</th>
	<th><a>Classement (nombre de lignes) [spacs]</a></th><th><?php echo formate_number($rankimport_spacs);?> importations - <?php echo formate_number($rankexport_spacs);?> exportations</th>
</tr>
<!--<tr>
	<th><a>Rapports de combats [Serveur]</a></th><th>x importations</th>
	<th><a>Rapports de combats [spacs]</a></th><th>x importations - x exportations</th>
</tr>-->
<tr>
	<td class="c" colspan="4">&nbsp;</th>
</tr>
<tr>
	<th colspan="2"><a href="php/phpinfo.php" target="_blank"a>PHPInfo</a></th>
	<th colspan="2"><a href="php/phpmodules.php" target="_blank"a>Modules PHP</a></th>
</tr>
</table>
<br />
<table width="100%">
<tr>
	<td class="c" colspan="4">Information de version</td>
</tr>
<tr>
	<th>Version Actuel</th>
	<th><?php echo $server_config["version"];?></th>
	<th>Derni�re Version Disponible</th>
	<th><?php echo $latest_version;?></th>
</tr>
<tr>
	<th style="text-align:left" colspan="4"><?php echo $version_info;?></th>
</tr>
</table>
<br />
<table width="100%">
<tr>
	<td class="c">Nom de membre</td>
	<td class="c">Connexion</td>
	<td class="c">Derni�re activit�</td>
	<td class="c">Adresse IP</td>
</tr>
<?php
foreach ($online as $v) {
	$user = $v["user"];
	$time_start = strftime("%d %b %Y %H:%M:%S", $v["time_start"]);
	$time_lastactivity =  strftime("%d %b %Y %H:%M:%S", $v["time_lastactivity"]);
	$ip = $v["ip"];
	$spacs = $v["spacs"] == 1 ? "(spacs)" : "";

	echo "<tr>";
	echo "\t"."<th width='25%'>".$user." ".$spacs."</th>";
	echo "\t"."<th width='25%'>".$time_start."</th>";
	echo "\t"."<th width='25%'>".$time_lastactivity."</th>";
	echo "\t"."<th width='25%'>".$ip."</th>";
	echo "</tr>";
}
?>
</table>