<?php
/***************************************************************************
* block_acp_portal_include_block_lang (Additional variables used by portal)
* @package language français
* @copyright (c) 2007 sjpphpbb http://sjpphpbb.net/phpbb3/portal.php
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
 ***************************************************************************/
 
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

/***************************************************************************
* DEVELOPERS PLEASE NOTE
*
* All language files should use UTF-8 as their encoding and the files must not contain a BOM.
*
* Placeholders can now contain order information, e.g. instead of
* 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
* translators to re-order the output of data while ensuring it remains correct
*
* You do not need this where single placeholders are used, e.g. 'Message %d' is fine
* equally where a string contains only two placeholders which are used to wrap text
* in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 ***************************************************************************/

$lang = array_merge($lang, array(

	'ADD_BLOCK'							=> 'Ajouter un block',
	'ADMIN'								=> 'Administrateur',	
	'ALL'								=> 'Tous',	
	'ANNUL'								=> 'Annuler',	
	'BLOCK_ACTIV'						=> 'Activation du block',
	'BLOCK_ACTIVE'						=> 'Activation',
	'BLOCK_ACTIV_LAXCISTE'				=> 'Permet d\'activer ou de désactiver le block sur le portal.',	
	'BLOCK_CENTRE'						=> 'Insdisponible',
	'BLOCK_CENTRES'						=> 'Blocks du centre',
	'BLOCK_HTML'						=> 'Fichier html',
	'BLOCK_HTML_LAXCISTE'				=> 'Sélectionner le fichier *.html pour votre block.',		
	'BLOCK_NAME'						=> 'Nom du block',
	'BLOCK_NAME_LAXCISTE'				=> 'Nom du block affiché dans l\'admin.',	
	'BLOCK_ORD'							=> 'Ordre:',	
	'BLOCK_ORDER'						=> 'Ordre',
	'BLOCK_ORD_LAXCISTE'				=> 'Permet de déterminer l\'ordre d\'affichage sur le portal<br>Ne modifier que dans le cas d\'une erreur d\'ordre',
	'BLOCK_POS'							=> 'Colonne',
	'BLOCK_REMOVED'						=> 'Block supprimé avec succes',
	'BLOCK_UPDATED'						=> 'Mise a jour éffectuée avec succes',
	'BLOC_BAS'							=> 'Blocks du bas',
	'BLOC_DISABLE_EX'					=> 'Block désactivé',	
	'BLOC_DROIT'						=> 'Blocks de droite',
	'BLOC_GAUCHE'						=> 'Blocks de gauche',
	'BLOC_HAUT'							=> 'Blocks du haut',
	'BLOC_NAME_EDIT'					=> 'Edition du block :',
	'BLOC_ORD'							=> 'Ordre :',	
	'BLOC_ORD_LAXCISTE'					=> 'Permet de determiner la colonne dans la quelle sera affiché le block sur le portal.',	
	'BLOC_POSITION'						=> 'Dernière position',	
	'BLOC_POSITION_LAXCISTE'			=> 'Sélectionner comme pour la colonne ci dessus',	
	'COOPYRIGHT'						=> 'copyright - By - sjpphppbb - gigi_online  http://sjpphpbb.net/phpbb3/',
	'CURRENT_VERSION'					=> 'Version actuelle installée',	
	'DISABLE_BLOC'						=> 'Activer',
	'ENABLE_BLOC'						=> 'Desactiver',
	'GUESTS'							=> 'Visiteur',	
	'ICON_DELETE'						=> 'Permet de supprimer les blocks que vous avez ajouté, les blocks d\'origine ne sont pas supprimables.',
	'ICON_EDIT'							=> 'Permet d\'éditer les blocks que vous avez ajouté, les blocks d\'origine ne sont pas éditables.',
	'ICON_MOVE_BOTOM'					=> 'Permet de faire descendre le block dans la colonne inférieure',
	'ICON_MOVE_BOTON_DIRECT'			=> 'Permet de faire descendre le block directement dans la colonne du bas',	
	'ICON_MOVE_DOWN'					=> 'Permet de faire descendre le block d\'une position',
	'ICON_MOVE_LEFT'					=> 'Permet de faire passer le block dans la colonne directement à sa gauche',	
	'ICON_MOVE_LEFT_DIRECT'				=> 'Permet de faire passer le block directement dans la colonne de gauche',	
	'ICON_MOVE_RIGHT'					=> 'Permet de faire passer le block dans la colonne directement à sa droite',
	'ICON_MOVE_RIGHT_DIRECT'			=> 'Permet de faire passer le block directement dans la colonne de droite',	
	'ICON_MOVE_TOP'						=> 'Permet de faire monter le block dans la colonne supérieure',
	'ICON_MOVE_TOP_DIRECT'				=> 'Permet de faire monter le block directement dans la colonne du haut',
	'ICON_MOVE_UP'						=> 'Permet de faire monter le block d\'une position',
	'LATEST_VERSION'					=> 'Dernière version disponible.',
	'LAXCISTE_ACP_PORTAL'				=> 'SjpPortal-phpBB3',	
	'LAXCISTE_ACP_PORTAL_INCLUDE_BLOCK'	=> 'Gestion de l\'Affichage des blocks',
	'LAXCISTE_ACP_PORTAL_INCLUDE_BLOCK2'=> 'Vous pouvez sélectionner ici les blocks qui seront affichés ou pas sur le portal.',
	'LAXCISTE_ACP_PORTAL_INCLUDE_BLOCK_NEW'	=> 'L\'ajout d\'un nouveau block implique que les fichiers pour ce block soient uploadés sur le serveur dans leurs répertoires respectifs ',	
	'LAXCISTE_ACP_PORTAL_INCLUDE_BLOCK_PERM' => 'Gestion de permissions du Block.',	
	'LEGENDE_ICON'						=> 'Voir la Légende des icones',	
	'LEGENDE_PORTAL'					=> 'Fermer la Légende des icones',
	'LEGENDE_PORTAL_OPTION'				=> 'Pour toutes les options suivantes vous devez faire descendre le block concerné en dernière position de sa colonne.',	
	'MOD'								=> 'Moderateur',
	'MUST_SELECT_BLOCK'					=> 'Erreur de sélection',
	'NONE'								=> 'Ne pas afficher',
	'OFFLIGNE'							=> 'Indique le block comme désactivé permet en cliquant dessus de l\'activer ',
	'ONLIGNE'							=> 'Indique le block comme activé et permet en cliquant dessus de le désactiver ',
	'PERM' 								=> 'Permissions du Block :',
	'PERMS' 							=> 'Permissions du block &nbsp;<i>(Tous le monde)</i>.&nbsp;Vous pouvez changer de permissions en cliquant sur l\'image:',
	'PERM_ADM' 							=> 'Permissions du block &nbsp;<i>(Administrateur(s))</i>.&nbsp;Vous pouvez changer de permissions en cliquant sur l\'image:',		
	'PERM_EXPLAIN' 						=> 'Permet de séléctionner qui pourra voir ce block :',
	'PERM_MOD' 							=> 'Permissions du block &nbsp;<i>(Moderateurs(s))</i>.&nbsp;Vous pouvez changer de permissions en cliquant sur l\'image:',	
	'PERM_REG' 							=> 'Permissions du block &nbsp;<i>(Enregistrés)</i>.&nbsp;Vous pouvez changer de permissions en cliquant sur l\'image:',
	'REG'								=> 'Enregistrer',
	'RESET_INCLUDE_BLOCK'				=> 'Annuler',
	'SUBMIT_INCLUDE_BLOCK'				=> 'Sauvegarder',
	'U_DEL'								=> 'Attention : Avant de supprimer ce block vous devez le faire descendre en dernière position de cette colonne.',	
	'VERSION_CHECK'						=> 'Version actuelle du SjpPortal-PhpBB3.',
	'VERSION_CHECK_EXPLAIN'				=> 'Votre version du SjpPortal-PhpBB3 n’est pas à jour. Vous trouverez ci-dessous un lien vers l’annonce de sortie pour la dernière version, et les instructions pour effectuer cette mise à jour.',		
	'VERSION_DONLOAD'					=> 'Téléchargement et instructions d\'install sur sjpphpbb.net.',	
	'VERSION_NOT_UP_TO_DATE_ACP'		=> 'Votre version n\'est pas a jour.',
));

?>