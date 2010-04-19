<?php
	/***************************************************************************
	*	fichier		: index.php
	*	description.	: eXpedition
	*	Auteur		: parAdOxxx_ZeRo
	*	cr��		: 04/01/2008
	*	modifi�		: 25/02/2008
	*	version		: 0.4.2
	
	Changelog
		0.4.2	Nettoyage du code + fix du css
		0.4.1	Ajout du bouton de forcage de xtense 2 dans config.
		0.4.0	Derniers fix + tag
		0.3.6	Refonte page header
		0.3.5 	Round des moyennes + corrections mineures du bbcode + Ajout du support d'xtense 2
		0.3.0 	Minor fixes + probl�me de "taggage" + ajout de signature d'export !
		0.2.9	Refonte de la page Config : les param�tres sont maintenant imm�diatement pris en compte et les boite d�roulante reflete les donn�es de la base...
		0.2.8  	Ajout de la fonction d'eXport BBCode pour le mois et pour chaque eXp.
		0.2.7   Ajout image-lien export BBCode dans d�tail perso, remaniement compatibilit� pour l'ajout des eXpedition ressources
		0.2.6	Corrections des conneries de la 0.2.5 XD
		0.2.5 	R�solution de plusieurs bugz + am�liorations (Tickets : 341, 344, 347, 348 (cf. trac)), ajout du mod debug dans la config,
			r�solution du bug du calcul du HoF g�n�ral (le premier), r�solution du probl�me des d�tails lors de la s�lection de la p�riode 
			(si global affichait user :/), ajout du header de date pour l'ajout de la p�riode au HoF, correction des eXpedition qui apparaissent en retard,
			passage � la quinzaine par d�faut pour les d�tails, d�tection du deuxi�me type de marchand...
		0.2.0 	Ajout des camembert dans stat + Ajout du Hall Of Fame + Ajout du choix de date dans les d�tails + calendrier js...
		0.1.9 	Correction de bugs � l'install et � la mise � jour + correction bug des points de structure... 
		0.1.8 	Ajout des moyennes, totaux, points de structure pour les vaisseaux dans stat + dans base (recalcul � l'install)
		0.1.7 	Ajout .htaccess (oubli�) :p
		0.1.6 	Ajout du module de configuration en urgence vu les cas d'incompatibilit� avec la dock.. => Possibilit� images fixes � la place... 
		0.1.5 	Correction de l'encodage de tous les fichiers (normalement :D) + ajout du dock de menu + groupement des resultats de d�tail par joueurs + minor bugs 
		0.1.4 	Correction d'un bug mineur qui permettait l'ajout du meme rapport d'exp�dition vaisseau plusieurs fois...
		0.1.3 	Correction de bugs mineurs (/0, // ds images et redefine de table_user
		0.1.2 	Fusion des sources des pages de stats + r�alisation page d�tail + gestion du mois courant + pourcentages + icones neon
		0.1.1 	Gros m�nage du code + s�paration en plusieurs fichier + ajout de gestion des modules + ajout module stat globales + ajout module detail
		0.1.0 	Premiere release en alpha : ajout du parsing + insertion dans la base TODO : gestion du mois courant
		0.0.1 	Affichage des donn�es de la base
		0.0.0 	Cr�ation + maquette HTML

			
	***************************************************************************/


if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'acc�s direct

global $db, $table_preffix;

//definition des tables
define("TABLE_EXPEDITION",	  $table_prefix."eXpedition");
define("TABLE_EXPEDITION_TYPE_0", $table_prefix."eXpedition_Type_0");
define("TABLE_EXPEDITION_TYPE_1", $table_prefix."eXpedition_Type_1");
define("TABLE_EXPEDITION_TYPE_2", $table_prefix."eXpedition_Type_2");
define("TABLE_EXPEDITION_TYPE_3", $table_prefix."eXpedition_Type_3");
define("TABLE_EXPEDITION_OPTS",   $table_prefix."eXpedition_Opts");

//On regarde si le mod est activ� + on recup�re la racine :
$query = "SELECT `root` FROM `".TABLE_MOD."` WHERE `action`='eXpedition' AND `active`='1' LIMIT 1";
$isActive = $db->sql_numrows($db->sql_query($query)); // mod actif ?
//On v�rifie que le mod est activ�
if(!$isActive) die('Mod d�sactiv� !');

$result = $db->sql_query($query);
list($root) = $db->sql_fetch_row($result);

// d�finition du dossier du modules
define("FOLDEREXP","mod/".$root."/");

// Inclusion des fonctions :
require_once(FOLDEREXP."includes/functions.php"); //on inclut l'entete d'ogspy dans le mod


// On regarde si on veut afficher une page sp�cifique ou juste la page d'accueil :

if(!isset($pub_module))
{
	$module = 'stat';
}
else
{
	$module = $pub_module;
}

require_once("views/page_header.php"); //on inclut l'entete d'ogspy dans le mod

require_once(FOLDEREXP."includes/header.php"); //on inclut notre header � nous !

require_once(FOLDEREXP."includes/$module.php");// on inclut le fichier correspondant � la page d�sir�e !

require_once(FOLDEREXP."includes/footer.php"); //on inclut notre footer � nous !

require_once("views/page_tail.php"); //on inclus la queue d'ogspy


//Voila le mod est fini ! Pas trop triste ? :D

?>
