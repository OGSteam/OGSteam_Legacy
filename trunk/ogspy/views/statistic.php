<?php
/** $Id$ **/
/**
* Page Statisitique
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007-2010, http://www.ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
$pub_subaction = isset($pub_subaction)?$pub_subaction:'members';
switch($pub_subaction){
	case 'universe':
	
	$galaxy_step=$server_config['galaxy_by_line_stat'];
	$galaxy_down=1;
	$galaxy=1;
	$step = $server_config['system_by_line_stat'];
	$page_id = 0;

	$enable_stat_view = $server_config['enable_stat_view'];
	$enable_members_view = $server_config['enable_members_view'];

	$user_statistic = user_statistic();

	$galaxy_statistic = galaxy_statistic($step);
	$galaxy_statistic = $galaxy_statistic["map"];

	if (file_exists($user_data['user_skin'].'\templates\statistic_universe.tpl'))
    {
        $tpl = new template($user_data['user_skin'].'\templates\statistic_universe.tpl');
    }
    elseif (file_exists($server_config['default_skin'].'\templates\statistic_universe.tpl'))
    {
        $tpl = new template($server_config['default_skin'].'\templates\statistic_universe.tpl');
    }
    else
    {
        $tpl = new template('statistic_universe.tpl');
    }
	do{
		
		$galaxy_up = $galaxy_down + $galaxy_step;
		$a_page[] = Array('id' => ++$page_id);
		

		// Entete du tableau (nom des galaxies)
		if ($galaxy > intval($server_config['num_of_galaxies']))
		{
			$galaxy_up = intval($server_config['num_of_galaxies']);
		}
		for ($i=$galaxy_down ; $i<$galaxy_up ; $i++)
		{
			$tmp[] = $tpl->GetDefined('1st_row.cell', 
				Array('name' => ($i<=intval($server_config['num_of_galaxies']))?"G$i":"&nbsp;"));
		}
		$table_content[] = $tpl->GetDefined('1st_row',
			Array('cell'=>implode('',$tmp)));
		
		// Lignes
		$line_id = 0;
		for ($system=1; $system<=intval($server_config['num_of_systems']); $system=$system+$step){
			$up = $system+$step-1;
			if ($up > intval($server_config['num_of_systems']))
				$up = intval($server_config['num_of_systems']);
			
			for ($galaxy=$galaxy_down ; $galaxy<$galaxy_up ; $galaxy++) {
				$link_colonized = "";
				$colonized = "";
				$link_free = "";
				$free = "";
				if ($galaxy<=intval($server_config['num_of_galaxies'])) {
					$colonized = "-";
					$free = "-";
					if ($galaxy_statistic[$galaxy][$system]["planet"] > 0) {
						$link_colonized = "onclick=\"window.location = '";
						$link_colonized .= "?action=galaxy_sector&amp;";
						$link_colonized .= "galaxy=".$galaxy."&amp;";
						$link_colonized .= "system_down=".$system."&amp;system_up=".$up;
						$link_colonized .= "';\"";
						if ($galaxy_statistic[$galaxy][$system]["new"])
							$colonized = "<a style='cursor:pointer;color:lime;text-decoration:blink;'>"
								.$galaxy_statistic[$galaxy][$system]["planet"]
								."</a>";
						else
							$colonized = "<a style='cursor:pointer;color:lime;'>".$galaxy_statistic[$galaxy][$system]["planet"]."</a>";
					}
					if ($galaxy_statistic[$galaxy][$system]["free"] > 0) {
						$link_free = "onclick=\"window.location = '";
						$link_free .= "?action=search&amp;search&amp;free_planet=1&amp;";
						$link_free .= "galaxy_down=".$galaxy."&amp;galaxy_up=".$galaxy."&amp;";
						$link_free .= "system_down=".$system."&amp;system_up=".$up;
						//$link_free .= "&amp;row_down&amp;row_up";
						$link_free .= "';\"";
						$free = "<a style='cursor:pointer;color:#FF6600;'>"
							.$galaxy_statistic[$galaxy][$system]["free"]."</a>";
					}
				}
				$cells[] = $tpl->GetDefined('row.cell',Array(
									'link_colonized' => $link_colonized,
									'link_free' => $link_free,
									'colonized' => $colonized,
									'free' => $free));
			}
			$table_content[] = $tpl->GetDefined('row',
				Array('interval'=>$system."&nbsp;-&nbsp;".$up,'cell'=>implode('',$cells)));
			$cells = Array();		
		}
		$galaxy_down = $galaxy_up;
	}while($galaxy_up<intval($server_config['num_of_galaxies']));

	$legend = '';
	$legend = htmlentities(htmlspecialchars($legend));

	$tpl->SimpleVar(Array(
		'1st_row' => implode("\n",$table_content),
		'tip_legend' => TipFormat($tpl->GetDefined('legend')),
		'colspan_head' => $galaxy_step*2+2,
		'stats_cartoState' => L_('stats_cartoState'),
		'stats_Legend' => L_('stats_Legend'),
		'stats_KnownPlanets' => L_('stats_KnownPlanets'),
		'stats_FreePlanets' => L_('stats_FreePlanets'),
		'stats_UpdatedRecentlyPlanets' => L_('stats_UpdatedRecentlyPlanets'),
		'legend_tooltip' => $legend
	));
	$content = $tpl->parse('return');
	break;
	
	
	case 'ranking':
	$tpl = new Template('statistic_ranking.tpl');
	$content = $tpl->parse('return');
	break;
	
	
	case 'members':
	default:
	$tpl = new Template('statistic_members.tpl');
	$tpl->SimpleVar(Array(
		'stats_reset' => L_('stats_reset'),
		'stats_Nicknames' => L_('stats_Nicknames'),
		'stats_Planets' => L_('stats_Planets'),
		'stats_SpyReports' => L_('stats_SpyReports'),
		'stats_RankingLines' => L_('stats_RankingLines'),
		'stats_ResearchMade' => L_('stats_ResearchMade'),
		'stats_Ratio' => L_('stats_Ratio'),
		'stats_LoadedFromBrowser' => L_('stats_LoadedFromBrowser'),
		'stats_LoadedFromPlugin' => L_('stats_LoadedFromPlugin'),
		'stats_web' => L_('stats_web'),
		'stats_plugin' => L_('stats_plugin'),
		'stats_ConnectedLegend' => L_('stats_ConnectedLegend')
	));

	//Statistiques participation des membres actifs
	$request = "select sum(planet_added_web + planet_added_ogs), ";
	$request .= "sum(spy_added_web + spy_added_ogs), ";
	$request .= "sum(rank_added_web + rank_added_ogs), ";
	$request .= "sum(search) ";
	$request .= "from ".TABLE_USER;
	$result = $db->sql_query($request);
	list($planetimport, $spyimport, $rankimport, $search) = $db->sql_fetch_row($result);

	if ($planetimport == 0) $planetimport = 1;
	if ($spyimport == 0) $spyimport = 1;
	if ($rankimport == 0) $rankimport = 1;
	if ($search == 0) $search = 1;
	$show_online = ($server_config['enable_members_view'] 
			|| $user_data["user_admin"] 
			|| $user_data["user_coadmin"]);
	$user_statistic = user_statistic();
	foreach ($user_statistic as $v) {
		list($result,$color) = get_ratio($v,$planetimport,$spyimport,$rankimport,$search);
		if ($server_config['enable_stat_view']
				|| ($v["user_name"] == $user_data["user_name"])
				|| $user_data["user_admin"] || $user_data["user_coadmin"]){
			$tpl->loopVar('stats',Array(
				'color' => $color,
				'user_name' => $v['user_name'],
				'here' => $show_online?$v["here"]:"",
				'planet_added_web' => formate_number($v["planet_added_web"]),
				'planet_added_ogs' => formate_number($v["planet_added_ogs"]),
				'spy_added_web' => formate_number($v["spy_added_web"]),
				'spy_added_ogs' => formate_number($v["spy_added_ogs"]),
				'rank_added_web' => formate_number($v["rank_added_web"]),
				'rank_added_ogs' => formate_number($v["rank_added_ogs"]),
				'search' => formate_number($v["search"]),
				'result' => formate_number($result),
			));
		}
	}
	$tpl->CheckIf('is_admin',($user_data["user_admin"] == 1 
			|| $user_data["user_coadmin"] == 1 
			|| $user_data["management_user"] == 1));
	$tpl->CheckIf('big_table',(sizeof($user_statistic) > 10));
	$tpl->CheckIf('enable_members_view',$show_online);
	$content = $tpl->parse('return');
	break;
}
//if(isset($pub_ajax)) include('views/statistic_'.$pub_subaction.'.php');

// Header & Menu
require_once("views/page_header.php");
// Appel de la page tout court (menu)
if (file_exists($user_data['user_skin'].'\templates\statistic.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\statistic.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\statistic.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\statistic.tpl');
}
else
{
    $tpl = new template('statistic.tpl');
}
// Activate the right menu
switch($pub_subaction){
	case 'universe':
		$tpl->checkIf('menu_univers',true);
		break;
	case 'ranking':
		$tpl->checkIf('menu_ranking',true);
		break;
	case 'members':
	default:
		$tpl->checkIf('menu_members',true);
		break;
	}

$tpl->SimpleVar(Array(
	'universe' => L_('stats_universe'),
	'ranking' => L_('stats_ranking'),
	'members' => L_('stats_members'),
	'content' => isset($content)?$content:'ERROR',
));

$tpl->parse();
require_once("views/page_tail.php");
?>
