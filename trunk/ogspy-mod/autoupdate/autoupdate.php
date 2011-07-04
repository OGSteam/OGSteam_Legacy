<?php
/** $Id$ **/
/**
* autoupdate.php Page maitresse du mod (fait les mises à jours des mods et affiche les pages demandées)
* @package [MOD] AutoUpdate
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 1.0
* created	: 27/10/2006
* modified	: 18/01/2007
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");
/**
*
*/
require_once("views/page_header.php");
if ( !function_exists('json_decode')) die("Autoupdate ne peut fonctionner correctement sans la librairie JSON, Merci de mettre à jour PHP(>= 5.2)");
require_once("mod/autoupdate/functions.php");


if (empty($pub_sub) OR $pub_sub == 'tableau' OR $pub_sub == 'maj' OR $pub_sub == 'down' OR $pub_sub == 'admin') {
	/**
	*Récupère les paramètres de configuration
	*/
	if (file_exists("mod/autoupdate/parameters.php")) {
		require_once("mod/autoupdate/parameters.php");
	} else {
		$result = generate_parameters(0, 1, 1, date("d"), date("H"), 0, 0, 1);
	}
}
/**
* Défini où se trouve le fichier qui contient les dernières versions des mods.
* Différent suivant si allow_url_fopen est activé ou non. S'il n'est pas activé, on va chercher le fichier en local après téléchargement.
*/
if(DOWNJSON == 0) {
	DEFINE("JSON_FILE","http://update.ogsteam.fr/update.json");
} else {
	DEFINE("JSON_FILE","parameters/modupdate.json");
}


/**
*Récupère le fichier de langue pour la langue approprié
*/
if (!empty($server_config['language'])) {
	if (is_dir("mod/autoupdate/".$server_config['language'])) {
		require_once("mod/autoupdate/".$server_config['language']."/lang_main.php");
	} else {
		require_once("mod/autoupdate/french/lang_main.php");
	}
} else {
	if (!is_dir("mod/autoupdate/french")) {
		echo "Retélécharger le mod via : <a href='http://ogsteam.fr/downloadmod.php?mod=autoupdate'>Zip link</a><br />\n";
		exit;
	} else {
		require_once("mod/autoupdate/french/lang_main.php");
	}
}

$d = "mod/autoupdate/";

if (!file_exists($d."admin.php") AND !file_exists($d."functions.php") AND !file_exists($d."ziplib") AND !is_dir($d."tmp")) {
	echo "Retélécharger le mod via : <a href='http://ogsteam.fr/downloadmod.php?mod=autoupdate'>Zip link</a><br />\n";
	exit;
}

if (!isset($pub_sub)) {
	$sub = "tableau";
	$pub_sub = "tableau";
} else $sub = $pub_sub;

if ($user_data["user_admin"] == 1 OR (COADMIN == 1 AND $user_data["user_coadmin"] == 1)) {
	if ($sub != "tableau") {
		$bouton1 = "\t\t"."<td class='c' align='center' width='150' style='cursor:pointer' onclick=\"window.location = 'index.php?action=autoupdate&sub=tableau';\">";

		$bouton1 .= "<font color='lime'>".$lang['autoupdate_autoupdate_table']."</font>";
		$bouton1 .= "</td>\n";
	} else {
		$bouton1 = "\t\t"."<th width='150'>";
		$bouton1 .= "<font color=\"#5CCCE8\">".$lang['autoupdate_autoupdate_table']."</font>";
		$bouton1 .= "</th>\n";
	}
	if ($sub != "down") {
		$bouton2 = "\t\t"."<td class='c' align='center' width='150' style='cursor:pointer' onclick=\"window.location = 'index.php?action=autoupdate&sub=down';\">";
		$bouton2 .= "<font color='lime'>".$lang['autoupdate_autoupdate_down']."</font>";
		$bouton2 .= "</td>\n";
	} else {
		$bouton2 = "\t\t"."<th width='150'>";
		$bouton2 .= "<font color=\"#5CCCE8\">".$lang['autoupdate_autoupdate_down']."</font>";
		$bouton2 .= "</th>\n";
	}
} else {
	$bouton1 = "";
	$bouton2 = "";
}
if ($user_data["user_admin"] == 1) {
	if ($sub != "admin") {
		$bouton3 = "\t\t"."<td class='c' align='center' width='150' style='cursor:pointer' onclick=\"window.location = 'index.php?action=autoupdate&sub=admin';\">";
		$bouton3 .= "<font color='lime'>".$lang['autoupdate_autoupdate_admin']."</font>";
		$bouton3 .= "</td>\n";
	} else {
		$bouton3 = "\t\t"."<th width='150'>";
		$bouton3 .= "<font color=\"#5CCCE8\">".$lang['autoupdate_autoupdate_admin']."</font>";
		$bouton3 .= "</th>\n";
	}
} else {
	$bouton3 = "";
}

/**
*Si le chargement de la page contient la variable GET['maj'] == yes on fait une MaJ du mod et on envoie le résultat
*/
if(!empty($pub_maj) AND $pub_maj == 'yes') {
	$request1 = "select id, title, root, link, version, active from ".TABLE_MOD." WHERE root='".$pub_modroot."' order by position, title";
	$result1 = $db->sql_query($request1);
 	list($pub_mod_id, $title, $root, $link, $version, $active) = $db->sql_fetch_row($result1);
	if (file_exists("mod/".$pub_modroot."/update.php")) {
		require_once("mod/".$pub_modroot."/update.php");
		
		$request = "SELECT title FROM ".TABLE_MOD." WHERE root = '".$pub_modroot."' LIMIT 1";
		$result = $db->sql_query($request);
		list($title) = $db->sql_fetch_row($result);
		log_("mod_update", $title);
		$maj = $lang['autoupdate_tableau_uptodateok']."<br />\n<br />\n";
	} else {
		$maj = $lang['autoupdate_tableau_uptodateoff']."<br />\n<br />\n";
	}
} else $maj = "";

/**
*Si le chargement de la page contient la variable GET['maj'] == all on fait une MaJ global des mods et on envoie le résultat
*/
if (!empty($pub_maj) AND $pub_maj == 'all') {
	$request1 = "select id, title, root, link, version, active from ".TABLE_MOD." order by position, title";
	$result1 = $db->sql_query($request1);
	while (list($pub_mod_id, $title, $root, $link, $version, $active) = $db->sql_fetch_row($result1)) {
		if (file_exists("mod/".$root."/version.txt")) {
			//Vérification disponibilité mise à jour de version
			$line = file("mod/".$root."/version.txt");
			$up_to_date = true;
			if (isset($line[1])) {
				if (file_exists("mod/".$root."/update.php")) {
					$up_to_date = (strcasecmp($version, trim($line[1])) >= 0) ? true : false;
				}
			}
			if (!$up_to_date) {
				if (require_once("mod/".$root."/update.php")) {
					log_("mod_update", $title);
					$maj = $lang['autoupdate_tableau_uptodateok']."<br />\n<br />\n";
				}
			}
		}
	}
} else $maj = "";

echo $maj;
echo "\n<table>\n";
echo "\t<tr>\n";
	echo $bouton1.$bouton2.$bouton3;
echo "\t</tr><br />\n";
echo "</table>\n<br />\n";

if (!isset($pub_sub)) $sub = 'tableau'; else $sub = htmlentities($pub_sub);
 switch($sub)
{
case 'tableau': include ('tableau.php');break;
case 'admin': include ('admin.php');break;
case 'maj': include ('MaJ.php');break;
case 'down': include ('down.php');break;
}
?>
