<?php
//http://www.maconlinux.net/php-online-manual/fr/language.variables.variable.html
//Sécuritée
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// variable globale
$tooltip_stats = array(); // utiliser dans fonctions_missiles.php

// Test si le module est active
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='missiles' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

//Définitions
global $table_prefix;
global $db;

// Récupération des données envoyer
if (!isset($pub_action))
	$pub_action = "";

if ($pub_action == "missiles")
{
	$type_search		= isset($pub_type_search)?$pub_type_search:"";
	$string_search	= isset($pub_string_search)?$pub_string_search:"";
	$string_search1	= isset($pub_string_search1)?$pub_string_search1:"";
	$string_search2	= isset($pub_string_search2)?$pub_string_search2:"";
	$strict					= isset($pub_strict)?$pub_strict:"";

	$check_g1 			= isset($pub_check_g1)?$pub_check_g1:"off";
	$check_g2 			= isset($pub_check_g2)?$pub_check_g2:"off";
	$check_g3 			= isset($pub_check_g3)?$pub_check_g3:"off";
	$check_g4 			= isset($pub_check_g4)?$pub_check_g4:"off";
	$check_g5 			= isset($pub_check_g5)?$pub_check_g5:"off";
	$check_g6 			= isset($pub_check_g6)?$pub_check_g6:"off";
	$check_g7 			= isset($pub_check_g7)?$pub_check_g7:"off";
	$check_g8 			= isset($pub_check_g8)?$pub_check_g8:"off";
	$check_g9 			= isset($pub_check_g9)?$pub_check_g9:"off";
}

// Init des checkbox
if (!isset($check_g1) && !isset($check_g2) && !isset($check_g3) && !isset($check_g4) && !isset($check_g5) && !isset($check_g6) && !isset($check_g7) && !isset($check_g8) && !isset($check_g9))
{
	$check_g1 = "off";$check_g2 = "off";$check_g3 = "off";
	$check_g4 = "off";$check_g5 = "off";$check_g6 = "off";
	$check_g7 = "off";$check_g8 = "off";$check_g9 = "off";
}

//Données recherches joueurs
if (!isset($string_search) && !isset($string_search1) && !isset($string_search2)) 
{
	$string_search 	= "";
	$string_search1 = "";
	$string_search2	= "";
}

if (!isset($type_search) && !isset($strict) || isset($strict)) 
{
	$strict = " checked";
}
else 
{
	$strict = "";
}

$type_player	= " checked";
$type_ally 		= "";
$type_planet 	= "";

if (isset($type_search)) 
{
	switch ($type_search) 
	{
		case "player":
			$type_player = " checked";
		break;
		
		case "ally":
			$type_ally = " checked";
		break;
		
		case "planet":
			$type_planet = " checked";
		break;
	}
}

