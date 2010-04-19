<?php
/***************************************************************************
*
* @package phpBB3
* @version $Id: sow_images
* @copyright (c) 2007 sjpphppbb.net
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
	{	

		$sql = 'SELECT *
			FROM ' . SOW_TITRE_TABLE . '
			ORDER BY   sow_titre_id ASC ';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{

		{
    			$sow_titre= $row['sow_titre'];
		}

		$template->assign_vars(array(
			'SOW_TITRE' 		=> $row['sow_titre'])
			);
		}

		$sql = "SELECT sow_id, no, titre, image, info, width, height, info3 FROM ".SOW_TABLE." ORDER BY no ASC LIMIT 5" ;

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
			$class = ( !($i % 2) ) ? 'row1' : 'row2';

		$user->add_lang('portal/block_sow_images_lang');

		$width[] = ( $compt[$i]['width'] != "" ) ? " width='" . $compt[$i]['width'] ."' " : "" ;
		$height = ( $compt[$i]['height'] != "" ) ? " height='" . $compt[$i]['height'] ."' " : "" ;
		$img2 =  ( $compt[$i]['image'] != "" ) ? "<img src='" . $compt[$i]['image'] . "' " . $width . $height  . " border='0' vspace='1' />": "" ;
		$img = ( $compt[$i]['info']) ? '<a style="text-decoration: none" href="' . $compt[$i]['info'] . '" target=_blank>' . $img2 . '</a>' : "";

		$template->assign_block_vars('show',array(
			'S_SOW_DISABLE'             	=> (isset ($sow_disable )) ? $sow_disable  : 0,
			'CLASS' 			=> $class,
			'U_INFO' 			=>  '<a style="text-decoration: none" href="' . $compt[$i]['info'] . '" target=_blank>' . $user->lang['INFO_LIEN'] . '</a>',
			'INFO3' 			=> $compt[$i]['info3'],
			'IMAGE' 			=> $img,
			'TITRE' 			=> $compt[$i]['titre']
			));

	}
 }



?>
