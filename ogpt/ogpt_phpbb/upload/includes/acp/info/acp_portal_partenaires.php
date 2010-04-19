<?php
/*************************************************************************
* @package acp
* @version $Id: acp_partenaires.php
* @copyright (c) sjpphpbb.net 12-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_partenaires_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_partenaires',
			'title'		=> 'ACP_CONFIGURATION_BLOCK_PARTENAIRES',
			'version'	=> '205',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_CONFIGURATION_BLOCK_PARTENAIRES', 'auth' => 'acl_a_board', 'cat' => array('ACP_CONFIGURATION_BLOCK_PARTENAIRES')),
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
