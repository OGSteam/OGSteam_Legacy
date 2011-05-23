<?php
#################################################
# Copyrigh GUNNING Sky et Guillouet Bruno
# Licence : GNU/GPL
# Modifiable à souhaits, à une seule condition :
#
#   ->  laisser le lien vers le site http://www.graphiks.net sur le chat.   <-
# 
# Version Originale non modifié
# Script est soumis à la licence CECCIL/GNU
#################################################

session_start();
$sessionER=0;
$cookER='0';
$testlogin=$_POST['MSpseudo'];

if((isset($_GET['psd']))&&($_GET['psd']!="Pseudo")){$testlogin=$_GET['psd'];}

setcookie("myspeach_pseudo",$testlogin,time()+365 * 24 * 3600, "/");

$dateNow = mktime(date('H'),date('i'),date('s'),date('m'), date('d'), date('Y'));
$dateThen = mktime(date('H'),date('i'),date('s')+2,date('m'), date('d'), date('Y'));

//--------------------------------------------
//Systeme anti-flood
if(!$_SESSION['floodsss']){
$_SESSION['floodsss']=$dateThen;
$sessionER=0;
}elseif($_SESSION['floodsss'] < $dateNow){
$_SESSION['floodsss']=$dateThen;
$sessionER=0;
}elseif($_SESSION['floodsss'] > $dateNow){
$sessionER=1;
}
//Fin du anti-flood
//---------------------------------------------

include("admin/config.php");
include("admin/options.php");
include("admin/setup.php");
include("error.php");
if($_GET['aj']=="ax"){$er1=1;$er2=2;$er3=3;$er4=4;} //gestion des erreurs

/* blocage par IP */
if(isset($_SERVER["REMOTE_ADDR"])){
  $ipVisiteur = htmlentities($_SERVER["REMOTE_ADDR"]);
}else{
  $ipVisiteur = "inexistant";
}
if(ereg($ipVisiteur,$my_ms['ipstop'])){
  exit(print $er1);
}
/* fin blocage par IP */

  //Netoyage :
	$testAdminLogin='my_'.md5($my_ms['admin_login']);
	$testAdminMdp='my_'.md5($my_ms['admin_mdp']);
  $testAdminLogin1=$my_ms['admin_login'];
	$testAdminMdp1=$my_ms['admin_mdp'];
	if(isset($_COOKIE[$testAdminLogin]) AND $_COOKIE[$testAdminLogin]==$testAdminMdp){ $testCookie=$_COOKIE[$testAdminLogin]; }else{ $testCookie=''; }

$testlogin1=$_POST['MSpseudo'];
if((isset($_GET['psd']))&&($_GET['psd']!="Pseudo")){$testlogin1=$_GET['psd'];}
//-------------------------------------------------------------------------------

	$testlogin1=strtolower($testlogin1);
	$testlogin1=trim($testlogin1);

  if($testlogin1==""){exit(print $er2); }
  //Fin

  $myverif="ok";
	if(eregi($testAdminLogin1,$testlogin)  OR eregi("webmaster",$testlogin1) OR eregi("root",$testlogin1) OR eregi("admin",$testlogin1)){
		if(isset($_COOKIE[$testAdminLogin]) AND $_COOKIE[$testAdminLogin]==$testAdminMdp){
      $myverif="ok";
		 }else{
      $myverif="non";
		}
	}

