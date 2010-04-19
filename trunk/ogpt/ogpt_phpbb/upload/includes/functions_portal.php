<?php
/** 
*
* @package phpBB3
* @copyright (c) Michael O'Toole 2005 phpBBireland 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
* Last updated: 14 February 2007
*/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $phpbb_root_path;

// Portal define tables
define('SOW_TABLE', $table_prefix . 'portal_sow');
define('SOW_TITRE_TABLE', $table_prefix . 'portal_sow_titre');
define('QUOTE_TABLE', $table_prefix.'portal_quote');
define('QUOTE_TITRE_TABLE', $table_prefix . 'portal_quote_titre');
define('MESS_BOARD_TABLE', $table_prefix.'portal_mess_board');
define('HOROSCOPE_TITRE_TABLE', $table_prefix . 'horoscope_titre');
define('MENU_TABLE', $table_prefix.'portal_menu');
define('METEO_TABLE', $table_prefix.'portal_meteo');
define('MENU_TABLE', $table_prefix.'portal_menu');
define('PORTAL_CONFIG_BLOCK_TABLE', $table_prefix.'portal_config_block');
define('PORTAL_CONFIG_COLL_TABLE', $table_prefix.'portal_config_coll');
define('PORTAL_CONFIG_COLL_INDEX_TABLE', $table_prefix.'portal_config_coll_index');
define('PARTENAIRES_TABLE', $table_prefix.'portal_partenaires');
define('PORTAL_ANNOUNCMENTS_TABLE', $table_prefix.'portal_announcments');
define('PORTAL_NEWS_TABLE', $table_prefix.'portal_news');
define('PORTAL_LINK_TABLE', $table_prefix.'portal_link');
define('PORTAL_ATTACH_TABLE', $table_prefix.'portal_attach');
define('HOLYDAYS_TABLE', $table_prefix.'holydays');
define('PORTAL_BLOCK_INCLUDES_ORDER_TABLE', $table_prefix.'portal_block_includes_order');
define('PORTAL_BLOCK_INCLUDES_ORDER_INDEX_TABLE', $table_prefix.'portal_block_includes_order_index');
define('PORTAL_HEADER_TABLE', $table_prefix.'portal_header');
define('PORTAL_HEADER_CONFIG_TABLE', $table_prefix.'portal_header_config');
// End Portal define tables

function phpbb_fetch_posts($forum_sql, $number_of_posts, $text_length, $time, $type)
{
	global $db, $user, $phpbb_root_path, $phpEx, $auth;
	
	$from_forum = ($forum_sql != '') ? 't.forum_id IN (' . $forum_sql . ') AND' : '';
	$post_time = ($time == 0) ? '' : 't.topic_time > ' . (time() - $time * 86400) . ' AND';

	if ($type == 'announcments')
	{
		$topic_type = '( t.topic_type = 2 OR t.topic_type = 3 ) AND';
	}
	else if ($type == 'news_all')
	{
		$topic_type = '';
	}
	else
	{
		$topic_type = 't.topic_type = 0 AND';
	}

	$sql = 'SELECT
			t.forum_id,
			t.topic_id,
			t.topic_time,
			t.topic_title,
			p.post_text,
			u.username,
			u.user_id,
			u.user_rank,			
			u.user_type,
			u.user_colour,
			u.user_country_flag,
			t.topic_replies,
			p.bbcode_uid,
			t.forum_id,
			t.topic_poster,
			p.post_id,
			p.enable_smilies,
			p.enable_bbcode,
			p.enable_magic_url,
			p.bbcode_bitfield,
			p.bbcode_uid,
			t.topic_attachment,
			t.poll_title
		FROM
			' . TOPICS_TABLE . ' AS t,
			' . USERS_TABLE . ' AS u,
			' . POSTS_TABLE . ' AS p
		WHERE
			' . $topic_type . '
			' . $from_forum . '
			' . $post_time . '
			t.topic_poster = u.user_id AND
			t.topic_first_post_id = p.post_id AND
			t.topic_first_post_id = p.post_id AND
			t.topic_status <> 2 AND
			t.topic_approved = 1
		ORDER BY
			t.topic_time DESC';

	//
	// query the database
	//
	if(!($result = $db->sql_query_limit($sql, $number_of_posts)))
	{
		die('Could not query topic information');
	}

	//
	// fetch all postings
	//
	$posts = array();
	$i = 0;
	while ( ($row = $db->sql_fetchrow($result)) && ( ($i < $number_of_posts) || ($number_of_posts == '0') ) )
	{
		if ( ($auth->acl_get('f_read', $row['forum_id'])) || ($row['forum_id'] == '0') )
		{
			if ($row['user_id'] != ANONYMOUS && $row['user_colour'])
			{
				$row['username'] = '<b style="color:#' . $row['user_colour'] . '">' . $row['username'] . '</b>';
			}
		
			$posts[$i]['post_text'] = censor_text($row['post_text']);
			$posts[$i]['topic_id'] = $row['topic_id'];
			$posts[$i]['forum_id'] = $row['forum_id'];
			$posts[$i]['topic_replies'] = $row['topic_replies'];
			$posts[$i]['topic_time'] = $user->format_date($row['topic_time']);
			$posts[$i]['topic_title'] = $row['topic_title'];
			$posts[$i]['username'] = $row['username'];
			$posts[$i]['user_rank'] = $row['user_rank'];			
			$posts[$i]['user_country_flag'] = $row['user_country_flag'];			
			$posts[$i]['user_id'] = $row['user_id'];
			$posts[$i]['user_type'] = $row['user_type'];
			$posts[$i]['user_user_colour'] = $row['user_colour'];
			$posts[$i]['poll'] = ($row['poll_title'] != '') ? true : false;
			$posts[$i]['attachment'] = ($row['topic_attachment']) ? true : false;

			$len_check = $posts[$i]['post_text'];
			/* Undefined variable: replacements
			$len_check = strip_post($len_check, $row['bbcode_uid'], $text_length);*/

			if (($text_length != 0) && (strlen($len_check) > $text_length))
			{
				$posts[$i]['post_text'] = substr($len_check, 0, $text_length);
				$posts[$i]['post_text'] .= '...';
				$posts[$i]['striped'] = true;
			}

			include_once($phpbb_root_path . 'includes/bbcode.' . $phpEx);
			$bbcode = new bbcode($row['bbcode_bitfield']);
			$posts[$i]['post_text'] = censor_text($posts[$i]['post_text']);

			$bbcode->bbcode_second_pass($posts[$i]['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield']);
			$posts[$i]['post_text'] = smiley_text($posts[$i]['post_text']);
			$posts[$i]['post_text'] = str_replace("\n", '<br />', $posts[$i]['post_text']);
			$i++;
		}
	}
	// return the result
	return $posts;
}

