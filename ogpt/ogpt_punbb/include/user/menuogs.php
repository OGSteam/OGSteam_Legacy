<?php
require_once  PUN_ROOT . 'ogpt/include/ogpt_pan.php';



$sql = 'SELECT *  FROM mod_fofo_ogs  WHERE  actif=\'1\'  ORDER BY ordre asc ';


$result = $db->query($sql);


while ($mod = $db->fetch_assoc($result)) {


    echo ' <span class="gensmall"><a href="' . $mod['lien'] . '">' . $mod['title'] .
        '</a></span><br> ';


}



?>