<?php

// pour l'affichage de la date
setlocale(LC_TIME, 'fr');
// format français : "nom_jour JJ nom_mois à HH:MM:SS"
//$format_date="%A %d %B à %H:%M:%S";

// valeur des seuils
$s_ressources = 200000;
$s_flotte = 200;
$s_defense = 200;
$s_batiments = 22;
$s_recherche = 12;

// couleurs par défaut
$c_defaut = '#FF9933';
$c_titre = '#0099FF';
$c_ressources = '#33FF33';
$c_flotte = '#FF00FF';
$c_defense = '#FF00FF';
$c_batiments = '#FF3333';
$c_recherche = '#FF3333';
$c_nom_planete = '#0099FF';

// les couleurs voulues par l'utilisateur
if (isset($_POST['spyreport']) && !empty($_POST['spyreport'])) {
	if (!empty($_POST['couleurdefaut'])) $c_defaut = $_POST['couleurdefaut'];
	if (!empty($_POST['couleurtitre'])) $c_titre = $_POST['couleurtitre'];
	if (!empty($_POST['couleurressources'])) $c_ressources = $_POST['couleurressources'];
	if (!empty($_POST['couleurflotte'])) $c_flotte = $_POST['couleurflotte'];
	if (!empty($_POST['couleurdefense'])) $c_defense = $_POST['couleurdefense'];
	if (!empty($_POST['couleurbatiments'])) $c_batiments = $_POST['couleurbatiments'];
	if (!empty($_POST['couleurrecherche'])) $c_recherche = $_POST['couleurrecherche'];
	if (!empty($_POST['couleurplanete'])) $c_nom_planete = $_POST['couleurplanete'];
}

// nom de chaque partie (pour la lecture du RE, et l'affichage ensuite)
$nom_partie_ressources = 'Matières premières';
$nom_partie_flotte = 'Flotte';
$nom_partie_defense = 'Défense';
$nom_partie_batiments = 'Bâtiments';
$nom_partie_recherche = 'Recherche';

// pour découper le RE
// correspond aux champs [ReadStrings] SPIO1 et SPIO2 de Speedsim
$spio1 = 'Matières premières sur '; // changement avec la chaine concernant l'activité sur la planète (le simple mot "sur" n'est pa suffisant)
$spio2 = "')";
$nom_metal = 'Métal:';
$txt_proba_destruc = 'Probabilité de destruction';

// divers... (pour l'affichage)
$espionnage_sur = 'Espionnage sur ';
$le_date = "\nle ";
$graviton = 'graviton';
$edlm = 'mort'; // un seul mot, car les espaces ne passent pas avec eregi()... et le \s non plus !
$porte_saut = "Porte de saut spatial";
$genere_par = 'G&eacute;n&eacute;r&eacute; par';

// liste des forums. pour le BBCode adapté
$liste_forum = array ( 'phpBB & WBB - [size] [center]' , 'LDU' , 'SMF & WBB lite - [size] [center]' , 'sans couleurs ni taille -  [center] no [size]' , 'HTML' , 'punBB - no [size] no [center]' );

// définition des styles
// modèle : $style[NUM_FORUM]['NOM_STYLE'][TYPE]="BALISE_BBCODE";
// NUM_FORUM : numéro de la liste de style (pour gérer plusieurs syntaxe BBCode)
// NOM_STYLE : nom du style
// TYPE : [0|1] zéro pour l'ouverture et un pour la fermeture de la balise
// BALISE_BBCODE : style BBCode à appliquer

// style pour phpBB & WBB
$style[0] = array (
	'defaut' => array ('[b][color='.$c_defaut.']','[/color][/b]'),
	'titre' => array ('[b][size=16][color='.$c_titre.']','[/color][/size][/b]'),
	'ressources' => array ('[b][size=14][color='.$c_ressources.']','[/color][/size][/b]'),
	'flotte' => array ('[b][color='.$c_flotte.']','[/color][/b]'),
	'defense' => array ('[b][color='.$c_defense.']','[/color][/b]'),
	'batiments' => array ('[b][color='.$c_batiments.']','[/color][/b]'),
	'recherche' => array ('[b][color='.$c_recherche.']','[/color][/b]'),
	'nom_planete' => array ('[b][color='.$c_nom_planete.']','[/color][/b]'),
	'quote' => array ('[quote]','[/quote]'),
	'center' => array ('[center]','[/center]'),
	'url_restyler' => '[size=9][url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].']'.$genere_par.' REstyler '.$restyler_version.'[/url][/size]',
	'new_line' => "\n"
);

// style pour LDU
$style[1] = array (
	'defaut' => array ('[b][blue]','[/blue][/b]'),
	'titre' => array ('[style=2][sea]','[/sea][/style]'),
	'ressources' => array ('[style=3][yellow]','[/yellow][/style]'),
	'flotte' => array ('[b][purple]','[/purple][/b]'),
	'defense' => array ('[b][purple]','[/purple][/b]'),
	'batiments' => array ('[b][red]','[/red][/b]'),
	'recherche' => array ('[b][red]','[/red][/b]'),
	'nom_planete' => array ('[b][sea]','[/sea][/b]'),
	'quote' => array ('[quote]','[/quote]'),
	'center' => array ('[center]','[/center]'),
	'url_restyler' => '[style=7][url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].']'.$genere_par.' REstyler '.$restyler_version.'[/url][/style]',
	'new_line' => "\n"
);