?>
<table width="700">
		<form name="missiles_recherche" method="POST" action="index.php">
		<input type="hidden" name="action" value="missiles">
		<tr>
			<td class="c" colspan="3">Recherche cible(s)</td>
		</tr>
		<tr>
			<th><input name="type_search" value="player" type="radio"<?php echo $type_player;?>></th>
			<th>Joueur</th>
			<th rowspan="3"><input name="string_search" type="text" maxlength="25" size="25" value="<?php echo $string_search;?>">&nbsp;<input name="string_search1" type="text" maxlength="25" size="25" value="<?php echo $string_search1;?>">&nbsp;<input name="string_search2" type="text" maxlength="25" size="25" value="<?php echo $string_search2;?>"></th>
		</tr>
		<tr>
			<th><input name="type_search" value="ally" type="radio"<?php echo $type_ally;?>></th>
			<th>Alliance</th>
		</tr>
		<tr>
			<th><input name="type_search" value="planet" type="radio"<?php echo $type_planet;?>></th>
			<th>Planete</th>
		</tr>
		<tr>
			<th><input name="strict" value="true" type="checkbox"<?php echo $strict;?>></th>
			<th colspan="2">Option strict&nbsp;<?php echo help("search_strict");?></th>
		</tr>
		<tr>
			<td class="c" colspan="3">Restriction de recherche</td>
		</tr>		
		<tr>
			<th colspan="3">
			<?php
			if ($check_g1 == "on")
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g1\" name=\"check_g1\" value=\"on\" type=\"checkbox\" checked /><label for=\"check_g1\"><font color=\"#8BDABA\">G1&nbsp;</font></label>\n";
			else
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g1\" name=\"check_g1\" value=\"on\" type=\"checkbox\" /><label for=\"check_g1\"><font color=\"#EDC76D\">G1&nbsp;</font></label>\n";
				
			if ($check_g2 == "on")
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g2\" name=\"check_g2\" value=\"on\" type=\"checkbox\" checked /><label for=\"check_g2\"><font color=\"#8BDABA\">G2&nbsp;</font></label>\n";
			else
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g2\" name=\"check_g2\" value=\"on\" type=\"checkbox\" /><label for=\"check_g2\"><font color=\"#EDC76D\">G2&nbsp;</font></label>\n";
			
			if ($check_g3 == "on")
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g3\" name=\"check_g3\" value=\"on\" type=\"checkbox\" checked /><label for=\"check_g3\"><font color=\"#8BDABA\">G3&nbsp;</font></label>\n";
			else
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g3\" name=\"check_g3\" value=\"on\" type=\"checkbox\" /><label for=\"check_g3\"><font color=\"#EDC76D\">G3&nbsp;</font></label>\n";
				
			if ($check_g4 == "on")
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g4\" name=\"check_g4\" value=\"on\" type=\"checkbox\" checked /><label for=\"check_g4\"><font color=\"#8BDABA\">G4&nbsp;</font></label>\n";
			else
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g4\" name=\"check_g4\" value=\"on\" type=\"checkbox\" /><label for=\"check_g4\"><font color=\"#EDC76D\">G4&nbsp;</font></label>\n";
				
			if ($check_g5 == "on")
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g5\" name=\"check_g5\" value=\"on\" type=\"checkbox\" checked /><label for=\"check_g5\"><font color=\"#8BDABA\">G5&nbsp;</font></label>\n";
			else
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g5\" name=\"check_g5\" value=\"on\" type=\"checkbox\" /><label for=\"check_g5\"><font color=\"#EDC76D\">G5&nbsp;</font></label>\n";
				
			if ($check_g6 == "on")
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g6\" name=\"check_g6\" value=\"on\" type=\"checkbox\" checked /><label for=\"check_g6\"><font color=\"#8BDABA\">G6&nbsp;</font></label>\n";
			else
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g6\" name=\"check_g6\" value=\"on\" type=\"checkbox\" /><label for=\"check_g6\"><font color=\"#EDC76D\">G6&nbsp;</font></label>\n";
				
			if ($check_g7 == "on")
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g7\" name=\"check_g7\" value=\"on\" type=\"checkbox\" checked /><label for=\"check_g7\"><font color=\"#8BDABA\">G7&nbsp;</font></label>\n";
			else
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g7\" name=\"check_g7\" value=\"on\" type=\"checkbox\" /><label for=\"check_g7\"><font color=\"#EDC76D\">G7&nbsp;</font></label>\n";
				
			if ($check_g8 == "on")
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g8\" name=\"check_g8\" value=\"on\" type=\"checkbox\" checked /><label for=\"check_g8\"><font color=\"#8BDABA\">G8&nbsp;</font></label>\n";
			else
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g8\" name=\"check_g8\" value=\"on\" type=\"checkbox\" /><label for=\"check_g8\"><font color=\"#EDC76D\">G8&nbsp;</font></label>\n";
				
			if ($check_g9 == "on")
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g9\" name=\"check_g9\" value=\"on\" type=\"checkbox\" checked /><label for=\"check_g9\"><font color=\"#8BDABA\">G9&nbsp;</font></label>\n";
			else
				echo "<input style=\"position:relative;bottom:-4px;\" id=\"check_g9\" name=\"check_g9\" value=\"on\" type=\"checkbox\" /><label for=\"check_g9\"><font color=\"#EDC76D\">G9&nbsp;</font></label>\n";
			
			echo "<a href=\"#\" onclick=\"missiles_checkbox_on()\"style=\"text-decoration:none;\"><font color=\"#8BDABA\">&nbsp;Toutes</font></a>/<a href=\"#\" onclick=\"missiles_checkbox_off()\"style=\"text-decoration:none;\"><font color=\"#EDC76D\">Aucune&nbsp;</font></a>\n";
			
			?>
			</th>
		</tr>			
		
		<tr>
			<th colspan="3"><input type="submit" value="Chercher"></th>
		</tr>
		</form>
		</table>
		<br />

