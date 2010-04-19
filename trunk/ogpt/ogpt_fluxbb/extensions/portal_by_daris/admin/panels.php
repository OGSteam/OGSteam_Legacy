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

($hook = get_hook('xn_portal_by_daris_apn_start')) ? eval($hook) : null;

if ($forum_user['g_id'] != FORUM_ADMIN)
	message($lang_common['No permission']);

// Load the admin.php language file
require FORUM_ROOT.'lang/'.$forum_user['language'].'/admin.php';

if (file_exists(FORUM_PORTAL_DIR.'lang/'.$forum_user['language'].'/portal.php'))
	require FORUM_PORTAL_DIR.'lang/'.$forum_user['language'].'/portal.php';
else
	require FORUM_PORTAL_DIR.'lang/English/portal.php';


// Add a "default" panel
if (isset($_POST['add_panel']))
{
	$title = trim($_POST['title']);
	$position = intval($_POST['position']);
	$file = $_POST['file'];
	$side = intval($_POST['side']);

	// position 0 for center side is registered for page content
	if ($side == 1 && $position == 0)
		$position = 1;

	// security - directory travesal
	if (strpos($file, '../') !== false)
		message($lang_common['Bad request']);

	($hook = get_hook('xn_portal_by_daris_apn_add_panel_form_submitted')) ? eval($hook) : null;

	$query = array(
		'INSERT'	=> 'position, title, content, file, side, enable',
		'INTO'		=> 'panels',
		'VALUES'	=> $position.', \''.$forum_db->escape($title).'\', \'\', \''.$forum_db->escape($file).'\', '.$side.', 1'
	);

	($hook = get_hook('xn_portal_by_daris_apn_qr_add_panel')) ? eval($hook) : null;
	$forum_db->query_build($query) or error(__FILE__, __LINE__);

	// Regenerate the panels cache
	require_once FORUM_PORTAL_DIR.'include/cache.php';
	generate_panels_cache();

	redirect(forum_link($forum_url['admin_panels']), $lang_portal['Panel added'].' '.$lang_admin['Redirect']);
}

