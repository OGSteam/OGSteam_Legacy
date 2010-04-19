<?php
/***********************************************************************

	FluxBB extension
	Portal
	Daris <daris91@gmail.com>

************************************************************************/


if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', '../../../');

define('FORUM_PORTAL_DIR', '../');

require FORUM_ROOT.'include/common.php';
require FORUM_ROOT.'include/common_admin.php';

($hook = get_hook('xn_portal_by_daris_apg_start')) ? eval($hook) : null;

if ($forum_user['g_id'] != FORUM_ADMIN)
	message($lang_common['No permission']);

// Load the admin.php language file
require FORUM_ROOT.'lang/'.$forum_user['language'].'/admin.php';

if (file_exists(FORUM_PORTAL_DIR.'lang/'.$forum_user['language'].'/portal.php'))
	require FORUM_PORTAL_DIR.'lang/'.$forum_user['language'].'/portal.php';
else
	require FORUM_PORTAL_DIR.'lang/English/portal.php';


// Add a "default" page
if (isset($_POST['add_page']))
{

	$title = trim($_POST['title']);

	($hook = get_hook('xn_portal_by_daris_apg_add_forum_form_submitted')) ? eval($hook) : null;

	$query = array(
		'INSERT'	=> 'title, content',
		'INTO'		=> 'pages',
		'VALUES'	=> '\''.$forum_db->escape($title).'\', \'\''
	);

	($hook = get_hook('xn_portal_by_daris_apg_qr_add_page')) ? eval($hook) : null;
	$forum_db->query_build($query) or error(__FILE__, __LINE__);


	redirect(forum_link($forum_url['admin_pages']), $lang_portal['Page added'].' '.$lang_admin['Redirect']);
}


// Delete a page
else if (isset($_GET['del_page']))
{
	$page_to_delete = intval($_GET['del_page']);
	if ($page_to_delete < 1)
		message($lang_common['Bad request']);


	// User pressed the cancel button
	if (isset($_POST['del_page_cancel']))
		redirect(forum_link($forum_url['admin_pages']), $lang_admin['Cancel redirect']);


	if (isset($_POST['del_page_comply']))	// Delete a page
	{
		($hook = get_hook('xn_portal_by_daris_apg_del_page_form_submitted')) ? eval($hook) : null;

		// Delete the page
		$query = array(
			'DELETE'	=> 'pages',
			'WHERE'		=> 'id='.$page_to_delete
		);

		($hook = get_hook('xn_portal_by_daris_apg_qr_delete_page')) ? eval($hook) : null;
		$forum_db->query_build($query) or error(__FILE__, __LINE__);

		redirect(forum_link($forum_url['admin_pages']), $lang_portal['Page deleted'].' '.$lang_admin['Redirect']);

	}
	else	// If the user hasn't confirmed the delete
	{
		$query = array(
			'SELECT'	=> 'pg.title',
			'FROM'		=> 'pages AS pg',
			'WHERE'		=> 'pg.id='.$page_to_delete
		);

		($hook = get_hook('xn_portal_by_daris_apg_qr_get_page_name')) ? eval($hook) : null;
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		$page_name = $forum_db->result($result);


		// Setup breadcrumbs
		$forum_page['crumbs'] = array(
			array($forum_config['o_board_title'], forum_link($forum_url['index'])),
			array($lang_admin['Forum administration'], forum_link($forum_url['admin_index'])),
			array($lang_portal['Pages'], forum_link($forum_url['admin_pages'])),
			$lang_portal['Delete page']
		);

		($hook = get_hook('xn_portal_by_daris_apg_del_page_pre_header_load')) ? eval($hook) : null;

		define('FORUM_PAGE_SECTION', 'start');
		define('FORUM_PAGE', 'admin-pages');
		require FORUM_ROOT.'header.php';
		
		ob_start();

?>
<div id="pun-main" class="main sectioned admin">

<?php echo generate_admin_menu(); ?>

	<div class="main-head">
		<h1><span>{ <?php echo end($forum_page['crumbs']) ?> }</span></h1>
	</div>

	<div class="main-content frm">
		<div class="frm-head">
			<h2><span><?php printf($lang_portal['Confirm delete page'], forum_htmlencode($page_name)) ?></span></h2>
		</div>
		<form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link($forum_url['admin_pages']) ?>?del_page=<?php echo $page_to_delete ?>">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link($forum_url['admin_pages']).'?del_page='.$page_to_delete) ?>" />
			</div>
			<div class="frm-info">
				<p class="warn"><?php echo $lang_portal['Delete page warning'] ?></p>
			</div>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" name="del_page_comply" value="<?php echo $lang_admin['Delete'] ?>" /></span>
				<span class="cancel"><input type="submit" name="del_page_cancel" value="<?php echo $lang_admin['Cancel'] ?>" /></span>
			</div>
		</form>
	</div>

</div>
<?php

		$tpl_temp = trim(ob_get_contents());
		$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
		ob_end_clean();
		// END SUBST - <!-- forum_main -->

		require FORUM_ROOT.'footer.php';
	}

}


