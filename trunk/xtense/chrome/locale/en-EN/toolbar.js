/**
 * @author OGSteam
 * @license GNU/GPL
 */

Ximplements(Xlocales, {
	'toolbar activated': 'Toolbar activated',
	'toolbar deactivated': 'Toolbar disabled',
	
	'ogspy menu tooltip': 'Automatic connexion to an OGSpy server',
	
	'fatal error': 'A critical error has occured and stoped the execution of Xtense',
	'parsing error': 'A critical error has occured during the parsing of the page',
	
	'no ogspy server': 'No OGSpy serveur',
	//'no ogame page': 'Page ogame non pris en compte',
	'no server': 'No server configurated for this universe',
	'unknow page': 'Unknown page',
	'activate': 'Activate',
	'deactivate': 'Disable',
	'wait send': 'Waiting for manual sending',
	'unavailable parser lang': 'Xtense doesn\'t support this server: ($1)', // lang (ogame domain extension)
	'hostiles': 'Hostile fleet detected on $1',
	'no hostiles': 'No Hostile fleet detected on member of community',		
	
	'overview detected': 'Overview detected',
	'buildings detected': 'Buildings detected',
	'installations detected': 'Installations détectés',
	'researchs detected': 'Researchs detected',
	'fleet detected': 'Fleet detected',
	'defense detected': 'Defense detected',
	'messages detected': 'Messages inbox detected',
	'ranking detected': '$2 ranks of $1 detected', // Primary type (ally/player), Secondary type (points, research, fleet)
	'ally_list detected': 'Alliance\'s members list detected',
	'system detected': 'Solar system [$1:$2] detected', // Galaxy, System
	're detected': 'Spy report detected',
	'rc detected': 'Battle report detected',
	'res detected': 'Trade message detected',
	
	'no researchs' : 'No research found',
	'no defenses' : 'No defense found',
	'no buildings' : 'No building found',
	'no fleet' : 'No fleet found',
	
	'ranking player': 'players',
	'ranking ally': 'alliances',
	'ranking points': 'points',
	'ranking economy': 'economy',
	'ranking fleet': 'military',
	'ranking fleet4': 'military (loosed)',
	'ranking fleet5': 'militaire (constructed',
	'ranking fleet6': 'militaire (destroyed)',
	'ranking fleet7': 'militaire (honor)',
	'ranking research': 'research',
	'ranking defense': 'defense',
	'ranking buildings': 'buildings',
	
	'invalid system': 'Incorrect solar system',
	'invalid ranking': 'Incorrect ranks page',
	'invalid rc': 'Incorrect battle report',
	'no ranking': 'No rank found',
	'no messages': 'No message found',
	'impossible ranking': 'Alliance ranks can\'t be found if displayed in "Per Member" order',
	
	// Responses
	'response start': 'Server $1 : ', // Serveur number
	'http status 403': 'Error 403, Xtense module is unaccessible',
	'http status 404': 'Error 404, Xtense module can\'t be found',
	'http status 500': 'Error 500, Internal server error',
	'http timeout': 'OGSpy server is not responding',
	'http status unknow': 'Unknown error code: $1', // Http status
	'empty response': 'Empty response from the module',
	'invalid response': 'Unknown response from the module (activate debug mode to see content)',
	'response hack': 'Data was refused by Xtense module on server',
	
	'error php version': 'Xtense needs PHP 5.1 to work properly, the current version ($1) is not recent enough',
	'error wrong version plugin': 'The version of the module is incompatible with the version of your toolbar (required: $1, module version : $2)', // required version, actual version
	'error wrong version xtense.php': 'The file xtense.php of the server hasn\'t the same version as the module',
	'error wrong version toolbar': 'The version of your toolbar is incompatible with the version of the module (required: $1, your version: $2)', // required version, actual version
	'error server active': 'OGSpy server disabled (Reason: $1)', // reason
	'error username': 'Incorrect username',
	'error password': 'Incorrect password',
	'error user active': 'Your account is disabled',
	'error home full': 'Your personnal space is full, impossible to add a new planet',
	'error plugin connections': 'Connections to plugins are not allowed to you on this server',
	'error plugin config': 'Xtense module not configurated',
	'error plugin univers': 'Your game server URL is not the same as the one in the module',
	'error grant start': 'You don\'t have the necessary authorization to send ',
	'error grant empire': 'the pages from your empire (Buildings, Researchs...)',
	'error grant messages': 'messages',
	'error grant system': 'solar systems',
	'error grant ranking': 'ranks',
	
	'success home updated': 'Personnal space updated ($1)', // Page name
	'success system': 'Solar system [$1:$2] updated', // Galaxy, System
	'success ranking': '$2 ranks of $1 ($3-$4) updated', // Primary type, secondary type, offset min, offset max
	'success rc': 'Battle report sent',
	'success ally_list': 'Members list of alliance [$1] sent', // TAG
	'success messages': 'Message sent',
	'success fleetSending': 'Fleet departure sent',
	'success spy': 'Spy report sent',
	'success res': 'Trade message correctly sent',
	
	'unknow response': 'Unknown response code : "$1", data: "$2"', // code, content
	
	'page overview': 'Overview',
	'page buildings': 'Buildings',
	'page installations': 'Installations',
	'page labo': 'Research',
	'page defense': 'Defense',
	'page fleet': 'Fleet',
	'page fleetSending': 'Fleet departure',
	
	//'PM':'PM',
	
	'call messages': '-- Messages renvoyés par les appels'
});
