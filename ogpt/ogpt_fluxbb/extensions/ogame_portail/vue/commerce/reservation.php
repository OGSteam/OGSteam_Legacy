
<?php

if(isset($_GET['reservation']) )
{
if (is_numeric($_GET['reservation']))
{
$query_username = array(
		'UPDATE'	=> 'commerce_vente',
		'SET'		=> 'reservation=\'1\'',
		'WHERE'		=> 'id=\''.$_GET['reservation'].'\''
	);
$forum_db->query_build($query_username) or error(__FILE__, __LINE__);

$query_username = array(
		'UPDATE'	=> 'commerce_vente',
		'SET'		=> 'pseudo=\''.$forum_db->escape($forum_user['username']).'\'',
		'WHERE'		=> 'id=\''.$_GET['reservation'].'\''
	);
$forum_db->query_build($query_username) or error(__FILE__, __LINE__);


$query_username = array(
		'UPDATE'	=> 'commerce_vente',
		'SET'		=> 'id_user_r=\''.$forum_db->escape($forum_user['id']).'\'',
		'WHERE'		=> 'id=\''.$_GET['reservation'].'\''
	);
$forum_db->query_build($query_username) or error(__FILE__, __LINE__);






$query = array(
	'SELECT'	=> '*',
	'FROM'		=> 'commerce_vente',
	'WHERE'		=> 'id = '.$_GET['reservation'].' ',
	
);
		
$vente = $forum_db->query_build($query) or error(__FILE__, __LINE__);
while ($venteencours = $forum_db->fetch_assoc($vente))

{



/// envoi du message pour confirmation de l'offre
$time = time();
$subject=' [message automatique] mod commerce ';
$message = ' Votre offre vient d etre reserver, merci de valider celle ci dans le module';

$forum_db->query('INSERT INTO '.$forum_db->prefix.'messages 
(to_id,
 from_id,
 sent) 
 VALUES 
 (  '.$venteencours['id_user_r'].',
  '.$forum_user['id'].',
 '.$time.'  
  )');

$query_commentaire = array(
		'UPDATE'	=> 'messages',
		'SET'		=> 'subject=\''.$forum_db->escape($subject).'\'',
		'WHERE'		=> 'sent=\''.$time.'\''
	);

             	$forum_db->query_build($query_commentaire) or error(__FILE__, __LINE__);


$query_commentaire = array(
		'UPDATE'	=> 'messages',
		'SET'		=> 'message=\''.$forum_db->escape($message).'\'',
		'WHERE'		=> 'sent=\''.$time.'\''
	);

             	$forum_db->query_build($query_commentaire) or error(__FILE__, __LINE__);


}

 
 
echo '<script> alert("Reservation prise en compte") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?voir=foo"}setTimeout("redirect()",50); </SCRIPT>';
}




}
else
{
echo "Qu'est-ce que tu fais, petit malin ? ;)";
}

	
	

	
		
?>
