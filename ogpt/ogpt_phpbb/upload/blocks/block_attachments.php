<?php
/***************************************************************************
 *                                mod_attachments.php
 *                            -------------------
 *   STARTED : 		10 . 6 . 2007
 *   COPYRIGHT : 		sjpphpbb - sjpphpbb@hotmail.com 
 *   WWW :			http://sjpphpbb.net/phpbb3/	
 ***************************************************************************/
 
/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/ 
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
*/

$user->add_lang('portal/block_attachments_lang');

		$sql = 'SELECT *
			FROM ' . PORTAL_ATTACH_TABLE . '
			WHERE 1';
		$results = $db->sql_query($sql);

		if( $result = $db->sql_query($sql) )
		{
			$row = $db->sql_fetchrow($result);		
			$attachments_number = $row['attachments_number'];
			$attachments_title_block = $row['attachments_title_block'];				
		}

		$sql = 'SELECT *
			FROM ' . ATTACHMENTS_TABLE . '
			ORDER BY download_count  ' . ((!$config['display_order']) ? 'DESC' : 'ASC') . ', post_msg_id ASC';
		$result = $db->sql_query_limit($sql, $attachments_number = $row['attachments_number']);

		while ($row = $db->sql_fetchrow($result))
		{
			$size_lang = ($row['filesize'] >= 1048576) ? $user->lang['MB'] : (($row['filesize'] >= 1024) ? $user->lang['KB'] : $user->lang['BYTES']);
			$row['filesize'] = ($row['filesize'] >= 1048576) ? round((round($row['filesize'] / 1048576 * 100) / 100), 2) : (($row['filesize'] >= 1024) ? round((round($row['filesize'] / 1024 * 100) / 100), 2) : $row['filesize']);	
			$replace = str_replace(array('_','-'), ' ', $row['real_filename']);	
	
		$template->assign_vars(array(
		'ATTACH_TITRE'		=> $attachments_title_block	));	
	
		$template->assign_block_vars('attach', array(
		'FILESIZE'			=> $row['filesize'] . ' ' . $size_lang,
		'FILETIME'			=> $user->format_date($row['filetime']),
		'REAL_FILENAME'		=> $replace,
		'ATTACH_DATE' 		=> $user->format_date($row['filetime'], $format = 'd M Y'),		
		'PHYSICAL_FILENAME'	=> basename($row['physical_filename']),
		'ATTACH_ID'			=> $row['attach_id'],
		'ATTACH_COUNT'		=> $row['download_count'],		
		'POST_IDS'			=> (!empty($post_ids[$row['attach_id']])) ? $post_ids[$row['attach_id']] : '',
		'U_FILE'			=> append_sid($phpbb_root_path . 'download.' . $phpEx, 'id=' . $row['attach_id']))
		);
		}	
		$db->sql_freeresult($result);
?>
