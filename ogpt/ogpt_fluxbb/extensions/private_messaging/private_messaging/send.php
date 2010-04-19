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

// Load the post.php language file
require FORUM_ROOT.'lang/'.$forum_user['language'].'/post.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$quote = isset($_GET['quote']) ? intval($_GET['quote']) : 0;
$to = isset($_GET['to']) ? intval($_GET['to']) : 0;

if ($id < 0 || $to < 0 || $quote < 0 || $to > 0 && ($id > 0 || $quote > 0))
	message($lang_common['Bad request']);

$disable_quote = true;
if ($quote)
{
	$id = $quote;
	$disable_quote = false;
}

if ($to)
{
	// Get username
	$query = array(
		'SELECT'	=> 'u.username',
		'FROM'		=> 'users AS u',
		'WHERE'		=> 'u.id='.$to,
	);
}
else if ($id)
{
	// Get message
	$query = array(
		'SELECT'	=> 'm.subject, u.username, m.message, m.first_message',
		'FROM'		=> 'messages AS m',
		'JOINS'		=> array(
			array(
				'INNER JOIN'	=> 'users AS u',
				'ON'			=> 'u.id=m.from_id'
			),
		),
		'WHERE'		=> 'm.id='.$id,
	);
}

if ($to || $id)
{
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

	if (!$forum_db->num_rows($result))
		message($lang_common['Bad request']);

	$cur_posting = $forum_db->fetch_assoc($result);
}

// Start with a clean slate
$errors = array();

// Did someone just hit "Submit" or "Preview"?
if (isset($_POST['form_sent']))
{
	// Flood protection
	if (!isset($_POST['preview']) && $forum_user['last_post'] != '' && (time() - $forum_user['last_post']) < $forum_user['g_post_flood'] && (time() - $forum_user['last_post']) >= 0)
		$errors[] = sprintf($lang_post['Flood'], $forum_user['g_post_flood']);

	$subject = trim($_POST['req_subject']);

	if ($subject == '')
		$errors[] = $lang_post['No subject'];
	else if (utf8_strlen($subject) > 70)
		$errors[] = $lang_post['Too long subject'];
	else if ($forum_config['p_subject_all_caps'] == '0' && utf8_strtoupper($subject) == $subject && !$forum_page['is_admmod'])
		$subject = utf8_ucwords(utf8_strtolower($subject));

	$to = trim($_POST['req_to']);

	// If we're an administrator or moderator, make sure the CSRF token in $_POST is valid
	if ($forum_user['is_admmod'] && (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== generate_form_token(get_current_url())))
		$errors[] = $lang_post['CSRF token mismatch'];

	// Clean up message from POST
	$message = forum_linebreaks(trim($_POST['req_message']));

	if ($message == '')
		$errors[] = $lang_post['No message'];
	else if (utf8_strlen($message) > FORUM_MAX_POSTSIZE)
		$errors[] = $lang_post['Too long message'];
	else if ($forum_config['p_message_all_caps'] == '0' && utf8_strtoupper($message) == $message && !$forum_page['is_admmod'])
		$message = utf8_ucwords(utf8_strtolower($message));

	// Validate BBCode syntax
	if ($forum_config['p_message_bbcode'] == '1' || $forum_config['o_make_links'] == '1')
	{
		if (!defined('FORUM_PARSER_LOADED'))
			require FORUM_ROOT.'include/parser.php';
		$message = preparse_bbcode($message, $errors);
	}

	$hide_smilies = isset($_POST['hide_smilies']) ? 1 : 0;
	$first_message = isset($_POST['first_message']) ? intval($_POST['first_message']) : 0;
	$reply_to = isset($_POST['reply_to']) ? intval($_POST['reply_to']) : 0;
	
	$query = array(
		'SELECT'	=> 'u.id',
		'FROM'		=> 'users AS u',
		'WHERE'		=> 'u.username=\''.$forum_db->escape($to).'\'',
	);

	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

	$to_id = $forum_db->result($result);
	if (!$to_id)
		$errors[] = $lang_private_messaging['User does not exist'];

	$now = time();

	// Did everything go according to plan?
	if (empty($errors) && !isset($_POST['preview']))
	{
		// Send message
		$query = array(
			'INSERT'	=> 'to_id, from_id, subject, message, hide_smilies, sent, first_message, reply_to',
			'INTO'		=> 'messages',
			'VALUES'	=> '\''.$to_id.'\', '.$forum_user['id'].', \''.$forum_db->escape($subject).'\', \''.$forum_db->escape($message).'\', '.$hide_smilies.', '.$now.', '.$first_message.', '.$reply_to
		);
		
		$forum_db->query_build($query) or error(__FILE__, __LINE__);

		if ($first_message == 0)
		{
			$query = array(
				'UPDATE'	=> 'messages',
				'SET'		=> 'first_message=id',
				'WHERE'		=> 'id='.$forum_db->insert_id(),
			);
			
			$forum_db->query_build($query) or error(__FILE__, __LINE__);
		}

		// Update last post [TODO: Separate PM limit]
		$query = array(
			'UPDATE'	=> 'users',
			'SET'		=> 'last_post='.$now,
			'WHERE'		=> 'id='.$forum_user['id'],
		);

		$forum_db->query_build($query) or error(__FILE__, __LINE__);

		redirect(forum_link($forum_url['pm_sent']), $lang_private_messaging['Message sent']);
	}
}


