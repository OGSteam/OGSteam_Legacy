<?php
/*************************************************************************
* @package acp
* @version $Id: acp_portal_config_coll.php
* @copyright (c) sjpphpbb.net 12-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_config_coll_index_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_config_coll_index',
			'title'		=> 'ACP_AGENCEMENT_DU_PORTAL_INDEX',
			'version'	=> '205',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_AGENCEMENT_DU_PORTAL_INDEX', 'auth' => 'acl_a_board', 'cat' => array('ACP_AGENCEMENT_DU_PORTAL_INDEX')),
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
