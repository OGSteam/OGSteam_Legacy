// sélectionne (et pour IE, copie) le rapport formaté
function copier(obj) {
	// on selectionne tout
	obj.select();

	// la copie dans le presse-papiers fonctionne uniquement avec IE
	var textRange = document.body.createTextRange();
	textRange.moveToElementText(obj);
	textRange.execCommand("Copy");
	if (textRange) {
		document.restyler.copie.value = "Copier dans le presse-papiers";
		document.restyler.copie.title = "Copier dans le presse-papiers";
	}
}

// efface le RE brut
function effacer(){
	document.restyler.spyreport.value = "";
}

// fonction de preview du rapport formaté en BBCode
// code repris de l'aperçu de Takana RC Converter, avec leur aimable autorisation.
function preview() {
	var str = document.restyler.result.value;
	if (!str)
		return;

	// si pas rendu HTML (num 4 dans la liste), on fait l'aperçu
	if (document.restyler.choixforum.options.selectedIndex != 4) {
		str = str.replace(/[[]/gi,"<");
		while (str.match("]")) {
			str = str.replace("]",">");
		}
		while (str.match("\n")) {
			str = str.replace("\n","<br>");
		}
		while (str.match("<br><")) {
			str = str.replace("<br><","<br>\n<");
		}
		while (str.match("</color>")) {
			str = str.replace("</color>","</font>");
		}
		while (str.match("<color")) {
			str = str.replace("<color","<font color");
		}
		while (str.match("<size=16>")) {
			str = str.replace("<size=16>","<span style=\"font-size: 16px;\"> ");
		}
		while (str.match("<size=14>")) {
			str = str.replace("<size=14>","<span style=\"font-size: 14px;\"> ");
		}
		while (str.match("<size=9>")) {
			str = str.replace("<size=9>","<span style=\"font-size: 9px;\"> ");
		}
		while (str.match("</size>")) {
			str = str.replace("</size>","</span>");
		}
		while (str.match("<center>")) {
			str = str.replace("<center>","<div style=\"text-align: center;\">");
		}
		while (str.match("</center>")) {
			str = str.replace("</center>","</div>");
		}
		while (str.match("<url=")) {
			str = str.replace("<url=","<a href=");
		}
		while (str.match("</url>")) {
			str = str.replace("</url>","</a>");
		}
		while (str.match("quote>")) {
			str = str.replace("quote>","fieldset>");
		}
		str +="<br>"
	}
	var obj = document.getElementById("preview");
	obj.innerHTML = str;

	document.getElementById("preview").style.visibility = "visible";
	document.getElementById("message").style.visibility = "visible";
}

// ferme la preview
function closeMessage() {
	document.getElementById("message").style.visibility = "hidden";
	document.getElementById("preview").style.visibility = "hidden";
	document.getElementById("montrerREtest").style.visibility = "hidden";
}

// montre le RE de test
function showREtest() {
	document.getElementById("montrerREtest").style.visibility = "visible";
}

// mise à zéro des seuils
function seuilAZero() {
	document.restyler.seuilressources.value = "0";
	document.restyler.seuilflotte.value = "0";
	document.restyler.seuildefense.value = "0";
	document.restyler.seuilbatiments.value = "0";
	document.restyler.seuilrecherche.value = "0";
}

// restaure les couleurs d'origine
function couleurParDefaut() {
// ce doit être les mêmes que celles définies dans 'constants.php'
	document.restyler.couleurressources.value = "#33FF33";
	document.restyler.couleurflotte.value = "#FF00FF";
	document.restyler.couleurdefense.value = "#FF00FF";
	document.restyler.couleurbatiments.value = "#FF3333";
	document.restyler.couleurrecherche.value = "#FF3333";
	document.restyler.couleurdefaut.value = "#FF9933";
	document.restyler.couleurtitre.value = "#0099FF";
	document.restyler.couleurplanete.value = "#0099FF";
}

//<!-- The JavaScript Source!! http://javascript.internet.com -->
//<!-- Original: Nick Baker -->
// It works on text fields and dropdowns in IE 5+
// It only works on text fields in Netscape 4.5

// Set the cookie.
// SetCookie('your_cookie_name', 'your_cookie_value', exp);

// Get the cookie.
// var someVariable = GetCookie('your_cookie_name');

var expDays = 150;
var exp = new Date(); 
exp.setTime(exp.getTime() + (expDays*24*3600*1000));

function getCookieVal (offset) { 
	var endstr = document.cookie.indexOf (";", offset); 
	if (endstr == -1) { endstr = document.cookie.length; }
	return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie (name) {
	var arg = name + "=";
	var alen = arg.length; 
	var clen = document.cookie.length; 
	var i = 0; 
	while (i < clen) { 
		var j = i + alen; 
		if (document.cookie.substring(i, j) == arg) return getCookieVal (j); 
		i = document.cookie.indexOf(" ", i) + 1; 
		if (i == 0) break; 
	} 
	return null;
}

function SetCookie (name, value) { 
	var argv = SetCookie.arguments; 
	var argc = SetCookie.arguments.length; 
	var expires = (argc > 2) ? argv[2] : null; 
	var path = (argc > 3) ? argv[3] : null; 
	var domain = (argc > 4) ? argv[4] : null; 
	var secure = (argc > 5) ? argv[5] : false; 
	document.cookie = name + "=" + escape (value) + 
	((expires == null) ? "" : ("; expires=" + expires.toGMTString())) + 
	((path == null) ? "" : ("; path=" + path)) + 
	((domain == null) ? "" : ("; domain=" + domain)) + 
	((secure == true) ? "; secure" : "");
}

// cookieForms saves form content of a page.

// use the following code to call it:
// <body onLoad="cookieForms('open', 'form_1', 'form_2', 'form_n')" onUnLoad="cookieForms('save', 'form_1', 'form_2', 'form_n')">

function cookieForms() { 
	var mode = cookieForms.arguments[0];

	for(f=1; f<cookieForms.arguments.length; f++) {
		formName = cookieForms.arguments[f];

		if(mode == 'open') {
			cookieValue = GetCookie('options_'+formName);
			if(cookieValue != null) {
				var cookieArray = cookieValue.split('#cf#');

				if(cookieArray.length == document[formName].elements.length) {
					for(i=0; i<document[formName].elements.length; i++) {

						if(cookieArray[i].substring(0,6) == 'select') { document[formName].elements[i].options.selectedIndex = cookieArray[i].substring(7, cookieArray[i].length-1); }
						else if((cookieArray[i] == 'cbtrue') || (cookieArray[i] == 'rbtrue')) { document[formName].elements[i].checked = true; }
						else if((cookieArray[i] == 'cbfalse') || (cookieArray[i] == 'rbfalse')) { document[formName].elements[i].checked = false; }
						else if((cookieArray[i] == '')) {  }  // suppression des textarea, boutons, submit (tout ce qu'on n'a pas enregistré, et donc ce qui est vide)
						else { document[formName].elements[i].value = (cookieArray[i]) ? cookieArray[i] : ''; }
					}
				}
			}
		}

		if(mode == 'save') {	
			cookieValue = '';
			for(i=0; i<document[formName].elements.length; i++) {
				fieldType = document[formName].elements[i].type;

				if(fieldType == 'checkbox') { passValue = 'cb'+document[formName].elements[i].checked; }
				else if(fieldType == 'radio') { passValue = 'rb'+document[formName].elements[i].checked; }
				else if(fieldType == 'select-one') { passValue = 'select'+document[formName].elements[i].options.selectedIndex; }
 				else if(fieldType == 'text') { passValue = document[formName].elements[i].value; }
 				else { passValue = ''; }

				cookieValue = cookieValue + passValue + '#cf#';
			}
			cookieValue = cookieValue.substring(0, cookieValue.length-4); // Remove last delimiter

			SetCookie('options_'+formName, cookieValue, exp);		
		}	
	}
}
