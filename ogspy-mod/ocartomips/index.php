<?php


if (!defined('IN_SPYOGAME')) die("Non définis");

require_once("views/page_header.php");

/// ajout modif inter
define("FOLDER_LANG","mod/ocartomips/lang");
include(FOLDER_LANG."/lang_french.php");




$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='ocartomips' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("requete invalide");
?>

<?php
If(!isset($_GET['menu']) OR ($_GET['menu'] != 'Visualisation' AND $_GET['menu'] != 'Recherche' AND $_GET['menu'] != 'Resultat' AND $_GET['menu'] != 'Apropos'))
$_GET['menu'] = 'Visualisation';
?>

<table style="">
		<tr>
			<th><strong><a href="?action=ocartomips&menu=visualisation"><?php echo ''.$lang['omips_menu_visu'].'';?></a></strong></th>
			<th><strong><a href="?action=ocartomips&menu=Recherche"><?php echo ''.$lang['omips_menu_rech'].'';?></a></strong></th>
			<th><strong><a href="?action=ocartomips&menu=Apropos"><?php echo ''.$lang['omips_menu_aide'].'';?></a></strong></th>
		</tr>
</table>

<?php if($_GET['menu'] == 'Visualisation') {

$tableau_mip_g1[] = 0;
$tableau_mip_g2[] = 0;
$tableau_mip_g3[] = 0;
$tableau_mip_g4[] = 0;
$tableau_mip_g5[] = 0;
$tableau_mip_g6[] = 0;
$tableau_mip_g7[] = 0;
$tableau_mip_g8[] = 0;
$tableau_mip_g9[] = 0;
$i = 0;
while (499 >= $i)
{
	$tableau_mip_g1[$i] = 0;
	$tableau_mip_g2[$i] = 0;
	$tableau_mip_g3[$i] = 0;
	$tableau_mip_g4[$i] = 0;
	$tableau_mip_g5[$i] = 0;
	$tableau_mip_g6[$i] = 0;
	$tableau_mip_g7[$i] = 0;
	$tableau_mip_g8[$i] = 0;
	$tableau_mip_g9[$i] = 0;
	$i = $i + 1;
}

$nb_total_p = 0;

$nb_mip_1 = 0;
$nb_bl_1 = 0;
$nb_p_v_1 = 0; $nb_p_p_1 = 0;

$nb_mip_2 = 0;
$nb_bl_2 = 0;
$nb_p_v_2 = 0; $nb_p_p_2 = 0;

$nb_mip_3 = 0;
$nb_bl_3 = 0;
$nb_p_v_3 = 0; $nb_p_p_3 = 0;

$nb_mip_4 = 0;
$nb_bl_4 = 0;
$nb_p_v_4 = 0; $nb_p_p_4 = 0;

$nb_mip_5 = 0;
$nb_bl_5 = 0;
$nb_p_v_5 = 0; $nb_p_p_5 = 0;

$nb_mip_6= 0;
$nb_bl_6 = 0;
$nb_p_v_6 = 0; $nb_p_p_6 = 0;

$nb_mip_7 = 0;
$nb_bl_7 = 0;
$nb_p_v_7 = 0; $nb_p_p_7 = 0;

$nb_mip_8 = 0;
$nb_bl_8 = 0;
$nb_p_v_8 = 0; $nb_p_p_8 = 0;

$nb_mip_9 = 0;
$nb_bl_9 = 0;
$nb_p_v_9 = 0; $nb_p_p_9 = 0;

$i = 0;
$v = 0;
$id_pl_table = array();
$reponce_visu = mysql_query("SELECT 
						".$table_prefix."user_building.user_id AS user_id_b,
						".$table_prefix."user_building.silo AS silo,
						".$table_prefix."user_building.coordinates AS coordinates,
						".$table_prefix."user_building.planet_id AS id_pl,
						".$table_prefix."user_defence.user_id AS user_id_d,
						".$table_prefix."user_defence.mip AS mip,
						".$table_prefix."user_technology.user_id AS user_id_t,
						".$table_prefix."user_technology.ri AS ri
						FROM ".$table_prefix."user_building 
						LEFT JOIN ".$table_prefix."user_defence ON ".$table_prefix."user_building.user_id = ".$table_prefix."user_defence.user_id 
						LEFT JOIN ".$table_prefix."user_technology ON ".$table_prefix."user_building.user_id = ".$table_prefix."user_technology.user_id");
while ($donnees_visu = mysql_fetch_array($reponce_visu))
{
	$g = 0; $ss = 0; $p = 0;
	$g_ss_p = explode(":", $donnees_visu['coordinates']);
	$g = $g_ss_p[0];
	$ss = $g_ss_p[1];
	$p = $g_ss_p[2];

	
	$j = 0;
	$ok = 1;
	while($j < $v)
	{
		if($id_pl_table[$v] == $donnees_visu['id_pl'])
		{
			$j = $v;
			$ok = 0;
		}
		$j = $j + 1;
	}
	
	if($ok)
	{	
		$v = $v + 1;
		
		//Galaxie 1
		if($g == 1)
		{
			$nb_mip_1 = $nb_mip_1 + $donnees_visu['mip'];
			
			if($donnees_visu['silo'] != 0)
				$nb_bl_1 = $nb_bl_1 + 1;
		
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss - (($donnees_visu['ri']*5)-1) + $i) > 0)
				{
					$tableau_mip_g1[$ss - (($donnees_visu['ri']*5)-1) + $i] = 1;
				}
				$i = $i + 1;
			}
			
			$tableau_mip_g1[$ss] = 1;
			
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss + (($donnees_visu['ri']*5)-1) - $i) < 499)
				{
					$tableau_mip_g1[$ss + (($donnees_visu['ri']*5)-1) - $i] = 1;;
				}
				$i = $i + 1;
			}
		}
		
		//Galaxie 2
		if($g == 2)
		{
			$nb_mip_2 = $nb_mip_2 + $donnees_visu['mip'];
			
			if($donnees_visu['silo'] != 0)
				$nb_bl_2 = $nb_bl_2 + 1;
		
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss - (($donnees_visu['ri']*5)-1) + $i) > 0)
				{
					$tableau_mip_g2[$ss - (($donnees_visu['ri']*5)-1) + $i] = 1;
				}
				$i = $i + 1;
			}
			
			$tableau_mip_g2[$ss] = 1;
			
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss + (($donnees_visu['ri']*5)-1) - $i) < 499)
				{
					$tableau_mip_g2[$ss + (($donnees_visu['ri']*5)-1) - $i] = 1;;
				}
				$i = $i + 1;
			}
		}
		
		
		//Galaxie 3
		if($g == 3)
		{
			$nb_mip_3 = $nb_mip_3 + $donnees_visu['mip'];
			
			if($donnees_visu['silo'] != 0)
				$nb_bl_3 = $nb_bl_3 + 1;
		
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss - (($donnees_visu['ri']*5)-1) + $i) > 0)
				{
					$tableau_mip_g3[$ss - (($donnees_visu['ri']*5)-1) + $i] = 1;
				}
				$i = $i + 1;
			}
			
			$tableau_mip_g3[$ss] = 1;
			
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss + (($donnees_visu['ri']*5)-1) - $i) < 499)
				{
					$tableau_mip_g3[$ss + (($donnees_visu['ri']*5)-1) - $i] = 1;;
				}
				$i = $i + 1;
			}
		}
		
		
		//Galaxie 4
		if($g == 4)
		{
			$nb_mip_4 = $nb_mip_4 + $donnees_visu['mip'];
			
			if($donnees_visu['silo'] != 0)
				$nb_bl_4 = $nb_bl_4 + 1;
		
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss - (($donnees_visu['ri']*5)-1) + $i) > 0)
				{
					$tableau_mip_g4[$ss - (($donnees_visu['ri']*5)-1) + $i] = 1;
				}
				$i = $i + 1;
			}
			
			$tableau_mip_g4[$ss] = 1;
			
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss + (($donnees_visu['ri']*5)-1) - $i) < 499)
				{
					$tableau_mip_g4[$ss + (($donnees_visu['ri']*5)-1) - $i] = 1;;
				}
				$i = $i + 1;
			}
		}
		
		
		//Galaxie 5
		if($g == 5)
		{
			$nb_mip_5 = $nb_mip_5 + $donnees_visu['mip'];
			
			if($donnees_visu['silo'] != 0)
				$nb_bl_5 = $nb_bl_5 + 1;
		
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss - (($donnees_visu['ri']*5)-1) + $i) > 0)
				{
					$tableau_mip_g5[$ss - (($donnees_visu['ri']*5)-1) + $i] = 1;
				}
				$i = $i + 1;
			}
			
			$tableau_mip_g5[$ss] = 1;
			
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss + (($donnees_visu['ri']*5)-1) - $i) < 499)
				{
					$tableau_mip_g5[$ss + (($donnees_visu['ri']*5)-1) - $i] = 1;;
				}
				$i = $i + 1;
			}
		}
		
		
		//Galaxie 6
		if($g == 6)
		{
			$nb_mip_6 = $nb_mip_6 + $donnees_visu['mip'];
			
			if($donnees_visu['silo'] != 0)
				$nb_bl_6 = $nb_bl_6 + 1;
		
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss - (($donnees_visu['ri']*5)-1) + $i) > 0)
				{
					$tableau_mip_g6[$ss - (($donnees_visu['ri']*5)-1) + $i] = 1;
				}
				$i = $i + 1;
			}
			
			$tableau_mip_g6[$ss] = 1;
			
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss + (($donnees_visu['ri']*5)-1) - $i) < 499)
				{
					$tableau_mip_g6[$ss + (($donnees_visu['ri']*5)-1) - $i] = 1;;
				}
				$i = $i + 1;
			}
		}
		
		
		//Galaxie 7
		if($g == 7)
		{
			$nb_mip_7 = $nb_mip_7 + $donnees_visu['mip'];
			
			if($donnees_visu['silo'] != 0)
				$nb_bl_7 = $nb_bl_7 + 1;
		
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss - (($donnees_visu['ri']*5)-1) + $i) > 0)
				{
					$tableau_mip_g7[$ss - (($donnees_visu['ri']*5)-1) + $i] = 1;
				}
				$i = $i + 1;
			}
			
			$tableau_mip_g7[$ss] = 1;
			
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss + (($donnees_visu['ri']*5)-1) - $i) < 499)
				{
					$tableau_mip_g7[$ss + (($donnees_visu['ri']*5)-1) - $i] = 1;;
				}
				$i = $i + 1;
			}
		}
		
		
		//Galaxie 8
		if($g == 8)
		{
			$nb_mip_8 = $nb_mip_8 + $donnees_visu['mip'];
			
			if($donnees_visu['silo'] != 0)
				$nb_bl_8 = $nb_bl_8 + 1;
		
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss - (($donnees_visu['ri']*5)-1) + $i) > 0)
				{
					$tableau_mip_g8[$ss - (($donnees_visu['ri']*5)-1) + $i] = 1;
				}
				$i = $i + 1;
			}
			
			$tableau_mip_g8[$ss] = 1;
			
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss + (($donnees_visu['ri']*5)-1) - $i) < 499)
				{
					$tableau_mip_g8[$ss + (($donnees_visu['ri']*5)-1) - $i] = 1;;
				}
				$i = $i + 1;
			}
		}
		
		
		//Galaxie 9
		if($g == 9)
		{
			$nb_mip_9 = $nb_mip_9 + $donnees_visu['mip'];
			
			if($donnees_visu['silo'] != 0)
				$nb_bl_9 = $nb_bl_9 + 1;
		
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss - (($donnees_visu['ri']*5)-1) + $i) > 0)
				{
					$tableau_mip_g9[$ss - (($donnees_visu['ri']*5)-1) + $i] = 1;
				}
				$i = $i + 1;
			}
			
			$tableau_mip_g9[$ss] = 1;
			
			$i = 0;
			while($i < (($donnees_visu['ri']*5)-1))
			{
				if(($ss + (($donnees_visu['ri']*5)-1) - $i) < 499)
				{
					$tableau_mip_g9[$ss + (($donnees_visu['ri']*5)-1) - $i] = 1;;
				}
				$i = $i + 1;
			}
		}
	}
}
?>
<br>
<table style="text-align:center; color:white;">
	<tr>
		<td class='c'><php echo ''.$lang['omips_visu_visu'].'';?></td>
	</tr>
	
	<tr><th>

