<?php
	if ( !isset($_GET['id'], $_GET['what']) )
		exit;

	require ( '../config.php' );
	require ( '../classes/mysql.class.php' );
	require ( '../classes/permissions.class.php' );
	require ( '../includes/commons.php' );
	require ( '../libs/session.lib.php' );

	$db = new DATABASE($db_host, $db_user, $db_pass, $db_name);
	$permissions = new permissions();
	$SESSION = check_session();

	if ( $SESSION === false || $SESSION['PERMISSIONS']['ShowStatsEx'] === false )
		exit;
	
	$player_id = (int)$_GET['id'];

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

	$maxrankings = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'maxrankings'"
	);

	$player_name = $db->first_result(
		"SELECT nick
		FROM " . DB_PLAYERS_TABLE . "
		WHERE id = '$player_id'"
	);

	$last_ranking_id = $db->first_result(
		"SELECT MAX(n)
		FROM " . DB_STATS_TABLE
	);

	$last_player_ranking_id = $db->first_result(
		"SELECT MAX(n)
		FROM " . DB_STATS_TABLE . "
		WHERE fkplayer = '$player_id'"
	);
	
	if ( $last_player_ranking_id !== false)
	{
		$query_result = $db->query(
			"SELECT " . $what . "
			FROM ". DB_STATS_TABLE . "
			WHERE fkplayer = '$player_id'
			AND n BETWEEN '$last_ranking_id'-399
			AND '$last_player_ranking_id'"
		);
		
		$start_date = $db->first_result(
			"SELECT date
			FROM ". DB_STATS_TABLE . "
			WHERE fkplayer = '$player_id'
			AND n = '$last_player_ranking_id'"
		);
		
		$cols = mysql_num_rows($query_result);
		$axis_x = array('');
		$axis_y = array('Points');
	
		for ($i = 1; $i <= $cols; $i++)
			$axis_x[] = $i;

		while ( $row = mysql_fetch_array($query_result) )
			$axis_y[] = $row[$what];

		$minmax = $db->first_row(
			"SELECT MIN(" . $what . "), MAX(" . $what . ")
			FROM " . DB_STATS_TABLE . "
			WHERE fkplayer = '$player_id'
			AND n BETWEEN '$last_ranking_id'-399
			AND '$last_player_ranking_id'"
		);

		$min = $minmax[0];
		$max = $minmax[1];
		
		/*$max = $db->first_result(
			"SELECT MAX(" . $what . ")
			FROM " . DB_STATS_TABLE . "
			WHERE n BETWEEN '$last_ranking_id'-" . ($maxrankings-1) . "
			AND '$last_player_ranking_id'"
		);

		$min = 0;*/

		switch($what)
		{
			case 'tot':
				$text = CHART_TOTAL;
				break;
			case 'build':
				$text = CHART_BUILD;
				break;
			case 'res':
				$text = CHART_RESEARCH;
				break;
			case 'fleetdef':
				$text = CHART_FLEET_DEFENSE;
				break;
		}
	
		include '../charts/charts.php';
		
		$chart['chart_data'] = array( $axis_x, $axis_y);
		
		$chart['chart_type'] = "Line";
		$chart['chart_rect'] = array('x' => 73, 'y' => 25, 'width' => 327, 'height' => 180);
		$chart['chart_grid_h'] = array('alpha' => 20, 'color' => "000000", 'thickness' => 1, 'type' => "solid");
		$chart['chart_grid_v'] = array('alpha' => 0/*, 'color' => "000000", 'thickness' => 1, 'type' => "solid"*/);
		$chart['chart_pref'] = array('point_shape' => 'none', 'line_thickness' => 1, 'fill_shape' => false);
		$chart['chart_value'] = array('alpha' => 75, 'position' => 'cursor', 'separator' => '.');
		$chart['chart_transition'] = array('type' => 'scale');
		
		$chart['axis_value'] = array('min' => $min, 'max' => $max, 'steps' => 10, 'separator' => '.', 'orientation' => 'diagonal_up');
		$chart['axis_category'] = array('alpha' => 0);
		$chart['axis_ticks'] = array('value_ticks' => true, 'category_ticks' => false, 'major_thickness' => 2, 'minor_thickness' => 1, 'minor_count' => 5, 'major_color' => "000000", 'minor_color' => "222222" ,'position' => "outside" );
		
		$chart['legend_rect'] = array('x' => -100, 'y' =>  -100, 'width' => 10, 'height' => 10, 'margin' => 10 ); 
		
		$chart['draw'] = array(array( 'type' => "text", 'color' => $chart_cfg['name_color'], 'alpha' => 100, 'font' => "arial", 'rotation' => 0, 'bold' => true, 'size' => 50, 'x' => 65, 'y' => 200, 'width' => 500, 'height' => 300, 'text' => $player_name, 'h_align' => "left", 'v_align' => "top", 'layer' => 'background' ),

							   array( 'type' => "rect", 'fill_color' => 'BBBBBB', 'fill_alpha' => 100, 'x' => 0, 'y' => 0, 'width' => 23, 'height' => 250, 'layer' => 'background'),
							   array( 'type' => "text", 'color' => '555555', 'alpha' => 100, 'font' => "arial", 'rotation' => -90, 'bold' => true, 'size' => 30, 'x' => -6, 'y' => 250, 'width' => 300, 'height' => 150, 'text' => $text, 'h_align' => "left", 'v_align' => "top", 'layer' => 'background' ),

							   array( 'type' => "rect", 'fill_color' => 'BBBBBB', 'fill_alpha' => 100, 'x' => 170, 'y' => 0, 'width' => 230, 'height' => 20, 'layer' => 'background'),
							   array( 'type' => "circle", 'fill_color' => 'BBBBBB', 'fill_alpha' => 100, 'x' => 170, 'y' => 10, 'radius' => 10, 'layer' => 'background'),
							   array( 'type' => "text", 'color' => '555555', 'alpha' => 100, 'font' => "arial", 'rotation' => 0, 'bold' => false, 'size' => 10, 'x' => 1, 'y' => 3, 'width' => 390, 'height' => 300, 'text' => 'Dal: ' . gmstrftime("%d/%m/%Y, %H:%M:%S", $start_date) . '. N. Classifiche: ' . ($cols-1), 'h_align' => "right", 'v_align' => "top", 'layer' => 'background'),
							   array( 'type' => "text", 'color' => 'FFFFFF', 'alpha' => 100, 'font' => "arial", 'rotation' => 0, 'bold' => false, 'size' => 10, 'x' => 0, 'y' => 2, 'width' => 390, 'height' => 300, 'text' => 'Dal: ' . gmstrftime("%d/%m/%Y, %H:%M:%S", $start_date) . '. N. Classifiche: ' . ($cols-1), 'h_align' => "right", 'v_align' => "top", 'layer' => 'background'),);
		
		$chart['series_color'] = array('4F91B3', '009900');
		
		SendChartData($chart);
	}
	
	$db->close_db();
?>