<?php
/**
* include.php
* @package CalculRessources
* @author varius9
* @version 1.0
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier de définition des constantes et des fonctions du mod
*/
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

// Définition des constantes et des variables globales

$file = file ( 'mod/CalculRessources/version.txt' );
global $db, $table_prefix, $server_config;
define ( 'NOM_MOD', trim ( $file[0] ) );
define ( 'VERSION_MOD', trim ( $file[1] ) );
define ( 'TABLE_MOD_PCP', $table_prefix . NOM_MOD );

/**
* La documentation de la fonction peut prendre la place qu'elle souhaite sur plusieurs lignes si besoin
* @author varius9
* @version 1.0
*/

?>