<em><strong><php echo ''.$lang['omips_visu_pourcentage_et_visu'].'';?></strong></em>
<br><br>

<?php
echo '<em>'.$lang['omips_visu_g1'].'</em>';
echo '<br><table cellspacing="0" style="border: 1px solid #405680; width:250px; border-spacing: 0px; height: 10px;"><tr>';
	
$i = 0;
while($i < 499)
{
	if($tableau_mip_g1[$i] == 1) 
	{
		echo '<td style="background-color:#097100;"></td>';
		$nb_p_p_1 = $nb_p_p_1 + 1;
	}
	else
	{
		echo '<td style="background-color:#344566;"></td>';
		$nb_p_v_1 = $nb_p_v_1 + 1;
	}
	
	$i = $i + 2;
}	

$nb_p_1 = ($nb_p_p_1 * 100) / ($nb_p_v_1 + $nb_p_p_1);

echo '</tr></table>';
echo $nb_p_1.''.$lang['omips_visu_couverture1'].' '.$nb_mip_1.' '.$lang['omips_visu_couverture2'].' '.$nb_bl_1.' '.$lang['omips_visu_couverture3'].'';
?>
<br><br>
<?php
echo '<em>'.$lang['omips_visu_g2'].'</em>';
echo '<br><table cellspacing="0" style="border: 1px solid #405680; width:250px; border-spacing: 0px; height: 10px;"><tr>';
	
