<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
$query = 'SELECT active FROM '.TABLE_MOD.' WHERE action=\'gameOgame\' AND active=\'1\' LIMIT 1';
if (!$db->sql_numrows($db->sql_query($query))) die('Hacking attempt');

if (!isUser($user_data['user_id'])) die ('Vous n\'avez pas les droits suffisants pour acc�der � cette page.<br>Demandez � un administrateur de vous ajouter � la liste des participants.');

$pub_reportRecyclage = (int)$pub_reportRecyclage;

$sql = 'SELECT sender FROM '.TABLE_GAME.' WHERE id=\''.$pub_reportRecyclage.'\'';
$result = $db->sql_query($sql);
list($sender) = $db->sql_fetch_row($result);
if ($sender<>$user_data['user_id']) die ('Ce rapport de combat ne vous appartient pas<br>Vous ne pouvez donc pas y ajouter un rapport de recyclage');

$sql = 'SELECT recyclageM, recyclageC, recycleM, recycleC FROM '.TABLE_GAME.' WHERE id=\''.$pub_reportRecyclage.'\'';
$result = $db->sql_query($sql);
list($dispoM, $dispoC, $collecteM, $collecteC) = $db->sql_fetch_row($result);

if (($collecteM>=$dispoM) && ($collecteC>=$dispoC) || !(($dispoM+$dispoC)>0))	die('Le champ de d�bris de ce combat a d�j� �t� enti�rement recycl�<br>Vous ne pouvez donc pas y ajouter un rapport de recyclage');

if (isset($pub_data) && ($pub_data<>''))
{
	
	$data = stripslashes($pub_data);
	//Compatibilit� UNIX/Windows
	$data = str_replace("\r\n","\n",$data);
	//Compatibilit� IE/Firefox
	$data = str_replace("\t",' ',$data);
	//A priori, certains obtiennent des rapports avec de multiples espaces, donc on �limine le probl�me � la base
	cleanDoubleSpace($data);
	//Compatibilit� avec la 0.76
	$data = str_replace(".",'',$data);
	$data = str_replace("\'","'",$data);
	
	preg_match('#(\d*)-(\d*)\s(\d*):(\d*):(\d*)#',$data,$date);
	$timestamp = mktime($date[3],$date[4],$date[5],$date[1],$date[2]);
	
	if (!preg_match('#Vos (\d*) recycleurs ont une capacit� totale de (.*) (.*) unit�s de m�tal et (.*) unit�s de cristal sont dispers�es dans ce champ Vous avez collect� (.*) unit�s de m�tal et (.*) unit�s de cristal#',$data,$reg))
	{
		echo 'Rapport de recyclage invalide';
	} else {
		$sql = 'INSERT INTO '.TABLE_GAME_RECYCLAGE.' (id,rc,recycleurs,capacite,dispoM,dispoC,collecteM,collecteC,timestamp) VALUES (\'\',\''.$pub_reportRecyclage.'\',\''.$reg[1].'\',\''.(int)floatval($reg[2]).'\',\''.(int)floatval($reg[3]).'\',\''.(int)floatval($reg[4]).'\',\''.(int)floatval($reg[5]).'\',\''.(int)floatval($reg[6]).'\',\''.(int)floatval($timestamp).'\')';
		$db->sql_query($sql);
		$sql = 'UPDATE '.TABLE_GAME.' SET recycleM=recycleM+'.(int)floatval($reg[5]).', recycleC=recycleC+'.(int)floatval($reg[6]).', points=points+'.((int)floatval($reg[5])+(int)floatval($reg[6]))/100000*$config['recycl'].' WHERE id='.$pub_reportRecyclage;
		$db->sql_query($sql);
		echo 'Rapport charg� avec succ�s<br><br>Compte-rendu du traitement:<br>';
		echo 'M�tal collect�: '.convNumber((int)floatval($reg[5])).' ('.convNumber((int)floatval($reg[5])/100000*$config['recycl']).' points)<br>';
		echo 'Cristal collect�: '.convNumber((int)floatval($reg[6])).' ('.convNumber((int)floatval($reg[6])/100000*$config['recycl']).' points)<br>';
		echo 'Ce rapport vous rapporte <font size=\'5\' color=\'red\'>'.convNumber(ceil(((int)floatval($reg[5])+(int)floatval($reg[6]))/100000*$config['recycl'])).'</font> points';
	}
	
	echo '<br><a href=\'?action=gameOgame&reportRecyclage='.$pub_reportRecyclage.'\'>Retour</a>';
} else {
?>
Collez ici votre rapport de recyclage brut:<br>
<form method='post' action='?action=gameOgame&reportRecyclage=<?php echo $pub_reportRecyclage; ?>'>
<textarea name='data' rows='10' cols='100'></textarea><br>
<input type='submit' value='Envoyer'>
</form>
<?php
}
?>


		
