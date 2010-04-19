<?php
/** market_profile.php Edition du profil générique d'un membre OGSpy
* @package MOD_Market
* @author Jey2k <jey2k.ogsteam@gmail.com>
* @version 1.0
*/
require_once($modMarket_path."market_profile_class.php");
if (isset($pub_subaction)&&($pub_subaction=="setprofile")){
	if (!isset($pub_email)) $pub_email="";
	if (!isset($pub_email_msn)) $pub_email_msn="";
	if (!isset($pub_pm_link)) $pub_pm_link="";
	if (!isset($pub_irc_nick)) $pub_irc_nick="";
	if (!isset($pub_note)) $pub_note="";
	
	$ProfilMarket->updateProfil($pub_email,$pub_email_msn,$pub_pm_link,$pub_irc_nick,$pub_note);
}
?>
<table>
<tr><td colspan="3">
  Afin d'etre contacté pour confirmer un deal, ou négocier, les joueurs peuvent acceder a votre profil et utiliser les liens suivants.<br>
  Seul les champs que vous aurez renseignés seront visibles (Bon d'accord... c'est une lapalissade ça...) :)
</td></tr>
<tr>
	<td class="c" colspan="3" align="center">Edition de votre Profil</td>
</tr>
<form action="index.php" method="post">
<input type="hidden" name="action" value="market">
<input type="hidden" name="subaction" value="setprofile">
<?php 
 echo "<tr>\n\t<th width='200'>Email</th>\n"
    ."\t<td class='c'><input type='text'  name='email' value='".$ProfilMarket->email."'></td>";
 echo "<td>";
    if (empty($ProfilMarket->email)) {echo "&lt;Non renseigné&gt;";}
					else {echo $ProfilMarket->email;}
 echo "</td>";
 echo "</tr>";
 echo "<tr>\n\t<th width='200'>Email MSN</th>\n"
    ."\t<td  class='c'><input type='text'  name='email_msn' value='".$ProfilMarket->msn."'></td>";
 echo "<td>";
    if (empty($ProfilMarket->msn)) {echo "&lt;Non renseigné&gt;";}
					else {echo $ProfilMarket->msn;}
 echo "</td>";
 echo "</tr>";
 echo "<tr>\n\t<th width='200'>Msg Privé</th>\n"
    ."\t<td  class='c'><input type='text'  name='pm_link' value='".$ProfilMarket->pm_link."'></td>";
 echo "<td>";
    if (empty($ProfilMarket->pm_link)) {echo "&lt;Non renseigné&gt;";}
					else {echo $ProfilMarket->pm_link;}
 echo "</td>";
 echo "</tr>";
 echo "<tr>\n\t<th width='200'>Nom IRC</th>\n"
    ."\t<td  class='c'><input type='text' name='irc_nick' value='".$ProfilMarket->irc_nick."'></td>";
 echo "<td>";
    if (empty($ProfilMarket->irc_nick)) {echo "&lt;Non renseigné&gt;";}
					else {echo $ProfilMarket->irc_nick;}
 echo "</td>";
 echo "<tr>\n\t<th width='200'>Ma Description</th>\n"
    ."\t<td  class='c'><textarea name='note'>".$ProfilMarket->note."</textarea></td>";
 echo "<td>";
    if (empty($ProfilMarket->note)) {echo "&lt;Non renseigné&gt;";}
					else {echo $ProfilMarket->note;}
 echo "</td>";
 echo "</tr>";
?>
<tr><th colspan="3"  align="center"><input type="submit"></th></tr>
</form>
</table>