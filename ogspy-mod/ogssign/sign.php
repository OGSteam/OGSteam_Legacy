<?php 
/**
* sign.php L'appel pour la creation de l'image dynamique
* @package OGSign
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created	: 04/09/2006 11:49:41
*/


// variable de s�curit�
define('OGSIGN', true);

// Connexion � la BDD pour prendre les informations dans les tables
require('sign_connexion.php');

// on d�finit le path du journal (ne sert que pour le d�buggage), AVANT l'appel � /includes/config.php (car cette constante y est aussi d�finie)
define('PATH_LOG', '../../journal/');
// afin d'�viter l'erreur NOTICE: Constant PATH_LOG already defined
$old_error_report = error_reporting(0);
// pour les noms de tables
require_once('../../includes/config.php');
// et on restaure le niveau d'erreur
error_reporting($old_error_report);

// les param�tres de OGSign
require_once('sign_include.php');

// pour interdire la mise en cache
header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date du pass�
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // toujours modifi�

// r�cup�ration imm�diate du nom. urldecode, pour g�rer les espaces dans les pseudos
if (isset($_GET['player']))
	$nom_player = urldecode($_GET['player']);
else {
	mysql_close($bdd);
	exit('Avec le nom du joueur, cela fonctionnerait mieux...');
}

// d�tection du type de signature
$type_sign = '';
if (isset($_GET['typesign']) && ($_GET['typesign'] == 'S' || $_GET['typesign'] == 'P' || $_GET['typesign'] == 'A' ))
	$type_sign = $_GET['typesign'];

if ($type_sign == 'A') {
	$ally_id = $nom_player;

	// protection des donn�es "utilisateur" contre les injections SQL. merci au manuel PHP !
	$ally_id_protege = quote_smart($ally_id);

	if (is_numeric($nom_player)) {
	// si num�rique, donc on a appel� � partir du num de l'alliance. rien de plus � faire
		$quet = mysql_query('SELECT * FROM `'.TABLE_ALLY_SIGN.'` WHERE `ally_id` = '.$ally_id_protege);
	} else {
	// sinon, on a appel� � partir du nom du joueur ; et l�, il faut retrouver l'alliance du joueur � partir de ses plan�tes

		// recherche de l'ID du joueur
		$result = mysql_query('SELECT `user_id` FROM `'.TABLE_USER_SIGN.'` WHERE `pseudo_ig` = '.$ally_id_protege);
		$user_id = mysql_result($result,0,'user_id');

		// on cherche les coordonn�es dans la partie "Espace personnel > Empire" du joueur (puisqu'on est s�r qu'il y a des plan�tes)
		$result = mysql_query('SELECT `coordinates` FROM '.TABLE_USER_BUILDING.' WHERE `coordinates` <> \'\' and `user_id` = '.$user_id.' LIMIT 1');
		$coords = mysql_result($result,0,'coordinates');

		$coords = explode(':',$coords);

		// enfin, d'apr�s ces coords, on trouve le tag de l'ally du joueur
		$result = mysql_query('SELECT `ally` FROM '.TABLE_UNIVERSE.' WHERE `galaxy` = '.$coords[0].' and `system` = '.$coords[1].' and `row` = '.$coords[2]);
		$alli_u = mysql_result($result,0,'ally');

		// enfin, on r�cup�re les param de la sign ally
		$quet = mysql_query('SELECT * FROM `'.TABLE_ALLY_SIGN.'` WHERE `TAG` = '.quote_smart($alli_u));
	}
} else {
	// protection des donn�es "utilisateur" contre les injections SQL. merci au manuel PHP !
	$nom_player_protege = quote_smart($nom_player);

	// param�tres de la signature
	$quet = mysql_query('SELECT * FROM `'.TABLE_USER_SIGN.'` WHERE `pseudo_ig` = '.$nom_player_protege);
}
$param_sign = mysql_fetch_array($quet,MYSQL_ASSOC);

// petite v�rification, pour ne pas faire de traitement dans le vide
if ($param_sign === FALSE) {
	mysql_close($bdd);
	exit('Erreur de pseudo ou signature non configur�e !');
}

// on r�cup�re l'univers
$query = mysql_query('SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name` = \'univers\'');
$result = mysql_fetch_array($query,MYSQL_ASSOC);
$uni_u = $result['config_value'];

switch($type_sign) {
	case 'P':	// signature production
		if ($param_sign['sign_prod_active'] == 1)
			require_once('sign_prod.php');
		else
			echo 'Signature d�sactiv�e';
		break;
	case 'A':	// signature alliance
		if ($param_sign['sign_active'] == 1)
			require_once('sign_ally.php');
		else
			echo 'Signature d�sactiv�e';
		break;
	default:	// signature statistiques
		if ($param_sign['sign_stats_active'] == 1)
			require_once('sign_stats.php');
		else
			echo 'Signature d�sactiv�e';
}

// ne pas oublier �a...
mysql_close($bdd);

// et maintenant, il faut afficher l'image, sauf s'il y a eu des erreurs...
// Modification du header
if (!headers_sent()) {
	header ('Content-type: image/png');

	// rien trouv� de mieux, sans passer par la lib GD...
	// le but �tant d'�conomiser des ressources CPU
	// (si l'image est d�j� cr��e et � jour, rien ne sert de refaire l'image)
	readfile($fichier_stats);
}

?>