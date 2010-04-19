<?php


$panel['title'] = 'Top mise a jour'; // title for panel
?>

<ul class="top_maj"> 
<?php
 /// cacul nb de systeme dans la base
 $request ='select count(*) from  '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe ';
 $result = $forum_db->query($request);
 list($total1) = $forum_db->fetch_row($result);
 $total= $total1;


  /// les 5 ayant le plus de maj
    $sql = 'SELECT user_name, count(*) as nb FROM  '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe , '.$forum_config['o_ogameportail_ogspy_prefixe'].'user WHERE  user_id=last_update_user_id GROUP BY last_update_user_id ORDER BY nb DESC LIMIT  '.$forum_config['o_ogameportail_pan_top_maj'].'';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	    {
              echo '<li>'.$maj['user_name'].' <br> <br /> : <b>'.round($maj['nb'] / $total * 100,1).'</b>%</li> ';
	    }

   ?>


