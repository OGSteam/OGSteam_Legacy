<?php    

  require ('../admin/connexion.php'); 
  $quet=mysql_query("SELECT * FROM users WHERE id ='$id'");
  while ($result=mysql_fetch_array($quet))
  { 
    $p1m = $result["p1m"];
    $p2m = $result["p2m"];
    $p3m = $result["p3m"];
    $p4m = $result["p4m"];
    $p5m = $result["p5m"];
    $p6m = $result["p6m"];
    $p7m = $result["p7m"];
    $p8m = $result["p8m"];
    $p9m = $result["p9m"];
    $p1c = $result["p1c"];
    $p2c = $result["p2c"];
    $p3c = $result["p3c"];
    $p4c = $result["p4c"];
    $p5c = $result["p5c"];
    $p6c = $result["p6c"];
    $p7c = $result["p7c"];
    $p8c = $result["p8c"];
    $p9c = $result["p9c"];
    $p1d = $result["p1d"];
    $p2d = $result["p2d"];
    $p3d = $result["p3d"];
    $p4d = $result["p4d"];
    $p5d = $result["p5d"];
    $p6d = $result["p6d"];
    $p7d = $result["p7d"];
    $p8d = $result["p8d"];
    $p9d = $result["p9d"];
 } 
 mysql_close();
 
?>

<form action="index.php?lng=<?php echo $lng ?>&page=majprod.php" method="post">
<div align="center">
  <center>
  <p><font size="2" face="Arial"><?php echo $lng_bh_aa ?><br>
