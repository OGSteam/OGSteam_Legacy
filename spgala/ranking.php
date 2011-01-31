<?php
	if ( !defined('SPGDB_INC') )
		die('Do not access this file directly.');
		
	$border_total        = '';
	$border_build        = '';
	$border_research     = '';
	$border_fleetdefense = '';
	
	if ( isset($_REQUEST['sort']) )
	{
		switch ($_REQUEST['sort'])
		{
			case 'tot':
				$sort = 'tot';
				$border_total = 'order_';
				break;
			case 'build':
				$sort = 'build';
				$border_build = 'order_';
				break;
			case 'res':
				$sort = 'res';
				$border_research = 'order_';
				break;
			case 'fleetdef':
				$sort = 'fleetdef';
				$border_fleetdefense = 'order_';
				break;
			default:
				$sort = 'tot';
				break;
		}
	}
	else
	{
		$sort = 'tot';
		$border_total = 'order_';
	}

	$last_ranking_id = $db->first_result(
		"SELECT MAX(n)
		FROM " . DB_STATS_TABLE
	);
	
	$rid = ( isset($_REQUEST['rid']) && (int)$_REQUEST['rid'] >= ($last_ranking_id - 59) && (int)$_REQUEST['rid'] <= $last_ranking_id ) ? (int)$_REQUEST['rid'] : $last_ranking_id;
		
	$ranking_rows_number = $db->first_result(
		"SELECT COUNT(*)
		FROM " . DB_STATS_TABLE . "
		WHERE n = '$rid'"
	);

	$total_pages_number = ceil($ranking_rows_number / 100);
	
	$page = ( isset($_REQUEST['page']) && (int)$_REQUEST['page'] > 0 && (int)$_REQUEST['page'] <= $total_pages_number ) ? (int)$_REQUEST['page'] : 1;

	$url_string_start = 'index.php?section=ranking&sort=';
	$url_string_end = '&rid=' . $rid . '&page=' . $page . '&si=' . $SESSION['SID'];
?>

