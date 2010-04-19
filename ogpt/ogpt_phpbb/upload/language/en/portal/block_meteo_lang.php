<?php
/***************************************************************************
* block_meteo_lang (Additional variables used by portal)
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

	'ACP_METEO_EXPLAIN'			=> 'Weather',
	'LAXCISTE_METEO_ADMIN'		=> 'Weather block Management',
	'LAXCISTE_METEO_ADMIN2'		=> 'Here you can fill in information about the title, the background colours and text colours of your Weather Block, so you can adapt it to your template.',
	'LAXCISTE_METEO_ADMIN3'		=> 'Fill in text fields',
	'LAXCISTE_METEO_COPYRIGHT'	=> 'copyright - By - sjpphppbb  http://sjpphpbb.net/phpbb3/',
	'METEO'						=> 'Weather :',	
	'METEO_FOND'				=> 'Here you can enter the background colour code of your Weather Block. This code must be written under the form 000000 without #.',
	'METEO_TEXTE'				=> 'Here you can enter the text colour code of your Weather Block. This code must be written under the form 000000 without #.',
	'METEO_TITRE'				=> 'Here you can enter the title of your Weather Block which will appear in the header of your Weather Block.',
	'METEO_UPDATED'				=> 'Updated',
	'METEO_USER_EXPLAIN'		=> 'Here you can fill in the name of your home city, so that its weather forecast can be displayed on the Weather Block in the portal.',
	'METEO_USER_EXPLAIN1'		=> 'Weather',
	'RESET'						=> 'Delete',
	'SAVE'						=> 'Save',

));

?>