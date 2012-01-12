<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas daccès direct

require_once(FOLDEREXP."includes/subHeaderDateChooser.php"); //on inclut le subheader pour la date...

$superTableau = readDBuserDet($typeUser, $datedebut, $datefin);

$imgExportBBCode = '<img src="'.$imageFolder.'/bbcode.png"  title="Export BBCode">';
$cellpadding = 0;
$cellspacing = 2;

//définition de la page
$pageDet = <<<HEREDET
<span style="font-weight: bold;"><big><big>$titrePeriode</big></big></span>
<br />
<br />
<table style="text-align: left; " border="0" cellpadding="$cellpadding" cellspacing="$cellspacing">
	<tbody>
		<tr>
HEREDET;

$pageDet .= <<<HEREDET
			<td colspan=3><span align=center style="font-weight: bold;"><big>eXpeditions ratées :</big></span></td>
			</tr>
HEREDET;

if ($typeUser == 0)
{
$pageDet .= <<<HEREDET
			<td class="c" style="width: 75px; font-weight: bold;">Pseudo</td>
HEREDET;
}

$pageDet .= <<<HEREDET
			<td class="c" style="width: 200px; font-weight: bold;">Date</td>
			<td class="c" style="width: 75px; font-weight: bold;">Position</td>
		</tr>
HEREDET;

if(count($superTableau['Rate'])!=0 && $superTableau['Rate']!='')
{
	foreach($superTableau['Rate'] as $res) {
	if ($res[4] == 0) {
		$date = date('d-m-Y - H:i:s', $res[0]);
		$pos = "[".$res[1].":".$res[2].":16]";
		$pageDet .= "<tr>";
		if($typeUser == 0) 
		{
			$uname = getUserNameById($res[3]);
			$pageDet .= <<<USER
				<th style="width: 75px; font-weight: bold;">$uname</td>
USER;
		}
		$pageDet .= <<<ITERATION
				<th align=center style="width: 200px;">$date</th>
				<th align=center style="width: 75px;">$pos</th>
			</tr>
ITERATION;
	}}
	
$pageDet .= <<<HEREDET
			<td colspan=3><span align=center style="font-weight: bold;"><big>eXpeditions combat Pirates :</big></span></td>
			</tr>
HEREDET;
if ($typeUser == 0)
{
$pageDet .= <<<HEREDET
			<td class="c" style="width: 75px; font-weight: bold;">Pseudo</td>
HEREDET;
}
$pageDet .= <<<HEREDET
			<td class="c" style="width: 200px; font-weight: bold;">Date</td>
			<td class="c" style="width: 75px; font-weight: bold;">Position</td>
			<td class="c" style="width: 75px; font-weight: bold;">Perte</td>
		</tr>
HEREDET;

	foreach($superTableau['Rate'] as $res) {
	if ($res[4] == 4) {
		$date = date('d-m-Y - H:i:s', $res[0]);
		$pos = "[".$res[1].":".$res[2].":16]";
		$perte = $res[5];
		$pageDet .= "<tr>";
		if($typeUser == 0) 
		{
			$uname = getUserNameById($res[3]);
			$pageDet .= <<<USER
				<th style="width: 75px; font-weight: bold;">$uname</td>
USER;
		}
		$pageDet .= <<<ITERATION
				<th align=center style="width: 200px;">$date</th>
				<th align=center style="width: 75px;">$pos</th>
				<th align=center style="width: 75px;">$perte</th>
			</tr>
ITERATION;
	}}
$pageDet .= <<<HEREDET
			<td colspan=3><span align=center style="font-weight: bold;"><big>eXpeditions combat Aliens :</big></span></td>
			</tr>
HEREDET;
if ($typeUser == 0)
{
$pageDet .= <<<HEREDET
			<td class="c" style="width: 75px; font-weight: bold;">Pseudo</td>
HEREDET;
}
$pageDet .= <<<HEREDET
			<td class="c" style="width: 200px; font-weight: bold;">Date</td>
			<td class="c" style="width: 75px; font-weight: bold;">Position</td>
			<td class="c" style="width: 75px; font-weight: bold;">Perte</td>
		</tr>
HEREDET;
	foreach($superTableau['Rate'] as $res) {
	if ($res[4] == 5) {
		$date = date('d-m-Y - H:i:s', $res[0]);
		$pos = "[".$res[1].":".$res[2].":16]";
		$perte = $res[5];
		$pageDet .= "<tr>";
		if($typeUser == 0) 
		{
			$uname = getUserNameById($res[3]);
			$pageDet .= <<<USER
				<th style="width: 75px; font-weight: bold;">$uname</td>
USER;
		}
		$pageDet .= <<<ITERATION
				<th align=center style="width: 200px;">$date</th>
				<th align=center style="width: 75px;">$pos</th>
				<th align=center style="width: 75px;">$perte</th>
			</tr>
ITERATION;
	}}	
}

