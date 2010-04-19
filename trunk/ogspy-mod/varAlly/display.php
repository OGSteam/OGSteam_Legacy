<?php
/**
* display.php
* @package varAlly
* @author Aeris
* @link http://ogsteam.fr
 */
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

$tag = $server_config['tagAlly'];

$tag = $pub_affiche ? $pub_tag : $tag;
check_tag($tag);
echo '<form action=\'?action=varAlly&subaction=display\' method=\'post\'>Liste des tags � afficher: <input type=\'text\' name=\'tag\' value=\''.$tag.'\'> <input type=\'submit\' value=\'Afficher\'><input type=\'hidden\' name=\'affiche\' value=\'true\'></form>';

$listTag = explode(';',$tag);

if ($tag == '')
{
	echo '<table width=\'100%\'><tr><td class=\'c\'>Pas d\'alliance s�lectionn�e</th></tr></table></br>';
} else {
	foreach ($listTag as $tag)
	{
		$query = 'SELECT DISTINCT `player` FROM `'.TABLE_UNIVERSE.'` WHERE `ally`=\''.mysql_real_escape_string($tag).'\' ORDER BY `player` ASC';
		$result = $db->sql_query($query);
?>
		<table width='100%'>
		<tr><td class='c' colspan='7'>Alliance [<?php echo $tag; ?>]</td></tr>
		<tr><td class='c'>Joueur</td><td class='c'>Ecart g�n�ral</td><td class='c'>%</td><td class='c'>Ecart flotte</td><td class='c'>%</td><td class='c'>Ecart recherche</td><td class='c'>%</td></tr>		
<?php
		while ($val = $db->sql_fetch_assoc($result))
		{
			$player = $val['player'];
		
			echo '<tr><th>'.$player.'</th>';
			affStats('points',$player);
			affStats('fleet',$player);
			affStats('research',$player);
			echo '</tr>';
		}
?>
		</table><br>
<?php
	}
}
?>
