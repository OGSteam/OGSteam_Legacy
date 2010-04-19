<?php
/***************************************************************************
*	filename	: editprofile.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 17/12/2005
*	modified	: 28/12/2005 23:56:40
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
?>
<table>
<tr><td colspan="3" >
  Afin d'etre contacté pour confirmer un deal, ou négocier, les joueurs peuvent acceder a votre profil et utiliser les liens suivants.<br>
  Seul les champs que vous aurez renseigné seront visible (Bon d'accord... c'est une lapalissade ça...) :)
</td></tr>
<tr>
	<td class="c" colspan="3" align="center">Edition de votre Profil</td>
</tr>
<form action="index.php" method="post">
<input type="hidden" name="action" value="setprofile">
<?php 
 echo "<tr>\n\t<th width='200'>Email</th>\n"
    ."\t<td class='c'><input type='text'  name='email' value='".$user_data["email"]."'></td>";
 echo "<td>";
    if (empty($user_data["email"])) {echo "&lt;Non renseigné&gt;";}
					else {echo $user_data["email"];}
 echo "</td>";
 echo "</tr>";
 echo "<tr>\n\t<th width='200'>Email MSN</th>\n"
    ."\t<td  class='c'><input type='text'  name='email_msn' value='".$user_data["msn"]."'></td>";
 echo "<td>";
    if (empty($user_data["msn"])) {echo "&lt;Non renseigné&gt;";}
					else {echo $user_data["msn"];}
 echo "</td>";
 echo "</tr>";
 echo "<tr>\n\t<th width='200'>Pseudo Ingame</th>\n"
    ."\t<td  class='c'><input type='text'  name='pm_link' value='".$user_data["pm_link"]."'></td>";
 echo "<td>";
    if (empty($user_data["pm_link"])) {echo "&lt;Non renseigné&gt;";}
					else {echo $user_data["pm_link"];}
 echo "</td>";
 echo "</tr>";
 echo "<tr>\n\t<th width='200'>Nom IRC</th>\n"
    ."\t<td  class='c'><input type='text' name='irc_nick' value='".$user_data["irc_nick"]."'></td>";
 echo "<td>";
    if (empty($user_data["irc_nick"])) {echo "&lt;Non renseigné&gt;";}
					else {echo $user_data["irc_nick"];}
 echo "</td>";
 echo "<tr>\n\t<th width='200'>Ma Description</th>\n"
    ."\t<td  class='c'><textarea name='note'>".$user_data["note"]."</textarea></td>";
 echo "<td>";
    if (empty($user_data["note"])) {echo "&lt;Non renseigné&gt;";}
					else {echo $user_data["note"];}
 echo "</td>";
 echo "</tr>";
?>
<tr><th colspan="3"  align="center"><input type="submit"></th></tr>
</form>
</table>
<?php
require_once("views/page_tail.php");
?>
