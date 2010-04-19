<?php




define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';

///ogpt
$lien="exchange.php?type=joueur";
$page_title = "exchange";
require_once  PUN_ROOT . 'ogpt/include/ogpt.php';
/// fin ogpt



define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';

 if ( $pun_user['id_ogspy'] ==  '0' ||  $pun_user['id_ogspy'] ==  '')
 {
  echo '
 <div class="blockform"><h2><span> EXchange </span></h2>
 <div class="box"><br><br>
 vous ne pouvez utiliser ce mod tant que vous n\'avez pas remplis votre profil <br> <br> rendez vous sur <a href="profil_ogs.php">profil_ogs</a><br>Merci<br>
 </div>
 </div>';
 }

else

{
?>
<?php
  echo '
 <div class="blockform"><h2><span> EXchange </span></h2>
 <div class="box">
 <a href="exchange.php?type=joueur">Joueur</a> | <a href="exchange.php?type=ally">Alliance</a> | <a href="exchange.php?type=rech_joueur">Recherche joueur</a> 
 <br>
 </div>
 </div>';

/// verif de l'existance du mod dans ogspy'
    $mod="eXchange";
    $ok="0";
	$sql = 'SELECT count(id) FROM   '.$pun_config["ogspy_prefix"].'mod WHERE action=\''.$mod.'\'';
	$result = $db->query($sql);
	list($nb_mod) = $db->fetch_row($result);
	$ok=$nb_mod;
	
    if ( $ok == '0' || $ok == ''){ echo ' le mod ne peut s afficher<br> il  n est pas installe sur  <br>ogspy'; } 	 else
		 {		





?>



<?php

if ( $_GET['type']=="rech_mot" )

{


echo '<div class="blockform"><h2><span> recherche</span></h2><div class="box"> ';




echo'<form id="universe" method="post" action="exchange.php?type=rech_mot">
			<div class="inform">


						<input type="hidden" name="action" value="recherche" accesskey="s" />
						<label class="conl">recherche :    <br /><input type="text" name="mot" size="20" maxlength="20" ><br /></label>


			</div>



			<p><input type="submit"   /></p>
		</form>

	</div>
</div> ';








if(isset($_POST['mot']))
{
$mot=stripslashes(pun_trim($_POST['mot']));

///pagination
$result = $db->query('SELECT date, user_id, pos_galaxie, pos_sys, pos_pos, player, title, body, MATCH (player,title,body)
          AGAINST ('.$mot.' IN BOOLEAN MODE) AS score
		FROM '.$pun_config["ogspy_prefix"].'exchange_user
		WHERE user_id=\''.$pun_user['id_ogspy'].'\' AND
		MATCH (player,title,body) AGAINST ('.$mot.' IN BOOLEAN MODE)
		  ');
/// nb de pages
$num_reponse = $db->num_rows($result);

$num_pages = ceil(($num_reponse + 1) / 10);
$p = (!isset($_GET['p']) || $_GET['p'] <= 1 || $_GET['p'] > $num_pages) ? 1 : $_GET['p'];
$start_from = 10  * ($p - 1);
// gernerer les liens
$paging_links = 'Page : '.paginate($num_pages, $p, 'exchange.php?type=joueur');


// fin pagination




echo'
    <div class="blockform">
	<h2><span>Resultat</span></h2>
	<div class="box">
	';
 echo ' '.$paging_links.' ';


$sql = 'SELECT date, user_id, pos_galaxie, pos_sys, pos_pos, player, title, body, MATCH (player,title,body)
          AGAINST ('.$mot.' IN BOOLEAN MODE) AS score
		FROM '.$pun_config["ogspy_prefix"].'eXchange_User
		WHERE user_id=\''.$pun_user['id_ogspy'].'\' AND
		MATCH (player,title,body) AGAINST ('.$mot.' IN BOOLEAN MODE)
		   LIMIT '.$start_from.', 10  ';


	    $result2 = $db->query($sql);
	    while($message = $db->fetch_assoc($result2))
{
echo' <fieldset>
	<legend>Message de '.$message['player'].' '.$message['pos_galaxie'].':'.$message['pos_sys'].':'.$message['pos_pos'].'   <b>'.stripslashes($message['title']).'</b></legend>

	'.stripslashes(($message['body'])).'
	</fieldset>

	<br>';





}









}


}

?>

<?php if ( $_GET['type']=="rech_joueur" )

{
if (isset($_POST['nom'])) {
$joueur=stripslashes(pun_trim($_POST['nom']));

///pagination
$result = $db->query('SELECT * FROM '.$pun_config["ogspy_prefix"].'eXchange_User WHERE  user_id=\''.$pun_user['id_ogspy'].'\'  and player=\''.$joueur.'\'  ');
/// nb de pages
$num_reponse = $db->num_rows($result);
$num_pages = ceil(($num_reponse + 1) / 10);
$p = (!isset($_GET['p']) || $_GET['p'] <= 1 || $_GET['p'] > $num_pages) ? 1 : $_GET['p'];
$start_from = 10  * ($p - 1);
// gernerer les liens
$paging_links = 'Page : '.paginate($num_pages, $p, 'exchange.php?type=joueur');


// fin pagination




echo'
    <div class="blockform">
	<h2><span>Resultat</span></h2>
	<div class="box">
	';
 echo ' '.$paging_links.' ';


$sql = 'SELECT * FROM '.$pun_config["ogspy_prefix"].'eXchange_User WHERE  user_id=\''.$pun_user['id_ogspy'].'\'  and player=\''.$joueur.'\' ORDER BY date desc LIMIT '.$start_from.', 10  ';


	    $result2 = $db->query($sql);
	    while($message = $db->fetch_assoc($result2))
{
echo' <fieldset>
	<legend>Message de '.$message['player'].' '.$message['pos_galaxie'].':'.$message['pos_sys'].':'.$message['pos_pos'].'   <b>'.stripslashes($message['title']).'</b></legend>

	'.stripslashes(($message['body'])).'
	</fieldset>

	<br>';





}







    echo ' '.$paging_links.'</div></div>';
}










echo'


        <div class="blockform">
	<h2><span>Rechercher un utilisateur</span></h2>
	<div class="box">
	<form id="joueur" method="post" action="exchange.php?type=rech_joueur">
		<div class="inform">


	<fieldset>
				<legend>Chercher et trier les utilisateurs</legend>

				<div class="infldset">

					<label class="conl">Pseudo
					<br><select name="nom">';


						  $sql = 'SELECT distinct(player) FROM '.$pun_config["ogspy_prefix"].'eXchange_User WHERE  user_id=\''.$pun_user['id_ogspy'].'\'  ORDER BY player asc  ';


	    $result2 = $db->query($sql);
	    while($message = $db->fetch_assoc($result2))
{
 echo' <option value="'.stripslashes(pun_trim($message['player'])).'">'.stripslashes(pun_trim($message['player'])).'</option>';


  }





					echo'</select>
					<br></label>

					<p class="clearb">Choisir le nom du joueur qdont vous souhaitez retrouver le message.</p>
				</div>
			</fieldset>













		</div>
		<p><input type="submit" name="search" value="Envoyer" accesskey="s" /></p>
	</form>

	</div>

</div>


';








}

?>




<?php   if ( $_GET['type']=="ally" )

{
echo'<div class="blockform"><h2><span>Message alliance</span></h2>
 <div class="box">';


 ///pagination
$result = $db->query('SELECT * FROM '.$pun_config["ogspy_prefix"].'eXchange_Ally WHERE  user_id=\''.$pun_user['id_ogspy'].'\'   ');
/// nb de pages
$num_reponse = $db->num_rows($result);
$num_pages = ceil(($num_reponse + 1) / 10);
$p = (!isset($_GET['p']) || $_GET['p'] <= 1 || $_GET['p'] > $num_pages) ? 1 : $_GET['p'];
$start_from = 10  * ($p - 1);
// gernerer les liens
$paging_links = 'Page : '.paginate($num_pages, $p, 'exchange.php?type=ally');
// fin pagination


$sql = 'SELECT * FROM '.$pun_config["ogspy_prefix"].'eXchange_Ally WHERE  user_id=\''.$pun_user['id_ogspy'].'\'  ORDER BY date desc  LIMIT '.$start_from.', 10   ';
 echo ' '.$paging_links.'';


	    $result2 = $db->query($sql);
	    while($message = $db->fetch_assoc($result2))
{
echo'
<br>
<fieldset>
<legend>Message de '.$message['player'].' <b>'.stripslashes($message['alliance']).' </b>
</legend>
'.stripslashes($message['body']).'
</fieldset>

 ';

}

echo'  '.$paging_links.'</div></div>';








}
if ( $_GET['type']=="joueur" )

{
  

 ///pagination
$result = $db->query('SELECT * FROM '.$pun_config["ogspy_prefix"].'eXchange_User WHERE  user_id=\''.$pun_user['id_ogspy'].'\'    ');
/// nb de pages
$num_reponse = $db->num_rows($result);
$num_pages = ceil(($num_reponse + 1) / 10);
$p = (!isset($_GET['p']) || $_GET['p'] <= 1 || $_GET['p'] > $num_pages) ? 1 : $_GET['p'];
$start_from = 10  * ($p - 1);
// gernerer les liens
$paging_links = 'Page : '.paginate($num_pages, $p, 'exchange.php?type=joueur');
// fin pagination

?>

<div class="blockform"><h2><span>Message joueurs</span></h2>
 <div class="box">
<?php
 echo ' '.$paging_links.'';

$sql = 'SELECT * FROM '.$pun_config["ogspy_prefix"].'eXchange_User WHERE  user_id=\''.$pun_user['id_ogspy'].'\'  ORDER BY date desc  LIMIT '.$start_from.', 10  ';


	    $result2 = $db->query($sql);
	    while($message = $db->fetch_assoc($result2))
{
echo'
<br>
<fieldset>
<legend>Message de '.$message['player'].' '.$message['pos_galaxie'].':'.$message['pos_sys'].':'.$message['pos_pos'].'   <b>'.stripslashes($message['title']).' </b>
</legend>
'.stripslashes($message['body']).'
</fieldset> ';

}
     echo ' '.$paging_links.'</div></div>';






?>


<?php
}
}
}

?>



  <div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>

    </div>
<?php


require PUN_ROOT.'footer.php';