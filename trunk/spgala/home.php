<?php
	$GMTsign = $db->first_result( "SELECT value FROM " . DB_CONFIG_TABLE ." WHERE name = 'gmtsign'" );
	
	if ( $GMTsign !== '' ) # Timezone
	{
		$GMT = intval($db->first_result( "SELECT value FROM " . DB_CONFIG_TABLE ." WHERE name = 'gmt'" ));
		
		if ( $GMTsign == '-' )
			$GMT = -$GMT * 3600;
		else if ( $GMTsign == '+' )
			$GMT = $GMT * 3600;
	}
	else
		$GMT = 0;

	$DST = intval($db->first_result( "SELECT value FROM " . DB_CONFIG_TABLE . " WHERE name = 'dst'" )); # Daylight Saving Time {0 = false | 1 = true}

	$TD = $GMT + (3600 * $DST); # Time Difference

	$players_n = $db->first_result( "SELECT COUNT(nick) FROM " . DB_PLAYERS_TABLE );
	$allys_n   = $db->first_result( "SELECT COUNT(DISTINCT ally) FROM " . DB_PLAYERS_TABLE );
	$planets_n = $db->first_result( "SELECT COUNT(name) FROM " . DB_PLANETS_TABLE );
	$last_upd  = $db->first_result( "SELECT MAX(date) FROM " . DB_STATS_TABLE );
	
	$last_upd = ( $last_upd !== NULL ) ? gmstrftime( "%d/%m/%Y alle %H:%M:%S", $last_upd+$SESSION['TD'] ) : '';

	$server_time = gmstrftime( "%d/%m/%Y, %H:%M:%S GMT " . $GMTsign . $GMT/3600 , time()+$TD );

// Compte le mobre d'utilisateur en ligne
	$sess_nb = $db->first_result( "SELECT count(id) FROM spgdb_sessions" );
	
	
?>

<table border="0" cellpadding="0" cellspacing="0" id="output_table" align="left">
  <tr>
    <td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
  </tr>
  <tr>
    <td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td class="name" valign="middle">Home</td>
    <td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
  </tr>
  <tr>
    <td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><img src="images/spacer.gif" width="1" height="10" /></td>
        </tr>
        <tr>
          <td><span class="label"><?php echo PLAYERS_NUM ?>: <?php echo $players_n ?></span></td>
        </tr>
        <tr>
          <td><span class="label"><?php echo ALLYS_NUM ?>: <?php echo $allys_n ?></span></td>
        </tr>
        <tr>
          <td><span class="label"><?php echo PLANETS_NUM ?>: <?php echo $planets_n ?></span></td>
        </tr>
        <tr>
          <td><span class="label"><?php echo LAST_RANKING_UPD ?>: <?php echo $last_upd ?></span></td>
        </tr>
        <tr>
          <td><span class="label"><?php echo SERVER_TIME ?>: <?php echo $server_time ?></span></td>
        </tr>
        <tr>
          <td><span class="label"><br>connecté : <?php echo $sess_nb ?></span></td>
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
