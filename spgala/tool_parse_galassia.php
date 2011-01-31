<?php
	header('Content-type: text/xml');

	require ( 'config.php' );
	require ( 'classes/mysql.class.php' );
	require ( 'includes/commons.php' );

	define ('GALAXY', '/([0-9]+)\t([\x20-\x7e\x81-\xffº¹²³¼½¾]+)\t([\x20-\x7e\x81-\xff]+)\t([\x20-\x7e\x81-\xff]+)\t([\x20-\x7e\x81-\xff]+)/');
	define ('STATUS', '/\((g|i|u|gu|iu|p|gp|ip|ig|up|gup|iup)\)/');
	
	$info = 0;
	
	if ( isset($_POST['user'], $_POST['pass'], $_POST['galassia'], $_POST['x'], $_POST['y']) && preg_match(USER_MATCH, $_POST['user']) && preg_match(PASS_MATCH, $_POST['pass']) )
	{
		$user = addslashes($_POST['user']);
		$pass = md5(addslashes($_POST['pass']));

		$db = new DATABASE($db_host, $db_user, $db_pass, $db_name);

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
				$data = stripslashes($_POST['galassia']);
				$planet['x'] = ( (int)$_POST['x'] < 10 ) ? '0' . (int)$_POST['x'] : (int)$_POST['x'];
				$planet['y'] = ( (int)$_POST['y'] < 10 ) ? '0' . (int)$_POST['y'] : (int)$_POST['y'];
				$lines = explode("\n", $data);
				$n = count($lines);
				$c = 0;
				$date = time();
				$fkplayerud = $query_result[0];
				
/*				$file = fopen(date("ymd").'.txt', "wb");
				fwrite($file, $data);
				fclose($file);
*/				
				$info = 2;

				while ( $c < $n )
				{
					$s = preg_match(GALAXY, $lines[$c], $matches);
		
					if ( $s )
					{
						$planet['z'] = ( $matches[1] < 10 ) ? '0' . $matches[1] : $matches[1];
						$player['ally'] = addslashes(trim($matches[2]));
						$planet['name'] = addslashes(trim($matches[3]));
						$player['name'] = addslashes(trim($matches[4]));
						$player['old_name'] = addslashes(trim($matches[5]));

						if ( $player['name'] !== '' )
						{
							$info = 1;
							
							$stat = preg_match(STATUS, $player['name'], $matches);
							
							if ( $stat )
							{
								$matches[1] = preg_replace("/p/", "", $matches[1]);
				
								switch ($matches[1])
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
								
								$player['name'] = preg_replace('/\s+&nbsp;\s+\(' . $matches[1] . '\)/', '', $player['name']);
								$player['old_name'] = preg_replace('/\s+&nbsp;\s+\(' . $matches[1] . '\)/', '', $player['old_name']);
							}
							else
								$player['status'] = 0;
								
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
									status = '{$player['status']}'
									WHERE id = '{$player['id']}'"
								);
							else
							{
								$db->query(
									"INSERT INTO " . DB_PLAYERS_TABLE . "
									(nick, ally, date, status)
									VALUES
									('{$player['name']}', '{$player['ally']}', '$date', '{$player['status']}')"
								);
								
								$player['id'] = mysql_insert_id();
							}
							
							$db->query(
								"REPLACE " . DB_PLANETS_TABLE . "
								SET fkplayer = '{$player['id']}',
								name = '{$planet['name']}',
								x = '{$planet['x']}',
								y = '{$planet['y']}',
								z = '{$planet['z']}',
								date = '$date',
								fkplayerud = '$fkplayerud'"
							);
						}
						else
							$db->query(
								"DELETE FROM " . DB_PLANETS_TABLE . "
								WHERE x = '{$planet['x']}'
								AND y = '{$planet['y']}'
								AND z = '{$planet['z']}'"
							);
					}
						
					$c++;
				}
			}
		}
		
		$db->close_db();
	}
?>
<xmlresponse>
    <info><?php echo $info; ?></info>
</xmlresponse>