<?php
/*
* historique.php
* @mod ZoneCheck
* @author Gorn
* @fileversion 2.5
*
* 0 = pas de changement
* 1 = status
* 2 = lune
* 4 = alliance
* 8 = nom
* 16 = plan&egrave;te
* 32 = colonisation
*/

// Sécurité
if ( !defined ( 'IN_SPYOGAME' ) || !defined ( 'IN_ZONECHECK' ) )
   die ( 'Hacking attempt' );
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr><form name="historique" method="post" action="index.php">
    <input type="hidden" name="action" value="<?php print $pub_action; ?>">
    <input type="hidden" name="subaction" value="<?php print $pub_subaction; ?>">
    <td>Afficher l'historique de </td>
    <td><select name="historique">
<?php
$query = 'SELECT DISTINCT newname FROM ' . TABLE_MOD_ZONECHECK_HST . ' WHERE type="P" ORDER BY newname, date DESC';
$result = $db->sql_query ( $query );
while ( $row =  $db->sql_fetch_row ( $result ) )
{
  print '<option value="' . addslashes ( $row[0] ) . '"';
  if ( isset ( $pub_historique ) && $row[0] == $pub_historique ) print ' selected';
  print '>' . $row[0] . '</option>' . "\n";
}
?>
    </select></td>
    <td><input type="submit" value="Afficher"></td>
  </form></tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
<?php
if ( isset ( $pub_historique ) )
{
  $aff_name_histo = false;
  $query = 'SELECT newname, oldname, ally, date FROM ' . TABLE_MOD_ZONECHECK_HST . ' WHERE newname="' . $pub_historique . '" AND type="P"';
  $result = $db->sql_query ( $query );
  if ( mysql_num_rows ( $result ) > 0 )
  {
    $aff_name_histo = true;
    print '  <tr>
    <td>Ancien pseudo</td>
    <td>Nouveau pseudo</td>
    <td>Alliance</td>
    <td>Date de la d&eacute;tection</td>
  </tr>';
  }
  else
    print '  <tr><td>Aucun historique pour ce joueur</td></tr>';
  while ( $aff_name_histo === true )
  {
    list ( $newname, $oldname, $ally, $timestamp ) = $db->sql_fetch_row ( $result );
?>
  <tr>
    <td><?php print $oldname; ?></td>
    <td><?php print $newname; ?></td>
    <td><?php print $ally; ?></td>
    <td><?php print date ( 'd/m/Y', $timestamp ); ?></td>
  </tr>
<?php
    $aff_name_histo = false;
    $query = 'SELECT newname, oldname, ally, date FROM ' . TABLE_MOD_ZONECHECK_HST . ' WHERE newname="' . $oldname . '" AND type="P"';
    $result = $db->sql_query ( $query );
    if ( mysql_num_rows ( $result ) > 0 )
      $aff_name_histo = true;
  }
}
?>
</table>