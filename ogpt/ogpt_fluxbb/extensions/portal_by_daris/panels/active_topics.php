<?php
/***********************************************************************

	FluxBB extension
	Portal
	Daris <daris91@gmail.com>

************************************************************************/



$count = 5; // active topics count


// Make sure no one attempts to run this script "directly"
if (!defined('FORUM'))
	exit;

$content_class = 'forum';

// Load the viewforum.php language file
require_once FORUM_ROOT.'lang/'.$forum_user['language'].'/forum.php';
require_once FORUM_ROOT.'lang/'.$forum_user['language'].'/search.php';

// Get topic/forum tracking data
if (!$forum_user['is_guest'])
	$tracked_topics = get_tracked_topics();


// Fetch list of topics
$query = array(
	'SELECT'	=> 't.id, t.poster, t.subject, t.posted, t.first_post_id, t.last_post, t.last_post_id, t.last_poster, t.num_views, t.num_replies, t.closed, t.sticky, t.moved_to, t.forum_id, f.moderators',
	'FROM'		=> 'topics AS t',
	'JOINS'		=> array(
		array(
			'LEFT JOIN' 		=> 'forums as f',
			'ON'			=> 't.forum_id=f.id'
		),
		array(
			'LEFT JOIN'		=> 'forum_perms AS fp',
			'ON'			=> '(fp.forum_id=t.forum_id AND fp.group_id='.$forum_user['g_id'].')'
		)
	),
	'WHERE'		=> '(fp.read_forum IS NULL OR fp.read_forum=1) AND t.moved_to IS NULL',
	'ORDER BY'	=> 't.last_post DESC',
	'LIMIT'		=> '0, '.$count
);

// With "has posted" indication
if (!$forum_user['is_guest'] && $forum_config['o_show_dot'] == '1')
{
	$query['SELECT'] .= ', p.poster_id AS has_posted';
	$query['JOINS'][] = array(
		'LEFT JOIN'	=> 'posts AS p',
		'ON'		=> 't.id=p.topic_id AND p.poster_id='.$forum_user['id']
	);

	if ($db_type == 'sqlite')
	{
		$query['WHERE'] = 't.id IN(SELECT id FROM '.$forum_db->prefix.'topics WHERE forum_id='.$id.' ORDER BY sticky DESC, '.(($cur_forum['sort_by'] == '1') ? 'posted' : 'last_post').' DESC LIMIT '.$forum_page['start_from'].', '.$forum_user['disp_topics'].')';
		$query['ORDER BY'] = 't.sticky DESC, t.last_post DESC';
	}

	$query['GROUP BY'] = ($db_type != 'pgsql') ? 't.id' : 't.id, t.subject, t.poster, t.posted, t.first_post_id, t.last_post, t.last_post_id, t.last_poster, t.num_views, t.num_replies, t.closed, t.sticky, t.moved_to, p.poster_id';
}

($hook = get_hook('xn_portal_by_daris_at_qr_get_topics')) ? eval($hook) : null;
$result_at = $forum_db->query_build($query) or error(__FILE__, __LINE__);

($hook = get_hook('xn_portal_by_daris_at_pre_header_load')) ? eval($hook) : null;

?>		<table cellspacing="0">
			<thead>
				<tr>
<?php ($hook = get_hook('xn_portal_by_daris_at_table_header_begin')) ? eval($hook) : null; ?>
					<th class="tcl" scope="col"><?php echo $lang_common['Topic'] ?></th>
					<th class="tc2" scope="col"><?php echo $lang_common['Replies'] ?></th>
<?php if ($forum_config['o_topic_views'] == '1'): ?>					<th class="tc3" scope="col"><?php echo $lang_forum['Views'] ?></th>
<?php endif; ($hook = get_hook('xn_portal_by_daris_at_table_header_after_num_views')) ? eval($hook) : null; ?>					<th class="tcr" scope="col"><?php echo $lang_common['Last post'] ?></th>
<?php ($hook = get_hook('xn_portal_by_daris_at_table_header_after_last_post')) ? eval($hook) : null; ?>
				</tr>
			</thead>
			<tbody class="statused">
