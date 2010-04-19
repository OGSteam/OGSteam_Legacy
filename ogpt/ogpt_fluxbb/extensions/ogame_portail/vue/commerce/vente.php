
<?php

if(isset($_GET['vente']) )
{
if (is_numeric($_GET['vente']))
{
$query = array(
	'SELECT'	=> '*',
	'FROM'		=> 'commerce_vente',
	'WHERE'		=> 'id = '.$_GET['vente'].' ',
	
);
		
$vente = $forum_db->query_build($query) or error(__FILE__, __LINE__);
while ($venteencours = $forum_db->fetch_assoc($vente))

{

if ( $venteencours['id_user']=$forum_user['id'] ){

$query_username = array(
		'UPDATE'	=> 'commerce_vente',
		'SET'		=> 'vente=\'1\'',
		'WHERE'		=> 'id=\''.$forum_db->escape($_GET['vente']).'\''
	);
$forum_db->query_build($query_username) or error(__FILE__, __LINE__);



/// envoi du message pour confirmation de l'offre
$time = time();
$subject=' [message automatique] mod commerce ';
$message = ' Votre reservation vient d etre accepter, merci de contacter le vendeur';

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



}

}


}
else
{
echo "vou n avez pas les droits necessaires ;)";
}

	
	

	
		
?>
