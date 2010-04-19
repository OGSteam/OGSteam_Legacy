<br/><br/>
<table style="text-align:center;margin-left:auto;margin-right:auto;" width="50%">
<!-- IF is_logs -->
	<tr>
		<td class="k" colspan='2'>{adminviewer_DateSelection}</td>
	</tr>
	<tr>
		<th>
			{adminviewer_SelectMonth}<br/>
			<input type="button" value="&lt;&lt;&lt;" id="prev_month" onclick="action_move('select_month','prev');" style="cursor:pointer;" />
			<select id='select_month' onchange='update_days()' style='text-align:center;'>
				{month_selectlist}
			</select>
			<input type="button" value="&gt;&gt;&gt;" id="next_month" onclick="action_move('select_month','next');" style="cursor:pointer;" /><br/>
			<img src="images/save.png" onclick="icon_action('log_extractor','select_month');" style="cursor:pointer;" alt="" />
			<img src="images/drop.png" onclick="icon_action('log_erase','select_month');" style="cursor:pointer;" alt="" />
		</th>
		<th>
			{adminviewer_SelectDay}<br/>
			<input type="button" value="&lt;&lt;&lt;" id="prev_day" onclick="action_move('select_day','prev');" style="cursor:pointer;" />
			<select id='select_day' onchange="show_log();" style='text-align:center;'>
				<option>&nbsp;</option>
			</select>
			<input type="button" value="&gt;&gt;&gt;" id="next_day" onclick="action_move('select_day','next');" style="cursor:pointer;"  /><br/>
			<img src="images/save.png" onclick="icon_action('log_extractor','select_day');" style="cursor:pointer;" alt="" />
			<img src="images/drop.png" onclick="icon_action('log_erase','select_day');" style="cursor:pointer;" alt="" />
		</th>
	</tr>
<!-- ELSE IF is_logs -->
	<tr>
		<th colspan="2">{no_logs_infos}</th>
	</tr>
<!-- END IF is_logs -->
</table>
<br/><br/>
<table width="100%">
	<tr>
		<th colspan="3" style="height:25px"><big id="selected_date">&nbsp;</big></th>
	</tr>
	<tr>
		<th style="width:25%;text-align:right;{type_log_style}">{type_log_onclick}{adminviewer_GeneralLog}{type_log_end}</th>
		<td style="width:50%;" class='k'><big>{type_selected}</big></td>
		<th style="width:25%;text-align:left;{type_sql_style}" >{type_sql_onclick}{adminviewer_SQLLog}{type_sql_end}</th>
	</tr>
	<tr>
		<td class="l" colspan="3"><b>{adminviewer_Viewer}</b><br/>
		<span id="log_content">
		</span>
		</td>
	</tr>
</table>
<!-- IF is_logs -->
<script src="library/prototype/prototype.js" type="text/javascript"></script>
<script type="text/JavaScript">
<!-- Begin
var LogContent 	= $('log_content');
var SelectDays 	= $('select_day');
var SelectedDate = $('selected_date');

var log_showed = '{pub_showlog}';
var month_key = new Array("{month_key}");
var month_value = new Array("{month_value}");
var day_key = new Array();
var day_value = new Array();
<!-- BEGIN day_array -->
day_key['{day_array.id}'] = new Array("{day_array.key}");
day_value['{day_array.id}'] = new Array("{day_array.content}");
<!-- END day_array -->

function show_log(){
//	date = document.getElementById('select_day').value;
//	window.location = '?action=administration&amp;subaction=viewer&amp;showlog='+date;
		
		new Ajax.Request('?',
		{
			method: 'get',
			parameters	:
			{
				action  : 'administration',
				subaction : 'viewer',
				showlog : SelectDays.value,
				ajax	: '1',
				type	: '{pub_type}'	
			},
			onCreate:   function() 
			{ 
				SelectedDate.update('<'+'img src="images/ajax.gif" align="absmiddle" />&nbsp;{common_AjaxChargement}'); 
			},
			onSuccess: function(transport)
			{
				var json = transport.responseText.evalJSON(true);
				
				if (Object.toJSON(json).include('SyntaxError:') == false)
				{
					var len = json['table'].length;
					var update_link = new Element('span', { style: 'cursor:pointer;', onclick: 'show_log();' }).update(json['selected_date'].stripScripts());
					SelectedDate.update().appendChild(update_link);
					LogContent.update();
					for (i = 0; i < len; i ++) 
					{
						date = new Element('font', { style: 'color:orange;' }).update(json['table'][i]['date'].stripScripts());
						LogContent.appendChild(date);
						LogContent.insert(json['table'][i]['line'].stripScripts()).insert('<'+'br />');
					}
				}
				else
				{
					alert(json);
				}
			},
			onFailure: function()
			{
				alert('Something went wrong...');
			}
		});

	check_button();
}
function update_days(){
	month = document.getElementById('select_month');
	day = document.getElementById('select_day');
	day.innerHTML = "";
	has_selected = false;
	for(i=0;i< day_key[month.value].length;i++){
		sel = '';
		if(day_key[month.value][i] == log_showed){ sel = ' selected'; has_selected = true; }
		if(i==day_key[month.value].length-1 && has_selected==false) sel = ' selected';
		day.innerHTML += "<"+"option value="+day_key[month.value][i]+" id='day_key_"+day_key[month.value][i]+"' style='text-align:center;'"+sel+">"+day_value[month.value][i]+"</"+"option>";
	}
	show_log();
}


function action_move(select_id,type){
	sel = document.getElementById(select_id);
	opt = sel.getElementsByTagName('option');
	the_next = the_last = sel.selectedIndex;
	if(type=='prev' && the_last != 0)
		the_next = the_last - 1;
	if(type=='next' && the_last != opt.length-1)
		the_next = the_last + 1;
	opt[the_last].selected = false;
	opt[the_next].selected = true;
		if(the_next!=the_last){
		if(select_id=='select_month')
			update_days();
		else	
			show_log();	
	}
	}

function icon_action(action,select_id){
	sel = document.getElementById(select_id);
	sel2 = document.getElementById('select_day');
	text = sel.getElementsByTagName('option')[sel.selectedIndex].innerHTML;
	value = sel2.getElementsByTagName('option')[sel2.selectedIndex].value;
	rg = new RegExp("\%s");
	str = '{adminviewer_dellog} ??';
	if(action=='log_erase')
		if(!confirm(str.replace(rg,text))) return;
	window.location = '?action='+action+'&'+'logtype='+select_id+'&'+'showlog='+value;
}
function check_button(){
	s_month = document.getElementById('select_month');
	s_day = document.getElementById('select_day');
	i_month = s_month.selectedIndex;
	i_day = s_day.selectedIndex;
	document.getElementById('prev_day').style.visibility = 
		(i_day==0)?'hidden':'visible';
	document.getElementById('next_day').style.visibility = 
		(i_day==s_day.getElementsByTagName('option').length-1)?'hidden':'visible';
	document.getElementById('prev_month').style.visibility = 
		(i_month==0)?'hidden':'visible';
	document.getElementById('next_month').style.visibility = 
		(i_month==s_month.getElementsByTagName('option').length-1)?'hidden':'visible';
}
update_days();
// End -->
</script>
<!-- END IF is_logs -->







