<?php
/***************************************************************************
*	filename	: help.php
*	desc.		:
*	Author		: Naqdazar- http://ogs.servebbs.net/
*	created		: 08/08/2006 00:00:00
*	modified	: 08/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

global $user_data;

$help["galaxy_missiles"] = "Chargez des rapports d'espionnage pour afficher les colonies hostiles";
// ajout Axel
$help["galaxy_ratio_restrict"] = "La page galaxie vous est inaccessible étant donné un ratio de participation insuffisant.<br />Améliorez votre participation afin de rendre le mode recherche de nouveau actif.<br /> Valeur plancher: ".User_Lower_Ratio.".";
$help["search_ratio_restrict"] = "Le mode recherche vous est inaccessible étant donné un ratio de participation insuffisant.<br />Améliorez votre participation afin de rendre le mode recherche de nouveau actif.<br /> Valeur plancher: ".User_Lower_Ratio.".";
$help["search_ratio_info"] = "Votre ratio indique votre participation rapportée à la participation globale des autres membres pour les trois types de pages ogame (Galaxie,Classement et rapports d'espionnage).<br/>Saisissez autant de données que possible afin d'améliorer votre ratio.<br /><br />Utilisez le plugin pour firefox pour faciliter ce travail si vous le souhaitez.<br /><br /> Valeur plancher: ".User_Lower_Ratio.".";


$help["galaxy_phalanx"] = "Chargez des rapports d'espionnage pour afficher les phalanges hostiles";

$help["tooltip_menu_admin"] = "<table width=\'250\' >"
                            . "<tr><td class=\'c\' colspan=\'2\' align=\'center\' width=\'200\'><b>Sous-menus administration</b></td></tr>"
                            . "<tr ><th ><div  align=\'left\'>";


                            //if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1)

                            if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1 || !isset($user_data)) {
                              $help["tooltip_menu_admin"] .= "<a style=\'cursor:pointer\' title=\'Rien\' href=\'index.php?action=administration&subaction=infoserver\'>Informations générales</a><br/>";
                              $help["tooltip_menu_admin"] .= "<a style=\'cursor:pointer\' title=\'Rien\' href=\'index.php?action=administration&subaction=parameter\'>Paramètres du serveur</a><br/>";
                            if ( $user_data["management_user"] == 1 || !isset($user_data))
                              $help["tooltip_menu_admin"] .= "<a style=\'cursor:pointer\' title=\'Rien\' href=\'index.php?action=administration&subaction=infoserver\'>Gestion des membres</a><br/>";
                            if ($user_data["management_user"] == 1 || !isset($user_data))
                               $help["tooltip_menu_admin"] .= "<a style=\'cursor:pointer\' title=\'Rien\' href=\'index.php?action=administration&subaction=group\'>Gestion des groupes</a><br/>";
                            $help["tooltip_menu_admin"] .= "<a style=\'cursor:pointer\' title=\'Rien\' href=\'index.php?action=administration&subaction=viewer\'>Journal</a><br/>";
                            $help["tooltip_menu_admin"] .= "<a style=\'cursor:pointer\' title=\'Rien\' href=\'index.php?action=administration&subaction=mod\'>Gestion des Mods</a><br/>";
                            }
                            $help["tooltip_menu_admin"] .= "</div></th></tr></table>";


$help["tooltip_menu_perso"] = "<table width=\'250\' >"
                            . "<tr><td class=\'c\' colspan=\'2\' align=\'center\' width=\'200\'><b>Sous-menus de l\'espace personnel</b></td></tr>"
                            . "<tr ><th ><div  align=\'left\'>";


                            $help["tooltip_menu_perso"] .= "<a style=\'cursor:pointer\' title=\'Rien\' href=\'index.php?action=home&subaction=empire\'>Empire</a><br/>";
                            $help["tooltip_menu_perso"] .= "<a style=\'cursor:pointer\' title=\'Rien\' href=\'index.php?action=home&subaction=simulation\'>Simulation</a><br/>";
                            $help["tooltip_menu_perso"] .= "<a style=\'cursor:pointer\' title=\'Rien\' href=\'index.php?action=home&subaction=spy\'>Rapports d\'espionnage</a><br/>";
                            $help["tooltip_menu_perso"] .= "<a style=\'cursor:pointer\' title=\'Rien\' href=\'index.php?action=home&subaction=stat\'>Statistiques</a><br/>";

                            $help["tooltip_menu_perso"] .= "</div></th></tr></table>";




?>