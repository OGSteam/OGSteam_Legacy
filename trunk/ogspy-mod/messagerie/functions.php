<?php
/**
* Module de Messagerie pour OGSpy
* @package Messagerie
* @author ericalens <ericalens@ogsteam.fr> 
* @link http://www.ogsteam.fr http://doc.ogsteam.fr/modules_ogspy/classtrees_Messagerie.html
* @version 1.0
*/
// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// On ne verifie pas si le mod est actif, pour permettre éventuellement à d'autres mods d'utiliser les fonctions
// sans que le mod 'Messagerie' soit actif

global $table_prefix;

define("TABLE_MESSAGES", $table_prefix."messages");
define("TABLE_MESSAGES_THREAD", $table_prefix."messages_thread");
define("TABLE_BOARD", $table_prefix."board");

/**
* Une classe avec des fonctions d'aides dev pour OGspy
* Instancié sous le nom $Helper
*/
class cOgspyHelper {
	var $UserGroups=null;
	/**
	* UserIsInGroup
	*/
	function UserIsInGroup($groupid) {
		global $user_data,$db;
		if (empty($this->UserGroups)) {
			$sql = "SELECT * from ".TABLE_USER_GROUP." WHERE user_id=".$user_data["user_id"];
			$result=$db->sql_query($sql);
			$this->UserGroups = Array();
			while ($arr = $db->sql_fetch_assoc($result)) {
				$this->UserGroups[]=$arr["group_id"];
			}

		}
		return in_array($groupid,$this->UserGroups);
	}

	/**
	* Indique si l'utilisateur loggé est dans un groupe determiné
	* Remarques: Probleme si le nom du groupe est un nombre :p
	* @param int|string $group Identificateur ou Nom du groupe
	* @return boolean 
	*/
	function UserInGroup($group) {
		global $user_data,$db;
		if (is_int($group)) {
			$sql = "SELECT user_id FROM ".TABLE_USER_GROUP." WHERE group_id=$group AND user_id=".$user_data["user_id"];
			$result=$db->sql_query($sql);
			return $db->sql_fetch_row($result);
		}
		if (is_string($group)) {
			$sql = "SELECT group_id FROM ".TABLE_GROUP." WHERE group_name = '$group'";
			$result = $db->sql_query($sql);
			if (list($groupid)=$db->sql_fetch_row($result)) return $this->UserInGroup($groupid);
		}
		return false;
	}
}

