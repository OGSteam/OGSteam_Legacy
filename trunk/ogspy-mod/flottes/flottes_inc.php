<?php
/***************************************************************************
*   filename    : flottes_inc.php
*   desc.       : 1.06
*   Author      : Conrad des Dragons 
*   created     : 
*   modified    : AirBAT
*   last modif. : Added MyBB preview/convertion
***************************************************************************/

// def de qq variable
if(!defined("TABLE_MOD_FLOTTES"))  // Controle de doublon (deja défini dans flotte_lang)
	define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");
if(!defined("TABLE_MOD_FLOTTES_ADM"))  // Controle de doublon (deja défini dans flotte_lang)
	define("TABLE_MOD_FLOTTES_ADM", $table_prefix."mod_flottes_admin");

define("IN_MOD_FLOTTES", "ok");
$forbidden = true;

require_once("mod/flottes/flottes_lang.php");


$request= "SELECT color_fleet,color_fleet_old,color_fleet_user, color_fleet_point, color_fleet_alli,";
$request .="color_bbc_1, color_bbc_2, color_bbc_3, color_bbc_4, color_bbc_5, GAME, nbpla FROM ".TABLE_MOD_FLOTTES_ADM." WHERE group_name='mod_flottes'";
if($result = $db->sql_query($request)) {
	while($ligne = mysql_fetch_row($result)) {
		$CF = $ligne[0]; 	
		$CFO = $ligne[1]; 
		$CFU = $ligne[2];
		$CFP = $ligne[3]; 	
		$CFA = $ligne[4]; 
		$CB1 = $ligne[5];
		$CB2 = $ligne[6]; 	
		$CB3 = $ligne[7]; 
		$CB4 = $ligne[8];
		$CB5 = $ligne[9]; 	
		$GA=$ligne[10];
		$PLA=$ligne[11];
	}
}
else {
	$CF=$CFO=$CFU=$CFP=$CFA=$CB1=$CB2=$CB3=$CB4=$CB5='lime';
	$GA='OGAME';
	$PLA=$nb_planet;
}	

?>

<script language="JavaScript">
<?php
global $user_building;
$nb_planet = find_nb_planete_user();
$nb_moon = find_nb_moon_user();
$name = $coordinates = $fields = $temperature = $satellite = "";
for ($i=1 ; $i<=$nb_planet+$nb_moon ; $i++) {
	$name .= "'".$user_building[$i]["planet_name"]."', ";
	$coordinates .= "'".$user_building[$i]["coordinates"]."', ";
	$fields .= "'".$user_building[$i]["fields"]."', ";
	$temperature .= "'".$user_building[$i]["temperature"]."', ";
	$satellite .= "'".$user_building[$i]["Sat"]."', ";
}

echo "var name = new Array(".substr($name, 0, strlen($name)-2).");"."\n";
echo "var coordinates = new Array(".substr($coordinates, 0, strlen($coordinates)-2).");"."\n";
echo "var fields = new Array(".substr($fields, 0, strlen($fields)-2).");"."\n";
echo "var temperature = new Array(".substr($temperature, 0, strlen($temperature)-2).");"."\n";
echo "var satellite = new Array(".substr($satellite, 0, strlen($satellite)-2).");"."\n";
?>

var select_planet = false;

function autofill(planet_id, planet_selected) {
	document.getElementById('planet_name').style.visibility = 'visible';
	document.getElementById('planet_name').disabled = false;

	document.getElementById('coordinates').style.visibility = 'visible';
	document.getElementById('coordinates').disabled = false;

	document.getElementById('fields').style.visibility = 'visible';
	document.getElementById('fields').disabled = false;

	document.getElementById('temperature').style.visibility = 'visible';
	document.getElementById('temperature').disabled = false;

	document.getElementById('satellite').style.visibility = 'visible';
	document.getElementById('satellite').disabled = false;

	document.getElementById('planet_name').value = name[(planet_id-1)];
	document.getElementById('coordinates').value = coordinates[(planet_id-1)];
	document.getElementById('fields').value = fields[(planet_id-1)];
	document.getElementById('temperature').value = temperature[(planet_id-1)];
	document.getElementById('satellite').value = satellite[(planet_id-1)];

	var i = 1;
	var lign = 0;
	var id = 0;
	var lim = 40;
	if(planet_id > $nb_planet) {
		lim = 17;
		planet_id -= 9;
	}
	for(i = start; i <= start+nb_planete-1; i++) {
		for(lign = 1; lign <= lim; lign++) {
			id = lign*10+i;
			document.getElementById(id).style.color = 'lime';
		}
	}

	for(i = 1; i <= lim; i++) {
		id = i*10+planet_id;
		document.getElementById(id).style.color = 'yellow';
	}

	return(true);
}

