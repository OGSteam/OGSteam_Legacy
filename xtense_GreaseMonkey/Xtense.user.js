// ==UserScript==
// @name		Xtense
// @version     2.4.0
// @namespace	xtense.ogsteam.fr
// @include     http://*.ogame.*/game/index.php*
// @description Permet d'envoyer des données à votre serveur OGSPY
// @require		http://svn.ogsteam.fr/trunk/xtense/chrome/content/Servers.js
// ==/UserScript==

var url=location.href;// Adresse en cours sur la barre d'outils


// Menu Options

if (document.getElementById('playerName'))
{
	var icone = 'data:image/gif;base64,R0lGODlhJgAdAMZ8AAAAABwgJTU4OhwhJRYaHjQ3OQcICjM2OA8SFQoMDxsgJB0hJjI1Nw8TFQcICAQEBDE0NgwPEAECAiYoKREVGB8lKi4yNCMlJgoNDzAzNiMnKzE0NxATFgsNECwuMAEBASotMB4iJyImKg8SFg4PDw8QESEjJQICAiAkKRgZGhsdHhUWFwoLCwoMDjI2OBcbHxsgIw0PEhsfIx8jJywvMh8hIhobHB8kKQkMDQYICQoNECwwMxcZGQsOER0iJygrLxweHysuMSUoLAkLDiQnKwwPESElKTM2NyAiIwcKCyAjJxoeISIlKiIkJRIWGRQWFiosLSUnKDAzNBscHRoeIgMEBDAyNA4ODyAkKAcICQkKCwwQEiMnKhwgJBIVGRAQEScqLiosLgcJCgcJCzQ2OAQEBQgICAkJCiksMCQmJwYHCSAjKC0vMQYGBh4jJyUpLSksLRAUFygsLzM2OSsuLyotMQwNDTAzNS4xMiwvMAkJDAkLDf///////////////yH5BAEAAH8ALAAAAAAmAB0AAAf+gH+CFQOFhoeIiRWCjI2ON4cBkpKIlIgVMI6af4SFk5+gk5UwBJuNBIahqqs+paaCBKuyoG4BA66vBFSgAr2+k74CnwoBuKaxkz7AvZ9rAcyTCgrGm8iq0Mug0tSa1qG/ktiTXbevsDKfC5/YwqvcjgTosszt7uZ/BN7f4Kov741i8gkcKLAXwYNZ7gFYyLAhQ18OIyqM6DCYAIoMJ2JceBFAr40ANGLs6PEjRpERTXJUyVBCSHMbWa48CZOizJUkG6IsGaxhT4k1I7oESXHnwqFEHd7LAUBN0qT3huDYI3VMEgNYs27EmkOLnnt/tsQoUqRHh7MY0iZY24KtDh0gAHpEmAtWkBMvceJw2NsAQV+/IwALpkChruHDiBPXDQQAOw==';
			
	var aff_option ='<li><span class="menu_icon"><a href="http://board.ogsteam.fr" target="blank_" ><img class="mouseSwitch" src="'+icone+'" height="29" width="38"></span><a class="menubutton " href="'+url+'&xtense=Options" accesskey="" target="_self">';
		aff_option += '<span class="textlabel">Xtense</span></a></li>';
				
				
	var sp1 = document.createElement("span");
	sp1.setAttribute("id", "optionIFC");
	var sp1_content = document.createTextNode('');
	sp1.appendChild(sp1_content);				
	
	var sp2 = document.getElementById('menuTable').getElementsByTagName('li')[Math.min(10,document.getElementById('menuTable').getElementsByTagName('li').length-1)];
			
	parentDiv = sp2.parentNode;
	parentDiv.insertBefore(sp1, sp2.nextSibling);
	var tableau = document.createElement("span");
	tableau.innerHTML = aff_option;
	document.getElementById('optionIFC').insertBefore(tableau, document.getElementById('optionIFC').firstChild);
}

	var reg = new RegExp(/(preferences|fleet2|fleet3|network|=messages|trader|premium|alliance)/);

