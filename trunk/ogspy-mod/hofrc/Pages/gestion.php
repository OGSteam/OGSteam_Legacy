<?php
/**
 * gestion.php 
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

global $db, $table_prefix, $prefixe;
require_once('mod/hofrc/Pages/include.php');
define('TABLE_HOFRC_INFO_RC',$table_prefix.'hofrc_info_rc');
define('TABLE_HOFRC_TITLE',$table_prefix.'hofrc_title');
define('TABLE_HOFRC_ATTACK',$table_prefix.'hofrc_attack');
define('TABLE_HOFRC_DEFENCE',$table_prefix.'hofrc_defence');

// Si on supprime un HOF
if($del_id = $_GET['del'])
	{
		$db->sql_query("DELETE FROM `".TABLE_HOFRC_TITLE."` WHERE `".TABLE_HOFRC_TITLE."`.`id_rc` = ".$del_id);
		$db->sql_query("UPDATE `".TABLE_HOFRC_INFO_RC."` SET `publicated` = '0' WHERE ".TABLE_HOFRC_INFO_RC.".`id_rc`  = '".$del_id."'");
	}

// Si on veut ignorer un hof car ils ont peur de montrer leur flotte sur le board
if($ignore_id = $_GET['ignore'])
	{
		$db->sql_query("UPDATE `".TABLE_HOFRC_INFO_RC."` SET `ignored` = '1' WHERE ".TABLE_HOFRC_INFO_RC.".`id_rc`  = '".$ignore_id."'");
	}

// Si on veut traiter un hof ignorer
if($traiter_id = $_GET['traiter'])
	{
		$db->sql_query("UPDATE `".TABLE_HOFRC_INFO_RC."` SET `ignored` = '0' WHERE ".TABLE_HOFRC_INFO_RC.".`id_rc`  = '".$traiter_id."'");
	}

//On va récupérer tout les hofs non publiés
$query_info = $db->sql_query("SELECT `id_rc`, `daterc`, `type_hof`, `coordinates`, `victoire`, `metal_cdr`, `cristal_cdr` FROM `".TABLE_HOFRC_INFO_RC."` WHERE `publicated` = '0' AND `ignored` = '0'"); ;
if ($_POST['url'])
	{
		$db->sql_query("UPDATE `".TABLE_HOFRC_TITLE."` SET `board_url` = '".$_POST['url_board_ogame']."' WHERE ".TABLE_HOFRC_TITLE.".`id_rc`  = '".$_POST['url_id']."'");
		echo "<a><font align='center;'  color='red'>HOF ajouté.</font></a>";
	}
?>
<table width="100%">
	<tr>
		<td class="c" align="center" colspan="8">Listes des HOFS non publiés:</td>
	</tr>
	<tr>
		<th width="110px"><a>Date</a></th>
		<th><a>Type de Hof</a></th>
		<th><a>Coordonnée</a></th>
		<th><a>Attaquant</a></th>
		<th><a>Défenseur</a></th>
		<th><a>Taille du CDR</a></th>
		<th><a>Publier le HOF</a></th>
		<th><a>Ignorer</a></th>
	</tr>
	
<?php
WHILE (list($id_rc, $daterc, $type, $coordinates, $victoire, $metal_cdr, $cristal_cdr) = $db->sql_fetch_row($query_info))
	{
		// On détermine les couleurs pour connaitre les vainqueurs
		if($victoire == "A")
			{
				$att = "green";
				$def = "red";
			}
		elseif ($victoire == "D")
			{
				$att = "red";
				$def = "green";
			}
		elseif ($victoire == "N")
			{
				$att = "orange";
				$def = "orange";
			}
		
		// On récupère les coordonnées de la bataille
		//$query_coordonnee = $db->sql_query("SELECT `coordinates` FROM ".TABLE_HOFRC_DEFENCE." WHERE `id_rc` = '$id_rc'");
		//list($skin) = $db->sql_fetch_row($query_skin);
?>
	<tr>
		<th width="110px"><?php echo date("H:i:s - j-m-Y",$daterc);?></th>
		<th><?php echo $type;?></th>
		<th><?php echo $coordinates;?></th>
		<th><?php $query_Att = $db->sql_query("SELECT player FROM ".TABLE_HOFRC_ATTACK." WHERE `id_rc`=".$id_rc." AND round = 1 GROUP BY player");while($queryAtt = mysql_fetch_array( $query_Att )){ echo "<span style='color:".$att.";'>".$queryAtt['player']."</span><br>";}?></th>
		<th><?php $query_Def1 = $db->sql_query("SELECT player FROM ".TABLE_HOFRC_DEFENCE." WHERE `id_rc`=".$id_rc." AND round = 1 GROUP BY player");WHILE($queryDef1 = mysql_fetch_array( $query_Def1 )){ echo "<span style='color:".$def.";'>".$queryDef1['player']."</span><br>";}?></th>
		<th><?php echo number_format($metal_cdr + $cristal_cdr,0,'','.');?></th> 
		<th>
			<form style="text-align:center;" method="POST" action="index.php?action=hofrc&subaction=publier&id=<?php echo $id_rc?>&create=ok" name="titlehof">
				<input style="width: 100%; text-align: center; margin-right:50px" type="text" value="Titre du HOF" name="title" />
				<input align="center" type="submit" name="titlehof" value="Publier">
			</form>
		</th>
		<th>
			<form style="text-align:center;" method="POST" action="index.php?action=hofrc&subaction=gestion&ignore=<?php echo $id_rc?>" name="ignore_hof">
				<input align="center" type="submit" name="ignore" value="Ignorer">
			</form>
		</th>
	</tr>
<?php
	}
?>
	
</table>
<br><br>
<?php
//On va récupérer tout les hofs publiés
$query_info_pub = $db->sql_query("SELECT `id_rc`, `daterc`, `type_hof`, `coordinates`, `victoire`, `metal_cdr`, `cristal_cdr` FROM `".TABLE_HOFRC_INFO_RC."` WHERE `publicated` = '1'");
?>
<table width="100%">
	<tr>
		<td class="c" align="center" colspan="7">Listes des HOFS non publiés:</td>
	</tr>
	<tr>
		<th width="110px"><a>Date</a></th>
		<th><a>Type de Hof</a></th>
		<th><a>Coordonnée</a></th>
		<th><a>Attaquant</a></th>
		<th><a>Défenseur</a></th>
		<th><a>Taille du CDR</a></th>
		<th><a>Supprimer le HOF</a></th>
	</tr>
	
<?php
WHILE (list($id_rc_pub, $daterc_pub, $type_pub, $coordinates_pub, $victoire_pub, $metal_cdr_pub, $cristal_cdr_pub) = $db->sql_fetch_row($query_info_pub))
	{
		// On détermine les couleurs pour connaitre les vainqueurs
		if($victoire_pub == "A")
			{
				$att_pub = "green";
				$def_pub = "red";
			}
		elseif ($victoire_pub == "D")
			{
				$att_pub = "red";
				$def_pub = "green";
			}
		elseif ($victoire_pub == "N")
			{
				$att_pub = "orange";
				$def_pub = "orange";
			}
		
		
?>
	<tr>
		<th width="110px"><?php echo date("H:i:s - j-m-Y",$daterc_pub);?></th>
		<th><?php echo $type_pub;?></th>
		<th><?php echo $coordinates_pub;?></th>
		<th><?php $query_Att_pub = $db->sql_query("SELECT `player` FROM ".TABLE_HOFRC_ATTACK." WHERE `id_rc`=".$id_rc_pub." AND round = 1 GROUP BY player");while($queryAtt_pub = mysql_fetch_array( $query_Att_pub )){ echo "<span style='color:".$att_pub.";'>".$queryAtt_pub['player']."</span><br>";}?></th>
		<th><?php $query_Def_pub = $db->sql_query("SELECT `player` FROM ".TABLE_HOFRC_DEFENCE." WHERE `id_rc`=".$id_rc_pub." AND round = 1 GROUP BY player");while($queryDef_pub = mysql_fetch_array( $query_Def_pub )){ echo "<span style='color:".$def_pub.";'>".$queryDef_pub['player']."</span><br>";}?></th>
		<th><?php echo number_format($metal_cdr_pub + $cristal_cdr_pub,0,'','.');?></th> 
		<th><form style="text-align:center;" method="POST" action="index.php?action=hofrc&subaction=gestion&del=<?php echo $id_rc_pub?>" name="del_hof">
				<input align="center" type="submit" name="del" value="Supprimer">
			</form></th>
	</tr>
	<?php
	}
?>
	
</table>
<br><br>
<?php
//Si on décide de poster le HOF enfin de compte
$query_info_ign = $db->sql_query("SELECT `id_rc`, `daterc`, `type_hof`, `coordinates`, `victoire`, `metal_cdr`, `cristal_cdr` FROM `".TABLE_HOFRC_INFO_RC."` WHERE `ignored` = '1'");
?>
<table width="100%">
	<tr>
		<td class="c" align="center" colspan="7">Listes des HOFS non publiés:</td>
	</tr>
	<tr>
		<th width="110px"><a>Date</a></th>
		<th><a>Type de Hof</a></th>
		<th><a>Coordonnée</a></th>
		<th><a>Attaquant</a></th>
		<th><a>Défenseur</a></th>
		<th><a>Taille du CDR</a></th>
		<th><a>Traiter</a></th>
	</tr>
	
<?php
WHILE (list($id_rc_ign, $daterc_ign, $type_ign, $coordinates_ign, $victoire_ign, $metal_cdr_ign, $cristal_cdr_ign) = $db->sql_fetch_row($query_info_ign))
	{
		// On détermine les couleurs pour connaitre les vainqueurs
		if($victoire_ign == "A")
			{
				$att_ign = "green";
				$def_ign = "red";
			}
		elseif ($victoire_ign == "D")
			{
				$att_ign = "red";
				$def_ign = "green";
			}
		elseif ($victoire_pub == "N")
			{
				$att_ign = "orange";
				$def_ign = "orange";
			}
		
		// On récupère les coordonnées de la bataille
		$query_coordonnee_ign = $db->sql_query("SELECT `coordinates` FROM ".TABLE_HOFRC_DEFENCE." WHERE `id_rc` = '$id_rc'");
		list($skin_ign) = $db->sql_fetch_row($query_skin_ign);
?>
	<tr>
		<th width="110px"><?php echo date("H:i:s - j-m-Y",$daterc_pub);?></th>
		<th><?php echo $type_ign;?></th>
		<th><?php echo $coordinates_ign;?></th>
		<th><?php $query_Att_ign = $db->sql_query("SELECT `player` FROM ".TABLE_HOFRC_ATTACK."  WHERE `id_rc`=".$id_rc_ign." AND round = 1 GROUP BY player");while($queryAtt_ign = mysql_fetch_array( $query_Att_ign )){ echo "<span style='color:".$att_ign.";'>".$queryAtt_ign['player']."</span><br>";}?></th>
		<th><?php $query_Def_ign = $db->sql_query("SELECT `player` FROM ".TABLE_HOFRC_DEFENCE." WHERE `id_rc`=".$id_rc_ign." AND round = 1 GROUP BY player");while($queryDef_ign = mysql_fetch_array( $query_Def_ign )){ echo "<span style='color:".$def_ign.";'>".$queryDef_ign['player']."</span><br>";}?></th>
		<th><?php echo number_format($metal_cdr_ign + $cristal_cdr_ign,0,'','.');?></th> 
		<th><form style="text-align:center;" method="POST" action="index.php?action=hofrc&subaction=gestion&traiter=<?php echo $id_rc_ign?>" name="traiter_hof">
				<input align="center" type="submit" name="del" value="Traiter">
			</form></th>
	</tr>
	<?php
	}
?>
	
</table>
