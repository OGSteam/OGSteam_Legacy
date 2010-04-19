<?php
/**
* maj.php 
* @package MAJ
* @author ben.12
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if (!($user_data["user_admin"]==1 || $user_data["user_coadmin"]==1))
	die("Accepté interdit!");

$help["mod_maj_popup"] = "Affichage d'un popup pour les membres étant en retard sur une mise à jour qui lui est assigné.";


if(isset($pub_active) && isset($pub_seuil) && isset($pub_step_rank_player) && isset($pub_step_rank_ally)
	&& isset($pub_num_rank_ally) && isset($pub_num_rank_ally)) {
	
	if(($pub_active!=0 && $pub_active!=1) || !is_numeric($pub_seuil)
		 || !is_numeric($pub_step_rank_player) || !is_numeric($pub_step_rank_ally)
		 || !is_numeric($pub_num_rank_player) || !is_numeric($pub_num_rank_ally))
		redirection("index.php?action=message&id_message=errordata&info");
	
	if($pub_seuil<0 || $pub_seuil>99
		 || $pub_step_rank_player<0  || $pub_step_rank_player>999
		 || $pub_step_rank_ally<0    || $pub_step_rank_ally>999
		 || $pub_num_rank_player<0   || $pub_num_rank_ally<0)
		redirection("index.php?action=message&id_message=errordata&info");
	
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_active."'";
	$request .= " where config_name = 'popup_maj_active'";
	$db->sql_query($request);
	
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_seuil."'";
	$request .= " where config_name = 'popup_maj_seuil_alert'";
	$db->sql_query($request);
	
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_step_rank_player."'";
	$request .= " where config_name = 'popup_maj_step_rank_player_alert'";
	$db->sql_query($request);
	
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_step_rank_ally."'";
	$request .= " where config_name = 'popup_maj_step_rank_ally_alert'";
	$db->sql_query($request);
	
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_num_rank_player."'";
	$request .= " where config_name = 'popup_maj_num_rank_player_alert'";
	$db->sql_query($request);
	
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_num_rank_ally."'";
	$request .= " where config_name = 'popup_maj_num_rank_ally_alert'";
	$db->sql_query($request);
	
	redirection("index.php?action=mod_maj&subaction=admin");
}


echo '<form action="index.php" method="post">',"\n";
echo '<input type="hidden" name="action" value="mod_maj">',"\n";
echo '<input type="hidden" name="subaction" value="admin">',"\n";
echo "\n<table>\n";
echo "\t<tr>\n";
echo "\t\t<td class='c' colspan='2'>Avertissements Popup &nbsp;".help("mod_maj_popup")."</td>\n";
echo '</tr>';

if(!defined('POPUP_MAJ_INCLUDED')) {
	echo "<tr>\n\t\t<th colspan='2'><blink><font color='red'><b>Popup non installé.</b></font></blink><br>Veillez lire le fichier \"Hack_pour_popup.txt\"</th>\n\t</tr>";
}

echo "\t<tr>\n";
echo "\t\t<th>Affichage des popup actif:</th>";
echo "\t\t<th><input type='radio' name='active' value='1' ".($server_config['popup_maj_active']?'checked':'')."> oui &nbsp;-&nbsp; <input type='radio' name='active' value='0' ".(!$server_config['popup_maj_active']?'checked':'')."> non</th>\n";
echo "\t</tr>\n";

echo "\t<tr>\n";
echo "\t\t<th>Seuil d'alerte pour la galaxie:</th>";
echo "\t\t<th>Si moins de <input type='text' name='seuil' size='2' maxlength='2' value='".$server_config['popup_maj_seuil_alert']."'> % des planètes à jour.</th>";
echo "\t</tr>\n";

echo "\t<tr>\n";
echo "\t\t<th>Interval entre deux mises à jour d'un classement de joueurs:</th>";
echo "\t\t<th><input type='text' name='step_rank_player' size='3' maxlength='3' value='".$server_config['popup_maj_step_rank_player_alert']."'> jours.</th>";
echo "\t</tr>\n";

echo "\t<tr>\n";
echo "\t\t<th>Interval entre deux mises à jour d'un classement d'alliances:</th>";
echo "\t\t<th><input type='text' name='step_rank_ally' size='3' maxlength='3' value='".$server_config['popup_maj_step_rank_ally_alert']."'> jours.</th>";
echo "\t</tr>\n";

echo "\t<tr>\n";
echo "\t\t<th>Nombre minimum de lignes pour un classement de joueurs:</th>";
echo "\t\t<th><input type='text' name='num_rank_player' size='4' maxlength='4' value='".$server_config['popup_maj_num_rank_player_alert']."'> lignes.</th>";
echo "\t</tr>\n";

echo "\t<tr>\n";
echo "\t\t<th>Nombre minimum de lignes pour un classement d'alliances:</th>";
echo "\t\t<th><input type='text' name='num_rank_ally' size='4' maxlength='4' value='".$server_config['popup_maj_num_rank_ally_alert']."'> lignes.</th>";
echo "\t</tr>\n";

echo "<tr>\n\t\t<th colspan='2'><input type='submit' value='Enregistrer'></th>\n\t</tr>";

echo "</table>\n</form>\n"
?>