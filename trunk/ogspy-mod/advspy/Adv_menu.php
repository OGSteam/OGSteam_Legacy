<?php
/***************************************************************************
*	filename	: Adv_menu.php
*	desc.		: AdvSpy, mod for OGSpy.
*	Author		: kilops - http://ogs.servebbs.net/
*	created		: 16/08/2006
***************************************************************************/

// Déclarations OgSpy
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
if (!defined('IN_MOD_ADVSPY')) die("Hacking attempt");



function AdvSpy_PrintHtml_Menu_Tris(){
	global $lang,$AdvSpyConfig,$BlockRecherche;
	
	print "<fieldset style=\"padding: 1px;\"><legend><b> Ordre de Tris </b></legend>";
	print "<select size=\"1\" name=\"AdvSpy_TRIS\">";
	foreach($AdvSpyConfig['Liste_Tris'] as $num=>$nom){
		if ($num==$BlockRecherche['AdvSpy_TRIS']) {
			$selected=" selected";
		} else {
			$selected="";
		}
		print "<option value=\"$num\"$selected>$nom</option>\n";
	}	
	print "</select>\n";

	print "
	<table border=\"0\" width=\"100%\" id=\"AdvSpyTableResultMinMax\" style=\"border-collapse: collapse\" align=\"center\">
	<tr>
		<td colspan=\"2\" align=\"center\">
		<a onClick=\"AdvSpy_SearchResultMoin();\" style=\"cursor:pointer\" >&lt;&nbsp;-</a>&nbsp;
		<a onClick=\"oldPP=(parseInt(document.getElementById('AdvSpy_SearchResult_Max').value,10)-parseInt(document.getElementById('AdvSpy_SearchResult_Min').value,10))+1;newPP=parseInt(prompt('Afficher combien de résultats par page ?',oldPP));document.getElementById('AdvSpy_SearchResult_Max').value=parseInt(document.getElementById('AdvSpy_SearchResult_Min').value,10)+newPP-1;document.getElementById('AdvSpy_SearchResult_PerPage').innerHTML=newPP;\" style=\"cursor:pointer;font-weight:normal\" id=\"AdvSpy_SearchResult_PPTitle\">Afficher <span id=\"AdvSpy_SearchResult_PerPage\">".(( $BlockRecherche['AdvSpy_SearchResult_Max'] - $BlockRecherche['AdvSpy_SearchResult_Min'] )+1)."</span> résultats</a>
		<a onClick=\"AdvSpy_SearchResultPlus();\" style=\"cursor:pointer\" >+&nbsp;&gt;</a>
		</td>
	</tr>
	<tr>
		<td align=\"center\">de <input type=\"text\" name=\"AdvSpy_SearchResult_Min\" id=\"AdvSpy_SearchResult_Min\" size=\"4\" value=\"".$BlockRecherche['AdvSpy_SearchResult_Min']."\" onkeyup=\"document.getElementById('AdvSpy_SearchResult_PerPage').innerHTML=(parseInt(document.getElementById('AdvSpy_SearchResult_Max').value,10)-parseInt(document.getElementById('AdvSpy_SearchResult_Min').value,10))+1\" ></td>
		<td align=\"center\">À  <input type=\"text\" name=\"AdvSpy_SearchResult_Max\" id=\"AdvSpy_SearchResult_Max\" size=\"4\" value=\"".$BlockRecherche['AdvSpy_SearchResult_Max']."\" onkeyup=\"document.getElementById('AdvSpy_SearchResult_PerPage').innerHTML=(parseInt(document.getElementById('AdvSpy_SearchResult_Max').value,10)-parseInt(document.getElementById('AdvSpy_SearchResult_Min').value,10))+1\" ></td>
	</tr>
	</table>
	";
	
	print "<div align=\"center\" style=\"text-align: center;\">";
	if (($BlockRecherche['AdvSpy_OnlyMyScan']=="ON") ) { // coché par défaut
		print "<input type=\"checkbox\" name=\"AdvSpy_OnlyMyScan\" id=\"AdvSpy_OnlyMyScan\" value=\"ON\" checked>";
	} else {
		print "<input type=\"checkbox\" name=\"AdvSpy_OnlyMyScan\" id=\"AdvSpy_OnlyMyScan\" value=\"ON\">";
	}
	print "<label title=\"N'affiche que mes RE que j'ai envoyé moi mÀªme\" style=\"cursor:pointer\" for=\"AdvSpy_OnlyMyScan\">Afficher uniquement <u>mes</u> RE</label>\n";
	
	print "</div>";

	
	print "</fieldset>";
}