// Update pages positions
else if (isset($_POST['update_positions']))
{
	$positions = array_map('intval', $_POST['position']);

	($hook = get_hook('xn_portal_by_daris_apg_update_positions_form_submitted')) ? eval($hook) : null;

	$query = array(
		'SELECT'	=> 'pg.id, pg.position',
		'FROM'		=> 'pages AS pg',
		'ORDER BY'	=> 'pg.position'
	);

	($hook = get_hook('xn_portal_by_daris_apg_qr_get_pages')) ? eval($hook) : null;
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	while ($cur_page = $forum_db->fetch_assoc($result))
	{
		// If these aren't set, we're looking at a forum that was added after
		// the admin started editing: we don't want to mess with it
		if (isset($positions[$cur_page['id']]))
		{
			$new_disp_position = $positions[$cur_page['id']];

			if ($new_disp_position < -1)
				message($lang_admin['Must be integer']);

			// We only want to update if we changed the position
			if ($cur_page['position'] != $new_disp_position)
			{
				$query = array(
					'UPDATE'	=> 'pages',
					'SET'		=> 'position='.$new_disp_position,
					'WHERE'		=> 'id='.$cur_page['id']
				);

				($hook = get_hook('xn_portal_by_daris_apg_qr_update_page_position')) ? eval($hook) : null;
				$forum_db->query_build($query) or error(__FILE__, __LINE__);
			}
		}
	}

	redirect(forum_link($forum_url['admin_pages']), $lang_portal['Pages updated'].' '.$lang_admin['Redirect']);
}

