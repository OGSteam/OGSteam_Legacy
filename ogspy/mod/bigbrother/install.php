<?php

if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");
global $db, $table_prefix;

// fichier commun
require_once ("mod/bigbrother/common.php");


$security = false;
$mod_folder = "bigbrother";
$security = install_mod($mod_folder);
if ($security == true) {
    // Creation table player
    $requests[] = "CREATE TABLE IF NOT EXISTS " . TABLE_PLAYER . " (" .
        " id INT(7) NOT NULL ," . " name_player varchar(30) NOT NULL ," .
        " id_ally INT(7)," . " status varchar(6), " . "UNIQUE (`id`)" . ")";

    // Creation table alliance
    $requests[] = "CREATE TABLE IF NOT EXISTS " . TABLE_ALLY . " (" .
        " id INT(7) NOT NULL ," . " name varchar(30) NOT NULL ," . " tag varchar(30)," .
        " url varchar(50)," . "UNIQUE (`id`)" . ")";

    // Creation table player story
    $requests[] = "CREATE TABLE IF NOT EXISTS " . TABLE_STORY_PLAYER . " (" .
        " id_player INT(7) NOT NULL ," . " name_player varchar(30) NOT NULL ," .
        " id_ally INT(7)," . " status varchar(6), " .
        " datadate int(11) NOT NULL default '0'," . " KEY (`id_player`)" . ")";

    // Creation table alliance story
    $requests[] = "CREATE TABLE IF NOT EXISTS " . TABLE_STORY_ALLY . " (" .
        " id_ally INT(7) NOT NULL ," . " name varchar(30) NOT NULL ," .
        " tag varchar(30) NOT NULL ," . " url varchar(50) NOT NULL ," .
        " datadate int(11) NOT NULL default '0'," . " KEY (`id_ally`)" . ")";


    // creation de la table uni
    $requests[] = "CREATE TABLE IF NOT EXISTS " . TABLE_UNI . " (" .
        " galaxy enum('1','2','3','4','5','6','7','8','9') NOT NULL ," .
        " system smallint(3) NOT NULL ," .
        " `row` enum('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') NOT NULL ," .
        " id_player INT(7) NOT NULL ," . " id_ally INT(7) NOT NULL ," .
        " datadate int(11) NOT NULL default '0'," .
        " UNIQUE KEY univers (galaxy,system,`row`)" . ")";


    // creation de la table rpp
    $requests[] = "CREATE TABLE IF NOT EXISTS " . TABLE_RPP . " (" .
        " datadate int(11) NOT NULL default '0'," . " rank INT(6) NOT NULL ," .
        " `player_id` INT(7) NOT NULL , " . " KEY (`player_id` )" . ")";


    // creation de la table rpf
    $requests[] = "CREATE TABLE IF NOT EXISTS " . TABLE_RPF . " (" .
        " datadate int(11) NOT NULL default '0'," . " rank INT(6) NOT NULL ," .
        " `player_id` INT(7) NOT NULL , " . " KEY (`player_id` )" . ")";


    // creation de la table rps
    $requests[] = "CREATE TABLE IF NOT EXISTS " . TABLE_RPR . " (" .
        " datadate int(11) NOT NULL default '0'," . " rank INT(6) NOT NULL ," .
        " `player_id` INT(7) NOT NULL , " . " KEY (`player_id` )" . ")";


    // date d installation ( debut d historisation)
    $requests[] = "INSERT IGNORE INTO " . TABLE_CONFIG .
        " (config_name, config_value) VALUES ('bigbrother','" . time() . "')";


    // on injecte toutes les requetes
    foreach ($requests as $request) {
        $db->sql_query($request);
    }


    // le cache :
    generate_config_cache();


}
?>
