<?php
/***************************************************************************
*
* $Id:block_allo_cine.php,v 1.146 03-2007 sjpphpbb Exp $
*
* FILENAME  : block_allo_cine.php
* STARTED   : 03-2007
* COPYRIGHT : © 2007 sjpphpbb 
* WWW       : http://sjpphpbb.net/phpbb3
* LICENCE   : GPL vs2.0 [ see /docs/COPYING ]
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

if (!defined('IN_PHPBB'))
{
	exit;
}
$user->add_lang('portal/portal_lang');
$visit_counter   = $config['visit_counter'];

{
   $sql = "UPDATE " . CONFIG_TABLE . "
         SET config_value = '" . ($visit_counter + 1) . "'
         WHERE config_name = 'visit_counter'";
   if( !($result = $db->sql_query($sql)) )
   {
      message_die(GENERAL_ERROR, 'Could not update counter information', '', __LINE__, __FILE__, $sql);
   }

   $visit_counter++;
   }

   $template->assign_vars(array(
   'VISIT_COUNTER' =>$visit_counter)
   );
?>