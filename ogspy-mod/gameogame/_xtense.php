<?php
/**
*   _xtense.php - fichier d'interface avec Xtense2
*   @package gameOgame
*   @author ericc
*   @link http://www.ogsteam.fr
*   @version    : 2.1
*   created	    : 13/04/2008
*   modified	: 04/05/2008
**/
// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if(class_exists("Callback")){
class gameOgame_Callback extends Callback {
        public $version = '2.3.9';
        public function gog_rc($rapport){
			global $io;
			if(gog_rc($rapport))
				return Io::SUCCESS;
			else
				return Io::ERROR;
		}
        public function gog_rr($rapport){
			global $io;
			if(gog_rr($rapport))
				return Io::SUCCESS;
			else
				return Io::ERROR;
		}
        public function getCallbacks() {
                return array(
                        array(
                                'function' => 'gog_rc',
                                'type' => 'rc'
                        ),
                        array(
                                'function' => 'gog_rr',
                                'type' => 'rc_cdr'
                        )
                );
       }
}
}


// Version minimum de Xtense2
$xtense_version="2.3.0";

// Import des Rapports de combats
function gog_rc($rapport)
{
    global $db, $table_prefix, $user_data, $config;
    $xtense_version="2.3.0";
    //$raw = stripslashes($rapport["content"]);
    //$raw = str_replace("\'","'",$raw);
    //Compatibilité UNIX/Windows
    //$raw = str_replace("\r\n","\n",$raw);
    //$raw = str_replace(" \n","\n",$raw);
    //Compatibilité IE/Firefox
    //$raw = str_replace("\t",' ',$raw);
    // Mise en forme du rapport, nettoyage des codes html et autres 
    //$rapport = remo_htm($raw);
    /*$handle=fopen("gog.txt","w");
    fwrite($handle,$raw);
    fwrite($handle,"--------\n");
	fwrite($handle,$rapport);
   //fwrite($handle,"\r\n");
   //fwrite($handle,$config[defenseur]);
   //fwrite($handle,"\r\n");  */
    
//	foreach($rapport['n'] as $n){
//		if ($n['type'] == "A"){
//			$query = $db->sql_query("SELECT count(planet_id) FROM ".TABLE_USER_BUILDING." WHERE user_id = '".$user_data['user_id']."' AND coordinates = '".$n['coords']."'");
//			list($check) = $db->sql_fetch_row($query);
//			if($check != 0){
//				$attaquant = $n['player'];
//				$coord_att = $n['coords'];
//				break;
//			}
//		}
//	}
//	
//	foreach($rapport['n'] as $n){
//		if ($n['type'] == "D"){
//			$defenseur = $n['player'];
//			$coord_def = $n['coords'];
//			break;
//		}
//	}
    //Definition des tables de gOg
    define('TABLE_GAME',$table_prefix.'game');
    //récupération des paramètres de config
	$query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='gameOgame' and `config`='config'";
	$result = $db->sql_query($query);
	$config = mysql_fetch_row($result);
	$gog_config = unserialize($config[0]);
	
    // Vérifie que c'est bien un RC valide
    if (!$rapport['date'])
    {
        echo 'Rapport de combat invalide';
        return FALSE;
    }
    else
    {
        //récupère le pseudo de l'attaquant
        $attaquant = $rapport['n']['0']['player'];
        //preg_match('#Attaquant\s(.{3,50})\s\(#',$rapport,$attaquant);
        //récupère les coordonnées de l'attaquant
        $coord_att = $rapport['n']['0']['coords'];
        //preg_match('#Attaquant\s.{3,110}\[(.{5,8})]#',$rapport,$coord_att);
        //On regarde dans les coordonnées de l'espace personnel du joueur qui insère les données via le plugin si les coordonnées de l'attaquant correspondent à une de ses planètes
    	$query = "SELECT coordinates FROM ".TABLE_USER_BUILDING." WHERE user_id='".$user_data['user_id']."'";
    	$result = $db->sql_query($query);
		$attaqu = 0;
    	while(list($coordinates) = mysql_fetch_row($result))
		{
			if($coordinates == $coord_att) $attaqu = 1;
		}
    	if ($attaqu == 0)
    	{
    		// Vous n'êtes pas l'attaquant, je sors !!
    		return FALSE;
    	} 
    	//récupère le pseudo du défenseur
    	$defenseur = $rapport['n']['1']['player'];
        //preg_match('#Défenseur\s(.{3,50})\s\(#',$rapport,$defenseur);
        //récupère les coordonnées du défenseur
        $coord_def = $rapport['n']['1']['coords'];
        //preg_match('#Défenseur\s.{3,110}\[(.{5,8})]#',$rapport,$coord_def);
        // Récupère les pertes de l'attaquant et du défenseur
        $pertesA = $rapport['result']['a_lost'];
        $pertesD = $rapport['result']['d_lost'];
        //preg_match('#attaquant\sa\sperdu\sau\stotal\s(\d*)\sunités#',$rapport,$pertesA);
        //preg_match('#Le\sdéfenseur\sa\sperdu\sau\stotal\s(\d*)\sunités#',$rapport,$pertesD);
        //preg_match('#(\d*)\sunités\sde\smétal,\s(\d*)\sunités\sde\scristal\set\s(\d*)\sunités\sde\sdeutérium#',$rapport,$ressources);
    	$ressources=Array(0,0,0,0);
        if ($rapport['win'] == 'A') {
			$winmetal=isset($rapport['result']['win_metal']) ? $rapport['result']['win_metal'] : 0;
			$wincristal=isset($rapport['result']['win_cristal']) ? $rapport['result']['win_cristal'] : 0;
			$windeut=isset($rapport['result']['win_deut']) ? $rapport['result']['win_deut'] : 0;
			$ressources=Array(0,$winmetal,$wincristal,$windeut);
		}

        //if (!preg_match('#(\d*)\sunités\sde\smétal,\s(\d*)\sunités\sde\scristal\set\s(\d*)\sunités\sde\sdeutérium#',$rapport,$ressources)) $ressources=Array(0,0,0,0);
        // Debris
        $debmetal=isset($rapport['result']['deb_metal']) ? $rapport['result']['deb_metal'] : 0;
        $debcristal=isset($rapport['result']['deb_cristal']) ? $rapport['result']['deb_cristal'] : 0;
        $recyclage = Array(0,$debmetal,$debcristal);
        //if (!preg_match('#Un\schamp\sde\sdébris\scontenant\s(\d*)\sunités\sde\smétal\set\s(\d*)\sunités\sde\scristal\sse\sforme\sdans\sl\'orbite\sde\scette\splanète#',$rapport,$recyclage)) $recyclage[1]=$recyclage[2]=0;
        // Probabilite de lune
        $plune[1] = isset($rapport['moonprob']) ? $rapport['moonprob'] : 0;
        $lune = isset($rapport['moon']) ? $rapport['moon'] : 0;
        // calcul la date et l'heure du rapport
        $date = $rapport['date'];//mktime($date[3],$date[4],$date[5],$date[1],$date[2],date('Y'));
        //Calcul des points en fonction des coeficients
        $points = ceil(($ressources[1]+$ressources[2]+$ressources[3])/100000*$gog_config['pillage'] + $pertesA/100000*$gog_config['pertes'] + $pertesD/100000*$gog_config['degats'] + $lune*$gog_config['clune']);
        //On vérifie que cette attaque n'a pas déja été enregistrée
        $query = "SELECT id FROM ".TABLE_GAME." WHERE sender='".$user_data['user_id']."' AND date='".$date."' AND attaquant='".$attaquant."' ";
        $result = $db->sql_query($query);
        $nb = mysql_num_rows($result);
        // Si le RC existe déjà on sort
        if ($nb != 0) return FALSE;
        //Insert dans la base de données
        $query = 'INSERT INTO '.TABLE_GAME.' (id,sender,date,attaquant,coord_att,defenseur,coord_def,pertesA,pertesD,lune,`%lune`,pillageM,pillageC,pillageD,recyclageM,recyclageC,recycleM,recycleC,points,rawdata) VALUES (\'\',\''.$user_data['user_id'].'\',\''.$date.'\',\''.mysql_real_escape_string($attaquant).'\',\''.mysql_real_escape_string($coord_att).'\',\''.mysql_real_escape_string($defenseur).'\',\''.mysql_real_escape_string($coord_def).'\',\''.$pertesA.'\',\''.$pertesD.'\',\''.$lune.'\',\''.$plune[1].'\',\''.$ressources[1].'\',\''.$ressources[2].'\',\''.$ressources[3].'\',\''.$recyclage[1].'\',\''.$recyclage[2].'\',\'0\',\'0\',\''.$points.'\',\''.mysql_real_escape_string($rapport['rawdata']).'\')';//'.mysql_real_escape_string($rapport).'
        $db->sql_query($query);
        
        
        /////////////////////////////////////////////
        // Test enregistrement des rounds du combats
        /////////////////////////////////////////////
//    		$exist = $db->sql_fetch_row($db->sql_query("SELECT id_rc FROM ".TABLE_GAME_PARSEDRC." WHERE dateRC = '".$pub_date."'"));
//			if(!$exist[0]){
//				$db->sql_query("INSERT INTO ".TABLE_GAME_PARSEDRC." (
//						`dateRC`, `nb_rounds`, `victoire`, `pertes_A`, `pertes_D`, `gain_M`, `gain_C`, `gain_D`, `debris_M`, `debris_C`, `lune`
//					) VALUES (
//					 '{$rapport['date']}', '{$rapport['count']}', '{$rapport['win']}', '".$rapport['result']['a_lost']."', '".$rapport['result']['d_lost']."', '".$rapport['result']['win_metal']."', '".$rapport['result']['win_cristal']."', '".$rapport['result']['win_deut']."', '".$rapport['result']['deb_metal']."', '".$rapport['result']['deb_cristal']."', '{$rapport['moon']}'
//					)"
//				);
//				$id_rc = $db->sql_insertid();
//				
//				foreach($rapport['rounds'] as $i => $round){
//					$db->sql_query("INSERT INTO ".TABLE_GAME_PARSEDRCROUND." (
//							`id_rc`, `numround`, `attaque_tir`, `attaque_puissance`, `defense_bouclier`, `attaque_bouclier`, `defense_tir`, `defense_puissance`
//						) VALUE (
//							'{$id_rc}', '{$i}', '".$round['a_nb']."', '".$round['a_shoot']."', '".$round['d_bcl']."', '".$round['a_bcl']."', '".$round['d_nb']."', '".$round['d_shoot']."'
//						)"
//					);
//					$id_rcround[$i] = $db->sql_insertid();
//				}
//				
//				foreach ($rapport['n'] as $i => $n){
//					$fields = '';
//					$values = '';
//					$j = 1;
//					
//					foreach ($n['content'] as $field => $value){
//						$fields .= ", `{$field}`";
//						$values .= ", '{$value}'";
//					}
//					
//					$db->sql_query("INSERT INTO ".(($n['type'] == "D") ? TABLE_GAME_ROUND_DEFENSE : TABLE_GAME_ROUND_ATTACK)." (
//							`id_rcround`, `player`, `coordinates`, `Armes`, `Bouclier`, `Protection`".$fields."
//						) VALUE (
//							'".$id_rcround[$j]."', '".$n['player']."', '".$n['coords']."', '".$n['weapons']['arm']."', '".$n['weapons']['bcl']."', '".$n['weapons']['coq']."'".$values."
//						)"
//					);
//					
//					if($n['type'] == "D"){
//						if(!isset($update))
//							$update = $db->sql_query("UPDATE ".TABLE_GAME_PARSEDRC." SET coordinates = '".$n['coords']."' WHERE id_rc = '{$id_rc}'");
//						$j++;
//					}
//				}
//			}
    }
    return TRUE;
}

