<form method="post" enctype="multipart/form-data" action="index.php" onsubmit="return true;">
<table width="100%">
	<tr>
<!-- IF view_planet -->
		<td colspan='5' style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a>{PLANETS}</a>
		</td>
		<td class='c' style='text-align:center;margin-left:auto;margin-right:auto;' colspan='5' >
			<a style='cursor:pointer;color:lime;' onclick="window.location = '?action=home&amp;view=moons';">{MOONS}</a>
		</td>
<!-- ELSE IF view_planet -->
		<td class='c' style='text-align:center;margin-left:auto;margin-right:auto;' colspan='5' >
			<a style='cursor:pointer;color:lime;' onclick="window.location = '?action=home&amp;view=planets';">{PLANETS}</a>
		</td>
		<td colspan='5' style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a>{MOONS}</a>
		</td>
<!-- END IF view_planet -->
	</tr>
        <tr>
		<td class="c" colspan="10">{PASTEINFO}</td>
	</tr>
	<tr>
		<th>
			<a>{PASTE}</a>
			<input type="hidden" name="action" value="set_empire"/>
			<input type="hidden" name="view" value="{VIEW}"/>
		</th>
		<th colspan="8">
			<textarea name="data" id='data' rows="2" cols="2" onfocus="clear_text2()">{HOME_TEXTAREA}</textarea>
		</th>		
		<th>
			<input type="submit" value="{SEND_BTN}"/>
		</th>
	</tr>
	<tr>
		<th style="width:10%;">
			<a>{SELECT_PLANET}</a>
		</th>
		<!-- BEGIN 10_col -->
		<th style="width:10%;">
			<!-- IF 10_col.RADIO -->
				<label>
					<input name="planet_id" value="{10_col.VALUE}" type="radio" onclick="select_planet=autofill({10_col.VALUE});" />
					{10_col.PLANET_NAME}
				</label>
			<!-- ELSE IF 10_col.RADIO -->
				&nbsp;
			<!-- END IF 10_col.RADIO -->
		</th>
		<!-- END 10_col -->
	</tr>
	<tr>
	<!-- IF view_planet -->
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a id="input_zone1">{TITLE_PLANET_NAME}</a>
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<input type="text" id="input_zone2" name="planet_name" size="10" maxlength="20" disabled="disabled" />
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a id="input_zone3">{TITLE_PLANET_COORDS}</a>
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<input type="text" id="input_zone4" name="coordinates" size="10" maxlength="10" disabled="disabled" />
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a id="input_zone5">{TITLE_PLANET_FIELDS}</a>
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<input type="text" id="input_zone6" name="fields" size="8" maxlength="3" disabled="disabled" />
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a id="input_zone7">{TITLE_PLANET_TEMPS}</a>
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<input type="text" id="input_zone8" name="temperature" size="8" maxlength="3" disabled="disabled" />
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a id="input_zone9">{TITLE_PLANET_SATS}</a>
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<input type="text" id="input_zone0" name="satellite" size="8" maxlength="5" disabled="disabled" />
		</th>
		<!-- ELSE IF view_planet -->
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a id="input_zone1">{TITLE_PLANET_NAME}</a>
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<input type="text" id="input_zone2" name="planet_name" size="10" maxlength="20" disabled="disabled" />
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a id="input_zone3">{TITLE_PLANET_COORDS}</a>
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<input type="text" id="input_zone4" name="coordinates" size="10" maxlength="10" disabled="disabled" readonly />
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a id="input_zone5">{TITLE_PLANET_FIELDS}</a>
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<input type="text" id="input_zone6" name="fields" size="8" maxlength="3" disabled="disabled" />
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a id="input_zone7">{TITLE_PLANET_TEMPS}</a>
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<input type="text" id="input_zone8" name="temperature" size="8" maxlength="3" disabled="disabled" />
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<a id="input_zone9">&nbsp;</a>
		</th>
		<th style='text-align:center;margin-left:auto;margin-right:auto;'>
			<input type="hidden" id="input_zone0" name="satellite" size="8" maxlength="5" disabled="disabled" />
		</th>
		<!-- END IF view_planet -->
	</tr>
</table>
</form>
<table width="100%">
	<tr>
		<td class="c" colspan="10">
			<!--- DEBUT DU SCRIPT -->
			<script type="text/javascript">
			<!-- Begin
			for(i=0;i<10;i++)
				document.getElementById('input_zone'+i).style.display='none';
			// End -->
			</script>
			<!--- FIN DU SCRIPT -->
			{GENERAL_INFO}
		</td>
	</tr>
	<tr>
		<th style="width:10%;" >&nbsp;</th>
	<!-- BEGIN move_delete_icons -->
		<th style="width:10%;">
			<!-- IF move_delete_icons.SHOW -->
			<!-- IF move_delete_icons.PLANET -->
			<input type='image' title='{move_delete_icons.LEFT_MOVE}' src='images/previous.png'
			onclick="window.location = '?action=move_planet&amp;planet_id={move_delete_icons.I}&amp;view={VIEW}&amp;left';"/>&nbsp;
			<!-- END IF move_delete_icons.PLANET -->
			<input type='image' title='{move_delete_icons.DELETE}' src='images/drop.png' 
			onclick="window.location = '?action=del_planet&amp;planet_id={move_delete_icons.I}&amp;view={VIEW}';"/>&nbsp;
			<!-- IF move_delete_icons.PLANET -->
			<input type='image' title='{move_delete_icons.RIGHT_MOVE}' src='images/next.png' 
			onclick="window.location = '?action=move_planet&amp;planet_id={move_delete_icons.I}&amp;view={VIEW}&amp;right';"/>
			<!-- END IF move_delete_icons.PLANET -->
			<!-- END IF move_delete_icons.SHOW -->
		</th>
		<!-- END move_delete_icons -->
	</tr>
<tr>
	<th style="width:10%;"><a>{TITLE_PLANET_NAME}</a></th>
	<th style="width:10%;"><a>{planets_name1}</a></th>
	<th style="width:10%;"><a>{planets_name2}</a></th>
	<th style="width:10%;"><a>{planets_name3}</a></th>
	<th style="width:10%;"><a>{planets_name4}</a></th>
	<th style="width:10%;"><a>{planets_name5}</a></th>
	<th style="width:10%;"><a>{planets_name6}</a></th>
	<th style="width:10%;"><a>{planets_name7}</a></th>
	<th style="width:10%;"><a>{planets_name8}</a></th>
	<th style="width:10%;"><a>{planets_name9}</a></th>
</tr>
<tr>
	<th><a>{TITLE_PLANET_COORDS}</a></th>
	<th>{planets_coord1}</th>
	<th>{planets_coord2}</th>
	<th>{planets_coord3}</th>
	<th>{planets_coord4}</th>
	<th>{planets_coord5}</th>
	<th>{planets_coord6}</th>
	<th>{planets_coord7}</th>
	<th>{planets_coord8}</th>
	<th>{planets_coord9}</th>
</tr>
<tr>
	<th><a>{TITLE_PLANET_FIELDS}</a></th>
	<th>{planets_field1}</th>
	<th>{planets_field2}</th>
	<th>{planets_field3}</th>
	<th>{planets_field4}</th>
	<th>{planets_field5}</th>
	<th>{planets_field6}</th>
	<th>{planets_field7}</th>
	<th>{planets_field8}</th>
	<th>{planets_field9}</th>
</tr>
<tr>
	<th><a>{TITLE_PLANET_TEMPS}</a></th>
	<th>{planets_temp1}</th>
	<th>{planets_temp2}</th>
	<th>{planets_temp3}</th>
	<th>{planets_temp4}</th>
	<th>{planets_temp5}</th>
	<th>{planets_temp6}</th>
	<th>{planets_temp7}</th>
	<th>{planets_temp8}</th>
	<th>{planets_temp9}</th>
</tr>
<!-- IF view_planet -->
<tr>
	<td class="c" colspan="10">{PRODUCTION}</td>
</tr>
<tr>
	<th><a>{METAL}</a></th>
	<th>{prod_M1}</th>
	<th>{prod_M2}</th>
	<th>{prod_M3}</th>
	<th>{prod_M4}</th>
	<th>{prod_M5}</th>
	<th>{prod_M6}</th>
	<th>{prod_M7}</th>
	<th>{prod_M8}</th>
	<th>{prod_M9}</th>
</tr>
<tr>
	<th><a>{CRISTAL}</a></th>
	<th>{prod_C1}</th>
	<th>{prod_C2}</th>
	<th>{prod_C3}</th>
	<th>{prod_C4}</th>
	<th>{prod_C5}</th>
	<th>{prod_C6}</th>
	<th>{prod_C7}</th>
	<th>{prod_C8}</th>
	<th>{prod_C9}</th>
</tr>
<tr>
	<th><a>{DEUTERIUM}</a></th>
	<th>{prod_D1}</th>
	<th>{prod_D2}</th>
	<th>{prod_D3}</th>
	<th>{prod_D4}</th>
	<th>{prod_D5}</th>
	<th>{prod_D6}</th>
	<th>{prod_D7}</th>
	<th>{prod_D8}</th>
	<th>{prod_D9}</th>
