<?php
/**
* uninstall.php : Desinstallation du Module News
* @author ericalens <ericalens@ogsteam.fr> http://www.ogsteam.fr
* @Update by Itori <itori@ogsteam.fr>
* @copyright OGSteam 2006 
* @version 1.0
* @package News
*/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
	}

// La suppression du mod dans la table de mod est faites par OGSpy
// (Donc pas besoin de la faire dans le fichier uninstall.php)

// Suppression des tables spécifiques au module
global $db, $table_prefix;
$mod_uninstall_name = "news";
$mod_uninstall_table = $table_prefix."news".','.$table_prefix."news_aide".','.$table_prefix."news_cat";
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);

$query="ALTER TABLE `".TABLE_GROUP."`
  DROP `news_post`,
  DROP `news_edit`,
  DROP `news_del`,
  DROP `news_admin`";
$db->sql_query($query);

?>
