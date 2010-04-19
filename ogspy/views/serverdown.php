<?php
/** $Id$ **/
/**
* Page d'information que le serveur est fermé
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

// Creation du template
if (file_exists($user_data['user_skin'].'\templates\serverdown.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\serverdown.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\serverdown.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\serverdown.tpl');
}
else
{
    $tpl = new template('serverdown.tpl');
}

// Simples variables texte
$tpl->simpleVar(Array(
	'SERVER_CLOSE' => L_("serverdown_serverclose"),
	'REASON' => $server_config["reason"]
));

// Traitement et affichage du template
$tpl->parse();

require_once("views/page_tail.php");
?>
