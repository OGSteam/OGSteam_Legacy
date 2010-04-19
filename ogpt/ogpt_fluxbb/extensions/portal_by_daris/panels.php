<?php
/***********************************************************************

	FluxBB extension
	Portal
	Daris <daris91@gmail.com>

************************************************************************/

if (defined('FORUM_PORTAL') && $forum_user['g_read_board'] != '0')
{
	if (file_exists(FORUM_PORTAL.'lang/'.$forum_user['language'].'/portal.php'))
		require_once FORUM_PORTAL.'lang/'.$forum_user['language'].'/portal.php';
	else
		require_once FORUM_PORTAL.'lang/English/portal.php';

	$left_width = isset($forum_config['o_portal_left_width']) ? intval($forum_config['o_portal_left_width']) : '15';
	$right_width = isset($forum_config['o_portal_right_width']) ? intval($forum_config['o_portal_right_width']) : '15';

	$panels_output = array(
		0 => array(),
		1 => array(
			'top' => array(),
			'bottom' => array()
		),
		2 => array()
	);

	foreach ($forum_panels as $side => $panels)
	{
		foreach ($panels as $panel)
		{
			// if panel side width is not equal 0
			if (($side == 0 && $left_width != 0) || ($side == 2 && $right_width != 0) || $side == 1)
			{
				ob_start();
		
				$content_class = 'panel-content';
		
				$file = FORUM_ROOT.'extensions/'.$panel['file'];
				
				// if panel file exists require it
				if ($panel['file'] != '' && file_exists($file) && is_file($file))
					require_once $file;
		
				// else evaluate panel content
				else
					eval('?>'.$panel['content']);
		
		
				$content = ob_get_contents();
				ob_end_clean();
				
				if ($content == '')
					continue;
		
				ob_start();
?>	<div class="panel">

		<div class="main-head">
			<h2 class="hn"><span><?php echo $panel['title'] ?></span></h2>
		</div>

		<div class="main-content <?php echo $content_class ?>">
<?php echo $content ?>

		</div>

	</div>
<?php

				// insert panel html to specified side
				if ($side == 0 || $side == 2)
					$panels_output[$side][] = ob_get_contents();
		
				elseif ($side == 1)
				{
					$pos = (intval($panel['position']) <= 0) ? 'top' : 'bottom';
					$panels_output[$side][$pos][] = ob_get_contents();
				}
		
				ob_end_clean();
			}
		}
	}

	// generate portal_top replacement
	$tpl_temp = "\n".'<div id="leftside">';
	$tpl_temp .= "\n".implode("\n", $panels_output[0]);
	$tpl_temp .= "\n".'</div>';

	$tpl_temp .= "\n".'<div id="rightside">';
	$tpl_temp .= "\n".implode("\n", $panels_output[2]);
	$tpl_temp .= "\n".'</div>';

	$tpl_temp .= "\n".'<div id="center">';
	$tpl_temp .= (FORUM_PAGE == 'news' ? "\n".implode("\n", $panels_output[1]['top']) : '');
	
	$tpl_main = str_replace('<!-- portal_top -->', $tpl_temp, $tpl_main);

	// generate portal_bottom replacement
	$tpl_temp = (FORUM_PAGE == 'news' ? "\n".implode("\n", $panels_output[1]['bottom']) : '');
	$tpl_temp .= "\n".'</div>';

	$tpl_temp .= "\n".'<div style="clear:both">&nbsp;</div>';

	$tpl_main = str_replace('<!-- portal_bottom -->', $tpl_temp, $tpl_main);

	$style_center = '';

	if (!count($panels_output[0]))
		$left_width = 0;
	
	if (!count($panels_output[2]))
		$right_width = 0;

	// Calculate center width
	$center_width = 100 - $left_width - $right_width;
	if (count($panels_output[0]) && count($panels_output[2]))
	{
		$center_width -= 2;
		$style_center .= 'margin-left: 1%;';
	}
	elseif (!count($panels_output[0]) && !count($panels_output[2])) { /* do nothing */ }
	
	elseif (!count($panels_output[0]))
		$center_width -= 1;

	elseif (!count($panels_output[2]))
	{
		$center_width -= 1;
		$style_center .= 'float: right;';
	}
	
	// Generate css
	$style = array();
	if ($left_width != 0)
		$style[] = '#leftside { width: '.$left_width.'%; }';
		
	if ($right_width != 0)
		$style[] = '#rightside { width: '.$right_width.'%; }';
	
	$style[] = '#center { width: '.$center_width.'%; '.$style_center.'}';

	$style_html = '<style type="text/css">'."\n".implode("\n", $style)."\n".'</style>';

	$tpl_main = str_replace('</head>', $style_html."\n".'</head>', $tpl_main);
}