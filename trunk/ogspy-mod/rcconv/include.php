<?php
/**
* include.php Fichier d'include
* @package [MOD] RCConv
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.7
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

$query = 'SELECT `active` FROM `'.TABLE_MOD.'` WHERE `action`=\'RCConv\' AND `active`=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

function init_all () {
	init_item();
	init_RCConv();
}

function init_item () {
	global $ship, $def, $other, $ship_a, $def_c;
	/**
	* Défini les variables pour les vaisseaux, les défenses et autres
	*/
	$ship = array(
		"PT" => "Petit transporteur",
		"GT" => "Grand transporteur",
		"Chl" => "Chasseur léger",
		"ChL" => "Chasseur lourd",
		"C" => "Croiseur",
		"VB" => "Vaisseaux de bataille",
		"Colo" => "Vaisseaux de colonisation",
		"R" => "Recycleur",
		"S" => "Sonde d'espionnage",
		"Bomb" => "Bombardier",
		"sat" => "Satellite solaire",
		"Dest" => "Destructeur",
		"Tra" => "Traqueur",
		"RIP" => "Etoile de la Mort"
	);
	$def = array(
		"lm" => "Lanceur de missile",
		"ll" => "Artillerie laser légère",
		"lL" => "Artillerie laser lourde",
		"G" => "Canon de Gauss",
		"i" => "Artillerie à ions",
		"pl" => "Lanceur de plasma",
		"PB" => "Petit bouclier",
		"GB" => "Grand bouclier"
	);	
	$other = array(
		"s1" => "de 0 à seuil 1",
		"s2" => "de seuil 1 à seuil 2",
		"s3" => "de seuil 2 à seuil 3",
		"s4" => "à partir de seuil 3",
		"met" => "métal",
		"cris" => "cristal",
		"deut" => "deutérium",
		"ally" => "alliance",
		"detr" => "Mot entre début et fin",
		"seuil" => "Valeur Seuil",
		"o_word" => "Mot entre le début et la fin",
		"o_af" => "Affichage sur",
		"o_nsize" => "Valeur de la balise [size]",
		"o_size" => "BBcode [size]",
		"o_center" => "BBcode [center]",
		"o_quote" => "BBcode [quote]",
		"o_coord" => "Afficher les coordonnées",
		"o_tech" => "Afficher les technologies",
		"o_renta" => "Afficher la rentabilité",
		"o_resum" => "Mode résumé"
	);
	$ship_a = array(
		"PT" => "P.transp.",
		"GT" => "G.transp.",
		"Chl" => "Ch.léger",
		"ChL" => "Ch.lourd",
		"C" => "Croiseur",
		"VB" => "V.bataille",
		"Colo" => "V.colo",
		"R" => "Recycleur",
		"S" => "Sonde",
		"Bomb" => "Bombardier",
		"sat" => "Sat.sol.",
		"Dest" => "Destr.",
		"Tra" => "Traqueur",
		"RIP" => "Rip",
		"lm" => "Missile",
		"ll" => "L.léger.",
		"lL" => "L.lourd",
		"G" => "Can.Gauss",
		"i" => "Art.ions",
		"pl" => "Lanc.plasma",
		"PB" => "P.bouclier",
		"GB" => "G.bouclier"
	);
	$def_c = array(
		"lm" => "Missile",
		"ll" => "L.léger.",
		"lL" => "L.lourd",
		"G" => "Can.Gauss",
		"i" => "Art.ions",
		"pl" => "Lanc.plasma",
		"PB" => "P.bouclier",
		"GB" => "G.bouclier"
	);
}

