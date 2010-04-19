<?php
/***************************************************************************
* block_acp_portal_config_lang (Additional variables used by portal)
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


//Menu portal
$lang = array_merge($lang, array(    
	
	'ACP_PORTAL_CONFIG_EXPLAIN'	=> 'Blocks Management',
	'ACP_PORTAL_CONFIG_EXPLAIN2' => 'Here you can determine the amount of data to be displayed in the following blocks :',
	'ACP_PORTAL_CONFIG_PACING3' => 'Here you can determine the spacing between columns and their width. ',
	'ACTION' 				=> 'Action.',
	'CONFIG_ADDED' 			=> 'Successfully added ',	
	'CONFIG_UPDATED' 		=> 'Successfully updated ',
	'COOPYRIGHT'			=> 'copyright - By - sjpphppbb  http://sjpphpbb.net/phpbb3/',
	'DROITE' 				=> 'Width of the right column',
	'FORUM_EXCEPT'           	=> 'Excluded from forum',
	'FORUM_EXCEPT_EXPLAIN'      => 'You can exclude certains forums from the Recent topic Block.<br>You must indicate one or several IDs and separate them with a comma if necessary:Ex : 1,2,3',
	'GAUCHE' 				=> 'Width of the left column',	
	'NAME_BLOC' 			=> 'Block Name ',	
	'NOM_BLOC' 				=> 'Block Name',
	'NOM_BLOC_EXPLAIN' 		=> 'Name that will appear in the block header',
	'NOM_DROITE_EXPLAIN' 	=> 'Determines the width of the right column. A value between 180 and 200 pixels is reasonable.',
	'NOM_GAUCHE_EXPLAIN' 	=> 'Determines the value of the left column. A value between 180 and 200 pixels is reasonable.',	
	'NOM_VALUE' 			=> 'Amount of displayed data',
	'NOM_VALUE_EXPLAIN' 	=> 'Determines the number of displayed lines.<br>Example : the 5 latest registered members.',
	'NONE' 					=> 'No',
	'NOT_AVAILABLE' 		=> 'Not available ',
	'N_AFF' 				=> 'Amount of displayed data', 
	'PACING' 				=> 'Spacing between columns',	
	'PACING_BLOC_EXPLAIN' 	=> 'Determines the spacing between each column. A spacing of 2 is reasonable.',
	'RESET_CONFIG' 			=> 'Delete',
	'SCROLL_BLOC' 			=> 'Scroll',
	'SCROLL_BLOC_EXPLAIN' 	=> 'Data Display in the block with the help of a scroll bar if necessary.',	
	'SCROOL' 				=> 'Scroll',
	'YES' 					=> 'Yes',	

));
?>