<?php
/*************************************************************************
* @package acp
* @version $Id: acp_link.php
* @copyright (c) sjpphpbb.net 30-05-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_link
	{
    	var $u_action;
    	var $new_config;

	function main($id, $mode)
   	{
        		global $db, $user, $auth, $template, $cache;
        		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
				$user->add_lang('portal/block_link_lang');
				$this->tpl_name = 'acp_portal_link';
				$this->page_title = 'Acp_portal_link';
        		$error = $notify = array();

	switch ($mode)
	{
	case 'main':
	}
	if (isset($_POST['edit']))
	{

	$selected_msg = request_var('portal_link', array('' => 0));
	$sql = 'SELECT *
		FROM ' . PORTAL_LINK_TABLE . "
		WHERE id = '" . $db->sql_escape($selected_msg) . "'";
		$results = $db->sql_query($sql);
		$row = $db->sql_fetchrow($results);

		$id         = $row['id'];
	    $portal_logo = $row['portal_logo'];
	    $portal_link = $row['portal_link'];

	if (isset($row['portal_link']))
	{
		unset($row['portal_link']);
	}

		$template->assign_vars(array(
			'U_SEL_ACTION'		=> $this->u_action,
			'MSG_ID'       		=> $id,
			'U_BACK'			=> $this->u_action,
			'LOGO'				=> $portal_logo,
			'LINK'				=> $portal_link,
			));
									
	}
	else if (isset($_POST['save-edited']))
	{
		$id = request_var('msg_id', '');
		$portal_logo = request_var('portal_logo', '');
		$portal_link = request_var('portal_link', '');

	$sql = 'SELECT *
		FROM ' . PORTAL_LINK_TABLE . "
		WHERE id = '" . $db->sql_escape($id) . "'";
		$results = $db->sql_query($sql);
		$row = $db->sql_fetchrow($results);

	$sql_ary = array(
		'portal_logo'	=> $portal_logo,
		'portal_link '	=> $portal_link 
		);

	$sql = 'UPDATE ' . PORTAL_LINK_TABLE . ' 
		SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
		WHERE id = $id";
		$db->sql_query($sql);
		unset($id); 
		trigger_error($user->lang['LINK_UPDATED'] . adm_back_link($this->u_action));
	}
	else
	{

	$sql = 'SELECT *
		FROM ' . PORTAL_LINK_TABLE . "
		WHERE id = '" . $db->sql_escape($id) . "'";
		$results = $db->sql_query($sql);

		$row = $db->sql_fetchrow($results);
		{
		$id         = $row['id'];
	    $portal_logo = $row['portal_logo'];
	    $portal_link = $row['portal_link'];

                	$template->assign_vars(array(
                   		'MSG_ID'    => $id,
						'U_BACK'	=> $this->u_action,
						'LOGO'	 	=> $portal_logo,
						'LINK'		=> $portal_link,));
                	}
         }

    }

}
?>