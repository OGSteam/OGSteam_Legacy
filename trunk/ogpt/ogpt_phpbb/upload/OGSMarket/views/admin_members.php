<?php
/***************************************************************************
*	filename	: Admin_members.php
*	desc.		: 
*	Author		: Mirtador
*	created		: 11/15/06
***************************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");
require_once("views/admin_menu.php");
?>
		<table width="80%" align="center" border="1">
			<tr>
				<th colspan="7">Liste des Membres</th>
			</tr>
			<tr>
				<th><a href="index.php?action=admin_members&amp;sortby=byname">Nom</a></th>
				<th><a href="index.php?action=admin_members&amp;sortby=bymail">Email</a></th>
				<th><a href="index.php?action=admin_members&amp;sortby=bylastvisit">Dernière Visite</a></th>
				<th><a href="index.php?action=admin_members&amp;sortby=byadmin">Administrateur</a></th>
				<th><a href="index.php?action=admin_members&amp;sortby=bymod">Modérateur</a></th>
				<th><a href="index.php?action=admin_members&amp;sortby=byactif">Actif</a></th>
				<th>Action</th>
			</tr>
			<?php
			
			if(!isset($ogs_sortby)) $ogs_sortby = "";
	
	switch ($ogs_sortby){
		case "byname":
			$orderby=" ORDER BY name asc";
			break;
		case "bymail":
			$orderby=" ORDER BY email asc";
			break;
		case "bylastvisit":
			$orderby=" ORDER BY lastvisit desc";
			break;
		case "byadmin":
			$orderby=" ORDER BY is_admin desc";
			break;
		case "bymod":
			$orderby=" ORDER BY is_moderator desc";
			break;
		case "byactif":
			$orderby=" ORDER BY is_active desc";
			break;
	}
			
			
			$query = "SELECT `id`, `name`, `lastvisit`, `email`, `is_admin`, `is_moderator`, `is_active` from ".TABLE_USER." ".$orderby.";";
			$result	=	$db->sql_query($query);
			while (list( $id, $name, $lastvisit, $email, $is_admin, $is_moderator, $is_active) = $db->sql_fetch_row($result))
			{
			echo "<tr>";
				//Première colonne
					echo"<th>";
				//	echo"$name</a>";
					echo "\t<a href='index.php?action=profile&amp;id=".$id."'>".$name."</a>\n";
					echo"</th>";
				//Deuxième colonne
					echo"<th>";
					echo"$email";
					echo"</th>";
				//Troisième colonne
					echo"<th>";
					echo strftime("%a %d %b %H:%M:%S",$lastvisit);
					echo"</th>";				
				//Quatrième colonne
					echo"<th>";
					if ($is_admin==1)
						{ echo "<font color=\"#00FF00\">Oui</font>"; 
						//Bouton retirer le statut d'Administrateur
							echo "<form method='POST' action='index.php?action=admin_unset_admin&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous sûr de vouloir retiter le statut d&rsquo;Admin à ".$name."');\">"."\n";
							echo "\t"." <input type='image' src='images/usercheck.png' title='Retirer le statut d&rsquo;Administrateur à ".$name."'>"."\n";
							echo "</form>"."\n";	
						}
					else 
						{echo "<font color=\"#FF0000\">Non</font>";
						//Bouton nommer un Administrateur
							echo "<form method='POST' action='index.php?action=admin_set_admin&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous sûr de vouloir donner le statut d&rsquo;Admin à ".$name."');\">"."\n";
							echo "\t"."<input type='image' src='images/usercheck.png' title='Donner le statut d&rsquo;Admin à ".$name."'>"."\n";
							echo "</form>"."\n";	
						}
						echo"</th>";
				//Cinquième colonne
					echo"<th>";
					if ($is_moderator==1)
						{
						echo "<font color=\"#00FF00\">Oui</font>";
						//Bouton retirer le statut de modérateur
					echo "<form method='POST' action='index.php?action=admin_unset_moderator&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous sûr de vouloir retirer le statut de modérateur a ".$name."');\">"."\n";
					echo "\t"."<input type='image' src='images/usercheck.png' title='Retirer le statut de modérateur à ".$name."'>"."\n";
					echo "</form>"."\n";
						}
					else 	{
						echo "<font color=\"#FF0000\">Non</font>";
						//Bouton nommer un modérateur
					echo "<form method='POST' action='index.php?action=admin_set_moderator&user_id=".$id."' onsubmit=\"return confirm('Etes-vous sûr de vouloir donner le statut de modérateur ".$name."');\">"."\n";
					echo "\t"."<input type='image' src='images/usercheck.png' title='Donner le statut de modérateur à ".$name."'>"."\n";
					echo "</form>"."\n";
						}
					echo"</th>";
				//Sixième colonne
					echo"<th>";
					if ($is_active==1)
						{
						echo "<font color=\"#00FF00\">Oui</font>";
						//Bouton Désactiver
							echo "<form method='POST' action='index.php?action=admin_unset_active&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous sûr de vouloir Désactivé ".$name."');\">"."\n";
							echo "\t"."<input type='image' src='images/usercheck.png' title='Désactiver  ".$name."'>"."\n";
							echo "</form>"."\n";
						}
					else 	{
						echo "<font color=\"#FF0000\">Non</font>";
						//Bouton activer
							echo "<form method='POST' action='index.php?action=admin_set_active&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous sûr de vouloir activé ".$name."');\">"."\n";
							echo "\t"."<input type='image' src='images/usercheck.png' title='Activer ".$name."'>"."\n";
							echo "</form>"."\n";
						}
					echo"</th>";
				//Septième colonne
					echo"<th>";
					echo "<form method='POST' action='index.php?action=admin_delete_user&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous sûr de vouloir supprimer ".$name."');\">"."\n";
					echo "\t"."<input type='image' src='images/userdrop.png' title='Supprimer ".$name."'>"."\n";
					echo "</form>"."\n";
					echo"</th>";
				//Fin de la ligne
			echo "</tr>";
			}
			?>
		</table>

<?php
require_once("views/page_tail.php");
?>