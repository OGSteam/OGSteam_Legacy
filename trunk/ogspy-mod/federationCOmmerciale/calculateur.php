<?php
/***********************************************************************
 * filename	:	Convertisseur.php
 * desc.	:	Fichier principal
 * created	: 	06/11/2006 Mirtador
 *
 * *********************************************************************/

//Sécuriter
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//ON commence les fonction qui vont tout calculler


/*
Fonction pour permettre à la fonction qt_ressource de supporter 3 ressource au lieu d'un seulle
*/
function qt_ressource1_merge($M_fournie,$C_fournie,$D_fournie,$M_taux,$C_taux,$D_taux,$nb_acheteur_vendeur){
	if ($M_taux==0 or $C_taux==0 or $D_taux==0){
		for ($i=1 ; $i<=$nb_acheteur_vendeur ; $i++) {
			$Valleur[$i]=0;
		}
		$result=$Valleur;
		return $result;
	}
	for ($i=1 ; $i<=$nb_acheteur_vendeur ; $i++) {
		$Valleur[$i]=($M_fournie[$i])/($M_taux)+($C_fournie[$i])/($C_taux)+($D_fournie[$i])/($D_taux);
	}
	$result=$Valleur;
	return $result;
}
function qt_ressource1_devide($ressource_rechercher,$autre_ressource_1, $autre_ressource_2, $Valleur, $taux_rechercher, $taux_1, $taux_2, $nb_acheteur, $nb_vendeur){
	//on inicialise les variables
	$total=0;
	$total_rechercher=0;
	$ratio=0;
	
	if ($taux_rechercher==0 or $taux_1==0 or $taux_2==0){
		for ($i=1 ; $i<=$nb_acheteur ; $i++) {
			$result[$i]=0;
		}
		return $result;
	}
	
	for ($i=1 ; $i<=$nb_vendeur ; $i++) {
		$total=$total+($ressource_rechercher[$i]/$taux_rechercher)+($autre_ressource_1[$i]/$taux_1)+($autre_ressource_2[$i]/$taux_2);
		$total_rechercher=$total_rechercher+$ressource_rechercher[$i];
	}

	if ($total!=0){
		$ratio=$total_rechercher/($total/$taux_rechercher);
		for ($i=1 ; $i<=$nb_acheteur ; $i++) {
			$result[$i]=$ratio*$Valleur[$i]/$taux_rechercher;
		}
	}
	else{
		for ($i=1 ; $i<=$nb_acheteur ; $i++) {
			$result[$i]=0;
		}
		return $result;
	}
	return $result;
}

