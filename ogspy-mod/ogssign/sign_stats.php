<?php 
/**
* sign_stats.php Créé une image avec les stats pour affichage dans un forum
* @package OGSign
* @author oXid_FoX
* @author CC30 <charles@cc30.net>
* @link http://www.ogsteam.fr
* @link http://www.cc30.net
*/


// vérification de sécurité
if (!defined('OGSIGN'))	die('Hacking attempt');

// on met le fond par défaut, si le fond demandé n'existe pas
if (file_exists('fonds/stats/'.$param_sign['nom_fond_stats']))
	$nom_fond = 'fonds/stats/'.$param_sign['nom_fond_stats'];
else
	$nom_fond = 'fonds/stats/'.$fond_defaut_stats;

// les paramètres vérifiés permettent de trouver le fond 
$fichier_stats = 'cache/'.$nom_player.'.S.png';

$nom_u = $nom_player; // pour garder une certaine compatibilité avec la partie création image...
$alli_u = '';

$critere_requete = '';
if ($param_sign['stats_detection_system'] == 1)
	$critere_requete = ' WHERE player = '.$nom_player_protege;

// pour la vérification de date, on va chercher les dates des 3 classements
$quet = mysql_query('SELECT max(datadate) as d FROM '.TABLE_RANK_PLAYER_POINTS.$critere_requete);
$result = mysql_fetch_array($quet,MYSQL_ASSOC);
$derniere_point_stats = $result['d'];

$quet = mysql_query('SELECT max(datadate) as d FROM '.TABLE_RANK_PLAYER_FLEET.$critere_requete);
$result = mysql_fetch_array($quet,MYSQL_ASSOC);
$derniere_fleet_stats = $result['d'];

$quet = mysql_query('SELECT max(datadate) as d FROM '.TABLE_RANK_PLAYER_RESEARCH.$critere_requete);
$result = mysql_fetch_array($quet,MYSQL_ASSOC);
$derniere_research_stats = $result['d'];

$date_derniere_maj = max($derniere_point_stats, $derniere_fleet_stats, $derniere_research_stats);

