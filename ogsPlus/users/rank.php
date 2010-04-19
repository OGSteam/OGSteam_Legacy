<?php    

  require ('../admin/connexion.php'); 
  $quet=mysql_query("SELECT * FROM users WHERE id ='$id'");
  while ($result=mysql_fetch_array($quet))
  { 
 $ppts=$result["ppts"];
 $progpts=$result["progpts"];
 $tpts=$result["tpts"];
 $pvaiss=$result["pvaiss"];
 $progvaiss=$result["progvaiss"];
 $tvaiss=$result["tvaiss"];
 $prech=$result["prech"];
 $progrech=$result["progrech"];
 $trech=$result["trech"];
 } mysql_close();
 
?>

<form action="index.php?lng=<?php echo $lng ?>&page=majrank.php" method="post">
<div align="center">
  <center>
  <p>
&nbsp;</p>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="533" height="30" id="AutoNumber1" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#FFFFFF">
    <tr>
      <td width="132" height="36" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#808080">
      &nbsp;</td>
      <td width="133" height="36" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#808080">
      <font face="Arial" size="2" color="#FFFFFF"><b>
      <?php echo $lng_bn_ab ?></b></font></td>
      <td width="133" height="36" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#808080">
      <font face="Arial" size="2" color="#FFFFFF"><b>
      <?php echo $lng_bn_ac ?></b></font></td>
      <td width="133" height="36" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#808080">
      <font face="Arial" size="2" color="#FFFFFF"><b>
      <?php echo $lng_bn_ad ?></b></font></td>
    </tr>
    <tr>
      <td width="132" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#C0C0C0"><b>
      <font face="Arial" size="2" color="#000000"><?php echo $lng_bn_ae ?></font></b></td>
      <td width="133" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#C0C0C0">
      <font face="Arial" size="1" color="#FFFFFF"><b>
      <input type="text" size="15" name="a" value="<?php echo $ppts; ?>" /></b></font></td>
      <td width="133" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#C0C0C0">
      <font face="Arial" size="1" color="#FFFFFF"><b>
      <input type="text" size="15" name="d" value="<?php echo $pvaiss; ?>" /></b></font></td>
      <td width="133" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#C0C0C0">
      <font face="Arial" size="1" color="#FFFFFF"><b>
      <input type="text" size="15" name="g" value="<?php echo $prech; ?>" /></b></font></td>
    </tr>
    <tr>
      <td width="132" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#808080">
      <b><font size="2" face="Arial" color="#FFFFFF"><?php echo $lng_bn_af ?></font></b></td>
      <td width="133" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#808080">
      
      <select size="1" name="b">
      <option value="<?php echo $progpts; ?>" selected><?php echo $progpts; ?></option>
      <option>  </option>
      <option value="+">+</option>
      <option value="-">-</option>
      <option value="*">*</option>
      </select></td>
      <td width="133" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#808080">
      
      <select size="1" name="e">
      <option value="<?php echo $progvaiss; ?>" selected><?php echo $progvaiss; ?></option>
      <option>  </option>
      <option value="+">+</option>
      <option value="-">-</option>
      <option value="*">*</option>
      </select></td>
      <td width="133" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#808080">
      
      <select size="1" name="h">
      <option value="<?php echo $progrech; ?>" selected><?php echo $progrech; ?></option>
      <option>  </option>
      <option value="+">+</option>
      <option value="-">-</option>
      <option value="*">*</option>
      </select></td>
    </tr>
    <tr>
      <td width="132" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#C0C0C0">
      <b>
      <font face="Arial" size="2" color="#000000"><?php echo $lng_bn_ab ?></font></b></td>
      <td width="133" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#C0C0C0">
      <font face="Arial" size="1" color="#FFFFFF"><b>
      <input type="text" size="15" name="c" value="<?php echo $tpts; ?>" /></b></font></td>
      <td width="133" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#C0C0C0">
      <font face="Arial" size="1" color="#FFFFFF"><b>
      <input type="text" size="15" name="f" value="<?php echo $tvaiss; ?>" /></b></font></td>
      <td width="133" height="37" align="center" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#C0C0C0">
      <font face="Arial" size="1" color="#FFFFFF"><b>
      <input type="text" size="15" name="i" value="<?php echo $trech; ?>" /></b></font></td>
      </tr>
  </table>
  </center>
</div>

<p align="center"><input type="submit" value="<?php echo $lng_bz_zz ?>" /></p><br>
</form>
