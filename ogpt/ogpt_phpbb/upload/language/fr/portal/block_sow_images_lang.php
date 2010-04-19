<?php
/***************************************************************************
* block_sow_images_lang (Additional variables used by portal)
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

	'ACP_MANAGE_SOW_IMAGES'		=> 'Sow Images.',
	'ACP_SOW2__EXPLAIN'			=> 'Vous pouvez ajouter, editer, supprimer  des sow images.',
	'ACP_SOW_EXPLAIN'			=> 'Gestion des sow images.',
	'ACP_SOW_EXPLAIN_TITRE_BLOC'=> 'Editer le titre du block',
	'ADD_SOW'					=> 'Ajouter',
	'COOPYRIGHT'				=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',
	'HEIGHT'					=> 'Hauteur de l\'image',
	'ID'						=> 'id',
	'IMAGE_EXPLAIN'				=> 'Vous devez mettre le lien de l’image <br> sous la forme :<br> http://sjpphpbb.net/sjpphpbb_logo.gif',
	'INFO'						=> 'Lien',
	'INFO3'						=> 'Commentaire',
	'INFO_EXPLAIN'				=> 'Vous pouvez mettre un lien vers un site ou autre sous la forme : http://sjpphpbb.net/index.net',
	'INFO_LIEN'					=> 'Voir Site',
	'MUST_SELECT_SOW'			=> 'Sow selectionné',
	'NO'						=> 'N°:',
	'RESET_SOW' 				=> 'Réinitialisé',
	'SOW_ADDED'					=> 'Sow ajouté avec Succès',
	'SOW_REMOVED'				=> 'Sow supprimé avec Succès',
	'SOW_TITRE' 				=> '<strong>Titre du block</strong>',
	'SOW_TITRE_BLOC_ADDED' 		=> 'Titre Sow ajouté avec Succès',
	'SOW_TITRE_BLOC_UPDATED' 	=> 'Titre modifié avec Succès',
	'SOW_TITRE_EDITER' 			=> 'Editer',
	'SOW_TITRE_EXPLAIN' 		=> 'Vous pouvez changer le titre du block, qui sera affiché en entête du block sow images sur le portal.',
	'SOW_TITRE_EXPLAIN_BLOC' 	=> 'Vous permet de mettre un titre en entête du block <br> qui sera affiché sur le portal',
	'SOW_TITRE_INFOS' 			=> 'Informations sur le titre',
	'SOW_UPDATED'				=> 'Sow modifié avec Succès',
	'TITRE'						=> 'titre',
	'WIDTH'						=> 'Largeur de l\'image',
 	'HEIGHT_EXPLAIN'			=> 'Hauteur de l’image affichée sur l’index. ',	
 	'INFO3_EXPLAIN'				=> 'Vous pouvez ajouter un commentaire <br>qui sera affiché en dessous des images.',
 	'TITRE_EXPLAIN'				=> 'Vous pouvez ajouter un nom<br>qui sera affiché en dessous des images. ',	
 	'WIDTH_EXPLAIN'				=> 'Largeur de l’image affichée sur l’index.',


));

?>
