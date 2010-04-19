<?php
/***********************************************************************

	FluxBB extension
	Portal
	Daris <daris91@gmail.com>

************************************************************************/


// Make sure no one attempts to run this script "directly"
if (!defined('FORUM'))
	exit;

function install()
{
	global $forum_db;

	// it's an upgrade
	if (defined('EXT_CUR_VERSION'))
	{
		// do upgrade to 2.2
		if (EXT_CUR_VERSION < 2.2)
		{
			$forum_db->add_field($forum_db->prefix.'pages', 'position', 'int', false, 0);

			$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_left_width\', \'15\')') or error(__FILE__, __LINE__);
			$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_right_width\', \'15\')') or error(__FILE__, __LINE__);
		
		}
	
		// do upgrade to 2.21
		if (EXT_CUR_VERSION < 2.21)
		{
			$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_panels_all_pages\', \'0\')') or error(__FILE__, __LINE__);
			$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_news_description_length\', \'1500\')') or error(__FILE__, __LINE__);
			$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_article_description_length\', \'800\')') or error(__FILE__, __LINE__);
			$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_enable_articles\', \'1\')') or error(__FILE__, __LINE__);
		}
		
		// do upgrade to 2.22
		if (EXT_CUR_VERSION < 2.22)
		{
			$forum_db->query('UPDATE '.$forum_db->prefix.'panels SET content=\'<a href="http://fluxbb.org">FluxBB</a>\', title=\'Links\' WHERE title=\'Banners\'') or error(__FILE__, __LINE__);
		}
	
		// do upgrade to 2.22
		if (EXT_CUR_VERSION < 2.3)
		{
			$forum_db->query('DELETE FROM '.$forum_db->prefix.'config WHERE conf_name=\'o_portal_articles_forums\'') or error(__FILE__, __LINE__);
			$forum_db->query('DELETE FROM '.$forum_db->prefix.'config WHERE conf_name=\'o_portal_article_description_length\'') or error(__FILE__, __LINE__);
			$forum_db->query('DELETE FROM '.$forum_db->prefix.'config WHERE conf_name=\'o_portal_enable_articles\'') or error(__FILE__, __LINE__);
		
			$forum_db->query('DELETE FROM '.$forum_db->prefix.'panels WHERE file=\'portal_by_daris/panels/newest_articles.php\'') or error(__FILE__, __LINE__);
		}


	}
	// it's a fresh install
	else
	{
		// Table pages
		$schema = array(
			'FIELDS'		=> array(
				'id'			=> array(
					'datatype'		=> 'SERIAL',
					'allow_null'	=> false
				),
				'position'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> true,
					'default'	=> 0
				),
				'title'			=> array(
					'datatype'		=> 'VARCHAR(255)',
					'allow_null'	=> true
				),
				'content'			=> array(
					'datatype'		=> 'text',
					'allow_null'	=> true
				)
			),
			'PRIMARY KEY'	=> array('id')
		);
		
		$forum_db->create_table('pages', $schema);
	
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'pages VALUES (0, 1, \'Example page\', \'Example content\')') or error(__FILE__, __LINE__);


		// Table panels
		$schema = array(
			'FIELDS'		=> array(
				'id'			=> array(
					'datatype'		=> 'SERIAL',
					'allow_null'	=> false
				),
				'position'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> true,
					'default'	=> 0
				),
				'title'			=> array(
					'datatype'		=> 'VARCHAR(255)',
					'allow_null'	=> true
				),
				'content'			=> array(
					'datatype'		=> 'text',
					'allow_null'	=> true
				),
				'file'			=> array(
					'datatype'		=> 'VARCHAR(255)',
					'allow_null'	=> true
				),
				'side'			=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> true,
					'default'	=> 0
				),
				'enable'		=> array(
					'datatype'		=> 'INT(1) UNSIGNED',
					'allow_null'	=> true,
					'default'	=> 1
				),
			),
			'PRIMARY KEY'	=> array('id')
		);
		
		$forum_db->create_table('panels', $schema);

		$forum_db->query('INSERT INTO '.$forum_db->prefix.'panels VALUES (0, 0, \'Main menu\', \'\', \'portal_by_daris/panels/menu.php\', 0, 1)') or error(__FILE__, __LINE__);

		$forum_db->query('INSERT INTO '.$forum_db->prefix.'panels VALUES (0, 1, \'Links\', \'<a href="http://fluxbb.org">FluxBB</a>\', \'\', 0, 1)') or error(__FILE__, __LINE__);
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'panels VALUES (0, 3, \'Example panel\', \'\', \'portal_by_daris/panels/example.php\', 0, 0)') or error(__FILE__, __LINE__);

		$forum_db->query('INSERT INTO '.$forum_db->prefix.'panels VALUES (0, -2, \'Welcome message\', \'Welcome to my portal\', \'\', 1, 1)') or error(__FILE__, __LINE__);
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'panels VALUES (0, -1, \'Active topics\', \'\', \'portal_by_daris/panels/active_topics.php\', 1, 1)') or error(__FILE__, __LINE__);
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'panels VALUES (0, 1, \'Example bottom panel\', \'Example panel content. You can use html code as panel content\', \'\', 1, 0)') or error(__FILE__, __LINE__);


		$forum_db->query('INSERT INTO '.$forum_db->prefix.'panels VALUES (0, 0, \''.$forum_db->escape('Who\'s online').'\', \'\', \'portal_by_daris/panels/who_is_online.php\', 2, 1)') or error(__FILE__, __LINE__);
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'panels VALUES (0, 1, \'Search\', \'\', \'portal_by_daris/panels/search.php\', 2, 1)') or error(__FILE__, __LINE__);
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'panels VALUES (0, 2, \'Recent posts\', \'\', \'portal_by_daris/panels/recent_posts.php\', 2, 1)') or error(__FILE__, __LINE__);
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'panels VALUES (0, 3, \'Top posters\', \'\', \'portal_by_daris/panels/top_posters.php\', 2, 1)') or error(__FILE__, __LINE__);

		$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_news_forums\', 1)') or error(__FILE__, __LINE__);
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_news_count\', 10)') or error(__FILE__, __LINE__);
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_news_avatar\', 1)') or error(__FILE__, __LINE__);
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_left_width\', \'15\')') or error(__FILE__, __LINE__);
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_right_width\', \'15\')') or error(__FILE__, __LINE__);
	
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_panels_all_pages\', \'0\')') or error(__FILE__, __LINE__);
		$forum_db->query('INSERT INTO '.$forum_db->prefix.'config VALUES (\'o_portal_news_description_length\', \'1500\')') or error(__FILE__, __LINE__);
	}

	// Regenerate panels cache
	require FORUM_ROOT.'extensions/portal_by_daris/include/cache.php';
	generate_panels_cache();
}