// Are we quoting someone?
if ($id && !$disable_quote)
{
	$q_poster = $cur_posting['username'];
	$q_message = $cur_posting['message'];
	if ($forum_config['p_message_bbcode'] == '1')
	{
		// If username contains a square bracket, we add "" or '' around it (so we know when it starts and ends)
		if (strpos($q_poster, '[') !== false || strpos($q_poster, ']') !== false)
		{
			if (strpos($q_poster, '\'') !== false)
				$q_poster = '"'.$q_poster.'"';
			else
				$q_poster = '\''.$q_poster.'\'';
		}
		else
		{
			// Get the characters at the start and end of $q_poster
			$ends = utf8_substr($q_poster, 0, 1).utf8_substr($q_poster, -1, 1);

			// Deal with quoting "Username" or 'Username' (becomes '"Username"' or "'Username'")
			if ($ends == '\'\'')
				$q_poster = '"'.$q_poster.'"';
			else if ($ends == '""')
				$q_poster = '\''.$q_poster.'\'';
		}

		$forum_page['quote'] = '[quote='.$q_poster.']'.$q_message.'[/quote]'."\n";
	}
	else
		$forum_page['quote'] = '> '.$q_poster.' '.$lang_common['wrote'].':'."\n\n".'> '.$q_message."\n";
}


// Setup form
$forum_page['set_count'] = $forum_page['fld_count'] = 0;
$forum_page['form_action'] = ($to) ? forum_link($forum_url['pm_send_to'], $to) : ($id) ? forum_link($forum_url['pm_reply'], $id) : forum_link($forum_url['pm_send']);
$forum_page['form_attributes'] = array();

$forum_page['hidden_fields'] = array(
	'<input type="hidden" name="form_sent" value="1" />',
	'<input type="hidden" name="form_user" value="'.forum_htmlencode($forum_user['username']).'" />'
);
if ($forum_user['is_admmod'])
	$forum_page['hidden_fields']['csrf_token'] = '<input type="hidden" name="csrf_token" value="'.generate_form_token($forum_page['form_action']).'" />';

if ($id)
{
	$forum_page['hidden_fields']['first_message'] = '<input type="hidden" name="first_message" value="'.($cur_posting['first_message'] != 0 ? $cur_posting['first_message'] : $id).'" />';
	$forum_page['hidden_fields']['reply_to'] = '<input type="hidden" name="reply_to" value="'.$id.'" />';
}	

