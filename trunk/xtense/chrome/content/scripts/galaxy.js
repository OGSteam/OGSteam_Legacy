
// Fix popup des alliances
function fix_ally_popups() {
	
	var onmouseovers = Xpath.getOrderedSnapshotNodes(Xogame.doc,Xogame.Xpaths.galaxy_ally_onmouseover);	
	if (onmouseovers.snapshotLength > 0){
    	for(var i=0;i<onmouseovers.snapshotLength;i++){
    		var onmouseover = onmouseovers.snapshotItem(i);
    		var txt = onmouseover.textContent;
    		
    		var head = txt.split("\(\'")[0]+"('";
    		var pied = "',"+txt.split("\(\'")[1].split("\'\,")[1];
    		
    		var reg=new RegExp("[\']", "g");
    		onmouseover.textContent = head+txt.split("\(\'")[1].split("\'\,")[0].replace(reg,"&apos;")+pied;
    	}
    }
    
	/*function ally_popup () {
		return overlib(this.$tmp, STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETY, -50 );
	}
	
	

	var rows = document.getElementsByTagName('table')[4].getElementsByTagName('tr');
	var foxgame = (rows[2].childNodes.length == 17 ? false : true);
	var col = (foxgame ? 0 : 1);
	var ally_strings = [];
	
	for (var i = 2; i < 17; i++) {
		var th = rows[i].getElementsByTagName('th');
		if (th[col+5].childNodes.length == 1) continue;
		
		var link = th[col+5].childNodes[1];
		link.$tmp = link.getAttribute('onmouseover').match(new RegExp('<table width=240 >.*</table></th></table>', 'g'))[0];
		link.onmouseover = function(){};
		link.addEventListener('mouseover', ally_popup, false);
	}*/
}

// Ajout du lien ver OGSPY
/** @author : Jedinight */
function addLinkToGalaxy(doc,paths,galaxy,system) {
	var contants = XnewOgame.contants.galaxy_link;
	
	// Creation du lien
	var a = document.createElement('a');
	a.setAttribute('style', contants.a_style);
	a.textContent = contants.a_libelle.formatPatern(0,galaxy).formatPatern(1,system);
	
	// Mise en place de l'ecoute au click
	var func = function(){ Xtoolbar.ogspyConnectGalaxy(XnewOgame.universe,galaxy,system); };
	a.addEventListener("click", func, false);
	
	// Creation du conteneur
	var tr = document.createElement('tr');			
	var td = document.createElement('td');
	td.setAttribute('colspan', contants.td_colspan);
	td.setAttribute('style', contants.td_style);
	
	td.appendChild(a);		
	tr.appendChild(td);
	
	// Insertion du lien
	var conteneur = Xpath.getSingleNode(doc,paths.table_galaxy);	
	var before = Xpath.getSingleNode(doc,paths.table_galaxy_header);
	conteneur.insertBefore(tr,before);
}