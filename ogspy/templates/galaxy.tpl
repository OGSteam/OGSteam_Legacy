<form action="?">
<table>
<tr>
	<td class="c" colspan="3">{common_Galaxy}</td>
	<th>
		&nbsp;
		<input type="hidden" name="action" value="galaxy" />
	</th>
	<td class="c" colspan="3">{search_SolarSystem}</td>
</tr>
<tr>
	<th><input type="button" onclick="window.location = '?action=galaxy&amp;galaxy={GALAXY_DOWN}&amp;system={SYSTEM_ACTUAL}';" value="&lt;&lt;&lt;" /></th>
	<th><input type="text" name="galaxy" maxlength="3" size="5" value="{GALAXY_ACTUAL}" tabindex="1" style="text-align:center;" /></th>
	<th><input type="button" onclick="window.location = '?action=galaxy&amp;galaxy={GALAXY_UP}&amp;system={SYSTEM_ACTUAL}';" value="&gt;&gt;&gt;" /></th>
	<th>&nbsp;</th>
	<th><input type="button" onclick="window.location = '?action=galaxy&amp;galaxy={GALAXY_ACTUAL}&amp;system={SYSTEM_DOWN}';" value="&lt;&lt;&lt;" /></th>
	<th><input type="text" name="system"  maxlength="3" size="5" value="{SYSTEM_ACTUAL}" tabindex="2" style="text-align:center;" /></th>
	<th><input type="button" onclick="window.location = '?action=galaxy&amp;galaxy={GALAXY_ACTUAL}&amp;system={SYSTEM_UP}';" value="&gt;&gt;&gt;" /></th>
</tr>
<tr>
	<td class="c" colspan="7" id="ajax_info">&nbsp;</td>
</tr>
<tr align="center">
	<td colspan="7"><input type="submit" value="{search_Show}" /></td>
</tr>
</table>
</form>
<!-- Deplacement par le clavier (methode OGame.fr) -->
<script type="text/javascript">
<!-- Begin
	function cursorevent(evt) {
		evt = (evt) ? evt : ((event) ? event : null);
		if(evt.keyCode == 37) // Touche gauche
			window.location = '?action=galaxy&galaxy={GALAXY_ACTUAL}&system={SYSTEM_DOWN}';
		if(evt.keyCode == 39) // Touche droite
			window.location = '?action=galaxy&galaxy={GALAXY_ACTUAL}&system={SYSTEM_UP}';
		if(evt.keyCode == 38)  // Touche haut
			window.location = '?action=galaxy&galaxy={GALAXY_UP}&system={SYSTEM_ACTUAL}';
		if(evt.keyCode == 40)  // Touche bas
			window.location = '?action=galaxy&galaxy={GALAXY_DOWN}&system={SYSTEM_ACTUAL}';
	}
	function toggle_info(a) {
		if(document.getElementById(a).style.display != 'none')
			hide_info(a);
		else
			draw_info(a);
	}
	function draw_info(a) {
		document.getElementById(a).style.display = 'block';
		document.getElementById(a + '_img1').src = 'images/arrow_top.png';
		document.getElementById(a + '_img2').src = 'images/arrow_top.png';
	}
	function hide_info(a) {
		document.getElementById(a).style.display = 'none';
		document.getElementById(a + '_img1').src = 'images/arrow_down.png';
		document.getElementById(a + '_img2').src = 'images/arrow_down.png';
	}
	document.onkeydown = cursorevent;
	//  End -->
</script>

