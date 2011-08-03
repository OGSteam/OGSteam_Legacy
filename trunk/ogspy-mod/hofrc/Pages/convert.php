<?php
/**
 * convert.php 
 * @package HofRC
 * @author Shad
 * @link http://www.ogsteam.fr
 * @version : 0.0.1
 */


// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='hofrc' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");
//echo"<script type='text/javascript' language='javascript' src='hofrc/script.js'></script>";
//Définitions
global $db, $table_prefix, $prefixe;
require_once('mod/hofrc/Pages/include.php');

// Gestion des dates


//Si les dates d'affichage ne sont pas définies, on affiche par défaut les attaques du jour,
if(!empty($_POST["from_day"]) && !empty($_POST["from_day"])  &&!empty($_POST["from_day"]) )
	{
		$from_day = $_POST['from_day'];
		$from_month = $_POST['from_month'];
		$from_year = $_POST['from_year'];
		$pub_date_from = mktime(0, 0, 0, $from_month, $from_day, $from_year);
		$from_septjours = $day-7;
		$from_yesterday = $day-1;
	}
else
	{
		$from_day = date("j");
		$from_month = date("m");
		$from_year = date("Y");
		$pub_date_from = mktime(0, 0, 0, $from_month, $from_day, $from_year);
		$from_septjours = $day-7;
		$from_yesterday = $day-1;
	}


		
if(!empty($_POST["to_day"]) && !empty($_POST["to_day"])  &&!empty($_POST["to_day"]) )
	{
		$to_day = $_POST['to_day'];
		$to_month = $_POST['to_month'];
		$to_year = $_POST['to_year'];
		$pub_date_to = mktime(23, 59, 59, $to_month, $to_day, $to_year);
		$to_septjours = $day-7;
		$to_yesterday = $day-1;
	}
else
	{
		$to_day = date("j");
		$to_month = date("m");
		$to_year = date("Y");
		$pub_date_to = mktime(23, 59, 59, $to_month, $to_day, $to_year);
		$to_septjours = $day-7;
		$to_yesterday = $day-1;
	}

	
	$queryRC =  $db->sql_query("SELECT `".TABLE_PARSEDRC."`.`id_rc`,`dateRC`,`coordinates`,`victoire`,`pertes_A`,`pertes_D`,`gain_M`,`gain_C`,`gain_D`,`debris_M`,`debris_C` , `".TABLE_PARSEDRCROUND."`.`id_rc`,`numround`,`id_rcround` FROM `".TABLE_PARSEDRCROUND."` LEFT JOIN `".TABLE_PARSEDRC."` on `".TABLE_PARSEDRC."`.`id_rc`=`".TABLE_PARSEDRCROUND."`.`id_rc`  WHERE `dateRC` > ".$pub_date_from." AND `dateRC` < ".$pub_date_to." AND numround=1 ORDER BY dateRC");

?>
<script language="JavaScript" type="text/javascript">
function show_bbcode() {
	if(document.getElementById('bbcode').style.display == 'none') {
		document.getElementById('bbcode').style.display = 'inline';
		document.getElementById('bbcode').value = 'Cacher la liste';
	} else {
		document.getElementById('bbcode').style.display = 'none';
		document.getElementById('select_bbcode').value = 'Affichage le BBCode';
	}
}


function copyclipboard(intext)
{  window.clipboardData.setData('Text', intext);     }

</script><?php
if (!empty($_GET["result"]))
	{
		$id=$_GET["result"];

		?>

		<table width="90%">
			<tr>	
				<th><?php
					$rc_convert = convert($id,'preview','raid','');	
					echo nl2br($rc_convert);?>
				</th>
			</tr>
			<tr>
				<td class="c" colspan="2" style="text-align:center;">
					<input type="button" onClick="show_bbcode();" id="select_bbcode" value="Afficher le BBCode">
				</td>
			</tr>
			<tr>
				<th>
					<div  id="bbcode" style="display: none; float: center; padding: 0;"><?php
					$rc_convert_bbcode = convert($id,'bbcode','raid','');
					echo nl2br($rc_convert_bbcode);?>
					</div>
				</th>
			</tr>
		</table><?php
	}

?>

<table width="90%">
	<tr>
		<td colspan="11" style="text-align:center;"><?php
			//On récupère la date au bon format
			$pub_date_from = strftime("%d %m %Y", $pub_date_from);
			$pub_date_to = strftime("%d %m %Y", $pub_date_to);

			//Création du field pour choisir l'affichage (attaque du jour, de la semaine ou du mois)
