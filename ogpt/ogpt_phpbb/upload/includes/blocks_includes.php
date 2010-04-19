<?php
/***************************************************************************
*
* $Id:block_includes.php,v 1.146 03-2007 sjpphpbb Exp $
*
* FILENAME  : block_includes.php
* STARTED   : 03-2007
* COPYRIGHT : © 2007 sjpphpbb 
* WWW       : http://sjpphpbb.net/phpbb3/
* LICENCE   : GPL vs2.0 [ see /docs/COPYING ]
*
 ***************************************************************************/

if (!defined('IN_PHPBB'))
{
	exit;
}

$phpbb_root_path = './';


// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup(array('memberlist', 'groups'));

	include_once($phpbb_root_path . 'blocks/block_bots_recent.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_the_team.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_style_select.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_links.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_recent_topics.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_top_posters.'. $phpEx );	
	include_once($phpbb_root_path . 'blocks/block_latest_members.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_quote.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_mess_board.'. $phpEx );	
	include_once($phpbb_root_path . 'blocks/block_whos_on_line.'. $phpEx );	
	include_once($phpbb_root_path . 'blocks/block_sp.'. $phpEx );	
	include_once($phpbb_root_path . 'blocks/block_meteo.'. $phpEx );	
	include_once($phpbb_root_path . 'blocks/block_horoscope.'. $phpEx );	
	include_once($phpbb_root_path . 'blocks/block_birthday.'. $phpEx );	
	include_once($phpbb_root_path . 'blocks/block_menu.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_user_information.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_partenaires.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_sow_images.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_announcments.'. $phpEx );	
	include_once($phpbb_root_path . 'blocks/block_allo_cine.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_clock.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_search.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_news.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_ip_host_portal.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_team.'. $phpEx );	
	include_once($phpbb_root_path . 'blocks/block_compteur.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_last_visite.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_php_infos.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_viewonline.'. $phpEx );	
	include_once($phpbb_root_path . 'blocks/block_attachments.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_online_friends.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_holydays.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_random_member.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_jump_to.'. $phpEx );
	include_once($phpbb_root_path . 'blocks/block_ranks.'. $phpEx );	
	include_once($phpbb_root_path . 'blocks/portal_header.'. $phpEx );		
?>