$pageDet .= <<<HEREDET
	</tbody>
</table>
<br />
<br />
<br />
<span style="font-weight: bold;">
	<big>eXpeditions ayant ramené des ressources :</big>
</span>
<br />
<br />
<br />
<table style="text-align: left; " border="0" cellpadding="$cellpadding" cellspacing="$cellspacing">
	<tbody>
		<tr>
HEREDET;
if($typeUser == 0)
{
$pageDet .= <<<HEREDET
			<td class="c" style="width: 75px; font-weight: bold;">Pseudo</td>
			<td style="width: 20px; font-weight: bold;"></td>
HEREDET;
}

$pageDet .= <<<HEREDET
			<td class="c" style="width: 200px; font-weight: bold;">Date</td>
			<td class="c" style="width: 75px; font-weight: bold;">Position</td>
			<td style="width: 20px;"></td>
			<td class="c" style="width: 100px; font-weight: bold;">Métal</td>
			<td class="c" style="width: 100px; font-weight: bold;">Cristal</td>
			<td class="c" style="width: 100px; font-weight: bold;">Deutérium</td>
			<td class="c" style="width: 100px; font-weight: bold;">Antimatière</td>
HEREDET;
		if($typeUser != 0) $pageDet .= '<td style="width: 60px;"></td>';

	$pageDet .=	"</tr>";
if(count($superTableau['Ress'])!=0 && $superTableau['Ress']!='')
{
	foreach($superTableau['Ress'] as $res)
	{
		$date = date('d-m-Y - H:i:s', $res[0]);
		$pos = "[".$res[1].":".$res[2].":16]";
		$met = format($res[3]);
		$cri = format($res[4]);
		$deut = format($res[5]);
		$antimat = format($res[6]);
		$pageDet .= "<tr>";
		if($typeUser == 0) 
		{
			$uname = getUserNameById($res[7]);
			$pageDet .= <<<USER
				<th style="width: 75px; font-weight: bold;">$uname</td>
				<td style="width: 20px; font-weight: bold;"></td>
USER;
		}
		$id = $res[8];
		$pageDet .= <<<ITERATION
				<th align=center style="width: 200px;">$date</th>
				<th align=center style="width: 75px;">$pos</th>
				<td style="width: 20px;"></td>
				<th align=center style="width: 100px;">$met</th>
				<th align=center style="width: 100px;">$cri</th>
				<th align=center style="width: 100px;">$deut</th>
				<th align=center style="width: 100px;">$antimat</th>
ITERATION;
		if($typeUser != 0) $pageDet .= '<th align=center style="width: 60px;"><a href="index.php?action=eXpedition&module=bbcode&idexp='.$id.'">'.$imgExportBBCode.'</a></th>';

	$pageDet .=	"</tr>";
	}
}


$pageDet .= <<<HEREDET
	</tbody>
</table>
<br />
<br />
<br />
<span style="font-weight: bold;">
	<big>eXpeditions ayant ramené des vaisseaux :</big>
</span>
<br />
<br />
<br />
<table style="text-align: left; " border="0" cellpadding="$cellpadding" cellspacing="$cellspacing">
	<tbody>
		<tr>
HEREDET;
if($typeUser == 0)
{
$pageDet .= <<<HEREDET
			<td class="c" style="width: 75px; font-weight: bold;">Pseudo</td>
			<td style="width: 20px; font-weight: bold;"></td>
HEREDET;
}

$pageDet .= <<<HEREDET
			<td class="c" style="width: 200px; font-weight: bold;">Date</td>
			<td class="c" style="width: 75px; font-weight: bold;">Position</td>
			<td style="width: 20px;"></td>
			<td class="c" style="width: 30px; font-weight: bold;">PT </td>
			<td class="c" style="width: 30px; font-weight: bold;">GT </td>
			<td class="c" style="width: 30px; font-weight: bold;">CLE</td>
			<td class="c" style="width: 30px; font-weight: bold;">CLO</td>
			<td class="c" style="width: 30px; font-weight: bold;">CR </td>
			<td class="c" style="width: 30px; font-weight: bold;">VB </td>
			<td class="c" style="width: 30px; font-weight: bold;">VC </td>
			<td class="c" style="width: 30px; font-weight: bold;">REC</td>
			<td class="c" style="width: 30px; font-weight: bold;">SE </td>
			<td class="c" style="width: 30px; font-weight: bold;">BMB</td>
			<td class="c" style="width: 30px; font-weight: bold;">DST</td>
			<td class="c" style="width: 30px; font-weight: bold;">TRA</td>
			<td class="c" style="width: 30px; font-weight: bold;">Unités</td>