$Helper = new cOgspyHelper();
/**
* Classe Mère , instancié sous le nom global $Messagerie 
* @package Messagerie
*/
class cMessagerie {
	/**
	* Tableau de cBoard
	* @var Array
	*/
	var $board=null;
	/**
	* Envoi d'un nouveau message
	* @param int $fromid  ID expéditeur
	* @param int $toid  ID destinataire (user ou thread)
	* @param int $type  0=message privé , 1 = thread
	* @param string $subject Sujet du message
	* @param string $message contenu du message
	* @return boolean
	*/
	function SendMessage($fromid,$toid,$type,$subject,$message) {
		$msg = new cMessage();
		return $msg->SendMessage($fromid,$toid,$type,$subject,$message) ;
	}
	/**
	* Modification d'un message
	* @param int $messageid  ID du message à changer
	* @param int $fromid  ID expéditeur
	* @param int $toid  ID destinataire (user ou thread)
	* @param int $type  0=message privé , 1 = thread
	* @param string $subject Sujet du message
	* @param string $message contenu du message
	* @return boolean
	*/
	function ChangeMessage($messageid,$fromid,$toid,$type,$subject,$message) {
		$msg = new cMessage();
		if ( !$msg->read($messageid) ) return false;
		$msg->fromid = $fromid;
		$msg->toid = $toid;
		$msg->type = $type;
		$msg->subject = $subject;
		$msg->message = $message;
		return $msg->write();
	}
	/**
	* Suppression de message (Non implémenté)
	*/
	function DelMessage($messageid) {
	
	}
	/**
	* Listing des messages attribués a un destinataire
	* @param int $toid  ID destinataire (user ou thread)
	* @param int $type  0 = msg privé, 1 = thread
	* @param string $sort Ordre de tri MySql
	* @return array Tableau de cMessage classé 
	*/
	function ListMessages($toid,$type,$sort=" ORDER BY sendeddate DESC"){
		global $db;
		$sql = "SELECT id FROM ".TABLE_MESSAGES." WHERE toid='$toid' and type='$type' $sort";
		$result = $db->sql_query($sql);
		$retarray = Array();

		while (list($msgid) = $db->sql_fetch_row($result)) {
			$retarray[]=new cMessage($msgid);
		}
		return $retarray;
	}
	/**
	* Réponse à un message
	*/
	function AnswerMessage($messageid,$message) {
	}
	/**
	* Recupère la liste des boards
	* @return Array Tableau de cBoard
	*/
	function GetBoards() {
		if (empty($this->board)) {
			$this->board=Array();
			global $db;
			$sql = "SELECT id from ".TABLE_BOARD;
			$result = $db->sql_query( $sql );
			while (list($boardid) = $db->sql_fetch_row($result)) {
				$this->board[]=new cBoard($boardid);
			}

		}
		return $this->board;
	}
	/**
	* Insertion de ligne de log
	* @param string $logmsg Message de log
	* @param string $section En-tete de ligne optionnel ("Messagerie" par defaut)
	*/
	function LogMessage($logmsg,$section="Messagerie"){
		global $user_data;
		$member = "";
		if (isset($user_data)) 	$member = $user_data["user_name"];
					
		$fichier = "log_".date("ymd").'.log';
    		$line = "/*".date("d/m/Y H:i:s")."*/ [$section]($member) ".$logmsg;
	        write_file(PATH_LOG_TODAY.$fichier, "a", $line);
	}
	/**
	* URL du mod Messagerie
	*/
	function URL(){
		return "<a href='?action=Messagerie'>Messagerie</a>";
	}
}
$Messagerie = new cMessagerie();
/**
* Classe Message
* Constructeur prenant optionellement un ID de message
*/
class cMessage {
	/**
	* Identificateur unique du message
	* @var int
	*/
	var $messageid;
	/**
	* Identificateur de l'expéditeur
	* @var int
	*/
	var $fromid;
	/**
	* Identificateur du destinataire (user id ou thread id)
	* @var int
	*/
	var $toid;
	/**
	* Type de message : 0 = Message privé, 1 = Thread , implémentations autres possibles
	* @var int
	*/
	var $type;
	/**
	* Sujet du Message
	*/
	var $subject;
	/**
	* Contenu du message
	* @var string
	*/
	var $message;
	/**
	* Date d'envoi du message
	* @var int
	*/
	var $sendeddate;
	/**
	* Message privé lu ou non
	* @var int
	*/
	var $readed=0;
	var $fromname="Unknown";
	/**
	* @param int $messageid Identificateur unique du message
	*/
	function cMessage($messageid=null) {
		if  (!empty($messageid))
			$this->read($messageid);
		else
			$this->Clear();
	}
	/**
	* Envoi d'un nouveau message
	* @param int $fromid  ID expéditeur
	* @param int $toid  ID destinataire (user ou thread)
	* @param int $type  0=message privé , 1 = thread
	* @param string $subject Sujet du message
	* @param string $message contenu du message
	* @return boolean
	*/
	function SendMessage($fromid,$toid,$type,$subject,$message) {
			$this->fromid = $fromid;
			$this->toid = $toid;
			$this->type = $type;
			$this->subject = $subject;
			$this->message = $message;
			$this->sendeddate = time();
			
			return $this->write();
	}
	/**
	* Effacement des données de la classe
	*/
	function Clear() {
			$this->messageid = null;
			$this->fromid = null;
			$this->toid = null;
			$this->type = null;
			$this->subject = null;
			$this->readed = 0;
			$this->message = null;
			$this->sendeddate = null;
			$this->fromname ="unknown";
	}
	/**
	* Lecture d'un message à partir de son identificateur
	* @param int $messageid ID du message
	* @return boolean
	*/
	function read($messageid){
		global $db;
		$sql = "SELECT t.*,u.user_name as fromname FROM ".TABLE_MESSAGES." t LEFT JOIN ".TABLE_USER." u on u.user_id=t.fromid WHERE id='".$messageid."'";

		$result = $db->sql_query( $sql );

		if ($arr = $db->sql_fetch_assoc($result)) {
			$this->messageid = $messageid;
			$this->fromid = $arr["fromid"];
			$this->toid = $arr["toid"];
			$this->type = $arr["type"];
			$this->readed = $arr["readed"];
			$this->subject = $arr["subject"];
			$this->message = $arr["message"];
			$this->sendeddate = $arr["sendeddate"];
			$this->fromname = $arr["fromname"];
		}
		else {
			$this->Clear();
			return false;
		}

		return $this;
	}
	/**
	* Ecriture en base de donnée du message
	* Si l'identificateur est invalide, le message est inséré sinon il est mis à jour
	*/
	function write(){
		if ( empty($this->messageid))
			return $this->InsertMessage();
		return $this->UpdateMessage();
		
	}
	/**
	* Mise à jour du message en base de donnée
	* si l'identificateur est mauvais, retourne false
	* @return boolean
	*/
	function UpdateMessage() {
		global $db;

		if ( empty($this->messageid)) return false;

		$sql = "UPDATE ".TABLE_MESSAGES." SET "
			."fromid='".intval($this->fromid)."', "
			."toid='".intval($this->toid)."', "
			."type'".intval($this->type)."', "
			."readed'".intval($this->readed)."', "
			."sendeddate'".intval($this->sendeddate)."', "
			."subject='".mysql_real_escape_string($this->subject)."', "
			."message='".mysql_real_escape_string($this->message)."' "
			."WHERE id = '".$this->messageid."'";

		$db->sql_query($sql);
		return $db->sql_num_rows();

	}
	/**
	* Insertion du message en base de donnée
	*/
	function InsertMessage() {
		global $db;

		$sql = "INSERT INTO ".TABLE_MESSAGES
			." (id,fromid,toid,type,readed,subject,message,sendeddate)"
			." VALUES(null,"
			."'".intval($this->fromid)."',"
			."'".intval($this->toid)."',"
			."'".intval($this->type)."',"
			."'".intval($this->readed)."',"
			."'".mysql_real_escape_string($this->subject)."',"
			."'".mysql_real_escape_string($this->message)."',"
			."'".intval($this->sendeddate)."' )";
		return $db->sql_query($sql);
	}
}

