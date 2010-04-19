<script type="text/javascript" src="js/ogame_formula.js"></script>
<table style="text-align:center;margin-left:auto;margin-right:auto;">
	<tr>
		<td class="c" colspan="8">{homesimulation_Param}&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<th>{homesimulation_EnergyTechnology}</th>
		<th><input type="text" id="techno_NRJ" size="2" value="{user_technology_NRJ} " onchange="update_page();" /></th>
		<th>{homesimulation_inge}</th>
		<th><input type="text" id="off_ingenieur" size="2" value="{user_data_off_ingenieur}" onchange="update_page();" /></th>
		<th>{homesimulation_geo}</th>
		<th><input type="text" id="off_geologue" size="2" value="{user_data_off_geologue}" onchange="update_page();" /></th>
		<th>{homesimulation_speeduni}</th>
		<th><input type="text" id="speed_uni" size="2" value="{server_config_speed_uni}" onchange="update_page();" /></th>
	</tr>
</table>
<br />
<table style="text-align:center;margin-left:auto;margin-right:auto;"> <!--width="1200" --> 
<tr>
	<td class="c">&nbsp;</td>
	<td class="c" style="text-align:center;"><a>{name1}</a></td>
	<td class="c" style="text-align:center;"><a>{name2}</a></td>
	<td class="c" style="text-align:center;"><a>{name3}</a></td>
	<td class="c" style="text-align:center;"><a>{name4}</a></td>
	<td class="c" style="text-align:center;"><a>{name5}</a></td>
	<td class="c" style="text-align:center;"><a>{name6}</a></td>
	<td class="c" style="text-align:center;"><a>{name7}</a></td>
	<td class="c" style="text-align:center;"><a>{name8}</a></td>
	<td class="c" style="text-align:center;"><a>{name9}</a></td>
	<td class="c" style="text-align:center;">{homesimulation_Totals}</td>
</tr>
<tr>
	<th><a>{homesimulation_Coordinates}</a></th>
	<th>{coordinates1}</th>
	<th>{coordinates2}</th>
	<th>{coordinates3}</th>
	<th>{coordinates4}</th>
	<th>{coordinates5}</th>
	<th>{coordinates6}</th>
	<th>{coordinates7}</th>
	<th>{coordinates8}</th>
	<th>{coordinates9}</th>
	<th rowspan="3">&nbsp;</th>
</tr>
<tr>
	<th><a>{homesimulation_Field}</a></th>
	<th>{fields1}</th>
	<th>{fields2}</th>
	<th>{fields3}</th>
	<th>{fields4}</th>
	<th>{fields5}</th>
	<th>{fields6}</th>
	<th>{fields7}</th>
	<th>{fields8}</th>
	<th>{fields9}</th>
</tr>
<tr>
	<th><a>{homesimulation_Temperature}</a></th>
	<th>{temperature1}<input id="Temp_1" type='hidden' value="{temperature1}"/></th>
	<th>{temperature2}<input id="Temp_2" type='hidden' value="{temperature2}"/></th>
	<th>{temperature3}<input id="Temp_3" type='hidden' value="{temperature3}"/></th>
	<th>{temperature4}<input id="Temp_4" type='hidden' value="{temperature4}"/></th>
	<th>{temperature5}<input id="Temp_5" type='hidden' value="{temperature5}"/></th>
	<th>{temperature6}<input id="Temp_6" type='hidden' value="{temperature6}"/></th>
	<th>{temperature7}<input id="Temp_7" type='hidden' value="{temperature7}"/></th>
	<th>{temperature8}<input id="Temp_8" type='hidden' value="{temperature8}"/></th>
	<th>{temperature9}<input id="Temp_9" type='hidden' value="{temperature9}"/></th>
</tr>
<tr>
	<td class="c" colspan="20">{homesimulation_Energies}</td>
</tr>
<tr>
	<th><a>{homesimulation_Ces}</a></th>
	<th style="white-space: nowrap;">
		<input type="text" id="CES_1" size="2" maxlength="3" value="{CES1}" onchange="update_page();" style="text-align:center;"/>
		<select id="CES_1_percentage" onchange="update_page();" onkeyup="update_page();">{CES_1_percentage_options}</select>
	</th>
	<th style="white-space: nowrap;">
		<input type="text" id="CES_2" size="2" maxlength="2" value="{CES2}" onchange="update_page();" style="text-align:center;"/>
		<select id="CES_2_percentage" onchange="update_page();" onkeyup="update_page();">{CES_2_percentage_options}</select>
	</th>
	<th style="white-space: nowrap;">
		<input type="text" id="CES_3" size="2" maxlength="2" value="{CES3}" onchange="update_page();" style="text-align:center;"/>
		<select id="CES_3_percentage" onchange="update_page();" onkeyup="update_page();">{CES_3_percentage_options}</select>
	</th>
	<th style="white-space: nowrap;">
		<input type="text" id="CES_4" size="2" maxlength="2" value="{CES4}" onchange="update_page();" style="text-align:center;"/>
		<select id="CES_4_percentage" onchange="update_page();" onkeyup="update_page();">{CES_4_percentage_options}</select>
	</th>
	<th style="white-space: nowrap;">
		<input type="text" id="CES_5" size="2" maxlength="2" value="{CES5}" onchange="update_page();" style="text-align:center;"/>
		<select id="CES_5_percentage" onchange="update_page();" onkeyup="update_page();">{CES_5_percentage_options}</select>
	</th>
	<th style="white-space: nowrap;">
		<input type="text" id="CES_6" size="2" maxlength="2" value="{CES6}" onchange="update_page();" style="text-align:center;"/>
		<select id="CES_6_percentage" onchange="update_page();" onkeyup="update_page();">{CES_6_percentage_options}</select>
	</th>
	<th style="white-space: nowrap;">
		<input type="text" id="CES_7" size="2" maxlength="2" value="{CES7}" onchange="update_page();" style="text-align:center;"/>
		<select id="CES_7_percentage" onchange="update_page();" onkeyup="update_page();">{CES_7_percentage_options}</select>
	</th>
	<th style="white-space: nowrap;">
		<input type="text" id="CES_8" size="2" maxlength="2" value="{CES8}" onchange="update_page();" style="text-align:center;"/>
		<select id="CES_8_percentage" onchange="update_page();" onkeyup="update_page();">{CES_8_percentage_options}</select>
	</th>
	<th style="white-space: nowrap;">
		<input type="text" id="CES_9" size="2" maxlength="2" value="{CES9}" onchange="update_page();" style="text-align:center;"/>
		<select id="CES_9_percentage" onchange="update_page();" onkeyup="update_page();">{CES_9_percentage_options}</select>
	</th>
	<th rowspan="3">&nbsp;</th>
