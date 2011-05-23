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


  $thisUser=$_SESSION['logged_in'];
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
    exit;
  }
?>

<table width="600" align="center" bgcolor="#eeeeee">
  <tr>
    <td>
    Bonjour mod&eacute;rateur. <br><br>
    Pour mettre le cookie qui vous permettra  d'efaccer les messages du chat : <a href="modo-cook.php?action=add">cliquer ici</a>.
    <br><br>
    Si vous ne voulez plus avoir le cookie : <a href="modo-cook.php?action=del">cliquer ici</a>.
    
    <br><br>
    <?php
      if(isset($_COOKIE['ms_moderateur'])){
        echo '
        <center>
          <p><font color="red"><i>Vous avez le cookie mod&eacute;rateur activ&eacute; ! &nbsp;&nbsp; ['.$_COOKIE['ms_moderateur'].']</i></font></p>
        </center>';
      }else{
        echo '
        <center>
          <p><font color="black"><i>Vous n\'avez pas le cookie mod&eacute;rateur activ&eacute; ...</i></font></p>
        </center>';
      }
    ?>
    </td>
  </tr>
</table>