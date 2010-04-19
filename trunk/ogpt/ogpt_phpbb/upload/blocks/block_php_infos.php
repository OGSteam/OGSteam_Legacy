<?php
/***************************************************************************
*
* @package phpBB3
* @version $Id: quote ( Citation )
* @copyright (c) 2007 sjpphppbb.net
*
****************************************************************************/

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

$user->add_lang('portal/block_php_infos_lang');
	{
		// Get webserver info
		if (preg_match('#(Apache)/([0-9\.]+)\s#siU', $_SERVER['SERVER_SOFTWARE'], $info))
		{
			$webserver_info = "$info[1] v$info[2]";
		}
		else if (strtoupper($_SERVER['SERVER_SOFTWARE']) == 'APACHE')
		{
			$webserver_info = 'Apache';
		}
		else if (preg_match('#Microsoft-IIS/([0-9\.]+)#siU', $_SERVER['SERVER_SOFTWARE'], $info))
		{
			$webserver_info = "IIS v$info[1]";
		}
		else if (preg_match('#Zeus/([0-9\.]+)#siU', $_SERVER['SERVER_SOFTWARE'], $info))
		{
			$webserver_info = "Zeus v$info[1]";
		}
		else
		{
			$webserver_info = php_sapi_name();
		}
			$template->assign_vars(array(
			'GZIP_COMPRESSION'	=> ($config['gzip_compress']) ? $user->lang['ON'] : $user->lang['OFF'],			
			'DATABASE_INFO'		=> $db->sql_server_info(),			
			'OS_INFO'			=> PHP_OS,
			'WEBSERVER_INFO'	=> $webserver_info,
			'PHP_INFO'			=> 'PHP ' . PHP_VERSION));

	}

?>