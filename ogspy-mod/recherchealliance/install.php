<?php
/**
* @Page principale du module
* @package rechercheAlly
* @Créateur du script Aeris
* @link http://www.ogsteam.fr
*
* @Modifier par Kazylax
* @Site internet www.kazylax.net
* @Contact kazylax-fr@hotmail.fr
*
 */
 
define("IN_SPYOGAME", true);

if (file_exists('mod/recherche_alliance/version.txt')) {
 	    $file = file('mod/recherche_alliance/version.txt');

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','recherche_alliance','Recherche Ally','alliance','recherche_alliance','index.php', '" . trim($file[1])  ."','1')";
$db->sql_query($query);

}
?>
