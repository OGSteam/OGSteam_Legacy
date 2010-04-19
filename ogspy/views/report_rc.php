<?php
/** $Id$ **/
/**
* Affichage d'un raport de combat
* @package OGSpy
* @subpackage main
* @author Gorn
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Creation du template
$reports = galaxy_reportrc_show();

if ($reports === false) redirection("?action=message&amp;id_message=errorfatal&info");

require_once("views/page_header_2.php");

if (file_exists($user_data['user_skin'].'\templates\report_rc.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\report_rc.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\report_rc.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\report_rc.tpl');
}
else
{
    $tpl = new template('report_rc.tpl');
}

// Traitement des conditions
$tpl->CheckIf('no_report',sizeof ( $reports ) == 0);

// Listing des RC
foreach ($reports as $v)
		$tpl->loopVar('prout',
			Array('CONTENT' => nl2br($v)));
	
// Simples variables texte
$tpl->SimpleVar(Array('report_nobattles' => L_("report_nobattles")));

// Traitement et affichage du template
$tpl->parse();

require_once("views/page_tail_2.php");
?>
