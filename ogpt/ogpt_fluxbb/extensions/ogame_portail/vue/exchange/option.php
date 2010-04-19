	<?php 
	
	
    /// le type de recherche est selectionné  : ally ou joueur
if(isset($_POST['option']) )	
	

{
///securisation de nom et mdp
$nom=trim($_POST['nom']);
$pass=trim($_POST['pass']);
//// passage en sha+ md5 pour l'identification du pseudo + filtre avnt requete
$nom_ogs = mysql_real_escape_string($nom);
$pass_ogs = md5(sha1($pass));

///recherche de l'id correspondant aux passe + pseudo


  $sql = 'SELECT * FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'user WHERE  user_name=\''.$nom_ogs.'\' and  user_password=\''.$pass_ogs.'\' ';

 
	    $result2 = $forum_db->query($sql);
	    while($pass = $forum_db->fetch_assoc($result2))
		{


//: ajout de l'id ogspy dans la table  fluxbb
 	$query_id_ogs = array(
		'UPDATE'	=> 'users',
		'SET'		=> 'ogs_user_id=\''.$pass['user_id'].'\'',
		'WHERE'		=> 'id=\''.$forum_db->escape($forum_user['id']).'\''
	);

  	$forum_db->query_build($query_id_ogs) or error(__FILE__, __LINE__);




}





}
    
    
    ?>
    
    <div class="main-head">
	<h1 class="hn"><span>Option d'echange</span></h1>
</div>

<div class="main-content frm">
	<div class="content-head">
		<h2 class="hn"><span>edite ton profil :
        <?php  if ( $forum_user['ogs_user_id'] ==  0 ) { echo '   votre acces ogs via le forum ne semble pas bon '; } ?>
        
        </span></h2>
	</div>

	
	<div id="req-msg" class="req-warn">
		<p class="important"><strong>IMPORTANT! </strong>champs marque <em>*</em> doit etre complete.</p>

	</div>
    
     
	<form id="afocus" class="frm-newform" method="post" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/vue/exchange.php') ?>?option=foo">
	
		
		<fieldset class="frm-set set1"><div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link('extensions/ogame_portail/vue/exchange.php').'?option=foo') ?>" />
			</div>
			
			
			<legend class="frm-legend"><strong>Required information</strong></legend>

				
			
		
				<div class="frm-textarea required">
					<label for="fld1">
						<span><em>*</em>pseudo</span>
					</label><br />
						<span class="fld-input"><input id="fld1" type="text" name="nom" size="25" maxlength="25" />
				Votre pseudo ogspy
				</span> 
				</div>
					
				<div class="frm-textarea required">
					<label for="fld1">
						<span><em>*</em>mot de passe</span>
					</label><br />
						<span class="fld-input"><input id="fld1" type="text" name="pass" size="25" maxlength="25" />
				votre mot de passe ogspy
				</span> 
				</div>
					
               
                    
                
                
				
				
				
		

		<div class="frm-buttons">
			<span class="submit"><input type="submit" name="option" value="Submit" /></span>
		
		</div>
	</form>
	</div>
    
    
    
    