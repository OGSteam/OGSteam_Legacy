<?php
if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");

require_once ("views/page_header.php");
// fichier commun
require_once ("mod/bigbrother/common.php");


create_menu();

switch ($pub_subaction) {

    case 'index':
        require (MOD_URL . "view/index.php");
        break;

    case 'apropos':
        require (MOD_URL . "view/apropos.php");
        break;

    case 'recherche':
        require (MOD_URL . "view/recherche.php");
        break;


    default:
        require (MOD_URL . "view/index.php");

}


require_once ("./views/page_tail.php");


//////////////////////////! fonctions \\\\\\\\\\\\\\\\\\\\\\\\\\
function create_menu()
{
    global $pub_subaction;
?>
    <table>
        <tbody>
            <tr align="center">
                <?php create_sub_menu("index"); ?>
                <?php create_sub_menu("recherche"); ?>
                <?php create_sub_menu("apropos"); ?>
            </tr>
        </tbody>
    </table>
    
    <?php


}

function create_sub_menu($value)
{
    global $pub_subaction;
    $class = null;
    if (isset($pub_subaction) && $pub_subaction == $value) {
        $class = 'class="c"';
    } else {
        $class = 'class="b"';
    }
    // si index
    if (!isset($pub_subaction) && $value == 'index') {
        $class = 'class="c"';
    }

    echo '<td width="150" ' . $class .
        '><a href="index.php?action=bigbrother&subaction=' . $value . '">' . $value .
        '</a></td>';

}


function player_count($type)
{
    global $db;
    $retour = 0;
    $requete = "select * from " . TABLE_PLAYER . " ";

    switch ($type) {
        case 'total':
            $requete .= "";
            break;


        case 'attente':
            $requete .= "WHERE status = 'x' ";
            break;

        case 'actif':
            $requete .= "JOIN " . TABLE_UNI . " ";
            $requete .= "ON " . TABLE_UNI . ".id_player = " . TABLE_PLAYER . ".id ";
            $requete .= "WHERE " . TABLE_PLAYER . ".status != 'x' ";
            $requete .= " GROUP BY " . TABLE_UNI . ".id_player ";
            break;

    }
    $result = $db->sql_query($requete);
    return $db->sql_numrows($result);

}


function player_actif($type)
{
    global $db;
    $retour = 0;
    $requete = "select * from " . TABLE_PLAYER . " ";

    switch ($type) {
        case 'actif':
            $requete .= "";
            break;


        case 'in':
            $requete .= "WHERE status = 'x'";
            break;

    }
    $result = $db->sql_query($requete);
    return $db->sql_numrows($result);

}
?>