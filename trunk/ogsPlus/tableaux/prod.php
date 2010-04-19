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
    $p1m = $result["p1m"];
    $p2m = $result["p2m"];
    $p3m = $result["p3m"];
    $p4m = $result["p4m"];
    $p5m = $result["p5m"];
    $p6m = $result["p6m"];
    $p7m = $result["p7m"];
    $p8m = $result["p8m"];
    $p9m = $result["p9m"];
    $p1c = $result["p1c"];
    $p2c = $result["p2c"];
    $p3c = $result["p3c"];
    $p4c = $result["p4c"];
    $p5c = $result["p5c"];
    $p6c = $result["p6c"];
    $p7c = $result["p7c"];
    $p8c = $result["p8c"];
    $p9c = $result["p9c"];
    $p1d = $result["p1d"];
    $p2d = $result["p2d"];
    $p3d = $result["p3d"];
    $p4d = $result["p4d"];
    $p5d = $result["p5d"];
    $p6d = $result["p6d"];
    $p7d = $result["p7d"];
    $p8d = $result["p8d"];
    $p9d = $result["p9d"];    
    $lng = $result["lng"];
    $bg = $result["prod_bg"];
    $r1 = $result["rvb_prod_r_1"];
    $r2 = $result["rvb_prod_r_2"];
    $r3 = $result["rvb_prod_r_3"];
    $r4 = $result["rvb_prod_r_4"];
    $v1 = $result["rvb_prod_v_1"];
    $v2 = $result["rvb_prod_v_2"];
    $v3 = $result["rvb_prod_v_3"];
    $v4 = $result["rvb_prod_v_4"];
    $b1 = $result["rvb_prod_b_1"];
    $b2 = $result["rvb_prod_b_2"];
    $b3 = $result["rvb_prod_b_3"];
    $b4 = $result["rvb_prod_b_4"];
    $prod_separ = $result["prod_separ"];
    $r_txt_prod = $result["r_txt_prod"];
    $v_txt_prod = $result["v_txt_prod"];
    $b_txt_prod = $result["b_txt_prod"];
    $r_chiff_prod = $result["r_chiff_prod"];
    $v_chiff_prod = $result["v_chiff_prod"];
    $b_chiff_prod = $result["b_chiff_prod"];
  }

// Calcul de la production
  // Métal
  $prodmeth = $p1m + $p2m + $p3m + $p4m + $p5m + $p6m + $p7m + $p8m + $p9m;
  $prodmetj = $prodmeth * 24;
  // Cristal
  $prodcrih = $p1c + $p2c + $p3c + $p4c + $p5c + $p6c + $p7c + $p8c + $p9c;
  $prodcrij = $prodcrih * 24;
  // Deut
  $proddeuth = $p1d + $p2d + $p3d + $p4d + $p5d + $p6d + $p7d + $p8d + $p9d;
  $proddeutj = $proddeuth * 24;

// Trouver le fichier
  $fichier_img = "../prod/".$id_u.".png";

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
    $perso5 = imagecolorallocate($image, $r_chiff_prod, $v_chiff_prod, $b_chiff_prod);
    $perso6 = imagecolorallocate($image, $r_txt_prod, $v_txt_prod, $b_txt_prod);
    
// Coloration du fond
  ImageFilledRectangle ($image, 1, 19, 348, 43, $perso1);
  ImageFilledRectangle ($image, 1, 45, 348, 58, $perso2);
  ImageFilledRectangle ($image, 1, 60, 348, 73, $perso3);
  ImageFilledRectangle ($image, 1, 75, 348, 88, $perso4);

// Lignes verticales
  ImageLine ($image, 85, 45, 85, 88, $noir);
  ImageLine ($image, 170, 45, 170, 88, $noir);
  ImageLine ($image, 256, 45, 256, 88, $noir);

// Récupération du fichier de langage
  include ("../langages/lng_$lng.php");

  $nom_l = $lng_zb_aa; 
  $uni_l = $lng_zb_ab;
  $alli_l = $lng_zb_ab;
  $metal_l = $lng_zb_ad;
  $cristal_l = $lng_zb_ae;
  $deut_l = $lng_zb_af;
  $prod_l = $lng_zb_ag;
  $heure_l = $lng_zb_ah;
  $jour_l = $lng_zb_ai;
  $tag_l = $lng_za_ac;
  
// Mise en forme des points
if($prod_separ == 0){
$prodmethbis = $prodmeth;
$prodmetjbis = $prodmetj;
$prodcrihbis = $prodcrih;
$prodcrijbis = $prodcrij;
$proddeuthbis = $proddeuth;
$proddeutjbis = $proddeutj;
}
if($prod_separ == 1){
$prodmethbis = number_format($prodmeth, 0, '', ' ');
$prodmetjbis = number_format($prodmetj, 0, '', ' ');
$prodcrihbis = number_format($prodcrih, 0, '', ' ');
$prodcrijbis = number_format($prodcrij, 0, '', ' ');
$proddeuthbis = number_format($proddeuth, 0, '', ' ');
$proddeutjbis = number_format($proddeutj, 0, '', ' ');
}
if($prod_separ == 2){
$prodmethbis = number_format($prodmeth, 0, '', '.');
$prodmetjbis = number_format($prodmetj, 0, '', '.');
$prodcrihbis = number_format($prodcrih, 0, '', '.');
$prodcrijbis = number_format($prodcrij, 0, '', '.');
$proddeuthbis = number_format($proddeuth, 0, '', '.');
$proddeutjbis = number_format($proddeutj, 0, '', '.');
}

// Résumé de l'utilisateur

  imagestring($image, 2, 5, 18, "$nom_l : $nom_u", $perso6);
  imagestring($image, 2, 255, 18, "$uni_l : $uni_u", $perso6);
  
  imagestring($image, 2, 5, 29, "$tag_l : $alli_u", $perso6);
  imagestring($image, 2, 255, 29, "OGame.$tld", $perso6);

// Tableau

  imagestring($image, 2, 5, 45, "$metal_l", $perso6);
  imagestring($image, 2, 5, 60, "$prodmethbis", $perso5);
  imagestring($image, 2, 5, 75, "$prodmetjbis", $perso5);
  
  imagestring($image, 2, 90, 45, "$cristal_l", $perso6);
  imagestring($image, 2, 90, 60, "$prodcrihbis", $perso5);
  imagestring($image, 2, 90, 75, "$prodcrijbis", $perso5);
    
  imagestring($image, 2, 175, 45, "$deut_l", $perso6);
  imagestring($image, 2, 175, 60, "$proddeuthbis", $perso5);
  imagestring($image, 2, 175, 75, "$proddeutjbis", $perso5);

  imagestring($image, 1, 260, 48, "$prod_l", $gris);
  
  imagestring($image, 2, 260, 60, "/ $heure_l", $perso6);
  imagestring($image, 2, 260, 75, "/ $jour_l", $perso6);

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
