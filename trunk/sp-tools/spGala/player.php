<?php
	if ( !defined('SPGDB_INC') )
		 die('Do not access this file directly.');

	if ( isset($_REQUEST['id']) )
		$player_id = (int)$_REQUEST['id'];
	else
		exit;

	$last_ranking_id = $db->first_result( "SELECT MAX(n)
										   FROM " . DB_STATS_TABLE . "
										   WHERE fkplayer = '$player_id'" );

	if ( $last_ranking_id !== false )
		$query_result = $db->first_row( "SELECT fkplayer, nick, class, tot, build, res, fleetdef, status, notes, oldnick, " . DB_STATS_TABLE . ".date, ally
										 FROM " . DB_PLAYERS_TABLE . ", " . DB_STATS_TABLE . "
										 WHERE " . DB_PLAYERS_TABLE . ".id = fkplayer
										 AND fkplayer = '$player_id'
										 AND n = '$last_ranking_id'" );
	
	if ( $query_result === false )
		exit;
		
		$player_id      = $query_result[0];
		$player_notes   = $query_result[8];
		$stats_tot      = $query_result[3];
		$stats_build    = $query_result[4];
		$stats_res      = $query_result[5];
		$stats_fleetdef = $query_result[6];
?>

<table width="700" border="0" align="left" cellpadding="0" cellspacing="0" id="output_table">
	<tr>
		<td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="name" valign="middle"> <?php echo TABLE_PLAYER_INFO; ?> </td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
				<tr>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="25%" align="center" class="label"><?php echo $TABLE_TERMS['NAME']; ?> [<?php echo $TABLE_TERMS['ALLIANCE']; ?>]</td>
								<td class="spacer">&nbsp;</td>
								<td width="25%" align="center" class="label"><?php echo $TABLE_TERMS['PREVIOUS_NAME']; ?></td>
								<td class="spacer">&nbsp;</td>
								<td width="25%" align="center" class="label"><?php echo $TABLE_TERMS['CLASS']; ?></td>
								<td class="spacer">&nbsp;</td>
								<td width="25%" align="center" class="label"><?php echo $TABLE_TERMS['STATUS']; ?></td>
							</tr>
							<tr>
								<td width="25%" align="left" class="row1"><?php echo htmlentities($query_result[1]); ?> [<?php echo htmlentities($query_result[11]); ?>]</td>
								<td></td>
								<td width="25%" align="left" class="row1"><?php echo htmlentities($query_result[9]); ?></td>
								<td></td>
								<td width="25%" align="left" class="row1"><?php echo $PLAYER_CLASS[$query_result[2]]; ?></td>
								<td></td>
								<td width="25%" align="left" class="row1"><?php echo $PLAYER_STATUS[$query_result[7]]; ?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><img src="images/spacer.gif" width="1" height="5"></td>
				</tr>
				<tr>
					<td colspan="4">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="400" align="center" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td>
												<iframe src="chart_page.php?id=<?php echo $player_id; ?>&what=tot&si=<?php echo $SESSION['SID']; ?>" name="chart" id="chart" width="400px" height="250px" scrolling="No" frameborder="0"></iframe>
											</td>
										</tr>
									</table>
								</td>
								<td rowspan="2" align="center" valign="top"><img src="images/spacer.gif" alt="spacer" width="5" height="1"></td>
								<td rowspan="2" align="center" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="50%" align="center" class="label"><?php echo $TABLE_TERMS['PLANET_NAME']; ?></td>
											<td align="center" class="spacer">&nbsp;</td>
											<td width="50%" align="center" class="label"><?php echo $TABLE_TERMS['PLANET_POSITION']; ?></td>
										</tr>
										<?php
											$query_result_a = $db->query( "SELECT name, x, y, z
																		   FROM " . DB_PLANETS_TABLE . "
																		   WHERE fkplayer = '{$query_result[0]}'
																		   ORDER BY x, y, z" );

											while ( $row_a = mysql_fetch_array($query_result_a) )
											{
												$x = ( $row_a['x'] <= 9 ) ? '0' . $row_a['x'] : $row_a['x'];
												$y = ( $row_a['y'] <= 9 ) ? '0' . $row_a['y'] : $row_a['y'];
												$z = ( $row_a['z'] <= 9 ) ? '0' . $row_a['z'] : $row_a['z'];

												echo '<tr>' . "\n";
												echo '<td width="50%" class="row2">' . htmlentities($row_a[0]) . '</td>' . "\n";
												echo '<td>&nbsp;</td>' . "\n";
												echo '<td width="50%" class="row1">' . $x . ':' . $y . ':' . $z .'</td>' . "\n";
												echo '</tr>' . "\n";
											}
										?>
									</table>
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="4"><img src="images/spacer.gif" width="1" height="5"></td>
				</tr>
				<tr>
					<td colspan="4">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="25%" align="center" class="label"><a href="chart_page.php?id=<?php echo $player_id; ?>&amp;what=tot&amp;si=<?php echo $SESSION['SID']; ?>" target="chart"><?php echo $TABLE_TERMS['TOTAL_POINTS']; ?></a></td>
								<td class="spacer">&nbsp;</td>
								<td width="25%" align="center" class="label"><a href="chart_page.php?id=<?php echo $player_id; ?>&amp;what=build&amp;si=<?php echo $SESSION['SID']; ?>" target="chart"><?php echo $TABLE_TERMS['BUILD_POINTS']; ?></a></td>
								<td class="spacer">&nbsp;</td>
								<td width="25%" align="center" class="label"><a href="chart_page.php?id=<?php echo $player_id; ?>&amp;what=res&amp;si=<?php echo $SESSION['SID']; ?>" target="chart"><?php echo $TABLE_TERMS['RESEARCH_POINTS']; ?></a></td>
								<td class="spacer">&nbsp;</td>
								<td width="25%" align="center" class="label"><a href="chart_page.php?id=<?php echo $player_id; ?>&amp;what=fleetdef&amp;si=<?php echo $SESSION['SID']; ?>" target="chart"><?php echo $TABLE_TERMS['FLEET_DEFENSE_POINTS']; ?></a></td>
							</tr>
							<tr>
								<td width="25%" align="right" class="row1"><?php echo number_format($query_result[3], 0, ",", "."); ?></td>
								<td>&nbsp;</td>
								<td width="25%" align="right" class="row1"><?php echo number_format($query_result[4], 0, ",", "."); ?></td>
								<td>&nbsp;</td>
								<td width="25%" align="right" class="row1"><?php echo number_format($query_result[5], 0, ",", "."); ?></td>
								<td>&nbsp;</td>
								<td width="25%" align="right" class="row1"><?php echo number_format($query_result[6], 0, ",", "."); ?></td>
							</tr>
						</table>
					</td>
				</tr>
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
<br>
<table width="700" border="0" align="left" cellpadding="0" cellspacing="0" id="output_table">
	<tr>
		<td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="name" valign="middle"> <?php echo TABLE_PLAYER_NOTES; ?> </td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
				<tr>
					<td>
						<?php
							$notes = $db->first_result( "SELECT notes
														 FROM " . DB_PLAYERS_TABLE . "
														 WHERE id = '$player_id'" );
														 
							if ( isset($_POST['note']) )
							{
								$text = htmlspecialchars(trim(stripslashes($_POST['note'])));

								if ( $text !== '')
								{
									$date = gmstrftime("%d/%m/%Y, %H:%M:%S GMT", time());
									$notes .= $text . "\n\n" . '- ' . $SESSION['USERNICK'] . ' (' . $date . ')' . "\n" . '=====' . "\n\n";

									$db->query( "UPDATE " . DB_PLAYERS_TABLE . "
												 SET notes = '" . addslashes($notes) . "'
												 WHERE id = '$player_id'" );
								}
							}
						?>
						<div id="notes"><?php echo nl2br($notes); ?></div>
						<form method="post" action="index.php?section=player&si=<?php echo $SESSION['SID']; ?>" style="width: 100%;">
							<input type="hidden" name="id" id="id" value="<?php echo $player_id; ?>" />
							<input type="text" name="note" id="note" style="width: 90%;" />
							<input type="submit" value="<?php echo FORM_SUBMIT; ?>" />
						</form>
					</td>
				</tr>
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
<br>
<?php
	$query_result = $db->first_row( "SELECT *
									 FROM " . DB_RESEARCH_TABLE . "
									 WHERE fkplayer = '$player_id'" );
	
	if ( $query_result !== false)
	{						 
?>
<table width="700" border="0" align="left" cellpadding="0" cellspacing="0" id="output_table">
	<tr>
		<td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="name" valign="middle"> <?php echo TABLE_PLAYER_RESEARCH; ?> </td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
				<?php
					$line_item = 1;

					foreach ( $RESEARCHES as $key => $value )
					{
						if ( $line_item == 1)
							echo '<tr>' . "\n";
						else
							echo '<td><img src="images/spacer.gif" alt="spacer" width="5" height="1"></td>' . "\n";
						
						echo '<td class="row2" width="22%" align="right">' . $value . ':</td><td class="row1" width="3%" align="left">' . $query_result[$key] . '</td>' . "\n";
						
						if ( $line_item == 4 )
							echo '</tr>';
						
						$line_item++;
						
						if ( $line_item == 5 )
							$line_item = 1;
					}
					
					if ( $line_item == 4 )
					{
						echo '<td><img src="images/spacer.gif" alt="spacer" width="5" height="1"></td>' . "\n";
						echo '<td class="row2" width="22%" align="right"></td>&nbsp;<td class="row1" width="3%" align="right">&left;</td>' . "\n";
						echo '</tr>' . "\n";
					}
					
					$query_result = $db->first_result( "SELECT date
														FROM " . DB_PLANETS_TABLE . "
														WHERE fkplayer = '$player_id'" );
					
					echo '<tr><td colspan="11" class="row1">' . $TABLE_TERMS['LAST_UPDATE'] . ': ' . gmstrftime("%d/%m/%Y, %H:%M:%S", $query_result+$SESSION['TD']) . '</td><tr>' . "\n";
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
<?php
	}
?>
