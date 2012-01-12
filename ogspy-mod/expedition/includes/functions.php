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
	$query = "SELECT user_name FROM ".TABLE_USER." WHERE user_id = $uid ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	list($nom) = $db->sql_fetch_row($result);
	return $nom;
}

// recupérer les options de quelqu'un
function getOpts($uid, $opt)
{
	global $db, $eXpDebug;
	$query = "SELECT val FROM ".TABLE_EXPEDITION_OPTS."
			 WHERE user_id = $uid and opts = $opt";
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
	$query = "SELECT count(*), type FROM ".TABLE_EXPEDITION." WHERE type = 0 ";
	if($uid != 0) $query .= "and user_id = $uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin  ";
	$query .= "group by type";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	list($res['nombreExpRate']) = $db->sql_fetch_row($result);
	// Si y'en a pas on met 0
	if($res['nombreExpRate'] == ''){$res['nombreExpRate'] = 0;}

	// Expedition ratée
	$query = "SELECT count(*) FROM ".TABLE_EXPEDITION." WHERE (type = 4 or type = 5) ";
	if($uid != 0) $query .= "and user_id = $uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin  ";
	$query .= "group by type";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	list($res['nombreExpCombat']) = $db->sql_fetch_row($result);
	if($res['nombreExpCombat'] == ''){$res['nombreExpCombat'] = 0;} // Si y'en a pas on met 0

	$query = "SELECT sum(perte) FROM ".TABLE_EXPEDITION." WHERE (type = 4 or type = 5) ";
	if($uid != 0) $query .= "and user_id =$uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";
		$result = $db->sql_query($query);
	list($res['sumPerte']) = $db->sql_fetch_row($result);
	if($res['sumPerte'] == ''){$res['sumPerte'] = 0;} 	// Si y'en a pas on met 0
	
	// Expedition ressource
	$query = "SELECT count(*), type FROM ".TABLE_EXPEDITION." WHERE type = 1 ";
	if($uid != 0) $query .= "and user_id = $uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin  ";
	$query .=	"group by type ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	list($res['nombreExpRess']) = $db->sql_fetch_row($result);
	// Si y'en a pas on met 0
	if($res['nombreExpRess'] == ''){$res['nombreExpRess'] = 0;}

	// Expedition vaisseau
	$query = "SELECT count(*), type FROM ".TABLE_EXPEDITION." WHERE type = 2 ";
	if($uid != 0) $query .= "and user_id = $uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin  ";
	$query .=	"group by type ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	list($res['nombreExpVaiss']) = $db->sql_fetch_row($result);
	// Si y'en a pas on met 0
	if($res['nombreExpVaiss'] == ''){$res['nombreExpVaiss'] = 0;}

	//Expedition marchand
	$query = "SELECT count(*), type FROM ".TABLE_EXPEDITION." WHERE type = 3 ";
	if($uid != 0) $query .= "and user_id = $uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin  ";
	$query .=	"group by type ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	list($res['nombreExpMarch']) = $db->sql_fetch_row($result);
	// Si y'en a pas on met 0
	if($res['nombreExpMarch'] == ''){$res['nombreExpMarch'] = 0;}

	// Nombre d'expédition total
	$res['nombreExpTot'] = $res['nombreExpRate'] + $res['nombreExpCombat'] + $res['nombreExpRess'] + $res['nombreExpVaiss'] + $res['nombreExpMarch'];
	// Calcul des pourcentages
	if($res['nombreExpTot'] == 0)
	{
		$res['pourcentExpRate'] = 0;
		$res['pourcentExpCombat'] = 0;
		$res['pourcentExpRess'] = 0;
		$res['pourcentExpVaiss'] = 0;
		$res['pourcentExpMarch'] = 0;
	}
	else
	{
		$res['pourcentExpRate'] = round(($res['nombreExpRate'] * 100) / $res['nombreExpTot']);
		$res['pourcentExpCombat'] = round(($res['nombreExpCombat'] * 100) / $res['nombreExpTot']);
		$res['pourcentExpRess'] = round(($res['nombreExpRess'] * 100) / $res['nombreExpTot']);
		$res['pourcentExpVaiss'] = round(($res['nombreExpVaiss'] * 100) / $res['nombreExpTot']);
		$res['pourcentExpMarch'] = round(($res['nombreExpMarch'] * 100) / $res['nombreExpTot']);
	}

	// Ensuite on cherche les ressources qu'il a gagné en tout :
	$query = "SELECT sum(metal), sum(cristal), sum(deuterium), sum(antimatiere)
			FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1 WHERE e.id = t1.id_eXpedition ";
			if($uid != 0) $query .= "and user_id =$uid ";
			if($datefin != 0) $query .= "and date between $datedeb and $datefin ";
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
		FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_2." AS t2 WHERE e.id = t2.id_eXpedition ";
	if($uid != 0) $query .= "and user_id =$uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin  ";
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
	$query = "SELECT count(*), type FROM ".TABLE_EXPEDITION." WHERE type = 3 ";
	if($uid != 0) $query .= "and user_id =$uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin";
	if($eXpDebug) echo("<br /> Db : $query <br />");
		$result = $db->sql_query($query);
	list($res['sumM']) = $db->sql_fetch_row($result);
	if($res['sumM']== ''){$res['sumM'] = 0;} // Si y'en a pas on met 0

	// on veux enfin recuperer la date d'origine des rapport en tout
	$query = "SELECT min(date) FROM ".TABLE_EXPEDITION;
	if($uid != 0) $query .= " WHERE user_id = $uid ";
	if($eXpDebug) echo("<br /> Db : $query <br />");
		$result = $db->sql_query($query);
	list($res['dateOrigine']) = $db->sql_fetch_row($result);

	// et si on calculait la moyenne et le total... !
	$res['totRess'] = $res['sumMetal'] + $res['sumCristal'] + $res['sumDeuterium'] - $res['sumPerte'];
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
	if (preg_match("#(\d{2}).(\d{2}).(\d{4}) (\d{2}):(\d{2}):(\d{2})#", $_POST['datas'], $timestmp))
		{
			$timestmp = str_replace('.', ':', $timestmp[0]);
			$content = str_replace(' ', ':', $timestmp);
			preg_match_all("#\d{4}|\d{2}#", $content, $timestmp, PREG_PATTERN_ORDER);
			$timestmp = mktime($timestmp[0][3], $timestmp[0][4] , $timestmp[0][5] , $timestmp[0][1], $timestmp[0][0],$timestmp[0][2]);
			$dateTmp = date('d-m-Y H:i:s', $timestmp);
			//echo("<br />".$timestmp."<br />");
			preg_match("#\[(\d+):(\d+):16]#", $_POST['datas'], $content);
			if (!$content)
				{
					echo('<big><big><big> Aucun Rapport Valide Trouve ! </big></big></big> <br />');
					return;
				}
			$galaxy= $content[1];
			$systeme = $content[2];
		}
	else
		{
			echo('<big><big><big> Aucun Rapport Valide Trouve ! </big></big></big> <br />');
			return;
		}
		
	$content = str_replace('.', '', $_POST['datas']); // on enleve les séparateurs
	$content = str_replace("\r\n","\n", $content); //Compatibilité UNIX/Windows
	$content = str_replace("\t",' ', $content); //Compatibilité IE/Firefox
	$content = stripslashes($content); //pour l'apostrophe !
//    echo("<br />".$content."<br />");

	$regExRien =  "#Résultat de l`expédition#";
	$regExCombat =  "#Rapport de combat#";
	$regExVaiss = "#Grand transporteur|Petit transporteur|Chasseur léger|Chasseur lourd|Sonde espionnage|Croiseur|Vaisseau de bataille|Traqueur|Destructeur#";
	$regExRess = "#Métal|Cristal|Deutérium|Antimatière#";
	$regExMarchand = "#liste\sde\sclients\sprivilégiés|dans\svotre\sempire\sun\sreprésentant\schargé\sde\sressources\sà\séchanger#";
	
	//et on extrait les entetes pour trouver le type de rapport
	$nbRapportVaiss = preg_match($regExVaiss, $content, $reg);
	$nbRapportRess = preg_match($regExRess, $content, $reg);
	$nbRapportMarchand = preg_match($regExMarchand, $content, $reg);
	$nbRapportRien = preg_match($regExRien, $content, $reg);
	
	if ($eXpDebug && !preg_match("#^\s*00-00\s*#", $_POST['datas']))
		{
			echo("<br /> Texte non traite : ".$_POST['datas']." <br />");
		}
		
	$nbRapport = $nbRapportRess + $nbRapportVaiss + $nbRapportMarchand;
		
	if ($nbRapport + $nbRapportRien == 0 )
	{	
		$nbRapportRien = preg_match($regExCombat, $content, $expsRien);
		if ($nbRapportRien > 0)
		{
			if(preg_match("#Pirates#", $content, $reg))
				{$nbRapport = 1; $type = 4;}
			elseif(preg_match("#Aliens#", $content, $reg))
				{$nbRapport = 1; $type = 5;}
		}
		else
		{	
			echo('<big><big><big>Aucun Rapport Valide Trouvé !</big></big></big><br />');
			return;
		}
	}
		elseif ($nbRapport == 0 && $nbRapportRien > 0)
			{
				if (preg_match("#Pirates|Aliens|pirates|aliens|espèce inconnue#", $content, $reg))
					{
						echo("<br /><big><big>Copier le RC de l'éxpédition</big></big><br />"); return;
					}
				else
					{
						$nbRapport = 1; $type = 0;
					}
			}

		if ($nbRapport == 0) 
			{
				echo('<big><big><big>Aucun Rapport Valide Trouvé !</big></big></big><br />'); return;
			}
		elseif	($nbRapportVaiss > 0) 
			{
				$type = 2; echo("<br /><big><big> 1 rapport de vaisseaux détécté !</big></big><br />");
			}
		elseif	($nbRapportRess > 0) 
			{
				$type = 1; echo("<br /><big><big> 1 rapport de ressources détécté !</big></big><br />");
			}
		elseif	($nbRapportMarchand > 0) 
			{
				$type = 3; echo("<br /><big><big> 1 rapport de ressources détécté !</big></big><br />");
			}
		elseif 	($type == 0)
			{
				echo("<br /><big><big> 1 rapport d'echec détécté !</big></big><br />");
			}
		elseif	($type == 4)	
			{
				echo("<br /><big><big> 1 rapport d'echec avec combat pirates détécté !</big></big><br />");
			}
		elseif	($type == 5)	
			{
				echo("<br /><big><big> 1 rapport d'echec avec combat aliens détécté !</big></big><br />");
			}
		else	
			{
				echo('<big><big><big>Aucun Rapport Valide Trouvé !</big></big></big><br />'); return;
			}

		$query = "Select * From ".TABLE_EXPEDITION." Where user_id = $uid and date = $timestmp and pos_galaxie = $galaxy and pos_sys = $systeme and type = $type";
		if($eXpDebug) echo("<br /> Db : $query <br />");
		$result = $db->sql_query($query);
		if($db->sql_numrows($result) == 0)
			{
				if ($type == 3 || $type == 0) // Marchand ou rien
					{
						$query = "Insert into ".TABLE_EXPEDITION." (id, user_id, date, pos_galaxie, pos_sys, type, perte) values ('', $uid, $timestmp, $galaxy, $systeme, $type, 0)";
						$db->sql_query($query);
					}
				elseif ($type >= 4) // attaque alien/pirates
					{
						preg_match_all("#unités perdues: .*#", $content, $tmp);
					//	$motif='`(\d+)+`'; 
						preg_match_all("(\d+)", $tmp[0][0], $reg);
						$pertes=$reg[0][1];
					//	echo("<br />".$pertes."<br />");
						$query = "Insert into ".TABLE_EXPEDITION." (id, user_id, date, pos_galaxie, pos_sys, type, perte) values ('', $uid, $timestmp, $galaxy, $systeme, $type, $pertes)";
						$db->sql_query($query);
					}
				elseif ($type == 1) // Ressources
					{
						$query = "Insert into ".TABLE_EXPEDITION." (id, user_id, date, pos_galaxie, pos_sys, type, perte) values ('', $uid, $timestmp, $galaxy, $systeme, $type, 0)";
						$db->sql_query($query);
						$idInsert = $db->sql_insertid();
						if(preg_match("#Métal\s(\d+)#", $content, $reg))
							{
								$query2 = "Insert into ".TABLE_EXPEDITION_TYPE_1." (id, id_eXpedition, typeRessource, metal, cristal, deuterium, antimatiere) 
								values ('', $idInsert, 0, $reg[1], 0, 0, 0)";
							}
						elseif(preg_match("#Cristal\s(\d+)#", $content, $reg))
							{
								$query2 = "Insert into ".TABLE_EXPEDITION_TYPE_1." (id, id_eXpedition, typeRessource, metal, cristal, deuterium, antimatiere) 
								values ('', $idInsert, 0, 0, $reg[1], 0, 0)";
							}
						elseif(preg_match("#Deutérium\s(\d+)#", $content, $reg))
							{
								$query2 = "Insert into ".TABLE_EXPEDITION_TYPE_1." (id, id_eXpedition, typeRessource, metal, cristal, deuterium, antimatiere) 
								values ('', $idInsert, 0, 0, 0, $reg[1], 0)";
							}
						elseif(preg_match("#Antimatière\s(\d+)#", $content, $reg))
							{
								$query2 = "Insert into ".TABLE_EXPEDITION_TYPE_1." (id, id_eXpedition, typeRessource, metal, cristal, deuterium, antimatiere) 
								values ('', $idInsert, 0, 0, 0, 0, $reg[1])";
								$db->sql_query($query2);
							}
					}
				elseif ($type == 2) // Flottes
					{
						$query = "Insert into ".TABLE_EXPEDITION." (id, user_id, date, pos_galaxie, pos_sys, type, perte) values ('', $uid, $timestmp, $galaxy, $systeme, $type, 0)";
						$pt = 0; $gt = 0; $cle = 0;	$clo = 0; $cr = 0; $vb = 0; $vc = 0; $rec = 0; $se = 0; $bmb = 0; $dst = 0; $tra = 0; $units = 0;
						//recherche des vaisseaux
						if(preg_match("#Petit\stransporteur\s(\d+)#", $content, $reg))
							{
								$pt = $reg[1]; $units += ( 2  + 2  + 0  ) * $pt;
							}
						if(preg_match("#Grand\stransporteur\s(\d+)#", $content, $reg))
							{
								$gt = $reg[1]; $units += ( 6  + 6  + 0  ) * $gt;
							}
						if(preg_match("#Chasseur\sléger\s(\d+)#", $content, $reg))
							{
								$cle = $reg[1]; $units += ( 3  + 1  + 0  ) * $cle;
							}
						if(preg_match("#Chasseur\slourd\s(\d+)#", $content, $reg))
							{
								$clo = $reg[1]; $units += ( 6  + 4  + 0  ) * $clo;
							}
						if(preg_match("#Croiseur\s(\d+)#", $content, $reg))
							{
								$cr = $reg[1]; $units += ( 20 + 7  + 2  ) * $cr;
							}
						if(preg_match("#Vaisseau\sde\sbataille\s(\d+)#", $content, $reg))
							{
								$vb = $reg[1]; $units += ( 45 + 15 + 0  ) * $vb;
							}
						if(preg_match("#Vaisseau\sde\scolonisation\s(\d+)#", $content, $reg))
							{
								$vc = $reg[1]; $units += ( 10 + 20 + 10 ) * $vc;
							}
						if(preg_match("#Recycleur\s(\d+)#", $content, $reg))
							{
								$rec = $reg[1]; $units += ( 10 + 6  + 2  ) * $rec;
							}
						if(preg_match("#espionnage\s(\d+)#", $content, $reg))
							{
								$se = $reg[1]; $units += ( 0  + 1  + 0  ) * $se;
							}
						if(preg_match("#Bombardier\s(\d+)#", $content, $reg))
							{
								$bmb = $reg[1]; $units += ( 50 + 25 + 15 ) * $bmb;
							}
						if(preg_match("#Destructeur\s(\d+)#", $content, $reg))
							{
								$dst = $reg[1]; $units += ( 60 + 50 + 15 ) * $dst;
							}
						if(preg_match("#Traqueur\s(\d+)#", $content, $reg))
							{
								$tra = $reg[1]; $units += ( 30 + 40 + 15 ) * $tra;
							}

					$db->sql_query($query);
					$idInsert = $db->sql_insertid();
					$query2 = "Insert into ".TABLE_EXPEDITION_TYPE_2." (id, id_eXpedition, pt, gt, cle, clo, cr, vb, vc, rec, se, bmb, dst, tra, units)
					values ('', $idInsert, $pt, $gt, $cle, $clo, $cr, $vb, $vc, $rec, $se, $bmb, $dst, $tra, $units)";
					$db->sql_query($query2);
					echo("<br /> Db : $query <br />");
					echo("Db : $query2");
			}
		}
	else
		{
			echo('<big><big>Rapport du '.$dateTmp.' deja ajoute !</big></big> <br />'); return;
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
	$TR4 = '';
	// On recupere le tableau des expeditions ratées :
	$query = "SELECT date, pos_galaxie, pos_sys, user_id, type, perte FROM ".TABLE_EXPEDITION." WHERE type = 0 or type = 4 or type = 5 ";
	if($uid != 0) $query .= "and user_id =$uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";
	$query .= "order by user_id ASC,date DESC";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	while ($row = $db->sql_fetch_row($result)) 
	{$TR0[] = $row;}

	// On recupere le tableau des expeditions ressources :
	$query = "SELECT date, pos_galaxie, pos_sys, metal, cristal, deuterium, antimatiere, user_id, e.id
		 	FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			WHERE e.id = t1.id_eXpedition ";
	if($uid != 0) $query .= "and user_id =$uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";
	 $query .=	"order by user_id ASC,date DESC";

	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	while ($row = $db->sql_fetch_row($result)) 
	{	
		$TR1[] = $row;
	}

	// On recupere le tableau des expeditions vaisseau :
	$query = "SELECT date, pos_galaxie, pos_sys, pt, gt, cle, clo, cr, vb, vc, rec, se, bmb, dst, tra, units, user_id, e.id
		 	FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_2." AS t2
			WHERE e.id = t2.id_eXpedition ";
	if($uid != 0) $query .= "and user_id =$uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";
	$query .= "order by user_id ASC, date DESC";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	while ($row = $db->sql_fetch_row($result)) 
	{	
		$TR2[] = $row;
	}

	// On recupere le tableau des expeditions marchand :
	$query = "SELECT date, pos_galaxie, pos_sys, user_id, type FROM ".TABLE_EXPEDITION." WHERE type = 3 ";
	if($uid != 0) $query .= "and user_id =$uid ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";
	$query .= "order by user_id ASC, date DESC";

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
	$query = "Select (ress.totres + unit.totunits) as total, u.user_id
			From ".TABLE_EXPEDITION." AS u,
			(SELECT sum( (metal + cristal + deuterium) / 1000 + antimatiere) as totres, user_id FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			WHERE e.id = t1.id_eXpedition ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";
	$query .= "GROUP BY user_id) as ress,
				(SELECT sum(units) as totunits, user_id FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_2." AS t2 
				WHERE e.id = t2.id_eXpedition ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";
	$query .= "GROUP BY user_id) as unit
			WHERE  u.user_id = ress.user_id and u.user_id = unit.user_id GROUP BY u.user_id ORDER BY total DESC "; 
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
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";		 
	$query .= "GROUP BY user_id ORDER BY total DESC";
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
	$query = "SELECT sum(cristal) as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";	
	$query .= "GROUP BY user_id ORDER BY total DESC";	 
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
	$query = "SELECT sum(deuterium) as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";				 
	$query .= 	"GROUP BY user_id ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{	$T2[$i]['D']['quantite'] = format($row[0]);
   			$T2[$i]['D']['pseudo'] = getuserNameById($row[1]);}
		else
		{	$T2[$i]['D']['quantite'] = "/";
   			$T2[$i]['D']['pseudo']   = "/";}
	}
	
//on récupère le classement des meilleurs rapporteurs de antimatiere:
	$query = "SELECT sum(antimatiere) as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";	
	$query .= 	" GROUP BY user_id ORDER BY total DESC";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result) )
		{	$T2[$i]['A']['quantite'] = format($row[0]);
   			$T2[$i]['A']['pseudo'] = getuserNameById($row[1]);}
		else
		{	$T2[$i]['A']['quantite'] = "/";
   			$T2[$i]['A']['pseudo']   = "/";}
	}
	
	//on récupère le classement des meilleurs eXpedition de métal:
	$query = "SELECT metal as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";	
	$query .= "ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{	$T3[$i]['M']['quantite'] = format($row[0]);
   			$T3[$i]['M']['pseudo'] = getuserNameById($row[1]);}
		else
		{	$T3[$i]['M']['quantite'] = "/";
   			$T3[$i]['M']['pseudo']   = "/";}
	}
	
