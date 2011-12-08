<?php
if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");

$id = $db->sql_escape_string($pub_id);
$first_date = $server_config['bigbrother'];
if (is_numeric($id)) {


    $affichage .= '<br />';
    $affichage .= '<br /><table>';
    $affichage .= '<tr>';
    $affichage .= '<td colspan="6" class="c">Depuis le ' . strftime("%d %b %Y %H:%M:%S",
        $first_date) . '</td>';
    $affichage .= '</tr>';
    $affichage .= '<tr>';
    //     $affichage .=  '<td class="c">id : ' . $cache_ally[$id]['id'] . '</td>';
    $affichage .= '<td colspan="6"  class="c">Alliance : ' . $cache_ally[$id]['tag'] .
        '</td>';
    $affichage .= '</tr>';

    $tab = null;
    $i = 0;
    /// recherche joueur actuel
    $requete = "select * from " . TABLE_PLAYER . "";
    $requete .= " where id_ally = '" . $id . "' ";
    $result = $db->sql_query($requete);
    $nb_req_1 = $db->sql_numrows($result);
    while ($row = $db->sql_fetch_assoc($result)) {

        $tab[$i][0] = '<a href="index.php?action=bigbrother&subaction=player&id=' . $row['id'] .
            '">' . $row['name_player'] . '</a>';
        $tab[$i][1] = convert_status($row['status']);
        $i++;

    }

    $i = 0;
    // recherche joueur ancien
    $requete = "select * from " . TABLE_STORY_PLAYER . "";
    $requete .= " where id_ally = '" . $id . "' ";
    $result = $db->sql_query($requete);
    $nb_req_2 = $db->sql_numrows($result);
    while ($row = $db->sql_fetch_assoc($result)) {

        $tab[$i][2] = strftime("%d %b %Y %H:%M:%S", $row['datadate']);
        if ($row['name_player'] == $cache_player[$row['id_player']]['name_player']) {
            $add = "";
        } else {
            $add = " (Actuellement : '" . $cache_player[$row['id_player']]['name_player'] .
                "') ";
        }
        $tab[$i][3] = '<a href="index.php?action=bigbrother&subaction=player&id=' . $row['id_player'] .
            '">' . $row['name_player'] . '</a> ' . $add . ' ';
        if ($row['status'] == $cache_player[$row['id_player']]['status']) {
            $add = "";
        } else {
            $add = " (Actuellement : '" . $cache_player[$row['id_player']]['status'] . "') ";
        }
        $tab[$i][4] = ' ' . convert_status($row['status']) . $add . '';
        if ($row['id_ally'] == $cache_player[$row['id_player']]['id_ally']) {
            $add = "";
        } else {
            $add = " (Actuellement : '" . convert_ally($cache_player[$row['id_player']]['id_ally']) .
                "') ";
        }
        $tab[$i][5] = '' . convert_ally($row['id_ally']) . $add . '';


        $i++;
    }

    $nb_row = max($nb_req_1, $nb_req_2);


    $affichage .= '<tr>';
    $affichage .= '<td colspan="2" class="c">Joueurs référencés (' . $nb_req_1 .
        ')</td>';
    $affichage .= '<td colspan="4" class="c">Anciennement dans l alliance (' . $nb_req_2 .
        ')</td>';
    $affichage .= '</tr>';

    $affichage .= '<tr>';
    $affichage .= '<td class="c">name_player</td>';
    $affichage .= '<td class="c">status</td>';
    $affichage .= '<td class="c">date</td>';
    $affichage .= '<td class="c">Nom</td>';
    $affichage .= '<td class="c">status</td>';
    $affichage .= '<td class="c">alliance</td>';
    $affichage .= '</tr>';


    for ($i = 0; $i < $nb_row; $i++) {
        $affichage .= '<tr>';
        $affichage .= '<td class="b">' . $tab[$i][0] . '</td>';
        $affichage .= '<td class="b">' . $tab[$i][1] . '</td>';
        $affichage .= '<td class="b">' . $tab[$i][2] . '</td>';
        $affichage .= '<td class="b">' . $tab[$i][3] . '</td>';
        $affichage .= '<td class="b">' . $tab[$i][4] . '</td>';
        $affichage .= '<td class="b">' . $tab[$i][5] . '</td>';

        $affichage .= '</tr>';


    }


    $affichage .= '</table>';

    echo $affichage;

}





?>
