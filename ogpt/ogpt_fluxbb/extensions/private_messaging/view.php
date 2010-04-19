<?php

if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', '../../');
require FORUM_ROOT.'include/common.php';

$id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;

if ($forum_user['g_pm'] == '0' || $forum_user['is_guest'] || $id < 1)
	message($lang_common['Bad request']);

if (file_exists(FORUM_ROOT.'extensions/private_messaging/lang/'.$forum_user['language'].'.php'))
	require FORUM_ROOT.'extensions/private_messaging/lang/'.$forum_user['language'].'.php';
else
	require FORUM_ROOT.'extensions/private_messaging/lang/English.php';

require FORUM_ROOT.'lang/'.$forum_user['language'].'/topic.php';

// Setup breadcrumbs
$forum_page['crumbs'] = array(
	array($forum_config['o_board_title'], forum_link($forum_url['index'])), $lang_private_messaging['Private messaging']
);

// Setup navigation menu
$forum_page['main_menu'] = array();
$forum_page['main_menu']['compose'] = '<li class="item1"><a href="'.forum_link($forum_url['pm_send']).'"><span>'.$lang_private_messaging['Compose message'].'</span></a></li>';
$forum_page['main_menu']['inbox'] = '<li><a href="'.forum_link($forum_url['pm']).'"><span>'.$lang_private_messaging['Inbox'].'</span></a></li>';
$forum_page['main_menu']['sent'] = '<li><a href="'.forum_link($forum_url['pm_sent']).'"><span>'.$lang_private_messaging['Sent messages'].'</span></a></li>';
//$forum_page['main_menu']['settings'] = '<li><a href="'.forum_link($forum_url['pm_settings']).'"><span>Settings</span></a></li>';

// Setup headings
$forum_page['main_head'] = $lang_private_messaging['Private messaging'].' : '.$lang_private_messaging['View message'];

// Setup form
$forum_page['fld_count'] = 0;
$forum_page['form_action'] = forum_link($forum_url['pm_send']);

// Retrieve the message
$query = array(
	'SELECT'	=> 'm2.id AS reply_to, m2.subject AS reply_to_subject, m2.to_id AS reply_to_to_id, m2.from_id AS reply_to_from_id, m2.deleted AS reply_to_deleted, m3.id AS replied, m3.subject AS replied_subject, m3.to_id AS replied_to_id, m3.from_id AS replied_from_id, m3.deleted AS replied_deleted, m.id, m.subject, m.message, m.to_id, m.from_id, m.ip, m.sent, m.hide_smilies, m.marked_read, u.username, u.email, u.title, u.url, u.location, u.signature, u.email_setting, u.num_posts, u.registered, u.admin_note, g.g_id, g.g_user_title, g.g_pm, o.user_id AS is_online',
	'FROM'		=> 'messages AS m',
	'JOINS'		=> array(
		array(
			'LEFT JOIN'		=> 'messages AS m2',
			'ON'			=> 'm2.id=m.reply_to'
		),
		array(
			'LEFT JOIN'		=> 'messages AS m3',
			'ON'			=> 'm3.reply_to=m.id'
		),
		array(
			'INNER JOIN'	=> 'users AS u',
			'ON'			=> 'u.id=m.from_id'
		),
		array(
			'INNER JOIN'	=> 'groups AS g',
			'ON'			=> 'g.g_id=u.group_id'
		),
		array(
			'LEFT JOIN'		=> 'online AS o',
			'ON'			=> '(o.user_id=u.id AND o.user_id!=1 AND o.idle=0)'
		),
	),
	'WHERE'		=> '((m.to_id='.$forum_user['id'].' AND m.deleted!=1) OR (m.from_id='.$forum_user['id'].' AND m.deleted!=2)) AND m.id='.$id,
	'ORDER BY'	=> 'm3.id DESC',
	'LIMIT'		=> '0,1'
);

$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

if (!$cur_message = $forum_db->fetch_assoc($result))
	message($lang_common['Bad request']);

if ($cur_message['to_id'] != $forum_user['id'] && $cur_message['from_id'] != $forum_user['id'])
	message($lang_common['Bad request']);

// If required mark as read
if ($cur_message['marked_read'] == '0' && $cur_message['to_id'] == $forum_user['id'])
{
	$query = array(
		'UPDATE'	=> 'messages',
		'SET'		=> 'marked_read=1',
		'WHERE'		=> 'id='.$id,
	);

	$forum_db->query_build($query) or error(__FILE__, __LINE__);
}

