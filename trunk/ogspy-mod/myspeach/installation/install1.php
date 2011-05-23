<?php
session_start();
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

if(file_exists($my_ms['root']."/admin/config.php")){
  exit("MySpeach est d&eacute;j&agrave; install&eacute;. <br /> Pour re installer, supprimer le fichier config.php");
}
?>

<html>
<head>
<title>Installation de MySpeach</title>
<link REL="STYLESHEET" HREF="mod/myspeach/saves/styles.css" TYPE="text/css">
</head>
<body bgcolor="#FEF2D6">

  <table width="600" align="center">
    <tr>
      <td>
      
      <h2>Installation</h2>
      
      <h2>En cours ...</h2>
      
<?PHP
$out=" "; $ok=0;
@umask(0000);

// on test si on peut creer config.php
if(@fopen($my_ms['root']."/admin/config.php","w+")){
  $out.='<li>Cr&eacute;ation du fichier config.php : <span style="color:green">OK</span></li>';
}else{
  $ok++; $out.='<li>Cr&eacute;ation du fichier config.php : <span style="color:red">ECHEC</span></li>';
}

$id_unique=time();
if($_SERVER["DOCUMENT_ROOT"]==""){ $rootPhp=$DOCUMENT_ROOT; }else{ $rootPhp=$_SERVER['DOCUMENT_ROOT']; }
if(substr($rootPhp, -1, 1)=='/'){ $rootPhp=substr($rootPhp, 0, -1); }

$data='<?php
//Mettez ici l adresse exact de votre site sans / a la fin :
//Metez votre véritable adresse, pas une redirection, ni une adresse du genre ulimit.

$my_ms["site"]="'.$_POST['url_site'].'";    //Votre site
$my_ms["repertoire"]="/'.$_POST['url_repertoire'].'";    //depuis la racine http
$my_ms["absolu_root"]="'.$rootPhp.'";    //si pas exact, mettez ici la racine de votre serveur

$my_ms["id_unique"]="'.$id_unique.'"; //identifiant unique, pour savoir si une nuvelle version de myspeach existe

$my_ms["admin_login"]="'.$_POST['url_login'].'";                 //Votre Login
$my_ms["admin_mdp"]="'.$_POST['url_mdp'].'";                //Votre mot de passe

$my_ms["msg_txt"]="message.txt";             //Le nom du fichier texte qui enregistre (ne pas changer)

$my_ms["version"]="3.0.1";
$my_ms["copyright"]="<a href=\"http://www.graphiks.net/\" target=\"_blank\" title=\"MySpeach\">MySpeach</a>";

$my_ms["skin"]="saves/skin/default";    //le skin utilisé
?>';

$fp=@fopen($my_ms['root']."/admin/config.php","w");
if(@fputs($fp,$data)){
  fclose($fp);
  $out.='<li>Mise &agrave; jours du fichier config.php : <span style="color:green">OK</span></li>';
}else{
  $out.='<li>Mise &agrave; jours du fichier config.php : <span style="color:red">ECHEC</span></li>';
  $ok++;
}
@umask($oldumask); 






