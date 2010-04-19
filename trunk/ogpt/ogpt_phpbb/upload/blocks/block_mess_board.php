<?php
/***************************************************************************
*
* @package phpBB3
* @version $Id: sow_images
* @copyright (c) 2007 sjpphppbb.net
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

if (!defined('IN_PHPBB'))
{
	exit;
}
	{
		
	$sql = 'SELECT *
		FROM ' . MESS_BOARD_TABLE . "
		WHERE id = '" . $db->sql_escape($id) . "'";
		$results = $db->sql_query($sql);

		$row = $db->sql_fetchrow($results);
		{

                	$message            	= $row['message'];
                	$mess_board_titre       = $row['mess_board_titre'];
                	$bbcode_bitfield        = $row['bbcode_bitfield'];
                	$bbcode_uid    			= $row['bbcode_uid'];

                	$flags = (($config['allow_bbcode']) ? 1 : 0) + (($config['allow_smilies']) ? 2 : 0) + ((true) ? 4 : 0);

		$template->assign_vars(array(
            'MESS_BOARD_TITRE'     	=> $mess_board_titre,
			'MESS-ACCUEIL' 			=> generate_text_for_display($message, $row['bbcode_uid'], $row['bbcode_bitfield'], $flags))
    		);
		}

	}

?>