<?php echo $lng_bh_ab ?></font></p>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="514" height="230" id="AutoNumber2" bordercolordark="#FFFFFF" bordercolorlight="#FFFFFF">
    <tr>
      <td width="129" height="51" align="center" bgcolor="#808080"></td>
      <td width="129" height="51" align="center" bgcolor="#808080">
      <b>
      <font size="2" face="Arial">
      <img src="../img/metall.gif" border="0" width="42" height="22"><br>
      <?php echo $lng_bh_ac ?></font></b></td>
      <td width="128" height="51" align="center" bgcolor="#808080">
      <b>
      <font size="2" face="Arial">
      <img src="../img/kristall.gif" border="0" width="42" height="22"><br>
      <?php echo $lng_bh_ad ?></font></b></td>
      <td width="128" height="51" align="center" bgcolor="#808080">
      <b>
      <font size="2" face="Arial">
      <img src="../img/deuterium.gif" border="0" width="42" height="22"><br>
      <?php echo $lng_bh_ae ?></font></b></td>
    </tr>
    <tr>
      <td width="129" height="42" align="center" bgcolor="#C0C0C0">
      <b>
      <font size="2" face="Arial" color="#000000"><?php echo $lng_bh_af ?> 1</font></b></td>
      <td width="129" height="42" align="center" bgcolor="#C0C0C0">
      <p>
        <font face="Arial">
        <b>
        <input type="text" name="p1m" size="15" value="<?php echo $p1m ?>"></b></font></p>
      </td>
      <td width="128" height="42" align="center" bgcolor="#C0C0C0">
      <font face="Arial">
        <b>
        <input type="text" name="p1c" size="15" value="<?php echo $p1c ?>"></b></font></td>
      <td width="128" height="42" align="center" bgcolor="#C0C0C0">
      <font face="Arial">
        <b>
        <input type="text" name="p1d" size="15" value="<?php echo $p1d ?>"></b></font></td>
    </tr>
    <tr>
      <td width="129" height="42" align="center" bgcolor="#808080"><b><font size="2" face="Arial">
      <?php echo $lng_bh_af ?> 2</font></b></td>
      <td width="129" height="42" align="center" bgcolor="#808080">
      <p>
        <font face="Arial">
        <b>
        <input type="text" name="p2m" size="15" value="<?php echo $p2m ?>"></b></font></p>
      </td>
      <td width="128" height="42" align="center" bgcolor="#808080"><font face="Arial">
        <b>
        <input type="text" name="p2c" size="15" value="<?php echo $p2c ?>"></b></font></td>
      <td width="128" height="42" align="center" bgcolor="#808080"><font face="Arial">
        <b>
        <input type="text" name="p2d" size="15" value="<?php echo $p2d ?>"></b></font></td>
    </tr>
    <tr>
      <td width="129" height="42" align="center" bgcolor="#C0C0C0">
      <b>
      <font size="2" face="Arial" color="#000000"><?php echo $lng_bh_af ?> 3</font></b></td>
      <td width="129" height="42" align="center" dir="ltr" bgcolor="#C0C0C0">
      <p dir="ltr">
        <font face="Arial">
        <b>
        <input type="text" name="p3m" size="15" value="<?php echo $p3m ?>"></b></font></p>
      </td>
      <td width="128" height="42" align="center" dir="ltr" bgcolor="#C0C0C0">
      <font face="Arial">
        <b>
        <input type="text" name="p3c" size="15" value="<?php echo $p3c ?>"></b></font></td>
      <td width="128" height="42" align="center" dir="ltr" bgcolor="#C0C0C0">
      <font face="Arial">
        <b>
        <input type="text" name="p3d" size="15" value="<?php echo $p3d ?>"></b></font></td>
    </tr>
    <tr>
      <td width="129" height="42" align="center" bgcolor="#808080"><b><font size="2" face="Arial">
      <?php echo $lng_bh_af ?> 4</font></b></td>
      <td width="129" height="42" align="center" bgcolor="#808080">
      <p>
        <font face="Arial">
        <b>
        <input type="text" name="p4m" size="15" value="<?php echo $p4m ?>"></b></font></p>
      </form>
      </td>
      <td width="128" height="42" align="center" bgcolor="#808080"><font face="Arial">
        <b>
        <input type="text" name="p4c" size="15" value="<?php echo $p4c ?>"></b></font></td>
      <td width="128" height="42" align="center" bgcolor="#808080"><font face="Arial">
        <b>
        <input type="text" name="p4d" size="15" value="<?php echo $p4d ?>"></b></font></td>
    </tr>
    <tr>
      <td width="129" height="42" align="center" bgcolor="#C0C0C0">
      <b>
      <font size="2" face="Arial" color="#000000"><?php echo $lng_bh_af ?> 5</font></b></td>
      <td width="129" height="42" align="center" dir="ltr" bgcolor="#C0C0C0">
      <p dir="ltr">
        <font face="Arial">
        <b>
        <input type="text" name="p5m" size="15" value="<?php echo $p5m ?>"></b></font></p>
      </td>
      <td width="128" height="42" align="center" dir="ltr" bgcolor="#C0C0C0">
      <font face="Arial">
        <b>
        <input type="text" name="p5c" size="15" value="<?php echo $p5c ?>"></b></font></td>
      <td width="128" height="42" align="center" dir="ltr" bgcolor="#C0C0C0">
      <font face="Arial">
        <b>
        <input type="text" name="p5d" size="15" value="<?php echo $p5d ?>"></b></font></td>
    </tr>
    <tr>
      <td width="129" height="42" align="center" bgcolor="#808080"><b><font size="2" face="Arial">
      <?php echo $lng_bh_af ?> 6</font></b></td>
      <td width="129" height="42" align="center" bgcolor="#808080">
      <p>
        <font face="Arial">
        <b>
        <input type="text" name="p6m" size="15" value="<?php echo $p6m ?>"></b></font></p>
      </form>
      </td>
      <td width="128" height="42" align="center" bgcolor="#808080"><font face="Arial">
        <b>
        <input type="text" name="p6c" size="15" value="<?php echo $p6c ?>"></b></font></td>
      <td width="128" height="42" align="center" bgcolor="#808080"><font face="Arial">
        <b>
        <input type="text" name="p6d" size="15" value="<?php echo $p6d ?>"></b></font></td>
    </tr>
    <tr>
      <td width="129" height="43" align="center" bgcolor="#C0C0C0">
      <b>
      <font size="2" face="Arial" color="#000000"><?php echo $lng_bh_af ?> 7</font></b></td>
      <td width="129" height="43" align="center" dir="ltr" bgcolor="#C0C0C0">
      <p dir="ltr">
        <font face="Arial">
        <b>
        <input type="text" name="p7m" size="15" value="<?php echo $p7m ?>"></b></font></p>
      </form>
      </td>
      <td width="128" height="43" align="center" dir="ltr" bgcolor="#C0C0C0">
      <font face="Arial">
        <b>
        <input type="text" name="p7c" size="15" value="<?php echo $p7c ?>"></b></font></td>
      <td width="128" height="43" align="center" dir="ltr" bgcolor="#C0C0C0">
      <font face="Arial">
        <b>
        <input type="text" name="p7d" size="15" value="<?php echo $p7d ?>"></b></font></td>
    </tr>
    <tr>
      <td width="129" height="43" align="center" bgcolor="#808080"><b><font size="2" face="Arial">
      <?php echo $lng_bh_af ?> 8</font></b></td>
      <td width="129" height="43" align="center" bgcolor="#808080">
      <p>
        <font face="Arial">
        <b>
        <input type="text" name="p8m" size="15" value="<?php echo $p8m ?>"></b></font></p>
      </td>
      <td width="128" height="43" align="center" bgcolor="#808080"><font face="Arial">
        <b>
        <input type="text" name="p8c" size="15" value="<?php echo $p8c ?>"></b></font></td>
      <td width="128" height="43" align="center" bgcolor="#808080"><font face="Arial">
        <b>
        <input type="text" name="p8d" size="15" value="<?php echo $p8d ?>"></b></font></td>
    </tr>
    <tr>
      <td width="129" height="43" align="center" dir="ltr" bgcolor="#C0C0C0">
      <b>
      <font size="2" face="Arial" color="#000000"><?php echo $lng_bh_af ?> 9</font></b></td>
      <td width="129" height="43" align="center" dir="ltr" bgcolor="#C0C0C0">
      <p dir="ltr">
        <font face="Arial">
        <b>
        <input type="text" name="p9m" size="15" value="<?php echo $p9m ?>"></b></font></p>
      </td>
      <td width="128" height="43" align="center" dir="ltr" bgcolor="#C0C0C0">
      <font face="Arial">
        <b>
        <input type="text" name="p9c" size="15" value="<?php echo $p9c ?>"></b></font></td>
      <td width="128" height="43" align="center" dir="ltr" bgcolor="#C0C0C0">
      <font face="Arial">
        <b>
        <input type="text" name="p9d" size="15" value="<?php echo $p9d ?>"></b></font></td>
    </tr>
  </table>
  </center>
</div>

<p align="center">

<p align="center"><input type="submit" value="<?php echo $lng_bz_zz ?>" /></p><br>

</form>