/*
Liste des variable Qu'on doit rensseigner pour que la fonction marche
$nb_vendeur
$nb_acheteur
$qt_ressource_fourni (matrice à 1 dimentions)
$qt_ressource_ressu (matrice à 1 dimentions)
*/
function qt_ressource1($nb_vendeur,$nb_acheteur,$qt_ressource_fourni,$qt_ressource_ressu){
	//on inicialise les variables
	$qt_ressource_total=0;
	$qt_ressource_ressu_total=0;
	//on vérifi que la varaible $qt_ressource_fourni est bien une matrice
	if (!is_array($qt_ressource_fourni) or !is_array($qt_ressource_ressu)){
		return false;
	}
	
	// On détermine la Quantiter de ressource total
	for ($i=1 ; $i<=$nb_vendeur ; $i++) {
		$qt_ressource_total=$qt_ressource_total+$qt_ressource_fourni[$i];
	}
	for ($i=1 ; $i<=$nb_acheteur ; $i++) {
		$qt_ressource_ressu_total=$qt_ressource_ressu_total+$qt_ressource_ressu[$i];
	}
	if ($qt_ressource_total==0){
		for ($i=1 ; $i<=$nb_vendeur ; $i++) {
			$qt_ressource[$i]=0;
		}
		$result=$qt_ressource;
		return $result;
	}

	//maintenant on fait un ratio de ce qu'il devrais revenir pour chaque vendeur
	for ($i=1 ; $i<=$nb_vendeur ; $i++) {
		$ratio[$i]=$qt_ressource_fourni[$i]/$qt_ressource_total;
	}
	
	for ($i=1 ; $i<=$nb_vendeur ; $i++) {
		$qt_ressource[$i]=$qt_ressource_ressu_total*$ratio[$i];
	}
	
	$result=$qt_ressource;
	return $result;
}
	
	
/*
Cette fonction est faite pour un formulaire plus tradissionnelle ou tu à l'offre et la demande. mais en ajoutant comment on ce sépare la cagnotte :p
Liste des variable Qu'on doit rensseigner pour que la fonction marche
$nb_vendeur
$ratio (matrice à 1 dimentions)
$qt_ressource_envoyer (Il s'agi de la somme des ressource envoyer)
$qt_ressource_ressu (il s'agi de la somme des ressource que la perssone avec qui vous faite affaire vas vous envoyer)
*/
function qt_ressource2_envoyer($nb_vendeur,$ratio,$qt_ressource_envoyer,$qt_ressource_ressu){
	//on vérifi que la varaible $ratio est bien une matrice
	if (!is_array($ratio)){
		return false;
	}
	
	//
	for ($i=1 ; $i<=$nb_vendeur ; $i++) {
		$qt_ressource[$i]=$qt_ressource_envoyer*($ratio/100);
	}
	
	$result=$qt_ressource;
	return $result;
}


/*
Cette fonction est faite pour un formulaire plus tradissionnelle ou tu à l'offre et la demande. mais en ajoutant comment on ce sépare la cagnotte :p
Liste des variable Qu'on doit rensseigner pour que la fonction marche
$nb_vendeur
$ratio (matrice à 1 dimentions)
$qt_ressource_envoyer (Il s'agi de la somme des ressource envoyer)
$qt_ressource_ressu (il s'agi de la somme des ressource que la perssone avec qui vous faite affaire vas vous envoyer)
*/
function qt_ressource2_resssu($nb_vendeur,$ratio,$qt_ressource_envoyer,$qt_ressource_ressu){
	//on vérifi que la varaible $ratio est bien une matrice
	if (!is_array($ratio)){
		return false;
	}
	
	//
	for ($i=1 ; $i<=$nb_vendeur ; $i++) {
		$qt_ressource[$i]=$qt_ressource_ressu*($ratio/100);
	}
	
	$result=$qt_ressource;
	return $result;
}

