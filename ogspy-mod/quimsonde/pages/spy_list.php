<?php
/**
 * spy_list.php 

Affiche la liste des espionnages

 * @package QuiMSonde
 * @author Sylar
 * @link http://ogsteam.fr
 * @version : 1.5.1
 * dernière modification : 11.08.08

 */
// On récupére les données
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Definition
global $user_data;

// Initialisation de l'affichage (public ou privé?)
$private=isset($pub_viewall)&&($pub_viewall=="1")? false : true;

// Initialisation des Filtres
$filtre = ""; $filtre_url = "";
$filtre_type = Array('position','joueur','alliance','cible');
foreach( $filtre_type as $type )
	if( isset(${'pub_filtre_'.$type}) && (${'pub_filtre_'.$type}!="-") ) $filtre = $type;
		else ${'pub_filtre_'.$type} = "-";
if($filtre!="") $filtre_url = "&filtre_".$filtre."=".${'pub_filtre_'.$filtre};

// Récupération des espionnage
// Récupération du nombre de ligne / pages à afficher
$pages_lgs = get_qms_config('lignes',$user_data['user_id']);

// Calcul du 1er enregistrement à afficher
$start=($pub_pagenum-1)*$pages_lgs;
qms_debug("start : ".$start);

// Nombre d'espionnage en tout
$max_spy = get_espionnage_count(
				$private?$user_data['user_id']:0,
				$private?"WHERE `sender_id`='".$user_data['user_id']."'":"",
				$filtre,
				isset(${'pub_filtre_'.$filtre})?${'pub_filtre_'.$filtre}:""
			);
qms_debug("max_spy : ".$max_spy);

// Si y'a pas assez d'espionnage, on remonte d'une page.
while($start>=$max_spy&&$pub_pagenum>1)
	$start=((--$pub_pagenum)-1)*$pages_lgs;

// Récupération des espionnages a afficher
$table_spy=get_spies(
	$private?$user_data['user_id']:0,
	$filtre,
	isset(${'pub_filtre_'.$filtre})?${'pub_filtre_'.$filtre}:"",
	isset($pub_sort)?$pub_sort:"",
	isset($pub_ord)?$pub_ord:"",
	" LIMIT ".$start.", ".$pages_lgs
);
qms_debug("count(table_spy) : ".count($table_spy['id']));

// Nombre de pages totales
$max_page = ceil($max_spy/$pages_lgs);

// Initialisation des liens
$string_url = "index.php?action=$mod_name&page=$pub_page".($private?'':'&viewall=1');

// Affichage des listes de filtrage
?>
<fieldset>
<legend>
	<font color='#80FFFF'>
		<b><?php echo ($private?$lang['qms_menu_mes_espions']:$lang['qms_menu_les_espions'])." ".help($private?'qms_mes espionnages':'qms_les espions'); ?></b>
	</font>
</legend>
<!-- Les Filtres -->
<table width='100%' border='0'>
	<tr>
<?php foreach($filtre_type as $key  => $type){ ?>
		<td width='20%' align='center'>
			<form action='<?php echo $string_url; ?>' method='post'>
				<select id='filtre_<?php echo $type."' name='filtre_".$type; ?>' style='width:150px;' onchange='this.form.submit();'>
<?php echo make_liste_string($type,${'pub_filtre_'.$type},$private); ?>
				</select>
			</form>
		</td>
<?php
		}
		if(!$private){ ?>
		<td width='20%' align='center'>
			<form action='<?php echo $string_url; ?>' method='post'>
				<select id='filtre_cible' name='filtre_cible' style='width:150px;' onchange='this.form.submit();'>
<?php echo make_liste_string('sender_id',$pub_filtre_cible,$private); ?>
				</select>
			</form>
		</td>
<?php
		} ?>
	</tr>
</table>

