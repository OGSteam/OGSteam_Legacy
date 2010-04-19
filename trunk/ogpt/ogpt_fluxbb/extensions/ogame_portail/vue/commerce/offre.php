<?php




$forumulaireincorrect="forumlaire incorrect";

if(isset($_POST['offre']) )
{
// on test toutes les valeurs envoyer par le formulaire

/// ressource
if($_POST['ressource']=="") 
{
echo '<script> alert("veuillez remplir le champ ressource !") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",5000); </SCRIPT>';

}
$ressource=trim($_POST['ressource']);

//// champs quantité ressource
if($_POST['quantite']=="") 
{
echo '<script> alert("veuillez remplir le champ quantite !") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",5000); </SCRIPT>';

}
$quantite=trim($_POST['quantite']);


/// vs
if($_POST['vs']=="") 
{
echo '<script> alert("veuillez remplir le champ ressource !") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",5000); </SCRIPT>';

}
$vs=trim($_POST['vs']);

//// champs quantité vs
if($_POST['vsquantite']=="") 
{
echo '<script> alert("veuillez remplir le champ quantite !") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",5000); </SCRIPT>';

}
$vsquantite=trim($_POST['vsquantite']);


/// vs
// potentiellement sans valeur

$vs2=trim($_POST['vs2']);

//// champs quantité vs
//potentiellement sans valeur
if($_POST['vs2quantite']=="") 
{
echo '<script> alert("veuillez remplir le champ quantite !") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",5000); </SCRIPT>';

}
$vs2quantite=trim($_POST['vs2quantite']);




/// champs duree
if($_POST['duree']=="") 
{
echo '<script> alert("veuillez remplir le champ durée !") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",5000); </SCRIPT>';

}
$duree=trim($_POST['duree']);



//// champs quantité
if($_POST['galaxie']=="") 
{
echo '<script> alert("veuillez remplir le champ galaxie !") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",5000); </SCRIPT>';

}
$livraison=trim($_POST['galaxie']);





//// champs commentaire
if($_POST['commentaire']=="") 
{
echo '<script> alert("veuillez remplir le champ commentaire !") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",5000); </SCRIPT>';

}
$commentaire = forum_linebreaks(trim($_POST['commentaire']));
$commentaire = utf8_ucwords(utf8_strtolower($commentaire));
/// preparation bb code :
require  FORUM_ROOT.'include/parser.php';
$commentaire = preparse_bbcode($commentaire, $errors);




/// verification logique des donnéee



 /// deut =deut+ cricri ou deut = cri + deutpar exemple ...
  if ($ressource == $vs || $ressource == $vs2)
  {
   echo '<script> alert("Confusion dans les ressources!") </script>';
   echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",5000); </SCRIPT>';
}
/// deut =cricri+ cricri par exemple ...
  if ($vs == $vs2 )
  {
   echo '<script> alert("Confusion dans les ressources!") </script>';
   echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo"}setTimeout("redirect()",5000); </SCRIPT>';
}


/// envoi dans la base de donnée

$time = time();
$fin  = ($duree + $time);
$id_user = $forum_user['id'];


$forum_db->query('INSERT INTO '.$forum_db->prefix.'commerce_vente 
(date,
 fin,
 id_user,
 ressource,
 quantite,
 vs,
 vsquantite,
 vs2,
 vs2quantite,
 livraison) 
 VALUES 
 (  '.$time.',
  '.$fin.',
  '.$id_user.',
 '.$ressource.',
  '.$quantite.',
 '.$vs.',
  '.$vsquantite.',
'.$vs2.',
  '.$vs2quantite.',
 '.$livraison.'  
  )');


//: integration username + commentaire( si qqn peut me dire pk ca ne marche pas dans la requete qui precede ... :s
 	$query_username = array(
		'UPDATE'	=> 'commerce_vente',
		'SET'		=> 'username=\''.$forum_db->escape($forum_user['username']).'\'',
		'WHERE'		=> 'date=\''.$time.'\''
	);

             	$forum_db->query_build($query_username) or error(__FILE__, __LINE__);

$query_commentaire = array(
		'UPDATE'	=> 'commerce_vente',
		'SET'		=> 'commentaire=\''.$forum_db->escape($commentaire).'\'',
		'WHERE'		=> 'date=\''.$time.'\''
	);

             	$forum_db->query_build($query_commentaire) or error(__FILE__, __LINE__);








/// travail sur les groupes ( droits )



$query = array(
	'SELECT'	=> '*',
	'FROM'		=> 'commerce_vente',
	'WHERE'		=> 'date = \''.$time.'\'',
	'LIMIT'		=> '1'
);
		
$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
while ($id = $forum_db->fetch_assoc($result))
{
/// droit admin
$forum_db->query('INSERT INTO '.$forum_db->prefix.'commerce_groupe 
(id_vente,
 id_groupe,
 permission
 ) 
 VALUES 
 (  '.$id['id'].',
  1,
  1
  )');

///autres droits




	$query = array(
	'SELECT'	=> '*',
	'FROM'		=> 'groups',
	'WHERE'		=> 'g_id>3',
	
);
		
$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
while ($groups = $forum_db->fetch_assoc($result))
{



$a= $groups['g_id'];
if(isset($_POST['groups_'.$a.'']) )
{
$forum_db->query('INSERT INTO '.$forum_db->prefix.'commerce_groupe 
(id_vente,
 id_groupe,
 permission
 ) 
 VALUES 
 (  '.$id['id'].',
  '.$a.',
  '.$_POST['groups_'.$a.''].'
  )');


}


}


//envoit des messages a ceux qui le desire ( option.php
//$id['id']= id de la vente
$query = array(
      'SELECT'	=> 'u.id as uid, u.group_id , u.commerce_alerte_m , u.commerce_alerte_c , u.commerce_alerte_d  , u.commerce_mp , u.email ,
                    g.id_vente , g.permission , g.id_groupe ,
                    v.id as vid, v.date, v.fin, v.id_user , v.username, v.ressource, v.quantite , v.vs, v.vsquantite, v.vs2 ,  v.vs2quantite ,v.commentaire, v.livraison, v.reservation , v.pseudo , v.id_user_r, v.vente, v.satisfaction  , v.commentaire_satisfaction  ',
         'FROM'		=> 'commerce_groupe AS g ',
         'JOINS'		=> array(
                                          array(
				                'INNER JOIN'	=> 'users AS u',
				                'ON'			=> '(u.group_id=g.id_groupe) '
			                        ),
                                          array(
				                'INNER JOIN'	=> 'commerce_vente AS v',
				                'ON'			=> '(v.id=g.id_vente) '
			                        ),
                                          ),

         'WHERE'		=> '  (id_vente = '.$id['id'].')
                                       and (g.permission = 1)
                                       and (u.commerce_mp = 1) ',
        	                      );

$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
while ($groups = $forum_db->fetch_assoc($result))
{
if ( $groups['ressource'] = 1 &&  $groups['commerce_alerte_m'] = 1 )
{
/// envoi du message pour confirmation de l'offre
$time = time();
$subject=' [message automatique] mod commerce ';
$message = 'Une vente correspondant a ce que vous desirez vient d etre poster dans le module commerce, depechez vous';

$forum_db->query('INSERT INTO '.$forum_db->prefix.'messages 
(to_id,
 from_id,
 sent) 
 VALUES 
 (  '.$groups['uid'].',
  '.$groups['id_user'].',
 '.$time.'  
  )');

$query_commentaire = array(
		'UPDATE'	=> 'messages',
		'SET'		=> 'subject=\''.$forum_db->escape($subject).'\'',
		'WHERE'		=> 'sent=\''.$time.'\' and from_id=\''.$groups['id_user'].'\''
	);

             	$forum_db->query_build($query_commentaire) or error(__FILE__, __LINE__);


$query_commentaire = array(
		'UPDATE'	=> 'messages',
		'SET'		=> 'message=\''.$forum_db->escape($message).'\'',
		'WHERE'		=> 'sent=\''.$time.'\' and from_id=\''.$groups['id_user'].'\''
	);

             	$forum_db->query_build($query_commentaire) or error(__FILE__, __LINE__);
				
/// envoi du mail

	
$destinataire = ''.$groups['email'].'' ;
$sujet = 'Mod commerce [ogameportail]';
$message = ' Une offre correspondant a votre attente est arrive sur http://ogameportail.free.fr/fluxbb ' ;
$entetes = 'From: gounter_lievin@yahoo.fr' ;



$envoi_mail=mail($destinataire, $sujet, $message, $entetes) ;
 
///verif de l'envoi

if (!$envoi_mail)
{ echo "<p> Le mail n'a pas &eacute;t&eacute; envoy&eacute; car un probl&egrave;me est survenu...</p>" ; }
			
				

}



}

	


}
echo '<script> alert("votre offre a ete prise en compte") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?voir=foo"}setTimeout("redirect()",50); </SCRIPT>';

}



?>



	
	




<div class="main-head">
	<h1 class="hn"><span>Poster une nouvelle offre</span></h1>
</div>

<div class="main-content frm">
	<div class="content-head">
		<h2 class="hn"><span>Compose ta nouvelle offre :</span></h2>
	</div>

	
	<div id="req-msg" class="req-warn">
		<p class="important"><strong>IMPORTANT! </strong>champs marque <em>*</em> doit etre complete.</p>

	</div>
	
	

	 
	<form id="afocus" class="frm-newform" method="post" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/vue/commerce.php') ?>?offre=foo">
	
		
		<fieldset class="frm-set set1"><div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link('extensions/ogame_portail/vue/commerce.php').'?offre=foo') ?>" />
			</div>
			
			
			<legend class="frm-legend"><strong>Required information</strong></legend>

					<div class="frm-textarea required">
					<label for="fld2">

						<span><em>*</em> vends:</span>
					</label><br />
					<span class="fld-input">
				<select name="ressource" size="1">
				<option value="">Choix</option>
				<option value="1">Deuterium</option>
				<option value="2">cristal</option>
				<option value="3">Metal</option>
				</select>
				type de ressource vendu
				</span> 
				</div>
				
				
			
			
		
				<div class="frm-textarea required">
					<label for="fld1">
						<span><em>*</em> quantite:</span>
					</label><br />
					<span class="fld-input"><input id="fld2" type="text" name="quantite" value="0" size="12" maxlength="12" /> en chiffre</span>
				</div>
				
				
				<div class="frm-textarea required">
					<label for="fld1">
						<span><em>*</em> contre:</span>
					</label><br />
					<span class="fld-input">
				<select name="vs" size="1">
				<option value="">Choix</option>
				<option value="1">Deuterium</option>
				<option value="2">cristal</option>
				<option value="3">Metal</option>
				</select>
				type de ressource attendu
				</span> 
				</div>
				
				
			
			
		
				<div class="frm-textarea required">
					<label for="fld1">
						<span><em>*</em> quantite:</span>
					</label><br />
					<span class="fld-input"><input id="fld2" type="text" name="vsquantite" value="0" size="12" maxlength="12" /> en chiffre</span>
				</div>
				
				
			<div class="frm-textarea required">
					<label for="fld1">
						<span> Et contre:</span>
					</label><br />
					<span class="fld-input">
				<select name="vs2" size="1">
				<option value="0">Choix</option>
				<option value="1">Deuterium</option>
				<option value="2">cristal</option>
				<option value="3">Metal</option>
				</select>
				2nd type de ressource attendu (optionnel)
				</span> 
				</div>
				
				
			
			
		
				<div class="frm-textarea required">
					<label for="fld1">
						<span> quantite:</span>
					</label><br />
					<span class="fld-input"><input id="fld2" type="text" name="vs2quantite" value="0"  size="12" maxlength="12" /> en chiffre</span>
				</div>
					
				
				
				
				
				
				<div class="frm-textarea required">
					<label for="fld2">

						<span><em>*</em> valable:</span>
					</label><br />
					<span class="fld-input">
				<select name="duree" size="1">
				<option value="86400">1 jour</option>
				<option value="172800">2 jours</option>
				<option value="259200">3 jours</option>
				<option value="345600">4 jours</option>
				<option value="432000">5 jours</option>
				<option value="518400">6 jours</option>
				<option value="604800">7 jours</option>
				
				</select>
				 
					</span>
				</div>
		
		
		
		
		
		
		
		
		<div class="frm-textarea required">
					<label for="fld2">

						<span>livrable en:</span>
					</label><br />
					<span class="fld-input">
					<select name="galaxie" size="1">
					<option value="0">galaxie</option>
					<option value="1">g1</option>
					<option value="2">g2</option>
					<option value="3">g3</option>
					<option value="4">g4</option>
					<option value="5">g5</option>
					<option value="6">g6</option>
					<option value="7">g7</option>
					<option value="8">g8</option>
					<option value="9">g9</option>
					</select>
					
					</span>
					

					
				</div>
				
				
				
			<div class="frm-textarea required">
					<label for="fld2">
					<span><em>*</em>permission:</span>
					</label><br />
					<span class="fld-input">	
		<?php
		$query = array(
	'SELECT'	=> '*',
	'FROM'		=> 'groups',
	'WHERE'		=> 'g_id>3',
	
);
		
$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
while ($groups = $forum_db->fetch_assoc($result))
{


echo'
			<span class="fld-input">
					<select name="groups_'.$groups['g_id'].'" size="1">
					<option value="1">oui</option>
					<option value="0">non</option>
					
					</select> Autorise le groupe '.$groups['g_title'].' a voir l\'annonce.
					
					</span>
			
			
			
					

';




}
	
	
		
		?>

					</span>
					
				</div>
				
				

		
		
		
			<div class="frm-textarea required">

				<label for="fld2">
					<span><em>*</em> ecris ton message:</span>
				</label><br />
				<span class="fld-input"><textarea id="fld2" name="commentaire" rows="14" cols="95">BBcode autorise</textarea></span><br />
			</div>
		</fieldset>


		<div class="frm-buttons">
			<span class="submit"><input type="submit" name="offre" value="Submit" /></span>
		
		</div>
	</form>
	</div>