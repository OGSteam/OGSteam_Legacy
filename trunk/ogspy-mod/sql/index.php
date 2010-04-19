<?php
/**
* index.php page principale du modSQL
* @package modSQL
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created : 04/09/2006 12:34:58
*/

if (!defined('IN_SPYOGAME')) die('Hacking attempt');

$result = $db->sql_query('SELECT `version` FROM `'.TABLE_MOD.'` WHERE `action`=\''.$pub_action.'\' AND `active`=\'1\' LIMIT 1');
if (!$db->sql_numrows($result)) die('Mod désactivé !');
$mod_version = $db->sql_fetch_row($result);
$mod_version = $mod_version[0];

$result = $db->sql_query('SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'modSQL_coadmin\' LIMIT 1');
$mod_coadmin = $db->sql_fetch_row($result);
$mod_coadmin = $mod_coadmin[0];

$result = $db->sql_query('SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name`=\'modSQL_fullscreen\' LIMIT 1');
$mod_fullscreen = $db->sql_fetch_row($result);
$mod_fullscreen = $mod_fullscreen[0];

// redirection lorsque changement de mode (fullscren/menu OGSpy)
// afin d'avoir l'effet immédiat (sans avoir à recliquer pour voir le changement)
if (isset($pub_fullscreen_view))
	header('Location: index.php?action=modSQL&subaction=config');

// nécessité de restreindre un minimum l'accès...
if ($user_data['user_admin'] != 1 && !($user_data['user_coadmin'] == 1 && $mod_coadmin == 1) ) {
	require_once('views/page_header.php');
	// améliorer ça !
	die('Mod réservé aux admins.');
}

// suppression du menu lorsque fullscreen
if ($mod_fullscreen) { ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="language" content="fr">
<title>modSQL - <?php echo $server_config['servername'],' - OGSpy ',$server_config['version'];?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $link_css;?>formate.css" />
</head>
<body>
<div style="text-align: center; margin: 15px;"><img src="images/<?php echo $banner_selected;?>"><br />
<a href="index.php">&larr; Retour OGSpy</a> / <a href="index.php?action=logout">Déconnexion</a></div>
<?php } else
	require_once('views/page_header.php');

// l'utilisateur est-il (co)admin ?
if ($user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1 )
	$nb_colonnes = 2;	// 2 colonnes : SQL, config
else
	$nb_colonnes = 1;	// 1 colonnes : SQL

echo '<table align="center" width="100%" cellpadding="0" cellspacing="1">
<tr align="center"><td class="c" colspan="',$nb_colonnes,'" >modSQL</td></tr>
<tr align="center">';

// subaction par défaut
if (!isset($pub_subaction)) $pub_subaction = 'sql';

// menu SQL
if ($pub_subaction != 'sql') echo '<td class="c" width="',floor(100/$nb_colonnes),'%"><a href="index.php?action=modSQL&subaction=sql" style="color: lime;"';
else echo '<th width="',floor(100/$nb_colonnes),'%"><a';
echo '>SQL</a></td>',"\n";

// menu config
if ($user_data['user_admin'] == 1) {
	if ($pub_subaction != 'config') echo '<td class="c" width="',floor(100/$nb_colonnes),'%"><a href="index.php?action=modSQL&subaction=config" style="color: lime;"';
	else echo '<th width="',floor(100/$nb_colonnes),'%"><a';
	echo '>Configuration</a> ',"\n";
}

echo '</td>
</tr>
</table>';

switch ($pub_subaction) {
// les requetes
case 'sql':
	include_once 'reqsql.php';
	break;
// la configuration
case 'config':
	include_once 'config.php';
	break;

}

?>
<div align=center style="clear: left;"><span style="font-size: 13px;"><b>modSQL</b> <?php
// on affiche le numéro de version
echo $mod_version,' par <b>oXid_FoX</b> &copy; 2007',(2007<date('Y')) ? ' - '.date('Y') : '','</span></div>';

require_once('views/page_tail.php');
?>