<?php
// Affichage du tableau de listage
if($max_spy>0){  

	if(count($table_spy['id'])>50) make_changepage_table($pub_pagenum,$max_page,$string_url);

	// Calcul du dernier enregistrement à afficher
	$stop=$start+$pages_lgs;
	if($stop>$max_spy) $stop=$max_spy;

	// 1ere ligne
	$entete_tableau = Array (			Array ( 'class'=>'d',	'sort' => '',					'label' => '&nbsp',		'width' => '20' ),
												Array ( 'class'=>'d',	'sort' => '',					'label' => '&nbsp',		'width' => '10' ),
												Array ( 'class'=>'c',	'sort' => 'datadate',		'label' => $lang['qms_date'],		'width' => '140' ),
												Array ( 'class'=>'c',	'sort' => 'position',			'label' => $lang['qms_depart'],	'width' => '80' ),
												Array ( 'class'=>'c',	'sort' => 'joueur',			'label' => $lang['qms_joueur'],	'width' => '180' ),
												Array ( 'class'=>'c',	'sort' => 'alliance',			'label' => $lang['qms_alliance'],	'width' => '100' ),
												Array ( 'class'=>'c',	'sort' => 'distance',			'label' => $lang['qms_distance'],	'width' => '80' ),
												Array ( 'class'=>'c',	'sort' => 'cible',				'label' => $lang['qms_cible'],		'width' => ($private?'110':'180') ),
												Array ( 'class'=>'c',	'sort' => 'pourcentage',	'label' => '%',			'width' => '40' )
									);

	// Dessin du tableau
	echo"\n\n<!-- Entête du tableau -->\n";
	echo"<table>\n\t<tr>\n";
	$string_url .= $filtre_url;
	foreach($entete_tableau as $key => $entete){
		echo"\t\t<td class='".$entete['class']."' align='center' width = '".$entete['width']."'>";
		if($entete['sort']!="") echo"<a href='$string_url&sort=".$entete['sort']."&ord=desc'><img src='images/desc.png'></a>";
		echo"<b> ".$entete['label']." </b>";
		if($entete['sort']!="") echo"<a href='$string_url&sort=".$entete['sort']."&ord=asc'><img src='images/asc.png'></a>";
		echo"</td>\n";
	}
	echo"\t</tr>\n";
	echo"\n\n<!-- La liste -->\n";
	if(isset($pub_sort)) $string_url .= "&sort=".$pub_sort."&ord=".$pub_ord;
	echo"<form id ='spy_list' action='$string_url&pagenum=$pub_pagenum' method='post'>\n";

	// Création des lignes d'espionnage
	$modify_all_link = "";
	for($j=0;$j<count($table_spy["id"]);$j++){

		// Formattage des champs

		//-------------DATE
		$out_date = "<b>".date($lang['qms_format_full'], $table_spy["datadate"][$j])."</b>";
		//-------------POSITION
		$temp = get_galaxy_link($table_spy["position"][$j])."'".get_tooltip($table_spy["position"][$j],'Position',0,$table_spy["id"][$j]);
		$temp = "<a href='index.php?action=galaxy&galaxy=".$temp.">".$table_spy["position"][$j]."</a>";
		$out_position = $temp."<small>".stripslashes(get_spies_string($table_spy["position"][$j]))."</small>";
		$lune = (strpos($table_spy["position_name"][$j],$lang['qms_lune'])===false&&strpos($table_spy["position_name"][$j],$lang['qms_Lune'])===false?"":$lang['qms_lune_print']);
		if($table_spy["position_name"][$j]&&$table_spy["position_name"][$j]!="") $out_position .= " ".$lune;
		//-------------JOUEUR
		$link = ""; $player_unknown = '0';
		if($table_spy['joueur'][$j]!="?")
			$link = " href='index.php?action=search&type_search=player&string_search=".$table_spy['joueur'][$j]."&strict=on'".get_tooltip($table_spy["joueur"][$j],'Joueur',0,$table_spy["id"][$j]);
		else
			$player_unknown = '1';
		$out_joueur = "<b><a".$link.">".$table_spy["joueur"][$j]."</a></b>";
		//-------------ALLIANCE
		$link = "></a></b>".$lang['qms_spylist_sans_alliance']."<a><b";
		if($table_spy["alliance"][$j]!=""){
			$link=" href='index.php?action=search&type_search=ally&string_search=";
			$link.=$table_spy["alliance"][$j]."&strict=on'".get_tooltip($table_spy["alliance"][$j],'Alliance',0,$table_spy["id"][$j]);
		}
		$out_alliance = "<b><a".$link.">".$table_spy["alliance"][$j]."</a></b>";
		//-------------DISTANCE
		$out_distance = "<b>".$table_spy["distance"][$j]."</b>";
		//-------------CIBLE
		$out_cible = "<b><a href='index.php?action=galaxy&galaxy=".get_galaxy_link($table_spy["cible"][$j])."'".get_tooltip($table_spy["cible"][$j],'Cible',0,$table_spy["id"][$j]).">".$table_spy["cible"][$j]."</a></b>";
		if($table_spy["cible_name"][$j]&&$table_spy["cible_name"][$j]!="") $out_cible .= " ".(strpos($table_spy["cible_name"][$j],"Lune")===false?"":"(L)");
		if(!$private){
			$out_cible .= " - <b><a href='index.php?action=search&type_search=player&string_search=";
			$out_cible .= $cible_name=get_user_name_by_id($table_spy['sender_id'][$j]);
			$out_cible .= "&strict=on'".get_tooltip($cible_name,'Joueur',0,$table_spy["id"][$j],1).">".$cible_name."</a></b>";
		}
		//-------------POUCENTAGE
		$out_pourcentage = "<font color='#".get_color($table_spy["pourcentage"][$j])."'><b>".$table_spy["pourcentage"][$j]."%</color></font></b>";

		// Formattage des boutons
		//-------------MODIFIER
		list($new_name,$new_ally)=get_user_id($table_spy["position"][$j]);
		if(!$new_name) $new_name="?";
		if( ($private||($user_data['user_id']==$table_spy['sender_id'][$j])) && ( ($new_ally!=$table_spy["alliance"][$j]) || ($table_spy["joueur"][$j]!=$new_name) ) ){
			if($modify_all_link=="")
				$modify_all_link = $table_spy['id'][$j];
			else
				$modify_all_link .= "_x_".$table_spy['id'][$j];
			$modify_link = "$string_url&pagenum=".$pub_pagenum."&modify=".$table_spy['id'][$j];
			$new_joueur_link = ""; $new_alliance_link ="";
			if($new_name!="?")
				$new_joueur_link = " href=\"index.php?action=search&type_search=player&string_search=".$new_name."&strict=on\"";
			if($new_ally!="")
				$new_alliance_link=" href=\"index.php?action=search&type_search=ally&string_search=".$new_ally."&strict=on\"";
			$tooltip = "<table width=\"218\"><tr><td class=\"b\" align=\"center\">".$lang['qms_spylist_joueur_change']."</td>";
			$tooltip .= "</tr><tr><td class=\"c\" align=\"center\">".$lang['qms_spylist_joueur_change_pseudo']."<a$new_joueur_link>$new_name</a></td>";
			$tooltip .= "</tr><tr><td class=\"c\" align=\"center\">".$lang['qms_spylist_joueur_change_alliance']."<a$new_alliance_link>";
			$tooltip .= ($new_ally?$new_ally:$lang['qms_spylist_joueur_change_aucune_alliance'])."</a></td>";
			$tooltip .= "</tr><tr><th align=\"center\"><sup><i><a href=\"$modify_link\">".$lang['qms_spylist_link_to_modify']."</a></i></sup></th>";
			$tooltip .= "</tr></table>";
			$tooltip = htmlentities($tooltip);
			$tooltip = " onmouseover=\"this.T_WIDTH=220;this.T_TEMP=15000;return escape('".$tooltip."')\"";
			$confirm = "return confirm('".sprintf($lang['qms_spylist_link_are_your_sure_modify'],$table_spy['joueur'][$j])."')";
			$img = "<img src='".FOLDER_QMS."/images/modify.png' name='".sprintf($lang['qms_spylist_link_modify_spy'],$table_spy["id"][$j])."'>";
			$out_modify = "<a href='$modify_link' onclick=\"$confirm\" $tooltip>$img</a>";
		} 
		else  // Pas d'icone pour modifier
			$out_modify = "&nbsp";
		if($private||($user_data['user_id']==$table_spy['sender_id'][$j])/*||IsUserAdmin()*/)
			$out_checkbox="<input type='checkbox' value='".$table_spy['id'][$j]."' name='check_".$j."' id='check_".$j."' inconnu='$player_unknown' modifier='".($out_modify=="&nbsp"?'0':'1')."'>";
		else
			$out_checkbox="";
		//-------------INFO
		$link="window.open('index.php?action=$mod_name&page=popup&target=".$table_spy["id"][$j];
		$link.="','_blank','width=890, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=0, copyhistory=0, menuBar=0');return(false)";
		$out_info = "<a href=\"#\" onclick=\"$link\"><img src='".FOLDER_QMS."/images/icone_info.png' alt=\"".$lang['qms_spylist_link_information']."\" /></a>";
		//-------------EFFACER
		if($private||($user_data['user_id']==$table_spy['sender_id'][$j])){
			$delete_link = "$string_url&pagenum=".$pub_pagenum."&delete=".$table_spy['id'][$j];
			$confirm = "return confirm('".sprintf($lang['qms_spylist_link_are_your_sure_delete'],$table_spy['joueur'][$j])."')";
			$img = "<img src='".FOLDER_QMS."/images/delete.png' />";
			$out_delete = "<a href=\"$delete_link\" onclick=\"$confirm\">$img</a>";
		} else
			$out_delete = "";

		// Dessin de la ligne du tableau
?>
	<tr>
		<td class='d'><?php echo $out_modify; ?></td>
		<td class='d'><?php echo $out_checkbox; ?></td>
		<th><?php echo $out_date; ?></th>
		<th><?php echo $out_position; ?></th>
		<th><?php echo $out_joueur; ?></th>
		<th><?php echo $out_alliance; ?></th>
		<th><?php echo $out_distance; ?></th>
		<th align="<?php echo ($private?'center':'left'); ?>"><?php echo $out_cible; ?></th>
		<th><?php echo $out_pourcentage; ?></th>
		<td class='d'><?php echo $out_info; ?></td>
		<td class='d'><?php echo $out_delete; ?></td>
	</tr>
<?php
	}
	?>
	<tr>
		<td class='d'>&nbsp</td>
		<td class='d' colspan='8'>
			<img src='<?php echo FOLDER_QMS; ?>/images/arrow_ltr.png'>
			<a href="Javascript:void(0)" onClick="GereChkbox('spy_list','1');"><?php echo $lang['qms_spylist_check_tout']; ?></a> / 
			<a href="Javascript:void(0)" onClick="GereChkbox('spy_list','0');"><?php echo $lang['qms_spylist_check_aucun']; ?></a> / 
			<a href="Javascript:void(0)" onClick="GereChkbox('spy_list','2');"><?php echo $lang['qms_spylist_check_inverser']; ?></a> / 
			<a href="Javascript:void(0)" onClick="GereChkbox('spy_list','3');"><?php echo $lang['qms_spylist_check_modifies']; ?></a> / 
			<a href="Javascript:void(0)" onClick="GereChkbox('spy_list','4');"><?php echo $lang['qms_spylist_check_inconnus']; ?></a>&nbsp
			<img src='<?php echo FOLDER_QMS; ?>/images/ligne.png'>
			<input type='hidden' value='<?php echo $start; ?>' name='start'>
			<input type='hidden' value='<?php echo $stop; ?>' name='stop'>
			<select name='onselection' onchange = "if(GereChkbox('spy_list','5')){this.form.submit();}else{document.getElementById('option1').selected=true;}" >
				<option id='option1' value='-' selected><?php echo $lang['qms_spylist_check_on_selection']; ?></option>
				<option id='option_delete' value='delete'><?php echo $lang['qms_spylist_check_on_selection_suppr']; ?></option>
				<option id='option_update' value='update'><?php echo $lang['qms_spylist_check_on_selection_update']; ?></option>
			</select>
		</td>
	</tr>
</form>
<?php
	// Fin du tableau d'espionnage
	?>
</table>

<?php echo make_changepage_table($pub_pagenum,$max_page,$string_url); ?>

	<?php //Champ pour choisir le nombre d espionnage par pages  ?>
	<!-- choix du nombre d'espionnage par pages -->
<form action='<?php echo $string_url; ?>' method='post'>
	<br/><?php echo $lang['qms_spylist_nbligne_par_pages']; ?> 
<?php
	$a = 'lignes_par_pages';
	$b = get_qms_config("lignes",$user_data['user_id']);
?>
	<input name='<?php echo $a; ?>' id='<?php echo $a; ?>' type='text' size='5' onchange="if (chk_nb(<?php echo "'$a',$b"; ?>)) this.form.submit;" value='<?php echo $b; ?>'/>
</form>
<?php
}
else{ // Pas d'espionnage à lister
	if($filtre) echo "<div align='center'>".$lang['qms_spylist_no_spy_filtered_found']."</div>\n";
	else echo "<div align='center'>".$lang['qms_spylist_no_spy_found']."</div>\n";
	
}
// Fin du FieldSet ?>
	<!-- fin page <?php echo $pub_page; ?>.php -->
