<?php
/*************************************************************************
* @package acp
* @version $Id: acp_link.php
* @copyright (c) sjpphpbb.net 24-02-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_link_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_link',
			'title'		=> 'ACP_CONFIG_BLOCK_LINK',
			'version'	=> '300',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_CONFIG_BLOCK_LINK', 'auth' => 'acl_a_board', 'cat' => array('ACP_CONFIG_BLOCK_LINK')),
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
