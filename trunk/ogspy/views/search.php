<?php
/** $Id$ **/
/**
* Page de recherche
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
lang_load_page('galaxy');

require_once("views/page_header.php");

if (file_exists($user_data['user_skin'].'\templates\search.tpl'))
{
    $tpl_main = new template($user_data['user_skin'].'\templates\search.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\search.tpl'))
{
    $tpl_main = new template($server_config['default_skin'].'\templates\search.tpl');
}
else
{
    $tpl_main = new template('search.tpl');
}

$galaxy_options[] = $system_options[] = $row_options[] = "<option value='0'>&nbsp;</option>";

for($i=1;$i<=$server_config['num_of_systems'];$i++)
	$system_options[] = "<option value='{$i}'>{$i}</option>";
for($i=1;$i<=$server_config['num_of_galaxies'];$i++)
	$galaxy_options[] = "<option value='{$i}'>{$i}</option>";
for($i=1;$i<=15;$i++)
	$row_options[] = "<option value='{$i}'>{$i}</option>";

$tpl_main->SimpleVar(Array(
	'search_Base' => L_('search_Base').'&nbsp;'.help('help_search'),
	'galaxy_options' => implode('',$galaxy_options),
	'system_options' => implode('',$system_options),
	'row_options' => implode('',$row_options),
	'player_input' => ( isset($pub_user_name)?
		$pub_user_name:	((isset($pub_string_search)&&$pub_type_search=='player')?$pub_string_search:'') ),
	'ally_input' => ( isset($pub_ally_name)?
		$pub_ally_name: ((isset($pub_string_search)&&$pub_type_search=='ally')?$pub_string_search:'') ),
	'planet_input' => ( isset($pub_planet_name)?
	$pub_planet_name: ((isset($pub_string_search)&&$pub_type_search=='planet')?$pub_string_search:'') ),
	'general_up_input' => isset($pub_points_up)?$pub_points_up:'',
	'general_down_input' => isset($pub_points_down)?$pub_points_down:'',
	'fleet_up_input' => isset($pub_fleet_up)?$pub_fleet_up:'',
	'fleet_down_input' => isset($pub_fleet_down)?$pub_fleet_down:'',
	'research_up_input' => isset($pub_research_up)?$pub_research_up:'',
	'research_down_input' => isset($pub_research_down)?$pub_research_down:'',
));


// Ancienne variable :
if(isset($pub_type_search)&&isset($pub_string_search)){
	if(!isset($pub_strict))	$pub_string_search = '*'.$pub_string_search.'*';
	Array('free_planet','moon','innactive','with_RE','holiday','phalanx_up','phalanx_down','galaxy_up','galaxy_down','system_up','system_down','row_up','row_down','points_up','points_down','fleet_up','fleet_down','research_up','research_down','do_and','ally_name','user_name','planet_name','rank_type');
	$pub_search = true;
	$pub_free_planet=2;$pub_moon=2;$pub_innactive=2;$pub_with_RE=2;$pub_holiday=2;$pub_phalanx_up=0;
	$pub_phalanx_down=0;$pub_galaxy_up=0;$pub_galaxy_down=0;$pub_system_up=0;$pub_system_down=0;
	$pub_row_up=0;$pub_row_down=0;$pub_points_up=0;$pub_points_down=0;$pub_fleet_up=0;
	$pub_fleet_down=0;$pub_research_up=0;$pub_research_down=0;$pub_do_and=1;$pub_rank_type='J';
	$pub_ajax=1;$pub_order='coords';
	$pub_ally_name = $pub_user_name = $pub_planet_name = '';
	$pub_order_o = isset($pub_order_o)?$pub_order_o:'asc';
	$pub_start = isset($pub_start)?$pub_start:0;
	$pub_length = isset($pub_length)?$pub_length:25;
	switch($pub_type_search){
		case 'planet': $pub_planet_name = $pub_string_search; break;
		case 'player': $pub_user_name = $pub_string_search; break;
		case 'ally': $pub_ally_name = $pub_string_search; break;
	}
}

// Recherche
if(isset($pub_search)){
	
	// Controle de la présence de toutes les variables
	/*$var_list = Array('free_planet','moon','innactive','with_RE','holiday','phalanx_up','phalanx_down','galaxy_up','galaxy_down','system_up','system_down','row_up','row_down','points_up','points_down','fleet_up','fleet_down','research_up','research_down','do_and','ally_name','user_name','planet_name','rank_type');
	foreach($var_list as $v)
		if(!isset(${'pub_'.$v})) redirection("?action=message&amp;id_message=errordata&info");*/
	/* initialisation with default values of variables not in GET */
	$var_list = array('user_name','ally_name','planet_name','points_up','points_down','fleet_up','fleet_down','research_up','research_down');
	foreach($var_list as $v)
		if(!isset(${'pub_'.$v}))
			{
				${'pub_'.$v} = "";
			}
	$var_list = array('free_planet','moon','innactive','with_RE','holiday');
	foreach($var_list as $v)
		if(!isset(${'pub_'.$v}))
			{
				${'pub_'.$v} = 2;
			}
	$var_list = array('phalanx_up','phalanx_down','galaxy_up','galaxy_down','system_up','system_down','row_up','row_down','start');
	foreach($var_list as $v)
		if(!isset(${'pub_'.$v}))
			{
				${'pub_'.$v} = 0;
			}
	if (!isset($pub_do_and))  $pub_do_and = 1;
	if (!isset($pub_rank_type))  $pub_rank_type = 'J';
	if (!isset($pub_order))  $pub_order = 'coords';
	if (!isset($pub_order_o))  $pub_order_o = 'asc';
	if (!isset($pub_length))  $pub_length = 25;
	
	// Valeur a sortir de la recherche
	$values = Array('u.galaxy','u.system','u.row','u.name','u.moon','u.phalanx','u.status','ta.name_ally','tp.name_player','u.last_update','u.last_update_user_id');
	
	// Tables concernées
	$tables = Array( TABLE_UNIVERSE.' u', TABLE_PLAYER.' tp', TABLE_ALLY.' ta');
	
	// Condition
	$wheres= Array('1');
	
	// Formattage du tri et des limit
	if($pub_order=='coords') $pub_order = 'u.galaxy,u.system,u.row';
	if($pub_order=='u.galaxy,u.system,u.row'){
		$order='u.galaxy '.$pub_order_o.',u.system '.$pub_order_o.',u.row '.$pub_order_o;
	}else
		$order = $pub_order.' '.$pub_order_o;
	$limit = $pub_start.','.($pub_length==0?$pub_length=1:$pub_length);

	// On retourne la requete comlpete, sans les ordre et les limit
	$req = $_SERVER['QUERY_STRING'];
	$req = preg_replace('/&order=.*&length=[0-9]+/','',$req);
	
	// Formatage des conditions sur les classements
	$ranks = Array('points','fleet','research');
	foreach($ranks as $r){
		if(${'pub_'.$r.'_up'}!="" || ${'pub_'.$r.'_down'}!=""){
			${'rank_'.$r} = get_ranking_match(${'pub_'.$r.'_up'},${'pub_'.$r.'_down'},$r,$pub_rank_type);
			if(${'rank_'.$r} != '') $wheres[] = ${'rank_'.$r};
		}
	}
	
	// Condition sur le nom du joueur, le nom de l'ally, ou le nom de la planete
	$and_or = ($pub_do_and=='1')?' AND ':' OR '; // ET ou OR pour les nom ?
	$w = $rank_value = Array();
	$string_var = Array('user_name'=>'tp.name_player','ally_name' =>'ta.name_ally','planet_name'=>'u.name');
	foreach($string_var as $i => $v){
		$varname = ${'pub_'.$i};
		if($varname!=""){
			unset($strings);
			if(strpos($varname,','))
				$strings = explode(',',$varname);
			else
				$strings[] = $varname;
			foreach($strings as $var){
				$var = trim($var);
				if(strpos($var,'*')!== false){
					$var = str_replace('*','%',$var);
					$w[] = $v." LIKE '".mysql_real_escape_string($var)."'";
				} else 
					$w[] = $v." = '".mysql_real_escape_string($var)."'";
				if($v=='tp.name_player') $rank_value['player']=true;
				if($v=='ta.name_ally') $rank_value['ally']=true;
			}
		}
	}
	if(!empty($w)) {
		$wheres[] = '('.implode($and_or,$w).')';
		$rank_where = implode($and_or,$w);
	}

	// On demande un classement ?!
	if(isset($rank_where)){
        if (file_exists($user_data['user_skin'].'\templates\search_rank.tpl'))
        {
            $tpl = new template($user_data['user_skin'].'\templates\search_rank.tpl');
        }
        elseif (file_exists($server_config['default_skin'].'\templates\search_rank.tpl'))
        {
            $tpl = new template($server_config['default_skin'].'\templates\search_rank.tpl');
        }
        else
        {
            $tpl = new template('search_rank.tpl');
        }
		if(isset($rank_value['player'])){
			$db->sql_query('SELECT DISTINCT tp.name_player FROM '.TABLE_UNIVERSE.' u , '.TABLE_PLAYER.' tp  WHERE u.id_player = tp.id_player and '.$rank_where);
			while(list($result) = $db->sql_fetch_row()) { $players[]=$result; }
		}
		if(isset($rank_value['ally'])){
			$db->sql_query('SELECT DISTINCT ta.name_ally FROM '.TABLE_UNIVERSE.' u, '.TABLE_ALLY.' ta, '.TABLE_PLAYER.' tp WHERE u.id_player = tp.id_player and tp.id_ally = ta.id_ally and '.$rank_where);
			while(list($result) = $db->sql_fetch_row()) { $allies[]=$result; }
		}
		$i = -1;
		if(isset($players))
		foreach($players as $n){
			$tpl->CheckIf('show_rank',true);
			$tpl->loopVar('rank',Array(
				'id' => ++$i,
				'title' => L_('search_StatsFor','<b>'.$n.'</b>'),
				'ally' => false,
			));
			unset($r);
			$r = galaxy_show_ranking_unique_player($n);
			if(empty($r)) $r[0] = "";
			foreach($r as $d => $v){
				$ranking['rank_'.$i][] = Array(
						'date' => ($d!=0)?date(L_('common_Date'),$d):'-',
						'general_points' =>  (isset($v['general'])  && isset($v['general']['points']))?$v['general']['points']:'',
						'general_rank' =>    (isset($v['general'])  && isset($v['general']['rank']))?$v['general']['rank']:'',
						'fleet_points' =>    (isset($v['fleet'])    && isset($v['fleet']['points']))?$v['fleet']['points']:'',
						'fleet_rank' =>      (isset($v['fleet'])    && isset($v['fleet']['rank']))?$v['fleet']['rank']:'',
						'research_points' => (isset($v['research']) && isset($v['research']['points']))?$v['research']['points']:'',
						'research_rank' =>   (isset($v['research']) && isset($v['research']['rank']))?$v['research']['rank']:'',
				);
			}
		}
		if(isset($allies))
		foreach($allies as $n){
			$tpl->CheckIf('show_rank',true);
			$tpl->loopVar('rank',Array(
				'id' => ++$i,
				'title' => L_('search_StatsFor','<b>'.$n.'</b>'),
				'ally' => true,
			));
			unset($r);
			$r = galaxy_show_ranking_unique_ally($n);
			if(empty($r)) $r[0] = "";
			foreach($r as $d => $v){
				$ranking['rank_'.$i][] = Array(
						'date' => ($d!=0)?date(L_('common_Date'),$d):'-',
						'general_points' =>  (isset($v['general'])  && isset($v['general']['points']))?$v['general']['points']:'',
						'general_rank' =>    (isset($v['general'])  && isset($v['general']['rank']))?$v['general']['rank']:'',
						'fleet_points' =>    (isset($v['fleet'])    && isset($v['fleet']['points']))?$v['fleet']['points']:'',
						'fleet_rank' =>      (isset($v['fleet'])    && isset($v['fleet']['rank']))?$v['fleet']['rank']:'',
						'research_points' => (isset($v['research']) && isset($v['research']['points']))?$v['research']['points']:'',
						'research_rank' =>   (isset($v['research']) && isset($v['research']['rank']))?$v['research']['rank']:'',
						'number_member' =>   isset($v['number_member']) ?$v['number_member']:''
				);
			}
		}
		if(isset($ranking))
			foreach($ranking as $i => $v)
				foreach($v as $w)
					$tpl->loopVar($i,$w);
		$tpl->simpleVar(Array(
			'search_date' => L_('search_date'),
			'search_GeneralPoints' => L_('search_GeneralPoints'),
			'search_FlottePoints' => L_('search_FlottePoints'),
			'search_ResearchPoints' => L_('search_ResearchPoints'),
			'search_MemberCount' => L_('search_MemberCount'),
			'search_NoResult' => L_('search_NoResult'),
		));
		$ranking_template = $tpl->parse('return');
	}// Fin Affichage classement

	// Condition sur la position
	$where_position = Array('galaxy_up' => "u.galaxy<=",'system_up' => "u.system<=",'row_up' => "u.row<=",'phalanx_up'=>"u.phalanx<=",
		'galaxy_down' => "u.galaxy>=",'system_down' => "u.system>=",'row_down' => "u.row>=",'phalanx_down'=>"u.phalanx>=");
	foreach($where_position as $v => $s)
		if(${'pub_'.$v}!=0) $wheres[] = $s.mysql_real_escape_string(${'pub_'.$v});

	// Planete libre ?
	if($pub_free_planet=='1'){
		$wheres[] = "u.name=''";
	}elseif($pub_free_planet=='0'){
		$wheres[] = "u.name!=''";
	}
	
	// Lune ?
	if($pub_moon=='1'){
		$wheres[] = "u.moon='1'";
	}elseif($pub_moon=='0'){
		$wheres[] = "u.moon='0'";
	}
	
	// Joueur inactif ?
	if($pub_innactive=='1'){
		$wheres[] = "u.status LIKE '%i%'";
	}elseif($pub_innactive=='0'){
		$wheres[] = "u.status NOT LIKE '%i%'";
	}
	
	// Joueur en vacance ?
	if($pub_holiday=='1'){
		$wheres[] = "u.status LIKE '%v%'";
	}elseif($pub_holiday=='0'){
		$wheres[] = "u.status NOT LIKE '%v%'";
	}
	
	// Position avec RE ?
	if($pub_with_RE=='1'){
		$wheres[] = "(u.galaxy=s.galaxy AND u.system=s.system AND u.row=s.row)";
		$tables[] = TABLE_PARSEDSPY.' s';
		$values[] = 's.id_spy';
	}
	
	// Récupération des noms d'alliances protégées
	$ally_protection = array();
	if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);
	
	$wheres[] = 'u.id_player = tp.id_player';
	$wheres[] = 'tp.id_ally = ta.id_ally';
	// Requete SQL (2 requetes, 1 pour avoir le nombre total de réponse, une autre avec les limites correspondant à la page a afficher)
	$request = 'SELECT '.implode(',',$values).
				' FROM '.implode(',',$tables).
				' WHERE '.implode(' AND ',$wheres).
				' ORDER by '.$order;
	$db->sql_query($request);
	$count = $db->sql_numrows();
	$request = $request.' LIMIT '.$limit;
	$db->sql_query($request);
	while($out = $db->sql_fetch_assoc()){
		if(!in_array($out['name_ally'],$ally_protection)||$user_auth['server_show_positionhided']==1)
			$is_result[] = Array(
				'coords' => $out['galaxy'].':'.$out['system'].':'.$out['row'],
				'galaxy' => $out['galaxy'],
				'system' => $out['system'],
				'row' => $out['row'],
				'name' => $out['name'],
				'ally' => $out['name_ally'],
				'ally_tip' => '',
				'user' => $out['name_player'],
				'user_tip' => '',
				'moon' => $out['moon']=='1'?(L_('search_Moons_abbrev').($out['phalanx']>0?(' - '.$out['phalanx']):'')):'',
				'status' => $out['status'],
				'date' =>  strftime("%d %b %Y %H:%M", $out['last_update']),
				'user_id' => $out['last_update_user_id']
			);
	}

	$tpl = new Template('search_result.tpl');
	
	// Inscription des Résultat
	if(isset($is_result)){
		$tpl->CheckIf('is_result',true);
		foreach($is_result as $r){
			$r['date'] = $r['date'].' - '.get_user_name($r['user_id']);

			$r['user'] = get_formated_string('player',$r['user']);
			$r['ally'] = get_formated_string('ally',$r['ally']);
			$r['name'] = get_formated_string('planet',$r['name']);
			$r['RE'] = (($a=is_RE_here($r['coords']))>0?get_formated_string('spy',Array('text' => $a.L_('search_SpyReport_abbrev'),
						'galaxy' => $r['galaxy'], 'system' => $r['system'], 'row' => $r['row'])):'');
			$r['RC'] = (($a=is_RC_here($r['coords']))>0?get_formated_string('combat',Array('text' => $a.L_('search_battlesreport_abbrev'),
						'galaxy' => $r['galaxy'], 'system' => $r['system'], 'row' => $r['row'])):'');
			$r['coords'] = get_formated_string('coordinates',$r['coords']);
			$tpl->loopVar('list',$r);
		}
	}
	
	// Inscription des variables simples
	$nb_page = ceil($count / intval($pub_length));
	$actual_page = $pub_start /  intval($pub_length);
	$page_options = Array();
	for($i=0;$i<$nb_page;$i++)
		$page_options[] ="<option value='{$i}'".($actual_page==$i?' selected="selected"':'').">".L_('search_PageOutOf',$i+1,$nb_page)."</option>";
	$tpl->simpleVar(Array(
		'search_ResultByPage' => L_('search_ResultByPage'),
		'search_NbResult' => L_('search_NbResult'),
		'search_Coordinates' => L_('search_Coordinates')
			.(($pub_order=='u.galaxy,u.system,u.row')?($pub_order_o=='asc'?"&#9650;":"&#9660;"):''),
		'common_Planet' => L_('common_Planet')
			.(($pub_order=='name')?($pub_order_o=='asc'?"&#9650;":"&#9660;"):''),
		'common_Allys' => L_('common_Allys')
			.(($pub_order=='ally')?($pub_order_o=='asc'?"&#9650;":"&#9660;"):''),
		'common_Players' => L_('common_Players')
			.(($pub_order=='player')?($pub_order_o=='asc'?"&#9650;":"&#9660;"):''),
		'last_update' => (($pub_order=='last_update')?($pub_order_o=='asc'?"&#9650;":"&#9660;"):''),
		'common_Moon' => L_('common_Moon'),
		'search_NoResult' => L_('search_NoResult'),
		'count' => $count,
		'page_options' => implode('',$page_options),
		'request' => htmlentities($req),
		'order' => $pub_order=='u.galaxy,u.system,u.row'?'coords':$pub_order,
		'order_o' => $pub_order_o,
		'start' => $pub_start,
		'length' => $pub_length,
		'search_date' => L_('search_date'),
		'search_GeneralPoints' => L_('search_GeneralPoints'),
		'search_FlottePoints' => L_('search_FlottePoints'),
		'search_ResearchPoints' => L_('search_ResearchPoints'),
		'search_MemberCount' => L_('search_MemberCount'),
	));

	// Message de retour
	$ajax_info = L_('search_NbResult').' : '.$count;
	
	$content = $tpl->parse('return').(isset($ranking_template) ? $ranking_template : "");	
	
	
	
