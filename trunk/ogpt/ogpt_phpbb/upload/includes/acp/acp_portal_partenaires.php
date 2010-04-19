<?php
/*************************************************************************
* @package acp
* @version $Id: acp_parenaires.php
* @copyright (c) sjpphpbb.net 03-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_partenaires
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$user->add_lang('portal/block_partenaires_lang');

		// Set up general vars
		$action = request_var('action', '');
		$action = (isset($_POST['edit'])) ? 'edit' : $action;
		$action = (isset($_POST['add'])) ? 'add' : $action;
		$action = (isset($_POST['save'])) ? 'save' : $action;
		$partenaires_id = request_var('id', 0);


		$this->tpl_name = 'acp_portal_partenaires';
		$this->page_title = 'ACP_PORTAL_PARTENAIRES';

		switch ($action)
		{

		case 'save':

                $partenaires_id = request_var('id', '', true);
				$partenaires_img = request_var('partenaires_img', '', true);
				$partenaires_flag = request_var('partenaires_flag', '', true);				
				$partenaires_url = request_var('partenaires_url', '', true);

				$sql_ary = array(

                    'partenaires_id'		=> $partenaires_id,
					'partenaires_img'		=> $partenaires_img,
					'partenaires_flag'		=> $partenaires_flag,					
					'partenaires_url'		=> $partenaires_url
				);

				if ($partenaires_id)
				{
				    $sql = 'UPDATE ' . PARTENAIRES_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE partenaires_id = $partenaires_id";
				    $message = $user->lang['PARTENAIRES_UPDATED'];
				}
				else
				{
				     $sql = 'INSERT INTO ' . PARTENAIRES_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				     $message = $user->lang['PARTENAIRES_ADDED'];
				}
				$db->sql_query($sql);

				$cache->destroy('partenaires');

				trigger_error($message . adm_back_link($this->u_action));

			break;

			case 'delete':

				// Ok, they want to delete their quote
				if ($partenaires_id)
				{
					$sql = 'DELETE FROM ' . PARTENAIRES_TABLE . "
						WHERE partenaires_id = $partenaires_id";
					$db->sql_query($sql);

					$cache->destroy('partenaires');

					trigger_error($user->lang['PARTENAIRES_REMOVED'] . adm_back_link($this->u_action));
				}
				else
				{
					trigger_error($user->lang['MUST_SELECT_PARTENAIRES'] . adm_back_link($this->u_action), E_USER_WARNING);
				}
			break;

			case 'edit':
			case 'add':

				$sql = 'SELECT *
					FROM ' . PARTENAIRES_TABLE . '
					ORDER BY   partenaires_url ASC';
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{

 				          if ($action == 'edit' && $partenaires_id == $row['partenaires_id'])

					{
						$partenaires_url = $row;
						$partenaires_img = $row;
						$partenaires_flag = $row;						
					}
				}
				$db->sql_freeresult($result);

				$template->assign_vars(array(
					'S_EDIT'		=> true,
					'U_BACK'		=> $this->u_action,
					'U_ACTION'	=> $this->u_action . '&amp;id=' . $partenaires_id,
					'PARTENAIRES_URL'		=> (isset($partenaires_url['partenaires_url'])) ? $partenaires_url['partenaires_url'] : '',
					'PARTENAIRES_FLAG'		=> (isset($partenaires_flag['partenaires_flag'])) ? $partenaires_flag['partenaires_flag'] : '',					
					'PARTENAIRES_IMG'		=> (isset($partenaires_img['partenaires_img'])) ? $partenaires_img['partenaires_img'] : '')
				);


				return;

			break;
		}

		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action)
		);

		$sql = 'SELECT *
			FROM ' . PARTENAIRES_TABLE . '
			ORDER BY partenaires_id ASC';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('partenaires', array(

				'PARTENAIRES_URL'		=> 	$row['partenaires_url'],
				'PARTENAIRES_IMG'		=> 	$row['partenaires_img'],
				'PARTENAIRES_FLAG'		=> 	$row['partenaires_flag'],				
				'U_EDIT'		=> 	$this->u_action . '&amp;action=edit&amp;id=' . $row['partenaires_id'],
				'U_DELETE'	=> 	$this->u_action . '&amp;action=delete&amp;id=' . $row['partenaires_id'])

			);
		}

		$db->sql_freeresult($result);

	}
}

?>
