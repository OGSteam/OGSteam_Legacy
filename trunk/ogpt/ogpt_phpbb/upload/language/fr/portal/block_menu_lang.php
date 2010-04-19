<?php
/***************************************************************************
* block_menu_lang (Additional variables used by portal)
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
		'ACP_MENU_EXPLAIN'			=> 'Gestion du menu',
		'ACP_MENU__EXPLAIN'			=> 'Gestion du menu qui est affiché sur le portal<br>Vous pouvez ajouter, editer, supprimer  un lien.',
		'ACTION'					=> 'Action',
		'ADD_URL'					=> 'Ajouter un lien',		
		'ADMIN'						=> 'Administrateur',			
		'ALL'						=> 'Tous',
		'COOPYRIGHT'				=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',		
		'MENU_ADDED'				=> 'Lien ajouté avec succès',
		'MENU_REMOVED'				=> 'Lien supprimé avec succès',			
		'MENU_UPDATED'				=> 'Mise a jour effectuée avec succès',
		'MOD'						=> 'Moderateur',
		'MUST_SELECT_MENU'			=> 'Sélectionner',
		'NAME_LIEN'					=> 'Nom du lien',
		'NOM_URL_EXPLAIN'			=> 'Nom du lien qui sera affiché dans le menu du portal',
		'ORDRE'						=> 'Ordre',		
		'PORTAL_NAV'				=> 'Navigation',
		'REG'						=> 'Enregistré',
		'RESET_MENU'				=> 'Annuler',		
		'URL_EXPLAIN'				=> 'Url pour la page a ouvrir',		
		'URL_EXPLAIN_2'				=> 'L\'url peut être mise sous la forme. Exemple : <br>index.php pour les lien internes, <br>http://google.fr pour les lien externes',		
		'URL_IMG'					=> 'Url de l\'image qui est affichée devant les liens du menu',	
		'URL_IMG_2'					=> 'Image',		
		'URL_IMG_EXPLAIN'			=> 'Image qui sera affichée devant les liens du menu',
		'URL_IMG_EXPLAIN2'			=> 'Les images doivent ce trouver dans le repertoire images/icon_menu/',		
		'URL_LIEN'					=> 'Url du lien',
		'VIEW_BY'					=> 'Vu par',
		'VIEW_BY_EXPLAIN'			=> 'Détermine qui peut voir le lien sur le portal',		
	
		
   ));


?>