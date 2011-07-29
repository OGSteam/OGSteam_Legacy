<?php



if (!defined('IN_SPYOGAME')) die("Hacking attempt");

/// ajout modif inter
define("FOLDER_LANG","mod/majvisu/lang");
include(FOLDER_LANG."/lang_french.php");



require_once("views/page_header.php");





$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='majvisu' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");



/// variable de temps
$time=time();
	$a=($time-259200);
	$b= ( $time-518400); 
	$c= ( $time-777600);
	$d= ( $time-1036800);
	$e= ( $time-1296000);



// création du tableau de galaxie vide

	$g1[] = 0;
	$g2[] = 0;
	$g3[] = 0;
	$g4[] = 0;
	$g5[] = 0;
	$g6[] = 0;
	$g7[] = 0;
	$g8[] = 0;
	$g9[] = 0;
	$i = 0;
	while (499 >= $i)
	{
	    $g1[$i] = 0;
	    $g2[$i] = 0;
	    $g3[$i] = 0;
	    $g4[$i] = 0;
	    $g5[$i] = 0;
	    $g6[$i] = 0;
	    $g7[$i] = 0;
	    $g8[$i] = 0;
	    $g9[$i] = 0;
	    $i = $i + 1;
	}
	
/// fin de la cration du tableau vide


