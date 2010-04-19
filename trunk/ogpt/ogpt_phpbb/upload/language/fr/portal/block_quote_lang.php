<?php
/***************************************************************************
* block_quote_lang (Additional variables used by portal)
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

	'ACP_MANAGE_QUOTE'			=> 'Ajouter, editer une Citation.',
	'ACP_QUOTE_EXPLAIN'			=> 'Gestion des citations.',
	'ACP_QUOTE__EXPLAIN'		=> 'Vous pouvez ajouter, supprimer, editer des citations.',
	'ADD_QUOTE'					=> 'Ajouter',
	'AUTHOR'					=> 'Auteur :',
	'COOPYRIGHT'				=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',
	'DISABLE'					=> '<b>Block activé</b>',
	'DISABLE_BLOC'				=> 'Activer',
	'ENABLE'					=> '<b>Block désactivé</b>',
	'ENABLE_BLOC'				=> 'Desactiver',
	'MUST_SELECT_QUOTE'			=> 'Citation selectionnée',
	'QUOTE'						=> 'Citations :',
	'QUOTE_ADDED'				=> 'Citation ajoutée avec succès',
	'QUOTE_DISABLE'				=> '<b>Activation</b>',
	'QUOTE_DISABLE_EXPLAIN'		=> '<b>Activation :</b><br>Affichage du block sur le forum.',
	'QUOTE_DISABLE_EXPLAIN2'	=> 'Vous pouvez activer ou de désactiver l\'affichage du block sur le forum : ',
	'QUOTE_REMOVED'				=> 'Citation supprimée avec succès',
	'QUOTE_TITRE' 				=> '<strong>Titre du block</strong>',
	'QUOTE_TITRE_BLOC_ADDED' 	=> 'Titre block ajouté avec succès',
	'QUOTE_TITRE_BLOC_UPDATED' 	=> 'Titre modifié avec succès',
	'QUOTE_TITRE_EDITER' 		=> 'Editer',
	'QUOTE_TITRE_EXPLAIN' 		=> 'Vous pouvez changer le titre du block, qui sera affiché en entête du block citation sur l’index du forum.',
	'QUOTE_TITRE_EXPLAIN_BLOC' 	=> 'Vous permet de mettre un titre en entête du block <br> qui sera affiché sur l\'index du forum',
	'QUOTE_TITRE_INFOS' 		=> 'Informations sur le titre',
	'QUOTE_UPDATED'				=> 'Citation modifiée avec succès',
	'RESET_QUOTE' 				=> 'Réinitialisé',

));

?>