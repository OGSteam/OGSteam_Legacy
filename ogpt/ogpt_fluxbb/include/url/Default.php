<?php
/***********************************************************************

  Copyright (C) 2008  FluxBB.org

  Based on code copyright (C) 2002-2008  PunBB.org

  This file is part of FluxBB.

  FluxBB is free software; you can redistribute it and/or modify it
  under the terms of the GNU General Public License as published
  by the Free Software Foundation; either version 2 of the License,
  or (at your option) any later version.

  FluxBB is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston,
  MA  02111-1307  USA

************************************************************************/


// Make sure no one attempts to run this script "directly"
if (!defined('FORUM'))
	exit;

// These are the regular, "non-SEF" URLs (you probably don't want to edit these)
$forum_url = array(
	'change_email'					=>	'profile.php?action=change_email&amp;id=$1',
	'change_email_key'				=>	'profile.php?action=change_email&amp;id=$1&amp;key=$2',
	'change_password'				=>	'profile.php?action=change_pass&amp;id=$1',
	'change_password_key'			=>	'profile.php?action=change_pass&amp;id=$1&amp;key=$2',
	'delete_user'					=>	'profile.php?action=delete_user&amp;id=$1',
	'delete'						=>	'delete.php?id=$1',
	'delete_avatar'					=>	'profile.php?action=delete_avatar&amp;id=$1&amp;csrf_token=$2',
	'edit'							=>	'edit.php?id=$1',
	'email'							=>	'misc.php?email=$1',
	'forum'							=>	'viewforum.php?id=$1',
	'forum_rss'						=>	'extern.php?action=feed&amp;fid=$1&amp;type=rss',
	'forum_atom'					=>	'extern.php?action=feed&amp;fid=$1&amp;type=atom',
	'help'							=>	'help.php?section=$1',
	'index'							=>	'',
	'login'							=>	'login.php',
	'logout'						=>	'login.php?action=out&amp;id=$1&amp;csrf_token=$2',
	'mark_read'						=>	'misc.php?action=markread&amp;csrf_token=$1',
	'mark_forum_read'				=>	'misc.php?action=markforumread&amp;fid=$1&amp;csrf_token=$2',
	'new_topic'						=>	'post.php?fid=$1',
	'new_reply'						=>	'post.php?tid=$1',
	'post'							=>	'viewtopic.php?pid=$1#p$1',
	'profile_about'					=>	'profile.php?section=about&amp;id=$1',
	'profile_identity'				=>	'profile.php?section=identity&amp;id=$1',
	'profile_settings'				=>	'profile.php?section=settings&amp;id=$1',
	'profile_preferences'			=>	'profile.php?section=preferences&amp;id=$1',
	'profile_avatar'				=>	'profile.php?section=avatar&amp;id=$1',
	'profile_signature'				=>	'profile.php?section=signature&amp;id=$1',
	'profile_display'				=>	'profile.php?section=display&amp;id=$1',
	'profile_privacy'				=>	'profile.php?section=privacy&amp;id=$1',
	'profile_admin'					=>	'profile.php?section=admin&amp;id=$1',
	'quote'							=>	'post.php?tid=$1&amp;qid=$2',
	'register'						=>	'register.php',
	'report'						=>	'misc.php?report=$1',
	'request_password'				=>	'login.php?action=forget',
	'rules'							=>	'misc.php?action=rules',
	'search'						=>	'search.php',
	'search_resultft'				=>	'search.php?action=search&amp;keywords=$1&amp;author=$3&amp;forum=$2&amp;search_in=$4&amp;sort_by=$5&amp;sort_dir=$6&amp;show_as=$7',
	'search_results'				=>	'search.php?search_id=$1',
	'search_new'					=>	'search.php?action=show_new',
	'search_24h'					=>	'search.php?action=show_recent',
	'search_unanswered'				=>	'search.php?action=show_unanswered',
	'search_subscriptions'			=>	'search.php?action=show_subscriptions&amp;user_id=$1',
	'search_user_posts'				=>	'search.php?action=show_user_posts&amp;user_id=$1',
	'search_user_topics'			=>	'search.php?action=show_user_topics&amp;user_id=$1',
	'subscribe'						=>	'misc.php?subscribe=$1&amp;csrf_token=$2',
	'topic'							=>	'viewtopic.php?id=$1',
	'topic_rss'						=>	'extern.php?action=feed&amp;tid=$1&amp;type=rss',
	'topic_atom'					=>	'extern.php?action=feed&amp;tid=$1&amp;type=atom',
	'topic_new_posts'				=>	'viewtopic.php?id=$1&amp;action=new',
	'topic_last_post'				=>	'viewtopic.php?id=$1&amp;action=last',
	'unsubscribe'					=>	'misc.php?unsubscribe=$1&amp;csrf_token=$2',
	'user'							=>	'profile.php?id=$1',
	'users'							=>	'userlist.php',
	'users_browse'					=>	'userlist.php?show_group=$1&amp;sort_by=$2&amp;sort_dir=$3&amp;username=$4',
	'page'							=>	'&amp;p=$1',
	'moderate'						=>	'moderate.php',
	'moderate_forum'				=>	'moderate.php?fid=$1',
	'get_host'						=>	'moderate.php?get_host=$1',
	'move'							=>	'moderate.php?fid=$1&amp;move_topics=$2',
	'open'							=>	'moderate.php?fid=$1&amp;open=$2&amp;csrf_token=$3',
	'close'							=>	'moderate.php?fid=$1&amp;close=$2&amp;csrf_token=$3',
	'stick'							=>	'moderate.php?fid=$1&amp;stick=$2&amp;csrf_token=$3',
	'unstick'						=>	'moderate.php?fid=$1&amp;unstick=$2&amp;csrf_token=$3',
	'delete_multiple'				=>	'moderate.php?fid=$1&amp;tid=$2',
	'admin_index'					=>	'admin/index.php',
	'admin_bans'					=>	'admin/bans.php',
	'admin_categories'				=>	'admin/categories.php',
	'admin_censoring'				=>	'admin/censoring.php',
	'admin_extensions_manage'		=>	'admin/extensions.php?section=manage',
	'admin_extensions_install'		=>	'admin/extensions.php?section=install',
	'admin_forums'					=>	'admin/forums.php',
	'admin_groups'					=>	'admin/groups.php',
	'admin_loader'					=>	'admin/loader.php',
	'admin_reindex'					=>	'admin/reindex.php',
	'admin_options_setup'			=>	'admin/options.php?section=setup',
	'admin_options_features'		=>	'admin/options.php?section=features',
	'admin_options_content'			=>	'admin/options.php?section=content',
	'admin_options_email'			=>	'admin/options.php?section=email',
	'admin_options_announcements'	=>	'admin/options.php?section=announcements',
	'admin_options_registration'	=>	'admin/options.php?section=registration',
	'admin_options_communications'	=>	'admin/options.php?section=communications',
	'admin_options_maintenance'		=>	'admin/options.php?section=maintenance',
	'admin_prune'					=>	'admin/prune.php',
	'admin_ranks'					=>	'admin/ranks.php',
	'admin_reports'					=>	'admin/reports.php',
	'admin_users'					=>	'admin/users.php'
);
