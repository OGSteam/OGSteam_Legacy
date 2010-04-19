<?php
	if ( !defined('SPGDB_INC') )
		 die('Do not access this file directly.');
?>
<script language="javascript" type="text/javascript">
<!--
	var IE = document.all?true:false
	
	document.onmousemove = coords;
	var tempX = 0
	var tempY = 0
	
	function coords(e)
	{
		if (IE)
		{
			tempX = event.clientX + document.body.scrollLeft;
			tempY = event.clientY + document.body.scrollTop;
		}
		else
		{
			tempX = e.pageX;
			tempY = e.pageY;
		}  
	
		if (tempX < 0)
			tempX = 0;
		if (tempY < 0)
			tempY = 0;
	
		document.getElementById('points_balloon').style.left = tempX+"px";
		document.getElementById('points_balloon').style.top  = (tempY-90)+"px";
	}
	
	function tips(on, a, b, c)
	{
		switch (on)
		{
			case 'false':
				document.getElementById('points_balloon').style.display = 'none';
				break;
			case 'true':
				var tbbody  = '<table border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #000000">';
				tbbody += '<tr><td style="padding: 1px" class="row1" align="right">Punteggio infrastrutture:</td><td style="padding: 1px" class="row2" align="left">'+a+'</td></tr>';
				tbbody += '<tr><td style="padding: 1px" class="row1" align="right">Punteggio ricerca:</td><td style="padding: 1px" class="row2" align="left">'+b+'</td></tr>';
				tbbody += '<tr><td style="padding: 1px" class="row1" align="right">Punteggio flotta/difesa:</td><td style="padding: 1px" class="row2" align="left">'+c+'</td></tr>';
				tbbody += '</table>';
				document.getElementById('points_balloon').innerHTML = tbbody;
				document.getElementById('points_balloon').style.display = '';
				break;
		}
	}
