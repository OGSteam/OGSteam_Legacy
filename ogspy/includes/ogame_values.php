<?php
/** $Id$ **/
/**
* Fichier des constantes et variables OGame (pour les Modules)
* @package OGSpy
* @subpackage Main
* @copyright Copyright &copy; 2009, http://ogsteam.fr/
* @modified $Date$
* @author Sylar
* @link $HeadURL$
* @version 3.04b ( $Rev$ ) 
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

// Technologie Requirement
$technology_requirement["Esp"] = array(3);
$technology_requirement["Ordi"] = array(1);
$technology_requirement["Armes"] = array(4);
$technology_requirement["Bouclier"] = array(6, "NRJ" => 3);
$technology_requirement["Protection"] = array(2);
$technology_requirement["NRJ"] = array(1);
$technology_requirement["Hyp"] = array(1, "NRJ" => 3, "Bouclier" => 5);
$technology_requirement["RC"] = array(1, "NRJ" => 1);
$technology_requirement["RI"] = array(2, "NRJ" => 1);
$technology_requirement["PH"] = array(7, "HYP" => 3);
$technology_requirement["Laser"] = array(1, "NRJ" => 2);
$technology_requirement["Ions"] = array(4, "Laser" => 5, "NRJ" => 4);
$technology_requirement["Plasma"] = array(4, "NRJ" => 8, "Laser" => 10, "Ions" => 5);
$technology_requirement["RRI"] = array(10, "Ordi" => 8, "Hyp" => 8);
$technology_requirement["Graviton"] = array(12);
$technology_requirement["Expeditions"] = array(3, "Esp" => 4, "RI" => 3);


//
$fleet_price = Array(
	'SC' => Array(2000,2000,0),				// Small Cargo - Petit Transporteur
	'LC' => Array(6000,6000,0),				// Large Cargo - Grand Transporteur
	'LF' => Array(3000,1000,0),				// Light Fighter - Chasseur Léger
	'HF' => Array(6000,4000,0),				// Heavy Fighter - Chasseur Lourd
	'CR' => Array(20000,7000,2000),			// Cruiser - Croiseur
	'BS' => Array(45000,15000,0),			// BattleShip - Vaisseau de Bataille
	'CS' => Array(10000,20000,10000),		// Colony Ship - Vaisseau de Colonisation
	'RC' => Array(10000,6000,2000),			// Recycler - Recycleur
	'EP' => Array(0,1000,0),				// Espionnage Probe - Sonde d'Espionnage
	'BO' => Array(50000,25000,15000),		// Bomber - Bombardier
	'SS' => Array(0,2000,500),				// Solar Satellite - Satellite Solaire
	'DE' => Array(60000,50000,15000),		// Destroyer - Destructeur
	'BC' => Array(30000,40000,15000),		// BattleCruiser - Traqueur
	'DS' => Array(5000000,4000000,1000000)	// Death Star - Etoile de la Mort
);
//
$building_price = Array(
	'MM' => Array(0,0,0), 					// Metal Mine - Mine de métal
	'CM' => Array(0,0,0), 					// Crystal Mine - Mine de cristal
	'DS' => Array(0,0,0), 					// Deuterium Synthetiser - Synthétiseur de deutérium
	'SP' => Array(0,0,0), 					// Solar Plant - Centrale électrique solaire
	'FR' => Array(900,360,180), 			// Fusion Reactor - Centrale électrique de fusion
	'RF' => Array(400,120,200), 			// Robotic Factory - Usine de robots
	'NF' => Array(1000000,500000,100000),	// Nanite Factory - Usine de nanites
	'SY' => Array(400,200,100), 			// Ship Yard - Chantier spatial
	'MS' => Array(4000,0,0), 				// Metal Storage - Hangar de métal
	'CS' => Array(2000,1000,0), 			// Crystal Storage - Hangar de cristal
	'DT' => Array(2000,2000,0), 			// Deuterium Tank - Réservoir de deutérium
	'RL' => Array(200,400,200), 			// ResearchLab - Laboratoire de recherche
	'AD' => Array(20000,40000,0), 			// Alliance Depot - Dépôt de ravitaillement
	'TF' => Array(0,50000,100000), 			// Terraformer - Terraformeur
	'MS' => Array(20000,20000,1000), 		// Missile Silo - Silo de missiles
	'LB' => Array(0,0,0), 					// Lunar Base - Base lunaire
	'SX' => Array(0,0,0), 					// Sensor Phalanx - Phalange de capteur
	'JG' => Array(0,0,0) 					// JumpGate - Porte de saut spatial
);
//
$defence_price = Array(
	'RL' => Array(2000,0,0), 				// Rocket Launcher - Lanceur de missiles
	'LL' => Array(1500,500,0),				// Light Laser - Artillerie laser légère
	'HL' => Array(6000,2000,0), 			// Heavy Laver - Artillerie laser lourde
	'GC' => Array(20000,15000,2000),		// Gauss Canon - Canon de Gauss
	'IC' => Array(2000,6000,0), 			// Ion Canon - Artillerie à ions
	'PT' => Array(50000,50000,30000),		// Plasma Turret - Lanceur de plasma
	'SS' => Array(10000,10000,0), 			// Small Shield Dome - Petit bouclier
	'LS' => Array(50000,50000,0), 			// Large Shield Dome - Grand bouclier
	'AM' => Array(0,8000,2000), 			// Anti-Ballistic Missle - Missile Interception
	'IM' => Array(12000,2500,10000) 		// Interplanetary Missile - Missile Interplanétaire
);
//
$technology_price = Array(
	'ES' => Array(200,1000,200),			// Espionage Technology - Technologie Espionnage
	'CO' => Array(0,400,600),				// Computer Technology - Technologie Ordinateur
	'WE' => Array(0,800,200), 				// Weapon Technology - Technologie Armes
	'SH' => Array(200,600,0), 				// Shielding Technology - Technologie Bouclier
	'AR' => Array(2000,0,0), 				// Armour Technology - Technologie Protection des vaisseaux spatiaux
	'EN' => Array(0,1500,800),				// Energy Technology - Technologie Energie
	'HY' => Array(0,4000,2000),				// Hyperspace Technology - Technologie Hyperespace
	'CD' => Array(400,600,0),				// Combustion Drive - Réacteur à combustion
	'ID' => Array(2000,4000,600),			// Impulsion Drive - Réacteur à impulsion
	'HD' => Array(10000,20000,6000),		// Hyperspace Drive - Propulsion hyperespace
	'LA' => Array(0,200,100), 				// Laser Technology - Technologie Laser
	'IO' => Array(1000,300,100), 			// Ion Technology - Technologie Ions
	'PL' => Array(2000,4000,1000), 			// Plasma Technology - Technologie Plasma
	'IN' => Array(240000,400000,160000),	// Intergalactic Research Network - Réseau de recherche intergalactique
	'EX' => Array(4000,8000,4000) 			// Expedtion TEchnology - Technologie Expéditions
);
?>
