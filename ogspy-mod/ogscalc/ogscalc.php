<?php

/**
* ogscalc.php - Programme principal
* @package Calculatrice universelle
* @author Aeris
* @update xaviernuma - 2012
* @link http://www.ogsteam.fr/
**/

if (!defined('IN_SPYOGAME'))
{ 
	die("Hacking attempt");
}

require_once("views/page_header.php");

$ta_resultat = $db->sql_query('SELECT `version`, `root` FROM `'.TABLE_MOD.'` WHERE `action`="'.$pub_action.'" AND `active`= 1');

if(!$db->sql_numrows($ta_resultat))
{
	die('Mod désactivé !');
}

list ( $mod_version, $mod_root ) = $db->sql_fetch_row($ta_resultat);

$s_html = ''; 
$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_technology = $user_empire["technology"];

$n_planetes = count($user_building);

$s_html .= '<script type="text/javascript" src="mod/'.$mod_root.'/formule.js"></script>';
$s_html .= '<script type="text/javascript">';

$j = 0;
foreach($user_building as $ta_une_planete)
{
	if ($ta_une_planete['planet_name'] <> '')
	{
		$s_html .= "batimentsOGSpy[".$j."]= new Array('".
				$ta_une_planete['planet_name']."','".
				$ta_une_planete['M']."','".
				$ta_une_planete['C']."','".
				$ta_une_planete['D']."','".
				$ta_une_planete['CES']."','".
				$ta_une_planete['CEF']."','".
				$ta_une_planete['UdR']."','".
				$ta_une_planete['UdN']."','".
				$ta_une_planete['CSp']."','".
				$ta_une_planete['HM']."','".
				$ta_une_planete['HC']."','".
				$ta_une_planete['HD']."','".
				$ta_une_planete['Lab']."','".
				$ta_une_planete['Silo']."','".
				$ta_une_planete['Ter']."','".
				$ta_une_planete['BaLu']."','".
				$ta_une_planete['Pha']."','".
				$ta_une_planete['PoSa']."');";
		$j++;		
	}
}

$s_html .= "technologiesOGSpy = new Array('".
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
		$user_technology['Graviton']."','".
		$user_technology['Astrophysique']."');";

$s_html .= '</script>';