/********************************************************************************/	
}

$tpl_main->SimpleVar(Array(
	'info' => isset($ajax_info)?$ajax_info:'',
	'content' => isset($content)?$content:'',
	'init_display' => isset($content)?'none':'block',
	'init_picture' => isset($content)?'arrow_down':'arrow_top',
));
$tpl_main->parse();
require_once("views/page_tail.php");

/**
 * renvoi le nom d'un utilisateur en fonction de son ID
 */
function get_user_name($uid){
		global $db;
		$db->sql_query('SELECT user_name FROM '.TABLE_USER.' where user_id='.$uid.' LIMIT 1');
		list($return) = $db->sql_fetch_row();
	return ($return=='')?'????':$return;
}

/**
 * Renvoi la liste des joueurs et alliance qui correspondent au Rank donnée
 */
function get_ranking_match($up,$down,$data,$type){
	global $db;
	$J_or_A = $type=='J'?'name_player':'name_ally';
	switch($data){
		case 'points': $table = $type=='J'?TABLE_RANK_PLAYER_POINTS." trpp, ".TABLE_PLAYER." tp ":TABLE_RANK_ALLY_POINTS." trpp, ".TABLE_ALLY." ta ";break;
		case 'fleet': $table = $type=='J'?TABLE_RANK_PLAYER_FLEET." trpp, ".TABLE_PLAYER." tp ":TABLE_RANK_ALLY_FLEET." trpp, ".TABLE_ALLY." ta ";break;
		case 'research': $table = $type=='J'?TABLE_RANK_PLAYER_RESEARCH." trpp, ".TABLE_PLAYER." tp ":TABLE_RANK_ALLY_RESEARCH." trpp, ".TABLE_ALLY." ta ";break;
	}
		$down = intval($down);
	$up=intval($up);
	if($up<1) $up = 1; 
	if($down<1) $down = 999999;
	$rank_matched = $found = Array();
	$db->sql_query($q="SELECT ".($type=='J' ? " tp.name_player " : " ta.name_ally ").", rank FROM ".$table." WHERE ".($type=='J' ? " trpp.id_player = tp.id_player "  : " trpp.id_ally = ta.id_ally ")." and trpp.rank BETWEEN ".$up." AND ".$down." ORDER by datadate DESC");
	while(list($name,$rank) = $db->sql_fetch_row()){
		if(!in_array($rank,$rank_matched)){
			$found[] = $name;
			$rank_matched[] = $rank;
		}
	}
	return empty($found)?'':($J_or_A." IN ('".implode("','",$found)."')");
}
/**
  * Controle la présence d'un RE/RC en fonction des coords données et renvoi le nombre d'enregistrement trouvé
  */
function checkREorRC_exists($t,$coords){
	global $db;
	if($t!='RE'&&$t!='RC') return false;
	list($g,$s,$r) = explode(":",$coords); 
	$g = intval($g); $s = intval($s); $r = intval($r);
	$db->sql_query("SELECT ".($t=='RE'?'id_spy':'id_rc')." FROM ".($t=='RE'?TABLE_PARSEDSPY:TABLE_PARSEDRC)." WHERE galaxy=".$g." AND system=".$s." AND row=".$r);
	return $db->sql_numrows();
}
function is_RE_here($coords){ return checkREorRC_exists('RE',$coords); }
function is_RC_here($coords){ return checkREorRC_exists('RC',$coords); }
?>
