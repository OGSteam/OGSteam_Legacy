<?php
	require ( 'config.php' );
	require ( 'classes/mysql.class.php' );
	require ( 'classes/permissions.class.php' );
	require ( 'includes/commons.php' );
	$db = new DATABASE($db_host, $db_user, $db_pass, $db_name);
	$permissions = new permissions();
	require ( 'libs/session.lib.php' );
	$SESSION = check_session();

	if ( $SESSION === false || $SESSION['PERMISSIONS']['ShowMap'] === false )
		exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<script type="text/javascript">
if( top.frames.length == 0 ) location.href = "about:blank";
</script>
</head>
<body style="background: #000; color: #fff; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;">
<?php
	if ( isset($_GET['x'], $_GET['y']) )
	{
		$list = $db->query(
			"SELECT DISTINCT nick, ally, z, name
			FROM " . DB_PLAYERS_TABLE . ", " . DB_PLANETS_TABLE . "
			WHERE x = '" . (int)$_GET['x'] . "'
			AND y = '" . (int)$_GET['y'] . "'
			AND " . DB_PLAYERS_TABLE . ".id = fkplayer
			ORDER BY x, y, z"
		);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="3">
  <tr>
    <td colspan="2"><strong><?php  echo MAP_SYSTEM . ' ' . (int)$_GET['x'] . ':' . (int)$_GET['y']; ?></strong></td>
  </tr>
<?php
		$i = 0;
	
		while ( $row = mysql_fetch_array($list) )
		{
			if ( $i == 0 )
				echo '<tr>' . "\n";
	
			echo '<td>' . $row['z'] . '. ' . $row['nick'] . ' [' . $row['ally'] . '] (' . $row['name'] . ')' . "\n";
			
			$i++;
			
			if ( $i == 2 )
			{
				echo '</tr>' . "\n";
				$i = 0;
			}		
		}
?>
</table>
<?php
	}
?>
</body>
</html>
