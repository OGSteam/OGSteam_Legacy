<?php
/***************************************************************************
 *                                mod_horoscope.php
 *                            -------------------
 *   STARTED : 		24 . 2 . 2007
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

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
$user->add_lang('portal/block_horoscope_lang');
	{
		$sql = 'SELECT *
			FROM ' . HOROSCOPE_TITRE_TABLE . '
			ORDER BY   horoscope_id ';
		$results = $db->sql_query($sql);

		$row = $db->sql_fetchrow($results);
		{
    			$horoscope_titre= $row['horoscope_titre'];
		}

			$template->assign_vars(array(
                'HOROSCOPE_TITRE'                   => $horoscope_titre)
			);
	}

?>