// Setup help
$forum_page['text_options'] = array();
if ($forum_config['p_message_bbcode'] == '1')
	$forum_page['text_options']['bbcode'] = '<span'.(empty($forum_page['text_options']) ? ' class="item1"' : '').'><a class="exthelp" href="'.forum_link($forum_url['help'], 'bbcode').'" title="'.sprintf($lang_common['Help page'], $lang_common['BBCode']).'">'.$lang_common['BBCode'].'</a></span>';
if ($forum_config['p_message_img_tag'] == '1')
	$forum_page['text_options']['img'] = '<span'.(empty($forum_page['text_options']) ? ' class="item1"' : '').'><a class="exthelp" href="'.forum_link($forum_url['help'], 'img').'" title="'.sprintf($lang_common['Help page'], $lang_common['Images']).'">'.$lang_common['Images'].'</a></span>';
if ($forum_config['o_smilies'] == '1')
	$forum_page['text_options']['smilies'] = '<span'.(empty($forum_page['text_options']) ? ' class="item1"' : '').'><a class="exthelp" href="'.forum_link($forum_url['help'], 'smilies').'" title="'.sprintf($lang_common['Help page'], $lang_common['Smilies']).'">'.$lang_common['Smilies'].'</a></span>';

// Setup breadcrumbs
$forum_page['crumbs'] = array(
	array($forum_config['o_board_title'], forum_link($forum_url['index'])), $lang_private_messaging['Private messaging']
);

// Setup navigation menu
$forum_page['main_menu'] = array();
$forum_page['main_menu']['compose'] = '<li class="item1 active"><a href="'.forum_link($forum_url['pm_send']).'"><span>'.$lang_private_messaging['Compose message'].'</span></a></li>';
$forum_page['main_menu']['inbox'] = '<li><a href="'.forum_link($forum_url['pm']).'"><span>'.$lang_private_messaging['Inbox'].'</span></a></li>';
$forum_page['main_menu']['sent'] = '<li><a href="'.forum_link($forum_url['pm_sent']).'"><span>'.$lang_private_messaging['Sent messages'].'</span></a></li>';
//$forum_page['main_menu']['settings'] = '<li><a href="'.forum_link($forum_url['pm_settings']).'"><span>Settings</span></a></li>';

// Setup headings
$forum_page['main_head'] = $lang_private_messaging['Private messaging'].' : '.$lang_private_messaging['Compose message'];

define('FORUM_ALLOW_INDEX', 0);
define('FORUM_PAGE', 'pm-compose');
define('FORUM_PAGE_TYPE', 'pm');

require FORUM_ROOT.'header.php';

// START SUBST - <!-- forum_main -->
ob_start();

// If preview selected and there are no errors
if (isset($_POST['preview']) && empty($errors))
{
	if (!defined('FORUM_PARSER_LOADED'))
		require FORUM_ROOT.'include/parser.php';
	$forum_page['preview_message'] = parse_message(trim($message), $hide_smilies);

?>
<div id="post-preview" class="main-content topic">
	<div class="content-head">
		<h2 class="hn"><span><?php echo forum_htmlencode($subject) ?></span></h2>
	</div>
	<div class="post firstpost">
		<div class="postbody">
			<div class="user">
				<h3 class="user-ident"><strong class="username"><?php echo $forum_user['username'] ?></strong></h3>
			</div>
			<div class="post-entry">
				<div class="entry-content">
				<?php echo $forum_page['preview_message']."\n" ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php

}

?>
<div class="main-content frm">
	<div class="content-head">
		<h2 class="hn"><span><?php echo $lang_post['Compose your'].' '.$lang_private_messaging['private message'] ?></span></h2>
	</div>
<?php

	if (!empty($forum_page['text_options']))
		echo "\t".'<p class="text-options options">'.sprintf($lang_common['You may use'], implode(' ', $forum_page['text_options'])).'</p>'."\n";

	// If there were any errors, show them
	if (!empty($errors))
	{
		$forum_page['errors'] = array();
		while (list(, $cur_error) = each($errors))
			$forum_page['errors'][] = '<li class="warn"><span>'.$cur_error.'</span></li>';

?>
	<div class="frm-error">
		<h3 class="warn"><?php echo $lang_post['Post errors'] ?></h3>
		<ul>
			<?php echo implode("\n\t\t\t\t\t", $forum_page['errors'])."\n" ?>
		</ul>
	</div>
<?php

	}

