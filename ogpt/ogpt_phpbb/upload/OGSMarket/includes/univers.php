<?php
/***************************************************************************
*	filename	: 	univers.php
*	desc.		:
*	Author		:	ericalens 
*	created		: 	05/06/2006
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

class cUniverses {

	var $Universes=false;
	//Nombre d'univers dans la base de donnée
	function count() {
		global $db;

		$sql="SELECT count(*) FROM ".TABLE_UNIVERS;

		$result=$db->sql_query($sql);

		if ( list($rowcount) = $db->sql_fetch_row( $result ) ) return $rowcount;

		return 0;
	}	

	//Ajoute un nouveau univers et renvoie un tableau sur ce nouvel univers
	function insert_new( $url, $name ) {
		global $db;

		//manque des info là!
		if($name=="" || $url=="") return "Il manque des informations !";

		// L'univer existe.
		$sql="SELECT COUNT(*) FROM ".TABLE_UNIVERS." WHERE name like '".mysql_real_escape_string($name)."' OR (url like '".mysql_real_escape_string($url)."' AND url != '')";
		$db->sql_query($sql);
		list($nb)=$db->sql_fetch_row();
		if ($nb != 0) return "Cet univer existe déjà";

		$sql=	 " INSERT INTO ".TABLE_UNIVERS." "
			." (`id`,`url`,`name`)"
			." VALUES(null,'".mysql_real_escape_string($url)."','".mysql_real_escape_string($name)."')";

		$result=$db->sql_query($sql);	

		$newvalues = Array();
		$newvalues["id"] = $db->sql_insertid();
		$newvalues["url"] = $url;
		$newvalues["name"] = $name;


		return "Le nouvel univert a bien été créé";

	}
	
	//Tableau de tout les univers dans la base de donnée
	function universes_array() {
	  	if ($this->Universes) return $this->Universes;
		global $db;
		
		$sql	=	" SELECT * FROM ".TABLE_UNIVERS." order by name ASC";
		$result	=	$db->sql_query( $sql );
		
		$this->Universes=Array();
		
		while (	list( $id, $url, $name) = $db->sql_fetch_row( $result ) ) {
		
			$uni = Array();
			
			$uni["id"] = $id;
			$uni["url"] = $url;
			$uni["name"] = $name;

			$this->Universes[] = $uni;
		}

		return $this->Universes;
	}

	// Récupération d'un univers à partir de son ID sous forme de tableau
	// renvoie false si pas trouvé
	function get_universe($universeid) {

		global $db;
		$sql =   "SELECT id,url,name"
			." FROM ".TABLE_UNIVERS
			." WHERE id=".intval($universeid);

		$result = $db->sql_query( $sql );

		if ( list($id,$url,$name) = $db->sql_fetch_row( $result)) {
			$uni=Array();

			$uni["id"] = $id;
			$uni["url"] = $url;
			$uni["name"] = $name;

			return $uni;			
		}
		return false;
	}

	// Effacement d'un univers a partir de son ID
	function delete_universe($universeid) {
		global $db;
		$sql = "DELETE FROM ".TABLE_UNIVERS." WHERE id=".intval($universeid);
		$db->sql_query($sql);

		return "L'univers a bien été delleté";
	}
	
	// Retourne un univers au format Xml
	function get_universe_xml($universe)
	{
			$univers_xml = "\n\t<universe>";
			$univers_xml .= "\n\t\t<id>". $universe["id"]."</id>";
			$univers_xml .= "\n\t\t<url>". $universe["url"]."</url>";
			$univers_xml .= "\n\t\t<name>". $universe["name"]."</name>";
			$univers_xml .= "\n\t</universe>";
			return $univers_xml;
	}
	
}

$Universes=new cUniverses();
?>
