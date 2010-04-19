<?php
/*************************************************************************
* @package acp
* @version $Id: acp_sow_images.php
* @copyright (c) sjpphpbb 15-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/
class acp_portal_header_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_header',
			'title'		=> 'ACP_PAGE_HEADER',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_PAGE_HEADER', 'auth' => 'acl_a_board', 'cat' => array('ACP_PAGE_HEADER')),
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
