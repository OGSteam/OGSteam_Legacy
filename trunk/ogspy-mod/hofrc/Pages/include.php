<?php
/**
 * include.php 
 * @package HofRC
 * @author Shad
 * @link http://www.ogsteam.fr
 * @version : 0.0.1
 */


// L'appel direct est interdit....
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Définitions
global $db, $table_prefix, $prefixe;
//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='hofrc' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

/**************************************************************************/
// Fonction pour traiter le post de configuration de l'historique
	function set_historique($font_historique, $font_size, $largeur_historique, $hauteur_historique, $pos_horiz_historique_1, $pos_horiz_historique_2, $pos_horiz_historique_3, $pos_horiz_historique_4, $pos_horiz_historique_5, $color_txt_historique_1, $color_txt_historique_2, $color_txt_historique_3, $color_txt_historique_4, $color_txt_historique_5, $pos_verti_historique, $angle_historique)
		{
			global $db, $table_prefix;
			define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$font_historique."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'font_historique'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$font_size."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'font_size_historique'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$largeur_historique."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'largeur_historique'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$hauteur_historique."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'hauteur_historique'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$pos_horiz_historique_1."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'pos_horiz_historique_1'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$pos_horiz_historique_2."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'pos_horiz_historique_2'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$pos_horiz_historique_3."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'pos_horiz_historique_3'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$pos_horiz_historique_4."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'pos_horiz_historique_4'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$pos_horiz_historique_5."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'pos_horiz_historique_5'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$color_txt_historique_1."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'color_txt_historique_1'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$color_txt_historique_2."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'color_txt_historique_2'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$color_txt_historique_3."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'color_txt_historique_3'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$color_txt_historique_4."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'color_txt_historique_4'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$color_txt_historique_5."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'color_txt_historique_5'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$pos_verti_historique."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'pos_verti_historique'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$angle_historique."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'angle_historique'");
		}


/**************************************************************************/
// Fonction pour traiter le post de la configuration de l'univers
	function post_config ($new_start_universe, $config_size_initial, $config_size_courant, $config_size_basic, $config_size_normal, $config_size_avance, $config_size_stratege, $new_end_initial_solo, $new_end_initial_groupe, $new_end_courant_solo, $new_end_courant_groupe, $new_end_basic_solo, $new_end_basic_groupe, $new_end_normal_solo, $new_end_normal_groupe, $new_end_avance_solo, $new_end_avance_groupe, $new_end_stratege_solo, $new_end_stratege_groupe)
		{
			global $db, $table_prefix;
			define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');
			
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_start_universe."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'start_universe'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$config_size_initial."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'size_initial'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$config_size_courant."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'size_courant'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$config_size_basic."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'size_basic'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$config_size_normal."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'size_normal'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$config_size_avance."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'size_avance'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$config_size_stratege."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'size_stratege'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_initial_solo."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_initial_solo'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_initial_groupe."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_initial_groupe'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_courant_solo."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_courant_solo'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_courant_groupe."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_courant_groupe'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_basic_solo."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_basic_solo'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_basic_groupe."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_basic_groupe'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_normal_solo."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_normal_solo'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_normal_groupe."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_normal_groupe'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_avance_solo."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_avance_solo'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_avance_groupe."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_avance_groupe'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_stratege_solo."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_stratege_solo'");
			$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_end_stratege_groupe."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'end_stratege_groupe'");
		}

	

/**************************************************************************/

// Fonction pour afficher texte ou images
	function select_picture($type, $skin, $picture, $historique, $round)
		{
			global $db, $table_prefix;
			define('TABLE_HOFRC_TITLE',$table_prefix.'hofrc_title');
						
			$filename = "mod/hofrc/Skin/".$skin.'/'.$picture;
			$file_historique = "mod/hofrc/Output/historique.php";
			if (file_exists($filename) && $historique == "0")
				{
					if ($type == "preview")
						{
							return "\n\n <img src=".$filename.">\n\n";
						}
					elseif ($type == "bbcode")
						{
							return "[img=".str_replace(' ','%20','http://'.substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],0, strlen($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'])-9)).$filename."][/img]";
						}
				}
			elseif ($historique == "1")
				{	
					if ($type == "bbcode")
						{
							$historique_picture .= "[center][spoiler]";
						}
					$query_historique = $db->sql_query("SELECT * FROM ".TABLE_HOFRC_TITLE);
					while ($historique_title = $db->sql_fetch_assoc($query_historique))
						{
							$picture_title = "mod/hofrc/Output/".$historique_title['id'].".png";
							if (!empty($historique_title['board_url']))
								{
									if ($type == "preview")
										{
											$historique_picture .= "<a href=".$historique_title['board_url']."><img src=".$picture_title."></a><br>";
										}
									elseif ($type == "bbcode")
										{
											$historique_picture .= "[url=".$historique_title['board_url']."][img=".str_replace(' ','%20','http://'.substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],0, strlen($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'])-9)).$picture_title."][/img][/url]<br>";
										}
								}
						}
						if ($type == "bbcode")
							{
								$historique_picture .= "[/spoiler]";
							}
					echo $historique_picture;
				}
			else
				{
					if ($type == "preview")
						{
							return "<img src=".$filename.">";
						}
					elseif ($type == "bbcode")
						{
							return "[img=".$filename."][/img]";
						}
				}
		}

/**************************************************************************/

// Fonction servant a sélectionner le skin ou le changer dans la configuration
	function select_skin ($value)
		{
			global $db, $table_prefix;
			define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');
			if ($value === 0)
				{ 
					$query_skin = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'hofrc_skin'");
					list($skin) = $db->sql_fetch_row($query_skin); 
					return $skin;
				}
			else
				{
					$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$value."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'hofrc_skin'");
				}
		}	

/**************************************************************************/

// Function pour creer un nouveau skin
	function new_skin ($new_skin)
			{
				global $db, $table_prefix;
				define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');
				define('TABLE_HOFRC_SKIN',$table_prefix.'hofrc_skin');
				$folder = "mod/hofrc/Skin/".$new_skin;
				if (!file_exists($folder))
					{
						mkdir($folder, 0777);			
						$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$new_skin."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'hofrc_skin'");	
						$db->sql_query("INSERT INTO `".TABLE_HOFRC_SKIN."` (`title`) VALUES('".$new_skin."')");				
					}
				else
					{
						echo "Un dossier ".$new_skin." existe déjà.";
					}
			}

/**************************************************************************/

// Function pour formater le RC
	function format_number($color_min,$color_max,$ressource,$quota,$type)
		{
			if ($type == "preview")
				{
					if ($ressource < $quota)
						{
							return "<span style='color:".$color_min.";'>".number_format($ressource,0,',','.')."</span>";
						}
					else
						{
							return "<span style='color:".$color_max.";'>".number_format($ressource,0,',','.')."</span>";
						}
				}
			elseif ($type == "bbcode")
				{
					if ($ressource < $quota)
						{
							return "[color=".$color_min."]".number_format($ressource,0,',','.');
						}
					else
						{
							return "[color=".$color_max."]".number_format($ressource,0,',','.');
						}
				}
		}

/**************************************************************************/

// Fonction pour avoir des infobulle
	function infobulle($txt_contenu, $titre = 'Aide', $largeur = 200) {
		// vérification de $largeur
		if (!is_numeric($largeur))
			$largeur = 200;

		$infobulle = '<img style="cursor: pointer;" title="" alt="tooltip" src="images/help_2.png" onMouseOver="this.T_WIDTH=210;this.T_TEMP=0;return escape(\'<table width=&quot;'
		.$largeur.'&quot;><tr><td align=&quot;center&quot; class=&quot;c&quot;>'
		.jsspecialchars($titre).'</td></tr><tr><th align=&quot;center&quot;>'.jsspecialchars($txt_contenu).'</th></tr></table>\')">';
		// retourne l'infobulle
		return $infobulle;
}

/**************************************************************************/

// Fonction en attente
/**
 * Escapes strings to be included in javascript
 *
 * @param string $s
 * @return string
 */
function jsspecialchars($s) {
	// ajout de ce petit replace car le masque ne prend pas correctement le double quote...
	$s = str_replace('"','&quot;',$s);

	return preg_replace('/([^ !#$%@()*+,-.\x30-\x5b\x5d-\x7e])/e',
		"'\\x'.(ord('\\1')<16? '0': '').dechex(ord('\\1'))",$s);
}

/**************************************************************************/

