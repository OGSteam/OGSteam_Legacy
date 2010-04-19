<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas daccès direct

if(!isset($pub_offset))
{
	$pub_offset = 0;
}
if(isset($_GET['type']))
{
	if($_GET['type'] == 'ally')
	{
		$typeAlly = 'SELECTED';
	}
	else
	{
		$typeAlly = '';
	}
	if($_GET['type'] == 'user')
	{
		$typeUser = 'SELECTED';
	}
	else
	{
		$typeUser = '';
	}
}
else
{
	$typeAlly = '';
	$typeUser = '';
}
if(isset($_GET['keyW']))
{
	$key = $_GET['keyW'];
}
else
{
	$key = '';
}
//définition de la page
$pageSeek = <<<HERESEEK



<!-- DEBUT Insertion mod eXchange : Seek -->

	<big><big>Recherche de messages : </big></big>
		
	<form name='form' method='get' action=''>
		Entrez les mots clefs correspondant à votre recherche : 
		<input type="text" name="keyW"value="$key">  
		<input type="hidden" name="action" value="eXchange">  
		<input type="hidden" name="module" value="seek">  
		<SELECT name="type">
			<OPTION $typeUser VALUE="user"> dans mes messages persos </OPTION>
			<OPTION $typeAlly VALUE="ally"> dans les messages d'alliance </OPTION>
		</SELECT>
		<input type="submit" name="Ok" value="Ok">  
	</form>

<hr>



HERESEEK;


if(isset($_GET['keyW']))
{
	if(($_GET['type'] != 'user') && ($_GET['type'] != 'ally'))
	{
		die('Vilain ! Pas toucher l\'url !');
	}
	if($_GET['type'] == 'user')
	{
		$nbUserMsg = countRechercheMessagesUser($_GET['keyW'], $user_data['user_id']);
	}
	if($_GET['type'] == 'ally')
	{
		$nbUserMsg = countRechercheMessagesAlly($_GET['keyW'], $user_data['user_id']);
	}
	$pageSeek .= '<big>Résultats de la recherche sur " '.$_GET['keyW'].' " : </big><br /><br />';
	
	if($_GET['type'] == 'user')
	{
		$pageSeek .= '<big> Messages perso : </big><br /><br /><br />';
	
		if($nbUserMsg == 0)
		{
			$pageSeek .= '<big> Aucun message perso ne correspond </big><br /><br />';
		}
		else
		{
			$UserMsgPerso = rechercherMessagesUser($_GET['keyW'], $user_data['user_id'], $pub_offset);
			$pageSeek .= ouvrirTableau($nbUserMsg, $pub_offset);
			foreach($UserMsgPerso as $msg)
			{
				$coords = "[".$msg['pos_galaxie'].":".$msg['pos_sys'].":".$msg['pos_pos']."]";
				$pageSeek .= afficheMessage($msg['date'], $msg['player'], $coords, $msg['body'], $msg['title'], $msg['score']);
			}
			$pageSeek .= fermerTableau($nbUserMsg, $pub_offset, 'seek&type=user&keyW='.$_GET['keyW']);
		}
	}
	if($_GET['type'] == 'ally')
	{
		$pageSeek .= '<big> Messages d\'alliance : </big><br /><br /><br />';
		if($nbUserMsg == 0)
		{
			$pageSeek .= '<big> Aucun message d\'alliance ne correspond </big><br /><br />';
		}	
		else
		{
			$UserMsgAlly = rechercherMessagesAlly($_GET['keyW'], $user_data['user_id'], $pub_offset);
			$pageSeek .= ouvrirTableau($nbUserMsg, $pub_offset);
			foreach($UserMsgAlly as $msg)
			{
				$pageSeek .= afficheMessage($msg['date'], $msg['player'], $msg['alliance'], $msg['body'], '<PasDeTitre>', $msg['score']);
			}
			$pageSeek .= fermerTableau($nbUserMsg, $pub_offset, 'seek&type=ally&keyW='.$_GET['keyW']);
		}
	}
}

$pageSeek .= <<<HERESEEK


<!-- FIN Insertion mod eXchange : Seek -->



HERESEEK;

//affichage de la page
echo($pageSeek);

?>