<?php

// If there are active topics
if ($forum_db->num_rows($result_at))
{
	($hook = get_hook('xn_portal_by_daris_at_pre_topic_loop_start')) ? eval($hook) : null;

	$forum_page['item_count'] = 0;

	while ($cur_topic = $forum_db->fetch_assoc($result_at))
	{
		($hook = get_hook('xn_portal_by_daris_at_topic_loop_start')) ? eval($hook) : null;

		++$forum_page['item_count'];

		// Start from scratch
		$forum_page['item_subject'] = $forum_page['item_status'] = $forum_page['item_last_post'] = $forum_page['item_alt_message'] = $forum_page['item_nav'] = array();
		$forum_page['item_indicator'] = '';
		$forum_page['item_alt_message']['topic'] = $lang_common['Topic'];

		if ($forum_config['o_censoring'] == '1')
			$cur_topic['subject'] = censor_words($cur_topic['subject']);

		if ($cur_topic['moved_to'] != null)
		{
			$forum_page['item_status']['moved'] = 'moved';
			$forum_page['item_last_post']['moved'] = $forum_page['item_alt_message']['moved'] = $lang_forum['Moved'];
			$forum_page['item_subject']['moved_to'] = '<a href="'.forum_link($forum_url['topic'], array($cur_topic['moved_to'], sef_friendly($cur_topic['subject']))).'">'.forum_htmlencode($cur_topic['subject']).'</a>';
			$forum_page['item_subject']['moved_by'] = '<span class="byuser">'.sprintf($lang_common['By user'], forum_htmlencode($cur_topic['poster'])).'</span>';
			$cur_topic['num_replies'] = $cur_topic['num_views'] = ' - ';
		}
		else
		{
			// Should we display the dot or not? :)
			if (!$forum_user['is_guest'] && $forum_config['o_show_dot'] == '1' && $cur_topic['has_posted'] == $forum_user['id'])
			{
				$forum_page['item_indicator'] = $lang_forum['You posted indicator'];
				$forum_page['item_status']['posted'] = 'posted';
				$forum_page['item_alt_message']['posted'] = $lang_forum['You posted'];
			}

			if ($cur_topic['sticky'] == '1')
			{
				$forum_page['item_subject']['sticky'] = $lang_forum['Sticky'];
				$forum_page['item_status']['sticky'] = 'sticky';
			}

			if ($cur_topic['closed'] == '1')
			{
				$forum_page['item_subject']['closed'] = $lang_common['Closed'];
				$forum_page['item_status']['closed'] = 'closed';
			}

			$forum_page['item_subject']['subject'] = '<a href="'.forum_link($forum_url['topic'], array($cur_topic['id'], sef_friendly($cur_topic['subject']))).'">'.forum_htmlencode($cur_topic['subject']).'</a>';

			$forum_page['item_pages'] = ceil(($cur_topic['num_replies'] + 1) / $forum_user['disp_posts']);

			if ($forum_page['item_pages'] > 1)
				$forum_page['item_nav']['pages'] = paginate($forum_page['item_pages'], -1, $forum_url['topic'], $lang_common['Page separator'], array($cur_topic['id'], sef_friendly($cur_topic['subject'])));

			// Does this topic contain posts we haven't read? If so, tag it accordingly.
			if (!$forum_user['is_guest'] && $cur_topic['last_post'] > $forum_user['last_visit'] && (!isset($tracked_topics['topics'][$cur_topic['id']]) || $tracked_topics['topics'][$cur_topic['id']] < $cur_topic['last_post']) && (!isset($tracked_topics['forums'][$cur_topic['forum_id']]) || $tracked_topics['forums'][$id] < $cur_topic['last_post']))
			{
				$forum_page['item_nav']['new'] = '<a href="'.forum_link($forum_url['topic_new_posts'], array($cur_topic['id'], sef_friendly($cur_topic['subject']))).'" title="'.$lang_forum['New posts info'].'">'.$lang_common['New posts'].'</a>';
				$forum_page['item_status']['new'] = 'new';
			}

			if (!empty($forum_page['item_nav']))
				$forum_page['item_subject']['nav'] = '<span class="topic-nav">[&#160;'.implode('&#160;&#160;', $forum_page['item_nav']).'&#160;]</span>';

			$forum_page['item_subject']['poster'] = '<span class="byuser">'.sprintf($lang_common['By user'], forum_htmlencode($cur_topic['poster'])).'</span>';
			$forum_page['item_last_post']['last_post'] = '<a href="'.forum_link($forum_url['post'], $cur_topic['last_post_id']).'"><span>'.format_time($cur_topic['last_post']).'</span></a>';
			$forum_page['item_last_post']['last_poster'] = '<span class="byuser">'.sprintf($lang_common['By user'], forum_htmlencode($cur_topic['last_poster'])).'</span>';

			if (empty($forum_page['item_status']))
				$forum_page['item_status']['normal'] = 'normal';
		}

		$forum_page['item_style'] = (($forum_page['item_count'] % 2 != 0) ? 'odd' : 'even').' '.implode(' ', $forum_page['item_status']);
		$forum_page['item_indicator'] = '<span class="status '.implode(' ', $forum_page['item_status']).'" title="'.implode(' - ', $forum_page['item_alt_message']).'"><img src="'.$base_url.'/style/'.$forum_user['style'].'/status.png" alt="'.implode(' - ', $forum_page['item_alt_message']).'" />'.$forum_page['item_indicator'].'</span>';

		($hook = get_hook('xn_portal_by_daris_at_row_pre_display')) ? eval($hook) : null;

?>
				<tr class="<?php echo $forum_page['item_style'] ?>">
<?php ($hook = get_hook('xn_portal_by_daris_at_table_contents_begin')) ? eval($hook) : null; ?>
					<td class="tcl"><?php echo $forum_page['item_indicator'].' '.implode(' ', $forum_page['item_subject']) ?></td>
					<td class="tc2"><?php echo $cur_topic['num_replies'] ?></td>
<?php if ($forum_config['o_topic_views'] == '1'): ?>					<td class="tc3"><?php echo $cur_topic['num_views'] ?></td>
<?php endif; ($hook = get_hook('xn_portal_by_daris_at_table_contents_after_num_views')) ? eval($hook) : null; ?>					<td class="tcr"><?php echo implode(' ', $forum_page['item_last_post']) ?></td>
<?php ($hook = get_hook('xn_portal_by_daris_at_table_contents_after_last_post')) ? eval($hook) : null; ?>
				</tr>
<?php

	}
}
// Else there are no active topics
else
{
	$forum_page['item_indicator'] = '<span class="status empty" title="'.$lang_forum['No topics'].'"><img src="'.$base_url.'/style/'.$forum_user['style'].'/status.png" alt="'.$lang_forum['No topics'].'" /></span>';

?>
				<tr class="odd empty">
					<td class="tcl"><?php echo $forum_page['item_indicator'].' '.$lang_forum['First topic nag'] ?></td>
					<td class="tc2">&#160;</td>
<?php if ($forum_config['o_topic_views'] == '1'): ?>					<td class="tc3">&#160;</td>
<?php endif; ?>					<td class="tcr"><?php echo $lang_forum['Never'] ?></td>
				</tr>
<?php

}

?>
			</tbody>
		</table>
	
	</div>
	<div>
	
		<div class="main-options gen-content">
			<p class="options">
				<span class="item1"><a href="<?php echo forum_link($forum_url['search_24h']) ?>"><?php echo $lang_search['Recently active topics'] ?></a></span>
				<span><a href="<?php echo forum_link($forum_url['search_unanswered']) ?>"><?php echo $lang_search['Unanswered topics'] ?></a></span>
<?php if (!$forum_user['is_guest']): ?>
				<span><a href="<?php echo forum_link($forum_url['search_subscriptions'], array($forum_user['id'])) ?>"><?php echo $lang_search['Subscriptions'] ?></a></span>
<?php endif; ?>
			</p>
		</div>

<?php


