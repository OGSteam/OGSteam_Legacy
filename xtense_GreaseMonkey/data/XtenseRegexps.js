var XtenseRegexps = {
planetNameAndCoords : ' (.*) \\[(\\d+:\\d+:\\d+)\\]',
planetCoords : '\\[(\\d+:\\d+:\\d+)\\]',
userNameAndCoords : '(.*) \\[(\\d+:\\d+:\\d+)\\]',
userNameAndDestroyed : ' (.*) d.truit',
moon : '=(\\d+)*',

messages : {
	ennemy_spy : '\\[(\\d+:\\d+:\\d+)\\][^\\]]*\\[(\\d+:\\d+:\\d+)\\][^%\\d]*([\\d]+)[^%\\d]*%',		
	trade_message_infos : 'Une flotte .trang.re de (\\S+) livre des ressources . (\\S+) (\\S+) :',
	trade_message_infos_me : 'Votre flotte atteint la plan.te (.*) (.*) et y livre les ressources suivantes',
	trade_message_infos_res_livrees : '(.*)Vous aviez :',
	trade_message_infos_res : 'M.tal : (.*) Cristal : (.*) Deut.rium : (.*)',
	trade_message_infos_me_res : 'M.tal :(.*)Cristal:(.*)Deut.rium:(.*)'
},
spy : {
	player : " '(.*)'\\)"
},
probability : ': (\\d+) %',
coords : '\\[(\\d+:\\d+:\\d+)\\]',
ally : 'Alliance \\[(.*)\\]',

parseTableStruct : '<a[^>]*id="details(\\d+)"[^>]*>[\\D\\d]*?([\\d.]+[KMG]?)<\/span>[^<]*<\/span>[^<]*<\/a>'
}