</tr>
<tr>
	<th><a>{ENERGY}</a></th>
	<th>{prod_NRJ1}</th>
	<th>{prod_NRJ2}</th>
	<th>{prod_NRJ3}</th>
	<th>{prod_NRJ4}</th>
	<th>{prod_NRJ5}</th>
	<th>{prod_NRJ6}</th>
	<th>{prod_NRJ7}</th>
	<th>{prod_NRJ8}</th>
	<th>{prod_NRJ9}</th>
</tr>
<tr>
	<td class="c" colspan="10">{BUILDING}</td>
</tr>
<tr>
	<th><a>{METALMINE}</a></th>
	<th style="color:lime;" id='a15{building_M1_Index}'>{building_M1_value}</th>
	<th style="color:lime;" id='a15{building_M2_Index}'>{building_M2_value}</th>
	<th style="color:lime;" id='a15{building_M3_Index}'>{building_M3_value}</th>
	<th style="color:lime;" id='a15{building_M4_Index}'>{building_M4_value}</th>
	<th style="color:lime;" id='a15{building_M5_Index}'>{building_M5_value}</th>
	<th style="color:lime;" id='a15{building_M6_Index}'>{building_M6_value}</th>
	<th style="color:lime;" id='a15{building_M7_Index}'>{building_M7_value}</th>
	<th style="color:lime;" id='a15{building_M8_Index}'>{building_M8_value}</th>
	<th style="color:lime;" id='a15{building_M9_Index}'>{building_M9_value}</th>
</tr>
<tr>
	<th><a>{CRISTALMINE}</a></th>
	<th style="color:lime;" id='a16{building_C1_Index}'>{building_C1_value}</th>
	<th style="color:lime;" id='a16{building_C2_Index}'>{building_C2_value}</th>
	<th style="color:lime;" id='a16{building_C3_Index}'>{building_C3_value}</th>
	<th style="color:lime;" id='a16{building_C4_Index}'>{building_C4_value}</th>
	<th style="color:lime;" id='a16{building_C5_Index}'>{building_C5_value}</th>
	<th style="color:lime;" id='a16{building_C6_Index}'>{building_C6_value}</th>
	<th style="color:lime;" id='a16{building_C7_Index}'>{building_C7_value}</th>
	<th style="color:lime;" id='a16{building_C8_Index}'>{building_C8_value}</th>
	<th style="color:lime;" id='a16{building_C9_Index}'>{building_C9_value}</th>
</tr>
<tr>
	<th><a>{DEUTMINE}</a></th>
	<th style="color:lime;" id='a17{building_D1_Index}'>{building_D1_value}</th>
	<th style="color:lime;" id='a17{building_D2_Index}'>{building_D2_value}</th>
	<th style="color:lime;" id='a17{building_D3_Index}'>{building_D3_value}</th>
	<th style="color:lime;" id='a17{building_D4_Index}'>{building_D4_value}</th>
	<th style="color:lime;" id='a17{building_D5_Index}'>{building_D5_value}</th>
	<th style="color:lime;" id='a17{building_D6_Index}'>{building_D6_value}</th>
	<th style="color:lime;" id='a17{building_D7_Index}'>{building_D7_value}</th>
	<th style="color:lime;" id='a17{building_D8_Index}'>{building_D8_value}</th>
	<th style="color:lime;" id='a17{building_D9_Index}'>{building_D9_value}</th>
</tr>
<tr>
	<th><a>{SOLARPLANT}</a></th>
	<th style="color:lime;" id='a33{building_CES1_Index}'>{building_CES1_value}</th>
	<th style="color:lime;" id='a33{building_CES2_Index}'>{building_CES2_value}</th>
	<th style="color:lime;" id='a33{building_CES3_Index}'>{building_CES3_value}</th>
	<th style="color:lime;" id='a33{building_CES4_Index}'>{building_CES4_value}</th>
	<th style="color:lime;" id='a33{building_CES5_Index}'>{building_CES5_value}</th>
	<th style="color:lime;" id='a33{building_CES6_Index}'>{building_CES6_value}</th>
	<th style="color:lime;" id='a33{building_CES7_Index}'>{building_CES7_value}</th>
	<th style="color:lime;" id='a33{building_CES8_Index}'>{building_CES8_value}</th>
	<th style="color:lime;" id='a33{building_CES9_Index}'>{building_CES9_value}</th>
</tr>
<tr>
	<th><a>{FUSIONREACTOR}</a></th>
	<th style="color:lime;" id='a34{building_CEF1_Index}'>{building_CEF1_value}</th>
	<th style="color:lime;" id='a34{building_CEF2_Index}'>{building_CEF2_value}</th>
	<th style="color:lime;" id='a34{building_CEF3_Index}'>{building_CEF3_value}</th>
	<th style="color:lime;" id='a34{building_CEF4_Index}'>{building_CEF4_value}</th>
	<th style="color:lime;" id='a34{building_CEF5_Index}'>{building_CEF5_value}</th>
	<th style="color:lime;" id='a34{building_CEF6_Index}'>{building_CEF6_value}</th>
	<th style="color:lime;" id='a34{building_CEF7_Index}'>{building_CEF7_value}</th>
	<th style="color:lime;" id='a34{building_CEF8_Index}'>{building_CEF8_value}</th>
	<th style="color:lime;" id='a34{building_CEF9_Index}'>{building_CEF9_value}</th>
</tr>
<!-- ELSE IF view_planet -->
<tr>
	<td class="c" colspan="10">{BUILDING}</td>
</tr>
<!-- END IF view_planet -->
<tr>
	<th><a>{ROBOTICFACTORY}</a></th>
	<th style="color:lime;" id='a1{building_UdR1_Index}'>{building_UdR1_value}</th>
	<th style="color:lime;" id='a1{building_UdR2_Index}'>{building_UdR2_value}</th>
	<th style="color:lime;" id='a1{building_UdR3_Index}'>{building_UdR3_value}</th>
	<th style="color:lime;" id='a1{building_UdR4_Index}'>{building_UdR4_value}</th>
	<th style="color:lime;" id='a1{building_UdR5_Index}'>{building_UdR5_value}</th>
	<th style="color:lime;" id='a1{building_UdR6_Index}'>{building_UdR6_value}</th>
	<th style="color:lime;" id='a1{building_UdR7_Index}'>{building_UdR7_value}</th>
	<th style="color:lime;" id='a1{building_UdR8_Index}'>{building_UdR8_value}</th>
	<th style="color:lime;" id='a1{building_UdR9_Index}'>{building_UdR9_value}</th>
</tr>
<!-- IF view_planet -->
<tr>
	<th><a>{NANITEFACTORY}</a></th>
	<th style="color:lime;" id='a35{building_UdN1_Index}'>{building_UdN1_value}</th>
	<th style="color:lime;" id='a35{building_UdN2_Index}'>{building_UdN2_value}</th>
	<th style="color:lime;" id='a35{building_UdN3_Index}'>{building_UdN3_value}</th>
	<th style="color:lime;" id='a35{building_UdN4_Index}'>{building_UdN4_value}</th>
	<th style="color:lime;" id='a35{building_UdN5_Index}'>{building_UdN5_value}</th>
	<th style="color:lime;" id='a35{building_UdN6_Index}'>{building_UdN6_value}</th>
	<th style="color:lime;" id='a35{building_UdN7_Index}'>{building_UdN7_value}</th>
	<th style="color:lime;" id='a35{building_UdN8_Index}'>{building_UdN8_value}</th>
	<th style="color:lime;" id='a35{building_UdN9_Index}'>{building_UdN9_value}</th>
</tr>
<!-- END IF view_planet -->
<tr>
	<th><a>{SHIPYARD}</a></th>
	<th style="color:lime;" id='a2{building_CSp1_Index}'>{building_CSp1_value}</th>
	<th style="color:lime;" id='a2{building_CSp2_Index}'>{building_CSp2_value}</th>
	<th style="color:lime;" id='a2{building_CSp3_Index}'>{building_CSp3_value}</th>
	<th style="color:lime;" id='a2{building_CSp4_Index}'>{building_CSp4_value}</th>
	<th style="color:lime;" id='a2{building_CSp5_Index}'>{building_CSp5_value}</th>
	<th style="color:lime;" id='a2{building_CSp6_Index}'>{building_CSp6_value}</th>
	<th style="color:lime;" id='a2{building_CSp7_Index}'>{building_CSp7_value}</th>
	<th style="color:lime;" id='a2{building_CSp8_Index}'>{building_CSp8_value}</th>
	<th style="color:lime;" id='a2{building_CSp9_Index}'>{building_CSp9_value}</th>
</tr>
<tr>
	<th><a>{METALSTORAGE}</a></th>
	<th style="color:lime;" id='a3{building_HM1_Index}'>{building_HM1_value}</th>
	<th style="color:lime;" id='a3{building_HM2_Index}'>{building_HM2_value}</th>
	<th style="color:lime;" id='a3{building_HM3_Index}'>{building_HM3_value}</th>
	<th style="color:lime;" id='a3{building_HM4_Index}'>{building_HM4_value}</th>
	<th style="color:lime;" id='a3{building_HM5_Index}'>{building_HM5_value}</th>
	<th style="color:lime;" id='a3{building_HM6_Index}'>{building_HM6_value}</th>
	<th style="color:lime;" id='a3{building_HM7_Index}'>{building_HM7_value}</th>
	<th style="color:lime;" id='a3{building_HM8_Index}'>{building_HM8_value}</th>
	<th style="color:lime;" id='a3{building_HM9_Index}'>{building_HM9_value}</th>
