<?php

///paramettre a rentrer dans bdd a la prochaine version
/// changer les valeurs pour changer la taille des graphique sur la page pandore
$hauteur="250";/// pour petite image
$largeur="350";/// pour petite uimage
$hauteurg="300";// pour grande image
$largeurg="800"; /// pour grande image

/// fin de modif



/***********************************************************************
MACHINE

************************************************************************/


define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';



///ogpt
$lien="pandore.php";
$page_title = "pandore";
require_once  PUN_ROOT . 'ogpt/include/ogpt.php';




/// fin ogpt

// Load the index.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/index.php';


define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';
?>
<?php


echo '
 <div class="blockform"><h2><span> Pandore </span></h2>
 <div class="box">
 <a href="pandore.php?type=voir">voir Fiches</a> | <a href="pandore.php?type=creer">Creer fiches</a> | <a href="pandore.php?type=admin">Administration</a>| <a href="pandore.php?type=stat">stat</a>
 <br>
 </div>
 </div>';

/// mod pandore ( @scaler )


$error = 0;
$error2 = Array(0,0,0);

///valeurs vaisseaux bat ..
$lang_flotte = array("PT"=>"Petit transporteur", "GT"=>"Grand transporteur", "CLE"=>"Chasseur léger", "CLO"=>"Chasseur lourd", "CR"=>"Croiseur", "VB"=>"Vaisseau de bataille", "VC"=>"Vaisseau de colonisation", "REC"=>"Recycleur", "SE"=>"Sonde espionnage", "BMD"=>"Bombardier", "SAT"=>"Satellite solaire", "DST"=>"Destructeur", "EDLM"=>"Étoile de la mort", "TRA"=>"Traqueur");
$points_flotte = array("PT"=>4, "GT"=>12, "CLE"=>4, "CLO"=>10, "CR"=>29, "VB"=>60, "VC"=>40, "REC"=>18, "SE"=>1, "BMD"=>90, "SAT"=>2.5, "DST"=>125, "EDLM"=>10000, "TRA"=>85);
$flotte = array("PT"=>0, "GT"=>0, "CLE"=>0, "CLO"=>0, "CR"=>0, "VB"=>0, "VC"=>0, "REC"=>0, "SE"=>0, "BMD"=>0, "SAT"=>0, "DST"=>0, "EDLM"=>0, "TRA"=>0);
$points_building = array("M"=>75, "C"=>72, "D"=>300, "CES"=>105, "CEF"=>1440, "UdR"=>720, "UdN"=>1600000, "CSp"=>700, "HM"=>2000, "HC"=>3000, "HD"=>4000, "Lab"=>800, "Ter"=>150000, "Silo"=>41000, "BaLu"=>80000, "Pha"=>80000, "PoSa"=>8000000, "DdR"=>60000);
$puissance_building = array("M"=>1.5, "C"=>1.6, "D"=>1.5, "CES"=>1.5, "CEF"=>1.8, "UdR"=>2, "UdN"=>2, "CSp"=>2, "HM"=>2, "HC"=>2, "HD"=>2, "Lab"=>2, "Ter"=>2, "Silo"=>2, "BaLu"=>2, "Pha"=>2, "PoSa"=>2, "DdR"=>2);
$points_defence = array("LM"=>2, "LLE"=>2, "LLO"=>8, "CG"=>37, "AI"=>8, "LP"=>130, "PB"=>20, "GB"=>100, "MIC"=>10, "MIP"=>25);
$points_technology = array("Esp"=>1.4, "Ordi"=>1, "Armes"=>1, "Bouclier"=>.8, "Protection"=>1, "NRJ"=>1.2, "Hyp"=>6, "RC"=>1, "RI"=>6.6, "PH"=>36, "Laser"=>.3, "Ions"=>1.4, "Plasma"=>7, "RRI"=>800, "Graviton"=>0, "Expeditions"=>16);
$technologies = array("Esp"=>0, "Ordi"=>0, "Armes"=>0, "Bouclier"=>0, "Protection"=>0, "NRJ"=>0, "Hyp"=>0, "RC"=>0, "RI"=>0, "PH"=>0, "Laser"=>0, "Ions"=>0, "Plasma"=>0, "RRI"=>0, "Graviton"=>0, "Expeditions"=>0);
$techno_necessaires = array("PT"=>array("RC"=>2), "GT"=>array("RC"=>6), "CLE"=>array("RC"=>1), "CLO"=>array("Protection"=>2, "RI"=>2), "CR"=>array("RI"=>4, "Ions"=>2), "VB"=>array("PH"=>4), "VC"=>array("RI"=>3), "REC"=>array("RC"=>6, "Bouclier"=>2), "SE"=>array("Esp"=>2, "RC"=>3), "BMD"=>array("RI"=>6, "Plasma"=>5), "DST"=>array("Hyp"=>5, "PH"=>6), "EDLM"=>array("Hyp"=>6, "PH"=>7, "Graviton"=>1), "TRA"=>array("Hyp"=>5, "PH"=>5, "Laser"=>12));
$points = array("flottes"=>0, "batiments"=>0, "defenses"=>0, "recherches"=>0);

$sep_mille = ' ';

/// si on demande les stats
if ( $_GET['type']=="stat" )
 {
  echo '
 <div class="blockform"><h2><span>  classement des fiches par points </span></h2>
 <div class="box">' ;
  echo' <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" height="5" id="carto">';
echo'  <tr>
	<th align="center" class="c" ><b>Nom</b></th>
	<th  align="center" class="c" ><b>points</b></th>
	<th  align="center" class="c" ><b>date de la fiche</b></th>
	<th  align="center" class="c" ><b>maj par</b></th>
	<th  align="center" class="c" ><b>points manquant</b></th>
       <th  align="center" class="c" ><b>fiabilité </b></th>
		 <th  align="center" class="c" ><b>admin </b></th>
</tr> ';

$sql = 'SELECT * FROM mod_pandore  ORDER BY total_point DESC ';
        $result = $db->query($sql);
        while($maj = $db->fetch_assoc($result))
        {
          echo'  <tr>
	<td align="center" class="c" ><a href="pandore.php?nom='.$maj['nom'].'&type=voir">'.$maj['nom'].'</a></td>
	<td  align="center" class="c" >'.number_format($maj['total_point'], 0, ',', $sep_mille).'</td>
	<td  align="center" class="c" >'.format_time($maj['date']).'</td>
	<td  align="center" class="c" >'.$maj['sender'].'</th>
	<td  align="center" class="c" >'.number_format($maj['points_manquant'], 0, ',', $sep_mille).'</td>
        <td  align="center" class="c" >';
          $test = ($maj['total_point'] - $maj['points_manquant']);
         $evol= ((100*$test)/$maj['total_point']);
         if ( $evol > 98) { echo ' <font style="color: #00cc00;"> excellente </font>('.number_format($evol).'%).'; }
         if ( $evol < 98 && $evol > 90 ) { echo ' <font style="color: #005300;">bonne</font> ('.number_format($evol).'%).'; }
         if ( $evol < 90 && $evol > 80) { echo ' <font style="color: orange;">moyenne</font> ('.number_format($evol).'%).'; }
         if ( $evol < 80 ) { echo ' <font style="color: red;">mauvaise</font> ('.number_format($evol).'%).'; }

        echo ' </td>' ;
        /// prevoir suppression diecrt des fiches ici et archivage direct sans passer par l admin
		echo ' </td></td></tr> ' ;


}

echo' </table>';
echo' </div>
 </div>';
 }
