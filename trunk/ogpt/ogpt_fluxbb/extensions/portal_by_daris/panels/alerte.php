<?php
$panel['title'] = 'Qui nous sonde ?';
// nb de jour pour les stats evite d'avoir des rapport vieux et ininteressant
$now=$forum_config['o_ogameportail_pan_qns_day'];
// limit date
$date=time()-(60*60*24*$now); ?>
<ul class="alerte">  
<?php
 // cacul nb de d'espionnage dans la base
 $request ='select * from '.$forum_config['o_ogameportail_ogspy_prefixe'].'QuiMeSonde ';
 $result = $forum_db->query($request);
 $esp_total = $forum_db->num_rows($result); 

 //joueur le plus espionné:
 echo '<li><strong>Le plus espionn&eacute; :</strong><li>  ';
 $request = "SELECT datadate , user_name, count(*) as nb FROM   ".$forum_config['o_ogameportail_ogspy_prefixe']."QuiMeSonde  ,  ".$forum_config['o_ogameportail_ogspy_prefixe']."user WHERE  (user_id=sender_id) and (datadate > $date) GROUP BY sender_id ORDER BY nb DESC LIMIT 0, ".$forum_config['o_ogameportail_pan_qns_pspy'];
 $result = $forum_db->query($request);
 while($maj = $forum_db->fetch_assoc($result))
 {
 	echo '<li>'.$maj['user_name'].' ( <b>'.round($maj['nb'] / $esp_total * 100,1).'</b>% )</li>';
 }

 // joueur le moins espionné
 echo '<li><strong> Le moins espionn&eacute; :</strong></li>';
 $request = "SELECT datadate ,user_name, count(*) as nb FROM ".$forum_config['o_ogameportail_ogspy_prefixe']."QuiMeSonde , ".$forum_config['o_ogameportail_ogspy_prefixe']."user WHERE  user_id=sender_id and (datadate > $date) GROUP BY sender_id ORDER BY nb aSC limit 0, ".$forum_config['o_ogameportail_pan_qns_mspy'];
 $result = $forum_db->query($request);
 while($maj = $forum_db->fetch_assoc($result))
 {
 	echo '<li>'.$maj['user_name'].' ( <strong>'.round($maj['nb'] / $esp_total * 100,1).'</strong>% )</li>';
 }
 echo '<p></p>';
 // joueurs ls plus actifs
 echo '<li><strong>Joueurs actifs :</strong></li>';
 $request = "SELECT datadate , user_name, joueur , count(*) as nb FROM ".$forum_config['o_ogameportail_ogspy_prefixe']."QuiMeSonde , ".$forum_config['o_ogameportail_ogspy_prefixe']."user WHERE  user_id=sender_id and (datadate > $date) GROUP BY joueur ORDER BY nb desc limit 0, ".$forum_config['o_ogameportail_pan_qns_topjoueur'];
 $result = $forum_db->query($request);
 while($maj1 = $forum_db->fetch_assoc($result))
 {
 	echo '<li><a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj1['joueur'].'&type=2">'.$maj1['joueur'].'</a> ( <strong>'.round($maj1['nb'] / $esp_total * 100,1).'</strong>% )</li>';
 }
echo '<p></p>';


 // alliances ls plus actifs :
 echo '<li><strong>Alliances actives :</strong></li> ';
 $request ="SELECT datadate, user_name, alliance, count(*) as nb FROM ".$forum_config['o_ogameportail_ogspy_prefixe']."QuiMeSonde, ".$forum_config['o_ogameportail_ogspy_prefixe']."user WHERE  user_id=sender_id and (datadate > $date) GROUP BY alliance ORDER BY nb desc limit 0, ".$forum_config['o_ogameportail_pan_qns_topally'];
 $result = $forum_db->query($request);
 while($maj2 = $forum_db->fetch_assoc($result))
 {
 	echo ' <li><a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$maj2['alliance'].'&type=1">'.$maj2['alliance'].'</a> ( <strong>'.round($maj2['nb'] / $esp_total * 100,1).'</strong>% )</li>';
}
 echo '<p></p>';
 
 
 // dernier joueur espionné:
 echo '<li><strong>Dernier espionnage :</strong></li> ';
 $request ="select * from ".$forum_config['o_ogameportail_ogspy_prefixe']."QuiMeSonde ORDER BY datadate desc  LIMIT 0, ".$forum_config['o_ogameportail_pan_qns_lastspy'];
 $result = $forum_db->query($request);
 while($deresp = $forum_db->fetch_assoc($result))
 {
 echo '<li><a href="'.FORUM_ROOT.'extensions/ogame_portail/vue/recherche.php?nom='.$deresp['joueur'].'&type=2">'.$deresp['joueur'].'</a> &agrave;  '.date("H:i" ,$deresp['datadate']).' le '.date("d-m" ,$deresp['datadate']).'</li>';
 }
echo '<p></p>';
 echo '<li><strong>Total espionnage : </strong>'.$esp_total.'</li><li>Stats g&eacute;n&eacute;r&eacute;es sur les '.$now.' derniers jours...</li>'; ?>



</ul>


