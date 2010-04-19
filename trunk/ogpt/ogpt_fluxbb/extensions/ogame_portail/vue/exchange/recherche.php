










   
    <div class="main-head">
	<h1 class="hn"><span>recherche des messages </span></h1>
</div>

<div class="main-content frm">
	<div class="content-head">
		<h2 class="hn"><span>
        <?php  if ( $forum_user['ogs_user_id'] ==  0 ) { echo '   votre acces ogs via le forum ne semble pas bon '; } ?>
        
        </span></h2>
	</div>

	
	
     
	<form id="afocus" class="frm-newform" method="post" accept-charset="utf-8" action="<?php echo forum_link('extensions/ogame_portail/vue/exchange.php') ?>?recherche=foo">
	
		
		<fieldset class="frm-set set1"><div class="hidden">
				<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link('extensions/ogame_portail/vue/exchange.php').'?recherche=foo') ?>" />
			</div>
			
			
			<div class="frm-select">
					<label for="fld2">

						<span>Nom du joueur :</span>
					</label><br />
					<span class="fld-input"><select id="fld2" name="player">
                    
                    
                    
						 <?php
                  $sql = 'SELECT distinct(player) FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'eXchange_User WHERE  user_id=\''.$forum_user['ogs_user_id'].'\'  ORDER BY player asc  ';

 
	    $result2 = $forum_db->query($sql);
	    while($message = $forum_db->fetch_assoc($result2))
{  
 echo' <option value="'.stripslashes($message['player']).'">'.stripslashes($message['player']).'</option>';
  
                    
  }
  
  ?>                  
						

						</select></span>
				</div>	

				
			
		
				
				
				
		

		<div class="frm-buttons">
			<span class="submit"><input type="submit" name="nom" value="Submit" /></span>
		
		</div>
	</form>
	</div>
    
    
    
    
    
    
    
    
    
    
    <?php
	
	if(isset($_POST['nom']) )	
	

{
///securisation de nom et mdp
$nom=trim(stripslashes($_POST['player']));


?>

   <div class="main-head">
	<h1 class="hn"><span>Messages joueur </span></h1>
</div>

<?php 
$sql = 'SELECT * FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'eXchange_User WHERE  user_id=\''.$forum_user['ogs_user_id'].'\'  and player=\''.$nom.'\' ORDER BY date desc  ';

 
	    $result2 = $forum_db->query($sql);
	    while($message = $forum_db->fetch_assoc($result2))
{
echo' <div class="main-content frm">
	<div class="content-head">
		<h2 class="hn"><span>Message de '.$message['player'].' '.$message['pos_galaxie'].':'.$message['pos_sys'].':'.$message['pos_pos'].'   <b>'.stripslashes($message['title']).' </b>
        
        
        </span></h2>
	</div>
	
	'.stripslashes(($message['body'])).'
	
	
	</div>';




}











}