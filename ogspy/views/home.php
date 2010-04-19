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

require_once("views/page_header.php");

// Creation des templates
if (file_exists($user_data['user_skin'].'\templates\home_header.tpl'))
{
    $tpl_header = new template($user_data['user_skin'].'\templates\home_header.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\home_header.tpl'))
{
    $tpl_header = new template($server_config['default_skin'].'\templates\home_header.tpl');
}
else
{
    $tpl_header = new template('home_header.tpl');
}

if (file_exists($user_data['user_skin'].'\templates\home_footer.tpl'))
{
    $tpl_footer = new template($user_data['user_skin'].'\templates\home_footer.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\home_footer.tpl'))
{
    $tpl_footer = new template($server_config['default_skin'].'\templates\home_footer.tpl');
}
else
{
    $tpl_footer = new template('home_footer.tpl');
}

// Options des menus
$menu_item = Array(
	'empire' => L_("home_empire"),
	'simulation' => L_("home_Simulation"),
	//'spy' => L_("home_spyreports"),
	'stat' => L_("home_userstats"),
	);

// Test de la validité de subaction
$pub_subaction = (isset($pub_subaction)&&in_array($pub_subaction,array_keys($menu_item)))?$pub_subaction:"empire";

// Listing des menus
foreach($menu_item as $menu_action => $menu_title)
	$tpl_header->loopVar('MENU', Array(
				'title' => $menu_title,
				'subaction' => $menu_action,
				'this_one' => ($pub_subaction==$menu_action)
		));
// Affiche de l'en-tête de la page
$tpl_header->parse();

// Affichage du contenu de la page en fonction de l'onglet sélectionné
require_once(translated("home_{$pub_subaction}.php"));

// Affichage du footer de la page Home.
$tpl_footer->parse();

// Footer OGSpy
require_once("views/page_tail.php");
?>
