<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
$query = 'SELECT active FROM '.TABLE_MOD.' WHERE action=\'gameOgame\' AND active=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

// Affiche le nombre de joueurs qui participe à gameOgame
$sql = 'SELECT count(id) AS nb FROM '.TABLE_GAME_USERS.' WHERE user=\'1\'';
$result = $db->sql_query($sql);
list($nb) = $db->sql_fetch_row($result);
echo $nb.' participants<br />';
//echo time()."<br>";
//echo time()-(24*60*60)."<br>";

// Affiche le nombre total de rapport saisi
$sql = 'SELECT count(g.id) AS nb FROM '.TABLE_GAME.' AS g,'.TABLE_GAME_USERS.' AS u WHERE g.sender=u.id AND u.user=\'1\'';
$result = $db->sql_query($sql);
list($nb) = $db->sql_fetch_row($result);
echo $nb.' rapports de combats dans la base de données<br /><br />';

?>

<table width='100%'>
<tr><td class='c'>Classement général</td></tr>
<tr>
	<th>
		<form method='post' action='?action=gameOgame&subaction=stats' enctype='multipart/form-data' >
		<input type='submit' name='alliance' value='Alliance' />&nbsp;&nbsp;&nbsp;<input type='submit' name='individuel' value='Personnel' />
		</form>
	</th>
</tr>
</table>
    <table width='100%'>
	   <tr>
		<td valign='top' align='center' width='33%'>
            <table width='100%'>
                <tr>
                    <td class='c' colspan='4'>Top5 joueur</td>
                </tr>
                <tr>
		          <td class='c' width='1'>Rang</td>
		          <td class='c'>Joueur</td>
		          <td class='c'>Points</td>
		          <td class='c'>Nb de rapports<br />(moyenne)</td>
                </tr>
<?php
if (isset($pub_individuel))
{
	$sql = 'SELECT g.sender, sum(g.points) AS total, count(g.id) AS nb,u.nb_rapport,u.point FROM '.TABLE_GAME.' AS g,'.TABLE_GAME_USERS.' AS u  WHERE u.id='.$user_data['user_id'].' AND g.sender='.$user_data['user_id'].' GROUP BY g.sender ORDER BY total DESC, g.sender ASC LIMIT 5';
}
else
{
	$sql = 'SELECT g.sender, sum(g.points) AS total, count(g.id) AS nb,u.nb_rapport,u.point FROM '.TABLE_GAME.' AS g LEFT JOIN '.TABLE_GAME_USERS.' AS u ON u.id=g.sender WHERE u.user=\'1\' GROUP BY g.sender ORDER BY total DESC, g.sender ASC LIMIT 5';
}
$result = $db->sql_query($sql);
$i = 1;
while ($val = $db->sql_fetch_assoc($result))
{
	$name = userNameById($val['sender']);
	echo '<tr><th nowrap>'.$i.'</th><th nowrap><a href=\'?action=gameOgame&subaction=display&player='.$name.'\'>'.$name.'</a></th><th nowrap>'.convNumber(($val['total']+$val['point'])).'</th><th nowrap>'.($val['nb']+$val['nb_rapport']).' ('.convNumber(floor(($val['total']+$val['point'])/($val['nb']+$val['nb_rapport']))).')</th></tr>';
	$i++;
}
?>
            </table>
        </td>
        <td valign='top' align='center' width='33%'>
            <table width='100%'>
                <tr>
                    <td class='c' colspan='4'>Top5 des rapports</td>
                </tr>
                <tr>
                    <td class='c' width='1'>Rang</td>
                    <td class='c'>Joueur</td>
                    <td class='c'>Points</td>
                    <td class='c'>Date<td>
                </tr>
