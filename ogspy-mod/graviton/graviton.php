<?php
/***************************************************************************
*	filename	: graviton.php
*	desc.		:
*	Author		: Kal Nightmare - http://ogs.servebbs.net/
*	created		: 25/07/2006
*	modified	: 13/08/2006 12:47:19
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='graviton' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_technology = $user_empire["technology"];
?>
<script src="mod/graviton/function.js"></script>
<script type="text/javascript">
var batimentsOGSpy = new Array();
Prod = new Array ();
Ress = new Array();
Temps = new Array();
Sat = new Array();
niv_lab = new Array();
<?php
$array = array("'CES'","'CEF'","'Sat'","'tot'","'prod_un'","'nb_nec'","'Sat'","'Lab'","'CES'","'CEF'","'Centrale'","'UdN'","'UdR'","'CSp'","'Usine'","'Total'","'Lab'","'Sat_un'","'Sat'","'Centrale'","'CSp'","'UdN'","'UdR'","'Usine'","'Total'");
for($i=0;$i<=3;$i++){echo "Prod[".$array[$i]."]=new Array();\n";}
for($i=4;$i<=5;$i++){echo "Sat[".$array[$i]."]=new Array();\n";}
for($i=6;$i<=15;$i++){echo "Ress[".$array[$i]."]=new Array();\n";}
for($i=16;$i<=24;$i++){echo "Temps[".$array[$i]."]=new Array();\n";}

$ressource= array ('Metal','Cristal','Deut');
for ($i=0;$i<=2;$i++){
echo "Ress['Sat']['".$ressource[$i]."'] = new Array;\n";
echo "Ress['Lab']['".$ressource[$i]."'] = new Array;\n";
echo "Ress['CES']['".$ressource[$i]."'] = new Array;\n";
echo "Ress['CEF']['".$ressource[$i]."'] = new Array;\n";
echo "Ress['Centrale']['".$ressource[$i]."'] = new Array;\n";
echo "Ress['UdN']['".$ressource[$i]."'] = new Array;\n";
echo "Ress['UdR']['".$ressource[$i]."'] = new Array;\n";
echo "Ress['CSp']['".$ressource[$i]."'] = new Array;\n";
echo "Ress['Usine']['".$ressource[$i]."'] = new Array;\n";
echo "Ress['Total']['".$ressource[$i]."'] = new Array;\n";
}

$j=1;
for ($i=1;$i<=9;$i++)
{
	if ($user_building[$i]['planet_name'] != '')
	{
		echo "batimentsOGSpy[".$i."]= new Array('".
			$user_building[$i]['planet_name']."','".
			$user_building[$i]['temperature']."','".
			$user_building[$i]['CES']."','".
			$user_building[$i]['CEF']."','".
			$user_building[$i]['UdN']."','".
			$user_building[$i]['CSp']."','".
			$user_building[$i]['Sat']."','".
			$user_building[$i]['Lab']."','".
			$user_building[$i]['UdR']."');\n";
				
	} else {
		echo "batimentsOGSpy[".$i."]= new Array('NC','-','-','-','-','-','-','-','-');\n";
	}
}
if ($user_technology['Graviton'] <> '') {echo "graviton=".$user_technology['Graviton'].";\n";}
else {echo "graviton=0;\n";}
?>
function chargement ()
{
<?php
for ($i=1;$i<=9;$i++)
	{
		echo "document.getElementById('CES".$i."').value = batimentsOGSpy[".$i."][2];\n";
		echo "document.getElementById('CEF".$i."').value = batimentsOGSpy[".$i."][3];\n";
		echo "document.getElementById('UdN".$i."').value = batimentsOGSpy[".$i."][4];\n";
		echo "document.getElementById('CSp".$i."').value = batimentsOGSpy[".$i."][5];\n";
		echo "document.getElementById('Sat".$i."').value = batimentsOGSpy[".$i."][6];\n";
		echo "document.getElementById('Lab".$i."').value = batimentsOGSpy[".$i."][7];\n";
		echo "document.getElementById('UdR".$i."').value = batimentsOGSpy[".$i."][8];\n";
	}
	echo "document.getElementById('niv_graviton').value= graviton +1 ;\n";
?>
verif_donnee ();
}
function verif_donnee() {
<?php 
 $bat2 = array('CES','CEF','UdN','CSp','Lab','UdR');
 $php = array(2,3,4,5,7,8);
 for ($b=0;$b<=5;$b++){
 	for ($i=1;$i<=9;$i++){
		 echo "if ((parseFloat(document.getElementById('".$bat2[$b].$i."').value) < parseFloat(batimentsOGSpy[".$i."][".$b."])) || (isNaN(parseFloat(document.getElementById('".$bat2[$b].$i."').value)) && parseFloat(document.getElementById('".$bat2[$b].$i."').value) != '-')) {document.getElementById('".$bat2[$b].$i."').value = batimentsOGSpy[".$i."][".$php[$b]."];}\n";
	}
 }
 for ($i=1;$i<=9;$i++){
 	echo "if ((isNaN(parseFloat(document.getElementById('Sat".$i."').value))) && (parseFloat(document.getElementById('Sat".$i."').value) != '-')) {document.getElementById('Sat".$i."').value = batimentsOGSpy[".$i."][6];}\n";
 }
?>
 if ((parseFloat(document.getElementById('niv_graviton').value) == 0 ) || (isNaN(parseFloat(document.getElementById('niv_graviton').value)))) {	document.getElementById('niv_graviton').value = graviton +1;} 
recup_donne ();
}
function recup_donne(){
niv_bat = new Array;
niv_grav = parseFloat(document.getElementById('niv_graviton').value);
<?php
$bat = array("'Lab'","'CES'","'CEF'","'Sat'","'UdN'","'UdR'","'CSp'");
$bat2 = array('Lab','CES','CEF','Sat','UdN','UdR','CSp');
for ($b=0;$b<=6;$b++){
	echo "niv_bat[".$bat[$b]."] = new Array;\n";
	for ($i=1;$i<=9;$i++){
		echo "niv_bat[".$bat[$b]."][".$i."] = parseFloat(document.getElementById('".$bat2[$b].$i."').value);\n";
	}
}
?>
calcul ();
}
function ecrire() {
<?php 
for ($i=1;$i<=9;$i++) {	
	echo "if (batimentsOGSpy[".$i."][0] != 'NC') {\n";
		echo "document.getElementById('CES_pro".$i."').innerHTML = Prod['CES'][".$i."];\n";
		echo "document.getElementById('CEF_pro".$i."').innerHTML = Prod['CEF'][".$i."];\n";
		echo "document.getElementById('Sat_pro".$i."').innerHTML = Prod['Sat'][".$i."];\n";
		
		echo "document.getElementById('NB_Sat".$i."').innerHTML =  format(Sat['nb_nec'][".$i."]);\n";
		echo "document.getElementById('Sat_cristal".$i."').innerHTML =  format(Ress['Sat']['Cristal'][".$i."]);\n";
		echo "document.getElementById('Sat_deut".$i."').innerHTML =  format(Ress['Sat']['Deut'][".$i."]);\n";
//Laboratoire	
		echo "document.getElementById('Lab_niv_manquant".$i."').innerHTML = (niv_lab[".$i."] - batimentsOGSpy[".$i."][7]);\n";
		echo "document.getElementById('Lab_metal".$i."').innerHTML = format(Ress['Lab']['Metal'][".$i."]);\n";
		echo "document.getElementById('Lab_cristal".$i."').innerHTML = format(Ress['Lab']['Cristal'][".$i."]);\n";
		echo "document.getElementById('Lab_deut".$i."').innerHTML = format(Ress['Lab']['Deut'][".$i."]);\n";
		echo "document.getElementById('lab_temps".$i."').innerHTML = format(Temps['Lab'][".$i."]);\n";
		echo "document.getElementById('lab_temps_conv".$i."').innerHTML = conv_temps (Temps['Lab'][".$i."]);\n";
//centrale		
		echo "document.getElementById('Cen_metal".$i."').innerHTML = format(Ress['Centrale']['Metal'][".$i."]);\n";
		echo "document.getElementById('Cen_cristal".$i."').innerHTML = format(Ress['Centrale']['Cristal'][".$i."]);\n";
		echo "document.getElementById('Cen_deut".$i."').innerHTML = format(Ress['Centrale']['Deut'][".$i."]);\n";
		echo "document.getElementById('Cen_temps".$i."').innerHTML = format(Temps['Centrale'][".$i."])+' s';\n";
		echo "document.getElementById('Cen_temps_conv".$i."').innerHTML = conv_temps (Temps['Centrale'][".$i."]);\n";
//Usine
		echo "document.getElementById('Usi_metal".$i."').innerHTML = format(Ress['Usine']['Metal'][".$i."]);\n";
		echo "document.getElementById('Usi_cristal".$i."').innerHTML = format(Ress['Usine']['Cristal'][".$i."]);\n";
		echo "document.getElementById('Usi_deut".$i."').innerHTML = format(Ress['Usine']['Deut'][".$i."]);\n";
		echo "document.getElementById('Usi_temps".$i."').innerHTML = format(Temps['Usine'][".$i."])+' s';\n";
		echo "document.getElementById('Usi_temps_conv".$i."').innerHTML = conv_temps (Temps['Usine'][".$i."]);\n";
//Temps	Sat	
		echo "document.getElementById('Sat_temps_un".$i."').innerHTML = format(Temps['Sat_un'][".$i."]) + ' s';\n";
		echo "document.getElementById('Sat_temps".$i."').innerHTML = format(Temps['Sat'][".$i."]) + ' s';\n";
		echo "document.getElementById('Sat_temps_conv".$i."').innerHTML = conv_temps (Temps['Sat'][".$i."]);\n";
//Totale		
		echo "document.getElementById('met_tot".$i."').innerHTML = format(Ress['Total']['Metal'][".$i."]);\n";
		echo "document.getElementById('crist_tot".$i."').innerHTML = format(Ress['Total']['Cristal'][".$i."]);\n";
		echo "document.getElementById('deut_tot".$i."').innerHTML = format(Ress['Total']['Deut'][".$i."]);\n";
		echo "document.getElementById('temps_tot".$i."').innerHTML = format(Temps['Total'][".$i."]) + ' s';\n";
		echo "document.getElementById('temps_tot_conv".$i."').innerHTML = conv_temps(Temps['Total'][".$i."]);\n";
		
		echo "}\n"; 


} ?>
}
window.onload = chargement;
</script>
<table width="100%">
<tr>
	<td class="c" colspan="10">Simulation Graviton niv <input type='text' id='niv_graviton' size='2' maxlength='2' onBlur="javascript:verif_donnee ()" value='1'> <input type="submit" value="Restaurer les données" onClick="javascript:chargement ()"></td>
</tr>
<tr>
	<th><a>Nom</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	if ($name == "") $name = "&nbsp;";

	echo "\t"."<th><a>".$name."</a></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Coordonnées</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$coordinates = $user_building[$i]["coordinates"];
	if ($coordinates == "") $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";

	echo "\t"."<th>".$coordinates."</th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Température</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	$temperature[$i] = $user_building[$i]["temperature"];
	if ($temperature[$i] == "") $temperature[$i] =0 ;

	echo "\t"."<th>".$temperature[$i]."</th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" colspan="10">Bâtiments</td>
</tr>
<?php
$bati = array('Lab','UdR','UdN','CSp','CES','CEF');
$nom_bat=array('Laboratoire de recherche','Usine de robots','Usine de nanites','Chantier spatial','Centrale électrique solaire','Centrale électrique de fusion');
for ($b=0;$b<=5;$b++) {
	echo "<tr><th><a>".$nom_bat[$b]."</a></th>";
	for ($i=1 ; $i<=9 ; $i++) {
		echo "\t"."<th><input type='text' id='".$bati[$b].$i."' size='2' maxlength='2' onBlur=\"javascript:verif_donnee ()\" value='0'></th>"."\n";
	}
	echo "</tr>";
}
?>
<tr>
	<th><a>Satellite solaire</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><input type='text' id='Sat".$i."' size='5' maxlength='5' onBlur='javascript:verif_donnee ()' value='0'></th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" colspan="10">Production théorique d'énergie</td>
</tr>
<tr>
	<th><a>Centrale électrique solaire</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='CES_pro".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Centrale électrique de fusion</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='CEF_pro".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Satellite solaire</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_pro".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" colspan="10">Batiement nécessaire Laboratoire de recherche niv 12</td>
</tr>
<tr>
	<th><a>Nombre de niveau manquant</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Lab_niv_manquant".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Métal</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Lab_metal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Cristal</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Lab_cristal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Deutérium</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Lab_deut".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='lab_temps".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='lab_temps_conv".$i."'></span></font></th>"."\n";
	}
?>
</tr>
<tr>
	<td class="c" colspan="10">Batiement</td>
</tr>
<tr>
	<td class="c" colspan="10">Usine de nanites, usine de robots, chantier spatial</td>
</tr>
<tr>
	<th><a>Métal</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Usi_metal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Cristal</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Usi_cristal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Deutérium</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Usi_deut".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Usi_temps".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Usi_temps_conv".$i."'></span></font></th>"."\n";
	}
?>
</tr>
<tr>
	<td class="c" colspan="10">Centrale électrique solaire, centrale électrique de fusion</td>
</tr>
<tr>
	<th><a>Métal</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Cen_metal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Cristal</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Cen_cristal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Deutérium</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Cen_deut".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Cen_temps".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Cen_temps_conv".$i."'></span></font></th>"."\n";
	}
?>
</tr>
<tr>
	<td class="c" colspan="10">Satellites nécessaires</td>
</tr>
<tr>
	<th><a>Nombres</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='NB_Sat".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Cristal</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_cristal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Deutérium</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_deut".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps construction un satellite</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_temps_un".$i."'></span></font></th>"."\n";
	
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_temps".$i."'></span></font></th>"."\n";
}
?>
</tr>

<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_temps_conv".$i."'></span></font></th>"."\n";
	}
?>
</tr>
<tr>
	<td class="c" colspan="10">Ressources totales nécessaires</td>
</tr>

<tr>
	<th><a>Métal</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='met_tot".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Cristal</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='crist_tot".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Deutérium</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='deut_tot".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='temps_tot".$i."'></span></font></th>"."\n";
}
?>
</tr>

<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=9 ; $i++) {
	echo "\t"."<th><font color='lime'><span id='temps_tot_conv".$i."'></span></font></th>"."\n";
	}
?>
</tr>
<tr><td colspan="10">
<div align=center><font size=2>Graviton développé par <a href=mailto:kalnightmare@free.fr>Kal Nightmare</a> &copy;2006</font></div>
</td></tr></table>
<table>
<tr><td>
<?php
require_once("views/page_tail.php");
?>