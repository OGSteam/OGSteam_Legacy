<?php
/** $Id$ **/ 
/** 
 * Fichier d'installation d'ogspy : ROOT/install/install.php 
* @package OGSpy 
* @subpackage main 
* @author Kyser 
* @copyright Copyright &copy; 2007, http://ogsteam.fr/ 
* @version 4.00 ($Rev$) 
* @modified $Date$ 
* @link $HeadURL$ 
*/ 
if (!defined('IN_SPYOGAME') || !defined('INSTALL_IN_PROGRESS')) die("Hacking attempt");
define('PHP_VERSION_REQUIRED','5.0.0');
define('SQL_VERSION_REQUIRED','4.1');

// Si on ne peut pas charger la langue choisie : on retourne à l'index.
if(!isset($pub_lang) && isset($server_config['language'])) $pub_lang = $server_config['language'];
if(!isset($pub_lang) || !lang_load_page("install",$pub_lang)) redirection("?");
$lang_install = $pub_lang;

// Création du template
$tpl_install = new Template('tpl/install.tpl');

// Définition des différentes étapes de l'installation
$step = Array('config_control','config_db','config_account','config_uni','module_install','end_install','close_install');

// A quelle étape somme-nous ?
$pub_step = isset($pub_step)?intval($pub_step):0;
if($pub_step<0) redirection("?");

// Recherche du fichier ID (pour avoir les variables en cours d'installation (generade_id)
if ( file_exists ( '../parameters/id.php' ) )
   require_once ( '../parameters/id.php' );
// Est-ce qu'on recoit le formulaire des accès SQL ?
if(isset($pub_sgbd_server, $pub_sgbd_username, $pub_sgbd_password, $pub_sgbd_dbname,$pub_sgbd_tableprefix)){
	// Un prefix est defini et valide ?
	if (!empty($pub_sgbd_tableprefix) && !check_var($pub_sgbd_tableprefix , "Pseudo_Groupname", "", true) )
			$pub_error[] = L_('badcharacterstableprefix');	// Non, retour erreur
	else{
		// Oui, alors on attribut les variables
		list($table_prefix,$db_host,$db_user,$db_password,$db_database) = 
		Array($pub_sgbd_tableprefix,$pub_sgbd_server, $pub_sgbd_username, $pub_sgbd_password, $pub_sgbd_dbname);
	}
}