/**
* Suite logique de messages sous forme de thread
*/
class cMessageThread {
	/**
	* Identificateur unique du thread
	*/
	var $messagethreadid;
	/**
	* Board auquel appartient le thread
	*/
	var $boardid;
	/**
	* Constructeur
	* @param int $id Identificateur unique du thread optionnel
	*/
	function cMessageThread($id=null) {
		if (!empty($id)) $this->read($id); 
	}
	/**
	* lecture en base de donnée
	* @param int $id Identificateur unique du thread
	* @return false|cMessageThread
	*/
	function read($id) {
		global $db;
		$sql = "SELECT * FROM ".TABLE_MESSAGES_THREAD." WHERE id='$id' LIMIT 1";
		$result = $db->sql_query($sql);
		if ($arr = $db->sql_fetch_assoc($result)) {
			$this->messagethreadid=$arr["id"];
			$this->boardid=$arr["boardid"];
			return $this;
		}
		return false;

	}
	/**
	* Suppression du thread de la base de donnée
	*/
	function DeleteThread() {
		global $db;
		if (empty($this->messagethreadid)) return false;

		$sql = "DELETE FROM ".TABLE_MESSAGES." where toid=".$this->messagethreadid." and type=1";

		$db->sql_query( $sql );
		$sql = "DELETE FROM ".TABLE_MESSAGES_THREAD." where id=".$this->messagethreadid;
		return $db->sql_query( $sql );

	}
	/**
	* Scission d'un thread (Non implémenté)
	*/
	function SplitThread() {
	}
	/**
	* Ajout d'un message au thread
	*/
	function NewMessage($fromid, $subject,$message) {
		$msg = new cMessage();
		$msg->type = 1;
		$msg->fromid=$fromid;
		$msg->toid=$this->messagethreadid;
		$msg->subject = $subject;
		$msg->message = $message;
		$msg->sendeddate = time();
		return $msg->write();
	}
	/**
	* Récupération de la liste des messages sous forme de tableaux de ligne BD
	* Il pourrait etre utile.. voire préférable de renvoyer un tableau de cMessage
	*/
	function GetMessagesRows() {
		global $db;

		$retval = Array();

		$sql = "SELECT * FROM ".TABLE_MESSAGES." WHERE type=1 and toid='".$this->messagethreadid."' ORDER BY sendeddate ASC";
		$result = $db->sql_query($sql);

		while($arrMsg = $db->sql_fetch_assoc($result)) {
			$retval[]=$arrMsg;
		}
		return $retval;
	}
	/**
	* Récupération de la liste des messages sous forme de cMessage
	*/
	function GetMessages() {
		global $db;

		$retval = Array();

		$sql = "SELECT id FROM ".TABLE_MESSAGES." WHERE type=1 and toid='".$this->messagethreadid."' ORDER BY sendeddate ASC";
		$result = $db->sql_query($sql);

		while(list($msgid)= $db->sql_fetch_row($result)) {
			$retval[]=new cMessage($msgid);
		}
		return $retval;
	}
	/**
	* Premier message du thread
	* @return cMessage La classe du premier message
	*/
	function FirstMessage() {

		global $db;

		$sql = "SELECT id FROM ".TABLE_MESSAGES." WHERE toid='".$this->messagethreadid."' ORDER BY ID ASC LIMIT 1";

		$result = $db->sql_query( $sql );
		
		if (list($msgid) = $db->sql_fetch_row( $result) ) {
			$msg=new cMessage($msgid);
			return $msg;
		}

		return null;
	}
	/**
	* Nombre de messages dans le thread
	*/
	function CountMessages() {
		global $db;
		$sql = "SELECT COUNT(*) FROM ".TABLE_MESSAGES." WHERE type=1 and toid='".$this->messagethreadid."'";
		
		$result = $db->sql_query( $sql );
		list ($msgcount) = $db->sql_fetch_row( $result ) ;

		return $msgcount;
	}
	/**
	* URL
	* @return string URL formaté <a ...>Sujet du premier message<a>
	*/
	function URL() {
		$first=$this->FirstMessage();

		return date("d M-H:i",$first->sendeddate).": <a href='?action=Messagerie&amp;subaction=showthread&amp;threadid=".$this->messagethreadid."'>\"".$first->subject."\"</a>  ( ".$first->fromname." )";
	}

}