?>
	<div id="req-msg" class="req-warn">
		<p class="important"><?php printf($lang_common['Required warn'], '<em>'.$lang_common['Reqmark'].'</em>') ?></p>
	</div>
	<form id="afocus" class="frm-newform" method="post" accept-charset="utf-8" action="<?php echo $forum_page['form_action'] ?>"<?php if (!empty($forum_page['form_attributes'])) echo ' '.implode(' ', $forum_page['form_attributes']) ?>>
		<div class="hidden">
			<?php echo implode("\n\t\t\t\t", $forum_page['hidden_fields'])."\n" ?>
		</div>
		<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
			<legend class="frm-legend"><strong><?php echo $lang_post['Guest post legend'] ?></strong></legend>
			<div class="frm-text required">
				<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
					<span><em><?php echo $lang_common['Reqmark'] ?></em> <?php echo $lang_private_messaging['To:'] ?></span>
				</label><br />
				<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="req_to" value="<?php if (isset($_POST['req_to'])) echo forum_htmlencode($to); else if ($to || $id) echo $cur_posting['username']; ?>" size="35" maxlength="25" /></span>
			</div>
		</fieldset>
		<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
			<legend class="frm-legend"><strong><?php echo $lang_common['Required information'] ?></strong></legend>
			<div class="frm-text required longtext">
				<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
					<span><em><?php echo $lang_common['Reqmark'] ?></em> <?php echo $lang_private_messaging['Message subject:'] ?></span>
				</label><br />
				<span class="fld-input"><input id="fld<?php echo $forum_page['fld_count'] ?>" type="text" name="req_subject" value="<?php if (isset($_POST['req_subject'])) echo forum_htmlencode($subject); else if ($id) echo 'Re: '.forum_htmlencode($cur_posting['subject']); ?>" size="80" maxlength="70" /></span>
			</div>
			<div class="frm-textarea required">
				<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
					<span><em><?php echo $lang_common['Reqmark'] ?></em> <?php echo $lang_post['Write message'] ?></span>
				</label><br />
				<span class="fld-input"><textarea id="fld<?php echo $forum_page['fld_count'] ?>" name="req_message" rows="14" cols="95"><?php if (isset($_POST['req_message'])) echo forum_htmlencode($message); else if ($id && !$disable_quote) echo forum_htmlencode($forum_page['quote']); ?></textarea></span><br />
			</div>
		</fieldset>
<?php

$forum_page['checkboxes'] = array();
if ($forum_config['o_smilies'] == '1')
	$forum_page['checkboxes']['hide_smilies'] = '<div class="frm-radbox"><input type="checkbox" id="fld'.(++$forum_page['fld_count']).'" name="hide_smilies" value="1"'.(isset($_POST['hide_smilies']) ? ' checked="checked"' : '').' /> <label for="fld'.$forum_page['fld_count'].'">'.$lang_post['Hide smilies'].'</label></div>';

if (!empty($forum_page['checkboxes']))
{

?>
		<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
			<legend class="frm-legend"><strong><?php echo $lang_post['Optional legend'] ?></strong></legend>
			<fieldset class="frm-group">
				<legend><span><?php echo $lang_post['Post settings'] ?></span></legend>
				<?php echo implode("\n\t\t\t\t\t", $forum_page['checkboxes'])."\n"; ?>
			</fieldset>
		</fieldset>
<?php

}

?>
		<div class="frm-buttons">
			<span class="submit"><input type="submit" name="submit" value="<?php echo $lang_common['Submit'] ?>" /></span>
			<span class="submit"><input type="submit" name="preview" value="<?php echo $lang_common['Preview'] ?>" /></span>
		</div>
	</form>
</div>

<?php

$tpl_temp = trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->

require FORUM_ROOT.'footer.php';
