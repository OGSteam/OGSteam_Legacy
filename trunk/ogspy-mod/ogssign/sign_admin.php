<?php
/**
* sign_admin.php administration d'OGSign
* @package OGSign
* @author oXid_FoX
* @link http://www.ogsteam.fr
*
*/


// vérification de sécurité
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

// vérification des droits
if ($user_data['user_admin'] != 1 && $user_data['user_coadmin'] != 1) {
	redirection('index.php?action=message&id_message=forbidden&info');
}

// MAJ du numéro d'univers
if (!empty($pub_univers) && ($pub_univers)) {
	$query = 'UPDATE `'.TABLE_CONFIG.'` SET `config_value` = \''.$pub_univers.'\' WHERE `config_name` = \'univers\'';
	$db->sql_query($query);
}

// liste tous les fonds (obligatoirement des PNG)
unset($liste_fonds);
$nb_sign_en_cache = 0;
// @ pour éviter le E_WARNING si le cache n'existe pas.
if ($dh = @opendir(DIR_SIGN_CACHE)) {
	while (($nom_fichier = readdir($dh)) !== false) {
		if (preg_match('/.png/',$nom_fichier)) {
			$liste_fonds[] = $nom_fichier;
			$nb_sign_en_cache++;
		}
	}
	closedir($dh);
}
if ($nb_sign_en_cache > 1) $nb_sign_en_cache .= ' signatures en cache'; else $nb_sign_en_cache .= ' signature en cache';

// les différentes actions
if (isset($pub_quoifaire)) {

	switch ($pub_quoifaire) {

	// vidage du cache
	case 'Vider':
		$i = 0;
		while ($i < count($liste_fonds))
		{
			unlink(DIR_SIGN_CACHE.$liste_fonds[$i]);
			$i++;
		}
		// on affiche qu'il s'est bien passé qqch, et on le loggue
		$i = count($liste_fonds);
		if ($i < 2) $nb_sign_en_cache = $i.' fichier supprimé';
		else $nb_sign_en_cache = $i.' fichiers supprimés';
		log_('debug','OGSign : vidage du cache par '.$user_data['user_name'].'. '.$nb_sign_en_cache);
		break;

	// suppression dans la base des signatures alliances & joueurs
	case 'Supprimer':
		// sign alliance
		if (isset($pub_ally_id) && is_numeric($pub_ally_id)) {
			// suppression dans la base
			$query = 'DELETE FROM `'.TABLE_ALLY_SIGN.'` WHERE `ally_id` = \''.$pub_ally_id.'\'';
			$db->sql_query($query);

			// suppression du fichier
			vide_sign_cache('A',$pub_TAG);
			// inscription dans le log
			log_('debug','OGSign : suppression de la signature d\'alliance "'.$pub_TAG.'" par '.$user_data['user_name']);
		}

		// sign joueur
		if (isset($pub_user_id) && is_numeric($pub_user_id)) {
			// suppression dans la base
			$query = 'DELETE FROM `'.TABLE_USER_SIGN.'` WHERE `user_id` = \''.$pub_user_id.'\'';
			$db->sql_query($query);

			// suppression des fichiers
			vide_sign_cache('S',$pub_pseudo_ig);
			vide_sign_cache('P',$pub_pseudo_ig);
			// inscription dans le log
			log_('debug','OGSign : suppression de la signature de joueur "'.$pub_pseudo_ig.'" par '.$user_data['user_name']);
		}
		break;

	// conservation des données après désinstall
	case 'Valider':
		if (isset($pub_keepogsigndata)) {
		  // création du "marqueur" pour garder les données
			@fclose(fopen(DIR_SIGN_CACHE.'keep_ogsign_datas','w'));
		} else {
			if (file_really_exists(DIR_SIGN_CACHE.'keep_ogsign_datas'))
			  unlink(DIR_SIGN_CACHE.'keep_ogsign_datas');
		}
		break;

	}
}

echo 	'<table align="center" width="100%" cellpadding="0" cellspacing="1">';

