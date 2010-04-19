<?php
	//on récupère les donnés
	global $db;

	define("TABLE_FEDERATION_COMMERCIAL", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial");
	define("TABLE_FEDERATION_COMMERCIAL_VENTE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial_vente");
	define("TABLE_FEDERATION_COMMERCIAL_PARTICIPANTS", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial_participants");
	
	$query = 'SELECT id, date FROM '.TABLE_FEDERATION_COMMERCIAL_VENTE.' ORDER BY date';
	$result = $db->sql_query($query);
	if (!$db->sql_numrows($result)) die('Hacking attempt');
	//on ordone tout ça dans un tableau
	echo'<table>';
	echo'<tr>';
	echo'<th>';
	echo 'date';
	echo'</th>';
	echo'<th>';
	echo'heure';
	echo'</th>';
	echo'</tr>';
	while(list($id,$date) = $db->sql_fetch_row($result)){
	echo'<form action="index.php" method="post">';
	echo'<input type="hidden" name="id" value="'.$id.'">';
	echo'<input type="hidden" name="action" value="federation_commerciale">';
	echo'<input type="hidden" name="page" value="sauvegarde_voir">';
	echo'<tr>';
	echo'<th>';
	echo date('d/m/Y', $date);
	echo'</th>';
	echo'<th>';
	echo date('H\h i\m\i\n', $date);
	echo'</th>';
	echo'<th>';
	echo'<input align="center" type="submit" value="Voir">';
	echo'</th>';
	echo'</tr>';
	echo'</form>';
	}
	echo'</table>';
?>