<?php
if (isset($pub_individuel))
{
	$sql = 'SELECT g.date, g.sender, g.id, g.points FROM '.TABLE_GAME.' AS g, '.TABLE_GAME_USERS.' AS u WHERE u.id='.$user_data['user_id'].' AND g.sender='.$user_data['user_id'].' ORDER BY g.points DESC, g.date DESC LIMIT 5';
}
else
{
	$sql = 'SELECT g.date, g.sender, g.id, g.points FROM '.TABLE_GAME.' AS g LEFT JOIN '.TABLE_GAME_USERS.' AS u ON u.id=g.sender WHERE u.user=\'1\' ORDER BY g.points DESC, g.date DESC LIMIT 5';
}
$result = $db->sql_query($sql);
$i = 1;
while ($val = $db->sql_fetch_assoc($result))
{
	$name = userNameById($val['sender']);
	echo '<tr><th nowrap><a href=\'?action=gameOgame&displayRC='.$val['id'].'\'>'.$i.'</a></th><th nowrap><a href=\'?action=gameOgame&subaction=display&player='.$name.'\'>'.$name.'</a></th><th nowrap>'.convNumber($val['points']).'</th><th nowrap>'.date('d/m/Y',$val['date']).'<br>'.date('H:m:s',$val['date']).'</th></tr>';
	$i++;
}
?>
            </table>
        </td>
        <td valign='top' align='center' width='33%'>
            <table width='100%'>
                <tr>
                    <td class='c' colspan='4'>5 derniers rapports</td>
                </tr>
                <tr>
                    <td class='c' width='1'>Rang</td>
                    <td class='c'>Joueur</td>
                    <td class='c'>Points</td>
                    <td class='c'>Date<td>
                </tr>
<?php
if (isset($pub_individuel))
{
	$sql = 'SELECT g.date, g.sender, g.id, g.points FROM '.TABLE_GAME.' AS g WHERE g.sender='.$user_data['user_id'].' ORDER BY g.date DESC LIMIT 5';
}
else
{
	$sql = 'SELECT g.date, g.sender, g.id, g.points FROM '.TABLE_GAME.' AS g LEFT JOIN '.TABLE_GAME_USERS.' AS u ON u.id=g.sender WHERE u.user=\'1\' ORDER BY g.date DESC LIMIT 5';
}
$result = $db->sql_query($sql);
$i = 1;
while ($val = $db->sql_fetch_assoc($result))
{
	$name = userNameById($val['sender']);
	echo '<tr><th nowrap><a href=\'?action=gameOgame&displayRC='.$val['id'].'\'>'.$i.'</a></th><th nowrap><a href=\'?action=gameOgame&subaction=display&player='.$name.'\'>'.$name.'</a></th><th nowrap>'.convNumber($val['points']).'</th><th nowrap>'.date('d/m/Y',$val['date']).'<br>'.date('H:m:s',$val['date']).'</th></tr>';
	$i++;
}
?>
            </table>
        </td>
	</tr>
</table><br />
<table width='100%'><tr><td class='c'>Hall of Fames</td></tr></table>
    <table width='100%'>
        <tr>
            <td valign='top' align='center' width='25%'>
<table width='100%'>
	<tr>
		<td class='c' colspan='4'>Top5 des pertes attaquant</td>
	</tr><tr>
		<td class='c' width='1'>Rang</td>
		<td class='c'>Joueur</td>
		<td class='c'>Pertes</td>
		<td class='c'>Date<td>
	</tr>
<?php
if (isset($pub_individuel))
{
	$sql = 'SELECT g.id, g.sender, g.pertesA, g.date FROM '.TABLE_GAME.' AS g WHERE g.sender='.$user_data['user_id'].' ORDER BY g.pertesA DESC, g.sender ASC LIMIT 5';
}
else
{
	$sql = 'SELECT g.id, g.sender, g.pertesA, g.date FROM '.TABLE_GAME.' AS g,'.TABLE_GAME_USERS.' AS u WHERE g.sender=u.id AND u.user=\'1\' ORDER BY g.pertesA DESC, g.sender ASC LIMIT 5';
}
$result = $db->sql_query($sql);
$i = 1;
while ($val = $db->sql_fetch_assoc($result))
{
	$name = userNameById($val['sender']);
	echo '<tr><th nowrap><a href=\'?action=gameOgame&displayRC='.$val['id'].'\'>'.$i.'</a></th><th nowrap><a href=\'?action=gameOgame&subaction=display&player='.$name.'\'>'.$name.'</a></th><th nowrap>'.convNumber($val['pertesA']).' points</th><th nowrap>'.date('d/m/Y',$val['date']).'<br>'.date('H:m:s',$val['date']).'</th></tr>';
	$i++;
}
?>
</table>
		</td>
		<td valign='top' align='center' width='50%'>
<table width='100%'>
	<tr>
		<td class='c' colspan='4'>Top5 des pertes défenseur</td>
	</tr><tr>
		<td class='c' width='1'>Rang</td>
		<td class='c'>Joueur</td>
		<td class='c'>Pertes</td>
		<td class='c'>Date<td>
	</tr>
