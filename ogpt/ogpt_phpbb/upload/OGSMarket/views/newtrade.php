<?php
/***********************************************************************
 * filename	:	newtrade.php
 * desc.	:	Fichier principal
 * based 	: 	Convertisseur.php by Mirtador
 * created  :   Digiduck pour OGSMarket
 * *********************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");
require_once("includes/ogamecalc.php");

//Débug
error_reporting(E_ALL);

//fonctions
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
	$base=$_POST['base'];

	if ($base == "p") {
// Calcul par poucentage
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

	if ($base == "q") {
//ou quantitŽ
		//message d'erreur
		if ($metal=="0"  &&  $cristal=="0"  &&  $deuterium=="0"){
			echo "Vous devez mettre au moins une ressource que vous souhaitez échanger";
			$error="1";
		}
		else{
		//On transpose les valeurs
			$TotalM=$combienm;
			$TotalC=$combienc;
			$TotalD=$combiend;
		}
	}
}
?>
<script language="javascript">
function livrable() {
    for (var i=1; i<=9; i++) {
        var checkbox = "livrable["+i+"]";
        if (document.getElementById(checkbox).checked == true) {
            document.getElementById(checkbox).checked = false
        }
        else document.getElementById(checkbox).checked = true
    }
}
</script>

<table width="100%">
<th>Création d'une Offre</th>
</table>

<table width="100%">
<tr>
<td width="20%"></td>
<td colspan="3">
			<center>
			Attention les offres sont en K c'est à dire en milliers de ressources ( 10k Metal = 10.000 Métal)<br>
			N'oubliez pas de mettre à jour votre profil afin d'y laisser les informations pour vous contacter.<br>
			Vous devez remplir ce que vous proposez et ce que vous voulez sous forme de % de la ou des ressources désirées.
			</center>
</td>
<td width="20%"></td>
</tr>
</table>

<table width="100%">
		<form action="index.php" method="post">
		<input type="hidden" name="action" value="newtrade">
		<input type="hidden" name="ouvert" value="1"/> 

<tr>
<td width="20%"></td>
<td align="center"><table>
		<tr>	<th colspan="2"> Quantités (K) <?php infobulle('Mettez ici, la quantité de ressource que vous souhaitez échanger'); ?></th>	</tr>
		<tr>	<td class="c">Métal:</td>	<td class="l">	<input type="text" name="metal" value="<?php if (isset($metal)) {echo "$metal";} else {echo '0';}?>"/>	</td>	</tr>
		<tr>	<td class="c">Cristal:</td>	<td class="l">	<input type="text" name="cristal" value="<?php if (isset($cristal)) {echo "$cristal";} else {echo '0';}?>"/>	</td>	</tr>
		<tr>	<td class="c">Deutérium: </td>	<td class="l">	<input type="text" name="deuterium" value="<?php if (isset($deuterium)) {echo "$deuterium";} else {echo '0';}?>"/>	</td>	</tr>
</table></td>
<td align="center"><table>
		<tr>	<th colspan="2">Taux (modifiable)<?php infobulle('Ici vous décidez a quel taux vous voulez le vendre, exemple, le taux bien connu, 1D=2C=3M')?></th>	</tr>
		<tr>	<td class="c">Métal	</td>	<td class="l">	<input type="text" name="tauxm" value="<?php if (isset($tauxm)) {echo "$tauxm";} else {echo $server_config["tauxmetal"];}?>"/> </td> </tr>
		<tr>	<td class="c">Cristal	</td>	<td class="l">	<input type="text" name="tauxc" value="<?php if (isset($tauxc)) {echo "$tauxc";} else {echo $server_config["tauxcristal"];}?>"/>	</td>	</tr>
		<tr>	<td class="c">Deutérium	</td>	<td class="l">	<input type="text" name="tauxd" value="<?php if (isset($tauxd)) {echo "$tauxd";} else {echo $server_config["tauxdeuterium"];}?>"/>	</td>	</tr>
</table></td>
<td align="center"><table>
		<tr>	<th colspan="2">Demandes en : <input type="radio" name="base" value="p" <?php if (isset($base) AND $base == "p") {echo "checked=\"checked\" ";} else if (isset($base) AND $base == "q") {echo" ";} else echo "checked=\"checked\" "; ?> /> % <input type="radio" name="base" value="q" <?php if (isset($base) AND $base == "q") {echo "checked=\"checked\" ";} else echo " "; ?> /> Q<?php infobulle('Choisissez ici quel est le mélange de chaque ressources que vous désirez avoir. Exemple: pour un mélange métal/cristal on met 50% à cristal et 50% à métal. Attention ne metez pas le % ou le calcule ne marchera pas. Attention! Il faut aussi que la somme de vos pourcentage donne 100%')?></th>	</tr>
		<tr>	<td class="c">Métal</td>	<td class="l">	<input type="text" name="combienm" value="<?php if (isset($combienm)) {echo "$combienm";} else {echo '0';}?>"/></td>	</tr> 
		<tr>	<td class="c">Cristal</td>	<td class="l">	<input type="text" name="combienc" value="<?php if (isset($combienc)) {echo "$combienc";} else {echo '0';}?>"/></td>	</tr> 
		<tr>	<td class="c">Deutérium</td>	<td class="l">	<input type="text" name="combiend" value="<?php if (isset($combiend)) {echo "$combiend";} else {echo '0';}?>"/></td>	</tr>
</table></td>
<td width="20%"></td>
</tr>
</table>

<table width="80%">
<th><input type="submit" value="Calculer"></th>
</table>
		</form>

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
	
<table width="80%">
<th>Calcul de votre Offre</th>
</table>

<table>
		<form action="index.php" method="post">
		<input type='hidden' name='action' value='addtrade'>
	<tr>
	<td>
	<table>
		<td colspan="3">
		<center>Vous pouvez encore modifier votre offre à votre convenance.</center>
		</td>
		<tr>
		<th></th>
		<th>votre offre (K)</th>
		<th>votre demande (K)</th>
		</tr>
		
<?php //Métal
?>
		<tr>
		<th>Métal</th>
		<th><input type="text" name="offer_metal" value=<?php echo round($metal); ?> /></th>
		<th><input type="text" name="want_metal" value=<?php echo round($TotalM); ?> /></th>
		</tr>
		
<?php //Cristal
?>
		<tr>
		<th>Cristal</th>
		<th><input type="text" name="offer_crystal" value=<?php echo round($cristal); ?> /></th>
		<th><input type="text" name="want_crystal" value=<?php echo round($TotalC); ?> /></th>
		</tr>
		
<?php //deutérium
?>
		<tr>
		<th>Deutérium</th>
		<th><input type="text" name="offer_deuterium" value=<?php echo round($deuterium); ?> /></th>
		<th><input type="text" name="want_deuterium" value=<?php echo round($TotalD); ?> /></th>
		</tr>	
	</table>
	</td>
	</tr>
	<tr>
	<td><center><?php echo (rapport(round($metal),round($cristal),round($deuterium),round($TotalM),round($TotalC),round($TotalD))); ?></center></td>
	<tr>
</table>

<table width="80%">
<th>Options de l'Offre</th>
</table>

<table width="100%">
<tr>
<td></td>
<td align="center" width="30%"><table>
		<tr>	<th colspan="4"> Durée et Infos de l'Offre <?php infobulle('Choisissez la durée de l\'offre et insérez une note d\'infos'); ?></th>	</tr>	
		<tr>	<td class='c'>Expiration</td><td align="center" class="l"><input type='text' size="5" name='expiration_hours' value='24'></td>  <td colspan="2" class="l">MAXI <?php   echo intval($server_config["max_trade_delay_seco"]/(60*60))." heures "; ?>  </td>	</tr>
		<tr>	<td class='c'>Note</td>	<td colspan='3'class="l"><textarea cols="36" rows="7" name='note'></textarea></td>	</tr>
</table></td>

<td align="center" width="30%"><table>
	<tr>	<th colspan="2">Options de Livraison</th> </tr>
	<tr>
		<td class='c'>Livrable en:</td>
		<td class="l">
			G1<input type="checkbox" value="1" id="livrable[1]" name="deliver_g1"/>
			G2<input type="checkbox" value="1" id="livrable[2]" name="deliver_g2"/>
			G3<input type="checkbox" value="1" id="livrable[3]" name="deliver_g3"/><br/>
			G4<input type="checkbox" value="1" id="livrable[4]" name="deliver_g4"/>
			G5<input type="checkbox" value="1" id="livrable[5]" name="deliver_g5"/>
			G6<input type="checkbox" value="1" id="livrable[6]" name="deliver_g6"/><br/>
			G7<input type="checkbox" value="1" id="livrable[7]" name="deliver_g7"/>
			G8<input type="checkbox" value="1" id="livrable[8]" name="deliver_g8"/>
			G9<input type="checkbox" value="1" id="livrable[9]" name="deliver_g9"/><input type="button" id="valide" name="valide" value="Inverser la selection" onClick="livrable();">
		</td>
	</tr>
	<tr>
		<td class='c'>Payable en:</td>
		<td class="l">
			G1<input type="checkbox" value="1" name="refunding_g1"/>
			G2<input type="checkbox" value="1" name="refunding_g2"/>
			G3<input type="checkbox" value="1" name="refunding_g3"/><br/>
			G4<input type="checkbox" value="1" name="refunding_g4"/>
			G5<input type="checkbox" value="1" name="refunding_g5"/>
			G6<input type="checkbox" value="1" name="refunding_g6"/><br/>
			G7<input type="checkbox" value="1" name="refunding_g7"/>
			G8<input type="checkbox" value="1" name="refunding_g8"/>
			G9<input type="checkbox" value="1" name="refunding_g9"/>
		</td>
	</tr>
</table></td>
<td></td>
</tr>
</table>

<table width="80%">
<th><input type="submit"></th>
</table>
		</form>
<?php
}
require_once("views/page_tail.php");
?>