<table width="800">
	<tr>
		<td colspan="3" align="left">
	<!-- IF is_favorite -->		
			<form method="post" action="?action=galaxy">
				<table width="100%"><tr><td>
				<select name="coordinates" onchange="this.form.submit();" onkeyup="this.form.submit();">
					<option>{search_FavoritesList}</option>
	<!-- BEGIN SHOW_FAVORITE -->
					<option value='{SHOW_FAVORITE.coordinates}' {SHOW_FAVORITE.selected}>{SHOW_FAVORITE.coordinates}</option>
	<!-- END SHOW_FAVORITE -->
				</select>
				</td></tr></table>
			</form>
	<!-- ELSE IF is_favorite -->
			&nbsp;
	<!-- END IF is_favorite -->
		</td>
		<td colspan="6" align="right">
	<!-- IF exist_favorite -->	
			<input type="button" value="{search_DelFavorites}" onclick="window.location = '?action=del_favorite&amp;galaxy={GALAXY_ACTUAL}&amp;system={SYSTEM_ACTUAL}';" />
	<!-- ELSE IF exist_favorite -->
		<!-- IF too_favorite -->
			<input type="button" value="{search_AddFavorites}" onclick="alert('{MAX_FAVORITE}');" />
		<!-- ELSE IF too_favorite -->
			<input type="button" value="{search_AddFavorites}" onclick="window.location = '?action=add_favorite&amp;galaxy={GALAXY_ACTUAL}&amp;system={SYSTEM_ACTUAL}';" />
		<!-- END IF too_favorite -->
	<!-- END IF exist_favorite -->
		</td>
	</tr>
	<tr>
		<td class="c" colspan="9">{search_SolarSystem}</td>
	</tr>
	<tr>
		<td class="c" style="width:15px;">&nbsp;</td>
		<td class="c" style="width:150px;">{common_Planets}</td>
		<td class="c" style="width:150px;">{common_Allys}</td>
		<td class="c" style="width:150px;">{common_Players}</td>
		<td class="c" style="width:15px;">&nbsp;</td>
		<td class="c" style="width:15px;">&nbsp;</td>
		<td class="c" style="width:20px;">&nbsp;</td>
		<td class="c" style="width:20px;">&nbsp;</td>
		<td class="c" style="width:150px;">{search_Update}</td>
	</tr>
	<!-- BEGIN SHOW_GALAXY -->
	<tr>
		<th>{SHOW_GALAXY.row}</th>
		<th class="a" style="white-space: nowrap;">{SHOW_GALAXY.planet}</th>
		<th class="a" style="white-space: nowrap;">{SHOW_GALAXY.ally}</th> 
		<th class="a" style="white-space: nowrap;">{SHOW_GALAXY.player}</th> 
		<th class="status" style="white-space: nowrap;">{SHOW_GALAXY.moon}</th> 
		<th class="status" style="white-space: nowrap;">{SHOW_GALAXY.status}</th> 
		<th class="status" style="white-space: nowrap;">{SHOW_GALAXY.spy}</th> 
		<th class="status" style="white-space: nowrap;">{SHOW_GALAXY.rc}</th> 
		<th class="a" style="white-space: nowrap;">{SHOW_GALAXY.date} - {SHOW_GALAXY.sender}</th> 
	</tr>
	<!-- END SHOW_GALAXY -->
	<tr align='center'>
		<td class='c' colspan='9'>
			<span style='cursor:pointer' onmouseover="Tip('{legend_tip}');" onmouseout="UnTip();">{search_Legend}</span>
		</td>
	</tr>
</table>

<!-- IF SHOW_MIP -->
<br />
<table width='800'>
	<tr>
		<td class="c" style="text-align:center;cursor:pointer;" onclick="toggle_info('table_mip');">
			<img id="table_mip_img1" src="images/{init_picture}.png" style="float:left; display:block;" alt=""/>
			<img id="table_mip_img2" src="images/{init_picture}.png" style="float:right; display:block;" alt=""/>
			{search_FriendlyMip} {help_galaxy_mip} {total_mip}
		</td>
	</tr>
	<tr><td style="border:none">
		<table id="table_mip" style="display:{init_display}">
	<!-- IF is_mip -->
		<!-- BEGIN MIP -->
			<tr style='text-align:left'>
				<th style='width:800px'>
					{MIP.user_name} -- {MIP.coordinates} - {incgal_MipsDispo}: {MIP.MIP} [<font color='green'>{MIP.position_down}&nbsp;&lt;-&gt;&nbsp;{MIP.position_up}</font>]
				</th>
			</tr>
		<!-- END MIP -->
	<!-- ELSE IF is_mip -->
			<tr style='text-align:left'>
				<th style='width:800px'>{incgal_NoMIonRange}</th>
			</tr>
	<!-- END IF is_mip -->
		</table>
	</td></tr>
</table>
<!-- END IF SHOW_MIP -->

