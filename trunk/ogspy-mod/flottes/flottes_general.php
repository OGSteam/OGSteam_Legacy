<?php
/***************************************************************************
*	filename	: flotte_general.php
*	desc.		:
*	Author		: 1.03
*	created		: 
*	modified	: 
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}


// def de qq variable
//define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");

// insertion des fonctions flotte
require_once("./mod/flottes/function_flottes.php");
require_once("./mod/flottes/flottes_inc.php");
require_once("./mod/flottes/flottes_lang.php");


global $CF,$CFO,$CFU,$CFP,$CFA,$CB1,$CB2,$CB3,$CB4,$CB5,$GA,$PLA;

buttons_bar($pub_subaction);

?>


<form action='index.php' method='POST' name='form'>
<input type='hidden' name='action' value='flottes' >
<input type='hidden' name='permit' value='change' >
<table width="100%">
	<tr>
		<td class='c' colspan='19'>Flottes</td>
	</tr>
	<tr>
		<th colspan='9'><input type="checkbox" name="active" OnClick='this.form.submit();' <?php echo ($members_data=='1' ? 'checked' : ''); ?>>&nbsp;J'autorise les membres cités ci-dessous à voir mon empire en plus de ma flotte.<br>Il n'ont en aucun cas la possibilité de changer quoi que ce soit.</th>
		<th colspan='10'><select name='add_user'>
<?php
			$request = "SELECT user_id, user_name FROM ".TABLE_USER;
			$result = $db->sql_query($request);
			while(list($id, $name) = $db->sql_fetch_row($result)) {
				echo "<option value='".$id."'>".$name."</option>";
			}
?>
		</select>&nbsp; &nbsp;<input type='submit' name='add' value='Ajouter ce membre ci-dessous'></th>
	</tr>
	<tr>
	<th colspan='9'>Auront accès: <?php
		$request = "SELECT DISTINCT user_name FROM ".TABLE_USER
			." LEFT JOIN ".TABLE_USER_GROUP." ON ".TABLE_USER.".user_id = ".TABLE_USER_GROUP.".user_id"
			." WHERE user_admin='1' OR (group_id=".(!empty($group_id) ? $group_id : "'-1'")." AND ".TABLE_USER_GROUP.".user_id=".TABLE_USER.".user_id)"
			." OR ".TABLE_USER.".user_id=";
		foreach($ids as $id) {
			$request .= $id." or ".TABLE_USER.".user_id=";
		}
		$request = substr($request, 0, strlen($request)-13-strlen(TABLE_USER));
		$result = $db->sql_query($request);
		list($name) = $db->sql_fetch_row($result);
		echo $name;
		while(list($name) = $db->sql_fetch_row($result)) {
			echo " | ".$name;
		}
?>
	</th>
	<th colspan='10'><select name='del_user'>
<?php
		if(count($ids)>0) {
			$request = "SELECT user_id, user_name FROM ".TABLE_USER." WHERE user_id=";
			foreach($ids as $id) {
				$request .= $id.' or user_id=';
			}
			$request = substr($request, 0, strlen($request)-12);
			$result = $db->sql_query($request);
			while(list($id, $name) = $db->sql_fetch_row($result)) {
				echo "<option value='".$id."'>".$name."</option>";
			}
		}
?>
		</select>&nbsp; &nbsp;<input type='submit' name='del' value='Supprimer ce membre de la liste'></th>
	</tr>


<?php
		$request = "SELECT date as datem, ";
		foreach($mod_flottes_lang as $key => $value) {
			$request .= "`".$key."`, ";
//			if ($key=="planet_name") $key= "Nom Planet";
//			if ($key=="coordinates") $key= "Coordonnées";
//			if ($key=="planet_id") $key= "ID Planet";
			echo "<td class='c' width='6.66%'>".$lib_flottes_lang[$key]."</td>";
		}
		$request = substr($request, 0, strlen($request)-2);
		$request .= " FROM ".TABLE_MOD_FLOTTES." WHERE user_id=".$user_data['user_id'];
		$result = $db->sql_query($request);
	echo "</tr>\n<tr>";
	echo "</tr>";

//// En jaune si plus vieux que 2 jours sinon en vert

	$datei= mktime(0, 0, 0, date("m")  , date("d")-2, date("Y"));
	while ($row = mysql_fetch_row($result)) {
	 	echo '<tr>';
	 		$color=$CFO;
	 		if ($row[0]=='0'){ $datem=0;}
	 		else {
	 			$datem=mktime(0, 0, 0, date("m",$row[0])  , date("d",$row[0]), date("Y",$row[0]));
				if ($datem>=$datei){$color=$CF;}
			}
    	
    		for ($j = 1; $j < count($row); $j++) {
        		echo ($row[$j] == NULL)  ? '0' : "\t"."<th><font color='".$color."'>".$row[$j]."</font></th>";
    		}
        echo '</tr>';
	}
	$out="";

// Début joueur

	$request= "SELECT COUNT(planet_id) FROM ".TABLE_MOD_FLOTTES." WHERE user_id=".$user_data['user_id'];
	$result = $db->sql_query($request);
	list($nbj)=mysql_fetch_row($result);
	if ($nbj!=0){

// Total flotte joueur

	echo '<tr>';
		$request = "SELECT 'Total joueur' as planet_name, 'Flottes' as coordinates, ' ' as planet_id,";
		foreach($mod_flottes_lang as $key => $value) {
			if (($key!="planet_name")&($key!="coordinates")&($key!="planet_id")){
					$request .= "SUM(".$key.") as ".$key.", ";
			}
		}
		$request = substr($request, 0, strlen($request)-2);
		$request .= " FROM ".TABLE_MOD_FLOTTES." WHERE user_id=".$user_data['user_id'];
			
		if ($result = $db->sql_query($request)){
			echo "</tr>\n<tr>";
			echo '</tr>';

			while ($row = mysql_fetch_row($result)) {
	    		echo '<tr>';
    			for ($j = 0; $j < count($row); $j++) {
       		 		echo ($row[$j] == NULL) ? '' : "\t"."<th><b><font color=".$CFU.">".$row[$j]."</font></b></th>";
    			}
        		echo '</tr>';
			}
		}
		else {
			echo '</tr>';
			$out="Pas d'enregistrement";}
				
// fin total joueur

// Total cout flotte joueur

		echo '<tr>';
// total points
		$total=0;
		$i=1;
		$request = "SELECT ";
	
		foreach($mod_flottes_lang as $key => $value) {
			if (($key!="planet_name")&($key!="coordinates")&($key!="planet_id")){
				$request .= "(SUM(".$key.") * ".$vaisseaux[$i][1]." / 1000 ) + ";
				$i++;}
		}
		
		$request = substr($request, 0, strlen($request)-2);
		$request .= " as tot FROM ".TABLE_MOD_FLOTTES." WHERE user_id=".$user_data['user_id'];
		
		if ($result = $db->sql_query($request)){
			$total = mysql_fetch_row($result);
			if ($total[0]==''){$total=0;}
			else {$total=$total[0];}
			
/// Valeur point

			$request = "SELECT 'Total joueur' as planet_name, 'Points' as coordinates, ".$total." as planet_id,";
			$i=1;
			
			foreach($mod_flottes_lang as $key => $value) {
				if (($key!="planet_name")&($key!="coordinates")&($key!="planet_id")){
					$request .= "(SUM(".$key.") * ".$vaisseaux[$i][1]." / 1000 ) as ".$key.", ";
					$i++;}
			}
			
			$request = substr($request, 0, strlen($request)-2);
			$request .= " FROM ".TABLE_MOD_FLOTTES." WHERE user_id=".$user_data['user_id'];
			if ($result = $db->sql_query($request)){
				echo "</tr>\n<tr>";
				echo '</tr>';
				
				while ($row = mysql_fetch_row($result)) {
	    			echo '<tr>';
    				for ($j = 0; $j < count($row); $j++) {
    					if ($j<2) {
    						echo ($row[$j] == NULL) ? '' : "\t"."<th><b><font color=".$CFP.">".$row[$j]."</font></b></th>";}
    					else {
							echo ($row[$j] == NULL) ? '' : "\t"."<th><b><font color=".$CFP.">".number_format($row[$j], 0, ',', ' ')."</font></b></th>";} 
					}
    				echo '</tr>';
				}
			}
			else {
				echo '</tr>';
				$out="Pas d'enregistrement.";}
		}
		else {
			echo '</tr>';
			$out="Pas d'enregistrement..";}
	
// fin total joueur

	}
	else {$out="Pas d'enregistrement...";}

// fin joueur

// Début alliance
if (!empty($group_id)) {
	$request= "SELECT COUNT(planet_id) FROM ".TABLE_MOD_FLOTTES;
	$result = $db->sql_query($request);
	list($nba)=mysql_fetch_row($result);
	if ($nba!=0){

// Total flotte alliance

	echo '<tr>';
		$request = "SELECT 'Total ".$group_name."' as planet_name, 'Flottes' as coordinates, ' ' as planet_id,";
		foreach($mod_flottes_lang as $key => $value) {
			if (($key!="planet_name")&($key!="coordinates")&($key!="planet_id")){
			$request .= "SUM(".$key.") as ".$key.", ";}
		}
		$request = substr($request, 0, strlen($request)-2);
		$request .= " FROM ".TABLE_MOD_FLOTTES;
		$request .=" INNER JOIN ".TABLE_USER_GROUP." ON ".TABLE_MOD_FLOTTES.".user_id = ".TABLE_USER_GROUP.".user_id";
		$request .=" WHERE (".TABLE_USER_GROUP.".group_id=".$group_id.")";
		$result = $db->sql_query($request);
	echo "</tr>\n<tr>";
	echo '</tr>';
	while ($row = mysql_fetch_row($result)) {
	    echo '<tr>';

    	for ($j = 0; $j < count($row); $j++) {
        	echo ($row[$j] == NULL) ? '<i></i>' : "\t"."<th><b><font color=".$CFA.">".$row[$j]."</font></b></th>";
    	}
        	echo '</tr>';
	}

// fin total alliance

	}
	else {$out="Pas d'enregistrement....";}
}
// fin Alliance

// Début serveur

	$request= "SELECT COUNT(planet_id) FROM ".TABLE_MOD_FLOTTES;
	$result = $db->sql_query($request);
	list($nbs)=mysql_fetch_row($result);
	if ($nbs!=0){

// Total flotte Serveur

		echo '<tr>';
		$request = "SELECT 'Total Serveur' as planet_name, 'Flottes' as coordinates, ' ' as planet_id,";
		foreach($mod_flottes_lang as $key => $value) {
			if (($key!="planet_name")&($key!="coordinates")&($key!="planet_id")){
			$request .= "SUM(".$key.") as ".$key.", ";}
		}
		$request = substr($request, 0, strlen($request)-2);
		$request .= " FROM ".TABLE_MOD_FLOTTES;
		$result = $db->sql_query($request);
	echo "</tr>\n<tr>";
	echo '</tr>';
	while ($row = mysql_fetch_row($result)) {
	    echo '<tr>';

    	for ($j = 0; $j < count($row); $j++) {
        	echo ($row[$j] == NULL) ? '<i></i>' : "\t"."<th><b><font color=".$CFA.">".$row[$j]."</font></b></th>";
    	}
        	echo '</tr>';
	}

// fin total Serveur

	}
	else {$out="Pas d'enregistrement....";}

// fin Serveur

	echo $out;

	 echo "<tr><td colspan='15'>&nbsp";
	 echo '</tr>';

?>


</table>

</form>

<form action='index.php' method='POST' name='form2'>
	<table width="100%">
		<tr>
<?php
// verification du partage empire
$request = "SELECT DISTINCT ".TABLE_USER.".user_id, ".TABLE_USER.".user_name FROM ".TABLE_USER." LEFT JOIN ".TABLE_MOD_FLOTTES." on ".TABLE_USER.".user_id=".TABLE_MOD_FLOTTES.".user_id WHERE ".TABLE_MOD_FLOTTES.".activate='1' AND ".TABLE_MOD_FLOTTES.".user_id='".$user_data["user_id"]."'";
	$result = $db->sql_query($request);
	$validemp = (mysql_num_rows($result)==1 || $user_data["user_admin"] == 1) ? TRUE : FALSE;
	
// je suis admin, ou dans le groupe "mod_flottes" ou j'ai peut etre été autorisé a voir qq de particulier
			if($user_data["user_admin"] == 1 || !$forbidden || !empty($ids_autorised)) {

			if($user_data["user_admin"] == 1 ) {
//				$request = "SELECT DISTINCT ".TABLE_USER.".user_id, user_name FROM ".TABLE_MOD_FLOTTES." LEFT JOIN ".TABLE_USER." on ".TABLE_USER.".user_id=".TABLE_MOD_FLOTTES.".user_id WHERE ".TABLE_MOD_FLOTTES.".activate='1'";
				$request = "SELECT DISTINCT ".TABLE_USER.".user_id, user_name FROM ".TABLE_USER." ";
			}
			else {
				$request = "SELECT DISTINCT ".TABLE_USER.".user_id, user_name FROM ".TABLE_USER;
				$request .=" INNER JOIN ".TABLE_USER_GROUP." ON ".TABLE_USER.".user_id = ".TABLE_USER_GROUP.".user_id";
				$request .=" WHERE (".TABLE_USER_GROUP.".group_id=".(!empty($group_id) ? $group_id : "'-1'").")";
				$request .=" OR ".TABLE_USER.".user_id=";
				foreach($ids as $id) {
					$request .= $id." or ".TABLE_USER.".user_id=";
				}
				$request = substr($request, 0, strlen($request)-13-strlen(TABLE_USER));
			}
			$result = $db->sql_query($request);

			if(isset($pub_flottes_user_id) && check_var($pub_flottes_user_id, "Special", "#^[[:digit:]\-]+$#")) $flottes_user_id = $pub_flottes_user_id;
			else $flottes_user_id = -1; 
?>
		</tr>
	</table>
</form>


<form action='index.php' method='POST' name='form3'>
	<table>
		<tr>
			<td>
				<input type='hidden' name='action' value='flottes' >
				<select name="flottes_user_id">
<?php
	// $ok verifit si j'ai pas essayé de tricher:
					$ok = false;
					while(list($user_id, $user_name)= $db->sql_fetch_row($result)) {
						if(empty($user_id) && empty($user_name)) continue;
						echo "<option value='".$user_id."' ".($flottes_user_id == $user_id ? "selected" : "").">".$user_name."</option>";
						if($flottes_user_id == $user_id) $ok = true;
					}
?>
				</select>
				&nbsp; &nbsp;<input type='submit' value='Voir'>
			</td>
		</tr>
	</table>
</form>

<table width="100%">
	<tr align="center">
 

		
<?php

if (!isset($pub_subaction2)) $pub_subaction2 = "flottes";

if ($pub_subaction2 != "flottes") {
	echo "\t\t\t"."<th class='c' width='150' onclick=\"window.location = 'index.php?action=flottes&subaction2=flottes&flottes_user_id=".$flottes_user_id."';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Flottes</font></a>";
	echo "</th>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Flottes</a>";
	echo "</th>";
}

if ($pub_subaction2 != "def" & $validemp) {
	echo "\t\t\t"."<th class='c' width='150' onclick=\"window.location = 'index.php?action=flottes&subaction2=def&flottes_user_id=".$flottes_user_id."';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Défenses</font></a>";
	echo "</th>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Défenses</a>";
	echo "</th>";
}

if ($pub_subaction2 != "empire" & $validemp) {
	echo "\t\t\t"."<th class='c' width='150' onclick=\"window.location = 'index.php?action=flottes&subaction2=empire&flottes_user_id=".$flottes_user_id."';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Empire</font></a>";
	echo "</th>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Empire</a>";
	echo "</th>";
}
/*
if ($pub_subaction2 != "simul" & $validemp=='1') {
	echo "\t\t\t"."<th class='c' width='150' onclick=\"window.location = 'index.php?action=flottes&subaction2=simul&flottes_user_id=".$flottes_user_id."';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Simulation</font></a>";
	echo "</th>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Simulation</a>";
	echo "</th>";
}
*/
if ($pub_subaction2 != "stat" & $validemp) {
	echo "\t\t\t"."<th class='c' width='150' onclick=\"window.location = 'index.php?action=flottes&subaction2=stat&flottes_user_id=".$flottes_user_id."';\">";
	echo "<a style='cursor:pointer'><font color='lime'>Statistiques</font></a>";
	echo "</th>";
}
else {
	echo "\t\t\t"."<th width='150'>";
	echo "<a>Statistiques</a>";
	echo "</th>";
}
?>
 
	</tr>
	<tr align="center">

<?php


// verif des droits:
if(check_var($flottes_user_id, "Special", "#^[[:digit:]\-]+$#") && $flottes_user_id != -1 && $flottes_user_id != '' && $ok) {

// saugarde et changement de user_data['user_id'] (je vois pas comment faire autrement car get_flottes l'utilise)
	$user_id = $user_data["user_id"];
	$user_data["user_id"] = $flottes_user_id;
	
	
	switch ($pub_subaction2) {
		case "flottes" :
		require_once("./mod/flottes/home_flottes.php");
		break;

		case "def" :
		require_once("./mod/flottes/home_def.php");
		break;
		
		case "empire" :
		require_once("./mod/flottes/home_empire.php");
		break;
/*		
		case "simul" :
		require_once("./mod/flottes/home_simulation.php");
		break;
*/		
		case "stat" :
		require_once("./mod/flottes/home_stat.php");
		break;
		
		default:
		require_once("./mod/flottes/home_flottes.php");
		break;
	}

// restitution de l'id:
	$user_data["user_id"] = $user_id;
}

?>

	</tr>
</table>

<?php
}
?>


