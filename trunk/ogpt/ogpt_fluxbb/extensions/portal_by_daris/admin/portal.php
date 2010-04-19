<?php
/***********************************************************************

	FluxBB extension
	Portal
	Daris <daris91@gmail.com>

************************************************************************/


// Make sure no one attempts to run this script "directly"
if (!defined('FORUM'))
	exit;

if (file_exists(FORUM_ROOT.'extensions/portal_by_daris/lang/'.$forum_user['language'].'/portal.php'))
	require FORUM_ROOT.'extensions/portal_by_daris/lang/'.$forum_user['language'].'/portal.php';
else
	require FORUM_ROOT.'extensions/portal_by_daris/lang/English/portal.php';


// Display all the categories and forums
$query = array(
	'SELECT'	=> 'c.id AS cid, c.cat_name, f.id AS fid, f.forum_name, f.disp_position',
	'FROM'		=> 'categories AS c',
	'JOINS'		=> array(
		array(
			'INNER JOIN'	=> 'forums AS f',
			'ON'			=> 'c.id=f.cat_id'
		)
	),
	'ORDER BY'	=> 'c.disp_position, c.id, f.disp_position'
);
($hook = get_hook('aop_portal_qr_get_cats_and_forums')) ? eval($hook) : null;
$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

$news_forums = $cur_cat_html = '';

$news_array = explode(',', $forum_config['o_portal_news_forums']);

($hook = get_hook('aop_portal_explode_news_forums')) ? eval($hook) : null;


if ($forum_db->num_rows($result))
{
	$cur_category = -1;

	while ($cur_forum = $forum_db->fetch_assoc($result))
	{
		if ($cur_forum['cid'] != $cur_category)	// A new category since last iteration?
		{
			$cur_cat_html = ($cur_category != -1 ? '</optgroup>' : '').'<optgroup label="'.forum_htmlencode($cur_forum['cat_name']).'">';
			$news_forums .= $cur_cat_html;
			
			($hook = get_hook('aop_portal_get_forums_loop_category')) ? eval($hook) : null;
		
			$cur_category = $cur_forum['cid'];
		}

		$news_forums .= '<option value="'.$cur_forum['fid'].'"'.(in_array($cur_forum['fid'], $news_array) ? ' selected="selected"' : '').'>'.forum_htmlencode($cur_forum['forum_name']).'</option>';
		
		($hook = get_hook('aop_portal_get_forums_loop')) ? eval($hook) : null;
	}
}


// Setup the form
$forum_page['part_count'] = $forum_page['fld_count'] = $forum_page['set_count'] = 0;

// Setup breadcrumbs
$forum_page['crumbs'] = array(
	array($forum_config['o_board_title'], forum_link($forum_url['index'])),
	array($lang_admin['Forum administration'], forum_link($forum_url['admin_index'])),
	$lang_portal['Portal']
);

($hook = get_hook('aop_portal_pre_header_load')) ? eval($hook) : null;

define('FORUM_PAGE_SECTION', 'options');
define('FORUM_PAGE', 'admin-options-portal');
require FORUM_ROOT.'header.php';

ob_start();

?>
<div id="pun-main" class="main sectioned admin">

<?php echo generate_admin_menu(); ?>

	<div class="main-head">
		<h1><span>{ <?php echo end($forum_page['crumbs']) ?> }</span></h1>
	</div>

	<div class="main-content frm parted">
		<div class="frm-head">
			<h2><span><?php echo $lang_portal['Portal head'] ?></span></h2>
		</div>
		<form class="frm-form" method="post" accept-charset="utf-8" action="<?php echo forum_link($forum_url['admin_options_portal']) ?>">
			<div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link($forum_url['admin_options_portal'])) ?>" />
				<input type="hidden" name="form_sent" value="1" />
			</div>
