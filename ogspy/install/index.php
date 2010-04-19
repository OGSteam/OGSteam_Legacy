<?php
/** $Id$ **/ 
/** 
 * Fichier d'installation d'ogspy : ROOT/install/index.php 
* @package OGSpy 
* @subpackage main 
* @author Kyser 
* @copyright Copyright &copy; 2007, http://ogsteam.fr/ 
* @version 4.00 ($Rev$) 
* @modified $Date$ 
* @link $HeadURL$ 
*/ 

define("IN_SPYOGAME", true);
define("INSTALL_IN_PROGRESS", true);
if(isset($_POST['update'])&&!defined("UPGRADE_IN_PROGRESS")) define("UPGRADE_IN_PROGRESS","1");

require_once("../common.php");
require_once("version.php");

if(isset($pub_step)&&$pub_step==-1) $pub_action = "";
if(defined("INSTALL_STEP")&&!isset($pub_step)&&!isset($pub_action)){
	$pub_step = INSTALL_STEP;
	$pub_action = "install";
}

$pub_lang = isset($pub_lang)?$pub_lang:(isset($server_config['language'])?$server_config['language']:"fr");
$pub_action = isset($pub_action)?$pub_action:"";
lang_load_page("help",$pub_lang);
lang_load_page("common",$pub_lang);
lang_load_page("log",$pub_lang);
$lang_ok = lang_load_page("install",$pub_lang);

$index_tpl = new Template('tpl/index.tpl');
$index_tpl->CheckIf('lang_isset',true);
$index_tpl->SimpleVar(Array(
		'lang_pics' => make_lang_pic("./?lang=","30","18"),
		'install_version' => $install_version,
	));
ob_start();
switch($pub_action){
	// Si l'utilisateur demande une mise à jour, on défini et on inclus ensuite le script d'installation
	case "update" :
		if(!defined("UPGRADE_IN_PROGRESS")) define("UPGRADE_IN_PROGRESS","1");
	// Si l'utilisateur demande une nouvelle installation, on saute la définition
	case 'install':
		include "install.php";
		break;
	default:
		$tpl = new Template('tpl/welcome.tpl');
		$tpl->CheckIf('found_id',file_exists('../parameters/id.php')?true:false);
		$tpl->SimpleVar(Array(
			'welcome' => L_('welcome',$install_version),
			'description-0' => L_('description-0'),
			'description-1' => L_('description-1'),
			'description-2' => L_('description-2'),
			'description-3' => L_('description-3'),
			'description-4' => L_('description-4'),
			'lang_selection' => make_lang_pic("./?lang=","45","30"),
			'moreinfo' => L_('moreinfo'),
			'lang' => $pub_lang,
			'chooseaction' => L_('chooseaction'),
			'fullinstall' => L_('fullinstall'),
			'update' => L_('update'),
		));
		$tpl->parse();
		break;
}
$index_tpl->SimpleVar(Array('page_content'=>ob_get_contents()));
ob_clean();
$index_tpl->parse();
?>
