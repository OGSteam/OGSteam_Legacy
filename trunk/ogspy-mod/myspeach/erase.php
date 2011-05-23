<?php
#################################################
# Copyrigh GUNNING Sky et Guillouet Bruno
# Modifiable à souhaits, à une seule condition :
#
#   ->  laisser le lien vers le site http://www.graphiks.net sur le chat.   <-
# 
# Version Originale non modifié
# Script est soumis à la licence CECCIL/GNU
#################################################
header('Pragma: public');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');
$page=$_GET['page'];
include("admin/config.php");
include("admin/options.php");

  $connect=0;
  if(isset($_COOKIE['ms_moderateur'])){
      $thisUser=$_COOKIE['ms_moderateur'];
      $temp=split(',',$my_ms['moderateur']);
      for($io=0; $io<count($temp); $io++){
        $testUser=$temp[$io];
        if($thisUser==$testUser){
          $connect=1;
        } 
      }
  }
  
	$temp_login="my_".md5($my_ms['admin_login']);
	$temp_mdp="my_".md5($my_ms['admin_mdp']);
  if(isset($_COOKIE[$temp_login]) AND $_COOKIE[$temp_login]==$temp_mdp){
    $connect=1;
  }
  
  if($connect==0){
    exit;
  }
  
  
    if($_GET['id']!=""){ $a=addslashes($_GET['id']); }else{ exit; }

    
  if($a!=""){
    $tableau=file("saves/message.txt");
    $nblignes=count($tableau);

    $fp = fopen("saves/message.txt", "w");
    $i=0;	
  
		for($i=0; $i<$nblignes; $i++){
		  if($i!=$a){
        $tableau[$i]=str_replace("/n","",$tableau[$i]);
        fwrite($fp, $tableau[$i]);
		  }
		}
    
	}	
	fclose($fp);
  
  //echo '<a href="javascript:history.go(-1)">retour</a>';
  
print "<html><head>";
print "<SCRIPT LANGUAGE=\"JavaScript\">document.location.href=\"".$my_ms['site'].$page."\"</SCRIPT>";
print "</head><body>";
print "</body></html>";
?>