$s_html .= '<fieldset>';
$s_html .= 		'<legend>Gestion</legend>';
$s_html .= 		'<div>';
$s_html .= 			'<input type="submit" value="Sauvegarder les données" onclick="javascript:sauvegarde();" />';
$s_html .= 			'<input type="submit" value="Restaurer les données" onclick="javascript:restaure();" />';
$s_html .= 			'<input type="submit" value="Changelog" onclick="javascript:inverse(\'changelog\');" />';
$s_html .= 			'<input type="submit" value="Reset" onclick="javascript:resetData();" />';
$s_html .= 		'</div>';
$s_html .= 		'<div id="changelog" style="display:none;">';
$s_html .= 			'<h2>Changelog</h2>';
$s_html .= 			'<p>13/04/2012</p>';
$s_html .= 			'<ol style="list-style-type: none;">';
$s_html .= 				'<li>v1.1.0';
$s_html .= 				'<ul type="disc">';
$s_html .= 					'<li>Compatibilité OGSpy 3.1.0</li>';
$s_html .= 					'<li>Optimisation du code</li>';
$s_html .= 					'<li>Simplification du fonctionnement</li>';
$s_html .= 				'</ul>';
$s_html .= 			'</ol>';
$s_html .= 			'<p>18/04/2008</p>';
$s_html .= 			'<ol style="list-style-type: none;">';
$s_html .= 				'<li>v0.5';
$s_html .= 				'<ul type="disc">';
$s_html .= 					'<li>Ajout du calcul des transports</li>';
$s_html .= 					'<li>Ajout du script de désintallation</li>';
$s_html .= 					'<li>Controle de sécurité pour éviter l\'erreur de "Duplicate Entry"</li>';
$s_html .= 				'</ul>';
$s_html .= 			'</ol>';
$s_html .= 			'<p>18/04/2008</p>';
$s_html .= 			'<ol style="list-style-type: none;">';
$s_html .= 				'<li>v0.4d';
$s_html .= 				'<ul type="disc">';
$s_html .= 					'<li>Fix d\'un bug à l\'installation</li>';
$s_html .= 				'</ul>';
$s_html .= 			'</ol>';
$s_html .= 			'<p>16/04/2008</p>';
$s_html .= 			'<ol style="list-style-type: none;">';
$s_html .= 				'<li>v0.4c';
$s_html .= 				'<ul type="disc">';
$s_html .= 					'<li>Ajout de la technologie expéditions</li>';
$s_html .= 					'<li>Modification du fichier install</li>';
$s_html .= 					'<li>Correction du chemin pour atteindre formule.js</li>';
$s_html .= 				'</ul>';
$s_html .= 			'</ol>';
$s_html .= 			'<p>04/03/2007</p>';
$s_html .= 			'<ol style="list-style-type: none;">';
$s_html .= 				'<li>v0.4';
$s_html .= 				'<ul type="disc">';
$s_html .= 					'<li>Ajout du traqueur</li>';
$s_html .= 					'<li>Correction du bug d\'affichage qui ne permmetait pas de voir les ressources</li>';
$s_html .= 					'<li>Modification du prix du traqueur</li>';
$s_html .= 					'<li>Installation des Install/Update qui récupére le n° de version dans le fichier version.txt</li>';
$s_html .= 				'</ul>';
$s_html .= 			'</ol>';
$s_html .= 			'<p>09/08/2006</p>';
$s_html .= 			'<ol style="list-style-type: none;">';
$s_html .= 				'<li>v0.3';
$s_html .= 					'<ul type="disc">';
$s_html .= 					'<li>Correction du problème des prix du terraformeur (merci ben_12)</li>';
$s_html .= 					'<li>Correction du non-rafraichissement des temps si modifications du niveau de l\'usine de robots et de nanites ou du chantier spatial</li>';
$s_html .= 				'</ul>';
$s_html .= 			'</ol>';
$s_html .= 			'<p>09/07/2006</p>';
$s_html .= 			'<ol style="list-style-type: none;">';
$s_html .= 				'<li>v0.2';
$s_html .= 				'<ul type="disc">';
$s_html .= 					'<li>Correction d\'un bug empêchant le calcul des technologies</li>';
$s_html .= 					'<li>Correction d\'un problème de calcul de l\'énergie nécessaire au graviton (merci Corwin)</li>';
$s_html .= 					'<li>Ajout de la fonction reset</li>';
$s_html .= 				'</ul>';
$s_html .= 			'</ol>';
$s_html .= 			'<p>08/07/2006</p>';
$s_html .= 			'<ol style="list-style-type: none;">';
$s_html .= 				'<li>v0.1';
$s_html .= 				'<ul type="disc">';
$s_html .= 					'<li>Sortie d\'OGSCalc en mod OGSpy</li>';
$s_html .= 				'</ul>';
$s_html .= 			'</ol>';
$s_html .= 		'</div>';
$s_html .= '</fieldset>';

$s_html .= '<fieldset>';
$s_html .= 		'<legend>Vos technologies</legend>';
$s_html .= 		'<table>';
$s_html .= 			'<tr>';
$s_html .= 				'<td class="c" style="text-align:center">Planète de développement :</td><th>';
$s_html .= 					'<select id="planete" onchange="javascript:chargement(this.options[this.selectedIndex].value);">';

$i = 0;
foreach($user_building as $ta_une_planete)
{
	if($ta_une_planete['planet_name'] <> '')
	{
		$s_html .= 	'<option value="'.$i.'">';
		$s_html .= 		$ta_une_planete['planet_name'].' ['.$ta_une_planete['coordinates'].']';
		$s_html .= 	'</option>';
	}
	$i++;
}

$s_html .= 					'</select>';
$s_html .= 					'</th>';
$s_html .= 			'</tr><tr>';
$s_html .= 				'<td class="c" style="text-align:center">Laboratoires de recherche :</td><th><input type="text" id="labopm" size="2" maxlength="2" value="0" onkeyup="javascript:laboEqui()"></th>';
$s_html .= 			'</tr><tr>';
$s_html .= 				'<td class="c" style="text-align:center">Usine de robot :</td><th><input type="text" id="robot" size="2" maxlength="2" value="0" onkeyup="javascript:rafraichiRobot()"></th>';
$s_html .= 			'</tr><tr>';
$s_html .= 				'<td class="c" style="text-align:center">Chantier spatial :</td><th><input type="text" id="chantier" size="2" maxlength="2" value="0" onkeyup="javascript:rafraichiChantier()"></th>';
$s_html .= 			'</tr><tr>';
$s_html .= 				'<td class="c" style="text-align:center">Usine de nanites :</td><th><input type="text" id="nanite" size="2" maxlength="2" value="0" onkeyup="javascript:rafraichiRobot();rafraichiChantier()"></th>';
$s_html .= 			'</tr>';
$s_html .= 			'</tr><tr>';
$s_html .= 				'<td class="c" style="text-align:center">Réseau de recherche intergalactique :</td><th><input type="text" id="reseau" size="2" maxlength="2" value="0" onkeyup="javascript:laboEqui()"></th>';
$s_html .= 			'</tr>';
$s_html .= 			'</tr><tr>';
$s_html .= 				'<td class="c" style="text-align:center">Laboratoire équivalent :</td><th><input type="text" id="laboequi" size="4" maxlength="2" readonly value="0"></th>';
$s_html .= 			'</tr>';
$s_html .= 		'</table>';
$s_html .= '</fieldset>';

