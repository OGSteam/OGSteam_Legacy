<?php
/**
* Installation du module
* @package rechercheAlly
* @author Aeris
* @link http://www.ogsteam.fr
 */
 
define("IN_SPYOGAME", true);

if (file_exists('mod/rechercheAlly/version.txt')) {
 	    $file = file('mod/rechercheAlly/version.txt');

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','Recherche d\'alliance','Recherche<br>d\'alliance','ally','rechercheAlly','ally.php', '" . trim($file[1])  ."','1')";
$db->sql_query($query);

}
?>
