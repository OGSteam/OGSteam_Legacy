<?php
/**
* install.php Installation du module OGSign
* @package OGSign
* @author oXid_FoX
* @link http://www.ogsteam.fr
*	created		: 22/08/2006
*/


if (!defined('IN_SPYOGAME')) die('Hacking attempt');
require_once('sign_include.php');

$queries = array();

//d�finition donn�e d'ajout du module

// on supprime/recr�e si l'admin n'a pas choisi de garder les donn�es
if (!file_really_exists(DIR_SIGN_CACHE.'keep_ogsign_datas')) {

	// suppression de la table TABLE_USER_SIGN si elle existe
	$queries[] = "DROP TABLE IF EXISTS `".TABLE_USER_SIGN."`";

	// cr�ation de la table d'enregistrement des signatures (pour les joueurs)
	$queries[] = "CREATE TABLE `".TABLE_USER_SIGN."` ("
	."  `user_id` int(11) NOT NULL COMMENT 'ID du compte OGSpy',"
	."  `pseudo_ig` varchar(20) NOT NULL COMMENT 'pseudo ingame du joueur',"
	."  `stats_detection_system` tinyint(1) NOT NULL default '2' COMMENT '1: ancien systeme (moins de ? mais sign pas forcement a jour) ; 2: systeme actuel (+ de ? mais sign toujours � jour)',"
	."  `nom_fond_stats` varchar(255) NOT NULL default 'stats7.png' COMMENT 'nom du fichier par d�faut (stats)',"
	."  `couleur_txt_stats` varchar(6) NOT NULL default '000000' COMMENT 'couleur du texte (stats)',"
	."  `couleur_txt_var_stats` varchar(6) NOT NULL default '000000' COMMENT 'couleur du texte variable (stats)',"
	."  `sign_stats_active` tinyint(1) NOT NULL default '1' COMMENT 'active ou non la signature des stats',"
	."  `sepa_milliers_stats` char(1) NOT NULL default '' COMMENT 's�parateurs de milliers pour la sign_stats',"
	."  `style_texte_stats` char(1) NOT NULL default '' COMMENT 'style du texte (stats)',"
	."  `couleur_style_txt_stats` varchar(6) NOT NULL default '828282' COMMENT 'couleur du style du texte (stats)',"
	."  `nom_fond_prod` varchar(255) NOT NULL default 'prod11.png' COMMENT 'nom du fichier par d�faut (production)',"
	."  `couleur_txt_prod` varchar(6) NOT NULL default '000000' COMMENT 'couleur du texte (production)',"
	."  `couleur_txt_var_prod` varchar(6) NOT NULL default '000000' COMMENT 'couleur du texte variable (production)',"
	."  `sign_prod_active` tinyint(1) NOT NULL default '1' COMMENT 'active ou non la signature des productions',"
	."  `sepa_milliers_prod` char(1) NOT NULL default '' COMMENT 's�parateurs de milliers pour la sign_prod',"
	."  `style_texte_prod` char(1) NOT NULL default '' COMMENT 'style du texte (prod)',"
	."  `couleur_style_txt_prod` varchar(6) NOT NULL default '828282' COMMENT 'couleur du style du texte (prod)',"
	."  `frequence_prod` tinyint(1) NOT NULL default '1' COMMENT 'fr�quence affich�e de la production',"
	."  PRIMARY KEY  (`user_id`),"
	."  UNIQUE KEY `pseudo_ig` (`pseudo_ig`)"
	."  ) COMMENT='sauvegarde des param�tres OGSign'";

	// suppression de la table TABLE_ALLY_SIGN si elle existe
	$queries[] = 'DROP TABLE IF EXISTS `'.TABLE_ALLY_SIGN.'`';

	//creation table pour la sign alliance
	$queries[] = "CREATE TABLE `".TABLE_ALLY_SIGN."` ("
	."  `ally_id` int(11) NOT NULL auto_increment COMMENT 'ID de ally',"
	."  `TAG` varchar(30) NOT NULL COMMENT 'TAG ingame de ally',"
	."  `nom_ally` varchar(30) NOT NULL COMMENT 'nom ingame de ally',"
	."  `founder_ally` varchar(20) NOT NULL COMMENT 'nom ingame du fondateur de ally',"
	."  `stats_detection_system` tinyint(1) NOT NULL default '2' COMMENT '1: ancien syst�me (moins de ''?'' mais sign pas forc�ment � jour) ; 2: syst�me actuel (+ de ''?'' mais sign toujours � jour)',"
	."  `nom_fond` varchar(255) NOT NULL default 'ally7.png' COMMENT 'nom du fichier par d�faut',"
	."  `couleur_txt` varchar(6) NOT NULL default '000000' COMMENT 'couleur du texte',"
	."  `couleur_txt_var` varchar(6) NOT NULL default '000000' COMMENT 'couleur du texte variable',"
	."  `sign_active` tinyint(1) NOT NULL default '1' COMMENT 'active ou non la signature de ally',"
	."  `sepa_milliers` char(1) NOT NULL default '' COMMENT 's�parateurs de milliers pour la sign_ally',"
	."  `style_texte` char(1) NOT NULL default '' COMMENT 'style du texte',"
	."  `couleur_style_txt` varchar(6) NOT NULL default '828282' COMMENT 'couleur du style du texte',"
	."  PRIMARY KEY (`ally_id`),"
	."  UNIQUE KEY `TAG` (`TAG`)"
	."  ) COMMENT='sauvegarde des param�tres OGSign'";

	// cr�ation de l'univers dans la table CONFIG
	$queries[] = 'INSERT INTO `'.TABLE_CONFIG.'` (`config_name`, `config_value`) VALUES (\'univers\', \'0\')';

	// Ajout du module dans la table des mod de OGSpy

	// insertion du mod (num�ro de version automatique)
	if (file_exists('mod/'.$mod_folder.'/version.txt')) {
		install_mod($mod_folder);
		}
} else {
	// pas de num�ro de version automatique, car si l'admin OGSign a gard� les donn�es, et qu'il y a une MAJ de la base,
	// il faudra passer par l'update pour faire cette MAJ
	// n�anmoins, il faut lire la derni�re version install�e (pour justement ne pas refaire des update d�j� effectu�s avant)
	$version_txt = file(DIR_SIGN_CACHE.'keep_ogsign_datas');
	install_mod($mod_folder);

}

