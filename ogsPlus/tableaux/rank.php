<?php 

// Interdiction de la mise en cache
  header("Cache-Control: no-cache, must-revalidate"); 
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// Récupération de l'ID dans l'URL
  $id_u = urldecode($_GET["id"]);

// Connexion à la BDD
  require ('../admin/connexion.php'); 
  
// Récupération des données 
  $quet = mysql_query("SELECT * FROM users WHERE id ='$id_u'");
  while ($result = mysql_fetch_array($quet)) {
    $nom_u = $result["nom"]; 
    $alli_u = $result["alli"];
    $uni_u = $result["uni"];
    $tld = $result["tld"];
    $date = date('d/m/y H:i', $result["uptime"]);
    $ppts = $result["ppts"];
    $progpts = $result["progpts"];
    $tpts = $result["tpts"];
    $pvaiss = $result["pvaiss"];
    $progvaiss = $result["progvaiss"];
    $tvaiss = $result["tvaiss"];
    $prech = $result["prech"];
    $progrech = $result["progrech"];
    $trech = $result["trech"];
    $lng = $result["lng"];
    $bg = $result["rank_bg"];
    $rank_separ = $result["rank_separ"];
    $r1 = $result["rvb_rank_r_1"];
    $r2 = $result["rvb_rank_r_2"];
    $r3 = $result["rvb_rank_r_3"];
    $r4 = $result["rvb_rank_r_4"];
    $v1 = $result["rvb_rank_v_1"];
    $v2 = $result["rvb_rank_v_2"];
    $v3 = $result["rvb_rank_v_3"];
    $v4 = $result["rvb_rank_v_4"];
    $b1 = $result["rvb_rank_b_1"];
    $b2 = $result["rvb_rank_b_2"];
    $b3 = $result["rvb_rank_b_3"];
    $b4 = $result["rvb_rank_b_4"];
    $r_txt_rank = $result["r_txt_rank"];
    $v_txt_rank = $result["v_txt_rank"];
    $b_txt_rank = $result["b_txt_rank"];
    $r_chiff_rank = $result["r_chiff_rank"];
    $v_chiff_rank = $result["v_chiff_rank"];
    $b_chiff_rank = $result["b_chiff_rank"];
 }

// Trouver le fichier
  $fichier_img = "../rank/".$id_u.".png";

// Choix du fond de l'image
  $image = imagecreatefrompng("rankprod/$bg.png");

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
    $perso5 = imagecolorallocate($image, $r_chiff_rank, $v_chiff_rank, $b_chiff_rank);
    $perso6 = imagecolorallocate($image, $r_txt_rank, $v_txt_rank, $b_txt_rank);
    
// Coloration du fond
  ImageFilledRectangle ($image, 1, 19, 348, 43, $perso1);
  ImageFilledRectangle ($image, 1, 45, 348, 58, $perso2);
  ImageFilledRectangle ($image, 1, 60, 348, 73, $perso3);
  ImageFilledRectangle ($image, 1, 75, 348, 88, $perso4);

// Lignes verticales
  ImageLine ($image, 90, 45, 90, 88, $noir);
  ImageLine ($image, 160, 60, 160, 73, $noir);
  ImageLine ($image, 175, 45, 175, 88, $noir);
  ImageLine ($image, 245, 60, 245, 73, $noir);
  ImageLine ($image, 260, 45, 260, 88, $noir);
  ImageLine ($image, 334, 60, 334, 73, $noir);

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
if($rank_separ == 0){
$tptsbis = $tpts;
$tvaissbis = $tvaiss;
$trechbis = $trech;
}
if($rank_separ == 1){
$tptsbis = number_format($tpts, 0, '', ' ');
$tvaissbis = number_format($tvaiss, 0, '', ' ');
$trechbis = number_format($trech, 0, '', ' ');
}
if($rank_separ == 2){
$tptsbis = number_format($tpts, 0, '', '.');
$tvaissbis = number_format($tvaiss, 0, '', '.');
$trechbis = number_format($trech, 0, '', '.');
}

// Résumé de l'utilisateur
  imagestring($image, 2, 5, 18, "$nom_l : $nom_u", $perso6);
  imagestring($image, 2, 255, 18, "$uni_l : $uni_u", $perso6);
  
  imagestring($image, 2, 5, 29, "$alli_l : $alli_u", $perso6);
  imagestring($image, 2, 255, 29, "OGame.$tld", $perso6);

// Tableau
  imagestring($image, 1, 5, 48, "$date", $gris);
  imagestring($image, 2, 5, 60, "$place_l", $perso6);
  imagestring($image, 2, 5, 75, "$points_l", $perso6);
  
  imagestring($image, 2, 95, 45, "$points_l", $perso6);
  imagestring($image, 2, 95, 60, "$ppts", $perso5);
  imagestring($image, 2, 95, 75, "$tptsbis", $perso5);
  
  imagestring($image, 2, 180, 45, "$vaiss_l", $perso6);
  imagestring($image, 2, 180, 60, "$pvaiss", $perso5);
  imagestring($image, 2, 180, 75, "$tvaissbis", $perso5);
      
  imagestring($image, 2, 265, 45, "$rech_l", $perso6);
  imagestring($image, 2, 265, 60, "$prech", $perso5);
  imagestring($image, 2, 265, 75, "$trechbis", $perso5);  

// Symboles de progression
  $array = preg_split('//', $progpts, -1, PREG_SPLIT_NO_EMPTY);

  $a = 2;
  $b = 160;
  $c = 60;

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
  $c = 60;

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
  $c = 60;

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
