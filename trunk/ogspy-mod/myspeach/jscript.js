/*--------------------------------/////////////////////// ecriture des cookies ////////////////////////------------------------------------------*/
<!--
function MY_MS_EcrireCookie(myms_nom, myms_valeur, myms_expires, myms_path)
{
var myms_argv=MY_MS_EcrireCookie.arguments;
var myms_argc=MY_MS_EcrireCookie.arguments.length;
var myms_expires=(myms_argc > 2) ? myms_argv[2] : null;
var myms_path=(myms_argc > 3) ? myms_argv[3] : null;
var myms_domain=(myms_argc > 4) ? myms_argv[4] : null;
var myms_secure=(myms_argc > 5) ? myms_argv[5] : false;
document.cookie=myms_nom+"="+escape(myms_valeur)+
((myms_expires==null) ? "" : ("; expires="+myms_expires.toGMTString()))+
((myms_path==null) ? "" : ("; path="+myms_path))+
((myms_domain==null) ? "" : ("; domain="+myms_domain))+
((myms_secure==true) ? "; secure" : "");
}
//-->

/*--------------------------//////////////////////////////// raccourcis clavier ////////////////////////////////////---------------------------------*/

  var myms_tem_touch=false; // temoin d'utilisation des touches clavier
  var myms_alt=false; // temoin d'utilisation de la touche Alt
function MY_MS_key(pEvent){
  myms_tem_touch=true;
  var pEvent=pEvent;
	if((pEvent.keyCode == 13)&&(myms_a_fait==true)){
		MY_MS_request(my_ms_myroot + "/ki.php?dit=" + document.myspeach.MSpseudo.value,'non');
		myms_tem_touch=false;
		MY_MS_checkForm();
	}

	if(pEvent.keyCode==18){ myms_alt=true;   } // Ctrl

	if(myms_alt==true){
			myms_tem_touch=false;

		switch(pEvent.keyCode){

		case 83 : // s => smileys
			MY_MS_request(my_ms_myroot + '/smile.php?sm=ok&chm=' + my_ms_myroot ,'pop');
			MY_MS_popTitle('Smileys');
			MY_MS_ouvre('popupAddressbook');
			myms_alt=false;
		break;
		case 72 : // h => historique
			MY_MS_request(my_ms_myroot + '/admin/histo.php?chm=' + my_ms_myroot ,'pop');
			MY_MS_popTitle('Archives');
			MY_MS_ouvre('popupAddressbook');
			myms_alt=false;
		break;
		case 80 : // p => palette de couleurs
			MY_MS_request(my_ms_myroot + '/palette.php?chm=' + my_ms_myroot + '&skin=' + my_ms_myskin,'pop');
			MY_MS_popTitle('Autres couleurs');
			MY_MS_ouvre('popupAddressbook');
			myms_alt=false;
		break;
		case 112 : // f1 => myspeach.com
			document.location.href="http://www.myspeach.com";
			myms_alt=false;
		break;
		case 71 : // g => graphiks.net
			document.location.href="http://www.graphiks.net";
			myms_alt=false;
		break;
		case 68 : // d => active/desactive ding
			MY_MS_cloche_droit();
			myms_alt=false;
		break;
		case 66 : // b => bloque le bleu
			MY_MS_block_clr('#0000FF');
			myms_alt=false;
		break;
		case 82 : // r => bloque le rouge
			MY_MS_block_clr('#FF0000');
			myms_alt=false;
		break;
		case 86 : // v => bloque le vert
			MY_MS_block_clr('#00FF00');
			myms_alt=false;
		break;
		default: myms_alt=pEvent.keyCode==18 ? true : false; // libÃšre la function si la 2eme touche n'est pas un raccourci.
		break;
		}

	}
}


/*--------------------------------------//////////////////////// couleur et mise en forme ///////////////////////-------------------------------------*/

