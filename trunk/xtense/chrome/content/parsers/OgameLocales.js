/**
 * @author Unibozu
 * @license GNU/GPL
 */

 Xogame.locales = {
	'fr': {
		'title ally_msg': 'Message de votre alliance',
		'title spy': 'Espionnage de',
		'title expedition': 'Résultat de l\'expédition',
		'title ennemy_spy': 'Activité d\'espionnage',
		'title rc_cdr': 'Rapport d\'exploitation du champ de débris',
		
		'ally_msg from': 'Le joueur (.*) vous envoie ce message:',
		'moon': 'Lune',
		
		'dates' : {
			'messages' : {
					regexp: '(\\d+)-(\\d+)[^\\d]+(\\d+):(\\d+):(\\d+)',
					fields: { 
							year: -1,
							month:1,
							day:2,
							hour:3,
							min:4,
							sec:5 }
			}
		},
		'spy attack': 'Attaquer',
		'spy activity': 'Act',
		'expedition': 'Résultat de l\'expédition',
		/*'galaxy': {
			'line regexp': ""+
						"Planète (.*) \\[\\d+:\\d+:\\d+\\].*Attaquer"+//nom de la planète
						".*"+
						"<th[^>]+width=\"30\">(.*Titane:\\D+([\\d\\s]+)\\D+Carbone:\\D+([\\d\\s]+)\\D+Tritium:\\s\\D+([\\d\\s]+)\\D+.*)?</th><th[^>]+width=\"150\">"+//CDR
						".*"+
						">Joueur (.*)\\([\\d\\s]+ème"+//nom du joueur
						".*"+
						"ecriremessages&dest=(\\d+)"+//id du joueur
						".*"+
						"<th[^>]+width=\"80\">(.*Alliance (.*) \\([0-9 ]+ème\\).*action=alliance&alliance=(\\d+).*)?</th>"+//nom de l'alliance et //id de l'alliance
						"",
		},*/
		'spy strings': {
			'M' : 'Mine de métal',
			'C' : 'Mine de cristal',
			'D' : 'Synthétiseur de deutérium',
			'CES' : 'Centrale électrique solaire',
			'CEF' : 'Centrale électrique de fusion',
			'UdR' : 'Usine de robots',
			'UdN' : 'Usine de nanites',
			'CSp' : 'Chantier spatial',
			'HM' : 'Hangar de métal',
			'HC' : 'Hangar de cristal',
			'HD' : 'Réservoir de deutérium',
			'Lab' : 'Laboratoire de recherche',
			'Ter' : 'Terraformeur',
			'DdR' : 'Dépôt de ravitaillement',
			'Silo' : 'Silo de missiles',
			'BaLu' : 'Base lunaire',
			'Pha' : 'Phalange de capteur',
			'PoSa' : 'Porte de saut spatial',
			
			'LM' : 'Lanceur de missiles',
			'LLE' : 'Artillerie laser légère',
			'LLO' : 'Artillerie laser lourde',
			'CG' : 'Canon de Gauss',
			'AI' : 'Artillerie à ions',
			'LP' : 'Lanceur de plasma',
			'PB' : 'Petit bouclier',
			'GB' : 'Grand bouclier',
			'MIC' : 'Missile Interception',
			'MIP' : 'Missile Interplanétaire',
			
			'PT' : 'Petit transporteur',
			'GT' : 'Grand transporteur',
			'CLE' : 'Chasseur léger',
			'CLO' : 'Chasseur lourd',
			'CR' : 'Croiseur',
			'VB' : 'Vaisseau de bataille',
			'VC' : 'Vaisseau de colonisation',
			'REC' : 'Recycleur',
			'SE' : 'Sonde espionnage',
			'BMD' : 'Bombardier',
			'DST' : 'Destructeur',
			'EDLM' : 'Étoile de la mort',
			'SAT' : 'Satellite solaire',
			'TRA' : 'Traqueur',
			
			'Esp' : 'Technologie Espionnage',
			'Ordi' : 'Technologie Ordinateur',
			'Armes' : 'Technologie Armes',
			'Bouclier' : 'Technologie Bouclier',
			'Protection' : 'Technologie Protection des vaisseaux spatiaux',
			'NRJ' : 'Technologie Energie',
			'Hyp' : 'Technologie Hyperespace',
			'RC' : 'Réacteur à combustion',
			'RI' : 'Réacteur à impulsion',
			'PH' : 'Propulsion hyperespace',
			'Laser' : 'Technologie Laser',
			'Ions' : 'Technologie Ions',
			'Plasma' : 'Technologie Plasma',
			'RRI' : 'Réseau de recherche intergalactique',
			'Graviton' : 'Technologie Graviton',
			'Expeditions' : 'Technologie Expéditions'
		},
		'spy database': {
			buildings: ['M','C','D','CES','CEF','UdR','UdN','CSp','HM','HC','HD','Lab','Ter','DdR','Silo','BaLu','Pha','PoSa'],
			researchs: ['Esp','Ordi','Armes','Bouclier','Protection','NRJ','Hyp','RC','RI','PH','Laser','Ions','Plasma','RRI','Expeditions','Graviton'],
			fleet: ['PT','GT','CLE','CLO','CR','VB','VC','REC','SE','BMD','SAT','DST','EDLM','TRA'],
			defense: ['LM','LLE','LLO','CG','AI','LP','PB','GB','MIC','MIP']
		},
		'spy groups': {
			'buildings': 'Bâtiments',
			'defense':  'Défense',
			'fleet': 'Flotte',
			'researchs': 'Recherche'
		},
		'spy header regexp': "Matières premières sur (.+) \\[(.+)\\] \\(Joueur '(.+)'\\)"
		//'parsetablestruct regexp': '<a[^>]*gid=(\\d+)[^>]*>[^<]*</a> \\([^<\\d]*([\\d.]+)[^)]*\\)[^<]*<'
	},
	
	'us': {
		'title ally_msg': 'Circular Message to Your Alliance',
		'title spy': 'Espionage Report of',
		'title expedition': 'Expedition Result',
		'title ennemy_spy': 'Espionage action',
		'title rc_cdr': 'Harvesting report from DF on',
		
		'ally_msg from': ' informs you',
		'moon': 'Moon',
		
		'spy attack': 'Attack',
		'spy activity': 'Act',
		'expedition': 'Expedition Result',
		'spy strings': {
			'M' : 'Metal Mine',
			'C' : 'Crystal Mine',
			'D' : 'Deuterium Synthesizer',
			'CES' : 'Solar Plant',
			'CEF' : 'Fusion Reactor',
			'UdR' : 'Robotics Factory',
			'UdN' : 'Nanite Factory',
			'CSp' : 'Shipyard',
			'HM' : 'Metal Storage',
			'HC' : 'Crystal Storage',
			'HD' : 'Deuterium Tank',
			'Lab' : 'Research Lab',
			'Ter' : 'Terraformer',
			'DdR' : 'Alliance Depot',
			'Silo' : 'Missile Silo',
			'BaLu' : 'Lunar Base',
			'Pha' : 'Sensor Phalanx',
			'PoSa' : 'Jump Gate',
			
			'LM' : 'Rocket Launcher',
			'LLE' : 'Light Laser',
			'LLO' : 'Heavy Laser',
			'CG' : 'Gauss Cannon',
			'AI' : 'Ion Cannon',
			'LP' : 'Plasma Turret',
			'PB' : 'Small Shield Dome',
			'GB' : 'Large Shield Dome',
			'MIC' : 'Anti-Ballistic Missiles',
			'MIP' : 'Interplanetary Missiles',
			
			'PT' : 'Small Cargo',
			'GT' : 'Large Cargo',
			'CLE' : 'Light Fighter',
			'CLO' : 'Heavy Fighter',
			'CR' : 'Cruiser',
			'VB' : 'Battleship',
			'VC' : 'Colony Ship',
			'REC' : 'Recycler',
			'SE' : 'Espionage Probe',
			'BMD' : 'Bomber',
			'DST' : 'Destroyer',
			'EDLM' : 'Deathstar',
			'SAT' : 'Solar Satellite',
			'TRA' : 'Battlecruiser',
			
			'Esp' : 'Espionage Technology',
			'Ordi' : 'Computer Technology',
			'Armes' : 'Weapons Technology',
			'Bouclier' : 'Shielding Technology',
			'Protection' : 'Armor Technology',
			'NRJ' : 'Energy Technology',
			'Hyp' : 'Hyperspace Technology',
			'RC' : 'Combustion Drive',
			'RI' : 'Impulse Drive',
			'PH' : 'Hyperspace Drive',
			'Laser' : 'Laser Technology',
			'Ions' : 'Ion Technology',
			'Plasma' : 'Plasma Technology',
			'RRI' : 'Intergalactic Research Network',
			'Graviton' : 'Graviton Technology',
			'Expeditions' : 'Expedition Technology'
		},
		'spy header regexp': "Resources on (.+) \\[(.+)\\] \\(Player '(.+)'\\)"
		//'parsetablestruct regexp': '<a[^>]*gid=(\\d+)[^>]*>[^<]*</a> \\([^<\\d]*([\\d.]+)[^)]\\)[^<]*<'
	},
	'de' : {
		'title ally_msg': 'Circular Message to Your Alliance',//TODO
		'title spy': 'Espionage Report of',//TODO
		'title expedition': 'Expedition Result',//TODO
		'title ennemy_spy': 'Espionage action',//TODO
		'title rc_cdr': 'Harvesting report from DF on',//TODO
		//TODO
		'ally_msg from': ' informs you',//TODO
		'moon': 'Moon',//TODO
		//TODO
		'spy attack': 'Attack',//TODO
		'spy activity': 'Act',//TODO
		'expedition': 'Expedition Result',//TODO
		'spy strings': {//TODO
			'M' : 'Metal Mine',//TODO
			'C' : 'Crystal Mine',//TODO
			'D' : 'Deuterium Synthesizer',//TODO
			'CES' : 'Solar Plant',//TODO
			'CEF' : 'Fusion Reactor',//TODO
			'UdR' : 'Robotics Factory',//TODO
			'UdN' : 'Nanite Factory',//TODO
			'CSp' : 'Shipyard',//TODO
			'HM' : 'Metal Storage',//TODO
			'HC' : 'Crystal Storage',//TODO
			'HD' : 'Deuterium Tank',//TODO
			'Lab' : 'Research Lab',//TODO
			'Ter' : 'Terraformer',//TODO
			'DdR' : 'Alliance Depot',//TODO
			'Silo' : 'Missile Silo',//TODO
			'BaLu' : 'Lunar Base',//TODO
			'Pha' : 'Sensor Phalanx',//TODO
			'PoSa' : 'Jump Gate',//TODO

			'LM' : 'Rocket Launcher',//TODO
			'LLE' : 'Light Laser',//TODO
			'LLO' : 'Heavy Laser',//TODO
			'CG' : 'Gauss Cannon',//TODO
			'AI' : 'Ion Cannon',//TODO
			'LP' : 'Plasma Turret',//TODO
			'PB' : 'Small Shield Dome',//TODO
			'GB' : 'Large Shield Dome',//TODO
			'MIC' : 'Anti-Ballistic Missiles',//TODO
			'MIP' : 'Interplanetary Missiles',//TODO

			'PT' : 'Small Cargo',//TODO
			'GT' : 'Large Cargo',//TODO
			'CLE' : 'Light Fighter',//TODO
			'CLO' : 'Heavy Fighter',//TODO
			'CR' : 'Cruiser',//TODO
			'VB' : 'Battleship',//TODO
			'VC' : 'Colony Ship',//TODO
			'REC' : 'Recycler',//TODO
			'SE' : 'Espionage Probe',//TODO
			'BMD' : 'Bomber',//TODO
			'DST' : 'Destroyer',//TODO
			'EDLM' : 'Deathstar',//TODO
			'SAT' : 'Solar Satellite',//TODO
			'TRA' : 'Battlecruiser',//TODO

			'Esp' : 'Espionage Technology',//TODO
			'Ordi' : 'Computer Technology',//TODO
			'Armes' : 'Weapons Technology',//TODO
			'Bouclier' : 'Shielding Technology',//TODO
			'Protection' : 'Armor Technology',//TODO
			'NRJ' : 'Energy Technology',//TODO
			'Hyp' : 'Hyperspace Technology',//TODO
			'RC' : 'Combustion Drive',//TODO
			'RI' : 'Impulse Drive',//TODO
			'PH' : 'Hyperspace Drive',//TODO
			'Laser' : 'Laser Technology',//TODO
			'Ions' : 'Ion Technology',//TODO
			'Plasma' : 'Plasma Technology',//TODO
			'RRI' : 'Intergalactic Research Network',//TODO
			'Graviton' : 'Graviton Technology',//TODO
			'Expeditions' : 'Expedition Technology'//TODO
		},
		'spy header regexp': "Resources on (.+) \\[(.+)\\] \\(Player '(.+)'\\)"//TODO
	}
};
Xogame.locales['us']['dates'] = Xogame.locales['fr']['dates'];
Xogame.locales['us']['spy groups'] = Xogame.locales['fr']['spy groups'];
Xogame.locales['us']['spy database'] = Xogame.locales['fr']['spy database'];

Xogame.locales['org'] = Xogame.locales['us'];

Xogame.locales['de']['dates'] = Xogame.locales['fr']['dates'];
Xogame.locales['de']['spy groups'] = Xogame.locales['fr']['spy groups'];
Xogame.locales['de']['spy database'] = Xogame.locales['fr']['spy database'];
