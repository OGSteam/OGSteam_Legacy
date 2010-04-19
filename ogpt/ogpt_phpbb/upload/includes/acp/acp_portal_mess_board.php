<?php
/*************************************************************************
* @package acp
* @version $Id: acp_mess_board.php
* @copyright (c) sjpphpbb.net 20-01-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_mess_board
	{
    	var $u_action;
    	var $new_config;

	function main($id, $mode)
   	{
        global $db, $user, $auth, $template, $cache;
        global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		$user->add_lang('portal/block_mess_board_lang');
        include($phpbb_root_path . 'includes/message_parser.'.$phpEx);
		$this->tpl_name = 'acp_portal_mess_board';
		$this->page_title = 'ACP_PORTAL_MESS_BOARD';
        		$error = $notify = array();

	switch ($mode)
	{
	case 'main':
	}
	if (isset($_POST['edit']))
	{

	$selected_msg = request_var('message', array('' => 0));
	$sql = 'SELECT *
		FROM ' . MESS_BOARD_TABLE . "
		WHERE id = '" . $db->sql_escape($selected_msg) . "'";
		$results = $db->sql_query($sql);
		$row = $db->sql_fetchrow($results);

		$id         			= $row['id'];
		$message    		= $row['message'];
		$mess_board_titre    	= $row['mess_board_titre'];
		$message_parser 		= new parse_message();

	if (isset($row['message']))
	{
		$message_parser->message = &$row['message'];
		unset($row['message']);
	}
	if ($row['bbcode_uid'])
	{
		$message_parser->bbcode_uid = $row['bbcode_uid'];
	}

		$message_parser->decode_message($row['bbcode_uid']);

		$template->assign_vars(array(
			'S_EDIT_MSG'  		=> true,
			'U_SEL_ACTION'		=> $this->u_action,
			'MSG_ID'       		=> $id,
			'U_BACK'			=> $this->u_action,
			'MESS_BOARD_TITRE'         => $mess_board_titre,
			'MESSAGE'      		=> $message_parser->message,
			));
	}
	else if (isset($_POST['save-edited']))
	{
		$message_parser = new parse_message();
		$id = request_var('msg_id', '');
		$message = utf8_normalize_nfc(request_var('message', '', true));
		$mess_board_titre = utf8_normalize_nfc(request_var('mess_board_titre', '', true));

	$sql = 'SELECT *
		FROM ' . MESS_BOARD_TABLE . "
		WHERE id = '" . $db->sql_escape($id) . "'";
		$results = $db->sql_query($sql);
		$row = $db->sql_fetchrow($results);

		$bbcode_bitfield 			= $row['bbcode_bitfield'];
		$bbcode_uid 			= $row['bbcode_uid'];
		$message_parser->message = request_var('message', '', true);
		$message_parser->parse(true, true, true, true, true, true, true, true);
		$message            			= $message_parser->message;
		$bbcode_uid         			= $message_parser->bbcode_uid;
		$bbcode_bitfield    			= $message_parser->bbcode_bitfield;

	$sql_ary = array(
		'mess_board_titre'	=> $mess_board_titre,
		'message'	=> $message,
		'bbcode_uid'	=> $bbcode_uid,
		'bbcode_bitfield'	=> $bbcode_bitfield
		);

	$sql = 'UPDATE ' . MESS_BOARD_TABLE . ' 
		SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
		WHERE id = $id";
		$db->sql_query($sql);
		unset($id); 
		trigger_error($user->lang['MESS_BOARD_UPDATED'] . adm_back_link($this->u_action));
	}
	else
	{

	$sql = 'SELECT *
		FROM ' . MESS_BOARD_TABLE . "
		WHERE id = '" . $db->sql_escape($id) . "'";
		$results = $db->sql_query($sql);

		$row = $db->sql_fetchrow($results);
		{
		$template->assign_vars(array(
			'S_MESS_BOARD'	=> true,));

                	$id                 		= $row['id'];
                	$message            		= $row['message'];
                	$mess_board_titre            	= $row['mess_board_titre'];
                	$bbcode_uid         		= $row['bbcode_uid'];
                	$bbcode_bitfield    		= $row['bbcode_bitfield'];
                	$flags = (($config['allow_bbcode']) ? 1 : 0) + (($config['allow_smilies']) ? 2 : 0) + ((true) ? 4 : 0);

            $template->assign_vars(array(
            'MSG_ID'                 => $id,
			'U_BACK'				 => $this->u_action,
            'MESS_BOARD_TITRE'       => $mess_board_titre,
            'MESS_BOARD'      		=> generate_text_for_display($message, $row['bbcode_uid'], $row['bbcode_bitfield'], $flags),));
                	}
         }

    }

}
?>