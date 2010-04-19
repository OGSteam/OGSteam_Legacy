<?php
/*
* auteur d'origine :
* @name random_member.php
* @package phpBB3 PlusXL 4.0 Portal (based on phpBB3 Portal 1.02b)
* @version $Id: v 1.0 2007/04/21 damysterious Exp $
* @copyright (c) DaMysterious http://damysterious.xs4all.nl
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

$user->add_lang('portal/block_random_member_lang');

$avatar_img = '';

$sql = 'SELECT user_id, username, user_posts, user_regdate, user_colour, user_occ, user_from, user_website, user_country_flag,
user_avatar, user_avatar_type, user_avatar_width, user_avatar_height
	FROM ' . USERS_TABLE . '
	WHERE user_type <> 2
	AND user_inactive_time = 0
	ORDER BY RAND() 
	LIMIT 0,1';

$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);

	if ($row['user_avatar'] && $user->optionget('viewavatars'))
	{
		$avatar_img = '';
		
		switch ($row['user_avatar_type'])
		{
			case AVATAR_UPLOAD:
			    $avatar_img = $phpbb_root_path . "download.$phpEx?avatar=";
			break;

			case AVATAR_GALLERY:
			    $avatar_img = $phpbb_root_path . $config['avatar_gallery_path'] . '/';
			break;
		}
		
	  $avatar_img .= $row['user_avatar'];
	  $avatar_img = '<img src="' . $avatar_img . '" width="' . $row['user_avatar_width'] . '" height="' . $row['user_avatar_height'] . '" alt="' . $row['username'] . '" title="' . $row['username'] . '" />';         
	}

$template->assign_block_vars('random_member', array(
	'USERNAME'				=> censor_text($row['username']),
	'USERNAME_COLOR'		=> $row['user_colour'],
	'USER_FLAG'				=> $row['user_country_flag'],	
	'U_USERNAME'			=> append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $row['user_id']),
	'USER_POSTS'			=> $row['user_posts'],
	'USER_AVATAR'			=> $avatar_img,
	'JOINED'				=> $user->format_date($row['user_regdate'], $format = 'd.n.Y'),
	'USER_OCC'				=> censor_text($row['user_occ']),
	'USER_FROM'				=> censor_text($row['user_from']),
	'U_WWW'					=> censor_text($row['user_website']),
	)
);

$db->sql_freeresult($result);

?>