<?php


/* La requête suivante récupére le niveau de la technologie impulsion et en déduit la porte
 * -----------------------------------------------------------------------------------------
 * sortie : t_user_id_lib[] contient le libelle du joueur en fonction de son ID
 *				: t_user_id_portee[] contient la portee du joueur en fonction de son ID
 */ 
$req = "SELECT u.user_name AS user_name, u.user_id AS user_id, t.RI AS RI FROM ".$table_prefix."user_technology t, ".$table_prefix."user u where t.user_id = u.user_id";
$result = $db->sql_query($req);
while ($data = $db->sql_fetch_assoc($result)) 
{
	if ($data["RI"]!=Null)
	{
		$t_user_id_lib[$data['user_id']] 		= $data['user_name'];
		$t_user_id_portee[$data['user_id']]	= (2*$data["RI"])-1;
	}
}


/* La requête suivante extrait le niveau des silo de missile, et si le niveau est supérieur 
 * a 4 liste les système pouvant être touchés
 * -----------------------------------------------------------------------------------------
 * sortie : $t_missiles_galaxies[] contient toutes les informations sur le joueur, sa portée, 
 * 					son niveau, coordonnées, etc..
 *					galaxie|system_du_joueur|portee_system_mini|portee_system_max|id_joueur|libelle_joueur|coordonnee_planete_joueur|portee_des_missiles_du_joueur
 *  
 */
$t_missiles_galaxies = array();

$req = "SELECT * FROM ".TABLE_USER_BUILDING." order by coordinates";
$result = $db->sql_query($req);
while ($data = $db->sql_fetch_assoc($result)) 
{
    if ($data["Silo"]!=Null && $data["Silo"]> 3 && $t_user_id_portee[$data['user_id']] != 0)
    {
			$coord= explode(":", ereg_replace("\\.", ":", $data["coordinates"]));
			$gal=$coord[0];
			$sys=$coord[1];
			$sysmini = $sys - $t_user_id_portee[$data['user_id']];
			if ($sysmini<1)
			{
				$sysmini=1;
			}
			$sysmaxi = $sys + $t_user_id_portee[$data['user_id']];
			if ($sysmaxi>499)
			{
				$sysmaxi=499;
			}
			// Stockage des informations
			$t_missiles_galaxies[] = $gal."|".$sys."|".$sysmini."|".$sysmaxi."|".$data['user_id']."|".$t_user_id_lib[$data['user_id']]."|".$data["coordinates"]."|".$t_user_id_portee[$data['user_id']];
		}
}

/* On génère un tableau distinct pour chaque galaxie
 *--------------------------------------------------
 */
$G1_missile_galaxie = array();$G2_missile_galaxie = array();$G3_missile_galaxie = array();
$G4_missile_galaxie = array();$G5_missile_galaxie = array();$G6_missile_galaxie = array();
$G7_missile_galaxie = array();$G8_missile_galaxie = array();$G9_missile_galaxie = array();
foreach ($t_missiles_galaxies as $missile_galaxie) 
{
	$info	= explode("|", $missile_galaxie);
	switch ($info[0])
	{
		case "1":
			$G1_missile_galaxie[] = $missile_galaxie;
			break;
			
		case "2":
			$G2_missile_galaxie[] = $missile_galaxie;
			break;
			
		case "3":
			$G3_missile_galaxie[] = $missile_galaxie;
			break;
			
		case "4":
			$G4_missile_galaxie[] = $missile_galaxie;
			break;
			
		case "5":
			$G5_missile_galaxie[] = $missile_galaxie;
			break;
			
		case "6":
			$G6_missile_galaxie[] = $missile_galaxie;
			break;
			
		case "7":
			$G7_missile_galaxie[] = $missile_galaxie;
			break;
			
		case "8":
			$G8_missile_galaxie[] = $missile_galaxie;
			break;	
																							
		case "9":
			$G9_missile_galaxie[] = $missile_galaxie;
			break;
	}
}


