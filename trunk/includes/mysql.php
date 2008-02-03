<?php
/** $Id$ **/
/**
* Classe d'accés à la BDD MySQL
* @package OGSpy
* @subpackage main
* @author Kyser
* @created 15/11/2005
* @copyright Copyright &copy; 2007, http://www.ogsteam.fr/
* @version 3.04b ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

/**
* Affichage d'une erreur SQL et sortie du script
* @param string $query Requête SQL fautive
*/
function DieSQLError($query){
	echo "<table align=center border=1>\n";
	echo "<tr><td class='c' colspan='3'>Database MySQL Error</td></tr>\n";
	echo "<tr><th colspan='3'>ErrNo:".mysql_errno().":  ".mysql_error()."</th></tr>\n";
	echo "<tr><th colspan='3'><u>Query:</u><br>".$query."</th></tr>\n";
	if (MODE_DEBUG) {
		$i=0;
		foreach (debug_backtrace() as $v) {
			echo "<tr><th width='50' align='center' rowspan='".(isset($v['args']) ? sizeof($v['args'])+1 : "")."'>[".$i."]</th>";
			echo "<th colspan='2'>";
			echo "file => ".$v['file']."<br>";
			echo "ligne => ".$v['line']."<br>";
			echo "fonction => ".$v['function'];
			echo "</th></tr>\n";
			$j=0;
			if (isset($v['args'])) {
				foreach ($v['args'] as $arg) {
					echo "<tr><th align='center'>[".$j."]</td><td>".$arg."</th></tr>\n";
					$j++;
				}
			}
			$i++;
		}
	}

	echo "</table>\n";

	log_("mysql_error", array($query, mysql_errno(), mysql_error(), debug_backtrace()));
	die();
}

/**
* Classe d'accès MySQL
*/
class sql_db {

	var $db_connect_id;
	var $result;
/**
* Constructeur
*/
	function sql_db($sqlserver, $sqluser, $sqlpassword, $database) {
		global $sql_timing;
		$sql_start = benchmark();

		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;

		$this->db_connect_id = @mysql_connect($this->server, $this->user, $this->password);

		if($this->db_connect_id) {
			if($database != "") {
				$this->dbname = $database;
				$dbselect = @mysql_select_db($this->dbname);
				if(!$dbselect) {
					@mysql_close($this->db_connect_id);
					$this->db_connect_id = $dbselect;
				}
			}
			return $this->db_connect_id;
		}
		else {
			return false;
		}

		$sql_timing += benchmark() - $sql_start;
	}

/**
* Fermeture de la BDD
*/
	function sql_close() {
		$result = @mysql_close($this->db_connect_id);
	}
/**
* Requête SQL
*/
	function sql_query($query = "", $Auth_dieSQLError = true, $save = true) {
		global $sql_timing, $server_config;
		
		$sql_start = benchmark();

		if ($Auth_dieSQLError) {
			$this->result = @mysql_query($query, $this->db_connect_id) or dieSQLError($query);
		}
		else {
			$this->result = @mysql_query($query, $this->db_connect_id);
		}

		if ($save) {
			$type = substr($query, 0, 6);
			if ($server_config["debug_log"] == "1") {
				if (!preg_match("/^select/i", $query) && !preg_match("/^show table status/i", $query)) {
					$fichier = "sql_".date("ymd").".sql";
					$date = date("d/m/Y H:i:s");
					$ligne = "/* ".$date." - ".$_SERVER["REMOTE_ADDR"]." */ ".$query.";";
					write_file(PATH_LOG_TODAY.$fichier, "a", $ligne);
				}
			}
		}

		$sql_timing += benchmark() - $sql_start;

		return $this->result;
	}
/**
* Récupération d'une ligne d'enregistrement
*/
	function sql_fetch_row($query_id = 0) {
		if(!$query_id) {
			$query_id = $this->result;
		}
		if($query_id) {
			return @mysql_fetch_row($query_id);
		}
		else {
			return false;
		}
	}
/**
* Récupération d'un tableau associatif d'une ligne d'enregistrement
*/
	function sql_fetch_assoc($query_id = 0) {
		if(!$query_id) {
			$query_id = $this->result;
		}
		if($query_id) {
			return @mysql_fetch_assoc($query_id);
		}
		else {
			return false;
		}
	}
/**
* Nombre de lignes concernées par la dernière requête
*/
	function sql_numrows($query_id = 0) {
		if(!$query_id) {
			$query_id = $this->result;
		}
		if($query_id) {
			$result = @mysql_num_rows($query_id);
			return $result;
		}
		else {
			return false;
		}
	}
/**
* Nombre de ligne affectés
*/
	function sql_affectedrows() {
		if($this->db_connect_id) {
			$result = @mysql_affected_rows($this->db_connect_id);
			return $result;
		}
		else {
			return false;
		}
	}
/**
* Identificateur unique de la dernière insertion SQL
*/
	function sql_insertid(){
		if($this->db_connect_id) {
			$result = @mysql_insert_id($this->db_connect_id);
			return $result;
		}
		else {
			return false;
		}
	}
/**
* Libération des ressources
*/
	function sql_free_result($query_id = 0) {
		mysql_free_result($query_id);
	}
/**
* renvoie sous forme d'un tableau de la dernière erreur SQL
*/
	function sql_error($query_id = 0) {
		$result["message"] = @mysql_error($this->db_connect_id);
		$result["code"] = @mysql_errno($this->db_connect_id);

		return $result;
	}
}
?>
