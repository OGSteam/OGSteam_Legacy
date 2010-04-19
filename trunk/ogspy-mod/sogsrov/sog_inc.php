<?php
/**
* sog_inc.php : Donn�es g�n�rales pour le module SOGSROV
* @author tsyr2ko <tsyr2ko-sogsrov@yahoo.fr>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version 0.4
* @package Sogsrov
*/

if (!defined('IN_SOGSROV')) die("Hacking attempt");

if (!isset($table_prefix)) require_once("./parameters/id.php");

/*
* D�finition du nom des tables
*/
define("TABLE_SOGSROV", $table_prefix . "sogsrov");
define("TABLE_SOGSROV_CONF", $table_prefix . "sogsrov_conf");

/**
* Tableau contenant les param�tres par d�faut
* @global array $config
*/
$config = array();

/**
* Fonction pour afficher le menu
* @param string $subaction Page du mod devant �tre affich�e
* @return string Renvoie une cha�ne contenant le menu
*/
function DisplayMenu() {
   global $lang, $pub_subaction;
   $admin = IsAdmin();
   $width = ($admin === true ? "25" : "33");
   
   $tab_subaction = Array(
      'main' => '- SOGSROV -',
      'options' => $lang['menu.options'],
      'admin' => $lang['menu.admin'],
      'credits' => $lang['menu.credits']
   );

   if (!isset($pub_subaction) || !array_key_exists($pub_subaction, $tab_subaction)) {
      $pub_subaction = "main";
   }
   
   $output = '<table width="100%">' . "\n";
   $output .= '<tr align="center">' . "\n";

   foreach ($tab_subaction as $key => $val) {
      if ($key == "admin" && !$admin) { continue; }
      if ($pub_subaction == $key) {
         $output .= '      <th width="' . $width . "%\">\n";
         $output .= '         <a>' . $val . "</a>\n";
         $output .= "      </th>\n";
      }
      else {
         $output .= '      <td class="c" width="' . $width . '%" onclick="';
         $output .= "window.location='index.php?action=sogsrov&subaction=" . $key . "';\">\n";
         $output .= '         <a style="cursor:pointer">';
         $output .= '<font color="lime">' . $val . "</font></a>\n";
         $output .= "      </td>\n";
      }
   }
   $output .= "   </tr>\n";
   $output .= "</table>";
   return ($output);
}

/**
* Scanne le dossier du mod � la recherche des fichiers de langue
* @return array Tableau des langues disponibles, ex : array('fr', 'en')
*/
function GetAvailableLanguage() {
   $availables_languages = array();
   $path = './mod/sogsrov/';
   
   if ($dir = opendir($path)) {
      while (($file = readdir($dir)) !== false) {
         if (!strncmp($file, "sog_lang_", 9) && is_file($path . $file)) {
            if (strlen($file) == 15) {
               $availables_languages[] = substr($file, 9, 2);
            }
         }
      }
      closedir($dir);
   }
   return ($availables_languages);
}

/**
* R�cup�ration de la configuration depuis la base de donn�es
*/
function GetConfig() {
   global $db, $user_data, $config;

   $user_id = intval($user_data["user_id"]);
   $request = 'SELECT `conf_name`, `conf_value` FROM `' . TABLE_SOGSROV_CONF;
   $request .= '` WHERE `user_id` = ' . $user_id;
   $result = $db->sql_query($request);

   if ($db->sql_numrows($result) > 0) {
      while (list($name, $value) = $db->sql_fetch_row($result)) {
         $config[$name] = stripslashes($value);
      }
   }
   
   $request = 'SELECT `config_name`, `config_value` FROM `' . TABLE_CONFIG;
   $request .= '` WHERE `config_name` like "sog_%"';
   $result = $db->sql_query($request);

   if ($db->sql_numrows($result) > 0) {
      while (list($name, $value) = $db->sql_fetch_row($result)) {
         if ($name == "sog_restrict_re")
            $config['sog_restrict_re'] = stripslashes($value);
         if ($name == "sog_users") {
            $tab_users = explode("<||>", stripslashes($value));
            foreach ($tab_users as $user) {
               $config['sog_users'][$user] = '1';
            }
         }
      }
   }
}

