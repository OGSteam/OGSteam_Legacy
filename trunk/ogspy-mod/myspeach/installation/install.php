<?PHP
####################Version Modifiée#######################
# Copyrigh GUNNING Sky et Guillouet Bruno
# Licence : GNU/GPL
# Modifiable à souhaits, à une seule condition :
#
#   ->  laisser le lien vers le site http://www.graphiks.net sur le chat.   <-
# 
# !!!!!!!!!!!!!! Version Modifiée ce fichier n'est pas officiel !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
# Script est soumis à la licence CECCIL/GNU
#######################################################
if(file_exists("../admin/config.php")){
  exit("MySpeach est d&eacute;j&agrave; install&eacute;. <br /> Pour re installer, supprimer le fichier config.php");
}

if(isset($_SERVER['PHP_SELF'])){
  $repertoire=str_replace('/index.php','/mod/myspeach',$_SERVER['PHP_SELF']);
}else{
  $repertoire=str_replace('/index.php','/mod/myspeach',$PHP_SELF);
}
$rep_install=substr(htmlentities($repertoire, ENT_QUOTES), 1);

if(isset($_SERVER['HTTP_HOST'])){
  $hote=$_SERVER['HTTP_HOST'];
}else{
  $hote=$HTTP_HOST;
}
?>

<html>
<head>
<title>Installation de MySpeach</title>
<link REL="STYLESHEET" HREF="../saves/styles.css" TYPE="text/css">
</head>
<body bgcolor="#FEF2D6">

  <table width="600" align="center">
    <tr>
      <td>

      <h2>Explications</h2>
        - Votre login et mot passe vous serviront pour vous connecter &agrave; l'administration du chat. <br />
        - Url du site est l'url du site sans oublier qu'il ne faut PAS mettre de <B>/</b> &agrave; la fin. <br />
        - R&eacute;pertoire d'installation est &agrave; changer que si &ccedil;a ne correspond pas.
        
      <h2>Remplir le formulaire</h2>
      
        <form method="post" action="index.php?action=myspeach&subaction=ms_install">
          <table class="encadrer" width="100%">
            <tr> 
              <td width="300">Votre <b>Login</b> : </td>
              <td><input name="url_login" type="text" value ="admin" id="url_login"></td>
            </tr>
            <tr> 
              <td width="300">Votre <b>Mot de passe</b> : </td>
              <td><input name="url_mdp" type="text" value ="admin" id="url_mdp"></td>
            </tr>
            <tr> 
              <td><br></td>
              <td></td>
            </tr>
            <tr> 
              <td width="300"><strong>Url du site </strong><font size="-1"><em>(sans / &agrave; la fin) Si vous est sous lycos, vous devez mettre : http://membres.lycos.fr (et pas la suite)</em></font></td>
              <td width="144"><input name="url_site" type="text" id="url_site" value="http://<?php echo $hote; ?>"></td>
            </tr>
            <tr> 
              <td width="300"><strong>R&eacute;pertoire d'installation </strong><font size="-1"><em></em></font></td>
              <td width="144"><input name="url_repertoire" type="text" id="url_repertoire" value="<?php echo $rep_install; ?>"></td>
            </tr>
            <tr> 
              <td> <input type="submit" name="forum_question" value="Install &gt;&gt;"> 
              </td>
              <td></td>
            </tr>
            <tr> 
              <td height="40">&nbsp;</td>
              <td height="40"></td>
            </tr>
          </table>
         </form>
            </td>
          </tr>
            <tr> 
              <td>
                <div align="center" style="border:1px dotted #999999;background-color:#EEEEEE;padding:4px;margin-top:10px">
                  Script php &eacute;crit par GUNNING Sky et Guillouet Bruno<br>
                  Pour tous les probl&egrave;mes d'installation, merci d'utiliser le forum de <a href="http://www.graphiks.net/" target="_blank">www.graphiks.net</a> 
                </div>
              </td>
            </tr>
        </table>

  
</body>
</html>
