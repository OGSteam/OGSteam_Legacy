<?php
/**
 * lang_french.php 

Liste des chaines et regex pour la langue Française.

 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Titre des menus :


$lang['omips_menu_visu'] =				"Visualisations & Statistiques";
$lang['omips_menu_rech'] =				"Recherche";
$lang['omips_menu_aide'] =				"A propos & Aide";

// visualisation :
$lang['omips_visu_visu'] =				"Visualisation & Satistiques";
$lang['omips_visu_pourcentage_et_visu'] =		"Pourcentages et visualisations de la couverture des MIPs par galaxie.";
$lang['omips_visu_g1'] =				"Galaxie 1";
$lang['omips_visu_g2'] =				"Galaxie 2";
$lang['omips_visu_g3'] =				"Galaxie 3";
$lang['omips_visu_g4'] =				"Galaxie 4";
$lang['omips_visu_g5'] =				"Galaxie 5";
$lang['omips_visu_g6'] =				"Galaxie 6";
$lang['omips_visu_g7'] =				"Galaxie 7";
$lang['omips_visu_g8'] =				"Galaxie 8";
$lang['omips_visu_g9'] =				"Galaxie 9";
$lang['omips_visu_couverture1'] =				"% de la galaxie couverts avec";
$lang['omips_visu_couverture2'] =				"Mips répartis dans";
$lang['omips_visu_couverture3'] =				"base(s) de lancement.";
$lang['omips_visu_couverture_total'] =				"Couverture totale de l'univers : ";

// visualisation :
$lang['omips_rech'] =				                "Recherche";
$lang['omips_rech_coord'] =				        "Coordonnées cible : ";
$lang['omips_rech_exlication'] =				"La recherche va retourner toutes les bases de lancement alliées à portée de la cible.";



// Resultat :
$lang['omips_result_erreur'] =				"La configuration de votre univers ne permet pas cette recherche";
$lang['omips_result_erreur2'] =				"Les champs doivent étre remplit par des valeurs numérique";
 $lang['omips_result_erreur3'] =				"Tous les champs doivent étre remplit";
$lang['omips_result_erreur4'] =				"Erreur du serveur";
$lang['omips_result'] =				"Resultats";
$lang['omips_result_Pseudo'] =				"Pseudo";
$lang['omips_result_Coordonn'] =				"Coordonnées";
$lang['omips_result_Silo'] =				"Silo";
 $lang['omips_result_Mips'] =				"Mips";
$lang['omips_result_Armes'] =				"Armes";
$lang['omips_result_Nanites'] =				"Nanites";
$lang['omips_result_Chantier'] =				"Chantier S.";
 $lang['omips_result_Mips2'] =				"Mips/h";
 $lang['omips_result_result_mips'] =				"Résultats MIPs";
 $lang['omips_result_result_no_result'] =				"Il n'y as pas de résultats";
  $lang['omips_result_result_total_mip'] =				"Nombre de Mips/h total : ";
  $lang['omips_result_result_insert_bbcode'] =				"Insertion dans les forums BBcode";


 // a propos :
  $lang['omips_apropos'] =				"A Propos";
  $lang['omips_apropos_help'] =
  				"	<tr><th style=\"text-align: left;\">
Ce module a été entiérement écrit par <strong>Baton</strong>.<br>
Et mis à jour par <strong>Ianouf</strong>.<br><br>
<strong>- Vous avez un probléme avec ce module ?</strong><br>
Vous pouvez me contacter  par mail : Baton@hotmail.fr<br>
Ou sur le forum support : <a href='http://ogametools.breizh-web.net/forum/'>Forum</a> <em>(Dans la partie OCarto - Mips 'Module pour OGspy')</em>.
	</th></tr>
</table>
<br>
<table style=\"text-align:center; color:white;\">
	<tr>
		<td class='c'>Aide</td>
	</tr>
	
	<tr><th style=\"text-align: left;\">
- Comment les données se mettent elles à jour ?<br>
Les données sont mises à jour grâce au plugin Xtense, elles sont récupérées des pages Bâtiments, Défenses et Laboratoire.<br>
Pour mettre à jour ces données il suffit de se rendre dans ces pages.<br><br>
- La page \"Visualisations & Statistiques\" ?<br>
Cette page affiche les diagrammes de chacune des galaxies.<br>
Les Zones en <strong style=\"color:#405680;\">bleu</strong> indique les endroits où aucun membre est à portée.<br>
Les Zones en <strong style=\"color:#097100;\">vert</strong> indique les endroits où au moins un membre est à portée.<br>

	</th></tr>";


   $lang['omips_apropos_copyright'] =				"Module de calcul de portée des MIP par <b>Baton</b> tiré du site <a href='http://ogametools.breizh-web.net/'>Otools</a>
Version 1.1a";













?>