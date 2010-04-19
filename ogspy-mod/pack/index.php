<?php
/**
* index.php
* @package <nom du mod>
* @author <votre pseudo>
* @version 1.0
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier principal du mod
*/
if ( ! defined ( 'IN_SPYOGAME' ) ) die ( 'Hacking attempt' );

if ( isset ( $pub_directory ) )
{
  if ( file_exists ( 'mod/' . $pub_directory . '/version.txt' ) )
    $chemin_du_script = $pub_directory;
    
}
elseif ( isset ( $pub_action ) )
{
  if ( file_exists ( 'mod/' . $pub_action . '/version.txt' ) )
    $chemin_du_script = $pub_action;
}
else
{
  if ( isset ( $_SERVER['PHP_SELF'] ) && file_exists ( 'mod/' . substr ( $_SERVER['PHP_SELF'], 0, strrpos ( '/', $_SERVER['PHP_SELF'] ) ) . '/version.txt' ) )
    $chemin_du_script = substr ( $_SERVER['PHP_SELF'], 0, strrpos ( '/', $_SERVER['PHP_SELF'] ) );
  elseif ( isset ( $PHP_SELF ) && file_exists ( 'mod/' . substr ( $PHP_SELF, 0, strrpos ( '/', $PHP_SELF ) ) . '/version.txt' ) )
    $chemin_du_script = substr ( $PHP_SELF, 0, strrpos ( '/', $PHP_SELF ) );
}
include_once ( 'mod/' . $chemin_du_script . '/include.php' );
?>
<table border="2" cellpadding="0" cellspacing="0">
  <tr>
    <th><?php print ( isset ( $pub_subaction ) ) ? '<a href="index.php?action=' . NOM_MOD . '">Utiliser le mod</a>':'Utiliser le mod' ?></th>
    <th><?php print ( ! isset ( $pub_subaction ) || $pub_subaction != 'changelog' ) ? '<a href="index.php?action=' . NOM_MOD . '&subaction=changelog">ChangeLog</a>':'ChangeLog' ?></th>
  </tr>
  <tr>
    <td colspan="2"><?php
if ( isset ( $pub_subaction ) )
{
  switch ( $pub_subaction )
  {
    case 'changelog':
      include_once ( './mod/' . NOM_MOD . '/' . $pub_subaction . '.php' );
      break;
    default:
      die ( 'Hacking attempt' );
  }
}
else
{
?>

<!-- Ici la page d'accueil du mod en HTML pur, le code php devant être entouré des balises <?php puis ?> -->

<?php
} // fin du else
?>
</table>