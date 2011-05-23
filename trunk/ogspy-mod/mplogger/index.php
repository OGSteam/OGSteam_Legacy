<?php
/**
 * index.php 

Page principale du mod

 * @package MP_Logger
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 0.1
 * dernière modification : 16.10.07
 * Module de capture des messages entre joueurs
 */
if (!defined('IN_SPYOGAME')) die("Hacking attempt");		// L'appel direct est interdit
require_once("views/page_header.php");						// Menu OGSpy
include("mpl_functions.php");										// Fonctions
$page=do_menu($pub_page,$pub_action);					// Menu
require_once("$page.php");										// Contenu de la page
require_once("views/page_tail.php");								// Insertion du bas de page d'OGSpy
?>