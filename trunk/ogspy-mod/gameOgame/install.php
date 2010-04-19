<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
//include('./parameters/id.php');
global $table_prefix;

$queries = array();

$queries[]  = 'INSERT INTO '.TABLE_MOD.' (title,menu,action,root,link,version,active) VALUES (\'gameOgame\',\'gameOgame\',\'gameOgame\',\'gameOgame\',\'index.php\',\'2.1b\',\'1\')';

//$queries[] = 'INSERT INTO '.TABLE_CONFIG.' (config_name,config_value) VALUES (\'gameOgame\',\'-1,1,3,4,10\')';

$queries[] = 'CREATE TABLE '.$table_prefix.'game (
  id INT(11) UNSIGNED NOT NULL auto_increment,
  sender INT(11) UNSIGNED NOT NULL DEFAULT \'0\',
  date INT(11) UNSIGNED NOT NULL DEFAULT \'0\',
  attaquant VARCHAR(255) NOT NULL DEFAULT \'0\',
  coord_att VARCHAR( 8 ) NOT NULL ,
  defenseur VARCHAR(255) NOT NULL DEFAULT \'0\',
  coord_def VARCHAR( 8 ) NOT NULL ,
  pertesA BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  pertesD BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  `%lune` mediumINT(2) UNSIGNED NOT NULL DEFAULT \'0\',
  lune TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\',
  pillageM BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  pillageC BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  pillageD BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  recyclageM BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  recyclageC BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  recycleM BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  recycleC BIGINT UNSIGNED NOT NULL DEFAULT \'0\',
  points BIGINT NOT NULL DEFAULT \'0\',
  rawdata text NOT NULL,
  PRIMARY KEY  (id),
  KEY sender (sender))';

$queries[] = 'CREATE TABLE '.$table_prefix.'game_users (
  id INT(11) UNSIGNED NOT NULL DEFAULT \'0\',
  admin TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\',
  user TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\',
  nb_rapport BIGINT NOT NULL COMMENT \'Nb de rapports supprimés\' DEFAULT \'0\',
  point BIGINT NOT NULL COMMENT \'points des rapports supprimés\' DEFAULT \'0\',
  PRIMARY KEY  (id))';
  
$queries[] = 'CREATE TABLE '.$table_prefix.'game_recyclage (
  id INT(11) UNSIGNED NOT NULL auto_increment,
  rc INT(11) UNSIGNED NOT NULL DEFAULT \'0\',
  recycleurs INT(11) UNSIGNED NOT NULL DEFAULT \'0\',
  capacite BIGINT(20) UNSIGNED NOT NULL DEFAULT \'0\',
  dispoM BIGINT(20) UNSIGNED NOT NULL DEFAULT \'0\',
  dispoC BIGINT(20) UNSIGNED NOT NULL DEFAULT \'0\',
  collecteM BIGINT(20) UNSIGNED NOT NULL DEFAULT \'0\',
  collecteC BIGINT(20) UNSIGNED NOT NULL DEFAULT \'0\',
  timestamp BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY rc_id (rc))';
  
    $config['pertes'] = -1;
    $config['degats'] = 1;
    $config['pillage'] = 3;
    $config['recycl'] = 4;
    $config['clune'] = 10;
    // Nouveaux paramètres
    $config['ligne'] = 20;
    $config['timer'] = time();
    $config['soft'] = 0;
    $config['autoS'] = "FALSE";
    $config['hard'] = 20;
    $config['autoH'] = "FALSE";
    $sqldata=serialize($config);
$queries[] = "INSERT INTO ".TABLE_MOD_CFG." VALUES ('gameOgame','config','".$sqldata."')";

foreach ($queries as $query) {
	$db->sql_query($query);
}
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
?>
