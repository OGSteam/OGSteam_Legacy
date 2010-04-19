<?php
/***************************************************************************
*block_attachments_lang (Additional variables used by portal)
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
		
	'ACP_PORTAL_ATTACH'		=> 'Gestion des fichiers joints',	
	'ACP_PORTAL_CONFIG_ATTACH'			=> 'Gestion de l\'affichage des fichiers joints',
	'ACP_PORTAL_CONFIG_ATTACH_EXPLAIN'	=> 'Vous pouvez gérer ici le nombre de fichiers joints à afficher, les forums qui seront sélectionnés pour l\'affichage des fichiers joints.',	
	'ATTACH_NOMBER'			=> 'Nomb*',
	'ATTACH_NOMBER_EXPLAIN'	=> 'Nombre de fichiers joints affichés sur le portal.',
	'ATTACH_TITLE'			=> 'Nom du block',
	'ATTACH_TITLE_EXPLAIN'	=> 'Le nom qui sera affiché en titre du block',	
	'CONFIG_ADDED'			=> 'Mise a jour effectuée avec succès.',
	'CONFIG_UPDATED'		=> 'Mise a jour effectuée avec succès.',
	'COOPYRIGHT'			=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',				
	'RESET_CONFIG' 			=> 'Réinitialisé',	
	'TOP_COUNT'         	=> 'Téléchargé',
	'TOP_DATE'         		=> 'Posté le',
	'TOP_FILENAME'         	=> 'Fichiers',
	'TOP_FILESIZE'         	=> 'Taille',
	'TOP_TEL'         		=> 'Top Téléchargements',
	'TOP_X'         		=> 'Fois',
		
   ));


?>