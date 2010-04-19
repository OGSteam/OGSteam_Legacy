<?php
/*************************************************************************
* @package acp
* @version $Id: acp_sow_images.php
* @copyright (c) sjpphpbb 15-12-2006
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_sow_images
{
    var $u_action;

    function main($id, $mode)
    {
        global $db, $user, $auth, $template, $cache;
        global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

        $user->add_lang('portal/block_sow_images_lang');

        // Set up general vars
        $action = request_var('action', '');
        $action = (isset($_POST['edit'])) ? 'edit' : $action;
        $action = (isset($_POST['add'])) ? 'add' : $action;
        $action = (isset($_POST['save'])) ? 'save' : $action;
        $sow_id = request_var('id', 0);	
        $ord = request_var('ord',0);
        $ord2 = request_var('ord2',0);
        $id = request_var('id',0);
        $id2 = request_var('id2',0);        
        $sow_titre_id = request_var('id', 0);
        $table = SOW_TABLE;

        $this->tpl_name = 'acp_portal_sow_images';
        $this->page_title = 'ACP_SOW_IMAGES';

        switch ($action)
        {

        case 'save':

                $sow_id = request_var('id', '', true);
                $no = request_var('no', '', true);
                $titre = request_var('titre', '', true);
                $image = request_var('image', '', true);
                $info = request_var('info', '', true);
                $width = request_var('width', '', true);
                $height = request_var('height', '', true);
                $info3 = request_var('info3', '', true);

        $sqlnews = "SELECT MAX(no) as total_no
               FROM $table
                  WHERE sow_id ";
                    $resultnews = $db->sql_query($sqlnews);
                    $total_no = (int) $db->sql_fetchfield('total_no');
                    $db->sql_freeresult($resultnews);
                    if($no) { $fin = $no; } 
					else 
					{
                    $fin = $total_no + 1; // nombre total de block dans la catégorie             
                    } // nombre total de block dans la catégorie             

                $sql_ary = array(
                    'sow_id'        => $sow_id,
                    'no'            => $fin,
                    'titre'         => $titre,
                    'image'         => $image,
                    'info'          => $info,
                    'width'         => $width,
                    'height'        => $height,
                    'info3'         => $info3
                );

                if ($sow_id)
                {
                    $sql = 'UPDATE ' . SOW_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE sow_id = $id";
                    $message = $user->lang['SOW_UPDATED'];
                }
                else
                {
                    $sql = 'INSERT INTO ' . SOW_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
                    $message = $user->lang['SOW_ADDED'];
                }
                $db->sql_query($sql);

                $cache->destroy('sow');

                trigger_error($message . adm_back_link($this->u_action));

            break;

            case 'save2':

                $sow_titre_id = request_var('id', '', true);
                $sow_titre = request_var('sow_titre', '', true);

                $sql_ary = array(

                    'sow_titre_id'      => $sow_titre_id,
                    'sow_titre'         => $sow_titre
                );

                if ($sow_titre_id)
                {
                    $sql = 'UPDATE ' . SOW_TITRE_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE sow_titre_id = $sow_titre_id";
                    $message = $user->lang['SOW_TITRE_BLOC_UPDATED'];
                }
                else
                {
                    $sql = 'INSERT INTO ' . SOW_TITRE_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
                    $message = $user->lang['SOW_TITRE_BLOC_ADDED'];
                }
                $db->sql_query($sql);

                $cache->destroy('sow_titre');

                trigger_error($message . adm_back_link($this->u_action));

            break;

            case 'delete':

                // Ok, they want to delete their sow imges
                if ($sow_id)
                {
                    $sql = 'DELETE FROM ' . SOW_TABLE . "
                        WHERE sow_id = $sow_id";
                    $db->sql_query($sql);

                    $cache->destroy('sow');

                    trigger_error($user->lang['SOW_REMOVED'] . adm_back_link($this->u_action));
                }
                else
                {
                    trigger_error($user->lang['MUST_SELECT_SOW'] . adm_back_link($this->u_action), E_USER_WARNING);
                }
                

            break;

            case 'edit2':

                $sql = 'SELECT *
                    FROM ' . SOW_TITRE_TABLE . '
                    ORDER BY  sow_titre ASC ';
                $result = $db->sql_query($sql);

                while ($row = $db->sql_fetchrow($result))

                    if ($action == 'edit2' && $sow_titre_id == $row['sow_titre_id'])
                    {
                        $sow_titre = $row;
                    }

                $db->sql_freeresult($result);

                $template->assign_vars(array(

                    'S_EDIT_TITRE'      => true,
                    'U_BACK'            => $this->u_action,
                    'U_ACTION_2'        => $this->u_action . '&amp;id=' .$sow_titre_id,
                    'SOW_TITRE'     => (isset($sow_titre['sow_titre'])) ? $sow_titre['sow_titre'] : '')
                );

            break;

            case 'edit':
            case 'add':
            
                $sql = 'SELECT *
                    FROM ' . SOW_TABLE . '
                    ORDER BY  sow_id ';
                $result = $db->sql_query($sql);

                while ($row = $db->sql_fetchrow($result))
                {

                    if ($action == 'edit' && $sow_id == $row['sow_id'])
                    {
                        $no = $row;
                        $titre = $row;
                        $image = $row;
                        $info = $row;
                        $width = $row;
                        $height = $row;
                        $info3 = $row;
                    }
                }
                $db->sql_freeresult($result);

                $template->assign_vars(array(

                    'S_EDIT'        => true,
                    'U_BACK'        => $this->u_action,
                    'U_ACTION'      => $this->u_action . '&amp;id=' .$sow_id,
                    'NO'            => (isset($no['no'])) ? $no['no'] : '',                 
                    'TITRE'         => (isset($titre['titre'])) ? $titre['titre'] : '',
                    'IMAGE'         => (isset($image['image'])) ? $image['image'] : '',
                    'INFO'          => (isset($info['info'])) ? $info['info'] : '',
                    'HEIGHT'        => (isset($height['height'])) ? $height['height'] : '',
                    'WIDTH'         => (isset($width['width'])) ? $width['width'] : '',
                    'INFO3'         => (isset($info3['info3'])) ? $info3['info3'] : '')
                );
                return;
            break;
    
            case 'move_down':
            case 'move_up':

            $sql = "UPDATE $table SET no = $ord + $ord2 - no WHERE sow_id = $id OR sow_id = $id2 ";
            if( !($result = $db->sql_query($sql)) )
            $db->sql_query($sql); 
            $cache->destroy('no');  
            break;      
        }

        $template->assign_vars(array(
            'U_ACTION'      => $this->u_action)
        );
        
        $sql = 'SELECT *
            FROM ' . SOW_TABLE . '
            ORDER BY no  ASC ';
        $result = $db->sql_query($sql);
        {
            $nb_sow_block = 0 ;     
            while ( $row = $db->sql_fetchrow($result) )     
             {
                $sow_block[$nb_sow_block]['sow_id']         =  $row['sow_id'] ;
                $sow_block[$nb_sow_block]['no']             =  $row['no'] ;
                $sow_block[$nb_sow_block]['titre']          =  $row['titre'] ;
                $sow_block[$nb_sow_block]['image']          =  $row['image'] ;
                $sow_block[$nb_sow_block]['info']           =  $row['info'] ;
                $sow_block[$nb_sow_block]['width']          =  $row['width'] ;
                $sow_block[$nb_sow_block]['height']             =  $row['height'] ;
                $sow_block[$nb_sow_block]['info3']          =  $row['info3'] ;                  
                $nb_sow_block ++ ;
             }
            for ( $imod_sow_block = 0 ; $imod_sow_block < $nb_sow_block ; $imod_sow_block ++)       
        
            $template->assign_block_vars('sow', array(
                'NO'            =>  $sow_block[$imod_sow_block]['no'],
                'TITRE'         =>  $sow_block[$imod_sow_block]['titre'],
                'IMAGE'         =>  $sow_block[$imod_sow_block]['image'],               
                'INFO'          =>  $sow_block[$imod_sow_block]['info'],
                'WIDTH'         =>  $sow_block[$imod_sow_block]['width'],
                'HEIGHT'        =>  $sow_block[$imod_sow_block]['height'],              
                'INFO3'         =>  $sow_block[$imod_sow_block]['info3'],
                'U_MOVE_UP'     =>  $this->u_action . '&amp;action=move_up&amp;idnone=' . $sow_block[$imod_sow_block]['sow_id']."&amp;id2="  . $sow_block[$imod_sow_block - 1]['sow_id'] . "&amp;id=" .  $sow_block[$imod_sow_block]['sow_id']. "&amp;ord=" .  $sow_block[$imod_sow_block]['no'] . "&amp;ord2=" .  $sow_block[$imod_sow_block - 1]['no'],
                'U_MOVE_DOWN'   =>  $this->u_action . '&amp;action=move_down&amp;idnone=' . $sow_block[$imod_sow_block]['sow_id']."&amp;id2="  . $sow_block[$imod_sow_block + 1]['sow_id']  . "&amp;id=" .  $sow_block[$imod_sow_block]['sow_id'] . "&amp;ord=" .  $sow_block[$imod_sow_block]['no'] . "&amp;ord2=" .  $sow_block[$imod_sow_block + 1]['no'],
                'U_DELETE'      =>  $this->u_action . '&amp;action=delete&amp;id2=' . $sow_block[$imod_sow_block]['sow_id']."&amp;id="  . $sow_block[$imod_sow_block]['sow_id'],
                'U_EDIT'        =>  $this->u_action . '&amp;action=edit&amp;id2=' . $sow_block[$imod_sow_block]['sow_id']."&amp;id="  . $sow_block[$imod_sow_block]['sow_id'])                  
            );                  

        }
        $db->sql_freeresult($result);

            $sql = 'SELECT *
            FROM ' . SOW_TITRE_TABLE . '
            ORDER BY   sow_titre_id ASC ';
        $result = $db->sql_query($sql);

        while ($row = $db->sql_fetchrow($result))
        {
            $template->assign_block_vars('sow_titre', array(

                'SOW_TITRE'     => $row['sow_titre'],
                'U_EDIT_TITRE'      => $this->u_action . '&amp;action=edit2&amp;id=' . $row['sow_titre_id'])
            );
        }
        $db->sql_freeresult($result);

    }
}

?>