$s_html .= '<fieldset>';


$s_html .= '<legend>Bâtiments</legend>';
$s_html .= 		'<table>';
$s_html .= 			'<tr><td class="c" style="text-align:center">';
$s_html .= 				'Nom</td><td class="c" style="text-align:center">';
$s_html .= 				'Niveau actuel</td><td class="c" style="text-align:center">';
$s_html .= 				'Niveau voulu</td><td class="c" style="text-align:center">';
$s_html .= 				'Métal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Cristal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Deutérium requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Durée de construction</td>';
$s_html .= 			'</tr>';
$s_html .= 			'<tr><th>';
$s_html .= 				'Mine de métal</th><th>';
$s_html .= 				'<input type="text" id="mine_metal_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'mine_metal\',60,15,0,1.5);" value="0"></th><th>';
$s_html .= 				'<input type="text" id="mine_metal_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'mine_metal\',60,15,0,1.5)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="mine_metal_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="mine_metal_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="mine_metal_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="mine_metal_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="mine_metal_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Mine de cristal</th><th>';
$s_html .= 				'<input type="text" id="mine_cristal_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'mine_cristal\',48,24,0,1.6)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="mine_cristal_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'mine_cristal\',48,24,0,1.6)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="mine_cristal_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="mine_cristal_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="mine_cristal_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="mine_cristal_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="mine_cristal_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Synthétiseur de deutérium</th><th>';
$s_html .= 				'<input type="text" id="synthetiseur_deuterium_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'synthetiseur_deuterium\',225,75,0,1.5)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="synthetiseur_deuterium_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'synthetiseur_deuterium\',225,75,0,1.5)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="synthetiseur_deuterium_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="synthetiseur_deuterium_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="synthetiseur_deuterium_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="synthetiseur_deuterium_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="synthetiseur_deuterium_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Centrale solaire</th><th>';
$s_html .= 				'<input type="text" id="centrale_solaire_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'centrale_solaire\',75,30,0,1.5)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="centrale_solaire_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'centrale_solaire\',75,30,0,1.5)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="centrale_solaire_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="centrale_solaire_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="centrale_solaire_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="centrale_solaire_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="centrale_solaire_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Réacteur à fusion</th><th>';
$s_html .= 				'<input type="text" id="reacteur_fusion_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'reacteur_fusion\',900,360,180,1.8)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_fusion_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'reacteur_fusion\',900,360,180,1.8)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_fusion_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_fusion_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_fusion_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_fusion_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="reacteur_fusion_sec" size="15" value="0"></th>';
$s_html .=			'</tr><tr><th>';
$s_html .= 				'Usine de robots</th><th>';
$s_html .= 				'<input type="text" id="usine_robots_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'usine_robots\',400,120,200,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="usine_robots_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'usine_robots\',400,120,200,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="usine_robots_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="usine_robots_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="usine_robots_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="usine_robots_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="usine_robots_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Usine de nanites</th><th>';
$s_html .=				'<input type="text" id="usine_nanites_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'usine_nanites\',1000000,500000,100000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="usine_nanites_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'usine_nanites\',1000000,500000,100000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="usine_nanites_metal" size="15" readonly value="0"></th><th>';
$s_html .=				'<input type="text" id="usine_nanites_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="usine_nanites_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="usine_nanites_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="usine_nanites_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Chantier spatial</th><th>';
$s_html .= 				'<input type="text" id="chantier_spatial_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'chantier_spatial\',400,200,100,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="chantier_spatial_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'chantier_spatial\',400,200,100,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="chantier_spatial_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="chantier_spatial_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="chantier_spatial_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="chantier_spatial_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="chantier_spatial_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Hangar de metal</th><th>';
$s_html .= 				'<input type="text" id="hangar_metal_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'hangar_metal\',2000,0,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="hangar_metal_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'hangar_metal\',2000,0,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="hangar_metal_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="hangar_metal_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="hangar_metal_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="hangar_metal_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="hangar_metal_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Hangar de cristal</th><th>';
$s_html .= 				'<input type="text" id="hangar_cristal_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'hangar_cristal\',2000,1000,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="hangar_cristal_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'hangar_cristal\',2000,1000,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="hangar_cristal_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="hangar_cristal_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="hangar_cristal_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="hangar_cristal_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="hangar_cristal_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Réservoir de deutérium</th><th>';
$s_html .= 				'<input type="text" id="reservoir_deuterium_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'reservoir_deuterium\',2000,2000,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="reservoir_deuterium_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'reservoir_deuterium\',2000,2000,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="reservoir_deuterium_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reservoir_deuterium_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reservoir_deuterium_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reservoir_deuterium_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="reservoir_deuterium_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Laboratoire</th><th>';
$s_html .= 				'<input type="text" id="laboratoire_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'laboratoire\',200,400,200,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="laboratoire_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'laboratoire\',200,400,200,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="laboratoire_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="laboratoire_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="laboratoire_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="laboratoire_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="laboratoire_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Silo à missiles</th><th>';
$s_html .= 				'<input type="text" id="silo_missiles_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'silo_missiles\',20000,20000,1000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="silo_missiles_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'silo_missiles\',20000,20000,1000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="silo_missiles_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="silo_missiles_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type=text" id="silo_missiles_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="silo_missiles_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="silo_missiles_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Terraformeur</th><th>';
$s_html .= 				'<input type="text" id="terraformeur_actuel" size="2" maxlength="2" onkeyup="javascript:batiment(\'terraformeur\',1000,50000,100000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="terraformeur_voulu" size="2" maxlength="2" onkeyup="javascript:batiment(\'terraformeur\',1000,50000,100000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="terraformeur_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="terraformeur_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'énergie: <input type="text" id="terraformeur_deuterium" size="15" readonly value="0"></td><th>';
$s_html .= 				'<input type="text" id="terraformeur_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="terraformeur_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><td class="c" style="text-align:center" colspan="3">';
$s_html .= 				'TOTAL</td><th>';
$s_html .= 				'<input type="text" id="batiments_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="batiments_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="batiments_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="batiments_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="batiments_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><td colspan="7" class="c">';
$s_html .= 				'Un total de <span id="batiments_ressources" style="color:#FF0080;font-weight:bold;">';
$s_html .= 				'0</span> ressources, soit <span id="batiments_pt" style="color:#0080FF;font-weight:bold;">';
$s_html .= 				'0</span> PT ou <span id="batiments_gt" style="color:#80FF00;font-weight:bold;">';
$s_html .= 				'0</span> GT';
$s_html .= 			'</td></tr></table>';
$s_html .= '</fieldset>';



