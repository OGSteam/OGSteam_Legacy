<HTML>
<HEAD><TITLE>Smileys</TITLE>
<SCRIPT language="javascript">
function Mssmyle(l) {
	window.opener.document.forms["myspeach"].elements["MSmessage"].value +=' ' + l + ' ';
	window.opener.document.forms["myspeach"].elements["MSmessage"].focus();
}
</SCRIPT>
</HEAD>
<BODY>
<?php

$chemin="";$js="Mssmyle";$closed="close()";
if($_GET['sm']=="ok"){  $my_ms['root']=htmlentities($_GET['chm']); $chemin=$my_ms['root']."/";$js="MY_MS_emoticon";$closed="";}
include("saves/smileys.php");
$total=count($smileys);
$nb_col="4";
$col_cr="4";
$col="1";
$i=0;

$toutImage = '<table align="center"><tr>';
foreach ($smileys as $signe => $image) {
    $TempArray[$image]=$signe;
    $image_smiley='<img border="0" src="'.$chemin.'smiley/'.$smileys[$signe]. '.gif">';
    $toutImage .= '<td width="25%"><A href="javascript:'.$js.'(\''.$signe.'\');'.$closed.';">'.$image_smiley.'</a></td>';

    	if($col==$col_cr){
        $toutImage .= "  </tr>\n";
        $toutImage .= "  <tr>\n";
        $col_cr+=$nb_col;
      }
      $col++;

    }
$toutImage .= '</table>';

echo $toutImage;
?>

</BODY>
</HTML>