if($myverif=="ok" AND $sessionER==0){
  $fp = fopen("saves/x.txt","r");
  $x = fgets($fp,11);
  fclose($fp);

  //Si POST[message] et pseudo exite, on pase a la suite :
   if((isset($_POST["MSmessage"]) && isset($_POST["MSpseudo"]))||(isset($_GET["mess"]) && isset($_GET["psd"]))){

   //Si oui, on ajoute le texte dans le fichier temporaire
    
    $heure = gmdate("H:i", time() + 3600*($my_ms['hDeca']+date("I")));
    $pseudo=htmlspecialchars($testlogin);

    if(strtolower($pseudo)==strtolower("$my_ms[admin_login]") AND $_COOKIE[$testAdminLogin]==$testAdminMdp){
        $pseudo="*ADMIND*".$pseudo;
    }
    if(isset($_COOKIE['ms_moderateur']) AND !isset($_COOKIE[$testAdminLogin])){
      $thisUser=$_COOKIE['ms_moderateur'];
      $temp=split(',',$my_ms['moderateur']);
      $connect=0;
      for($i=0; $i<count($temp); $i++){
        $testUser=$temp[$i];
        if($thisUser==$testUser AND eregi($pseudo,$testUser)){
          $connect=1;
        } 
      }
      if($connect==1){
        $pseudo="#MODO#".$pseudo;
      }
    }

  if(isset($_POST["MSmessage"])){ $message=htmlspecialchars($_POST["MSmessage"]); }
  if(isset($_GET["mess"])){       $message=htmlspecialchars(urldecode($_GET["mess"]));       }

  $message=str_replace("\n",'',$message);$message=str_replace("\t",'',$message); $message=str_replace("\r",'',$message);
// netoyage des bbcode en trop
  $message=preg_replace('!\*(b|i|s|u|big|small|sup)\*\*\*!isU','', $message);
  $message=str_replace('[][]','[]',$message);
  $message=preg_replace('!\[(#[a-fA-F0-9]{6})\](| )\[\]!isU','', $message);

  $pseudo=str_replace("\n",'',$pseudo);$pseudo=str_replace("\t",'',$pseudo);$pseudo=str_replace("\r",'',$pseudo);
  
  //Conversion des caractères bizards : (en l'ocurence, le €
  $myms_trans = array("%u20AC" => "&euro;");
  $message=strtr($message,$myms_trans);
  
$fp = fopen('saves/'.$my_ms['msg_txt'], "a+");
fwrite($fp, $heure."\t");
fwrite($fp, $pseudo."\t");
fwrite($fp, $message."\t");
fwrite($fp, htmlentities($_SERVER['REMOTE_ADDR'])."
");
fclose($fp);
    
//On verifie la taille du fichier actuelle de sauvegarde :
$taille=filesize ("saves/".$x.".txt");
$tailleUp=25000;


// echo '<br>la taille du fichier actuelle est : '.$taille.'<br>';
// Si elle est superieur a 20 000octet (20ko)
	if($taille>$tailleUp){
		//On creer un nouveau fichier de saves en fonction de la dernier en faisant +1
		$fp = fopen("saves/x.txt","r+");
		$whatx = fgets($fp,11);
		$whatx++;
		fseek($fp,0);
		fputs($fp,$whatx);
		fclose($fp);
    $myE['xx']=$whatx;
  }
  
  if(isset($myE['xx'])){
    $myE['xx']=$whatx;
    $fp1=fopen('saves/'.$myE['xx'].'.txt',"w");
    fclose($fp1);
  }else{
    $myE['xx']=$x;
  }
  

    $heure = gmdate("H:i", time() + 3600*($my_ms['hDeca']+date("I")));
    $pseudo=htmlspecialchars($testlogin);

    if(strtolower($pseudo)==strtolower($my_ms['admin_login']) AND $_COOKIE[$testAdminLogin]==$testAdminMdp){
      $pseudo="*ADMIND*".$pseudo;
    }

  if(isset($_POST["MSmessage"])){ $message=htmlspecialchars($_POST["MSmessage"]); }
  if(isset($_GET["mess"])){ $message=htmlspecialchars($_GET["mess"]); }
  //Conversion des caractères bizards : (en l'ocurence, le €
  $myms_trans = array("%u20AC" => "&euro;");
  $message=strtr($message,$myms_trans);
  
  
$fp = fopen("saves/".$myE['xx'].".txt", "a+");
fwrite($fp, $heure."\t");
fwrite($fp, $pseudo."\t");
fwrite($fp, $message."\t");
fwrite($fp, $_SERVER['REMOTE_ADDR']."
");
fclose($fp);
}

/* enlevons les messages en trops */
function cleanUpTheChat($msg_txt, $_nbr_) {
$tableau=file($msg_txt);
$nb=count($tableau);

if($nb >= $_nbr_){

$tableau=file($msg_txt);
$nblignes=count($tableau);

	if($nblignes>=$_nbr_){
	$fp = fopen($msg_txt, "w+");

	$T=$nblignes-$_nbr_;
	
  for($i=$T; $i<$nblignes; $i++){
    $tableau[$i]=str_replace("/n","",$tableau[$i]);
    fwrite($fp, $tableau[$i]);
  }
	
	fclose($fp);
	}
}
}
cleanUpTheChat('saves/'.$my_ms['msg_txt'], $_nbr_);
//--
//fin

//On redirige :
  $cettepage=htmlentities($_POST['cettepage'], ENT_QUOTES);
 if($_GET['aj']!="ax"){header("location: ".$cettepage);}

}else{

  if($myverif!="ok"){ print $er3;}
	if($sessionER==1 or $cookER==1){ print $er4;}

}

?>
