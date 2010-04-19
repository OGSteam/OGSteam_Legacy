<?php
/**
* empire.php 
* @package Empire
* @author ben.12
* @link http://www.ogsteam.fr
*/

/***************************************************************************
*	filename	: recherche_plus.php
*	Author	: ben.12
***************************************************************************/

/**************************************************************************
*	Ce mod gère les permission d'acces grace aux groupe d'ogpy.
*	Pour cela créé un groupe nomé "members_rank" et ajoutez y les utilisateur devants avoir acces a ce mod.
*	SI AUCUN GROUPE N'EST CREE, TOUS LES MEMBRES ONT ACCES.
***************************************************************************/
//secu
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='mod_empire' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");
// fin de secu

// def de qq variable
define("TABLE_MOD_EMPIRE", $table_prefix."mod_empire");
define("IN_MOD_EMPIRE", "ok");
$forbidden = true;

// insertion des fonctions flotte
require_once("mod/Empire/function_empire.php");
?>
<script>
function clear_box_mod_empire() {
	if (document.form.ship.value == "Je copie ici la partie \"Flottes\" d'Ogame.") {
		document.form.ship.value = "";
	}
}
</script>
<?php
// Groupe toujours autorisé a voir:
$request = "SELECT group_id FROM ".TABLE_GROUP." WHERE group_name='mod_empire'";
$result = $db->sql_query($request);

if(list($group_id) = $db->sql_fetch_row($result)) {
	if($user_data["user_admin"] != 1) {
		$request = "SELECT COUNT(*) FROM ".TABLE_USER_GROUP." WHERE group_id=".$group_id." AND user_id=".$user_data['user_id'];
		$result = $db->sql_query($request);
		list($row) = $db->sql_fetch_row($result);
		if($row != 0) $forbidden = false;
	}
}

// Recupère si j'autorise la difusion de mes données
$request = "SELECT activate FROM ".TABLE_MOD_EMPIRE." WHERE user_id=".$user_data['user_id'];
$result = $db->sql_query($request);
if(list($members_data) = $db->sql_fetch_row($result)) ;
else {
	$request = "INSERT INTO ".TABLE_MOD_EMPIRE." (user_id, activate) VALUES (".$user_data['user_id'].", '0')" ;
	$db->sql_query($request);
	$members_data = '0';
}

//utilisateurs autorisés:
$request = "SELECT users_permits FROM ".TABLE_MOD_EMPIRE." WHERE user_id=".$user_data['user_id'];
$result = $db->sql_query($request);
list($users_permits) = $db->sql_fetch_row($result);
$ids = array();
if(!empty($users_permits)) $ids = explode("<|>", $users_permits);

//J'ai le droit de voir les users:
$request = "SELECT users_permits, user_id FROM ".TABLE_MOD_EMPIRE;
$result = $db->sql_query($request);
$ids_autorised = array();
while(list($users, $id) = $db->sql_fetch_row($result)) {
	if(!empty($users)) {
		if(in_array($user_data['user_id'], explode("<|>", $users)))
			$ids_autorised[] = $id;
	}
}

//Autorise la diffusion de mon empire:
if(!isset($pub_add_ship) && isset($pub_permit) && !isset($pub_add) && !isset($pub_del) && $pub_permit=="change") {
	if(isset($pub_active) && $pub_active) {
		$request = "UPDATE ".TABLE_MOD_EMPIRE." SET activate='1' WHERE user_id=".$user_data['user_id'];
		$members_data = '1';
	}
	else {
		$request = "UPDATE ".TABLE_MOD_EMPIRE." SET activate='0' WHERE user_id=".$user_data['user_id'];
		$members_data = '0';
	}
	$db->sql_query($request);
}

// Ajouter un membre aux autorisations:
if(!isset($pub_add_ship) && !isset($pub_del) && isset($pub_add) && isset($pub_add_user) && check_var($pub_add_user, "Num") && $pub_add="Ajouter ce membre si-dessous") {
	if(!in_array($pub_add_user, $ids)) {
		if(!empty($users_permits)) $users_permits .= "<|>".$pub_add_user;
		else $users_permits = $pub_add_user;
		$ids[] = $pub_add_user;
		$request = "UPDATE ".TABLE_MOD_EMPIRE." SET users_permits='".$users_permits."' WHERE user_id=".$user_data['user_id'];
		$db->sql_query($request);
	}
}