function AdvSpy_PrintHtml_Menu_Secteur(){
	global $AdvSpyConfig, $lang,$BlockRecherche;

	print "<fieldset style=\"padding: 1px;\">
<legend><b> Secteur </b></legend>
<p align=\"center\">
<table border=\"0\" width=\"100px\" id=\"AdvSpyTable2\" style=\"border-collapse: collapse\">
	<tr>
		<td></td>
		<td>Galaxie</td>
		<td>Système</td>
		<td>Rang</td>
	</tr>
	<tr>
		<td>Min</td>
		<td><input type=\"text\" name=\"AdvSpy_GalaxyMin\" id=\"AdvSpy_GalaxyMin\" size=\"1\" value=\"".$BlockRecherche['AdvSpy_GalaxyMin']."\"></td>
		<td><input type=\"text\" name=\"AdvSpy_SystemMin\" id=\"AdvSpy_SystemMin\" size=\"3\" value=\"".$BlockRecherche['AdvSpy_SystemMin']."\"></td>
		<td><input type=\"text\" name=\"AdvSpy_RowMin\" id=\"AdvSpy_RowMin\" size=\"2\" value=\"".$BlockRecherche['AdvSpy_RowMin']."\"></td>
	</tr>
	<tr>
		<td>Max</td>
		<td><input type=\"text\" name=\"AdvSpy_GalaxyMax\" id=\"AdvSpy_GalaxyMax\" size=\"1\" value=\"".$BlockRecherche['AdvSpy_GalaxyMax']."\"></td>
		<td><input type=\"text\" name=\"AdvSpy_SystemMax\" id=\"AdvSpy_SystemMax\" size=\"3\" value=\"".$BlockRecherche['AdvSpy_SystemMax']."\"></td>
		<td><input type=\"text\" name=\"AdvSpy_RowMax\" id=\"AdvSpy_RowMax\" size=\"2\" value=\"".$BlockRecherche['AdvSpy_RowMax']."\"></td>
	</tr>
	<tr>
		<td colspan=\"4\" >
			<b>";

	if ($AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max'] == 9) {
	// ogame normal
		print "<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='1';document.getElementById('AdvSpy_GalaxyMax').value='".$AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max']."';document.getElementById('AdvSpy_SystemMin').value='1';document.getElementById('AdvSpy_SystemMax').value='".$AdvSpyConfig['Settings']['OgameUniverse_System_Max']."';document.getElementById('AdvSpy_RowMin').value='1';document.getElementById('AdvSpy_RowMax').value='".$AdvSpyConfig['Settings']['OgameUniverse_Row_Max']."';\" title=\"Tous l'univers\">[*]</a>&nbsp;&nbsp;
<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='1';document.getElementById('AdvSpy_GalaxyMax').value='1';\" title=\"Galaxie 1\">[1]</a>&nbsp;&nbsp;
<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='2';document.getElementById('AdvSpy_GalaxyMax').value='2';\" title=\"Galaxie 2\">[2]</a>&nbsp;&nbsp;
<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='3';document.getElementById('AdvSpy_GalaxyMax').value='3';\" title=\"Galaxie 3\">[3]</a>&nbsp;&nbsp;
<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='4';document.getElementById('AdvSpy_GalaxyMax').value='4';\" title=\"Galaxie 4\">[4]</a><br/>
<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='5';document.getElementById('AdvSpy_GalaxyMax').value='5';\" title=\"Galaxie 5\">[5]</a>&nbsp;&nbsp;
<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='6';document.getElementById('AdvSpy_GalaxyMax').value='6';\" title=\"Galaxie 6\">[6]</a>&nbsp;&nbsp;
<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='7';document.getElementById('AdvSpy_GalaxyMax').value='7';\" title=\"Galaxie 7\">[7]</a>&nbsp;&nbsp;
<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='8';document.getElementById('AdvSpy_GalaxyMax').value='8';\" title=\"Galaxie 8\">[8]</a>&nbsp;&nbsp;
<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='9';document.getElementById('AdvSpy_GalaxyMax').value='9';\" title=\"Galaxie 9\">[9]</a>";

	} elseif ($AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max'] == 50) {
	//nombre de galaxie
		print "<font size=\"1\">";
		print "<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='1';document.getElementById('AdvSpy_GalaxyMax').value='".$AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max']."';document.getElementById('AdvSpy_SystemMin').value='1';document.getElementById('AdvSpy_SystemMax').value='".$AdvSpyConfig['Settings']['OgameUniverse_System_Max']."';document.getElementById('AdvSpy_RowMin').value='1';document.getElementById('AdvSpy_RowMax').value='".$AdvSpyConfig['Settings']['OgameUniverse_Row_Max']."';\" title=\"Tous l'univers\">[*-*]</a>&nbsp;\n";
		$i=0;
		while($i<=9){
			$s=$i*5+1;
			$e=$i*5+5;
			print "<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_GalaxyMin').value='$s';document.getElementById('AdvSpy_GalaxyMax').value='$e';\" title=\"Galaxie ".$s." À  ".$e."\">[".$s."-".$e."]</a>&nbsp;\n";
			$i++;
		} // while

		print "</font>";
		
	} // fin elseif
	
	print "			</b>
		</td>
	</tr>
	
	
	<tr>
        <td colspan=\"4\" >
            <b>À  +- <input type=\"text\" name=\"rangeSys\" size=\"3\" id=\"rangeSys\" value=\"20\" onChange=\"AdvSpy_SelPlanette(document.getElementById('planetteSel').value,this.value)\"> systèmes de :<br/>
            <select name=\"planetteSel\"  id=\"planetteSel\" onChange=\"AdvSpy_SelPlanette(this.value,document.getElementById('rangeSys').value)\">
            <option value=''>Aucune</option>
            ".AdvSpy_GetEmpirePlanetsListAsOptions()."
            </select>
            </b>
        </td>
    </tr>
	
	
</table>
<br/>
Cacher ces planètes :<br/>
<input type=\"text\" name=\"AdvSpy_CoordsToHide\" id=\"AdvSpy_CoordsToHide\" size=\"20\" value=\"".$BlockRecherche['AdvSpy_CoordsToHide']."\">
<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_CoordsToHide').value='';AdvSpy_DivResult_SHOWALL();\" title='Effacer la liste'><img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."images/clear.png\" border=\"0\"></a>
</p>
</fieldset>";

}