/// appel des dates de mise a jour dans universe :
$result = mysql_query("SELECT
	                        ".$table_prefix."universe.last_update , 
							 ".$table_prefix."universe.galaxy ,
							  ".$table_prefix."universe.system
	                        FROM ".$table_prefix."universe
	                         WHERE  row=1 
							 order by galaxy , system
						
	                       
	                        ");
	while ($maj = mysql_fetch_assoc($result))
{

if  ( $maj['galaxy'] == '1' ) {  $g1[$maj['system']] = $maj['last_update']   ;}
if  ( $maj['galaxy'] == '2' ) {  $g2[$maj['system']] = $maj['last_update']   ;}
if  ( $maj['galaxy'] == '3' ) {  $g3[$maj['system']] = $maj['last_update']   ;}
if  ( $maj['galaxy'] == '4' ) {  $g4[$maj['system']] = $maj['last_update']   ;}
if  ( $maj['galaxy'] == '5' ) {  $g5[$maj['system']] = $maj['last_update']   ;}
if  ( $maj['galaxy'] == '6' ) {  $g6[$maj['system']] = $maj['last_update']   ;}
if  ( $maj['galaxy'] == '7' ) {  $g7[$maj['system']] = $maj['last_update']   ;}
if  ( $maj['galaxy'] == '8' ) {  $g8[$maj['system']] = $maj['last_update']   ;}
if  ( $maj['galaxy'] == '9' ) {  $g9[$maj['system']] = $maj['last_update']   ;}



 
}








///creation de la vue galaxie en fonction des array
///g1
echo '<table cellspacing="1" style="border: 0px solid #405680; width:20px; border-spacing: 0px; height: 30px;">
	  <tr>
	  <td width="30px">G1</td>
	  <td>';
	  {
	  $i = 1;
	while (499 >= $i)
	{
	
	               if ( $g1[$i] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
	               if ( $g1[$i] >= $b and $g1[$i] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
	               if (  $g1[$i] >= $c and  $g1[$i] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
	               if ( $g1[$i] >= $d and  $g1[$i] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
               if ( $g1[$i] >= $e and $g1[$i]< $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
	                if ( $g1[$i] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
					
					
					  $i = $i + 1;
        }
	}

  echo'   </tr>	</table> ';
  
  
  ///g2
echo '<table cellspacing="1" style="border: 0px solid #405680; width:20px; border-spacing: 0px; height: 30px;">
	  <tr>
	  <td width="30px">G2</td>
	  <td>';
	  {
	  $i = 1;
	while (499 >= $i)
	{
	
	               if ( $g2[$i] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
	               if ( $g2[$i] >= $b and $g2[$i] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
	               if ( $g2[$i] >= $c and $g2[$i] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
	               if ( $g2[$i] >= $d and $g2[$i] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
               if ( $g2[$i] >= $e and $g2[$i] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
	                if ( $g2[$i] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
					
					
					  $i = $i + 1;
        }
	}

  echo'   </tr>	</table> ';
  
  
  ///g3
echo '<table cellspacing="1" style="border: 0px solid #405680; width:20px; border-spacing: 0px; height: 30px;">
	  <tr>
	  <td width="30px">G3</td>
	  <td>';
	  {
	  $i = 1;
	while (499 >= $i)
	{
	
	               if ( $g3[$i] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
	               if ( $g3[$i] >= $b and $g3[$i] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
	               if ( $g3[$i] >= $c and $g3[$i] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
	               if ( $g3[$i] >= $d and $g3[$i] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
               if ( $g3[$i] >= $e and $g3[$i] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
	                if ( $g3[$i] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
					
					
					  $i = $i + 1;
        }
	}

  echo'   </tr>	</table> '; 
  
  
  
   ///g4
echo '<table cellspacing="1" style="border: 0px solid #405680; width:20px; border-spacing: 0px; height: 30px;">
	  <tr>
	  <td width="30px">G4</td>
	  <td>';
	  {
	  $i = 1;
	while (499 >= $i)
	{
	
	               if ( $g4[$i] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
	               if ( $g4[$i] >= $b and $g4[$i]  < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
	               if ( $g4[$i] >= $c and $g4[$i]  < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
	               if ( $g4[$i] >= $d and $g4[$i]  < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
               if ( $g4[$i] >= $e and $g4[$i]  < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
	                if ( $g4[$i] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
					
					
					  $i = $i + 1;
        }
	}

  echo'   </tr>	</table> ';
  
  
   ///g5
echo '<table cellspacing="1" style="border: 0px solid #405680; width:20px; border-spacing: 0px; height: 30px;">
	  <tr>
	  <td width="30px">G5</td>
	  <td>';
	  {
	  $i = 1;
	while (499 >= $i)
	{
	
	               if ( $g5[$i] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
	               if ( $g5[$i] >= $b and $g5[$i] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
	               if ( $g5[$i] >= $c and $g5[$i] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
	               if ( $g5[$i] >= $d and $g5[$i] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
               if ( $g5[$i] >= $e and $g5[$i] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
	                if ( $g5[$i] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
					
					
					  $i = $i + 1;
        }
	}

  echo'   </tr>	</table> ';
  
  
  
  
   ///g5
echo '<table cellspacing="1" style="border: 0px solid #405680; width:20px; border-spacing: 0px; height: 30px;">
	  <tr>
	  <td width="30px">G6</td>
	  <td>';
	  {
	  $i = 1;
	while (499 >= $i)
	{
	
	               if ( $g6[$i] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
	               if ( $g6[$i] >= $b and $g6[$i]< $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
	               if ( $g6[$i] >= $c and  $g6[$i] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
	               if ( $g6[$i] >= $d and  $g6[$i] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
               if ( $g6[$i] >= $e and  $g6[$i] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
	                if ( $g6[$i] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
					
					
					  $i = $i + 1;
        }
	}

  echo'   </tr>	</table> ';
  
  
   ///g7
echo '<table cellspacing="1" style="border: 0px solid #405680; width:20px; border-spacing: 0px; height: 30px;">
	  <tr>
	  <td width="30px">G7</td>
	  <td>';
	  {
	  $i = 1;
	while (499 >= $i)
	{
	
	               if ( $g7[$i] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
	               if ( $g7[$i] >= $b and $g7[$i] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
	               if ( $g7[$i] >= $c and $g7[$i] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
	               if ( $g7[$i] >= $d and $g7[$i] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
               if ( $g7[$i] >= $e and $g7[$i] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
	                if ( $g7[$i] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
					
					
					  $i = $i + 1;
        }
	}

  echo'   </tr>	</table> ';
  
  
  
  ///g8
echo '<table cellspacing="1" style="border: 0px solid #405680; width:20px; border-spacing: 0px; height: 30px;">
	  <tr>
	  <td width="30px">G8</td>
	  <td>';
	  {
	  $i = 1;
	while (499 >= $i)
	{
	
	               if ( $g8[$i] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
	               if ( $g8[$i] >= $b and  $g8[$i] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
	               if ( $g8[$i] >= $c and  $g8[$i] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
	               if ( $g8[$i] >= $d and  $g8[$i] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
               if ( $g8[$i] >= $e and  $g8[$i] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
	                if ( $g8[$i] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
					
					
					  $i = $i + 1;
        }
	}

  echo'   </tr>	</table> '; 
  
  
  
   ///g9
echo '<table cellspacing="1" style="border: 0px solid #405680; width:20px; border-spacing: 0px; height: 30px;">
	  <tr>
	  <td width="30px">G9</td>
	  <td>';
	  {
	  $i = 1;
	while (499 >= $i)
	{
	
	               if ( $g9[$i] >= $a) {   echo ' <td  style="background-color:#00cc00;"></td>'; }
	               if ( $g9[$i] >= $b and $g9[$i] < $a) {   echo ' <td  style="background-color:#00AA00;"></td>'; }
	               if ( $g9[$i] >= $c and $g9[$i] < $b) {   echo ' <td  style="background-color:#007900;"></td>'; }
	               if ( $g9[$i] >= $d and $g9[$i] < $c) {   echo ' <td  style="background-color:#005300;"></td>'; }
               if ( $g9[$i] >= $e and $g9[$i] < $d) {   echo ' <td  style="background-color:#000000;"></td>'; }
	                if ( $g9[$i] < $e ) {   echo ' <td  style="background-color:#FF3300;"></td>'; }
					
					
					  $i = $i + 1;
        }
	}

  echo'   </tr>	</table> ';
  
  
  
  //// legende
  
  echo' 
<br /><br />
	
	<table width="500" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td colspan="2">Legende</td>
	  </tr>
	   <tr>
	    <td bgcolor="#00cc00">&nbsp;</td>
	    <td> moins de 3 jours</td>
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
	 
	<p>&nbsp;</p>
	<p>&nbsp;</p>
';






echo'
<br><br>
Module de visualisation des mises a jour de la galaxie par <b>Machine</b> tiré du portail OGPT
Version 1.0';

 require_once("./views/page_tail.php");
?>