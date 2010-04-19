<?php
/***************************************************************************
*
* @package phpBB3
* @version $Id: block_link
* @copyright (c) 2007 sjpphppbb.net
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

$user->add_lang('portal/block_link_lang');

$server_name = (!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : getenv('SERVER_NAME');
$server_port = (!empty($_SERVER['SERVER_PORT'])) ? (int) $_SERVER['SERVER_PORT'] : (int) getenv('SERVER_PORT');
$secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 1 : 0;

$script_name = (!empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : getenv('PHP_SELF');
if (!$script_name)
{
	$script_name = (!empty($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
}

// Replace any number of consecutive backslashes and/or slashes with a single slash
// (could happen on some proxy setups and/or Windows servers)
$script_path = trim(dirname($script_name));
$script_path = preg_replace('#[\\\\/]{2,}#', '/', $script_path);

$url = (($secure) ? 'https://' : 'http://') . $server_name;

if ($server_port && (($secure && $server_port <> 443) || (!$secure && $server_port <> 80)))
{
	$url .= ':' . $server_port;
}
$url .= $script_path;

    $error = $notify = array();
	$id = request_var('id', '');
	$sql = 'SELECT *
		FROM ' . PORTAL_LINK_TABLE . "
		WHERE id = '" . $db->sql_escape($id) . "'";
		$results = $db->sql_query($sql);

		$row = $db->sql_fetchrow($results);
		{
	    $portal_logo = $row['portal_logo'];
	    $portal_link = $row['portal_link'];
		}
		
$template->assign_vars(array(
	'LOGO'	=> $portal_logo,
	'LINK'	=> $portal_link,
	'U_LINK'=> '&lt;a&nbsp;href=&quot;' . $url . '&quot;&nbsp;target=&quot;_blank&quot;&nbsp;title=&quot;' . $config['site_desc'] . '&quot;&gt; &lt;'. 'img src=' . $portal_logo. ' ; border 0' . '&gt' . '&lt;/a&gt',
	)
);
	
?>