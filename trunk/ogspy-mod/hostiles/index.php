<?php
/**
* index.php Fichier principal
* @package hostiles
* @author Jedinight
* @link http://www.ogsteam.fr
* created : 23/02/2012
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");
//echo "<table width='100%'>";

//version
$result = $db->sql_query('SELECT `version` FROM `'.TABLE_MOD.'` WHERE `action`=\''.$pub_action.'\' AND `active`=\'1\' LIMIT 1');
if (!$db->sql_numrows($result)) die('Mod désactivé !');
$version = $db->sql_fetch_row($result);
$version = $version[0];

//menu
global $db, $table_prefix, $user_data;
//$trade = remove_htm($trade["content"]);
//definition de la table Convertisseur
define("TABLE_USER", $table_prefix."user");
define("TABLE_HOSTILES", $table_prefix."hostiles");
define("TABLE_HOSTILES_ATTACKS", $table_prefix."hostiles_attacks");
define("TABLE_HOSTILES_COMPOSITION", $table_prefix."hostiles_composition");

// Y'a t-il des infos de base de l'attaque
$query = "SELECT * FROM " . TABLE_HOSTILES;
$result = $db->sql_query($query);
$nbHostiles = mysql_num_rows($result);

if($nbHostiles==0){
	echo "<span style='text-align: left; font-size:18px; font-weight: bold; color:white;'>Aucune flotte hostile n'a été détectée au sein de la communauté !</span>";
} else {
	// Users id des attaques normales
	$query = "SELECT DISTINCT(user_id) "
			."FROM " . TABLE_HOSTILES_ATTACKS . " hosatt, " . TABLE_HOSTILES . " hos "
			."WHERE hos.id_attack = hosatt.id_attack AND id_vague='0' "
			."ORDER BY user_id ASC";
	$userIdsAttaquesNormales = $db->sql_query($query);

	// Traitement des attaques normales par user id
	while(list($user_id) = $db->sql_fetch_row($userIdsAttaquesNormales) ){
		// Attaques Simples du user_id
		$query = "SELECT arrival_time, hosatt.id_attack AS id_attack, hosatt.id_vague AS id_vague, attacker, origin_planet, origin_coords, cible_planet, cible_coords "
		."FROM " . TABLE_HOSTILES_ATTACKS . " hosatt, " . TABLE_HOSTILES . " hos"
		." WHERE hos.id_attack = hosatt.id_attack AND hosatt.id_vague='0' AND hos.user_id = '" . $user_id ."'"
		."ORDER BY arrival_time ASC";
		$result = $db->sql_query($query);
		
		$query = "SELECT  `user_name` FROM ". TABLE_USER ." WHERE `user_id`=".$user_id;
		$userNames=$db->sql_query($query);
		$userName="";
		while(list($name)=$db->sql_fetch_row($userNames)){
			$userName=$name;
		}
		
		echo "<table width='100%'>";
		echo "<tbody><tr>";
		echo "<td align='left' style='font-size:14px; font-weight: bold; color:yellow;'>Liste des attaques sur le joueur " . $userName . "</td>";
		echo "</tr>";
		echo "</tbody></table>";
		
		echo "<table width='100%'><thead>"
				."<th align='center' style='font-size:14px; font-weight: bold; color:orange;'>Attaquant</th>"
				."<th align='center' style='font-size:14px; font-weight: bold; color:orange;'>Provenance</th>"
				."<th align='center' style='font-size:14px; font-weight: bold; color:orange;'>Cible</th>"
				."<th align='center' style='font-size:14px; font-weight: bold; color:orange;'>Heure d'Impact</th>"
				."<th align='center' style='font-size:14px; font-weight: bold; color:orange;'>Composition de la Flotte</th>"
			."</thead><tbody>";
		
		while(list($arrival_time, $id_attack, $id_vague, $attacker, $origin_planet, $origin_coords, $cible_planet, $cible_coords) = $db->sql_fetch_row($result) ){
			
			echo "<tr>".
					"<th align='center'>" . $attacker . "</th>".
					"<th align='center'>" . $origin_planet . "(" . $origin_coords . ")</th>".
					"<th align='center'>" . $cible_planet . "(" . $cible_coords . ")</th>".
					"<th align='center'>" . $arrival_time . "</th>".
					"<th align='center'>";
					
					$query = "SELECT type_ship, nb_ship "
							."FROM " . TABLE_HOSTILES_ATTACKS . " hosatt, ". TABLE_HOSTILES_COMPOSITION . " hoscompo "
							."WHERE hosatt.id_attack = '".$id_attack."' AND hosatt.id_attack = hoscompo.id_attack";
					$result2 = $db->sql_query($query);
			
			// Composition de la flotte
			while( list($type_ship, $nb_ship) = $db->sql_fetch_row($result2) ){
				echo "<b>".$type_ship."</b> ".$nb_ship."<br/>";
			}
			echo "</th>";
		}
		echo "</tbody></table>";
	}
	
	// Users id des AG
	$query = "SELECT DISTINCT(user_id) "
			."FROM " . TABLE_HOSTILES_ATTACKS . " hosatt, " . TABLE_HOSTILES . " hos "
			."WHERE hos.id_attack = hosatt.id_attack AND id_vague!='0' "
			."ORDER BY user_id ASC, arrival_time ASC";
	$userIdsAG = $db->sql_query($query);
	
	while(list($user_id) = $db->sql_fetch_row($userIdsAG) ){
		$query = "SELECT  `user_name` FROM ". TABLE_USER ." WHERE `user_id`=".$user_id;
		$userNames=$db->sql_query($query);
		$userName="";
		while(list($name)=$db->sql_fetch_row($userNames)){
			$userName=$name;
		}
		
		echo "<table width='100%'>".
				"<tbody><tr>".
				"<td align='left' style='font-size:14px; font-weight: bold; color:yellow;'>Liste des AG sur le joueur " .$userName . "</td>".
				"</tr>".
			"</tbody></table>";
				
		echo "<table width='100%'>"
		."<colgroup>"
			."<col width='5%'/>"
			."<col width='15%'/>"
			."<col width='20%'/>"
			."<col width='20%'/>"
			."<col width='15%'/>"
			."<col/>"
		."</colgroup>"
				."<thead>"
					."<th align='center' style='font-size:14px; font-weight: bold; color:orange;'>Vague</th>"
					."<th align='center' style='font-size:14px; font-weight: bold; color:orange;'>Attaquant</th>"
					."<th align='center' style='font-size:14px; font-weight: bold; color:orange;'>Provenance</th>"
					."<th align='center' style='font-size:14px; font-weight: bold; color:orange;'>Cible</th>"
					."<th align='center' style='font-size:14px; font-weight: bold; color:orange;'>Heure d'Impact</th>"
					."<th align='center' style='font-size:14px; font-weight: bold; color:orange;'>Composition de la Flotte</th>"
				."</thead>"
			."<tbody>";
		
		// AG du user_id
		$query = "SELECT hosatt.id_attack AS id_attack, hosatt.id_vague AS id_vague, arrival_time "
				."FROM " . TABLE_HOSTILES_ATTACKS . " hosatt, " . TABLE_HOSTILES . " hos "
				."WHERE hos.id_attack = hosatt.id_attack AND hosatt.id_vague != '0' AND hos.user_id = '" . $user_id ."' "
				."ORDER BY hosatt.id_attack ASC, hosatt.id_vague ASC";
		$agsUser = $db->sql_query($query);
		
		while(list($id_attack, $id_vague, $arrival_time) = $db->sql_fetch_row($agsUser) ){		
			// AG du user_id
			$query2 = "SELECT attacker, origin_planet, origin_coords, cible_planet, cible_coords "
			."FROM " . TABLE_HOSTILES_ATTACKS . " "
			."WHERE id_attack = '" . $id_attack . "' AND id_vague = '". $id_vague ."' "
			."ORDER BY id_vague ASC";
			$agVague = $db->sql_query($query2);
			
			// Exploitation de la vague
			while(list($attacker, $origin_planet, $origin_coords, $cible_planet, $cible_coords) = $db->sql_fetch_row($agVague) ){	
				//printf("ID : %s  Nom : %s", $row["id"], $row["name"]);
				
				if($id_vague=='1'){
					echo "<tr>"
							."<th align='center' style='font-size:14px; font-weight: bold; color:yellow; border:2px solid green;' colspan='3'>Attaque " . $id_attack . "</th>"
							."<th align='center' style='font-size:14px; font-weight: bold; color:yellow; border:2px solid green;'>" . $cible_planet . "(" . $cible_coords . ")</th>"
							."<th align='left' style='font-size:14px; font-weight: bold; color:yellow; border:2px solid green;'>" . $arrival_time . "</th>"
							."<th align='left' style='font-size:14px; font-weight: bold; color:yellow; border:2px solid green;'>-</th>"
						."</tr>";
				}
										
				echo "<tr>".
						"<th align='center'>" . $id_vague . "</th>".
						"<th align='center'>" . $attacker . "</th>".
						"<th align='center'>" . $origin_planet . "(" . $origin_coords . ")</th>".
						"<th align='center' colspan='2'></th>".
						"<th align='center'>";
					
					$query = "SELECT type_ship, nb_ship "
					."FROM " . TABLE_HOSTILES_COMPOSITION . " "
					."WHERE id_attack = '".$id_attack."' AND id_vague = '" . $id_vague . "'";
					$result3 = $db->sql_query($query);
					
					while( list($type_ship, $nb_ship) = $db->sql_fetch_row($result3) ){
						echo "<b>" . $type_ship . "</b> " . number_format($nb_ship, 0, ',', ' ') . "<br/>";
					}
					echo "</th></tr>";
			}
		}
			echo "</tbody></table>";
	}
}
//echo "</table>";

echo "<table><p align=\"center\"><a href=\"\">Mod Hostiles</a> | Version ".$version." | Jedinight | 2012</p></table>";

//Insertion du bas de page d'OGSpy
require_once("views/page_tail.php");
?>
