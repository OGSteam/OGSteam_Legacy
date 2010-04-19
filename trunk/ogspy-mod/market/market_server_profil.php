<?php
/** market_server_profil.php Page ayant pour but la gestion de ses profils de connection aux Serveurs de Trade
* @package MOD_Market
* @author Jey2k <jey2k.ogsteam@gmail.com>
* @version 1.0
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
require_once($modMarket_path."market_server_profil_class.php");

function check_password($password,$password_confirm)
{
	if ($password=="") return -1;
	if ($password_confirm=="") return -2;
	if (!($password_confirm==$password)) return -3;
	return 1;
}

function login() {
	global $server;
	global $profile;
	global $user_data;
	$url_to_open=$server["server_url"]."/index.php?action=ogspy_auth&subaction=login&ogspy_user_id=".$user_data["user_id"]."&password=".$profile->password."&ogspy_url=".OGSPY_URL;
echo "<br>\n[url]".$url_to_open."[/url]<br>&nbsp;\n";
	$f = fopen($url_to_open, "r");
	$xml = '';
	while (!feof($f)) $xml .= fread($f, 4096);
	fclose($f);
	return get_tag_value(get_tag_value($xml,"market"),"output");
}

if (isset($pub_server_id)){
	$error=0;
	$profile=new cMarketServerProfile($user_data['user_id'],$pub_server_id);
	if (!(isset($pub_subsubaction))) $pub_subsubaction="";
	if ($pub_subsubaction=="updateprofil") {
		if (!(isset($pub_password))) $pub_password="";
		if (!(isset($pub_password_confirm))) $pub_password_confirm="";
		$error=check_password($pub_password,$pub_password_confirm);
echo "[error]".$error."[/error]";
		if ($error==1) {
			echo "[passwordSauvegardé]";
			$profile->password=$pub_password;
			$profile->saveProfile();
		}
	}
	$server=get_server_from_id($pub_server_id);
	?>
	<table>
		<tr>
			<td class="c" colspan="2" align="center">Edition de votre Profil sur le Serveur <?php echo $server["server_name"];?></td>
		</tr>
	<form action="index.php" method="post">
	<input type="hidden" name="action" value="market">
	<input type="hidden" name="server_id" value="<? echo $pub_server_id; ?>">
	<input type="hidden" name="subaction" value="serveruserprofile">
	<input type="hidden" name="subsubaction" value="updateprofil">
	<tr>
			<td width="40%">
				<?php
					if ($profile->password=="")  {
						 echo "Définir votre mot de passe pour ce serveur";
					}
					else {
						echo "Modifier votre mot de passe pour ce serveur";
						$login=login();
						switch ($login)
						{
							case "1":
								echo "Login ok";
								break;
							case "2":
								echo "user non déclaré";
								break;
							case "3":
								echo "Mot de passe erroné";
								break;
							case "4":
								echo "Les logins via OGSpy sont desactivés sur ce serveur";
								break;
						}
					}
				?>
			</td><td><input type="password" name="password"</td>
	</tr>
	<?php
		if ($error==-1) {echo "<tr><td colspan=\"2\"><blink><b><font color='orange'>Saisir un password</font></b></blink></td></tr>";}
	?>
	<tr>
			<td width="40%">Confirmer Password</td><td><input type="password" name="password_confirm"</td>
	</tr>
	<?php
		if ($error==-2) {echo "<tr><td colspan=\"2\"><blink><b><font color='orange'>Vous devez confirmer votre password</font></b></blink></td></tr>";}
		elseif ($error==-3) {echo "<tr><td><blink><b><font color='orange'>Le mot de passe et la confirmation sont différents</font></b></blink></td></tr>";}
	?>
	<tr>
			<td colspan=2"><input type="submit">
	</tr>
	<?php
		if ($error==1) {echo "<tr><td colspan=\"2\"><font color='lime'><b>Modification de password prise en compte.</b></font></td></tr>";}
	?>
</table>
<?php
	} 
?>