/* Recherche d'une cible potentielle
 *------------------------------------------------------------------------------------------------
 * sortie : $Gx_ennemi[] contient les informations trouvées par galaxie sur la cible sélectionnée.
 * 				  galaxie|system|planete|libelle_planete|tag_alliance|libelle_joueur|status_joueur
 */
$G1_ennemi = array();$G2_ennemi = array();$G3_ennemi = array();
$G4_ennemi = array();$G5_ennemi = array();$G6_ennemi = array();
$G7_ennemi = array();$G8_ennemi = array();$G9_ennemi = array();

// Génération de la requête pour la recherche
if ($pub_action == "missiles")
{
	// Les chaînes de saisie sont vide, donc on ne fait rien
	if (!empty($string_search) || !empty($string_search1) || !empty($string_search2))
	{
		$req = "SELECT * FROM ".$table_prefix."universe WHERE ";
		
		if (isset($strict))
		{
			switch ($strict)
			{
				case true:
					$operateur2test = "= '";
				break;
				
				case false:
					$operateur2test = "like '%";
				break;
				
				default:
					$operateur2test = "= '";
				break;
			}
		}
				
		if (isset($type_search)) 
		{
			switch ($type_search) 
			{
				case "player":
					if (!empty($string_search))
						$req .= "`player` ".$operateur2test.$string_search.(($operateur2test == "= '")?"'":"%'");				
					
					if (!empty($string_search1) && !empty($string_search))
						$req .= " OR `player` ".$operateur2test.$string_search1.(($operateur2test == "= '")?"'":"%'");
					
					if (!empty($string_search1) && empty($string_search))
						$req .= "`player` ".$operateur2test.$string_search1.(($operateur2test == "= '")?"'":"%'");						
					
					if (!empty($string_search2) && (!empty($string_search1) || !empty($string_search)))
						$req .= " OR `player` ".$operateur2test.$string_search2.(($operateur2test == "= '")?"'":"%'");
					
					if (!empty($string_search2) && empty($string_search1) && empty($string_search))
						$req .= "`player` ".$operateur2test.$string_search2.(($operateur2test == "= '")?"'":"%'");
				break;
				
				case "ally":
					if (!empty($string_search))
						$req .= "`ally` ".$operateur2test.$string_search.(($operateur2test == "= '")?"'":"%'");				
					
					if (!empty($string_search1) && !empty($string_search))
						$req .= " OR `ally` ".$operateur2test.$string_search1.(($operateur2test == "= '")?"'":"%'");
					
					if (!empty($string_search1) && empty($string_search))
						$req .= "`ally` ".$operateur2test.$string_search1.(($operateur2test == "= '")?"'":"%'");						
					
					if (!empty($string_search2) && (!empty($string_search1) || !empty($string_search)))
						$req .= " OR `ally` ".$operateur2test.$string_search2.(($operateur2test == "= '")?"'":"%'");
					
					if (!empty($string_search2) && empty($string_search1) && empty($string_search))
						$req .= "`ally` ".$operateur2test.$string_search2.(($operateur2test == "= '")?"'":"%'");
				break;
				
				case "planet":
					if (!empty($string_search))
						$req .= "`name` ".$operateur2test.$string_search.(($operateur2test == "= '")?"'":"%'");				
					
					if (!empty($string_search1) && !empty($string_search))
						$req .= " OR `name` ".$operateur2test.$string_search1.(($operateur2test == "= '")?"'":"%'");
					
					if (!empty($string_search1) && empty($string_search))
						$req .= "`name` ".$operateur2test.$string_search1.(($operateur2test == "= '")?"'":"%'");						
					
					if (!empty($string_search2) && (!empty($string_search1) || !empty($string_search)))
						$req .= " OR `name` ".$operateur2test.$string_search2.(($operateur2test == "= '")?"'":"%'");
					
					if (!empty($string_search2) && empty($string_search1) && empty($string_search))
						$req .= "`name` ".$operateur2test.$string_search2.(($operateur2test == "= '")?"'":"%'");
				break;
			}
		}
		
		// Exécution
		$result = $db->sql_query($req);
		while ($data = $db->sql_fetch_assoc($result)) 
		{
				if ($data['galaxy']== 1 )
					$G1_ennemi[] = $data['galaxy']."|".$data['system']."|".$data['row']."|".$data['name']."|".$data['ally']."|".$data['player']."|".$data['status'];
					
				if ($data['galaxy']== 2 )
					$G2_ennemi[] = $data['galaxy']."|".$data['system']."|".$data['row']."|".$data['name']."|".$data['ally']."|".$data['player']."|".$data['status'];
					
				if ($data['galaxy']== 3 )
					$G3_ennemi[] = $data['galaxy']."|".$data['system']."|".$data['row']."|".$data['name']."|".$data['ally']."|".$data['player']."|".$data['status'];
					
				if ($data['galaxy']== 4 )
					$G4_ennemi[] = $data['galaxy']."|".$data['system']."|".$data['row']."|".$data['name']."|".$data['ally']."|".$data['player']."|".$data['status'];
					
				if ($data['galaxy']== 5 )
					$G5_ennemi[] = $data['galaxy']."|".$data['system']."|".$data['row']."|".$data['name']."|".$data['ally']."|".$data['player']."|".$data['status'];
					
				if ($data['galaxy']== 6 )
					$G6_ennemi[] = $data['galaxy']."|".$data['system']."|".$data['row']."|".$data['name']."|".$data['ally']."|".$data['player']."|".$data['status'];
					
				if ($data['galaxy']== 7 )
					$G7_ennemi[] = $data['galaxy']."|".$data['system']."|".$data['row']."|".$data['name']."|".$data['ally']."|".$data['player']."|".$data['status'];
					
				if ($data['galaxy']== 8 )
					$G8_ennemi[] = $data['galaxy']."|".$data['system']."|".$data['row']."|".$data['name']."|".$data['ally']."|".$data['player']."|".$data['status'];
					
				if ($data['galaxy']== 9 )
					$G9_ennemi[] = $data['galaxy']."|".$data['system']."|".$data['row']."|".$data['name']."|".$data['ally']."|".$data['player']."|".$data['status'];															
		}
	}
}