</fieldset>
<?php
function make_changepage_table($pub_pagenum,$max_page,$string_url){	// Tableau pour les boutons de changement de page 
	global $lang;
	if($max_page<2) return "";
	$next_page_link = $prev_page_link = "";
	// Lien vers page précédente
	if($pub_pagenum>1) $prev_page_link =  " onclick=\"window.location = '$string_url&pagenum=".($pub_pagenum-1)."';\"";
	// Lien vers page suivante
	if($pub_pagenum<$max_page) $next_page_link =  " onclick=\"window.location = '$string_url&pagenum=".($pub_pagenum+1)."';\"";
?>
	<!-- Bouton de changement de pages -->
<table width="100%">
	<tr>
		<?php 
	$style = ($prev_page_link=="")?" style='visibility:hidden;'":"";
	echo "<td class='c'$style align='center'$prev_page_link><a><<<</a></td>";

	// Liste du choix de page 
?>
		<form action='<?php echo $string_url; ?>' method='post'>
		<td class='d' align='center' colspan='2'>
			<select name='pagenum' onchange='this.form.submit();'>
<?php
	$i=1;
	while($i<=$max_page){
		echo"\t\t\t<option value='$i'";
		if($pub_pagenum==$i) echo " selected";
		echo">".sprintf($lang['qms_spylist_page_on_page'],$i,$max_page)."</option>\n";
		$i++;
	}
?>
			</select>
		</td>
</form>
<?php 
	$style = ($next_page_link=="")?" style='visibility:hidden;'":"";
	echo "<td class='c'$style align='center'$next_page_link><a>>>></a></td>";
?>
	</tr>
</table>
<?php // Fin du tableau de changement de page 
}
?>