// Supprimer un membre des autorisations:
if(!isset($pub_add_ship) && !isset($pub_add) && isset($pub_del) && isset($pub_del_user) && check_var($pub_del_user, "Num") && $pub_del="Supprimer ce membre de la liste") {
	if(in_array($pub_del_user, $ids)) {
		$users_permits = "";
		$i=0;
		foreach($ids as $id) {
			if($id != $pub_del_user) $users_permits .= $id."<|>";
			else unset($ids[$i]);
			$i++;
		}
		if(strlen($users_permits)>0) $users_permits = substr($users_permits, 0, strlen($users_permits)-3);
		$request = "UPDATE ".TABLE_MOD_EMPIRE." SET users_permits='".$users_permits."' WHERE user_id=".$user_data['user_id'];
		$db->sql_query($request);
	}
}

// Enregistre les données sur la flotte:
if(isset($pub_add_ship) && !isset($pub_add) && !isset($pub_del) && isset($pub_ship)) {
	switch($pub_add_ship) {
		case "Nouvelle insertion":
			mod_empire_get_ship($pub_ship);
		break;
		
		case "Ajouter à ceux déjà entrés":
			mod_empire_get_ship($pub_ship, true);
		break;
	}
}

require_once("views/page_header.php");
?>
<form action='index.php' method='POST' name='form'>
<input type='hidden' name='action' value='mod_empire' >
<input type='hidden' name='permit' value='change' >
<table width="90%">
	<tr>
		<td class='c' colspan='13'>Empire</td>
	<tr>
		<th colspan='7'><input type="checkbox" name="active" OnClick='this.form.submit();' <?php echo ($members_data=='1' ? 'checked' : ''); ?>>&nbsp;J'autorise les membres cités ci-dessous à voir mon empire.<br>Il n'ont en aucun cas la possibilité de changer quoi que ce soit.</th>
		<th colspan='6'><select name='add_user'>
		<?php
			$request = "SELECT user_id, user_name FROM ".TABLE_USER;
			$result = $db->sql_query($request);
			while(list($id, $name) = $db->sql_fetch_row($result)) {
				echo "<option value='".$id."'>".$name."</option>";
			}
		?></select>&nbsp; &nbsp;<input type='submit' name='add' value='Ajouter ce membre ci-dessous'></th>
	</tr>
	<tr>
	<th colspan='7'>Auront acces: <?php
		$request = "SELECT DISTINCT user_name FROM ".TABLE_USER
			." LEFT JOIN ".TABLE_USER_GROUP." ON ".TABLE_USER.".user_id = ".TABLE_USER_GROUP.".user_id"
			." WHERE user_admin='1' OR (group_id=".(!empty($group_id) ? $group_id : "'-1'")." AND ".TABLE_USER_GROUP.".user_id=".TABLE_USER.".user_id)"
			." OR ".TABLE_USER.".user_id=";
		foreach($ids as $id) {
			$request .= $id." or ".TABLE_USER.".user_id=";
		}
		$request = substr($request, 0, strlen($request)-13-strlen(TABLE_USER));
		$result = $db->sql_query($request);
		list($name) = $db->sql_fetch_row($result);
		echo $name;
		while(list($name) = $db->sql_fetch_row($result)) {
			echo " | ".$name;
		}
	?></th>
	<th colspan='6'><select name='del_user'>
		<?php
		if(count($ids)>0) {
			$request = "SELECT user_id, user_name FROM ".TABLE_USER." WHERE user_id=";
			foreach($ids as $id) {
				$request .= $id.' or user_id=';
			}
			$request = substr($request, 0, strlen($request)-12);
			$result = $db->sql_query($request);
			while(list($id, $name) = $db->sql_fetch_row($result)) {
				echo "<option value='".$id."'>".$name."</option>";
			}
		}
		?>
	</select>&nbsp; &nbsp;<input type='submit' name='del' value='Supprimer ce membre de la liste'></th>
	</tr>
	<tr>
	<th colspan='13'>
		<textarea name='ship' onFocus='clear_box_mod_empire()'>Je copie ici la partie "Flottes" d'Ogame.</textarea><br>
		<input type='submit' name='add_ship' value='Nouvelle insertion'>&nbsp; &nbsp;<input type='submit' name='add_ship' value='Ajouter à ceux déjà entrés'>
	</th>
	</tr>
	<tr><td colspan='13'>&nbsp;</td></tr>
	<tr>
	<?php
	$request = "SELECT";
	foreach($mod_empire_lang as $key => $value) {
		$request .= "`".$key."`, ";
		echo "<td class='c' width='8.33%'>".$key."</td>";
	}
	$request = substr($request, 0, strlen($request)-2);
	$request .= " FROM ".TABLE_MOD_EMPIRE." WHERE user_id=".$user_data['user_id'];
	$result = $db->sql_query($request);
	$lines = array();
	$lines = $db->sql_fetch_assoc($result);
	echo "</tr>\n<tr>";
	foreach($mod_empire_lang as $key => $value) {
		echo "\t"."<th><font color='lime'>".$lines[$key]."</font></th>";
	}
	?>
	</tr>
