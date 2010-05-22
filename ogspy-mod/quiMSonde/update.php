<?php
/**
 * update.php 

Script de mise � jour

 * @package QuiMSonde
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 1.5
 * derni�re modification : 27.04.08
 * Largement inspir� du formidable mod QuiMObserve de Santory
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Include
include("qms_common.php");
include(FOLDER_INCLUDE."/qms_main.php");


// Quelle version met � jour ?
if (file_exists(FOLDER_QMS.'/version.txt')) {
	list($mod_name,$version) = file(FOLDER_QMS.'/version.txt'); 
	$mod_name = trim($mod_name);
	$version = trim($version);
}else
	die($lang['qms_version.txt_not_found']);

// Pour les acc�s SQL
global $db;

// Definition necessaire � la mise � jour
$col_distance = $col_userid = $idx_config_2 = $col_cible_name = $col_position_name = false;

// Est-ce que la colonne 'distance' existe ? (ajout� � la v1.0)
// Est-ce que la colonne 'cible_name' existe ? (ajout� � la v1.5)
// Est-ce que la colonne 'position_name' existe ? (ajout� � la v1.5)
$query = $db->sql_query('SHOW COLUMNS FROM '.TABLE_QMS);
while ($test = mysql_fetch_assoc($query)) {
	if ($test['Field'] == 'distance') $col_distance = true;
	if ($test['Field'] == 'cible_name') $col_cible_name = true;
	if ($test['Field'] == 'position_name') $col_position_name = true;
}

// Est-ce que la colonne 'user_id' existe ? (ajout� � la v1.0)
$query = $db->sql_query('SHOW COLUMNS FROM '.TABLE_QMS_config);
while ($test = mysql_fetch_assoc($query)) 
	if ($test['Field'] == 'user_id') $col_userid = true;

// Est-ce que l'index 'config_2' existe ? (ajout� � la v1.0)
$query = $db->sql_query('SHOW INDEX FROM '.TABLE_QMS_config);
while ($test = mysql_fetch_assoc($query)) 
	if ($test['Key_name'] == 'config_2') $idx_config_2 = true;

if (!$col_distance) {  
	// On ajoute la colonne distance
	$db->sql_query('ALTER TABLE `'.TABLE_QMS.'` ADD `distance` INT(11) NOT NULL AFTER `alliance`');

	// Remplissage de la colonne des distances :
	$table_spy = get_spies(0);
	$max_spy = count($table_spy['id']);
	for($i=0;$i<$max_spy;$i++)
		$db->sql_query("UPDATE `".TABLE_QMS."` SET `distance` = '".get_distance($table_spy['cible'][$i],$table_spy['position'][$i])."' WHERE `id` = '".$table_spy['id'][$i]."'");
}

if (!$col_position_name) // On ajoute la colonne position_name
	$db->sql_query('ALTER TABLE `'.TABLE_QMS.'` ADD `position_name` VARCHAR( 64 ) NULL AFTER `position`');
if (!$col_cible_name) // On ajoute la colonne cible_name
	$db->sql_query('ALTER TABLE `'.TABLE_QMS.'` ADD `cible_name` VARCHAR( 64 ) NULL AFTER `cible`');


// Effacement des fichiers innutile (ils ont �t� d�plac� dans la v1.3)
$file_to_delete = Array(
'accueil.php','admin.php','analyse.php','bilan.php','changelog.php','footer.php',
'graph.php','insertion.php','interpolation.php','popup.php','qms_functions.php',
'qms_functions_sql.php','qms_includes.php','spy_list.php','spy_list_public.php','tout_serveur.php');
foreach($file_to_delete as $file)
	if(file_exists(FOLDER_QMS."/".$file))
		unlink(FOLDER_QMS."/".$file);

// On ajoute la colonne user_id a la table de config
if (!$col_userid) $db->sql_query('ALTER TABLE `'.TABLE_QMS_config.'` ADD `user_id` INT(11) NOT NULL DEFAULT \'0\' FIRST');

// On supprime l'index "config_2", les config ne sont plus unique
if ($idx_config_2) $db->sql_query('ALTER TABLE `'.TABLE_QMS_config.'` DROP INDEX `config_2`');

// On s'assure que le champ 'valeur' a bien une limite � 255 caract�res
$db->sql_query('ALTER TABLE `'.TABLE_QMS_config.'` CHANGE `valeur` `valeur` VARCHAR( 255 )');

// G�n�ration des configuration par d�fault
$db->sql_query("TRUNCATE TABLE `".TABLE_QMS_config."`");
$insert_config = "INSERT INTO ".TABLE_QMS_config." ( `user_id`, `config`, `valeur`) VALUES ";
$db->sql_query($insert_config."( '0', 'lignes', '15' )");
$db->sql_query($insert_config."( '0', 'jours', '365' )");
$db->sql_query($insert_config."( '0', 'add_home', 'no' )");
$db->sql_query($insert_config."( '0', 'banniere', 'no' )");
$db->sql_query($insert_config."( '0', 'imgmenu', 'no' )");
$db->sql_query($insert_config."( '0', 'nbrapport', '2' )");
$db->sql_query($insert_config."( '0', 'periode', '20' )");
$db->sql_query($insert_config."( '0', 'time_start', '".($a-3600*24*30)."' )");
$db->sql_query($insert_config."( '0', 'time_end', '".($a=time())."' )");
$db->sql_query($insert_config."( '1', 'search', 
	'Recherche d\'Alliance<|>?action=ally&ally={alliance}&classement=pp&Rechercher<|>Alliance<|>0' )");
$db->sql_query($insert_config."( '2', 'search', 
	'Lite Seach (BBCode)<|>?action=litesearch&search={joueur}&target=player&galaxie=%&limit=0&mode=3&go=Rechercher<|>Joueur<|>0' )");
$db->sql_query($insert_config."( '3', 'search', 
	'Recherche+<|>?action=recherche_plus&ally_active=1&allys={alliance}&Chercher<|>Alliance<|>0' )");
$db->sql_query($insert_config."( '0', 'searchID', '1|2|3' )");

// mise � jour du num�ro de version
$db->sql_query("UPDATE `".TABLE_MOD."` SET `version` = '$version' WHERE `title` = '$mod_name'");


// Insertion de la liaison entre Xtense v2 et QuiMSonde (merci Paradoxx!)
define("INSTALL_MOD_NAME",$mod_name);
include("_xtense.php");

?>