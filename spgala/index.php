<?php
	error_reporting ( E_ALL );
	
	define('SPGDB_INC', true);
	
	require ( 'config.php' );
	
	if ( !isset($db_host) )
	{
		echo "<meta http-equiv='Refresh' content='0; url=install/index.php'>";
		exit;
	}
	
	require ( 'classes/mysql.class.php' );
	require ( 'classes/permissions.class.php' );
	require ( 'includes/commons.php' );
	$db = new DATABASE($db_host, $db_user, $db_pass, $db_name);
	$permissions = new permissions();
	require ( 'libs/session.lib.php' );
	$SESSION = check_session();
	
	$tag = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'tag'"
	);
								 
	$title = $tag . ' - ' . $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'name'"
	);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title; ?></title>
<link href="skins/default/css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="header">
  <div id="copy" align="right">&copy; <?php echo gmdate('Y'); ?> - <a href="mailto:capi@ogsteam.fr"><b>Capi </b></a> [ <a href="http://www.ogsteam.fr/" target="_blank">OGSteam</a> ]</div>
  
</div>
<div id="buttons">
  <ul>
    <li><a href="index.php<?php echo ( isset($SESSION['SID']) ) ? '?si=' . $SESSION['SID'] : ''; ?>">Home</a></li>
    <?php
			if ( $SESSION !== false )
			{
				echo '<li><a href="index.php?section=search&si=' . $SESSION['SID'] . '">' . TABLE_SEARCH . '</a></li>' . "\n";
				echo '<li><a href="index.php?section=ranking&si=' . $SESSION['SID'] . '">' . TABLE_RANKING . '</a></li>' . "\n";
				echo '<li><a href="index.php?section=compare&si=' . $SESSION['SID'] . '">' . TABLE_COMPARE . '</a></li>' . "\n";
				echo '<li><a href="index.php?section=spyreport&si=' . $SESSION['SID'] . '">' . TABLE_SPYREPORT . '</a></li>' . "\n";
				echo '<li><a href="index.php?section=map&si=' . $SESSION['SID'] . '">' . TABLE_MAP . '</a></li>' . "\n";
				echo '<li><a href="index.php?section=logout&si=' . $SESSION['SID'] . '">Logout</a></li>' . "\n";
				/*echo '<li><a href="SPGdb_Tool_1.5revFR.20070625_AJAX.zip">Download</a></li>' . "\n";*/

				if ( $SESSION['PERMISSIONS']['Admin'] === true )
					echo '<li><a href="index.php?section=admin&si=' . $SESSION['SID'] . '">' . TABLE_ADMIN . '</a></li>' . "\n";
			}
			else
			{
				echo '<li><a href="index.php?section=registration">' . TABLE_REGISTRATION . '</a></li>' . "\n";
				echo '<li><a href="index.php?section=login">Login</a></li>' . "\n";
			}
		?>
  </ul>
</div>
<div style=" clear:both;">
  <?php
	if ( isset($_REQUEST['section']) )
	{
		switch ($_REQUEST['section'])
		{
			case 'login':
				require ( 'login.php' );
				break;
			case 'logout':
				$response = logout();
				if ( $response === false )
					echo "<meta http-equiv='Refresh' content='0; url=index.php'>";
				break;
			case 'registration':
				require ( 'register.php' );
				break;
			case 'ranking':
				if ( $SESSION === false || $SESSION['PERMISSIONS']['ShowStats'] === false )
					echo NO_PERMISSIONS;
				else
					require ( 'ranking.php' );
				break;
			case 'compare':
				if ( $SESSION === false || $SESSION['PERMISSIONS']['ShowStatsEx'] === false )
					echo NO_PERMISSIONS;
				else
					require ( 'compare.php' );
				break;
			case 'search':
				if ( $SESSION === false || $SESSION['PERMISSIONS']['ShowPlayer'] === false )
					echo NO_PERMISSIONS;
				else
					require ( 'search.php' );
				break;
			case 'map':
				if ( $SESSION === false || $SESSION['PERMISSIONS']['ShowMap'] === false )
					echo NO_PERMISSIONS;
				else
					require ( 'gmap.php' );
				break;
			case 'results':
				if ( $SESSION === false || $SESSION['PERMISSIONS']['ShowPlayer'] === false )
					echo NO_PERMISSIONS;
				else
					require ( 'results.php' );
				break;
			case 'player':
				if ( $SESSION === false || $SESSION['PERMISSIONS']['ShowStatsEx'] === false )
					echo NO_PERMISSIONS;
				else
					require ( 'player.php' );
				break;
			case 'spyreport':
				if ( $SESSION === false || $SESSION['PERMISSIONS']['UpdDb'] === false )
					echo NO_PERMISSIONS;
				else
					require ( 'spyreport.php' );
				break;
			case 'admin':
				if ( $SESSION === false || $SESSION['PERMISSIONS']['Admin'] === false )
					echo NO_PERMISSIONS;
				else
					require ( 'admin.php' );
				break;
			default:
				require ( 'home.php' );
		}
	}
	else
		require ( 'home.php' );

	$db->close_db();
  ?>
</div>
</body>
</html>
