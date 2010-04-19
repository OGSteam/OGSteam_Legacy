<?php
/***************************************************************************
*
* $Id:block_clock,v 1.146 03-2007 sjpphpbb Exp $
*
* FILENAME  : block_header.php
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
	global $db;
	
		$sql_header_portal = "SELECT *
			FROM  ".PORTAL_HEADER_CONFIG_TABLE ." 
			WHERE header_portal_disable = '1'  
			ORDER by header_portal_disable";
		
        $result_header_portal = $db->sql_query($sql_header_portal);

        while ($row = $db->sql_fetchrow($result_header_portal))
        {
              $header_portal_disable = $row['header_portal_disable'];
        }
            $template->assign_vars(array(
			
                'S_PORTAL_HEADER'  					=> $header_portal_disable));	
	
		$sql = 'SELECT *
			FROM ' . PORTAL_HEADER_CONFIG_TABLE . '
			ORDER BY   header_logo_id';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_vars(array(
				'SITENAME_PORTAL'		=> $row['header_logo_name'],
				'SITE_DESCRIPTION_DESC'	=> $row['header_logo_desc'],				
				'IMG_LOGO'				=> $row['header_logo_image'],
				'IMG_LOGO_2'			=> $row['header_logo_image'])
			);
		}
		$db->sql_freeresult($result);

			$sql = 'SELECT *
			FROM ' . PORTAL_HEADER_TABLE . '
			ORDER BY   header_no ASC';
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, "Could not query sow information", "", __LINE__, __FILE__, $sql);
		}

		$compt = array();
		while( $row = $db->sql_fetchrow($result) )
		{
			$compt[] = $row;
		}
		for( $i = 0; $i < count($compt); $i++ )
		{

		$header_image[] = ( $compt[$i]['header_image'] != "" ) ? " header_image='" . $compt[$i]['header_image'] ."' " : "" ;
		$header_ulr_img = ( $compt[$i]['header_ulr_img'] != "" ) ? " header_ulr_img='" . $compt[$i]['header_ulr_img'] ."' " : "" ;
		$header_titre = ( $compt[$i]['header_titre'] != "" ) ? " header_titre='" . $compt[$i]['header_titre'] ."' " : "" ;
		$header_portal_disable = ( $compt[$i]['header_portal_disable'] != "" ) ? " header_portal_disable='" . $compt[$i]['header_portal_disable'] ."' " : "" ;		
		
        if
		(
		$compt[$i]['header_portal_disable'] == 1 ||
		$compt[$i]['header_portal_disable'] == 2 && $user->data['is_registered'] ||		
		$compt[$i]['header_portal_disable'] == 3 && $user->data['user_rank'] == 2 ||
		$compt[$i]['header_portal_disable'] == 3 && $user->data['user_type'] == 3 ||		
		$compt[$i]['header_portal_disable'] == 4 && $user->data['user_type'] == 3 )

		{
			$template->assign_block_vars('header',array(		
				'HEADER_IMAGE'        	=>  $compt[$i]['header_image'],				
				'HEADER_URL_IMG'       =>  $compt[$i]['header_ulr_img'],
				'HEADER_TITRE'        	=>  $compt[$i]['header_titre'])	
			);
		}
	}	
		$db->sql_freeresult($result);		
  

?>