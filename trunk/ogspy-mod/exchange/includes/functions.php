<?php


if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct


// Pour le formattage des nombres
function format ( $number, $e = 0 )
{
	return number_format($number, $e, ',', '.');
}

// recupérer le nom de quelqu'un
function getuserNameById($uid)
{
	global $db, $eXcDebug;
	$query = 
				"SELECT user_name
			 	FROM ".TABLE_USER."
			 	WHERE user_id = $uid ";
	if($eXcDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	list($nom) = $db->sql_fetch_row($result);
	return $nom;
}


// recupérer les options de quelqu'un
function getOpts($uid, $opt)
{
	global $db, $eXcDebug;
	$query = 
				"SELECT val
			 	FROM ".TABLE_EXCHANGE_OPTS."
			 	WHERE user_id = $uid 
				and opts = $opt";
	if($eXcDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	if(($db->sql_numrows($result) == 0) && ($opt < 2))
	{
		return 0; // Valeur par défaut...
	}
	if(($db->sql_numrows($result) == 0) && ($opt == 2))
	{
		return 25;
	}
	list($value) = $db->sql_fetch_row($result);
	return $value;
}


// définir les options de quelqu'un
function setOpts($uid, $opt, $value)
{
	global $db, $eXcDebug;
	$query = 
				"SELECT val
			 	FROM ".TABLE_EXCHANGE_OPTS."
			 	WHERE user_id = $uid 
				and opts = $opt";
	if($eXcDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	if($db->sql_numrows($result) == 0)
	{	
		$query = 
				"Insert into ".TABLE_EXCHANGE_OPTS."
				(id, user_id, opts, val)
				values (null, $uid, $opt, $value)";
		$db->sql_query($query);
	}
	else
	{
		$query = 
				"Update ".TABLE_EXCHANGE_OPTS."
				Set val = $value
			 	WHERE user_id = $uid 
				and opts = $opt";
		$db->sql_query($query);
	}
}

// analyser les messages ajoutés
function analyseRapport($uid)
{
	global $db, $eXcDebug;

	// Tout d'abord si il a été soumis un message :
	if ( isset($_POST['datas'] ) ) 
	{	
		$regExUser = "#(\d{2})-(\d{2})\s*(\d{2}):(\d{2}):(\d{2})\s*(.+)\s*\[(\d+):(\d+):(\d+)\]\s+(.+)\s+Répondre\s+((.|\n)+)\s*00-00#U";
		//$regExAlly = "#(\d{2})-(\d{2})\s*(\d{2}):(\d{2}):(\d{2})\s*Alliance\s+\[(.+)\]\s*Message\sde\svotre\salliance\[.+\]\s+Le\sjoueur\s(.+)\svous\senvoie\sce\smessage:\s+((.|\n)+)\s*00-00#U";
                         // 00-00 02-14 16:32:49 Alliance [ArtDuMal] Message de votre alliance [ArtDuMal] Le joueur ange loki vous envoie ce message: dites 
		$regExAlly = "#(\d{2})-(\d{2})\s*(\d{2}):(\d{2}):(\d{2})\s*Alliance\s*\[(.+)\]\s*Message\sde\svotre\salliance\s\[.+\]\s+Le\sjoueur\s(.+)\svous\senvoie\sce\smessage:\s+((.|\n)+)\s*00-00#U";	
		// on enleve les séparateurs
		$_POST['datas'] = str_replace('.', '', $_POST['datas']);
		//Compatibilité UNIX/Windows
		$_POST['datas'] = str_replace("\r\n","\n",$_POST['datas']);
		//Compatibilité IE/Firefox
		$_POST['datas'] = str_replace("\t",' ',$_POST['datas']);
		//pour l'apostrophe !	
		$_POST['datas'] = stripslashes($_POST['datas']);

		
		$regEnTete = "#(\d{2})-(\d{2})\s*(\d{2}):(\d{2}):(\d{2})#";
		$_POST['datas'] = preg_replace($regEnTete, '00-00 $1-$2 $3:$4:$5', $_POST['datas']);
		$_POST['datas'] .= " 00-00";
		
		$nbUser = preg_match_all($regExUser, $_POST['datas'], $msgUser, PREG_PATTERN_ORDER);
		$_POST['datas'] = preg_replace($regExUser, '', $_POST['datas']);

		$nbAlly = preg_match_all($regExAlly, $_POST['datas'], $msgAlly, PREG_PATTERN_ORDER);
		$_POST['datas'] = preg_replace($regExAlly, '', $_POST['datas']);
		
		if($eXcDebug && !preg_match("#^\s*00-00\s*#", $_POST['datas']))
		{
			echo("<br /> Texte non traite : ".$_POST['datas']." <br />");
		}
		$nbMsg = $nbUser + $nbAlly;
		if($nbMsg == 0)
		{
			echo('<big><big><big> Aucun Message Valide Trouve ! </big></big></big> <br />');
		}
		else
		{
			echo('<big><big><big>OK :)</big></big></big> <br />');
			echo("<br /><big><big>".$nbMsg." messages détéctés !<br />");
			echo("dont : ".$nbUser." perso et ".$nbAlly." d'alliance </big></big><br /><br />");
			if($nbAlly)
			{
				for($i = 0 ; $i < $nbAlly ; $i++)
				{
					//recherche de l'année :
					if( $msgAlly[1][$i] > date('m'))
					{
						//on a changé d'année entre temps
						$year = date('Y') - 1;
					}
					else
					{
						//sinon c'est l'année courante
						$year = date('Y');			
					}
					
					$timestmp = mktime($msgAlly[3][$i], $msgAlly[4][$i] , $msgAlly[5][$i], $msgAlly[1][$i], $msgAlly[2][$i], $year);
					$alliance   = addslashes($msgAlly[6][$i]);
					$player   = addslashes($msgAlly[7][$i]);
					$body     = addslashes($msgAlly[8][$i]);
					$body = str_replace("\n","<br />",$body);
					$dateTmp = date('d-m-Y H:i:s', $timestmp);
					if($eXcDebug)
					{
						echo("-Message alliance <br />-");
						echo("Date : $timestmp ou encore : $dateTmp  ! <br />");
						echo("Joueur : $player  <br /> Alliance : $alliance <br /> Message : $body");
					}
					$query = 
						"Select * 
						From ".TABLE_EXCHANGE_ALLY." 
						Where date = $timestmp 
						and user_id = $uid 
						and alliance = '$alliance'
						and player = '$player'
						and body = '$body'
						";
					if($eXcDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);

					if($db->sql_numrows($result) == 0)
					{
						$query = 
							"Insert into ".TABLE_EXCHANGE_ALLY." 
							(id, date, user_id, alliance, player, body) 
							values ('', $timestmp, $uid, '$alliance', '$player', '$body')";
						if($eXcDebug) echo("<br /> Db : $query <br />");
						$db->sql_query($query);

					}
					else
					{
						echo('<big><big>> Message d\'alliance du '.$dateTmp.' déja ajouté !</big></big> <br />');
					}
				}
				
			}
			if($nbUser)
			{
				for($i = 0 ; $i < $nbUser ; $i++)
				{
					//recherche de l'année :
					if( $msgUser[1][$i] > date('m'))
					{
						//on a changé d'année entre temps
						$year = date('Y') - 1;
					}
					else
					{
						//sinon c'est l'année courante
						$year = date('Y');			
					}
					$timestmp = mktime($msgUser[3][$i], $msgUser[4][$i] , $msgUser[5][$i], $msgUser[1][$i], $msgUser[2][$i], $year);
					$player   = addslashes($msgUser[6][$i]);
					$galaxy   = $msgUser[7][$i];
					$systeme  = $msgUser[8][$i];
					$position = $msgUser[9][$i];
					$title    = addslashes($msgUser[10][$i]);
					$body     = addslashes($msgUser[11][$i]);
					$body = str_replace("\n","<br />",$body);
					
					$dateTmp = date('d-m-Y H:i:s', $timestmp);
					if($eXcDebug)
					{
						echo("-Message perso <br />-");
						echo("Date : $timestmp ou encore : $dateTmp  ! <br />");
						echo("Coordonnees : [$galaxy:$systeme:$position]  <br />");
						echo("Joueur : $player  <br /> Titre : $title <br /> Message : $body");
					}
					$query = 
						"Select * 
						From ".TABLE_EXCHANGE_USER." 
						Where date = $timestmp 
						and user_id = $uid 
						and pos_galaxie = $galaxy 
						and pos_sys = $systeme
						and pos_pos = $position
						and player = '$player'
						and title = '$title'
						and body = '$body'
						";
					if($eXcDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);

					if($db->sql_numrows($result) == 0)
					{
						$query = 
							"Insert into ".TABLE_EXCHANGE_USER." 
							(id, date, user_id, pos_galaxie, pos_sys, pos_pos, player, title, body) 
							values ('', $timestmp, $uid, $galaxy, $systeme, $position, '$player', '$title', '$body')";
						if($eXcDebug) echo("<br /> Db : $query <br />");
						$db->sql_query($query);

					}
					else
					{
						echo('<big><big>> Message perso du '.$dateTmp.' déja ajouté !</big></big> <br />');
					}
				}
				
			}
		}	
	}
}

function readDBUser($uid, $offset)
{
	global $db, $eXcDebug, $nMsgParPage;
	$query = 
		"Select date, user_id, pos_galaxie, pos_sys, pos_pos, player, title, body
		From ".TABLE_EXCHANGE_USER." 
		Where user_id = $uid
		Order by date desc
		Limit $offset, $nMsgParPage
		";
	if($eXcDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	while ($assoc = $db->sql_fetch_assoc($result)) 
	{
   		$ret[] = $assoc;
	}
	return $ret;
}


function nbMsgUserForUser($uid=0)
{ 
	global $db, $eXcDebug;
	$query = 
		"Select count(*)
		From ".TABLE_EXCHANGE_USER." ";
if($uid != 0) $query .= "Where user_id = $uid";
	if($eXcDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);	
	$TabCount = $db->sql_fetch_row($result);
	return $TabCount[0];
}

function readDBAlly($uid, $offset)
{
	global $db, $eXcDebug, $nMsgParPage;
	$query = 
		"Select date, user_id, alliance, player, body
		From ".TABLE_EXCHANGE_ALLY." 
		Where user_id = $uid
		Order by date desc
		Limit $offset, $nMsgParPage
		";
	if($eXcDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	while ($assoc = $db->sql_fetch_assoc($result)) 
	{
   		$ret[] = $assoc;
	}
	return $ret;
}


function nbMsgAllyForUser($uid=0)
{
	global $db, $eXcDebug;
	$query = 
		"Select count(*)
		From ".TABLE_EXCHANGE_ALLY." ";
if($uid != 0) $query .= "Where user_id = $uid";
	if($eXcDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);	
	$TabCount = $db->sql_fetch_row($result);
	return $TabCount[0];
}

function countUser() 
{	global $db, $eXcDebug;
	$query = 
		"
		SELECT count(ut.user_id)
		FROM (
		(SELECT user_id 
		FROM ".TABLE_EXCHANGE_USER." as u) 
		UNION
		(SELECT user_id
		FROM ".TABLE_EXCHANGE_ALLY." as a)) as ut
		";
	if($eXcDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	$TabCount = $db->sql_fetch_row($result);
	return $TabCount[0];
}

function countRechercheMessagesUser($keyW, $uid) 
{	global $db, $eXcDebug;
	$query = 
		"SELECT count(*)
		FROM ".TABLE_EXCHANGE_USER."
		WHERE user_id = $uid AND
		MATCH (player,title,body) AGAINST ('$keyW' IN BOOLEAN MODE)
		";
	
	if($eXcDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	$TabCount = $db->sql_fetch_row($result);
	return $TabCount[0];
}

function countRechercheMessagesAlly($keyW, $uid) 
{	global $db, $eXcDebug;
	$query = 
		"SELECT count(*)
		FROM ".TABLE_EXCHANGE_ALLY."
		WHERE user_id = $uid AND
		MATCH (player,alliance,body) AGAINST ('$keyW' IN BOOLEAN MODE)
		";
	
	if($eXcDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	$TabCount = $db->sql_fetch_row($result);
	return $TabCount[0];
}


function rechercherMessagesUser($keyW, $uid, $offset)
{	global $db, $eXcDebug, $nMsgParPage;
	$query = 
		"SELECT date, user_id, pos_galaxie, pos_sys, pos_pos, player, title, body, MATCH (player,title,body) AGAINST ('$keyW' IN BOOLEAN MODE) AS score
		FROM ".TABLE_EXCHANGE_USER."
		WHERE user_id = $uid AND
		MATCH (player,title,body) AGAINST ('$keyW' IN BOOLEAN MODE)
		Order by score desc
		Limit $offset, $nMsgParPage
		";
	
	if($eXcDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	while ($assoc = $db->sql_fetch_assoc($result)) 
	{
   		$ret[] = $assoc;
	}
	return $ret;	
}


function rechercherMessagesAlly($keyW, $uid, $offset)
{
	global $db, $eXcDebug, $nMsgParPage;
	$query = 
		"SELECT date, user_id, alliance, player, body, MATCH (player,alliance,body) AGAINST ('$keyW' IN BOOLEAN MODE) AS score
		FROM ".TABLE_EXCHANGE_ALLY."
		WHERE user_id = $uid AND 
		MATCH (player,alliance,body) AGAINST ('$keyW' IN BOOLEAN MODE)
		Order by score desc
		Limit $offset, $nMsgParPage
		";
	
	if($eXcDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	while ($assoc = $db->sql_fetch_assoc($result)) 
	{
   		$ret[] = $assoc;
	}
	return $ret;	
}


?>