$s_html .= '<fieldset>';
$s_html .= 		'<legend>Bâtiments spéciaux</legend>';
$s_html .=		'<table>';
$s_html .= 			'<tr><td class="c" style="text-align:center">';
$s_html .= 				'Nom</td><td class="c" style="text-align:center">';
$s_html .= 				'Niveau actuel</td><td class="c" style="text-align:center">';
$s_html .= 				'Niveau voulu</td><td class="c" style="text-align:center">';
$s_html .= 				'Métal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Cristal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Deutérium requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Durée de construction</td>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Base lunaire</th><th>';
$s_html .= 				'<input type="text" id="base_lunaire_actuel" size="2" maxlength="2" onkeyup="javascript:batimentSpeciaux(\'base_lunaire\',20000,40000,20000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="base_lunaire_voulu" size="2" maxlength="2" onkeyup="javascript:batimentSpeciaux(\'base_lunaire\',20000,40000,20000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="base_lunaire_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="base_lunaire_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="base_lunaire_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="base_lunaire_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="base_lunaire_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Phalange de capteurs</th><th>';
$s_html .= 				'<input type="text" id="phalange_capteurs_actuel" size="2" maxlength="2" onkeyup="javascript:batimentSpeciaux(\'phalange_capteurs\',20000,40000,20000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="phalange_capteurs_voulu" size="2" maxlength="2" onkeyup="javascript:batimentSpeciaux(\'phalange_capteurs\',20000,40000,20000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="phalange_capteurs_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="phalange_capteurs_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="phalange_capteurs_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="phalange_capteurs_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="phalange_capteurs_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Porte de saut spatial</th><th>';
$s_html .= 				'<input type="text" id="porte_saut_spatial_actuel" size="2" maxlength="2" onkeyup="javascript:batimentSpeciaux(\'porte_saut_spatial\',2000000,4000000,2000000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="porte_saut_spatial_voulu" size="2" maxlength="2" onkeyup="javascript:batimentSpeciaux(\'porte_saut_spatial\',2000000,4000000,2000000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="porte_saut_spatial_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="porte_saut_spatial_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="porte_saut_spatial_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="porte_saut_spatial_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="porte_saut_spatial_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Dépôt de ravitaillement</th><th>';
$s_html .= 				'<input type="text" id="depot_ravitaillement_actuel" size="2" maxlength="2" onkeyup="javascript:batimentSpeciaux(\'depot_ravitaillement\',20000,40000,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="depot_ravitaillement_voulu" size="2" maxlength="2" onkeyup="javascript:batimentSpeciaux(\'depot_ravitaillement\',20000,40000,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="depot_ravitaillement_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="depot_ravitaillement_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="depot_ravitaillement_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="depot_ravitaillement_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="depot_ravitaillement_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><td class="c" style="text-align:center" colspan="3">';
$s_html .= 				'TOTAL</td><th>';
$s_html .= 				'<input type="text" id="batiments_speciaux_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="batiments_speciaux_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="batiments_speciaux_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="batiments_speciaux_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="batiments_speciaux_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><td colspan="7" class="c">';
$s_html .= 				'Un total de <span id="batiments_speciaux_ressources" style="color:#FF0080;font-weight:bold;">';
$s_html .= 				'0</span> ressources, soit <span id="batiments_speciaux_pt" style="color:#0080FF;font-weight:bold;">';
$s_html .= 				'0</span> PT ou <span id="batiments_speciaux_gt" style="color:#80FF00;font-weight:bold;">';
$s_html .= 				'0</span> GT';
$s_html .= 			'</td></tr>';
$s_html .= 		'</table>';
$s_html .= '</fieldset>';



