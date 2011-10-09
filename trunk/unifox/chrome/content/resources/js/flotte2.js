function dateTempsReelOffset(time)
{
	var days = new Array('Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam');
	var months = new Array('jan', 'f\u00E9v', 'mar', 'avr', 'mai', 'juin', 'juil', 'ao\u00E9', 'sep', 'oct', 'nov', 'd\u00E9c');
	date = new Date;
	date.setTime(date.getTime()+time*1000);
	date_now = new Date;
	date_now.setTime(date_now.getTime());
	var hour = date.getHours();
	var min = date.getMinutes();
	var sec = date.getSeconds();
	var day_number = date.getDate();
	var day_number_now = date_now.getDate();
	var month = date.getMonth();
	var month_now = date_now.getMonth();
	var nextday = "";
	
	if (day_number_now != day_number || month_now != month) {
		nextday = days[date.getDay()] + ' ' + day_number + ' ' + months[date.getMonth()] + ' ';
	}
	
	if (sec < 10) sec = '0' + sec;
	if (min < 10) min = '0' + min;
	if (hour < 10) hour = '0' + hour;

	var datetime =  nextday + hour + ':' + min + ':' + sec;
	
	return datetime;
}

function dateArrivee(interval) {
	var duree = document.getElementsByName("duree")[0].value;
	document.getElementById("arrivee").innerHTML = ''+dateTempsReelOffset(duree)+'';
	document.getElementById("retour").innerHTML = ''+dateTempsReelOffset(duree*2)+'';
	
	setTimeout('dateArrivee('+interval+')', interval);
}

function Infov() {

  document.getElementById("distance").innerHTML = AddEspace(distance());
  var secondes = duree();
  var heures = Math.floor(secondes / 3600);
  secondes -= heures * 3600;

  var minutes = Math.floor(secondes / 60);
  secondes -= minutes * 60;

  if (minutes < 10) minutes = "0" + minutes;
  if (secondes < 10) secondes = "0" + secondes;

  document.getElementById("duree").innerHTML = heures + ":" + minutes + ":" + secondes + " h";
  var stor = stockage();
  var cons = conso();
  if(cons > stor)
	stor = stor - cons;//on ne compte la conso que si elle dépasse le frêt

  document.getElementById("maxvitesse").innerHTML = AddEspace(maxvitesse());
  document.getElementsByName("duree")[0].value = duree();
  if (stor >= 0) {
    document.getElementById("conso").innerHTML = '<font color="lime">'+AddEspace(cons)+'</font>';
    document.getElementById("stockage").innerHTML = '<font color="lime">'+AddEspace(stor)+'</font>';
  } else {
    document.getElementById("conso").innerHTML = '<font color="red">'+AddEspace(cons)+'</font>';
    document.getElementById("stockage").innerHTML = '<font color="red">'+AddEspace(stor)+'</font>';
  }

  //dateArrivee();
}

function AddEspace(Sentence){
	var SentenceModified = '';
	var Rest = '';
	while (Sentence >= 1000 || Sentence <= -1000) {
		Rest = Sentence - Math.floor(Sentence/1000)*1000;
		if (Rest<10) 
			Rest='00'+Rest;
		else if (Rest<100) 
			Rest='0'+Rest;
		Sentence = Math.floor(Sentence/1000);
		SentenceModified = ' '+Rest+SentenceModified;
	}
	return (Sentence+SentenceModified);
}

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------


function calculateTransportCapacity() {
  var r1= Math.abs(document.getElementsByName("ressource1_aff")[0].value);
  var r2= Math.abs(document.getElementsByName("ressource2_aff")[0].value);
  var r3= Math.abs(document.getElementsByName("ressource3_aff")[0].value);

  tc =  stockage() - r1 - r2 - r3;

  if (tc < 0) {
    document.getElementById("reste_ressources").innerHTML="<font color=red>"+AddEspace(tc)+"</font>";
  } else {
    document.getElementById("reste_ressources").innerHTML="<font color=lime>"+AddEspace(tc)+"</font>";
  }
  return tc;
}
