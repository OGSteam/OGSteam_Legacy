<?php
/*
* include.php
* @mod ZoneCheck
* @author Gorn
* @fileversion 2.5
*
* 0 = pas de changement
* 1 = status
* 2 = lune
* 4 = alliance
* 8 = nom
* 16 = planète
* 32 = colonisation
*/

// Sécurité
if ( !defined ( 'IN_SPYOGAME' ) || !defined ( 'IN_ZONECHECK' ) )
   die ( 'Hacking attempt' );

//Mise à jour du mod nécessaire et/ou forcée ?
function maj_mod ( $moon, $name, $ally, $player, $statut, $galaxy, $system, $row, $last_update ) {

  global $db;
  global $system_per_page, $color_block, $color_moon, $color_deco, $color_vac, $color_inactif, $color_unstatus;
  global $color_colo, $color_date_less, $color_date_middle, $color_date_more, $color_date_out;
  $statut_changed = 0;
  $histo = array();

  // Récupération des informations de la vue galaxie
  $query = 'SELECT `moon`, `name`, `ally`, `player`, `status`, `last_update` FROM ' . TABLE_UNIVERSE . ' WHERE `galaxy` = ' . $galaxy . ' AND `system` = ' . $system . ' AND `row` = ' . $row;
  list ( $new_moon, $new_name, $new_ally, $new_player, $new_statut, $galaxie_last_update ) = $db->sql_fetch_row ( $db->sql_query ( $query ) );

  // Calcul des changements survenus entre les 2 mises à jour et mise à jour du mod si besoin.
  $query = 'UPDATE ' . TABLE_MOD_ZONECHECK . ' SET ';
  if ( $new_statut != $statut ) {
    $statut_changed += 1;
    $statut = $new_statut;
    $query .= '`status` = "' . $new_statut . '", ';
  }
  if ( $new_moon != $moon ) {
    $statut_changed += 2;
    $moon = $new_moon;
    $query .= '`moon` = "' . $new_moon . '", ';
  }
  if ( $new_ally != $ally ) {
    $statut_changed += 4;
    $histo[] = 'INSERT IGNORE INTO ' . TABLE_MOD_ZONECHECK_HST . ' (oldname, newname, type, date, coordinates) VALUES ( "' . $ally . '","' . $new_ally . '","A","' . $galaxie_last_update . '","' . $galaxy . ':' . $system . ':' . $row . '")';
    $ally = $new_ally;
    $query .= '`ally` = "' . $new_ally . '", ';
  }
  if ( $new_player != $player ) {
    $statut_changed += 8;
    if ( $player != '' )
      $histo[] = 'INSERT IGNORE INTO ' . TABLE_MOD_ZONECHECK_HST . ' (oldname, newname, type, date, coordinates, ally) VALUES ("' . $player . '","' . $new_player . '","P","' . $galaxie_last_update . '","' . $galaxy . ':' . $system . ':' . $row . '","' . $new_ally . '")';
    else
      $histo[] = 'DELETE FROM ' . TABLE_MOD_ZONECHECK_HST . ' WHERE coordinates = "' . $galaxy . ':' . $system . ':' . $row . '"';
    $player = $new_player;
    $query .= '`player` = "' . $new_player . '", ';
  }
  if ( ( $new_name != '' && $name == '' ) && $new_player != '' ) {
    $statut_changed = 32;
    $name = $new_name;
    $query .= '`name` = "' . $new_name . '", ';
  }
  elseif ( $new_name != $name ) {
    $statut_changed += 16;
    $name = $new_name;
    $query .= '`name` = "' . $new_name . '", ';
    if ( $new_name == '' )
      $histo[] = 'DELETE FROM ' . TABLE_MOD_ZONECHECK_HST . ' WHERE coordinates = "' . $galaxy . ':' . $system . ':' . $row . '"';
  }
  if ( $statut_changed > 0 || ( ( mktime ( 0, 0, 0 ) - $last_update ) > ( 5 * 86400 ) ) ) {
    $last_update = $galaxie_last_update;
    $query .= '`last_update` = "' . $galaxie_last_update . '", ';
    $query .= '`status_changed` = "' . $statut_changed . '"' ;
    $query .= ' WHERE `galaxy` = ' . $galaxy . ' AND `system` = ' . $system . ' AND `row` = ' . $row;
    $db->sql_query ( $query );
  }
  if ( sizeof ( $histo ) > 0 )
  {
    foreach ( $histo as $query )
    {
      $db->sql_query ( $query, true );
    }
  }
  return array ( $moon, $name, $ally, $player, $statut, $last_update, $statut_changed );
}

