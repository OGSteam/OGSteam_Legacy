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
$content = ob_get_contents();
ob_clean();

// Creation du template
if (file_exists($user_data['user_skin'].'\templates\index.tpl'))
{
    $tpl_index = new template($user_data['user_skin'].'\templates\index.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\index.tpl'))
{
    $tpl_index = new template($server_config['default_skin'].'\templates\index.tpl');
}
else
{
    $tpl_index = new template('index.tpl');
}

// Header
if (!isset($link_css) || empty($link_css)) $link_css = $server_config["default_skin"];
// Custom CSS for mods or other page
if (!isset($custom_css) || empty($custom_css)) $custom_css = "./css/fake.css";

// Simples variables texte
$tpl_index->simpleVar(array(
	'SERVER_NAME'		=> $server_config["servername"]." - OGSpy ".$server_config["version"],
	'LINK_CSS'			=> $link_css,
	'LANG'				=> strtoupper(get_user_language()),
	'LANG_LOWERCASE'	=> get_user_language(),
	'BANNER'			=> $banner_selected,
	'CUSTOM_CSS'		=> $custom_css
));


/* Menu ? */

// CSS - 1/3
$headerId	= 'header-no-menu';
$contentId	= 'content-no-menu';
$footerId	= 'footer-no-menu';

if(!defined('NO_MENU'))
{
	// CSS - 2/3
	$headerId	= 'header';
	$contentId	= 'content';
	$footerId	= 'footer';
	
	$tpl_index->CheckIf('show_menu', true);
	require_once(translated('menu.php'));
}

// CSS - 3/3
$tpl_index->simpleVar(array(
	'HEADER_ID'		=> $headerId,
	'CONTENT_ID'	=> $contentId,
	'FOOTER_ID'		=> $footerId
));


// Tail
lang_load_page("page_tail");
$php_end = benchmark();
$php_timing = $php_end - $php_start - $sql_timing;
$db->sql_close(); // fermeture de la connexion à la base de données 

// Traitement des conditions
if (is_array($ogspy_phperror) && count($ogspy_phperror)){ // Si oui, peuplement du tableau
	$tpl_index->checkIf('phperror',true);
	foreach($ogspy_phperror as $line) 
		$tpl_index->loopVar('phperror',array('line' => $line));
}

// Simples variables texte
$tpl_index->simpleVar(Array(
	'SERVER_NAME' => $server_config["servername"]." - OGSpy ".$server_config["version"],
	'COPYRIGHT_LINK' => 'http://ogsteam.fr',
	'COPYRIGHT' => L_("pagetail_Copyright"),
	'VERSION' => "v".$server_config["version"],
	'TIME' => L_("Time_generation", round($php_timing+$sql_timing, 3), round($php_timing, 3), round($sql_timing, 3))
));


// Débug ?
if(MODE_DEBUG&&!isset($pub_ajax)){
	$debug = $debug_tpl->parse('return');
	$tpl_index->checkIf('DEBUG_ON_TOP',DEBUG_ON_TOP);
}

// Traitement et affichage du template
$tpl_index->simpleVar(Array(
	'MENU' => isset($menu)?$menu:'ERROR',
	'CONTENT' => isset($content)?$content:'ERROR',
	'DEBUG' => isset($debug)?$debug:'',
));
	
$tpl_index->parse();

?>