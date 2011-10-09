// DEBUT FONCTION DE Max485 POUR POUVOIR CONFIGURER SES OPTIONS (Ajouté le Sam 20 Juin 2009)

function ufM_editXUL(action, doc)
{
	// Les differents parametres
	var tab = new Array(
							'agrandir_page',
							'agrandir_page_entiere',
							'supprimer_colo',
							'afficher_ressources_en_vol',
							'suppr_colo_pass_auto',
							'messages_mettre_lien_sur_coords',
							'messages_ajouter_separateur_milier_dans_rapports_espionnage',
							'messages_envoyer_message_alli',
							'messages_ajouter_historique_dans_message',
							'messages_colorer_message_flotte_amical',
							'simu_afficher_renta_defenseur',
							'ajouter_somme_all_planetes',
							'calculProduction_all_planetes',
							'changer_planete_avec_fleche_haut_et_bas',
							'envoyer_formulaire_via_touche_enterInConverto',
							'envoyer_formulaire_via_touche_enterInFlotte',
							'stats_changer_centaine_avec_fleches_gauche_droite',
							'alliance_liste_members_rendre_les_coords_cliquable',
							'simu_formater_rapport_de_combat',
							'chantier_agrandir_zones_saisi',
							'flotte_agrandir_zones_saisi',
							'simu_agrandir_zones_saisi',
							'simu_agrandir_zones_saisi_dynamique',
							'messages_afficher_lien_sur_RC_pour_formater',
							'afficher_pourcentage_points'
					   );

	var nb_tab = tab.length;
	
	if(action == 'save') // Si on demande de sauvegarder les infos
	{
		var array_options = {}; // On demarre le tableau
		
		for(var i=0; i < nb_tab; i++)
		{
			array_options[tab[i]] = doc.getElementById('ufM_'+tab[i]).checked;
		}

		ufSetCharPref('E-UniverS_Compil_Options', uneval(array_options) );
	}
	else if(action == 'get') // Dans le cas ou l'on demande de recuperer des informations
	{
		var options = eval( ufGetPref('E-UniverS_Compil_Options', '') );
		if(typeof options == "undefined")
		{
			var options = { 
								"agrandir_page" : true, 
								"agrandir_page_entiere" : false, 
								"supprimer_colo" : true, 
								"afficher_ressources_en_vol" : true, 
								"suppr_colo_pass_auto" : true, 
								"messages_mettre_lien_sur_coords" : true, 
								'messages_ajouter_historique_dans_message' : true,
								"messages_ajouter_separateur_milier_dans_rapports_espionnage" : true, 
								"messages_envoyer_message_alli" : true, 
								'messages_colorer_message_flotte_amical' : true,
								"simu_afficher_renta_defenseur" : true,
								'changer_planete_avec_fleche_haut_et_bas' : false,
								'envoyer_formulaire_via_touche_enterInConverto' : false,
								'envoyer_formulaire_via_touche_enterInFlotte' : false,
								'stats_changer_centaine_avec_fleches_gauche_droite' : false,
								'alliance_liste_members_rendre_les_coords_cliquable' : true,
								'simu_formater_rapport_de_combat' : true,
								'chantier_agrandir_zones_saisi' : true,
								'flotte_agrandir_zones_saisi' : true,
								'simu_agrandir_zones_saisi' : true,
								'messages_afficher_lien_sur_RC_pour_formater' : true,
								'afficher_pourcentage_points' : true,
							};
		}
							
		for(var i=0; i < nb_tab; i++)
		{
			doc.getElementById('ufM_'+tab[i]).checked = options[tab[i]];
		}
	}
}

// FIN FONCTION DE Max485 POUR POUVOIR CONFIGURER SES OPTIONS (Ajouté le Sam 20 Juin 2009)


/*var prefObj = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefService);
var ufPrefsBranch = prefObj.getBranch("unifox.userprefs.");*/

var ufboolPrefsTrue = new Array("unifoxHighlightPrivates",
				"unifoxHighlightAllyMessages","unifoxHighlightBigDebris",
				"unifoxInfosDeltas","unifoxProdTime",
				"unifoxAddOverviewTime","unifoxBuildingsTime","unifoxResearchTime","unifoxColoriseRessources","unifoxAddGalaxyLinks",
				"unifoxFleetTime","unifoxTransportsNeeded","unifoxRestructurateBody","unifoxResizeImg","unifoxMaxButton",
				"unifoxDescriptionTooltips","unifoxBBcode","unifoxAddMessageOption","unifoxFleetReturnTime","unifoxLastFleets",
				"unifoxVEReturnTime","unifoxAddRanks","ufRENeededShips","unifoxCRConverter","unifoxRSS","unifoxCRConverterAutocopy"
				);//"unifoxShipyardTime",
var ufRadioPref=new Array("unifoxSaveLastUniverse","unifoxSelectUniverse","unifoxUniverseSelectionDisabled");

var ufboolPrefsFalse = new Array("unifoxCoordCopy","unifoxRECopy",'unifoxSimulator',"unifoxMessageSignature","unifoxAllyColors",
											"ufWrittenMessages","ufWrittenMessagesBold","ufWrittenMessagesItalic","unifoxConverter",
											"ufDebugMode",
											"uf_Flotte_lien_pour_aider_remplir_converto",
											"uf_Flotte_lien_pour_aider_vidage_ressources"
											);//"unifoxDatesFromDurations","unifoxRemoveOverviewTime","unifoxOptionsSortByPage"

var ufcharPrefs = new Array( "ufMsgSign","ufLogin","ufPassword", 
							 'ufM_messages_colorer_message_flotte_amical_color_texte',
							 'ufM_messages_colorer_message_flotte_amical_color_backgound'
							 );

var ufintPrefs = new Array("ufDebrisMin","unifoxImgSize","unifoxTimersInterval","ufConverterQuantity");

var ufcolorPrefs = new Array("ufPrivateColor", "ufAllyColor", "ufDebrisColor","ufWrittenMessagesColor","ufTextColor",
									'ufWrittenMessagesBackground');

var ufcharPrefsSelects = new Array("ufServer","ufUni","ufVESpeed","ufConverterFirstRes","ufConverterSdRes","ufRENeededShip");
//var ufcharPrefsSelects2 = new Array();

var ufFleetSpeeds = new Array(100,90,80,70,60,50,40,30,20,10,5,1);

