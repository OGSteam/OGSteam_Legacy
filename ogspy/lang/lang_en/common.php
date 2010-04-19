<?php
/***************************************************************************
*	filename	: common.php
*	generated	: on 02/2/2009 at 22:24:09
*	created by	: capi
***************************************************************************/
$lang['basic_Yes'] = 'Yes';
$lang['basic_No'] = 'No';
$lang['basic_Ok'] = 'Ok';
$lang['basic_Cancel'] = 'Cancel';
$lang['help_help'] = 'Help';
//$lang['common_Date'] = 'M j Y at Gh';
$lang['common_Date'] = 'F,jS Y \a\t G:i';

// Basic
$lang['admin_name'] = 'Name:';
$lang['common_Player'] = 'Player';
$lang['common_Players'] = 'Players';
$lang['common_Ally'] = 'Alliance';
$lang['common_Allys'] = 'Alliances';
$lang['common_Planet'] = 'Planet';
$lang['common_Planets'] = 'Planets';
$lang['common_Galaxy'] = 'Galaxy';
$lang['common_Moons'] = 'Moons';
$lang['common_Moon'] = 'Moon';
$lang['common_Galaxies'] = 'Galaxy';
$lang['common_System'] = 'System';
$lang['common_Systems'] = 'Systems';
$lang['common_Row'] = 'Rank';

$lang['ogame_Metal'] = 'Metal';
$lang['ogame_Crystal'] = 'Cristal';
$lang['ogame_Deuterium'] = 'Deuterium';
$lang['ogame_Energy'] = 'Energy';

// includes/galaxy.php & user.php
$lang['incgal_probadestruction'] = 'Chance of counter-espionage: %s %%';
//$lang['incgal_noactivity'] = 'The espionages probe haven\'t detected any atmospheric anomalies on this planet. Any activity on this planet during the last hour can be excluded.';
//$lang['incgal_showactivity'] = 'Your espionage report shows abnormalities in the atmosphere of the planet which suggests activity within the last %s minutes.';
// %1 = planet name, %2 = coords, %3 dateRE
$lang['incgal_ressourceson'] = 'Resources at %1$s [%2$s] on %3$s';
$lang['incgal_fleet'] = 'Fleets';
$lang['incgal_defense'] = 'Defense';
$lang['incgal_buildings'] = 'Buildings';
$lang['incgal_research'] = 'Technology';
$lang['empire_Vaisseaux'] = 'Fleets';
$lang['search_Rank'] = 'Ranking';

// Affichage du raport de combat
// Fonction user.php/UNparseRC
$lang['incusr_RC_Date'] = 'm-d H:i:s';
$lang['incusr_RC_Title'] = 'on %1 the following fleets met in battle in %2';
$lang['incusr_RC_Att'] = 'Attacker %1  Weapons:%2%% Shields: %3%% Armour: %4%%';
$lang['incusr_RC_Def'] = 'Defender %1  Weapons:%2%% Shields: %3%% Armour: %4%%';
$lang['incusr_RC_Type'] = 'Type';
$lang['incusr_RC_Nombre'] = 'Total';
$lang['incusr_RC_Armes'] = 'Weapons';
$lang['incusr_RC_Bouclier'] = 'Shields';
$lang['incusr_RC_Coque'] = 'Armour';
$lang['incusr_RC_Detruit'] = 'Destroyed';
$lang['incusr_RC_AttShoot'] = 'The attacking fleet fires %1 times at the defender, with a total firepower of %2. The defender\'s shields absorb %3 damage points';
$lang['incusr_RC_DefShoot'] = 'The defending fleet fires %1 times at the attacker, with a total firepower of %2. The attacker\'s shields absorb %3 damage points.';
$lang['incusr_RC_MatchNul'] = 'The battle as end by a tie, each fleets have return to their respective planets.';
$lang['incusr_RC_AttWin'] = 'The attacker has won the battle! He captured %1 metal, %2 crystal and %3 deuterium. ';
$lang['incusr_RC_DefWin'] = 'The defender has won the battle.';
$lang['incusr_RC_AttPertes'] = 'The attacker lost a total of %1 units.';
$lang['incusr_RC_DefPertes'] = 'The defender lost a total of %1 units.';
$lang['incusr_RC_CDR'] = 'At these space coordinates now float %1 metal and %2$ crystal.';
$lang['incusr_RC_Proba'] = 'The probability of a moon creation is of %s %%';