function clear_box() 
{
    document.getElementById('ship').value = "";
    
}


function preview() {
	var str = document.flottes.flottes_conv.value;

		str = str.replace(/[[]/gi,"<");
		while (str.match("]")) {
			str = str.replace("]",">");
		}
		while (str.match("\n")) {
			str = str.replace("\n","<br>");
		}
		while (str.match("<br><")) {
			str = str.replace("<br><","<br>\n<");
		}
		while (str.match("</color>")) {
			str = str.replace("</color>","</font>");
		}
		while (str.match("<color")) {
			str = str.replace("<color","<font color");
		}
		while (str.match("<size=16>")) {
			str = str.replace("<size=16>","<span style=\"font-size: 16px;\"> ");
		}
		while (str.match("<size=14>")) {
			str = str.replace("<size=14>","<span style=\"font-size: 14px;\"> ");
		}
		while (str.match("<size=9>")) {
			str = str.replace("<size=9>","<span style=\"font-size: 9px;\"> ");
		}
        while (str.match("<size=x-large>")) {
            str = str.replace("<size=x-large>","<span style=\"font-size: 24px;\"> ");
        }
        while (str.match("<size=large>")) {
            str = str.replace("<size=large>","<span style=\"font-size: 18px;\"> ");
        }
        while (str.match("<size=small>")) {
            str = str.replace("<size=small>","<span style=\"font-size: 12px;\"> ");
        }
        while (str.match("<size=x-small>")) {
            str = str.replace("<size=x-small>","<span style=\"font-size: 10px;\"> ");
        }
		while (str.match("</size>")) {
			str = str.replace("</size>","</span>");
		}
		while (str.match("<center>")) {
			str = str.replace("<center>","<div style=\"text-align: center;\">");
		}
        while (str.match("<align=center>")) {
            str = str.replace("<align=center>","<div style=\"text-align: center;\">");
        }
		while (str.match("</center>")) {
			str = str.replace("</center>","</div>");
		}
        while (str.match("</align>")) {
            str = str.replace("</align>","</div>");
        }
		while (str.match("<url=")) {
			str = str.replace("<url=","<a href=");
		}
		while (str.match("</url>")) {
			str = str.replace("</url>","</a>");
		}
		while (str.match("quote>")) {
			str = str.replace("quote>","fieldset>");
		}
		str +="<br>"
		
	var obj = document.getElementById("preview");
	obj.innerHTML = str;

	document.getElementById("preview").style.visibility = "visible";
	document.getElementById("message").style.visibility = "visible";
}

function closeMessage() {
	document.getElementById("message").style.visibility = "hidden";
	document.getElementById("preview").style.visibility = "hidden";
	document.getElementById("montrerREtest").style.visibility = "hidden";
}
</script>

<?php
$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];
$user_technology = $user_empire["technology"];

//variable des vaiseaux
$vaisseaux[1]=$vaisseaux_lang[1];
$vaisseaux[2]=$vaisseaux_lang[2];
$vaisseaux[3]=$vaisseaux_lang[3];
$vaisseaux[4]=$vaisseaux_lang[4];
$vaisseaux[5]=$vaisseaux_lang[5];
$vaisseaux[6]=$vaisseaux_lang[6];
$vaisseaux[7]=$vaisseaux_lang[7];
$vaisseaux[8]=$vaisseaux_lang[8];
$vaisseaux[9]=$vaisseaux_lang[9];
$vaisseaux[10]=$vaisseaux_lang[10];
$vaisseaux[11]=$vaisseaux_lang[11];
$vaisseaux[12]=$vaisseaux_lang[12];
$vaisseaux[13]=$vaisseaux_lang[13];
$vaisseaux[14]=$vaisseaux_lang[14];


