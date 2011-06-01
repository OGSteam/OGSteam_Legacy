<?php
/*
* index.php
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
if ( !defined ( 'IN_SPYOGAME' ) )
   die ( 'Hacking attempt' );

define ( 'IN_ZONECHECK', true );

$query = 'SELECT `root` FROM `' . TABLE_MOD . '` WHERE `action`="zonecheck" AND `active`=1 LIMIT 1';
if ( !$db->sql_numrows ( $db->sql_query ( $query ) ) )
  die ( 'Hacking attempt' );
list ( $root ) = $db->sql_fetch_row ( $db->sql_query ( $query ) );

include_once ( './mod/' . $root . '/include.php' );

if ( isset ( $pub_affiche ) && $pub_affiche != '' ) $affiche = $pub_affiche;

// En-tête de page
require_once ( 'views/page_header.php' );
?>
<script language="javascript">
<!--
function affiche_all()
{
  var max_len = document.affichage.elements.length;
  var aff_checked = "";
  for ( var idx=0; idx < max_len; idx++ ) {
    if ( document.affichage.elements[idx].type == "checkbox" ) {
      document.affichage.elements[idx].checked = true;
      aff_checked = aff_checked + document.affichage.elements[idx].value + "|";
    }
  }
  aff_checked = aff_checked.substring(0,aff_checked.length-1);
  document.affichage.affiche.value = aff_checked;
}
function update_affichage( myForm )
{
  var max_len = document.affichage.elements.length;
  var aff_checked = "";
  for ( var idx=0; idx < max_len; idx++ ) {
    if ( document.affichage.elements[idx].type == "checkbox" && document.affichage.elements[idx].checked == true ) {
      aff_checked = aff_checked + document.affichage.elements[idx].value + "|";
    }
  }
  aff_checked = aff_checked.substring(0,aff_checked.length-1);
  myForm.affiche.value = aff_checked;
}
function change_planete()
{
  var planete = document.choix_planete.planete.options[document.choix_planete.planete.options.selectedIndex].value;
  tmp = planete.split(":");
  document.choix_planete.galaxie.value = tmp[0];
  document.choix_planete.systeme.value = tmp[1] - <?php print $system_per_page / 2 ?>;
  update_affichage(document.choix_planete);
  document.choix_planete.submit();
}
-->
</script>
<table>
  <tr align="center">
    <td class="c" width="150" onclick="javascript: window.location.href='index.php?action=<?php print $pub_action; ?>&subaction=zonecheck';"><a style="cursor:pointer"><font color="lime">ZoneCheck</font></a></td>
    <td class="c" width="150" onclick="javascript: window.location.href='index.php?action=<?php print $pub_action; ?>&subaction=historique';"><a style="cursor:pointer"><font color="lime">Historique des changements de pseudo</font></a></td>
    <td class="c" width="150" onclick="javascript: window.location.href='index.php?action=<?php print $pub_action; ?>&subaction=changelog';"><a style="cursor:pointer"><font color="lime">Changelog</font></a></td>
    <?php print ( $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 ) ? '<td class="c" width="150" onclick="javascript: window.location.href=\'index.php?action=' . $pub_action . '&subaction=administration\';"><a style="cursor:pointer"><font color="lime">Administration</font></a></td>':'' ?>
  </tr>
</table>
<?php
if ( ! isset ( $pub_subaction ) )
  $pub_subaction = 'zonecheck';
switch ( $pub_subaction )
{
  case 'administration':
    if ( $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 )
      include_once 'admin.php';
    else
      include_once 'zonecheck.php';
    break;
  case 'changelog':
    include_once 'changelog.php';
    break;
  case 'historique':
    include_once 'historique.php';
    break;
  default:
    include_once 'zonecheck.php';
    break;
}
//Récupére le numéro de version du mod
print '<p><div>ZoneCheck (v' . mod_version() . ') cr&eacute;&eacute; par Gorn pour StationMyr</div></p>';
require_once("views/page_tail.php");
?>