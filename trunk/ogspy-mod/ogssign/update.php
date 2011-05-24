<?php
/**
* update.php Fichier de mise à jour du module OGSign
* @package OGSign
* @author oXid_FoX
* @link http://www.ogsteam.fr
*/


if (!defined('IN_SPYOGAME')) die('Hacking attempt');

// pour le nom de la table du mod
require_once('sign_include.php');

global $db;

// on récupère le numéro de version
$result = mysql_query('SELECT `version` FROM `'.TABLE_MOD.'` WHERE `title` = \''.$mod_name.'\'');
$OGSign_version = mysql_result($result,0,'version');

// et ensuite, on fait les MAJ qui s'imposent !
switch($OGSign_version) {

case '0.3':
	// création des nouveaux champs (couleur du texte variable), v0.4
	$query = 'ALTER TABLE `'.TABLE_USER_SIGN.'` ADD `couleur_txt_var_stats` VARCHAR(6) NOT NULL DEFAULT \'000000\' COMMENT \'couleur du texte variable (stats)\' AFTER `couleur_txt_stats`';
	$db->sql_query($query);
	$query = 'ALTER TABLE `'.TABLE_USER_SIGN.'` ADD `couleur_txt_var_prod` VARCHAR(6) NOT NULL DEFAULT \'000000\' COMMENT \'couleur du texte variable (production)\' AFTER `couleur_txt_prod`';
	$db->sql_query($query);

case '0.4':

case '0.5':
	// création des nouveaux champs (ombrage du texte fixe) v0.5b
	$query = 'ALTER TABLE `'.TABLE_USER_SIGN.'` ADD `ombre_stats` TINYINT(1) NOT NULL DEFAULT \'0\' COMMENT \'ombrage du texte fixe (stats)\' AFTER `sepa_milliers_stats`, ADD `ombre_prod` TINYINT(1) NOT NULL DEFAULT \'0\' COMMENT \'ombrage du texte fixe (prod)\' AFTER `sepa_milliers_prod`';
	$db->sql_query($query);

case '0.5b':

case '0.5c':
	// ajout de la sign alliance v0.6

	// suppression de la table TABLE_ALLY_SIGN si elle existe
	$query = 'DROP TABLE IF EXISTS `'.TABLE_ALLY_SIGN.'`';
	$db->sql_query($query);

	//creation table pour la sign alliance
	$query = "CREATE TABLE `".TABLE_ALLY_SIGN."` (";
	$query .= " `ally_id` int(11) NOT NULL auto_increment COMMENT 'ID de ally',";
	$query .= " `TAG` varchar(30) NOT NULL COMMENT 'TAG ingame de ally',";
	$query .= " `nom_ally` varchar(30) NOT NULL COMMENT 'nom ingame de ally',";
	$query .= " `founder_ally` varchar(20) NOT NULL COMMENT 'nom ingame du fondateur de ally',";
	$query .= " `nom_fond` varchar(255) NOT NULL default 'ally7.png' COMMENT 'nom du fichier par défaut',";
	$query .= " `couleur_txt` varchar(6) NOT NULL default '000000' COMMENT 'couleur du texte',";
	$query .= " `couleur_txt_var` varchar(6) NOT NULL default '000000' COMMENT 'couleur du texte variable',";
	$query .= " `sign_active` tinyint(1) NOT NULL default '1' COMMENT 'active ou non la signature de ally',";
	$query .= " `sepa_milliers` char(1) NOT NULL default '' COMMENT 'séparateurs de milliers pour la sign_ally',";
	$query .= " `ombre` tinyint(1) NOT NULL default '0' COMMENT 'ombrage du texte fixe',";
	$query .= " PRIMARY KEY (`ally_id`),";
	$query .= " UNIQUE KEY `TAG` (`TAG`)";
	$query .= " ) COMMENT='sauvegarde des paramètres OGSign'";
	$db->sql_query($query);

	// et vu que le htaccess (juste celui du mod_rewrite) change, on doit le remettre
	if(version_compare(phpversion(), '4.3.2') >= 0) {
		// on vérifie d'abord que la fonction d'Apache est définie (apparement, elle est désactivée chez certains hébergeurs)
		$existing_functions = get_defined_functions();
		if (in_array('apache_get_modules',$existing_functions['internal'])) {
			// et ensuite on regarde dans la liste des modules Apache chargés
			$apache_modules = apache_get_modules();
			if (in_array('mod_rewrite',$apache_modules)) {
				if (!copy($chemin_htaccess.'_mod_rewrite_ON',$chemin_htaccess))
					echo '<script language="JavaScript" type="text/javascript">alert("La création du .htaccess a échoué. Vous devez le faire manuellement :\ndans le dossier d\'OGSign, copiez le fichier \".htaccess_mod_rewrite_ON\" et renommez-le en \".htaccess\"")</script>';	// on "affiche" l'erreur...
			}
		}
	}

case '0.6':
	// ajout de l'univers dans la table de configuration, v0.7
	$query = 'INSERT IGNORE INTO `'.TABLE_CONFIG.'` (`config_name`, `config_value`) VALUES (\'univers\', \'0\')';
	$db->sql_query($query);

case '0.7':

case '0.7b':

case '0.7c':

case '0.7d':
	// unicité du pseudo_ig, v0.8

	// recherche des pseudos en "plus que 1 exemplaire" (double, triple...)
	$query = 'SELECT `pseudo_ig` FROM `'.TABLE_USER_SIGN.'` GROUP BY `pseudo_ig` HAVING COUNT(`pseudo_ig`) > 1';
	$result_pseudo = $db->sql_query($query);
	while ($pseudo_suppr = $db->sql_fetch_assoc($result_pseudo)) {
		// suppression du pseudo en doublon...
		$query = 'DELETE FROM `'.TABLE_USER_SIGN.'` WHERE `pseudo_ig` = \''.$pseudo_suppr['pseudo_ig'].'\'';
		$db->sql_query($query);
	}

	// pour éviter qu'il y ait le même pseudo_ig mais des id différents, on rend unique le pseudo_ig (maintenant que les doublons ont été enlevés)
	$query = 'ALTER TABLE `'.TABLE_USER_SIGN.'` ADD UNIQUE(`pseudo_ig`)';
	$db->sql_query($query);

case '0.8':

case '0.8b':

case '0.8c':

case '0.8d':

case '0.8e':

case '0.8eb':

case '0.8f':

	$queries = array();

	// changement du format des styles de textes et ajout de la couleur
	// user - stats
	$queries[] = 'ALTER TABLE `'.TABLE_USER_SIGN.'` CHANGE `ombre_stats` `style_texte_stats` CHAR(1) NOT NULL DEFAULT \'\' COMMENT \'style du texte (stats)\'';
	$queries[] = 'UPDATE `'.TABLE_USER_SIGN.'` SET `style_texte_stats` = \'o\' WHERE `style_texte_stats` = \'1\'';
	$queries[] = 'UPDATE `'.TABLE_USER_SIGN.'` SET `style_texte_stats` = \'\' WHERE `style_texte_stats` = \'0\'';
	$queries[] = 'ALTER TABLE `'.TABLE_USER_SIGN.'` ADD `couleur_style_txt_stats` VARCHAR(6) NOT NULL DEFAULT \'828282\' COMMENT \'couleur du style du texte (stats)\' AFTER `style_texte_stats`';
	// user - prod
	$queries[] = 'ALTER TABLE `'.TABLE_USER_SIGN.'` CHANGE `ombre_prod` `style_texte_prod` CHAR(1) NOT NULL DEFAULT \'\' COMMENT \'style du texte (prod)\'';
	$queries[] = 'UPDATE `'.TABLE_USER_SIGN.'` SET `style_texte_prod` = \'o\' WHERE `style_texte_prod` = \'1\'';
	$queries[] = 'UPDATE `'.TABLE_USER_SIGN.'` SET `style_texte_prod` = \'\' WHERE `style_texte_prod` = \'0\'';
	$queries[] = 'ALTER TABLE `'.TABLE_USER_SIGN.'` ADD `couleur_style_txt_prod` VARCHAR(6) NOT NULL DEFAULT \'828282\' COMMENT \'couleur du style du texte (prod)\' AFTER `style_texte_prod`';
	// ally - stats
	$queries[] = 'ALTER TABLE `'.TABLE_ALLY_SIGN.'` CHANGE `ombre` `style_texte` CHAR(1) NOT NULL DEFAULT \'\' COMMENT \'style du texte\'';
	$queries[] = 'UPDATE `'.TABLE_ALLY_SIGN.'` SET `style_texte` = \'o\' WHERE `style_texte` = \'1\'';
	$queries[] = 'UPDATE `'.TABLE_ALLY_SIGN.'` SET `style_texte` = \'\' WHERE `style_texte` = \'0\'';
	$queries[] = 'ALTER TABLE `'.TABLE_ALLY_SIGN.'` ADD `couleur_style_txt` VARCHAR(6) NOT NULL DEFAULT \'828282\' COMMENT \'couleur du style du texte\' AFTER `style_texte`';

	foreach ($queries as $query) {
		$db->sql_query($query, false);
	}

case '0.9':

case '0.9a':

case '0.9b':

case '0.9c':

case '0.9d':
	// ajout du choix du système de détection des stats
	$query = 'ALTER TABLE `'.TABLE_USER_SIGN.'` ADD `stats_detection_system` TINYINT(1) NOT NULL DEFAULT \'2\' COMMENT \'1: ancien système (moins de \'\'?\'\' mais sign pas forcément à jour) ; 2: système actuel (+ de \'\'?\'\' mais sign toujours à jour)\' AFTER `pseudo_ig`;';
	$db->sql_query($query);
	$query = 'ALTER TABLE `'.TABLE_ALLY_SIGN.'` ADD `stats_detection_system` TINYINT(1) NOT NULL DEFAULT \'2\' COMMENT \'1: ancien système (moins de \'\'?\'\' mais sign pas forcément à jour) ; 2: système actuel (+ de \'\'?\'\' mais sign toujours à jour)\' AFTER `founder_ally`;';
	$db->sql_query($query);

case '0.9e':
	// ajout du choix de la fréquence affichée pour la prod
	$query = 'ALTER TABLE `'.TABLE_USER_SIGN.'` ADD `frequence_prod` TINYINT(1) NOT NULL DEFAULT \'1\' COMMENT \'fréquence affichée de la production\';';
	$db->sql_query($query);
}

// MAJ du numéro de version automatique
update_mod($mod_folder,$mod_name);


?>
