<?php
/**
 * update.php 

Script de mise à jour

 * @package QuiMSonde
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 1.5
 * dernière modification : 27.04.08
 * Largement inspiré du formidable mod QuiMObserve de Santory
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Include
include("qms_common.php");
include(FOLDER_INCLUDE."/qms_main.php");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

$mod_folder = "quimsonde";
$mod_name = "QuiMSonde";
update_mod($mod_folder, $mod_name);

// Quelle version met à jour ?
if (file_exists(FOLDER_QMS.'/version.txt')) {
	list($mod_name,$version) = file(FOLDER_QMS.'/version.txt'); 
	$mod_name = trim($mod_name);
	$version = trim($version);
}else
	die($lang['qms_version.txt_not_found']);

// Pour les accès SQL
global $db;

// Definition necessaire à la mise à jour
$col_distance = $col_userid = $idx_config_2 = $col_cible_name = $col_position_name = false;

// Est-ce que la colonne 'distance' existe ? (ajouté à la v1.0)
// Est-ce que la colonne 'cible_name' existe ? (ajouté à la v1.5)
// Est-ce que la colonne 'position_name' existe ? (ajouté à la v1.5)
$query = $db->sql_query('SHOW COLUMNS FROM '.TABLE_QMS);
while ($test = mysql_fetch_assoc($query)) {
	if ($test['Field'] == 'distance') $col_distance = true;
	if ($test['Field'] == 'cible_name') $col_cible_name = true;
	if ($test['Field'] == 'position_name') $col_position_name = true;
}

// Est-ce que la colonne 'user_id' existe ? (ajouté à la v1.0)
$query = $db->sql_query('SHOW COLUMNS FROM '.TABLE_QMS_config);
while ($test = mysql_fetch_assoc($query)) 
	if ($test['Field'] == 'user_id') $col_userid = true;

// Est-ce que l'index 'config_2' existe ? (ajouté à la v1.0)
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


// Effacement des fichiers innutile (ils ont été déplacé dans la v1.3)
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

// On s'assure que le champ 'valeur' a bien une limite à 255 caractères
$db->sql_query('ALTER TABLE `'.TABLE_QMS_config.'` CHANGE `valeur` `valeur` VARCHAR( 255 )');

// Génération des configuration par défault
$db->sql_query("TRUNCATE TABLE `".TABLE_QMS_config."`");
$insert_config = "INSERT INTO ".TABLE_QMS_config." ( `user_id`, `config`, `valeur`) VALUES ";
$db->sql_query($insert_config."( '0', 'lignes', '15' )");
$db->sql_query($insert_config."( '0', 'jours', '365' )");
$db->sql_query($insert_config."( '0', 'add_home', 'no' )");
$db->sql_query($insert_config."( '0', 'banniere', 'no' )");
$db->sql_query($insert_config."( '0', 'imgmenu', 'no' )");
$db->sql_query($insert_config."( '0', 'nbrapport', '2' )");
$db->sql_query($insert_config."( '0', 'periode', '20' )");
$db->sql_query($insert_config."( '0', 'time_end', '".($a=time())."' )");
$db->sql_query($insert_config."( '0', 'time_start', '".($a-3600*24*30)."' )");
$db->sql_query($insert_config."( '1', 'search', 
	'Recherche d\'Alliance<|>?action=ally&ally={alliance}&classement=pp&Rechercher<|>Alliance<|>0' )");
$db->sql_query($insert_config."( '2', 'search', 
	'Lite Seach (BBCode)<|>?action=litesearch&search={joueur}&target=player&galaxie=%&limit=0&mode=3&go=Rechercher<|>Joueur<|>0' )");
$db->sql_query($insert_config."( '3', 'search', 
	'Recherche+<|>?action=recherche_plus&ally_active=1&allys={alliance}&Chercher<|>Alliance<|>0' )");
$db->sql_query($insert_config."( '0', 'searchID', '1|2|3' )");


// Insertion de la liaison entre Xtense v2 et QuiMSonde


// On regarde si la table xtense_callbacks existe :
$query = 'show tables like "'.TABLE_XTENSE_CALLBACKS.'" ';
$result = $db->sql_query($query);
// On récupère le n° d'id du mod
$query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='QuiMSonde' AND `active`='1' LIMIT 1";
$result = $db->sql_query($query);
$mod_id = $db->sql_fetch_row($result);
$mod_id = $mod_id[0];

if($db->sql_numrows($result) != 0)
	{
		//Bonne nouvelle le mod xtense 2 est installé !
		//Maintenant on regarde si eXchange est dedans normalement il devrait pas mais on est jamais trop prudent...
		$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
		$result = $db->sql_query($query);
		$nresult = $db->sql_numrows($result);
		if($nresult == 0)
		{
			// Il est pas dedans alors on l'ajoute :
			$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES 
			('.$mod_id.', "qms_import_enemy_spy", "ennemy_spy", 1)';
			$db->sql_query($query);		
			echo("<script> alert('La compatibilité du mod Qui Me Sonde avec le mod Xtense2 est installée !') </script>");
		}
	}	
else
	{
	//On averti qu'Xtense 2 n'est pas installé :
	echo("<script> alert('Le mod Xtense 2 n\'est pas installé. \nLa compatibilité du mod Qui Me Sonde ne sera donc pas installée !\nPensez à installer Xtense 2 c'est pratique ;)') </script>");
	}	

?>