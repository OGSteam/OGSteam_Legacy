<table>
	<tr>
		<td class="c" onclick="col_sort('coords');" style="cursor:pointer;text-align:center;width:75px;">
			{search_Coordinates}
		</td>
		<td class="c" onclick="col_sort('name');" style="cursor:pointer;text-align:center;width:160px;">
			{common_Planet}
		</td>
		<td class="c" style="text-align:center;width:40px;">
			{common_Moon}
		</td>
		<td class="c" onclick="col_sort('name_player');" style="cursor:pointer;text-align:center;width:160px;">
			{common_Players}
		</td>
		<td class="c" onclick="col_sort('name_ally');" style="cursor:pointer;text-align:center;width:125px;">
			{common_Allys}
		</td>
		<td class="c" style="width:20px;">&nbsp;</td>
		<td class="c" style="width:20px;">&nbsp;</td>
		<td class="c" style="width:20px;">&nbsp;</td>
		<td class="c" onclick="col_sort('last_update');" style="cursor:pointer;text-align:center;width:200px;">
			{last_update}
		</td>
	</tr>
<!-- IF is_result -->
	<tr>
		<td colspan='9'>
			<table width='100%'>
				<tr>
					<th><input type='button' value='&lt;&lt;&lt;' onclick="change_page('prev');"/></th>
					<th style="width:100%;">
						{search_ResultByPage}&nbsp;
						<input type="text" maxlength="4" size="5" id="length" value="{length}" style="text-align:center;" onchange="change_length();"/>
					</th>
					<th style="white-space:nowrap;">
						<select id="page" onchange="change_page('page');" style="text-align:center;">
						{page_options}
						</select>
					</th>
					<th><input type='button' value='&gt;&gt;&gt;' onclick="change_page('next');"/></th>
				</tr>
			</table>
		</td>
	</tr>
<!-- BEGIN list -->
	<tr style="visibility:{list.visibility};">
		<th class="list" onclick="window.location='{list.coords_link}';" 
			onmouseover="this.className='list_over';" onmouseout="this.className='list';">
			{list.coords}
		</th>
		<th>{list.name}</th>
		<th>{list.moon}</th>
		<th class="list">{list.user}</th>
		<th class="list">{list.ally}</th>
		<th>{list.status}</th>
		<th class="list">{list.RE}</th>
		<th class="list">{list.RC}</th>
		<th>{list.date}</th>
	</tr>
<!-- END list -->
	<tr>
		<td colspan='9'>
			<table width='100%'>
				<tr>
					<th><input type='button' value='&lt;&lt;&lt;' onclick="change_page('prev');"/></th>
					<th style="width:100%;">
						{search_NbResult} : <span id='count'>{count}</span> 
					</th>
					<th  style="white-space: nowrap;">
						<select id="page2" onchange="change_page('page2');" style="text-align:center;">
						{page_options}
						</select>
					</th>
					<th><input type='button' value='&gt;&gt;&gt;' onclick="change_page('next');"/></th>
				</tr>
			</table>
		</td>
	</tr>
<!-- ELSE IF is_result -->
	<tr>
		<th colspan="9">{search_NoResult}</th>
	</tr>
<!-- END IF is_result -->
<!-- IF show_rank -->
<!-- END IF show_rank -->
</table>
<input id='request' type='hidden' value='{request}'/>
<input id='order' type='hidden' value='{order}'/>
<input id='order_o' type='hidden' value='{order_o}'/>
<input id='start' type='hidden' value='{start}'/>
