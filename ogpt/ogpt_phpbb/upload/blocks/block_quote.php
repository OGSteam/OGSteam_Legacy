<?php
/***************************************************************************
*
* @package phpBB3
* @version $Id: quote ( Citation )
* @copyright (c) 2007 sjpphppbb.net
*
****************************************************************************/

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
			FROM ' . QUOTE_TITRE_TABLE . '
			ORDER BY   quote_titre_id ';
		$results = $db->sql_query($sql);

		$row = $db->sql_fetchrow($results);
		{
    			$quote_titre= $row['quote_titre'];
		}

			$template->assign_block_vars('quote_titre', array(
				'S_QUOTE_DISABLE'       => (isset ($block_quote_disable )) ? $block_quote_disable  : 0,
				'QUOTE_TITRE' 			=> $row['quote_titre'])
			);


		$sql = "SELECT quote, author FROM " . QUOTE_TABLE . "  ORDER BY rand()";
		$result = $db->sql_query($sql);
		while( $row = $db->sql_fetchrow($result) )
		{
    			$quote = $row['quote'];
    			$author = $row['author'];
		}
			$template->assign_vars(array(		
   	 			'QUOTE' 				=> $quote,
   	 			'AUTHOR' 			=> $author));

	}

?>