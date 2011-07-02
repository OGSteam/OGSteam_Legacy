<?php
/***************************************************************************
*   filename    : flottes_xtense2.php
*   desc.       : 1.08beta
*   Author      : AirBAT
*   created     : 16/04/2008
*   by          : AirBAT
*   modified    : -
*   last modif. : created
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

// insertion des fonctions flotte
require_once("./mod/flottes/function_flottes.php");

global $db, $table_prefix;

buttons_bar($pub_subaction);
active_xtense2($pub_act);

// on definie les tables mod et xtense_callbacks
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");
define("TABLE_MOD", $table_prefix."mod");
?>

<table class="xtense2">
    <tr>
        <td colspan="2" class="xtense2_h">Gestion du mod Flottes pour Xtense2</td>
    </tr>

<?php
// On regarde si la table xtense_callbacks existe
$q_callback = 'show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'"';
$r_callback = $db->sql_query($q_callback);
$r_callback1 = $db->sql_numrows($r_callback);
if($r_callback1 != 0){
    
    // Xtense2 installe
    echo '<tr height="30px" valign="middle">';
    echo '<td class="status">Etat de Xtense2 (Callbacks)</td>';
    echo '<td class="status1">INSTALLE</td>';
    echo '</tr>';
    
    // on recupere l'id du mod Flottes
    $q_modid = 'SELECT `id` FROM `'.TABLE_MOD.'` WHERE `title`="Flottes" LIMIT 1';
    $r_modid = $db->sql_query($q_modid);
    $r_modid1 = $db->sql_fetch_row($r_modid);
    $mod_id = $r_modid1[0];
    
    //On regarde si le mod Flottes est inscrit dans xtense2
    $q_xstatus = 'Select * From `'.TABLE_XTENSE_CALLBACKS.'` where mod_id = "'.$mod_id.'"';
    $r_xstatus = $db->sql_query($q_xstatus);
    $r_xstatus1 = $db->sql_numrows($r_xstatus);
        
    if ($r_xstatus1 != 0) {
        // xtense2 active
        echo '<tr height="30px" valign="middle">';
        echo '<td class="status">Status du mod Flottes dans Xtense2</td>';
        echo '<td class="status1">ACTIVE</td>';
        echo '</tr></table>';

        // desactiver xtense2
        echo '<table class="xtense2_f">';
        echo '<tr height="30px" valign="middle">';
        echo '<td class="xtense2_f" onclick="window.location = \'index.php?action=flottes&subaction=xtense2&act=desactive\';">';
        echo 'DESACTIVER Xtense2';
        echo '</td></tr></table>';
    }
    else {
        // xtense2 desactive
        echo '<tr height="30px" valign="middle">';
        echo '<td class="status">Status du mod Flottes dans Xtense2</td>';
        echo '<td class="status1">DESACTIVE</td>';
        echo '</tr></table>';
        
        // activer xtense2
        echo '<table class="xtense2_f">';
        echo '<tr height="30px" valign="middle">';
        echo '<td class="xtense2_f" onclick="window.location = \'index.php?action=flottes&subaction=xtense2&act=active\';">';
        echo 'ACTIVER Xtense2';
        echo '</td></tr></table>';
    }
}
else {
    // on affiche comme quoi xtense2 n'est pas installe
    echo '<tr height="30px" valign="middle">';
    echo '<td class="status">Etat de Xtense2 (Callbacks)</td>';
    echo '<td class="status1">DESINSTALLE</td>';
    echo '</tr>';

    // on ne peut donc pas activer le mod dans xtense2
    echo '<tr height="30px" valign="middle">';
    echo '<td class="status">Status du mod Flottes dans Xtense2</td>';
    echo '<td class="status1">IMPOSSIBLE</td>';
    echo '</tr></table>';    
}
?>
