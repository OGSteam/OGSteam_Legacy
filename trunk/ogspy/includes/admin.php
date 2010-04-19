<?php
if (!defined('IN_SPYOGAME') || ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1)) die("Hacking attempt");

/*****
 * Fonctions pour l'affichage des modules présent dans /mod/
*/

/**
 * fonction renvoyant un tableau pour afficher une ligne de module ou de catégorie
 */
function print_line($type,$data ){
	$link_update=$id=$title=$updown=$text=$action=$menu=$admin_only=$readonly='';$is_module = true;
	switch($type){
	
	
		// Ligne pour un mod actif, avec ou sans catégorie
		
		case 'mod_with_cat':
			$tabulation = "&nbsp;\t&nbsp;\t&nbsp;\t";
		case 'mod_without_cat':
			$id = $data['id'];
			$menu = htmlspecialchars($data['menu']);
			$title = (isset($tabulation)?$tabulation:"").$data['title']." (".$data['version'].")";
			$admin_only = $data['admin_only'];
			$updown = get_link_code('asc',"?action=administration&subaction=mod&make=mod_up&mod_id={$id}",L_("adminmod_Up"));
			$updown.=get_link_code('dsc',"?action=administration&subaction=mod&make=mod_down&mod_id={$id}",L_("adminmod_Down")); 
			$text =get_link_code('mod_disable',"?action=administration&subaction=mod&make=mod_disable&mod_id={$id}",L_("adminmod_Desactivate"));
			if($type=="mod_with_cat")
				$text.=get_link_code('cat_rem_mod',"?action=administration&subaction=mod&make=cat_rem_mod&mod_id={$id}",L_("adminmod_Mods_RemFromCat"));
			else				
				$text.=get_link_code('cat_add_mod',"javascript:show_select({$id});",L_("adminmod_Mods_AddToCat"),true);
			$text.="&nbsp;".$title."&nbsp;"; 
			if($admin_only!="") $text.=get_link_code('mod_admin',"{$admin_only}",L_("adminmod_Mods_GoToAdmin"));
			$action = "";
			if(!$data['up_to_date_ogs'])
				$action.=get_link_code('mod_update',"?action=administration&subaction=mod&make=mod_update&mod_id={$id}",L_("adminmod_Update",$data['new_version']));
			elseif(!$data['up_to_date_svn'])
				$action.=get_link_code('mod_update',"?action=administration&subaction=mod&make=new_update&mod_id={$id}&root=".$data['root']."&version=".$data['new_version'],L_("adminmod_Update",$data['new_version']));
			$action.=get_link_code('mod_edit',"javascript:show_edit_for_mod('{$id}');",L_("adminmod_Mods_edit"),true);
			$action.=get_link_code('mod_uninstall',"?action=administration&subaction=mod&make=mod_uninstall&mod_id={$id}",L_("adminmod_ConfUninstallMod",$data['title']));
			break;
			
		// Ligne pour une catégorie
		case 'categorie':
			$id = $data['id'];
			$menu = $data['menu'];
			$title = $data['title'];
			if($data['menu'] == $data['title'])
				$text = $data['menu'];
			else
				$text = $data['menu']." (".$data['title'].")";
			if($data['title']=='Admin') $readonly = 'readonly="readonly"';
			$updown = get_link_code('asc',"?action=administration&subaction=mod&make=cat_up&cat_id={$id}",L_("adminmod_Up"));
			$updown.=get_link_code('dsc',"?action=administration&subaction=mod&make=cat_down&cat_id={$id}",L_("adminmod_Down"));
			$action = get_link_code('mod_edit',"javascript:show_edit_for_cat('{$id}');",L_("adminmod_Mods_edit"),true);
				if($data['title']=='Admin')
					$action.=get_link_code('mod_uninstall',"","");
				else
					$action.=get_link_code('mod_uninstall',"?action=administration&subaction=mod&make=cat_remove&cat_id={$id}",L_("adminmod_ConfDeleteCategorie",$data['title']));
			$is_module = false;
			
			break;
			
			
		// Ligne pour un mod désactivé
		
		case 'mod_disabled':
			$id = $data['id'];
			$menu = $data['menu'];
			$text = $title = (isset($tabulation)?$tabulation:"").$data['title']." (".$data['version'].")";
			$updown = get_link_code('mod_active',"?action=administration&subaction=mod&make=mod_active&mod_id={$id}",L_("adminmod_Activate"));
			$action = get_link_code('mod_uninstall',"?action=administration&subaction=mod&make=mod_uninstall&mod_id={$id}",L_("adminmod_ConfUninstallMod",$data['title']));
			break;
			
		
		// Ligne pour un mod a installer
		
		case 'mod_install':
			$directory = $data['directory'];
			$title = $data['title'];
			$text = $title;
			$action = get_link_code('mod_install',"?action=administration&subaction=mod&make=mod_install&directory={$directory}",L_("adminmod_Install",$data['title'],$data['version']));
			break;
			
		
		// Ligne pour un mod défaillant
		
		case 'mod_wrong':
			$id = $data['id'];
			$title = $data['title'];
			$text = $title;
			$action = get_link_code('mod_uninstall',"?action=administration&subaction=mod&make=mod_uninstall&mod_id={$id}",L_("adminmod_ConfUninstallMod",$data['title']));
			break;
	}
	return Array('id'=>$id,'title'=>$title,'up_down_icons'=>$updown,'Text'=>$text,'menu'=>$menu,'admin_link'=>$admin_only,'action'=>$action,'readonly'=>$readonly,'module'=>$is_module, 'link_update'=>$link_update);

}

