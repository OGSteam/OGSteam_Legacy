<?php
/***************************************************************************
 *                        block_recents_topics.php
 *                            -------------------
 *   begin                : Saturday, mars 2007
 *   copyright            : (C) 2007
 *   website              : http://sjpphpbb.net/phpbb3/
 *
 ***************************************************************************/
/***************************************************************************
*   issued from kiss portal : (C) 2005 Michael O'Toole - aka Michaelo < o2l@eircom.net >
*   website              : http://www.phpbbireland.com
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
(int)$style = $user->data['user_style'];
$user->add_lang('portal/portal_lang');

		global $user_id, $user, $template, $lang, $board_config, $phpbb_root_path, $phpEx, $db, $var_cache;
		global $HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS;
		
		if(isset($HTTP_POST_VARS['STYLE_URL']))
		{
			$sql_ary = array(
				'user_style'	=> (int)$HTTP_POST_VARS['STYLE_URL'],
			);
		
			$sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE user_id = ' . $user->data['user_id'];
				$db->sql_query($sql);		
		}
		if(isset($HTTP_POST_VARS['STYLE_URL']) || isset($HTTP_GET_VARS['STYLE_URL']))
		{
			(int)$style = urldecode((isset($HTTP_POST_VARS['STYLE_URL'])) ? $HTTP_POST_VARS['STYLE_URL'] : $HTTP_GET_VARS['STYLE_URL']);
			if ($style == 0)
			{
				$sql = "SELECT theme_id
						FROM " . THEMES_TABLE . "
						WHERE theme_name = '$style'";
				if( ($result = $db->sql_query($sql)) && ($row = $db->sql_fetchrow($result)) )
				{
					$style = $row['theme_id'];
				}
				else
				{
					message_die(GENERAL_ERROR, "Hacking Attempt (logged).... Could not find style name $style.");
				}
			}
		}
		
		$sql = "SELECT theme_id, theme_name, theme_status
			FROM " . STYLES_THEME_TABLE . "
			ORDER BY theme_name";
		
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not get list of styles!", "", __LINE__, __FILE__, $sql);
		}
		$select_theme = "<select onChange=\"this.form.submit();\" name=\"STYLE_URL\" class=\"\">\n";
		while( $row = $db->sql_fetchrow($result) )
		{
			$selected = ($row['theme_id'] == $style) ? " selected=\"selected\"" : "";
			$class = "\"list_release\"";
			$select_theme .= "<option class=" . $class . " value=\"" . $row['theme_id'] . "\"$selected>" . $row['theme_name'] . "</option>";
		}
		$select_theme .= "</select>\n";
		$template->assign_vars(array(
			'S_SELECT_STYLE' => $select_theme,
			)
		);
		
?>