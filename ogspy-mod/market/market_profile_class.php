<?php
/** market_profile_class.php Classe cProfilMarket
* @package MOD_Market
* @author Jey2k <jey2k.ogsteam@gmail.com>
* @version 1.0
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Classe gérant les différents trades
class cProfilMarket {
	var $user_id;
	var $email;
	var $msn;
	var $pm_link;
	var $irc_nick;
	var $note;
	function cProfilMarket($user_id){
		global $db;
		$query="SELECT user_id,email,msn,pm_link,irc_nick,note from ".TABLE_MARKET_PROFIL." where user_id='".$user_id."' limit 1;";
		$result = $db->sql_query($query);
		if ($db->sql_numrows($result)>0) {
			$profile = $db->sql_fetch_assoc($result);
			$this->user_id=$profile["user_id"];
			$this->email=$profile["email"];
			$this->msn=$profile["msn"];
			$this->pm_link=$profile["pm_link"];
			$this->irc_nick=$profile["irc_nick"];
			$this->note=$profile["note"];
		} else {
			$this->user_id=$user_id;
			$this->email="";
			$this->msn="";
			$this->pm_link="";
			$this->irc_nick="";
			$this->note="";
		}
	}
	function refreshProfile(){
		global $db;
		$query="SELECT email,msn,pm_link,irc_nick,note from ".TABLE_MARKET_PROFIL." where user_id='".$this->user_id."' limit 1;";
		$result = $db->sql_query($query);
		$profile = $db->sql_fetch_assoc($result);
		$this->email=$profile["email"];
		$this->msn=$profile["msn"];
		$this->pm_link=$profile["pm_link"];
		$this->irc_nick=$profile["irc_nick"];
		$this->note=$profile["note"];
	}
	function checkProfilExists($user_id){
		global $db;
		$query="SELECT user_id from ".TABLE_MARKET_PROFIL." where user_id='".$user_id."' limit 1;";
//echo "<br>Vérif:".$query;
		$result = $db->sql_query($query);
		if ($db->sql_numrows($result)>0) {
			return true;
		}
		return false;
	}
	function updateProfil($email,$msn,$pm_link,$irc_nick,$note){
		global $db;
		if (cProfilMArket::checkProfilExists($this->user_id)){
			//echo "Le profile existe déjà, on met à jour";
			$query = "UPDATE ".TABLE_MARKET_PROFIL." set email='".$email."',msn='".$msn."',pm_link='".$pm_link."',irc_nick='".$irc_nick."',note='".$note."' where user_id='".$this->user_id."' limit 1;";
		} else {
			//echo "Le profile n existe pas, on insère";
			$query = "INSERT INTO ".TABLE_MARKET_PROFIL."(user_id,email,msn,pm_link,irc_nick,note) values ('".$this->user_id."','".$email."','".$msn."','".$pm_link."','".$irc_nick."','".$note."')";
		}
//echo "<br>".$query;
		$db->sql_query($query);
		$this->refreshProfile();
		return true;
	}
	
		
	
}
$ProfilMarket=new cProfilMarket($user_data["user_id"]);
	
?>