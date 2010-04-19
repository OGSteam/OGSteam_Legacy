<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

if (!defined('IN_SPYOGAME')) exit;

class Mysql_Exception extends Exception {
	public function __construct($message, $query = '') {
		if (!empty($query)) $message .= "\n".'Query: "'.$query.'"';
		parent::__construct($message);
		$stack = $this->getTrace();
		$this->line = $stack[0]['line'];
		$this->file = $stack[0]['file'];
	}
}


class Mysql {
	public $error_dir = '.';
	public $error_reporting = true;
	public $error_log = true;
	public $error_backtrace = false;

	protected $link = false;
	protected $query;
	
	/**
	 * Connexion a la DB
	 *
	 * @param string $host
	 * @param string $user
	 * @param string $pass
	 * @param string $db
	 * @param bool $link = true
	 */
	public function connect($host, $user, $pass, $db, $link = true) {
			if (!$this->link = @mysql_connect($host, $user, $pass, $link)) $this->error(new Mysql_Exception(mysql_error()));
			if (!@mysql_select_db($db, $this->link)) $this->error(new Mysql_Exception(mysql_error()));
	}
	
	/**
	 * Change la DB de la connexion courante
	 *
	 * @param unknown_type $db
	 */
	public function change_db($db) {
		if (!@mysql_select_db($db, $this->link)) $this->error(new Mysql_Exception(mysql_error()));
	}
	
	/**
	 * Execute la requ�te $query et retourne le r�sultat
	 *
	 * @param string $query
	 * @return Ressource MySQL
	 */
	public function query($query) {
		if (!$this->query = @mysql_query($query)) $this->error(new Mysql_Exception(mysql_error(), $query));
		return $this->query;
	}
	
	/**
	 * Execute la requete $query et retourne true si elle contient au moins un enregistrement
	 *
	 * @param unknown_type $query
	 * @return unknown
	 */
	public function check($query = null) {
		if ($query !== null) $this->query($query);
		return mysql_num_rows($this->query) > 0;
	}
	
	/**
	 * Retourne le nombre d'enregistrements de la requete $query
	 *
	 * @param unknown_type $query
	 * @return unknown
	 */
	public function num($query = null) {
		if ($query !== null) $this->query($query);
		return mysql_num_rows($this->query);
	}
	
	/**
	 * Associe les resultats de la requete $query dans un tableau multidimentionnel. Si vous ne sp�cifiez par de requete, la ressource de la derniere execute sera utilisee
	 * Tableau dans cette forme : array([ligne 1] => array('champ'=>'valeur'...), [ligne2] => array(..)...)
	 *
	 * @param unknown_type $query
	 * @return unknown
	 */
	public function assoc($query = null) {
		if ($query === null) $query = $this->query;
		else $query = $this->query($query);
		$rows = array();
		$i = 0;
		while ($data = mysql_fetch_assoc($query)) {
			foreach($data as $key => $value) {
				$rows[$i][$key] = $value;
			}
			$i ++;
		}
		return $rows;
	}
	
	/**
	 * Retourne l'ID de la derniere requete executee
	 *
	 * @return unknown
	 */
	public function insert_id() {
		return mysql_insert_id($this->link);
	}

	/**
	 * Retourne le nombre de champs affect�s par la derniere requete
	 *
	 * @return unknown
	 */
	public function affected_rows() {
		return mysql_affected_rows($this->link);
	}
	
	/**
	 * Fonction privée pour les erreur MySQL, avec backtrace, log...
	 *
	 */
	protected function error(Mysql_Exception $e) {
		global $call;
		
		if ($call instanceof CallbackHandler) {
			
			throw $e;
		}
		
		if ($this->error_reporting) {
			$trace = $e->getTrace();
			$traceString = $e->getTraceAsString();
			
			echo 'MySQL Exception "'.$e->getMessage()."\"\n".'File '.$e->getFile().'('.$e->getLine().")\n";
			if ($trace[0]['function'] == 'connect') {
				echo preg_replace('!connect\(.*\)!Usi', 'connect( hidden )', $traceString);
			} else {
				echo $traceString;
			}
		}
		exit;
	}
	
}


?>