$oldumask = @umask(0);
  
  @mkdir($my_ms['root']."/admin/temp/",0777);
  @mkdir($my_ms['root']."/admin/skins/",0777);
   @mkdir($my_ms['root']."/admin/maj/",0777);
  
  //creation de 0.txt
  $data="12:00	Sky et 3run0	[#0000ff] Bienvenu sur MySpeach 3.01 []	10.0.0.1\n";
  $fp=@fopen($my_ms['root']."/saves/0.txt","w+");
  if(@fputs($fp,$data)){
    fclose($fp);
    $out.='<li>Cr&eacute;ation du fichier ../saves/0.txt : <span style="color:green">OK</span></li>';
  }else{ 
    $out.='<li>Cr&eacute;ation du fichier ../saves/0.txt : <span style="color:red">ECHEC</span></li>';
    $ok++;
  }
  
  //creation de ki.txt
  $data=" ";
  $fp=fopen($my_ms['root']."/saves/ki.txt","w+");
  if(fputs($fp,$data)){
    fclose($fp);
    $out.='<li>Cr&eacute;ation du fichier ../saves/ki.txt : <span style="color:green">OK</span></li>';
  }else{ 
    $out.='<li>Cr&eacute;ation du fichier ../saves/ki.txt : <span style="color:red">ECHEC</span></li>';
    $ok++;
  }

  //creation de message.txt
  $data="12:00	Sky et 3run0	[#0000ff] Bienvenu sur MySpeach 3.01 ! Bon chat et si vous avez un soucis, n'h&eacute;sitez pas &agrave; nous contacter : http://www.graphiks.net ! []	10.0.0.1\n";
  $fp=@fopen($my_ms['root']."/saves/message.txt","w+");
  if(@fputs($fp,$data)){
    fclose($fp);
    $out.='<li>Cr&eacute;ation du fichier ../saves/message.txt : <span style="color:green">OK</span></li>';
  }else{ 
    $out.='<li>Cr&eacute;ation du fichier ../saves/message.txt : <span style="color:red">ECHEC</span></li>';
    $ok++;
  }
  
  //creation de x.txt
  $data="0";
  $fp=@fopen($my_ms['root']."/saves/x.txt","w+");
  if(@fputs($fp,$data)){
    fclose($fp);
    $out.='<li>Cr&eacute;ation du fichier ../saves/x.txt : <span style="color:green">OK</span></li>';
  }else{ 
    $out.='<li>Cr&eacute;ation du fichier ../saves/x.txt : <span style="color:red">ECHEC</span></li>';
    $ok++;
  }

@umask($oldumask); 


  //creation de ../saves/smileys.php
$data='<?php
$smileys=Array(
  \':ff:\' => \'ff\',
  \':fleche:\' => \'icon_arrow\',
  \':)\' => \'icon_biggrin\',
  \':ha:\' => \'icon_confused\',
  \':8)\' => \'icon_cool\',
  \':cry:\' => \'icon_cry2\',
  \':iiiii:\' => \'icon_eek\',
  \':devil:\' => \'icon_evil\',
  \':hey:\' => \'icon_exclaim\',
  \':dow:\' => \'icon_hum\',
  \':idee:\' => \'icon_idea\',
  \':grr:\' => \'icon_mad\',
  \':what:\' => \'icon_question\',
  \':p\' => \'icon_razz\',
  \':hum:\' => \'icon_redface\',
  \':roll:\' => \'icon_rolleyes\',
  \':(\' => \'icon_sad\',
  \':hoo:\' => \'icon_surprised\',
  \':devi2:\' => \'icon_twisted\',
  \';)\' => \'icon_wink\',
  \':lol:\' => \'laugh\',
  \':nerf:\' => \'nerf\',
  \':oye:\' => \'oye\',
  \':LL\' => \'smile\',
  \':tchin:\' => \'smil_bounce\',
  \':cry2:\' => \'smil_crying1\',
  \':bye:\' => \'smly_accueil001\',
  \':cheese:\' => \'smly_biggrin\',
  \':blah:\' => \'smly_canail001\',
  \':grin:\' => \'smly_cheesygrin\',
  \':think:\' => \'smly_cingle001\',
  \':zzz:\' => \'smly_dodo001\',
  \':wtf:\' => \'smly_eek\',
  \':oops:\' => \'smly_embarras004\',
  \':bad:\' => \'smly_frown\',
  \':ll2:\' => \'smly_happy\',
  \':BIG:\' => \'smly_lol\',
  \':haha:\' => \'smly_mdr001\',
  \':D\' => \'smly_mdr011\',
  \':ioi:\' => \'nux\',
  \':no:\' => \'smly_no\',
  \':bordel:\' => \'smly_raleur001\',
  \':roll2:\' => \'smly_rolleyes\',
  \':larme:\' => \'smly_triste014\',
  \':yo:\' => \'smly_yooo\',
  \':bug:\' => \'tapepc\',
  \':UP:\' => \'testamora\',
  \':ami:\' => \'amis\',
  \':AV:\' => \'micmic\'
);
?>';
  $fp=@fopen($my_ms['root']."/saves/smileys.php","w+");
  if(@fputs($fp,$data)){
    fclose($fp);
    $out.='<li>Cr&eacute;ation du fichier ../saves/smileys.php : <span style="color:green">OK</span></li>';
  }else{ 
    $out.='<li>Cr&eacute;ation du fichier ../saves/smileys.php : <span style="color:red">ECHEC</span></li>';
    $ok++;
  }
  

  //creation de styles.css
  //$data='.MYtout { font-size:10px; background-color:#C0D2E9; font-family:Verdana; width:600px; border:3px outset #93b5db; } /* Style qui defini la structure du chat */
  $data='.MYtout { font-size:10px;  font-family:Verdana; width:600px; border:3px outset } /* Style qui defini la structure du chat */
