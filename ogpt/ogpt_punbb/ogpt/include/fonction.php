<?php

////////////////////////////////// AFFICHAGE SI MISSILE A PORTEE ////////////////////
///////adaptain de a fnction galaxybis.php
function portee_missiles($galaxy, $system)
{
    global $pun_user, $db;
    $retour = 0;
    $total_missil = 0;
    // recherche niveau missile
    $request = 'SELECT user_id, planet_id, coordinates, Silo FROM ogspy_user_building WHERE Silo >= 3';
    $req1 = $db->query($request);

    $ok_missil = '';
    while (list($base_joueur, $base_id_planet, $base_coord, $base_missil) = $db->
        fetch_row($req1)) {
        // sépare les coords
        $missil_coord = explode(':', $base_coord);
        $galaxie_missil = $missil_coord[0];
        $sysSol_missil = $missil_coord[1];
        $planet_missil = $missil_coord[2];
        // recherche le niveau du réacteur du joueur
        $request = 'SELECT RI FROM ogspy_user_technology where user_id = ' . $base_joueur;
        $req2 = $db->query($request);
        list($niv_reac_impuls) = $db->fetch_row($req2);
        // recherche du nombre de missile dispo
        $request = 'SELECT MIP FROM ogspy_user_defence where user_id = ' . $base_joueur .
            ' AND planet_id = ' . $base_id_planet;
        $req2 = $db->query($request);
        list($missil_dispo) = $db->fetch_row($req2);
        if (!$missil_dispo)
            $missil_dispo = 'non connu';
        // recherche le nom du joueur
        $req3 = $db->query('SELECT user_name FROM ogspy_user where user_id = ' . $base_joueur);
        list($nom_missil_joueur) = $db->fetch_row($req3);


        // calcule la porté du silo
        $porte_missil = ($niv_reac_impuls * 5) - 1;
        // calcul des écarts
        $vari_missil_moins = $sysSol_missil - $porte_missil;
        $vari_missil_plus = $sysSol_missil + $porte_missil;
        // création des textes si missil à portée
        if ($galaxy == $galaxie_missil && $system >= $vari_missil_moins && $system <= $vari_missil_plus) {
            if ($retour == 5) {
                $ret = '<br>';
                $retour = 0;
            } else {
                $ret = '&nbsp;|&nbsp;';
                $retour++;
            }
            $door = '<a href="?action=galaxie&galaxie=' . $galaxie_missil . '&systeme=' . $sysSol_missil .
                '">';
            $ok_missil .= $door . $base_coord . '</a> (' . $nom_missil_joueur . ')   ' . $ret .
                ' ';
            $total_missil += $missil_dispo;
        }
    }
    if ($ok_missil)
        $missil_ok = ' ' . $ok_missil . '<br><br>Total : <b>' . $total_missil .
            '</b> MIP Dispo';
    else
        $missil_ok = 'à porté d\'aucun silo de missiles connu';
    return $missil_ok;
}


function RE($galaxie, $systeme, $row)
{
    global $pun_user, $db;

    $ss = '' . $galaxie . ':' . $systeme . ':' . $row . '';
    $sss = '' . $galaxie . 'g' . $systeme . 'g' . $row . '';
    $re = '';

    $sql = 'SELECT *	 FROM ogspy_parsedspy   where coordinates=\'' . $ss . '\'  ';
    $result = $db->query($sql);


    while ($carto = $db->fetch_assoc($result)) {
?>


<?php
		$re = "<A HREF='#' onClick=\"window.open('re.php?re=$ss','_blank','width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');return(false)\">RE</A>";
      
    }


    return $re;


}



?>