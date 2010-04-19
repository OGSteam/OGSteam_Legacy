<?php
/***********************************************************************
 * filename	:	Convertisseur.php
 * desc.	:	Fichier principal
 * created	: 	06/11/2006 Mirtador
 *
 * *********************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");
echo "<table width='100%'>";
//Débug
error_reporting(E_ALL);
//fonction
/**
 * fait les infobulle
 *merci a oXid_FoX pour la fonction
 */
function infobulle($txt_contenu, $titre = 'Aide', $largeur = '200') {
	// remplace ' par \'
	// puis remplace \\' par \'
	// au cas où le guillemet simple aurait déjà été protégé avant l'appel à la fonction
	$txt_contenu = str_replace('\\\\\'','\\\'',str_replace('\'','\\\'',$txt_contenu));
	// remplace le guillemet double par son code HTML
	$txt_contenu = str_replace('"','&quot;',$txt_contenu);

	// pareil avec $titre
	$titre = str_replace('\\\\\'','\\\'',str_replace('\'','\\\'',$titre));
	$titre = str_replace('"','&quot;',$titre);

	// tant qu'on y est, vérification de $largeur
	if (!is_numeric($largeur))
	  $largeur = 200;

	// affiche l'infobulle
	echo '<img style="cursor: pointer;" src="images/help_2.png" onMouseOver="this.T_WIDTH=210;this.T_TEMP=0;return escape(\'<table width=&quot;',$largeur
	,'&quot;><tr><td align=&quot;center&quot; class=&quot;c&quot;>',$titre,'</td></tr><tr><th align=&quot;center&quot;>',$txt_contenu,'</th></tr></table>\')">';
}
// Définition du ouvert
if(isset($_POST['ouvert'])){
$ouvert=$_POST['ouvert'];
}
else{
$ouvert="0";
}
if ($ouvert=="1"){
	//définition des variables
	$metal=$_POST['metal'];
	$cristal=$_POST['cristal'];
	$deuterium=$_POST['deuterium'];
	$tauxm=$_POST['tauxm'];
	$tauxc=$_POST['tauxc'];
	$tauxd=$_POST['tauxd'];
	$combienm=$_POST['combienm'];
	$combienc=$_POST['combienc'];
	$combiend=$_POST['combiend'];
	$transporteur=$_POST['transporteur'];
	//message d'erreures
	$total_pourc=($combienm)+($combienc)+($combiend);
	if ($total_pourc!="100") {
		echo "Le total des pourcentages doivent donner 100%";
		$error="1";
	}
	elseif ($metal=="0"  &&  $cristal=="0"  &&  $deuterium=="0"){
		echo "Vous devez mettre au moins une ressource que vous souhaitez échanger";
		$error="1";
	}
	else{
		//On fait les totaux des taux
		if($tauxm!="0" && $tauxc!="0" && $tauxd!="0")
		$Valleur=($metal)/($tauxm)+($cristal)/($tauxc)+($deuterium)/($tauxd);
		else $Valleur=0;
		//on calcule
		if ($tauxm!="0"  &&  $tauxm!=""  &&  $combienm!="0"  &&  $combienm!=""){
			$pourcM=($combienm)/100;
			$TotalM=($Valleur)*($pourcM)*($tauxm);
		}
		if ($tauxc!="0"  &&  $tauxc!=""  &&  $combienc!="0"  &&  $combienc!=""){
			$pourcC=($combienc)/100;
			$TotalC=($Valleur)*($pourcC)*($tauxc);
		}
		if ($tauxd!="0"  &&  $combiend!="0"  &&  $tauxd!=""  &&  $combiend!=""){
			$pourcD=($combiend)/100;
			$TotalD=($Valleur)*($pourcD)*($tauxd);
		}
	}
}
?>


		<form action="index.php" method="post">
		<input type="hidden" name="action" value="Convertisseur">
		<input type="hidden" name="ouvert" value="1"/> 

			<th colspan="4">Convertisseur de ressources</th>
	<tr>
		<td align="center">
		<table>
			<tr>
			<th colspan="4">Options</th>
			</tr>
				
				<tr>	<td class="c">Calcule des transporteurs <?php infobulle('Ici vous pouvez décider si oui ou non il vous met le calcule du nombre de transporteur requis et Quel type de transporteur vous allez utiliser ')?></td>	<th>
				<?php if (!isset($transporteur)){$transporteur="aucun";}?>
				<input type="radio" name="transporteur" value="aucun" <?php if ($transporteur=='aucun') { ?> checked="checked"<?php } ?> /> Aucun</th>
				<th><input type="radio" name="transporteur" value="pt" <?php if ($transporteur=='pt') { ?> checked="checked"<?php } ?> /> PT</th>
				<th><input type="radio" name="transporteur" value="gt" <?php if ($transporteur=='gt') { ?>checked="checked"<?php } ?> /> GT</th>
				</td>	</tr> 
				
			</tr>
		</table>
	</td>
	<td align="center">
		<table>
			<th> ressources</th>
			<th> Quantités (U) <?php infobulle('Mettez ici, la quantité de ressource que vous souhaitez échanger'); ?></th>
			<tr>
				<td class="c">Métal:</td>
					<td>
						<input type="text" name="metal" value="<?php if (isset($metal)) {echo "$metal";} else {echo '0';}?>"/>
					</td>
			</tr>
			<tr>
				<td class="c">Cristal:</td>
					<td>
						<input type="text" name="cristal" value="<?php if (isset($cristal)) {echo "$cristal";} else {echo '0';}?>"/>
					</td>
			</tr>
			<tr>
				<td class="c">Deutérium: </td>
					<td>
						<input type="text" name="deuterium" value="<?php if (isset($deuterium)) {echo "$deuterium";} else {echo '0';}?>"/>
					</td>
			</tr>
	</table>
	</td>
	<td>
		<table>
			<tr>
			<th colspan="2">Taux<?php infobulle('Ici vous décidez a quel taux vous voulez le vendre, exemple, le taux bien connu, 1D=2C=3M')?></th>
			</tr>
					<tr>	<td class="c">Métal	</td>	<td>
					<input type="text" name="tauxm" value="<?php if (isset($tauxm)) {echo "$tauxm";} else {echo $server_config["tauxmetal"];}?>"/> 	</td>	</tr>
					<tr>	<td class="c">Cristal	</td>	<td>
					<input type="text" name="tauxc" value="<?php if (isset($tauxc)) {echo "$tauxc";} else {echo $server_config["tauxcristal"];}?>"/>		</td>	</tr>
					<tr>	<td class="c">Deutérium	</td>	<td>
					<input type="text" name="tauxd" value="<?php if (isset($tauxd)) {echo "$tauxd";} else {echo $server_config["tauxdeuterium"];}?>"/>		</td>	</tr>

			</tr>
		</table>
	</td>
	<td align="center">
			<table>
			<tr>
			<th colspan="2">pourcentage (%) <?php infobulle('Choisissez ici quel est le mélange de chaque ressources que vous désirez avoir. Exemple: pour un mélange métal/cristal on met 50% à cristal et 50% à métal. Attention ne metez pas le % ou le calcule ne marchera pas. Attention! Il faut aussi que la somme de vos pourcentage donne 100%')?></th>
			</tr>
				<td>
					<tr>	<td class="c">Métal</td>	<td>
					<input type="text" name="combienm" value="<?php if (isset($combienm)) {echo "$combienm";} else {echo '0';}?>"/></td>	</tr> 
					<tr>	<td class="c">Cristal</td>	<td>
					<input type="text" name="combienc" value="<?php if (isset($combienc)) {echo "$combienc";} else {echo '0';}?>"/></td>	</tr> 
					<tr>	<td class="c">Deutérium</td>	<td>
					<input type="text" name="combiend" value="<?php if (isset($combiend)) {echo "$combiend";} else {echo '0';}?>"/></td>	</tr>
				</td>
			</tr>
		</table>
	</td>
