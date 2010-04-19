<?php
/*************************************************************************
* @package acp
* @version $Id: acp_new.php
* @copyright (c) sjpphpbb.net 12-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_news_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_news',
			'title'		=> 'ACP_CONFIG_NEWS',
			'version'	=> '205',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_CONFIG_NEWS', 'auth' => 'acl_a_board', 'cat' => array('ACP_CONFIG_NEWS')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>
