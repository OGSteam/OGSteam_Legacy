<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
$query = 'SELECT active FROM '.TABLE_MOD.' WHERE action=\'gameOgame\' AND active=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

if (!isUser($user_data['user_id'])) die ('Vous n\'avez pas les droits suffisants pour acc�der � cette page.<br>Demandez � un administrateur de vous ajouter � la liste des participants.');

if (isset($pub_data) && $pub_data<>'')
{	
	$data = stripslashes($pub_data);
	$data = str_replace("\'","'",$data);
	//Compatibilit� UNIX/Windows
	$data = str_replace("\r\n","\n",$data);
	$data = str_replace(" \n","\n",$data);
	//Compatibilit� IE/Firefox
	$data = str_replace("\t",' ',$data);
	$data = str_replace("\n"," ",$data);
    $data = html_entity_decode($data);
    $data = str_replace("<br>"," ",$data);
    $data = str_replace("<th>"," ",$data);
    $data = strip_tags($data);
	//A priori, certains obtiennent des rapports avec de multiples espaces, donc on �limine le probl�me � la base
	cleanDoubleSpace($data);
	//Compatibilit� avec la 0.76
	$data = str_replace(".",'',$data);
	$data = str_replace("\'","'",$data);

	if (!preg_match('#Les\sflottes\ssuivantes\sse\ssont\saffront�es\sle\s(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2}) :#',$data,$date))
	{
		echo 'Rapport de combat invalide';
	} 
	else 
	{
		preg_match('#Attaquant\s(.{3,50})\s\(#',$data,$attaquant);
		//r�cup�re les coordonn�es de l'attaquant
        preg_match('#Attaquant\s.{3,110}\[(.{5,8})]#',$data,$coord_att);
		//On regarde dans les coordonn�es de l'espace personnel du joueur qui ins�re les donn�es via le plugin si les coordonn�es de l'attaquant correspondent � une de ses plan�tes
    	$query = "SELECT coordinates FROM ".TABLE_USER_BUILDING." WHERE user_id='".$user_data['user_id']."'";
    	$result = $db->sql_query($query);
		$attaqu = 0;
    	while(list($coordinates) = mysql_fetch_row($result))
		{
			if($coordinates == $coord_att[1]) $attaqu = 1;
		}
    	if ($attaqu == 0) 
    	{
    		echo "Vous n'�tes pas l'attaquant !! ";
    		//return FALSE;
    	}
    	else
    	{		 
    		preg_match('#D�fenseur\s(.{3,50})\s\(#',$data,$defenseur);
			//r�cup�re les coordonn�es du d�fenseur
			preg_match('#D�fenseur\s.{3,110}\[(.{5,8})]#',$data,$coord_def);
    		
			preg_match('#L\'attaquant\sa\sperdu\sau\stotal\s(\d*)\sunit�s#',$data,$pertesA);
			preg_match('#Le\sd�fenseur\sa\sperdu\sau\stotal\s(\d*)\sunit�s#',$data,$pertesD);
			preg_match('#(\d*)\sunit�s\sde\sm�tal,\s(\d*)\sunit�s\sde\scristal\set\s(\d*)\sunit�s\sde\sdeut�rium#',$data,$ressources);
			if (!preg_match('#Un\schamp\sde\sd�bris\scontenant\s(\d*)\sunit�s\sde\sm�tal\set\s(\d*)\sunit�s\sde\scristal\sse\sforme\sdans\sl\'orbite\sde\scette\splan�te#',$data,$recyclage)) $recyclage[1]=$recyclage[2]=0; 
			if (!preg_match('#La\sprobabilit�\sde\scr�ation\sd\'une\slune\sest\sde\s(\d*)\s%#',$data,$plune)) $plune[1] = 0;
			$lune = preg_match('#Les\squantit�s\s�normes\sde\sm�tal\set\sde\scristal\ss\'attirent,\sformant\sainsi\sune\slune\sdans\sl\'orbite\sde\scette\splan�te#',$data);
			$date = mktime($date[3],$date[4],$date[5],$date[1],$date[2],date('Y'));
			$points = ceil(($ressources[1]+$ressources[2]+$ressources[3])/100000*$config['pillage'] + $pertesA[1]/100000*$config['pertes'] + $pertesD[1]/100000*$config['degats'] + $lune*$config['clune']);
			//On v�rifie que cette attaque n'a pas d�ja �t� enregistr�e
        	$query = "SELECT id FROM ".TABLE_GAME." WHERE sender='".$user_data['user_id']."' AND date='".$date."' AND attaquant='".$attaquant[1]."' ";
			$result = $db->sql_query($query);
			$nb = mysql_num_rows($result);
			// Si le RC existe d�j� on sort
			if ($nb != 0)
			{
				echo "Le rapport de combat existe d�j� !!";
			}
			else
			{
				$sql = 'INSERT INTO '.TABLE_GAME.' (id,sender,date,attaquant,coord_att,defenseur,coord_def,pertesA,pertesD,lune,`%lune`,pillageM,pillageC,pillageD,recyclageM,recyclageC,recycleM,recycleC,points,rawdata) VALUES (\'\',\''.$user_data['user_id'].'\',\''.$date.'\',\''.mysql_real_escape_string($attaquant[1]).'\',\''.mysql_real_escape_string($coord_att[1]).'\',\''.mysql_real_escape_string($defenseur[1]).'\',\''.mysql_real_escape_string($coord_def[1]).'\',\''.$pertesA[1].'\',\''.$pertesD[1].'\',\''.$lune.'\',\''.$plune[1].'\',\''.$ressources[1].'\',\''.$ressources[2].'\',\''.$ressources[3].'\',\''.$recyclage[1].'\',\''.$recyclage[2].'\',\'0\',\'0\',\''.$points.'\',\''.mysql_real_escape_string($data).'\')';
				$db->sql_query($sql);
		
				echo 'Rapport charg� avec succ�s<br><br>Compte-rendu du traitement:<br>';
				echo 'Rapport du '.date('d/m/Y H:m:s',$date).' envoy� par '.$user_data['user_name'].'<br>';
				echo $attaquant[1].' vs. '.$defenseur[1].'<br>';
				echo 'Pertes attaquant: '.convNumber($pertesA[1]).' unit�s ('.convNumber($pertesA[1]/100000*$config['pertes']).' points)<br>';
				echo 'Pertes d�fenseur: '.convNumber($pertesD[1]).' unit�s ('.convNumber($pertesD[1]/100000*$config['degats']).' points)<br>';
				echo 'Pillage: '.convNumber($ressources[1]).' m�tal ('.convNumber($ressources[1]/100000*$config['pillage']).' points), '.convNumber($ressources[2]).' cristal ('.convNumber($ressources[2]/100000*$config['pillage']).' points), '.convNumber($ressources[3]).' deut�rium ('.convNumber($ressources[3]/100000*$config['pillage']).' points)<br>';
				echo 'Recyclage possible: '.convNumber($recyclage[1]).' m�tal, '.convNumber($recyclage[2]).' cristal<br>';
				echo 'Pourcentage de cr�ation de lune: '.$plune[1].'%<br>';
				if ($lune) echo 'Une lune a �t� cr��e ('.$config['clune'].' points)<br>'; else echo 'Pas de lune cr��e (0 point)<br>';
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
