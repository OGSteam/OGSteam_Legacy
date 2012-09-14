/**
 * @author OGSteam
 * @license GNU/GPL
 */

XnewOgame.Xpaths = {
	metas : {
		ogame_version: "//meta[@name=\'ogame-version\']/@content",
		timestamp: "//meta[@name=\'ogame-timestamp\']/@content",
		universe: "//meta[@name=\'ogame-universe\']/@content",
		language: "//meta[@name=\'ogame-language\']/@content",
		player_id: "//meta[@name=\'ogame-player-id\']/@content",
		player_name: "//meta[@name=\'ogame-player-name\']/@content",
		ally_id: "//meta[@name=\'ogame-alliance-id\']/@content",
		ally_name: "//meta[@name=\'ogame-alliance-name\']/@content",
		ally_tag: "//meta[@name=\'ogame-alliance-tag\']/@content",
		planet_id: "//meta[@name=\'ogame-planet-id\']/@content",
		planet_name: "//meta[@name=\'ogame-planet-name\']/@content",
		planet_coords: "//meta[@name=\'ogame-planet-coordinates\']/@content",
		planet_type: "//meta[@name=\'ogame-planet-type\']/@content"
	},
	ally_members_list : {
		rows : '//table[@class="members zebra bborder"]/tbody/tr',
		player : 'td[1]',
		rank : 'td[4]/span',
		points : 'td[4]/span/@title',
		coords : 'td[5]/a',
		tag : '//table[@class="members bborder"]/tbody/tr[2]/td[2]/span'
	},
	
	galaxy : { 
		rows : '//tr[@class="row"]',
		position : 'td[contains(@class, "position")]/text()',
		planetname : 'td[@class="planetname"]/text()',
		planetname_l : 'td[@class="planetname"]/a/text()',
		planetname_tooltip : 'td[@class="tipsGalaxy microplanet"]/div/div/h4/span/span/text()',
		moon : 'td[@class="moon"]/a',
		debris : 'descendant::li[@class="debris-content"]',
		playername : 'td[contains(@class,"playername")]/*[1]',//* pour a en general, span pour joueur courant,
		playername2 : 'td[contains(@class,"playername")]/*[2]', //Pour joueur bandit ou empereur
		playername_tooltip : 'td[contains(@class,"playername")]/div/div/h4/span/span/text()',
		allytag : 'td[contains(@class, "allytag")]/span/text()',
		status : 'descendant::span[@class="status"]',
		activity : 'td[contains(@class,"microplanet")]/div[contains(@class,"activity")]/text()',
		player_id : 'descendant::a[contains(@href,"writemessage")]/@href',
		ally_id : 'descendant::a[@target="_ally"]/@href',
		table_galaxy : '//table[@id="galaxytable"]/tbody',
		table_galaxy_header : '//table[@id="galaxytable"]/tbody/tr[@class="info info_header"]',
		galaxy_input : '//table[@id="galaxytableHead"]//input[@id="galaxy_input"]',
		system_input : '//table[@id="galaxytableHead"]//input[@id="system_input"]'
	},
	
	levels : {
		level : '//span[@class="level"]/text()'
	},
	
	messages : {
		from : '//tr[1]/td',
		to : '//tr[2]/td',
		subject : '//tr[3]/td',
		date : '//tr[4]/td',
		reply : "//*[contains(@class,'toolbar')]/li[contains(@class,'reply')]",
		contents : {
			'spy' : '//div[@class="note"]',
			'msg': '//div[@class="note"]',
			'ally_msg': '//div[@class="note"]',
			'expedition': '//div[@class="note"]',
			'rc': '//div[@id="battlereport"]',
			'rc_cdr': '//div[@class="note"]',
			'ennemy_spy': '//div[@class="textWrapper"]/div[@class="note"]',
			'livraison': '//div[@class="note"]',
			'livraison_me': '//div[@class="note"]'
		},
		spy : {
			playername : '//table[@class="material spy"]//span[contains(@class,"status")]/text()',
			fleetdefbuildings : '//table[contains(@class, "spy")]//th[@colspan="6"]',
			moon : '//a[@class="buttonSave"]'
		}
	},
	
	parseTableStruct : {
		units : "id('buttonz')//ul/li/div/div",
		id : "a[starts-with(@id,'details')]",
		number : "a/span"
	},
	
	planetData : {
		name : "id('selectedPlanetName')",
		name_planete : "//span[@class='planet-name']",
		coords : "//div[@class='smallplanet']/a[contains(@class,'active') or @href='#']/span[@class='planet-koords']",
		coords_unique_planet : "//div[@class='smallplanet']/a[contains(@class,'') or @href='#']/span[@class='planet-koords']"
	},
	
	ranking : { 
		date : "//div[@id=\'OGameClock\']/text()",
		time : "//div[@id=\'OGameClock\']/span/text()",
		who : "//div[@id=\'categoryButtons\']/a[contains(@class,'active')]/@id",
		type : "//div[@id=\'typeButtons\']/a[contains(@class,'active')]/@id",
		subnav_fleet : "//div[@id=\'subnav_fleet\']/a[contains(@class,'active')]/@rel",
		
		rows : "id(\'ranks\')/tbody/tr",
		position : "td[contains(@class,\'position\')]/text()",
		points :  "td[contains(@class,\'score\')]/text()",
		allytag : "td[@class=\'name\']/span[@class=\'ally-tag\']/a/text()",
		ally_id : "td[@class=\'name\']/span[@class=\'ally-tag\']/a/@href",
		player : {
			playername : "td[@class=\'name\']//a[contains(@href,\'galaxy\') and contains(@href,\'system\')]/span/text()",
			player_id : "td[@class=\'sendmsg\']//a[contains(@href,\'writemessage\')]/@href",
			spacecraft : "td[@class=\'score tipsStandard\']/@title"
		},
		
		ally : {
			members : "td[@class=\'name tipsStandard\']/text()",
			points_moy :  "td[@class=\'score tipsStandard\']/@title"
		}
	},
	
	ressources : {
		metal : '//span[@id="resources_metal"]/text()',
		cristal : '//span[@id="resources_crystal"]/text()',
		deuterium : '//span[@id="resources_deuterium"]/text()',
		antimatiere : '//span[@id="resources_darkmatter"]/text()',
		energie : '//span[@id="resources_energy"]/text()'	
	},
		
	rc : {
		list_infos : '//td[@class="newBack"]/center',
		list_rounds : '//div[@class="round_info"]',
		infos : {
			player : 'span[contains(@class, "name")]',
			weapons : 'span[contains(@class, "weapons")]',
			destroyed : 'span[contains(@class, "destroyed")]'
		},
		list_types : 'table/tbody/tr[1]/th',
		list_values : 'table/tbody/tr[2]/td',
		result : '//div[@id="combat_result"]',
		combat_round : '//div[@id="master"]'//div[@class="combat_round"]'
	},
		
	writemessage : {
		form : '//form[1]',
		from : 'id("wrapper")/form/div/table/tbody/tr[1]/td',
		to : 'id("wrapper")/form/div/table/tbody/tr[2]/td',
		subject : 'id("wrapper")/form/div[1]/table/tbody/tr[3]/td/input',
		date : 'id("wrapper")/form/div/table/tbody/tr[4]/td',
		content : 'id("wrapper")/form/div[2]/div/textarea'
	},
	
	eventlist : {
		overview_event : '//span[@id="eventHostile"]/text()',
		attack_id : '@id',
		attack_event : '//tr[@class="eventFleet" and td[contains(@class,"hostile")]]',
		attack_arrival_time : 'td[@class="arrivalTime"]/text()',
		attack_origin_attack_planet : 'td[@class="originFleet"]/text()',
		attack_origin_attack_coords : 'td[@class="coordsOrigin"]/a/text()',
		attack_attacker_name : 'td[@class="sendMail"]/a/@title',
		attack_destination_planet : 'td[@class="destFleet"]/text()',
		attack_destination_coords : 'td[@class="destCoords"]/a/text()',
		attack_url_composition_flotte : 'td[@class="icon_movement"]/span/@href',
		group_id : '//tr[@class="allianceAttack"]/td[a/@class="toggleInfos infosClosed"]/a/@rel',
		group_event : '//tr[starts-with(@class,"partnerInfo {0}")]',
		group_attack : '//tr[@class="allianceAttack hostile" and td[a/@class="toggleInfos infosClosed"]/a/@rel=\'{0}\']',
		group_attack_parent : '//tr[@class="allianceAttack" and td[a/@rel=\'{0}\']]',
		group_arrival_time : 'td[@class="arrivalTime"]/text()',
		group_origin_attack_planet : 'td[@class="originFleet"]/a/text()',
		group_origin_attack_coords : 'td[@class="coordsOrigin"]/a/text()',
		group_attacker_name : 'td[@class="sendMail"]/a/@title',
		group_destination_planet : 'td[@class="destFleet"]/text()',
		group_destination_coords : 'td[@class="destCoords"]/a/text()',
		group_url_compo : 'td[@class="icon_movement"]/span/@rel'
	}
}