// style pour SMF & WBB lite
$style[2] = array (
	'defaut' => array ('[b][color='.$c_defaut.']','[/color][/b]'),
	'titre' => array ('[b][size=3][color='.$c_titre.']','[/color][/size][/b]'),
	'ressources' => array ('[b][size=3][color='.$c_ressources.']','[/color][/size][/b]'),
	'flotte' => array ('[b][color='.$c_flotte.']','[/color][/b]'),
	'defense' => array ('[b][color='.$c_defense.']','[/color][/b]'),
	'batiments' => array ('[b][color='.$c_batiments.']','[/color][/b]'),
	'recherche' => array ('[b][color='.$c_recherche.']','[/color][/b]'),
	'nom_planete' => array ('[b][color='.$c_nom_planete.']','[/color][/b]'),
	'quote' => array ('[quote]','[/quote]'),
	'center' => array ('[center]','[/center]'),
	'url_restyler' => '[size=1][url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].']'.$genere_par.' REstyler '.$restyler_version.'[/url][/size]',
	'new_line' => "\n"
);

// style épuré, sans couleurs ni taille
$style[3] = array (
	'defaut' => array ('[b]','[/b]'),
	'titre' => array ('[b]','[/b]'),
	'ressources' => array ('[b]','[/b]'),
	'flotte' => array ('[b]','[/b]'),
	'defense' => array ('[b]','[/b]'),
	'batiments' => array ('[b]','[/b]'),
	'recherche' => array ('[b]','[/b]'),
	'nom_planete' => array ('[b]','[/b]'),
	'quote' => array ('[quote]','[/quote]'),
	'center' => array ('[center]','[/center]'),
	'url_restyler' => '[i][url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].']'.$genere_par.' REstyler '.$restyler_version.'[/url][/i]',
	'new_line' => "\n"
);

// code HTML
$style[4] = array (
	'defaut' => array ('<span style="font-weight: bolder; color:'.$c_defaut.';">','</span>'),
	'titre' => array ('<span style="font-weight: bolder; font-size:16px; color:'.$c_titre.';">','</span>'),
	'ressources' => array ('<span style="font-weight: bolder; font-size:14px; color:'.$c_ressources.';">','</span>'),
	'flotte' => array ('<span style="font-weight: bolder; color:'.$c_flotte.';">','</span>'),
	'defense' => array ('<span style="font-weight: bolder; color:'.$c_defense.';">','</span>'),
	'batiments' => array ('<span style="font-weight: bolder; color:'.$c_batiments.';">','</span>'),
	'recherche' => array ('<span style="font-weight: bolder; color:'.$c_recherche.';">','</span>'),
	'nom_planete' => array ('<span style="font-weight: bolder; color:'.$c_nom_planete.';">','</span>'),
	'quote' => array ('<fieldset>','</fieldset>'),
	'center' => array ('<center>','</center>'),
	'url_restyler' => '<a href="http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'" style="font-size:10px;">'.$genere_par.' REstyler '.$restyler_version.'</a>',
	'new_line' => "<br />\n"
);

// style pour punBB de base (pas de size ni center)
$style[5] = array (
	'defaut' => array ('[b][color='.$c_defaut.']','[/color][/b]'),
	'titre' => array ('[b][color='.$c_titre.']','[/color][/b]'),
	'ressources' => array ('[b][color='.$c_ressources.']','[/color][/b]'),
	'flotte' => array ('[b][color='.$c_flotte.']','[/color][/b]'),
	'defense' => array ('[b][color='.$c_defense.']','[/color][/b]'),
	'batiments' => array ('[b][color='.$c_batiments.']','[/color][/b]'),
	'recherche' => array ('[b][color='.$c_recherche.']','[/color][/b]'),
	'nom_planete' => array ('[b][color='.$c_nom_planete.']','[/color][/b]'),
	'quote' => array ('[quote]','[/quote]'),
	'center' => array ('',''),
	'url_restyler' => '[url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].']'.$genere_par.' REstyler '.$restyler_version.'[/url]',
	'new_line' => "\n"
);

// les phrases accompagnant la proba de destruction...
$txt_proba_destruc_rp = ' de chances de se faire d&eacute;truire.';
$txt_proba_destruc_rp_0[] = ', les d&eacute;fenses ennemies n\'ont rien vu.';
$txt_proba_destruc_rp_0[] = '. M&ecirc;me pas rep&eacute;r&eacute; !';
$txt_proba_destruc_rp_0[] = '. Incognito !';
$txt_proba_destruc_rp_0[] = ', m&ecirc;me ma grand m&egrave;re peut le faire !';
$txt_proba_destruc_rp_0[] = ', les d&eacute;fenses adverses n\'y ont vu que du feu !';
$txt_proba_destruc_rp_0[] = '. Leur syst&egrave;me d&eacute;fensif &eacute;tait d&eacute;sactiv&eacute;';
$txt_proba_destruc_rp_100[] = '. Ce fut "mission suicide !!!"';
$txt_proba_destruc_rp_100[] = '. C\'&eacute;tait une mission suicide !!!';
$txt_proba_destruc_rp_100[] = '. C\'&eacute;tait une pure folie !';
$txt_proba_destruc_rp_100[] = '... Au prix du cristal, c\'&eacute;tait du gaspillage !';
$txt_proba_destruc_rp_100[] = '. C\'est sympa de distribuer du cristal...';
$txt_proba_destruc_rp_100[] = '. Je donne du cristal...';
$txt_proba_destruc_rp_100[] = '. C\'&eacute;tait plus dur que de rouler une pelle à un cobra !';
$txt_proba_destruc_rp_100[] = '. Il ne fallait pas atterrir ici...';
$txt_proba_destruc_rp_100[] = '. Que se passe-t-il aujourd\'hui, une pluie de sondes ?';
$txt_proba_destruc_rp_100[] = '. Ce soir, on recycle des sondes...';

?>
