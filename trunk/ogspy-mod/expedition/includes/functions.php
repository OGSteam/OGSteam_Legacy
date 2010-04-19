<?php


if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct


// Pour le formattage des nombres
function format ( $number, $e = 0 )
{
	return number_format($number, $e, ',', '.');
}

// recupérer le nombre d'unite d'une flotte
function calculUnits($tabFlotte)
{
	$units = 0;
	$units += ( 2  + 2  + 0  ) * $tabFlotte['sumpt'];
	$units += ( 6  + 6  + 0  ) * $tabFlotte['sumgt'];
	$units += ( 3  + 1  + 0  ) * $tabFlotte['sumcle'];
	
	$units += ( 6  + 4  + 0  ) * $tabFlotte['sumclo'];
	$units += ( 20 + 7  + 2  ) * $tabFlotte['sumcr'];
	$units += ( 45 + 15 + 0  ) * $tabFlotte['sumvb'];
	
	$units += ( 10 + 20 + 10 ) * $tabFlotte['sumvc'];
	$units += ( 10 + 6  + 2  ) * $tabFlotte['sumrec'];
	$units += ( 0  + 1  + 0  ) * $tabFlotte['sumse'];
	
	$units += ( 50 + 25 + 15 ) * $tabFlotte['sumbmb'];
	$units += ( 60 + 50 + 15 ) * $tabFlotte['sumdst'];
	$units += ( 30 + 40 + 15 ) * $tabFlotte['sumtra'];
	return $units;
}

// recupérer le nom de quelqu'un
function getuserNameById($uid)
{
	global $db, $eXpDebug;
	$query = 
				"SELECT user_name
			 	FROM ".TABLE_USER."
			 	WHERE user_id = $uid ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	list($nom) = $db->sql_fetch_row($result);
	return $nom;
}


// recupérer les options de quelqu'un
function getOpts($uid, $opt)
{
	global $db, $eXpDebug;
	$query = 
				"SELECT val
			 	FROM ".TABLE_EXPEDITION_OPTS."
			 	WHERE user_id = $uid 
				and opts = $opt";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	if($db->sql_numrows($result) == 0)
	{
		return 0; // Valeur par défaut...
	}
	list($value) = $db->sql_fetch_row($result);
	return $value;
}


// définir les options de quelqu'un
function setOpts($uid, $opt, $value)
{
	global $db, $eXpDebug;
	$query = 
				"SELECT val
			 	FROM ".TABLE_EXPEDITION_OPTS."
			 	WHERE user_id = $uid 
				and opts = $opt";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	if($db->sql_numrows($result) == 0)
	{	
		$query = 
				"Insert into ".TABLE_EXPEDITION_OPTS."
				(id, user_id, opts, val)
				values ('', $uid, $opt, $value)";
		$db->sql_query($query);
	}
	else
	{
		$query = 
				"Update ".TABLE_EXPEDITION_OPTS."
				Set val = $value
			 	WHERE user_id = $uid 
				and opts = $opt";
		$db->sql_query($query);
	}
}


