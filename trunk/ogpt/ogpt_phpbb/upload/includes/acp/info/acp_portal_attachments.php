<?php
/*************************************************************************
* @package acp
* @version $Id: acp_attachments.php
* @copyright (c) sjpphpbb.net 12-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_attachments_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_attachments',
			'title'		=> 'ACP_CONFIG_ATT',
			'version'	=> '205',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_CONFIG_ATT', 'auth' => 'acl_a_board', 'cat' => array('ACP_CONFIG_ATT')),
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
