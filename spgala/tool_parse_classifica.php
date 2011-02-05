<?php
	header('Content-type: text/xml');

	require ( 'config.php' );
	require ( 'classes/mysql.class.php' );
	require ( 'includes/commons.php' );


	define ('RANKING', '/([0-9]+)\t(.+?)\t(.*?)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)/');
	define ('STATUS', '/\((g|i|u|gu|iu|p|gp|ip|ig|up|gup|iup)\)/');



	
	$info = 0;
	
	$db = new DATABASE($db_host, $db_user, $db_pass, $db_name);
	
	$GMTsign = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE ."
		WHERE name = 'gmtsign'"
	);
	
	if ( $GMTsign !== '' ) # Timezone
	{
		$GMT = intval($db->first_result(
			"SELECT value
			FROM " . DB_CONFIG_TABLE ."
			WHERE name = 'gmt'"
		));
		
		if ( $GMTsign == '-' )
			$GMT = -$GMT * 3600;
		else if ( $GMTsign == '+' )
			$GMT = $GMT * 3600;
	}
	else
		$GMT = 0;

	$DST = intval($db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'dst'"
	)); # Daylight Saving Time {0 = false | 1 = true}

	$TD = $GMT + (3600 * $DST); # Time Difference

	$windows_n = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'windows'"
	);

	$window_h = 24/$windows_n;
	
	if ( isset($_POST['user'], $_POST['pass'], $_POST['classifica']) && preg_match(USER_MATCH, $_POST['user']) && preg_match(PASS_MATCH, $_POST['pass']) )
	{
		$user = addslashes($_POST['user']);
		$pass = md5(addslashes($_POST['pass']));

		$query_result = $db->first_row(
			"SELECT id, active, credentials
			FROM " . DB_USERS_TABLE . "
			WHERE nick = '$user'
			AND pass = '$pass'"
		);
										 
		if ( $query_result !== false && $query_result[1] == '1' )
		{
			require ( 'classes/permissions.class.php' );
			$roles = new permissions();
			$permissions = $roles->getPermissions($query_result[2]);
			
			if ( $permissions['UpdDb'] == true )
			{
				$data = stripslashes($_POST['classifica']);
				$lines = explode("\n", $data);
				$n = count($lines);
				$c = 0;
				$date = time();
				$fkplayerud = $query_result[0];
				
$file = fopen(date("ymd-h-i-s").'.txt', "wb");
fwrite($file, $data);
fclose($file);
				
				$info = 2;

				while ( $c < $n )
				{
					$s = preg_match(RANKING, $lines[$c], $matches);
		
					if ( $s )
					{
						$info = 1;
						$player['ally'] = addslashes(trim($matches[3], "/\[\] /"));
						$player['name'] = addslashes(trim(ltrim($matches[2], "/[123]/")));
						$player['old_name'] = addslashes(trim(ltrim($matches[2], "/[123]/")));
						$player['class'] = '';
						$player['tot_p'] = $matches[4];
						$player['build_p'] = $matches[5];
						$player['res_p'] = $matches[6];
						$player['fleet_p'] = $matches[7];


//						fputs($logFile, $player['name'].' - '.$player['class']); 
						
						$stat = preg_match(STATUS, $player['name'], $matches);
						
						if ( $stat )
						{
							$status = preg_replace("/p/", "", $matches[1]);
			
							switch ($status)
							{
								case 'g':
									$player['status'] = 1;
									break;
								case 'i':
									$player['status'] = 2;
									break;
								case 'u':
									$player['status'] = 3;
									break;
								case 'gu':
									$player['status'] = 4;
									break;
								case 'iu':
									$player['status'] = 5;
									break;
								default:
									$player['status'] = 0;
									break;
							}
							
							$player['name'] = preg_replace('/ \(' . $matches[1] . '\)/', '', $player['name']);
							$player['old_name'] = preg_replace('/ \(' . $matches[1] . '\)/', '', $player['old_name']);
						}
						else
							$player['status'] = 0;
						
						switch ($player['class'])
						{
							case CLASS_WARRIOR:
								$player['class'] = 1;
								break;
							case " ":
								$player['class'] = 0;
								break;
							default:
								$player['class'] = 2;
								break;			
						}


//						fput ($logFile, " - Comp : " . strcmp($player['class'] , "Commerçant"));
//						fputs($logFile, " - " . $player['class']."\n");


						if ( $player['name'] !== $player['old_name'] )
						{
							$old = $db->first_result(
								"SELECT nick
								FROM " . DB_PLAYERS_TABLE . "
								WHERE nick = '{$player['old_name']}'"
							);

							$new = $db->first_result(
								"SELECT nick
								FROM " . DB_PLAYERS_TABLE . "
								WHERE nick = '{$player['name']}'"
							);
													   
							if ( $old !== false && $new === false )
								$db->query(
									"UPDATE " . DB_PLAYERS_TABLE . "
									SET nick = '{$player['name']}',
									oldnick = '{$player['old_name']}'
									WHERE nick = '{$player['old_name']}'"
								);
							else if ($old === false && $new !== false)
								$db->query(
									"UPDATE " . DB_PLAYERS_TABLE . "
									SET oldnick = '{$player['old_name']}'
									WHERE nick = '{$player['name']}'"
								);
						}
						
						$player['id'] = $db->first_result(
							"SELECT id
							FROM " . DB_PLAYERS_TABLE . "
							WHERE nick = '{$player['name']}'"
						);
			
						if ( $player['id'] !== false )
							$db->query(
								"UPDATE " . DB_PLAYERS_TABLE . "
								SET ally = '{$player['ally']}',
								date = '$date',
								class = '{$player['class']}',
								status = '{$player['status']}'
								WHERE id = '{$player['id']}'"
							);
						else
						{
							$db->query(
								"INSERT INTO " . DB_PLAYERS_TABLE . "
								(nick, ally, date, class, status)
								VALUES
								('{$player['name']}', '{$player['ally']}', '$date', '{$player['class']}', '{$player['status']}')"
							);
							
							$player['id'] = mysql_insert_id();
						}
						
						for ( $i = 0; $i < $windows_n; $i++ )
						{
							$time['start'] = gmmktime($window_h*$i, 0, 0, gmdate("m"), gmdate("d"), gmdate("Y"))-$TD;
							$time['end']   = gmmktime($window_h*$i+$window_h-1, 59, 59, gmdate("m"), gmdate("d"), gmdate("Y"))-$TD;
							
							if ( time() >= $time['start'] && time() <= $time['end'] )
							{
								$last_ranking_date = $db->first_result(
									"SELECT MAX(date)
									FROM " . DB_STATS_TABLE . "
									WHERE fkplayer = '{$player['id']}'"
								);
					
								$last_ranking_id = $db->first_result(
									"SELECT MAX(n)
									FROM " . DB_STATS_TABLE . "
									WHERE date < '{$time['start']}'"
								);
								
								if ( $last_ranking_id === NULL )
									$last_ranking_id = 0;
								else
									$last_ranking_id++;
							
								if ( $last_ranking_date !== NULL && $last_ranking_date >= $time['start'] && $last_ranking_date <= $time['end'] )
								{
									$last_ranking_id--;
									
									$db->query(
										"UPDATE " . DB_STATS_TABLE . "
										SET tot = '{$player['tot_p']}',
										build = '{$player['build_p']}',
										res = '{$player['res_p']}',
										fleetdef = '{$player['fleet_p']}',
										date = '$date',
										fkplayerud = '$fkplayerud'
										WHERE fkplayer = '{$player['id']}'
										AND date = '$last_ranking_date'"
									);
								}
								else
									$db->query(
										"INSERT INTO " . DB_STATS_TABLE . "
										(fkplayer, tot, build, res, fleetdef, date, n, fkplayerud)
										VALUES
										('{$player['id']}', '{$player['tot_p']}', '{$player['build_p']}', '{$player['res_p']}', '{$player['fleet_p']}', '$date', '$last_ranking_id', '$fkplayerud')"
									);
								
								break;
							}
						}
					}
						
					$c++;
				}
			}
		}
	}
?>
<xmlresponse>
    <info><?php echo $info; ?></info>
</xmlresponse>
<?php
	require ( 'includes/pruning.php' );
	
//	fclose($logFile);
	
	$db->close_db();
?>