function init_RCConv () {
	global $_COOKIE, $RC_var;
	//Vérifie si le cookie php existe, si oui il récupère les données.
	if(!empty($_COOKIE['config_RCConv']) AND isset($_COOKIE['config_RCConv'])) {
		$RC_var = array(
		'PT' => $_COOKIE['config_RCConv']['PT'],
		'GT' => $_COOKIE['config_RCConv']['GT'],
		'Chl' => $_COOKIE['config_RCConv']['Chl'],
		'ChL' => $_COOKIE['config_RCConv']['ChL'],
		'C' => $_COOKIE['config_RCConv']['C'],
		'VB' => $_COOKIE['config_RCConv']['VB'],
		'Colo' => $_COOKIE['config_RCConv']['Colo'],
		'R' => $_COOKIE['config_RCConv']['R'],
		'S' => $_COOKIE['config_RCConv']['S'],
		'Bomb' => $_COOKIE['config_RCConv']['Bomb'],
		'sat' => $_COOKIE['config_RCConv']['sat'],
		'Dest' => $_COOKIE['config_RCConv']['Dest'],
		'RIP' => $_COOKIE['config_RCConv']['RIP'],
		'Tra' => $_COOKIE['config_RCConv']['Tra'],
		'lm' => $_COOKIE['config_RCConv']['lm'],
		'll' => $_COOKIE['config_RCConv']['ll'],
		'lL' => $_COOKIE['config_RCConv']['lL'],
		'G' => $_COOKIE['config_RCConv']['G'],
		'i' => $_COOKIE['config_RCConv']['i'],
		'pl' => $_COOKIE['config_RCConv']['pl'],
		'PB' => $_COOKIE['config_RCConv']['PB'],
		'GB' => $_COOKIE['config_RCConv']['GB'],
		'Mi' => $_COOKIE['config_RCConv']['Mi'],
		'MI' => $_COOKIE['config_RCConv']['MI'],
		'detr' => $_COOKIE['config_RCConv']['detr'],
		'met' => $_COOKIE['config_RCConv']['met'],
		'cris' => $_COOKIE['config_RCConv']['cris'],
		'deut' => $_COOKIE['config_RCConv']['deut'],
		's1' => $_COOKIE['config_RCConv']['s1'],
		's2' => $_COOKIE['config_RCConv']['s2'],
		's3' => $_COOKIE['config_RCConv']['s3'],
		's4' => $_COOKIE['config_RCConv']['s4'],
		'ally' => $_COOKIE['config_RCConv']['ally'],
		'seuil' => $_COOKIE['config_RCConv']['seuil'],
		'o_center' => $_COOKIE['config_RCConv']['o_center'],
		'o_quote' => $_COOKIE['config_RCConv']['o_quote'],
		'o_size' => $_COOKIE['config_RCConv']['o_size'],
		'o_nsize' => $_COOKIE['config_RCConv']['o_nsize'],
		'o_coord' => $_COOKIE['config_RCConv']['o_coord'],
		'o_tech' => $_COOKIE['config_RCConv']['o_tech'],
		'o_renta' => $_COOKIE['config_RCConv']['o_renta'],
		'o_word' => $_COOKIE['config_RCConv']['o_word'],
		'o_af' => $_COOKIE['config_RCConv']['o_af'],
		'o_resum' => $_COOKIE['config_RCConv']['o_resum']
		);
	} else {
		$RC_var = array(
		'PT' => '#0BED05',
		'GT' => '#0BED05',
		'Chl' => '#DDEF03',
		'ChL' => '#DDEF03',
		'C' => '#EE7404',
		'VB' => '#EE7404',
		'Colo' => '#0BED05',
		'R' => '#EE7404',
		'S' => '#EE7404',
		'Bomb' => '#EE7404',
		'sat' => '#0BED05',
		'Dest' => '#EE7404',
		'RIP' => '#DC0106',
		'Tra' => '#CB0000',
		'lm' => '#00F700',
		'll' => '#00E700',
		'lL' => '#00D700',
		'G' => '#00C700',
		'i' => '#00B700',
		'pl' => '#00A700',
		'PB' => '#009700',
		'GB' => '#008700',
		'Mi' => '#DC0106',
		'MI' => '#DC0106',
		'detr' => '#DC0106',
		'met' => '#FF0000',
		'cris' => '#FF0000',
		'deut' => '#FF0000',
		's1' => '#100000',
		's2' => '#800000',
		's3' => '#BB0000',
		's4' => '#FF0000',
		'ally' => '#FFFFFF',
		'seuil' => '200000',
		'o_center' => '',
		'o_quote' => '',
		'o_size' => '',
		'o_nsize' => '18',
		'o_coord' => ' checked',
		'o_tech' => ' checked',
		'o_renta' => ' checked',
		'o_word' => '',
		'o_af' => 'c',
		'o_resum' => ''
		);
	}
}

function destroy_cookie () {
	global $ship, $def, $other;
	
	foreach ($ship as $key => $value) {
		setcookie("config_RCConv[".$key."]", "");
	}
	foreach ($def as $key => $value) {
		setcookie("config_RCConv[".$key."]", "");
	}
	foreach ($other as $key => $value) {
		setcookie("config_RCConv[".$key."]", "");
	}
	redirection("index.php?action=RCConv&page=cookie");
}

function convNumber($number) {
	return(number_format($number,0,'.',' '));
}

function convfooter($type) {
	return $footer = "\n\n[url=http://www.ogsteam.fr/forums/sujet-1683]".$type." converti par RCConv (MOD OGSpy)[/url]";
}

function page_footer () {
	global $db;
	
	//Récupére le numéro de version du mod
	$request = 'SELECT `version` from `'.TABLE_MOD.'` WHERE `title`=\'RCConv\'';
	$result = $db->sql_query($request);
	list($version) = $db->sql_fetch_row($result);
	echo '<div>RCConv (v'.$version.') créé par Aéris et Bartheleway</div>';
}

function convColor($vari) {
	global $RC_var;
	
	$seuil1 = $RC_var['seuil'];
	$seuil2 = (2 * $RC_var['seuil']);
	$seuil3 = (3 * $RC_var['seuil']);
	
	if ($vari <= $seuil1) {
		$RC_varc = $RC_var['s1'];
	} else if ($vari <= $seuil2) {
		$RC_varc = $RC_var['s2'];
	} else if ($vari <= $seuil3) {
		$RC_varc = $RC_var['s3'];
	} else if ($vari > $seuil3) {
		$RC_varc = $RC_var['s4'];
	}
	
	$RC_varr = "[color=".$RC_varc."]".$vari."[/color]";
	
	return $RC_varr;
}

