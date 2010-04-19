<?php
/***************************************************************************
*	filename	: menu.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 08/12/2005
*	modified	: 21/11/2006 19:40:18

***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
//global $LANG, $help;

$items = array();
$menus = array();

if (($user_auth["server_set_system"] == 1 && $user_auth["server_set_spy"] == 1) || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	$items[] = array("basic", $LANG["sendbox_SolarSystem"] . " - " . $LANG["sendbox_SpyReport"]);
}
elseif ($user_auth["server_set_system"] == 1) {
	$items[] = array("basic", $LANG["sendbox_SolarSystem"]);
}
elseif ($user_auth["server_set_spy"] == 1) {
	$items[] = array("basic", $LANG["sendbox_SpyReport"]);
}

if ($user_auth["server_set_ranking"] == 1 || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
	$items[] = array("none", "");
	$items[] = array("none", $LANG["sendbox_PlayerRanking"]);
	$items[] = array("general_player",$LANG["sendbox_RankingGeneral"]);
	$items[] = array("fleet_player", $LANG["sendbox_RankingFleet"]);
	$items[] = array("research_player", $LANG["sendbox_RankingResearch"]);
	$items[] = array("none", "");
	$items[] = array("none", $LANG["sendbox_AllyRanking"]);
	$items[] = array("general_ally", $LANG["sendbox_RankingGeneral"]);
	$items[] = array("fleet_ally", $LANG["sendbox_RankingFleet"]);
	$items[] = array("research_ally", $LANG["sendbox_RankingResearch"]);
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
	var hour = date.getHours()+<?php echo $server_config['timeshift']; ?>;
	var min = date.getMinutes();
	var sec = date.getSeconds();
	var day = days[date.getDay()];
	var day_number = date.getDate();
	var month = months[date.getMonth()];
	if (sec < 10) sec = "0" + sec;
	if (min < 10) min = "0" + min;
	if (hour < 10) hour = "0" + hour;
	if (hour >= 24) day = days[date.getDay()+1];
	if (hour >= 24) hour = hour-24;
	if (hour < 0) day = days[date.getDay()-1];
	if (hour < 0) hour = hour+24;

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
	if (document.post.data.value == "<?php echo $LANG["sendbox_ExplainText"]; ?>") {
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
<br>
<br>
<table border="0" cellpadding="0" cellspacing="0" width="130px">
<tr align="center"><th><b><?php echo $LANG["server_Time"];?></b><br /><span id="datetime"><?php echo $LANG["Server_time2"];?></span></th></tr>
<tr>
	<td class="c" height="40">&nbsp;</td>
</tr>
<?php
if ($server_config["server_active"] == 0) {
	echo "<tr>";
	echo "\t"."<td><div align='center'><font color='red'><b><blink>".$LANG["server_Offline"]."</blink></b></font></div></td>";
	echo "</tr>";
}

if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) {
        $admin_menu_tooltip = addslashes(htmlentities($help["tooltip_menu_admin"]));
      	$menus[] = "<div align='center'><font color='#FFFFFF'>"."\n"."\t"."<a style='cursor:pointer' href='index.php?action=administration' onmouseover=\"this.T_WIDTH=210;this.T_STICKY=true;this.T_TEMP=0;return escape('".$admin_menu_tooltip."')\"; >Administration</a>"."\n"."\t"."</font></div>";
} else {
		$menus[]  = "";
}

		$menus[] = "<div align='center'><a href='index.php?action=profile'>".$LANG["menu_Profile"]."</a></div>";

		$perso_menu_tooltip = addslashes(htmlentities($help["tooltip_menu_perso"]));
		$menus[] = "<div align='center'>"."\n"."\t"."<a style='cursor:pointer' href='index.php?action=home' onmouseover=\"this.T_WIDTH=210;this.T_STICKY=true;this.T_TEMP=0;return escape('".$perso_menu_tooltip."')\";  >".$LANG["menu_Home"]."</a>"."\n"."\t"."</div>";

		$menus[] = "&nbsp;";
		$menus[] = "<div align='center'><a href='index.php?action=galaxy'>".$LANG["univers_Galaxy"]."</a></div>";
		$menus[] = "<div align='center'><a href='index.php?action=cartography'>".$LANG["menu_AllyTerritory"]."</a></div>";
		$menus[] = "<div align='center'><a href='index.php?action=search'>".$LANG["menu_Search"]."</a></div>";
		$menus[] = "<div align='center'><a href='index.php?action=ranking'>".$LANG["menu_Ranking"]."</a></div>";

		$menus[] = "&nbsp;";
		$menus[] = "&nbsp;";
		$menus[] = "<div align='center'><a href='index.php?action=statistic'>".$LANG["menu_Statistics"]."</a></div>";
		$menus[] = "<div align='center'><a href='index.php?action=galaxy_obsolete'>".$LANG['menu_ObsoletedData']."</a></div>";

		$menus[] = "&nbsp;";
		$menus[] = "<div align='center'><a href='index.php?action=logout'>".$LANG["menu_Logout"]."</a></div>";

		$menus[] = "&nbsp;";

if ($server_config["url_forum"] != "") {
		$menus[] = "<div align='center'><a href='".$server_config["url_forum"]."' target='_blank'>".$LANG["menu_Forum"]."</a></div>";
} else {
		$menus[] = "";
}
		$menus[] = "<div align='center'><a href='index.php?action=about'>".$LANG["menu_About"]."</a></div>";
		$menus[] = "&nbsp;";

		$mod_list = mod_list();
		
		for ($i = 0;$i<count($mod_list['actived']);$i++){
			if ($mod_list['actived'][$i]['menupos'] == "0"){
				if (user_as_perms($user_data['user_id'],$mod_list['actived'][$i]['id']) || $user_data['user_admin']==1){
					array_splice($menus, $mod_list['actived'][$i]['position'], 0, array("<div align='center'><a href='index.php?action=".$mod_list['actived'][$i]['root']."'>".$mod_list['actived'][$i]['title']."</a></div>"));
				} else {
					array_splice($menus, $mod_list['actived'][$i]['position'], 0, "");
				}
			}
		}

		foreach ($menus as $menu) {
		if (!empty($menu)){
			echo "<tr>";
			if ($menu != "&nbsp;") {
				echo "<th>".$menu."</th>";
			} else {
				echo "<td class='c' height='20'>".$menu."</td>";
			}
			echo "</tr>";
		}
		}
		?>
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
if (sizeof($items) > 0) echo $LANG["sendbox_ExplainText"];
else echo $LANG["sendbox_Forbidden"];
echo "</textarea></td>"."\n";
echo "</tr>"."\n";

if (sizeof($items) > 0) {
	echo "<tr>"."\n";
	echo "\t"."<td><div align='center'><input type='submit' value='Envoyer'></div></td>"."\n";
	echo "</tr>"."\n";
}
?>
</form>
</table>
