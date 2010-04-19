<?php
/***************************************************************************
*	filename	: 	trade.php
*	desc.		:
*	Author		:	ericalens 
*	created		: 	06/06/2006
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

//Classe gérant les différents trades
class cTrades {

	//Nombre de Trades dans la base de donnée pour un univers donné
	function count($universeid,$include_expired=false) {
		global $db;

		$sql="SELECT count(*) FROM ".TABLE_TRADE." where universid=".intval($universeid);
		if (!$include_expired) $sql .=" AND expiration_date>".time();
		$result=$db->sql_query($sql);

		if ( list($rowcount) = $db->sql_fetch_row( $result ) ) return $rowcount;

		return 0;
	}	

	function last($universeid) {
		global $db;
		$sql="select t.*,u.name as username from ".TABLE_TRADE." t LEFT JOIN ".TABLE_USER." u ON u.id=t.traderid "
			." WHERE t.universid=".intval($universeid)." AND expiration_date>".time()
			." ORDER BY t.creation_date desc limit 1";
		$db->sql_query($sql);
		return $db->sql_fetch_assoc();
	}
	
	function pos_new($tradeid,$userid){
		global $db;
		$now=time();
		$out="Effectué";
		$sql = "Update ".TABLE_TRADE." "
		." set `pos_user`=".$userid.", `pos_date`=".$now." where `id`=".$tradeid;
		
		if(!($result=$db->sql_query($sql))) {
			$out = "Erreur";
		}
		return $out;
	}
	
	function unpos_new($tradeid){
		global $db;
		$out="Effectué";
		$sql = "Update ".TABLE_TRADE." "
		." set `pos_user`=0 , `pos_date`=NULL where `id`=".$tradeid;
		
		if(!($result=$db->sql_query($sql))) {
			$out = "Erreur";
		}
		return $out;
	}


	//Ajoute un nouveau trade renvoie un tableau sur ce nouvel univers
	function insert_new( $traderid,$universid,$offer_metal,$offer_crystal,$offer_deuterium,$want_metal,$want_crystal,$want_deuterium,$secs_duration,$note,$deliver_g1,$deliver_g2,$deliver_g3,$deliver_g4,$deliver_g5,$deliver_g6,$deliver_g7,$deliver_g8,$deliver_g9,$refunding_g1,$refunding_g2,$refunding_g3,$refunding_g4,$refunding_g5,$refunding_g6,$refunding_g7,$refunding_g8,$refunding_g9 ) {
		global $db;
		$now=time();
		$expiration=$now+intval($secs_duration);
		$sql=	 " INSERT INTO ".TABLE_TRADE." "
			." (`id`,`traderid`,`universid`,`offer_metal`,`offer_crystal`,`offer_deuterium`,`want_metal`,`want_crystal`,`want_deuterium`,`creation_date`,`expiration_date`,`note`,`deliver_g1`,`deliver_g2`,`deliver_g3`,`deliver_g4`,`deliver_g5`,`deliver_g6`,`deliver_g7`,`deliver_g8`,`deliver_g9`,`refunding_g1`,`refunding_g2`,`refunding_g3`,`refunding_g4`,`refunding_g5`,`refunding_g6`,`refunding_g7`,`refunding_g8`,`refunding_g9`)"
			." VALUES(null,".intval($traderid).",".intval($universid).",".intval($offer_metal).",".intval($offer_crystal).",".intval($offer_deuterium).",".intval($want_metal).",".intval($want_crystal).",".intval($want_deuterium).",$now,$expiration,'".mysql_escape_string($note)."','".$deliver_g1."','".$deliver_g2."','".$deliver_g3."','".$deliver_g4."','".$deliver_g5."','".$deliver_g6."','".$deliver_g7."','".$deliver_g8."','".$deliver_g9."','".$refunding_g1."','".$refunding_g2."','".$refunding_g3."','".$refunding_g4."','".$refunding_g5."','".$refunding_g6."','".$refunding_g7."','".$refunding_g8."','".$refunding_g9."')";

		$result=$db->sql_query($sql);	

		$newvalues = Array();
		$newvalues["id"] = $db->sql_insertid();
		$newvalues["traderid"] = $traderid;
		$newvalues["universid"] = $universid;
		$newvalues["offer_metal"] = $offer_metal;
		$newvalues["offer_crystal"] = $offer_crystal;
		$newvalues["offer_deuterium"] = $offer_deuterium;
		$newvalues["want_metal"] = $want_metal;
		$newvalues["want_crystal"] = $want_crystal;
		$newvalues["want_deuterium"] = $want_deuterium;
		$newvalues["creation_date"] = $now;
		$newvalues["expiration_date"] = $expiration;
		$newvalues["note"]= $note;
		return $newvalues;
	}
	
	//Mettre a jour une trade renvoie un tableau sur ce nouvel univers
	function upd_trade( $id,$traderid,$universid,$offer_metal,$offer_crystal,$offer_deuterium,$want_metal,$want_crystal,$want_deuterium,$expiration_date,$note,$deliver_g1,$deliver_g2,$deliver_g3,$deliver_g4,$deliver_g5,$deliver_g6,$deliver_g7,$deliver_g8,$deliver_g9,$refunding_g1,$refunding_g2,$refunding_g3,$refunding_g4,$refunding_g5,$refunding_g6,$refunding_g7,$refunding_g8,$refunding_g9 ) {
		global $db;
			
		$sql=	 " UPDATE ".TABLE_TRADE." set "
			."`offer_metal`=".intval($offer_metal).",`offer_crystal`=".intval($offer_crystal).",`offer_deuterium`=".intval($offer_deuterium).","
			."`want_metal`=".intval($want_metal).",`want_crystal`=".intval($want_crystal).",`want_deuterium`=".intval($want_deuterium).","
			."`expiration_date`=".$expiration_date.",`note`='".mysql_escape_string($note)."',"
			."`deliver_g1`='".$deliver_g1."',`deliver_g2`='".$deliver_g2."',`deliver_g3`='".$deliver_g3."',`deliver_g4`='".$deliver_g4."',"
			."`deliver_g5`='".$deliver_g5."',`deliver_g6`='".$deliver_g6."',`deliver_g7`='".$deliver_g7."',`deliver_g8`='".$deliver_g8."',`deliver_g9`='".$deliver_g9."',"
			."`refunding_g1`='".$refunding_g1."',`refunding_g2`='".$refunding_g2."',`refunding_g3`='".$refunding_g3."',`refunding_g4`='".$refunding_g4."',"
			."`refunding_g5`='".$refunding_g5."',`refunding_g6`='".$refunding_g6."',`refunding_g7`='".$refunding_g7."',`refunding_g8`='".$refunding_g8."',`refunding_g9`='".$refunding_g9."'"
			." where `id`=".intval($id)." ";

		if (!$result=$db->sql_query($sql))return 0;
		else return 1;
		
	}
	//RŽactivation d'une offre
	function reactive_trade($id,$creation_date,$expiration_date){
		global $db;
		$sql= " UPDATE ".TABLE_TRADE." SET `creation_date`=".$creation_date.",`expiration_date`=".$expiration_date." WHERE id = ".intval($id);
		
		if (!$result=$db->sql_query($sql))return 0;
		else return 1;
	}
	
	//Tableau de trades d'un univers donné, eventuellement classés 
	function trades_array($universeid,$order="creation_date desc",$limit="LIMIT 30",$includeexpired=true) {
		global $db;
		
		$sql	=	" SELECT t.`id`,t.`traderid`,t.`universid`,t.`offer_metal`,t.`offer_crystal`,t.`offer_deuterium`,t.`want_metal`,t.`want_crystal`,t.`want_deuterium`,t.`creation_date`,t.`expiration_date`,t.`note`,u.`name` as username,t.`deliver_g1`,t.`deliver_g2`,t.`deliver_g3`,t.`deliver_g4`,t.`deliver_g5`,t.`deliver_g6`,t.`deliver_g7`,t.`deliver_g8`,t.`deliver_g9`,t.`refunding_g1`,t.`refunding_g2`,t.`refunding_g3`,t.`refunding_g4`,t.`refunding_g5`,t.`refunding_g6`,t.`refunding_g7`,t.`refunding_g8`,t.`refunding_g9`,t.`pos_user`,t.`pos_date` FROM ".TABLE_TRADE." t LEFT JOIN ".TABLE_USER." u ON u.id=t.traderid WHERE 1=1";
		if (!($universeid==null))
		{
		$sql .=" AND universid=".intval($universeid);
		}
		if ($includeexpired) {
			$sql .= " AND expiration_date>".time();
		}
		if ($order) {
			$sql .= " ORDER BY $order";
		}
		$sql .=" $limit";

		$result	=	$db->sql_query( $sql );
		
		$tradearray=Array();
		
		while (	list( $id,$traderid,$universid,$offer_metal,$offer_crystal,$offer_deuterium,$want_metal,$want_crystal,$want_deuterium,$creation_date,$expiration_date,$note,$username,$deliver_g1,$deliver_g2,$deliver_g3,$deliver_g4,$deliver_g5,$deliver_g6,$deliver_g7,$deliver_g8,$deliver_g9,$refunding_g1,$refunding_g2,$refunding_g3,$refunding_g4,$refunding_g5,$refunding_g6,$refunding_g7,$refunding_g8,$refunding_g9,$pos_user,$pos_date) = $db->sql_fetch_row( $result ) ) {
		
			$newvalues = Array();
			
			$newvalues["id"] = $id;
			$newvalues["traderid"] = $traderid;
			$newvalues["universid"] = $universid;
			$newvalues["offer_metal"] = $offer_metal;
			$newvalues["offer_crystal"] = $offer_crystal;
			$newvalues["offer_deuterium"] = $offer_deuterium;
			$newvalues["want_metal"] = $want_metal;
			$newvalues["want_crystal"] = $want_crystal;
			$newvalues["want_deuterium"] = $want_deuterium;
			$newvalues["creation_date"] = $creation_date;
			$newvalues["expiration_date"] = $expiration_date;
			$newvalues["note"]= $note;
			$newvalues["username"]= $username;
			$newvalues["deliver_g1"]= $deliver_g1;
			$newvalues["deliver_g2"]= $deliver_g2;
			$newvalues["deliver_g3"]= $deliver_g3;
			$newvalues["deliver_g4"]= $deliver_g4;
			$newvalues["deliver_g5"]= $deliver_g5;
			$newvalues["deliver_g6"]= $deliver_g6;
			$newvalues["deliver_g7"]= $deliver_g7;
			$newvalues["deliver_g8"]= $deliver_g8;
			$newvalues["deliver_g9"]= $deliver_g9;
			$newvalues["refunding_g1"]= $refunding_g1;
			$newvalues["refunding_g2"]= $refunding_g2;
			$newvalues["refunding_g3"]= $refunding_g3;
			$newvalues["refunding_g4"]= $refunding_g4;
			$newvalues["refunding_g5"]= $refunding_g5;
			$newvalues["refunding_g6"]= $refunding_g6;
			$newvalues["refunding_g7"]= $refunding_g7;
			$newvalues["refunding_g8"]= $refunding_g8;
			$newvalues["refunding_g9"]= $refunding_g9;
			$newvalues["pos_user"]= $pos_user;
			$newvalues["pos_date"]= $pos_date;

			$tradearray[] = $newvalues;
		}

		return $tradearray;
	}
	
	//Tableau de trades d'un membre donné, eventuellement classés 
	function tradesuser_array($id) {
		global $db;
		
		$sql	=	" SELECT t.`id`,t.`traderid`,t.`universid`,t.`offer_metal`,t.`offer_crystal`,t.`offer_deuterium`,t.`want_metal`,t.`want_crystal`,t.`want_deuterium`,t.`creation_date`,t.`expiration_date`,t.`note`,u.`name` as username,t.`deliver_g1`,t.`deliver_g2`,t.`deliver_g3`,t.`deliver_g4`,t.`deliver_g5`,t.`deliver_g6`,t.`deliver_g7`,t.`deliver_g8`,t.`deliver_g9`,t.`refunding_g1`,t.`refunding_g2`,t.`refunding_g3`,t.`refunding_g4`,t.`refunding_g5`,t.`refunding_g6`,t.`refunding_g7`,t.`refunding_g8`,t.`refunding_g9`,t.`pos_user`,t.`pos_date` FROM ".TABLE_TRADE." t LEFT JOIN ".TABLE_USER." u ON u.id=t.traderid WHERE 1=1";
		$sql .= " AND traderid = $id";
		$sql .= " ORDER BY expiration_date desc";

		$result	=	$db->sql_query( $sql );
		
		$tradearray=Array();
		
		while (	list( $id,$traderid,$universid,$offer_metal,$offer_crystal,$offer_deuterium,$want_metal,$want_crystal,$want_deuterium,$creation_date,$expiration_date,$note,$username,$deliver_g1,$deliver_g2,$deliver_g3,$deliver_g4,$deliver_g5,$deliver_g6,$deliver_g7,$deliver_g8,$deliver_g9,$refunding_g1,$refunding_g2,$refunding_g3,$refunding_g4,$refunding_g5,$refunding_g6,$refunding_g7,$refunding_g8,$refunding_g9,$pos_user,$pos_date) = $db->sql_fetch_row( $result ) ) {
		
			$newvalues = Array();
			
			$newvalues["id"] = $id;
			$newvalues["traderid"] = $traderid;
			$newvalues["universid"] = $universid;
			$newvalues["offer_metal"] = $offer_metal;
			$newvalues["offer_crystal"] = $offer_crystal;
			$newvalues["offer_deuterium"] = $offer_deuterium;
			$newvalues["want_metal"] = $want_metal;
			$newvalues["want_crystal"] = $want_crystal;
			$newvalues["want_deuterium"] = $want_deuterium;
			$newvalues["creation_date"] = $creation_date;
			$newvalues["expiration_date"] = $expiration_date;
			$newvalues["note"]= $note;
			$newvalues["username"]= $username;
			$newvalues["deliver_g1"]= $deliver_g1;
			$newvalues["deliver_g2"]= $deliver_g2;
			$newvalues["deliver_g3"]= $deliver_g3;
			$newvalues["deliver_g4"]= $deliver_g4;
			$newvalues["deliver_g5"]= $deliver_g5;
			$newvalues["deliver_g6"]= $deliver_g6;
			$newvalues["deliver_g7"]= $deliver_g7;
			$newvalues["deliver_g8"]= $deliver_g8;
			$newvalues["deliver_g9"]= $deliver_g9;
			$newvalues["refunding_g1"]= $refunding_g1;
			$newvalues["refunding_g2"]= $refunding_g2;
			$newvalues["refunding_g3"]= $refunding_g3;
			$newvalues["refunding_g4"]= $refunding_g4;
			$newvalues["refunding_g5"]= $refunding_g5;
			$newvalues["refunding_g6"]= $refunding_g6;
			$newvalues["refunding_g7"]= $refunding_g7;
			$newvalues["refunding_g8"]= $refunding_g8;
			$newvalues["refunding_g9"]= $refunding_g9;
			$newvalues["pos_user"]= $pos_user;
			$newvalues["pos_date"]= $pos_date;

			$tradearray[] = $newvalues;
		}

		return $tradearray;
	}
	
	// Affichage d'un trade sous forme de xml
	function get_trade_xml($trade) {
			$xmlTrade="";
			$xmlTrade = "\t<id>".$trade["id"]."</id>\n";
			$xmlTrade .= "\t<traderid>".$trade["traderid"]."</traderid>\n";
			$xmlTrade .= "\t<universid>".$trade["universid"]."</universid>\n";
			$xmlTrade .= "\t<offer_metal>".$trade["offer_metal"]."</offer_metal>\n";
			$xmlTrade .= "\t<offer_crystal>".$trade["offer_crystal"]."</offer_crystal>\n";
			$xmlTrade .= "\t<offer_deuterium>".$trade["offer_deuterium"]."</offer_deuterium>\n";
			$xmlTrade .= "\t<want_metal>".$trade["want_metal"]."</want_metal>\n";
			$xmlTrade .= "\t<want_crystal>".$trade["want_crystal"]."</want_crystal>\n";
			$xmlTrade .= "\t<want_deuterium>".$trade["want_deuterium"]."</want_deuterium>\n";
			$xmlTrade .= "\t<creation_date>".$trade["creation_date"]."</creation_date>\n";
			$xmlTrade .= "\t<expiration_date>".$trade["expiration_date"]."</expiration_date>\n";
			$xmlTrade .= "\t<note>".$trade["note"]."</note>\n";
			$xmlTrade .= "\t<username>".$trade["username"]."</username>\n";
			$xmlTrade .= "\t<deliver_g1>".$trade["deliver_g1"]."</deliver_g1>\n";
			$xmlTrade .= "\t<deliver_g2>".$trade["deliver_g2"]."</deliver_g2>\n";
			$xmlTrade .= "\t<deliver_g3>".$trade["deliver_g3"]."</deliver_g3>\n";
			$xmlTrade .= "\t<deliver_g4>".$trade["deliver_g4"]."</deliver_g4>\n";
			$xmlTrade .= "\t<deliver_g5>".$trade["deliver_g5"]."</deliver_g5>\n";
			$xmlTrade .= "\t<deliver_g6>".$trade["deliver_g6"]."</deliver_g6>\n";
			$xmlTrade .= "\t<deliver_g7>".$trade["deliver_g7"]."</deliver_g7>\n";
			$xmlTrade .= "\t<deliver_g8>".$trade["deliver_g8"]."</deliver_g8>\n";
			$xmlTrade .= "\t<deliver_g9>".$trade["deliver_g9"]."</deliver_g9>\n";
			$xmlTrade .= "\t<refunding_g1>".$trade["refunding_g1"]."</refunding_g1>\n";
			$xmlTrade .= "\t<refunding_g2>".$trade["refunding_g2"]."</refunding_g2>\n";
			$xmlTrade .= "\t<refunding_g3>".$trade["refunding_g3"]."</refunding_g3>\n";
			$xmlTrade .= "\t<refunding_g4>".$trade["refunding_g4"]."</refunding_g4>\n";
			$xmlTrade .= "\t<refunding_g5>".$trade["refunding_g5"]."</refunding_g5>\n";
			$xmlTrade .= "\t<refunding_g6>".$trade["refunding_g6"]."</refunding_g6>\n";
			$xmlTrade .= "\t<refunding_g7>".$trade["refunding_g7"]."</refunding_g7>\n";
			$xmlTrade .= "\t<refunding_g8>".$trade["refunding_g8"]."</refunding_g8>\n";
			$xmlTrade .= "\t<refunding_g9>".$trade["refunding_g9"]."</refunding_g9>\n";
			$xmlTrade .= "\t<pos_user>".$trade["pos_user"]."</pos_user>\n";
			$xmlTrade .= "\t<pos_date>".$trade["pos_date"]."</pos_date>\n";
			

			return $xmlTrade;			
	}

	// Affichage d'un trade sous format rss
	function get_trade_rss($trade,$universe) {
			$xmlTrade="";
			$xmlTrade = "\n<item>";
			$xmlTrade .= "\n\t<guid>"."http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?action=viewtrade&amp;tradeid=".$trade["id"]."</guid>";
			$xmlTrade .= "\n\t<title>Vends ".$trade["offer_metal"]."M/".$trade["offer_crystal"]."C/".$trade["offer_deuterium"]."D sur ".$universe["name"]." par ".$trade["username"]."</title>";
			$xmlTrade .= "\n\t<link>http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?action=viewtrade&amp;tradeid=".$trade["id"]."</link>";
			//$xmlTrade .= "\n\t<author>"..$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?action=viewtrade&amp;tradeid=".$trade["id"]."</author>";
			$xmlTrade .= "\n\t<description>".utf8_encode("Dans ".$universe["name"].", ".$trade["username"]." vend ".$trade["offer_metal"]."M/".$trade["offer_crystal"]."C/".$trade["offer_deuterium"]."D contre ".$trade["want_metal"]."M/".$trade["want_crystal"]."C/".$trade["want_deuterium"]."D")."</description>";
			$xmlTrade .= "\n\t<comments>".utf8_encode($trade["note"])."</comments>";
			$xmlTrade .= "\n\t<pubDate>".date("D, j F Y g:i:s T",$trade["creation_date"])."</pubDate>";
			$xmlTrade .= "\n</item>";
			return $xmlTrade;			
	}

	// Récupération sous forme XML de la liste des offres d'un Univers
	function trades_array_xml($universeid,$order="creation_date desc",$limit="LIMIT 30",$excludeexpired=true) {
			$ret="";
			foreach($this->trades_array($universeid,$order,$limit,$excludeexpired) as $trade)
			{
				$ret .= "\n<offer>\n".$this->get_trade_xml($trade)."</offer>\n";
			}
			return $ret;
	}

	// Récupération sous format RSS de la liste des offres d'un Univers
	function trades_array_rss($universe,$limit="LIMIT 30") {
			$ret="";
			foreach($this->trades_array($universe["id"],"creation_date desc",$limit,true) as $trade)
			{
				$ret .= "\n".$this->get_trade_rss($trade,$universe);
			}
			return $ret;
	}
	
	// Récupération sous format RSS de la liste des offres d'un Univers
	function trades_array_all_uni_rss($limit="LIMIT 30") {
			$ret="";
			foreach($this->trades_array(null,"creation_date desc",$limit,true) as $trade)
			{
				$universe=cUniverses::get_universe($trade["universid"]);
				$ret .= "\n".$this->get_trade_rss($trade,$universe);
			}
			return $ret;
	}
	
	// Récupération d'un trade à partir de son ID sous forme de tableau
	// renvoie false si pas trouvé
	function get_trade($tradeid) {
		global $db;
		$sql =   "SELECT t.`id`,t.`traderid`,t.`universid`,t.`offer_metal`,t.`offer_crystal`,t.`offer_deuterium`,t.`want_metal`,t.`want_crystal`,t.`want_deuterium`,t.`creation_date`,t.`expiration_date`,t.`note`,u.`name` as username,t.`deliver_g1`,t.`deliver_g2`,t.`deliver_g3`,t.`deliver_g4`,t.`deliver_g5`,t.`deliver_g6`,t.`deliver_g7`,t.`deliver_g8`,t.`deliver_g9`,t.`refunding_g1`,t.`refunding_g2`,t.`refunding_g3`,t.`refunding_g4`,t.`refunding_g5`,t.`refunding_g6`,t.`refunding_g7`,t.`refunding_g8`,t.`refunding_g9`,t.`pos_user`,t.`pos_date` "
			." FROM ".TABLE_TRADE." t LEFT JOIN ".TABLE_USER." u ON u.id=t.traderid"
			." WHERE t.id=".intval($tradeid);

		$result = $db->sql_query( $sql );

		if ( list( $id,$traderid,$universid,$offer_metal,$offer_crystal,$offer_deuterium,$want_metal,$want_crystal,$want_deuterium,$creation_date,$expiration_date,$note,$username,$deliver_g1,$deliver_g2,$deliver_g3,$deliver_g4,$deliver_g5,$deliver_g6,$deliver_g7,$deliver_g8,$deliver_g9,$refunding_g1,$refunding_g2,$refunding_g3,$refunding_g4,$refunding_g5,$refunding_g6,$refunding_g7,$refunding_g8,$refunding_g9,$pos_user,$pos_date) = $db->sql_fetch_row( $result)) {
			$newvalues = Array();
			
			$newvalues["id"] = $id;
			$newvalues["traderid"] = $traderid;
			$newvalues["universid"] = $universid;
			$newvalues["offer_metal"] = $offer_metal;
			$newvalues["offer_crystal"] = $offer_crystal;
			$newvalues["offer_deuterium"] = $offer_deuterium;
			$newvalues["want_metal"] = $want_metal;
			$newvalues["want_crystal"] = $want_crystal;
			$newvalues["want_deuterium"] = $want_deuterium;
			$newvalues["creation_date"] = $creation_date;
			$newvalues["expiration_date"] = $expiration_date;
			$newvalues["note"]= $note;
			$newvalues["username"]= $username;
			$newvalues["deliver_g1"]= $deliver_g1;
			$newvalues["deliver_g2"]= $deliver_g2;
			$newvalues["deliver_g3"]= $deliver_g3;
			$newvalues["deliver_g4"]= $deliver_g4;
			$newvalues["deliver_g5"]= $deliver_g5;
			$newvalues["deliver_g6"]= $deliver_g6;
			$newvalues["deliver_g7"]= $deliver_g7;
			$newvalues["deliver_g8"]= $deliver_g8;
			$newvalues["deliver_g9"]= $deliver_g9;
			$newvalues["refunding_g1"]= $refunding_g1;
			$newvalues["refunding_g2"]= $refunding_g2;
			$newvalues["refunding_g3"]= $refunding_g3;
			$newvalues["refunding_g4"]= $refunding_g4;
			$newvalues["refunding_g5"]= $refunding_g5;
			$newvalues["refunding_g6"]= $refunding_g6;
			$newvalues["refunding_g7"]= $refunding_g7;
			$newvalues["refunding_g8"]= $refunding_g8;
			$newvalues["refunding_g9"]= $refunding_g9;
			$newvalues["pos_user"]= $pos_user;
			$newvalues["pos_date"]= $pos_date;

			return $newvalues;			
		}
		return false;
	}

	// Effacement d'une offre a partir de son ID
	function delete_trade($tradeid) {
		global $db;
		$sql = "DELETE FROM ".TABLE_TRADE." WHERE id=".intval($tradeid);
		$db->sql_query($sql);
	}
	
}

$Trades=new cTrades();
?>
