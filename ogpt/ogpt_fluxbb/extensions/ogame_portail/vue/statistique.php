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


/// filtre des divers q_get

 if (isset($_GET['type']))
{
$_GET['type'] = trim($_GET['type']);
}

 if (isset($_GET['choix']))
{
$_GET['choix'] = trim($_GET['choix']);
/// tri de la fn get choix
$explode=$_GET['choix'];

list($choix, $date) = explode("-",$explode);


}

 if (isset($_GET['date']))
{

// fonction n'exisant plus pour le mioment
$_GET['date'] = trim($_GET['date']);
}









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

<table width="100%">
	<tr>
		<td>


<div class="main-content frm">
	
		<form  class="frm-newform" method="get" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/vue/statistique.php') ?>">
			
			<fieldset class="frm-set set1">
				
			

			
				<div class="frm-select">
					<label for="fld2">

						<span>type de recherche:</span>
					</label><br />
					<span class="fld-input"><select id="fld1" name="type">
					
						<option value="1">alliance</option>
						

						</select></span>
				</div>
				
				
				<div class="frm-select">
					<label for="fld2">

							<span>choix :</span>
					</label><br />
					<span class="fld-input"><select id="fld2" name="choix">
					<?php
					/// en premier couix , l'option choisi si elle existe
					
					 if (isset($_GET['choix']))
{
if ($_GET['type']==1)
{

echo '<option value="'.$choix.'-'.$date.'"><b>points</b> le '.date("d-m-Y" ,$date).' ('.date("H\Hi" ,$date).')';
}
}					
					
					
					///points
					$sql = 'SELECT  DISTINCT(datadate) FROM   '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_ally_points	order by datadate desc ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		
		   echo '<option value="rank_ally_points-'.$maj2['datadate'].'"><b>points</b> le '.date("d-m-Y" ,$maj2['datadate']).' ('.date("H\Hi" ,$maj2['datadate']).')</option>';
		 
		}
		///flotte
		$sql = 'SELECT  DISTINCT(datadate) FROM   '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_ally_fleet	order by datadate desc ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		
		   echo '<option value="rank_ally_fleet-'.$maj2['datadate'].'"><b>flotte</b> le '.date("d-m-Y" ,$maj2['datadate']).' ('.date("H\Hi" ,$maj2['datadate']).')</option>';
		 
		}	 
		///recherche
		$sql = 'SELECT  DISTINCT(datadate) FROM   '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_ally_research	order by datadate desc ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		
		   echo '<option value="rank_ally_research-'.$maj2['datadate'].'"><b>recherche</b> le '.date("d-m-Y" ,$maj2['datadate']).' ('.date("H\Hi" ,$maj2['datadate']).')</option>';
		 
		}	 
		
		
			 
	?>
	
						

						</select></span>
				</div>
				
				
			
			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" name="statistique" value="Submit" /></span>
			</div>
		</form>
	</div>





	
	</td>
		<td>
		
