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
        public $version = '2.0b8';
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
$xtense_version="2.0b5";

// Import des Rapports de combats
function gog_rc($rapport)
{
    global $sql, $table_prefix, $user, $config;
    $xtense_version="2.0b5";
    $raw = stripslashes($rapport["content"]);
    $raw = str_replace("\'","'",$raw);
    //Compatibilité UNIX/Windows
    $raw = str_replace("\r\n","\n",$raw);
    $raw = str_replace(" \n","\n",$raw);
    //Compatibilité IE/Firefox
    $raw = str_replace("\t",' ',$raw);
    // Mise en forme du rapport, nettoyage des codes html et autres 
    $rapport = remo_htm($raw);
    /*$handle=fopen("gog.txt","w");
    fwrite($handle,$raw);
    fwrite($handle,"--------\n");
	fwrite($handle,$rapport);
   //fwrite($handle,"\r\n");
   //fwrite($handle,$config[defenseur]);
   //fwrite($handle,"\r\n");  */
    
    //Definition des tables de gOg
    define('TABLE_GAME',$table_prefix.'game');
    //récupération des paramètres de config
	$query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='gameOgame' and `config`='config'";
	$result = $sql->query($query);
	$config = mysql_fetch_row($result);
	$gog_config = unserialize($config[0]);
	
    // Vérifie que c'est bien un RC valide
    if (!preg_match('#Les\sflottes\ssuivantes\sse\ssont\saffrontées\sle\s(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2}) :#',$rapport,$date))
    {
        echo 'Rapport de combat invalide';
        return FALSE;
    }
    else
    {
        //récupère le pseudo de l'attaquant
        preg_match('#Attaquant\s(.{3,50})\s\(#',$rapport,$attaquant);
        //récupère les coordonnées de l'attaquant
        preg_match('#Attaquant\s.{3,110}\[(.{5,8})]#',$rapport,$coord_att);
        //On regarde dans les coordonnées de l'espace personnel du joueur qui insère les données via le plugin si les coordonnées de l'attaquant correspondent à une de ses planètes
    	$query = "SELECT coordinates FROM ".TABLE_USER_BUILDING." WHERE user_id='".$user['id']."'";
    	$result = $sql->query($query);
		/*$attaqu = 0;
    	while(list($coordinates) = mysql_fetch_row($result))
		{
			if($coordinates == $coord_att[1]) $attaqu = 1;
		}
    	if ($attaqu == 0)
    	{
    		// Vous n'êtes pas l'attaquant, je sors !!
    		return FALSE;
    	} */
    	//récupère le pseudo du défenseur
        preg_match('#Défenseur\s(.{3,50})\s\(#',$rapport,$defenseur);
        //récupère les coordonnées du défenseur
        preg_match('#Défenseur\s.{3,110}\[(.{5,8})]#',$rapport,$coord_def);
        // Récupère les pertes de l'attaquant et du défenseur
        preg_match('#attaquant\sa\sperdu\sau\stotal\s(\d*)\sunités#',$rapport,$pertesA);
        preg_match('#Le\sdéfenseur\sa\sperdu\sau\stotal\s(\d*)\sunités#',$rapport,$pertesD);
        //preg_match('#(\d*)\sunités\sde\smétal,\s(\d*)\sunités\sde\scristal\set\s(\d*)\sunités\sde\sdeutérium#',$rapport,$ressources);
        if (!preg_match('#(\d*)\sunités\sde\smétal,\s(\d*)\sunités\sde\scristal\set\s(\d*)\sunités\sde\sdeutérium#',$rapport,$ressources)) $ressources=Array(0,0,0,0);
        if (!preg_match('#Un\schamp\sde\sdébris\scontenant\s(\d*)\sunités\sde\smétal\set\s(\d*)\sunités\sde\scristal\sse\sforme\sdans\sl\'orbite\sde\scette\splanète#',$rapport,$recyclage)) $recyclage[1]=$recyclage[2]=0;
        if (!preg_match('#La\sprobabilité\sde\scréation\sd\'une\slune\sest\sde\s(\d*)\s%#',$rapport,$plune)) $plune[1] = 0;
        $lune = preg_match('#Les\squantités\sénormes\sde\smétal\set\sde\scristal\ss\'attirent,\sformant\sainsi\sune\slune\sdans\sl\'orbite\sde\scette\splanète#',$rapport);
        // calcul la date et l'heure du rapport
        $date = mktime($date[3],$date[4],$date[5],$date[1],$date[2],date('Y'));
        //Calcul des points en fonction des coeficients
        $points = ceil(($ressources[1]+$ressources[2]+$ressources[3])/100000*$gog_config['pillage'] + $pertesA[1]/100000*$gog_config['pertes'] + $pertesD[1]/100000*$gog_config['degats'] + $lune*$gog_config['clune']);
        //On vérifie que cette attaque n'a pas déja été enregistrée
        $query = "SELECT id FROM ".TABLE_GAME." WHERE sender='".$user['id']."' AND date='".$date."' AND attaquant='".$attaquant[1]."' ";
        $result = $sql->query($query);
        $nb = mysql_num_rows($result);
        // Si le RC existe déjà on sort
        if ($nb != 0) return FALSE;
        //Insert dans la base de données
        $query = 'INSERT INTO '.TABLE_GAME.' (id,sender,date,attaquant,coord_att,defenseur,coord_def,pertesA,pertesD,lune,`%lune`,pillageM,pillageC,pillageD,recyclageM,recyclageC,recycleM,recycleC,points,rawdata) VALUES (\'\',\''.$user['id'].'\',\''.$date.'\',\''.mysql_real_escape_string($attaquant[1]).'\',\''.mysql_real_escape_string($coord_att[1]).'\',\''.mysql_real_escape_string($defenseur[1]).'\',\''.mysql_real_escape_string($coord_def[1]).'\',\''.$pertesA[1].'\',\''.$pertesD[1].'\',\''.$lune.'\',\''.$plune[1].'\',\''.$ressources[1].'\',\''.$ressources[2].'\',\''.$ressources[3].'\',\''.$recyclage[1].'\',\''.$recyclage[2].'\',\'0\',\'0\',\''.$points.'\',\''.mysql_real_escape_string($rapport).'\')';
        $sql->query($query);
    }
    return TRUE;
}

