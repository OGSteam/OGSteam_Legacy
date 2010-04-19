<?php
/***************************************************************************
*	filename	: home.php
*	desc.		: 
*	Author		: Digiduck - http://ogs.servebbs.net/
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
require_once("views/admin_menu.php");
echo "<table align='center' width='80%'>";
//Conversion en heures
$ogs_max_trade_delay_seco = ($ogs_max_trade_delay_hours)*60*60;

if (isset($ogs_subaction))
{
	switch ($ogs_subaction) {
		case "updatecomparam":
			
			$queries=array();
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_max_trade_by_univers."' WHERE name='max_trade_by_univers' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_max_trade_delay_seco."' WHERE name='max_trade_delay_seco' LIMIT 1;" ;

			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_tauxmetal."' WHERE name='tauxmetal' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_tauxcristal."' WHERE name='tauxcristal' LIMIT 1;" ;
			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_tauxdeuterium."' WHERE name='tauxdeuterium' LIMIT 1;" ;

			$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$ogs_view_trade."' WHERE name='view_trade' LIMIT 1;" ;

			foreach($queries as $query)
			{
				$result = $db->sql_query($query);
			}
			init_serverconfig();
			echo "<tr><th>Paramètres Commerciaux Mis à Jour</th></tr>";
			break;
	}
}

//Convertion en heures (suite)
$max_trade_delay = ($server_config["max_trade_delay_seco"])/60/60;

//Conversion des attributs des checkbox
$member_view_trade = ($server_config["view_trade"]) == 1 ? "checked" : "";


?>

<?php
//General
?>

<tr>
	<td>
		<form action="index.php" method="POST">
		<input name="action" type="hidden" value="admin_trade"/>
		<input name="subaction" type="hidden" value="updatecomparam"/>
		<table width="100%">

			<tr>
				<th colspan="2">Configuration Générale</th>
			</tr>
				<tr>
					<td class="c" width="50%">Nombre maximum d'échange:</td>
					<td>
						<input type="text" name="max_trade_by_univers" value="<?php echo $server_config["max_trade_by_univers"]?>"/>
					</td>
				</tr>
				<tr>
					<td class="c">Temps maximum pour une échange (En heures):</td>
					<td>
						<input type="text" name="max_trade_delay_hours" value="<?php echo $max_trade_delay ?>"/>
					</td>
				</tr>
			<tr>
				<td colspan="2" class="c" align="center"><input type="submit"></td>
			</tr>

<?php
//Taux
?>
			<tr>
				<th colspan="2">Taux de Change Officiel</th>
			</tr>

				<tr>
					<td class="c">Métal</td>
					<td>
						<input type="text" name="tauxmetal" value="<?php echo $server_config["tauxmetal"]?>"/>
					</td>
				</tr>

				<tr>
					<td class="c">Cristal</td>
					<td>
						<input type="text" name="tauxcristal" value="<?php echo $server_config["tauxcristal"]?>"/>
					</td>
				</tr>
				
				<tr>
					<td class="c">Deutérium</td>
					<td>
						<input type="text" name="tauxdeuterium" value="<?php echo $server_config["tauxdeuterium"]?>"/>
					</td>
				</tr>
			<tr>
				<td colspan="2" class="c" align="center"><input type="submit"></td>
			</tr>

<?php
//Offres
?>		
			<tr>
				<th colspan="2">Options des Offres</th>
			</tr>

				<tr>
					<td class="c">Visualisation des offres limitée aux membres</td>
					<td>
						<input type="checkbox" name="view_trade" value="1" <?php echo $member_view_trade; ?> />
					</td>
				</tr>
				
			<tr>
				<td colspan="2" class="c" align="center"><input type="submit"></td>
			</tr>
		</table>
		</form>
	</td>
</table>

<?php
//if (!$dont_include_header){
	require_once("views/page_tail.php");
//	}
?>
