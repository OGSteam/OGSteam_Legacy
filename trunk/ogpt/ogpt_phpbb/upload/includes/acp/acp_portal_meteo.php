<?php
/*************************************************************************
* @package acp
* @version $Id: acp_meteo.php
* @copyright (c) sjpphpbb.net 20-02-2007
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*************************************************************************/

class acp_portal_meteo
	{
    	var $u_action;
    	var $new_config;

	function main($id, $mode)
   	{
        		global $db, $user, $auth, $template, $cache;
        		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
				$user->add_lang('portal/block_meteo_lang');
				$this->tpl_name = 'acp_portal_meteo';
				$this->page_title = 'ACP_PORTAL_METEO';
        		$error = $notify = array();

	switch ($mode)
	{
	case 'main':
	}
	if (isset($_POST['edit']))
	{

	$selected_msg = request_var('meteo_titre', array('' => 0));
	$sql = 'SELECT *
		FROM ' . METEO_TABLE . "
		WHERE id = '" . $db->sql_escape($selected_msg) . "'";
		$results = $db->sql_query($sql);
		$row = $db->sql_fetchrow($results);

		$id         			= $row['id'];
		$meteo_titre    		= utf8_normalize_nfc($row['meteo_titre']);
		$meteo_fond    			= $row['meteo_fond'];
		$meteo_texte    		= $row['meteo_texte'];

	if (isset($row['meteo_titre']))
	{
		unset($row['meteo_titre']);
	}

		$template->assign_vars(array(
			'U_SEL_ACTION'		=> $this->u_action,
			'MSG_ID'       		=> $id,
			'U_BACK'			=> $this->u_action,
			'METEO_TITRE'       => $meteo_titre,
			'METEO_FOND'		=> $meteo_fond,
			'METEO_TEXTE'      	=> $meteo_texte,
			));
									
	}
	else if (isset($_POST['save-edited']))
	{
		$id = request_var('msg_id', '');
		$meteo_titre = utf8_normalize_nfc(request_var('meteo_titre', '', true));
		$meteo_fond = request_var('meteo_fond', '');
		$meteo_texte = request_var('meteo_texte', '');

	$sql = 'SELECT *
		FROM ' . METEO_TABLE . "
		WHERE id = '" . $db->sql_escape($id) . "'";
		$results = $db->sql_query($sql);
		$row = $db->sql_fetchrow($results);

	$sql_ary = array(
		'meteo_titre'	=> $meteo_titre,
		'meteo_fond '	=> $meteo_fond ,
		'meteo_texte'	=> $meteo_texte
		);

	$sql = 'UPDATE ' . METEO_TABLE . ' 
		SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
		WHERE id = $id";
		$db->sql_query($sql);
		unset($id); 
		trigger_error($user->lang['METEO_UPDATED'] . adm_back_link($this->u_action));
	}
	else
	{

	$sql = 'SELECT *
		FROM ' . METEO_TABLE . "
		WHERE id = '" . $db->sql_escape($id) . "'";
		$results = $db->sql_query($sql);

		$row = $db->sql_fetchrow($results);
		{
                	$id           = $row['id'];
                	$meteo_titre  = utf8_normalize_nfc($row['meteo_titre']);
					$meteo_fond   = $row['meteo_fond'];
                	$meteo_texte  = $row['meteo_texte'];

                	$template->assign_vars(array(
                   		'MSG_ID'                => $id,
						'U_BACK'				=> $this->u_action,
                   		'METEO_TITRE'           => $meteo_titre,
						'METEO_FOND' 			=> $meteo_fond ,
                    	'METEO_TEXTE'      		=> $meteo_texte,));
                	}
         }

    }

}
?>