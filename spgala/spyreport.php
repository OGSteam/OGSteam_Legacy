<div align="left">
	<table border="0" cellpadding="0" cellspacing="0" id="output_table" align="center">
		<tr>
			<td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
			<td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
			<td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
		</tr>
		<tr>
			<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
			<td class="name" valign="middle"><?php echo TABLE_SPYREPORT; ?></td>
			<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
		</tr>
		<tr>
			<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
			<td>
				<?php
					if ( isset($_POST['spyreport'], $_POST['date_time']) )
					{
						require ( 'includes/spyreportparser.php' );
						echo '<span class="label">';
						echo ( $info === true ) ? REPORT_INSERTED : REPORT_FAILED;
						echo '</span>';
						echo "<meta http-equiv='Refresh' content='3; url=index.php?section=spyreport'>";
					}
					else
					{
				?>
				<form action="index.php?section=spyreport&si=<?php echo $SESSION['SID']; ?>" method="post" name="form_spyreport" id="form_spyreport">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="left"><span class="label"><?php echo PASTE_REPORT_DATE; ?>:</span><br />
								<input class="textfield" name="date_time" type="text" maxlength="19" />
							</td>
						</tr>
						<tr>
							<td><span class="label"><?php echo PASTE_SPY_REPORT; ?>:</span><br />
								<textarea class="textfield" style="height: auto;  width: 600px" name="spyreport" cols="100" rows="17" wrap="off"></textarea>
							</td>
						</tr>
						<tr>
							<td><img src="images/spacer.gif" width="1" height="5" align="right" /></td>
						</tr>
						<tr>
							<td align="right">
								<input class="button" type="submit" value="<?php echo FORM_SUBMIT; ?>" />
								<input class="button" type="reset" value="<?php echo FORM_RESET; ?>" />
							</td>
						</tr>
					</table>
				</form>
				<?php
					}
				?>
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
</div>