<?php ($hook = get_hook('aop_setup_pre_portal_news')) ? eval($hook) : null; ?>
			<div class="frm-part part<?php echo ++ $forum_page['part_count'] ?>">
				<h3><span><?php printf($lang_portal['Index page head'], $forum_page['part_count']) ?></span></h3>
				<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
					<legend class="frm-legend"><strong><?php echo $lang_portal['Index page legend'] ?></strong></legend>
					<div class="frm-fld text">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['Forums for news'] ?></span><br />
							<span class="fld-select"><select id="fld<?php echo $forum_page['fld_count'] ?>" name="form[portal_news_forums][]" multiple="multiple" size="8"><?php echo $news_forums ?></optgroup></select></span><br />
						</label>
					</div>
					<div class="frm-fld text">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['News count'] ?></span><br />
							<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="form[portal_news_count]" size="3" maxlength="3" value="<?php echo forum_htmlencode($forum_config['o_portal_news_count']) ?>" /></span><br />
						</label>
					</div>
					<div class="frm-fld text">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['News description length'] ?></span><br />
							<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="form[portal_news_description_length]" size="5" maxlength="5" value="<?php echo forum_htmlencode($forum_config['o_portal_news_description_length']) ?>" /></span><br />
							<span class="fld-help"><?php echo $lang_portal['News description length info'] ?></span>
						</label>
					</div>
					<div class="radbox checkbox">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['Avatar in news'] ?></span><br /><input type="checkbox" id="fld<?php echo $forum_page['fld_count'] ?>" name="form[portal_news_avatar]" value="1"<?php if ($forum_config['o_portal_news_avatar'] == '1') echo ' checked="checked"' ?> /> <?php echo $lang_portal['Avatar in news info'] ?>
						</label>
					</div>
				</fieldset>
			</div>
<?php 
$forum_page['set_count'] = 0;

($hook = get_hook('aop_setup_pre_portal_size')) ? eval($hook) : null;

?>
			<div class="frm-part part<?php echo ++ $forum_page['part_count'] ?>">
				<h3><span><?php printf($lang_portal['Size head'], $forum_page['part_count']) ?></span></h3>
				<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
					<legend class="frm-legend"><strong><?php echo $lang_portal['Size legend'] ?></strong></legend>
					<div class="frm-fld text">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['Left side width'] ?></span><br />
							<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="form[portal_left_width]" size="10" value="<?php echo forum_htmlencode($forum_config['o_portal_left_width']) ?>" /></span><br />
							<span class="fld-help"><?php echo $lang_portal['Left side width info'] ?></span>
						</label>
					</div>
					<div class="frm-fld text">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['Right side width'] ?></span><br />
							<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="form[portal_right_width]" size="10" value="<?php echo forum_htmlencode($forum_config['o_portal_right_width']) ?>" /></span><br />
							<span class="fld-help"><?php echo $lang_portal['Right side width info'] ?></span>
						</label>
					</div>
				</fieldset>
			</div>	
<?php 
$forum_page['set_count'] = 0;

($hook = get_hook('aop_setup_pre_portal_advanced')) ? eval($hook) : null;

?>
			<div class="frm-part part<?php echo ++ $forum_page['part_count'] ?>">
				<h3><span><?php printf($lang_portal['Advanced settings head'], $forum_page['part_count']) ?></span></h3>
				<fieldset class="frm-set set<?php echo ++$forum_page['set_count'] ?>">
					<legend class="frm-legend"><strong><?php echo $lang_portal['Advanced settings legend'] ?></strong></legend>
					<div class="radbox checkbox">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>">
							<span class="fld-label"><?php echo $lang_portal['Panels on all pages'] ?></span><br /><input type="checkbox" id="fld<?php echo $forum_page['fld_count'] ?>" name="form[portal_panels_all_pages]" value="1"<?php if ($forum_config['o_portal_panels_all_pages'] == '1') echo ' checked="checked"' ?> /> <?php echo $lang_portal['Panels on all pages info'] ?>
						</label>
					</div>
				</fieldset>
			</div>
<?php
$forum_page['set_count'] = 0;

($hook = get_hook('aop_setup_portal_new_part')) ? eval($hook) : null;

?>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" name="save" value="<?php echo $lang_admin['Save changes'] ?>" /></span>
			</div>
		</form>
	</div>

</div>