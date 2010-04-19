
// Get the "extensions.gtplugin." branch
/*
window.addEventListener("load", function() { myExtension.init(); }, false);

var myExtension = {
    init: function() {
        GTPlugin_setTextfields();
    },

    onPageLoad: function(aEvent) {
    }
}
*/
function GTPlugin_initWindow() {
    GTPlugin_setTextfields();
}

function GTPlugin_setTextfields() {
    var prefs = GTPlugin_getPrefs();
    // usernames
    if(prefs.prefHasUserValue("gtplugin.settings.username1")) {
        username = prefs.getCharPref("gtplugin.settings.username1");
        document.getElementById("GTPlugin-username1").value = username;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.username2")) {
        username = prefs.getCharPref("gtplugin.settings.username2");
        document.getElementById("GTPlugin-username2").value = username;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.username3")) {
        username = prefs.getCharPref("gtplugin.settings.username3");
        document.getElementById("GTPlugin-username3").value = username;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.username4")) {
        username = prefs.getCharPref("gtplugin.settings.username4");
        document.getElementById("GTPlugin-username4").value = username;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.username5")) {
        username = prefs.getCharPref("gtplugin.settings.username5");
        document.getElementById("GTPlugin-username5").value = username;
    }
    
    // passwords
    if(prefs.prefHasUserValue("gtplugin.settings.password1")) {
        password = prefs.getCharPref("gtplugin.settings.password1");
        document.getElementById("GTPlugin-password1").value = password;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.password2")) {
        password = prefs.getCharPref("gtplugin.settings.password2");
        document.getElementById("GTPlugin-password2").value = password;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.password3")) {
        password = prefs.getCharPref("gtplugin.settings.password3");
        document.getElementById("GTPlugin-password3").value = password;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.password4")) {
        password = prefs.getCharPref("gtplugin.settings.password4");
        document.getElementById("GTPlugin-password4").value = password;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.password5")) {
        password = prefs.getCharPref("gtplugin.settings.password5");
        document.getElementById("GTPlugin-password5").value = password;
    }
    
    // tool urls
    if(prefs.prefHasUserValue("gtplugin.settings.url1")) {
        url = prefs.getCharPref("gtplugin.settings.url1");
        document.getElementById("GTPlugin-url1").value = url;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.url2")) {
        url = prefs.getCharPref("gtplugin.settings.url2");
        document.getElementById("GTPlugin-url2").value = url;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.url3")) {
        url = prefs.getCharPref("gtplugin.settings.url3");
        document.getElementById("GTPlugin-url3").value = url;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.url4")) {
        url = prefs.getCharPref("gtplugin.settings.url4");
        document.getElementById("GTPlugin-url4").value = url;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.url5")) {
        url = prefs.getCharPref("gtplugin.settings.url5");
        document.getElementById("GTPlugin-url5").value = url;
    }
    
    // ogame urls
    if(prefs.prefHasUserValue("gtplugin.settings.ogameurl1")) {
        url = prefs.getCharPref("gtplugin.settings.ogameurl1");
        document.getElementById("GTPlugin-ogameurl1").value = url;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.ogameurl2")) {
        url = prefs.getCharPref("gtplugin.settings.ogameurl2");
        document.getElementById("GTPlugin-ogameurl2").value = url;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.ogameurl3")) {
        url = prefs.getCharPref("gtplugin.settings.ogameurl3");
        document.getElementById("GTPlugin-ogameurl3").value = url;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.ogameurl4")) {
        url = prefs.getCharPref("gtplugin.settings.ogameurl4");
        document.getElementById("GTPlugin-ogameurl4").value = url;
    }
    if(prefs.prefHasUserValue("gtplugin.settings.ogameurl5")) {
        url = prefs.getCharPref("gtplugin.settings.ogameurl5");
        document.getElementById("GTPlugin-ogameurl5").value = url;
    }

    // automatic start
    if(prefs.prefHasUserValue("gtplugin.settings.autostarten")) {
        autostart = prefs.getBoolPref("gtplugin.settings.autostarten");
        document.getElementById("GTPlugin-autostart").checked = autostart;
    }
}

