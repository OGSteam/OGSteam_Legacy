<?php
/***************************************************************************
* block_news_lang (Additional variables used by portal)
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

	'ACP_PORTAL_CONFIG_NEWS'				=> 'News display Management',
	'ACP_PORTAL_CONFIG_NEWS_EXPLAIN'		=> 'Here you can manage the amount of news to be displayed, the period of display, the number of caracters and the forums where to display them.',	
	'ACP_PORTAL_NEWS'	=> 'News Management',	
	'A_DAY'				=> 'Days',
	'A_DAY_EXPLAIN'		=> 'Period of news display.',
	'A_FORUM'			=> 'Forum Id ',
	'A_FORUM_EXPLAIN'	=> 'Forum Id selection for News display. In case of several forums, separate Ids with a comma. Example: 1,3,5 .',
	'A_LENGTH'			=> 'Caracters',
	'A_LENGTH_EXPLAIN'	=> 'Number of caracters contained in displayed news.',
	'A_NOMBER'			=> 'Number',
	'A_NOMBER_EXPLAIN'	=> 'Amount of news displayed on the portal.',
	'A_TITLE'			=> 'Block Name',
	'A_TITLE_EXPLAIN'	=> 'Title that will appear in the block header',	
	'COMMENTS'			=> 'Comments',
	'CONFIG_ADDED'		=> 'Successfully added',
	'CONFIG_UPDATED'	=> 'Successfully updated',
	'COOPYRIGHT'		=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',		
	'NEWS'			    => 'News',
	'NO_NEWS'			=> 'No news',
	'POLL'			    => 'Poll',
	'POSTED_BY'			=> 'Posted by',
	'POST_REPLY'		=> 'Reply',
	'READ_FULL'			=> 'View all',
	'RESET_CONFIG' 		=> 'Reset',	
	'VIEW_COMMENTS'		=> 'View comments',
));

?>
