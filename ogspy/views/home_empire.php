<?php
/** $Id$ **/
/**
* 
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPYOGAME'))
	die('Hacking attempt');

require_once('includes/ogame.php');

$user_empire		= user_get_empire();
$user_building		= $user_empire['building'];
$user_defence		= $user_empire['defence'];
$user_fleet			= $user_empire['fleet'];
$user_technology	= $user_empire['technology'];

if (!isset($pub_view) || $pub_view == '')
	$view = 'planets';
else if ($pub_view == 'planets' || $pub_view == 'moons')
	$view = $pub_view;
else
	$view = 'planets';

$start = $view == 'planets' ? 1 : 10;

if (isset($pub_alert_empire) && $pub_alert_empire)
	echo 'message('. L_('homeempire_Warning') .');';

$name = $coordinates = $fields = $temperature = $satellite = '';

for ($i = 1 ; $i <= 9 ; $i++)
{
	$name			.= "'".$user_building[$i]["planet_name"]."', ";
	$coordinates	.= "'".$user_building[$i]["coordinates"]."', ";
	$fields			.= "'".$user_building[$i]["fields"]."', ";
	$temperature	.= "'".$user_building[$i]["temperature"]."', ";
	$satellite		.= "'".$user_building[$i]["Sat"]."', ";
}

for ($i = 10 ; $i <= 18 ; $i++)
{
	$name			.= "'".(($user_building[$i]["planet_name"]=="")?L_("common_Moon"):$user_building[$i]["planet_name"])."', ";
	$coordinates	.= "'', ";
	$fields			.= "'1', ";
	$temperature	.= "'".$user_building[$i]["temperature"]."', ";
	$satellite		.= "'".$user_building[$i]["Sat"]."', ";
}

// Creation du template
if (file_exists($user_data['user_skin'].'\templates\home_empire.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\home_empire.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\home_empire.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\home_empire.tpl');
}
else
{
    $tpl = new template('home_empire.tpl');
}

// Traitement des conditions
$tpl->checkIf('is_ddr', $server_config['ddr'] == 1);	// depot de ravitaillement ?
$tpl->checkIf('view_planet', $view == 'planets');		// vue des planètes ?

function Get_Techno_Level($check,$techno,$Lab)
{
	// Défini s'il faut afficher un - ou le niveau de la technologie $techno en fonction d'un niveau de laboratoire $Lab
	global $user_technology, $technology_requirement, $user_building;
	
	if ($check == true)
	{
		$return			= $user_technology[$techno] != '' ? $user_technology[$techno] : '0';
		$requirement	= $technology_requirement[$techno];
		
		while ($value = current($requirement))
		{
			$key = key($requirement);
			
			if (($key == 0 OR $user_technology[$key] < $value) AND $Lab < $value)
				$return = '-';
			
			next($requirement);
		}
	}
	else
		$return = '&nbsp;';
	
	return $return;
}

for ($i = $start ; $i <= $start + 8 ; $i++)
{
	$j = $i - $start + 1;
	
	/* Index, nom et bouton radio */
	
	$tpl->loopVar('10_col', array(
		'VALUE'			=> $view == 'planets' ? $j : $j + 9,
		'PLANET_NAME'	=> $view == 'moons' ? '<br/>'. $user_building[$j]['planet_name'] : '',
		'RADIO'			=> $view != 'moons' || $user_building[$j]['planet_name'] != ''
	));
	
	/* Icone déplacer/effacer */
	
	$tpl->loopVar('move_delete_icons', array(
		'I'				=> $i,
		'LEFT_MOVE'		=> L_('homeempire_LeftMove', $user_building[$i]['planet_name']),
		'DELETE'		=> L_((!isset($pub_view) || $pub_view == 'planets') ? 'homeempire_DeletePlanet' : 'homeempire_DeleteMoon', $user_building[$i]['planet_name']),
		'RIGHT_MOVE'	=> L_('homeempire_RightMove', $user_building[$i]['planet_name']),
		'PLANET'		=> (!isset($pub_view) || $pub_view == 'planets'),
		'SHOW'			=> $user_building[$i]['planet_name'] != ''
	));
	
	/* Nom des planetes */
	
	$tpl->SimpleVar(array(
		'planets_name'. $j	=> ($user_building[$i]['planet_name'] == '') ? '&nbsp;' : $user_building[$i]['planet_name']
	));
	
	/* Coordonnées */
	
	$tpl->SimpleVar(array(
		'planets_coord'. $j	=> ($user_building[$j]['coordinates'] == '' || ($user_building[$j + 9]['planet_name'] == '' && $view == 'moons')) ?
			'&nbsp;' :
			'['. $user_building[$j]['coordinates'] .']'
	));
	
	/* Occupation coses */
	
	$field = $user_building[$i]['fields_used'] .' / '. (($user_building[$i]['fields'] == '0') ? '' : $user_building[$i]['fields']);
	
	if ($field == ' / ')
		$field = '&nbsp;';
	
	$tpl->SimpleVar(array(
		'planets_field'. $j	=> $field
	));
	
	/* Température */
	
	$tpl->SimpleVar(array(
		'planets_temp'. $j	=> ($user_building[$i]['temperature'] == '') ? '&nbsp;' : $user_building[$i]['temperature']
	));
	
	/* Valeur de productions */
	
	$w = array('M', 'C', 'D', 'NRJ');
	
	if($view == 'planets')
	{
		foreach($w as $v)
		{
			if($v != 'NRJ')
				$value = (($t=$user_building[$i][$v]) != '') ? formate_number(production($v, $t)) : '&nbsp;';
			else
			{
				$NRJ =	production('CES', $user_building[$i]['CES']) +
						production('CEF', $user_building[$i]['CEF']) +
						production_sat($user_building[$i]['temperature']) * $user_building[$i]['Sat'];
				
				$value = ($NRJ != '0') ? formate_number($NRJ) : '&nbsp;';
			}
			
			$tpl->SimpleVar(array(
				'prod_'. $v . $j	=> $value
			));
		}
	}
	
	/* Batiments */
	
	if ($view == "planets")
		$w = array('M', 'C', 'D', 'CEF', 'CES', 'UdR', 'UdN', 'CSp', 'HM', 'HC', 'HD', 'Lab', 'DdR', 'Ter', 'Silo');
	else
		$w= array('UdR', 'CSp', 'HM', 'HC', 'HD', 'BaLu', 'Pha', 'PoSa');
	
	foreach ($w as $v)
	{
		$tpl->SimpleVar(array(
			'building_'. $v . $j .'_value'	=> (isset($user_building[$i][$v]) && $user_building[$i][$v] != '') ? ($user_building[$i][$v] == 0 ? '-' : formate_number($user_building[$i][$v])) : '&nbsp;',
			'building_'. $v . $j .'_Index'	=> $i + 1 - $start
		));
	}
	
	/* Technologie */
	
	$w = array('Esp', 'Ordi', 'Armes', 'Bouclier', 'Protection', 'NRJ', 'Hyp', 'RC', 'RI', 'PH', 'Laser', 'Ions', 'Plasma', 'RRI', 'Expeditions', 'Graviton');
	
	if ($view == 'planets')
	{
		foreach($w as $v)
		{
			$tpl->SimpleVar(array(
				'techno_'. $v . $j .'_value'	=> Get_Techno_Level($user_building[$j][0], $v, $user_building[$j]['Lab']),
				'techno_'. $v . $j .'_Index'	=> $j
			));
		}
	}
	
	/* Defense */
	
	if ($view == 'planets')
		$w = array('LM', 'LLE', 'LLO', 'CG', 'AI', 'LP', 'PB', 'GB', 'MIC', 'MIP');
	else
		$w = array('LM', 'LLE', 'LLO', 'CG', 'AI', 'LP', 'PB', 'GB');
	
	foreach($w as $v)
	{
		$tpl->SimpleVar(array(
			'defence_'. $v . $j .'_value'	=> $user_defence[$i][$v] != '' ? ($user_defence[$i][$v] == 0 ? '-' : formate_number($user_defence[$i][$v])) : '&nbsp;',
			'defence_'. $v . $j .'_Index'	=> $i + 1 - $start
		));
	}
	
	/* Flotte */
	
	$w = array('PT', 'GT', 'CLE', 'CLO', 'CR', 'VB', 'VC', 'REC', 'SE', 'BMD', 'SAT', 'DST', 'EDLM', 'TRA');
	
	foreach($w as $v)
	{
		$tpl->SimpleVar(array(
			'fleet_'. $v . $j .'_value'	=> $user_fleet[$i][$v] != '' ? ($user_fleet[$i][$v] == 0 ? '-' : formate_number($user_fleet[$i][$v])) : '&nbsp;',
			'fleet_'. $v . $j .'_Index' => $i + 1 -$start
		));
	}
}

