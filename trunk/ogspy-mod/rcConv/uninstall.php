<?php
/**
* uninstall.php Supprime le mod d'OGSpy
* @package [MOD] RCConv
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.5
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

$query = "DELETE FROM ".TABLE_MOD." WHERE title='RCConv'";
$db->sql_query($query);

?>
<title>D�sinstallation</title>
<script>alert("Merci d\'avoir utilis� [MOD] RCConv.\nAu plaisir de vous rendre service Bartheleway\n")</script>