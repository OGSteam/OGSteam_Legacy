 <?php
 
 ?>
    <div class="main-head">
	<h1 class="hn"><span>Messages alliance  <?php  if ( $forum_user['ogs_user_id'] ==  0 ) { echo '   votre acces ogs via le forum ne semble pas bon '; } ?></span></h1>
</div>

<?php 
$sql = 'SELECT * FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'eXchange_Ally WHERE  user_id=\''.$forum_user['ogs_user_id'].'\'  ORDER BY date desc  ';

 
	    $result2 = $forum_db->query($sql);
	    while($message = $forum_db->fetch_assoc($result2))
{
echo' <div class="main-content frm">
	<div class="content-head">
		<h2 class="hn"><span>Message de '.$message['player'].'    (<b>'.stripslashes($message['alliance']).' </b>)
        
        
        </span></h2>
	</div>
	
	'.stripslashes($message['body']).'
	
	
	</div>';




}


?>