<table border="0" cellpadding="0" cellspacing="0" id="output_table" align="left">
	<tr>
		<td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="name" valign="middle"><?php echo TABLE_RANKING; ?></td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
				<tr>
					<td colspan="21" align="center">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<?php
										#--== Chronology Menu ==--#
										echo '<form method="post" name="chronology_form" id="chronology_form" action="index.php?section=ranking&si=' . $SESSION['SID'] . '">' . "\n";
										echo '<input type="hidden" name="section" id="section" value="ranking" />' . "\n";
										echo '<input type="hidden" name="sort" id="sort" value="' . $sort . '" />' . "\n";
										echo '<input type="hidden" name="page" id="page" value="' . $page . '" />' . "\n";
										echo '<input type="hidden" name="si" id="si" value="' . $SESSION['SID'] . '" />' . "\n";
			
										echo '<select name="rid" id="rid" onchange="document.chronology_form.submit();">' . "\n";
										
										$query_result = $db->query(
											"SELECT DISTINCT n
											FROM " . DB_STATS_TABLE . "
											WHERE n BETWEEN '$last_ranking_id'-59 AND '$last_ranking_id'
											ORDER BY date DESC"
										);
																	 
										if ( mysql_num_rows($query_result) !== 0 )
										{
											while ( $row = mysql_fetch_array($query_result) )
											{
												$ranking_date = $db->first_result(
													"SELECT MAX(date)
													FROM " . DB_STATS_TABLE . "
													WHERE n = '$row[0]'"
												);
			
												echo '<option value="' . $row[0] . '"';
												
												if ( $row[0] == $rid )
													echo ' selected="selected"';
												
												echo '>' . strftime("%d/%m/%Y, %H:%M:%S", $ranking_date) . '</option>'."\n";
											}
										}
										else
											echo '<option value="">-</option>'."\n";
			
										echo '</select>' . "\n";
										echo '</form>' . "\n";
										#--=====================--#
									?>
								</td>
								<td><img src="images/spacer.gif" width="5" height="1" /></td>
								<td>
									<?php
										#--== Pages Menu ==--#
										echo '<form method="post" name="page_form" id="page_form" action="index.php?section=ranking&si=' . $SESSION['SID'] . '">' . "\n";
										echo '<input type="hidden" name="rid" id="rid" value="' . $rid . '" />' . "\n";
										echo '<input type="hidden" name="sort" id="sort" value="' . $sort . '" />' . "\n";
										echo '<input type="hidden" name="si" id="si" value="' . $SESSION['SID'] . '" />' . "\n";
										
										echo '<select name="page" id="page" onchange="document.page_form.submit();">' . "\n";
			
										for ( $i = 1; $i <= $total_pages_number; $i++ )
										{
											echo '<option value="' . $i . '"';
											
											if ( $i == $page ) echo ' selected="selected"';
											
											echo '>' . (($i - 1) * 100 + 1) . ' - ' . ($i * 100) .'</option>';
										}
			
										echo '</select>' . "\n";
										echo '</form>' . "\n";
										#--================--#
									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><img src="images/spacer.gif" width="1" height="5" /></td>
				</tr>
				<tr>
					<td class="label" align="center"> <?php echo $TABLE_TERMS['POSITION']; ?> </td>
					<td class="spacer"></td>
					<td class="label" align="center"> <?php echo $TABLE_TERMS['NAME']; ?> [<?php echo $TABLE_TERMS['ALLIANCE']; ?>]</td>
					<td class="spacer"></td>
					<td class="label" align="center"> <?php echo $TABLE_TERMS['CLASS']; ?> </td>
					<td class="spacer"></td>
					<td class="label" align="center"> <?php echo $TABLE_TERMS['STATUS']; ?> </td>
					<td class="spacer"></td>
					<td class="label" align="center" colspan="2"><a href="<?php echo $url_string_start; ?>tot<?php echo $url_string_end; ?>"> <?php echo $TABLE_TERMS['TOTAL_POINTS']; ?> </a></td>
					<td class="spacer"></td>
					<td class="label" align="center" colspan="2"><a href="<?php echo $url_string_start; ?>build<?php echo $url_string_end; ?>"> <?php echo $TABLE_TERMS['BUILD_POINTS']; ?> </a></td>
					<td class="spacer"></td>
					<td class="label" align="center" colspan="2"><a href="<?php echo $url_string_start; ?>res<?php echo $url_string_end; ?>"> <?php echo $TABLE_TERMS['RESEARCH_POINTS']; ?> </a></td>
					<td class="spacer"></td>
					<td class="label" align="center" colspan="2"><a href="<?php echo $url_string_start; ?>fleetdef<?php echo $url_string_end; ?>"> <?php echo $TABLE_TERMS['FLEET_DEFENSE_POINTS']; ?> </a></td>
					<td class="spacer"></td>
					<td class="label" align="center"> <?php echo $TABLE_TERMS['LAST_UPDATE']; ?> </td>
				</tr>
				<?php		
					$start = ($page - 1) * 100;
				
					$query_result = $db->query(
						"SELECT nick, ally, class, status, tot, build, res, fleetdef, " . DB_STATS_TABLE . ".date, " . DB_STATS_TABLE . ".fkplayer, fkplayerud
						FROM " . DB_PLAYERS_TABLE . ", " . DB_STATS_TABLE . "
						WHERE n = '$rid'
						AND " . DB_PLAYERS_TABLE . ".id = fkplayer
						ORDER BY " . $sort . " DESC
						LIMIT " . $start . ", 100"
					);
					
					$tag = $db->first_result(
						"SELECT value
						FROM " . DB_CONFIG_TABLE . "
						WHERE name = 'tag'"
					);

					
					if ( mysql_num_rows($query_result) !== 0 )
					{
						$count = 0;
						$row_color = 1;
				
						while ( $row = mysql_fetch_array($query_result) )
						{
							$count++;
							
							$user_ud = $db->first_result(
								"SELECT nick
								FROM " . DB_USERS_TABLE . "
								WHERE id = '{$row[10]}'"
							);
				
							#--== Calculate Points % ==--#
							$previous_ranking_id = ( ($rid - 1) <= ($last_ranking_id - 59) ) ? ($last_ranking_id - 59) : ($rid - 1);
							$previous_ranking_id = ( $previous_ranking_id <= 0 ) ? 0 : $previous_ranking_id;
				
							$query_result_a = $db->first_row(
								"SELECT tot, build, res, fleetdef
								FROM " . DB_STATS_TABLE . "
								WHERE n = '$previous_ranking_id'
								AND fkplayer = '{$row[9]}'"
							);
				
							$last_total    = &$row[4]; $previous_total    = &$query_result_a[0];
							$last_build    = &$row[5]; $previous_build    = &$query_result_a[1];
							$last_research = &$row[6]; $previous_research = &$query_result_a[2];
							$last_fleetdef = &$row[7]; $previous_fleetdef = &$query_result_a[3];
				
							$total_percent    = ( $query_result_a === false || $previous_total == 0 ) ? 0 : round(($last_total - $previous_total) / $previous_total * 100, 2);
							$build_percent    = ( $query_result_a === false || $previous_build == 0 ) ? 0 : round(($last_build - $previous_build) / $previous_build * 100, 2);
							$research_percent = ( $query_result_a === false || $previous_research == 0 ) ? 0 : round(($last_research - $previous_research) / $previous_research * 100, 2);
							$fleetdef_percent = ( $query_result_a === false || $previous_fleetdef == 0 ) ? 0 : round(($last_fleetdef - $previous_fleetdef) / $previous_fleetdef * 100, 2);
							#--========================--#

							#--== Get Status color ==--#
							switch ($row[3]){
								case 1 : // Banned
									$fontColor='#FF0000';
								break;
								case 2 : // Inactive
									$fontColor='#CCCCCC';
								break;
								case 3 : // Holiday mode
									$fontColor='#0000FF';
								break;
								case 4 : // Blocked Holiday mode
									$fontColor='#0000FF';
								break;
								case 5 : // Inactive Holiday mode
									$fontColor='#0000FF';
								break;
								default : // default color
									$fontColor='#000000';
								break;
							}
							#--========================--#
				
							#--== Print Ranking ==--#
							echo '<tr>' . "\n";
							echo '<td class="row' . $row_color . '">' . ($start + $count) . '</td>' . "\n";
							echo '<td></td>' . "\n";
							echo '<td class="row' . $row_color . '"><nobr><a class="name_links" href="index.php?section=player&id=' . $row[9] . '&si=' . $SESSION['SID'] . '">' .( ( $row[1] == $tag ) ? '<font color="#00ff00"><b>' . htmlentities($row[0]) . '</b></font>':htmlentities($row[0])). '</a> [' . ( ( $row[1] == $tag ) ? '<font color="#00ff00"><b>' . htmlentities($row[1]) . '</b></font>':htmlentities($row[1])) . ']</nobr></td>' . "\n";
							echo '<td></td>' . "\n";
							echo '<td class="row' . $row_color . '">' . $PLAYER_CLASS[$row[2]] . '</td>' . "\n";
							echo '<td></td>' . "\n";
							echo '<td class="row' . $row_color . '"><nobr><font color="' . $fontColor. '">' . $PLAYER_STATUS[$row[3]] . '</font></nobr></td>' . "\n";
							echo '<td></td>' . "\n";
							echo '<td class="' . $border_total . 'row' . $row_color . '" style="width: 20px;" align="left">' . $total_percent . '%</td>' . "\n";
							echo '<td class="' . $border_total . 'row' . $row_color . '" align="right">' . number_format($row[4], 0, ",", ".") . '</td>' . "\n";
							echo '<td></td>' . "\n";
							echo '<td class="' . $border_build . 'row' . $row_color . '" style="width: 20px;" align="left">' . $build_percent . '%</td>' . "\n";
							echo '<td class="' . $border_build . 'row' . $row_color . '" align="right">' . number_format($row[5], 0, ",", ".") . '</td>' . "\n";
							echo '<td></td>' . "\n";
							echo '<td class="' . $border_research . 'row' . $row_color . '" style="width: 20px;" align="left">' . $research_percent . '%</td>' . "\n";
							echo '<td class="' . $border_research . 'row' . $row_color . '" align="right">' . number_format($row[6], 0, ",", ".") . '</td>' . "\n";
							echo '<td></td>' . "\n";
							echo '<td class="' . $border_fleetdefense . 'row' . $row_color . '" style="width: 20px;" align="left">' . $fleetdef_percent . '%</td>' . "\n";
							echo '<td class="' . $border_fleetdefense . 'row' . $row_color . '" align="right">' . number_format($row[7], 0, ",", ".") . '</td>' . "\n";
							echo '<td></td>' . "\n";
							echo '<td class="row' . $row_color . '"><nobr>' . gmstrftime("%d/%m/%Y, %H:%M:%S", $row[8]+$SESSION['TD']) . ' ' . htmlentities($user_ud) . '</nobr></td>' . "\n";
							echo '</tr>' . "\n";
							#--===================--#
							
							$row_color = ( $row_color == 1 ) ? 2 : 1;
						}
					}
					else
						echo '<td class="row1" colspan="21">Aucun joueur trouvé dans la Base.</td>' . "\n";
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
