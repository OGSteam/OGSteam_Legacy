<?php

if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', '../../');
require FORUM_ROOT.'include/common.php';

if ($forum_user['g_pm'] == '0' || $forum_user['is_guest'])
	message($lang_common['Bad request']);

if (file_exists(FORUM_ROOT.'extensions/private_messaging/lang/'.$forum_user['language'].'.php'))
	require FORUM_ROOT.'extensions/private_messaging/lang/'.$forum_user['language'].'.php';
else
	require FORUM_ROOT.'extensions/private_messaging/lang/English.php';

$view = (isset($_GET['view'])) ? $_GET['view'] : 'inbox';
$action = (isset($_GET['action'])) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$messages = isset($_POST['messages']) ? @array_map('intval', @array_keys($_POST['messages'])) : array();

if ($action == 'delete')
{
	if (!isset($_POST['csrf_token']) && (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== generate_form_token('pm_delete'.$id.$forum_user['id'])))
	csrf_confirm_form();

	if ($id < 1)
		message($lang_common['Bad request']);

	// Retrieve the message
	$query = array(
		'SELECT'	=> 'm.to_id, m.from_id, m.deleted',
		'FROM'		=> 'messages AS m',
		'WHERE'		=> 'm.id='.$id,
	);

	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

	if (!$cur_message = $forum_db->fetch_assoc($result))
		message($lang_common['Bad request']);
	
	if (($cur_message['from_id'] == $forum_user['id'] && $cur_message['to_id'] == $forum_user['id']) || ($cur_message['to_id'] == $forum_user['id'] && $cur_message['deleted'] == 2) || ($cur_message['from_id'] == $forum_user['id'] && $cur_message['deleted'] == 1))
	{
		$query = array(
			'DELETE'	=> 'messages',
			'WHERE'		=> 'id='.$id
		);
	}
	else if ($cur_message['to_id'] == $forum_user['id'])
	{
		$query = array(
			'UPDATE'	=> 'messages',
			'SET'		=> 'deleted=1',
			'WHERE'		=> 'id='.$id
		);
	}
	else if ($cur_message['from_id'] == $forum_user['id'])
	{
		$query = array(
			'UPDATE'	=> 'messages',
			'SET'		=> 'deleted=2',
			'WHERE'		=> 'id='.$id
		);
	}
	else
		message($lang_common['Bad request']);
	
	$forum_db->query_build($query) or error(__FILE__, __LINE__);
}

if ($action == 'read' && $view == 'inbox')
{
	if (!isset($_POST['csrf_token']) && (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== generate_form_token('markpmread'.$forum_user['id'])))
		csrf_confirm_form();

	$query = array(
		'UPDATE'	=> 'messages',
		'SET'		=> 'marked_read=1',
		'WHERE'		=> 'to_id='.$forum_user['id'],
	);

	$forum_db->query_build($query) or error(__FILE__, __LINE__);
}

if (isset($_POST['mark_read']))
{
	$query = array(
		'UPDATE'	=> 'messages',
		'SET'		=> 'marked_read=1',
		'WHERE'		=> 'to_id='.$forum_user['id'].' AND id IN('.implode(',', $messages).')',
	);

	$forum_db->query_build($query) or error(__FILE__, __LINE__);
}

if (isset($_POST['delete']))
{
	$query = array(
		'DELETE'	=> 'messages',
		'WHERE'		=> '((to_id='.$forum_user['id'].' AND deleted=2) OR (from_id='.$forum_user['id'].' AND deleted=1)) AND id IN('.implode(',', $messages).')'
	);
	$forum_db->query_build($query) or error(__FILE__, __LINE__);

	if ($view == 'inbox')
	{
		$query = array(
			'UPDATE'	=> 'messages',
			'SET'		=> 'deleted=1',
			'WHERE'		=> 'to_id='.$forum_user['id'].' AND id IN('.implode(',', $messages).')'
		);
	}
	else if ($view == 'sent')
	{
		$query = array(
			'UPDATE'	=> 'messages',
			'SET'		=> 'deleted=2',
			'WHERE'		=> 'from_id='.$forum_user['id'].' AND id IN('.implode(',', $messages).')'
		);
	}
	$forum_db->query_build($query) or error(__FILE__, __LINE__);
}

