<?php
/**
* install.php 
 * @package Attaques - UniSpy
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version : 0.8e
 */

//L'appel direct est BIGINTerdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Définitions
global $db;
global $table_prefix;
define("TABLE_ATTAQUES_ATTAQUES", $table_prefix."attaques_attaques");
define("TABLE_ATTAQUES_RECYCLAGES", $table_prefix."attaques_recyclages");
define("TABLE_ATTAQUES_ARCHIVES", $table_prefix."attaques_archives");

//Si la table attaques_attaques existe, on la supprime
$query="DROP TABLE IF EXISTS ".TABLE_ATTAQUES_ATTAQUES."";
$db->sql_query($query);

//Si la table attaques_recyclage existe, on la supprime
$query="DROP TABLE IF EXISTS ".TABLE_ATTAQUES_RECYCLAGES."";
$db->sql_query($query);

//Si la table gains_save existe, on la supprime
$query="DROP TABLE IF EXISTS ".TABLE_ATTAQUES_ARCHIVES."";
$db->sql_query($query);

//Ensuite, on crée la table attaques_attaques
$query = "CREATE TABLE ".TABLE_ATTAQUES_ATTAQUES." ("
  . " attack_id INT NOT NULL AUTO_INCREMENT, "
  . " attack_user_id INT NOT NULL, "
  . " attack_coord VARCHAR(9) NOT NULL, "
  . " attack_date INT NOT NULL, "
  . " attack_titane BIGINT NOT NULL, "
  . " attack_carbone BIGINT NOT NULL, "
  . " attack_tritium BIGINT NOT NULL, "
  . " attack_pertes BIGINT NOT NULL, "
  . " primary key ( attack_id )"
  . " )";
$db->sql_query($query);

//Puis la table attaques_recyclages
$query = "CREATE TABLE ".TABLE_ATTAQUES_RECYCLAGES." ("
  . " recy_id INT NOT NULL AUTO_INCREMENT, "
  . " recy_user_id INT NOT NULL, "
  . " recy_coord VARCHAR(9) NOT NULL, "
  . " recy_date INT NOT NULL, "
  . " recy_titane BIGINT NOT NULL, "
  . " recy_carbone BIGINT NOT NULL, "
  . " primary key ( recy_id )"
  . " )";
$db->sql_query($query);

//Enfin la table attaques_archives
$query = "CREATE TABLE ".TABLE_ATTAQUES_ARCHIVES." ("
	. " archives_id INT NOT NULL AUTO_INCREMENT, "
	. " archives_user_id INT NOT NULL, "
	. " archives_nb_attaques INT NOT NULL, "
	. " archives_date INT NOT NULL, "
	. " archives_titane BIGINT NOT NULL, "
	. " archives_carbone BIGINT NOT NULL, "
	. " archives_tritium BIGINT NOT NULL, "
	. " archives_pertes BIGINT NOT NULL, "
	. " archives_recy_titane BIGINT NOT NULL, "
	. " archives_recy_carbone BIGINT NOT NULL, "
	. " primary key ( archives_id )"
	. " )";
$db->sql_query($query);

//Enfin on insère les données du mod, dans la table mod.
$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('', 'Gestion des attaques', 'Gestion des<br>attaques', 'attaques', 'Attaques', 'index.php', '0.8e', '1')";
$db->sql_query($query);

?>
