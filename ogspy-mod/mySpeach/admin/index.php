<?php
##################################################################
#Copyrigh GUNNING Sky
#Modifiable à souhaits, à une seule condition :
#laisser le lien vers le site http://www.graphiks.net sur le chat.
#
#Version Originale non modifié
##################################################################

if (file_exists("config.php")){

session_start();
session_destroy();

include("config.php");
include("options.php");

if(isset($_POST['url_login']) AND isset($_POST['url_mdp'])){

if($_POST['typeConnec']=='admin'){
  
  if($_POST['url_login']==$my_ms['admin_login'] AND $_POST['url_mdp']==$my_ms['admin_mdp']){
  $admin_login=$_POST['url_login'];
  $admin_mdp=$_POST['url_mdp'];

  session_start();
  $_SESSION['My_admin_login']=md5($admin_login);
  $_SESSION['My_admin_mdp']=md5($admin_mdp);

    print "<html><head>";
    print "<SCRIPT LANGUAGE=\"JavaScript\">document.location.href=\"admin.php\"</SCRIPT>";
    print "</head><body>";
    print "</body></html>";

  }else{
    session_start();
    session_destroy();
    echo '<b>mauvais Login ou Mot de passe</b>';
  }
  
}elseif($_POST['typeConnec']=='modo'){
  $thisUser=$_POST['url_login'].'|'.$_POST['url_mdp'];
  $temp=split(',',$my_ms['moderateur']);
  $connect=0;
  for($i=0; $i<count($temp); $i++){
    $testUser=$temp[$i];
    if($thisUser==$testUser){
      $connect=1;
    }
  }
  
  if($connect==1){
    session_start();
    $_SESSION['logged_in']=$thisUser;
    print "<html><head>";
    print "<SCRIPT LANGUAGE=\"JavaScript\">document.location.href=\"modo.php\"</SCRIPT>";
    print "</head><body>";
    print "</body></html>";
  }else{
    session_start();
    session_destroy();
    echo 'mauvais Login ou Mot de passe';
  }
}


}else{
?>
<html>
<head>
	<title>Section admin</title>
	<link REL="STYLESHEET" HREF="styles.css" TYPE="text/css">
</head>
<body bgcolor="#FEF2D6">

<center>
<br><font size="5">Back-end de Myspeach <?php echo $my_ms['version']; ?></font><br><br>
<table class="encadrer" align="center" width="500" cellspacing="1" border="0">
  <form method="post" action="index.php">
    <tr>
           <td>Pseudo :</td>
            <td><input type="text" name="url_login" size="10"></td>
    </tr>
    <tr>
            <td>Mot de passe :</td>
            <td><input type="password" name="url_mdp" size="15"></td>
    </tr>
    <tr>
            <td>Type de compte : </td>
            <td>
              <select width="3" name="typeConnec" id="typeConnece">
                <option value="admin" selected="selected">Administrateur</option>
                <option value="modo">Mod&eacute;rateur</option>
              </select>
            </td>
    </tr>
    <tr>
        <td>
          <input type="submit" value="Connexion >>">
        </td>
    </tr>
  </form>
</table>
<br>
<?php
echo $my_ms['copyright'];
?></center>
</body>
</html>
<?php
}

}else{
  echo 'Le chat n\'est pas encore installé <br>
  <a href="../installation/index.php">Cliquez ici</a>
  ';
}
?>