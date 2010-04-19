<?php
/***************************************************************************
*	filename	: options.php
*	desc.		:
*	Author		: ericalens - http://ogs.servebbs.net/
*	created		: jeudi 8 juin 2006, 03:54:36 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
?>

<table width="100%">
<tr>
	<td align='center'>
		<table width="100%">
		<tr align="center">
			<td align="center"><a href='http://ogs.servebbs.net'>OGSMarket</a>: Le commerce Ogamien par l'<b>OGSTeam</b></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		<table align="center" width="90%">
		<tr>
			<td align="center" colspan=2>Les options sont sous forme de cookies dans votre explorateur, il est donc neccessaire de les autoriser si vous voulez les modifier , et conservez leur changement</td>
		</tr>
		<tr>
		<td>
		<table align="center">
			<tr>
		  		<th width="150">Option</th><th width='200'>Valeur</th>
			</tr>
			<form action="index.php" method="post">
			<input type='hidden' name='action' value='setoption'>
			<tr>
				<th>Skin</th><td ><input type='text' size='40' name='skin' value='<?php echo $link_css;?>'/></td>
			</tr>
			<tr>
			<td colspan='2' align="center"><input type='submit'></td>
			</tr>
			</form>
		</table>
		</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<?php
require_once("views/page_tail.php");
?>
