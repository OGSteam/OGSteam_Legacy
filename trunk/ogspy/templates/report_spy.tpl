<!-- IF no_re -->
<p>{reportspy_nobattles}</p>
<!--// ?<script type="text/javascript">window.opener.location.href=window.opener.location.href;</script> -->
<!-- ELSE IF no_re -->
<p class="titre" style="text-align:center;font-size:x-large"><b>{title}</b></p>
<br />
<div style="text-align:right;">
	<select id="re_select" name="re_select" onchange="{onclick_re_select}">
		<option value="0">{reportspy_ViewGlobalRe}</option>
<!-- BEGIN re_list -->
<!-- IF re_list.selected -->
		<option value="{re_list.id}" selected="selected">{re_list.name}</option>
<!-- ELSE IF re_list.selected -->
		<option value="{re_list.id}">{re_list.name}</option>
<!-- END IF re_list.selected -->
<!-- END re_list -->
	</select>
	<!--<input type='button' value='{reportspy_Favorites}' onclick="{onclick_Favorites}"/>-->
</div>
<br />
<p class="f" style="text-align:center;font-size:large">{spy_title}</p>
<!-- IF planet_re -->
<br />
<br />
<table border="0" cellpadding="2" cellspacing="0" style="text-align:center;">
	<tr>
		<td class="l" colspan="4"><big>{incgal_ressourceson}</big></td>
	</tr>
	<tr>
		<td class="c" style="text-align:right;">{ogame_Metal}</td><th>{metal}</th>
		<td class="c" style="text-align:right;">{ogame_Crystal}</td><th>{cristal}</th>
	</tr>
	<tr>
		<td class="c" style="text-align:right;">{ogame_Deuterium}</td><th>{deuterium}</th>
		<td class="c" style="text-align:right;">{ogame_Energy}</td><th>{energie}</th>
	</tr>
	<!--<tr>
		<th colspan="4">{incgal_activity}</th>
	</tr>-->
	
<!-- IF is_fleet -->
	<tr>
		<td class="l" colspan="4">
			<big>{incgal_fleet}</big>
<!-- IF is_global -->
			<i>({fleet_date})</i>
<!-- END IF is_global -->
		</td>
	</tr>
<!-- END IF is_fleet -->

<!-- IF is_frow -->
<!-- BEGIN fleet -->
	<tr>
		<td class="c" style="text-align:right;">{fleet.name1}</td>
		<th>{fleet.count1}</th>
		<td class="c" style="text-align:right;">{fleet.name2}</td>
		<th>{fleet.count2}</th>
	</tr>
<!-- END fleet -->
<!-- END IF is_frow -->

<!-- IF is_defense -->
	<tr>
		<td class="l" colspan="4">
			<big>{incgal_defense}</big>
<!-- IF is_global -->
			<i>({defense_date})</i>
<!-- END IF is_global -->
		</td>
	</tr>
<!-- END IF is_defense -->

<!-- IF is_drow -->
<!-- BEGIN defense -->
	<tr>
		<td class="c" style="text-align:right;">{defense.name1}</td>
		<th>{defense.count1}</th>
		<td class="c" style="text-align:right;">{defense.name2}</td>
		<th>{defense.count2}</th>
	</tr>
<!-- END defense -->

<!-- END IF is_drow -->


<!-- IF is_buildings -->
	<tr>
		<td class="l" colspan="4">
			<big>{incgal_buildings}</big>
<!-- IF is_global -->
			<i>({buildings_date})</i>
<!-- END IF is_global -->
		</td>
	</tr>
<!-- END IF is_buildings -->

<!-- IF is_brow -->
<!-- BEGIN buildings -->
	<tr>
		<td class="c" style="text-align:right;">{buildings.name1}</td>
		<th>{buildings.count1}</th>
		<td class="c" style="text-align:right;">{buildings.name2}</td>
		<th>{buildings.count2}</th>
	</tr>
<!-- END buildings -->

<!-- END IF is_brow -->

<!-- IF is_research -->
	<tr>
		<td class="l" colspan="4">
			<big>{incgal_research}</big>
<!-- IF is_global -->
			<i>({research_date})</i>
<!-- END IF is_global -->
		</td>
	</tr>
<!-- END IF is_research -->

<!-- IF is_rrow -->
<!-- BEGIN research -->
	<tr>
		<td class="c" style="text-align:right;">{research.name1}</td>
		<th>{research.count1}</th>
		<td class="c" style="text-align:right;">{research.name2}</td>
		<th>{research.count2}</th>
	</tr>