if((! reg.test(url)) || (new RegExp(/xtense=Options/)).test(url)){
	var nomScript = 'Xtense';

	if(!GM_getValue){
		function GM_getValue(key,defaultVal){
			var retValue = localStorage.getItem(key);
			if ( !retValue ){
				return defaultVal;
			}
			return retValue;
		}

		function GM_setValue(key,value){
			localStorage.setItem(key, value);
		}
		
		function GM_deleteValue(value){
            localStorage.removeItem(value);
        }
	}
	/*var XtenseOptions = {
			servers : {
					server1ids : {
						url_plugin : "Serveur n�1",
						utilisateur : ""
					}
			}
	}*/
	
	if(url.indexOf('xtense=Options',0) >= 0){
		var options = '<table id="Xtense_table" style="width:675px;">';
		options += '<colgroup><col width="30%"/><col/></colgroup>';
		options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"><img src="http://svn.ogsteam.fr/trunk/xtense/chrome/skin/classic/images/logo.png" alt="Options Xtense" height="150%"/></th></tr></thead>';
		options+= '<tbody>';
		// Serveur 1
		options+= '<tr>';
		options+= '<td class="champ"><label class="styled textBeefy">URL Univers</label></td>';
		options+= '<td class="value"><input class="speed" id="server1.url.univers" value="'+GM_getValue(nomScript+'-server1.url.univers','http://uniXXX.ogame.fr')+'" size="35" alt="24" type="text"/></td>';
		options+= '</tr>';
		options+= '<tr>';
		options+= '<td class="champ"><label class="styled textBeefy">URL OGSpy</label></td>';
		options+= '<td class="value"><input class="speed" id="server1.url.plugin" value="'+GM_getValue(nomScript+'-server1.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
		options+= '</tr>';
		options+= '<tr>';
		options+= '<td class="champ"><label class="styled textBeefy">Utilisateur</label></td>';
		options+= '<td class="value"><input class="speed" id="server1.user" value="'+GM_getValue(nomScript+'-server1.user','utilisateur')+'" size="35" alt="24" type="text"/></td>';
		options+= '</tr>';
		options+= '<tr>';
		options+= '<td class="champ"><label class="styled textBeefy">Mot de passe</label></td>';
		options+= '<td class="value"><input class="speed" type="password" id="server1.pwd" value="'+GM_getValue(nomScript+'-server1.pwd','mot de passe')+'" size="35" alt="24" type="text"/></td>';
		options+= '</tr>';		
		options+= '</tbody></table>'; //fin Tableau
		
		var einhalt=document.getElementById('inhalt');
		var escriptopt=document.createElement('div');
		escriptopt.id='xtenseScriptOpt';
		escriptopt.innerHTML=options;
		escriptopt.style.cssFloat='left';
		escriptopt.style.position='relative';
		escriptopt.style.width='670px';
		einhalt.style.display='none';
		einhalt.parentNode.insertBefore(escriptopt,einhalt);

		function enregistreOptionsXtense(){

			var Xpath = {//node est facultatif
				getNumberValue : function (doc,xpath,node) {
					node = node ? node : doc;
					return doc.evaluate(xpath,node,null,XPathResult.NUMBER_TYPE, null).numberValue;
				},
				getStringValue : function (doc,xpath,node) {
					node = node ? node : doc;
					return doc.evaluate(xpath,node,null,XPathResult.STRING_TYPE, null).stringValue;
				},
				getOrderedSnapshotNodes : function (doc,xpath,node) {
					node = node ? node : doc;
					return doc.evaluate(xpath,node,null,XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
				},
				getUnorderedSnapshotNodes : function (doc,xpath,node) {
					node = node ? node : doc;
					return doc.evaluate(xpath,node,null,XPathResult.UNORDERED_NODE_SNAPSHOT_TYPE, null);
				},	
				getSingleNode : function (doc,xpath,node) {
					node = node ? node : doc;
					return doc.evaluate(xpath,node,null,XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
				}
			}
			var inputOptions = Xpath.getOrderedSnapshotNodes(document, "//table[@id='Xtense_table']//input");
			if(inputOptions.snapshotLength > 0){
				//console.log("Xtense says : inputOptions.snapshotLength="+inputOptions.snapshotLength);
			   	for(var i=0;i<inputOptions.snapshotLength;i++){
			   		var input = inputOptions.snapshotItem(i);
			   		GM_setValue(nomScript+'-'+input.id , input.value);
			   	}
			}	
		}
		setInterval(enregistreOptionsXtense, 500);
	}
}

// converti un nombre de la forme xxx.xxx.xxx en xxxxxxxxx
function parseNB(monText){
  return (monText.replace(/\./g,""));  
}