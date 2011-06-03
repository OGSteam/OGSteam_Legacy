<?php
/**
* update.php du mod News
* @package News
* @author ericalens
* @Update by Itori <itori@ogsteam.fr>
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}
$mod_folder = "news";
$mod_name = "news";
update_mod($mod_folder, $mod_name);

// function CreateTable(){
	// global $db;
	// global $table_prefix;
	
	
	// $query = "ALTER TABLE `".$table_prefix."news` ADD `idcat` int(11) NOT NULL";
	// $db->sql_query($query);
	
	// Suppresion de la table si elle existe
	// $query="DROP TABLE IF EXISTS `".$table_prefix."news_cat`;";
	// $db->sql_query($query);
	// Creation de la table proprement dites
	// $query="CREATE TABLE `".$table_prefix."news_cat` (
		  // `id` int(11) NOT NULL auto_increment,
		  // `categorie` varchar(250) NOT NULL,
		  // `souscat` varchar(250) NOT NULL,
		  // PRIMARY KEY  (`id`)
		// ) ENGINE=MyISAM;";
	// $db->sql_query($query);			
// }

// function addmod() {
	// global $db;
	// global $table_prefix;
	
	// $query = "SELECT `menu` FROM `".TABLE_MOD."` WHERE `title` not like 'Group.%'";
	// $db->sql_query($query);
	// while ($row=$db->sql_fetch_assoc($result)){
		// $query = "INSERT INTO `".$table_prefix."news_cat` (`categorie`, `souscat`) VALUES ('Tutoriels','".$row['menu']."')";
		// $db->sql_query($query);
	// }
	// $query = "INSERT INTO `".$table_prefix."news_cat` (`categorie`, `souscat`) VALUES ('Tutoriels', 'General')" ;
	// $db->sql_query($query);
// }

// function transfert(){
	// global $db;
	// global $table_prefix;
	
		//as très propre mais permet d'ajouter les news présentent dans le menu "Général"
		// $query = "SELECT `".$table_prefix."news_cat`.`id`, `souscat` FROM `".$table_prefix."news_cat` WHERE `souscat`='General'";
	// $result = $db->sql_query($query);
	// while ($row=$db->sql_fetch_assoc($result)){
		// $query = "INSERT INTO `".$table_prefix."news` (`news_time`, `title`, `body`, `idcat`) SELECT `news_time`, `title`, `body`, '".$row['id']."' FROM `".$table_prefix."news_aide` WHERE `mod`='General'";
		// $db->sql_query($query);
	// }
	
	// $query = "SELECT DISTINCT `".$table_prefix."news_cat`.`id`, `souscat`, `".TABLE_MOD."`.`title` FROM `".$table_prefix."news_cat`, `".TABLE_MOD."` WHERE `souscat`=`menu`";
	// $result = $db->sql_query($query);
	// while ($row=$db->sql_fetch_assoc($result)){
		// $query = "INSERT INTO `".$table_prefix."news` (`news_time`, `title`, `body`, `idcat`) SELECT `news_time`, `title`, `body`, '".$row['id']."' FROM `".$table_prefix."news_aide` WHERE `mod`='".addslashes(strtr($row["title"]," ", "_"))."'";
		// $db->sql_query($query);
	// }
		
	
// }

// function maj() {
	// global $db;
	// global $table_prefix;
// $query = "INSERT INTO `".$table_prefix."group` (`group_name`) VALUES ('News')";
// $db->sql_query($query);
// }
// function deltable() {
	// global $db;
	// global $table_prefix;
	// $query="DROP TABLE IF EXISTS `".$table_prefix."news_aide`;";
	// $db->sql_query($query);
// }



// function maj1() {
	// global $db;

// $query = "ALTER TABLE `".TABLE_GROUP."` ADD `news_post` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
// ADD `news_edit` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
// ADD `news_del` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
// ADD `news_admin` ENUM( '0', '1' ) NOT NULL DEFAULT '0'";
// $db->sql_query($query);

// }

// $query="SELECT `version` FROM `".TABLE_MOD."` WHERE `title`='News'";
// $result=$db-> sql_query($query);

// $result=$db-> sql_fetch_assoc($result);

// if ($result["version"]>"1.4c") {
	// maj1();
// }
// else
// {
	// Createtable();
	// addmod();
	// transfert();
	// deltable();
	// maj();
	// maj1();
// }
?>