</table>
</form>

<?php
// je suis admin, ou dans le groupe "mod_empire" ou j'ai peut etre été autorisé a voir qq de particulier
if($user_data["user_admin"] == 1 || !$forbidden || !empty($ids_autorised)) {

if($user_data["user_admin"] == 1 || !$forbidden) $request = "SELECT ".TABLE_USER.".user_id, user_name FROM ".TABLE_MOD_EMPIRE." LEFT JOIN ".TABLE_USER." on ".TABLE_USER.".user_id=".TABLE_MOD_EMPIRE.".user_id WHERE ".TABLE_MOD_EMPIRE.".activate='1'";
else {
	$request = "SELECT ".TABLE_USER.".user_id, user_name FROM ".TABLE_MOD_EMPIRE." LEFT JOIN ".TABLE_USER." on ".TABLE_USER.".user_id=".TABLE_MOD_EMPIRE.".user_id WHERE ".TABLE_MOD_EMPIRE.".activate='1' AND (".TABLE_USER.".user_id=";
	foreach($ids_autorised as $id) {
		$request .= $id." OR ".TABLE_USER.".user_id=";
	}
	$request = substr($request, 0, strlen($request)-13-strlen(TABLE_USER));
	$request .= ")";
}
$result = $db->sql_query($request);

if(isset($pub_empire_user_id) && check_var($pub_empire_user_id, "Special", "#^[[:digit:]\-]+$#")) $empire_user_id = $pub_empire_user_id;
else $empire_user_id = -1; 
?>

<table>
<tr>
	<td>
	<form action='index.php' method='POST' name='form2'>
	<input type='hidden' name='action' value='mod_empire' >
		<select name="empire_user_id">
	<?php
	// $ok verifit si j'ai pas essayé de tricher:
		$ok = false;
		while(list($user_id, $user_name)= $db->sql_fetch_row($result)) {
			if(empty($user_id) && empty($user_name)) continue;
			echo "<option value='".$user_id."' ".($empire_user_id == $user_id ? "selected" : "").">".$user_name."</option>";
			if($empire_user_id == $user_id) $ok = true;
		}
	?>
		</select>
		&nbsp; &nbsp;<input type='submit' value='Voir'>
	</form>
	</td>
</tr>
</table>

<table width="100%">
<tr>
	<td>
		<table>
		<tr align="center">
<?php
if (!isset($pub_subaction)) $pub_subaction = "empire";

if ($pub_subaction != "empire") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=mod_empire&subaction=empire&empire_user_id=".$empire_user_id."';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Empire</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Empire</a>";
	echo "</th>";
}

if ($pub_subaction != "simulation") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=mod_empire&subaction=simulation&empire_user_id=".$empire_user_id."';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Simulation</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Simulation</a>";
	echo "</th>";
}

if ($pub_subaction != "stat") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=mod_empire&subaction=stat&empire_user_id=".$empire_user_id."';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Statistiques</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Statistiques</a>";
	echo "</th>";
}
?>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
<?php
// verif des droits:
if(check_var($empire_user_id, "Special", "#^[[:digit:]\-]+$#") && $empire_user_id != -1 && $empire_user_id != '' && $ok) {

// saugarde et changement de user_data['user_id'] (je vois pas comment faire autrement car get_empire l'utilise)
$user_id = $user_data["user_id"];
$user_data["user_id"] = $empire_user_id;
	
	
	switch ($pub_subaction) {
		case "empire" :
		require_once("mod/Empire/home_empire.php");
		break;

		case "simulation" :
		require_once("mod/Empire/home_simulation.php");
		break;

		case "stat" :
		require_once("mod/Empire/home_stat.php");
		break;

		default:
		require_once("mod/Empire/home_empire.php");
		break;
	}

// restitution de l'id:
$user_data["user_id"] = $user_id;
}
?>
	</td>
</tr>
</table>

<?php
}

require_once("views/page_tail.php");
?>