$i = 0;
while($i < 499)
{
	if($tableau_mip_g2[$i] == 1) 
	{
		echo '<td style="background-color:#097100;"></td>';
		$nb_p_p_2 = $nb_p_p_2 + 1;
	}
	else
	{
		echo '<td style="background-color:#344566;"></td>';
		$nb_p_v_2 = $nb_p_v_2 + 1;
	}
	
	$i = $i + 2;
}	

$nb_p_2 = ($nb_p_p_2 * 100) / ($nb_p_v_2 + $nb_p_p_2);

echo '</tr></table>';
echo $nb_p_2.''.$lang['omips_visu_couverture1'].' '.$nb_mip_2.' '.$lang['omips_visu_couverture2'].' '.$nb_bl_2.' '.$lang['omips_visu_couverture3'].'';
?>
<br><br>
<?php
echo '<em>'.$lang['omips_visu_g3'].'</em>';
echo '<br><table cellspacing="0" style="border: 1px solid #405680; width:250px; border-spacing: 0px; height: 10px;"><tr>';
	
$i = 0;
while($i < 499)
{
	if($tableau_mip_g3[$i] == 1) 
	{
		echo '<td style="background-color:#097100;"></td>';
		$nb_p_p_3 = $nb_p_p_3 + 1;
	}
	else
	{
		echo '<td style="background-color:#344566;"></td>';
		$nb_p_v_3 = $nb_p_v_3 + 1;
	}
	
	$i = $i + 2;
}	