/**
* Classe de Board : contenant des threads contenant eux memes des messages
*/
class cBoard {
	/**
	* Identificateur unique du Board
	* @var int
	*/
	var $id;
	/**
	* Nom/Titre du board
	* @var string
	*/
	var $name;
	/**
	* Description optionelle du board
	* @var string
	*/
	var $description;
	/**
	* Groupe d'utilisateur ogspy pouvant écrire dans ce board
	* @var int
	*/
	var $writegroup;
	/**
	* Groupe d'utilisateur ogspy ayant accés en lecture à ce board
	* @var int
	*/
	var $readgroup;
	/**
	* Group d'utilisateur ogspy ayant accés aux fonctions admins de ce board
	* @var int
	*/
	var $admingroup;

	/**
	* Constructeur
	* @param int $boardid Identificateur unique du board
	*/
	function cBoard($boardid=null) {
		if (!empty($boardid)) $this->read($boardid);
	}
	/**
	* Ecriture des données en base de données
	* @return bool
	*/
	function write() {
		if (empty($this->id)) return $this->insert();
		return $this->update();
		
	}
	/**
	* Update les données en base de donnée
	* @return bool
	*/
	function update() {
		global $db;
		if (empty($this->id)) return false;	
		
		$sql = "UPDATE ".TABLE_BOARD." SET 
			 name='".mysql_real_escape_string($this->name)."', 
			 description='".mysql_real_escape_string($this->description)."', 
			 writegroup=".$this->writegroup.", 
			 readgroup=".$this->readgroup.", 
			 admingroup=".$this->admingroup." 
			WHERE ID='".$this->id."'";
		return $db->sql_query($sql);
	}
	/**
	* Insere le board dans la base de donnée
	* @return bool
	*/
	function insert() {
		global $db;
		$sql = "INSERT INTO ".TABLE_BOARD." 
			         (id,name,description,writegroup,readgroup,admingroup)
			VALUES (null,
				'".mysql_real_escape_string($this->name)."',
				'".mysql_real_escape_string($this->description)."',
				".$this->writegroup.",
				".$this->readgroup.",
				".$this->admingroup.")";
		return $db->sql_query($sql);

	}