// Action de l'etape (en fonction de l'etape d'avant)
if($pub_step>0){
	
	// connexion au serveur SQL si possible
	if(isset($db_host)){
		$db = new sql_db($db_host, $db_user, $db_password, $db_database);
		$db_connected = $db->db_connect_id;
	}
	switch($step[$pub_step-1]){
	
	// Test des parametre de connexion a la db et sauvegarde si necessaire dans id.php
	case 'config_db':
		$pub_step--; // retour à l'etape précédente au cas ou y'a un bug
		if(isset($pub_sgbd_server) && !isset($db_host))
			// Aucune variable n'est défini : y'a certainement un probleme
			$pub_error[] = L_('badsqlconfig');
		elseif (!$db_connected)
			// La connexion a échoué
			$pub_error[] = L_('cantconnect');
		elseif (version_compare((str_replace('mysqlnd ', '', $mysqlVersion = mysql_get_client_info())), SQL_VERSION_REQUIRED, '<'))
			$pub_error[] = L_('SQL_Version_Error',$mysqlVersion,SQL_VERSION_REQUIRED);
		else{
			// Tout est ok, on peut créer le ficheir id temporaire, et effectivement aller à l'etape suivante
			if(mysql_select_db($db_database)){
				$pub_msgok[] = L_('SQLConnect_Success');
				$a=generate_id($db_host, $db_database, $db_user, $db_password, $table_prefix, false);
				if(isset($a))
					$pub_error[] = $a;
				else
					$pub_step++;
			} else $pub_error[] = L_('Wrong_DB_Name');
			if(defined('UPGRADE_IN_PROGRESS')) $pub_step++; // Il sagit d'une mise à jour, alors on saute l'étape User/Pass Admin
		}
		break;
		
	// Test de la validité du password et du pseudo. Si OK : Enregistrement dans id.php en temporaire
	case 'config_account':
		// On revérifie que la connexion est bonne (peu probable, mais sait-on jamais)
		if (!$db_connected) {
			$pub_error[] = L_('cantconnect');
			$pub_step = $pub_step - 2;
		}
		// Controle de la validité des données renvoyées
		if(!check_var($pub_admin_username,"Pseudo_Groupname")) $pub_error[] = L_('badcharacterslogin');
		if(!check_var($pub_admin_password,"Password")) $pub_error[] = L_('badcharacterslogin');
		if($pub_admin_password != $pub_admin_password2) $pub_error[] = L_('Passwords_NotMatch');
		// Si on ne retourne pas d'erreur, on regénére le id.php temporaire (avec les pseudo/pass)
		if(isset($pub_error)) 
			$pub_step = $pub_step - 1;
		else{
			$pub_msgok[] = L_('Admin_Create_Success');
			generate_id($db_host, $db_database, $db_user, $db_password, $table_prefix, false);
		}
		break;
		
	// Configuration de l'univers : Varification des valeurs données : si c'est OK, on peut créerla base
	case 'config_uni':
		
		// Controle des données retournées
		if (isset($pub_num_of_galaxies) && !check_var($pub_num_of_galaxies, "Galaxy","", true)
		||  isset($pub_num_of_systems) && !check_var($pub_num_of_systems, "Galaxy","", true)){
			$pub_error[] = L_('baduniconfig');
		}
		if(isset($pub_speeduni)) $pub_speeduni = intval($pub_speeduni);
		
		// Mise à jour ou nouvelle Installation?
		if(defined('UPGRADE_IN_PROGRESS')){
			include "upgrade_to_latest.php";
			$is_installation_db = $is_create_user_account = $is_create_1st_config = $up_to_date;
		}else{
			// Création de la base de donnée, du compte admin et des configuration si ce n'est pas déja fait ? (bouton précédent....)
			if(!isset($is_installation_db)) $is_installation_db = installation_db();
			if(!isset($is_create_user_account)) $is_create_user_account = create_user_account();
			if(!isset($is_create_1st_config)) $is_create_1st_config = create_1st_config();
		}
		
		// Code de retour
		if($is_installation_db==true && $is_create_user_account==true && $is_create_1st_config==true)
			$pub_msgok[] = L_('SQL_Installation_Success');
		else{
			if(!$is_installation_db=true) $pub_error[] = $is_installation_db;
			if(!$is_create_user_account=true) $pub_error[] = $is_create_user_account;
			if(!$is_create_1st_config=true) $pub_error[] = $is_create_1st_config;
		}
		
		// Génération du id.php temporaire
		generate_id($db_host, $db_database, $db_user, $db_password, $table_prefix, false);
		break;
		
	// Recherche, et installation des module complémentaire.
	case 'module_install':
		// Si on a renvoyé des valeurs de mod (des modules quoi)
		if(isset($pub_mod)){
			// Récupération des modules déjà installé
			$installed = Array();
			$db->sql_query('SELECT root, version FROM '.$table_prefix.'mod;');
			while(list($root,$version)=$db->sql_fetch_row()) { $installed[$root] = $version; }
			
			// Défilement des modules retourné, et inscription de ceux qui ne sont pas déjà installé
			foreach($pub_mod as $root => $v){
				$file_install = "mod/{$root}/install.php";
				$file_update = "mod/{$root}/update.php";
				$file_version = "../mod/{$root}/version.txt";
				$tmp = file_exists($file_version)?file($file_version):Array(false,0);
				$inst = !file_exists('../'.$file_install)||array_key_exists($root,$installed);
				$updt = ($inst)?file_exists('../'.$file_update)&&$tmp[0]!==false?version_compare($tmp[1],$installed[$root],'>'):false:false;
				if(!$inst) 
					$file_to_install[$root] = $file_install;
				elseif($updt){
					if(version_compare($tmp[1],$installed[$root],'>'))
						$file_to_install[$root] = $file_update;
				}
			}
		} else // On est déjà dans la pahse d'installation des modules, et tous ne sont pas installé
			if(isset($modules_link_to_install)) $pub_step--;
		// Génération du id.php temporaire (le dernier, avec les modules à installer)
		generate_id($db_host, $db_database, $db_user, $db_password, $table_prefix, false);
		break;
	
	// Fin de l'installation
	case 'end_install':
		// Génération du id.php final
		generate_id($db_host, $db_database, $db_user, $db_password, $table_prefix, true);
		break;
	}
}

