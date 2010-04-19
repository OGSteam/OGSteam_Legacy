<?php 

// Interdiction de la mise en cache
  header("Cache-Control: no-cache, must-revalidate"); 
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// Récupération de l'ID dans l'URL
  $id_u = urldecode($_GET["id"]);

// Connexion à la BDD
  require ('../admin/connexion.php'); 
  
// Récupération des données 
  $quet = mysql_query("SELECT * FROM alli WHERE id ='$id_u'");
  while ($result = mysql_fetch_array($quet)) {
    $nom = $result["nom"]; 
    $alli = $result["alli"];
    $tag = $result["tag"];
    $uni_u = $result["uni"];
    $tld = $result["tld"];
    $date = date('d/m/y H:i', $result["uptime"]);
    $ppts = $result["ppts"];
    $progpts = $result["progpts"];
    $tpts = $result["tpts"];
    $tmpts = $result["tmpts"];
    $pvaiss = $result["pvaiss"];
    $progvaiss = $result["progvaiss"];
    $tvaiss = $result["tvaiss"];
    $tmvaiss = $result["tmvaiss"];
    $prech = $result["prech"];
    $progrech = $result["progrech"];
    $trech = $result["trech"];
    $tmrech = $result["tmrech"];
    $lng = $result["lng"];
    $mbrs = $result["mbrs"];
    $bg = $result["bg"];
    $separ = $result["separ"];
    $r1 = $result["rvb_r_1"];
    $r2 = $result["rvb_r_2"];
    $r3 = $result["rvb_r_3"];
    $r4 = $result["rvb_r_4"];
    $r5 = $result["rvb_r_5"];
    $v1 = $result["rvb_v_1"];
    $v2 = $result["rvb_v_2"];
    $v3 = $result["rvb_v_3"];
    $v4 = $result["rvb_v_4"];
    $v5 = $result["rvb_v_5"];
    $b1 = $result["rvb_b_1"];
    $b2 = $result["rvb_b_2"];
    $b3 = $result["rvb_b_3"];
    $b4 = $result["rvb_b_4"];
    $b5 = $result["rvb_b_5"];
    $r_txt_rank = $result["r_txt"];
    $v_txt_rank = $result["v_txt"];
    $b_txt_rank = $result["b_txt"];
    $r_chiff_rank = $result["r_chiff"];
    $v_chiff_rank = $result["v_chiff"];
    $b_chiff_rank = $result["b_chiff"];
 }

// Trouver le fichier
  $fichier_img = "../alli/".$id_u.".png";

// Choix du fond de l'image
  $image = imagecreatefrompng("alli/$bg.png");

// Référencement des couleurs utilisées
  $blanc = imagecolorallocate($image, 255, 255, 255);
  $noir = imagecolorallocate($image, 0, 0, 0);
  $rouge = imagecolorallocate($image, 255, 0, 0);
  $vert = imagecolorallocate($image, 0, 150, 0);
  $bleu = imagecolorallocate($image, 0, 0, 255);
  $gris = imagecolorallocate($image, 130, 130, 130);
  
    $perso1 = imagecolorallocate($image, $r1, $v1, $b1);
    $perso2 = imagecolorallocate($image, $r2, $v2, $b2);
    $perso3 = imagecolorallocate($image, $r3, $v3, $b3);
    $perso4 = imagecolorallocate($image, $r4, $v4, $b4);
    $perso7 = imagecolorallocate($image, $r5, $v5, $b5);
    $perso5 = imagecolorallocate($image, $r_chiff_rank, $v_chiff_rank, $b_chiff_rank);
    $perso6 = imagecolorallocate($image, $r_txt_rank, $v_txt_rank, $b_txt_rank);
    
// Coloration du fond
  ImageFilledRectangle ($image, 1, 19, 348, 58, $perso1);
  ImageFilledRectangle ($image, 1, 60, 348, 73, $perso2);
  ImageFilledRectangle ($image, 1, 75, 348, 88, $perso3);
  ImageFilledRectangle ($image, 1, 90, 348, 103, $perso4);
  ImageFilledRectangle ($image, 1, 105, 348, 118, $perso7);
  

// Lignes verticales
  ImageLine ($image, 90, 59, 90, 119, $noir);
  ImageLine ($image, 160, 75, 160, 88, $noir);
  ImageLine ($image, 175, 59, 175, 119, $noir);
  ImageLine ($image, 245, 75, 245, 88, $noir);
  ImageLine ($image, 260, 59, 260, 119, $noir);
  ImageLine ($image, 334, 75, 334, 88, $noir);

// Récupération du fichier de langage
  include ("../langages/lng_$lng.php");

  $nom_l = $lng_za_aa; 
  $uni_l = $lng_za_ab;
  $alli_l = $lng_za_ac;
  $place_l = $lng_za_ad;
  $points_l = $lng_za_ae;
  $vaiss_l = $lng_za_af;
  $rech_l = $lng_za_ag;
  
