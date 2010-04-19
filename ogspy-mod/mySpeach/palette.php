<?php
if($_GET['chm']!=""){$chemin=htmlentities($_GET['chm'], ENT_QUOTES);}
if($_GET['skin']!=""){$skin=htmlentities($_GET['skin'], ENT_QUOTES);}
$colors= array('00', '33', '66', '99', 'CC', 'FF');
$size=sizeOf($colors);
for ($red = 0; $red<$size; $red++) {
    echo '<table style="float:left">'."\n";
    for ($green = 0; $green<$size; $green++) {
        echo "<tr>\n";
        for ($blue = 0; $blue<$size; $blue++) {
            $color = $colors[$red] . $colors[$green] . $colors[$blue];
            echo '<td style="background-color: #'.$color.'">';
            echo '
	    <img src="'.$chemin.'/'.$skin.'/transp5px.gif" height="15px" title="'.$color.'"
	    onclick="MY_MS_bbcode(\'#'.$color.'\',\'col\');"
	    ondblclick="MY_MS_block_clr(\'#'.$color.'\');MY_MS_ferme(\'popupAddressbook\');"/>';
            echo "</td>\n";

        }
    echo "</tr>\n";
    }
    echo "</table>\n";
}
?>

