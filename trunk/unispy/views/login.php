<?php
/***************************************************************************
*	filename	: login.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 15/11/2005
*	modified	: 22/06/2006 00:13:20
*	modified	: 30/07/2006 00:00:00
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
<div align="center">
<table align='center' cellpadding="0" cellspacing="1">
<tr>
	<td class="c" colspan="2"><?php echo $LANG['Connection_parameters'];?></td>
</tr>
<tr>
	<th width="150"><?php echo $LANG['Username'];?></td>
	<th width="150"><input type='text' name='login'></th>
</tr>
<tr>
	<th><?php echo $LANG['Password'];?></th>
	<th><input type='password' name='password'></th>
</tr>
<tr>
	<th colspan='2' align='right'><input type='submit' value='<?php echo $LANG['Log_in'];?>'></th>
</tr>
</table>
</div>
</form>
<?php
require_once("views/page_tail_2.php");
?>