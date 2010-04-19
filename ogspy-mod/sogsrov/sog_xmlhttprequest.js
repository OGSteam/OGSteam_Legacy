var xhr = null;
/**
* Fonction de cr�ation d'un objet xmlHTTPRequest
*/   
function getXhr() {
   if (window.XMLHttpRequest) // Firefox et autres
      xhr = new XMLHttpRequest();
   else if (window.ActiveXObject) { // Internet Explorer
      try {
         xhr = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
         xhr = new ActiveXObject("Microsoft.XMLHTTP");
      }
   }
   else { // XMLHttpRequest non support� par le navigateur
      alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest.");
      xhr = false;
   }
}
/**
* M�thode qui sera appel�e pour mettre � jour chaque champ
*/
function update_conf(page, param){
   getXhr();
   // On d�fini ce qu'on va faire quand on aura la r�ponse
   xhr.onreadystatechange = function() {
      // On ne fait quelque chose que si on a tout re�u
      // et que le serveur est ok
      if (xhr.readyState == 4 && xhr.status == 200) {
         var response = xhr.responseText;
         document.getElementById(param).value = response;
         document.getElementById("response").innerHTML = response;
      }
   }
   var elementObj = document.getElementById(param);
   var elemNodeName = elementObj.nodeName.toLowerCase();
   if (elemNodeName == "select") {
      var value = elementObj.options[elementObj.selectedIndex].value;
   }
   else {
      var value = elementObj.value;
   }
   var url = "mod/sogsrov/sog_rpc.php?page=" + page + "&" + param + "=" + value;
   // Ici on va voir comment faire du post
   xhr.open("GET", url, true);
   xhr.send(null);
}