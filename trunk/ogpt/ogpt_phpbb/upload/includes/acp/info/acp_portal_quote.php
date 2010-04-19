<?php
/*************************************************************************
* @package acp
* @version $Id: acp_quote.php
* @copyright (c) sjpphpbb.net 12-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_quote_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_quote',
			'title'		=> 'ACP_CONFIGURATION_DES_CITATIONS',
			'version'	=> '205',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_CONFIGURATION_DES_CITATIONS', 'auth' => 'acl_a_board', 'cat' => array('ACP_CONFIGURATION_DES_CITATIONS')),
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
