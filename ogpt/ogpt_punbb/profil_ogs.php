<?php




define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
//bizarre :malgre require_once bug :s
 ///envoi des include necessaires
//require_once PUN_ROOT.'ogpt/include/fonction.php';
//require_once PUN_ROOT.'ogpt/include/empire.php';
//require_once PUN_ROOT.'ogpt/include/prod.php';
//require_once PUN_ROOT.'ogpt/include/re.php';
//require_once PUN_ROOT.'ogpt/include/rech.php';
//require_once PUN_ROOT.'ogpt/include/records.php';
/// fin des includes


if ($pun_user['g_read_board'] == '0')
	message($lang_common['No view']);


/// si utilisateur est pas enregistré : redirection
if(	$pun_user['is_guest'] )
{
$redirection="identifiez vous";
redirect('index.php', $redirection);
}



define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';





if (isset($_POST['profil_ogs']))
{
///securisation de nom et mdp
$pseudo=pun_trim($_POST['pseudo']);
$pass=pun_trim($_POST['pass']);
//// passage en sha+ md5 pour l'identification du pseudo + filtre avnt requete
$pseudo_ogs = pun_trim($pseudo);
$pass_ogs = md5(sha1($pass));


///recherche de l'id correspondant aux passe + pseudo


  $sql = 'SELECT * FROM '.$pun_config["ogspy_prefix"].'user WHERE  user_name=\''.$pseudo_ogs.'\' and  user_password=\''.$pass_ogs.'\' ';


	    $result2 = $db->query($sql);
	    while($pass = $db->fetch_assoc($result2))
		{

		 $sql = 'UPDATE '.$db->prefix.'users SET id_ogspy = '.$pass['user_id'].'  WHERE id = '.$pun_user['id'].' ';
            $query = $db->query($sql) or error("Impossible to update ", __FILE__, __LINE__, $db->error());


	///redirection pour prise en compte dans la page
$redirection='Modifications prises en compte<br>'.pseudo($pun_user['id_ogspy']).''; redirect('profil_ogs.php', $redirection);


		}









}








if (isset($_POST['profil_ogs_pm']))
{

///paramettre de la galaxie ( a mettre eb bdd plus tard )
$gal_min=1;
$gal_max=$pun_config['gal']+1;
$sys_min=1;
$sys_max=$pun_config['sys']+1;



///securisation de nom et mdp
$galaxie=pun_trim($_POST['galaxie']);
$systeme=pun_trim($_POST['systeme']);


// verif numerique
if (!is_numeric($galaxie)){$redirection="Nous ne nous comprennons plus"; redirect('index.php', $redirection);}
if (!is_numeric($systeme)){$redirection="Nous ne nous comprennons plus"; redirect('index.php', $redirection);}

/// si veleur de galaxie inf a 1 => valeur 1 sup a 9 => 1
if($galaxie>= $gal_min && $galaxie<$gal_max) { $galaxie=$galaxie ;} else { $galaxie=1 ;}

/// si veleur de systeme inf a 1 => valeur 1 sup a 499 => 499
if($systeme>= $sys_min && $systeme<$sys_max) { $systeme=$systeme;} else { $systeme=1 ;}




/// mise a jour de la pm

 $sql = 'UPDATE '.$db->prefix.'users SET pm_g = '.$galaxie.'  WHERE id = '.$pun_user['id'].' ';
            $query = $db->query($sql) or error("Impossible to update pm", __FILE__, __LINE__, $db->error());

 $sql = 'UPDATE '.$db->prefix.'users SET pm_s = '.$systeme.'  WHERE id = '.$pun_user['id'].' ';
            $query = $db->query($sql) or error("Impossible to update pm", __FILE__, __LINE__, $db->error());

///redirection pour prise en compte dans la page
$redirection="Modifications prises en compte"; redirect('profil_ogs.php', $redirection);


}






?>










<div class="blockform"><h2><span> Liaison forum ogspy</span></h2><div class="box">


 <fieldset>
						<legend>Donnez vos accés ogspy si besoin est </legend>
 <?php
/// verification de l'utilisation de l'id ogspy si 0 pas utilisé ...
 if ( $pun_user['id_ogspy'] ==  '0' ) { echo '   votre acces ogs via le forum ne semble pas bon '; }
 if ( $pun_user['id_ogspy'] !==  '0' ) { echo '   votre acces ogs via le forum semble correct <br><br>  sous le pseudo ogspy de <b>'.pseudo($pun_user['id_ogspy']).'</b>'; }



  ?>

						<div class="infldset">


<form id="profil_ogs" method="post" action="profil_ogs.php">
			<div class="inform">


						<input type="hidden" name="profil_ogs" value="profil_ogs" accesskey="s" />
						<label class="conl">pseudo ogspy :    <br /><input type="text" name="pseudo" value="<?php echo ''.pseudo($pun_user['id_ogspy']).'';?>" size="10" maxlength="20" /><br /></label>
						<label class="conl">pass ogspy :    <br /><input type="text" name="pass" size="10" maxlength="20"  "/> <br /></label>


			</div>

		
			
			<p><input type="submit"   /></p>
		</form>
</div>
   </fieldset>
  
  




 <fieldset>
						<legend>Donnez vos accés ogspy si besoin est </legend>
 <?php
/// verification de l'utilisation de l'id ogspy si 0 pas utilisé ...
 echo '   votre systeme solaire est actuelement :  [';  if ( $pun_user['pm_g'] ==  '0' ) { echo '1'; } if ( $pun_user['pm_g'] !==  '0' ) { echo ''.$pun_user['pm_g'].''; }echo':';if ( $pun_user['pm_s'] ==  '0' ) { echo '1'; } if ( $pun_user['pm_s'] !==  '0' ) { echo ''.$pun_user['pm_s'].''; }echo']';
 


  
  
  
  ?>                       
                        
						<div class="infldset"> 
  

<form id="profil_ogs_pm" method="post" action="profil_ogs.php">
			<div class="inform">

                    
						<input type="hidden" name="profil_ogs_pm" value="profil_ogs" accesskey="s" />
						<label class="conl">galaxie :    <br /><input type="text" name="galaxie" size="2" value="<?php echo ''.$pun_user['pm_g'].''; ?>" maxlength="2" /><br /></label>
						<label class="conl">systeme :    <br /><input type="text" name="systeme" size="3" value="<?php echo ''.$pun_user['pm_s'].''; ?>" maxlength="3"  "/> <br /></label>
						
			
			</div>

		
			
			<p><input type="submit"   /></p>
		</form>
</div>
   </fieldset>
  











<br />



	</div>
</div>













  <div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>

    </div>

	
    
  
  

<?php



require PUN_ROOT.'footer.php';