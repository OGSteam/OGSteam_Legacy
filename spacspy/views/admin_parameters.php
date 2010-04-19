<?php
/** $Id$ **/
/**
* Panneau d'Administration : paramètres et options du serveur 
* @package SpacSpy
* @version 0.1b ($Rev$)
* @subpackage views
* @author Kyser
* @created 15/12/2005
* @copyright Copyright &copy; 2007, http://spacsteam.fr/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPACSPY')) {
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
$log_phperror = $server_config['log_phperror'] == 1 ? "checked" : "";
$reason = $server_config['reason'];
$ally_protection = $server_config['ally_protection'];
$allied = $server_config['allied'];
$url_forum = $server_config['url_forum'];
$max_keeprank = $server_config['max_keeprank'];
$keeprank_criterion = $server_config['keeprank_criterion'];
$max_keepspyreport = $server_config['max_keepspyreport'];
$servername = $server_config['servername'];
$servername = $server_config['servername'];
$max_favorites_spy = $server_config['max_favorites_spy'];
$disable_ip_check = $server_config['disable_ip_check'] == 1 ? "checked" : "";
$num_of_galaxies = ( isset ( $pub_num_of_galaxies ) ) ? $pub_num_of_galaxies:$server_config['num_of_galaxies'];
$num_of_systems = ( isset ( $pub_num_of_systems ) ) ? $pub_num_of_systems:$server_config['num_of_systems'];
?>

<table width="100%">
<form method="POST" action="index.php">
<input type="hidden" name="action" value="set_serverconfig">
<input name="max_battlereport" type="hidden" size="5" value="10">
<tr>
	<td class="c" colspan="2">Options générales du serveur</td>
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
	<th>Autoriser la désactivation du contrôle des adresses ip&nbsp;<?php echo help("admin_check_ip");?></th>
	<th><input name="disable_ip_check" type="checkbox" value="1" <?php echo $disable_ip_check;?>></th>
</tr>
<tr>
	<th>Skin par défaut<br /><div class="z"><i>ex: http://80.237.203.201/download/use/epicblue/</i></div></th>
	<th><input name="default_skin" type="text" size="60" value="<?php echo $default_skin;?>"></th>
</tr>
<tr>
	<th>Nombre maximum de systèmes favoris autorisé <a>[0-99]</a></th>
	<th><input name="max_favorites" type="text" size="5" maxlength="2" value="<?php echo $max_favorites;?>"></th>
</tr>
<tr>
	<th>Nombre maximum de rapports d'espionnage favoris autorisé <a>[0-99]</a></th>
	<th><input name="max_favorites_spy" type="text" size="5" maxlength="2" value="<?php echo $max_favorites_spy;?>"></th>
</tr>
<tr>
	<td class="c" colspan="2">Gestion des sessions</td>
</tr>
<tr>
	<th>Durée des sessions <a>[5-180 minutes]</a> <a>[0=durée indéterminée&nbsp;<?php echo help("admin_session_infini");?>]</a></th>
	<th><input name="session_time" type="text" size="5" maxlength="3" value="<?php echo $session_time;?>"></th>
</tr>
<tr>
	<td class="c" colspan="2">Blindage alliance</td>
</tr>
<tr>
	<th width="60%">Liste des alliances à ne pas afficher<br /><div class="z"><i>Séparez les alliances avec des virgules</i></div></th>
	<th><input type="text" size="60" name="ally_protection" value="<?php echo $ally_protection;?>"></th>
</tr>
<tr>
	<th width="60%">Liste des alliances amies<br /><div class="z"><i>Séparez les alliances avec des virgules</i></div></th>
	<th><input type="text" size="60" name="allied" value="<?php echo $allied;?>"></th>
</tr>
<tr>
	<td class="c" colspan="2">Paramètres divers</td>
</tr>
<tr>
	<th width="60%">Lien du forum de l'alliance</th>
	<th><input type="text" size="60" name="url_forum" value="<?php echo $url_forum;?>"></th>
</tr>
<tr>
	<th>Journaliser les transactions et requêtes SQL&nbsp;<?php echo help("admin_save_transaction");?><br /><div class="z"><i>Risque de dégradation des performances du serveur</i></div></th>
	<th><input name="debug_log" type="checkbox" value="1" <?php echo $debug_log;?>></th>
</tr>
<tr>
	<td class="c" colspan="2">Maintenance</td>
</tr>
<tr>
	<th width="60%">Durée de conservation des classements <a>[1-50 jours ou nombre]</a></th>
	<th><input type="text" name="max_keeprank" maxlength="4" size="5" value="<?php echo $max_keeprank;?>">&nbsp;<select name="keeprank_criterion"><option value="quantity" <?php echo $keeprank_criterion == "quantity" ? "selected" : "";?>>Nombre</option><option value="day" <?php echo $keeprank_criterion == "day" ? "selected" : "";?>>Jours</option></th>
</tr>
<tr>
	<th width="60%">Nombre maximal de rapports d'espionnage par planète <a>[1-10]</a></th>
	<th><input type="text" name="max_spyreport" maxlength="4" size="5" value="<?php echo $max_spyreport;?>"></th>
</tr>
<tr>
	<th width="60%">Durée de conservation des rapports d'espionnage <a>[1-90 jours]</a></th>
	<th><input type="text" name="max_keepspyreport" maxlength="4" size="5" value="<?php echo $max_keepspyreport;?>"></th>
</tr>
<tr>
	<th width="60%">Durée de conservation des fichiers lspacs <a>[0-365 jours]</a></th>
	<th><input name="max_keeplog" type="text" size="5" maxlength="3" value="<?php echo $max_keeplog;?>"></th>
</tr>
<?php
	if ($user_data["user_admin"] == 1) {
?>
<tr>
	<td class="c" colspan="2">Taille de l'univers</td>
</tr>
<tr>
	<th width="60%">Nombre de galaxies&nbsp;<?php echo help("profile_galaxy");?></th>
	<th><input name="num_of_galaxies" id="galaxies" type="text" size="5" maxlength="3" value="<?php echo $num_of_galaxies;?>" onchange="if (!confirm('Etes vous sur de vouloir modifier le nombre de galaxies?\nsi vous réduisez ce nombre\nLes membres qui sont définit comme étant dans l\'une des galaxies supprimé ce verront mis dans la galaxie 1, système 1\n et leur favoris supprimé')){document.getElementById('galaxies').value='<?php echo $num_of_galaxies;?>';}" readonly="readonly"> &nbsp; &nbsp; active le champs(<input name="enable_input_num_galaxies" type="checkbox" onclick="(this.checked)? document.getElementById('galaxies').readOnly=false : document.getElementById('galaxies').readOnly=true;">)</th>
</tr>
<tr>
	<th width="60%">Nombre de systèmes par galaxies&nbsp;<?php echo help("profile_galaxy");?></th>
	<th><input name="num_of_systems" id="systems" type="text" size="5" maxlength="3" value="<?php echo $num_of_systems;?>" onchange="if (!confirm('Etes vous sur de vouloir modifier le nombre de systèmes?\nsi vous réduisez ce nombre\nLes membres qui sont définit comme étant dans l\'un des systèmes supprimé ce verront mis dans la galaxie 1, système 1\n et leur favoris supprimé')){document.getElementById('systems').value='<?php echo $num_of_systems;?>';}" readonly="readonly"> &nbsp; &nbsp; active le champs(<input name="enable_input_num_systems" type="checkbox" onclick="(this.checked)? document.getElementById('systems').readOnly=false : document.getElementById('systems').readOnly=true;">)</th>
</tr>
<tr>
<?php
}
?>
<tr>
	<td class="c" colspan="2">Options de debuggage et de journalisation</td>
</tr>
<tr>
	<th>Enregistrement des erreurs php<br /><div class="z"><i>(Surveillez vos journaux.. peut prendre beaucoup de place)</i></div></th>
	<th><input name="log_phperror" type="checkbox" value="1" <?php echo $log_phperror;?>></th>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<th colspan="2"><input type="submit" value="Valider">&nbsp;<input type="reset" value="Réinitialiser"></th>
</tr>
</form>
</table>
