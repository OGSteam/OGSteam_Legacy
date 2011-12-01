<?php

if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");
global $db, $table_prefix;
define("TABLE_PLAYER", $table_prefix . "bigb_player");
define("TABLE_ALLY", $table_prefix . "bigb_ally");
define("TABLE_STORY_PLAYER", $table_prefix . "bigb_story_player");
define("TABLE_STORY_ALLY", $table_prefix . "bigb_story_ally");
// Xtense
define("TABLE_XTENSE_CALLBACKS", $table_prefix . "xtense_callbacks");


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

    // ajout des id dans stat :
    //joueur
    $requests[] = "ALTER TABLE " . TABLE_RANK_PLAYER_POINTS .
        " ADD id_player INT(7) NOT NULL default '0'";
    $requests[] = "ALTER TABLE " . TABLE_RANK_PLAYER_FLEET .
        " ADD id_player INT(7) NOT NULL default '0'";
    $requests[] = "ALTER TABLE " . TABLE_RANK_PLAYER_RESEARCH .
        " ADD id_player INT(7) NOT NULL default '0'";
    //alliance
    $requests[] = "ALTER TABLE " . TABLE_RANK_ALLY_POINTS .
        " ADD id_ally INT(7) NOT NULL default '0'";
    $requests[] = "ALTER TABLE " . TABLE_RANK_ALLY_FLEET .
        " ADD id_ally INT(7) NOT NULL default '0'";
    $requests[] = "ALTER TABLE " . TABLE_RANK_ALLY_RESEARCH .
        " ADD id_ally INT(7) NOT NULL default '0'";

    //modif system solaire
    $requests[] = "ALTER TABLE " . TABLE_UNIVERSE . " ADD id_ally INT(7)"; // null => pas encore mis a jour 0 pas d alliance -1 alliance du detenteur de compte ogspy
    $requests[] = "ALTER TABLE " . TABLE_UNIVERSE .
        " ADD id_player INT(7) NOT NULL default '0'";

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
