<?php
	if ( !defined('SPGDB_INC') )
		 die('Do not access this file directly.');
		 
	$response = true;

	if ( isset($_POST['user'], $_POST['pass']) )
		$response = login();
?>
<table border="0" cellpadding="0" cellspacing="0" id="output_table" align="left">
	<tr>
		<td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="name" valign="middle"><?php echo TABLE_LOGIN; ?></td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td>
			<form action="index.php" method="post" name="search" id="search">
				<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
					<?php
						if ( $response === false )
						{
							echo '<tr><td>' . "\n";
							echo '<span class="label">• ' . LOGIN_INFO_ERROR . '</span><br />';
							echo '</td></tr>' . "\n";
							echo '<tr><td><img src="images/spacer.gif" width="1" height="5" align="right" /></td></tr>' . "\n";
						}
					?>
				  <tr>
            <td>
              <input type="hidden" name="section" id="section" value="login" />
              <span class="label"><?php echo USER_NAME; ?>:</span><br />
              <input name="user" type="text" id="user" maxlength="20" />
            </td>
			    </tr>
				  <tr>
            <td><img src="images/spacer.gif" width="1" height="5" align="right" /></td>
			    </tr>
				  <tr>
            <td> <span class="label"><?php echo USER_PASSWORD; ?>:</span><br />
                <input name="pass" type="password" id="pass" maxlength="32" />
            </td>
			    </tr>
					<tr>
						<td><img src="images/spacer.gif" width="1" height="5" /></td>
					</tr>
					<tr>
						<td align="right">
							<table border="0" cellspacing="1" cellpadding="0">
								<tr>
									<td>
										<input type="submit" class="button" value="<?php echo FORM_SUBMIT; ?>" />
									</td>
									<td><img src="images/spacer.gif" width="5" height="1" align="right" /></td>
									<td>
										<input type="reset" class="button" value="<?php echo FORM_RESET; ?>" />
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