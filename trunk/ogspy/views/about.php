<?php
/** $Id$ **/
/**
* Page about
* @package OGSpy
* @subpackage main
* @author Kyser / OGSteam 
* @copyright Copyright &copy; 2005-2009, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
$pub_subaction = isset($pub_subaction)?$pub_subaction:'ogsteam';
// Creation du template
if (file_exists($user_data['user_skin'].'\templates\about_'.$pub_subaction.'.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\about_'.$pub_subaction.'.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\about_'.$pub_subaction.'.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\about_'.$pub_subaction.'.tpl');
}
else
{
    $tpl = new template('about_'.$pub_subaction.'.tpl');
}
$tpl->SimpleVar(Array(
	'ogsteam_ircchan' => L_('ogsteam_ircchan'),
	'ogsteam_website' => L_('ogsteam_website')
));
$content = $tpl->parse('return');

// Header & Menu
require_once("views/page_header.php");
// Appel de la page tout court (menu)
if (file_exists($user_data['user_skin'].'\templates\about.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\about.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\about.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\about.tpl');
}
else
{
    $tpl = new template('about.tpl');
}
$tpl->SimpleVar(Array('content'=>$content));
$tpl->parse();
require_once("views/page_tail.php");