	/**
	* Lecture à partir d'un identificateur de board
	* @param int $boardid Identificateur existant non null du board demandé
	* @return false|Array
	*/	
	function read($boardid) {
		global $db;
		$sql = "SELECT * FROM ".TABLE_BOARD." WHERE id='".$boardid."'";
		$result=$db->sql_query($sql);
		if ($arr = $db->sql_fetch_assoc($result)) {
			$this->id = $arr["id"];
			$this->name = $arr["name"];
			$this->description = $arr["description"];
			$this->writegroup = $arr["writegroup"];
			$this->readgroup = $arr["readgroup"];
			$this->admingroup = $arr["admingroup"];
			return $arr;
		}
		return false;
	}
	/**
	* Retourne un tableau de cThread
	* @param int $count Nombre maximum de thread a retourner
	* @param int $start Premier thread à envoyer
	* @param int $sort Classement MySql des threads
	*/
	function GetThreads($count=15,$start=0,$sort=" ORDER BY ID DESC") {
		global $db;
		$retval=Array();
		$sql = "SELECT id FROM ".TABLE_MESSAGES_THREAD." WHERE boardid=".$this->id." $sort LIMIT $start,$count";
		$result = $db->sql_query( $sql );
		while (list($id) = $db->sql_fetch_row( $result ) ) {
			$retval[] = new cMessageThread($id);
		}
		return $retval;
	}

	/**
	* Nombre de thread appartenant au board
	* @return int Nombre de thread
	*/
	function CountThread() {
		global $db;
		$sql = "SELECT count(*) FROM ".TABLE_MESSAGES_THREAD." WHERE boardid='".$this->id."'";
		list($threadsNum) = $db->sql_fetch_row($db->sql_query($sql));
		return intval($threadsNum);
	}
	/**
	* Nombres de messages dans le board (pour tout les threads)
	* @return int Nombre de messages total
	*/
	function CountMessages() {
		global $db;

		$sql = "SELECT count(1) as ThreadCount FROM ".TABLE_MESSAGES." WHERE type=1 and toid in (SELECT id FROM ".TABLE_MESSAGES_THREAD." WHERE boardid='".$this->id."')";
		$result = $db->sql_query($sql);
		list($msgcount)=$db->sql_fetch_row($result);
		return intval($msgcount);
	}
	/**
	* URL ancré
	* @return string URL sous la forme <a ..>Nom du Board</a>
	*/
	function URL() {
		return "<a href='?action=Messagerie&amp;subaction=show&amp;boardid=".$this->id."'>".$this->name."</a>";
	}
	/**
	 * Verifie si l'utilisateur courant à un accés en écriture à ce board
	 * @return boolean true si l'utilisateur peut ecrire
	 */
	 function user_can_write(){
	 		global $Helper,$user_data;
	 		if ($user_data["user_admin"]==1) return true;
	 		return $Helper->UserIsInGroup($this->writegroup);
	 }
	/**
	 * Verifie si l'utilisateur courant à un accés en lecture à ce board
	 * @return boolean true si l'utilisateur peut lire
	 */
	 function user_can_read(){
	 		global $Helper,$user_data;
	 		if ($user_data["user_admin"]==1) return true;
	 		return $Helper->UserIsInGroup($this->readgroup);
	 }
	 /**
	 * Verifie si l'utilisateur courant à un accés administratif à ce board
	 * @return boolean true si l'utilisateur peut administrer
	 */
	 function user_can_admin(){
	 		global $Helper,$user_data;
	 		if ($user_data["user_admin"]==1) return true;
	 		return $Helper->UserIsInGroup($this->admingroup);
	 }
}
?>