function gog_rr($rapport)
{
    global $db, $table_prefix, $user_data, $config;
    $xtense_version="2.3.0";
    //var_dump($rapport);
    //Definition des tables de gOg
    define('TABLE_GAME',$table_prefix.'game');
    define('TABLE_GAME_USERS',$table_prefix.'game_users');
    define('TABLE_GAME_RECYCLAGE',$table_prefix.'game_recyclage');
    //récupération des paramètres de config
    $query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='gameOgame' and `config`='config'";
	$result = $db->sql_query($query);
	$gog_config = mysql_fetch_row($result);
	$gog_config = unserialize($gog_config[0]);
	
    // on boucle dans les RR envoyés
//    for($i=0; $i<count($rapport); $i++)
//    {
    	//On vérifie si le rapport n'a pas déjà été entré
		$query = "SELECT id FROM `".TABLE_GAME_RECYCLAGE."` WHERE `timestamp`=".$rapport['time']." AND `recycleurs`=".$rapport['nombre']." AND `dispoM`=".$rapport['M_total']." AND `dispoC`=".$rapport['C_total']." AND `collecteM`=".$rapport['M_reco']." AND `collecteC`=".$rapport['C_reco'];
		//echo $query;
		$result2 = $db->sql_query($query);
		//On vérifie si on trouve qque chose
        if (mysql_num_rows($result2) != 0)
        {
            echo "Déjà existant<br />";
            return true;
        }
    	//On reconstruit les coordonnées du recyclage
        $coordonne = $rapport['coords'][0].":".$rapport['coords'][1].":".$rapport['coords'][2];
        // on recherche dans les 24h précédentes
        $timestamp = $rapport['time'] - (24*60*60);
        //On cherche dans la db un combat au même coordonnées.
        $query = "SELECT id,sender,recyclageM,recyclageC,recycleM,recycleC FROM `".TABLE_GAME."` WHERE `coord_def`='".$coordonne."' AND `date`>='".$timestamp."' ORDER BY date ASC";
		//echo $query."<br />";
        $result = $db->sql_query($query);
        //On vérifie si on trouve qque chose
        if (mysql_num_rows($result) == 0)
        {
            echo "rien trouvé<br />";
            return true;
        }
		// on boucle dans les RC au cas ou on en trouverais plusieurs
       	while ($row = mysql_fetch_array($result))
       	{
            //On vérifie que celui qui envoi le RR était l'attaquant
            if ($row['sender'] == $user_data['user_id'])
            {
                //On vérifie que tout n'a pas déjà été récolté
                if (($row['recyclageM'] > $row['recycleM']) || ($row['recyclageC'] > $row['recycleC']))
                {
                    //On vérifie que ce qui est dispo dans le champs est au moins égal à ce qu'a généré le RR
                    if (($rapport['M_total'] >= ($row['recyclageM']-$row['recycleM'])) || ($rapport['C_total'] >= ($row['recyclageC']-$row['recycleC'])))
                    {
                        //Ok, je ne vois plus quoi tester ! Inserons les données
                        $query = "INSERT INTO ".TABLE_GAME_RECYCLAGE." (id,rc,recycleurs,capacite,dispoM,dispoC,collecteM,collecteC,timestamp) VALUES ('','".$row['id']."','".$rapport['nombre']."','".(int)floatval(($rapport['nombre']*20000))."','".(int)floatval($rapport['M_total'])."','".(int)floatval($rapport['C_total'])."','".(int)floatval($rapport['M_reco'])."','".(int)floatval($rapport['C_reco'])."','".(int)floatval($rapport['time'])."')";
                        //echo $query."<br />";
                        $db->sql_query($query);
                    
                        $query = 'UPDATE '.TABLE_GAME.' SET recycleM=recycleM+'.(int)floatval($rapport['M_reco']).', recycleC=recycleC+'.(int)floatval($rapport['C_reco']).', points=points+'.((int)floatval($rapport['M_reco'])+(int)floatval($rapport['C_reco']))/100000*$gog_config['recycl'].' WHERE id='.$row['id'];
                        $db->sql_query($query);
                        // On a fait l'insertion ...
                        //je veux pas risquer de trouver un autre rapport et recommencer l'insertion, donc je sort de la boucle While
                        return true;
                    }
                }
            }
        }
//    }
}

function remo_htm($rapport)
{
    $rapport = str_replace("\n"," ",$rapport);
	$rapport = stripslashes($rapport);
    $rapport = html_entity_decode($rapport);
    $rapport = str_replace("<br>"," ",$rapport);
    $rapport = str_replace("<th>"," ",$rapport);
    $rapport = strip_tags($rapport);
    $rapport = str_replace(".","",$rapport);
    //$rapport = str_replace("\n"," ",$rapport);
    // remove double space
	while (!(strpos($rapport,'  ')===FALSE))
	{
			$rapport = str_replace('  ',' ',$rapport);
	}
    
    return $rapport;
}

?>