function calcul_changement ( $statut_changed, $player, $statut ) {

  global $show, $td, $num_statut, $num_lune, $num_ally, $num_PseuDo, $num_planete, $num_colo;
  global $system_per_page, $color_block, $color_moon, $color_deco, $color_vac, $color_inactif, $color_unstatus;
  global $color_colo, $color_date_less, $color_date_middle, $color_date_more, $color_date_out;
  $changed = $color = '';

  switch ( $statut_changed ) {
    case 0:
      $show = false;
      break;
    case 1:
      $changed = '(' . $statut . ')';
      $num_statut++;
      break;
    case 2:
      $changed = 'Lune';
      $num_lune++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 3:
      $changed = '(' . $statut . ') & Lune';
      $num_statut++;
      $num_lune++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 4:
      $changed = 'Ally';
      $num_ally++;
      break;
    case 5:
      $changed = '(' . $statut . ') & Ally';
      $num_statut++;
      $num_ally++;
      break;
    case 6:
      $changed = 'Lune & Ally';
      $num_lune++;
      $num_ally++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 7:
      $changed = '(' . $statut . ') & Lune & Ally';
      $num_statut++;
      $num_lune++;
      $num_ally++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 8:
      $changed = 'PseuDo';
      $num_PseuDo++;
      break;
    case 9:
      $changed = '(' . $statut . ') & PseuDo';
      $num_statut++;
      $num_PseuDo++;
      break;
    case 10:
      $changed = 'Lune & PseuDo';
      $num_lune++;
      $num_PseuDo++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 11:
      $changed = '(' . $statut . ') & Lune & PseuDo';
      $num_statut++;
      $num_lune++;
      $num_PseuDo++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 12:
      $changed = 'Ally & PseuDo';
      $num_ally++;
      $num_PseuDo++;
      break;
    case 13:
      $changed = '(' . $statut . ') & Ally & PseuDo';
      $num_statut++;
      $num_ally++;
      $num_PseuDo++;
      break;
    case 14:
      $changed = 'Lune & Ally & PseuDo';
      $num_lune++;
      $num_ally++;
      $num_PseuDo++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 15:
      $changed = '(' . $statut . ') & Lune & Ally & PseuDo';
      $num_statut++;
      $num_lune++;
      $num_ally++;
      $num_PseuDo++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 16:
      $changed = 'Planète';
      $num_planete++;
      break;
    case 17:
      $changed = '(' . $statut . ') & Planète';
      $num_statut++;
      $num_planete++;
      break;
    case 18:
      $changed = 'Lune & Planète';
      $num_lune++;
      $num_planete++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 19:
      $changed = '(' . $statut . ') & Lune & Planète';
      $num_statut++;
      $num_lune++;
      $num_planete++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 20:
      $changed = 'Ally & Planète';
      $num_ally++;
      $num_planete++;
      break;
    case 21:
      $changed = '(' . $statut . ') & Ally & Planète';
      $num_statut++;
      $num_ally++;
      $num_planete++;
      break;
    case 22:
      $changed = 'Lune & Ally & Planète';
      $num_lune++;
      $num_ally++;
      $num_planete++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 23:
      $changed = '(' . $statut . ') & Lune & Ally & Planète';
      $num_statut++;
      $num_lune++;
      $num_ally++;
      $num_planete++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 24:
      $changed = 'PseuDo & Planète';
      $num_PseuDo++;
      $num_planete++;
      break;
    case 25:
      $changed = '(' . $statut . ') & PseuDo & Planète';
      $num_statut++;
      $num_PseuDo++;
      $num_planete++;
      break;
    case 26:
      $changed = 'Lune & PseuDo & Planète';
      $num_lune++;
      $num_PseuDo++;
      $num_planete++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 27:
      $changed = '(' . $statut . ') & Lune & PseuDo & Planète';
      $num_statut++;
      $num_lune++;
      $num_PseuDo++;
      $num_planete++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 28:
      $changed = 'Ally & PseuDo & Planète';
      $num_ally++;
      $num_PseuDo++;
      $num_planete++;
      break;
    case 29:
      $changed = '(' . $statut . ') & Ally & PseuDo & Planète';
      $num_statut++;
      $num_ally++;
      $num_PseuDo++;
      $num_planete++;
      break;
    case 30:
      $changed = 'Lune & Ally & PseuDo & Planète';
      $num_lune++;
      $num_ally++;
      $num_PseuDo++;
      $num_planete++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 31:
      $changed = '(' . $statut . ') & Lune & Ally & PseuDo & Planète';
      $num_statut++;
      $num_lune++;
      $num_ally++;
      $num_PseuDo++;
      $num_planete++;
      $color = ' background-color: ' . $color_moon . '; font-weight:bold;';
      $td = 'td';
      break;
    case 32:
      $changed = 'Colonisation';
      $num_colo++;
      $color = ' background-color: ' . $color_colo . '; font-weight:bold;';
      $td = 'td';
      break;
    default:
      $show = false;
  }

  // Est-ce une décolonisation ou non ?
  if ( $player == '' && isset ( $changed ) ) {
    if ( ereg ( 'Planète', $changed ) ) $num_planete--;
    if ( ereg ( 'Lune', $changed ) ) $num_lune--;
    if ( ereg ( 'Ally', $changed ) ) $num_ally--;
    if ( ereg ( 'PseuDo', $changed ) ) $num_PseuDo--;
    if ( ereg ( 'Statut', $changed ) ) $num_statut--;
    if ( ereg ( 'Colonisation', $changed ) ) $num_colo--;
    $changed = 'Décolonisation';
    $color = ' background-color: ' . $color_deco . '; font-weight:bold;';
    $td = 'td';
  }

  return array ( $changed, $color, $td );

}