</tr>
<tr>
	<th><a>{homesimulation_Cef}</a></th>
	<th>
		<input type="text" id="CEF_1" size="2" maxlength="2" value="{CEF1}" onchange="update_page();" style="text-align:center;"/>
		<select id="CEF_1_percentage" onchange="update_page();" onkeyup="update_page();">{CEF_1_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="CEF_2" size="2" maxlength="2" value="{CEF2}" onchange="update_page();" style="text-align:center;"/>
		<select id="CEF_2_percentage" onchange="update_page();" onkeyup="update_page();">{CEF_2_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="CEF_3" size="2" maxlength="2" value="{CEF3}" onchange="update_page();" style="text-align:center;"/>
		<select id="CEF_3_percentage" onchange="update_page();" onkeyup="update_page();">{CEF_3_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="CEF_4" size="2" maxlength="2" value="{CEF4}" onchange="update_page();" style="text-align:center;"/>
		<select id="CEF_4_percentage" onchange="update_page();" onkeyup="update_page();">{CEF_4_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="CEF_5" size="2" maxlength="2" value="{CEF5}" onchange="update_page();" style="text-align:center;"/>
		<select id="CEF_5_percentage" onchange="update_page();" onkeyup="update_page();">{CEF_5_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="CEF_6" size="2" maxlength="2" value="{CEF6}" onchange="update_page();" style="text-align:center;"/>
		<select id="CEF_6_percentage" onchange="update_page();" onkeyup="update_page();">{CEF_6_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="CEF_7" size="2" maxlength="2" value="{CEF7}" onchange="update_page();" style="text-align:center;"/>
		<select id="CEF_7_percentage" onchange="update_page();" onkeyup="update_page();">{CEF_7_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="CEF_8" size="2" maxlength="2" value="{CEF8}" onchange="update_page();" style="text-align:center;"/>
		<select id="CEF_8_percentage" onchange="update_page();" onkeyup="update_page();">{CEF_8_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="CEF_9" size="2" maxlength="2" value="{CEF9}" onchange="update_page();" style="text-align:center;"/>
		<select id="CEF_9_percentage" onchange="update_page();" onkeyup="update_page();">{CEF_9_percentage_options}</select>
	</th>
</tr>
<tr>
	<th><a>{homesimulation_Sats}</a></th>
	<th>
		<input type="text" id="Sat_1" size="2" maxlength="5" value="{Sat1}" onchange="update_page();" style="text-align:center;"/>
		<select id="Sat_1_percentage" onchange="update_page();" onkeyup="update_page();">{Sat_1_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="Sat_2" size="2" maxlength="5" value="{Sat2}" onchange="update_page();" style="text-align:center;"/>
		<select id="Sat_2_percentage" onchange="update_page();" onkeyup="update_page();">{Sat_2_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="Sat_3" size="2" maxlength="5" value="{Sat3}" onchange="update_page();" style="text-align:center;"/>
		<select id="Sat_3_percentage" onchange="update_page();" onkeyup="update_page();">{Sat_3_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="Sat_4" size="2" maxlength="5" value="{Sat4}" onchange="update_page();" style="text-align:center;"/>
		<select id="Sat_4_percentage" onchange="update_page();" onkeyup="update_page();">{Sat_4_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="Sat_5" size="2" maxlength="5" value="{Sat5}" onchange="update_page();" style="text-align:center;"/>
		<select id="Sat_5_percentage" onchange="update_page();" onkeyup="update_page();">{Sat_5_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="Sat_6" size="2" maxlength="5" value="{Sat6}" onchange="update_page();" style="text-align:center;"/>
		<select id="Sat_6_percentage" onchange="update_page();" onkeyup="update_page();">{Sat_6_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="Sat_7" size="2" maxlength="5" value="{Sat7}" onchange="update_page();" style="text-align:center;"/>
		<select id="Sat_7_percentage" onchange="update_page();" onkeyup="update_page();">{Sat_7_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="Sat_8" size="2" maxlength="5" value="{Sat8}" onchange="update_page();" style="text-align:center;"/>
		<select id="Sat_8_percentage" onchange="update_page();" onkeyup="update_page();">{Sat_8_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="Sat_9" size="2" maxlength="5" value="{Sat9}" onchange="update_page();" style="text-align:center;"/>
		<select id="Sat_9_percentage" onchange="update_page();" onkeyup="update_page();">{Sat_9_percentage_options}</select>
	</th>
</tr>
<tr>
	<th><a>{homesimulation_Energies}</a></th>
	<th style="color:lime;white-space: nowrap;"><div id="NRJ_1">-</div></th>
	<th style="color:lime;white-space: nowrap;"><div id="NRJ_2">-</div></th>
	<th style="color:lime;white-space: nowrap;"><div id="NRJ_3">-</div></th>
	<th style="color:lime;white-space: nowrap;"><div id="NRJ_4">-</div></th>
	<th style="color:lime;white-space: nowrap;"><div id="NRJ_5">-</div></th>
	<th style="color:lime;white-space: nowrap;"><div id="NRJ_6">-</div></th>
	<th style="color:lime;white-space: nowrap;"><div id="NRJ_7">-</div></th>
	<th style="color:lime;white-space: nowrap;"><div id="NRJ_8">-</div></th>
	<th style="color:lime;white-space: nowrap;"><div id="NRJ_9">-</div></th>
	<th style="white-space: nowrap;"><div id="NRJ">&nbsp;</div></th>
</tr>
<tr>
	<th><a>{homesimulation_ProductionRatio}</a></th>
	<th style="color:lime;"><div id="ratio_1">-</div></th>
	<th style="color:lime;"><div id="ratio_2">-</div></th>
	<th style="color:lime;"><div id="ratio_3">-</div></th>
	<th style="color:lime;"><div id="ratio_4">-</div></th>
	<th style="color:lime;"><div id="ratio_5">-</div></th>
	<th style="color:lime;"><div id="ratio_6">-</div></th>
	<th style="color:lime;"><div id="ratio_7">-</div></th>
	<th style="color:lime;"><div id="ratio_8">-</div></th>
	<th style="color:lime;"><div id="ratio_9">-</div></th>
	<th><div id="ratio">&nbsp;</div></th>
</tr>
<tr>
	<td class="c" colspan="20">{homesimulation_Metal}</td>
</tr>
<tr>
	<th><a>{homesimulation_Level}</a></th>
	<th>
		<input type="text" id="M_1" size="2" maxlength="2" value="{M1}" onchange="update_page();" style="text-align:center;"/>
		<select id="M_1_percentage" onchange="update_page();" onkeyup="update_page();">{M_1_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="M_2" size="2" maxlength="2" value="{M2}" onchange="update_page();" style="text-align:center;"/>
		<select id="M_2_percentage" onchange="update_page();" onkeyup="update_page();">{M_2_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="M_3" size="2" maxlength="2" value="{M3}" onchange="update_page();" style="text-align:center;"/>
		<select id="M_3_percentage" onchange="update_page();" onkeyup="update_page();">{M_3_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="M_4" size="2" maxlength="2" value="{M4}" onchange="update_page();" style="text-align:center;"/>
		<select id="M_4_percentage" onchange="update_page();" onkeyup="update_page();">{M_4_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="M_5" size="2" maxlength="2" value="{M5}" onchange="update_page();" style="text-align:center;"/>
		<select id="M_5_percentage" onchange="update_page();" onkeyup="update_page();">{M_5_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="M_6" size="2" maxlength="2" value="{M6}" onchange="update_page();" style="text-align:center;"/>
		<select id="M_6_percentage" onchange="update_page();" onkeyup="update_page();">{M_6_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="M_7" size="2" maxlength="2" value="{M7}" onchange="update_page();" style="text-align:center;"/>
		<select id="M_7_percentage" onchange="update_page();" onkeyup="update_page();">{M_7_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="M_8" size="2" maxlength="2" value="{M8}" onchange="update_page();" style="text-align:center;"/>
		<select id="M_8_percentage" onchange="update_page();" onkeyup="update_page();">{M_8_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="M_9" size="2" maxlength="2" value="{M9}" onchange="update_page();" style="text-align:center;"/>
		<select id="M_9_percentage" onchange="update_page();" onkeyup="update_page();">{M_9_percentage_options}</select>
	</th>
	<th>&nbsp;</th>
</tr>
<tr>
	<th><a>{homesimulation_ConsumptionEnergy}</a></th>
	<th style="color:lime;"><div id="M_1_conso">-</div></th>
	<th style="color:lime;"><div id="M_2_conso">-</div></th>
	<th style="color:lime;"><div id="M_3_conso">-</div></th>
	<th style="color:lime;"><div id="M_4_conso">-</div></th>
	<th style="color:lime;"><div id="M_5_conso">-</div></th>
	<th style="color:lime;"><div id="M_6_conso">-</div></th>
	<th style="color:lime;"><div id="M_7_conso">-</div></th>
	<th style="color:lime;"><div id="M_8_conso">-</div></th>
	<th style="color:lime;"><div id="M_9_conso">-</div></th>
	<th><div id="M_conso">-</div></th>
</tr>
<tr>
	<th><a>{homesimulation_Production}</a></th>
	<th style="color:lime;"><div id="M_1_prod">-</div></th>
	<th style="color:lime;"><div id="M_2_prod">-</div></th>
	<th style="color:lime;"><div id="M_3_prod">-</div></th>
	<th style="color:lime;"><div id="M_4_prod">-</div></th>
	<th style="color:lime;"><div id="M_5_prod">-</div></th>
	<th style="color:lime;"><div id="M_6_prod">-</div></th>
	<th style="color:lime;"><div id="M_7_prod">-</div></th>
	<th style="color:lime;"><div id="M_8_prod">-</div></th>
	<th style="color:lime;"><div id="M_9_prod">-</div></th>
	<th><div id="M_prod">-</div></th>
</tr>
<tr>
	<td class="c" colspan="20">{homesimulation_Crystal}</td>
</tr>
<tr>
	<th><a>{homesimulation_Level}</a></th>
	<th>
		<input type="text" id="C_1" size="2" maxlength="2" value="{C1}" onchange="update_page();" style="text-align:center;"/>
		<select id="C_1_percentage" onchange="update_page();" onkeyup="update_page();">{C_1_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="C_2" size="2" maxlength="2" value="{C2}" onchange="update_page();" style="text-align:center;"/>
		<select id="C_2_percentage" onchange="update_page();" onkeyup="update_page();">{C_2_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="C_3" size="2" maxlength="2" value="{C3}" onchange="update_page();" style="text-align:center;"/>
		<select id="C_3_percentage" onchange="update_page();" onkeyup="update_page();">{C_3_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="C_4" size="2" maxlength="2" value="{C4}" onchange="update_page();" style="text-align:center;"/>
		<select id="C_4_percentage" onchange="update_page();" onkeyup="update_page();">{C_4_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="C_5" size="2" maxlength="2" value="{C5}" onchange="update_page();" style="text-align:center;"/>
		<select id="C_5_percentage" onchange="update_page();" onkeyup="update_page();">{C_5_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="C_6" size="2" maxlength="2" value="{C6}" onchange="update_page();" style="text-align:center;"/>
		<select id="C_6_percentage" onchange="update_page();" onkeyup="update_page();">{C_6_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="C_7" size="2" maxlength="2" value="{C7}" onchange="update_page();" style="text-align:center;"/>
		<select id="C_7_percentage" onchange="update_page();" onkeyup="update_page();">{C_7_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="C_8" size="2" maxlength="2" value="{C8}" onchange="update_page();" style="text-align:center;"/>
		<select id="C_8_percentage" onchange="update_page();" onkeyup="update_page();">{C_8_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="C_9" size="2" maxlength="2" value="{C9}" onchange="update_page();" style="text-align:center;"/>
		<select id="C_9_percentage" onchange="update_page();" onkeyup="update_page();">{C_9_percentage_options}</select>
	</th>
	<th>&nbsp;</th>
</tr>
<tr>
	<th><a>{homesimulation_ConsumptionEnergy}</a></th>
	<th style="color:lime;"><div id="C_1_conso">-</div></th>
	<th style="color:lime;"><div id="C_2_conso">-</div></th>
	<th style="color:lime;"><div id="C_3_conso">-</div></th>
	<th style="color:lime;"><div id="C_4_conso">-</div></th>
	<th style="color:lime;"><div id="C_5_conso">-</div></th>
	<th style="color:lime;"><div id="C_6_conso">-</div></th>
	<th style="color:lime;"><div id="C_7_conso">-</div></th>
	<th style="color:lime;"><div id="C_8_conso">-</div></th>
	<th style="color:lime;"><div id="C_9_conso">-</div></th>
	<th><div id="C_conso">-</div></th>
</tr>
<tr>
	<th><a>{homesimulation_Production}</a></th>
	<th style="color:lime;"><div id="C_1_prod">-</div></th>
	<th style="color:lime;"><div id="C_2_prod">-</div></th>
	<th style="color:lime;"><div id="C_3_prod">-</div></th>
	<th style="color:lime;"><div id="C_4_prod">-</div></th>
	<th style="color:lime;"><div id="C_5_prod">-</div></th>
	<th style="color:lime;"><div id="C_6_prod">-</div></th>
	<th style="color:lime;"><div id="C_7_prod">-</div></th>
	<th style="color:lime;"><div id="C_8_prod">-</div></th>
	<th style="color:lime;"><div id="C_9_prod">-</div></th>
	<th><div id="C_prod">-</div></th>
</tr>
<tr>
	<td class="c" colspan="20">{homesimulation_Deuterium}</td>
</tr>
<tr>
	<th><a>{homesimulation_Level}</a></th>
	<th>
		<input type="text" id="D_1" size="2" maxlength="2" value="{D1}" onchange="update_page();" style="text-align:center;"/>
		<select id="D_1_percentage" onchange="update_page();" onkeyup="update_page();">{D_1_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="D_2" size="2" maxlength="2" value="{D2}" onchange="update_page();" style="text-align:center;"/>
		<select id="D_2_percentage" onchange="update_page();" onkeyup="update_page();">{D_2_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="D_3" size="2" maxlength="2" value="{D3}" onchange="update_page();" style="text-align:center;"/>
		<select id="D_3_percentage" onchange="update_page();" onkeyup="update_page();">{D_3_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="D_4" size="2" maxlength="2" value="{D4}" onchange="update_page();" style="text-align:center;"/>
		<select id="D_4_percentage" onchange="update_page();" onkeyup="update_page();">{D_4_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="D_5" size="2" maxlength="2" value="{D5}" onchange="update_page();" style="text-align:center;"/>
		<select id="D_5_percentage" onchange="update_page();" onkeyup="update_page();">{D_5_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="D_6" size="2" maxlength="2" value="{D6}" onchange="update_page();" style="text-align:center;"/>
		<select id="D_6_percentage" onchange="update_page();" onkeyup="update_page();">{D_6_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="D_7" size="2" maxlength="2" value="{D7}" onchange="update_page();" style="text-align:center;"/>
		<select id="D_7_percentage" onchange="update_page();" onkeyup="update_page();">{D_7_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="D_8" size="2" maxlength="2" value="{D8}" onchange="update_page();" style="text-align:center;"/>
		<select id="D_8_percentage" onchange="update_page();" onkeyup="update_page();">{D_8_percentage_options}</select>
	</th>
	<th>
		<input type="text" id="D_9" size="2" maxlength="2" value="{D9}" onchange="update_page();" style="text-align:center;"/>
		<select id="D_9_percentage" onchange="update_page();" onkeyup="update_page();">{D_9_percentage_options}</select>
	</th>
	<th>&nbsp;</th>
</tr>
<tr>
	<th><a>{homesimulation_ConsumptionEnergy}</a></th>
	<th style="color:lime;"><div id="D_1_conso">-</div></th>
	<th style="color:lime;"><div id="D_2_conso">-</div></th>
	<th style="color:lime;"><div id="D_3_conso">-</div></th>
	<th style="color:lime;"><div id="D_4_conso">-</div></th>
	<th style="color:lime;"><div id="D_5_conso">-</div></th>
	<th style="color:lime;"><div id="D_6_conso">-</div></th>
	<th style="color:lime;"><div id="D_7_conso">-</div></th>
	<th style="color:lime;"><div id="D_8_conso">-</div></th>
	<th style="color:lime;"><div id="D_9_conso">-</div></th>
	<th><div id="D_conso">-</div></th>
</tr>
<tr>
	<th><a>{homesimulation_Production}</a></th>
	<th style="color:lime;"><div id="D_1_prod">-</div></th>
	<th style="color:lime;"><div id="D_2_prod">-</div></th>
	<th style="color:lime;"><div id="D_3_prod">-</div></th>
	<th style="color:lime;"><div id="D_4_prod">-</div></th>
	<th style="color:lime;"><div id="D_5_prod">-</div></th>
	<th style="color:lime;"><div id="D_6_prod">-</div></th>
	<th style="color:lime;"><div id="D_7_prod">-</div></th>
	<th style="color:lime;"><div id="D_8_prod">-</div></th>
	<th style="color:lime;"><div id="D_9_prod">-</div></th>
	<th><div id="D_prod">-</div></th>
</tr>
<tr>
	<td class="c" colspan="20">{homesimulation_PointsPerPlanet}</td>
</tr>
<tr>
	<th>
		<a>{homesimulation_Building}</a>
	</th>
	<th style="color:lime;">
		<div id="building_pts_1">-</div>
		<input type="hidden" id="building_1" value="{building_1_value}" />
	</th>
	<th style="color:lime;">
		<div id="building_pts_2">-</div>
		<input type="hidden" id="building_2" value="{building_2_value}" />
	</th>
	<th style="color:lime;">
		<div id="building_pts_3">-</div>
		<input type="hidden" id="building_3" value="{building_3_value}" />
	</th>
	<th style="color:lime;">
		<div id="building_pts_4">-</div>
		<input type="hidden" id="building_4" value="{building_4_value}" />
	</th>
	<th style="color:lime;">
		<div id="building_pts_5">-</div>
		<input type="hidden" id="building_5" value="{building_5_value}" />
	</th>
	<th style="color:lime;">
		<div id="building_pts_6">-</div>
		<input type="hidden" id="building_6" value="{building_6_value}" />
	</th>
	<th style="color:lime;">
		<div id="building_pts_7">-</div>
		<input type="hidden" id="building_7" value="{building_7_value}" />
	</th>
	<th style="color:lime;">
		<div id="building_pts_8">-</div>
		<input type="hidden" id="building_8" value="{building_8_value}" />
	</th>
	<th style="color:lime;">
		<div id="building_pts_9">-</div>
		<input type="hidden" id="building_9" value="{building_9_value}" />
	</th>
	<th style="color:white;"><div id='total_b_pts'>-</div></th>
</tr>
<tr>
	<th>
		<a>{homesimulation_Defence}</a>
	</th>
	<th style="color:lime;">
		<div id="defence_pts_1">-</div>
		<input type="hidden" id="defence_1" value="{defence_1_value}" />
	</th>
	<th style="color:lime;">
		<div id="defence_pts_2">-</div>
		<input type="hidden" id="defence_2" value="{defence_2_value}" />
	</th>
	<th style="color:lime;">
		<div id="defence_pts_3">-</div>
		<input type="hidden" id="defence_3" value="{defence_3_value}" />
	</th>
	<th style="color:lime;">
		<div id="defence_pts_4">-</div>
		<input type="hidden" id="defence_4" value="{defence_4_value}" />
	</th>
	<th style="color:lime;">
		<div id="defence_pts_5">-</div>
	<input type="hidden" id="defence_5" value="{defence_5_value}" />
	</th>
	<th style="color:lime;">
		<div id="defence_pts_6">-</div>
		<input type="hidden" id="defence_6" value="{defence_6_value}" />
	</th>
	<th style="color:lime;">
		<div id="defence_pts_7">-</div>
		<input type="hidden" id="defence_7" value="{defence_7_value}" />
	</th>
	<th style="color:lime;">
		<div id="defence_pts_8">-</div>
		<input type="hidden" id="defence_8" value="{defence_8_value}" />
	</th>
	<th style="color:lime;">
		<div id="defence_pts_9">-</div>
		<input type="hidden" id="defence_9" value="{defence_9_value}" />
	</th>
	<th style="color:white;">
		<div id='total_d_pts'>-</div>
	</th>
</tr>
<tr>
	<th>
		<a>{homesimulation_Fleet}</a>
	</th>
	<th style="color:lime;">
		<div id="fleet_pts_1">-</div>
		<input type="hidden" id="fleet_1" value="{fleet_1_value}" />
	</th>
	<th style="color:lime;">
		<div id="fleet_pts_2">-</div>
		<input type="hidden" id="fleet_2" value="{fleet_2_value}" />
	</th>
	<th style="color:lime;">
		<div id="fleet_pts_3">-</div>
		<input type="hidden" id="fleet_3" value="{fleet_3_value}" />
	</th>
	<th style="color:lime;">
		<div id="fleet_pts_4">-</div>
		<input type="hidden" id="fleet_4" value="{fleet_4_value}" />
	</th>
	<th style="color:lime;">
		<div id="fleet_pts_5">-</div>
		<input type="hidden" id="fleet_5" value="{fleet_5_value}" />
	</th>
	<th style="color:lime;">
		<div id="fleet_pts_6">-</div>
		<input type="hidden" id="fleet_6" value="{fleet_6_value}" />
	</th>
	<th style="color:lime;">
		<div id="fleet_pts_7">-</div>
		<input type="hidden" id="fleet_7" value="{fleet_7_value}" />
	</th>
	<th style="color:lime;">
		<div id="fleet_pts_8">-</div>
		<input type="hidden" id="fleet_8" value="{fleet_8_value}" />
	</th>
	<th style="color:lime;">
		<div id="fleet_pts_9">-</div>
		<input type="hidden" id="fleet_9" value="{fleet_9_value}" />
	</th>
	<th style="color:white;">
		<div id='total_f_pts'>-</div>
	</th>
</tr>
<tr>
	<th>
		<a>{homesimulation_Moons}</a>
	</th>
	<th style="color:lime;">
		<div id="lune_pts_1">-</div>
		<input type="hidden" id="lune_b_1" value="{lune_b_1_value}" />
		<input type="hidden" id="lune_d_1" value="{lune_d_1_value}" />
		<input type="hidden" id="lune_f_1" value="{lune_f_1_value}" />
	</th>
	<th style="color:lime;">
		<div id="lune_pts_2">-</div>
		<input type="hidden" id="lune_b_2" value="{lune_b_2_value}" />
		<input type="hidden" id="lune_d_2" value="{lune_d_2_value}" />
		<input type="hidden" id="lune_f_2" value="{lune_f_2_value}" />
	</th>
	<th style="color:lime;">
		<div id="lune_pts_3">-</div>
		<input type="hidden" id="lune_b_3" value="{lune_b_3_value}" />
		<input type="hidden" id="lune_d_3" value="{lune_d_3_value}" />
		<input type="hidden" id="lune_f_3" value="{lune_f_3_value}" />
	</th>
	<th style="color:lime;">
		<div id="lune_pts_4">-</div>
		<input type="hidden" id="lune_b_4" value="{lune_b_4_value}" />
		<input type="hidden" id="lune_d_4" value="{lune_d_4_value}" />
		<input type="hidden" id="lune_f_4" value="{lune_f_4_value}" />
	</th>
	<th style="color:lime;">
		<div id="lune_pts_5">-</div>
		<input type="hidden" id="lune_b_5" value="{lune_b_5_value}" />
		<input type="hidden" id="lune_d_5" value="{lune_d_5_value}" />
		<input type="hidden" id="lune_f_5" value="{lune_f_5_value}" />
	</th>
	<th style="color:lime;">
		<div id="lune_pts_6">-</div>
		<input type="hidden" id="lune_b_6" value="{lune_b_6_value}" />
		<input type="hidden" id="lune_d_6" value="{lune_d_6_value}" />
		<input type="hidden" id="lune_f_6" value="{lune_f_6_value}" />
	</th>
	<th style="color:lime;">
		<div id="lune_pts_7">-</div>
		<input type="hidden" id="lune_b_7" value="{lune_b_7_value}" />
		<input type="hidden" id="lune_d_7" value="{lune_d_7_value}" />
		<input type="hidden" id="lune_f_7" value="{lune_f_7_value}" />
	</th>
	<th style="color:lime;">
		<div id="lune_pts_8">-</div>
		<input type="hidden" id="lune_b_8" value="{lune_b_8_value}" />
		<input type="hidden" id="lune_d_8" value="{lune_d_8_value}" />
		<input type="hidden" id="lune_f_8" value="{lune_f_8_value}" />
	</th>
	<th style="color:lime;">
		<div id="lune_pts_9">-</div>
		<input type="hidden" id="lune_b_9" value="{lune_b_9_value}" />
		<input type="hidden" id="lune_d_9" value="{lune_d_9_value}" />
		<input type="hidden" id="lune_f_9" value="{lune_f_9_value}" />
	</th>
	<th style="color:white;"><div id='total_lune_pts'>-</div></th>
</tr>
<tr>
	<th><a>{homesimulation_Technology}</a></th>	
	<th style="color:lime;">
		{techno_1}
		<input type="hidden" id="techno" value="{techno_value}" />
	</th>
	<th style="color:lime;">{techno_2}</th>
	<th style="color:lime;">{techno_3}</th>
	<th style="color:lime;">{techno_4}</th>
	<th style="color:lime;">{techno_5}</th>
	<th style="color:lime;">{techno_6}</th>
	<th style="color:lime;">{techno_7}</th>
	<th style="color:lime;">{techno_8}</th>
	<th style="color:lime;">{techno_9}</th>
	<th style="color:white;"><div id="techno_pts">-</div></th>
</tr>
<tr>
	<th><a style="color:yellow;">{homesimulation_Totals}</a></th>
	<th style="color:white;"><div id="total_pts_1">-</div></th>
	<th style="color:white;"><div id="total_pts_2">-</div></th>
	<th style="color:white;"><div id="total_pts_3">-</div></th>
	<th style="color:white;"><div id="total_pts_4">-</div></th>
	<th style="color:white;"><div id="total_pts_5">-</div></th>
	<th style="color:white;"><div id="total_pts_6">-</div></th>
	<th style="color:white;"><div id="total_pts_7">-</div></th>
	<th style="color:white;"><div id="total_pts_8">-</div></th>
	<th style="color:white;"><div id="total_pts_9">-</div></th>
	<th style="color:white;"><div id="total_pts">-</div></th>
</tr>
<tr>
	<td class="c">&nbsp;</td>
	<td class="c" style="text-align:center;"><a>{name1}</a></td>
	<td class="c" style="text-align:center;"><a>{name2}</a></td>
	<td class="c" style="text-align:center;"><a>{name3}</a></td>
	<td class="c" style="text-align:center;"><a>{name4}</a></td>
	<td class="c" style="text-align:center;"><a>{name5}</a></td>
	<td class="c" style="text-align:center;"><a>{name6}</a></td>
	<td class="c" style="text-align:center;"><a>{name7}</a></td>
	<td class="c" style="text-align:center;"><a>{name8}</a></td>
	<td class="c" style="text-align:center;"><a>{name9}</a></td>
	<td class='c' style="text-align:center;">{homesimulation_Totals}</td>
</tr>
</table>
<script type="text/javascript">
<!-- Begin
function Check_if_Int(objet,defaut){
	var value = parseInt(objet.value);
	if(isNaN(value)){
		objet.value = defaut;
		return defaut;
	}
	return value;
}
function update_page(){
	var Temp = Array(); var fleet = Array();
	var M = Array();var C = Array();var D = Array();
	var CES = Array(); var CEF = Array(); var Sat = Array();
	var NRJ = Array(); var build = Array(); var def = Array();
	var lune = Array(); var Total = Array(); var ratio = Array();
	for(i=1; i<10; i++){
		M[i] = Array();C[i] = Array();D[i] = Array();
		CES[i] = Array();CEF[i] = Array();Sat[i] = Array();
		NRJ[i] = Array();build[i] = Array();def[i] = Array();
		lune[i] = Array();fleet[i] = Array();
	}
	init_b_prix = new Array(720, 1600000, 700, 2000, 3000, 4000, 800, 150000, 41000, 80000, 80000, 8000000, 60000);
	init_d_prix = new Array(2000, 2000, 8000, 37000, 8000, 130000, 20000, 100000, 10000, 25000);
	init_f_prix = new Array(4000, 12000, 4000, 10000, 29000, 60000, 40000, 18000, 1000, 90000, 125000, 10000000, 85000, 2500);
	init_t_prix = new Array(1400, 1000, 1000, 800, 1000, 1200, 6000, 1000, 6600, 36000, 300, 1400, 7000, 800000, 16000);
	var tek_NRJ = Check_if_Int(document.getElementById("techno_NRJ"),{user_technology_NRJ});
	var off_Ing = Check_if_Int(document.getElementById("off_ingenieur"),0);
	var off_Geo = Check_if_Int(document.getElementById("off_geologue"),0);
	var speed = Check_if_Int(document.getElementById("speed_uni"),1);
	for(i=1; i<10; i++){
		Temp[i] = document.getElementById("Temp_"+i).value;
	
		//Métal 
		M[i]['level'] = document.getElementById("M_"+i).value;
		M[i]['percent'] = document.getElementById("M_"+i+"_percentage").value;
		M[i]['conso'] = Math.round(consumption("M", M[i]['level']) * M[i]['percent'] / 100);
		M[i]['prod'] = Math.round(production("M", M[i]['level'], Temp[i], tek_NRJ) * M[i]['percent'] / 100) * speed;
		if (off_Geo > 0) M[i]['prod'] = Math.round(M[i]['prod'] * 1.1);
	
		//Cristal 
		C[i]['level'] = document.getElementById("C_"+i).value;
		C[i]['percent'] = document.getElementById("C_"+i+"_percentage").value;
		C[i]['conso'] = Math.round(consumption("C", C[i]['level']) * C[i]['percent'] / 100);
		C[i]['prod'] = Math.round(production("C", C[i]['level'], Temp[i], tek_NRJ) * C[i]['percent'] / 100) * speed;
		if (off_Geo > 0) C[i]['prod'] = Math.round(C[i]['prod'] * 1.1);
	
		//CES
		CES[i]['level'] = document.getElementById("CES_"+i).value;
		CES[i]['percent'] = document.getElementById("CES_"+i+"_percentage").value;
		CES[i]['prod'] = production("CES", CES[i]['level'], Temp[i], tek_NRJ) * CES[i]['percent'] / 100;

		//CEF
		CEF[i]['level'] = document.getElementById("CEF_"+i).value;
		CEF[i]['percent'] = document.getElementById("CEF_"+i+"_percentage").value;
		CEF[i]['prod'] = production("CEF", CEF[i]['level'], Temp[i], tek_NRJ) * CEF[i]['percent'] / 100;

		//Sat
		Sat[i]['level'] = document.getElementById("Sat_"+i).value;
		Sat[i]['percent'] = document.getElementById("Sat_"+i+"_percentage").value;
		Sat[i]['prod'] = production_sat(Temp[i]) * Sat[i]['level'] * Sat[i]['percent'] / 100;
	
		//Deutérium
		D[i]['level'] = document.getElementById("D_"+i).value;
		D[i]['percent'] = document.getElementById("D_"+i+"_percentage").value;
		D[i]['conso'] = Math.round(consumption("D", D[i]['level']) * D[i]['percent'] / 100);
		D[i]['prod'] = (Math.round(production("D", D[i]['level'], Temp[i], tek_NRJ) * D[i]['percent'] / 100) 
					- Math.round(consumption("CEF", CEF[i]['level']) * CEF[i]['percent'] / 100)) * speed;
		if (off_Geo > 0) D[i]['prod'] = Math.round(D[i]['prod'] * 1.1);

		//Energie
		NRJ[i]['total'] = Math.round(CES[i]['prod'] + CEF[i]['prod'] + Sat[i]['prod']);
		if (off_Ing > 0) NRJ[i]['total'] = Math.round(NRJ[i]['total'] * 1.1);
		NRJ[i]['delta'] = NRJ[i]['total'] - (M[i]['conso'] + C[i]['conso'] + D[i]['conso']);
		if (NRJ[i]['delta'] < 0) NRJ[i]['delta'] = "<font color='red'>" + NRJ[i]['delta'] + "";

		//Ratio de consommation d'énergie
		ratio[i] = NRJ[i]['total'] / (M[i]['conso'] + C[i]['conso'] + D[i]['conso']);
		if (ratio[i] < 1) {
			M[i]['prod'] = Math.round(M[i]['prod'] * ratio[i]);
			C[i]['prod'] = Math.round(C[i]['prod'] * ratio[i]);
			D[i]['prod'] = Math.round(D[i]['prod'] * ratio[i]);
		} else ratio[i] = 1;
		
		// Batiments
		build[i]['level'] = document.getElementById("building_"+i).value;
		build[i]['level'] = build[i]['level'].split('<>');
		build[i]['pts'] = ((60 + 15) * (1 - Math.pow(1.5, M[i]['level'])) / (-0.5))
						+ ((48 + 24) * (1 - Math.pow(1.6, C[i]['level'])) / (-0.6))
						+ ((225 +75) * (1 - Math.pow(1.5, D[i]['level'])) / (-0.5))
						+ ((75 + 30) * (1 - Math.pow(1.5, CES[i]['level'])) / (-0.5))
						+ ((900 + 360 + 180) * (1 - Math.pow(1.8, CEF[i]['level'])) / (-0.8));
		for(j=0; j<(build[i]['level'].length-2); j++) build[i]['pts'] += init_b_prix[j] * (Math.pow(2, build[i]['level'][j]) - 1);
		build[i]['pts'] = Math.round(build[i]['pts']/1000);
		
		// Défenses
		def[i]['level'] = document.getElementById("defence_"+i).value;
		def[i]['level'] = def[i]['level'].split('<>');
		def[i]['pts'] = 0;
		for(j=0; j<def[i]['level'].length; j++) def[i]['pts'] += init_d_prix[j] * def[i]['level'][j];
		def[i]['pts'] = Math.round(def[i]['pts']/1000);
		
		// Flottes
		fleet[i]['level'] = document.getElementById("fleet_"+i).value;
		fleet[i]['level'] = fleet[i]['level'].split('<>');
		fleet[i]['pts'] = 0;
		for(j=0; j<fleet[i]['level'].length; j++) fleet[i]['pts'] += init_f_prix[j] * fleet[i]['level'][j];
		fleet[i]['pts'] = Math.round(fleet[i]['pts']/1000);
		
		// Lunes
		lune[i]['build'] = document.getElementById("lune_b_"+i).value;
		lune[i]['build'] = lune[i]['build'].split('<>');
		lune[i]['def'] = document.getElementById("lune_d_"+i).value;
		lune[i]['def'] = lune[i]['def'].split('<>');
		lune[i]['fleet'] = document.getElementById("lune_f_"+i).value;
		lune[i]['fleet'] = lune[i]['fleet'].split('<>');
		lune[i]['pts'] = lune[i]['b_pts'] = lune[i]['d_pts'] = lune[i]['f_pts'] = 0;
		for(j=0; j<lune[i]['build'].length; j++) lune[i]['b_pts'] += init_b_prix[j] * (Math.pow(2, lune[i]['build'][j]) - 1);
		for(j=0; j<lune[i]['def'].length; j++) lune[i]['d_pts'] += init_d_prix[j] * lune[i]['def'][j];
		for(j=0; j<lune[i]['fleet'].length; j++) lune[i]['f_pts'] += init_f_prix[j] * lune[i]['fleet'][j];
		lune[i]['pts'] = Math.round((lune[i]['b_pts']+lune[i]['d_pts']+lune[i]['f_pts'])/1000);
		
		
		// Total
		Total[i] = build[i]['pts'] + def[i]['pts'] + lune[i]['pts'] + fleet[i]['pts'];
		
		// Inscription des résultats
		document.getElementById("NRJ_"+i).innerHTML = NRJ[i]['delta'] + " / " + NRJ[i]['total'];
		document.getElementById("ratio_"+i).innerHTML = Math.round(ratio[i] * 100)+" %";
		document.getElementById("M_"+i+"_conso").innerHTML = M[i]['conso'];
		document.getElementById("M_"+i+"_prod").innerHTML = M[i]['prod'];
		document.getElementById("C_"+i+"_conso").innerHTML = C[i]['conso'];
		document.getElementById("C_"+i+"_prod").innerHTML = C[i]['prod'];
		document.getElementById("D_"+i+"_conso").innerHTML = D[i]['conso'];
		document.getElementById("D_"+i+"_prod").innerHTML = D[i]['prod'];
		document.getElementById("building_pts_"+i).innerHTML = build[i]['pts'];		
		document.getElementById("defence_pts_"+i).innerHTML = def[i]['pts'];		
		document.getElementById("lune_pts_"+i).innerHTML = lune[i]['pts'];
		document.getElementById("fleet_pts_"+i).innerHTML = fleet[i]['pts'];
		document.getElementById("total_pts_"+i).innerHTML = Total[i];		
	}
		
	// Technologie
	var techno = document.getElementById("techno").value;
	techno = techno.split('<>');
	var techno_pts = 0;
	for(i=0; i<(techno.length-1); i++) techno_pts = techno_pts + init_t_prix[i] * (Math.pow(2, techno[i]) - 1);
	document.getElementById("techno_pts").innerHTML = Math.round(techno_pts/1000);
	
	// Totaux
	var Builds = Defs = Lunes = Fleet = Totals = M_prod = M_conso = C_prod = C_conso = D_prod = D_conso = Total_NRJ = Total_ratio = 0;
	for(i=1;i<10;i++){
		Total_NRJ += NRJ[i]['total'];
		Total_ratio += ratio[i];
		M_prod += M[i]['prod'];
		M_conso += M[i]['conso'];
		C_prod += C[i]['prod'];
		C_conso += C[i]['conso'];
		D_prod += D[i]['prod'];
		D_conso += D[i]['conso'];
		Builds += build[i]['pts'];
		Defs += def[i]['pts'];
		Lunes += lune[i]['pts'];
		Fleet += fleet[i]['pts'];
		Totals += Total[i];
	}
	//Energie
	var Delta_NRJ = Total_NRJ - (M_conso + C_conso + D_conso);
	if (Delta_NRJ < 0) Delta_NRJ = "<font color='red'>"+Delta_NRJ+"";
	Total_NRJ = "<font color='lime'>"+Delta_NRJ+ " / "+Total_NRJ+""

	Total_ratio = Math.round(Total_ratio/9*100);
	
	document.getElementById("NRJ").innerHTML = Total_NRJ;
	document.getElementById("ratio").innerHTML = Total_ratio+" %";
	document.getElementById("M_prod").innerHTML = M_prod;
	document.getElementById("M_conso").innerHTML = M_conso;
	document.getElementById("C_prod").innerHTML = C_prod;
	document.getElementById("C_conso").innerHTML = C_conso;
	document.getElementById("D_prod").innerHTML = D_prod;
	document.getElementById("D_conso").innerHTML = D_conso;
	document.getElementById("total_b_pts").innerHTML = Builds;
	document.getElementById("total_d_pts").innerHTML = Defs;
	document.getElementById("total_lune_pts").innerHTML = Lunes;
	document.getElementById("total_f_pts").innerHTML = Fleet;
	document.getElementById("total_pts").innerHTML = Totals + Math.round(techno_pts/1000);
}
update_page();
// End -->
</script>
