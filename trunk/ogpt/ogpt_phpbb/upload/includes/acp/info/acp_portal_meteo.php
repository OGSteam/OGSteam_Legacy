<?php
/*************************************************************************
* @package acp
* @version $Id: acp_meteo.php
* @copyright (c) sjpphpbb.net 24-02-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_meteo_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_portal_meteo',
			'title'		=> 'ACP_CONFIGURATION_METEO',
			'version'	=> '300',
			'modes'		=> array(
				'select'		=> array('title' => 'ACP_CONFIGURATION_METEO', 'auth' => 'acl_a_board', 'cat' => array('ACP_CONFIGURATION_METEO')),
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
