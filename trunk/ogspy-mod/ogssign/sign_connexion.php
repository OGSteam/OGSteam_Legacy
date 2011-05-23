<?php
/**
* sign_connexion.php Ouverture de la base de données
* @package OGSign
* @author oXid_FoX
* @link http://www.ogsteam.fr
*/

// vérification de sécurité
if (!defined('OGSIGN')) die('Hacking attempt');

// variable de sécurité
define('IN_SPYOGAME', true);
// identifiants
require_once('../../parameters/id.php');

// Connexion et sélection de la base
$bdd = mysql_connect($db_host, $db_user, $db_password) or die('Impossible de se connecter');
mysql_select_db($db_database,$bdd) or die('Base inexistante.');

?>
