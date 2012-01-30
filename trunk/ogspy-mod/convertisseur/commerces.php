<?php
/**
* convertisseur.php Fichier principal
* @package convertisseur
* @author Mirtador
* @link http://www.ogsteam.fr
* created : 06/11/2006
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
global $db, $table_prefix, $user_data;
define("TABLE_CONVERTISSEUR_COMMERCE", $table_prefix."convertisseur_commerce");


//Gestion des dates
$date = date("j");
$mois = date("m");
$annee = date("Y");
$septjours = $date-7;
$yesterday = $date-1;

if($septjours < 1) $septjours = 1;
if($yesterday < 1) $yesterday = 1;


//Si les dates d'affichage ne sont pas définies, on affiche par défaut les attaques du jour,
if(!isset($pub_date_from)) $pub_date_from = mktime(0, 0, 0, $mois, $date, $annee);
else $pub_date_from = mktime(0, 0, 0, $mois, $pub_date_from, $annee);

if(!isset($pub_date_to)) $pub_date_to = mktime(23, 59, 59, $mois, $date, $annee);
else $pub_date_to = mktime(23, 59, 59, $mois, $pub_date_to, $annee);

$pub_date_from = intval($pub_date_from);
$pub_date_to = intval($pub_date_to);

//Si le choix de l'ordre n'est pas définis on met celui par defaut
if(!isset($pub_order_by)) $pub_order_by ="commerce_date";
else $pub_order_by = mysql_real_escape_string($pub_order_by);

if(!isset($pub_sens)) $pub_sens = "DESC";
elseif($pub_sens == 2) $pub_sens = "DESC";
elseif($pub_sens == 1) $pub_sens = "ASC";


//On récupère la date au bon format
//$pub_date_from = strftime("%d %b %Y", $pub_date_from);
//$pub_date_to = strftime("%d %b %Y", $pub_date_to);

?>
<script type='text/javascript' language='javascript'>
function setDateFrom(fromdate) {
	document.getElementById("date_from").value=fromdate;
}
function setDateTo(todate) {
	document.getElementById("date_to").value=todate;
}
function valid() {
	document.forms.date.submit();
}

</script>

<table width='100%'>
	<colgroup>
		<col width="25%"/>
		<col width="25%"/>
		<col width="25%"/>
		<col width="25%"/>
	</colgroup>
	<thead>
	<tr>
		<th colspan="4" style="font-size:14px; font-weight: bold; color:orange;">Afficher les livraisons</th>
	</tr>
	<tr>
		<th colspan="4">
			<form action='index.php?action=convertisseur&page=commerce' method='post' name='date'>
				<input type='text' name='date_from' id='date_from' size='10' maxlength='10' value='<?php echo strftime("%d %b %Y", $pub_date_from);?>'/> au : <input type='text' name='date_to' id='date_to' size='10' maxlength='10' value='<?php echo strftime("%d %b %Y", $pub_date_to);?>'/>
			</form>
		</th>
	</tr>
	</thead>
	<tr>
		<th align="center"><a href="#haut" onclick="javascript: setDateFrom('<?php echo $date; ?>'); setDateTo('<?php echo $date; ?>'); valid();">D'aujoud'hui</a></td>
		<th align="center"><a href="#haut" onclick="javascript: setDateFrom('<?php echo $yesterday; ?>'); setDateTo('<?php echo $yesterday; ?>'); valid();">D'hier</a></td> 
		<th align="center"><a href="#haut" onclick="javascript: setDateFrom('<?php echo $septjours ; ?>'); setDateTo('<?php echo $date; ?>'); valid();">Des 7 derniers jours</a></td>
		<th align="center"><a href="#haut" onclick="javascript: setDateFrom('01'); setDateTo('<?php echo $date; ?>'); valid();">Du mois</a></td>
	</tr>	
</table>
<br/><br/>
<table width='100%'>
	<thead>
		<tr>
			<th colspan="6" align="center" style="font-size:14px; font-weight: bold; color:orange;">Mes Livraisons du <?php echo strftime("%d %b %Y", $pub_date_from);?> au <?php echo strftime("%d %b %Y", $pub_date_to);?></th>
		</tr>
		<tr>
			<th align="center" style="font-size:12px; font-weight: bold;">Date de livraison</th>
			<th align="center" style="font-size:12px; font-weight: bold;">D&eacute;part livraison</th>
			<th align="center" style="font-size:12px; font-weight: bold;">Arriv&eacute;e livraison</th>
			<th align="center" style="font-size:12px; font-weight: bold;">M&eacute;tal livr&eacute;</th>
			<th align="center" style="font-size:12px; font-weight: bold;">Cristal livr&eacute;</th>
			<th align="center" style="font-size:12px; font-weight: bold;">Deut&eacute;rium livr&eacute;</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<?php
		$query = "SELECT commerce_date, commerce_planet, commerce_planet_coords, commerce_planet_dest, commerce_planet_dest_coords, commerce_metal, commerce_cristal, commerce_deut  FROM " . TABLE_CONVERTISSEUR_COMMERCE . " WHERE commerce_user_id = ".$user_data['user_id']." AND commerce_type = '0' AND commerce_date BETWEEN ".$pub_date_from." and ".$pub_date_to."  ORDER BY ".$pub_order_by." ".$pub_sens."";
    	$result = $db->sql_query($query);
    	while( list($commerce_date, $commerce_planet, $commerce_planet_coords, $commerce_planet_dest, $commerce_planet_dest_coords, $commerce_metal, $commerce_cristal, $commerce_deut) = $db->sql_fetch_row($result) ){
			$commerce_date = strftime("%d %b %Y à %Hh%M", $commerce_date);
			$commerce_metal = number_format($commerce_metal, 0, ',', ' ');
			$commerce_cristal = number_format($commerce_cristal, 0, ',', ' ');
			$commerce_deut = number_format($commerce_deut, 0, ',', ' ');
			echo "<tr>";
					echo "<th align='center'>".$commerce_date."</th>";
					echo "<th align='center'>".$commerce_planet." (".$commerce_planet_coords.")</th>";
					echo "<th align='center'>".$commerce_planet_dest." (".$commerce_planet_dest_coords.")</th>";
					echo "<th align='center'>".$commerce_metal."</th>";
					echo "<th align='center'>".$commerce_cristal."</th>";
					echo "<th align='center'>".$commerce_deut."</th>";
			echo "</tr>";
		}
		?>
	</tr>
	</tbody>
</table>
<br/>

<table width='100%'>
	<thead>
		<tr>
			<th colspan="7" align="center" style="font-size:14px; font-weight: bold; color:orange;">Livraisons Amies du <?php echo strftime("%d %b %Y", $pub_date_from);?> au <?php echo strftime("%d %b %Y", $pub_date_to);?></th>
		</tr>
		<tr>
			<th align="center" style="font-size:12px; font-weight: bold;">Date de livraison</th>
			<th align="center" style="font-size:12px; font-weight: bold;">Lieu de livraison</th>
			<th align="center" style="font-size:12px; font-weight: bold;">Livreur</th>
			<th align="center" style="font-size:12px; font-weight: bold;">Provenance</th>
			<th align="center" style="font-size:12px; font-weight: bold;">M&eacute;tal livr&eacute;</th>
			<th align="center" style="font-size:12px; font-weight: bold;">Cristal livr&eacute;</th>
			<th align="center" style="font-size:12px; font-weight: bold;">Deut&eacute;rium livr&eacute;</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<?php
		$query = "SELECT commerce_date, commerce_planet, commerce_planet_coords, commerce_trader, commerce_trader_planet, commerce_trader_planet_coords, commerce_metal, commerce_cristal, commerce_deut  FROM " . TABLE_CONVERTISSEUR_COMMERCE . " WHERE commerce_user_id = ".$user_data['user_id']." AND commerce_type = '1' AND commerce_date BETWEEN ".$pub_date_from." and ".$pub_date_to."  ORDER BY ".$pub_order_by." ".$pub_sens."";
    	$result = $db->sql_query($query);
    	while( list($commerce_date, $commerce_planet, $commerce_planet_coords, $commerce_trader, $commerce_trader_planet, $commerce_trader_planet_coords, $commerce_metal, $commerce_cristal, $commerce_deut) = $db->sql_fetch_row($result) ){
			$commerce_date = strftime("%d %b %Y à %Hh%M", $commerce_date);
			$commerce_metal = number_format($commerce_metal, 0, ',', ' ');
			$commerce_cristal = number_format($commerce_cristal, 0, ',', ' ');
			$commerce_deut = number_format($commerce_deut, 0, ',', ' ');
			echo "<tr>";
					echo "<th align='center'>".$commerce_date."</th>";
					echo "<th align='center'>".$commerce_planet." (".$commerce_planet_coords.")</th>";
					echo "<th align='center'>".$commerce_trader."</th>";
					echo "<th align='center'>".$commerce_trader_planet." (".$commerce_trader_planet_coords.")</th>";
					echo "<th align='center'>".$commerce_metal."</th>";
					echo "<th align='center'>".$commerce_cristal."</th>";
					echo "<th align='center'>".$commerce_deut."</th>";
			echo "</tr>";
		}
		?>
	</tr>
	</tbody>
</table>
<?php
//pied de page
require_once("pieddepage.php");
?>
