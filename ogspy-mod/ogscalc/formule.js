<!--//--><![CDATA[//><!--

var batimentsOGSpy = new Array();
var technologiesOGSpy = new Array();

arrayTechno = new Array('robot','chantier','nanite','labopm','labo1','labo2','labo3','labo4','labo5','labo6','labo7','labo8','reseau');
arrayBatiments = new Array('mine_metal','mine_cristal','synthetiseur_deuterium','centrale_solaire','reacteur_fusion','usine_robots','usine_nanites','chantier_spatial','hangar_metal','hangar_cristal','reservoir_deuterium','laboratoire','silo_missiles','terraformeur');
arrayBatimentsSpeciaux = new Array('base_lunaire','phalange_capteurs','porte_saut_spatial','depot_ravitaillement');
arrayTechnologies = new Array('espionnage','ordinateur','armes','bouclier','protection_vaisseaux','energie','hyperespace','reacteur_combustion','reacteur_impulsion','propulsion_hyperespace','laser','ion','plasma','reseau_recherche','expeditions');
arrayVaisseaux = new Array('pt','gt','cle','clo','cr','vb','traq','bb','dest','edlm','recycleur','vc','sonde','satellite');
arrayDefenses = new Array('lm','ale','alo','canon_ion','gauss','lp','pb','gb','min','mip');
arrayTotal = new Array('batiments','batiments_speciaux','technologies','vaisseaux','defenses');

function writeCookie(nom, valeur)
{
	var argv=writeCookie.arguments;
	var argc=writeCookie.arguments.length;
	var expires=(argc > 2) ? argv[2] : null;
	var path=(argc > 3) ? argv[3] : null;
	var domain=(argc > 4) ? argv[4] : null;
	var secure=(argc > 5) ? argv[5] : false;
	document.cookie=nom+"="+escape(valeur)+
	((expires==null) ? "" : ("; expires="+expires.toGMTString()))+
	((path==null) ? "" : ("; path="+path))+
	((domain==null) ? "" : ("; domain="+domain))+
	((secure==true) ? "; secure" : "");
}

function compare ( a, b )
{
 return b - a;
}

function isNumeric( sText )
{
	var ValidChars = "0123456789";
	var IsNumber=true;
	var Char;

	for (i = 0; i < sText.length && IsNumber == true; i++)
	{
		Char = sText.charAt(i);
		if (ValidChars.indexOf(Char) == -1)
		{
			IsNumber = false;
		}
	}
	return IsNumber;
}

function afficheDurée ( valeur )
{
	valeur = parseFloat(valeur);
	if ( valeur != 0 )
	{
		var jour = Math.floor(valeur/86400);
		valeur = valeur - 86400*jour;
		var heure = Math.floor(valeur/3600);
		valeur = valeur - 3600*heure;
		var minute = Math.floor(valeur/60);
		valeur = valeur - 60*minute;
		var seconde = Math.floor(valeur);
		var texte = '';
		if ( jour != 0 ) { texte = jour + 'j'; }
		if ( heure != 0 ) { texte = texte + heure + 'h'; }
		if ( minute != 0 ) { texte = texte + minute + 'm'; }
		if ( seconde != 0 ) { texte = texte + seconde + 's'; }
	} else {
		var texte = '-';
	}
	return texte;
}

function affiche(balise)
{
	if (document.getElementById && document.getElementById(balise) != null)
	{
		document.getElementById(balise).style.display='block';
	}
}

function cache(balise)
{
	if (document.getElementById && document.getElementById(balise) != null)
	{
		document.getElementById(balise).style.display='none';
	}
}

function inverse(balise)
{
	if ( document.getElementById(balise).style.display == 'block' ) { cache(balise); } else { affiche(balise); }
}

function coutDe_A ( p1, alpha, i, j )
{
	if ( i>j ) { return 0; } else { return Math.floor(p1*(Math.pow(alpha,j)-Math.pow(alpha,i))/(alpha-1)); }
}

function graviton ()
{
	actuel = parseFloat(document.getElementById('graviton_actuel').value);
	voulu = parseFloat(document.getElementById('graviton_voulu').value);
	if (voulu>actuel)
	{
		document.getElementById('graviton').value=coutDe_A(300000,3,voulu-1,voulu);
	} else {
		document.getElementById('graviton').value=0;
	}
}