$s_html .= '<fieldset>';
$s_html .= 		'<legend>Technologies</legend>';
$s_html .= 			'<table>';
$s_html .= 			'<tr><td class="c" style="text-align:center">';
$s_html .= 				'Nom</td><td class="c" style="text-align:center">';
$s_html .= 				'Niveau actuel</td><td class="c" style="text-align:center">';
$s_html .= 				'Niveau voulu</td><td class="c" style="text-align:center">';
$s_html .= 				'Métal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Cristal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Deutérium requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Durée de construction</td>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Espionnage</th><th>';
$s_html .= 				'<input type="text" id="espionnage_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'espionnage\',200,1000,200,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="espionnage_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'espionnage\',200,1000,200,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="espionnage_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="espionnage_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="espionnage_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="espionnage_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="espionnage_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Ordinateur</th><th>';
$s_html .= 				'<input type="text" id="ordinateur_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'ordinateur\',0,400,600,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="ordinateur_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'ordinateur\',0,400,600,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="ordinateur_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="ordinateur_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="ordinateur_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="ordinateur_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="ordinateur_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Armes</th><th>';
$s_html .= 				'<input type="text" id="armes_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'armes\',800,200,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="armes_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'armes\',800,200,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="armes_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="armes_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="armes_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="armes_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="armes_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Bouclier</th><th>';
$s_html .= 				'<input type="text" id="bouclier_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'bouclier\',200,600,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="bouclier_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'bouclier\',200,600,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="bouclier_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="bouclier_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="bouclier_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="bouclier_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="bouclier_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Protection des vaisseaux</th><th>';
$s_html .= 				'<input type="text" id="protection_vaisseaux_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'protection_vaisseaux\',1000,0,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="protection_vaisseaux_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'protection_vaisseaux\',1000,0,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="protection_vaisseaux_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="protection_vaisseaux_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="protection_vaisseaux_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="protection_vaisseaux_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="protection_vaisseaux_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Energie</th><th>';
$s_html .= 				'<input type="text" id="energie_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'energie\',0,800,400,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="energie_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'energie\',0,800,400,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="energie_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="energie_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="energie_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="energie_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="energie_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Hyperespace</th><th>';
$s_html .= 				'<input type="text" id="hyperespace_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'hyperespace\',0,4000,2000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="hyperespace_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'hyperespace\',0,4000,2000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="hyperespace_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="hyperespace_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="hyperespace_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="hyperespace_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="hyperespace_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Réacteur à combustion</th><th>';
$s_html .= 				'<input type="text" id="reacteur_combustion_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'reacteur_combustion\',400,0,600,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_combustion_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'reacteur_combustion\',400,0,600,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_combustion_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_combustion_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_combustion_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_combustion_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="reacteur_combustion_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Réacteur à impulsion</th><th>';
$s_html .= 				'<input type="text" id="reacteur_impulsion_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'reacteur_impulsion\',2000,4000,600,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_impulsion_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'reacteur_impulsion\',2000,4000,600,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_impulsion_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_impulsion_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_impulsion_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reacteur_impulsion_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="reacteur_impulsion_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Propulsion hyperespace</th><th>';
$s_html .= 				'<input type="text" id="propulsion_hyperespace_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'propulsion_hyperespace\',10000,20000,6000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="propulsion_hyperespace_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'propulsion_hyperespace\',10000,20000,6000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="propulsion_hyperespace_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="propulsion_hyperespace_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="propulsion_hyperespace_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="propulsion_hyperespace_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="propulsion_hyperespace_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Laser</th><th>';
$s_html .= 				'<input type="text" id="laser_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'laser\',200,100,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="laser_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'laser\',200,100,0,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="laser_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="laser_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="laser_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="laser_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="laser_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Ion</th><th>';
$s_html .= 				'<input type="text" id="ion_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'ion\',1000,300,100,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="ion_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'ion\',1000,300,100,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="ion_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="ion_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="ion_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="ion_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="ion_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Plasma</th><th>';
$s_html .= 				'<input type="text" id="plasma_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'plasma\',2000,4000,1000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="plasma_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'plasma\',2000,4000,1000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="plasma_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="plasma_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="plasma_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="plasma_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="plasma_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Réseau de recherche</th><th>';
$s_html .= 				'<input type="text" id="reseau_recherche_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'reseau_recherche\',240000,400000,160000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="reseau_recherche_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'reseau_recherche\',240000,400000,160000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="reseau_recherche_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reseau_recherche_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reseau_recherche_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="reseau_recherche_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="reseau_recherche_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Expéditions</th><th>';
$s_html .= 				'<input type="text" id="expeditions_actuel" size="2" maxlength="2" onkeyup="javascript:technologie(\'expeditions\',4000,8000,4000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="expeditions_voulu" size="2" maxlength="2" onkeyup="javascript:technologie(\'expeditions\',4000,8000,4000,2)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="expeditions_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="expeditions_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="expeditions_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="expeditions_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="expeditions_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Graviton</th><th>';
$s_html .= 				'<input type="text" id="graviton_actuel" size="2" maxlength="2" onkeyup="javascript:graviton()" value="0"></th><th>';
$s_html .= 				'<input type="text" id="graviton_voulu" size="2" maxlength="2" onkeyup="javascript:graviton()" value="0"></th><th colspan="3">';
$s_html .= 				'énergie: <input type="text" id="graviton" size="15" readonly value="0"></td><th>';
$s_html .= 				'instantané</th>';
$s_html .= 			'</tr><tr><td class="c" style="text-align:center" colspan="3">';
$s_html .= 				'TOTAL</td><th>';
$s_html .= 				'<input type="text" id="technologies_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="technologies_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="technologies_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="technologies_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="technologies_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><td colspan="7" class="c">';
$s_html .= 				'Un total de <span id="technologies_ressources" style="color:#FF0080;font-weight:bold;">';
$s_html .= 				'0</span> ressources, soit <span id="technologies_pt" style="color:#0080FF;font-weight:bold;">';
$s_html .= 				'0</span> PT ou <span id="technologies_gt" style="color:#80FF00;font-weight:bold;">';
$s_html .= 				'0</span> GT';
$s_html .= 			'</td></tr>';
$s_html .= 		'</table>';
$s_html .= '</fieldset>';