$nb_p_3 = ($nb_p_p_3 * 100) / ($nb_p_v_3 + $nb_p_p_3);

echo '</tr></table>';
 echo $nb_p_3.''.$lang['omips_visu_couverture1'].' '.$nb_mip_3.' '.$lang['omips_visu_couverture2'].' '.$nb_bl_3.' '.$lang['omips_visu_couverture3'].'';
?>
<br><br>
<?php
echo '<em>'.$lang['omips_visu_g4'].'</em>';
echo '<br><table cellspacing="0" style="border: 1px solid #405680; width:250px; border-spacing: 0px; height: 10px;"><tr>';
	
$i = 0;
while($i < 499)
{
	if($tableau_mip_g4[$i] == 1) 
	{
		echo '<td style="background-color:#097100;"></td>';
		$nb_p_p_4 = $nb_p_p_4 + 1;
	}
	else
	{
		echo '<td style="background-color:#344566;"></td>';
		$nb_p_v_4 = $nb_p_v_4 + 1;
	}
	
	$i = $i + 2;
}	

$nb_p_4 = ($nb_p_p_4 * 100) / ($nb_p_v_4 + $nb_p_p_4);

echo '</tr></table>';
echo $nb_p_4.''.$lang['omips_visu_couverture1'].' '.$nb_mip_4.' '.$lang['omips_visu_couverture2'].' '.$nb_bl_4.' '.$lang['omips_visu_couverture3'].'';
?>
<br><br>
<?php
echo '<em>'.$lang['omips_visu_g5'].'</em>';
echo '<br><table cellspacing="0" style="border: 1px solid #405680; width:250px; border-spacing: 0px; height: 10px;"><tr>';
	
