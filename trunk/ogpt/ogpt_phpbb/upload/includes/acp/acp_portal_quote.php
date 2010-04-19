<?php
/*************************************************************************
* @package acp
* @version $Id: acp_quote.php
* @copyright (c) sjpphpbb.net 12-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/
class acp_portal_quote
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$user->add_lang('portal/block_quote_lang');

		// Set up general vars
		$action = request_var('action', '');
		$action = (isset($_POST['edit'])) ? 'edit' : $action;
		$action = (isset($_POST['add'])) ? 'add' : $action;
		$action = (isset($_POST['save'])) ? 'save' : $action;
		$quote_id = request_var('id', 0);
		$quote_titre_id = request_var('id', 0);

		$this->tpl_name = 'acp_portal_quote';
		$this->page_title = 'ACP_PORTAL_QUOTE';

		switch ($action)
		{

		case 'save':

                $quote_id = request_var('id', '', true);
				$quote = request_var('quote', '', true);
				$author = request_var('author', '', true);

				$sql_ary = array(

                    'quote_id'		=> $quote_id,
					'quote'		=> $quote,
					'author'		=> $author
				);

				if ($quote_id)
				{
				    $sql = 'UPDATE ' . QUOTE_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE quote_id = $quote_id";
				    $message = $user->lang['QUOTE_UPDATED'];
				}
				else
				{
				     $sql = 'INSERT INTO ' . QUOTE_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				     $message = $user->lang['QUOTE_ADDED'];
				}
				$db->sql_query($sql);

				$cache->destroy('quote');

				trigger_error($message . adm_back_link($this->u_action));

			break;

			case 'save2':

				$quote_titre_id = request_var('id', '', true);
				$quote_titre = request_var('quote_titre', '', true);

				$sql_ary = array(

					'quote_titre_id'	=> $quote_titre_id,
					'quote_titre'		=> $quote_titre
				);

				if ($quote_titre_id)
				{
					$sql = 'UPDATE ' . QUOTE_TITRE_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE quote_titre_id = $quote_titre_id";
					$message = $user->lang['QUOTE_TITRE_BLOC_UPDATED'];
				}
				else
				{
					$sql = 'INSERT INTO ' . QUOTE_TITRE_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
					$message = $user->lang['QUOTE_TITRE_BLOC_ADDED'];
				}
				$db->sql_query($sql);

				$cache->destroy('quote_titre');

				trigger_error($message . adm_back_link($this->u_action));

			break;

			case 'delete':

				// Ok, they want to delete their quote
				if ($quote_id)
				{
					$sql = 'DELETE FROM ' . QUOTE_TABLE . "
						WHERE quote_id = $quote_id";
					$db->sql_query($sql);

					$cache->destroy('quote');

					trigger_error($user->lang['QUOTE_REMOVED'] . adm_back_link($this->u_action));
				}
				else
				{
					trigger_error($user->lang['MUST_SELECT_QUOTE'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

			break;

			case 'edit2':

				$sql = 'SELECT *
					FROM ' . QUOTE_TITRE_TABLE . '
					ORDER BY  quote_titre ASC ';
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					if ($action == 'edit2' && $quote_titre_id == $row['quote_titre_id'])
					{
						$quote_titre = $row;
					}
				}
				$db->sql_freeresult($result);

				$template->assign_vars(array(

					'S_EDIT_TITRE'		=> true,
					'U_BACK'			=> $this->u_action,
					'U_ACTION_2'		=> $this->u_action . '&amp;id=' .$quote_titre_id,
					'QUOTE_TITRE'		=> (isset($quote_titre['quote_titre'])) ? $quote_titre['quote_titre'] : '')
				);


			break;

			case 'edit':
			case 'add':

				$sql = 'SELECT *
					FROM ' . QUOTE_TABLE . '
					ORDER BY   quote ASC, author ASC';
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{

 				          if ($action == 'edit' && $quote_id == $row['quote_id'])

					{
						$quote = $row;
						$author = $row;
					}
				}
				$db->sql_freeresult($result);

				$template->assign_vars(array(
					'S_EDIT'		=> true,
					'U_BACK'		=> $this->u_action,
					'U_ACTION'	=> $this->u_action . '&amp;id=' . $quote_id,
					'QUOTE'		=> (isset($quote['quote'])) ? $quote['quote'] : '',
					'AUTHOR'		=> (isset($author['author'])) ? $author['author'] : '')
				);


				return;

			break;
		}

		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action)
		);

		$sql = 'SELECT *
			FROM ' . QUOTE_TABLE . '
			ORDER BY quote_id ASC , quote ASC , author ASC';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('quote', array(

				'QUOTE'		=> 	$row['quote'],
				'AUTHOR'		=> 	$row['author'],
				'U_EDIT'		=> 	$this->u_action . '&amp;action=edit&amp;id=' . $row['quote_id'],
				'U_DELETE'	=> 	$this->u_action . '&amp;action=delete&amp;id=' . $row['quote_id'])

			);
		}


		$db->sql_freeresult($result);

			$sql = 'SELECT *
			FROM ' . QUOTE_TITRE_TABLE . '
			ORDER BY   quote_titre_id ASC  ';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('quote_titre', array(

				'QUOTE_TITRE'		=> $row['quote_titre'],
				'QUOTE_DISABLE'		=> ($row['quote_disable']) ? sprintf($user->lang['DISABLE'])  : sprintf($user->lang['ENABLE']) ,
				'U_EDIT_DISABLE'		=> $this->u_action . '&amp;action=edit2&amp;id=' . $row['quote_titre_id'],
				'U_EDIT_TITRE'		=> $this->u_action . '&amp;action=edit2&amp;id=' . $row['quote_titre_id'])
			);
		}
		$db->sql_freeresult($result);


	}
}

?>