// Find out how many PMs we have
$query = array(
	'SELECT'	=> 'count(m.id) as num_messages',
	'FROM'		=> 'messages AS m',
);

if ($view == 'inbox')
	$query['WHERE'] = 'm.deleted != 1 AND m.to_id='.$forum_user['id'];
else if ($view == 'sent')
	$query['WHERE'] = 'm.deleted != 2 AND m.from_id='.$forum_user['id'];

$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

$messages = $forum_db->fetch_assoc($result);

// Determine the topic offset (based on $_GET['p'])
$forum_page['num_pages'] = ceil($messages['num_messages'] / $forum_user['disp_topics']);

$forum_page['page'] = (!isset($_GET['p']) || $_GET['p'] <= 1 || $_GET['p'] > $forum_page['num_pages']) ? 1 : $_GET['p'];
$forum_page['start_from'] = $forum_user['disp_topics'] * ($forum_page['page'] - 1);
$forum_page['finish_at'] = min(($forum_page['start_from'] + $forum_user['disp_topics']), ($messages['num_messages']));

// Generate paging links
$forum_page['page_post']['paging'] = '<p class="paging"><span class="pages">'.$lang_common['Pages'].'</span> '.paginate($forum_page['num_pages'], $forum_page['page'], $forum_url['pm_inbox'], $lang_common['Paging separator']).'</p>';

// Navigation links for header and page numbering for title/meta description
if ($forum_page['page'] < $forum_page['num_pages'])
{
	$forum_page['nav']['last'] = '<link rel="last" href="'.forum_sublink($forum_url['pm_inbox'], $forum_url['page'], $forum_page['num_pages']).'" title="'.$lang_common['Page'].' '.$forum_page['num_pages'].'" />';
	$forum_page['nav']['next'] = '<link rel="next" href="'.forum_sublink($forum_url['pm_inbox'], $forum_url['page'], ($forum_page['page'] + 1)).'" title="'.$lang_common['Page'].' '.($forum_page['page'] + 1).'" />';
}
if ($forum_page['page'] > 1)
{
	$forum_page['nav']['prev'] = '<link rel="prev" href="'.forum_sublink($forum_url['pm_inbox'], $forum_url['page'], ($forum_page['page'] - 1)).'" title="'.$lang_common['Page'].' '.($forum_page['page'] - 1).'" />';
	$forum_page['nav']['first'] = '<link rel="first" href="'.forum_link($forum_url['pm']).'" title="'.$lang_common['Page'].' 1" />';
}

// Setup breadcrumbs
$forum_page['crumbs'] = array(
	array($forum_config['o_board_title'], forum_link($forum_url['index'])), $lang_private_messaging['Private messaging']
);

// Setup navigation menu
$forum_page['main_menu'] = array();
$forum_page['main_menu']['compose'] = '<li class="item1"><a href="'.forum_link($forum_url['pm_send']).'"><span>'.$lang_private_messaging['Compose message'].'</span></a></li>';
$forum_page['main_menu']['inbox'] = '<li'.(($view == 'inbox')  ? ' class="active"' : '').'><a href="'.forum_link($forum_url['pm']).'"><span>'.$lang_private_messaging['Inbox'].'</span></a></li>';
$forum_page['main_menu']['sent'] = '<li'.(($view == 'sent')  ? ' class="active"' : '').'><a href="'.forum_link($forum_url['pm_sent']).'"><span>'.$lang_private_messaging['Sent messages'].'</span></a></li>';
//$forum_page['main_menu']['settings'] = '<li><a href="'.forum_link($forum_url['pm_settings']).'"><span>Settings</span></a></li>';

