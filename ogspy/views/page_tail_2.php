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
require_once('page_tail.php');
/*lang_load_page("page_tail_2");
$php_end = benchmark();
$php_timing = $php_end - $php_start - $sql_timing;
$db->sql_close(); // fermeture de la connexion à la base de données 

// Creation du template
$tpl = new template('page_tail_2.tpl');

// Traitement des conditions
$tpl->checkIf('phperror',is_array($ogspy_phperror) && count($ogspy_phperror)); // Des erreurs PHP a afficher ?
if (is_array($ogspy_phperror) && count($ogspy_phperror)) // Si oui, peuplement du tableau
	foreach($ogspy_phperror as $line) 
		$tpl->loopVar('phperror',array('line' => $line));

// Simples variables texte
$tpl->simpleVar(Array(
	'SERVER_NAME' => $server_config["servername"]." - OGSpy ".$server_config["version"],
	'VERSION' => "v".$server_config["version"],
	'TIME' => L_("pagetail_generation")." ".round($php_timing+$sql_timing, 3)." sec (<b>PHP</b> : ".round($php_timing, 3)." / <b>SQL</b> : ".round($sql_timing, 3)."
)"
));
if(MODE_DEBUG&&!DEBUG_ON_TOP&&!isset($pub_ajax)) echo "<br/><br/><br/>".$debug_tpl->parse('return');

// Traitement et affichage du template
$tpl->parse();

//*/
?>
