<?php
/** $Id$ **/
/**
* 
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
ob_start();
/*
if ($link_css == "") $link_css = $server_config["default_skin"];

// Creation du template
$tpl = new template('page_header.tpl');

// Simples variables texte
$tpl->simpleVar(Array(
	'SERVER_NAME' => $server_config["servername"]." - OGSpy ".$server_config["version"],
	'LINK_CSS' => $link_css
));

// Traitement et affichage du template
$tpl->parse();

require_once(translated("menu.php"));//*/
?>
