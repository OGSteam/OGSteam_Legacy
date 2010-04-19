<?php
function my_MS_genWebColor($nom) {
  $out='<select name="'.$nom.'">';
  $couleur = array('00', '33', '66', '99', 'CC', 'FF');
  for ( $rouge = 0; $rouge<count($couleur); $rouge++ )
  {
  
      for ( $vert = 0; $vert<count($couleur); $vert++ )
      {
  
          for ( $bleu = 0; $bleu<count($couleur); $bleu++ )
          {
              $Cellcouleur = $couleur[$rouge] . $couleur[$vert] . $couleur[$bleu];
              $out.='<option style="background-color: #'.$Cellcouleur.'" value="'.$Cellcouleur.'">#'.$Cellcouleur.'</option>';
          }
  
      }
  
  }
  $out.='</select>';
  
  return $out;
}

function my_MS_countfilesandclean($rep,$max) {
    $repertoire = openDir($rep);
    $n=0;
    while ($fichier = readDir($repertoire)) {
      if($fichier!="." AND $fichier!="..") {
        $filesarray[$fichier]=$fichier;
        $n++;
      }
    }
    
    if($n>$max){
    $dif=$n-$max;
    
      sort($filesarray);
      for($i=$dif; $i>0; $i--) {
        unlink('temp/'.$filesarray[$i]);
      }
    }
    
    return $n;
}



function my_MS_getSkins($rep,$skin_actuel){
  $repertoire = openDir($rep);
  $out='
  <select name="les_skins">';
  while ($fichier = readDir($repertoire)) {
    if($fichier!="." AND $fichier!=".." AND is_dir($rep.$fichier)) {
    if($skin_actuel==$fichier) {$selected=' selected="selected"';} else {$selected='';}
    $out.='
    <option value="'.$fichier.'"'.$selected.'>'.ucfirst($fichier).'</option>';
    }
   }
  $out.='
  </select>';
  
  return $out;
}


function my_MS_getrestorefiles($rep) {
    $repertoire = openDir($rep);
    $n='';
    while ($fichier = readDir($repertoire)) {
      if($fichier!="." AND $fichier!="..") {
        $n++;
        $filesarray[$fichier]=$fichier;
      }
    }
    if($n>0) { sort($filesarray); }
    return $filesarray;
}

function my_MS_datefr($date_sql){
  $date_fr=date("d-m-Y à H:i:s", $date_sql);
  return $date_fr;
}

if($_GET['chm']){$chm=htmlentities($_GET['chm']);}
$ip=htmlentities($_SERVER['REMOTE_ADDR'], ENT_QUOTES);

function my_MS_plus_un($lui,$ip,$fichier,$ki="",$son="",$chm="",$mes=""){
$lui=trim($lui);
if($ki!=""){$ki=trim($ki);$ki='<big>'.$ki.'</big>';}else{$ki="";}
if(is_readable($fichier) AND is_writable($fichier)){
$fp=fopen($fichier,'r');
while (!feof($fp)) {
$ligne=explode("£",fgets($fp,255));
if((strlen($ligne[0])>2)&&($lui!=$ligne[0])&&($ligne[2]>=(time()-300))){$enligne.=$ligne[0].'£'.$ligne[1].'£'.$ligne[2].'£'.$ligne[3].'£'.$ligne[4].'£'.$ligne[5]."£\n"; }
}
//$enligne.=$lui.'£'.$ip.'£'.time().'£'."\n";
$enligne.=$lui.'£'.$ip.'£'.time().'£'.$ki.'£'.$son.'£'.$mes."£\n";
fclose($fp);
$fpa=fopen($fichier,'w+');
fwrite($fpa,$enligne);
fclose($fpa);
if($son!=""){print '<img src="'.$chm.'/cloche.gif" alt=""/> Ding !! '.$son ;}
}
}

function my_MS_il_part($part,$fichier){
$fp=fopen($fichier,'r');
while (!feof($fp)) {
$ligne=explode("£",fgets($fp,255));
if(($ligne[0]!=$part)&&(strlen($ligne[0])>2)){$enligne.=$ligne[0].'£'.$ligne[1].'£'.$ligne[2].'£'.$ligne[3].'£'.$ligne[4].'£'.$ligne[5]."£\n";}
}
fclose($fp);
$fpa=fopen($fichier,'w+');
fwrite($fpa,$enligne);
fclose($fpa);
 }