function converter_n ($pub_data) {
	global $db, $pub_quote, $pub_size, $pub_sizeSize, $pub_center, $date, $pub_resum;
	global $RC_var, $pub_noTechs, $pub_noCoords, $pub_renta, $pub_comment;
	
	// Récupère la flotte de l'attaquant
	$nbRoundAttaquant = preg_match_all('#Attaquant\s.*\s\(.*\)\n?(Armes:\s\d{2,}%\sBouclier:\s\d{2,}%\sCoque:\s\d{2,}%\n)?Type\s+(.*)\nNombre\s+(.*)\n#',$pub_data,$roundAttaquant,PREG_SET_ORDER);
	// Récupère la flotte du défenseur
	$nbRoundDefenseur = preg_match_all('#Défenseur\s.*\s\(.*\)\n?(Armes:\s\d{2,}%\sBouclier:\s\d{2,}%\sCoque:\s\d{2,}%\n)?Type\s+(.*)\nNombre\s+(.*)\n#',$pub_data,$roundDefenseur,PREG_SET_ORDER);
	
	// Calcul du nombre de rounds
	$nbRound = min($nbRoundAttaquant,$nbRoundDefenseur);
	// Cas du match nul
	$nbRound = ($nbRoundAttaquant == $nbRoundDefenseur) ? $nbRound - 1 : $nbRound;
	
	// Récupère le pseudo et les coordonnées de l'attaquant
	preg_match('#Attaquant\s(.*)\s\((.*)\)\nArmes:\s(\d*)%\sBouclier:\s(\d*)%\sCoque:\s(\d*)%#', $pub_data, $attaquant);
	// Récupère le pseudo et les coordonnées du défenseur
	preg_match('#Défenseur\s(.*)\s\((.*)\)\nArmes:\s(\d*)%\sBouclier:\s(\d*)%\sCoque:\s(\d*)%#', $pub_data, $defenseur);
	// Récupère les pertes de l'attaquant
	preg_match('#L\'attaquant\sa\sperdu\sau\stotal\s((?:\.?\d*)+)\sunités\.#',$pub_data,$pertesA).'<br>';
	// Récupère les pertes du défenseur
	preg_match('#Le\sdéfenseur\sa\sperdu\sau\stotal\s((?:\.?\d*)+)\sunités\.#',$pub_data,$pertesD).'<br>';
	// Récupère les ressources pillées
	preg_match('#((?:\.?\d*)+)\sunités\sde\smétal,\s((?:\.?\d*)+)\sunités\sde\scristal\set\s((?:\.?\d*)+)\sunités\sde\sdeutérium#',$pub_data,$pillage);
	// Récupère le champ de débris
	if (!preg_match('#Un\schamp\sde\sdébris\scontenant\s((?:\.?\d*)+)\sunités\sde\smétal\set\s((?:\.?\d*)+)\sunités\sde\scristal\sse\sforme\sdans\sl\'orbite\sde\scette\splanète#',$pub_data,$recyclage)) $recyclage = null; 
	// Récupère le pourcentage de cération de lune
	if (!preg_match('#La\sprobabilité\sde\scréation\sd\'une\slune\sest\sde\s(\d*)\s%#',$pub_data,$plune)) $plune = null;
	// Vérifie si une lune a été créée
	if (!preg_match('#Les\squantités\sénormes\sde\smétal\set\sde\scristal\ss\'attirent,\sformant\sainsi\sune\slune\sdans\sl\'orbite\sde\scette\splanète\.#',$pub_data)) $lune = null; else $lune = 1;
	
	//print_r($roundAttaquant);
	$date = date('d/m/Y à H:i:s',mktime($date[3],$date[4],$date[5],$date[1],$date[2],date('Y')));
	
	//Recherche l'alliance de l'attaquant et du défenseur
	$allya = "SELECT * FROM ".TABLE_UNIVERSE." WHERE player = '".$attaquant[1]."'";
	$allya1 = $db->sql_query($allya);
	$allya2 = $db->sql_fetch_assoc($allya1);
	$allyd = "SELECT * FROM ".TABLE_UNIVERSE." WHERE player = '".$defenseur[1]."'";
	$allyd1 = $db->sql_query($allyd);
	$allyd2 = $db->sql_fetch_assoc($allyd1);
	
	//Reformate les nombres de ressources
	$pillage = preg_replace("#\.#", "", $pillage);
	$recyclage = preg_replace("#\.#", "", $recyclage);
	$pertesA = preg_replace("#\.#", "", $pertesA);
	$pertesD = preg_replace("#\.#", "", $pertesD);
	
	//Calcul la rentabilité du raid
	if ($nbRoundAttaquant > $nbRoundDefenseur) {
		$ressource = $pillage[1] + $pillage[2] + $pillage[3];
	} else {
		$ressource = "0";
	}
	
	$rentar =  $recyclage[1] + $recyclage[2] + $ressource - $pertesA[1];
	$rentasr = $ressource - $pertesA[1];
	$perter = $recyclage[1] + $recyclage[2] - $ressource - $pertesD[1];
	$pertesr = - $ressource - $pertesD[1];
	
	//Récupère le commentaire des rounds
	$comment = (!empty($pub_comment)) ? $pub_comment : '';
	
	$header = (($pub_quote == ' checked') ? '[quote]' : '').(($pub_center == ' checked') ? '[center]' : '');
	$footer = (($pub_center == ' checked') ? '[/center]' : '').(($pub_quote == ' checked') ? '[/quote]' : '');
	$size_opening = (($pub_size == ' checked') ? '[size='.$pub_sizeSize.']' : '').'[b]';
	$size_closing = '[/b]'.(($pub_size == ' checked') ? '[/size]' : '');
	
	$conv  = $header.'Les flottes suivantes se sont affrontées le '.$date."\n";
	$conv .= "\n";
	if ($pub_resum != ' checked') {
		$conv .= 'Attaquant '.$size_opening.'[color=red]'.$attaquant[1].'[/color]'.$size_closing.' [color='.$RC_var['ally'].']( '.$allya2['ally'].' )[/color] ('.(($pub_noCoords==' checked') ? $attaquant[2] : 'x:xxx:x').')'."\n";
		$conv .= 'Armes: '.(($pub_noTechs==' checked') ? $attaquant[3] : 'XXX').'% - Bouclier: '.(($pub_noTechs == ' checked') ? $attaquant[4] : 'XXX').'% - Coque: '.(($pub_noTechs == ' checked') ? $attaquant[5] : 'XXX').'%'."\n";
		$conv .= affFlotte($roundAttaquant[0]);
		$conv .= "\n";
		$conv .= 'Défenseur '.$size_opening.'[color=red]'.$defenseur[1].'[/color]'.$size_closing.' [color='.$RC_var['ally'].']( '.$allyd2['ally'].' )[/color] ('.(($pub_noCoords == ' checked') ? $defenseur[2] : 'x:xxx:x').')'."\n";
		$conv .= 'Armes: '.(($pub_noTechs == ' checked') ? $defenseur[3] : 'XXX').'% - Bouclier: '.(($pub_noTechs == ' checked') ? $defenseur[4] : 'XXX').'% - Coque: '.(($pub_noTechs == ' checked') ? $defenseur[5] : 'XXX').'%'."\n";
		$conv .= affFlotte($roundDefenseur[0]);
	} else {
		$conv .= '----------------------------------------------------------------'."\n";
		$conv .= 'Nombre total de vaisseaux attaquant : '.count_flotte($roundAttaquant[0])."\n";
		$conv .= 'Nombre total de vaisseaux et défenses défendant la planète : '.count_flotte($roundDefenseur[0])."\n";
		$conv .= '----------------------------------------------------------------'."\n";
	}
	$conv .= "\n";
	if ($comment == '') {
		$conv .= 'Après '.$nbRound.' rounds'."\n";
	} else {
		$conv .= $comment."\n";
	}
	$conv .= "\n";
	if ($pub_resum != ' checked') {
		$conv .= 'Attaquant '.$size_opening.'[color=red]'.$attaquant[1].'[/color]'.$size_closing.' [color='.$RC_var['ally'].']( '.$allya2['ally'].' )[/color]'."\n";
		$conv .= ($nbRound == $nbRoundAttaquant) ? $size_opening.'[color='.$RC_var['detr'].']Détruit ![/color]'.$size_closing."\n" : affFlotte($roundAttaquant[$nbRound]);
		$conv .= "\n";
		$conv .= 'Défenseur '.$size_opening.'[color=red]'.$defenseur[1].'[/color]'.$size_closing.' [color='.$RC_var['ally'].']( '.$allyd2['ally'].' )[/color]'."\n";
		$conv .= ($nbRound == $nbRoundDefenseur) ? $size_opening.'[color='.$RC_var['detr'].']Détruit ![/color]'.$size_closing."\n" : affFlotte($roundDefenseur[$nbRound]);
	} else {
		$conv .= '----------------------------------------------------------------'."\n";
		$conv .= 'Il reste '.(($nbRound == $nbRoundAttaquant) ? '0' : count_flotte($roundAttaquant[$nbRound])).' vaisseaux attaquant'."\n";
		$conv .= 'Il reste '.(($nbRound == $nbRoundDefenseur) ? '0' : count_flotte($roundDefenseur[$nbRound])).' vaisseaux et défenses défandant la planète'."\n";
		$conv .= '----------------------------------------------------------------'."\n";
	}
	$conv .= "\n";
	if ($nbRoundAttaquant > $nbRoundDefenseur)
	{
		$conv .= 'L\'attaquant remporte la bataille'."\n";
		$conv .= 'Il remporte '.$size_opening.'[color='.$RC_var['met'].']'.convNumber($pillage[1]).'[/color]'.$size_closing.' de métal, '.$size_opening.'[color='.$RC_var['cris'].']'.convNumber($pillage[2]).'[/color]'.$size_closing.' de cristal et '.$size_opening.'[color='.$RC_var['deut'].']'.convNumber($pillage[3]).'[/color]'.$size_closing.' de deutérium'."\n";
	} else if ($nbRoundAttaquant < $nbRoundDefenseur) {
		$conv .= 'Le défenseur remporte la bataille'."\n";
	} else if ($nbRoundAttaquant == $nbRoundDefenseur) {
		$conv .= 'La bataille se termine par un match nul'."\n";
	} else {
		die("Erreur");
	}
	$conv .= "\n";
	$conv .= 'L\'attaquant a perdu '.$size_opening.'[color=red]'.convNumber($pertesA[1]).'[/color]'.$size_closing.' unités'."\n";
	$conv .= 'Le défenseur a perdu '.$size_opening.'[color=red]'.convNumber($pertesD[1]).'[/color]'.$size_closing.' unités';
	if (!is_null($recyclage)) $conv .= "\n".'Un champ de débris contenant '.$size_opening.'[color=orange]'.convNumber($recyclage[1]).'[/color]'.$size_closing.' de métal et '.$size_opening.'[color=orange]'.convNumber($recyclage[2]).'[/color]'.$size_closing.' de cristal se forme dans l\'orbite de la planète';
	if (!is_null($plune)) $conv .= "\n".'La probabilité de création de lune est de '.$size_opening.'[color=red]'.$plune[1].'%[/color]'.$size_closing;
	if (!is_null($plune) AND !is_null($lune)) $conv .= "\n".'[color=red]Une lune se forme dans l\'orbite de la planète![/color]';
	if ($pub_renta == ' checked') {
		$conv .= "\n\n".'[u]Rentabilité :[/u]'."\n";
		$conv .= 'Attaquant [color=green]avec[/color]/[color=red]sans[/color] recyclage : '.$size_opening.'[color=green]'.convNumber($rentar).'[/color]/[color=red]'.convNumber($rentasr).$size_closing.'[/color]'."\n";
		$conv .= 'Défenseur [color=red]avec[/color]/[color=green]sans[/color] recyclage : '.$size_opening.'[color=red]'.convNumber($perter).'[/color]/[color=green]'.convNumber($pertesr).$size_closing.'[/color]';
	}
	$conv .= convfooter("RC");
	$conv .= $footer;
	
	return 'Rapport converti<br><textarea rows=\'10\' cols=\'10\'>'.$conv.'</textarea>';
}