</tr>
<tr>
	<th><a>{CRISTALSTORAGE}</a></th>
	<th style="color:lime;" id='a4{building_HC1_Index}'>{building_HC1_value}</th>
	<th style="color:lime;" id='a4{building_HC2_Index}'>{building_HC2_value}</th>
	<th style="color:lime;" id='a4{building_HC3_Index}'>{building_HC3_value}</th>
	<th style="color:lime;" id='a4{building_HC4_Index}'>{building_HC4_value}</th>
	<th style="color:lime;" id='a4{building_HC5_Index}'>{building_HC5_value}</th>
	<th style="color:lime;" id='a4{building_HC6_Index}'>{building_HC6_value}</th>
	<th style="color:lime;" id='a4{building_HC7_Index}'>{building_HC7_value}</th>
	<th style="color:lime;" id='a4{building_HC8_Index}'>{building_HC8_value}</th>
	<th style="color:lime;" id='a4{building_HC9_Index}'>{building_HC9_value}</th>
</tr>
<tr>
	<th><a>{DEUTERIUMTANK}</a></th>
	<th style="color:lime;" id='a5{building_HD1_Index}'>{building_HD1_value}</th>
	<th style="color:lime;" id='a5{building_HD2_Index}'>{building_HD2_value}</th>
	<th style="color:lime;" id='a5{building_HD3_Index}'>{building_HD3_value}</th>
	<th style="color:lime;" id='a5{building_HD4_Index}'>{building_HD4_value}</th>
	<th style="color:lime;" id='a5{building_HD5_Index}'>{building_HD5_value}</th>
	<th style="color:lime;" id='a5{building_HD6_Index}'>{building_HD6_value}</th>
	<th style="color:lime;" id='a5{building_HD7_Index}'>{building_HD7_value}</th>
	<th style="color:lime;" id='a5{building_HD8_Index}'>{building_HD8_value}</th>
	<th style="color:lime;" id='a5{building_HD9_Index}'>{building_HD9_value}</th>
</tr>
<!-- IF view_planet -->
<tr>
	<th><a>{RESEARCHLAB}</a></th>
	<th style="color:lime;" id='a36{building_Lab1_Index}'>{building_Lab1_value}</th>
	<th style="color:lime;" id='a36{building_Lab2_Index}'>{building_Lab2_value}</th>
	<th style="color:lime;" id='a36{building_Lab3_Index}'>{building_Lab3_value}</th>
	<th style="color:lime;" id='a36{building_Lab4_Index}'>{building_Lab4_value}</th>
	<th style="color:lime;" id='a36{building_Lab5_Index}'>{building_Lab5_value}</th>
	<th style="color:lime;" id='a36{building_Lab6_Index}'>{building_Lab6_value}</th>
	<th style="color:lime;" id='a36{building_Lab7_Index}'>{building_Lab7_value}</th>
	<th style="color:lime;" id='a36{building_Lab8_Index}'>{building_Lab8_value}</th>
	<th style="color:lime;" id='a36{building_Lab9_Index}'>{building_Lab9_value}</th>
</tr>
<!-- IF is_ddr -->
<tr>
	<th><a>{DEPOTRAV}</a></th>
	<th style="color:lime;" id='a55{building_DdR1_Index}'>{building_DdR1_value}</th>
	<th style="color:lime;" id='a55{building_DdR2_Index}'>{building_DdR2_value}</th>
	<th style="color:lime;" id='a55{building_DdR3_Index}'>{building_DdR3_value}</th>
	<th style="color:lime;" id='a55{building_DdR4_Index}'>{building_DdR4_value}</th>
	<th style="color:lime;" id='a55{building_DdR5_Index}'>{building_DdR5_value}</th>
	<th style="color:lime;" id='a55{building_DdR6_Index}'>{building_DdR6_value}</th>
	<th style="color:lime;" id='a55{building_DdR7_Index}'>{building_DdR7_value}</th>
	<th style="color:lime;" id='a55{building_DdR8_Index}'>{building_DdR8_value}</th>
	<th style="color:lime;" id='a55{building_DdR9_Index}'>{building_DdR9_value}</th>
</tr>
<!-- END IF is_ddr -->
<tr>
	<th><a>{TERRAFORMER}</a></th>
	<th style="color:lime;" id='a37{building_Ter1_Index}'>{building_Ter1_value}</th>
	<th style="color:lime;" id='a37{building_Ter2_Index}'>{building_Ter2_value}</th>
	<th style="color:lime;" id='a37{building_Ter3_Index}'>{building_Ter3_value}</th>
	<th style="color:lime;" id='a37{building_Ter4_Index}'>{building_Ter4_value}</th>
	<th style="color:lime;" id='a37{building_Ter5_Index}'>{building_Ter5_value}</th>
	<th style="color:lime;" id='a37{building_Ter6_Index}'>{building_Ter6_value}</th>
	<th style="color:lime;" id='a37{building_Ter7_Index}'>{building_Ter7_value}</th>
	<th style="color:lime;" id='a37{building_Ter8_Index}'>{building_Ter8_value}</th>
	<th style="color:lime;" id='a37{building_Ter9_Index}'>{building_Ter9_value}</th>
</tr>
<tr>
	<th><a>{MISSILESSILO}</a></th>
	<th style="color:lime;" id='a38{building_Silo1_Index}'>{building_Silo1_value}</th>
	<th style="color:lime;" id='a38{building_Silo2_Index}'>{building_Silo2_value}</th>
	<th style="color:lime;" id='a38{building_Silo3_Index}'>{building_Silo3_value}</th>
	<th style="color:lime;" id='a38{building_Silo4_Index}'>{building_Silo4_value}</th>
	<th style="color:lime;" id='a38{building_Silo5_Index}'>{building_Silo5_value}</th>
	<th style="color:lime;" id='a38{building_Silo6_Index}'>{building_Silo6_value}</th>
	<th style="color:lime;" id='a38{building_Silo7_Index}'>{building_Silo7_value}</th>
	<th style="color:lime;" id='a38{building_Silo8_Index}'>{building_Silo8_value}</th>
	<th style="color:lime;" id='a38{building_Silo9_Index}'>{building_Silo9_value}</th>
</tr>
<!-- ELSE IF view_planet -->
<tr>
	<th><a>{LUNARBASE}</a></th>
	<th style="color:lime;" id='a15{building_BaLu1_Index}'>{building_BaLu1_value}</th>
	<th style="color:lime;" id='a15{building_BaLu2_Index}'>{building_BaLu2_value}</th>
	<th style="color:lime;" id='a15{building_BaLu3_Index}'>{building_BaLu3_value}</th>
	<th style="color:lime;" id='a15{building_BaLu4_Index}'>{building_BaLu4_value}</th>
	<th style="color:lime;" id='a15{building_BaLu5_Index}'>{building_BaLu5_value}</th>
	<th style="color:lime;" id='a15{building_BaLu6_Index}'>{building_BaLu6_value}</th>
	<th style="color:lime;" id='a15{building_BaLu7_Index}'>{building_BaLu7_value}</th>
	<th style="color:lime;" id='a15{building_BaLu8_Index}'>{building_BaLu8_value}</th>
	<th style="color:lime;" id='a15{building_BaLu9_Index}'>{building_BaLu9_value}</th>
</tr>
<tr>
	<th><a>{PHALANX}</a></th>
	<th style="color:lime;" id='a16{building_Pha1_Index}'>{building_Pha1_value}</th>
	<th style="color:lime;" id='a16{building_Pha2_Index}'>{building_Pha2_value}</th>
	<th style="color:lime;" id='a16{building_Pha3_Index}'>{building_Pha3_value}</th>
	<th style="color:lime;" id='a16{building_Pha4_Index}'>{building_Pha4_value}</th>
	<th style="color:lime;" id='a16{building_Pha5_Index}'>{building_Pha5_value}</th>
	<th style="color:lime;" id='a16{building_Pha6_Index}'>{building_Pha6_value}</th>
	<th style="color:lime;" id='a16{building_Pha7_Index}'>{building_Pha7_value}</th>
	<th style="color:lime;" id='a16{building_Pha8_Index}'>{building_Pha8_value}</th>
	<th style="color:lime;" id='a16{building_Pha9_Index}'>{building_Pha9_value}</th>
</tr>
<tr>
	<th><a>{JUMPGATE}</a></th>
	<th style="color:lime;" id='a17{building_PoSa1_Index}'>{building_PoSa1_value}</th>
	<th style="color:lime;" id='a17{building_PoSa2_Index}'>{building_PoSa2_value}</th>
	<th style="color:lime;" id='a17{building_PoSa3_Index}'>{building_PoSa3_value}</th>
	<th style="color:lime;" id='a17{building_PoSa4_Index}'>{building_PoSa4_value}</th>
	<th style="color:lime;" id='a17{building_PoSa5_Index}'>{building_PoSa5_value}</th>
	<th style="color:lime;" id='a17{building_PoSa6_Index}'>{building_PoSa6_value}</th>
	<th style="color:lime;" id='a17{building_PoSa7_Index}'>{building_PoSa7_value}</th>
	<th style="color:lime;" id='a17{building_PoSa8_Index}'>{building_PoSa8_value}</th>
	<th style="color:lime;" id='a17{building_PoSa9_Index}'>{building_PoSa9_value}</th>
