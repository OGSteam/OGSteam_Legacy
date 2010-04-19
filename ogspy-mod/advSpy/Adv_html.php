<?php
/***************************************************************************
*	filename	: Adv_html.php
*	desc.		: AdvSpy, mod for OGSpy.
*	Author		: kilops - http://ogs.servebbs.net/
*	created		: 16/08/2006
***************************************************************************/

// Déclarations OgSpy
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
if (!defined('IN_MOD_ADVSPY')) die("Hacking attempt");



function AdvSpy_PrintHtml_Header(){
	global $AdvSpyConfig, $lang;
	print "
<form method='POST' name='AdvSpyFrm' enctype='multipart/form-data' action='?action=AdvSpy'>
<table border=\"0\" width=\"100%\" id=\"AdvSpyTableGeneral\">
	<tr>
	
		<td width=\"170px\" align=\"center\">
			<table width=\"100%\">
			<tr>
			<td class=\"c\" align=\"center\" style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivRecherchePlus');\" id=\"AdvSpy_DivRecherchePlus_MenuRow\">
				<b><a style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivRecherchePlus');\">".$lang['UI_Lang']['SearchPlus']." ".AdvSpy_GetHtml_OgspyTooltipImage($lang['UI_Lang']['SearchPlus_TooltipTitle'],$lang['UI_Lang']['SearchPlus_TooltipText'],200)."</a></b>
			</td>
			</tr>
			</table>
		</td>
		
		<td>
		<div class='box'><div class='box_background'> </div> <div class='box_contents'>
		<b>
		
		<table width=\"100%\">
			<tr>
				<td class=\"c\" align=\"center\" style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivResultatRecherche')\" id=\"AdvSpy_DivResultatRecherche_MenuRow\">
					<a style=\"cursor:pointer\" title=\"".$lang['UI_Lang']['Tab_SearchResult_Title']."\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivResultatRecherche')\">".$lang['UI_Lang']['Tab_SearchResult_Text']."</a>
				</td>

				<td class=\"c\" align=\"center\" style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivSimulateur')\" id=\"AdvSpy_DivSimulateur_MenuRow\">
					<a style=\"cursor:pointer\" title=\"".$lang['UI_Lang']['Tab_Sim_Title']."\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivSimulateur')\">".$lang['UI_Lang']['Tab_Sim_Text']."</a>
				</td>
		
				<td class=\"c\" align=\"center\" style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivStats')\" id=\"AdvSpy_DivStats_MenuRow\">
					<a style=\"cursor:pointer\" title=\"".$lang['UI_Lang']['Tab_Stats_Title']."\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivStats')\">".$lang['UI_Lang']['Tab_Stats_Text']."</a>
				</td>
		
				<td class=\"c\" align=\"center\" style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivSaveLoad')\" id=\"AdvSpy_DivSaveLoad_MenuRow\">
					<a style=\"cursor:pointer\" title=\"".$lang['UI_Lang']['Tab_SaveLoad_Title']."\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivSaveLoad')\">".$lang['UI_Lang']['Tab_SaveLoad_Text']."</a>
				</td>
		
				<td class=\"c\" align=\"center\" style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivOptions')\" id=\"AdvSpy_DivOptions_MenuRow\">
					<a style=\"cursor:pointer\" title=\"".$lang['UI_Lang']['Tab_Options_Title']."\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivOptions')\">".$lang['UI_Lang']['Tab_Options_Text']."</a>
				</td>";

	if ($AdvSpyConfig['UserIsAdmin']) {
		print "
		<td class=\"c\" align=\"center\" style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivAdmin')\" id=\"AdvSpy_DivAdmin_MenuRow\">
			<a style=\"cursor:pointer\" title=\"".$lang['UI_Lang']['Tab_Admin_Title']."\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivAdmin')\">".$lang['UI_Lang']['Tab_Admin_Text']."</a>
		</td>";
	}
	
	print "</tr></table></b>	</div></div>
</td> </tr>
	<tr> <td width=\"170\" align=\"left\" valign=\"top\">";
}

function AdvSpy_GetHtml_SubmitBT($text='',$OnlyInput=0){
	global $AdvSpyConfig, $lang;
	if ($text=='') { $text=$lang['UI_Lang']['BT_Search']; }
	if ($OnlyInput==0) {
		return "<p align=\"center\"><input type=\"submit\" name='ChercherOK' value=\"$text\"></p>";
	} elseif ($OnlyInput==1) {
		return "<input type=\"submit\" name='ChercherOK' value=\"$text\">";
	}
}


