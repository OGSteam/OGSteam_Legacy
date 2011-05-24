<?php
/**
* sign_conf.php configuration des sign
* @package OGSign
* @author oXid_FoX
* @link http://www.ogsteam.fr
*	created		: 04/09/2006 12:34:58
*/


if (!defined('IN_SPYOGAME')) die('Hacking attempt');

require_once('views/page_header.php');
require_once('sign_include.php');
$folder = "ogssign";

$query = 'SELECT `version` FROM `'.TABLE_MOD.'` WHERE `action`=\''.$pub_action.'\' AND `active`=\'1\' LIMIT 1';
$result = $db->sql_query($query);
if (!$db->sql_numrows($result)) die('Mod désactivé !');
$ogsign_version = mysql_result($result,0,'version');

// recherche des paramètres de la signature
$query = 'SELECT `pseudo_ig` FROM `'.TABLE_USER_SIGN.'` WHERE `user_id` = '.$user_data['user_id'];
$sign_exist = $db->sql_numrows($db->sql_query($query));

// on va essayer les $pub_
if (!isset($pub_subaction)) $pub_subaction = 'stats';

// l'utilisateur est-il (co)admin ?
if ($user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1 )
	$nb_colonnes = 4;	// 4 colonnes : stats, prod, conf_ally, admin
else
	$nb_colonnes = 3;	// 3 colonnes : stats, prod, visu_ally

?>
<table align="center" width="100%" cellpadding="0" cellspacing="1">
<tr align="center"><td class="c" colspan="<?php echo $nb_colonnes; ?>" >Configuration d'OGSign</td></tr>
<tr align="center">
<?php
// menu sign_conf_stats
if ($pub_subaction != 'stats') echo '<td class="c" width="',floor(100/$nb_colonnes),'%"><a href="index.php?action='.$folder.'&subaction=stats" style="color: lime;"';
else echo '<th width="',floor(100/$nb_colonnes),'%"><a';
echo '>Statistiques</a></td>',"\n";

// menu sign_conf_prod
if ($pub_subaction != 'prod') echo '<td class="c" width="',floor(100/$nb_colonnes),'%"><a href="index.php?action='.$folder.'&subaction=prod" style="color: lime;"';
else echo '<th width="',floor(100/$nb_colonnes),'%"><a';
echo '>Production</a> ';
echo infobulle('Paramétrez votre production grâce au mod "Production"<br>(les données sont reprises sur cette image)');
// rend le code HTML un tout petit peu plus lisible...
echo "\n";

if ($user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1 ) {
	// menu sign_conf_ally
	if ($pub_subaction != 'ally') echo '<td class="c" width="',floor(100/$nb_colonnes),'%"><a href="index.php?action='.$folder.'&subaction=ally" style="color: lime;"';
	else echo '<th width="',floor(100/$nb_colonnes),'%"><a';
	echo '>Alliance</a></td>';

	if ($pub_subaction != 'admin') echo '<td class="c" width="',floor(100/$nb_colonnes),'%"><a href="index.php?action='.$folder.'&subaction=admin" style="color: lime;"';
	else echo '<th width="',floor(100/$nb_colonnes),'%"><a';
	echo '>Administration</a></td>';

} else {

	// menu sign_visu_ally
	if ($pub_subaction != 'ally') echo '<td class="c" width="',floor(100/$nb_colonnes),'%"><a href="index.php?action='.$folder.'&subaction=ally" style="color: lime;"';
	else echo '<th width="',floor(100/$nb_colonnes),'%"><a';
	echo '>Alliance</a></td>';

}
?></td>
</tr>
</table>

<?php
switch ($pub_subaction) {
// configurer les stats
case 'stats':
	require('sign_conf_stats.php');
	break;
// configurer la production
case 'prod':
	require('sign_conf_prod.php');
	break;
// configurer / visualiser l'alliance
case 'ally':
	if ($user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1 )
		require('sign_conf_ally.php');
	else
		require('sign_visu_ally.php');
	break;
// administration d'OGSign
case 'admin':
	require('sign_admin.php');
	break;
// par défaut, on ira sur la config des stats
default:
	require('sign_conf_stats.php');
}

?>
<div align=center style="clear: left;"><span style="font-size: 13px;"><b>OGSign</b> <?php
// on affiche le numéro de version
echo $ogsign_version,' par <b>oXid_FoX</b> &copy; 2006-',date('Y'),'</span></div>';

require_once('views/page_tail.php');
?>
