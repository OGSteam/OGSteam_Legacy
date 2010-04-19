<?php
/** $Id$ **/
/**
* Page debug
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if (file_exists($user_data['user_skin'].'\templates\debug.tpl'))
{
    $debug_tpl = new template($user_data['user_skin'].'\templates\debug.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\debug.tpl'))
{
    $debug_tpl = new template($server_config['default_skin'].'\templates\debug.tpl');
}
else
{
    $debug_tpl = new template('debug.tpl');
}

// Liste des Variables de session
if (isset($HTTP_SESSION_VARS)){
	$debug_tpl->CheckIf('session',true);
	foreach ($HTTP_SESSION_VARS as $key=>$value){
		$v = '';
		if (is_array($value))
			foreach ($value as $inckey=>$incval)
				$v .= "[{$inckey}]=>{$incval}<br />"; 
		else  
			$v = $value;
		$debug_tpl->loopVar('session',Array('key'=>$key,'value'=>$v));
	}
}

// Liste des variables passées dans l'URL. NB : Il n'y a pas de gestion des tableaux dans ce cas
if (!empty($HTTP_GET_VARS)){
	$debug_tpl->CheckIf('url',true);
	foreach ($HTTP_GET_VARS as $key=>$value)
		$debug_tpl->loopVar('url',Array('key'=>$key,'value'=>$value));
}

// Liste des variables transmises par formulaire
if (isset($HTTP_POST_VARS)){
	$is = false;
	foreach ($HTTP_POST_VARS as $key=>$value){
		$is = true;
		$v = '';
		if (is_array($value))
			foreach ($value as $inckey=>$incval)
				$v .= "[{$inckey}]=>{$incval}<br />"; 
		else  
			$v = $value;
		$debug_tpl->loopVar('form',Array('key'=>$key,'value'=>$v));
	}
	$debug_tpl->CheckIf('form',$is);
}
$debug_tpl->SimpleVar(Array(
	'debug_session' => L_('debug_session'),
	'debug_URL' => L_('debug_URL'),
	'debug_form' => L_('debug_form')
));
$debug_tpl->CheckIf('no_ajax',!isset($pub_ajax));
if(!isset($pub_ajax) && DEBUG_ON_TOP) $debug_tpl->parse();
?>
