<?php
	if( ini_get('safe_mode') )
		ini_set('max_execution_time', '36000');
	else
		set_time_limit(0);

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
	
	function show_player_position($what, $query)
	{
		global $z, $a, $e, $m;
		
		if ( $what !== 'status' )
		{
			switch($what)
			{
				case 'friend':
					$ico = 'green';
					break;
				case 'enemy':
					$ico = 'blue';
					break;
				case 'ally':
					$ico = 'red';
					break;
			}
		}

		while ($row = mysql_fetch_array($query))
		{
			if ( $what == 'status' )
			{
				if ( (time() - $row['date']) >= 2592000 )
					$ico = '5';
				else if ( (time() - $row['date']) >= 1296000 )
					$ico = '4';
				else if ( (time() - $row['date']) >= 604800 )
					$ico = '3';
				else if ( (time() - $row['date']) >= 172800 )
					$ico = '2';
				else if ( (time() - $row['date']) < 172800 )
					$ico = '1';
			}
			
			$x = $row['x'];
			$y = $row['y'];
			
			$x_fixed = ($x <= 9) ? "0".$x : $x;
			$y_fixed = ($y <= 9) ? "0".$y : $y;

			$x_pos = ($x*7)-7;
			$y_pos = ($y*7)-7;

			echo '<div class="point" style="background:url(images/' . $ico . '.gif) center;left: ' . $x_pos . 'px;top: ' . $y_pos . 'px;z-index: ' . $z . ';"></div>' . "\n";
			$z++;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
#container{left:40%;margin-top:-40px;padding:0;position:absolute;top:50%}
#pointer{border:solid 1px #FFF;height:5px;position:absolute;width:5px;z-index:10000003}
#table{-moz-opacity:0.5px;background-color:#FFF;color:red;filter:alpha(opacity=50);font-family:Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:700;height:12px;opacity:.50;position:absolute;width:33px;z-index:10000000}
#x{background-color:#FFF;height:1px;left:0;position:absolute;width:693px;z-index:10000001}
#y{background-color:#FFF;height:693px;position:absolute;top:0;width:1px;z-index:10000002}
.point{height:7px;position:absolute;width:7px}
</style>
<script language="javascript">
	if( top.frames.length == 0 ) location.href = "about:blank";

	var IE = document.all?true:false
	
	document.onmousemove = coords;
	document.onclick = showlist;

	var tempX = 0
	var tempY = 0
		
	function coords(e) {
		if (IE)
		{
			tempX = parseInt(event.clientX/7)*7 + document.body.scrollLeft;
			tempY = parseInt(event.clientY/7)*7 + document.body.scrollTop;
		}
		else
		{
			tempX = parseInt(e.pageX/7)*7;
			tempY = parseInt(e.pageY/7)*7;
		}  
		
		if (tempX < 0)
			tempX = 0
		if (tempY < 0)
			tempY = 0
		
		document.getElementById("pointer").style.left = tempX+"px";
		document.getElementById("pointer").style.top = tempY+"px";
		document.getElementById("y").style.left = tempX+3+"px";
		document.getElementById("x").style.top = tempY+3+"px";
		t_height = 12;
		t_width  = 33;
		
		if ( tempX >= 350 ) document.getElementById("table").style.left = tempX-t_width-11+"px";
		else if ( tempX < 350 ) document.getElementById("table").style.left = tempX+18+"px";
		if ( tempY >= 350 ) document.getElementById("table").style.top = tempY-t_height-11+"px";
		else if ( tempY < 350 ) document.getElementById("table").style.top = tempY+18+"px";
		
		document.getElementById("coords_n").innerHTML = (tempX/7+1)+":"+(tempY/7+1);
	}
	
	function showlist()
	{
		var x = parseInt(tempX/7)+1;
		var y = parseInt(tempY/7)+1;
		
		top.frames[0].document.location = 'plist.php?x='+x+'&y='+y+'&si=<?php echo $SESSION['SID']; ?>';
	}
</script>
<link href="style/SPGdb_default.css" rel="stylesheet" type="text/css" />
</head>
<body style="background-color: #000; margin: 0px;">
<div id="pointer"><img src="images/spacer.gif" /></div>
<div id="x" style="top: 3px"><img src="images/spacer.gif" /></div>
<div id="y" style="left: 3px"><img src="images/spacer.gif" /></div>
<div id="table" style="top: 8px; left: 8px;">
	<div id="coords_n">1:1</div>
</div>
<?php
	$tag = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'tag'"
	);
	
	$z = 10;

	if ( isset($_POST['status']) )
	{
		$query = $db->query(
			"SELECT DISTINCT x, y, date
			FROM " . DB_PLANETS_TABLE . "
			ORDER BY x, y"
		);
		
		show_player_position('status', $query);
	}
	else if ( isset($_POST['a'], $_POST['e'], $_POST['m']) )
	{
		$a = addslashes(trim(stripslashes($_POST['a'])));
		$e = addslashes(trim(stripslashes($_POST['e'])));
		$m = addslashes(trim(stripslashes($_POST['m'])));

		$query = $db->query(
			"SELECT DISTINCT x, y
			FROM " . DB_PLAYERS_TABLE . ", " . DB_PLANETS_TABLE . "
			WHERE ally = '$a'
			AND " . DB_PLAYERS_TABLE . ".id = fkplayer
			AND ally <> ''
			ORDER BY x, y"
		);
		
		show_player_position('ally', $query);

		
		$query = $db->query(
			"SELECT DISTINCT x, y
			FROM " . DB_PLAYERS_TABLE . ", " . DB_PLANETS_TABLE . "
			WHERE " . DB_PLAYERS_TABLE . ".id = fkplayer
			AND nick = '$e'
			ORDER BY x, y"
		);

		show_player_position('enemy', $query);
		
		$query = $db->query(
			"SELECT DISTINCT x, y
			FROM " . DB_PLAYERS_TABLE . ", " . DB_PLANETS_TABLE . "
			WHERE ally = '$tag'
			AND " . DB_PLAYERS_TABLE . ".id = fkplayer
			AND nick = '$m'
			ORDER BY x, y"
		);

		show_player_position('friend', $query);
	}

	$db->close_db();
?>
</body>
</html>