function converter_g ($data) {
	global $db, $pub_quote, $pub_size, $pub_sizeSize, $pub_center, $date;
	global $RC_var, $pub_noTechs, $pub_noCoords, $pub_renta, $pub_resum;
	global $nb_A, $nb_D, $A, $D;
	
	//Récupère le nombre de round
	$nbRound = preg_match_all("#La\sflotte\sattaquante#", $data, $Rounds);
	
	
	// Récupère les pertes des attaquants
	preg_match('#L\'attaquant\sa\sperdu\sau\stotal\s((?:\.?\d*)+)\sunités\.#', $data, $pertesA).'<br>';
	// Récupère les pertes des défenseurs
	preg_match('#Le\sdéfenseur\sa\sperdu\sau\stotal\s((?:\.?\d*)+)\sunités\.#', $data, $pertesD).'<br>';
	// Récupère les ressources pillées
	preg_match('#((?:\.?\d*)+)\sunités\sde\smétal,\s((?:\.?\d*)+)\sunités\sde\scristal\set\s((?:\.?\d*)+)\sunités\sde\sdeutérium#', $data, $pillage);
	// Récupère le champ de débris
	if (!preg_match('#Un\schamp\sde\sdébris\scontenant\s((?:\.?\d*)+)\sunités\sde\smétal\set\s((?:\.?\d*)+)\sunités\sde\scristal\sse\sforme\sdans\sl\'orbite\sde\scette\splanète#', $data, $recyclage)) $recyclage = null; 
	// Récupère le pourcentage de cération de lune
	if (!preg_match('#La\sprobabilité\sde\scréation\sd\'une\slune\sest\sde\s(\d*)\s%#', $data, $plune)) $plune = null;
	// Vérifie si une lune a été créée
	if (!preg_match('#Les\squantités\sénormes\sde\smétal\set\sde\scristal\ss\'attirent,\sformant\sainsi\sune\slune\sdans\sl\'orbite\sde\scette\splanète\.#', $data)) $lune = null; else $lune = 1;
	
	//Met en forme la date
	$date = date('d/m/Y à H:i:s', mktime($date[3],$date[4],$date[5],$date[1],$date[2], date('Y')));
	
	//Recherche l'alliance des attaquants et des défenseurs
	
	
	//Reformate les nombres de ressources
	$pillage = preg_replace("#\.#", "", $pillage);
	$recyclage = preg_replace("#\.#", "", $recyclage);
	$pertesA = preg_replace("#\.#", "", $pertesA);
	$pertesD = preg_replace("#\.#", "", $pertesD);
	
	
	//Récupère le commentaire des rounds
	$comment = (!empty($pub_comment)) ? $pub_comment : '';
	
	$header = (($pub_quote == ' checked') ? '[quote]' : '').(($pub_center == ' checked') ? '[center]' : '');
	$footer = (($pub_center == ' checked') ? '[/center]' : '').(($pub_quote == ' checked') ? '[/quote]' : '');
	$size_opening = (($pub_size == ' checked') ? '[size='.$pub_sizeSize.']' : '').'[b]';
	$size_closing = '[/b]'.(($pub_size == ' checked') ? '[/size]' : '');
	
	$conv  = $header.'Les flottes suivantes se sont affrontées le '.$date."\n";
	$i = 0;
	$nbv_A = 0;
	while ($i < $nb_A) {
		//Recherche de l'alliance du joueur
		$request = "SELECT * FROM ".TABLE_UNIVERSE." WHERE player = '".$A[$i][1]."'";
		$query = $db->sql_query($request);
		$ally_A[$i] = $db->sql_fetch_assoc($query);
		
		if ($pub_resum != ' checked') {
			$conv .= "\n";
			$conv .= 'Attaquant '.$size_opening.'[color=red]'.$A[$i][1].'[/color]'.$size_closing.(($ally_A[$i]['ally'] != '') ? ' [color='.$RC_var['ally'].']( '.$ally_A[$i]['ally'].' )[/color]' : '').' ('.(($pub_noCoords==' checked') ? $A[$i][2] : 'x:xxx:x').')'."\n";
			$conv .= 'Armes: '.(($pub_noTechs == ' checked') ? $A[$i][3] : 'XXX').'% - Bouclier: '.(($pub_noTechs==' checked') ? $A[$i][4] : 'XXX').'% - Coque: '.(($pub_noTechs==' checked') ? $A[$i][5] : 'XXX').'%'."\n";
			$conv .= affFlotte($A[$i], 6);
		} else {
			$nbv_A += count_flotte($A[$i], 6);
		}
		
		if (!preg_match("#Attaquant\s".$A[$i][1]."\s\(".$A[$i][2]."\)\nDétruit#", $data)) {
			// Récupère la flotte de l'attaquant
			preg_match_all('#Attaquant\s'.$A[$i][1].'\s\('.$A[$i][2].'\)\n?(Armes:\s\d{2,}%\sBouclier:\s\d{2,}%\sCoque:\s\d{2,}%\n?)?Type\s(.*)\n?Nombre\s(.*)\n?Armes:#', $data, $roundA[$i], PREG_SET_ORDER);
		}
		$i++;
	}
	
	$i = 0;
	$nbv_D = 0;
	$nbd_D = 0;
	while ($i < $nb_D) {
		//Recherche de l'alliance du joueur
		$request = "SELECT * FROM ".TABLE_UNIVERSE." WHERE player = '".$D[$i][1]."'";
		$query = $db->sql_query($request);
		$ally_D[$i] = $db->sql_fetch_assoc($query);
		
		if ($pub_resum != ' checked') {
			$conv .= "\n";
			$conv .= 'Défenseur '.$size_opening.'[color=red]'.$D[$i][1].'[/color]'.$size_closing.(($ally_D[$i]['ally'] != '') ? ' [color='.$RC_var['ally'].']( '.$ally_D[$i]['ally'].' )[/color]' : '').' ('.(($pub_noCoords==' checked') ? $D[$i][2] : 'x:xxx:x').')'."\n";
			$conv .= 'Armes: '.(($pub_noTechs == ' checked') ? $D[$i][3] : 'XXX').'% - Bouclier: '.(($pub_noTechs==' checked') ? $D[$i][4] : 'XXX').'% - Coque: '.(($pub_noTechs==' checked') ? $D[$i][5] : 'XXX').'%'."\n";
			$conv .= affFlotte($D[$i], 6);
		} else {
			$nbv_D += count_flotte($D[$i], 6, 2);
			$nbd_D += count_flotte($D[$i], 6, 3);
		}
		
		if (!preg_match("#Défenseur\s".$D[$i][1]."\s\(".$D[$i][2]."\)\nDétruit#", $data)) {
			// Récupère la flotte de l'attaquant
			preg_match_all('#Défenseur\s'.$D[$i][1].'\s\('.$D[$i][2].'\)\n?(Armes:\s\d{2,}%\sBouclier:\s\d{2,}%\sCoque:\s\d{2,}%\n?)?Type\s(.*)\n?Nombre\s(.*)\n?Armes:#', $data, $roundD[$i], PREG_SET_ORDER);
		}
		$i++;
	}
	
	if ($pub_resum == ' checked') {
		$conv .= "\n";
		$conv .= '----------------------------------------------------------------'."\n";
		$conv .= 'Nombre d\'attaquant : '.$nb_A."\n";
		$conv .= 'Nombre de défenseur : '.$nb_D."\n";
		$conv .= "\n";
		$conv .= 'Total de '.$size_opening.convColor($nbv_A).$size_closing.' vaisseaux attaquant'."\n";
		$conv .= 'Total de '.$size_opening.convColor($nbv_D).$size_closing.' vaisseaux et '.$size_opening.convColor($nbd_D).$size_closing.' défenses défendant la planète'."\n";
		$conv .= '----------------------------------------------------------------'."\n";
	}
	
	$conv .= "\n";
	if ($comment == '') {
		$conv .= 'Après '.$nbRound.' rounds'."\n";
	} else {
		$conv .= $comment."\n";
	}
	
	$i = 0;
	$nbvr_A = 0;
	while ($i < $nb_A) {
		if ($pub_resum != ' checked') {
			$conv .= "\n";
			$conv .= 'Attaquant '.$size_opening.'[color=red]'.$A[$i][1].'[/color]'.$size_closing.(($ally_A[$i]['ally'] != '') ? ' [color='.$RC_var['ally'].']( '.$ally_A[$i]['ally'].' )[/color]' : '').' ('.(($pub_noCoords == ' checked') ? $A[$i][2] : 'x:xxx:x').')'."\n";
			if (!empty($roundA[$i][$nbRound])) {
				$conv .= affFlotte($roundA[$i][$nbRound]);
			} else {
				$conv .= 'Détruit !';
				$conv .= "\n";
			}
		} else {
			if (!empty($roundA[$i][$nbRound])) {
				$nbvr_A += count_flotte($roundA[$i][$nbRound]);
			}
		}
		$i++;
	}
	$i = 0;
	$nbvr_D = 0;
	$nbdr_D = 0;
	while ($i < $nb_D) {
		if ($pub_resum != ' checked') {
			$conv .= "\n";
			$conv .= 'Défenseur '.$size_opening.'[color=red]'.$D[$i][1].'[/color]'.$size_closing.(($ally_D[$i]['ally'] != '') ? ' [color='.$RC_var['ally'].']( '.$ally_D[$i]['ally'].' )[/color]' : '').' ('.(($pub_noCoords==' checked') ? $D[$i][2] : 'x:xxx:x').')'."\n";
			if (!empty($roundD[$i][$nbRound])) {
				$conv .= affFlotte($roundD[$i][$nbRound]);
			} else {
				$conv .= 'Détruit !';
				$conv .= "\n";
			}
		} else {
			if (!empty($roundD[$i][$nbRound])) {
				$nbvr_D += count_flotte($roundD[$i][$nbRound], 2, 2);
				$nbdr_D += count_flotte($roundD[$i][$nbRound], 2, 3);
			}
		}
		$i++;
	}
	
	if ($pub_resum == ' checked') {
		$conv .= "\n";
		$conv .= '---------------------------------------------------------------'."\n";
		$conv .= 'Il reste '.$size_opening.convColor($nbvr_A).$size_closing.' vaisseaux attaquant'."\n";
		$conv .= 'Il reste '.$size_opening.convColor($nbvr_D).$size_closing.' vaisseaux et '.$size_opening.convColor($nbdr_D).$size_closing.' défenses défendant la planète'."\n";
		$conv .= '----------------------------------------------------------------'."\n";
	}
	
	$conv .= "\n";
	if (!empty($roundA) AND !empty($roundD)) {
		$conv .= 'La bataille se termine par un match nul'."\n";
		$ressource = 0;
	} else if (empty($roundA) AND !empty($roundD)) {
		$conv .= 'Le défenseur remporte la bataille'."\n";
		$ressource = 0;
	} else if (!empty($roundA) AND empty($roundD)) {
		$conv .= 'L\'attaquant remporte la bataille'."\n";
		$conv .= 'Il remporte '.$size_opening.'[color='.$RC_var['met'].']'.convNumber($pillage[1]).'[/color]'.$size_closing.' de métal, '.$size_opening.'[color='.$RC_var['cris'].']'.convNumber($pillage[2]).'[/color]'.$size_closing.' de cristal et '.$size_opening.'[color='.$RC_var['deut'].']'.convNumber($pillage[3]).'[/color]'.$size_closing.' de deutérium'."\n";
		$ressource = $pillage[1] + $pillage[2] + $pillage[3];
	} else {
		die('Error');
	}
	$conv .= "\n";
	
	$conv .= 'L\'attaquant a perdu '.$size_opening.'[color=red]'.convNumber($pertesA[1]).'[/color]'.$size_closing.' unités'."\n";
	$conv .= 'Le défenseur a perdu '.$size_opening.'[color=red]'.convNumber($pertesD[1]).'[/color]'.$size_closing.' unités';
	if (!is_null($recyclage)) $conv .= "\n".'Un champ de débris contenant '.$size_opening.'[color=orange]'.convNumber($recyclage[1]).'[/color]'.$size_closing.' de métal et '.$size_opening.'[color=orange]'.convNumber($recyclage[2]).'[/color]'.$size_closing.' de cristal se forme dans l\'orbite de la planète';
	if (!is_null($plune)) $conv .= "\n".'La probabilité de création de lune est de '.$size_opening.'[color=red]'.$plune[1].'%[/color]'.$size_closing;
	if (!is_null($plune) AND !is_null($lune)) $conv .= "\n".'[color=red]Une lune se forme dans l\'orbite de la planète![/color]';
	
	// Calcul de la rentabilité
	$rentar = $ressource + $recyclage[1] + $recyclage[2] - $pertesA[1];
	$rentasr = $ressource - $pertesA[1];
	$perter = $recyclage[1] + $recyclage[2] - $ressource - $pertesD[1];
	$pertesr = - $ressource - $pertesD[1];
	
	if ($pub_renta == ' checked') {
		$conv .= "\n\n".'[u]Rentabilité :[/u]'."\n";
		$conv .= 'Attaquant [color=green]avec[/color]/[color=red]sans[/color] recyclage : '.$size_opening.'[color=green]'.convNumber($rentar).'[/color]/[color=red]'.convNumber($rentasr).$size_closing.'[/color]'."\n";
		$conv .= 'Défenseur [color=red]avec[/color]/[color=green]sans[/color] recyclage : '.$size_opening.'[color=red]'.convNumber($perter).'[/color]/[color=green]'.convNumber($pertesr).$size_closing.'[/color]';
	}
	$conv .= convfooter("RC");
	$conv .= $footer;
	
	return 'Rapport converti<br><textarea rows=\'10\' cols=\'10\'>'.$conv.'</textarea>';
}