</tr>
<!-- END IF view_planet -->
<!-- IF view_planet -->
<tr>
	<td class="c" colspan="10">{TECHNOLOGY}</td>
</tr>
<tr>
	<th><a>{SPY_TECH}</a></th>
	<th style="color:lime;" id='a39{techno_Esp1_Index}'>{techno_Esp1_value}</th>
	<th style="color:lime;" id='a39{techno_Esp2_Index}'>{techno_Esp2_value}</th>
	<th style="color:lime;" id='a39{techno_Esp3_Index}'>{techno_Esp3_value}</th>
	<th style="color:lime;" id='a39{techno_Esp4_Index}'>{techno_Esp4_value}</th>
	<th style="color:lime;" id='a39{techno_Esp5_Index}'>{techno_Esp5_value}</th>
	<th style="color:lime;" id='a39{techno_Esp6_Index}'>{techno_Esp6_value}</th>
	<th style="color:lime;" id='a39{techno_Esp7_Index}'>{techno_Esp7_value}</th>
	<th style="color:lime;" id='a39{techno_Esp8_Index}'>{techno_Esp8_value}</th>
	<th style="color:lime;" id='a39{techno_Esp9_Index}'>{techno_Esp9_value}</th>
</tr>
<tr>
	<th><a>{COMPUTER_TECH}</a></th>
	<th style="color:lime;" id='a40{techno_Ordi1_Index}'>{techno_Ordi1_value}</th>
	<th style="color:lime;" id='a40{techno_Ordi2_Index}'>{techno_Ordi2_value}</th>
	<th style="color:lime;" id='a40{techno_Ordi3_Index}'>{techno_Ordi3_value}</th>
	<th style="color:lime;" id='a40{techno_Ordi4_Index}'>{techno_Ordi4_value}</th>
	<th style="color:lime;" id='a40{techno_Ordi5_Index}'>{techno_Ordi5_value}</th>
	<th style="color:lime;" id='a40{techno_Ordi6_Index}'>{techno_Ordi6_value}</th>
	<th style="color:lime;" id='a40{techno_Ordi7_Index}'>{techno_Ordi7_value}</th>
	<th style="color:lime;" id='a40{techno_Ordi8_Index}'>{techno_Ordi8_value}</th>
	<th style="color:lime;" id='a40{techno_Ordi9_Index}'>{techno_Ordi9_value}</th>
</tr>
<tr>
	<th><a>{WEAPONS_TECH}</a></th>
	<th style="color:lime;" id='a41{techno_Armes1_Index}'>{techno_Armes1_value}</th>
	<th style="color:lime;" id='a41{techno_Armes2_Index}'>{techno_Armes2_value}</th>
	<th style="color:lime;" id='a41{techno_Armes3_Index}'>{techno_Armes3_value}</th>
	<th style="color:lime;" id='a41{techno_Armes4_Index}'>{techno_Armes4_value}</th>
	<th style="color:lime;" id='a41{techno_Armes5_Index}'>{techno_Armes5_value}</th>
	<th style="color:lime;" id='a41{techno_Armes6_Index}'>{techno_Armes6_value}</th>
	<th style="color:lime;" id='a41{techno_Armes7_Index}'>{techno_Armes7_value}</th>
	<th style="color:lime;" id='a41{techno_Armes8_Index}'>{techno_Armes8_value}</th>
	<th style="color:lime;" id='a41{techno_Armes9_Index}'>{techno_Armes9_value}</th>
</tr>
<tr>
	<th><a>{SHIELD_TECH}</a></th>
	<th style="color:lime;" id='a42{techno_Bouclier1_Index}'>{techno_Bouclier1_value}</th>
	<th style="color:lime;" id='a42{techno_Bouclier2_Index}'>{techno_Bouclier2_value}</th>
	<th style="color:lime;" id='a42{techno_Bouclier3_Index}'>{techno_Bouclier3_value}</th>
	<th style="color:lime;" id='a42{techno_Bouclier4_Index}'>{techno_Bouclier4_value}</th>
	<th style="color:lime;" id='a42{techno_Bouclier5_Index}'>{techno_Bouclier5_value}</th>
	<th style="color:lime;" id='a42{techno_Bouclier6_Index}'>{techno_Bouclier6_value}</th>
	<th style="color:lime;" id='a42{techno_Bouclier7_Index}'>{techno_Bouclier7_value}</th>
	<th style="color:lime;" id='a42{techno_Bouclier8_Index}'>{techno_Bouclier8_value}</th>
	<th style="color:lime;" id='a42{techno_Bouclier9_Index}'>{techno_Bouclier9_value}</th>
</tr>
<tr>
	<th><a>{ARMOR_TECH}</a></th>
	<th style="color:lime;" id='a43{techno_Protection1_Index}'>{techno_Protection1_value}</th>
	<th style="color:lime;" id='a43{techno_Protection2_Index}'>{techno_Protection2_value}</th>
	<th style="color:lime;" id='a43{techno_Protection3_Index}'>{techno_Protection3_value}</th>
	<th style="color:lime;" id='a43{techno_Protection4_Index}'>{techno_Protection4_value}</th>
	<th style="color:lime;" id='a43{techno_Protection5_Index}'>{techno_Protection5_value}</th>
	<th style="color:lime;" id='a43{techno_Protection6_Index}'>{techno_Protection6_value}</th>
	<th style="color:lime;" id='a43{techno_Protection7_Index}'>{techno_Protection7_value}</th>
	<th style="color:lime;" id='a43{techno_Protection8_Index}'>{techno_Protection8_value}</th>
	<th style="color:lime;" id='a43{techno_Protection9_Index}'>{techno_Protection9_value}</th>
</tr>
<tr>
	<th><a>{ENERGY_TECH}</a></th>
	<th style="color:lime;" id='a44{techno_NRJ1_Index}'>{techno_NRJ1_value}</th>
	<th style="color:lime;" id='a44{techno_NRJ2_Index}'>{techno_NRJ2_value}</th>
	<th style="color:lime;" id='a44{techno_NRJ3_Index}'>{techno_NRJ3_value}</th>
	<th style="color:lime;" id='a44{techno_NRJ4_Index}'>{techno_NRJ4_value}</th>
	<th style="color:lime;" id='a44{techno_NRJ5_Index}'>{techno_NRJ5_value}</th>
	<th style="color:lime;" id='a44{techno_NRJ6_Index}'>{techno_NRJ6_value}</th>
	<th style="color:lime;" id='a44{techno_NRJ7_Index}'>{techno_NRJ7_value}</th>
	<th style="color:lime;" id='a44{techno_NRJ8_Index}'>{techno_NRJ8_value}</th>
	<th style="color:lime;" id='a44{techno_NRJ9_Index}'>{techno_NRJ9_value}</th>
</tr>
<tr>
	<th><a>{HYPERSPACE_TECH}</a></th>
	<th style="color:lime;" id='a45{techno_Hyp1_Index}'>{techno_Hyp1_value}</th>
	<th style="color:lime;" id='a45{techno_Hyp2_Index}'>{techno_Hyp2_value}</th>
	<th style="color:lime;" id='a45{techno_Hyp3_Index}'>{techno_Hyp3_value}</th>
	<th style="color:lime;" id='a45{techno_Hyp4_Index}'>{techno_Hyp4_value}</th>
	<th style="color:lime;" id='a45{techno_Hyp5_Index}'>{techno_Hyp5_value}</th>
	<th style="color:lime;" id='a45{techno_Hyp6_Index}'>{techno_Hyp6_value}</th>
	<th style="color:lime;" id='a45{techno_Hyp7_Index}'>{techno_Hyp7_value}</th>
	<th style="color:lime;" id='a45{techno_Hyp8_Index}'>{techno_Hyp8_value}</th>
	<th style="color:lime;" id='a45{techno_Hyp9_Index}'>{techno_Hyp9_value}</th>
</tr>
<tr>
	<th><a>{COMBUSTION_DRIVE}</a></th>
	<th style="color:lime;" id='a46{techno_RC1_Index}'>{techno_RC1_value}</th>
	<th style="color:lime;" id='a46{techno_RC2_Index}'>{techno_RC2_value}</th>
	<th style="color:lime;" id='a46{techno_RC3_Index}'>{techno_RC3_value}</th>
	<th style="color:lime;" id='a46{techno_RC4_Index}'>{techno_RC4_value}</th>
	<th style="color:lime;" id='a46{techno_RC5_Index}'>{techno_RC5_value}</th>
	<th style="color:lime;" id='a46{techno_RC6_Index}'>{techno_RC6_value}</th>
	<th style="color:lime;" id='a46{techno_RC7_Index}'>{techno_RC7_value}</th>
	<th style="color:lime;" id='a46{techno_RC8_Index}'>{techno_RC8_value}</th>
	<th style="color:lime;" id='a46{techno_RC9_Index}'>{techno_RC9_value}</th>
