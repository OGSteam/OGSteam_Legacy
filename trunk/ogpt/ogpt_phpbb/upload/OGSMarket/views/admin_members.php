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
				<th><a href="index.php?action=admin_members&amp;sortby=bylastvisit">Derni�re Visite</a></th>
				<th><a href="index.php?action=admin_members&amp;sortby=byadmin">Administrateur</a></th>
				<th><a href="index.php?action=admin_members&amp;sortby=bymod">Mod�rateur</a></th>
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
				//Premi�re colonne
					echo"<th>";
				//	echo"$name</a>";
					echo "\t<a href='index.php?action=profile&amp;id=".$id."'>".$name."</a>\n";
					echo"</th>";
				//Deuxi�me colonne
					echo"<th>";
					echo"$email";
					echo"</th>";
				//Troisi�me colonne
					echo"<th>";
					echo strftime("%a %d %b %H:%M:%S",$lastvisit);
					echo"</th>";				
				//Quatri�me colonne
					echo"<th>";
					if ($is_admin==1)
						{ echo "<font color=\"#00FF00\">Oui</font>"; 
						//Bouton retirer le statut d'Administrateur
							echo "<form method='POST' action='index.php?action=admin_unset_admin&user_id=".$id."' onsubmit=\"return confirm('�tes-vous s�r de vouloir retiter le statut d&rsquo;Admin � ".$name."');\">"."\n";
							echo "\t"." <input type='image' src='images/usercheck.png' title='Retirer le statut d&rsquo;Administrateur � ".$name."'>"."\n";
							echo "</form>"."\n";	
						}
					else 
						{echo "<font color=\"#FF0000\">Non</font>";
						//Bouton nommer un Administrateur
							echo "<form method='POST' action='index.php?action=admin_set_admin&user_id=".$id."' onsubmit=\"return confirm('�tes-vous s�r de vouloir donner le statut d&rsquo;Admin � ".$name."');\">"."\n";
							echo "\t"."<input type='image' src='images/usercheck.png' title='Donner le statut d&rsquo;Admin � ".$name."'>"."\n";
							echo "</form>"."\n";	
						}
						echo"</th>";
				//Cinqui�me colonne
					echo"<th>";
					if ($is_moderator==1)
						{
						echo "<font color=\"#00FF00\">Oui</font>";
						//Bouton retirer le statut de mod�rateur
					echo "<form method='POST' action='index.php?action=admin_unset_moderator&user_id=".$id."' onsubmit=\"return confirm('�tes-vous s�r de vouloir retirer le statut de mod�rateur a ".$name."');\">"."\n";
					echo "\t"."<input type='image' src='images/usercheck.png' title='Retirer le statut de mod�rateur � ".$name."'>"."\n";
					echo "</form>"."\n";
						}
					else 	{
						echo "<font color=\"#FF0000\">Non</font>";
						//Bouton nommer un mod�rateur
					echo "<form method='POST' action='index.php?action=admin_set_moderator&user_id=".$id."' onsubmit=\"return confirm('Etes-vous s�r de vouloir donner le statut de mod�rateur ".$name."');\">"."\n";
					echo "\t"."<input type='image' src='images/usercheck.png' title='Donner le statut de mod�rateur � ".$name."'>"."\n";
					echo "</form>"."\n";
						}
					echo"</th>";
				//Sixi�me colonne
					echo"<th>";
					if ($is_active==1)
						{
						echo "<font color=\"#00FF00\">Oui</font>";
						//Bouton D�sactiver
							echo "<form method='POST' action='index.php?action=admin_unset_active&user_id=".$id."' onsubmit=\"return confirm('�tes-vous s�r de vouloir D�sactiv� ".$name."');\">"."\n";
							echo "\t"."<input type='image' src='images/usercheck.png' title='D�sactiver  ".$name."'>"."\n";
							echo "</form>"."\n";
						}
					else 	{
						echo "<font color=\"#FF0000\">Non</font>";
						//Bouton activer
							echo "<form method='POST' action='index.php?action=admin_set_active&user_id=".$id."' onsubmit=\"return confirm('�tes-vous s�r de vouloir activ� ".$name."');\">"."\n";
							echo "\t"."<input type='image' src='images/usercheck.png' title='Activer ".$name."'>"."\n";
							echo "</form>"."\n";
						}
					echo"</th>";
				//Septi�me colonne
					echo"<th>";
					echo "<form method='POST' action='index.php?action=admin_delete_user&user_id=".$id."' onsubmit=\"return confirm('�tes-vous s�r de vouloir supprimer ".$name."');\">"."\n";
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