$s_html .= '<fieldset>';
$s_html .= 		'<legend>Vaisseaux</legend>';
$s_html .= 		'<table>';
$s_html .= 			'<tr><td class="c" style="text-align:center">';
$s_html .= 				'Nom</td><td class="c" style="text-align:center">';
$s_html .= 				'Quantité voulue</td><td class="c" style="text-align:center">';
$s_html .= 				'Métal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Cristal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Deutérium requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Durée de construction</td>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Petit transporteur</th><th>';
$s_html .= 				'<input type="text" id="pt_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'pt\',2000,2000,0)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="pt_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="pt_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="pt_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="pt_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="pt_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Grand transporteur</th><th>';
$s_html .= 				'<input type="text" id="gt_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'gt\',6000,6000,0)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="gt_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="gt_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="gt_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="gt_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="gt_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Chasseur léger</th><th>';
$s_html .= 				'<input type="text" id="cle_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'cle\',3000,1000,0)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="cle_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="cle_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="cle_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="cle_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="cle_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Chasseur lourd</th><th>';
$s_html .= 				'<input type="text" id="clo_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'clo\',6000,4000,0)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="clo_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="clo_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="clo_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="clo_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="clo_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Croiseur</th><th>';
$s_html .= 				'<input type="text" id="cr_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'cr\',20000,7000,2000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="cr_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="cr_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="cr_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="cr_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="cr_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Vaisseau de bataille</th><th>';
$s_html .= 				'<input type="text" id="vb_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'vb\',45000,15000,0)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="vb_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="vb_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="vb_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="vb_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="vb_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Traqueur</th><th>';
$s_html .= 				'<input type="text" id="traq_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'traq\',30000,40000,15000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="traq_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="traq_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="traq_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="traq_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="traq_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Bombardier</th><th>';
$s_html .= 				'<input type="text" id="bb_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'bb\',50000,25000,15000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="bb_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="bb_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="bb_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="bb_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="bb_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Destructeur</th><th>';
$s_html .= 				'<input type="text" id="dest_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'dest\',60000,50000,15000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="dest_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="dest_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="dest_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="dest_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="dest_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Etoile de la Mort</th><th>';
$s_html .= 				'<input type="text" id="edlm_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'edlm\',5000000,4000000,1000000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="edlm_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="edlm_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="edlm_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="edlm_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="edlm_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Recycleur</th><th>';
$s_html .= 				'<input type="text" id="recycleur_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'recycleur\',10000,6000,2000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="recycleur_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="recycleur_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="recycleur_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="recycleur_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="recycleur_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Vaisseau de colonisation</th><th>';
$s_html .= 				'<input type="text" id="vc_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'vc\',10000,20000,10000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="vc_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="vc_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="vc_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="vc_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="vc_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Sonde d\'espionnage</th><th>';
$s_html .= 				'<input type="text" id="sonde_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'sonde\',0,1000,0)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="sonde_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="sonde_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="sonde_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="sonde_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="sonde_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Satellite solaire</th><th>';
$s_html .= 				'<input type="text" id="satellite_voulu" size=5 maxlength="5" onkeyup="javascript:vaisseaux(\'satellite\',0,2000,500)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="satellite_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="satellite_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="satellite_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="satellite_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="satellite_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><td class="c" style="text-align:center" colspan="2">';
$s_html .= 				'TOTAL</td><th>';
$s_html .= 				'<input type="text" id="vaisseaux_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="vaisseaux_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="vaisseaux_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="vaisseaux_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="vaisseaux_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><td colspan="7" class="c">';
$s_html .= 				'Un total de <span id="vaisseaux_ressources" style="color:#FF0080;font-weight:bold;">';
$s_html .= 				'0</span> ressources, soit <span id="vaisseaux_pt" style="color:#0080FF;font-weight:bold;">';
$s_html .= 				'0</span> PT ou <span id="vaisseaux_gt" style="color:#80FF00;font-weight:bold;">';
$s_html .= 				'0</span> GT';
$s_html .= 			'</td></tr>';
$s_html .= 		'</table>';
$s_html .= '</fieldset>';