// Mise en forme des points
if($separ == 0){
$tptsbis = $tpts;
$tvaissbis = $tvaiss;
$trechbis = $trech;
$tmptsbis = $tmpts;
$tmvaissbis = $tmvaiss;
$tmrechbis = $tmrech;
}
if($separ == 1){
$tptsbis = number_format($tpts, 0, '', ' ');
$tvaissbis = number_format($tvaiss, 0, '', ' ');
$trechbis = number_format($trech, 0, '', ' ');
$tmptsbis = number_format($tmpts, 0, '', ' ');
$tmvaissbis = number_format($tmvaiss, 0, '', ' ');
$tmrechbis = number_format($tmrech, 0, '', ' ');
}
if($separ == 2){
$tptsbis = number_format($tpts, 0, '', '.');
$tvaissbis = number_format($tvaiss, 0, '', '.');
$trechbis = number_format($trech, 0, '', '.');
$tmptsbis = number_format($tmpts, 0, '', '.');
$tmvaissbis = number_format($tmvaiss, 0, '', '.');
$tmrechbis = number_format($tmrech, 0, '', '.');
}

// Résumé de l'utilisateur
  imagestring($image, 2, 5, 18, "$lng_za_aa : $alli", $perso6);
  imagestring($image, 2, 5, 32, "$lng_za_ac : $tag", $perso6);
  imagestring($image, 2, 5, 45, "$lng_zc_aa : $nom", $perso6);
  
  imagestring($image, 2, 240, 18, "$lng_zc_ab : $mbrs", $perso6);
  imagestring($image, 2, 240, 32, "$uni_l : $uni_u", $perso6);
  imagestring($image, 2, 240, 45, "OGame.$tld", $perso6);

// Tableau
  imagestring($image, 1, 5, 63, "$date", $gris);
  imagestring($image, 2, 5, 75, "$place_l", $perso6);
  imagestring($image, 2, 5, 90, "$lng_zc_ac", $perso6);
  imagestring($image, 2, 5, 105, "$lng_zc_ad", $perso6);
  
  imagestring($image, 2, 95, 60, "$points_l", $perso6);
  imagestring($image, 2, 95, 75, "$ppts", $perso5);
  imagestring($image, 2, 95, 90, "$tptsbis", $perso5);
  imagestring($image, 2, 95, 105, "$tmptsbis", $perso5);
  
  imagestring($image, 2, 180, 60, "$vaiss_l", $perso6);
  imagestring($image, 2, 180, 75, "$pvaiss", $perso5);
  imagestring($image, 2, 180, 90, "$tvaissbis", $perso5);
  imagestring($image, 2, 180, 105, "$tmvaissbis", $perso5);
      
  imagestring($image, 2, 265, 60, "$rech_l", $perso6);
  imagestring($image, 2, 265, 75, "$prech", $perso5);
  imagestring($image, 2, 265, 90, "$trechbis", $perso5);
  imagestring($image, 2, 265, 105, "$tmrechbis", $perso5);   

// Symboles de progression
  $array = preg_split('//', $progpts, -1, PREG_SPLIT_NO_EMPTY);

  $a = 2;
  $b = 160;
  $c = 75;

  foreach($array as $element) {
    $b += 6;
    switch($element) {
      case '+':
        imagechar($image, $a, $b, $c, $element, $vert);
        break;
      case '-':
        imagechar($image, $a, $b, $c, $element, $rouge);
        break;
      case '*':
        imagechar($image, $a, $b, $c, $element, $bleu);
        break;
      default:
        imagechar($image, $a, $b, $c, $element, $blanc);
    }
  }

  $array = preg_split('//', $progvaiss, -1, PREG_SPLIT_NO_EMPTY);

  $a = 2;
  $b = 245;
  $c = 75;

  foreach($array as $element) {
    $b += 6;
    switch($element) {
      case '+':
        imagechar($image, $a, $b, $c, $element, $vert);
        break;
      case '-':
        imagechar($image, $a, $b, $c, $element, $rouge);
        break;
      case '*':
        imagechar($image, $a, $b, $c, $element, $bleu);
        break;
      default:
        imagechar($image, $a, $b, $c, $element, $blanc);
    }
  }

  $array = preg_split('//', $progrech, -1, PREG_SPLIT_NO_EMPTY);

  $a = 2;
  $b = 334;
  $c = 75;

  foreach($array as $element) {
    $b += 6;
    switch($element) {
      case '+':
        imagechar($image, $a, $b, $c, $element, $vert);
        break;
      case '-':
        imagechar($image, $a, $b, $c, $element, $rouge);
        break;
      case '*':
        imagechar($image, $a, $b, $c, $element, $bleu);
        break;
      default:
        imagechar($image, $a, $b, $c, $element, $blanc);
    }
  }

// Création de l'image
  imagepng($image,$fichier_img);

// Libération des ressources
  imagedestroy($image);

// Fermeture de MySQL
  mysql_close();

// Modification du header
  header ("Content-type: image/png");

// Lecture du fichier
  readfile($fichier_img);

?>
