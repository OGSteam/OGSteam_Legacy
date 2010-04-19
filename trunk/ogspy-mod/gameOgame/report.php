<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
$query = 'SELECT active FROM '.TABLE_MOD.' WHERE action=\'gameOgame\' AND active=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

if (!isUser($user_data['user_id'])) die ('Vous n\'avez pas les droits suffisants pour accéder à cette page.<br>Demandez à un administrateur de vous ajouter à la liste des participants.');

if (isset($pub_data) && $pub_data<>'')
{	
	$data = stripslashes($pub_data);
	$data = str_replace("\'","'",$data);
	//Compatibilité UNIX/Windows
	$data = str_replace("\r\n","\n",$data);
	$data = str_replace(" \n","\n",$data);
	//Compatibilité IE/Firefox
	$data = str_replace("\t",' ',$data);
	$data = str_replace("\n"," ",$data);
    $data = html_entity_decode($data);
    $data = str_replace("<br>"," ",$data);
    $data = str_replace("<th>"," ",$data);
    $data = strip_tags($data);
	//A priori, certains obtiennent des rapports avec de multiples espaces, donc on élimine le problème à la base
	cleanDoubleSpace($data);
	//Compatibilité avec la 0.76
	$data = str_replace(".",'',$data);
	$data = str_replace("\'","'",$data);

	if (!preg_match('#Les\sflottes\ssuivantes\sse\ssont\saffrontées\sle\s(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2}) :#',$data,$date))
	{
		echo 'Rapport de combat invalide';
	} 
	else 
	{
		preg_match('#Attaquant\s(.{3,50})\s\(#',$data,$attaquant);
		//récupère les coordonnées de l'attaquant
        preg_match('#Attaquant\s.{3,110}\[(.{5,8})]#',$data,$coord_att);
		//On regarde dans les coordonnées de l'espace personnel du joueur qui insère les données via le plugin si les coordonnées de l'attaquant correspondent à une de ses planètes
    	$query = "SELECT coordinates FROM ".TABLE_USER_BUILDING." WHERE user_id='".$user_data['user_id']."'";
    	$result = $db->sql_query($query);
		$attaqu = 0;
    	while(list($coordinates) = mysql_fetch_row($result))
		{
			if($coordinates == $coord_att[1]) $attaqu = 1;
		}
    	if ($attaqu == 0) 
    	{
    		echo "Vous n'êtes pas l'attaquant !! ";
    		//return FALSE;
    	}
    	else
    	{		 
    		preg_match('#Défenseur\s(.{3,50})\s\(#',$data,$defenseur);
			//récupère les coordonnées du défenseur
			preg_match('#Défenseur\s.{3,110}\[(.{5,8})]#',$data,$coord_def);
    		
			preg_match('#L\'attaquant\sa\sperdu\sau\stotal\s(\d*)\sunités#',$data,$pertesA);
			preg_match('#Le\sdéfenseur\sa\sperdu\sau\stotal\s(\d*)\sunités#',$data,$pertesD);
			preg_match('#(\d*)\sunités\sde\smétal,\s(\d*)\sunités\sde\scristal\set\s(\d*)\sunités\sde\sdeutérium#',$data,$ressources);
			if (!preg_match('#Un\schamp\sde\sdébris\scontenant\s(\d*)\sunités\sde\smétal\set\s(\d*)\sunités\sde\scristal\sse\sforme\sdans\sl\'orbite\sde\scette\splanète#',$data,$recyclage)) $recyclage[1]=$recyclage[2]=0; 
			if (!preg_match('#La\sprobabilité\sde\scréation\sd\'une\slune\sest\sde\s(\d*)\s%#',$data,$plune)) $plune[1] = 0;
			$lune = preg_match('#Les\squantités\sénormes\sde\smétal\set\sde\scristal\ss\'attirent,\sformant\sainsi\sune\slune\sdans\sl\'orbite\sde\scette\splanète#',$data);
			$date = mktime($date[3],$date[4],$date[5],$date[1],$date[2],date('Y'));
			$points = ceil(($ressources[1]+$ressources[2]+$ressources[3])/100000*$config['pillage'] + $pertesA[1]/100000*$config['pertes'] + $pertesD[1]/100000*$config['degats'] + $lune*$config['clune']);
			//On vérifie que cette attaque n'a pas déja été enregistrée
        	$query = "SELECT id FROM ".TABLE_GAME." WHERE sender='".$user_data['user_id']."' AND date='".$date."' AND attaquant='".$attaquant[1]."' ";
			$result = $db->sql_query($query);
			$nb = mysql_num_rows($result);
			// Si le RC existe déjà on sort
			if ($nb != 0)
			{
				echo "Le rapport de combat existe déjà !!";
			}
			else
			{
				$sql = 'INSERT INTO '.TABLE_GAME.' (id,sender,date,attaquant,coord_att,defenseur,coord_def,pertesA,pertesD,lune,`%lune`,pillageM,pillageC,pillageD,recyclageM,recyclageC,recycleM,recycleC,points,rawdata) VALUES (\'\',\''.$user_data['user_id'].'\',\''.$date.'\',\''.mysql_real_escape_string($attaquant[1]).'\',\''.mysql_real_escape_string($coord_att[1]).'\',\''.mysql_real_escape_string($defenseur[1]).'\',\''.mysql_real_escape_string($coord_def[1]).'\',\''.$pertesA[1].'\',\''.$pertesD[1].'\',\''.$lune.'\',\''.$plune[1].'\',\''.$ressources[1].'\',\''.$ressources[2].'\',\''.$ressources[3].'\',\''.$recyclage[1].'\',\''.$recyclage[2].'\',\'0\',\'0\',\''.$points.'\',\''.mysql_real_escape_string($data).'\')';
				$db->sql_query($sql);
		
				echo 'Rapport chargé avec succès<br><br>Compte-rendu du traitement:<br>';
				echo 'Rapport du '.date('d/m/Y H:m:s',$date).' envoyé par '.$user_data['user_name'].'<br>';
				echo $attaquant[1].' vs. '.$defenseur[1].'<br>';
				echo 'Pertes attaquant: '.convNumber($pertesA[1]).' unités ('.convNumber($pertesA[1]/100000*$config['pertes']).' points)<br>';
				echo 'Pertes défenseur: '.convNumber($pertesD[1]).' unités ('.convNumber($pertesD[1]/100000*$config['degats']).' points)<br>';
				echo 'Pillage: '.convNumber($ressources[1]).' métal ('.convNumber($ressources[1]/100000*$config['pillage']).' points), '.convNumber($ressources[2]).' cristal ('.convNumber($ressources[2]/100000*$config['pillage']).' points), '.convNumber($ressources[3]).' deutérium ('.convNumber($ressources[3]/100000*$config['pillage']).' points)<br>';
				echo 'Recyclage possible: '.convNumber($recyclage[1]).' métal, '.convNumber($recyclage[2]).' cristal<br>';
				echo 'Pourcentage de création de lune: '.$plune[1].'%<br>';
				if ($lune) echo 'Une lune a été créée ('.$config['clune'].' points)<br>'; else echo 'Pas de lune créée (0 point)<br>';
				echo '<br>Ce rapport rapporte <font size=\'5\' color=\'red\'>'.convNumber(ceil($points)).'</font> points';
			}
    	}
    }
	echo '<br><a href=\'?action=gameOgame&subaction=stats\'>Retour</a>';
} else {?>
Collez ici votre rapport de combat brut:<br>
<form method='post' action='?action=gameOgame&subaction=report'>
<textarea name='data' rows='20' cols='100'></textarea><br>
<input type='submit' value='Envoyer'>
</form>
<?php
}
?>