// Affichage de l'etape
$tpl_install->CheckIf($step[$pub_step],true);

// Affichage des variables (en fonction de l'etape en cours)
switch($step[$pub_step]){
	
	// Etape 0 : Controle des prérequis pour installer un OGSpy
	case 'config_control':
		// Test
		/* check version of PHP */
		if(!($chk_Php = version_compare(PHP_VERSION,PHP_VERSION_REQUIRED,'>')))
		{
			$pub_warning[] = L_('Version_Php_Error',PHP_VERSION,PHP_VERSION_REQUIRED);
		}
		/* Check if folder /parameters/ is writable */
		//if(!($chk_Param = @chmod('../parameters',0777)))
		if(!($chk_Param = is_writable('../parameters')))
		{
			$pub_warning[] = L_('Param_chmod_Error');
		}
		/* Check if folder /journal/ is writable */
		//if(!($chk_Log = @chmod('../journal',0777)))
		if(!($chk_Log = is_writable('../journal')))
		{
			$pub_warning[] = L_('Log_chmod_Error');
		}
		/* Check if folder /mod/ is writable */
		//if(!($chk_Mod = @chmod('../mod',0777)))
		if(!($chk_Mod = is_writable('../mod')))
		{
			$pub_warning[] = L_('Mod_chmod_Error');
		}
		// Affichage des erreurs
		if(isset($pub_warning))
		{
			$next_step = 0;
			$pub_warning[] = L_('ConfigControl_Fail');
			$pub_warning = array_merge(Array(L_('installwarning')),$pub_warning);
		}
		else
		{
			$pub_msgok[] = L_('ConfigControl_Success');
		}
		// Affichage du résultat
		$err = '<span style="color:#FF0000;">'.L_('unwritable').'</span>';
		$ok = '<span style="color:#008000;">'.L_('writable').'</span>';
		$vars = Array(
			'controltitle' => L_('controltitle'),
			'PHP_Version'=>L_('PHP_Version',PHP_VERSION),
			'PHP_Version_value' => ($chk_Php?'<span style="color:#008000;">'.L_('basic_Yes').'</span>':'<span style="color:#ff0000;">'.L_('basic_No').'</span>'),
			'Files_Access' => 0,
			'Parameter_Access' => L_('Parameter_Access'),
			'Parameter_Access_value' => ($chk_Param?$ok:$err),
			'Journal_Access' => L_('Journal_Access'),
			'Journal_Access_value' => ($chk_Log?$ok:$err),
			'Mod_Access' => L_('Mod_Access'),
			'Mod_Access_value' => ($chk_Mod?$ok:$err),
		);break;
	
	// Etape 1 : Demande des infos pour le SQL
	case 'config_db':
		// Message d'info
		$pub_info[] = L_('Enter_SQL_Access');
		// Variables
		$vars = Array(
			'dbconfigtitle' => L_('dbconfigtitle').'&nbsp;'.help('install_SQL',"",'../'),
			'dbhostname' => L_('dbhostname').'&nbsp;'.help('install_SQL_hostname',"",'../'),
			'pub_sgbd_server' => isset($db_host) ? $db_host : "localhost",
			'dbname' => L_('dbname').'&nbsp;'.help('install_SQL_name',"",'../'),
			'pub_sgbd_dbname' => isset($db_database) ? $db_database : "",
			'dbusername' => L_('dbusername').'&nbsp;'.help('install_SQL_userpass',"",'../'),
			'pub_sgbd_username' => isset($db_user) ? $db_user : "",
			'dbpassword' => L_('dbpassword'),
			'dbtableprefix' => L_('dbtableprefix').'&nbsp;'.help('install_SQL_prefix',"",'../'),
			'pub_sgbd_tableprefix' => isset($table_prefix) ? $table_prefix : "ogspy_",
		);break;
	
	// Etape 2 : Création du compte Admin
	case 'config_account':
		// Message d'info
		$pub_info[] = L_('Enter_Admin_Access');
		// Variable
		$vars = Array(
			'adminconfigtitle' => L_('adminconfigtitle').'&nbsp;'.help('install_Admin',"",'../'),
			'adminloginname' => L_('adminloginname'),
			'pub_admin_username' => isset($pub_admin_username)?$pub_admin_username:'',
			'adminpassword' => L_('adminpassword').'&nbsp;'.help("profile_password", "", "../"),
			'adminpasswordconfirm' => L_('adminpasswordconfirm'),
		);break;
	
	// Etape 3 : Configuration des options de l'univers
	case 'config_uni':
		// Message d'info
		$pub_info[] = L_('OGSpy_1st_Config');
		// Cas d'une mise à jour : Récupération des configurations déjà défini.
		if(defined('UPGRADE_IN_PROGRESS')){
			init_serverconfig();
			if(isset($server_config['servername'])) $pub_servername = $server_config['servername'];
			if(isset($server_config['num_of_galaxies'])) $pub_num_of_galaxies = $server_config['num_of_galaxies'];
			if(isset($server_config['num_of_systems'])) $pub_num_of_systems = $server_config['num_of_systems'];
			if(isset($server_config['speed_uni'])) $pub_speeduni = $server_config['speed_uni'];
		}
		// Variable
		$vars = Array(
			'uniconfigtitle' => L_('uniconfigtitle').'&nbsp;'.help('install_Config',"",'../'),
			'pub_admin_username' => isset($pub_admin_username)?$pub_admin_username:'',
			'pub_admin_password' => isset($pub_admin_password)?$pub_admin_password:'',
			'servername' => L_('servername'),
			'pub_servername' => isset($pub_servername)?$pub_servername:L_('Cartography'),
			'numgalaxies' => L_('numgalaxies').'&nbsp;'.help("profile_galaxy", "", "../"),
			'pub_num_of_galaxies' => isset($pub_num_of_galaxies) ? $pub_num_of_galaxies : "9",
			'numsystems' => L_('numsystems').'&nbsp;'.help("profile_galaxy", "", "../"),
			'pub_num_of_systems' => isset($pub_num_of_systems) ? $pub_num_of_systems : "499",
			'speeduni' => L_('speeduni'),
			'pub_speeduni' => isset($pub_speeduni)?$pub_speeduni:'1',
			'ddr' => L_('ddr'),
			'common_Yes' => L_('basic_Yes'),
			'common_No' => L_('basic_No'),
			'ddr_selected_yes' => (isset($server_config['ddr'])&&$server_config['ddr']=='1')?'selected="selected"':'',
			'ddr_selected_no' => (isset($server_config['ddr'])&&$server_config['ddr']=='0')?'selected="selected"':'',
			'serverlanguage' => L_('serverlanguage').'&nbsp;'.help('install_Lang',"",'../'),
			'lang_list' => make_lang_list($lang_install),
			'parsinglanguage' => L_('parsinglanguage').'&nbsp;'.help('install_Parsing',"",'../'),
		);
		if(defined('UPGRADE_IN_PROGRESS')) $prev_step = $pub_step - 2; // 'il sagit d'une mise à jour, on ne retourne pas à l'étape de création du login mais directement aux accès dB
		break;
	
	// Etape 4 : Installation des modules
	case 'module_install':
		// Message d'info
		$pub_info[] = L_('Install_Modules_Inclued');
		// Recherche des modules déjà installé
		$installed = Array();$server_config["debug_log"]="1";
		$db->sql_query('SELECT root, version FROM '.$table_prefix.'mod;');
		while(list($root,$version)=$db->sql_fetch_row()) { $installed[$root] = $version; }
		
		// Création de la liste des modules avec le bouton pour les installer ou pas
		$inst_str = '<span style="color:#00FF00;display:inline;position:relative;float:right;width:100px;">'.L_('Already_Installed').'</span>';
		$updt_str = '<span style="color:#FFA500;display:inline;position:relative;float:right;width:100px;">'.L_('Installed_OutDate').'</span>';
		$folder = "../mod/";
		//on commence par Xtense
		$root = "Xtense";
		$file_version = "{$folder}{$root}/version.txt";
		$file_title = "{$folder}{$root}/lang/lang_".$server_config['language']."/infos.php";
		$file_install = "{$folder}{$root}/install.php";
		if(is_dir($folder.$root) && file_exists($file_version) && file_exists($file_title)){
			include($file_title);
			$title = (isset($lang['mod_title']) ? $lang['mod_title'] : 'undefined');
			unset($lang);
			$tmp = file($file_version);
			$name = "{$title}&nbsp;(".(array_key_exists($root,$installed)?$installed[$root]:trim($tmp[1])).")";
			$inst = array_key_exists($root,$installed);
			$updt = ($inst)?file_exists("{$folder}{$root}/update.php")?version_compare($tmp[1],$installed[$root],'>'):false:false;
			$tpl_install->loopVar('mod',Array(
				'name'=>$name,
				'info'=>($inst?$updt?$updt_str:$inst_str:''),
				'root'=>$root,
				'disable'=>file_exists($file_install)&&(!$inst||$updt)?false:true,
			));
		}
		//et ensuite les mods
		if ($dirlink = opendir($folder)) {
			while (($root = readdir($dirlink)) !== false) {
				if ($root == "Xtense") continue;
				$file_version = "{$folder}{$root}/version.txt";
				$file_title = "{$folder}{$root}/lang/lang_".$server_config['language']."/infos.php";
				$file_install = "{$folder}{$root}/install.php";
				if(is_dir($folder.$root) && file_exists($file_version) && file_exists($file_title)){
					include($file_title);
					$title = (isset($lang['mod_title']) ? $lang['mod_title'] : 'undefined');
					unset($lang);
					$tmp = file($file_version);
					$name = "{$title}&nbsp;(".(array_key_exists($root,$installed)?$installed[$root]:trim($tmp[1])).")";
					$inst = array_key_exists($root,$installed);
					$updt = ($inst)?file_exists("{$folder}{$root}/update.php")?version_compare($tmp[1],$installed[$root],'>'):false:false;
					$tpl_install->loopVar('mod',Array(
						'name'=>$name,
						'info'=>($inst?$updt?$updt_str:$inst_str:''),
						'root'=>$root,
						'disable'=>file_exists($file_install)&&(!$inst||$updt)?false:true,
					));
				}
			}
		} else // Pas de liste de module, y'a un probleme avec le dossier ?
			$php_error = L_('Unable_Open_Mod');
		if(!isset($name)) $tpl_install->loopVar('mod',Array('name'=>'','disable'=>' disabled'));
		// Variables
		$vars = Array(
			'Mod_Name' => L_('Mod_Name').'&nbsp;'.help('install_Module',"",'../'),
			'Install_Button' => L_('Install_Button'),
		);
		break;
		
	// Fin de l'installation
	case 'end_install':
		// Y'a-t-til des fichiers à installer ? Si oui, alors on devrait retourner à l'index d'OGSpy pour terminer ça.
		if(isset($file_to_install)) redirection('../?');
		// Variables
		$vars = Array(
			'Thanks_For_Having_Installed_OGSpy' => L_('Thanks_For_Having_Installed_OGSpy'),
			'installsuccess' => L_('installsuccess',$install_version),
			'end_install_notes' => L_('end_install_notes'),
			'deleteinstall' => L_('deleteinstall'),
			'end_install_button' => L_('end_install_button'),
		);
		break;
	case 'close_install':
		// Affichage de la page de fin d'installation
		$vars = Array(
			'Thanks_For_Having_Installed_OGSpy' => L_('Thanks_For_Having_Installed_OGSpy'),
			'installsuccess' => L_('installsuccess',$install_version),
			'deleteinstall' => L_('deleteinstall'),
			'Return_to_OGSpy' => L_('Return_to_OGSpy'),
		);
	

}
// Affichage d'erreur, de succes ou d'info ?
$tpl_install->CheckIf('is_error',isset($pub_error));
$tpl_install->CheckIf('is_warning',isset($pub_warning));
$tpl_install->CheckIf('is_msgok',isset($pub_msgok));
$tpl_install->CheckIf('is_info',isset($pub_info));
// Mise à jour ou nouvelle install ?
$tpl_install->CheckIf('is_update',defined('UPGRADE_IN_PROGRESS'));

