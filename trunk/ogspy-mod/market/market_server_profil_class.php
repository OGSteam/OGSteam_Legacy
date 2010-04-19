<?php
/** market_server_profil_class.php Definition de la classe de profil de connection utilisateur du Mod Market
* @package MOD_Market
* @author Jey2k <jey2k.ogsteam@gmail.com>
* @version 1.0
*/
class cMarketServerProfile {
	var $user_id;
	var $server_id;
	var $password;
	var $last_check;
	function cMarketServerProfile($p_user_id,$p_server_id)
	{
		global $db;
		$this->user_id=$p_user_id;
		$this->server_id=$p_server_id;
		$query= "SELECT password,last_check FROM `".TABLE_MARKET_USER_SERVER_PROFILE."` WHERE user_id='".intval($p_user_id)."' and server_id='".intval($p_server_id)."'";
		$result=$db->sql_query($query);
		if (!(list($l_password,$l_last_check)=$db->sql_fetch_row())) {
			$this->password="";
			$this->last_check="";
			$this->saveProfile();
		} else {
			$this->password=$l_password;
			$this->last_check=$l_last_check;
		}
		
	}
	function marketServerProfileExists($user_id,$server_id)
	{
		global $db;
		$query= "SELECT user_id,server_id,password,last_check FROM `".TABLE_MARKET_USER_SERVER_PROFILE."` WHERE user_id='".intval($user_id)."' and server_id='".intval($server_id)."'";
		if (!$db->sql_numrows($db->sql_query($query))) return false;
		return true;
	}
	
	/* Fonction saveProfile
	 * Sauvegarde en db l'instance actuelle
	 * @author Jey2k
	 * @return true
	*/
	function saveProfile() {
		global $db;
		$query= "UPDATE `".TABLE_MARKET_USER_SERVER_PROFILE."` set user_id='".$this->user_id."',server_id='".$this->server_id."',password='".$this->password."',last_check='".$this->last_check."';";
		$db->sql_query($query);
		if ($db->sql_affectedrows()==0) {
			$query= "INSERT INTO `".TABLE_MARKET_USER_SERVER_PROFILE."`(user_id,server_id,password,last_check) VALUES('".$this->user_id."','".$this->server_id."','".$this->password."','".$this->last_check."');";
			$db->sql_query($query);
		};
		return true;
	}
	
	
	
	
}
?>