/* traitement des icones */
function MY_MS_emoticon(text) {
	text = ' ' + text + ' ';
	MY_MS_traitement(text);
	MY_MS_ferme('popupAddressbook');
}
//traitement du texte et des couleurs
  var myms_tag=""; // tag peut prendre les valeur "#hexa" ou  "b" "i" "s" etc .... ou "zzz" quand chekform ferme les balises ouvertes
  var myms_cat=""; // cat peut prendre la valeur "txt" ou "col"
  var myms_tem=""; // tem permet de savoir si et quel bbcode est deja  ouvert et dans quel ordre "c" => color, "t" => txt
  var myms_memtxt=""; // memorise le dernier tag txt
  var myms_memcol=""; // memorise le dernier tag color
  var myms_etat_txt= false; // une balise txt est elle ouverte? false => non, true => oui
  var myms_etat_col= false; // une balise color est elle ouverte? false => non, true => oui
  var myms_fbal=""; // fermeture des bbcode en dehors du processus normal en cas de depacement de max caracteres
function MY_MS_bbcode(myms_tag,myms_cat){
  var myms_bal=""; // le bbcode qui s'affichera dans MSmessage
  var myms_ftxt="**";
  var myms_fcol="[]";
	if(myms_cat=="txt"){
		if(myms_memtxt!=""){document.getElementById('chr_' + myms_memtxt).style.border="outset #cccccc 2px";}
		if((myms_tag==myms_memtxt)||(myms_tag=="zzz")){
			myms_etat_txt=true;
		}else{
			myms_etat_txt=false;
		}
		if(myms_etat_txt==false){
		  myms_memtxt= myms_tag;
		  var myms_dtag= "*" + myms_tag + "*";
			switch(myms_tem){
				case "c" : myms_bal= myms_dtag;
				           myms_tem= "ct";
				break;
				case "ct": myms_bal= myms_ftxt + myms_dtag;
				break;
				case "t" : myms_bal= myms_ftxt + myms_dtag;
				break;
				case ""  : myms_bal= myms_dtag;
				           myms_tem= "t";
				break;
			}
		  document.getElementById('chr_' + myms_tag).style.border= "inset #cccccc 2px";
		  myms_etat_txt=true;
		}else{
		  myms_bal= myms_ftxt; // pas de depacement nb char on ferme normalement dans MSmessage
		  myms_fbal= myms_alertmax==true? myms_ftxt + myms_fbal : myms_fbal; //depassement nb char on ferme direct dans zyva()
		  myms_tem= myms_tem=="ct"? "c" : myms_tem ;
		  myms_tem= myms_tem=="t"? "" : myms_tem ;
		  myms_etat_txt= false;
		  myms_memtxt="";
		}
	}else{
		if(myms_memcol!=""){document.getElementById('pal').style.background= "transparent";}
		if((myms_tag==myms_memcol)||(myms_tag=="zzz")){
			myms_etat_col=true;
		}else{
			myms_etat_col=false;
		}
		if(myms_etat_col==false){
		  myms_memcol= myms_tag;
		  var myms_dtag="[" + myms_tag + "]";
			switch(myms_tem){
				case "c" : myms_bal= myms_fcol + myms_dtag;
				break;
				case "ct": myms_bal= myms_ftxt + myms_fcol + myms_dtag + "*" + myms_memtxt + "*";
					   myms_tem= "ct";
				break;
				case "t" : myms_bal= myms_ftxt + myms_dtag + "*" + myms_memtxt + "*";
					   myms_tem= "ct";
				break;
				case ""  : myms_bal= myms_dtag;
					   myms_tem= "c";
				break;
			}
		  document.getElementById('pal').style.background= myms_tag;
		  myms_etat_col=true;
		}else{
		  myms_bal= myms_fcol; // pas de depacement nb char on ferme normalement dans MSmessage
		  myms_fbal= myms_alertmax==true? myms_fcol + myms_fbal : myms_fbal; //depassement nb char on ferme direct dans zyva()
		  myms_tem=myms_tem=="ct"? "t" : myms_tem ;
		  myms_tem=myms_tem=="c"? "" : myms_tem ;
		  myms_etat_col=false;
		}
	}
MY_MS_traitement(myms_bal);
}