// Variables de l'etape en cours
if(isset($vars)) $tpl_install->SimpleVar($vars);

// Variable communes
$tpl_install->SimpleVar(Array(
	'lang_install' => $lang_install,
	'installwelcome' => defined('UPGRADE_IN_PROGRESS')?L_('updatewelcome',$install_version):L_('installwelcome',$install_version),
	'next_step' => isset($next_step)?$next_step:$pub_step+1,
	'prev_step' => isset($prev_step)?$prev_step:$pub_step-1,
	'next_step_style' => "",
	'needhelp' => L_('needhelp'),
	'pub_warning' => isset($pub_warning)?implode('<br/>',$pub_warning):'',
	'pub_error' => isset($pub_error)?implode('<br/>',$pub_error):'',
	'pub_msgok' => isset($pub_msgok)?implode('<br/>',$pub_msgok):'',
	'pub_info' => isset($pub_info)?implode('<br/>',$pub_info):'',
	'next_step_style'=>isset($bug)?'disabled="disabled"':"",
));

// Inscription de la page
$tpl_install->parse();




/**
* Affiche une boite d'erreur d'installation et quitte le script
* @var string $message Message d'erreur
*/
function error_sql($message) {
	echo "<h3 align='center'><font color='red'>".L_('sqlerror')."</font></h3>";
	echo "<center><b>- ".$message."</b></center>";
	exit();
}

