<?php
/** $Id$ **/
/**
* Panneau administration des options d'Affichages
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	redirection("?action=message&amp;id_message=forbidden&info");
}

//on inclut les langs menu
lang_load_page("menu");

$galaxy_by_line_stat = $server_config['galaxy_by_line_stat'];
$system_by_line_stat = $server_config['system_by_line_stat'];
$enable_stat_view = $server_config['enable_stat_view'] == 1 ? "checked='checked'" : "";
$enable_members_view = $server_config['enable_members_view'] == 1 ? "checked='checked'" : "";
$galaxy_by_line_ally = $server_config['galaxy_by_line_ally'];
$system_by_line_ally = $server_config['system_by_line_ally'];
$nb_colonnes_ally = $server_config['nb_colonnes_ally'];
$enable_register_view = $server_config['enable_register_view'] == 1 ? "checked='checked'" : "";
$register_forum = $server_config['register_forum'];
$register_alliance = $server_config['register_alliance'];
$enable_portee_missil = $server_config['portee_missil'] == 1 ? "checked='checked'" : "";
$enable_friendly_phalanx = $server_config['friendly_phalanx'] == 1 ? "checked='checked'" : "";
$open_user = $server_config['open_user'];
$open_admin = $server_config['open_admin'];

$color_ally_n = $server_config['color_ally'];
$color_ally_e = explode("_", $color_ally_n);

$scolor_count = $server_config['scolor_count'];
$scolor_type = explode("_", $server_config['scolor_type']);
$scolor_text = explode("_|_", $server_config['scolor_text']);	
$scolor_color = explode("_", $server_config['scolor_color']);

// Creation des listes des mods :
$result = $db->sql_query("SELECT mods FROM ".TABLE_MOD_CAT." WHERE title = 'Admin'");
list($m_admin) = $db->sql_fetch_row($result);
$mod_ids = explode(' ',$m_admin);
$m_user = $m_admin = Array();
$m_total = $db->sql_query("SELECT id, root, link FROM ".TABLE_MOD." WHERE active = '1' ORDER BY position");
while ($mod = $db->sql_fetch_assoc($m_total)) {
	$mod['title'] = mod_info_title($mod['root']);
	if(in_array($mod['id'],$mod_ids))
		$m_admin[] = $mod;
	else
		$m_user[] = $mod;
}

for ($i = 0 ; $i < $nb_colonnes_ally+$scolor_count ; $i ++){
	$help["color_picker$i"] = addslashes("<script type=\"text/javascript\">function View(x){alert(x);} function Set(x){alert(x);}</script><table border=0 cellspacing=1 cellpadding=0 bgcolor=#000000 style=\"cursor: hand;\" onclick=Set($i)><tr height=10><td bgcolor=black onMouseOver=View('black'); width=10></td><td bgcolor=#000000 onMouseOver=View('#000000') width=10></td><td bgcolor=#001900 onMouseOver=View('#001900') width=10></td><td bgcolor=#003300 onMouseOver=View('#003300') width=10></td><td bgcolor=#006600 onMouseOver=View('#006600') width=10></td><td bgcolor=#009900 onMouseOver=View('#009900') width=10></td><td bgcolor=#00CC00 onMouseOver=View('#00CC00') width=10></td><td bgcolor=#00FF00 onMouseOver=View('#00FF00') width=10></td><td bgcolor=#330000 onMouseOver=View('#330000') width=10></td><td bgcolor=#333300 onMouseOver=View('#333300') width=10></td><td bgcolor=#336600 onMouseOver=View('#336600') width=10></td><td bgcolor=#339900 onMouseOver=View('#339900') width=10></td><td bgcolor=#33CC00 onMouseOver=View('#33CC00') width=10></td><td bgcolor=#33FF00 onMouseOver=View('#33FF00') width=10></td><td bgcolor=#660000 onMouseOver=View('#660000') width=10></td><td bgcolor=#663300 onMouseOver=View('#663300') width=10></td><td bgcolor=#666600 onMouseOver=View('#666600') width=10></td><td bgcolor=#669900 onMouseOver=View('#669900') width=10></td><td bgcolor=#66CC00 onMouseOver=View('#66CC00') width=10></td><td bgcolor=#66FF00 onMouseOver=View('#66FF00') width=10></td></tr><tr height=10><td bgcolor=darkgray onMouseOver=View('darkgray')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#000033 onMouseOver=View('#000033')></td><td bgcolor=#003333 onMouseOver=View('#003333')></td><td bgcolor=#006633 onMouseOver=View('#006633')></td><td bgcolor=#009933 onMouseOver=View('#009933')></td><td bgcolor=#00CC33 onMouseOver=View('#00CC33')></td><td bgcolor=#00FF33 onMouseOver=View('#00FF33')></td><td bgcolor=#330033 onMouseOver=View('#330033')></td><td bgcolor=#333333 onMouseOver=View('#333333')></td><td bgcolor=#336633 onMouseOver=View('#336633')></td><td bgcolor=#339933 onMouseOver=View('#339933')></td><td bgcolor=#33CC33 onMouseOver=View('#33CC33')></td><td bgcolor=#33FF33 onMouseOver=View('#33FF33')></td><td bgcolor=#660033 onMouseOver=View('#660033')></td><td bgcolor=#663333 onMouseOver=View('#663333')></td><td bgcolor=#666633 onMouseOver=View('#666633')></td><td bgcolor=#669933 onMouseOver=View('#669933')></td><td bgcolor=#66CC33 onMouseOver=View('#66CC33')></td><td bgcolor=#66FF33 onMouseOver=View('#66FF33')></td></tr><tr height=10><td bgcolor=gray onMouseOver=View('gray')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#000066 onMouseOver=View('#000066')></td><td bgcolor=#003366 onMouseOver=View('#003366')></td><td bgcolor=#006666 onMouseOver=View('#006666')></td><td bgcolor=#009966 onMouseOver=View('#009966')></td><td bgcolor=#00CC66 onMouseOver=View('#00CC66')></td><td bgcolor=#00FF66 onMouseOver=View('#00FF66')></td><td bgcolor=#330066 onMouseOver=View('#330066')></td><td bgcolor=#333366 onMouseOver=View('#333366')></td><td bgcolor=#336666 onMouseOver=View('#336666')></td><td bgcolor=#339966 onMouseOver=View('#339966')></td><td bgcolor=#33CC66 onMouseOver=View('#33CC66')></td><td bgcolor=#33FF66 onMouseOver=View('#33FF66')></td><td bgcolor=#660066 onMouseOver=View('#660066')></td><td bgcolor=#663366 onMouseOver=View('#663366')></td><td bgcolor=#666666 onMouseOver=View('#666666')></td><td bgcolor=#669966 onMouseOver=View('#669966')></td><td bgcolor=#66CC66 onMouseOver=View('#66CC66')></td><td bgcolor=#66FF66 onMouseOver=View('#66FF66')></td></tr><tr height=10><td bgcolor=#999999 onMouseOver=View('#999999')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#000099 onMouseOver=View('#000099')></td><td bgcolor=#003399 onMouseOver=View('#003399')></td><td bgcolor=#006699 onMouseOver=View('#006699')></td><td bgcolor=#009999 onMouseOver=View('#009999')></td><td bgcolor=#00CC99 onMouseOver=View('#00CC99')></td><td bgcolor=#00FF99 onMouseOver=View('#00FF99')></td><td bgcolor=#330099 onMouseOver=View('#330099')></td><td bgcolor=#333399 onMouseOver=View('#333399')></td><td bgcolor=#336699 onMouseOver=View('#336699')></td><td bgcolor=#339999 onMouseOver=View('#339999')></td><td bgcolor=#33CC99 onMouseOver=View('#33CC99')></td><td bgcolor=#33FF99 onMouseOver=View('#33FF99')></td><td bgcolor=#660099 onMouseOver=View('#660099')></td><td bgcolor=#663399 onMouseOver=View('#663399')></td><td bgcolor=#666699 onMouseOver=View('#666699')></td><td bgcolor=#669999 onMouseOver=View('#669999')></td><td bgcolor=#66CC99 onMouseOver=View('#66CC99')></td><td bgcolor=#66FF99 onMouseOver=View('#66FF99')></td></tr><tr height=10><td bgcolor=#CCCCCC onMouseOver=View('#CCCCCC')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#0000CC onMouseOver=View('#0000CC')></td><td bgcolor=#0033CC onMouseOver=View('#0033CC')></td><td bgcolor=#0066CC onMouseOver=View('#0066CC')></td><td bgcolor=#0099CC onMouseOver=View('#0099CC')></td><td bgcolor=#00CCCC onMouseOver=View('#00CCCC')></td><td bgcolor=#00FFCC onMouseOver=View('#00FFCC')></td><td bgcolor=#3300CC onMouseOver=View('#3300CC')></td><td bgcolor=#3333CC onMouseOver=View('#3333CC')></td><td bgcolor=#3366CC onMouseOver=View('#3366CC')></td><td bgcolor=#3399CC onMouseOver=View('#3399CC')></td><td bgcolor=#33CCCC onMouseOver=View('#33CCCC')></td><td bgcolor=#33FFCC onMouseOver=View('#33FFCC')></td><td bgcolor=#6600CC onMouseOver=View('#6600CC')></td><td bgcolor=#6633CC onMouseOver=View('#6633CC')></td><td bgcolor=#6666CC onMouseOver=View('#6666CC')></td><td bgcolor=#6699CC onMouseOver=View('#6699CC')></td><td bgcolor=#66CCCC onMouseOver=View('#66CCCC')></td><td bgcolor=#66FFCC onMouseOver=View('#66FFCC')></td></tr><tr height=10><td bgcolor=White onMouseOver=View('White')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#0000FF onMouseOver=View('#0000FF')></td><td bgcolor=#0033FF onMouseOver=View('#0033FF')></td><td bgcolor=#0066FF onMouseOver=View('#0066FF')></td><td bgcolor=#0099FF onMouseOver=View('#0099FF')></td><td bgcolor=#00CCFF onMouseOver=View('#00CCFF')></td><td bgcolor=#00FFFF onMouseOver=View('#00FFFF')></td><td bgcolor=#3300FF onMouseOver=View('#3300FF')></td><td bgcolor=#3333FF onMouseOver=View('#3333FF')></td><td bgcolor=#3366FF onMouseOver=View('#3366FF')></td><td bgcolor=#3399FF onMouseOver=View('#3399FF')></td><td bgcolor=#33CCFF onMouseOver=View('#33CCFF')></td><td bgcolor=#33FFFF onMouseOver=View('#33FFFF')></td><td bgcolor=#6600FF onMouseOver=View('#6600FF')></td><td bgcolor=#6633FF onMouseOver=View('#6633FF')></td><td bgcolor=#6666FF onMouseOver=View('#6666FF')></td><td bgcolor=#6699FF onMouseOver=View('#6699FF')></td><td bgcolor=#66CCFF onMouseOver=View('#66CCFF')></td><td bgcolor=#66FFFF onMouseOver=View('#66FFFF')></td></tr><tr height=10><td bgcolor=Red onMouseOver=View('Red')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#990000 onMouseOver=View('#990000')></td><td bgcolor=#993300 onMouseOver=View('#993300')></td><td bgcolor=#996600 onMouseOver=View('#996600')></td><td bgcolor=#999900 onMouseOver=View('#999900')></td><td bgcolor=#99CC00 onMouseOver=View('#99CC00')></td><td bgcolor=#99FF00 onMouseOver=View('#99FF00')></td><td bgcolor=#CC0000 onMouseOver=View('#CC0000')></td><td bgcolor=#CC3300 onMouseOver=View('#CC3300')></td><td bgcolor=#CC6600 onMouseOver=View('#CC6600')></td><td bgcolor=#CC9900 onMouseOver=View('#CC9900')></td><td bgcolor=#CCCC00 onMouseOver=View('#CCCC00')></td><td bgcolor=#CCFF00 onMouseOver=View('#CCFF00')></td><td bgcolor=#FF0000 onMouseOver=View('#FF0000')></td><td bgcolor=#FF3300 onMouseOver=View('#FF3300')></td><td bgcolor=#FF6600 onMouseOver=View('#FF6600')></td><td bgcolor=#FF9900 onMouseOver=View('#FF9900')></td><td bgcolor=#FFCC00 onMouseOver=View('#FFCC00')></td><td bgcolor=#FFFF00 onMouseOver=View('#FFFF00')></td></tr><tr height=10><td bgcolor=#Green onMouseOver=View('Green')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#990033 onMouseOver=View('#990033')></td><td bgcolor=#993333 onMouseOver=View('#993333')></td><td bgcolor=#996633 onMouseOver=View('#996633')></td><td bgcolor=#999933 onMouseOver=View('#999933')></td><td bgcolor=#99CC33 onMouseOver=View('#99CC33')></td><td bgcolor=#99FF33 onMouseOver=View('#99FF33')></td><td bgcolor=#CC0033 onMouseOver=View('#CC0033')></td><td bgcolor=#CC3333 onMouseOver=View('#CC3333')></td><td bgcolor=#CC6633 onMouseOver=View('#CC6633')></td><td bgcolor=#CC9933 onMouseOver=View('#CC9933')></td><td bgcolor=#CCCC33 onMouseOver=View('#CCCC33')></td><td bgcolor=#CCFF33 onMouseOver=View('#CCFF33')></td><td bgcolor=#FF0033 onMouseOver=View('#FF0033')></td><td bgcolor=#FF3333 onMouseOver=View('#FF3333')></td><td bgcolor=#FF6633 onMouseOver=View('#FF6633')></td><td bgcolor=#FF9933 onMouseOver=View('#FF9933')></td><td bgcolor=#FFCC33 onMouseOver=View('#FFCC33')></td><td bgcolor=#FFFF33 onMouseOver=View('#FFFF33')></td></tr><tr height=10><td bgcolor=Blue onMouseOver=View('Blue')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#990066 onMouseOver=View('#990066')></td><td bgcolor=#993366 onMouseOver=View('#993366')></td><td bgcolor=#996666 onMouseOver=View('#996666')></td><td bgcolor=#999966 onMouseOver=View('#999966')></td><td bgcolor=#99CC66 onMouseOver=View('#99CC66')></td><td bgcolor=#99FF66 onMouseOver=View('#99FF66')></td><td bgcolor=#CC0066 onMouseOver=View('#CC0066')></td><td bgcolor=#CC3366 onMouseOver=View('#CC3366')></td><td bgcolor=#CC6666 onMouseOver=View('#CC6666')></td><td bgcolor=#CC9966 onMouseOver=View('#CC9966')></td><td bgcolor=#CCCC66 onMouseOver=View('#CCCC66')></td><td bgcolor=#CCFF66 onMouseOver=View('#CCFF66')></td><td bgcolor=#FF0066 onMouseOver=View('#FF0066')></td><td bgcolor=#FF3366 onMouseOver=View('#FF3366')></td><td bgcolor=#FF6666 onMouseOver=View('#FF6666')></td><td bgcolor=#FF9966 onMouseOver=View('#FF9966')></td><td bgcolor=#FFCC66 onMouseOver=View('#FFCC66')></td><td bgcolor=#FFFF66 onMouseOver=View('#FFFF66')></td></tr><tr height=10><td bgcolor=Yellow onMouseOver=View('Yellow')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td>	<td bgcolor=#990099 onMouseOver=View('#990099')></td><td bgcolor=#993399 onMouseOver=View('#993399')></td><td bgcolor=#996699 onMouseOver=View('#996699')></td><td bgcolor=#999999 onMouseOver=View('#999999')></td><td bgcolor=#99CC99 onMouseOver=View('#99CC99')></td><td bgcolor=#99FF99 onMouseOver=View('#99FF99')></td><td bgcolor=#CC0099 onMouseOver=View('#CC0099')></td><td bgcolor=#CC3399 onMouseOver=View('#CC3399')></td><td bgcolor=#CC6699 onMouseOver=View('#CC6699')></td><td bgcolor=#CC9999 onMouseOver=View('#CC9999')></td><td bgcolor=#CCCC99 onMouseOver=View('#CCCC99')></td><td bgcolor=#CCFF99 onMouseOver=View('#CCFF99')></td><td bgcolor=#FF0099 onMouseOver=View('#FF0099')></td><td bgcolor=#FF3399 onMouseOver=View('#FF3399')></td><td bgcolor=#FF6699 onMouseOver=View('#FF6699')></td><td bgcolor=#FF9999 onMouseOver=View('#FF9999')></td><td bgcolor=#FFCC99 onMouseOver=View('#FFCC99')></td><td bgcolor=#FFFF99 onMouseOver=View('#FFFF99')></td></tr><tr height=10><td bgcolor=Cyan onMouseOver=View('Cyan')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#9900CC onMouseOver=View('#9900CC')></td><td bgcolor=#9933CC onMouseOver=View('#9933CC')></td><td bgcolor=#9966CC onMouseOver=View('#9966CC')></td><td bgcolor=#9999CC onMouseOver=View('#9999CC')></td><td bgcolor=#99CCCC onMouseOver=View('#99CCCC')></td><td bgcolor=#99FFCC onMouseOver=View('#99FFCC')></td><td bgcolor=#CC00CC onMouseOver=View('#CC00CC')></td><td bgcolor=#CC33CC onMouseOver=View('#CC33CC')></td><td bgcolor=#CC66CC onMouseOver=View('#CC66CC')></td><td bgcolor=#CC99CC onMouseOver=View('#CC99CC')></td><td bgcolor=#CCCCCC onMouseOver=View('#CCCCCC')></td><td bgcolor=#CCFFCC onMouseOver=View('#CCFFCC')></td><td bgcolor=#FF00CC onMouseOver=View('#FF00CC')></td><td bgcolor=#FF33CC onMouseOver=View('#FF33CC')></td><td bgcolor=#FF66CC onMouseOver=View('#FF66CC')></td><td bgcolor=#FF99CC onMouseOver=View('#FF99CC')></td><td bgcolor=#FFCCCC onMouseOver=View('#FFCCCC')></td><td bgcolor=#FFFFCC onMouseOver=View('#FFFFCC')></td></tr><tr height=10><td bgcolor=Magenta onMouseOver=View('Magenta')></td><td bgcolor=#000000 onMouseOver=View('#000000')></td><td bgcolor=#9900FF onMouseOver=View('#9900FF')></td><td bgcolor=#9933FF onMouseOver=View('#9933FF')></td><td bgcolor=#9966FF onMouseOver=View('#9966FF')></td><td bgcolor=#9999FF onMouseOver=View('#9999FF')></td><td bgcolor=#99CCFF onMouseOver=View('#99CCFF')></td><td bgcolor=#99FFFF onMouseOver=View('#99FFFF')></td><td bgcolor=#CC00FF onMouseOver=View('#CC00FF')></td><td bgcolor=#CC33FF onMouseOver=View('#CC33FF')></td><td bgcolor=#CC66FF onMouseOver=View('#CC66FF')></td><td bgcolor=#CC99FF onMouseOver=View('#CC99FF')></td><td bgcolor=#CCCCFF onMouseOver=View('#CCCCFF')></td><td bgcolor=#CCFFFF onMouseOver=View('#CCFFFF')></td><td bgcolor=#FF00FF onMouseOver=View('#FF00FF')></td><td bgcolor=#FF33FF onMouseOver=View('#FF33FF')></td><td bgcolor=#FF66FF onMouseOver=View('#FF66FF')></td><td bgcolor=#FF99FF onMouseOver=View('#FF99FF')></td><td bgcolor=#FFCCFF onMouseOver=View('#FFCCFF')></td><td bgcolor=#FFFFFF onMouseOver=View('#FFFFFF')></td></tr><tr height=10><td colspan=20 height=\"20\"><div id=\"ColorPreview$i\" style=\"height: 100%; width: 100%\"></div></td></tr></table>");
}

if (file_exists($user_data['user_skin'].'\templates\admin_affichage.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\admin_affichage.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\admin_affichage.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\admin_affichage.tpl');
}
else
{
    $tpl = new template('admin_affichage.tpl');
}

$tpl->SimpleVar(Array(
		'admin_optiongalaxy' => L_('admin_optiongalaxy'),
		'admin_displaymip' => L_("admin_displaymip").'&nbsp;'.help("admin_helpdisplaymip"),
		'enable_portee_missil' => $enable_portee_missil,
		'admin_displayfriendlyphalanx' => L_("admin_displayfriendlyphalanx").'&nbsp;'.help("admin_helpdisplayfriendlyphalanx"),
		'enable_friendly_phalanx' => $enable_friendly_phalanx,
		'admin_optiongalaxyandclassement' => L_('admin_optiongalaxyandclassement'),
		'admin_countsspecialcolors' => L_('admin_countsspecialcolors'),
		'scolor_count' => $scolor_count,
		'common_Player' => L_('common_Player'),
		'common_Ally' => L_('common_Ally'),
		'admin_helpspecialcolortext' => help("admin_helpspecialcolortext"),
		'admin_optionstats' => L_('admin_optionstats'),
		'admin_optionmembers' => L_("admin_optionmembers")."&nbsp;". help("admin_helpoptionmembers"),
		'enable_stat_view' => $enable_stat_view,
		'admin_displaymbron' => L_("admin_displaymbron").'&nbsp;'.help("admin_helpdisplaymbron"),
		'enable_members_view' => $enable_members_view,
		'admin_countgalaline' => L_('admin_countgalaline'),
		'galaxy_by_line_stat' => $galaxy_by_line_stat,
		'admin_countsysline' => L_('admin_countsysline'),
		'system_by_line_stat' => $system_by_line_stat,
		'admin_optionallypage' => L_('admin_optionallypage'),
		'admin_countscolumns' => L_('admin_countscolumns'),
		'nb_colonnes_ally' => $nb_colonnes_ally,
		'admin_countgalaline' => L_('admin_countgalaline'),
		'galaxy_by_line_ally' => $galaxy_by_line_ally,
		'admin_countsysline' => L_('admin_countsysline'),
		'system_by_line_ally' => $system_by_line_ally,
		'admin_optionconnexion' => L_('admin_optionconnexion'),
		'admin_displayregpannel' => L_("admin_displayregpannel")."&nbsp;".help("admin_helpdisplayregpannel"),
		'enable_register_view' => $enable_register_view,
		'admin_allyname' => L_("admin_allyname")."&nbsp;".help("admin_allynameogspy"),
		'register_alliance' => $register_alliance,
		'admin_boardlinkreg' => L_("admin_boardlinkreg")."&nbsp;".help("admin_helpboardlink"),
		'register_forum' => $register_forum,
		'admin_usermodconnexion' => L_("admin_usermodconnexion")."&nbsp;".help("admin_helpusermodconnexion"),
		'admin_adminmodconnexion' => L_("admin_adminmodconnexion")."&nbsp;".help("admin_helpadminmodconnexion"),
		'adminparam_Validate' => L_("adminparam_Validate"),
		'adminparam_Reset' => L_("adminparam_Reset")
));

for ($i = 0; $i < $nb_colonnes_ally+$scolor_count; $i++){
	$tpl->loopVar('js_loop1',Array('id' => "ColorPreview".$i));
	$tpl->loopVar('js_loop2',Array(
		'index' => $i,
		'id' => ($i<$nb_colonnes_ally)?"color_ally".$i:"scolor_color".($i-$nb_colonnes_ally)
	));
}

for ($i = 0; $i < $scolor_count; $i++){
	$tpl->loopVar('colorspecial',Array(
			'id' => $i,
			'color' => $scolor_color[$i],
			'text' => $scolor_text[$i],
			'title' => L_("admin_colorspecial").($i+1)."&nbsp;".(help("admin_helpcolorally")),
			'J_selected' => (($scolor_type[$i] == "J")?" selected='selected'":""),
			'A_selected' => (($scolor_type[$i] == "A")?" selected='selected'":""),
			'color_picker' => (help("color_picker".($i+$nb_colonnes_ally),"","",true))
			
	));
}

for ($i = 0; $i < $nb_colonnes_ally; $i++){
	$tpl->loopVar('colonnes_ally',Array(
		'id' => $i,
		'color' => $color_ally_e[$i],
		'text' => L_("admin_colorally").($i+1)."&nbsp;".(help("admin_helpcolorally")),
		'color_picker' => (help("color_picker".$i,"","",true))
	));
}

$m_base = Array(
	Array('value'=>"./views/profile.php",'text'=>L_("menu_Profile")),
	Array('value'=>"./views/home.php",'text'=>L_("menu_Home")),
	Array('value'=>"./views/galaxy.php",'text'=>L_("ogame_Galaxy")),
	Array('value'=>"./views/cartography.php",'text'=>L_("menu_AllyTerritory")),
	Array('value'=>"./views/search.php",'text'=>L_("menu_Search")),
	Array('value'=>"./views/ranking.php",'text'=>L_("menu_Ranking")),
	Array('value'=>"./views/statistic.php",'text'=>L_("menu_Statistics")),
);
$nb_option = 1 + count($m_base); 
$nb_option += count($m_user);
$nb_option += count($m_user)>1?1:0;
$nb_option += count($m_admin);
$nb_option += count($m_admin)>1?1:0;
$c_user = current($m_user); 
$c_admin = current($m_admin);
for ($i = 0; $i < $nb_option; $i++){
	if(($i==0)||($i==count($m_base))||($i==count($m_base)+count($m_user)+1&&count($m_user!=0))){
		$value = "";
		$text = "------";
	}elseif($i<count($m_base)){
		$value = $m_base[$i]['value'];
		$text = $m_base[$i]['text'];
	}elseif($i<=count($m_base)+count($m_user)){
		$value = "./mod/".$c_user['root']."/".$c_user['link'];
		$text = $c_user['title'];
		$c_user = next($m_user);
	}else{
		$value = "./mod/".$c_admin['root']."/".$c_admin['link'];
		$text = $c_admin['title'];
		$c_admin = next($m_admin);
	}
	if($i<=count($m_base)+count($m_user))
		$tpl->loopVar('open_user',Array(
			'value' => $value,
			'text' => $text,
			'selected' => ($open_user == $value)?'selected="selected"':''
		));
	$tpl->loopVar('open_admin',Array(
		'value' => $value,
		'text' => $text,
		'selected' => ($open_admin == $value)?'selected="selected"':''
	));
}

	
$tpl->parse();