function create_date($format, $gmepoch, $tz)
{
	global $board_config, $lang;
	static $translate;
	global $userdata, $db;

	$switch_summer_time = ( $userdata['user_summer_time'] && $board_config['summer_time'] ) ? true : false;
	if ($switch_summer_time) $tz++;

	if ( empty($translate) && $board_config['default_lang'] != 'english' )
	{
		@reset($lang['datetime']);
		while ( list($match, $replace) = @each($lang['datetime']) )
		{
			$translate[$match] = $replace;
		}
	}

	return ( !empty($translate) ) ? strtr(@gmdate($format, $gmepoch + (3600 * $tz)), $translate) : @gmdate($format, $gmepoch + (3600 * $tz));
}
function obtain_word_list(&$censors)
{
	global $db, $cache, $user;

	if (!$user->optionget('viewcensors') && $config['allow_nocensors'])
	{
		return;
	}
		$sql = 'SELECT word, replacement
			FROM  ' . WORDS_TABLE;
		$result = $db->sql_query($sql);

		$censors = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$censors['match'][] = '#\b(' . str_replace('\*', '\w*?', preg_quote($row['word'], '#')) . ')\b#i';
			$censors['replace'][] = $row['replacement'];
		}
		$db->sql_freeresult($result);

		$cache->put('word_censors', $censors);
//	}

	return true;
}
function smilie_text($text, $force_option = false)
{
	global $config, $user, $phpbb_root_path;
 
	$userstylepath = $phpbb_root_path .  'images/smilies';
	$phpbb_root_path = '';
	
	return ($force_option || !$config['allow_smilies'] || !$user->optionget('viewsmilies')) ? preg_replace('#<!\-\- s(.*?) \-\-><img src="\{SMILIES_PATH\}\/.*? \/><!\-\- s\1 \-\->#', '\1', $text) : str_replace('<img src="{SMILIES_PATH}', '<img src="' . $userstylepath, $text); 	   
}
function checksize($txt,$len)
{
	if( strlen($txt) > $len)
	{
		$temp = $txt;
		$temp = substr($txt,0,$len);
		$temp[$len] = '.';
		$temp[$len+1] = '.';
		$temp[$len+2] = '.';
		$txt = $temp;
	}		
	return($txt);
}

function smilies_pass($message)
{
	static $orig, $repl;

	if (!isset($orig))
	{
		global $db, $images, $portal_config;

		$orig = $repl = array();

		if(!$orig)
		{
			$sql = 'SELECT * FROM ' . SMILIES_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't obtain smilies data", "", __LINE__, __FILE__, $sql);
			}
			$smilies = $db->sql_fetchrowset($result);

			if (count($smilies))
			{
				usort($smilies, "smiley_sort");
			}

			for ($i = 0; $i < count($smilies); $i++)
			{
				$orig[] = "/(?<=.\W|\W.|^\W)" . phpbb_preg_quote($smilies[$i]['code'], "/") . "(?=.\W|\W.|\W$)/";
				$repl[] = '<img src="images/smilies/'. $images['smilies'] . '/' . $smilies[$i]['smiley_url'] . '" alt="' . $smilies[$i]['emotion'] . '" border="0" />';

			}

			if($portal_config['cache_enabled'])
			{
				$var_cache->save($orig, 'orig2', 'smilies');
				$var_cache->save($repl, 'repl2', 'smilies');
			}
		}
	}

	if (count($orig))
	{
		$message = preg_replace($orig, $repl, ' ' . $message . ' ');
		$message = substr($message, 1, -1);
	}
	
	return $message;
}


function smiley_sort($a, $b)
{
	if ( strlen($a['code']) == strlen($b['code']) )
	{
		return 0;
	}

	return ( strlen($a['code']) > strlen($b['code']) ) ? -1 : 1;
}

function phpbb_preg_quote($str, $delimiter)
{
	$text = preg_quote($str);
	$text = str_replace($delimiter, '\\' . $delimiter, $text);
	
	return $text;
}

?>