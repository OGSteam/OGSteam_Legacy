<?php
/** $Id$ **/
/**
* Messagerie interne
* @package OGSpy
* @subpackage main
* @author Capi
* @copyright Copyright &copy; 2007, http://ogsteam.fr
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$user_id = $user_data['user_id'];
$pub_subaction = isset($pub_subaction)?$pub_subaction:'inbox';

require_once("views/page_header.php");
if (file_exists($user_data['user_skin'].'\templates\mp.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\mp.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\mp.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\mp.tpl');
}
else
{
    $tpl = new template('mp.tpl');
}

// Effacement d'un message
if(isset($pub_delete)){
	$db->sql_query("SELECT expediteur, destinataire, efface FROM ".TABLE_MP." WHERE id='".$pub_delete."'");
	list($exped,$dest,$del) = $db->sql_fetch_row();

	if ($user_id == $dest) $suppr = 1;
	if ($user_id == $exped) $suppr = 2;
	if($suppr+$del===3)
		$db->sql_query("DELETE FROM ".TABLE_MP." WHERE id='".$pub_delete."'");
	else 
		$db->sql_query("UPDATE ".TABLE_MP." SET efface='".($suppr)."' WHERE id='".$pub_delete."'");
	$ajax_info = L_('mp_ErasseOk');
}

// Envoi d'un message
if ($pub_subaction == 'send') {
	$pub_subaction = 'inbox'; // On redirigera sur la boite d'arrivé ensuite
	$pub_destinataire = explode('|',$pub_destinataire);
	$db->sql_query("SELECT COUNT(*) AS nbre_entrees FROM ".TABLE_USER." WHERE user_id IN(".implode(',',$pub_destinataire).")"); 
	list($nbr_dest) = $db->sql_fetch_row();
	if($nbr_dest>0){ // Aucun destinataire n'existe (c'est possible d'en arriver là?!)
		foreach($pub_destinataire as $d){
			$value = Array($pub_subject,$user_id,$d,mysql_real_escape_string($pub_message),time(),0,0);
			$db->sql_query("INSERT INTO ".TABLE_MP."
				(sujet, expediteur, destinataire, message, timestamp, vu, efface) 
				VALUES('".implode("','",$value)."')"
			);
		}
		$ajax_info = L_('mp_SendOK');
	}else{
		$ajax_info = L_('mp_NoUser');
	}
}
	
	
// Boite de réception
if ($pub_subaction == "inbox") {
	$tpl->checkIf('mp_box',true); //$tpl = new Template('mp_box.tpl');
	$tpl->checkIf('menu_inbox',true);
	$nbr_non_vus = $db->sql_query("SELECT COUNT(*) AS nbre FROM ".TABLE_MP." WHERE destinataire='".$user_id."' AND vu='0' AND efface <> '1'");
	$nbre_non_vus = $db->sql_fetch_assoc($nbr_non_vus);
	$retour = $db->sql_query("SELECT u.id, u.sujet, v.user_name, u.destinataire, u.timestamp, u.vu FROM ".TABLE_MP." u, ".TABLE_USER." v WHERE u.destinataire='".$user_id."' AND v.user_id = u.expediteur AND u.efface <> '1' ORDER BY id DESC");
		
	$class = 'f';
	$tpl->checkIf('is_empty',$db->sql_numrows($retour)<1);
	while ($donnees = $db->sql_fetch_assoc($retour)) {
		$class =  ($class == 'f')?'b':'f';
		$tpl->loopVar('list',Array(
			'class' => $class,
			'image' => 'images/'.($donnees['vu'] == 0 ? "b" : "c").'.gif',
			'subject' => stripslashes($donnees['sujet']),
			'author' => $donnees['user_name'],
			'date' => date('d M Y - H\hi', $donnees['timestamp']),
			'subject_onclick' => "document.location='?action=mp&amp;subaction=read&amp;mp=".$donnees['id']."';",
			'author_onclick' => "document.location='?action=mp&amp;subaction=write&amp;reponse=".$donnees['id']."';",
			'delete_onclick' => "document.location='?action=mp&amp;subaction=inbox&amp;delete=".$donnees['id']."';",
		));
	}
	$tpl->SimpleVar(Array(
		'mp_head' => '('.$nbre_non_vus['nbre'].')',
		'mp_subject' => L_('mp_subjet'),
		'mp_author' => L_('mp_author'),
		'mp_date' => L_('mp_date'),
		'mp_head_right' => '&nbsp;',
		'mp_Rep' => L_('mp_Rep'),
		'mp_EmptyBox' => L_('mp_EmptyBox')
	));
	//ajax_return($tpl->parse('return'));
}
	
// Boite d'envoi	
if ($pub_subaction == 'outbox') {
	$retour = $db->sql_query("SELECT id, user_name, sujet, timestamp, vu FROM ".TABLE_MP.", ".TABLE_USER." WHERE expediteur='".$user_id."' AND destinataire=user_id AND efface <> '2' ORDER BY id DESC");

	$tpl->checkIf('mp_box',true); //$tpl = new Template('mp_box.tpl');
	$tpl->checkIf('menu_outbox',true);
	$class = 'f';
	$tpl->checkIf('is_empty',$db->sql_numrows($retour)<1);
	while ($donnees = $db->sql_fetch_assoc($retour)) {
		$class = ($class == 'f')?'b':'f';
		$tpl->loopVar('list',Array(
			'class' => $class,
			'image' => 'images/'.($donnees['vu'] != 0 ? "b" : "c").'.gif',
			'subject' => stripslashes($donnees['sujet']),
			'author' => $donnees['user_name'],
			'date' => date('d M Y - H\hi', $donnees['timestamp']),
			'subject_onclick' => "document.location = '?action=mp&amp;subaction=read&amp;mp=".$donnees['id']."';",
			'author_onclick' => "document.location = '?action=mp&amp;subaction=write&amp;reponse=".$donnees['id']."';",
			'delete_onclick' => "document.location = '?action=mp&amp;subaction=outbox&amp;delete=".$donnees['id']."';"
		));
	}
	$tpl->SimpleVar(Array(
		'mp_head' => sprintf(help('mp_dest_read'),"&lt;img src=\'images/b.gif\' /&gt;&nbsp;","&lt;img src=\'images/c.gif\' /&gt;&nbsp;"),
		'mp_subject' => L_('mp_subjet'),
		'mp_author' => L_('mp_To'),
		'mp_date' => L_('mp_date'),
		'mp_head_right' => sprintf(help('mp_delete'),"&lt;img src=\'images/b.gif\' /&gt;&nbsp;","&lt;img src=\'images/c.gif\' /&gt;&nbsp;"),
		'mp_Rep' => help('mp_delete'),
		'mp_EmptyBox' => L_('mp_EmptyBox')
	));
	//ajax_return($tpl->parse('return'));
}

// Message	
if ($pub_subaction == 'read') {
	$db->sql_query("SELECT destinataire, sujet, expediteur, timestamp, message, vu FROM ".TABLE_MP." WHERE id='".$pub_mp."'");
	$donnees = $db->sql_fetch_assoc();
	if ($donnees['destinataire'] == $user_id) {
		$dest_exp = $donnees['expediteur'];
		$de_pour = L_('mp_From');
	} else{
		$dest_exp = $donnees['destinataire'];
		$de_pour = L_('mp_To');
	}
	$db->sql_query("SELECT user_name FROM ".TABLE_USER." WHERE user_id='".$dest_exp."'");
	list($dest_exp) = $db->sql_fetch_row();
	if ($donnees['destinataire'] == $user_id && $donnees['vu']!=1) 
		$db->sql_query("UPDATE ".TABLE_MP." SET vu='1' WHERE id='".$pub_mp."'");
	$tpl->checkIf('mp_read',true); //$tpl = new Template('mp_read.tpl');
	$tpl->SimpleVar(Array(
		'subject' => stripslashes($donnees['sujet']),
		'author' => $de_pour."&nbsp;<b>".$dest_exp."</b>",
		'date' => L_('mp_date')."&nbsp;".date('d M Y - H\hi', $donnees['timestamp']),
		'text' => stripslashes($donnees['message']),
		'answer_onclick' => "document.location = '?action=mp&amp;subaction=write&amp;reponse=".$pub_mp."';",
		'mp_Rep' => L_('mp_Rep')
	));
	//ajax_return($tpl->parse('return'));
}
	
// Ecriture message	
if ($pub_subaction == 'write') {
	if (isset($pub_reponse)) {
		$req = $db->sql_query("SELECT sujet, expediteur, destinataire FROM ".TABLE_MP." WHERE id='".$pub_reponse."'");
		list($sujet,$exped,$dest) = $db->sql_fetch_row($req);
	}
	if (isset($sujet)) $sujet = L_('mp_Re')."&nbsp;".$sujet;
	$tpl->checkIf('mp_write',true); //$tpl = new Template('mp_write.tpl');
	$tpl->checkIf('menu_write',true);
	$tpl->SimpleVar(Array(
		'mp_subject' => L_('mp_subjet'),
		'input_subject' => isset($sujet)?$sujet:'',
		'mp_message' => L_('mp_message'),
		'mp_To' => L_('mp_To')."&nbsp;".help("mp_chose_reader"),
		'mp_Send' => L_('mp_Send')
	));
	
	
	$req = $db->sql_query("SELECT user_name, user_id FROM ".TABLE_USER." WHERE user_active='1' AND user_id != ".$user_id);
	$tpl->CheckIf('is_user', $db->sql_numrows($req)!=0);
	while ($members = $db->sql_fetch_assoc($req)) {
		$selected = "";
		if ((isset($exped)&&$exped==$members['user_id'])
		|| (isset($dest)&&$dest==$members['user_id']))
			$selected = " selected='selected'";
		$tpl->loopVar('mb_list',Array(
			'user_id' => $members['user_id'],
			'selected' => $selected,
			'user_name' => $members['user_name']
		));
	}
	if(isset($exped)){
		$req = $db->sql_query("SELECT user_active FROM ".TABLE_USER." WHERE user_id = ".$exped);
		list($active) = $db->sql_fetch_row($req);
		if($active=="0")
			$return_script="<script>alert('".addslashes(htmlspecialchars_decode(html_entity_decode(L_('mp_NoUser')),ENT_QUOTES))."');</script>";
	}
	//ajax_return($tpl->parse('return').(isset($return_script)?$return_script:''));
}


$tpl->SimpleVar(Array(
	'info' => isset($ajax_info)?$ajax_info:'&nbsp;',
	'mp_All' => addslashes(htmlspecialchars_decode(html_entity_decode(L_('mp_All')),ENT_QUOTES)),
));
//make_ajax_script();
$tpl->parse();
require_once("views/page_tail.php");
?>
