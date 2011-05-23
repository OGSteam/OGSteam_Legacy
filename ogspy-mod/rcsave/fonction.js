/***************************************************************************
*	filename	: fonction.js
*	Author	: ben.12
*         Mod OGSpy: RC Save
***************************************************************************/

function del_script (formulaire) {
	rc_source = formulaire.RC_sources.value;
	reg = new RegExp("<link[^>]*?>\\s*","gi");
	rc_source = rc_source.replace(reg, "");
	if(navigator.appName.toLowerCase() == "netscape") {
        reg = new RegExp("<script[^>]*?>(.*?[\\n\\r]{0,2})*?<\/script>\\s*","gi");
        reg2 = new RegExp("<div\\s+id=['\"]overDiv['\"]\\s+style=[^>]*?>(.*?[\\n\\r]{0,2})*?<\/div>\\s*","gi");
    } else {
        reg = new RegExp("<script[^>]*?>(.*?[\\n\\r]{0,2})*<\/script>\\s*","gi");
        reg2 = new RegExp("<div\\s+id=['\"]overDiv['\"]\\s+style=[^>]*?>(.*?[\\n\\r]{0,2})*<\/div>\\s*","gi");
    }
    rc_source = rc_source.replace(reg, "");
    rc_source = rc_source.replace(reg2, "");
	formulaire.RC_sources.value = rc_source;
}
	
function validate_suppression(id) {
	if(confirm("Voulez-vous vraiment supprimer ce RC ?")) {
		window.location = "index.php?action=rc_save&delete=" + id;
	}
}
	
function publier(id) {
	if(document.getElementById(id+"_checkbox").checked) {
		window.location = "index.php?action=rc_save&publier=" + id;
	} else {
		window.location = "index.php?action=rc_save&de_publier=" + id;
	}
}