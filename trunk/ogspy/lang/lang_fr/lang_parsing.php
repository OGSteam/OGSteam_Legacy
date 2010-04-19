<?php
$x_nb = "[0-9]{1,}";
$x_pseudo = '[a-zA-Z0-9 \-_]*';
$x_coords = '[0-9]{1,2}\:[0-9]{1,3}\:[0-9]{1,2}';
$x_tech = 'Armes: {$x_nb}% Bouclier: {$x_nb}% Coque: {$x_nb}%';

// PARSING USER HOME
//Batiments
$lang['homeempire_Textarea'] = 'Empire & Bâtiments & Laboratoire & Défenses';
$lang['Home_Empire'] = 'votre empire';
$lang['Home_Name'] = 'Nom';
$lang['Home_Coordonnates'] = 'Coordonnées';
$lang['Home_Size'] = 'Cases';

$lang['Home_M'] = 'Mine de métal';
$lang['Home_C'] = 'Mine de cristal';
$lang['Home_D'] = 'Synthétiseur de deutérium';
$lang['Home_CES'] = 'Centrale électrique solaire';
$lang['Home_CEF'] = 'Centrale électrique de fusion';
$lang['Home_UdR'] = 'Usine de robots';
$lang['Home_UdN'] = 'Usine de nanites';
$lang['Home_CSp'] = 'Chantier spatial';
$lang['Home_HM'] = 'Hangar de métal';
$lang['Home_HC'] = 'Hangar de cristal';
$lang['Home_HD'] = 'Réservoir de deutérium';
$lang['Home_Lab'] = 'Laboratoire de recherche';
$lang['Home_DdR'] = 'Dépôt de ravitaillement';
$lang['Home_Ter'] = 'Terraformeur';
$lang['Home_Silo'] = 'Silo de missiles';
$lang['Home_BaLu'] = 'Base lunaire';
$lang['Home_Pha'] = 'Phalange de capteur';
$lang['Home_PoSa'] = 'Porte de saut spatial';
$lang['Home_Level'] = 'Niveau';

$lang['defence_LM'] = 'Lanceur de missiles';
$lang['defence_LLE'] = 'Artillerie laser légère';
$lang['defence_LLO'] = 'Artillerie laser lourde';
$lang['defence_CG'] = 'Canon de Gauss';
$lang['defence_AI'] = 'Artillerie à ions';
$lang['defence_LP'] = 'Lanceur de plasma';
$lang['defence_PB'] = 'Petit bouclier';
$lang['defence_GB'] = 'Grand bouclier';
$lang['defence_MIC'] = 'Missile Interception';
$lang['defence_MIP'] = 'Missile Interplanétaire';
$lang['defence_available'] = 'disponible\(s\)';
$lang['defence_available2'] = 'disponible(s)';

$lang['tech_Esp'] = 'Technologie Espionnage';
$lang['tech_Ordi'] = 'Technologie Ordinateur';
$lang['tech_Armes'] = 'Technologie Armes';
$lang['tech_Bouclier'] = 'Technologie Bouclier';
$lang['tech_Protection'] = 'Technologie Protection des vaisseaux spatiaux';
$lang['tech_NRJ'] = 'Technologie Energie';
$lang['tech_Hyp'] = 'Technologie Hyperespace';
$lang['tech_RC'] = 'Réacteur à combustion';
$lang['tech_RI'] = 'Réacteur à impulsion';
$lang['tech_PH'] = 'Propulsion hyperespace';
$lang['tech_Laser'] = 'Technologie Laser';
$lang['tech_Ions'] = 'Technologie Ions';
$lang['tech_Plasma'] = 'Technologie Plasma';
$lang['tech_RRI'] = 'Réseau de recherche intergalactique';
$lang['tech_Graviton'] = 'Technologie Graviton';
$lang['tech_Expeditions'] = 'Technologie Expéditions';

