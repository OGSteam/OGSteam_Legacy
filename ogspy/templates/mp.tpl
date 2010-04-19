<table border="1" style="text-align:center;margin-left:auto;margin-right:auto;">
	<tr style="text-align:center;margin-left:auto;margin-right:auto;">
<!-- IF menu_inbox -->
		<th style="width:150px;">
			<a>{mp_Inbox}</a>
		</th>
<!-- ELSE IF menu_inbox -->
		<td class='c' style="width:150px;" onclick="document.location='?action=mp&amp;subaction=inbox';">
			<a style='cursor:pointer;color:lime;'>{mp_Inbox}</a>
		</td>
<!-- END IF menu_inbox -->
<!-- IF menu_outbox -->
		<th style="width:150px;">
			<a>{mp_outbox}</a>
		</th>
<!-- ELSE IF menu_outbox -->
		<td class='c' style="width:150px;" onclick="document.location='?action=mp&amp;subaction=outbox';">
			<a style='cursor:pointer;color:lime;'>{mp_outbox}</a>
		</td>
<!-- END IF menu_outbox -->
<!-- IF menu_write -->
		<th style="width:150px;">
			<a>{mp_NewMp}</a>
		</th>
<!-- ELSE IF menu_write -->
		<td class='c' style="width:150px;" onclick="document.location='?action=mp&amp;subaction=write';">
			<a style='cursor:pointer;color:lime;'>{mp_NewMp}</a>
		</td>
<!-- END IF menu_write -->
	</tr>
</table>
<br/>
<!-- IF mp_box -->
<table style="text-align:center;margin-left:auto;margin-right:auto;">
<tbody>
	<tr>
		<td class="c" style="width:16px" >{mp_head}</td>
		<td class="c" style="width:300px;white-space:nowrap;">{mp_subject}</td>
		<td class="c" style="width:90px">{mp_author}</td>
		<td class="c" style="width:120px">{mp_date}</td>
		<td class="c" style="width:16px" >{mp_head_right}</td>
	</tr>
<!-- IF is_empty -->
	<tr>
		<th colspan="5">{mp_EmptyBox}</th>
	</tr>
<!-- ELSE IF is_empty -->
<!-- BEGIN list -->
	<tr>
		<td class="{list.class}" align="center"><img src="{list.image}" alt="" /></td>
		<td class="{list.class}" align="center" style="cursor:pointer;" onclick="{list.subject_onclick}"><a>{list.subject}</a></td>
		<td class="{list.class}" align="center" style="cursor:pointer;" onclick="{list.author_onclick}"><a>{list.author}</a></td>
		<td class="{list.class}" align="center">{list.date}</td>
		<td class="{list.class}" align="center" style="cursor:pointer;" onclick="{list.delete_onclick}"><img src="images/drop.png" alt=""/></td>
	</tr>
<!-- END list -->
<!-- END IF is_empty -->
</tbody>
</table>
<!-- END IF mp_box -->
<!-- IF mp_read -->
<table width='500px' style="text-align:center;margin-left:auto;margin-right:auto;">
	<tbody>
	<tr>
		<td colspan='2' class='c'><h2>{subject}</h2></td>
	</tr>
	<tr>
		<td class='b' style ='width: 40%'>{author}</td>
		<td class='b'>{date}</td>
	</tr>
	<tr>
		<td colspan='2' class='f'>{text}</td>
	</tr>
	<tr>
		<td class='c' align='center' onclick="{answer_onclick}"><a><img src='images/b.gif' style='vertical-align: middle;' alt=''/>&nbsp;{mp_Rep}</a></td>
	</tr>
	</tbody>
</table>
<!-- END IF mp_read -->
<!-- IF mp_write -->
<form method="post" action="?action=mp&amp;subaction=send">
<table width='500' style="text-align:center;margin-left:auto;margin-right:auto;">
<tr>
	<td class='c' style='width:80px;'>{mp_subject}</td>
	<td class='c' style='width:410px;'><input type="text" style="width:410px;" name="subject" id="subject" value ="{input_subject}" /></td>
</tr>
</table>
<table width='500' style="text-align:center;margin-left:auto;margin-right:auto;">
	<tr>
		<td style='width:400px;' class='c'>{mp_message}<br/><textarea name="message" id="message" rows="10" cols="60"></textarea></td>
		<td class="c">
			{mp_To}
			<br/>
			<select id="destinataire" style="width:100px;" size="11" multiple="multiple">
<!-- IF is_user -->
<!-- BEGIN mb_list -->
				<option value="{mb_list.user_id}" {mb_list.selected}>{mb_list.user_name}</option>
<!-- END mb_list -->
<!-- END IF is_user -->
			</select>
			<input type="hidden" name="destinataire" id="destinataire_hidden" value="" />
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="submit" value="{mp_Send}" onclick="return send_message_ok();" />
		</td>
	</tr>
</table>
</form>
<!-- END IF mp_write -->
<script type="text/javascript">
<!-- Begin
function send_message_ok(){
	destinataire = document.getElementById('destinataire');
	d='';
	for (var i = 0; i < destinataire.options.length; i++) 
		if (destinataire.options[i].selected) 
			if(!d)
				d = destinataire.options[i].value;
			else
				d += '|'+destinataire.options[i].value;
	s = document.getElementById('subject').value;
	m = escape(document.getElementById('message').value);
	if(m==''||s==''||d==''){
		alert('{mp_All}');
		return false;
	} else {
		document.getElementById('destinataire_hidden').value = d;
		return true;
	}
	//send('?action=mp&amp;subaction=send&amp;subject='+s+'&amp;message='+m+'&amp;destinataire='+d+'&amp;ajax=1');
}
//send('?action=mp&amp;subaction=inbox&amp;ajax=1');
// End -->
</script>