/*
fonction qui récupère les résultats et les envois dans la BD
*/
function sauvegarde($nb_vendeur, $nb_acheteur, $M_taux, $C_taux, $D_taux, $pseudo_vendeur, $pseudo_acheteur, $métal_vendeur, $cristal_vendeur,$deutérium_vendeur, $métal_acheteur, $cristal_acheteur, $deutérium_acheteur){
	//on défini les variable
	global $db;

	define("TABLE_FEDERATION_COMMERCIAL", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial");
	define("TABLE_FEDERATION_COMMERCIAL_VENTE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial_vente");
	define("TABLE_FEDERATION_COMMERCIAL_PARTICIPANTS", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."federation_commercial_participants");

	//on déterminer le ID de la transaction
	$query = 'SELECT `lastid` FROM `'.TABLE_FEDERATION_COMMERCIAL.'` WHERE `id`=\'1\' LIMIT 1';
	$result = $db->sql_query($query);
	if (!$db->sql_numrows($result)) die('Hacking attempt');
	list($lastid) = $db->sql_fetch_row($result);
	$lastid=$lastid+1;
	$query = 'UPDATE '.TABLE_FEDERATION_COMMERCIAL.' SET `lastid` = \''.$lastid.'\' WHERE `id` = \'1\'';
	$db->sql_query($query);
	
	//on détermine le moment de l'envois
	$time=time();
	
	//on envoy les résultat de la vente
	$query = "INSERT INTO ".TABLE_FEDERATION_COMMERCIAL_VENTE." (id, nb_vendeur, nb_acheteur, m_taux, c_taux, d_taux, date) VALUES ('".$lastid."', '".$nb_vendeur."', '".$nb_acheteur."', '".$M_taux."', '".$C_taux."', '".$D_taux."', '".$time."')";
	$db->sql_query($query);
	
	//maintenant que l'offre est enregistré nous allons enregistrer les participants
	for ($i=1 ; $i<=$nb_vendeur ; $i++) {
		$query = "INSERT INTO ".TABLE_FEDERATION_COMMERCIAL_PARTICIPANTS." (id, pseudo, metal, cristal, deuterium, rang, groupe, vente_id) VALUES ('', '".$pseudo_vendeur[$i]."', '".$métal_vendeur[$i]."', '".$cristal_vendeur[$i]."', '".$deutérium_vendeur[$i]."', '".$i."', '1', '".$lastid."')";
	$db->sql_query($query);
	}
	for ($i=1 ; $i<=$nb_acheteur ; $i++) {
		$query = "INSERT INTO ".TABLE_FEDERATION_COMMERCIAL_PARTICIPANTS." (id, pseudo, metal, cristal, deuterium, rang, groupe, vente_id) VALUES ('', '".$pseudo_acheteur[$i]."', '".$métal_acheteur[$i]."', '".$cristal_acheteur[$i]."', '".$deutérium_acheteur[$i]."', '".$i."', '2', '".$lastid."')";
	$db->sql_query($query);
	}
}
/*
fonction récupéré de mon mad aide au comerce aillant pour but de vérifier si la variable rentré est un nombre
*/
function estunnombre($chainedecaractère){
	if (preg_match("#[a-z]#i", "$chainedecaractère")){
		$résult= false;
	}
	else{
		$résult= true;
	}
	return "$résult";
}

//fonction de sélection de BBcode
?>
<SCRIPT language="JavaScript">
function selectionner() {
		document.getElementById('bbcode').select();
	}
</script>
<?php
//fonction qui transforme les virgule en point
?>
<SCRIPT language="JavaScript">
function javascript_virguleapoint(unitee){
	if(unitee.indexOf(",")!=-1){
	unitee=unitee.replace(",",".");
	}
	return unitee;
}
</script>
<?php
//fonction qui transforme gère les unitées en java scripe

?>
<SCRIPT language="JavaScript">

function javascript_unitee(unitee){
	unitee=unitee.toLowerCase();
	
	if(unitee.indexOf("kk")!=-1){
		unitee.replace("kk","");
		unitee=parseFloat(unitee)
		if (isNaN(unitee)){
			unitee=0;
		}
		else{
		unitee=unitee*1000000;
		}
		return unitee;
	}
	
	if(unitee.indexOf("milion")!=-1){
		unitee.replace("m","");
		unitee=parseFloat(unitee)
		if (isNaN(unitee)){
			unitee=0;
		}
		else{
		unitee=unitee*1000000;
		}
		return unitee;
	}
	
	if(unitee.indexOf("m")!=-1){
		unitee.replace("m","");
		unitee=parseFloat(unitee)
		if (isNaN(unitee)){
			unitee=0;
		}
		else{
		unitee=unitee*1000000;
		}
		return unitee;
	}
	
	if(unitee.indexOf("kilo")!=-1){
		unitee.replace("kilo","");
		unitee=parseFloat(unitee)
		if (isNaN(unitee)){
			unitee=0;
		}
		else{
		unitee=unitee*1000;
		}
		return unitee;
	}
	
	if(unitee.indexOf("k")!=-1){
		unitee.replace("k","");
		unitee=parseFloat(unitee)
		if (isNaN(unitee)){
			unitee=0;
		}
		else{
		unitee=unitee*1000;
		}
		return unitee;
	}
	return unitee;
}
</script>
<?php
//fonction qui fait le calcule en temp réel de la barre
?>
	<SCRIPT language="JavaScript">
function calcul_bare(){
	//on va chercher les deux variable qui détermine la grosseur de nos boucles
	var nb_vendeur=document.forms["ressources"].elements["nb_vendeur"].value;
	var nb_acheteur=document.forms["ressources"].elements["nb_acheteur"].value;
	//on récupère les totaux voulu au quel on comparera les toteau qu'on à
	var metal_vendeur_total_voulu=document.forms["ressources"].elements["metal_vendeur_total_voulu"].value;
	var cristal_vendeur_total_voulu=document.forms["ressources"].elements["cristal_vendeur_total_voulu"].value;
	var deuterium_vendeur_total_voulu=document.forms["ressources"].elements["deuterium_vendeur_total_voulu"].value;
	var metal_acheteur_total_voulu=document.forms["ressources"].elements["metal_acheteur_total_voulu"].value;
	var cristal_acheteur_total_voulu=document.forms["ressources"].elements["cristal_acheteur_total_voulu"].value;
	var deuterium_acheteur_total_voulu=document.forms["ressources"].elements["deuterium_acheteur_total_voulu"].value;
	//on inicialise les tableaux
	var pseudo_vendeur=new Array;
	var metal_vendeur=new Array;
	var cristal_vendeur=new Array;
	var deuterium_vendeur=new Array;
	
	var pseudo_acheteur=new Array;
	var metal_acheteur=new Array;
	var cristal_acheteur=new Array;
	var deuterium_acheteur=new Array;
	//on inicialise les autre variable
	var metal_vendeur_total=new Number;
	var cristal_vendeur_total=new Number;
	var deuterium_vendeur_total=new Number;
	var metal_acheteur_total=new Number;
	var cristal_acheteur_total=new Number;
	var deuterium_acheteur_total=new Number;
	//on récupère les tableau
	for (var i=1;i<=nb_vendeur;i=i+1){
		pseudo_vendeur[i]=document.forms["ressources"].elements["pseudo_vendeur["+i+"]"].value;
		metal_vendeur[i]=document.forms["ressources"].elements["metal_vendeur["+i+"]"].value;
		cristal_vendeur[i]=document.forms["ressources"].elements["cristal_vendeur["+i+"]"].value;
		deuterium_vendeur[i]=document.forms["ressources"].elements["deuterium_vendeur["+i+"]"].value;
	}
	for (var i=1;i<=nb_acheteur;i=i+1){
		pseudo_acheteur[i]=document.forms["ressources"].elements["pseudo_acheteur["+i+"]"].value;
		metal_acheteur[i]=document.forms["ressources"].elements["metal_acheteur["+i+"]"].value;
		cristal_acheteur[i]=document.forms["ressources"].elements["cristal_acheteur["+i+"]"].value;
		deuterium_acheteur[i]=document.forms["ressources"].elements["deuterium_acheteur["+i+"]"].value;
	}
	//on aplique les fonction qui gère les virgules
	metal_vendeur_total_voulu=javascript_unitee(javascript_virguleapoint(metal_vendeur_total_voulu));
	cristal_vendeur_total_voulu=javascript_unitee(javascript_virguleapoint(cristal_vendeur_total_voulu));
	deuterium_vendeur_total_voulu=javascript_unitee(javascript_virguleapoint(deuterium_vendeur_total_voulu));
	metal_acheteur_total_voulu=javascript_unitee(javascript_virguleapoint(metal_acheteur_total_voulu));
	cristal_acheteur_total_voulu=javascript_unitee(javascript_virguleapoint(cristal_acheteur_total_voulu));
	deuterium_acheteur_total_voulu=javascript_unitee(javascript_virguleapoint(deuterium_acheteur_total_voulu));
	
	for (var i=1;i<=nb_vendeur;i=i+1){
		metal_vendeur[i]=javascript_unitee(javascript_virguleapoint(metal_vendeur[i]));
		cristal_vendeur[i]=javascript_unitee(javascript_virguleapoint(cristal_vendeur[i]));
		deuterium_vendeur[i]=javascript_unitee(javascript_virguleapoint(deuterium_vendeur[i]));
	}
	for (var i=1;i<=nb_acheteur;i=i+1){
		metal_acheteur[i]=javascript_unitee(javascript_virguleapoint(metal_acheteur[i]));
		cristal_acheteur[i]=javascript_unitee(javascript_virguleapoint(cristal_acheteur[i]));
		deuterium_acheteur[i]=javascript_unitee(javascript_virguleapoint(deuterium_acheteur[i]));
	}
	//on fait le total de toute les ressources
	for (var i=1;i<=nb_vendeur;i=i+1){
		metal_vendeur_total=parseInt(metal_vendeur_total)+parseInt(metal_vendeur[i]);
		cristal_vendeur_total=parseInt(cristal_vendeur_total)+parseInt(cristal_vendeur[i]);
		deuterium_vendeur_total=parseInt(deuterium_vendeur_total)+parseInt(deuterium_vendeur[i]);
	}
	for (var i=1;i<=nb_acheteur;i=i+1){
		metal_acheteur_total=parseInt(metal_acheteur_total)+parseInt(metal_acheteur[i]);
		cristal_acheteur_total=parseInt(cristal_acheteur_total)+parseInt(cristal_acheteur[i]);
		deuterium_acheteur_total=parseInt(deuterium_acheteur_total)+parseInt(deuterium_acheteur[i]);
	}
	//on trouve la diférence
	var difference_metal_vendeur=parseInt(metal_vendeur_total)-parseInt(metal_vendeur_total_voulu);
	var difference_cristal_vendeur=parseInt(cristal_vendeur_total)-parseInt(cristal_vendeur_total_voulu);
	var difference_deuterium_vendeur=parseInt(deuterium_vendeur_total)-parseInt(deuterium_vendeur_total_voulu);
	var difference_metal_acheteur=parseInt(metal_acheteur_total)-parseInt(metal_acheteur_total_voulu);
	var difference_cristal_acheteur=parseInt(cristal_acheteur_total)-parseInt(cristal_acheteur_total_voulu);
	var difference_deuterium_acheteur=parseInt(deuterium_acheteur_total)-parseInt(deuterium_acheteur_total_voulu);
	//on affiche le résultat
	if (difference_metal_vendeur<0){
	document.getElementById('metal_vendeur').innerHTML = '<font color="#FF0000">'+difference_metal_vendeur+'</font>';
	}
	if (difference_metal_vendeur==0){
	document.getElementById('metal_vendeur').innerHTML = '<font color="#00FF00">'+difference_metal_vendeur+'</font>';
	}
	if (difference_metal_vendeur>0){
	document.getElementById('metal_vendeur').innerHTML = '<font color="#0000FF">'+difference_metal_vendeur+'</font>';
	}
	if (difference_cristal_vendeur<0){
	document.getElementById('cristal_vendeur').innerHTML = '<font color="#FF0000">'+difference_cristal_vendeur+'</font>';
	}
	if (difference_cristal_vendeur==0){
	document.getElementById('cristal_vendeur').innerHTML = '<font color="#00FF00">'+difference_cristal_vendeur+'</font>';
	}
	if (difference_cristal_vendeur>0){
	document.getElementById('cristal_vendeur').innerHTML = '<font color="#0000FF">'+difference_cristal_vendeur+'</font>';
	}
	if (difference_deuterium_vendeur<0){
	document.getElementById('deuterium_vendeur').innerHTML = '<font color="#FF0000">'+difference_deuterium_vendeur+'</font>';
	}
	if (difference_deuterium_vendeur==0){
	document.getElementById('deuterium_vendeur').innerHTML = '<font color="#00FF00">'+difference_deuterium_vendeur+'</font>';
	}
	if (difference_deuterium_vendeur>0){
	document.getElementById('deuterium_vendeur').innerHTML = '<font color="#0000FF">'+difference_deuterium_vendeur+'</font>';
	}
	if (difference_metal_acheteur<0){
	document.getElementById('metal_acheteur').innerHTML = '<font color="#FF0000">'+difference_metal_acheteur+'</font>';
	}
	if (difference_metal_acheteur==0){
	document.getElementById('metal_acheteur').innerHTML = '<font color="#00FF00">'+difference_metal_acheteur+'</font>';
	}
	if (difference_metal_acheteur>0){
	document.getElementById('metal_acheteur').innerHTML = '<font color="#0000FF">'+difference_metal_acheteur+'</font>';
	}
	if (difference_cristal_acheteur<0){
	document.getElementById('cristal_acheteur').innerHTML = '<font color="#FF0000">'+difference_cristal_acheteur+'</font>';
	}
	if (difference_cristal_acheteur==0){
	document.getElementById('cristal_acheteur').innerHTML = '<font color="#00FF00">'+difference_cristal_acheteur+'</font>';
	}
	if (difference_cristal_acheteur>0){
	document.getElementById('cristal_acheteur').innerHTML = '<font color="#0000FF">'+difference_cristal_acheteur+'</font>';
	}
	if (difference_deuterium_acheteur<0){
	document.getElementById('deuterium_acheteur').innerHTML = '<font color="#FF0000">'+difference_deuterium_acheteur+'</font>';
	}
	if (difference_deuterium_acheteur==0){
	document.getElementById('deuterium_acheteur').innerHTML = '<font color="#00FF00">'+difference_deuterium_acheteur+'</font>';
	}
	if (difference_deuterium_acheteur>0){
	document.getElementById('deuterium_acheteur').innerHTML = '<font color="#0000FF">'+difference_deuterium_acheteur+'</font>';
	}
}
</script>
<?php
/**
 * Fonction qui fait les infobulle
 *récupéré de mon mad aide au comerce aussi
 *encors merci a oXid_FoX pour la fonction
 */
function infobulle($txt_contenu, $titre = 'Aide', $largeur = '200') {
	// remplace ' par \'
	// puis remplace \\' par \'
	// au cas où le guillemet simple aurait déjà été protégé avant l'appel à la fonction
	$txt_contenu = str_replace('\\\\\'','\\\'',str_replace('\'','\\\'',$txt_contenu));
	// remplace le guillemet double par son code HTML
	$txt_contenu = str_replace('"','&quot;',$txt_contenu);

	// pareil avec $titre
	$titre = str_replace('\\\\\'','\\\'',str_replace('\'','\\\'',$titre));
	$titre = str_replace('"','&quot;',$titre);

	// tant qu'on y est, vérification de $largeur
	if (!is_numeric($largeur))
	  $largeur = 200;

	// affiche l'infobulle
	echo '<img style="cursor: pointer;" src="images/help_2.png" onMouseOver="this.T_WIDTH=210;this.T_TEMP=0;return escape(\'<table width=&quot;',$largeur
	,'&quot;><tr><td align=&quot;center&quot; class=&quot;c&quot;>',$titre,'</td></tr><tr><th align=&quot;center&quot;>',$txt_contenu,'</th></tr></table>\')">';
}

//Fonction remplasser les virgule par un point (récupéré de mon mad aide au comerce)
function virguleapoint($unitée){
if (preg_match("#,#", "$unitée")){
	$unitée = preg_replace("#,#", '.', $unitée);
	return "$unitée";
	}
return "$unitée";
}
//finction de traitement des unitées
function unitée($unitée){
if (preg_match("#k|kilo#i", "$unitée")){
	$unitée = preg_replace("#k|kilo#i", '', $unitée);
	$unitée = $unitée*1000;
	return "$unitée";
	}
else if (preg_match("#m|kk|million#i", "$unitée")){
	$unitée = preg_replace("#m|kk|million#i", '', $unitée);
	$unitée = $unitée*1000000;
	return "$unitée";
}
return "$unitée";
}
?>