<?
/**
 * mpc_includes.php 

Definitions

 * @package MP_Logger
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 0.1
 * dernière modification : 16.10.07
 * Module de capture des messages entre joueurs
 */
// L'appel direct est interdit
//if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$mod_name = "MP_Logger";
define("TABLE_MPC", "$table_prefix$mod_name");
define("FOLDER_MPC","mod/$mod_name");
define("TABLE_MPC_Config", "$table_prefix$mod_name_config");

// Definition du Menu
$i=-1;
$t_menu['fichier'][++$i] = 'msg_prives';	$t_menu['texte'][$i] = 'Messages';			$t_menu['admin'][$i] = 0;
$t_menu['fichier'][++$i] = 'msg_public';	$t_menu['texte'][$i] = 'Messages Public';	$t_menu['admin'][$i] = 0;
$t_menu['fichier'][++$i] = 'config';			$t_menu['texte'][$i] = 'Configuration';		$t_menu['admin'][$i] = 0;
$t_menu['fichier'][++$i] = 'admin';			$t_menu['texte'][$i] = 'Admin';				$t_menu['admin'][$i] = 1;



 ?>