$i = 0;
while($i < 499)
{
	if($tableau_mip_g5[$i] == 1) 
	{
		echo '<td style="background-color:#097100;"></td>';
		$nb_p_p_5 = $nb_p_p_5 + 1;
	}
	else
	{
		echo '<td style="background-color:#344566;"></td>';
		$nb_p_v_5 = $nb_p_v_5 + 1;
	}
	
	$i = $i + 2;
}	

$nb_p_5 = ($nb_p_p_5 * 100) / ($nb_p_v_5 + $nb_p_p_5);

echo '</tr></table>';
echo $nb_p_5.''.$lang['omips_visu_couverture1'].' '.$nb_mip_5.' '.$lang['omips_visu_couverture2'].' '.$nb_bl_5.' '.$lang['omips_visu_couverture3'].'';
?>
<br><br>
<?php
echo '<em>'.$lang['omips_visu_g6'].'</em>';
echo '<br><table cellspacing="0" style="border: 1px solid #405680; width:250px; border-spacing: 0px; height: 10px;"><tr>';
	
$i = 0;
while($i < 499)
{
	if($tableau_mip_g6[$i] == 1) 
	{
		echo '<td style="background-color:#097100;"></td>';
		$nb_p_p_6 = $nb_p_p_6 + 1;
	}
	else
	{
		echo '<td style="background-color:#344566;"></td>';
		$nb_p_v_6 = $nb_p_v_6 + 1;
	}
	
	$i = $i + 2;
}	

$nb_p_6 = ($nb_p_p_6 * 100) / ($nb_p_v_6 + $nb_p_p_6);

echo '</tr></table>';
echo $nb_p_6.''.$lang['omips_visu_couverture1'].' '.$nb_mip_6.' '.$lang['omips_visu_couverture2'].' '.$nb_bl_6.' '.$lang['omips_visu_couverture3'].'';
?>
<br><br>
<?php
echo '<em>'.$lang['omips_visu_g7'].'</em>';
echo '<br><table cellspacing="0" style="border: 1px solid #405680; width:250px; border-spacing: 0px; height: 10px;"><tr>';
	
$i = 0;
while($i < 499)
{
	if($tableau_mip_g7[$i] == 1) 
	{
		echo '<td style="background-color:#097100;"></td>';
		$nb_p_p_7 = $nb_p_p_7 + 1;
	}
	else
	{
		echo '<td style="background-color:#344566;"></td>';
		$nb_p_v_7 = $nb_p_v_7 + 1;
	}
	
	$i = $i + 2;
}	

$nb_p_7 = ($nb_p_p_7 * 100) / ($nb_p_v_7 + $nb_p_p_7);

echo '</tr></table>';
echo $nb_p_7.''.$lang['omips_visu_couverture1'].' '.$nb_mip_7.' '.$lang['omips_visu_couverture2'].' '.$nb_bl_7.' '.$lang['omips_visu_couverture3'].'';
?>
<br><br>
<?php
echo '<em>'.$lang['omips_visu_g8'].'</em>';
echo '<br><table cellspacing="0" style="border: 1px solid #405680; width:250px; border-spacing: 0px; height: 10px;"><tr>';
	
$i = 0;
while($i < 499)
{
	if($tableau_mip_g8[$i] == 1) 
	{
		echo '<td style="background-color:#097100;"></td>';
		$nb_p_p_8 = $nb_p_p_8 + 1;
	}
	else
	{
		echo '<td style="background-color:#344566;"></td>';
		$nb_p_v_8 = $nb_p_v_8 + 1;
	}
	
	$i = $i + 2;
}	

$nb_p_8 = ($nb_p_p_8 * 100) / ($nb_p_v_8 + $nb_p_p_8);

