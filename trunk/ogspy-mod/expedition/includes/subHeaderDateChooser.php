<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas dacc�s direct

$datePickerFolder = FOLDEREXP."includes/datePicker";
 

// Pour le module d�tail
if(isset($pub_sousmodule))
{
	if($pub_sousmodule == 'global')
	{
		$typeUser = 0;	
	}
	else if($pub_sousmodule == 'user')
	{
 		$typeUser = $user_data['user_id'];	
	}
	else
	{
		$typeUser = '';
	}
}
else
{
	$typeUser = '';
	$pub_sousmodule = '';
}

$aujourdhuiMinuit = mktime(0,0,0);
$nouvelanMinuit = mktime(0,0,0, 1, 1);
$debutDuMois = mktime(0, 0, 0, date('m'), 1, date('Y'));

if(!isset($pub_datedebut))
{
	if($pub_module == 'detail')
	{	if(date('d') < 15)
		{
			$quinzaine = 1;
			$titrePeriode = "eXpeditions depuis le d�but du mois :";
		}
		else
		{
			$quinzaine = 15;
			$titrePeriode = "eXpeditions depuis le d�but de la deuxi�me quinzaine du mois :";
		}
		$datedebut =  mktime(0, 0, 0, date('m'), $quinzaine, date('Y')); // d�but du mois
	}
	
	if($pub_module == 'hof')
	{
	    	$datedebut =  0; // depuis toujours
	  	$titrePeriode = "eXpeditions depuis toujours :";
	}
	$datefin =  99999999999;     //maintenant (la fin des temps...)

}
else
{
	if(preg_match("#(\d{2})-(\d{2})-(\d{4})#", $pub_datedebut, $dat))
	{	
		$pub_datedebut = mktime(0, 0, 0, $dat[2], $dat[1], $dat[3]);
	}
	if(!isset($pub_datefin))
	{
		$datedebut = $pub_datedebut;
		$datefin =  99999999999;     //maintenant (la fin des temps...)
		$titrePeriode = "eXpeditions depuis le ".date('d/m/Y', $datedebut)." jusqu'� maintenant :";
	}
	else
	{
		if(preg_match("#(\d{2})-(\d{2})-(\d{4})#", $pub_datefin, $dat))
		{
			$pub_datefin = mktime(0, 0, 0, $dat[2], $dat[1], $dat[3]);
		}
		$datedebut = $pub_datedebut;
		$datefin   = $pub_datefin;
		if($datedebut > $datefin)
		{
			$datefin = $datedebut + 1;
		}
		$titrePeriode = "eXpeditions dans la p�riode allant du ".date('d/m/Y', $datedebut)." au ".date('d/m/Y', $datefin)." :";
	}
}

$pageSubHeader = <<<HERESUBHEADER

<!-- DEBUT Insertion mod eXpedition : Detail -->

<script type="text/javascript" src="$datePickerFolder/js.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="$datePickerFolder/css.css" />
	
<span style="font-weight: bold;">
Voir eXpeditions du 
<a href="index.php?action=eXpedition&module=$pub_module&sousmodule=$pub_sousmodule&datedebut=$aujourdhuiMinuit"> jour</a>, 
<a href="index.php?action=eXpedition&module=$pub_module&sousmodule=$pub_sousmodule&datedebut=$debutDuMois"> mois</a>, de l'
<a href="index.php?action=eXpedition&module=$pub_module&sousmodule=$pub_sousmodule&datedebut=$nouvelanMinuit"> ann�e</a>, ou encore
<a href="index.php?action=eXpedition&module=$pub_module&sousmodule=$pub_sousmodule&datedebut=0"> depuis toujours !</a>
<br />
<form name='form' method='get' action='index.php'>
	ou dans la p�riode allant du 
	<input type="hidden" name="action" value="eXpedition">  
	<input type="hidden" name="module" value="$pub_module">  
	<input type="hidden" name="sousmodule" value="$pub_sousmodule">  
	<input type="text" name="datedebut">
	<input type=button value="Calendrier" onclick="displayDatePicker('datedebut', false, 'dmy', '-');">
 au 
	<input type="text" name="datefin">
	<input type=button value="Calendrier" onclick="displayDatePicker('datefin', false, 'dmy', '-');">
	<input value='Valider' type='submit'>
</form>
</span>

<br />
<br />
<br />
HERESUBHEADER;


//affichage de la page
echo($pageSubHeader);
?>