function AdvSpy_PrintHtml_Menu_RE(){
	global $AdvSpyConfig, $lang,$BlockRecherche;
	print "<fieldset style=\"padding: 5px;\">\n<legend><b> Rapport d'espionnage </b></legend>Age max du RE :</b>\n";
	print AdvSpy_GetHtml_Menu_ListeAgeMax();
	print "<br/>\n";
	print AdvSpy_GetHtml_Menu_NoDoublon();
	print AdvSpy_GetHtml_Menu_ShowOnlyMoon();
	print "<br/>\n";
	print AdvSpy_GetHtml_Menu_DetailSondage();
	//$BlockRecherche['AdvSpy_PlanetSearch']
	print "<br/>Nom de planète (ou de lune) :<br/><input type=\"text\" name=\"AdvSpy_PlanetSearch\" id=\"AdvSpy_PlanetSearch\" value=\"".$BlockRecherche['AdvSpy_PlanetSearch']."\"/>
	<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_PlanetSearch').value=''\" title='Effacer la recherche'><img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."images/clear.png\" border=\"0\"></a>
	";
	print "</fieldset>\n";
}

function AdvSpy_GetHtml_Menu_ListeAgeMax(){
	global $AdvSpyConfig, $lang,$BlockRecherche;
	$out="<select size=\"1\" name=\"AdvSpy_AgeMax\">";
	foreach($AdvSpyConfig['Settings']['ListeAgeMax'] as $age){
		if ($BlockRecherche['AdvSpy_AgeMax']==$age) {
		    $out.="<option value=\"$age\" selected>".AdvSpy_duration($age)."</option>\n";
		} else {
		    $out.="<option value=\"$age\">".AdvSpy_duration($age)."</option>\n";
		}
	}
	$out.="</select>\n";
	return $out;
}

