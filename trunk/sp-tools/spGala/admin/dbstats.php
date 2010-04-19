<?php
	if ( !defined('SPGDB_INC') )
		 die('Do not access this file directly.');

	$stats = $db->query(
		"SHOW TABLE STATUS FROM " . $db_name
	);
	
	$total_db = 0;
	
	echo '<table width="450" border="0" cellspacing="0" cellpadding="0">' . "\n";

	while($array = mysql_fetch_array($stats))
	{
		$total = $array['Data_length'] + $array['Index_length'];
	
		echo '
		<tr><td align="right" class="row2" width="50%">' . STATS_TABLE . ':</td><td align="left" class="row1" width="50%">' . $array['Name'] . '</td></tr>
		<tr><td align="right" class="row2">' . STATS_DATA_SIZE . ':</td><td align="left" class="row1">' . round($array['Data_length']/1024, 2) . 'KB</td></tr>
		<tr><td align="right" class="row2">' . STATS_INDEX_SIZE . ':</td><td align="left" class="row1">' . round($array['Index_length']/1024, 2) . 'KB</td></tr>
		<tr><td align="right" class="row2">' . STATS_TOTAL_SIZE . ':</td><td align="left" class="row1">' . round($total/1024, 2).'KB</td></tr>
		<tr><td align="right" class="row2">' . STATS_ROWS_NUMBER . ':</td><td align="left" class="row1">' . $array['Rows'] . '</td></tr>
		<tr><td align="right" class="row2">' . STATS_AVERAGE_SIZE_PER_ROW . ':</td><td align="left" class="row1">' . round($array['Avg_row_length']/1024, 2) . 'KB</td></tr>
		<tr><td>&nbsp;</td></tr>
		';
		
		$total_db += $total;
	}
	
	echo '<tr><td align="right" class="row2">' . STATS_DB_TOTAL_SIZE . ':</td><td align="left" class="row1">' . round($total_db/1024, 2) . 'KB</td></tr></table>' . "\n";
?>