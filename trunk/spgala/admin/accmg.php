<?php
	if ( !defined('SPGDB_INC') )
		 die('Do not access this file directly.');
?>

<form method="post" action="index.php?section=admin&admin=accmg&si=<?php echo $SESSION['SID']; ?>">
  <table width="450" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">
        <?php
			if ( isset($_POST['id']) )
			{
				if ( isset($_POST['update']) )
				{
					$user_permissions = array();
					
					$permissions->permissions['Admin'] = ( isset($_POST['admin']) ) ? true : false;
					$permissions->permissions['UpdDb'] = ( isset($_POST['upddb']) ) ? true : false;
					$permissions->permissions['ShowMap'] = ( isset($_POST['showmap']) ) ? true : false;
					$permissions->permissions['ShowStats'] = ( isset($_POST['showstats']) ) ? true : false;
					$permissions->permissions['ShowPlayer'] = ( isset($_POST['showplayer']) ) ? true : false;
					$permissions->permissions['ShowStatsEx'] = ( isset($_POST['showstatsex']) ) ? true : false;
					
					$user_bitmask = $permissions->toBitmask();
					
					$active = ( isset($_POST['active']) ) ? 1 : 0;
					
					$db->query(
						"UPDATE " . DB_USERS_TABLE . "
						SET active = '$active',
						credentials = '$user_bitmask'
						WHERE id = '" . (int)$_POST['id'] . "'"
					);
								 
					echo '<span class="label">' . SETTINGS_SAVED . '</span>' . "\n";
				}
				else if ( isset($_POST['delete']) )
				{
					$db->query(
						"DELETE FROM " . DB_USERS_TABLE . "
						WHERE id = '" . (int)$_POST['id'] . "'"
					);
					
					echo '<span class="label">' . ACCOUNT_DELETED . '</span>' . "\n";
				}

				$query_result = $db->first_row(
					"SELECT nick, email, credentials, active, login, ip
					FROM " . DB_USERS_TABLE . "
					WHERE id = '" . (int)$_POST['id'] . "'" );
				
				if ( $query_result !== false )
				{
					$user_permissions = $permissions->getPermissions($query_result['credentials']);
		?>
        <table width="450" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50%" align="right" class="row2"><?php echo USER_NAME; ?>:</td>
            <td width="50%" align="left" class="row1"><?php echo $query_result['nick']; ?></td>
          </tr>
          <tr>
            <td width="50%" align="right" class="row2"><?php echo LAST_LOGIN; ?>: </td>
            <td width="50%" align="left" class="row1"><?php echo ($query_result['login'] == 0 ) ? 'N.D.' : gmstrftime("%d/%m/%Y, %H:%M:%S", $query_result['login']+$SESSION['TD']); ?></td>
          </tr>
          <tr>
            <td width="50%" align="right" class="row2"><?php echo LAST_IP; ?>: </td>
            <td width="50%" align="left" class="row1"><?php echo $query_result['ip']; ?></td>
          </tr>
          <tr>
            <td width="50%" align="right" class="row2"><?php echo EMAIL; ?>:</td>
            <td width="50%" align="left" class="row1"><?php echo $query_result['email']; ?></td>
          </tr>
          <tr>
            <td align="right" class="row2"><?php echo ACTIVE; ?>:</td>
            <td align="left" class="row1"><input type="checkbox" name="active"<?php echo ( $query_result['active'] == 1 ) ? ' checked="checked"' : ''; ?> /></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><span class="label"><?php echo PERMISSIONS; ?>:</span></td>
          </tr>
          <tr>
            <td colspan="2">
			  <input type="hidden" name="id" value="<?php echo (int)$_POST['id']; ?>" />
              <label>
              <input type="checkbox" name="admin"<?php echo ( $user_permissions['Admin'] === true ) ? ' checked="checked"' : ''; ?> />
              <span class="label"><?php echo PERM_ADMINISTRATION; ?></span></label>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label>
              <input type="checkbox" name="upddb"<?php echo ( $user_permissions['UpdDb'] === true ) ? ' checked="checked"' : ''; ?> />
              <span class="label"><?php echo PERM_UPDATE_DB; ?></span></label>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label>
              <input type="checkbox" name="showmap"<?php echo ( $user_permissions['ShowMap'] === true ) ? ' checked="checked"' : ''; ?> />
              <span class="label"><?php echo PERM_SHOW_MAP; ?></span></label>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label>
              <input type="checkbox" name="showstats"<?php echo ( $user_permissions['ShowStats'] === true ) ? ' checked="checked"' : ''; ?> />
              <span class="label"><?php echo PERM_SHOW_RANKING; ?></span></label>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label>
              <input type="checkbox" name="showplayer"<?php echo ( $user_permissions['ShowPlayer'] === true ) ? ' checked="checked"' : ''; ?> />
              <span class="label"><?php echo PERM_USE_SEARCH; ?></span></label>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label>
              <input type="checkbox" name="showstatsex"<?php echo ( $user_permissions['ShowStatsEx'] === true ) ? ' checked="checked"' : ''; ?> />
              <span class="label"><?php echo PERM_SHOW_STATS; ?></span></label>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input type="submit" name="update" value="<?php echo FORM_SUBMIT; ?>" />
              <input type="submit" name="delete" value="<?php echo FORM_DELETE_ACCOUNT; ?>" />
            </td>
          </tr>
        </table>
        <?php
				}
			}
			else
			{
		?>
        <select name="id">
          <?php
				$query_result = $db->query(
					"SELECT id, nick
					FROM " . DB_USERS_TABLE ."
					WHERE nick <> 'root'
					AND nick <> '{$SESSION['USERNICK']}'
					ORDER BY id"
				);
			
				while ( $row = mysql_fetch_array($query_result) )
					echo '<option value="' . $row['id'] . '">' . $row['nick'] . '</option>';
			?>
        </select>
        <input type="submit" value="<?php echo FORM_SUBMIT; ?>" />
        <?php
			}
		?>
      </td>
    </tr>
  </table>
</form>
