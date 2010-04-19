<?php
/*************************************************************************
* @package acp
* @version $Id: acp_menu.php
* @copyright (c) sjpphpbb.net 03-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_menu_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_menu',
			'title'		=> 'ACP_PORTAL_MENU',
			'version'	=> '300',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_PORTAL_MENU', 'auth' => 'acl_a_board', 'cat' => array('ACP_PORTAL_MENU')),
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