-->
</script>
<?php
	$form_inputs = '';
	
	#--== Set Results Per Page ==--#
	$prn = ( isset($_REQUEST['prn']) && ((int)$_REQUEST['prn'] == 10 || (int)$_REQUEST['prn'] == 25 || (int)$_REQUEST['prn'] == 50 || (int)$_REQUEST['prn'] == 100) ) ? (int)$_REQUEST['prn'] : 10;
	
	$form_inputs .= '<input type="hidden" value="' . $prn . '" name="prn" id="prn" />' . "\n";
	#--==========================--#
	
	#--== Set Ranking To Use ==--#
	$last_ranking_id = $db->first_result( "SELECT MAX(n)
										   FROM " . DB_STATS_TABLE );
	
	$rid = ( isset($_REQUEST['rid']) && (int)$_REQUEST['rid'] >= ($last_ranking_id - 59) && (int)$_REQUEST['rid'] <= $last_ranking_id ) ? (int)$_REQUEST['rid'] : $last_ranking_id;
	
	$form_inputs .= '<input type="hidden" value="' . $rid . '" name="rid" id="rid" />' . "\n";
	#--========================--#

	##----==== Query Creation ====----##
	$query_string = "SELECT fkplayer, nick, ally, class, status, tot, build, res, fleetdef, " . DB_STATS_TABLE . ".date
					 FROM " . DB_PLAYERS_TABLE . ", " . DB_STATS_TABLE . "
					 WHERE (n = '$rid')";

	#--== Filter By Name ==--#
	if ( isset($_REQUEST['player_name'], $_REQUEST['name_search']) )
	{
		$player['name'] = addslashes(trim(stripslashes($_REQUEST['player_name'])));
		
		$query_string .= " AND (nick LIKE '%{$player['name']}%')";
		
		$form_inputs .= '<input type="hidden" value="on" name="name_search" id="name_search" />' . "\n";
		$form_inputs .= '<input type="hidden" value="' . $player['name'] . '" name="player_name" id="player_name" />' . "\n";
	}
	#--====================--#
	
	#--== Filter By Alliance ==--#
	if ( isset($_REQUEST['player_ally'], $_REQUEST['ally_search']) )
	{
		$player['ally'] = addslashes(trim(stripslashes($_REQUEST['player_ally'])));
		
		$query_string .= " AND (ally = '{$player['ally']}')";
		
		$form_inputs .= '<input type="hidden" value="on" name="ally_search" id="ally_search" />'."\n";
		$form_inputs .= '<input type="hidden" value="' . $player['ally'] . '" name="player_ally" id="player_ally" />' . "\n";
	}
	#--========================--#

	#--== Filter By Fleet Points ==--#
	if ( isset($_REQUEST['min'], $_REQUEST['max'], $_REQUEST['point_search']) )
	{		
		$query_string .= " AND (fleetdef BETWEEN '" . (int)$_REQUEST['min'] . "' AND '" . (int)$_REQUEST['max'] . "')";
		
		$form_inputs .= '<input type="hidden" value="on" name="point_search" id="point_search" />'."\n";
		$form_inputs .= '<input type="hidden" value="' . (int)$_REQUEST['min'] . '" name="min" id="min" />'."\n";
		$form_inputs .= '<input type="hidden" value="' . (int)$_REQUEST['max'] . '" name="max" id="max" />'."\n";
	}
	#--============================--#

	#--== Filter By Player Status ==--#
	if ( isset($_REQUEST['status_search']) )
	{	
		$status_list = '(';
		
		if ( isset($_REQUEST['g']) )
		{
			$status_list .= "'1', ";
			$form_inputs .= '<input type="hidden" value="on" name="g" id="g" />' . "\n";
		}
		
		if ( isset($_REQUEST['i']) )
		{
			$status_list .= "'2', ";
			$form_inputs .= '<input type="hidden" value="on" name="i" id="i" />' . "\n";
		}
		
		if ( isset($_REQUEST['u']) )
		{
			$status_list .= "'3', ";
			$form_inputs .= '<input type="hidden" value="on" name="u" id="u" />' . "\n";
		}
		
		if ( isset($_REQUEST['gu']) )
		{
			$status_list .= "'4', ";
			$form_inputs .= '<input type="hidden" value="on" name="gu" id="gu" />' . "\n";
		}
		
		if ( isset($_REQUEST['iu']) )
		{
			$status_list .= "'5', ";
			$form_inputs .= '<input type="hidden" value="on" name="iu" id="iu" />' . "\n";
		}
		
		if ( isset($_REQUEST['a']) )
		{
			$status_list .= "'0', ";
			$form_inputs .= '<input type="hidden" value="on" name="a" id="a" />' . "\n";
		}
		
		$status_list .= ')';

		$status_list = preg_replace("/, \)/", ")", $status_list);
		
		if ( $status_list !== '()' )
			$query_string .= " AND (status IN " . $status_list . ")";

		$form_inputs .= '<input type="hidden" value="on" name="status_search" id="status_search" />' . "\n";
	}
	#--=============================--#

	#--== Filter By Planets Position ==--#
	if ( isset($_REQUEST['xp'], $_REQUEST['yp'], $_REQUEST['xa'], $_REQUEST['ya'], $_REQUEST['area_search']) )
	{
		$xp = (int)$_REQUEST['xp'];
		$yp = (int)$_REQUEST['yp'];
		$xa = (int)$_REQUEST['xa'];
		$ya = (int)$_REQUEST['ya'];

		if ( $xp == 0 )
			$xp = 1;

		if ( $yp == 0 )
			$yp = 1;

		if ( $xa == 0 )
			$xa = 1;

		if ( $ya == 0 )
			$ya = 1;


		if ( $xp > $xa )
		{
			$temp = $xa;
			$xa = $xp;
			$xp = $temp;
		}

		if ( $yp > $ya )
		{
			$temp = $ya;
			$ya = $yp;
			$yp = $temp;
		}

		$query = $db->query(" SELECT DISTINCT(fkplayer)
							  FROM " . DB_PLANETS_TABLE . "
							  WHERE (x BETWEEN '$xp' AND '$xa')
							  AND (y BETWEEN '$yp' AND '$ya')" );
		$ids_list = '(';
		
		while ( $row = mysql_fetch_array($query) )
			$ids_list.= "'" . $row[0] . "', ";
		
		$ids_list .= ")";

		$ids_list = preg_replace("/, \)/", ")", $ids_list);

		$query_string .= " AND (" . DB_PLAYERS_TABLE . ".id IN " . $ids_list . ")";

		$form_inputs .= '<input type="hidden" value="on" name="area_search" id="area_search" />' . "\n";
		$form_inputs .= '<input type="hidden" value="' . $xp . '" name="xp" id="xp" />' . "\n";
		$form_inputs .= '<input type="hidden" value="' . $yp . '" name="yp" id="yp" />' . "\n";
		$form_inputs .= '<input type="hidden" value="' . $xa . '" name="xa" id="xa" />' . "\n";
		$form_inputs .= '<input type="hidden" value="' . $ya . '" name="ya" id="ya" />' . "\n";
	}
	#--================================--#

	$query_string .= " AND (" . DB_PLAYERS_TABLE . ".id = fkplayer)
					  ORDER BY nick ASC, " . DB_STATS_TABLE . ".date DESC";
	##----========================----##

	#--== Set Page ==--#
	$query_result = $db->query($query_string);

	$search_rows_number = mysql_num_rows($query_result);
	$total_pages_number = ceil($search_rows_number / $prn);

	$page = ( isset($_REQUEST['page']) && (int)$_REQUEST['page'] > 0 && (int)$_REQUEST['page'] <= $total_pages_number ) ? (int)$_REQUEST['page'] : 1;
	#--==============--#
?>
<div id="points_balloon" style="position: absolute; top: 100px; left: 100px;"></div>
<table border="0" cellpadding="0" cellspacing="0" id="output_table" align="left">
	<tr>
		<td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="name" valign="middle"><?php echo TABLE_SEARCH_RESULT; ?></td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" colspan="13">
						<?php
							#--== Pages Menu ==--#
							echo '<form method="post" name="page_form" id="page_form" action="index.php?section=results&si=' . $SESSION['SID'] . '">' . "\n";
							echo $form_inputs;
							echo '<input type="hidden" name="si" id="si" value="' . $SESSION['SID'] . '" />' . "\n";
							
							echo '<select name="page" id="page" onchange="document.page_form.submit();">' . "\n";

							for ( $i = 1; $i <= $total_pages_number; $i++ )
							{
								echo '<option value="' . $i . '"';
								
								if ( $i == $page ) echo ' selected="selected"';
								
								echo '>' . (($i - 1) * $prn + 1) . ' - ' . ($i * $prn) .'</option>';
							}

							echo '</select>' . "\n";
							echo '</form>' . "\n";
							#--================--#
						?>
					</td>
				</tr>
				<tr>
					<td><img src="images/spacer.gif" width="1" height="5" /></td>
				</tr>
				<tr>
					<td class="label" align="center">#</td>
					<td class="spacer"></td>
					<td class="label" align="center"><?php echo $TABLE_TERMS['TOTAL_POINTS']; ?></td>
					<td class="spacer"></td>
					<td class="label" align="center"><?php echo $TABLE_TERMS['NAME'] . '[' . $TABLE_TERMS['ALLIANCE'] . ']'; ?></td>
					<td class="spacer"></td>
					<td class="label" align="center"><?php echo $TABLE_TERMS['STATUS']; ?></td>
					<td class="spacer"></td>
					<td class="label" align="center"><?php echo $TABLE_TERMS['CLASS']; ?></td>
					<td class="spacer"></td>
					<td class="label" align="center"><?php echo $TABLE_TERMS['PLANET_POSITION']; ?></td>
					<td class="spacer"></td>
					<td class="label" align="center"><?php echo $TABLE_TERMS['PLANET_NAME']; ?></td>
				</tr>
				<?php
						$start = ($page - 1) * $prn;
						$row_color = 1;
						$count = 0;


						if ( mysql_num_rows($query_result) !== 0 )
							mysql_data_seek($query_result, $start);
					
						while ( ($row = mysql_fetch_array($query_result)) && ($count <= ($prn - 1)) )
						{
							$count++;
							$stats_build    = number_format($row['6'], 0, ",", ".");
							$stats_res      = number_format($row['7'], 0, ",", ".");
							$stats_fleetdef = number_format($row['8'], 0, ",", ".");
					
							#--== Player's Planets ==--#
							$first_planet  = '<td class="row' . $row_color . '">N.D.</td>' . "\n";
							$first_planet .= '<td></td>' . "\n";
							$first_planet .= '<td class="row' . $row_color . '">N.D.</td>' . "\n";

							$other_planets = '';
						
							$query_result_a = $db->query( "SELECT name, x, y, z
														   FROM " . DB_PLANETS_TABLE . "
														   WHERE fkplayer = '{$row[0]}'
														   ORDER BY x, y, z" );
														   
							$planets_count = 0;
							$row_color_a = 1;
							
							while ( $row_a = mysql_fetch_array($query_result_a) )
							{
								$planets_count++;

								$x = ( $row_a['x'] <= 9 ) ? '0' . $row_a['x'] : $row_a['x'];
								$y = ( $row_a['y'] <= 9 ) ? '0' . $row_a['y'] : $row_a['y'];
								$z = ( $row_a['z'] <= 9 ) ? '0' . $row_a['z'] : $row_a['z'];
								
								if ( $planets_count == 1 )
								{
									$first_planet = '<td align="left" class="row' . $row_color_a . '">' . $x . ':' . $y . ':' . $z . '</td>'."\n";
									$first_planet .= '<td></td>'."\n";
									$first_planet .= '<td align="left" class="row' . $row_color_a . '"><nobr>' . htmlentities($row_a['name']) . '</nobr></td>'."\n";
								}
								else
								{
									$other_planets .= '<tr>' . "\n";
									$other_planets .= '<td align="left" class="row' . $row_color_a . '">' . $x . ':' . $y . ':' . $z . '</td>' . "\n";
									$other_planets .= '<td></td>' . "\n";
									$other_planets .= '<td align="left" class="row' . $row_color_a . '"><nobr>' . htmlentities($row_a['name']) . '</nobr></td>' . "\n";
									$other_planets .= '</tr>' . "\n";
								}
					
								$row_color_a = ( $row_color_a == 1 ) ? 2 : 1;
							}
							#--======================--#
							
							if ( $planets_count == 0 )
								$planets_count = 1;
					
							#--== Print Results ==--#
							echo '<tr>' . "\n";
							echo '<td rowspan="' . $planets_count . '" class="row' . $row_color . '" align="center">' . ($count + $start) . '</td>' . "\n";
							echo '<td rowspan="' . $planets_count . '"></td>' . "\n";
							echo '<td rowspan="' . $planets_count . '" class="row' . $row_color . '" align="right" onmouseover="tips(\'true\', \'' . $stats_build . '\', \'' . $stats_res . '\', \'' . $stats_fleetdef . '\');" onmouseout="tips(\'false\');">' . number_format($row[5], 0, ",", ".") . '</td>' . "\n";
							echo '<td rowspan="' . $planets_count . '"></td>' . "\n";
							echo '<td rowspan="' . $planets_count . '" class="row' . $row_color . '"><nobr><a class="name_links" href="index.php?section=player&id=' . $row[0] . '&si=' . $SESSION['SID'] . '">' . htmlentities($row[1]) . '</a> [' . htmlentities($row[2]) . ']</nobr></td>'."\n";
							echo '<td rowspan="' . $planets_count . '"></td>' . "\n";
							echo '<td rowspan="' . $planets_count . '" class="row' . $row_color . '">' . $PLAYER_STATUS[$row[4]] . '</nobr></td>' . "\n";
							echo '<td rowspan="' . $planets_count . '"></td>' . "\n";
							echo '<td rowspan="' . $planets_count . '" class="row' . $row_color . '"><nobr>' . $PLAYER_CLASS[$row[3]] . '</td>' . "\n";
							echo '<td rowspan="' . $planets_count . '"></td>' . "\n";
							echo $first_planet;
							echo '</tr>' . "\n";
							echo $other_planets;
							#--===================--#
					
							$row_color = ( $row_color == 1 ) ? 2 : 1;
						}
						
						echo '<tr>' . "\n";
					
						if ( $search_rows_number == 0 )
							echo '<td class="row1" colspan="13">La recherche n\'a donné aucun résultat.</td>' . "\n";
						else
							echo '<td class="row1" colspan="13">' . $search_rows_number . ' joueur(s) trouvé(s) dans la base.</td>' . "\n";
					
						echo '</tr>' . "\n";
					?>
			</table>
		</td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="bl"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="bottom"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="br"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
</table>
