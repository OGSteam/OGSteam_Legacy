<?php
/***************************************************************************
*	filename	: profile.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 08/12/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined("IN_SPYOGAME")) {
	die("Hacking attempt");
}

$user_name = $user_data["username"];
$user_galaxy = $user_data["user_galaxy"];
$user_system = $user_data["user_system"];
$user_skin = $user_data["user_skin"];
if ($server_config["disable_ip_check"] == 1) $disable_ip_check = $user_data["disable_ip_check"] == 1 ? "checked" : "";
else $disable_ip_check = "disabled";
?>

<!-- DEBUT DU SCRIPT -->
<script language="JavaScript">
function check_password(form) {
	var old_password = form.old_password.value
	var new_password = form.new_password.value
	var new_password2 = form.new_password2.value

	if (old_password != "" && (new_password == "" || new_password2 == "")) {
		alert("Saisissez le nouveau mot de passe et sa confirmation");
		return false;
	}
	if (old_password == "" && (new_password != "" || new_password2 != "")) {
		alert("Saisissez l'ancien mot de passe");
		return false;
	}
	if (old_password != "" && new_password != new_password2) {
		alert("Le mot de passe saisie est diff�rent de la confirmation");
		return false;
	}
	if (old_password != "" && new_password != "" && new_password2 != "") {
		if (new_password.length < 6 || new_password.length > 15) {
			alert("Le mot de passe doit contenir entre 6 et 15 caract�res");
			return false;
		}
	}

	return true;
}
</script>
<!-- FIN DU SCRIPT -->
<center>
<table width="450">
<form method="POST" action="index.php" onsubmit="return check_password(this);">
<input name="action" type="hidden" value="member_modify_member">
	<input name="pseudo" type="hidden" size="20" maxlength="20" value="<?php echo $user_name;?>">
	<input name="old_password" type="hidden" size="20" maxlength="15">
	<input name="new_password" type="hidden" size="20" maxlength="15">
	<input name="new_password2" type="hidden" size="20" maxlength="15">
<tr>
	<td class="c" colspan="2">Position de la plan�te principale</td>
</tr>
<tr>
	<th>Position de la plan�te principale&nbsp;<?php echo help("profile_main_planet");?></th>
	<th>
		<input name="galaxy" type="text" size="3" maxlength="1" value="<?php echo $user_galaxy;?>">&nbsp;
		<input name="system" type="text" size="3" maxlength="3" value="<?php echo $user_system;?>">
	</th>
</tr>
<tr>
	<td class="c" colspan="2">Divers</td>
</tr>
<tr>
	<th>Lien du skin utilis�&nbsp;<?php echo help("profile_skin");?></th>
	<th>
		<input name="skin" type="text" size="20" value="<?php echo $user_skin;?>">
	</th>
</tr>
<tr>
	<th>D�sactiver la v�rification de l'adresse IP&nbsp;<?php echo help("profile_disable_ip_check");?></th>
	<th>
		<input name="disable_ip_check" value="1" type="checkbox" <?php echo $disable_ip_check;?>>
	</th>
</tr>
<tr>
	<th colspan="2">&nbsp;</th>
</tr>
<tr>
	<th colspan="2" align="center"><input type="submit" value="Valider"></th>
</tr>
</form>
</table>
</center>
