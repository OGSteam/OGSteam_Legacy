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
		
	'ACP_PORTAL_ATTACH'		=> 'Attachments Management',	
	'ACP_PORTAL_CONFIG_ATTACH'			=> 'Attachments display Management',
	'ACP_PORTAL_CONFIG_ATTACH_EXPLAIN'	=> 'Here you can manage the number of attached files to be displayed and the forums where to display them.',	
	'ATTACH_NOMBER'			=> 'Number',
	'ATTACH_NOMBER_EXPLAIN'	=> 'Number of attached files displayed on the portal.',
	'ATTACH_TITLE'			=> 'Block name',
	'ATTACH_TITLE_EXPLAIN'	=> 'Block title',	
	'CONFIG_ADDED'			=> 'Successfully added.',
	'CONFIG_UPDATED'		=> 'Successfully updated.',
	'COOPYRIGHT'			=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',				
	'RESET_CONFIG' 			=> 'Reset',	
	'TOP_COUNT'         	=> 'Dowloaded',
	'TOP_DATE'         		=> 'Posted on',
	'TOP_FILENAME'         	=> 'Files',
	'TOP_FILESIZE'         	=> 'Size',
	'TOP_TEL'         		=> 'Top Downloadings',
	'TOP_X'         		=> 'Times',
		
   ));


?>