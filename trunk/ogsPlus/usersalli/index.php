<?php

session_start();

$lng = $_GET["lng"]; 
$page = $_GET["page"];

if(!empty($_SESSION['id'])) {

}else{

include("kick.php");

}

if(!empty($_GET["lng"])) {

}else{

include("kick.php");

}

if($_SESSION['sousdossier'] == alli) {

}else{

include("kick.php");

}

include("../langages/lng_$lng.php");

$_SESSION['id'] = $id;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $xml_lang; ?>" >

   <head>

            <title>OGPlus</title>
            <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
            <link rel="stylesheet" media="screen" type="text/css" title="Exemple" href="../css/formate.css" />

            <meta http-equiv="pragma" content="no-cache" />

   </head>

   <body>

       <!-- L'en-tête -->

       <div id="en_tete">
      <a href="http://ogplus.free.fr"><img src="../img/logo.png" class="imageflottante" alt="Image flottante" width="241" height="88" /></a> <br /><center><SCRIPT language="javascript" SRC="http://ads.allotraffic.com/clicstandart?id=7053"></SCRIPT></center>
       </div>

       <!-- Les menus -->
       
  <div id="menu">  
      
           <div class="titre_menu">
           <?php echo $lng_ab_ca; ?>
           </div>
           
                <div class="element_menu">
           
                   > <a href="index.php?lng=<?php echo $lng ?>&page=galerie.php"><?php echo $lng_bm_aa ?></a><br />
                   > <a href="index.php?lng=<?php echo $lng ?>&page=rank.php"><?php echo $lng_bm_ab ?></a><br />
                   > <a href="index.php?lng=<?php echo $lng ?>&page=img.php"><?php echo $lng_bm_ac ?></a><br /><br />
                   > <a href="index.php?lng=<?php echo $lng ?>&page=profil.php"><?php echo $lng_bm_ad ?></a><br />
                   > <a href="index.php?lng=<?php echo $lng ?>&page=logout.php"><?php echo $lng_bm_ae ?></a><br />
            
            </div>

       </div>
  
       <!-- Le corps -->
       
       <div id="titre_corps">
       OGPlus
       </div>       

       <div id="corps">
         
         <?php 
            $path = $_SERVER["DOCUMENT_ROOT"];//nécéssaire
            $goto = "$path" . "/usersalli/" . "$page";
            
            if (isset($_GET['page'])&&is_file($goto))
            {
            include "$goto";
            }
            else if (isset($_GET['page'])&&preg_match('`\.`', $_GET['page']))
            {
            include "$path" . "/usersalli/galerie.php";//possibilité de mettre ici une page erreur.php 
            }
            else if (empty($_GET['page']))
            {
            include "$path" . "/usersalli/galerie.php";//page par défault
            }
            else
            {
            include "$path" . "/usersalli/galerie.php";//possibilité de mettre ici une page erreur.php
            }
            ?>       
           
       </div>
       
              
   </body>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-816698-2";
urchinTracker();
</script>
</html>
