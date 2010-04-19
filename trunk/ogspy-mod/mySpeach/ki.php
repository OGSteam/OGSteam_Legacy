<?php
header('Pragma: public');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');


include('admin/fonctions.php');

if($_GET['dit']){
$fichier="saves/ki.txt";
  if(ereg("Firefox", $_SERVER['HTTP_USER_AGENT'])){
    $lui=htmlentities(utf8_decode($_GET['dit']));
  }else{
    $lui=htmlentities($_GET['dit']);
  }
  my_MS_plus_un($lui,$ip,$fichier,$ki,$son,$chm,$mes);
}

if($_GET['part']!=''){
$fichier="saves/ki.txt";
  if(ereg("Firefox", $_SERVER['HTTP_USER_AGENT'])){
    $part=htmlentities(utf8_decode($_GET['part']));
  }else{
    $part=htmlentities($_GET['part']);
  }
  my_MS_il_part($part,$fichier);
}
if($_GET['ecrit']){
$fichier="saves/ki.txt";
  if(ereg("Firefox", $_SERVER['HTTP_USER_AGENT'])){
    $ki=htmlentities(utf8_decode($_GET['ecrit']));
  }else{
    $ki=htmlentities($_GET['ecrit']);
  }
  //my_MS_il_ecrit($ki,$ip,$fichier);
    my_MS_plus_un($ki,$ip,$fichier,$ki,$son,$chm,$mes);
}
if(($_GET['son'])&&($_GET['mes'])){
$son=strip_tags($_GET['son']);
$fichier="saves/ki.txt";
  if(ereg("Firefox", $_SERVER['HTTP_USER_AGENT'])){
    $son=htmlentities(utf8_decode($son));
    $mes=htmlentities(utf8_decode($_GET['mes']));
  }else{
    $son=htmlentities($son);
    $mes=htmlentities($_GET['mes']);
  }
  //my_MS_il_ecrit($ki,$ip,$fichier);
    my_MS_plus_un("@@@",$ip,$fichier,$ki,$son,$chm,$mes);
}
?>
