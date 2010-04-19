<?php if (!defined('IN_SPYOGAME')) die("Hacking attempt");
// Récupération de la liste des modules
$mod_list = mod_list();

// Récupération de liste des catégories
$cat_list = cat_list();

// Creation du template
if (file_exists($user_data['user_skin'].'\templates\admin_mod_list.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\admin_mod_list.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\admin_mod_list.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\admin_mod_list.tpl');
}
else
{
    $tpl = new template('admin_mod_list.tpl');
}

$done = $active_line = $inactive_line = $uninstalled_line = $x_mod_list = $wrong_line = $x_cat_list = Array();
$mods = $mod_list["actived"];

// Défilement de toutes les catégories
foreach($cat_list["actived"] as $cat_id => $categ){
	$print_after[] = Array('categorie',$categ);
	$x_cat_list[] = $categ['id'];
	// Défilement de tous les modules
	foreach($mods as $mod) {
		// Le module est dans cette catégorie et n'a pas déjà été affiché dans une catégorie
		if(in_array($mod['id'],$categ['members']) && !in_array($mod['id'],$done)){
			$print_after[] = Array('mod_with_cat',$mod);
			$x_mod_list[] = $mod['id'];
			$done[] = $mod['id'];
		}
	}
}
reset($mods);

// Re défilement de tous les modules pour retrouver les modules non affichés (ceux qui ne sont donc dans aucunes catégorie)
while ($mod = current($mods)) {
	// Le module a-t-il été traité pour une catégorie ?
	if(!in_array($mod['id'],$done)){
		$x_mod_list[] = $mod['id'];
		$done[] = $id = $mod['id'];
		$active_line[] = print_line('mod_without_cat',$mod);
	}
	next($mods);
}

// Traitement du tableau des catégories et modules
foreach($print_after as $line){
	$active_line[]=print_line($line[0],$line[1]);
	$mod = $line[1];
	$id=$mod['id'];
}
// traitement des modules désactivé
$mods = $mod_list["disabled"];
if(count($mods)>0){
	$tpl->CheckIf('is_inactive',true);
	while ($mod = current($mods)) {
		$inactive_line[] =  print_line('mod_disabled',$mod);
		$x_mod_list[] = $mod['id'];
		next($mods);
	}
}

// Traitement des modules à installer
$mods = $mod_list["install"];
if(count($mods)>0){
	$tpl->CheckIf('is_uninstalled',true);
	while ($mod = current($mods)) {
		$uninstalled_line[] =  print_line('mod_install',$mod);
		next($mods);
	}
}

// Traitement des modules invalide
$mods = $mod_list["wrong"];
if(count($mods)>0){
	$tpl->CheckIf('is_wrong',true);
	while ($mod = current($mods)) {
		$wrong_line[] = print_line('mod_wrong',$mod);
		next($mods);
	}
}

// Inscription des lignes dans le template
foreach($active_line as $line)
	$tpl->loopVar('active',$line);
foreach($inactive_line as $line)
	$tpl->loopVar('inactive',$line);
foreach($uninstalled_line as $line)
	$tpl->loopVar('uninstalled',$line);
foreach($wrong_line as $line)
	$tpl->loopVar('wrong',$line);
foreach($info as $i)
	$tpl->loopVar('info',$i);

// Simples variables texte
$tpl->simpleVar(Array(
	'adminmod_ActiveMods' => L_("adminmod_ActiveMods"),
	'adminmod_CatCreate' => L_("adminmod_CatCreate"),
	'adminmod_InactiveMods' => L_("adminmod_InactiveMods"),
	'adminmod_InstallableMods' => L_("adminmod_InstallableMods"),
	'adminmod_InvalidMods' => L_("adminmod_InvalidMods"),
	'x_mod_list' => implode('<|>',$x_mod_list),
	'x_cat_list' => implode('<|>',$x_cat_list),
	'adminmod_Add' => L_("adminmod_Add"),
	'adminmod_CatName' => L_("adminmod_CatName"),
	'basic_Ok' => L_('basic_Ok'),
	'basic_Cancel' => L_('basic_Cancel'),
	'adminmod_Mods_ChooseNewName' => L_("adminmod_Mods_ChooseNewName"),
	'adminmod_Mods_ChooseNewAdminLink' => L_('adminmod_Mods_ChooseNewAdminLink'),
	'adminmod_Mods_ChooseACat' => L_("adminmod_Mods_ChooseACat"),
	'adminmod_SelectTitle' => L_('adminmod_SelectTitle'),
	'adminmod_SelectMenu_cat' => L_('adminmod_SelectMenu_cat'),
	'mod_newversion' => L_('adminmod_mod_newversion'),
	'cat_select_list' => get_cat_select_list()
));

// Traitement et affichage du template
$tpl->parse();

?>