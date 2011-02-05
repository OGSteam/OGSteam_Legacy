<?php
	if ( !defined('SPGDB_INC') )
		 die('Do not access this file directly.');
		 
	$maxrankings = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'maxrankings'"
	);
?>
<script language="JavaScript" type="text/javascript">
	function init()
	{
		document.getElementById("name_tab").style.display = 'none';
		document.getElementById("ally_tab").style.display = 'none';
		document.getElementById("area_tab").style.display = 'none';
		document.getElementById("status_tab").style.display = 'none';
		document.getElementById("point_tab").style.display = 'none';
		document.searchp.reset();		
	}
	
	function fix(camp)
	{
		number = document.getElementById(camp).value;
		number = number.replace(/[^0-9]/g, "");
		
		if ( parseInt(number) == 0 )
			number = 1;
		
		document.getElementById(camp).value = number;
	}
	
	function showhide(what)
	{
		if ( document.getElementById(what+'_box').checked )
			document.getElementById(what+'_tab').style.display = '';
		else
			document.getElementById(what+'_tab').style.display = 'none';
	}
</script>
<table border="0" cellpadding="0" cellspacing="0" id="output_table" align="left">
	<tr>
		<td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="name" valign="middle"><?php echo TABLE_SEARCH; ?></td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td>
			<form action="index.php?section=results&si=<?php echo $SESSION['SID']; ?>" method="post" name="searchp" id="searchp">
				<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
					<tr>
						<td>
							<input type="hidden" name="si" id="si" value="<?php echo $SESSION['SID']; ?>" />
							<label for="name_box">
							<input id="name_box" name="name_search" type="checkbox" onchange="showhide('name');" />
							<span class="label"><?php echo SEARCH_NAME; ?></span></label>
						</td>
					</tr>
					<tr>
						<td id="name_tab">
							<blockquote >
								<input name="player_name" type="text" class="textfield" id="player_name" size="20" maxlength="20" />
							</blockquote>
						</td>
					</tr>
					<tr>
						<td>
							<label for="ally_box">
							<input id="ally_box" name="ally_search" type="checkbox" onchange="showhide('ally');" />
							<span class="label"><?php echo SEARCH_ALLIANCE; ?></span></label>
						</td>
					</tr>
					<tr>
						<td id="ally_tab">
							<blockquote>
								<select name="player_ally" id="player_ally">
									<option value=""><?php echo SEARCH_NO_ALLIANCE; ?></option>
									<?php
										$query_result = $db->query(
											"SELECT DISTINCT ally
											FROM " . DB_PLAYERS_TABLE . "
											WHERE ally <> ''
											ORDER BY ally"
										);
										
										while ( $row = mysql_fetch_array($query_result) )
											echo '<option value="' . $row[0] . '">' . $row[0] . '</option>' . "\n";
									?>
								</select>
							</blockquote>
						</td>
					</tr>
					<tr>
						<td>
							<label for="point_box">
							<input id="point_box" name="point_search" type="checkbox" onchange="showhide('point');" />
							<span class="label"><?php echo SEARCH_FLEET_POINTS; ?></span></label>
						</td>
					</tr>
					<tr>
						<td id="point_tab">
							<blockquote><span class="label"><?php echo SEARCH_BETWEEN; ?></span>
								<input class="textfield" type="text" id="min" name="min" size="10" maxlength="10" />
								<span class="label"><?php echo SEARCH_AND; ?></span>
								<input class="textfield" type="text" id="max" name="max" size="10" maxlength="10" />
							</blockquote>
						</td>
					</tr>
					<tr>
						<td>
							<label for="area_box">
							<input id="area_box" name="area_search" type="checkbox" onchange="showhide('area');" />
							<span class="label"><?php echo SEARCH_AREA; ?></span></label>
						</td>
					</tr>
					<tr>
						<td id="area_tab">
							<blockquote><span class="label"><?php echo SEARCH_BETWEEN; ?></span>
								<input class="textfield" id="xp" name="xp" type="text" size="2" maxlength="2" onkeyup="fix('xp')" />
								<span class="label">:</span>
								<input class="textfield" id="yp" name="yp" type="text" size="2" maxlength="2" onkeyup="fix('yp')" />
								<span class="label"><?php echo SEARCH_AND; ?></span>
								<input class="textfield" id="xa" name="xa" type="text" size="2" maxlength="2" onkeyup="fix('xa')" />
								<span class="label">:</span>
								<input class="textfield" id="ya" name="ya" type="text" size="2" maxlength="2" onkeyup="fix('ya')" />
							</blockquote>
						</td>
					</tr>
					<tr>
						<td>
							<label for="status_box">
							<input id="status_box" name="status_search" type="checkbox" onchange="showhide('status');" />
							<span class="label"><?php echo SEARCH_STATUS; ?></span></label>
						</td>
					</tr>
					<tr>
						<td id="status_tab">
							<table border="0" cellpadding="0" cellspacing="3" style="margin-left: 35px;">
								<tr>
									<td>
										<label for="g">
										<input id="g" name="g" type="checkbox" />
										<span class="label"><?php echo STATUS_BANNED; ?></span></label>
									</td>
									<td>
										<label for="i">
										<input id="i" name="i" type="checkbox" />
										<span class="label"><?php echo STATUS_INACTIVE; ?></span></label>
									</td>
									<td>
										<label for="a">
										<input id="a" name="a" type="checkbox" />
										<span class="label"><?php echo STATUS_ACTIVE; ?></span></label>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<label for="u">
										<input id="u" name="u" type="checkbox" />
										<span class="label"><?php echo STATUS_ON_HOLIDAY; ?></span></label>
									</td>
									<td>
										<label for="gu">
										<input id="gu" name="gu" type="checkbox" />
										<span class="label"><?php echo STATUS_FORCED_HOLIDAY; ?></span></label>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<label for="iu">
										<input id="iu" name="iu" type="checkbox" />
										<span class="label"><?php echo STATUS_INACTIVE_ON_HOLIDAY; ?></span></label>
									</td>
									<td></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td id="status_tab"><span class="label"><?php echo SEARCH_RESULTS_PER_PAGE; ?>:
							<select id="prn" name="prn">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
							</span></td>
					</tr>
					<tr>
						<td id="status_tab"><img src="images/spacer.gif" width="1" height="10" /></td>
					</tr>
					<tr>
						<td id="status_tab"><span class="label"><?php echo SEARCH_RANKING_SELECTION; ?>:</span></td>
					</tr>
					<tr>
						<td id="status_tab">
							<?php
								echo '<select name="rid" id="rid">' . "\n";
								
								$last_ranking_id = $db->first_result(
									"SELECT MAX(n)
									FROM " . DB_STATS_TABLE
								);
								
								$query_result = $db->query(
									"SELECT DISTINCT n
									FROM " . DB_STATS_TABLE . "
									WHERE n BETWEEN '$last_ranking_id'-" . ($maxrankings - 1) . " AND '$last_ranking_id'
									ORDER BY date DESC"
								);
															 
								if ( mysql_num_rows($query_result) !== 0 )
								{
									$count = 1;

									while ( $row = mysql_fetch_array($query_result) )
									{
										$query_result_a = $db->first_row(
											"SELECT MAX(date), COUNT(fkplayer)
											FROM " . DB_STATS_TABLE . "
											WHERE n = '$row[0]'"
										);
	
										echo '<option value="' . $row[0] . '">';
										echo ( $count < 10 ) ? '0' . $count : $count;
										echo '. ' . strftime("%d/%m/%Y, %H:%M:%S", $query_result_a[0]) . ' (' . $query_result_a[1] . ' joueurs)</option>'."\n";

										$count++;
									}
								}
								else
									echo '<option value="">-</option>' . "\n";
	
								echo '</select>' . "\n";
							?>
						</td>
					</tr>
					<tr>
						<td id="status_tab"><img src="images/spacer.gif" width="1" height="10" /></td>
					</tr>
					<tr>
						<td align="right" id="status_tab">
							<table border="0" cellspacing="1" cellpadding="0">
								<tr>
									<td>
										<input type="submit" class="button" value="<?php echo FORM_SUBMIT; ?>" />
									</td>
									<td><img src="images/spacer.gif" width="5" height="1" align="right" /></td>
									<td>
										<input type="reset" class="button" value="<?php echo FORM_RESET; ?>" onclick="init();" />
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
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
<script language="JavaScript" type="text/javascript">init();</script>
