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
    <td class="name" valign="middle"><?php echo TABLE_ADMIN; ?></td>
    <td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
  </tr>
  <tr>
    <td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td>
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="200" align="center" class="label"><?php echo MENU; ?></td>
          <td>&nbsp;</td>
          <td width="450" rowspan="2" align="center">
			<?php
				if ( isset($_GET['admin']) )
				{
					switch ( $_GET['admin'] )
					{
						case 'accmg':
							require ( 'admin/accmg.php' );
							break;
						case 'dbsettings':
							require ( 'admin/dbsettings.php' );
							break;
						case 'dbstats':
							require ( 'admin/dbstats.php' );
							break;
					}
				}
			?>
		  </td>
        </tr>
        <tr>
          <td width="200" align="left" valign="top" class="admin_menu">- <a href="index.php?section=admin&amp;admin=dbsettings&amp;si=<?php echo $SESSION['SID']; ?>"><?php echo DB_SETTINGS; ?></a><br />
            - <a href="index.php?section=admin&amp;admin=accmg&amp;si=<?php echo $SESSION['SID']; ?>"><?php echo ACCOUNT_ADMIN; ?></a><br />
			- <a href="index.php?section=admin&amp;admin=dbstats&amp;si=<?php echo $SESSION['SID']; ?>"><?php echo DB_STATS; ?></a></td>
          <td>&nbsp;</td>
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
