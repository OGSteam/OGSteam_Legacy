<?php
/*****************************************************************************
 *  acp_portal_config_coll
 *   begin                : 03-2007
 *   copyright            : (C) 2007 sjpphpbb
 *   email                : sjpphpbb@club-internet.fr
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *****************************************************************************/

class acp_portal_config_coll
{
	var $u_action;
	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		$user->add_lang('portal/block_acp_portal_config_lang');
        $user->add_lang('portal/acp_portal_include_block_lang');		
		// Set up general vars
		$action = request_var('action', '');
		$action = (isset($_POST['edit'])) ? 'edit' : $action;
		$action = (isset($_POST['add'])) ? 'add' : $action;
		$action = (isset($_POST['save'])) ? 'save' : $action;	
		$config_coll_id = request_var('id', 0);		
		$this->tpl_name = 'acp_portal_config_coll';
		$this->page_title = 'ACP_CONFIG_COLL';
		
        $sql = 'SELECT *
            FROM ' . PORTAL_CONFIG_COLL_TABLE . '
            ORDER BY config_version';

        $result = $db->sql_query($sql);
                while ($row = $db->sql_fetchrow($result))
                {
                    $cur_version  = $row;
                }
                $errstr = '';
                $errnos = 0;
                $info = get_remote_file('sjpphpbb.net', '', 'sjpphpbbportal.txt', $errstr, $errnos);
                if ($info === false)
                    {
                        trigger_error($errstr, E_USER_WARNING);
                    }
                $info = explode("\n", $info);
                $lat_version = trim($info[0]);
                $announcement_url = trim($info[1]);
                $update_link = append_sid($phpbb_root_path . 'install/index.' . $phpEx, 'imod_portal_blocke=update');

                $up_to_dates = (version_compare(str_replace('', '', strtolower($cur_version['config_version'])), str_replace('', '', strtolower($lat_version)), '<')) ? false : true;

                $template->assign_vars(array(
                    'S_UP_TO_DATE'      => $up_to_dates,
                    'S_VERSION_CHECK'   => true,
                    'U_ACTION'          => $this->u_action,
					'VERSION_DONLOAD'	=> $announcement_url,
                    'LATEST_VERSION'    => $lat_version,
                    'CURRENT_VERSION'   => $cur_version['config_version'],
                    ));         		

		switch ($action)
		{
		case 'save':
		
                $config_coll_id = request_var('id', '', true);
				$config_coll_pacing = request_var('config_coll_pacing', '', true);
				$config_g_w = request_var('config_g_w', '', true);
				$config_d_w = request_var('config_d_w', '', true);				
				$sql_ary = array(

                    'config_coll_id'		=> $config_coll_id,
                    'config_coll_pacing'	=> $config_coll_pacing,					
					'config_g_w'			=> $config_g_w,
					'config_d_w'			=> $config_d_w					
				);
				if ($config_coll_id)
				{
				    $sql = 'UPDATE ' . PORTAL_CONFIG_COLL_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE config_coll_id = $config_coll_id";
				    $message = $user->lang['CONFIG_UPDATED'];
				}
				else
				{
				     $sql = 'INSERT INTO ' . PORTAL_CONFIG_COLL_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				     $message = $user->lang['CONFIG_ADDED'];
				}
				$db->sql_query($sql);
				$cache->destroy('config');
				trigger_error($message . adm_back_link($this->u_action));
			break;

			case 'edit':
			case 'add':
				$sql = 'SELECT *
					FROM ' . PORTAL_CONFIG_COLL_TABLE . '
					ORDER BY   config_coll_pacing ASC';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
 				          if ($action == 'edit' && $config_coll_id == $row['config_coll_id'])
					{
						$config_coll_pacing = $row;					
						$config_g_w = $row;
						$config_d_w = $row;						
					}
				}
				$db->sql_freeresult($result);		
				$template->assign_vars(array(
					'S_EDIT_COLL'		=> true,
					'U_BACK'		=> $this->u_action,					
					'U_ACTION'	=> $this->u_action . '&amp;id=' . $config_coll_id,
					'PACING'		=> (isset($config_coll_pacing['config_coll_pacing'])) ? $config_coll_pacing['config_coll_pacing'] : '',
					'DROITE_W'		=> (isset($config_d_w['config_d_w'])) ? $config_d_w['config_d_w'] : '',					
					'GAUCHE_W'		=> (isset($config_g_w['config_g_w'])) ? $config_g_w['config_g_w'] : '')
				);	
				return;
			break;
		}					
		
		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action)
		);
				$sql = 'SELECT *
					FROM ' . PORTAL_CONFIG_COLL_TABLE . '
					ORDER BY   config_coll_id';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('portal_config_coll', array(
				'PACING'		=> 	$row['config_coll_pacing'],
				'DROITE_W'		=> 	$row['config_d_w'],
				'GAUCHE_W'		=> 	$row['config_g_w'],				
				'U_EDIT'	=> 	$this->u_action . '&amp;action=edit&amp;id=' . $row['config_coll_id'])
			);
		}				
		$db->sql_freeresult($result);		
	}
}
?>
