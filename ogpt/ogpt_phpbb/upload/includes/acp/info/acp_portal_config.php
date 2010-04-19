<?php
/*************************************************************************
* @package acp
* @version $Id: acp_qportal_confige.php
* @copyright (c) sjpphpbb.net 12-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_config_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_config',
			'title'		=> 'ACP_DONNES_BLOCK_PORTAL',
			'version'	=> '205',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_DONNES_BLOCK_PORTAL', 'auth' => 'acl_a_board', 'cat' => array('ACP_DONNES_BLOCK_PORTAL')),
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