// La function pour convertir le rc
	function convert($id_RC,$type,$hof,$pillage)
		{
			global $db,$table_prefix;
			define('TABLE_HOFRC_SKIN',$table_prefix.'hofrc_skin');
			// On définie le skin
			$skin = select_skin(0);
		
			// On récupère la configuration par défaut
			$query_RCcolor = $db->sql_query("SELECT pt, gt, cle, clo, cr, vb, vc, rec, se, bmd, dst, edlm, tra, sat, lm, lleger, llourd, cg, ai, lp, pb, gb, player_att, player_def, ally, techno, detruit, ressources_piller_min, ressources_piller_max, pertes_fleet_def, seuil_pertes, seuil_pillage, seuil_cdr, pertes_min_att, pertes_max_att, pertes_min_def, pertes_max_def, debris_min, debris_max, renta_min, renta_max, pic_header , pic_round, pic_separator, pic_result, pic_background FROM ".TABLE_HOFRC_SKIN." WHERE title = CONVERT( _utf8 '".$skin."' USING latin1 )");
			list($color_PT, $color_GT, $color_CLE, $color_CLO, $color_CR, $color_VB, $color_VC, $color_REC, $color_SE, $color_BMD, $color_DST, $color_EDLM, $color_TRA, $color_SAT, $color_LM, $color_LLEGER, $color_LLOURD, $color_CG, $color_AI, $color_LP, $color_PB, $color_GB, $color_PLAYER_ATT, $color_PLAYER_DEF, $color_ALLY, $color_TECHNO, $color_DETRUIT, $color_RESSOURCES_PILLER_MIN, $color_RESSOURCES_PILLER_MAX, $color_PERTES_FLEET_DEF, $color_SEUIL_PERTES, $color_SEUIL_PILLAGE, $color_SEUIL_CDR,$color_PERTES_MIN_ATT, $color_PERTES_MAX_ATT, $color_PERTES_MIN_DEF, $color_PERTES_MAX_DEF, $color_DEBRIS_MIN, $color_DEBRIS_MAX, $color_RENTA_MIN, $color_RENTA_MAX, $color_PIC_HEADER , $color_PIC_ROUND, $color_PIC_SEPARATOR, $color_PIC_RESULT, $color_PIC_BACKGROUND) = $db->sql_fetch_row($query_RCcolor);
				
			$query_RCRound = $db->sql_query("SELECT id_rcround FROM ".TABLE_PARSEDRCROUND." WHERE id_rc=".$id_RC." AND numround=1");
			list($id_rcround) = $db->sql_fetch_row($query_RCRound);
		
			// On choisis si c'est pour visualiser le RC ou pour le convertir en BBCode
			if ($type == "preview")
				{
					$color_pertes_min_att = $color_PERTES_MIN_ATT;
					$color_pertes_max_att = $color_PERTES_MAX_ATT;
					$color_pertes_min_def = $color_PERTES_MIN_DEF;
					$color_pertes_max_def = $color_PERTES_MAX_DEF;
					$color_debris_min = $color_DEBRIS_MIN;
					$color_debris_max = $color_DEBRIS_MAX; 
					$color_renta_min = $color_RENTA_MIN;
					$color_renta_max = $color_RENTA_MAX;
					$color_seuil_pertes = $color_SEUIL_PERTES;
					$color_seuil_pillage = $color_SEUIL_PILLAGE;
					$color_seuil_cdr = $color_SEUIL_CDR;
					$color_ressources_piller_min = $color_RESSOURCES_PILLER_MIN;
					$color_ressources_piller_max = $color_RESSOURCES_PILLER_MAX;
					$color_perte_fleet_def = "<span style='color:".$color_PERTES_FLEET_DEF."'>";
					$color_detruit = "<span style='color:".$color_DETRUIT."'>";
					$color_player_att = "<span style='color:".$color_PLAYER_ATT."'>";
					$color_player_def = "<span style='color:".$color_PLAYER_DEF."'>";
					$color_alliance = "<span style='color:".$color_ALLY."'>";
					$color_techno = "<span style='color:".$color_TECHNO."'>";
					$color_bal = "</span>";
					$key_ships = array('PT' => "<span style='color:".$color_PT."'>P.transp.", 'GT' => "<span style='color:".$color_GT."'>G.transp.", 'CLE' => "<span style='color:".$color_CLE."'>Ch.léger", 'CLO' => "<span style='color:".$color_CLO."'>Ch.lourd", 'CR' => "<span style='color:".$color_CR."'>Croiseur", 'VB' => "<span style='color:".$color_VB."'>V.bataille", 'VC' => "<span style='color:".$color_VC."'>V.colonisation", 'REC' => "<span style='color:".$color_REC."'>Recycleur", 'SE' => "<span style='color:".$color_SE."'>Sonde", 'BMD' => "<span style='color:".$color_BMD."'>Bombardier", 'DST' => "<span style='color:".$color_DST."'>Destr.", 'EDLM' => "<span style='color:".$color_EDLM."'>Rip", 'TRA' => "<span style='color:".$color_TRA."'>Traqueur");
					$key_defs = array( 'SAT' => "<span style='color:".$color_SAT."'>Sat.sol.",'LM' => "<span style='color:".$color_LM."'>Missile", 'LLE' => "<span style='color:".$color_LLEGER."'>L.léger.", 'LLO' => "<span style='color:".$color_LLOURD."'>L.lourd", 'CG' => "<span style='color:".$color_CG."'>Can.Gauss", 'AI' => "<span style='color:".$color_AI."'>Art.ions", 'LP' => "<span style='color:".$color_LP."'>Lanc.plasma", 'PB' => "<span style='color:".$color_PB."'>P.bouclier", 'GB' => "<span style='color:".$color_GB."'>G.bouclier");
				}
			elseif ($type == "bbcode")
				{
					$color_pertes_min_att = $color_PERTES_MIN_ATT;
					$color_pertes_max_att = $color_PERTES_MAX_ATT;
					$color_pertes_min_def = $color_PERTES_MIN_DEF;
					$color_pertes_max_def = $color_PERTES_MAX_DEF;
					$color_debris_min = $color_DEBRIS_MIN;
					$color_debris_max = $color_DEBRIS_MAX; 
					$color_renta_min = $color_RENTA_MIN;
					$color_renta_max = $color_RENTA_MAX;
					$color_seuil_pertes = $color_SEUIL_PERTES;
					$color_seuil_pillage = $color_SEUIL_PILLAGE;
					$color_seuil_cdr = $color_SEUIL_CDR;
					$color_ressources_piller_min = $color_RESSOURCES_PILLER_MIN;
					$color_ressources_piller_max = $color_RESSOURCES_PILLER_MAX;
					$color_perte_fleet_def = "[color=".$color_PERTES_FLEET_DEF."]";
					$color_detruit = "[color=".$color_DETRUIT."]";
					$color_player_att = "[color=".$color_PLAYER_ATT."]";
					$color_player_def = "[color=".$color_PLAYER_DEF."]";
					$color_alliance = "[color=".$color_ALLY."]";
					$color_techno = "[color=".$color_TECHNO."]";
					$color_bal = "[/color]";
					$key_ships = array('PT' => "[color=".$color_PT."]P.transp.", 'GT' => "[color=".$color_GT."]G.transp.", 'CLE' => "[color=".$color_CLE."]Ch.léger", 'CLO' => "[color=".$color_CLO."]Ch.lourd", 'CR' => "[color=".$color_CR."]Croiseur", 'VB' => "[color=".$color_VB."]V.bataille", 'VC' => "[color=".$color_VC."]V.colonisation", 'REC' => "[color=".$color_REC."]Recycleur", 'SE' => "[color=".$color_SE."]Sonde", 'BMD' => "[color=".$color_BMD."]Bombardier", 'DST' => "[color=".$color_DST."]Destr.", 'EDLM' => "[color=".$color_EDLM."]Rip", 'TRA' => "[color=".$color_TRA."]Traqueur");
					$key_defs = array( 'SAT' => "[color=".$color_SAT."]Sat.sol.",'LM' => "[color=".$color_LM."]Missile", 'LLE' => "[color=".$color_LLEGER."]L.léger.", 'LLO' => "[color=".$color_LLOURD."]L.lourd", 'CG' => "[color=".$color_CG."]Can.Gauss", 'AI' => "[color=".$color_AI."]Art.ions", 'LP' => "[color=".$color_LP."]Lanc.plasma", 'PB' => "[color=".$color_PB."]P.bouclier", 'GB' => "[color=".$color_GB."]G.bouclier");
				}
		
			// On récupère les informations générales du RC
			$query_RC = $db->sql_query("SELECT dateRC, coordinates, nb_rounds, victoire, pertes_A, pertes_D, gain_M, gain_C, gain_D, debris_M, debris_C, lune FROM ".TABLE_PARSEDRC." WHERE id_rc = ".$id_RC);
			list($dateRC, $coordinates, $nb_rounds, $victoire, $pertes_A, $pertes_D, $gain_M,$gain_C, $gain_D, $debris_M, $debris_C, $lune) = $db->sql_fetch_row($query_RC);
			$dateRC = date('d.m.Y H:i:s', $dateRC);
			
			// Début du la variable de concaténation
			// Si hof on affiche l'historique
			if ($hof == "1")
				{
			$template .= select_picture($type, $skin, $color_PIC_HEADER, "1", "")."\n";
				}
			
			
			$template .= select_picture($type, $skin, $color_PIC_HEADER, "0", "")."\n";
			if ($type == "bbcode")
				{
					$template.= "\n"."[color=#ffffff]";
				}			
			$template .= 'Les flottes suivantes se sont affrontées le: '.$dateRC."\n";

			
			
			
			// On récupère la flotte attaquante du premier round
			$query_round_attack_first = $db->sql_query("SELECT player, coordinates, Armes, Bouclier, Protection, SUM(PT), SUM(GT), SUM(CLE), SUM(CLO), SUM(CR), SUM(VB), SUM(VC), SUM(REC), SUM(SE), SUM(BMD), SUM(DST), SUM(EDLM), SUM(TRA) FROM ".TABLE_ROUND_ATTACK." WHERE id_rcround=".$id_rcround." GROUP BY player");
			WHILE (list($player_att, $coordinates_att, $Armes_att, $Bouclier_att, $Protection_att, $PT, $GT, $CLE, $CLO, $CR, $VB, $VC, $REC, $SE, $BMD, $DST, $EDLM, $TRA) = $db->sql_fetch_row($query_round_attack_first))
				{
					// On récupère les alliances des attaquants
					$query_ally_att = $db->sql_query ("SELECT ally FROM ".TABLE_UNIVERSE." WHERE player = '".$player_att."'");
					list($result_ally_att) = $db->sql_fetch_row($query_ally_att);
					if (empty($result_ally_att))
						{
							$ally_att = "NO ALLY";
						}
					else
						{
							$ally_att = $result_ally_att;
						}
					// On récupérère tout les informations coté attaque du premier round
					$key_att_first = '';
					$ship_att_first = 0;
					
					// Variable de concaténation pour les attaquants et techno
					$template .= "\n".'Attaquant '.$color_player_att . $player_att . $color_bal . $color_alliance. ' ['.$ally_att.']'. $color_bal . " \n";
					$template .= 'Armes: '. $color_techno. $Armes_att. ' % '. $color_bal. ' Bouclier: '. $color_techno .$Bouclier_att. ' % '. $color_bal. ' Coque: '. $color_techno. $Protection_att. ' % ' . $color_bal . "\n";
					foreach ($key_ships as $key_att_first => $ship_att_first)
						{
							if (isset($$key_att_first) && $$key_att_first > 0 ) 
								{
									// Variable de concaténation de toute les flottes de la partie attaque
									
									$template .= "\t" . $ship_att_first ." ". number_format($$key_att_first,0,',','.').$color_bal."\n";
								}
						}
		 
				}
				
			// On récupère la flotte défensive du premier round
			$query_round_defense_first = $db->sql_query("SELECT player, coordinates, Armes, Bouclier, Protection, SUM(PT), SUM(GT), SUM(CLE), SUM(CLO), SUM(CR), SUM(VB), SUM(VC), SUM(REC), SUM(SE), SUM(BMD), SAT, SUM(DST), SUM(EDLM), SUM(TRA), LM, LLE, LLO, CG, AI, LP, PB, GB FROM ".TABLE_ROUND_DEFENSE." WHERE id_rcround=".$id_rcround." GROUP BY player");
			WHILE (list($player_def, $coordinates_def, $Armes_def, $Bouclier_def, $Protection_def, $PT, $GT, $CLE, $CLO, $CR, $VB, $VC, $REC, $SE, $BMD, $SAT, $DST, $EDLM, $TRA, $LM, $LLE, $LLO, $CG, $AI, $LP, $PB, $GB) = $db->sql_fetch_row($query_round_defense_first))
				{
					// On récupère les alliances de la défence
					$query_ally_att = $db->sql_query ("SELECT ally FROM ".TABLE_UNIVERSE." WHERE player = '".$player_att."'");
					list($result_ally_att) = $db->sql_fetch_row($query_ally_att);
					if (empty($result_ally_att))
						{
							$ally_def = 'NO ALLY';
						}
					else
						{
							$ally_def = $result_ally_att;
						}
					
					// Variable ce concaténation pour les défenseurs et techno
					$template .= "\n".'Défenseur '. $color_player_def. $player_def. $color_bal. $color_alliance.' ['.$ally_def.']'. $color_bal. "\n";
					$template .=  'Armes: '. $color_techno. $Armes_def.' % '. $color_bal. ' Bouclier: '. $color_techno. $Bouclier_def. ' % '. $color_bal. ' Coque: '. $color_techno. $Protection_def. ' % '. $color_bal. "\n";
				
					$key_def_first = '';
					$ship_def_first = 0;
					$vivant_def_first_round = false;
					foreach ($key_ships as $key_def_first => $ship_def_first) 
						{
							if (isset($$key_def_first) && $$key_def_first > 0) 
								{
									$vivant_def_first_round = true;
									// Variable de concaténation de toute les flottes de la partie défence
									$template .= "\t" . $ship_def_first ." ". number_format($$key_def_first,0,',','.').$color_bal."\n";
								}
						}
					
					foreach ($key_defs as $key_def_first => $def_def_first) 
						{
							if (isset($$key_def_first) && $$key_def_first > 0) 
								{
									$vivant_def_first_round = true;
									// Variable de concaténation de toute les défences du défenceur
									$template .= "\t" . $def_def_first ." ". number_format($$key_def_first,0,',','.').$color_bal."\n";
								}
						}
					if ($vivant_def_first_round == false) 
							{
								// Variable de concaténation si le défenseur détruit
								$template .= $color_detruit . 'Vide' . $color_bal . " \n";
							}
				}
				
			// On détermine le dernier round
			$query_last_RCRound = $db->sql_query("SELECT id_rcround FROM ".TABLE_PARSEDRCROUND." WHERE id_rc=".$id_RC." AND numround=".$nb_rounds);
			list($id_last_rcround_attack) = $db->sql_fetch_row($query_last_RCRound);
			$id_last_rcround=$id_last_rcround_attack;
			$id_last_rcround=$id_rcround+$nb_rounds-1;
		
			
			// Variable de concaténation du nombre de round
			if ($type == "bbcode")
				{
					$template.= "\n\n";
				}
			$template .= select_picture($type, $skin, $color_PIC_ROUND, "0", "\n".'Après '. ($nb_rounds - 1) .' rounds'."\n\n");
			if ($type == "bbcode")
				{
					$template.= "\n\n";
				}

			
			// On récupère les flottes après le combat
				$query_round_attack_last = $db->sql_query("SELECT player, SUM(PT), SUM(GT), SUM(CLE), SUM(CLO), SUM(CR), SUM(VB), SUM(VC), SUM(REC), SUM(SE), SUM(BMD), SUM(DST), SUM(EDLM), SUM(TRA) FROM ".TABLE_ROUND_ATTACK." WHERE id_rcround=".$id_last_rcround." GROUP BY player");
				WHILE (list($player_att,$PT, $GT, $CLE, $CLO, $CR, $VB, $VC, $REC, $SE, $BMD, $DST, $EDLM, $TRA) = $db->sql_fetch_row($query_round_attack_last))
					{
						// Variable de concaténation pour les attaquants
						$template .= "\n".'Attaquant '.$color_player_att . $player_att . $color_bal. "\n";
						
						$key_att_last = '';
						$ship_att_last = 0;
						$vivant_att = false;
					
						foreach ($key_ships as $key_att_last => $ship_att_last) 
							{
								if (isset($$key_att_last) && $$key_att_last > 0) 
									{
										$vivant_att = true;
										$lost_units = lost_unit ($player_att, $$key_att_last, $key_att_last, $id_rcround, "att");
										// Variable de concaténation pour des flottes
										$template .= "\t" . $ship_att_last ." ". number_format($$key_att_last,0,',','.').$color_bal." ".$color_perte_fleet_def.$lost_units.$color_bal."\n";
									}
							}
						// Si la variable revient false il affichera détruit.
						if ($vivant_att == false) 
							{
							// Variable de concaténation si l'attaquant détruit
							$template .= $color_detruit . 'Détruit' . $color_bal . " \n\n";								
							}
					}
				
				// On recupère les flottes de défenses après le combat
				$query_round_defense_last = $db->sql_query("SELECT player, coordinates, Armes, Bouclier, Protection, SUM(PT), SUM(GT), SUM(CLE), SUM(CLO), SUM(CR), SUM(VB), SUM(VC), SUM(REC), SUM(SE), SUM(BMD), SAT, SUM(DST), SUM(EDLM), SUM(TRA), LM, LLE, LLO, CG, AI, LP, PB, GB FROM ".TABLE_ROUND_DEFENSE." WHERE id_rcround=".$id_last_rcround." GROUP BY player");
				WHILE (list($player_def, $coordinates_def, $Armes_def, $Bouclier_def, $Protection_def, $PT, $GT, $CLE, $CLO, $CR, $VB, $VC, $REC, $SE, $BMD, $SAT, $DST, $EDLM, $TRA, $LM, $LLE, $LLO, $CG, $AI, $LP, $PB, $GB) = $db->sql_fetch_row($query_round_defense_last))
					{
						// Variable de concaténation pour les défenseurs
						$template .= "\n".'Défenseur '. $color_player_def. $player_def. $color_bal."\n";
						
						$key_def_last = '';
						$ship_def_last = 0;
						$vivant_def = false;
						
				
						foreach ($key_ships as $key_def_last => $ship_def_last) 
							{
								if (isset($$key_def_last) && $$key_def_last > 0) 
									{
										$vivant_def = true;
										$lost_units = lost_unit ($player_att, $$key_att_last, $key_att_last, $id_rcround, "def");
										// Variable de concaténation pour les flottes des défenseurs
										$template .= "\t" . $ship_def_last ." ". number_format($$key_def_last,0,',','.').$color_bal." ".$color_perte_fleet_def.$lost_units.$color_bal."\n";
									}
							}
						foreach ($key_defs as $key_def_last => $def_def_last) 
							{
								if (isset($$key_def_last) && $$key_def_last > 0) 
									{
										$vivant_def = true;
										
										// Variable de concaténation pour la défense du défenseur
										$template .= "\t" . $def_def_last ." ". number_format($$key_def_last,0,',','.').$color_bal."\n";
									}
							}
							
						if ($vivant_def == false) 
							{
								// Variable de concaténation si le défenseur détruit
								$template .= $color_detruit . 'Détruit' . $color_bal . " \n";
							}
				
				
				}
			
			// Variable de concaténation pour afficher une séparation
			if ($type == "bbcode")
				{
					$template.= "\n\n";
				}
			$template .= select_picture($type, $skin, $color_PIC_SEPARATOR, "0", "");
			if ($type == "bbcode")
				{
					$template.= "\n\n";
				}
			
			if ($victoire == "A")
				{	
					// Variable de concaténation si le défenseur gagne la bataille
					$template .= "\n". 'L\'attaquant a remporter la battaille ! Il emporte '.format_number($color_ressources_piller_min,$color_ressources_piller_max,$gain_M,$color_seuil_pillage,$type).$color_bal.' unités de métal, '.format_number($color_ressources_piller_min,$color_ressources_piller_max,$gain_C,$color_seuil_pillage,$type).$color_bal.' unités de cristal et '.format_number($color_ressources_piller_min,$color_ressources_piller_max,$gain_D,$color_seuil_pillage,$type).$color_bal.' de deutérium.'."\n";
				}
			 elseif ($victoire == "D")
				{
					// Variable de concaténation si le défenseur gagne la bataille
					$template .= "\n".'Le défenseur a gagné la bataille !'."\n";
				
				}
			elseif ($victoire == "N")
				{
					// Variable de concaténation si match nul
					$template .= "\n".'La bataille se termine par un match nul, les deux flottes rentrent vers leurs planètes respectives.'."\n";
				}		
		
			// Variable de concaténation pour afficher une séparation
			if ($type == "bbcode")
				{
					$template.= "\n\n";
				}
			$template .= select_picture($type, $skin, $color_PIC_RESULT, "0", "");
			if ($type == "bbcode")
				{
					$template.= "\n\n";
				}
		
			// On véréfie si une lune a été créée
			if ($lune == 1)
				{
					// Variable de concaténation si une lune a été créée
					$template .= "\n\n".' Une lune se forme dans l\'orbite de la planète!'."\n";
				}
			
			// On récupère les pillage
			if (!empty($pillage))
				{
					$pillage_unit_perdu_att = 0;
					$pillage_unit_perdu_att = 0;
					$pillage_metal = 0;
					$pillage_cristal = 0;
					$pillage_deuterium = 0;
					$pillage_cdr_M = 0;
					$pillage_cdr_C = 0;
					$id_pillage = explode("P",$pillage);
					$nb_pillage = count($id_pillage) - 1;
					for ($i=1; $i<=$nb_pillage; $i++)
						{
							$query_pillage = $db->sql_query("SELECT pertes_A, pertes_D, gain_M, gain_C, gain_D, debris_M, debris_C FROM ".TABLE_PARSEDRC." WHERE id_rc=".$id_pillage[$i]);
							list($pillage_pertes_att,$pillage_pertes_def, $pillage_gain_M, $pillage_gain_C, $pillage_gain_D, $pillage_debris_M, $pillage_debris_C) = $db->sql_fetch_row($query_pillage);
							
							$template .= 'Il emporte '.format_number($color_ressources_piller_min,$color_ressources_piller_max,$pillage_gain_M,$color_seuil_pillage,$type).$color_bal.' unités de métal, '.format_number($color_ressources_piller_min,$color_ressources_piller_max,$pillage_gain_C,$color_seuil_pillage,$type).$color_bal.' unités de cristal et '.format_number($color_ressources_piller_min,$color_ressources_piller_max,$pillage_gain_D,$color_seuil_pillage,$type).$color_bal.' de deutérium.'."\n";
					$pillage_metal = $pillage_metal + $pillage_gain_M;
					$pillage_cristal = $pillage_cristal + $pillage_gain_C;
					$pillage_deuterium = $pillage_deuterium + $pillage_gain_D;
					$pillage_cdr_M = $pillage_cdr_M + $pillage_debris_M;
					$pillage_cdr_C = $pillage_cdr_C + $pillage_debris_C;
					$pillage_unit_perdu_att = $pillage_unit_perdu_att + $pillage_pertes_att;
					$pillage_unit_perdu_def = $pillage_unit_perdu_def + $pillage_pertes_def;
						}
				}
			
		
			//on fais le bilan du rc
			$renta_Att_cdr = $gain_M + $pillage_metal + $gain_C + $pillage_cristal + $gain_D + $pillage_deuterium + $debris_M + $pillage_cdr_M + $debris_C +$pillage_cdr_C - $pertes_A - $pillage_unit_perdu_att;
			$renta_Att =$gain_M + $pillage_metal + $gain_C + $pillage_cristal + $gain_D + $pillage_deuterium - $pertes_A - $pillage_unit_perdu_att;
			$renta_Def_cdr = $debris_M + $pillage_cdr_M + $debris_C +$pillage_cdr_C - $pertes_D - $pillage_unit_perdu_def;
			$renta_Def = -$pertes_D + $pillage_unit_perdu_def;
		
		
			// Variable de concaténation du résultat du combat et de la rentabilité
			$template .= "\n".'L\'attaquant a perdu au total '.format_number($color_pertes_min_att,$color_pertes_max_att,$pertes_A,$color_seuil_pertes,$type).$color_bal.' unités.'."\n";
			$template .= 'Le défenseur a perdu au total '.format_number($color_pertes_min_def,$color_pertes_max_def,$pertes_D,$color_seuil_pertes,$type).$color_bal.' unités.'. "\n";		$template .= 'Un champ de débris contenant '.format_number($color_debris_min,$color_debris_max,$debris_M,$color_seuil_cdr,$type).$color_bal.' unités de métal et '.format_number($color_debris_min,$color_debris_max,$debris_C,$color_seuil_cdr,$type).$color_bal.' unités de cristal.'."\n\n";
			$template .= 'Rentabilité'."\n";
			$template .= 'Attaquant avec/sans recyclage : '.format_number($color_renta_min,$color_renta_max,$renta_Att_cdr,$renta_Att_cdr,$type).$color_bal.' / '.format_number($color_renta_min,$color_renta_max,$renta_Att,$renta_Att_cdr,$type).$color_bal."\n";
			$template .= 'Défenseur avec/sans recyclage : '.format_number($color_renta_min,$color_renta_max,$renta_Def_cdr,0,$type).$color_bal.' / '.format_number($color_renta_min,$color_renta_max,$renta_Def,0,$type).$color_bal."\n";
			if ($type == "bbcode")
				{
					$template.= "\n\n"."[/color][url='http://www.ogsteam.fr/'][size=7][color=#ffffff]Mod HofRC by Shad (OGSteam)[/color][/size][/url][/center]";
				}

			return $template;
			
	}

