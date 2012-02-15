<?php
/**
 * QuiMSonde.php 

index du script
analyse des $pub_
appel des fichiers

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Includes
include("qms_common.php");
include(FOLDER_INCLUDE."/qms_statistique.php");
include(FOLDER_INCLUDE."/qms_users.php");
include(FOLDER_INCLUDE."/qms_sql.php");
include(FOLDER_INCLUDE."/qms_main.php");
include(FOLDER_INCLUDE."/qms_html.php");

if (!isset($pub_page)) $pub_page = "accueil";

// Quel header&tail ogspy? rien si graph, page_header_2.php & page_tail_2 si popup
$popup = ($pub_page=="popup"?"_2":"");
$graph = ($pub_page=="graph");

if (!$graph){
	require_once ("views/page_header".$popup.".php");
	echo"\n\n<!-- DEBUT de QUIMSONDE -->\n"; // Marquage
}
else 
	require_once("pages/graph.php");							// Sauf si graph

if($popup=="_2") { 
		require_once("pages/popup.php");
		echo "<script language='JavaScript' src='js/wz_tooltip.js'></script>";
}

if(!$graph && $popup==""){ // Ni un graph, ni un popup

	// Si on a demandé de réinstaller le callbacks
	if(isset($pub_add_callbacks)){
		define("INSTALL_MOD_NAME",$mod_name);
		include("_xtense.php");
	}
	// Click : importation de la table qmo
	if(isset($pub_import_from_qmo)) $retour=import_from_qmo();
		
	// Check : supression des ?
	if(isset($pub_check_newnames)) $retour=check_for_newnames();
		
	// Click : purge
	if(isset($pub_delete_oldspies)) $retour=delete_oldspies();
		
	// Modif options
	if(isset($pub_valider_user)||isset($pub_valider_admin)) {
		if(isset($pub_valider_admin)) $tag="admin"; else $tag="user";
		foreach($config_list as $config){
			if(($a=$config['name'])!="" && isset(${'pub_'.$tag.'_'.$a})){
				if($a=="time_start"||$a=="time_end"){ // Type DATE
					if(preg_match_all($lang['qms_format_date_regex'],${'pub_'.$tag.'_'.$a},$date))
						$value = mktime(0,0,0,intval($date[2][0]),intval($date[1][0]),intval($date[3][0]));
					else 
						$value = false;
				}else
				if($a=="add_home"||$a=="imgmenu"||$a=="banniere"){ // Type YES/NO
					$value = ${'pub_'.$tag.'_'.$a}=='1'?'yes':'no';
				}else{ // Autre : Type nombre
					$value = trim(${'pub_'.$tag.'_'.$a});
					$value = is_numeric($value)?$value:false;
				}
				if($value!=false) set_qms_config($value,$a, $tag=="user"?$user_data['user_id']:0);
			}
		}
		if($tag=="admin"&&isset($pub_admin_jours)) {
			$value = trim($pub_admin_jours);
			if(is_numeric($value)) set_qms_config($value,'jours', 0);
		}
		$retour = $lang['qms_admin_config_updated'];
	}
	
	// Click ràz user
	if(isset($pub_restore_user)){
		delete_qms_config($user_data['user_id']);
		$retour = $lang['qms_admin_defaut_restored'];
	}

	// On vient d'effacer un rapport
	if (isset($pub_delete)) delete_espionnage($pub_delete);

	// On vient de modifier un rapport
	if (isset($pub_modify)) modify_espionnage($pub_modify);

	// On vient de faire des modif sur les selection ?
	if(isset($pub_onselection)){
		$retour = 0;
		if($update=$pub_onselection=='update')
			for($j=0;$j<(get_qms_config('lignes',$user_data['user_id']));$j++)
				if(isset(${'pub_check_'.$j})) $retour += modify_espionnage(${'pub_check_'.$j});
		if($pub_onselection=='delete')
			for($j=0;$j<(get_qms_config('lignes',$user_data['user_id']));$j++)
				if(isset(${'pub_check_'.$j})) $retour += delete_espionnage(${'pub_check_'.$j});
		$text = 'qms_admin_'.($retour<1?'0':($retour>1?'x':'1')).'_rapports_'.($update?'updated':'deleted');
		$retour = sprintf($lang[$text],$retour);
	}

	// Si on vient d'ajouter un espionnage...
	if (isset($pub_espionage))	$retour=prepare_espionnage($pub_espionage);

	// Si la page a afficher n'est pas définie, on affiche la première
	if (!isset($pub_page)) $pub_page = $pages[0]['fichier'];

	// On vient de modifier le nombre de lignes par page 
	if(isset($pub_lignes_par_pages)) {
		$value = trim($pub_lignes_par_pages);
		if(is_numeric($value)) set_qms_config($value,'lignes', $user_data['user_id']);
	}
	if(!isset($pub_pagenum)) $pub_pagenum = 1;

	// On vient d'ajouter un nouveau lien
	if(isset($pub_search_create)){
		set_new_search($pub_search_name,$pub_search_link,$pub_search_type);
	}

	// On vient de modifier les liens
	if(isset($pub_search_modify)){
		update_search();
	}
		
	// On efface les rapports trop anciens
	clear_old_rapport();

	//Logo QuiMSonde
	if(get_qms_config('banniere',$user_data['user_id'])=="yes")
		echo"<center><img src='$image_logo'></center>";

	// Affichage du menu et de la page demandée
	menu($pub_page);

	//Insertion du message de validation si défini
	if (isset($retour))	echo"<blink>$retour</blink>";

	// Affichage du contenu de la page
	include("pages/$pub_page.php");
	// Affichage du fin de page du module
	include("pages/footer.php");
}


// Quel footer?
if (!$graph) {
	require_once("views/page_tail".$popup.".php");

	$debug = qms_debug();

?>
<script type="text/javascript">
function chk_nb(name,defaut_value) {
	var txt_zone = document.getElementById(name);
	if (isNaN(txt_zone.value))
	{
		alert("<?php echo $lang['qms_alert_number_only']; ?>");
		txt_zone.value = defaut_value;
		return false;
	}
	return true;
}
</script>
<?php
}
?>