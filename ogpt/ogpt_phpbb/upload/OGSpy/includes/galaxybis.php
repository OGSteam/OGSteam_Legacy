<?php
/***************************************************************************
* fichier GalaxyBis
* poss�de toutes les fonction supl�mentaire
*	filename	: GalaxyBis.php
*	desc.		:
*	Author		: Christ24
*	created		:11/08/2006
*	modified	: 29/08/2006
***************************************************************************/

////////////////////////////////// AFFICHAGE SI MISSILE A PORTEE ////////////////////
function see_porter_missil($galaxy,$system){
	global $user_data,$db;
$retour=0;
$total_missil=0;
// recherche niveau missile
	$request = "SELECT user_id, planet_id, coordinates, Silo ";
	$request .= "FROM ".TABLE_USER_BUILDING." where Silo >= '3' ";
	$req1 = $db->sql_query($request);

	$ok_missil="";
	while($row = mysql_fetch_array($req1))
		{   
			$base_joueur=$row['user_id'];
			$base_id_planet=$row['planet_id'];
			$base_coord=$row['coordinates'];
			$base_missil=$row['Silo'];
// s�pare les coords
			$missil_coord = explode(":", $base_coord);
			$galaxie_missil = $missil_coord[0];
			$sysSol_missil = $missil_coord[1];
			$planet_missil = $missil_coord[2];
			
// recherche le niveau du r�acteur du joueur
			$request = "SELECT RI ";
			$request .= "FROM ".TABLE_USER_TECHNOLOGY." where user_id = '".$base_joueur."' ";
			$req2 = $db->sql_query($request);
			$niv_row = mysql_fetch_array($req2);
			$niv_reac_impuls = $niv_row['RI'];

// recherche du nombre de missile dispo
			$request = "SELECT MIP ";
			$request .= "FROM ".TABLE_USER_DEFENCE." where user_id = '".$base_joueur."' AND planet_id = '".$base_id_planet."' ";
			$req2 = $db->sql_query($request);
			$niv_row = mysql_fetch_array($req2);
			$missil_dispo = $niv_row['MIP'];
			if (!$missil_dispo){$missil_dispo="non connu";}
			
// recherche le nom du joueur
	$req3=mysql_query("SELECT username FROM ".TABLE_USER." where user_id = '".$base_joueur."'");
			$row = mysql_fetch_array($req3);
			$nom_missil_joueur=$row['username'];

				$color_missil_ally1='<font color="#00FF00">';
				$color_missil_ally2='</font>';
				$tooltip = '<table width="250">';
				$tooltip .= '<tr><td colspan="2" class="c" align="center">MISSILE</td></tr>';
				$tooltip .= '<tr><td class="c" width="70">Nom : </td><th width="30">'.$nom_missil_joueur.'</th></tr>';
				//$tooltip .= '<tr><td class="c" width="70">Alliance : </td><th width="30">'.$ally_missil_joueur.'</th></tr>';
				$tooltip .= '<tr><td class="c" width="70">Nb de missiles dispo : </td><th width="30">'.$missil_dispo.'</th></tr>';
				$tooltip .= '</table>';
			$tooltip = htmlentities($tooltip);

// calcule la port� du silo
			$porte_missil = ($niv_reac_impuls*2)-1;

// calcul des �carts
			$vari_missil_moins=$sysSol_missil-$porte_missil;
			$vari_missil_plus=$sysSol_missil+$porte_missil;

// cr�ation des texte si missil � port�e
			if ($galaxy == $galaxie_missil){
				if(($system >= $vari_missil_moins) AND ($system <= $vari_missil_plus))
				{
					if ($retour==11){$ret="<br>";$retour=0;}else{$ret="&nbsp;-&nbsp;";$retour++;}
					$door="<a href=\"?action=galaxy&galaxy=".$galaxie_missil."&system=".$sysSol_missil."\" 
					onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip."')\">";
					
					$ok_missil .= $door.$color_missil_ally1.$base_coord.$color_missil_ally2."</a> - ";
			$total_missil += $missil_dispo;
				}
			}
		}
		if ($ok_missil){
		$missil_ok="<font color='#FFFF66'> � port� du (des) Silo de missiles suivant(s) : ".$ok_missil."</font> <font color='#DBBADC'>Total : ".$total_missil." MIP Dispo</font>";
		}else{$ok_missil="";$missil_ok="<font color='#FFFF66'> � port� d'aucun silo de missiles connu</font>";}

	return $missil_ok;
}

?>
