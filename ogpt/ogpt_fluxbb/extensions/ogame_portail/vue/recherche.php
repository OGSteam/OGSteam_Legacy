<?php


/***********************************************************************


************************************************************************/


if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', '../../../');
require FORUM_ROOT.'include/common.php';

/// appel du fichier fonction du portail :
require FORUM_ROOT.'extensions/ogame_portail/include/fonction.php';


// Load the viewforum.php language file
require FORUM_ROOT.'lang/'.$forum_user['language'].'/forum.php';



// Setup breadcrumbs
$forum_page['crumbs'] = array(
	array($forum_config['o_board_title'], forum_link($forum_url['index'])),
	forum_htmlencode($forum_url['index'])
);


define('FORUM_PAGE', 'recherche OGS');
define('FORUM_PAGE_TYPE', 'forum');
require FORUM_ROOT.'header.php';

// START SUBST - <!-- forum_main -->
ob_start();




/// filtre joueur non inscrit :
if ($forum_user['is_guest']) 
{message($lang_common['No view']);}


/// appel du filtre ratio +incrementation  la bdd utilisateur ( stat  possible ulterieurement)
// nombre de mois depuis l'inscription
$time=time();
/// 1 journée en seconde
$j=(60*60*24);
$jj=($time-$j);
/// il faut avoir poster dans la journée qui precede pour aceder aux mods ...
if (  $jj > $forum_user['last_post'] )

{ 
echo '<script> alert("Vous devez poster pour acceder a cette section") </script>';
message($lang_common['No view']);
}





// incrementation du ratio utilisateur ( pour statisqtique utlerieur
$forum_user['ratio']++;
$forum_db->query('UPDATE '.$forum_db->prefix.'users SET ratio='.$forum_user['ratio'].' WHERE id='.$forum_user['id']) or error('Unable to update users ratio', __FILE__, __LINE__, $db->error());



	
	
	
	
?>
<div class="main-head">
	<h1 class="hn"><span>Recherche OGS (ally-joueurs)</span></h1>
</div>
<?php


/// le type de recherche est selectionné  : ally ou joueur
   if (isset($_GET['type']))
{
/// filtre de la reponse


$_GET['type'] = trim($_GET['type']);
$nom = trim($_GET['nom']);

/// si c une recherche alliance
if ($_GET['type']==1)
{
?>
<div class="main-content topic">
		<div class="content-head">
			<h2 class="hn"><span>recherche alliance : <?php echo '<b>'.$nom.'</b>'; ?></span></h2>
		</div>


<table border="0" width="100%" id="table1">
	<tr>
		<td width="50%">
		<?php
		 echo '<li><b>Statistiques</b> : </li> ';
		 echo '<p></p> ';
		/// nom de l'alliance
		echo '<li> alliance : <b>'.$nom.'</b> </li>';
		///nombre de joueur
		 $request ='select count(distinct player) from '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe where ally=\''.$nom.'\' ';
 $result = $forum_db->query($request);
 list($nb_joueur1) = $forum_db->fetch_row($result);
 $nb_joueur= $nb_joueur1;
	 echo '<li>Nombre de joueur : <b>'.$nb_joueur.'</b></li> ';
	  echo '<p></p> ';
      
	   
	   /// recherche des stat point de l'ally 
	    $sql = 'SELECT  *  FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_ally_points   WHERE  ally=\''.$nom.'\'	order by datadate desc LIMIT 1   ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		
		 
		   echo '<li>point :  '.conv($maj2['rank']).'eme avec '.conv($maj2['points']).' points </li><li>(soit une moyenne de '.conv($maj2['points_per_member']).' par membre) </li>';   
		 
		}
	
	  /// recherche des stat flotte de l'ally 
	    $sql = 'SELECT  *  FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_ally_fleet   WHERE  ally=\''.$nom.'\'	order by datadate desc LIMIT 1   ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		 
		 
		   echo '<li>flotte :  '.conv($maj2['rank']).'eme avec '.conv($maj2['points']).' points </li><li>(soit une moyenne de '.conv($maj2['points_per_member']).' par membre) </li>';   
		 
		} 
       
		   /// recherche des stat recherche de l'ally 
	    $sql = 'SELECT  *  FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_ally_research   WHERE  ally=\''.$nom.'\'	order by datadate desc LIMIT 1   ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		 
		 
		   echo '<li>recherche :  '.conv($maj2['rank']).'eme avec '.conv($maj2['points']).' points </li><li>(soit une moyenne de '.conv($maj2['points_per_member']).' par membre) </li>';   
		 
		} 
		
	 echo '<li></li>';
	
	 echo '<a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/statistique.php">statistique</a>';

		
		
		
		
		?>
		
		
		
		</td>
		<td width="50%">
		   <li><b>Joueurs :</b> </li> 
		  <p></p>
		<?php
		
    $sql = 'SELECT  distinct player  FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe   WHERE  (ally=\''.$nom.'\')	order by player desc    ';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	    {
				$name=$maj['player'];
              echo '<li><b><a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$name.'&type=2">'.$name.'</a></b> ';
			  
		  $sql = 'SELECT  rank   FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_points   WHERE  player=\''.$name.'\'	order by datadate desc LIMIT 1   ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		  
		  
		  
		  echo ' ( <b>'.conv($maj2['rank']).'</b>eme place ) </li> ';
		}
		}	  
			  
			  
			  
			  
			 
	    

		
		
		?>
		</td>
	</tr>

	</table>
	

</div>

<div class="main-content topic">
		<div class="content-head">
			<h2 class="hn"><span>recherche alliance : galaxie
		</div>