function my_MS_choix_couleur($coul1, $coul2) {
  static $coul;
  if ($coul == $coul1) {
    $coul = $coul2;
  }
  else {
    $coul = $coul1;
  }
  return $coul;
}

function my_MS_compteur($fichier){
$fp=fopen($fichier,"r");
while (!feof($fp)) {
$ligne=explode("£",fgets($fp,255));
if((time()-$ligne[2])<=300){
if(strlen($ligne[3])>5){$ligne[0]=$ligne[3];}
if($ligne[0]=="@@@"){$ligne[0]="";$ding.="[".$ligne[4]."[".$ligne[5]."[";}else{$ding='';}
if(strlen($ligne[0])>1){
$qui.='<a href="" onclick="MY_MS_son(\''.$ligne[0].'\');return(false)">'.$ligne[0]."</a>~~";
}
}
}

$nb=substr_count($qui, "~~") ;
if($nb>1){$s="s";}
$compteur=$nb ." connecté".$s;
$res= htmlentities($compteur)."<br />".str_replace("~~",", ",$qui);
$res=rtrim($res,', ');

return $ding.$res;

}


function my_MS_maj($vers,$id,$chm){
  if(!file_exists($chm.'/admin/maj')){
    $oldumask = umask(0);
    mkdir($chm.'/admin/maj',0777);
    umask($oldumask); 
  }

  //test pour voir si on a deja fais le test aujourdh'ui
  $today=date("d-m-Y");
  $testfile='maj_'.$today.'.lock';
  if(!file_exists($chm.'/admin/'.$testfile)) {
    //o recupere les ifnos sur graphiks.net
    $contents = '';
    $handle = fopen('http://www.graphiks.net/api/myspeach_maj.php?maj='.$vers.'&id='.$id.'&chm='.$chm, 'rb');
    while (!feof($handle)) {
      $contents .= fread($handle, 8192);
    }
    fclose($handle);
    //on le creer et on test si une mise a jours existe
    $fp=@fopen($chm.'/admin/maj/'.$testfile,"w+");
    if(@fputs($fp,$contents)){
      fclose($fp);
    }
  }
  
  
  //on li le fichier cree : 
  $contents = '';
  $handle = fopen($chm.'/admin/maj/'.$testfile, 'r');
  while (!feof($handle)) {
    $contents .= fread($handle, 8192);
  }
  fclose($handle);
  
  if(trim($contents)==""){
    $contents='ok';
  }
  
  
  //on fais un petit nettoyage
    $repertoire = openDir($chm.'/admin/maj/');
    $n=0;
    while ($fichier = readDir($repertoire)) {
      if($fichier!="." AND $fichier!=".." AND $fichier!=$testfile) {
        if($fichier!=""){
          unlink($chm.'/admin/maj/'.$fichier);
        }
      }
    }
  
  return $contents;
}

function even_better_wordwrap($str,$cols,$cut) {
   $tag_open = '<';
   $tag_close = '>';
   $count = 0;
   $in_tag = 0;
   $str_len = strlen($str);
   $segment_width = 0;

   for ($i=0 ; $i<=$str_len ; $i++){
       if ($str[$i] == $tag_open) {
       //tamos dentro de uma tag html
           $in_tag++;
           } elseif ($str[$i] == $tag_close) {
           //fechamos uma tag html
               if ($in_tag > 0)
                   $in_tag--;
           } else {
               if ($in_tag == 0) {
           //se nao estamos dentro de uma tag html
                   $segment_width++;
		   if ($str[$i] == " ") {$segment_width=0;}
                   if (($segment_width > $cols) && ($str[$i] != " ")) {
               //se passamos o limite de colunas acrescentamos o $cut no sitio
                       $str = substr($str,0,$i).$cut.substr($str,$i,$str_len-1);
                       $i += strlen($cut);
                       $str_len = strlen($str);
                       $segment_width = 0;
                   }
               }
           }
   }
   return $str;
}
?>
