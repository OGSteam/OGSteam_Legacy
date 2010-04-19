<?php
/** $Id$ **/
/**
* Ce mod permet de suivre l'évolution du classement des membres d'une alliance
* @package varAlly
* @author Aeris
* @link http://ogsteam.fr
* @version 2.1a
 */
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

require_once('./views/page_header.php');
require_once('./mod/varAlly/include.php');

$query = 'SELECT `active` FROM `'.TABLE_MOD.'` WHERE `action`=\'varAlly\' AND `active`=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

if (!isset($pub_subaction)) $pub_subaction='ally';
?>
<table width="100%">
	<tr>
		<td>
<?php
button_bar();
?>
		</td>
	</tr>
	<tr>
		<td>
<?php
switch ($pub_subaction)
{
	case 'admin': require_once('./mod/varAlly/admin.php'); break;
	case 'ally': require_once('./mod/varAlly/ally.php'); break;
	case 'report': require_once('./mod/varAlly/addReport.php'); break;
	case 'display': require_once('./mod/varAlly/display.php'); break;
	default: require_once('./mod/varAlly/ally.php'); break;
}
?>
		</td>
	</tr>
</table>
<?php
page_footer();
require_once('./views/page_tail.php');
?>
