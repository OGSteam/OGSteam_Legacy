<?php
	if ( !isset($_GET['id1'], $_GET['id2'], $_GET['what']) )
		exit;
		
	require ( 'config.php' );
	require ( 'classes/mysql.class.php' );
	require ( 'classes/permissions.class.php' );
	require ( 'includes/commons.php' );
	$db = new DATABASE($db_host, $db_user, $db_pass, $db_name);
	$permissions = new permissions();
	require ( 'libs/session.lib.php' );
	$SESSION = check_session();

	if ( $SESSION === false || $SESSION['PERMISSIONS']['ShowStatsEx'] === false )
		exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Chart</title>
</head>
<body style="margin: 0px;">
<?php
	switch ( $_GET['what'] )
	{
		case 'tot':
			$what = 'tot';
			break;
		case 'build':
			$what = 'build';
			break;
		case 'res':
			$what = 'res';
			break;
		case 'fleetdef':
			$what = 'fleetdef';
			break;
		default:
			$what = 'tot';
			break;
	}

	require ( 'charts/charts.php' );

	echo InsertChart('charts/charts.swf', 'charts/charts_library', 'includes/chart2.php?id1=' . $_GET['id1'] . '&id2=' . $_GET['id2'] . '&what=' . $what . '&si=' . $SESSION['SID'], 400, 250, '555555');
?>
</body>
</html>
