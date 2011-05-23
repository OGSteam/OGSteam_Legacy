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


if(file_exists("../admin/config.php")){
  exit("MySpeach est d&eacute;j&agrave; install&eacute;. <br /> Pour re installer, supprimer le fichier config.php");
}
//valeur de $mode pour un dossier(777) dwrxwrxwrx
//valeur de $mode pour un fichier(777)  wrxwrxwrx
function chmodnum($mode) {
  $mode=substr($mode,-9);// on prend les 9 derniers, marche avec fichiers ou dossiers
  $mode = str_pad($mode,9,'-');
  $trans = array('-'=>'0','r'=>'4','w'=>'2','x'=>'1');
  $mode = strtr($mode,$trans);
  $newmode = '';
  $newmode .= $mode[0]+$mode[1]+$mode[2];
  $newmode .= $mode[3]+$mode[4]+$mode[5];
  $newmode .= $mode[6]+$mode[7]+$mode[8];
  return $newmode;
}

function getperms($file){
if(@function_exists(fileperms)){
$perms = fileperms($file);
if (($perms & 0xC000) == 0xC000) {
   // Socket
   $info = 's';
} elseif (($perms & 0xA000) == 0xA000) {
   // Lien symbolique
   $info = 'l';
} elseif (($perms & 0x8000) == 0x8000) {
   // Régulier
   $info = '';
} elseif (($perms & 0x6000) == 0x6000) {
   // Block spécial
   $info = 'b';
} elseif (($perms & 0x4000) == 0x4000) {
   // Dossier
   $info = 'd';
} elseif (($perms & 0x2000) == 0x2000) {
   // Caractère spécial
   $info = 'c';
} elseif (($perms & 0x1000) == 0x1000) {
   // FIFO pipe
   $info = 'p';
} else {
   // Inconnu
   $info = 'u';
}

// Propriétaire
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
           (($perms & 0x0800) ? 's' : 'x' ) :
           (($perms & 0x0800) ? 'S' : '-'));

// Groupe
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
           (($perms & 0x0400) ? 's' : 'x' ) :
           (($perms & 0x0400) ? 'S' : '-'));

// Tous
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
           (($perms & 0x0200) ? 't' : 'x' ) :
           (($perms & 0x0200) ? 'T' : '-'));
           
  return $info;

}
  $errorfunction='<b>Indeterminé</b>, fonction php fileperms() absent';
  return $errorfunction;
}
/*
$liste_a_tester=array(
                        '../ki.txt',
                        '../smileys.php',
                        '../saves/',
                        '../saves/skin/',
                        '../saves/message.txt',
                        '../saves/styles.css',
                        '../saves/x.txt',
                        '../saves/0.txt',
                        '../admin/', 
                        '../admin/setup.php',
                        '../admin/temp/',
                        '../admin/skins/',
                        '../admin/options.php'
                      );
$test=0;
*/
$liste_a_tester=array(
                        '../saves/',
                        '../saves/skin/',
                        '../admin/'
                      );
$test=0;
clearstatcache();
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
      
      <h1>Pr&eacute;configuration</h1>
      
      <?php
      $cettepage=htmlentities($_SERVER['HTTP_HOST'], ENT_QUOTES);
      if(eregi("free.fr",$cettepage)){
      if($_SERVER["DOCUMENT_ROOT"]==""){ $rootPhp=$DOCUMENT_ROOT; }else{ $rootPhp=$_SERVER['DOCUMENT_ROOT']; }
        if(!file_exists($rootPhp.'/sessions/')) {
        echo '
        <div style="border:1px dotted #EEEEEE;background-color:#999999;padding:5px;margin-top:10px">
        <h2 style="margin-top:0;padding-top:0"><span style="color:darkred" title="'.$rootPhp.'sessions/">Attention : erreur fatal !</span></h2>
          Vous est chez FREE.FR, vous devez cr&eacute;er un r&eacute;pertoire <b>sessions</b> &agrave; la racine de votre site. <br />
          Sans faire cette &eacute;tape, le chat ne fonctionnera pas du tout.
        </div>';
        exit();
        }
      }
      ?>
      
      <h2>Pr&eacute;ambule</h2>
      <p>
        Pour fonctionner, MySpeach &agrave; besoin de PHP <b>4.1.0</b> et plus. <br />
        Si votre installation &eacute;chou, vous aurez la possibilit&eacute; d'envoyer un rapport pour avoir un support plus rapide.
      </p>
      
      <h2>Test des droits en &eacute;critures</h2>
      <p>Avant de continuer, v&eacute;rifier que les fichiers et r&eacute;pertoires list&eacute; ci-dessous sont bien accessible en &eacute;criture par PHP. Besoin de plus d'infos sur les chmod ? <a href="http://www.graphiks.net/cours/serveur/72-chmod.html" target="_blank">cliquer ici</a>
      </p>
      <table width="100%" cellpadding="2";>
        <tr>
          <td><b>Fichier</b></td><td><b>Etat</b></td><td width="100"><b>CHMOD</b></td>
        </tr>
        <?php
        $out='';
        foreach($liste_a_tester as $key=>$valeur) {
          $lemod=@chmodnum(getperms($valeur));
          if(is_writable($valeur)){
            $out='<tr><td>'.str_replace('../','',$valeur).'</td><td><span style="color:green">est accessible en &eacute;criture.</span></td><td><span style="color:green">'.$lemod.'</span></td>';
          }else{
            $test++;
            $out='<tr><td>'.str_replace('../','',$valeur).'</td><td><span style="color:red"><u>n\'est PAS</u> accessible en &eacute;criture.</span></td><td><span style="color:red">'.$lemod.'</span></td>';
          }
          echo $out;
        }
        ?>
      </table>
      <br />
      &nbsp;
      <?php

    if($test>0){
    echo '
      <span style="color:red">
        Avant de poursuivre, changer le CHMOD des fichiers list&eacute;s audessus. 
      </span>
      <br>';
    }else{
      echo 'CHMOD des fichiers OK, l\'installation peut poursuivre : <a href="install.php"><b>Cliquez ici</b></a>';
    }
      ?>
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
