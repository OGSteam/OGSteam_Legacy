<?php if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$mod_list = mod_list();
$lines = array();
if(count($info) < 2){
	$info[] = Array('text'=>"<u>".L_('adminmod_NewModulesFound')."</u>");
	foreach($mod_list['svn'] as $mod){
		$lines[] = Array(
			'name' => $mod['title'],
			'version' => $mod['version'],
			'description' => $mod['description'],
			'link' => "?action=administration&amp;subaction=mod&amp;make=new_mod_install&amp;mod_root=".$mod['title']."&amp;mod_version=".$mod['version']
		);
	}
}
if (file_exists($user_data['user_skin'].'\templates\admin_mod_new.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\admin_mod_new.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\admin_mod_new.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\admin_mod_new.tpl');
}
else
{
    $tpl = new template('admin_mod_new.tpl');
}
// Inscription des lignes dans la liste définie
foreach($lines as $line)
	$tpl->loopVar('newmod_list',$line);
// Inscription des lignes d'information
foreach($info as $i)
	$tpl->loopVar('info',$i);

// Simple variable
$tpl->SimpleVar(Array(
	'install_new' => L_('adminmod_InstallMod'),
	'update_mod' => L_('adminmod_UpdateMod'),
	'mod_name' => L_('adminmod_mod_name'),
	'mod_description' => L_('adminmod_mod_description'),
	'mod_newversion' => L_('adminmod_mod_newversion')
));

$tpl->parse();
?>