// lire le contenu de la base
function readDB($uid = 0, $datedeb = 0, $datefin = 0)
//Retourne un tableau associatif concernant toutes les stats
//$uid correspond à l'id user si = 0 alors tous les users sont pris en compte...
{

	// On commence par chercher le nombre d'expeditions par type de l'utilisateur :
	global $db, $eXpDebug;

	// Expedition ratée
	$query = 
				"SELECT count(*), type
			 	FROM ".TABLE_EXPEDITION."
			 	WHERE type = 0 ";
if($uid != 0) $query .= 	"and user_id = $uid ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin  ";
	$query .=	"group by type";
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	list($res['nombreExpRate']) = $db->sql_fetch_row($result);
	// Si y'en a pas on met 0
	if($res['nombreExpRate'] == ''){$res['nombreExpRate'] = 0;}



	// Expedition ressource
	$query = 
			"SELECT count(*), type 
			FROM ".TABLE_EXPEDITION." 
			WHERE type = 1 ";
if($uid != 0) $query .= 	"and user_id = $uid ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin  ";
	$query .=	"group by type ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	list($res['nombreExpRess']) = $db->sql_fetch_row($result);
	// Si y'en a pas on met 0
	if($res['nombreExpRess'] == ''){$res['nombreExpRess'] = 0;}



	// Expedition vaisseau
	$query = 
			"SELECT count(*), type 
			FROM ".TABLE_EXPEDITION." 
			WHERE type = 2 ";
if($uid != 0) $query .= 	"and user_id = $uid ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin  ";
	$query .=	"group by type ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	list($res['nombreExpVaiss']) = $db->sql_fetch_row($result);
	// Si y'en a pas on met 0
	if($res['nombreExpVaiss'] == ''){$res['nombreExpVaiss'] = 0;}



	//Expedition marchand
	$query = 
			"SELECT count(*), type 
			FROM ".TABLE_EXPEDITION." 
			WHERE type = 3 ";
if($uid != 0) $query .= 	"and user_id = $uid ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin  ";
	$query .=	"group by type ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	list($res['nombreExpMarch']) = $db->sql_fetch_row($result);
	// Si y'en a pas on met 0
	if($res['nombreExpMarch'] == ''){$res['nombreExpMarch'] = 0;}
	


	// Nombre d'expédition total
	$res['nombreExpTot'] = $res['nombreExpRate'] + $res['nombreExpRess'] + $res['nombreExpVaiss'] + $res['nombreExpMarch'];
	// Calcul des pourcentages
	if($res['nombreExpTot'] == 0)
	{
		$res['pourcentExpRate'] = 0;
		$res['pourcentExpRess'] = 0;
		$res['pourcentExpVaiss'] = 0;
		$res['pourcentExpMarch'] = 0;
	}
	else
	{
		$res['pourcentExpRate'] = round(($res['nombreExpRate'] * 100) / $res['nombreExpTot']);
		$res['pourcentExpRess'] = round(($res['nombreExpRess'] * 100) / $res['nombreExpTot']);
		$res['pourcentExpVaiss'] = round(($res['nombreExpVaiss'] * 100) / $res['nombreExpTot']);
		$res['pourcentExpMarch'] = round(($res['nombreExpMarch'] * 100) / $res['nombreExpTot']);
	}
	// Ensuite on cherche les ressources qu'il a gagné en tout :
	$query = 
			"SELECT sum(metal), sum(cristal), sum(deuterium), sum(antimatiere)
			FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			WHERE e.id = t1.id_eXpedition ";
if($uid != 0) $query .= 	"and user_id =$uid ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin  ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	list($res['sumMetal'], $res['sumCristal'], $res['sumDeuterium'], $res['sumAntiMat']) = $db->sql_fetch_row($result);
	// Si y'en a pas on met 0
	if($res['sumMetal'] == ''){$res['sumMetal'] = 0;}
	if($res['sumCristal'] == ''){$res['sumCristal'] = 0;}
	if($res['sumDeuterium'] == ''){$res['sumDeuterium'] = 0;}
	if($res['sumAntiMat'] == ''){$res['sumAntiMat'] = 0;}
	
	// puis les vaisseaux : 
	$query = 
		"SELECT sum(pt), sum(gt), sum(cle), sum(clo), sum(cr), sum(vb), sum(vc), sum(rec), sum(se), sum(bmb), sum(dst), sum(tra)
		FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_2." AS t2
		WHERE e.id = t2.id_eXpedition ";
if($uid != 0) $query .= 	"and user_id =$uid ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin  ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	list($res['sumpt'], $res['sumgt'], $res['sumcle'], $res['sumclo'], $res['sumcr'], $res['sumvb'], $res['sumvc'], $res['sumrec'], $res['sumse'], $res['sumbmb'], $res['sumdst'], $res['sumtra']) = $db->sql_fetch_row($result);
	// Si y'en a pas on met 0
	if($res['sumpt'] == ''){$res['sumpt'] = 0;}
	if($res['sumgt'] == ''){$res['sumgt'] = 0;}
	if($res['sumcle'] == ''){$res['sumcle'] = 0;}
	if($res['sumclo'] == ''){$res['sumclo'] = 0;}
	if($res['sumcr'] == ''){$res['sumcr'] = 0;}
	if($res['sumvb'] == ''){$res['sumvb'] = 0;}
	if($res['sumvc'] == ''){$res['sumvc'] = 0;}
	if($res['sumrec'] == ''){$res['sumrec'] = 0;}
	if($res['sumse'] == ''){$res['sumse'] = 0;}
	if($res['sumbmb'] == ''){$res['sumbmb'] = 0;}
	if($res['sumdst'] == ''){$res['sumdst'] = 0;}
	if($res['sumtra'] == ''){$res['sumtra'] = 0;}
	// calcul des unités
	$res['sumUpt']  = ( 2  + 2  + 0  ) * $res['sumpt'];
	$res['sumUgt']  = ( 6  + 6  + 0  ) * $res['sumgt'];
	$res['sumUcle'] = ( 3  + 1  + 0  ) * $res['sumcle'];
	$res['sumUclo'] = ( 6  + 4  + 0  ) * $res['sumclo'];
	$res['sumUcr']  = ( 20 + 7  + 2  ) * $res['sumcr'];
	$res['sumUvb']  = ( 45 + 15 + 0  ) * $res['sumvb'];
	$res['sumUvc']  = ( 10 + 20 + 10 ) * $res['sumvc'];
	$res['sumUrec'] = ( 10 + 6  + 0  ) * $res['sumrec'];
	$res['sumUse']  = ( 0  + 1  + 0  ) * $res['sumse'];
	$res['sumUbmb'] = ( 50 + 25 + 15 ) * $res['sumbmb'];
	$res['sumUdst'] = ( 60 + 50 + 15 ) * $res['sumdst'];
	$res['sumUtra'] = ( 30 + 40 + 15 ) * $res['sumtra'];
	//et enfin les marchands :
	$query = 
		"SELECT count(*) 
		FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_3." AS t3
		WHERE e.id = t3.id_eXpedition ";
if($uid != 0) $query .= 	"and user_id =$uid ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin  ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	list($res['sumM']) = $db->sql_fetch_row($result);
	// Si y'en a pas on met 0
	if($res['sumM']== ''){$res['sumM'] = 0;}

	// on veux enfin recuperer la date d'origine des rapport en tout
	$query = 
			" SELECT min(date)
			  FROM ".TABLE_EXPEDITION;
if($uid != 0) $query .= " WHERE user_id = $uid ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	list($res['dateOrigine']) = $db->sql_fetch_row($result);

	// et si on calculait la moyenne et le total... !
	$res['totRess'] = $res['sumMetal'] + $res['sumCristal'] + $res['sumDeuterium'];
	$res['totPtRess'] = round( $res['totRess'] / 1000);
	$res['totVaiss'] = $res['sumpt'] + $res['sumgt'] + $res['sumcle'] + $res['sumclo'] + $res['sumcr'] + $res['sumvb'] + $res['sumvc'] + $res['sumrec'] + $res['sumse'] + $res['sumbmb'] + $res['sumdst'] + $res['sumtra'];
	$res['totUVaiss'] = calculUnits($res);
	
	if($res['nombreExpTot'] == 0)
	{
		$res['moyRess'] = 0;
		$res['moyVaiss'] = 0;
		$res['moyUVaiss'] = 0;
	}
	else
	{
		$res['moyRess']   = round( $res['totRess']    /  $res['nombreExpTot']);
		$res['moyVaiss']  = round($res['totVaiss']   /  $res['nombreExpTot']);
		$res['moyUVaiss'] = round($res['totUVaiss']  /  $res['nombreExpTot']);
	}
	if($res['nombreExpVaiss'] == 0)
	{
		$res['moyVVaiss'] = 0;
		$res['moyUVVaiss'] = 0;
	}
	else
	{
		$res['moyVVaiss']  = round($res['totVaiss']   /  $res['nombreExpVaiss']);
		$res['moyUVVaiss'] = round($res['totUVaiss']  /  $res['nombreExpVaiss']);
	}
	return $res;
}