$lang['Fleet_SC'] = 'Petit transporteur';
$lang['Fleet_LC'] = 'Grand transporteur';
$lang['Fleet_LF'] = 'Chasseur léger';
$lang['Fleet_HF'] = 'Chasseur lourd';
$lang['Fleet_Cru'] = 'Croiser';
$lang['Fleet_BS'] = 'Vaisseau de bataille';
$lang['Fleet_CS'] = 'Vaisseau de colonistation';
$lang['Fleet_Rec'] = 'Recycleur';
$lang['Fleet_Spy'] = 'Sonde d\'espionnage';
$lang['Fleet_Bom'] = 'Bombardier';
$lang['Fleet_Sat'] = 'Satellite solaire';
$lang['Fleet_Des'] = 'Destructeur';
$lang['Fleet_RIP'] = 'Étoile de la mort';
$lang['Fleet_BC'] = 'Traqueur';

$lang['home_Batiment'] = 'Bâtiments';
$lang['home_Recherche'] = 'Recherche';
$lang['home_Vaisseaux'] = 'Vaisseaux';
$lang['home_Defense'] = 'Défense';

$lang['OverView_Rename'] = 'Renommer';
$lang['OverView_Overview'] = 'Vue Générale';
$lang['OverView_Diameter'] = 'Diametre';
$lang['OverView_Temperature'] = 'Temperature';
$lang['OverView_Position'] = 'Position';





/*
  --------- TOUT CE QUI SUIT EST A REVOIR COMPLETEMENT LORS DE L'ADAPTATION A OGAME V1.0 ------------	
*/




//début du parsing galaxie-ce qui signifie que ce qui suis doit être identique à l'interface ogame, pas d'inventions ici-
$lang['symbol_blocked'] = 'b';
$lang['symbol_vacation'] = 'v';
$lang['symbol_weak'] = 'd';
$lang['symbol_strong'] = 'f';
$lang['symbol_inactive'] = 'i';
$lang['symbol_Inactive'] = 'I';
$lang['Inactive'] = 'Inactif 28 jours';
$lang['Ally'] = 'Alliance';
$lang['Player'] = 'Joueur';
$lang['Moon'] = 'Lune';
$lang['Planet'] = 'Planète';
//$lang['Alliance_Homepage'] = 'Page d\'alliance';
//$lang['Alliance_Page'] = 'Page web de l\'alliance';
//$lang['alliance_end'] = ', classée';
//$lang['player_end'] = ', classé';
//fin du parsing galaxie

// début parsing classement
$lang['Ranking_Player'] = '#^Place+\s+Joueur+\s+Alliance+\s+Points$#';
$lang['Ranking_SendMessage'] = '#^(\d+)\s+\S\s+(.*?)\s+(?:\s+Envoyer\sun\smessage)?\s+(.*?)?\s+([^\s]\d*)$#';
$lang['Ranking_Alliance'] = '#^Place+\s+Alliance+\s+Memb.+\s+(Milliers de )?points+\s+par membre$#i'; //Place Alliance Memb. Milliers de points par membre
$lang["Ranking_Text"] =  "#^(\d+)\s+\S\s+(.*?)\s+([^\s]\d*)\s+([^\s]\d*)\s+([^\s]\d*)$#"; //Syntaxe d'une ligne de classement

//parsing spy report
$lang['SolarSystem'] = 'Système solaire'; //en commun pour le parsing galaxie/espionnage
$lang['Resources'] = '#Matières premières sur#';
$lang['Header_ressources'] = 'Matières premières sur';
$lang['Header_date'] = 'le '; //l'espace est important ^^
$lang['Spy_FleetDestructionProbability'] = '/Probabilité de destruction de la flotte/';

//spy affichage
$lang['Spy_Moon'] = '(lune)';
$lang['Spy_Moon2'] = 'lune';
$lang['Spy_mine'] = '#Mine#';
$lang['Spy_Flotte'] = 'Flotte';
$lang['Spy_Building'] = 'Bâtiments';
$lang['Spy_Defence'] = 'Défense';
$lang['Spy_Research'] = 'Recherches';
$lang['Spy_Technology'] = 'Technologies';
$lang['Spy_Resources'] = 'Matières premières';
$lang['Spy_FleetDestructionProbability_view'] = 'Probabilité de destruction de la flotte';
$lang['Spy_ResearchLab'] = '#Laboratoire de recherche+\s(\d)#';
$lang['Spy_ImpulseDrive'] = '#Réacteur à impulsion+\s(\d{1,2})#';
$lang['Spy_SensorPhalanx'] = '#Phalange de capteur+\s(\d)#';
$lang['Spy_JumpGate'] = '#Porte de saut spatial+\s(\d)#';
$lang['Spy_MissileSilo'] = '#Silo de missiles+\s(\d)#';

