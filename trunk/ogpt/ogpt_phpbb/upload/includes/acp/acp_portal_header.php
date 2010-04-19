<?php
/*************************************************************************
* @package acp
* @version $Id: acp_portal_header.php
* @copyright (c) sjpphpbb 15-07-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_header
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		$user->add_lang('portal/acp_portal_header_lang');
		// Set up general vars
		$action = request_var('action', '');
		$action = (isset($_POST['edit'])) ? 'edit' : $action;
		$action = (isset($_POST['add'])) ? 'add' : $action;
		$action = (isset($_POST['save'])) ? 'save' : $action;
		$header_id = request_var('id', 0);
        $ord = request_var('ord',0);
        $ord2 = request_var('ord2',0);
        $id = request_var('id',0);
        $id2 = request_var('id2',0);		
		$header_logo_id = request_var('id', 0);
		$table = PORTAL_HEADER_TABLE;
		$table2 = PORTAL_HEADER_CONFIG_TABLE;		
		$this->tpl_name = 'acp_portal_header';
		$this->page_title = 'ACP_PORTAL_HEADER';

		switch ($action)
		{
		case 'save':
				$header_no 		= request_var('header_no', '', true);
				$header_titre 	= request_var('header_titre', '', true);
				$header_image 	= request_var('header_image', '', true);
				$header_ulr_img = request_var('header_ulr_img', '', true);
				$header_portal_disable 	= request_var('header_portal_disable', '', true);

        $sqlnews = "SELECT COUNT(header_no) as total_header_no
               FROM $table
               WHERE  header_id";
                    $resultnews = $db->sql_query($sqlnews);
                    $total_header_no = (int) $db->sql_fetchfield('total_header_no');
                    $db->sql_freeresult($resultnews);			
                    if($header_no) { $fin = $header_no; } 
					else 
					{
                    $fin = $total_header_no + 1; // nombre total de block dans la catégorie             
                    }
				$sql_ary = array(
					'header_no'		=> $fin,
					'header_titre'	=> $header_titre,
					'header_image'	=> $header_image,
					'header_ulr_img'=> $header_ulr_img,
					'header_portal_disable'	=> $header_portal_disable
				);

				if ($header_id)
				{
					$sql = 'UPDATE ' . PORTAL_HEADER_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE header_id = $header_id";
					$message = $user->lang['HEARDER_IMG_UPDATED'];
				}
				else
				{
					$sql = 'INSERT INTO ' . PORTAL_HEADER_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
					$message = $user->lang['HEARDER_IMG_ADDED'];
				}
				$db->sql_query($sql);
				$cache->destroy('header');
				trigger_error($message . adm_back_link($this->u_action));

			break;

			case 'save2':
				$header_logo_id 		= request_var('id', '', true);
				$header_logo_image 		= request_var('header_logo_image', '', true);				
				$header_portal_disable 	= request_var('header_portal_disable', '', true);
				$header_logo_name 		= request_var('header_logo_name', '', true);
				$header_logo_desc 		= request_var('header_logo_desc', '', true);				
				$sql_ary = array(
				
					'header_logo_id'			=> $header_logo_id,				
					'header_logo_image'			=> $header_logo_image,
					'header_portal_disable'		=> $header_portal_disable,
					'header_logo_name'			=> $header_logo_name,
					'header_logo_desc'			=> $header_logo_desc					
				);

				if ($header_logo_id)
				{
					$sql = 'UPDATE ' . PORTAL_HEADER_CONFIG_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE header_logo_id = $header_logo_id";
					$message = $user->lang['HEADER_LOGO_UPDATED'];
				}
				else
				{
					$sql = 'INSERT INTO ' . PORTAL_HEADER_CONFIG_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
					$message = $user->lang['HEADER_LOGO_UPDATED'];
				}
				$db->sql_query($sql);
				$cache->destroy('header');
				trigger_error($message . adm_back_link($this->u_action));
			break;

			case 'delete':
				// Ok, they want to delete their link
				if ($header_id)
				{
					$sql = 'DELETE FROM ' . PORTAL_HEADER_TABLE . "				 
						WHERE header_id = $header_id";
					$db->sql_query($sql);

					$cache->destroy('header');
					trigger_error($user->lang['HEARDER_IMG_REMOVED'] . adm_back_link($this->u_action));
				}
				else
				{
					trigger_error($user->lang['MUST_SELECT_HEARDER_IMG'] . adm_back_link($this->u_action), E_USER_WARNING);
				}
			break;

			case 'edit2':
				$sql = 'SELECT *
					FROM ' . PORTAL_HEADER_CONFIG_TABLE . '				
					ORDER BY  header_logo_id ASC ';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))

					if ($action == 'edit2' && $header_logo_id == $row['header_logo_id'])
					{
						$header_logo_no 		= $row;					
						$header_logo_image 		= $row;
						$header_portal_disable 	= $row;
						$header_logo_name 		= $row;
						$header_logo_desc 		= $row;											
					}
					
				$db->sql_freeresult($result);

				$template->assign_vars(array(
				'S_EDIT_LOGO'	=> true,
				'U_BACK'	=> $this->u_action,
				'U_ACTION_2'=> $this->u_action . '&amp;id=' .$header_logo_id,
				'HEADER_DISABLE'=> (isset($header_portal_disable['header_portal_disable'])) ? $header_portal_disable['header_portal_disable'] : '',
				'NAME_SITE'	=> (isset($header_logo_name['header_logo_name'])) ? $header_logo_name['header_logo_name'] : '',
				'DESC_SITE'	=> (isset($header_logo_desc['header_logo_desc'])) ? $header_logo_desc['header_logo_desc'] : '',	
				'IMG_LOGO'	=> (isset($header_logo_image['header_logo_image'])) ? $header_logo_image['header_logo_image'] : '')
				);

			break;

			case 'edit':
			case 'add':
				$sql = 'SELECT *
					FROM ' . PORTAL_HEADER_TABLE . '				
					ORDER BY  header_no ASC ';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					if ($action == 'edit' && $header_id == $row['header_id'])
					{
						$header_no = $row;
						$header_titre = $row;
						$header_image = $row;
						$header_ulr_img = $row;
						$header_portal_disable = $row;
					}
				}
				$db->sql_freeresult($result);
				// dir liste images
				$dirslist='';
					$dirs = dir('./../styles/prosilver/theme/images/icon_header');
						while ($file = $dirs->read()) 
							{
							if (eregi("header", $file) && eregi(".gif", $file)  ||  eregi(".jpg", $file) || eregi(".png", $file) && !eregi(" ",$file))
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
								$template->assign_block_vars('file_name', array('S_IMG_IMAGE' => $dirslist[$i]));
								}				
				$dirslist='';				
			
				$template->assign_vars(array(
					'S_EDIT'		=> true,
					'U_BACK'		=> $this->u_action,
					'U_ACTION'		=> $this->u_action . '&amp;id=' .$header_id,
					'IMG_NO'		=> (isset($header_no['header_no'])) ? $header_no['header_no'] : '',					
					'TITRE'			=> (isset($header_titre['header_titre'])) ? $header_titre['header_titre'] : '',
					'IMG_IMAGE' 	=> (isset($header_image['header_image'])) ? $header_image['header_image'] : '',
					'IMG_URL'		=> (isset($header_ulr_img['header_ulr_img'])) ? $header_ulr_img['header_ulr_img'] : '',
					'IMG_DISABLE'	=> (isset($header_portal_disable['header_portal_disable'])) ? $header_portal_disable['header_portal_disable'] : '')
				);
				return;
			break;
			
            case 'move_down':
            case 'move_up':
            $sql = "UPDATE $table SET header_no = $ord + $ord2 - header_no WHERE header_id = $id OR header_id = $id2 ";
            if( !($result = $db->sql_query($sql)) )
            $db->sql_query($sql); 
            $cache->destroy('header_no');	
			break;		
		}

		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action)
		);

		$sql = 'SELECT *
			FROM ' . PORTAL_HEADER_TABLE . '		
			ORDER BY header_no  ASC ';
		$result = $db->sql_query($sql);
		{
			$nb_header_img = 0 ;		
			while ( $row = $db->sql_fetchrow($result) )		
             {
                $header_img[$nb_header_img]['header_id'] 				=  $row['header_id'] ;
                $header_img[$nb_header_img]['header_no'] 				=  $row['header_no'] ;
                $header_img[$nb_header_img]['header_titre'] 			=  $row['header_titre'] ;
                $header_img[$nb_header_img]['header_image'] 			=  $row['header_image'] ;
                $header_img[$nb_header_img]['header_ulr_img'] 			=  $row['header_ulr_img'] ;
                $header_img[$nb_header_img]['header_portal_disable'] 	=  $row['header_portal_disable'] ;					
                $nb_header_img ++ ;
             }
			for ( $imod_header_img = 0 ; $imod_header_img < $nb_header_img ; $imod_header_img ++)		
		
			$template->assign_block_vars('header', array(
				'HEADER_NO'   			=>  $header_img[$imod_header_img]['header_no'],
				'HEADER_TITRE'        	=>  $header_img[$imod_header_img]['header_titre'],
				'HEADER_IMAGE'        	=>  $header_img[$imod_header_img]['header_image'],				
				'HEADER_URL_IMG'       	=>  $header_img[$imod_header_img]['header_ulr_img'],						
				'HEADER_DISABLE'		=>  $header_img[$imod_header_img]['header_portal_disable'],
                'U_MOVE_UP'     		=>  $this->u_action . '&amp;action=move_up&amp;idnone=' . $header_img[$imod_header_img]['header_id']."&amp;id2="  . $header_img[$imod_header_img - 1]['header_id'] . "&amp;id=" .  $header_img[$imod_header_img]['header_id']. "&amp;ord=" .  $header_img[$imod_header_img]['header_no'] . "&amp;ord2=" .  $header_img[$imod_header_img - 1]['header_no'],
                'U_MOVE_DOWN'   		=>  $this->u_action . '&amp;action=move_down&amp;idnone=' . $header_img[$imod_header_img]['header_id']."&amp;id2="  . $header_img[$imod_header_img + 1]['header_id']  . "&amp;id=" .  $header_img[$imod_header_img]['header_id'] . "&amp;ord=" .  $header_img[$imod_header_img]['header_no'] . "&amp;ord2=" .  $header_img[$imod_header_img + 1]['header_no'],
                'U_DELETE'     			=>  $this->u_action . '&amp;action=delete&amp;id2=' . $header_img[$imod_header_img]['header_id']."&amp;id="  . $header_img[$imod_header_img]['header_id'],
                'U_EDIT'        		=>  $this->u_action . '&amp;action=edit&amp;id2=' . $header_img[$imod_header_img]['header_id']."&amp;id="  . $header_img[$imod_header_img]['header_id'])					
            );					

		}
		$db->sql_freeresult($result);

			$sql = 'SELECT *
			FROM ' . PORTAL_HEADER_CONFIG_TABLE . '
			ORDER BY   header_logo_id ASC ';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('header_titre', array(
				'IMG_LOGO'		=> $row['header_logo_image'],
				'IMG_LOGO_2'	=> $row['header_logo_image'],
				'NAME_SITE'		=> $row['header_logo_name'],
				'DESC_SITE'		=> $row['header_logo_desc'],				
				'U_IMG_LOGO'	=> $this->u_action . '&amp;action=edit2&amp;id=' . $row['header_logo_id'])
			);
		}
		$db->sql_freeresult($result);
	}
}

?>
