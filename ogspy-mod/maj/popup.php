<?php
/**
* popup.php du Mod MAJ
* @package MAJ
* @author ben.12
* @link http://www.ogsteam.fr
*/
	if (!defined('IN_SPYOGAME')) {
	    die("Hacking attempt");
	}	
	
	define('POPUP_MAJ_INCLUDED', 1);
	
	if(isset($pub_action2) && $pub_action2=='verif_maj' && $server_config['popup_maj_active']!=0) {
		
		
		$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='mod_maj' AND `active`='1' LIMIT 1";
		if ($db->sql_numrows($db->sql_query($query))) {
			
			require_once('./mod/maj/functions.php');
			
			/********************************************
			                                    GALAXIES:
			*********************************************/
			define("TABLE_MAJ", $table_prefix."maj");
			
			$maj_div = $server_config["step_maj"];
			$maj_step = ceil($num_of_systems/$maj_div);
			$part = array();
			
			$request = "select div_nb from ".TABLE_MAJ;
		    $request .= " where name_id = ".$user_data["user_id"]." and div_type = ".$maj_div;
		    $result = $db->sql_query($request);	
			
			while(list($maj_div_nb) = $db->sql_fetch_row($result)) {
				
				$maj_galaxy = ceil(($maj_div_nb+1) / $maj_div);
				$maj_system = (($maj_div_nb-(($maj_galaxy-1)*$maj_div))*$maj_step) + 1;
				
				$request = "select count(*) from ".TABLE_UNIVERSE;
		        $request .= " where galaxy = ".$maj_galaxy;
		        $request .= " and system between ".$maj_system." and ".($maj_system+$maj_step-1);
		        $request .= " and last_update > ".(time()-(60*60*24*$server_config["maj_step_jrs"]));
		        $result2 = $db->sql_query($request);
		        list($maj_planet) = $db->sql_fetch_row($result2);
				
				$maj_percent = ($maj_planet/((($maj_system+$maj_step-1)-$maj_system+1)*15))*100;
				
				if($maj_percent < $server_config['popup_maj_seuil_alert']) 
					$part[] = array('galaxy'=>$maj_galaxy, 'system_down'=>$maj_system, 'system_up'=>(($maj_system+$maj_step-1)>$num_of_systems?$num_of_systems:($maj_system+$maj_step-1)));
			}
			
			if(count($part)>0) {
				echo '<script language="javascript" type="text/javascript">alert("Des parties de galaxies dont tu es responsable\nauraient bien besoins d\'une mises à jour:\n\n';
				foreach($part as $v)
					echo ' - Galaxie '.$v['galaxy'].': systèmes '.$v['system_down'].' à '.$v['system_up'].'\n';
				echo '");</script>';
				echo '<noscript style="color:#FF0000">Des parties de galaxies dont tu es responsable<br />auraient bien besoins d\'une mises à jour:<br /><br />';
				foreach($part as $v)
					echo ' - Galaxie '.$v['galaxy'].': systèmes '.$v['system_down'].' à '.$v['system_up'].'<br />';
				echo '</noscript>';
			}
			
			/********************************************
			                                 CLASSEMENTS:
			*********************************************/
			
			$request = "select div_type from ".TABLE_MAJ;
		    $request .= " where name_id = ".$user_data["user_id"]." and div_type < 0";
		    $result = $db->sql_query($request);
			$part = array();
			
			while(list($div_type) = $db->sql_fetch_row($result)) {
				list($name, $date, $nb_rank, $rank, $user) = rank_maj($div_type);
				
				if($name[0]=='A') {
					$key_config1='popup_maj_step_rank_ally_alert';
					$key_config2='popup_maj_num_rank_ally_alert';
				} else {
					$key_config1='popup_maj_step_rank_player_alert';
					$key_config2='popup_maj_num_rank_player_alert';
				}
				
				if(($date+(60*60*24*$server_config[$key_config1]))<time())
					$part[] = array('rank_name'=>$name, 'msg'=>'il a plus de '.$server_config[$key_config1].' jours.');
				elseif($nb_rank<$server_config[$key_config2]) 
					$part[] = array('rank_name'=>$name, 'msg'=>'il y a mois de '.$server_config[$key_config2].' classements enregistrés.');
			}
			
			if(count($part)>0) {
				echo '<script language="javascript" type="text/javascript">alert("Des classements dont tu es responsable\nauraient bien besoins d\'une mises à jour:\n\n';
				foreach($part as $v)
					echo ' - '.$v['rank_name'].': '.$v['msg'].'\n';
				echo '");</script>';
				echo '<noscript style="color:#FF0000">Des classements dont tu es responsable<br />auraient bien besoins d\'une mises à jour:<br /><br />';
				foreach($part as $v)
					echo ' - '.$v['rank_name'].': '.$v['msg'].'\n';
				echo '</noscript>';
			}
		}
	}
?>