// si o dmande a voir une fiche
 if ( $_GET['type']=="voir" )
 {
/// vue de la fiche
 if ( isset($_GET['nom']) )
 {
 /// filtre duu nom
 $nom=pun_htmlspecialchars(pun_trim($_GET['nom']));

  ///  appel table pour les infos

   $sql = 'SELECT * FROM mod_pandore  where nom = \''.$nom.'\' order by date desc limit 1';
$result = $db->query($sql);
	    while($pandore = $db->fetch_assoc($result))
	    {


////transfert des valeurs pour reprendre le tableau de la création de fiche
$class_gene["points"]=$pandore["total_point"];
$points["batiments"]=$pandore["points_bat"];
$points["defenses"]=$pandore["points_def"];
$points["recherches"]=$pandore["points_rech"];
$points["flottes"]=$pandore["points_flotte"];
$points_manquants=$pandore["points_manquant"];
$flotte=$pandore["nb_vaisseaux"] ;
$class_flotte["points"]= ($pandore["nb_vaisseaux"]+$pandore["nb_vaisseaux_manquant"]) ;





echo "<div class='blockform'><h2><span>Points <a href='rech_joueur.php?action=rech_joueur&joueur=".$nom."'>".$nom."<a> : Points</span></h2><div class='box'><table border='0' cellpadding='2' cellspacing='0' align='center'><tr><td class='c' align='center'>Total de points</td><td class='b' align='center'>".number_format($class_gene["points"], 0, ',', $sep_mille)."</td></tr>";
	echo "<tr><td class='b' colspan='2' align='center'>Fiche créé : ";
	if ($pandore["date"]) {
		$class_gene["date"] = format_time($pandore["date"]);
		$r_pt = max(min(255, round((time() - $class_gene["datadate"] - 86400) / 2033)), 0);
		echo " <font title='Fiche créé le ' style='color: rgb(".$r_pt.",".(255 - $r_pt).",0);'>".$class_gene["date"]."</font> par <b>".$pandore["sender"]."</b></td></tr>";
	} else {
		echo " <font style='color: red;'>indisponible</font></td></tr>";

	}
        	 /// recherche de l'evolutio de point si existe depuis la creation de la fiche
                 $sql = 'SELECT * FROM '.$pun_config["ogspy_prefix"].'rank_player_points where player =\''.$nom.'\' and datadate > \''.$pandore['date'].'\' order by datadate desc  LIMIT 1';
	    $result = $db->query($sql);
                    while($stat = $db->fetch_assoc($result))
	    {
     $dif=$stat['points']- $class_gene["points"];
     $points_now=$stat['points'];
     $date_now=$stat['datadate'];
     }


                 echo "<tr><td class='b' colspan='2' align='center'>";
	if ($points_now) {
                   $evol_points=(($points_now*100/$class_gene["points"]-100));
        if ($points_now < $class_gene["points"]) {  $color="red"; }  if ($points_now > $class_gene["points"]) {  $color="green"; }
		echo " <font title=''>".format_time($date_now)."</font> : nombre de point  ".number_format($points_now, 0, ',', $sep_mille)." soit une difference de  ".number_format($dif, 0, ',', $sep_mille)." points (<font style='color: ".$color."'> ".number_format(($evol_points))."%</font>)</td></tr>";
	} else {
		echo " Classement actuel <font style='color: red;'>indisponible</font></td></tr>";
	}

	echo "<tr><td class='c' align='center'>Points bâtiments</td><td class='b' align='center'>".number_format($points["batiments"], 0, ',', $sep_mille)."</td></tr>";
	echo "<tr><td class='c' align='center'>Points défenses</td><td class='b' align='center'>".number_format($points["defenses"], 0, ',', $sep_mille)."</td></tr>";
	echo "<tr><td class='c' align='center'>Points recherches</td><td class='b' align='center'>".number_format($points["recherches"], 0, ',', $sep_mille)."</td></tr>";
	echo "<tr><td class='c' align='center'>Points vaisseaux calculés</td><td class='b' align='center'>".number_format($points_manquants, 0, ',', $sep_mille)."</td></tr>";
	echo "<tr><td class='c' align='center'>Nombre de vaisseaux</td><td class='b' align='center'>".number_format($class_flotte["points"], 0, ',', $sep_mille)."</td></tr>";
        echo "</td></tr></table>";


  echo " </div></div> ";




        // Affichage du nombre de vaisseaux
	echo "<div class='blockform'><h2><span><a href='rech_joueur.php?action=rech_joueur&joueur=".$nom."'>".$nom."<a> : Vaisseaux</span></h2><div class='box'><table border='0' cellpadding='2' cellspacing='0' align='center'><tr><td class='c' align='center'>Vaisseaux</td><td class='c' align='center'>sondés</td><th class='c' align='center'>maximum</th>";
	$row = 'b';

         echo "<tr><td class='c' align='center'>".$lang_flotte[PT]."</td><td class='b' align='center'>".number_format(floor($pandore["pt"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_pt"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[GT]."</td><td class='b' align='center'>".number_format(floor($pandore["gt"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_gt"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[CLE]."</td><td class='b' align='center'>".number_format(floor($pandore["cl"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_cl"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[CLO]."</td><td class='b' align='center'>".number_format(floor($pandore["clo"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_clo"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[CR]."</td><td class='b' align='center'>".number_format(floor($pandore["cr"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_cr"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[VB]."</td><td class='b' align='center'>".number_format(floor($pandore["vb"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_vb"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[REC]."</td><td class='b' align='center'>".number_format(floor($pandore["rc"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_rc"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[SE]."</td><td class='b' align='center'>".number_format(floor($pandore["se"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_se"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[BMD]."</td><td class='b' align='center'>".number_format(floor($pandore["bb"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_bb"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[SAT]."</td><td class='b' align='center'>".number_format(floor($pandore["sat"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_sat"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[DST]."</td><td class='b' align='center'>".number_format(floor($pandore["dest"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_dest"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[EDLM]."</td><td class='b' align='center'>".number_format(floor($pandore["edlm"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_edlm"]), 0, ',', $sep_mille)."</td></tr>";
          echo "<tr><td class='c' align='center'>".$lang_flotte[TRA]."</td><td class='b' align='center'>".number_format(floor($pandore["tr"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>".number_format(floor($pandore["max_tr"]), 0, ',', $sep_mille)."</td></tr>";

	echo "<tr><td class='c' align='center'>Points vaisseaux</td><td class='b' align='center'>".number_format(floor($points["flottes"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>-</td></tr>";
	echo "<tr><td class='c' align='center'>Points manquants</td><td class='b' align='center'>".number_format($class_gene["points"] - $points["batiments"] - $points["defenses"] - $points["recherches"] - $points["flottes"], 0, ',', $sep_mille)."</td>\n\t\t<td class='b' align='center'>-</td></tr>";
	echo "<tr><td class='c' align='center'>Nombre de  vaisseaux</td><td class='b' align='center'>".number_format($flotte, 0, ',', $sep_mille)."</td><td class='b' align='center'>-</td></tr>";
	echo "<tr><td class='c' align='center'>Vaisseaux manquants</td><td class='b' align='center'>".number_format($class_flotte["points"] - $flotte, 0, ',', $sep_mille)."</td><td class='b' align='center'>-</td></tr>";
	echo "</table></div></div>";



            // Affiche le graphique dans le code HTML
 echo "<div class='blockform'><h2><span><a href='rech_joueur.php?action=rech_joueur&joueur=".$nom."'>".$nom."<a> : Graphiques </span></h2><div class='box'>";
  echo " <table width='100%'> ";
     echo "<tr><td><center><img src='./pandore_graph.php?hauteur=".$hauteur."&largeur=".$largeur."&title=total points&legend=defenses_x_flottes_x_recherches_x_manquants_x_batiments&values=".$points["defenses"]."_x_".$points["flottes"]."_x_".$points["recherches"]."_x_".$points_manquants."_x_".$points["batiments"]."' alt='Repartition des points'/></center></td>";
   echo "<td><center><img src='./pandore_graph.php?hauteur=".$hauteur."&largeur=".$largeur."&title=connaissance de la flotte&legend=scannée_x_non scannée&values=".$flotte."_x_".($class_flotte["points"] - $flotte)."' alt='Scanne de la flotte'/></center></td></tr>";
  echo " </table> ";
  ///grph
                echo "<center><img src='./pandore_graph.php?hauteur=".$hauteurg."&largeur=".$largeurg."&title=repartition des vaisseaux en nombre&legend=".$lang_flotte["PT"]."_x_".$lang_flotte["GT"]."_x_".$lang_flotte["CLE"]."_x_".$lang_flotte["CLO"]."_x_".$lang_flotte["CR"]."_x_".$lang_flotte["VB"]."_x_".$lang_flotte["VC"]."_x_".$lang_flotte["REC"]."_x_".$lang_flotte["SE"]."_x_".$lang_flotte["BMD"]."_x_".$lang_flotte["SAT"]."_x_".$lang_flotte["DST"]."_x_".$lang_flotte["EDLM"]."_x_".$lang_flotte["TRA"]."&values=".$pandore["pt"]."_x_".$pandore["gt"]."_x_".$pandore["cl"]."_x_".$pandore["clo"]."_x_".$pandore["cr"]."_x_".$pandore["vb"]."_x_".$pandore["vc"]."_x_".$pandore["rc"]."_x_".$pandore["se"]."_x_".$pandore["bb"]."_x_".$pandore["sat"]."_x_".$pandore["dest"]."_x_".$pandore["edlm"]."_x_".$pandore["tr"]."' alt='repartition des vaisseaux en nombre'/></center><br>";
                echo "<center><img src='./pandore_graph.php?hauteur=".$hauteurg."&largeur=".$largeurg."&title=repartition des vaisseaux en point&legend=".$lang_flotte["PT"]."_x_".$lang_flotte["GT"]."_x_".$lang_flotte["CLE"]."_x_".$lang_flotte["CLO"]."_x_".$lang_flotte["CR"]."_x_".$lang_flotte["VB"]."_x_".$lang_flotte["VC"]."_x_".$lang_flotte["REC"]."_x_".$lang_flotte["SE"]."_x_".$lang_flotte["BMD"]."_x_".$lang_flotte["SAT"]."_x_".$lang_flotte["DST"]."_x_".$lang_flotte["EDLM"]."_x_".$lang_flotte["TRA"]."&values=".$pandore["pt"]*$points_flotte["PT"]."_x_".$pandore["gt"]*$points_flotte["GT"]."_x_".$pandore["cl"]*$points_flotte["CLE"]."_x_".$pandore["clo"]*$points_flotte["CLO"]."_x_".$pandore["cr"]*$points_flotte["CR"]."_x_".$pandore["vb"]*$points_flotte["VB"]."_x_".$pandore["vc"]*$points_flotte["VC"]."_x_".$pandore["rc"]*$points_flotte["RC"]."_x_".$pandore["se"]*$points_flotte["SE"]."_x_".$pandore["bb"]*$points_flotte["BMD"]."_x_".$pandore["sat"]*$points_flotte["SAT"]."_x_".$pandore["dest"]*$points_flotte["DST"]."_x_".$pandore["edlm"]*$points_flotte["EDLM"]."_x_".$pandore["tr"]*$points_flotte["TRA"]."' alt='repartition des vaisseaux en point'/></center>";
                echo "<center><img src='./pandore_graph.php?hauteur=".$hauteurg."&largeur=".$largeurg."&title=type de flotte en point&legend=Transport_x_Leger_x_Lourd_x_Autres&values=".($pandore["pt"]*$points_flotte["PT"]+$pandore["gt"]*$points_flotte["GT"]+$pandore["rc"]*$points_flotte["RC"])."_x_".($pandore["cl"]*$points_flotte["CLE"]+$pandore["clo"]*$points_flotte["CLO"]+$pandore["cr"]*$points_flotte["CR"]+$pandore["vb"]*$points_flotte["VB"])."_x_".($pandore["edlm"]*$points_flotte["EDLM"]+$pandore["tr"]*$points_flotte["TRA"]+$pandore["dest"]*$points_flotte["DST"]+$pandore["bb"]*$points_flotte["BMD"])."_x_".($pandore["sat"]*$points_flotte["SAT"]+$pandore["se"]*$points_flotte["SE"]+$pandore["vc"]*$points_flotte["VC"])."' alt='type de flotte construite'/> <img src='./pandore_graph.php?hauteur=300&largeur=500&title=type de flotte en nombre&legend=Transport_x_Leger_x_Lourd_x_Autres&values=".($pandore["pt"]+$pandore["gt"]*$pandore["rc"])."_x_".($pandore["cl"]+$pandore["clo"]+$pandore["cr"]+$pandore["vb"])."_x_".($pandore["edlm"]+$pandore["tr"]+$pandore["dest"]+$pandore["bb"])."_x_".($pandore["sat"]+$pandore["se"]+$pandore["vc"])."' alt='type de flotte construite'/></center>";
              /// fin graph


echo "</div></div>";



     }









 }




/// formulaire de recherche



echo'


        <div class="blockform">
	<h2><span>Rechercher une fiche</span></h2>
	<div class="box">
	<form id="joueur" method="get" action="pandore.php?type=voir">
		<div class="inform">


	<fieldset>
				<legend>Chercher et trier les joueurs parmis les fiches existantes</legend>

				<div class="infldset">

					<label class="conl">Pseudo
					<br><select name="nom">';


						  $sql = 'SELECT distinct(nom) FROM mod_pandore   ORDER BY nom asc  ';


	    $result2 = $db->query($sql);
	    while($message = $db->fetch_assoc($result2))
{
 echo' <option value="'.stripslashes(pun_trim($message['nom'])).'">'.stripslashes(pun_trim($message['nom'])).'</option>';


  }





					echo'</select>
					<br></label>

					<p class="clearb">Choisir le nom du joueur dont vous souhaitez retrouver la fiche.</p>
				</div>
			</fieldset>













		</div>
		<p><input type="submit" name="type" value="voir" accesskey="s" /></p>
	</form>

	</div>

</div>


';








}



if ( $_GET['type']=="admin" )
 {
 /// si utilisateur n'est pas admin redirection
if ($pun_user['g_id'] > PUN_MOD)
	message($lang_common['No permission']);

 ///  update de la bdd si pseudo envoyé
 if ( $_GET['action']=="pseudo" )
 {
 $db->query('UPDATE mod_pandore SET nom =\''.$_GET['joueur'].'\' WHERE nom=\''.$_GET['nom'].'\'') or error('Unable to update pandore mod ( pseudo )', __FILE__, __LINE__, $db->error());


/// regeeration du cache avant redirection :

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();


///redirection pour prise en compte dans la page
$redirection="Modifications prises en compte"; redirect('pandore.php?type=admin', $redirection);


 }


echo'


        <div class="blockform">
	<h2><span>admin</span></h2>
	<div class="box">
	<form id="joueur" method="get" action="pandore.php">
		<div class="inform">


	<fieldset>
				<legend>Changer le pseudo d\'une fiche</legend>

				<div class="infldset">

					<label class="conl">Pseudo
					<br><select name="nom">';


						  $sql = 'SELECT distinct(nom) FROM mod_pandore   ORDER BY nom asc  ';


	    $result2 = $db->query($sql);
	    while($message = $db->fetch_assoc($result2))
{
 echo' <option value="'.stripslashes(pun_trim($message['nom'])).'">'.stripslashes(pun_trim($message['nom'])).'</option>';


  }
	echo'</select>
					<br></label>

					<p class="clearb">Choisir le nom du joueur dont vous souhaitez changer le pseudo.</p>

                                <input type="hidden" name="action" value="pseudo" accesskey="s" />
						<label class="conl">Pseudo :    <input type="text" name="joueur" size="20" maxlength="20" ></label>


                                </div>
			</fieldset>
		</div>
		<p><input type="submit" name="type" value="admin" accesskey="s" /></p>
	</form>

	</div>

</div>


';












 }

if ( $_GET['type']=="creer" )

{

  ?>


<div class="blockform"><h2><span>recherche joueur</span></h2><div class="box">



<form id="rech_joueur" method="post" action="pandore.php?type=creer">
			<div class="inform">


						<input type="hidden" name="action" value="rech_joueur" accesskey="s" />
						<label class="conl">Nom :    <input type="text" name="joueur" size="20" maxlength="20" ></label>




			<p><input type="submit"   /></p>
		</form>

	</div>
</div>

</div>



<?php


 if (isset($_POST['joueur']))
{
// vaeur de la recherche ( machine )


  $nom=pun_htmlspecialchars(pun_trim($_POST['joueur']));




// Recherche des planètes du joueur
  if ($error == 0 && $nom!=='') {
	$res =  $db-> query("SELECT `galaxy`, `system`, `row`, `name`, `moon` FROM ".$pun_config['ogspy_prefix']."universe WHERE player = '".$nom."' ORDER BY `galaxy` ASC, `system` ASC, `row` ASC");
	while ($coords = $db-> fetch_assoc($res)) {
		if ($coords["moon"] == 0) $coords["moon"] = FALSE;
		else $coords["moon"] = 'Lune';
		$coordonnees[] = Array ($coords["galaxy"].':'.$coords["system"].':'.$coords["row"],$coords["name"],0,$coords["moon"],0);
	}
	if (count($coordonnees) == 0) $error = 2;
	if (count($coordonnees) > 9) $error = 1;

  }


// Recherche des rapports d'espionnages sur les planètes
if ($error == 0 && $nom!=='') {
	$rapport_date_min = time();
	for ($i = 0; $i < count($coordonnees); $i++) {
		$res = $db-> query("SELECT * FROM ".$pun_config['ogspy_prefix']."parsedspy WHERE coordinates = '".$coordonnees[$i][0]."' ORDER BY dateRE ASC");
		while ($rapport = $db-> fetch_assoc($res)) {
			$d = 0;
			$j = $i;
			if ($rapport['planet_name'] == 'lune' || (ereg(" \(Lune\)$", $rapport['planet_name']) && $rapport['M'] <= 0 && $rapport['C'] <= 0 && $rapport['D'] <= 0 && $rapport['CES'] <= 0 && $rapport['CEF'] <= 0 && $rapport['UdN'] <= 0 && $rapport['Lab'] <= 0 && $rapport['Ter'] <= 0 && $rapport['Silo'] <= 0)) $j += count($coordonnees);
			foreach ($rapport as $key => $value) {
				if ($value != -1 && $key != 'dateRE') $rapports[$j][$key] = $value;
				elseif ($value == -1 && $key != 'dateRE')  $rapports[$j][$key] = 0;
				elseif ($key != 'activite' && $key != 'dateRE' && $key != 'Esp' && $key != 'Ordi' && $key != 'Armes' && $key != 'Bouclier' && $key != 'Protection' && $key != 'NRJ' && $key != 'Hyp' && $key != 'RC' && $key != 'RI' && $key != 'PH' && $key != 'Laser' && $key != 'Ions' && $key != 'Plasma' && $key != 'RRI' && $key != 'Graviton' && $key != 'Expeditions') $d = 1;
			}
			if ($d == 0) $rapports[$j]["dateRE"] = $rapport["dateRE"];
			else {
				$rapports[$j]["dateRE"] = 1;
				$error2[2] = 1;
			}
		}
		if (isset($rapports[$i])) $coordonnees[$i][2] = $rapports[$i]["dateRE"];
		else $error2[1] = 1;
		if ($coordonnees[$i][3]) {
			if ($rapports[$i + count($coordonnees)]["planet_name"]) {
				$coordonnees[$i][3] = $rapports[$i + count($coordonnees)]["planet_name"];
				$coordonnees[$i][4] = $rapports[$i + count($coordonnees)]["dateRE"];
			} else $error2[1] = 1;
		}
		$rapport_date_min = min($rapport_date_min, $coordonnees[$i][2]);
		if ($coordonnees[$i][3]) $rapport_date_min = min($rapport_date_min, $coordonnees[$i][4]);
	}
}

// Recherche des classements du joueur
if ($error == 0 && $nom!=='') {
	$class_gene = $db-> fetch_assoc($db-> query("SELECT datadate, points FROM ".$pun_config['ogspy_prefix']."rank_player_points WHERE player = '".$nom."' ORDER BY datadate DESC LIMIT 1"));
	$class_flotte = $db-> fetch_assoc($db-> query("SELECT datadate, points FROM ".$pun_config['ogspy_prefix']."rank_player_fleet WHERE player = '".$nom."' ORDER BY datadate DESC LIMIT 1"));
	$class_techno = $db-> fetch_assoc($db-> query("SELECT datadate, points FROM ".$pun_config['ogspy_prefix']."rank_player_research WHERE player = '".$nom."' ORDER BY datadate DESC LIMIT 1"));
	if (!$class_gene || !$class_flotte || !$class_techno) $error2[0] = 1;
}


  // Calcul du nombre de flottes et des points flottes, bâtiments, défenses
if ($error == 0 && $nom!=='' && isset($rapports))
 {
	foreach ($rapports as $re) {
		foreach ($lang_flotte as $key => $value) {
			if ($re[$key] > 0) {
				$flotte[$key] += $re[$key];
				$points["flottes"] += $re[$key] * $points_flotte[$key];
			}
		}



                foreach ($lang_building as $key => $value) {

                        if ($re[$key] > 0 )
                        {$points["batiments"] += floor($points_building[$key] * (1 - pow($puissance_building[$key], $re[$key])) / ((1 - $puissance_building[$key]) * 1000));}
                         }
		foreach ($lang_defence as $key => $value) {
			if ($re[$key] > 0)
                        {$points["defenses"] += $points_defence[$key] * $re[$key]; }
		}
	}
}



// Calcul du nombre de recherches et des points recherches
if ($error == 0 && $nom!=='' && isset($rapports)) {
	foreach ($technologies as $key => $value) {
		foreach ($rapports as $re) $technologies[$key] = max($re[$key], $technologies[$key]);
		$points["recherches"] += floor($points_technology[$key] * (pow(2, $technologies[$key]) - 1));
	}
}


 // Calcul des points manquants
if ($error == 0 && $nom!=='') $points_manquants = $class_gene["points"] - $points["batiments"] - $points["defenses"] - $points["recherches"] - $points["flottes"];



 // Flottes constructibles
if ($error == 0 && $nom!=='') {
	foreach ($techno_necessaires as $key => $value) {
		$flotte_const[$key] = 1;
		foreach ($value as $key2 => $value2) {
			if ($technologies[$key2] < $value2) $flotte_const[$key] = 0;
		}
	}
	$flotte_const['SAT'] = 0;
}



// Javascript pour l'estimation
if ( $error == 0 && $nom!=='') :
?>
<script type="text/javascript">
points_flotte = new Array();
<?php
$i = 0;
foreach ($lang_flotte as $key => $value) {
	echo "points_flotte[".$i++."] = ".$points_flotte[$key].";\n";
}
?>
function calculs() {
points = 0;
nombre = 0;
<?php
$i = 0;
	foreach ($lang_flotte as $key => $value) {
		echo "if (isNaN(parseFloat(document.getElementById('".$key."').value)) || parseFloat(document.getElementById('".$key."').value) < 0) document.getElementById('".$key."').value = ".max(0, $flotte[$key]).";\n";
		echo "points += document.getElementById('".$key."').value * points_flotte[".$i++."];\n";
		echo "nombre += parseFloat(document.getElementById('".$key."').value);\n";
	}
	echo "points_manquants = ".($class_gene["points"] - $points["batiments"] - $points["defenses"] - $points["recherches"])." - Math.floor(points);";
	echo "flottes_manquantes = ".$class_flotte["points"]." - nombre;";
?>
document.getElementById('points').innerHTML = format(Math.floor(points));
if (points_manquants >= 0) document.getElementById('points_manquants').innerHTML = format(points_manquants);
else document.getElementById('points_manquants').innerHTML = '-' + format(-points_manquants);
document.getElementById('flottes').innerHTML = format(nombre);
if (flottes_manquantes >= 0) document.getElementById('flottes_manquantes').innerHTML = format(flottes_manquantes);
else document.getElementById('flottes_manquantes').innerHTML = '-' + format(-flottes_manquantes);
}
// Fonction de mise en forme des chiffres
function format(x) {
var str = x.toString(), n = str.length;
if (n < 4 || isNaN(x)) {return x;}
else {return ((n % 3) ? str.substr(0, n % 3) + '<?php echo $sep_mille; ?>' : '') + str.substr(n % 3).match(new RegExp('[0-9]{3}', 'g')).join('<?php echo $sep_mille; ?>');}
}
// Lancement du script au chargement de la page
window.onload = function () {Biper(); calculs();}
<?php endif;?>
</script>
<?php
///normalement pas d'erreur puisque pas de recherche par coordonnés ... ( si ajout, deja la :p ) sauf erreur 2
if ($error == 4) echo "<div class='blockform'><h2><span>Erreur</span></h2><div class='box'> <table border='0' cellpadding='2' cellspacing='0' align='center'><tr><td><img style='width: 128px; height: 128px;' src='./ogpt/img/error.png' alt='Erreur :' /></td><td>Coordonnées erronnées,<br /> indiquez les valeurs séparées par deux points <br />(ex&nbsp;: 1:234:5)</td></tr></table></div></div>";
if ($error == 3) echo "<div class='blockform'><h2><span>Erreur</span></h2><div class='box'><table border='0' cellpadding='2' cellspacing='0' align='center'><tr><td><img style='width: 128px; height: 128px;' src='./ogpt/img/error.png' alt='Erreur :' /></td><td>Pas de joueur trouvé aux coordonnées [".$search."]</td></tr></table></div></div>";
if ($error == 2) echo "<div class='blockform'><h2><span>Erreur</span></h2><div class='box'><table border='0' cellpadding='2' cellspacing='0' align='center'><tr><td><img style='width: 128px; height: 128px;' src='./ogpt/img/error.png' alt='Erreur :' /></td><td>Aucune planète du joueur n'a été trouvée,<br /> vérifiez la typographie du pseudo.</td></tr></table></div></div>";
if ($error == 1) {
	echo "<div class='blockform'><h2><span>Erreur</span></h2><div class='box'><table border='0' cellpadding='2' cellspacing='0' align='center'><tr><td><img style='width: 128px; height: 128px;' src='./ogpt/img/error.png' alt='Erreur :' /></td><td>Plus de 9 planètes ont été répertoriées pour le joueur ".$nom.".<br /> Veuillez mettre à jour les systèmes solaires suivants&nbsp;:<br /><br />";
	for ($i = 0; $i <= count($coordonnees); $i++) {
		echo "[".$coordonnees[$i][0]."] <br />";
	}
	echo "</td></tr></table></div></div>";
}


// Si pas d'erreur, afficher le résultat lorsqu'une recherche est lancée
if ( $error == 0 && $nom!=='') {
	// Affichage du nom et du tableau des coordonnées trouvées
	echo "<div class='blockform'><h2><span><u>Joueur&nbsp;:</u> ".$nom."</span></h2><div class='box'><table border='0' cellpadding='2' cellspacing='0' align='center'><tr><td></td><th class='c' align='center'>Coordonnées</th><th class='c' align='center'>Planètes</th><th class='c' align='center'>Lunes</th></tr>";
	$i = 0;
	$row = 'b';
	foreach ($coordonnees as $coord) {
		$coord_p = date('d-m-y H:i:s',$coord[2]);
		$r_p = max(min(255, round((time() - $coord[2] - 86400) / 2033)), 0);
		$coord_l = date('d-m-y H:i:s',$coord[4]);
		$r_l = max(min(255, round((time() - $coord[4] - 86400) / 2033)), 0);
		if ($coord[2] == 0) $coord_p = 'Pas de rapport';
		if ($coord[4] == 0) $coord_l = 'Pas de rapport';
		if ($coord[2] == 1) $coord_p = 'Rapport incomplet';
		if ($coord[4] == 1) $coord_l = 'Rapport incomplet';
		echo "<tr><td rowspan='2' class='".$row."' >".++$i."</td><td rowspan='2' class='".$row."' >".$coord[0]."</td><td class='".$row."' >".$coord[1]."</td>";
		if ($coord[3]) echo "<td class='".$row."' style='text-align: center; vertical-align: middle; background-image: none;'>".$coord[3]."</td></tr>";
		else echo "<td rowspan='2' class='".$row."' style='text-align: center; vertical-align: middle; background-image: none;'>".$coord[3]."</td></tr>";
		echo "<tr><td class='".$row."' style='text-align: center; vertical-align: middle; background-image: none;' title='Date de la dernière mise à jour complète'><font style='color: rgb(".$r_p.",".(255 - $r_p).",0);'>".$coord_p."</font></td>";
		if ($coord[3]) echo "<td class='".$row."' style='text-align: center; vertical-align: middle; background-image: none;' title='Date de la dernière mise à jour complète'><font style='color: rgb(".$r_l.",".(255 - $r_l).",0);'>".$coord_l."</font></td>";
		echo "</tr>";
		if ($row == 'b') $row = 'f';
		else $row = 'b';
	}
	// Affichage des avertissements sur le nombre de planètes
	if ($i == 1) echo "<tr><td colspan='4' class='".$row."' style='vertical-align: middle;'><img style='width: 64px; height: 64px;' src='./ogpt/img/error.png' alt='Attention :' />Seule 1 planète a été trouvée.<br />Sillonnez l'univers pour vous assurer<br />que le joueur n'a pas d'autre planète.</td></tr>";
	else if ($i < 9) echo "<tr><td colspan='4' class='".$row."' style='vertical-align: middle;'><img style='width: 64px; height: 64px;' src='./ogpt/img/error.png' alt='Attention :' />Seulement ".$i." planètes ont été trouvées.<br />Sillonnez l'univers pour vous assurer<br />que le joueur n'a pas d'autre planète.</td></tr>";
	echo "</table>\n";
        echo "</div></div>";


        	// Affichage des points

        echo "<div class='blockform'><h2><span>Points</span></h2><div class='box'><table border='0' cellpadding='2' cellspacing='0' align='center'><tr><td class='c' align='center'>Total de points</td><td class='b' align='center'>".number_format($class_gene["points"], 0, ',', $sep_mille)."</td></tr>";
	echo "<tr><td class='b' colspan='2' align='center'>Classement points";
	if ($class_gene) {
		$class_gene["date"] = date('d-m-y H:i:s',$class_gene["datadate"]);
		$r_pt = max(min(255, round((time() - $class_gene["datadate"] - 86400) / 2033)), 0);
		echo " du <font title='Date de mise à jour' style='color: rgb(".$r_pt.",".(255 - $r_pt).",0);'>".$class_gene["date"]."</font></td></tr>";
	} else {
		echo " <font style='color: red;'>indisponible</font></td></tr>";
		$class_gene["points"] = 0;
		$class_gene["date"] = FALSE;
	}
	echo "<tr><td class='c' align='center'>Points bâtiments</td><td class='b' align='center'>".number_format($points["batiments"], 0, ',', $sep_mille)."</td></tr>";
	echo "<tr><td class='c' align='center'>Points défenses</td><td class='b' align='center'>".number_format($points["defenses"], 0, ',', $sep_mille)."</td></tr>";
	echo "<tr><td class='c' align='center'>Points recherches</td><td class='b' align='center'>".number_format($points["recherches"], 0, ',', $sep_mille)."</td></tr>";
	echo "<tr><td class='b' colspan='2' align='center'><img style='width: 32px; height: 32px;' src='./ogpt/img/";
	if ($class_techno) {
		$class_techno["date"] = date('d-m-y H:i:s',$class_techno["datadate"]);
		$r_t = max(min(255, round((time() - $class_techno["datadate"] - 86400) / 2033)), 0);
		if (array_sum($technologies) == $class_techno["points"]) echo "ok.png' alt='Attention :' style='vertical-align: middle; width: 20px;' />Le nombre de technologies correspond";
		else echo "error.png' alt='Attention :' style='vertical-align: middle; width: 20px;' />Le nombre de technologies ne correspond pas";
		echo " avec le classement recherche du <font title='Date de mise à jour' style='color: rgb(".$r_t.",".(255 - $r_t).",0);'>".$class_techno["date"];
	} else echo "error.png' alt='Attention :' style='vertical-align: middle; width: 20px;' />Classement recherche <font style='color: red;'>indisponible";
	echo "</font></td></tr>";
	echo "<tr><td class='c' align='center'>Points vaisseaux calculés</td><td class='b' align='center'>".number_format($points_manquants, 0, ',', $sep_mille)."</td></tr>";
	echo "<tr><td class='c' align='center'>Nombre de vaisseaux</td><td class='b' align='center'>".number_format($class_flotte["points"], 0, ',', $sep_mille)."</td></tr>";
	echo "<tr><td class='b' colspan='2' align='center'>Classement vaisseaux ";
	if ($class_flotte) {
		$class_flotte["date"] = date('d-m-y H:i:s',$class_flotte["datadate"]);
		$r_f = max(min(255, round((time() - $class_flotte["datadate"] - 86400) / 2033)), 0);
		echo "du <font title='Date de mise à jour' style='color: rgb(".$r_f.",".(255 - $r_f).",0);'>".$class_flotte["date"]."</font></td></tr></table>";
	} else echo "<font style='color: red;'>indisponible</font></td></tr></table>";

          // Affiche le graphique dans le code HTML
  echo " <table width='100%'> ";
   echo "<tr><td><center><img src='./pandore_graph.php?action=pts&titre=total points&d=".$points["defenses"]."&f=".$points["flottes"]."&r=".$points["recherches"]."&m=".$points_manquants."&b=".$points["batiments"]."&end=total' alt='Repartition des points'/></center></td>";
   echo "<td><center><img src='./pandore_graph.php?test=pts&titre=vaisseaux&c=".array_sum($flotte)."&i=".($class_flotte["points"] - array_sum($flotte))."&end=total' alt='Repartition des vaisseaux'/></center></td></tr>";
    
    //   echo "<td><img src='./pandore_graph.php?test=points' alt='Mon graphique'/></td></tr>";
  echo " </table> ";
  echo " </div></div> ";


        // Affichage du nombre de vaisseaux
	echo "<div class='blockform'><h2><span>vaisseaux</span></h2><div class='box'><table border='0' cellpadding='2' cellspacing='0' align='center'><tr><td class='c' align='center'>Vaisseaux</td><td class='c' align='center'>sondés</td><th class='c' align='center'>maximum</th><td class='c' align='center'>supposés</td>";
	$row = 'b';
	foreach ($lang_flotte as $key => $value) {
		$maximum[$key] = max(0, $flotte[$key] + min($class_flotte["points"] - array_sum($flotte), floor($flotte[$key] + ($points_manquants + array_sum($flotte) - $class_flotte["points"]) / (max(2, $points_flotte[$key]) - 1))));
		if ($flotte_const[$key] == 0) $maximum[$key] = 0;
		if ($key == 'SAT') $maximum[$key] = $flotte[$key];
		echo "<tr><td class='".$row."' style='text-align: center; background-image: none;'>".$value."</td><td class='".$row."' style='text-align: center; background-image: none;'>".$flotte[$key]."</td><td class='".$row."' style='text-align: center; background-image: none;'>".number_format($maximum[$key], 0, ',', $sep_mille)."</td><td class='".$row."' style='text-align: center; background-image: none;'><input type='text' id='".$key."' name='".$key."' size='10' maxlength='8' onBlur='javascript:calculs ()' value='-' style='text-align: center;";
		if ($flotte_const[$key] == 0 || $maximum[$key]<= $flotte[$key]) echo "-moz-opacity: .25; filter: alpha(opacity=25);'";// disabled";
		else echo "'";
		echo " /></td></tr>";
		if ($row == 'b') $row = 'f';
		else $row = 'b';
	}
	echo "<tr><td class='c' align='center'>Points vaisseaux</td><td class='b' align='center'>".number_format(floor($points["flottes"]), 0, ',', $sep_mille)."</td><td class='b' align='center'>-</td><td class='b' align='center'><span id='points'></span></td></tr>";
	echo "<tr><td class='c' align='center'>Points manquants</td><td class='b' align='center'>".number_format($class_gene["points"] - $points["batiments"] - $points["defenses"] - $points["recherches"] - $points["flottes"], 0, ',', $sep_mille)."</td>\n\t\t<td class='b' align='center'>-</td>\n\t\t<td class='b' align='center'><span id='points_manquants'></span></td></tr>";
	echo "<tr><td class='c' align='center'>Nombre de  vaisseaux</td><td class='b' align='center'>".number_format(array_sum($flotte), 0, ',', $sep_mille)."</td><td class='b' align='center'>-</td><td class='b' align='center'><span id='flottes'></span></td></tr>";
	echo "<tr><td class='c' align='center'>Vaisseaux manquants</td><td class='b' align='center'>".number_format($class_flotte["points"] - array_sum($flotte), 0, ',', $sep_mille)."</td><td class='b' align='center'>-</td><td class='b' align='center'><span id='flottes_manquantes'></span></td></tr>";
	echo "</table></div></div>";


 /// création de la fiche "pandore" si aucune erreur
 if ( $error == 0 && $nom!=='' && $error2[1] !== 1 && $error2[2] !== 1 && $error2[0]!== 1  ) 
 
 {


   
   //// preparation a l'insertion ( note pour plus tard, pk l'envoi direct de donnée ne marche po ???? )
   $date= time();
   $points_manquant = ($class_gene["points"] - $points["batiments"] - $points["defenses"] - $points["recherches"] - $points["flottes"] );
   $nb_vaisseaux_manquant = ($class_flotte["points"] - array_sum($flotte));
   $total_flotte_connu = array_sum($flotte)  ;
    $points_bat = $points["batiments"];
     $points_def = $points["defenses"];
      $points_rech = $points["recherches"];
       $points_flotte = $points["flottes"];
        $edlm = $flotte[EDLM]  ;
         $max_edlm= $maximum[EDLM] ;
        $dest = $flotte[DST]  ;
         $max_dest= $maximum[DST] ;
           $tr = $flotte[TRA]  ;
         $max_tr= $maximum[TRA] ;
         $sat = $flotte[SAT]  ;
         $max_sat= $maximum[SAT] ;
         $bb = $flotte[BMD]  ;
         $max_bb= $maximum[BMD] ;
         $se = $flotte[SE]  ;
         $max_se= $maximum[SE] ;
         $rc = $flotte[REC]  ;
         $max_rc= $maximum[REC] ;
         $vc = $flotte[VC]  ;
         $max_vc= $maximum[VC] ;
         $pt = $flotte[PT]  ;
         $max_pt= $maximum[PT] ;
         $gt = $flotte[GT]  ;
         $max_gt= $maximum[GT] ;
         $cl = $flotte[CLE]  ;
         $max_cl= $maximum[CLE] ;
         $clo = $flotte[CLO]  ;
         $max_clo= $maximum[CLO] ;
         $cr = $flotte[CR]  ;
         $max_cr= $maximum[CR] ;
         $vb = $flotte[VB]  ;
         $max_vb= $maximum[VB] ;
      //// envoi des données
      

  $db->query('INSERT INTO mod_pandore
  (sender,
       id_sender ,
        nom ,
        total_point ,
         date ,
          points_bat ,
          points_def  ,
           points_rech  ,
            points_flotte,
             points_manquant,
             nb_vaisseaux,
              nb_vaisseaux_manquant ,
              edlm ,
              max_edlm, 
              max_dest,
                dest  ,
                 max_tr,
                tr ,
                max_sat,
                sat,
                max_bb,
                bb  ,
                max_se,
                se,
                max_rc,
                rc,
                max_vc,
                vc,
                max_pt,
                pt,
                max_gt,
                gt,
                max_cl,
                cl,
                max_clo,
                clo,
                max_cr,
                cr,
                max_vb,
                vb

           ) VALUES(
              \''.$pun_user['username'].'\',
            \''.$pun_user['id'].'  \',
           \''.$nom.'\',
            \''.$class_gene["points"].'  \' ,
              \''.$date.'  \' ,
               \''.$points_bat.'\',
               \''.$points_def.'\'  ,
               \''.$points_rech.'\'  ,
               \''.$points_flotte.'\'   ,
               \''.$points_manquant.'\'  ,
               \''.$total_flotte_connu.'\'     ,
                    \''.$nb_vaisseaux_manquant.'\' ,
                     \''.$edlm.'\' ,
                         \''.$max_edlm.'\' ,
                           \''.$max_dest.'\' ,
                       \''.$dest.'\' ,
                          \''.$max_tr.'\' ,
                       \''.$tr.'\'  ,
                       \''.$max_sat.'\' ,
                       \''.$sat.'\'  ,
                       \''.$max_bb.'\' ,
                       \''.$bb.'\'    ,
                       \''.$max_se.'\' ,
                       \''.$se.'\'    ,
                       \''.$max_rc.'\' ,
                       \''.$rc.'\'    ,
                       \''.$max_vc.'\' ,
                       \''.$vc.'\'  ,
                       \''.$max_pt.'\' ,
                       \''.$pt.'\'   ,
                       \''.$max_gt.'\' ,
                       \''.$gt.'\' ,
                       \''.$max_cl.'\' ,
                       \''.$cle.'\'   ,
                       \''.$max_clo.'\' ,
                       \''.$clo.'\' ,
                        \''.$max_cr.'\' ,
                       \''.$cr.'\' ,
                       \''.$max_vb.'\' ,
                       \''.$vb.'\'

           )') or error('Unable to add mod pandore', __FILE__, __LINE__, $db->error());


  //// effacement des vielles fiches

      /// on efface ou pas les anciennes fiches ??? archivages ?
      ///  $db->query('DELETE FROM mod_pandore WHERE nom=\''.$nom.'\' and date !=\''.$date.'\' ') or error('Unable to delete mod_pandore', __FILE__, __LINE__, $db->error());



 }



 // Affichage des erreurs dues à un manque d'informations
	if ($error2[1] == 1) {
		echo "<div class='blockform'><h2><span>Erreur</span></h2><div class='box'><fieldset><legend>Attention</legend><center><img style='width: 128px; height: 128px;' src='./ogpt/img/stop.png' alt='Attention :' /><br />Il manque des rapports d'espionnage.<br />Veuillez espionner les planètes et lunes suivantes&nbsp;:<br /><br />";
		for ($i = 0; $i < count($coordonnees); $i++) {
			$k = Array(0,0);
			for ($j = 0; isset($rapports) && $j < count($rapports); $j++) {
				if (isset($rapports[$j]) && $rapports[$j]["coordinates"] == $coordonnees[$i][0] && $rapports[$j]["planet_name"] == $coordonnees[$i][1]) $k[0] = 1;
				if (isset($rapports[$j + count($coordonnees)]) && $rapports[$j + count($coordonnees)]["coordinates"] == $coordonnees[$i][0] && $rapports[$j + count($coordonnees)]["planet_name"] == $coordonnees[$i][3]) $k[1] = 1;
			}
			if ($k[0] == 0) echo "[".$coordonnees[$i][0]."] <br /> ";
			if ($k[1] == 0 && $coordonnees[$i][3]) echo "[".$coordonnees[$i][0]."&nbsp;Lune]<br /> ";
		}
		echo "</center></fieldset></div></div>";
	}
	if ($error2[2] == 1) {
		echo "<div class='blockform'><h2><span>Erreur</span></h2><div class='box'><fieldset><legend>Attention</legend><center><img style='width: 128px; height: 128px;' src='./ogpt/img/stop.png' alt='Erreur :' /><br />Certains rapports d'espionnages sont incomplets.<br />Veuillez espionner les planètes et lunes suivantes&nbsp;:<br />";
		for ($i = 0; $i < count($coordonnees); $i++) {
			if ($coordonnees[$i][2] == 1) echo "[".$coordonnees[$i][0]."] ";
			if ($coordonnees[$i][4] == 1) echo "[".$coordonnees[$i][0]."&nbsp;Lune] ";
		}
		echo "</center></fieldset></div></div>";
	}
	if ($error2[0] == 1) {
		echo "<div class='blockform'><h2><span>Attention</span></h2><div class='box'><br /><fieldset><legend>Attention</legend><center><img style='width: 128px; height: 128px;' src='./ogpt/img/stop.png' alt='Erreur :' /><BR>Le joueur ".$nom." n'as pas été trouvé dans les classements.<br />Veuillez mettre à jour les classements suivants&nbsp;:<br />";
		if (!$class_gene["date"]) echo "classement points";
		if (!$class_flotte) {
			if ((!$class_gene["date"]) && (!$class_flotte) && (!$class_techno)) echo ", ";
			elseif (!$class_gene["date"]) echo " et ";
			echo "classement vaisseaux";
			$comp = 1;
		}
		if (!$class_techno) {
			if ((!$class_gene["date"]) || (!$class_flotte)) echo " et ";
			echo "classement recherche";
		}
		echo ".</center>\n</fieldset>";
	}
	if (array_sum($error2) == 0) {
		// Affichage des avertissements de péremption
		if (time() - $rapport_date_min >= 604800) {
			echo "<br /><div class='blockform'><h2><span>Attention</span></h2><div class='box'><fieldset><legend>Attention</legend><center><img style='width: 128px; height: 128px;' src='./ogpt/img/warning.png' alt='Attention :' />Certains rapports d'espionnage datent de plus d'une semaine.<br />Il serait préférable de ré-espionner les planètes et lunes suivantes&nbsp;:<br />";
			for ($i = 0; $i < count($coordonnees); $i++) {
				if (time()-$coordonnees[$i][2] >= 604800) echo "[".$coordonnees[$i][0]."] <br>";
				if ($coordonnees[$i][4] && time()-$coordonnees[$i][5] >= 604800) echo "[".$coordonnees[$i][0]." Lune]<br> ";
			}
			echo "</center></fieldset></div></div>";
		}
		if (time() - min($class_gene["datadate"], $class_flotte["datadate"], $class_techno["datadate"]) >= 604800) {
			echo "<br /><div class='blockform'><h2><span>Attention</span></h2><div class='box'><fieldset><legend>Attention</legend><center><img style='width: 128px; height: 128px;' src='./ogpt/img/warning.png' alt='Attention :' />Certains classements datent de plus d'une semaine.<br />Il serait préférable de mettre à jour les classements suivants&nbsp;:<br />";
				if (time()-$class_gene["datadate"] >= 604800) echo "classement points";
				if (time()-$class_flotte["datadate"] >= 604800) {
					if ((time()-$class_gene["datadate"] >= 604800) && (time()-$class_flotte["datadate"] >= 604800) && (time()-$class_techno["datadate"] >= 604800)) echo ", ";
					elseif (time()-$class_gene["datadate"] >= 604800) echo " et ";
					echo "classement vaisseaux";
					$comp = 1;
				}
				if (time()-$class_techno["datadate"] >= 604800) {
					if ((time()-$class_gene["datadate"] >= 604800) || (time()-$class_flotte["datadate"] >= 604800)) echo " et ";
					echo "classement recherche";
				}
			echo ".</center></fieldset></div></div>";
		}
	}
}


else echo "";


 }


 }


 ?>


   <div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>

    <?php

 ?>


    </div>

<?php

$footer_style = 'index';
require PUN_ROOT.'footer.php';