function somme ( type, arr, res )
{
	result=0;
	for(i=0;i<arr.length;i++)
	{
		if ( !( ( (arr[i]=='terraformeur') && (res=='_metal') ) ) )
		{
			if (res=='_temps')
			{
				id=arr[i]+'_sec';
				result+=parseFloat(document.getElementById(id).value);
			} else {
				id=arr[i]+res;
				result+=parseFloat(document.getElementById(id).value);
			}
		}
	}
	if (res=='_temps')
	{
		document.getElementById(type+'_sec').value=result;
		document.getElementById(type+res).value=afficheDurée(result);
	} else {
		document.getElementById(type+res).value=result;
	}		
}

function sommeTotale ()
{
	somme('total',arrayTotal,'_metal');
	somme('total',arrayTotal,'_cristal');
	somme('total',arrayTotal,'_deuterium');
	somme('total',arrayTotal,'_temps');
	calcul_transports(arrayTotal);
}

function construction ( bat, met, cris, deut, coeff )
{
	actuel = bat+'_actuel';
	voulu = bat+'_voulu';
	metal = bat+'_metal';
	cristal = bat+'_cristal';
	deuterium = bat+'_deuterium';
	sec = bat+'_sec';
	temps = bat+'_temps';
	
	document.getElementById(metal).value=coutDe_A(met,coeff,parseFloat(document.getElementById(actuel).value),parseFloat(document.getElementById(voulu).value));
	document.getElementById(cristal).value=coutDe_A(cris,coeff,parseFloat(document.getElementById(actuel).value),parseFloat(document.getElementById(voulu).value));
	document.getElementById(deuterium).value=coutDe_A(deut,coeff,parseFloat(document.getElementById(actuel).value),parseFloat(document.getElementById(voulu).value));
	if (bat=='terraformeur') {
		document.getElementById(sec).value=2*60*60*parseFloat(document.getElementById(cristal).value)/5000/Math.pow(2,parseFloat(document.getElementById('nanite').value))/(1+parseFloat(document.getElementById('robot').value));
	} else {
		document.getElementById(sec).value=2*60*60*(parseFloat(document.getElementById(metal).value)+parseFloat(document.getElementById(cristal).value))/5000/Math.pow(2,parseFloat(document.getElementById('nanite').value))/(1+parseFloat(document.getElementById('robot').value));
	}
	document.getElementById(temps).value=afficheDurée(parseFloat(document.getElementById(sec).value));
}

function batiment ( bat, met, cris, deut, coeff )
{
	construction(bat,met,cris,deut,coeff);
		
	somme('batiments',arrayBatiments,'_metal');
	somme('batiments',arrayBatiments,'_cristal');
	somme('batiments',arrayBatiments,'_deuterium');
	somme('batiments',arrayBatiments,'_temps');
	sommeTotale();
}

function batimentSpeciaux ( bat, met, cris, deut, coeff )
{
	construction(bat,met,cris,deut,coeff);

	somme('batiments_speciaux',arrayBatimentsSpeciaux,'_metal');
	somme('batiments_speciaux',arrayBatimentsSpeciaux,'_cristal');
	somme('batiments_speciaux',arrayBatimentsSpeciaux,'_deuterium');
	somme('batiments_speciaux',arrayBatimentsSpeciaux,'_temps');
	sommeTotale();
}

function technologie ( tech, met, cris, deut, coeff )
{
	actuel = tech+'_actuel';
	voulu = tech+'_voulu';
	metal = tech+'_metal';
	cristal = tech+'_cristal';
	deuterium = tech+'_deuterium';
	sec = tech+'_sec';
	temps = tech+'_temps';

	document.getElementById(metal).value=coutDe_A(met,coeff,parseFloat(document.getElementById(actuel).value),parseFloat(document.getElementById(voulu).value));
	document.getElementById(cristal).value=coutDe_A(cris,coeff,parseFloat(document.getElementById(actuel).value),parseFloat(document.getElementById(voulu).value));
	document.getElementById(deuterium).value=coutDe_A(deut,coeff,parseFloat(document.getElementById(actuel).value),parseFloat(document.getElementById(voulu).value));
	document.getElementById(sec).value=60*60*(parseFloat(document.getElementById(metal).value)+parseFloat(document.getElementById(cristal).value))/1000/(1+parseFloat(document.getElementById('laboequi').value));
	document.getElementById(temps).value=afficheDurée(parseFloat(document.getElementById(sec).value));

	somme('technologies',arrayTechnologies,'_metal');
	somme('technologies',arrayTechnologies,'_cristal');
	somme('technologies',arrayTechnologies,'_deuterium');
	somme('technologies',arrayTechnologies,'_temps');
	sommeTotale();
}

