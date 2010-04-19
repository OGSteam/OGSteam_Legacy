<?php
	/***************************************************************************
	*	fichier		: index.php
	*	description.	: eXpedition
	*	Auteur		: parAdOxxx_ZeRo
	*	créé		: 04/01/2008
	*	modifié		: 25/02/2008
	*	version		: 0.4.2
	
	Changelog
		0.4.2	Nettoyage du code + fix du css
		0.4.1	Ajout du bouton de forcage de xtense 2 dans config.
		0.4.0	Derniers fix + tag
		0.3.6	Refonte page header
		0.3.5 	Round des moyennes + corrections mineures du bbcode + Ajout du support d'xtense 2
		0.3.0 	Minor fixes + problème de "taggage" + ajout de signature d'export !
		0.2.9	Refonte de la page Config : les paramètres sont maintenant immédiatement pris en compte et les boite déroulante reflete les données de la base...
		0.2.8  	Ajout de la fonction d'eXport BBCode pour le mois et pour chaque eXp.
		0.2.7   Ajout image-lien export BBCode dans détail perso, remaniement compatibilité pour l'ajout des eXpedition ressources
		0.2.6	Corrections des conneries de la 0.2.5 XD
		0.2.5 	Résolution de plusieurs bugz + améliorations (Tickets : 341, 344, 347, 348 (cf. trac)), ajout du mod debug dans la config,
			résolution du bug du calcul du HoF général (le premier), résolution du problème des détails lors de la sélection de la période 
			(si global affichait user :/), ajout du header de date pour l'ajout de la période au HoF, correction des eXpedition qui apparaissent en retard,
			passage à la quinzaine par défaut pour les détails, détection du deuxième type de marchand...
		0.2.0 	Ajout des camembert dans stat + Ajout du Hall Of Fame + Ajout du choix de date dans les détails + calendrier js...
		0.1.9 	Correction de bugs à l'install et à la mise à jour + correction bug des points de structure... 
		0.1.8 	Ajout des moyennes, totaux, points de structure pour les vaisseaux dans stat + dans base (recalcul à l'install)
		0.1.7 	Ajout .htaccess (oublié) :p
		0.1.6 	Ajout du module de configuration en urgence vu les cas d'incompatibilité avec la dock.. => Possibilité images fixes à la place... 
		0.1.5 	Correction de l'encodage de tous les fichiers (normalement :D) + ajout du dock de menu + groupement des resultats de détail par joueurs + minor bugs 
		0.1.4 	Correction d'un bug mineur qui permettait l'ajout du meme rapport d'expédition vaisseau plusieurs fois...
		0.1.3 	Correction de bugs mineurs (/0, // ds images et redefine de table_user
		0.1.2 	Fusion des sources des pages de stats + réalisation page détail + gestion du mois courant + pourcentages + icones neon
		0.1.1 	Gros ménage du code + séparation en plusieurs fichier + ajout de gestion des modules + ajout module stat globales + ajout module detail
		0.1.0 	Premiere release en alpha : ajout du parsing + insertion dans la base TODO : gestion du mois courant
		0.0.1 	Affichage des données de la base
		0.0.0 	Création + maquette HTML

			
	***************************************************************************/


if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct

global $db, $table_preffix;

//definition des tables
define("TABLE_EXPEDITION",	  $table_prefix."eXpedition");
define("TABLE_EXPEDITION_TYPE_0", $table_prefix."eXpedition_Type_0");
define("TABLE_EXPEDITION_TYPE_1", $table_prefix."eXpedition_Type_1");
define("TABLE_EXPEDITION_TYPE_2", $table_prefix."eXpedition_Type_2");
define("TABLE_EXPEDITION_TYPE_3", $table_prefix."eXpedition_Type_3");
define("TABLE_EXPEDITION_OPTS",   $table_prefix."eXpedition_Opts");

//On regarde si le mod est activé + on recupère la racine :
$query = "SELECT `root` FROM `".TABLE_MOD."` WHERE `action`='eXpedition' AND `active`='1' LIMIT 1";
$isActive = $db->sql_numrows($db->sql_query($query)); // mod actif ?
//On vérifie que le mod est activé
if(!$isActive) die('Mod désactivé !');

$result = $db->sql_query($query);
list($root) = $db->sql_fetch_row($result);

// définition du dossier du modules
define("FOLDEREXP","mod/".$root."/");

// Inclusion des fonctions :
require_once(FOLDEREXP."includes/functions.php"); //on inclut l'entete d'ogspy dans le mod


// On regarde si on veut afficher une page spécifique ou juste la page d'accueil :

if(!isset($pub_module))
{
	$module = 'stat';
}
else
{
	$module = $pub_module;
}

require_once("views/page_header.php"); //on inclut l'entete d'ogspy dans le mod

require_once(FOLDEREXP."includes/header.php"); //on inclut notre header à nous !

require_once(FOLDEREXP."includes/$module.php");// on inclut le fichier correspondant à la page désirée !

require_once(FOLDEREXP."includes/footer.php"); //on inclut notre footer à nous !

require_once("views/page_tail.php"); //on inclus la queue d'ogspy


//Voila le mod est fini ! Pas trop triste ? :D

?>