function GTPlugin_getValue(elementID) {
    // Get a handle to our url textfield
    var textfield = document.getElementById(elementID);
    // Get the value, trimming whitespace as necessary
    var string = GTPlugin_TrimString(textfield.value);
    
    // If there is no url, we return ""
    // Otherwise, we convert the search terms to a safe URI version and return it
    if(string.length == 0) { return ""; }
    else { return encodeURIComponent(string); }
}

function GTPlugin_getPrefs() {
  return Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefBranch);
}

function GTPlugin_SaveValues() {
    var prefs = GTPlugin_getPrefs();
    // usernames
    prefs.setCharPref("gtplugin.settings.username1", GTPlugin_getValue("GTPlugin-username1")); // set a pref
    prefs.setCharPref("gtplugin.settings.username2", GTPlugin_getValue("GTPlugin-username2")); // set a pref
    prefs.setCharPref("gtplugin.settings.username3", GTPlugin_getValue("GTPlugin-username3")); // set a pref
    prefs.setCharPref("gtplugin.settings.username4", GTPlugin_getValue("GTPlugin-username4")); // set a pref
    prefs.setCharPref("gtplugin.settings.username5", GTPlugin_getValue("GTPlugin-username5")); // set a pref
    // passwords
    prefs.setCharPref("gtplugin.settings.password1", GTPlugin_getValue("GTPlugin-password1")); // set a pref
    prefs.setCharPref("gtplugin.settings.password2", GTPlugin_getValue("GTPlugin-password2")); // set a pref
    prefs.setCharPref("gtplugin.settings.password3", GTPlugin_getValue("GTPlugin-password3")); // set a pref
    prefs.setCharPref("gtplugin.settings.password4", GTPlugin_getValue("GTPlugin-password4")); // set a pref
    prefs.setCharPref("gtplugin.settings.password5", GTPlugin_getValue("GTPlugin-password5")); // set a pref
    // tool urls
    prefs.setCharPref("gtplugin.settings.url1", decodeURIComponent(GTPlugin_getValue("GTPlugin-url1"))); // set a pref
    prefs.setCharPref("gtplugin.settings.url2", decodeURIComponent(GTPlugin_getValue("GTPlugin-url2"))); // set a pref
    prefs.setCharPref("gtplugin.settings.url3", decodeURIComponent(GTPlugin_getValue("GTPlugin-url3"))); // set a pref
    prefs.setCharPref("gtplugin.settings.url4", decodeURIComponent(GTPlugin_getValue("GTPlugin-url4"))); // set a pref
    prefs.setCharPref("gtplugin.settings.url5", decodeURIComponent(GTPlugin_getValue("GTPlugin-url5"))); // set a pref
    // ogame urls
    prefs.setCharPref("gtplugin.settings.ogameurl1", decodeURIComponent(GTPlugin_getValue("GTPlugin-ogameurl1"))); // set a pref
    prefs.setCharPref("gtplugin.settings.ogameurl2", decodeURIComponent(GTPlugin_getValue("GTPlugin-ogameurl2"))); // set a pref
    prefs.setCharPref("gtplugin.settings.ogameurl3", decodeURIComponent(GTPlugin_getValue("GTPlugin-ogameurl3"))); // set a pref
    prefs.setCharPref("gtplugin.settings.ogameurl4", decodeURIComponent(GTPlugin_getValue("GTPlugin-ogameurl4"))); // set a pref
    prefs.setCharPref("gtplugin.settings.ogameurl5", decodeURIComponent(GTPlugin_getValue("GTPlugin-ogameurl5"))); // set a pref
    
    prefs.setBoolPref("gtplugin.settings.autostarten", document.getElementById("GTPlugin-autostart").checked); // set a pref

    window.close();
}

function GTPlugin_Cancel() {
    window.close(); 
}


function GTPlugin_TrimString(string) {
    // Return empty if nothing was passed in
    if (!string) return "";

    // Efficiently replace any leading or trailing whitespace
    var value = string.replace(/^\s+/, '');
    value = string.replace(/\s+$/, '');

    // Replace any multiple whitespace characters with a single space
    value = value.replace(/\s+/g, ' ');

    // Return the altered string
    return value;
}

