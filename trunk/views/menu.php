<?php
/***************************************************************************
*	filename	: menu.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 08/12/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

$items = array();
if (($user_auth["server_set_system"] == 1 && $user_auth["server_set_spy"] == 1) || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	$items[] = array("basic", "S. Solaire, R. Espionnage");
}
elseif ($user_auth["server_set_system"] == 1) {
	$items[] = array("basic", "S. solaire");
}
elseif ($user_auth["server_set_spy"] == 1) {
	$items[] = array("basic", "R. Espionnage");
}
if ($user_auth["server_set_rc"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	$items[] = array("combat_report", "R. Combat");
}

if ($user_auth["server_set_ranking"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	$items[] = array("none", "");
	$items[] = array("none", "----Classement joueur----");
	$items[] = array("general_player", "-> Général");
	$items[] = array("fleet_player", "-> Flotte");
	$items[] = array("research_player", "-> Recherche");
	$items[] = array("mines_player", "-> Mines");
	$items[] = array("defenses_player", "-> Défenses");	
	$items[] = array("none", "");
	$items[] = array("none", "---Classement alliance---");
	$items[] = array("general_ally", "-> Général");
	$items[] = array("fleet_ally", "-> Flotte");
	$items[] = array("research_ally", "-> Recherche");
	$items[] = array("mines_ally", "-> Mines");
	$items[] = array("defenses_ally", "-> Défenses");
}

?>

<script type="text/javascript">
var date = new Date;
var delta = Math.round((<?php echo (time() * 1000);?> - date.getTime()) / 1000);
function Timer() {
	var days = new Array ("Dim","Lun","Mar","Mer","Jeu","Ven","Sam");
	var months = new Array ("Jan","Fév","Mar","Avr","Mai","Jui","Jui","Aoû","Sep","oct","nov","déc");

	date = new Date;
	date.setTime(date.getTime() + delta*1000);
	var hour = date.getHours();
	var min = date.getMinutes();
	var sec = date.getSeconds();
	var day = days[date.getDay()];
	var day_number = date.getDate();
	var month = months[date.getMonth()];
	if (sec < 10) sec = "0" + sec;
	if (min < 10) min = "0" + min;
	if (hour < 10) hour = "0" + hour;

	var datetime = day + " " + day_number + " " + month + " " + hour + ":" + min + ":" + sec;

	if (document.getElementById) {
		document.getElementById("datetime").innerHTML = datetime;
	}
}

go_visibility = new Array;
function goblink() {
	if(document.getElementById && document.all)
	{
		blink_tab = document.getElementsByTagName('blink');
		for(a=0;a<blink_tab.length;a++) {
			if(go_visibility[a] != "visible")
			go_visibility[a] = "visible";
			else
			go_visibility[a] = "hidden";
			blink_tab[a].style.visibility=go_visibility[a];
		}
	}
}

function clear_box() {
	if (document.post.data.value == "Système solaire & Rapport espionnage & Classement") {
		document.post.data.value = "";
	}
}

function Biper() {
	Timer();
	goblink();	

	setTimeout("Biper()", 1000);	
}

window.onload = Biper;
</script>
<div class="style">
<table border="0" cellpadding="0" cellspacing="0">
<tr align="center"><td><b>Heure serveur</b><br /><span id="datetime"></span></td></tr>
<tr>
	<td><img src="<?php echo $link_css;?>/gfx/spacecon-produktion.jpg" width="110" height="40" /></td>
</tr>
<?php
if ($server_config["server_active"] == 0) {
	echo "<tr>\n";
	echo "\t"."<td><div align='center'><font color='red'><b><blink>Serveur hors-ligne</blink></b></font></div></td>\n";
	echo "</tr>\n";
}
if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) {
	echo "<tr>";
	echo "<td><div align='center'><font color='#FFFFFF'><a href='index.php?action=administration'>Administration</a></font></div></td>";
	echo "</tr>";
}?>
<tr><td><div align="center"><a href="index.php?action=profile">Profil</a></div></td></tr>
<tr><td><div align="center"><font color="#FFFFFF"><a href="index.php?action=home">Espace personnel</a></font></div></td></tr>
<tr>
	<td><img src="<?php echo $link_css;?>/gfx/user-menu.jpg" width="110" height="19"></td>
</tr>
<tr><td><div align="center"><a href="index.php?action=galaxy">Galaxie</a></div></td></tr>
<tr><td><div align="center"><a href="index.php?action=cartography">Espace alliance</a></div></td></tr>
<tr><td><div align="center"><a href="index.php?action=search">Recherche</a></div></td></tr>
<tr><td><div align="center"><a href="index.php?action=ranking">Classement</a></div></td></tr>
<tr>
	<td><img src="<?php echo $link_css;?>/gfx/user-menu.jpg" width="110" height="19"></td>
</tr>
<tr><td><div align="center"><a href="index.php?action=statistic">Statistiques</a></div></td></tr>
<tr><td><div align="center"><a href="index.php?action=galaxy_obsolete">Syst. obsolètes</a></div></td></tr>
<!-- Emplacement mod /-->
<?php
$request = "select action, menu, admin_only from ".TABLE_MOD." where active = 1 order by position, title";
$result = $db->sql_query($request);
if ($db->sql_numrows($result)) {
    echo '<tr><td><img src="'.$link_css.'/gfx/user-menu.jpg" width="110" height="19"></td></tr>';
    while ($val = $db->sql_fetch_assoc($result)) {
        if (($val["admin_only"] == 1)) {
        continue;
    }
        echo '<tr><td><div align="center"><a href="index.php?action='.$val['action'].'">'.$val['menu'].'</a></div></td></tr>';
    }
}
?>
<!-- Fin des mods /-->
<!-- Emplacement mod  admin/-->
<?php
    if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
$request = "select action, menu, admin_only from ".TABLE_MOD." where active = 1 order by position, title";
$result = $db->sql_query($request);
if ($db->sql_numrows($result)) {
    echo '<tr><td><img src="'.$link_css.'/gfx/user-menu.jpg" width="110" height="19"></td></tr>';
    while ($val = $db->sql_fetch_assoc($result)) {
        if (($val["admin_only"] == 0)) {
        continue;
    }
        echo '<tr><td><div align="center"><a href="index.php?action='.$val['action'].'">'.$val['menu'].'</a></div></td></tr>';
    }
}
}
?>
<!-- Fin des mods  admin/-->
<tr>
	<td><img src="<?php echo $link_css;?>/gfx/user-menu.jpg" width="110" height="19"></td>
</tr>
<tr><td><div align="center"><a href="index.php?action=logout">Déconnexion</a></div></td></tr>
<tr>
	<td><img src="<?php echo $link_css;?>/gfx/user-menu.jpg" width="110" height="19"></td>
</tr>
<?php
if ($server_config["url_forum"] != "") {?>
<tr><td><div align="center"><a href="<?php echo $server_config["url_forum"];?>" target="_blank">Forum</a></div></td></tr>
<?php }?>
<tr><td><div align="center"><a href="index.php?action=about">A propos ...</a></div></td></tr>
<tr>
	<td><img src="<?php echo $link_css;?>/gfx/user-menu.jpg" width="110" height="35"></td>
</tr>
</table>
</div>
<br />
<table>
<form method="POST" name="post" enctype="multipart/form-data" action="index.php">
<input type="hidden" name="action" value="get_data">
<?php
if (sizeof($items) > 0) {
	echo "<tr><td>"."\n";
	echo "\t"."<select name='datatype'>"."\n";
	foreach ($items as $value) {
		list($type, $text) = $value;
		echo "\t"."<option value='".$type."'>".$text."</option>"."\n";
	}
	echo "\t"."</select>"."\n";
	echo "</td></tr>"."\n";
}

echo "<tr align='center'>"."\n";
echo "\t"."<td><textarea name='data' rows='3' cols='20' onFocus='clear_box()'>";
if (sizeof($items) > 0) echo "Système solaire & Rapport espionnage & Classement";
else echo "Vous ne disposez pas des droits nécessaires pour importer des informations sur le serveur";
echo "</textarea></td>"."\n";
echo "</tr>"."\n";

if (sizeof($items) > 0) {
	echo "<tr>"."\n";
	echo "\t"."<td><div align='center'><input type='submit' value='Envoyer' ></div></td>"."\n";
	echo "</tr>"."\n";
}
?>
</form>
</table>
