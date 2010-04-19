<?php
/***************************************************************************
*	filename	: profile.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 17/12/2005
*	modified	: 28/12/2005 23:56:40
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}



//if (!$dont_include_header){
require_once("views/page_header.php");
echo "<table width='100%'>";
?>

<tr>
	<td>
		<table width="100%">
		<tr align="center">
			<td align="center"><a href='http://ogs.servebbs.net'>OGSMarket</a>:</td>
		</tr>
		</table>
	</td>
</tr>
<?php
/*}
else echo "<table align='center' >";*/
?>
<tr>
	<td>
<?php
	$user=$Users->get_user($ogs_id);
	if(!$user) {echo "<div>Profil non trouvé</div>";}
	else
	{
	?>	<table width="300" align="center">
	<tr><th colspan="2">Profil utilisateur de <?php echo $user["name"];?></th></tr>
	<tr><td class="c">Enregistrement :</td><td><?php echo strftime("%a %d %b %H:%M:%S",$user["regdate"]); ?></td>
	<tr><td class="c">Dern. Connexion:</td><td><?php echo strftime("%a %d %b %H:%M:%S",$user["lastvisit"]); ?></td>
	<tr><td class="c">Email: </td><td><?php if (empty($user["email"])) {echo "&lt;Non renseigné&gt;";}
					else {echo "<a href='mailto://".$user["email"]."'>".$user["email"]."</a>";} ?></td>
	<tr><td class="c">MSN: </td><td><?php if (empty($user["msn"])) {echo "&lt;Non renseigné&gt;";}
					else {echo $user["msn"];} ?></td>
	<tr><td class="c">Pseudo Ingame : </td><td><?php if (empty($user["pm_link"])) {echo "&lt;Non renseigné&gt;";}
					else {echo $user["pm_link"];} ?></td>
	<tr><td class="c">IRC Nickname: </td><td><?php if (empty($user["irc_nick"])) {echo "&lt;Non renseigné&gt;";}
					else {echo "<a href='http://ogs.servebbs.net/OGSMarket/index.php?action=pjirc' target='_blank'>".$user["irc_nick"]."</a>";} ?></td>
	<tr>
					<td class="c">note</td>
					<td>
						<textarea name="note"><?php echo $user["note"]; ?></textarea>
					</td>
				</tr>
	
	
	</table><?php
	}


?>
	</td>
</tr>
</table>

<?php
//if (!$dont_include_header){
	require_once("views/page_tail.php");
//	}
?>