/**************************************************************************/
	
	function lost_unit ($player_name, $alive_unit, $key, $id_rcround, $cat)
		{
			global $db, $table_prefix;
			if ($cat == "att")
				{
					$table_cat = TABLE_ROUND_ATTACK;
				}
			elseif ($cat == "def")
				{
					$table_cat = TABLE_ROUND_DEFENSE;
				}
			$query_round_key = $db->sql_query("SELECT SUM(".$key.") FROM ".$table_cat." WHERE id_rcround=".$id_rcround." AND player='".$player_name."' GROUP BY player");
			WHILE (list($result_key) = $db->sql_fetch_row($query_round_key))
			$lost_unit = $result_key - $alive_unit;
			
			$result_lost_unit = "( -".number_format($lost_unit,0,',','.')." )";
	
		return $result_lost_unit;
		}
/**************************************************************************/
	
	function set_color_fleet ($PT, $GT, $CLE, $CLO, $CR, $VB, $VC, $REC, $SE, $BMD, $SAT, $DEST, $EDLM, $TRA)
		{ 
			global $db, $table_prefix;
			define('TABLE_HOFRC_SKIN',$table_prefix.'hofrc_skin');
			$set_id = $_GET['id'];
			$db->sql_query("UPDATE `".TABLE_HOFRC_SKIN."` SET `pt` = '".$PT."', `gt` = '".$GT."', `cle` = '".$CLE."', `clo` = '".$CLO."', `cr` = '".$CR."', `vb` = '".$VB."', `vc` = '".$VC."', `rec` = '".$REC."', `se` = '".$SE."', `bmd` = '".$BMD."', `sat` = '".$SAT."', `dst` = '".$DEST."', `edlm` = '".$EDLM."', `tra` = '".$TRA."'	WHERE `".TABLE_HOFRC_SKIN."`.`id`  =  ".$set_id);
		}

