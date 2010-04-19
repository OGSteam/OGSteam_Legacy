<?php
/*************************************************************************
*
* @package acp
* @version $Id: acp_menu.php
* @copyright (c) sjpphpbb.net 03-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*************************************************************************/

class acp_portal_menu
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$user->add_lang('portal/block_menu_lang');

		// Set up general vars
		$action = request_var('action', '');
		$action = (isset($_POST['edit'])) ? 'edit' : $action;
		$action = (isset($_POST['add'])) ? 'add' : $action;
		$action = (isset($_POST['save'])) ? 'save' : $action;
		$menu_id = request_var('id', 0);
		$menu_order = request_var('id', 0);
        $ord = request_var('ord',0);
        $ord2 = request_var('ord2',0);
        $id = request_var('id',0);
        $id2 = request_var('id2',0);		
		$table = MENU_TABLE;		
		$this->tpl_name = 'acp_portal_menu';
		$this->page_title = 'ACP_PORTAL_MENU';

		switch ($action)
		{	
		// sauvegarde
		case 'save':
                $menu_id     	= request_var('id', '', true);		
				$menu_img 		= request_var('menu_img', '', true);
				$menu_name 		= request_var('menu_name', '', true);
				$menu_url 		= request_var('menu_url', '', true);
				$menu_view 		= request_var('menu_view', '', true);
				$menu_order 	= request_var('menu_order', '', true);
				
        $sqlnews = "SELECT MAX(menu_order) as total_menu_order
               FROM $table
               WHERE menu_order ";
                    $resultnews = $db->sql_query($sqlnews);
                    $total_menu_order = (int) $db->sql_fetchfield('total_menu_order');
                    $db->sql_freeresult($resultnews);
                    if($menu_order) { $fin = $menu_order; } 
					else 
					{
                    $fin = $total_menu_order + 1; // nombre total de block dans la catégorie             
                    } // nombre total de block dans la catégorie    					
				
				$sql_ary 		= array(
					'menu_id'       => $menu_id,  // modification de la variable
					'menu_img'		=> $menu_img,
                    'menu_name'		=> $menu_name,
					'menu_url'		=> $menu_url,
                    'menu_view'		=> $menu_view,
                    'menu_order'	=> $fin,					
				);

				if ($menu_id)
				{
				    $sql = 'UPDATE ' . $table . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE menu_id = $menu_id";
				    $message = $user->lang['MENU_UPDATED'];
				}
				else
				{
				     $sql = 'INSERT INTO ' . $table . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				     $message = $user->lang['MENU_ADDED'];
				}
				$db->sql_query($sql);

				$cache->destroy('menu');

				trigger_error($message . adm_back_link($this->u_action));

			break;
			// supprimer un lien
			case 'delete':
				if ($menu_id)
				{
					$sql = 'DELETE FROM ' . $table . "
						WHERE menu_id = $menu_id";
					$db->sql_query($sql);

					$cache->destroy('menu');

					trigger_error($user->lang['MENU_REMOVED'] . adm_back_link($this->u_action));
				}
				else
				{
					trigger_error($user->lang['MUST_SELECT_MENU'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

			break;
			// ajouter editer des liens
			case 'edit':
			case 'add':
				$sql = "SELECT *
					FROM $table
					ORDER BY   menu_name ASC";
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
 				          if ($action == 'edit' && $menu_id == $row['menu_id'])
					{
						$menu_img = $row;
						$menu_name = $row;
						$menu_url = $row;
						$menu_view = $row;
						$menu_order = $row;						
					}
				}
				$db->sql_freeresult($result);
				
				
				$dirslist='';
					$dirs = dir('./../images/icon_menu/');
						while ($file = $dirs->read()) 
							{
							if (eregi("menu", $file) && eregi(".gif", $file)  ||  eregi(".jpg", $file) || eregi(".png", $file) && !eregi(" ",$file))
								{
									$dirslist .= "$file ";
								}
							}
						closedir($dirs->handle);
						$dirslist = explode(" ", $dirslist);
						sort($dirslist);	
							for ( $i=0; $i < sizeof($dirslist); $i++ ) 
								{
								if($dirslist[$i] != '')
								$template->assign_block_vars('file_name', array('S_MENU_IMG' => $dirslist[$i]));
								}				
				$dirslist='';				

				$template->assign_vars(array(
					'S_EDIT'	 => true,
					'U_BACK'	 => $this->u_action,
					'U_ACTION'	 => $this->u_action . '&amp;id=' . $menu_id,
					'MENU_ORDER' => (isset($menu_order['menu_order'])) ? $menu_order['menu_order'] : '',					
					'MENU_IMG'	 => (isset($menu_img['menu_img'])) ? $menu_img['menu_img'] : '',
					'MENU1_IMG'	 => $row['menu_img'],
					'MENU_NAME'	 => (isset($menu_name['menu_name'])) ? $menu_name['menu_name'] : '',
					'MENU_URL'	 => (isset($menu_url['menu_url'])) ? $menu_url['menu_url'] : '',
					'MENU_VIEW'	 => (isset($menu_view['menu_view'])) ? $menu_view['menu_view'] : ''	)
				);
				return;
			break;
			
            case 'move_down':
            case 'move_up':

            $sql = "UPDATE $table SET menu_order = $ord + $ord2 - menu_order WHERE menu_id = $id OR menu_id = $id2 ";
            if( !($result = $db->sql_query($sql)) )
            $db->sql_query($sql); 
            $cache->destroy('menu_order');	
			break;
		}			
		
		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action)
		);
		// Affichage
		$sql = "SELECT *
			FROM $table
			ORDER BY menu_order ASC ";
		$result = $db->sql_query($sql);
		{
			$nb_menu = 0 ;		
			while ( $row = $db->sql_fetchrow($result) )		
             {
                $menu_block[$nb_menu]['menu_id'] 		=  $row['menu_id'] ;
                $menu_block[$nb_menu]['menu_order'] 	=  $row['menu_order'] ;
                $menu_block[$nb_menu]['menu_view'] 		=  $row['menu_view'] ;
                $menu_block[$nb_menu]['menu_url'] 		=  $row['menu_url'] ;
                $menu_block[$nb_menu]['menu_name'] 		=  $row['menu_name'] ;
                $menu_block[$nb_menu]['menu_img'] 		=  $row['menu_img'] ;;					
                $nb_menu ++ ;
             }
			for ( $imod_menu_block = 0 ; $imod_menu_block < $nb_menu ; $imod_menu_block ++)	
			$template->assign_block_vars('menu', array(				
				'MENU_ORDER'   	=>  $menu_block[$imod_menu_block]['menu_order'],
				'MENU_VIEW'     =>  $menu_block[$imod_menu_block]['menu_view'],
				'MENU_URL'      =>  $menu_block[$imod_menu_block]['menu_url'],				
				'MEU_NAME'      =>  $menu_block[$imod_menu_block]['menu_name'],
				'MENU_IMG'      =>  $menu_block[$imod_menu_block]['menu_img'],				
                'U_MOVE_UP'     =>  $this->u_action . '&amp;action=move_up&amp;idnone=' . $menu_block[$imod_menu_block]['menu_id']."&amp;id2="  . $menu_block[$imod_menu_block - 1]['menu_id'] . "&amp;id=" .  $menu_block[$imod_menu_block]['menu_id']. "&amp;ord=" .  $menu_block[$imod_menu_block]['menu_order'] . "&amp;ord2=" .  $menu_block[$imod_menu_block - 1]['menu_order'],
                'U_MOVE_DOWN'   =>  $this->u_action . '&amp;action=move_down&amp;idnone=' . $menu_block[$imod_menu_block]['menu_id']."&amp;id2="  . $menu_block[$imod_menu_block + 1]['menu_id']  . "&amp;id=" .  $menu_block[$imod_menu_block]['menu_id'] . "&amp;ord=" .  $menu_block[$imod_menu_block]['menu_order'] . "&amp;ord2=" .  $menu_block[$imod_menu_block + 1]['menu_order'],				
                'U_DELETE'     	=>  $this->u_action . '&amp;action=delete&amp;id2=' . $menu_block[$imod_menu_block]['menu_id']."&amp;id="  . $menu_block[$imod_menu_block]['menu_id'],
                'U_EDIT'        =>  $this->u_action . '&amp;action=edit&amp;id2=' . $menu_block[$imod_menu_block]['menu_id']."&amp;id="  . $menu_block[$imod_menu_block]['menu_id'])					
            );	
		}
		$db->sql_freeresult($result);
	}
}

?>
