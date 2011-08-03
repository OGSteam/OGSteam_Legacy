<?php
/**
 * admin.php 
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
if ($user_data['user_admin'] != 1 && $user_data['user_coadmin'] != 1) {
	redirection('index.php?action=message&id_message=forbidden&info');
}
require_once('mod/hofrc/Pages/include.php');
//Définitions
global $db, $table_prefix, $prefixe;
		define('TABLE_HOFRC_SKIN',$table_prefix.'hofrc_skin');
		define('TABLE_HOFRC_CONFIG',$table_prefix.'hofrc_config');

if($_GET["id"])
{

set_color_fleet ($PT = $_POST["couleur_pt"], $GT = $_POST["couleur_gt"], $CLE = $_POST["couleur_cle"], $CLO = $_POST["couleur_clo"], $CR = $_POST["couleur_cr"], $VB = $_POST["couleur_vb"], $VC = $_POST["couleur_vc"], $REC = $_POST["couleur_rec"], $SE = $_POST["couleur_se"], $BMD = $_POST["couleur_bmd"], $SAT = $_POST["couleur_sat"], $DST = $_POST["couleur_dst"], $EDLM = $_POST["couleur_edlm"], $TRA = $_POST["couleur_tra"]);
set_color_def ($LM = $_POST["couleur_lm"], $LLEGER = $_POST["couleur_lleger"], $LLOURD = $_POST["couleur_llourd"], $CG = $_POST["couleur_cg"], $AI = $_POST["couleur_ai"], $LP = $_POST["couleur_lp"], $PB = $_POST["couleur_pb"], $GB = $_POST["couleur_gb"]);
set_color_general ($title=$_POST["set_title"], $ALLY = $_POST["couleur_ally"], $PLAYER_ATT = $_POST["couleur_player_att"], $PLAYER_DEF = $_POST["couleur_player_def"], $TECHNO = $_POST["couleur_techno"], $DETRUIT = $_POST["couleur_detruit"]);
set_end_rc ($PILLER_MIN = $_POST["couleur_ressources_piller_min"], $PILLER_MAX = $_POST["couleur_ressources_piller_max"], $PERTES_FLEET_DEF = $_POST["couleur_pertes_fleet_def"], $SEUIL_PERTES = $_POST["couleur_seuil_pertes"], $SEUIL_PILLAGE = $_POST["couleur_seuil_pillage"], $SEUIL_CDR = $_POST["couleur_seuil_cdr"], $PERTES_MIN_ATT = $_POST["couleur_pertes_min_att"], $PERTES_MAX_ATT = $_POST["couleur_pertes_max_att"], $PERTES_MIN_DEF = $_POST["couleur_pertes_min_def"], $PERTES_MAX_DEF = $_POST["couleur_pertes_max_def"], $DEBRIS_MIN = $_POST["couleur_debris_min"], $DEBRIS_MAX = $_POST["couleur_debris_max"], $RENTA_MIN  = $_POST["couleur_renta_min"], $RENTA_MAX = $_POST["couleur_renta_max"]);
	
}

if(!empty($_POST["PIC"]))
	{
		$type_upload = $_POST["PIC"];
		upload_picture($type_upload);
	}

if(!empty($_POST["new_skin"]))
	{
		new_skin($new_skin = $_POST["new_skin"]);
	}

if(!empty($_POST["rate_resize"]))
	{
		rate_resizing($percent = $_POST["rate_resize"]);
	}

if ($_POST["list_skin"])
	{
		select_skin($values = $_POST["list_skin"]);
		
	}
	
if ($_POST["config_universe"])
	{
		$new_start_universe = mktime(0, 0, 0, $_POST["month_start_universe"], $_POST["day_start_universe"], $_POST["year_start_universe"]);
		$new_config_size_initial = str_replace(" ", "", $_POST["config_size_initial"]);
		$new_config_size_courant = str_replace(" ", "", $_POST["config_size_courant"]);
		$new_config_size_basic = str_replace(" ", "", $_POST["config_size_basic"]);
		$new_config_size_normal = str_replace(" ", "", $_POST["config_size_normal"]);
		$new_config_size_avance = str_replace(" ", "", $_POST["config_size_avance"]);
		$new_config_size_stratege = str_replace(" ", "", $_POST["config_size_stratege"]);
		$new_end_initial_solo = mktime(0, 0, 0, $_POST["month_config_end_initial_solo"], $_POST["day_config_end_initial_solo"], $_POST["year_config_end_initial_solo"]);
		$new_end_initial_groupe = mktime(0, 0, 0, $_POST["month_config_end_initial_groupe"], $_POST["day_config_end_initial_groupe"], $_POST["year_config_end_initial_groupe"]);
		$new_end_courant_solo = mktime(0, 0, 0, $_POST["month_config_end_courant_solo"], $_POST["day_config_end_courant_solo"], $_POST["year_config_end_courant_solo"]);
		$new_end_courant_groupe = mktime(0, 0, 0, $_POST["month_config_end_courant_groupe"], $_POST["day_config_end_courant_groupe"], $_POST["year_config_end_courant_groupe"]);
		$new_end_basic_solo = mktime(0, 0, 0, $_POST["month_config_end_basic_solo"], $_POST["day_config_end_basic_solo"], $_POST["year_config_end_basic_solo"]);
		$new_end_basic_groupe = mktime(0, 0, 0, $_POST["month_config_end_basic_groupe"], $_POST["day_config_end_basic_groupe"], $_POST["year_config_end_basic_groupe"]);
		$new_end_normal_solo = mktime(0, 0, 0, $_POST["month_config_end_normal_solo"], $_POST["day_config_end_normal_solo"], $_POST["year_config_end_normal_solo"]);
		$new_end_normal_groupe = mktime(0, 0, 0, $_POST["month_config_end_normal_groupe"], $_POST["day_config_end_normal_groupe"], $_POST["year_config_end_normal_groupe"]);
		$new_end_avance_solo = mktime(0, 0, 0, $_POST["month_config_end_avance_solo"], $_POST["day_config_end_avance_solo"], $_POST["year_config_end_avance_solo"]);
		$new_end_avance_groupe = mktime(0, 0, 0, $_POST["month_config_end_avance_groupe"], $_POST["day_config_end_avance_groupe"], $_POST["year_config_end_avance_groupe"]);
		$new_end_stratege_solo = mktime(0, 0, 0, $_POST["month_config_end_stratege_solo"], $_POST["day_config_end_stratege_solo"], $_POST["year_config_end_stratege_solo"]);
		$new_end_stratege_groupe = mktime(0, 0, 0, $_POST["month_config_end_stratege_groupe"], $_POST["day_config_end_stratege_groupe"], $_POST["year_config_end_stratege_groupe"]);
		
		post_config ($new_start_universe, $new_config_size_initial, $new_config_size_courant, $new_config_size_basic, $new_config_size_normal, $new_config_size_avance, $new_config_size_stratege, $new_end_initial_solo, $new_end_initial_groupe, $new_end_courant_solo, $new_end_courant_groupe, $new_end_basic_solo, $new_end_basic_groupe, $new_end_normal_solo, $new_end_normal_groupe, $new_end_avance_solo, $new_end_avance_groupe, $new_end_stratege_solo, $new_end_stratege_groupe);
	
	}

if ($_POST["set_historique"])
	{
		set_historique($font_historique = $_POST["set_font_historique"], $font_size = $_POST["set_font_size"], $largeur_historique = $_POST["set_largeur_historique"], $hauteur_historique = $_POST["set_hauteur_historique"], $pos_horiz_historique_1 = $_POST["set_pos_horiz_historique_1"], $pos_horiz_historique_2 = $_POST["set_pos_horiz_historique_2"], $pos_horiz_historique_3 = $_POST["set_pos_horiz_historique_3"], $pos_horiz_historique_4 = $_POST["set_pos_horiz_historique_4"], $pos_horiz_historique_5 = $_POST["set_pos_horiz_historique_5"], $color_txt_historique_1 = $_POST["set_color_txt_1_RGB"], $color_txt_historique_2 = $_POST["set_color_txt_2_RGB"], $color_txt_historique_3 = $_POST["set_color_txt_3_RGB"], $color_txt_historique_4 = $_POST["set_color_txt_4_RGB"], $color_txt_historique_5 = $_POST["set_color_txt_5_RGB"], $pos_verti_historique = $_POST["set_pos_verti_historique"], $angle_historique = $_POST["set_angle_historique"]);
	}
// On définie le skin
$skin= select_skin(0);

// On récupère la configuration des couleurs par défaut
$query_RCcolor = $db->sql_query("SELECT id,title, pt, gt, cle, clo, cr, vb, vc, rec, se, bmd, dst, edlm, tra, sat, lm, lleger, llourd, cg, ai, lp, pb, gb, ally, player_att, player_def,  techno, detruit, ressources_piller_min, ressources_piller_max, pertes_fleet_def, seuil_pertes, seuil_pillage, seuil_cdr, pertes_min_att, pertes_max_att, pertes_min_def, pertes_max_def, debris_min, debris_max, renta_min, renta_max FROM ".TABLE_HOFRC_SKIN." WHERE title='".$skin."'");
list($id,$title, $color_PT, $color_GT, $color_CLE, $color_CLO, $color_CR, $color_VB, $color_VC, $color_REC, $color_SE, $color_BMD, $color_DST, $color_EDLM, $color_TRA, $color_SAT, $color_LM, $color_LLEGER, $color_LLOURD, $color_CG, $color_AI, $color_LP, $color_PB, $color_GB, $color_PLAYER_ATT, $color_PLAYER_DEF, $color_ALLY, $color_TECHNO, $color_DETRUIT, $color_RESSOURCES_PILLER_MIN, $color_RESSOURCES_PILLER_MAX, $color_PERTES_FLEET_DEF, $color_SEUIL_PERTES, $color_SEUIL_PILLAGE, $color_SEUIL_CDR,$color_PERTES_MIN_ATT, $color_PERTES_MAX_ATT, $color_PERTES_MIN_DEF, $color_PERTES_MAX_DEF, $color_DEBRIS_MIN, $color_DEBRIS_MAX, $color_RENTA_MIN, $color_RENTA_MAX) = $db->sql_fetch_row($query_RCcolor);

// On récupère les configurations de l'univers
			$query_config = "select * from " . TABLE_HOFRC_CONFIG;
			$result_config = mysql_query($query_config);
	
			while (list($config_name, $config_value) = mysql_fetch_row($result_config)) 
				{
					$hofrc_config[$config_name] = stripslashes($config_value);
				}
			$font_historique = $hofrc_config["font_historique"];
			$font_size = $hofrc_config["font_size_historique"];
			$largeur_historique = $hofrc_config["largeur_historique"];
			$hauteur_historique = $hofrc_config["hauteur_historique"];
			$angle_historique = $hofrc_config["angle_historique"];
			$pos_horiz_historique_1 = $hofrc_config["pos_horiz_historique_1"];
			$pos_horiz_historique_2 = $hofrc_config["pos_horiz_historique_2"];
			$pos_horiz_historique_3 = $hofrc_config["pos_horiz_historique_3"];
			$pos_horiz_historique_4 = $hofrc_config["pos_horiz_historique_4"];
			$pos_horiz_historique_5 = $hofrc_config["pos_horiz_historique_5"];
			$color_txt_1_RGB = $hofrc_config["color_txt_historique_1"];
			$color_txt_2_RGB = $hofrc_config["color_txt_historique_2"];
			$color_txt_3_RGB = $hofrc_config["color_txt_historique_3"];
			$color_txt_4_RGB = $hofrc_config["color_txt_historique_4"];
			$color_txt_5_RGB = $hofrc_config["color_txt_historique_5"];
			$pos_verti_historique = $hofrc_config["pos_verti_historique"];
			$day_start_universe = strftime("%d",$hofrc_config["start_universe"]);
			$month_start_universe = strftime("%m",$hofrc_config["start_universe"]);
			$year_start_universe = strftime("%Y",$hofrc_config["start_universe"]);
			$config_size_initial = number_format($hofrc_config["size_initial"],0, ',', ' ');
			$config_size_courant = number_format($hofrc_config["size_courant"],0, ',', ' ');
			$config_size_basic = number_format($hofrc_config["size_basic"],0, ',', ' ');
			$config_size_normal = number_format($hofrc_config["size_normal"],0, ',', ' ');
			$config_size_avance = number_format($hofrc_config["size_avance"],0, ',', ' ');
			$config_size_stratege = number_format($hofrc_config["size_stratege"],0, ',', ' ');
			$day_config_end_initial_solo = date("j",$hofrc_config["end_initial_solo"]);
			$month_config_end_initial_solo = date("m",$hofrc_config["end_initial_solo"]);
			$year_config_end_initial_solo = date("Y",$hofrc_config["end_initial_solo"]);
			$day_config_end_initial_groupe = date("j",$hofrc_config["end_initial_groupe"]);
			$month_config_end_initial_groupe = date("m",$hofrc_config["end_initial_groupe"]);
			$year_config_end_initial_groupe = date("Y",$hofrc_config["end_initial_groupe"]);
			$day_config_end_courant_solo = date("j",$hofrc_config["end_courant_solo"]);
			$month_config_end_courant_solo = date("m",$hofrc_config["end_courant_solo"]);
			$year_config_end_courant_solo = date("Y",$hofrc_config["end_courant_solo"]);
			$day_config_end_courant_groupe = date("j",$hofrc_config["end_courant_groupe"]);
			$month_config_end_courant_groupe = date("m",$hofrc_config["end_courant_groupe"]);
			$year_config_end_courant_groupe = date("Y",$hofrc_config["end_courant_groupe"]);
			$day_config_end_basic_solo = date("j",$hofrc_config["end_basic_solo"]);
			$month_config_end_basic_solo = date("m",$hofrc_config["end_basic_solo"]);
			$year_config_end_basic_solo = date("Y",$hofrc_config["end_basic_solo"]);
			$day_config_end_basic_groupe = date("j",$hofrc_config["end_basic_groupe"]);
			$month_config_end_basic_groupe = date("m",$hofrc_config["end_basic_groupe"]);
			$year_config_end_basic_groupe = date("Y",$hofrc_config["end_basic_groupe"]);
			$day_config_end_normal_solo = date("j",$hofrc_config["end_normal_solo"]);
			$month_config_end_normal_solo = date("m",$hofrc_config["end_normal_solo"]);
			$year_config_end_normal_solo = date("Y",$hofrc_config["end_normal_solo"]);
			$day_config_end_normal_groupe = date("j",$hofrc_config["end_normal_groupe"]);
			$month_config_end_normal_groupe = date("m",$hofrc_config["end_normal_groupe"]);
			$year_config_end_normal_groupe = date("Y",$hofrc_config["end_normal_groupe"]);
			$day_config_end_avance_solo = date("j",$hofrc_config["end_avance_solo"]);
			$month_config_end_avance_solo = date("m",$hofrc_config["end_avance_solo"]);
			$year_config_end_avance_solo = date("Y",$hofrc_config["end_avance_solo"]);
			$day_config_end_avance_groupe = date("j",$hofrc_config["end_avance_groupe"]);
			$month_config_end_avance_groupe = date("m",$hofrc_config["end_avance_groupe"]);
			$year_config_end_avance_groupe = date("Y",$hofrc_config["end_avance_groupe"]);
			$day_config_end_stratege_solo = date("j",$hofrc_config["end_stratege_solo"]);
			$month_config_end_stratege_solo = date("m",$hofrc_config["end_stratege_solo"]);
			$year_config_end_stratege_solo = date("Y",$hofrc_config["end_stratege_solo"]);
			$day_config_end_stratege_groupe = date("j",$hofrc_config["end_stratege_groupe"]);
			$month_config_end_stratege_groupe = date("m",$hofrc_config["end_stratege_groupe"]);
			$year_config_end_stratege_groupe = date("Y",$hofrc_config["end_stratege_groupe"]);
?>


<table align="center" width="100%" cellpadding="0" cellspacing="1">
	
<!-- CONFIGURATION GENERAL -->
	<tr>
		<td class="c" colspan="4">Configuration générale</td>
	</tr>
	<tr>
		<th colspan="2">		
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Configuration de l'univers</u></font>
					</b>
				</legend>
				<p align='left'>
					<form style="text-align:right;" method="POST" action="index.php?action=hofrc&subaction=admin" name="config">
						<span style="text-align:center";><a align="center">Début de l'univers : </a><input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_start_universe;?>" name="day_start_universe" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_start_universe;?>" name="month_start_universe" /> / <input style="width: 40px; text-align: center;" type="text" value="<?php echo $year_start_universe;?>" name="year_start_universe" /></span><br><br>
							<a style="margin-right:82px;">CDR en solo</a><a style="text-align:right; margin-right:20px">CDR en groupé</a><br>
							<!-- Configuration INITIAL SOLO -->
							<a>CDR Initial :</a> <input style="width: 20%; text-align: center;" type="text" value="<?php echo $config_size_initial;?>" name="config_size_initial" /> de débris.
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_initial_solo;?>" name="day_config_end_initial_solo" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_initial_solo;?>" name="month_config_end_initial_solo" /> / <input style="width: 40px; text-align: center; margin-right:50px" type="text" value="<?php echo $year_config_end_initial_solo;?>" name="year_config_end_initial_solo" />
							<!-- Configuration INITIAL GROUPE -->
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_initial_groupe;?>" name="day_config_end_initial_groupe" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_initial_groupe;?>" name="month_config_end_initial_groupe" /> / <input style="width: 40px; text-align: center; margin-right:10px" type="text" value="<?php echo $year_config_end_initial_groupe;?>" name="year_config_end_initial_groupe" /><br>
							<!-- Configuration COURANT SOLO -->
							<a>CDR Courant : </a><input style="width: 20%; text-align: center;" type="text" value="<?php echo $config_size_courant;?>" name="config_size_courant" /> de débris.
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_courant_solo;?>" name="day_config_end_courant_solo" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_courant_solo;?>" name="month_config_end_courant_solo" /> / <input style="width: 40px; text-align: center; margin-right:50px;" type="text" value="<?php echo $year_config_end_courant_solo;?>" name="year_config_end_courant_solo" />
							<!-- Configuration COURANT GROUPE -->
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_courant_groupe;?>" name="day_config_end_courant_groupe" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_courant_groupe;?>" name="month_config_end_courant_groupe" /> / <input style="width: 40px; text-align: center; margin-right:10px;" type="text" value="<?php echo $year_config_end_courant_groupe;?>" name="year_config_end_courant_groupe" /><br>
							<!-- Configuration BASIC SOLO -->
							<a>CDR Basic : </a><input style="width: 20%; text-align: center;" type="text" value="<?php echo $config_size_basic;?>" name="config_size_basic" /> de débris.
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_basic_solo;?>" name="day_config_end_basic_solo" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_basic_solo;?>" name="month_config_end_basic_solo" /> / <input style="width: 40px; text-align: center; margin-right:50px;" type="text" value="<?php echo $year_config_end_basic_solo;?>" name="year_config_end_basic_solo" />
							<!--Configuration BASIC GROUPE -->
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_basic_groupe;?>" name="day_config_end_basic_groupe" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_basic_groupe;?>" name="month_config_end_basic_groupe" /> / <input style="width: 40px; text-align: center; margin-right:10px;" type="text" value="<?php echo $year_config_end_basic_groupe;?>" name="year_config_end_basic_groupe" /><br>
							<!-- Configuration NORMAL SOLO -->
							<a>CDR Normal : </a><input style="width: 20%; text-align: center;" type="text" value="<?php echo $config_size_normal;?>" name="config_size_normal" /> de débris.
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_normal_solo;?>" name="day_config_end_normal_solo" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_normal_solo;?>" name="month_config_end_normal_solo" /> / <input style="width: 40px; text-align: center; margin-right:50px;" type="text" value="<?php echo $year_config_end_normal_solo;?>" name="year_config_end_normal_solo" />
							<!--Configuration NORMAL GROUPE -->
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_normal_groupe;?>" name="day_config_end_normal_groupe" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_normal_groupe;?>" name="month_config_end_normal_groupe" /> / <input style="width: 40px; text-align: center; margin-right:10px;" type="text" value="<?php echo $year_config_end_normal_groupe;?>" name="year_config_end_normal_groupe" /><br>
							<!-- Configuration AVANCE SOLO -->
							<a>CDR Avancé <?php echo infobulle("Permet de désactivé les hofs avancés sur certains univers.");?>: </a><input style="width: 20%; text-align: center;" type="text" value="<?php echo $config_size_avance;?>" name="config_size_avance" /> de débris.
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_avance_solo;?>" name="day_config_end_avance_solo" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_avance_solo;?>" name="month_config_end_avance_solo" /> / <input style="width: 40px; text-align: center; margin-right:50px;" type="text" value="<?php echo $year_config_end_avance_solo;?>" name="year_config_end_avance_solo" />
							<!-- Configuration AVANCE GROUPE -->
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_avance_groupe;?>" name="day_config_end_avance_groupe" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_avance_groupe;?>" name="month_config_end_avance_groupe" /> / <input style="width: 40px; text-align: center; margin-right:10px;" type="text" value="<?php echo $year_config_end_avance_groupe;?>" name="year_config_end_avance_groupe" /></br>
							<!-- Configuration STRATEGE SOLO -->
							<a>CDR Stratège <?php echo infobulle("Permet de désactivé les hofs avancés sur certains univers.");?>: </a><input style="width: 20%; text-align: center;" type="text" value="<?php echo $config_size_stratege;?>" name="config_size_stratege" /> de débris.
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_stratege_solo;?>" name="day_config_end_stratege_solo" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_stratege_solo;?>" name="month_config_end_stratege_solo" /> / <input style="width: 40px; text-align: center; margin-right:50px;" type="text" value="<?php echo $year_config_end_stratege_solo;?>" name="year_config_end_stratege_solo" />
							<!-- Configuration STRATEGE GROUPE -->
							<input style="width: 20px; text-align: center;" type="text" value="<?php echo $day_config_end_stratege_groupe;?>" name="day_config_end_stratege_groupe" /> / <input style="width: 20px; text-align: center;" type="text" value="<?php echo $month_config_end_stratege_groupe;?>" name="month_config_end_stratege_groupe" /> / <input style="width: 40px; text-align: center; margin-right:10px;" type="text" value="<?php echo $year_config_end_stratege_groupe;?>" name="year_config_end_stratege_groupe" /></br></br>
						
							<input align="center" type="submit" name="config_universe" value="Envoyer">
					</form>
				</p>
			</fieldset>
		</th>
		<th>
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Création d'un nouveau skin</u></font>
					</b>
				</legend>
				<p align='left'>
					<form method="POST" action="index.php?action=hofrc&subaction=admin" name="create_skin">
						Créer un skin: <input style="width: 40%;" type="text" name="new_skin" id="new_skin" maxlength="20"><br><br>
																	<!-- VALIDATION DES PARAMETRES -->
						<input type="submit" name="create_skin" value="Envoyer">
					</form>
				</p>
			</fieldset>
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Sélection d'un skin</u></font>
					</b>
				</legend>
				<p align='left'>
					<form method="POST" action="index.php?action=hofrc&subaction=admin" name="select_use_skin">
						Sélection du skin: 
							<SELECT style="width: 40%;" name ="list_skin" value="" >
								<?php
									$query_skin = $db->sql_query("SELECT `title` FROM `".TABLE_HOFRC_SKIN."` ORDER BY `title` ASC");
										while ($query_select_skin = $db->sql_fetch_row($query_skin)) 	
											{
												echo "<option name = '".$query_select_skin[0]."' value='".$query_select_skin[0]."'";
												if($skin == $query_select_skin[0]) echo "selected='selected'";
												echo ">".$query_select_skin[0]."</option>";
											}
								?>
							</select>
															<!-- VALIDATION DES PARAMETRES -->
						<br><br><center><input type="submit" name="select_use_skin" value="Envoyer"></center>
					</form>
				</p>
			</fieldset>
		</th>
		<th>
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Upload des images</u></font>
					</b>
				</legend>
				<p align='left'>
					<table>
						<form method="post" enctype="multipart/form-data" action="index.php?action=hofrc&subaction=admin">
							<tr>
								<th width="220px">
									<!-- On limite le fichier à 300Ko -->
									Image :<?php echo infobulle("Les différents fichier doivent avoir comme nom:<br>- header <br>- round <br>- separator <br>- result <br>- background<br>Les seuls fichier accepter sont des gif, jpg et png.");?> <input type="file" name="picture"></br></br>
								</th>	
								<th style="text-align:left;">
									<input type="radio" name="PIC" value="PIC_HEADER">Entête<br>
									<input type="radio" name="PIC" value="PIC_ROUND">Round<br>
									<input type="radio" name="PIC" value="PIC_SEPARATOR">Séparation<br>
									<input type="radio" name="PIC" value="PIC_RESULT">Résultat<br>
									<input type="radio" name="PIC" value="PIC_BACKGROUND">Arrière-Plan<br>
									<input type="radio" name="PIC" value="PIC_HISTORIQUE">Historique<br>
								</th>
							</tr>
							<tr>
								<th  colspan="2">
									<input type="submit" name="upload" value="Envoyer l'image">
								</th>
							</tr>
						</form>
					</table>
				</p>
			</fieldset>
		</th>
	</tr>
	<tr>
		<td class="c" colspan="4">Affichage des images et police disponible</td>
	</tr>
		<th>
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Listes des Polices du skin <?php echo $skin; ?></u></font>
					</b>
				</legend>
				<p align='left'>
					
						 <?php list_font();?>
						 
				</p>
			</fieldset>
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Ratio pour visualier les images</u></font>
					</b>
				</legend>
				<p align='left'>
					<form method="POST" action="index.php?action=hofrc&subaction=admin" name="rate">
						Ratio: <input type="text" name="rate_resize" value="<?php $rate_resize = rate_resizing(0); echo($rate_resize);?>" id="new_skin" maxlength="20">%<br />
																	<!-- VALIDATION DES PARAMETRES -->
						<br><center><input type="submit" name="rate" value="Envoyer"></center>
					</form>											
				</p>
			</fieldset>
		</th>
		<th colspan="3">
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Images du skin <?php echo $skin; ?></u></font>
					</b>
				</legend>
				<p align='left'>
					<table>
					<?php
				// Génération de la liste des fonds disponible
				$background = get_background_tab($skin);

				// Limite à 5 images/lignes sinon au nombre d'images
				$back_per_ligne = ($x=count($background)<$back_per_ligne)?$x:5;
				$count=0;
				foreach($background as $key => $fichier)
					{
						// Si c'est la 1ere image de la ligne, on affiche le <tr>
						$count++;
						if($count==1) echo "<tr>";
							
								?>
								<th align="center">
								<?php 
								list ($width, $height, $type, $attr) = getimagesize("mod/hofrc/Skin/".$skin."/"."/".$fichier);
								$new_width = image_resizing($width);
								$new_height = image_resizing($height);
								?>
									<a href="<?php echo "mod/hofrc/Skin/".$skin."/".$fichier;?>">
									<img src="<?php echo "mod/hofrc/Skin/".$skin."/".$fichier; ?>" width="<?php echo $new_width;?>" height="<?php echo $new_height;?>"><br/>
									</a>
									<?php echo $fichier; ?></br>
									
									<?php
										// Récupération et affichage des dimensions de l'image
										list($width, $height, $type, $attr) = getimagesize("mod/hofrc/Skin/".$skin."/"."/".$fichier);
										echo "(".$width."x".$height.")";
												?>
								</th>
<?php										// Si c'est la dernière image de la ligne, on affiche le </tr>
										if($count==$back_per_ligne) 
											{
												echo"</tr>";
												$count = 0;
											}
										
					}		
						// Combien il restait de case pour finir la ligne? On ne rempli avec du vide
						if($count!=0)
							{
								?>
									<td style="border:0;" class="d" colspan="<?php echo $back_per_page-$count; ?>">
									&nbsp
									</td>
								</tr>
									<?php
							}
					
					?></table>
					</p>
			</fieldset>
		</th>
	<tr>
		<td class="c" colspan="4">Configuration de l'historique</td>
	</tr>
	<tr>
		<th colspan="2">
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Générales</u></font>
					</b>
				</legend>
					<p align='left'>
						<form method="POST" action="index.php?action=hofrc&subaction=admin&id=<?php echo $id ?>" name="set_historique">
							Police: Choix:	
							<SELECT style="width: 40%;" name ="set_font_historique" value="" >
							<?php
							$folder = "mod/hofrc/Font";
							if ($list = opendir($folder))
								{
									while (false !== ($file = readdir($list)))
										{
											if($file != "."&&$file!=".."&&!is_dir($folder.$file))
												{
													echo "<option name = '".$files."' value='".$file."'";
													if($font_historique == $file) echo "selected='selected'";
													echo ">".$file."</option>";
												}
										}
									closedir($list);
								}
							?>
							</select>
							Taille: <input type="text" name="set_font_size" id="set_font_size" value="<?php if (!empty($font_size)==TRUE) echo $font_size; else echo 'Taille de la police'; ?>" maxlength="20">
							<br />
							Image: Largeur: <input type="text" name="set_largeur_historique" id="set_largeur_historique" value="<?php if (!empty($largeur_historique)==TRUE) echo $largeur_historique; else echo 'Largeur de l\'image'; ?>" maxlength="20">
							Hauteur: <input type="text" name="set_hauteur_historique" id="set_hauteur_historique" value="<?php if (!empty($hauteur_historique)==TRUE) echo $hauteur_historique; else echo 'Hauteur de l\'image'; ?>" maxlength="20">
							<br />
							Texte: Position Verticale: <input type="text" name="set_pos_verti_historique" id="set_pos_verti_historique" value="<?php if (!empty($pos_verti_historique)==TRUE) echo $pos_verti_historique; else echo 'Pos. vert. txt'; ?>" maxlength="20">
							Angle: <input type="text" name="set_angle_historique" id="set_angle_historique" value="<?php if (!empty($angle_historique)==TRUE) echo $angle_historique; else echo '0'; ?>" maxlength="20">
							<br />
							Texte 1: Position horizontale: <input type="text" name="set_pos_horiz_historique_1" id="set_pos_horiz_historique_1" value="<?php if (!empty($pos_horiz_historique_1)==TRUE) echo $pos_horiz_historique_1; else echo 'Pos. Horiz. txt 1'; ?>" maxlength="20">
							Couleur: <input type="text" name="set_color_txt_1_RGB" id="set_color_txt_1_RGB" value="<?php if (!empty($color_txt_1_RGB)==TRUE) echo $color_txt_1_RGB; else echo 'X,XX,XXX'; ?>" maxlength="20">
							<br />
							Texte 2: Position horizontale: <input type="text" name="set_pos_horiz_historique_2" id="set_pos_horiz_historique_2" value="<?php if (!empty($pos_horiz_historique_2)==TRUE) echo $pos_horiz_historique_2; else echo 'Pos. Horiz. txt 2'; ?>" maxlength="20">
							Couleur: <input type="text" name="set_color_txt_2_RGB" id="set_color_txt_2_RGB" value="<?php if (!empty($color_txt_2_RGB)==TRUE) echo $color_txt_2_RGB; else echo 'X,XX,XXX'; ?>" maxlength="20">
							<br />
							Texte 3: Position horizontale: <input type="text" name="set_pos_horiz_historique_3" id="set_pos_horiz_historique_3" value="<?php if (!empty($pos_horiz_historique_3)==TRUE) echo $pos_horiz_historique_3; else echo 'Pos. Horiz. txt 3'; ?>" maxlength="20">
							Couleur: <input type="text" name="set_color_txt_3_RGB" id="set_color_txt_3_RGB" value="<?php if (!empty($color_txt_3_RGB)==TRUE) echo $color_txt_3_RGB; else echo 'X,XX,XXX'; ?>" maxlength="20">
							<br />
							Texte 4: Position horizontale: <input type="text" name="set_pos_horiz_historique_4" id="set_pos_horiz_historique_4" value="<?php if (!empty($pos_horiz_historique_4)==TRUE) echo $pos_horiz_historique_4; else echo 'Pos. Horiz. txt 4'; ?>" maxlength="20">
							Couleur: <input type="text" name="set_color_txt_4_RGB" id="set_color_txt_4_RGB" value="<?php if (!empty($color_txt_4_RGB)==TRUE) echo $color_txt_4_RGB; else echo 'X,XX,XXX'; ?>" maxlength="20">
							<br />
							Texte 5: Position horizontale: <input type="text" name="set_pos_horiz_historique_5" id="set_pos_horiz_historique_5" value="<?php if (!empty($pos_horiz_historique_5)==TRUE) echo $pos_horiz_historique_5; else echo 'Pos. Horiz. txt 5'; ?>" maxlength="20">
							Couleur: <input type="text" name="set_color_txt_5_RGB" id="set_color_txt_5_RGB" value="<?php if (!empty($color_txt_5_RGB)==TRUE) echo $color_txt_5_RGB; else echo 'X,XX,XXX'; ?>" maxlength="20">
							<!-- VALIDATION DES PARAMETRES -->
						<br><center><input type="reset" name="Submit" value="Réinitialiser le formulaire"> <input type="submit" name="set_historique" value="Envoyer"></center>
					</form>
					</p>
			</fieldset>
		</th>
		<th colspan="2">
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Aperçu de l'historique</u></font>
					</b>
				</legend>
				<?php
				$source = imagecreatefromjpeg("mod/hofrc/Skin/".$skin."/historique.jpg");
				$preview = "mod/hofrc/Output/temporaire.png";
				$font = "mod/hofrc/Font/".$font_historique;
				
				$color_txt_1 = explode(",",$color_txt_1_RGB);
				$color_txt_2 = explode(",",$color_txt_2_RGB);
				$color_txt_3 = explode(",",$color_txt_3_RGB);
				$color_txt_4 = explode(",",$color_txt_4_RGB);
				$color_txt_5 = explode(",",$color_txt_5_RGB);
				
				$destination  = imagecreatetruecolor($largeur_historique, $hauteur_historique) or die ("Impossible de crée un flux d'image GD");
			
				$txt_1 = imagecolorallocate($destination, $color_txt_1[0], $color_txt_1[1], $color_txt_1[2]);
				$txt_2 = imagecolorallocate($destination, $color_txt_2[0], $color_txt_2[1], $color_txt_2[2]);
				$txt_3 = imagecolorallocate($destination, $color_txt_3[0], $color_txt_3[1], $color_txt_3[2]);
				$txt_4 = imagecolorallocate($destination, $color_txt_4[0], $color_txt_4[1], $color_txt_4[2]);
				$txt_5 = imagecolorallocate($destination, $color_txt_5[0], $color_txt_5[1], $color_txt_5[2]);
					
				// image - taille font - angle - horizontal - verticale
				$text1 = "1";
				$text2 = "-";
				$text3 = "LEGENDAIRE";
				$text4 = "-";
				$text5 = "Titre du RP";
				// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
				$largeur_source = imagesx($source);
				$hauteur_source = imagesy($source);
				$largeur_destination = imagesx($destination);
				$hauteur_destination = imagesy($destination);
				
				imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
				putenv('GDFONTPATH=' . realpath('.'));
				imagettftext($destination, $font_size, $angle_historique, $pos_horiz_historique_1, $pos_verti_historique, $txt_1, $font, $text1);
				imagettftext($destination, $font_size, $angle_historique, $pos_horiz_historique_2, $pos_verti_historique, $txt_2, $font, $text2);
				imagettftext($destination, $font_size, $angle_historique, $pos_horiz_historique_3, $pos_verti_historique, $txt_3, $font, $text3);
				imagettftext($destination, $font_size, $angle_historique, $pos_horiz_historique_4, $pos_verti_historique, $txt_4, $font, $text4);
				imagettftext($destination, $font_size, $angle_historique, $pos_horiz_historique_5, $pos_verti_historique, $txt_5, $font, $text5);
				imagepng($destination,$preview);
				imagedestroy($destination);
				
				?>
				<?php echo '<br><img src="'.$preview.'" alt="'.$preview.'" /><br><br>';?>
			</fieldset>
		</th>
	</tr>
	<tr>
		<td class="c" colspan="4">Paramétrage des couleurs du Rapport de Combat</td>
	</tr>
		<th>
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Générales</u></font>
					</b>
				</legend>
				<p align='left'>
					<form method="POST" action="index.php?action=hofrc&subaction=admin&id=<?php echo $id ?>" name="color">
						Titre du Skin:	<input type="text" name="set_title" id="set_title" value="<?php if (!empty($title)==TRUE) echo $title; else echo 'temporaire'; ?>" maxlength="20"><br />

						Nom du joueur Attaquant:	<input type="radio" name="position_color_picker" id="position_color_picker_player_att" checked="checked">
						<input type="text" name="couleur_player_att" id="couleur_player_att" value="<?php if (!empty($color_PLAYER_ATT)==TRUE) echo $color_PLAYER_ATT; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_player_att').style.color=this.value;" maxlength="6"><br />

						Nom du joueur Défenseur:	<input type="radio" name="position_color_picker" id="position_color_picker_player_def" checked="checked">
						<input type="text" name="couleur_player_def" id="couleur_player_def" value="<?php if (!empty($color_PLAYER_DEF)==TRUE) echo $color_PLAYER_DEF; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_player_def').style.color=this.value;" maxlength="6"><br />

						Alliance:	<input type="radio" name="position_color_picker" id="position_color_picker_ally" checked="checked">
						<input type="text" name="couleur_ally" id="couleur_ally" value="<?php if (!empty($color_ALLY)==TRUE) echo $color_ALLY; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_ally').style.color=this.value;" maxlength="6"><br />
	
						Technologie:<input type="radio" name="position_color_picker" id="position_color_picker_techno" checked="checked">
						<input type="text" name="couleur_techno" id="couleur_techno" value="<?php if (!empty($color_TECHNO)==TRUE) echo $color_TECHNO; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_techno').style.color=this.value;" maxlength="6"><br />
				
				</p>
			</fieldset>
		
		
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Divers</u></font>
					</b>
				</legend>
				<p align='left'>
					Détruit: <input type="radio" name="position_color_picker" id="position_color_picker_detruit" checked="checked">
					<input type="text" name="couleur_detruit" id="couleur_detruit" value="<?php if (!empty($color_DETRUIT)==TRUE) echo $color_DETRUIT; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_detruit').style.color=this.value;" maxlength="6"><br /> 
		
					Ressources Piller Minimum: <input type="radio" name="position_color_picker" id="position_color_picker_ressources_piller_min" checked="checked">
					<input type="text" name="couleur_ressources_piller_min" id="couleur_ressources_piller_min" value="<?php if (!empty($color_RESSOURCES_PILLER_MIN)==TRUE) echo $color_RESSOURCES_PILLER_MIN; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_ressources_piller_min').style.color=this.value;" maxlength="6"><br />
		
					Ressources Piller Maximum: <input type="radio" name="position_color_picker" id="position_color_picker_ressources_piller_max" checked="checked">
					<input type="text" name="couleur_ressources_piller_max" id="couleur_ressources_piller_max" value="<?php if (!empty($color_RESSOURCES_PILLER_MAX)==TRUE) echo $color_RESSOURCES_PILLER_MAX; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_ressources_piller_max').style.color=this.value;" maxlength="6"><br />
		
					Pertes des Flottes et Défences: <input type="radio" name="position_color_picker" id="position_color_picker_pertes_fleet_def" checked="checked">
					<input type="text" name="couleur_pertes_fleet_def" id="couleur_pertes_fleet_def" value="<?php if (!empty($color_PERTES_FLEET_DEF)==TRUE) echo $color_PERTES_FLEET_DEF; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_pertes_fleet_def').style.color=this.value;" maxlength="6"><br />
		
					Pertes Minimum Attaque: <input type="radio" name="position_color_picker" id="position_color_picker_pertes_min_att" checked="checked">
					<input type="text" name="couleur_pertes_min_att" id="couleur_pertes_min_att" value="<?php if (!empty($color_PERTES_MIN_ATT)==TRUE) echo $color_PERTES_MIN_ATT; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_pertes_min_att').style.color=this.value;" maxlength="6"><br />
		
					Pertes Maximum Attaque: <input type="radio" name="position_color_picker" id="position_color_picker_pertes_max_att" checked="checked">
					<input type="text" name="couleur_pertes_max_att" id="couleur_pertes_max_att" value="<?php if (!empty($color_PERTES_MAX_ATT)==TRUE) echo $color_PERTES_MAX_ATT; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_pertes_max_att').style.color=this.value;" maxlength="6"><br />
		
					Pertes Minimum Défense: <input type="radio" name="position_color_picker" id="position_color_picker_pertes_min_def" checked="checked">
					<input type="text" name="couleur_pertes_min_def" id="couleur_pertes_min_def" value="<?php if (!empty($color_PERTES_MIN_DEF)==TRUE) echo $color_PERTES_MIN_DEF; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_pertes_min_def').style.color=this.value;" maxlength="6"><br />
		
					Pertes Maximum Défense: <input type="radio" name="position_color_picker" id="position_color_picker_pertes_max_def" checked="checked">
					<input type="text" name="couleur_pertes_max_def" id="couleur_pertes_max_def" value="<?php if (!empty($color_PERTES_MAX_DEF)==TRUE) echo $color_PERTES_MAX_DEF; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_pertes_max_def').style.color=this.value;" maxlength="6"><br />
					Débris Minimum: <input type="radio" name="position_color_picker" id="position_color_picker_debris_min" checked="checked">
					<input type="text" name="couleur_debris_min" id="couleur_debris_min" value="<?php if (!empty($color_DEBRIS_MIN)==TRUE) echo $color_DEBRIS_MIN; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_debris_min').style.color=this.value;" maxlength="6"><br />
		 
					Débris Maximum: <input type="radio" name="position_color_picker" id="position_color_picker_debris_max" checked="checked">
					<input type="text" name="couleur_debris_max" id="couleur_debris_max" value="<?php if (!empty($color_DEBRIS_MAX)==TRUE) echo $color_DEBRIS_MAX; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_debris_max').style.color=this.value;" maxlength="6"><br />
		
					Rentabilité Minimum: <input type="radio" name="position_color_picker" id="position_color_picker_renta_min" checked="checked">
					<input type="text" name="couleur_renta_min" id="couleur_renta_min" value="<?php if (!empty($color_RENTA_MIN)==TRUE) echo $color_RENTA_MIN; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_renta_min').style.color=this.value;" maxlength="6"><br />
		
					Rentabilité Maximum: <input type="radio" name="position_color_picker" id="position_color_picker_renta_max" checked="checked">
					<input type="text" name="couleur_renta_max" id="couleur_renta_max" value="<?php if (!empty($color_RENTA_MAX)==TRUE) echo $color_RENTA_MAX; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_renta_max').style.color=this.value;" maxlength="6"><br />
				</p>
			</fieldset>	
			
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Seuil</u></font>
					</b>
				</legend>
				<p align='left'>	
					
						Seuil des pertes: <input type="text" name="couleur_seuil_pertes" id="couleur_seuil_pertes" value="<?php if (!empty($color_SEUIL_PERTES)==TRUE) echo $color_SEUIL_PERTES; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_seuil_pertes').style.color=this.value;" maxlength="6"><br />
		
						Seuil des pillages: <input type="text" name="couleur_seuil_pillage" id="couleur_seuil_pillage" value="<?php if (!empty($color_SEUIL_PILLAGE)==TRUE) echo $color_SEUIL_PILLAGE; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_seuil_pillage').style.color=this.value;" maxlength="6"><br />
		
						Seuil Champs de débris: <input type="text" name="couleur_seuil_cdr" id="couleur_seuil_cdr" value="<?php if (!empty($color_SEUIL_CDR)==TRUE) echo $color_SEUIL_CDR; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_seuil_cdr').style.color=this.value;" maxlength="6"><br />
		
				</p>
			</fieldset>

		</th>
		<th>
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Flottes</u></font>
					</b>
				</legend>
				<p align='left'>
					
						P.transporteur:<input type="radio" name="position_color_picker" id="position_color_picker_pt" checked="checked">
						<input type="text" name="couleur_pt" id="couleur_pt" value="<?php if (!empty($color_PT)==TRUE) echo $color_PT; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_pt').style.color=this.value;" maxlength="6"><br />
		
						G.transporteur:<input type="radio" name="position_color_picker" id="position_color_picker_gt" checked="checked">
						<input type="text" name="couleur_gt" id="couleur_gt" value="<?php if (!empty($color_GT)==TRUE) echo $color_PT; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_gt').style.color=this.value;" maxlength="6"><br />
		
						C.Léger<input type="radio" name="position_color_picker" id="position_color_picker_cle" checked="checked">
						<input type="text" name="couleur_cle" id="couleur_cle" value="<?php if (!empty($color_CLE)==TRUE) echo $color_CLE; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_cle').style.color=this.value;" maxlength="6"><br />
		
						C.Lourd<input type="radio" name="position_color_picker" id="position_color_picker_clo" checked="checked">
						<input type="text" name="couleur_clo" id="couleur_clo" value="<?php if (!empty($color_CLO)==TRUE) echo $color_CLO; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_clo').style.color=this.value;" maxlength="6"><br />
		
						Croiseur:<input type="radio" name="position_color_picker" id="position_color_picker_cr" checked="checked">
						<input type="text" name="couleur_cr" id="couleur_cr" value="<?php if (!empty($color_CR)==TRUE) echo $color_CR; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_cr').style.color=this.value;" maxlength="6"><br />
		
						V.Bataille:<input type="radio" name="position_color_picker" id="position_color_picker_vb" checked="checked">
						<input type="text" name="couleur_vb" id="couleur_vb" value="<?php if (!empty($color_VB)==TRUE) echo $color_VB; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_vb').style.color=this.value;" maxlength="6"><br />
		
						V.Colonisation:<input type="radio" name="position_color_picker" id="position_color_picker_vc" checked="checked">
						<input type="text" name="couleur_vc" id="couleur_vc" value="<?php if (!empty($color_VC)==TRUE) echo $color_VC; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_vc').style.color=this.value;" maxlength="6"><br />
		
						Recycleur:<input type="radio" name="position_color_picker" id="position_color_picker_rec" checked="checked">
						<input type="text" name="couleur_rec" id="couleur_rec" value="<?php if (!empty($color_REC)==TRUE) echo $color_REC; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_rec').style.color=this.value;" maxlength="6"><br />
		
						Sonde:<input type="radio" name="position_color_picker" id="position_color_picker_se" checked="checked">
						<input type="text" name="couleur_se" id="couleur_se" value="<?php if (!empty($color_SE)==TRUE) echo $color_SE; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_se').style.color=this.value;" maxlength="6"><br />
		
						Bombardier:<input type="radio" name="position_color_picker" id="position_color_picker_bmd" checked="checked">
						<input type="text" name="couleur_bmd" id="couleur_bmd" value="<?php if (!empty($color_BMD)==TRUE) echo $color_BMD; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_bmd').style.color=this.value;" maxlength="6"><br />
		
						S.Solaire: <input type="radio" name="position_color_picker" id="position_color_picker_sat" checked="checked">
						<input type="text" name="couleur_sat" id="couleur_sat" value="<?php if (!empty($color_SAT)==TRUE) echo $color_SAT; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_sat').style.color=this.value;" maxlength="6"><br />
		
						Destructeur: <input type="radio" name="position_color_picker" id="position_color_picker_dst" checked="checked">
						<input type="text" name="couleur_dst" id="couleur_dst" value="<?php if (!empty($color_DST)==TRUE) echo $color_DST; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_dst').style.color=this.value;" maxlength="6"><br />
		
						EDLM:<input type="radio" name="position_color_picker" id="position_color_picker_edlm" checked="checked">
						<input type="text" name="couleur_edlm" id="couleur_edlm" value="<?php if (!empty($color_EDLM)==TRUE) echo $color_EDLM; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_edlm').style.color=this.value;" maxlength="6"><br />
		
						Traqueur:<input type="radio" name="position_color_picker" id="position_color_picker_tra" checked="checked">
						<input type="text" name="couleur_tra" id="couleur_tra" value="<?php if (!empty($color_TRA)==TRUE) echo $color_TRA; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_tra').style.color=this.value;" maxlength="6"><br />
		
						
				</p>
			</fieldset>
			<fieldset>
				<legend>
					<b>
						<font color='#0080FF'><u>Défences</u></font>
					</b>
				</legend>
				<p align='left'>	
					
						L.Missile:<input type="radio" name="position_color_picker" id="position_color_picker_lm" checked="checked">
						<input type="text" name="couleur_lm" id="couleur_lm" value="<?php if (!empty($color_LM)==TRUE) echo $color_LM; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_lm').style.color=this.value;" maxlength="6"><br />
		
						L.Léger:<input type="radio" name="position_color_picker" id="position_color_picker_lleger" checked="checked">
						<input type="text" name="couleur_lleger" id="couleur_lleger" value="<?php if (!empty($color_LLEGER)==TRUE) echo $color_LLEGER; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_lleger').style.color=this.value;" maxlength="6"><br />
		
						L.Lourd:<input type="radio" name="position_color_picker" id="position_color_picker_llourd" checked="checked">
						<input type="text" name="couleur_llourd" id="couleur_llourd" value="<?php if (!empty($color_LLOURD)==TRUE) echo $color_LLOURD; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_llourd').style.color=this.value;" maxlength="6"><br />
		
						Can.Gauss:<input type="radio" name="position_color_picker" id="position_color_picker_cg" checked="checked">
						<input type="text" name="couleur_cg" id="couleur_cg" value="<?php if (!empty($color_CG)==TRUE) echo $color_CG; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_cg').style.color=this.value;" maxlength="6"><br />
		
						Art.Ions:<input type="radio" name="position_color_picker" id="position_color_picker_ai" checked="checked">
						<input type="text" name="couleur_ai" id="couleur_ai" value="<?php if (!empty($color_AI)==TRUE) echo $color_AI; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_ai').style.color=this.value;" maxlength="6"><br />
		
						Lanc.Plasma:<input type="radio" name="position_color_picker" id="position_color_picker_lp" checked="checked">
						<input type="text" name="couleur_lp" id="couleur_lp" value="<?php if (!empty($color_LP)==TRUE) echo $color_LP; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_lp').style.color=this.value;" maxlength="6"><br />
		
						P.Bouclier:<input type="radio" name="position_color_picker" id="position_color_picker_pb" checked="checked">
						<input type="text" name="couleur_pb" id="couleur_pb" value="<?php if (!empty($color_PB)==TRUE) echo $color_PB; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_pb').style.color=this.value;" maxlength="6"><br />
		
						G.Bouclier:<input type="radio" name="position_color_picker" id="position_color_picker_gb" checked="checked">
						<input type="text" name="couleur_gb" id="couleur_gb" value="<?php if (!empty($color_GB)==TRUE) echo $color_GB; else echo '000000'; ?>" onKeyUp="document.getElementById('preview_gb').style.color=this.value;" maxlength="6"><br />
			</fieldset>
		</th>
	
		
		<th colspan="2" rowspan=2>
			Les flottes suivantes se sont affrontées le: 28.06.2011 16:51:44<br>
			Attaquant <span id="preview_player_att_begin" style="color: <?php echo $color_PLAYER_ATT; ?>; font-size: 10px;"> xXx </span><span id="preview_ally" style="color: <?php echo $color_ALLY; ?>; font-size: 10px;"> [Ally] </span><br>
			Armes: <span id="preview_techno" style="color: <?php echo $color_TECHNO ?>; font-size: 10px;"> 160 % </span> Bouclier: <span id="preview_techno1" style="color: <?php echo $color_TECHNO ?>; font-size: 10px;"> 150 % </span> Coque: <span id="preview_techno2" style="color: <?php echo $color_TECHNO ?>; font-size: 10px;"> 170 % </span><br>
			<span id="preview_dst1" style="color: <?php echo $color_DST ?>; font-size: 10px;"> Destr. 1100</span><br>
			<br>
			Défenseur <span id="preview_player_def_begin" style="color: <?php echo $color_PLAYER_DEF; ?>; font-size: 10px;"> xXx  </span> <span id="preview_ally1" style="color: <?php echo $color_ALLY; ?>; font-size: 10px;"> [Ally] </span><br>
			Armes: <span id="preview_techno3" style="color: <?php echo $color_TECHNO ?>; font-size: 10px;"> 150 % </span> Bouclier: <span id="preview_techno4" style="color: <?php echo $color_TECHNO ?>; font-size: 10px;"> 130 % </span> Coque: <span id="preview_techno5" style="color: <?php echo $color_TECHNO ?>; font-size: 10px;"> 140 % </span><br>
			<span id="preview_pt" style="color: <?php echo $color_PT ?>; font-size: 10px;"> P.transp. 50</span><br>
			<span id="preview_gt" style="color: <?php echo $color_GT ?>; font-size: 10px;"> G.transp. 10</span><br>
			<span id="preview_cle" style="color: <?php echo $color_CLE ?>; font-size: 10px;"> Ch.léger 1000</span><br>
			<span id="preview_clo" style="color: <?php echo $color_CLO ?>; font-size: 10px;"> Ch.lourd 505</span><br>
			<span id="preview_cr" style="color: <?php echo $color_CR ?>; font-size: 10px;"> Croiseur 310</span><br>
			<span id="preview_vb" style="color: <?php echo $color_VB ?>; font-size: 10px;"> V.bataille 318</span><br>
			<span id="preview_vc" style="color: <?php echo $color_VC ?>; font-size: 10px;"> V.colonisation 1</span><br>
			<span id="preview_rec" style="color: <?php echo $color_REC ?>; font-size: 10px;"> Recycleur 100</span><br>
			<span id="preview_se" style="color: <?php echo $color_SE ?>; font-size: 10px;"> Sonde 28</span><br>
			<span id="preview_bmd" style="color: <?php echo $color_BMD ?>; font-size: 10px;"> Bombardier 40</span><br>
			<span id="preview_sat" style="color: <?php echo $color_SAT ?>; font-size: 10px;"> Sat.sol. 100</span><br>
			<span id="preview_dst" style="color: <?php echo $color_DST ?>; font-size: 10px;"> Destr. 10</span><br>
			<span id="preview_edlm" style="color: <?php echo $color_EDLM ?>; font-size: 10px;"> Rip 1</span><br>
			<span id="preview_tra" style="color: <?php echo $color_TRA ?>; font-size: 10px;"> Traqueur 50</span><br>
			<span id="preview_lm" style="color: <?php echo $color_LM ?>; font-size: 10px;"> Missile 150</span><br>
			<span id="preview_lleger" style="color: <?php echo $color_LLEGER ?>; font-size: 10px;"> L.léger. 128</span><br>
			<span id="preview_llourd" style="color: <?php echo $color_LLOURD ?>; font-size: 10px;"> L.lourd 150</span><br>
			<span id="preview_cg" style="color: <?php echo $color_CG ?>; font-size: 10px;"> Can.Gauss 30</span><br>
			<span id="preview_ai" style="color: <?php echo $color_AI ?>; font-size: 10px;"> Art.ions 10</span><br>
			<span id="preview_lp" style="color: <?php echo $color_LP ?>; font-size: 10px;"> Lanc.plasma 5</span><br>
			<span id="preview_pb" style="color: <?php echo $color_PB ?>; font-size: 10px;"> P.bouclier 1</span><br>
			<span id="preview_gb" style="color: <?php echo $color_GB ?>; font-size: 10px;"> G.bouclier 1</span><br>
			<br>
			Après 6 rounds<br>
			<br>
			Attaquant <span id="preview_player_att_after" style="color: <?php echo $color_PLAYER_ATT; ?>; font-size: 10px;"> xXx </span> <span id="preview_ally2" style="color: <?php echo $color_ALLY; ?>; font-size: 10px;"> [Ally]</span><br>
			<span id="preview_dst2" style="color: <?php echo $color_DST ?>; font-size: 10px;"> Destr. 1054 </span><span id="preview_pertes_fleet_def" style="color: <?php echo $color_PERTES_FLEET_DEF ?>; font-size: 10px;">(-6)</span><br>
			<br>
			Défenseur <span id="preview_player_def_after" style="color: <?php echo $color_PLAYER_DEF; ?>; font-size: 10px;"> xXx  </span>  <span id="preview_ally3" style="color: <?php echo $color_ALLY; ?>; font-size: 10px;"> [Ally]</span><br>
			<span id="preview_detruit" style="color: <?php echo $color_DETRUIT; ?>; font-size: 10px;"> Détruit </span><br>
			<br>
			L'attaquant a remporter la battaille ! Il emporte <span id="preview_ressources_piller_min" style="color: <?php echo $color_RESSOURCES_PILLER_MIN ?>; font-size: 10px;">227.623</span> unités de métal, <span id="preview_ressources_piller_max" style="color: <?php echo $color_RESSOURCES_PILLER_MAX ?>; font-size: 10px;">392.712</span> unités de cristal et <span id="preview_ressources_piller_min1" style="color: <?php echo $color_RESSOURCES_PILLER_MIN ?>; font-size: 10px;">228.109</span> de deutérium.<br>
			<br>
			L'attaquant a perdu au total <span id="preview_pertes_min_att" style="color: <?php echo $color_PERTES_MIN_ATT ?>; font-size: 10px;">5.060.000</span> unités.<br>
			<br>
			L'attaquant a perdu au total <span id="preview_pertes_max_att" style="color: <?php echo $color_PERTES_MAX_ATT ?>; font-size: 10px;">5.060.000</span> unités.<br>
			<br>
			Le défenseur a perdu au total <span id="preview_pertes_min_def" style="color: <?php echo $color_PERTES_MIN_DEF ?>; font-size: 10px;">58.784.000</span> unités.<br>
			<br>
			Le défenseur a perdu au total <span id="preview_pertes_max_def" style="color: <?php echo $color_PERTES_MAX_DEF ?>; font-size: 10px;">58.784.000</span> unités.<br>
			<br>
			Un champ de débris contenant <span id="preview_debris_max" style="color: <?php echo $color_DEBRIS_MAX ?>; font-size: 10px;">11.871.000</span> unités de métal et <span id="preview_debris_min" style="color: <?php echo $color_DEBRIS_MIN ?>; font-size: 10px;">6.230.400</span> unités de cristal.<br>
			<br>
			Rentabilité<br>
			Attaquant avec/sans recyclage : <span id="preview_renta_max" style="color: <?php echo $color_RENTA_MAX ?>; font-size: 10px;">8.282.844</span> / <span id="preview_renta_min" style="color: <?php echo $color_RENTA_MIN ?>; font-size: 10px;">-4.211.556</span><br>
			Défenseur avec/sans recyclage : <span id="preview_renta_min1" style="color: <?php echo $color_RENTA_MIN ?>; font-size: 10px;">-41.531.044</span> / <span id="preview_renta_min2" style="color: <?php echo $color_RENTA_MIN ?>; font-size: 10px;">-58.784.000</span><br>
		</th>
	</tr>
	<tr>
		<th colspan="2">
				<!-- color picker -->
			<table style="background-color: transparent; border: 0px; padding: 0px; margin: 5px auto;" border="0" cellpadding="0" cellspacing="0" id="colorpicker">
				<tr>
					<td width="169" style="border: 1px solid #cccccc; background-color: #ffffff;">
						<div id="temoin" style="float: right; width: 40px; height: 128px;"></div>
						<script language="Javascript" type="text/javascript">
							var total=1657;
							var X=Y=j=RG=B=0;
							var aR=new Array(total);
							var aG=new Array(total);
							var aB=new Array(total);
							for (var i=0;i<256;i++)
								{
									aR[i+510]=aR[i+765]=aG[i+1020]=aG[i+5*255]=aB[i]=aB[i+255]=0;
									aR[510-i]=aR[i+1020]=aG[i]=aG[1020-i]=aB[i+510]=aB[1530-i]=i;
									aR[i]=aR[1530-i]=aG[i+255]=aG[i+510]=aB[i+765]=aB[i+1020]=255;
									if(i<255)
										aR[i/2+1530]=127;aG[i/2+1530]=127;aB[i/2+1530]=127;
								}

							var hexbase=new Array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
							var i=0;
							var jl=new Array();
							for(x=0;x<16;x++)
								for(y=0;y<16;y++)
									jl[i++]=hexbase[x]+hexbase[y];
									document.write('<'+'table border="0" cellspacing="0" cellpadding="0" onMouseover="t(event)" onClick="p()">');
							var H=W=63;
							for (Y=0;Y<=H;Y++)
								{
									s='<'+'tr height="2">';j=Math.round(Y*(510/(H+1))-255);
									for (X=0;X<=W;X++)
										{
											i=Math.round(X*(total/W));
											R=aR[i]-j;if(R<0)R=0;if(R>255||isNaN(R))R=255;
											G=aG[i]-j;if(G<0)G=0;if(G>255||isNaN(G))G=255;
											B=aB[i]-j;if(B<0)B=0;if(B>255||isNaN(B))B=255;
											s=s+'<'+'td width="2" bgcolor="#'+jl[R]+jl[G]+jl[B]+'"><'+'/td>';
										}
									document.write(s+'<'+'/tr>\n');
								}
							document.write('<'+'/table>');
							var ns6=document.getElementById&&!document.all;
							var ie=document.all;
							var couleur_clic='';

							// appelée au survol, affiche la couleur survolée dans la case témoin
							function t(e)
								{
									source=ie?event.srcElement:e.target;
									if(source.tagName=='TABLE') return
									while(source.tagName!='TD' && source.tagName!='HTML')source=ns6?source.parentNode:source.parentElement;
									// couleur dans la zone témoin
									document.getElementById('temoin').style.backgroundColor=couleur_clic;
									couleur_clic=source.bgColor;
								}

							// fonction qui écrit la couleur choisie, etc...
							// appelée au clic
							// substring pour ne pas prendre le #
							function p()
								{
									if (document.getElementById('position_color_picker_player_att').checked) 
										{
											document.getElementById('couleur_player_att').value=couleur_clic.substring(1,7);
											document.getElementById('preview_player_att_begin').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_player_att_after').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_player_def').checked) 
										{
											document.getElementById('couleur_player_def').value=couleur_clic.substring(1,7);
											document.getElementById('preview_player_def_begin').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_player_def_after').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_ally').checked) 
										{
											document.getElementById('couleur_ally').value=couleur_clic.substring(1,7);
											document.getElementById('preview_ally').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_ally1').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_ally2').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_ally3').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_techno').checked) 
										{
											document.getElementById('couleur_techno').value=couleur_clic.substring(1,7);
											document.getElementById('preview_techno').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_techno1').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_techno2').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_techno3').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_techno4').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_techno5').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_pt').checked) 
										{
											document.getElementById('couleur_pt').value=couleur_clic.substring(1,7);
											document.getElementById('preview_pt').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_gt').checked) 
										{
											document.getElementById('couleur_gt').value=couleur_clic.substring(1,7);
											document.getElementById('preview_gt').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_cle').checked) 
										{
											document.getElementById('couleur_cle').value=couleur_clic.substring(1,7);
											document.getElementById('preview_cle').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_clo').checked) 
										{
											document.getElementById('couleur_clo').value=couleur_clic.substring(1,7);
											document.getElementById('preview_clo').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_cr').checked) 
										{
											document.getElementById('couleur_cr').value=couleur_clic.substring(1,7);
											document.getElementById('preview_cr').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_vb').checked) 
										{
											document.getElementById('couleur_vb').value=couleur_clic.substring(1,7);
											document.getElementById('preview_vb').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_vc').checked) 
										{
											document.getElementById('couleur_vc').value=couleur_clic.substring(1,7);
											document.getElementById('preview_vc').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_rec').checked) 
										{
											document.getElementById('couleur_rec').value=couleur_clic.substring(1,7);
											document.getElementById('preview_rec').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_se').checked) 
										{
											document.getElementById('couleur_se').value=couleur_clic.substring(1,7);
											document.getElementById('preview_se').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_bmd').checked) 
										{
											document.getElementById('couleur_bmd').value=couleur_clic.substring(1,7);
											document.getElementById('preview_bmd').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_sat').checked) 
										{
											document.getElementById('couleur_sat').value=couleur_clic.substring(1,7);
											document.getElementById('preview_sat').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_dst').checked) 
										{
											document.getElementById('couleur_dst').value=couleur_clic.substring(1,7);
											document.getElementById('preview_dst').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_dst1').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_dst2').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_edlm').checked) 
										{
											document.getElementById('couleur_edlm').value=couleur_clic.substring(1,7);
											document.getElementById('preview_edlm').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_tra').checked) 
										{
											document.getElementById('couleur_tra').value=couleur_clic.substring(1,7);
											document.getElementById('preview_tra').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_lm').checked) 
										{
											document.getElementById('couleur_lm').value=couleur_clic.substring(1,7);
											document.getElementById('preview_lm').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_lleger').checked) 
										{
											document.getElementById('couleur_lleger').value=couleur_clic.substring(1,7);
											document.getElementById('preview_lleger').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_llourd').checked) 
										{
											document.getElementById('couleur_llourd').value=couleur_clic.substring(1,7);
											document.getElementById('preview_llourd').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_cg').checked) 
										{
											document.getElementById('couleur_cg').value=couleur_clic.substring(1,7);
											document.getElementById('preview_cg').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_ai').checked) 
										{
											document.getElementById('couleur_ai').value=couleur_clic.substring(1,7);
											document.getElementById('preview_ai').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_lp').checked) 
										{
											document.getElementById('couleur_lp').value=couleur_clic.substring(1,7);
											document.getElementById('preview_lp').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_pb').checked) 
										{
											document.getElementById('couleur_pb').value=couleur_clic.substring(1,7);
											document.getElementById('preview_pb').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_gb').checked) 
										{
											document.getElementById('couleur_gb').value=couleur_clic.substring(1,7);
											document.getElementById('preview_gb').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_detruit').checked) 
										{
											document.getElementById('couleur_detruit').value=couleur_clic.substring(1,7);
											document.getElementById('preview_detruit').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_ressources_piller_min').checked) 
										{
											document.getElementById('couleur_ressources_piller_min').value=couleur_clic.substring(1,7);
											document.getElementById('preview_ressources_piller_min').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_ressources_piller_min1').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_ressources_piller_max').checked) 
										{
											document.getElementById('couleur_ressources_piller_max').value=couleur_clic.substring(1,7);
											document.getElementById('preview_ressources_piller_max').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_pertes_fleet_def').checked) 
										{
											document.getElementById('couleur_pertes_fleet_def').value=couleur_clic.substring(1,7);
											document.getElementById('preview_pertes_fleet_def').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_pertes_min_att').checked) 
										{
											document.getElementById('couleur_pertes_min_att').value=couleur_clic.substring(1,7);
											document.getElementById('preview_pertes_min_att').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_pertes_max_att').checked) 
										{
											document.getElementById('couleur_pertes_max_att').value=couleur_clic.substring(1,7);
											document.getElementById('preview_pertes_max_att').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_pertes_min_def').checked) 
										{
											document.getElementById('couleur_pertes_min_def').value=couleur_clic.substring(1,7);
											document.getElementById('preview_pertes_min_def').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_pertes_max_def').checked) 
										{
											document.getElementById('couleur_pertes_max_def').value=couleur_clic.substring(1,7);
											document.getElementById('preview_pertes_max_def').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_debris_min').checked) 
										{
											document.getElementById('couleur_debris_min').value=couleur_clic.substring(1,7);
											document.getElementById('preview_debris_min').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_debris_max').checked) 
										{
											document.getElementById('couleur_debris_max').value=couleur_clic.substring(1,7);
											document.getElementById('preview_debris_max').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_renta_min').checked) 
										{
											document.getElementById('couleur_renta_min').value=couleur_clic.substring(1,7);
											document.getElementById('preview_renta_min').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_renta_min1').style.color=couleur_clic.substring(1,7);
											document.getElementById('preview_renta_min2').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_renta_max').checked) 
										{
											document.getElementById('couleur_renta_max').value=couleur_clic.substring(1,7);
											document.getElementById('preview_renta_max').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_seuil_pertes').checked) 
										{
											document.getElementById('couleur_seuil_pertes').value=couleur_clic.substring(1,7);
											document.getElementById('preview_seuil_pertes').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_seuil_pillage').checked) 
										{
											document.getElementById('couleur_seuil_pillage').value=couleur_clic.substring(1,7);
											document.getElementById('preview_seuil_pillage').style.color=couleur_clic.substring(1,7);
										}
									if (document.getElementById('position_color_picker_seuil_cdr').checked) 
										{
											document.getElementById('couleur_seuil_cdr').value=couleur_clic.substring(1,7);
											document.getElementById('preview_seuil_cdr').style.color=couleur_clic.substring(1,7);
										}
								}
						</script>
					</td>
					<td>
						<?php echo infobulle('Cliquez sur la couleur pour la sélectionner.<br />Pour alterner le texte à colorer (fixe/variable), cochez celui désiré.'); ?>
					</td>
				</tr>
				<tr colspan="2">
					<td>
												<!-- VALIDATION DES PARAMETRES -->
						<br><center><input type="reset" name="Submit" value="Réinitialiser le formulaire"> <input type="submit" name="color" value="Envoyer"></center>
					</form>
				</p>
					</td>
				</tr>
			</table>
		</th>
	</tr>
</table>

<script language="JavaScript" type="text/javascript">
// cela permet de rester compatible avec le javascript désactivé.
document.getElementById('list_fonds_ogsign').style.display = 'none';
document.getElementById('submit_bar2').style.display = 'none';
document.getElementById('choice_color_txt').style.display = 'none';
document.getElementById('bloc_preview_txt_color').style.display = 'none';
document.getElementById('colorpicker').style.display = 'block'; // pour IE
document.getElementById('colorpicker').style.display = 'table';
</script>