/* blocage d'une couleur */
var myms_bloclr=false;
var myms_deb_clr='';
var myms_fin_clr='';
function MY_MS_block_clr(myms_clr){
	//myms_a_fait=true;
	myms_bloclr=myms_bloclr==false?true:false;
	myms_deb_clr='[' + myms_clr + '] ';
	myms_fin_clr=' []';
	document.myspeach.MSmessage.value=myms_bloclr==true?'':'';
	document.myspeach.MSmessage.style.border=myms_bloclr==true?'inset ' + myms_clr :'inset black';
	myms_tem=myms_bloclr==true?'c':'';
	//myms_setcol=myms_bloclr==true?true:false;
	myms_date=new Date;
	myms_date.setMonth(myms_date.getMonth()+1);
	MY_MS_EcrireCookie("MS_config_col", myms_clr, myms_date,"/");
}
/* ---------------//////////////////////finalisation du traitement des icones, couleurs, textes /////////////////////----------------- */
function MY_MS_traitement(val) {
	var txtarea = document.myspeach.MSmessage;
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.val = caretPos.val.charAt(caretPos.val.length - 1) == ' ' ? val + ' ' : val;
		txtarea.focus();
	} else {
		txtarea.value  += val;
		txtarea.focus();
	}

}
/*------------------------////////////////////////////////////// timer /////////////////////////////////////////-------------------------------*/

function MY_MS_timer() {
       setTimeout("MY_MS_timer()",1000);
	MY_MS_compter(document.myspeach.MSmessage.value);
	MY_MS_visualisation(); // temoin mise en forme des messages
//document.getElementById("debug").innerHTML="debug";
}
/*-----------------------///////////////////////////////// visualisation des messages ///////////////////////////////------------------------------*/

  var fin_txt=""; /*   variable qui faire d'avance la balise bbcode (visualisation */
  var fin_col=""; /* pareil mais pour les couleurs */
  var myms_texte="";
function  MY_MS_visualisation() {
	fin_txt=myms_etat_txt==true?" **":"";
	fin_col=myms_etat_col==true?" []":"";
	fin_col=myms_bloclr==true?"":fin_col;
  var myms_t=myms_deb_clr + document.myspeach.MSmessage.value + myms_fin_clr + fin_col + fin_txt;
	myms_t=MY_MS_code_to_html(myms_t);
	if (document.getElementById) document.getElementById("temoin").innerHTML=myms_t ;
}

/*--------------------/////////////////////// bbcode //////////////////////////-----------------------------*/