// Replies
$forum_page['main_options'] = array();
if ($cur_message['reply_to'] && (($cur_message['reply_to_to_id'] == $forum_user['id'] && $cur_message['reply_to_deleted'] != 1) || ($cur_message['reply_to_from_id'] == $forum_user['id'] && $cur_message['reply_to_deleted'] != 2)))
	$forum_page['main_options']['replyto'] = '<span'.(empty($forum_page['main_options']) ? ' class="item1"' : '').'>'.$lang_private_messaging['This message is a reply to'].' <a href="'.forum_link($forum_url['pm_view'], $cur_message['reply_to']).'">"'.$cur_message['reply_to_subject'].'"</a></span>';
if ($cur_message['replied'] && (($cur_message['replied_to_id'] == $forum_user['id'] && $cur_message['replied_deleted'] != 1) || ($cur_message['replied_from_id'] == $forum_user['id'] && $cur_message['replied_deleted'] != 2)))
	$forum_page['main_options']['reply'] = '<span'.(empty($forum_page['main_options']) ? ' class="item1"' : '').'>'.$lang_private_messaging['This message has a reply:'].' <a href="'.forum_link($forum_url['pm_view'], $cur_message['replied']).'">"'.$cur_message['replied_subject'].'"</a></span>';

define('FORUM_ALLOW_INDEX', 0);
define('FORUM_PAGE', 'pm-view');
define('FORUM_PAGE_TYPE', 'pm');

require FORUM_ROOT.'header.php';

// START SUBST - <!-- forum_main -->
ob_start();

if (!defined('FORUM_PARSER_LOADED'))
	require FORUM_ROOT.'include/parser.php';

?>
<div id="pm-view" class="main-content pm">
	<div class="content-head">
		<h2 class="hn"><span><?php echo forum_htmlencode($cur_message['subject']) ?></span></h2>
	</div>
<?php

$signature = '';
$forum_page['user_ident'] = array();
$forum_page['user_info'] = array();
$forum_page['post_options'] = array();
$forum_page['post_contacts'] = array();
$forum_page['message'] = array();

// Generate the post heading
$forum_page['item_ident'] = array(
	'date'	=> '<span>'.format_time($cur_message['sent']).'</span>'
);

$forum_page['item_head'] = '<a class="permalink" rel="bookmark" href="'.forum_link($forum_url['pm_view'], $cur_message['id']).'">'.implode(' ', $forum_page['item_ident']).'</a>';

// Generate author identification
if ($forum_config['o_avatars'] == '1' && $forum_user['show_avatars'] != '0')
{
	$forum_page['user_ident']['avatar'] = generate_avatar_markup($cur_message['from_id']);
}

$forum_page['user_ident']['username'] = ($forum_user['g_view_users'] == '1') ? '<strong class="username"><a title="'.sprintf($lang_topic['Go to profile'], forum_htmlencode($cur_message['username'])).'" href="'.forum_link($forum_url['user'], $cur_message['from_id']).'">'.forum_htmlencode($cur_message['username']).'</a></strong>' : '<strong class="username">'.forum_htmlencode($cur_message['username']).'</strong>';
$forum_page['user_ident']['usertitle'] = '<span class="usertitle">'.get_title($cur_message).'</span>';

if ($cur_message['is_online'] == $cur_message['from_id'])
	$forum_page['user_status'] = $lang_topic['Online'];
else
	$forum_page['user_status'] = $lang_topic['Offline'];

$forum_page['user_ident']['status'] = '<small class="userstatus">'.$forum_page['user_status'].'</small>';

if ($forum_config['o_show_user_info'] == '1')
{
	if ($cur_message['location'] != '')
	{
		if ($forum_config['o_censoring'] == '1')
			$cur_message['location'] = censor_words($cur_message['location']);

		$forum_page['user_info']['from'] = '<li><span><strong>'.$lang_topic['From'].'</strong> '.forum_htmlencode($cur_message['location']).'</span></li>';
	}

	$forum_page['user_info']['registered'] = '<li><span><strong>'.$lang_topic['Registered'].'</strong> '.format_time($cur_message['registered'], true).'</span></li>';

	if ($forum_config['o_show_post_count'] == '1' || $forum_user['is_admmod'])
		$forum_page['user_info']['posts'] = '<li><span><strong>'.$lang_topic['Posts'].'</strong> '.$cur_message['num_posts'].'</span></li>';
}

if ($forum_user['is_admmod'])
{
	if ($cur_message['admin_note'] != '')
		$forum_page['user_info']['note'] = '<li><span><strong>'.$lang_topic['Note'].'</strong> '.forum_htmlencode($cur_message['admin_note']).'</span></li>';

	$forum_page['user_info']['ip'] = '<li><span><strong>'.$lang_topic['IP'].'</strong> <a href="'.forum_link($forum_url['get_host'], $cur_message['ip']).'">'.$cur_message['ip'].'</a></span></li>';
}