// si on est en mode "test du module", on ne raffiche pas tout...
if (!isset($pub_quoifaire) || $pub_quoifaire <> 'Tester le module') {

	// sélection du numéro d'univers
	$query = 'SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name` = \'univers\'';
	$result = $db->sql_query($query);
	$num_uni = $db->sql_fetch_row($result);

	// recherche des paramètres de la signature ALLY
	$query = 'SELECT `ally_id`, `TAG` FROM `'.TABLE_ALLY_SIGN.'` ORDER BY `TAG` ASC';
	$result_ally = $db->sql_query($query);

	// recherche des paramètres de la signature USER
	$query = 'SELECT `user_id`, `pseudo_ig` FROM `'.TABLE_USER_SIGN.'` ORDER BY `pseudo_ig` ASC';
	$result_user = $db->sql_query($query);

	// début de l'adresse des signatures
	$debut_full_url_sign = str_replace(' ','%20','http://'.substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],0, strlen($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'])-9)) . 'mod/OGSign/';
	?>

	<!-- UNIVERS -->
		<tr><td class="c" colspan="2">Choix de l'univers</td></tr>
		<tr>
			<th>Numéro de votre univers</th>
			<th width="170"><form method="POST" action=""><input type="text" name="univers" size="10" maxlength="15" value="<?php echo $num_uni[0]; ?>" style="text-align: center;">
			<input type="submit" value="Changer l'univers"></form></th>
		</tr>

	<!-- CONSERVATION DES TABLES -->
		<tr><td class="c" colspan="2">Conservation des données</td></tr>
		<tr>
			<th>Lorsqu'activée, cette option permet de conserver les paramètres d'OGSign (toutes les signatures dans la base de données et le .htaccess configuré) après désinstallation.<br />
			Cela impose que le dossier du mod ne doit PAS être supprimé !</th>
			<th><form method="POST" action=""><input type="checkbox" name="keepogsigndata" style="text-align: center; vertical-align: middle;" <?php
			if (file_really_exists(DIR_SIGN_CACHE.'keep_ogsign_datas'))
				echo 'checked="checked"'; ?>>
			<input type="submit" name="quoifaire" value="Valider"></form></th>
		</tr>

	<!-- VIDAGE DU CACHE -->
		<tr><td class="c" colspan="2">Vider le cache (<?php echo $nb_sign_en_cache; ?>)</td></tr>
		<tr><th>Pour vider le cache, appuyez sur le bouton "Vider". Tous les fichiers du cache seront supprimés
		<?php infobulle('Les signatures qui sont configurées pour les alliances et les joueurs vont se régénérer immédiatement. Cela explique pourquoi il reste des signatures en cache même après l\'avoir vidé.'); ?>

		, mais les signatures resteront configurées dans la base de données (donc sans risques pour les utilisateurs) !<br />
		Cela peut résoudre des problèmes de mise à jour des signatures.</th>
		<th><form method="POST" action=""><input type="submit" name="quoifaire" value="Vider"></form></th></tr>

	<!-- LISTE DES SIGNATURES D'ALLIANCE -->
		<tr><td class="c" colspan="2">Signatures d'alliance configurées</td></tr><?php

	if ($db->sql_numrows($result_ally) == 0) {
		echo "\t",'<tr><th colspan="2">Aucune signature d\'alliance configurée.</th></tr>';

	} else {
		// Tant qu'une ligne existe, il y a une signature configurée
		while ($param_sign_ally = $db->sql_fetch_assoc($result_ally)) {
			echo "\n\t<tr>\n\t\t",'<th style="-moz-opacity: 1; filter: alpha(opacity=100); /*suppression de la transparence éventuelle*/">'
			// donc on affiche les signatures en question
			,"\n\t\t",'<img src="mod/OGSign/',$param_sign_ally['ally_id'],'.A.png" alt="signature de l\'alliance ',$param_sign_ally['TAG'],'" title="',$param_sign_ally['TAG'],'"><br />'
			// réaffichage de l'adresse
			,"\n\t\t",'<input type="text" value="',$debut_full_url_sign,$param_sign_ally['ally_id'],'.A.png" size="70" readonly="readonly" onClick="this.focus(); this.select();" style="text-align: center;"></th>'
			// et on propose de les supprimer
			,"\n\t\t",'<th><form method="POST" action=""><input type="hidden" name="ally_id" value="',$param_sign_ally['ally_id'],'"><input type="hidden" name="TAG" value="',$param_sign_ally['TAG'],'">'
			,"\n\t\t",'<input type="submit" name="quoifaire" value="Supprimer"></form><br />'
			,"\n\t\t",'<form method="POST" action="index.php?action=ogsign&subaction=ally"><input type="hidden" name="ally_l" value="',$param_sign_ally['TAG'],'">'
			,'<input type="submit" name="quoifaire" value="Modifier"></form></th>'
			,"\n\t",'</tr>';
		}
	}

	?>


	<!-- LISTE DES SIGNATURES DE JOUEURS -->
		<tr><td class="c" colspan="2">Signatures de joueurs <?php
	infobulle('Seules les signatures stats sont affichées, les signatures production ne le sont pas (pour éviter de surcharger l\'affichage inutilement).');
	echo '</td></tr>';

	if ($db->sql_numrows($result_user) == 0) {
		echo "\t",'<tr><th colspan="2">Aucun joueur n\'a configuré sa signature.</th></tr>';

	} else {
		// Tant qu'une ligne existe, il y a une signature configurée
		while ($param_sign_user = $db->sql_fetch_assoc($result_user)) {
			echo "\n\t",'<tr>',"\n\t\t",'<th style="-moz-opacity: 1; filter: alpha(opacity=100); /*suppression de la transparence éventuelle*/">'
			// donc on affiche les signatures en question
			,"\n\t\t",'<img src="mod/OGSign/',$param_sign_user['pseudo_ig'],'.png" alt="signature du joueur ',$param_sign_user['pseudo_ig'],'" title="',$param_sign_user['pseudo_ig'],'"><br />'
			// réaffichage de l'adresse
			,"\n\t\t",'<input type="text" value="',$debut_full_url_sign,$param_sign_user['pseudo_ig'],'.png" size="70" readonly="readonly" onClick="this.focus(); this.select();" style="text-align: center;"></th>'
			// et on propose de les supprimer
			,"\n\t\t",'<th><form method="POST" action=""><input type="hidden" name="user_id" value="',$param_sign_user['user_id'],'">'
			,'<input type="hidden" name="pseudo_ig" value="',$param_sign_user['pseudo_ig'],'">'
			,"\n\t\t",'<input type="submit" name="quoifaire" value="Supprimer"></form><br /></th>'
			,"\n\t",'</tr>';
		}
	}
} // fin de l'affichage du contenu de la page par défaut
?>


<!-- INTEGRITE DU MODULE -->
	<?php

// et là, si on est en mode "test du module"
if (isset($pub_quoifaire) && $pub_quoifaire == 'Tester le module') {

	$problem = FALSE;
	$check_ok = '<span style="color: lime; font-weight: bold;">OK</span>';
	$check_err = '<span style="color: red; font-weight: bold;">ECHEC</span>';

	// infos du serveur
	echo '<tr><td class="c" colspan="2">Info du serveur (global)</td></tr>',"\n",'<tr><th colspan="2">'
	,'HTTP_HOST : ',$_SERVER['HTTP_HOST'],'<br />SERVER_NAME : ',$_SERVER['SERVER_NAME'],'<br /><br />phpversion : ',phpversion()
	,"<br /><br />\nmysql_get_client_info : ",mysql_get_client_info(),'<br />mysql_get_server_info : ',mysql_get_server_info()
	,"\n\t</th></tr>\n\t";

	// vérification de la version de la lib GD
	echo '<tr><td class="c" colspan="2">Génération des images (global)</td></tr>',"\n",'<tr><th colspan="2">';
	echo '<img src="mod/OGSign/testgd.php" width="36" height="36" alt="image de test" title="image de test">';
	echo "\n",infobulle('Vous devez voir une image avec écrit "OK" dedans.'),'<br />';
	// note : gd_info() ne fonctionne que PHP 4 >= 4.3.0		(voir si OGSpy ne fonctionne pas avec un PHP inférieur)
	if(function_exists("gd_info")) $composants_gd = gd_info();
	if ($composants_gd['GD Version']) {
		echo 'GD Version : ',$composants_gd['GD Version'],'<br />';

		// vérification du support des PNG
		if ($composants_gd['PNG Support']) {
			echo 'Support des PNG activé !<br />';
		}
	} else {
		echo '<span style="color: red; font-weight: bold;">La librairie GD n\'est pas activée ! OGSign ne pourra pas fonctionner !</span>';
	}

	// variables générales d'OGSign
	echo '<tr><td class="c" colspan="2">Variables (OGSign)</td></tr>',"\n",'<tr><th colspan="2">'
	,'Version installée : ',$ogsign_version
	,'<br /><br />$table_prefix : ',$table_prefix
	,'<br />TABLE_USER_SIGN : ',TABLE_USER_SIGN
	,'<br />TABLE_ALLY_SIGN : ',TABLE_ALLY_SIGN
	,'<br /><br />DIR_SIGN_CACHE : ',DIR_SIGN_CACHE
	,"\n\t</th></tr>\n\t";

	// présence de la table TABLE_USER_SIGN
	echo "\n\t</th></tr>\n\t",'<tr><td class="c" colspan="2">Etat de la base de données (OGSign)</td></tr>',"\n",'<tr><th colspan="2">'
	,TABLE_USER_SIGN,' : ';
	$db->sql_query('INSERT INTO `'.TABLE_USER_SIGN.'` (`user_id`, `pseudo_ig`, `nom_fond_stats`, `couleur_txt_stats`, `couleur_txt_var_stats`, `sign_stats_active`, `sepa_milliers_stats`, `style_texte_stats`, `couleur_style_txt_stats`, `nom_fond_prod`, `couleur_txt_prod`, `couleur_txt_var_prod`, `sign_prod_active`, `sepa_milliers_prod`, `style_texte_prod`, `couleur_style_txt_prod`)'
	.' VALUES (\'999999\', \'test_test_test\', \'stats7.png\', \'123ABC\', \'123ABC\', \'1\', \'s\', \'d\', \'123ABC\', \'prod11.png\', \'123ABC\', \'123ABC\', \'1\', \'p\', \'o\', \'123ABC\')');
	echo 'INSERT (',$db->sql_affectedrows(),') / ';
	$db->sql_query('DELETE FROM `'.TABLE_USER_SIGN.'` WHERE `user_id` = 999999 AND `pseudo_ig` = \'test_test_test\'');
	echo 'DELETE (',$db->sql_affectedrows(),') : ';
	if ($db->sql_affectedrows() == 1) echo $check_ok,"\n<br />"; else { echo $check_err,"\n<br />"; $problem = TRUE; }

	// et présence de la table TABLE_ALLY_SIGN
	$query = 'SELECT `ally_id`, `TAG`, `nom_ally`, `founder_ally`, `nom_fond`, `couleur_txt`, `couleur_txt_var`, `sign_active`, `sepa_milliers`, `style_texte`, `couleur_style_txt` FROM `'.TABLE_ALLY_SIGN.'` WHERE 1 LIMIT 1';
	$db->sql_query($query);
	echo TABLE_ALLY_SIGN,' : SELECT : ',$check_ok,"\n<br />";

	// présence du paramètre de config de l'uni
	$db->sql_query('SELECT `config_value` FROM `'.TABLE_CONFIG.'` WHERE `config_name` = \'univers\'');
	if ($db->sql_numrows() != 0)
		echo TABLE_CONFIG,' > univers : ',$check_ok,'<br />';
	else {
		echo TABLE_CONFIG,' > univers : ',$check_err,'<br />';
		$problem = TRUE;
	}
	if (!$problem)
		echo "\n",'~<br />Base de données OGSign <span style="color: lime; font-weight: bold;">opérationnelle</span> !';
	else
		echo "\n",'~<br />Base de données OGSign <span style="color: red; font-weight: bold;">incomplète</span>.<br />'
		,'<span style="color: red; font-weight: bold;">Désinstallez et réinstallez OGSign.<br />Si cela ne suffit pas, désinstallez OGSign, envoyez à nouveau les fichiers sur le serveur, et réinstallez OGSign.</span>';

	echo "\n\t</th></tr>\n\t",'<tr><td class="c" colspan="2">Cache d\'OGSign</td></tr>',"\n",'<tr><th colspan="2">';
	// présence du dossier "cache"
	echo 'Cache accessible en lecture : ';
	if ($h_cache=@opendir(DIR_SIGN_CACHE)) {
		echo $check_ok,"<br />\n";
		closedir($h_cache);

		// et si présent, on vérifie qu'il puisse être écrit
		echo 'Cache accessible en écriture : ';
		if (@fopen(DIR_SIGN_CACHE.'/test','w')) {
			echo $check_ok,"<br />\n";

			// et on vérifie la suppression (il faut supprimer le fichier créé, et autant l'afficher)
			echo 'Cache accessible en suppression : ';
			if (@unlink(DIR_SIGN_CACHE.'/test') === TRUE) echo $check_ok;
			else echo $check_err,"<br />\n"
			,'<span style="color: red; font-weight: bold;">Ajoutez les permissions d\'écriture au dossier "cache" dans le dossier d\'OGSign.</span>';

		} else {
			echo $check_err,"<br />\n"
			,'<span style="color: red; font-weight: bold;">Ajoutez les permissions d\'écriture au dossier "cache" dans le dossier d\'OGSign.</span>';
		}

	} else {
		echo $check_err," (inexistant)<br />\n"
		,'<span style="color: red; font-weight: bold;">Créez le dossier "cache" dans le dossier d\'OGSign.</span>';
	}

	echo "\n\t</th></tr>\n\t",'<tr><td class="c" colspan="2">&nbsp;</td></tr>',"\n",'<tr><th colspan="2">';
	echo '<a href="index.php?action=ogsign&subaction=admin">Retour à l\'administration</a>';

// fin de la partie de test du module
} else {
	// de quoi accéder au test
	echo '<tr><td class="c" colspan="2">Etat du module</td></tr><tr><th colspan="2">',
	'Ce test affiche un certain nombre d\'informations, qui permettent de vérifier le bon fonctionnement du mod OGSign.<br />'
	,"\n",'<form method="POST" action=""><input type="submit" name="quoifaire" value="Tester le module"></form>';
}

?></th></tr>

</table>
