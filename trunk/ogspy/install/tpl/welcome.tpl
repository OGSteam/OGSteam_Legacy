<table width="100%" cellpadding="20">
<tr>
	<td align="center">
		<table>
			<tr>
				<td align="center" style="font-size:3;"><b>{welcome}</b></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td>
					<div style="font-size:12px">
						<ul>
							<li style="list-style-type: square;">{description-0}</li>
							<li style="list-style-type: square;">{description-1}
								<ul>
									<li>{description-2}</li>
									<li>{description-3}</li>
									<li>{description-4}</li>
								</ul>
							</li>
						</ul>
						<div style="text-align:center; color:#ecff00;">{moreinfo}<a href="http://board.ogsteam.fr/" onclick="window.open(this.href); return false;" >http://board.ogsteam.fr/</a></div>
					</div>
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td><div style="text-align:center;">{lang_selection}</div></td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
<!-- IF found_id -->
				<td align="center"><font color="#FFA500"><b>{chooseaction}<br/></b></font>
					<form action="index.php?lang={lang}" method="post">
						<div>
							<button class="button" type="submit" name="action" value="install">{fullinstall}</button>
							<button class="button" type="submit" name="action" value="update">{update}</button>
						</div>
					</form>
				</td>
<!-- ELSE IF found_id -->
				<td align="center">
					<form action="index.php?lang={lang}" method="post">
						<div>
							<button class="button" type="submit" name="action" value="install">{fullinstall}</button>
						</div>
					</form>
				</td>
<!-- END IF found_id -->
			</tr>
		</table>
	</td>
</tr>
</table>
