<?php
/** 
*
* @package acp
* @version $Id: acp_reasons.php,v 1.2 2006/05/01 19:45:42 grahamje Exp $
* @copyright (c) 2005 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* @package module_install
*/
class acp_reasons_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_reasons',
			'title'		=> 'ACP_REASONS',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'main'		=> array('title' => 'ACP_MANAGE_REASONS', 'auth' => 'acl_a_reasons', 'cat' => array('ACP_GENERAL_TASKS')),
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