<!--
			* Contenu d'un toopTip d'aide
 -->
<!-- define=help_tip -->
<table width="200" style="z-index:100;"><tbody>
	<tr>
		<th style="text-align:center;background-color:#000000;"><span style="color:#D3D3D3;">{help_tip.value}</span></th>
	</tr></tbody>
</table>
<!-- /define -->
<!--
			* Lien d'un tooptip d'aide quand il doit se refermer dès que la sourie quitte l'image
 -->
<!-- define=help_link_autoclose -->
<img style="cursor:help" 
	src="{help_link_autoclose.prefixe}images/help_2.png" 
	onmouseover="Tip('{help_link_autoclose.tip}',TITLE,'{help_link_autoclose.title}');" 
	onmouseout="UnTip();"
	alt="help_icon" />
<!-- /define -->
<!--
			* Lien d'un tooltip d'aide quand il doit rester afficher jusqu'a ce que l'utilisateur clic ( cas des tooltips qui intégrent des liens)
 -->
<!-- define=help_link_clicktoclose -->
<img style="cursor:help" 
	src="{help_link_clicktoclose.prefixe}images/help_2.png" 
	onmouseover="Tip('{help_link_clicktoclose.tip}',TITLE,'{help_link_clicktoclose.title}',CLICKCLOSE,true);"
	alt="help_icon" />
<!-- /define -->
<!--
			* Tooltip d'information affiché su le pseudo des membres dans l'administration des membres (résumé des droits)
 -->
<!-- define=admin_user_detail -->
<table width="400" style="background:#000;">
	<tr>
		<td class="c" colspan="2" align="center">{admin_user_detail.title}</td>
	</tr>
	<tr>
		<td valign="top">
		<table>
			<tr>
				<td class="c" colspan="2">{admin_ServerRights}</td></tr>
			<tr>
				<th>{admin_AddSolarSystem}</th>
				<th>{admin_user_detail.YesNo_server_set_system}</th>
			</tr>
		<tr><th>{admin_AddSpyReport}</th><th>{admin_user_detail.YesNo_server_set_spy}</th></tr>
		<tr><th>{admin_AddRanking}</th><th>{admin_user_detail.YesNo_server_set_ranking}</th></tr>
		<tr><th>{admin_ViewHiddenPosition}</th><th>{admin_user_detail.YesNo_server_show_positionhided}</th></tr>
		<tr><td colspan="2">&nbsp;</th></tr>
		</table></td><td><table valign="top">
		<tr><td class="c" colspan="2">{admin_ExternalClientRights}</td></tr>
		<tr><th>{admin_ServerConnection}</th><th>{admin_user_detail.YesNo_ogs_connection}</th></tr>
		<tr><th>{admin_ImportSolarSystem}</th><th>{admin_user_detail.YesNo_ogs_set_system}</th></tr>
		<tr><th>{admin_ExportSolarSystem}</th><th>{admin_user_detail.YesNo_ogs_get_system}</th></tr>
		<tr><th>{admin_ImportSpyReport}</th><th>{admin_user_detail.YesNo_ogs_set_spy}</th></tr>
		<tr><th>{admin_ExportSpyReport}</th><th>{admin_user_detail.YesNo_ogs_get_spy}</th></tr>
		<tr><th>{admin_ImportRanking}</th><th>{admin_user_detail.YesNo_ogs_set_ranking}</th></tr>
		<tr><th>{admin_ExportRanking}</th><th>{admin_user_detail.YesNo_ogs_get_ranking}</th></tr>
		</table></td></tr>
		<!-- define=admin_user_detail.mod_list -->
			<tr><td class="c" colspan="2">{admin_ModsRestricts}</td></tr>
			<tr><th colspan="2">{admin_user_detail.mod_list.mod_names}</th></tr>
		<!-- /define -->
		</table>
<!-- /define -->
<!--
			* Affichage d'un nom spécial (clignotement)
 -->
<!-- define=hided_blink --><span style="text-decoration:blink;">{hided_blink.content}</span><!-- /define -->
<!--
			*  Affiche d'un nom special (couleur)
 -->
<!-- define=hided_color --><span style="color:{hided_color.color};">{hided_color.content}</span><!-- /define -->
<!--
			* Code d'un lien ouvrant un popup (RE, RC)
-->
<!-- define=cell_windowopen -->
<span onclick="window.open('{cell_windowopen.link}','_blank','width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');return(false);" style="cursor:pointer;">
	<a>{cell_windowopen.content}</a>
</span>
<!-- /define -->
<!--
			* Affiche des infos sur les classements (joueur et alliance)
 -->
<!-- define=rank_tip_link -->Tip('{rank_tip_link.tip}',DURATION,'3500',CLICKCLOSE,'true',TITLE,'{rank_tip_link.title}');<!-- /define -->
<!-- define=rank_tip -->
<table width='250'><tr><td class='c' colspan='4' align='center'>{search_Rank}</td></tr><tr><td class='c' style="width:75px">{search_General}</td><th style="width:30px;color:LightCyan;">{rank_tip.g_rank}</th><th style="color:LightCyan;">{rank_tip.g_points}</th><th style="white-space:nowrap;color:LightCyan;">{rank_tip.g_date}</th></tr><tr><td class='c'>{search_Flotte}</td><th style="color:LightCyan;">{rank_tip.f_rank}</th><th style="color:LightCyan;">{rank_tip.f_points}</th><th style="white-space:nowrap;color:LightCyan;">{rank_tip.f_date}</th></tr><tr><td class='c'>{search_Research}</td><th style="color:LightCyan;">{rank_tip.r_rank}</th><th style="color:LightCyan;">{rank_tip.r_points}</th><th style="white-space:nowrap;color:LightCyan;">{rank_tip.r_date}</th></tr><tr><td class='c' colspan='4' align='center'><a href='{rank_tip.link}'>{search_DetailsView}</a></td></tr></table>
<!-- /define -->