/**
 * Renvoi une liste <select> des catégories disponibles pour l'affichage de la liste
 */
function get_cat_select_list(){
	global $cat_list;
	$return = "\n";
	foreach($cat_list['actived'] as $cat){
		$return .= "<option value='{$cat['id']}'>{$cat['title']}</option>\n";
	}
	$return .= "\n";
	return $return;
}

/**
 * Renvoi un code bouton pour l'affichage de la liste
 */
function get_link_code($type,$url,$title,$js=false,$id=""){
	if($title=='')
		return "<img src='images/action_blank.png' alt='' />";
	$link = $js?$url:"document.location=('{$url}');";
	if($type=='mod_uninstall')
		$link = "if(confirm('".addslashes(html_entity_decode($title))."')) {$link}";
	$return = '<img title="'.($title).'" onclick="'.htmlentities(($link)).'" ';
	$return .= 'style="cursor:pointer;" alt=""';
	switch($type){
		case '':
		$return .= ""; break;
		case 'mod_admin':
		$return .= " src='images/application_form_edit.png'"; break;
		case 'mod_install':
		$return .= " src='images/link_add.png'"; break;
		case 'mod_active':
		$return .= " src='images/download.png'"; break;
		case 'mod_disable':
		$return .= " src='images/action_check.png'"; break;
		case 'mod_edit':
		$return .= " src='images/link_edit.png'"; break;
		case 'mod_uninstall':
		$return .= " src='images/cross.png'"; break;
		case 'mod_update':
		$return .= " src='images/link_go.png'"; break;
		case 'cat_add_mod':
		$return .= " src='images/arrow_right.png'"; break;
		case 'cat_rem_mod':
		$return .= " src='images/arrow_left.png'"; break;
		case 'asc':
		$return.=" src='images/asc.png'";break;
		case 'dsc':
		$return.=" src='images/desc.png'";break;
		default:
		break;
	}
	return $return.' />';
}

/**
 * Copie du omdule donné dans le dossier des mods
 */
 
function import_module($modroot,$version){
	require_once("./library/ziplib.php");
	$zip = new ZipLib;

	$modzip = "http://ogsteam.fr/downloadmod.php?mod=".$modroot."&amp;tag=".$version;
	if (!is__writable(TEMP_Folder)) {
		die("Erreur: Le repertoire ".TEMP_Folder." doit etre accessible en écriture (777) ".__FILE__. "(Ligne: ".__LINE__.")");
	}
	if(@copy($modzip , TEMP_Folder.$modroot.".zip")) {
		$tab = $zip->Extract(TEMP_Folder.$modroot.".zip", "./mod/");
		unlink(TEMP_Folder.$modroot.".zip");
	}
	return 'done';
}
?>