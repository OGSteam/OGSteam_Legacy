<?php
	if ( !defined('SPGDB_INC') )
		 die('Do not access this file directly.');
		
	if ( isset($_POST['allytag'], $_POST['allyname'], $_POST['windows']) && preg_match("/[\x20-\x7e\x81-\xffº¹²³¼½¾]+/", trim($_POST['allytag'])) )
	{
		$db->query(
			"UPDATE " . DB_CONFIG_TABLE . "
			SET value = '" . trim($_POST['allytag']) . "'
			WHERE name = 'tag'"
		);
		
		$db->query(
			"UPDATE " . DB_CONFIG_TABLE . "
			SET value = '" . trim(htmlspecialchars($_POST['allyname'])) . "'
			WHERE name = 'name'"
		);
					 
		$db->query(
			"UPDATE " . DB_CONFIG_TABLE . "
			SET value = '" . (int)$_POST['windows'] . "'
			WHERE name = 'windows'"
		);
					 
		$db->query(
			"UPDATE " . DB_CONFIG_TABLE . "
			SET value = '" . (int)$_POST['maxrankings'] . "'
			WHERE name = 'maxrankings'"
		);
					 
		echo '<span class="label">' . SETTINGS_SAVED . '</span>' . "\n";
	}

	$allytag = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'tag'"
	);
								   
	$allyname = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'name'"
	);
									
	$windows = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'windows'"
	);
	
	$maxrankings = $db->first_result(
		"SELECT value
		FROM " . DB_CONFIG_TABLE . "
		WHERE name = 'maxrankings'"
	);
?>

<form method="post" action="index.php?section=admin&admin=dbsettings&si=<?php echo $SESSION['SID']; ?>">
  <table width="450" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="50%" align="right" class="row2"><?php echo SET_ALLIANCE_TAG; ?>:</td>
      <td width="50%" align="left" class="row1">
        <input name="allytag" type="text" value="<?php echo $allytag; ?>" maxlength="20" />
      </td>
    </tr>
    <tr>
      <td align="right" class="row2"><?php echo SET_ALLIANCE_NAME; ?>:</td>
      <td align="left" class="row1">
        <input name="allyname" type="text" value="<?php echo $allyname; ?>" maxlength="100" />
      </td>
    </tr>
    <tr>
      <td align="right" class="row2"><?php echo SET_RANKINGS_PER_DAY; ?>:</td>
      <td align="left" class="row1">
        <select name="windows">
          <?php
			foreach ( $WINDOWS as $key => $value )
			{
				echo '<option value="' . $key . '"';
				
				if ( $key == $windows )
					echo 'selected ';
				
				echo '>' . $value . '</option>';
			}
		  ?>
        </select>
      </td>
    </tr>
    <tr>
      <td align="right" class="row2"><?php echo SET_MAX_RANKINGS; ?>:</td>
      <td align="left" class="row1">
        <select name="maxrankings">
          <?php
			foreach ( range(24,100) as $value )
			{
				echo '<option value="' . $value . '"';
				
				if ( $value == $maxrankings )
					echo 'selected ';
				
				echo '>' . $value . '</option>';
			}
		  ?>
        </select>
      </td>
    </tr>
  </table>
  <input type="submit" value="<?php echo FORM_SUBMIT; ?>" />
</form>
