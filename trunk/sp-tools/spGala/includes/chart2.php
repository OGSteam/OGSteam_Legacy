<?php
	if ( !isset($_GET['id1'], $_GET['id2'], $_GET['what']) )
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
	
	$player1_id = (int)$_GET['id1'];
	$player2_id = (int)$_GET['id2'];
	
	/* --== Calculer le premier et le dernier rang pour considerer l'id  ==-- */
	$player1_minmax_n = $db->first_row(
		"SELECT MIN(n), MAX(n)
		FROM " . DB_STATS_TABLE . "
		WHERE fkplayer = '$player1_id'"
	);

	$player1_min_n = $player1_minmax_n[0];
	$player1_max_n = $player1_minmax_n[1];
	
	$player2_minmax_n = $db->first_row(
		"SELECT MIN(n), MAX(n)
		FROM " . DB_STATS_TABLE . "
		WHERE fkplayer = '$player2_id'"
	);

	$player2_min_n = $player2_minmax_n[0];
	$player2_max_n = $player2_minmax_n[1];
	
	$chart_min_n = min($player1_min_n, $player2_min_n);
	$chart_max_n = max($player1_max_n, $player2_max_n);
	
	/* --== Obtien les points player1 ==-- */
	$player1_pts = $db->query(
		"SELECT n, " . $what . "
		FROM " . DB_STATS_TABLE . "
		WHERE fkplayer = '$player1_id'
		AND n BETWEEN '$chart_max_n'-299 AND '$chart_max_n'
		ORDER BY n"
	);
	
	$player1_pts_arr = array();

	while ( $row = mysql_fetch_array($player1_pts) )
		$player1_pts_arr[$row['n']] = $row[$what];
		
	/* --== Obtien les points player2==-- */
	$player2_pts = $db->query(
		"SELECT n, " . $what . "
		FROM " . DB_STATS_TABLE . "
		WHERE fkplayer = '$player2_id'
		AND n BETWEEN '$chart_max_n'-299 AND '$chart_max_n'
		ORDER BY n"
	);
	
	$player2_pts_arr = array();

	while ( $row = mysql_fetch_array($player2_pts) )
		$player2_pts_arr[$row['n']] = $row[$what];
	
	/* --== Calculate X Axis' values ==-- */
	$player1_x = array($player1_name = $db->first_result(
		"SELECT nick
		FROM " . DB_PLAYERS_TABLE . "
		WHERE id = '$player1_id'"
	));

	$player2_x = array($player2_name = $db->first_result(
		"SELECT nick
		FROM " . DB_PLAYERS_TABLE . "
		WHERE id = '$player2_id'"
	));

	$x = 1;
	$player1_tmp = ( isset($player1_pts_arr[$chart_min_n]) ) ? $player1_pts_arr[$chart_min_n] : 0;
	$player2_tmp = ( isset($player2_pts_arr[$chart_min_n]) ) ? $player2_pts_arr[$chart_min_n] : 0;
	
	for ( $i = $chart_min_n; $i <= $chart_max_n; $i++ )
	{
		if ( isset($player1_pts_arr[$i]) )
		{
			$player1_x[$x] = $player1_pts_arr[$i];
			$player1_tmp = $player1_pts_arr[$i];
		}
		else
			$player1_x[$x] = $player1_tmp;
		
		if ( isset($player2_pts_arr[$i]) )
		{
			$player2_x[$x] = $player2_pts_arr[$i];
			$player2_tmp = $player2_pts_arr[$i];
		}
		else
			$player2_x[$x] = $player2_tmp;	
		
		$x++;
	}

	/* #--== Create chart ==--# */
	$start_date = $db->first_result(
		"SELECT max(date)
		FROM ". DB_STATS_TABLE . "
		WHERE n = '$chart_min_n'"
	);

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

	$axis_x  = array("");
	$min = min(min(array_slice($player1_x, 1)), min(array_slice($player2_x, 1)));
	$max = max(max(array_slice($player1_x, 1)), max(array_slice($player2_x, 1)));
	$cols = count($player1_x)-1;

	for ($i = 1; $i <= $cols; $i++)
		$axis_x[] = $i;
	
	include '../charts/charts.php';
	
	$chart['chart_data'] = array( $axis_x, $player1_x, $player2_x);
	
	$chart['chart_type'] = "Line";
	$chart['chart_rect'] = array('x' => 73, 'y' => 30, 'width' => 327, 'height' => 180);
	$chart['chart_grid_h'] = array('alpha' => 20, 'color' => "000000", 'thickness' => 1, 'type' => "solid");
	$chart['chart_grid_v'] = array('alpha' => 0);
	$chart['chart_pref'] = array('point_shape' => 'none', 'line_thickness' => 1, 'fill_shape' => false);
	$chart['chart_value'] = array('alpha' => 75, 'position' => 'cursor', 'separator' => '.');
	$chart['chart_transition'] = array('type' => 'scale');
	
	$chart['axis_value'] = array('min' => $min, 'max' => $max, 'steps' => 10, 'separator' => '.', 'orientation' => 'diagonal_up');
	$chart['axis_category'] = array('alpha' => 0);
	$chart['axis_ticks'] = array('value_ticks' => true, 'category_ticks' => false, 'major_thickness' => 2, 'minor_thickness' => 1, 'minor_count' => 5, 'major_color' => "000000", 'minor_color' => "222222" ,'position' => "outside" );
	
	$chart['draw'] = array(array( 'type' => "rect", 'fill_color' => '666666', 'fill_alpha' => 100, 'x' => 73, 'y' => 0, 'width' => 327, 'height' => 17, 'layer' => 'background'),
						   array( 'type' => "circle", 'fill_color' => '666666', 'fill_alpha' => 100, 'x' => 83, 'y' => 17, 'radius' => 10, 'layer' => 'background'),
						   array( 'type' => "circle", 'fill_color' => '666666', 'fill_alpha' => 100, 'x' => 390, 'y' => 17, 'radius' => 10, 'layer' => 'background'),
						   array( 'type' => "rect", 'fill_color' => '666666', 'fill_alpha' => 100, 'x' => 83, 'y' => 10, 'width' => 307, 'height' => 17, 'layer' => 'background'),
						   
						   array( 'type' => "rect", 'fill_color' => 'BBBBBB', 'fill_alpha' => 100, 'x' => 170, 'y' => 230, 'width' => 230, 'height' => 20, 'layer' => 'background'),
						   array( 'type' => "circle", 'fill_color' => 'BBBBBB', 'fill_alpha' => 100, 'x' => 170, 'y' => 240, 'radius' => 10, 'layer' => 'background'),
						   array( 'type' => "text", 'color' => '555555', 'alpha' => 100, 'font' => "arial", 'rotation' => 0, 'bold' => false, 'size' => 10, 'x' => 1, 'y' => 233, 'width' => 390, 'height' => 300, 'text' => 'Dal: ' . gmstrftime("%d/%m/%Y, %H:%M:%S", $start_date) . '. N. Classifiche: ' . $cols, 'h_align' => "right", 'v_align' => "top", 'layer' => 'background'),
						   array( 'type' => "text", 'color' => 'FFFFFF', 'alpha' => 100, 'font' => "arial", 'rotation' => 0, 'bold' => false, 'size' => 10, 'x' => 0, 'y' => 232, 'width' => 390, 'height' => 300, 'text' => 'Dal: ' . gmstrftime("%d/%m/%Y, %H:%M:%S", $start_date) . '. N. Classifiche: ' . $cols, 'h_align' => "right", 'v_align' => "top", 'layer' => 'background'),

						   array( 'type' => "rect", 'fill_color' => 'BBBBBB', 'fill_alpha' => 100, 'x' => 0, 'y' => 0, 'width' => 23, 'height' => 250, 'layer' => 'background'),
						   array( 'type' => "text", 'color' => '555555', 'alpha' => 100, 'font' => "arial", 'rotation' => -90, 'bold' => true, 'size' => 30, 'x' => -6, 'y' => 250, 'width' => 300, 'height' => 150, 'text' => $text, 'h_align' => "left", 'v_align' => "top", 'layer' => 'background' ));
	
	$chart['legend_rect'] = array('x' => 85, 'y' =>  10, 'width' => 280, 'height' => 10, 'margin' => 0, 'fill_alpha' => 0); 
	$chart['legend_label'] = array('alpha' => 100, 'bold' => false, 'bullet' => 'line', 'color' => 'FFFFFF');
	$chart['series_color'] = array('4F91B3', '009900');
	
	SendChartData($chart);
	
	$db->close_db();
?>