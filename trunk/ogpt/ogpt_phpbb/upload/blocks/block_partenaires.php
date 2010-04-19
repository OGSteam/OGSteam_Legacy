<?php
/***************************************************************************
*
* $Id:block_user_information.php,v 1.146 03-2007 sjpphpbb Exp $
*
* FILENAME  : block_partenaires.php
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

if (!defined('IN_PHPBB'))
{
	exit;
}

$user->add_lang('portal/block_partenaires_lang');

$sql = 'SELECT *
	FROM ' . PARTENAIRES_TABLE . '	
    ORDER BY partenaires_id ASC';
$result = $db->sql_query($sql);
while ($row = $db->sql_fetchrow($result))
{
	$i = 0;
	do

	{
	$template->assign_block_vars('partenaires', array(
        'ROW_NUMBER' => $i + '1',	
		'PARTENAIRES_URL' 	=> $row['partenaires_url'],
		'PARTENAIRES_IMG' 	=> $row['partenaires_img'],
		'PARTENAIRES_FLAG' 	=> $row['partenaires_flag'],		
		));
		$i++;
	}
	while ( $row = $db->sql_fetchrow($result) );
	$db->sql_freeresult($result);
}
?>