?>
			<fieldset><legend><b><font color='#0080FF'>Recherche de Rapport de Combat</font></b></legend>
				<form action="index.php?action=hofrc&subaction=convert" method="post" name="date">
					<label>Recherche entre le :</label>
					<input style="width: 20px; text-align: center;" type="text" value="<?php echo $from_day;?>" name="from_day" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $from_month;?>" name="from_month" /> / <input style="width: 40px; text-align: center;" type="text" value="<?php echo $from_year;?>" name="from_year" /> et le
					<input style="width: 20px; text-align: center;" type="text" value="<?php echo $to_day;?>" name="to_day" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $to_month;?>" name="to_month" /> / <input style="width: 40px; text-align: center;" type="text" value="<?php echo $to_year;?>" name="to_year" />	<br><br>
					<input  type="submit" name="search_date" value="Valider" />
				</form>
			</fieldset>
			<br><br>
		</td>
	</tr>
	
	<tr>
		<td class="c" align="center" colspan="11">Listes des RC enregistrés dans OGSpy:</td>
	</tr>
	<tr>
		<th><a>Hof</a></th>
		<th><a>Date</a></th>
		<th><a>Coordonnée</a></th>
		<th><a>Attaquant<br>Nom/Pertes</a></th>
		<th><a>Défenseur<br>Nom/Pertes</a></th>
		<th><a>Pillage Métal</a></th>
		<th><a>Pillage Cristal</a></th>
		<th><a>Pillage Deutérium</a></th>
		<th><a>Taille CDR</a></th>
		<th><a>Voir le rc original</a></th>
		<th><a>Convertir le RC</a></th>
	</tr>
<?php

while ($data = mysql_fetch_assoc($queryRC)) 

	{
		$id_rcround = $data['id_rcround'];
		$query_Nb_Att = $db->sql_query("SELECT player FROM ".TABLE_ROUND_ATTACK." WHERE `id_rcround`=".$id_rcround.' GROUP BY player'); $Nb_Att = mysql_num_rows( $query_Nb_Att );
		$query_Nb_Def = $db->sql_query("SELECT player FROM ".TABLE_ROUND_DEFENSE." WHERE `id_rcround`=".$id_rcround.' GROUP BY player'); $Nb_Def = mysql_num_rows( $query_Nb_Def );
		$type_hof = find_hof($Nb_Att, $Nb_Def, $data['victoire'], $data['dateRC'], $data['debris_M'], $data['debris_C'], $data['id_rc']);
		
?>
 
	<tr>
		<th><?php echo $type_hof;?></th>
		<th><?php echo date("H:i:s - j-m-Y",$data['dateRC']);?></th>
		<th><?php echo $data['coordinates'];?></th>
		<th><?php $queryAtt = $db->sql_query("SELECT player FROM ".TABLE_ROUND_ATTACK." WHERE `id_rcround`=".$id_rcround.' GROUP BY player'); while($player_att = mysql_fetch_array( $queryAtt )){ echo $player_att['player']."<br>";}?><?php echo number_format($data['pertes_A'],0,'','.');?></th>
		<th><?php $queryDef = $db->sql_query("SELECT player FROM ".TABLE_ROUND_DEFENSE." WHERE `id_rcround`=".$id_rcround.' GROUP BY player');while($player_def = mysql_fetch_array( $queryDef )){ echo $player_def['player']."<br>";}?><?php  echo number_format($data['pertes_D'],0,'','.');?></th>
		<th><?php echo number_format($data['gain_M'],0,'','.');?></th> 
		<th><?php echo number_format($data['gain_C'],0,'','.');?></th> 
		<th><?php echo number_format($data['gain_D'],0,'','.');?></th> 
		<th><?php echo number_format($data['debris_M'] + $data['debris_C'],0,'','.');?></th>
		<th><a style="cursor:pointer" onclick="window.open('index.php?action=hofrc&subaction=preview&id=<?php echo $data['id_rc']?>', 'RC Original', 'width=920, height=550, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no'); return false;">Vérifier</a></th>
		<th><a style="cursor:pointer" href="index.php?action=hofrc&subaction=convert&result=<?php echo $data['id_rc']?>">Convertir</a></th>
	</tr>
		<?php
	
	}
	
	//fin de la boucle<th>
	?>
	
</table>
	