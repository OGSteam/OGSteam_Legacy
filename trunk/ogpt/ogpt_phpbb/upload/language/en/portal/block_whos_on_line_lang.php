<?php
/***************************************************************************
* block_whos_on_line_lang (Additional variables used by portal)
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

		'COOPYRIGHT'		=> 'copyright - By - sjpphppbb http://sjpphpbb.net/phpbb3/',		
		'FILES_ATTACHMENTS'			=> 'Attachments statistics',
		'FILES_PER_DAY'				=> 'Attachments per day',
		'FILES_PER_POST'			=> 'Attachments per post',
		'FILES_PER_TOPIC'			=> 'Attachments per topic',
		'FILES_PER_USER'			=> 'Attachments per user',
		'POSTS_PER_DAY'				=> 'Posts per day',
		'POSTS_PER_TOPIC'			=> 'Posts per topic',
		'POSTS_PER_USER'			=> 'Posts per user',
		'STATISTICS2'				=> 'We have',		
		'STATISTICS3'				=> 'Forum contains',
		'STATISTICS4'				=> 'In',
		'STAT_DISABLE'				=> 'Hide Statistics',
		'STAT_ENABLE'				=> 'Display Statistics',
		'STAT_MEMBRE'				=> 'Users statistics',
		'STAT_NEW_POSTS'			=> 'New post',
		'STAT_NEW_TOPICS'			=> 'New topic',		
		'STAT_POSTE'				=> 'Posts statistics',
		'TOPICS_PER_DAY'			=> 'Topics per day',
		'TOPICS_PER_USER'			=> 'Topics per user',
		'TOTAL_ATTACHMENTS_OTHER'	=> 'Total attachements <strong>%d</strong>',
		'TOTAL_ATTACHMENTS_ZERO'	=> 'Total attachment <strong>0</strong>',
		'TOTAL_FILES_OTHER'			=> 'Total files other',
		'TOTAL_FILES_ZERO'			=> 'Total files 0',		
		'TOTAL_POSTERS_OTHER'		=> 'Total posters <strong>%d</strong>',
		'TOTAL_POSTERS_ZERO'		=> 'Total poster <strong>0</strong>',    
		'USERS_PER_DAY'				=> 'Users per day',
   ));


?>