// analyser les rapports ajoutés
function analyseRapport($uid)
{
	global $db, $eXpDebug;

	// Tout d'abord si il a été soumis un RExp :
	if ( isset($_POST['datas'] ) ) 
	{
		$regExVaiss =     "#(\d{2})-(\d{2})\s*(\d{2}):(\d{2}):(\d{2})\s*Quartier\s*général\s*Résultat\s*de\s*l'expédition\s*\[(\d+):(\d+):16\]\s+(\D.*)(\n|\s*)*Votre\sflotte\ss'est\sagrandie,\svoici\sles\snouveaux\svaisseaux\squi\ss'y\ssont\sjoints\s:\n((.+\n)+)\n*(\D*)\n*#";
		$regExRess =      "#(\d{2})-(\d{2})\s*(\d{2}):(\d{2}):(\d{2})\s*Quartier\s*général\s*Résultat\s*de\s*l'expédition\s*\[(\d+):(\d+):16\]\s+(\D.*)(\n|\s*)*Vous\savez\scollecté\s(\d+)\sunités\sde\s(\S+)\s+\n*(\D*)\n*#";
		$regExRien =      "#(\d{2})-(\d{2})\s*(\d{2}):(\d{2}):(\d{2})\s*Quartier\s*général\s*Résultat\s*de\s*l'expédition\s*\[(\d+):(\d+):16\]\s+(\D*)\n*\s*#";
		$regExMarchand1 = "#(\d{2})-(\d{2})\s*(\d{2}):(\d{2}):(\d{2})\s*Quartier\s*général\s*Résultat\s*de\s*l'expédition\s*\[(\d+):(\d+):16\]\s+\D*liste\sde\sclients\sprivilégiés\D*\n*\s*#";
		$regExMarchand2 = "#(\d{2})-(\d{2})\s*(\d{2}):(\d{2}):(\d{2})\s*Quartier\s*général\s*Résultat\s*de\s*l'expédition\s*\[(\d+):(\d+):16\]\s+\D*dans\svotre\sempire\sun\sreprésentant\schargé\sde\sressources\sà\séchanger\D*\n*\s*#";
		// on enleve les séparateurs
		$_POST['datas'] = str_replace('.', '', $_POST['datas']);
		//Compatibilité UNIX/Windows
		$_POST['datas'] = str_replace("\r\n","\n",$_POST['datas']);
		//Compatibilité IE/Firefox
		$_POST['datas'] = str_replace("\t",' ',$_POST['datas']);
		//pour l'apostrophe !	
		$_POST['datas'] = stripslashes($_POST['datas']);
		$_POST['datas'] .= " 00-00";
		
		//et on extrait les entetes !!	
		$nbRapportVaiss = preg_match_all($regExVaiss, $_POST['datas'], $expsVaiss, PREG_PATTERN_ORDER);
		$_POST['datas'] = preg_replace($regExVaiss, '', $_POST['datas']);

		$nbRapportRess = preg_match_all($regExRess, $_POST['datas'], $expsRess, PREG_PATTERN_ORDER);
		$_POST['datas'] = preg_replace($regExRess, '', $_POST['datas']);

		$nbRapportMarchand1 = preg_match_all($regExMarchand1, $_POST['datas'], $expsMarchand1, PREG_PATTERN_ORDER);
		$_POST['datas'] = preg_replace($regExMarchand1, '', $_POST['datas']);
		
		$nbRapportMarchand2 = preg_match_all($regExMarchand2, $_POST['datas'], $expsMarchand2, PREG_PATTERN_ORDER);
		$_POST['datas'] = preg_replace($regExMarchand2, '', $_POST['datas']);
		
		$nbRapportRien = preg_match_all($regExRien, $_POST['datas'], $expsRien, PREG_PATTERN_ORDER);
		$_POST['datas'] = preg_replace($regExRien, '', $_POST['datas']);
		
		if($eXpDebug && !preg_match("#^\s*00-00\s*#", $_POST['datas']))
		{
			echo("<br /> Texte non traite : ".$_POST['datas']." <br />");
		}
		
		$nbRapportMarchand = $nbRapportMarchand1 + $nbRapportMarchand2;
		
		//on calcul le nombre de rapport analysés
		$nbRapport = $nbRapportRien + $nbRapportRess + $nbRapportVaiss + $nbRapportMarchand;

		if($nbRapport == 0)
		{
			echo('<big><big><big> Aucun Rapport Valide Trouve ! </big></big></big> <br />');
		}
		else
		{
			echo('<big><big><big>OK :)</big></big></big> <br />');
			echo("<br /><big><big>".$nbRapport." rapports d'eXpedition détéctés !<br />");
			echo("dont : ".$nbRapportRess." de ressource ".$nbRapportVaiss." de vaisseau ".$nbRapportMarchand." de marchand et ".$nbRapportRien." d'echec </big></big><br /><br />");
			if ($nbRapportMarchand1) 
			{
				for($i = 0 ; $i < $nbRapportMarchand1 ; $i++)
				{
					//recherche de l'année :
					if( $expsMarchand1[1][$i] > date('m'))
					{
						//on a changé d'année entre temps
						$year = date('Y') - 1;
					}
					else
					{
						//sinon c'est l'année courante
						$year = date('Y');			
					}
					$timestmp = mktime($expsMarchand1[3][$i], $expsMarchand1[4][$i] , $expsMarchand1[5][$i], $expsMarchand1[1][$i], $expsMarchand1[2][$i], $year);
					$galaxy = $expsMarchand1[6][$i];
					$systeme = $expsMarchand1[7][$i];
					$dateTmp = date('d-m-Y H:i:s', $timestmp);
					if($eXpDebug)
					{
						echo("-Rapport marchand <br />-");
						echo("Date : $timestmp ou encore : $dateTmp  ! <br />");
						echo("Coordonnees : [$galaxy:$systeme:16]  <br />");
					}
			
					$query = 
						"Select * 
						From ".TABLE_EXPEDITION." 
						Where user_id = $uid 
						and date = $timestmp 
						and pos_galaxie = $galaxy 
						and pos_sys = $systeme and type = 3";
					if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);

					if($db->sql_numrows($result) == 0)
					{
						$query = 
							"Insert into ".TABLE_EXPEDITION." 
							(id, user_id, date, pos_galaxie, pos_sys, type) 
							values ('', $uid, $timestmp, $galaxy, $systeme, 3)";
						$db->sql_query($query);
						$idInsert = $db->sql_insertid();
						$query = 
							"Insert into ".TABLE_EXPEDITION_TYPE_3." 
							(id, id_eXpedition, typeRessource)
							 values ('', $idInsert, 0)";
						$db->sql_query($query);
					}
					else
					{
						echo('<big><big>> Rapport de marchand du '.$dateTmp.' deja ajoute !</big></big> <br />');
					}
				}
			}
			if ($nbRapportMarchand2) 
			{
				for($i = 0 ; $i < $nbRapportMarchand2 ; $i++)
				{
					//recherche de l'année :
					if( $expsMarchand2[1][$i] > date('m'))
					{
						//on a changé d'année entre temps
						$year = date('Y') - 1;
					}
					else
					{
						//sinon c'est l'année courante
						$year = date('Y');			
					}
					$timestmp = mktime($expsMarchand2[3][$i], $expsMarchand2[4][$i] , $expsMarchand2[5][$i], $expsMarchand2[1][$i], $expsMarchand2[2][$i], $year);
					$galaxy = $expsMarchand2[6][$i];
					$systeme = $expsMarchand2[7][$i];
					$dateTmp = date('d-m-Y H:i:s', $timestmp);
					if($eXpDebug)
					{
						echo("-Rapport marchand <br />-");
						echo("Date : $timestmp ou encore : $dateTmp  ! <br />");
						echo("Coordonnees : [$galaxy:$systeme:16]  <br />");
					}
			
					$query = 
						"Select * 
						From ".TABLE_EXPEDITION." 
						Where user_id = $uid 
						and date = $timestmp 
						and pos_galaxie = $galaxy 
						and pos_sys = $systeme and type = 3";
					if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);

					if($db->sql_numrows($result) == 0)
					{
						$query = 
							"Insert into ".TABLE_EXPEDITION." 
							(id, user_id, date, pos_galaxie, pos_sys, type) 
							values ('', $uid, $timestmp, $galaxy, $systeme, 3)";
						$db->sql_query($query);
						$idInsert = $db->sql_insertid();
						$query = 
							"Insert into ".TABLE_EXPEDITION_TYPE_3." 
							(id, id_eXpedition, typeRessource)
							 values ('', $idInsert, 0)";
						$db->sql_query($query);
					}
					else
					{
						echo('<big><big>> Rapport de marchand du '.$dateTmp.' deja ajoute !</big></big> <br />');
					}
				}
			}						
			if ($nbRapportRien) 
			{
				for($i = 0 ; $i < $nbRapportRien ; $i++)
				{
					//recherche de l'année :
					if( $expsRien[1][$i] > date('m'))
					{
						//on a changé d'année entre temps
						$year = date('Y') - 1;
					}
					else
					{
						//sinon c'est l'année courante
						$year = date('Y');			
					}
					$timestmp = mktime($expsRien[3][$i], $expsRien[4][$i] , $expsRien[5][$i], $expsRien[1][$i], $expsRien[2][$i], $year);
					$galaxy = $expsRien[6][$i];
					$systeme = $expsRien[7][$i];
					$dateTmp = date('d-m-Y H:i:s', $timestmp);
					if($eXpDebug)
					{
						echo("-Rapport rien <br />-");
						echo("Date : $timestmp ou encore : $dateTmp  ! <br />");
						echo("Coordonnees : [$galaxy:$systeme:16]  <br />");
						echo("Rapport 1 : ".$expsRien[8][$i]." <br /> <br />"); //blabla1
					}
					$query = 
						"Select * 
						From ".TABLE_EXPEDITION." 
						Where user_id = $uid 
						and date = $timestmp 
						and pos_galaxie = $galaxy 
						and pos_sys = $systeme 
						and type = 0";
					if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
					if($db->sql_numrows($result) == 0)
					{
						$query = 
							"Insert into ".TABLE_EXPEDITION." 
							(id, user_id, date, pos_galaxie, pos_sys, type) 
							values ('', $uid, $timestmp, $galaxy, $systeme, 0)";
						$db->sql_query($query);
						$idInsert = $db->sql_insertid();
						$query = 
							"Insert into ".TABLE_EXPEDITION_TYPE_0." 
							(id, id_eXpedition, typeVitesse) 
							values ('', $idInsert, 0)"; //TODO : Choisir le type !
						$db->sql_query($query);
					}
					else
					{
						echo('<big><big>> Rapport de rien du '.$dateTmp.' deja ajoute ! </big></big> <br />');
					}
				}
			}
			if ($nbRapportRess) 
			{
				for($i = 0 ; $i < $nbRapportRess ; $i++)
				{
					//recherche de l'année :
					if( $expsRess[1][$i] > date('m'))
					{
						//on a changé d'année entre temps
						$year = date('Y') - 1;
					}
					else
					{
						//sinon c'est l'année courante
						$year = date('Y');			
					}
					$timestmp = mktime($expsRess[3][$i], $expsRess[4][$i] , $expsRess[5][$i], $expsRess[1][$i], $expsRess[2][$i], $year);
					$galaxy = $expsRess[6][$i];
					$systeme = $expsRess[7][$i];
					$dateTmp = date('d-m-Y H:i:s', $timestmp);
					if($eXpDebug)
					{
						echo("-Rapport ressource <br />-");
						echo("Date : $timestmp ou encore : $dateTmp  ! <br />");
						echo("Coordonnees : [$galaxy:$systeme:16]  <br />");
						echo("Rapport 1 : ".$expsRess[8][$i]." <br /> <br />"); //blabla1
						echo("Rapport 2 : ".$expsRess[9][$i]." <br /> <br />"); //Quantité
						echo("Rapport 3 : ".$expsRess[10][$i]." <br /> <br />"); //Type
						echo("Rapport 4 : ".$expsRess[11][$i]." <br /> <br />"); //blabla2
						echo("Rapport 5 : ".$expsRess[12][$i]." <br /> <br />"); //blabla3?

					}
					$typeRess = -1;
					if($expsRess[11][$i] == "Métal")
					{
						$typeRess = 0;
						$met = $expsRess[10][$i];
						$cri = 0;
						$deut = 0;
						$antimat = 0;
					}
					if($expsRess[11][$i] == "Cristal")
					{
						$typeRess = 1;
						$met = 0;
						$cri = $expsRess[10][$i];
						$deut = 0;
						$antimat = 0;
					}
					if($expsRess[11][$i] == "Deutérium")
					{
						$typeRess = 2;
						$met = 0;
						$cri = 0;
						$deut = $expsRess[10][$i];
						$antimat = 0;
					}
					if($expsRess[11][$i] == "Antimatière")
					{
						$typeRess = 3;
						$met = 0;
						$cri = 0;
						$deut = 0;
						$antimat = $expsRess[10][$i];
					}
					if($typeRess == -1)
					{
						die("Erreur fatale de parsing");
					}
					$query = 
						"Select * 
						From ".TABLE_EXPEDITION." 
						Where user_id = $uid 
						and date = $timestmp 
						and pos_galaxie = $galaxy 
						and pos_sys = $systeme 
						and type = 1";
					if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
					if($db->sql_numrows($result) == 0)
					{
						$query = 
							"Insert into ".TABLE_EXPEDITION." 
							(id, user_id, date, pos_galaxie, pos_sys, type) 
							values ('', $uid, $timestmp, $galaxy, $systeme, 1)";
						$db->sql_query($query);
						$idInsert = $db->sql_insertid();
						$query = 
							"Insert into ".TABLE_EXPEDITION_TYPE_1." 
							(id, id_eXpedition, typeRessource, metal, cristal, deuterium, antimatiere) 
							values ('', $idInsert, $typeRess, $met, $cri, $deut, $antimat)";
						$db->sql_query($query);
					}
					else
					{
						echo('<big><big>> Rapport ressource du '.$dateTmp.' deja ajoute ! </big></big> <br />');
					}
			
				}

			}
			if ($nbRapportVaiss) 
			{
				for($i = 0 ; $i < $nbRapportVaiss ; $i++)
				{
					 $pt = 0;
					 $gt = 0;
					 $cle = 0;
					 $clo = 0;
					 $cr = 0;
					 $vb = 0;
					 $vc = 0;
					 $rec = 0;
					 $se = 0;
					 $bmb = 0;
					 $dst = 0;
					 $tra = 0;

					//recherche de l'année :
					if( $expsVaiss[1][$i] > date('m'))
					{
						//on a changé d'année entre temps
						$year = date('Y') - 1;
					}
					else
					{
						//sinon c'est l'année courante
						$year = date('Y');			
					}
					$timestmp = mktime($expsVaiss[3][$i], $expsVaiss[4][$i] , $expsVaiss[5][$i], $expsVaiss[1][$i], $expsVaiss[2][$i], $year);
					$galaxy = $expsVaiss[6][$i];
					$systeme = $expsVaiss[7][$i];
					$dateTmp = date('d-m-Y H:i:s', $timestmp);
					if($eXpDebug)
					{
						echo("-Rapport vaisseau <br />-");
						echo("Date : $timestmp ou encore : $dateTmp  ! <br />");
						echo("Coordonnees : [$galaxy:$systeme:16]  <br />");
						echo("Rapport 1 : ".$expsVaiss[8][$i]." <br /> <br />"); //blabla1
						echo("Rapport 2 : ".$expsVaiss[9][$i]." <br /> <br />"); //rien
						echo("Rapport 3 : ".$expsVaiss[10][$i]." <br /> <br />"); //liste vaisseaux
						echo("Rapport 4 : ".$expsVaiss[11][$i]." <br /> <br />"); //fantome
						echo("Rapport 5 : ".$expsVaiss[12][$i]." <br /> <br />"); //blabla2
					}
					$units = 0;
					//recherche des vaisseaux
					if(preg_match("#Petit\stransporteur\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$pt = $reg[1]; 
						$units += ( 2  + 2  + 0  ) * $pt;
					}
					if(preg_match("#Grand\stransporteur\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$gt = $reg[1]; 
						$units += ( 6  + 6  + 0  ) * $gt;
					}
					if(preg_match("#Chasseur\sléger\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$cle = $reg[1]; 
						$units += ( 3  + 1  + 0  ) * $cle;
					}
					if(preg_match("#Chasseur\slourd\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$clo = $reg[1]; 
						$units += ( 6  + 4  + 0  ) * $clo;
					}
					if(preg_match("#Croiseur\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$cr = $reg[1]; 
						$units += ( 20 + 7  + 2  ) * $cr;
					}
					if(preg_match("#Vaisseau\sde\sbataille\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$vb = $reg[1]; 
						$units += ( 45 + 15 + 0  ) * $vb;
					}
					if(preg_match("#Vaisseau\sde\scolonisation\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$vc = $reg[1]; 
						$units += ( 10 + 20 + 10 ) * $vc;
					}
					if(preg_match("#Recycleur\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$rec = $reg[1]; 
						$units += ( 10 + 6  + 2  ) * $rec;
					}
					if(preg_match("#Sonde\sespionnage\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$se = $reg[1]; 
						$units += ( 0  + 1  + 0  ) * $se;
					}
					if(preg_match("#Bombardier\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$bmb = $reg[1]; 
						$units += ( 50 + 25 + 15 ) * $bmb;
					}
					if(preg_match("#Destructeur\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$dst = $reg[1]; 
						$units += ( 60 + 50 + 15 ) * $dst;
					}
					if(preg_match("#Traqueur\s(\d+)#", $expsVaiss[10][$i], $reg))
					{
						$tra = $reg[1]; 
						$units += ( 30 + 40 + 15 ) * $tra;
					}
					$query = 
						"Select * 
						From ".TABLE_EXPEDITION." 
						Where user_id = $uid 
						and date = $timestmp 
						and pos_galaxie = $galaxy 
						and pos_sys = $systeme 
						and type = 2";
					if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
					
					if($db->sql_numrows($result) == 0)
					{
						$query = 
							"Insert into ".TABLE_EXPEDITION." 
							(id, user_id, date, pos_galaxie, pos_sys, type) 
							values ('', $uid, $timestmp, $galaxy, $systeme, 2)";
						$db->sql_query($query);
						$idInsert = $db->sql_insertid();
						$query = 
							"Insert into ".TABLE_EXPEDITION_TYPE_2." 
							(id, id_eXpedition, pt, gt, cle, clo, cr, vb, vc, rec, se, bmb, dst, tra, units)
							values ('', $idInsert, $pt, $gt, $cle, $clo, $cr, $vb, $vc, $rec, $se, $bmb, $dst, $tra, $units)";
						$db->sql_query($query);
					}
					else
					{
						echo('<big><big>> Rapport vaisseau du '.$dateTmp.' deja ajoute ! </big></big> <br />');
					}
				}
			}
		}
	}
}

// lecture des infos de la base 
function readDBuserDet($uid = 0, $datedeb = 0, $datefin = 0)
{
	global $db, $eXpDebug;
	$TR0 = '';
	$TR1 = '';
	$TR2 = '';
	$TR3 = '';
	// On recupere le tableau des expeditions ratées :
	$query = 
				"SELECT date, pos_galaxie, pos_sys, user_id, e.id
		 		FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_0." AS t0
				WHERE e.id = t0.id_eXpedition ";
if($uid != 0) $query .= 	"and user_id =$uid ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";
	 $query .=		"order by user_id ASC,date DESC";
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	while ($row = $db->sql_fetch_row($result)) 
	{
   		$TR0[] = $row;
	}



	// On recupere le tableau des expeditions ressources :

	$query = 
				"SELECT date, pos_galaxie, pos_sys, metal, cristal, deuterium, antimatiere, user_id, e.id
		 		FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
				WHERE e.id = t1.id_eXpedition ";
if($uid != 0) $query .= 	"and user_id =$uid ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";
	 $query .=		"order by user_id ASC,date DESC";

	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	while ($row = $db->sql_fetch_row($result)) 
	{
   		$TR1[] = $row;
	}



	// On recupere le tableau des expeditions vaisseau :

	$query = 
				"SELECT date, pos_galaxie, pos_sys, pt, gt, cle, clo, cr, vb, vc, rec, se, bmb, dst, tra, units, user_id, e.id
		 		FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_2." AS t2
				WHERE e.id = t2.id_eXpedition ";
if($uid != 0) $query .= 	"and user_id =$uid ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";
	 $query .=		"order by user_id ASC,date DESC";

	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	while ($row = $db->sql_fetch_row($result)) 
	{
   		$TR2[] = $row;
	}


	// On recupere le tableau des expeditions marchand :


	$query = 
				"SELECT date, pos_galaxie, pos_sys, user_id, e.id
		 		FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_3." AS t3
				WHERE e.id = t3.id_eXpedition ";
if($uid != 0) $query .= 	"and user_id =$uid ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";
	 $query .=		"order by user_id ASC, date DESC";

	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	while ($row = $db->sql_fetch_row($result)) 
	{
   		$TR3[] = $row;
	}


	// et on renvoie le tout dans un super tableau qui est un tableau de tableau de tableau de ....

	$superTableau['Rate']  = $TR0;
	$superTableau['Ress']  = $TR1;
	$superTableau['Vaiss'] = $TR2;
	$superTableau['March'] = $TR3;

	return $superTableau;
}


// etablir le classement
function readDBuserHOF($datedeb = 0, $datefin = 0)
{
	global $db, $eXpDebug;
	
//on récupère le premier classement :

	$query = 		"Select (ress.totres + unit.totunits) as total, u.user_id
				From ".TABLE_EXPEDITION." AS u,
				(SELECT sum( (metal + cristal + deuterium) / 1000 + antimatiere) as totres, user_id FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
				WHERE e.id = t1.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";
	$query .= 		"GROUP BY user_id) as ress,
				(SELECT sum(units) as totunits, user_id FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_2." AS t2 
				WHERE e.id = t2.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";
	$query .= 		"GROUP BY user_id) as unit

				WHERE  u.user_id = ress.user_id and u.user_id = unit.user_id
				GROUP BY u.user_id
				ORDER BY total DESC "; 
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{	
   			$TT1['quantite'] = format($row[0]);
   			$TT1['pseudo'] = getuserNameById($row[1]);
   			$T1[] = $TT1;
		}
		else
		{
		   	$TT1['quantite'] = "/";
   			$TT1['pseudo']   = "/";
   			$T1[] = $TT1;
		}
	}
		
//on récupère le classement des meilleurs rapporteurs de métal:

	$query = 	"SELECT sum(metal) as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";		 
	$query .= 	"GROUP BY user_id
			 ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{
   			$T2[$i]['M']['quantite'] = format($row[0]);
   			$T2[$i]['M']['pseudo'] = getuserNameById($row[1]);
		}
		else
		{
		   	$T2[$i]['M']['quantite'] = "/";
   			$T2[$i]['M']['pseudo']   = "/";
		}
	}
			
//on récupère le classement des meilleurs rapporteurs de cristal:

	$query = 	"SELECT sum(cristal) as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";	
		$query .= 	"GROUP BY user_id
			 ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{
   			$T2[$i]['C']['quantite'] = format($row[0]);
   			$T2[$i]['C']['pseudo'] = getuserNameById($row[1]);
		}
		else
		{
		   	$T2[$i]['C']['quantite'] = "/";
   			$T2[$i]['C']['pseudo']   = "/";
		}
	}		
			
	
//on récupère le classement des meilleurs rapporteurs de deutérium:

	$query = 	"SELECT sum(deuterium) as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";				 
			 	$query .= 	"GROUP BY user_id
			 ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{
   			$T2[$i]['D']['quantite'] = format($row[0]);
   			$T2[$i]['D']['pseudo'] = getuserNameById($row[1]);
		}
		else
		{
		   	$T2[$i]['D']['quantite'] = "/";
   			$T2[$i]['D']['pseudo']   = "/";
		}
	}		
			
	
//on récupère le classement des meilleurs rapporteurs de antimatiere:

	$query = 	"SELECT sum(antimatiere) as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";	
				$query .= 	" GROUP BY user_id
			 ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result) )
		{
   			$T2[$i]['A']['quantite'] = format($row[0]);
   			$T2[$i]['A']['pseudo'] = getuserNameById($row[1]);
		}
		else
		{
		   	$T2[$i]['A']['quantite'] = "/";
   			$T2[$i]['A']['pseudo']   = "/";
		}
	}	
	
	
	
	//on récupère le classement des meilleurs eXpedition de métal:

	$query = 	"SELECT metal as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";	
			 	$query .= 	"ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{
   			$T3[$i]['M']['quantite'] = format($row[0]);
   			$T3[$i]['M']['pseudo'] = getuserNameById($row[1]);
		}
		else
		{
		   	$T3[$i]['M']['quantite'] = "/";
   			$T3[$i]['M']['pseudo']   = "/";
		}
	}
			
//on récupère le classement des meilleurs eXpedition de cristal:

	$query = 	"SELECT cristal as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";	
		$query .= 	" ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{
   			$T3[$i]['C']['quantite'] = format($row[0]);
   			$T3[$i]['C']['pseudo'] = getuserNameById($row[1]);
		}
		else
		{
		   	$T3[$i]['C']['quantite'] = "/";
   			$T3[$i]['C']['pseudo']   = "/";
		}
	}		
			
	
//on récupère le classement des meilleurs eXpedition de deutérium:

	$query = 	"SELECT deuterium as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";	
		$query .= 	" ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{
   			$T3[$i]['D']['quantite'] = format($row[0]);
   			$T3[$i]['D']['pseudo'] = getuserNameById($row[1]);
		}
		else
		{
		   	$T3[$i]['D']['quantite'] = "/";
   			$T3[$i]['D']['pseudo']   = "/";
		}
	}		
			
	