else if (isset($_GET['edit_page']) || isset($_GET['add_page']))
{
	$edit = isset($_GET['edit_page']);

	if ($edit) {
		$page_id = intval($_GET['edit_page']);
		if ($page_id < 1)
			message($lang_common['Bad request']);
	}

	// Update page
	if (isset($_POST['save']))
	{
		($hook = get_hook('xn_portal_by_daris_apg_save_page_form_submitted')) ? eval($hook) : null;

		// Start with the forum details
		$title = trim($_POST['title']);
		$content = forum_linebreaks(trim($_POST['content']));

		if ($content == '')
			message($lang_portal['Page content empty']);

		if ($title == '')
			message($lang_portal['Page title empty']);


		if ($edit)
			$query = array(
				'UPDATE'	=> 'pages',
				'SET'		=> 'title=\''.$forum_db->escape($title).'\', content=\''.$forum_db->escape($content).'\'',
				'WHERE'		=> 'id='.$page_id
			);
		else
			$query = array(
				'INSERT'	=> 'title, content',
				'INTO'		=> 'pages',
				'VALUES'	=> '\''.$forum_db->escape($title).'\', \''.$forum_db->escape($content).'\''
			);

		($hook = get_hook('xn_portal_by_daris_apg_qr_update_page')) ? eval($hook) : null;
		$forum_db->query_build($query) or error(__FILE__, __LINE__);


		redirect(forum_link($forum_url['admin_pages']), $lang_portal['Page updated'].' '.$lang_admin['Redirect']);
	}

	if ($edit)
	{
		// Fetch page info
		$query = array(
			'SELECT'	=> 'pg.id, pg.title, pg.content',
			'FROM'		=> 'pages AS pg',
			'WHERE'		=> 'pg.id='.$page_id
		);

		($hook = get_hook('xn_portal_by_daris_apg_ qr_get_page_details')) ? eval($hook) : null;
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		if (!$forum_db->num_rows($result))
			message($lang_common['Bad request']);

		$cur_page = $forum_db->fetch_assoc($result);
	}
	else
		$cur_page = array('title' => '', 'content' => '');


	$action_str = ($edit ? 'Edit' : 'Add');

	$forum_page['form_info'] = array();

	// Setup the form
	$forum_page['part_count'] = $forum_page['set_count'] = $forum_page['fld_count'] = 0;

	// Setup breadcrumbs
	$forum_page['crumbs'] = array(
		array($forum_config['o_board_title'], forum_link($forum_url['index'])),
		array($lang_admin['Forum administration'], forum_link($forum_url['admin_index'])),
		array($lang_portal['Pages'], forum_link($forum_url['admin_pages'])),
		$lang_portal[$action_str.' page']
	);

	($hook = get_hook('xn_portal_by_daris_apg_edit_page_pre_header_load')) ? eval($hook) : null;

	define('FORUM_PAGE_SECTION', 'start');
	define('FORUM_PAGE', 'admin-pages');
	require FORUM_ROOT.'header.php';

	ob_start();

?>
<div id="pun-main" class="main sectioned admin">

<?php echo generate_admin_menu(); ?>

	<div class="main-head">
		<h1><span>{ <?php echo end($forum_page['crumbs']) ?> }</span></h1>
	</div>

	<form method="post" accept-charset="utf-8" action="<?php echo forum_link($forum_url['admin_pages']) .'?'.strtolower($action_str).'_page='. ($edit ? $page_id : '') ?>">

	<div class="main-content frm parted">
		<div class="hidden">
			<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link($forum_url['admin_pages']).'?'.strtolower($action_str).'_page='. ($edit ? $page_id : '')) ?>" />
		</div>
		<div class="frm-head">
			<h2><span><?php echo $lang_portal[$action_str.' page head'] ?></span></h2>
		</div>
		<div class="frm-form">
<?php ($hook = get_hook('xn_portal_by_daris_apg_ edit_forum_pre_details_part')) ? eval($hook) : null; ?>
			<div class="frm-part part<?php echo ++ $forum_page['part_count'] ?>">
				<h3><span><?php printf($lang_portal[$action_str.' page head'], $forum_page['part_count']) ?></span></h3>
				<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
					<legend class="frm-legend"><strong><?php echo $lang_portal[$action_str.' page details legend'] ?></strong></legend>
					<div class="frm-fld text">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['Page title'] ?></span><br />
							<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="title" size="35" maxlength="80" value="<?php echo forum_htmlencode($cur_page['title']) ?>" /></span>
						</label>
					</div>
					<div class="frm-fld text textarea">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['Page content'] ?></span><br />
							<span class="fld-input"><textarea id="fld<?php echo $forum_page['fld_count'] ?>" name="content" rows="10" cols="50"><?php echo forum_htmlencode($cur_page['content']) ?></textarea></span>
							<span class="fld-help"><?php echo $lang_portal['Page description help'] ?></span>
						</label>
					</div>
				</fieldset>
			</div>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" name="save" value="<?php echo ($edit ? $lang_admin['Save changes'] : $lang_portal['Add page']) ?>" /></span>
			</div>
		</div>
	</div>
	</form>

</div>

<?php
	
	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
	ob_end_clean();
	// END SUBST - <!-- forum_main -->
	
	require FORUM_ROOT.'footer.php';
}

