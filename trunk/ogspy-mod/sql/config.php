<?php
/**
* config.php panneau d'admin du mod
* @package modSQL
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created : 11/03/2007 22:31:33
*/

if (!defined('IN_SPYOGAME')) die('Hacking attempt');

// vérification des droits
if ($user_data['user_admin'] != 1)
	redirection('index.php?action=message&id_message=forbidden&info');

if (isset($pub_acces_coadmin)) {
	// on leur coupe l'accès
	if ($pub_acces_coadmin == 'interdire') $mod_coadmin = 0;
	// on les autorise
	if ($pub_acces_coadmin == 'autoriser') $mod_coadmin = 1;

	$db->sql_query('UPDATE '.TABLE_CONFIG.' SET `config_value` = \''.$mod_coadmin.'\' WHERE `config_name` = \'modSQL_coadmin\'');
}

// affichage plein écran
if (isset($pub_fullscreen_view)) {
	if (isset($pub_fullscreen))
		$mod_fullscreen = 1;
	else
		$mod_fullscreen = 0;

		$db->sql_query('UPDATE '.TABLE_CONFIG.' SET `config_value` = \''.$mod_fullscreen.'\' WHERE `config_name` = \'modSQL_fullscreen\'');
}

?>
<table width="100%" cellpadding="0" cellspacing="1">
<tr><td class="c" colspan="2">Autoriser les co-admins</td></tr>
<tr>
	<th>Lorsqu'activée, cette option permet d'autoriser les co-admins à accéder à ce mod. Si non, seul l'admin y a accès.</th>
	<th width="170"><form method="POST" action=""><input type="submit" name="acces_coadmin" value="<?php
if ($mod_coadmin)
	echo 'interdire';
else
	echo 'autoriser';
?>"></form></th>
</tr>
<tr><td class="c" colspan="2">Fullscreen</td></tr>
<tr>
	<th>Mode plein écran, sans le menu OGSpy à gauche.</th>
	<th width="170"><form method="POST" action=""><input type="checkbox" name="fullscreen"<?php if ($mod_fullscreen) echo ' checked="checked"'; ?>>
<input type="submit" name="fullscreen_view">
</form></th>
</tr>
</table>
