<?php

/***************************************************************************
 *                                mod_meteo3.php
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

//meteo_lang
$user->add_lang('portal/block_meteo_lang');
$user->session_begin();
$auth->acl($user->data);
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$phpbb_root_path = './';

$sql1="SELECT meteo_fond,meteo_texte,meteo_titre FROM " . METEO_TABLE . " ORDER BY rand()";

		if(!($resulta = $db->sql_query($sql1)))
		{
			message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
		}

if ( $row = $db->sql_fetchrow( $resulta ) )
{

	{
				$meteo_fond = $row['meteo_fond'] ;
         		$meteo_texte = utf8_normalize_nfc($row['meteo_texte']);
         		$meteo_titre = $row['meteo_titre'] ;
	}
	while ( $row = $db->sql_fetchrow( $resulta ) );
}

$sql="SELECT meteo_name, user_id, username FROM " . USERS_TABLE . "
WHERE user_id = ". $user->data['user_id'];

		if(!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow( $result ) )
		{
		$meteo_name = $row['meteo_name'] ;
		}
		while ( $row = $db->sql_fetchrow( $result ) );

	$template->assign_vars(array(
	'METEO' => $meteo_name,
	'TITRE' => $meteo_titre,
	'FOND' => $meteo_fond,
	'TEXTE' => $meteo_texte));

?>