/* Pour simplifier les traitements annexes, on créer un tableau de 499 cases pour chaque galaxie
 * ---------------------------------------------------------------------------------------------
 */
$G1 = array_fill(0, 498, array_fill(0,2,''));
$G2 = array_fill(0, 498, array_fill(0,2,''));
$G3 = array_fill(0, 498, array_fill(0,2,''));
$G4 = array_fill(0, 498, array_fill(0,2,''));
$G5 = array_fill(0, 498, array_fill(0,2,''));
$G6 = array_fill(0, 498, array_fill(0,2,''));
$G7 = array_fill(0, 498, array_fill(0,2,''));
$G8 = array_fill(0, 498, array_fill(0,2,''));
$G9 = array_fill(0, 498, array_fill(0,2,''));
	
/* Les tableaux ci dessous permettent de générer des tooltips pour chaque coordonnées
 * ----------------------------------------------------------------------------------
 */	
$G1_tooltips = array();$G2_tooltips = array();$G3_tooltips = array();
$G4_tooltips = array();$G5_tooltips = array();$G7_tooltips = array();
$G8_tooltips = array();$G9_tooltips = array();$G10_tooltips = array();

/* Les tableaux ci dessous contiennent les cibles que personne ne peut missiler
 * ----------------------------------------------------------------------------------
 */	