/**
 * Création de la structure de la base de donnée
 */
function installation_db() {
	global $db,$table_prefix,$install_version;

	//Création de la structure de la base de données
	$sql_query = @fread(@fopen("schemas/ogspy_structure.sql", 'r'), @filesize("schemas/ogspy_structure.sql")) or die("<h1>".L_('noinstallscript')."</h1>");

	$sql_query = preg_replace("#ogspy_#", $table_prefix, $sql_query);
	$sql_query = explode(";", $sql_query);

	$db->sql_query("ALTER DATABASE `".$db->dbname."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
	foreach ($sql_query as $request) {
		if (trim($request) != "") {
			if (!($result = $db->sql_query($request, false, false))) {
				$error = $db->sql_error($result);
				print $request;
				return error_sql($error['message']);
			}
		}
	}
	return true;
/*		
	generate_id($sgbd_server, $sgbd_dbname, $sgbd_username, $sgbd_password, $sgbd_tableprefix);//*/
}

/**
 * Création du compte Admin
 */
function create_user_account(){
	global $db,$lang_install,$table_prefix,$pub_admin_username,$pub_admin_password;
	$sql_query[] = "REPLACE INTO ".$table_prefix."user_group (group_id, user_id) values (1, 1)";
	$sql_query[] = "REPLACE INTO ".$table_prefix."user (user_id, user_name, user_password, user_regdate, user_active, user_admin, user_language)".
	" values (1, '".mysql_real_escape_string($pub_admin_username)."', '".md5(sha1($pub_admin_password))."', ".time().", '1', '1','".$lang_install."')";
	foreach ($sql_query as $request) {
		if (trim($request) != "") {
			if (!($result = $db->sql_query($request, false, false))) {
				$error = $db->sql_error($result);
				print $request;
				return error_sql($error['message']);
			}
		}
	}
	return true;
}

/**
 * Enregistrement des valeurs de configuration par défault et saisie par l'utilisateur.
 *
 */
function create_1st_config(){
	global $db,$install_version,$table_prefix,$pub_num_of_galaxies,$pub_num_of_systems,$pub_speeduni,$pub_ddr,$pub_serverlanguage,$pub_parsinglanguage,$pub_servername;
	$sql_query[] = "REPLACE INTO ".$table_prefix."config (config_name, config_value) VALUES ('version','".$install_version."')";
	$sql_query[] = "REPLACE INTO ".$table_prefix."config (config_name, config_value) VALUES ('num_of_galaxies','".$pub_num_of_galaxies."')";
	$sql_query[] = "REPLACE INTO ".$table_prefix."config (config_name, config_value) VALUES ('num_of_systems','".$pub_num_of_systems."')";
	$sql_query[] = "REPLACE INTO ".$table_prefix."config (config_name, config_value) VALUES ('speed_uni','".$pub_speeduni."')";
	$sql_query[] = "REPLACE INTO ".$table_prefix."config (config_name, config_value) VALUES ('ddr','".$pub_ddr."')";
	$sql_query[] = "REPLACE INTO ".$table_prefix."config (config_name, config_value) VALUES ('language','".$pub_serverlanguage."')";
	$sql_query[] = "REPLACE INTO ".$table_prefix."config (config_name, config_value) VALUES ('language_parsing','".$pub_parsinglanguage."')";
	$sql_query[] = "REPLACE INTO ".$table_prefix."config (config_name, config_value) VALUES ('servername', '".$pub_servername."')";
	foreach ($sql_query as $request) {
		if (trim($request) != "") {
			if (!($result = $db->sql_query($request, false, false))) {
				$error = $db->sql_error($result);
				print $request;
				return error_sql($error['message']);
			}
		}
	}
	return true;
}
/**
* Création du fichier de configuration id.php et quitte le script
* @var string $sgbd_server Serveur MySql (localhost)
* @var string $sgbd_username Utilisateur Base de donnée
* @var string $sgbd_password Mot de passe Base de donnée
* @var string $sgbd_tableprefix Préfixe à utiliser pour les tables ogspy
* @var boolean $installed ID.PHP Final : Vrai ou Faux. Permet de générer un id.php temporaire en cours d'installation
*/
function generate_id($sgbd_server, $sgbd_dbname, $sgbd_username, $sgbd_password, $sgbd_tableprefix, $installed = true) {
	global $install_version, $pub_step,$pub_admin_username,$pub_admin_password,$pub_admin_password2,$lang_install,$is_installation_db,$is_create_user_account,$is_create_1st_config,$file_to_install,$pub_serverlanguage,$pub_parsinglanguage;
	if(!isset($pub_serverlanguage)&&isset($server_config["language"])) $pub_serverlanguage = $server_config["language"];
	if(!isset($pub_parsinglanguage)&&isset($server_config["language_parsing"])) $pub_parsinglanguage = $server_config["language_parsing"];
	$id_php[] = '<?php';
	$id_php[] = '/***************************************************************************';
	$id_php[] = '*	filename	: id.php';
	$id_php[] = '*	generated	: '.date("d/M/Y H:i:s");
	$id_php[] = '***************************************************************************/';
	$id_php[] = '';
	$id_php[] = 'if (!defined("IN_SPYOGAME")) die("Hacking attempt");';
	$id_php[] = '';
	$id_php[] = '$table_prefix = "'.$sgbd_tableprefix.'";';
	$id_php[] = '';
	$id_php[] = '//Paramètres de connexion à la base de données';
	$id_php[] = '$db_host = "'.$sgbd_server.'";';
	$id_php[] = '$db_user = "'.$sgbd_username.'";';
	$id_php[] = '$db_password = "'.$sgbd_password.'";';
	$id_php[] = '$db_database = "'.$sgbd_dbname.'";';
	$id_php[] = '';
	if($installed) 
		$id_php[] = 'define("OGSPY_INSTALLED", "TRUE");';
	else{
		$id_php[] = 'define("INSTALL_STEP","'.$pub_step.'");';
		if(defined('UPGRADE_IN_PROGRESS')) $id_php[] = 'if(!defined("UPGRADE_IN_PROGRESS")) define("UPGRADE_IN_PROGRESS","'.UPGRADE_IN_PROGRESS.'");';
		if(isset($is_installation_db)) $id_php[] = '$is_installation_db = true;';
		if(isset($is_create_user_account)) $id_php[] = '$is_create_user_account = true;';
		if(isset($is_create_1st_config)) $id_php[] = '$is_create_1st_config = true;';
		if(isset($pub_admin_username)){
			$id_php[] = '$pub_admin_username = "'.$pub_admin_username.'";';
			$id_php[] = '$pub_admin_password = "'.$pub_admin_password.'";';
			$id_php[] = '$pub_admin_password2 = "'.$pub_admin_password2.'";';
			$lg = isset($pub_serverlanguage)?$pub_serverlanguage:(isset($server_config["language"])?$server_config["language"]:$lang_install);
			$id_php[] = '$server_config["language"] = "'.$lg.'";';
			$lg = isset($pub_parsinglanguage)?$pub_parsinglanguage:(isset($server_config["language_parsing"])?$server_config["language_parsing"]:$lang_install);
			$id_php[] = '$server_config["language_parsing"] = "'.$lg.'";';
		}
		if(isset($file_to_install)&&!empty($file_to_install)){
			$name = Array();
			foreach($file_to_install as $i => $v)
				$name[] = '"'.$i.'" => "'.$v.'"';
			$id_php[] = '$modules_link_to_install = Array('.implode(',',$name).');';
		}
	}
	$id_php[] = '?>';
	if (!write_file("../parameters/id.php", "w", $id_php)) 
		return L_('installfail');
	return NULL;
}
