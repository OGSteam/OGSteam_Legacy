<?php
/**
* include.php
* @package <nom du mod>
* @author <votre pseudo>
* @version 1.0
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier de d�finition des constantes et des fonctions du mod
*/
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

// D�finition des constantes et des variables globales

$file = file ( 'mod/' . $chemin_du_script . '/version.txt' );
global $db, $table_prefix, $server_config;
define ( 'NOM_MOD', trim ( $file[0] ) );
define ( 'VERSION_MOD', trim ( $file[1] ) );
define ( 'TABLE_MOD_PCP', $table_prefix . NOM_MOD );

// Fonctions utilis�es dans le mod

/**
* Fonction de test � vis�e illustrative
* La documentation de la fonction peut prendre la place qu'elle souhaite sur plusieurs lignes si besoin
* @author <pseudo de l'auteur>
* @version 1.0
* @param string $test Le param�tre $test est une chaine
* @param boolean $test2 Le param�tre $test2 est un boolean true/false
* @return boolean La fonction retourne un bool�en true/false
*/

function MaFonction ( $test, $test2 )
{
  global $db, $server_config;
  return true;
}
?>