<!-- END research -->
<!-- END IF is_rrow -->

	<tr>
		<th colspan="4">{incgal_probadestruction}</th>
	</tr>
</table>
<!-- IF can_delete -->
	<input type='button' value='{reportspy_DelReport}' onclick="{onclick_DelReport}"/>
<!-- END IF can_delete -->
<br />
<!-- END IF planet_re -->
<br />

<!-- IF moon_re -->
<br />
<table border="0" cellpadding="2" cellspacing="0" style="text-align:center;">
	<tr>
		<td class="l" colspan="4"><big>{incgal_ressourceson_2}</big></td>
	</tr>
	<tr>
		<td class="c" style="text-align:right;">{ogame_Metal}</td><th>{metal_2}</th>
		<td class="c" style="text-align:right;">{ogame_Crystal}</td><th>{cristal_2}</th>
	</tr>
	<tr>
		<td class="c" style="text-align:right;">{ogame_Deuterium}</td><th>{deuterium_2}</th>
		<td class="c" style="text-align:right;">{ogame_Energy}</td><th>{energie_2}</th>
	</tr>
	<tr>
		<th colspan="4">{incgal_activity_2}</th>
	</tr>
<!-- IF is_fleet_2 -->
	<tr>
		<td class="l" colspan="4">
			<big>{incgal_fleet}</big>
<!-- IF is_global -->
			<i>({fleet_date_2})</i>
<!-- END IF is_global -->
		</td>
	</tr>
<!-- END IF is_fleet_2 -->

<!-- IF is_frow_2 -->
<!-- BEGIN fleet_2 -->
	<tr>
		<td class="c" style="text-align:right;">{fleet_2.name1}</td>
		<th>{fleet_2.count1}</th>
		<td class="c" style="text-align:right;">{fleet_2.name2}</td>
		<th>{fleet_2.count2}</th>
	</tr>
<!-- END fleet_2 -->

<!-- END IF is_frow_2 -->

<!-- IF is_defense_2 -->
	<tr>
		<td class="l" colspan="4">
			<big>{incgal_defense}</big>
<!-- IF is_global -->
			<i>({defense_date_2})</i>
<!-- END IF is_global -->
		</td>
	</tr>
<!-- END IF is_defense_2 -->

<!-- IF is_drow_2 -->
<!-- BEGIN defense_2 -->
	<tr>
		<td class="c" style="text-align:right;">{defense_2.name1}</td>
		<th>{defense_2.count1}</th>
		<td class="c" style="text-align:right;">{defense_2.name2}</td>
		<th>{defense_2.count2}</th>
	</tr>
<!-- END defense_2 -->
<!-- END IF is_drow_2 -->

<!-- IF is_buildings_2 -->
	<tr>
		<td class="l" colspan="4">
			<big>{incgal_buildings}</big>
<!-- IF is_global -->
			<i>({buildings_date_2})</i>
<!-- END IF is_global -->
		</td>
	</tr>
<!-- END IF is_buildings_2 -->

<!-- IF is_brow_2 -->
<!-- BEGIN buildings_2 -->
	<tr>
		<td class="c" style="text-align:right;">{buildings_2.name1}</td>
		<th>{buildings_2.count1}</th>
		<td class="c" style="text-align:right;">{buildings_2.name2}</td>
		<th>{buildings_2.count2}</th>
	</tr>
<!-- END buildings_2 -->
<!-- END IF is_brow_2 -->

<!-- IF is_research_2 -->
	<tr>
		<td class="l" colspan="4">
			<big>{incgal_research}</big>
<!-- IF is_global -->
			<i>({research_date_2})</i>
<!-- END IF is_global -->
		</td>
	</tr>
<!-- END IF is_research_2 -->

<!-- IF is_rrow_2 -->
<!-- BEGIN research_2 -->
	<tr>
		<td class="c" style="text-align:right;">{research_2.name1}</td>
		<th>{research_2.count1}</th>
		<td class="c" style="text-align:right;">{research_2.name2}</td>
		<th>{research_2.count2}</th>
	</tr>
<!-- END research_2 -->
<!-- END IF is_rrow_2 -->

	<tr>
		<th colspan="4">{incgal_probadestruction_2}</th>
	</tr>
</table>
<!-- IF can_delete_2 -->
	<input type='button' value='{reportspy_DelReport}' onclick="{onclick_DelReport_2}"/>
<!-- END IF can_delete_2 -->
<!-- END IF moon_re -->
<!-- END IF no_re -->
<br /><br />
<input type="button" value="Close" onclick="javascript:window.close();"/>