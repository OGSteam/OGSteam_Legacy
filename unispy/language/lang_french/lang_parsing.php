<?php

//Affichage lié au parsing menu.php

$LANG["sendbox_PlayerRanking"] = "---- Classement joueur ----";
$LANG["sendbox_AllyRanking"] = "---- Classement alliance ----";
$LANG["sendbox_RankingGeneral"] = "-> Général";
$LANG["sendbox_RankingFleet"] = "-> Flotte";
$LANG["sendbox_RankingResearch"] = "-> Recherche";
$LANG["sendbox_ExplainText"] = "Système solaire & Rapport espionnage & Classement";
$LANG["sendbox_Forbidden"] = "Vous ne disposez pas des droits necessaire pour importer des informations sur le serveur";
$LANG["sendbox_SolarSystem"] = "S. Solaire";
$LANG["sendbox_SpyReport"] = "R. Espionnage";


//début du parsing galaxie-ce qui signifie que ce qui suis doit être identique à l'interface univers, pas d'inventions ici-
$LANG["symbol_blocked"] = "b";
$LANG["symbol_vacation"] = "v";
$LANG["symbol_weak"] = "d";
$LANG["symbol_strong"] = "f";
$LANG["symbol_inactive"] = "\+7";
$LANG["symbol_Inactive"] = "\+21";

$LANG["Legend"] = "Légende";
$LANG["Inactive"] = "Inactif 21 jours";
$LANG["Ally"] = "Alliance";
$LANG["Player"] = "Joueur";
$LANG["Moon"] = "Lune";
$LANG["Planet"] = "Planète";

$LANG["Alliance_Homepage"] = "Page d'alliance";
$LANG["Alliance_Page"] = "Page web de l'alliance";
$LANG["alliance_end"] = ", classée";
$LANG["player_end"] = "\(\d+ème\)";
//fin du parsing galaxie


// début parsing classement
$LANG["Ranking_Player"] = "#^Place+\s+Joueur+\s+Alliance+\s+Points$#";
//$LANG["Ranking_SendMessage"] = "#^(\d+)\s+\S\s+(.*?)\s+(?:\s+Envoyer\sun\smessage)?\s+(.*?)?\s+([^\s]\d*)$#";
//$LANG["Ranking_SendMessage"] = "#([0-9]{1,4}) (?:\+|\-|\*)\t(.*)\tEnvoyer un message\t(.*)\t([0-9 ]*)#";
$LANG["Ranking_SendMessage"] = "#^(\d+)\s+\S\s+(.*)\s+(?:Envoyer un message)\s+(.*)\t([0-9 ]+)$#";

$LANG["Ranking_Alliance"] = "#^Place+\s+Nom+\s+Tag.+\s+Points$#i"; //Place Alliance Memb. Milliers de points par membre
//$LANG["Ranking_Text"] =  "#^(\d+)\s+\S\s+(.*?)\s+([^\s]\d*)\s+([^\s]\d*)\s+([^\s]\d*)$#"; //Syntaxe d'une ligne de classement
$LANG["Ranking_Text"] =  "#^(\d+)\s+\S\s+(.*?)\s+\[(.+)\]\s+([0-9 ]+)$#"; //Syntaxe d'une ligne de classement

//parsing spy report
$LANG["SolarSystem"] = "Système solaire";				//en commun pour le parsing galaxie/espionnage
$LANG["Resources"] = "#Matières premières sur#";
$LANG["Header_ressources"] = "Matières premières sur";
$LANG["Header_date"] = "le ";  //le ' ' est important ^^
$LANG["Spy_FleetDestructionProbability"] = "/Probabilité de destruction de la flotte/";

//spy affichage
$LANG["Spy_Flotte"] = "Flotte";
$LANG["Spy_Building"] = "Batiments";
$LANG["Spy_Defence"] = "Défense";
$LANG["Spy_Research"] = "Recherche";
$LANG["Spy_Technology"] = "Technologies";
$LANG["Spy_Resources"] = "Matières premières";
$LANG["Spy_FleetDestructionProbability_view"] = "Probabilité de destruction de la flotte";
$LANG["Spy_ResearchLab"] = "#Centre Technique+\s(\d)#";

$LANG["Spy_ImpulseDrive"] = "#Impulsion+\s(\d{1,2})#";
$LANG["Spy_MissileSilo"] = "#Hangar de missiles+\s(\d)#";


// end parsing spy report

// PARSING USER HOME
//Bâtiments
$LANG["Home_Empire"] = "Vue d'ensemble de votre empire";
$LANG["Home_Name"] = "Nom";
$LANG["Home_Coordonnates"] = "Position GSP";
$LANG["Home_Size"] = "Cases";
$LANG["Home_Temp"] = "Température";


