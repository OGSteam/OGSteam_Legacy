<?php

define("IN_SPYOGAME", true);

require_once("../../parameters/id.php");
require_once("./sog_mysql.php");

define("COOKIE_NAME", "ogspy_id");
define("TABLE_SESSIONS", $table_prefix."sessions");
define("TABLE_CONFIG", $table_prefix."config");
define("TABLE_USER", $table_prefix."user");
define("TABLE_SPY", $table_prefix."spy");
define("TABLE_SOGSROV", $table_prefix . "sogsrov");
define("TABLE_SOGSROV_CONF", $table_prefix . "sogsrov_conf");

$db = new sql_db($db_host, $db_user, $db_password, $db_database);

if (!$db->db_connect_id) {
   die("Impossible de se connecter à la base de données");
}

$check = array();

$check['language'] = 'Char';
$check['reports_per_page'] = 'Num';
$check['menu_disp'] = 'Bool';
$check['default_color'] = 'Color';
$check['critical_limit_color'] = 'Color';
$check['moon_color'] = 'Color';
$check['low_priority_color'] = 'Color';
$check['normal_priority_color'] = 'Color';
$check['high_priority_color'] = 'Color';
$check['min_metal'] = 'Num';
$check['min_crystal'] = 'Num';
$check['min_deuterium'] = 'Num';
$check['min_energy'] = 'Num';
$check['min_fleet'] = 'Num';
$check['min_defense'] = 'Num';
$check['min_buildings'] = 'Num';
$check['min_research'] = 'Num';
$check['order_by'] = 'Char';

function sog_check_var($value, $type_check) {
   $colors = array("none", "orange", "green", "red");

   switch ($type_check) {
      //Booléen
      case "Bool" :
      if (!preg_match("#^[01]{1}$#", $value)) { return false; }
      break;
      
      //Caractères alphabétiques
      case "Char" :
      if (!preg_match("#^[a-zA-Z]+$#", $value)) { return false; }
      break;
      
      //Chiffres
      case "Num" :
      if (!preg_match("#^[[:digit:]]+$#", $value)) { return false; }
      break;
      
      //Couleurs
      case "Color" :
      foreach ($colors as $color) { if ($color == $value) return true; }
      return false;
      break;
      
      default:
      return false;
   }
   return true;
}

function save_admin($tab) {
   global $db, $user_id;

   foreach ($tab as $key => $value) {
      if ($key == "restrict_re") {
         $value = ($value == "0" ? "1" : "0");
      }
      $request = 'REPLACE INTO `' . TABLE_CONFIG . '` ';
      $request .= 'VALUES (';
      $request .= "'sog_" . $key . "', '" . $value . "')";
      $db->sql_query($request);
      echo $value;
   }
}

function save_options($tab) {
   global $db, $check, $user_id;
   
   foreach ($tab as $key => $value) {
      if (array_key_exists($key, $check) && isset($check[$key])) {
         if (sog_check_var($value, $check[$key])) {
            $request = 'REPLACE INTO `' . TABLE_SOGSROV_CONF . '` ';
            $request .= 'VALUES (';
            $request .= "'" . $user_id . "', '" . $key . "', '" . $value . "')";
            $db->sql_query($request);
            echo $value;
         }
         else {
            $request = 'SELECT `conf_value` FROM `' . TABLE_SOGSROV_CONF . '` ';
            $request .= 'WHERE `user_id` = ' . $user_id;
            $request .= " AND `conf_name` = '" . $key . "'";
            $result = $db->sql_query($request);
            list($val) = $db->sql_fetch_row($result);
            echo $val;
         }
      }
   }
}

function encode_ip($ip) {
   $ip_sep = explode('.', $ip);
   return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

$cookie_name = COOKIE_NAME;

if (isset($HTTP_COOKIE_VARS[$cookie_name])) {
   //Récupération et encodage de l'adresse ip
   $user_ip = $_SERVER['REMOTE_ADDR'];
   $user_ip = encode_ip($user_ip);
   
   $cookie_id = $HTTP_COOKIE_VARS[$cookie_name];
   
   //Vérification de la validité de le session
   $request = "select session_user_id from ".TABLE_SESSIONS.
   " where session_id = '".$cookie_id."'".
   " and session_ip = '".$user_ip."'";
   $result = $db->sql_query($request);
   if ($db->sql_numrows($result) != 1) {
      die ("Hacking attempt (erreur sur les sessions)");
   }
   else {
      list($user_id) = $db->sql_fetch_row($result);
   }
}

$method = "_" . $_SERVER['REQUEST_METHOD'];
$tab = array_change_key_case(${$method}, CASE_LOWER);

if (array_key_exists("page", $tab) && isset($tab['page'])) {
   $page = $tab['page'];
   unset($tab['page']);
}
else { die ("Hacking attempt ('page=' non présent)"); }

switch ($page) {
   case "options" :
   save_options($tab);
   break;
   
   case "admin" :
   if (isset($_SESSION['admin']) && $_SESSION['admin'] === 1) save_admin($tab);
   else die("var session non définie");
   break;
   
   case "main" :
   break;
   
   default:
   die ("Hacking attempt");
   break;
}

?>