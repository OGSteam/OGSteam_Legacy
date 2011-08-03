<?php

/**
 * publier.php 
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

//Définitions
global $db, $table_prefix, $prefixe;
// define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');
// define('TABLE_HOFRC_ATTACK',$table_prefix.'hofrc_attack');
define('TABLE_HOFRC_DEFENSE',$table_prefix.'hofrc_defence');
define('TABLE_HOFRC_INFO_RC',$table_prefix.'hofrc_info_rc');
define('TABLE_HOFRC_TITLE',$table_prefix.'hofrc_title');

require_once('mod/hofrc/Pages/include.php');
$id_rc = $_GET["id"];
if ($_GET["create"] == 'ok')
	{
		$nb_enregistrement = $db->sql_query("SELECT count(*) from `".TABLE_HOFRC_TITLE."`");
		$numero = (mysql_result($nb_enregistrement,0) + 1);
		var_dump($numero);
		$db->sql_query("UPDATE `".TABLE_HOFRC_INFO_RC."` SET `publicated` = '1' WHERE ".TABLE_HOFRC_INFO_RC.".`id_rc`  = '".$id_rc."'");
		$db->sql_query("INSERT INTO `".TABLE_HOFRC_TITLE."` (`id`, `id_rc`, `board_url`, `title`) VALUES ('".$numero."', '".$id_rc."', '', '".$_POST['title']."')");
		$id = $db->sql_query("SELECT `id` FROM `".TABLE_HOFRC_TITLE."` ORDER BY id DESC LIMIT 0,1");
		list($last_id) = $db->sql_fetch_row($id);
		historique($last_id);
		
	}

$query_player_date = $db->sql_query("SELECT `player`, `daterc` FROM `".TABLE_HOFRC_DEFENSE."`, `".TABLE_HOFRC_INFO_RC."` WHERE `".TABLE_HOFRC_DEFENSE."`.id_rc =  ".$id_rc." AND `".TABLE_HOFRC_INFO_RC."`.id_rc = ".$id_rc);
list($player, $date) = $db->sql_fetch_row($query_player_date);

$queryRC =  $db->sql_query("SELECT `".TABLE_PARSEDRC."`.`id_rc`,`dateRC`,`coordinates`,`victoire`,`pertes_A`,`pertes_D`,`gain_M`,`gain_C`,`gain_D`,`debris_M`,`debris_C` , `".TABLE_PARSEDRCROUND."`.`id_rc`,`numround`,`id_rcround` FROM `".TABLE_PARSEDRCROUND."` LEFT JOIN `".TABLE_PARSEDRC."` on `".TABLE_PARSEDRC."`.`id_rc`=`".TABLE_PARSEDRCROUND."`.`id_rc`  WHERE `dateRC` > ".$date." AND numround=1 ORDER BY dateRC");

if ($_POST["raid"])
	 {
		
		// On véréfie que pillage et raid ne sont pas tout les 2 cocher
		for($i=1; $i<=$_POST["count"]; $i++)
		{
			if(!empty($_POST[$i]))
				{
					$pillage .= $_POST[$i];
					
				}
		}
		$db->sql_query("UPDATE `".TABLE_HOFRC_TITLE."` SET `pillage` = '".$pillage."' WHERE ".TABLE_HOFRC_TITLE.".`id_rc`  = '".$id_rc."'");
				
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

</script>
	<table align="center" width="90%">
			<tr>	
				<th><?php
					$rc_convert = convert($id_rc,'preview',"1",$pillage);	
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
					$rc_convert_bbcode = convert($id_rc,'bbcode',"1", $pillage);
					echo nl2br($rc_convert_bbcode);?>
					</div>
				</th>
			</tr>
			<tr>
				<th>
					<form style="text-align:center;" method="POST" action="index.php?action=hofrc&subaction=gestion" name="url">
						<input style="width: 200px; text-align: center; margin-right:50px" type="text"  name="url_board_ogame" />
						<input type="hidden" name="url_id" value="<?php echo $id_rc?>"> 
						<input align="center" type="submit" name="url" value="Publier">
					</form>
				</th>
			</tr>
	</table><?php
		
	}



?>
<table align="center" width="90%">
<form method="post" enctype="multipart/form-data" action="index.php?action=hofrc&subaction=publier&id=<?php echo $id_rc;?>">
	<tr>
		<td class="c" align="center" colspan="11">Listes des RC enregistrés dans OGSpy:<?php echo infobulle("Validez en bas de la page lorsque vous avez finie.");?> <font color="red">Ne sélectionner que les pillages du HOF</font></td>
	</tr>
	<tr>
		<tr>
		
			<th><a>Date</a></th>
			<th><a>Coordonnée</a></th>
			<th><a>Attaquant<br>Nom/Pertes</a></th>
			<th><a>Défenseur<br>Nom/Pertes</a></th>
			<th><a>Pillage Métal</a></th>
			<th><a>Pillage Cristal</a></th>
			<th><a>Pillage Deutérium</a></th>
			<th><a>Taille CDR</a></th>
			<th><a>Voir le rc original</a></th>
			<th><a>Type</a></th>
		</tr>			
	</tr>
	
<?php
 $count = 0;
while ($data = mysql_fetch_assoc($queryRC))

	{
		$id_rcround = $data['id_rcround'];
			if ($data['id_rc']!= $id_rc)
			{
				$count = $count +1;
?>
	
 <tr>
		<th><?php echo date("H:i:s - j-m-Y",$data['dateRC']);?></th>
		<th><?php echo $data['coordinates'];?></th>
		<th>
			<?php 
				$queryAtt = $db->sql_query("SELECT player FROM ".TABLE_ROUND_ATTACK." WHERE `id_rcround`=".$id_rcround.' GROUP BY player'); 
					while($player_att = mysql_fetch_array( $queryAtt ))
						{ 
							echo $player_att['player']."<br>";
						}
				echo number_format($data['pertes_A'],0,'','.');
			?>
		</th>
		<th>
			<?php 
				$queryDef = $db->sql_query("SELECT player FROM ".TABLE_ROUND_DEFENSE." WHERE `id_rcround`=".$id_rcround.' GROUP BY player');
					while($player_def = mysql_fetch_array( $queryDef ))
						{ 
							if ($player_def['player'] == $player )
								{ 
									echo '<font color="blue">';
								}
							echo $player_def['player']."<br>";
							if ($player == $player_def['player'])
								{ 
									echo '</font>';
								}
						}
					echo number_format($data['pertes_D'],0,'','.');
			?>
		</th>
		<th><?php echo number_format($data['gain_M'],0,'','.');?></th> 
		<th><?php echo number_format($data['gain_C'],0,'','.');?></th> 
		<th><?php echo number_format($data['gain_D'],0,'','.');?></th> 
		<th><?php echo number_format($data['debris_M'] + $data['debris_C'],0,'','.');?></th>
		<th><a style="cursor:pointer" onclick="window.open('index.php?action=hofrc&subaction=preview&id=<?php echo $data['id_rc']?>', 'RC Original', 'width=920, height=550, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no'); return false;">Vérifier</a></th>
		<th>
			<input type="checkbox" name="<? echo $count?>" value="P<?php echo $data['id_rc']?>">Pillage
		</th>
		
	</tr>
		<?php
	
	}}
					?>	
	<tr>
		<td class="c" align="center" colspan="11">
			<input type="hidden" name="count" value="<?php echo $count?>"> 
			<input  type="submit" name="raid" value="Valider" />
			
		</td>
	</tr>
	</form>
	</table>

