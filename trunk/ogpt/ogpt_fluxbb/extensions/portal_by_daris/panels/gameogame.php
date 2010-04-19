<?php


$panel['title'] = 'GameOgame'; // title for panel
 




/// fonction a placer en include
//fn 1
function convNumber($number)
{
	return(number_format($number,0,'.',' '));
}

  //fn2

function userNameById ( $id )
{
	global $forum_db;
	global $forum_config;
	$sql = 'SELECT user_name FROM   '.$forum_config['o_ogameportail_ogspy_prefixe'].'user WHERE user_id=\''.(int)$id.'\'';
	$result = $forum_db->query($sql);
        list($name) = $forum_db->fetch_row($result);
        if ($name=='') $name="??????????";
	return($name);
}






///	fin des fonction a placer en include






?>
<MARQUEE behavior="scroll" align="center" direction="up" height="200" scrollamount="1" scrolldelay="1" onmouseover='this.stop()' onmouseout='this.start()'>
 <ul class="gameogame"> 
  <li><b>top joueur</b></li>>        <?php
 

     $sql = 'SELECT  g.sender,g.id , sum(g.points) AS total, count(g.id) AS nb  FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'game  AS g LEFT JOIN '.$forum_config['o_ogameportail_ogspy_prefixe'].'game_users AS u ON u.id=g.sender WHERE u.user=\'1\' GROUP BY g.sender ORDER BY total DESC, g.sender ASC limit '.$forum_config['o_ogameportail_pan_gog'].'';
   $result = $forum_db->query($sql);




$i = 1;

 while(   $val = $forum_db->fetch_assoc($result))
{
          $name = userNameById($val['sender']);
	echo '<li>'.$i.') <b>'.$name.'</b>:'.convNumber($val['total']).'</li>';
         	$i++;
} 
?>
 
 <li>.</li>
 <li><b> top rapport </b></li>
 <?php
 
 
     ///top 10 rapport
 
 $sql = 'SELECT g.date, g.sender, g.id, g.points  FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'game  AS g LEFT JOIN '.$forum_config['o_ogameportail_ogspy_prefixe'].'game_users  AS u ON u.id=g.sender WHERE u.user=\'1\' ORDER BY g.points DESC, g.date DESC LIMIT '.$forum_config['o_ogameportail_pan_gog'].'';
  $result = $forum_db->query($sql);



$i = 1;

 while(   $val = $forum_db->fetch_assoc($result))
{
       $name = userNameById($val['sender']);
	echo '<li>'.$i.') <b>'.$name.'</b>('.convNumber($val['points']).')</li>';
         	$i++;
}


 
 
 
   ?>
  <li>.</li>
 <li><b> top recyclage </b></li>
 <?php
 
 
     ///top 10 recyclage
 
 $sql = 'SELECT g.date, g.sender, g.id, g.recycleM+g.recycleC AS recyclage FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'game  AS g LEFT JOIN '.$forum_config['o_ogameportail_ogspy_prefixe'].'game_users AS u ON u.id=g.sender WHERE u.user=\'1\' ORDER BY recyclage DESC LIMIT '.$forum_config['o_ogameportail_pan_gog'].'';
  $result = $forum_db->query($sql);



$i = 1;

 while(   $val = $forum_db->fetch_assoc($result))
{
       $name = userNameById($val['sender']);
	echo '<li>'.$i.') <b>'.$name.'</b>('.convNumber($val['recyclage']).')</li>>';
         	$i++;
}
 
 
 
 
 
 
    ?>
  <li>.</li>
 <li><b> top pillage </b></li>
 <?php
 
 
     ///top 10 pillage
 
 $sql = 'SELECT g.id, g.sender, g.pillageM+g.pillageC+g.pillageD AS total, g.date FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'game  AS g, '.$forum_config['o_ogameportail_ogspy_prefixe'].'game_users AS u WHERE g.sender=u.id AND u.user=\'1\' ORDER BY total DESC, g.sender ASC LIMIT '.$forum_config['o_ogameportail_pan_gog'].'';
  $result = $forum_db->query($sql);



$i = 1;

 while(   $val = $forum_db->fetch_assoc($result))
{
       $name = userNameById($val['sender']);
	echo '<li>'.$i.') <b>'.$name.'</b>('.convNumber($val['total']).')</li>';
         	$i++;
}
 
 
 
 
 
 

 
  ?>
 </ul>
 </MARQUEE>
 


 <?php








