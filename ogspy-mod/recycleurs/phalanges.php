<?php
/***************************************************************************
*	filename	: phalanges.php		
*	desc.		: fichier principal du mod
*	Author : DeusIrae
*	created : 25/08/07
*	modified	: 12/02/2008
***************************************************************************/
if (!defined('IN_SPYOGAME')) {
die("Hacking attempt");
}?>

<div id="recy" name="recy"> 
	<form method="POST" action="index.php?action=recycleurs&sub_action=addp"> 
	<table  align="center"><tr><td> 
		<table width="450" style="border:2px #003399 solid;" cellpadding="3"> 
			
				<td align="center" class="c" colspan="4">Formulaire d'envoi des phalanges</td> 
			<tr> 
				<th align="center">Coordonn�es :</th> 
				<th align="center">
				<i>Galaxie :</i> &nbsp; <input type="text" name="galaxie" maxlength="1" size="5"><br>  
				<i>Syst�me :</i> &nbsp; <input type="text" name="systeme" maxlength="3" size="5"><br> 
				<i>Position :</i> &nbsp; <input type="text" name="position" maxlength="2" size="5"><br></th> 
				<th align="center"></th>
		    </tr><tr> 
				<th align="center">Niveau de phalange :</th> 
				<th align="center">
				<input type="text" name="niv" maxlength="2" size="20"><br></th> 
				<th align="center" colspan="2"> 
					<input type="submit" value=" &nbsp; &nbsp; Envoi &nbsp; &nbsp; "> 
				</th> 
			</tr> 
		</table> 
		</td></tr></table> 
	</form> 
</div> 
<?php
for ( $i = 1; $i < $nb_galaxies; $i++) {
	echo '<center>
	<table border="2" width="90%">
	<b><td colspan="6"><font size="5" color="#FFFFFF"><A name='.$i.'>G'.$i.'</A></font></b></tr>
	<tr>
	<td width="20%" align="center"><font color="#FFFFFF" size="4"><b>Coordonn�es</b></font></td>
	<td width="20%" align="center"><font color="#FFFFFF" size="4"><b>De</b></font></td>
	<td width="20%" align="center"><font color="#FFFFFF" size="4"><b>A</b></font></td>
	<td width="20%" align="center"><font color="#FFFFFF" size="4"><b>MAJ</b></font></td>
	<td width="15%" align="center"><font color="#FFFFFF" size="4"><b>Noms</b></font></td>
	<td width="15%" align="center"><font color="#FFFFFF" size="4"><b>Options</b></font></td>
	</tr>
	<tr>';
	$req = "SELECT * FROM ".$table_prefix."phalanges WHERE galaxie=".$i." ORDER BY systeme ASC";
	$result = $db->sql_query ($req);
	while ( $rows = $db->sql_fetch_assoc($result) ) {
		echo '<td width="20%" align="center"><b>'.$rows['galaxie'].':'.$rows['systeme'].':'.$rows['position'].'</b></td>';
		echo '<td width="20%" align="center"><b>'.$rows['galaxie'].':'.$rows['systemep'].'</b></td>';
		echo '<td width="20%" align="center"><b>'.$rows['galaxie'].':'.$rows['systemea'].'</b></td>';
		$time = $rows["time"];
		$time = strftime("%d %b %Y", $time);
		echo '<td width="20%" align="center"><b>'.$time.'</b></td>';
		echo '<td width="20%" align="center"><b>'.$rows['user_name'].'</b></td>';
		if ($rows['user_name'] == $user_data['user_name'] || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
			echo '<td width="15%" align="center"><form method="POST" action="index.php?action=recycleurs&sub_action=suppp">
			<input type="hidden" name="sub_action" value="suppp">
			<input type="hidden" value="suppression" name="suppression">
			<input type="hidden" value='.$rows['id'].' name="id">
			<input type="submit" value="Supprimer" name="supprimer">
			</form>
			</tr></td>';
		}
		else {
			echo '<td></tr></td>';
		}
	}
	echo '</tr></table><br><br>';
}


?>