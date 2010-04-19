<?php
/*****************************************************************************
 *   acp_portal_attachments.php
 *   begin                : 03-2007
 *   copyright            : (C) 2007 sjpphpbb
 *   email                : sjpphpbb@club-internet.fr
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *************************************************************************/

class acp_portal_attachments
{
	var $u_action;
	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		$user->add_lang('portal/block_attachments_lang');
		// Set up general vars
		$action = request_var('action', '');
		$action = (isset($_POST['edit'])) ? 'edit' : $action;
		$action = (isset($_POST['add'])) ? 'add' : $action;
		$action = (isset($_POST['save'])) ? 'save' : $action;	
		$attachments_id = request_var('id', 0);		
		$this->tpl_name = 'acp_portal_attachments';
		$this->page_title = 'Acp_portal_attachments';

		switch ($action)
		{
		case 'save':
		
                $attachments_id = request_var('id', '', true);
				$attachments_number = request_var('attachments_number', '', true);
				$attachments_title_block = request_var('attachments_title_block', '', true);				
				$sql_ary = array(
				
                    'attachments_id'			=> $attachments_id,
                    'attachments_number'		=> $attachments_number,					
					'attachments_title_block'	=> $attachments_title_block						
				);
				if ($attachments_id)
				{
				    $sql = 'UPDATE ' . PORTAL_ATTACH_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE attachments_id = $attachments_id";
				    $message = $user->lang['CONFIG_UPDATED'];
				}
				else
				{
				     $sql = 'INSERT INTO ' . PORTAL_ATTACH_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				     $message = $user->lang['CONFIG_ADDED'];
				}
				$db->sql_query($sql);
				$cache->destroy('attachments');
				trigger_error($message . adm_back_link($this->u_action));
			break;

			case 'edit':
			case 'add':
				$sql = 'SELECT *
					FROM ' . PORTAL_ATTACH_TABLE . '
					ORDER BY   attachments_id';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
 				          if ($action == 'edit' && $attachments_id == $row['attachments_id'])
					{
						$attachments_number = $row;
						$attachments_title_block = $row;							
					}
				}
				$db->sql_freeresult($result);		
				$template->assign_vars(array(
					'S_EDIT_ATTACH'	=> true,
					'U_BACK'		=> $this->u_action,					
					'U_ACTION'		=> $this->u_action . '&amp;id=' . $attachments_id,
					'ATTACH_NOMBER'		=> (isset($attachments_number['attachments_number'])) ? $attachments_number['attachments_number'] : '',
					'ATTACH_TITLE_BLOC'	=> (isset($attachments_title_block['attachments_title_block'])) ? $attachments_title_block['attachments_title_block'] : '')
				);	
				return;
			break;
		}					
		
		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action)
		);
				$sql = 'SELECT *
					FROM ' . PORTAL_ATTACH_TABLE . '
					ORDER BY   attachments_id';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('portal_config_attachments', array(
				'ATTACH_NOMBER'		=> 	$row['attachments_number'],
				'ATTACH_TITLE_BLOC'	=> 	$row['attachments_title_block'],					
				'U_EDIT'	=> 	$this->u_action . '&amp;action=edit&amp;id=' . $row['attachments_id'])
			);
		}				
		$db->sql_freeresult($result);		
	}
}
?>