function unite ( uni, met, crist, deut )
{
	voulu = uni+'_voulu';
	metal = uni+'_metal';
	cristal = uni+'_cristal';
	deuterium = uni+'_deuterium';
	sec = uni+'_sec';
	temps = uni+'_temps';
	
	document.getElementById(metal).value=document.getElementById(voulu).value*met;
	document.getElementById(cristal).value=document.getElementById(voulu).value*crist;
	document.getElementById(deuterium).value=document.getElementById(voulu).value*deut;
	document.getElementById(sec).value=2*60*60*(parseFloat(document.getElementById(metal).value)+parseFloat(document.getElementById(cristal).value))/5000/Math.pow(2,document.getElementById('nanite').value)/(1+parseFloat(document.getElementById('chantier').value));
	document.getElementById(temps).value=afficheDurée(document.getElementById(sec).value);
}

function vaisseaux ( uni, met, crist, deut )
{
	unite(uni,met,crist,deut);
	
	somme('vaisseaux',arrayVaisseaux,'_metal');
	somme('vaisseaux',arrayVaisseaux,'_cristal');
	somme('vaisseaux',arrayVaisseaux,'_deuterium');
	somme('vaisseaux',arrayVaisseaux,'_temps');
	sommeTotale();
}

function defense ( uni, met, crist, deut )
{
	unite(uni,met,crist,deut);
	
	somme('defenses',arrayDefenses,'_metal');
	somme('defenses',arrayDefenses,'_cristal');
	somme('defenses',arrayDefenses,'_deuterium');
	somme('defenses',arrayDefenses,'_temps');
	sommeTotale();
}

function laboEqui()
{
	var i = 0;
	var t_labo = Array();
	
	while(batimentsOGSpy[i])
	{
		t_labo.push(batimentsOGSpy[i][12]);
		i++;
	}

	t_labo.sort(compare);
	
	labo_Equi = 0;
	for(i = 0 ; i < document.getElementById('reseau').value ; i++)
	{
		if(t_labo[i] >= 7)
		{	
			labo_Equi += parseFloat(t_labo[i]);
		}
	}
	document.getElementById('laboequi').value = labo_Equi;
	rafraichiLaboratoire();
}

function rafraichiTempsBatiments ( bat )
{
	metal = bat+'_metal';
	cristal = bat+'_cristal';
	deuterium = bat+'_deuterium';
	sec = bat+'_sec';
	temps = bat+'_temps';

	document.getElementById(sec).value=2*60*60*(parseFloat(document.getElementById(metal).value)+parseFloat(document.getElementById(cristal).value))/5000/Math.pow(2,document.getElementById('nanite').value)/(1+parseFloat(document.getElementById('robot').value));
	document.getElementById(temps).value=afficheDurée(document.getElementById(sec).value);
}

function rafraichiTempsTechnologies ( bat )
{
	metal = bat+'_metal';
	cristal = bat+'_cristal';
	deuterium = bat+'_deuterium';
	sec = bat+'_sec';
	temps = bat+'_temps';

	document.getElementById(sec).value=2*60*60*(parseFloat(document.getElementById(metal).value)+parseFloat(document.getElementById(cristal).value))/5000/(1+parseFloat(document.getElementById('laboequi').value));
	document.getElementById(temps).value=afficheDurée(document.getElementById(sec).value);
}

function rafraichiTempsUnites ( bat )
{
	metal = bat+'_metal';
	cristal = bat+'_cristal';
	deuterium = bat+'_deuterium';
	sec = bat+'_sec';
	temps = bat+'_temps';

	document.getElementById(sec).value=2*60*60*(parseFloat(document.getElementById(metal).value)+parseFloat(document.getElementById(cristal).value))/5000/Math.pow(2,document.getElementById('nanite').value)/(1+parseFloat(document.getElementById('chantier').value));
	document.getElementById(temps).value=afficheDurée(document.getElementById(sec).value);
}

