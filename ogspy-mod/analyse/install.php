<?php
/**
 *	install..php Page d'accès au module analyseI
 *	@package	analyseI
 *	@author	benneb 
 *	created	: 10/02/2010   
 *	modified	: 10/02/2010  
 */
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}
global $db,$table_prefix;

if (file_exists('mod/analyseI/version.txt')) { 
	$file = file('mod/analyseI/version.txt'); 
}
$query = "CREATE TABLE IF NOT EXISTS `".$table_prefix.'inactivite'."` ("
	. " inactivite_id INT NOT NULL AUTO_INCREMENT, "
	. " inactivite_nom VARCHAR(50) NOT NULL, "
	. " inactivite_date INT NOT NULL, "
	. " primary key ( inactivite_id )"
	. " )";
	
$db->sql_query($query);

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('', 'analyseI', 'analyseI', 'analyseI', 'analyseI', 'index.php', '".trim($file[1])."', '1')";

$db->sql_query($query);

?>