// Setup headings
if ($view == 'inbox')
	$forum_page['main_head'] = $lang_private_messaging['Private messaging'].' : '.$lang_private_messaging['Inbox'];
else if ($view == 'sent')
	$forum_page['main_head'] = $lang_private_messaging['Private messaging'].' : '.$lang_private_messaging['Sent messages'];

if ($forum_page['num_pages'] > 1)
	$forum_page['main_head'] .= '<br /><small>'.sprintf($lang_private_messaging['Message pages'], $forum_page['start_from'] + 1, $forum_page['finish_at'], $messages['num_messages']).'</small>';

// Setup form
$forum_page['fld_count'] = 0;
if ($view == 'inbox')
	$forum_page['form_action'] = forum_link($forum_url['pm']);
else if ($view == 'sent')
	$forum_page['form_action'] = forum_link($forum_url['pm_sent']);


define('FORUM_ALLOW_INDEX', 0);
$forum_page['fld_count'] = 0;
define('FORUM_PAGE', 'pm-'.$view);
define('FORUM_PAGE_TYPE', 'pm');

require FORUM_ROOT.'header.php';

// START SUBST - <!-- forum_main -->
ob_start();

?>
<form method="post" accept-charset="utf-8" action="<?php echo $forum_page['form_action'] ?>">
<div id="privatemessaging" class="main-content forum">
	<div class="hidden">
		<input type="hidden" name="csrf_token" value="<?php echo generate_form_token($forum_page['form_action']) ?>" />
	</div>
	<table cellspacing="0">
		<thead>
			<tr>
				<th class="tcl" scope="col"><?php echo $lang_private_messaging['Subject'] ?></th>
				<th class="tcr" scope="col"><?php echo $lang_private_messaging['Sent'] ?></th>
				<th class="tcmod" scope="col"><?php echo $lang_private_messaging['Select'] ?></th>
			</tr>
		</thead>
		<tbody class="statused">
<?php

// Select topics
$query = array(
	'SELECT'	=> 'm.id, m.subject, m.sent, m.marked_read, u.username, m2.id as replied',
	'FROM'		=> 'messages AS m',
	'JOINS'		=> array(
		array(
			'LEFT JOIN'		=> 'messages as m2',
			'ON'			=> 'm.id = m2.reply_to'
		)
	),
	'ORDER BY'	=> 'm.sent DESC',
	'GROUP BY'	=> 'm.id',
	'LIMIT'		=>	$forum_page['start_from'].', '.$forum_user['disp_topics']
);

if ($view == 'inbox')
{
	$query['WHERE'] = 'm.deleted != 1 AND m.to_id='.$forum_user['id'];
	$query['JOINS'][] = array(
			'LEFT JOIN'		=> 'users as u',
			'ON'			=> 'm.from_id = u.id'
	);
}
else if ($view == 'sent')
{
	$query['WHERE'] = 'm.deleted != 2 AND m.from_id='.$forum_user['id'];
	$query['JOINS'][] = array(
			'LEFT JOIN'		=> 'users as u',
			'ON'			=> 'm.to_id = u.id'
	);
}

$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