// Generate author contact details
if ($forum_config['o_show_user_info'] == '1')
{
	if ($cur_message['url'] != '')
		$forum_page['post_contacts']['url'] = '<a class="external" href="'.forum_htmlencode(($forum_config['o_censoring'] == '1') ? censor_words($cur_message['url']) : $cur_message['url']).'"><span>'.sprintf($lang_topic['Visit website'], forum_htmlencode($cur_message['username'])).'</span></a>';
	if ((($cur_message['email_setting'] == '0' && !$forum_user['is_guest']) || $forum_user['is_admmod']) && $forum_user['g_send_email'] == '1')
		$forum_page['post_contacts']['email'] = '<a href="mailto:'.$cur_message['email'].'"><span>'.$lang_topic['E-mail'].'<span>&#160;'.forum_htmlencode($cur_message['username']).'</span></span></a>';
	else if ($cur_message['email_setting'] == '1' && !$forum_user['is_guest'] && $forum_user['g_send_email'] == '1')
		$forum_page['post_contacts']['email'] = '<a href="'.forum_link($forum_url['email'], $cur_message['from_id']).'"><span>'.$lang_topic['E-mail'].'<span>&#160;'.forum_htmlencode($cur_message['username']).'</span></span></a>';
}
if ($cur_message['g_pm'] == 1)
	$forum_page['post_contacts']['pm'] = '<a href="'.forum_link($forum_url['pm_send_to'], $cur_message['from_id']).'"><span>'.$lang_private_messaging['PM'].'<span>&#160;'.forum_htmlencode($cur_message['username']).'</span></span></a>';

$forum_page['post_options']['delete'] = '<a href="'.forum_link($forum_url['pm_delete'], array($cur_message['id'], generate_form_token('pm_delete'.$cur_message['id'].$forum_user['id']))).'"><span>'.$lang_topic['Delete'].'</span></a>';
if ($cur_message['to_id'] == $forum_user['id'])
{
	$forum_page['post_options']['reply'] = '<a href="'.forum_link($forum_url['pm_reply'], $cur_message['id']).'"><span>'.$lang_private_messaging['Reply'].'</span></a>';
	$forum_page['post_options']['quote'] = '<a href="'.forum_link($forum_url['pm_quote'], $cur_message['id']).'"><span>'.$lang_topic['Quote'].'</span></a>';
}

// Give the post some class
$forum_page['item_status'] = array(
	'post',
	'odd'
);

$forum_page['item_status']['firstpost'] = 'firstpost';
$forum_page['item_status']['lastpost'] = 'lastpost';
$forum_page['item_status']['topicpost'] = 'topicpost';

$forum_page['item_subject'] = forum_htmlencode($cur_message['subject']);

// Perform the main parsing of the message (BBCode, smilies, censor words etc)
$forum_page['message']['message'] = parse_message($cur_message['message'], $cur_message['hide_smilies']);

// Do signature parsing/caching
if ($cur_message['signature'] != '' && $forum_user['show_sig'] != '0' && $forum_config['o_signatures'] == '1')
	$forum_page['message']['signature'] = '<div class="sig-content"><span class="sig-line"><!-- --></span>'.parse_signature($cur_message['signature']).'</div>';

?>
	<div class="<?php echo implode(' ', $forum_page['item_status']) ?>">
		<div id="m<?php echo $cur_message['id'] ?>" class="posthead">
			<h3><?php echo $forum_page['item_head'] ?></h3>
		</div>
		<div class="postbody">
			<div class="user<?php if ($cur_message['is_online'] == $cur_message['from_id']) echo ' online' ?>">
				<h4 class="user-ident"><?php echo implode('<br />', $forum_page['user_ident']) ?></h4>
				<ul class="user-info">
					<?php echo implode("\n\t\t\t\t\t", $forum_page['user_info'])."\n" ?>
				</ul>
			</div>
			<div class="post-entry">
				<h4 class="entry-title"><?php echo $forum_page['item_subject'] ?></h4>
				<div class="entry-content">
					<?php echo implode("\n\t\t\t\t\t", $forum_page['message'])."\n" ?>
				</div>
			</div>
		</div>
<?php if (!empty($forum_page['post_options']) || !empty($forum_page['post_contacts'])): ?>		<div class="postfoot">
			<div class="postfoot-inner">
<?php if (!empty($forum_page['post_contacts'])): ?>				<p class="post-contacts"><?php echo implode(' ', $forum_page['post_contacts']) ?></p>
<?php endif; if (!empty($forum_page['post_contacts'])): ?>				<p class="post-options"><?php echo implode(' ', $forum_page['post_options']) ?></p>
<?php endif; ?>			</div>
		</div>
<?php endif; ?>	</div>
</div>
<?php

$tpl_temp = forum_trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->

require FORUM_ROOT.'footer.php';