function affFlotte($data, $deb = 2) {
	global $RC_var, $ship_a, $pub_format;
	
	if ($deb == 2) {
		$vaisseaux = split(' ', $data[2]);
		$nb = split(' ', $data[3]);
	} else {
		$vaisseaux = split(' ', $data[6]);
		$nb = split(' ', $data[7]);
	}
	$nb = preg_replace("#\.#", "", $nb);
	$output1 = '';
	$output2 = '';
	
	$nb_v = count($vaisseaux);
	$i = 0;
	while ($i < $nb_v) {
		$key = array_search($vaisseaux[$i], $ship_a);
		if ($pub_format == 1) {
			$h = ($i == 0) ? '' : ', ';
			$output1 .= $h.'[color='.$RC_var[$key].']'.convNumber($nb[$i]).' '.$vaisseaux[$i].'[/color]';
		} else if ($pub_format == 2) {
			$output1 .= '[color='.$RC_var[$key].']'.$vaisseaux[$i].'[/color] ';
			$output2 .= '[color='.$RC_var[$key].']'.convNumber($nb[$i]).'[/color] ';
		} else if ($pub_format == 'c') {
			$output1 .= '[color='.$RC_var[$key].']'.convNumber($nb[$i]).' '.$vaisseaux[$i].'[/color]'."\n";
		}
		$i++;
	}
	if ($pub_format == 1) {
		$output = $output1."\n";
	} else if ($pub_format == 2) {
		$output = $output1."\n".$output2."\n";
	} else if ($pub_format == 'c') {
		$output = $output1;
	}
	return $output;
}

