<?php

session_start();

$_SESSION['id'] = $id;
      
  require ('../admin/connexion.php');    
  $quet=mysql_query("SELECT * FROM users WHERE id='".$id."' ");
  while ($result=mysql_fetch_array($quet))
  {
  $actif = $result["bann"];
  
  } mysql_close();
  
      if($actif == 0) {
      
      header("Location: login_perso_2.php");
      exit;
      
      }else{
      
      echo "BANNISSEMENT ACTIF !";
      
      }

?>
