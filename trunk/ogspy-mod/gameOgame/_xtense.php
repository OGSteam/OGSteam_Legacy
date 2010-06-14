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
        public $version = '2.3.0';
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
    global $db, $table_prefix, $user_data;
    $xtense_version="2.3.0";
    //Definition des tables de gOg
    define('TABLE_GAME',$table_prefix.'game');
    //récupération des paramètres de config
	$query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='gameOgame' and `config`='config'";
	$result = $db->sql_query($query);
	$config = $db->sql_fetch_row($result);
	$gog_config = unserialize($config[0]);
	
	foreach($rapport['n'] as $n){
		if ($n['type'] == "A"){
			$query = $db->sql_query("SELECT count(planet_id) FROM ".TABLE_USER_BUILDING." WHERE user_id = '".$user_data['user_id']."' AND coordinates = '".$n['coords']."'");
			list($check) = $db->sql_fetch_row($query);
			if($check != 0){
				$attaquant = $n['player'];
				$coord_att = $n['coords'];
				break;
			}
		}
	}
	
	foreach($rapport['n'] as $n){
		if ($n['type'] == "D"){
			$defenseur = $n['player'];
			$coord_def = $n['coords'];
			break;
		}
	}

	//Calcul des points en fonction des coeficients
	$points = ceil(($rapport['result']['win_metal']+$rapport['result']['win_cristal']+$rapport['result']['win_deut'])/100000*$gog_config['pillage'] + $rapport['result']['a_lost']/100000*$gog_config['pertes'] + $rapport['result']['d_lost']/100000*$gog_config['degats'] + $rapport['moon']*$gog_config['clune']);
	//On vérifie que cette attaque n'a pas déja été enregistrée
	$query = "SELECT id FROM ".TABLE_GAME." WHERE sender='".$user_data['user_id']."' AND date='".$rapport['date']."' AND attaquant='".$attaquant."' ";
	$result = $db->sql_query($query);
	$nb = $db->sql_numrows($result);
	// Si le RC existe déjà on sort
	if ($nb == 0){
		//Insert dans la base de données
		$query = "INSERT INTO ".TABLE_GAME." 
				(sender, date, attaquant, coord_att, defenseur, coord_def, pertesA, pertesD, lune, `%lune`, pillageM, pillageC, pillageD, recyclageM, recyclageC, recycleM, recycleC, points, rawdata) 
			VALUES 
				('".$user_data['user_id']."', '".$rapport['date']."', '".$attaquant."', '".$coord_att."', '".$defenseur."', '".$coord_def."', '".$rapport['result']['a_lost']."', '".$rapport['result']['d_lost']."', '".$rapport['moon']."', '".($rapport['moon']*100)."', '".$rapport['result']['win_metal']."', '".$rapport['result']['win_cristal']."', '".$rapport['result']['win_deut']."', '".$rapport['result']['deb_metal']."', '".$rapport['result']['deb_cristal']."', '0', '0', '".$points."', '".(string)$rapport."')";
		$db->sql_query($query);
	}	
    return TRUE;
}

function gog_rr($rapport)
{
    global $db, $table_prefix, $user_data;
    $xtense_version="2.3.0";
    //var_dump($rapport);
    //Definition des tables de gOg
    define('TABLE_GAME',$table_prefix.'game');
    define('TABLE_GAME_USERS',$table_prefix.'game_users');
    define('TABLE_GAME_RECYCLAGE',$table_prefix.'game_recyclage');
    //récupération des paramètres de config
    $query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='gameOgame' and `config`='config'";
	$result = $db->sql_query($query);
	$gog_config = $db->sql_fetch_row($result);
	$gog_config = unserialize($gog_config[0]);
	
    // on boucle dans les RR envoyés
    for($i=0; $i<count($rapport); $i++)
    {
    	//On vérifie si le rapport n'a pas déjà été entré
		$query = "SELECT id FROM `".TABLE_GAME_RECYCLAGE."` WHERE `timestamp`=".$rapport[$i]['time']." AND `recycleurs`=".$rapport[$i]['nombre']." AND `dispoM`=".$rapport[$i]['M_total']." AND `dispoC`=".$rapport[$i]['C_total']." AND `collecteM`=".$rapport[$i]['M_reco']." AND `collecteC`=".$rapport[$i]['C_reco'];
		//echo $query;
		$result2 = $db->sql_query($query);
		//On vérifie si on trouve qque chose
        if ($db->sql_numrows($result2) != 0)
        {
            //echo "Déjà existant<br />";
            return;
        }
    	//On reconstruit les coordonnées du recyclage
        $coordonne = $rapport[$i]['coords'][0].":".$rapport[$i]['coords'][1].":".$rapport[$i]['coords'][2];
        // on recherche dans les 24h précédentes
        $timestamp = $rapport[$i]['time'] - (24*60*60);
        //On cherche dans la db un combat au même coordonnées.
        $query = "SELECT id,sender,recyclageM,recyclageC,recycleM,recycleC FROM `".TABLE_GAME."` WHERE `coord_def`='".$coordonne."' AND `date`>='".$timestamp."' ORDER BY date ASC";
		//echo $query."<br />";
        $result = $db->sql_query($query);
        //On vérifie si on trouve qque chose
        if ($db->sql_numrows($result) == 0)
        {
            //echo "rien trouvé<br />";
            return;
        }
		// on boucle dans les RC au cas ou on en trouverais plusieurs
       	while ($row = $db->sql_fetch_assoc($result))
       	{
            //On vérifie que celui qui envoi le RR était l'attaquant
            if ($row['sender'] == $user_data['user_id'])
            {
                //On vérifie que tout n'a pas déjà été récolté
                if (($row['recyclageM'] > $row['recycleM']) || ($row['recyclageC'] > $row['recycleC']))
                {
                    //On vérifie que ce qui est dispo dans le champs est au moins égal à ce qu'a généré le RR
                    if (($rapport[$i]['M_total'] >= ($row['recyclageM']-$row['recycleM'])) || ($rapport[$i]['C_total'] >= ($row['recyclageC']-$row['recycleC'])))
                    {
                        //Ok, je ne vois plus quoi tester ! Inserons les données
                        $query = "INSERT INTO ".TABLE_GAME_RECYCLAGE." (id,rc,recycleurs,capacite,dispoM,dispoC,collecteM,collecteC,timestamp) VALUES ('','".$row['id']."','".$rapport[$i]['nombre']."','".(int)floatval(($rapport[$i]['nombre']*20000))."','".(int)floatval($rapport[$i]['M_total'])."','".(int)floatval($rapport[$i]['C_total'])."','".(int)floatval($rapport[$i]['M_reco'])."','".(int)floatval($rapport[$i]['C_reco'])."','".(int)floatval($rapport[$i]['time'])."')";
                        //echo $query."<br />";
                        $db->sql_query($query);
                    
                        $query = 'UPDATE '.TABLE_GAME.' SET recycleM=recycleM+'.(int)floatval($rapport[$i]['M_reco']).', recycleC=recycleC+'.(int)floatval($rapport[$i]['C_reco']).', points=points+'.((int)floatval($rapport[$i]['M_reco'])+(int)floatval($rapport[$i]['C_reco']))/100000*$gog_config['recycl'].' WHERE id='.$row['id'];
                        $db->sql_query($query);
                        // On a fait l'insertion ...
                        //je veux pas risquer de trouver un autre rapport et recommencer l'insertion, donc je sort de la boucle While
                        break 1;
                    }
                }
            }
        }
    }
}

?>