// ex�cution de toutes les requ�tes
foreach ($queries as $query) {
	$db->sql_query($query, false);
}

// configuration automatique du .htaccess

// l� aussi, on supprime/recr�e si l'admin n'a pas choisi de garder les donn�es
if (!file_really_exists(DIR_SIGN_CACHE.'keep_ogsign_datas')) {

	// n�cessite PHP >= 4.3.2 pour d�tecter le mod_rewrite
	// note : cela supprimera le .htaccess d�j� pr�sent, dans le cas d'une r�installation, par exemple (mais il ne devrait pas y en avoir sur une install vierge, normalement...)
	$chemin_htaccess = 'mod/'.$mod_folder.'/.htaccess';
	// c'est la lign � ajouter au .htaccess lorsque le mod_rewrite d'Apache est d�sactiv�
	$ligne_ErrorDocument = 'ErrorDocument 404 '.str_replace('index.php','mod/'.$mod_folder.'/urlrewriting.php',$_SERVER['SCRIPT_NAME']);
	$erreur_copie_htaccess = '';
	$erreur_config_htaccess = '';

	// v�rif pour les r�install (si install faite manuellement, le fichier aura �t� renomm�, donc plus existant)
	if (file_exists($chemin_htaccess.'_mod_rewrite_OFF')) {
		// par d�faut (et ce qui devrait convenir � la majorit� des serveurs), solution avec le mod_rewrite � OFF
		if (!copy($chemin_htaccess.'_mod_rewrite_OFF',$chemin_htaccess))
			$erreur_copie_htaccess = 'La cr�ation du .htaccess a �chou�. Vous devez le faire manuellement :\ndans le dossier d\'OGSign, copiez le fichier \".htaccess_mod_rewrite_OFF\" et renommez-le en \".htaccess\"\n\n';

		// et configuration automatique de la ligne ErrorDocument 404 !
		// assurons nous que le fichier est accessible en �criture (si la copie a �chou�)
		if (is_writable($chemin_htaccess)) {
			// ouverture en mode "append" (�criture � la suite)
			if ($handle_htaccess = fopen($chemin_htaccess, 'a')) {
				if (fwrite($handle_htaccess, $ligne_ErrorDocument) === FALSE) {
				// et si �a n'a pas fonctionn�... � l'admin du serveur OGSpy de le faire � la main !
				$erreur_config_htaccess = 'La configuration du .htaccess n\'a pas fonctionn�.\n';
				$erreur_config_htaccess .= 'Ajoutez � la fin de ce fichier cette ligne :\n';
				$erreur_config_htaccess .= $ligne_ErrorDocument.'\n';
				$erreur_config_htaccess .= '(cela devrait correspondre au chemin complet depuis la racine du serveur)';
				}
			}
			fclose($handle_htaccess);
		}
	} else {
		// si l'install a �t� manuelle, le .htaccess existe d�j�... sinon, erreur !
		if (!file_exists($chemin_htaccess))
			$erreur_copie_htaccess = 'Il manque des fichiers.\nRefaites la configuration du .htaccess manuellement ou uploadez une nouvelle fois les fichiers d\'OGSign sur votre serveur.\n\n';
	}

	// et pour les �ventuels personnes ayant un mod_rewrite actif, on �crase le .htaccess si joliment r�alis�...
	if(version_compare(phpversion(), '4.3.2') >= 0) {
		// on v�rifie d'abord que la fonction d'Apache est d�finie (apparement, elle est d�sactiv�e chez certains h�bergeurs)
		$existing_functions = get_defined_functions();
		if (in_array('apache_get_modules',$existing_functions['internal'])) {
			// et ensuite on regarde dans la liste des modules Apache charg�s
			$apache_modules = apache_get_modules();
			if (in_array('mod_rewrite',$apache_modules)) {
				if (!copy($chemin_htaccess.'_mod_rewrite_ON',$chemin_htaccess))
					$erreur_copie_htaccess = 'La cr�ation du .htaccess a �chou�. Vous devez le faire manuellement :\ndans le dossier d\'OGSign, copiez le fichier \".htaccess_mod_rewrite_ON\" et renommez-le en \".htaccess\"';
			}
		}
	}

	// on "affiche" l'erreur...
	if ($erreur_copie_htaccess || $erreur_config_htaccess) {
		echo '<script language="JavaScript" type="text/javascript">alert("';
		if ($erreur_copie_htaccess)
			echo $erreur_copie_htaccess;
		if ($erreur_config_htaccess)
			echo $erreur_config_htaccess;
		echo '")</script>';
	}
}

?>
