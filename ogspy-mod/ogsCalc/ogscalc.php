<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require_once("views/page_header.php");

$result = $db->sql_query('SELECT `version`, `root` FROM `'.TABLE_MOD.'` WHERE `action`="'.$pub_action.'" AND `active`= 1');
if (!$db->sql_numrows($result)) die('Mod désactivé !');
list ( $mod_version, $mod_root ) = $db->sql_fetch_row($result);

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_technology = $user_empire["technology"];
?>

<script language="javascript" src="mod/<?php print $mod_root ?>/formule.js"></script>

<script type="text/javascript">
var batimentsOGSpy = new Array();

<?php
$j=0;
for ($i=1;$i<=9;$i++)
{
	if ($user_building[$i]['planet_name'] != '')
	{
		echo "batimentsOGSpy[".$j."]= new Array('".
			$user_building[$i]['planet_name']."','".
			$user_building[$i]['M']."','".
			$user_building[$i]['C']."','".
			$user_building[$i]['D']."','".
			$user_building[$i]['CES']."','".
			$user_building[$i]['CEF']."','".
			$user_building[$i]['UdR']."','".
			$user_building[$i]['UdN']."','".
			$user_building[$i]['CSp']."','".
			$user_building[$i]['HM']."','".
			$user_building[$i]['HC']."','".
			$user_building[$i]['HD']."','".
			$user_building[$i]['Lab']."','".
			$user_building[$i]['Silo']."','".
			$user_building[$i]['Ter']."','".
			$user_building[$i]['BaLu']."','".
			$user_building[$i]['Pha']."','".
			$user_building[$i]['PoSa']."');\n";
		$j++;		
	}
}

echo "technologiesOGSpy = new Array('".
		$user_technology['Esp']."','".
		$user_technology['Ordi']."','".
		$user_technology['Armes']."','".
		$user_technology['Bouclier']."','".
		$user_technology['Protection']."','".
		$user_technology['NRJ']."','".
		$user_technology['Hyp']."','".
		$user_technology['RC']."','".
		$user_technology['RI']."','".
		$user_technology['PH']."','".
		$user_technology['Laser']."','".
		$user_technology['Ions']."','".
		$user_technology['Plasma']."','".
		$user_technology['RRI']."','".
		$user_technology['Expeditions']."','".
		$user_technology['Graviton']."');\n";
?>

function chargement ()
{

	var i = 0;
	while (	(i<batimentsOGSpy.length) && (batimentsOGSpy[i][0] != document.getElementById('planete').options[document.getElementById('planete').selectedIndex].text) )
	{
		i++;
	}
	
	resetData();
	
	if (!(i == batimentsOGSpy.length))
	{
		document.getElementById('robot').value = batimentsOGSpy[i][6];
		document.getElementById('chantier').value= batimentsOGSpy[i][8];
		document.getElementById('nanite').value = batimentsOGSpy[i][7];
		
		k=1;
		for ( j=0; j<batimentsOGSpy.length; j++ )
		{
			if (i==j)
			{
				document.getElementById('labopm').value = batimentsOGSpy[j][12];
			} else {
				document.getElementById('labo'+k).value = batimentsOGSpy[j][12];
				k++;
			}
		}
		document.getElementById('reseau').value = technologiesOGSpy[13];
		laboEqui();
		
		for ( j=0 ; j<arrayBatiments.length; j++ )
		{
			bat = arrayBatiments[j]+"_actuel";
			document.getElementById(bat).value=batimentsOGSpy[i][j+1];
		}
		for ( j=0 ; j<arrayTechnologies.length; j++ )
		{
			bat = arrayTechnologies[j]+"_actuel";
			document.getElementById(bat).value=technologiesOGSpy[j];
		}
		document.getElementById('graviton_actuel').value=technologiesOGSpy[14];
	}
}
</script>

<center>

<fieldset><legend><b>Gestion</b></legend>
<div><input type="submit" value="Sauvegarder les données" onClick="javascript:sauvegarde()"> <input type="submit" value="Restaurer les données" onClick="javascript:restaure()"> <input type="submit" value="Changelog" onClick="javascript:inverse('changelog')"> <select id="planete" onChange="javascript:chargement()"><option>Planètes OGSpy</option>
<?php
for ($i=1;$i<=9;$i++)
{
	if ( $user_building[$i]['planet_name'] != '' )
	{
		echo "<option>".$user_building[$i]['planet_name']."</option>";
	}
}
?>
</select> <input type="submit" value="Reset" onClick="javascript:resetData()"></div>
<div id="changelog" style="display:none; text-align:left;">
<center><font size="5">Changelog</font></center>
	<b>18/04/2008</v>
<ol style="list-style-type: none;">
	<li>v0.5
	<ul type="disc">
		<li>Ajout du calcul des transports</li>
		<li>Ajout du script de désintallation</li>
		<li>Controle de sécurité pour éviter l'erreur de "Duplicate Entry"</li>
	</ul>
</ol>	
	<b>18/04/2008</v>
<ol style="list-style-type: none;">
	<li>v0.4d
	<ul type="disc">
		<li>Fix d'un bug à l'installation</li>
	</ul>
</ol>	
	<b>16/04/2008</v>
<ol style="list-style-type: none;">
	<li>v0.4c
	<ul type="disc">
		<li>Ajout de la technologie expéditions</li>
		<li>Modification du fichier install</li>
		<li>Correction du chemin pour atteindre formule.js</li>
	</ul>
</ol>	
    <b>04/03/2007</b>
<ol style="list-style-type: none;">
	<li>v0.4
	<ul type="disc">
		<li>Ajout du traqueur</li>
		<li>Correction du bug d'affichage qui ne permmetait pas de voir les ressources</li>
		<li>Modification du prix du traqueur</li>
		<li>Installation des Install/Update qui récupére le n° de version dans le fichier version.txt</li>
	</ul>
