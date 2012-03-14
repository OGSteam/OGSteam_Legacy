<?php
/**
* index.php Fichier principal
* @package hostiles
* @author Jedinight
* @link http://www.ogsteam.fr
* created : 23/02/2012
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");
echo "<table width='100%'>";

//version
$result = $db->sql_query('SELECT `version` FROM `'.TABLE_MOD.'` WHERE `action`=\''.$pub_action.'\' AND `active`=\'1\' LIMIT 1');
if (!$db->sql_numrows($result)) die('Mod désactivé !');
$version = $db->sql_fetch_row($result);
$version = $version[0];

echo "\t\t\t"."<th width='150'>";
echo "<a>Flottes Hostiles</a>";
echo "</th>\n</table>";

?>
