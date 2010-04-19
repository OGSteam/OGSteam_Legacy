<?php
/***************************************************************************
*	filename	: setprofile.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 17/12/2005
*	modified	: 28/12/2005 23:56:40
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");

if (isset($user_data)){

if (!empty($user_data["id"])){

	$sql="UPDATE ".TABLE_USER." SET "
	   ." email='".mysql_escape_string($ogs_email)."' ,"
	   ." pm_link='".mysql_escape_string($ogs_pm_link)."' ,"
	   ." msn='".mysql_escape_string($ogs_email_msn)."' ,"
	   ." irc_nick='".mysql_escape_string($ogs_irc_nick)."', "
	   ." note='".mysql_escape_string($ogs_note)."' "
	   ." WHERE id=".$user_data["id"];
	$db->sql_query($sql);
	echo "Mise à jour de votre profil.";
}

}else{
echo "Impossible de mettre à jour le profile. Contactez l'administrateur";
}

require_once("views/page_tail.php");
	redirection("index.php?action=editprofile");
?>