// Delete a panel
else if (isset($_GET['del_panel']))
{
	$panel_to_delete = intval($_GET['del_panel']);
	if ($panel_to_delete < 1)
		message($lang_common['Bad request']);


	// User pressed the cancel button
	if (isset($_POST['del_panel_cancel']))
		redirect(forum_link($forum_url['admin_panels']), $lang_admin['Cancel redirect']);


	if (isset($_POST['del_panel_comply']))	// Delete a panel
	{

		($hook = get_hook('xn_portal_by_daris_apn_del_panel_form_submitted')) ? eval($hook) : null;

		// Delete the panel
		$query = array(
			'DELETE'	=> 'panels',
			'WHERE'		=> 'id='.$panel_to_delete
		);

		($hook = get_hook('xn_portal_by_daris_apn_qr_delete_panel')) ? eval($hook) : null;
		$forum_db->query_build($query) or error(__FILE__, __LINE__);

		// Regenerate the panels cache
		require_once FORUM_PORTAL_DIR.'include/cache.php';
		generate_panels_cache();

		redirect(forum_link($forum_url['admin_panels']), $lang_portal['Panel deleted'].' '.$lang_admin['Redirect']);
	}
	else	// If the user hasn't confirmed the delete
	{
		$query = array(
			'SELECT'	=> 'pn.title',
			'FROM'		=> 'panels AS pn',
			'WHERE'		=> 'pn.id='.$panel_to_delete
		);

		($hook = get_hook('xn_portal_by_daris_apn_qr_get_panel_name')) ? eval($hook) : null;
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		$page_name = $forum_db->result($result);


		// Setup breadcrumbs
		$forum_page['crumbs'] = array(
			array($forum_config['o_board_title'], forum_link($forum_url['index'])),
			array($lang_admin['Forum administration'], forum_link($forum_url['admin_index'])),
			array($lang_portal['Panels'], forum_link($forum_url['admin_panels'])),
			$lang_portal['Delete panel']
		);

		($hook = get_hook('xn_portal_by_daris_apn_del_panel_pre_header_load')) ? eval($hook) : null;

		define('FORUM_PAGE_SECTION', 'start');
		define('FORUM_PAGE', 'admin-panels');
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
			<h2><span><?php printf($lang_portal['Confirm delete panel'], forum_htmlencode($page_name)) ?></span></h2>
		</div>
		<form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link($forum_url['admin_panels']) ?>?del_panel=<?php echo $panel_to_delete ?>">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link($forum_url['admin_panels']).'?del_panel='.$panel_to_delete) ?>" />
			</div>
			<div class="frm-info">
				<p class="warn"><?php echo $lang_portal['Delete panel warning'] ?></p>
			</div>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" name="del_panel_comply" value="<?php echo $lang_admin['Delete'] ?>" /></span>
				<span class="cancel"><input type="submit" name="del_panel_cancel" value="<?php echo $lang_admin['Cancel'] ?>" /></span>
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

// Move panel
else if (isset($_GET['move']) && isset($_GET['side']))
{
	$panel_to_move = intval($_GET['move']);
	$side = intval($_GET['side']);

	if ($panel_to_move < 1 || $side < 0 || $side > 2)
		message($lang_common['Bad request']);

	$query = array(
		'UPDATE'	=> 'panels',
		'SET'		=> 'side='.$side,
		'WHERE'		=> 'id='.$panel_to_move
	);

	($hook = get_hook('xn_portal_by_daris_apn_qr_update_panel_side')) ? eval($hook) : null;
	$forum_db->query_build($query) or error(__FILE__, __LINE__);

	// Regenerate the panels cache
	require_once FORUM_PORTAL_DIR.'include/cache.php';
	generate_panels_cache();

	redirect(forum_link($forum_url['admin_panels']), $lang_portal['Panel moved'].' '.$lang_admin['Redirect']);
}

// Enable/disable panel
else if (isset($_GET['state']) && isset($_GET['panel']))
{
	$state = intval($_GET['state']);
	$panel = intval($_GET['panel']);

	if ($panel < 1 || $state < 0 || $state > 1)
		message($lang_common['Bad request']);

	$query = array(
		'UPDATE'	=> 'panels',
		'SET'		=> 'enable='.$state,
		'WHERE'		=> 'id='.$panel
	);

	($hook = get_hook('xn_portal_by_daris_apn_qr_update_panel_state')) ? eval($hook) : null;
	$forum_db->query_build($query) or error(__FILE__, __LINE__);

	// Regenerate the panels cache
	require_once FORUM_PORTAL_DIR.'include/cache.php';
	generate_panels_cache();

	redirect(forum_link($forum_url['admin_panels']), ($state == 1 ? $lang_portal['Panel enabled'] : $lang_portal['Panel disabled']).' '.$lang_admin['Redirect']);
}

// Update forum positions
else if (isset($_POST['update_positions']))
{
	$positions = array_map('intval', $_POST['position']);

	($hook = get_hook('xn_portal_by_daris_apn_update_positions_form_submitted')) ? eval($hook) : null;

	$query = array(
		'SELECT'	=> 'p.id, p.position',
		'FROM'		=> 'panels AS p',
		'ORDER BY'	=> 'p.position'
	);

	($hook = get_hook('xn_portal_by_daris_apn_qr_get_panels')) ? eval($hook) : null;
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	while ($cur_panel = $forum_db->fetch_assoc($result))
	{
		// If these aren't set, we're looking at a forum that was added after
		// the admin started editing: we don't want to mess with it
		if (isset($positions[$cur_panel['id']]))
		{
			$new_disp_position = $positions[$cur_panel['id']];

// 			if ($new_disp_position < 0)
// 				message($lang_admin['Must be integer']);

			// We only want to update if we changed the position
			if ($cur_panel['position'] != $new_disp_position)
			{
				$query = array(
					'UPDATE'	=> 'panels',
					'SET'		=> 'position='.$new_disp_position,
					'WHERE'		=> 'id='.$cur_panel['id']
				);

				($hook = get_hook('xn_portal_by_daris_apn_qr_update_panel_position')) ? eval($hook) : null;
				$forum_db->query_build($query) or error(__FILE__, __LINE__);
			}
		}
	}

	// Regenerate the panels cache
	require_once FORUM_PORTAL_DIR.'include/cache.php';
	generate_panels_cache();

	redirect(forum_link($forum_url['admin_panels']), $lang_portal['Panels updated'].' '.$lang_admin['Redirect']);
}

else if (isset($_GET['edit_panel']))
{
	$panel_id = intval($_GET['edit_panel']);
	if ($panel_id < 1)
		message($lang_common['Bad request']);

	// Update panel
	if (isset($_POST['save']))
	{
		($hook = get_hook('xn_portal_by_daris_apn_save_panel_form_submitted')) ? eval($hook) : null;

		$title = trim($_POST['title']);
		$content = forum_linebreaks(trim($_POST['content']));
		$file = trim($_POST['file']);

		// security - directory travesal
		if (strpos($file, '../') !== false)
			message($lang_common['Bad request']);

		$query = array(
			'UPDATE'	=> 'panels',
			'SET'		=> 'title=\''.$forum_db->escape($title).'\', content=\''.$forum_db->escape($content).'\', file=\''.$forum_db->escape($file).'\'',
			'WHERE'		=> 'id='.$panel_id
		);

		($hook = get_hook('xn_portal_by_daris_apn_qr_update_panel')) ? eval($hook) : null;
		$forum_db->query_build($query) or error(__FILE__, __LINE__);

		// Regenerate the panels cache
		require_once FORUM_PORTAL_DIR.'include/cache.php';
		generate_panels_cache();

		redirect(forum_link($forum_url['admin_panels']), $lang_portal['Panel updated'].' '.$lang_admin['Redirect']);
	}

	// Fetch panel info
	$query = array(
		'SELECT'	=> 'pn.id, pn.title, pn.content, pn.file',
		'FROM'		=> 'panels AS pn',
		'WHERE'		=> 'pn.id='.$panel_id
	);

	($hook = get_hook('xn_portal_by_daris_apn_qr_get_panel_details')) ? eval($hook) : null;
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	if (!$forum_db->num_rows($result))
		message($lang_common['Bad request']);

	$cur_panel = $forum_db->fetch_assoc($result);
	
	// Fetch enabled extensions
	$query = array(
		'SELECT'	=> 'e.id',
		'FROM'		=> 'extensions AS e',
		'WHERE'		=> 'e.disabled=0'
	);

	($hook = get_hook('xn_portal_by_daris_apn_qr_get_panel_details')) ? eval($hook) : null;
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

	$enabled_extensions = array();

	while ($cur_extension = $forum_db->fetch_assoc($result))
		$enabled_extensions[] = $cur_extension['id'];

	$forum_page['form_info'] = array();

	// Setup the form
	$forum_page['part_count'] = $forum_page['set_count'] = $forum_page['fld_count'] = 0;

	// Setup breadcrumbs
	$forum_page['crumbs'] = array(
		array($forum_config['o_board_title'], forum_link($forum_url['index'])),
		array($lang_admin['Forum administration'], forum_link($forum_url['admin_index'])),
		array($lang_portal['Panels'], forum_link($forum_url['admin_panels'])),
		$lang_portal['Edit panel']
	);

	($hook = get_hook('xn_portal_by_daris_apn_edit_panel_pre_header_load')) ? eval($hook) : null;

	define('FORUM_PAGE_SECTION', 'start');
	define('FORUM_PAGE', 'admin-panels');
	require FORUM_ROOT.'header.php';

	ob_start();
	
?>
<div id="pun-main" class="main sectioned admin">

<?php echo generate_admin_menu(); ?>

	<div class="main-head">
		<h1><span>{ <?php echo end($forum_page['crumbs']) ?> }</span></h1>
	</div>

	<form method="post" accept-charset="utf-8" action="<?php echo forum_link($forum_url['admin_panels']) ?>?edit_panel=<?php echo $panel_id ?>">

	<div class="main-content frm parted">
		<div class="hidden">
			<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link($forum_url['admin_panels']).'?edit_panel='.$panel_id) ?>" />
		</div>
		<div class="frm-head">
			<h2><span><?php echo $lang_portal['Edit panel head'] ?></span></h2>
		</div>
		<div class="frm-form">
<?php ($hook = get_hook('xn_portal_by_daris_apn_edit_forum_pre_details_part')) ? eval($hook) : null; ?>
			<div class="frm-part part<?php echo ++ $forum_page['part_count'] ?>">
				<h3><span><?php printf($lang_portal['Edit panel head'], $forum_page['part_count']) ?></span></h3>
				<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
					<legend class="frm-legend"><strong><?php echo $lang_portal['Edit panel details legend'] ?></strong></legend>
					<div class="frm-fld text">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['Panel name'] ?></span><br />
							<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="title" size="35" maxlength="80" value="<?php echo forum_htmlencode($cur_panel['title']) ?>" /></span>
						</label>
					</div>
					<div class="frm-fld select">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['Panel file'] ?></span><br />
							<span class="fld-input"><select id="fld<?php echo $forum_page['fld_count'] ?>" name="file">
								<option value=""><?php echo $lang_portal['None'] ?></option>
<?php
	$dir = dir(FORUM_ROOT.'extensions');
	$last_extension = '';
	
	// Go through extension directory
	while ($cur_extension = $dir->read())
	{
		$panels_dir = FORUM_ROOT.'extensions/'.$cur_extension.'/panels';
		
		// Search panels directory in current extension folder
		if (file_exists($panels_dir) && is_dir($panels_dir))
		{
			$ext_dir = dir($panels_dir);
			
			// Get all panels
			while ($file = $ext_dir->read())
			{
				if (substr(strtolower($file), strlen($file) - 4) == '.php' && substr($file, 0, 1) != '.')
				{
					 // A new extension since last iteration?
					if ($last_extension != $cur_extension)
					{
						$new_extension_name = forum_htmlencode(ucfirst(str_replace('_', ' ', $cur_extension)));
						$new_extension_name .= (!in_array($cur_extension, $enabled_extensions) ? ' '.$lang_portal['Disabled'] : '');
						
						echo ($last_extension != '' ? "\n\t\t\t\t\t\t\t\t".'</optgroup>' : '') . "\n\t\t\t\t\t\t\t\t".'<optgroup label="'.$new_extension_name.'">';
					}
					
					$ext_file = $cur_extension.'/panels/'.$file;
					$ext_name = forum_htmlencode(ucfirst(str_replace('_', ' ', substr($file, 0, strrpos($file, '.')))));
					
					echo "\n\t\t\t\t\t\t\t\t\t".'<option value="'.$ext_file.'"'.($cur_panel['file'] == $ext_file ? ' selected="selected"' : '').'>'.$ext_name.'</option>';
					
					$last_extension = $cur_extension;
				}
	
			}
			$ext_dir->close();
		}
	}
	$dir->close();
?>

								</optgroup>
							</select></span>
						</label>
					</div>
					<div class="frm-fld text textarea">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['Panel content'] ?></span><br />
							<span class="fld-input"><textarea id="fld<?php echo $forum_page['fld_count'] ?>" name="content" rows="10" cols="50"><?php echo forum_htmlencode($cur_panel['content']) ?></textarea></span>
							<span class="fld-help"><?php echo $lang_portal['Panel content help'] ?></span><br />
						</label>
					</div>
				</fieldset>
			</div>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" name="save" value="<?php echo $lang_admin['Save changes'] ?>" /></span>
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

// Fetch enabled extensions
$query = array(
	'SELECT'	=> 'e.id',
	'FROM'		=> 'extensions AS e',
	'WHERE'		=> 'e.disabled=0'
);

($hook = get_hook('xn_portal_by_daris_apn_qr_get_panel_details')) ? eval($hook) : null;
$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

$enabled_extensions = array();

while ($cur_extension = $forum_db->fetch_assoc($result))
	$enabled_extensions[] = $cur_extension['id'];


// Setup the form
$forum_page['fld_count'] = $forum_page['set_count'] = 0;

// Setup breadcrumbs
$forum_page['crumbs'] = array(
	array($forum_config['o_board_title'], forum_link($forum_url['index'])),
	array($lang_admin['Forum administration'], forum_link($forum_url['admin_index'])),
	$lang_portal['Panels']
);

($hook = get_hook('xn_portal_by_daris_apn_pre_header_load')) ? eval($hook) : null;

define('FORUM_PAGE_SECTION', 'start');
define('FORUM_PAGE', 'admin-panels');
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
			<h2><span><?php echo $lang_portal['Add panel head'] ?></span></h2>
		</div>
		<form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link($forum_url['admin_panels']) ?>?action=adddel">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link($forum_url['admin_panels']).'?action=adddel') ?>" />
			</div>
			<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
				<legend class="frm-legend"><strong><?php echo $lang_portal['Add panel legend'] ?></strong></legend>
				<div class="frm-fld text">
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label"><?php echo $lang_portal['Panel name'] ?></span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="title" size="35" maxlength="80" /></span>
					</label>
				</div>
				<div class="frm-fld text">
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label"><?php echo $lang_admin['Position'] ?></span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="position" size="3" maxlength="3" /></span>
					</label>
				</div>
				<div class="frm-fld select">
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label"><?php echo $lang_portal['Panel side'] ?></span><br />
						<span class="fld-input"><select id="fld<?php echo $forum_page['fld_count'] ?>" name="side">
							<option value="0"><?php echo $lang_portal['Left side'] ?></option>
							<option value="1"><?php echo $lang_portal['Center'] ?></option>
							<option value="2"><?php echo $lang_portal['Right side'] ?></option>
						</select></span>
					</label>
				</div>
				<div class="frm-fld select">
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
						<span class="fld-label"><?php echo $lang_portal['Panel file'] ?></span><br />
						<span class="fld-input"><select id="fld<?php echo $forum_page['fld_count'] ?>" name="file">
							<option value=""><?php echo $lang_portal['None'] ?></option>
<?php

$dir = dir(FORUM_ROOT.'extensions');
$last_extension = '';

// Go through extension directory
while ($cur_extension = $dir->read())
{
	$panels_dir = FORUM_ROOT.'extensions/'.$cur_extension.'/panels';
	
	// Search panels directory in current extension folder
	if (file_exists($panels_dir) && is_dir($panels_dir))
	{
		$ext_dir = dir($panels_dir);
		
		// Get all panels
		while ($file = $ext_dir->read())
		{
			if (substr(strtolower($file), strlen($file) - 4) == '.php' && substr($file, 0, 1) != '.')
			{
				// A new extension since last iteration?
				if ($last_extension != $cur_extension)
				{
					$new_extension_name = forum_htmlencode(ucfirst(str_replace('_', ' ', $cur_extension)));
					$new_extension_name .= (!in_array($cur_extension, $enabled_extensions) ? ' '.$lang_portal['Disabled'] : '');
					
					echo ($last_extension != '' ? "\n\t\t\t\t\t\t\t\t".'</optgroup>' : '') . "\n\t\t\t\t\t\t\t\t".'<optgroup label="'.$new_extension_name.'">';
				}
				
				$ext_name = forum_htmlencode(ucfirst(str_replace('_', ' ', substr($file, 0, strrpos($file, '.')))));
				
				echo "\n\t\t\t\t\t\t\t\t\t".'<option value="'.$cur_extension.'/panels/'.$file.'">'.$ext_name.'</option>';
				
				$last_extension = $cur_extension;
			}

		}
		$ext_dir->close();
	}
}
$dir->close();

?>

							</optgroup>
						</select></span>
					</label>
				</div>
			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" class="button" name="add_panel" value=" <?php echo $lang_portal['Add panel'] ?> " /></span>
			</div>
		</form>
	</div>

<?php

// Display all the panels
$query = array(
	'SELECT'	=> 'pn.id, pn.title, pn.content, pn.position, pn.side, pn.enable, pn.file',
	'FROM'		=> 'panels AS pn',
	'ORDER BY'	=> 'pn.side, pn.position'
);

($hook = get_hook('xn_portal_by_daris_apn_qr_get_panels')) ? eval($hook) : null;
$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

// If there are some panels
if ($forum_db->num_rows($result))
{
	// Reset fieldset counter
	$forum_page['set_count'] = 0;
	$forum_page['cur_side'] = -1;

?>
	<div class="main-content frm">
		<div class="frm-head">
			<h2><span><?php echo $lang_portal['Edit panels head'] ?></span></h2>
		</div>
		<form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link($forum_url['admin_panels']) ?>?action=edit">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link($forum_url['admin_panels']).'?action=edit') ?>" />
			</div>
			<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
<?php

	$side_names = array(0 => 'Left side', 1 => 'Center', 2 => 'Right side');
	$main_content_showed = false;
	
	$sides = array(0 => array(), 1 => array(), 2 => array());

	while ($cur_panel = $forum_db->fetch_assoc($result))
	{
		$sides[$cur_panel['side']][] = $cur_panel;
	}
	
	
	ob_start();
?>
				<div class="frm-fld text twin">
					<span class="fld-label"></span>
					<label for="fld-page-content" class="twin2">
						<span class="fld-label"><?php echo $lang_admin['Position'] ?></span><br />
						<span class="fld-input"><input type="text" disabled="disabled"  size="3" maxlength="3" value="0" /></span>
						<span class="fld-extra"><?php echo $lang_portal['Page content'] ?></span>
					</label>
				</div>
<?php
	$page_content = ob_get_contents();
	ob_end_clean();

	foreach ($sides as $side => $panels)
	{

		if ($side == 2 && !$main_content_showed)
		{
			$main_content_showed = true;
			echo $page_content;
		}
?>
				<div class="frm-fld text twin">
					<span class="fld-label"><?php echo $lang_portal[$side_names[$side]] ?></span><br />
				</div>
<?php
		// If there are any panels on that side?
		if (count($panels) > 0)
		{
			foreach ($panels as $cur_panel)
			{

				if ((($cur_panel['position'] > 0 && $side == 1) || $side == 2) && !$main_content_showed)
				{
					$main_content_showed = true;
					echo $page_content;
				}

				// Which side can move panels to?
				switch ($cur_panel['side'])
				{
					case 0: $move_to_side = array(1); $move_to_side_str = array(1 => 'right'); break;
					case 1: $move_to_side = array(0, 2); $move_to_side_str = array(0 => 'left', 2 => 'right');break;
					case 2: $move_to_side = array(1); $move_to_side_str = array(1 => 'left'); break;
				}

				$move_to_side_arr = array();

				// Generate html for sides to move
				foreach ($move_to_side as $cur_side)
					$move_to_side_arr[] = '<a href="' . forum_link($forum_url['admin_panels']) .'?move='.$cur_panel['id'] .'&amp;side='.$cur_side.'" title="'.$lang_portal['Move '.$move_to_side_str[$cur_side]] .'"><img src="'.FORUM_PORTAL_DIR.'img/'. $move_to_side_str[$cur_side] .'.gif" alt="" /></a>';

				$str_enable = ($cur_panel['enable'] == 0 ? $lang_portal['Enable'] : $lang_portal['Disable']);
				$enable = ($cur_panel['enable'] == 0 ? 1 : 0);
				
				// Check if current panel extension is enabled
				$extension_enabled = ($cur_panel['file'] == '') || in_array(substr($cur_panel['file'], 0, strpos($cur_panel['file'], '/')), $enabled_extensions);
?>
				<div class="frm-fld text twin">
					<span class="fld-label">
					<a href="<?php echo forum_link($forum_url['admin_panels']) ?>?state=<?php echo $enable ?>&amp;panel=<?php echo $cur_panel['id'] ?>"><span><?php echo $str_enable.'<span> '.forum_htmlencode($cur_panel['title']).' </span></span>' ?></a><br />
					<a href="<?php echo forum_link($forum_url['admin_panels']) ?>?edit_panel=<?php echo $cur_panel['id'] ?>"><span><?php echo $lang_admin['Edit'].'<span> '.forum_htmlencode($cur_panel['title']).' </span></span>' ?></a><br /> <a href="<?php echo forum_link($forum_url['admin_panels']) ?>?del_panel=<?php echo $cur_panel['id'] ?>" title="<?php echo $lang_admin['Delete'] ?>"><span><?php echo $lang_portal['Delete short'].'<span> '.forum_htmlencode($cur_panel['title']).'</span></span>' ?></a>
					<?php echo implode("\n", $move_to_side_arr) ?>
					</span><br />
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>" class="twin2">
						<span class="fld-label"><?php echo $lang_admin['Position'] ?></span><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="position[<?php echo $cur_panel['id'] ?>]" size="3" maxlength="3" value="<?php echo $cur_panel['position'] ?>" /></span>
						<span class="fld-extra"><?php echo forum_htmlencode($cur_panel['title']).(!$extension_enabled ? ' '.$lang_portal['Extension disabled'] : '') ?></span>
					</label>
				</div>

<?php
			}
		}
		// Else there are no panels for that side and it isn't center (center has "default" panel - page content)
		elseif ($side != 1)
		{
?>
				<div class="frm-fld text twin">
					<span class="fld-extra"><?php echo $lang_portal['No panels'] ?></span><br />
				</div>
<?php
		}
	}


?>
			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" class="button" name="update_positions" value="<?php echo $lang_admin['Update positions'] ?>" /></span>
			</div>
		</form>
	</div>
<?php

}
// Else there are no panels
else
{
?>
	<div class="main-content frm">
		<div class="frm-head">
			<h2><span><?php echo $lang_portal['Edit panels head'] ?></span></h2>
		</div>
		<div class="frm-info">
			<p><?php echo $lang_portal['No panels'] ?></p>
		</div>
	</div>
<?php
}

?>

</div>
<?php


$tpl_temp = trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->

require FORUM_ROOT.'footer.php';
