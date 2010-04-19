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

header('Pragma: public');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');


//::: Location de myspeach
  $my_ms['root']='../myspeach';
  $my_ms['img_root']=htmlentities($_GET['chm']);
 $return="false"; //pour up.php
//::: Location de MySpeach



//On inclu les fichiers de config
include($my_ms['root'].'/admin/config.php');
include($my_ms['root'].'/admin/options.php');
include($my_ms['root'].'/admin/setup.php');
include($my_ms['root'].'/admin/fonctions.php');


if(($_GET['rqst']=='message')||($_GET['rqst']=='list')){

($_COOKIE['myspeach_pseudo']!="")?$lepseudo=htmlentities($_COOKIE['myspeach_pseudo'], ENT_QUOTES):$lepseudo="Pseudo";

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

  <head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="pragma" content="no-cache" />
  </head>

  <body>
    ';
//PreConf
$my_ms['cettepage']=htmlentities($_SERVER["REQUEST_URI"]);
$my_ms['cettepage']=str_replace("&amp;","&",$my_ms['cettepage']);

$toutMySpeach2="";

/* On ouvre le fichier message.txt  */
$tableau=file($my_ms['root']."/saves/".$my_ms['msg_txt']);
/* On compte le nombre de ligne */
$nblignes=count($tableau);

/* On ouvre le for avec qui continue tant qu'il est < que $nbr || affichage en fonction de $my_ms["lesens"] * */
if($my_ms["lesens"]=='down'){
  for($i=0; $i<$nblignes; $i++){
    include($my_ms['root'].'/up.php');
  }
}else{
  for($i=$nblignes; $i>=0; $i--){
    include($my_ms['root'].'/up.php');
  }
}
if($_GET['rqst']=='message'){$sortie= $toutMySpeach2;
$trans = array("&lt;" => "<", "&gt;" => ">","&amp;lt;" => "&lt;", "&amp;gt;" => "&gt;","&amp;quot;" => '"', "&quot;" => '"',"&amp;" => "&");
echo strtr($sortie,$trans);}



 if($_GET['rqst']=='list'){
 
   if (isset($_COOKIE['my_'.md5($my_ms['admin_login'])]) AND $_COOKIE['my_'.md5($my_ms['admin_login'])]=='my_'.md5($my_ms['admin_mdp'])){
    if($my_ms["id_unique"]=="") { $my_ms["id_unique"]='pas_de_id_unique'; }
    $maj=my_MS_maj($my_ms["version"],$my_ms["id_unique"],$my_ms["root"]);
    if($maj!="ok"){ 
      $maj=$maj; //si != de ok, y'a une mise a jours
    }else{ 
      $maj=''; //pas de maj
    }
   }else{
    $maj='';
   }
 
   if($list_ip2!=''){
   $select_ip='
   <div  style="float:left"><img src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/coche.gif" title="ban ip" />
   <select id="slct_ip" name="slct_ip" onchange="MY_MS_request(\''.$my_ms['img_root'].'/admin/blok_ip.php?slct_ip=\' +  this.options[this.selectedIndex].value,\'count\');">
   <option value="">Ban IP</option>
   '.$list_ip2.'
   </select></div>
   <a href="" onclick="MY_MS_request(\''.$my_ms['img_root'].'/admin/blok_ip.php?slct_ip=clear\',\'count\');return(false);">
   <div  style="clear:left;"><img src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/coche2.gif" /> Netoyer les IP</div></a>'.
   $maj;
   print $select_ip;
   }
   
 }


}
if($_GET['count']=='count'){
  print my_MS_compteur('saves/ki.txt');// ici le compteur n'apparait pas mais il permet de faire fonctionner le controle des requetes message
}

if($_GET['titre']!=''){
   print htmlentities($_GET['titre']);
  }
?>

</body>
</html>