HEREDET;
		if($typeUser != 0) $pageDet .= '<td style="width: 60px;"></td>';

	$pageDet .=	"</tr>";

if(count($superTableau['Vaiss'])!=0 && $superTableau['Vaiss']!='')
{
	foreach($superTableau['Vaiss'] as $res)
	{
		$date = date('d-m-Y - H:i:s', $res[0]);
		$pos = "[".$res[1].":".$res[2].":16]";
		$pt  = format($res[3]);
		$gt  = format($res[4]);
		$cle = format($res[5]);
		$clo = format($res[6]);
		$cr  = format($res[7]);
		$vb  = format($res[8]);
		$vc  = format($res[9]);
		$rec = format($res[10]);
		$se  = format($res[11]);
		$bmb = format($res[12]);
		$dst = format($res[13]);
		$tra = format($res[14]);
		$units = format($res[15]);
		$pageDet .= "<tr>";
		if($typeUser == 0) 
		{
			$uname = getUserNameById($res[16]);
			$pageDet .= <<<USER
				<th style="width: 75px; font-weight: bold;">$uname</td>
				<td style="width: 20px; font-weight: bold;"></td>
USER;
		}
		$id = $res[17];
		$pageDet .= <<<ITERATION
				<th align=center style="width: 200px;">$date</th>
				<th align=center style="width: 75px;">$pos</th>
				<td style="width: 20px;"></td>
				<th align=center style="width: 30px;">$pt</th>
				<th align=center style="width: 30px;">$gt</th>
				<th align=center style="width: 30px;">$cle</th>
				<th align=center style="width: 30px;">$clo</th>
				<th align=center style="width: 30px;">$cr</th>
				<th align=center style="width: 30px;">$vb</th>
				<th align=center style="width: 30px;">$vc</th>
				<th align=center style="width: 30px;">$rec</th>
				<th align=center style="width: 30px;">$se</th>
				<th align=center style="width: 30px;">$bmb</th>
				<th align=center style="width: 30px;">$dst</th>
				<th align=center style="width: 30px;">$tra</th>
				<td class="c" style="width: 30px; font-weight: bold;">$units</td>
ITERATION;
		if($typeUser != 0) $pageDet .= '<th align=center style="width: 60px;"><a href="index.php?action=eXpedition&module=bbcode&idexp='.$id.'">'.$imgExportBBCode.'</a></th>';

	$pageDet .=	"</tr>";
	}
}
$pageDet .= <<<HEREDET
	</tbody>
</table>
<br />
<br />
<br />
<span style="font-weight: bold;">
	<big>eXpeditions ayant ramené des marchands :</big>
</span>
<br />
<br />
<br />
<table style="text-align: left; " border="0" cellpadding="$cellpadding" cellspacing="$cellspacing">
	<tbody>
		<tr>
HEREDET;
if($typeUser == 0)
{
$pageDet .= <<<HEREDET
			<td class="c" style="width: 75px; font-weight: bold;">Pseudo</td>
			<td style="width: 20px; font-weight: bold;"></td>
HEREDET;
}

$pageDet .= <<<HEREDET
			<td class="c" style="width: 200px; font-weight: bold;">Date</td>
			<td class="c" style="width: 75px; font-weight: bold;">Position</td>
		</tr>
HEREDET;
if(count($superTableau['March'])!=0 && $superTableau['March'] != '')
{
	foreach($superTableau['March'] as $res)
	{
		$date = date('d-m-Y - H:i:s', $res[0]);
		$pos = "[".$res[1].":".$res[2].":16]";
		$pageDet .= "<tr>";
		if($typeUser == 0) 
		{
			$uname = getUserNameById($res[3]);
			$pageDet .= <<<USER
				<th style="width: 75px; font-weight: bold;">$uname</td>
				<td style="width: 20px; font-weight: bold;"></td>
USER;
		}
		$pageDet .= <<<ITERATION
				<th align=center style="width: 200px;">$date</th>
				<th align=center style="width: 75px;">$pos</th>
			</tr>
ITERATION;
	}
}

$pageDet .= <<<HEREDETFIN
	</tbody>
</table>

<!-- FIN Insertion mod eXpedition : Detail -->
HEREDETFIN;



//affichage de la page
echo($pageDet);

?>
