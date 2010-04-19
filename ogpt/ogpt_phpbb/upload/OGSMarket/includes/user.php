<?php
/***************************************************************************
*	filename	: 	user.php
*	desc.		:
*	Author		:	ericalens 
*	created		:	mardi 6 juin 2006, 06:35:28 (UTC+0200)
*	modified	:	vendredi 9 juin 2006, 23:26:39 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}


//Gestion des utilisateurs
class cUsers{
	function get_user($user_id) {
		global $db;
		if (empty($user_id) || intval($user_id)!=$user_id) return false;
		$sql = "SELECT * FROM ".TABLE_USER." WHERE id=$user_id limit 1";
		$db->sql_query($sql);
		return $db->sql_fetch_assoc();	
	}

	function UpdateLastVisit(){

		global $db,$user_data;
		if (empty($_SESSION["username"])) return false;

		$sql="UPDATE ".TABLE_USER." SET lastvisit='".time()."' WHERE id=".$user_data["id"];
		$db->sql_query($sql);
		return true;
	}

	function OnlineUsers($last_seen_seconds=60){
		global $db;

		$sql="SELECT id,name FROM ".TABLE_USER." WHERE lastvisit>".(time()-$last_seen_seconds);
		$db->sql_query($sql);
		$retval=Array();
		while ($data=$db->sql_fetch_assoc()) {$retval[]=$data; }
		return $retval;

	}

	function AnonymousUsers($last_seen_seconds=300){
		global $db;

		$sql="SELECT count(*) FROM ".TABLE_SESSIONS." WHERE last_connect>".(time()-$last_seen_seconds);
		$db->sql_query($sql);
		list($count)=$db->sql_fetch_row();
		return $count;

	}
	
	function newaccount($password, $login, $repassword, $email, $email_msn, $pm_link, $irc_nick, $note){


		global $db;
		
		$sql="SELECT value FROM ".TABLE_CONFIG." WHERE name='users_active'";
		$result = $db->sql_query($sql);
		list($active) = $db->sql_fetch_row($result);
		
		//manque des info là!
		if($password=="" || $login=="") return "Il manque des informations !";
		
		//ah non, mot de passe trop court.
		if(strlen($password) < 6) return "Mot de passe inférieur à 6 caractères";
		
		//erreur mot de passe.
		if($password != $repassword) return "erreur mot de passe";

		$sql="SELECT COUNT(*) FROM ".TABLE_USER." WHERE name like '".mysql_real_escape_string($login)."' OR (email like '".mysql_real_escape_string($email)."' AND email != '')";
		$db->sql_query($sql);
		// L'utilisateur existe.
		list($nb)=$db->sql_fetch_row();
		if ($nb != 0) return "Nom ou email d'utilisateur déjà utilisé";
		
		//enregistrement.
		$sql="INSERT INTO ".TABLE_USER." (name, password, regdate, email, msn, pm_link, irc_nick, note, is_active) VALUES ('".mysql_real_escape_string($login)."', '".md5($password)."', ".time().", '".mysql_real_escape_string($email)."', '".mysql_real_escape_string($email_msn)."', '".mysql_real_escape_string($pm_link)."', '".mysql_real_escape_string($irc_nick)."', '".mysql_real_escape_string($note)."', '".$active."')";
		$return = $db->sql_query($sql);
		if(!$return) return "erreur fatale durant l'inscription";
		return true;
	}

	function delete_account($user_id) {
		global $db;
		$sql = "DELETE FROM ".TABLE_USER." WHERE id=".intval($user_id)." LIMIT 1";
		$db->sql_query($sql);

		return "Le membre a bien été delleté";
	}

	function unset_active($user_id) {
		if (!empty($user_id )){
		global $db;
		$sql="UPDATE ".TABLE_USER." SET "." is_active='0' "
		   ." WHERE id=".$user_id;
		$db->sql_query($sql);
		return "Le membre a bien été Désactivé";}
}

	function set_active($user_id) {
		if (!empty($user_id)){
		global $db;
		$sql="UPDATE ".TABLE_USER." SET "." is_active='1' "
		   ." WHERE id=".$user_id;
		$db->sql_query($sql);
		return "Le membre a bien été Activé";}
}
	function unset_admin($user_id) {
		if (!empty($user_id )){
		global $db;
		$sql="UPDATE ".TABLE_USER." SET "." is_admin='0' "
		   ." WHERE id=".$user_id;
		$db->sql_query($sql);
		return "Le membre a perdu son status d'admin";}
}

	function set_admin($user_id) {
		if (!empty($user_id)){
		global $db;
		$sql="UPDATE ".TABLE_USER." SET "." is_admin='1' "
		   ." WHERE id=".$user_id;
		$db->sql_query($sql);
		return "Le membre a bien été nomé admin";}
}

	function unset_moderator($user_id) {
		if (!empty($user_id )){
		global $db;
		$sql="UPDATE ".TABLE_USER." SET "." is_moderator='0' "
		   ." WHERE id=".$user_id;
		$db->sql_query($sql);
		return "Le membre a perdu son status de modérateur";}
}

	function set_moderator($user_id) {
		if (!empty($user_id)){
		global $db;
		$sql="UPDATE ".TABLE_USER." SET "." is_moderator='1' "
		   ." WHERE id=".$user_id;
		$db->sql_query($sql);
		return "Le membre a bien été nomé modérateur";}
}

	
	function login($form_username,$form_userpass){
		global $db;
		global $server_config;
		switch ($server_config["users_auth_type"]){
			//Utilisation du listing interne d'utilisateurs
			case "internal":
				$sql="SELECT id,is_active FROM ".TABLE_USER." WHERE name like '".mysql_real_escape_string($form_username)."'";
				$db->sql_query($sql);
				// L'utilisateur existe pas
				if (!(list($id,$is_active)=$db->sql_fetch_row())) return false;
				if ($is_active==1){
					$sql="SELECT * FROM ".TABLE_USER." WHERE id=$id";	
					$db->sql_query($sql);
					$user=$db->sql_fetch_assoc();
					if ($user["password"]!=md5($form_userpass)) return false;
				}
				break;

			//Connection à partir de la liste utilisateurs de punbb	
			case "punbb":
				$db_connect_id = @mysql_connect($server_config["users_adr_auth_db"], $server_config["users_auth_dbuser"], $server_config["users_auth_dbpasswor"]);
				if (!$db_connect_id) die("Unable to connect to database. Contact Administrator");
				if (!@mysql_select_db($server_config["users_auth_db"])){
					@mysql_close($db_connect_id);
					die("Unable to select database. Contact Administrator");	
				}
				$sql="SELECT password FROM ".$server_config["users_auth_table"]." WHERE username='".mysql_real_escape_string($form_username)."'";
				$result=@mysql_query($sql,$db_connect_id) or die(mysql_error());
				list($db_password_hash)=@mysql_fetch_row($result);
				/*if ($server_config["users_adr_auth_db"] != $sqlserver)
					{
						@mysql_close($db_connect_id);
					}*/

				$sha1_in_db = (strlen($db_password_hash) == 40) ? true : false;
				$sha1_available = (function_exists('sha1') || function_exists('mhash')) ? true : false;

				$form_password_hash = pun_hash($form_userpass);	// This could result in either an SHA-1 or an MD5 hash (depends on $sha1_available)
				$autorized=false;
				if ($sha1_in_db && $sha1_available && $db_password_hash == $form_password_hash)
					$authorized = true;
				else if (!$sha1_in_db && $db_password_hash == md5($form_userpass))
				{
					$authorized = true;
				}
				if (!$authorized) return false;


				$sql="SELECT id FROM ".TABLE_USER." WHERE name like '".mysql_escape_string($form_username)."'";
				$db->sql_query($sql);
				
				if (!(list($id)=$db->sql_fetch_row())){
					//l'utilisateur n'est pas dans la base OGSMarket , on l'ajoute

					$sql="INSERT INTO ".TABLE_USER." (name,regdate,lastvisit)"
					    ."VALUES('".mysql_escape_string($form_username)."',"
					           ."'".time()."','".time()."')";
					$db->sql_query($sql);
					$id=$db->sql_insertid();
						   
				}

				$sql="SELECT * FROM ".TABLE_USER." WHERE id=$id";	
				$db->sql_query($sql);
				$user=$db->sql_fetch_assoc();

				break;
			//Connection à partir de la liste utilisateurs de SMF Forum
			case "smf":
				$db_connect_id = @mysql_connect($server_config["users_adr_auth_db"], $server_config["users_auth_dbuser"], $server_config["users_auth_dbpasswor"]);
				if (!$db_connect_id) die("Unable to connect to database. Contact Administrator");
				if (!@mysql_select_db($server_config["users_auth_db"])){
					@mysql_close($db_connect_id);
					die("Unable to select database. Contact Administrator");	
				}
				$sql="SELECT passwd FROM ".$server_config["users_auth_table"]." WHERE memberName='".mysql_real_escape_string($form_username)."'";
				$result=@mysql_query($sql,$db_connect_id) or die(mysql_error());
				list($db_password_hash)=@mysql_fetch_row($result);
				/*if ($server_config["users_adr_auth_db"] != $sqlserver)
					{
						@mysql_close($db_connect_id);
					}*/

				$sha1_in_db = (strlen($db_password_hash) == 40) ? true : false;
				$sha1_available = (function_exists('sha1') || function_exists('mhash')) ? true : false;

				$form_password_hash = pun_hash($form_username.$form_userpass);	// This could result in either an SHA-1 or an MD5 hash (depends on $sha1_available)
				$autorized=false;
				if ($sha1_in_db && $sha1_available && $db_password_hash == $form_password_hash)
					$authorized = true;
				else if (!$sha1_in_db && $db_password_hash == md5($form_userpass))
				{
					$authorized = true;
				}
				if (!$authorized) return false;


				$sql="SELECT id FROM ".TABLE_USER." WHERE name like '".mysql_escape_string($form_username)."'";
				$db->sql_query($sql);
				
				if (!(list($id)=$db->sql_fetch_row())){
					//l'utilisateur n'est pas dans la base OGSMarket , on l'ajoute

					$sql="INSERT INTO ".TABLE_USER." (name,regdate,lastvisit)"
					    ."VALUES('".mysql_escape_string($form_username)."',"
					           ."'".time()."','".time()."')";
					$db->sql_query($sql);
					$id=$db->sql_insertid();
						   
				}

				$sql="SELECT * FROM ".TABLE_USER." WHERE id=$id";	
				$db->sql_query($sql);
				$user=$db->sql_fetch_assoc();

				break;
				
				//CONNECTION PHPBB2 by ChRom
			case "phpbb2":
				$db_connect_id = @mysql_connect($server_config["users_adr_auth_db"], $server_config["users_auth_dbuser"], $server_config["users_auth_dbpasswor"]);
				if (!$db_connect_id) die("Unable to connect to database. Contact Administrator");
				if (!@mysql_select_db($server_config["users_auth_db"])){
					@mysql_close($db_connect_id);
					die("Unable to select database. Contact Administrator");	
				}
				$sql="SELECT user_password FROM ".$server_config["users_auth_table"]." WHERE username='".mysql_real_escape_string($form_username)."'";
				$result=@mysql_query($sql,$db_connect_id) or die(mysql_error());
				list($db_password_hash)=@mysql_fetch_row($result);
				/*if ($server_config["users_adr_auth_db"] != $sqlserver)
					{
						@mysql_close($db_connect_id);
					}	*/
					
					echo $sqlserver;
				
				if ($db_password_hash != md5($form_userpass)) return false;

				$sql="SELECT id FROM ".TABLE_USER." WHERE name like '".mysql_escape_string($form_username)."'";
				$db->sql_query($sql);
				
				if (!(list($id)=$db->sql_fetch_row())){
					//l'utilisateur n'est pas dans la base OGSMarket , on l'ajoute

					$sql="INSERT INTO ".TABLE_USER." (name,regdate,lastvisit)"
					    ."VALUES('".mysql_escape_string($form_username)."',"."'".time()."','".time()."')";
					$db->sql_query($sql);
					$id=$db->sql_insertid();
						   
				}

				$sql="SELECT * FROM ".TABLE_USER." WHERE id=$id";	
				$db->sql_query($sql);
				$user=$db->sql_fetch_assoc();
				
			break;
				
			default:
				return false;
		}
		$_SESSION["username"]=$form_username;
		$_SESSION["userpass"]=$form_userpass;
		global $user_data;
		$user_data=$user;
		return $user_data;
	}
	function profile_html($userid){
		global $db;
		$user=$this->get_user($userid);
		if(!$user)return "<div>Profil non trouvé</div>";

	}

}

function pun_hash($str)
{
	if (function_exists('sha1'))	// Only in PHP 4.3.0+
		return sha1($str);
	else if (function_exists('mhash'))	// Only if Mhash library is loaded
		return bin2hex(mhash(MHASH_SHA1, $str));
	else
		return md5($str);
}
$Users=new cUsers();

?>
