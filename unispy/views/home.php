<?php
/***************************************************************************
*	filename	: home.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 17/12/2005
*	modified	: 21/11/2006 19:02:00 par Naqdazar
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
?>

<table width="100%">
<tr>
	<td>
		<table>
		<tr align="center">
<?php
if (!isset($pub_subaction)) $pub_subaction = "empire";

if ($pub_subaction != "empire") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=home&subaction=empire';\">";
	echo "<a style='cursor:pointer'><font color='lime'>".$LANG["univers_Empire"]."</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>".$LANG["univers_Empire"]."</a>";
	echo "</th>";
}

if ($pub_subaction != "simulation") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=home&subaction=simulation';\">";
	echo "<a style='cursor:pointer'><font color='lime'>".$LANG["home_Simulation"]."</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>".$LANG["home_Simulation"]."</a>";
	echo "</th>";
}

if ($pub_subaction != "spy") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=home&subaction=spy';\">";
	echo "<a style='cursor:pointer'><font color='lime'>".$LANG["univers_SpyReports"]."</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>".$LANG["univers_SpyReports"]."</a>";
	echo "</th>";
}

if ($pub_subaction != "stat") {
	echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=home&subaction=stat';\">";
	echo "<a style='cursor:pointer'><font color='lime'>".$LANG["basic_Statistics"]."</font></a>";
	echo "</td>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>".$LANG["basic_Statistics"]."</a>";
	echo "</th>";
}


//<!-- Emplacement mod / position espace perso /-->

   $request = "select action, menu, tooltip, dateinstall, noticeifnew from ".TABLE_MOD." where active = 1 and menupos=6";
   $result = $db->sql_query($request);
   if ($db->sql_numrows($result)) {


	   while ($val = $db->sql_fetch_assoc($result)) {
        	if ($pub_subaction != $val['action']) {
                $menuitem = "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=home&subaction=".$val['action']."';\"";
                $menutooltip = addslashes(htmlentities($val['tooltip']));
                if ($val['tooltip']!="") $menuitem .= ' onmouseover="this.T_WIDTH=210;this.T_STICKY=true;this.T_TEMP=0;return escape(\''.$menutooltip.'\');";';
                $menuitem .= ">";
                echo $menuitem."\n";

                echo "<a style='cursor:pointer'><font color='lime'>".$val['menu']."</font></a>";
                echo "</td>"."\n";
                }

                  else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>".$val['menu']."</a>";
		echo "</th>"."\n";
        }
        }

   }


?>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
<?php
		// ajout code pour affichage mod perso dans espace perso
		if ($pub_subaction <> '') {
           $query = "SELECT root, link FROM ".TABLE_MOD." WHERE active = '1' AND menupos=6 AND action = '".$pub_subaction."' ORDER BY position asc";
           $result = $db->sql_query($query);
           if ($db->sql_numrows($result)) {
              $val = $db->sql_fetch_assoc($result);
              require_once("mod/".$val['root']."/".$val['link']);
              exit();
           }
        }

switch ($pub_subaction) {
	case "empire" :
	require_once("home_empire.php");
	break;

	case "simulation" :
	require_once("home_simulation.php");
	break;

	case "stat" :
	require_once("home_stat.php");
	break;
	
	case "spy" :
	require_once("home_spy.php");
	break;

	default:
	require_once("home_empire.php");
	break;
}
?>
	</td>
</tr>
</table>

<?php
require_once("views/page_tail.php");
?>