function gog_rr($rapport)
{
    global $sql, $table_prefix, $user, $config;
    $xtense_version="2.0b5";
    //var_dump($rapport);
    //Definition des tables de gOg
    define('TABLE_GAME',$table_prefix.'game');
    define('TABLE_GAME_USERS',$table_prefix.'game_users');
    define('TABLE_GAME_RECYCLAGE',$table_prefix.'game_recyclage');
    //récupération des paramètres de config
    $query = "SELECT value FROM `".TABLE_MOD_CFG."` WHERE `mod`='gameOgame' and `config`='config'";
	$result = $sql->query($query);
	$gog_config = mysql_fetch_row($result);
	$gog_config = unserialize($gog_config[0]);
	
    // on boucle dans les RR envoyés
    for($i=0; $i<count($rapport); $i++)
    {
    	//On vérifie si le rapport n'a pas déjà été entré
		$query = "SELECT id FROM `".TABLE_GAME_RECYCLAGE."` WHERE `timestamp`=".$rapport[$i]['time']." AND `recycleurs`=".$rapport[$i]['nombre']." AND `dispoM`=".$rapport[$i]['M_total']." AND `dispoC`=".$rapport[$i]['C_total']." AND `collecteM`=".$rapport[$i]['M_reco']." AND `collecteC`=".$rapport[$i]['C_reco'];
		//echo $query;
		$result2 = $sql->query($query);
		//On vérifie si on trouve qque chose
        if (mysql_num_rows($result2) != 0)
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
        $result = $sql->query($query);
        //On vérifie si on trouve qque chose
        if (mysql_num_rows($result) == 0)
        {
            //echo "rien trouvé<br />";
            return;
        }
		// on boucle dans les RC au cas ou on en trouverais plusieurs
       	while ($row = mysql_fetch_array($result))
       	{
            //On vérifie que celui qui envoi le RR était l'attaquant
            if ($row['sender'] == $user['id'])
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
                        $sql->query($query);
                    
                        $query = 'UPDATE '.TABLE_GAME.' SET recycleM=recycleM+'.(int)floatval($rapport[$i]['M_reco']).', recycleC=recycleC+'.(int)floatval($rapport[$i]['C_reco']).', points=points+'.((int)floatval($rapport[$i]['M_reco'])+(int)floatval($rapport[$i]['C_reco']))/100000*$gog_config['recycl'].' WHERE id='.$row['id'];
                        $sql->query($query);
                        // On a fait l'insertion ...
                        //je veux pas risquer de trouver un autre rapport et recommencer l'insertion, donc je sort de la boucle While
                        break 1;
                    }
                }
            }
        }
    }
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