// Setup the form
$forum_page['fld_count'] = $forum_page['set_count'] = 0;

// Setup breadcrumbs
$forum_page['crumbs'] = array(
	array($forum_config['o_board_title'], forum_link($forum_url['index'])),
	array($lang_admin['Forum administration'], forum_link($forum_url['admin_index'])),
	$lang_portal['Pages']
);

($hook = get_hook('xn_portal_by_daris_apg_pre_header_load')) ? eval($hook) : null;

define('FORUM_PAGE_SECTION', 'start');
define('FORUM_PAGE', 'admin-pages');
require FORUM_ROOT.'header.php';

ob_start();

?>
<div id="pun-main" class="main sectioned admin">

<?php echo generate_admin_menu(); ?>

	<div class="main-head">
		<h1><span>{ <?php echo end($forum_page['crumbs']) ?> }</span></h1>
	</div>

<?php

// Display all the pages
$query = array(
	'SELECT'	=> 'pg.id, pg.title, pg.content, pg.position',
	'FROM'		=> 'pages AS pg',
	'ORDER BY'	=> 'pg.position'
);

($hook = get_hook('xn_portal_by_daris_apg_qr_get_pages')) ? eval($hook) : null;
$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);


	// Reset fieldset counter
	$forum_page['set_count'] = 0;

?>
	<div class="main-content frm">
		<div class="frm-head">
			<h2><span><?php echo $lang_portal['Manage pages head'] ?></span></h2>
		</div>
		<form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link($forum_url['admin_pages']) ?>">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link($forum_url['admin_pages'])) ?>" />
			</div>
			<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
<?php
if ($forum_db->num_rows($result))
{
	while ($cur_page = $forum_db->fetch_assoc($result))
	{
?>
				<div class="frm-fld text twin">
					<span class="fld-label"><a href="<?php echo forum_link($forum_url['admin_pages']) ?>?edit_page=<?php echo $cur_page['id'] ?>"><span><?php echo $lang_admin['Edit'].'<span> '.forum_htmlencode($cur_page['title']).' </span></span>' ?></a><br /> <a href="<?php echo forum_link($forum_url['admin_pages']) ?>?del_page=<?php echo $cur_page['id'] ?>"><span><?php echo $lang_admin['Delete'].'<span> '.forum_htmlencode($cur_page['title']).'</span></span>' ?></a></span><br />
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>" class="twin2">
						<span class="fld-label"><?php echo $lang_admin['Position'] ?></span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="position[<?php echo $cur_page['id'] ?>]" size="3" maxlength="3" value="<?php echo $cur_page['position'] ?>" /></span>
						<span class="fld-extra"><a href="<?php echo forum_link($forum_url['page_id'], array($cur_page['id'], sef_friendly(forum_htmlencode($cur_page['title'])))) ?>"><?php echo forum_htmlencode($cur_page['title']) ?></a></span>
					</label>
				</div>

<?php

	}

?>
				<div class="frm-fld text twin">
					<span class="fld-label"></span>
					<span class="submit"><input type="submit" class="button" name="update_positions" value="<?php echo $lang_admin['Update positions'] ?>" /></span>
				</div>
<?php

} else {

?>
				<div class="frm-fld text twin">
					<label class="twin2">
						<span><?php echo $lang_portal['No pages'] ?></span>
					</label>
				</div>

<?php

}

?>
			</fieldset>

		</form>
		<form class="frm-form" method="get" accept-charset="utf-8" action="<?php echo forum_link($forum_url['admin_pages']) ?>">
			<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
				<div class="frm-fld text twin">
					<span class="fld-label"></span>
					<span class="submit"><input type="submit" class="button" name="add_page" value="<?php echo $lang_portal['Add page'] ?>" /></span>
				</div>
			</fieldset>
		</form>
	</div>
<?php



?>

</div>
<?php


$tpl_temp = trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->

require FORUM_ROOT.'footer.php';
