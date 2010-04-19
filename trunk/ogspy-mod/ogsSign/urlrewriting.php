<?php
/**
* urlrewriting.php classe qui permet l'url rewriting sans le mod_rewrite d'apache
* @package OGSign
* @author NeoZer0
* @link http://www.siteduzero.com/forum-83-17384-171346.html#r171346
*/


// Désactive le rapport d'erreurs
// (si on passe vraiment dans une 404, un ereg() n'apprécie pas...)
error_reporting(0);

/**
 *
 */
class rewriting{

	function rewriting(){
		$this->fichier_conf = '.rewriterules';
		$this->page_erreur = '404.php';
		$this->url = substr_replace($_SERVER['REQUEST_URI'],'',0,1);
		$this->get_rewriting_rules();
		include($this->page_erreur);
	}

	function get_rewriting_rules(){
		$open = fopen($this->fichier_conf,"r");
		while(!feof($open)){
			$rules = fgets($open);
			$this->get_masque($rules);
		}
	}

	function redirection(){
		$this->url_finale = $this->masque[1];
		//je change ereg() par preg_match() car il y a un problème de masque sinon.
		if(preg_match("/".$this->masque[0]."/",$this->url,$ereg)){
			$i =0;
			$count = count($ereg);
			while($i <= $count -1){
				$this->url_finale = str_replace("$".$i,$ereg[$i],$this->url_finale);
				$i++;
			}
			$this->affichage();
		}
	}

	function get_masque($rules){
		$this->masque = explode('|',$rules);
		$this->redirection();
	}

	function affichage(){
		$parse_url = parse_url($this->url_finale);
		//chose bizarre de parse_url????
		if(isset($parse_url['query'])){
			$position = strrpos('_',$parse_url['query']);
			$varget = substr($parse_url['query'],-$position,strlen($parse_url['query']) -2);
			$varget = explode("&",$varget);
			foreach($varget as $varval){
				$varval = explode("=",$varval);
				$_GET["$varval[0]"] = $varval[1];
			}
		}
		else{
			$position = strrpos('_',$parse_url['path']);
			$parse_url['path'] = substr($parse_url['path'],-$position,strlen($parse_url['path']) -2);
		}
		header("HTTP/1.0 200 OK");
		include($parse_url["path"]);
		exit;
	}

} // fin de la classe

$rewrite = new rewriting();

?>
