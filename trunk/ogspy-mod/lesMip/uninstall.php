<?php
/**
* uninstall.php D�sinstalle le mod
* @package [MOD] Tout sur les MIP
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.4
* created	: 21/08/2006
* modified	: 07/02/2007
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

$query = "DELETE FROM ".TABLE_MOD." WHERE title='lesmip'";
$db->sql_query($query);

?>
<title>D�sinstallation</title>
<script>alert("Merci d\'avoir utilis� [MOD] Tout sur les mip.\nAu plaisir de vous rendre service Bartheleway\n")</script>