//on récupère le classement des meilleurs eXpedition de cristal:
	$query = "SELECT cristal as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";	
	$query .= " ORDER BY total DESC";
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{	$T3[$i]['C']['quantite'] = format($row[0]);
   			$T3[$i]['C']['pseudo'] = getuserNameById($row[1]);}
		else
		{	$T3[$i]['C']['quantite'] = "/";
   			$T3[$i]['C']['pseudo']   = "/";}
	}
	
//on récupère le classement des meilleurs eXpedition de deutérium:
	$query = "SELECT deuterium as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";	
	$query .= " ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{	$T3[$i]['D']['quantite'] = format($row[0]);
   			$T3[$i]['D']['pseudo'] = getuserNameById($row[1]);}
		else
		{	$T3[$i]['D']['quantite'] = "/";
   			$T3[$i]['D']['pseudo']   = "/";}
	}
	
//on récupère le classement des meilleurs eXpedition de antimatiere:
	$query = "SELECT antimatiere as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_1." AS t1
			 WHERE e.id = t1.id_eXpedition ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";	
	$query .= " ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{	$T3[$i]['A']['quantite'] = format($row[0]);
   			$T3[$i]['A']['pseudo'] = getuserNameById($row[1]);}
		else
		{	$T3[$i]['A']['quantite'] = "/";
   			$T3[$i]['A']['pseudo']   = "/";}
	}
	