//on récupère le classement des meilleurs eXpedition de antimatiere:

	$query = 	"SELECT antimatiere as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";	
		$query .= 	" ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{
   			$T3[$i]['A']['quantite'] = format($row[0]);
   			$T3[$i]['A']['pseudo'] = getuserNameById($row[1]);
		}
		else
		{
		   	$T3[$i]['A']['quantite'] = "/";
   			$T3[$i]['A']['pseudo']   = "/";
		}
	}	
	
	
	
	//on récupère le classement des meilleurs rapporteurs de vaisseau:

	$query = 	"SELECT sum(units) as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_2." AS t2
			 WHERE e.id = t2.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";	
	$query .= 	"  GROUP BY user_id
			ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{
   			$T4[$i]['quantite'] = format($row[0]);
   			$T4[$i]['pseudo'] = getuserNameById($row[1]);
		}
		else
		{
		   	$T4[$i]['quantite'] = "/";
   			$T4[$i]['pseudo']   = "/";
		}
	}	
	
	
	
	//on récupère le classement des meilleurs eXpedition de vaisseau:

	$query = 	"SELECT units as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_2." AS t2
			 WHERE e.id = t2.id_eXpedition ";
if($datefin != 0) $query .= 	"and date between $datedeb and $datefin ";	
		$query .= 	" ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
					$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{
   			$T5[$i]['quantite'] = format($row[0]);
   			$T5[$i]['pseudo'] = getuserNameById($row[1]);
		}
		else
		{
		   	$T5[$i]['quantite'] = "/";
   			$T5[$i]['pseudo']   = "/";
		}
	}

	$T['tout'] = $T1;
	$T['ress'] = $T2;
	$T['ressM'] = $T3;
	$T['vaiss'] = $T4;
	$T['vaissM'] = $T5;
	
	return $T;	
	
}
	

