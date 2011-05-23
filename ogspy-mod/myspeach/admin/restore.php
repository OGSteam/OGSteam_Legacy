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
include("fonctions.php");
include("options.php");
include("setup.php");

/* test de connexion admin ou non */
if($_SESSION['My_admin_login']!=md5($my_ms['admin_login']) AND $_SESSION['My_admin_mdp']!=md5($my_ms['admin_mdp'])){
exit("<center><br><br><b>Vous n'&ecirc;tes pas loggu&eacute;</b><br><br><a href=\"index.php\">Connexion</a></center>");
}

if(!$_SESSION['changecss'] OR $_POST) {

  if($_POST['changecss']!=""){
    $_SESSION['changecss']=$_POST['changecss']; 
    if($_SESSION['changecss']=='styles.bak.css') {
      $laversion='Originel';
    }else{
    $dateversion=str_replace('temp/','',$_SESSION['changecss']);
      $laversion=my_MS_datefr($dateversion);
    }
    echo '<br><br><center>Etes vous bien sur de vouloir restaurer la version du '.$laversion.' du fichiers styles.css ?
    <br><a href="restore.php?verif=1">Oui</a> - <a href="admin.php">Non</a><br><br>';
  }else{
    echo 'selection vide';
  }
  
}else{
  if($_SESSION['changecss']!=""){
  
    if($_GET['verif']==1){
    $cssfile=$_SESSION['changecss'];
    if($cssfile=='styles.bak.css') { $cssfile='../'.$my_ms['skin'].'/styles.css'; }
    $handle = fopen ($cssfile, "r");
    $contents = fread ($handle, filesize ($cssfile));
    fclose ($handle);
    
    $fp=fopen("../saves/styles.css","w+");
    fputs($fp,$contents);
    fclose($fp);
    $_SESSION['changecss']='';
    
    header("location: admin.php?mod=css");
    exit;
    }
    $_SESSION['changecss']='';
    
  }
}
?>