// Toutes les unites du jeu
// id : nom du champ dans la bdd
XnewOgame.database = {
	'resources': {601:'metal',602:'cristal',603:'deuterium',604:'energie'},
	'buildings': { 1:'M', 2:'C', 3:'D', 4:'CES', 
						12:'CEF', 14:'UdR', 15:'UdN', 
						21:'CSp', 212:'Sat', 22:'HM', 23:'HC', 
						24:'HD', 31:'Lab', 33:'Ter', 
						34:'DdR', 44:'Silo', 41:'BaLu', 
						42:'Pha', 43:'PoSa'
						},
	'researchs': { 106:'Esp', 108:'Ordi', 109:'Armes',
						110:'Bouclier', 111:'Protection', 
						113:'NRJ', 114:'Hyp', 115:'RC', 
						117:'RI', 118:'PH', 120:'Laser', 
						121:'Ions', 122:'Plasma', 123:'RRI', 
						124: 'Astrophysique', 199:'Graviton'
						},
	'fleet': { 		202:'PT', 203:'GT', 204:'CLE', 205:'CLO',
						206:'CR', 207:'VB', 208:'VC', 209:'REC', 
						210:'SE', 211:'BMD', 212:'SAT', 213:'DST', 
						214:'EDLM', 215:'TRA',
						},
	'defense': { 	401:'LM', 402:'LLE', 403:'LLO', 404:'CG',
						405:'AI', 406:'LP', 407:'PB', 408:'GB', 
						502:'MIC', 503:'MIP' 
						}
}
	
