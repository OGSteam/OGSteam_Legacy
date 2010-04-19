<?php
/*************************************************************************************
 *                            blocks_ranks.php
 *                            -------------------
 *   copyright            	: sjpphpbb 
 *   website              	: http://sjpphpbb.net/phpbb3/
 *   email                	: sjpphpbb@club-internet.fr
 ************************************************************************************/
/* @version original $Id: ranks.php,v 1.0 2007/02/01 22:28:42 Nicolas Fraga Exp $*/
/************************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify it under 
 *   the terms of the GNU General Public License as published by the Free Software
 *   Foundation; either version 2 of the License, or any later version.
 *
 ************************************************************************************/



/**
* @ignore
*/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
$phpbb_root_path = './';
$user->add_lang('portal/block_ranks_lang');
$sql = 'SELECT *
	FROM ' . RANKS_TABLE . '
	ORDER BY rank_min ASC, rank_special ASC, rank_title ASC';
$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
	$template->assign_block_vars('ranks', array(
		'S_RANK_IMAGE'		=> ($row['rank_image']) ? true : false,
		'RANK_IMAGE'		=> $phpbb_root_path . $config['ranks_path'] . '/' . $row['rank_image'],
		'RANK_TITLE'		=> $row['rank_title'])
	);
}

$db->sql_freeresult($result);

?>