$s_html .= '<fieldset>';
$s_html .= 		'<legend>Défense</legend>';
$s_html .= 		'<table>';
$s_html .= 			'<tr><td class="c" style="text-align:center">';
$s_html .= 				'Nom</td><td class="c" style="text-align:center">';
$s_html .= 				'Quantité voulue</td><td class="c" style="text-align:center">';
$s_html .= 				'Métal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Cristal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Deutérium requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Durée de construction</td>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Lance-missile</th><th>';
$s_html .= 				'<input type="text" id="lm_voulu" size=5 maxlength="5" onkeyup="javascript:defense(\'lm\',2000,0,0)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="lm_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="lm_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="lm_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="lm_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="lm_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Artillerie légère</th><th>';
$s_html .= 				'<input type="text" id="ale_voulu" size=5 maxlength="5" onkeyup="javascript:defense(\'ale\',1500,500,0)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="ale_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="ale_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="ale_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="ale_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="ale_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Artillerie lourde</th><th>';
$s_html .= 				'<input type="text" id="alo_voulu" size=5 maxlength="5" onkeyup="javascript:defense(\'alo\',6000,2000,0)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="alo_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="alo_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="alo_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="alo_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="alo_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Canon à ion</th><th>';
$s_html .= 				'<input type="text" id="canon_ion_voulu" size=5 maxlength="5" onkeyup="javascript:defense(\'canon_ion\',2000,6000,0)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="canon_ion_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="canon_ion_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="canon_ion_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="canon_ion_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="canon_ion_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Canon de Gauss</th><th>';
$s_html .= 				'<input type="text" id="gauss_voulu" size=5 maxlength="5" onkeyup="javascript:defense(\'gauss\',20000,15000,2000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="gauss_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="gauss_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="gauss_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="gauss_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="gauss_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Lanceur de plasma</th><th>';
$s_html .= 				'<input type="text" id="lp_voulu" size=5 maxlength="5" onkeyup="javascript:defense(\'lp\',50000,50000,30000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="lp_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="lp_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="lp_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="lp_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="lp_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Petit bouclier</th><th>';
$s_html .= 				'<input type="text" id="pb_voulu" size=5 maxlength="5" onkeyup="javascript:defense(\'pb\',10000,10000,0)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="pb_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="pb_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="pb_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="pb_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="pb_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Grand bouclier</th><th>';
$s_html .= 				'<input type="text" id="gb_voulu" size=5 maxlength="5" onkeyup="javascript:defense(\'gb\',50000,50000,30000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="gb_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="gb_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="gb_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="gb_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="gb_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Missile d\'interception</th><th>';
$s_html .= 				'<input type="text" id="min_voulu" size=5 maxlength="5" onkeyup="javascript:defense(\'min\',8000,0,2000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="min_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="min_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="min_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="min_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="min_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><th>';
$s_html .= 				'Missile intergalactique</th><th>';
$s_html .= 				'<input type="text" id="mip_voulu" size=5 maxlength="5" onkeyup="javascript:defense(\'mip\',12500,2500,10000)" value="0"></th><th>';
$s_html .= 				'<input type="text" id="mip_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="mip_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="mip_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="mip_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="mip_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><td class="c" style="text-align:center" colspan="2">';
$s_html .= 				'TOTAL</td><th>';
$s_html .= 				'<input type="text" id="defenses_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="defenses_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="defenses_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="defenses_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="defenses_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><td colspan="7" class="c">';
$s_html .= 				'Un total de <span id="defenses_ressources" style="color:#FF0080;font-weight:bold;">';
$s_html .= 				'0</span> ressources, soit <span id="defenses_pt" style="color:#0080FF;font-weight:bold;">';
$s_html .= 				'0</span> PT ou <span id="defenses_gt" style="color:#80FF00;font-weight:bold;">';
$s_html .= 				'0</span> GT';
$s_html .= 				'</td></tr></table>';
$s_html .= 				'</fieldset>';

