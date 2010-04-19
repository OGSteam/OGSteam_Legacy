<?php
include("../smileys.php");

$toutImage = '<table border="1">
<tr><td colspan="2"><b>Config actuel</b></td></tr>
';
foreach ($smileys as $signe => $image) {
    $TempArray[$image]=$signe;
    $image_smiley='<img border="0" src="../smiley/'.$smileys[$signe]. '.gif">'; 
    $toutImage .= '<tr><td>'.$image_smiley.'</td><td>'.$signe.'</td></tr>';
    }
$toutImage .= '</table>';
?>