<table align="center" border="0" id="table2">
	<tr>





	
		
		<?php
	 $sql = 'SELECT  *  FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe   WHERE  (ally=\''.$nom.'\')	order by galaxy  ,   system ,	row  desc';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	    {
				
			
				
              echo '<td>['.$maj['galaxy'].':'.$maj['system'].':'.$maj['row'].']</td> <td><a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj['player'].'&type=2"><b>'.$maj['player'].'</b></a></td><td> <a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj['ally'].'&type=1">'.$maj['ally'].'</a></td>'; 
			 
	 if ($maj['moon']== 1) {echo '<td>Lune</td>';} else {echo '<td>&nbsp;</td>';}   
	 
	echo '<td>'.date("d-m-Y" ,$maj['last_update']).' ('.date("H:i:s" ,$maj['last_update']).')</td></tr> ';		 
			  
			  
			  }	
		
		
		
		
		
		?>
		
</table>

		
		</div>
		
		
		
		
		
		


<?php
}
}


/// type de recherch ( a rassembler avec au dessus plus tard ..

   if (isset($_GET['type']))
{ 


/// si c une recherche joueur
if ($_GET['type']==2)
{
?>


<div class="main-content topic">
		<div class="content-head">
			<h2 class="hn">recherche joueur : <?php echo '<b>'.$nom.'</b>'; ?> </span></h2>
		</div>
<table border="0" width="100%" id="table1">
	<tr>
		<td width="35%">
		 <?php 
		 
		 
		 echo '<li><b>'.$nom.' </b>';
		 //// s'il fait partie d'une alliance on la nomme :)
		 $sql = 'SELECT  *  FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe   WHERE  (player=\''.$nom.'\')	limit 1';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	    {
		echo ' membre de l\'alliance <a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj['ally'].'&type=1">'.$maj['ally'].'</a>';
		echo' </li>';
				
	}
		/// stattistique
		echo' &nbsp;</li>';
		echo' <li><b>statistique</b> :</li>';
		echo'<li>';
		/// calcule des points geeral
		 $sql = 'SELECT  *  FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_points   WHERE  (player=\''.$nom.'\')	limit 1';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	    {
		echo ''.conv($maj['points']).' points au general';
		if ($maj['rank']>> 0) {echo '(  '.$maj['rank'].'eme )';} else {echo '<td>&nbsp;</td>';}
		echo' </li>'; 
				
	}
		
		
		
		
		/// calcule des points flotte	
		echo'<li>';
		
		 $sql = 'SELECT  *  FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_fleet   WHERE  (player=\''.$nom.'\')	limit 1';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	    {
		echo ''.conv($maj['points']).' points flotte';
		if ($maj['rank']>> 0) {echo '(  '.$maj['rank'].'eme )';} else {echo '<td>&nbsp;</td>';}
		echo' </li>'; 
				
	}
		
		
		
		 /// calcule des points recherche	
		echo'<li>';
		
		 $sql = 'SELECT  *  FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_research   WHERE  (player=\''.$nom.'\')	limit 1';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	    {
		echo ''.conv($maj['points']).' points recherche';
		if ($maj['rank']>> 0) {echo '(  '.$maj['rank'].'eme )';} else {echo '<td>&nbsp;</td>';}
		echo' </li>'; 
				
	}
		
	
		 	 echo' <li>&nbsp;</li>';
		 	 echo' <li>&nbsp;</li>';
		 	
			  echo '<li></li>';
			  
			  
			  
			  
 echo '<a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/statistique.php">statistique</a>';
	
	
		 //nb de lune
		 
		 
		 
		 
		 
		 
		  ?> 
	
		 </td>
		<td>
	
		<?php
			/// recherche des infos sur les planetes du gars :)
		 echo '<table><tr>';
	 $sql = 'SELECT  *  FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe   WHERE  (player=\''.$nom.'\')	order by galaxy  ,   system ,	row  desc';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	    {
				
			
				
              echo '<td>['.$maj['galaxy'].':'.$maj['system'].':'.$maj['row'].']</td> <td><a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj['player'].'&type=2"><b>'.$maj['player'].'</b></a></td><td> <a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj['ally'].'&type=1">'.$maj['ally'].'</a></td>'; 
			 
	 if ($maj['moon']== 1) {echo '<td>Lune</td>';} else {echo '<td>&nbsp;</td>';}   
	 
	echo '<td></td></tr> ';		 
			  
			  
			  }	
		
		
		
		
		
		?>
		
</table>

		
		
		
		
		</td>
	</tr>
</table>

</div> 






<?php

}
}
 ?>






<div class="main-content frm">
	
		<form  class="frm-newform" method="get" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/vue/recherche.php') ?>">
			
			<fieldset class="frm-set set1">
				
			

				<div class="frm-text">
					<label for="fld1">
						<span>Nom : </span>
					</label><br />
					<span class="fld-input"><input id="fld1" type="text" name="nom" size="25" maxlength="25" /></span>
				</div>
				<div class="frm-select">
					<label for="fld2">

						<span>type de recherche:</span>
					</label><br />
					<span class="fld-input"><select id="fld2" name="type">
						<option value="2">joueur</option>
						<option value="1">alliance</option>
						

						</select></span>
				</div>
			
			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" name="recherche" value="Submit" /></span>
			</div>
		</form>
	</div>







		
	
		


<?php

($hook = get_hook('vf_end')) ? eval($hook) : null;

$tpl_temp = trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->



require FORUM_ROOT.'footer.php';

