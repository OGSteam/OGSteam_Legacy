<?php
/***************************************************************************
*	filename	: serverdown.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 16/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$reason = $server_config["reason"];
require_once("views/page_header.php");
?>

<table width="500" align="center">
<tr>
	<td class="c"><?php echo $LANG["serverdown_serverclose"]; ?></td>
</tr>
<tr>
	<th><font color="red"><?php echo $reason;?></a></th>
</tr>
</table>

<?php
require_once("views/page_tail.php");
?>