// insertion des fonctions flotte
//require_once("mod/flottes/function_flottes.php");

// Groupe toujours autorisé a voir:
$request="SELECT group_id, group_name from ".TABLE_GROUP." WHERE group_name like 'flottes_%'";
		$result = $db->sql_query($request);
		if (mysql_num_rows($result)!=0)	{
			$request="SELECT MIN(".TABLE_GROUP.".group_id) from ".TABLE_GROUP." INNER JOIN ".TABLE_USER_GROUP." on ".TABLE_GROUP.".";
			$request .="group_id=".TABLE_USER_GROUP.".group_id WHERE ".TABLE_GROUP.".group_name like 'flottes_%' AND ".TABLE_USER_GROUP.".";
			$request .="user_id =".$user_data['user_id'];
		}
		else {
			$request = "SELECT group_id FROM ".TABLE_GROUP." WHERE group_name='mod_flottes'";
		}
$result = $db->sql_query($request);

if(list($group_id) = $db->sql_fetch_row($result)) {
	$request = "SELECT group_name FROM ".TABLE_GROUP." WHERE group_id=".$group_id." ";
	$result = $db->sql_query($request);
	list($group_name) = $db->sql_fetch_row($result);
	if($user_data["user_admin"] != 1) {
		$request = "SELECT COUNT(*) FROM ".TABLE_USER_GROUP." WHERE group_id=".$group_id." AND user_id=".$user_data['user_id'];
		$result = $db->sql_query($request);
		list($row) = $db->sql_fetch_row($result);
		if($row != 0) $forbidden = false;
	}
}

// Recupère si j'autorise la difusion de mes données
$request = "SELECT MAX(activate) as activate FROM ".TABLE_MOD_FLOTTES." WHERE user_id=".$user_data['user_id'];
$result = $db->sql_query($request);
if(list($members_data) = $db->sql_fetch_row($result)) ;
else {
	$request = "INSERT INTO ".TABLE_MOD_FLOTTES." (user_id, activate,planet_id) VALUES (".$user_data['user_id'].", '1','1')" ;
	$db->sql_query($request);
	$members_data = '0';
}

//utilisateurs autorisés:
$request = "SELECT users_permits FROM ".TABLE_MOD_FLOTTES." WHERE user_id=".$user_data['user_id'];
$result = $db->sql_query($request);
list($users_permits) = $db->sql_fetch_row($result);
$ids = array();
if(!empty($users_permits)) $ids = explode("<|>", $users_permits);

//J'ai le droit de voir les users:
$request = "SELECT users_permits, user_id FROM ".TABLE_MOD_FLOTTES;
$result = $db->sql_query($request);
$ids_autorised = array();
while(list($users, $id) = $db->sql_fetch_row($result)) {
	if(!empty($users)) {
		if(in_array($user_data['user_id'], explode("<|>", $users)))
			$ids_autorised[] = $id;
	}
}

//Autorise la diffusion de ma flotte:
if(!isset($pub_add_ship) && isset($pub_permit) && !isset($pub_add) && !isset($pub_del) && $pub_permit=="change") {
	if(isset($pub_active) && $pub_active) {
		$request = "UPDATE ".TABLE_MOD_FLOTTES." SET activate='1' WHERE user_id=".$user_data['user_id'];
		$members_data = '1';
	}
	else {
		$request = "UPDATE ".TABLE_MOD_FLOTTES." SET activate='0' WHERE user_id=".$user_data['user_id'];
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
		$request = "UPDATE ".TABLE_MOD_FLOTTES." SET users_permits='".$users_permits."' WHERE user_id=".$user_data['user_id'];
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
		$request = "UPDATE ".TABLE_MOD_FLOTTES." SET users_permits='".$users_permits."' WHERE user_id=".$user_data['user_id'];
		$db->sql_query($request);
	}
}

// Enregistre les données sur la flotte:
if(isset($pub_add_ship) && !isset($pub_add) && !isset($pub_del) && isset($pub_ship)) {
	switch($pub_add_ship) {
		case "Nouvelle insertion":
			mod_flottes_get_ship($pub_ship);
		break;
		
		case "Supprimer cette flotte":
			mod_flottes_get_ship($pub_ship, true);
		break;
	}
}

?>