function rafraichiRobot ()
{
	for ( i = 0; i < arrayBatiments.length; i++ )
	{
		bat = arrayBatiments[i];
		rafraichiTempsBatiments(bat);
	}
	for ( i = 0; i < arrayBatimentsSpeciaux.length; i++ )
	{
		bat = arrayBatimentsSpeciaux[i];
		rafraichiTempsBatiments(bat);
	}

	somme('batiments',arrayBatiments,'_metal');
	somme('batiments',arrayBatiments,'_cristal');
	somme('batiments',arrayBatiments,'_deuterium');
	somme('batiments',arrayBatiments,'_temps');

	somme('batiments_speciaux',arrayBatimentsSpeciaux,'_metal');
	somme('batiments_speciaux',arrayBatimentsSpeciaux,'_cristal');
	somme('batiments_speciaux',arrayBatimentsSpeciaux,'_deuterium');
	somme('batiments_speciaux',arrayBatimentsSpeciaux,'_temps');

	sommeTotale();
}

function rafraichiLaboratoire ()
{
	for ( i = 0; i < arrayTechnologies.length; i++ )
	{
		bat = arrayTechnologies[i];
		rafraichiTempsTechnologies(bat);
	}

	somme('technologies',arrayTechnologies,'_metal');
	somme('technologies',arrayTechnologies,'_cristal');
	somme('technologies',arrayTechnologies,'_deuterium');
	somme('technologies',arrayTechnologies,'_temps');
	
	sommeTotale();
}

function rafraichiChantier ()
{
	for ( i = 0; i < arrayVaisseaux.length; i++ )
	{
		bat = arrayVaisseaux[i];
		rafraichiTempsUnites(bat);
	}
	for ( i = 0; i < arrayDefenses.length; i++ )
	{
		bat = arrayDefenses[i];
		rafraichiTempsUnites(bat);
	}
	
	somme('vaisseaux',arrayVaisseaux,'_metal');
	somme('vaisseaux',arrayVaisseaux,'_cristal');
	somme('vaisseaux',arrayVaisseaux,'_deuterium');
	somme('vaisseaux',arrayVaisseaux,'_temps');
	
	somme('defenses',arrayDefenses,'_metal');
	somme('defenses',arrayDefenses,'_cristal');
	somme('defenses',arrayDefenses,'_deuterium');
	somme('defenses',arrayDefenses,'_temps');
	
	sommeTotale();
}

function sauvegarde ()
{
	var date=new Date;
	date.setMonth(date.getMonth()+12*500);
	writeCookie("dataSave", "1", date);
	var save = new Array();
	var j = 0;
	for ( i = 0; i < arrayTechno.length; i++ )
	{
		typeUnite = arrayTechno[i];
		valueUnite = document.getElementById(typeUnite).value;
		save[j] = typeUnite+">"+valueUnite;
		j++;
	}
	for ( i = 0; i < arrayBatiments.length; i++ )
	{
		typeUnite = arrayBatiments[i]+"_actuel";
		valueUnite = document.getElementById(typeUnite).value;
		save[j] = typeUnite+">"+valueUnite;
		j++;
	}
	for ( i = 0; i < arrayBatimentsSpeciaux.length; i++ )
	{
		typeUnite = arrayBatimentsSpeciaux[i]+"_actuel";
		valueUnite = document.getElementById(typeUnite).value;
		save[j] = typeUnite+">"+valueUnite;
		j++;
	}
	for ( i = 0; i < arrayTechnologies.length; i++ )
	{
		typeUnite = arrayTechnologies[i]+"_actuel";
		valueUnite = document.getElementById(typeUnite).value;
		save[j] = typeUnite+">"+valueUnite;
		j++;
	}
	writeCookie("data", save, date);
	alert('Données sauvegardées');
}

function restaure ()
{
	arrayCookie = document.cookie.split("; ");
	for ( i = 0; i < arrayCookie.length; i++ )
	{
		arrayCookie[i] = arrayCookie[i].split("=");
		if ( arrayCookie[i][0] == 'data' )
		{
			save = arrayCookie[i][1];
		}
	}
	save = save.split("%2C");
	for ( i = 0;  i < save.length; i++ )
	{
		temp = save[i].split("%3E");
		document.getElementById(temp[0]).value = temp[1];
	}
	alert('Données restaurées');
}

function resetType ( array )
{
	for ( i = 0; i < array.length; i++ )
	{
		bat1 = array[i]+"_actuel";
		document.getElementById(bat1).value = 0;
		bat2 = array[i]+"_voulu";
		document.getElementById(bat2).value = 0;
		bat3 = array[i]+"_metal";
		document.getElementById(bat3).value = 0;
		bat4 = array[i]+"_cristal";
		document.getElementById(bat4).value = 0;
		bat5 = array[i]+"_deuterium";
		document.getElementById(bat5).value = 0;
		bat6 = array[i]+"_temps";
		document.getElementById(bat6).value = '-';
		bat7 = array[i]+"_sec";
		document.getElementById(bat7).value = 0;
	}
}

