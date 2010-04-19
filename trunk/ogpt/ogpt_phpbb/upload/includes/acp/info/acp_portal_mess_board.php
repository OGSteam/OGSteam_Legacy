<?php
/*************************************************************************
* @package acp
* @version $Id: acp_mess_board.php
* @copyright (c) sjpphpbb.net 20-01-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_mess_board_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_mess_board',
			'title'		=> 'ACP_CONFIGURATION_MESS_BOARD',
			'version'	=> '205',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_CONFIGURATION_MESS_BOARD', 'auth' => 'acl_a_board', 'cat' => array('ACP_CONFIGURATION_MESS_BOARD')),
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
