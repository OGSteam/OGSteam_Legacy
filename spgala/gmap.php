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
    <td class="name" valign="middle"><?php echo TABLE_MAP; ?></td>
    <td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
  </tr>
  <tr>
    <td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td>
      <form action="map.php?si=<?php echo $SESSION['SID']; ?>" method="post" target="map">
        <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
          <tr>
            <td rowspan="2" align="left" valign="top">
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><img src="images/red.gif" alt="red" /> <span class="label"><?php echo SEARCH_ALLIANCE; ?>:</span></td>
                </tr>
                <tr>
                  <td>
                    <select name="a">
                      <option value=""><?php echo SEARCH_NO_ALLIANCE; ?>:</option>
                      <?php
					$query_result = $db->query(
						"SELECT DISTINCT ally
						FROM " . DB_PLAYERS_TABLE . "
						WHERE ally <> ''
						ORDER BY ally"
					);
					
					while ( $row = mysql_fetch_array($query_result) )
						echo '<option value="' . htmlentities($row[0], ENT_QUOTES) . '">' . htmlentities($row[0]) . '</option>' . "\n";
				?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><img src="images/blue.gif" alt="blue" /> <span class="label"><?php echo MAP_ENEMY; ?>:</span></td>
                </tr>
                <tr>
                  <td>
                    <input name="e" type="text" class="textfield" size="20" maxlength="20" />
                  </td>
                </tr>
                <tr>
                  <td><img src="images/green.gif" alt="green" /> <span class="label"><?php echo MAP_FRIEND; ?>:</span></td>
                </tr>
                <tr>
                  <td>
                    <select name="m">
                      <option value=""><?php echo MAP_NO_MEMBER; ?></option>
                      <?php
					$query_result = $db->query(
						"SELECT nick
						FROM " . DB_PLAYERS_TABLE . "
						WHERE ally = '$tag'
						ORDER BY nick"
					);
					
					while ( $row = mysql_fetch_array($query_result) )
						echo '<option value="' . htmlentities($row[0], ENT_QUOTES) . '">' . htmlentities($row[0]) . '</option>' . "\n";
				?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><img src="images/spacer.gif" width="1" height="5" align="left" /></td>
                </tr>
                <tr>
                  <td>
                    <input type="submit" value="<?php echo FORM_SUBMIT; ?>" />
                    <input type="submit" name="status" value="<?php echo MAP_STATUS; ?>" />
                  </td>
                </tr>
              </table>
            </td>
            <td align="right" valign="top">
            <iframe name="list" id="list" src="plist.php?si=<?php echo $SESSION['SID']; ?>"></iframe>
            </td>
          </tr>
          <tr>
            <td valign="top"><span class="label"><img src="images/1.gif" width="7" height="7" /> &lt; 2  <img src="images/2.gif" width="7" height="7" /> &gt; 2  <img src="images/3.gif" width="7" height="7" /> &gt; 7 <img src="images/4.gif" width="7" height="7" /> &gt; 15 <img src="images/5.gif" width="7" height="7" /> &gt; 30</span></td>
          </tr>
          
          <tr>
            <td colspan="2"><img src="images/spacer.gif" width="1" height="5" align="left" /></td>
          </tr>
          <tr>
            <td colspan="2">
              <iframe name="map" id="map" src="map.php?si=<?php echo $SESSION['SID']; ?>" frameborder="0" scrolling="no"></iframe>
            </td>
          </tr>
          <tr>
            <td colspan="2"><img src="images/spacer.gif" width="1" height="5" align="left" /></td>
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