</td>
<td>
</td>
	</tr>
	<tr>

	<th colspan="4">
		<table>
		<input type="submit">
		</table>
	</th>
	</tr>
</table>
	<?php 
//tableaux des résultats 
//on doit tout d'abord s'assurer que le formulaire est ouvert
if ($ouvert=="1" and !isset($error)){
	//Avant de poster les variables ils vous faut définir les variable non défini
	if (!isset($metal)) {$metal="0";}
	if (!isset($cristal)) {$cristal="0";}
	if (!isset($deuterium)) {$deuterium="0";}
	if (!isset($TotalM)){$TotalM = 0;}
	if (!isset($TotalC)){$TotalC = 0;}
	if (!isset($TotalD)){$TotalD = 0;}
	?> 
	<table>
	<td>
	<table>
		<th colspan="3">Échange</th><tr>
		<th></th>
		<th>votre offre</th>
		<th>votre demande </th>
			<?php //Métal?>
		<tr>
			<th>Métal</th>
			<th><?php echo round($metal);?></th>
			<th><?php echo round($TotalM);?></th>
		</tr>
			<?php //Cristal?>
		<tr>
			<th>Cristal</th>
			<th><?php echo round($cristal);?></th>
			<th><?php echo round($TotalC);?></th>
		</tr>
			<?php //deutérium?>
		<tr>
			<th>Deutérium</th>
			<th><?php echo round($deuterium);?></th>
			<th><?php echo round($TotalD);?></th>
		</tr>
	<?php if ($transporteur!="aucun") {
		$totalaressevoir=(($TotalM)+($TotalC)+($TotalD));
		$totalaenvoyer=($metal)+($cristal)+($deuterium);
		if ($transporteur=="pt"){
			$transporteurenvoyer=$totalaenvoyer/5000;
			$transporteurressus=$totalaressevoir/5000;
			}
		elseif ($transporteur=="gt")
		{
			$transporteurenvoyer=$totalaressevoir/25000;
			$transporteurressus=$totalaenvoyer/25000;
		}
	?>
		<th>Nombre de transporteurs (<?php echo"$transporteur"?>)</th>
		<th><?php echo ceil($transporteurenvoyer);?></th>
		<th><?php echo ceil($transporteurressus);?></th><tr>
			</tr>
		
	<?php
	}
	?>
	</table>
	</td>
	<td>
<?php
// BBCode
require_once("convertisseur_BBcode.php");
?>
<table height="100%">
<td class="c">Offre en BBcode pour les forums</td>
<tr>
<th>
<form method='post'><textarea id="bbcode" rows="4" cols="45">
<?php echo $BBcode ?>
</textarea></form>
</th>
</tr>
</table>
</td>
</table>

<?php
}
?>