//on récupère le classement des meilleurs rapporteurs de vaisseau:
	$query = "SELECT sum(units) as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_2." AS t2
			 WHERE e.id = t2.id_eXpedition ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";	
	$query .= "  GROUP BY user_id ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{	$T4[$i]['quantite'] = format($row[0]);
   			$T4[$i]['pseudo'] = getuserNameById($row[1]);}
		else
		{	$T4[$i]['quantite'] = "/";
   			$T4[$i]['pseudo']   = "/";}
	}
	
//on récupère le classement des meilleurs eXpedition de vaisseau:
	$query = "SELECT units as total, user_id
			 FROM ".TABLE_EXPEDITION." AS e, ".TABLE_EXPEDITION_TYPE_2." AS t2
			 WHERE e.id = t2.id_eXpedition ";
	if($datefin != 0) $query .= "and date between $datedeb and $datefin ";	
	$query .= " ORDER BY total DESC";	 
	if($eXpDebug) echo("<br /> Db : $query <br />");
	$result = $db->sql_query($query);
	for($i = 0 ; $i < 10 ; $i ++)
	{
		if($row = $db->sql_fetch_row($result))
		{	$T5[$i]['quantite'] = format($row[0]);
   			$T5[$i]['pseudo'] = getuserNameById($row[1]);}
		else
		{	$T5[$i]['quantite'] = "/";
   			$T5[$i]['pseudo']   = "/";}
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
	$query = "SELECT type, user_id, date, pos_galaxie, pos_sys FROM ".TABLE_EXPEDITION." WHERE id = $idexp";
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
			$query = "SELECT typeRessource, metal, cristal, deuterium, antimatiere
				FROM ".TABLE_EXPEDITION_TYPE_1." WHERE id_eXpedition = $idexp";
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