/**************************************************************************/
	
	function set_color_def ($LM, $LLEGER, $LLOURD, $CG, $AI, $LP, $PB, $GB)
		{ 
			global $db, $table_prefix;
			define('TABLE_HOFRC_SKIN',$table_prefix.'hofrc_skin');
			$set_id = $_GET['id'];
			$db->sql_query("UPDATE `".TABLE_HOFRC_SKIN."` SET `lm` = '".$LM."', `lleger` = '".$LLEGER."', `llourd` = '".$LLOURD."', `cg` = '".$CG."', `ai` = '".$AI."', `lp` = '".$LP."', `pb` = '".$PB."', `gb` = '".$GB."'	WHERE `".TABLE_HOFRC_SKIN."`.`id`  =  ".$set_id);
		}

/**************************************************************************/
		
	function set_color_general ($title, $ALLY, $PLAYER_ATT, $PLEYER_DEF, $TECHNO, $DETRUIT)
		{ 
			global $db, $table_prefix;
			define('TABLE_HOFRC_SKIN',$table_prefix.'hofrc_skin');
			$set_id = $_GET['id'];
			$db->sql_query("UPDATE `".TABLE_HOFRC_SKIN."` SET `title` = '".$title."', `ally` = '".$ALLY."', `player_att` = '".$PLAYER_ATT."', `player_def` = '".$PLAYER_DEF."', `techno` = '".$TECHNO."', `detruit` = '".$DETRUIT."'	WHERE `".TABLE_HOFRC_SKIN."`.`id`  =  ".$set_id);
		}

