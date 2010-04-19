/**
 * @author OGSteam
 * @license GNU/GPL
 */
 
XEUnivers.Xpaths = {
		/* ranks page */
	ranks : {
		time:"id('divpage')/center/form/table[1]/tbody/tr[2]/td/div",//text with the time of update
		lines:"id('divpage')/center/form/table[2]/tbody/tr",//every line of the table with ranks
		},
		
	galaxy : { 
		rows : 'id("divpage")/table/tbody/tr'
		/*position : 'td[@class="position"]/text()',
		planetname : 'td[@class="planetname"]/text()',
		moon : 'td[@class="moon"]/a',
		debris : 'descendant::li[@class="debris-content"]',
		playername : 'td[contains(@class,"playername")]/*[1]',//* pour a en général, span pour joueur courant,
		allytag : 'td[@class="allytag"]/span/text()',
		status : 'descendant::span[@class="status"]',
		activity : 'descendant::div[@id="TTPlanet"]/descendant::span[@class="spacing"]/text()',

		galaxy : '//form[@name="galaform"]//input[@name="galaxy"]/@value',
		system : '//form[@name="galaform"]//input[@name="system"]/@value'*/
	}
}

XEUnivers.regexps = {
	ranks : { 
		'player' : "<th[^>]*>(\\d+)\\D"+//classement
						".*"+
						"<th[^>]*><(?:a|font)[^>]*>(.*)</(?:a|font)></th>.*action=ecriremessages.*dest=(\\d+)"+//joueur et son id
						".*"+
						"Evolution.*<th[^>]*>(?:<a[^>]*action=alliance[^>]*alliance=(\\d+)[^>]*>(.*)</a>)?</th>"+//alliance et son id
						'<th[^>]*>(?:[^<]*<a.*href="#">)?(.*)(?:</a>)?</th>$'+//points
						"",	
		'ally' : ""+
						"<th[^>]*>(\\d+)\\D"+//classement
						".*"+
						"<th[^>]*>\\[<a[^>]*action=alliance[^>]*alliance=(\\d+)[^>]*>(.*)</a>\\]</th>"+//alliance et son id
						"<th[^>]*>(.*)</th><th[^>]*>"+//points
						""
		},
	galaxy : {
		inactive : /\(\+7\)/,
		longinactive : /\(\+21\)/,
		vacation : /<span[^>]+class="vacation"[^>]*>/,
		strong : /<span[^>]+class="strong"[^>]*>/,
		noob : /<span[^>]+class="noob"[^>]*>/
	}
}

// DonnÃ©es sur les batiments,  def...
XEUnivers.database = {
	'resources': ['titanium','carbon','tritium'],
	'buildings': { 
				1:'MTi', 2:'MCa', 3:'MTr', 4:'PGe', 5:'PTr',
				6:'FDr', 7:'FAn', 8:'Shi', 9:'STi', 10:'SCa',
				11:'STr', 12:'TCe', 13:'Con', 14:'Terr', 15:'MPl'},
	'researchs': { 
				1:'Spy', 2:'Quan',3:'Allo', 4:'Stra',5:'Refi',
				6:'Weap', 7:'Shie', 8:'Shiel', 9:'Ther', 10:'Anti',
				11:'Subl', 12:'Impu', 13:'Warp',	14:'Smart', 15:'Ions',
				16:'Aere', 17:'Calc',18:'Grav', 19:'Admi', 20: 'Expl'	},
	'fleet': { 1:'PT', 2:'GT', 3:'Fig', 4:'LFi', 5:'Freg',
				6:'Dest', 7:'Over', 8:'For', 9:'Hyp', 10:'Coll',
				11:'Spyp', 12:'Sat', 13:'Colo', 14:'Ext', 15:'Frel'},
	'defense': { 
				101:'BFG', 102:'SBFG', 103:'PCa', 104:'Def', 105:'PIo',
				106:'AMD', 107:'SF', 108:'HF', 109:'CME', 110:'EMP' }
}