function AdvSpy_GetHtml_Menu_NoDoublon(){
	global $AdvSpyConfig, $lang,$BlockRecherche;
	$out="";
	
	if (($BlockRecherche['AdvSpy_NoDoublon']=="ON") OR (!$BlockRecherche['ChercherOK']) ) { // coché par défaut
		$out.="<input type=\"checkbox\" name=\"AdvSpy_NoDoublon\" id=\"AdvSpy_NoDoublon\" value=\"ON\" checked>";
	} else {
		$out.="<input type=\"checkbox\" name=\"AdvSpy_NoDoublon\" id=\"AdvSpy_NoDoublon\" value=\"ON\">";
	}
	$out.="<label title=\"N'affiche que le dernier RE par planète\" style=\"cursor:pointer\" for=\"AdvSpy_NoDoublon\">Pas de doublons.</label><br/>\n";
	return $out;
}

function AdvSpy_GetHtml_Menu_ShowOnlyMoon(){
	global $AdvSpyConfig, $lang,$BlockRecherche;
	$out="";
	if (($BlockRecherche['AdvSpy_ShowOnlyMoon']=="ON")) {
		$out.="<input type=\"checkbox\" name=\"AdvSpy_ShowOnlyMoon\" id=\"AdvSpy_ShowOnlyMoon\" value=\"ON\" checked>";
	} else {
		$out.="<input type=\"checkbox\" name=\"AdvSpy_ShowOnlyMoon\" id=\"AdvSpy_ShowOnlyMoon\" value=\"ON\">";
	}
	$out.="<label title=\"N'affiche que les lunes\" style=\"cursor:pointer\" for=\"AdvSpy_ShowOnlyMoon\">Uniquement les lunes.</label><br/>\n";
	return $out;
}

function AdvSpy_GetHtml_Menu_DetailSondage(){
	global $AdvSpyConfig, $lang,$BlockRecherche;
	$out="";
	$SpyCatList=$lang['DicOgame']['SpyCatList'];
	foreach($SpyCatList as $Cat=>$name){

		if ($BlockRecherche["AdvSpy_Scanned_$Cat"]=="ON") { 
			$out.="<input type=\"checkbox\" name=\"AdvSpy_Scanned_$Cat\" id=\"AdvSpy_Scanned_$Cat\" value=\"ON\" checked>\n";
		} else {
			$out.="<input type=\"checkbox\" name=\"AdvSpy_Scanned_$Cat\" id=\"AdvSpy_Scanned_$Cat\" value=\"ON\">\n";
		}
		$out.="<label style=\"cursor:pointer\" for=\"AdvSpy_Scanned_$Cat\" title=\"N'affiche que les rapports qui on pu scanner les $name \"><font color='".$AdvSpyConfig['color'][$Cat]."'>Scan $name ?</font></label><br/>\n";

		if ($BlockRecherche["AdvSpy_Reduire_$Cat"]=="ON") { 
			$out.="<input type=\"checkbox\" name=\"AdvSpy_Reduire_$Cat\" id=\"AdvSpy_Reduire_$Cat\" value=\"ON\" onClick=\"if (this.checked) { AdvSpy_DivCat_".$Cat."_HIDEALL() } else { AdvSpy_DivCat_".$Cat."_SHOWALL() } ;\" checked>\n";
		} else {
			$out.="<input type=\"checkbox\" name=\"AdvSpy_Reduire_$Cat\" id=\"AdvSpy_Reduire_$Cat\" value=\"ON\" onClick=\"if (this.checked) { AdvSpy_DivCat_".$Cat."_HIDEALL() } else { AdvSpy_DivCat_".$Cat."_SHOWALL() } ;\" >\n";
		}
		$out.="<label style=\"cursor:pointer\" for=\"AdvSpy_Reduire_$Cat\" title=\"Réduit la vue des $name À  l'affichage\"><font color='".$AdvSpyConfig['color'][$Cat]."'>Réduire ?</font></label><br/>\n";

		
	}
	return $out;
}


 
 
