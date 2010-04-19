<?php
/**
* REstyler.php page principale de modREstyler
* @package modREstyler
* @author oXid_FoX
* @link http://www.ogsteam.fr
*	created		: 14/10/2006 12:44:33
*/

if (!defined('IN_SPYOGAME')) die('Hacking attempt');

// on démarre la bufferisation (besoin d'envoyer une feuille de style)
ob_start();
require_once('views/page_header.php');

$query = 'SELECT `active` FROM `'.TABLE_MOD.'` WHERE `action`=\''.$pub_action.'\' AND `active`=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Mod désactivé !');

// récupération du buffer
$buffer = ob_get_contents();
// vide tous les buffers, et stoppe la bufferisation
while (@ob_end_clean());
// rajoute le CSS de ColorPicker
echo str_replace('</head>','<link rel="stylesheet" type="text/css" href="mod/modREstyler/ColorPicker/ColorPicker.css">'."\n".'<style type="text/css">input { text-align: center; vertical-align: middle; } li { text-align: left; } fieldset { border: 1px solid; }</style></head>',$buffer);

// définition du dossier d'inclusion (pour la compatibilité avec REstyler)
define('DOSSIER_INCLUDE','mod/modREstyler');

// mise à défaut des $pub_
if (!isset($pub_subaction)) $pub_subaction = '';

switch ($pub_subaction) {
// voir le changelog
case 'changelog':
	require DOSSIER_INCLUDE.'/changelog.php';
	break;
// par défaut, on affichera la page de traitement
default:
	require DOSSIER_INCLUDE.'/index.php';
}

require_once 'views/page_tail.php';

?>
