var XtenseXpaths = {
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
	rows : "//table[@class=\'members zebra bborder\']/tbody/tr",
	player : "td[1]",
	rank : "td[4]/span",
	points : "td[4]/span/@title",
	coords : "td[5]/a",
	tag : "//table[@class=\'members bborder\']/tbody/tr[2]/td[2]/span"
},

overview : {
	cases : "//*[@id=\'diameterContentField\']/span[2]",
	temperatures : "//*[@id=\'temperatureContentField\']/text()"
},

galaxy : { 
	rows : "//tr[@class=\'row\']",
	position : "td[@class=\'position\']/text()",
	planetname : "td[@class=\'planetname\']/text()",
	planetname_l : "td[@class=\'planetname\']/a/text()",
	moon : "td[@class=\'moon\']/a",
	debris : "descendant::li[@class=\'debris-content\']",
	playername : "td[contains(@class,\'playername\')]/*[1]",//* pour a en général, span pour joueur courant,
	allytag : "td[@class=\'allytag\']/span/text()",
	status : "descendant::span[@class=\'status\']",
	activity : "descendant::div[@id=\'TTPlanet\']/descendant::span[@class=\'spacing\']/text()",
	player_id : "descendant::a[contains(@href,\'writemessage\')]/@href",
	ally_id : "descendant::a[@target=\'_ally\']/@href"
},

levels : {
	level : "//span[@class=\'level\']/text()"
},

messages : {
	from : "//tr[1]/td",
	to : "//tr[2]/td",
	subject : "//tr[3]/td",
	date : "//tr[4]/td",
	contents : {
		"spy" : "//div[@class=\'note\']",
		"msg": "//div[@class=\'note\']",
		"ally_msg": "//div[@class=\'note\']",
		"expedition": "//div[@class=\'note\']",
		"rc": "//div[@id=\'battlereport\']",
		"rc_cdr": "//div[@class=\'note\']",
		"ennemy_spy": "//div[@class=\'textWrapper\']/div[@class=\'note\']",
		"livraison": "//div[@class=\'note\']",
		"livraison_me": "//div[@class=\'note\']"
	},
	spy : {
		fleetdefbuildings : "//table[contains(@class,\'spy\')]//th[@colspan=\'6\']",
		moon : "//a[@class=\'buttonSave\']"
	}
},

parseTableStruct : {
	units : "id(\'buttonz\')//ul/li/div/div",
	id : "a[starts-with(@id,\'details\')]",
	number : "a/span"
},

planetData : {
	name : "id(\'selectedPlanetName\')",
	name_planete : "//span[@class=\'planet-name\']",
	coords : "//div[@class=\'smallplanet\']/a[contains(@class,\'active\') or @href=\'#\']/span[@class=\'planet-koords\']",
	coords_unique_planet : "//div[@class=\'smallplanet\']/a[contains(@class,\'\') or @href=\'#\']/span[@class=\'planet-koords\']"
},

ranking : { 
	time : "//div[@id=\'statisticsContent\']//div[@class=\'header\']/h3/text()",
	who : "//input[@id=\'who\']/@value",
	type : "//input[@id=\'type\']/@value",
	
	rows : "id(\'ranks\')/tbody/tr",
	position : "td[@class=\'position\']/text()",
	player : {
		playername : "td[@class=\'name\']//a[contains(@href,\'galaxy\') and contains(@href,\'system\') and contains(@href,\'position\')]/text()",
		allytag : "td[@class=\'name\']//a[contains(@href,\'alliance\') or contains(@href,\'ainfo.php?allyid\')]/text()",
		points :  "td[@class=\'score\']/text()",
		player_id : "td[@class=\'sendmsg\']//a[contains(@href,\'writemessage\')]/@href",
		ally_id : "td[@class=\'name\']//a[contains(@target,\'_ally\')]/@href"
	},
	
	ally : {
		position_ally : "td[1]/text()",
		allytag : "td[2]/a[contains(@href,\'alliance\') or contains(@href,\'ainfo.php?allyid\')]/text()",
		points :  "td[4]/text()",
		members : "td[5]/text()",
		ally_id : "td[2]/a[contains(@target,\'_ally\')]/@href"
	}
},

ressources : {
	metal : "//span[@id=\'resources_metal\']/text()",
	cristal : "//span[@id=\'resources_crystal\']/text()",
	deuterium : "//span[@id=\'resources_deuterium\']/text()",
	antimatiere : "//span[@id=\'resources_darkmatter\']/text()",
	energie : "//span[@id=\'resources_energy\']/text()"	
},

rc : {
	list_infos : "//td[@class=\'newBack\']/center",
	list_rounds : "//div[@class=\'round_info\']",
	infos: {
		player : "span[contains(@class,\'name\')]",
		weapons : "span[contains(@class,\'weapons\')]",
		destroyed : "span[contains(@class,\'destroyed\')]"
	},
	list_types : "table/tbody/tr[1]/th",
	list_values : "table/tbody/tr[2]/td",
	result : "//div[@id=\'combat_result\']",
	combat_round : "//div[@id=\'master\']//div[@class=\'combat_round\']"
},

writemessage : {
	form : "//form[1]",
	from : "id(\'wrapper\')/form/div/table/tbody/tr[1]/td",
	to : "id(\'wrapper\')/form/div/table/tbody/tr[2]/td",
	subject : "id(\'wrapper\')/form/div[1]/table/tbody/tr[3]/td/input",
	date : "id(\'wrapper\')/form/div/table/tbody/tr[4]/td",
	content : "id(\'wrapper\')/form/div[2]/div/textarea"
	}
}