$lang['Spy_rgx_moon'] = "\(lune\)";

$lang['Spy_rgx_global'] = array ( 
		'/.*Flotte(.*)D.fense(.*)B.timents(.*)Recherche(.*)/', 
		'/.*Flotte(.*)D.fense(.*)B.timents(.*)/', 
		'/.*Flotte(.*)D.fense(.*)/', 
		'/.*Flotte(.*)/', 
		'/.*/' 
	);

$lang['Spy_rgx_matiere1ere'] = '/Mati.res\spremi.res\ssur(.*?):\d+%/ms';
$lang['Spy_rgx_split_date'] = "\nle";
$lang['Spy_rgx_firstline'] = '/Mati.res premi.res sur (.*?) \[(\d+:\d+:\d+)\](?: \(Joueur \'.*?\'\))?[\s]*le (\d+-\d+ \d+:\d+:\d+)\s*M.tal:(\s)*(\d+)\s*Cristal:(\s)*(\d+)\s*Deut.rium:(\s)*(\d+)\s*Energie:(\s)*(\d+).*Probabilit. de destruction de la flotte d.espionnage( ?):([0-9]{1,3})%/';
$lang['Spy_rgx_activity'] = '/dans les (\d+) derni.res minutes/';
$lang['Spy_rgx_metal'] = '/Mine de m.tal\s+(\d+)/';
$lang['Spy_rgx_cristal'] = '/Mine de cristal\s+(\d+)/';
$lang['Spy_rgx_deut'] = '/Synth.tiseur de deut.rium\s+(\d+)/';
$lang['Spy_rgx_ces'] = '/Centrale .lectrique solaire\s+(\d+)/';
$lang['Spy_rgx_cef'] = '/Centrale .lectrique de fusion\s+(\d+)/';
$lang['Spy_rgx_robots'] = '/Usine de robots\s+(\d+)/';
$lang['Spy_rgx_nanites'] = '/Usine de nanites\s+(\d+)/';
$lang['Spy_rgx_chspatial'] = '/Chantier spatial\s+(\d+)/';
$lang['Spy_rgx_hangarmetal'] = '/Hangar de m.tal\s+(\d+)/';
$lang['Spy_rgx_hangarcristal'] = '/Hangar de cristal\s+(\d+)/';
$lang['Spy_rgx_hangardeut'] = '/R.servoir de deut.rium\s+(\d+)/';
$lang['Spy_rgx_labo'] = '/Laboratoire de recherche\s+(\d+)/';
$lang['Spy_rgx_terra'] = '/Terraformeur\s+(\d+)/';
$lang['Spy_rgx_ddr'] = '/D.p.t de ravitaillement\s+(\d+)/';
$lang['Spy_rgx_silo'] = '/Silo de missiles\s+(\d+)/';
$lang['Spy_rgx_baselune'] = '/Base lunaire\s+(\d+)/';
$lang['Spy_rgx_phalange'] = '/Phalange de capteur\s+(\d+)/';
$lang['Spy_rgx_portesaut'] = '/Porte de saut spatial\s+(\d+)/';

$lang['Spy_rgx_missiles'] = '/Lanceur de missiles\s+(\d+)/';
$lang['Spy_rgx_llegers'] = '/Artillerie laser l.g.re\s+(\d+)/';
$lang['Spy_rgx_llourds'] = '/Artillerie laser lourde\s+(\d+)/';
$lang['Spy_rgx_gauss'] = '/Canon de Gauss\s+(\d+)/';
$lang['Spy_rgx_ion'] = '/Artillerie . ions\s+(\d+)/';
$lang['Spy_rgx_plasma'] = '/Lanceur de plasma\s+(\d+)/';
$lang['Spy_rgx_petitboucl'] = '/Petit bouclier\s+(\d+)/';
$lang['Spy_rgx_grandboucl'] = '/Grand bouclier\s+(\d+)/';
$lang['Spy_rgx_MI'] = '/Missile Interception\s+(\d+)/';
$lang['Spy_rgx_MIP'] = '/Missile Interplan.taire\s+(\d+)/';

