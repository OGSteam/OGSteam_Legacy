<?php
/*************************************************************************
* @package acp
* @version $Id: acp_quote.php
* @copyright (c) sjpphpbb.net 12-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_announcments_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_announcments',
			'title'		=> 'ACP_PORTAL_ANNONCES',
			'version'	=> '205',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_PORTAL_ANNONCES', 'auth' => 'acl_a_board', 'cat' => array('ACP_PORTAL_ANNONCES')),
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