<!-- IF SHOW_PHALANX_FRIEND -->
<br />
<table width='800'>
	<tr>
		<td class="c" style="text-align:center;cursor:pointer;" onclick="toggle_info('table_phal_fr');">
			<img id="table_phal_fr_img1" src="images/{init_picture}.png" style="float:left; display:block;" alt=""/>
			<img id="table_phal_fr_img2" src="images/{init_picture}.png" style="float:right; display:block;" alt=""/>
			{search_FriendlyPhallanx} {help_galaxy_mip} {total_FriendlyPhallanx}
		</td>
	</tr>
	<tr><td style="border:none">
		<table id="table_phal_fr" style="display:{init_display}">
	<!-- IF is_phalanx_friend -->
		<!-- BEGIN PHALANX_FRIEND -->
			<tr style='text-align:left'>
				<th style='width:800px'>
					{PHALANX_FRIEND.user_name} -- {PHALANX_FRIEND.coordinates}&nbsp;[<font color='green'>{PHALANX_FRIEND.galaxy}:{PHALANX_FRIEND.range_down}&nbsp;&lt;-&gt;&nbsp;{PHALANX_FRIEND.galaxy}:{PHALANX_FRIEND.range_up}</font>]
				</th>
			</tr>
		<!-- END PHALANX_FRIEND -->
	<!-- ELSE IF is_phalanx_friend -->
			<tr style='text-align:left'>
				<th style='width:800px'>{galaxy_nofriendlyphalange}</th>
			</tr>
	<!-- END IF is_phalanx_friend -->
		</table>
	</td></tr>
</table>
<!-- END IF SHOW_PHALANX_FRIEND -->

<br />
<table width='800'>
	<tr>
		<td class="c" style="text-align:center;cursor:pointer;" onclick="toggle_info('table_phal_dan');">
			<img id="table_phal_dan_img1" src="images/{init_picture}.png" style="float:left; display:block;" alt=""/>
			<img id="table_phal_dan_img2" src="images/{init_picture}.png" style="float:right; display:block;" alt=""/>
			{search_DangerousPhallanx} {help_galaxy_phalanx} {total_DangerousPhallanx}
		</td>
	</tr>
	<tr><td style="border:none">
		<table id="table_phal_dan" style="display:{init_display}">
<!-- IF is_phalanx_dangerous -->
	<!-- BEGIN PHALANX_DANGEROUS -->
			<tr style='text-align:left'>
				<th style='width:800px'>
					{PHALANX_DANGEROUS.user_name} [{PHALANX_DANGEROUS.user_ally}] -- {PHALANX_DANGEROUS.coordinates}&nbsp;[<font color='red'>{PHALANX_DANGEROUS.galaxy}:{PHALANX_DANGEROUS.range_down}&nbsp;&lt;-&gt;&nbsp;{PHALANX_DANGEROUS.galaxy}:{PHALANX_DANGEROUS.range_up}</font>]
				</th>
			</tr>
	<!-- END PHALANX_DANGEROUS -->
<!-- ELSE IF is_phalanx_dangerous -->
			<tr style='text-align:left'>
				<th style='width:800px'>{galaxy_nophalange}</th>
			</tr>
<!-- END IF is_phalanx_dangerous -->
		</table>
	</td></tr>
</table>


<!-- define=legend_content -->
<table width="225">
	<tr><td class="c" colspan="2" align="center" width="150">{search_Legend}</td></tr>
	<tr><td class="c">{search_Inactive7Day} / {search_Inactive28Day}</td><th class="i">i / I</th></tr>
	<tr><td class="c">{search_strongerPlayer}</td><th class="f">f</th></tr>
	<tr><td class="c">{search_vacation}</td><th class="v">v</th></tr>
	<tr><td class="c">{search_WeakPlayer}</td><th class="d">d</th></tr>
	<tr><td class="c">{search_MoonPhallanx}</td><th style="white-space: nowrap;">{ogame_Moons_abbrev} - {ogame_Phallanx_abbrev}X</th></tr>
	<tr><td class="c">{search_SpyReport}</td><th>X {search_SpyReport_abbrev}</th></tr>
	<tr><td class="c">{search_battlesreport}</td><th>X {search_battlesreport_abbrev}</th></tr>
	<tr><td class="c">{search_FriendAlly}</td><th><blink><a>abc</a></blink></th></tr>
	<tr><td class="c">{search_HidenAlly}</td><th><font color="{HIDED_COLOR}">abc</font></th></tr>
</table>
<!-- /define -->