$lang['Spy_rgx_pt'] = '/Petit transporteur\s+(\d+)/';
$lang['Spy_rgx_gt'] = '/Grand transporteur\s+(\d+)/';
$lang['Spy_rgx_cle'] = '/Chasseur l.ger\s+(\d+)/';
$lang['Spy_rgx_clo'] = '/Chasseur lourd\s+(\d+)/';
$lang['Spy_rgx_cro'] = '/Croiseur\s+(\d+)/';
$lang['Spy_rgx_vb'] = '/Vaisseau de bataille\s+(\d+)/';
$lang['Spy_rgx_vcolo'] = '/Vaisseau de colonisation\s+(\d+)/';
$lang['Spy_rgx_recy'] = '/Recycleur\s+(\d+)/';
$lang['Spy_rgx_se'] = '/Sonde espionnage\s+(\d+)/';
$lang['Spy_rgx_bomb'] = '/Bombardier\s+(\d+)/';
$lang['Spy_rgx_sat'] = '/Satellite solaire\s+(\d+)/';
$lang['Spy_rgx_destro'] = '/Destructeur\s+(\d+)/';
$lang['Spy_rgx_rip'] = '/.toile de la mort\s+(\d+)/';
$lang['Spy_rgx_traq'] = '/Traqueur\s+(\d+)/';

$lang['Spy_rgx_espion'] = '/Technologie Espionnage\s+(\d+)/';
$lang['Spy_rgx_ordi'] = '/Technologie Ordinateur\s+(\d+)/';
$lang['Spy_rgx_armes'] = '/Technologie Armes\s+(\d+)/';
$lang['Spy_rgx_bouclier'] = '/Technologie Bouclier\s+(\d+)/';
$lang['Spy_rgx_protect'] = '/Technologie Protection des vaisseaux spatiaux\s+(\d+)/';
$lang['Spy_rgx_energie'] = '/Technologie Energie\s+(\d+)/';
$lang['Spy_rgx_technohspace'] = '/Technologie Hyperespace\s+(\d+)/';
$lang['Spy_rgx_combustion'] = '/R.acteur . combustion\s+(\d+)/';
$lang['Spy_rgx_impulsion'] = '/R.acteur . impulsion\s+(\d+)/';
$lang['Spy_rgx_prophspace'] = '/Propulsion hyperespace\s+(\d+)/';
$lang['Spy_rgx_laser'] = '/Technologie Laser\s+(\d+)/';
$lang['Spy_rgx_t_ion'] = '/Technologie Ions\s+(\d+)/';
$lang['Spy_rgx_t_plasma'] = '/Technologie Plasma\s+(\d+)/';
$lang['Spy_rgx_rri'] = '/R.seau de recherche intergalactique\s+(\d+)/';
$lang['Spy_rgx_grav'] = '/Technologie Graviton\s+(\d+)/';
$lang['Spy_rgx_exped'] = '/Technologie Exp.ditions\s+(\d+)/';

// end parsing spy report

// parsing classement
$lang['Stat_rgx_play_header'] = "#^Place+\s+Joueur+\s+Alliance+\s+Points$#";
$lang['Stat_rgx_play_line'] = "#^(\d+)\s+\S\s+(.*?)\s+(?:\s+Envoyer\sun\smessage)?\s+(.*?)?\s+([^\s][0-9.]*)$#";
$lang['Stat_rgx_ally_header'] = "#^Place+\s+Alliance+\s+Memb.+\s+(Milliers de )?points+\s+par membre$#i";
$lang['Stat_rgx_ally_line'] = "#^(\d+)\s+\S\s+(.*?)\s+([^\s][0-9.]*)\s+([^\s][0-9.]*)\s+([^\s][0-9.]*)$#";
// --------------------