echo '</tr></table>';
echo $nb_p_8.'% de la galaxie converte avec '.$nb_mip_8.' Mips répartie dans '.$nb_bl_8.' base de lancement.';
?>
<br><br>
<?php
echo '<em>'.$lang['omips_visu_g9'].'</em>';
echo '<br><table cellspacing="0" style="border: 1px solid #405680; width:250px; border-spacing: 0px; height: 10px;"><tr>';
	
$i = 0;
while($i < 499)
{
	if($tableau_mip_g9[$i] == 1) 
	{
		echo '<td style="background-color:#097100;"></td>';
		$nb_p_p_9 = $nb_p_p_9 + 1;
	}
	else
	{
		echo '<td style="background-color:#344566;"></td>';
		$nb_p_v_9 = $nb_p_v_9 + 1;
	}
	
	$i = $i + 2;
}	

$nb_p_9 = ($nb_p_p_9 * 100) / ($nb_p_v_9 + $nb_p_p_9);

echo '</tr></table>';
echo $nb_p_9.''.$lang['omips_visu_couverture1'].' '.$nb_mip_9.' '.$lang['omips_visu_couverture2'].' '.$nb_bl_9.' '.$lang['omips_visu_couverture3'].'';

$nb_total_p = ($nb_p_1 + $nb_p_2 + $nb_p_3 + $nb_p_4 + $nb_p_5 + $nb_p_6 + $nb_p_7 + $nb_p_8 + $nb_p_9)/9;
?>

<br>
<br>
<em><?php echo''.$lang['omips_visu_couverture_total'].'';?><?php echo round($nb_total_p, 2); ?>%.</em>
	
	</th></tr>
</table>