function AdvSpy_PrintHtml_JavaScript_StaticFunctions(){
	global $AdvSpyConfig, $lang;
	
	//$SendFleetToSimDefFunctionString="";
	
	print "
<script type=\"text/javascript\">
<!--

// hard-coded pour l'instant, à rendre polymorphe...

function SendFleetToSimDef(pt,gt,cle,clo,cro,vb,vc,rec,se,bom,sat,des,edlm,traq,mis,lle,llo,gaus,ion,pla,pb,gb,mi,mip,techA,techB,techP) {
	document.getElementById(\"AdvSpy_Sim_def_f_pt\").value=pt;
	document.getElementById(\"AdvSpy_Sim_def_f_gt\").value=gt;
	document.getElementById(\"AdvSpy_Sim_def_f_cle\").value=cle;
	document.getElementById(\"AdvSpy_Sim_def_f_clo\").value=clo;
	document.getElementById(\"AdvSpy_Sim_def_f_cro\").value=cro;
	document.getElementById(\"AdvSpy_Sim_def_f_vb\").value=vb;
	document.getElementById(\"AdvSpy_Sim_def_f_vc\").value=vc;
	document.getElementById(\"AdvSpy_Sim_def_f_rec\").value=rec;
	document.getElementById(\"AdvSpy_Sim_def_f_se\").value=se;
	document.getElementById(\"AdvSpy_Sim_def_f_bom\").value=bom;
	document.getElementById(\"AdvSpy_Sim_def_f_sat\").value=sat;
	document.getElementById(\"AdvSpy_Sim_def_f_des\").value=des;
	document.getElementById(\"AdvSpy_Sim_def_f_edlm\").value=edlm;
	document.getElementById(\"AdvSpy_Sim_def_f_traq\").value=traq;
	document.getElementById(\"AdvSpy_Sim_def_d_mis\").value=mis;
	document.getElementById(\"AdvSpy_Sim_def_d_lle\").value=lle;
	document.getElementById(\"AdvSpy_Sim_def_d_llo\").value=llo;
	document.getElementById(\"AdvSpy_Sim_def_d_gaus\").value=gaus;
	document.getElementById(\"AdvSpy_Sim_def_d_ion\").value=ion;
	document.getElementById(\"AdvSpy_Sim_def_d_pla\").value=pla;
	document.getElementById(\"AdvSpy_Sim_def_d_pb\").value=pb;
	document.getElementById(\"AdvSpy_Sim_def_d_gb\").value=gb;
	document.getElementById(\"AdvSpy_Sim_def_d_mi\").value=mi;
	document.getElementById(\"AdvSpy_Sim_def_d_mip\").value=mip;
	
	if (techA > 0) { document.getElementById(\"AdvSpy_Sim_def_t_armes\").value=techA; }
	if (techB > 0) { document.getElementById(\"AdvSpy_Sim_def_t_bouclier\").value=techB; }
	if (techP > 0) { document.getElementById(\"AdvSpy_Sim_def_t_protect\").value=techP; }
	
	AdvSpy_Sim_RefreshAll();
	
	AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivSimulateur');

}


function SET_cliptext(text) {
	if (window.clipboardData) {
	   // Internet Explorer style
		window.clipboardData.setData(\"Text\", text);
		return true;

	} else if (window.netscape) { // Si cette 1 ere technique marche pas alors on teste la methode firefox/netscape
		";
		if (!AdvSpy_Options_GetValue('HideCopyClipAlert')) { print "AdvSpy_Div_SHOW('AdvSpy_FireFoxCopyAlertDiv');\n"; }
		print "netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect'); // cette ligne est inutile pour firefox
		var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
		if (!clip) return false;
		var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		if (!trans) return false;
		trans.addDataFlavor('text/unicode');
		var str = new Object();
		var len = new Object();
		var str = Components.classes[\"@mozilla.org/supports-string;1\"].createInstance(Components.interfaces.nsISupportsString);
		var copytext=text;
		str.data=copytext;
		trans.setTransferData(\"text/unicode\",str,copytext.length*2);
		var clipid=Components.interfaces.nsIClipboard;
		clip.setData(trans,null,clipid.kGlobalClipboard);\n";
		if (!AdvSpy_Options_GetValue('HideCopyClipAlert')) { print "AdvSpy_Div_HIDE('AdvSpy_FireFoxCopyAlertDiv');\n"; }
		print "return true;
	}
return false;
}

function GET_cliptext() {
	if (window.clipboardData) {
		return window.clipboardData.getData(\"Text\");
	} else if (window.netscape) {
		netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect'); // cette ligne est inutile pour firefox
		var clipboard = Components.classes[\"@mozilla.org/widget/clipboard;1\"].createInstance(Components.interfaces.nsIClipboard);
		var transferable = Components.classes[\"@mozilla.org/widget/transferable;1\"].createInstance(Components.interfaces.nsITransferable);
		if (clipboard && transferable) {
			transferable.addDataFlavor(\"text/unicode\");
			// Create wrapper for text.
			//var str = Components.classes[\"@mozilla.org/supports-string;1\"].createInstance(Components.interfaces.nsISupportsString);
			// Get from clipboard.
			clipboard.getData(transferable, Components.interfaces.nsIClipboard.kGlobalClipboard);
			var str = new Object();
			var len = new Object();
			transferable.getTransferData ( \"text/unicode\", str, len );
			if (str) str = str.value.QueryInterface(Components.interfaces.nsISupportsString);
			if (str) clipboard_text = str.data.substring(0,len.value / 2);
			return clipboard_text;
		}
	}
	return false;
}




function SwapOptionList(listname,nom,post,ToolTip) {
	if (document.getElementById(listname).value=='indifferent') {
		document.getElementById(listname).value='present';
		document.getElementById(listname+'_Min').value='1';
		document.getElementById(listname+'_Max').value='';

		Color='red';

	} else {
		if (document.getElementById(listname).value=='present') {
			document.getElementById(listname).value='absent';
			document.getElementById(listname+'_Min').value='';
			document.getElementById(listname+'_Max').value='0';
			Color='green';
		} else {
			document.getElementById(listname).value='indifferent';
			document.getElementById(listname+'_Min').value='';
			document.getElementById(listname+'_Max').value='';
			Color='000000';
		}
	}
PopToolTip(nom,post,ToolTip,Color);
}


function PopToolTip(nom,post,ToolTip,Color) {
	if (Color=='') {
		if (document.getElementById(post).value=='indifferent')
			Color='000000';
		if (document.getElementById(post).value=='present')
			Color='red';
		if (document.getElementById(post).value=='absent')
			Color='green';
	} else {
		//Color='000000';
	}
	
	post=document.getElementById(post).value;
	var content =\"<table border=1px width='200' height='30' CELLPADDING=0 CELLSPACING=0 id='tableX'><tr><td align='center' valign='top'><b><font color='#000000'>".$lang['UI_Lang']['SearchPlus']." :<br/>\"+nom+\"</font><br/><font color='\"+Color+\"'>\"+post+\"</font></b></td></tr></table>\";
	document.getElementById(ToolTip).innerHTML = content;
}

function KillToolTip(ToolTip){
	document.getElementById(ToolTip).innerHTML = '';
}

function AdvSpy_ViewPatateInfo(id) {
	if (document.getElementById(\"PatateInfo_\"+id).style.display=='') {
		document.getElementById(\"PatateInfo_\"+id).style.visibility='hidden';
		document.getElementById(\"PatateInfo_\"+id).style.display='none';	
	} else {
		document.getElementById(\"PatateInfo_\"+id).style.visibility='visible';
		document.getElementById(\"PatateInfo_\"+id).style.display='';
	}
}

function AdvSpy_ViewRessourcesInfo(id) {
	if (document.getElementById(\"RessourcesInfo_\"+id).style.display=='') {
		document.getElementById(\"RessourcesInfo_\"+id).style.visibility='hidden';
		document.getElementById(\"RessourcesInfo_\"+id).style.display='none';	
	} else {
		document.getElementById(\"RessourcesInfo_\"+id).style.visibility='visible';
		document.getElementById(\"RessourcesInfo_\"+id).style.display='';
	}
}

function AdvSpy_PopRaid(id,g,s,r,l) {
	if (document.getElementById(\"PopRaid_\"+id).style.display=='') {
		document.getElementById(\"PopRaid_\"+id).style.visibility='hidden';
		document.getElementById(\"PopRaid_\"+id).style.display='none';	
	} else {
		document.getElementById(\"PopRaid_\"+id).style.visibility='visible';
		document.getElementById(\"PopRaid_\"+id).style.display='';
		document.getElementById(\"Frame_RaidAlert_\"+id).src=\"./?action=AdvSpy&RaidAlert_Galaxy=\"+g+\"&RaidAlert_System=\"+s+\"&RaidAlert_Row=\"+r+\"&RaidAlert_Lune=\"+l;
	}
}


function AdvSpy_PopStats(sid,player,comp) {
	tmp=document.getElementById('PopStats_'+sid).innerHTML;
	if (tmp=='') {
		var content =\"<table border=15px CELLPADDING=0 CELLSPACING=0 id='tableStats'><tr><td align='center' valign='top' bgcolor='#808080'><img src='index.php?action=graphic_curve&player=\"+player+\"&player_comp=\"+comp+\"&start=0000000000&end=9999999999&graph=points_rank&titre=Classement%20par%20points&zoom=true' alt='[Pas de Stats]' />	<img src='index.php?action=graphic_curve&player=\"+player+\"&player_comp=\"+comp+\"&start=0000000000&end=9999999999&graph=points_points&titre=Points%20total&zoom=true' alt='[Pas de Stats]' /><br/><img src='index.php?action=graphic_curve&player=\"+player+\"&player_comp=\"+comp+\"&start=0000000000&end=9999999999&graph=fleet_rank&titre=Classement%20par%20flotte&zoom=true' alt='[Pas de Stats]' />	<img src='index.php?action=graphic_curve&player=\"+player+\"&player_comp=\"+comp+\"&start=0000000000&end=9999999999&graph=fleet_points&titre=Points%20de%20flotte&zoom=true' alt='[Pas de Stats]' /><br/><img src='index.php?action=graphic_curve&player=\"+player+\"&player_comp=\"+comp+\"&start=0000000000&end=9999999999&graph=research_rank&titre=Classement%20par%20recherche&zoom=true' alt='[Pas de Stats]' />	<img src='index.php?action=graphic_curve&player=\"+player+\"&player_comp=\"+comp+\"&start=0000000000&end=9999999999&graph=research_points&titre=Points%20de%20recherche&zoom=true' alt='[Pas de Stats]' /></td></tr></table> \";
		document.getElementById('PopStats_'+sid).innerHTML = content;
	} else {
		AdvSpy_KillPopStats(sid);
	}
}

function AdvSpy_KillPopStats(sid){
	document.getElementById('PopStats_'+sid).innerHTML = '';
}

function AdvSpy_Div_SHOW(id) {
	document.getElementById(id).style.visibility='visible';
	document.getElementById(id).style.display='';
}
function AdvSpy_Div_HIDE(id) {
	document.getElementById(id).style.visibility='hidden';
	document.getElementById(id).style.display='none';
}

function AdvSpy_CopyHolderToClip(holderid) {
	SET_cliptext(document.getElementById(holderid).innerHTML);
}

function AdvSpy_SetMinMetal(m) {
	document.getElementById('AdvSpy_RessourceMinMetal').value=m/1000;
}
function AdvSpy_SetMinCristal(c) {
	document.getElementById('AdvSpy_RessourceMinCristal').value=c/1000;
}
function AdvSpy_SetMinDeut(d) {
	document.getElementById('AdvSpy_RessourceMinDeut').value=d/1000;
}
function AdvSpy_SetMinEnergie(e) {
	document.getElementById('AdvSpy_RessourceMinEnergie').value=e/1000;
}

function AdvSpy_PopSpyOldScool(sid,g,s,r) {
	tmp=document.getElementById('PopSpyOldScool_'+sid).innerHTML;
	if (tmp=='') {
		var content =\"<table border=15px width='150' height='30' CELLPADDING=0 CELLSPACING=0 id='tableY'><tr><td align='center' valign='top'><iframe name='ifr' src='./index.php?action=show_reportspy&galaxy=\"+g+\"&system=\"+s+\"&row=\"+r+\"' width='550' height='600'></iframe></td></tr></table>\";
		document.getElementById('PopSpyOldScool_'+sid).innerHTML = content;
	} else {
		AdvSpy_KillPopSpyOldScool(sid);
	}
}

function AdvSpy_KillPopSpyOldScool(sid){
	document.getElementById('PopSpyOldScool_'+sid).innerHTML = '';
}

function AdvSpy_HideSearchResult(spyid,coordsstring) {
	ligne=document.getElementById(\"AdvSpy_DivResult_\"+spyid);
	ligne.style.display='none';
	ligne.style.visibility='hidden';
	hidecoords=document.getElementById(\"AdvSpy_CoordsToHide\");
	hidecoords.value=coordsstring+hidecoords.value
}


function AdvSpy_MenuHideAllThenShowFromID(ElementId){
	document.getElementById('AdvSpy_DivRecherchePlus').style.visibility='hidden';
	document.getElementById('AdvSpy_DivRecherchePlus').style.display='none';	
	document.getElementById('AdvSpy_DivRecherchePlus_MenuRow').className='c';
	
	document.getElementById('AdvSpy_DivFrontPage').style.visibility='hidden';
	document.getElementById('AdvSpy_DivFrontPage').style.display='none';	
	
	document.getElementById('AdvSpy_DivSimulateur').style.visibility='hidden';
	document.getElementById('AdvSpy_DivSimulateur').style.display='none';	
	document.getElementById('AdvSpy_DivSimulateur_MenuRow').className='c';
	
	document.getElementById('AdvSpy_DivStats').style.visibility='hidden';
	document.getElementById('AdvSpy_DivStats').style.display='none';	
	document.getElementById('AdvSpy_DivStats_MenuRow').className='c';
	
	document.getElementById('AdvSpy_DivOptions').style.visibility='hidden';
	document.getElementById('AdvSpy_DivOptions').style.display='none';	
	document.getElementById('AdvSpy_DivOptions_MenuRow').className='c';
	";

	if ($AdvSpyConfig['UserIsAdmin']) {
		print "document.getElementById('AdvSpy_DivAdmin').style.visibility='hidden';
	document.getElementById('AdvSpy_DivAdmin').style.display='none';	
	document.getElementById('AdvSpy_DivAdmin_MenuRow').className='c';";
	}

print "	
	document.getElementById('AdvSpy_DivResultatRecherche').style.visibility='hidden';
	document.getElementById('AdvSpy_DivResultatRecherche').style.display='none';	
	document.getElementById('AdvSpy_DivResultatRecherche_MenuRow').className='c';
	
	document.getElementById('AdvSpy_DivSaveLoad').style.visibility='hidden';
	document.getElementById('AdvSpy_DivSaveLoad').style.display='none';	
	document.getElementById('AdvSpy_DivSaveLoad_MenuRow').className='c';
	
	//show the last
	document.getElementById(ElementId).style.visibility='visible';
	document.getElementById(ElementId).style.display='';
	document.getElementById(ElementId+'_MenuRow').className='l';

}


function AdvSpy_ToggleVisibilityFromID(ElementId){
	if (document.getElementById(ElementId).style.display=='') {
		document.getElementById(ElementId).style.visibility='hidden';
		document.getElementById(ElementId).style.display='none';	
	} else {
		document.getElementById(ElementId).style.visibility='visible';
		document.getElementById(ElementId).style.display='';
	}
}

function CheckOptionList(listname) {
	if (document.getElementById(listname).value=='indifferent') {
		document.getElementById(listname+'_Min').value='';
		document.getElementById(listname+'_Max').value='';
	} else {
		if (document.getElementById(listname).value=='present') {
			document.getElementById(listname+'_Min').value='1';
			document.getElementById(listname+'_Max').value='';
		} else {
		document.getElementById(listname+'_Min').value='';
		document.getElementById(listname+'_Max').value='0';		}
	}
}


function AdvSpy_SearchResultMoin(){
	oldmin=parseInt(document.getElementById('AdvSpy_SearchResult_Min').value,10);
	oldmax=parseInt(document.getElementById('AdvSpy_SearchResult_Max').value,10);
	newmin=parseInt(oldmin-(oldmax-oldmin)-1);
	newmax=oldmin-1;
	if (newmin<=0) { newmin=1; }
	if (newmax<=newmin) { newmax=newmin+".AdvSpy_Options_GetValue('SearchResult_DefaultMax')."-1; }
	document.getElementById('AdvSpy_SearchResult_Min').value=newmin;
	document.getElementById('AdvSpy_SearchResult_Max').value=newmax;
	document.getElementById('AdvSpy_SearchResult_PerPage').innerHTML=(newmax-newmin)+1;
}
function AdvSpy_SearchResultPlus(){
	oldmin=parseInt(document.getElementById('AdvSpy_SearchResult_Min').value,10);
	oldmax=parseInt(document.getElementById('AdvSpy_SearchResult_Max').value,10);
	newmax=parseInt(oldmax+(oldmax-oldmin)+1);
	newmin=oldmax+1;
	if (newmin<=0) { newmin=1; }
	if (newmax<=newmin) { newmax=newmin+".AdvSpy_Options_GetValue('SearchResult_DefaultMax')."-1; }
	document.getElementById('AdvSpy_SearchResult_Min').value=newmin;
	document.getElementById('AdvSpy_SearchResult_Max').value=newmax;
	document.getElementById('AdvSpy_SearchResult_PerPage').innerHTML=(newmax-newmin)+1;
}


function AdvSpy_SelPlanette(Coord,range) {
    StrCoord=Coord.replace('[','');
    StrCoord=Coord.replace(']','');
	StrCoord=Coord.replace('(','');
	StrCoord=Coord.replace(')','');
	
	ArrCoord=StrCoord.split(':');
    G=ArrCoord[0];
    S=ArrCoord[1];

	nG=G;
	nSmin=parseInt(S)-parseInt(range,10);
	nSmax=parseInt(S)+parseInt(range,10);
	
	if (nG<=0) { nG=1; }
	if (nSmin<1) { nSmin=1; }
	if (nSmax>".$AdvSpyConfig['Settings']['OgameUniverse_System_Max'].") { nSmax=".$AdvSpyConfig['Settings']['OgameUniverse_System_Max']."; }
	
    document.getElementById('AdvSpy_GalaxyMin').value=nG;
    document.getElementById('AdvSpy_GalaxyMax').value=nG;
    document.getElementById('AdvSpy_SystemMin').value=nSmin;
    document.getElementById('AdvSpy_SystemMax').value=nSmax;
    document.getElementById('AdvSpy_RowMin').value='1';
    document.getElementById('AdvSpy_RowMax').value='".$AdvSpyConfig['Settings']['OgameUniverse_Row_Max']."';
}


// =================================================================
function AdvSpy_GetHtmlFormatedNumber(nStr,sufix) {
	// thx http://www.mredkj.com/javascript/numberFormat.html
	sep='';
	try { sep=document.getElementById('AdvSpy_Options_SeparateurDeMilliers').value; } catch (ex) { };	
	if (nStr==0) { return ''; }
	if (nStr+''=='NaN') { return ''; }
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	if (sep=='') { return x1 + '<font style=\"font-size: 7px\">' + x2 + '</font>' + sufix; }
	if (isNumeric(sep)) { return x1 + '<font style=\"font-size: 7px\">' + x2 + '</font>' + sufix; }
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '\$1' + sep + '\$2');
	}
	return x1 + '<font style=\"font-size: 7px\">' + x2 + '</font>' + sufix;
}


<!-- La fonction isNumeric(sText) provient du site:  http://www.codetoad.com/javascript/isnumeric.asp  -->
function isNumeric(sText){
	var ValidChars = \"0123456789\";
	var IsNumber=true;
	var Char;
	for (i = 0; i < sText.length && IsNumber == true; i++){
		Char = sText.charAt(i);
		if (ValidChars.indexOf(Char) == -1){
			IsNumber = false;
		}
	}
	return IsNumber;
}
//=====================================================================

function AdvSpy_Sim_RefreshAll(){
";
// atk

	print "
	//initialisation des totaux
	AdvSpy_Sim_atk_Patate_armes=0;
	AdvSpy_Sim_atk_Patate_bouclier=0;
	AdvSpy_Sim_atk_Patate_protect=0;
	AdvSpy_Sim_atk_Patate_total=0;
	
	AdvSpy_Sim_def_Patate_f_armes=0;
	AdvSpy_Sim_def_Patate_f_bouclier=0;
	AdvSpy_Sim_def_Patate_f_protect=0;
	AdvSpy_Sim_def_Patate_f_total=0;
	
	AdvSpy_Sim_def_Patate_d_armes=0;
	AdvSpy_Sim_def_Patate_d_bouclier=0;
	AdvSpy_Sim_def_Patate_d_protect=0;
	AdvSpy_Sim_def_Patate_d_total=0;

	AdvSpy_Sim_def_Patate_total=0;
	
	";

	$TechArray=array();
	
	$TechArray['atk_t_armes']='Patate Armes :';
	$TechArray['atk_t_bouclier']='Patate Bouclier :';
	$TechArray['atk_t_protect']='Patate Protection :';

	$TechArray['def_t_armes']='Patate Armes :';
	$TechArray['def_t_bouclier']='Patate Bouclier :';
	$TechArray['def_t_protect']='Patate Protection :';
	
	foreach($TechArray as $key=>$value){
		print "
	// initialisation des technologies
	if ( (document.getElementById('AdvSpy_Sim_$key').value!='') && (isNumeric(document.getElementById('AdvSpy_Sim_$key').value)) ) {
		AdvSpy_Sim_$key=Number( parseFloat(document.getElementById('AdvSpy_Sim_$key').value)	);
	} else { AdvSpy_Sim_$key=1; }
	\n";

	}

	// AdvSpy_Sim_atk_t_armes
	// AdvSpy_Sim_atk_t_bouclier
	// AdvSpy_Sim_atk_t_protection

	// AdvSpy_Sim_def_t_armes
	// AdvSpy_Sim_def_t_bouclier
	// AdvSpy_Sim_def_t_protection	
	

	foreach($lang['DicOgame']['Fleet'] as $Num=>$Params){
		// $Params['Structure'] ['Bouclier'] ['Attaque']

		$PostVar=$Params['PostVar'];
		$Attaque=$Params['Attaque'];
		$Bouclier=$Params['Bouclier'];
		$Structure=$Params['Structure'];
		
		print "
	// initialisation des vaisseaux atk
	if ( (document.getElementById('AdvSpy_Sim_atk_$PostVar').value!='') && (isNumeric(document.getElementById('AdvSpy_Sim_atk_$PostVar').value)) ) {
		AdvSpy_Sim_atk_$PostVar=Number( parseFloat(document.getElementById('AdvSpy_Sim_atk_$PostVar').value)	);
	} else {
		AdvSpy_Sim_atk_$PostVar=0;
	}
	
	AdvSpy_Sim_atk_Patate_armes=AdvSpy_Sim_atk_Patate_armes+ ( 0.1 * AdvSpy_Sim_atk_t_armes * $Attaque * AdvSpy_Sim_atk_$PostVar);
	AdvSpy_Sim_atk_Patate_bouclier=AdvSpy_Sim_atk_Patate_bouclier+ ( 0.1 * AdvSpy_Sim_atk_t_bouclier * $Bouclier * AdvSpy_Sim_atk_$PostVar);
	AdvSpy_Sim_atk_Patate_protect=AdvSpy_Sim_atk_Patate_protect+ ( 0.1 * AdvSpy_Sim_atk_t_protect * $Structure * AdvSpy_Sim_atk_$PostVar);

	\n";
		
		print "
	// initialisation des vaisseaux def
	if ( (document.getElementById('AdvSpy_Sim_def_$PostVar').value!='') && (isNumeric(document.getElementById('AdvSpy_Sim_def_$PostVar').value)) ) {
		AdvSpy_Sim_def_$PostVar=Number( parseFloat(document.getElementById('AdvSpy_Sim_def_$PostVar').value)	);
	} else {
		AdvSpy_Sim_def_$PostVar=0;
	}
	
	AdvSpy_Sim_def_Patate_f_armes=AdvSpy_Sim_def_Patate_f_armes+ ( 0.1 * AdvSpy_Sim_def_t_armes * $Attaque * AdvSpy_Sim_def_$PostVar);
	AdvSpy_Sim_def_Patate_f_bouclier=AdvSpy_Sim_def_Patate_f_bouclier+ ( 0.1 * AdvSpy_Sim_def_t_bouclier * $Bouclier * AdvSpy_Sim_def_$PostVar);
	AdvSpy_Sim_def_Patate_f_protect=AdvSpy_Sim_def_Patate_f_protect+ ( 0.1 * AdvSpy_Sim_def_t_protect * $Structure * AdvSpy_Sim_def_$PostVar);

	\n";
		
	} // fin foreach
	
	print "AdvSpy_Sim_atk_Patate_total=AdvSpy_Sim_atk_Patate_total+ AdvSpy_Sim_atk_Patate_armes + AdvSpy_Sim_atk_Patate_bouclier + AdvSpy_Sim_atk_Patate_protect;\n";
	print "AdvSpy_Sim_def_Patate_f_total=AdvSpy_Sim_def_Patate_f_total+ AdvSpy_Sim_def_Patate_f_armes + AdvSpy_Sim_def_Patate_f_bouclier + AdvSpy_Sim_def_Patate_f_protect;\n";



	foreach($lang['DicOgame']['Def'] as $Num=>$Params){
		// $Params['Structure'] ['Bouclier'] ['Attaque']

		$PostVar=$Params['PostVar'];
		$Attaque=$Params['Attaque'];
		$Bouclier=$Params['Bouclier'];
		$Structure=$Params['Structure'];
		
		print "
	// initialisation des défenses def
	if ( (document.getElementById('AdvSpy_Sim_def_$PostVar').value!='') && (isNumeric(document.getElementById('AdvSpy_Sim_def_$PostVar').value)) ) {
		AdvSpy_Sim_def_$PostVar=Number( parseFloat(document.getElementById('AdvSpy_Sim_def_$PostVar').value)	);
	} else {
		AdvSpy_Sim_def_$PostVar=0;
	}
	
	AdvSpy_Sim_def_Patate_d_armes=AdvSpy_Sim_def_Patate_d_armes+ ( 0.1 * AdvSpy_Sim_def_t_armes * $Attaque * AdvSpy_Sim_def_$PostVar);
	AdvSpy_Sim_def_Patate_d_bouclier=AdvSpy_Sim_def_Patate_d_bouclier+ ( 0.1 * AdvSpy_Sim_def_t_bouclier * $Bouclier * AdvSpy_Sim_def_$PostVar);
	AdvSpy_Sim_def_Patate_d_protect=AdvSpy_Sim_def_Patate_d_protect+ ( 0.1 * AdvSpy_Sim_def_t_protect * $Structure * AdvSpy_Sim_def_$PostVar);
	
	\n";
		
	} // fin foreach
	
	print "
	AdvSpy_Sim_def_Patate_d_total=AdvSpy_Sim_def_Patate_d_total+ AdvSpy_Sim_def_Patate_d_armes + AdvSpy_Sim_def_Patate_d_bouclier + AdvSpy_Sim_def_Patate_d_protect;

	AdvSpy_Sim_def_Patate_total=AdvSpy_Sim_def_Patate_f_total+AdvSpy_Sim_def_Patate_d_total;	
	
	";
	
	
	
	
	print "
	
	document.getElementById('AdvSpy_Sim_atk_Patate_armes').innerHTML=AdvSpy_GetHtmlFormatedNumber(Number(AdvSpy_Sim_atk_Patate_armes/1000000).toFixed(2),' ');
	document.getElementById('AdvSpy_Sim_atk_Patate_bouclier').innerHTML=AdvSpy_GetHtmlFormatedNumber(Number(AdvSpy_Sim_atk_Patate_bouclier/1000000).toFixed(2),' ');
	document.getElementById('AdvSpy_Sim_atk_Patate_protect').innerHTML=AdvSpy_GetHtmlFormatedNumber(Number(AdvSpy_Sim_atk_Patate_protect/1000000).toFixed(2),' ');

	document.getElementById('AdvSpy_Sim_atk_Patate_total').innerHTML=AdvSpy_GetHtmlFormatedNumber(Number(AdvSpy_Sim_atk_Patate_total/1000000).toFixed(2),' ');

	
	document.getElementById('AdvSpy_Sim_def_Patate_f_armes').innerHTML=AdvSpy_GetHtmlFormatedNumber(Number(AdvSpy_Sim_def_Patate_f_armes/1000000).toFixed(2),' ');
	document.getElementById('AdvSpy_Sim_def_Patate_f_bouclier').innerHTML=AdvSpy_GetHtmlFormatedNumber(Number(AdvSpy_Sim_def_Patate_f_bouclier/1000000).toFixed(2),' ');
	document.getElementById('AdvSpy_Sim_def_Patate_f_protect').innerHTML=AdvSpy_GetHtmlFormatedNumber(Number(AdvSpy_Sim_def_Patate_f_protect/1000000).toFixed(2),' ');
	
	document.getElementById('AdvSpy_Sim_def_Patate_d_armes').innerHTML=AdvSpy_GetHtmlFormatedNumber(Number(AdvSpy_Sim_def_Patate_d_armes/1000000).toFixed(2),' ');
	document.getElementById('AdvSpy_Sim_def_Patate_d_bouclier').innerHTML=AdvSpy_GetHtmlFormatedNumber(Number(AdvSpy_Sim_def_Patate_d_bouclier/1000000).toFixed(2),' ');
	document.getElementById('AdvSpy_Sim_def_Patate_d_protect').innerHTML=AdvSpy_GetHtmlFormatedNumber(Number(AdvSpy_Sim_def_Patate_d_protect/1000000).toFixed(2),' ');
	
	document.getElementById('AdvSpy_Sim_def_Patate_total').innerHTML=AdvSpy_GetHtmlFormatedNumber(Number((AdvSpy_Sim_def_Patate_f_total+AdvSpy_Sim_def_Patate_d_total)/1000000).toFixed(2),' ');


	// Pondération pour le graphique  :   armes*6.6    bouclier*28      protect*0.1

	AdvSpy_Sim_atk_Patate_totalP=  (AdvSpy_Sim_atk_Patate_armes*6.6)   + (AdvSpy_Sim_atk_Patate_bouclier*28)   + (AdvSpy_Sim_atk_Patate_protect*0.1);
	AdvSpy_Sim_def_Patate_f_totalP=(AdvSpy_Sim_def_Patate_f_armes*6.6) + (AdvSpy_Sim_def_Patate_f_bouclier*28) + (AdvSpy_Sim_def_Patate_f_protect*0.1);
	AdvSpy_Sim_def_Patate_d_totalP=(AdvSpy_Sim_def_Patate_d_armes*6.6) + (AdvSpy_Sim_def_Patate_d_bouclier*28) + (AdvSpy_Sim_def_Patate_d_protect*0.1);

	document.getElementById('AdvSpy_Sim_atk_PatateBarr_armes').style.width=Number(    ((AdvSpy_Sim_atk_Patate_armes*6.6)  /(AdvSpy_Sim_atk_Patate_totalP+0.1)) *150 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_atk_PatateBarr_bouclier').style.width=Number( ((AdvSpy_Sim_atk_Patate_bouclier*28)/(AdvSpy_Sim_atk_Patate_totalP+0.1)) *150 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_atk_PatateBarr_protect').style.width=Number(  ((AdvSpy_Sim_atk_Patate_protect*0.1)/(AdvSpy_Sim_atk_Patate_totalP+0.1)) *150 ).toFixed(0);
	
	
	document.getElementById('AdvSpy_Sim_def_PatateBarr_f_armes').style.width=Number(    ((AdvSpy_Sim_def_Patate_f_armes*6.6)  /(AdvSpy_Sim_def_Patate_f_totalP+0.1)) *150 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_def_PatateBarr_f_bouclier').style.width=Number( ((AdvSpy_Sim_def_Patate_f_bouclier*28)/(AdvSpy_Sim_def_Patate_f_totalP+0.1)) *150 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_def_PatateBarr_f_protect').style.width=Number(  ((AdvSpy_Sim_def_Patate_f_protect*0.1)/(AdvSpy_Sim_def_Patate_f_totalP+0.1)) *150 ).toFixed(0);

	document.getElementById('AdvSpy_Sim_def_PatateBarr_d_armes').style.width=Number(    ((AdvSpy_Sim_def_Patate_d_armes*6.6)  /(AdvSpy_Sim_def_Patate_d_totalP+0.1)) *150 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_def_PatateBarr_d_bouclier').style.width=Number( ((AdvSpy_Sim_def_Patate_d_bouclier*28)/(AdvSpy_Sim_def_Patate_d_totalP+0.1)) *150 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_def_PatateBarr_d_protect').style.width=Number(  ((AdvSpy_Sim_def_Patate_d_protect*0.1)/(AdvSpy_Sim_def_Patate_d_totalP+0.1)) *150 ).toFixed(0);
	

	PatatePc=Number( ( AdvSpy_Sim_atk_Patate_total /( AdvSpy_Sim_atk_Patate_total + AdvSpy_Sim_def_Patate_total +0.1))*100 ).toFixed(2);
	if (PatatePc>100) { PatatePc=100; }
	if (PatatePc<0) { PatatePc=0; }
	if (AdvSpy_Sim_def_Patate_total<=0) { PatatePc=100; }
	
	document.getElementById('AdvSpy_Sim_Result_PatatePc').innerHTML='<b>Taux de PATATE :<br/><font size=\"5\"> '+PatatePc+' %</font></b>';
	
	PatatePourcent0=  '".$AdvSpyConfig['color']['PatatePourcent0']."';
	PatatePourcent10= '".$AdvSpyConfig['color']['PatatePourcent10']."';
	PatatePourcent20= '".$AdvSpyConfig['color']['PatatePourcent20']."';
	PatatePourcent30= '".$AdvSpyConfig['color']['PatatePourcent30']."';
	PatatePourcent40= '".$AdvSpyConfig['color']['PatatePourcent40']."';
	PatatePourcent50= '".$AdvSpyConfig['color']['PatatePourcent50']."';
	PatatePourcent60= '".$AdvSpyConfig['color']['PatatePourcent60']."';
	PatatePourcent70= '".$AdvSpyConfig['color']['PatatePourcent70']."';
	PatatePourcent80= '".$AdvSpyConfig['color']['PatatePourcent80']."';
	PatatePourcent90= '".$AdvSpyConfig['color']['PatatePourcent90']."';
	PatatePourcent100= '".$AdvSpyConfig['color']['PatatePourcent100']."';

	if (PatatePc<=0) { PatateColor=PatatePourcent0; }
	if (PatatePc>=10) { PatateColor=PatatePourcent10; }
	if (PatatePc>=20) { PatateColor=PatatePourcent20; }
	if (PatatePc>=30) { PatateColor=PatatePourcent30; }
	if (PatatePc>=40) { PatateColor=PatatePourcent40; }
	if (PatatePc>=50) { PatateColor=PatatePourcent50; }
	if (PatatePc>=60) { PatateColor=PatatePourcent60; }
	if (PatatePc>=70) { PatateColor=PatatePourcent70; }
	if (PatatePc>=80) { PatateColor=PatatePourcent80; }
	if (PatatePc>=90) { PatateColor=PatatePourcent90; }
	if (PatatePc>=100) { PatateColor=PatatePourcent100; }
	
	document.getElementById('AdvSpy_Sim_Result_PatateColor').style.border='10px solid '+PatateColor;

	
	
	
	document.getElementById('AdvSpy_Sim_atk_PatatePRC_armes').style.width=Number(     ((AdvSpy_Sim_atk_Patate_armes*6.6)    /( ((AdvSpy_Sim_atk_Patate_armes+AdvSpy_Sim_def_Patate_f_armes+AdvSpy_Sim_def_Patate_d_armes)*6.6) +0.1)) *450 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_def_PatatePRC_f_armes').style.width=Number(   ((AdvSpy_Sim_def_Patate_f_armes*6.6)  /( ((AdvSpy_Sim_atk_Patate_armes+AdvSpy_Sim_def_Patate_f_armes+AdvSpy_Sim_def_Patate_d_armes)*6.6) +0.1)) *450 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_def_PatatePRC_d_armes').style.width=Number(   ((AdvSpy_Sim_def_Patate_d_armes*6.6)  /( ((AdvSpy_Sim_atk_Patate_armes+AdvSpy_Sim_def_Patate_f_armes+AdvSpy_Sim_def_Patate_d_armes)*6.6) +0.1)) *450 ).toFixed(0);
	
	document.getElementById('AdvSpy_Sim_atk_PatatePRC_bouclier').style.width=Number(     ((AdvSpy_Sim_atk_Patate_bouclier*6.6)    /( ((AdvSpy_Sim_atk_Patate_bouclier+AdvSpy_Sim_def_Patate_f_bouclier+AdvSpy_Sim_def_Patate_d_bouclier)*6.6) +0.1)) *450 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_def_PatatePRC_f_bouclier').style.width=Number(   ((AdvSpy_Sim_def_Patate_f_bouclier*6.6)  /( ((AdvSpy_Sim_atk_Patate_bouclier+AdvSpy_Sim_def_Patate_f_bouclier+AdvSpy_Sim_def_Patate_d_bouclier)*6.6) +0.1)) *450 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_def_PatatePRC_d_bouclier').style.width=Number(   ((AdvSpy_Sim_def_Patate_d_bouclier*6.6)  /( ((AdvSpy_Sim_atk_Patate_bouclier+AdvSpy_Sim_def_Patate_f_bouclier+AdvSpy_Sim_def_Patate_d_bouclier)*6.6) +0.1)) *450 ).toFixed(0);

	document.getElementById('AdvSpy_Sim_atk_PatatePRC_protect').style.width=Number(     ((AdvSpy_Sim_atk_Patate_protect*6.6)    /( ((AdvSpy_Sim_atk_Patate_protect+AdvSpy_Sim_def_Patate_f_protect+AdvSpy_Sim_def_Patate_d_protect)*6.6) +0.1)) *450 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_def_PatatePRC_f_protect').style.width=Number(   ((AdvSpy_Sim_def_Patate_f_protect*6.6)  /( ((AdvSpy_Sim_atk_Patate_protect+AdvSpy_Sim_def_Patate_f_protect+AdvSpy_Sim_def_Patate_d_protect)*6.6) +0.1)) *450 ).toFixed(0);
	document.getElementById('AdvSpy_Sim_def_PatatePRC_d_protect').style.width=Number(   ((AdvSpy_Sim_def_Patate_d_protect*6.6)  /( ((AdvSpy_Sim_atk_Patate_protect+AdvSpy_Sim_def_Patate_f_protect+AdvSpy_Sim_def_Patate_d_protect)*6.6) +0.1)) *450 ).toFixed(0);


	
	
}
";

	print "function AdvSpy_Sim_atk_CLEAR(){\n";
	foreach($lang['DicOgame']['Fleet'] as $Num=>$Params){
		$PostVar=$Params['PostVar'];
		print "	document.getElementById('AdvSpy_Sim_atk_$PostVar').value='';\n";
	}
	print "AdvSpy_Sim_RefreshAll();\n}\n";


	print "function AdvSpy_Sim_def_CLEAR(){\n";
	foreach($lang['DicOgame']['Fleet'] as $Num=>$Params){
		$PostVar=$Params['PostVar'];
		print "	document.getElementById('AdvSpy_Sim_def_$PostVar').value='';\n";
	}
	foreach($lang['DicOgame']['Def'] as $Num=>$Params){
		$PostVar=$Params['PostVar'];
		print "	document.getElementById('AdvSpy_Sim_def_$PostVar').value='';\n";
	}

	print "AdvSpy_Sim_RefreshAll();\n}\n";

	

	
	
	print "
function SendUrlToDivId(url,divid,repeattime){
	var req = null;
	if (!repeattime){
		repeattime=0;
	}
	if (window.XMLHttpRequest){
		req = new XMLHttpRequest();
		if (req.overrideMimeType) {
			req.overrideMimeType('text/xml');
		}
	} else if (window.ActiveXObject) {
		try { req = new ActiveXObject(\"Msxml2.XMLHTTP\"); }
		catch (e) {
			try { req = new ActiveXObject(\"Microsoft.XMLHTTP\"); } catch (e) {}
		}
	}
	req.onreadystatechange = function()	{ 
		//document.getElementById(divid).innerHTML=\"Loading...\";
		if(req.readyState == 4)	{
			if(req.status == 200) {
				document.getElementById(divid).innerHTML=req.responseText;
			} else {
				document.getElementById(divid).innerHTML=\"Error: \" + req.status + \" / \" + req.statusText;
			}	
		} 
	}; 
	req.open(\"GET\", url, true); 
	req.setRequestHeader(\"Content-Type\", \"application/x-www-form-urlencoded\"); 
	req.send(null);
	if (repeattime>=1){
		func = \"SendUrlToDivId('\" + url + \"','\" + divid + \"','\" + repeattime + \"');\";
		setTimeout(func,repeattime);
	}
}\n";




	
	
	
	
	
print "\n\n\nwindow.setTimeout('AdvSpy_Sim_RefreshAll()',900);

//-->
</script>\n";




}


function AdvSpy_GetHtml_PatateLegende() {
	global $AdvSpyConfig, $lang;
	return "<br/>".$lang['UI_Lang']['PatateLegendHeader']." <a style=\"cursor:pointer\" title=\"Click pour voir\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivSimulateur')\">\"".$lang['UI_Lang']['PatateLegendMyFleet']."\"</a>:<br/>
<table border=\"0\" id=\"table1\" cellspacing=\"1\" cellpadding=\"2\" style=\"border-collapse: collapse\">
	<tr>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent0']."\" align=\"center\"><b><font color=\"#FFFFFF\">0 %</font></b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent10']."\" align=\"center\"><b><font color=\"#FFFFFF\">10 %</font></b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent20']."\" align=\"center\"><b><font color=\"#FFFFFF\">20 %</font></b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent30']."\" align=\"center\"><b><font color=\"#FFFFFF\">30 %</font></b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent40']."\" align=\"center\"><b><font color=\"#FFFFFF\">40 %</font></b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent50']."\" align=\"center\"><b><font color=\"#FFFFFF\">50 %</font></b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent60']."\" align=\"center\"><b><font color=\"#FFFFFF\">60 %</font></b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent70']."\" align=\"center\"><b><font color=\"#FFFFFF\">70 %</font></b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent80']."\" align=\"center\"><b><font color=\"#FFFFFF\">80 %</font></b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent90']."\" align=\"center\"><b><font color=\"#FFFFFF\">90 %</font></b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent100']."\" align=\"center\"><b><font color=\"#FFFFFF\">100 %</font></b></td>
	</tr>
	<tr>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent10']."\" align=\"center\" colspan=\"2\"><b><font color=\"#FFFFFF\">[".$lang['UI_Lang']['PatateDefeat']."</font></b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent20']."\" align=\"center\"><b>-----</b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent30']."\" align=\"center\"><b>-----</b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent40']."\" align=\"center\"><b>----]</b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent50']."\" align=\"center\"><b>[----</b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent60']."\" align=\"center\"><b>".$lang['UI_Lang']['PatateDraw']."</b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent70']."\" align=\"center\"><b>----]</b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent80']."\" align=\"center\"><b>[----</b></td>
		<td style=\"background-color: ".$AdvSpyConfig['color']['PatatePourcent90']."\" align=\"center\" colspan=\"2\"><b><font color=\"#FFFFFF\">".$lang['UI_Lang']['PatateWin']."]</font></b></td>
	</tr>
</table>
<br/>
".$lang['UI_Lang']['PatateLegendFooter'];
}




/**
 *	Frontpage
 **/
function AdvSpy_PrintHtml_Tab_FrontPage(){
	global $AdvSpyConfig, $lang;
	print "
<div class='box'><div class='box_background'> </div> <div class='box_contents'>
<h2>".$lang['UI_Lang']['Tab_FrontPage_Title']."</h2>
<br/>
".$lang['UI_Lang']['Tab_FrontPage_Define1']."<br/>
<br/>
".$lang['UI_Lang']['Tab_FrontPage_Help1']."<br/>
<br/>
".$lang['UI_Lang']['Tab_FrontPage_Help2A']."<a style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivRecherchePlus');\">"		.$lang['UI_Lang']['Tab_FrontPage_Help2B']."</a>".$lang['UI_Lang']['Tab_FrontPage_Help2C']."<br/>
<br/>
".$lang['UI_Lang']['Tab_FrontPage_Help3A']."<a style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivResultatRecherche');\">"	.$lang['UI_Lang']['Tab_FrontPage_Help3B']."</a>".$lang['UI_Lang']['Tab_FrontPage_Help3C']."<br/>
<br/>
".$lang['UI_Lang']['Tab_FrontPage_Help4A']."<a style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivStats');\">"				.$lang['UI_Lang']['Tab_FrontPage_Help4B']."</a>".$lang['UI_Lang']['Tab_FrontPage_Help4C']."<br/>
<br/>
".$lang['UI_Lang']['Tab_FrontPage_Help5A']."<a style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivSimulateur');\">"			.$lang['UI_Lang']['Tab_FrontPage_Help5B']."</a>".$lang['UI_Lang']['Tab_FrontPage_Help5C']."<br/>
<br/>
".$lang['UI_Lang']['Tab_FrontPage_Help6A']."<a style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivSaveLoad');\">"			.$lang['UI_Lang']['Tab_FrontPage_Help6B']."</a>".$lang['UI_Lang']['Tab_FrontPage_Help6C']."<br/>
<br/>
".$lang['UI_Lang']['Tab_FrontPage_Help7A']."<a style=\"cursor:pointer\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivOptions');\">"			.$lang['UI_Lang']['Tab_FrontPage_Help7B']."</a>".$lang['UI_Lang']['Tab_FrontPage_Help7C']."<br/>
<br/>
<br/>
".$lang['UI_Lang']['Tab_FrontPage_Help8A']."<a href=\"http://www.ogsteam.fr/forums/sujet-1273-advspy-recherche-crit-selon-fense-flotte\" target=\"_blank\">".$lang['UI_Lang']['Tab_FrontPage_Help8B']."</a>.<br/>
".$lang['UI_Lang']['Tab_FrontPage_Help8C']."<br/>
<br/>
<br/>
<h3>".$lang['UI_Lang']['Tab_FrontPage_Help9']."</h3><br/>
<br/>
-= Kilops =-<br/>
<br/>
</div></div>
";

}

/**
 *
 **/
function AdvSpy_PrintHtml_Tab_RecherchePLUS(){
	global $AdvSpyConfig, $lang;
	print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
	print "<table border=\"0\" id=\"AdvSpyTableRecherchePlus\">";;
	foreach($lang['DicOgame']['SpyCatList'] as $Cat=>$Catname){
		print "<tr><td valign=\"top\" align=\"center\">"; // width=\"170\"
	    print AdvSpy_GetHtml_Menu_LISTES($Cat,0);
		print "</td></tr>";
	}
	print "</table></div></div>";
}




/**
 *	Alerte firefox et presse-papier
 **/
function AdvSpy_PrintHtml_ClipboardCopyAlert(){
	global $AdvSpyConfig, $lang;

	print "<fieldset style=\"padding: 2px; ; color:#C0C0C0; background-color:#000040\">
<legend><b>".$lang['UI_Lang']['ClipboardCopyAlert_Title']." : <a style=\"cursor:pointer\" onClick=\"AdvSpy_Div_HIDE('AdvSpy_FireFoxCopyAlertDiv');\"><img src='".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."clear.png' border='0' alt='[X]' title='".$lang['UI_Lang']['CloseMsgText']."'></a></b></legend>
<br/><br/>
".$lang['UI_Lang']['ClipboardCopyAlert_Text']."
<br/><br/>
<a style=\"cursor:pointer\" onClick=\"AdvSpy_Div_HIDE('AdvSpy_FireFoxCopyAlertDiv');\"><img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."clear.png\" border=\"0\" alt=\"[X]\" title=\"".$lang['UI_Lang']['CloseMsgText']."\"> ".$lang['UI_Lang']['CloseMsgText']." <img src='".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."clear.png' border='0' alt='[X]' title='".$lang['UI_Lang']['CloseMsgText']."'></a>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</fieldset>";

}



/**
 * Reconstruction d'un RE en texte à partir d'un FlatSpyRepport
 **/
function AdvSpy_GetFromFlatSpyRepportReStyleString($FlatSpyRepport){
	global $AdvSpyConfig, $lang;
	
	$out=$lang['DicOgame']['Text']['Spy']['start'];
	$out.=$FlatSpyRepport['planet_name'];
	
	if ($FlatSpyRepport['lune']) {
	    $out.=$lang['DicOgame']['Text']['Spy']['lune'];
	} else {
		$out.=" ";
	}

	$out.=$FlatSpyRepport['coord'];
	$out.=$lang['DicOgame']['Text']['Spy']['playerstart'].$FlatSpyRepport['player'].$lang['DicOgame']['Text']['Spy']['playerend'];
	
	$out.=$lang['DicOgame']['Text']['Spy']['interlude'];
	$out.=$FlatSpyRepport['timetext']."\n";

	$out.=$lang['DicOgame']['Text']['Spy']['metal'];
	$out.=" ".$FlatSpyRepport['metal']."\n";

	$out.=$lang['DicOgame']['Text']['Spy']['cristal'];
	$out.=" ".$FlatSpyRepport['cristal']."\n";

	$out.=$lang['DicOgame']['Text']['Spy']['deut'];
	$out.=" ".$FlatSpyRepport['deut']."\n";
	
	$out.=$lang['DicOgame']['Text']['Spy']['energie'];
	$out.=" ".$FlatSpyRepport['energie']."\n";

	foreach($lang['DicOgame']['SpyCatList'] as $Cat=>$Catname){
		if ($FlatSpyRepport[$Cat]) {
		    $out.=$Catname."\n";
		}
		foreach($lang['DicOgame'][$Cat] as $num=>$valuesarray){
			if ($FlatSpyRepport[$valuesarray['PostVar']]) {
			    $out.=$valuesarray['Name']." ".$FlatSpyRepport[$valuesarray['PostVar']]."\n";
			}
		}
	}
	
	$out.=$lang['DicOgame']['Text']['Spy']['end'];
	$out.=$FlatSpyRepport['proba']."%";
		
	return $out;
}


/**
 * Reconstruction d'un RE en BBCode à partir d'un FlatSpyRepport(Advanced ou pas)
 **/
function AdvSpy_GetFromFlatSpyRepportReStyleBBCode($FlatSpyRepport){
	global $AdvSpyConfig, $lang;
	
	
	$out=$lang['DicOgame']['Text']['Spy']['start'];
	$out.="[color=".$AdvSpyConfig['color']['Spy_PlanetName']."]";
	$out.=$FlatSpyRepport['planet_name'];
	$out.="[/color]";
	
	if ($FlatSpyRepport['lune']) {
		$out.="[color=".$AdvSpyConfig['color']['Spy_Lune']."]";
	    $out.=$lang['DicOgame']['Text']['Spy']['lune'];
		$out.="[/color]";
	} else {
		$out.=" ";
	}

	$out.="[color=".$AdvSpyConfig['color']['Spy_Coord']."][b]";
	$out.=$FlatSpyRepport['coord'];
	$out.="[/b][/color]";
	
	$out.=$lang['DicOgame']['Text']['Spy']['playerstart'].$FlatSpyRepport['player'].$lang['DicOgame']['Text']['Spy']['playerend'];

	$out.=$lang['DicOgame']['Text']['Spy']['interlude'];
	$out.=$FlatSpyRepport['timetext']."\n";

	$out.=$lang['DicOgame']['Text']['Spy']['metal'];
	$out.=" ".AdvSpy_GetFormatedNumberBBCode($FlatSpyRepport['metal'])."\n";

	$out.=$lang['DicOgame']['Text']['Spy']['cristal'];
	$out.=" ".AdvSpy_GetFormatedNumberBBCode($FlatSpyRepport['cristal'])."\n";

	$out.=$lang['DicOgame']['Text']['Spy']['deut'];
	$out.=" ".AdvSpy_GetFormatedNumberBBCode($FlatSpyRepport['deut'])."\n";
	
	$out.=$lang['DicOgame']['Text']['Spy']['energie'];
	$out.=" ".AdvSpy_GetFormatedNumberBBCode($FlatSpyRepport['energie'])."\n";

	foreach($lang['DicOgame']['SpyCatList'] as $Cat=>$Catname){
		if ($FlatSpyRepport[$Cat]) {
		    $out.="[b]".$Catname."[/b]\n";
		}
		foreach($lang['DicOgame'][$Cat] as $num=>$valuesarray){
			if ($FlatSpyRepport[$valuesarray['PostVar']]) {
				$out.="[color=".$AdvSpyConfig['color'][$Cat]."]";
			    $out.=$valuesarray['Name']."[/color] ".AdvSpy_GetFormatedNumberBBCode($FlatSpyRepport[$valuesarray['PostVar']])."\n";
			}
		}
	}
	
	$out.=$lang['DicOgame']['Text']['Spy']['end'];
	$out.=$FlatSpyRepport['proba']."%";
		
	return $out;
}



/**
 * Affichage d'un RE en mode HTML (l'interieur des résultat)
 **/
function AdvSpy_PrintSpyRepportHtmlResult($FlatSpyRepport){
	global $AdvSpyConfig, $lang,$BlockRecherche;
	
	//$AdvancedSpyInfos=array_merge(AdvSpy_GetAdvancedSpyInfosFromFlatSpyRepport($FlatSpyRepport),$FlatSpyRepport);
	$AdvancedSpyInfos=$FlatSpyRepport;

	print $lang['DicOgame']['Text']['Spy']['start'];
	print "<font color='".$AdvSpyConfig['color']['Spy_PlanetName']."'>";
	print $AdvancedSpyInfos['planet_name'];
	print "</font>";
	
	if ($AdvancedSpyInfos['lune']) {
		print "<font color='".$AdvSpyConfig['color']['Spy_Lune']."'>";
		if ($AdvSpyConfig['color']['Spy_LuneBlink']) {
			print "<blink>";
			print $lang['DicOgame']['Text']['Spy']['lune'];
			print "</blink>";
		} else {
			print $lang['DicOgame']['Text']['Spy']['lune'];
		}
		print "</font>";
	} else {
		print " ";
	}

	print "<a title=\"".$lang['UI_Lang']['HSR_ToolTip_System_1'].$AdvancedSpyInfos['spy_galaxy'].":".$AdvancedSpyInfos['spy_system'].$lang['UI_Lang']['HSR_ToolTip_System_2']."\" href='index.php?action=galaxy&galaxy=".$AdvancedSpyInfos['spy_galaxy']."&system=".$AdvancedSpyInfos['spy_system']."'>";
	print "<font color='".$AdvSpyConfig['color']['Spy_Coord']."'>";
	print $AdvancedSpyInfos['coord'];
	print "</font></a>";

	//print "";
	print $lang['DicOgame']['Text']['Spy']['playerstart']."<font color='".$AdvSpyConfig['color']['Spy_PlayerName']."'>".$AdvancedSpyInfos['player']."</font>".$lang['DicOgame']['Text']['Spy']['playerend'];
	
	print $lang['DicOgame']['Text']['Spy']['interlude']; // le

	print "<a title=\"".$lang['UI_Lang']['HSR_ToolTip_Duration1'].strip_tags(AdvSpy_duration(time()-$AdvancedSpyInfos['datadate'])).$lang['UI_Lang']['HSR_ToolTip_Duration2']."\">";
	print $AdvancedSpyInfos['timetext']."<br/>\n";
	print "</a>";
	
	print "<a style=\"cursor:pointer\" title=\"".$lang['UI_Lang']['HSR_ToolTip_Metal'].intval($AdvancedSpyInfos['metal'] / 1000)." K\" onClick=\"AdvSpy_SetMinMetal('".$AdvancedSpyInfos['metal']."')\">";
	print $lang['DicOgame']['Text']['Spy']['metal'];
	print "</a>";
	print " ".AdvSpy_GetFormatedNumber($AdvancedSpyInfos['metal'])."<br/>\n";

	print "<a style=\"cursor:pointer\" title=\"".$lang['UI_Lang']['HSR_ToolTip_Cristal'].intval($AdvancedSpyInfos['cristal'] / 1000)." K\" onClick=\"AdvSpy_SetMinCristal('".$AdvancedSpyInfos['cristal']."')\">";
	print $lang['DicOgame']['Text']['Spy']['cristal'];
	print "</a>";
	print " ".AdvSpy_GetFormatedNumber($AdvancedSpyInfos['cristal'])."<br/>\n";

	print "<a style=\"cursor:pointer\" title=\"".$lang['UI_Lang']['HSR_ToolTip_Deut'].intval($AdvancedSpyInfos['deut'] / 1000)." K\" onClick=\"AdvSpy_SetMinDeut('".$AdvancedSpyInfos['deut']."')\">";
	print $lang['DicOgame']['Text']['Spy']['deut'];
	print "</a>";
	print " ".AdvSpy_GetFormatedNumber($AdvancedSpyInfos['deut'])."<br/>\n";
	
	print "<a style=\"cursor:pointer\" title=\"".$lang['UI_Lang']['HSR_ToolTip_Energie'].intval($AdvancedSpyInfos['energie'] / 1000)." K\" onClick=\"AdvSpy_SetMinEnergie('".$AdvancedSpyInfos['energie']."')\">";
	print "<i>".$lang['DicOgame']['Text']['Spy']['energie']."</i>";
	print "</a>";
	print " ".AdvSpy_GetFormatedNumber($AdvancedSpyInfos['energie'])."<br/>\n";

	$ElementCount=0;
	
	
	foreach($lang['DicOgame']['SpyCatList'] as $Cat=>$Catname){
	
		if (AdvSpy_Options_GetValue('CompactSpy')) { $ElementCount=$ElementCount+1; }
		
		if ($ElementCount==1) { print "<table border=\"0\"><tr><td width=\"300\" valign=\"top\">"; }
		if ($ElementCount==2) { print "<td width=\"300\" valign=\"top\">"; }
		if ($ElementCount==3) { print "<tr><td width=\"300\" valign=\"top\">"; }
		if ($ElementCount==4) { print "<td width=\"300\" valign=\"top\">"; }
	
		if ($AdvancedSpyInfos[$Cat]) {
		    print "<br/><a title=\"Afficher/Masquer $Catname\" onclick=\"AdvSpy_ToggleVisibilityFromID('Spy_".$AdvancedSpyInfos['spy_id']."_DivCat_$Cat')\" style=\"cursor:pointer;\"><b>".$Catname."</b></a><br/>";
		}
		
		$style="";
		if ($BlockRecherche["AdvSpy_Reduire_$Cat"]) { $style="style=\"visibility:hidden;display:none;\""; }
		
		print "<div id=\"Spy_".$AdvancedSpyInfos['spy_id']."_DivCat_$Cat\" $style>";
		foreach($lang['DicOgame'][$Cat] as $num=>$valuesarray){
			if ($AdvancedSpyInfos[$valuesarray['PostVar']] >= 1) { // $AdvancedSpyInfos['spy_id']
			    print "
				<a style=\"cursor:pointer\"
				onClick=\"SwapOptionList('AdvSpy_".$valuesarray['PostVar']."','".$valuesarray['Name']."','AdvSpy_".$valuesarray['PostVar']."','ToolTip_".$AdvancedSpyInfos['spy_id']."');\"
				onMouseOver=\"PopToolTip('".$valuesarray['Name']."','AdvSpy_".$valuesarray['PostVar']."','ToolTip_".$AdvancedSpyInfos['spy_id']."','');\"
				onmouseout=\"KillToolTip('ToolTip_".$AdvancedSpyInfos['spy_id']."')\">
				<font color=\"".$AdvSpyConfig['color'][$Cat]."\">
				".$valuesarray['Name']."
				</font></a> ".AdvSpy_GetFormatedNumber($AdvancedSpyInfos[$valuesarray['PostVar']])."<br/>\n";
			}
		}
		print "</div>";

		if ($ElementCount==1) { print "</td>"; }
		if ($ElementCount==2) { print "</td></tr>"; }
		if ($ElementCount==3) { print "</td>"; }
		if ($ElementCount==4) { print "</td></tr>"; }
		
	}

	if ($ElementCount==1) { print "</tr>"; }
	if ($ElementCount==2) { print ""; }
	if ($ElementCount==3) { print "<td></td></tr>"; }
	if ($ElementCount==4) { print ""; }	
	
	if ($ElementCount) { print "</table>"; }
	
	
	print "<br/>".$lang['DicOgame']['Text']['Spy']['end'];
	print $AdvancedSpyInfos['proba']."%";
}



/**
 * Au cas ou cette fonction existe deja : Tan pis !
 **/
function AdvSpy_GetHtml_OgspyTooltipImage($title,$text,$size=300,$picturepath='images/help_2.png'){
	$html=str_replace(array("\n",'	',"'"),array('','','´'),htmlentities("<table width=\"$size\"><tr><td align=\"center\" class=\"c\">$title</td></tr><tr><th align=\"center\">$text</th></tr></table>"));
	$size2=$size+9;
	return "<img onmouseover=\"this.T_WIDTH=$size2;this.T_TEMP=0;return escape('$html');\" src=\"$picturepath\" style=\"cursor: pointer;\"/>";
}


/**
 * Execution de la requete SQL, filtre, tris, et enfin affichage des RE.
 * c'est pas le meilleur endroit où placer tout ca (adv_html), mais bon...
 **/
function AdvSpy_PrintHtml_Tab_ResultatRecherche(){
	global $AdvSpyConfig, $lang,$db,$BlockRecherche;

	$nothing=$lang['UI_Lang']['Tab_NoSearch1']."<br/><br/>".$lang['UI_Lang']['Tab_NoSearch2']."
<a style=\"cursor:pointer\" title=\"".$lang['UI_Lang']['Tab_Sim_Title']."\" onclick=\"AdvSpy_MenuHideAllThenShowFromID('AdvSpy_DivSimulateur')\"'>".$lang['UI_Lang']['Tab_NoSearch3']."</a>".$lang['UI_Lang']['Tab_NoSearch4']."<br/>";
	
	$AdvSpyConfig['Current']['SearchStats']['TotalPrinted']=0;
	$AdvSpyConfig['Current']['SearchStats']['TotalPrintable']=0;
	$AdvSpyConfig['Current']['SearchStats']['TotalSql']=0;
		
	if ($BlockRecherche['ChercherOK']) {
		if ($query=AdvSpy_GetSqlRequestFromBlockRecherche($BlockRecherche)) {
		    $result = $db->sql_query($query);
		} else {
			print "(Error: Probleme avec votre recherche, le refus vien du générateur de reqete SQL pour les RE) ".$nothing;
		}
		if ($RaidAlertQuery=AdvSpy_GetRaidAlertSqlRequestFromBlockRecherche($BlockRecherche)) {
		    $RaidAlertResult = $db->sql_query($RaidAlertQuery);
		} else {
			print "(Error: Probleme avec votre recherche, le refus vien du générateur de reqete SQL pour les RaidAlert) ".$nothing;
		}		
	} else {
		print $nothing;
	}
	

	//petits details pour le tris
		$SortCriteria='';
		$SortOrder='asc';
		
		if ($BlockRecherche['AdvSpy_TRIS']==1) { // tris par date mais en fait pas de tris parsque c deja dans le SQL donc pas besoin
			$SortCriteria='';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==2) { // tris par date inversé
			$SortCriteria='datadate';
			$SortOrder='asc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==3) { // tris par Ressources total
			$SortCriteria='Ressources_total';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==4) { // tris par Metal
			$SortCriteria='metal';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==5) { // tris par Cristal
			$SortCriteria='cristal';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==6) { // tris par Deut
			$SortCriteria='deut';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==7) { // Flotte (en ressources)
			$SortCriteria='ArmyRessources_f';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==8) { // Indice P/R
			$SortCriteria='Indice_PR';
			$SortOrder='asc';
		}
		
		if ($BlockRecherche['AdvSpy_TRIS']==9) { // PATATE Totale (<)
			$SortCriteria='PATATE';
			$SortOrder='asc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==10) { // PATATE Totale (>)
			$SortCriteria='PATATE';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==11) { // PATATE- Vaisseaux (<)
			$SortCriteria='PATATE_f';
			$SortOrder='asc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==12) { // PATATE- Vaisseaux (>)
			$SortCriteria='PATATE_f';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==13) { // PATATE- Défenses (<)
			$SortCriteria='PATATE_d';
			$SortOrder='asc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==14) { // PATATE- Défenses (>)
			$SortCriteria='PATATE_d';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==15) { // Taux de Patate (>)
			$SortCriteria='TauxPatateVsCurrentAtk';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==16) { // Nombre de PT / GT (>)
			$SortCriteria='Raid_PT';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==17) { // Coordonées (<)
			$SortCriteria='Coords_triable';
			$SortOrder='asc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==18) { // Coordonées (<)
			$SortCriteria='Coords_triable';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==19) { // Scanner d`activité (<)
			$SortCriteria='lastseen';
			$SortOrder='asc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==20) { // Champ de ruines (>)
			$SortCriteria='CDR_t_t';
			$SortOrder='desc';
		}
		if ($BlockRecherche['AdvSpy_TRIS']==21) { // Champ de ruines (<)
			$SortCriteria='CDR_t_t';
			$SortOrder='asc';
		}		
		
	//fin petits details pour le tris


	//recuperation de la liste des raids deja effectués
	$RaidAlertResults=array();
	if(isset($RaidAlertResult))
	while ($val=@mysql_fetch_assoc($RaidAlertResult)) {
		$RaidAlertResults[]=$val;
	}



	$FlatSpyRepportAdvancedList=array();
	$SortList=array();
	$DoublonsList=array();
	
	$TotalSql=0;
	
	
	$NoPrintReason=array();
	$NoPrintReason['AdvSpy_NoDoublon']=0;
	$NoPrintReason['AdvSpy_CoordsToHide']=0;
	$NoPrintReason['AdvSpy_PlayerSearch']=0;
	$NoPrintReason['AdvSpy_AllySearch']=0;
	$NoPrintReason['AdvSpy_PlanetSearch']=0;
	$NoPrintReason['AdvSpy_OnlyGrandNombre']=0;		
	$NoPrintReason['AdvSpy_RessourceMetal']=0;
	$NoPrintReason['AdvSpy_RessourceCristal']=0;
	$NoPrintReason['AdvSpy_RessourceDeut']=0;
	$NoPrintReason['AdvSpy_RessourceEnergie']=0;
	$NoPrintReason['AdvSpy_TauxPatateMini']=0;
	$NoPrintReason['AdvSpy_PatateTotalMin']=0;
	$NoPrintReason['AdvSpy_PatateTotalMax']=0;
	$NoPrintReason['Hide_Allied']=0;
	$NoPrintReason['Hide_AllyProtected']=0;
	$NoPrintReason['customlist_player']=0;
	$NoPrintReason['customlist_allytag']=0;
	$NoPrintReason['customlist_coord']=0;
	$NoPrintReason['AdvSpy_HideRaided']=0;
	$NoPrintReason['AdvSpy_OnlyRaided']=0;
	$NoPrintReason['AdvSpy_BFTD_min']=0;
	$NoPrintReason['AdvSpy_BFTD_max']=0;
	$NoPrintReason['AdvSpy_ShowOnlyMoon']=0;
	$NoPrintReason['Autre_Page']=0;		
	
	
	
	if(isset($result))
	while ($val=@mysql_fetch_assoc($result)) {

		//analyse du RE
		if ($AdvSpyConfig['OgspyConfig']['version'] < '3.05') {
			$FlatSpyRepport=AdvSpy_GetFlatSpyRepportFromRawText($val['rawdata']);
		}
		
		if ($AdvSpyConfig['OgspyConfig']['version'] >= '3.05') {
			$FlatSpyRepport=AdvSpy_GetFlatSpyRepportFromParsedSpy($val);
		}
		
		$AdvancedSpyInfos=array_merge($val,$FlatSpyRepport,AdvSpy_GetAdvancedSpyInfosFromFlatSpyRepport($FlatSpyRepport));



		$AdvancedSpyInfos['Raided']=0;
		foreach($RaidAlertResults as $num=>$values){
			if ( ($values['RaidGalaxy'] == $val['galaxy']) && ($values['RaidSystem'] == $val['system']) && ($values['RaidRow'] == $val['row']) && ($values['RaidLune'] == $FlatSpyRepport['lune']) ) {
				$AdvancedSpyInfos['Raided']=$AdvancedSpyInfos['Raided']+1;
			}
		}

		$FlatSpyRepportAdvancedList[$TotalSql]=$AdvancedSpyInfos;
		$FlatSpyRepportAdvancedList[$TotalSql]['TauxPatateVsCurrentAtk']=AdvSpy_GetTauxPatate($BlockRecherche['AdvSpy_Current_AtkPatate'],$FlatSpyRepportAdvancedList[$TotalSql]['PATATE']);
		
		//coords pour le tris
		$FlatSpyRepportAdvancedList[$TotalSql]['Coords_triable']='1'.AdvSpy_AddZeroToNum($FlatSpyRepportAdvancedList[$TotalSql]['spy_galaxy'],3).AdvSpy_AddZeroToNum($FlatSpyRepportAdvancedList[$TotalSql]['spy_system'],3).AdvSpy_AddZeroToNum($FlatSpyRepportAdvancedList[$TotalSql]['spy_row'],3);
	
		//ca c'est la liste de toutes les informations d'un RE, à partir de ca on peut tout faire.
		//$FlatSpyRepportAdvancedList[0]=
		//[spy_id][spy_galaxy][spy_system][spy_row][sender_id][datadate][rawdata][active][galaxy][system][row][moon][phalanx][gate]
		//[name][ally][player][status][last_update][last_update_moon][last_update_user_id][proba]
		//['planet_name'][coord][lune][timetext][metal][cristal][deut][energie]
		//[Fleet][f_pt][f_gt][f_cle][f_clo][f_cro][f_vb][f_vc][f_rec][f_se][f_bom][f_sat][f_des][f_edlm][f_traq]
		//[Def][d_mis][d_lle][d_llo][d_gaus][d_ion][d_pla][d_pb][d_gb][d_mi][d_mip]
		//[Buildings][b_metal][b_cristal][b_deut][b_solaire][b_fusion][b_robot][b_nanites][b_spatial][b_hmetal][b_hcristal][b_hdeut][b_labo][b_terra][b_missiles][b_lune][b_phalange][b_stargate]
		//[Tech][t_spy][t_ordi][t_armes][t_bouclier][t_protect][t_energie][t_hyper][t_combu][t_impu][t_phyper][t_laser][t_ions][t_plasma][t_reseau][t_graviton]
		//[PATATE][PATATE_f][PATATE_d][PATATE_Balance_f][PATATE_Balance_d][TauxPatateVsCurrentAtk]
		//[ArmyRessourcesD][ArmyRessourcesD_f][ArmyRessourcesD_d][ArmyRessources][ArmyRessources_f][ArmyRessources_d]
		//[GrandNombre][Transport_PT][Transport_GT][Raid_PT][Raid_GT][Ressources_total][Raided]
		//[Raid_metal][Raid_cristal][Raid_deut][Raid_total] [Raid2_metal][Raid2_cristal][Raid2_deut][Raid2_total] [Raid3_metal][Raid3_cristal][Raid3_deut][Raid3_total]
		//['Indice_PR'][Coords_triable] ['lastseen']


		// analyse éliminatoire pour les doublons, en se basant sur un critère chronologique (donc on dois le faire mantenant et PAS APRES le tris)
		$ReadyToPrint=TRUE;
		if ($FlatSpyRepportAdvancedList[$TotalSql]['lune']) {
			$ItemCoord="(".$FlatSpyRepportAdvancedList[$TotalSql]['spy_galaxy'].":".$FlatSpyRepportAdvancedList[$TotalSql]['spy_system'].":".$FlatSpyRepportAdvancedList[$TotalSql]['spy_row'].")";
		} else {
			$ItemCoord="[".$FlatSpyRepportAdvancedList[$TotalSql]['spy_galaxy'].":".$FlatSpyRepportAdvancedList[$TotalSql]['spy_system'].":".$FlatSpyRepportAdvancedList[$TotalSql]['spy_row']."]";
		}
		if ($BlockRecherche['AdvSpy_NoDoublon']) {
			if (in_array($ItemCoord,$DoublonsList)) {
				$ReadyToPrint=FALSE;
				$NoPrintReason['AdvSpy_NoDoublon']++;
			}
			$DoublonsList[]=$ItemCoord;
		}

		
		
		//on copie le critere de tris dans le tableau de tris
		if ($ReadyToPrint) {
			$ThisValue=$FlatSpyRepportAdvancedList[$TotalSql][$SortCriteria];
			// à propos de lastseen faut faire un petit ajustement ici pour que le critère de tris se fasse bien
			if ( (($ThisValue=='') OR ($ThisValue=='??')) AND ($SortCriteria=='lastseen') ) {
				$ThisValue='99';
			}
			
			$SortList[$TotalSql]=$ThisValue;
		}

		$TotalSql++;
	}//fin while


	$AdvSpyConfig['Current']['SearchStats']['TotalSql']=$TotalSql+0;

	
	// le trie du tableau de tris
	if (($SortCriteria!='') && ($SortOrder=='asc') ) {
		if (!asort($SortList,SORT_NUMERIC)) {
			die('erreur tris asc ');
		};
	}
	if (($SortCriteria!='') && ($SortOrder=='desc') ) {
		if (!arsort($SortList,SORT_NUMERIC)) {
			die('erreur tris desc');
		}
	}	
	
	

	$PrintList=array();
	// existe aussi : $TotalSql
	$TotalPrinted=0;
	$TotalPrintable=0;
	
	print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
	
	foreach($SortList as $num=>$criteriavalue){
		$ReadyToPrint=TRUE; // si false alors le RE ne sera pas affiché


		if ($FlatSpyRepportAdvancedList[$num]['lune']) {
			$ItemCoord="(".$FlatSpyRepportAdvancedList[$num]['spy_galaxy'].":".$FlatSpyRepportAdvancedList[$num]['spy_system'].":".$FlatSpyRepportAdvancedList[$num]['spy_row'].")";
		} else {
			$ItemCoord="[".$FlatSpyRepportAdvancedList[$num]['spy_galaxy'].":".$FlatSpyRepportAdvancedList[$num]['spy_system'].":".$FlatSpyRepportAdvancedList[$num]['spy_row']."]";
		}
		//$ItemCoord= [x:x:x] (planete) // (x:x:x) (lune)
		
		//elements cachés
		if (strpos($BlockRecherche['AdvSpy_CoordsToHide'],$ItemCoord) !== FALSE) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_CoordsToHide']++;
		}
		
		//Recherches ...
		if (($BlockRecherche['AdvSpy_PlayerSearch'] != '') && ($BlockRecherche['AdvSpy_PlayerSearch'] != $FlatSpyRepportAdvancedList[$num]['player'])) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_PlayerSearch']++;
		}
		if (($BlockRecherche['AdvSpy_AllySearch'] != '') && ($BlockRecherche['AdvSpy_AllySearch'] != $FlatSpyRepportAdvancedList[$num]['ally'])) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_AllySearch']++;
		}
		if (($BlockRecherche['AdvSpy_PlanetSearch'] != '') && ($BlockRecherche['AdvSpy_PlanetSearch'] != $FlatSpyRepportAdvancedList[$num]['planet_name'])) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_PlanetSearch']++;
		}
		//Grand nombre
		if (($BlockRecherche['AdvSpy_SeuilGrandNombre'] != '') && ($BlockRecherche['AdvSpy_OnlyGrandNombre'] != '') && (1000*$BlockRecherche['AdvSpy_SeuilGrandNombre'] >= $FlatSpyRepportAdvancedList[$num]['GrandNombre'])) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_OnlyGrandNombre']++;
			//echo "¤".(1000*$BlockRecherche['AdvSpy_SeuilGrandNombre'])." >= ".$FlatSpyRepportAdvancedList[$num]['GrandNombre']."¤";
		}
		
		
		// minimum metal/cristal/deut/energie
		
		if (($BlockRecherche['AdvSpy_RessourceMinMetal'] > 0) && (1000*$BlockRecherche['AdvSpy_RessourceMinMetal'] >= $FlatSpyRepportAdvancedList[$num]['metal'])) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_RessourceMetal']++;
		}
		if (($BlockRecherche['AdvSpy_RessourceMinCristal'] > 0) && (1000*$BlockRecherche['AdvSpy_RessourceMinCristal'] >= $FlatSpyRepportAdvancedList[$num]['cristal'])) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_RessourceCristal']++;
		}
		if (($BlockRecherche['AdvSpy_RessourceMinDeut'] > 0) && (1000*$BlockRecherche['AdvSpy_RessourceMinDeut'] >= $FlatSpyRepportAdvancedList[$num]['deut'])) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_RessourceDeut']++;
		}
		if (($BlockRecherche['AdvSpy_RessourceMinEnergie'] > 0) && (1000*$BlockRecherche['AdvSpy_RessourceMinEnergie'] >= $FlatSpyRepportAdvancedList[$num]['energie'])) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_RessourceEnergie']++;
		}		
		
		//taux de PATATE mini, et patate mini/maxi
		
		if (($BlockRecherche['AdvSpy_TauxPatateMini'] != '') && ($BlockRecherche['AdvSpy_TauxPatateMini'] >= $FlatSpyRepportAdvancedList[$num]['TauxPatateVsCurrentAtk'])) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_TauxPatateMini']++;
		}
		if (($BlockRecherche['AdvSpy_PatateTotalMin'] != '') && ($BlockRecherche['AdvSpy_PatateTotalMin']*1000000 > $FlatSpyRepportAdvancedList[$num]['PATATE'])) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_PatateTotalMin']++;
		}
		if (($BlockRecherche['AdvSpy_PatateTotalMax'] != '') && ($BlockRecherche['AdvSpy_PatateTotalMax']*1000000 < $FlatSpyRepportAdvancedList[$num]['PATATE'])) {
			$ReadyToPrint=FALSE;
			$NoPrintReason['AdvSpy_PatateTotalMax']++;
		}
		
		
		//info alliance complémentaires ...
		
		$AllyTagIsAllied=FALSE;
		foreach(explode(',',str_replace(';',',',$AdvSpyConfig['OgspyConfig']['allied'])) as $Allied){
			if ( ($Allied == $FlatSpyRepportAdvancedList[$num]['ally']) AND ($Allied != '') ) { $AllyTagIsAllied=TRUE; }
		}
		foreach($AdvSpyConfig['protection']['customlist_allytag'] as $Allied){
			if ( ($Allied == $FlatSpyRepportAdvancedList[$num]['ally']) AND ($Allied != '') ) { $AllyTagIsAllied=TRUE; }
		}
	
	
		$AllyTagIsProtected=FALSE;
		foreach(explode(',',str_replace(';',',',$AdvSpyConfig['OgspyConfig']['ally_protection'])) as $Protected) {
			if ( ($Protected == $FlatSpyRepportAdvancedList[$num]['ally']) AND ($Protected != '') ) {
				$AllyTagIsProtected=TRUE;
			}
		}
		foreach($AdvSpyConfig['protection']['customlist_allytag'] as $Protected){
			if ( ($Protected == $FlatSpyRepportAdvancedList[$num]['ally']) AND ($Protected != '') ) {
				$AllyTagIsProtected=TRUE;
			}
		}
		$AllyTagIsEnemy=FALSE;
		foreach($AdvSpyConfig['protection']['customlist_enemytag'] as $Enemy){
			if ( ($Enemy == $FlatSpyRepportAdvancedList[$num]['ally']) AND ($Enemy != '') ) {
				$AllyTagIsEnemy=TRUE;
			}
		}
		//$AllyTagIsAllied
		//$AllyTagIsProtected
		
		// 3 nouveaux attributs pour le "$FlatSpyRepportAdvanced" utilisables plus tard dans "AdvSpy_PrintHtmlSearchResult(x,y)"
		
		$FlatSpyRepportAdvancedList[$num]['AllyTagIsAllied']=0;
		$FlatSpyRepportAdvancedList[$num]['AllyTagIsProtected']=0;
		$FlatSpyRepportAdvancedList[$num]['AllyTagIsEnemy']=0;
		if ($AllyTagIsAllied) { $FlatSpyRepportAdvancedList[$num]['AllyTagIsAllied']=1; }
		if ($AllyTagIsProtected) { $FlatSpyRepportAdvancedList[$num]['AllyTagIsProtected']=1; }
		if ($AllyTagIsEnemy) { $FlatSpyRepportAdvancedList[$num]['AllyTagIsEnemy']=1; }
		
		
		//on masque les ally protégées suivant les differents parametres de la configuration.
		if (($AdvSpyConfig['protection']['Hide_Allied']) && ($AllyTagIsAllied) && (!$AdvSpyConfig['UserIsAdmin']) ) { $ReadyToPrint=FALSE; $NoPrintReason['Hide_Allied']++; }
		if (($AdvSpyConfig['protection']['Hide_Protected']) && ($AllyTagIsProtected) && (!$AdvSpyConfig['UserIsAdmin']) ) { $ReadyToPrint=FALSE; $NoPrintReason['Hide_AllyProtected']++; }
		
		//on s'occupe des differentes listes de protection spécifiques AdvSpy.
		// a faire : exception pour les admins
		if ((in_array($FlatSpyRepportAdvancedList[$num]['player'],$AdvSpyConfig['protection']['customlist_player'])) ) { $ReadyToPrint=FALSE; $NoPrintReason['customlist_player']++; }
		if ((in_array($FlatSpyRepportAdvancedList[$num]['ally'],$AdvSpyConfig['protection']['customlist_allytag'])) ) { $ReadyToPrint=FALSE;  $NoPrintReason['customlist_allytag']++; }
		if ((in_array($FlatSpyRepportAdvancedList[$num]['coord'],$AdvSpyConfig['protection']['customlist_coord'])) ) { $ReadyToPrint=FALSE;   $NoPrintReason['customlist_coord']++; }
		
		//On cache les RE raidés
		if ( ($BlockRecherche['AdvSpy_HideRaided']) && ($FlatSpyRepportAdvancedList[$num]['Raided']) ) { $ReadyToPrint=FALSE; $NoPrintReason['AdvSpy_HideRaided']++; }

		//On affiche que les RE raidés
		if ( ($BlockRecherche['AdvSpy_OnlyRaided']) && (!$FlatSpyRepportAdvancedList[$num]['Raided']) ) { $ReadyToPrint=FALSE; $NoPrintReason['AdvSpy_OnlyRaided']++; }

		

		// flotte/def/batiment/tech    mini/maxi
		foreach($lang['DicOgame']['SpyCatList'] as $xCat=>$xCatname){
			foreach($lang['DicOgame'][$xCat] as $xnum=>$xvaluesarray){
				if ($BlockRecherche["AdvSpy_".$xvaluesarray['PostVar']."_Min"] != '') {
					if ($BlockRecherche["AdvSpy_".$xvaluesarray['PostVar']."_Min"] > $FlatSpyRepportAdvancedList[$num][$xvaluesarray['PostVar']]) {
						$ReadyToPrint=FALSE;
						$NoPrintReason['AdvSpy_BFTD_min']++;
					}
				}
				if ($BlockRecherche["AdvSpy_".$xvaluesarray['PostVar']."_Max"] != '') {
					if ($BlockRecherche["AdvSpy_".$xvaluesarray['PostVar']."_Max"] < $FlatSpyRepportAdvancedList[$num][$xvaluesarray['PostVar']]) {
						$ReadyToPrint=FALSE;
						$NoPrintReason['AdvSpy_BFTD_max']++;
					}
				}
			}
		}
	
		if (($BlockRecherche['AdvSpy_ShowOnlyMoon'] == 'ON') AND ($FlatSpyRepportAdvancedList[$num]['lune'] != 1) ) { $ReadyToPrint=FALSE; $NoPrintReason['AdvSpy_ShowOnlyMoon']++; }
		
		
		
		// si il a été gentil, on l'ajoute à la liste des heureux rapports qui vont etre affichés
		if ($ReadyToPrint) {
			if (( ($TotalPrintable+1 >= $BlockRecherche['AdvSpy_SearchResult_Min']) && ($TotalPrintable+1 <= $BlockRecherche['AdvSpy_SearchResult_Max']) )) {
				$PrintList[]=$FlatSpyRepportAdvancedList[$num];				
				$AdvSpyConfig['Current']['PrintedIdList'][]=$FlatSpyRepportAdvancedList[$num]['spy_id'];
				$TotalPrinted++;
			} else {
				$NoPrintReason['Autre_Page']++;
			}
			$TotalPrintable++;
		}
	}


	$AdvSpyConfig['Current']['SearchStats']['TotalPrinted']=$TotalPrinted+0;
	$AdvSpyConfig['Current']['SearchStats']['TotalPrintable']=$TotalPrintable+0;




	//l'affichage en lui meme .


	$AdvSpyConfig['Current']['SearchStats']['Minimales']=array();
	$AdvSpyConfig['Current']['SearchStats']['Maximales']=array();
	$AdvSpyConfig['Current']['SearchStats']['Total']=array();
	$AdvSpyConfig['Current']['SearchStats']['Moyenne']=array();
	$AdvSpyConfig['Current']['SearchStats']['NoPrintReasons']=$NoPrintReason;
	
	foreach($PrintList as $num=>$values){
		//partie pour le calcul des stats (ici c bien)
		foreach($values as $VarName=>$VarValue){
			if ((is_numeric($VarValue)) && ($VarValue > -1) ) {
				if (!$AdvSpyConfig['Current']['SearchStats']['Minimales'][$VarName]) { $AdvSpyConfig['Current']['SearchStats']['Minimales'][$VarName]=99999999999; }
				if (!$AdvSpyConfig['Current']['SearchStats']['Maximales'][$VarName]) { $AdvSpyConfig['Current']['SearchStats']['Maximales'][$VarName]=0; }
				if (!$AdvSpyConfig['Current']['SearchStats']['Total'][$VarName]) { $AdvSpyConfig['Current']['SearchStats']['Total'][$VarName]=0; }
										
				if ($VarValue<@$AdvSpyConfig['Current']['SearchStats']['Minimales'][$VarName]) { $AdvSpyConfig['Current']['SearchStats']['Minimales'][$VarName]=$VarValue; }
				if ($VarValue>@$AdvSpyConfig['Current']['SearchStats']['Maximales'][$VarName]) { $AdvSpyConfig['Current']['SearchStats']['Maximales'][$VarName]=$VarValue; }
				$AdvSpyConfig['Current']['SearchStats']['Total'][$VarName]=@$AdvSpyConfig['Current']['SearchStats']['Total'][$VarName]+$VarValue;
			}
		}
		//on ajoute le RE au buffer de sortie pour l'affichage...
		// ahh ahh y a plus de buffer, on print direct !
		AdvSpy_PrintHtmlSearchResult($values);
	}
	
	//on fini 2/3 trucs pour les stats en dehors de la boucle précédente.
	$Diviseur=$AdvSpyConfig['Current']['SearchStats']['TotalPrinted'];
	if ($Diviseur==0) { $Diviseur=1; }
	foreach($AdvSpyConfig['Current']['SearchStats']['Total'] as $VarName=>$VarValue){
		$AdvSpyConfig['Current']['SearchStats']['Moyenne'][$VarName]=$AdvSpyConfig['Current']['SearchStats']['Total'][$VarName]/$Diviseur;
	}
	
	
	print "\n\n</div></div>\n\n";
	
	
	// le script pour ré-afficher tous les RE :
	print "<script type=\"text/javascript\">
<!--
function AdvSpy_DivResult_SHOWALL() {";
	foreach($AdvSpyConfig['Current']['PrintedIdList'] as $PrintedId){
		print "	AdvSpy_Div_SHOW(\"AdvSpy_DivResult_$PrintedId\");\n";
		//print "	document.getElementById(\"AdvSpy_DivResult_$PrintedId\").style.visibility='visible';\n";
		//print "	document.getElementById(\"AdvSpy_DivResult_$PrintedId\").style.display='';\n";
	}
print " }

function AdvSpy_DivCat_Fleet_SHOWALL() {";
	foreach($AdvSpyConfig['Current']['PrintedIdList'] as $PrintedId){
		print "	AdvSpy_Div_SHOW(\"Spy_".$PrintedId."_DivCat_Fleet\");\n";
	}
print " }

function AdvSpy_DivCat_Def_SHOWALL() {";
	foreach($AdvSpyConfig['Current']['PrintedIdList'] as $PrintedId){
		print "	AdvSpy_Div_SHOW(\"Spy_".$PrintedId."_DivCat_Def\");\n";
	}
print " }

function AdvSpy_DivCat_Buildings_SHOWALL() {";
	foreach($AdvSpyConfig['Current']['PrintedIdList'] as $PrintedId){
		print "	AdvSpy_Div_SHOW(\"Spy_".$PrintedId."_DivCat_Buildings\");\n";
	}
print " }

function AdvSpy_DivCat_Tech_SHOWALL() {";
	foreach($AdvSpyConfig['Current']['PrintedIdList'] as $PrintedId){
		print "	AdvSpy_Div_SHOW(\"Spy_".$PrintedId."_DivCat_Tech\");\n";
	}
print " }




function AdvSpy_DivCat_Fleet_HIDEALL() {";
	foreach($AdvSpyConfig['Current']['PrintedIdList'] as $PrintedId){
		print "	AdvSpy_Div_HIDE(\"Spy_".$PrintedId."_DivCat_Fleet\");\n";
	}
print " }

function AdvSpy_DivCat_Def_HIDEALL() {";
	foreach($AdvSpyConfig['Current']['PrintedIdList'] as $PrintedId){
		print "	AdvSpy_Div_HIDE(\"Spy_".$PrintedId."_DivCat_Def\");\n";
	}
print " }

function AdvSpy_DivCat_Buildings_HIDEALL() {";
	foreach($AdvSpyConfig['Current']['PrintedIdList'] as $PrintedId){
		print "	AdvSpy_Div_HIDE(\"Spy_".$PrintedId."_DivCat_Buildings\");\n";
	}
print " }

function AdvSpy_DivCat_Tech_HIDEALL() {";
	foreach($AdvSpyConfig['Current']['PrintedIdList'] as $PrintedId){
		print "	AdvSpy_Div_HIDE(\"Spy_".$PrintedId."_DivCat_Tech\");\n";
	}
print " }



//-->
</script>\n";
	
	//return $out; PAS DE RETURN !! La fonction print elle meme les RE.
}



/**
 * Onglet Save/Load
 **/
function AdvSpy_PrintHtml_Tab_SaveLoad(){
	global $AdvSpyConfig, $lang,$BlockRecherche,$db;

	//execution ici des actions de sauvegarde

	if ($BlockRecherche['ChercherOK']==$lang['UI_Lang']['BT_Save']) {
		print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
		print "<fieldset style=\"padding: 10px;\"><legend><b> ".$lang['UI_Lang']['Tab_SL_NewSave']." </b></legend>";
		
		//$BlockRecherche['AdvSpy_SaveNameToSave']='';
		//$BlockRecherche['AdvSpy_SaveIsPublic']='';
		//$BlockRecherche['AdvSpy_SaveIsDefault']='';
		//print print_r(AdvSpy_SaveLoad_GetSaveArrayFromBlockRecherche($BlockRecherche),1);
		//$AdvSpyConfig['User_Data']['user_id']
		
		if (($BlockRecherche['AdvSpy_SaveIsDefault']) AND (!$AdvSpyConfig['UserIsAdmin'])) {
			print $lang['UI_Lang']['Tab_SL_Error_PrivateMode'];
			$BlockRecherche['AdvSpy_SaveIsDefault']=0;
		}
		
		if ((!$AdvSpyConfig['Restrictions']['Save_AllowPublic']) AND (!$AdvSpyConfig['UserIsAdmin']) AND ($BlockRecherche['AdvSpy_SaveIsPublic'])) {
			print $lang['UI_Lang']['Tab_SL_Error_PublicMode'];
			AdvSpy_log($lang['UI_Lang']['Tab_SL_Error_PublicMode_Log'],"Warning");
			$BlockRecherche['AdvSpy_SaveIsPublic']=0;
		}
		
		
		if (strlen($BlockRecherche['AdvSpy_SaveNameToSave'])<=2) {
			print $lang['UI_Lang']['Tab_SL_Error_ShortName'];
			$BlockRecherche['AdvSpy_SaveNameToSave']="";
		}

		if (($BlockRecherche['AdvSpy_SaveNameToSave'])) {
			AdvSpy_log("Enregistrement d'une sauvegarde: ".$BlockRecherche['AdvSpy_SaveNameToSave']);
			$SaveData=AdvSpy_array_to_string(AdvSpy_SaveLoad_GetSaveArrayFromBlockRecherche($BlockRecherche));
			$SaveOwner=$AdvSpyConfig['User_Data']['user_id'];
			$SaveType=2; // privé
			if ($BlockRecherche['AdvSpy_SaveIsPublic']) {
				$SaveType=1; // privé/partagé
			}
			if ($BlockRecherche['AdvSpy_SaveIsDefault']) {
				$SaveType=0; // générale
				$SaveOwner=1; // crée par l'utilisateur à l'id numero 1 (compte 'admin' considéré comme "-AdvSpy-") 
				// bug connu au cas où il n'existe pas d'utilisateur 1 mais c'est le compte administrateur par défaut et il est insuppressible
				// donc pas de problèmes tant que la BDD n'est pas trafiquée...
			}
			
			print "Sauvegarde... ";
			$requete = AdvSpy_SaveLoad_GetSqlRequestForNewSave($SaveOwner,$SaveType,$BlockRecherche['AdvSpy_SaveNameToSave'],$SaveData);
			$result = $db->sql_query($requete);
			if ($result) {
				print "OK !<br/>Nouvelle sauvegarde crée:<br/>";
				print $BlockRecherche['AdvSpy_SaveNameToSave'];
			} else {
				print "Erreur (!)";
			}
			
		}
		
		
		print "</fieldset></div></div><br/>";
	}

	//execution ici des actions de suppression

	if ($BlockRecherche['ChercherOK']==$lang['UI_Lang']['BT_Del']) {
		print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
		print "<fieldset style=\"padding: 10px;\"><legend><b> Suppression de sauvegarde : </b></legend>";		
		if ($BlockRecherche['AdvSpy_SaveIdToLoad']) {
			if ($BlockRecherche['AdvSpy_SaveDelConfirmation']) {
				$requete = AdvSpy_SaveLoad_GetSqlRequestForLoad($BlockRecherche['AdvSpy_SaveIdToLoad']);
				$result = $db->sql_query($requete);
				$SaveList=array();
				while ($val=@mysql_fetch_assoc($result)) { $SaveList[]=$val; }
				//$SaveList[0][SaveId][SaveOwner][SaveType][SaveData][SaveName]
				$DroitOK=TRUE;
				if ($AdvSpyConfig['User_Data']['user_id']!=$SaveList[0]['SaveOwner']) { $DroitOK=FALSE; }
				if ($AdvSpyConfig['UserIsAdmin']) { $DroitOK=TRUE; }
				if ($DroitOK) {
					AdvSpy_log("Suppression d'une sauvegarde: ".$SaveList[0]['SaveName']);
					print "Suppression... ";
					$requete = AdvSpy_SaveLoad_GetSqlRequestForDelete($BlockRecherche['AdvSpy_SaveIdToLoad']);
					$result = $db->sql_query($requete);
					if ($result) {
						print "OK !";
					} else {
						print "Erreur (!)";
					}
				} else {
					print "Desolé mais vous n'avez pas le droit de supprimer cette sauvegarde";
				}
			} else {
				print "Vous devez confirmer pour supprimer";
			}
		} else {
			print "Selectionnez une sauvegarde à supprimer";
		}
		print "</fieldset></div></div><br/>";		
	}



	//affichage du reste...	
	print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
	print "<fieldset style=\"padding: 10px;\"><legend><b> Sauvegardes générales et publiques </b></legend>";
	$requete = AdvSpy_SaveLoad_GetSqlRequestForSaveList(1);
	$result = $db->sql_query($requete);
	$SaveList=array();
	while ($val=@mysql_fetch_assoc($result)) { $SaveList[]=$val; }
	
	print AdvSpy_SaveLoad_GetHtmlSaveRadioList($SaveList,"AdvSpy_SaveIdToLoad","AdvSpy_SaveIdToLoad_g_");

	print AdvSpy_GetHtml_SubmitBT($lang['UI_Lang']['BT_Load']);
	print "</fieldset></div></div>";

	print "<br/>";
	
	print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
	print "<fieldset style=\"padding: 10px;\"><legend><b> Sauvegardes privées : (de l'utilisateur ".$AdvSpyConfig['User_Data']['user_name'].")</b></legend>";
	$requete = AdvSpy_SaveLoad_GetSqlRequestForSaveList(0,$AdvSpyConfig['User_Data']['user_id']);
	$result = $db->sql_query($requete);
	$SaveList=array();
	while ($val=@mysql_fetch_assoc($result)) { $SaveList[]=$val; }

	print AdvSpy_SaveLoad_GetHtmlSaveRadioList($SaveList,"AdvSpy_SaveIdToLoad","AdvSpy_SaveIdToLoad_p_");

	print AdvSpy_GetHtml_SubmitBT($lang['UI_Lang']['BT_Load']);

	print "<p align=\"center\"><input type=\"checkbox\" name=\"AdvSpy_SaveDelConfirmation\" id=\"AdvSpy_SaveDelConfirmation\" value=\"ON\" />";
	
	
	$titlemessage="Vous n'etes pas Admin, vous ne pouvez supprimer que vos propres sauvegardes";
	if ($AdvSpyConfig['UserIsAdmin']) { $titlemessage="Vous etes Admin, vous pouvez supprimer n'importe quelle sauvegarde. (Générales et publiques)"; }
	
	print "<label for=\"AdvSpy_SaveDelConfirmation\" style=\"cursor:pointer\" title=\"$titlemessage\">Effacer la sauvegarde selectionnée</label></p>";
	print AdvSpy_GetHtml_SubmitBT($lang['UI_Lang']['BT_Del']);
	
	print "</fieldset></div></div><br/><br/>";

	print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
	print "<fieldset style=\"padding: 10px;\"><legend><b> Nouvelle sauvegarde : </b></legend>";
	print AdvSpy_GetHtml_SubmitBT($lang['UI_Lang']['BT_Save']);
	print "Nom de la sauvegarde :<br/>
	<input type=\"text\" size=\"50\" id=\"AdvSpy_SaveNameToSave\" name=\"AdvSpy_SaveNameToSave\" value=\"Nouvelle sauvegarde\"/><br/>";

	print "Type :<br/>";
	$ListeElementsSauvegarde=array();
	
	if ($AdvSpyConfig['Restrictions']['Save_AllowPublic']) {
		$ListeElementsSauvegarde['AdvSpy_SaveIsPublic']='Sauvegarde Publique';
	} else {
		if ($AdvSpyConfig['UserIsAdmin']) {
			$ListeElementsSauvegarde['AdvSpy_SaveIsPublic']='Sauvegarde Publique';
		}
	}
	
	if ($AdvSpyConfig['UserIsAdmin']) { $ListeElementsSauvegarde['AdvSpy_SaveIsDefault']='Sauvegarde Générale (Admin Only)'; }

	foreach($ListeElementsSauvegarde as $PostVar=>$Name){
		print "<input type=\"checkbox\" id=\"$PostVar\" name=\"$PostVar\" value=\"ON\" /><label for=\"$PostVar\" style=\"cursor:pointer\"> $Name</label><br/>";
	}


	print "<br/>Inclure dans la sauvegarde:<br/>
	<br/>Les critères de recherche,<br/>";

	$ListeElementsSauvegarde=array();
	$ListeElementsSauvegarde['AdvSpy_SaveElement_Tris']='Ordre de tris, résultats min/max et mes scan';
	$ListeElementsSauvegarde['AdvSpy_SaveElement_Secteur']='Secteur (et planètes cachées)';
	$ListeElementsSauvegarde['AdvSpy_SaveElement_RE']='Age Max, Doublons, Lunes, Scan, Réduction et Nom de planète';
	$ListeElementsSauvegarde['AdvSpy_SaveElement_Joueur']='Inactifs, Nom de Joueur et tag d\'ally';
	$ListeElementsSauvegarde['AdvSpy_SaveElement_Ressources']='Grand Nombre, et ressources mini';
	$ListeElementsSauvegarde['AdvSpy_SaveElement_Analyse']='Taux de patate mini, patate mini/maxi et R.E. raidés';
	foreach($ListeElementsSauvegarde as $PostVar=>$Name){
		print "<input type=\"checkbox\" id=\"$PostVar\" name=\"$PostVar\" value=\"ON\" checked/><label for=\"$PostVar\" style=\"cursor:pointer\"> $Name</label><br/>";
	}
	
	print "<br/>".$lang['UI_Lang']['SearchPlus'].",<br/>";
	$ListeElementsSauvegarde=array();
	$ListeElementsSauvegarde['AdvSpy_SaveElement_MMFleet']='Min/Max Flottes';
	$ListeElementsSauvegarde['AdvSpy_SaveElement_MMDef']='Min/Max Défenses';
	$ListeElementsSauvegarde['AdvSpy_SaveElement_MMBuildings']='Min/Max Bâtiments';
	$ListeElementsSauvegarde['AdvSpy_SaveElement_MMTech']='Min/Max Technologies';

	foreach($ListeElementsSauvegarde as $PostVar=>$Name){
		print "<input type=\"checkbox\" id=\"$PostVar\" name=\"$PostVar\" value=\"ON\" checked/><label for=\"$PostVar\" style=\"cursor:pointer\"> $Name</label><br/>";
	}
	

	print "<br/>Simulateur,<br/>";
	$ListeElementsSauvegarde=array();
	$ListeElementsSauvegarde['AdvSpy_SaveElement_Sim_atk']='Flotte attaquant';
	$ListeElementsSauvegarde['AdvSpy_SaveElement_Sim_atk_tech']='Tech attaquant';
	$ListeElementsSauvegarde['AdvSpy_SaveElement_Sim_def']='Flotte (et def) du défenseur';
	$ListeElementsSauvegarde['AdvSpy_SaveElement_Sim_def_tech']='Tech défenseur';

	foreach($ListeElementsSauvegarde as $PostVar=>$Name){
		print "<input type=\"checkbox\" id=\"$PostVar\" name=\"$PostVar\" value=\"ON\" checked/><label for=\"$PostVar\" style=\"cursor:pointer\"> $Name</label><br/>";
	}
	
	
	
	
	print AdvSpy_GetHtml_SubmitBT($lang['UI_Lang']['BT_Save']);
	print "</fieldset></div></div>";

}


/**
 * Onglet Administration
 **/
function AdvSpy_PrintHtml_Tab_Administration(){
	global $AdvSpyConfig, $lang,$BlockRecherche;

	if (!$AdvSpyConfig['UserIsAdmin']) { return "Repasse quand tu seras admin ou co-admin"; }


	// $AdvSpyConfig['Settings']['AdvSpy_AutoUpdate_MasterURL']="http://kilops2.free.fr/og/AdvSpy/";
	$AdvSpy_LastVersionFileName="lastversion.txt";
	//$AdvSpyConfig['version']['advspy']
	$AdvSpy_RemoteVersion=0;
	if ($file = @file($AdvSpyConfig['Settings']['AdvSpy_AutoUpdate_MasterURL'].$AdvSpy_LastVersionFileName)) { $AdvSpy_RemoteVersion=trim(@$file[0]); }

	print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
	print "<fieldset style=\"padding: 10px;\"><legend><b> Mise à jour : </b></legend>";
	print "Votre version de AdvSpy : ".$AdvSpyConfig['version']['advspy']."<br/>";
	print "Dèrnière version disponible : ".$AdvSpy_RemoteVersion."<br/>";

	if ($AdvSpy_RemoteVersion == $AdvSpyConfig['version']['advspy']) {
		print "<font color=\"green\">OK</font>";

	} else {
		if ($AdvSpy_RemoteVersion==0) {
			print "Erreur pendant la recherche de mise à jour<br/>";
			print "Vous pouvez verifier la dernière version disponible via le mod \"Mise à jour de [MOD]\"<br/>
			Ou bien visiter le <a href=\"http://www.ogsteam.fr/forums/sujet-1273-advspy-recherche-crit-selon-fense-flotte\" target=\"_blank\">Topic officiel</a><br/>";
		}
		else {
			if ($AdvSpy_RemoteVersion != $AdvSpyConfig['version']['advspy']) {
				print "<font color=\"red\">Vous devriez mettre à jour le mod !<br/>";
				print "<blink><a href=\"http://www.ogsteam.fr/forums/sujet-1273-advspy-recherche-crit-selon-fense-flotte\" target=\"_blank\">TOPIC OFFICIEL</a></blink>";
				print "</font>";
			}
		}

	}
	print "</fieldset></div></div>";

	print "\n<br/>\n";

	print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
	print "<fieldset style=\"padding: 10px;\"><legend><b> Entretien : </b></legend>";
	
	print "<input type=\"checkbox\" name=\"ForceDefaultSavesInstallation\" id=\"ForceDefaultSavesInstallation\" value=\"ON\" />";
	print "<label for=\"ForceDefaultSavesInstallation\" style=\"cursor:pointer\">Forcer le chargement des sauvegardes par défaut (ne le faites pas plusieurs fois sinon vous aurez tout en double)</label>";
	
	if(isset($pub_ForceDefaultSavesInstallation) && ($pub_ForceDefaultSavesInstallation == "ON") ) {
		print "<br/><font color=\"red\"><strong>Sauvegardes par défaut installées !!!</strong></font>";
	}
	print AdvSpy_GetHtml_SubmitBT($lang['UI_Lang']['BT_Admin']);
	print "</fieldset></div></div>";
	
	if ($AdvSpyConfig['Settings']['EnableDebug']) {
		print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
		print "<fieldset style=\"padding: 10px;\"><legend><b> DEBUG : </b></legend>";
		print "Configuration :<br/>";
		print "<textarea rows=\"15\" cols=\"70\" name=\"debug_config\">";
		print AdvSpy_Print_Rvar($AdvSpyConfig,'$AdvSpyConfig');
		print "</textarea>";
		print "<br/>";
		print "Recherche :<br/>";
		print "<textarea rows=\"15\" cols=\"70\" name=\"debug_blockrecherche\">";
		print AdvSpy_Print_Rvar($BlockRecherche,'$BlockRecherche');
		print "</textarea>";
		print "<br/>";
		
		print "Requete :<br/>";
		print "<textarea rows=\"15\" cols=\"70\" name=\"debug_recherchesql\">";
		print AdvSpy_GetSqlRequestFromBlockRecherche($BlockRecherche);
		print "</textarea>";
		print "<br/>";
		

		
		print "</fieldset>";
		print "</div></div>";

	}
}


/**
 * Affichage d'un tableau à RE
 **/
function AdvSpy_PrintHtmlSearchResult($FlatSpyRepportAdvanced){
	global $AdvSpyConfig, $lang,$BlockRecherche;

	//$FlatSpyRepportAdvanced=
	//[spy_id][spy_galaxy][spy_system][spy_row][sender_id][datadate][rawdata][active][galaxy][system][row][moon][phalanx][gate]
	//[name][ally][player][status][last_update][last_update_moon][last_update_user_id][proba]
	//['planet_name'][coord][lune][timetext][metal][cristal][deut][energie]
	//[Fleet][f_pt][f_gt][f_cle][f_clo][f_cro][f_vb][f_vc][f_rec][f_se][f_bom][f_sat][f_des][f_edlm][f_traq]
	//[Def][d_mis][d_lle][d_llo][d_gaus][d_ion][d_pla][d_pb][d_gb][d_mi][d_mip]
	//[Buildings][b_metal][b_cristal][b_deut][b_solaire][b_fusion][b_robot][b_nanites][b_spatial][b_hmetal][b_hcristal][b_hdeut][b_labo][b_terra][b_missiles][b_lune][b_phalange][b_stargate]
	//['lastseen']
	//[Tech][t_spy][t_ordi][t_armes][t_bouclier][t_protect][t_energie][t_hyper][t_combu][t_impu][t_phyper][t_laser][t_ions][t_plasma][t_reseau][t_graviton]
	//[PATATE][PATATE_f][PATATE_d][PATATE_Balance_f][PATATE_Balance_d][TauxPatateVsCurrentAtk]
	//[ArmyRessourcesD][ArmyRessourcesD_f][ArmyRessourcesD_d][ArmyRessources][ArmyRessources_f][ArmyRessources_d]
	//[GrandNombre][Transport_PT][Transport_GT][Raid_PT][Raid_GT][Ressources_total][Raided]
	//[Raid_metal][Raid_cristal][Raid_deut][Raid_total] [Raid2_metal][Raid2_cristal][Raid2_deut][Raid2_total] [Raid3_metal][Raid3_cristal][Raid3_deut][Raid3_total]
	//['AllyTagIsAllied']['AllyTagIsProtected']['AllyTagIsEnemy']['Indice_PR']

	//[Coords_triable]


	// En premier : le menu de gauche avec tout ce qu'il y a dedan. (c'est à dire les conteneurs pour le Clipboard Copy et 2/3 autres craps)
	
	print "<div id=\"AdvSpy_DivResult_".$FlatSpyRepportAdvanced['spy_id']."\"><table>
	<tr><td valign=\"top\" width=\"10px\">
	<a style=\"cursor:pointer\" onclick=\"";
	if ($FlatSpyRepportAdvanced['lune']==1) {
		print "AdvSpy_HideSearchResult(".$FlatSpyRepportAdvanced['spy_id'].",'(".$FlatSpyRepportAdvanced['spy_galaxy'].":".$FlatSpyRepportAdvanced['spy_system'].":".$FlatSpyRepportAdvanced['spy_row'].")');\">";
	} else {
		print "AdvSpy_HideSearchResult(".$FlatSpyRepportAdvanced['spy_id'].",'[".$FlatSpyRepportAdvanced['spy_galaxy'].":".$FlatSpyRepportAdvanced['spy_system'].":".$FlatSpyRepportAdvanced['spy_row']."]');\">";
	}
	print "<br/><img title=\"Cacher cette planète\" alt=\"hide\" src=\"./images/drop.png\"></a>\n";
	
	//Ancien RE
	print "<br/><br/><a onClick='AdvSpy_PopSpyOldScool(".$FlatSpyRepportAdvanced['spy_id'].",".$FlatSpyRepportAdvanced['spy_galaxy'].",".$FlatSpyRepportAdvanced['spy_system'].",".$FlatSpyRepportAdvanced['spy_row'].")' title='Voir le(s) rapport(s) de cette planète (OGSpy old style)'>
	<img style=\"cursor:pointer\" src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."ogs.png\" width=\"16\" height=\"16\" /></a>\n";
	
	//Voir les stats du joueur
	print "<br/><br/><a style=\"cursor:pointer\" onclick=\"AdvSpy_PopStats(".$FlatSpyRepportAdvanced['spy_id'].",'".$FlatSpyRepportAdvanced['player']."','".$AdvSpyConfig['User_Data']['user_stat_name']."');\">
		<img title=\"Afficher les statistiques de ce joueur\" alt=\"stats\" src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."stats.png\"></a>\n";

	if ($FlatSpyRepportAdvanced['Raided']) {
		print "<br/><br/><a style=\"cursor:pointer\" onclick=\"AdvSpy_PopRaid(".$FlatSpyRepportAdvanced['spy_id'].",".$FlatSpyRepportAdvanced['spy_galaxy'].",".$FlatSpyRepportAdvanced['spy_system'].",".$FlatSpyRepportAdvanced['spy_row'].",".$FlatSpyRepportAdvanced['lune'].");\">
		<img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."raid.gif\" border=\"0\" alt='[R]' title='Cette planète est signalé comme raidée ".$FlatSpyRepportAdvanced['Raided']." fois (depuis ".strip_tags(AdvSpy_duration($BlockRecherche['AdvSpy_RaidAgeMax']))." ).' /></a>\n";
	} else {
		print "<br/><br/><a style=\"cursor:pointer\" onclick=\"AdvSpy_PopRaid(".$FlatSpyRepportAdvanced['spy_id'].",".$FlatSpyRepportAdvanced['spy_galaxy'].",".$FlatSpyRepportAdvanced['spy_system'].",".$FlatSpyRepportAdvanced['spy_row'].",".$FlatSpyRepportAdvanced['lune'].");\">
		<img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."raid.png\" border=\"0\" alt='[R]' title='Signaler votre raid. (Aucun depuis ".strip_tags(AdvSpy_duration($BlockRecherche['AdvSpy_RaidAgeMax']))." )' /></a>\n";
	}

	//Copier le RE

	
	if (AdvSpy_Options_GetValue('ExpressCopyClipRE')) { // copie express de re
		print "<br/><br/><a onClick=\"AdvSpy_CopyHolderToClip('AdvSpy_ClipHolder_Standard_".$FlatSpyRepportAdvanced['spy_id']."');\">
		<img style=\"cursor:pointer\" border=\"0\" src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."copy.png\" title=\"Copie express de rapport dans le presse-papier  (Compatible IE et FireFox**)\" /></a>\n";
	} else { // bouton normal avec menu de copie et tout.
		print "<br/><br/><a onClick='AdvSpy_ToggleVisibilityFromID(\"CopyPop_".$FlatSpyRepportAdvanced['spy_id']."\")'>
		<img style=\"cursor:pointer\" border=\"0\" src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."copy.png\" title=\"Menu de copie de rapport dans le presse-papier  (Compatible IE et FireFox**)\" /></a>\n";

	}
	

	

	
	// fin menu de gauche
	print "\n</td><td valign=\"top\">\n";
	// debut menu du haut

	


	
	print "<div id=\"AdvSpy_ResultTopMenu_".$FlatSpyRepportAdvanced['spy_id']."\" >
		<table border='1' cellpadding='4' cellspacing='2' width='100%'>
			<tr>
			<td align=\"left\" width=\"100\" class=\"b\" >
				<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_AllySearch').value='".$FlatSpyRepportAdvanced['ally']."'\" title='Chercher les rapports sur cette alliance.'>
				<img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."search.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"./index.php?action=search&type_search=ally&string_search=".$FlatSpyRepportAdvanced['ally']."&strict=on\" title='Recherche l`alliance \"".$FlatSpyRepportAdvanced['ally']."\" dans OGSpy' >".$FlatSpyRepportAdvanced['ally']."</td>
			<td align=\"left\" width=\"200\" class=\"b\" >
				<a style=\"cursor:pointer\" onClick=\"document.getElementById('AdvSpy_PlayerSearch').value='".$FlatSpyRepportAdvanced['player']."'\" title='Chercher les rapports sur ce joueur.'>
				<img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."search.png\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"./index.php?action=search&type_search=player&string_search=".$FlatSpyRepportAdvanced['player']."&strict=on\" title='Recherche le joueur \"".$FlatSpyRepportAdvanced['player']."\" dans OGSpy' >".$FlatSpyRepportAdvanced['player']."</a></td>
			<td align=\"center\" width=\"5\" class=\"b\" >
				<label style=\"cursor:pointer\" title='Status Joueur (inactif,vacance...)' for='inactif'>
				<blink><font color=\"#FF0000\"><b>".$FlatSpyRepportAdvanced['status']."</b></font></blink></label></td>
			<td align=\"center\" width=\"50\" class=\"b\" >
				<a onClick='AdvSpy_ViewRessourcesInfo(".$FlatSpyRepportAdvanced['spy_id'].");' style=\"cursor:pointer\" title='~".$FlatSpyRepportAdvanced['Raid_GT']." GT == ".intval($FlatSpyRepportAdvanced['Raid_metal']/1000)."K M + ".intval($FlatSpyRepportAdvanced['Raid_cristal']/1000)."K C + ".intval($FlatSpyRepportAdvanced['Raid_deut']/1000)."K D == ".$FlatSpyRepportAdvanced['Raid_PT']." PT'>";
				
				if (AdvSpy_Options_GetValue('ShowRaidsInPT')) {
					print "<font color=\"#9955FF\"><b>".$FlatSpyRepportAdvanced['Raid_PT']."</b> PT</font>";
				} else {
					print "<font color=\"#9955FF\"><b>".$FlatSpyRepportAdvanced['Raid_GT']."</b> GT</font>";
				}
				
				print "</a></td>

			<td align=\"center\" width=\"60\" class=\"b\">
				<a onClick='AdvSpy_ViewPatateInfo(".$FlatSpyRepportAdvanced['spy_id'].");' style=\"cursor:pointer;background-color: ".AdvSpy_PatatePourcentToColor($FlatSpyRepportAdvanced['TauxPatateVsCurrentAtk'])."\" title=' ".$FlatSpyRepportAdvanced['TauxPatateVsCurrentAtk']." % de chances de gagner (".AdvSpy_GetPointsFromPatate($BlockRecherche['AdvSpy_Current_AtkPatate'])." contre ".AdvSpy_GetPointsFromPatate($FlatSpyRepportAdvanced['PATATE']).")'>
				<font color=\"#FFFFFF\"><b>".$FlatSpyRepportAdvanced['TauxPatateVsCurrentAtk']."</b> %</font></a></td>
				
			<td align=\"center\" width=\"50\" class=\"b\">
				<a onClick='AdvSpy_ToggleVisibilityFromID(\"RecycleInfo_".$FlatSpyRepportAdvanced['spy_id']."\");' style=\"cursor:pointer\" title='".$FlatSpyRepportAdvanced['CDR_t_rec']." Recycleurs == ".intval($FlatSpyRepportAdvanced['CDR_t_m']/1000)."K M + ".intval($FlatSpyRepportAdvanced['CDR_t_c']/1000)."K C == ".intval($FlatSpyRepportAdvanced['CDR_t_t']/1000)."K Total'>
				<font color=\"#CC9911\"><b>".$FlatSpyRepportAdvanced['CDR_t_rec']."</b> ReC</font></a></td>
				
				
			<td align=\"center\" width=\"50\" class=\"b\"><a title=\"Indice 'Patate Par Ressource' (IPR) (plus c'est petit plus ca vaux le coup de raider)\">".$FlatSpyRepportAdvanced['Indice_PR']."</a></td>";

	if (($FlatSpyRepportAdvanced['moon']) && (!$FlatSpyRepportAdvanced['lune'])) {
		print  "<td align=\"center\" class=\"b\"><a title=\"Cette planète possède une lune !\">
		<img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."HasMoon.png\" border=\"0\" alt=\"[M!]\" title=\"Cette planète possède une lune !\" />
		</a></td>";
	} elseif (($FlatSpyRepportAdvanced['lune'])) {
		print  "<td align=\"center\" class=\"b\"><a title=\"Cette planète est une lune\">
		<img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."IsMoon.png\" border=\"0\" alt=\"[M]\" title=\"Cette planète est une lune\" />
		</a></td>";
	}

	if($FlatSpyRepportAdvanced['lastseen']!='')
		print "<td align=\"center\" width=\"20\" class=\"b\" ><a title='Derniers mouvement détecté par le scanner des sondes.'>".$FlatSpyRepportAdvanced['lastseen']."mn</a></td>";
	
	

	if($FlatSpyRepportAdvanced['AllyTagIsAllied'])
		print "<td align=\"center\" width=\"20\" class=\"b\"><a title='Alliance amie (ne pas raider)'><blink><font color=\"#44FF00\"><b>Allié</b></font></blink></a></td>";
	if($FlatSpyRepportAdvanced['AllyTagIsEnemy'])
		print "<td align=\"center\" width=\"20\" class=\"b\"><a title='Alliance ennemie !! (à l`assaut !)'><blink><font color=\"#FF4400\"><b>Enemie</b></font></blink></a></td>";
		

	// un peut d'explication pour celle là :
	//Si on est admin et que :
	//		L'alliance est alliée et les alliés sont protégés
	//	ou
	//		L'alliance est Protegée et la protection est activée
	// alors ...
	// si ce RE est quand meme envoyé à cette fonction c'est qu'on a la chance d'etre un admin, donc on l'affiche...
	if ($AdvSpyConfig['UserIsAdmin'] && (
		 (($FlatSpyRepportAdvanced['AllyTagIsAllied']) && ($AdvSpyConfig['protection']['Hide_Allied'])) ||
		 (($FlatSpyRepportAdvanced['AllyTagIsProtected']) && ($AdvSpyConfig['protection']['Hide_Protected'])) ) ) {
		print "<td align=\"center\" width=\"20\" class=\"b\"><a title='Seul un admin peut le voir.'><blink><font color=\"#FF0088\"><b>Protégé</b></font></blink></a></td>";
	}
	
	if ($FlatSpyRepportAdvanced['Raided']) {
	    print "<td align=\"center\" width=\"20\" class=\"b\"><a onClick='AdvSpy_PopRaid(".$FlatSpyRepportAdvanced['spy_id'].",".$FlatSpyRepportAdvanced['spy_galaxy'].",".$FlatSpyRepportAdvanced['spy_system'].",".$FlatSpyRepportAdvanced['spy_row'].",".$FlatSpyRepportAdvanced['lune'].");' style='cursor:pointer;' title='Cette planète est signalée comme raidée ".$FlatSpyRepportAdvanced['Raided']." fois (depuis ".strip_tags(AdvSpy_duration($BlockRecherche['AdvSpy_RaidAgeMax']))." ) .'><img src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."raid.gif\" border=\"0\"/></a></td>";
	}
	
	
	//print "<td>".$FlatSpyRepportAdvanced['Coords_triable']."</td>";
	
	//Fin du menu du haut
	print "</tr></table></div>";
	
	// les div des differents popups associés à un RE (son id)
	// placés juste apres le menu du haut pour s'afficher par dessus le texte du RE
	print "<DIV id=\"PopSpyOldScool_".$FlatSpyRepportAdvanced['spy_id']."\" style=\"z-index: 20; POSITION: absolute;\"></DIV>";
	print "<DIV id=\"PopStats_".$FlatSpyRepportAdvanced['spy_id']."\" style=\"z-index: 20; POSITION: absolute;\"></DIV>";
	print "<DIV id=\"ToolTip_".$FlatSpyRepportAdvanced['spy_id']."\" style=\"z-index: 20; POSITION: absolute; background-color:".$AdvSpyConfig['color']['ToolTipBackground']."\"></DIV>";

	print "<DIV id=\"PopRaid_".$FlatSpyRepportAdvanced['spy_id']."\" style=\"z-index: 20; POSITION: absolute;visibility:hidden;display:none;\">
<fieldset style=\"padding: 2px; ; color:#C0C0C0; background-color:#000040\">
<legend><a style=\"cursor:pointer\" onClick=\"AdvSpy_PopRaid(".$FlatSpyRepportAdvanced['spy_id'].",".$FlatSpyRepportAdvanced['spy_galaxy'].",".$FlatSpyRepportAdvanced['spy_system'].",".$FlatSpyRepportAdvanced['spy_row'].",".$FlatSpyRepportAdvanced['lune'].")\">
<img src='".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."clear.png' border='0' alt='[X]' title='".$lang['UI_Lang']['CloseMsgText']."'></a> Raid Alert :</legend>
Lorsque vous raidez cette planete, vous pouvez le signaler ici.<br/>
Faites le quand vous envoyez votre flotte, IL N'Y A PAS DE RC A COLLER, ceci sert surtout à garder un historique des raids, pas comptabiliser les gains<br/>
<iframe name=\"Frame_RaidAlert_".$FlatSpyRepportAdvanced['spy_id']."\" id=\"Frame_RaidAlert_".$FlatSpyRepportAdvanced['spy_id']."\" src=\"about:blank\" width=\"600\" height=\"200\" marginwidth=\"1\" marginheight=\"1\" border=\"0\" frameborder=\"0\">
! Get FireFox !</iframe>
<br/>
<a style=\"cursor:pointer\" onClick=\"AdvSpy_PopRaid(".$FlatSpyRepportAdvanced['spy_id'].",".$FlatSpyRepportAdvanced['spy_galaxy'].",".$FlatSpyRepportAdvanced['spy_system'].",".$FlatSpyRepportAdvanced['spy_row'].",".$FlatSpyRepportAdvanced['lune'].")\">
<img src='".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."clear.png' border='0' alt='[X]' title='".$lang['UI_Lang']['CloseMsgText']."'> ".$lang['UI_Lang']['CloseMsgText']." 
<img src='".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."clear.png' border='0' alt='[X]' title='".$lang['UI_Lang']['CloseMsgText']."'>
</a>
&nbsp;</fieldset>
</DIV>";


	print "<div id='PatateInfo_".$FlatSpyRepportAdvanced['spy_id']."' style='z-index: 20; visibility:hidden;display:none;position: absolute;'>
		<fieldset style=\"padding: 2px; ; color:#FFFFFF; background-color:#000040\">
		<legend><a style=\"cursor:pointer\" onClick='AdvSpy_ViewPatateInfo(".$FlatSpyRepportAdvanced['spy_id'].")'><img src='".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."clear.png' border='0' alt='[X]' title='".$lang['UI_Lang']['CloseMsgText']."'></a> PATATE Infos :</legend>
		<br/>
		<table>
		<td>PATATE Défenseur :</td><td>".AdvSpy_GetPointsFromPatate($FlatSpyRepportAdvanced['PATATE'])." P</td></tr>
		<tr><td>PATATE Attaquant :</td><td>".AdvSpy_GetPointsFromPatate($BlockRecherche['AdvSpy_Current_AtkPatate'])." P</td></tr>
		<tr><td></td><td></td></tr>
		<td><b>Chances de Victoire :</b></td><td><font color=\"".AdvSpy_PatatePourcentToColor($FlatSpyRepportAdvanced['TauxPatateVsCurrentAtk'])."\"><b> ".$FlatSpyRepportAdvanced['TauxPatateVsCurrentAtk']." %</b></font></td></tr></table><br/>
		";
	//print "Pour gagner à 85% vous devez envoyer au moins :<br/>";
	print "<table>";
/*		$as_FleetListToPrint=array('vb'=>5);
		foreach($as_RawFleetList as $as_RawFleet){
			if ($as_FleetListToPrint[$as_RawFleet['PostVar']]) {
				$i=0;
				while(as_TauxPATATE(as_CalcPATATE(array($as_RawFleet['PostVar']=>$i),array(),$as_MyTechArmes,$as_MyTechBouclier,$as_MyTechProtect),$as_OtherPATATE,$i,$as_OtherVolume)<=85){
					$i=$i+$as_FleetListToPrint[$as_RawFleet['PostVar']];
				} // while
				echo "<tr><td>~ $i ~</td><td>".$as_RawFleet['SearchString']."</td></tr>";
			}
		}*/
	print  "</table>";
	print  "&lt;&lt;-- Copier cette flotte dans le presse papier (l'autre menu)<br/>";
	print  "<hr/><div align=\"center\" ><a style=\"cursor:pointer\" onClick=\"SendFleetToSimDef('".$FlatSpyRepportAdvanced['f_pt']."','".$FlatSpyRepportAdvanced['f_gt']."','".$FlatSpyRepportAdvanced['f_cle']."','".$FlatSpyRepportAdvanced['f_clo']."','".$FlatSpyRepportAdvanced['f_cro']."','".$FlatSpyRepportAdvanced['f_vb']."','".$FlatSpyRepportAdvanced['f_vc']."','".$FlatSpyRepportAdvanced['f_rec']."','".$FlatSpyRepportAdvanced['f_se']."','".$FlatSpyRepportAdvanced['f_bom']."','".$FlatSpyRepportAdvanced['f_sat']."','".$FlatSpyRepportAdvanced['f_des']."','".$FlatSpyRepportAdvanced['f_edlm']."','".$FlatSpyRepportAdvanced['f_traq']."','".$FlatSpyRepportAdvanced['d_mis']."','".$FlatSpyRepportAdvanced['d_lle']."','".$FlatSpyRepportAdvanced['d_llo']."','".$FlatSpyRepportAdvanced['d_gaus']."','".$FlatSpyRepportAdvanced['d_ion']."','".$FlatSpyRepportAdvanced['d_pla']."','".$FlatSpyRepportAdvanced['d_pb']."','".$FlatSpyRepportAdvanced['d_gb']."','".$FlatSpyRepportAdvanced['d_mi']."','".$FlatSpyRepportAdvanced['d_mip']."','".$FlatSpyRepportAdvanced['t_armes']."','".$FlatSpyRepportAdvanced['t_bouclier']."','".$FlatSpyRepportAdvanced['t_protect']."');\">Copier cette flotte dans le simulateur. (Défenseur)</a></div>";
	print  "<hr/><div align=\"center\" ><a target=\"_blank\" href=\"".AdvSpy_Get_SpeedSimWebUrlFromFlatArray(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_atk_'),$FlatSpyRepportAdvanced)."\" >Copier cette flotte dans WebSim.Speedsim.Net</a></div>";
	print  "<hr/><div align=\"center\" ><a target=\"_blank\" href=\"".AdvSpy_Get_DragoSimUrlFromFlatArray(AdvSpy_GetFlatArmyFromBlockRechercheMask($BlockRecherche,'AdvSpy_Sim_atk_'),$FlatSpyRepportAdvanced)."\" >Copier cette flotte dans Drago-Sim.Com</a></div>";

	print  "<hr/>".AdvSpy_GetHtml_PatateLegende()."</fieldset></div>";

	print  "
		<div id='RecycleInfo_".$FlatSpyRepportAdvanced['spy_id']."' style='z-index: 20; visibility:hidden;display:none;position: absolute;'>
		<fieldset style=\"padding: 2px; ; color:#FFFFFF; background-color:#3c2a00\">

		<legend><a style=\"cursor:pointer\" onClick='AdvSpy_ToggleVisibilityFromID(\"RecycleInfo_".$FlatSpyRepportAdvanced['spy_id']."\")'>
		<img src='".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."clear.png' border='0' alt='[X]' title='".$lang['UI_Lang']['CloseMsgText']."'></a> Recyclage Infos :</legend>";
		
/*
$FlatSpyRepportAdvanced['CDR_f_m'] = 73200;
$FlatSpyRepportAdvanced['CDR_f_c'] = 39600;
$FlatSpyRepportAdvanced['CDR_f_t'] = 112800;
$FlatSpyRepportAdvanced['CDR_f_rec'] = 6;
$FlatSpyRepportAdvanced['CDR_d_m'] = 420000;
$FlatSpyRepportAdvanced['CDR_d_c'] = 162000;
$FlatSpyRepportAdvanced['CDR_d_t'] = 582000;
$FlatSpyRepportAdvanced['CDR_d_rec'] = 30;
$FlatSpyRepportAdvanced['CDR_t_m'] = 73200;
$FlatSpyRepportAdvanced['CDR_t_c'] = 39600;
$FlatSpyRepportAdvanced['CDR_t_t'] = 73200;
$FlatSpyRepportAdvanced['CDR_t_rec'] = 4;
*/
	
	
	if (AdvSpy_Options_GetValue('RecycleDef')) {
		print 'Champ de ruine de cette flotte :<br/>';

		print "<table border=\"0\">
	<tr>
		<td colspan=\"2\" align=\"center\">
		<b>Total</b><table border=\"1\" width=\"100%\">
			<tr>
				<td align=\"center\">Métal</td>
				<td align=\"center\">Cristal</td>
				<td align=\"center\"><b>Total</b></td>
			</tr>
			<tr>
				<td align=\"center\">".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_t_m'])."</td>
				<td align=\"center\">".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_t_c'])."</td>
				<td align=\"center\"><b>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_t_t'])."</b></td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\"><b>Recycleurs : ".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_t_rec'])."</b></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align=\"center\">		<font size=\"2\">Vaisseaux:</font><br>
<table border=\"1\" width=\"100%\">
			<tr>
				<td align=\"center\"><font size=\"2\">Métal</font></td>
				<td align=\"center\"><font size=\"2\">Cristal</font></td>
				<td align=\"center\"><font size=\"2\">Total</font></td>
			</tr>
			<tr>
				<td align=\"center\">".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_f_m'])."</td>
				<td align=\"center\">".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_f_c'])."</td>
				<td align=\"center\">".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_f_t'])."</td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\">Recycleurs : ".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_f_rec'])."</td>
			</tr>
		</table></td>
		<td align=\"center\"><font size=\"2\">Défenses:</font><table border=\"1\" width=\"100%\">
			<tr>
				<td align=\"center\"><font size=\"2\">Métal</font></td>
				<td align=\"center\"><font size=\"2\">Cristal</font></td>
				<td align=\"center\"><font size=\"2\">Total</font></td>
			</tr>
			<tr>
				<td align=\"center\">".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_d_m'])."</td>
				<td align=\"center\">".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_d_c'])."</td>
				<td align=\"center\">".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_d_t'])."</td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\">Recycleurs : ".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_d_rec'])."</td>
			</tr>
		</table></td>
	</tr>
</table>";

	} else {
		print 'Champ de ruine de cette flotte :<br/>';
		print "<table border=\"0\">
	<tr>
		<td colspan=\"2\" align=\"center\">
		<b>Total</b><table border=\"1\" width=\"100%\">
			<tr>
				<td align=\"center\">Métal</td>
				<td align=\"center\">Cristal</td>
				<td align=\"center\"><b>Total</b></td>
			</tr>
			<tr>
				<td align=\"center\">".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_t_m'])."</td>
				<td align=\"center\">".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_t_c'])."</td>
				<td align=\"center\"><b>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_t_t'])."</b></td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\"><b>Recycleurs : ".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['CDR_t_rec'])."</b></td>
			</tr>
		</table>
		</td>
	</tr>
	</table>";

	}

		
	print "</fieldset></div>";
		

	print  "
		<div id='RessourcesInfo_".$FlatSpyRepportAdvanced['spy_id']."' style='z-index: 20; visibility:hidden;display:none;position: absolute;'>
		<fieldset style=\"padding: 2px; ; color:#FFFFFF; background-color:#000040\">
		<legend><a style=\"cursor:pointer\" onClick='AdvSpy_ViewRessourcesInfo(".$FlatSpyRepportAdvanced['spy_id'].")'>
		<img src='".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."clear.png' border='0' alt='[X]' title='".$lang['UI_Lang']['CloseMsgText']."'></a> Ressources Infos :</legend>
		<br/>Ressources à gagner en raidant <br/><br/><table>

		<tr><td> </td><td align='right'>En 1 raid</td> <td align='right'>En 2 raids</td> <td align='right'>En 3 raids</td> </tr>		
		<tr><td>Metal :   </td><td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid_metal'])."</td> <td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid2_metal'])."</td>  <td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid3_metal'])."</td> </tr>
		<tr><td>Cristal : </td><td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid_cristal'])."</td> <td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid2_cristal'])."</td>  <td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid3_cristal'])."</td> </tr>
		<tr><td>Deut :    </td><td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid_deut'])."</td> <td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid2_deut'])."</td>  <td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid3_deut'])."</td> </tr>
		<tr><td>          </td><td align='right'> </td></tr>
		<tr><td>TOTAL :   </td><td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid_total'])."</td> <td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid2_total'])."</td> <td align='right'>".AdvSpy_GetFormatedNumber($FlatSpyRepportAdvanced['Raid3_total'])."</td> </tr></table>
		<br/>
		Soit :<br/>
		<table>
		<tr><td>Grand Transporteur : </td><td align='right'><b>".$FlatSpyRepportAdvanced['Raid_GT']."</b></td></tr>
		<tr><td>Petit Transporteur : </td><td align='right'><b>".$FlatSpyRepportAdvanced['Raid_PT']."</b></td></tr>
		</table>
		</fieldset></div>
		";


		// menu pour copier le rapport dans le prese papier (le nouveau)

	if ($AdvSpyConfig['Settings']['EnableDebug']) { $diviseurpc=33;	} else { $diviseurpc=50; }
		
	print "<DIV width=\"100%\" id=\"CopyPop_".$FlatSpyRepportAdvanced['spy_id']."\" style='z-index: 20; visibility:hidden;display:none;position: absolute;'>
<fieldset style=\"padding: 2px; ; color:#C0C0C0; background-color:#000040\">
<legend><a style=\"cursor:pointer\" onClick='AdvSpy_Div_HIDE(\"CopyPop_".$FlatSpyRepportAdvanced['spy_id']."\")'>
<img src='".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."clear.png' border='0' alt='[X]' title='".$lang['UI_Lang']['CloseMsgText']."'></a>
&nbsp;Copier ce rapport dans le presse-papier :</legend>
<table width=\"100%\" border=\"0\" style=\"border-collapse: collapse\">
	<tr>
		<td width=\"$diviseurpc%\" align=\"center\">
		<a style=\"cursor:pointer\" onClick=\"AdvSpy_CopyHolderToClip('AdvSpy_ClipHolder_Standard_".$FlatSpyRepportAdvanced['spy_id']."');AdvSpy_Div_SHOW('AdvSpy_ClipHolderIcon_Standard_".$FlatSpyRepportAdvanced['spy_id']."');\">
		<img style=\"cursor:pointer\" border=\"0\" src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."copy.png\" title=\"Copier le rapport dans le presse-papier  (Compatible IE et FireFox**)\" /> Copier le rapport 'Standard'</a><br>
		<font size=\"1\">(Texte simple, lisible &amp; compatible SpeedSim)</font></td>

		<td width=\"$diviseurpc%\" align=\"center\">
		<a style=\"cursor:pointer\" onClick=\"AdvSpy_CopyHolderToClip('AdvSpy_ClipHolder_BBCode_".$FlatSpyRepportAdvanced['spy_id']."');AdvSpy_Div_SHOW('AdvSpy_ClipHolderIcon_BBCode_".$FlatSpyRepportAdvanced['spy_id']."');\">
		<img style=\"cursor:pointer\" border=\"0\" src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."copy.png\" title=\"Copier le rapport dans le presse-papier  (Compatible IE et FireFox**)\" /> Copier le rapport au format BBCode</a><br>
		<font size=\"1\">(Pour les forums PhpBB et compatibles)</font></td>";

		if ($AdvSpyConfig['Settings']['EnableDebug']) {
			print "<td width=\"$diviseurpc%\" align=\"center\">
			<a style=\"cursor:pointer\" onClick=\"AdvSpy_CopyHolderToClip('AdvSpy_ClipHolder_Original_".$FlatSpyRepportAdvanced['spy_id']."');AdvSpy_Div_SHOW('AdvSpy_ClipHolderIcon_Original_".$FlatSpyRepportAdvanced['spy_id']."');\">
			<img style=\"cursor:pointer\" border=\"0\" src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."copy.png\" title=\"Copier le rapport dans le presse-papier  (Compatible IE et FireFox**)\" /> Copier les info de DEBUG</a><br>
			<font size=\"1\">(le \$FlatSpyRepport associé)</font></td>";
		}
		
		
	print "</tr>
	<tr>
		<td width=\"$diviseurpc%\" align=\"center\"><img width=\"64\" height=\"64\" id=\"AdvSpy_ClipHolderIcon_Standard_".$FlatSpyRepportAdvanced['spy_id']."\" style=\"cursor:pointer;visibility:hidden;display:none;position: absolute;\" border=\"0\" src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."copy.png\" title=\"Rapport copié !\" onClick=\"AdvSpy_Div_HIDE('AdvSpy_ClipHolderIcon_Standard_".$FlatSpyRepportAdvanced['spy_id']."');\" />
		<TEXTAREA WRAP=\"off\" rows=\"23\" cols=\"$diviseurpc%\" name=\"AdvSpy_ClipHolder_Standard_".$FlatSpyRepportAdvanced['spy_id']."\" id=\"AdvSpy_ClipHolder_Standard_".$FlatSpyRepportAdvanced['spy_id']."\"    onClick=\"AdvSpy_CopyHolderToClip('AdvSpy_ClipHolder_Standard_".$FlatSpyRepportAdvanced['spy_id']."');AdvSpy_Div_SHOW('AdvSpy_ClipHolderIcon_Standard_".$FlatSpyRepportAdvanced['spy_id']."');\" >".AdvSpy_GetFromFlatSpyRepportReStyleString($FlatSpyRepportAdvanced)."</TEXTAREA>\n</td>
		<td width=\"$diviseurpc%\" align=\"center\"><img width=\"64\" height=\"64\" id=\"AdvSpy_ClipHolderIcon_BBCode_".$FlatSpyRepportAdvanced['spy_id']."\" style=\"cursor:pointer;visibility:hidden;display:none;position: absolute;\" border=\"0\" src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."copy.png\" title=\"Rapport copié !\" onClick=\"AdvSpy_Div_HIDE('AdvSpy_ClipHolderIcon_BBCode_".$FlatSpyRepportAdvanced['spy_id']."');\" />
		<TEXTAREA WRAP=\"off\" rows=\"23\" cols=\"$diviseurpc%\" name=\"AdvSpy_ClipHolder_BBCode_".$FlatSpyRepportAdvanced['spy_id']."\" id=\"AdvSpy_ClipHolder_BBCode_".$FlatSpyRepportAdvanced['spy_id']."\"        onClick=\"AdvSpy_CopyHolderToClip('AdvSpy_ClipHolder_BBCode_".$FlatSpyRepportAdvanced['spy_id']."');AdvSpy_Div_SHOW('AdvSpy_ClipHolderIcon_BBCode_".$FlatSpyRepportAdvanced['spy_id']."');\" >".AdvSpy_GetFromFlatSpyRepportReStyleBBCode($FlatSpyRepportAdvanced)."</TEXTAREA>\n</td>";
		
		
		if ($AdvSpyConfig['Settings']['EnableDebug']) {
			print "<td width=\"$diviseurpc%\" align=\"center\"><img width=\"64\" height=\"64\" id=\"AdvSpy_ClipHolderIcon_Original_".$FlatSpyRepportAdvanced['spy_id']."\" style=\"cursor:pointer;visibility:hidden;display:none;position: absolute;\" border=\"0\" src=\"".$AdvSpyConfig['Settings']['AdvSpy_BasePath']."copy.png\" title=\"Rapport copié !\" onClick=\"AdvSpy_Div_HIDE('AdvSpy_ClipHolderIcon_Original_".$FlatSpyRepportAdvanced['spy_id']."');\" />
			<TEXTAREA WRAP=\"off\" rows=\"23\" cols=\"$diviseurpc%\" name=\"AdvSpy_ClipHolder_Original_".$FlatSpyRepportAdvanced['spy_id']."\" id=\"AdvSpy_ClipHolder_Original_".$FlatSpyRepportAdvanced['spy_id']."\"    onClick=\"AdvSpy_CopyHolderToClip('AdvSpy_ClipHolder_Original_".$FlatSpyRepportAdvanced['spy_id']."');AdvSpy_Div_SHOW('AdvSpy_ClipHolderIcon_Original_".$FlatSpyRepportAdvanced['spy_id']."');\" >".AdvSpy_Print_Rvar($FlatSpyRepportAdvanced,'$FlatSpyRepportAdvanced')."</TEXTAREA>\n</td>";
		}
		
	print "</tr>
	<tr>
		<td width=\"100%\" align=\"center\" colspan=\"3\" >Clickez juste sur un des rapports pour le copier</td>
	</tr>


</table>

</fieldset>

</DIV>\n\n";

	
	//Debut du corp du RE
	print AdvSpy_PrintSpyRepportHtmlResult($FlatSpyRepportAdvanced);

	print "</tr></table></div>";

}




function AdvSpy_PrintHtml_Tab_Statistiques() {
	global $AdvSpyConfig, $lang,$BlockRecherche;
	
	print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
	print "<fieldset style=\"padding: 5px;\"><legend><b>Statistiques (Basées sur les résultats affichés de la recherche)</b></legend><br/>";
	
	if ($AdvSpyConfig['Current']['SearchStats']['TotalPrintable']>0) {
	
		print "Nombre de résultats <b>retournés par la base de donnée : ".$AdvSpyConfig['Current']['SearchStats']['TotalSql']."</b><br/>";
		
		print "Nombre de résultats <b>filtrés : </b>";
		
		$printplusbefore=false;
		foreach($AdvSpyConfig['Current']['SearchStats']['NoPrintReasons'] as $ReasonTag=>$RNum){
			if ($RNum>0) {
				
				if (isset($lang['UI_Lang']['NoPrintReason'][$ReasonTag])) {
					$ReasonName=$lang['UI_Lang']['NoPrintReason'][$ReasonTag];
				} else {
					$ReasonName=$ReasonTag;
				}
				
				if ($printplusbefore) { print ' + '; }
				print "<span style=\"cursor:pointer\" title=\"($RNum) Raison : $ReasonName\"> <b><u>$RNum</u></b> </span>\n";
				$printplusbefore=true;
			}
		}
		print "<br/>\n";
		
		print "<b>".round(  ($AdvSpyConfig['Current']['SearchStats']['TotalSql']-$AdvSpyConfig['Current']['SearchStats']['TotalPrintable']  )  /$AdvSpyConfig['Current']['SearchStats']['TotalSql']*100)."%</b> des RE sont filtrés.<br/>";
		print "<br/>\n";
		
		print "Sur un <b>total de ".$AdvSpyConfig['Current']['SearchStats']['TotalPrintable']." <i>affichable</i></b><br />";
		
		print "Nombre de résultats <b>affichés sur cette page: ".$AdvSpyConfig['Current']['SearchStats']['TotalPrinted']."</b><br />
		Avec ".$AdvSpyConfig['Current']['SearchStats']['NoPrintReasons']['Autre_Page']." RE sur les pages suivantes/précédentes.<br />";
		
		
		print "<br/>";
		print "<table border=\"0\"><tbody>";
		print "<tr>";
		print "<td width=\"300px\" align=\"center\" class=\"c\"><b>Description</b></td>";
		print "<td width=\"100px\" align=\"center\" class=\"c\"><b> - Mini - </b></td>";
		print "<td width=\"100px\" align=\"center\" class=\"c\"><b> - Maxi - </b></td>";
		print "<td width=\"100px\" align=\"center\" class=\"c\"><b> - Moyenne - </b></td>";
		print "<td width=\"100px\" align=\"center\" class=\"c\"><b> - Total - </b></td>";
		print "</tr>";

		foreach($lang['FlatSpyElements'] as $ElementPostVar=>$Properties){ //['spy_galaxy']['Name']
			$ElementName=$Properties['Name'];
			//$ElementPostVar
			print "<tr>";
			print "<td class=\"f\" align=\"left\"><b>&nbsp;&nbsp;$ElementName</b></td>";
			print "<td align=\"center\" class=\"b\">".AdvSpy_GetFormatedNumber(round(@$AdvSpyConfig['Current']['SearchStats']['Minimales'][$ElementPostVar]))."</td>";
			print "<td align=\"center\" class=\"b\">".AdvSpy_GetFormatedNumber(round(@$AdvSpyConfig['Current']['SearchStats']['Maximales'][$ElementPostVar]))."</td>";
			print "<td align=\"center\" class=\"b\">".AdvSpy_GetFormatedNumber(round(@$AdvSpyConfig['Current']['SearchStats']['Moyenne'][$ElementPostVar]))."</td>";
			print "<td align=\"center\" class=\"b\">".AdvSpy_GetFormatedNumber(round(@$AdvSpyConfig['Current']['SearchStats']['Total'][$ElementPostVar]))."</td>";
			print "</tr>";
		}
		print "<tr>";
		print "<td align=\"center\" class=\"c\"><b>Description</b></td>";
		print "<td align=\"center\" class=\"c\"><b> - Mini - </b></td>";
		print "<td align=\"center\" class=\"c\"><b> - Maxi - </b></td>";
		print "<td align=\"center\" class=\"c\"><b> - Moyenne - </b></td>";
		print "<td align=\"center\" class=\"c\"><b> - Total - </b></td>";
		print "</tr>";
		print "</tbody></table>";
		
	} else {
		print "Aucun résultat donc pas de stats.";
	}

	print "</fieldset></div></div>";

}


/**
 **/
function AdvSpy_PrintHtml_Tab_Options(){
	global $AdvSpyConfig, $lang,$db;
	
	print "<div class='box'><div class='box_background'> </div> <div class='box_contents'>";
	print "\n<fieldset style=\"padding: 5px;\">\n";
	print "<legend><b>Options</b></legend>\n";
	
	$Current_Edition_Target='-1';
	
	print '<p align="center">Voir / Editer : ';
	
	if ($AdvSpyConfig['UserIsAdmin']) {
	
		if (isset($pub_AdvSpy_OptionsTarget))
			if (is_numeric($pub_AdvSpy_OptionsTarget))
				$Current_Edition_Target = $pub_AdvSpy_OptionsTarget;
	
		print "<select id=\"AdvSpy_OptionsTarget\" name=\"AdvSpy_OptionsTarget\" size=\"1\">\n";

		if ($Current_Edition_Target=='-1')
			print "<option value=\"-1\" selected>Mes options perso (de ".$AdvSpyConfig['User_Data']['user_name'].")</option>";
		else
			print "<option value=\"-1\">Mes options perso (de ".$AdvSpyConfig['User_Data']['user_name'].")</option>";

		if ($Current_Edition_Target=='0')
			print "<option value=\"0\" selected>Les options d'Administration</option>";
		else
			print "<option value=\"0\">Les options d'Administration</option>";
		
		$request = "SELECT * FROM `".$AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad']."`,`".TABLE_USER."`
		WHERE `SaveOwner`=`user_id`
		AND `SaveType` = '8'";
		
		$result = $db->sql_query($request);
		while ($val=@mysql_fetch_assoc($result)) {
			//$val['SaveId 	SaveOwner 	SaveType 	SaveData 	SaveName 	user_id 	user_name 	user_password 	user_admin 	user_coadmin 	user_active 	user_regdate 	user_lastvisit 	user_galaxy 	user_system 	planet_added_web 	planet_added_ogs 	planet_exported 	search 	spy_added_web 	spy_added_ogs 	spy_exported 	rank_added_web 	rank_added_ogs 	rank_exported 	user_skin 	user_stat_name 	management_user 	management_ranking 	disable_ip_check 	off_amiral 	off_ingenieur 	off_geologue 	off_technocrate']
			if ($Current_Edition_Target==$val['user_id']) {
				print "<option value=\"".$val['user_id']."\" selected>Les options de ".$val['user_name']."</option>";
			} else {
				print "<option value=\"".$val['user_id']."\">Les options de ".$val['user_name']."</option>";
			}
		}
		unset($result);

		print '</select>';
		
		print AdvSpy_GetHtml_SubmitBT($lang['UI_Lang']['BT_OptRefresh'],1);
		
		print '</p>';
	
	} else {
	
		print "Mes options perso (de <b>".$AdvSpyConfig['User_Data']['user_name']."</b>)</p>";
	
	}
	
	if ($Current_Edition_Target=='-1') {
		$Current_Edition_Target=$AdvSpyConfig['User_Data']['user_id'];
	}
	
	print '<table>';

	print '<tr>
	<td align="center" class="c">Nom / Description</th>
	<td align="center" class="c"><font size="1">'.AdvSpy_GetHtml_OgspyTooltipImage('Config','Option par défaut telle que définie dans Adv_Config.php',300,'images/help.png').'<br/>Config</font></td>
	<td align="center" class="c"><font size="1">'.AdvSpy_GetHtml_OgspyTooltipImage('Admin','Option telle que définie par l\'administrateur',300,'images/help.png').'<br/>Admin</font></td>
	<td align="center" class="c"><font size="1">'.AdvSpy_GetHtml_OgspyTooltipImage('Verrouillage Admin','L\'administrateur a-t-il verrouillé cette option pour interdire aux utilisateurs de définir leur propre config personelle ?',300,'images/help.png').'<br/>Lock</font></td>
	<td align="center" class="c"><font size="1">'.AdvSpy_GetHtml_OgspyTooltipImage('Admin','Option personnelle telle que définie par l\'utilisateur',300,'images/help.png').'<br/>User</font></td>
	<td align="center" class="c"><font size="1">'.AdvSpy_GetHtml_OgspyTooltipImage('Valeure active','Valeure actuelle de l\'option',300,'images/help.png').'<br/>Actif</font></td>
	<td align="center" class="c">Edition '.AdvSpy_GetHtml_OgspyTooltipImage('Edition','Ce que vous voyez sélectionné par défaut sont vos options personnelles. Mais si l\'admin a verrouillé l\'option, la valeur active peut être différente, et donc utilisée par AdvSpy pour vos recherches.',300,'images/help.png').'</td>
	';
	
	if (($AdvSpyConfig['UserIsAdmin']) AND ($Current_Edition_Target=='0')) {
		print '<td align="center" class="c">Verrouiller'.AdvSpy_GetHtml_OgspyTooltipImage('Verrouiller','(Uniquement en mode `Admin`) Verrouiller la valeur \'Admin\' et forcer tous les utilisateurs à utiliser cette option pour leurs recherches.',300,'images/help.png').'</td>';
	}
	
	print '</tr>';
	
	foreach($lang['Options'] as $OptionVar=>$OptionProp){
		print "<tr>";
		print "<td align=\"left\" style=\"text-align:left;\" class=\"f\">".$OptionProp['Name'].' '.AdvSpy_GetHtml_OgspyTooltipImage($OptionProp['Name'],$OptionProp['Desc']).' : </td>';

		print '<td align="center" class="b">'.AdvSpy_Options_GetHtmlFormatedValue(@$OptionProp['Value_Config'],$OptionProp['Type']).'</td>';
		print '<td align="center" class="b">'.AdvSpy_Options_GetHtmlFormatedValue(@$OptionProp['Value_Admin'],$OptionProp['Type']).'</td>';

		if (isset($OptionProp['Value_Admin_IsLocked'])) {
			if ($OptionProp['Value_Admin_IsLocked']) {
				print '<td align="center" class="b">'."<img border=\"0\" src=\"./mod/AdvSpy/lock.png\" title=\"Verrouillé\"/>".'</td>';
			} else {
				print '<td align="center" ></td>';
			}
		}
		

		print '<td align="center" class="b">'.AdvSpy_Options_GetHtmlFormatedValue(@$OptionProp['Value_User'],$OptionProp['Type']).'</td>';
		
		print '<td align="center" class="b">'.AdvSpy_Options_GetHtmlFormatedValue(AdvSpy_Options_GetValue($OptionVar),$OptionProp['Type']).'</td>';
		
		print '<td>';
		
		
		if ($Current_Edition_Target=='0') {
			print AdvSpy_GetHtml_FormElementByType($OptionProp['Type'],'AdvSpy_Options_'.$OptionVar,AdvSpy_Options_GetValue($OptionVar,0,1));
		} else {
			print AdvSpy_GetHtml_FormElementByType($OptionProp['Type'],'AdvSpy_Options_'.$OptionVar,AdvSpy_Options_GetValue($OptionVar,1));
		}
		
		print '</td>';
		
		
		if ($AdvSpyConfig['UserIsAdmin']) {
			if ($Current_Edition_Target=='0') { // admin
				print '<td align="center" class="b">';
				$selected='';
				if (@$OptionProp['Value_Admin_IsLocked']) { $selected='checked'; }
				$Name='AdvSpy_Options_LockAdmin_'.$OptionVar;
				print "<input type=\"checkbox\" value=\"ON\" name=\"$Name\" id=\"$Name\"/ $selected>";
				print "<label for=\"".$Name."\" style=\"cursor: pointer;\" title=\"Verrouiller la valeur ´Admin´ et forcer tous les utilisateurs à utiliser cette option pour leurs recherches.\"><font size=\"1\">Admin Lock</font></label>";
				print '</td>';
			}
		}
		
		
		print "</tr>";
		
	} // fin foreach

		
	print "</table>";
	
	print AdvSpy_GetHtml_SubmitBT($lang['UI_Lang']['BT_OptSubmit']);
	
	print "<input type=\"checkbox\" name=\"AdvSpy_OptionSaveItAnyway\" value=\"ON\" style=\"visibility:hidden;display:none;\" >\n\n";
	
	print "</fieldset>\n</div></div>";
	
}


/**
 * @access public
 * @return void
 **/
function AdvSpy_GetHtml_FormElementByType($Type,$Name,$Defaut=''){

	if (strpos($Type,'*') === 0) { $Type=substr($Type,1); }  // on vire l'étoile (important)
	$Type=strtolower($Type);
	

	if ($Type=='string') { return "<input type=\"text\" value=\"$Defaut\" size=\"16\" id=\"$Name\" name=\"$Name\"/>"; }

	if ($Type=='integer') { return "<input type=\"text\" value=\"$Defaut\" size=\"4\" id=\"$Name\" name=\"$Name\"/>"; }
	
	if ($Type=='boolean') {
		$on_check='';
		$off_check='';
		if ( ($Defaut=='1') OR ($Defaut=='ON') ) { $on_check='checked'; }
		if ( ($Defaut=='0') OR ($Defaut=='OFF') OR ($Defaut=='') ) { $off_check='checked'; }
		return "<input type=\"radio\" value=\"1\" name=\"$Name\" id=\"".$Name."_ON\" $on_check><label for=\"".$Name."_ON\" style=\"cursor: pointer;\">Oui</label>
<input type=\"radio\" value=\"0\" name=\"$Name\" id=\"".$Name."_OFF\" $off_check><label for=\"".$Name."_OFF\" style=\"cursor: pointer;\">Non</label>\n\n";
	}
	
	if ($Type=='onoff') {
		$on_check='';
		if ( ($Defaut=='1') OR ($Defaut=='ON') ) { $on_check='checked'; }
		return "<input type=\"checkbox\" value=\"ON\" name=\"$Name\" id=\"$Name\" $on_check/>";
	}
	
}

?>