$LANG["Home_Ti"] = "Mine de titane";
$LANG["Home_Ca"] = "Mine de carbone";
$LANG["Home_Tr"] = "Extracteur de Tritium";
$LANG["Home_CG"] = "Centrale Géothermique";
$LANG["Home_CaT"] = "Centrale à tritium";
$LANG["Home_UdD"] = "Usine de droïdes";
$LANG["Home_UdA"] = "Usine d'Androïdes";
$LANG["Home_UA"] = "Usine d'armement";
$LANG["Home_STi"] = "Silo de Titane";
$LANG["Home_SCa"] = "Silo de Carbone";
$LANG["Home_STr"] = "Silo de tritium";
$LANG["Home_CT"] = "Centre Technique";
$LANG["Home_CM"] = "Convertisseur moléculaire";
$LANG["Home_Ter"] = "Terraformeur";
$LANG["Home_Hangar"] = "Hangar de missiles";

$LANG["Home_Level"] = "Niveau";

$LANG["defence_BFG"] = "BFG";
$LANG["defence_SBFG"] = "Smart BFG";
$LANG["defence_PFC"] = "Plate-Forme Canon";
$LANG["defence_Def"] = "Déflecteurs";
$LANG["defence_PFI"] = "Plate-Forme Ionique";
$LANG["defence_AMD"] = "Aereon Missile Defense";
$LANG["defence_CF"] = "Champ de force";
$LANG["defence_Ho"] = "Holochamp";
$LANG["defence_CME"] = "Contre-Mesure Electromagnétique";
$LANG["defence_EMP"] = "Missile EMP";

$LANG["defence_available"] = "disponible\(s\)";
$LANG["defence_available2"] = "disponible(s)";

$LANG["Tech_Esp"] = "Espionnage";
$LANG["Tech_Qua"] = "Quantique";
$LANG["Tech_All"] = "Alliages";
$LANG["Tech_SC"] = "Stratification carbone";
$LANG["Tech_Raf"] = "Raffinerie";
$LANG["Tech_Armes"] = "Armement";
$LANG["Tech_Bouclier"] = "Bouclier";
$LANG["Tech_Blindage"] = "Blindage";
$LANG["Tech_Ther"] = "Thermodynamique";
$LANG["Tech_Anti"] = "Antimatière";
$LANG["Tech_HD"] = "HyperDrive";
$LANG["Tech_Imp"] = "Impulsion";
$LANG["Tech_Warp"] = "Warp";
$LANG["Tech_Smart"] = "Smart";
$LANG["Tech_Ions"] = "Ions";
$LANG["Tech_Aereon"] = "Aereon";
$LANG["Tech_SCa"] = "Super-Calculateur";
$LANG["Tech_Graviton"] = "Graviton";
$LANG["Tech_Admi"] = "Administration";
$LANG["Tech_Expl"] = "Exploitation";

$LANG["home_Batiment"] = "Bâtiments";
$LANG["home_Recherche"] = "Recherche";
$LANG["home_Vaisseaux"] = "Vaisseaux";
$LANG["home_Défense"] = "Défense";

$LANG["homeempire_Textarea"] = "Empire & Bâtiments & Laboratoire & Défenses";


$technology_requirement["Esp"] = array(3);
$technology_requirement["Qua"] = array(1);
$technology_requirement["Alli"] = array(2);
$technology_requirement["SC"] = array(3);
$technology_requirement["Raf"] = array(4);
$technology_requirement["Armes"] = array(4);
$technology_requirement["Bouclier"] = array(6, "Ther" => 4);
$technology_requirement["Blindage"] = array(2);
$technology_requirement["Ther"] = array(1);
$technology_requirement["Anti"] = array(7, "Ther" => 6, "Bouclier" => 4);
$technology_requirement["HD"] = array(1, "Ther" => 2);
$technology_requirement["Imp"] = array(2, "Ther" => 4);
$technology_requirement["Warp"] = array(8, "Ther" => 6);
$technology_requirement["Smart"] = array(2, "Ther" => 2);
$technology_requirement["Ions"] = array(4, "Smart" => 5, "Ther" => 4);
$technology_requirement["Aereon"] = array(6, "Smart" => 10, "Ther" => 8, "Ions" => 6, "Qua" => 6);
$technology_requirement["Sca"] = array(10, "Qua" => 8, "Anti" => 8);
$technology_requirement["Graviton"] = array(14);
$technology_requirement["Admi"] = array(2);
$technology_requirement["Expl"] = array(8, "Ther" => 8, "Blindage" =>10);
?>