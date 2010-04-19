<?php
/***************************************************************************
*	filename	: login.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 15/11/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

require_once("views/page_header_2.php");
if (!isset($goto)) $goto = "";
?>

<form method='POST' action=''>
<input type='hidden' name='action' value='login_web'>
<input type='hidden' name='goto' value='<?php echo $goto;?>'>
<table align='center' cellpadding="0" cellspacing="1">
<tr>
	<td class="c" colspan="2">Paramètres de connexion</td>
</tr>
<tr>
	<th width="150">Login :</td>
	<th width="150"><input type='text' name='login'></th>
</tr>
<tr>
	<th>Mot de passe :</th>
	<th><input type='password' name='password'></th>
</tr>
<tr>
	<th colspan='2' align='right'><input type='submit' value='Connexion'></th>
</tr>
</table>
</form>
<?php
require_once("views/page_tail_2.php");
?>