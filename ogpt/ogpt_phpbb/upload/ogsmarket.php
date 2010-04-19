<?php
/** 
*
* @package phpBB3
* @version $Id: faq.php,v 1.35 2006/12/24 13:11:52 acydburn Exp $
* @copyright (c) 2005 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* @ignore
*/
define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

$mode = request_var('mode', '');

// Load the appropriate faq file
switch ($mode)
{
	case 'bbcode':
		$l_title = $user->lang['BBCODE_GUIDE'];
		$user->add_lang('bbcode', false, true);
	break;

	default:
		$l_title = $user->lang['OGSMARKET_EXPLAIN'];
		$user->add_lang('ogsmarket', false, true);
	break;
}


page_header($l_title);

$template->set_filenames(array(
	'body' => 'ogsmarket_body.html')
);
make_jumpbox(append_sid("{$phpbb_root_path}viewforum.$phpEx"));

page_footer();

?>