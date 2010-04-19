<?php
session_start();
$_SESSION['tst']="norqst";

if($_GET['cettepage']){
$labas=htmlentities($_GET['cettepage']);
$labas=str_replace("&amp;","&",$labas);
}else{
exit();
}
?>
<html><head><title></title>
<META HTTP-EQUIV="Refresh" CONTENT="1;<?php echo $labas; ?>">
</head><body>

Bonjour,<br />votre navigateur, trop ancien ou exotique, ne supporte pas une des techniques utiliser par ce site,<br />pour y acceder en toute tranquilit&eacute;, veuillez suivre ce lien:<br /><a href="<?php echo $labas; ?>"> Acc&eacute;s au site</a>

</body></html>