$s_html .= 				'<fieldset><legend><b>TOTAL</b></legend>';
$s_html .= 				'<table>';
$s_html .= 			'<tr><td class="c" style="text-align:center">';
$s_html .= 				'Métal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Cristal requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Deutérium requis</td><td class="c" style="text-align:center">';
$s_html .= 				'Durée de construction</td>';
$s_html .= 				'</tr>';
$s_html .= 			'<tr><th>';
$s_html .= 				'<input type="text" id="total_metal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="total_cristal" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="total_deuterium" size="15" readonly value="0"></th><th>';
$s_html .= 				'<input type="text" id="total_temps" size="15" readonly value="-">';
$s_html .= 				'<input type="hidden" id="total_sec" size="15" value="0"></th>';
$s_html .= 			'</tr><tr><td colspan="7" class="c">';
$s_html .= 				'un total de <span id="total_ressources" style="color:#FF0080;font-weight:bold;">';
$s_html .= 				'0</span> ressources, soit <span id="total_pt" style="color:#0080FF;font-weight:bold;">';
$s_html .= 				'0</span> PT ou <span id="total_gt" style="color:#80FF00;font-weight:bold;">';
$s_html .= 				'0</span> GT';
$s_html .= 			'</td></tr>';
$s_html .= 		'</table>';
$s_html .= '</fieldset>';

$s_html .= '<div style="font-size:10px;width:400px;text-align:center;background-image:url(\'skin/OGSpy_skin/tableaux/th.png\');background-repeat:repeat;">Calculatrice universelle ('.$mod_version.')';
$s_html .= 		'<br>Développé par Aéris';
$s_html .= 		'<br>Mise à jour par <a href="mailto:contact@epe-production.org?subject=ogscalc">xaviernuma</a> 2012';
$s_html .= '</div>';

echo $s_html;

require_once("views/page_tail.php");

?>