</tr>
<tr>
	<th><a>{IMPULSE_DRIVE}</a></th>
	<th style="color:lime;" id='a47{techno_RI1_Index}'>{techno_RI1_value}</th>
	<th style="color:lime;" id='a47{techno_RI2_Index}'>{techno_RI2_value}</th>
	<th style="color:lime;" id='a47{techno_RI3_Index}'>{techno_RI3_value}</th>
	<th style="color:lime;" id='a47{techno_RI4_Index}'>{techno_RI4_value}</th>
	<th style="color:lime;" id='a47{techno_RI5_Index}'>{techno_RI5_value}</th>
	<th style="color:lime;" id='a47{techno_RI6_Index}'>{techno_RI6_value}</th>
	<th style="color:lime;" id='a47{techno_RI7_Index}'>{techno_RI7_value}</th>
	<th style="color:lime;" id='a47{techno_RI8_Index}'>{techno_RI8_value}</th>
	<th style="color:lime;" id='a47{techno_RI9_Index}'>{techno_RI9_value}</th>
</tr>
<tr>
	<th><a>{HYPERSPACE_DRIVE}</a></th>
	<th style="color:lime;" id='a48{techno_PH1_Index}'>{techno_PH1_value}</th>
	<th style="color:lime;" id='a48{techno_PH2_Index}'>{techno_PH2_value}</th>
	<th style="color:lime;" id='a48{techno_PH3_Index}'>{techno_PH3_value}</th>
	<th style="color:lime;" id='a48{techno_PH4_Index}'>{techno_PH4_value}</th>
	<th style="color:lime;" id='a48{techno_PH5_Index}'>{techno_PH5_value}</th>
	<th style="color:lime;" id='a48{techno_PH6_Index}'>{techno_PH6_value}</th>
	<th style="color:lime;" id='a48{techno_PH7_Index}'>{techno_PH7_value}</th>
	<th style="color:lime;" id='a48{techno_PH8_Index}'>{techno_PH8_value}</th>
	<th style="color:lime;" id='a48{techno_PH9_Index}'>{techno_PH9_value}</th>
</tr>
<tr>
	<th><a>{LASER_TECH}</a></th>
	<th style="color:lime;" id='a49{techno_Laser1_Index}'>{techno_Laser1_value}</th>
	<th style="color:lime;" id='a49{techno_Laser2_Index}'>{techno_Laser2_value}</th>
	<th style="color:lime;" id='a49{techno_Laser3_Index}'>{techno_Laser3_value}</th>
	<th style="color:lime;" id='a49{techno_Laser4_Index}'>{techno_Laser4_value}</th>
	<th style="color:lime;" id='a49{techno_Laser5_Index}'>{techno_Laser5_value}</th>
	<th style="color:lime;" id='a49{techno_Laser6_Index}'>{techno_Laser6_value}</th>
	<th style="color:lime;" id='a49{techno_Laser7_Index}'>{techno_Laser7_value}</th>
	<th style="color:lime;" id='a49{techno_Laser8_Index}'>{techno_Laser8_value}</th>
	<th style="color:lime;" id='a49{techno_Laser9_Index}'>{techno_Laser9_value}</th>
</tr>
<tr>
	<th><a>{ION_TECH}</a></th>
	<th style="color:lime;" id='a50{techno_Ions1_Index}'>{techno_Ions1_value}</th>
	<th style="color:lime;" id='a50{techno_Ions2_Index}'>{techno_Ions2_value}</th>
	<th style="color:lime;" id='a50{techno_Ions3_Index}'>{techno_Ions3_value}</th>
	<th style="color:lime;" id='a50{techno_Ions4_Index}'>{techno_Ions4_value}</th>
	<th style="color:lime;" id='a50{techno_Ions5_Index}'>{techno_Ions5_value}</th>
	<th style="color:lime;" id='a50{techno_Ions6_Index}'>{techno_Ions6_value}</th>
	<th style="color:lime;" id='a50{techno_Ions7_Index}'>{techno_Ions7_value}</th>
	<th style="color:lime;" id='a50{techno_Ions8_Index}'>{techno_Ions8_value}</th>
	<th style="color:lime;" id='a50{techno_Ions9_Index}'>{techno_Ions9_value}</th>
</tr>
<tr>
	<th><a>{PLASMA_TECH}</a></th>
	<th style="color:lime;" id='a51{techno_Plasma1_Index}'>{techno_Plasma1_value}</th>
	<th style="color:lime;" id='a51{techno_Plasma2_Index}'>{techno_Plasma2_value}</th>
	<th style="color:lime;" id='a51{techno_Plasma3_Index}'>{techno_Plasma3_value}</th>
	<th style="color:lime;" id='a51{techno_Plasma4_Index}'>{techno_Plasma4_value}</th>
	<th style="color:lime;" id='a51{techno_Plasma5_Index}'>{techno_Plasma5_value}</th>
	<th style="color:lime;" id='a51{techno_Plasma6_Index}'>{techno_Plasma6_value}</th>
	<th style="color:lime;" id='a51{techno_Plasma7_Index}'>{techno_Plasma7_value}</th>
	<th style="color:lime;" id='a51{techno_Plasma8_Index}'>{techno_Plasma8_value}</th>
	<th style="color:lime;" id='a51{techno_Plasma9_Index}'>{techno_Plasma9_value}</th>
</tr>
<tr>
	<th><a>{RESEARCH_NETWORK}</a></th>
	<th style="color:lime;" id='a52{techno_RRI1_Index}'>{techno_RRI1_value}</th>
	<th style="color:lime;" id='a52{techno_RRI2_Index}'>{techno_RRI2_value}</th>
	<th style="color:lime;" id='a52{techno_RRI3_Index}'>{techno_RRI3_value}</th>
	<th style="color:lime;" id='a52{techno_RRI4_Index}'>{techno_RRI4_value}</th>
	<th style="color:lime;" id='a52{techno_RRI5_Index}'>{techno_RRI5_value}</th>
	<th style="color:lime;" id='a52{techno_RRI6_Index}'>{techno_RRI6_value}</th>
	<th style="color:lime;" id='a52{techno_RRI7_Index}'>{techno_RRI7_value}</th>
	<th style="color:lime;" id='a52{techno_RRI8_Index}'>{techno_RRI8_value}</th>
	<th style="color:lime;" id='a52{techno_RRI9_Index}'>{techno_RRI9_value}</th>
</tr>
<tr>
	<th><a>{EXPEDITIONS}</a></th>
	<th style="color:lime;" id='a54{techno_Expeditions1_Index}'>{techno_Expeditions1_value}</th>
	<th style="color:lime;" id='a54{techno_Expeditions2_Index}'>{techno_Expeditions2_value}</th>
	<th style="color:lime;" id='a54{techno_Expeditions3_Index}'>{techno_Expeditions3_value}</th>
	<th style="color:lime;" id='a54{techno_Expeditions4_Index}'>{techno_Expeditions4_value}</th>
	<th style="color:lime;" id='a54{techno_Expeditions5_Index}'>{techno_Expeditions5_value}</th>
	<th style="color:lime;" id='a54{techno_Expeditions6_Index}'>{techno_Expeditions6_value}</th>
	<th style="color:lime;" id='a54{techno_Expeditions7_Index}'>{techno_Expeditions7_value}</th>
	<th style="color:lime;" id='a54{techno_Expeditions8_Index}'>{techno_Expeditions8_value}</th>
	<th style="color:lime;" id='a54{techno_Expeditions9_Index}'>{techno_Expeditions9_value}</th>
</tr>
<tr>
	<th><a>{GRAVITON}</a></th>
	<th style="color:lime;" id='a53{techno_Graviton1_Index}'>{techno_Graviton1_value}</th>
	<th style="color:lime;" id='a53{techno_Graviton2_Index}'>{techno_Graviton2_value}</th>
	<th style="color:lime;" id='a53{techno_Graviton3_Index}'>{techno_Graviton3_value}</th>
	<th style="color:lime;" id='a53{techno_Graviton4_Index}'>{techno_Graviton4_value}</th>
	<th style="color:lime;" id='a53{techno_Graviton5_Index}'>{techno_Graviton5_value}</th>
	<th style="color:lime;" id='a53{techno_Graviton6_Index}'>{techno_Graviton6_value}</th>
	<th style="color:lime;" id='a53{techno_Graviton7_Index}'>{techno_Graviton7_value}</th>
	<th style="color:lime;" id='a53{techno_Graviton8_Index}'>{techno_Graviton8_value}</th>
	<th style="color:lime;" id='a53{techno_Graviton9_Index}'>{techno_Graviton9_value}</th>
</tr>
<!-- END IF view_planet -->
<tr>
	<td class="c" colspan="10">{DEFENCE}</td>
</tr>
<tr>
	<th><a>{ROCKET_LAUNCHER}</a></th>
	<th style="color:lime;" id='a7{defence_LM1_Index}'>{defence_LM1_value}</th>
	<th style="color:lime;" id='a7{defence_LM2_Index}'>{defence_LM2_value}</th>
	<th style="color:lime;" id='a7{defence_LM3_Index}'>{defence_LM3_value}</th>
	<th style="color:lime;" id='a7{defence_LM4_Index}'>{defence_LM4_value}</th>
	<th style="color:lime;" id='a7{defence_LM5_Index}'>{defence_LM5_value}</th>
	<th style="color:lime;" id='a7{defence_LM6_Index}'>{defence_LM6_value}</th>
	<th style="color:lime;" id='a7{defence_LM7_Index}'>{defence_LM7_value}</th>
	<th style="color:lime;" id='a7{defence_LM8_Index}'>{defence_LM8_value}</th>
	<th style="color:lime;" id='a7{defence_LM9_Index}'>{defence_LM9_value}</th>
