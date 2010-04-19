<?php
/*************************************************************************
* @package acp
* @version $Id: acp_portal_include_block.php
* @copyright (c) sjpphpbb.net 20-01-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_include_block_index_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_include_block_index',
			'title'		=> 'ACP_PORTAL_INCLUDE_BLOCK_INDEX',
			'version'	=> '205',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_PORTAL_INCLUDE_BLOCK_INDEX', 'auth' => 'acl_a_board', 'cat' => array('ACP_PORTAL_INCLUDE_BLOCK_INDEX')),
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
