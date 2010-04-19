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
 
		'ACP_MENU_EXPLAIN'			=> 'Menu management',
		'ACP_MENU__EXPLAIN'			=> 'Menu management displayed on the portal',
		'ACTION'					=> 'Action',
		'ADD_URL'					=> 'Add a link',		
		'ADMIN'						=> 'Administrator',			
		'COOPYRIGHT'				=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',		
		'MENU_ADDED'				=> 'Link successfully added',
		'MENU_REMOVED'				=> 'Link successfully removed',			
		'MENU_UPDATED'				=> 'Link uccessfully updated',
		'MOD'						=> 'Moderator',
		'MUST_SELECT_MENU'			=> 'Select',
		'NAME_LIEN'					=> 'Link name',
		'NOM_URL_EXPLAIN'			=> 'Link name displayed in Portal menu',
		'NONE'						=> 'No display',
		'ORDER'						=> 'Display order',
		'ORDER_EXPLAIN_2'			=> 'For a new link, make an increment of 1.<br> Example : if the latest link added is n° 9, <br> make an increment to 10.',
		'ORDRE'						=> 'Order',		
		'PORTAL_NAV'				=> 'Browsing',
		'REG'						=> 'Registered',
		'RESET_MENU'				=> 'Delete',		
		'STAFF'						=> 'Team',
		'URL_EXPLAIN'				=> 'Url of opening window',
		'URL_EXPLAIN_2'				=> 'The url can be written as followed. Example : <br>index.php for internal links, <br>http://google.fr for external links',		
		'URL_IMG'					=> 'Image url displayed in Menu links',	
		'URL_IMG_2'					=> 'Tip image ',		
		'URL_IMG_EXPLAIN'			=> 'Image Url displayed in Menu links',
		'URL_IMG_EXPLAIN2'			=> 'Click on the selected image',		
		'URL_LIEN'					=> 'Link url',
		'VIEW_BY'					=> 'Viewed by',
		'VIEW_BY_EXPLAIN'			=> 'Determines who can view the link on the portal',		
   ));


?>