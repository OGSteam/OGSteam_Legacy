<table width="800">
<tr>
	<td class="c" colspan="2" style="text-align:center;cursor:pointer;width:800px;" onclick="toggle_search();">
		<img id="img1" src="images/{init_picture}.png" style="float:left; display:block;" alt="{init_picture}"/>
		<img id="img2" src="images/{init_picture}.png" style="float:right; display:block;" alt="{init_picture}"/>
		<big>{search_global}</big>
	</td>
</tr>
<tr><td colspan='4'>
<table id="table_body" style="display:{init_display}">
<tr>
	<td style="width:400px;vertical-align:top;">
		<table width="100%">
			<tr>
				<td class="c" colspan="2">{search_Base}</td>
			</tr>
			<tr>
				<th>{common_Player}</th>
				<th>
					<input id="user_name" name = "user_name" type="text" maxlength="25" size="25" value="{player_input}" onkeypress="CheckKey(this,event,false);"/>
				</th>
			</tr>
			<tr>
				<th>{common_Ally}</th>
				<th>
					<input id="ally_name" name="ally_name" type="text" maxlength="25" size="25" value="{ally_input}" onkeypress="CheckKey(this,event,false);"/>
				</th>
			</tr>
			<tr>
				<th>{common_Planet}</th>
				<th>
					<input id="planet_name" name="planet_name" type="text" maxlength="25" size="25" value="{planet_input}" onkeypress="CheckKey(this,event,false);"/>
				</th>
			</tr>
			<tr>
				<th colspan="2">
					{search_And}<input type="radio" name="do_and" value='1' checked="checked"/>
					{search_Or}<input type="radio" name="do_and" value='0'/>
				</th>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td class="c" colspan="4">{search_Option}</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th>{search_WhatEver}</th>
				<th>{basic_Yes}</th>
				<th>{basic_No}</th>
			</tr>
			<tr>
				<th>{search_Colonization}</th>
				<th><input name="free_planet" type="radio" value='2' checked="checked"/></th>
				<th><input name="free_planet" type="radio" value='1'/></th>
				<th><input name="free_planet" type="radio" value='0'/></th>
			</tr>
			<tr>
				<th>{common_Moon}</th>
				<th><input name="moon" type="radio" value='2' checked="checked"/></th>
				<th><input name="moon" type="radio" value='1'/></th>
				<th><input name="moon" type="radio" value='0'/></th>
			</tr>
			<tr>
				<th>{search_InactivePlayers}</th>
				<th><input name="innactive" type="radio" value='2' checked="checked"/></th>
				<th><input name="innactive" type="radio" value='1'/></th>
				<th><input name="innactive" type="radio" value='0'/></th>
			</tr>
			<tr>
				<th>{search_Holiday}</th>
				<th><input name="holiday" type="radio" value='2' checked="checked"/></th>
				<th><input name="holiday" type="radio" value='1'/></th>
				<th><input name="holiday" type="radio" value='0'/></th>
			</tr>
			<tr>
				<th>{search_WithRE}</th>
				<th><input name="with_RE" type="radio" value='2' checked="checked"/></th>
				<th><input name="with_RE" type="radio" value='1'/></th>
				<th><input name="with_RE" type="radio" value='0'/></th>
			</tr>
			<tr>
				<th>{building_Pha}</th>
				<th colspan="3">
					{search_From}&nbsp;<select class='select_list' id="phalanx_down">
						<option value='0'>&nbsp;</option>
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5</option>
						<option value='6'>6</option>
						<option value='7'>7</option>
						<option value='8'>8</option>
						<option value='9'>9</option>
					</select>&nbsp;
					{search_To}&nbsp;<select class='select_list' id="phalanx_up">
						<option value='0'>&nbsp;</option>
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5</option>
						<option value='6'>6</option>
						<option value='7'>7</option>
						<option value='8'>8</option>
						<option value='9'>9</option>
					</select>
				</th>
			</tr>
		</table>
	</td>
	<td style="width:400px;vertical-align:top;">
		<table width="100%">
			<tr>
				<td class="c" colspan="3">{search_Rank}</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th>{search_From}</th>
				<th>{search_To}</th>
			</tr>
			<tr>
				<th>{search_General}</th>
				<th>
					<input id="points_up" type="text" maxlength="9" size="9" value="{general_up_input}" onchange="CheckInt(this);" onkeypress="CheckKey(this,event,true);"/>
				</th>
				<th>
					<input id="points_down" type="text" maxlength="9" size="9" value="{general_down_input}" onchange="CheckInt(this);" onkeypress="CheckKey(this,event,true);"/>
				</th>
			</tr>
			<tr>
				<th>{search_Flotte}</th>
				<th>
					<input id="fleet_up" type="text" maxlength="9" size="9" value="{fleet_up_input}" onchange="CheckInt(this);" onkeypress="CheckKey(this,event,true);"/>
				</th>
				<th>
					<input id="fleet_down" type="text" maxlength="9" size="9" value="{fleet_down_input}" onchange="CheckInt(this);" onkeypress="CheckKey(this,event,true);"/>
				</th>
			</tr>
			<tr>
				<th>{search_Research}</th>
				<th>
					<input id="research_up" type="text" maxlength="9" size="9" value="{research_up_input}" onchange="CheckInt(this);" onkeypress="CheckKey(this,event,true);"/>
				</th>
				<th>
					<input id="research_down" type="text" maxlength="9" size="9" value="{research_down_input}" onchange="CheckInt(this);" onkeypress="CheckKey(this,event,true);"/>
				</th>
			</tr>
			<tr>
				<th colspan="3">
					<input type="radio" name="rank_type" value="J" checked="checked" />{common_Player}&nbsp;
					<input type="radio" name="rank_type" value="A"/>{common_Ally}
				</th>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td class="c" colspan="3">{search_Position}</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th>{search_From}</th>
				<th>{search_To}</th>
			</tr>
			<tr>
				<th>{common_Galaxy}</th>
				<th><select class='select_list' id='galaxy_down'>{galaxy_options}</select></th>
				<th><select class='select_list' id='galaxy_up'>{galaxy_options}</select></th>
			</tr>
			<tr>
				<th>{common_System}</th>
				<th><select class='select_list' id='system_down'>{system_options}</select></th>
				<th><select class='select_list' id='system_up'>{system_options}</select></th>
			</tr>
			<tr>
				<th>{common_Row}</th>
				<th><select class='select_list' id='row_down'>{row_options}</select></th>
				<th><select class='select_list' id='row_up'>{row_options}</select></th>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<th colspan="4">
		<input type="submit" value="{search_SearchPosition}" onclick="do_search()"/>
	</th>
