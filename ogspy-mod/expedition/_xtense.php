<<<<<<< .mine
<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if(class_exists("Callback")){
class eXpedition_Callback extends Callback {
        public $version = '2.3.10';
        public function eXpedition_xtense2_integration($expedition){
			global $io,$user_data;
			// Si vous avez des questions sur cet algorithme de vérification à 2F30 adressez-vous à unibozu sur le forum
			$checksomme = 0;
			//foreach ($expedition as $exp)
				if(eXpedition_analyse_moi_ce_rapport($user_data['user_id'], $expedition['coords'][0], $expedition['coords'][1], $expedition['time'], $expedition['content'])) 
                {
                    	$checksomme= 1;
                    
                }
				
			if($checksomme>0)
				$io->append_call_message("Un total de {$checksomme} rapports d'expéditions ont été enregistrés", Io::SUCCESS);
			else
				$io->append_call_message("Aucun rapport d'expéditions ({$checksomme}) n'a été enregistré", Io::WARNING);
			return Io::SUCCESS;
		}
        public function getCallbacks() {
                return array(
                        array(
                                'function' => 'eXpedition_xtense2_integration',
                                'type' => 'expedition'
                        )
                );
       }
}
}


global $xtense_version,$table_prefix;
$xtense_version = "2.3.0";

define("TABLE_EXPEDITION",	  $table_prefix."eXpedition");
define("TABLE_EXPEDITION_TYPE_0", $table_prefix."eXpedition_Type_0");
define("TABLE_EXPEDITION_TYPE_1", $table_prefix."eXpedition_Type_1");
define("TABLE_EXPEDITION_TYPE_2", $table_prefix."eXpedition_Type_2");
define("TABLE_EXPEDITION_TYPE_3", $table_prefix."eXpedition_Type_3");

function eXpedition_xtense2_integration($expedition)
{
	global $user_data;
	// Si vous avez des questions sur cet algorithme de vérification à 2F30 adressez-vous à unibozu sur le forum
	$checksomme = 0;
//	foreach ($expedition as $exp)
	//{
		if(eXpedition_analyse_moi_ce_rapport($user_data['user_id'], $expedition['coords'][0], $expedition['coords'][1], $expedition['date'], $expedition['content']))
		{
			$checksomme=1;
		}
	//}
	if($checksomme == 0) return FALSE;
	return TRUE;

} 