// filemtime() renvoie un timestamp, au même format que DATADATE ... ça tombe bien, on va pouvoir les comparer !
// et si $date_derniere_maj > filemtime($fichier_stats), il faut regénérer l'image
// et on attend que le classement ne puisse plus être récupéré sur OGame
// par exemple, on va attendre 16h pour faire la MAJ de l'image avec le classement de 8h
if (!file_exists($fichier_stats) || ( $date_derniere_maj > filemtime($fichier_stats) && ($date_derniere_maj+(8*3600))<time() )) {

	// le séparateur de milliers pour l'affichage des grands nombres
	$sepa_milliers = $param_sign['sepa_milliers_stats'];
	// transformation de l'espace
	if ($sepa_milliers == 's') $sepa_milliers = ' ';

	//le fond choisi pour la signature
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
	if (strlen($param_sign['couleur_txt_stats'])==6) {
		$couleur_txt_R = hexdec(substr($param_sign['couleur_txt_stats'], 0, 2));
		$couleur_txt_V = hexdec(substr($param_sign['couleur_txt_stats'], 2, 2));
		$couleur_txt_B = hexdec(substr($param_sign['couleur_txt_stats'], 4, 2));
	} elseif (strlen($param_sign['couleur_txt_stats'])==3) {
		$couleur_txt_R = hexdec(substr($param_sign['couleur_txt_stats'], 0, 1))*16-1;
		$couleur_txt_V = hexdec(substr($param_sign['couleur_txt_stats'], 1, 1))*16-1;
		$couleur_txt_B = hexdec(substr($param_sign['couleur_txt_stats'], 2, 1))*16-1;
	} else {
		$couleur_txt_R = $couleur_txt_V = $couleur_txt_B = '0';
	}
	$couleur_perso_txt = imagecolorallocate($image, $couleur_txt_R, $couleur_txt_V, $couleur_txt_B);

	// 2è couleur de texte choisie par l'utilisateur
	if (strlen($param_sign['couleur_txt_var_stats'])==6) {
		$couleur_txt_R = hexdec(substr($param_sign['couleur_txt_var_stats'], 0, 2));
		$couleur_txt_V = hexdec(substr($param_sign['couleur_txt_var_stats'], 2, 2));
		$couleur_txt_B = hexdec(substr($param_sign['couleur_txt_var_stats'], 4, 2));
	} elseif (strlen($param_sign['couleur_txt_var_stats'])==3) {
		$couleur_txt_R = hexdec(substr($param_sign['couleur_txt_var_stats'], 0, 1))*16-1;
		$couleur_txt_V = hexdec(substr($param_sign['couleur_txt_var_stats'], 1, 1))*16-1;
		$couleur_txt_B = hexdec(substr($param_sign['couleur_txt_var_stats'], 2, 1))*16-1;
	} else {
		$couleur_txt_R = $couleur_txt_V = $couleur_txt_B = '0';
	}
	$couleur_perso_txtvar = imagecolorallocate($image, $couleur_txt_R, $couleur_txt_V, $couleur_txt_B);

	// couleur de contour du texte choisie par l'utilisateur
	if (strlen($param_sign['couleur_style_txt_stats'])==6) {
		$couleur_txt_R = hexdec(substr($param_sign['couleur_style_txt_stats'], 0, 2));
		$couleur_txt_V = hexdec(substr($param_sign['couleur_style_txt_stats'], 2, 2));
		$couleur_txt_B = hexdec(substr($param_sign['couleur_style_txt_stats'], 4, 2));
	} elseif (strlen($param_sign['couleur_style_txt_stats'])==3) {
		$couleur_txt_R = hexdec(substr($param_sign['couleur_style_txt_stats'], 0, 1))*16-1;
		$couleur_txt_V = hexdec(substr($param_sign['couleur_style_txt_stats'], 1, 1))*16-1;
		$couleur_txt_B = hexdec(substr($param_sign['couleur_style_txt_stats'], 2, 1))*16-1;
	} else {
		$couleur_txt_R = $couleur_txt_V = $couleur_txt_B = '0';
	}
	$couleur_perso_styletxt = imagecolorallocate($image, $couleur_txt_R, $couleur_txt_V, $couleur_txt_B);

	// classement points
	// on vérifie qu'il y a bien un classement points, sinon datadate=NULL, et ça donnera une erreur de type warning...
	if (!empty($derniere_point_stats)) {
		$quet = mysql_query('SELECT rank, points, ally FROM '.TABLE_RANK_PLAYER_POINTS.' WHERE player = '.$nom_player_protege.' and datadate = '.$derniere_point_stats.' LIMIT 1');
		$result = mysql_fetch_array($quet,MYSQL_ASSOC);
		$ppts = $result['rank'];
		$tpts = $result['points'];
		$alli_u = $result['ally'];

		// et là, on regarde pour l'évolution points
		// il est vrai qu'une manière optimale pour récupérer la deuxième max datadate serait de faire ceci :
		// select min(datadate) from (select first 2 distinct datadate from ".TABLE_RANK_PLAYER_POINTS." order by datadate desc);
		// mais MySQL ne supporte pas cela...
		// on ira donc plus en "finesse" :-p
		// note: apparement, il ne faut pas imbriquer... merci ben_12
	$quet = mysql_query('SELECT max(datadate) as d FROM '.TABLE_RANK_PLAYER_POINTS.' WHERE player = '.$nom_player_protege.' AND datadate <> '.$derniere_point_stats);
		$result = mysql_fetch_array($quet,MYSQL_ASSOC);
		$oldrank_date = $result['d'];

		if (!empty($oldrank_date)) {
			$quet = mysql_query('SELECT rank FROM '.TABLE_RANK_PLAYER_POINTS.' WHERE player = '.$nom_player_protege.' AND datadate = '.$oldrank_date.' LIMIT 1');
			$result = mysql_fetch_array($quet,MYSQL_ASSOC);
			$oldrank_points = $result['rank'];
		}
	}

	$evo_pts = '?';
	// ce test est nécessaire, sinon, avec une valeur vide, on a toujours $oldrank_points > $ppts qui est vrai...
	if (!empty($oldrank_points)) {
		switch($oldrank_points) {
			case $oldrank_points > $ppts :
				$evo_pts = '+';
				break;
			case $oldrank_points == $ppts :
				$evo_pts = '*';
				break;
			case $oldrank_points < $ppts :
				$evo_pts = '-';
				break;
		}
	}

	// classement flotte
	// on vérifie qu'il y a bien un classement flotte, sinon datadate=NULL, et ça donnera une erreur de type warning...
	if (!empty($derniere_fleet_stats)) {
		$quet = mysql_query('SELECT rank, points, ally FROM '.TABLE_RANK_PLAYER_FLEET.' WHERE player = '.$nom_player_protege.' and datadate = '.$derniere_fleet_stats.' LIMIT 1');
		$result = mysql_fetch_array($quet,MYSQL_ASSOC);
		$pvaiss = $result['rank'];
		$tvaiss = $result['points'];
		// MAJ éventuelle de l'ally, si les stats flotte sont plus récentes que les stats points
		if(($result['ally']<>'') && ($derniere_fleet_stats >= $derniere_point_stats))
			$alli_u = $result['ally'];

		// et là, on regarde pour l'évolution flotte
		$quet = mysql_query('SELECT max(datadate) as d FROM '.TABLE_RANK_PLAYER_FLEET.' WHERE player = '.$nom_player_protege.' AND datadate <> '.$derniere_fleet_stats);
		$result = mysql_fetch_array($quet,MYSQL_ASSOC);
		$oldrank_date = $result['d'];

		if (!empty($oldrank_date)) {
			$quet = mysql_query('SELECT rank FROM '.TABLE_RANK_PLAYER_FLEET.' WHERE player = '.$nom_player_protege.' AND datadate = '.$oldrank_date.' LIMIT 1');
			$result = mysql_fetch_array($quet,MYSQL_ASSOC);
			$oldrank_fleet = $result['rank'];
		}
	}

	$evo_vaiss = '?';
	if (!empty($oldrank_fleet)) {
		switch($oldrank_fleet) {
			case $oldrank_fleet > $pvaiss :
				$evo_vaiss = '+';
				break;
			case $oldrank_fleet == $pvaiss :
				$evo_vaiss = '*';
				break;
			case $oldrank_fleet < $pvaiss :
				$evo_vaiss = '-';
				break;
		}
	}

	// classement recherche
	// on vérifie qu'il y a bien un classement recherche, sinon datadate=NULL, et ça donnera une erreur de type warning...
	if (!empty($derniere_research_stats)) {
		$quet = mysql_query('SELECT rank, points, ally FROM '.TABLE_RANK_PLAYER_RESEARCH.' WHERE player = '.$nom_player_protege.' and datadate = '.$derniere_research_stats.' LIMIT 1');
		$result = mysql_fetch_array($quet,MYSQL_ASSOC);
		$prech = $result['rank'];
		$trech = $result['points'];
		// MAJ éventuelle de l'ally, si les stats recherche sont plus récentes que les stats points & flotte
		if(($result['ally']<>'') && ($derniere_research_stats >= $derniere_point_stats && $derniere_research_stats >= $derniere_fleet_stats))
			$alli_u = $result['ally'];

		// et là, on regarde pour l'évolution recherche
		$quet = mysql_query('SELECT max(datadate) as d FROM '.TABLE_RANK_PLAYER_RESEARCH.' WHERE player = '.$nom_player_protege.' AND datadate <> '.$derniere_research_stats);
		$result = mysql_fetch_array($quet,MYSQL_ASSOC);
		$oldrank_date = $result['d'];

		if (!empty($oldrank_date)) {
			$quet = mysql_query('SELECT rank FROM '.TABLE_RANK_PLAYER_RESEARCH.' WHERE player = '.$nom_player_protege.' AND datadate = '.$oldrank_date.' LIMIT 1');
			$result = mysql_fetch_array($quet,MYSQL_ASSOC);
			$oldrank_research = $result['rank'];
		}
	}

	$evo_rech = '?';
	if (!empty($oldrank_research)) {
		switch($oldrank_research) {
			case $oldrank_research > $prech :
				$evo_rech ='+';
				break;
			case $oldrank_research == $prech :
				$evo_rech = '*';
				break;
			case $oldrank_research < $prech :
				$evo_rech = '-';
				break;
		}
	}

	// CREATION DE L'IMAGE
	// Début de l'écriture

	// arrays de positionnements de l'ombre ou du contour (ou de rien du tout, dans ce cas, on conserve NULL)
	$_x = NULL;
	$_y = NULL;

	// Détourage du texte
	// positions pour le contour
	if ($param_sign['style_texte_stats'] == 'd') {
		$_x = array(8, 1, 0, 1, -1, -1, 1, 0, -1);
		$_y = array(8, 0, -1, -1, 0, -1, 1, 1, 1);
	}

	// Ombrage des textes fixes
	// positions pour l'ombre
	if ($param_sign['style_texte_stats'] == 'o') {
		$_x = array(1, 1);
		$_y = array(1, 1);
	}

	// Gestion des textes fixes

	// Zone d'identification

	image_string_contour($image, 2, 5, 18, $nom_l.' : ', $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 229, 18, $uni_l.' : ', $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);// position vert
	image_string_contour($image, 2, 5, 29, $alli_l.' : ', $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 229, 29, 'ogame.'.$tld, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);

	// Tableau

	// "Place" & "Points"
	image_string_contour($image, 2, 5, 60, $place_l, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 5, 75, $points_l, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	// texte points
	image_string_contour($image, 2, 95, 45, $points_l, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	// texte vaisseaux
	image_string_contour($image, 2, 180, 45, $vaiss_l, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);
	// texte recherche
	image_string_contour($image, 2, 265, 45, $rech_l, $couleur_perso_txt, $couleur_perso_styletxt, $_x, $_y);

	// suppression des ombrages pour le reste (textes "variables")
	if ($param_sign['style_texte_stats'] == 'o') {
		$_x = NULL;
		$_y = NULL;
	}

	// Zone d'identification

	image_string_contour($image, 2, 41, 18, $nom_u, $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 290, 18, $uni_u, $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
	image_string_contour($image, 2, 41, 29, $alli_u, $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);

	// Tableau

	// date de création/MAJ de la signature + "Place" & "Points"
	image_string_contour($image, 1, 5, 48, date("d/m/y H:i", $date_derniere_maj), $gris, $grisF, $_x, $_y);

	// classement points & nombre de points
	// s'il n'y a pas de résultat, on affichera un '?' à la place du zéro
	if (empty($ppts)) {
		image_string_contour($image, 2, 95, 60, '?', $gris, $couleur_perso_styletxt, $_x, $_y);
		image_string_contour($image, 2, 95, 75, '?', $gris, $couleur_perso_styletxt, $_x, $_y);
	} else {
		image_string_contour($image, 2, 95, 60, number_format($ppts, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
		image_string_contour($image, 2, 95, 75, number_format($tpts, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
	}
	// évolution
	switch($evo_pts) {
		case '+':
			image_string_contour($image, 2, 165, 60, $evo_pts, $vert, $grisF, $_x, $_y);
			break;
		case '-':
			image_string_contour($image, 2, 165, 60, $evo_pts, $rouge, $grisF, $_x, $_y);
			break;
		case '*':
			image_string_contour($image, 2, 165, 60, $evo_pts, $bleu, $grisF, $_x, $_y);
			break;
		case '?':
			image_string_contour($image, 2, 165, 60, $evo_pts, $gris, $grisF, $_x, $_y);
			break;
		}

	// classement flotte & nombre de vaisseaux
	// s'il n'y a pas de résultat, on affichera un '?' à la place du zéro
	if (empty($pvaiss)) {
		image_string_contour($image, 2, 180, 60, '?', $gris, $couleur_perso_styletxt, $_x, $_y);
		image_string_contour($image, 2, 180, 75, '?', $gris, $couleur_perso_styletxt, $_x, $_y);
	} else {
		image_string_contour($image, 2, 180, 60, number_format($pvaiss, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
		image_string_contour($image, 2, 180, 75, number_format($tvaiss, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
	}
	// évolution
	switch($evo_vaiss) {
		case '+':
			image_string_contour($image, 2, 250, 60, $evo_vaiss, $vert, $grisF, $_x, $_y);
			break;
		case '-':
			image_string_contour($image, 2, 250, 60, $evo_vaiss, $rouge, $grisF, $_x, $_y);
			break;
		case '*':
			image_string_contour($image, 2, 250, 60, $evo_vaiss, $bleu, $grisF, $_x, $_y);
			break;
		case '?':
			image_string_contour($image, 2, 250, 60, $evo_vaiss, $gris, $grisF, $_x, $_y);
			break;
		}

	// classement recherche & nombre de recherches
	// s'il n'y a pas de résultat, on affichera un '?' à la place du zéro
	if (empty($prech)) {
		image_string_contour($image, 2, 265, 60, '?', $gris, $couleur_perso_styletxt, $_x, $_y);
		image_string_contour($image, 2, 265, 75, '?', $gris, $couleur_perso_styletxt, $_x, $_y);
	} else {
		image_string_contour($image, 2, 265, 60, number_format($prech, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
		image_string_contour($image, 2, 265, 75, number_format($trech, 0, ',', $sepa_milliers), $couleur_perso_txtvar, $couleur_perso_styletxt, $_x, $_y);
	}
	// évolution
	switch($evo_rech) {
		case '+':
			image_string_contour($image, 2, 339, 60, $evo_rech, $vert, $grisF, $_x, $_y);
			break;
		case '-':
			image_string_contour($image, 2, 339, 60, $evo_rech, $rouge, $grisF, $_x, $_y);
			break;
		case '*':
			image_string_contour($image, 2, 339, 60, $evo_rech, $bleu, $grisF, $_x, $_y);
			break;
		case '?':
			image_string_contour($image, 2, 339, 60, $evo_rech, $gris, $grisF, $_x, $_y);
			break;
		}

	// Création de l'image, si les headers n'ont pas déjà été envoyés... si c'est le cas, il y a eu des erreurs...
	if (!headers_sent())
		imagepng($image,$fichier_stats);

	// Libération des ressources
	imagedestroy($image);

	// nettoyage du cache sur les fichiers
	// (date de création changée, et on veut en être sûr, pour pas recréer l'img pour rien)
	clearstatcache();

} // endif (test sur la date ranking & img de stats)

?>