</tr>
<tr>
	<th><a>{LIGHT_LASER}</a></th>
	<th style="color:lime;" id='a8{defence_LLE1_Index}'>{defence_LLE1_value}</th>
	<th style="color:lime;" id='a8{defence_LLE2_Index}'>{defence_LLE2_value}</th>
	<th style="color:lime;" id='a8{defence_LLE3_Index}'>{defence_LLE3_value}</th>
	<th style="color:lime;" id='a8{defence_LLE4_Index}'>{defence_LLE4_value}</th>
	<th style="color:lime;" id='a8{defence_LLE5_Index}'>{defence_LLE5_value}</th>
	<th style="color:lime;" id='a8{defence_LLE6_Index}'>{defence_LLE6_value}</th>
	<th style="color:lime;" id='a8{defence_LLE7_Index}'>{defence_LLE7_value}</th>
	<th style="color:lime;" id='a8{defence_LLE8_Index}'>{defence_LLE8_value}</th>
	<th style="color:lime;" id='a8{defence_LLE9_Index}'>{defence_LLE9_value}</th>
</tr>
<tr>
	<th><a>{HEAVY_LASER}</a></th>
	<th style="color:lime;" id='a9{defence_LLO1_Index}'>{defence_LLO1_value}</th>
	<th style="color:lime;" id='a9{defence_LLO2_Index}'>{defence_LLO2_value}</th>
	<th style="color:lime;" id='a9{defence_LLO3_Index}'>{defence_LLO3_value}</th>
	<th style="color:lime;" id='a9{defence_LLO4_Index}'>{defence_LLO4_value}</th>
	<th style="color:lime;" id='a9{defence_LLO5_Index}'>{defence_LLO5_value}</th>
	<th style="color:lime;" id='a9{defence_LLO6_Index}'>{defence_LLO6_value}</th>
	<th style="color:lime;" id='a9{defence_LLO7_Index}'>{defence_LLO7_value}</th>
	<th style="color:lime;" id='a9{defence_LLO8_Index}'>{defence_LLO8_value}</th>
	<th style="color:lime;" id='a9{defence_LLO9_Index}'>{defence_LLO9_value}</th>
</tr>
<tr>
	<th><a>{GAUSS_CANON}</a></th>
	<th style="color:lime;" id='a10{defence_CG1_Index}'>{defence_CG1_value}</th>
	<th style="color:lime;" id='a10{defence_CG2_Index}'>{defence_CG2_value}</th>
	<th style="color:lime;" id='a10{defence_CG3_Index}'>{defence_CG3_value}</th>
	<th style="color:lime;" id='a10{defence_CG4_Index}'>{defence_CG4_value}</th>
	<th style="color:lime;" id='a10{defence_CG5_Index}'>{defence_CG5_value}</th>
	<th style="color:lime;" id='a10{defence_CG6_Index}'>{defence_CG6_value}</th>
	<th style="color:lime;" id='a10{defence_CG7_Index}'>{defence_CG7_value}</th>
	<th style="color:lime;" id='a10{defence_CG8_Index}'>{defence_CG8_value}</th>
	<th style="color:lime;" id='a10{defence_CG9_Index}'>{defence_CG9_value}</th>
</tr>
<tr>
	<th><a>{ION_CANON}</a></th>
	<th style="color:lime;" id='a11{defence_AI1_Index}'>{defence_AI1_value}</th>
	<th style="color:lime;" id='a11{defence_AI2_Index}'>{defence_AI2_value}</th>
	<th style="color:lime;" id='a11{defence_AI3_Index}'>{defence_AI3_value}</th>
	<th style="color:lime;" id='a11{defence_AI4_Index}'>{defence_AI4_value}</th>
	<th style="color:lime;" id='a11{defence_AI5_Index}'>{defence_AI5_value}</th>
	<th style="color:lime;" id='a11{defence_AI6_Index}'>{defence_AI6_value}</th>
	<th style="color:lime;" id='a11{defence_AI7_Index}'>{defence_AI7_value}</th>
	<th style="color:lime;" id='a11{defence_AI8_Index}'>{defence_AI8_value}</th>
	<th style="color:lime;" id='a11{defence_AI9_Index}'>{defence_AI9_value}</th>
</tr>
<tr>
	<th><a>{PLASMA_CANON}</a></th>
	<th style="color:lime;" id='a12{defence_LP1_Index}'>{defence_LP1_value}</th>
	<th style="color:lime;" id='a12{defence_LP2_Index}'>{defence_LP2_value}</th>
	<th style="color:lime;" id='a12{defence_LP3_Index}'>{defence_LP3_value}</th>
	<th style="color:lime;" id='a12{defence_LP4_Index}'>{defence_LP4_value}</th>
	<th style="color:lime;" id='a12{defence_LP5_Index}'>{defence_LP5_value}</th>
	<th style="color:lime;" id='a12{defence_LP6_Index}'>{defence_LP6_value}</th>
	<th style="color:lime;" id='a12{defence_LP7_Index}'>{defence_LP7_value}</th>
	<th style="color:lime;" id='a12{defence_LP8_Index}'>{defence_LP8_value}</th>
	<th style="color:lime;" id='a12{defence_LP9_Index}'>{defence_LP9_value}</th>
</tr>
<tr>
	<th><a>{SMALL_SHIELD}</a></th>
	<th style="color:lime;" id='a13{defence_PB1_Index}'>{defence_PB1_value}</th>
	<th style="color:lime;" id='a13{defence_PB2_Index}'>{defence_PB2_value}</th>
	<th style="color:lime;" id='a13{defence_PB3_Index}'>{defence_PB3_value}</th>
	<th style="color:lime;" id='a13{defence_PB4_Index}'>{defence_PB4_value}</th>
	<th style="color:lime;" id='a13{defence_PB5_Index}'>{defence_PB5_value}</th>
	<th style="color:lime;" id='a13{defence_PB6_Index}'>{defence_PB6_value}</th>
	<th style="color:lime;" id='a13{defence_PB7_Index}'>{defence_PB7_value}</th>
	<th style="color:lime;" id='a13{defence_PB8_Index}'>{defence_PB8_value}</th>
	<th style="color:lime;" id='a13{defence_PB9_Index}'>{defence_PB9_value}</th>
</tr>
<tr>
	<th><a>{LARGE_SHIELD}</a></th>
	<th style="color:lime;" id='a14{defence_GB1_Index}'>{defence_GB1_value}</th>
	<th style="color:lime;" id='a14{defence_GB2_Index}'>{defence_GB2_value}</th>
	<th style="color:lime;" id='a14{defence_GB3_Index}'>{defence_GB3_value}</th>
	<th style="color:lime;" id='a14{defence_GB4_Index}'>{defence_GB4_value}</th>
	<th style="color:lime;" id='a14{defence_GB5_Index}'>{defence_GB5_value}</th>
	<th style="color:lime;" id='a14{defence_GB6_Index}'>{defence_GB6_value}</th>
	<th style="color:lime;" id='a14{defence_GB7_Index}'>{defence_GB7_value}</th>
	<th style="color:lime;" id='a14{defence_GB8_Index}'>{defence_GB8_value}</th>
	<th style="color:lime;" id='a14{defence_GB9_Index}'>{defence_GB9_value}</th>
</tr>
<!-- IF view_planet -->
<tr>
	<th><a>{ANTI_MISSILE}</a></th>
	<th style="color:lime;" id='a32{defence_MIC1_Index}'>{defence_MIC1_value}</th>
	<th style="color:lime;" id='a32{defence_MIC2_Index}'>{defence_MIC2_value}</th>
	<th style="color:lime;" id='a32{defence_MIC3_Index}'>{defence_MIC3_value}</th>
	<th style="color:lime;" id='a32{defence_MIC4_Index}'>{defence_MIC4_value}</th>
	<th style="color:lime;" id='a32{defence_MIC5_Index}'>{defence_MIC5_value}</th>
	<th style="color:lime;" id='a32{defence_MIC6_Index}'>{defence_MIC6_value}</th>
	<th style="color:lime;" id='a32{defence_MIC7_Index}'>{defence_MIC7_value}</th>
	<th style="color:lime;" id='a32{defence_MIC8_Index}'>{defence_MIC8_value}</th>
	<th style="color:lime;" id='a32{defence_MIC9_Index}'>{defence_MIC9_value}</th>