function MY_MS_code_to_html(myms_t) {
// balise Gras
	myms_t=MY_MS_deblaie(/(\*\*)/g,myms_t)
	myms_t=MY_MS_remplace_tag(/\*(b|u|i|s|big|small|sup)\*(.+)\*\*/g,'<$1>$2</$1>',myms_t)
	myms_t=MY_MS_remblaie(myms_t)

// balise Color hexa
	myms_t=MY_MS_deblaie(/(\[\])/g,myms_t)
	myms_t=MY_MS_remplace_tag(/\[(#[a-fA-F0-9]{6})\](.+)\[\]/g,'<font color="$1">$2</font>',myms_t)
	myms_t=MY_MS_remblaie(myms_t)
		return myms_t
}
function MY_MS_deblaie(reg,myms_t) {
	myms_texte=new String(myms_t);
	return myms_texte.replace(reg,'$1\n');
}
function MY_MS_remblaie(myms_t) {
	myms_texte=new String(myms_t);
	return myms_texte.replace(/\n/g,'');
}

function MY_MS_remplace_tag(reg,rep,myms_t) {
	myms_texte=new String(myms_t) ;
	return myms_texte.replace(reg,rep);
}

/*-------------------------------///////////////////////////////////// popup et menu droit ///////////////////////////////////------------------------------------*/

function MY_MS_ouvre(cadre){
	myms_layerStyle = document.getElementById('contextMenu').style;
	myms_layerStyle.visibility = 'hidden'; // quand on ouvre la popup on ferme le clic droit
var pospop = myms_mousePosY -300 ;
	if(pospop<=0) pospop=0;
	document.getElementById(cadre).style.top=pospop + "px";
	document.getElementById(cadre).style.display="block";
}


function MY_MS_ferme(cadre){
	document.getElementById(cadre).style.display="none";
	document.getElementById('pop').innerHTML = "Chargement de la page ..."; // on ferme, on remet le contenu initial
	document.myspeach.MSmessage.focus();
}

var myms_red=false;
function MY_MS_reduit(cadre){
	if(myms_red == true){
		document.getElementById(cadre).style.height= 350 + "px";
		document.getElementById('pop').style.display= "block";
		myms_red = false;
	}else{
		document.getElementById(cadre).style.height= 20 + "px";
		document.getElementById('pop').style.display= "none";
		myms_red = true;
	}
}

function MY_MS_popTitle(titre){
	if(document.getElementById('pop_titre')){
		document.getElementById('pop_titre').innerHTML = titre;
	}
}
   /**
    * Setup initial event handlers
    */
document.onmousemove = MY_MS_getMouseXY;
document.onmousedown = MY_MS_customContext;

    /**
    * Context menu handler
    */
    var myms_overContextMenu = "";
    var myms_layerStyle = "";
function MY_MS_customContext(f){
	if (f) event = f;
	myms_layerStyle = document.getElementById('contextMenu').style;

        if (event.button == 2 && myms_overContextMenu) {
		MY_MS_request( my_ms_myroot + "/chat_rqst.php?rqst=list&chm=" + my_ms_myroot,"list_ip");
		document.oncontextmenu =     function myms_za() { return false;}
		myms_layerStyle.left = myms_mousePosX + "px";
		myms_layerStyle.top = myms_mousePosY + "px";
		myms_layerStyle.visibility = 'visible';
        } else if (myms_overContextMenu){
		document.oncontextmenu =   function myms_az(){ return true;}
		myms_layerStyle.left = 0;
		myms_layerStyle.top = 0;
		myms_layerStyle.visibility = 'hidden';
	}
}

    /* Init some vars */

    var myms_mousePosX = 0;
    var myms_mousePosY = 0;

    var myms_posLayer=false;

    var myms_layer = '';

    var myms_origX = 0;
    var myms_origY = 0;

    var myms_origLayerX = 0;
    var myms_origLayerY = 0;

    var myms_diffX =0;
    var myms_diffY=0;

    /**
    * Sets mouseX and mouseY coords
    */
function MY_MS_getMouseXY(e) {
	myms_mousePosX = (navigator.appName.substring(0,3) == "Net") ? e.pageX : event.clientX;
	myms_mousePosY = (navigator.appName.substring(0,3) == "Net") ? e.pageY : event.clientY;
}

    /**
    * Layer drag functions
    *
    * MY_MS_startLayerDrag() - Initiates and sets up the drag
    * MY_MS_endLayerDrag()   - Cleans up after a drag
    * MY_MS_onLayerDrag()    - Fired when the mouse moves, updating the position of the layer
    */
function MY_MS_startLayerDrag(layerID){

        myms_layer = document.getElementById(layerID);

	if(myms_posLayer==false){
		myms_layer.style.left =layerID=="popupAddressbook"? 160 + "px" : 0 + "px"; // position de depart de la popup Ã  accorder avec la feuille css (#popupAddressbook)
		myms_layer.style.top = myms_mousePosY-10 + "px";
	}
        myms_origX = myms_mousePosX;
        myms_origY = myms_mousePosY;

        myms_origLayerX = Math.abs(myms_layer.style.left.substring(0, myms_layer.style.left.length - 2));
        myms_origLayerY = Math.abs(myms_layer.style.top.substring(0, myms_layer.style.top.length - 2));

        document.onmousemove = MY_MS_onLayerDrag;
    }

    function MY_MS_endLayerDrag()
    {
        myms_layer = '';
	document.onmousemove = MY_MS_getMouseXY;
    }

    function MY_MS_onLayerDrag(e)
    {
        MY_MS_getMouseXY(e);
        myms_diffX = myms_mousePosX - myms_origX;
        myms_diffY = myms_mousePosY - myms_origY;
        myms_layer.style.left = myms_origLayerX + myms_diffX + 'px';
        myms_layer.style.top  = myms_origLayerY + myms_diffY + 'px';
	myms_posLayer=true;
	document.onmouseup=MY_MS_endLayerDrag;
    }

/*--------------------------------------//////////////////////////////////////////////////////////////////////////////////////////////////-----------------------------------------*/

function MY_MS_rafraichi(){
	setInterval('MY_MS_envoi()', myms_speed_fresh);
}

function MY_MS_envoi(){ // les requetes qui actualise le chat
	if(myms_stop_rqst==false){ // si quelqun est connectÃ© on actualise les messages
		MY_MS_request( my_ms_myroot + "/chat_rqst.php?rqst=message&chm=" + my_ms_myroot,"toti_ms");
	}
	MY_MS_request( my_ms_myroot + "/chat_rqst.php?count=count","count"); // actualisation du compteur en permanance
}

  var myms_a_fait=false; // pret Ã  detecter l'ecriture du message
  var myms_alertmax=false; // pret pour alert max caracteres
function MY_MS_compter(f) {
  var myms_min=0;
  var myms_txt=f;
  var myms_nb=myms_txt.length;
	if ((myms_nb>=myms_max)&&(myms_alertmax==false)) {
			myms_alertmax=true;
		alert("Pas plus de " + myms_max + " caracteres !");
		f=myms_txt.substring(myms_min,myms_max);
		myms_nb=myms_max;
			}
	if ((myms_nb>myms_min)&&(myms_nb<myms_max)&&(myms_a_fait==false)&&(myms_tem_touch==true)) { // on envoi qui ecrit
		MY_MS_request(my_ms_myroot + "/ki.php?ecrit=" + document.myspeach.MSpseudo.value,'non');
		myms_a_fait=true; // on bloque pour envoyer qu'une seule fois la requete
	}
	document.myspeach.nbcar.value=myms_max - myms_nb;
}

/*-----------------------------/////////////////////////////// MY_MS_request(url,cadre) ///////////////////////////////////----------------------------------*/
  var myms_stop_rqst=false; // les requetes message ne sont pas stopÃ©es
 var url='';
 var cadre='';
function MY_MS_request(url,cadre) {
  var myms_xhr_object = null;
  var myms_retour = document.getElementById(cadre);
	if(window.XMLHttpRequest) // Firefox
		myms_xhr_object = new XMLHttpRequest();
	if(window.ActiveXObject) // Internet Explorer
		myms_xhr_object = new ActiveXObject("Microsoft.XMLHTTP");

	myms_xhr_object.open("GET",url, true);
	if (cadre!='non'){
		myms_xhr_object.onreadystatechange = function MY_MS_anonymous() {
			if(myms_xhr_object.readyState < 4) myms_retour.style.cursor="wait";
			if(myms_xhr_object.readyState == 4){
				if(myms_xhr_object.status ==200){
					// si le header n'est pas 200, evite l'affichage de la page 404
					myms_retour.style.cursor="default";
					if(cadre=='count') {
						myms_stop_rqst=myms_xhr_object.responseText.substr(0,1)<1?true:false;
					  var myms_aff_compteur = myms_xhr_object.responseText;
						myms_choix=myms_choix=="silence"?"silence":"son";
						if(myms_aff_compteur.substring(0,1)=="["){
							var myms_decoup=myms_aff_compteur.split("[");
							myms_aff_compteur =myms_decoup[3];
							if(myms_pseudo==myms_decoup[1]){
				  				MY_MS_request(my_ms_myroot + "/ki.php?part=" + "@@@",'non');
				  				window.open(my_ms_mychmskin + '/hello.php?son=' + myms_choix + "&mess=" + escape(myms_decoup[2]) ,"","width=100, height=100");
				 			}
						}
						document.getElementById('count').innerHTML = myms_aff_compteur;
					}else{
					myms_retour.innerHTML = myms_xhr_object.responseText;
					}
				}else{
				document.getElementById('count').innerHTML = url + " N'est pas disponible"; // (debug)
				}
			}
		}
	}

	myms_xhr_object.send(null);
	return;
}

function MY_MS_popup_smileys(){
  var myms_width = 350;
  var myms_height = 350;
		window.open(my_ms_myroot + "/smile.php", 'cp', 'resizable=yes, location=no, width=' + myms_width + ', height=' + myms_height + ', menubar=no, status=yes, scrollbars=1, menubar=no');
}

/*-------------------------//////////////////////////// Son popup ////////////////////////////////////-----------------------------------------------*/

function MY_MS_son(pseudo){
	myms_message.value=myms_message.value=="" ? "" : myms_message.value;
	MY_MS_request(my_ms_myroot + "/ki.php?dit=" + myms_pseudo + "&son=" + pseudo + "&mes=" +myms_pseudo + " "  + myms_message.value + "&chm=" + my_ms_mychmskin ,'temoin');
	myms_message.value="";
	myms_a_fait=false;
}

/*---------------------------------///////////////////// menu droit (son) /////////////////////------------------------------------------------------*/
var myms_bypass=false;

function MY_MS_cloche_droit(){
	if(myms_bypass==true){
	myms_choix=myms_choix=="silence"?"son":"silence";
	}else{
	myms_bypass=true;
	}
var myms_sonne='<img src="' + my_ms_mychmskin + '/coche2.gif" title="son" /><big> Mode sonore</big>';
var myms_silence='<img src="' + my_ms_mychmskin + '/coche.gif" title="silencieux" alt="' + my_ms_mychmskin + '"/><big> Mode silencieux</big>';
document.getElementById('cloche').innerHTML=myms_choix=="son"? myms_sonne : myms_silence;
	myms_date=new Date;
	myms_date.setMonth(myms_date.getMonth()+1);
	MY_MS_EcrireCookie("MS_config_son", myms_choix, myms_date,"/");
}

/*---------------------------//////////////////////////// envoi des messages ////////////////////////-----------------------------------------------*/

function MY_MS_checkForm() {

	var myms_formErrors = false;

	if (document.myspeach.MSpseudo.value.length < 2) {
		myms_formErrors = "Vous devez entrer un -- pseudo -- avant de poster.";
	}
	if (document.myspeach.MSmessage.value.length < 2) {
		myms_formErrors = "Vous devez entrer un -- message -- avant de poster.";
	}
	if (document.myspeach.MSpseudo.value == "Pseudo") {
		myms_formErrors = "Vous devez entrer un pseudo autre que -- Pseudo --.";
	}

	if(myms_bloclr==true){
		myms_etat_col=false;
		document.getElementById('pal').style.background="transparent";
	}

	if(myms_etat_col==true) {MY_MS_bbcode("zzz","col");}
	if(myms_etat_txt==true) {MY_MS_bbcode("zzz","txt");}

	if (myms_formErrors) {
		alert(myms_formErrors);
		return false;
	} else {

		MY_MS_zyva();
	}
}


function MY_MS_zyva() {
// on envoie un message
var myms_msg=document.myspeach.MSmessage.value;
	myms_msg=myms_bloclr==true?myms_deb_clr + myms_msg + myms_fbal + myms_fin_clr : myms_msg + myms_fbal;
	myms_tem=myms_bloclr==true?"c":"";
	//myms_setcol=myms_bloclr==true?true:false;
	myms_msg = myms_msg.replace(/\+/g,'&#43;');
	myms_msg=escape(myms_msg);
   var myms_psdo=escape(document.myspeach.MSpseudo.value);
   var myms_vazy=my_ms_myroot + "/save.php?mess=" + myms_msg + "&psd=" + myms_psdo + "&aj=ax";
   var myms_xhr_object = null;

	if(window.XMLHttpRequest) // Firefox
		myms_xhr_object = new XMLHttpRequest();
	if(window.ActiveXObject) // Internet Explorer
		myms_xhr_object = new ActiveXObject("Microsoft.XMLHTTP");

	myms_xhr_object.open("GET",myms_vazy, true);

	myms_xhr_object.onreadystatechange = function MY_MS_anonymous() {

		if(myms_xhr_object.readyState == 4)     {
			document.myspeach.MSmessage.value="";
			document.myspeach.nbcar.value="";
			myms_a_fait=false; // le message est parti on debloque la detection de l'ecriture de message
			myms_fbal=""; // raz
			myms_alertmax=false; // le message est parti on debloque la detection du comptage des caracteres
  var myms_rep = myms_xhr_object.responseText;
  var myms_res = myms_rep.substring(0, 1);
	 //alert(res);
			if((myms_res <= 4)&& (myms_res >= 1)) { // affichage des messages d'erreur, si il y en a (save.php)
				document.getElementById('pop_titre').innerHTML = "Erreur";
				if(myms_res==1){document.getElementById('pop').innerHTML= myms_error1;}
				if(myms_res==2){document.getElementById('pop').innerHTML= myms_error2;}
				if(myms_res==3){document.getElementById('pop').innerHTML= myms_error3;}
				if(myms_res==4){document.getElementById('pop').innerHTML= myms_error4;}
				document.getElementById('popupAddressbook').style.display="block";
			}
		}
	}
	myms_xhr_object.send(null);
	MY_MS_envoi();
	document.myspeach.MSmessage.focus();
	return;
}