// analyser les rapports ajoutés
function eXpedition_analyse_moi_ce_rapport($uid, $galaxy, $systeme, $timestmp, $content)
{
	global $db;
    $retour = false ;
	$eXpXtense2Debug = false;
	// Tout d'abord si il a été soumis un RExp :
	$regExVaiss =    	"#Votre\sflotte\ss`est\sagrandie,\svoici\sles\snouveaux\svaisseaux\squi\ss`y\ssont\sjoints\s:(.+)#";
	$regExRess =		"#L`attaquant\sobtient\s(\S+|\S+\s\(AM\))\s(\d+)#";
	$regExMarchand1 = 	"#liste\sde\sclients\sprivil.gi.s#";
	$regExMarchand2 = 	"#dans\svotre\sempire\sun\srepr.sentant\scharg.\sde\sressources\s.\s.changer#";
	// on enleve les séparateurs
	$content = str_replace('.', '', $content);
	//Compatibilité UNIX/Windows
	$content = str_replace("\r\n","\n", $content);
	//Compatibilité IE/Firefox
	$content = str_replace("\t",' ', $content);
	//pour l'apostrophe !	
	$content = stripslashes($content);
	
	if($eXpXtense2Debug)
	{
		echo("\nregExVaiss =     ".$regExVaiss);
		echo("\nregExRess =      ".$regExRess);
		echo("\nregExMarchand1 = ".$regExMarchand1);
		echo("\nregExMarchand2 = ".$regExMarchand2);
		echo("\n");
	}
	if(preg_match($regExVaiss, $content, $expVaiss) != 0)
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

		if($eXpXtense2Debug)
		{
			echo("<big><big>-Rapport vaisseau </big></big><br />-");
			echo($content."<br />");
			echo("Date : $timestmp <br />");
			echo("Coordonnees : [$galaxy:$systeme:16]  <br />");
		}
		$units = 0;
		//recherche des vaisseaux
		if(preg_match("#Petit\stransporteur\s(\d+)#", $expVaiss[1], $reg))
		{
			$pt = $reg[1]; 
			$units += ( 2  + 2  + 0  ) * $pt;
		}
		if(preg_match("#Grand\stransporteur\s(\d+)#", $expVaiss[1], $reg))
		{
			$gt = $reg[1]; 
			$units += ( 6  + 6  + 0  ) * $gt;
		}
		if(preg_match("#Chasseur\sl.ger\s(\d+)#", $expVaiss[1], $reg))
		{
			$cle = $reg[1]; 
			$units += ( 3  + 1  + 0  ) * $cle;
		}
		if(preg_match("#Chasseur\slourd\s(\d+)#", $expVaiss[1], $reg))
		{
			$clo = $reg[1]; 
			$units += ( 6  + 4  + 0  ) * $clo;
		}
		if(preg_match("#Croiseur\s(\d+)#", $expVaiss[1], $reg))
		{
			$cr = $reg[1]; 
			$units += ( 20 + 7  + 2  ) * $cr;
		}
		if(preg_match("#Vaisseau\sde\sbataille\s(\d+)#", $expVaiss[1], $reg))
		{
			$vb = $reg[1]; 
			$units += ( 45 + 15 + 0  ) * $vb;
		}
		if(preg_match("#Vaisseau\sde\scolonisation\s(\d+)#", $expVaiss[1], $reg))
		{
			$vc = $reg[1]; 
			$units += ( 10 + 20 + 10 ) * $vc;
		}
		if(preg_match("#Recycleur\s(\d+)#", $expVaiss[1], $reg))
		{
			$rec = $reg[1]; 
			$units += ( 10 + 6  + 2  ) * $rec;
		}
		if(preg_match("#Sonde\sd`espionnage\s(\d+)#", $expVaiss[1], $reg))
		{
			$se = $reg[1]; 
			$units += ( 0  + 1  + 0  ) * $se;
		}
		if(preg_match("#Bombardier\s(\d+)#", $expVaiss[1], $reg))
		{
			$bmb = $reg[1]; 
			$units += ( 50 + 25 + 15 ) * $bmb;
		}
		if(preg_match("#Destructeur\s(\d+)#", $expVaiss[1], $reg))
		{
			$dst = $reg[1]; 
			$units += ( 60 + 50 + 15 ) * $dst;
		}
		if(preg_match("#Traqueur\s(\d+)#", $expVaiss[1], $reg))
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

		if($eXpXtense2Debug) echo("<br /> Db : $query <br />");

		if($db->sql_numrows($db->sql_query($query)) == 0)
		{
		  $retour = true;
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
			if($eXpXtense2Debug)
			{
				echo('<big><big>> Rapport de vaisseau du '.$timestmp.' deja ajoute !</big></big> <br />');
			}
			return false;
		}		
	}
	else if(preg_match($regExRess, $content, $expRess) != 0)
	{
		if($eXpXtense2Debug)
		{
			echo("<big><big>-Rapport ressource </big></big><br />-");
			echo($content."<br />");
			echo("Date : $timestmp <br />");
			echo("Coordonnees : [$galaxy:$systeme:16]  <br />");

		}
		$typeRess = -1;
		if(preg_match("#M.tal#", $expRess[1]))
		{
			$typeRess = 0;
			$met = $expRess[2];
			$cri = 0;
			$deut = 0;
			$antimat = 0;
		}
		if(preg_match("#Cristal#", $expRess[1]))
		{
			$typeRess = 1;
			$met = 0;
			$cri = $expRess[2];
			$deut = 0;
			$antimat = 0;
		}
		if(preg_match("#Deut.rium#", $expRess[1]))
		{
			$typeRess = 2;
			$met = 0;
			$cri = 0;
			$deut = $expRess[2];
			$antimat = 0;
		}
		if(preg_match("#Antimati.re#", $expRess[1]))
		{
			$typeRess = 3;
			$met = 0;
			$cri = 0;
			$deut = 0;
			$antimat = $expRess[2];
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

		if($eXpXtense2Debug) echo("<br /> Db : $query <br />");

		if($db->sql_numrows($db->sql_query($query)) == 0)
		{
		    $retour = true;
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
			if($eXpXtense2Debug)
			{
				echo('<big><big>> Rapport de ressource du '.$timestmp.' deja ajoute !</big></big> <br />');
			}
			return false;
		}
		
	}
	else if((preg_match($regExMarchand1, $content) != 0) || (preg_match($regExMarchand2, $content) != 0))
	{
		if($eXpXtense2Debug)
		{
			if(preg_match($regExMarchand1, $content) != 0)
				echo("<big><big>-Rapport marchand1-</big></big><br />");
			else
				echo("<big><big>-Rapport marchand2-</big></big><br />");
			echo($content."<br />");
			echo("Date : $timestmp <br />");
			echo("Coordonnees : [$galaxy:$systeme:16]  <br />");
		}
		
		$query = 
			"Select * 
			From ".TABLE_EXPEDITION." 
			Where user_id = $uid 
			and date = $timestmp 
			and pos_galaxie = $galaxy 
			and pos_sys = $systeme and type = 3";

		if($eXpXtense2Debug) echo("<br /> Db : $query <br />");

		if($db->sql_numrows($db->sql_query($query)) == 0)
		{
		    $retour = true;
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
			if($eXpXtense2Debug)
			{
				if(preg_match($regExMarchand1, $content) != 0)
					echo('<big><big>> Rapport de marchand1 du '.$timestmp.' deja ajoute !</big></big> <br />');
				else
					echo('<big><big>> Rapport de marchand2 du '.$timestmp.' deja ajoute !</big></big> <br />');
			}
			return false;
		}
	}
	else
	{
		if($eXpXtense2Debug)
		{
			echo("<big><big>-Rapport rien </big></big><br />-");
			echo($content."<br />");
			echo("Date : $timestmp <br />");
			echo("Coordonnees : [$galaxy:$systeme:16]  <br />");
		}
		$query = 
			"Select * 
			From ".TABLE_EXPEDITION." 
			Where user_id = $uid 
			and date = $timestmp 
			and pos_galaxie = $galaxy 
			and pos_sys = $systeme 
			and type = 0";
		if($eXpXtense2Debug) echo("<br /> Db : $query <br />");
		if($db->sql_numrows($db->sql_query($query)) == 0)
		{
		    $retour = true;
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
			if($eXpXtense2Debug) echo('<big><big>> Rapport de rien du '.$timestmp.' deja ajoute !</big></big> <br />');
			return false;
		}
	}
	return $retour;
}
?>
=======
<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