// Vue générale
$lang['OverView_coords'] = "`\[(.*) \[({$x_coords})\]\]`";
$lang['OverView_fields'] = "`Diam.tre 	.* km \( \d+ \/ (\d+) cases \)`";
$lang['OverView_position'] = "`Position	\[({$x_coords})\]`";
$lang['OverView_planetname'] = "`Plan.te \"(.*)\" \({$x_pseudo}\)`";
// --------------------


// parsing galaxie
$lang['Gal_rgx_status'] = Array('i','b','v','d','f','I');
$lang['Gal_rgx_spying'] = 'Espionner';
$lang['Gal_rgx_solarsyst'] = '#Syst.me solaire#';
$lang['Gal_rgx_resources'] = '/Mati.res premi.res sur/';
$lang['Gat_rgx_header'] = '#^Syst.me solaire (\d+?):(\d+?)$#';
$lang['Gal_rgx_line'] = '/(\d{1,2})\s+([A-Za-z0-9àâäéèêëìïîòöôùüûç_\-\. ]+?)(?:\s\([0-9min \*]+\))?(\s+Lune \(Taille : \d+\))?\s{2,}([A-Za-z0-9àâäéèêëìïîòöôùüûç_\-\. ]+?)(\s\([iIbvdf ]+\))?\s{2,}([A-Za-z0-9àâäéèêëìïîòöôùüûç_\-\. ]+?)?\s+(?:Espionner[A-Za-z ]+)?/';
// --------------------
$lang['server_Time'] = 'Heure du serveur';


// includes/user.php
// REGEX Pour les COMBATS
// Fonction user.php/parseRC et parseRCround
$lang['incusr_regexRC_date'] = "/affront.es le ({$x_nb})-({$x_nb}) ({$x_nb}):({$x_nb}):({$x_nb}) \.:/";
$lang['incusr_regexRC_AttName'] = "/Attaquant ({$x_pseudo}) \(\[({$x_coords})\]\)(\s*)Armes: ({$x_nb})% Bouclier: ({$x_nb})% Coque: ({$x_nb})%/";
$lang['incusr_regexRC_DefName'] = "/D.fenseur ({$x_pseudo}) \(\[({$x_coords})\]\)(\s*)Armes: ({$x_nb})% Bouclier: ({$x_nb})% Coque: ({$x_nb})%/";
$lang['incusr_regexRC_AttLoss'] = "/L\'attaquant a perdu au total ({$x_nb}) unit.s/";
$lang['incusr_regexRC_DefLoss'] = "/Le d.fenseur a perdu au total ({$x_nb}) unit.s/";
$lang['incusr_regexRC_AttWin'] = "/L\'attaquant a gagn. la bataille/";
$lang['incusr_regexRC_DefWin'] = "/Le d.fenseur a gagn. la bataille/";
$lang['incusr_regexRC_Debris'] = "/Un champ de d.bris contenant ({$x_nb}) unit.s de m.tal et ({$x_nb}) unit.s de cristal(.*)/";
$lang['incusr_regexRC_Moon'] = "/une lune est de ({$x_nb})( ?)%/";
$lang['incusr_regexRC_Resouces'] = "/(\d*) unit.s de m.tal, ({$x_nb}) unit.s de cristal et ({$x_nb}) unit.s de deut.rium/";
$lang['incusr_regexRC_AttShoot'] = "attaquante tire";
$lang['incusr_regexRC_PtsDegats'] = "points de dégâts||";
$lang['incusr_regexRC_Flight'] = "\s[\(\[0-9\:\]\)]+(.Armes\:[0-9%\s]+Bouclier\:[0-9%\s]+Coque\:[0-9%\s]+)?.Type.([a-zA-Zéàè-\s\t\.]+).Nombre.([0-9\.\s\t]+).Armes/";
$lang['incusr_regexRC_AttRound'] = "/La flotte attaquante tire (\d*) fois avec une puissance totale de (-?\d*) sur le d.fenseur. Les boucliers du d.fenseur absorbent (\d*) points de d.g.ts/";
$lang['incusr_regexRC_DefRound'] = "/La flotte d.fensive tire au total (\d*) fois avec une puissance totale de (-?\d*) sur l'attaquant. Les boucliers de l'attaquant absorbent (\d*)/";

?>