<script type="text/javascript">
function GereChkbox(conteneur, a_faire) {
	var blnEtat=null;
	var selected_item = 0;
	var selected_count = 0;

	var Chckbox = document.forms[conteneur].elements[0]
	while (Chckbox!=null) {
		if (Chckbox.nodeName=="INPUT")
			if (Chckbox.getAttribute("type")=="checkbox") {
				if (a_faire == '0') blnEtat = false;
				if (a_faire == '1') blnEtat = true;
				if (a_faire == '2') blnEtat = (document.getElementById(Chckbox.getAttribute("id")).checked) ? false : true;
				if (a_faire == '3') blnEtat = (Chckbox.getAttribute("modifier")=='1') ? true : false;
				if (a_faire == '4') blnEtat = (Chckbox.getAttribute("inconnu")=='1') ? true : false;
				if (a_faire != '5') document.getElementById(Chckbox.getAttribute("id")).checked=blnEtat;
				if (document.getElementById(Chckbox.getAttribute("id")).checked==true) selected_count ++;
			}
		selected_item ++;
		Chckbox = document.forms[conteneur].elements[selected_item]
	}
	if (a_faire =='5') {
		if (selected_count>0) {
			if(selected_count>1){
				if(document.getElementById('option_delete').selected == true) action = "<?php echo $lang['qms_spylist_sure_to_delete_many']; ?>";
				if(document.getElementById('option_update').selected == true) action = "<?php echo $lang['qms_spylist_sure_to_modify_many']; ?>";
			}else{
				if(document.getElementById('option_delete').selected == true) action = "<?php echo $lang['qms_spylist_sure_to_delete_one']; ?>";
				if(document.getElementById('option_update').selected == true) action = "<?php echo $lang['qms_spylist_sure_to_modify_one']; ?>";
			}
			return confirm(action,"aa");
		}else{
			alert("<?php echo $lang['qms_spylist_vous_navez_rien_selectionne']; ?>","aa");
			return 0;
		}
	}
}
</script>
