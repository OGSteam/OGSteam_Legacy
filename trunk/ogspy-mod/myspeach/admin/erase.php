<?php
##################################################################
#Copyrigh GUNNING Sky
#Modifiable à souhaits, à une seule condition :
#laisser le lien vers le site http://www.graphiks.net sur le chat.
#
#Version Originale non modifié : 1.8.1
##################################################################
header('Pragma: public');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');
include("config.php");

$temp_ad='my_'.md5($my_ms['admin_login']);
$temp_mdp='my_'.md5($my_ms['admin_mdp']);

if(isset($_COOKIE[$temp_ad]) AND $_COOKIE[$temp_ad]==$temp_mdp){
  if($_COOKIE[$temp_ad]==$temp_mdp){

  if($_GET['id'] AND isset($_GET['page'])){
  $a=$_GET['id'];
  $page="../saves/".$_GET['page'];
  
  $tableau=file($page);
  $nblignes=count($tableau);

	$fp = fopen($page, "w+");
	$i=0;	
		for($i=0; $i<$nblignes; $i++){
		  if($i!=$a){
		  $tableau[$i]=str_replace("/n","",$tableau[$i]);
		  fwrite($fp, $tableau[$i]);
		  }
		}	
	fclose($fp);
 }
 
 $my_ms['cettepage']=htmlentities($_GET['cettepage']);
 $my_ms['cettepage']=str_replace("&amp;","&",$my_ms['cettepage']);
 
  print "<html><head>";
  print "<SCRIPT LANGUAGE=\"JavaScript\">document.location.href=\"".$my_ms['site'].$my_ms['cettepage']."&xhr=non\"</SCRIPT>";
  print "</head><body>";
  print "</body></html>";

  }else{
   echo '<br>Parametre insuffisant<br>';
  }

}else{
 echo '<br>Vous n\'est pas autorisez à modifier ce fichier.';
}
?>
