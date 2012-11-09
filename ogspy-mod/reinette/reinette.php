<?php
//var_dump($_SERVER);
define('IN_SPYOGAME', true);
define('IN_REINETTE', true);

date_default_timezone_set(date_default_timezone_get());

if (preg_match('#mod#', getcwd()))
    chdir('../../');
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__file__), 'index.php',
    preg_replace('#\/mod\/(.*)\/#', '/', $_SERVER['SCRIPT_FILENAME']));
include ("common.php");
list($root, $active) = $db->sql_fetch_row($db->sql_query("SELECT root, active FROM " .
    TABLE_MOD . " WHERE action = 'reinette'"));

require_once ("mod/{$root}/includes/db_xml.php");
require_once ("mod/{$root}/includes/functions.php");

// chaque appel se fera avec avec verification mdp et pseudo
if (!isset($pub_user)) {
    db_xml::generate_simple_xlm(array('ref' => 'Erreur 4', 'cause' =>
        'Pas de pseudo'), 'Erreur');
    die;
} // pas de pseudo
if (!isset($pub_password)) {
    db_xml::generate_simple_xlm(array('ref' => 'Erreur 5', 'cause' =>
        'Pas de mot de passe'), 'Erreur');
    die;
} // pas de passeword
if (!isset($pub_pays)) {
    db_xml::generate_simple_xlm(array('ref' => 'Erreur 20', 'cause' => 'Pas de pays'),
        'Erreur');
    die;
} // pas de pseudo
if (!isset($pub_uni)) {
    db_xml::generate_simple_xlm(array('ref' => 'Erreur 21', 'cause' => 'Pas d\'uni'),
        'Erreur');
    die;
} // pas de passeword

if (!isset($pub_version)) {
    db_xml::generate_simple_xlm(array('ref' => 'Erreur 31', 'cause' => 'Pas connaissance de la version du soft'),
        'Erreur');
    die;
} // pas de passeword

if (!isset($pub_soft)) {
    db_xml::generate_simple_xlm(array('ref' => 'Erreur 32', 'cause' => 'Application sans nom'),
        'Erreur');
    die;
} // pas de passeword

// on recherche les infos du compte joueur
$query = $db->sql_query('SELECT * FROM ' . TABLE_USER . ' WHERE user_name = "' .
    $db->sql_escape_string($pub_user) . '"');
if (!$db->sql_numrows($query)) {
    db_xml::generate_simple_xlm(array('ref' => 'Erreur 6', 'cause' => 'erreur d\'authentification'),
        'Erreur');
    die;
} else {
    $user_data = $db->sql_fetch_assoc($query); // recuperation des données

    if ($pub_password != $user_data['user_password']) {
        db_xml::generate_simple_xlm(array('ref' => 'Erreur 7', 'cause' => 'erreur d\'authentification'),
            'Erreur');
        die;
    }


    if ($user_data['user_active'] == 0) {
        db_xml::generate_simple_xlm(array('ref' => 'Erreur 8', 'cause' =>
            'Compte inactif'), 'Erreur');
        die;
    }

    if (valid_version(find_config("version_pommedapi"),$pub_version) == false){
         db_xml::generate_simple_xlm(array('ref' => 'Erreur 33', 'cause' =>
            'Probleme de version '.find_config("version_pommedapi").' !<= '.$pub_version), 'Erreur');
        die; 
        
        
    }
    // admin only
    if ($user_data['user_admin'] == 0 && $user_data['user_coadmin'] == 0) {
        db_xml::generate_simple_xlm(array('ref' => 'Erreur 22', 'cause' =>
            'Administrateur only'), 'Erreur');
        die;
    }

    // Verification des droits de l'user ( xtense spirit)
    $query = $db->sql_query("SELECT ogs_set_system as set_universe , ogs_set_ranking as set_rank  FROM " .
        TABLE_USER_GROUP . " u LEFT JOIN " . TABLE_GROUP .
        " g ON g.group_id = u.group_id  WHERE u.user_id = '" . $user_data['user_id'] .
        "'");
    $user_data['grant'] = $db->sql_fetch_assoc($query);
    //var_dump($user_data['grant']);
}


// table sur lesquel on peut travailler
$table_can_use = array( //  "ogspy_parsedspy" => TABLE_PARSEDSPY,
    "universe" => TABLE_UNIVERSE, 'rank_ally_points' => TABLE_RANK_ALLY_POINTS,
    'rank_player_points' => TABLE_RANK_PLAYER_POINTS, 'rank_player_eco' =>
    TABLE_RANK_PLAYER_ECO, 'rank_player_Research' => TABLE_RANK_PLAYER_TECHNOLOGY,
    'rank_player_Military' => TABLE_RANK_PLAYER_MILITARY,
    'rank_player_Military_Built' => TABLE_RANK_PLAYER_MILITARY_BUILT,
    'rank_player_Military_Lost' => TABLE_RANK_PLAYER_MILITARY_LOOSE,
    'rank_player_Military_Destroyed' => TABLE_RANK_PLAYER_MILITARY_DESTRUCT,
    'rank_player_honnor' => TABLE_RANK_PLAYER_HONOR, 'rank_ally_economique' =>
    TABLE_RANK_ALLY_ECO, 'rank_ally_technology' => TABLE_RANK_ALLY_TECHNOLOGY,
    'rank_ally_military' => TABLE_RANK_ALLY_MILITARY, 'rank_ally_military_built' =>
    TABLE_RANK_ALLY_MILITARY_BUILT, 'rank_ally_military_loose' =>
    TABLE_RANK_ALLY_MILITARY_LOOSE, 'rank_ally_military_destruct' =>
    TABLE_RANK_ALLY_MILITARY_DESTRUCT, 'rank_ally_honor' => TABLE_RANK_ALLY_HONOR);

if (!array_key_exists(($pub_table), $table_can_use)) {
    db_xml::generate_simple_xlm(array('ref' => 'Erreur 14', 'cause' =>
        'utilisation interdite de la table ' . $pub_table), 'Erreur');
    die;
}

if ($user_data['grant']["set_rank"] == 0 || $user_data['grant']["set_universe"] ==
    0) {
    db_xml::generate_simple_xlm(array('ref' => 'Erreur 10', 'cause' => 'Erreur ' . $ogs_prefix .
        $pub_table_temp . ' '), 'Erreur');
    die;
}

if (function_exists($pub_table)) {
    $func = $pub_table;
    $func($pub_data, $table_can_use[$pub_table]); // Appel foo()
} else {
    db_xml::generate_simple_xlm(array('ref' => 'Erreur 25', 'cause' =>
        'fonction n existant pas' . $pub_table), 'Erreur');
    die;
}