// Empire 
//Batiments
$lang['building_M'] = 'Metal Mine';
$lang['building_C'] = 'Crystal Mine';
$lang['building_D'] = 'Deuterium Synthesizer';
$lang['building_CES'] = 'Solar Plant';
$lang['building_CEF'] = 'Fusion Reactor';
$lang['building_UdR'] = 'Robotics Factory';
$lang['building_UdN'] = 'Nanite Factory';
$lang['building_CSp'] = 'Shipyard';
$lang['building_HM'] = 'Metal Storage';
$lang['building_HC'] = 'Crystal Storage';
$lang['building_HD'] = 'Deuterium Tank';
$lang['building_Lab'] = 'Research Lab';
$lang['building_Ter'] = 'Terraformer';
$lang['building_Silo'] = 'Missile Silo';
$lang['building_DdR'] = 'Alliance Depot';
$lang['building_BaLu'] = 'Lunar Base';
$lang['building_Pha'] = 'Sensor Phalanx';
$lang['building_PoSa'] = 'Jump Gate';
// Defense
$lang['defence_LM'] = 'Rocket Launcher';
$lang['defence_LLE'] = 'Light Laser';
$lang['defence_LLO'] = 'Heavy Laser';
$lang['defence_CG'] = 'Gauss Cannon';
$lang['defence_AI'] = 'Ion Cannon';
$lang['defence_LP'] = 'Plasma Turret';
$lang['defence_PB'] = 'Small Shield Dome';
$lang['defence_GB'] = 'Large Shield Dome';
$lang['defence_MIC'] = 'Anti-Ballistic Missiles';
$lang['defence_MIP'] = 'Interplanetary Missiles';
//Technologies
$lang['techno_Esp'] = 'Espionage Technology';
$lang['techno_Ordi'] = 'Computer Technology';
$lang['techno_Armes'] = 'Weapons Technology';
$lang['techno_Bouclier'] = 'Shielding Technology';
$lang['techno_Protection'] = 'Armour Technology';
$lang['techno_NRJ'] = 'Energy Technology';
$lang['techno_Hyp'] = 'Hyperspace Technology';
$lang['techno_RC'] = 'Combustion Drive';
$lang['techno_RI'] = 'Impulse Drive';
$lang['techno_PH'] = 'Hyperspace Drive';
$lang['techno_Laser'] = 'Laser Technology';
$lang['techno_Ions'] = 'Ion Technolog';
$lang['techno_Plasma'] = 'Plasma Technology';
$lang['techno_RRI'] = 'Intergalactic Research Network';
$lang['techno_Graviton'] = 'Graviton Technology';
$lang['techno_Expeditions'] = 'Expedition Technology';
//Fleets
$lang['fleet_PT'] = 'Small Cargo';
$lang['fleet_GT'] = 'Large Cargo';
$lang['fleet_CLE'] = 'Light Fighter';
$lang['fleet_CLO'] = 'Heavy Fighter';
$lang['fleet_CR'] = 'Cruiser';
$lang['fleet_VB'] = 'Battleship';
$lang['fleet_VC'] = 'Colony Ship';
$lang['fleet_REC'] = 'Recycler';
$lang['fleet_SE'] = 'Espionage Probe';
$lang['fleet_BMD'] = 'Bomber';
$lang['fleet_SAT'] = 'Solar Satellite';
$lang['fleet_DST'] = 'Destroyer';
$lang['fleet_TRA'] = 'Battlecruiser';
$lang['fleet_EDLM'] = 'Deathstar';

$lang['common_AjaxEndLoad'] = 'Loading complete';
$lang['common_AjaxEndLoadAndTime'] = 'Loading finished in %s sec';
$lang['common_AjaxChargement'] = 'Loading ...';
$lang['common_AjaxSessionExpire'] = 'Session expired';
$lang['common_AjaxError'] = 'Your browser does not support Ajax, please post on the forum of your problem OGSteam';
?>
