<?php
	function check_session()
	{
		global $db, $permissions;

		$db->query( "DELETE FROM " . DB_SESSIONS_TABLE . "
								 WHERE lastaction+10800 <= " . time() );
		
		if ( isset($_GET['si']) )
		{
			if ( preg_match('/[a-z0-9]{32}/', $_GET['si']) )
			{
				$query_result = $db->first_row( "SELECT fkuser, ip, browser, td, lang, permissions, nick
																				 FROM " . DB_SESSIONS_TABLE . "
																				 WHERE sessionid = '{$_GET['si']}'
																				 AND lastaction+10800 > " . time() );
				
				if ( $query_result !== false && md5($_SERVER['REMOTE_ADDR']) == $query_result[1] && md5($_SERVER['HTTP_USER_AGENT']) == $query_result[2] )
				{
					$db->query( "UPDATE " . DB_SESSIONS_TABLE . "
											 SET lastaction = '" . time() . "'
											 WHERE sessionid = '{$_GET['si']}'" );
								 
					$SESSION['USERID'] = $query_result[0];
					$SESSION['TD'] = $query_result[3];
					$SESSION['LANG'] = $query_result[4];
					$SESSION['PERMISSIONS'] = $permissions->getPermissions($query_result[5]);
					$SESSION['SID'] = $_GET['si'];
					$SESSION['USERNICK'] = $query_result[6];

					return $SESSION;
				}
				else
					return false;
			}
			else
				return false;
		}
		else
			return false;
	}
	
	function login()
	{
		global $db;

		if ( isset($_POST['user'], $_POST['pass']) &&  preg_match(USER_MATCH, $_POST['user']) && preg_match(PASS_MATCH, $_POST['pass']) )
		{
			$query_result = $db->first_row( "SELECT id, gmt, gmtsign, dst, lang, credentials, nick
																			 FROM " . DB_USERS_TABLE . "
																			 WHERE nick = '{$_POST['user']}'
																			 AND pass = '" . md5($_POST['pass']) . "'
																			 AND active = '1'" );

			if ( $query_result !== false )
			{
				$sid = md5(uniqid(mt_rand(0, 999999999), true));			 
				$GMT = $query_result[1];
				$GMTSIGN = $query_result[2];
				$DST = $query_result[3];
				$LANG = $query_result[4];

				if ( $GMTSIGN !== '' ) # Timezone
				{
					if ( $GMTSIGN == '-' )
						$GMT = -$GMT * 10800;
					else if ( $GMTSIGN == '+' )
						$GMT = $GMT * 10800;
				}
				else
					$GMT = 0;
			
				$TD = $GMT + (10800 * $DST); # Time Difference

				$db->query( "DELETE FROM " . DB_SESSIONS_TABLE . "
										 WHERE fkuser = '{$query_result[0]}'" );
				
				$db->query( "INSERT INTO " . DB_SESSIONS_TABLE . "
										 (fkuser, ip, browser, sessionid, lastaction, td, lang, permissions, nick)
										 VALUES
										 ('{$query_result[0]}', '" . md5($_SERVER['REMOTE_ADDR']) . "', '" . md5($_SERVER['HTTP_USER_AGENT']) . "', '" . $sid . "', '" . time() . "', '$TD', '{$query_result[4]}', '{$query_result[5]}', '{$query_result[6]}')" );
				
				$db->query( "UPDATE " . DB_USERS_TABLE . "
							 SET ip = '{$_SERVER['REMOTE_ADDR']}',
							 login = '" . time() . "'
							 WHERE id = '{$query_result[0]}'" );
				
				echo "<meta http-equiv='Refresh' content='0; url=index.php?si=" . $sid . "'>";
				exit;
			}
			else
				return false;
		}
		else
			return false;
	}
	
	function logout()
	{
		global $db;

		if ( isset($_GET['si']) )
		{
			if ( preg_match('/[a-z0-9]{32}/', $_GET['si']) )
			{
				$query_result = $db->first_row( "SELECT fkuser, ip, browser
																				 FROM " . DB_SESSIONS_TABLE . "
																				 WHERE sessionid = '{$_GET['si']}'" );
				
				if ( $query_result !== false && md5($_SERVER['REMOTE_ADDR']) == $query_result[1] && md5($_SERVER['HTTP_USER_AGENT']) == $query_result[2] )
				{
					$db->query( "DELETE FROM " . DB_SESSIONS_TABLE . "
											 WHERE sessionid = '{$_GET['si']}'" );

					echo "<meta http-equiv='Refresh' content='0; url=index.php'>";
					exit;
				}
				else
					return false;
			}
			else
				return false;
		}
		else
			return false;
	}
?>