//var ufUniversesXml = uf_getXML("ufUniverses.xml");
var ufUniversesJSON = ufGetJSONPref("ufUniverses");
var ufUnitsJSON = ufGetJSONPref("ufUnits");
//var ufUnitsXml = uf_getXML("ufUnits.xml");
function ufOptionsDebug(e)
{
if(ufGetPref("ufDebugMode", false))
{
try{
ufLog(e.name+": "+e.message+"|line "+e.lineNumber+"");
}catch(e){alert(e);}
}
}
function uf_fillListFromJSON(id, prefix, JSONObj, descAttr, valAttr, sortType){
    try{
	//ufDump(JSONObj);
	//ufLog(elem+" "+JSONObj[elem]);
	var menupopup = document.getElementById(id);
	while (menupopup.childNodes.length > 0) {
		menupopup.removeChild(menupopup.firstChild);
    }
	var pairs = new Array();
	var label = '';
	var value = '';
	for (var i in JSONObj) {
		label = JSONObj[i][descAttr];
		if(valAttr == "INDEX")value = i;
        else value = JSONObj[i][valAttr];
		pairs.push(new Array(label,value));
		ufLog(i+" - label: "+label+" , value: "+value);
	}
   

    function alphaSort(a,b) {
        return a[0].localeCompare(b[0]);
    }
	 function valueSort(a,b) {
        return a[1] > b[1];
    }
    if(sortType == "ALPHABETICAL")
		pairs.sort(alphaSort);
	else if(sortType == "VALUE")
		pairs.sort(valueSort);
	//ufLog("uf_fillListFromJSON :"+"langs[0][0]="+langs[0][0]);
    for (var i=0; i<pairs.length; i++) {
        
        var label = pairs[i][0];
        var value = pairs[i][1];

        var obj = document.createElement("menuitem");
        obj.setAttribute("id", prefix+value);
        obj.setAttribute("label", label);
        obj.setAttribute("value", value);
        //ufLog("uf_fillListFromJSON :"+"obj.getAttribute(label)="+obj.getAttribute("label"));
        menupopup.appendChild(obj); 
    }
}catch(e){ufOptionsDebug(e);}
}

function uf_loadUnis(){
	try {
	ufLog('uf_loadUnis');
	//ufLog(document.getElementById("ufServer").selectedIndex+" "+document.getElementById("ufServer").getElementsByTagName('menuitem').length);
	var server = document.getElementById("ufServer").selectedItem.value;
	ufLog('server='+server);
	
	uf_fillListFromJSON("ufUniPopup", "ufUni-", ufUniversesJSON["servers"][server]["universes"], "name", "INDEX","VALUE");
	document.getElementById("ufUni").selectedIndex = 0;
	} catch(e) { ufOptionsDebug(e);}
}
function ufUpdateShipCapacity(list)
{
//var list=e.target;
ufLog(list+" "+list.value);
//document.getElementById("RENeededShipCapacity").value=list.value;
document.getElementById("RENeededShipCapacity").value=ufUnitsJSON["fleet"][list.value]["capacity"];
}

//////////////////////
//Code from Xtense2
function ufOpen_link(uri) {
	var browser = window.opener.getBrowser();
	browser.selectedTab = browser.addTab(uri);
	window.close();
}
//End of code from Xtense2
//////////////////////////////