/**************************************************************************/
		
	function set_end_rc ($PILLER_MIN, $PILLER_MAX, $PERTES_FLEET_DEF, $SEUIL_PERTES, $SEUIL_PILLAGE, $SEUIL_CDR, $PERTES_MIN_ATT, $PERTES_MAX_ATT, $PERTES_MIN_DEF, $PERTES_MAX_DEF, $DEBRIS_MIN, $DEBRIS_MAX, $RENTA_MIN, $RENTA_MAX)
		{ 
			global $db, $table_prefix;
			define('TABLE_HOFRC_SKIN',$table_prefix.'hofrc_skin');
			$set_id = $_GET['id'];
			$db->sql_query("UPDATE `".TABLE_HOFRC_SKIN."` SET `ressources_piller_min` =  '".$PILLER_MIN."', `ressources_piller_max` =  '".$PILLER_MAX."', `pertes_fleet_def` =  '".$PERTES_FLEET_DEF."', `seuil_pertes` =  '".$SEUIL_PERTES."', `seuil_pillage` =  '".$SEUIL_PILLAGE."', `seuil_cdr` =  '".$SEUIL_CDR."', `pertes_min_att` =  '".$PERTES_MIN_ATT."', `pertes_max_att` =  '".$PERTES_MAX_ATT."', `pertes_min_def` =  '".$PERTES_MIN_DEF."', `pertes_max_def` =  '".$PERTES_MAX_DEF."', `debris_min` =  '".$DEBRIS_MIN."', `debris_max` =  '".$DEBRIS_MAX."', `renta_min` =  '".$RENTA_MIN."', `renta_max` =  '".$RENTA_MAX."' 	WHERE `".TABLE_HOFRC_SKIN."`.`id`  =  ".$set_id);
		}	

/**************************************************************************/
	
	function rate_resizing($percent)
		{
			global $db, $table_prefix;
			define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');
			if ($percent === 0)
				{ 
					$query_rate = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'hofrc_percent_resizing'");
					list($rate_resize) = $db->sql_fetch_row($query_rate); 
					return $rate_resize;
				}
			else
				{
					$db->sql_query("UPDATE `".TABLE_HOFRC_CONFIG."` SET `config_value` = '".$percent."' WHERE ".TABLE_HOFRC_CONFIG.".`config_name`  = 'hofrc_percent_resizing'");
				}
		}

/**************************************************************************/
		
	function image_resizing($size)
		{
			global $db;
			// On récupère le ratio des images
			$query_percent_size = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'hofrc_percent_resizing'");
			list($percent_resizing) = $db->sql_fetch_row($query_percent_size);
			
			$new_size = round((($percent_resizing/100)*$size));
			
			return $new_size;
		}
		
/**************************************************************************/

	function get_background_tab($folder)
		{
			// Liste tous les fichiers .jpg du dossier des fonds disponibles	
			$background = array(); 
			$dossier = @opendir ("mod/hofrc/Skin/".$folder); 
			while ($fichier = readdir ($dossier))
				if ((substr($fichier, -4) == ".jpg")||(substr($fichier, -4) == ".png")||(substr($fichier, -4) == ".gif"))
				$background[] = $fichier;
			
			return $background;
		}

/**************************************************************************/

	function get_image_tab($folder)
		{
			// Liste tous les fichier .jpg et .png du dossier des images disponible (fusion avec les polices et les fonds...?)
			$images = array(); 
			$dossier = @opendir ("mod/hofrc/Skin/".$folder); 
			while ($fichier = readdir ($dossier))
				if ((substr($fichier, -4) == ".jpg")||(substr($fichier, -4) == ".png"))
			$images[] = $fichier;
		
			return $images;
		}

/**************************************************************************/

	function upload_picture($pic)
		{
			preg_match ('#^\w+#',$_FILES['picture']['name'],$pic_name);
			$erreur = "Le nom du fichier n'est pas écrit correctement, il devrait ce nommer ";
			if ($pic == "PIC_HEADER")
				{
					if ($pic_name[0] == "header")
						{
							upload("pictures");
						}
					else
						{
							echo $erreur."header.xxx";
						}
				}
		
			elseif ($pic == "PIC_ROUND")
				{
					if ($pic_name[0] == "round")
					{
						upload("pictures");
					}
				else
					{
						echo $erreur."round.xxx";
					}
			
				}
		
			elseif ($pic == "PIC_SEPARATOR")
				{
					if ($pic_name[0] == "separator")
					{
						upload("pictures");
					}
				else
					{
						echo $erreur."separator.xxx";
					}
				}
		
			elseif ($pic == "PIC_RESULT")
				{
					if ($pic_name[0] == "result")
					{
						upload("pictures");
					}
				else
					{
						echo $erreur."result.xxx";
					}
				}
		
			elseif ($pic == "PIC_BACKGROUND")
				{
					if ($pic_name[0] == "background")
					{
						upload("pictures");
					}
				else
					{
						echo $erreur."background.xxx";
					}
				}
			elseif ($pic == "HISTORIQUE")
				{
					if ($pic_name[0] == "historique.xxx")
					{
						upload("pictures");
					}
				else
					{
						echo $erreur."background.xxx";
					}
				}
		}

/**************************************************************************/

	function upload($type)
		{
			$skin= select_skin(0);
			if($type=='pictures') 
				{
					$dossier = "mod/hofrc/Skin/".$skin."/";
					$fichier = basename($_FILES['picture']['name']);
					$taille_maxi = 300000;
					$taille = filesize($_FILES['picture']['tmp_name']);
					$extensions = array('.png', '.jpg', '.gif');
					$extension = strrchr($_FILES['picture']['name'], '.'); 

					//Vérification du fichiers
					if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans l'array
						{
							$erreur = 'Vous devez uploader un fichier de type png, jpg ou gif';
						}

					if($taille>$taille_maxi)
						{
							$erreur = 'Le fichier est trop gros...';
						}
					
					if(!isset($erreur)) //Aucune erreur, on upload
						{
							//On formate le nom du fichier
							$fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
							$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
							if(move_uploaded_file($_FILES['picture']['tmp_name'], $dossier . $fichier))
								{
									echo 'Upload effectué avec succès !';
								}
							else 
								{
									echo 'Echec de l\'upload !';
								}
						}
					else
						{
							echo $erreur;
						}
				}

			//Upload de police
			if($type=='font') 
				{
					$dossier = 'mod/hofrc/Font/';
					$fichier = basename($_FILES['file']['name']);
					$taille_maxi = 500000;
					$taille = filesize($_FILES['file']['tmp_name']);
					$extensions = array('.ttf');
					$extension = strrchr($_FILES['file']['name'], '.'); 
					
					//Vérification du fichiers
					if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans l'array
						{
							$erreur = 'Vous devez uploader un fichier de type ttf';
						}
					
					if($taille>$taille_maxi)
						{
							$erreur = 'Le fichier est trop gros...';
						}
					
					if(!isset($erreur)) //Aucune erreur, on upload
						{
							//On formate le nom du fichier
							$fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
							$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
							if(move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $fichier))
								{
									echo 'Upload effectué avec succès !';
								}
							else 
								{
									echo 'Echec de l\'upload !';
								}
						}
					else
						{
							echo $erreur;
						}
				}
		}

/**************************************************************************/

	function list_font()
		{
			$folder = "mod/hofrc/Font";
			if ($list = opendir($folder))
				{
					while (false !== ($file = readdir($list)))
						{
							if($file != "."&&$file!=".."&&!is_dir($folder.$file))
								{
									echo $file."\r\n<br>";
								}
						}
					closedir($list);
				}
		}
		
