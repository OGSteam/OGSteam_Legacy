<?php
#################################################
# Copyrigh GUNNING Sky
# Modifiable à souhaits, à une seule condition :
#
#   ->  laisser le lien vers le site http://www.graphiks.net sur le chat.   <-
# 
# Version Originale non modifié
# Script est soumis à la licence CECCIL/GNU
#################################################

session_start();
include("config.php");

if($_SESSION['My_admin_login']!=md5($my_ms['admin_login']) OR $_SESSION['My_admin_mdp']!=md5($my_ms['admin_mdp'])){
  exit('Identifiant inconnu !');
}

/*
$temp="my_".$my_ms['admin_login'];
$temp2="my_".$my_ms['admin_mdp'];
*/
$temp="my_".md5($my_ms['admin_login']);
$temp2="my_".md5($my_ms['admin_mdp']);

	if($_GET['op']=="oui"){
        
          setcookie($temp,$temp2,time()+365 * 24 * 3600, "/");
	  
	}elseif($_GET['op']=="non"){
	  
          setcookie($temp, "", time()-(9 * 9999999 * 9999 * 3600), "/");

	}
	
        echo '<br><br>Redirection en cours...';
        
print "<html><head>";
print "<SCRIPT LANGUAGE=\"JavaScript\">document.location.href=\"./admin.php\"</SCRIPT>";
print "</head><body>";
print "</body></html>";
?>
