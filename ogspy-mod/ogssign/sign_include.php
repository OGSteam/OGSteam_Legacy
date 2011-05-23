<?php
/**
* sign_include.php paramètres & fonctions de OGSign
* @package OGSign
* @author oXid_FoX
* @link http://www.ogsteam.fr
*/


if (!isset($table_prefix)) // pétage de cable à cause du global...
	global $table_prefix;

define('TABLE_USER_SIGN',$table_prefix.'user_sign');
define('TABLE_ALLY_SIGN',$table_prefix.'ally_sign');

// dossier du cache
define('DIR_SIGN_CACHE', 'mod/OGSign/cache/');

/**
 * protection des variables pour MySQL (gestion des guillemets)
 * provient du manuel PHP
 *
 * @param string $value valeur à protéger
 * @param bool $addquote ajouter ou non les quotes autour de la valeur
 * @return string chaine protégée
 */
function quote_smart($value,$addquote = TRUE) {
	// Stripslashes
	if (get_magic_quotes_gpc())
		$value = stripslashes($value);

	// Protection si ce n'est pas un entier ou pas une chaine à protéger
	if (!is_numeric($value) && $addquote)
		$value = "'" . mysql_real_escape_string($value) . "'";

	return $value;
}

/**
 * nettoyage des signatures
 *
 * @param string $typesign
 * @param string $nom_fichier
 */
function vide_sign_cache($typesign,$nom_fichier) {
	// on évite qu'il y ait des caractères bizarres
	$suppr = array('\\','"','/','|','*','?');
	$nom_fichier = str_replace($suppr,"",$nom_fichier);

	unset($liste_purge);
	if ($dhandle = opendir(DIR_SIGN_CACHE)) {
		while (false !== ($file = readdir($dhandle))) {
			if ($file == $nom_fichier.'.'.$typesign.'.png') {
				// on efface directement le fichier
				unlink(DIR_SIGN_CACHE.$file);
			}
		}
		closedir($dhandle);
	}
}

// Function vide cache pour ally
function vide_sign_cacheally($typesign,$nom_fichier) {
	// on évite qu'il y ait des caractères bizarres
	$suppr = array('\\','"','/','|','*','?');
	$nom_fichier = str_replace($suppr,"",$nom_fichier);

	unset($liste_purge);
	if ($dhandle = opendir(DIR_SIGN_CACHE)) {
		while (false !== ($file = readdir($dhandle))) {
			if ($file == $typesign.'.'.$nom_fichier.'.png') {
				// on efface directement le fichier
				unlink(DIR_SIGN_CACHE.$file);
			}
		}
		closedir($dhandle);
	}
}

/**
 * Escapes strings to be included in javascript
 *
 * @param string $s
 * @return string
 */
function jsspecialchars($s) {
	// ajout de ce petit replace car le masque ne prend pas correctement le double quote...
	$s = str_replace('"','&quot;',$s);

	return preg_replace('/([^ !#$%@()*+,-.\x30-\x5b\x5d-\x7e])/e',
		"'\\x'.(ord('\\1')<16? '0': '').dechex(ord('\\1'))",$s);
}

/**
 * fait la petite infobulle
 *
 * @param string $txt_contenu
 * @param string $titre
 * @param int $largeur
 * @return string
 */
function infobulle($txt_contenu, $titre = 'Aide', $largeur = 200) {
	// vérification de $largeur
	if (!is_numeric($largeur))
		$largeur = 200;

	$infobulle = '<img style="cursor: pointer;" title="" alt="tooltip" src="images/help_2.png" onMouseOver="this.T_WIDTH=210;this.T_TEMP=0;return escape(\'<table width=&quot;'
	.$largeur.'&quot;><tr><td align=&quot;center&quot; class=&quot;c&quot;>'
	.jsspecialchars($titre).'</td></tr><tr><th align=&quot;center&quot;>'.jsspecialchars($txt_contenu).'</th></tr></table>\')">';
	// retourne l'infobulle
	return $infobulle;
}

/**
 * fonction qui teste l'existence d'un fichier.
 * pas exactement identique à file_exists() car file_exists() met à jour la date de dernier accès (atime) et surtout est mise en cache (stat())
 *
 * @param string $fichier
 */
function file_really_exists($fichier = 'NULL') {
	$handle = @fopen($fichier, 'r');
	if ($handle === FALSE)
		return false;

	fclose($handle);
	return true;
}


/**
 * Fonction pour la génération des signatures
 * Dessine le texte, en fonction des tableaux donnés (qui permettent l'ombrage et/ou le détourage)
 * Si aucun tableau n'est donné, pas d'ombrage/détourage
 *
 * @param resource $image
 * @param int $font
 * @param int $x_cord
 * @param int $y_cord
 * @param string $text
 * @param int $color_text
 * @param int $color_contour
 * @param array $_x
 * @param array $_y
 */
function image_string_contour($image, $font, $x_cord, $y_cord, $text, $color_text, $color_contour = NULL, $_x = NULL, $_y = NULL)
{
	if (isset($color_contour) & isset($_x) & isset($_y)) {
		// dessin du contour du texte
		// les tableaux $_x et $_y contiennent en position [0] le nombre d'éléments (pour éviter de le recalculer ici à chaque appel)
		for($n=1;$n<=$_x[0];$n++) {
			imagestring($image, $font, $x_cord+$_x[$n], $y_cord+$_y[$n], $text, $color_contour);
		}
	}
	// écriture du texte
	imagestring($image, $font, $x_cord, $y_cord, $text, $color_text);
}

// variables de jeu

// note : le TAG de votre alliance est détecté automatiquement (pour les sign stats & prod des joueurs)

// numéro du fond par défaut.
// LE FICHIER DOIT EXISTER !!!
$fond_defaut_stats = 'stats7.png' ;	// (donc le fond "stats7.png")
$fond_defaut_prod = 'prod11.png' ;
$fond_defaut_ally = 'ally7.png' ;

// localisation du texte de la signature
$nom_l = 'Nom';
$uni_l = 'Univers';
$alli_l = 'TAG';
$mem_l = 'Membres';
$founder_l = 'Fondateur';
$place_l = 'Place';
$points_l = 'Points';
$points_mem_l = 'Points/Membres';
$vaiss_l = 'Vaisseaux';
$rech_l = 'Recherche';
$metal_l = 'Métal';
$cristal_l = 'Cristal';
$deut_l = 'Deutérium';
$heure_l = '/ Heure';
$jour_l = '/ Jour';
$semaine_l = '/ Semaine';
$prod_l = 'Production';

// extension de votre OGame
$tld = 'fr';

// vitesse de l'univers
$query = mysql_fetch_assoc(mysql_query("SELECT config_value FROM ".TABLE_CONFIG." WHERE `config_name`='speed_uni'"));
// pour les version d'OGSpy jusqu'à 3.04b, par défaut : 1
// pour l'uni 50 français qui est à vitesse *2, il faut donc mettre... 2 !
if (!$query["config_value"]) $query["config_value"] = 1;
define('VITESSE_UNI', $query["config_value"]);
?>