/**************************************************************************/

	// La fonction principale du mod qui permet de détecter les hofs dans les rc par rapport au date limite de chaque type de rc
	function find_hof($Nb_Att, $Nb_Def, $victory, $dateRC, $debris_M, $debris_C, $id_RC)
		{
			global $db, $table_prefix;
			define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');
			define('TABLE_HOFRC_INFO_RC',$table_prefix.'hofrc_info_rc');
			$query_set_config = "select * from " . TABLE_HOFRC_CONFIG;
			$set_config = mysql_query($query_set_config);
			while (list($set_config_name, $set_config_value) = mysql_fetch_row($set_config)) 
				{
					$set_hofrc_config[$set_config_name] = stripslashes($set_config_value);
				}
			
			// On calcul la taille du CDR
			$cdr = $debris_M + $debris_C;
			
			// On détermine qui est le vainqeur pour savoir par la suite s'il s'agit d'un groupée
			if (($Nb_Att == 1) || ($Nb_Def == 1))
				{
					// Maintenant que l'on sait qu'il s'agit d'une victoire solo on détermine de quel catégorie il s'agit.
					if(($set_hofrc_config["size_initial"] < $cdr && $cdr < $set_hofrc_config["size_courant"]) && ($set_hofrc_config["start_universe"] < $dateRc && $dateRC < $set_hofrc_config["end_initial_solo"]))
						{
							$check_initial_solo = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_initial_solo))
									{ 
										signal_hof($id_RC,"INITIAL");
										echo  "<script>alert('Un HOF Initial a été fait.');</script>";
									}
							return "<span style='color:red;'>Initial</span>";
						}
					elseif(($set_hofrc_config["size_courant"] < $cdr && $cdr < $set_hofrc_config["size_basic"]) && ($set_hofrc_config["start_universe"] < $dateRc && $set_hofrc_config["end_courant_solo"] > $dateRC))
						{
							$check_courant_solo = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_courant_solo))
									{ 
										signal_hof($id_RC,"COURANT");
										echo  "<script>alert('Un HOF Courant a été fait.');</script>";
									}
							return "<span style='color:red;'>Courant</span>";
						}
					elseif(($set_hofrc_config["size_basic"] < $cdr && $cdr < $set_hofrc_config["size_normal"]) && ($set_hofrc_config["start_universe"] < $dateRc && $dateRC < $set_hofrc_config["end_basic_solo"]))
						{
							$check_basic_solo = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_initial_basic))
									{ 
										signal_hof($id_RC,"BASIC");
										echo  "<script>alert('Un HOF Basic a été fait.');</script>";
									}
							return "<span style='color:red;'>Basic</span>";
						}
					elseif(($set_hofrc_config["size_normal"] < $cdr && $cdr < $set_hofrc_config["size_avance"]) && ($set_hofrc_config["start_universe"] < $dateRc && $dateRC < $set_hofrc_config["end_normal_solo"]))
						{
							$check_normal_solo = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_normal_solo))
									{ 
										signal_hof($id_RC,"NORMAL");
										echo  "<script>alert('Un HOF Normal a été fait.');</script>";
									}
							return "<span style='color:red;'>Normal</span>";
						}
					elseif(($set_hofrc_config["size_avance"] < $cdr && $cdr < $set_hofrc_config["size_stratege"]) && ($set_hofrc_config["start_universe"] < $dateRc) && ($dateRC < $set_hofrc_config["end_stratege_solo"]))
						{
							$check_avance_solo = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_avance_solo))
									{ 
										signal_hof($id_RC,"AVANCE");
										echo  "<script>alert('Un HOF Avancé a été fait.');</script>";
									}
							return "<span style='color:red;'>Avancé</span>";
						}
					elseif($set_hofrc_config["size_stratege"] < $cdr && $cdr < $set_hofrc_config["size_expert"])
						{
							$check_stratege_solo = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_stratege_solo))
									{ 
										signal_hof($id_RC,"STRATEGE");
										echo  "<script>alert('Un HOF Stratège a été fait.');</script>";
									}
							return "<span style='color:red;'>Stratège</span>";
						}
					elseif($set_hofrc_config["size_expert"] < $cdr && $cdr < $set_hofrc_config["size_guerrier"])
						{
							$check_expert_solo = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_expert_solo))
									{ 
										signal_hof($id_RC,"EXPERT");
										echo  "<script>alert('Un HOF Expert a été fait.');</script>";
									}
							return "<span style='color:red;'>Expert</span>";
						}
					elseif($set_hofrc_config["size_guerrier"] < $cdr && $cdr < $set_hofrc_config["size_devastateur"])
						{
							$check_guerrier_solo = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_guerrier_solo))
									{ 
										signal_hof($id_RC,"GUERRIER");
										echo  "<script>alert('Un HOF Guerrier a été fait.');</script>";
									}
							return "<span style='color:red;'>Guerrier</span>";
						}
					elseif($set_hofrc_config["size_devastateur"] < $cdr && $cdr < $set_hofrc_config["size_champion"])
						{
							$check_devastateur_solo = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_devastateur_solo))
									{ 
										signal_hof($id_RC,"DEVASTATEUR");
										echo  "<script>alert('Un HOF Dévastateur a été fait.');</script>";
									}
							return "<span style='color:red;'>Dévastateur</span>";
						}
					elseif($set_hofrc_config["size_champion"] < $cdr && $cdr < $set_hofrc_config["size_legendaire"])
						{
							$check_champion_solo = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_champion_solo))
									{ 
										signal_hof($id_RC,"CHAMPION");
										echo  "<script>alert('Un HOF Champion a été fait.');</script>";
									}
							return "<span style='color:red;'>Champion</span>";
						}
					elseif($set_hofrc_config["size_legendaire"] < $cdr)
						{
							$check_legendaire_solo = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_legendaire_solo))
									{ 
										signal_hof($id_RC,"LEGENDAIRE");
										echo  "<script>alert('Un HOF Légendaire a été fait.');</script>";
									}
							return "<span style='color:red;'>Legendaire</span>";
						}
				}
			elseif(($set_hofrc_config["size_initial"] < $cdr && $cdr < $set_hofrc_config["size_courant"]) && ($set_hofrc_config["start_universe"] < $dateRc && $dateRC < $set_hofrc_config["end_initial_groupe"]))
						{
							$check_initial_groupe = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_initial_groupe))
									{ 
										signal_hof($id_RC,"INITIAL");
										echo  "<script>alert('Un HOF initial a été fait.');</script>";
									}
							return "<span style='color:red;'>Initial</span>";
						}
					elseif(($set_hofrc_config["size_courant"] < $cdr && $cdr < $set_hofrc_config["size_basic"]) && ($set_hofrc_config["start_universe"] < $dateRc && $dateRC < $set_hofrc_config["end_courant_groupe"]))
						{
							$check_courant_groupe = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_courant_groupe))
									{ 
										signal_hof($id_RC,"COURANT");
										echo  "<script>alert('Un HOF Courant a été fait.');</script>";
									}
							return "<span style='color:red;'>Courant</span>";
						}
					elseif(($set_hofrc_config["size_basic"] < $cdr && $cdr < $set_hofrc_config["size_normal"]) && ($set_hofrc_config["start_universe"] < $dateRc && $dateRC < $set_hofrc_config["end_basic_groupe"]))
						{
							$check_basic_groupe = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_basic_groupe))
									{ 
										signal_hof($id_RC,"BASIC");
										echo  "<script>alert('Un HOF Basic a été fait.');</script>";
									}
							return "<span style='color:red;'>Basic</span>";
						}
					elseif(($set_hofrc_config["size_normal"] < $cdr && $cdr < $set_hofrc_config["size_avance"]) && ($set_hofrc_config["start_universe"] < $dateRc && $dateRC < $set_hofrc_config["end_normal_groupe"]))
						{
							$check_normal_groupe = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_normal_groupe))
									{ 
										signal_hof($id_RC,"NORMAL");
										echo  "<script>alert('Un HOF Normal a été fait.');</script>";
									}
							return "<span style='color:red;'>Normal</span>";
						}
					elseif(($set_hofrc_config["size_avance"] < $cdr && $cdr < $set_hofrc_config["size_stratege"]) && ($set_hofrc_config["start_universe"] < $dateRc && $dateRC < $set_hofrc_config["end_stratege_groupe"]))
						{
							$check_avance_groupe = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_avance_groupe))
									{ 
										signal_hof($id_RC,"AVANCE");
										echo  "<script>alert('Un HOF Avancé a été fait.');</script>";
									}
							return "<span style='color:red;'>Avancé</span>";
						}
					elseif($set_hofrc_config["size_stratege"] < $cdr && $cdr < $set_hofrc_config["size_expert"])
						{
							$check_stratege_groupe = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_stratege_groupe))
									{ 
										signal_hof($id_RC,"STRATEGE");
										echo  "<script>alert('Un HOF Stratège a été fait.');</script>";
									}
							return "<span style='color:red;'>Stratège</span>";
						}
					elseif($set_hofrc_config["size_expert"] < $cdr && $cdr < $set_hofrc_config["size_guerrier"])
						{
							$check_expert_groupe = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
							if(!$db->sql_numrows($check_expert_groupe))
									{ 
										signal_hof($id_RC,"EXPERT");
										echo  "<script>alert('Un HOF Expert a été fait.');</script>";
									}
							return "<span style='color:red;'>Expert</span>";
						}
					elseif($set_hofrc_config["size_guerrier"] < $cdr && $cdr < $set_hofrc_config["size_devastateur"])
						{
							$check_guerrier_groupe = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_guerrier_groupe))
									{ 
										signal_hof($id_RC,"GUERRIER");
										echo  "<script>alert('Un HOF Guerrier a été fait.');</script>";
									}
							return "<span style='color:red;'>Guerrier</span>";
						}
					elseif($set_hofrc_config["size_devastateur"] < $cdr && $cdr < $set_hofrc_config["size_champion"])
						{
							$check_devastateur_groupe = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_devastateur_groupe))
									{ 
										signal_hof($id_RC,"DEVASTATEUR");
										echo  "<script>alert('Un HOF Dévastateur a été fait.');</script>";
									}
							return "<span style='color:red;'>Dévastateur</span>";
						}
					elseif($set_hofrc_config["size_champion"] < $cdr && $cdr < $set_hofrc_config["size_legendaire"])
						{
							$check_champion_groupe = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_champion_groupe))
									{ 
										signal_hof($id_RC,"CHAMPION");
										echo  "<script>alert('Un HOF Champion a été fait.');</script>";
									}
							return "<span style='color:red;'>Champion</span>";
						}
					elseif($set_hofrc_config["size_legendaire"] < $cdr)
						{ 
							$check_legendaire_groupe = $db->sql_query("SELECT `id_rc` FROM ".TABLE_HOFRC_INFO_RC." WHERE `id_rc` = ".$id_RC);
								if(!$db->sql_numrows($check_legendaire_groupe))
									{ 
										signal_hof($id_RC,"LEGENDAIRE");
										echo  "<script>alert('Un HOF Légendaire a été fait.');</script>";
									}
							return "<span style='color:red;'>Legendaire</span>";
						}
						
				
		}

