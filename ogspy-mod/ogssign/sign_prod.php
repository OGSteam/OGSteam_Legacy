<?php 
/**
* sign_prod.php Créé une image avec les stats pour affichage dans un forum
* @package OGSign
* @author oXid_FoX
* @author CC30 <charles@cc30.net>
* @author Kal nightmare
* @link http://www.ogsteam.fr
* @link http://www.cc30.net
*	created	: 03/09/2006 22:26:34
*/


// vérification de sécurité
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
if (!defined('OGSIGN')) die('Hacking attempt');
require_once("../../includes/functions.php");
require_once("../../includes/ogame.php");
require_once("../../common.php");
init_serverconfig();
global $db;
$off_ingenieur = $user_data['off_ingenieur'];
$off_geologue = $user_data['off_geologue'];
$start = 101;
$nb_planet = $start + find_nb_planete_user() - 1;
$user_id = $param_sign['user_id'];	// pour la sign_prod
$nom_u = $param_sign['pseudo_ig'];
// on met le fond par défaut, si le fond demandé n'existe pas

if (file_exists('fonds/prod/'.$param_sign['nom_fond_prod']))
	$nom_fond = 'fonds/prod/'.$param_sign['nom_fond_prod'];
else
	$nom_fond = 'fonds/prod/'.$fond_defaut_prod;

// les paramètres vérifiés permettent de trouver le fond 
$fichier_stats = 'cache/'.$nom_player.'.P.png';
		