function create_links ( $ally, $player, $galaxie, $system, $row ) {

  global $begin_allied, $begin_hided, $end_hided, $end_allied, $db;
  $link_player = $link_ally = '';

  // Création des liens et des tooltips indiquant les classements.
  if ( $ally != '' ) {
    $tooltip = '<table width="250">';
    $tooltip .= '<tr><td colspan="3" class="c" align="center">Alliance ' . $ally . '</td></tr>';
    $query = 'SELECT oldname FROM ' . TABLE_MOD_ZONECHECK_HST . ' WHERE newname="' . $ally . '" AND type="A" AND coordinates="' . $galaxie . ':' . $system . ':' . $row . '" ORDER BY date DESC LIMIT 0,1';
    $result = $db->sql_query ( $query );
    if ( $db->sql_numrows ( $result ) > 0 )
    {
      list ( $oldname ) = $db->sql_fetch_row ( $result );
      $tooltip .= '<tr><td class="c" colspan="2">Ancienne alliance du joueur</td><th nowrap>' . $oldname . '</th></tr>';
    }
    $individual_ranking = galaxy_show_ranking_unique_ally ( $ally );
    while ( $ranking = current ( $individual_ranking ) ) {
      $datadate = strftime ( "%d %b %Y &agrave; %Hh", key ( $individual_ranking ) );
      $general_rank = isset ( $ranking['general'] ) ? formate_number ( $ranking['general']['rank'] ):'&nbsp;';
      $general_points = isset ( $ranking['general'] ) ? formate_number ( $ranking['general']['points'] ) . ' <i>(' . formate_number ( $ranking['general']['points_per_member'] ) . ')</i>':'&nbsp;';
      $fleet_rank = isset ( $ranking['fleet'] ) ? formate_number ( $ranking['fleet']['rank'] ) : '&nbsp;';
      $fleet_points = isset ( $ranking['fleet'] ) ?  formate_number ( $ranking['fleet']['points'] ) . ' <i>(' . formate_number ( $ranking['fleet']['points_per_member'] ) . ')</i>':'&nbsp;';
      $research_rank = isset ( $ranking['research'] ) ? formate_number($ranking['research']['rank']) : '&nbsp;';
      $research_points = isset ( $ranking['research'] ) ? formate_number ( $ranking['research']['points'] ) . ' <i>(' . formate_number ( $ranking['research']['points_per_member'] ) . ')</i>':'&nbsp;';
      $tooltip .= '<tr><td class="c" colspan="3" align="center">Classement du ' . $datadate . '</td></tr>';
      $tooltip .= '<tr><td class="c" width="75">G&eacute;n&eacute;ral</td><th width="50">' . $general_rank . '</th><th>' . $general_points . '</th></tr>';
      $tooltip .= '<tr><td class="c">Flotte</td><th>' . $fleet_rank . '</th><th>' . $fleet_points . '</th></tr>';
      $tooltip .= '<tr><td class="c">Recherche</td><th>' . $research_rank . '</th><th>' . $research_points . '</th></tr>';
      $tooltip .= '<tr><td class="c" colspan="3" align="center">' . formate_number ( $ranking['number_member'] ) . ' membre(s)</td></tr>';
      break;
    }
    $tooltip .= '<tr><td class="c" colspan="3" align="center"><a href="index.php?action=search&type_search=ally&string_search=' . $ally . '&strict=on">Voir d&eacute;tail</a></td></tr>';
    $tooltip .= '</table>';
    $tooltip = htmlentities ( $tooltip );
    $link_ally = '<a href="index.php?action=search&type_search=ally&string_search=' . $ally . '&strict=on" onmouseover="this.T_WIDTH=260;this.T_TEMP=15000;return escape(\'' . $tooltip . '\')">[' . $begin_allied . $begin_hided . $ally . $end_hided . $end_allied . ']</a>';
  }
  if ( $player != '' ) {
    $tooltip = '<table width="250">';
    $tooltip .= '<tr><td colspan="3" class="c" align="center">Joueur ' . $player . '</td></tr>';
    $query = 'SELECT oldname FROM ' . TABLE_MOD_ZONECHECK_HST . ' WHERE newname="' . $player . '" AND type="P" AND coordinates="' . $galaxie . ':' . $system . ':' . $row . '" ORDER BY date DESC';
    $result = $db->sql_query ( $query );
    if ( $db->sql_numrows ( $result ) > 0 )
    {
      list ( $oldname ) = $db->sql_fetch_row ( $result );
      $tooltip .= '<tr><td class="c" colspan="2">Ancien pseudo</td><th nowrap>' . $oldname . '</th></tr>';
    }
    $individual_ranking = galaxy_show_ranking_unique_player ( $player );
    while ( $ranking = current ( $individual_ranking ) ) {
      $datadate = strftime ( "%d %b %Y &agrave; %Hh", key ( $individual_ranking ) );
      $general_rank = isset ( $ranking['general'] ) ? formate_number ( $ranking['general']['rank'] ):'&nbsp;';
      $general_points = isset ( $ranking['general'] ) ? formate_number ( $ranking['general']['points'] ):'&nbsp;';
      $fleet_rank = isset ( $ranking['fleet'] ) ? formate_number ( $ranking['fleet']['rank'] ) : '&nbsp;';
      $fleet_points = isset ( $ranking['fleet'] ) ?  formate_number ( $ranking['fleet']['points'] ):'&nbsp;';
      $research_rank = isset ( $ranking['research'] ) ? formate_number($ranking['research']['rank']) : '&nbsp;';
      $research_points = isset ( $ranking['research'] ) ? formate_number ( $ranking['research']['points'] ):'&nbsp;';
      $tooltip .= '<tr><td class="c" colspan="3" align="center">Classement du ' . $datadate . '</td></tr>';
      $tooltip .= '<tr><td class="c" width="75">G&eacute;n&eacute;ral</td><th width="50" nowrap>' . $general_rank . '</th><th>' . $general_points . '</th></tr>';
      $tooltip .= '<tr><td class="c">Flotte</td><th nowrap>' . $fleet_rank . '</th><th>' . $fleet_points . '</th></tr>';
      $tooltip .= '<tr><td class="c">Recherche</td><th nowrap>' . $research_rank . '</th><th>' . $research_points . '</th></tr>';
      break;
    }
    $tooltip .= '<tr><td class="c" colspan="3" align="center"><a href="index.php?action=search&type_search=player&string_search=' . $player . '&strict=on">Voir d&eacute;tail</a></td></tr>';
    $tooltip .= '</table>';
    $tooltip = htmlentities ( $tooltip );
    $link_player = '<a href="index.php?action=search&type_search=player&string_search=' . $player . '&strict=on" onmouseover="this.T_WIDTH=260;this.T_TEMP=15000;return escape(\'' . $tooltip . '\')">' . $begin_allied . $begin_hided . $player . $end_hided . $end_allied . '</a>';
  }
  $link_galaxie = 'index.php?action=galaxy&galaxy=' . $galaxie . '&system=' . $system;
  return array ( $link_ally, $link_player, $link_galaxie );

}

