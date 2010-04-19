<?php
/*****************************************************************************
 *   acp_portal_annoncment.php
 *   begin                : 03-2007
 *   copyright            : (C) 2007 sjpphpbb
 *   email                : sjpphpbb@club-internet.fr
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *************************************************************************/

class acp_portal_news
{
	var $u_action;
	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		$user->add_lang('portal/block_news_lang');
		// Set up general vars
		$action = request_var('action', '');
		$action = (isset($_POST['edit'])) ? 'edit' : $action;
		$action = (isset($_POST['add'])) ? 'add' : $action;
		$action = (isset($_POST['save'])) ? 'save' : $action;	
		$news_id = request_var('id', 0);		
		$this->tpl_name = 'acp_portal_news';
		$this->page_title = 'ACP_PORTAL_NEWS';

		switch ($action)
		{
		case 'save':
		
                $news_id = request_var('id', '', true);
				$news_number = request_var('news_number', '', true);
				$news_day = request_var('news_day', '', true);
				$news_length = request_var('news_length', '', true);
				$news_forum = request_var('news_forum', '', true);
				$news_title_block = request_var('news_title_block', '', true);				
				$sql_ary = array(
				
                    'news_id'		=> $news_id,
                    'news_number'	=> $news_number,					
					'news_day'		=> $news_day,
					'news_length'	=> $news_length,
					'news_forum'	=> $news_forum,
					'news_title_block'	=> $news_title_block						
				);
				if ($news_id)
				{
				    $sql = 'UPDATE ' . PORTAL_NEWS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE news_id = $news_id";
				    $message = $user->lang['CONFIG_UPDATED'];
				}
				else
				{
				     $sql = 'INSERT INTO ' . PORTAL_NEWS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				     $message = $user->lang['CONFIG_ADDED'];
				}
				$db->sql_query($sql);
				$cache->destroy('news');
				trigger_error($message . adm_back_link($this->u_action));
			break;

			case 'edit':
			case 'add':
				$sql = 'SELECT *
					FROM ' . PORTAL_NEWS_TABLE . '
					ORDER BY   news_id';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
 				          if ($action == 'edit' && $news_id == $row['news_id'])
					{
						$news_number = $row;
						$news_day = $row;
						$news_length = $row;
						$news_forum = $row;
						$news_title_block = $row;							
					}
				}
				$db->sql_freeresult($result);		
				$template->assign_vars(array(
					'S_EDIT_NEW'	=> true,
					'U_BACK'		=> $this->u_action,					
					'U_ACTION'		=> $this->u_action . '&amp;id=' . $news_id,
					'A_NOMBER'		=> (isset($news_number['news_number'])) ? $news_number['news_number'] : '',
					'A_DAY'			=> (isset($news_day['news_day'])) ? $news_day['news_day'] : '',
					'A_LENGTH'		=> (isset($news_length['news_length'])) ? $news_length['news_length'] : '',
					'A_TITLE_BLOC'	=> (isset($news_title_block['news_title_block'])) ? $news_title_block['news_title_block'] : '',
					'A_FORUM'		=> (isset($news_forum['news_forum'])) ? $news_forum['news_forum'] : '')
				);	
				return;
			break;
		}					
		
		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action)
		);
				$sql = 'SELECT *
					FROM ' . PORTAL_NEWS_TABLE . '
					ORDER BY   news_id';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('portal_config_news', array(
				'A_NOMBER'		=> 	$row['news_number'],
				'A_DAY'			=> 	$row['news_day'],
				'A_LENGTH'		=> 	$row['news_length'],
				'A_FORUM'		=> 	$row['news_forum'],
				'TITLE_BLOC'	=> 	$row['news_title_block'],					
				'U_EDIT'	=> 	$this->u_action . '&amp;action=edit&amp;id=' . $row['news_id'])
			);
		}				
		$db->sql_freeresult($result);		
	}
}
?>
