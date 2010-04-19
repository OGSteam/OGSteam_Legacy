<?php
/*****************************************************************************
 *   acp_portal_config
 *   begin                : 03-2007
 *   copyright            : (C) 2007 sjpphpbb
 *   email                : sjpphpbb@club-internet.fr
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *****************************************************************************/

class acp_portal_config
{
	var $u_action;
	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		$user->add_lang('portal/block_acp_portal_config_lang');
		// Set up general vars
		$action = request_var('action', '');
		$action = (isset($_POST['edit'])) ? 'edit' : $action;
		$action = (isset($_POST['add'])) ? 'add' : $action;
		$action = (isset($_POST['save'])) ? 'save' : $action;
		$config_bloc_id = request_var('id', 0);
		$this->tpl_name = 'acp_portal_config';
		$this->page_title = 'ACP_PORTAL_CONFIG';

		switch ($action)
		{
		case 'save':
                $config_bloc_id = request_var('id', '', true);
				$config_bloc_name = request_var('config_bloc_name', '', true);
				$config_name = request_var('config_name', '', true);
				$config_scroll = request_var('config_scroll', '', true);
				$config_value = request_var('config_value', '', true);
				$config_forum = request_var('config_forum', '', true);				
				$sql_ary = array(

                    'config_bloc_id'		=> $config_bloc_id,
                    'config_name'			=> $config_name,					
					'config_scroll'			=> $config_scroll,
					'config_value'			=> $config_value,
					'config_forum'			=> $config_forum					
				);
				if ($config_bloc_id)
				{
				    $sql = 'UPDATE ' . PORTAL_CONFIG_BLOCK_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE config_bloc_id = $config_bloc_id";
				    $message = $user->lang['CONFIG_UPDATED'];
				}
				else
				{
				     $sql = 'INSERT INTO ' . PORTAL_CONFIG_BLOCK_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				     $message = $user->lang['CONFIG_ADDED'];
				}
				$db->sql_query($sql);
				$cache->destroy('config');
				trigger_error($message . adm_back_link($this->u_action));
			break;
			case 'edit':
			case 'add':
				$sql = 'SELECT *
					FROM ' . PORTAL_CONFIG_BLOCK_TABLE . '
					ORDER BY   config_bloc_name ASC';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
 				          if ($action == 'edit' && $config_bloc_id == $row['config_bloc_id'])
					{
						$config_name = $row;					
						$config_scroll = $row;
						$config_value = $row;
						$config_forum = $row;						
					}
				}
				$db->sql_freeresult($result);
				$template->assign_vars(array(
					'S_EDIT'		=> true,
					'U_BACK'		=> $this->u_action,
					'U_ACTION'	=> $this->u_action . '&amp;id=' . $config_bloc_id,
					'CF'		=> (isset($config_forum['config_forum'])) ? $config_forum['config_forum'] : '',					
					'CN'		=> (isset($config_name['config_name'])) ? $config_name['config_name'] : '',					
					'CS'		=> (isset($config_scroll['config_scroll'])) ? $config_scroll['config_scroll'] : '',
					'CV'		=> (isset($config_value['config_value'])) ? $config_value['config_value'] : '')
				);
				return;
			break;
		}
		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action)
		);
		$sql = 'SELECT *
			FROM ' . PORTAL_CONFIG_BLOCK_TABLE . '
			ORDER BY config_bloc_id ASC';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('portal_config', array(

				'CBN'		=> 	$row['config_bloc_name'],
				'CF'		=> 	$row['config_forum'],				
				'CN'		=> 	$row['config_name'],
				'CS'		=> 	$row['config_scroll'],
				'CV'		=> 	$row['config_value'],				
				'U_EDIT'		=> 	$this->u_action . '&amp;action=edit&amp;id=' . $row['config_bloc_id'])
			);
		}
		$db->sql_freeresult($result);
	}
}
?>
