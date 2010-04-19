<?php
/*************************************************************************
* @package acp
* @version $Id: acp_portal_include_block.php
* @copyright (c) sjpphpbb.net - gigi_online 20-01-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/
class acp_portal_include_block
    {
    var $u_action;
    function main($id, $imod_portal_blocke)
    {
        global $db, $user, $auth, $template, $cache;
        global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
        $user->add_lang('portal/acp_portal_include_block_lang');
		$user->add_lang('portal/block_acp_portal_config_lang');		
        $this->tpl_name = 'acp_portal_include_block';
        $this->page_title = 'acp_portal_include_block';
        $error = $notify = array();
        $action = request_var('action', '');        
        $action = (isset($_POST['edit'])) ? 'edit' : $action;
        $action = (isset($_POST['save'])) ? 'save' : $action;
        $action = (isset($_POST['add'])) ? 'add' : $action;     
        $portal_block_includes_id = request_var('id', 0);       
        $ord = request_var('ord',0);
        $ord2 = request_var('ord2',0);
        $id = request_var('id',0);
        $id2 = request_var('id2',0);
        $colid = request_var('colid',0);
		$config_coll_id = request_var('id', 0);		
        $table = PORTAL_BLOCK_INCLUDES_ORDER_TABLE;		

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
		
		case 'savecoll':
		
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
		
		case 'saveperm':

                $portal_block_includes_id = request_var('id', '', true);
				$portal_block_includes_view = request_var('portal_block_includes_view', '', true);

				$sql_ary = array(
                    'portal_block_includes_id'		=> $portal_block_includes_id,
					'portal_block_includes_view'	=> $portal_block_includes_view
				);

				if ($portal_block_includes_id)
				{
				    $sql = 'UPDATE ' . PORTAL_BLOCK_INCLUDES_ORDER_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE portal_block_includes_id = $portal_block_includes_id";
				    $message = $user->lang['PORTAL_BLOCK_VIEW_UPDATED'];
				}
				else
				{
				     $sql = 'INSERT INTO ' . PORTAL_BLOCK_INCLUDES_ORDER_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				     $message = $user->lang['PORTAL_BLOCK_VIEW_UPDATED'];
				}
				$db->sql_query($sql);
				$cache->destroy('portal_block_includes');
				trigger_error($message . adm_back_link($this->u_action));

			break;		

        case 'save':
                $portal_block_includes_nom              = request_var('portal_block_includes_nom','',true);
                $portal_block_includes_name             = request_var('portal_block_includes_name','',true);                
                $portal_block_includes_disable          = request_var('portal_block_includes_disable', '', true);
                $portal_block_includes_position         = request_var('portal_block_includes_position', '', true);              
                $portal_block_includes_order            = request_var('portal_block_includes_order', '', true);
				$portal_block_includes_view 			= request_var('portal_block_includes_view', '', true);			
				
                  // calcul du nombre total de block par rapport à la position choisi
                   $sqlnews = "SELECT MAX(portal_block_includes_order) as total_order
                            FROM $table
                            WHERE portal_block_includes_position = $portal_block_includes_position";
                                $resultnews = $db->sql_query($sqlnews);
                                $total_order_block = (int) $db->sql_fetchfield('total_order');
                                $db->sql_freeresult($resultnews);
                                $fin = $total_order_block + 1; // nombre total de block dans la catégorie

                    $sql_ary = array(
                    'portal_block_includes_nom'             => $portal_block_includes_nom,
                    'portal_block_includes_name'            => $portal_block_includes_name,                 
                    'portal_block_includes_order'           => $fin,    // imod_portal_blockification de la variable
                    'portal_block_includes_disable'         => $portal_block_includes_disable,
                    'portal_block_includes_position'        => $portal_block_includes_position,
					'portal_block_includes_view'			=> $portal_block_includes_view					
                
                );
                if ($portal_block_includes_id)
                {               
                $sql = 'UPDATE ' . PORTAL_BLOCK_INCLUDES_ORDER_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE portal_block_includes_id = $portal_block_includes_id";

                    $message = $user->lang['BLOCK_UPDATED'];
                }
                else
                {
                     $sql = 'INSERT INTO ' . PORTAL_BLOCK_INCLUDES_ORDER_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
                     $message = $user->lang['BLOCK_ADDED'];
                }
                $db->sql_query($sql);
                $cache->destroy('portal_block_includes');
                
                trigger_error($message . adm_back_link($this->u_action));

            break;
			
			case 'editcoll':
				$sqlcoll = 'SELECT *
					FROM ' . PORTAL_CONFIG_COLL_TABLE . '
					ORDER BY   config_coll_pacing ASC';
				$resultcoll = $db->sql_query($sqlcoll);
				while ($row = $db->sql_fetchrow($resultcoll))
				{
 				          if ($action == 'editcoll' && $config_coll_id == $row['config_coll_id'])
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
					'U_ACTION_COLL'	=> $this->u_action . '&amp;id=' . $config_coll_id,
					'PACING'		=> (isset($config_coll_pacing['config_coll_pacing'])) ? $config_coll_pacing['config_coll_pacing'] : '',
					'DROITE_W'		=> (isset($config_d_w['config_d_w'])) ? $config_d_w['config_d_w'] : '',					
					'GAUCHE_W'		=> (isset($config_g_w['config_g_w'])) ? $config_g_w['config_g_w'] : '')
				);					

            break;			
			
            case 'editperm':

                $sqlperm = 'SELECT *
                    FROM ' . PORTAL_BLOCK_INCLUDES_ORDER_TABLE . '
                    ORDER BY   portal_block_includes_id ';
                $resultperm = $db->sql_query($sqlperm);

                while ($row = $db->sql_fetchrow($resultperm))
                {
                if ($action == 'editperm' && $portal_block_includes_id == $row['portal_block_includes_id'])
                    {
                    $portal_block_includes_nom              = $row;					
                    $portal_block_includes_view             = $row;                    
                    }
                }
                $db->sql_freeresult($result);

                $template->assign_vars(array(
                    'S_EDIT_PERM'        	=> true,				
                    'U_BACK'        		=> $this->u_action,
                    'BLOCK_NOM'     => (isset($portal_block_includes_nom['portal_block_includes_nom'])) ? $portal_block_includes_nom['portal_block_includes_nom'] : '',					
                    'U_ACTION_PERM'      	=> $this->u_action . '&amp;id=' . $portal_block_includes_id,				
					'BLOCK_VIEW' => (isset($portal_block_includes_view['portal_block_includes_view'])) ? $portal_block_includes_view['portal_block_includes_view'] : '')
                ); 

            break;	

            case 'edit':
            case 'add':
			
                $sql = 'SELECT *
                    FROM ' . PORTAL_BLOCK_INCLUDES_ORDER_TABLE . '
                    ORDER BY   portal_block_includes_id ';
                $result = $db->sql_query($sql);

                while ($row = $db->sql_fetchrow($result))
                {
                if ($action == 'edit' && $portal_block_includes_id == $row['portal_block_includes_id'])
                    {
                    $portal_block_includes_nom              = $row;
                    $portal_block_includes_name             = $row;                     
                    $portal_block_includes_position         = $row;                     
                    $portal_block_includes_disable          = $row;
                    $portal_block_includes_order            = $row;
                    $portal_block_includes_view             = $row;                    
                    }
                }
                $db->sql_freeresult($result);
                
                //Select fils block.html
                $dirslist='';
                    $dirs = dir('./../styles/prosilver/template/blocks/');
                        while ($file = $dirs->read()) 
                            {
                            if (eregi("html", $file))
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
                                $template->assign_block_vars('file_name', array('S_BLOCK_HTML' => $dirslist[$i]));
                                }               
                $dirslist='';
				
                $template->assign_vars(array(					
                    'S_EDIT'        => true,
                    'U_BACK'        => $this->u_action,
                    'U_ACTION'      => $this->u_action . '&amp;id=' . $portal_block_includes_id,
                    'BLOCK_NOM'     => (isset($portal_block_includes_nom['portal_block_includes_nom'])) ? $portal_block_includes_nom['portal_block_includes_nom'] : '',             
                    'BLOCK_HTML'    => (isset($portal_block_includes_name['portal_block_includes_name'])) ? $portal_block_includes_name['portal_block_includes_name'] : '',                 
                    'BLOCK_ORDER'   => (isset($portal_block_includes_order['portal_block_includes_order'])) ? $portal_block_includes_order['portal_block_includes_order'] : '',                 
                    'BLOCK_POS'     => (isset($portal_block_includes_position['portal_block_includes_position'])) ? $portal_block_includes_position['portal_block_includes_position'] : '',                 
                    'BLOCK_DISABLE' => (isset($portal_block_includes_disable['portal_block_includes_disable'])) ? $portal_block_includes_disable['portal_block_includes_disable'] : '',                    
					'BLOCK_VIEW' => (isset($portal_block_includes_view['portal_block_includes_view'])) ? $portal_block_includes_view['portal_block_includes_view'] : '')
                ); 
				
                return;
            break;

            // case delete block
            case 'delete':
                if ($portal_block_includes_id)
                {   
                    $sql = 'DELETE FROM ' . PORTAL_BLOCK_INCLUDES_ORDER_TABLE . "
                        WHERE portal_block_includes_id = $portal_block_includes_id";
                    $db->sql_query($sql);

                    $cache->destroy('portal_block_includes');

                    trigger_error($user->lang['BLOCK_REMOVED'] . adm_back_link($this->u_action));
                }
                else
                {
                    trigger_error($user->lang['MUST_SELECT_BLOCK'] . adm_back_link($this->u_action), E_USER_WARNING);
                }
 
            break;
			
			// case move left & move_bottom_direct
            case'move_left':
            case'move_bottom_direct':			 
			 
               $sql = "SELECT MAX(portal_block_includes_order) as total_ord FROM $table WHERE portal_block_includes_position = $colid + 1  " ;
               if( !($result = $db->sql_query($sql)) )
               {
                   message_die(CRITICAL_ERROR, "Could not query structure portal information", "", __LINE__, __FILE__, $sql);
                   }
                   while ( $row = $db->sql_fetchrow($result) )
                   {
                       $max_order = $row['total_ord'] ;
                   }
					$colnew = $colid + 1 ;
					$ordernew = $max_order + 1;
               $sql = "UPDATE $table SET portal_block_includes_position = $colnew , portal_block_includes_order = $ordernew WHERE portal_block_includes_id = $id " ;
              if( !($result = $db->sql_query($sql)) )
					$db->sql_query($sql); 
					$cache->destroy('sql', $table);
            break;
			
			// case move_right  &  move_top_direct 
            case'move_right':
			case'move_top_direct':

               $sql = "SELECT MAX(portal_block_includes_order) as total_ord FROM $table WHERE portal_block_includes_position = $colid - 1  " ;
				if( !($result = $db->sql_query($sql)) )
					{
					message_die(CRITICAL_ERROR, "Could not query structure portal information", "", __LINE__, __FILE__, $sql);
					}
				while ( $row = $db->sql_fetchrow($result) )
					{
                       $max_order = $row['total_ord'] ;
					}
					$colnew = $colid - 1 ;
					$ordernew = $max_order + 1;
               $sql = "UPDATE $table SET portal_block_includes_position = $colnew , portal_block_includes_order = $ordernew WHERE portal_block_includes_id = $id " ;
				if( !($result = $db->sql_query($sql)) )
					$db->sql_query($sql); 
					$cache->destroy('sql', $table);
            break;
			
			// case move_bottom  &  move_left_direct
            case'move_bottom':
            case'move_left_direct':
			
               $sql = "SELECT MAX(portal_block_includes_order) as total_ord FROM $table WHERE portal_block_includes_position = $colid - 2  " ;
               if( !($result = $db->sql_query($sql)) )
					{
					message_die(CRITICAL_ERROR, "Could not query structure portal information", "", __LINE__, __FILE__, $sql);
					}
				while ( $row = $db->sql_fetchrow($result) )
					{
                       $max_order = $row['total_ord'] ;
					}
					$colnew = $colid - 2 ;
					$ordernew = $max_order + 1;
               $sql = "UPDATE $table SET portal_block_includes_position = $colnew , portal_block_includes_order = $ordernew WHERE portal_block_includes_id = $id " ;
				if( !($result = $db->sql_query($sql)) )
					$db->sql_query($sql); 
					$cache->destroy('sql', $table);
            break;
			
			// case move_center_bottom
            case'move_center_bottom':
               $sql = "SELECT MAX(portal_block_includes_order) as total_ord FROM $table WHERE portal_block_includes_position = $colid + 3  " ;
				if( !($result = $db->sql_query($sql)) )
					{
					message_die(CRITICAL_ERROR, "Could not query structure portal information", "", __LINE__, __FILE__, $sql);
					}
              while ( $row = $db->sql_fetchrow($result) )
					{
                       $max_order = $row['total_ord'] ;
					}
					$colnew = $colid + 3 ;
					$ordernew = $max_order + 1;
				$sql = "UPDATE $table SET portal_block_includes_position = $colnew , portal_block_includes_order = $ordernew WHERE portal_block_includes_id = $id " ;
				if( !($result = $db->sql_query($sql)) )
					$db->sql_query($sql); 
					$cache->destroy('sql', $table);
            break;
			
			// case move_center_top  &  move_right_direct
            case'move_center_top':
			case'move_right_direct':
               $sql = "SELECT MAX(portal_block_includes_order) as total_ord FROM $table WHERE portal_block_includes_position = $colid + 2  " ;
               if( !($result = $db->sql_query($sql)) )
					{
					message_die(CRITICAL_ERROR, "Could not query structure portal information", "", __LINE__, __FILE__, $sql);
					}
				while ( $row = $db->sql_fetchrow($result) )
					{
                       $max_order = $row['total_ord'] ;
					}
					$colnew = $colid + 2 ;
					$ordernew = $max_order + 1;
               $sql = "UPDATE $table SET portal_block_includes_position = $colnew , portal_block_includes_order = $ordernew WHERE portal_block_includes_id = $id " ;
				if( !($result = $db->sql_query($sql)) )
					$db->sql_query($sql); 
					$cache->destroy('sql', $table);
            break;
			
			// case mov centre haut
            case'move_bottom_top':
               $sql = "SELECT MAX(portal_block_includes_order) as total_ord FROM $table WHERE portal_block_includes_position = $colid - 3  " ;
				if( !($result = $db->sql_query($sql)) )
					{
					message_die(CRITICAL_ERROR, "Could not query structure portal information", "", __LINE__, __FILE__, $sql);
					}
				while ( $row = $db->sql_fetchrow($result) )
					{
                       $max_order = $row['total_ord'] ;
					}
					$colnew = $colid - 3 ;
					$ordernew = $max_order + 1;
               $sql = "UPDATE $table SET portal_block_includes_position = $colnew , portal_block_includes_order = $ordernew WHERE portal_block_includes_id = $id " ;
				if( !($result = $db->sql_query($sql)) )
					$db->sql_query($sql); 
					$cache->destroy('sql', $table);
            break;			
                       
            //block disable
            case 'disable':
                       $sql = 'SELECT *
                            FROM ' . PORTAL_BLOCK_INCLUDES_ORDER_TABLE . '
                            ORDER BY   portal_block_includes_id ';
                            $result = $db->sql_query($sql);
                            $db->sql_freeresult($result);   
                       $sql = "UPDATE $table
                            SET portal_block_includes_disable = $portal_block_includes_id, portal_block_includes_disable = 0
                            WHERE " . $db->sql_in_set('portal_block_includes_id', $portal_block_includes_id);
                                if( !($result = $db->sql_query($sql)) )             
                                    $db->sql_query($sql);               
                                    $cache->destroy('portal_block_includes');
                                    $cache->destroy('sql', $table);

            break;
            //block enable
            case 'enable':
                       $sql = 'SELECT *
                            FROM ' . PORTAL_BLOCK_INCLUDES_ORDER_TABLE . '
                            ORDER BY   portal_block_includes_id ';
                            $result = $db->sql_query($sql);
                            $db->sql_freeresult($result);   
                       $sql = "UPDATE $table
                            SET portal_block_includes_disable = $portal_block_includes_id, portal_block_includes_disable = 1
                            WHERE " . $db->sql_in_set('portal_block_includes_id', $portal_block_includes_id);
                                if( !($result = $db->sql_query($sql)) )             
                                $db->sql_query($sql);               
                                $cache->destroy('portal_block_includes');
                                $cache->destroy('sql', $table);
            break;

            //case move_down & move_up			
            case 'move_down':
            case 'move_up':

            $sql = "UPDATE $table SET portal_block_includes_order = $ord + $ord2 - portal_block_includes_order WHERE portal_block_includes_id = $id OR portal_block_includes_id = $id2 ";
            if( !($result = $db->sql_query($sql)) )
            $db->sql_query($sql); 
            $cache->destroy('portal_block_includes');
			
			break;
        }
                            
        $template->assign_vars(array(   
            'U_ACTION'      => $this->u_action)
        );

        $sql = 'SELECT *
            FROM ' . PORTAL_BLOCK_INCLUDES_ORDER_TABLE . '
            ORDER BY portal_block_includes_position, portal_block_includes_order ASC';

        $result = $db->sql_query($sql);
        
		// Rajout comptable nombre total de block par position  
        // comptage position gauche
        $portal_block_includes_position = 1;
                       $sql_gauche = "SELECT MAX(portal_block_includes_order) as last_portal_block_includes_order
                            FROM $table WHERE portal_block_includes_position = $portal_block_includes_position";
                                $result_gauche = $db->sql_query($sql_gauche);
                                $last_block_gauche = (int) $db->sql_fetchfield('last_portal_block_includes_order');
                                $db->sql_freeresult($result_gauche);

        // comptage position milieu 
        $portal_block_includes_position = 2;
                       $sql_milieu = "SELECT MAX(portal_block_includes_order) as last_portal_block_includes_order
                            FROM $table WHERE portal_block_includes_position = $portal_block_includes_position";
                                $result_milieu = $db->sql_query($sql_milieu);
                                $last_block_milieu = (int) $db->sql_fetchfield('last_portal_block_includes_order');
                                $db->sql_freeresult($result_milieu);								
	
        // comptage position droite
        $portal_block_includes_position = 3;
                       $sql_droit = "SELECT MAX(portal_block_includes_order) as last_portal_block_includes_order
                            FROM $table WHERE portal_block_includes_position = $portal_block_includes_position";
                                $result_droit = $db->sql_query($sql_droit);
                                $last_block_droit = (int) $db->sql_fetchfield('last_portal_block_includes_order');
                                $db->sql_freeresult($result_droit);
        
        // comptage position haut
        $portal_block_includes_position = 4;
                       $sql_haut = "SELECT MAX(portal_block_includes_order) as last_portal_block_includes_order
                            FROM $table WHERE portal_block_includes_position = $portal_block_includes_position";
                                $result_haut = $db->sql_query($sql_haut);
                                $last_block_haut = (int) $db->sql_fetchfield('last_portal_block_includes_order');
                                $db->sql_freeresult($result_haut);
     
        // comptage position bas
        $portal_block_includes_position = 5;
                       $sql_bas = "SELECT MAX(portal_block_includes_order) as last_portal_block_includes_order
                            FROM $table WHERE portal_block_includes_position = $portal_block_includes_position";
                                $result_bas = $db->sql_query($sql_bas);
                                $last_block_bas = (int) $db->sql_fetchfield('last_portal_block_includes_order');
                                $db->sql_freeresult($result_bas);

		$nb_portal_block = 0 ;								
			while ( $row = $db->sql_fetchrow($result) )
             {  
                $portal_block[$nb_portal_block]['portal_block_includes_id'] =  $row['portal_block_includes_id'] ;
                $portal_block[$nb_portal_block]['portal_block_includes_order'] =  $row['portal_block_includes_order'] ;
                $portal_block[$nb_portal_block]['portal_block_includes_nom'] =  $row['portal_block_includes_nom'] ;
                $portal_block[$nb_portal_block]['portal_block_includes_name'] =  $row['portal_block_includes_name'] ;
                $portal_block[$nb_portal_block]['portal_block_includes_disable'] =  $row['portal_block_includes_disable'] ;
                $portal_block[$nb_portal_block]['portal_block_includes_position'] =  $row['portal_block_includes_position'] ;
                $portal_block[$nb_portal_block]['portal_block_includes_edit'] =  $row['portal_block_includes_edit'] ;
				
				
                $portal_block[$nb_portal_block]['portal_block_includes_view'] =  $row['portal_block_includes_view'] ;				
				
				
                $nb_portal_block ++ ;
             }
			for ( $imod_portal_block = 0 ; $imod_portal_block < $nb_portal_block ; $imod_portal_block ++)

            $template->assign_block_vars('block', array(
                'BLOCK_TOTAL_MILIEU'    =>  $last_block_milieu, 
                'BLOCK_TOTAL_BAS'       =>  $last_block_bas,     
                'BLOCK_TOTAL_HAUT'      =>  $last_block_haut,  
                'BLOCK_TOTAL_GAUCHE'    =>  $last_block_gauche, 
                'BLOCK_TOTAL_DROIT'     =>  $last_block_droit,          
                'BLOCK_ID'              =>  $portal_block[$imod_portal_block]['portal_block_includes_order'],
                'BLOCK_NOM'             =>  $portal_block[$imod_portal_block]['portal_block_includes_nom'],
                'BLOCK_HTML'            =>  $portal_block[$imod_portal_block]['portal_block_includes_name'],
                'BLOCK_DISABLE_IMG'     =>  $portal_block[$imod_portal_block]['portal_block_includes_disable'],
                'BLOCK_POS'             =>  $portal_block[$imod_portal_block]['portal_block_includes_position'],
                'BLOCK_EDIT'            =>  $portal_block[$imod_portal_block]['portal_block_includes_edit'],
                'BLOCK_VIEW'            =>  $portal_block[$imod_portal_block]['portal_block_includes_view'],				
                'U_DELETE'              =>  $this->u_action . '&amp;action=delete&amp;id2=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'],			
                'U_MOVE_UP'             =>  $this->u_action . '&amp;action=move_up&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id2="  . $portal_block[$imod_portal_block - 1]['portal_block_includes_id'] . "&amp;id=" .  $portal_block[$imod_portal_block]['portal_block_includes_id']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'] . "&amp;ord2=" .  $portal_block[$imod_portal_block - 1]['portal_block_includes_order'],		
                'U_MOVE_DOWN'           =>  $this->u_action . '&amp;action=move_down&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id2="  . $portal_block[$imod_portal_block + 1]['portal_block_includes_id']  . "&amp;id=" .  $portal_block[$imod_portal_block]['portal_block_includes_id'] . "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'] . "&amp;ord2=" .  $portal_block[$imod_portal_block + 1]['portal_block_includes_order'],
                'U_MOVE_RIGHT'          =>  $this->u_action . '&amp;action=move_left&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'].'&amp;colid='.$portal_block[$imod_portal_block]['portal_block_includes_position']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'],
                'U_MOVE_LEFT'           =>  $this->u_action . '&amp;action=move_right&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'].'&amp;colid='.$portal_block[$imod_portal_block]['portal_block_includes_position']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'],
                'U_MOVE_BOTTOM'         =>  $this->u_action . '&amp;action=move_bottom&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'].'&amp;colid='.$portal_block[$imod_portal_block]['portal_block_includes_position']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'],
                'U_MOVE_CENTER_BOTON'   =>  $this->u_action . '&amp;action=move_center_bottom&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'].'&amp;colid='.$portal_block[$imod_portal_block]['portal_block_includes_position']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'],
                'U_MOVE_CENTER_TOP'    	=>  $this->u_action . '&amp;action=move_center_top&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'].'&amp;colid='.$portal_block[$imod_portal_block]['portal_block_includes_position']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'],
                'U_MOVE_TOP'    		=>  $this->u_action . '&amp;action=move_bottom_top&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'].'&amp;colid='.$portal_block[$imod_portal_block]['portal_block_includes_position']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'],
                'U_MOVE_TOP'    		=>  $this->u_action . '&amp;action=move_bottom_top&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'].'&amp;colid='.$portal_block[$imod_portal_block]['portal_block_includes_position']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'],	
                'U_MOVE_TOP_DIRECT' 	=>  $this->u_action . '&amp;action=move_top_direct&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'].'&amp;colid='.$portal_block[$imod_portal_block]['portal_block_includes_position']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'],
                'U_MOVE_BOTON_DIRECT' 	=>  $this->u_action . '&amp;action=move_bottom_direct&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'].'&amp;colid='.$portal_block[$imod_portal_block]['portal_block_includes_position']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'],
                'U_MOVE_RIGHT_DIRECT' 	=>  $this->u_action . '&amp;action=move_right_direct&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'].'&amp;colid='.$portal_block[$imod_portal_block]['portal_block_includes_position']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'],	
                'U_MOVE_LEFT_DIRECT' 	=>  $this->u_action . '&amp;action=move_left_direct&amp;idnone=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'].'&amp;colid='.$portal_block[$imod_portal_block]['portal_block_includes_position']. "&amp;ord=" .  $portal_block[$imod_portal_block]['portal_block_includes_order'],					
                'U_DISABLE'             =>  $this->u_action . "&amp;action=disable&amp;idnone=".$portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'],
                'U_ENABLE'              =>  $this->u_action . "&amp;action=enable&amp;idnone=".$portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'],
                'BLOCK_DISABLE'         => ($portal_block[$imod_portal_block]['portal_block_includes_disable']) ? sprintf($user->lang['DISABLE'])  : sprintf($user->lang['ENABLE']) ,
                'U_EDIT'                =>  $this->u_action . '&amp;action=edit&amp;id2=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'],
                'U_EDIT_PERM'           =>  $this->u_action . '&amp;action=editperm&amp;id2=' . $portal_block[$imod_portal_block]['portal_block_includes_id']."&amp;id="  . $portal_block[$imod_portal_block]['portal_block_includes_id'])				
				
            );

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
				'U_EDIT_COLL'	=> 	$this->u_action . '&amp;action=editcoll&amp;id=' . $row['config_coll_id'])
			);
		}			

			$db->sql_freeresult($result);			

    }
}

?>