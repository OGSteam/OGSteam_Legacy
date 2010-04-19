<?php
/*
* zonecheck.php
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
?>
<table>
  <tr>
    <th class="c" nowrap colspan="2" align="center" style="width: 250px;"><form action="index.php" method="post" name="choix_planete" onSubmit="javascript: update_affichage(this);">
      <input type="hidden" name="action" value="<?php print $pub_action ?>">
      <input type="hidden" name="systeme">
      <input type="hidden" name="galaxie">
      <input type="hidden" name="affiche" value="<?php print $pub_affiche ?>">
      <select name="planete" onchange="javascript: change_planete();">
        <option>Sélectionnez votre planète</option>
        <?php
$request = 'SELECT planet_id, planet_name, coordinates FROM ' . TABLE_USER_BUILDING . ' WHERE user_id = ' . 
  $user_data['user_id'] . ' AND planet_id < 10 order by planet_id';
$result = $db->sql_query($request);
while ( $row = $db->sql_fetch_assoc($result) )
{
  print '<option value="' . $row['coordinates'] . '"';
  if ( isset ( $pub_planete ) && $row['coordinates'] == $pub_planete ) print ' selected';
  print '>' . $row['planet_name'] . '</option>' . "\n";
}
        ?>
      </select>
    </form></th>
    <td style="width: 15px;">&nbsp;</td>
    <th class="c" nowrap colspan="2" align="center" style="width: 250px;"><form action="index.php" method="post" name="choix_galaxie" onSubmit="javascript: update_affichage(this);">
      <input type="hidden" name="action" value="<?php print $pub_action ?>">
      <input type="hidden" name="systeme" value="<?php print $pub_systeme ?>">
      <input type="hidden" name="affiche" value="<?php print $pub_affiche ?>">
      <select name="galaxie" onchange="javascript: update_affichage(document.choix_galaxie); document.choix_galaxie.submit();">
        <?php
        for ( $idx_galaxie = 0; $idx_galaxie < $num_of_galaxies; $idx_galaxie++ )
        {
          print '<option value="' . ( $idx_galaxie + 1 ) . '"';
          if ( isset ( $pub_galaxie ) && ( $idx_galaxie + 1 == $pub_galaxie ) ) print ' selected';
          print '>Galaxie ' . ( $idx_galaxie + 1 ) . '</option>' . "\n";
        }
        ?>
      </select>
    </form></th>
    <td style="width: 15px;">&nbsp;</td>
    <th colspan="2" style="width: 250px;">&nbsp;</th>
  </tr>
  <tr>
    <th class="c" nowrap colspan="2" align="center"><form action="index.php" method="POST" name="sspre" onSubmit="javascript: update_affichage(this);">
      <input type="hidden" name="action" value="<?php print $pub_action ?>">
      <input type="hidden" name="galaxie" value="<?php print $pub_galaxie ?>">
      <input type="hidden" name="systeme" value="<?php print ( $pub_systeme - $system_per_page ) ?>">
      <input type="hidden" name="affiche" value="<?php print $pub_affiche ?>">
      <?php print ( $pub_systeme > 1 ) ? '<input name="systempre" type="submit" value="' . $system_per_page . ' Systèmes précédents">':'&nbsp;'; ?>
    </form></th>
    <td style="width: 15px;">&nbsp;</td>
    <th class="c" nowrap colspan="2" align="center">Syst&egrave;mes <?php print $pub_systeme ?> &agrave; <?php print ( $pub_systeme + $system_per_page - 1 ) ?><?php print ( isset ( $pub_centrer ) && $pub_centrer == 'Centrer la vue' ) ? '<br />(Vue centr&eacute;e sur le syst&egrave;me ' . ( $pub_systeme + ( $system_per_page / 2 ) ) . ')':''; ?></th>
    <td style="width: 15px;">&nbsp;</td>
    <th class="c" nowrap colspan="2" align="center"><form action="index.php" method="POST" name="sssui" onSubmit="javascript: update_affichage(this);">
      <input type="hidden" name="action" value="<?php print $pub_action ?>">
      <input type="hidden" name="galaxie" value="<?php print $pub_galaxie ?>">
      <input type="hidden" name="systeme" value="<?php print ( $pub_systeme + $system_per_page ) ?>">
      <input type="hidden" name="affiche" value="<?php print $pub_affiche ?>">
      <?php print ( $pub_systeme < $num_of_systems - $system_per_page ) ? '<input name="systemsui" type="submit" value="' . $system_per_page . ' Systèmes suivants">':'&nbsp;'; ?>
    </form></th>
  </tr>
  <tr>
    <th class="c" nowrap colspan="8" align="center" nowrap>Centrer la vue sur le syst&egrave;me :
      <form name="centerview" method="post" action="index.php" onSubmit="javascript: update_affichage(this);">
      <input type="hidden" name="action" value="<?php print $pub_action ?>">
      <input type="hidden" name="subaction" value="centrer">
      <input type="hidden" name="affiche" value="<?php print $pub_affiche ?>">
      <input name="galaxie" type="text" value="<?php print $pub_galaxie ?>" maxlength="1" style="width: 50px">:
      <input name="systeme" type="text" value="<?php print ( $pub_systeme + ( $system_per_page / 2 ) ) ?>" maxlength="3" style="width: 50px">
      <input type="submit" name="centrer" value="Centrer la vue"></form></th>
  </tr>
  <tr>
    <th class="c" nowrap colspan="8" align="center" nowrap><form name="affichage" action="index.php" method="POST" onSubmit="javascript: update_affichage(this);">
      <input type="hidden" name="action" value="<?php print $pub_action ?>">
      <input type="hidden" name="galaxie" value="<?php print $pub_galaxie ?>">
      <input type="hidden" name="systeme" value="<?php print $pub_systeme ?>">
      <input type="hidden" name="planete" value="<?php print ( isset ( $pub_planete ) ) ? $pub_planete:'' ?>">
      <input type="hidden" name="affiche" value="<?php print $pub_affiche ?>">
      <table border="0" cellpadding="0" cellspacing="10" width="100%">
        <tr>
          <th class="c" align="center">Choix de l'affichage :<br /><br /><input type="button" value="Tout cocher" onclick="javascript: affiche_all()"></th>
          <th class="c" style="text-align: left;"><input type="checkbox" value="inactif"<?php if ( !empty ( $pub_affiche ) && preg_match ( '/inactif/', stripslashes ( $pub_affiche ) ) ) print ' checked' ?>>Inactifs 7 jours<br />
            <input type="checkbox" value="I"<?php if ( !empty ( $pub_affiche ) && preg_match ( '/I/', stripslashes ( $pub_affiche ) ) ) print ' checked' ?>>Inactifs 28 jours<br />
            <input type="checkbox" value="d"<?php if ( !empty ( $pub_affiche ) && preg_match ( '/d/', stripslashes ( $pub_affiche ) ) ) print ' checked' ?>>D&eacute;butants<br />
            <input type="checkbox" value="v"<?php if ( !empty ( $pub_affiche ) && preg_match ( '/v/', stripslashes ( $pub_affiche ) ) ) print ' checked' ?>>Mode vacances<br />
            <input type="checkbox" value="b"<?php if ( !empty ( $pub_affiche ) && preg_match ( '/b/', stripslashes ( $pub_affiche ) ) ) print ' checked' ?>>Bloqu&eacute;s<br />
          </th>
          <th class="c" style="text-align: left;"><input type="checkbox" value="PseuDo"<?php if ( !empty ( $pub_affiche ) && preg_match ( '/PseuDo/', stripslashes ( $pub_affiche ) ) ) print ' checked' ?>>Changements de nom<br />
            <input type="checkbox" value="Ally"<?php if ( !empty ( $pub_affiche ) && preg_match ( '/Ally/', stripslashes ( $pub_affiche ) ) ) print ' checked' ?>>Changements d'alliance<br />
            <input type="checkbox" value="Planète"<?php if ( !empty ( $pub_affiche ) && preg_match ( '/Planète/', stripslashes ( $pub_affiche ) ) ) print ' checked' ?>>Renommages de planète<br />
            <input type="checkbox" value="Lune"<?php if ( !empty ( $pub_affiche ) && preg_match ( '/Lune/', stripslashes ( $pub_affiche ) ) ) print ' checked' ?>>Nouvelle lune / Suppression de lune<br />
            <input type="checkbox" value="Colonisation"<?php if ( !empty ( $pub_affiche ) && preg_match ( '/Colonisation/', stripslashes ( $pub_affiche ) ) ) print ' checked' ?>>Colonisations<br />
            <input type="checkbox" value="Décolonisation"<?php if ( !empty ( $pub_affiche ) && preg_match ( '/Décolonisation/', stripslashes ( $pub_affiche ) ) ) print ' checked' ?>>D&eacute;colonisations<br />
          </th>
          <th class="c"><input type="submit" name="Modifier" value="Modifier l'affichage"></th>
        </tr>
      </table>
    </form></th>
  </tr>
  <tr>
    <th class="c" colspan="8">&nbsp;</th>
  </tr>
  <tr>
<?php
// Récupération et parcours de la zone complète
$query = 'SELECT `system`, `row`, `status_changed`, `moon`, `name`, `ally`, `player`, `status`, `last_update` FROM ' . 
  TABLE_MOD_ZONECHECK . ' WHERE `galaxy` = ' . $pub_galaxie . ' AND `system` BETWEEN ' . $pub_systeme . ' AND ' . 
  ( ( ( $pub_systeme + $system_per_page ) < $num_of_systems ) ? ( $pub_systeme + $system_per_page - 1 ):$num_of_systems );
$result = $db->sql_query ( $query );
while ( list ( $system, $row, $statut_changed, $moon, $name, $ally, $player, $statut, $last_update ) = $db->sql_fetch_row ( $result ) )
{
  // Vérification d'une mise à jour du système
  $query = 'SELECT `last_update` FROM ' . TABLE_UNIVERSE . ' WHERE `galaxy` = ' . $pub_galaxie . ' AND `system` = ' . $system . ' AND 
    `row` = ' . $row;
  list ( $galaxie_last_update ) = $db->sql_fetch_row ( $db->sql_query ( $query ) );
  $show = true;
  $color = '';
  $td = 'th';
  $color_update = '<font color="white">';
  $color_updated = '</font>';

  // Si la vue galaxie est plus récente que la vue du mod, on met à jour
  if ( $galaxie_last_update > $last_update )
    list ( $moon, $name, $ally, $player, $statut, $last_update, $statut_changed ) = maj_mod ( $moon, $name, $ally, $player, $statut, $pub_galaxie, $system, $row, $galaxie_last_update );

  // Calcul des changements intervenus et préparation de l'affichage
  if ( $statut == '' )
    $statut = '*';
  list ( $changed, $color, $td ) = calcul_changement ( $statut_changed, $player, $statut );
  if ( !empty ( $pub_affiche ) && preg_match ( '/' . stripslashes ( $pub_affiche ) . '/', $changed ) )
  {
    list ( $link_ally, $link_player, $link_galaxie ) = create_links ( $ally, $player, $pub_galaxie, $system, $row );
    list ( $color_update, $changed, $last_statut ) = colorise ( $last_update, $changed );

    // Affichage des changements
    if ( $show === true ) {
      if ( $player == '' ) {
        print '<' . $td . ' style="text-align: left;' . $color . '"><a href="' . $link_galaxie . '">[' . $pub_galaxie . ':' . $system . ':' . $row . ']</a></' . $td . '>' . "\n";
      }
      else {
        if ( $ally != '' ) {
          if ( isset ( $allied ) && is_array ( $allied ) && in_array ( $ally, $allied ) )
            print '<' . $td . ' style="text-align: left;' . $color . '"><a href="' . $link_galaxie . '">[' . $pub_galaxie . ':' . $system . ':' . $row . ']</a> ' . $player . ' <br>TAG <blink>' . $link_ally . '</blink></' . $td . '>' . "\n";
          elseif ( isset ( $ally_protection ) && is_array ( $ally_protection ) && in_array ( $ally, $ally_protection ) )
            print '<' . $td . ' style="text-align: left;' . $color . '"><a href="' . $link_galaxie . '">[' . $pub_galaxie . ':' . $system . ':' . $row . ']</a> ' . $link_player . '<br>TAG <font color="lime">' . $link_ally . '</font></' . $td . '>' . "\n";
          else
            print '<' . $td . ' style="text-align: left;' . $color . '"><a href="' . $link_galaxie . '">[' . $pub_galaxie . ':' . $system . ':' . $row . ']</a> ' . $link_player . '<br>TAG ' . $link_ally . '</' . $td . '>' . "\n";
        }
        else
          print '<' . $td . ' style="text-align: left;' . $color . '"><a href="' . $link_galaxie . '">[' . $pub_galaxie . ':' . $system . ':' . $row . ']</a> ' . $link_player . '</' . $td . '>' . "\n";
      }
      print '<th>' . str_replace ( 'PseuDo', 'Pseudo', $changed ) . '<br>' . $color_update . date ( "d/m/Y", $last_update ) . $color_updated . '</th>' . "\n";
      $idx_system_shown++;
      $num_system_shown++;
      if ( ( $idx_system_shown % 3 ) != 0 )
        print '<td style="width: 15px;">&nbsp;</td>';
    }
    if ( $idx_system_shown > 0 && ( $idx_system_shown % 3 ) == 0 ) {
      print '  </tr>' . "\n";
      print '  <tr>' . "\n";
      $idx_system_shown = 0;
    }
  }
}
if ( $num_system_shown == 0 )
  print '<th class="c" align="center" colspan="8">Aucun r&eacute;sultat trouv&eacute; !</th>' . "\n";
else {
  print '  <tr>' . "\n";
  print '    <th class="c" colspan="8">&nbsp;</th>' . "\n";
  print '  </tr>' . "\n";
  print '  <tr>' . "\n";
  print '    <th class="c" align="center" colspan="8">' . $num_system_shown . ' r&eacute;sultat(s) trouv&eacute;(s) !</th>' . "\n";
  print '  </tr>' . "\n";
  print '  <tr>' . "\n";
  print '    <th style="text-align: left;" class="c">' . $num_statut . ' changement(s) de statut.</th>' . "\n";
  print '    <th style="text-align: left;" class="c">' . $num_lune . ' changement(s) de lune.</th>' . "\n";
  print '    <td>&nbsp;</td>' . "\n";
  print '    <th style="text-align: left;" class="c">' . $num_ally . ' changement(s) d\'alliance.</th>' . "\n";
  print '    <th style="text-align: left;" class="c">' . $num_PseuDo . ' changement(s) de pseudo.</th>' . "\n";
  print '    <td>&nbsp;</td>' . "\n";
  print '    <th style="text-align: left;" class="c">' . $num_planete . ' changement(s) de nom de Planète.</th>' . "\n";
  print '    <th style="text-align: left;" class="c">' . $num_colo . ' colonisation(s).</th>' . "\n";
  print '  </tr>' . "\n";
}

// Affichage du pied de page
?>
  </tr>
  <tr>
    <th class="c" colspan="8">&nbsp;</th>
  </tr>
  <tr>
    <th style="text-align: left;" class="c" colspan="2" rowspan="9">L&eacute;gende :</th>
    <td rowspan="9">&nbsp;</td>
    <th style="text-align: left;" class="c" colspan="2">(???)</th>
    <td>&nbsp;</td>
    <th style="text-align: left;" class="c" colspan="2">Changement de statut<br>
      (*) = plus de statut (sortie de MV, d&eacute;butant, inactif, blocage)</th>
  </tr>
  <tr>
    <th style="text-align: left;" class="c" colspan="2">Pseudo</th>
    <td>&nbsp;</td>
    <th style="text-align: left;" class="c" colspan="2">Changement de pseudo</th>
  </tr>
  <tr>
    <th style="text-align: left;" class="c" colspan="2">Planète</th>
    <td>&nbsp;</td>
    <th style="text-align: left;" class="c" colspan="2">Changement de nom de Planète</th>
  </tr>
  <tr>
    <th style="text-align: left;" class="c" colspan="2">Lune</th>
    <td>&nbsp;</td>
    <th style="text-align: left;" class="c" colspan="2">Nouvelle lune / destruction de lune</th>
  </tr>
  <tr>
    <th style="text-align: left;" class="c" colspan="2">Ally</th>
    <td>&nbsp;</td>
    <th style="text-align: left;" class="c" colspan="2">Changement d'alliance</th>
  </tr>
  <tr>
    <th class="c" style="text-align: left;" colspan="2"><font color="#FF2A00">Date</font></th>
    <td>&nbsp;</td>
    <th class="c" style="text-align: left;" colspan="2">Mise à jour de moins de 24h</th>
  </tr>
  <tr>
    <th class="c" style="text-align: left;" colspan="2"><font color="#FFAA2A">Date</font></th>
    <td>&nbsp;</td>
    <th class="c" style="text-align: left;" colspan="2">Mise à jour de moins de 48h</th>
  </tr>
  <tr>
    <th class="c" style="text-align: left;" colspan="2"><font color="#FFFF2A">Date</font></th>
    <td>&nbsp;</td>
    <th class="c" style="text-align: left;" colspan="2">Mise à jour de moins de 72h</th>
  </tr>
  <tr>
    <th class="c" style="text-align: left;" colspan="2"><font color="#FFFFFF">Date</font></th>
    <td>&nbsp;</td>
    <th class="c" style="text-align: left;" colspan="2">Mise à jour de plus de 72h</th>
  </tr>
  <tr>
    <th class="c" colspan="8">&nbsp;</th>
  </tr>
  <tr>
    <th class="c" colspan="8" align="center">La recherche par "Centrer la vue" affiche les syst&egrave;mes (n-<?php print round($system_per_page/2) ?>) &agrave; (n+<?php echo floor($system_per_page/2) ?>) autour du syst&egrave;me demand&eacute;.</th>
  </tr>
</table>