</ol>
    <b>09/08/2006</b>
<ol style="list-style-type: none;">
	<li>v0.3
	<ul type="disc">
		<li>Correction du problème des prix du terraformeur (merci ben_12)</li>
		<li>Correction du non-rafraichissement des temps si modifications du niveau de l'usine de robots et de nanites ou du chantier spatial</li>
	</ul>
</ol>
    <b>09/07/2006</b>
<ol style="list-style-type: none;">
	<li>v0.2
	<ul type="disc">
		<li>Correction d'un bug empêchant le calcul des technologies</li>
		<li>Correction d'un problème de calcul de l'énergie nécessaire au graviton (merci Corwin)</li>
		<li>Ajout de la fonction reset</li>
	</ul>
</ol>
    <b>08/07/2006</b>
<ol style="list-style-type: none;">
	<li>v0.1
	<ul type="disc">
		<li>Sortie d'OGSCalc en mod OGSpy</li>
	</ul>
</ol>
</div>
</fieldset>
<br>
<br>
<fieldset><legend><b>Vos technologies</b></legend>
<table>
<tr><td>
	<table>
	<tr>
	<td class="c" style="text-align:center">Usine de robot:</td><th><input type="text" id="robot" size="2" maxlength="2" value="0" onBlur="javascript:rafraichiRobot()"></th>
	</tr><tr>
	<td class="c" style="text-align:center">Chantier spatial:</td><th><input type="text" id="chantier" size="2" maxlength="2" value="0" onBlur="javascript:rafraichiChantier()"></th>
	</tr><tr>
	<td class="c" style="text-align:center">Usine de nanites:</td><th><input type="text" id="nanite" size="2" maxlength="2" value="0" onBlur="javascript:rafraichiRobot();rafraichiChantier()"></th>
	</tr>
	</table>
</td><td>
	<table>
	<tr><td class="c" style="text-align:center">
	Planète de développement:</td><th><input type="text" id="labopm" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()"></th>
	<td class="c" style="text-align:center" colspan="6">Laboratoires de recherche</td></tr>
	<tr><td class="c" style="text-align:center">
	Planète 1:</td><th><input type="text" id="labo1" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 2:</td><th><input type="text" id="labo2" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 3:</td><th><input type="text" id="labo3" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 4:</td><th><input type="text" id="labo4" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th></tr>
	<tr><td class="c" style="text-align:center">
	Planète 5:</td><th><input type="text" id="labo5" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 6:</td><th><input type="text" id="labo6" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 7:</td><th><input type="text" id="labo7" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th><td class="c" style="text-align:center">
	Planète 8:</td><th><input type="text" id="labo8" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">
	</th></tr>
	</table>
</td></tr><tr><td colspan="2" align="center">
	Réseau de recherche intergalactique: <input type="text" id="reseau" size="2" maxlength="2" value="0" onBlur="javascript:laboEqui()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Laboratoire équivalent: <input type="text" id="laboequi" size="2" maxlength="2" readonly value="0">
