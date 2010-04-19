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


define('FORUM_PAGE', 'stat OGS');
define('FORUM_PAGE_TYPE', 'forum');
require FORUM_ROOT.'header.php';

// START SUBST - <!-- forum_main -->
ob_start();




/// filtre joueur non inscrit :
if ($forum_user['is_guest']) 
{message($lang_common['No view']);}

//calcul du ratio
/// nb de post / nb de recherche > ratio
$forum_user['ratio']++;
$ratio = ( ($forum_user['num_posts']*10  ) / $forum_user['ratio'] );
echo ' votre ratio est de '.$ratio.' ( attention la limite ratio est de '.forum_htmlencode($forum_config['o_ogameportail_ratio']).' => pour monter votre ratio, POSTEZ !)';


/// si ratio positif on incremente la bdd
if ( $ratio > $forum_config['o_ogameportail_ratio'])
{


$forum_db->query('UPDATE '.$forum_db->prefix.'users SET ratio='.$forum_user['ratio'].' WHERE id='.$forum_user['id']) or error('Unable to update users ratio', __FILE__, __LINE__, $db->error());
}

/// si ratio negatif : redirection
if ( $ratio < $forum_config['o_ogameportail_ratio'])
{
echo ' <li>RATIO NEGATIF DESOLE</li>';

message($lang_common['No view']);
}

	
	
/// reponse de la requete post
//http://ogameportail.free.fr/fluxbb/extensions/ogame_portail/vue/statistique.php?type=2&choix=1&date=1&statistique=Submit	
	


/// verification d'un post ( existence du "type" )
   if (isset($_GET['type']))
   {
/// si c une recherche alliance
if ($_GET['type']==1)
{

?>

<div class="main-content frm">
	
		<form  class="frm-newform" method="get" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/vue/statistique.php') ?>">
			
			<fieldset class="frm-set set1">
				
			

			
				<div class="frm-select">
					<label for="fld2">

						<span>type de recherche:</span>
					</label><br />
					<span class="fld-input"><select id="fld1" name="type">
						<option value="2">joueur</option>
						<option value="1">alliance</option>
						

						</select></span>
				</div>
				
				
				<div class="frm-select">
					<label for="fld2">

						<span>choix</span>
					</label><br />
					<span class="fld-input"><select id="fld2" name="choix">
						<option value="1">points</option>
						<option value="2">flotte</option>
						<option value="3">recherche</option>
						

						</select></span>
				</div>
				
				
				<div class="frm-select">
					<label for="fld2">

						<span>date :</span>
					</label><br />
					<span class="fld-input"><select id="fld3" name="date">
						<option value="1">date1</option>
						<option value="2">date2</option>
						<option value="3">date3</option>
						

						</select></span>
				</div>
				
				
			
			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" name="statistique" value="Submit" /></span>attention, stat non encore fonctionnelle( juste le top pointd joueur )
			</div>
		</form>
	</div>





<div class="main-head">
	<h1 class="hn"><span>Stat OGS (ally-joueurs)</span></h1>
</div>

<div class="main-content topic">
		<div class="content-head">
			<h2 class="hn"><span>Statistique </span></h2>
		</div>
		
	
	<table border="0" width="100%" id="table1">
	<tr>
		<td><b>Place</b></td>
		<td><b>Nom</b></td>
		<td><b>Alliance</b></td>
		<td><b>Points</b></td>
		<td><b>Date</b></td>
	</tr>
	<tr>
	
			
	<?php	
	 $sql = 'SELECT  *
	
	 FROM  
	 '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_points  
	where 
	DATADATE = (SELECT MAX(DATADATE) FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_points )
	order by rank asc
	 
	 ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		
		
		   echo '<td><li>'.$maj2['rank'].'</li></td>';   
		  echo '<td><li><a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj2['player'].'&type=2">'.$maj2['player'].'</a></li></td>'; 
		   echo '<td><li><a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj2['ally'].'&type=1">'.$maj2['ally'].'</a></li></td>';
		   echo '<td><li>'.conv($maj2['points']).'</li></td>';
		   echo '<td><li>'.date("d-m-Y" ,$maj2['datadate']).' ('.date("H\Hi" ,$maj2['datadate']).')</li></td>';
		  
		    
		    echo '</tr>'; 
		}	 
		?>
		
		
</table>


	
		
	
		
		
		
		
		
		
		
		
		</div>

























<?php
}

/// si c une recherche alliance
if ($_GET['type']==2)
{
echo ' <div class="main-content frm">

joueur
</div>
';
}

	}



/// si aucune demande passé par le formulaire ( $_get
 else
 { 







?>

<div class="main-content frm">
	
		<form  class="frm-newform" method="get" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/vue/statistique.php') ?>">
			
			<fieldset class="frm-set set1">
				
			

			
				<div class="frm-select">
					<label for="fld2">

						<span>type de recherche:</span>
					</label><br />
					<span class="fld-input"><select id="fld1" name="type">
						<option value="2">joueur</option>
						<option value="1">alliance</option>
						

						</select></span>
				</div>
				
				
				<div class="frm-select">
					<label for="fld2">

						<span>choix</span>
					</label><br />
					<span class="fld-input"><select id="fld2" name="choix">
						<option value="1">points</option>
						<option value="2">flotte</option>
						<option value="3">recherche</option>
						

						</select></span>
				</div>
				
				
				<div class="frm-select">
					<label for="fld2">

						<span>date :</span>
					</label><br />
					<span class="fld-input"><select id="fld3" name="date">
					<?php
					
					$sql = 'SELECT  DISTINCT(datadate) FROM   '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_points	order by datadate desc ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		
		   echo '<option value="'.$maj2['datadate'].'">'.date("d-m-Y" ,$maj2['datadate']).' ('.date("H\Hi" ,$maj2['datadate']).')</option>';
		 
		}	 
	?>
						

						</select></span>
				</div>
				
				
			
			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" name="statistique" value="Submit" /></span>attention, stat non encore fonctionnelle( juste le top pointd joueur )
			</div>
		</form>
	</div>





<div class="main-head">
	<h1 class="hn"><span>Stat OGS (ally-joueurs)</span></h1>
</div>

<div class="main-content topic">
		<div class="content-head">
			<h2 class="hn"><span>Statistique </span></h2>
		</div>
		
	
	<table border="0" width="100%" id="table1">
	<tr>
		<td><b>Place</b></td>
		<td><b>Nom</b></td>
		<td><b>Alliance</b></td>
		<td><b>Points</b></td>
		<td><b>Date</b></td>
	</tr>
	<tr>
	
			
	<?php	
	 $sql = 'SELECT  *
	
	 FROM  
	 '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_points  
	where 
	DATADATE = (SELECT MAX(DATADATE) FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_points )
	order by rank asc
	 
	 ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		
		
		   echo '<td><li>'.$maj2['rank'].'</li></td>';   
		  echo '<td><li><a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj2['player'].'&type=2">'.$maj2['player'].'</a></li></td>'; 
		   echo '<td><li><a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj2['ally'].'&type=1">'.$maj2['ally'].'</a></li></td>';
		   echo '<td><li>'.conv($maj2['points']).'</li></td>';
		   echo '<td><li>'.date("d-m-Y" ,$maj2['datadate']).' ('.date("H\Hi" ,$maj2['datadate']).')</li></td>';
		  
		    
		    echo '</tr>'; 
		}	 
		?>
		
		
</table>


	
		
	
		
		
		
		
		
		
		
		
		</div>





		
	
		


<?php

}

($hook = get_hook('vf_end')) ? eval($hook) : null;

$tpl_temp = trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->



require FORUM_ROOT.'footer.php';

