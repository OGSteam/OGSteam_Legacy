<?php
/**
 * qms_users.php 

Procédures et Fonctions liées aux utilisateurs

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
function get_real_sender_id($position){		// Renvoi le vrai #id du joueur qui s'est fait espionné (dans le cas d'un sitting, c'est pas forcement le même qui est connecté)
	global $db;
	$query_limit = "SELECT  `user_id`  FROM `".TABLE_USER_BUILDING."` WHERE `coordinates` = '".$position."'";
	$result=$db->sql_query($query_limit);
	list($user_id)=$db->sql_fetch_row($result);
	return $user_id;
}
function IsUserAdmin(){						// Renvoi 1 si l'utilisateur est admin, coadmin ou manager
	global $user_data;
	if($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || $user_data["management_user"] == 1) return 1;
	else return 0;
}
function get_user_using(){					// Renvoi les pseudos des membres utilisant le module
	global $db; global $table_prefix,$lang;
	$query = "SELECT DISTINCT `sender_id` FROM ".TABLE_QMS;
 	$result=$db->sql_query($query);
	if($result=$db->sql_numrows($result)==0){
		$result=$lang['qms_aucun'];
	}else{
		$i=0;
 	 	while(list($id)=$db->sql_fetch_row($result)){
			$tab[$i]=$id;
			$i++;
		}
		$text="";
		foreach($tab as $index)	{
			$query = "SELECT  `user_name` FROM ".$table_prefix."user WHERE `user_id`=".$index;
		 	$result=$db->sql_query($query);
	 	 	while(list($name)=$db->sql_fetch_row($result)){
				if(!$text)
					$text=$name;
				else
					$text.=", $name";
			}
		}
		$result=$text.".";
	}
	return $result;
}
function get_user_data_from_coord($key,$value){										// Renvoi le nom de la planete d'un membre
	global $db;
	$query_limit = "SELECT  `$key`  FROM `".TABLE_USER_BUILDING."` WHERE `coordinates` = '$value' ";
	$result=$db->sql_query($query_limit);
	list($planet_name)=$db->sql_fetch_row($result);
	return $planet_name;
}
function get_user_name_by_id($id){													// Recupère le nom d'un membre de OGSpy en fonction de son ID
	global $db,$lang;
	if($id){
		$query_limit = "SELECT  `user_name`  FROM `".TABLE_USER."` WHERE `user_id` = ".$id;
		$result=$db->sql_query($query_limit);
		list($name)=$db->sql_fetch_row($result);
		if(!$name) $name=sprintf($lang['qms_analyse_id_supprime'],$id);
		return $name;
	}else
		return "-?-";
}
function get_user_id_by_name($name){												// Recupère le userid d'un membre de OGSpy en fonction de son nom
	global $db;
	if($name){
		$query_limit = "SELECT  `user_id`  FROM `".TABLE_USER."` WHERE `user_name` = '".$name."'";
		$result=$db->sql_query($query_limit);
		list($user_id)=$db->sql_fetch_row($result);
		if(!$user_id) $user_id=0;
		return $user_id;
	}else
		return 0;
}
function get_user_id($position){					// recupére le nom du joueur et l'alliance d'une certaine position
	global $db;	
	$coord=get_coord($position);
	$player = "?";	
	$ally = "";	
	if($coord[0]&&$coord[1]&&$coord[2]){
		$query_limit = "SELECT  `player` , `ally`  FROM `".TABLE_UNIVERSE."` WHERE `galaxy` = ".$coord[0]." and `system` = ".$coord[1]." and `row` = ".$coord[2];		
		$result=$db->sql_query($query_limit);
		if($db->sql_numrows($result)>0)
			list($player,$ally)=$db->sql_fetch_row($result);	
	}	
	return array($player,$ally);
}
?>