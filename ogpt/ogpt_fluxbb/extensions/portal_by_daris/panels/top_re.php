<?php


$panel['title'] = 'Top espionnage'; // title for panel
?>

<ul class="top_re"> 
<?php


   


  /// les 4 ayant le plus de maj
    $sql = 'SELECT user_name, count(*) as nb FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'parsedspy , '.$forum_config['o_ogameportail_ogspy_prefixe'].'user WHERE  user_id=sender_id GROUP BY sender_id ORDER BY nb DESC LIMIT '.$forum_config['o_ogameportail_pan_top_spy'].'';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	    {
              echo '<li>'.$maj['user_name'].' : <b>'.round($maj['nb'] / $nb_spy * 100,1).'</b>% <li>';
}

if ($forum_config['o_ogameportail_pan_top_spy_total'] == '1')

          {
      /// cacul nb de rapport d'espionnage dans la base
 $request ='select count(*) from '.$forum_config['o_ogameportail_ogspy_prefixe'].'parsedspy ';
 $result = $forum_db->query($request);
 list($nb_spy1) = $forum_db->fetch_row($result);
 $nb_spy= $nb_spy1;


      echo '<p></p><li>Total spy :<b>'.$nb_spy.'</b></li> ';
      
          }


   ?>


