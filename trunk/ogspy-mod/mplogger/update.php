<?php
/**
 * update.php 

Script de mise à jour

 * @package MP_Logger
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 0.1
 * dernière modification : 16.10.07
 * Module de capture des messages entre joueurs
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$mod_folder = "mplogger";
$mod_name = "mp_logger";
update_mod($mod_folder,$mod_name);
?>