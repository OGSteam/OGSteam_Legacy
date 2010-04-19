<?php
/***************************************************************************
* block_horoscope_lang (Additional variables used by portal)
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
		
		'ZODIAC'         				=> 'Horoscope',

		'ARIES'         				=> 'Bélier',
		'TAURUS'         				=> 'Taureau',
		'GEMINI'         				=> 'Gémeaux',
		'CANCER'         				=> 'Cancer',
		'LEO'         					=> 'Lion',
		'VIRGO'         				=> 'Vierge',
		'LIBRA'         				=> 'Balance',
		'SCORPIO'         				=> 'Scorpion',
		'SAGITTARIUS'         			=> 'Sagittaire',
		'CAPRICON'         				=> 'Capricorne',
		'AQUARIUS'         				=> 'Verseau',
		'PISCES'         				=> 'Poissons',

   ));


?>