<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

require_once('./views/page_header.php');
require_once('./mod/gameOgame/include.php');
require_once('./mod/gameOgame/languages/french/help.php');

$query = 'SELECT active FROM '.TABLE_MOD.' WHERE action=\'gameOgame\' AND active=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');
//Controle depuis combien de temps a eu lieu la derniere purge
$maintenant = time();
if ($maintenant >= $config['timer'] + (24 * 60 * 60)) // 24heures * 60 minutes * 60 secondes
{
	if ($config['autoS'] == "TRUE")
	{
		softpurge();
		$config['timer']=time();
		gog_SauvConfig(); 
	}
	elseif ($config['autoH'] == "TRUE")
	{
		hardpurge();
		$config['timer']=time();
		gog_SauvConfig();
	}
}

?>
<table width="100%">
	<tr>
		<td>
<?php
//Menu
// Si la page a afficher n'est pas définie, on affiche la première
if (!isset($pub_subaction)) $pub_subaction='Stats';
menu($pub_subaction);
?>
		</td>
	</tr>
	<tr>
		<td>
<?php
$action = false;

if (isset($pub_displayRC))
{
	require_once('./mod/gameOgame/displayRC.php');
	$action = true;
}

if (isset($pub_reportRecyclage))
{
	require_once('./mod/gameOgame/reportRecyclage.php');
	$action = true;
}

if (!$action) switch ($pub_subaction)
{
	case 'stats': require_once('./mod/gameOgame/stats.php'); break;
	case 'display': require_once('./mod/gameOgame/display.php'); break;
	case 'report': require_once('./mod/gameOgame/report.php'); break;
	case 'admin': require_once('./mod/gameOgame/admin.php'); break;
	case 'changelog': require_once('./mod/gameOgame/changelog.php'); break;
	default: require_once('./mod/gameOgame/stats.php'); break;
}
?>
		</td>
	</tr>
</table><br>
<?php
page_footer();
require_once('./views/page_tail.php');
?>