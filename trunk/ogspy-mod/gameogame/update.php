<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
//include('./parameters/id.php');
global $table_prefix,$db,$server_config;

// on récupère le numéro de version
$result = $db->sql_query('SELECT `version` FROM `'.TABLE_MOD.'` WHERE `id` = \''.$pub_mod_id.'\' LIMIT 1',false);
$mod_version = $db->sql_fetch_row($result);
$mod_version = $mod_version[0];

// et selon la version, on MAJ
switch(true) {

case $mod_version < 2 :

	$queries = array();

	$queries[] = 'UPDATE '.TABLE_MOD.' SET version=\'2.0\' WHERE action=\'gameOgame\'';

	$queries[] = 'ALTER TABLE '.$table_prefix.'game_recyclage DROP sender';
	$queries[] = 'ALTER TABLE '.$table_prefix.'game ADD recycleM BIGINT UNSIGNED NOT NULL AFTER recyclageC, ADD recycleC BIGINT UNSIGNED NOT NULL AFTER recycleM';

	$queries[] = 'DROP VIEW IF EXISTS '.$table_prefix.'game_view';
	$queries[] = 'DROP VIEW IF EXISTS '.$table_prefix.'game_recyclage_view';

	foreach ($queries as $query) {
		$db->sql_query($query, false);
	}

	$coeff = explode(',',$server_config['gameOgame']);
	$config['pertes'] = $coeff[0];
	$config['degats'] = $coeff[1];
	$config['pillage'] = $coeff[2];
	$config['recycl'] = $coeff[3];
	$config['clune'] = $coeff[4];

	$sql = 'SELECT DISTINCT(id) AS rc FROM '.$table_prefix.'game';
	$result = $db->sql_query($sql);
	while ($val = $db->sql_fetch_assoc($result)) {
		$sql = 'SELECT IFNULL(sum(collecteM),0) as collecteM, IFNULL(sum(collecteC),0) as collecteC FROM '.$table_prefix.'game_recyclage WHERE rc='.$val['rc'];
		list($recycleM, $recycleC) = $db->sql_fetch_row($db->sql_query($sql));
		$sql = 'UPDATE '.$table_prefix.'game SET recycleM='.$recycleM.', recycleC='.$recycleC.' WHERE id='.$val['rc'];
		$db->sql_query($sql);
		$sql = 'UPDATE '.$table_prefix.'game SET points=pertesA/100000*'.$config['pertes'].'+pertesD/100000*'.$config['degats'].'+(pillageM+pillageC+pillageD)/100000*'.$config['pillage'].'+(recycleM+recycleC)/100000*'.$config['recycl'].'+lune*'.$config['clune'];
	}
	break;

case $mod_version === '2.0' :
	$db->sql_query('UPDATE '.TABLE_MOD.' SET version=\'2.0b\' WHERE action=\'gameOgame\'', false);
	break;
case $mod_version === '2.0b' :
	$db->sql_query('UPDATE '.TABLE_MOD.' SET version=\'2.0c\' WHERE action=\'gameOgame\'', false);
	break;
case $mod_version === '2.0c' :
    gog_xt2();
	$db->sql_query('UPDATE '.TABLE_MOD.' SET version=\'2.0d\' WHERE action=\'gameOgame\'', false);
	break;
case $mod_version === '2.0d' :
    gog_xt2();
    // Ajoute un champ pour les coordonnées de l'attaquant
    $query = "ALTER TABLE `".$table_prefix."game` ADD `coord_att` VARCHAR( 8 ) NOT NULL AFTER `attaquant`";
    $db->sql_query($query);
    // Ajoute un champ pour les coordonnées du défenseur
    $query = "ALTER TABLE `".$table_prefix."game` ADD `coord_def` VARCHAR( 8 ) NOT NULL AFTER `defenseur`";
    $db->sql_query($query);
    // Ajoute un champ pour le timestamp des rapports de recyclages
	$query = "ALTER TABLE `".$table_prefix."game_recyclage` ADD `timestamp` BIGINT UNSIGNED NOT NULL";
	$db->sql_query($query);
	
	// Transfert les paramètres dans la table mod_config
    $coeff = explode(',',$server_config['gameOgame']);
    $config['pertes'] = $coeff[0];
    $config['degats'] = $coeff[1];
    $config['pillage'] = $coeff[2];
    $config['recycl'] = $coeff[3];
    $config['clune'] = $coeff[4];
    // Nouveaux paramètres
    $config['ligne'] = 20;
    $config['timer'] = time();
    $config['soft'] = 0;
    $config['autoS'] = "FALSE";
    $config['hard'] = 20;
    $config['autoH'] = "FALSE";
    $sqldata=serialize($config);
    $query = "INSERT INTO ".TABLE_MOD_CFG." VALUES ('gameOgame','config','".$sqldata."')";
    $db->sql_query($query);
    // supprime les paramètres de la table config
    $query = "DELETE FROM `".TABLE_CONFIG."` WHERE `config_name`='gameOgame'";
    $db->sql_query($query);
    // Ajoute deux champs à la table ogspy_game_user pour compatbiliser les rapports supprimés
    $query="ALTER TABLE `".$table_prefix."game_users` ADD `nb_rapport` BIGINT NOT NULL COMMENT 'Nb de rapports supprimés',ADD `point` BIGINT NOT NULL COMMENT 'points des rapports supprimés'";
    $db->sql_query($query);
    // Change le n° de version
    $db->sql_query('UPDATE '.TABLE_MOD.' SET version=\'2.1\' WHERE action=\'gameOgame\'', false);
   
case $mod_version === '2.1' :
	//gog_xt2();
	$db->sql_query('UPDATE '.TABLE_MOD.' SET version=\'2.1a\' WHERE action=\'gameOgame\'', false);
	break;
    
case $mod_version === '2.1a' :
	//gog_xt2();
	$db->sql_query('UPDATE '.TABLE_MOD.' SET version=\'2.1b\' WHERE action=\'gameOgame\'', false);
	break;
    
}
function gog_xt2()
{
    global $table_prefix,$db;
	//On vérifie que la table xtense_callbacks existe (Xtense2)
    if( mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$table_prefix."xtense_callbacks"."'")))
    {
        // Si oui, on récupère le n° d'id du mod
        $query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='gameOgame' AND `active`='1' LIMIT 1";
        $result = $db->sql_query($query);
        $gog_id = $db->sql_fetch_row($result);
        $gog_id = $gog_id[0];
        // on fait du nettoyage au cas ou
        $query = "DELETE FROM `".$table_prefix."xtense_callbacks"."` WHERE `mod_id`=".$gog_id;
        $db->sql_query($query);
        // Insert les données pour récuperer les RC
        $query = "INSERT INTO ".$table_prefix."xtense_callbacks"." ( `mod_id` , `function` , `type` )
				VALUES ( '".$gog_id."', 'gog_rc', 'rc')";
        $db->sql_query($query);
        // Insert les données pour récuperer les RR
        $query = "INSERT INTO ".$table_prefix."xtense_callbacks"." ( `mod_id` , `function` , `type` )
				VALUES ( '".$gog_id."', 'gog_rr', 'rc_cdr')";
        $db->sql_query($query);
    }
}
?>