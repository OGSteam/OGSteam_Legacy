<?php
/***************************************************************************
* block_announcments_lang (Additional variables used by portal)
* @package language fran�ais
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
	'ACP_PORTAL_CONFIG_ANNOUNCMENT'				=> 'Gestion de l\'affichage des annonces',
	'ACP_PORTAL_CONFIG_ANNOUNCMENT_EXPLAIN'		=> 'Vous pouvez gérer ici le nombre d\' annonces à afficher, le nombre de jours d\'affichage, le nombre de caractères à afficher , les forums qui seront sélectionnés pour l\'affichage des annonces.',	
	'ANNOUNCMENTS'		=> 'Annonces',
	'A_DAY'				=> 'Jours',
	'A_DAY_EXPLAIN'		=> 'Nombre de jours que doivent être affichés les annonces.',
	'A_FORUM'			=> 'Id forum',
	'A_FORUM_EXPLAIN'	=> 'Id des forums à sélectionner pour l\' affichage des annonces.Pour plusieurs forums séparer les id par des virgules.Exemple : 1,3,5.',
	'A_LENGTH'			=> 'Caractères',
	'A_LENGTH_EXPLAIN'	=> 'Nombre de caractères qui  doivent être affichés dans les annonces.',
	'A_NOMBER'			=> 'Nomb*',
	'A_NOMBER_EXPLAIN'	=> 'Nombre d\'annonces afficher sur le portal.',
	'COMMENTS'			=> 'Commentaires',
	'CONFIG_ADDED'		=> 'Mise a jour effectuée avec succès',	
	'CONFIG_UPDATED'	=> 'Mise a jour effectuée avec succès',
	'COOPYRIGHT'		=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',		
	'NEWS'			    => 'Nouvelles',
	'NO_NEWS'			=> 'Aucune nouvelle',
	'POLL'			    => 'Sondage',
	'POSTED_BY'			=> 'Posté par',
	'POST_REPLY'		=> 'Ecrire des commentaires',
	'READ_FULL'			=> 'Tout voir',
	'RESET_CONFIG' 		=> 'Réinitialisé',	
	'VIEW_COMMENTS'		=> 'Voir les commentaires',
	
));

?>