function resetUnite ( array )
{
	for ( i = 0; i < array.length; i++ )
	{
		bat1 = array[i]+"_voulu";
		bat2 = array[i]+"_metal";
		bat3 = array[i]+"_cristal";
		bat4 = array[i]+"_deuterium";
		bat5 = array[i]+"_temps";
		bat6 = array[i]+"_sec";
		document.getElementById(bat1).value = 0;
		document.getElementById(bat2).value = 0;
		document.getElementById(bat3).value = 0;
		document.getElementById(bat4).value = 0;
		document.getElementById(bat5).value = '-';
		document.getElementById(bat6).value = 0;
	}
}

function resetTotal ()
{
	for ( i = 0; i < arrayTotal.length; i++ )
	{
		bat1 = arrayTotal[i]+"_metal";
		bat2 = arrayTotal[i]+"_cristal";
		bat3 = arrayTotal[i]+"_deuterium";
		bat4 = arrayTotal[i]+"_temps";
		bat5 = arrayTotal[i]+"_sec";
		bat6 = arrayTotal[i]+"_ressources";
		bat7 = arrayTotal[i]+"_pt";
		bat8 = arrayTotal[i]+"_gt";
		document.getElementById(bat1).value = 0;
		document.getElementById(bat2).value = 0;
		document.getElementById(bat3).value = 0;
		document.getElementById(bat4).value = '-';
		document.getElementById(bat5).value = 0;
		document.getElementById(bat6).innerHTML = 0;
		document.getElementById(bat7).innerHTML = 0;
		document.getElementById(bat8).innerHTML = 0;
	}
}

function resetData ()
{

	document.getElementById('laboequi').value = 0;
	
	document.getElementById('graviton_actuel').value = 0;
	document.getElementById('graviton_voulu').value = 0;
	document.getElementById('graviton').value = 0;
	
	resetType(arrayBatiments);
	resetType(arrayBatimentsSpeciaux);
	resetType(arrayTechnologies);
	resetUnite(arrayVaisseaux);
	resetUnite(arrayDefenses);
	
	resetTotal();
	document.getElementById('total_metal').value = 0;
	document.getElementById('total_cristal').value = 0;
	document.getElementById('total_deuterium').value = 0;
	document.getElementById('total_sec').value = 0;
	document.getElementById('total_temps').value = '-';
}

function calcul_transports ( arr )
{
	for ( i = 0; i <= arr.length; i++ )
	{
		if (i == arr.length)
		{
			type = "total";
		} else {
			type = arr[i];
		}
		result=0;
		result+=parseFloat(document.getElementById(type+"_metal").value);
		result+=parseFloat(document.getElementById(type+"_cristal").value);
		result+=parseFloat(document.getElementById(type+"_deuterium").value);
		document.getElementById(type+"_ressources").innerHTML=formatNmb(result);
		document.getElementById(type+"_pt").innerHTML=formatNmb(Math.ceil(result/5000));
		document.getElementById(type+"_gt").innerHTML=formatNmb(Math.ceil(result/25000));
	}
}
function formatNmb(numero)
{ // Formater le nombre avec des . entre chaque groupe de 3 chiffres
	var nNmb = String(numero); 
	var sRes = "";
	for (var j, i = nNmb.length - 1, j = 0; i >= 0; i--, j++)
		sRes = nNmb.charAt(i) + ((j > 0) && (j % 3 == 0)? ".": "") + sRes;
	return sRes;
}

function chargement(id_planete)
{
	// resetData();
	
	document.getElementById("labopm").value = batimentsOGSpy[id_planete][12];
	document.getElementById("robot").value = batimentsOGSpy[id_planete][6];
	document.getElementById("chantier").value = batimentsOGSpy[id_planete][8];
	document.getElementById("nanite").value = batimentsOGSpy[id_planete][7];
	document.getElementById("reseau").value = technologiesOGSpy[13];
	document.getElementById("graviton_actuel").value=technologiesOGSpy[14];
	
	if(batimentsOGSpy[id_planete][12] >= 7)
	{
		laboEqui();
	}
	else
	{
		document.getElementById('laboequi').value = batimentsOGSpy[id_planete][12];
	}
}

//--><!]]>