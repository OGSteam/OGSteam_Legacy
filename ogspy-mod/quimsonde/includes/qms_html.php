<?php
/**
 * qms_html.php 

Procédures et Fonctions liées au code HTML

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
function menu($pub_page){											// Création du menu
	global $pages, $image_menu, $mod_name,$user_data;
	$ligne1=$ligne2="";
	$width = 80;$height =44;
	for($i=0;$i<count($pages);$i++){
		$this_page = ($pub_page == $pages[$i]['fichier']);
		$link_menu = "index.php?action={$mod_name}&";
		$cfg_imgmenu = get_qms_config('imgmenu',$user_data['user_id']);
		$link_menu = "{$link_menu}&page={$pages[$i]['fichier']}";
		$title_menu = $pages[$i]['texte'];
		$ignore_insertion = ( ( get_qms_config("add_home",$user_data['user_id'])=='yes' ) && $pages[$i]['fichier']=='insertion' );
		if($cfg_imgmenu=="yes"){
			if ( ($pages[$i]['admin'] && IsUserAdmin())||(!$pages[$i]['admin']) && !$ignore_insertion ){
				$ligne2 .= "\n<td width='".$width."' valign='center' height='".$height."'";
				$styleON= " style='background : url(".$pages[$i]['image_on'].");'";
				$styleOFF = " style='background : url(".$pages[$i]['image_off'].");'";
				if($this_page) $ligne2 .= $styleON; else $ligne2 .= $styleOFF;
				if(!$this_page){
					$ligne2 .= " onMouseOver=\"this.style.background= 'url(".$pages[$i]['image_on'].")';\"";
					$ligne2 .= " onMouseOut=\"this.style.background= 'url(".$pages[$i]['image_off'].")';\"";
				}
				$ligne2 .= " onclick=\"window.location = '{$link_menu}';\"";
				$ligne2 .= "><b><font color='".($this_page?"white":"grey")."'>{$title_menu}</font></b></td>";
			}
		} else {
			if ( ($pages[$i]['admin'] && IsUserAdmin())||(!$pages[$i]['admin'])  && !$ignore_insertion ){
					$ligne2 .= "\t<td class='".($this_page?"c":"b")."' width='150' onclick=\"window.location = '{$link_menu}';\">";
					$ligne2 .= "<a style='cursor:pointer'>{$title_menu}</a></td>";
			}
		}
	}
	echo "\n\n<!-- menu -->\n<table><tbody><tr align='center'>$ligne2\n</tr></tbody></table>\n";
	echo "\n\n<!-- page ".$pub_page.".php -->\n";
}
function get_galaxy_link($position){								// Renvoi le lien de recherche vers un systeme donné
	$tmp = get_coord($position);
	$ret = $tmp[0]."&system=".$tmp[1];
	return $ret;
}
function make_liste_string($type,$data,$private=1){					// Rempli la zone <select> des options de $type de filtrage
	global $lang;
	$liste = get_list($type,$private);
	$string = "";
	if($type=='sender_id') {
		$type='membres';
		if(count(explode('>',$data))<2)
			$data = '-';
	}
	if(count($liste)>0){
		if($data=='-') $string.="\t\t\t\t\t<option value='-' selected>".$lang['qms_spylist_filtrer_par'].ucfirst($type)."</option>\n";
		else $string.="\t\t\t\t\t<option value='-'>".$lang['qms_spylist_filtrer_none']."</option>\n";
		foreach($liste as $option){
			if($type!='membres')
				if(!($value=$option)) $texte=$lang['qms_spylist_filtrer_no_alliance'];
				elseif($option=="?") $texte=$lang['qms_spylist_filtrer_no_player'];
				else $texte = $option;
			else $value = "---> ".($texte=get_user_name_by_id($option));
			if($data==$value) $selected=" selected"; else $selected="";
			if($type=='cible'&&$private==1) $texte .= " - ".get_user_data_from_coord('planet_name',$value);
			$string .="\t\t\t\t\t<option value='$value'$selected>$texte</option>\n";
		}
	}else
		$string = "";// "<i>Aucune donnée trouvée...</i>";
	return $string;
}
function get_tooltip($gtarget,$gtype,$from_popup=0,$id=0,$member=0){	// Renvoi un code de tooltip inspiré de la page galaxie selon le Type "Joueur" ou "Alliance";
	global $mod_name,$pub_viewall,$lang;
	// Depuis où? et donc vers où?
	if($from_popup!=0){
		// Depuis le popup
		$href_start ="onclick=\"window.opener.document.location.href = \'";
		$href_stop = "\'\"";
	}else{
		// Depuis une page normale
		$href_start ="href = \'";
		$href_stop = "\'";
	}
	$page = "spy_list";
	if($gtype=="Position"){
		list($name,$ally) = get_user_id($gtarget);
		$type= "Joueur";
		$target= $name;
	} else {
		$type = $gtype;
		$target = $gtarget;
	}
	if(isset($pub_viewall)&&$pub_viewall==1) $page .= "_public";
	if($target=="?") return "";
	if($id!=0&&$from_popup==0){
		$link ="javascript:window.open(\"index.php?action=$mod_name&page=popup&target=".$id;
		$link.="\",\"_blank\",\"width=890, height=480, toolbar=0, location=0, directories=0, status=0, ";
		$link.="scrollbars=1, resizable=0, copyhistory=0, menuBar=0\");return(false)";
		$analyser = "<a ".$href_start."#".$href_stop." onclick=\'".$link."\'>";
		$analyser .= $lang['qms_spylist_analyse_link']."</a>";
	} else $analyser = "";
	$tooltip = "<table width=\"250\">";
	$tooltip .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">".$lang['qms_'.strtolower($type)]." ".$target." ".$analyser."</td></tr>";
	if($type=="Joueur" || $type=="Alliance"){
		$individual_ranking = ($type=='Joueur')? galaxy_show_ranking_unique_player($target):galaxy_show_ranking_unique_ally($target);
		while ($ranking = current($individual_ranking)) {
			$datadate = strftime($lang['qms_classement_date'], key($individual_ranking));
			$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
			$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
			$eco_rank = isset($ranking["eco"]) ?  formate_number($ranking["eco"]["rank"]) : "&nbsp;";
			$eco_points = isset($ranking["eco"]) ?  formate_number($ranking["eco"]["points"]) : "&nbsp;";
			$technology_rank = isset($ranking["techno"]) ?  formate_number($ranking["techno"]["rank"]) : "&nbsp;";
			$technology_points = isset($ranking["techno"]) ?  formate_number($ranking["techno"]["points"]) : "&nbsp;";
			$military_rank = isset($ranking["military"]) ?  formate_number($ranking["military"]["rank"]) : "&nbsp;";
			$military_points = isset($ranking["military"]) ?  formate_number($ranking["military"]["points"]) : "&nbsp;";
			$military_builded_rank = isset($ranking["military_b"]) ?  formate_number($ranking["military_b"]["rank"]) : "&nbsp;";
			$military_builded_points = isset($ranking["military_b"]) ?  formate_number($ranking["military_b"]["points"]) : "&nbsp;";
			$military_lost_rank = isset($ranking["military_l"]) ?  formate_number($ranking["military_l"]["rank"]) : "&nbsp;";
			$military_lost_points = isset($ranking["military_l"]) ?  formate_number($ranking["military_l"]["points"]) : "&nbsp;";
			$military_destroyed_rank = isset($ranking["military_d"]) ?  formate_number($ranking["military_d"]["rank"]) : "&nbsp;";
			$military_destroyed_points = isset($ranking["military_d"]) ?  formate_number($ranking["military_d"]["points"]) : "&nbsp;";
			$honnor_rank = isset($ranking["honnor"]) ?  formate_number($ranking["honnor"]["rank"]) : "&nbsp;";
			$honnor_points = isset($ranking["honnor"]) ?  formate_number($ranking["honnor"]["points"]) : "&nbsp;";
			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".sprintf($lang['qms_classement_of'],$datadate)."</td></tr>";
			$tooltip .= "<tr><td class=\"c\" width=\"75\">".$lang['qms_classement_general']."</td><th width=\"30\">";
			$tooltip .= $general_rank."</th><th>".$general_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">".$lang['qms_classement_economique']."</td><th>".$eco_rank."</th><th>".$eco_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">".$lang['qms_classement_technologie']."</td><th>".$technology_rank."</th><th>".$technology_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">".$lang['qms_classement_militaire']."</td><th>".$military_rank."</th><th>".$military_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">".$lang['qms_classement_militaire_construit']."</td><th>".$military_builded_rank."</th><th>".$military_builded_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">".$lang['qms_classement_militaire_perdu']."</td><th>".$military_lost_rank."</th><th>".$military_lost_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">".$lang['qms_classement_militaire_detruit']."</td><th>".$military_destroyed_rank."</th><th>".$military_destroyed_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">".$lang['qms_classement_honneur']."</td><th>".$honnor_rank."</th><th>".$honnor_points."</th></tr>";
			if($type=='Alliance'){
					$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">";
					$tooltip .= sprintf($lang['qms_classement_membres'],formate_number($ranking["number_member"]))."</td></tr>";
			}
			break;
		}
	}
	$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">";
	$filtre = strtolower($type);
	$data = $target;
	if($member!=0){
		$filtre = "cible";
		$data = "---> ".$target;
	}
	$tooltip .= "<a ".$href_start."index.php?action=".$mod_name."&page=".$page."&filtre_".$filtre."=".$data.$href_stop.">";
	$tooltip .= "Filtrer / ".$target."</a></td></tr>";
	if($type=='Alliance'){
		$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">";
		$tooltip .= "<a ".$href_start."index.php?action=search&type_search=ally&string_search=".$target."&strict=on".$href_stop.">";
		$tooltip .= $lang['qms_classement_voir_details']."</a></td></tr>";
	}elseif($type=='Joueur')	{
		$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">";
		$tooltip .= "<a ".$href_start."index.php?action=search&type_search=player&string_search=".$target."&strict=on".$href_stop.">";
		$tooltip .= $lang['qms_classement_voir_details']."</a></td></tr>";
	}elseif($type=='Position'){
		if(($x=get_spies_string($target,$lang['qms_classement_voir_espionnage']))!="")
			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".$x."</td></tr>";
	}
	if(($search = get_search_list())==true){
		foreach($search as $s){
			if(($s['type']==$type||($s['type']=='Position'&&$type=='Cible'))&&$s['actif']=='1'){
				if($type=="Alliance"){
					$s['link'] = str_replace("{alliance}",$target,$s["link"]);
				}elseif($type=="Joueur"){
					$s['link'] = str_replace("{joueur}",$target,$s["link"]);
				}elseif($type=="Position"||$type=="Cible"){
					$s['link'] = str_replace(Array("{galaxy}","{system}","{row}"),get_coord($target),$s["link"]);
				}
				$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a ".$href_start.$s['link'].$href_stop.">".$s['name']."</td></tr>";
			}
		}
	}
	$tooltip .= "</table>";
	$tooltip = htmlentities($tooltip);
	$retour = " onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip."')\"";
	return $retour;
}
function make_spy_OGameStyle($table_spy,$j,$from_popup=0){			// Affiche l'espionnage $j de la table $table_spy a la manière de la page message de OGame
	// Qui affiche?
	global $user_data,$lang;

	// Depuis où? et donc vers où?
	if($from_popup!=0){
		// Depuis le popup
		$href_start ="onclick=\"window.opener.document.location.href = '";
		$href_stop = "'\"";
	}else{
		// Depuis une page normale
		$href_start ="href = '";
		$href_stop = "'";
	}

	// Si le nom enregistré n'est pas inconnu
	if($table_spy['joueur'][$j]=="?"){
		$s_joueur="<i>".$lang['qms_joueur_inconnu']."</i>";
	}else{
		$joueur_link = " ".$href_start."index.php?action=search&type_search=player&string_search=".$table_spy['joueur'][$j]."&strict=on".$href_stop;
		$popup_joueur=get_tooltip($table_spy["joueur"][$j],'Joueur',$from_popup,$table_spy["id"][$j]);
		$s_joueur="<b><a$joueur_link$popup_joueur>".$table_spy['joueur'][$j]."</a></b>";
	}
		
	// S'il y a le nom d'une alliance a afficher
	if($table_spy['alliance'][$j]==""){
		$s_alliance = "";
	}else{
		$alliance_string=$table_spy['alliance'][$j];
		$popup_alliance=get_tooltip($alliance_string,'Alliance',$from_popup,$table_spy["id"][$j]);
		$alliance_link=" ".$href_start."index.php?action=search&type_search=ally&string_search=$alliance_string&strict=on".$href_stop;
		$s_alliance = "(<b><a$alliance_link$popup_alliance>$alliance_string</a></b>)";
	}

	// Texte pour la position de l'espion
	$s_position="<b>[<a ".$href_start."index.php?action=galaxy&galaxy=".get_galaxy_link($table_spy["position"][$j]).$href_stop;
	$s_position.=get_tooltip($table_spy["position"][$j],'Position',$from_popup,$table_spy["id"][$j]).">".$table_spy["position"][$j];
	$s_position.="</a>] ".get_spies_string($table_spy["position"][$j])." </b>";

	// Texte pour la date au format OGame : 11-15 18:05:49
	$s_date="<b>".date($lang['qms_format_date_ogame'],$table_spy["datadate"][$j])."</b>";

	// Texte pour le nom de la planete cible (récupére dans la table building)
	$s_cible_name = get_user_data_from_coord('planet_name',$table_spy["cible"][$j]);

	// Texte pour la position de la planete cible
	$s_cible = "<b><a ".$href_start."index.php?action=galaxy&galaxy=".get_galaxy_link($table_spy["cible"][$j]).$href_stop;
	$s_cible .=get_tooltip($table_spy["cible"][$j],'Cible',$from_popup,$table_spy["id"][$j]).">".$table_spy["cible"][$j]."</a></b>";

	// Texte pour la probabilité de destruction
	$s_proba = "<font color='#".get_color($table_spy["pourcentage"][$j])."'><b>".$table_spy["pourcentage"][$j]."%</color></font></b>";
		
	/*/ Lien pour effacer l'espionnage            <<<<<<<<------------ BUGGED ----------------->
	$delete_link = "index.php?action=$mod_name&page=$pub_page&sort=".$pub_sort."&ord=".$pub_ord."&pagenum=".$pub_pagenum."&delete=".$table_spy['id'][$j]."$string_url";

	// Texte de la zone Action selon s'il y a de la modif ou pas 
	if( ($user_data['user_id'] == $table_spy['sender_id'][$j]) ){
		if($from_popup!=0)
			$s_target="target='_parent'";
		else
			$s_target="";
		$s_action = "<form method='POST' $s_target action='$delete_link' onsubmit=\"return confirm('Etes-vous sûr de vouloir supprimer l\'espionnage de ".$table_spy['joueur'][$j]." ?')\"><input type='image' width='15' height='15' src='".FOLDER_QMS."/images/delete.png' name = 'supprimer espionnage n°".$table_spy["id"][$j]."'></form>";

		// On récupére le nom et l'ally du joueur depuis la table universe
		$tmp=get_user_id($table_spy["position"][$j]);
		$new_name=$tmp[0];$new_ally=$tmp[1];
		if(!$new_name) $new_name="?";

		// Si le nom ou l'ally a changé et si l'utilisateur peut le faire
		if( ($user_data['user_id'] == $table_spy['sender_id'][$j]) )
		if( ($new_ally!=$table_spy["alliance"][$j]) || ($table_spy["joueur"][$j]!=$new_name) ) {
			$modify_link = "index.php?action=$mod_name&page=$pub_page$viewall&sort=".$pub_sort."&ord=".$pub_ord."&pagenum=".$pub_pagenum."&modify=".$table_spy['id'][$j]."$string_url";
			$s_action.=" <form method='POST' action='$modify_link' onsubmit=\"return confirm('Etes-vous sûr de vouloir modifier l\'espionnage de ".$table_spy['joueur'][$j]." 	?')\">\n";
			if($new_name!="?")
				$new_joueur_link = " href=\"index.php?action=search&type_search=player&string_search=".$new_name."&strict=on\" target=\"$target_link\"";
			else
				$new_joueur_link = "";
			if($new_ally!="")
				$new_alliance_link=" href=\"index.php?action=search&type_search=ally&string_search=".$newally."&strict=on\" target=\"$target_link\"";
			else
				$new_alliance_link ="";
			$tooltip = "<table width=\"188\"><tr>";
			$tooltip .= "<td class=\"b\" align=\"center\"><b>Ce joueur a changé!</b></td>";
			$tooltip .= "</tr><tr>";
			$tooltip .= "<td class=\"c\" align=\"center\">Son pseudo: <a$new_joueur_link>$new_name</a></td>";
			$tooltip .= "</tr><tr>";
			$tooltip .= "<td class=\"c\" align=\"center\">Son alliance: <a$new_alliance_link>".($new_ally?$new_ally:'<i>(aucune)</i>')."</a></td>";
			$tooltip .= "</tr><tr>";
			$tooltip .= "<th align=\"center\"><sup><i><blink><a href=\"$modify_link\">Cliquez pour mettre à jour</blink></i></sup></td>";
			$tooltip .= "</tr></table>";
			$tooltip = htmlentities($tooltip);
			$tooltip = " onmouseover=\"this.T_WIDTH=190;this.T_TEMP=15000;return escape('".$tooltip."')\"";

			// On ajoute une icone au texte Action
			$s_action.="<a onclick='this.form.submit()' $tooltip><input type='image' width='15' height='15' src='".FOLDER_QMS."/images/modify.png' name = 'Modification de l\'espionnage n°".$table_spy["id"][$j]."'></a>\n</form>";
		}
	}
	else 
	*/	$s_action = "&nbsp";
	// Texte de l'espionnage
	$retour = "<tr>";
	$retour.="<td class='e' align='center' valign='center' rowspan='2'>$s_action</td><td class='c'>$s_date</td>";
	$retour.="<td class='c'>".$lang['qms_format_spy_title_ogame']."</td>";
	$retour.="</tr>\n";
	$retour.="<tr>";
	$retour.="<th colspan='3' class='f' align='left'>";
	$retour.=sprintf($lang['qms_format_spy_content_ogame'],$s_joueur,$s_alliance,$s_position,$s_cible_name,$s_cible,$s_proba)."</th>";
	$retour.="</tr>\n";

	// Ligne vide pour aérer
	echo"<tr><td class='e' colspan='4'>&nbsp</td></tr>\n\n";

	return $retour;
}
?>