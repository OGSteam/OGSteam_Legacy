<?php
/***************************************************************************
*
* $Id:block_allo_cine.php,v 1.146 03-2007 sjpphpbb Exp $
*
* FILENAME  : block_viewonline.php
* STARTED   : 03-2007
* COPYRIGHT : © 2007 sjpphpbb 
* WWW       : http://sjpphpbb.net/phpbb3
* LICENCE   : GPL vs2.0 [ see /docs/COPYING ]
*
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
$phpbb_root_path = './';

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// Get and set some variables
$mode		= request_var('mode', '');
$session_id	= request_var('s', '');
$start		= request_var('start', 0);
$sort_key	= request_var('sk', 'b');
$sort_dir	= request_var('sd', 'd');
$show_guests= ($config['load_online_guests']) ? request_var('sg', 0) : 0;
$sort_key_text = array('a' => $user->lang['SORT_USERNAME'], 'b' => $user->lang['SORT_LOCATION'], 'c' => $user->lang['SORT_JOINED']);
$sort_key_sql = array('a' => 'u.username_clean', 'b' => 's.session_time', 'c' => 's.session_page');
// Sorting and order
if (!isset($sort_key_text[$sort_key]))
{
	$sort_key = 'b';
}
$order_by = $sort_key_sql[$sort_key] . ' ' . (($sort_dir == 'a') ? 'ASC' : 'DESC');
// Forum info
$sql = 'SELECT forum_id, forum_name, parent_id, forum_type, left_id, right_id
	FROM ' . FORUMS_TABLE . '
	ORDER BY left_id ASC';
$result = $db->sql_query($sql, 600);

while ($row = $db->sql_fetchrow($result))
{
	$forum_data[$row['forum_id']] = $row;
}
$db->sql_freeresult($result);
$sql = 'SELECT u.user_id, u.username, u.username_clean, u.user_type, u.user_allow_viewonline, u.user_country_flag , u.user_colour, s.session_id, s.session_time, s.session_page, s.session_ip, s.session_viewonline
	FROM ' . USERS_TABLE . ' u, ' . SESSIONS_TABLE . ' s
	WHERE u.user_id = s.session_user_id
		AND s.session_time >= ' . (time() - ($config['load_online_time'] * 60)) . 
		((!$show_guests) ? ' AND s.session_user_id <> ' . ANONYMOUS : '') . '
	ORDER BY ' . $order_by;
$result = $db->sql_query($sql);
$prev_id = $prev_ip = $user_list = array();
$logged_visible_online = $logged_hidden_online = $counter = 0;

while ($row = $db->sql_fetchrow($result))
{
	if ($row['user_id'] != ANONYMOUS && !isset($prev_id[$row['user_id']]))
	{
		$view_online = false;

		if ($row['user_colour'])
		{
			$row['username'] = '<b style="color:#' . $row['user_colour'] . '">' . $row['username'] . '</b>';
		}

		if (!$row['user_allow_viewonline'] || !$row['session_viewonline'])
		{
			$view_online = ($auth->acl_get('u_viewonline')) ? true : false;
			$logged_hidden_online++;

			$row['username'] = '<i>' . $row['username'] . '</i>';
		}
		else
		{
			$view_online = true;
			$logged_visible_online++;
		}

		$prev_id[$row['user_id']] = 1;

		if ($view_online)
		{
			$counter++;
		}

		if (!$view_online || $counter > $start + $config['topics_per_page'] || $counter <= $start)
		{
			continue;
		}
	}
	else if ($show_guests && $row['user_id'] == ANONYMOUS && !isset($prev_ip[$row['session_ip']]))
	{
		$prev_ip[$row['session_ip']] = 1;
		$guest_counter++;
		$counter++;

		if ($counter > $start + $config['topics_per_page'] || $counter <= $start)
		{
			continue;
		}

		$row['username'] = $user->lang['GUEST'];
	}
	else
	{
		continue;
	}

	preg_match('#^([a-z/]+)#i', $row['session_page'], $on_page);
	if (!sizeof($on_page))
	{
		$on_page[1] = '';
	}

	switch ($on_page[1])
	{
		case 'index':
			$location = $user->lang['INDEX'];
			$location_url = append_sid("{$phpbb_root_path}index.$phpEx");
		break;
		
		case 'portal':
			$location = $user->lang['PORTAL'];
			$location_url = append_sid("{$phpbb_root_path}portal.$phpEx");
		break;		
		
//-- mod : AJAX Chat ----------------------------------------------------
//-- add
		case 'chat':
            $location = $user->lang['VIEWING_CHAT'];
            $location_url = append_sid("{$phpbb_root_path}chat.$phpEx");
        break;
//-- fin mod : AJAX Chat ------------------------------------------------		

		case 'adm/index':
			$location = $user->lang['ACP'];
			$location_url = append_sid("{$phpbb_root_path}index.$phpEx");
		break;

		case 'posting':
		case 'viewforum':
		case 'viewtopic':
			preg_match('#f=([0-9]+)#', $row['session_page'], $forum_id);
			$forum_id = (sizeof($forum_id)) ? (int) $forum_id[1] : 0;

			if ($forum_id && $auth->acl_get('f_list', $forum_id))
			{
				$location = '';
				$location_url = append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $forum_id);

				if ($forum_data[$forum_id]['forum_type'] == FORUM_LINK)
				{
					$location = sprintf($user->lang['READING_LINK'], $forum_data[$forum_id]['forum_name']);
					break;
				}

				switch ($on_page[1])
				{
					case 'posting':
						preg_match('#mode=([a-z]+)#', $row['session_page'], $on_page);

						switch ($on_page[1])
						{
							case 'reply':
							case 'quote':
								$location = sprintf($user->lang['REPLYING_MESSAGE'], $forum_data[$forum_id]['forum_name']);
							break;

							default:
								$location = sprintf($user->lang['POSTING_MESSAGE'], $forum_data[$forum_id]['forum_name']);
							break;
						}
					break;

					case 'viewtopic':
						$location = sprintf($user->lang['READING_TOPIC'], $forum_data[$forum_id]['forum_name']);
					break;
	
					case 'viewforum':
						$location = sprintf($user->lang['READING_FORUM'], $forum_data[$forum_id]['forum_name']);
					break;
				}
			}
			else
			{
				$location = $user->lang['INDEX'];
				$location_url = append_sid("{$phpbb_root_path}index.$phpEx");
			}
		break;

		case 'search':
			$location = $user->lang['SEARCHING_FORUMS'];
			$location_url = append_sid("{$phpbb_root_path}search.$phpEx");
		break;

		case 'faq':
			$location = $user->lang['VIEWING_FAQ'];
			$location_url = append_sid("{$phpbb_root_path}faq.$phpEx");
		break;

		case 'viewonline':
			$location = $user->lang['VIEWING_ONLINE'];
			$location_url = append_sid("{$phpbb_root_path}viewonline.$phpEx");
		break;

		case 'memberlist':
			$location = (strpos($row['session_page'], 'mode=viewprofile') !== false) ? $user->lang['VIEWING_MEMBER_PROFILE'] : $user->lang['VIEWING_MEMBERS'];
			$location_url = append_sid("{$phpbb_root_path}memberlist.$phpEx");
		break;

		case 'mcp':
			$location = $user->lang['VIEWING_MCP'];
			$location_url = append_sid("{$phpbb_root_path}index.$phpEx");
		break;

		case 'ucp':
			$location = $user->lang['VIEWING_UCP'];

			// Grab some common modules
			$url_params = array(
				'mode=register'		=> 'VIEWING_REGISTER',
				'i=pm&mode=compose'	=> 'POSTING_PRIVATE_MESSAGE',
				'i=pm&'				=> 'VIEWING_PRIVATE_MESSAGES',
				'i=profile&'		=> 'CHANGING_PROFILE',
				'i=prefs&'			=> 'CHANGING_PREFERENCES',
			);

			foreach ($url_params as $param => $lang)
			{
				if (strpos($row['session_page'], $param) !== false)
				{
					$location = $user->lang[$lang];
					break;
				}
			}

			$location_url = append_sid("{$phpbb_root_path}index.$phpEx");
		break;

		case 'download':
			$location = $user->lang['DOWNLOADING_FILE'];
			$location_url = append_sid("{$phpbb_root_path}index.$phpEx");
		break;

		case 'report':
			$location = $user->lang['REPORTING_POST'];
			$location_url = append_sid("{$phpbb_root_path}index.$phpEx");
		break;

		default:
			$location = $user->lang['INDEX'];
			$location_url = append_sid("{$phpbb_root_path}index.$phpEx");
		break;
	}

	$template->assign_block_vars('user_row', array(
		'USERNAME' 			=> $row['username'],
		'LASTUPDATE'		=> $user->format_date($row['session_time']),
		'FORUM_LOCATION'	=> $location,
// Contry Flags by sjpphpbb http://sjpphpbb.net/phpbb3/
		'USER_FLAG'			=> $row['user_country_flag'],
// Fin contry flags		
		'USER_IP'			=> ($auth->acl_get('a_')) ? (($mode == 'lookup' && $session_id == $row['session_id']) ? gethostbyaddr($row['session_ip']) : $row['session_ip']) : '',

		'U_USER_PROFILE'	=> (($row['user_type'] == USER_NORMAL || $row['user_type'] == USER_FOUNDER) && $row['user_id'] != ANONYMOUS) ? append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $row['user_id']) : '',
		'U_USER_IP'			=> append_sid("{$phpbb_root_path}viewonline.$phpEx", 'mode=lookup' . (($mode != 'lookup' || $row['session_id'] != $session_id) ? '&amp;s=' . $row['session_id'] : '') . "&amp;sg=$show_guests&amp;start=$start&amp;sk=$sort_key&amp;sd=$sort_dir"),
		'U_WHOIS'			=> append_sid("{$phpbb_root_path}viewonline.$phpEx", 'mode=whois&amp;s=' . $row['session_id']),
		'U_FORUM_LOCATION'	=> $location_url,
		
		'S_GUEST'			=> ($row['user_id'] == ANONYMOUS) ? true : false,
		'S_USER_TYPE'		=> $row['user_type'])
	);
}

$db->sql_freeresult($result);
unset($prev_id, $prev_ip);

?>