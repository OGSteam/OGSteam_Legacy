<?php
/***************************************************************************
*	filename	: menu.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 08/12/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

$items = array();
if (($user_auth["server_set_system"] == 1 && $user_auth["server_set_spy"] == 1) ||
    $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
    $items[] = array("basic", "S. Solaire, R. Espionnage");
} elseif ($user_auth["server_set_system"] == 1) {
    $items[] = array("basic", "S. solaire");
} elseif ($user_auth["server_set_spy"] == 1) {
    $items[] = array("basic", "R. Espionnage");
}
if ($user_auth["server_set_rc"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] ==
    1) {
    $items[] = array("combat_report", "R. Combat");
}

if ($user_auth["server_set_ranking"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] ==
    1) {
    $items[] = array("none", "");
    $items[] = array("none", "----Classement joueur----");
    $items[] = array("general_player", "-> G�n�ral");
    $items[] = array("fleet_player", "-> Flotte");
    $items[] = array("research_player", "-> Recherche");
    $items[] = array("none", "");
    $items[] = array("none", "---Classement alliance---");
    $items[] = array("general_ally", "-> G�n�ral");
    $items[] = array("fleet_ally", "-> Flotte");
    $items[] = array("research_ally", "-> Recherche");
}

?>

<script type="text/javascript">
var date = new Date;
var delta = Math.round((<?php echo (time() * 1000); ?> - date.getTime()) / 1000);
function Timer() {
	var days = new Array ("Dim","Lun","Mar","Mer","Jeu","Ven","Sam");
	var months = new Array ("Jan","F�v","Mar","Avr","Mai","Jui","Jui","Ao�","Sep","oct","nov","d�c");

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
	if (document.post.data.value == "Syst�me solaire & Rapport espionnage & Classement") {
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
<tr align="center"><td><b>Heure serveur</b><br /><span id="datetime"><blink>En attente</blink></span></td></tr>
<tr>
	<td><div align="center"><img src="<?php echo $link_css; ?>/gfx/ogame-produktion.jpg" width="110" height="40" /></div></td>
</tr>
<?php
if ($server_config["server_active"] == 0) {
    echo "<tr>\n";
    echo "\t" . "<td><div align='center'><font color='red'><b><blink>Serveur hors-ligne</blink></b></font></div></td>\n";
    echo "</tr>\n";
}
if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] ==
    1) {
    echo "<tr>";
    echo "<td><div align='center'><font color='#FFFFFF'><a href='index.php?action=administration'>Administration</a></font></div></td>";
    echo "</tr>";
} ?>
<tr><td><div align="center"><a href="index.php?action=profile">Profil</a></div></td></tr>
<tr><td><div align="center"><font color="#FFFFFF"><a href="index.php?action=home">Espace personnel</a></font></div></td></tr>
<tr>
	<td><div align="center"><img src="<?php echo $link_css; ?>/gfx/user-menu.jpg" width="110" height="19"></div></td>
</tr>
<tr><td><div align="center"><a href="index.php?action=galaxy">Galaxie</a></div></td></tr>
<tr><td><div align="center"><a href="index.php?action=cartography">Espace alliance</a></div></td></tr>
<tr><td><div align="center"><a href="index.php?action=search">Rechercher</a></div></td></tr>
<tr><td><div align="center"><a href="index.php?action=ranking">Classement</a></div></td></tr>
<tr>
	<td><div align="center"><img src="<?php echo $link_css; ?>/gfx/user-menu.jpg" width="110" height="19"></div></td>
</tr>
<tr><td><div align="center"><a href="index.php?action=statistic">Etat Cartographie</a></div></td></tr>
<tr><td><div align="center"><a href="index.php?action=galaxy_obsolete">Syst. obsol�tes</a></div></td></tr>
<tr>
	<td><div align="center"><img src="<?php echo $link_css; ?>/gfx/user-menu.jpg" width="110" height="19"></div></td>
</tr>
<!-- Emplacement mod /-->
<?php
if ($cache_mod) {
    if (ratio_is_ok()) {
        foreach ($cache_mod as $val) {
            if ($val['admin_only'] != '1') {
                echo '<tr><td><div align="center"><a href="index.php?action=' . $val['action'] .
                    '">' . $val['menu'] . '</a></div></td></tr>' . "\n";
            }
        }
    } else
        echo '<tr><td><div align="center"><font color="red">Mods<br />inaccessibles&nbsp;' .
            help("ratio_block") . '</font></div></td></tr>' . "\n";
?>
<!-- Fin des mods /-->
<!-- Emplacement mod  admin/-->
<?php
    if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
        foreach ($cache_mod as $val) {
            if ($val['admin_only'] == '1') {
                echo '<tr><td><div align="center"><a href="index.php?action=' . $val['action'] .
                    '">' . $val['menu'] . '</a></div></td></tr>' . "\n";
            }
        }
    }
}
?>
<!-- Fin des mods  admin/-->
<tr>
	<td><div align="center"><img src="<?php echo $link_css; ?>/gfx/user-menu.jpg" width="110" height="19"></div></td>
</tr>
<tr><td><div align="center"><a href="index.php?action=logout">D�connexion</a></div></td></tr>
<tr>
	<td><div align="center"><img src="<?php echo $link_css; ?>/gfx/user-menu.jpg" width="110" height="19"></div></td>
</tr>
<?php if ($server_config["url_forum"] != "") { ?>
<tr><td><div align="center"><a href="<?php echo $server_config["url_forum"]; ?>" target="_blank">Forum</a></div></td></tr>
<?php } ?>
<tr><td><div align="center"><a href="index.php?action=about">A propos</a></div></td></tr>
<tr>
	<td><div align="center"><img src="<?php echo $link_css; ?>/gfx/user-menu.jpg" width="110" height="35"></div></td>
</tr>
</table>
</div>
<br />
<table>
<?php //TODO =>Suppression de l'insertion Manuelle ?>
<!-- <form method="POST" name="post" enctype="multipart/form-data" action="index.php">
<input type="hidden" name="action" value="get_data">
<?php
if (sizeof($items) > 0) {
    echo "<tr><td>" . "\n";
    echo "\t" . "<select name='datatype'>" . "\n";
    foreach ($items as $value) {
        list($type, $text) = $value;
        echo "\t" . "<option value='" . $type . "'>" . $text . "</option>" . "\n";
    }
    echo "\t" . "</select>" . "\n";
    echo "</td></tr>" . "\n";
}

echo "<tr align='center'>" . "\n";
echo "\t" . "<td><textarea name='data' rows='3' cols='20' onFocus='clear_box()'>";
if (sizeof($items) > 0)
    echo "Syst�me solaire & Rapport espionnage & Classement";
else
    echo "Vous ne disposez pas des droits n�cessaires pour importer des informations sur le serveur";
echo "</textarea></td>" . "\n";
echo "</tr>" . "\n";

if (sizeof($items) > 0) {
    echo "<tr>" . "\n";
    echo "\t" . "<td><div align='center'><input type='submit' value='Envoyer' ></div></td>" .
        "\n";
    echo "</tr>" . "\n";
}
?>
</form> -->
</table>