function colorise ( $last_update, $changed ) {

  global $system_per_page, $color_block, $color_moon, $color_deco, $color_vac, $color_inactif, $color_unstatus;
  global $color_colo, $color_date_less, $color_date_middle, $color_date_more, $color_date_out;
  $color_update = $last_statut = '';
  //Coloration des dates
  if ( mktime ( 0, 0, 0 ) - $last_update < 21600 )  $color_update = '<font color="' . $color_date_less . '">';
  elseif ( mktime ( 0, 0, 0 ) - $last_update < 43200 ) $color_update = '<font color="' . $color_date_middle . '">';
  elseif ( mktime ( 0, 0, 0 ) - $last_update < 86400 ) $color_update = '<font color="' . $color_date_more . '">';
  else $color_update = '<font color="' . $color_date_out . '">';

  // Coloration des statuts
  if ( strpos ( $changed, ')' ) !== false ) {
    if ( strpos ( $changed, 'b' ) !== false )
      $changed = '<font color="' . $color_block . '">' . $changed . '</font>';
    elseif ( strpos ( $changed, 'v' ) !== false )
      $changed = '<font color="' . $color_vac . '">' . $changed . '</font>';
    elseif ( strpos ( $changed, 'i' ) !== false || strpos ( $changed, 'I' ) !== false )
      $changed = '<font color="' . $color_inactif . '">' . $changed . '</font>';
    elseif ( strpos ( $changed, '*' ) !== false )
      $changed = '<font color="' . $color_unstatus . '">' . $changed . '</font>';
  }

  //Coloration des colonisations
  if ( ereg ( 'Colonisation', $changed ) ) {
    if ( ereg ( '<font color="#([A-Z0-9]*)"', $changed, $regs ) )
      $changed = ereg_replace ( 'Colonisation', '</font><font color="' . $color_colo . '">Colonisation</font><font color="#' . $regs[0] . '">', $changed );
    else
      $changed = ereg_replace ( 'Colonisation', '<font color="' . $color_colo . '">Colonisation</font>', $changed );
  }

  return array ( $color_update, $changed, $last_statut );

}

