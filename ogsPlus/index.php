<?php 
$err = $_GET["err"]; 
include("langages/lng_fr.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $xml_lang; ?>" >

   <head>

            <title>OGPlus</title>
            <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
            <link rel="stylesheet" media="screen" type="text/css" title="Exemple" href="../css/formate.css" />
            <meta http-equiv="pragma" content="no-cache" />

   </head>

       <div id="form_cnxt">
<center><form action="login/login.php" method="post" dir="ltr">
<select name="type"><option selected value="1"><?php echo $lng_aa_ae; ?></option><option><?php echo $lng_aa_af; ?></option></select> 
<input type="text" size="3" name="uni" onFocus="if (this.value=='<?php echo $lng_aa_aa; ?>') this.value=''" value="<?php echo $lng_aa_aa; ?>" onBlur="if (this.value=='') this.value='<?php echo $lng_aa_aa; ?>'" /> 
<input type="text" size="20" name="nom" onFocus="if (this.value=='<?php echo $lng_aa_ab; ?>') this.value=''" value="<?php echo $lng_aa_ab; ?>" onBlur="if (this.value=='') this.value='<?php echo $lng_aa_ab; ?>'" /> 
<input type="password" size="20" name="pass" onFocus="if (this.value=='******') this.value=''" value="******" onBlur="if (this.value=='') this.value='******'" /> 
<input type="submit" value="LOGIN !" />
</form><br><br>
<?php 
if($err == 1){
echo'<font face="Arial" size="2" color="#FF0000"><b>Une erreur est survenue veuillez vous re-logger!<br>An error occurred...<br></b></font>';
}
?>
</center>
       </div>
       
<META http-EQUIV="Refresh" CONTENT="25; url=http://ogplus.free.fr"> 
       
   </body>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-816698-2";
urchinTracker();
</script>
</html>
