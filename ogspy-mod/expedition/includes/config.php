<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'acc�s direct



if(isset($_POST['ForceXtense2']))
{
	if($_POST['ForceXtense2'] == "OK")
	{
		define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");
		$query = "SELECT id, version FROM ".TABLE_MOD." WHERE action='eXpedition'";
		if($eXpDebug) echo("<br /> Db : $query <br />");
		$result = $db->sql_query($query);
		list($mod_id, $version) = $db->sql_fetch_row($result);
		
		// On regarde si la table xtense_callbacks existe :
		$query = 'show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ';
		if($eXpDebug) echo("<br /> Db : $query <br />");
		$result = $db->sql_query($query);
		if($db->sql_numrows($result) != 0)
		{
			//Bonne nouvelle le mod xtense 2 est install� !
	
			//Maintenant on regarde si eXpedition est dedans :
			$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
			if($eXpDebug) echo("<br /> Db : $query <br />");
			$result = $db->sql_query($query);
			if($db->sql_numrows($result) == 0)
			{
				// Il est pas dedans alors on l'ajoute :
				$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES 
						('.$mod_id.', "eXpedition_xtense2_integration", "expedition", 1)';
				if($eXpDebug) echo("<br /> Db : $query <br />");
				$db->sql_query($query);
				echo("<big>La compatibilit� du mod eXpedition avec le mod Xtense2 est install�e !</big><br /><br /><br /><br />");		
			}
			else
			{
				echo("<big>La compatibilit� du mod eXpedition avec le mod Xtense2 est d�ja install�e !<br />Aucun changement ne sera donc effectu�.</big><br /><br /><br /><br />");	
			}
		}
		else
		{
			echo("<big>Le mod Xtense 2 n'est pas install�.<br />La compatibilit� du mod eXpedition ne sera donc pas install�e !</big><br />Pensez � installer Xtense 2 c'est pratique ;)<br /><br /><br /><br />");
		}
	}
	else die('Na m� ho ! PAS BIEN !');
}

if(isset($_POST['td']))
{

	if($_POST['td'] == "0")
	{
		setOpts($user_data['user_id'], 0, 0);
	}
	if($_POST['td'] == "1")
	{
		setOpts($user_data['user_id'], 0, 1);
		
	}

	if($_POST['debug'] == "0")
	{
		setOpts($user_data['user_id'], 1, 0);
	}
	if($_POST['debug'] == "1")
	{
		setOpts($user_data['user_id'], 1, 1);
	}	
	$_POST['td'] = NULL;
	require(FOLDEREXP."includes/header.php"); //on inclut notre header � nous !
	
	echo('<br /><big><big>Modifications prises en compte.</big></big><br />');
	
}

	if($menuFixe == 0)
	{
		$is00Seclected =  'SELECTED';
		$is01Seclected =  '';
	}
	else
	{
		$is00Seclected =   '';
		$is01Seclected =  'SELECTED';
	}
	if($eXpDebug == 0)
	{
		$is10Seclected = 'SELECTED';
		$is11Seclected = '';
	}
	else
	{	
		$is10Seclected = '';
		$is11Seclected = 'SELECTED';
	}
	
//d�finition de la page
$pageConfig = <<<HERECONFIG

<!-- DEBUT Insertion mod eXpedition : Config -->



<div style="text-align: center;">
	<big style="font-weight: bold;"><big>
		Configuration du mod !
	</big></big>
</div>
<br />
<form name='form' method='post' action=''>

Choisir votre type de menu (Dock) : 
	<SELECT name="td">
		<OPTION $is00Seclected VALUE="0">Menu anim� (n�c�ssite javascript)</OPTION>
		<OPTION $is01Seclected VALUE="1">Menu fixe (compatibilit�) </OPTION>
	</SELECT>
<br /><br />
Mode Debug (= Affichage de nombreuses choses incompr�hensibles) ?
	<SELECT name="debug">
		<OPTION $is10Seclected VALUE="0">Non merci...    ;) </OPTION>
		<OPTION $is11Seclected VALUE="1">Oui j'en veux ! XD </OPTION>
	</SELECT>
<br /><br />
	<input value='Valider' type='submit'>
</form>
<br /><br />
<form name='form' method='post' action=''>
	<input type="hidden" name="ForceXtense2" value="OK">  
	<big><strong> Forcer la r�installation de la compatibilit� avec Xtense 2 : </strong> </big><input value='Allez hop !' type='submit'><br />
	Peut etre utile si Xtense 2 a �t� d�sinstall� puis r�install�.
</form>


<!-- FIN Insertion mod eXpedition : Config -->

HERECONFIG;

//affichage de la page
echo($pageConfig);

?>