// Constantes / Variables globales
define ( 'TABLE_MOD_ZONECHECK', $table_prefix . 'ZoneCheck' );
define ( 'TABLE_MOD_ZONECHECK_CFG', $table_prefix . 'ZoneCheck_config' );
define ( 'TABLE_MOD_ZONECHECK_HST', $table_prefix . 'ZoneCheck_histo' );

if ( ! defined ( 'TABLE_MOD_CFG' ) )
{
  $query = 'SELECT nb_system, block, moon, deco, vac, inactif, unstatus, colo, less, middle, more, outofdate, affichage FROM ' . TABLE_MOD_ZONECHECK_CFG;
  $result = $db->sql_query ( $query );
  if ( ! $result || $db->sql_numrows ( $result ) == 0)
    $system_per_page = 0;
  else
    list ( $system_per_page, $color_block, $color_moon, $color_deco, $color_vac, $color_inactif, $color_unstatus, $color_colo, $color_date_less, $color_date_middle, $color_date_more, $color_date_out, $affiche ) = $db->sql_fetch_row ( $result );
}
else
{
  $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="nb_system"';
  $result = $db->sql_query ( $query );
  if ( ! $result || $db->sql_numrows ( $result ) == 0 )
    $system_per_page = 0;
  else
  {
    list ( $system_per_page ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="block"';
    $result = $db->sql_query ( $query );
    list ( $color_block ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="moon"';
    $result = $db->sql_query ( $query );
    list ( $color_moon ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="deco"';
    $result = $db->sql_query ( $query );
    list ( $color_deco ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="vac"';
    $result = $db->sql_query ( $query );
    list ( $color_vac ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="inactif"';
    $result = $db->sql_query ( $query );
    list ( $color_inactif ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="unstatus"';
    $result = $db->sql_query ( $query );
    list ( $color_unstatus ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="colo"';
    $result = $db->sql_query ( $query );
    list ( $color_colo ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="less"';
    $result = $db->sql_query ( $query );
    list ( $color_date_less ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="middle"';
    $result = $db->sql_query ( $query );
    list ( $color_date_middle ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="more"';
    $result = $db->sql_query ( $query );
    list ( $color_date_more ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="outofdate"';
    $result = $db->sql_query ( $query );
    list ( $color_date_out ) = $db->sql_fetch_row ( $result );
    $query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod`="ZoneCheck" AND config="affichage"';
    $result = $db->sql_query ( $query );
    list ( $affiche ) = $db->sql_fetch_row ( $result );
  }
}
if ( $system_per_page == 0 )
{
  $system_per_page = 50;
  $color_block = '#FFAAD4';
  $color_moon = '#00D4FF';
  $color_deco = '#DDBB66';
  $color_vac = '#7FFFFF';
  $color_inactif = '#FF7F00';
  $color_unstatus = '#FFAA2A';
  $color_colo = '#FF0000';
  $color_date_less = '#FF2A00';
  $color_date_middle = '#FFAA2A';
  $color_date_more = '#FFFF2A';
  $color_date_out = '#FFFFFF';
  $affiche = '';
}

if ( ! isset ( $pub_affiche ) )
  $pub_affiche = $affiche;
if ( !isset ( $num_of_galaxies ) || !isset ( $num_of_systems ) ) {
  $num_of_galaxies = ( isset ( $server_config['num_of_galaxies'] ) ) ? $server_config['num_of_galaxies']:9;
  $num_of_systems = ( isset ( $server_config['num_of_systems'] ) ) ? $server_config['num_of_systems']:499;
}

if ( !isset ( $pub_galaxie ) )
  $pub_galaxie = 1;
elseif ( isset ( $pub_galaxie ) && ! ( $pub_galaxie > 0 && $pub_galaxie <= $num_of_galaxies ) )
  $pub_galaxie = 1;

if ( !isset ( $pub_systeme ) )
  $pub_systeme = 1;
elseif ( isset ( $pub_systeme ) && ! ( $pub_systeme > 0 && $pub_systeme <= $num_of_systems ) )
  $pub_systeme = 1;

if ( isset ( $pub_centrer ) && $pub_centrer == 'Centrer la vue' )
  $pub_systeme -= ( $system_per_page / 2 );
if ( $server_config['ally_protection'] != '' )
  $ally_protection = explode ( ',', $server_config['ally_protection'] );
if ( $server_config['allied'] != '' )
  $allied = explode ( ',', $server_config['allied'] );

$idx_system_shown = 0;
$num_system_shown = 0;
$num_statut = 0;
$num_lune = 0;
$num_ally = 0;
$num_PseuDo = 0;
$num_planete = 0;
$num_colo = 0;
?>