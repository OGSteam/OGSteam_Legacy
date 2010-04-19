<?php
/** $Id$ **/
/**
* Fichier de gestion des Template
* @package OGSpy
* @subpackage Main
* @copyright Copyright &copy; 2008, http://ogsteam.fr/
* @modified $Date$
* @author Sylar
* @link $HeadURL$
* @version 3.99 ( $Rev$ ) 
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");


class template {
	var $page; // Texte de la page HTML
	var $infoTpl; // Tableau des variables
	var $Blocs; // Bloc défini
	
	// Création de la variable : import du fichier dans $page
	function __construct($file) {
		// Teste si le fichier existe et si il est autorisé en lecture
		if(empty($file) or !file_exists($file) or !is_readable($file)) $file = PATH_TPL.$file;
		if(empty($file) or !file_exists($file) or !is_readable($file)) {
			// Si le fichier est inexistant pas : erreur
			die('Template error : file '.$file.' not found.');
		} else {
			// Ouverture du fichier
			$handle = fopen($file, 'rb');
			// Enregistrement du fichier dans $this->page
			$this->page = fread($handle, filesize ($file));
			// Fermeture du fichier
			fclose ($handle);
			// Récupération des définition
			$this->SetDefined();
		}
	}
	
	// Enregistrement des blocs définis par <define=name></define>
	function SetDefined(){
		$unmatchedStarts = Array();
		$startMarkup =  "<!-- define=";
		$endMarkup = "<!-- /define -->";
		$startMarkupLength = strlen ($startMarkup) -2;
		$rgx = "`<\!-- define=([^\s]*) -->([\s\S.]*)`";
		
		//on prend la 1ere balise start
		$offset = 0;
		$a = 0;
		
		//echo "pos1:".$pos1;
		$test = true;//($pos1 !== false && $a < 1);
		while($test)
		{
			$a++;
			
			//on cherche la balise start ou end suivante
			$startPos = strpos ($this->page  , $startMarkup, $offset );
			$endPos = strpos ($this->page  , $endMarkup, $offset );
			
			if($endPos !== false)
			{
				//si c'est une end, on la match avec la start précédente
				if($startPos === false || $endPos < $startPos)
				{
					//echo "END FOUND";
					$currentStart = array_pop($unmatchedStarts);
					//et on lit les données
					$bloctext = substr ( $this->page, $currentStart, $endPos-$currentStart);
					preg_match($rgx,$bloctext,$matches);
					$this->Blocs[$matches[1]] = $matches[2];
					
					$this->page = str_replace($bloctext.$endMarkup,'{'.$matches[1].'}',$this->page);
					$offset = min($currentStart + $startMarkupLength,strlen($this->page)-1);
					
				}
				//si c'est une start, on l'ajoute à la pile des starts
				else if($startPos !== false && $endPos > $startPos)
				{
					//echo "START FOUND";
					array_push($unmatchedStarts, $startPos);
					$offset = min($startPos+$startMarkupLength,strlen($this->page)-1);//l'offset assure de chercher la balise suivante
				}
			
			}
			else
			{
				$test = false;
			}
			/*if($a > 6)
				$test = false;*/
			//echo " endLoop".$a."||";
		}
		
		//$this->ExtractDefined($this->page);
		//echo $this->page;
		//echo "count".count($this->Blocs);
		//print_r($this->Blocs);
		
	}
	
	// Renvoi un bloc défini en remplacant les variables données
	function GetDefined($blocname,$vars=Array()){
		$tmp = $this->Blocs[$blocname];
		foreach($vars as $value => $text){
			$tmp = preg_replace('`{'.$blocname.'.'.$value.'}`', $text, $tmp);
		}
		return trim($tmp);
	}
	
	// Enregistrement d'une variable simple
	function simpleVar($varArray = array()) {
		// Si le tableau est vide, on stoppe le script
		if (empty($varArray)) exit;

		// Parcours du tableau
		foreach ($varArray as $var => $data) {
			// Enregistrement dans le tableau $this->infoTpl
			$this->infoTpl['.'][][$var] = $data;
		}
	}

	// Enregistrement d'une variable Loop
	function loopVar($type, $varArray = array()) {
		// Si le tableau est vide, on stoppe le script
		if (empty($varArray)) exit;
        
		// Calcule le nombre de lignes dans le type courant
		$lastID = !isset($this->infoTpl[$type])?0:(count($this->infoTpl[$type]) != 0) ? (count($this->infoTpl[$type])) : 0;
        
		foreach ($varArray as $constant => $data) {
			$this->infoTpl[$type][$lastID][$constant] = $data;
		}
	}
	
	// Traitement des conditions
	function checkIf($var_name,$var_value,$text = NULL){
		// Si texte n'est pas renseigné, on prends la page et on retourne vers la page
		if($text == NULL) { $text = $this->page; $returnToPage = true; } else $returnToPage = false;
		
		// Si la variable n'est pas booleenne on sort
		if(!is_bool($var_value)) return $text; //

		// Transformation du texte en tableau
		$textArray = explode("\n",htmlentities($text));
		
		// Suppression des espaces
		foreach($textArray as $i => $temp)
			$textArray2[$i] = trim($temp);
		
		// Tant qu'on trouve les tags IF et END IF et que l'un est après l'autre
		while(($startIf=array_search(htmlentities('<!-- IF '.$var_name.' -->'),$textArray2)) !== false 
			&& ($endIf=array_search(htmlentities('<!-- END IF '.$var_name.' -->'),$textArray2)) !== false
			&& ($startIf < $endIf)) {
			
			// Recherche des index
			$startIf = $startIf+1;
			$elseIf = array_search(htmlentities('<!-- ELSE IF '.$var_name.' -->'),$textArray2);
			$endIf = $endIf-1;
			
			// definition des blocs et de leur longeurs
			// S'il n'y a pas de ELSE, ou que le ELSE n'est pas entre le IF et le END IF (il est donc dans un autre bloc)
			if($elseIf===false || $elseIf>$endIf || $elseIf<$startIf){
				// Condition simple : il n'y a pas de ELSE
				$lengthIf = ($endIf - $startIf) + 1;
				$lengthElse = 0;
				$blockIf = array_slice($textArray, $startIf, $lengthIf);
				$blockElse = Array();
			}else{
				// Condition double, si FAUX : copier le bloc ELSE
				$lengthIf = (($elseIf-1) - $startIf) + 1;
				$lengthElse = ($endIf - ($elseIf+1)) + 1;
				$blockIf = array_slice($textArray, $startIf, $lengthIf);
				$blockElse = array_slice($textArray, $elseIf+1, $lengthElse);
			}

			// Découpage des 2 block : Avant, Apres
			$blockFirst = array_slice($textArray, 0, $startIf - 1);
			$blockSecond = array_slice($textArray, $endIf + 2);

			// En fonction de la valeur de la variable : recomposition du tableau avec le bloc IF ou le ELSE
			if($var_value === true){
				$textArray = array_merge($blockFirst, $blockIf, $blockSecond);
			}else{
				$textArray = array_merge($blockFirst, $blockElse, $blockSecond);
			}
			
			// On reinitialise le tableau sans espace pour la condition du while{}
			$textArray2 = Array();
			foreach($textArray as $i => $temp)
				$textArray2[$i] = trim($temp);
		}
		
		// Si on utiliser $page, on l'actualise
		if($returnToPage==true) $this->page = html_entity_decode(implode("\n",$textArray));
		
		// Renvoi du texte traité
		return html_entity_decode(implode("\n",$textArray));
	}
	
	// Remplacement des variables simple et loop
	function constantReplace() {
		// Parcours de tout le taleau $this->infoTpl
		if(is_array($this->infoTpl))
		foreach($this->infoTpl as $type => $info) {
			// Si le type est '.' càd
			// provient de la fonction simpleVar()
			// ou encore de constantes places hors-boucle
			if ($type == '.') {
				for ($i = 0, $imax = count($info); $i < $imax; $i++) {
					foreach ($info[$i] as $constant => $data) {
						// Remplace {CONSTANTE} par les donneés correspondantes
						// et mets  jour le code HTML du fichier test.tpl
						// stock dans $this->page
						/* si $data est un nom de fichier, on cherche à l'inclure s'il existe. 
						DESACTIVE a cause de la variable $link_css *
						$data = (file_exists($data)) ? $this->includeFile($data) : $data; //*/
						$this->page = preg_replace('`{'.$constant.'}`', $data, $this->page);
					}
				}
			// Sinon si le type est autre càd
			// provient de la fonction loopVar()
			// ou encore de constantes places dans une boucle
			} else {
				// Calcule la taille du tableau $info
				$infoSize = count($info);
				
				// Encode les caractres spéciaux
				$page = htmlentities($this->page);
					
				// $page est une variable string
				// Remplit le tableau $infoArray ligne par ligne
				$infoArray = explode("\n", $page);
					
				// Suppression des espaces blancs avant/après
				// dus aux indentations du code
				for ($k = 0, $kmax = count($infoArray); $k < $kmax; $k++) {
					$infoArray2[$k] = trim($infoArray[$k]);
				}    
					
				// Récupration et formatage des tags
				$startTag = '<!-- BEGIN '.$type.' -->';
				$startTag_c = htmlentities($startTag);
						
				$endTag = '<!-- END '.$type.' -->';
				$endTag_c = htmlentities($endTag);
				
				// Verifie que les tags sont bien trouvé dans le script
				if(array_search($startTag_c, $infoArray2)&&array_search($endTag_c, $infoArray2))
				do{
					// Variable qui contiendra le code à la place de
					//  <!-- BEGIN country -->
					//  {country.ID} => {country.COUNTRY}
					// <!-- END country -->
					$block = '';
					
					// Récupration de la clé des tags dans le tableau $infoArray
					$startTag = (array_search($startTag_c, $infoArray2)) + 1;
					$endTag = (array_search($endTag_c, $infoArray2)) - 1;
					// Nombre de lignes entre les tags
					$lengthTag = ($endTag - $startTag) + 1;
					
					// Parcourt le tableau $info
					for ($i = 0; $i < $infoSize; $i++) {
						// Récupration de la portion du tableau
						// délimite par les tags (tags non compris)
						$blockTag = array_slice($infoArray, $startTag, $lengthTag);

						// Remise en type 'string' et non plus 'array'
						// Facilitera le remplacement des constantes par leurs donneés
						$blockTag = implode("\n", $blockTag);
						
						// Remplacement des constantes par leur données
						foreach($info[$i] as $constant => $data) {
							// Si c'est un boolean, on cherche un block IF
							if(is_bool($data)){
								$blockTag = $this->checkIf($type.'.'.$constant,$data,html_entity_decode($blockTag)); 
								$blockTag = htmlentities($blockTag);
							}
							/* si $data est un nom de fichier, on cherche à l'inclure s'il existe. 
							DESACTIVE a cause de la variable $link_css *
							$data = (file_exists($data)) ? $this->includeFile($data) : $data; //*/
							$blockTag = preg_replace('`{'.$type.'.'.$constant.'}`', htmlentities($data), $blockTag);
						}
					
						// Ajout des données à la variable block globale pour la boucle
						// Ajoute \n ou pas et ajoute les données
						// de la nouvelle boucle à la suite de $block
						$block = ($block == '') ? $blockTag : $block."\n".$blockTag;
					}
				
					// Mise en tableau de $block
					// Facilitera l'opération de reconstitution des tableaux
					$block = explode ("\n", $block);
				
					// Coupe du tableau en 2
					// $fisrtPart = début du tableau   ----->    <!-- BEGIN country -->
					// $secondPart = <!-- BEGIN country -->    ----->    fin du tableau
					$firstPart = array_slice($infoArray, 0, $startTag - 1);
					$secondPart = array_slice($infoArray, $startTag + $lengthTag + 1);
				
					// Reconstitution du code source
					// en insrant au milieu les donnes
					$infoArray = $infoArray2 = Array();
					$infoArray = array_merge($firstPart, $block, $secondPart);
				
					for ($k = 0, $kmax = count($infoArray); $k < $kmax; $k++) 
						$infoArray2[$k] = trim($infoArray[$k]);
				
				// Tant que les TAG sont trouvé, on relance la copie (permet d'avoir plusieurs block BEGIN/END pour un même tableau
				}while(array_search($startTag_c, $infoArray2)&&array_search($endTag_c, $infoArray2));
				
				$page = $infoArray;
				
				// Décode les balises HTML qui étaient encodées avec htmlentities()
				for ($i = 0, $imax = count($page); $i < $imax; $i++) {
					$page[$i] = html_entity_decode($page[$i]);
				}
				
				// Mets  jour le code HTML du fichier test.tpl
				// stock dans $this->page
				$this->page = implode("\n", $page);
			}
		}
	}

	// Permet d'inclure un fichier lorsqu'il est utilisé comme nom de variable
	function includeFile ($file) {

		// Enclenche la temporisation de sortie
		ob_start();
	
		include $file;
	
		// Enregistre le contenu du tampon de sortie
		$buffer = ob_get_contents();
	
		// Efface le contenu du tampon de sortie
		ob_clean();
	
		// Retourne les données enregistrées
		return $buffer;
	}
	
	// Vire  les bloc IF non traité (donc faux)
	function removeIf(){
		$var_done = Array();
		do{
			$text = $this->page;
		
			// Transformation du texte en tableau
			$textArray = explode("\n",$text);
		
			$var_name = "";
			
			foreach($textArray as $i => $temp){
				if(preg_match('/<!-- IF (.*) -->/',$temp,$matches)){
					// Teste si la variable trouvé n'a pas déjà été trouvé 
					// (peu arriver s'il n'y a pas de END IF pour cette variable : le checkIf ne l'effacera pas.
					//if(!in_array($matches[1],$var_done)){   //<------------------- Si y'a plusieurs fois la meme variable a effacer ?
						// donc un IF sans son END IF crééra une erreur...
						$var_done[] = $var_name = $matches[1];
						continue;
					//}
				}
			}
			if($var_name == "") continue;
			$this->checkIf($var_name,false);
		} while($var_name!="");
	}
	
	// Affichage du template
	function parse($return=false) {
		
		// Remplacement des constantes.
		$this->constantReplace();
		
		// Effacement des variables de défine restante (elles n'ont pas été définie)
		if(is_array($this->Blocs)){
			$last_defined = array_keys($this->Blocs);
			foreach($last_defined as $define_id)
				$this->page = preg_replace('`{'.$define_id.'}`', '', $this->page);
		}
		
		// Effacement des blocs If non déclaré (donc faux).
        $this->removeIf();
		
		// Traitement des dernières variables (passage a la traduction)
		$this->page = CheckForTranslate($this->page);
		
		// Affichage
		if($return!=false)
			return $this->page;
		else
			echo $this->page;
	}

}

	// Traitement des variables restant et traduction
function CheckForTranslate($target){
	global $help,$pub_ajax;
	$possible_var = array();
	$rgx = "`\{([a-zA-Z0-9\.-_]*)\}`";
	if(preg_match_all($rgx,$target,$matches))
		$possible_var = $matches[1];
		
	foreach($possible_var as $var_name){
		if(preg_match('`help_(.*)`',$var_name,$matches2) && isset($help[$matches2[1]])){
				$target = str_replace('{'.$var_name.'}',help($matches2[1]),$target);
		}else{
			$data = L_($var_name,false);
			if($data != $var_name)
				$target = str_replace('{'.$var_name.'}',$data,$target);
		}
	}
	return $target;
}


?>
