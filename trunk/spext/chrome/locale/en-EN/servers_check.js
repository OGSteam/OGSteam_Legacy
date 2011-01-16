/**
 * @author OGSteam
 * @license GNU/GPL
 */

 Ximplements(Xlocales, {
	'error start': 'ERROR: ',
	'http status 403': 'Error 403, Xtense module is unaccessible',
	'http status 404': 'Error 404, Xtense module can\'t be found, check the url',
	'http status 500': 'Error 500, Internal server error',
	'http timeout': 'Server isn\'t responding. Check that your host doesn\'t have network problems.',
	'http status unknow': 'Unknown http status ($1)',

	'incorrect response' : 'Incorrect response',
	'empty response': 'Empty response from the module',
	'invalid response': 'Unknown response from the module, check that your server does\'t include ad, which can create this error.',
	
	'php version': 'The PHP version of your server is not recent enough. Xtense requires PHP 5.1.',
	'error occurs': 'An error occured',
	'wrong version plugin': 'The version of the module is incompatible with the version of your toolbar.\nModule version : $1, required version : $2 \nYou need to update the module on OGSpy to continue.', // Actual pluhin version, version required
	'wrong version xtense.php': 'The file xtense.php of the server hasn\'t the same version as the module',
	'wrong version toolbar': 'The version of your toolbar is incompatible with the version of the module.\nYour version : $1, required version : $2\nYou need to update Xtense toolbar to continue', // Actual toolbar version, version required
	'server active': 'The OGSpy server is disabled',
	'plugin connections': 'Connections to plugins are not allowed to you on this server',
	'plugin config': 'Xtense module is not configurated, ask your administrator to configure it',
	'plugin univers': 'Your game server URL is not the same as the one in the module',
	
	'username': 'Account "$1" doesn\'t exist. Check the case.', // Username
	'password': 'Incorrect password. Check the case.',
	'user active': 'Your account is disabled, you can\'t log in.',
	
	'informations': 'Informations',
	'server name': 'OGSpy server name', // Server name
	'version': 'Version', // version
	'grant all': 'You have all the rights to use Xtense',
	'grant nothing': 'You don\'t have the authorization to import data on this OGSpy server',
	
	'grant can': 'can',
	'grant cannot': 'can\'t',
	'grant system': 'You $1 add solar systems', // can / cannot
	'grant ranking': 'You $1 add ranks', // can / cannot
	'grant empire': 'You $1 update your personnal area (Buildings, Research, Empire...)', // can / cannot
	'grant messages': 'You $1 add messages (Spy reports, Battle reports, Private messages...)', // can / cannot
	
	'checking end': 'CHECKING IS OVER',
	'checking errors': 'One or more errors occured, you can either return to the options window or close this one ignoring the errors.',
	'checking success': 'Everything is fine, you can exit',
	
	'connecting': 'Connecting to : ', // Server url
	'checking server': 'Verification of OGSpy server No $1' // Server number
});
