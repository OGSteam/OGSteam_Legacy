/**
 * @author OGSteam
 * @license GNU/GPL
 */

XnewOgame.Xpaths = {
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
		position : 'td[@class="position"]/text()',
		planetname : 'td[@class="planetname"]/text()',
		planetname_l : 'td[@class="planetname"]/a/text()',
		moon : 'td[@class="moon"]/a',
		debris : 'descendant::li[@class="debris-content"]',
		playername : 'td[contains(@class,"playername")]/*[1]',//* pour a en g�n�ral, span pour joueur courant,
		allytag : 'td[@class="allytag"]/span/text()',
		status : 'descendant::span[@class="status"]',
		activity : 'descendant::div[@id="TTPlanet"]/descendant::span[@class="spacing"]/text()',
		player_id : 'descendant::a[contains(@href,"writemessage")]/@href',
		ally_id : 'descendant::a[@target="_ally"]/@href'
	},
	
	levels : {
		level : '//span[@class="level"]/text()'
	},
	
	messages : {
		from : '//tr[1]/td',
		to : '//tr[2]/td',
		subject : '//tr[3]/td',
		date : '//tr[4]/td',
		contents : {
			'spy' : '//div[@class="note"]',
			'msg': '//div[@class="note"]',
			'ally_msg': '//div[@class="note"]',
			'expedition': '//div[@class="note"]',
			'rc': '//div[@id="battlereport"]',
			'rc_cdr': '//div[@class="note"]',
			'ennemy_spy': '//div[@class="textWrapper"]/div[@class="note"]',
		},
		spy : {
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
		name: "id('selectedPlanetName')",
		coords : "//div[@class='smallplanet']/a[contains(@class,'active') or @href='#']/span[@class='planet-koords']"
	},
	
	ranking : { 
		time : '//div[@id="statisticsContent"]//div[@class="header"]/h3/text()',
		who : '//input[@id="who"]/@value',
		type : '//input[@id="type"]/@value',
		
		rows : 'id("ranks")/tbody/tr',
		position : 'td[@class="position"]/text()',
		player : {
			playername : 'td[@class="name"]//a[contains(@href,"galaxy") and contains(@href,"system") and contains(@href,"position")]/text()',
			allytag : 'td[@class="name"]//a[contains(@href,"alliance") or contains(@href,"ainfo.php?allyid")]/text()',
			points :  'td[@class="score"]/text()',
			player_id : 'td[@class="sendmsg"]//a[contains(@href,"writemessage")]/@href',
			ally_id : 'td[@class="name"]//a[contains(@target,"_ally")]/@href'
		},
		
		ally : {
			position_ally : 'td[1]/text()',
			allytag : 'td[2]/a[contains(@href,"alliance") or contains(@href,"ainfo.php?allyid")]/text()',
			points :  'td[4]/text()',
			members : 'td[5]/text()',
			ally_id : 'td[2]/a[contains(@target,"_ally")]/@href'
		}
	},
	
	rc : {
		list_infos : '//td[@class="newBack"]/center',
		list_rounds : '//div[@class="round_info"]',
		infos: {
			player : 'span[contains(@class, "name")]',
			weapons : 'span[contains(@class, "weapons")]'
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
						124: 'Expeditions', 199:'Graviton'
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
	moon : '=(\\d+)*',
	
	messages : {
		ennemy_spy : '\\[(\\d+:\\d+:\\d+)\\][^\\]]*\\[(\\d+:\\d+:\\d+)\\][^%\\d]*([\\d]+)[^%\\d]*%'
	},
	spy : {
		player : " '(.*)'\\)"
	},
	probability : ': (\\d+) %',
	coords : '\\[(\\d+:\\d+:\\d+)\\]',
	ally : 'Alliance \\[(.*)\\]',
	
	parseTableStruct : '<a[^>]*id="details(\\d+)"[^>]*>[\\D\\d]*?([\\d.]+[KMG]?)<\/span>[^<]*<\/span>[^<]*<\/a>'
}