if(class_exists("Callback")){
class eXpedition_Callback extends Callback {
	public $version = '2.3.14';
    public function getCallbacks() {
		return array (
			array('function' => 'eXpedition_xtense2_integration','type' => 'expedition'),
//			array('function' => 'eXpedition_rc','type' => 'rc')
			);
       }
	
/**	public function eXpedition_rc($data) {
		global $db, $io, $user_data, $table_prefix;
		define("TABLE_TEST", $table_prefix."test");
		$uid = $user_data['user_id'];
		$timestmp = $data['time'];
		$galaxy = $data['coords'][0];
		$systeme = $data['coords'][1];
		$planet = $data['coords'][2];
		$content = str_replace('.', '', $data['content']);	//Compatibilité UNIX/Windows
		$content = str_replace("\r\n","\n", $content);	//Compatibilité IE/Firefox
		$content = str_replace("\n","", $content);	//saut de ligne
		$content = str_replace("\t",'', $content);	//pour l'apostrophe !	
		$content = str_replace("  ",'', $content);	//espace
		$content = stripslashes($content); //Pas sûr que utile
	
		$type = 4;
		{$query = "Insert into ".TABLE_TEST." (id, user_id, date, pos_galaxie, pos_sys, type, perte, contents) values ('', $uid, $timestmp, $galaxy, $systeme, $type, 0, $content)";
		$db->sql_query($query);}
	}	
**/
    public function eXpedition_xtense2_integration($data) {
		global $db, $io, $user_data, $table_prefix;
		define("TABLE_TEST", $table_prefix."test");
		define("TABLE_EXPEDITION",$table_prefix."eXpedition");
		define("TABLE_EXPEDITION_TYPE_1",$table_prefix."eXpedition_Type_1");
		define("TABLE_EXPEDITION_TYPE_2",$table_prefix."eXpedition_Type_2");

		$uid = $user_data['user_id'];
		$timestmp = $data['time'];
		$galaxy = $data['coords'][0];
		$systeme = $data['coords'][1];
		$planet = $data['coords'][2];
		$content = str_replace('.', '', $data['content']);	//Compatibilité UNIX/Windows
		$content = str_replace("\r\n","\n", $content);	//Compatibilité IE/Firefox
		$content = str_replace("\n","", $content);	//saut de ligne
		$content = str_replace("\t",'', $content);	//pour l'apostrophe !	
		$content = str_replace("  ",'', $content);	//espace
		$content = stripslashes($content); //Pas sûr que utile

		$regExCombat =  "#Rapport de combat#";
		$regExVaiss = "#Grand transporteur|Petit transporteur|Chasseur léger|Chasseur lourd|Sonde espionnage|Croiseur|Vaisseau de bataille|Traqueur|Destructeur#";
		$regExRess = "#Métal|Cristal|Deutérium|Antimatière#";
		$regExMarchand = "#liste\sde\sclients\sprivilégiés|dans\svotre\sempire\sun\sreprésentant\schargé\sde\sressources\sà\séchanger#";
	
		//et on extrait les entetes pour trouver le type de rapport
		$nbRapportVaiss = preg_match($regExVaiss, $content, $reg);
		$nbRapportRess = preg_match($regExRess, $content, $reg);
		$nbRapportMarchand = preg_match($regExMarchand, $content, $reg);
	
		$nbRapport = $nbRapportRess + $nbRapportVaiss + $nbRapportMarchand;

		if ($nbRapport == 0 ) {
			$nbRapportRien = preg_match($regExCombat, $content, $expsRien);
			if ($nbRapportRien > 0) {
				if(preg_match("/pirates/i", $content, $reg))
					{$nbRapport = 1; $type = 4;}
				elseif(preg_match("/aliens/i", $content, $reg))
					{$nbRapport = 1; $type = 5;}
			}
		else {
			if (preg_match("/Pirates|Aliens|pirates|aliens|espèce inconnue/i", $content, $reg))
				{
				$io->append_call_message("Aucun rapport d'expéditions enregistré", Io::WARNING); 
			//	$query = "Insert into ".TABLE_TEST." (user_id, chaine, varint) values ($uid, 'rapport expe combat 2', $timestmp)";
			//	$db->sql_query($query);
				return;
				}
			else
				{$nbRapport = 1; $type = 0;}}
		}

		if ($nbRapport == 0) {$io->append_call_message("Aucun rapport d'expéditions enregistré", Io::WARNING);
//							$query = "Insert into ".TABLE_TEST." (user_id, chaine, varint) values ($type, 'aucun rapport enregistré 2', $nbRapport)";
//							$db->sql_query($query);
							return Io::WARNING;}
		elseif ($nbRapportVaiss > 0) {	$type = 2;
										$io->append_call_message("1 rapport de vaisseaux détécté", Io::SUCCESS);}
		elseif ($nbRapportRess > 0) {	$type = 1;
										$io->append_call_message("1 rapport de ressources détécté", Io::SUCCESS);}
		elseif ($nbRapportMarchand > 0) {$type = 3;
										$io->append_call_message("1 rapport de marchands détécté", Io::SUCCESS);}
		elseif ($type == 0)	{$io->append_call_message("1 rapport d'echec détécté", Io::SUCCESS);}
		elseif	($type == 4) {$io->append_call_message("1 rapport d'echec avec combat pirates détécté", Io::SUCCESS);
/**							preg_match_all("#unités perdues: (\d+)#", $content, $tmp);
							preg_match("(\d+)", $tmp[0][1], $reg);
							$pertes=$reg[0];
							$query = "Insert into ".TABLE_TEST." (user_id, contents) values ($uid, $pertes)";
							$db->sql_query($query); **/
							}
		elseif	($type == 5) {$io->append_call_message("1 rapport d'echec avec combat aliens détécté", Io::SUCCESS);}
		else {	$io->append_call_message("Aucun rapport d'expéditions enregistré", Io::WARNING);
				return Io::WARNING;}

		$query = "Select * From ".TABLE_EXPEDITION." Where user_id = $uid and date = $timestmp and pos_galaxie = $galaxy and pos_sys = $systeme and type = $type";
		$result = $db->sql_query($query);
		if($db->sql_numrows($result) == 0)
		{
			if ($type == 3 || $type == 0) // Marchand ou rien
				{$query = "Insert into ".TABLE_EXPEDITION." (id, user_id, date, pos_galaxie, pos_sys, type, perte) values ('', $uid, $timestmp, $galaxy, $systeme, $type, 0)";
				$db->sql_query($query);}
			elseif ($type >= 4) // attaque alien/pirates
				{preg_match_all("#unités perdues: (\d+)#", $content, $tmp);
				preg_match("(\d+)", $tmp[0][1], $reg);
				$pertes=$reg[0];
				$query = "Insert into ".TABLE_EXPEDITION." (id, user_id, date, pos_galaxie, pos_sys, type, perte) values ('', $uid, $timestmp, $galaxy, $systeme, $type, $pertes)";
				$db->sql_query($query);}
			elseif ($type == 1) // Ressources
				{$query = "Insert into ".TABLE_EXPEDITION." (id, user_id, date, pos_galaxie, pos_sys, type, perte) values ('', $uid, $timestmp, $galaxy, $systeme, $type, 0)";
				$db->sql_query($query);
				$idInsert = $db->sql_insertid();
				if(preg_match("#Métal\s(\d+)#", $content, $reg))
					$query2 = "Insert into ".TABLE_EXPEDITION_TYPE_1." (id, id_eXpedition, typeRessource, metal, cristal, deuterium, antimatiere) 
						values ('', $idInsert, 0, $reg[1], 0, 0, 0)";
				elseif(preg_match("#Cristal\s(\d+)#", $content, $reg))
					$query2 = "Insert into ".TABLE_EXPEDITION_TYPE_1." (id, id_eXpedition, typeRessource, metal, cristal, deuterium, antimatiere) 
						values ('', $idInsert, 0, 0, $reg[1], 0, 0)";
				elseif(preg_match("#Deutérium\s(\d+)#", $content, $reg))
					$query2 = "Insert into ".TABLE_EXPEDITION_TYPE_1." (id, id_eXpedition, typeRessource, metal, cristal, deuterium, antimatiere) 
						values ('', $idInsert, 0, 0, 0, $reg[1], 0)";
				elseif(preg_match("#Antimatière\s(\d+)#", $content, $reg))
					$query2 = "Insert into ".TABLE_EXPEDITION_TYPE_1." (id, id_eXpedition, typeRessource, metal, cristal, deuterium, antimatiere) 
						values ('', $idInsert, 0, 0, 0, 0, $reg[1])";
				$db->sql_query($query2);}
			elseif ($type == 2) // Flottes
				{$query = "Insert into ".TABLE_EXPEDITION." (id, user_id, date, pos_galaxie, pos_sys, type, perte) values ('', $uid, $timestmp, $galaxy, $systeme, $type, 0)";
				$pt = 0; $gt = 0; $cle = 0;	$clo = 0; $cr = 0; $vb = 0; $vc = 0; $rec = 0; $se = 0; $bmb = 0; $dst = 0; $tra = 0; $units = 0;
			//recherche des vaisseaux
				if(preg_match("#Petit\stransporteur\s(\d+)#", $content, $reg))
					{$pt = $reg[1]; $units += ( 2  + 2  + 0  ) * $pt;}
				if(preg_match("#Grand\stransporteur\s(\d+)#", $content, $reg))
					{$gt = $reg[1]; $units += ( 6  + 6  + 0  ) * $gt;}
				if(preg_match("#Chasseur\sléger\s(\d+)#", $content, $reg))
					{$cle = $reg[1]; $units += ( 3  + 1  + 0  ) * $cle;}
				if(preg_match("#Chasseur\slourd\s(\d+)#", $content, $reg))
					{$clo = $reg[1]; $units += ( 6  + 4  + 0  ) * $clo;}
				if(preg_match("#Croiseur\s(\d+)#", $content, $reg))
					{$cr = $reg[1]; $units += ( 20 + 7  + 2  ) * $cr;}
				if(preg_match("#Vaisseau\sde\sbataille\s(\d+)#", $content, $reg))
					{$vb = $reg[1]; $units += ( 45 + 15 + 0  ) * $vb;}
				if(preg_match("#Vaisseau\sde\scolonisation\s(\d+)#", $content, $reg))
					{$vc = $reg[1]; $units += ( 10 + 20 + 10 ) * $vc;}
				if(preg_match("#Recycleur\s(\d+)#", $content, $reg))
					{$rec = $reg[1]; $units += ( 10 + 6  + 2  ) * $rec;}
				if(preg_match("#espionnage\s(\d+)#", $content, $reg))
					{$se = $reg[1]; $units += ( 0  + 1  + 0  ) * $se;}
				if(preg_match("#Bombardier\s(\d+)#", $content, $reg))
					{$bmb = $reg[1]; $units += ( 50 + 25 + 15 ) * $bmb;}
				if(preg_match("#Destructeur\s(\d+)#", $content, $reg))
					{$dst = $reg[1]; $units += ( 60 + 50 + 15 ) * $dst;}
				if(preg_match("#Traqueur\s(\d+)#", $content, $reg))
					{$tra = $reg[1]; $units += ( 30 + 40 + 15 ) * $tra;}

				$db->sql_query($query);
				$idInsert = $db->sql_insertid();
				$query2 = "Insert into ".TABLE_EXPEDITION_TYPE_2." (id, id_eXpedition, pt, gt, cle, clo, cr, vb, vc, rec, se, bmb, dst, tra, units)
					values ('', $idInsert, $pt, $gt, $cle, $clo, $cr, $vb, $vc, $rec, $se, $bmb, $dst, $tra, $units)";
				$db->sql_query($query2);
			}
	return Io::SUCCESS;
	}
	else {
			$dateTmp = date('d-m-Y H:i:s', $timestmp);
			$io->append_call_message("Rapport du '.{$dateTmp}.' deja ajoute ", Io::WARNING);
			return Io::WARNING;}
}
}}
?>>>>>>>> .r7405