</tr>
</table>
</td></tr>
<tr>
	<th colspan="4" id="ajax_info">{info}</th>
</tr>
</table>
<br/>
<div id="ajax_retour">{content}</div>
<script type="text/javascript">
<!-- Begin
function CheckKey(cible,event,check){
	if(event.keyCode==13){
		if(check) CheckInt(this);
		do_search();
	}
}
function CheckInt(cible){
	//cible = document.getElementById(cible);
	if(isNaN(i=parseInt(cible.value)))
		cible.value = "";
	else
		cible.value = i;
}
function toggle_search(){
	if(document.getElementById('table_body').style.display != 'none')
		hide_search();
	else
		draw_search();
}
function draw_search(){
	document.getElementById('table_body').style.display = 'block';
	document.getElementById('img1').src = 'images/arrow_top.png';
	document.getElementById('img2').src = 'images/arrow_top.png';
}
function hide_search(){
	document.getElementById('table_body').style.display = 'none';
	document.getElementById('img1').src = 'images/arrow_down.png';
	document.getElementById('img2').src = 'images/arrow_down.png';
}
function do_search(){
	link = get_data();
	//send(link+'&ajax=1&order=coords&order_o=asc&start=0&length=25');
	window.location = link+'&order=coords&order_o=asc&start=0&length=25';
}
function col_sort(type){
	request = document.getElementById('request').value;
	order = document.getElementById('order').value;
	order_o = document.getElementById('order_o').value;
	start = parseInt(document.getElementById('start').value);
	length = isNaN(a=parseInt(document.getElementById('length').value))?25:a;
	if(type==order){
		if(order_o=='asc')
			order_o = 'desc';
		else
			order_o = 'asc';
	} else {
		order = type;
		order_o = 'asc';
	}
	window.location = '?'+request+'&order='+order+'&order_o='+order_o+'&start='+start+'&length='+length;
}
function change_page(prev_next){
	request = document.getElementById('request').value;
	order = document.getElementById('order').value;
	order_o = document.getElementById('order_o').value;
	start =  parseInt(document.getElementById('start').value);
	length = isNaN(a=parseInt(document.getElementById('length').value))?25:a;
	count = parseInt(document.getElementById('count').innerHTML);
	if(prev_next=='next')
		start += length;
	else if(prev_next=='prev')
		start -= length;
	else
		start = parseInt(document.getElementById(prev_next).value)*length;
	if(start+1>count) return;
	if(start<0) start = 0;
	if(start!=parseInt(document.getElementById('start').value))
		window.location='?'+request+'&order='+order+'&order_o='+order_o+'&start='+start+'&length='+length;
}
function change_length(){
	request = document.getElementById('request').value;
	order = document.getElementById('order').value;
	order_o = document.getElementById('order_o').value;
	start =  parseInt(document.getElementById('start').value);
	length = parseInt(document.getElementById('length').value);
	window.location ='?'+request+'&order='+order+'&order_o='+order_o+'&start='+start+'&length='+length;
}
function get_data(){
	free_planets = document.getElementsByName('free_planet');
	for(i=0;i<free_planets.length;i++)
		if(free_planets[i].checked) { free_planet = free_planets[i].value; continue; }
	moons = document.getElementsByName('moon');
	for(i=0;i<moons.length;i++)
		if(moons[i].checked) { moon = moons[i].value; continue; }
	innactives = document.getElementsByName('innactive');
	for(i=0;i<innactives.length;i++)
		if(innactives[i].checked) { innactive = innactives[i].value; continue; }
	with_REs = document.getElementsByName('with_RE');
	for(i=0;i<with_REs.length;i++)
		if(with_REs[i].checked) { with_RE = with_REs[i].value; continue; }
	holidays = document.getElementsByName('holiday');
	for(i=0;i<holidays.length;i++)
		if(holidays[i].checked) { holiday = holidays[i].value; continue; }
	do_ands = document.getElementsByName('do_and');
	for(i=0;i<do_ands.length;i++)
		if(do_ands[i].checked) { do_and = do_ands[i].value; continue; }
	rank_types = document.getElementsByName('rank_type');
	for(i=0;i<rank_types.length;i++)
		if(rank_types[i].checked) { rank_type = rank_types[i].value; continue; }
	phalanx_up = document.getElementById('phalanx_up').value;
	phalanx_down = document.getElementById('phalanx_down').value;
	user_name = document.getElementById('user_name').value;
	ally_name = document.getElementById('ally_name').value;
	planet_name = document.getElementById('planet_name').value;
	galaxy_up = document.getElementById('galaxy_up').value;
	galaxy_down = document.getElementById('galaxy_down').value;
	system_up = document.getElementById('system_up').value;
	system_down = document.getElementById('system_down').value;
	row_up = document.getElementById('row_up').value;
	row_down = document.getElementById('row_down').value;
	points_up = isNaN(a=parseInt(document.getElementById('points_up').value))?'':a;
	points_down = isNaN(a=parseInt(document.getElementById('points_down').value))?'':a;
	fleet_up = isNaN(a=parseInt(document.getElementById('fleet_up').value))?'':a;
	fleet_down = isNaN(a=parseInt(document.getElementById('fleet_down').value))?'':a;
	research_up = isNaN(a=parseInt(document.getElementById('research_up').value))?'':a;
	research_down = isNaN(a=parseInt(document.getElementById('research_down').value))?'':a;
	return '?action=search&search&user_name='+user_name+'&ally_name='+ally_name+'&planet_name='+planet_name+'&free_planet='+free_planet+'&moon='+moon+'&innactive='+innactive+'&with_RE='+with_RE+'&holiday='+holiday+'&phalanx_up='+phalanx_up+'&phalanx_down='+phalanx_down+'&galaxy_up='+galaxy_up+'&galaxy_down='+galaxy_down+'&system_up='+system_up+'&system_down='+system_down+'&row_up='+row_up+'&row_down='+row_down+'&points_up='+points_up+'&points_down='+points_down+'&fleet_up='+fleet_up+'&fleet_down='+fleet_down+'&research_up='+research_up+'&research_down='+research_down+'&do_and='+do_and+'&rank_type='+rank_type;
}
// End -->
</script>
