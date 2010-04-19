<?php
#################################################
# Copyrigh GUNNING Sky et Guillouet Bruno
# Modifiable à souhaits, à une seule condition :
#
#   ->  laisser le lien vers le site http://www.graphiks.net sur le chat.   <-
# 
# Version Originale non modifié
# Script est soumis à la licence CECCIL/GNU
#################################################

//include_once($my_ms['root'].'/admin/funcs.php');
$_temp=split("\t",$tableau[$i]);

if(!empty($tableau[$i])){

/* On test la longueur du pseudo */
if(strlen($_temp[1])>25){ $_temp[1]=substr($_temp[1], 0, 25); }
/* On test la longueur du texte */
if(strlen($_temp[2])>$my_ms['maxTexte']){ $_temp[2]=substr($_temp[2], 0, $my_ms['maxTexte']+15); }

/* Gestion des smileys */
include($my_ms['root']."/saves/smileys.php");
$smil=$smileys;
foreach ($smileys as $smiley => $image) {
    $image_smiley='<img border="0" src="'.$my_ms['img_root'].'/smiley/'.$smileys[$smiley]. '.gif" alt="myspeach"  title="myspeach" />'; 
    $_temp[2]=str_replace($smiley,$image_smiley,$_temp[2]);
    }

/* 
 On enleve tout le html ou autre code malveillant 
 Pour avoir un lien automatique, le lien doit commencer avec http, ftp ou https 
 Le lien cliquable aura comme "texte" le mot LIEN .
*/

$_temp[0]=stripslashes($_temp[0]);
$_temp[1]=stripslashes($_temp[1]);
$_temp[2]=stripslashes($_temp[2]);

$_temp[2]=str_replace("&amp;#43;",'+',$_temp[2]);
// $_temp[2]=str_replace("&amp;#0128;",'€',$_temp[2]);

if($my_ms['typedelien']=='lien'){$typedelien='LIEN';}else{$typedelien='$1';}
$_temp[2]=preg_replace("`((?:https?|ftp)://\S+)(\s|\z)`", '<a href="$1" target="_blank">'.$typedelien.'</a>$2', $_temp[2]);
$_temp[2]=ucfirst($_temp[2]);


/* Getion des insultes, sont remplacer par le contenant de $par */
$wordstop=$my_ms['stop'];
$par="xxxxx";
$_temp[2]=preg_replace('`(^|\W*)('.$wordstop.')s?(\W|$)`Usi','$1 '.$par.' $3', $_temp[2]); 




$my_ms['alterne1']='My_altern1'; $my_ms['alterne2']='My_altern2';
$my_ms['couleur']=my_MS_choix_couleur($my_ms['alterne1'], $my_ms['alterne2']);


/* Si on à le cookie admin, on affiche le bouton pour supprimer le message */
/* si on est dans ajax, on change le retour */

  $my_ms["admin_boutton"]="";
  $my_ms["admin_survol"]="";
	$temp_login="my_".md5($my_ms['admin_login']);
	$temp_mdp="my_".md5($my_ms['admin_mdp']);
  
	  if(isset($_COOKIE[$temp_login]) AND $_COOKIE[$temp_login]==$temp_mdp){
	    $my_ms["admin_boutton"]='
	    <a href="myspeach/erase.php?id='.$i.'&page='.$my_ms['cettepage'].'" onclick="MY_MS_request(\''.$my_ms['img_root'].'/erase.php?id='.$i.'\',\'non\');MY_MS_envoi();return('.$return.');">
	    <img border="0" width="8" height="8" src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/erase.gif"></a>';
	    $my_ms["admin_survol"]=' title="'.$_temp[3].'" ';
	    $ip_list="ok";
    }
  if(isset($_COOKIE['ms_moderateur']) AND !isset($_COOKIE[$temp_login])){
      $thisUser=$_COOKIE['ms_moderateur'];
      $temp=split(',',$my_ms['moderateur']);
      $connect=0;
      for($io=0; $io<count($temp); $io++){
        $testUser=$temp[$io];
        if($thisUser==$testUser){
          $connect=1;
        } 
      }
      if($connect==1){
	    $my_ms["admin_boutton"]='
	    <a href="myspeach/erase.php?id='.$i.'&page='.$my_ms['cettepage'].'" onclick="MY_MS_request(\'/'.$my_ms["repertoire"].'/erase.php?id='.$i.'\',\'non\');MY_MS_envoi();return('.$return.');">
	    <img border="0" width="8" height="8" src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/erase.gif"></a>';
	    $ip_list="ok";
      }
  }


$my_ms['test_class']="MSpseudo"; 
if(strtolower($_temp[1])==strtolower("*admind*".$my_ms['admin_login'])){
  $my_ms['test_class']="My_Root";
  $_temp[1]=str_replace("*ADMIND*","",$_temp[1]);
}
if(ereg("#MODO#",$_temp[1])){
    $tempS=split(',',$my_ms['moderateur']);
    $connect=0; $thisUser=str_replace('#MODO#','',$_temp[1]);
    for($aa=0; $aa<count($tempS); $aa++){
      $testUser=$tempS[$aa];
      if(eregi($thisUser,$testUser)){
        $my_ms['test_class']="MSmodo"; 
        $_temp[1]=str_replace("#MODO#","",$_temp[1]);
      }
    }
}
$_temp[1]=str_replace("#MODO#","",$_temp[1]);
/* fini modo ou admin */
$_temp[2]=preg_replace('!\[(#[a-fA-F0-9]{6})\](.+)\[\]!isU','<span style= "color:$1" >$2</span>', $_temp[2]);
$_temp[2]=preg_replace('!\*(b|i|s|u|big|small|sup)\*(.+)\*\*!isU','<$1>$2</$1>', $_temp[2]);
/* Si un mot est supérieur à 15 (par defaut) caractere, on le coupe en deux */
$_temp[2]=even_better_wordwrap($_temp[2], $my_ms['cesure'], "\n");

    $toutMySpeach.='
    <li class="'.$my_ms["couleur"].'">
      '.$my_ms["admin_boutton"].'
      <span '.$my_ms["admin_survol"].' class="'.$my_ms["test_class"].'">'.$_temp[1].' </span>
      <span class="MSdate">('.$_temp[0].') :</span><br />
      <span class="MStexte">'.$_temp[2].'</span>
    </li>';

if($ip_list=="ok"){
if((!ereg($_temp[3],$list_ip))||(!ereg($_temp[1],$list_ip))){ $list_ip.='<option value="'.$_temp[3].'" title="'.$_temp[3].'">'.$_temp[1].'</option>';}
if((!ereg($_temp[3],$list_ip2))||(!ereg($_temp[1],$list_ip2))){ $list_ip2.='<option value="'.$_temp[3].'" title="'.$_temp[3].'">'.htmlentities($_temp[1]).'</option>';}

}
    $toutMySpeach2.='
    <li class="'.$my_ms["couleur"].'">
      '.$my_ms["admin_boutton"].'
      <span '.$my_ms["admin_survol"].' class="'.$my_ms["test_class"].'">'.htmlentities($_temp[1]).' </span>
      <span class="MSdate">('.$_temp[0].') :</span><br />
      <span class="MStexte">'.htmlentities($_temp[2]).'</span>
    </li>';
}

?>
