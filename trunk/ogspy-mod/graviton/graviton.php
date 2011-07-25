<?php
/**
* graviton.php Fichier principal
* @package MOD Graviton
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");

$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='graviton' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//recuperaiton du dossier, et de la version
$query = "SELECT root, version FROM `" . TABLE_MOD . "` WHERE `action`='graviton'";
$result = $db->sql_fetch_assoc($db->sql_query($query));
$dir = $result['root'];

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_technology = $user_empire["technology"];
$nb_planete = find_nb_planete_user();
($server_config['speed_uni'] > 0) ? $vitesse_uni = $server_config['speed_uni'] : $vitesse_uni = 1;
?>
<script <?php echo 'src="mod/'.$dir.'/function.js"'; ?> ></script>
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

$j = 1;
for ($i=101;$i<=100+$nb_planete;$i++)
{
	if ($user_building[$i]['planet_name'] != '')
	{
		echo "batimentsOGSpy[".$j."]= new Array('".
			$user_building[$i]['planet_name']."','".
			floor(($user_building[$i]["temperature_max"] + $user_building[$i]["temperature_min"])/2)."','".
			$user_building[$i]['CES']."','".
			$user_building[$i]['CEF']."','".
			$user_building[$i]['UdN']."','".
			$user_building[$i]['CSp']."','".
			$user_building[$i]['Sat']."','".
			$user_building[$i]['Lab']."','".
			$user_building[$i]['UdR']."',1);\n";
		$j = $j + 1;
	}
}
echo 'nb_planete = '.$nb_planete.';';
echo 'vitesse_uni = '.$vitesse_uni.';';
if ($user_technology['Graviton'] <> '') {echo "graviton=".$user_technology['Graviton'].";\n";}
else {echo "graviton=0;\n";}

?>
function chargement ()
{
<?php
for ($i=1;$i<= $nb_planete;$i++)
	{
		
		echo "document.getElementById('CES".$i."').value = batimentsOGSpy[".$i."][2];\n";
		echo "document.getElementById('CEF".$i."').value = batimentsOGSpy[".$i."][3];\n";
		echo "document.getElementById('UdN".$i."').value = batimentsOGSpy[".$i."][4];\n";
		echo "document.getElementById('CSp".$i."').value = batimentsOGSpy[".$i."][5];\n";
		echo "document.getElementById('Sat".$i."').value = batimentsOGSpy[".$i."][6];\n";
		echo "document.getElementById('Lab".$i."').value = batimentsOGSpy[".$i."][7];\n";
		echo "document.getElementById('UdR".$i."').value = batimentsOGSpy[".$i."][8];\n";
	}
	echo "document.getElementById('niv_graviton').value= graviton + 1 ;\n";
?>

verif_all ();
}
function verif_all() {
for (i=1;i<=nb_planete;i++) {
verif_donnee(i);}}
function verif_donnee(planete) {
<?php 
 $bat2 = array('CES','CEF','UdN','CSp','Lab','UdR');
 $php = array(2,3,4,5,7,8);
 for ($b=0;$b<=5;$b++){
 		 echo "if ((parseFloat(document.getElementById('".$bat2[$b]."' + planete).value) < parseFloat(batimentsOGSpy[planete][".$php[$b]."])) || (isNaN(parseFloat(document.getElementById('".$bat2[$b]."' + planete).value)) && parseFloat(document.getElementById('".$bat2[$b]."' + planete).value) != '-')) {document.getElementById('".$bat2[$b]."' + planete).value = batimentsOGSpy[planete][".$php[$b]."];}\n";
 }?>
 	if ((isNaN(parseFloat(document.getElementById('Sat' + planete).value))) && (parseFloat(document.getElementById('Sat' + planete).value) != '-')) {document.getElementById('Sat' + planete).value = batimentsOGSpy[planete][6];}
 

 if ((parseFloat(document.getElementById('niv_graviton').value) == 0 ) || (isNaN(parseFloat(document.getElementById('niv_graviton').value)))) {	document.getElementById('niv_graviton').value = graviton +1;} 
recup_donne (planete);
}
function recup_donne(planete){
niv_bat = new Array;
niv_grav = parseFloat(document.getElementById('niv_graviton').value);
<?php
$bat = array("'Lab'","'CES'","'CEF'","'Sat'","'UdN'","'UdR'","'CSp'");
$bat2 = array('Lab','CES','CEF','Sat','UdN','UdR','CSp');
for ($b=0;$b<=6;$b++){
	echo "niv_bat[".$bat[$b]."] = new Array;\n";
	echo "niv_bat[".$bat[$b]."][planete] = parseFloat(document.getElementById('".$bat2[$b]."' + planete).value);\n";
}
?>
calcul (planete);
}
function ecrire(planete) {
	 	 document.getElementById('CES_pro' + planete).innerHTML = Prod['CES'][planete];
		 document.getElementById('CEF_pro' + planete).innerHTML = Prod['CEF'][planete];
		 document.getElementById('Sat_pro' + planete).innerHTML = Prod['Sat'][planete];
		
		 document.getElementById('NB_Sat' + planete).innerHTML =  format(Sat['nb_nec'][planete]);
		 document.getElementById('Sat_cristal' + planete).innerHTML =  format(Ress['Sat']['Cristal'][planete]);
		 document.getElementById('Sat_deut' + planete).innerHTML =  format(Ress['Sat']['Deut'][planete]);
//Laboratoire	
		 document.getElementById('Lab_niv_manquant' + planete).innerHTML = (niv_lab[planete] - batimentsOGSpy[planete][7]);
		 document.getElementById('Lab_metal' + planete).innerHTML = format(Ress['Lab']['Metal'][planete]);
		 document.getElementById('Lab_cristal' + planete).innerHTML = format(Ress['Lab']['Cristal'][planete]);
		 document.getElementById('Lab_deut' + planete).innerHTML = format(Ress['Lab']['Deut'][planete]);
		 document.getElementById('lab_temps' + planete).innerHTML = format(Temps['Lab'][planete]);
		 document.getElementById('lab_temps_conv' + planete).innerHTML = conv_temps (Temps['Lab'][planete]);
//centrale		
		 document.getElementById('Cen_metal' + planete).innerHTML = format(Ress['Centrale']['Metal'][planete]);
		 document.getElementById('Cen_cristal' + planete).innerHTML = format(Ress['Centrale']['Cristal'][planete]);
		 document.getElementById('Cen_deut' + planete).innerHTML = format(Ress['Centrale']['Deut'][planete]);
		 document.getElementById('Cen_temps' + planete).innerHTML = format(Temps['Centrale'][planete])+' s';
		 document.getElementById('Cen_temps_conv' + planete).innerHTML = conv_temps (Temps['Centrale'][planete]);
//Usine
		 document.getElementById('Usi_metal' + planete).innerHTML = format(Ress['Usine']['Metal'][planete]);
		 document.getElementById('Usi_cristal' + planete).innerHTML = format(Ress['Usine']['Cristal'][planete]);
		 document.getElementById('Usi_deut' + planete).innerHTML = format(Ress['Usine']['Deut'][planete]);
		 document.getElementById('Usi_temps' + planete).innerHTML = format(Temps['Usine'][planete])+' s';
		 document.getElementById('Usi_temps_conv' + planete).innerHTML = conv_temps (Temps['Usine'][planete]);
//Temps	Sat	
		 document.getElementById('Sat_temps_un' + planete).innerHTML = format(Temps['Sat_un'][planete]) + ' s';
		 document.getElementById('Sat_temps' + planete).innerHTML = format(Temps['Sat'][planete]) + ' s';
		 document.getElementById('Sat_temps_conv' + planete).innerHTML = conv_temps (Temps['Sat'][planete]);
//Totale		
		 document.getElementById('met_tot' + planete).innerHTML = format(Ress['Total']['Metal'][planete]);
		 document.getElementById('crist_tot' + planete).innerHTML = format(Ress['Total']['Cristal'][planete]);
		 document.getElementById('deut_tot'+ planete).innerHTML = format(Ress['Total']['Deut'][planete]);
		 document.getElementById('temps_tot' + planete).innerHTML = format(Temps['Total'][planete]) + ' s';
		 document.getElementById('temps_tot_conv' + planete).innerHTML = conv_temps(Temps['Total'][planete]);
}
window.onload = chargement;
</script>
<?php $largeur=190+(106*$nb_planete)+106;
echo "<table width=".$largeur." >";?>
<tr>
	<td class="c" <?php echo 'colspan="'.($nb_planete + 2).'"'; ?> >Simulation Graviton niv <input type='text' id='niv_graviton' size='2' maxlength='2' onBlur="javascript:verif_all ()" value='1'> <input type="submit" value="Restaurer les données" onClick="javascript:chargement()"></td>
</tr>
<tr>
	<th width="190"><a>Nom</a></th>
<?php
for ($i=101 ; $i<=100+find_nb_planete_user() ; $i++) {
	$name = $user_building[$i]["planet_name"];
	if ($name == "") $name = "&nbsp;";

	echo "\t"."<th width='106'><a>".$name."</a></th>"."\n";
}
?>
<th width="106">Simulation</th>
</tr>
<tr>
	<th><a>Coordonnées</a></th>
<?php
for ($i=101 ; $i<=100+$nb_planete ; $i++) {
	$coordinates = $user_building[$i]["coordinates"];
	if ($coordinates == "") $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";

	echo "\t"."<th>".$coordinates."</th>"."\n";
}
?>
<th>0:00:00</th>
</tr>
<tr>
	<th><a>Température</a></th>
<?php
for ($i=101 ; $i<=100+ $nb_planete ; $i++) {
	$temperature[$i] = floor(($user_building[$i]["temperature_max"] + $user_building[$i]["temperature_min"])/2);
	if ($temperature[$i] == "") $temperature[$i] =0 ;

	echo "\t"."<th>".$temperature[$i]."</th>"."\n";
}
?>
<th><input type='text'  size='2' maxlength='2' <?php echo "id='temp".($nb_planete+1)."'  onBlur='javascript:verif_donnee (".($nb_planete+1).")'"; ?> value='0' disabled>
</tr>
<tr>
	<td class="c" <?php echo 'colspan="'.($nb_planete + 2).'"'; ?> >Bâtiments</td>
</tr>
<?php
$bati = array('Lab','UdR','UdN','CSp','CES','CEF');
$nom_bat=array('Laboratoire de recherche','Usine de robots','Usine de nanites','Chantier spatial','Centrale électrique solaire','Centrale électrique de fusion');
for ($b=0;$b<=5;$b++) {
	echo "<tr><th><a>".$nom_bat[$b]."</a></th>";
	for ($i=1 ; $i<=($nb_planete) ; $i++) {
		echo "\t"."<th><input type='text' id='".$bati[$b].$i."' size='2' maxlength='2' onBlur=\"javascript:verif_donnee (".$i.")\" value='0'></th>"."\n";
	}
		echo "\t"."<th><input type='text' id='".$bati[$b].($nb_planete + 1)."' size='2' maxlength='2' onBlur=\"javascript:verif_donnee (".($nb_planete + 1).")\" value='0' disabled></th>"."\n";
		echo "</tr>";
}
?>
<tr>
	<th><a>Satellite solaire</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><input type='text' id='Sat".$i."' size='5' maxlength='5' onBlur='javascript:verif_donnee (".$i.")' value='0'></th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" <?php echo 'colspan="'.($nb_planete + 2).'"'; ?> >Production théorique d'énergie</td>
</tr>
<tr>
	<th><a>Centrale électrique solaire</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='CES_pro".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Centrale électrique de fusion</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='CEF_pro".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Satellite solaire</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_pro".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<td class="c" <?php echo 'colspan="'.($nb_planete + 2).'"'; ?> >Bâtiments nécessaire Laboratoire de recherche niv 12</td>
</tr>
<tr>
	<th><a>Nombre de niveau manquant</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Lab_niv_manquant".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Métal</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Lab_metal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Cristal</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Lab_cristal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Deutérium</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Lab_deut".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='lab_temps".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='lab_temps_conv".$i."'></span></font></th>"."\n";
	}
?>
</tr>
<tr>
	<td class="c" <?php echo 'colspan="'.($nb_planete + 2).'"'; ?> >Bâtiments</td>
</tr>
<tr>
	<td class="c" <?php echo 'colspan="'.($nb_planete + 2).'"'; ?> >Usine de nanites, usine de robots, chantier spatial</td>
</tr>
<tr>
	<th><a>Métal</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Usi_metal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Cristal</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Usi_cristal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Deutérium</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Usi_deut".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Usi_temps".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Usi_temps_conv".$i."'></span></font></th>"."\n";
	}
?>
</tr>
<tr>
	<td class="c" <?php echo 'colspan="'.($nb_planete + 2).'"'; ?> >Centrale électrique solaire, centrale électrique de fusion</td>
</tr>
<tr>
	<th><a>Métal</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Cen_metal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Cristal</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Cen_cristal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Deutérium</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Cen_deut".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Cen_temps".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Cen_temps_conv".$i."'></span></font></th>"."\n";
	}
?>
</tr>
<tr>
	<td class="c" <?php echo 'colspan="'.($nb_planete + 2).'"'; ?> >Satellites nécessaires</td>
</tr>
<tr>
	<th><a>Nombres</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='NB_Sat".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Cristal</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_cristal".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Deutérium</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_deut".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps construction un satellite</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_temps_un".$i."'></span></font></th>"."\n";
	
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_temps".$i."'></span></font></th>"."\n";
}
?>
</tr>

<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='Sat_temps_conv".$i."'></span></font></th>"."\n";
	}
?>
</tr>
<tr>
	<td class="c" <?php echo 'colspan="'.($nb_planete + 2).'"'; ?> >Ressources totales nécessaires</td>
</tr>

<tr>
	<th><a>Métal</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='met_tot".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Cristal</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='crist_tot".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Deutérium</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='deut_tot".$i."'></span></font></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='temps_tot".$i."'></span></font></th>"."\n";
}
?>
</tr>

<tr>
	<th><a>Temps</a></th>
<?php
for ($i=1 ; $i<=($nb_planete) ; $i++) {
	echo "\t"."<th><font color='lime'><span id='temps_tot_conv".$i."'></span></font></th>"."\n";
	}
?>
</tr></table>
<br/>
<div align=center><font size=2>Graviton développé <?php echo $result['version']; ?> par <a href=mailto:kalnightmare@free.fr>Kal Nightmare</a> &copy;2006</font></div>

<table>
<tr><td>
<?php
require_once("views/page_tail.php");
?>