/**
* R�cup�re le dossier o� est install� le mod depuis la BDD
*/
function GetModDirectory() {
   global $db;
   
   $directory = "";
   
   $query = "SELECT `root` FROM `" . TABLE_MOD;
   $query .= "` WHERE `action`='sogsrov' AND `active`='1' LIMIT 1";
   $result = $db->sql_query($query);
   if ($db->sql_numrows($result) > 0) {
      list($directory) = $db->sql_fetch_row($result);
   }
   return $directory;
}

/**
* R�cup�re la version courante dans la table des modules
* @return string Version courante du module
*/
function GetVersion() {
   global $db;
   
   $query = "SELECT `version` FROM `" . TABLE_MOD;
   $query .= "` WHERE `action`= 'sogsrov' LIMIT 1";
   $result = $db->sql_query($query);
   list($version) = $db->sql_fetch_row($result);
   
   return ($version);
}

/**
* V�rification si le mod n'est pas d�sactiv�
* @return bool
*/
function IsActive() {
   global $db;
   
   $query = "SELECT `active` FROM `" . TABLE_MOD;
   $query .= "` WHERE `action`='sogsrov' AND `active`='1' LIMIT 1";
   if ($db->sql_numrows($db->sql_query($query))) return true;
   return false;
}

/**
* V�rification si l'utilisateur acc�dant au mod est un admin ou un coadmin
* @return bool
*/
function IsAdmin() {
   global $user_data;
   
   if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
      return true;
   }
   return false;
}

/**
* Fonction de s�curit� contre les injections SQL
* @param mixed $value Donn�e � prot�ger contre les injections SQL
* @return mixed Donn�e pr�te � �tre ins�rer en base de donn�es
*/
function SecurizeUserVar($value) {
   // Stripslashes
   if (get_magic_quotes_gpc()) $value = stripslashes($value);
   
   // Protection si ce n'est pas une valeur num�rique ou une cha�ne num�rique
   if (!is_numeric($value)) $value = "'" . mysql_real_escape_string($value) . "'";
   return ($value);
}


/**
* Insertion de la configuration par d�faut dans la base de donn�es
*/
function SetConfig() {
   global $db, $config;

   // langage par d�faut, mais param�trable
   $config['language'] = "fr";
   // "1" => menu � droite ; "0" => menu � gauche
   $config['menu_disp'] = '1';
   // couleur par d�faut pour les infos utiles
   $config['default_color'] = "orange";
   // couleur lorsque le seuil est d�pass�
   $config['critical_limit_color'] = "red";
   // couleur sp�ciale pour les lunes
   $config['moon_color'] = "green";
   // couleur pour la priorit� basse
   $config['low_priority_color'] = "green";
   // couleur pour la priorit� normale
   $config['normal_priority_color'] = "none";
   // couleur pour la priorit� haute
   $config['high_priority_color'] = "red";
   // nombre de rapports par page
   $config['reports_per_page'] = "20";
   // seuils avant de mettre en couleur critique
   $config['min_metal']     = "40000";
   $config['min_crystal']   = "30000";
   $config['min_deuterium'] = "20000";
   $config['min_energy']    =  "4000";
   $config['min_fleet']     =    "50";
   $config['min_defense']   =    "10";
   $config['min_buildings'] =    "15";
   $config['min_research']  =     "7";
   /* classement par d�faut des rapports d'espionnage
   ** 'm' pour m�tal,
   ** 'c' pour cristal',
   ** 'd' pour deut�rium,
   ** 't' pour total des ressources,
   ** 'p' pour position,
   ** 'y' pour priorit�
   */
   $config['order_by'] = "t";

   foreach ($config as $key => $value) {
      $query = "REPLACE INTO `" . TABLE_SOGSROV_CONF;
      $query .= "` (`conf_name`, `conf_value`) VALUES";
      $query .= " ('" . $key . "', '" . $value . "')";
      $db->sql_query($query);
   }
}

GetConfig();
if (!isset($config['menu_disp'])) SetConfig();

?>