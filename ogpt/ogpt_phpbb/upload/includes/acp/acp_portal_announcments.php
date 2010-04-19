<?php
/*****************************************************************************
 *   acp_portal_annoncment.php
 *   begin                : 03-2007
 *   copyright            : (C) 2007 sjpphpbb
 *   email                : sjpphpbb@club-internet.fr
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *************************************************************************/

class acp_portal_announcments
{
	var $u_action;
	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		$user->add_lang('portal/block_announcments_lang');
		// Set up general vars
		$action = request_var('action', '');
		$action = (isset($_POST['edit'])) ? 'edit' : $action;
		$action = (isset($_POST['add'])) ? 'add' : $action;
		$action = (isset($_POST['save'])) ? 'save' : $action;	
		$announcments_id = request_var('id', 0);		
		$this->tpl_name = 'acp_portal_announcments';
		$this->page_title = 'ACP_PORTAL_ANNOUNCMENTS';

		switch ($action)
		{
		case 'save':
		
                $announcments_id = request_var('id', '', true);
				$announcments_number = request_var('announcments_number', '', true);
				$announcments_day = request_var('announcments_day', '', true);
				$announcments_length = request_var('announcments_length', '', true);
				$announcments_forum = request_var('announcments_forum', '', true);				
				$sql_ary = array(

                    'announcments_id'		=> $announcments_id,
                    'announcments_number'	=> $announcments_number,					
					'announcments_day'		=> $announcments_day,
					'announcments_length'	=> $announcments_length,
					'announcments_forum'	=> $announcments_forum					
				);
				if ($announcments_id)
				{
				    $sql = 'UPDATE ' . PORTAL_ANNOUNCMENTS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE announcments_id = $announcments_id";
				    $message = $user->lang['CONFIG_UPDATED'];
				}
				else
				{
				     $sql = 'INSERT INTO ' . PORTAL_ANNOUNCMENTS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				     $message = $user->lang['CONFIG_ADDED'];
				}
				$db->sql_query($sql);
				$cache->destroy('announcments');
				trigger_error($message . adm_back_link($this->u_action));
			break;

			case 'edit':
			case 'add':
				$sql = 'SELECT *
					FROM ' . PORTAL_ANNOUNCMENTS_TABLE . '
					ORDER BY   announcments_id';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
 				          if ($action == 'edit' && $announcments_id == $row['announcments_id'])
					{
						$announcments_number = $row;
						$announcments_day = $row;
						$announcments_length = $row;
						$announcments_forum = $row;											
					}
				}
				$db->sql_freeresult($result);		
				$template->assign_vars(array(
					'S_EDIT_ANNOUNCMENT'		=> true,
					'U_BACK'		=> $this->u_action,					
					'U_ACTION'	=> $this->u_action . '&amp;id=' . $announcments_id,
					'A_NOMBER'		=> (isset($announcments_number['announcments_number'])) ? $announcments_number['announcments_number'] : '',
					'A_DAY'		=> (isset($announcments_day['announcments_day'])) ? $announcments_day['announcments_day'] : '',
					'A_LENGTH'		=> (isset($announcments_length['announcments_length'])) ? $announcments_length['announcments_length'] : '',						
					'A_FORUM'		=> (isset($announcments_forum['announcments_forum'])) ? $announcments_forum['announcments_forum'] : '')
				);	
				return;
			break;
		}					
		
		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action)
		);
				$sql = 'SELECT *
					FROM ' . PORTAL_ANNOUNCMENTS_TABLE . '
					ORDER BY   announcments_id';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('portal_config_announcment', array(
				'A_NOMBER'		=> 	$row['announcments_number'],
				'A_DAY'		=> 	$row['announcments_day'],
				'A_LENGTH'		=> 	$row['announcments_length'],
				'A_FORUM'		=> 	$row['announcments_forum'],					
				'U_EDIT'	=> 	$this->u_action . '&amp;action=edit&amp;id=' . $row['announcments_id'])
			);
		}				
		$db->sql_freeresult($result);		
	}
}
?>
