<?php

$forum_url['pm'] = 'extensions/'.$ext_info['id'].'/';
$forum_url['pm_view'] = 'extensions/'.$ext_info['id'].'/view.php?id=$1';
$forum_url['pm_send'] = 'extensions/'.$ext_info['id'].'/send.php';
$forum_url['pm_send_to'] = 'extensions/'.$ext_info['id'].'/send.php?to=$1';
$forum_url['pm_reply'] = 'extensions/'.$ext_info['id'].'/send.php?id=$1';
$forum_url['pm_quote'] = 'extensions/'.$ext_info['id'].'/send.php?quote=$1';
$forum_url['pm_inbox'] = 'extensions/'.$ext_info['id'].'/index.php?view=inbox';
$forum_url['pm_read'] = 'extensions/'.$ext_info['id'].'/index.php?view=inbox&amp;action=read&amp;csrf_token=$1';
$forum_url['pm_delete'] = 'extensions/'.$ext_info['id'].'/index.php?view=inbox&amp;action=delete&amp;id=$1&amp;csrf_token=$2';
$forum_url['pm_sent'] = 'extensions/'.$ext_info['id'].'/index.php?view=sent';
$forum_url['pm_settings'] = 'extensions/'.$ext_info['id'].'/index.php?view=settings';