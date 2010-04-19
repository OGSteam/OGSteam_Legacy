<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
$query = 'SELECT active FROM '.TABLE_MOD.' WHERE action=\'gameOgame\' AND active=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

function affFlotte($data)
{
	$array = split(' ',$data);
	foreach ($array as $vaisseau)
	{
		if (is_int($vaisseau))
		{
			echo '<th>'.convNumber($vaisseau).'</th>';
		} else {
			echo '<th>'.$vaisseau.'</th>';
		}
	}
}
// Supprime les tags html et autres cochonneries
function remo_htm($rapport)
{
    $rapport = str_replace("\n"," ",$rapport);
    $rapport = stripslashes($rapport);
    $rapport = html_entity_decode($rapport);
    $rapport = str_replace("<br>"," ",$rapport);
    $rapport = str_replace("<th>"," ",$rapport);
    $rapport = strip_tags($rapport);
    $rapport = str_replace(".","",$rapport);
	// remove double space
	while (!(strpos($rapport,'  ')===FALSE))
	{
		$rapport = str_replace('  ',' ',$rapport);
	}
    return $rapport;
}

function nbVaisseaux($data)
{
	return(count(split(' ',$data)));
}

function displayRC($id)
{
	global $db, $config;

	$id = (int)$id;
	$sql = 'SELECT * FROM '.TABLE_GAME.' WHERE id=\''.$id.'\'';
	$result = $db->sql_query($sql);
	if (!$db->sql_numrows($result))
	{
		echo 'Rapport introuvable';
	} else {
		$val = $db->sql_fetch_assoc($result);
		$val['rawdata'] = str_replace("\r\n","\n",$val['rawdata']);
		$val['rawdata'] = str_replace(" \n","\n",$val['rawdata']);
		$val['rawdata'] = remo_htm($val['rawdata']);
		
		$total = 'Total recyclé: '.convNumber($val['recycleM']).' de métal et '.convNumber($val['recycleC']).' de cristal';
		@$precyclage = 'Recyclé à '.ceil(($val['recycleM'] + $val['recycleC'])/($val['recyclageM'] + $val['recyclageC'])*100).'%';
		$points = $val['points'];
		echo 'Rapport envoyé par '.userNameById($val['sender']).'<br>Ce rapport rapporte <font size=\'5\' color=\'lime\'>'.convNumber(ceil($points)).'</font> points<br><br>';
		echo '<center>Les flottes suivantes se sont affrontées le '.date('H:i:s d/m/Y',$val['date']).':<center><br>';

        // Si les coordonnées de l'attaquant ne sont pas dans la base de données, on va les chercher dans le rapport
        if (($val['coord_att'] == "") || (!isset($val['coord_att'])))
        {
            preg_match('#Attaquant\s.{3,110}\[(.{5,8})]#',$val['rawdata'],$coord_att);
            $val['coord_att'] = $coord_att[1];
        }
        // Si les coordonnées du défenseur ne sont pas dans la base de données, on va les chercher dans le rapport
        if (($val['coord_def'] == "") || (!isset($val['coord_def'])))
        {
            preg_match('#Défenseur\s.{3,110}\[(.{5,8})]#',$val['rawdata'],$coord_def);
            $val['coord_def'] = $coord_def[1];
        }

        $nbRound['A'] = preg_match_all('#Attaquant\s.*?\sType\s(.*?)\sNombre\s(.*?)\sArmes.*?Défenseur#',$val['rawdata'],$attaquant,PREG_SET_ORDER);
        preg_match('#Attaquant.*\s(Armes:\s\d{2,}%\sBouclier:\s\d{2,}%\sCoque:\s\d{2,}%)#',$val['rawdata'],$techno);
        if (isset($techno[1])) {$techn['A'] = $techno[1];} else {$techn['A']="";}
        //echo $techn['A'];
        $nbRound['D'] = preg_match_all('#Défenseur\s.*?\sType\s(.*?)\sNombre\s(.*?)\sArmes#',$val['rawdata'],$defenseur,PREG_SET_ORDER);

        preg_match('#Défenseur.*\s(Armes:\s\d{2,}%\sBouclier:\s\d{2,}%\sCoque:\s\d{2,}%)#',$val['rawdata'],$techno);
        if (isset($techno[1])) {$techn['D'] = $techno[1];} else {$techn['D']="";}

		// Etat des flottes au 1er tour
		if ($nbRound['D'] !=0 )
		{
		echo '<table align=\'center\'><tr>';
		echo '<td class=\'c\' align=\'center\' colspan=\''.nbVaisseaux($attaquant[0][1]).'\'>Attaquant: '.$val['attaquant'].' ('.$val['coord_att'].')</td>';
		echo '</tr><tr>';
		echo '<td class=\'c\' align=\'center\' colspan=\''.nbVaisseaux($attaquant[0][1]).'\'>'.$techn['A'].'</td>';
		echo '</tr><tr>';
		affFlotte($attaquant[0][1]);
		echo '</tr><tr>';
		affFlotte($attaquant[0][2]);
		echo '</tr></table>';	
		echo '<table align=\'center\'><tr>';
		echo '<td class=\'c\' align=\'center\' colspan=\''.nbVaisseaux($defenseur[0][1]).'\'>Défenseur: '.$val['defenseur'].' ('.$val['coord_def'].')</td>';
		echo '</tr><tr>';
		echo '<td class=\'c\' align=\'center\' colspan=\''.nbVaisseaux($defenseur[0][1]).'\'>'.$techn['D'].'</td>';
		echo '</tr><tr>';
		affFlotte($defenseur[0][1]);
		echo '</tr><tr>';
		affFlotte($defenseur[0][2]);
		echo '</tr></table><br>';
		}
		$nbTour = (($nbRound['A']==7) && ($nbRound['D']==7)) ? 6 : min($nbRound['A'],$nbRound['D']);
		if ($nbRound['A'] == $nbRound['D']){ $nbTour = $nbTour - 1; }
		echo '<center>Après '.$nbTour. ' tours...</center><br>';

		// Etat des flottes au dernier tour
		echo '<table align=\'center\'><tr>';
		echo '<td class=\'c\' align=\'center\' colspan=\''.((($nbTour == $nbRound['D']) || ($nbRound['D'] == $nbRound['A'])) ? nbVaisseaux($attaquant[$nbTour][1]) : 1).'\'>Attaquant: '.$val['attaquant'].' ('.$val['coord_att'].')</td>';
        echo '</tr><tr>';
		echo '<td class=\'c\' align=\'center\' colspan=\''.nbVaisseaux($attaquant[0][1]).'\'>'.$techn['A'].'</td>';
        echo '</tr><tr>';
		if (($nbTour == $nbRound['D']) || ($nbRound['D'] == $nbRound['A']))
		{
			affFlotte($attaquant[$nbTour][1]);
			echo '</tr><tr>';
			affFlotte($attaquant[$nbTour][2]);
		} else {
			echo '<th>Détruit</th>';
		}
		echo '</tr></table>';	
		echo '<table align=\'center\'><tr>';
		echo '<td class=\'c\' align=\'center\' colspan=\''.((($nbTour == $nbRound['A']) || ($nbRound['D'] == $nbRound['A'])) ? nbVaisseaux($defenseur[$nbTour][1]) : 1).'\'>Défenseur: '.$val['defenseur'].' ('.$val['coord_def'].')</td>';
		echo '</tr><tr>';
		echo '<td class=\'c\' align=\'center\' colspan=\''.((($nbTour == $nbRound['A']) || ($nbRound['D'] == $nbRound['A'])) ? nbVaisseaux($defenseur[$nbTour][1]) : 1).'\'>'.$techn['D'].'</td>';
		echo '</tr><tr>';
		if (($nbTour == $nbRound['A']) || ($nbRound['D'] == $nbRound['A']))
		{
			affFlotte($defenseur[$nbTour][1]);
			echo '</tr><tr>';
			affFlotte($defenseur[$nbTour][2]);
		} else {
			echo '<th>Détruit</th>';
		}
		echo '</tr></table><br>';
		echo '<table align=\'center\'><tr><th align=\'center\'>';
		echo 'L\'attaquant a perdu <font size=\'5\' color=\'red\'>'.convNumber($val['pertesA']).'</font> points<br>';
		echo 'Le défenseur a perdu <font size=\'5\' color=\'red\'>'.convNumber($val['pertesD']).'</font> points';
		if ($val['pillageM']+$val['pillageC']+$val['pillageD']>0) echo '<br>L\'attaquant emporte  <font size=\'5\' color=\'red\'>'.convNumber($val['pillageM']).'</font> métal, <font size=\'5\' color=\'red\'>'.convNumber($val['pillageC']).'</font> cristal et  <font size=\'5\' color=\'red\'>'.convNumber($val['pillageD']).'</font> deutérium';
		if ($val['recyclageM']+$val['recyclageC']>0) echo '<br>Un champ de débris contenant <font size=\'5\' color=\'red\'>'.convNumber($val['recyclageM']).'</font> métal et <font size=\'5\' color=\'red\'>'.convNumber($val['recyclageC']).'</font> cristal se forme dans l\'orbite dans la planète';
		if ($val['%lune']>0) echo '<br>La probabilité de création de lune est de <font size=\'5\' color=\'red\'>'.$val['%lune'].'%</font>';
		if ($val['lune']) echo '<br><font size=\'5\' color=\'red\'>Une lune s\'est formée dans l\'orbite de la planète!!!</font>';
		echo '</th></tr></table>';

		$sql = 'SELECT * FROM '.TABLE_GAME_RECYCLAGE.' WHERE rc=\''.$val['id'].'\' ORDER BY id ASC';
		$result = $db->sql_query($sql);
		if ($db->sql_numrows($result))
		{
			echo '<br><table><tr><td class=\'c\'>Rapports de recyclage</td></tr>';
			while( $val = $db->sql_fetch_assoc($result))
			{
				echo '<tr><th>'.convNumber($val['recycleurs']).' recycleurs arrivent sur le champ de débris.<br>Celui-ci contient '.convNumber($val['dispoM']).' de métal et '.convNumber($val['dispoC']).' de cristal<br>Ils repartent avec '.convNumber($val['collecteM']).' de métal et '.convNumber($val['collecteC']).' de cristal</th></tr>';
			}
			echo '<tr><td class=\'c\'>'.$total.'<br>'.$precyclage.'</td></tr></table>';
		}	
	}
}

echo $pub_displayRC."<br />";
displayRC($pub_displayRC);
?>