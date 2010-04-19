<?php 

  require ('../admin/connexion.php'); 
  $quet=mysql_query("SELECT * FROM users WHERE id ='$id'");
  while ($result=mysql_fetch_array($quet))
  { 
 $nom=$result["nom"]; 
 $uni=$result["uni"];
 $alli=$result["alli"];
 $tld=$result["tld"];
 $lngbis=$result["lng"];
 } mysql_close();
 
?>
<p align="center">
<a href="index.php?lng=<?php echo $lng; ?>&page=mdp.php"><font color="#FFFF00"><?php echo $lng_bi_af ?></font></a> - <a href="index.php?lng=<?php echo $lng; ?>&page=suppr.php"><font color="#FFFF00"><?php echo $lng_bi_ag ?></font></a>

<form action="index.php?lng=<?php echo $lng; ?>&page=majprofil.php" method="post">

<p align="center"><?php echo $lng_aa_ab ?><br>
<input type="text" value="<?php echo $nom; ?>" disabled="disabled" size="20">

<br><br><?php echo $lng_bi_ab ?><br>
<input type="text" value="<?php echo $uni; ?>" disabled="disabled" size="20">

<br><br><?php echo $lng_bi_ah ?><br>
<input type="text" name="1" value="<?php echo $alli; ?>" size="20">

<br><br>OGame.<br>
<select size="1" name="2">
<option value="<?php echo $tld; ?>"><?php echo $tld; ?></option>
<option value="fr">fr</option>
<option value="de">de</option>
<option value="org">org</option>
<option value="com.es">com.es</option>
<option value="it">it</option>
<option value="pl">pl</option>
<option value="ru">ru</option>
<option value="com.tw">com.tw</option>
<option value="com.tr">com.tr</option>
<option value="ba">ba</option>
<option value="com.hr">com.hr</option>
<option value="nl">nl</option>
<option value="com.pt">com.pt</option>
<option value="dk">dk</option>
<option value="com.br">com.br</option>
<option value="com.cn">com.cn</option>
<option value="cz">cz</option>
<option value="fi">fi</option>
<option value="gr">gr</option>
<option value="sk">sk</option>
<option value="se">se</option>
</select>

<br><br><?php echo $lng_ah_aj ?><br>
<select size="1" name="3">
<option value="<?php echo $lngbis; ?>"><?php echo $lngbis; ?></option>
<option value="fr">Français</option>
<option value="en">English</option>
<option value="de">Deutsche</option>
<option value="es">Español</option>
<option value="it">Italiano</option>
<option value="pl">Jezyk polski</option>
</select>
<br><br><br><input type="submit" value="<?php echo $lng_bz_zz ?>"/>
<br><br>
<font size="1"><?php echo $lng_bi_ae ?><br></p>
</form>