<?php }elseif($_GET['menu'] == 'Recherche') { ?>
<br>
<table style="text-align:center; color:white;">	 
  
	<tr>
<td colspan="8" class="c"><strong><?php echo''.$lang['omips_rech'].''; ?></strong></td>
	</th>   
			
	<form method="post" action="index.php?action=ocartomips&menu=Resultat"> 

	<tr>
<th><strong><?php echo''.$lang['omips_rech'].''; ?></strong></th>
<th><label><input type="text" name="g" size="5"/></label>/<label><input type="text" name="ss" size="5"/></label>/<label><input type="text" name="p" size="5"/></label></th>
	</tr>
	
	<tr>
<th colspan="8"><?php echo''.$lang['omips_rech_exlication'].''; ?></th>
	</tr>
	
	<tr>
<th colspan="8"><input type="submit" name="recherche" value="Rechercher"/></th>
	</tr>
				
	</form>
	
</table>
<?php }elseif($_GET['menu'] == 'Resultat') { 

$tableau_resultat = array();

$rien = 0;
$i = 0;

$reponce_config_g = mysql_query("SELECT config_value FROM ".$table_prefix."config WHERE config_name='num_of_galaxies'");
$donnees_config_g = mysql_fetch_array($reponce_config_g);

$reponce_config_ss = mysql_query("SELECT config_value FROM ".$table_prefix."config WHERE config_name='num_of_systems'");
$donnees_config_ss = mysql_fetch_array($reponce_config_ss);

if(isset($_POST['recherche']))
{
	if(!empty($_POST['g']) and !empty($_POST['ss']) and !empty($_POST['p']))
	{
		if(is_numeric($_POST['g']) and is_numeric($_POST['ss']) and is_numeric($_POST['p']))
		{
			if($_POST['g'] <= 9 and $_POST['g'] > 0)
			{
				if($_POST['ss'] <= 499 and $_POST['ss'] > 0)
				{
					$g_post = htmlentities($_POST['g']);
					$ss_post = htmlentities($_POST['ss']);
					$p_post = htmlentities($_POST['p']);
					
					$reponce_resultat = mysql_query("SELECT 
						".$table_prefix."user_building.user_id AS user_id_b,
						".$table_prefix."user_building.silo AS silo,
						".$table_prefix."user_building.coordinates AS coordinates,
						".$table_prefix."user_building.csp AS csp,
						".$table_prefix."user_building.udn AS udn,
						".$table_prefix."user_building.planet_id AS id_pl,
						".$table_prefix."user_defence.user_id AS user_id_d,
						".$table_prefix."user_defence.mip AS mip,
						".$table_prefix."user_technology.user_id AS user_id_t,
						".$table_prefix."user_technology.ri AS ri,
						".$table_prefix."user_technology.Armes AS armes,
						".$table_prefix."user.user_id AS id,
						".$table_prefix."user.user_name AS name
						FROM ".$table_prefix."user_building 
						LEFT JOIN ".$table_prefix."user_defence ON ".$table_prefix."user_building.user_id = ".$table_prefix."user_defence.user_id 
						LEFT JOIN ".$table_prefix."user_technology ON ".$table_prefix."user_building.user_id = ".$table_prefix."user_technology.user_id
						LEFT JOIN ".$table_prefix."user ON ".$table_prefix."user_building.user_id = ".$table_prefix."user.user_id");
					while ($donnees_resultat = mysql_fetch_array($reponce_resultat))
					{
						$g = 0; $ss = 0; $p = 0;
						$g_ss_p = explode(":", $donnees_resultat['coordinates']);
						$g = $g_ss_p[0];
						$ss = $g_ss_p[1];
						$p = $g_ss_p[2];
						
						if($g_post == $g)
						{
							if( ($ss-(($donnees_resultat['ri']*5)-1)) <= $ss_post AND ($ss+(($donnees_resultat['ri']*5)-1)) >= $ss_post)
							{
								if($donnees_resultat['silo'] != 0)
								{
									$rien = 1;
									$mips_h = 0; 
									$mips_h_token = 0;
									if($donnees_resultat['csp'] >= 4)
									{
										$mips_h = ((12500+2500)/5000)*(2/(1+$donnees_resultat['csp']));				
										while($mips_h_token < $donnees_resultat['udn'])
										{
											$mips_h = $mips_h*0.5;
											$mips_h_token = $mips_h_token + 1;
										}
										
										if($mips_h < 1/3600) 
											$mips_h = 1/3600;
										
										$mips_h = floor(3600/(floor(3600*$mips_h)));
										$mips_h_total = $mips_h_total + $mips_h;
									}
									else
									{
										$mips_h = '/';
									}
								
									$j = 0;
									$ok = 1;
									while($j < $i)
									{
										$explode_table = explode("//", $tableau_resultat[$j]);
										if($explode_table[0] == $donnees_resultat['id_pl'])
										{
											$j = $i;
											$ok = 0;
										}
										$j = $j + 1;
									}
								
									if($ok) 
									{
										$tableau_resultat[$i] = $donnees_resultat['id_pl'].'//'.
										$donnees_resultat['name'].'//'.
										$donnees_resultat['coordinates'].'//'.
										$donnees_resultat['silo'].'//'.
										$donnees_resultat['mip'].'//'.
										$donnees_resultat['armes'].'//'.
										$donnees_resultat['udn'].'//'.
										$donnees_resultat['csp'].'//'.
										$mips_h;
										$i = $i + 1;
									}
								}
							}
						}					
					}					
				}
				else
				{
				echo '<br>'.$lang['omips_result_erreur'].'<br>';
				}
			}
			else
			{
			echo '<br>'.$lang['omips_result_erreur'].'<br>';
			}
		}
		else
		{
		echo '<br>'.$lang['omips_result_erreur2'].'<br>';
		}
	}
	else
	{
	echo '<br>'.$lang['omips_result_erreur3'].'<br>';
	}
}
else
{
echo '<br>'.$lang['omips_result_erreur4'].'<br>';
}

?>
<br>
<table style="text-align:center; color:white;">	 
  
	<tr>
<td colspan="9" class="c"><strong><?php echo ''.$lang['omips_result'].''; ?></strong></td>
	</th>  
	
	<tr>
<td class="c"><strong>#</strong></td>
<td class="c"><strong><?php echo ''.$lang['omips_result_Pseudo'].''; ?></strong></td>
<td class="c"><strong><?php echo ''.$lang['omips_result_Coordonn'].''; ?></strong></td>
<td class="c"><strong><?php echo ''.$lang['omips_result_Silo'].''; ?></strong></td>
<td class="c"><strong><?php echo ''.$lang['omips_result_Mips'].''; ?></strong></td>
<td class="c"><strong><?php echo ''.$lang['omips_result_Armes'].''; ?></strong></td>
<td class="c"><strong><?php echo ''.$lang['omips_result_Nanites'].''; ?></strong></td>
<td class="c"><strong><?php echo ''.$lang['omips_result_Chantier'].''; ?></strong></td>
<td class="c"><strong><?php echo ''.$lang['omips_result_Mips2'].''; ?></strong></td>
	</th>  	
			
<?php 
$i = 0;
$v = 0;

$mise_en_forme = '[table border="1"][td colspan="9"][b][center]'.$lang['omips_result_result_mips'].'[/center][/b][/td]';
$mise_en_forme = $mise_en_forme.'[tr][td]#[/td][td]'.$lang['omips_result_Pseudo'].'[/td][td]'.$lang['omips_result_Coordonn'].'[/td][td]'.$lang['omips_result_Silo'].'[/td][td]'.$lang['omips_result_Mips'].'[/td][td]'.$lang['omips_result_Armes'].'[/td][td]'.$lang['omips_result_Nanites'].'[/td][td]'.$lang['omips_result_Chantier'].'[/td][td]'.$lang['omips_result_Mips'].'[/td][/tr]';
while($v == 0)
{
	$explode_table = explode("//", $tableau_resultat[$i]);
	$mise_en_forme = $mise_en_forme.'[tr][td]'.($i+1).'[/td][td]'.$explode_table[1].'[/td][td]'.$explode_table[2].'[/td][td]'.$explode_table[3].'[/td][td]'.$explode_table[4].'[/td][td]'.$explode_table[5].'[/td][td]'.$explode_table[6].'[/td][td]'.$explode_table[7].'[/td][td]'.$explode_table[8].'[/td][/tr]';
	
	if($rien == 0)
	{
		$v = 1;
		?>
	<tr>
<th colspan="9"><em><?php echo ''.$lang['omips_result_result_no_result'].''; ?></em></th>
	</tr>
		<?php
	}
	else
	{
?>
			
	<tr>
<th><?php echo $i+1; ?></th>
<th><?php echo $explode_table[1]; ?></th>
<th><?php echo $explode_table[2]; ?></th>
<th><?php echo $explode_table[3]; ?></th>
<th><?php echo $explode_table[4]; ?></th>
<th><?php echo $explode_table[5]; ?></th>
<th><?php echo $explode_table[6]; ?></th>
<th><?php echo $explode_table[7]; ?></th>
<th><?php echo $explode_table[8]; ?></th>
	</tr>

<?php 
	}
if($tableau_resultat[$i+1] == '')
	$v = 1;
	
$i = $i + 1;
} 
$mise_en_forme = $mise_en_forme.'[td colspan="9"][center][i]'.$lang['omips_result_result_total_mip'].'[B]'.$mips_h_total.'[/B][/i][/center][/td][/table]';

if($rien != 0)
{
?>
	<tr>
<th colspan="9"><?php echo ''.$lang['omips_result_result_total_mip'].''; ?><strong><?php echo $mips_h_total; ?></strong></th>
	</tr>
<?php } ?>
	
</table>

<?php
if($rien != 0)
{
?>
<br>
<table style="text-align:center; color:white;">	 
  
	<tr>
<td colspan="9" class="c"><strong><?php echo ''.$lang['omips_result_result_insert_bbcode'].''; ?></strong></td>
	</th>  

	<tr>
<th><label><textarea onClick="javascript:this.select();" name="texte" rows="1" cols="95"><?php echo '[center]'.$mise_en_forme.'[/center]'; ?></textarea></label></th>
	</tr>
	
</table>
<?php } ?>
	
<?php }elseif($_GET['menu'] == 'Apropos') { ?>
<br>
<table style="text-align:center; color:white;">
	<tr>
		<td class='c'><?php echo ''.$lang['omips_apropos'].''; ?></td>
	</tr>
	
<?php echo ''.$lang['omips_apropos_help'].''; ?>


</table>
<?php } ?>

<br><br>
<?php echo ''.$lang['omips_apropos_copyright'].'';
 require_once("./views/page_tail.php");
 ?>

