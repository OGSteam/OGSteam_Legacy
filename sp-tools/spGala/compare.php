<?php
	if ( !defined('SPGDB_INC') )
		 die('Do not access this file directly.');
?>

<table border="0" cellpadding="0" cellspacing="0" id="output_table" align="left">
  <tr>
    <td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
  </tr>
  <tr>
    <td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td class="name" valign="middle"><?php echo TABLE_COMPARE; ?></td>
    <td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
  </tr>
  <tr>
    <td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td>
      <form method="post">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2"><img src="images/spacer.gif" width="1" height="10" /></td>
          </tr>
          <tr>
            <td width="50%"><span class="label"><?php echo COMP_PLAYER; ?> 1:</span>
              <select name="id1">
                <?php
					$players = $db->query(
						"SELECT id, nick
						FROM " . DB_PLAYERS_TABLE . "
						ORDER BY nick"
					);
					
					while ( $player = mysql_fetch_array($players) )
					{
						echo '<option value="' . $player['id'] . '"';
						
						if ( isset($_POST['id1']) && $player['id'] == (int)$_POST['id1'] )
							echo ' selected';
						
						echo '>' . $player['nick'] . '</option>' . "\n";
					}
			    ?>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="2"><img src="images/spacer.gif" width="1" height="5" /></td>
          </tr>
          <tr>
            <td width="50%"><span class="label"><?php echo COMP_PLAYER; ?> 2:</span>
              <select name="id2">
                <?php
					$players = $db->query(
						"SELECT id, nick
						FROM " . DB_PLAYERS_TABLE . "
						ORDER BY nick"
					);
					
					while ( $player = mysql_fetch_array($players) )
					{
						echo '<option value="' . $player['id'] . '"';
						
						if ( isset($_POST['id2']) && $player['id'] == (int)$_POST['id2'] )
							echo ' selected';
						
						echo '>' . $player['nick'] . '</option>' . "\n";
					}
			    ?>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="2"><img src="images/spacer.gif" width="1" height="5" /></td>
          </tr>
          <tr>
            <td colspan="2"><span class="label">Points:</span>
              <select name="what">
                <option value="tot"<? if ( isset($_POST['what']) && $_POST['what'] == 'tot' ) echo ' selected'; ?>><?php echo CHART_TOTAL; ?></option>
                <option value="build"<? if ( isset($_POST['what']) && $_POST['what'] == 'build' ) echo ' selected'; ?>><?php echo CHART_BUILD; ?></option>
                <option value="res"<? if ( isset($_POST['what']) && $_POST['what'] == 'res' ) echo ' selected'; ?>><?php echo CHART_RESEARCH; ?></option>
                <option value="fleetdef"<? if ( isset($_POST['what']) && $_POST['what'] == 'fleetdef' ) echo ' selected'; ?>><?php echo CHART_FLEET_DEFENSE; ?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="2"><img src="images/spacer.gif" width="1" height="5" /></td>
          </tr>
          <tr>
            <td>
              <input type="submit" value="<?php echo FORM_SUBMIT; ?>" />
            </td>
          </tr>
          <?php
			if ( isset($_POST['id1'], $_POST['id2'], $_POST['what']) )
				echo '<tr>
            <td colspan="2"><img src="images/spacer.gif" width="1" height="5" /></td>
          </tr>
          <tr>
            <td colspan="2">
              <iframe src="chart_page2.php?id1=' . (int)$_POST['id1'] . '&id2=' . (int)$_POST['id2'] . '&what=' . $_POST['what'] . '&si=' . $SESSION['SID'] . '" name="chart" id="chart" width="400px" height="250px" scrolling="No" frameborder="0"></iframe>
            </td>
          </tr>' . "\n";
		  ?>
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
