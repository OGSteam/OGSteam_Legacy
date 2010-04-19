/*
param = 0 => Tout déselectionner
param = 1 => Tout sélectionner
param = 2 => Inverser la sélection
*/
function check(param) {
   var blnEtat=null;
   var Chckbox = document.getElementById('div_chck').firstChild;
   
   while (Chckbox != null) {
		if (Chckbox.nodeName.toLowerCase() == "input")
			if (Chckbox.getAttribute("type") == "checkbox") {
            switch(param) {
               case "0" :
                  blnEtat = false;
                  break;
               case "1" :
                  blnEtat = true;
                  break;
               case "2" :
                  blnEtat = !document.getElementById(Chckbox.getAttribute("id")).checked;
                  break;
            }
				document.getElementById(Chckbox.getAttribute("id")).checked = blnEtat;
			}
		Chckbox = Chckbox.nextSibling;
	}
   update_users();
}

function update_users() {
   var Chckbox = document.getElementById('div_chck').firstChild;
   var users = "";
   
   while (Chckbox != null) {
		if (Chckbox.nodeName.toLowerCase() == "input")
			if (Chckbox.getAttribute("type") == "checkbox") {
            blnEtat = document.getElementById(Chckbox.getAttribute("id")).checked;
				if (blnEtat == true) users = users + Chckbox.getAttribute("id") + "<||>";
			}
		Chckbox = Chckbox.nextSibling;
	}
   if (users.length > 4) users = users.substr(0, users.length - 4);
   if (!document.getElementById('users')) {
      var inp = document.createElement("input");
      inp.setAttribute("type", "hidden");
      inp.setAttribute("id", "users");
      inp.setAttribute("value", users);
      document.getElementById('div_chck').appendChild(inp);
   }
   else {
      document.getElementById('users').value = users;
   }
   update_conf('admin', 'users');
}