<div class="main-content frm">
	
		<form  class="frm-newform" method="get" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/vue/statistique.php') ?>">
			
			<fieldset class="frm-set set1">
				
			

			
				<div class="frm-select">
					<label for="fld2">

						<span>type :</span>
					</label><br />
					<span class="fld-input"><select id="fld1" name="type">
						<option value="2">joueur</option>
					
						

						</select></span>
				</div>
				
				
				
				
				
				<div class="frm-select">
					<label for="fld2">

						<span>choix :</span>
					</label><br />
					<span class="fld-input"><select id="fld2" name="choix">
					<?php
					/// en premier couix , l'option choisi si elle existe
					
					 if (isset($_GET['choix']))
{
if ($_GET['type']==2)
{
echo '<option value="'.$choix.'-'.$date.'"><b>points</b> le '.date("d-m-Y" ,$date).' ('.date("H\Hi" ,$date).')';
}
}					
					
					
					///points
					$sql = 'SELECT  DISTINCT(datadate) FROM   '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_points	order by datadate desc ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		
		   echo '<option value="rank_player_points-'.$maj2['datadate'].'"><b>points</b> le '.date("d-m-Y" ,$maj2['datadate']).' ('.date("H\Hi" ,$maj2['datadate']).')</option>';
		 
		}
		///flotte
		$sql = 'SELECT  DISTINCT(datadate) FROM   '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_fleet	order by datadate desc ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		
		   echo '<option value="rank_player_fleet-'.$maj2['datadate'].'"><b>flotte</b> le '.date("d-m-Y" ,$maj2['datadate']).' ('.date("H\Hi" ,$maj2['datadate']).')</option>';
		 
		}	 
		///recherche
		$sql = 'SELECT  DISTINCT(datadate) FROM   '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_player_research	order by datadate desc ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		
		   echo '<option value="rank_player_research-'.$maj2['datadate'].'"><b>recherche</b> le '.date("d-m-Y" ,$maj2['datadate']).' ('.date("H\Hi" ,$maj2['datadate']).')</option>';
		 
		}	 
		
		
			 
	?>
	
						

						</select></span>
				</div>
				
				
			
			</fieldset>
			<div class="frm-buttons">
				<span class="submit"><input type="submit" name="statistique" value="Submit" /></span>
			</div>
		</form>
	</div>		
		
		
		
		</td>
	</tr>
</table>
	
<?php
		
		
		
		
		/// tableau pour juoeur
		
if (isset($_GET['type']))	
{	
		
if ($_GET['type']==2)
{







?>

<div class="main-head">
	<h1 class="hn"><span>Stat OGS (ally-joueurs)</span></h1>
</div>

<div class="main-content topic">
		<div class="content-head">
		
			
		</div><h2 class="hn"><span>Statistique joueur</span></h2>
		
	
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
	 $sql = 'SELECT  * FROM  
	 '.$forum_config['o_ogameportail_ogspy_prefixe'].''.$choix.'  
	where 
	DATADATE = '.$date.'
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

	}	

		
		
	
	
		/// tableau pour juoeur
		
if (isset($_GET['type']))	
{	
		
if ($_GET['type']==1)
{
?>	
	<div class="main-head">
	<h1 class="hn"><span>Stat OGS (ally-joueurs)</span></h1>
</div>

<div class="main-content topic">
		<div class="content-head">
		
			
		</div><h2 class="hn"><span>Statistique alliance</span></h2>
		
	
	<table border="0" width="100%" id="table1">
	<tr>
		<td><b>Place</b></td>
		<td><b>Alliance</b></td>
		<td><b>points</b></td>
		<td><b>point par membre</b></td>
		<td><b>Date</b></td>
	</tr>
<tr>


<tr>
	
			
	<?php	
	 $sql = 'SELECT  * FROM  
	 '.$forum_config['o_ogameportail_ogspy_prefixe'].''.$choix.'  
	where 
	DATADATE = '.$date.'
	order by rank asc
	 
	 ';
	    $result2 = $forum_db->query($sql);
	    while($maj2 = $forum_db->fetch_assoc($result2))
		{
		
		
		   echo '<td><li>'.$maj2['rank'].'</li></td>';   
		  echo '<td><li><a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj2['ally'].'&type=1">'.$maj2['ally'].'</a>   ('.$maj2['number_member'].')</li></td>'; 
		   echo '<td><li>'.conv($maj2['points']).'</li></td>';
		   echo '<td><li>'.conv($maj2['points_per_member']).'</li></td>';
		   echo '<td><li>'.date("d-m-Y" ,$maj2['datadate']).' ('.date("H\Hi" ,$maj2['datadate']).')</li></td>';
		  
		    
		    echo '</tr>'; 
		}	 
		?>







</table>
</div>

<?php
	}
	}		
		
		
		
		
		
		
		




($hook = get_hook('vf_end')) ? eval($hook) : null;

$tpl_temp = trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->



require FORUM_ROOT.'footer.php';

