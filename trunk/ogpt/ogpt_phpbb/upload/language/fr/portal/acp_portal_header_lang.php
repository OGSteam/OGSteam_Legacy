<?php
/***************************************************************************
* header_portal_lang (Additional variables used by portal)
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

		'ACP_HEADER'				=> 'Gestion du Header du Portal.',	
		'ACP_HEADER_EXPLAIN' => 'Voici un aperçu du Header du portal tel qu\'il sera affiché.<br>L\'image affichée actuellement dans l\'Admin est celle du thême prosilver',
		'ACTION'					=> 'Action',
		'ACT_HEA'					=> 'Activation : ',	
		'ACT_HEA_EXPLAIN'			=> 'Vous pouvez choisir pour vôtre portal le header portal ou le header classique de vôtre thême.',	
		'ADD_LINK'					=> 'Ajouter',	
		'ADMIN'						=> 'Administrateur',			
		'ALL'						=> 'Tous',		
		'ALL'						=> 'Tous',
		'BUL'						=> 'Nom du lien : ',	
		'BUL_EXPLAIN'				=> 'Nom du lien qui sera affiché dans la bulle au survol du lien avec la souris.',	
		'COOPYRIGHT'				=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',
		'DIM_EXPLAIN'				=> 'Indiquer la largeur et la hauteur de vôtre image ',	

		'DIM_HEIGHT'				=> 'Hauteur :',	
		'DIM_IMG'					=> 'Dimmensions ',		
		'DIM_WIDTH'					=> 'Largeur :',
		'EDIT_EXPLAIN'				=> 'Gestion les liens du Header portal : ',	
		'GUESTS'					=> 'Visiteur',
		'HEADER_EDITER' 			=> 'Editer :',
		'HEADER_IMG_ADDED'			=> 'Lien ajouté avec Succès',
		'HEADER_IMG_REMOVED'		=> 'Lien supprimé avec Succès',
		'HEADER_IMG_UPDATED'		=> 'Lien modifié avec Succès',	
		'HEADER_LOGO_IMG' 			=> 'Header du portal',	
		'HEADER_LOGO_IMG_EXPLAIN' 	=> 'Gestion des liens du Header du Portal.<br>Les images afficher actuellement dans l\'Admin sont celles du thême prosilver',
		'HEADER_LOGO_UPDATED'		=> 'Logo modifié avec Succès',	
		'IMAGE'						=> 'Image : ',
		'IMAGES'					=> 'Image',	
		'IMAGE_EXPLAIN'				=> 'Sélectionner l\'image pour ce lien<br>Les images doivent êtres uploadées dans le répertoire /styles/VOTRE THEME/thême/images/icon_header/ et doivent avoir le prefix header_   Ex: header_mon_image.gif .jpg ou png Et doit avoir le même nom pour tout vos thêmes.<br>Vous pouvez avoir des images différantes pour vos differants thêmes.',	
		'IMG_PERM_FORUM'			=> 'Forum : ',

		'IMG_PERM_PORTAL'			=> 'Portal : ',		
		'LOG_IMG'					=> '<b>Logo qui sera affiché dans le Header de vôtre portal :</b>',
		'LOG_IMG_EXPLAIN'			=> 'L\'image pour vôtre logo doit être uploadée dans le repertoire /styles/VOTRE THEME/thême/images/icon_header/<br> Vous devez donner uniquement le nom de l\'image. Ex : logo.gif Et doit avoir le même nom pour tout vos thêmes.',
		'MOD'						=> 'Moderateur',
		'MUST_SELECT_HEADER_IM'	=> 'Lien selectionné',
		'NOM_NAM'					=> 'Nom du lien',
		'NONE'						=> 'Ne pas afficher',
		'PERM'						=> 'Permission ',	
		'REG'						=> 'Enregistré',
		'RESET'						=> 'Annuler',		
		'SIT_DESC'					=> 'Description du site : ',	
		'SIT_DESC_EXPLAIN'			=> 'Indiquer la description du site qui sera sur le header du le portal ',	
		'SIT_NAM'					=> 'Nom du site : ',
		'SIT_NAM_EXPLAIN'			=> 'Indiquer le nom du site qui sera affiché sur le header du le portal ',	
		'STAFF'						=> 'Team',
		'URL'						=> 'Url du lien',
		'URL_EXPLAIN'				=> 'Url du lien a ouvrir. Pour les liens interne vous pouvez metre l\'url relative Ex : index.php',		
		'VIEW_BY'					=> 'Permissions',	
		'VIEW_BY_EXPLAIN'			=> 'Vous pouver définir qui poura voir le lien sur le Header du Portal',	
	

));

?>