</tr>
<tr>
	<th><a>{INTERPLANET_MISSILE}</a></th>
	<th style="color:lime;" id='a31{defence_MIP1_Index}'>{defence_MIP1_value}</th>
	<th style="color:lime;" id='a31{defence_MIP2_Index}'>{defence_MIP2_value}</th>
	<th style="color:lime;" id='a31{defence_MIP3_Index}'>{defence_MIP3_value}</th>
	<th style="color:lime;" id='a31{defence_MIP4_Index}'>{defence_MIP4_value}</th>
	<th style="color:lime;" id='a31{defence_MIP5_Index}'>{defence_MIP5_value}</th>
	<th style="color:lime;" id='a31{defence_MIP6_Index}'>{defence_MIP6_value}</th>
	<th style="color:lime;" id='a31{defence_MIP7_Index}'>{defence_MIP7_value}</th>
	<th style="color:lime;" id='a31{defence_MIP8_Index}'>{defence_MIP8_value}</th>
	<th style="color:lime;" id='a31{defence_MIP9_Index}'>{defence_MIP9_value}</th>
</tr>
<!-- END IF view_planet -->
<tr>
	<td class="c" colspan="10">{FLEET}</td>
</tr>
<tr>
	<th><a>{SMALLCARGO}</a></th>
	<th style="color:lime;" id='a18{fleet_PT1_Index}'>{fleet_PT1_value}</th>
	<th style="color:lime;" id='a18{fleet_PT2_Index}'>{fleet_PT2_value}</th>
	<th style="color:lime;" id='a18{fleet_PT3_Index}'>{fleet_PT3_value}</th>
	<th style="color:lime;" id='a18{fleet_PT4_Index}'>{fleet_PT4_value}</th>
	<th style="color:lime;" id='a18{fleet_PT5_Index}'>{fleet_PT5_value}</th>
	<th style="color:lime;" id='a18{fleet_PT6_Index}'>{fleet_PT6_value}</th>
	<th style="color:lime;" id='a18{fleet_PT7_Index}'>{fleet_PT7_value}</th>
	<th style="color:lime;" id='a18{fleet_PT8_Index}'>{fleet_PT8_value}</th>
	<th style="color:lime;" id='a18{fleet_PT9_Index}'>{fleet_PT9_value}</th>
</tr>
<tr>
	<th><a>{LARGECARGO}</a></th>
	<th style="color:lime;" id='a19{fleet_GT1_Index}'>{fleet_GT1_value}</th>
	<th style="color:lime;" id='a19{fleet_GT2_Index}'>{fleet_GT2_value}</th>
	<th style="color:lime;" id='a19{fleet_GT3_Index}'>{fleet_GT3_value}</th>
	<th style="color:lime;" id='a19{fleet_GT4_Index}'>{fleet_GT4_value}</th>
	<th style="color:lime;" id='a19{fleet_GT5_Index}'>{fleet_GT5_value}</th>
	<th style="color:lime;" id='a19{fleet_GT6_Index}'>{fleet_GT6_value}</th>
	<th style="color:lime;" id='a19{fleet_GT7_Index}'>{fleet_GT7_value}</th>
	<th style="color:lime;" id='a19{fleet_GT8_Index}'>{fleet_GT8_value}</th>
	<th style="color:lime;" id='a19{fleet_GT9_Index}'>{fleet_GT9_value}</th>
</tr>
<tr>
	<th><a>{LIGHTFIGHTER}</a></th>
	<th style="color:lime;" id='a20{fleet_CLE1_Index}'>{fleet_CLE1_value}</th>
	<th style="color:lime;" id='a20{fleet_CLE2_Index}'>{fleet_CLE2_value}</th>
	<th style="color:lime;" id='a20{fleet_CLE3_Index}'>{fleet_CLE3_value}</th>
	<th style="color:lime;" id='a20{fleet_CLE4_Index}'>{fleet_CLE4_value}</th>
	<th style="color:lime;" id='a20{fleet_CLE5_Index}'>{fleet_CLE5_value}</th>
	<th style="color:lime;" id='a20{fleet_CLE6_Index}'>{fleet_CLE6_value}</th>
	<th style="color:lime;" id='a20{fleet_CLE7_Index}'>{fleet_CLE7_value}</th>
	<th style="color:lime;" id='a20{fleet_CLE8_Index}'>{fleet_CLE8_value}</th>
	<th style="color:lime;" id='a20{fleet_CLE9_Index}'>{fleet_CLE9_value}</th>
</tr>
<tr>
	<th><a>{HEAVYFIGHTER}</a></th>
	<th style="color:lime;" id='a21{fleet_CLO1_Index}'>{fleet_CLO1_value}</th>
	<th style="color:lime;" id='a21{fleet_CLO2_Index}'>{fleet_CLO2_value}</th>
	<th style="color:lime;" id='a21{fleet_CLO3_Index}'>{fleet_CLO3_value}</th>
	<th style="color:lime;" id='a21{fleet_CLO4_Index}'>{fleet_CLO4_value}</th>
	<th style="color:lime;" id='a21{fleet_CLO5_Index}'>{fleet_CLO5_value}</th>
	<th style="color:lime;" id='a21{fleet_CLO6_Index}'>{fleet_CLO6_value}</th>
	<th style="color:lime;" id='a21{fleet_CLO7_Index}'>{fleet_CLO7_value}</th>
	<th style="color:lime;" id='a21{fleet_CLO8_Index}'>{fleet_CLO8_value}</th>
	<th style="color:lime;" id='a21{fleet_CLO9_Index}'>{fleet_CLO9_value}</th>
</tr>
<tr>
	<th><a>{CRUISER}</a></th>
	<th style="color:lime;" id='a22{fleet_CR1_Index}'>{fleet_CR1_value}</th>
	<th style="color:lime;" id='a22{fleet_CR2_Index}'>{fleet_CR2_value}</th>
	<th style="color:lime;" id='a22{fleet_CR3_Index}'>{fleet_CR3_value}</th>
	<th style="color:lime;" id='a22{fleet_CR4_Index}'>{fleet_CR4_value}</th>
	<th style="color:lime;" id='a22{fleet_CR5_Index}'>{fleet_CR5_value}</th>
	<th style="color:lime;" id='a22{fleet_CR6_Index}'>{fleet_CR6_value}</th>
	<th style="color:lime;" id='a22{fleet_CR7_Index}'>{fleet_CR7_value}</th>
	<th style="color:lime;" id='a22{fleet_CR8_Index}'>{fleet_CR8_value}</th>
	<th style="color:lime;" id='a22{fleet_CR9_Index}'>{fleet_CR9_value}</th>
</tr>
<tr>
	<th><a>{BATTLESHIP}</a></th>
	<th style="color:lime;" id='a23{fleet_VB1_Index}'>{fleet_VB1_value}</th>
	<th style="color:lime;" id='a23{fleet_VB2_Index}'>{fleet_VB2_value}</th>
	<th style="color:lime;" id='a23{fleet_VB3_Index}'>{fleet_VB3_value}</th>
	<th style="color:lime;" id='a23{fleet_VB4_Index}'>{fleet_VB4_value}</th>
	<th style="color:lime;" id='a23{fleet_VB5_Index}'>{fleet_VB5_value}</th>
	<th style="color:lime;" id='a23{fleet_VB6_Index}'>{fleet_VB6_value}</th>
	<th style="color:lime;" id='a23{fleet_VB7_Index}'>{fleet_VB7_value}</th>
	<th style="color:lime;" id='a23{fleet_VB8_Index}'>{fleet_VB8_value}</th>
	<th style="color:lime;" id='a23{fleet_VB9_Index}'>{fleet_VB9_value}</th>
</tr>
<tr>
	<th><a>{COLONYSHIP}</a></th>
	<th style="color:lime;" id='a24{fleet_VC1_Index}'>{fleet_VC1_value}</th>
	<th style="color:lime;" id='a24{fleet_VC2_Index}'>{fleet_VC2_value}</th>
	<th style="color:lime;" id='a24{fleet_VC3_Index}'>{fleet_VC3_value}</th>
	<th style="color:lime;" id='a24{fleet_VC4_Index}'>{fleet_VC4_value}</th>
	<th style="color:lime;" id='a24{fleet_VC5_Index}'>{fleet_VC5_value}</th>
	<th style="color:lime;" id='a24{fleet_VC6_Index}'>{fleet_VC6_value}</th>
	<th style="color:lime;" id='a24{fleet_VC7_Index}'>{fleet_VC7_value}</th>
	<th style="color:lime;" id='a24{fleet_VC8_Index}'>{fleet_VC8_value}</th>
	<th style="color:lime;" id='a24{fleet_VC9_Index}'>{fleet_VC9_value}</th>
</tr>
<tr>
	<th><a>{RECYCLER}</a></th>
	<th style="color:lime;" id='a25{fleet_REC1_Index}'>{fleet_REC1_value}</th>
	<th style="color:lime;" id='a25{fleet_REC2_Index}'>{fleet_REC2_value}</th>
	<th style="color:lime;" id='a25{fleet_REC3_Index}'>{fleet_REC3_value}</th>
	<th style="color:lime;" id='a25{fleet_REC4_Index}'>{fleet_REC4_value}</th>
	<th style="color:lime;" id='a25{fleet_REC5_Index}'>{fleet_REC5_value}</th>
	<th style="color:lime;" id='a25{fleet_REC6_Index}'>{fleet_REC6_value}</th>
	<th style="color:lime;" id='a25{fleet_REC7_Index}'>{fleet_REC7_value}</th>
	<th style="color:lime;" id='a25{fleet_REC8_Index}'>{fleet_REC8_value}</th>
	<th style="color:lime;" id='a25{fleet_REC9_Index}'>{fleet_REC9_value}</th>
