<?php

/***************************************************************************
*	filename	: flottes_lang.php
*	desc.		: 1.03
*	Author		: 
*	created		: 17/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/


// def de qq variable
define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");
define("TABLE_MOD_FLOTTES_ADM", $table_prefix."mod_flottes_admin");



if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$request= "SELECT config_value FROM ".TABLE_CONFIG." WHERE config_name='language'";
if($result = $db->sql_query($request)) {
	while($ligne = mysql_fetch_row($result)) {	
		$dblang=$ligne[0];
	}
}
else {
	$dblang='NLG';
}		

	
$request= "SELECT GAME, nbpla FROM ".TABLE_MOD_FLOTTES_ADM." WHERE group_name='mod_flottes'";
if($result = $db->sql_query($request)) {
	while($ligne = mysql_fetch_row($result)) {	
		$GA=$ligne[0];
		$PLA=$ligne[1];
	}
}
else {
	$GA='OGAME';
}	

if ($GA=='UNIVERS')
{
	
// affichage
$gameselect='UNIVERS';
$phpfonc="univers";
$nplapage=$PLA;
$lib_page=array("Planètes ","Planètes ","Planètes ","Planètes ","Planètes ","Planètes ","Planètes ","Planètes ","Planètes ");
	
// version antérieure à la 3.10
if ($dblang='NLG') {
$LANG["ogame_Metal"] = "Titane";
$LANG["ogame_Crystal"] = "Carbone";
$LANG["ogame_Deuterium"] = "Tritium";
$LANG["ogame_Energy"] = "Energie";
$LANG["ogame_MetalMine"] = "Mine de titane";
$LANG["ogame_CrystalMine"] = "Mine de carbone";
$LANG["ogame_DeuteriumSynthesizer"] = "Extracteur de Tritium";
$LANG["ogame_SolarPlant"] = "Centrale Géothermique";
$LANG["ogame_FusionReactor"] = "Centrale à tritium";
$LANG["ogame_RoboticsFactory"] = "Usine de droïdes";
$LANG["ogame_NaniteFactory"] = "Usine d'Androïdes";
$LANG["ogame_Shipyard"] = "Usine d'armement";
$LANG["ogame_MetalStorage"] = "Silo de Titane";
$LANG["ogame_CrystalStorage"] = "Silo de Carbone";
$LANG["ogame_DeuteriumTank"] = "Silo de tritium";
$LANG["ogame_ResearchLab"] = "Centre Technique";
$LANG["ogame_Converter"] = "Convertisseur moléculaire";
$LANG["ogame_Terraformer"] = "Terraformeur";
$LANG["ogame_MissileSilo"] = "Hangar de missiles";
$LANG["ogame_LunarBase"] = "Base lunaire";
$LANG["ogame_SensorPhalanx"] = "Phalange de capteur";
$LANG["ogame_JumpGate"] = "Porte de saut spatial";
$LANG["ogame_EspionageTechnology"] = "Espionnage";
$LANG["ogame_ComputerTechnology"] = "Quantique";
$LANG["ogame_Alliages"] = "Alliages";
$LANG["ogame_Strat"] = "Stratification carbone";
$LANG["ogame_Raffinerie"] = "Raffinerie";
$LANG["ogame_WeaponsTechnology"] = "Armement";
$LANG["ogame_ShieldingTechnology"] = "Bouclier";
$LANG["ogame_ArmourTechnology"] = "Blindage";
$LANG["ogame_EnergyTechnology"] = "Thermodynamique";
$LANG["ogame_HyperspaceTechnology"] = "Antimatière";
$LANG["ogame_CombustionDrive"] = "HyperDrive";
$LANG["ogame_ImpulseDrive"] = "Impulsion";
$LANG["ogame_HyperspaceDrive"] = "Warp";
$LANG["ogame_LaserTechnology"] = "Smart";
$LANG["ogame_IonTechnology"] = "Ions";
$LANG["ogame_PlasmaTechnology"] = "Aereon";
$LANG["ogame_IntergalacticResearchNetwork"] = "Super Calculateur";
$LANG["ogame_GravitonTechnology"] = "Graviton";
$LANG["ogame_Admi"] = "Administration";
$LANG["ogame_Expl"] = "Exploitation";
$LANG["ogame_RocketLauncher"] = "BFG";
$LANG["ogame_LightLaser"] = "Smart BFG";
$LANG["ogame_HeavyLaser"] = "Plate-Forme Canon";
$LANG["ogame_GaussCannon"] = "Déflecteurs";
$LANG["ogame_IonCannon"] = "Plate-Forme Ionique";
$LANG["ogame_PlasmaTuret"] = "Aereon Missile Defense";
$LANG["ogame_SmallShield"] = "Champ de force";
$LANG["ogame_LargeShield"] = "Holochamp";
$LANG["ogame_AntiBallisticMissiles"] = "Contre Mesure Electromagnétique";
$LANG["ogame_InterplanetaryMissiles"] = "Missile EMP";
$LANG["ogame_TemperatureMax"] = "Température Max";
$LANG["ogame_Temperature"] = "Température";
$LANG["ogame_Field"] = "Cases";
$LANG["ogame_Coordinates"] = "Coordonnées";
$LANG["ogame_Empire"] = "Empire";
$LANG["ogame_Building"] = "Bâtiments";
$LANG["ogame_Defence"] = "Défenses";
$LANG["ogame_Research"] = "Recherches";
$LANG["ogame_Technology"] = "Technologies";

}	
	// Flotte UNIVERS
$mod_flottes_lang["planet_name"]= "Nom Planet";
$mod_flottes_lang["coordinates"]= "Coordonnées";
$mod_flottes_lang["planet_id"]= "ID Planet";
$mod_flottes_lang["PT"] = "Navette PT";
$mod_flottes_lang["GT"] = "Navette GT";
$mod_flottes_lang["CLE"] = "Chasseur";
$mod_flottes_lang["CLO"] = "Chasseur Lance";
$mod_flottes_lang["CR"] = "Frégate d'assaut";
$mod_flottes_lang["VB"] = "Destroyer";
$mod_flottes_lang["VC"] = "Colonisateur";
$mod_flottes_lang["REC"] = "Collecteur";
$mod_flottes_lang["SE"] = "Sonde";
$mod_flottes_lang["BMD"] = "Overlord";
$mod_flottes_lang["DST"] = "Forteresse Noire";
$mod_flottes_lang["EDLM"] = "Hyperion";
$mod_flottes_lang["TRA"] = "Vaisseau Extracteur";
$mod_flottes_lang["SAT"] = "Satellite solaire";

$lib_flottes_lang["planet_name"]= "Nom Planet";
$lib_flottes_lang["coordinates"]= "Coordonnées";
$lib_flottes_lang["planet_id"]= "ID Planet";
$lib_flottes_lang["PT"] = "PT-5";
$lib_flottes_lang["GT"] = "GT-50";
$lib_flottes_lang["CLE"] = "Chasseur";
$lib_flottes_lang["CLO"] = "C. Lance";
$lib_flottes_lang["CR"] = "FdAssaut";
$lib_flottes_lang["VB"] = "Destruct";
$lib_flottes_lang["VC"] = "Colonis";
$lib_flottes_lang["REC"] = "Collect";
$lib_flottes_lang["SE"] = "Sonde";
$lib_flottes_lang["BMD"] = "Overlord";
$lib_flottes_lang["DST"] = "F. Noire";
$lib_flottes_lang["EDLM"] = "Hyperion";
$lib_flottes_lang["TRA"] = "Extract";
$lib_flottes_lang["SAT"] = "SAT";

// Nom, Coût, Bouclier, Attaque, Fret, Vitesse, Conso

$vaisseaux_lang[1]=array ("Navette PT-5","4500","5","25","5000","5000","20");
$vaisseaux_lang[2]=array ("Navette GT-50","45000","25","5","50000","8000","200");
$vaisseaux_lang[3]=array ("Chasseur","4500","10","150","50","12500","20");
$vaisseaux_lang[4]=array("Chasseur Lance","12000","25","300","100","10000","75");
$vaisseaux_lang[5]=array ("Frégate d'assaut","35500","50","600","1000","15000","250");
$vaisseaux_lang[6]=array ("Destroyer","60000","200","1250","1250","10000","350");
$vaisseaux_lang[7]=array ("Colonisateur","40000","100","50","7500","2500","1000");
$vaisseaux_lang[8]=array ("Collecteur","14000","10","1","20000","3000","300");
$vaisseaux_lang[9]=array ("Sonde","1500","1","0","5","100000000","1");
$vaisseaux_lang[10]=array ("Overlord","105000","500","1500","500","3500","750");
$vaisseaux_lang[11]=array ("Forteresse Noire","170000","500","2500","2000","5000","1000");
$vaisseaux_lang[12]=array ("Hyperion","22500000","50000","200000","2500000","100","10");
$vaisseaux_lang[13]=array ("Vaisseau Extracteur","125000","1500","1","5000","500","1000");
$vaisseaux_lang[14]=array ("Satellite solaire","3000","1","0","0","0","0");

// champs de la table user_defence
	$mic_lang="CME";
	$mip_lang="EMP";
	$pb_lang="CF";
	$gb_lang="Ho";
	$lm_lang="BFG";
	$lle_lang="SBFG";
	$llo_lang="PFC";
	$cg_lang="DeF";
	$ai_lang="PFI";
	$lp_lang="AMD";

//	production
	$m_lang="Ti";
	$c_lang="Ca";
	$d_lang="Tr";
	
// batiments
	$cef_lang="CaT";
	$ces_lang="CG";
	$udr_lang="UdD";
	$udn_lang="UdA";
	$csp_lang="UA";
	$hm_lang="STi";
	$hc_lang="SCa";
	$hd_lang="STr";
	$lab_lang="CT";
	$ter_lang="Ter";
	$silo_lang="HM";
	$balu_lang="BaLu";
	$pha_lang="Pha";
	$posa_lang="PoSa";
	$cm_lang="CM";
	
// recherches	
	$esp_lang="Esp";
	$ordi_lang="Qua";
	$alli_lang="Alli";
	$sc_lang="SC";
	$raf_lang="Raf";
	$armes_lang="Armes";
	$bouclier_lang="Bouclier";
	$protec_lang="Blindage";
	$nrj_lang="Ther";
	$hyp_lang="Anti";
	$rc_lang="HD";
	$ri_lang="Imp";
	$ph_lang="Warp";
	$laser_lang="Smart";
	$ions_lang="Ions";
	$plasma_lang="Aereon";
	$rri_lang="SCa";
	$grav_lang="Graviton";	
	
	// Valeur défense Total
	$mic_rec = 7000;
	$mip_rec= 28000;
	$lm_rec=   3000;
	$lle_rec=  3500;
	$llo_rec=  10500;
	$ai_rec=  9000;
	$cg_rec= 37000;
	$lp_rec= 125000;
	$pb_rec=  20000;
	$gb_rec= 100000;
	
	// Valeur recyclage Metal/Titane -  Cristal/Carbone
	$sat_rec=array("0","2500"); 
	$PT_rec=  array("3000","1500");  
	$GT_rec= array("25000","20000"); 
	$CLE_rec= array("3500","1000"); 
	$CLO_rec=  array("7000","5000"); 
	$CR_rec=array("22000","10000"); 
	$VB_rec= array("45000","15000"); 
	$VC_rec= array("10000","20000"); 
	$REC_rec=array("12500","5000"); 
	$SE_rec= array("500","1000"); 
	$BMD_rec= array("60000","25000"); 
	$DST_rec= array("75000","70000"); 
	$EDLM_rec=array("10000000","10000000"); 
	$TRA_rec=  array("50000","50000"); 
	
	$coef_rec=0.35;
	
// FIN UNIVERS
	
}

else
{

// affichage
$gameselect='OGAME';
$phpfonc="ogame";
$nplapage=11;
$lib_page=array("Planètes ","Lunes ","","","","","","","");
	
// version antérieure à la 3.10
if ($dblang='NLG') {
$LANG["ogame_Metal"] = "Métal";
$LANG["ogame_Crystal"] = "Cristal";
$LANG["ogame_Deuterium"] = "Deutérium";
$LANG["ogame_Energy"] = "Energie";
$LANG["ogame_MetalMine"] = "Mine de métal";
$LANG["ogame_CrystalMine"] = "Mine de cristal";
$LANG["ogame_DeuteriumSynthesizer"] = "Synthétiseur de deutérium";
$LANG["ogame_SolarPlant"] = "Centrale électrique solaire";
$LANG["ogame_FusionReactor"] = "Centrale électrique de fusion";
$LANG["ogame_RoboticsFactory"] = "Usine de robots";
$LANG["ogame_NaniteFactory"] = "Usine de nanites";
$LANG["ogame_Shipyard"] = "Chantier spatial";
$LANG["ogame_MetalStorage"] = "Hangar de métal";
$LANG["ogame_CrystalStorage"] = "Hangar de cristal";
$LANG["ogame_DeuteriumTank"] = "Réservoir de deutérium";
$LANG["ogame_ResearchLab"] = "Laboratoire de recherche";
$LANG["ogame_Terraformer"] = "Terraformeur";
$LANG["ogame_MissileSilo"] = "Silo de missiles";
$LANG["ogame_LunarBase"] = "Base lunaire";
$LANG["ogame_SensorPhalanx"] = "Phalange de capteur";
$LANG["ogame_JumpGate"] = "Porte de saut spatial";
$LANG["ogame_EspionageTechnology"] = "Technologie espionnage";
$LANG["ogame_ComputerTechnology"] = "Technologie ordinateur";
$LANG["ogame_WeaponsTechnology"] = "Technologie armes";
$LANG["ogame_ShieldingTechnology"] = "Technologie bouclier";
$LANG["ogame_ArmourTechnology"] = "Technologie protection des vaisseaux";
$LANG["ogame_EnergyTechnology"] = "Technologie énergie";
$LANG["ogame_HyperspaceTechnology"] = "Technologie hyperespace";
$LANG["ogame_CombustionDrive"] = "Réacteur à combustion";
$LANG["ogame_ImpulseDrive"] = "Réacteur à impulsion";
$LANG["ogame_HyperspaceDrive"] = "Propulsion hyperespace";
$LANG["ogame_LaserTechnology"] = "Technologie laser";
$LANG["ogame_IonTechnology"] = "Technologie ions";
$LANG["ogame_PlasmaTechnology"] = "Technologies plasma";
$LANG["ogame_IntergalacticResearchNetwork"] = "Réseau de recherche intergalactique";
$LANG["ogame_AstrophysiqueTechnology"] = "Technologie astrophysiques";
$LANG["ogame_GravitonTechnology"] = "Technologie graviton";
$LANG["ogame_RocketLauncher"] = "Lanceur de missiles";
$LANG["ogame_LightLaser"] = "Artillerie laser légère";
$LANG["ogame_HeavyLaser"] = "Artillerie laser lourde";
$LANG["ogame_GaussCannon"] = "Canon de Gauss";
$LANG["ogame_IonCannon"] = "Artillerie à ions";
$LANG["ogame_PlasmaTuret"] = "Lanceur de plasma";
$LANG["ogame_SmallShield"] = "Petit bouclier";
$LANG["ogame_LargeShield"] = "Grand bouclier";
$LANG["ogame_AntiBallisticMissiles"] = "Missile interception";
$LANG["ogame_InterplanetaryMissiles"] = "Missile interplanétaire";
$LANG["ogame_TemperatureMax"] = "Température Max";
$LANG["ogame_Temperature"] = "Température";
$LANG["ogame_Field"] = "Cases";
$LANG["ogame_Coordinates"] = "Coordonnées";
$LANG["ogame_Empire"] = "Empire";
$LANG["ogame_Building"] = "Bâtiments";
$LANG["ogame_Defence"] = "Défenses";
$LANG["ogame_Research"] = "Recherches";
$LANG["ogame_Technology"] = "Technologies";
}	

//Flotte OGAME
$mod_flottes_lang["planet_name"]= "Nom Planet";
$mod_flottes_lang["coordinates"]= "Coordonnées";
$mod_flottes_lang["planet_id"]= "ID Planet";
$mod_flottes_lang["PT"] = "Petit transporteur";
$mod_flottes_lang["GT"] = "Grand transporteur";
$mod_flottes_lang["CLE"] = "Chasseur léger";
$mod_flottes_lang["CLO"] = "Chasseur lourd";
$mod_flottes_lang["CR"] = "Croiseur";
$mod_flottes_lang["VB"] = "Vaisseau de bataille";
$mod_flottes_lang["VC"] = "Vaisseau de colonisation";
$mod_flottes_lang["REC"] = "Recycleur";
$mod_flottes_lang["SE"] = "Sonde espionnage";
$mod_flottes_lang["BMD"] = "Bombardier";
$mod_flottes_lang["DST"] = "Destructeur";
$mod_flottes_lang["EDLM"] = "Étoile de la mort";
$mod_flottes_lang["TRA"] = "Traqueur";
$mod_flottes_lang["SAT"] = "Satellite solaire";

$lib_flottes_lang["planet_name"]= "Nom Planet";
$lib_flottes_lang["coordinates"]= "Coordonnées";
$lib_flottes_lang["planet_id"]= "ID Planet";
$lib_flottes_lang["PT"] = "PT";
$lib_flottes_lang["GT"] = "GT";
$lib_flottes_lang["CLE"] = "CLE";
$lib_flottes_lang["CLO"] = "CLO";
$lib_flottes_lang["CR"] = "CR";
$lib_flottes_lang["VB"] = "VB";
$lib_flottes_lang["VC"] = "VC";
$lib_flottes_lang["REC"] = "REC";
$lib_flottes_lang["SE"] = "SE";
$lib_flottes_lang["BMD"] = "BMD";
$lib_flottes_lang["DST"] = "DST";
$lib_flottes_lang["EDLM"] = "EDLM";
$lib_flottes_lang["TRA"] = "TRA";
$lib_flottes_lang["SAT"] = "SAT";

$vaisseaux_lang[1]=array ("Petit transporteur","4000","10","5","5000","5000(10000)","10(20)");
$vaisseaux_lang[2]=array ("Grand transporteur","12000","25","5","25000","7500","50");
$vaisseaux_lang[3]=array ("Chasseur léger","4000","10","50","50","12500","20");
$vaisseaux_lang[4]=array("Chasseur lourd","10000","25","150","100","10000","75");
$vaisseaux_lang[5]=array ("Croiseur","29000","50","400","800","15000","300");
$vaisseaux_lang[6]=array ("Vaisseau de bataille","60000","200","1000","1500","10000","500");
$vaisseaux_lang[7]=array ("Vaisseau de colonisation","40000","100","50","7500","2500","1000");
$vaisseaux_lang[8]=array ("Recycleur","18000","10","1","20000","2000","300");
$vaisseaux_lang[9]=array ("Sonde espionnage","1000","0.01","0.01","5","100000000","1");
$vaisseaux_lang[10]=array ("Bombardier","90000","500","1000","500","4000(5000)","1000");
$vaisseaux_lang[11]=array ("Destructeur","125000","500","2000","2000","5000","1000");
$vaisseaux_lang[12]=array ("Étoile de la mort","10000000","50000","200000","1000000","100","1");
$vaisseaux_lang[13]=array ("Traqueur","85000","400","700","750","10000","250");
$vaisseaux_lang[14]=array ("Satellite solaire","2500","1","1","0","0","0");

// champs de la table user_defence
	$mic_lang="MIC";
	$mip_lang="MIP";
	$pb_lang="PB";
	$gb_lang="GB";
	$lm_lang="LM";
	$lle_lang="LLE";
	$llo_lang="LLO";
	$cg_lang="CG";
	$ai_lang="AI";
	$lp_lang="LP";
	
//	production
	$m_lang="M";
	$c_lang="C";
	$d_lang="D";
	
// batiments
	$cef_lang="CEF";
	$ces_lang="CES";
	$udr_lang="UdR";
	$udn_lang="UdN";
	$csp_lang="CSp";	
	$hm_lang="HM";
	$hc_lang="HC";
	$hd_lang="HD";
	$lab_lang="Lab";
	$ter_lang="Ter";
	$silo_lang="Silo";
	$balu_lang="BaLu";
	$pha_lang="Pha";
	$posa_lang="PoSa";
	$cm_lang="CM";
	
// recherches	
	$esp_lang="Esp";
	$ordi_lang="Ordi";
	$alli_lang="Alli";
	$sc_lang="SC";
	$raf_lang="Raf";
	$armes_lang="Armes";
	$bouclier_lang="Bouclier";
	$protec_lang="Protection";
	$nrj_lang="NRJ";
	$hyp_lang="Hyp";
	$rc_lang="RC";
	$ri_lang="RI";
	$ph_lang="PH";
	$laser_lang="Laser";
	$ions_lang="Ions";
	$plasma_lang="Plasma";
	$rri_lang="RRI";
	$astro_lang="Astrophysique";
	$grav_lang="Graviton";
	
	// Valeur défense total
	$mic_rec = 10000;
	$mip_rec= 25000; 
	$lm_rec=  2000; 
	$lle_rec=  2000;
	$llo_rec=  8000; 
	$ai_rec=  8000; 
	$cg_rec= 37000; 
	$lp_rec= 130000;
	$pb_rec=  20000; 
	$gb_rec= 100000; 
	
	// Valeur recyclage Metal/Titane -  Cristal/Carbone
	$sat_rec=array("0","2000"); 
	$PT_rec=  array("2000","2000");  
	$GT_rec= array("6000","6000"); 
	$CLE_rec= array("3000","1000"); 
	$CLO_rec=  array("6000","4000"); 
	$CR_rec=array("20000","7000"); 
	$VB_rec= array("45000","15000"); 
	$VC_rec= array("10000","20000"); 
	$REC_rec=array("10000","6000"); 
	$SE_rec= array("0","1000"); 
	$BMD_rec= array("50000","25000"); 
	$DST_rec= array("60000","50000"); 
	$EDLM_rec=array("5000000","4000000"); 
	$TRA_rec=  array("30000","40000"); 
	
	$coef_rec=0.35;
	
// Fin OGAME
}


?>