// Simples variables texte
$tpl->simpleVar(array(
	'HOME_WARNING' => L_("homeempire_Warning"),
	'PLANETS_NAMES' => substr($name, 0, strlen($name)-2),
	'PLANETS_COORDS' => substr($coordinates, 0, strlen($coordinates)-2),
	'PLANETS_FIELDS' => substr($fields, 0, strlen($fields)-2),
	'PLANETS_TEMPS' => substr($temperature, 0, strlen($temperature)-2),
	'PLANETS_SATS' => substr($satellite, 0, strlen($satellite)-2),
	'HOME_TEXTAREA' => L_("homeempire_Textarea"),
	'PASTEINFO' => L_("homeempire_pateinfo"),
	'PLANETS' => L_("common_Planets"),
	'MOONS' => L_("common_Moons"),
	'PASTE' => L_("homeempire_Paste"),
	'EMPIRE' => L_("homeempire_Empire"),
	'EMPIRE_TIPS' => " (".($view=="moons"?L_("common_Moons"):L_("common_Planets")).") ".help("home_commandant"),
	'VIEW' => $view,
	'MUST_CHOOSE_PLANET' => L_("homeempire_Warning2"),
	'BUILDING' => L_("incgal_buildings"),
	'DEFENCE' => L_("incgal_defense"),
	'FLEET' => L_("incgal_fleet"),
	'TECHNO' => L_("homeempire_Technology"),
	'SEND_BTN' => L_("homeempire_Send"),
	'SELECT_PLANET' => L_("homeempire_SelectPlanet"),
	'TITLE_PLANET_NAME' => L_("homeempire_PlanetName"),
	'TITLE_PLANET_COORDS' => L_("homeempire_Coordinates"),
	'TITLE_PLANET_FIELDS' => L_("homeempire_Field"),
	'TITLE_PLANET_TEMPS' => L_("homeempire_TemperatureMax"),
	'TITLE_PLANET_SATS' => L_("homeempire_Satnumbber"),
	'GENERAL_INFO' => L_("homeempire_GeneralInfo"),
	'PRODUCTION' =>L_("homeempire_Production"),
	'METAL' => L_("homeempire_Metal"),
	'CRISTAL' => L_("homeempire_Crystal"),
	'DEUTERIUM' => L_("homeempire_Deuterium"),
	'ENERGY' => L_("homeempire_Energy"),
	'METALMINE' => L_("homeempire_MetalMine"),
	'CRISTALMINE' => L_("homeempire_CrystalMine"),
	'DEUTMINE' => L_("homeempire_DeuteriumSynthesizer"),
	'SOLARPLANT' => L_("homeempire_SolarPlant"),
	'FUSIONREACTOR' => L_("homeempire_FusionReactor"),
	'ROBOTICFACTORY' => L_("homeempire_RoboticsFactory"),
	'NANITEFACTORY' => L_("homeempire_NaniteFactory"),
	'SHIPYARD' => L_("homeempire_Shipyard"),
	'METALSTORAGE' => L_("homeempire_MetalStorage"),
	'CRISTALSTORAGE' => L_("homeempire_CrystalStorage"),
	'DEUTERIUMTANK' => L_("homeempire_DeuteriumTank"),
	'RESEARCHLAB' => L_("homeempire_ResearchLab"),
	'DEPOTRAV' => L_("homeempire_DepoRav"),
	'TERRAFORMER' => L_("homeempire_Terraformer"),
	'MISSILESSILO' => L_("homeempire_MissileSilo"),
	'LUNARBASE' => L_("homeempire_LunarBase"),
	'PHALANX' => L_("homeempire_SensorPhalanx"),
	'JUMPGATE' => L_("homeempire_JumpGate"),
	'OTHERS' => L_("homeempire_Various"),
	'TECHNOLOGY' => L_("homeempire_Technology"),
	'SPY_TECH' => L_("homeempire_EspionageTechnology"),
	'COMPUTER_TECH' => L_("homeempire_ComputerTechnology"),
	'WEAPONS_TECH' => L_("homeempire_WeaponsTechnology"),
	'SHIELD_TECH' => L_("homeempire_ShieldingTechnology"),
	'ARMOR_TECH' => L_("homeempire_ArmourTechnology"),
	'ENERGY_TECH' => L_("homeempire_EnergyTechnology"),
	'HYPERSPACE_TECH' => L_("homeempire_HyperspaceTechnology"),
	'COMBUSTION_DRIVE' => L_("homeempire_CombustionDrive"),
	'IMPULSE_DRIVE' => L_("homeempire_ImpulseDrive"),
	'HYPERSPACE_DRIVE' => L_("homeempire_HyperspaceDrive"),
	'LASER_TECH' => L_("homeempire_LaserTechnology"),
	'ION_TECH' => L_("homeempire_IonTechnology"),
	'PLASMA_TECH' => L_("homeempire_PlasmaTechnology"),
	'RESEARCH_NETWORK' => L_("homeempire_IntergalacticResearchNetwork"),
	'EXPEDITIONS' => L_("homeempire_expeTechnology"),
	'GRAVITON' => L_("homeempire_GravitonTechnology"),
	'ROCKET_LAUNCHER' => L_("homeempire_RocketLauncher"),
	'LIGHT_LASER' => L_("homeempire_LightLaser"),
	'HEAVY_LASER' => L_("homeempire_HeavyLaser"),
	'GAUSS_CANON' => L_("homeempire_GaussCannon"),
	'ION_CANON' => L_("homeempire_IonCannon"),
	'PLASMA_CANON' => L_("homeempire_PlasmaTuret"),
	'SMALL_SHIELD' => L_("homeempire_SmallShield"),
	'LARGE_SHIELD' => L_("homeempire_LargeShield"),
	'ANTI_MISSILE' => L_("homeempire_AntiBallisticMissiles"),
	'INTERPLANET_MISSILE' => L_("homeempire_InterplanetaryMissiles"),
	'SMALLCARGO' => L_("homeempire_SmallCargo"),
	'LARGECARGO' => L_("homeempire_LargeCargo"),
	'LIGHTFIGHTER' => L_("homeempire_LightFighter"),
	'HEAVYFIGHTER' => L_("homeempire_HeavyFighter"),
	'CRUISER' => L_("homeempire_Cruiser"),
	'BATTLESHIP' => L_("homeempire_Battleship"),
	'COLONYSHIP' => L_("homeempire_ColonyShip"),
	'RECYCLER' => L_("homeempire_Recycler"),
	'ESPIONAGEPROBE' => L_("homeempire_EspionageProbe"),
	'BOMBER' => L_("homeempire_Bomber"),
	'SOLARSATELLITE' => L_("homeempire_SolarSatellite"),
	'DESTROYER' => L_("homeempire_Destroyer"),
	'DEATHSTAR' => L_("homeempire_Deathstar"),
	'BATTLECRUISER' => L_("homeempire_Battlecruiser")
));

// Traitement et affichage du template
$tpl->parse();