XnewOgame.regexps = {
	planetNameAndCoords : ' (.*) \\[(\\d+:\\d+:\\d+)\\]',
	planetCoords : '\\[(\\d+:\\d+:\\d+)\\]',
	userNameAndCoords : '(.*) \\[(\\d+:\\d+:\\d+)\\]',
	userNameAndDestroyed : ' (.*) d.truit',
	moon : '=(\\d+)*',
	
	messages : {
		ennemy_spy : '\\[(\\d+:\\d+:\\d+)\\][^\\]]*\\[(\\d+:\\d+:\\d+)\\][^%\\d]*([\\d]+)[^%\\d]*%',		
		trade_message_infos : 'Une flotte .trang.re de (.*) [(](.*)\\[(\\d+:\\d+:\\d+)\\][)] a livr. des ressources . (.*) \\[(\\d+:\\d+:\\d+)\\]',
		trade_message_infos_me : 'Votre flotte de la plan.te (.*) \\[(\\d+:\\d+:\\d+)\\] a atteint la plan.te (.*) \\[(\\d+:\\d+:\\d+)\\] et y a livr. les ressources suivantes',
		trade_message_infos_res_livrees : '(.*)Vous aviez [:]',
		trade_message_infos_res : 'M.tal(.*)Cristal(.*)Deut.rium(.*)',
		trade_message_infos_me_res : 'tal(.*)Cristal(.*)Deut.rium(.*)'
	},
	spy : {
		player : " '(.*)'\\)"
	},
	probability : ': (\\d+) %',
	coords : '\\[(\\d+:\\d+:\\d+)\\]',
	ally : 'Alliance \\[(.*)\\]',
	ally_msg_player_name : '<a href.*>(.*)</a>',
	
	parseTableStruct : '<a[^>]*id="details(\\d+)"[^>]*>[\\D\\d]*?([\\d.]+[KMG]?)<\/span>[^<]*<\/span>[^<]*<\/a>'
}


XnewOgame.contants = {
	galaxy_link : {
		td_colspan : '13',
		td_style : 'background: url("http://gf1.geo.gfsrv.net/cdn2b/1479c3eccd39bf4e3c4d37d4877387.gif") repeat-x scroll -1px 0 transparent; padding: 0 10px;',
		a_style : 'color: #FFFFFF; cursor: pointer; text-decoration: none;',
		a_libelle : 'OGSPY [{0}:{1}]'
	}	
}