</tr>
<tr>
	<th><a>{ESPIONAGEPROBE}</a></th>
	<th style="color:lime;" id='a26{fleet_SE1_Index}'>{fleet_SE1_value}</th>
	<th style="color:lime;" id='a26{fleet_SE2_Index}'>{fleet_SE2_value}</th>
	<th style="color:lime;" id='a26{fleet_SE3_Index}'>{fleet_SE3_value}</th>
	<th style="color:lime;" id='a26{fleet_SE4_Index}'>{fleet_SE4_value}</th>
	<th style="color:lime;" id='a26{fleet_SE5_Index}'>{fleet_SE5_value}</th>
	<th style="color:lime;" id='a26{fleet_SE6_Index}'>{fleet_SE6_value}</th>
	<th style="color:lime;" id='a26{fleet_SE7_Index}'>{fleet_SE7_value}</th>
	<th style="color:lime;" id='a26{fleet_SE8_Index}'>{fleet_SE8_value}</th>
	<th style="color:lime;" id='a26{fleet_SE9_Index}'>{fleet_SE9_value}</th>
</tr>
<tr>
	<th><a>{BOMBER}</a></th>
	<th style="color:lime;" id='a27{fleet_BMD1_Index}'>{fleet_BMD1_value}</th>
	<th style="color:lime;" id='a27{fleet_BMD2_Index}'>{fleet_BMD2_value}</th>
	<th style="color:lime;" id='a27{fleet_BMD3_Index}'>{fleet_BMD3_value}</th>
	<th style="color:lime;" id='a27{fleet_BMD4_Index}'>{fleet_BMD4_value}</th>
	<th style="color:lime;" id='a27{fleet_BMD5_Index}'>{fleet_BMD5_value}</th>
	<th style="color:lime;" id='a27{fleet_BMD6_Index}'>{fleet_BMD6_value}</th>
	<th style="color:lime;" id='a27{fleet_BMD7_Index}'>{fleet_BMD7_value}</th>
	<th style="color:lime;" id='a27{fleet_BMD8_Index}'>{fleet_BMD8_value}</th>
	<th style="color:lime;" id='a27{fleet_BMD9_Index}'>{fleet_BMD9_value}</th>
</tr>
<tr>
	<th><a>{SOLARSATELLITE}</a></th>
	<th style="color:lime;" id='a6{fleet_SAT1_Index}'>{fleet_SAT1_value}</th>
	<th style="color:lime;" id='a6{fleet_SAT2_Index}'>{fleet_SAT2_value}</th>
	<th style="color:lime;" id='a6{fleet_SAT3_Index}'>{fleet_SAT3_value}</th>
	<th style="color:lime;" id='a6{fleet_SAT4_Index}'>{fleet_SAT4_value}</th>
	<th style="color:lime;" id='a6{fleet_SAT5_Index}'>{fleet_SAT5_value}</th>
	<th style="color:lime;" id='a6{fleet_SAT6_Index}'>{fleet_SAT6_value}</th>
	<th style="color:lime;" id='a6{fleet_SAT7_Index}'>{fleet_SAT7_value}</th>
	<th style="color:lime;" id='a6{fleet_SAT8_Index}'>{fleet_SAT8_value}</th>
	<th style="color:lime;" id='a6{fleet_SAT9_Index}'>{fleet_SAT9_value}</th>
</tr>
<tr>
	<th><a>{DESTROYER}</a></th>
	<th style="color:lime;" id='a28{fleet_DST1_Index}'>{fleet_DST1_value}</th>
	<th style="color:lime;" id='a28{fleet_DST2_Index}'>{fleet_DST2_value}</th>
	<th style="color:lime;" id='a28{fleet_DST3_Index}'>{fleet_DST3_value}</th>
	<th style="color:lime;" id='a28{fleet_DST4_Index}'>{fleet_DST4_value}</th>
	<th style="color:lime;" id='a28{fleet_DST5_Index}'>{fleet_DST5_value}</th>
	<th style="color:lime;" id='a28{fleet_DST6_Index}'>{fleet_DST6_value}</th>
	<th style="color:lime;" id='a28{fleet_DST7_Index}'>{fleet_DST7_value}</th>
	<th style="color:lime;" id='a28{fleet_DST8_Index}'>{fleet_DST8_value}</th>
	<th style="color:lime;" id='a28{fleet_DST9_Index}'>{fleet_DST9_value}</th>
</tr>
<tr>
	<th><a>{DEATHSTAR}</a></th>
	<th style="color:lime;" id='a29{fleet_EDLM1_Index}'>{fleet_EDLM1_value}</th>
	<th style="color:lime;" id='a29{fleet_EDLM2_Index}'>{fleet_EDLM2_value}</th>
	<th style="color:lime;" id='a29{fleet_EDLM3_Index}'>{fleet_EDLM3_value}</th>
	<th style="color:lime;" id='a29{fleet_EDLM4_Index}'>{fleet_EDLM4_value}</th>
	<th style="color:lime;" id='a29{fleet_EDLM5_Index}'>{fleet_EDLM5_value}</th>
	<th style="color:lime;" id='a29{fleet_EDLM6_Index}'>{fleet_EDLM6_value}</th>
	<th style="color:lime;" id='a29{fleet_EDLM7_Index}'>{fleet_EDLM7_value}</th>
	<th style="color:lime;" id='a29{fleet_EDLM8_Index}'>{fleet_EDLM8_value}</th>
	<th style="color:lime;" id='a29{fleet_EDLM9_Index}'>{fleet_EDLM9_value}</th>
</tr>
<tr>
	<th><a>{BATTLECRUISER}</a></th>
	<th style="color:lime;" id='a30{fleet_TRA1_Index}'>{fleet_TRA1_value}</th>
	<th style="color:lime;" id='a30{fleet_TRA2_Index}'>{fleet_TRA2_value}</th>
	<th style="color:lime;" id='a30{fleet_TRA3_Index}'>{fleet_TRA3_value}</th>
	<th style="color:lime;" id='a30{fleet_TRA4_Index}'>{fleet_TRA4_value}</th>
	<th style="color:lime;" id='a30{fleet_TRA5_Index}'>{fleet_TRA5_value}</th>
	<th style="color:lime;" id='a30{fleet_TRA6_Index}'>{fleet_TRA6_value}</th>
	<th style="color:lime;" id='a30{fleet_TRA7_Index}'>{fleet_TRA7_value}</th>
	<th style="color:lime;" id='a30{fleet_TRA8_Index}'>{fleet_TRA8_value}</th>
	<th style="color:lime;" id='a30{fleet_TRA9_Index}'>{fleet_TRA9_value}</th>
</tr>
</table>
<!--- DEBUT DU SCRIPT -->
<script type="text/javascript">
<!-- Begin
//message("{HOME_WARNING}");

var name = new Array({PLANETS_NAMES});
var coordinates = new Array({PLANETS_COORDS});
var fields = new Array({PLANETS_FIELDS});
var temperature = new Array({PLANETS_TEMPS});
var satellite = new Array({PLANETS_SATS});
var select_planet = false;

function autofill(planet_id, planet_selected) {
<!-- IF view_planet -->
	var start = 0;
<!-- ELSE IF view_planet -->
	var start = 1;
<!-- END IF view_planet -->
	for(i=start;i<10;i++){
		document.getElementById('input_zone'+i).style.display='block';
		document.getElementById('input_zone'+i).disabled=false;
	}

	//	if (name[(planet_id-1)] == "" && coordinates[(planet_id-1)] == "" && fields[(planet_id-1)] == "" && temperature[(planet_id-1)] == "" && satellite[(planet_id-1)] == "") {
	//		return;
	//	}

	document.getElementById('input_zone2').value = name[(planet_id-1)];
	if(planet_id>9)
		document.getElementById('input_zone4').value = coordinates[(planet_id-10)];
	else
		document.getElementById('input_zone4').value = coordinates[(planet_id-1)];
	document.getElementById('input_zone6').value = fields[(planet_id-1)];
	document.getElementById('input_zone8').value = temperature[(planet_id-1)];
	document.getElementById('input_zone0').value = satellite[(planet_id-1)];

	var i = 1;
	var lign = 0;
	var id = 0;
<!-- IF is_ddr -->
	var lim = 55;
<!-- ELSE IF is_ddr -->
	var lim = 54;
<!-- END IF is_ddr -->
	if(planet_id > 9) {
		lim = 30;
		planet_id -= 9;
	}
	for(i = 1; i <= 9; i++) {
		for(lign = 1; lign <= lim; lign++) {
			id = 'a'+(lign*10+i);
			document.getElementById(id).style.color = 'lime';
		}
	}

	for(i = 1; i <= lim; i++) {
		id = 'a'+(i*10+planet_id);
		document.getElementById(id).style.color = 'yellow';
	}

	return(true);
}

function clear_text2() {
	if (document.getElementById('data').value == data_default) {
		document.getElementById('data').value = "";
	}
}

function message(msg) {
	alert("\n"+msg);
}
var data_default = document.getElementById('data').value;
// End -->
</script>
<!--- FIN DU SCRIPT -->
