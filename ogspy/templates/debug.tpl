<!-- IF no_ajax -->
<div id='debug_form' style="text-align:center;">
<!-- END IF no_ajax -->
<table border="0" cellpadding="3" cellspacing="1" style="width:500px; background-color:#000000; margin-left:auto;margin-right:auto;">
	<tr style="background-color:#9999CC">
		<td class="c" colspan="2">{debug_session}</td>
	</tr>
<!-- IF session --> 
<!-- BEGIN session -->
	<tr bgcolor="#CCCCCC">
		<td style="background-color:#CCCCFF; white-space: nowrap;">{session.key}</td>
		<td>{session.value}</td>
	</tr>
<!-- END session -->
<!-- END IF session -->
	<tr style="background-color:#9999CC;"><td class="c" colspan="2">{debug_URL}</td></tr>
<!-- IF url -->
<!-- BEGIN url -->
	<tr>
		<th style="white-space: nowrap;">{url.key}</th>
		<th>{url.value}</th>
	</tr>
<!-- END url -->
<!-- END IF url -->
	<tr style="background-color:#9999CC"><td class="c" colspan="2">{debug_form}</td></tr>
<!-- IF form -->
<!-- BEGIN form -->
	<tr>
		<th style="white-space: nowrap;">{form.key}</th>
		<th>{form.value}</th>
	</tr>
<!-- END form -->
<!-- END IF form -->
</table>
<!-- IF no_ajax -->
</div>
<!-- END IF no_ajax -->
