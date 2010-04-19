<?php
/**
* update.php
* @package <nom du mod>
* @author <votre pseudo>
* @version 1.0
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier de mise � jour du mod
*/
if ( ! defined ( 'IN_SPYOGAME' ) ) die ( 'Hacking attempt' );

/**
*
* Fonction de mise � jour du mod
* N'accepte aucun param�tre
*
* @return boolean La fonction retourne un bool�en true/false pour indiquer la r�ussite ou l'�chec de la mise � jour
*/
function UpdateMonMod ()
{
  global $db;
  
  // Ins�rez ici vos modifications sur la table du mod
  $query = 'ALTER ' . TABLE_MOD_PCP ' ADD <mon_champ> CHAR(5) NOT NULL DEFAULT "foo"';
  if ( $db->sql_query ( $query ) )
    return true;
  else
    return false;
}

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
  if ( isset ( $_SERVER['PHP_SELF'] ) && file_exists ( substr ( $_SERVER['PHP_SELF'], strpos ( '/', $_SERVER['PHP_SELF'] ) + 1, strrpos ( '/', $_SERVER['PHP_SELF'] ) ) . '/version.txt' ) )
    $chemin_du_script = substr ( $_SERVER['PHP_SELF'], strpos ( '/', $_SERVER['PHP_SELF'] ) + 1, strrpos ( '/', $_SERVER['PHP_SELF'] ) );
  elseif ( isset ( $PHP_SELF ) && file_exists ( 'mod/' . substr ( $PHP_SELF, strpos ( '/', $PHP_SELF ) + 1, strrpos ( '/', $PHP_SELF ) ) . '/version.txt' ) )
    $chemin_du_script = substr ( $PHP_SELF, strpos ( '/', $PHP_SELF ) + 1, strrpos ( '/', $PHP_SELF ) );
}
include_once ( 'mod/' . $chemin_du_script . '/include.php' );

if ( UpdateMonMod() )
{
  $query = 'UPDATE ' . TABLE_MOD . ' SET version = \'' . VERSION_MOD . '\' WHERE `action` = \'' . $chemin_du_script . '\'';
  $db->sql_query ( $query );
}
else
{
  print '<h2 style="font-color; red;">Erreur lors de la mise � jour du mod ! Veuillez r�essayer ou consulter le forum http://ogsteam.fr pour r�soudre le probl�me !</h2>';
}
?>