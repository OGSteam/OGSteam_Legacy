<?php
	//utilisation du framework de l'appi
	include "ewcfg7.php" ;
	include "ewmysql7.php"; 
	include "phpfn7.php" ;
	
	//connection bdd
	$conn = ew_Connect();
	//langue par defaut pour le mod
	$lang_default = 'en';
	
	if(isset($_GET['version']) && isset($_GET['lang']))
	{
		$v = $_GET['version'];
		$lang = $_GET['lang'];
		$ve = explode(".", $v);
		$vv  = $ve[0];
		$vma = $ve[1];
		$vmi = $ve[2];
		//requete qui renvoie la version max du mod compatible avec la version ogspy, à condition que la version des mods soit un nombre
		//autrement il est difficile de faire tout ca en une requete ...
		$sSqlWrk = "SELECT m.root_module as root, max(mv.version) as version ".
					"FROM `mod_version` mv, ogspy_version min, ogspy_version max, module m ".
					"WHERE mv.id_module = m.id_module ".
					"and mv.id_version_min = min.id_ogspy_version ".
					"and mv.id_version_max = max.id_ogspy_version ".
					"and ( ".
					"min.version < $vv ".
					"OR (min.version = $vv AND min.major < $vma) ".
					"OR (min.version = $vv AND min.major = $vma AND min.minor <= $vmi) ".
					") and ( ".
					"max.version > $vv ".
					"OR (max.version = $vv AND max.major > $vma) ".
					"OR (max.version = $vv AND max.major = $vma AND max.minor >= $vmi) ".
					") ".
					"GROUP BY m.root_module";
					
		//echo $sSqlWrk;
		$rswrk = $conn->Execute($sSqlWrk);
		$c = $rswrk->RecordCount();

		$cnt = 0;
		header ("content-type: text/xml");
		echo "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>\n";
		echo "<modogspy>\n";
		//tant que le resultset n'est pas vide
		while (!$rswrk->EOF && $c != $cnt) {
			
			$root = $rswrk->fields('root');
			$version = $rswrk->fields('version');
			//on recupere le mod name et mod description en fonction de la langue du OGSpy, si elle n'existe pas, on prend le lang_default
			//peut etre possible d'integrer cette sous requete dans la requete plus haut
			$sSqlWrk = "SELECT mod_name, mod_description FROM `mod_lang` ml, module m, lang l ".
						"WHERE ml.id_module = m.id_module and ml.id_lang = l.id_lang ".
						"and (l.country = '$lang' or l.country = '$lang_default') ".
						"and root_module = '$root' ";
						
			$rs = $conn->Execute($sSqlWrk);
			$mc = $rs->RecordCount();
			if($mc > 0)
			{
				//en premier dans le rs, c'est le $lang, si le mod_name est vide , c'est que le mod n'a pas cette lang, donc on prend le suivant qui lui est le defaut
				while ( count($rs->fields('mod_name')) == 0 )
				{
					$rs->MoveNext();
				}
				if(!$rs->EOF)
				{
					echo "\t<mod>\n";
					echo "\t\t<name>".$rs->fields('mod_name')."</name>\n";
					echo "\t\t<description><![CDATA[".$rs->fields('mod_description')."]]></description>\n";
					echo "\t\t<version>$version</version>\n";
					echo "\t\t<root>$root</root>\n";
					echo "\t</mod>\n";
				}
			}
			$rswrk->MoveNext();
			$cnt++;
		}
		echo "</modogspy>\n";
	}
 ?>
 