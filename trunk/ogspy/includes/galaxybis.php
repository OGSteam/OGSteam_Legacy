<?php
/***************************************************************************
* fichier GalaxyBis
* posséde toutes les fonction suplémentaire
*  filename  : GalaxyBis.php
*  desc.    :
*  Author    : Christ24
*  created    :11/08/2006
*  modified  : 02/03/2007
***************************************************************************/

////////////////////////////////// AFFICHAGE SI MISSILE A PORTEE ////////////////////
function portee_missiles ( $galaxy, $system )
{
  global $user_data,$db;
  $retour = 0;
  $total_missil = 0;
  // recherche niveau missile
  $request = 'SELECT user_id, planet_id, coordinates, Silo FROM ' . TABLE_USER_BUILDING . ' WHERE Silo >= 3';
  $req1 = $db->sql_query ( $request );

  $ok_missil = '';
  while ( list ( $base_joueur, $base_id_planet, $base_coord, $base_missil ) = $db->sql_fetch_row ( $req1 ) )
  {   
    // sépare les coords
    $missil_coord = explode ( ':', $base_coord );
    $galaxie_missil = $missil_coord[0];
    $sysSol_missil = $missil_coord[1];
    $planet_missil = $missil_coord[2];
    // recherche le niveau du réacteur du joueur
    $request = 'SELECT RI FROM ' . TABLE_USER_TECHNOLOGY . ' where user_id = ' . $base_joueur;
    $req2 = $db->sql_query ( $request );
    list ( $niv_reac_impuls ) = $db->sql_fetch_row ( $req2 );
    // recherche du nombre de missile dispo
    $request = 'SELECT MIP FROM ' . TABLE_USER_DEFENCE . ' where user_id = ' . $base_joueur . ' AND planet_id = ' . $base_id_planet;
    $req2 = $db->sql_query ( $request );
    list ( $missil_dispo ) = $db->sql_fetch_row ( $req2 );
    if ( ! $missil_dispo )
      $missil_dispo = 'non connu';
    // recherche le nom du joueur
    $req3 = $db->sql_query ( 'SELECT user_name FROM ' . TABLE_USER . ' where user_id = ' . $base_joueur );
    list ( $nom_missil_joueur ) = $db->sql_fetch_row ( $req3 );
    $color_missil_ally1 = '<font color="#00FF00">';
    $color_missil_ally2 = '</font>';
    $tooltip = '<table width="250">';
    $tooltip .= '<tr><td colspan="2" class="c" align="center">MISSILE</td></tr>';
    $tooltip .= '<tr><td class="c" width="70">Nom : </td><th width="30">' . $nom_missil_joueur . '</th></tr>';
    $tooltip .= '<tr><td class="c" width="70">Nb de missiles dispo : </td><th width="30">' . $missil_dispo . '</th></tr>';
    $tooltip .= '</table>';
    $tooltip = htmlentities ( $tooltip );
    // calcule la porté du silo
    $porte_missil = ( $niv_reac_impuls * 5 ) - 1;
    // calcul des écarts
    $vari_missil_moins = $sysSol_missil - $porte_missil;
    $vari_missil_plus = $sysSol_missil + $porte_missil;
    // création des textes si missil à portée
    if ( $galaxy == $galaxie_missil && $system >= $vari_missil_moins && $system <= $vari_missil_plus )
    {
      if ( $retour == 11 )
      {
        $ret = '<br>';
        $retour = 0;
      }
      else
      {
        $ret = '&nbsp;-&nbsp;';
        $retour++;
      }
      $door = '<a href="?action=galaxy&galaxy=' . $galaxie_missil . '&system=' . $sysSol_missil . 
        '" onmouseover="this.T_WIDTH=260;this.T_TEMP=15000;return escape(\'' . $tooltip . '\')">';
      $ok_missil .= $door . $color_missil_ally1 . $base_coord . $color_missil_ally2 . '</a> - ';
      $total_missil += $missil_dispo;
    }
  }
  if ( $ok_missil )
    $missil_ok = '<font color="#FFFF66"> à porté du (des) Silo de missiles suivant(s) : ' . $ok_missil . '</font><br><font color="#DBBADC">Total : ' . $total_missil . ' MIP Dispo</font>';
  else
    $missil_ok = '<font color="#FFFF66"> à porté d\'aucun silo de missiles connu</font>';
  return $missil_ok;
}
?>