<script type="text/javascript">
<!--
	var date = new Date();
	var delta = Math.round(({TIME} - date.getTime()) / 1000);
	
	function timer()
	{
		if (document.getElementById)
		{
			var days = new Array ({DAY_LIST});
			var months = new Array ({MONTH_LIST});
			
			date = new Date();
			date.setTime(date.getTime() + delta * 1000);
			
			var hour = date.getHours();
			var min = date.getMinutes();
			var sec = date.getSeconds();
			var day = days[date.getDay()];
			var day_number = date.getDate();
			var month = months[date.getMonth()];
			
			if (sec < 10) sec = "0" + sec;
			if (min < 10) min = "0" + min;
			if (hour < 10) hour = "0" + hour;
			
			var datetime = day + " " + day_number + " " + month + " " + hour + ":" + min + ":" + sec;
			
			document.getElementById("datetime").textContent = datetime;
		}
	}
	
	function clear_box()
	{
		if(document.getElementById('zonetexte').textContent == "{EXPLAIN_TEXT_JS}")
			document.getElementById('zonetexte').textContent = "";
	}
	
	function biper()
	{
		timer();
		setTimeout("biper()", 1000);
	}
	
	window.onload = biper;
-->
</script>

<table>
	<tr>
		<td class="time-1 strong">{MENU_TIME}</td>
	</tr>
	<tr>
		<td id="datetime" class="time-2">{TIME_WAIT}</td>
	</tr>
	<tr>
		<td class="ogspy-logo"></td>
	</tr>
	
	<!-- IF server_desactive -->
	
	<tr>
		<td><span class="strong red">{MENU_OFFLINE}</span></td>
	</tr>
	
	<!-- END IF server_desactive -->
	
	<!-- IF admin_menu -->
	
	<tr>
		<td><a href="?action=administration">{ADMIN_MENU}</a></td>
	</tr>
	
	<!-- END IF admin_menu -->
	
	<tr>
		<td><a href="?action=profile">{MENU_PROFILE}</a></td>
	</tr>
	<tr>
		<td><a href="?action=home">{MENU_HOME}</a></td>
	</tr>
	<tr>
		<td><a href="?action=mp">{MENU_MESSAGE}</a></td>
	</tr>
	<tr>
		<td class="separator"></td>
	</tr>
	<tr>
		<td><a href="?action=galaxy">{MENU_GALAXY}</a></td>
	</tr>
	<tr>
		<td><a href="?action=cartography">{MENU_ALLY_TERRITORY}</a></td>
	</tr>
	<tr>
		<td><a href="?action=search">{MENU_SEARCH}</a></td>
	</tr>
	<tr>
		<td><a href="?action=ranking">{MENU_RANKING}</a></td>
	</tr>
	<tr>
		<td class="separator"></td>
	</tr>
	<tr>
		<td><a href="?action=statistic">{MENU_STATISTICS}</a></td>
	</tr>
	<tr>
		<td class="separator"></td>
	</tr>
	
	<!-- BEGIN mod_list -->	
		<!-- IF mod_list.link -->
		
		<tr>
			<td><a href="{mod_list.action}">{mod_list.title}</a></td>
		</tr>
		
		<!-- ELSE IF mod_list.link -->
			<!-- IF mod_list.category -->
			
			<tr>
				<td>{mod_list.title}</td>
			</tr>
			
			<!-- ELSE IF mod_list.category -->
			
			<tr>
				<td class="separator"></td>
			</tr>
			
			<!-- END IF mod_list.category -->
		<!-- END IF mod_list.link -->
	<!-- END mod_list -->
	
	<tr>
		<td><a href="?action=logout">{MENU_LOGOUT}</a></td>
	</tr>
	<tr>
		<td class="separator"></td>
	</tr>
	
	<!-- IF url_forum -->
	
	<tr>
		<td><a href="{URL_FORUM}">{MENU_FORUM}</a></td>
	</tr>
	
	<!-- END IF url_forum -->
	
	<tr>
		<td><a href="?action=about">{MENU_ABOUT}</a></td>
	</tr>
	<tr>
		<td class="end"></td>
	</tr>
</table>

<form method="post" enctype="multipart/form-data" action="index.php">
	<table>
		<!-- IF item_list -->
		
		<tr>
			<td>
				<select name='datatype'>
					<!-- BEGIN item -->
					
					<option value='{item.value}'>{item.text}</option>
					
					<!-- END item -->
				</select>
			</td>
		</tr>
		
		<tr>
			<td>
				<textarea name='data' id='zonetexte' rows='3' cols='20' onfocus='clear_box()'>{EXPLAIN_TEXT}</textarea>
			</td>
		</tr>
		
		<tr>
			<td>
				<input type="hidden" name="action" value="get_data" />
				<input type='submit' value="{MENU_SEND}" />
			</td>
		</tr>
		
		<!-- ELSE IF item_list -->
		
		<tr>
			<td>
				<textarea name='data' id='zonetexte' rows='3' cols='20' onfocus='clear_box()'>{SENDBOX_FORBIDDEN}</textarea>
			</td>
		</tr>
		
		<!-- END IF item_list -->
	</table>
</form>