<?php
if (isset($pub_individuel))
{
	$sql = 'SELECT g.id, g.sender, g.pertesD, g.date FROM '.TABLE_GAME.' AS g WHERE g.sender='.$user_data['user_id'].' ORDER BY g.pertesD DESC, g.sender ASC LIMIT 5';
}
else
{
	$sql = 'SELECT g.id, g.sender, g.pertesD, g.date FROM '.TABLE_GAME.' AS g,'.TABLE_GAME_USERS.' AS u WHERE g.sender=u.id AND u.user=\'1\' ORDER BY g.pertesD DESC, g.sender ASC LIMIT 5';
}
$result = $db->sql_query($sql);
$i = 1;
while ($val = $db->sql_fetch_assoc($result))
{
	$name = userNameById($val['sender']);
	echo '<tr><th nowrap><a href=\'?action=gameOgame&displayRC='.$val['id'].'\'>'.$i.'</a></th><th nowrap><a href=\'?action=gameOgame&subaction=display&player='.$name.'\'>'.$name.'</a></th><th nowrap>'.convNumber($val['pertesD']).' points</th><th nowrap>'.date('d/m/Y',$val['date']).'<br>'.date('H:m:s',$val['date']).'</th></tr>';
	$i++;
}
?>
</table>
		</td>
	</tr><tr>
		<td valign='top' align='center' width='50%'>
<table width='100%'>
	<tr>
		<td class='c' colspan='4'>Top5 des pillages</td>
	</tr><tr>
		<td class='c' width='1'>Rang</td>
		<td class='c'>Joueur</td>
		<td class='c'>Pillage</td>
		<td class='c'>Date<td>
	</tr>
<?php
if (isset($pub_individuel))
{
	$sql = 'SELECT g.id, g.sender, g.pillageM+g.pillageC+g.pillageD AS total, g.date FROM '.TABLE_GAME.' AS g WHERE g.sender='.$user_data['user_id'].' ORDER BY total DESC, g.sender ASC LIMIT 5';
}
else
{
	$sql = 'SELECT g.id, g.sender, g.pillageM+g.pillageC+g.pillageD AS total, g.date FROM '.TABLE_GAME.' AS g,'.TABLE_GAME_USERS.' AS u WHERE g.sender=u.id AND u.user=\'1\' ORDER BY total DESC, g.sender ASC LIMIT 5';
}
$result = $db->sql_query($sql);
$i = 1;
while ($val = $db->sql_fetch_assoc($result))
{
	$name = userNameById($val['sender']);
	echo '<tr><th nowrap><a href=\'?action=gameOgame&displayRC='.$val['id'].'\'>'.$i.'</a></th><th nowrap><a href=\'?action=gameOgame&subaction=display&player='.$name.'\'>'.$name.'</a></th><th nowrap>'.convNumber($val['total']).' unités</th><th nowrap>'.date('d/m/Y',$val['date']).'<br>'.date('H:m:s',$val['date']).'</th></tr>';
	$i++;
}
?>
</table>
		</td>
		<td valign='top' align='center' width='50%'>
<table width='100%'>
	<tr>
		<td class='c' colspan='4'>Top5 des recyclages</td>
	</tr><tr>
		<td class='c' width='1'>Rang</td>
		<td class='c'>Joueur</td>
		<td class='c'>Recyclage</td>
		<td class='c'>Date<td>
	</tr>
<?php
if (isset($pub_individuel))
{
	$sql = 'SELECT g.date, g.sender, g.id, g.recycleM+g.recycleC AS recyclage FROM '.TABLE_GAME.' AS g  WHERE g.sender='.$user_data['user_id'].' ORDER BY recyclage DESC LIMIT 5';
}
else
{
	$sql = 'SELECT g.date, g.sender, g.id, g.recycleM+g.recycleC AS recyclage FROM '.TABLE_GAME.' AS g LEFT JOIN '.TABLE_GAME_USERS.' AS u ON u.id=g.sender WHERE u.user=\'1\' ORDER BY recyclage DESC LIMIT 5';
}
$result = $db->sql_query($sql);
$i = 1;
while ($val = $db->sql_fetch_assoc($result))
{
	$name = userNameById($val['sender']);
	echo '<tr><th nowrap><a href=\'?action=gameOgame&displayRC='.$val['id'].'\'>'.$i.'</a></th><th nowrap><a href=\'?action=gameOgame&subaction=display&player='.$name.'\'>'.$name.'</a></th><th nowrap>'.convNumber($val['recyclage']).' unités</th><th nowrap>'.date('d/m/Y',$val['date']).'<br>'.date('H:m:s',$val['date']).'</th></tr>';
	$i++;
}
?>
</table>
		</td>

	</tr>
</table>
