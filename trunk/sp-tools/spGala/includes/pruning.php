<?php
	$pruning_date = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'pruning'"
	);
	
	$maxrankings = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'maxrankings'"
	);

	$date = time();
	
	if ( $date >= $pruning_date )
	{
		$max_ranking_id = $db->first_result(
			"SELECT MAX(n)
			FROM " . DB_STATS_TABLE
		);

		$db->query(
			"DELETE FROM " . DB_STATS_TABLE . "
			WHERE n <= '$max_ranking_id'-" . $maxrankings
		);

		$query_result = $db->query(
			"SELECT DISTINCT id
			FROM " . DB_PLAYERS_TABLE
		);

		while ( $row = mysql_fetch_array($query_result) )
		{
			$player_id = $row['id'];
			$check = $db->first_result(
				"SELECT fkplayer
				FROM " . DB_STATS_TABLE . "
				WHERE fkplayer = '$player_id'"
			);
			
			if ($check === false)
			{
				$db->query( "DELETE FROM " . DB_PLAYERS_TABLE . "
							 WHERE id = '$player_id'" );

				$db->query( "DELETE FROM " . DB_PLANETS_TABLE . "
							 WHERE fkplayer = '$player_id'" );

				$db->query( "DELETE FROM " . DB_RESEARCH_TABLE . "
							 WHERE fkplayer = '$player_id'" );
			}
		}
		
		$next_pruning = gmmktime(0, 0, 0, gmdate("m"), gmdate("d")+1, gmdate("Y"));
		
		$db->query(
			"OPTIMIZE TABLE
			" . DB_PLAYERS_TABLE.  ",
			" . DB_STATS_TABLE . ",
			" . DB_PLANETS_TABLE . ",
			" . DB_RESEARCH_TABLE
		);

		$db->query(
			"UPDATE " . DB_CONFIG_TABLE . "
			SET value = '$next_pruning'
			WHERE name = 'pruning'"
		);
	}
?>