<?php



/**
 * AutoPub
 */ 
function page_footer() {
global $db;
	
	//Récupére le numéro de version du mod
	$request = 'SELECT `version` from OGSPY_MOD WHERE title=\'varAlly\'';
	$result = $db->query($request);
	list($version) = $db->fetch_row($result);
	echo '<div>varAlly (v'.$version.') créé par Aéris, légèrement modifié par CyberSpace</div>';
}


/**
 * Verification des tags et suppression des ; excedentaires
 * @param string $tag Le tag a vérifier
 */
function check_tag ( &$tag ) {
	if (substr($tag,0,1) == ';') $tag = substr($tag,1);
	if (substr($tag,-1) == ';') $tag = substr($tag,0,strlen($tag)-1);
}

/**
 * Affiche les statistiques
 * @param string $fields Type de stats: points,fleet ou research
 * @param string $player Nom du joueur
 */
function affStats ( $field, $player ) {
	global $db;
	switch ($field) {
		case 'points': $table = OGSPY_RANK_PLAYER_POINTS; break;
		case 'fleet': $table = OGSPY_RANK_PLAYER_FLEET; break;
		case 'research': $table = OGSPY_RANK_PLAYER_RESEARCH; break;
	}

	$query = 'SELECT `points` FROM `'.$table.'` WHERE `player`=\''.$player.'\' ORDER BY `datadate` DESC LIMIT 2';
	$result = $db->query($query);
	$nb = $db->num_rows($result);
	
	switch ($nb) {
		case 0; echo '<th colspan=\'2\'> - </th>'; break;
		case 1; $val = $db->fetch_assoc($result); echo '<th>? -> '.$val['points'].'</th><th>n/a</th>'; break;
		case 2; $val = $db->fetch_assoc($result); $new = $val['points']; $val = $db->fetch_assoc($result); $ex = $val['points'];
			$ecart = $new - $ex; $pourcent = round(100*$ecart/$ex,2); if ($ecart<0) { $color='red'; } elseif ($ecart>0) { $color='lime'; $ecart = '+'.$ecart; $pourcent = '+'.$pourcent; } else { $color=''; }
			echo '<th>'.$ex.' -> '.$new.' (<font color=\''.$color.'\'>'.$ecart.'</font>)</th><th><font color=\''.$color.'\'>'.$pourcent.'%</font></th>'; break;
		default; echo '<th colspan=\'2\'> - Error - </th>'; break;
	}
}

function affPoints ( $player, $where ) {
	global $db;
	
	if ($where <> '')
	{
		$query = 'SELECT min(`datadate`) AS `min`, max(`datadate`) as `max` FROM `'.TABLE_VARALLY.'` WHERE `player`=\''.$player.'\''.$where;
		$result = $db->query($query);
		list($min, $max) = $db->fetch_row($result);
		$date = ' AND (`datadate`=\''.$min.'\' OR `datadate`=\''.$max.'\')';
		$limit = '';
	} else {
		$date = '';
		$limit = ' LIMIT 2';
	}

	$query = 'SELECT `points` FROM `'.TABLE_VARALLY.'` WHERE `player`=\''.$player.'\''.$date.' ORDER BY `datadate` DESC'.$limit;
	$result = $db->query($query);
	$nb = $db->num_rows($result);
    	switch ($nb) {
		case 0; echo '<th colspan=\'2\'> - </th>'; break;
		case 1; $val = $db->fetch_assoc($result); echo '<th>'.$val['points'].'</th><th>n/a</th>'; break;
		case 2; $val = $db->fetch_assoc($result); $new = $val['points']; $val = $db->fetch_assoc($result); $ex = $val['points'];
		    $ecart = $new - $ex; 
		    $pourcent = round(100*$ecart/$ex,2);        

		    global $tblecart; 
		    $tblecart[] = array( "joueur" => $player, "pts" => $ecart, "prc" => $pourcent );        

		    if ($ecart<0) { $color='red'; } elseif ($ecart>0) { $color='lime'; $ecart = '+'.$ecart; $pourcent = '+'.$pourcent; } else { $color=''; }        

		    echo '<th>'.$ex.' -> '.$new.' (<font color=\''.$color.'\'>'.$ecart.'</font>)</th><th><font color=\''.$color.'\'>'.$pourcent.'%</font></th>'; break;
		default; echo '<th colspan=\'2\'> - Error - </th>'; break;
	}	
}

function parseDate ( $date ) {
	preg_match('#(\d{2})/(\d{2})/(\d{4})\s(\d{2}):(\d{2}):(\d{2})#', $date, $reg);
	return(mktime($reg[4], $reg[5], $reg[6], $reg[2], $reg[1], $reg[3]));
}
?>