function count_flotte ($data, $deb = 2, $type = 1) {
	global $def_c;
	
	if ($type == 1) {
		if ($deb == 2) {
			$nb = split(' ', $data[3]);
		} else {
			$nb = split(' ', $data[7]);
		}
		
		$nb = preg_replace("#\.#", "", $nb);
		
		$nb_v = count($nb);
		$i = 0;
		$nbre = 0;
		while ($i < $nb_v) {
			$nbre += $nb[$i++];
		}
	} else if ($type == 2) {
		if ($deb == 2) {
			$vaisseaux = split(' ', $data[2]);
			$nb = split(' ', $data[3]);
		} else {
			$vaisseaux = split(' ', $data[6]);
			$nb = split(' ', $data[7]);
		}
		
		$nb = preg_replace("#\.#", '', $nb);
		
		$nb_v = count($nb);
		$i = 0;
		$nbre = 0;
		while ($i < $nb_v) {
			if (!array_search($vaisseaux[$i], $def_c) OR is_null(array_search($vaisseaux[$i], $def_c))) {
				$nbre += $nb[$i];
			}
			$i++;
		}
	} else if ($type == 3) {
		if ($deb == 2) {
			$vaisseaux = split(' ', $data[2]);
			$nb = split(' ', $data[3]);
		} else {
			$vaisseaux = split(' ', $data[6]);
			$nb = split(' ', $data[7]);
		}
		
		$nb = preg_replace("#\.#", '', $nb);
		
		$nb_v = count($nb);
		$i = 0;
		$nbre = 0;
		while ($i < $nb_v) {
			if (array_search($vaisseaux[$i], $def_c) OR !is_null(array_search($vaisseaux[$i], $def_c))) {
				$nbre += $nb[$i];
			}
			$i++;
		}
	}
	
	return $nbre;
}
?>