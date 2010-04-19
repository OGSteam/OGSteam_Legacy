<?php
/***************************************************************************
*
* $Id:block_user_information.php,v 1.146 03-2007 sjpphpbb Exp $
*
* FILENAME  : block_user_informationphp
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

$phpbb_root_path = './';


// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup(array('memberlist', 'groups'));
global $db, $config, $user, $user_id;
$user->add_lang('portal/portal_lang');
$user_id = $user->data['user_id'];

$date=date("d-m-Y");
$jour=date("l");

$monday = sprintf($user->lang['MONDAY']);
$tuesday = sprintf($user->lang['TUESDAY']);
$wednesday = sprintf($user->lang['WEDNESDAY']);
$thursday = sprintf($user->lang['THURSDAY']);
$friday = sprintf($user->lang['FRIDAY']);
$saturday = sprintf($user->lang['SATURDAY']);
$sunday = sprintf($user->lang['SUNDAY']);

switch ($jour)
{    
case "Monday":    $jour=$monday ;    break;        
case "Tuesday":    $jour=$tuesday ;    break;    
case "Wednesday":    $jour=$wednesday ;    break;    
case "Thursday":    $jour=$thursday ;    break;    
case "Friday":    $jour=$friday ;    break;    
case "Saturday":    $jour=$saturday ;    break;    
case "Sunday":    $jour=$sunday ;    break;}

		$sql = 'SELECT user_id, username, user_colour, user_country_flag , user_rank
			FROM ' . USERS_TABLE . '
			WHERE user_type <> 2
			AND user_id ';
		if( $result = $db->sql_query($sql) )
		{
			$row = $db->sql_fetchrow($result);
}

$template->assign_block_vars('team', array(
	'U_USERNAME'	=> append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $row['user_id']),
	'USERNAME_COLOR'=> ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] .'"' : '',
	'USERNAME_FULL'		=> get_username_string('full', $user->data['user_id'], $user->data['username'], $user->data['user_colour']),	
	'USER_NAME'		=> $user->data['username'],
	'JOUR'			=> $jour,	
	'DATE'			=> $date,
	'USER_FLAG'		=> $user->data['user_country_flag'],
	)
);	
		
?>