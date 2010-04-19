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
header('Pragma: public');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');

$fp = fopen("../saves/x.txt","r");
$xOK = fgets($fp,11);
fclose($fp);

include("config.php");
include("options.php");
include("setup.php");
include("fonctions.php");

$my_ms['cettepage']=$_SERVER["REQUEST_URI"];
$my_ms['adminBoutton']='';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="pragma" content="no-cache" />
<title>MySpeach -> Historique</title>
<link href="../saves/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>


<table border="0" width="95%" class="My_historique">
<tr><td colspan="2"><b>Sauvegarde de MySpeach</b><br></td></tr>
  <tr valign="top">
    <td width="150">

<?php

echo '<table border="0" width="100%">';

    $repertoire = openDir("../saves/");
    $_tab=array();
    while ($fichier = readDir($repertoire)) {
      //if(($fichier!=".")&&($fichier!="..")&&($fichier!="message.txt")&&($fichier!="x.txt")&&($fichier!="skin")){
            $fichier_t=str_replace(".txt","","$fichier");
      	if(is_numeric($fichier_t)){ // plus court !

              if($_GET['xhr']=="non"){
                $link_save= '<a href="histo.php?f='.$fichier_t.'&xhr=non">Sauvegarde&nbsp; '.$fichier_t.'</a>';
                $my_ms['root']='../';
                //$my_ms['save']]='';
                $my_ms['erase']='';
                $puce=$my_ms['repertoire']."/".$my_ms['skin']."/erase.gif";
              }else{
                $my_ms['root']=htmlentities($_GET['chm'], ENT_QUOTES);
                $link_save= '<a href="javascript:void(0)" onclick="MY_MS_request(\''.$my_ms['root'].'/admin/histo.php?f='.$fichier_t.'&chm='.$my_ms['root'].'\',\'pop\')">Archive '.$fichier_t.'</a>';
                $my_ms['erase']=$my_ms['root'].'/admin/';
                 $puce=$my_ms['repertoire']."/".$my_ms['skin']."/erase.gif";
              }

            echo '
            <tr valign="top">
              <td><font size="-1">'.$link_save.'</font><br /></td>
            </tr>';
      }
    }
    closeDir($repertoire);

echo '</td></tr></table>';
?>

</td><td>

<table width="100%" border="0">
<?php
if(isset($_GET['f'])){ $f=$_GET['f']; }else{ $f=$fichier_t; }

if(isset($f)){
  $f=str_replace(":/","",$f);
  $f=str_replace("http","",$f);
  $f=str_replace("www","",$f);
  $f=str_replace("./","",$f);
  $f_k=$f;
}else{
  $f_k=$xOK;
}

if(!file_exists("../saves/".$f_k.".txt")){
exit('Cette identifiant n existe pas !');
}

echo '<ul class="MSli">';	
/* On ouvre le fichier message.txt */
$tableau=file("../saves/".$f_k.".txt");
/* On compte le nombre de ligne */
$nblignes=count($tableau);

/* On ouvre le for avec qui continue tant qu'il est < que $nbr */
for($i=0; $i<$nblignes; $i++){
$_temp=split("\t","$tableau[$i]");
/* On test la longueur du texte */
if(strlen($_temp[2])>$my_ms['maxTexte']){ $_temp[2]=substr($_temp[2], 0, $my_ms['maxTexte']+15); }
$_temp[2]=htmlentities($_temp[2]);
/* Gestion des smileys */
include("../saves/smileys.php");

    foreach ($smileys as $smiley => $image) {
      $image_smiley='<img border="0" src="'.$my_ms['root'].'/smiley/'.$smileys[$smiley]. '.gif" alt="myspeach"  title="mypeach">';
      $_temp[2]=str_replace($smiley,$image_smiley,$_temp[2]);
    }

/* 
 On enleve tout le html ou autre code malveillant 
 Pour avoir un lien automatique, le lien doit commencer avec http ou https 
 Le lien cliquable aura comme "texte" le mot LIEN .
*/
$_temp[0]=stripslashes($_temp[0]) ;
$_temp[1]=stripslashes($_temp[1]) ;
$_temp[2]=stripslashes($_temp[2]) ;
$_temp[2]=preg_replace("`((?:https?|ftp)://\S+)(\s|\z)`", '<a href="$1" target="_blank">LIEN</a>$2', $_temp[2]);
$_temp[2]=ucfirst($_temp[2]);

/* Getion des insultes, sont remplacer par le contenant de $par */
$wordstop=$my_ms['stop'];
$par="xxxxx";
$_temp[2]=preg_replace('`(^|\W*)('.$wordstop.')s?(\W|$)`Usi','$1 '.$par.' $3', $_temp[2]); 
$_temp[2]=str_replace("&amp;amp;#43;",'+',$_temp[2]);
$_temp[2]=str_replace("&amp;euro;",'&euro;',$_temp[2]);

/* Si un mot est supérieur à 15 (par defaut) caractere, on le coupe en deux */
$my_ms['alterne1']='My_altern1'; $my_ms['alterne2']='My_altern2';
$my_ms['couleur']=my_MS_choix_couleur($my_ms['alterne1'], $my_ms['alterne2']);


/* Si on à le cookie admin, on affiche le bouton pour supprimer le message */	
  $my_ms['adminBoutton']=''; $my_ms["admin_survol"]='';
	$temp_login="my_".md5($my_ms['admin_login']);
	$temp_mdp="my_".md5($my_ms['admin_mdp']);
	  if(isset($_COOKIE[$temp_login]) AND $_COOKIE[$temp_login]==$temp_mdp){
        $my_ms['adminBoutton']='<a href="'.$my_ms['erase'].'erase.php?id='.$i.'&cettepage='.$my_ms['cettepage'].'&page='.$f_k.'.txt" onclick="MY_MS_request(\''.$my_ms['erase'].'erase.php?id='.$i.'&cettepage='.$my_ms['cettepage'].'&page='.$f_k.'.txt\',\'non\');MY_MS_request(\''.$my_ms['erase'].'histo.php?f='.$f_k.'&chm='.$my_ms['root'].'\',\'pop\');return(false);"><img border="0" width="8" height="8" src="'.$puce.'" alt="@" /></a>';
        $my_ms["admin_survol"]=' title="'.$_temp[3].'" ';
      }else{
        $my_ms['adminBoutton']=' ';
        $my_ms["admin_survol"]=' ';
      }


if(ereg("\*ADMIND\*",$_temp[1])){ $my_ms['test_class']="My_Root"; }else{ $my_ms['test_class']="MSpseudo"; }
$_temp[1]=str_replace("*ADMIND*","",$_temp[1]);
$_temp[2]=preg_replace('!\[(#[a-fA-F0-9]{6})\](.+)\[\]!isU','<span style="color:$1">$2</span>', $_temp[2]);
$_temp[2]=preg_replace('!\*(b|i|s|u|big|small|sup)\*(.+)\*\*!isU','<$1>$2</$1>', $_temp[2]);
$toutSaves.='
<li class="'.$my_ms["couleur"].'">'.$my_ms['adminBoutton']."
  <span ".$my_ms['admin_survol']." class=\"".$my_ms['test_class']."\">".htmlentities($_temp[1])." </span>
  <span class=\"MSdate\">[$_temp[0]]:</span><br/>
  <span class=\"MStexte\">".$_temp[2]."</span>
</li>";
}
/* L'affichage est fini */
echo $toutSaves;
echo '
</ul>';
?>
</table>

</td></tr></table>

<br><center>
<?php
echo $my_ms['copyright'];
?></center>

</body>
</html>