$G1_ennemi_non_touches = array();$G2_ennemi_non_touches = array();$G3_ennemi_non_touches = array();
$G4_ennemi_non_touches = array();$G5_ennemi_non_touches = array();$G6_ennemi_non_touches = array();
$G7_ennemi_non_touches = array();$G8_ennemi_non_touches = array();$G9_ennemi_non_touches = array();

/* Hop, on attaque le plus gros du boulot
 * - mise à jour des tableaux Gx[] en fonction des tableaux $Gx_missile_galaxie[]
 * ----------------------------------------------------------------------------------
 */	
 
$nbr_system = 9;
// Au dernières nouvelles, il y a 9 system ^^
for ($i=1 ; $i <= $nbr_system; $i++)
{	
	//Cette galaxie fait partie de notre sélection ou pas.
	if (${"check_g".$i} == "on")
	{
		// On repère sur les 499 systeme lequel peu être attaquer par un missile.
		// Pour résumer, position du tableau vide donc rien, non vide quelqu'un peu attaquer ce system.
		foreach (${"G".$i."_missile_galaxie"} as $galaxie)
		{	
			//   0          1                 2              3                  4         5                 6                       7	
			//galaxie|system_du_joueur|portee_system_mini|portee_system_max|id_joueur|libelle_joueur|coordonnee_planete_joueur|portee_des_missiles_du_joueur
			$info								= explode("|", $galaxie);
			$coordonnee_joueur	= $info[6];	
			$lib_joueur 				= $info[5];	
			$sysmaxi 						= $info[3];
			$sysmini 						= $info[2];
			$positionjoueur		 	= $info[1];
			$gal								= $info[0];
			
			// Init de la variable de test
			$t_pos_joueur = array();
			for ($pos = $sysmini; $pos <= $sysmaxi; $pos++)
			{
				// Génération du tooltips affichant le nom des joueurs pouvant toucher cette position		
				if (empty(${"G".$i}[$pos][0]))
				{
					// Premier passage, on génère l'entete du tooltips
					${"G".$i."_tooltips"}[$pos] = "<tr><td class=\'c\' align=\'center\'>".$gal.":".$pos.":1 - ".$gal.":".$pos.":15</td></tr>";
				}	
						
				// On ajout le nom du joueur dans le tooltips
				if (in_array ($gal.$pos.$lib_joueur, $t_pos_joueur,TRUE) == FALSE)
				{
					${"G".$i."_tooltips"}[$pos] .= "<tr><th>".$lib_joueur."</th></tr>";
					// Sert seulement à ne pas affecter plusieurs fois le même nom pour la même coordonnée
					$t_pos_joueur[] = $gal.$pos.$lib_joueur;
				}
				
				// Sur notre tableau à 499 cases on identifie quelle position peu être touchée
				// index 0 : [][][][239][240][241][242][243][344][345][][][][][][][][]
				// index 1 : [][][]  []   []  []  [zhym][]   []  []  [][][][][][][][]
				${"G".$i}[$pos][0] = $pos;  // index 0
				if ($positionjoueur == $pos)
				{
					${"G".$i}[$pos][1] = $lib_joueur."<br />".$coordonnee_joueur; // index 1
				}		
			}
		}
		
		// On récupere les victimes que personnes n'arrivent a toucher dans cette galaxie
		$ennemi_affichage		= "";
		$ennemi_coordonnee	= "";
		$ennemi_tooltips 		= "";		
		foreach (${"G".$i."_ennemi"} as $ennemi) 
		{
			//0         1       2      3              4            5               6
			//galaxie|system|planete|libelle_planete|tag_alliance|libelle_joueur|status_joueur
			$info_ennemi = explode("|", $ennemi);	
			$affichage_emmemi_non_touche	= 1;
			$ennemi_affichage		= "";
			$ennemi_coordonnee	= "";
			$ennemi_tooltips 		= "";
			
			foreach (${"G".$i} as $position_system_globale) 
			{
				list( $position_system , $joueur) = $position_system_globale;		
				// Vérification des coordonnées, si vide alors aucun joueur ne peu attaquer ces coordonnées
				if ($position_system != "")
				{	
					if ($info_ennemi[1] == $position_system)
					{
						$affichage_emmemi_non_touche = 0;
					}							
				}
			}
			if ($affichage_emmemi_non_touche == 1)
			{			
				// Mise en place d'un tooltips pour les ennemis
				$ennemi_tooltips .= "<table width=\'100%\'>";
				$ennemi_tooltips .= "<tr><td class=\'c\' align=\'center\'>Joueur\t: ".$info_ennemi[5]."</td></tr>";
				$ennemi_tooltips .= "<tr><th align=\'center\'>Planète\t: ".$info_ennemi[3]."<br />";
				$ennemi_tooltips .= "Tag Alliance\t: ".$info_ennemi[4]."<br />";
				$ennemi_tooltips .= "Localisation\t: ".$info_ennemi[0].":".$info_ennemi[1].":".$info_ennemi[2]."<br />";
				$ennemi_tooltips .= "Status\t: ".$info_ennemi[6]."</th></tr>";				
				$ennemi_tooltips .= "</table>";
				$ennemi_tooltips .= get_stats_joueur($info_ennemi[5]);
					
				$ennemi_coordonnee = $info_ennemi[0].":".$info_ennemi[1].":".$info_ennemi[2];
			}
			if (!empty($ennemi_tooltips))
			{
				$ennemi_tooltips  = htmlentities($ennemi_tooltips);
				$out_ennemi_tooltips = " onmouseover=\"this.T_WIDTH=210;this.T_TEMP=15000;return escape('".$ennemi_tooltips."')\"";
				$ennemi_affichage = "<a style='cursor:pointer'".$out_ennemi_tooltips."><font color=\"#FF5555\">".$ennemi_coordonnee."</font></a><br/>";
				
				${"G".$i."_ennemi_non_touches"}[] = "<th width='50' align='center'>".$ennemi_affichage."</th>\n";
			}	
		}
		
		$tmp_array = array();	
		$tmp_array = array_filter(${"G".$i."_ennemi_non_touches"});
		if ( !empty($tmp_array ))
		{
			// cette variable indique le nombre MAX de colonne pour l'affichage de sortie
			$coupure 	= 0;		
			echo "<table width='700' border='1'>\n";
			echo "<tr><td class='c' colspan='10' align='center'>Cibles non touchées en G".$i."</td></tr>\n";
			echo "<tr height='30'>\n";
			foreach (${"G".$i."_ennemi_non_touches"} as $ennemi_non_touches)
			{
				// Mise en page, on génère un tableau de 10 colones MAX
				$coupure++;	
				if ($coupure > 10)
				{
					echo "</tr><tr height='30'>\n";
					$coupure = 1;
				}			
				print($ennemi_non_touches);
			}
			echo "</tr></table><br />\n";
		}
				
		
		// Affichage de la galaxie avec les portées des membres de l'alliance ainsi que les cibles potentielles
		$affichage_sortie 		= 0;			// sert pour savoir si on génére un tableau en sortie ou non
		$coupure 							= 0;			// cette variable indique le nombre MAX de colonne pour l'affichage de sortie
		$old_position_system	= "999";	// variable référence pour savoir si on a une coupure entre 2 portée de missiles
		
		foreach (${"G".$i} as $position_system_globale) 
		{
			list( $position_system , $joueur) = $position_system_globale;
			
			// Vérification des coordonnées, si vide alors aucun joueur ne peu attaquer ces coordonnées
			if ($position_system != "")
			{
				// on a bien quelque chose a afficher donc on affiche l entete du tableau
				if ($affichage_sortie < 1)
				{
						echo "<table width='700' border='1'>\n";
						echo "<tr><td class='c' colspan='10' align='center'>G".$i."</td></tr>\n";
						echo "<tr height='30'>\n";
						$affichage_sortie++;
				}
				
				// Mise en page, on génère un tableau de 10 colones MAX
				$coupure++;	
				if ($coupure > 10)
				{
					echo "</tr><tr height='30'>\n";
					$coupure = 1;
				}
				// Génération d'un séparation entre 2 portées
				if ( $old_position_system != ($position_system-1)) // en gros 300 est il la suite de 230+1 (super l'explication, non :) )
				{
					echo "<td class='c' width='50' align='center'>&nbsp;</td>\n";
					$coupure++;
				}	
				// 2ème test de coupure car on a pu générer un espace juste avant
				if ($coupure > 10)
				{
					echo "</tr><tr height='30'>\n";
					$coupure = 1;
				}		
				
				// Mise en place d'un tooltips
				$tooltips  = "<table width=\'100%\'>";
				$tooltips .= ${"G".$i."_tooltips"}[$position_system];
				$tooltips .= "</table>";
				$tooltips  = htmlentities($tooltips);
				$out_tooltips = " onmouseover=\"this.T_WIDTH=210;this.T_TEMP=15000;return escape('".$tooltips."')\"";
				
				// Cet partie sert seulement à afficher le nom du joueur sur la planète qui peut tirer des missiles
				// ou seulement les coordonnes si aucun jouer ne possede cette planète
				$info_position_system = $i.":".$position_system; // coordonnée du system
				// On test si un joueur a sa planète dans ce system
				if ($joueur != "")
				{
					$info_position_system = "<font color=\"#8BDABA\">".$joueur."</font><br />"; // on remplace par les infos du joueur
				}
				
				// Cet partie sert à afficher le nom de la cible recherchée
				$ennemi_affichage		= "";
				$ennemi_coordonnee	= "";
				$ennemi_tooltips 		= "";
				foreach (${"G".$i."_ennemi"} as $ennemi) 
				{
					//0         1       2      3              4            5               6
					//galaxie|system|planete|libelle_planete|tag_alliance|libelle_joueur|status_joueur
					$info_ennemi = explode("|", $ennemi);
					if ($info_ennemi[1] == $position_system)
					{
						// Mise en place d'un tooltips pour les ennemis
						$ennemi_tooltips .= "<table width=\'100%\'>";
						$ennemi_tooltips .= "<tr><td class=\'c\' align=\'center\'>Joueur\t: ".$info_ennemi[5]."</td></tr>";
						$ennemi_tooltips .= "<tr><th align=\'center\'>Planète\t: ".$info_ennemi[3]."<br />";
						$ennemi_tooltips .= "Tag Alliance\t: ".$info_ennemi[4]."<br />";
						$ennemi_tooltips .= "Localisation\t: ".$info_ennemi[0].":".$info_ennemi[1].":".$info_ennemi[2]."<br />";
						$ennemi_tooltips .= "Status\t: ".$info_ennemi[6]."</th></tr>";
						$ennemi_tooltips .= "</table>";
						$ennemi_tooltips .= get_stats_joueur($info_ennemi[5]);
						
						$ennemi_coordonnee = $info_ennemi[0].":".$info_ennemi[1].":".$info_ennemi[2];
					}
				}		
				if (!empty($ennemi_tooltips))
				{
					$ennemi_tooltips  = htmlentities($ennemi_tooltips);
					$out_ennemi_tooltips = " onmouseover=\"this.T_WIDTH=210;this.T_TEMP=15000;return escape('".$ennemi_tooltips."')\"";
					$ennemi_affichage = "<br /><a style='cursor:pointer'".$out_ennemi_tooltips."><font color=\"#FF5555\">".$ennemi_coordonnee."</font></a><br/> \n";
				}
				
				// Affichage du system
				echo "<th width='50' align='center'>".$ennemi_affichage."<a style='cursor:pointer'".$out_tooltips.">".$info_position_system."</a></th>\n";
			
				$old_position_system = $position_system;
			}
		}
		// test si on a générer un tableau de sortie.
		if ($affichage_sortie > 0)
		{
			echo "</tr></table>\n";
			echo "<br />\n";
		}
	}
}
?>