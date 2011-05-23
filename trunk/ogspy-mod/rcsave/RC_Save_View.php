<?php
/***************************************************************************
*	filename	: RC_Save_View.php
*	Author	: ben.12
*         Mod OGSpy: RC Save
***************************************************************************/
	if (!defined('IN_SPYOGAME')) {
		die("Hacking attempt");
	}

	if(isset($HTTP_SERVER_VARS)) $_SERVEUR = $HTTP_SERVER_VARS;
	
	if(empty($_SERVEUR)) $javascript = true;
	else $javascript = false;
	
	$sql = "SELECT rc_id, rc_comment, time, user_name FROM ".TABLE_RC_SAVE.", ".TABLE_USER." WHERE public='1' AND ".TABLE_RC_SAVE.".user_id=".TABLE_USER.".user_id ORDER BY time DESC LIMIT 50";
		
	$result = $db->sql_query($sql);
	
	echo "<br><br><center><table width='100%'><tr>";
	echo "<td class='c'>Auteur</td><td class='c'>Commentaire</td>";
	echo "<td class='c'>&nbsp;</td><td class='c'>date</td></tr>";
		
	while( list($rc_id, $comment, $time, $auteur) = $db->sql_fetch_row($result) )
	{		
		echo "<tr><th>$auteur</th>";
		echo "<th>".$comment."</th>";
		echo "<th><a href='mod/RC_save/datas/".$rc_id.".html' target='_blank'>Voir</a></th><th>".gmdate("d/m/Y H:i:s", $time)."</th></tr>";
	}

	echo "</table></center>";
?>