<?php
/** $Id$ **/
/**
* Fonctions de journalisation (log)  d'Ogspy
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 3.04b ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
global $ogspy_phperror;
$ogspy_phperror=Array();
/**
* Entr�e dans le journal d'une ligne d'information
* @param string $parameter type d'information
* @param mixed $option Donn�es optionnelles
*/
function log_ ($parameter, $option=0) {
	global $db, $user_data, $server_config,$pub_action;

	$member = "Inconnu";
	if (isset($user_data)) {
		$member = $user_data["user_name"];
	}

	switch ($parameter) {
		/* ----------- Entr�e Journal g�n�rique de Mod ----------- */		
		case 'mod':
		$line = "[$pub_action] ".$member." ";
		if (is_array($option)) {
			$line .= print_r($option,true);
		}else {
			$line .= $option;
		}
		break;

		/* ----------- Administration ----------- */		
		case 'set_serverconfig' :
		$line = "[admin] ".$member." modifie les param�tres du serveur";
		break;
		
		case 'set_server_view' :
		$line = "[admin] ".$member." modifie les param�tres d'affichage du serveur";
		break;
    
		case 'set_db_size' :
		$line = "[admin] ".$member." modifie la taille de l'univers sa nouvelle taille est galaxy:".$server_config['num_of_galaxies']." et system:".$server_config['num_of_systems'];
		break;
		
		case 'mod_install' :
		$line = "[admin] ".$member." installe le mod \"".$option."\"";
		break;
		
		case 'mod_update' :
		$line = "[admin] ".$member." met � jour le mod \"".$option."\"";
		break;
		
		case 'mod_uninstall' :
		$line = "[admin] ".$member." d�sinstalle le mod \"".$option."\"";
		break;
		
		case 'mod_active' :
		$line = "[admin] ".$member." active le mod \"".$option."\"";
		break;
		
		case 'mod_disable' :
		$line = "[admin] ".$member." d�sactive le mod \"".$option."\"";
		break;
		
		case 'mod_order' :
		$line = "[admin] ".$member." repositionne le mod \"".$option."\"";
		break;

		case 'mod_normal' :
		$line = "[admin] ".$member." affiche le mod aux utilisateurs \"".$option."\"";
		break;

		case 'mod_admin' :
		$line = "[admin] ".$member." cache le mod aux utilisateurs \"".$option."\"";
		break;

		/* ----------- Gestion syst�mes solaires et rapports ----------- */
		case 'load_system' :
		$line = $member." charge le syst�me solaire ".$option[0].":".$option[1];
		break;

		case 'load_system_OGS' :
		$line = $member." charge ".$option[0]." planetes via OGS : ".$option[1]." insertion(".$option[1]."), mise � jour(".$option[2]."), obsol�te(".$option[3]."), �chec(".$option[4].") - ".$option[5]." sec";
		break;

		case 'get_system_OGS' :
		if ($option != 0) $line = $member." r�cup�re les plan�tes de la galaxie ".$option;
		else $line = $member." r�cup�re toutes les plan�tes de l'univers";
		break;

		case 'load_spy' :
		$line = $member." charge ".$option." rapport(s) d'espionnage";
		break;

		case 'load_spy_OGS' :
		$line = $member." charge ".$option." rapport(s) d'espionnage via OGS";
		break;

		case 'export_spy_sector' :
		list($nb_spy, $galaxy, $system) = $option;
		$line = $member." r�cup�re ".$nb_spy." rapport(s) d'espionnage du syst�me [".$galaxy.":".$system."]";
		break;

		case 'export_spy_date' :
		list($nb_spy, $timestamp) = $option;
		$date = strftime("%d %b %Y %H:%M", $timestamp);
		$line = $member." r�cup�re ".$nb_spy." rapport(s) d'espionnage post�rieur au ".$date;
		break;

		/* ----------- Gestion des erreurs ----------- */
		case 'mysql_error' :
		$line = 'Erreur critique mysql - Req : '.$option[0].' - Erreur n�'.$option[1].' '.$option[2];
		$i=0;
		foreach ($option[3] as $l) {
			$line .= "\n";
			$line .= "\t".'['.$i.']'."\n";
			$line .= "\t\t".'file => '.$l['file']."\n";
			$line .= "\t\t".'ligne => '.$l['line']."\n";
			$line .= "\t\t".'fonction => '.$l['function'];
			$j=0;
			if (isset($l['args'])) {
				foreach ($l['args'] as $arg) {
					$line .= "\n";
					$line .= "\t\t\t".'['.$j.'] => '.$arg;
					$j++;

				}
			}
			$i++;
		}
		break;

		/* ----------- Gestion des membres ----------- */
		case 'login' :
		$line = $member. " se connecte";
		break;

		case 'login_ogs' :
		$line = $member." se connecte via OGS";
		break;

		case 'logout' :
		$line = $member." se d�connecte";
		break;

		case 'modify_account' :
		$line = $member." change son profil";
		break;

		case 'modify_account_admin' :
		$user_info = user_get($option);
		$line = "[admin] ".$member." change le profil de ".$user_info[0]['user_name'];
		break;

		case 'create_account' :
		$user_info = user_get($option);
		$line = "[admin] ".$member." cr�� le compte de ".$user_info[0]['user_name'];
		break;

		case 'regeneratepwd' :
		$user_info = user_get($option);
		$line = "[admin] ".$member." g�n�re un nouveau mot de passe pour ".$user_info[0]['user_name'];
		break;

		case 'delete_account' :
		$user_info = user_get($option);
		$line = "[admin] ".$member." supprime le compte de ".$user_info[0]['user_name'];
		break;

		case 'create_usergroup' :
		$line = "[admin] ".$member." cr�� le groupe ".$option;
		break;

		case 'modify_usergroup' :
		$usergroup_info = usergroup_get($option);
		$line = "[admin] ".$member." modifie les param�tres du groupe ".$usergroup_info["group_name"];
		break;

		case 'delete_usergroup' :
		$usergroup_info = usergroup_get($option);
		$line = "[admin] ".$member." supprime le groupe ".$usergroup_info["group_name"];
		break;

		case 'add_usergroup' :
		list($group_id, $user_id) = $option;
		$usergroup_info = usergroup_get($group_id);
		$user_info = user_get($user_id);
		$line = "[admin] ".$member." ajoute ".$user_info[0]["user_name"]." dans le groupe ".$usergroup_info["group_name"];;
		break;

		case 'del_usergroup' :
		list($group_id, $user_id) = $option;
		$usergroup_info = usergroup_get($group_id);
		$user_info = user_get($user_id);
		$line = "[admin] ".$member." supprime ".$user_info[0]["user_name"]." du groupe ".$usergroup_info["group_name"];;
		break;

		/* ----------- Classement ----------- */
		case 'load_rank' :
		list($support, $typerank, $typerank2, $timestamp, $countrank) = $option;
		switch ($support) {
			case "OGS": $support = "OGS";break;
			case "WEB": $support = "serveur web";break;
		}
		switch ($typerank) {
			case "general": $typerank = "g�n�ral";break;
			case "fleet": $typerank = "flotte";break;
			case "research": $typerank = "recherche";break;
		}
		switch($typerank2) {
			case "player": $typerank2 = "joueur";
			case "ally": $typerank2 = "alliance";
		}
		$date = strftime("%d %b %Y %Hh", $timestamp);
		$line = $member." envoie le classement ".$typerank." ".$typerank2." du ".$date." via ".$support." [".$countrank." lignes]";
		break;

		case 'get_rank' :
		list($typerank, $timestamp) = $option;
		$date = strftime("%d %b %Y %H:%M", $timestamp);
		switch ($typerank) {
			case "points": $typerank = "g�n�ral";break;
			case "flotte": $typerank = "flotte";break;
			case "research": $typerank = "recherche";break;
		}
		$line = $member." r�cup�re le classement ".$typerank." du ".$date;
		break;

		/* ----------------------------------------- */

		case 'check_var' :
		$line = $member." envoie des donn�es refus�es par le contr�leur : ".$option[0]." - ".$option[1];
		break;

		case 'debug' :
		$line = 'DEBUG : '.$option;
		break;
		case 'php_error' :
		$line = "[PHP-ERROR] ".$option[0]." - ".$option[1];
		if (isset($option[2])) $line .=" ; Fichier: ".$option[2];
		if (isset($option[3])) $line .=" ; Ligne: ".$option[3];

		break;

		default:
		$line = 'Erreur appel fichier log - '.$parameter.' - '.print_r($option);
		break;
	}
	
	$fichier = "log_".date("ymd").'.log';
	$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
	write_file(PATH_LOG_TODAY.$fichier, "a", $line);
}
/**
* Error handler PHP : log des erreurs PHP dans la journalisation d'OGSpy
* Optionnellement mise en place dans common.php , si $server_config["no_phperror"] n'est pas flagg� � 1
*/
function ogspy_error_handler($code, $message, $file, $line) {
	global $ogspy_phperror;
	$option=Array($code,$message,$file,$line);
	log_("php_error",Array($code,$message,$file,$line));
	global $user_data;
	if ($user_data["user_admin"]==1) {
		$line = "[PHP-ERROR] ".$option[0]." - ".$option[1];
		if (isset($option[2])) $line .=" ; Fichier: ".$option[2];
		if (isset($option[3])) $line .=" ; Ligne: ".$option[3];
	if ($option[0]!=8)	$ogspy_phperror[] = $line;
	}
}
