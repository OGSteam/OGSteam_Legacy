<?php
/***********************************************************************

	FluxBB extension
	Portal
	Daris <daris91@gmail.com>

************************************************************************/


// Make sure no one attempts to run this script "directly"
if (!defined('FORUM'))
	exit;


$forum_rewrite_rules_portal = array(
	'/^forum(\.html?|\/)?$/i'			=> 'index.php?forum',
	'/^articles(\.html?|\/)?$/i'			=> 'index.php?articles',
	'/^article[\/_-]?([0-9]+).*(\.html?|\/)?$/i'	=> 'index.php?article=$1',
	'/^pages(\.html?|\/)?$/i'			=> 'index.php?pages',
	'/^page[\/_-]?([0-9]+).*(\.html?|\/)?$/i'	=> 'index.php?page=$1',
	'/^news[\/_-](rss|atom)(\.html?|\/)?$/i'	=> 'extern.php?portal_feed=news&type=$1',
	'/^articles[\/_-](rss|atom)(\.html?|\/)?$/i'	=> 'extern.php?portal_feed=articles&type=$1',
);

$forum_rewrite_rules = array_merge($forum_rewrite_rules, $forum_rewrite_rules_portal);