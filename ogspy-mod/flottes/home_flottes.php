<?php
/***************************************************************************
*	filename	: home_flottes.php
*	desc.		: 1.0.0
*	Author		: 
*	created		: 
*	modified	: 03/07/2011
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if (!defined('IN_MOD_FLOTTES')) {
	die("Hacking attempt");
}

require_once("./mod/flottes/flottes_lang.php");
require_once("./includes/".$phpfonc.".php");
//require_once("parameters/lang_empire.php");

$user_flottes = user_get_empire();
$user_building = $user_flottes["building"];
$user_defence = $user_flottes["defence"];
$user_technology = $user_flottes["technology"];

$affplanet=compte_planet($user_data['user_id'],$nplapage,$gameselect);
//var_dump($affplanet);

if(!isset($pub_view) || $pub_view=="") $view = "0";
else $view = $pub_view;

?>
<table width="100%">
<tr>
<?php
if ($affplanet[1]==0) {
	$nbcol1=$affplanet[2];
	$nbcol2=10;
}
else {
	$nbcol1=($nplapage+1)-($affplanet[2]*$affplanet[1]);
	$nbcol2=$nplapage+1;
}
for ($i=0 ; $i<=$affplanet[1] ; $i++) {
	if ($view == $i) {
		echo "<th colspan='".$nbcol1."'><a>".$lib_page[$i]."</a></th>";
	} 
	else {
		echo "<td class='c' align='center' colspan='".$affplanet[2]."' onClick=\"window.location = 'index.php?action=flottes&view=".$i."&flottes_user_id=".$user_data['user_id']."';\"><a style='cursor:pointer'><font color='lime'>".$lib_page[$i]."</font></a></td>";
	}
}

echo "</tr><tr>";
echo "<td class='c' colspan='". $nbcol2."'>Vue d'ensemble de votre flottes</td>";
echo "</tr><tr>";
echo "<th width='10%'><a>Nom</a></th>";


for ($i=0 ; $i<=$affplanet[1] ; $i++) {
	if ($view == $i) {
		$start = $view=="0" ? 101 : ($view*$nplapage)+1;
	} 
	else {
		$start = $view=="1" ? 201 : ($view*$nplapage)+1;
	}

for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$name = $user_building[$i]["planet_name"];
	echo "\t"."<th width='8%'><label for='".$i."'>".$name."</label></th>"."\n";
}
?>
</tr>
<tr>
	<th><a>Coordonnées</a></th>
<?php
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$il=$i;
	$coordinates = $user_building[$i]["coordinates"];
	if ($coordinates == "" || ($user_building[$i]["planet_name"] == "" && $view=="1")) $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";
//	if ($view=="1") $il=$i+$nplapage;
//		else $il=$i;
	echo "\t"."<th><label for='".$il."'>".$coordinates."</label></th>"."\n";
}
echo "</tr><tr>";
echo "<td class='c' colspan='". $nbcol2."'>Vaisseaux</td>";
echo "</tr>";

/////////////////////////////////////////////////
$requet = "SELECT * FROM ".TABLE_MOD_FLOTTES." WHERE user_id=".$user_data['user_id']; 
$result = mysql_query($requet);
$i=1;

$id = array();
$name = array();
$loc = array();
$pt = array();
$gt = array();
$clo = array();
$cle = array();
$cr = array();
$vb = array();
$vc = array();
$rec = array();
$se = array();
$bmd = array();
$dst = array();
$edlm = array();
$trac = array();
$sat = array();

	while($ligne = mysql_fetch_array($result)) {
		$i=$ligne['planet_id'];

		$id[$i] = $ligne['planet_id'];
 		$name[$i] = $ligne['planet_name']; 
		$loc[$i] = $ligne['coordinates'];
		$pt[$i] = $ligne['PT'];
 		$gt[$i] = $ligne['GT'];
 		$clo[$i] = $ligne['CLO'];
 		$cle[$i] = $ligne['CLE'];
 		$cr[$i] = $ligne['CR'];
 		$vb[$i] = $ligne['VB'];
 		$vc[$i] = $ligne['VC'];
 		$rec[$i] = $ligne['REC'];
 		$se[$i] = $ligne['SE'];
 		$bmd[$i] = $ligne['BMD'];
 		$dst[$i] = $ligne['DST'];
 		$edlm[$i] = $ligne['EDLM'];
 		$trac[$i] = $ligne['TRA'];
 		$sat[$i] = $ligne['SAT'];
	}

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["PT"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $pt[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["GT"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $gt[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["CLE"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $cle[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["CLO"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $clo[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["CR"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $cr[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["VB"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $vb[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["VC"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $vc[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["REC"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $rec[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["SE"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $se[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["BMD"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $bmd[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["DST"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $dst[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["EDLM"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $edlm[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["TRA"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $trac[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";

echo "<tr>";
echo	"<th><a>".$lib_flottes_lang["SAT"]."</a></th>";
for ($i=$start ; $i<=$start+$nplapage-1 ; $i++) {
	$rr = $sat[$i];
	if ($rr == "") $rr = "&nbsp;";

	echo "\t"."<th><font color='lime' id='6".($i)."'>".$rr."</font></th>"."\n";
}
echo "</tr>";
// fin de si view="planets"

}
echo "</table>";
?>