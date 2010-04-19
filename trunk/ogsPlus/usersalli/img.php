<?php    

  require ('../admin/connexion.php'); 
  $quet=mysql_query("SELECT * FROM alli WHERE id ='$id'");
  while ($result=mysql_fetch_array($quet))
  { 
 $rvb_rank_r_1=$result["rvb_r_1"];
 $rvb_rank_r_2=$result["rvb_r_2"]; 
 $rvb_rank_r_3=$result["rvb_r_3"]; 
 $rvb_rank_r_4=$result["rvb_r_4"];
 $rvb_rank_r_5=$result["rvb_r_5"]; 
 $rvb_rank_v_1=$result["rvb_v_1"]; 
 $rvb_rank_v_2=$result["rvb_v_2"]; 
 $rvb_rank_v_3=$result["rvb_v_3"]; 
 $rvb_rank_v_4=$result["rvb_v_4"];
 $rvb_rank_v_5=$result["rvb_v_5"]; 
 $rvb_rank_b_1=$result["rvb_b_1"]; 
 $rvb_rank_b_2=$result["rvb_b_2"]; 
 $rvb_rank_b_3=$result["rvb_b_3"]; 
 $rvb_rank_b_4=$result["rvb_b_4"];
 $rvb_rank_b_5=$result["rvb_b_5"]; 
 $r_chiff_rank=$result["r_chiff"]; 
 $v_chiff_rank=$result["v_chiff"]; 
 $b_chiff_rank=$result["b_chiff"]; 
 $r_txt_rank=$result["r_txt"];
 $v_txt_rank=$result["v_txt"];
 $b_txt_rank=$result["b_txt"];
 $r_chiff_rank=$result["r_chiff"]; 
 $v_chiff_rank=$result["v_chiff"]; 
 $b_chiff_rank=$result["b_chiff"]; 
 $r_txt_rank=$result["r_txt"];
 $v_txt_rank=$result["v_txt"];
 $b_txt_rank=$result["b_txt"];
 $rank_separ=$result["separ"];
 $rank_bg=$result["bg"];
 } mysql_close();
 
?>
<br>
<h2><?php echo $lng_bk_aa ?></h2>
<form action="index.php?lng=<?php echo $lng ?>&page=majimg.php" method="post" dir="ltr">
<?php
if($rank_bg ==  0){
echo "<p align=\"center\"><input type=\"radio\" value=\"0\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/0.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"0\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/0.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  1){
echo "<p align=\"center\"><input type=\"radio\" value=\"1\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/1.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"1\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/1.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  2){
echo "<p align=\"center\"><input type=\"radio\" value=\"2\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/2.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"2\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/2.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  3){
echo "<p align=\"center\"><input type=\"radio\" value=\"3\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/3.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"3\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/3.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  4){
echo "<p align=\"center\"><input type=\"radio\" value=\"4\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/4.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"4\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/4.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  5){
echo "<p align=\"center\"><input type=\"radio\" value=\"5\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/5.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"5\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/5.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  6){
echo "<p align=\"center\"><input type=\"radio\" value=\"6\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/6.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"6\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/6.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  7){
echo "<p align=\"center\"><input type=\"radio\" value=\"7\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/7.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"7\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/7.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  9){
echo "<p align=\"center\"><input type=\"radio\" value=\"9\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/9.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"9\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/9.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  10){
echo "<p align=\"center\"><input type=\"radio\" value=\"10\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/10.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"10\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/10.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  11){
echo "<p align=\"center\"><input type=\"radio\" value=\"11\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/11.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"11\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/11.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  12){
echo "<p align=\"center\"><input type=\"radio\" value=\"12\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/12.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"12\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/12.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  13){
echo "<p align=\"center\"><input type=\"radio\" value=\"13\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/13.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"13\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/13.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  14){
echo "<p align=\"center\"><input type=\"radio\" value=\"14\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/14.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"14\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/14.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  15){
echo "<p align=\"center\"><input type=\"radio\" value=\"15\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/15.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"15\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/15.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  16){
echo "<p align=\"center\"><input type=\"radio\" value=\"16\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/16.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"16\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/16.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  17){
echo "<p align=\"center\"><input type=\"radio\" value=\"17\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/17.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"17\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/17.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  18){
echo "<p align=\"center\"><input type=\"radio\" value=\"18\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/18.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"18\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/18.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  19){
echo "<p align=\"center\"><input type=\"radio\" value=\"19\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/19.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"19\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/19.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  20){
echo "<p align=\"center\"><input type=\"radio\" value=\"20\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/20.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"20\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/20.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  21){
echo "<p align=\"center\"><input type=\"radio\" value=\"21\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/21.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"21\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/21.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  22){
echo "<p align=\"center\"><input type=\"radio\" value=\"22\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/22.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"22\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/22.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  23){
echo "<p align=\"center\"><input type=\"radio\" value=\"23\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/23.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"23\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/23.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  24){
echo "<p align=\"center\"><input type=\"radio\" value=\"24\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/24.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"24\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/24.png\" width=\"350\" height=\"19\"></p>";
}
?>

<?php
if($rank_bg ==  25){
echo "<p align=\"center\"><input type=\"radio\" value=\"25\" name=\"R1\" checked><img border=\"0\" src=\"../tableaux/userbar/25.png\" width=\"350\" height=\"19\"></p>";
}else{
echo "<p align=\"center\"><input type=\"radio\" value=\"25\" name=\"R1\"><img border=\"0\" src=\"../tableaux/userbar/25.png\" width=\"350\" height=\"19\"></p>";
}
?>

<div align="center">
<table border="3" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#808080" width="424" height="278" id="AutoNumber3">
<tr>
<td width="410" height="250">

<p align="center">

