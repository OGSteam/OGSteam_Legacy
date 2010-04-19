
 
<div style='position:absolute'>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="365" height="400" id="Untitled-1" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="Untitled-1.swf" />
<param name="quality" value="high" />
<param name="wmode" value="" />
<param name="bgcolor" value="#ffffff" />
<embed src="Untitled-1.swf" quality="high" wmode="" bgcolor="#ffffff" width="365" height="400" name="Untitled-1" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div>

<?php $rep = "music/";
$dir = opendir($rep); 
$i=1;
while ($f = readdir($dir)) {

	$tab = explode(".",$f);
	if($tab[1]=="mp3")
	{
          echo "&lenb=".$i."&piste".$i."=".$f;
	   $i++;
         }
	
   }
?>