function initunifoxPreferences() 
{
	ufM_editXUL('get', document); // Fonction permettant de recuperer les options pour les ajout de Max485 (Sam 20 Juin 2009)
		
    try {
        //uf_fillListFromXml("ufServerPopup", "ufServer-", ufUniversesXml, "server", "url", "url");
        uf_fillListFromJSON("ufServerPopup", "ufServer-", ufUniversesJSON["servers"], "name", "INDEX", "ALPHABETICAL");
    } catch (e) {
        unifoxdebug(e);
    }
	 try {
        //uf_fillListFromXml2("ufRENeededShipPopup", "ufRENeededShip-", ufUnitsXml, "ship", "name", "capacity",false);
		uf_fillListFromJSON("ufRENeededShipPopup", "ufRENeededShip-", ufUnitsJSON["fleet"], "name", "INDEX", "INDEX");
    } catch (e) {
        unifoxdebug(e);
    }
	// document.getElementById("ufRENeededShip").addEventListener("change",ufUpdateShipCapacity,false);
    
    for (var i=0; i < ufboolPrefsTrue.length; i++) {
        try {
            var temp = ufboolPrefsTrue[i];
            document.getElementById(temp).checked=ufGetPref(temp,true);
        } catch (e) {
		  ufLog("ufboolPrefsTrue["+i+"]="+temp);
		document.getElementById(temp).checked=true;
	  }
    }
    for (var i=0; i<ufboolPrefsFalse.length; i++) {
        try {
            var temp = ufboolPrefsFalse[i];
            document.getElementById(temp).checked=ufGetPref(temp,false);
        } catch (e) {
		document.getElementById(temp).checked=false;
	  }
    }
	for (var i=0; i<ufRadioPref.length; i++) {
        try {
            var temp = ufRadioPref[i];
				if(ufGetPref(temp,false))
					document.getElementById(temp).radioGroup.selectedItem=document.getElementById(temp);
					//document.getElementById(temp).selected=true;//setAttribute("selected","true");
				//else document.getElementById(temp).selected=false;//setAttribute("selected","false");
					ufLog(temp+"="+ufGetPref(temp,false));
        } catch (e) {
		//document.getElementById(temp).checked=false;
	  }
    }

    for (var i=0; i<ufcharPrefs.length; i++) {
        try {
            var temp = ufcharPrefs[i];
				var val=ufGetPref(temp,"");
				if(temp=="ufPassword")val=ufDecrypt(val,"pwd");
            document.getElementById(temp).value=val;
        } catch (e) {}
    }
	 for (var i=0; i<ufintPrefs.length; i++) {
        try {
            var temp = ufintPrefs[i];
            document.getElementById(temp).value=ufGetPref(temp,0);
				ufLog("inpref "+temp+" "+ufGetPref(temp,0));
        } catch (e) {}
    }

    for (var i=0; i<ufcolorPrefs.length; i++) {
        try {
            var temp = ufcolorPrefs[i];
            document.getElementById(temp).value=ufGetColorPref(temp,"#CC0000",true);
        } catch (e) {
		document.getElementById(temp).value="#CC0000";
	  }
    }

var menupopup=document.getElementById("ufVESpeedPopup");
	for(var i=0; i< ufFleetSpeeds.length;i++)
	{
	var obj = document.createElement("menuitem");
	obj.setAttribute("id", "fleetspeed"+i);
	obj.setAttribute("label", ufFleetSpeeds[i]);
	obj.setAttribute("value", ufFleetSpeeds[i]);
	/*if(ufFleetSpeeds[i]==ufGetPref("ufVESpeed", 100))
		obj.setAttribute("selected",true);*/
	menupopup.appendChild(obj);
	}		 
    for (var i=0; i<ufcharPrefsSelects.length; i++) {
        try {
            var temp = ufcharPrefsSelects[i];
				//ufLog("temp="+temp);
				var val=ufGetPref(temp, "####");
				//ufLog(val);
				/*var item=document.getElementById(temp + "-" + val);
				if(item && val!="####")
					document.getElementById(temp).selectedItem=item;
				else */
				var menulist=document.getElementById(temp);
				menulist.selectedIndex=0;
				var items=menulist.getElementsByTagName("menuitem");
				//dumpProperties_o(menulist);
				for(var j=0;j<items.length;j++)
					{
					if(items[j].value==val)menulist.selectedIndex=j;
					}
			if (temp == "ufServer")
				{
				//ufLog(temp);
				uf_loadUnis();
				}
        } catch (e) {}
    }
	 /*for (var i=0; i<ufcharPrefsSelects2.length; i++) {
        try {
            var temp = ufcharPrefsSelects2[i];
				//ufLog("temp="+temp);
				var val=ufGetPref(temp, 0);
				//ufLog(val);
				var menulist=document.getElementById(temp);
				menulist.selectedIndex=val;//la préférence et le n° dans la liste sont les mêmes.
        } catch (e) {menulist.selectedIndex=0;}
    }*/
	 ufUpdateShipCapacity(document.getElementById("ufRENeededShip"));
///////
//alert(ufGetPref("ufVESpeed", 100));

///////
	//var res = ufUnitsXml.getElementsByTagName("resource");
	var res = ufUnitsJSON["resources"];
	//ufLog("res:"+res);
	var names=new Array();
	var list=document.getElementById("unifoxFreightOrder");
	/*for(var i in res)
		{
		//ufLog("res loading n "+i);
		//var nameNode=res[i].getElementsByTagName('name')[0];
		//names[i]=ufGetLocaleChild(nameNode);
		names.push(res[i]["name"]);
		}*/
	var order=ufGetPref("unifoxFreightOrder",123);
	switch(order) {//blindage
		case 123:
		case 132:
		case 213:
		case 231:
		case 312:
		case 321:
			break;
		default:order=123;
	}
	order=order+"";
	order=order.split('');
	for(var i in order)
		{
		x=parseInt(order[i]);
		ufLog("res loading: "+x+" "+res[x]["name"]);
		list.appendItem(res[x]["name"],x);
		it=list.getItemAtIndex ( list.getRowCount()-1);
		it.index=i;
		}

///////
	//var saved=PrefsBranchUF.getCharPref("unifoxAllyColorsList2");
	var saved=ufGetPref("unifoxAllyColorsList","");
	if(saved=="");
	else{
		var colors=new Array();//couleurs appliquees
		var allies=new Array();//noms des l'alliances
		var backs=new Array();//fond
		if(saved.match(/%#[a-fA-F0-9]{6}%#/) || saved.match(/%#[a-fA-F0-9]{6}%\//) )
				{//très ancien mode
				var tab=saved.split('/');
				for(k=0;k<tab.length;k++)
					{
					tab2=tab[k].split('%');
					//alert(tab2.length);
					allies[k]=tab2[0];
					colors[k]=tab2[1];
					backs[k]=tab2[2];
					}
				}
		else if(saved.match(/%%#[a-fA-F0-9]{6}%%#/) || saved.match(/%%#[a-fA-F0-9]{6}%%\//) )
				//ancien mode
				{
				var tab=saved.split('//');
				for(k=0;k<tab.length;k++)
					{
					tab2=tab[k].split('%%');
					//alert(tab2.length);
					allies[k]=tab2[0];
					colors[k]=tab2[1];
					backs[k]=tab2[2];
					}
				}
			else {//nouveau mode
			var tab=saved.split(uf_separator1);
				
				for(k=0;k<tab.length;k++)
					{
					tab2=tab[k].split(uf_separator2);
					//alert(tab2.length);
					allies[k]=tab2[0];
					colors[k]=tab2[1];
					backs[k]=tab2[2];
					}
				}
			//pour tous les modes
			var list = document.getElementById("unifoxAllyColorsList");
				for(k=0;k<tab.length;k++)
					{
					//alert(k);
					uf_addAlly(list,allies[k],colors[k],backs[k],k);
					}
					//displayproperties_o(list,false);
						
		}
	
	

	try {
	document.addEventListener("click",ufWrittenMessagesBoldOrItalicClicked,false);
	/*document.getElementById("ufWrittenMessagesBold").addEventListener("click",ufWrittenMessagesBoldClicked,false);
	document.getElementById("ufWrittenMessagesItalic").addEventListener("click",ufWrittenMessagesItalicClicked,false);*/
	ufWrittenMessagesBoldClicked();
	ufWrittenMessagesItalicClicked();

	}
	catch (e) {
        unifoxdebug(e);
    }

	var i = 0;
	var lista = document.getElementById("uf_missionPriorities");

	var pref = ufGetPref("ufMissionPreference"+i,"-1");
	var button;
 	while (pref != "-1") {
      	button = document.getElementById("uf_missionButton"+pref);
		lista.appendItem((lista.getRowCount()+1)+". "+button.label,pref);
		button.setAttribute('hidden','true');
		i++;
		pref = ufGetPref("ufMissionPreference"+i,"-1");
	}
		//if(ufGetPref("ufDebugMode", false);)alert("load:"+i+" "+lista.getRowCount());	
		
	/* CR converter options*/
	var options = ufGetCRconvOptions();
	if(ufCRconvPref.bools) {
		//ufLog("loading CR booleans");
		for(var i in ufCRconvPref.bools) {
			//ufLog("searching "+ufCRconvPref.bools[i]);
			var checkbox = document.getElementById("ufCR"+i);
			if(checkbox) {
				//ufLog('options.'+ufCRconvPref.bools[i]+' | '+eval('options.'+ufCRconvPref.bools[i]));
				var val = val = eval('options.'+i);
				if(typeof val =='undefined')val = ufCRconvPref.bools[i];
				checkbox.checked = val;
			}
		}
	}
	if(ufCRconvPref.texts) {
		//ufLog("loading CR texts");
		for(var i in ufCRconvPref.texts) {
			//ufLog("searching "+i);
			var textbox = document.getElementById("ufCR"+i);
			if(textbox) {
				//ufLog('options.'+i+' | '+eval('options.'+i));
				var val = eval('options.'+i);
				if(typeof val =='undefined')val = ufCRconvPref.texts[i];
				//val = unescape(val);
				textbox.value = val;
			}
		}
	}
	if(ufCRconvPref.menulists) {
		//ufLog("loading CR booleans");
		for(var i in ufCRconvPref.menulists) {
			//ufLog("searching "+ufCRconvPref.menulists[i]);
			var list = document.getElementById("ufCR"+i);
			if(list) {
				//ufLog('options.'+ufCRconvPref.menulists[i]+' | '+eval('options.'+ufCRconvPref.menulists[i]));
				var val = val = eval('options.'+i);
				if(typeof val =='undefined')val = ufCRconvPref.menulists[i];
				
				list.selectedIndex=0;
				var items=list.getElementsByTagName("menuitem");
				//dumpProperties_o(menulists);
				for(var j=0;j<items.length;j++) {
					if(items[j].value==val)
						list.selectedIndex=j;
				}
			}
		}
	}
	/*if(ufCRconvPref.colors) {
		var grid = 
		for(var i in ufCRconvPref.colors) {
			
		}
	}*/
}


function ufsavePreferences() {
    
    try {

		ufM_editXUL('save', document); // Appelle la fonction permettant de sauver les options ajouter par Max485 (Sam 20 Juin 2009)
		
        for (var i=0; i<ufboolPrefsFalse.length; i++) {
            var temp = ufboolPrefsFalse[i];
            ufSetBooleanPref(temp, document.getElementById(temp).checked);
        }
        for (var i=0; i<ufboolPrefsTrue.length; i++) {
            var temp = ufboolPrefsTrue[i];
            ufSetBooleanPref(temp, document.getElementById(temp).checked);
        }
		  for (var i=0; i<ufRadioPref.length; i++) {
            var temp = ufRadioPref[i];
				//ufLog("radioprefsaving-"+temp+":"+document.getElementById(temp).selected+"-"+document.getElementById(temp).checked);
				ufSetBooleanPref(temp,document.getElementById(temp).selected)
			}
			//dumpProperties_o(document.getElementById(temp));
        for (var i=0; i<ufcharPrefs.length; i++) {
            var temp = ufcharPrefs[i];
				var val=document.getElementById(temp).value;
				if(temp=="ufPassword")val=ufEncrypt(val,"pwd");
            ufSetCharPref(temp, val);
        }

        for (var i=0; i<ufintPrefs.length; i++) {
            var temp = ufintPrefs[i];
            ufSetIntPref(temp, uf_parseInt(document.getElementById(temp).value));
        }
        for (var i=0; i<ufcolorPrefs.length; i++) {
            var temp = ufcolorPrefs[i];
            ufSetCharPref(temp, document.getElementById(temp).value);
        }

        for (var i=0; i<ufcharPrefsSelects.length; i++) {
            var temp = ufcharPrefsSelects[i];
            if (document.getElementById(temp).selectedItem != null) {
					
                ufSetCharPref(temp, document.getElementById(temp).selectedItem.value);
				ufLog("saving select pref:"+temp+" - "+document.getElementById(temp).value);
            }
        }
		  
		 /* for (var i=0; i<ufcharPrefsSelects2.length; i++) {
            var temp = ufcharPrefsSelects2[i];
            if (document.getElementById(temp).selectedItem != null) {
				//	ufLog("saving select pref:"+temp);
                ufSetCharPref(temp, document.getElementById(temp).selectedIndex);
            }
        }*/
////
	//var res = ufUnitsXml.getElementsByTagName("resource");
	//ufLog("res:"+res);
	var list=document.getElementById("unifoxFreightOrder");
	var text='';
	for(var i=0;i<list.getRowCount();i++)
		{
		text+=list.getItemAtIndex(i).value;
		}
	ufSetIntPref("unifoxFreightOrder",uf_parseInt(text));
////
	var list = document.getElementById("unifoxAllyColorsList");
	var tab=new Array();
	for(k=0;k<list.getRowCount();k++)
		{
		tab[k]=list.getItemAtIndex(k).value;
		}
	var saving=tab.join(uf_separator1);
	 ufSetCharPref("unifoxAllyColorsList",saving);
/////
        
	  var lista = document.getElementById("uf_missionPriorities");
	  var i = 0;
  	  for (i = 0; i < lista.getRowCount(); i++) {
            ufSetCharPref("ufMissionPreference"+i, lista.getItemAtIndex(i).value);	
	  }
		//if(ufGetPref("ufDebugMode", false);)alert("save:"+i+" "+lista.getRowCount());
        ufSetCharPref("ufMissionPreference"+i, "-1");
        
        
    
	/*CR options*/
  // var options = {};
	var options = ufGetCRconvOptions();
	ufLog("saving CR options"+options);
	if(ufCRconvPref.bools) {
		var bools = [];//"bools:{";
		//ufLog("saving CR booleans");
		for(var i in ufCRconvPref.bools) {
			//ufLog("searching "+i+"("+ufCRconvPref.bools[i]+")");
			option = document.getElementById("ufCR"+i);
			if(option) {
				var val = option.checked;
			}
			else var val = ufCRconvPref.bools[i];
			
			options[i]=val;
		}
	}
	if(ufCRconvPref.texts) {
		var texts = [];//"texts:{";
		//ufLog("saving CR booleans");
		for(var i in ufCRconvPref.texts) {
			//ufLog("searching "+i+"("+ufCRconvPref.texts[i]+")");
			option = document.getElementById("ufCR"+i);
			if(option) {
				var val = option.value;
			}
			else var val = ufCRconvPref.texts[i];
			//val = escape(val);
			
			options[i]=val;
		}
	}
	if(ufCRconvPref.menulists) {
		var menulists = [];
		//ufLog("saving CR lists");
		for(var i in ufCRconvPref.menulists) {
			//ufLog("searching "+i+"("+ufCRconvPref.menulists[i]+")");
			option = document.getElementById("ufCR"+i);
			if(option) {
				var val = option.value;
			}
			else var val = ufCRconvPref.menulists[i];
			
			options[i]=val;
		}
	}
	
	//options = "("+ufSerialize(options)+")";
	ufSetCRconvOptions(options);
	//ufSetCharPref("unifoxCRConverterOptions",options);
	
	
	/*end*/
	return true;
	} catch (e) {
        alert (e);
        return true;
   }
}


//---------------------------------------------------------------
function ufinitWindow() {

	initunifoxPreferences();
	document.getElementById("typeTabs").selectedIndex=1;
	document.getElementById("pageTabs").onselect=uf_onselectTabs;
	document.getElementById("typeTabs").onselect=uf_onselectTabs;	
	document.getElementById("pageTabs2").onselect=uf_onselectTabs;	
}

function unifox_getSortedKeysForArray(values, sortProperty) {
 
    var keys = new Array();
    
    for (var key in values) {
        keys[keys.length] = key;
    }
    
    function sortfunction(a,b) {
        return values[a][sortProperty].localeCompare(values[b][sortProperty]);
    }
    
    keys.sort(sortfunction);
    
    return keys;
    
}
//---------------------------------------------------------------
function ufWrittenMessagesBoldOrItalicClicked(e)
{
if(e.target==document.getElementById("ufWrittenMessagesBold"))ufWrittenMessagesBoldClicked();
else if(e.target==document.getElementById("ufWrittenMessagesItalic"))ufWrittenMessagesItalicClicked();
	
}
//---------------------------------------------------------------
function ufWrittenMessagesBoldClicked()
{
var box=document.getElementById("ufWrittenMessagesBold");
if(box.checked)
{
//si la case est cochée, on change le style
box.setAttribute('style','font-weight:bold');
}
else {
//si la case est cochée, on change le style
box.setAttribute('style','font-weight:normal');
}
}
function ufWrittenMessagesItalicClicked()
{
var box=document.getElementById("ufWrittenMessagesItalic");
if(box.checked)
{
//si la case est cochée, on change le style
box.setAttribute('style','font-style:italic');
}
else {
//si la case est cochée, on change le style
box.setAttribute('style','font-style:normal');
}
}
//---------------------------------------------------------------
function uf_initColor() {

	var pref = window.arguments[0];
	document.getElementById("ufColorPicker").color=ufGetColorPref(pref,uf_isColor(pref)?pref:'#CC0000',false);
	/*try {
      	document.getElementById("ufColorPicker").color=ufPrefsBranch.getCharPref(pref);

   	} catch (e) {
		document.getElementById("ufColorPicker").color="#CC0000";
   	}*/
}

function uf_saveColor() {

	var pref = window.arguments[0];
	if(pref != '' && !uf_isColor(pref))
	//alert(pref);
      ufSetCharPref(pref, document.getElementById("ufColorPicker").color);

	return true;
}
function uf_returnColor() {
	var ele = window.arguments[1];
	try {
		window.opener.document.getElementById(ele).value = document.getElementById("ufColorPicker").color;
	} catch(e) {
		ufOptionsDebug(e);
	}
}

function uf_openColor(pref,ele) {
	window.openDialog('chrome://unifox/content/unifoxColorPicker.xul','ColorPicker','chrome',pref,ele);
	return true;
}

//---------------------------------------------------------------//---------------------------------------------------------------//---------------------------------------------------------------
function uf_initAlly() {
	try {
		document.getElementById("ufAllyBackgroundColor").value=window.opener.document.getElementById("ufAllyBackgroundColor").value;
		document.getElementById("ufAllyNameColor").value=window.opener.document.getElementById("ufAllyNameColor").value;
		document.getElementById("ufAllyName").value=window.opener.document.getElementById("ufAllyName").value;
   	} catch (e) {
		document.getElementById("ufAllyNameColor").value="#CC0000";
		document.getElementById("ufAllyName").value="TAG exact de l'alliance";
   	}
}

function uf_addAllyButton() {
document.getElementById("allyListMode").checked=false;
window.openDialog('chrome://unifox/content/allyColorPicker.xul','AllyPicker','chrome');
}

function uf_addAlly(list,name,color,back,ind)
{
	
	var test=false;
	for(i=0;i<list.getRowCount();i++)
		{
		var it=list.getItemAtIndex(i);
		if(it.label==name)test=true;
		}
	if(test)return;
	try{
	//var st=list.getRowCount()+":";
	var st="";
	list.appendItem(st+name,name+uf_separator2+color+uf_separator2+back);
	it=list.getItemAtIndex ( list.getRowCount()-1);
	list.ensureElementIsVisible (it);
	//it.label=color;
	it.setAttribute("style","color:"+color+";background-color:"+back);
	it.setAttribute("onclick","uf_refreshName(this);");
	//it.setAttribute('ondraggesture','nsDragAndDrop.startDrag(event,listObserver);');
	it.setAttribute('id',it.value);
	it.index=ind;
	uf_refreshName(it);
	//it.label=color;
	}catch(e){ufOptionsDebug(e);}
}
//^%%#FFFFFF%%#333399//Angels%%#ffee47%%#004664//Jormund%%#ffee47%%#004664//FIS%%#ffee47%%//AntiNoob%%#009900%%undefined//Intru%%#6600CC%%//HAVE FUN%%#999900%%//TRD%%#3333FF%%undefined//Mordor_e%%#CC9933%%//WG%%#990000%%//[Heroes]%%#666666%%//FTPGENTO%%#339999%%undefined//XTM%%#CC6600%%//EP.Org%%#CC33CC%%//llm%%#663300%%//.A.A.%%#FF6600%%//B.D%%#00CCCC%%undefined//PLOP%%#993399%%//TZU%%#CC0000%%//SNIPERS%%#FFCC33%%undefined//MCP%%#99FF99%%undefined//KD%%#FFCC00%%//_X.A_%%#CCCCFF%%// %%#FFFFFF%%#FF0000//thib s%%#FFFFFF%%#FF0000//LoRd SeAr%%#FFFFFF%%#FF0000//FireHawk%%#FFFFFF%%#FF0000//gaunt%%#FFFFFF%%#FF0000//ForD%%#FFFFFF%%#FF0000//Alkor%%#FFFFFF%%#FF0000//kamikaze009%%#FFFFFF%%#FF0000//itachi shinobi%%#FFFFFF%%#33FF33//rocky%%#FFFFFF%%#33FF33//Kill BiZ%%#FFFFFF%%#33FF33////test%%#FFFFFF%%#33FF33
//^%#FFFFFF%#333399/Angels%#ffee47%#004664/Jormund%#ffee47%#004664/FIS%#ffee47%/AntiNoob%#009900%undefined/Intru%#6600CC%/HAVE FUN%#999900%/TRD%#3333FF%undefined/Mordor_e%#CC9933%/WG%#990000%/[Heroes]%#666666%/FTPGENTO%#339999%undefined/XTM%#CC6600%/EP.Org%#CC33CC%/llm%#663300%/.A.A.%#FF6600%/B.D%#00CCCC%undefined/PLOP%#993399%/TZU%#CC0000%/SNIPERS%#FFCC33%undefined/MCP%#99FF99%undefined/KD%#FFCC00%/_X.A_%#CCCCFF%/ %#FFFFFF%#FF0000/thib s%#FFFFFF%#FF0000/LoRd SeAr%#FFFFFF%#FF0000/FireHawk%#FFFFFF%#FF0000/gaunt%#FFFFFF%#FF0000/ForD%#FFFFFF%#FF0000/Alkor%#FFFFFF%#FF0000/kamikaze009%#FFFFFF%#FF0000/itachi shinobi%#FFFFFF%#33FF33/rocky%#FFFFFF%#33FF33/Kill BiZ%#FFFFFF%#33FF33/test%#FFFFFF%#33FF33

function uf_insertAlly(targetitem,id)
{
//var list=targetitem.parentNode;
//alert(targetitem.value+'\n'+list.id);
//var test=list.getItemAtIndex ( parseInt(id) );
//alert(id+'\n'+test.value);
//test=document.getElementById(id);
//alert(id+'\n'+test.value);
//alert(targetitem.parentNode.id);
//targetitem.parentNode.removeChild(document.getElementById(id));

	targetitem.parentNode.insertBefore(document.getElementById(id),targetitem);
	//alert('ok');
}

function uf_confirmAlly()
{
var mode = window.opener.document.getElementById("allyListMode").checked;
var name = document.getElementById("ufAllyName").value;
if(name=="")return;
var color = document.getElementById("ufAllyNameColor").value;
//ufLog("color="+color+"|isColor="+uf_isColor(color,true)+"|isColor="+uf_isColor(color));
if(!uf_isColor(color,true) /*&& color !=""*/)return;
var back = document.getElementById("ufAllyBackgroundColor").value;
if(!uf_isColor(back,true) /*&& back !=""*/)return;

if(mode)//true pour une édition
	{
	var a= window.opener.document.getElementById("unifoxAllyColorsList");
	try{
	for(i=0;i<a.getRowCount();i++)
		{
		var it=a.getItemAtIndex ( i );
		if(it.selected)//si  l'alliance est sélectionnée, on veut l'écraser
			{
			it.label=name;
			it.setAttribute("style","color:"+color+";background-color:"+back);
			it.value=name+uf_separator2+color+uf_separator2+back;
			i=a.getRowCount();
			uf_refreshName(it);
			}
		}

	}catch(e){ufOptionsDebug(e);}
	return true;
}
else {//false pour un ajout

	var list =window.opener.document.getElementById("unifoxAllyColorsList");
	uf_addAlly(list,name,color,back);
}
}

function uf_editAlly() 
{
document.getElementById("allyListMode").checked=true;
var a = document.getElementById("unifoxAllyColorsList");
var it=a.currentItem;
if(it)
{
uf_refreshName(it);
window.openDialog('chrome://unifox/content/allyColorPicker.xul','AllyPicker','chrome');
}
}

function uf_removeAlly() {
	var a = document.getElementById("unifoxAllyColorsList");

	for(i=0;i<a.getRowCount();i++)
		{
		var it=a.getItemAtIndex ( i );
		if(it.selected){
		a.removeItemAt(i);
		i--;
		}
		}
	//uf_refreshList("unifoxAllyColorsList");
}

function uf_refreshName(it)
{
try{
var tab=it.value.split(uf_separator2);
it.ownerDocument.getElementById("ufAllyName").value=tab[0];
it.ownerDocument.getElementById("ufAllyNameColor").value=tab[1];
it.ownerDocument.getElementById("ufAllyBackgroundColor").value=tab[2];
	}catch(e){ufOptionsDebug(e);}
}
//---------------------------------------------------------------//---------------------------------------------------------------//---------------------------------------------------------------
function uf_borrarLista(id,prefix) {
	var a = document.getElementById(id);
	var id2;
	var button;
	while(a.getRowCount() > 0) {
		id2 = prefix + a.getItemAtIndex(0).value;
		button = document.getElementById(id2);
		button.setAttribute("hidden","false");
		a.removeItemAt(0);
	}
	document.getElementById(prefix+1).focus();
}
function uf_borrarUltimo(id, prefix) {
	var a = document.getElementById(id);
	var id2 = prefix + a.getItemAtIndex(a.getRowCount()-1).value;
	var button = document.getElementById(id2);
	button.setAttribute("hidden","false");
	a.removeItemAt(a.getRowCount()-1);
	document.getElementById(prefix+1).focus();
}
function uf_anadir(id,label,value) {
	var a = document.getElementById(id);
	a.appendItem((a.getRowCount()+1)+". "+label,value);
}
//---------------------------------------------------------------//---------------------------------------------------------------//---------------------------------------------------------------




//---------------------------------------------------------------//---------------------------------------------------------------//---------------------------------------------------------------
function uf_openSymbol()
{
try{
window.openDialog('chrome://unifox/content/symbolPicker.xul','symbolPicker','chrome');
}catch(e){ufOptionsDebug(e);}
}
function uf_initSymbol()
{
localcharPrefs=new Array("unifoxProdTimeSymbol1","unifoxProdTimeSymbol2");
localboolPrefsFalse=new Array("unifoxShowProdTimeLikeOgame");
for (var i=0; i<localcharPrefs.length; i++) {
        try {
		
            var temp = localcharPrefs[i];
            document.getElementById(temp).value=ufGetPref(temp,"TIME!");
        } catch (e) {unifoxdebug(e)}
    }
for (var i=0; i<localboolPrefsFalse.length; i++) {
        try {
            var temp = localboolPrefsFalse[i];
            document.getElementById(temp).checked=ufGetPref(temp,false);
        } catch (e) {
		document.getElementById(temp).checked=false;
	  }
    }
document.getElementById("unifoxShowProdTimeLikeOgame").addEventListener("click",uf_symbolcheckboxchanged,false);
if(document.getElementById("unifoxShowProdTimeLikeOgame").checked)
	{
	//on masque la 2e zone
	document.getElementById("unifoxProdTimeSymbol2").disabled=true;
	//et on change le default
	ufSetCharPref('unifoxdefaultSymbol1','&nbsp;(TIME!)');
	}
else{
	//on affiche la 2e zone
	document.getElementById("unifoxProdTimeSymbol2").disabled=false;
	//et on change le default
	//ufSetCharPref('unifoxdefaultSymbol1','<a title="TIME!" style="color:yellow; font:Courrier New, Arial;"><img alt="sablier jaune" src="http://jormund.free.fr/sablier4.gif"/></a>');
	ufSetCharPref('unifoxdefaultSymbol1','<span style="font-size:0.9em;">- TIME!</span>');
	}
}

function uf_symbolcheckboxchanged(e)
{
//alert(e.target.checked);
if(e.target.checked)
	{
	//on masque la 2e zone
	document.getElementById("unifoxProdTimeSymbol2").disabled=true;
	//et on change le default
	ufSetCharPref('unifoxdefaultSymbol1','&nbsp;(TIME!)');
	}
else{
	//on affiche la 2e zone
	document.getElementById("unifoxProdTimeSymbol2").disabled=false;
	//et on change le default
	//ufSetCharPref('unifoxdefaultSymbol1','<a title="TIME!" style="color:yellow; font:Courrier New, Arial;"><img alt="sablier jaune" src="http://jormund.free.fr/sablier4.gif"/></a>');
	ufSetCharPref('unifoxdefaultSymbol1','<span style="font-size:0.9em;">- TIME!</span>');
	}
}

function uf_defaultSymbol()
{
try{
document.getElementById("unifoxProdTimeSymbol1").value=ufGetPref('unifoxdefaultSymbol1','!TIME');
//document.getElementById("unifoxProdTimeSymbol2").value='<a title="TIME!" style="color:yellow; font:Courrier New, Arial;"><img alt="sablier jaune" src="http://jormund.free.fr/sablier3.gif"/></a>';
document.getElementById("unifoxProdTimeSymbol2").value='<span style="font-size:0.9em;">- TIME!</span>';
}catch(e){ufOptionsDebug(e);}
}

function uf_saveSymbol()
{
localcharPrefs=new Array("unifoxProdTimeSymbol1","unifoxProdTimeSymbol2");
localboolPrefsFalse=new Array("unifoxShowProdTimeLikeOgame");
for (var i=0; i<localcharPrefs.length; i++) {
        try {
		
            var temp = localcharPrefs[i];
            ufSetCharPref(temp,document.getElementById(temp).value);
        } catch (e) {unifoxdebug(e)}
    }
for (var i=0; i<localboolPrefsFalse.length; i++) {
        try {
            var temp = localboolPrefsFalse[i];
            ufSetCharPref(temp,document.getElementById(temp).checked);
        } catch (e) {
		document.getElementById(temp).checked=false;
	  }
    }
}


//---------------------------------------------------------------//---------------------------------------------------------------//---------------------------------------------------------------
function uf_appendElementsInPanel(targetId,elemIds,inputIds)
{
	try
	{
	
		var target = document.getElementById(targetId);
		
		if(target && elemIds.length>0)
		{
			//on recopie les valeurs des textbox
			var values = new Array();
			for(var i=0;i<inputIds.length;i++)
				{
				values[i] = document.getElementById(inputIds[i]).value;
				}
			//alert(values[i-1]);
			for(var i=0;i<elemIds.length;i++)
			{
				var elem = document.getElementById(elemIds[i]);
				if(elem)
				{
					//elem.parentNode.removeChild(elem);
					//target.appendChild(elem);
					/*if(target.firsChild)
						{
						target.insertBefore(target.firsChild,elem);
						//alert(elem);
						}
					else*/
					target.appendChild(elem);
				}
			}
			
			for(var i=0;i<inputIds.length;i++)
			{
				document.getElementById(inputIds[i]).value = values[i];
			}
		}
	}
	catch(e)
	{
		alert('append error' + i);
	}
}


function uf_onselectTabs()
{
tabs=this;
//var L=tabs.getElementByTagName("tab").length-1;
//ufLog(tabs.getAttribute("id")+" says:"+tabs.selectedItem.getAttribute("id"));
var I=tabs.selectedIndex;
if(I!=0)
{


/*for(var i=0;i<3;i++)
	{
	var invitab=document.getElementById('inviTab'+i);
	var p=invitab.parentNode;
	ufLog('i+p==tabs: '+i+" "+(p==tabs));
	if(p!=tabs)p.selectedIndex=0;
	}*/
if(tabs.getAttribute("id")=="typeTabs")
	{
	document.getElementById("pageTabs").onselect="";
	document.getElementById("pageTabs").selectedIndex=0;
	document.getElementById("pageTabs").onselect=uf_onselectTabs;
	document.getElementById("pageTabs2").onselect="";
	document.getElementById("pageTabs2").selectedIndex=0;
	document.getElementById("pageTabs2").onselect=uf_onselectTabs;
	document.getElementById("typeTabs").onselect="";
	document.getElementById("typeTabs").selectedIndex=0;
	document.getElementById("typeTabs").selectedIndex=I;
	document.getElementById("typeTabs").onselect=uf_onselectTabs;
	}
if(tabs.getAttribute("id")=="pageTabs")
	{
	document.getElementById("typeTabs").onselect="";
	document.getElementById("typeTabs").selectedIndex=0;
	document.getElementById("typeTabs").onselect=uf_onselectTabs;
	document.getElementById("pageTabs2").onselect="";
	document.getElementById("pageTabs2").selectedIndex=0;
	document.getElementById("pageTabs2").onselect=uf_onselectTabs;
	document.getElementById("pageTabs").onselect="";
	document.getElementById("pageTabs").selectedIndex=0;
	document.getElementById("pageTabs").selectedIndex=I;
	document.getElementById("pageTabs").onselect=uf_onselectTabs;
	}
if(tabs.getAttribute("id")=="pageTabs2")
	{
	document.getElementById("typeTabs").onselect="";
	document.getElementById("typeTabs").selectedIndex=0;
	document.getElementById("typeTabs").onselect=uf_onselectTabs;
	document.getElementById("pageTabs").onselect="";
	document.getElementById("pageTabs").selectedIndex=0;
	document.getElementById("pageTabs").onselect=uf_onselectTabs;	
	document.getElementById("pageTabs2").onselect="";
	document.getElementById("pageTabs2").selectedIndex=0;
	document.getElementById("pageTabs2").selectedIndex=I;
	document.getElementById("pageTabs2").onselect=uf_onselectTabs;
	}
//ufLog(tabs.getAttribute("id")+" says:"+"index changed to"+I+'('+tabs.selectedItem.getAttribute("id")+')');
uf_updateTabPanelOnFocus(tabs.selectedItem.getAttribute("id"));
}
}

function uf_updateTabPanelOnFocus(panel)
{
try{
//ufLog("uf_updateTabPanelOnFocus(panel)="+panel);
var target=false;
var param = null;
var param2 = null;
switch(panel)
	{
	//anciens onglets
	case 'colors'://on reforme la moitié de droite
						/*target = 'colorsVbox'; 
						param1 = new Array ('selectUniverseGbox',
													'privateMessagesGbox',
													'allyMessagesGbox',
													'highlightBigDebrisGbox'											
													);
						param2 = new Array ('ufAllyColor',
													'ufPrivateColor',
													'ufDebrisColor',
													'ufDebrisMin'
													);
						uf_appendElementsInPanel(target,param1,param2);
						//on rassemble tout
						target = 'colorsHbox'; //panel or panel's vbox
						param1 = new Array ('allyColorsGbox',
													'colorsVbox'											
													);
						param2 = new Array ('ufAllyColor',
													'ufPrivateColor',
													'ufDebrisColor',
													'ufDebrisMin'
													);*/
						document.getElementById('unifoxAllyColorsList').setAttribute('rows','5');
						target = 'colorsVbox'; 
						param1 = new Array ('allyColorsGbox',
													'privateMessagesGbox',
													'allyMessagesGbox',
													'highlightBigDebrisGbox',
													'messageFormatGbox',
													'textColorGbox'
													);
						param2 = new Array ('ufAllyColor',
													'ufPrivateColor',
													'ufDebrisColor',
													'ufDebrisMin',
													'ufWrittenMessagesColor',
													'ufWrittenMessagesBackground',
													'ufTextColor'
													);
						break;
	case 'actions':target = 'actionsVbox'; //panel or panel's vbox
						param1 = new Array ('unifoxCoordCopy',
													'unifoxRECopy',
													'unifoxSimulator',
													'unifoxLastFleets',
													'unifoxAddMessageOption',
													'missionPreferenceGbox',
													'converterGbox',
													'messageSignatureGbox'
													
													//'messageFormatGbox'											
													);//elements to add
						param2 = new Array ('ufMsgSign',
													'ufConverterQuantity'
													//'ufWrittenMessagesColor'
													);//text inputs							
						break;
	case 'comp':	//on reforme la Gbox des heures
						target = 'hoursGbox';
						param1 = new Array ('unifoxAddOverviewTime',
													'unifoxBuildingsTime',
													'unifoxResearchTime',
													'unifoxFleetTime',
													'unifoxFleetReturnTime',
													'timersIntervalBox',
													"VESpeedBox",
													"unifoxVEReturnTime"
													);
						param2 = new Array ('unifoxTimersInterval');
						uf_appendElementsInPanel(target,param1,param2);
						target = 'compVbox'; //panel or panel's vbox
						param1 = new Array ('unifoxInfosDeltas',
													'prodTimeHbox',
													'RENeededShipsGbox',
													'hoursGbox'
													);//elements to add
						param2 = new Array ('unifoxTimersInterval',
													'RENeededShipCapacity');//text inputs							
						break;
	case 'times':	target = 'timesVbox';
						param1 = new Array ('unifoxAddOverviewTime',
													'unifoxBuildingsTime',
													'unifoxResearchTime',
													'unifoxFleetTime',
													'unifoxFleetReturnTime',
													'timersIntervalBox'
													);
						param2 = new Array ('unifoxTimersInterval');
						break;
	case 'display'://on reforme la Gbox des heures
						/*target = 'hoursGbox';
						param1 = new Array ('unifoxAddOverviewTime',
													'unifoxBuildingsTime',
													'unifoxResearchTime',
													'unifoxFleetTime',
													'unifoxFleetReturnTime',
													'timersIntervalBox'
													);
						param2 = new Array ('unifoxTimersInterval');
						uf_appendElementsInPanel(target,param1,param2);*/
						//on reforme la Gbox des boutons
						target = 'buttonsGbox';
						param1 = new Array ('unifoxAddGalaxyLinks',
													'unifoxMaxButton',
													'unifoxTransportsNeeded'
													);
						param2 = new Array (0);
						uf_appendElementsInPanel(target,param1,param2);
						//on ajoute tout comme les autres onglets
						target = 'displayVbox'; //panel or panel's vbox
						param1 = new Array ('unifoxBBcode',
													//'hoursGbox',
													'buttonsGbox',
													'displayGbox'
													);//elements to add
						param2 = new Array ('unifoxImgSize'//,
													//'unifoxTimersInterval'
													);//text inputs							
						break;
	//nouveaux onglets
	case 'overview':target = 'overviewVbox'; //panel or panel's vbox
						param1 = new Array ('unifoxAddGalaxyLinks',
													'unifoxAddOverviewTime',
													"unifoxVEReturnTime",
													"VESpeedBox"
													);//elements to add
						param2 = new Array (
													);//text inputs							
						break;
	case 'buildings':target = 'buildingsVbox'; //panel or panel's vbox
						param1 = new Array ('unifoxInfosDeltas',
													'prodTimeHbox',
													'unifoxBuildingsTime',
													'displayGbox'
													);//elements to add
						param2 = new Array ('unifoxImgSize'
													);//text inputs							
						break;
	case 'research':target = 'researchVbox'; //panel or panel's vbox
						param1 = new Array ('prodTimeHbox',
													'unifoxResearchTime',
													'displayGbox'
													);//elements to add
						param2 = new Array ('unifoxImgSize'
													);//text inputs							
						break;
	case 'messages':target = 'messagesVbox'; //panel or panel's vbox
						param1 = new Array ('unifoxBBcode',
													'unifoxRECopy',
													'unifoxAddMessageOption',
													'allyMessagesGbox',
													'privateMessagesGbox',
													'messageSignatureGbox',
													'messageFormatGbox',
													'RENeededShipsGbox'														
													);//elements to add
						param2 = new Array ('ufAllyColor',
													'ufPrivateColor',
													'ufMsgSign',
													'ufWrittenMessagesColor',
													'ufWrittenMessagesBackground',
													'RENeededShipCapacity'
													);//text inputs
						/*target = 'messagesVbox1'; //panel or panel's vbox
						param1 = new Array ('unifoxBBcode',
													'unifoxAddMessageOption',
													'allyMessagesGbox',
													'privateMessagesGbox'											
													);//elements to add
						param2 = new Array ('ufAllyColor',
													'ufPrivateColor'
													);//text inputs
						uf_appendElementsInPanel(target,param1,param2);
						target = 'messagesVbox2'; //panel or panel's vbox
						param1 = new Array ('messageSignatureGbox',
													'messageFormatGbox'													
													);//elements to add
						param2 = new Array ('ufMsgSign',
													'ufWrittenMessagesColor'
													);//text inputs*/
						break;
	case 'galaxy':/*target = 'galaxyVbox'; //panel or panel's vbox
						param1 = new Array ('highlightBigDebrisGbox'												
													);//elements to add
						param2 = new Array ('ufDebrisColor',
													'ufDebrisMin'
													);//text inputs
						uf_appendElementsInPanel(target,param1,param2);
						//on rassemble tout
						target = 'galaxyHbox'; //panel or panel's vbox
						param1 = new Array ('allyColorsGbox',
													'galaxyVbox'											
													);
						param2 = new Array ('ufDebrisColor',
													'ufDebrisMin'
													);		*/
						document.getElementById('unifoxAllyColorsList').setAttribute('rows','15');
						target = 'galaxyVbox'; //panel or panel's vbox
						param1 = new Array ('allyColorsGbox',
													'unifoxAddRanks',
													'highlightBigDebrisGbox'														
													);
						param2 = new Array ('ufDebrisColor',
													'ufDebrisMin'
													);
						break;
	/*case 'stats':target = 'statsVbox'; //panel or panel's vbox
						param1 = new Array ('allyColorsGbox'												
													);//elements to add
						param2 = new Array (
													);//text inputs
						break;*/
	case 'shipyard':target = 'shipyardVbox'; //panel or panel's vbox
						param1 = new Array (	'unifoxMaxButton',
													'displayGbox'
													);//elements to add
						param2 = new Array ('unifoxImgSize'
													);//text inputs							
						break;
   case 'fleet':target = 'fleetVbox'; //panel or panel's vbox
						param1 = new Array ('unifoxCoordCopy',
													'unifoxFleetTime',
													'unifoxFleetReturnTime',
													'timersIntervalBox',
													'unifoxTransportsNeeded',
													'missionPreferenceGbox',
													'freightOrderBox'
													);//elements to add
						param2 = new Array ('unifoxTimersInterval'
													);//text inputs							
						break;
	case 'simu':target = 'simuVbox'; //panel or panel's vbox
						param1 = new Array (	'unifoxRECopy',
													'unifoxSimulator',
													'unifoxLastFleets'
													);//elements to add
						param2 = new Array (
													);//text inputs							
						break;
	case 'conv':target = 'convVbox'; //panel or panel's vbox
						param1 = new Array (	'converterGbox'
													);//elements to add
						param2 = new Array ("ufConverterQuantity"
													);//text inputs							
						break;
	/*case 'others':var atemp=
						target = 'othersVbox'; //panel or panel's vbox
						param1 = new Array (
													'selectUniverseGbox'
													);//elements to add
						param2 = new Array ('ufLogin',
													'ufPassword'
													);//text inputs		
																
						param1=new Array();
						param2=new Array();
						break;*/


	default:
			break;
	}
if(target && param1 && param2)
uf_appendElementsInPanel(target,param1,param2);
//alert('appended '+panel);
}
catch(e)
{
ufOptionsDebug(e);
}
}

//*********************************
function ufGetUfPrefnames()
{
	return {};
}
function ufExportOptions()
{
	var options = {};
}

function ufImportOptions()
{
	var optionsTextbox = document.getElementById('exportOptionsText');
	var optionsText = optionsTextbox.value;
	var options = eval(optionsText);
	if(options.bools) {
		ufLog("loading booleans");
	}
	if(options.ints) {
		ufLog("loading int");
	}
	if(options.texts) {
		ufLog("loading texts");
	}
}
//*********************************
function uf_openCRcolors() {
	window.openDialog('chrome://unifox/content/CRcolors.xul','CRcolors','centerscreen,chrome');
}
