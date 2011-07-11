// ==UserScript==
// @name           Xtense 2.4
// @namespace      Xtense
// @include        http://*.ogame.*/game/index.php*
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


	if ((url.indexOf('xtense=Options',0))>=0){
	//alert("options");
	var aff = '<table id="IFC_table" style="width:675px;"><tr><th class="IFC_th" style="font-size: 12px; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;">Options Xtense:</th></tr></table>';
	aff+=	'<center><table width="657px" id="IFC_mid">';
	aff+= '<div class="fieldwrapper"><label class="styled textBeefy">URL OGSpy:</label>';
	aff+= '<div class="thefield"><input class="speed" value="http://votreogspy/mod/xtense/xtense.php" size="35" alt="24" type="text"></div></div>';
	aff+= '<div class="fieldwrapper"><label class="styled textBeefy">User:</label>';
	aff+= '<div class="thefield"><input value="Username" size="35" alt="24" type="text"></div></div>';
	aff+= '<div class="fieldwrapper"><label class="styled textBeefy">Password:</label>';
	aff+= '<div class="thefield"><input value="password" size="35" alt="24" type="text"></div></div>';
	aff+= '<table id="IFC_down" style="clear: right;" width="663px" height="22px"></table></table><br/>'; //fin Tableau
	
	var einhalt=document.getElementById('inhalt');
	var escriptopt=document.createElement('div');
	escriptopt.id='xtenseScriptOpt';
	escriptopt.innerHTML=aff;
	escriptopt.style.cssFloat='left';
	escriptopt.style.position='relative';
	escriptopt.style.width='670px';
	einhalt.style.display='none';
	einhalt.parentNode.insertBefore(escriptopt,einhalt);
	}



	//Filtre par Page affichée



	if ((url.indexOf('page=research',0))>=0) 
	{ 	
		
	}else if((url.indexOf('page=overview',0))>=0){

	var planet_name = document.getElementById("planetNameHeader").innerHTML;
	planet_name = planet_name.replace( / /g, "")

	}
}