// aucun moyen de savoir si il y a eu MAJ des données dans Empire...
// donc si filemtime($fichier_stats) + 48h > date actuelle, on va regénérer l'image
if (!file_exists($fichier_stats) || filemtime($fichier_stats)+48*3600 < time()) {
	// le séparateur de milliers pour l'affichage des grands nombres
	$sepa_milliers = $param_sign['sepa_milliers_prod'];
	// transformation de l'espace
	if ($sepa_milliers == 's') $sepa_milliers = ' ';

	// on cherche les coordonnées dans la partie "Espace personnel > Empire" du joueur (puisqu'on est sûr qu'il y a des planètes)
	$quet = mysql_query('SELECT coordinates FROM '.TABLE_USER_BUILDING.' WHERE coordinates <> \'\' and user_id = '.$user_id.' LIMIT 1');
	$result = mysql_fetch_array($quet,MYSQL_ASSOC);
	$coords = $result['coordinates'];

	$coords = explode(':',$coords);
	
	// enfin, d'après ces coords, on trouve l'ally du joueur
	$quet = mysql_query('SELECT ally FROM '.TABLE_UNIVERSE.' WHERE galaxy = '.$coords[0].' and system = '.$coords[1].' and row = '.$coords[2]);
	$result = mysql_fetch_array($quet,MYSQL_ASSOC);
	$alli_u = $result['ally']; // pour garder une certaine compatibilité avec la partie création image...

	// Récupération des informations sur les mines
	$planet = array(false, 'temperature_min' => '', 'temperature_max' => '', 'Sat' => '',
	'M' => 0, 'C' => 0, 'D' => 0, 'CES' => 0, 'CEF' => 0 ,
	'M_percentage' => 0, 'C_percentage' => 0, 'D_percentage' => 0, 'CES_percentage' => 100, 'CEF_percentage' => 100, 'Sat_percentage' => 100);

	$quet = mysql_query('SELECT planet_id, temperature_min, temperature_max, Sat, M, C, D, CES, CEF, M_percentage, C_percentage, D_percentage, CES_percentage, CEF_percentage, Sat_percentage FROM '.TABLE_USER_BUILDING.' WHERE user_id = '.$user_id.' ORDER BY planet_id');

	$user_building = array_fill($start, $nb_planet, $planet);
	while ($row = mysql_fetch_assoc($quet)) {
		$user_building[$row['planet_id']] = $row;
		$user_building[$row['planet_id']][0] = true;

		}

// Récupération des informations sur les technologies
	$query = mysql_fetch_assoc(mysql_query("SELECT `NRJ` FROM ".TABLE_USER_TECHNOLOGY." WHERE `user_id` = ".$user_id));
	$NRJ = $query['NRJ'];



	// calcul des productions
	$metal_heure=0;
	$cristal_heure=0;
	$deut_heure=0;
	$metal_jour = 0;
	$cristal_jour = 0;
	$deut_jour = 0;
	for ($i=$start; $i<=$nb_planet; $i++) {
		// si la planète existe, on calcule la prod de ressources
		if ($user_building[$i][0] === TRUE) {

			$M = $user_building[$i]['M'];
			$C = $user_building[$i]['C'];
			$D = $user_building[$i]['D'];
			$CES = $user_building[$i]['CES'];
			$CEF = $user_building[$i]['CEF'];
			$SAT = $user_building[$i]['Sat'];
			$M_per = $user_building[$i]['M_percentage'];
			$C_per = $user_building[$i]['C_percentage'];
			$D_per = $user_building[$i]['D_percentage'];
			$CES_per = $user_building[$i]['CES_percentage'];
			$CEF_per = $user_building[$i]['CEF_percentage'];
			$SAT_per = $user_building[$i]['Sat_percentage'];
			$temperature_min = $user_building[$i]['temperature_min'];
			$temperature_max = $user_building[$i]['temperature_max'];
			$production_CES = ( $CES_per / 100 ) * ( production ( "CES", $CES, $off_ingenieur ));
			$production_CEF = ( $CEF_per / 100 ) * ( production ("CEF", $off_ingenieur ));
			$production_SAT = ( $SAT_per / 100 ) * ( production_sat ( $temperature_min, $temperature_max, $off_ingenieur ) * $SAT );
			$prod_energie = $production_CES + $production_CEF + $production_SAT;
			
			//Consommation
			$consommation_M = ( $M_per / 100 ) * ( consumption ( "M", $M ));
			$consommation_C = ( $C_per / 100 ) * ( consumption ( "C", $C ));
			$consommation_D = ( $D_per / 100 ) * ( consumption ( "D", $D ));
			$cons_energie = $consommation_M + $consommation_C + $consommation_D;
				
			if ($cons_energie == 0) $cons_energie = 1;
			$ratio = floor(($prod_energie/$cons_energie)*100)/100;
			if ($ratio > 1) $ratio = 1;

			// calcul de la production horaire
			$metal_heure = $metal_heure + ( 20 + round (($M_per/100) * $ratio * ( production ( "M", $M, $off_geologue ))));
			$cristal_heure = $cristal_heure + ( 10 + round (( $C_per/100 ) * $ratio * ( production ( "C", $C, $off_geologue ))));
			$deut_heure = $deut_heure  + (( round (( $D_per/100) * $ratio * ( production ( "D", $D, $off_geologue, $temperature_max )))) -  consumption ("CEF", $CEF));
		}
	}

switch($param_sign['frequence_prod']) {
	case 2 : // journalière et hebdomadaire
		$metal_f1 = 24 * $metal_heure;
		$cristal_f1 = 24 * $cristal_heure;
		$deut_f1 = 24 * $deut_heure;
		$metal_f2 = 24 * 7 * $metal_heure;
		$cristal_f2 = 24 * 7 * $cristal_heure;
		$deut_f2 = 24 * 7 * $deut_heure;
		$freq1 = $jour_l;
		$freq2 = $semaine_l;
	break;

	case 3 : // horaire et hebdomadaire
		$metal_f1 = $metal_heure;
		$cristal_f1 = $cristal_heure;
		$deut_f1 = $deut_heure;
		$metal_f2 = 24 * 7 * $metal_heure;
		$cristal_f2 = 24 * 7 * $cristal_heure;
		$deut_f2 = 24 * 7 * $deut_heure;
		$freq1 = $heure_l;
		$freq2 = $semaine_l;	break;

	// le cas 1 (horaire et journalière), sera celui par défaut (si la valeur dans la base est incorrecte/absente)
	default :
		$metal_f1 = $metal_heure;
		$cristal_f1 = $cristal_heure;
		$deut_f1 = $deut_heure;
		$metal_f2 = 24 * $metal_heure;
		$cristal_f2 = 24 * $cristal_heure;
		$deut_f2 = 24 * $deut_heure;
		$freq1 = $heure_l;
		$freq2 = $jour_l;
}

	// le fond choisi pour la signature
	$image = imagecreatefrompng($nom_fond);

	// Référencement des couleurs utilisées pour le texte
	$blanc = imagecolorallocate($image, 255, 255, 255);
	$noir = imagecolorallocate($image, 0, 0, 0);
	$rouge = imagecolorallocate($image, 255, 0, 0);
	$vert = imagecolorallocate($image, 0, 150, 0);
	$bleu = imagecolorallocate($image, 0, 0, 255);
	$gris = imagecolorallocate($image, 130, 130, 130);
	$grisF = imagecolorallocate($image, 216, 216, 216);
	// couleur du texte choisie par l'utilisateur
	if (strlen($param_sign['couleur_txt_prod'])==6) { // pour le code hexa à 6 chiffres
		$couleur_txt_R = hexdec(substr($param_sign['couleur_txt_prod'], 0, 2));
		$couleur_txt_V = hexdec(substr($param_sign['couleur_txt_prod'], 2, 2));
		$couleur_txt_B = hexdec(substr($param_sign['couleur_txt_prod'], 4, 2));
	} elseif (strlen($param_sign['couleur_txt_prod'])==3) { // pour le code hexa à 3 chiffres
		$couleur_txt_R = hexdec(substr($param_sign['couleur_txt_prod'], 0, 1))*16-1;
		$couleur_txt_V = hexdec(substr($param_sign['couleur_txt_prod'], 1, 1))*16-1;
		$couleur_txt_B = hexdec(substr($param_sign['couleur_txt_prod'], 2, 1))*16-1;
	} else {	// noir par défaut
		$couleur_txt_R = $couleur_txt_V = $couleur_txt_B = '0';
	}
	$couleur_perso_txt = imagecolorallocate($image, $couleur_txt_R, $couleur_txt_V, $couleur_txt_B);

	// 2è couleur de texte choisie par l'utilisateur
	if (strlen($param_sign['couleur_txt_var_prod'])==6) { // pour le code hexa à 6 chiffres
		$couleur_txt_R = hexdec(substr($param_sign['couleur_txt_var_prod'], 0, 2));
		$couleur_txt_V = hexdec(substr($param_sign['couleur_txt_var_prod'], 2, 2));
		$couleur_txt_B = hexdec(substr($param_sign['couleur_txt_var_prod'], 4, 2));
	} elseif (strlen($param_sign['couleur_txt_var_prod'])==3) { // pour le code hexa à 3 chiffres
		$couleur_txt_R = hexdec(substr($param_sign['couleur_txt_var_prod'], 0, 1))*16-1;
		$couleur_txt_V = hexdec(substr($param_sign['couleur_txt_var_prod'], 1, 1))*16-1;
		$couleur_txt_B = hexdec(substr($param_sign['couleur_txt_var_prod'], 2, 1))*16-1;
	} else {	// noir par défaut
		$couleur_txt_R = $couleur_txt_V = $couleur_txt_B = '0';
	}
	$couleur_perso_txtvar = imagecolorallocate($image, $couleur_txt_R, $couleur_txt_V, $couleur_txt_B);

	// couleur de contour du texte choisie par l'utilisateur
	if (strlen($param_sign['couleur_style_txt_prod'])==6) {
		$couleur_txt_R = hexdec(substr($param_sign['couleur_style_txt_prod'], 0, 2));
		$couleur_txt_V = hexdec(substr($param_sign['couleur_style_txt_prod'], 2, 2));
		$couleur_txt_B = hexdec(substr($param_sign['couleur_style_txt_prod'], 4, 2));
	} elseif (strlen($param_sign['couleur_style_txt_prod'])==3) {
		$couleur_txt_R = hexdec(substr($param_sign['couleur_style_txt_prod'], 0, 1))*16-1;
		$couleur_txt_V = hexdec(substr($param_sign['couleur_style_txt_prod'], 1, 1))*16-1;
		$couleur_txt_B = hexdec(substr($param_sign['couleur_style_txt_prod'], 2, 1))*16-1;
	} else {
		$couleur_txt_R = $couleur_txt_V = $couleur_txt_B = '0';
	}
	$couleur_perso_styletxt = imagecolorallocate($image, $couleur_txt_R, $couleur_txt_V, $couleur_txt_B);

	// CREATION DE L'IMAGE
	// Début de l'écriture

	// arrays de positionnements de l'ombre ou du contour (ou de rien du tout, dans ce cas, on conserve NULL)
	$_x = NULL;
	$_y = NULL;

	// Détourage du texte
	// positions pour le contour
	if ($param_sign['style_texte_prod'] == 'd') {
		$_x = array(8, 1, 0, 1, -1, -1, 1, 0, -1);
		$_y = array(8, 0, -1, -1, 0, -1, 1, 1, 1);
	}

	// Ombrage des textes fixes
	// positions pour l'ombre
	if ($param_sign['style_texte_prod'] == 'o') {
		$_x = array(1, 1);
		$_y = array(1, 1);
	}

	// Gestion des textes fixes

	// Zone d'identification

	image_string_contour($image, 2, 5, 18, $nom_l.' : ', $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 229, 18, $uni_l.' : ', $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 5, 29, $alli_l.' : ', $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 229, 29, 'ogame.'.$tld, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);

	// Tableau

		// production/heure, production/jour
	image_string_contour($image, 2, 260, 60, $freq1, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 260, 75, $freq2, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);

	// texte metal, cristal, deut
	image_string_contour($image, 2, 5, 45, $metal_l, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 90, 45, $cristal_l, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 176, 45, $deut_l, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);

	// suppression des ombrages pour le reste (textes "variables")
	if ($param_sign['style_texte_prod'] == 'o') {
		$_x = NULL;
		$_y = NULL;
	}

	// Zone d'identification

	image_string_contour($image, 2, 41, 18, $nom_u, $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 290, 18, $uni_u, $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 41, 29, $alli_u, $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);

	// Tableau

	// "production"
	image_string_contour($image, 1, 260, 48, $prod_l, $gris, $grisF, $_x, $_y);

	// prod/heure
	image_string_contour($image, 2, 5, 60, number_format($metal_f1, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 90, 60, number_format($cristal_f1, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 176, 60, number_format($deut_f1, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);


	// prod/jour
	image_string_contour($image, 2, 5, 75, number_format($metal_f2, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 90, 75, number_format($cristal_f2, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 176, 75, number_format($deut_f2, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);

	// Création de l'image, si les headers n'ont pas déjà été envoyés... si c'est le cas, il y a eu des erreurs...
	if (!headers_sent())
		imagepng($image,$fichier_stats);

	// Libération des ressources
	imagedestroy($image);

	// nettoyage du cache sur les fichiers
	// (date de création changée, et on veut en être sûr, pour pas recréer l'img pour rien)
	clearstatcache();

} // endif (test sur la date de création de la sign des productions)

?>
