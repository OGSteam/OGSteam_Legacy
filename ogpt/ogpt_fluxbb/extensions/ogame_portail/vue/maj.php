<?php


/***********************************************************************


************************************************************************/


if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', '../../../');
require FORUM_ROOT.'include/common.php';


?>
<table cellspacing="0" style="border: 0px solid #405680; width:100px; border-spacing: 0px; height: 30px;">
  <tr>
  <td width="30px">G1
  <td>
  <?php
  
  /// pour la g1
 $time=time();
$a=($time-259200);
$b= ( $time-518400);  
$c= ( $time-777600);
$d= ( $time-1036800);
$e= ( $time-1296000);

  
  $sql = 'SELECT *  FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe WHERE  (row=1)  and (galaxy = 1)    ORDER BY system asc ';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
{
               if ( $maj['last_update'] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
			   if ( $maj['last_update'] >= $b and $maj['last_update'] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
			   if ( $maj['last_update'] >= $c and $maj['last_update'] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
			   if ( $maj['last_update'] >= $d and $maj['last_update'] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
			   if ( $maj['last_update'] >= $e and $maj['last_update'] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
			    if ( $maj['last_update'] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
				
			  
			  
			   
			 
			 
		
		
		}
  
  

   ?>
  </tr>
<tr>
  <td width="30px">G2
  <td>
  <?php
  
  /// pour la g2
 $time=time();
$a=($time-259200);
$b= ( $time-518400);  
$c= ( $time-777600);
$d= ( $time-1036800);
$e= ( $time-1296000);

  
  $sql = 'SELECT *  FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe WHERE  (row=1)  and (galaxy = 2)    ORDER BY system asc ';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	{
               if ( $maj['last_update'] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
			   if ( $maj['last_update'] >= $b and $maj['last_update'] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
			   if ( $maj['last_update'] >= $c and $maj['last_update'] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
			   if ( $maj['last_update'] >= $d and $maj['last_update'] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
			   if ( $maj['last_update'] >= $e and $maj['last_update'] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
			    if ( $maj['last_update'] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
				
			  
			  
			   
			 
			 
		
		
		}
  
  

   ?>
  </tr>  
  
  <tr>
  <td width="30px">G3
  <td>
  <?php
  
  /// pour la g3
 $time=time();
$a=($time-259200);
$b= ( $time-518400);  
$c= ( $time-777600);
$d= ( $time-1036800);
$e= ( $time-1296000);

  
  $sql = 'SELECT *  FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe WHERE  (row=1)  and (galaxy = 3)    ORDER BY system asc ';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	{
               if ( $maj['last_update'] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
			   if ( $maj['last_update'] >= $b and $maj['last_update'] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
			   if ( $maj['last_update'] >= $c and $maj['last_update'] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
			   if ( $maj['last_update'] >= $d and $maj['last_update'] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
			   if ( $maj['last_update'] >= $e and $maj['last_update'] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
			    if ( $maj['last_update'] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
				
			  
			  
			   
			 
			 
		
		
		}
  
  

   ?>
  </tr>
  <tr>
  <td width="30px">G4
  <td>
  <?php
  
  /// pour la g4
 $time=time();
$a=($time-259200);
$b= ( $time-518400);  
$c= ( $time-777600);
$d= ( $time-1036800);
$e= ( $time-1296000);

  
  $sql = 'SELECT *  FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe WHERE  (row=1)  and (galaxy = 4)    ORDER BY system asc ';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
{
               if ( $maj['last_update'] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
			   if ( $maj['last_update'] >= $b and $maj['last_update'] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
			   if ( $maj['last_update'] >= $c and $maj['last_update'] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
			   if ( $maj['last_update'] >= $d and $maj['last_update'] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
			   if ( $maj['last_update'] >= $e and $maj['last_update'] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
			    if ( $maj['last_update'] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
				
			  
			  
			   
			 
			 
		
		
		}
  
  

   ?>
  </tr>
  
  <tr>
  <td width="30px">G5
  <td>
  <?php
  
  /// pour la g1
 $time=time();
$a=($time-259200);
$b= ( $time-518400);  
$c= ( $time-777600);
$d= ( $time-1036800);
$e= ( $time-1296000);

  
  $sql = 'SELECT *  FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe WHERE  (row=1)  and (galaxy = 5)    ORDER BY system asc ';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	  {
               if ( $maj['last_update'] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
			   if ( $maj['last_update'] >= $b and $maj['last_update'] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
			   if ( $maj['last_update'] >= $c and $maj['last_update'] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
			   if ( $maj['last_update'] >= $d and $maj['last_update'] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
			   if ( $maj['last_update'] >= $e and $maj['last_update'] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
			    if ( $maj['last_update'] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
				
			  
			  
			   
			 
			 
		
		
		}
  
  

   ?>
  </tr>
  <tr>
  <td width="30px">G6
  <td>
  <?php
  
  /// pour la g6
 $time=time();
$a=($time-259200);
$b= ( $time-518400);  
$c= ( $time-777600);
$d= ( $time-1036800);
$e= ( $time-1296000);

  
  $sql = 'SELECT *  FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe WHERE  (row=1)  and (galaxy = 6)    ORDER BY system asc ';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	   {
               if ( $maj['last_update'] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
			   if ( $maj['last_update'] >= $b and $maj['last_update'] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
			   if ( $maj['last_update'] >= $c and $maj['last_update'] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
			   if ( $maj['last_update'] >= $d and $maj['last_update'] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
			   if ( $maj['last_update'] >= $e and $maj['last_update'] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
			    if ( $maj['last_update'] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
				
			  
			  
			   
			 
			 
		
		
		}
  
  

   ?>
  </tr>
  
  <tr>
  <td width="30px">G7
  <td>
  <?php
  
  /// pour la g7
 $time=time();
$a=($time-259200);
$b= ( $time-518400);  
$c= ( $time-777600);
$d= ( $time-1036800);
$e= ( $time-1296000);

  
  $sql = 'SELECT *  FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe WHERE  (row=1)  and (galaxy =7)    ORDER BY system asc ';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	  {
               if ( $maj['last_update'] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
			   if ( $maj['last_update'] >= $b and $maj['last_update'] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
			   if ( $maj['last_update'] >= $c and $maj['last_update'] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
			   if ( $maj['last_update'] >= $d and $maj['last_update'] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
			   if ( $maj['last_update'] >= $e and $maj['last_update'] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
			    if ( $maj['last_update'] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
				
			  
			  
			   
			 
			 
		
		
		}
  
  

   ?>
  </tr>
  
 <tr>
  <td width="30px">G8
  <td>
  <?php
  
  /// pour la g8
 $time=time();
$a=($time-259200);
$b= ( $time-518400);  
$c= ( $time-777600);
$d= ( $time-1036800);
$e= ( $time-1296000);

  
  $sql = 'SELECT *  FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe WHERE  (row=1)  and (galaxy = 8)    ORDER BY system asc ';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	 {
               if ( $maj['last_update'] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
			   if ( $maj['last_update'] >= $b and $maj['last_update'] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
			   if ( $maj['last_update'] >= $c and $maj['last_update'] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
			   if ( $maj['last_update'] >= $d and $maj['last_update'] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
			   if ( $maj['last_update'] >= $e and $maj['last_update'] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
			    if ( $maj['last_update'] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
				
			  
			  
			   
			 
			 
		
		
		}
  
  

   ?>
  </tr> 
  
  <tr>
  <td width="30px">G9
  <td>
  <?php
  
  /// pour la g9
 $time=time();
$a=($time-259200);
$b= ( $time-518400);  
$c= ( $time-777600);
$d= ( $time-1036800);
$e= ( $time-1296000);

  
  $sql = 'SELECT *  FROM '.$forum_config['o_ogameportail_ogspy_prefixe'].'universe WHERE  (row=1)  and (galaxy = 9)    ORDER BY system asc ';
	    $result = $forum_db->query($sql);
	    while($maj = $forum_db->fetch_assoc($result))
	    {
               if ( $maj['last_update'] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
			   if ( $maj['last_update'] >= $b and $maj['last_update'] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
			   if ( $maj['last_update'] >= $c and $maj['last_update'] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
			   if ( $maj['last_update'] >= $d and $maj['last_update'] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
			   if ( $maj['last_update'] >= $e and $maj['last_update'] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
			    if ( $maj['last_update'] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
				
			  
			  
			   
			 
			 
		
		
		}
  

   ?>
  </tr>
  
  
</table>



<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2">Legende</td>
  </tr>
  <tr>
    <td bgcolor="#00cc00">&nbsp;</td>
    <td> moins de 3 jours</td>
  </tr>
  <tr>
    <td bgcolor="#00AA00">&nbsp;</td>
    <td>moins de 6 jours</td>
  </tr>
  <tr>
    <td bgcolor="#007900">&nbsp;</td>
    <td>moins de 9 jours</td>
  </tr>
  <tr>
    <td bgcolor="#005300">&nbsp;</td>
    <td>moins de 12 jours</td>
  </tr>
  <tr>
    <td bgcolor="#000000">&nbsp;</td>
    <td>moins de 15</td>
  </tr>
  <tr>
   <td bgcolor="#FF3300">&nbsp;</td>
    <td>a mettre a jour</td>
  </tr>
</table>



<p>Pr&eacute;sentation visuel des mises a jour galaxie</p>
 <p align="center"><a href="../../../">RETOUR</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
