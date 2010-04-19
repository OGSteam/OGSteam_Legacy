<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if(class_exists("Callback")){
class eXchange_Callback extends Callback {
        public $version = '2.0b8';
        public function eXchange_xtense2_msg($msg){
			global $io,$user;
			// Si vous avez des questions sur cet algorithme de vérification à 2F30 adressez-vous à unibozu sur le forum
			$checksomme = 0;
			foreach ($msg as $mess)
				if(eXchange_analyse_moi_ce_message_perso($user['id'], $mess['coords'][0], $mess['coords'][1], $mess['coords'][2], addslashes($mess['from']), addslashes($mess['subject']), addslashes($mess['message']), $mess['time']))
					$checksomme++;
			if($checksomme>0)
				$io->append_call_message("Un total de {$checksomme} messages ont été enregistrés", Io::SUCCESS);
			else
				$io->append_call_message("Aucun messages ({$checksomme}) n'a été enregistré", Io::WARNING);
			return Io::SUCCESS;
		}
		public function eXchange_xtense2_ally_msg($ally_msg){
			global $io,$user;
			// Si vous avez des questions sur cet algorithme de vérification à 2F30 adressez-vous à unibozu sur le forum
			$checksomme = 0;
			foreach ($ally_msg as $mess)
				if(eXchange_analyse_moi_ce_message_d_alliance($user['id'], addslashes($mess['from']), addslashes($mess['tag']), addslashes($mess['message']), $mess['time']))
					$checksomme++;
				if($checksomme>0)
					$io->append_call_message("Un total de {$checksomme} messages d'alliance ont été enregistrés", Io::SUCCESS);
				else
					$io->append_call_message("Aucun messages ({$checksomme}) d'alliance n'a été enregistré", Io::WARNING);
				return Io::SUCCESS;
		}
        public function getCallbacks() {
                return array(
                        array(
                                'function' => 'eXchange_xtense2_msg',
                                'type' => 'msg'
                        ),
                        array(
                                'function' => 'eXchange_xtense2_ally_msg',
                                'type' => 'ally_msg'
                        )
                );
       }
}
}

global $xtense_version,$table_prefix;
$xtense_version = "2.0b2"; 

//definition des tables
define("TABLE_EXCHANGE_USER",	$table_prefix."eXchange_User");
define("TABLE_EXCHANGE_ALLY",	$table_prefix."eXchange_Ally");


function eXchange_xtense2_msg($msg)
{
	global $user;
	// Si vous avez des questions sur cet algorithme de vérification à 2F30 adressez-vous à unibozu sur le forum
	$checksomme = 0;
	foreach ($msg as $mess)
	{
		if(eXchange_analyse_moi_ce_message_perso($user['id'], $mess['coords'][0], $mess['coords'][1], $mess['coords'][2], addslashes($mess['from']), addslashes($mess['subject']), addslashes($mess['message']), $mess['time']))
		{
			$checksomme++;
		}
	}
	if($checksomme == 0) return FALSE;
	return TRUE;

} 

function eXchange_xtense2_ally_msg($ally_msg)
{
	global $user;
	// Si vous avez des questions sur cet algorithme de vérification à 2F30 adressez-vous à unibozu sur le forum
	$checksomme = 0;
	foreach ($ally_msg as $mess)
	{
		if(eXchange_analyse_moi_ce_message_d_alliance($user['id'], addslashes($mess['from']), addslashes($mess['tag']), addslashes($mess['message']), $mess['time']))
		{
			$checksomme++;
		}
	}
	if($checksomme == 0) return FALSE;
	return TRUE;

} 



// analyser les messages perso ajoutés
function eXchange_analyse_moi_ce_message_perso($uid, $galaxy, $systeme, $position, $player, $title, $body, $timestmp)
{
	global $sql;
	$eXpXtense2Debug = false;
	$dateTmp = date('d-m-Y H:i:s', $timestmp);
	$body = str_replace("\n\n","<br />",$body);
	if($eXpXtense2Debug)
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
	if($eXpXtense2Debug) echo("<br /> Db : $query <br />");

	if(!$sql->check($query))
	{
		$query = 
			"Insert into ".TABLE_EXCHANGE_USER." 
			(id, date, user_id, pos_galaxie, pos_sys, pos_pos, player, title, body) 
			values (null, $timestmp, $uid, $galaxy, $systeme, $position, '$player', '$title', '$body')";
		if($eXpXtense2Debug) echo("<br /> Db : $query <br />");
		$sql->query($query);

	}
	else
	{	
		if($eXpXtense2Debug) 
		{
			echo('<big><big>> Message perso du '.$dateTmp.' déja ajouté !</big></big> <br />');
		}
	}				

}


// analyser les messages d'alliance ajoutés
function eXchange_analyse_moi_ce_message_d_alliance($uid, $player, $alliance, $body, $timestmp)
{
	global $sql;
	$eXpXtense2Debug = false;
	$dateTmp = date('d-m-Y H:i:s', $timestmp);
	$body = str_replace("\n\n","<br />",$body);
	if($eXpXtense2Debug)
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

	if($eXpXtense2Debug) echo("<br /> Db : $query <br />");

	if(!$sql->check($query))
	{
		$query = 
			"Insert into ".TABLE_EXCHANGE_ALLY." 
			(id, date, user_id, alliance, player, body) 
			values (null, $timestmp, $uid, '$alliance', '$player', '$body')";
		if($eXpXtense2Debug) echo("<br /> Db : $query <br />");
		$sql->query($query);

	}
	else
	{	
		if($eXpXtense2Debug) 
		{
			echo('<big><big>> Message d\'alliance du '.$dateTmp.' déja ajouté !</big></big> <br />');
		}
	}				

}

?>
