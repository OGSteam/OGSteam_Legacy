<?php
/** $Id$ **/
/**
* Administration: affichage des journaux 
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
if (file_exists($user_data['user_skin'].'\templates\admin_viewer.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\admin_viewer.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\admin_viewer.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\admin_viewer.tpl');
}
else
{
    $tpl = new template('admin_viewer.tpl');
}

$days = $months = Array();
$list_month = $list_day = "";

$logs = get_logs();

$pub_showlog = intval(isset($pub_showlog)?$pub_showlog:($logs!==false?$logs[sizeOf($logs)-1]['date']:time()));

if($logs!==false)
foreach($logs as $l){
	$tpl->CheckIf('is_logs',true);
	$month_key = date('ym',$l['date']);
	$f = L_('adminviewer_MonthFormat');
	if($f=='adminviewer_MonthFormat') $f ='M y';
	$month_value = date($f,$l['date']);
	$day_key = $l['date'];
	$f = L_('adminviewer_Dayformat');
	if($f=='adminviewer_Dayformat') $f = 'j  M Y';
	$day_value = date($f,$l['date']);
	if(!in_array($month_value,$months))
		$months[$month_key] = $month_value;
	if(!isset($days[$month_key])||!in_array($day_value,$days[$month_key]))
		$days[$month_key][$day_key] = $day_value;
}

foreach($months as $i => $m){
	if($i==date('ym',$pub_showlog)) $sel = ' selected="selected"'; else $sel = '';
	$list_month .="<option value='{$i}' style='text-align:center;'{$sel}>{$m}</option>";
}

foreach($days as $i => $d){
	$tpl->loopVar('day_array',Array('id'=>$i,'content'=>implode('","',$d),'key'=>implode('","',array_keys($d))));
}


$tpl->SimpleVar(Array(
	'adminviewer_DateSelection' => L_('adminviewer_DateSelection'),
	'adminviewer_SelectMonth' => L_('adminviewer_SelectedMonth'),
	'adminviewer_SelectDay' => L_('adminviewer_SelectedDay'),
	'month_selectlist' => $list_month,
	'day_selectlist' => $list_day,
	'month_value' => implode('","',$months),
	'month_key' => implode('","',array_keys($months)),
	'adminviewer_dellog' => L_('adminviewer_dellog'),
	'no_logs_infos' => L_('adminviewer_NoDataAtAll'),
));


$file = get_log_path($pub_showlog);

if (!$file) $log = array(L_("adminviewer_NoData"));
else{
	if(isset($pub_type)&&isset($file[$pub_type])){
		$log = file($file[$pub_type][0]);
		if(isset($file[$pub_type][1])) array_merge(file($file[$pub_type][1]),$log);
	}
	elseif(isset($file['log'])){
		$log = file($file[$pub_type='log'][0]);
		if(isset($file[$pub_type][1])) array_merge(file($file[$pub_type][1]),$log);
	}elseif(isset($file['sql'])){
		$log = file($file[$pub_type='sql'][0]);
		if(isset($file[$pub_type][1])) array_merge($log.=file($file[$pub_type][1]),$log);
	}elseif(!isset($file['log'])&&!isset($file['sql']))
		$log = array(L_("adminviewer_NoData"));
}

if(isset($pub_ajax)){
	end($log);
	while ($l = current($log)) {
		if(preg_match('`/\*(.*)\*/(.*)`',$l,$m))
			$log_lines[] = Array('date'=>$m[1],'line'=>$m[2]);
		else
			$log_lines[] = Array('date'=>'-','line'=>$l);
		prev($log);
	}
	die(json_encode(Array('selected_date'=>date(L_('adminviewer_Dateformat'),$pub_showlog),'table'=>$log_lines)));
}

$link_log = "<a href=\"?action=administration&amp;subaction=viewer&amp;type=log\">";
$link_sql = "<a href=\"?action=administration&amp;subaction=viewer&amp;type=sql\">";
$style_on = "cursor:pointer; color:lime;";
$style_off = "font-style:italic;";
$tpl->SimpleVar(Array(
	'pub_showlog' => $pub_showlog,
	'pub_type' => $pub_type,
	'type_log_style' => isset($file['log'])&&$pub_type!='log'?$style_on:$style_off,
	'type_log_onclick' => isset($file['log'])&&$pub_type!='log'?"{$link_log}":"",
	'type_log_end' => isset($file['log'])&&$pub_type!='log'?"</a>":"",
	'type_sql_style' => isset($file['sql'])&&$pub_type!='sql'?$style_on:$style_off,
	'type_sql_onclick' => isset($file['sql'])&&$pub_type!='sql'?"{$link_sql}":"",
	'type_sql_end' => isset($file['sql'])&&$pub_type!='sql'?"</a>":"",
	'type_selected' => isset($pub_type)?(($pub_type=='log')?L_('adminviewer_GeneralLog'):L_('adminviewer_SQLLog')):'',
	'save_return' => isset($save_return)?$save_return:'-'
));


$tpl->parse();
?>