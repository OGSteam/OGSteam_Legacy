<?php 
if(isset($_POST['options']) )
{
///filtrage des resultats
$mp=trim($_POST['mp']);
$mail=trim($_POST['mail']);
$metal=trim($_POST['metal']);
$cristal=trim($_POST['cristal']);
$deut=trim($_POST['deut']);

///si une valeut n'est pas rempli
if ($mp == "" || $mail == ""   || $metal == ""      || $cristal == ""   || $deut == ""  )
//alors redirection
{
echo '<script> alert("veuillez TOUTES les options !") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?options=foo"}setTimeout("redirect()",50); </SCRIPT>';	
}
///verification valeurs numeriques
else if (!is_numeric($mp) || !is_numeric($mail)  || !is_numeric($metal)     || !is_numeric($cristal)  || !is_numeric($deut))
{
/// si une est nulle, redirection
echo '<script> alert("?????????") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?options=foo"}setTimeout("redirect()",50); </SCRIPT>';	
}

else if (is_numeric($mp) || is_numeric($mail)  || is_numeric($metal)     || is_numeric($cristal)  || is_numeric($deut))

{
// ajout dans le profile des otpions 
// mp
$query_username = array(
		'UPDATE'	=> 'users',
		'SET'		=> 'commerce_mp=\''.$forum_db->escape($mp).'\'',
		'WHERE'		=> 'id=\''.$forum_user['id'].'\''
	);

$forum_db->query_build($query_username) or error(__FILE__, __LINE__);

// mail
$query_username = array(
		'UPDATE'	=> 'users',
		'SET'		=> 'commerce_mail=\''.$forum_db->escape($mail).'\'',
		'WHERE'		=> 'id=\''.$forum_user['id'].'\''
	);

$forum_db->query_build($query_username) or error(__FILE__, __LINE__);


// metal
$query_username = array(
		'UPDATE'	=> 'users',
		'SET'		=> 'commerce_alerte_m=\''.$forum_db->escape($metal).'\'',
		'WHERE'		=> 'id=\''.$forum_user['id'].'\''
	);

$forum_db->query_build($query_username) or error(__FILE__, __LINE__);


// cristal
$query_username = array(
		'UPDATE'	=> 'users',
		'SET'		=> 'commerce_alerte_c=\''.$forum_db->escape($cristal).'\'',
		'WHERE'		=> 'id=\''.$forum_user['id'].'\''
	);

$forum_db->query_build($query_username) or error(__FILE__, __LINE__);

// deuterieum
$query_username = array(
		'UPDATE'	=> 'users',
		'SET'		=> 'commerce_alerte_d=\''.$forum_db->escape($deut).'\'',
		'WHERE'		=> 'id=\''.$forum_user['id'].'\''
	);

$forum_db->query_build($query_username) or error(__FILE__, __LINE__);



/// uena alerte avec redirection
echo '<script> alert("changements pris en compte") </script>';
echo '<SCRIPT LANGUAGE="JavaScript"/> function redirect() { window.location="'.forum_link('extensions/ogame_portail/vue/commerce.php').'?voir=foo"}setTimeout("redirect()",50); </SCRIPT>';	


}


}
?> 



<div class="main-head">
	<h1 class="hn"><span>Option de mod commerce</span></h1>
</div>

<div class="main-content frm">
	<div class="content-head">
		<h2 class="hn"><span>edite ton profil :</span></h2>
	</div>

	
	<div id="req-msg" class="req-warn">
		<p class="important"><strong>IMPORTANT! </strong>champs marque <em>*</em> doit etre complete.</p>

	</div>
	
	

	 
	<form id="afocus" class="frm-newform" method="post" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/vue/commerce.php') ?>?options=foo">
	
		
		<fieldset class="frm-set set1"><div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link('extensions/ogame_portail/vue/commerce.php').'?options=foo') ?>" />
			</div>
			
			
			<legend class="frm-legend"><strong>Required information</strong></legend>

				
			
		
				<div class="frm-textarea required">
					<label for="fld1">
						<span><em>*</em> MP :</span>
					</label><br />
					<span class="fld-input">
				<select name="mp" size="1">
				<option value="">Choix</option>
				<option value="1">oui</option>
				<option value="0">non</option>
				
				</select>
				Recevoir des MP d'avertissement
				</span> 
				</div>
					
				<div class="frm-textarea required">
					<label for="fld1">
						<span><em>*</em> Mail :</span>
					</label><br />
					<span class="fld-input">
				<select name="mail" size="1">
				<option value="">Choix</option>
				<option value="1">oui</option>
				<option value="0">non</option>
				
				</select>
				Recevoir des mails d'avertissement
				</span> 
				</div>
					
                
                <div class="frm-textarea required">
					<label for="fld1">
						<span><em>*</em> Alerte metal :</span>
					</label><br />
					<span class="fld-input">
				<select name="metal" size="1">
				<option value="">Choix</option>
				<option value="1">oui</option>
				<option value="0">non</option>
				
				</select>
				Etre averti pour chaque vente de metal
				</span> 
				</div>
					
                    
                    
                    <div class="frm-textarea required">
					<label for="fld1">
						<span><em>*</em> Alerte cristal :</span>
					</label><br />
					<span class="fld-input">
				<select name="cristal" size="1">
				<option value="">Choix</option>
				<option value="1">oui</option>
				<option value="0">non</option>
				
				</select>
				Etre averti pour chaque vente de cristal
				</span> 
				</div>
					
                   <div class="frm-textarea required">
					<label for="fld1">
						<span><em>*</em> Alerte deut :</span>
					</label><br />
					<span class="fld-input">
				<select name="deut" size="1">
				<option value="">Choix</option>
				<option value="1">oui</option>
				<option value="0">non</option>
				
				</select>
				Etre averti pour chaque vente de deuterium
				</span> 
				</div>
					 
                    
                
                
				
				
				
		

		<div class="frm-buttons">
			<span class="submit"><input type="submit" name="options" value="Submit" /></span>
		
		</div>
	</form>
	</div>
    
    
    
   