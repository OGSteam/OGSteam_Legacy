<?php 
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

/**
 * Gestion de templates basiques
 *
 */
class tpl {
	
	var $vars = array();
	var $accents = array();
	var $html_codes = array();
	var $gzip = false;
	var $dir = '';
	
	function tpl($dir) {
		$this->accents = array('é', 'è', 'ê', 'à', 'ù'/*, '&'*/);
		$this->html_codes = array('&eacute;', '&egrave;', '&ecirc;', '&agrave;', '&ugrave;'/*, '&amp;'*/);
		
		$this->dir = $dir;
	}
	
	/**
	 * Assigner une variable
	 *
	 * @param mixed[string/array] $key
	 * @param string $value
	 */
	function assign($key, $value = null) {
		if (is_array($key)) {
			foreach ($key as $key => $v) {
				$this->vars[$key] = $v;
			}
		} elseif ($key != '__file__') {
			$this->vars[$key] = $value;
		} else {
			trigger_error('Can\'t use variable $__file__ in templates', E_USER_NOTICE);
		}
	}
	
	function assignRef($key, &$value) {
		if ($key != '__file__') {
			$this->vars[$key] = &$value;
		} else {
			trigger_error('Can\'t use variable $__file__ in templates', E_USER_NOTICE);
		}
	}
	
	/**
	 * Suppression d'une variable
	 *
	 * @param string $key
	 */
	function del($key) {
		if (isset($this->vars[$key])) unset($this->var[$key]);
	}
	
	/**
	 * Recuperation de la valeur d'une variable
	 *
	 * @param string $key
	 * @return mixed
	 */
	function get($key) {
		if (isset($this->vars[$key])) return $this->vars[$key];
	}
	
	/**
	 * Activation de la compression Gzip
	 *
	 * @param string $x
	 */
	function gzip($compress) {
		$this->gzip = ($compress === true ? true : false);
	}
	
	/**
	 * Affichage d'un fichier template
	 *
	 * @param string $__file__
	 */
	function display($__file__) {
		if (file_exists($this->dir.$__file__.'.tpl')) {
			foreach ($this->vars as $key => $value) {
				${$key} = $value;
			}
			$tpl = $this;
			
			ob_start();
			require_once($this->dir.$__file__.'.tpl');
			
			$output = ob_get_clean();
			$output = str_replace($this->accents, $this->html_codes, $output);
			
			if ($this->gzip) {
				ob_start('ob_gzhandler');
				echo $output;
				ob_end_flush();
			} else {
				echo $output;
			}
		} else {
			trigger_error('Missing template file "'.$this->dir.$__file__.'.tpl"', E_USER_WARNING);
		}
	}
	
}

?>