<b><font size="3pts" color="#ffea15"><u><?php echo $lng_bc_aa ?></u></font></b><br><br />
<br />
  
  <?php 
  if($rank_separ == 0){
  
  echo "<input type=\"radio\" value=\"0\" checked name=\"SepaRank\"> $lng_bc_ab<br />";
  
  }else{
  
  echo "<input type=\"radio\" value=\"0\" name=\"SepaRank\"> $lng_bc_ab<br />";
  
  }
  ?>
  
    <?php 
  if($rank_separ == 2){
  
  echo "<input type=\"radio\" value=\"2\" checked name=\"SepaRank\"> $lng_bc_ac<br />";
  
  }else{
  
  echo "<input type=\"radio\" value=\"2\" name=\"SepaRank\"> $lng_bc_ac<br />";
  
  }
  ?>
  
    <?php 
  if($rank_separ == 1){
  
  echo "<input type=\"radio\" value=\"1\" checked name=\"SepaRank\"> $lng_bc_ad<br />";
  
  }else{
  
  echo "<input type=\"radio\" value=\"1\" name=\"SepaRank\"> $lng_bc_ad<br />";
  
  }
  ?>
  
<br /><br />
<b><font size="3pts" color="#ffea15"><u><?php echo $lng_bc_ae ?></u></font></b><br><br />

<?php 

if("$rvb_rank_r_1$rvb_rank_v_1$rvb_rank_b_1$rvb_rank_r_3$rvb_rank_v_3$rvb_rank_b_3$rvb_rank_r_5$rvb_rank_v_5$rvb_rank_b_5$r_txt_rank$v_txt_rank$b_txt_rank$r_chiff_rank$v_chiff_rank$b_chiff_rank" == 240240240240240240240240240000000 AND "$rvb_rank_r_2$rvb_rank_v_2$rvb_rank_b_2$rvb_rank_r_4$rvb_rank_v_4$rvb_rank_b_4" == 255255255255255255){

echo "<input type=\"checkbox\" name=\"DEF\" value=\"CK\" checked=\"checked\"> <font color=\"#C0C0C0\">$lng_bc_af

</font><br>";

}else{

echo "<input type=\"checkbox\" name=\"DEF\" value=\"CK\"> <font color=\"#C0C0C0\">$lng_bc_af

</font><br>";

}
?>

<font size="1pts" color="#ffdb1b"><i><?php echo $lng_bc_ag ?></i></font><br /><br /><br />

<b><?php echo $lng_bc_ah ?></b><br>

&nbsp;<br>
<b><?php echo $lng_bc_ai ?> 1&nbsp;&nbsp;&nbsp;
<input type="text" name="CC1" size="3" value="<?php echo $rvb_rank_r_1; ?>">&nbsp;
<input type="text" name="CC2" size="3" value="<?php echo $rvb_rank_v_1; ?>">&nbsp;
<input type="text" name="CC3" size="3" value="<?php echo $rvb_rank_b_1; ?>"><br>
<?php echo $lng_bc_ai ?> 2&nbsp;&nbsp;&nbsp;
<input type="text" name="CC4" size="3" value="<?php echo $rvb_rank_r_2; ?>">&nbsp;
<input type="text" name="CC5" size="3" value="<?php echo $rvb_rank_v_2; ?>">&nbsp;
<input type="text" name="CC6" size="3" value="<?php echo $rvb_rank_b_2; ?>"><br>
<?php echo $lng_bc_ai ?> 3&nbsp;&nbsp;&nbsp;
<input type="text" name="CC7" size="3" value="<?php echo $rvb_rank_r_3; ?>">&nbsp;
<input type="text" name="CC8" size="3" value="<?php echo $rvb_rank_v_3; ?>">&nbsp;
<input type="text" name="CC9" size="3" value="<?php echo $rvb_rank_b_3; ?>"><br>
<?php echo $lng_bc_ai ?> 4&nbsp;&nbsp;&nbsp;
<input type="text" name="CC10" size="3" value="<?php echo $rvb_rank_r_4; ?>">&nbsp;
<input type="text" name="CC11" size="3" value="<?php echo $rvb_rank_v_4; ?>">&nbsp; 
<input type="text" name="CC12" size="3" value="<?php echo $rvb_rank_b_4; ?>"><br>
<?php echo $lng_bc_ai ?> 5&nbsp;&nbsp;&nbsp;
<input type="text" name="CC13" size="3" value="<?php echo $rvb_rank_r_5; ?>">&nbsp;
<input type="text" name="CC14" size="3" value="<?php echo $rvb_rank_v_5; ?>">&nbsp; 
<input type="text" name="CC15" size="3" value="<?php echo $rvb_rank_b_5; ?>"><br><br />

<b><?php echo $lng_bc_aj ?></b><br>

&nbsp;<br>
<b><?php echo $lng_bc_ak ?> 1&nbsp;&nbsp;&nbsp;
<input type="text" name="CC31" size="3" value="<?php echo $r_txt_rank; ?>">&nbsp;
<input type="text" name="CC32" size="3" value="<?php echo $v_txt_rank; ?>">&nbsp;
<input type="text" name="CC33" size="3" value="<?php echo $b_txt_rank; ?>"><br>
<?php echo $lng_bc_ak ?> 2&nbsp;&nbsp;&nbsp;
<input type="text" name="CC34" size="3" value="<?php echo $r_chiff_rank; ?>">&nbsp;
<input type="text" name="CC35" size="3" value="<?php echo $v_chiff_rank; ?>">&nbsp;
<input type="text" name="CC36" size="3" value="<?php echo $b_chiff_rank; ?>"><br>
<br>
</tr>
</table>
</div>

<p align="center"><input type="submit" value="<?php echo $lng_bz_zz ?>" /></p><br>
</form>
