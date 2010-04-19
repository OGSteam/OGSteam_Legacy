<?php


$panel['title'] = 'TOP <=> FLOP '; // title for panel
?>
<ul class="alonestat"> 

<?php

///desc

 if ($forum_config['o_ogameportail_pan_topflop_order'] == '1')
 
   {

   /// les 4 ayant le plus de maj
$sql = 'SELECT
distinct(P.player) as pplayer, (PF1.POINTS - PF2.POINTS) as PROGRESSION, PF1.POINTS as total 
FROM   '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_members as P
LEFT JOIN '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_members as PF1 on PF1.player = P.player
LEFT JOIN '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_members as PF2 on PF2.player = PF1.player
WHERE

PF1.DATADATE = (SELECT MAX(DATADATE) FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_members)
AND
PF2.DATADATE = (SELECT MAX(DATADATE) FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_members WHERE DATADATE <> PF1.DATADATE)
ORDER BY PROGRESSION DESC ';

$result = $forum_db->query($sql);
while($maj = $forum_db->fetch_assoc($result))
{
  

               if    ($maj['PROGRESSION']<-1) { $color='red'; }
               elseif ($maj['PROGRESSION']>1) { $color='green';  }
               else  { $color='black';  }
              echo '<li><b>'.$maj['pplayer'].'</b> : <font color=\''.$color.'\'>'.$maj['PROGRESSION'].'</font></li>';
}


   }


    ///  asc
    
    

 if ($forum_config['o_ogameportail_pan_topflop_order'] == '0')
 
   {

   /// les 4 ayant le plus de maj
$sql = 'SELECT
distinct(P.player) as pplayer, (PF1.POINTS - PF2.POINTS) as PROGRESSION, PF1.POINTS as total
FROM   '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_members as P
LEFT JOIN '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_members as PF1 on PF1.player = P.player
LEFT JOIN '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_members as PF2 on PF2.player = PF1.player
WHERE
PF1.DATADATE = (SELECT MAX(DATADATE) FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_members)
AND
PF2.DATADATE = (SELECT MAX(DATADATE) FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'rank_members WHERE DATADATE <> PF1.DATADATE)
ORDER BY PROGRESSION asc  ';

$result = $forum_db->query($sql);
while($maj = $forum_db->fetch_assoc($result))
{
  

               if    ($maj['PROGRESSION']<-1) { $color='red'; }
               elseif ($maj['PROGRESSION']>1) { $color='green';  }
               else  { $color='black';  }
              echo '<li><b>'.$maj['pplayer'].'</b> : <font color=\''.$color.'\'>'.$maj['PROGRESSION'].'</font> </li>';
}


   }
echo '</ul>';
