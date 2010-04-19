<?php
/** $Id$ **/ 
/** 
* Page about 
* @package OGSpy 
* @subpackage main 
* @author Kyser 
* @copyright Copyright &copy; 2007, http://ogsteam.fr/ 
* @version 4.00 ($Rev$) 
* @modified $Date$ 
* @link $HeadURL$ 
*/ 
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

/**
* Création d'un lien d'aide en popup sur image
* @param string $key Identifiant de l'aide
* @param string $value Texte optionnel d'aide , lorsque $key n'est pas fourni
* @param string $prefixe Chemin optionnel vers le root OGSpy
* @return string le lien à insérer
*/
function help($key, $value = "", $prefixe = "",$clickclose = false) {
	global $help,$tpl_global_defined;

	if (!isset($help[$key]) && !(is_null($key) && $value <> "")) return;

	if (isset($help[$key])) $value = $help[$key];
	
	$text = TipFormat($tpl_global_defined->GetDefined('help_tip',Array('value'=>$value)));

	$template_define_name = ($clickclose == false)?'help_link_autoclose':'help_link_clicktoclose';
	
	return $tpl_global_defined->GetDefined(
		$template_define_name,
		Array(
			'prefixe'=>$prefixe,
			'tip'=>$text,
			'title'=>L_("help_help")
		)
	);
		
}
?>
