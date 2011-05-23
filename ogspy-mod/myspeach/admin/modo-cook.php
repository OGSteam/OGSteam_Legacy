<?php
##################################################################
#Copyrigh GUNNING Sky
#Modifiable à souhaits, à une seule condition :
#laisser le lien vers le site http://www.graphiks.net sur le chat.
#
#Version Originale non modifié
##################################################################

if(!file_exists("config.php")){
  exit('MySpeach non installé');
}

session_start();
include("config.php");
include("options.php");

  if(isset($_SESSION['logged_in'])){ $thisUser=$_SESSION['logged_in']; }else{ exit; }
  
  $temp=split(',',$my_ms['moderateur']);
  $connect=0;
  for($i=0; $i<count($temp); $i++){
    $testUser=$temp[$i];
    if($thisUser==$testUser){
      $connect=1;
    }
  }
  
  if($connect==0){
    session_destroy();
    echo 'Vous devez &ecirc;tre mod&eacute;rateur pour afficher cette page !';
  }
  
  
  $temp=$_SESSION['logged_in'];
        
	if($_GET['action']=="add"){
    setcookie('ms_moderateur',$temp,time()+365 * 24 * 3600, "/");
	}elseif($_GET['action']=="del"){
    setcookie("ms_moderateur", "", time()-(9 * 9999999 * 9999 * 3600), "/");
	}
	
        echo '<br><br>Redirection en cours...';
        
print "<html><head>";
print "<SCRIPT LANGUAGE=\"JavaScript\">document.location.href=\"./modo.php\"</SCRIPT>";
print "</head><body>";
print "</body></html>";
?>
