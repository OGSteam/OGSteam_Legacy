<?php
/**
 * lang_french.php 

Liste des chaines et regex pour la langue Fran�aise.

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
$lang['omips_visu_couverture2'] =				"Mips r�partis dans";
$lang['omips_visu_couverture3'] =				"base(s) de lancement.";
$lang['omips_visu_couverture_total'] =				"Couverture totale de l'univers : ";

// visualisation :
$lang['omips_rech'] =				                "Recherche";
$lang['omips_rech_coord'] =				        "Coordonn�es cible : ";
$lang['omips_rech_exlication'] =				"La recherche va retourner toutes les bases de lancement alli�es � port�e de la cible.";



// Resultat :
$lang['omips_result_erreur'] =				"La configuration de votre univers ne permet pas cette recherche";
$lang['omips_result_erreur2'] =				"Les champs doivent �tre remplit par des valeurs num�rique";
 $lang['omips_result_erreur3'] =				"Tous les champs doivent �tre remplit";
$lang['omips_result_erreur4'] =				"Erreur du serveur";
$lang['omips_result'] =				"Resultats";
$lang['omips_result_Pseudo'] =				"Pseudo";
$lang['omips_result_Coordonn'] =				"Coordonn�es";
$lang['omips_result_Silo'] =				"Silo";
 $lang['omips_result_Mips'] =				"Mips";
$lang['omips_result_Armes'] =				"Armes";
$lang['omips_result_Nanites'] =				"Nanites";
$lang['omips_result_Chantier'] =				"Chantier S.";
 $lang['omips_result_Mips2'] =				"Mips/h";
 $lang['omips_result_result_mips'] =				"R�sultats MIPs";
 $lang['omips_result_result_no_result'] =				"Il n'y as pas de r�sultats";
  $lang['omips_result_result_total_mip'] =				"Nombre de Mips/h total : ";
  $lang['omips_result_result_insert_bbcode'] =				"Insertion dans les forums BBcode";


 // a propos :
  $lang['omips_apropos'] =				"A Propos";
  $lang['omips_apropos_help'] =
  				"	<tr><th style=\"text-align: left;\">
Ce module a �t� enti�rement �crit par <strong>Baton</strong>.<br>
Et mis � jour par <strong>Ianouf</strong>.<br><br>
<strong>- Vous avez un probl�me avec ce module ?</strong><br>
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
- Comment les donn�es se mettent elles � jour ?<br>
Les donn�es sont mises � jour gr�ce au plugin Xtense, elles sont r�cup�r�es des pages B�timents, D�fenses et Laboratoire.<br>
Pour mettre � jour ces donn�es il suffit de se rendre dans ces pages.<br><br>
- La page \"Visualisations & Statistiques\" ?<br>
Cette page affiche les diagrammes de chacune des galaxies.<br>
Les Zones en <strong style=\"color:#405680;\">bleu</strong> indique les endroits o� aucun membre est � port�e.<br>
Les Zones en <strong style=\"color:#097100;\">vert</strong> indique les endroits o� au moins un membre est � port�e.<br>

	</th></tr>";


   $lang['omips_apropos_copyright'] =				"Module de calcul de port�e des MIP par <b>Baton</b> tir� du site <a href='http://ogametools.breizh-web.net/'>Otools</a>
Version 1.1a";













?>