.MSli { list-style-type:none; margin:2px; background:#FFFFFF; padding:0; border:3px inset #93b5db; } /* Style cellule du chat */
.MStitre, .barre { font-size:14px; font-weight:bold; font-variant:small-caps;  background-image: url(\''.$link_css.'/gfx/ogame-produktion.jpg\') no-repeat bottom left; border-bottom:1px solid ; text-align:center; padding:2px; margin:0; } /* Taille du titre du chat */
.MStxtAutre { font-size:10px; color:#000000; } /* autres textes */
.MSpseudo { font-size:10px; color:grey; font-weight:bold; } /* Pseudos normaux */
.MSmodo { font-size:10px; color:orange; font-weight:bold; } /* Pseudo Moderateur */
.MStexte { font-size:10px; color:#000000; } /* Texte du chat */
.MSdate { font-size:8px; color:#888888; } /* Style des dates */
.My_Tail { font-size:10px; } /* Style du texte en pied du chat */
.My_Root { font-size:10px; color:#ff0000; font-weight:bold; } /* Pseudos administrateur */
.My_altern1 { padding:2px; } /* Couleur qui alterne n 1*/
.My_altern2 { padding:2px; } /* Couleur qui alterne n 2*/
#count big { color:red; } /* Quand on ecrit, le pseudo change de couleur, ceci change la couleur. */
.My_historique { font-size:10px; font-family:Verdana; color:#333333; } /* Taille du texte historique */
#popupAddressbook { display:none; position:absolute; left:160px; top:10px; width:350px; height:355px; background-color:#C0D2E9; border:3px outset #93b5db; } /* !! Les CSS qui suivent sont a modifier que si vous savez ce que vous faite !! */
.barre { text-align:right; height:1.4em; }
.barre a {padding:0;margin:2px; text-decoration:none; border:#FFD62F outset 1px; } /* contient les images fermer/reduire popup */
#pop_titre { float:left; font-weight:bold; color:#000000; margin-left:40px; }
#pop { height:320px; border:3px inset #93b5db; overflow:auto; background-color:#F1F5FA; background-position:50%; margin:2px; }
#pop table { background-color:transparent; }
#contextMenu { position:absolute; left:0; top:0; padding:5px; z-index:2; background-color:#C0D2E9; width:130px; visibility:hidden; border:3px outset #93b5db; }
#slct_ip { font-size:0.6em; }
#contextMenu li {list-style:none;}
#contextMenu .separator {border-bottom:inset #93b5db 1px;}
#contextMenu li a { text-decoration:none; color:#000000; font-size:0.8em; }
#contextMenu li a { width:125px;}
#contextMenu li a img { border:none; }
#contextMenu li a:hover{ color:#000000; background-color:#F1F5FA; }
.My_basduchat { padding:2px; text-align:center; } /* Style qui defini le bas du chat */
#pal { text-align:center; margin:auto; }
#temoin { height:1em; border:0;width:95%;} /* temoin de mise en forme du texte */
.My_basduchat input { background-color:#F1F5FA; color:#000000; width:100px }
.petit_boutton { display:inline; background-color:#F1F5FA; border:outset #93b5db 2px; font-family:monospace; font-size:1em;padding:1px;} /* plus les styles suivants */
#chr_b {background-image:url(\'skin/default/bold.gif\');background-position:60% 50%;background-repeat: no-repeat} /* background-position: horisontal(%) vertical(%)*/
#chr_i {background-image:url(\'skin/default/italic.gif\');background-position:60% 50%;background-repeat: no-repeat} /* background-position: horisontal(%) vertical(%)*/
#chr_s {background-image:url(\'skin/default/strike.gif\');background-position:0% 50%;background-repeat: no-repeat} /* background-position: horisontal(%) vertical(%)*/
#chr_u {background-image:url(\'skin/default/underline.gif\');background-position:50% 50%;background-repeat: no-repeat} /* background-position: horisontal(%) vertical(%)*/
#chr_sup {background-image:url(\'skin/default/super.gif\');background-position:55% 50%;background-repeat: no-repeat} /* background-position: horisontal(%) vertical(%)*/
#chr_big {background-image:url(\'skin/default/big.gif\');background-position:55% 50%;background-repeat: no-repeat} /* background-position: horisontal(%) vertical(%)*/
#chr_small {background-image:url(\'skin/default/small.gif\');background-position:55% 50%;background-repeat: no-repeat} /* background-position: horisontal(%) vertical(%)*/
.pop_dring {background-color:#F1F5FA;text-align:center;}
.pop_dring span {font-size:10px; color:#000000; }
';
  $fp=@fopen($my_ms['root']."/saves/styles.css","w+");
  if(@fputs($fp,$data)){
    fclose($fp);
    $out.='<li>Cr&eacute;ation du fichier ../saves/styles.css : <span style="color:green">OK</span></li>';
  }else{ 
    $out.='<li>Cr&eacute;ation du fichier ../saves/styles.css : <span style="color:red">ECHEC</span></li>';
    $ok++;
  }
  
  //creation de setup.php
  $data='<?php
$my_ms["chat_titre"]="MySpeach - Chat PHP pour serveur OGSPY (adapté par Naqdazar)";               // Titre du chat (defaut MySpeach)
$my_ms["maxTexte"]=200;               // Nbr de caractere max par ligne
$my_ms["cesure"]=20;                     // Coupe tous les mots qui sont plus lonbg que ce nbr de lettres
$my_ms["lesens"]="down";                           // Sens d affichage du chat
?>';
  $fp=@fopen($my_ms['root']."/admin/setup.php","w+");
  if(@fputs($fp,$data)){
    fclose($fp);
    $out.='<li>Cr&eacute;ation du fichier ../admin/setup.php : <span style="color:green">OK</span></li>';
  }else{ 
    $out.='<li>Cr&eacute;ation du fichier ../admin/setup.php : <span style="color:red">ECHEC</span></li>';
    $ok++;
  }
  
  //creation du fichier options.php
  $data='<?php
//Mot interdit d affichage sur le chat
//SURTOUT : Respecter le format -> pas d espace ou de | au debut et rien à la fin non plus !!!
//EX : pour rajouter un mot, tapez à la suite : |lemot
//mais surtout pas |lemot|
$my_ms["stop"]="sexe|penis|encule|connard|merde|connasse|conasse|salope|putain|merde|pute|con";

/* ban par ip : ip séparé par une virgule */
$my_ms["ipstop"]="192.168.0.1"; 

/* liste des moderateurs. ex : pseudo|motdepasse,pseudo2|motdepasse2   etc ... */
$my_ms["moderateur"]="";

$my_ms["hDeca"]=1;                 // Decalage horaire
$my_ms["auto_refresh"]=1;            // Refresh autamatique ou non.
$my_ms["refresh_speed"]=4000;       // vitesse du refresh
$_nbr_=8;                      // Nombre de messages que vous voulez voir afficher
$my_ms["af_counter"]=1;            // Afficher ou non le compteur de connecté
$my_ms["af_smiley"]=1;             // Afficher ou non les smileys?
$my_ms["af_historique"]=1;         // Afficher ou non le lien vers l\'historique
$my_ms["af_img_smileys"]=1;        // Afficher ou non les smileys cliquable
$my_ms["typedelien"]="lien";       // lien ou url (url affichera le vraiu lien cliquable, lien affichera juste le mot LIEN cliquable)
$my_ms["wisiwyg"]=1;             // les boutons de mise en page
$my_ms["adv_filtage"]=1;          //filtrage avancer ou non. (0/1)
?>';
  $fp=@fopen($my_ms['root']."/admin/options.php","w+");
  if(@fputs($fp,$data)){
    fclose($fp);
    $out.='<li>Cr&eacute;ation du fichier ../admin/options.php : <span style="color:green">OK</span></li>';
  }else{ 
    $out.='<li>Cr&eacute;ation du fichier ../admin/options.php : <span style="color:red">ECHEC</span></li>';
    $ok++;
  }





  echo '<ul>'.$out.'</ul>';
  
  if($ok==0){
    echo '
    <h2>Installation termin&eacute;</h2>
    <span style="color:green; size:15px;">Normalement, l\'installation c\'est bien d&eacute;roul&eacute;.</span> <br /><br />
    Pour retourner sur OGSPY, <a href="'.$_SERVER['PHP_SELF'].'?action=myspeach">cliquer ici</a> <br /><br />
    ';
  }else{
  
    $freesessions='';$_is_free="";
    $cettepage=htmlentities($_SERVER['HTTP_HOST'], ENT_QUOTES);
    if(eregi("free.fr",$cettepage)){
    $_is_free="Chez free";
      if($_SERVER["DOCUMENT_ROOT"]==""){ $rootPhp=$DOCUMENT_ROOT; }else{ $rootPhp=$_SERVER['DOCUMENT_ROOT']; }
      if(!file_exists($rootPhp.'/sessions/')) {
        $freesessions='Sessions free ? : NON';
      }else{
        $freesessions='Sessions free ? : OUI';
      }
    }else{
     $_is_free="Pas chez free";
    }
      
      
    $output='';
    foreach($_SERVER as $id=>$data){ $output.=$id.' = '.$data."\n"; }
    $_SESSION['report']='
      Version de MySpeach : 3.02
      Serveur et version de PHP : '.$_SERVER['SERVER_SOFTWARE'].'
      '.$freesessions."\n".'
      Url abs serveur : '.$_SERVER['SCRIPT_FILENAME'].'
      Url abs HTTP : '.$_SERVER['REQUEST_URI'].'
      
      $_SERVER : 
      '.$output.'
      ';
      
      
    echo '
    <h2 style="color:red">Probl&egrave;me(s) lors de l\'installation</h2>
    Si vous voulez de l\'aide rapidement, nous faciliter la tache et avoir un support performant, vous pouvez nous envoyer un rapport et nous essayerons de d&eacute;terminer les probl&egrave;mes. <br />
    Voici les donn&eacute;es qui seront envoy&eacute; si vous le d&eacute;sir&eacute; : <br />

    <div style="border:2px solid black;background-color:#EEEEEE;padding:6px;margin-top:10px">
      '.$_SESSION['report'].'
      <a href="report.php"><b>ENVOYER UN RAPPORT</b></a>
    </div>
    ';


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
