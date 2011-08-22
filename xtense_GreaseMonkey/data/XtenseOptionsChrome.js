var options = '<div id="Xtense_Div" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;"><br/><br/>';
// Serveur Univers
options+= '<img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/xtense.png" alt="Options Xtense"/>';
options+= '<br/><br/>';
options+= '<table style="width:675px;">' +
		  '<colgroup><col width="25%"/><col width="25%"/><col width="25%"/><col width="25%"/></colgroup>' +
		  '<tbody>' +
		  '<tr>' +
		  '<td align="center"><a onclick="displayOption(\'Xtense_serveurs\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/server.png"/><span id="menu_servers" style="font-size: 20px; color: white;"><b>&#160;Serveur</b></span></a></td>' +
		  '<td align="center"><a onclick="displayOption(\'Xtense_pages\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/pages.png"/><span id="menu_pages" style="font-size: 20px; color: orange;"><b>&#160;Pages</b></span></a></td>' +
		  '<td align="center"><a onclick="displayOption(\'Xtense_options\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/conf.png"/><span id="menu_options" style="font-size: 20px; color: orange;"><b>&#160;Options</b></span></a></td>' +
		  '<td align="center"><a onclick="displayOption(\'Xtense_about\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/about.png"/><span id="menu_about" style="font-size: 20px; color: orange;"><b>&#160;A propos</b></span></a></td>' +
		  '</tr>' +
		  '</tbody>' +
		  '</table>';
options+= '<div id="Xtense_serveurs">';		
options += '<table id="Xtense_table_serveurs" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
options += '<colgroup><col width="20%"/><col/></colgroup>';
options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
options+= '<tbody>';
options+= '<tr>';
options+= '<td class="champ"><label class="styled textBeefy">URL OGSpy</label></td>';
options+= '<td class="value"><input class="speed" id="server.url.plugin" value="'+GM_getValue('server.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
options+= '</tr>';
options+= '<tr><td>&#160;</td><td>&#160;</td></tr>';
options+= '<tr>';
options+= '<td class="champ"><label class="styled textBeefy">Utilisateur</label></td>';
options+= '<td class="value"><input class="speed" id="server.user" value="'+GM_getValue('server.user','utilisateur')+'" size="35" alt="24" type="text"/></td>';
options+= '</tr>';
options+= '<tr><td>&#160;</td><td>&#160;</td></tr>';
options+= '<tr>';
options+= '<td class="champ"><label class="styled textBeefy">Mot de passe</label></td>';
options+= '<td class="value"><input class="speed" id="server.pwd" value="'+GM_getValue('server.pwd','mot de passe')+'" size="35" alt="24" type="password"/></td>';
options+= '</tr>';
options+= '</tbody></table>';
options+= '</div>';			
// Pages
options+= '<div id="Xtense_pages">';
options += '<table id="Xtense_table_pages" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
options += '<colgroup><col width="20%"/><col/></colgroup>';
options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
options+= '<tbody>';
options+= '<tr>';
options+= '<td class="champ"><label class="styled textBeefy">Systemes solaires</label></td>';
//alert("GM_getValue('handle.system','false'))="+(GM_getValue('handle.system','false')=='true')+"\n"+((GM_getValue('handle.system','false')=='true')?'checked="true" ':'checked="false" '));
options+= '<td class="value"><input class="speed" id="handle.system" checked="false" size="35" alt="24" type="checkbox"/></td>';
options+= '</tr>';
options+= '<tr>';
options+= '<td class="champ"><label class="styled textBeefy">Vue générale</label></td>';
options+= '<td class="value"><input class="speed" id="handle.overview" checked="false" size="35" alt="24" type="checkbox"/></td>';
options+= '</tr>';
options+= '</tbody></table>';
options+= '</div>';
// Options
options+= '<div id="Xtense_options">';
options += '<table id="Xtense_table_options" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
options += '<colgroup><col width="20%"/><col/></colgroup>';
options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
options+= '<tbody>';
/*options+= '<tr>';
options+= '<td class="champ"><label class="styled textBeefy">Options</label></td>';
options+= '<td class="value"><input class="speed" id="server.url.plugin" value="'+GM_getValue('server.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
options+= '</tr>';*/
options+= '</tbody></table>';
options+= '</div>';
// A propos
options+= '<div id="Xtense_about">';
options += '<table id="Xtense_table_about" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
options += '<colgroup><col width="20%"/><col/></colgroup>';
options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
options+= '<tbody>';
/*options+= '<tr>';
options+= '<td class="champ"><label class="styled textBeefy">A propos</label></td>';
options+= '<td class="value"><input class="speed" id="server.url.plugin" value="'+GM_getValue('server.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
options+= '</tr>';*/
options+= '</tbody></table>';
options+= '</div>';
options+= '<br/><br/></div>'; //fin Tableau