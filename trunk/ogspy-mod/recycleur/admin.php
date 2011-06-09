<?php 
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}
?>
<form method="POST" action="index.php?action=recycleurs&sub_action=razr"> 
	<table  align="center"><tr><td> 
		<table width="200" style="border:2px #003399 solid;" cellpadding="3"> 
			
				<td align="center" class="c" colspan="2">Remise à Zéro des tables</td><tr>			
<th align="center">
Oui:<INPUT type="radio" name="raz" value="Oui"><br>
</tr>
				<th align="center" colspan="2"> 
					<input type="submit" value=" &nbsp; &nbsp; Envoi &nbsp; &nbsp; "> 
				</th>
							</tr> 
		</table> 
		</td></tr></table><br>
		
		

	