function AdvSpy_PrintHtml_Menu_Player(){
	global $AdvSpyConfig, $lang,$BlockRecherche;

	print "<fieldset style=\"padding: 5px;\"><legend><b> Joueur </b></legend>\n";

	// Joueurs inactifs
	if ($BlockRecherche['AdvSpy_OnlyInactif']=="ON") {
		print "<input type=\"checkbox\" name=\"AdvSpy_OnlyInactif\" id=\"AdvSpy_OnlyInactif\" value=\"ON\" checked>";
	} else {
		print "<input type=\"checkbox\" name=\"AdvSpy_OnlyInactif\" id=\"AdvSpy_OnlyInactif\" value=\"ON\">";
	}
	print "<label style=\"cursor:pointer\" for=\"AdvSpy_OnlyInactif\">Joueur inactif (<blink><font color='red'>iI</font></blink>)</label><br/><br/>\n";
	
	// Recherche par nom de joueur
	print "Nom joueur :<br/><input type=\"text\" name=\"AdvSpy_PlayerSearch\" id=\"AdvSpy_PlayerSearch\" size=\"15\" value=\"".$BlockRecherche['AdvSpy_PlayerSearch']."\">
	<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_PlayerSearch').value=''\" title='Effacer la recherche'><img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."images/clear.png\" border=\"0\"></a><br/>";

	// Recherche par alliance
	print "Tag alliance :<br/><input type=\"text\" name=\"AdvSpy_AllySearch\" id=\"AdvSpy_AllySearch\" size=\"7\" value=\"".$BlockRecherche['AdvSpy_AllySearch']."\">
	<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_AllySearch').value=''\" title='Effacer la recherche'><img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."images/clear.png\" border=\"0\"></a>";

	print "</fieldset>";
}



function AdvSpy_PrintHtml_Menu_Ressources(){
	global $AdvSpyConfig, $lang,$BlockRecherche;

	print "<fieldset style=\"padding: 5px;\"><legend><b> Ressources </b></legend>\n";

	// Seuil 'grand nombre'
	print "Seuil 'Grand Nombre'<br/>\n";
	print "<input type=\"text\" name=\"AdvSpy_SeuilGrandNombre\" id=\"AdvSpy_SeuilGrandNombre\" size=\"5\" value=\"".$BlockRecherche['AdvSpy_SeuilGrandNombre']."\"> K<br/>";

	if ($BlockRecherche['AdvSpy_OnlyGrandNombre']=="ON") {
		print "<input type=\"checkbox\" name=\"AdvSpy_OnlyGrandNombre\" id=\"AdvSpy_OnlyGrandNombre\" value=\"ON\" checked>";
	} else {
		print "<input type=\"checkbox\" name=\"AdvSpy_OnlyGrandNombre\" id=\"AdvSpy_OnlyGrandNombre\" value=\"ON\">";
	}
	print "<label style=\"cursor:pointer\" for=\"AdvSpy_OnlyGrandNombre\" title=\"N'affiche le RE que si une des ressources dépasse le seuil 'Grand Nombre'\">Que si dépassé.</label><br/>";

	// Metal Mini (0=aucun)
	print "<br/><table><tr><td><a style=\"cursor:pointer\" onClick=\"AdvSpy_SetMinMetal(0)\" title=\"Remettre À  0\">Metal Mini : </a></td>\n";
	print "<td><input type=\"text\" name=\"AdvSpy_RessourceMinMetal\" id=\"AdvSpy_RessourceMinMetal\" size=\"5\" value=\"".$BlockRecherche['AdvSpy_RessourceMinMetal']."\"> K</td></tr>";

	// Cristal Mini (0=aucun)
	print "<tr><td><a style=\"cursor:pointer\" onClick=\"AdvSpy_SetMinCristal(0)\" title=\"Remettre À  0\">Cristal Mini : </a></td>\n";
	print "<td><input type=\"text\" name=\"AdvSpy_RessourceMinCristal\" id=\"AdvSpy_RessourceMinCristal\" size=\"5\" value=\"".$BlockRecherche['AdvSpy_RessourceMinCristal']."\"> K</td></tr>";

	// Deut Mini (0=aucun)
	print "<tr><td><a style=\"cursor:pointer\" onClick=\"AdvSpy_SetMinDeut(0)\" title=\"Remettre À  0\">Deut Mini : </a></td>\n";
	print "<td><input type=\"text\" name=\"AdvSpy_RessourceMinDeut\" id=\"AdvSpy_RessourceMinDeut\" size=\"5\" value=\"".$BlockRecherche['AdvSpy_RessourceMinDeut']."\"> K</td></tr>";

	// Energie Mini (0=aucun)
	print "<tr><td><a style=\"cursor:pointer\" onClick=\"AdvSpy_SetMinEnergie(0)\" title=\"Remettre À  0\">Energie Mini : </a></td>\n";
	print "<td><input type=\"text\" name=\"AdvSpy_RessourceMinEnergie\" id=\"AdvSpy_RessourceMinEnergie\" size=\"5\" value=\"".$BlockRecherche['AdvSpy_RessourceMinEnergie']."\"> K</td></tr>";
	
	print "</table></fieldset>";

}