if ($forum_db->num_rows($result))
{
	$forum_page['item_count'] = 0;

	while ($cur_message = $forum_db->fetch_assoc($result))
	{
		++$forum_page['item_count'];

		// Start from scratch
		$forum_page['item_subject'] = $forum_page['item_status'] = $forum_page['item_last_post'] = $forum_page['item_alt_message'] = $forum_page['item_nav'] = array();
		$forum_page['item_indicator'] = '';
		$forum_page['item_alt_message']['message'] = 'Message';

		if ($forum_config['o_censoring'] == '1')
			$cur_message['subject'] = censor_words($cur_message['subject']);

		$forum_page['item_subject']['subject'] = '<a href="'.forum_link($forum_url['pm_view'], array($cur_message['id'], sef_friendly($cur_message['subject']))).'">'.forum_htmlencode($cur_message['subject']).'</a>';

		$forum_page['item_sent']['sent'] = '<a href="'.forum_link($forum_url['pm_view'], $cur_message['id']).'">'.format_time($cur_message['sent']).'</a>';
		if ($view == 'inbox')
			$forum_page['item_sent']['from'] = '<span class="byuser">'.sprintf($lang_common['By user'], forum_htmlencode($cur_message['username'])).'</span>';
		else if ($view == 'sent')
			$forum_page['item_sent']['from'] = '<span class="byuser">'.$lang_private_messaging['to'].' '.forum_htmlencode($cur_message['username']).'</span>';

		if ($cur_message['marked_read'] == 0)
			$forum_page['item_status']['new'] = 'new';
		else
			$forum_page['item_status']['normal'] = 'normal';

		$forum_page['subject_label'] = $cur_message['subject'];

		if (!empty($cur_message['replied']))
			$forum_page['item_indicator'] = '·&#160';

		$forum_page['item_style'] = (($forum_page['item_count'] % 2 != 0) ? 'odd' : 'even').' '.implode(' ', $forum_page['item_status']);
		$forum_page['item_indicator'] = '<span class="status '.implode(' ', $forum_page['item_status']).'" title="'.implode(' - ', $forum_page['item_alt_message']).'"><img src="'.$base_url.'/style/'.$forum_user['style'].'/status.png" alt="'.implode(' - ', $forum_page['item_alt_message']).'" />'.$forum_page['item_indicator'].'</span>';

?>
			<tr class="<?php echo $forum_page['item_style'] ?>">
				<td class="tcl"><?php echo $forum_page['item_indicator'].' '.implode(' ', $forum_page['item_subject']) ?></td>
				<td class="tcr"><?php echo implode(' ', $forum_page['item_sent']) ?></td>
				<td class="tcmod"><label for="fld<?php echo ++$forum_page['fld_count'] ?>"><input id="fld<?php echo $forum_page['fld_count'] ?>" type="checkbox" name="messages[<?php echo $cur_message['id'] ?>]" value="1" /> <span><?php echo $forum_page['subject_label'] ?></span></label></td>
			</tr>
<?php

	}

	$forum_page['options'] = array();
	$forum_page['options']['delete'] = '<span class="submit item1"><input type="submit" name="delete" value="'.$lang_private_messaging['Delete selected'].'" /></span>';
	if ($view == 'inbox')
	{
		$forum_page['options']['mark_read'] = '<span class="submit"><input type="submit" name="mark_read" value="'.$lang_private_messaging['Mark selected as read'].'" /></span>';
		$forum_page['options']['mark_all_read'] = '<span><a href="'.forum_link($forum_url['pm_read'], generate_form_token('markpmread'.$forum_user['id'])).'">'.$lang_private_messaging['Mark all as read'].'</a></span>';
	}
}
else
{
	$forum_page['item_indicator'] = '<span class="status empty" title="'.$lang_private_messaging['No messages'].'"><img src="'.$base_url.'/style/'.$forum_user['style'].'/status.png" alt="'.$lang_private_messaging['No messages'].'" /></span>';

?>
			<tr class="odd empty">
				<td class="tcl"><?php echo $forum_page['item_indicator'].' '.$lang_private_messaging['No messages'] ?></td>
				<td class="tcr"> - </td>
				<td class="tcmod"> - </td>
			</tr>
<?php

}

?>
		</tbody>
	</table>
</div>
<?php if (!empty($forum_page['options'])): ?><div class="main-options mod-options">
	<p class="options"><?php echo implode(' ', $forum_page['options']) ?></p>
</div>
<?php endif; ?></form>
<?php

$tpl_temp = trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->

require FORUM_ROOT.'footer.php';