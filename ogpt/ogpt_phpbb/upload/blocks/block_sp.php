<?php

/***************************************************************************
 *                                mod_sujet le plus populaire.php
 *                            -------------------
 *   fait le                : Vendreci,5 Octobre, 2003
 *   Par : sjpphpbb - sjpphpbb@hotmail.com - http://sjpphpbb.net
 *
 ***************************************************************************/
 
/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/


if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

$user->add_lang('portal/block_sp_lang');
//pour avoir les sujets de la semaine par exemple, modifier : $days = 7;
$days_topic = 300;
$date_topic = time() - ( $days_topic * 24 * 60 * 60 );

$topic_views_sql="SELECT topic_title,topic_views,topic_id,topic_replies FROM " . TOPICS_TABLE . " WHERE topic_time > " . $date_topic . " ORDER BY topic_views DESC LIMIT 1"; 
$more_views = $db->sql_query($topic_views_sql);
while($line = $db->sql_fetchrow($more_views) ) { 
$topic = append_sid("viewtopic.php?t=".$line['topic_id']); 
$template->assign_vars(array(

            'TOPIC' => $topic, 
            'POST' => $line['topic_title'], 
            'NB' => $line['topic_views'],
            'REPLIES' => $line['topic_replies'],) 
         ); 
}; 

$topic_replies_sql="SELECT topic_title,topic_replies,topic_id,topic_views FROM " . TOPICS_TABLE . " WHERE topic_time > " . $date_topic . " ORDER BY topic_replies DESC LIMIT 1"; 
$more_replies = $db->sql_query($topic_replies_sql);
while($line2 = $db->sql_fetchrow($more_replies) ) {  
$topic2 = append_sid("viewtopic.php?t=".$line2['topic_id']); 
$template->assign_vars(array(

            'TOPIC2' => $topic2, 
            'POST2' => $line2['topic_title'], 
	        'NB2' => $line2['topic_views'],
            'REPLIES2' => $line2['topic_replies']) 
         ); 
};	 

?>
