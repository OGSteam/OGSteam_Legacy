<?php
/**
* sign_connexion.php Ouverture de la base de donn�es
* @package OGSign
* @author oXid_FoX
* @link http://www.ogsteam.fr
*/

// v�rification de s�curit�
if (!defined('OGSIGN')) die('Hacking attempt');

// variable de s�curit�
define('IN_SPYOGAME', true);
// identifiants
require_once('../../parameters/id.php');

// Connexion et s�lection de la base
$bdd = mysql_connect($db_host, $db_user, $db_password) or die('Impossible de se connecter');
mysql_select_db($db_database,$bdd) or die('Base inexistante.');

?>
