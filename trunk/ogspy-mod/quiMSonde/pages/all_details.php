<?php
/**
 * spy_list.php 

Affiche la liste des espionnages

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Pour savoir qui affiche la page
global $user_data;

$pub_viewall = 1;
include("own_details.php");
?>