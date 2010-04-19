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

require_once("views/page_header_2.php");
if (!isset($goto)) $goto = "";

// Creation du template
if (file_exists($user_data['user_skin'].'\templates\login.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\login.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\login.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\login.tpl');
}
else
{
    $tpl = new template('login.tpl');
}

// Verifications de l'enregistrement
$tpl->checkIf('is_register', $server_config['enable_register_view'] == 1);

// Simples variables texte
$tpl->simpleVar(Array(
	'GOTO' => $goto,
	'CONNECTION_PARAMETERS' => L_('login_Connection_parameters'),
	'LOGIN_PASSWORD' => L_('login_Password'),
	'LOGIN_USERNAME' => L_('login_Username'),
	'LOG_IN' => L_('login_Log_in'),
	'LOG_CREATE' => L_('login_cpteOGSpy'),
	'LOG_ALLIANCE' => L_('login_NoCpte', $server_config['register_alliance']),
	'LOG_CALL' => L_('login_opencpteOGSpy'),
	'LOG_URL' => $server_config['register_forum']
));

// Traitement et affichage du template
$tpl->parse();

require_once("views/page_tail_2.php");
?>
