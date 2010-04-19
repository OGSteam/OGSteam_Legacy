/**
* @author Unibozu
 * @author Jormund
 * @license GNU/GPL
 */

 XEUnivers.locales = {
	'fr': {
		'title spy': 'Espionnage de',
		'resources': ['Titane','Carbone','Tritium','Energie'],
		'spy strings': {
			'buildings': { 
				1:'Mine de titane',
				2:'Mine de carbone',
				3:'Extracteur de Tritium',
				4:'Centrale G\u00E9othermique',
				5:'Centrale à tritium',
				6:'Usine de droïdes',
				7:"Usine d'Androïdes",
				8:"Usine d'armement",
				9:'Silo de Titane',
				10:'Silo de Carbone',
				11:'Silo de tritium',
				12:'Centre Technique',
				13:'Convertisseur mol\u00E9culaire',
				14:'Terraformeur',
				15:'Hangar de missiles'
				},
			'researchs': { 
				1:'Espionnage',
				2:'Quantique',
				6:"Armement",
				7:"Bouclier",
				8:"Blindage",
				9:'Thermodynamique',
				10:'Antimatière',
				11:'HyperDrive',
				12:'Impulsion',
				13:'Warp',
				14:'Smart',
				15:'Ions',
				16:'Aereon',
				17:'Super Calculateur',
				20:'Exploitation',
				18:'Graviton',
				3:'Alliages',
				4:'Stratification carbone',
				5:'Raffinerie',
				19:'Administration'},
			'fleet': { 
				1:"Navette PT-5",
				2:"Navette GT-50",
				3:"Chasseur",
				4:"Chasseur Lance",
				5:"Fr\u00E9gate d'assaut",
				6:"Destroyer",
				7:"Overlord",
				8:"Forteresse Noire",
				9:"Hyperion",
				10:"Collecteur",
				11:"Sonde",
				12:"Satellite solaire",
				13:"Colonisateur",
				14:"Vaisseau Extracteur",
				15:"Frelon"},

			'defense': { 
				101:"BFG",
				102:"Smart BFG",
				103:"Plate-Forme Canon",
				104:"D\u00E9flecteurs",
				105:"Plate-Forme Ionique",
				106:"Aereon Missile Defense",
				107:"Champ de force",
				108:"Holochamp",
				109:"Contre Mesure Electromagn\u00E9tique",
				110:"Missile EMP" }

		},
		'spy proba regexp': /Probabilité de destruction de la flotte espionnage : (\d+) %/,
		'spy header regexp': /Matières[^<]*<a[^>]*>([^[]*)[^[]\[([\d:]*)\]/,
		'parsetablestruct regexp': '<a[^>]*id=(\\d+)[^>]*>[^<]*</a> \\([^<\\d]*([\\d ]+)[^<]*<',
		'resources path': "id('diventete')/table[1]/tbody/tr/th",//une case sur deux contient les ressources à quai
		'messages path': "id('divpage')/form[2]/table/tbody/tr",//chaque ligne est soit l'entête d'un message, soit son contenu (2 lignes par message sauf pour les RC)
		'parsespyreports regexp': ''+
						'<tr>.*Espionnage de.*<tr>.*'+
						//'[^(Probabilité de destruction de la flotte espionnage)]*'+
						/*'\\s|[^(Probabilité de destruction de la flotte espionnage)]*'+*/
						'Probabilité de destruction de la flotte espionnage : \\d+ %'+
						'',
		'galaxy' : {
			'line regexp' : "Plan\u00E8te (.*) \\[\\d+:\\d+:\\d+\\].*Attaquer"+//planète
				".*"+
				'<th[^>]+width="30">(.*Titane:\\D+([\\d\\s]+)\\D+Carbone:\\D+([\\d\\s]+)\\D+Tritium:\\D+([\\d\\s]+)\\D+.*)?</th>'+//CDR
				".*"+
				">Joueur (.*)\\([\\d\\s]+(?:\u00E8me|er)\\D+ecriremessages[^=]*dest=(\\d+)"+//joueur
				".*"+
				'<th[^>]+width="80">(.*Alliance (.*) \\([\\d\\s]+(?:\u00E8me|er)\\).*.*action=alliance[^=]*alliance=(\\d+).*)?</th>'+//aliance
				""
		},
		'dates' : {
			'messages' : {
					regexp: '(\\d+)\\/(\\d+)\\/(\\d+)[^\\d]+(\\d+):(\\d+):(\\d+)',	//e.g. 14/12/2008 16:15:42
					fields: { 
							year: 3,
							month:2,
							day:1,
							hour:4,
							min:5,
							sec:6 }
			}
		}				
	}
};
