/**************************************************************************/

	function signal_hof($id_RC,$type)
		{
			global $db, $table_prefix;
			define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');
			define('TABLE_HOFRC_ATTACK',$table_prefix.'hofrc_attack');
			define('TABLE_HOFRC_DEFENSE',$table_prefix.'hofrc_defence');
			define('TABLE_HOFRC_INFO_RC',$table_prefix.'hofrc_info_rc');
			
			// On sélectionne les id des round pour le rc dans la table parsedRCROUND
			$query_parsedrcround_first = $db->sql_query("SELECT id_rcround FROM ".TABLE_PARSEDRCROUND." WHERE id_rc = ".$id_RC." AND numround = 1 ");
			list($id_rcround_first) = $db->sql_fetch_row($query_parsedrcround_first);
			
			// On sélectionne les info du rc dans la table parsedRC
			$query_parsedrc = $db->sql_query("SELECT dateRC, coordinates, nb_rounds, victoire, pertes_A, pertes_D, gain_M, gain_C, gain_D, debris_M, debris_C, lune FROM ".TABLE_PARSEDRC." WHERE id_rc=".$id_RC);
			list($dateRC, $coordinates, $nb_rounds, $victoire, $pertes_A, $pertes_D, $gain_M, $gain_C, $gain_D, $debris_M, $debris_C, $lune) = $db->sql_fetch_row($query_parsedrc);
			$db->sql_query("INSERT INTO `".TABLE_HOFRC_INFO_RC."` (`id`, `id_rc`, `id_rcround`, `Daterc`, `type_hof`, `coordinates`, `victoire`, `nb_rounds`, `metal_taken`, `cristal_taken`, `deut_taken`, `metal_cdr`, `cristal_cdr`, `lost_attack`, `lost_defence`, `lune`) VALUES ('', '".$id_RC."', '".$id_rcround_first."', '".$dateRC."', '".$type."', '".$coordinates."', '".$victoire."', '".$nb_rounds."', '".$gain_M."', '".$gain_C."', '".$gain_D."', '".$debris_M."', '".$debris_C."', '".$pertes_A."', '".$pertes_D."', '".$lune."')");
						
			//On va récupérer caractéristiques des attaquant du premier round
			$query_attack = $db->sql_query("SELECT `player`, `coordinates`, `Armes`, `Bouclier`, `Protection`, SUM(`PT`), SUM(`GT`), SUM(`CLE`), SUM(`CLO`), SUM(`CR`), SUM(`VB`), SUM(`VC`), SUM(`REC`), SUM(`SE`), SUM(`BMD`), SUM(`DST`), SUM(`EDLM`), SUM(`TRA`) FROM `".TABLE_ROUND_ATTACK."` WHERE `id_rcround` = ".$id_rcround_first." group by `player`"); ;
			WHILE (list($player_att, $coordinates_att, $Armes_att, $Bouclier_att, $Protection_att, $PT_att, $GT_att, $CLE_att, $CLO_att, $CR_att, $VB_att, $VC_att, $REC_att, $SE_att, $BMD_att, $DST_att, $EDLM_att, $TRA_att) = $db->sql_fetch_row($query_attack))
				{
					// On récupère les alliances des attaquants
					$query_ally_att = $db->sql_query ("SELECT ally FROM ".TABLE_UNIVERSE." WHERE player = '".$player_att."'");
					list($result_ally_att) = $db->sql_fetch_row($query_ally_att);
					if (empty($result_ally_att))
						{
							$ally_att = "NO ALLY";
						}
					else
						{
							$ally_att = $result_ally_att;
						}
					$db->sql_query("INSERT INTO `".TABLE_HOFRC_ATTACK."` (`id`, `id_rc`, `round`, `player`, `ally`, `coordinates`, `armes`, `bouclier`, `protection`, `pt`, `gt`, `cle`, `clo`, `cr`, `vb`, `vc`, `rec`, `se`, `bmd`, `dst`, `edlm`, `tra`) VALUES ('', '".$id_RC."', '1', '".$player_att."', '".$ally_att."', '".$coordinates_att."', '".$Armes_att."', '".$Bouclier_att."', '".$Protection_att."', '".$PT_att."', '".$GT_att."', '".$CLE_att."', '".$CLO_att."', '".$CR_att."', '".$VB_att."', '".$VC_att."', '".$REC_att."', '".$SE_att."', '".$BMD_att."', '".$DST_att."', '".$EDLM_att."', '".$TRA_att."')");
				}
				
				
			//On va récupérer caractéristiques des défenseurs du premier round
			$query_defence = $db->sql_query("SELECT `player`, `coordinates`, `Armes`, `Bouclier`, `Protection`, SUM(`PT`), SUM(`GT`), SUM(`CLE`), SUM(`CLO`), SUM(`CR`), SUM(`VB`), SUM(`VC`), SUM(`REC`), SUM(`SE`), SUM(`BMD`), SUM(`DST`), SUM(`EDLM`), `SAT`, SUM(`TRA`), `LM`, `LLE`, `LLO`, `CG`, `AI`, `LP`, `PB`, `GB` FROM `".TABLE_ROUND_DEFENSE."` WHERE `id_rcround` = ".$id_rcround_first." group by `player`");
			WHILE (list($player_def, $coordinates_def, $Armes_def, $Bouclier_def, $Protection_def, $PT_def, $GT_def, $CLE_def, $CLO_def, $CR_def, $VB_def, $VC_def, $REC_def, $SE_def, $BMD_def, $DST_def, $EDLM_def, $SAT_def, $TRA_def, $LM, $LLE, $LLO, $CG, $AI, $LP, $PB, $GB) = $db->sql_fetch_row($query_defence))
				{
					// On récupère les alliances des défenseurs
					$query_ally_def = $db->sql_query ("SELECT ally FROM ".TABLE_UNIVERSE." WHERE player = '".$player_def."'");
					list($result_ally_def) = $db->sql_fetch_row($query_ally_def);
					if (empty($result_ally_def))
						{
							$ally_def = "NO ALLY";
						}
					else
						{
							$ally_def = $result_ally_def;
						}
					$db->sql_query("INSERT INTO `".TABLE_HOFRC_DEFENSE."` (`id`, `id_rc`, `round`, `player`, `ally`, `coordinates`, `armes`, `bouclier`, `protection`, `pt`, `gt`, `cle`, `clo`, `cr`, `vb`, `vc`, `rec`, `se`, `bmd`, `dst`, `edlm`, `tra`, `sat`, `lm`, `lle`, `llo`, `cg`, `ai`, `lp`, `pb`, `gb`) VALUES ('', '".$id_RC."', '1', '".$player_def."', '".$ally_def."', '".$coordinates_def."', '".$Armes_def."', '".$Bouclier_def."', '".$Protection_def."', '".$PT_def."', '".$GT_def."', '".$CLE_def."', '".$CLO_def."', '".$CR_def."', '".$VB_def."', '".$VC_def."', '".$REC_def."', '".$SE_def."', '".$BMD_def."', '".$DST_def."', '".$EDLM_def."', '".$TRA_def."', '".$SAT_def."', '".$LM."', '".$LLE."', '".$LLO."', '".$CG."', '".$AI."', '".$LP."', '".$PB."', '".$GB."')");
					
				}
				
			$query_parsedrcround_last = $db->sql_query("SELECT id_rcround FROM ".TABLE_PARSEDRCROUND." WHERE id_rc = ".$id_RC." AND numround = ".$nb_rounds);
			list($id_rcround_last) = $db->sql_fetch_row($query_parsedrcround_last);
			
			//On va récupérer caractéristiques des attaquant du dernier round
			$query_attack_last = $db->sql_query("SELECT `player`, `coordinates`, `Armes`, `Bouclier`, `Protection`, SUM(`PT`), SUM(`GT`), SUM(`CLE`), SUM(`CLO`), SUM(`CR`), SUM(`VB`), SUM(`VC`), SUM(`REC`), SUM(`SE`), SUM(`BMD`), SUM(`DST`), SUM(`EDLM`), SUM(`TRA`) FROM `".TABLE_ROUND_ATTACK."` WHERE `id_rcround` = ".$id_rcround_last." group by `player`"); ;
			WHILE (list($player_att_last, $coordinates_att_last, $Armes_att_last, $Bouclier_att_last, $Protection_att_last, $PT_att_last, $GT_att_last, $CLE_att_last, $CLO_att_last, $CR_att_last, $VB_att_last, $VC_att_last, $REC_att_last, $SE_att_last, $BMD_att_last, $DST_att_last, $EDLM_att_last, $TRA_att_last) = $db->sql_fetch_row($query_attack_last))
				{
					// On récupère les alliances des attaquants
					$query_ally_att_last = $db->sql_query ("SELECT ally FROM ".TABLE_UNIVERSE." WHERE player = '".$player_att."'");
					list($result_ally_att_last) = $db->sql_fetch_row($query_ally_att_last);
					if (empty($result_ally_att))
						{
							$ally_att_last = "NO ALLY";
						}
					else
						{
							$ally_att_last = $result_ally_att_last;
						}
					$db->sql_query("INSERT INTO `".TABLE_HOFRC_ATTACK."` (`id`, `id_rc`, `round`, `player`, `ally`, `coordinates`, `armes`, `bouclier`, `protection`, `pt`, `gt`, `cle`, `clo`, `cr`, `vb`, `vc`, `rec`, `se`, `bmd`, `dst`, `edlm`, `tra`) VALUES ('', '".$id_RC."', '".$nb_rounds."', '".$player_att_last."', '".$ally_att_last."','".$coordinates_att_last."', '".$Armes_att_last."', '".$Bouclier_att_last."', '".$Protection_att_last."', '".$PT_att_last."', '".$GT_att_last."', '".$CLE_att_last."', '".$CLO_att_last."', '".$CR_att_last."', '".$VB_att_last."', '".$VC_att_last."', '".$REC_att_last."', '".$SE_att_last."', '".$BMD_att_last."', '".$DST_att_last."', '".$EDLM_att_last."', '".$TRA_att_last."')");
				}
			
				
			//On va récupérer caractéristiques des défenseurs du dernier round
			$query_defence_last = $db->sql_query("SELECT `player`, `coordinates`, `Armes`, `Bouclier`, `Protection`, SUM(`PT`), SUM(`GT`), SUM(`CLE`), SUM(`CLO`), SUM(`CR`), SUM(`VB`), SUM(`VC`), SUM(`REC`), SUM(`SE`), SUM(`BMD`), SUM(`DST`), SUM(`EDLM`), `SAT`, SUM(`TRA`), `LM`, `LLE`, `LLO`, `CG`, `AI`, `LP`, `PB`, `GB` FROM `".TABLE_ROUND_DEFENSE."` WHERE `id_rcround` = ".$id_rcround_last." group by `player`");
			WHILE (list($player_def_last, $coordinates_def_last, $Armes_def_last, $Bouclier_def_last, $Protection_def_last, $PT_def_last, $GT_def_last, $CLE_def_last, $CLO_def_last, $CR_def_last, $VB_def_last, $VC_def_last, $REC_def_last, $SE_def_last, $BMD_def_last, $DST_def_last, $EDLM_def_last, $SAT_def_last, $TRA_def_last, $LM_last, $LLE_last, $LLO_last, $CG_last, $AI_last, $LP_last, $PB_last, $GB_last) = $db->sql_fetch_row($query_defence_last))
				{
					// On récupère les alliances des défenseurs
					$query_ally_def_last = $db->sql_query ("SELECT ally FROM ".TABLE_UNIVERSE." WHERE player = '".$player_def."'");
					list($result_ally_def_last) = $db->sql_fetch_row($query_ally_def_last);
					if (empty($result_ally_def_last))
						{
							$ally_def_last = "NO ALLY";
						}
					else
						{
							$ally_def_last = $result_ally_def_last;
						}
					$db->sql_query("INSERT INTO `".TABLE_HOFRC_DEFENSE."` (`id`, `id_rc`, `round`, `player`, `ally`, `coordinates`, `armes`, `bouclier`, `protection`, `pt`, `gt`, `cle`, `clo`, `cr`, `vb`, `vc`, `rec`, `se`, `bmd`, `dst`, `edlm`, `tra`, `sat`, `lm`, `lle`, `llo`, `cg`, `ai`, `lp`, `pb`, `gb`) VALUES ('', '".$id_RC."', '".$nb_rounds."', '".$player_def_last."', '".$ally_def_last."','".$coordinates_def_last."', '".$Armes_def_last."', '".$Bouclier_def_last."', '".$Protection_def_last."', '".$PT_def_last."', '".$GT_def_last."', '".$CLE_def_last."', '".$CLO_def_last."', '".$CR_def_last."', '".$VB_def_last."', '".$VC_def_last."', '".$REC_def_last."', '".$SE_def_last."', '".$BMD_def_last."', '".$DST_def_last."', '".$EDLM_def_last."', '".$TRA_def_last."', '".$SAT_def_last."', '".$LM_last."', '".$LLE_last."', '".$LLO_last."', '".$CG_last."', '".$AI_last."', '".$LP_last."', '".$PB_last."', '".$GB_last."')");
					
				}
		}
	
	/**************************************************************************/
	
	function historique($name)
		{ 
			global $db, $table_prefix;
			define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');
			define('TABLE_HOFRC_ATTACK',$table_prefix.'hofrc_attack');
			define('TABLE_HOFRC_DEFENSE',$table_prefix.'hofrc_defence');
			define('TABLE_HOFRC_INFO_RC',$table_prefix.'hofrc_info_rc');
			define('TABLE_HOFRC_TITLE',$table_prefix.'hofrc_title');
			$skin = select_skin(0);
			// On récupère la police
			$query_font = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'font_historique'");
			list($select_font) = $db->sql_fetch_row($query_skin); 
			// On récupère les dimensions de l'image
			$query_largeur = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'largeur_historique'");
			list($largeur_picture) = $db->sql_fetch_row($query_largeur); 
			$query_hauteur = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'hauteur_historique'");
			list($hauteur_picture) = $db->sql_fetch_row($query_hauteur);
			// On récupère les paramètres pour le texte
			$query_font_size = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'font_size_historique'");
			list($font_size) = $db->sql_fetch_row($query_font_size); 
			$query_angle = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'angle_historique'");
			list($angle) = $db->sql_fetch_row($query_angle);
			$query_pos_horiz_1 = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'pos_horiz_historique_1'");
			list($pos_horiz_1) = $db->sql_fetch_row($query_pos_horiz_1); 
			$query_pos_horiz_2 = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'pos_horiz_historique_2'");
			list($pos_horiz_2) = $db->sql_fetch_row($query_pos_horiz_2); 
			$query_pos_horiz_3 = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'pos_horiz_historique_3'");
			list($pos_horiz_3) = $db->sql_fetch_row($query_pos_horiz_3); 
			$query_pos_horiz_4 = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'pos_horiz_historique_4'");
			list($pos_horiz_4) = $db->sql_fetch_row($query_pos_horiz_4); 
			$query_pos_horiz_5 = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'pos_horiz_historique_5'");
			list($pos_horiz_5) = $db->sql_fetch_row($query_pos_horiz_5); 
			$query_pos_verti = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'pos_verti_historique'");
			list($pos_verti) = $db->sql_fetch_row($query_pos_verti);
			
			$query_color_txt_1 = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'color_txt_historique_1'");
			list($color_txt_1_RGB) = $db->sql_fetch_row($query_color_txt_1); 
			$query_color_txt_2 = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'color_txt_historique_2'");
			list($color_txt_2_RGB) = $db->sql_fetch_row($query_color_txt_2); 
			$query_color_txt_3 = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'color_txt_historique_3'");
			list($color_txt_3_RGB) = $db->sql_fetch_row($query_color_txt_3); 
			$query_pos_horiz_5 = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'color_txt_historique_4'");
			list($color_txt_4_RGB) = $db->sql_fetch_row($query_color_txt_4); 
			$query_color_txt_5 = $db->sql_query("SELECT `config_value` FROM ".TABLE_HOFRC_CONFIG." WHERE `config_name` = 'color_txt_historique_5'");
			list($color_txt_5_RGB) = $db->sql_fetch_row($query_color_txt_5);
			$color_txt_1 = explode(",",$color_txt_1_RGB);
			$color_txt_2 = explode(",",$color_txt_2_RGB);
			$color_txt_3 = explode(",",$color_txt_3_RGB);
			$color_txt_4 = explode(",",$color_txt_4_RGB);
			$color_txt_5 = explode(",",$color_txt_5_RGB);
			
			$source = imagecreatefromjpeg("mod/hofrc/Skin/".$skin."/historique.jpg");
			$historique="mod/hofrc/Output/".$name.".png";
			$font = "/mod/hofrc/Font/".$select_font;
			if (is_file($historique))
				{ 
					unlink($historique);
				}// Regarde si le fichier existe ou non  
			
			// $list_hof = $db->sql_query("SELECT `id`, `id_rc`, `BOARD_URL`, `TITLE` FROM ".TABLE_HOFRC_TITLE);
			$query_title = $db->sql_query("SELECT `id`, `id_rc`, `BOARD_URL`, `title` FROM ".TABLE_HOFRC_TITLE." ORDER BY id");
			while ($title = mysql_fetch_assoc($query_title))
				{
					$color_txt_1 = explode(",",$color_txt_1_RGB);
					$color_txt_2 = explode(",",$color_txt_2_RGB);
					$color_txt_3 = explode(",",$color_txt_3_RGB);
					$color_txt_4 = explode(",",$color_txt_4_RGB);
					$color_txt_5 = explode(",",$color_txt_5_RGB);
					$destination  = imagecreatetruecolor($largeur_picture, $hauteur_picture) or die ("Impossible de crée un flux d'image GD");
					$color_txt_1 = imagecolorallocate($destination, $color_txt_1[0], $color_txt_1[1], $color_txt_1[2]);
					$color_txt_2 = imagecolorallocate($destination, $color_txt_2[0], $color_txt_2[1], $color_txt_2[2]);
					$color_txt_3 = imagecolorallocate($destination, $color_txt_3[0], $color_txt_3[1], $color_txt_3[2]);
					$color_txt_4 = imagecolorallocate($destination, $color_txt_4[0], $color_txt_4[1], $color_txt_4[2]);
					$color_txt_5 = imagecolorallocate($destination, $color_txt_5[0], $color_txt_5[1], $color_txt_5[2]);

					$query_info = $db->sql_query("SELECT `TYPE_HOF` FROM `".TABLE_HOFRC_INFO_RC."` WHERE `id_rc` = ".$title['id_rc']);
					(list($type_hof) = $db->sql_fetch_row($query_info));
					$text1 = $title['id'];
					$text2 = "-";
					$text3 =  $type_hof;
					$text4 = "-";
					$text5 = $title['title']."\n";
					
					// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
					$largeur_source = imagesx($source);
					$hauteur_source = imagesy($source);
					$largeur_destination = imagesx($destination);
					$hauteur_destination = imagesy($destination);
					imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
												putenv('GDFONTPATH=' . realpath('.'));
					//image - taille font - angle - horizontal - verticale
					imagettftext($destination, $font_size, $angle, $pos_horiz_1, $pos_verti, $color_txt_1, $font, $text1);
					imagettftext($destination, $font_size, $angle, $pos_horiz_2, $pos_verti, $color_txt_2, $font, $text2);
					imagettftext($destination, $font_size, $angle, $pos_horiz_3, $pos_verti, $color_txt_3, $font, $text3);
					imagettftext($destination, $font_size, $angle, $pos_horiz_4, $pos_verti, $color_txt_4, $font, $text4);
					imagettftext($destination, $font_size, $angle, $pos_horiz_5, $pos_verti, $color_txt_5, $font, $text5);
					imagepng($destination,$historique);
					imagedestroy($destination);
									
				}
					
			
		}
	function page_footer() {
		global $db;
		//Récupére le numéro de version du mod
		$request = 'SELECT `version` from `'.TABLE_MOD.'` WHERE title=\'hofrc\'';
		$result = $db->sql_query($request);
		list($version) = $db->sql_fetch_row($result);
		echo '<div>HofRC (v'.$version.') créé par Shad</div>';
		echo '<div>Remise à jour pour OGSpy 3.0.7 - Shad</div>';
}
?>