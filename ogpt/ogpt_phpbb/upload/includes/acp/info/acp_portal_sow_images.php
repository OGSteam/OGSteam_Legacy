<?php
/*************************************************************************
* @package acp
* @version $Id: acp_sow_images.php
* @copyright (c) sjpphpbb 15-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/
class acp_portal_sow_images_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_sow_images',
			'title'		=> 'ACP_CONFIGURATION_DU_SOW',
			'version'	=> '3.0.0',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_CONFIGURATION_DU_SOW', 'auth' => 'acl_a_board', 'cat' => array('ACP_CONFIGURATION_DU_SOW')),
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
