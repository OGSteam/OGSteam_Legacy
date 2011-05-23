<?php
/***************************************************************************
*	Filename	: update.php
*	desc.		: Script de mise à jour SQL du module "Présentation Alliance"
*	Authors	: Lose - http://ogs.servebbs.net/; Edité par Sylar - sylar@ogsteam.fr
*	created	: 30/11/2007
*	modified	: 18/05/2011	version	: 1.0
***************************************************************************/
/***************************************************************************
* function update($pub_id)
*		Met à jour les données de l'images n°$pub_id
*
* function add_pic($name,$tag_alliance,$fond,$sortie)
*		Créé une nouvelle image avec les données fournies
*
* function add_data($id,$name,$type)
*		Ajoute une nouvelle donnée $name de type $type à l'image n°$id
*
* function delete_pic($id)
*		Efface l'image n°$id
*
* function delete_data($id,$data)
*		Efface la donnée $data de l'image n°$id
*
* function get_user_name_by_id($id)
*		Renvoi le nom d'un joueur en fonction de son ID
***************************************************************************/
if (!defined('IN_SPYOGAME')) 	die("Hacking attempt");
/**************************************************************************/
function update($pub_id)
{
	// Met à jour la base SQL à partir des données de la page édition
	global $db,$pub_background,$pub_lien_sortie,$pub_tag_alliance,$user_data;
	$data = get_pic_data($pub_id);
	$query = "UPDATE ".TABLE_P_ALLY_PIC." SET ";
	$query .= "background='".$pub_background."',output='".$pub_lien_sortie."',tag_alliance='".$pub_tag_alliance."' WHERE id = '".$pub_id."' ";
	$db->sql_query($query);
	debug_log("UPDATE: ".$query);
	foreach($data as $line)
	{
		$i=$line['id'];
		global ${'pub_text_'.$i},${'pub_x_'.$i},${'pub_y_'.$i},${'pub_actif_'.$i},${'pub_angle_'.$i},${'pub_font_'.$i},${'pub_taille_'.$i},${'pub_color_'.$i};
		$query = "UPDATE ".TABLE_P_ALLY_DATA." SET ";
		$query .= "text = '".utf8_encode(${'pub_text_'.$i})."', pos_x = '".${'pub_x_'.$i}."', pos_y='".${'pub_y_'.$i}."', actif='".(isset(${'pub_actif_'.$i})?"1":"0")."', ";
		$query .="pos_ang ='".${'pub_angle_'.$i}."',font_name='".${'pub_font_'.$i}."',font_size='".${'pub_taille_'.$i}."',font_color='".${'pub_color_'.$i}."' ";
		$query .= "WHERE id = '".$i."' AND id_pic = '".$pub_id."' ";
		$db->sql_query($query);
	}
}
/**************************************************************************/
function add_pic($name,$tag_alliance,$fond,$sortie2)
{
	// Ajoute une image à partir des données de la page d'accueil
	global $db,$user_data;
	$query = "INSERT INTO `".TABLE_P_ALLY_PIC."` (`name`,`tag_alliance`,`background`,`output`,`user_id`) ";
	$query .= "VALUES ('$name','$tag_alliance','$fond','$sortie','".$user_data['user_id']."');";
	$db->sql_query($query);
	debug_log("ADDPIC: ".$query);
	$id = $db->sql_insertid();
	$query = "INSERT INTO `".TABLE_P_ALLY_DATA."` (`id_pic`,`type`,`nom_champ`,`text`,`pos_x`,`pos_y`,`pos_ang`,`font_name`,`font_size`,`font_color`,`actif`) ";
	$query .= "VALUES ";
	$query .= "( $id, 'stat', 'general', '{rank} ème', 20, 520, 0, 'verdanab.ttf', 10, 'F76541',1 ), ";
	$query .= "( $id, 'stat', 'fleet', '{rank} ème', 20, 530, 0, 'verdanab.ttf', 10, 'F76541',1 ), ";
	$query .= "( $id, 'stat', 'research', '{rank} ème', 20, 540, 0, 'verdanab.ttf', 10, 'F76541',1 ); ";
	$db->sql_query($query);
	return $id;
}
/**************************************************************************/
function add_data($id,$name,$type)
{
	// Ajoute une champ à l'image $id
	global $db,$police;
	$query = "INSERT INTO `".TABLE_P_ALLY_DATA."` (`id_pic`,`type`,`nom_champ`,`text`,`pos_x`,`pos_y`,`pos_ang`,`font_name`,`font_size`,`font_color`,`actif`) ";
	$query .= "VALUES ";
	$query .= "( $id, '$type', '$name', '".($type=='image'?"":$name)."', 1, 1, 0, '".$police[0]."', 10, 'FFFFFF',1 ); ";
	$db->sql_query($query);
	debug_log("ADD DATA: ".$query);
}
/**************************************************************************/
function delete_pic($id)
{
	// Effacer une image
	global $db;
	$query = "DELETE FROM ".TABLE_P_ALLY_PIC." WHERE id='$id'";
	$db->sql_query($query) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());
	debug_log("DELETE: ".$query);
	$query = "DELETE FROM ".TABLE_P_ALLY_DATA." WHERE id_pic='$id'";
	$db->sql_query($query);
	debug_log("DELETE: ".$query);
}
/**************************************************************************/
function delete_data($id,$data)
{
	// Effacer un champ
	global $db;
	$query = "DELETE FROM ".TABLE_P_ALLY_DATA." WHERE id_pic='$id' AND id='$data'";
	$db->sql_query($query);
	debug_log("DELETE: ".$query);
}
/**************************************************************************/
function get_user_name_by_id($id)
{
	// Trouver le nom du membre n°$id
	global $db;
	if($id!=0){
		$query_limit = "SELECT  `user_name`  FROM `".TABLE_USER."` WHERE `user_id` = ".$id;
		$result=$db->sql_query($query_limit);
		list($name)=$db->sql_fetch_row($result);
		if(!$name) $name="<i>ID#$id Supprimé</i>";
		return $name;
	}else
		return "<i>Aucun</i>";
}
/**************************************************************************/
?>