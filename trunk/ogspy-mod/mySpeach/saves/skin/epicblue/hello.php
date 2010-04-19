<?php
include("../../../admin/config.php");
include("../../../saves/smileys.php");
$chemin=$my_ms["repertoire"].'/'.$my_ms["skin"].'/';
?>
<http>
<head>
<title>drrriing!</title>
<link href="../../styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
$mess=$_GET['mess'];
$smil=$smileys;
foreach ($smileys as $smiley => $image) {
    $image_smiley='<img border="0" src="'.$my_ms["repertoire"].'/smiley/'.$smileys[$smiley]. '.gif" alt="'.$smileys[$smiley]. '.gif"  title="myspeach" />';
    $mess=str_replace($smiley,$image_smiley,$mess);
    }
print '
<img src="'.$chemin.'drelin.gif" /><img src="'.$chemin.'drelin.gif" /><img src="'.$chemin.'drelin.gif" /><img src="'.$chemin.'drelin.gif" /><img src="'.$chemin.'drelin.gif" /><br />
<p class="pop_dring"><big>
drrriiiiiiiiiiiiinng!<br />';
print $mess.'</big></p>';
if($_GET['son']=="son"){
?>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="1" height="1" id="donflash" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="<? print $chemin ?>couac.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed src="<? print $chemin ?>couac.swf" quality="high" bgcolor="#ffffff" width="1" height="1" name="couac" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
<? } ?>
</body>
</html>