function AdvSpy_PrintHtml_Menu_Analyses(){
	global $AdvSpyConfig, $lang,$BlockRecherche;

	print "<fieldset style=\"padding: 5px;\"><legend><b> Analyse </b></legend>\n";

	// Taux de patate mini
	print "<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_TauxPatateMini').value='85'\" title='Click pour 85%'>Taux de PATATE mini:</a><br/>\n";
	print "<input type=\"text\" name=\"AdvSpy_TauxPatateMini\" id=\"AdvSpy_TauxPatateMini\" size=\"5\" value=\"".$BlockRecherche['AdvSpy_TauxPatateMini']."\"> %<br/>";

	print "<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_PatateTotalMin').value=''\" title='Patate mini'>".$lang['BlockRechercheElements']['AdvSpy_PatateTotalMin']['Name'].":</a><br/>\n";
	print "<input type=\"text\" name=\"AdvSpy_PatateTotalMin\" id=\"AdvSpy_PatateTotalMin\" size=\"5\" value=\"".$BlockRecherche['AdvSpy_PatateTotalMin']."\"> P<br/>";

	print "<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_PatateTotalMax').value=''\" title='Patate maxi'>PATATE maxi:</a><br/>\n";
	print "<input type=\"text\" name=\"AdvSpy_PatateTotalMax\" id=\"AdvSpy_PatateTotalMax\" size=\"5\" value=\"".$BlockRecherche['AdvSpy_PatateTotalMax']."\"> P<br/>";

	print "<br/>";
	
	if ($BlockRecherche['AdvSpy_HideRaided']=="ON") {
		print "<input type=\"checkbox\" name=\"AdvSpy_HideRaided\" id=\"AdvSpy_HideRaided\" value=\"ON\" onClick=\"if (this.checked) { document.getElementById('AdvSpy_OnlyRaided').checked=0 };\" checked>";
	} else {
		print "<input type=\"checkbox\" name=\"AdvSpy_HideRaided\" id=\"AdvSpy_HideRaided\" value=\"ON\" onClick=\"if (this.checked) { document.getElementById('AdvSpy_OnlyRaided').checked=0 };\">";
	}
	print "<label style=\"cursor:pointer\" for=\"AdvSpy_HideRaided\" title=\"Cacher les RE raidés\">Cacher les RE raidés</label><br/>";
	
	if ($BlockRecherche['AdvSpy_OnlyRaided']=="ON") {
		print "<input type=\"checkbox\" name=\"AdvSpy_OnlyRaided\" id=\"AdvSpy_OnlyRaided\" value=\"ON\" onClick=\"if (this.checked) { document.getElementById('AdvSpy_HideRaided').checked=0 };\" checked>";
	} else {
		print "<input type=\"checkbox\" name=\"AdvSpy_OnlyRaided\" id=\"AdvSpy_OnlyRaided\" value=\"ON\" onClick=\"if (this.checked) { document.getElementById('AdvSpy_HideRaided').checked=0 };\">";
	}
	print "<label style=\"cursor:pointer\" for=\"AdvSpy_OnlyRaided\" title=\"N'afficher que les RE raidés\">N'afficher que les RE raidés</label><br/>";

	
	print "il y a moin de...<br/>";
	print "<select size=\"1\" name=\"AdvSpy_RaidAgeMax\" id=\"AdvSpy_RaidAgeMax\">";
	foreach($AdvSpyConfig['Settings']['ListeAgeMax'] as $age){
		if ($BlockRecherche['AdvSpy_RaidAgeMax']==$age) {
		    print "<option value=\"$age\" selected>".AdvSpy_duration($age)."</option>\n";
		} else {
		    print "<option value=\"$age\">".AdvSpy_duration($age)."</option>\n";
		}
	}
	print "</select>\n";

	print "</fieldset>\n";

}