</td></tr></table>
</fieldset>
<br>
<br>
<fieldset><legend><b>Bâtiments</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Nom</td><td class="c" style="text-align:center">
Niveau actuel</td><td class="c" style="text-align:center">
Niveau voulu</td><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr>
<tr><th>
Mine de métal</th><th>
<input type="text" id="mine_metal_actuel" size="2" maxlength="2" onBlur="javascript:batiment('mine_metal',60,15,0,1.5);" value="0"></th><th>
<input type="text" id="mine_metal_voulu" size="2" maxlength="2" onBlur="javascript:batiment('mine_metal',60,15,0,1.5)" value="0"></th><th>
<input type="text" id="mine_metal_metal" size="15" readonly value="0"></th><th>
<input type="text" id="mine_metal_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="mine_metal_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="mine_metal_temps" size="15" readonly value="-">
<input type="hidden" id="mine_metal_sec" size="15" value="0"></th>
</tr><tr><th>
Mine de cristal</th><th>
<input type="text" id="mine_cristal_actuel" size="2" maxlength="2" onBlur="javascript:batiment('mine_cristal',48,24,0,1.6)" value="0"></th><th>
<input type="text" id="mine_cristal_voulu" size="2" maxlength="2" onBlur="javascript:batiment('mine_cristal',48,24,0,1.6)" value="0"></th><th>
<input type="text" id="mine_cristal_metal" size="15" readonly value="0"></th><th>
<input type="text" id="mine_cristal_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="mine_cristal_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="mine_cristal_temps" size="15" readonly value="-">
<input type="hidden" id="mine_cristal_sec" size="15" value="0"></th>
</tr><tr><th>
Synthétiseur de deutérium</th><th>
<input type="text" id="synthetiseur_deuterium_actuel" size="2" maxlength="2" onBlur="javascript:batiment('synthetiseur_deuterium',225,75,0,1.5)" value="0"></th><th>
<input type="text" id="synthetiseur_deuterium_voulu" size="2" maxlength="2" onBlur="javascript:batiment('synthetiseur_deuterium',225,75,0,1.5)" value="0"></th><th>
<input type="text" id="synthetiseur_deuterium_metal" size="15" readonly value="0"></th><th>
<input type="text" id="synthetiseur_deuterium_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="synthetiseur_deuterium_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="synthetiseur_deuterium_temps" size="15" readonly value="-">
<input type="hidden" id="synthetiseur_deuterium_sec" size="15" value="0"></th>
</tr><tr><th>
Centrale solaire</th><th>
<input type="text" id="centrale_solaire_actuel" size="2" maxlength="2" onBlur="javascript:batiment('centrale_solaire',75,30,0,1.5)" value="0"></th><th>
<input type="text" id="centrale_solaire_voulu" size="2" maxlength="2" onBlur="javascript:batiment('centrale_solaire',75,30,0,1.5)" value="0"></th><th>
<input type="text" id="centrale_solaire_metal" size="15" readonly value="0"></th><th>
<input type="text" id="centrale_solaire_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="centrale_solaire_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="centrale_solaire_temps" size="15" readonly value="-">
<input type="hidden" id="centrale_solaire_sec" size="15" value="0"></th>
</tr><tr><th>
Réacteur à fusion</th><th>
<input type="text" id="reacteur_fusion_actuel" size="2" maxlength="2" onBlur="javascript:batiment('reacteur_fusion',900,360,180,1.8)" value="0"></th><th>
<input type="text" id="reacteur_fusion_voulu" size="2" maxlength="2" onBlur="javascript:batiment('reacteur_fusion',900,360,180,1.8)" value="0"></th><th>
<input type="text" id="reacteur_fusion_metal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_fusion_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_fusion_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_fusion_temps" size="15" readonly value="-">
<input type="hidden" id="reacteur_fusion_sec" size="15" value="0"></th>
</tr><tr><th>
Usine de robots</th><th>
<input type="text" id="usine_robots_actuel" size="2" maxlength="2" onBlur="javascript:batiment('usine_robots',400,120,200,2)" value="0"></th><th>
<input type="text" id="usine_robots_voulu" size="2" maxlength="2" onBlur="javascript:batiment('usine_robots',400,120,200,2)" value="0"></th><th>
<input type="text" id="usine_robots_metal" size="15" readonly value="0"></th><th>
<input type="text" id="usine_robots_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="usine_robots_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="usine_robots_temps" size="15" readonly value="-">
<input type="hidden" id="usine_robots_sec" size="15" value="0"></th>
</tr><tr><th>
Usine de nanites</th><th>
<input type="text" id="usine_nanites_actuel" size="2" maxlength="2" onBlur="javascript:batiment('usine_nanites',1000000,500000,100000,2)" value="0"></th><th>
<input type="text" id="usine_nanites_voulu" size="2" maxlength="2" onBlur="javascript:batiment('usine_nanites',1000000,500000,100000,2)" value="0"></th><th>
<input type="text" id="usine_nanites_metal" size="15" readonly value="0"></th><th>
<input type="text" id="usine_nanites_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="usine_nanites_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="usine_nanites_temps" size="15" readonly value="-">
<input type="hidden" id="usine_nanites_sec" size="15" value="0"></th>
</tr><tr><th>
Chantier spatial</th><th>
<input type="text" id="chantier_spatial_actuel" size="2" maxlength="2" onBlur="javascript:batiment('chantier_spatial',400,200,100,2)" value="0"></th><th>
<input type="text" id="chantier_spatial_voulu" size="2" maxlength="2" onBlur="javascript:batiment('chantier_spatial',400,200,100,2)" value="0"></th><th>
<input type="text" id="chantier_spatial_metal" size="15" readonly value="0"></th><th>
<input type="text" id="chantier_spatial_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="chantier_spatial_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="chantier_spatial_temps" size="15" readonly value="-">
<input type="hidden" id="chantier_spatial_sec" size="15" value="0"></th>
</tr><tr><th>
Hangar de metal</th><th>
<input type="text" id="hangar_metal_actuel" size="2" maxlength="2" onBlur="javascript:batiment('hangar_metal',2000,0,0,2)" value="0"></th><th>
<input type="text" id="hangar_metal_voulu" size="2" maxlength="2" onBlur="javascript:batiment('hangar_metal',2000,0,0,2)" value="0"></th><th>
<input type="text" id="hangar_metal_metal" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_metal_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_metal_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_metal_temps" size="15" readonly value="-">
<input type="hidden" id="hangar_metal_sec" size="15" value="0"></th>
</tr><tr><th>
Hangar de cristal</th><th>
<input type="text" id="hangar_cristal_actuel" size="2" maxlength="2" onBlur="javascript:batiment('hangar_cristal',2000,1000,0,2)" value="0"></th><th>
<input type="text" id="hangar_cristal_voulu" size="2" maxlength="2" onBlur="javascript:batiment('hangar_cristal',2000,1000,0,2)" value="0"></th><th>
<input type="text" id="hangar_cristal_metal" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_cristal_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_cristal_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="hangar_cristal_temps" size="15" readonly value="-">
<input type="hidden" id="hangar_cristal_sec" size="15" value="0"></th>
</tr><tr><th>
Réservoir de deutérium</th><th>
<input type="text" id="reservoir_deuterium_actuel" size="2" maxlength="2" onBlur="javascript:batiment('reservoir_deuterium',2000,2000,0,2)" value="0"></th><th>
<input type="text" id="reservoir_deuterium_voulu" size="2" maxlength="2" onBlur="javascript:batiment('reservoir_deuterium',2000,2000,0,2)" value="0"></th><th>
<input type="text" id="reservoir_deuterium_metal" size="15" readonly value="0"></th><th>
<input type="text" id="reservoir_deuterium_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="reservoir_deuterium_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="reservoir_deuterium_temps" size="15" readonly value="-">
<input type="hidden" id="reservoir_deuterium_sec" size="15" value="0"></th>
</tr><tr><th>
Laboratoire</th><th>
<input type="text" id="laboratoire_actuel" size="2" maxlength="2" onBlur="javascript:batiment('laboratoire',200,400,200,2)" value="0"></th><th>
<input type="text" id="laboratoire_voulu" size="2" maxlength="2" onBlur="javascript:batiment('laboratoire',200,400,200,2)" value="0"></th><th>
<input type="text" id="laboratoire_metal" size="15" readonly value="0"></th><th>
<input type="text" id="laboratoire_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="laboratoire_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="laboratoire_temps" size="15" readonly value="-">
<input type="hidden" id="laboratoire_sec" size="15" value="0"></th>
</tr><tr><th>
Silo à missiles</th><th>
<input type="text" id="silo_missiles_actuel" size="2" maxlength="2" onBlur="javascript:batiment('silo_missiles',20000,20000,1000,2)" value="0"></th><th>
<input type="text" id="silo_missiles_voulu" size="2" maxlength="2" onBlur="javascript:batiment('silo_missiles',20000,20000,1000,2)" value="0"></th><th>
<input type="text" id="silo_missiles_metal" size="15" readonly value="0"></th><th>
<input type="text" id="silo_missiles_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="silo_missiles_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="silo_missiles_temps" size="15" readonly value="-">
<input type="hidden" id="silo_missiles_sec" size="15" value="0"></th>
</tr><tr><th>
Terraformeur</th><th>
<input type="text" id="terraformeur_actuel" size="2" maxlength="2" onBlur="javascript:batiment('terraformeur',1000,50000,100000,2)" value="0"></th><th>
<input type="text" id="terraformeur_voulu" size="2" maxlength="2" onBlur="javascript:batiment('terraformeur',1000,50000,100000,2)" value="0"></th><th>
<input type="text" id="terraformeur_metal" size="15" readonly value="0"></th><th>
<input type="text" id="terraformeur_cristal" size="15" readonly value="0"></th><th>
énergie:<input type="text" id="terraformeur_deuterium" size="15" readonly value="0"></td><th>
<input type="text" id="terraformeur_temps" size="15" readonly value="-">
<input type="hidden" id="terraformeur_sec" size="15" value="0"></th>
</tr><tr><td class="c" style="text-align:center" colspan="3">
TOTAL</td><th>
<input type="text" id="batiments_metal" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_temps" size="15" readonly value="-">
<input type="hidden" id="batiments_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
Un total de <span id="batiments_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="batiments_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="batiments_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset><br>
<fieldset><legend><b>Bâtiments spéciaux</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Nom</td><td class="c" style="text-align:center">
Niveau actuel</td><td class="c" style="text-align:center">
Niveau voulu</td><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr><tr><th>
Base lunaire</th><th>
<input type="text" id="base_lunaire_actuel" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('base_lunaire',20000,40000,20000,2)" value="0"></th><th>
<input type="text" id="base_lunaire_voulu" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('base_lunaire',20000,40000,20000,2)" value="0"></th><th>
<input type="text" id="base_lunaire_metal" size="15" readonly value="0"></th><th>
<input type="text" id="base_lunaire_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="base_lunaire_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="base_lunaire_temps" size="15" readonly value="-">
<input type="hidden" id="base_lunaire_sec" size="15" value="0"></th>
</tr><tr><th>
Phalange de capteurs</th><th>
<input type="text" id="phalange_capteurs_actuel" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('phalange_capteurs',20000,40000,20000,2)" value="0"></th><th>
<input type="text" id="phalange_capteurs_voulu" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('phalange_capteurs',20000,40000,20000,2)" value="0"></th><th>
<input type="text" id="phalange_capteurs_metal" size="15" readonly value="0"></th><th>
<input type="text" id="phalange_capteurs_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="phalange_capteurs_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="phalange_capteurs_temps" size="15" readonly value="-">
<input type="hidden" id="phalange_capteurs_sec" size="15" value="0"></th>
</tr><tr><th>
Porte de saut spatial</th><th>
<input type="text" id="porte_saut_spatial_actuel" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('porte_saut_spatial',2000000,4000000,2000000,2)" value="0"></th><th>
<input type="text" id="porte_saut_spatial_voulu" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('porte_saut_spatial',2000000,4000000,2000000,2)" value="0"></th><th>
<input type="text" id="porte_saut_spatial_metal" size="15" readonly value="0"></th><th>
<input type="text" id="porte_saut_spatial_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="porte_saut_spatial_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="porte_saut_spatial_temps" size="15" readonly value="-">
<input type="hidden" id="porte_saut_spatial_sec" size="15" value="0"></th>
</tr><tr><th>
Dépôt de ravitaillement</th><th>
<input type="text" id="depot_ravitaillement_actuel" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('depot_ravitaillement',20000,40000,0,2)" value="0"></th><th>
<input type="text" id="depot_ravitaillement_voulu" size="2" maxlength="2" onBlur="javascript:batimentSpeciaux('depot_ravitaillement',20000,40000,0,2)" value="0"></th><th>
<input type="text" id="depot_ravitaillement_metal" size="15" readonly value="0"></th><th>
<input type="text" id="depot_ravitaillement_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="depot_ravitaillement_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="depot_ravitaillement_temps" size="15" readonly value="-">
<input type="hidden" id="depot_ravitaillement_sec" size="15" value="0"></th>
</tr><tr><td class="c" style="text-align:center" colspan="3">
TOTAL</td><th>
<input type="text" id="batiments_speciaux_metal" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_speciaux_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_speciaux_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="batiments_speciaux_temps" size="15" readonly value="-">
<input type="hidden" id="batiments_speciaux_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
Un total de <span id="batiments_speciaux_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="batiments_speciaux_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="batiments_speciaux_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset><br>
<fieldset><legend><b>Technologies</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Nom</td><td class="c" style="text-align:center">
Niveau actuel</td><td class="c" style="text-align:center">
Niveau voulu</td><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr>
<tr><th>
Espionnage</th><th>
<input type="text" id="espionnage_actuel" size="2" maxlength="2" onBlur="javascript:technologie('espionnage',200,1000,200,2)" value="0"></th><th>
<input type="text" id="espionnage_voulu" size="2" maxlength="2" onBlur="javascript:technologie('espionnage',200,1000,200,2)" value="0"></th><th>
<input type="text" id="espionnage_metal" size="15" readonly value="0"></th><th>
<input type="text" id="espionnage_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="espionnage_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="espionnage_temps" size="15" readonly value="-">
<input type="hidden" id="espionnage_sec" size="15" value="0"></th>
</tr><tr><th>
Ordinateur</th><th>
<input type="text" id="ordinateur_actuel" size="2" maxlength="2" onBlur="javascript:technologie('ordinateur',0,400,600,2)" value="0"></th><th>
<input type="text" id="ordinateur_voulu" size="2" maxlength="2" onBlur="javascript:technologie('ordinateur',0,400,600,2)" value="0"></th><th>
<input type="text" id="ordinateur_metal" size="15" readonly value="0"></th><th>
<input type="text" id="ordinateur_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="ordinateur_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="ordinateur_temps" size="15" readonly value="-">
<input type="hidden" id="ordinateur_sec" size="15" value="0"></th>
</tr><tr><th>
Armes</th><th>
<input type="text" id="armes_actuel" size="2" maxlength="2" onBlur="javascript:technologie('armes',800,200,0,2)" value="0"></th><th>
<input type="text" id="armes_voulu" size="2" maxlength="2" onBlur="javascript:technologie('armes',800,200,0,2)" value="0"></th><th>
<input type="text" id="armes_metal" size="15" readonly value="0"></th><th>
<input type="text" id="armes_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="armes_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="armes_temps" size="15" readonly value="-">
<input type="hidden" id="armes_sec" size="15" value="0"></th>
</tr><tr><th>
Bouclier</th><th>
<input type="text" id="bouclier_actuel" size="2" maxlength="2" onBlur="javascript:technologie('bouclier',200,600,0,2)" value="0"></th><th>
<input type="text" id="bouclier_voulu" size="2" maxlength="2" onBlur="javascript:technologie('bouclier',200,600,0,2)" value="0"></th><th>
<input type="text" id="bouclier_metal" size="15" readonly value="0"></th><th>
<input type="text" id="bouclier_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="bouclier_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="bouclier_temps" size="15" readonly value="-">
<input type="hidden" id="bouclier_sec" size="15" value="0"></th>
</tr><tr><th>
Protection des vaisseaux</th><th>
<input type="text" id="protection_vaisseaux_actuel" size="2" maxlength="2" onBlur="javascript:technologie('protection_vaisseaux',1000,0,0,2)" value="0"></th><th>
<input type="text" id="protection_vaisseaux_voulu" size="2" maxlength="2" onBlur="javascript:technologie('protection_vaisseaux',1000,0,0,2)" value="0"></th><th>
<input type="text" id="protection_vaisseaux_metal" size="15" readonly value="0"></th><th>
<input type="text" id="protection_vaisseaux_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="protection_vaisseaux_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="protection_vaisseaux_temps" size="15" readonly value="-">
<input type="hidden" id="protection_vaisseaux_sec" size="15" value="0"></th>
</tr><tr><th>
Energie</th><th>
<input type="text" id="energie_actuel" size="2" maxlength="2" onBlur="javascript:technologie('energie',0,800,400,2)" value="0"></th><th>
<input type="text" id="energie_voulu" size="2" maxlength="2" onBlur="javascript:technologie('energie',0,800,400,2)" value="0"></th><th>
<input type="text" id="energie_metal" size="15" readonly value="0"></th><th>
<input type="text" id="energie_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="energie_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="energie_temps" size="15" readonly value="-">
<input type="hidden" id="energie_sec" size="15" value="0"></th>
</tr><tr><th>
Hyperespace</th><th>
<input type="text" id="hyperespace_actuel" size="2" maxlength="2" onBlur="javascript:technologie('hyperespace',0,4000,2000,2)" value="0"></th><th>
<input type="text" id="hyperespace_voulu" size="2" maxlength="2" onBlur="javascript:technologie('hyperespace',0,4000,2000,2)" value="0"></th><th>
<input type="text" id="hyperespace_metal" size="15" readonly value="0"></th><th>
<input type="text" id="hyperespace_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="hyperespace_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="hyperespace_temps" size="15" readonly value="-">
<input type="hidden" id="hyperespace_sec" size="15" value="0"></th>
</tr><tr><th>
Réacteur à combustion</th><th>
<input type="text" id="reacteur_combustion_actuel" size="2" maxlength="2" onBlur="javascript:technologie('reacteur_combustion',400,0,600,2)" value="0"></th><th>
<input type="text" id="reacteur_combustion_voulu" size="2" maxlength="2" onBlur="javascript:technologie('reacteur_combustion',400,0,600,2)" value="0"></th><th>
<input type="text" id="reacteur_combustion_metal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_combustion_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_combustion_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_combustion_temps" size="15" readonly value="-">
<input type="hidden" id="reacteur_combustion_sec" size="15" value="0"></th>
</tr><tr><th>
Réacteur à impulsion</th><th>
<input type="text" id="reacteur_impulsion_actuel" size="2" maxlength="2" onBlur="javascript:technologie('reacteur_impulsion',2000,4000,600,2)" value="0"></th><th>
<input type="text" id="reacteur_impulsion_voulu" size="2" maxlength="2" onBlur="javascript:technologie('reacteur_impulsion',2000,4000,600,2)" value="0"></th><th>
<input type="text" id="reacteur_impulsion_metal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_impulsion_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_impulsion_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="reacteur_impulsion_temps" size="15" readonly value="-">
<input type="hidden" id="reacteur_impulsion_sec" size="15" value="0"></th>
</tr><tr><th>
Propulsion hyperespace</th><th>
<input type="text" id="propulsion_hyperespace_actuel" size="2" maxlength="2" onBlur="javascript:technologie('propulsion_hyperespace',10000,20000,6000,2)" value="0"></th><th>
<input type="text" id="propulsion_hyperespace_voulu" size="2" maxlength="2" onBlur="javascript:technologie('propulsion_hyperespace',10000,20000,6000,2)" value="0"></th><th>
<input type="text" id="propulsion_hyperespace_metal" size="15" readonly value="0"></th><th>
<input type="text" id="propulsion_hyperespace_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="propulsion_hyperespace_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="propulsion_hyperespace_temps" size="15" readonly value="-">
<input type="hidden" id="propulsion_hyperespace_sec" size="15" value="0"></th>
</tr><tr><th>
Laser</th><th>
<input type="text" id="laser_actuel" size="2" maxlength="2" onBlur="javascript:technologie('laser',200,100,0,2)" value="0"></th><th>
<input type="text" id="laser_voulu" size="2" maxlength="2" onBlur="javascript:technologie('laser',200,100,0,2)" value="0"></th><th>
<input type="text" id="laser_metal" size="15" readonly value="0"></th><th>
<input type="text" id="laser_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="laser_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="laser_temps" size="15" readonly value="-">
<input type="hidden" id="laser_sec" size="15" value="0"></th>
</tr><tr><th>
Ion</th><th>
<input type="text" id="ion_actuel" size="2" maxlength="2" onBlur="javascript:technologie('ion',1000,300,100,2)" value="0"></th><th>
<input type="text" id="ion_voulu" size="2" maxlength="2" onBlur="javascript:technologie('ion',1000,300,100,2)" value="0"></th><th>
<input type="text" id="ion_metal" size="15" readonly value="0"></th><th>
<input type="text" id="ion_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="ion_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="ion_temps" size="15" readonly value="-">
<input type="hidden" id="ion_sec" size="15" value="0"></th>
</tr><tr><th>
Plasma</th><th>
<input type="text" id="plasma_actuel" size="2" maxlength="2" onBlur="javascript:technologie('plasma',2000,4000,1000,2)" value="0"></th><th>
<input type="text" id="plasma_voulu" size="2" maxlength="2" onBlur="javascript:technologie('plasma',2000,4000,1000,2)" value="0"></th><th>
<input type="text" id="plasma_metal" size="15" readonly value="0"></th><th>
<input type="text" id="plasma_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="plasma_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="plasma_temps" size="15" readonly value="-">
<input type="hidden" id="plasma_sec" size="15" value="0"></th>
</tr><tr><th>
Réseau de recherche</th><th>
<input type="text" id="reseau_recherche_actuel" size="2" maxlength="2" onBlur="javascript:technologie('reseau_recherche',240000,400000,160000,2)" value="0"></th><th>
<input type="text" id="reseau_recherche_voulu" size="2" maxlength="2" onBlur="javascript:technologie('reseau_recherche',240000,400000,160000,2)" value="0"></th><th>
<input type="text" id="reseau_recherche_metal" size="15" readonly value="0"></th><th>
<input type="text" id="reseau_recherche_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="reseau_recherche_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="reseau_recherche_temps" size="15" readonly value="-">
<input type="hidden" id="reseau_recherche_sec" size="15" value="0"></th>
</tr><tr><th>
Expéditions</th><th>
<input type="text" id="expeditions_actuel" size="2" maxlength="2" onBlur="javascript:technologie('expeditions',4000,8000,4000,2)" value="0"></th><th>
<input type="text" id="expeditions_voulu" size="2" maxlength="2" onBlur="javascript:technologie('expeditions',4000,8000,4000,2)" value="0"></th><th>
<input type="text" id="expeditions_metal" size="15" readonly value="0"></th><th>
<input type="text" id="expeditions_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="expeditions_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="expeditions_temps" size="15" readonly value="-">
<input type="hidden" id="expeditions_sec" size="15" value="0"></th>
</tr><tr><th>
Graviton</th><th>
<input type="text" id="graviton_actuel" size="2" maxlength="2" onBlur="javascript:graviton()" value="0"></th><th>
<input type="text" id="graviton_voulu" size="2" maxlength="2" onBlur="javascript:graviton()" value="0"></th><th colspan="3">
énergie: <input type="text" id="graviton" size="15" readonly value="0"></td><th>
instantané</th>
</tr><tr><td class="c" style="text-align:center" colspan="3">
TOTAL</td><th>
<input type="text" id="technologies_metal" size="15" readonly value="0"></th><th>
<input type="text" id="technologies_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="technologies_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="technologies_temps" size="15" readonly value="-">
<input type="hidden" id="technologies_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
Un total de <span id="technologies_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="technologies_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="technologies_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset><br>
<fieldset><legend><b>Vaisseaux</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Nom</td><td class="c" style="text-align:center">
Quantité voulue</td><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr>
<tr><th>
Petit transporteur</th><th>
<input type="text" id="pt_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('pt',2000,2000,0)" value="0"></th><th>
<input type="text" id="pt_metal" size="15" readonly value="0"></th><th>
<input type="text" id="pt_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="pt_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="pt_temps" size="15" readonly value="-">
<input type="hidden" id="pt_sec" size="15" value="0"></th>
</tr><tr><th>
Grand transporteur</th><th>
<input type="text" id="gt_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('gt',6000,6000,0)" value="0"></th><th>
<input type="text" id="gt_metal" size="15" readonly value="0"></th><th>
<input type="text" id="gt_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="gt_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="gt_temps" size="15" readonly value="-">
<input type="hidden" id="gt_sec" size="15" value="0"></th>
</tr><tr><th>
Chasseur léger</th><th>
<input type="text" id="cle_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('cle',3000,1000,0)" value="0"></th><th>
<input type="text" id="cle_metal" size="15" readonly value="0"></th><th>
<input type="text" id="cle_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="cle_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="cle_temps" size="15" readonly value="-">
<input type="hidden" id="cle_sec" size="15" value="0"></th>
</tr><tr><th>
Chasseur lourd</th><th>
<input type="text" id="clo_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('clo',6000,4000,0)" value="0"></th><th>
<input type="text" id="clo_metal" size="15" readonly value="0"></th><th>
<input type="text" id="clo_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="clo_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="clo_temps" size="15" readonly value="-">
<input type="hidden" id="clo_sec" size="15" value="0"></th>
</tr><tr><th>
Croiseur</th><th>
<input type="text" id="cr_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('cr',20000,7000,2000)" value="0"></th><th>
<input type="text" id="cr_metal" size="15" readonly value="0"></th><th>
<input type="text" id="cr_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="cr_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="cr_temps" size="15" readonly value="-">
<input type="hidden" id="cr_sec" size="15" value="0"></th>
</tr><tr><th>
Vaisseau de bataille</th><th>
<input type="text" id="vb_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('vb',45000,15000,0)" value="0"></th><th>
<input type="text" id="vb_metal" size="15" readonly value="0"></th><th>
<input type="text" id="vb_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="vb_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="vb_temps" size="15" readonly value="-">
<input type="hidden" id="vb_sec" size="15" value="0"></th>
</tr><tr><th>
Traqueur</th><th>
<input type="text" id="traq_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('traq',30000,40000,15000)" value="0"></th><th>
<input type="text" id="traq_metal" size="15" readonly value="0"></th><th>
<input type="text" id="traq_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="traq_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="traq_temps" size="15" readonly value="-">
<input type="hidden" id="traq_sec" size="15" value="0"></th>
</tr><tr><th>
Bombardier</th><th>
<input type="text" id="bb_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('bb',50000,25000,15000)" value="0"></th><th>
<input type="text" id="bb_metal" size="15" readonly value="0"></th><th>
<input type="text" id="bb_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="bb_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="bb_temps" size="15" readonly value="-">
<input type="hidden" id="bb_sec" size="15" value="0"></th>
</tr><tr><th>
Destructeur</th><th>
<input type="text" id="dest_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('dest',60000,50000,15000)" value="0"></th><th>
<input type="text" id="dest_metal" size="15" readonly value="0"></th><th>
<input type="text" id="dest_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="dest_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="dest_temps" size="15" readonly value="-">
<input type="hidden" id="dest_sec" size="15" value="0"></th>
</tr><tr><th>
Etoile de la Mort</th><th>
<input type="text" id="edlm_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('edlm',5000000,4000000,1000000)" value="0"></th><th>
<input type="text" id="edlm_metal" size="15" readonly value="0"></th><th>
<input type="text" id="edlm_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="edlm_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="edlm_temps" size="15" readonly value="-">
<input type="hidden" id="edlm_sec" size="15" value="0"></th>
</tr><tr><th>
Recycleur</th><th>
<input type="text" id="recycleur_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('recycleur',10000,6000,2000)" value="0"></th><th>
<input type="text" id="recycleur_metal" size="15" readonly value="0"></th><th>
<input type="text" id="recycleur_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="recycleur_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="recycleur_temps" size="15" readonly value="-">
<input type="hidden" id="recycleur_sec" size="15" value="0"></th></tr><tr><th>
Vaisseau de colonisation</th><th>
<input type="text" id="vc_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('vc',10000,20000,10000)" value="0"></th><th>
<input type="text" id="vc_metal" size="15" readonly value="0"></th><th>
<input type="text" id="vc_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="vc_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="vc_temps" size="15" readonly value="-">
<input type="hidden" id="vc_sec" size="15" value="0"></th>
</tr><tr><th>
Sonde d'espionnage</th><th>
<input type="text" id="sonde_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('sonde',0,1000,0)" value="0"></th><th>
<input type="text" id="sonde_metal" size="15" readonly value="0"></th><th>
<input type="text" id="sonde_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="sonde_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="sonde_temps" size="15" readonly value="-">
<input type="hidden" id="sonde_sec" size="15" value="0"></th>
</tr><tr><th>
Satellite solaire</th><th>
<input type="text" id="satellite_voulu" size=5 maxlength="5" onBlur="javascript:vaisseaux('satellite',0,2000,500)" value="0"></th><th>
<input type="text" id="satellite_metal" size="15" readonly value="0"></th><th>
<input type="text" id="satellite_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="satellite_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="satellite_temps" size="15" readonly value="-">
<input type="hidden" id="satellite_sec" size="15" value="0"></th>
</tr><tr><td class="c" style="text-align:center" colspan="2">
TOTAL</td><th>
<input type="text" id="vaisseaux_metal" size="15" readonly value="0"></th><th>
<input type="text" id="vaisseaux_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="vaisseaux_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="vaisseaux_temps" size="15" readonly value="-">
<input type="hidden" id="vaisseaux_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
Un total de <span id="vaisseaux_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="vaisseaux_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="vaisseaux_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset>
<br>
<fieldset><legend><b>Défense</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Nom</td><td class="c" style="text-align:center">
Quantité voulue</td><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr>
<tr><th>
Lance-missile</th><th>
<input type="text" id="lm_voulu" size=5 maxlength="5" onBlur="javascript:defense('lm',2000,0,0)" value="0"></th><th>
<input type="text" id="lm_metal" size="15" readonly value="0"></th><th>
<input type="text" id="lm_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="lm_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="lm_temps" size="15" readonly value="-">
<input type="hidden" id="lm_sec" size="15" value="0"></th>
</tr><tr><th>
Artillerie légère</th><th>
<input type="text" id="ale_voulu" size=5 maxlength="5" onBlur="javascript:defense('ale',1500,500,0)" value="0"></th><th>
<input type="text" id="ale_metal" size="15" readonly value="0"></th><th>
<input type="text" id="ale_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="ale_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="ale_temps" size="15" readonly value="-">
<input type="hidden" id="ale_sec" size="15" value="0"></th>
</tr><tr><th>
Artillerie lourde</th><th>
<input type="text" id="alo_voulu" size=5 maxlength="5" onBlur="javascript:defense('alo',6000,2000,0)" value="0"></th><th>
<input type="text" id="alo_metal" size="15" readonly value="0"></th><th>
<input type="text" id="alo_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="alo_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="alo_temps" size="15" readonly value="-">
<input type="hidden" id="alo_sec" size="15" value="0"></th>
</tr><tr><th>
Canon à ion</th><th>
<input type="text" id="canon_ion_voulu" size=5 maxlength="5" onBlur="javascript:defense('canon_ion',2000,6000,0)" value="0"></th><th>
<input type="text" id="canon_ion_metal" size="15" readonly value="0"></th><th>
<input type="text" id="canon_ion_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="canon_ion_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="canon_ion_temps" size="15" readonly value="-">
<input type="hidden" id="canon_ion_sec" size="15" value="0"></th>
</tr><tr><th>
Canon de Gauss</th><th>
<input type="text" id="gauss_voulu" size=5 maxlength="5" onBlur="javascript:defense('gauss',20000,15000,2000)" value="0"></th><th>
<input type="text" id="gauss_metal" size="15" readonly value="0"></th><th>
<input type="text" id="gauss_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="gauss_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="gauss_temps" size="15" readonly value="-">
<input type="hidden" id="gauss_sec" size="15" value="0"></th>
</tr><tr><th>
Lanceur de plasma</th><th>
<input type="text" id="lp_voulu" size=5 maxlength="5" onBlur="javascript:defense('lp',50000,50000,30000)" value="0"></th><th>
<input type="text" id="lp_metal" size="15" readonly value="0"></th><th>
<input type="text" id="lp_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="lp_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="lp_temps" size="15" readonly value="-">
<input type="hidden" id="lp_sec" size="15" value="0"></th>
</tr><tr><th>
Petit bouclier</th><th>
<input type="text" id="pb_voulu" size=5 maxlength="5" onBlur="javascript:defense('pb',10000,10000,0)" value="0"></th><th>
<input type="text" id="pb_metal" size="15" readonly value="0"></th><th>
<input type="text" id="pb_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="pb_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="pb_temps" size="15" readonly value="-">
<input type="hidden" id="pb_sec" size="15" value="0"></th>
</tr><tr><th>
Grand bouclier</th><th>
<input type="text" id="gb_voulu" size=5 maxlength="5" onBlur="javascript:defense('gb',50000,50000,30000)" value="0"></th><th>
<input type="text" id="gb_metal" size="15" readonly value="0"></th><th>
<input type="text" id="gb_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="gb_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="gb_temps" size="15" readonly value="-">
<input type="hidden" id="gb_sec" size="15" value="0"></th>
</tr><tr><th>
Missile d'interception</th><th>
<input type="text" id="min_voulu" size=5 maxlength="5" onBlur="javascript:defense('min',8000,0,2000)" value="0"></th><th>
<input type="text" id="min_metal" size="15" readonly value="0"></th><th>
<input type="text" id="min_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="min_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="min_temps" size="15" readonly value="-">
<input type="hidden" id="min_sec" size="15" value="0"></th>
</tr><tr><th>
Missile intergalactique</th><th>
<input type="text" id="mip_voulu" size=5 maxlength="5" onBlur="javascript:defense('mip',12500,2500,10000)" value="0"></th><th>
<input type="text" id="mip_metal" size="15" readonly value="0"></th><th>
<input type="text" id="mip_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="mip_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="mip_temps" size="15" readonly value="-">
<input type="hidden" id="mip_sec" size="15" value="0"></th>
</tr><tr><td class="c" style="text-align:center" colspan="2">
TOTAL</td><th>
<input type="text" id="defenses_metal" size="15" readonly value="0"></th><th>
<input type="text" id="defenses_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="defenses_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="defenses_temps" size="15" readonly value="-">
<input type="hidden" id="defenses_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
Un total de <span id="defenses_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="defenses_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="defenses_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset>
<br>
<fieldset><legend><b>TOTAL</b></legend>
<table>
<tr><td class="c" style="text-align:center">
Métal requis</td><td class="c" style="text-align:center">
Cristal requis</td><td class="c" style="text-align:center">
Deutérium requis</td><td class="c" style="text-align:center">
Durée de construction</td>
</tr>
<tr><th>
<input type="text" id="total_metal" size="15" readonly value="0"></th><th>
<input type="text" id="total_cristal" size="15" readonly value="0"></th><th>
<input type="text" id="total_deuterium" size="15" readonly value="0"></th><th>
<input type="text" id="total_temps" size="15" readonly value="-">
<input type="hidden" id="total_sec" size="15" value="0"></th>
</tr><tr><td colspan="7" class="c">
un total de <span id="total_ressources" style="color:#FF0080;font-weight:bold;">
0</span> ressources, soit <span id="total_pt" style="color:#0080FF;font-weight:bold;">
0</span> PT ou <span id="total_gt" style="color:#80FF00;font-weight:bold;">
0</span> GT
</td></tr></table>
</fieldset>

<br>
<div>OGSCalc_mod (v<?php echo $mod_version?>) créé par Aéris</div>
<br>
<div>
<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-html401" alt="Valid HTML 4.01 Transitional" height="31" width="88"></a>
<a href="http://jigsaw.w3.org/css-validator/"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!"></a>
</div>

</center>

<?php
require_once("views/page_tail.php");
?>
