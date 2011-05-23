<?php
/**
* uninstall.php Desinstallation du module OGSign
* @package OGSign
* @author oXid_FoX
* @link http://www.ogsteam.fr
*	created		: 27/08/2006
*/


if (!defined('IN_SPYOGAME')) die('Hacking attempt');

require_once('sign_include.php');

// on vide le cache

// liste tous les fonds (obligatoirement des PNG)
unset($liste_fonds);
// @ pour �viter le E_WARNING si le cache n'existe pas.
if ($dh = @opendir(DIR_SIGN_CACHE)) {
	while (($nom_fichier = readdir($dh)) !== false) {
		if (strpos($nom_fichier,'.png'))
			$liste_fonds[] = $nom_fichier;
	}
	closedir($dh);
}
if (isset($liste_fonds))
	foreach($liste_fonds as $fond)
		unlink(DIR_SIGN_CACHE.$fond);


// pour savoir si on a pu �crire la version actuellement install�e
$ecrit = FALSE;

// on ne supprime rien si l'admin a choisi de garder les donn�es
if (file_really_exists(DIR_SIGN_CACHE.'keep_ogsign_datas')) {
	// on va stocker le num�ro de la version install�e, pour la prochaine r�install
	// d'abord, le num�ro de version
	$result = mysql_query('SELECT `version` FROM `'.TABLE_MOD.'` WHERE `id` = \''.$pub_mod_id.'\'');
	$OGSign_version = mysql_result($result,0,'version');
	// ensuite, on l'�crit
	$handle = @fopen(DIR_SIGN_CACHE.'keep_ogsign_datas','w');
  $ecrit = @fwrite($handle, $OGSign_version);
  @fclose($handle);

	// on "affiche" l'erreur...
	if ($ecrit === FALSE || $handle === FALSE) {
		$ecrit = FALSE;
		// il faut virer le flag pour la prochaine r�install, sinon, �a ne va pas installer grand chose...
		$flag_suppr = @unlink(DIR_SIGN_CACHE.'keep_ogsign_datas');
		echo '<script language="JavaScript" type="text/javascript">alert("ERREUR !!!\n\nProbl�me d\'�criture dans le cache.\nLes donn�es seront toutes supprim�es !';
		// et comme il y a peu de chances que la suppression du flag fonctionne, l'user doit le faire. (mais s'il n'a pas �t� �crit... il n'y en a pas)
		if (!$flag_suppr)
			echo '\nVous devez absolument supprimer ce fichier \"',jsspecialchars(DIR_SIGN_CACHE.'keep_ogsign_datas'),'\" (si pr�sent) avant de faire une r�installation d\'OGSign.';

		echo '")</script>';
	}
}

// donc si on n'a pas pu inscrire la version, ou simplement si on ne devait pas conserver les donn�es, on fait le nettoyage
if ($ecrit === FALSE) {
	$queries = array();
	// suppression de la table d'enregistrement des signatures (joueurs & alliance)
	$queries[] = 'DROP TABLE IF EXISTS `'.TABLE_USER_SIGN.'`';
	$queries[] = 'DROP TABLE IF EXISTS `'.TABLE_ALLY_SIGN.'`';

	// suppression du param�tre univers
	$queries[] = 'DELETE FROM `'.TABLE_CONFIG.'` WHERE `config_name` = \'univers\'';

	// ex�cution de toutes les requ�tes
	foreach ($queries as $query) {
		$db->sql_query($query, false);
	}
}

?>
