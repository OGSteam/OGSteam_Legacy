<?php
// -------------------------------------------------------------
// FILENAME  : portal.php
// STARTED   : Sun Feb 13, 2005
// COPYRIGHT : © 2007 sjpphpbb
// WWW       : http://sjpphpbb.net/phpbb3
// LICENCE   : GPL vs2.0 [ see /docs/COPYING ]
// -------------------------------------------------------------

/**
* @ignore
*/
define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_display.' . $phpEx);
include_once($phpbb_root_path . 'includes/blocks_includes.'.$phpEx);
//-- mod : AJAX Chat ----------------------------------------------------
include($phpbb_root_path . 'shout.' . $phpEx);
//-- fin mod : AJAX Chat ------------------------------------------------
// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();
// Output page
page_header($user->lang['INDEX']);
$layout = '';
if(isset($HTTP_GET_VARS['page']))
{
    $layout = intval($HTTP_GET_VARS['page']);
}
else
{
    $layout = '';
}
    {
        // Coll blocks
        $sql = "SELECT config_coll_pacing, config_d_w, config_g_w 
        FROM " . PORTAL_CONFIG_COLL_TABLE . "  
        ORDER BY config_coll_id";
        $result = $db->sql_query($sql);
		while( $row = $db->sql_fetchrow($result) )
        {
                $config_coll_pacing = $row['config_coll_pacing'];
                $config_g_w = $row['config_g_w'];
                $config_d_w = $row['config_d_w'];               
        }
            $template->assign_vars(array(
                'PACING'    => $config_coll_pacing,
                'DROITE_W'  => $config_d_w,             
                'GAUCHE_W'  => $config_g_w));

    }   

   $error = $notify = array();

// fonction display block
function portal_block_template($info)
{
    global $template;
    // set template filename
    $template->set_filenames(array('name' => 'blocks/' . $info));
    // Return templated data
    return $template->assign_display('name');
}

$block_ary = array();

			$template->assign_vars(array(
			'U_ACP' => ($auth->acl_get('a_') && $user->data['is_registered']) ? append_sid("{$phpbb_root_path}adm/index.$phpEx", '', true, $user->session_id) : '',			
            'U_CHAT' => append_sid("{$phpbb_root_path}chat.$phpEx"))
    		);

$sql = "SELECT *
        FROM  ".PORTAL_BLOCK_INCLUDES_ORDER_TABLE ." 
		WHERE portal_block_includes_disable = '0'  
		ORDER by portal_block_includes_order ASC";
		
        $result = $db->sql_query($sql);
        $D = $G = $M = $B = $H = 0;

        while ($row = $db->sql_fetchrow($result))
        {
              $portal_block_includes_id = $row['portal_block_includes_id'];
              $portal_block_includes_name = $row['portal_block_includes_name'];
              $block_position = $row['portal_block_includes_position'];
              $portal_block_includes_view = $row['portal_block_includes_view'];
			  
		// view by all, registered, moderator,admin	  			
        if
		(
		$portal_block_includes_view = $row['portal_block_includes_view'] == 1 ||
		$portal_block_includes_view = $row['portal_block_includes_view'] == 2 && $user->data['is_registered'] ||		
		$portal_block_includes_view = $row['portal_block_includes_view'] == 3 && $user->data['user_rank'] == 2 ||
		$portal_block_includes_view = $row['portal_block_includes_view'] == 3 && $user->data['user_type'] == 3 ||		
		$portal_block_includes_view = $row['portal_block_includes_view'] == 4 && $user->data['user_type'] == 3 )			  
        if($portal_block_includes_name != '')
            {
                switch($block_position)
                {
                   case '1':
                      {               
						$left_block_ary_file[$G]    = $portal_block_includes_name;
						$left_block_id[$G]          = $portal_block_includes_id;						
						$G++;
                   break;
                      }
                   case '3':
                      {
						$right_block_ary[$D]    = $portal_block_includes_name;
						$right_block_id[$D]     = $portal_block_includes_id;
						$D++;
                   break;
                      }
                   case '2' :
                      {
						$middle_block_ary[$M] = $portal_block_includes_name;
						$middle_block_id[$M] = $portal_block_includes_id;
						$M++;
                   break;
                      }
                   case '5' :
                      {
						$bas_block_ary[$B] = $portal_block_includes_name;
						$bas_block_id[$B] = $portal_block_includes_id;
						$B++;
                   break;
                       }
                   case '4' :
                       {
						$haut_block_ary[$H] = $portal_block_includes_name;
						$haut_block_id[$H] = $portal_block_includes_id;
						$H++;
                       break;
                       }
                    default:
                 }
			} 					
		}
        $db->sql_freeresult($result);

					if($left_block_ary_file !='') {
						foreach ($left_block_ary_file as $block => $value)
						{
						$template->assign_block_vars('left_block_files', array(
						'LEFT_BLOCKS'       => portal_block_template($value),
						'LEFT_BLOCK_ID'     => $left_block_id[$block],
						));
						} } else {}

					if($right_block_ary !='') {
						foreach ($right_block_ary as $block => $value)
						{
						$template->assign_block_vars('right_block_files', array(
						'RIGHT_BLOCKS'      => portal_block_template($value),
						'RIGHT_BLOCK_ID'    => $right_block_id[$block],
						));
						} } else {}

					if($middle_block_ary !='') {
						foreach ($middle_block_ary as $block => $value)
						{
					    $template->assign_block_vars('middle_block_files', array(
				        'MIDDLE_BLOCKS'      => portal_block_template($value),
						'MIDDLE_BLOCK_ID'    => $middle_block_id[$block],
					    ));
						}} else {}


					if($haut_block_ary !='') {
						foreach ($haut_block_ary as $block => $value)
						{
						$template->assign_block_vars('haut_block_files', array(
						'HAUT_BLOCKS'      => portal_block_template($value),
						'HAUT_BLOCK_ID'    => $haut_block_id[$block],
						));
						} } else {}


					if ($bas_block_ary !='') {
						foreach ($bas_block_ary as $block => $value)
						{
						$template->assign_block_vars('bas_block_files', array(
						'BAS_BLOCKS'      => portal_block_template($value),
						'BAS_BLOCK_ID'    => $bas_block_id[$block],
						));
						}
						} else { }
												

$template->set_filenames(array(
    'body' => 'portal.html')
);

page_footer();
?>