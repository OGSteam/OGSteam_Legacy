<?php
/***************************************************************************
*	filename	: admin_parameters.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 16/12/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}

$max_battlereport = $server_config['max_battlereport'];
$max_favorites = $server_config['max_favorites'];
$max_spyreport = $server_config['max_spyreport'];
$server_active = $server_config['server_active'] == 1 ? "checked" : "";
$session_time = $server_config['session_time'];
$max_keeplog = $server_config['max_keeplog'];
$default_skin = $server_config['default_skin'];
$debug_log = $server_config['debug_log'] == 1 ? "checked" : "";
$reason = $server_config['reason'];
$ally_protection = $server_config['ally_protection'];
$allied = $server_config['allied'];
$url_forum = $server_config['url_forum'];
$max_keeprank = $server_config['max_keeprank'];
$keeprank_criterion = $server_config['keeprank_criterion'];
$max_keepspyreport = $server_config['max_keepspyreport'];
$servername = $server_config['servername'];
$max_favorites_spy = $server_config['max_favorites_spy'];
$disable_ip_check = $server_config['disable_ip_check'] == 1 ? "checked" : "";

?>

<table width="100%">
<form method="POST" action="index.php">
<input type="hidden" name="action" value="set_serverconfig">
<input name="max_battlereport" type="hidden" size="5" value="10">
<tr>
	<td class="c" colspan="2">Options g�n�rales du serveur</td>
</tr>
<tr>
	<th width="60%">Nom du serveur</th>
	<th><input type="text" name="servername" size="60" value="<?php echo $servername;?>"></th>
</tr>
<tr>
	<th width="60%">Activer le serveur&nbsp;<?php echo help("admin_server_status");?></th>
	<th><input name="server_active" type="checkbox" value="1" <?php echo $server_active;?>></th>
</tr>
<tr>
	<th width="60%">Motif fermeture&nbsp;<?php echo help("admin_server_status_message");?></th>
	<th><input type="text" name="reason" size="60" value="<?php echo $reason;?>"></th>
</tr>
<tr>
	<td class="c" colspan="2">Options des membres</td>
</tr>
<tr>
	<th>Autoriser la d�sactivation du contr�le des adresses ip&nbsp;<?php echo help("admin_check_ip");?></th>
	<th><input name="disable_ip_check" type="checkbox" value="1" <?php echo $disable_ip_check;?>></th>
</tr>
<tr>
	<th>Skin par d�faut<br /><div class="z"><i>ex: http://80.237.203.201/download/use/epicblue/</i></div></th>
	<th><input name="default_skin" type="text" size="60" value="<?php echo $default_skin;?>"></th>
</tr>
<tr>
	<th>Nombre maximum de syst�mes favoris autoris� <a>[0-99]</a></th>
	<th><input name="max_favorites" type="text" size="5" maxlength="2" value="<?php echo $max_favorites;?>"></th>
</tr>
<tr>
	<th>Nombre maximum de rapports d'espionnage favoris autoris� <a>[0-99]</a></th>
	<th><input name="max_favorites_spy" type="text" size="5" maxlength="2" value="<?php echo $max_favorites_spy;?>"></th>
</tr>
<tr>
	<td class="c" colspan="2">Gestion des sessions</td>
</tr>
<tr>
	<th>Dur�e des sessions <a>[5-180 minutes]</a> <a>[0=dur�e ind�termin�e&nbsp;<?php echo help("admin_session_infini");?>]</a></th>
	<th><input name="session_time" type="text" size="5" maxlength="3" value="<?php echo $session_time;?>"></th>
</tr>
<tr>
	<td class="c" colspan="2">Protection alliance</td>
</tr>
<tr>
	<th width="60%">Liste des alliances � ne pas afficher<br /><div class="z"><i>S�parez les alliances avec des virgules</i></div></th>
	<th><input type="text" size="60" name="ally_protection" value="<?php echo $ally_protection;?>"></th>
</tr>
<tr>
	<th width="60%">Liste des alliances amies<br /><div class="z"><i>S�parez les alliances avec des virgules</i></div></th>
	<th><input type="text" size="60" name="allied" value="<?php echo $allied;?>"></th>
</tr>
<tr>
	<td class="c" colspan="2">Param�tres divers</td>
</tr>
<input type="hidden" size="60" name="url_forum" value="<?php echo $url_forum;?>">
<tr>
	<th>Journaliser les transactions et requ�tes SQL&nbsp;<?php echo help("admin_save_transaction");?><br /><div class="z"><i>Risque de d�gradation des performances du serveur</i></div></th>
	<th><input name="debug_log" type="checkbox" value="1" <?php echo $debug_log;?>></th>
</tr>
<tr>
	<td class="c" colspan="2">Maintenance</td>
</tr>
<tr>
	<th width="60%">Dur�e de conservation des classements <a>[1-50 jours ou nombre]</a></th>
	<th><input type="text" name="max_keeprank" maxlength="4" size="5" value="<?php echo $max_keeprank;?>">&nbsp;<select name="keeprank_criterion"><option value="quantity" <?php echo $keeprank_criterion == "quantity" ? "selected" : "";?>>Nombre</option><option value="day" <?php echo $keeprank_criterion == "day" ? "selected" : "";?>>Jours</option></th>
</tr>
<tr>
	<th width="60%">Nombre maximal de rapports d'espionnage par plan�te <a>[1-10]</a></th>
	<th><input type="text" name="max_spyreport" maxlength="4" size="5" value="<?php echo $max_spyreport;?>"></th>
</tr>
<tr>
	<th width="60%">Dur�e de conservation des rapports d'espionnage <a>[1-90 jours]</a></th>
	<th><input type="text" name="max_keepspyreport" maxlength="4" size="5" value="<?php echo $max_keepspyreport;?>"></th>
</tr>
<tr>
	<th width="60%">Dur�e de conservation des fichiers logs <a>[0-365 jours]</a></th>
	<th><input name="max_keeplog" type="text" size="5" maxlength="3" value="<?php echo $max_keeplog;?>"></th>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<th colspan="2"><input type="submit" value="Valider">&nbsp;<input type="reset" value="R�initialiser"></th>
</tr>
</form>
</table>