// récupérer le type d'une eXpedition et son contenu à partir de l'id
function geteXpById($idexp)
{
	global $db, $eXpDebug;
		$query = 
			"SELECT type, user_id, date, pos_galaxie,	pos_sys
			FROM ".TABLE_EXPEDITION." 
			WHERE id = $idexp ";

	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	$returnTab = $db->sql_fetch_assoc($result);
	
	switch($returnTab['type'])
	{
		
		case 0:
		case 3:
			$returnTab['type'] = "Rien";	
		break;
		case 1:
			$returnTab['type'] = "Ressources";
			$query = 
				"SELECT typeRessource, metal, cristal, deuterium, antimatiere
				FROM ".TABLE_EXPEDITION_TYPE_1."
				WHERE id_eXpedition = $idexp";
			if($eXpDebug) echo("<br /> Db : $query <br />");
			$result = $db->sql_query($query);
			$sqlret = $db->sql_fetch_assoc($result);
			switch($sqlret['typeRessource'])
			{
				case 0:
					$returnTab['typeRessource'] = "Métal";	
				break;
				case 1:
					$returnTab['typeRessource'] = "Cristal";	
				break;
				case 2:
					$returnTab['typeRessource'] = "Deutérium";	
				break;
				case 3:
					$returnTab['typeRessource'] = "Antimatière";	
				break;
				default:
					$returnTab['typeRessource'] = "Croquettes";
			}
				
			$returnTab['quantite'] =   $sqlret['metal'] + $sqlret['cristal'] + $sqlret['deuterium'] + $sqlret['antimatiere']; 
		break;
		
		case 2:
			$returnTab['type'] = "Vaisseaux";	
			
			$query = 
				"SELECT units, pt, gt, cle, clo, cr, vb, vc, rec, se, bmb, dst, tra
				FROM ".TABLE_EXPEDITION_TYPE_2."
				WHERE id_eXpedition  = $idexp";
			if($eXpDebug) echo("<br /> Db : $query <br />");
			$result = $db->sql_query($query);
			
			$sqlret = $db->sql_fetch_assoc($result);
			
			$returnTab['units'] = $sqlret['units'];	
			
			$returnTab['pt']  = $sqlret['pt'];
			$returnTab['gt']  = $sqlret['gt'];
			$returnTab['cle'] = $sqlret['cle'];
			$returnTab['clo'] = $sqlret['clo'];
			$returnTab['cr']  = $sqlret['cr'];
			$returnTab['vb']  = $sqlret['vb'];
			$returnTab['vc']  = $sqlret['vc'];
			$returnTab['rec'] = $sqlret['rec'];
			$returnTab['se']  = $sqlret['se'];
			$returnTab['bmb'] = $sqlret['bmb'];
			$returnTab['dst'] = $sqlret['dst'];
			$returnTab['tra'] = $sqlret['tra'];
			
		break;			
		
		default:
			$returnTab['type'] = "Erreur : type exp inconnu : ".$typexp;	
	}
	return $returnTab;
}

?>
