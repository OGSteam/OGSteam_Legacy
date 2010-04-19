<?php
/***************************************************************************
* block_announcments_lang (Additional variables used by portal)
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
	'ACP_PORTAL_CONFIG_ANNOUNCMENT'				=> 'Announcements display Management',
	'ACP_PORTAL_CONFIG_ANNOUNCMENT_EXPLAIN'		=> 'Here you can manage the number of announcements to be displayed , the period of display, the number of caracters, the selected forums of display.',
	'ANNOUNCMENTS'		=> 'Announcements',
	'A_DAY'				=> 'Days',
	'A_DAY_EXPLAIN'		=> 'Number of days of Announcement display.',
	'A_FORUM'			=> 'Forum Id ',
	'A_FORUM_EXPLAIN'	=> 'Forums Ids selected for Announcement display.In case of several forums, separate Ids with commas. Example : 1,3,5.',
	'A_LENGTH'			=> 'Caracters',
	'A_LENGTH_EXPLAIN'	=> 'Number of caracters displayed in Announcements.',
	'A_NOMBER'			=> 'Number displayed',
	'A_NOMBER_EXPLAIN'	=> 'Number of announcements displayed on the portal.',
	'COMMENTS'			=> 'Comments',
	'CONFIG_ADDED'	=> 'Successfully updated',	
	'CONFIG_UPDATED'	=> 'Successfully updated',
	'COOPYRIGHT'				=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',		
	'NEWS'			    => 'News',
	'NO_NEWS'			=> 'No news',
	'POLL'			    => 'Polls',
	'POSTED_BY'			=> 'Posted by',
	'POST_REPLY'		=> 'Reply',
	'READ_FULL'			=> 'View all',
	'RESET_CONFIG' 		=> 'Reset',	
	'VIEW_COMMENTS'		=> 'View comments',
	
));

?>
