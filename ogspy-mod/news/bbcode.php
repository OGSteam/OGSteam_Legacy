<?php
	// BBCode parser v0.1
	// LAlex 2003
	// lalex@lalex.com - http://www.lalex.com/
	//
	// Le terme BBCode est la propriété de phpBB : http://www.phpBB.com/
	//
	// Ce code est protégé par les lois sur la propriété intellectuelle et
	// ne peut être vendu ni utilisé a des fins commerciales.
	// Il doit être redistribué gratuitement, et toute modification lors de
	// sa diffusion doit être signalée dans l'entête du code et/ou dans le
	// fichier 'lisezmoi.txt' fourni avec.
	//
	// Soyez gentil de m'envoyer un ch'tit mail si vous utilisez ce code
	// avec l'URL du site sur lequel il tourne.
	// Si en plus vous pouvez faire une lien sur mon site, c'est le bonheur !!!
	// Merci d'avance !
?>
<?php
	// transforme les adress email et URL en liens
	function renderLinks ($str) { 
		$tmp = $str;
		// Tous les email deviennent des liens
		$tmp = preg_replace("#(\s|^)((?:[\w\.~-]*?)@(?:.*?))((?:\.)?(\s|$|\[|\())#i","$1<a href=\"mailto:$2\">$2</a>$3",$tmp);
		// Toutes les URL avec http:// ou ftp:// etc.. deviennent des liens
		$tmp = preg_replace("#(\s|^)(\w{3,8}://.*?)((?:\.)?(\s|$|\[|\())#is","$1<a href=\"$2\" target=\"blank\">$2</a>$3",$tmp);
		// Toutes les URL commencant par www. deviennent des liens
		$tmp = preg_replace("#(\s|^)(www\..*?)((?:\.)?(\s|$|\[|\())#is","$1<a href=\"http://$2\" target=\"blank\">$2</a>$3",$tmp);
		return $tmp;
	}

	// Les tableaux contenant les données des BBCodes
	// bbTags : contient le nom de chaque tag
	$bbTags = Array();
	// htmlTags : contient les données de traduction en code HTML
	$htmlTags = Array();
	// Contient les tags ouverts dans le fichier XML
	$xmlstack = Array();
	// Contient le tag BBCode en cours du fichier XML
	$xmlcurtag = "";
	
	// Appelé à l'ouverture d'un tag XML
	function startTag($parser, $name, $att) {
		// On récupères les tableaux
		global $bbTags;
		global $htmlTags;
		global $xmlstack;
		global $xmlcurtag;
		// On ajoute le tag ouvert dans la pile de tags XML
		array_push($xmlstack,$name);
		// Si c'est un debut de déclaration de tag BBCode
		if ($name == "TAG") {
			// S'il a un nom
			if($curtag = $att["NAME"]) {
				// On rajoute le tag aux tags BBCode
				array_push($bbTags,$curtag);

				// evite les E_NOTICE
				if (!isset($att["CLOSE"])) $att["CLOSE"] = '';
				if (!isset($att["PARENT"])) $att["PARENT"] = '';
				if (!isset($att["KEEPVALUE"])) $att["KEEPVALUE"] = '';
				if (!isset($att["RENDER"])) $att["RENDER"] = '';
				if (!isset($att["PARAM"])) $att["PARAM"] = '';
				if (!isset($att["FUNCTION"])) $att["FUNCTION"] = '';

				// Pour différencier les comportements avec parametre et
				// sans paramètre, on rajoute un identifiant -param
				if ($att["PARAM"] == "yes") {
					$curtag .= "-param";
				}
				// Le tag courant est initialisé
				$xmlcurtag = $curtag;
				// On crée une entrée dans les paramètres HTML du tag
				//  - close : Dit si le tag doit être fermé
				//  - parent : Dit si le tag doit obligatoirement être imbriqué
				//             dans un autre
				//  - keep : Sit si on conserve le texte contenu entre le tag d'ouverture
				//           et le tag de fermeture
				//  - param : Dit si le tag d'ouverture doit avoir un parametre =param
				//  - function : Specifie le nom d'une fonction a appeler pour modifer
				//               le contenu du tag.
				$htmlTags[$curtag] = Array("close"=>$att["CLOSE"],
								       "parent"=>$att["PARENT"],
									   "keep"=>$att["KEEPVALUE"],
									   "render"=>$att["RENDER"],
									   "param"=>$att["PARAM"],
									   "function"=>$att["FUNCTION"]);
			}
		}
	}
	
	// Appelé à la fermeture d'un tag XML
	function endTag($parser, $name) {
		global $xmlstack;
		global $xmlcurtag;
		// Le tag courant est vidé
		if (array_pop($xmlstack) == "TAG") {
			$xmlcurtag = "";
		}
	}
	
	// Appelé au parsage du contenu d'un tag XML
	function cdataTag($parser, $data) {
//		echo htmlspecialchars($getdata) . " * " . htmlspecialchars($data) . "<br>";
		// Recupere la pile de tags XML ouverts
		global $xmlstack;
		global $xmlcurtag;
		// Récupère les données HTML
		global $htmlTags;
		// Si c'est le remplacement du tag d'ouverture
		// on renseigne la propriété "begin" des données HTML
		// du tag en cours
		if (($curtag = array_pop($xmlstack)) == "BEGIN") {
			$htmlTags[$xmlcurtag]["begin"] = $data;
		} elseif ($curtag == "FINISH") {
		// Si c'est le remplacement du tag de fermeture
		// on renseigne la propriété "finish"
			$htmlTags[$xmlcurtag]["finish"] = $data;
		}
	}
	
	// Fonction pouvant servir à retourner une chaine identique
	function identity($str) {
		return $str;
	}
	
	// Récupère les données BBCode a partir d'un fichier XML dont
	// le chemin est donné en paramètre
	function getBBTags($fil) {
		// Crée le parser XML
		$xmlparser = xml_parser_create("UTF-8");
		// Attribue les 'handler' qui vont parser le fichier XML
		xml_set_element_handler($xmlparser, "startTag", "endTag");
		xml_set_character_data_handler($xmlparser, "cdataTag");
		// Ouvre le fichier XML
		if (!($fp = fopen($fil, "r"))) {
			die("Impossible d'ouvrir le fichier XML");
		}
		// Parse le fichier XML
		while ($data = fread($fp, 4096)) {
			if (!xml_parse($xmlparser, $data, feof($fp))) {
				die(sprintf("erreur XML : %s &agrave; la ligne %d",
					xml_error_string(xml_get_error_code($xmlparser)),
					xml_get_current_line_number($xmlparser)));
			}
		}
		// Efface le parser et ferme le fichier
		xml_parser_free($xmlparser);
		fclose($fp);
	}

	// Fonction qui va attribuer un identifiant unique
	// a chaque tag qui en a besoin
	function parseBBTags (&$str) {
		global $bbTags;
		global $htmlTags;
		// Mes variables
		// $progress contient la chaine reconsitutée.
		$progress = Array();
		// Result contient le resultat de la recherche par regexp PERL
		$result = Array();
		// Stack est un pile contenant les tags ouverts
		$stack = Array();
		// On génère la chaine de caractère a rechercher
		// On concatène les valeurs du tableau bbTags
		// avec un operateur "ou" : |
		$srch = "";
		for($i=0 ; $i<count($bbTags) ; $i++) {
			$srch .= preg_quote($bbTags[$i]) . "|";
		}
		// On enlève le dernier |
		$srch = substr($srch,0,-1);
		// je rajoute les crochets à ma recherche, et le texte qui suit jusqu'au prochain tag
		$srchall = "\[(/)?(" . $srch . ")(=(?:.*?))?\](.*?)(?=(?:\[(/)?(" . $srch . ")(=(?:.*?))?\])|$)";
		// Je récupère ma chaine en "morceaux" de la regexp
		preg_match_all("#" . $srchall . "#is",$str,$result);
		// Je récupère le texte du début de la chaine jusqu'au premier tag
		// et j'initialise la chaine qui va être retournée : $ret
		$begin = Array();
		if (preg_match("#^(.*?)(?=(?:\[(/)?(" . $srch . ")(=(?:.*?))?\])|$)#is",$str,$begin)) {
			$ret = $begin[1];
		} else {
			$ret = "";
		}
		// Je boucle sur mes resultats
		// Chaque indice de $result contient une partie du résultat
		//  0 : colonne contenant les exepressions trouvées
		//  1 : Barre de fermeture (si elle existe)
		//  2 : Nom du tag (b, u, etc...)
		//  3 : Paramètre du tag (avec un '=' au debut)
		//  4 : Texte qui suit le tag (jusqu'au prochain)
		$norender = 0;
		for ($i=0 ; $i<count($result[1]) ; $i++) {
			// Je crée mon tableau associatif avec les données du tag courant
			$curTag = Array("tag"=>$result[2][$i],
							"close"=>($result[1][$i] == "/"),
							"param"=>$result[3][$i],
							"after"=>$result[4][$i]);
			// Si c'est une fermeture de tag
			if ($curTag["close"]) {
				// Je recherche les tags ouverts dans ma pile en 
				// partant du dernier tag ouvert puis en remontant la pile
				for ($k=count($stack)-1 ; $k>=0 ; $k--) {
					$lastTag = $stack[$k];
					// Si le tag ouvert est le même que celui que je ferme,
					// J'attribue a mon tag de fermeture le meme id
					// que le tag ouvrant et j'arrete la boucle
					if ($lastTag["tag"] == $curTag["tag"]) {
						// Si le tag est ouvert, je regarde s'il peut être fermé
						// Si c'est le cas, je donne l'identifiant du tag d'ouverture
						// au tag de fermeture
						if ($lastTag["canclose"]) {
							$curTag["uid"] = $lastTag["uid"];
						}
						// Je supprime le tag d'ouverture de la pile
						array_splice($stack,$k,1);
						// Si c'était un tag qui epêmchait le parsage des BBCode
						// de son contenu, je diminue le nombre de tag de "non-rendu".
						if ($htmlTags[$curTag["tag"]]["render"] == "no") {
							$norender--;
						}
						// Si le tag est trouvé, inutile de continuer la boucle
						break;
					
					// Sinon, c'est un chevauchement de tag, le tag courant
					// ne pourra pas être fermé.
					} else {
						$stack[$k]["canclose"] = false;
					}
				}
			
			// Si c'est un tag d'ouverture
			} else {
				// S'il a besoin d'être ferme, je lui crée un identifiant unique
				// de longueur 10 (ca devrait suffire)
				if ($htmlTags[$curTag["tag"]]["close"] != "no") {
					// Je génère un ID aléatoire et je l'attribue
					// au tag d'ouverture
					$uid = md5(mt_rand());
					$uid = substr($uid, 0, 10);
					$curTag["uid"] = $uid;
					// Si on est dans un tag de "non-rendu", le tag
					// ne peut être fermé (il ne sera donc pas interprété)
					$curTag["canclose"] = ($norender == 0);
					// Je rajoute le tag dans ma pile
					array_push($stack,$curTag);
					// Si c'est un tag de "non-rendu" que l'on ouvre
					// j'augmente le nombre de tag de "non-rendu" ouverts
					if ($htmlTags[$curTag["tag"]]["render"] == "no") {
						$norender++;
					}
				}
			}
			// Quoi qu'il arrive, je rajoute mon tag a la progression
			array_push($progress,$curTag);
		}
		// Je reconstruit ma chaîne à partir de ma progression
		for ($i=0 ; $i<count($progress) ; $i++) {
			$ret .= "[";
			$ret .= $progress[$i]["close"] ? "/" : "";
			$ret .= $progress[$i]["tag"];
			$ret .= $progress[$i]["param"];
			$ret .= isset($progress[$i]["uid"]) ? ":" . $progress[$i]["uid"] : "";
			$ret .= "]";
			$ret .= $progress[$i]["after"];
		}
		
		// Je retourne la chaine ainsi obtenue
		return $ret;
	}
	
	// Fonction qui transforme les BBCode en HTML
	function renderBBCode (&$str) {
		// Je rend les tableaux de paramètres disponibles
		// à ma fonction
		global $bbTags;
		global $htmlTags;

		// Je parse les BBCode pour leur attribuer un id unique
		$tmp = parseBBTags($str);
		// Pour chaque tag BBCode de mes aramètres HTML
		reset($htmlTags);
		while (list ($key, $val) = each ($htmlTags)) {
			// Je récupère le nom et les propriétés de mon tag
			$curtagname = $key;
			$curtagprops = $val;
			// Si c'est un tag avec paramètres, je dois enlever
			// le '-param' qui est à la fin.
			if ($curtagprops["param"] == "yes") {
				$curtagname = substr($curtagname,0,-6);
			}
			// Il s'agit maintenant de générer l'expression régulière ... :D
			//  - before : regexp pour un contenu éventuel AVANT le tag
			//  - tagsrch : regexp pour le tag lui-même
			//  - contsrch : regexp pour le contenu du tag
			//  - endsrch : regexp pour le tag de fermeture
			//  - after : regexp pour un contenu eventuel APRES le tag de fermeture
			$before = "";
			$tagsrch = "\[" . preg_quote($curtagname);
			$contsrch = "(.*?)";
			$endsrch = "";
			$after = "";
			
			// Idinces des regexp
			//  - idind : Indice dans la regexp de l'ID du tag (utile pour les références arrières)
			//  - contind : Indice du contenu du tag
			//  - paramind : Indice du paramètre du tag (s'il en faut un)
			$idind = 0;
			$contind = 1;
			$paramind = 0;
			
			// Chaine de remplacement
			//  - beforerepl : Debut de la chaine de remplacement
			//  - repl : Remplacement
			//  - afterrepl : Fin de la chaine de remplacement
			$beforerepl = "";
			$repl = "";
			$afterrepl = "";
			
			// Il s'agit de donner les bonnes valeurs aux indices et regexp maintenant
			// SI le tag prend un paramètre
			if ($curtagprops["param"] == "yes") {
				// On rajoute le paramètre à la regexp du tag d'ouverture
				$tagsrch .= "(?:=(.*?))";
				// Le parametre a un indice
				$paramind++;
				// Du coup, l'ID et le contenu sont un cran plus loin
				$idind++;
				$contind++;
			}
			// Si le tag doit être fermé, il a un ID
			if($curtagprops["close"] != "no") {
				// On rajoute l'ID à la regexp du tag d'ouverture
				$tagsrch .= "(:[0-9a-z]{10})";
				// Du coup, l'ID a un indice
				$idind++;
				// Et le contenu est encore décalé d'un cran
				$contind++;
				// Le tag de fermeture doit être recherché avec le meme ID
				// que celui d'ouverture
				$endsrch = "\[/" . preg_quote($curtagname) . "\\" . $idind . "\]";
			} else {
				// Si le tag n'a pas de fermeture, on ne peut pas trouver de "contenu"
				$contsrch = "";
			}
			// On rajoute le crochet de fin du tag d'ouverture
			$tagsrch .= "\]";
			// Si le tag doit avoir un parent, on s'assure qu'il est dans ce parent
			if ($partag = $curtagprops["parent"]) {
				// On cherche le tag parent d'ouverture AVANT le tag
				$before = "(\[" . preg_quote($partag) . "(?:=.*?)?(:[0-9a-z]{10})\].*?)";
				// Et on cherche la tag prent de fermeture APRES le tag
				$after = "(.*?\[/" . preg_quote($partag) . "\\2\])";
				// Du coup, le contenu est décalé de 2 cran : tag parent d'ouverture
				// + ID du tag parent d'ouverture
				$contind += 2;
				// Pareil pour l'ID
				$paramind += 2;
				$idind +=2;
				// On remet les tags parent avant et aprés dans la chaine de remplacement
				$beforerepl = "$1";
				$afterrepl = "$" . ($contind+1);
			}
			// Maintenant que tous les indices de position sont bons, on peut chercher
			// le tag de fermeture (si besoin est)
			if($curtagprops["close"] != "no") {
				// Le tag de fermeture doit être recherché avec le meme ID
				// que celui d'ouverture
				$endsrch = "\[/" . preg_quote($curtagname) . "\\" . $idind . "\]";
			}
			// On remplace les valeurs {PARAM} et {VALUE} qui peuvent apparaître
			// dans le HTML de remplacement. {PARAM} ets remplacé par le paramètre
			// du tag BBCode, et {VALUE} par son contenu
			// On en profite pour commencer la chaine de remplacement par le HTML de debut
			if (!isset($curtagprops["begin"])) $curtagprops["begin"] = '';
			$repl = "'" . $curtagprops["begin"] . "'";
			$repl = str_replace("{VALUE}", "$" . $contind,$repl);
			if ($paramind > 0) {
				$repl = str_replace("{PARAM}","$" . $paramind,$repl);
			} else {
				$repl = str_replace("{PARAM}","",$repl);
			}
			
			// Si on veut garder le contenu entre le HTML de début et le HTML de fin
			if ($curtagprops["keep"] != "no") {
				// Si le contenu doit être parsé par une fonction, on y fait appel
				if ($curtagprops["function"]) {
					$repl .= " . " . $curtagprops["function"] . "(\"$" . $contind . "\")";
				
				// Sinon, on affiche tout simplement le contenu (grace a son indice
				// trouvé plus haut)
				} else {
					$repl .= " . '$" . $contind . "'";
				}
			}
			// On finit la chaine de remplacement par le HTML de fin
			if (!isset($curtagprops["finish"])) $curtagprops["finish"] = '';
			$repl .= " . '" . $curtagprops["finish"] . "'";

			// On assemble la chaine de remplacement
			$repl = "'" . $beforerepl . "' . " . $repl . " . '" . $afterrepl . "'";

			// On assemble la regexp
			$srch = $before . $tagsrch . $contsrch . $endsrch . $after;
			
// Affichage de debug, affiche la regexp et le pattern de remplacement
// si la regexp n'est pas trouvée
//			if (!preg_match("#" . $srch . "#isS", $tmp)) {
//				echo $srch . " => " . htmlspecialchars($repl) . "<br />\n";
//			}
			// A cause de l'imbrication éventuelle des tags, on effectue
			// le remplacement jusqu'à ce qu'il n'y ai plus de tag à remplacer.
			while (preg_match("#" . $srch . "#isS",$tmp)) {
				// Le stripslashes élimine les quelques antislah qui ont pu se glisser
				// à cause du preg_quote.
//				$tmp = stripslashes(preg_replace("#" . $srch . "#isSe" . $options,$repl,$tmp));
				$tmp = stripslashes(preg_replace("#" . $srch . "#isSe" ,$repl,$tmp));
			}
		}
		
		// Si jamais il reste des tags avec id qui n'ont pas été remplacés
		// on enlève l'id. Le pricipe de recherche est le même que pour parseBBTags
		$srch = "";
		for($i=0 ; $i<count($bbTags) ; $i++) {
			$srch .= preg_quote($bbTags[$i]) . "|";
		}
		$srch = substr($srch,0,-1);
		$srch = "(\[(?:/)?(?:" . $srch . ")(?:=(?:.*?))?)(?::[0-9a-z]{10})(\])";
		$tmp = preg_replace("#" . $srch . "#i","$1$2",$tmp);
		// Je retourne la chaine obtenue
		return $tmp;
	}
	
	// Cette fonction remplace les URLs et emails par des liens
	// puis parse les BBCode et enfin remplace les retour chariot
	// par des <br />
	function render (&$str) {
		return stripslashes(nl2br(renderBBCode(renderLinks($str))));
	}
	
?>
