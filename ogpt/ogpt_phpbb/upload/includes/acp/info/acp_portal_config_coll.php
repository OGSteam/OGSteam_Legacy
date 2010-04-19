<?php
/*************************************************************************
* @package acp
* @version $Id: acp_portal_config_coll.php
* @copyright (c) sjpphpbb.net 12-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_config_coll_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_config_coll',
			'title'		=> 'ACP_AGENCEMENT_DU_PORTAL',
			'version'	=> '205',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_AGENCEMENT_DU_PORTAL', 'auth' => 'acl_a_board', 'cat' => array('ACP_AGENCEMENT_DU_PORTAL')),
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