function uninstall()
{
	global $forum_db;

	$forum_db->drop_table('pages');
	$forum_db->drop_table('panels');
	$forum_db->query('DELETE FROM '.$forum_db->prefix.'config WHERE conf_name=\'o_portal_news_forums\'') or error(__FILE__, __LINE__);
	$forum_db->query('DELETE FROM '.$forum_db->prefix.'config WHERE conf_name=\'o_portal_news_count\'') or error(__FILE__, __LINE__);
	$forum_db->query('DELETE FROM '.$forum_db->prefix.'config WHERE conf_name=\'o_portal_news_avatar\'') or error(__FILE__, __LINE__);
	$forum_db->query('DELETE FROM '.$forum_db->prefix.'config WHERE conf_name=\'o_portal_left_width\'') or error(__FILE__, __LINE__);
	$forum_db->query('DELETE FROM '.$forum_db->prefix.'config WHERE conf_name=\'o_portal_right_width\'') or error(__FILE__, __LINE__);
	$forum_db->query('DELETE FROM '.$forum_db->prefix.'config WHERE conf_name=\'o_portal_panels_all_pages\'') or error(__FILE__, __LINE__);
	$forum_db->query('DELETE FROM '.$forum_db->prefix.'config WHERE conf_name=\'o_portal_news_description_length\'') or error(__FILE__, __LINE__);
}
