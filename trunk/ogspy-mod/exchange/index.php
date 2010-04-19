<?php
	/***************************************************************************
	*	fichier		: index.php
	*	description.	: eXchange
	*	Auteur		: parAdOxxx_ZeRo
	*	cr��		: 17/02/2008
	*	modifi�		: 25/02/2008
	*	version		: 0.2.1
	
	Changelog 
		0.2.1 Compatibilit� Xtense 2.0b7/2.0.4041
		0.2.0	Nettoyage du code + fix du css
		0.1.9	Ajout des stats + minor fixes dans recherche
		0.1.8	Support du multi-page pour la recherche !
		0.1.7	Correction de bug pour la recherche.
		0.1.6	Re-refonte du syst�me d'affichage des messages : abstraction maximale
		0.1.5	Ajout de la page d'about + redimensionnement des images (256^2 -> 128^2)
		0.1.4	Syst�me de recherche op�rationnel.
		0.1.3	Refonte du syst�me d'affichage de message. Cr�tion de la vue (view.php)
		0.1.2	Ajout du bouton de forcage de xtense 2 dans config.
		0.1.1	Probleme d'apostrophe et retour � la ligne regl� + ajout du type de table myISAM
		0.1.0	Affichage des messages + support des multi-pages
		0.0.7	Ajout des options
		0.0.5	Support ajout par xtense
		0.0.2	Support ajout de message perso + ally
		0.0.1   R�alisation des install update uninstall avec compatibilit� xtense... 
		0.0.0 	Cr�ation

			
	***************************************************************************/


if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'acc�s direct

global $db, $table_preffix;

//definition des tables
define("TABLE_EXCHANGE_USER",	$table_prefix."eXchange_User");
define("TABLE_EXCHANGE_ALLY",	$table_prefix."eXchange_Ally");
define("TABLE_EXCHANGE_OPTS",	$table_prefix."eXchange_Opts");

//On regarde si le mod est activ� + on recup�re la racine :
$query = "SELECT `root` FROM `".TABLE_MOD."` WHERE `action`='eXchange' AND `active`='1' LIMIT 1";
$isActive = $db->sql_numrows($db->sql_query($query)); // mod actif ?
//On v�rifie que le mod est activ�
if(!$isActive) die('Mod d�sactiv� !');

$result = $db->sql_query($query);
list($root) = $db->sql_fetch_row($result);

// d�finition du dossier du modules
define("FOLDEREXP","mod/".$root."/");

// Inclusion des fonctions :
require_once(FOLDEREXP."includes/functions.php");
// Inclusion des fonctions de vue :
require_once(FOLDEREXP."includes/view.php"); 

// On regarde si on veut afficher une page sp�cifique ou juste la page d'accueil :

if(!isset($pub_module))
{
	$module = 'user';
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
