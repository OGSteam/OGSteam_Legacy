<?php
/*
* admin.php
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

if ( $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 )
  redirection ( 'index.php?action=' . $pubaction );

if ( isset ( $pub_valider ) )
{
  if ( ! defined ( 'TABLE_MOD_CFG' ) )
  {
    $query = 'TRUNCATE ' . TABLE_MOD_ZONECHECK_CFG;
    $db->sql_query ( $query );
    $query = 'INSERT INTO ' . TABLE_MOD_ZONECHECK_CFG . ' VALUES ( ' . $pub_system_per_page . ', 
      "' . $pub_color_block . '", 
      "' . $pub_color_moon . '", 
      "' . $pub_color_deco . '", 
      "' . $pub_color_vac . '", 
      "' . $pub_color_inactif . '", 
      "' . $pub_color_unstatus . '", 
      "' . $pub_color_colo . '", 
      "' . $pub_color_date_less . '", 
      "' . $pub_color_date_middle . '", 
      "' . $pub_color_date_more . '", 
      "' . $pub_color_date_out . '", 
      "' . addslashes ( $pub_affiche ) . '" )';
    $db->sql_query ( $query );
  }
  else
  {
    $query = 'DELETE FROM ' . TABLE_MOD_CFG . ' WHERE `mod` = "ZoneCheck"';
    $db->sql_query ( $query );
    $query = 'INSERT IGNORE INTO ' . TABLE_MOD_CFG . ' VALUES ( "ZoneCheck", "nb_system", ' . $pub_system_per_page . ' ), 
      ( "ZoneCheck", "block", "' . $pub_color_block . '" ), 
      ( "ZoneCheck", "moon", "' . $pub_color_moon . '" ), 
      ( "ZoneCheck", "deco", "' . $pub_color_deco . '" ), 
      ( "ZoneCheck", "vac", "' . $pub_color_vac . '" ), 
      ( "ZoneCheck", "inactif", "' . $pub_color_inactif . '" ), 
      ( "ZoneCheck", "unstatus", "' . $pub_color_unstatus . '" ), 
      ( "ZoneCheck", "colo", "' . $pub_color_colo . '" ), 
      ( "ZoneCheck", "less", "' . $pub_color_date_less . '" ), 
      ( "ZoneCheck", "middle", "' . $pub_color_date_middle . '" ), 
      ( "ZoneCheck", "more", "' . $pub_color_date_more . '" ), 
      ( "ZoneCheck", "outofdate", "' . $pub_color_date_out . '" ), 
      ( "ZoneCheck", "affichage", "' . addslashes ( $pub_affiche ) . '" )';
    $db->sql_query ( $query );
  }
  print '<p>Configuration mise à jour avec succès.</p>' . "\n";
  $system_per_page = $pub_system_per_page;
  $color_block = $pub_color_block;
  $color_moon = $pub_color_moon;
  $color_deco = $pub_color_deco;
  $color_vac = $pub_color_vac;
  $color_inactif = $pub_color_inactif;
  $color_unstatus = $pub_color_unstatus;
  $color_colo = $pub_color_colo;
  $color_date_less = $pub_color_date_less;
  $color_date_middle = $pub_color_date_middle;
  $color_date_more = $pub_color_date_more;
  $color_date_out = $pub_color_date_out;
  $affiche = addslashes ( $pub_affiche ) ;
}
?>
<script language="javascript">
function affiche_all()
{
  var myForm = document.configure;
  var max_len = myForm.elements.length;
  var aff_checked = "";
  for ( var idx=0; idx < max_len; idx++ ) {
    elemName = myForm.elements[idx].name;
    if ( elemName.substring(0,4) == 'aff_' ) {
      myForm.elements[idx].checked = true;
      aff_checked = aff_checked + myForm.elements[idx].value + "|";
    }
  }
  aff_checked = aff_checked.substring(0,aff_checked.length-1);
  myForm.affiche.value = aff_checked;
}
function update_affichage()
{
  var myForm = document.configure;
  var max_len = myForm.elements.length;
  var aff_checked = "";
  for ( var idx=0; idx < max_len; idx++ ) {
    elemName = myForm.elements[idx].name;
    if ( elemName.substring(0,4) == "aff_" && myForm.elements[idx].checked == true ) {
      aff_checked = aff_checked + myForm.elements[idx].value + "|";
    }
  }
  aff_checked = aff_checked.substring(0,aff_checked.length-1);
  myForm.affiche.value = aff_checked;
}
function verif_saisie(){
  var reg_color = /^#[a-z0-9]{6}$/gi;
  var reg_system = /^[0-9]{2,3}$/g;
  var myForm = document.configure;
  var system_per_page = myForm.system_per_page.value;
  if ( system_per_page == "" || !system_per_page.match(reg_system) )
  {
    alert ('Vous devez indiquer un nombre de système valide !');
    myForm.system_per_page.value = "";
    myForm.system_per_page.focus();
    return false;
  }
  var color_block = myForm.color_block.value;
  if ( color_block == "" || !color_block.match(reg_color) )
  {
    alert ('Vous devez indiquer une couleur héxadécimale valide pour les joueurs bloqués !');
    myForm.color_block.value = "";
    myForm.color_block.focus();
    return false;
  }
  var color_moon = myForm.color_moon.value;
  if ( color_moon == "" || !color_moon.match(reg_color) )
  {
    alert ('Vous devez indiquer une couleur héxadécimale valide pour les lunes !');
    myForm.color_moon.value = "";
    myForm.color_moon.focus();
    return false;
  }
  var color_deco = myForm.color_deco.value;
  if ( color_deco == "" || !color_deco.match(reg_color) )
  {
    alert ('Vous devez indiquer une couleur héxadécimale valide pour les décolonisations !');
    myForm.color_deco.value = "";
    myForm.color_deco.focus();
    return false;
  }
  var color_vac = myForm.color_vac.value;
  if ( color_vac == "" || !color_vac.match(reg_color) )
  {
    alert ('Vous devez indiquer une couleur héxadécimale valide pour les joueurs en mode vacance !');
    myForm.color_vac.value = "";
    myForm.color_vac.focus();
    return false;
  }
  var color_inactif = myForm.color_inactif.value;
  if ( color_inactif == "" || !color_inactif.match(reg_color) )
  {
    alert ('Vous devez indiquer une couleur héxadécimale valide pour les joueurs inactifs !');
    myForm.color_inactif.value = "";
    myForm.color_inactif.focus();
    return false;
  }
  var color_unstatus = myForm.color_unstatus.value;
  if ( color_unstatus == "" || !color_unstatus.match(reg_color) )
  {
    alert ('Vous devez indiquer une couleur héxadécimale valide pour les joueurs sans statut !');
    myForm.color_unstatus.value = "";
    myForm.color_unstatus.focus();
    return false;
  }
  var color_colo = myForm.color_colo.value;
  if ( color_colo == "" || !color_colo.match(reg_color) )
  {
    alert ('Vous devez indiquer une couleur héxadécimale valide pour les colonisations !');
    myForm.color_colo.value = "";
    myForm.color_colo.focus();
    return false;
  }
  var color_date_less = myForm.color_date_less.value;
  if ( color_date_less == "" || !color_date_less.match(reg_color) )
  {
    alert ('Vous devez indiquer une couleur héxadécimale valide pour les dates inférieures à 24h !');
    myForm.color_date_less.value = "";
    myForm.color_date_less.focus();
    return false;
  }
  var color_date_middle = myForm.color_date_middle.value;
  if ( color_date_middle == "" || !color_date_middle.match(reg_color) )
  {
    alert ('Vous devez indiquer une couleur héxadécimale valide pour les dates entre 24 et 48h !');
    myForm.color_date_middle.value = "";
    myForm.color_date_middle.focus();
    return false;
  }
  var color_date_more = myForm.color_date_more.value;
  if ( color_date_more == "" || !color_date_more.match(reg_color) )
  {
    alert ('Vous devez indiquer une couleur héxadécimale valide pour les dates entre 48 et 72h !');
    myForm.color_date_more.value = "";
    myForm.color_date_more.focus();
    return false;
  }
  var color_date_out = myForm.color_date_out.value;
  if ( color_date_out == "" || !color_date_out.match(reg_color) )
  {
    alert ('Vous devez indiquer une couleur héxadécimale valide pour les dates supérieures à 72h !');
    myForm.color_date_out.value = "";
    myForm.color_date_out.focus();
    return false;
  }
  update_affichage();
  return true;
}
</script>
<h2 align="center">Administration de <?php print $pub_action ?></h2>
<form name="configure" action="index.php" method="POST" onsubmit="javascript: return verif_saisie();">
<input type="hidden" name="action" value="<?php print $pub_action ?>">
<input type="hidden" name="subaction" value="<?php print $pub_subaction ?>">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th nowrap>Nombre de syst&egrave;mes affich&eacute;s par page :</th>
    <td nowrap><input type="text" name="system_per_page" length="3" maxlength="3" value="<?php print $system_per_page ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th nowrap>Couleur d'affichage des joueurs bloqu&eacute;s :</th>
    <td nowrap><input type="text" name="color_block" length="7" maxlength="7" value="<?php print $color_block ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th nowrap>Couleur d'affichage des lunes :</th>
    <td nowrap><input type="text" name="color_moon" length="7" maxlength="7" value="<?php print $color_moon ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th nowrap>Couleur d'affichage des d&eacute;colonisations :</th>
    <td nowrap><input type="text" name="color_deco" length="7" maxlength="7" value="<?php print $color_deco ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th nowrap>Couleur d'affichage des joueurs en mode vacance :</th>
    <td nowrap><input type="text" name="color_vac" length="7" maxlength="7" value="<?php print $color_vac ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th nowrap>Couleur d'affichage des inactifs :</th>
    <td nowrap><input type="text" name="color_inactif" length="7" maxlength="7" value="<?php print $color_inactif ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th nowrap>Couleur d'affichage des joueurs sans status :</th>
    <td nowrap><input type="text" name="color_unstatus" length="7" maxlength="7" value="<?php print $color_unstatus ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th nowrap>Couleur d'affichage des colonisations :</th>
    <td nowrap><input type="text" name="color_colo" length="7" maxlength="7" value="<?php print $color_colo ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th nowrap>Couleur d'affichage des dates inf&eacute;rieures &agrave; 24h :</th>
    <td nowrap><input type="text" name="color_date_less" length="7" maxlength="7" value="<?php print $color_date_less ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th nowrap>Couleur d'affichage des dates entre 24h et 48h :</th>
    <td nowrap><input type="text" name="color_date_middle" length="7" maxlength="7" value="<?php print $color_date_middle ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th nowrap>Couleur d'affichage des dates entre 48 et 72h :</th>
    <td nowrap><input type="text" name="color_date_more" length="7" maxlength="7" value="<?php print $color_date_more ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th nowrap>Couleur d'affichage des dates sup&eacute;rieures &agrave; 72h :</th>
    <td nowrap><input type="text" name="color_date_out" length="7" maxlength="7" value="<?php print $color_date_out ?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th valign="middle">Choix de l'affichage par défaut :<br /><br /><input type="button" value="Tout cocher" onclick="javascript: affiche_all()"></th>
    <th nowrap style="text-align: left;"><input type="checkbox" name="aff_little_inactifs" value="inactif"<?php if ( !empty ( $affiche ) && preg_match ( '/inactif/', stripslashes ( $affiche ) ) ) print ' checked' ?>>Inactifs 7 jours<br />
      <input type="checkbox" name="aff_big_inactifs" onclick="javascript: update_affichage()" value="I"<?php if ( !empty ( $affiche ) && preg_match ( '/I/', stripslashes ( $affiche ) ) ) print ' checked' ?>>Inactifs 28 jours<br />
      <input type="checkbox" name="aff_debut" onclick="javascript: update_affichage()" value="d"<?php if ( !empty ( $affiche ) && preg_match ( '/d/', stripslashes ( $affiche ) ) ) print ' checked' ?>>D&eacute;butants<br />
      <input type="checkbox" name="aff_vac" onclick="javascript: update_affichage()" value="v"<?php if ( !empty ( $affiche ) && preg_match ( '/v/', stripslashes ( $affiche ) ) ) print ' checked' ?>>Mode vacances<br />
      <input type="checkbox" name="aff_block" onclick="javascript: update_affichage()" value="b"<?php if ( !empty ( $affiche ) && preg_match ( '/b/', stripslashes ( $affiche ) ) ) print ' checked' ?>>Bloqu&eacute;s<br />
      <input type="checkbox" name="aff_pseudo" onclick="javascript: update_affichage()" value="PseuDo"<?php if ( !empty ( $affiche ) && preg_match ( '/PseuDo/', stripslashes ( $affiche ) ) ) print ' checked' ?>>Changements de pseudo<br />
      <input type="checkbox" name="aff_ally" onclick="javascript: update_affichage()" value="Ally"<?php if ( !empty ( $affiche ) && preg_match ( '/Ally/', stripslashes ( $affiche ) ) ) print ' checked' ?>>Changements d'alliance<br />
      <input type="checkbox" name="aff_planete" onclick="javascript: update_affichage()" value="Planète"<?php if ( !empty ( $affiche ) && preg_match ( '/Planète/', stripslashes ( $affiche ) ) ) print ' checked' ?>>Renommages de planète<br />
      <input type="checkbox" name="aff_moon" onclick="javascript: update_affichage()" value="Lune"<?php if ( !empty ( $affiche ) && preg_match ( '/Lune/', stripslashes ( $affiche ) ) ) print ' checked' ?>>Nouvelle lune / Suppression de lune<br />
      <input type="checkbox" name="aff_colo" onclick="javascript: update_affichage()" value="Colonisation"<?php if ( !empty ( $affiche ) && preg_match ( '/Colonisation/', stripslashes ( $affiche ) ) ) print ' checked' ?>>Colonisations<br />
      <input type="checkbox" name="aff_deco" onclick="javascript: update_affichage()" value="Décolonisation"<?php if ( !empty ( $affiche ) && preg_match ( '/Décolonisation/', stripslashes ( $affiche ) ) ) print ' checked' ?>>D&eacute;colonisations
      <input type="hidden" name="affiche" value=""></th>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="2" align="center" nowrap><input type="submit" name="valider" onclick="javascript: return verif_saisie()" value="Sauvegarder la configuration"></th>
  </tr>
</table>
</form>
<p>Attention, toutes les couleurs doivent être notées au format RGB en héxadécimal (#??????) !</p>
<p>Voici un tableau pour vous aider à trouver le code héxadécimal voulu :</p>
<p align="center"><table border="1" cellpadding="0" cellspacing="0">
<?php
$hex_Red = array ( "00", "33", "66", "99", "CC", "FF");
$hex_Green = array ( "00", "33", "66", "99", "CC", "FF");
$hex_Blue = array ( "00", "33", "66", "99", "CC", "FF");
$red = 0;
$green = 0;
$blue = 0;
$y = 0;
$xyz = 0;

while ( $y < 6 )
{
  print '<tr>' . "\n";
  $x = 0;
  $hexblue = $hex_Blue[$blue];
  while ( $x < 6 )
  {
    $z = 0;
    $hexgreen = $hex_Green[$green];
    while ( $z < 6 )
    {
      $hexred = $hex_Red[$red];
      $hexadecimal = "#" . $hexred . $hexgreen . $hexblue;
      print '<td style="background: ' . $hexadecimal . ';cursor: pointer;" onclick="document.getElementsByName(\'hex_color\')[0].value=\'' . $hexadecimal . '\';">&nbsp;&nbsp;&nbsp;&nbsp;</td>' . "\n";
      $z++;
      $red++;
      if ( $red == 6 )
      {
        $red = 0;
      }
    }
    $x++;
    $green++;
    if ( $green == 6 )
    {
      $green = 0;
    }
    $xyz++;
    if ( $xyz == 3 )
    {
      print '</tr>' . "\n";
      $xyz = 0;
    }
  }
  $y++;
  $blue++;
  if ( $blue == 6 )
  {
    $blue = 0;
  }
}
?>
</table></p>
<p><center><input type="text" name="hex_color" size="7" readonly></center></p>