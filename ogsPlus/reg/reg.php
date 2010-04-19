<?php


// Fichier du langage
$lng = $_GET["lng"]; 
include("../langages/lng_$lng.php");

// Conditions générales
$cbox = $_POST['cbox'];

if($cbox == 8) {

// Vérification du mot de passe
  if(!empty($_POST['pass1'])) {
    
      if($_POST['pass1'] == $_POST['pass2']) {

        if($_POST['type'] == 1){
        
// Vérification si le compte n'existe pas déjà (USER)       
      require ('../admin/connexion.php');
      $query1 = sprintf("SELECT nom,uni FROM users WHERE nom='%s' AND uni='%s' ",
      mysql_real_escape_string($nom),
      mysql_real_escape_string($uni));

      $select = mysql_query($query1);

      $data = mysql_fetch_assoc($select);

      $a = $data['nom'] AND $data['uni'];
      $b = $_POST['nom'] AND $_POST['uni'];

        if($a == $b) {

        echo "$lng_ba_aa";
        
        }else{

// Ouverture du compte si tout est valide
        $quet=mysql_query("INSERT INTO users VALUES('', '', '".md5(htmlentities($_POST['pass2']))."', '".htmlentities($_POST['langue'])."', '".time()."', '', '".htmlentities($_POST['nom'])."', '', '".htmlentities($_POST['uni'])."', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '240', '255', '240', '255', '240', '255', '240', '255', '240', '255', '240', '255', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '240', '255', '240', '255', '240', '255', '240', '255', '240', '255', '240', '255')");
        echo '<META http-EQUIV="Refresh" CONTENT="0; url=ok.php?lng='.$lng.'">';

        }
        
        }else{

// Vérification si le compte n'existe pas déjà (ALLI)        
      require ('../admin/connexion.php');
      $query2 = sprintf("SELECT nom,uni FROM alli  WHERE nom='%s' AND uni='%s' ",
      mysql_real_escape_string($nom),
      mysql_real_escape_string($uni));

      $select = mysql_query($query2);


      $data = mysql_fetch_assoc($select);

      $c = $data['nom'] AND $data['uni'];
      $d = $_POST['nom'] AND $_POST['uni'];

        if($c == $d) {

        echo "$lng_ba_aa";
        
        }else{
        
// Ouverture du compte si tout est valide
        $quet=mysql_query("INSERT INTO alli VALUES('', '', '".md5(htmlentities($_POST['pass2']))."', '".htmlentities($_POST['langue'])."', '".time()."', '', '".htmlentities($_POST['nom'])."', '', '', '".htmlentities($_POST['uni'])."', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '240', '255', '240', '255', '240', '255', '240', '255', '240', '255', '240', '255', '240', '240', '240')");
        echo '<META http-EQUIV="Refresh" CONTENT="0; url=ok.php?lng='.$lng.'">';
        
        }
        
        }
  
      }else{

      echo "$lng_ba_ab";
  
      }
  
  }else{
  
  echo "$lng_ba_ac";
  
  }
 
}else{

echo "$lng_ba_ad";

}
?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-816698-2";
urchinTracker();
</script>
