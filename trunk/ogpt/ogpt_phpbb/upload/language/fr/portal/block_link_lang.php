<?php
/***************************************************************************
* block_link_lang (Additional variables used by portal)
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

	'ACP_LINK_EXPLAIN'			=> 'Block link',
	'COOPYRIGHT'			=> 'copyright - By - sjpphppbb  http://sjpphpbb.net/phpbb3/',	
	'LAXCISTE_LINK_ADMIN'		=> 'Administration du bloc Link',
	'LAXCISTE_LINK_ADMIN2'		=> 'Vous pouvez donner dans ce formulaire les informations du bloc link',
	'LAXCISTE_LINK_ADMIN3'		=> 'Renseigner les champs',
	'LAXCISTE_LINK_COPYRIGHT'	=> 'copyright - By - sjpphppbb http://sjpphpbb.net',
	'LINK'						=> 'Url de votre site',
	'LINK_UPDATED'				=> 'Mise a jour effectuée',
	'LOGO'						=> 'Url du logo',	
	'RESET'						=> 'Annuler',
	'SAVE'						=> 'Sauvegarder',
	'SITE_LINK_TXT'   			=> 'Mettre un lien',		
	'SITE_LINK_TXT_EXPLAIN'   	=> '<br />Le code HTML ci-dessous contient tout le code nécessaire pour mettre un lien vers <b>Ce site</b> SVP ajoutez le librement à votre site.<br /><br />',			
	'SITE_LINK_TXT_EXPLAIN2' 	=> 'Effet du code ci-dessus :',
));

?>