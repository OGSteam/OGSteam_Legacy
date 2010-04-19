<?php

/***************************************************************************
 *                                mod_holydays.php
 *                            -------------------
 *   fait le                : Lundi ,6 Octobre, 2003
 *   Par : sjpphpbb - sjpphpbb@club-internet.fr    http://sjpphpbb.net/phpbb3/
 *
 * Tirer du script original Holy Days
 * © Copyright 2001-2002 / Script affichant la date en français et la fête du jour correspondante - http://holydays.online.fr
 ***************************************************************************/

/***************************************************************************
 *
 *   Minimodule à intégrer dans un Gf-Portail
 *
 ***************************************************************************/

if (!defined('IN_PHPBB'))
{
	exit;
}

$user->add_lang('portal/portal_lang');

		function date_fran()
		{
		$mois = array("janvier", "fevrier", "mars", "avril", "mai", "juin",
"juillet", "aout", "septembre", "octobre", "novembre", "decembre");
		$jours = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
		return $jours[date("w")]." ".date("j").(date("j") == 1 ? "er" : " ").
		$mois[date("n")-1]." ".date("Y");
		}
		$date = (date_fran());
		$serveurtime = time();                     
		$lejour = date("d",$serveurtime);          
		$lemois = date("m",$serveurtime);          

	$sql = 'SELECT*
		FROM ' . HOLYDAYS_TABLE . "
		WHERE lejour = '" . $lejour . "'
		AND lemois = $lemois";
		$results = $db->sql_query($sql);		

		$row = $db->sql_fetchrow($results);
		{
        $fete = $row['fetedujour'];	
		}		

		$template->assign_vars(array(
            	'DATE' =>$date,
            	'FETE' =>$fete)
         );

?>