function AdvSpy_GetHtml_Menu_LISTES($SingleSpyCat='',$hide=1){
	global $AdvSpyConfig, $lang,$BlockRecherche;
	$out="";
	if ($SingleSpyCat!='') {
	    if ($SingleSpyCatName=$lang['DicOgame']['SpyCatList'][$SingleSpyCat]) {
	        $SpyCatList=array($SingleSpyCat=>$SingleSpyCatName);
	    } else {
			$SpyCatList=$lang['DicOgame']['SpyCatList'];
		}
	} else {
		$SpyCatList=$lang['DicOgame']['SpyCatList'];
	}
	
	if ($hide==1) {
		$hidestyle=" style='visibility:hidden;display:none;'";
	} else {
		$hidestyle="";
	}
	
	foreach($SpyCatList as $Cat=>$Catname){
		$CatColor=$AdvSpyConfig['color'][$Cat];
		$out.="<fieldset style=\"padding: 3px;\"><legend><a style=\"cursor:pointer\" title=\"Click pour Afficher/Masquer\" onClick=\"AdvSpy_ToggleVisibilityFromID('AdvSpy_DivMenuListes_$Cat')\">
		<b> $Catname </b></a> | <label style=\"cursor:pointer\" for=\"AdvSpy_Reduire_$Cat\" title=\"Réduit la vue des $Catname À  l'affichage\">
		<font color='".$AdvSpyConfig['color'][$Cat]."'><b>R?</b></font></label> </legend>
		<div id=\"AdvSpy_DivMenuListes_$Cat\"$hidestyle>\n";
		
		$out.="<table>";
		
		foreach($lang['DicOgame'][$Cat] as $num=>$valuesarray){
			$Name=$valuesarray['Name'];
			$PostVar="AdvSpy_".$valuesarray['PostVar'];
			$PostVarMin=$PostVar."_Min";
			$PostVarMax=$PostVar."_Max";
			
			$out.="<tr><td class=\"f\">";
			
			$out.="<a style=\"cursor:pointer\" onClick=\"SwapOptionList('".$PostVar."');\">
<font color='$CatColor'>".$Name." :</font></a>

</td><td class=\"b\">

<select name=\"".$PostVar."\" id=\"".$PostVar."\" size=\"1\" style=\"font-weight: bold;\" onChange=\"CheckOptionList('".$PostVar."')\">";
			if ($BlockRecherche[$PostVar]=="indifferent") {
			    $out.="<option value=\"indifferent\" selected>Indifférent</option>";
			} else {
				$out.="<option value=\"indifferent\">Indifférent</option>";
			}
			if ($BlockRecherche[$PostVar]=="present") {
			    $out.="<option value=\"present\" style=\"color: red\" selected>Présent (au moins 1)</option>";
			} else {
				$out.="<option value=\"present\" style=\"color: red\">Présent (au moins 1)</option>";
			}
			if ($BlockRecherche[$PostVar]=="absent") {
			    $out.="<option value=\"absent\" style=\"color: green\" selected>Absent</option>";
			} else {
				$out.="<option value=\"absent\" style=\"color: green\">Absent</option>";
			}
			$out.="</select></td><td class=\"b\">";
			$out.="Min: <input type=\"text\" name=\"".$PostVarMin."\" id=\"".$PostVarMin."\" size=\"3\" value=\"".$BlockRecherche[$PostVarMin]."\"></td><td class=\"b\">";
			$out.="Max: <input type=\"text\" name=\"".$PostVarMax."\" id=\"".$PostVarMax."\" size=\"3\" value=\"".$BlockRecherche[$PostVarMax]."\">\n</td></tr>\n";
		}
		$out.="\n</table>\n</div></fieldset>\n";
		//$out.=AdvSpy_GetHtml_SubmitBT();
	}
	return $out;
}

function AdvSpy_PrintHtml_Menu_FIN() {
	print "</td>\n\n\n\n";
}



?>