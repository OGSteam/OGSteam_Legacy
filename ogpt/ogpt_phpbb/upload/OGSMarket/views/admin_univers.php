<?php
/***************************************************************************
*	filename	: Admin_univers.php
*	desc.		:
*	Author		: Mirtador
*	created		: 11/21/06
***************************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");
require_once("views/admin_menu.php");
echo "<table>";
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=admin_new_univers';\">";
		echo "<a style='cursor:pointer'><font color='lime'><center>Ajouter un univers<center></font></a>";
echo "</table>";
 
	if(isset($ogs_info)) echo "<table><tr><th class='c' colspan='2'><h2>".$ogs_info."</h2></th></tr><table>";

?>

		<table width="80%" align="center" border="1">
			<tr>
				<th colspan="4">liste des Univers</th>
			</tr>
			<tr>
				<th>ID</th>
				<th>nom</th>
				<th>Adresse</th>
				<th>Action</th>

			</tr>

			<?php
			$query = "SELECT `id`, `name`, `url` from ".TABLE_UNIVERS.";";
			$result	=	$db->sql_query($query);
			while (list( $id, $name, $url) = $db->sql_fetch_row($result))
				{
				//Début de la ligne
				echo "<tr>";
					//Première colonne
						echo "<th>";
						echo "$id";
						echo "</th>";
					//Deuxième colonne
						echo "<th>";
						echo "$name";
						echo "</th>";
					//Troisième colonne
						echo "<th>";
						echo "<a href=\"http://$url\">$url</a>";
						echo "</th>";
					//Quatrième colonne
						echo "<th>";
						echo "<form method='POST' action='index.php?action=admin_delete_univers&universeid=".$id."' onsubmit=\"return confirm('Êtes-vous sûr de vouloir supprimer ".$name."');\">"."\n";
						echo "\t"."<input type='image' src='images/drop.png' title='Supprimer l&rsquo;univers: ".$name."'>"."\n";
						echo "</form>"."\n";
						echo "</th>";
					//Fin de la ligne
				echo "</tr>";
				}
			?>
		</table>


<?php
require_once("views/page_tail.php");
?>
