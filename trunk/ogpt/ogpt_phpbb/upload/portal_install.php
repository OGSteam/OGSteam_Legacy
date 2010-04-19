<?php
/*-----------------------------------------------------------------------------
    Modification Installer for phpBB 3
  ----------------------------------------------------------------------------
    install.php
       SQL Installer Script
    Generation Date: June 16, 2007  
  ----------------------------------------------------------------------------
    This file is released under the GNU General Public License Version 2.
-----------------------------------------------------------------------------*/

define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include_once($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/acp/acp_modules.' . $phpEx);
// Session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('acp/common');
$user->add_lang('acp/modules');
if ($user->data['user_id'] == ANONYMOUS)
{
    login_box("portal_install.$phpEx", $user->lang['LOGIN_ADMIN'], $user->lang['LOGIN_ADMIN_SUCCESS']);
}

if (!$auth->acl_get('a_'))
{
    trigger_error($user->lang['NO_ADMIN']);
}


function user_add_acp_module(&$module_data)
{
   global $cache;
   

   $acp_modules = new acp_modules();
   $acp_modules->module_class = $module_data['module_class'];

   $mod_id = module_exists($module_data['module_langname'], $module_data['parent_id']);
   
   if ( !empty($mod_id) )
   {
      $module_data['module_id'] = $mod_id;
   }
   
   // Adjust auth row if not category
   if ($module_data['module_basename'] && $module_data['module_mode'])
   {
      $fileinfo = $acp_modules->get_module_infos($module_data['module_basename']);
      $module_data['module_auth'] = $fileinfo[$module_data['module_basename']]['modes'][$module_data['module_mode']]['auth'];
   } 

   $errors = $acp_modules->update_module_data($module_data, TRUE);
   if (!sizeof($errors))
   {
      $acp_modules->remove_cache_file();
   } 
   else
   {
      echo 'Could not add item!<br />' . implode('<br />', $errors);
   }
   
   $cache->destroy('_modules_');
   $cache->destroy('_sql_', MODULES_TABLE);
   
   return $module_data['module_id'];
}

function module_exists($modName, $parent = 0)
{
   global $db;
   $sql = "SELECT module_id FROM " . MODULES_TABLE . "
            WHERE parent_id = $parent
            AND module_langname = '$modName'";
   if (!$result = $db->sql_query($sql))
   {
      trigger_error('Could not access modules table');
   }
   //there could be a duplicate module, but screw it 
   if ( $row = $db->sql_fetchrow($result) )
   {
      if ( !empty($row['module_id']) ) 
      {
         return $row['module_id'];
      }
   }
   return false;
}

// Our tab info
$modData = array(
   'module_basename'   => '', // must be blank for category/tab
   'module_mode'      => '', // must be blank for category/tab
   'module_auth'      => '', // must be blank for category/tab
   'module_enabled'   => 1,
   'module_display'   => 1, // must be 1 for tab
   'parent_id'         => 0, // a tab is just a category with no parent
   'module_langname'   => 'Sjpphpbb Portal', //llanguage key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the tab, and grab the ID
$tabId = user_add_acp_module($modData);


// Our subcategory info
$modData = array(
   'module_basename'   => 'Portal config', // must be blank for category
   'module_mode'      => '', // must be blank for category/tab
   'module_auth'      => '', // must be blank for category/tab
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $tabId, // If you wanted to add this to an existing tab, you could have obtained the parent_id here using module_exists('TAB_NAME', 0);
   'module_langname'   => 'ACP_PORTAL_CONFIG', //llanguage key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the subcategory, and grab the ID
$catId = user_add_acp_module($modData);

// And finally... our module information
$modData = array(
   'module_basename'   => 'portal_header', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_PAGE_HEADER', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_include_block', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_PORTAL_INCLUDE_BLOCK', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_include_block_index', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_PORTAL_INCLUDE_BLOCK_INDEX', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_config', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_DONNES_BLOCK_PORTAL', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_menu', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_PORTAL_MENU', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_announcments', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_PORTAL_ANNONCES', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_news', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_CONFIG_NEWS', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_attachments', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_CONFIG_ATT', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_mess_board', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_CONFIGURATION_MESS_BOARD', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_meteo', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_CONFIGURATION_METEO', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_partenaires', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_CONFIGURATION_BLOCK_PARTENAIRES', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_quote', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_CONFIGURATION_DES_CITATIONS', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_sow_images', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_CONFIGURATION_DU_SOW', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);
$modData = array(
   'module_basename'   => 'portal_link', // set in includes/acp/info file
   'module_mode'      => 'select', // set in includes/acp/info file
   'module_auth'      => 'acl_a_board', // use the same as set in your includes/acp/info file
   'module_enabled'   => 1,
   'module_display'   => 1, 
   'parent_id'         => $catId,
   'module_langname'   => 'ACP_CONFIG_BLOCK_LINK', //language key or just a string for the name -- must include
   'module_class'      =>'acp',
);
// create the module
$moduleId = user_add_acp_module($modData);

$mod = array(
    'name'          =>  '',
    'version'       =>  '',
    'copy_year'     =>  '2007',
    'author'        =>  '',
    'website'       =>  '',
    'sitename'      =>  '',
    'prev_version'  =>  '',
);

$install = $uninstall = $upgrade = FALSE;
$sql = $module_data = array();
switch( $dbms )
{
    case 'postgres':
        $sql["install"] = array(
				
    "ALTER TABLE " . $table_prefix . "styles_theme ADD COLUMN theme_status SMALLINT",
    "UPDATE TABLE " . $table_prefix . "styles_theme SET theme_status = 0 WHERE theme_status IS NULL",
    "ALTER TABLE " . $table_prefix . "styles_theme ALTER COLUMN theme_status SET NOT NULL",
    "ALTER TABLE " . $table_prefix . "users ALTER COLUMN meteo_name SET DEFAULT ''",
    "UPDATE TABLE " . $table_prefix . "users SET meteo_name = '' WHERE meteo_name IS NULL",
    "ALTER TABLE " . $table_prefix . "users ALTER COLUMN meteo_name SET NOT NULL");

    break;
    case 'mysql':
    case 'mysql4':
    default:
        $sql["install"] = array(

    "ALTER TABLE " . $table_prefix . "styles_theme ADD theme_status SMALLINT(3) NOT NULL DEFAULT '1'",
    "INSERT INTO " . $table_prefix . "config (config_name, config_value, is_dynamic) VALUES ('visit_counter', '1', '1')",
    "ALTER TABLE " . $table_prefix . "forums  ADD forum_last_poster_flags varchar(40)  NOT NULL DEFAULT '0'",
    "ALTER TABLE " . $table_prefix . "topics  ADD topic_first_poster_flags varchar(40)  NOT NULL DEFAULT '0'",
    "ALTER TABLE " . $table_prefix . "topics  ADD topic_last_poster_flags varchar(40)  NOT NULL DEFAULT '0'",
    
//table chat 
   // "DROP TABLE IF EXISTS " . $table_prefix . "chat",  
    "CREATE TABLE " . $table_prefix . "chat (
          message_id int(11) unsigned NOT NULL auto_increment,
          chat_id int(11) unsigned NOT NULL default '0',
          user_id int(11) unsigned NOT NULL default '0',
          username varchar(255) NOT NULL default '',
          user_colour varchar(6) NOT NULL default '',
          message text NOT NULL,
          bbcode_bitfield varchar(255) NOT NULL default '',
          bbcode_uid varchar(5) NOT NULL default '',
          bbcode_options tinyint(1) unsigned NOT NULL default '7',
          time int(11) unsigned NOT NULL default '0',
          PRIMARY KEY (message_id)
        )",
		
    //"DROP TABLE IF EXISTS " . $table_prefix . "chat_sessions",		
    "CREATE TABLE " . $table_prefix . "chat_sessions (
          user_id mediumint(8) unsigned NOT NULL default '0',
          username varchar(255) NOT NULL default '',
          user_colour varchar(6) NOT NULL default '',
          user_login int(11) unsigned NOT NULL default '0',
          user_firstpost int(11) unsigned NOT NULL default '0',
          user_lastpost int(11) unsigned NOT NULL default '0',
          user_lastupdate int(11) unsigned NOT NULL default '0',
          PRIMARY KEY (user_id)
        )",
		
    "ALTER TABLE `" . $table_prefix . "chat` ADD `user_country_flag` varchar(250) NULL AFTER `user_colour`",
    "ALTER TABLE `" . $table_prefix . "chat_sessions` ADD `user_country_flag` varchar(250) NULL AFTER `user_colour`",			

//table portal attach  
    //"DROP TABLE IF EXISTS " . $table_prefix . "portal_attach", 
    "CREATE TABLE `" . $table_prefix . "portal_attach` ( 
  `attachments_id` mediumint(8) unsigned NOT NULL auto_increment,
  `attachments_number` varchar(50) default NULL,
  `attachments_title_block` varchar(255) default NULL,  
  PRIMARY KEY  (`attachments_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_attach` VALUES (1, '5', 'titre du block')",
    
//table portal_block_includes 
    //"DROP TABLE IF EXISTS " . $table_prefix . "portal_block_includes",    
    "CREATE TABLE `" . $table_prefix . "portal_block_includes` (
  `id` smallint(5) unsigned NOT NULL default '0',
  `block_whos_on_line_stat_disable` smallint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_block_includes` VALUES (0, 1)",  
	
//table block include order	
    "DROP TABLE IF EXISTS " . $table_prefix . "portal_block_includes_order",         
    "CREATE TABLE `" . $table_prefix . "portal_block_includes_order` (
  `portal_block_includes_id` mediumint(8) unsigned NOT NULL auto_increment,
  `portal_block_includes_edit` mediumint(8) unsigned NOT NULL default '0',  
  `portal_block_includes_name` varchar(255) NOT NULL default '',
  `portal_block_includes_nom` varchar(255) NOT NULL default '',  
  `portal_block_includes_disable` mediumint(8) unsigned NOT NULL default '0',
  `portal_block_includes_order` tinyint(8) unsigned default NULL,
  `portal_block_includes_position` char(2) NOT NULL default '',
  `portal_block_includes_last_position` char(2) NOT NULL default '',
  `portal_block_includes_view` char(2) NOT NULL default '',   
  PRIMARY KEY  (`portal_block_includes_id`),
  KEY `config_value` (`portal_block_includes_order`)
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",

"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (1, '1', 'block_log_in_out.html','Login', 0, 1, '4','4', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (2, '1', 'block_team.html', 'Team', 0, 2, '4','4', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (3, '1', 'block_quote.html', 'Citation', 0, 3, '4','4', '1' )",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (44,'1', 'block_sow_images.html', 'Sow images', 0, 1, '5','5', '1')",


"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (4, '1', 'block_mess_board.html', 'Mess board', 0, 1, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (5, '1', 'block_fill_infos.html', 'File infos', 0, 2, '2', '2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (6, '1', 'block_chat_body.html', 'Chat', 0, 3, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (7, '1', 'block_announcments.html', 'Annonces', 0, 4, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (8, '1', 'block_news.html', 'News', 0, 5, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (9, '1', 'block_recent_topics.html', 'Recent topics', 0, 6, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (10, '1', 'block_attachments.html', 'Attachements', 0, 7, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (11, '1', 'block_sp.html', 'Sujet populaire', 0, 8, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (12, '1', 'block_whos_on_line.html', 'Statistiques', 0, 9, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (13, '1', 'block_viewonline.html', 'Viewonline', 0, 10, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (14, '1', 'block_ip_host_portal.html', 'Ip host', 0, 11, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (15, '1', 'block_birthday.html', 'Birthday', 0, 12, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (16, '1', 'block_jump_to.html', 'Jump to', 0, 13, '2','2', '1')",

"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (17, '1', 'block_menu.html', 'Menu', 0, 1, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (18, '1', 'block_forum_categories.html', 'Categories', 0, 2, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (19, '1', 'block_geoloc.html', 'Geoloc', 0, 3, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (20, '1', 'block_neo_counter.html', 'Neo counter', 0, 4, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (21, '1', 'block_clock.html', 'Horloge', 0, 5, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (22, '1', 'block_calendrier.html', 'Calendrier', 0, 6, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (23, '1', 'block_allo_cine.html', 'Allo cine ', 0, 7, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (24, '1', 'block_search.html', 'Recherche', 0, 8, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (25, '1', 'block_meteo.html', 'Meteo', 0, 9, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (26, '1', 'block_horoscope.html', 'Horoscope', 0, 10, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (45, '1', 'block_radio.html', 'Radio', 0, 11, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (27, '1', 'block_random_member.html', 'Membres aleatoires', 0, 12, '1','1', '1')",

"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (28, '1', 'block_user_information.html', 'User infos', 0, 1, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (29, '1', 'block_style_select.html', 'Style', 0, 2, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (30, '1', 'block_the_team.html', 'La team', 0, 3, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (31, '1', 'block_top_posters.html', 'Top poster', 0, 4, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (32, '1', 'block_latest_members.html', 'Last members', 0, 5, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (33, '1', 'block_bots_recent.html', 'Recent Bot', 0, 6, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (34, '1', 'block_links.html', 'Links', 0, 7, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (35, '1', 'block_partenaires.html', 'Partenaires', 0, 8, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (36, '1', 'block_last_visite.html', 'Last visites', 0, 9, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (37, '1', 'block_tele.html', 'Tele', 0, 10, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (38, '1', 'block_jukebox.html', 'Jukebox', 0, 11, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (39, '1', 'block_php_infos.html', 'Php infos', 0, 12, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (40, '1', 'block_compteur.html', 'Compteur', 0, 13, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (41, '1', 'block_holydays.html', 'Fete du jour', 0, 14, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (42, '1', 'block_online_friends.html', 'Amis', 0, 15, '3','3', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order` VALUES (43, '1', 'block_vendredi13.html', 'Vendredi 13', 0, 16, '3','3', '1')",

//table block include order_index
    //"DROP TABLE IF EXISTS " . $table_prefix . "portal_block_includes_order_index",   	         
    "CREATE TABLE `" . $table_prefix . "portal_block_includes_order_index` (
  `portal_block_includes_id` mediumint(8) unsigned NOT NULL auto_increment,
  `portal_block_includes_edit` mediumint(8) unsigned NOT NULL default '0',  
  `portal_block_includes_name` varchar(255) NOT NULL default '',
  `portal_block_includes_nom` varchar(255) NOT NULL default '',  
  `portal_block_includes_disable` mediumint(8) unsigned NOT NULL default '0',
  `portal_block_includes_order` tinyint(8) unsigned default NULL,
  `portal_block_includes_position` char(2) NOT NULL default '',
  `portal_block_includes_last_position` char(2) NOT NULL default '',
  `portal_block_includes_view` char(2) NOT NULL default '',   
  PRIMARY KEY  (`portal_block_includes_id`),
  KEY `config_value` (`portal_block_includes_order`)
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",

"INSERT INTO `" . $table_prefix . "portal_block_includes_order_index` VALUES (1, '1', 'block_team.html', 'Team', 0, 1, '4','4', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order_index` VALUES (2, '1', 'block_forumlist_body.html', 'Block Forum', 0, 1, '2','2', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order_index` VALUES (3, '1', 'block_menu.html', 'Menu', 0, 1, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order_index` VALUES (4, '1', 'block_style_select.html', 'Style', 0, 2, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order_index` VALUES (5, '1', 'block_partenaires.html', 'Partenaires', 0, 3, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order_index` VALUES (6, '1', 'block_compteur.html', 'Compteur', 0, 4, '1','1', '1')",
"INSERT INTO `" . $table_prefix . "portal_block_includes_order_index` VALUES (7, '1', 'block_compteur.html', 'Compteur', 0, 5, '1','1', '1')",

//table config block 
    //"DROP TABLE IF EXISTS " . $table_prefix . "portal_config_block",        
    "CREATE TABLE `" . $table_prefix . "portal_config_block` (
  `config_bloc_id` mediumint(8) unsigned NOT NULL auto_increment,
  `config_bloc_name` varchar(255) NOT NULL,
  `config_name` varchar(255) NOT NULL,
  `config_scroll` tinyint(20) unsigned default NULL,
  `config_value` varchar(255) NOT NULL,
  `config_forum` varchar(255) default NULL,  
  PRIMARY KEY   (`config_bloc_id`),
  KEY `config_value` (`config_value`)
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_config_block` VALUES (1, 'bot', 'Top bot', 2, '5', '')",
    "INSERT INTO `" . $table_prefix . "portal_config_block` VALUES (2, 'recent_topic', '15 derniers sujets', 0, '15', '50,51')",
    "INSERT INTO `" . $table_prefix . "portal_config_block` VALUES (3, 'recent_reg', '5 dernier Membres', 2, '5', '')",
    "INSERT INTO `" . $table_prefix . "portal_config_block` VALUES (4, 'recent_poster', 'Top posteurs', 2, '10', '')",
    "INSERT INTO `" . $table_prefix . "portal_config_block` VALUES (5, 'friends_online', 'Liste d\'amis', 2, '6', '')", 
    
//table link
    //"DROP TABLE IF EXISTS " . $table_prefix . "portal_link",      
    "CREATE TABLE `" . $table_prefix . "portal_link` (
  `id` smallint(5) unsigned NOT NULL default '0',
  `portal_logo` text NOT NULL,
  `portal_link` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_link` VALUES (0, 'http://sjpphpbb.net/phpbb3/images/logo_sites/sjpphpbb_logo.gif', 'http://sjpphpbb.net/phpbb3/')",

//table portal news 
    //"DROP TABLE IF EXISTS " . $table_prefix . "portal_news",
    "CREATE TABLE `" . $table_prefix . "portal_news` (
  `news_id` mediumint(8) unsigned NOT NULL auto_increment,
  `news_number` varchar(50) default NULL,
  `news_day` varchar(50) default NULL,
  `news_length` varchar(50) default NULL,
  `news_forum` varchar(255) default NULL,
  `news_title_block` varchar(255) default NULL,  
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_news` VALUES (1, '1', '300', '400', '1', 'titre du block')",
    
//table portal config coll 
	"DROP TABLE IF EXISTS " . $table_prefix . "portal_config_coll", 
    "CREATE TABLE `" . $table_prefix . "portal_config_coll` (
  `config_coll_id` mediumint(8) unsigned NOT NULL auto_increment,
  `config_coll_pacing` varchar(255) default NULL,
  `config_coll_padding` varchar(255) default NULL,
  `config_g_w` varchar(255) default NULL,
  `config_d_w` varchar(255) default NULL,
  `config_version` varchar(255) default NULL,  
  PRIMARY KEY  (`config_coll_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_config_coll` VALUES (1, '4', '50', '200', '200','1.0.5 RC4')",
	
//table portal config coll _index
	"DROP TABLE IF EXISTS " . $table_prefix . "portal_config_coll_index", 
    "CREATE TABLE `" . $table_prefix . "portal_config_coll_index` (
  `config_coll_id` mediumint(8) unsigned NOT NULL auto_increment,
  `config_coll_pacing` varchar(255) default NULL,
  `config_coll_padding` varchar(255) default NULL,
  `config_g_w` varchar(255) default NULL,
  `config_d_w` varchar(255) default NULL,  
  PRIMARY KEY  (`config_coll_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_config_coll_index` VALUES (1, '4', '50', '200', '0')",	
    
//table portal annonces 
    //"DROP TABLE IF EXISTS " . $table_prefix . "portal_announcments",
    "CREATE TABLE `" . $table_prefix . "portal_announcments` (
  `announcments_id` mediumint(8) unsigned NOT NULL auto_increment,
  `announcments_number` varchar(50) default NULL,
  `announcments_day` varchar(50) default NULL,
  `announcments_length` varchar(50) default NULL,
  `announcments_forum` varchar(255) default NULL,
  PRIMARY KEY  (`announcments_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_announcments` VALUES (1, '2', '100', '400', '2')",
    


//table portal menu
    "DROP TABLE IF EXISTS " . $table_prefix . "portal_menu", 
    "CREATE TABLE `" . $table_prefix . "portal_menu` (
  `menu_id` mediumint(8) unsigned NOT NULL auto_increment,
  `menu_img` varchar(150) NOT NULL default '',
  `menu_name` varchar(150) NOT NULL default '',
  `menu_url` varchar(150) NOT NULL default '',
  `menu_view` varchar(20) NOT NULL default '',
  `menu_order` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`menu_id`),
  KEY `menu_order` (`menu_order`)
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_menu` VALUES (1, 'menu_portal.gif', 'Portal', 'portal.php', '1', 1)",
    "INSERT INTO `" . $table_prefix . "portal_menu` VALUES (2, 'menu_portal_index.gif', 'Portal Index', 'portal_index.php', '1', 2)",	
    "INSERT INTO `" . $table_prefix . "portal_menu` VALUES (3, 'menu_forum.gif', 'Forum', 'index.php', '1', 3)",
    "INSERT INTO `" . $table_prefix . "portal_menu` VALUES (4, 'menu_members_list.gif', 'Liste des membres', 'memberlist.php', '2', 4)",
    "INSERT INTO `" . $table_prefix . "portal_menu` VALUES (5, 'menu_membership_manager.gif', 'Le Staff', 'memberlist.php?mode=leaders', '2', 5)",
    "INSERT INTO `" . $table_prefix . "portal_menu` VALUES (6, 'menu_surveiller.gif', 'Sujets surveiller', 'ucp.php?i=main&mode=bookmarks', '2', 6)",
    "INSERT INTO `" . $table_prefix . "portal_menu` VALUES (7, 'menu_profile.gif', 'Profil', 'ucp.php', '2', 7)",
    
//table portal meteo   
    //"DROP TABLE IF EXISTS " . $table_prefix . "portal_meteo",
    "CREATE TABLE " . $table_prefix . "portal_meteo (
  id int(11) NOT NULL default '0',
  meteo_fond varchar(6) default NULL,
  meteo_texte varchar(6) default NULL,
  meteo_titre varchar(25) default NULL,
  PRIMARY KEY  (meteo_fond)
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO " . $table_prefix . "portal_meteo VALUES ('0','E6E6E6', '00639D', 'Météo')",
    
//table portal mess board
    "DROP TABLE IF EXISTS " . $table_prefix . "portal_mess_board",   
    "CREATE TABLE `" . $table_prefix . "portal_mess_board` (
  `id` smallint(5) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `mess_board_titre` text NOT NULL,
  `mess_board_disable` smallint(4) unsigned NOT NULL default '0',
  `bbcode_bitfield` varchar(255) NOT NULL default '',
  `bbcode_uid` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_mess_board` VALUES (0, 'Votre message', 'Titre du bloc', 0, '', '')",
	
//table portal header  
    "DROP TABLE IF EXISTS " . $table_prefix . "portal_header",
    "CREATE TABLE `" . $table_prefix . "portal_header` (
  `header_id` int(3) NOT NULL auto_increment,
  `header_no` varchar(10) default NULL,
  `header_titre` varchar(60) default NULL,
  `header_image` varchar(100) default NULL,
  `header_ulr_img` varchar(100) default NULL,
  `header_portal_disable` int(3) default NULL,
  PRIMARY KEY   (`header_id`)
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",

    "INSERT INTO `" . $table_prefix . "portal_header` (`header_id`, `header_no`, `header_titre`, `header_image`, `header_ulr_img`,  `header_portal_disable`) VALUES (1, '1', 'Portal', 'header_portal.gif', 'portal.php', '1')",
    "INSERT INTO `" . $table_prefix . "portal_header` (`header_id`, `header_no`, `header_titre`, `header_image`, `header_ulr_img`,  `header_portal_disable`) VALUES (2, '2', 'Portal Index', 'header_portal_index.gif', 'portal_index.php', '1')",	
    "INSERT INTO `" . $table_prefix . "portal_header` (`header_id`, `header_no`, `header_titre`, `header_image`, `header_ulr_img`,  `header_portal_disable`) VALUES (3, '3', 'Forum', 'header_backhome_icon.gif', 'index.php', '1')",
    "INSERT INTO `" . $table_prefix . "portal_header` (`header_id`, `header_no`, `header_titre`, `header_image`, `header_ulr_img`,  `header_portal_disable`) VALUES (4, '4', 'Members list', 'header_members_list.gif', 'memberlist.php', '1')",	
    "INSERT INTO `" . $table_prefix . "portal_header` (`header_id`, `header_no`, `header_titre`, `header_image`, `header_ulr_img`,  `header_portal_disable`) VALUES (5, '5', 'Msg', 'header_read_private_message_icon.gif', 'ucp.php?i=pm&folder=inbox', '1')",
    "INSERT INTO `" . $table_prefix . "portal_header` (`header_id`, `header_no`, `header_titre`, `header_image`, `header_ulr_img`,  `header_portal_disable`) VALUES (6, '6', 'Faq', 'header_fak.gif', 'faq.php', '1')",
    "INSERT INTO `" . $table_prefix . "portal_header` (`header_id`, `header_no`, `header_titre`, `header_image`, `header_ulr_img`,  `header_portal_disable`) VALUES (7, '7', 'Recherche', 'header_search.gif', 'search.php', '1')",
    "INSERT INTO `" . $table_prefix . "portal_header` (`header_id`, `header_no`, `header_titre`, `header_image`, `header_ulr_img`,  `header_portal_disable`) VALUES (8, '8', 'Profil', 'header_edit_profile.gif', 'ucp.php', '1')",

//portal header logo
   "DROP TABLE IF EXISTS " . $table_prefix . "portal_header_config",
   "CREATE TABLE `" . $table_prefix . "portal_header_config` (
  `header_logo_id` int(3) NOT NULL default '1',
  `header_logo_image` varchar(250) default NULL,
  `header_logo_name` varchar(250) default NULL,
  `header_logo_desc` varchar(250) default NULL,   
  `header_portal_disable` smallint(4) unsigned NOT NULL default '0'  
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_header_config` VALUES (1, 'site_logo.gif','Le nom du site','La description du site','1')",	
    
//table portal sow 
    //"DROP TABLE IF EXISTS " . $table_prefix . "portal_sow",
    "CREATE TABLE `" . $table_prefix . "portal_sow` (
  `sow_id` int(3) NOT NULL auto_increment,
  `no` varchar(10) default NULL,
  `titre` varchar(60) default NULL,
  `image` varchar(100) default NULL,
  `info` varchar(100) default NULL,
  `width` varchar(60) default NULL,
  `height` varchar(60) default NULL,
  `info3` varchar(250) default NULL,
  PRIMARY KEY  (`sow_id`)
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_sow` (`sow_id`, `no`, `titre`, `image`, `info`, `width`, `height`, `info3`) VALUES (1, '1', 'brasov.ro', 'http://sjpphpbb.net/phpbb3/images/sow_images/brasov1.gif', 'http://www.brasov.ro/nou/index.php', '120', '100', 'In ultimii ani in Brasov s-au deschis extrem de multe locuri unde puteti dormi in conditii bune. Ramane doar sa alegeti locul care va place, in functie de conditii si de preturi. Noi suntem in masura sa va recomandam locul potrivit gustului si buzuna')",
    "INSERT INTO `" . $table_prefix . "portal_sow` (`sow_id`, `no`, `titre`, `image`, `info`, `width`, `height`, `info3`) VALUES (2, '2', 'rolrena.club.fr', 'http://sjpphpbb.net/phpbb3/images/sow_images/brasovprefecture.jpg', 'http://rolrena.club.fr/Brasov_image.php', '120', '100', 'La citÃ© de Brasov, (1395), entourÃ©e de remparts (XIVe -XVIIe) conserve encore le rempart nord et deux murailles d''enceinte, Bastion des Forgerons et des OrfÃ¨vres (actuellement les Archives de la municipalitÃ©, rue GH. Baritiu) ; la Porte Ecaterin')",
    "INSERT INTO `" . $table_prefix . "portal_sow` (`sow_id`, `no`, `titre`, `image`, `info`, `width`, `height`, `info3`) VALUES (3, '3', 'wikipedia.org/', 'http://sjpphpbb.net/phpbb3/images/sow_images/brasov3.gif', 'http://fr.wikipedia.org/wiki/Brasov', '120', '100', 'Brasov (en latin Corona, en allemand Kronstadt, en hongrois BrassÃ³) est une ville de Roumanie et un des plus importants centres touristiques avec la plus grande station de ski de l''Europe de l''Est. En 2005, sa population Ã©tait de 328 702 habitan')",
    "INSERT INTO `" . $table_prefix . "portal_sow` (`sow_id`, `no`, `titre`, `image`, `info`, `width`, `height`, `info3`) VALUES (4, '4', 'maisons-laffitte', 'http://sjpphpbb.net/phpbb3/images/sow_images/m_l1.gif', 'http://www.maisons-laffitte.fr/', '120', '100', 'Dans un monde mÃ©diatique en perpÃ©tuelle Ã©volution, Maisons-Laffitte se devait d''amÃ©liorer le site internet de la Ville. C''est chose faite, le site nouveau est en ligne !')",
    "INSERT INTO `" . $table_prefix . "portal_sow` (`sow_id`, `no`, `titre`, `image`, `info`, `width`, `height`, `info3`) VALUES (5, '5', 'maisonslaffitte.net', 'http://sjpphpbb.net/phpbb3/images/sow_images/m-l2.jpg', 'http://www.maisonslaffitte.net/', '120', '100', 'De la construction du chÃ¢teau par RenÃ© de Longueil au XVII Ã¨me siÃ¨cle jusqu''Ã  son rachat  par l''Etat en 1905, prenez connaissance d''un rÃ©sumÃ© de l''histoire du chÃ¢teau de Maisons Ã  travers ses diffÃ©rents propriÃ©taires.')",
    
//table portal sow titre 
    "DROP TABLE IF EXISTS " . $table_prefix . "portal_sow_titre",
    "CREATE TABLE `" . $table_prefix . "portal_sow_titre` (
  `sow_titre_id` int(3) NOT NULL default '1',
  `sow_titre` varchar(150) default NULL
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_sow_titre` VALUES (1, 'Titre du bloc')",
    
//table portal quote  
    //"DROP TABLE IF EXISTS " . $table_prefix . "portal_quote",  
    "CREATE TABLE `" . $table_prefix . "portal_quote` (
  `quote_id` smallint(5) unsigned NOT NULL auto_increment,
  `quote` varchar(250) default NULL,
  `author` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`quote_id`)
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_quote` VALUES (1, 'L''asile le plus sur est le sein d''une mÃ¨re.', 'Florian')",
    "INSERT INTO `" . $table_prefix . "portal_quote` VALUES (2, 'Nous sommes ce que nous faisons rÃ©guliÃ¨rement. Donc, l''excellence n''est pas un acte, mais une habitude', 'Aristote')",
	
//table portal quote titre  
    "DROP TABLE IF EXISTS " . $table_prefix . "portal_quote_titre",
    "CREATE TABLE `" . $table_prefix . "portal_quote_titre` (
  `quote_titre_id` int(3) NOT NULL default '0',
  `quote_titre` varchar(150) default NULL
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_quote_titre` VALUES (1, 'Citation du moment')",
    
//table portal partenaires
    //"DROP TABLE IF EXISTS " . $table_prefix . "portal_partenaires", 
    "CREATE TABLE `" . $table_prefix . "portal_partenaires` (
  `partenaires_id` smallint(5) unsigned NOT NULL auto_increment,
  `partenaires_url` varchar(150) NOT NULL default '',
  `partenaires_img` varchar(150) NOT NULL default '',
  `partenaires_flag` varchar(255) default NULL,
  PRIMARY KEY  (`partenaires_id`)
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "portal_partenaires` VALUES (1, 'http://sjpphpbb.net', 'images/logo_sites/sjpphpbb_logo.gif', 'images/logo_sites/france.gif')",
    
//table geoloc  
    //"DROP TABLE IF EXISTS " . $table . "geo",
    "CREATE TABLE `" . $table_prefix . "geo` (
  `pays` varchar(4) NOT NULL default '',
  `abs` int(4) default '0',
  `ord` int(4) default '0',
  `name` varchar(25) default '0',
  `nom` varchar(25) NOT NULL default '',
  `visit` int(4),
  `time` int(4),
  KEY `time` (`time`)
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",

//table geoloc2
    //"DROP TABLE IF EXISTS " . $table . "geo2",
    "CREATE TABLE `" . $table_prefix . "geo2` (
  `time` int(4) ,
  `ip` bigint(4) default '0',
  PRIMARY KEY  (`time`)
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",

//table horoscope titre
    //"DROP TABLE IF EXISTS " . $table_prefix . "horoscope_titre", 
    "CREATE TABLE `" . $table_prefix . "horoscope_titre` (
  `horoscope_id` smallint(3) unsigned NOT NULL default '1',
  `horoscope_titre` varchar(150) default NULL
) TYPE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",
    "INSERT INTO `" . $table_prefix . "horoscope_titre` VALUES (1, 'Horoscope du jour')",

//table portal_block_includes  
    //"DROP TABLE IF EXISTS " . $table_prefix . "holydays",   
    "CREATE TABLE `" . $table_prefix . "holydays` (
  `lejour` int(2) NOT NULL default '0',
  `lemois` int(2) NOT NULL default '0',
  `fetedujour` varchar(70) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",

    "INSERT INTO `phpbb_holydays` VALUES (1, 1, 'Fête du jour de l''An')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 1, 'Saint Basile le Grand')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 1, 'Sainte Geneviève')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 1, 'Saint Odilon')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 1, 'St Edouard le Confesseur')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 1, 'St André Corsini')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 1, 'St Raymond de Penyafort')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 1, 'Saint Lucien')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 1, 'Sainte Alix de Ch.')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 1, 'St Guillaume de Bourges')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 1, 'St Paulin d''Aquilée')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 1, 'Sainte Tatiana')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 1, 'Sainte Yvette')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 1, 'Sainte Nina')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 1, 'Saint Rémi')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 1, 'Saint Marcel')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 1, 'Sainte Roseline')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 1, 'Sainte Prisca')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 1, 'Saint Marius')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 1, 'Saint Sébastien')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 1, 'Sainte Agnès')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 1, 'Saint Vincent')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 1, 'Saint Barnard')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 1, 'St François de Sales')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 1, 'la Conversion de St Paul')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 1, 'Sainte Paule')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 1, 'Sainte Angèle Mérici')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 1, 'St Thomas d''Aquin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 1, 'Saint Gildas le Sage')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (30, 1, 'Sainte Martine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (31, 1, 'Sainte Marcelle')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (1, 2, 'Sainte Ella')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 2, 'Saint Théophane V.')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 2, 'Saint Blaise')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 2, 'Sainte Véronique')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 2, 'Sainte Agathe')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 2, 'Saint Gaston')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 2, 'Sainte Eugénie Smet')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 2, 'Sainte Jacqueline')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 2, 'Sainte Apolline')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 2, 'Saint Arnaud')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 2, 'Saint Séverin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 2, 'Saint Félix d''Abilène')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 2, 'Ste Béatrice')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 2, 'Saint Valentin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 2, 'St Claude de la Colombière')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 2, 'Sainte Julienne')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 2, 'St Alexis Falconieri')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 2, 'Sainte Bernadette')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 2, 'Saint Gabin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 2, 'Sainte Aimée')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 2, 'Saint Damien')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 2, 'Sainte Isabelle')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 2, 'Saint Lazare')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 2, 'Saint Modeste')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 2, 'Saint Roméo')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 2, 'Saint Nestor')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 2, 'Sainte Honorine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 2, 'Saint Romain')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 2, 'St Auguste Chapdelaine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (1, 3, 'Saint Aubin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 3, 'Saint Charles le Bon')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 3, 'Saint Gwenolé')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 3, 'Saint Casimir')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 3, 'Saint Olive')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 3, 'Sainte Colette')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 3, 'Ste Félicité')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 3, 'Saint Jean de Dieu')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 3, 'Ste Françoise Romaine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 3, 'Saint Vivien')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 3, 'Sainte Rosine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 3, 'Sainte Justine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 3, 'Saint Rodrigue')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 3, 'Sainte Mathilde')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 3, 'Ste Louise de Marillac')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 3, 'Sainte Bénédicte')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 3, 'Saint Patrick')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 3, 'St Cyrille de Jérusalem')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 3, 'Saint Joseph')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 3, 'Saint Herbert')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 3, 'Sainte Clémence')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 3, 'Sainte Léa')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 3, 'Saint Victorien')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 3, 'Ste Catherine de Suède')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 3, 'Saint Humbert')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 3, 'Sainte Larissa')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 3, 'Saint Habib')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 3, 'Saint Gontran')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 3, 'Sainte Gwladys')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (30, 3, 'St Amédée de Savoie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (31, 3, 'St Benjamin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (1, 4, 'St Hugues de Grenoble')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 4, 'Sainte Sandrine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 4, 'Saint Richard')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 4, 'St Isidore de Séville')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 4, 'Sainte Irène')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 4, 'Saint Marcellin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 4, 'St Jean-Baptiste de la Salle')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 4, 'Ste Julie Billard')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 4, 'Saint Gautier')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 4, 'Saint Fulbert')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 4, 'Saint Stanislas')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 4, 'Saint Jules 1er')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 4, 'Sainte Ida')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 4, 'Saint Maxime')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 4, 'St Paterne de Vannes')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 4, 'Saint Benoît Labre')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 4, 'Saint Etienne Harding')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 4, 'Saint Parfait')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 4, 'Sainte Emma')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 4, 'Sainte Odette')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 4, 'Saint Anselme')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 4, 'Saint Alexandre')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 4, 'Saint Georges')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 4, 'St Fidèle de Sigmaringen')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 4, 'Saint Marc')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 4, 'Sainte Alida')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 4, 'Sainte Zita')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 4, 'Sainte Valérie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 4, 'Ste Catherine de Sienne')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (30, 4, 'Saint Robert')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (1, 5, 'Saint Joseph Artisan')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 5, 'Saint Boris')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 5, 'Fête des Sts Philippe et Jacques le Mineur')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 5, 'Saint Sylvain de Gaza')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 5, 'Sainte Judith')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 5, 'Sainte Prudence')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 5, 'Sainte Gisèle')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 5, 'Saint Désiré')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 5, 'Ste Pacôme')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 5, 'Sainte Solange')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 5, 'Sainte Estelle')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 5, 'Fête des Saints Achille et Nérée')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 5, 'Sainte Rolande')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 5, 'Saint Matthias')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 5, 'Sainte Denise')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 5, 'Saint Honoré')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 5, 'Saint Pascal Baylon')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 5, 'Saint Eric')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 5, 'St Yves Hélory')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 5, 'Saint Bernardin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 5, 'Saint Constantin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 5, 'Saint Emile')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 5, 'Saint Didier de Vienne')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 5, 'Saint Donatien')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 5, 'Sainte Sophie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 5, 'Saint Bérenger')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 5, 'St Augustin de Canterbury')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 5, 'Saint Germain de Paris')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 5, 'Saint Aymard')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (30, 5, 'Saint Ferdinand')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (31, 5, 'Sainte Perrine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (1, 6, 'Saint Justin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 6, 'Sainte Blandine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 6, 'St Charles Lwanga')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 6, 'Sainte Clotilde')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 6, 'Saint Igor')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 6, 'Saint Norbert')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 6, 'St Gilbert de Neuffontaines')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 6, 'Saint Médard')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 6, 'Sainte Diane')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 6, 'Saint Landry')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 6, 'Saint Barnabé')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 6, 'Saint Guy')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 6, 'St Antoine de Padoue')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 6, 'Saint Elisée')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 6, 'Ste Germaine cousin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 6, 'St Jean-François Régis')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 6, 'Saint Hervé')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 6, 'Saint Léonce')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 6, 'Saint Romuald')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 6, 'Saint Silvère')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 6, 'Saint Rodolphe')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 6, 'Saint Alban')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 6, 'Sainte Audrey')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 6, 'Saint Jean-Baptiste')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 6, 'Saint Prosper')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 6, 'Saint Anthelme')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 6, 'Saint Fernand')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 6, 'Saint Irénée')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 6, 'Fête des Saints Pierre et Paul')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (30, 6, 'Saint Martial')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (1, 7, 'Saint Thierry')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 7, 'Saint Martinien')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 7, 'Saint Thomas')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 7, 'Saint Florent')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 7, 'St Antoine-Marie Zaccharia')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 7, 'Sainte Marietta Goretti')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 7, 'Saint Raoul Milner')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 7, 'Saint Thibaud')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 7, 'Sainte Amandine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 7, 'Saint Ulric de Zell')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 7, 'Saint Benoît')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 7, 'Saint Olivier')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 7, 'Saint Henri et de Joël')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 7, 'Saint Camille de Lellis')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 7, 'Saint Donald')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 7, 'Sainte Elvire')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 7, 'Sainte Charlotte')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 7, 'Saint Frédéric')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 7, 'Saint Arsène')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 7, 'Sainte Marina')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 7, 'Saint Victor')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 7, 'Sainte Marie-Madeleine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 7, 'Sainte Brigitte de Suède')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 7, 'Sainte Christine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 7, 'Saint Jacques le Majeur')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 7, 'Sainte Anne')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 7, 'Fête des Sts Aurèle et Nathalie de Cordoue')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 7, 'Saint Samson')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 7, 'Sainte Marthe')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (30, 7, 'Sainte Juliette')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (31, 7, 'Saint Ignace de Loyola')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (1, 8, 'St Alphonse-Marie de Liguori')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 8, 'St Pierre-Julien Eymard')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 8, 'Sainte Lydie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 8, 'Saint Jean-Marie Vianney')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 8, 'Saint Abel')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 8, 'Saint Octavien')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 8, 'Saint Gaétan')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 8, 'Saint Dominique')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 8, 'Saint Amour')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 8, 'Saint Laurent')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 8, 'Sainte Claire d''Assise')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 8, 'Sainte Clarisse')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 8, 'Saint Hippolyte')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 8, 'Saint Evrard')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 8, 'Sainte Marie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 8, 'Saint Armel')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 8, 'St Hyacinthe de Cracovie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 8, 'Sainte Hélène')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 8, 'Saint Jean-Eudes')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 8, 'Saint Bernard')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 8, 'Saint Christophe')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 8, 'Saint Fabrice')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 8, 'Sainte Rose de Lima')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 8, 'Saint Barthélémy')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 8, 'St Louis (IX) Roi de France')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 8, 'Sainte Natacha')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 8, 'Sainte Monique')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 8, 'Saint Augustin d''Hippone')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 8, 'Sainte Sabine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (30, 8, 'Saint Fiacre')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (31, 8, 'Saint Aristide')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (1, 9, 'Saint Gilles')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 9, 'Sainte Ingrid')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 9, 'Saint Grégoire le Grand')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 9, 'Sainte Rosalie de Palerme')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 9, 'Sainte Raïssa')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 9, 'Saint Bertrand')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 9, 'Sainte Reine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 9, 'Saint Adrien')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 9, 'Saint Alain de la Roche')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 9, 'Sainte Inès Takeya')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 9, 'Saint Adelphe')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 9, 'Saint Apollinaire')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 9, 'Saint Aimé')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 9, 'la Croix Glorieuse')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 9, 'Saint Roland')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 9, 'Sainte Edith')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 9, 'Saint Renaud')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 9, 'Sainte Nadège')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 9, 'Ste Emilie de Rodat')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 9, 'Saint Davy')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 9, 'Saint Matthieu')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 9, 'Saint Maurice d''Agaune')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 9, 'Saint Constant')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 9, 'Sainte Thècle')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 9, 'Saint Hermann')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 9, 'Saints Côme et Damien')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 9, 'Saint Vincent de Paul')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 9, 'Saint Venceslas')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 9, 'Saint Michel')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (30, 9, 'Saint Jérôme')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (1, 10, 'Sainte Thérèse de lisieux')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 10, 'Saint Léger')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 10, 'Saint Gérard Majella')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 10, 'Saint François d''Assise')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 10, 'Sainte Fleur')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 10, 'Saint Bruno')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 10, 'Saint Serge')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 10, 'Sainte Pélagie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 10, 'Saint Denis')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 10, 'Saint Ghislain')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 10, 'Saint Firmin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 10, 'Saint Wilfrid')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 10, 'Saint Géraud d''Aurillac')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 10, 'Saint Juste')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 10, 'Sainte Thérèse d''Avila')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 10, 'Sainte Edwige')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 10, 'Saint Baudouin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 10, 'Saint Luc')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 10, 'Saint René Goupil')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 10, 'Fête des Saints Vital et Adeline')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 10, 'Sainte Céline')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 10, 'Sainte Elodie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 10, 'Saint Jean de Capistran')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 10, 'Saint Florentin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 10, 'Fête des Saints Crépin et Doria')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 10, 'Saint Dimitri')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 10, 'Sainte Emeline')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 10, 'Fête des Saints Simon et Jude')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 10, 'Saint Narcisse')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (30, 10, 'Sainte Bienvenue')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (31, 10, 'Saint Quentin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (1, 11, 'Tous les Saints')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 11, 'Fête des Défunts')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 11, 'Saint Hubert')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 11, 'Saint Charles Borromée')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 11, 'Sainte Sylvie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 11, 'Ste Bertille de Chelles')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 11, 'Sainte Carine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 11, 'Saint Geoffroy')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 11, 'Saint Théodore')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 11, 'Saint Léon le Grand')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 11, 'Saint Martin')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 11, 'Saint Christian')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 11, 'Saint Brice')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 11, 'Saint Sidoine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 11, 'Saint Albert le Grand')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 11, 'Ste Marguerite d''Ecosse')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 11, 'Ste Elisabeth de Hongrie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 11, 'Sainte Aude')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 11, 'St Tanguy de Bretagne')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 11, 'St Edmond d''Angleterre')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 11, 'Saint Albert')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 11, 'Sainte Cécile')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 11, 'Saint Clément')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 11, 'Ste Flora')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 11, 'Ste Catherine d''Alexandrie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 11, 'Sainte Delphine')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 11, 'Saint Séverin de Paris')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 11, 'St Jacques de la Marche')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 11, 'Saint Saturnin de Toulouse')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (30, 11, 'Saint André')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (1, 12, 'Ste Florence')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (2, 12, 'Sainte Viviane')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (3, 12, 'Saint François-Xavier')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (4, 12, 'Sainte Barbara')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (5, 12, 'Saint Gérald de Braga')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (6, 12, 'Saint Nicolas de Myre')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (7, 12, 'Saint Ambroise de Milan')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (8, 12, 'Sainte Elfie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (9, 12, 'St Pierre Fourier')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (10, 12, 'Saint Romaric')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (11, 12, 'Saint Daniel')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (12, 12, 'Ste Jeanne-Françoise de Chantal')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (13, 12, 'Sainte Lucie')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (14, 12, 'Sainte Odile')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (15, 12, 'Sainte Ninon')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (16, 12, 'Sainte Alice')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (17, 12, 'Saint Gaël')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (18, 12, 'Saint Gatien')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (19, 12, 'Saint Urbain')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (20, 12, 'Saint Théophile')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (21, 12, 'Saint Pierre Canisius')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (22, 12, 'Ste Françoise-Xavière Cabrini')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (23, 12, 'Saint Armand')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (24, 12, 'Sainte Adèle')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (25, 12, 'Noël')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (26, 12, 'Saint Etienne')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (27, 12, 'St Jean l''évangéliste')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (28, 12, 'Fête des Saints Innocents')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (29, 12, 'Saint David')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (30, 12, 'Saint Roger')",
    "INSERT INTO `" . $table_prefix . "holydays` VALUES (31, 12, 'Saint Sylvestre')");

    
    break;
}



if( !empty($sql['install']) || !empty($module_data['install']) )
{
    $install = TRUE;
}

if( !empty($sql['uninstall']) || !empty($module_data['uninstall']) )
{
    $uninstall = TRUE;
}

if( !empty($sql['upgrade']) || !empty($module_data['upgrade']) )
{
    $upgrade = TRUE;
}

require_once($phpbb_root_path . 'includes/acp/acp_modules.' . $phpEx);
$acp_modules    = new acp_modules();

$page_title = $mod['name'] . ' SjpPortal-phpBB3 Sql Install';
$action = request_var('action', '');

$version_string = $of_name = $for_name = '';
if( !empty($mod['name']) )
{
    $of_name  = ' of ' . $mod['name'];
    $for_name = ' for ' . $mod['name'];
}

if( !empty($mod['prev_version']) && !empty($mod['version']) )
{
    $version_string = " from {$mod['name']} {$mod['prev_version']} to {$mod['name']} {$mod['version']}";
}

$page_head = <<<EOH
<html>
<head>
<title>$page_title</title>
<style type="text/css">
<!--
body
{
    color: black;
    background-color: blanchedalmond;
    margin: 0;
    padding: 0;
    font-size: 15px;
    font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif;
}

a
{
    background-color: inherit;
    text-decoration: none;
    font-size: 1.0em;
}

a:hover
{
    color: green;
    background-color: inherit;
    text-decoration: underline;
}

div#header
{
    width: 100%;
    color: saddlebrown;
    background-position: right bottom;
    border: none;
    margin-top: 0.4em;
    margin-bottom: 0.5em;
}

#logo
{
    font-size: 1.8em;
    font-weight: bold;
    padding-left: 0.5em;
}

#logo a, #logo a:hover
{
    color: saddlebrown;
    font-size: 1em;
}

#footer
{
    clear: both;
    border: none;
    border-top: 1px solid saddlebrown;
    margin: 0;
    padding: 0.3em;
    font-size: 0.7em;
    text-align: right;
}

#content
{
    background: ivory;
    border-top: 1px solid saddlebrown;
    margin-top: 0;
    padding: 0.5em 1em 0.1em;
    text-align: justify;
}

p, ul
{
    font-size: 0.8em;
}

.error
{
    font-weight: bold;
    color: #005EBB;
}

.success
{
    font-weight: bold;
    color: green;
}
-->
</style>
</head>
<body>
<div id="header">
    <div id="logo">$page_title</div>
</div>
<div id="content">
<p>
    <center>Bienvenue sur {$page_title}.<br> Ce script va vous permettre d'installer les tables nécessaires pour le fonctionnement
du portal.<br>Il est recommander de faire une sauvegarde de vos tables avant d'éxécuter ce script.
</p>
EOH;

$page_tail = <<<EOH
    </div>
    <div id="footer">
        {$mod['name']} Copyright &copy; by <a href="http://sjpphpbb.net/phpbb3/portal.php" title="Site support">SjpPortal-phpBB3</a>
    </div>
</body>
</html>
EOH;

$url_append = $phpEx . '?sid=' . $user->data['session_id'];
$page_postaction = <<<EOH
    </p>

    <p>Vous devez supprimer maintenant le fichier Portal_install.php de votre Ftp</p>
    
    <p class="alert"><a href="./OGSpy/install/">Installer OGSpy.</a></p>
EOH;

$results = array();
$db_errors = FALSE;
$db->sql_return_on_error(true);
$page_text = '';
if( empty($action) || !in_array($action, array('install', 'upgrade', 'uninstall')) )
{
    $page_text = <<<EOH
    <p class="alert"></p>
    <p>
EOH;
    if( $install )
    {
        $page_text .= <<<EOH
    <ul>
        <li><a href="portal_install.$url_append&amp;action=install">Install</a></li>
EOH;
    }
    if( $uninstall )
    {
        $page_text .= <<<EOH
        <li><a href="portal_install.$url_append&amp;action=uninstall">Uninstall</a></li>
EOH;
    }
    if( $upgrade )
    {
        $page_text .= <<<EOH
        <li><a href="portal_install.$url_append&amp;action=upgrade">Upgrade $version_string</a></li>
EOH;
    }
    $page_text .= <<<EOH
    </ul>
    </p>
EOH;
}
else
{
    run_installer();
}

function run_installer()
{
    global $action, $page_text, $for_name, $results, $install, $uninstall, $upgrade;

    if( !$$action )
    {
        $page_text .= '<p>';
        switch( $action )
        {
            case 'install':
                $page_text .= 'Installation';
            break;
            case 'uninstall':
                $page_text .= 'Uninstallation';
            break;
            case 'upgrade':
                $page_text .= 'Upgrading';
            break;
        }
        $page_text .= ' is not supported for ' . $for_name . '.</p>';
    }
    else
    {
        $page_text = "
            <p>This installer will now attempt to make the database changes{$for_name}.</p>";
        process_sql();
        process_modules();

        if( empty($results) )
        {
            $results[] = '<li>No changes were attempted! You may have already run the installer successfully.</li>';
        }
        $page_text .= '<ul>' . implode("\n", $results) . '</ul>
        <p>
            The installer process is now complete.';
    }
}

function process_modules()
{
    global $action, $module_data;
    if( empty($module_data[$action]) )
    {
        return;
    }
    switch( $action )
    {
        case 'install':
            add_modules($module_data['install']);
        break;
        case 'upgrade':
            remove_modules($module_data['upgrade']['remove']);
            add_modules($module_data['upgrade']['add']);
        break;
        case 'uninstall':
            remove_modules($module_data['uninstall']);
        break;
    }
}

function get_cat_ids($details, $module_class)
{
    global $db;

    $parents = array();
    if( !isset($details['cat']) )
    {
        return array(0);
    }
    $cats = $details['cat'];
    $sql = 'SELECT module_id FROM ' . MODULES_TABLE . '
            WHERE ' . $db->sql_in_set('module_langname', $cats) . "
                AND module_class = '" . $db->sql_escape($module_class) . "'";
    $result = $db->sql_query($sql);
    while( $row = $db->sql_fetchrow($result) )
    {
        $parents[] = $row['module_id'];
    }
    $db->sql_freeresult($result);

    if( empty($parents) )
    {
        $parents = array(0);
    }

    return $parents;
}

function remove_modules($modules)
{
    global $db, $phpbb_root_path, $phpEx, $acp_modules;

    if( empty($modules) )
    {
        return;
    }
    foreach($modules as $k=>$v)
    {
        // Check if module name and mode exist...
        $module_basename    = $v['basename'];
        $module_class       = $v['class'];
        if( !check_for_info($module_class, $module_basename) )
        {
            continue;
        }
        $fileinfo = $acp_modules->get_module_infos($module_basename, $module_class);
        $fileinfo = $fileinfo[$module_basename];

        if( !empty($fileinfo['modes']) )
        {
            uninstall_modules($fileinfo['modes'], $module_class, $module_basename);
        }

        if( isset($fileinfo['new_parents']) )
        {
            uninstall_modules($fileinfo['new_parents'], $module_class, '', true);
        }
    }
}

function uninstall_modules($modules, $module_class, $module_basename, $cats_only = FALSE)
{
    global $acp_modules, $db, $user;
    $modules = array_reverse($modules);
    foreach($modules as $module_mode => $mode_details)
    {
        // We need to get the module_id for each mode.
        $sql = 'SELECT module_id FROM ' . MODULES_TABLE . "
                WHERE module_langname = '" . $db->sql_escape($mode_details['title']) . "'
                    AND module_class = '" . $db->sql_escape($module_class) . "'";
        $result = $db->sql_query($sql);
        $rows = $db->sql_fetchrowset($result);
        $db->sql_freeresult($result);
        $acp_modules->module_class = $module_class;

        $msg = "Removal of module $module_basename, mode $module_mode";
        if( $cats_only )
        {
            $cat_name = ( isset($user->lang[$mode_details['title']]) ) ? $user->lang[$mode_details['title']] : $mode_details['title'];
            $msg = "Removal of menu category $cat_name";
        }

        if( empty($rows) )
        {
            add_result($msg, "This could not be removed because it was not already installed.");
            continue;
        }
        foreach($rows as $v)
        {
            $result = $acp_modules->delete_module($v['module_id']);
            if( !empty($result) )
            {
                add_result($msg, $result[0]);
            }
            else
            {
                add_result($msg);
            }
        }
    }
}

function check_for_info($module_class, $module_basename)
{
    global $phpbb_root_path, $phpEx;
    $module_file = $phpbb_root_path . 'includes/' . $module_class . '/info/' . $module_class . '_' .$module_basename . '.' . $phpEx;
    if( !@file_exists($module_file) )
    {
        add_result("Module $module_basename", "The module's info file has not been uploaded. The module cannot be edited without the info file.");
        return FALSE;
    }
    return TRUE;
}

function check_for_installed($mode_details, $module_class, $parents)
{
    global $db;

    $parent_sql = '';
    if( !empty($parents) )
    {
        if( !is_array($parents) )
        {
            $parents = array($parents);
        }
        $parent_sql = ' AND ' . $db->sql_in_set('parent_id', $parents);
    }
    $sql = 'SELECT module_id FROM ' . MODULES_TABLE . "
            WHERE module_langname = '" . $db->sql_escape($mode_details['title']) . "'
                AND module_class = '" . $db->sql_escape($module_class) . "'";
    $sql .= $parent_sql;
    $result = $db->sql_query($sql);
    $rows = $db->sql_fetchrowset($result);
    $db->sql_freeresult($result);
    if( empty($rows) )
    {
        return FALSE;
    }
    
    return TRUE;
}

function add_modules($new_modules)
{
    global $db, $phpbb_root_path, $phpEx, $acp_modules;

    if( empty($new_modules) )
    {
        return;
    }
    foreach($new_modules as $k=>$v)
    {
        // Check if module name and mode exist...
        $module_class       = $v['class'];
        $module_basename    = $v['basename'];
        if( !check_for_info($module_class, $module_basename) )
        {
            continue;
        }
        $fileinfo = $acp_modules->get_module_infos($module_basename, $module_class);
        $fileinfo = $fileinfo[$module_basename];

        if( isset($fileinfo['new_parents']) )
        {
            install_modules($fileinfo['new_parents'], $module_class, '', true);
        }

        if( !empty($fileinfo['modes']) )
        {
            install_modules($fileinfo['modes'], $module_class, $module_basename);
        }
    }
}

function install_modules($modules, $module_class, $module_basename, $cats_only = FALSE)
{
    global $acp_modules, $user;
    $install_basename = $module_basename;
    foreach($modules as $module_mode => $mode_details)
    {
        $install_mode = $module_mode;
        // We need to get the parent for the mode.
        $parents = get_cat_ids($mode_details, $module_class);

        $msg = "Addition of module $module_basename, mode $module_mode";
        if( $cats_only )
        {
            $module_mode            = '';
            $mode_details['auth']   = '';
            $install_basename       = '';
            $install_mode           = '';
            $cat_name = ( isset($user->lang[$mode_details['title']]) ) ? $user->lang[$mode_details['title']] : $mode_details['title'];
            $msg = "Addition of menu category $cat_name";
        }

        foreach($parents as $parent_id)
        {
            // Check for an already installed instance of this module
            // under this parent. If it is already present, we don't install
            // again.
            if( check_for_installed($mode_details, $module_class, $parent_id) )
            {
                break;
            }
            $module_data = array(
                'module_basename'   => $install_basename,
                'module_enabled'    => 1,
                'module_display'    => (isset($mode_details['display'])) ? $mode_details['display'] : 1,
                'parent_id'         => $parent_id,
                'module_class'      => $module_class,
                'module_langname'   => $mode_details['title'],
                'module_mode'       => $install_mode,
                'module_auth'       => $mode_details['auth'],
            );

            $errors = $acp_modules->update_module_data($module_data, true);
            if( !empty($errors) )
            {
                add_result($msg, $errors[0]);
                break;
            }

            add_result($msg);
        }
    }
}

function process_sql()
{
    global $action, $sql, $db, $db_errors;
    if( empty($sql[$action]) )
    {
        return;
    }

    foreach($sql[$action] as $v)
    {
        if( !$result = $db->sql_query($v) )
        {
            $error = $db->sql_error();
            add_result($v, $error['message']);
        }
        else
        {
            add_result($v);
        }
    }
}

function wrap_up()
{
    global $cache, $action, $mod;
    add_log('admin', "<strong>Executed a modification database installer</strong><br />{$mod['name']} $action");

    // Now we will purge the cache.
    // This is necessary for any inserted or removed configuration settings
    // to take affect.
    $cache->purge();
    add_log('admin', 'LOG_PURGE_CACHE');
}

function add_result($item, $msg = '')
{
    global $results, $db_errors;
    $str = '<li>' . htmlspecialchars($item) . '<br /><span class="';
    if( !empty($msg) )
    {
        $str .= 'error">Failed due to error: ' . $msg;
        $db_errors = TRUE;
    }
    else
    {
        $str .= 'success">Completed successfully!';
    }
    $str .= '</span></li>';
    $results[] = $str;
}

function add_error_note()
{
    global $mod, $db_errors, $action;

    if( !$db_errors )
    {
        return '';
    }

    $site_string = $error_text = '';
    if( !empty($mod['website']) && !empty($mod['sitename']) )
    {
        $site_string = '<a href="' . $mod['website'] . '">' . $mod['sitename'] . '</a> or ';
    }

    $error_text .= ' If any error messages are listed above, a problem was encountered during the ';
    
    switch( $action )
    {
        case 'install':
            $error_text .= 'install. Any errors mentioning that a table already exists or duplicate entries or column names are often the result of running the install a second time by accident. Usually these errors can be ignored unless other problems appear when using the modification.';
        break;
        case 'upgrade':
            $error_text .= 'upgrade and some portions of the modification may not have been upgraded.';
        break;
        case 'uninstall':
            $error_text .= 'uninstall and some portions of the modification may not have been uninstalled.';
        break;
    }
    $error_text .= ' If you need assistance in troubleshooting these errors, please visit the support forums at ' . $site_string . ' <a href="http://sjpphpbb.net/phpbb3/">sjpphpbb.net</a>.';

    return $error_text;
}

echo $page_head;
echo $page_text;
if( !empty($action) )
{
    wrap_up();
    echo add_error_note();      
    echo $page_postaction;
}
echo $page_tail;
?>