<http>
<head>
<title>drrriing!</title>
<link href="../../styles.css" rel="stylesheet" type="text/css" />
</head>
<body class="pop_dring">
<?php
print '
<img src="drelin.gif" /><br />
<span>drrriiiiiiiiiiiiinng!</span><br />';
$mess=$_GET['mess'];
include("../../../saves/smileys.php");   
$smil=$smileys;
foreach ($smileys as $smiley => $image) {
    $image_smiley='<img border="0" src="../../../smiley/'.$smileys[$smiley]. '.gif" alt="myspeach"  title="myspeach" />';
    $mess=str_replace($smiley,$image_smiley,$mess);
    }
print '<span>'.$mess.'</span>';
if($_GET['son']=="son"){
?>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="1" height="1" id="donflash" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="couac.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed src="couac.swf" quality="high" bgcolor="#ffffff" width="1" height="1" name="couac" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
<? } ?>
</body>
</html>
