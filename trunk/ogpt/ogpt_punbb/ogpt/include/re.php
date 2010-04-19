<?php

/**
 * Reconstruction des RE
 * repris dosgpy => ogsteam.fr
 */
function UNparseRE($id_RE)
{
    global $db;
    $show = array('flotte' => 0, 'defense' => 0, 'batiment' => 0, 'recherche' => 0);
    $flotte = array('PT' => 'Petit transporteur', 'GT' => 'Grand transporteur',
        'CLE' => 'Chasseur léger', 'CLO' => 'Chasseur lourd', 'CR' => 'Croiseur', 'VB' =>
        'Vaisseau de bataille', 'VC' => 'Vaisseau de colonisation', 'REC' => 'Recycleur',
        'SE' => 'Sonde espionnage', 'BMD' => 'Bombardier', 'DST' => 'Destructeur',
        'EDLM' => 'Étoile de la mort', 'SAT' => 'Satellite solaire', 'TRA' => 'Traqueur');
    $defs = array('LM' => 'Lanceur de missiles', 'LLE' => 'Artillerie laser légère',
        'LLO' => 'Artillerie laser lourde', 'CG' => 'Canon de Gauss', 'AI' =>
        'Artillerie à ions', 'LP' => 'Lanceur de plasma', 'PB' => 'Petit bouclier', 'GB' =>
        'Grand bouclier', 'MIC' => 'Missile interception', 'MIP' =>
        'Missile interplanétaire');
    $bats = array('M' => 'Mine de métal', 'C' => 'Mine de cristal', 'D' =>
        'Synthétiseur de deutérium', 'CES' => 'Centrale électrique solaire', 'CEF' =>
        'Centrale électrique de fusion', 'UdR' => 'Usine de robots', 'UdN' =>
        'Usine de nanites', 'CSp' => 'Chantier spatial', 'HM' => 'Hangar de métal', 'HC' =>
        'Hangar de cristal', 'HD' => 'Réservoir de deutérium', 'Lab' =>
        'Laboratoire de recherche', 'Ter' => 'Terraformeur', 'DdR' =>
        'Dépôt de ravitaillement', 'Silo' => 'Silo de missiles', 'BaLu' =>
        'Base lunaire', 'Pha' => 'Phalange de capteur', 'PoSa' =>
        'Porte de saut spatial');
    $techs = array('Esp' => 'Technologie Espionnage', 'Ordi' =>
        'Technologie Ordinateur', 'Armes' => 'Technologie Armes', 'Bouclier' =>
        'Technologie Bouclier', 'Protection' =>
        'Technologie Protection des vaisseaux spatiaux', 'NRJ' => 'Technologie Energie',
        'Hyp' => 'Technologie Hyperespace', 'RC' => 'Technologie Réacteur à combustion',
        'RI' => 'Technologie Réacteur à impulsion', 'PH' =>
        'Technologie Propulsion hyperespace', 'Laser' => 'Technologie Laser', 'Ions' =>
        'Technologie Ions', 'Plasma' => 'Technologie Plasma', 'RRI' =>
        'Réseau de recherche intergalactique', 'Graviton' => 'Technologie Graviton',
        'Expeditions' => 'Technologie Expéditions');
    $query = 'SELECT planet_name, coordinates, metal, cristal, deuterium, energie, activite, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC,
		HD, Lab, Ter, Silo, DdR, BaLu, Pha, PoSa, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP, PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD,
		DST, EDLM, SAT, TRA, Esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton, Expeditions,
		dateRE, proba FROM ogspy_parsedspy WHERE id_spy=' . $id_RE;
    $result = $db->query($query);
    $row = $db->fetch_assoc($result);
    //// filtre coordonne:
    $coord = explode(':', $row['coordinates']);
    $g = $coord[0];
    $s = $coord[1];
    $r = $coord[2];


    if (preg_match('/\(Lune\)/', $row['planet_name']))
        $moon = 1;
    else
        $moon = 0;
    $dateRE = date('m-d H:i:s', $row['dateRE']);
    ///ajout pour punbb ( div )
    $template = '      <div class="blockform"><h2><span>  ' . $row['planet_name'] .
        ' [<a href="galaxie.php?action=galaxie&galaxie=' . $g . '&systeme=' . $s . '">' .
        $row['coordinates'] . '</a>] le ' . $dateRE . '</span></h2><div class="box">  ';
    ///fin d'ajout
    $template .= '<table border="0" cellpadding="2" cellspacing="0" align="center">
	<tr>
		<td class="l" colspan="4" class="c">Matières premières sur ' . $row['planet_name'] .
        ' [<a href="galaxie.php?action=galaxie&galaxie=' . $g . '&systeme=' . $s . '">' .
        $row['coordinates'] . '</a>] le ' . $dateRE . '</td>
	</tr>
	<tr>
		<td class="c" style="text-align:right;">Métal</td>
		<th>' . $row['metal'] . '</th>
		<td class="c" style="text-align:right;">Cristal</td>
		<th>' . $row['cristal'] . '</th>
	</tr>
	<tr>
		<td class="c" style="text-align:right;">Deutérium</td>
		<th>' . $row['deuterium'] . '</th>
		<td class="c" style="text-align:right;">Energie</td>
		<th>' . $row['energie'] . '</th>
	</tr>
	<tr>
		<th colspan="4">';
    if ($row['activite'] > -1)
        $template .= 'Le scanner des sondes a détecté des anomalies dans l\'atmosphère de cette planète, indiquant qu\'il y a eu une activité sur cette planète dans les ' .
            $row['activite'] . ' dernières minutes.';
    else
        $template .= 'Le scanner des sondes n\'a pas détecté d\'anomalies atmosphériques sur cette planète. Une activité sur cette planète dans la dernière heure peut quasiment être exclue.';
    $template .= '</th>
	</tr>' . "\n";
    foreach ($flotte as $key => $value) {
        if ($row[$key] != -1) {
            $show['flotte'] = 1;
            continue;
        }
    }
    if ($show['flotte'] == 0) {
        $query = 'SELECT PT, GT, CLE, CLO, CR, VB, VC, REC, SE, BMD, DST, EDLM, SAT, TRA FROM ogspy_parsedspy WHERE
			(PT <> -1 OR GT <> -1 OR CLE <> -1 OR CLO <> -1 OR CR <> -1 OR VB <> -1 OR VC <> -1 OR REC <> -1 OR SE <> -1 OR
			BMD <> -1 OR DST <> -1 OR EDLM <> -1 OR SAT <> -1 OR TRA <> -1) AND coordinates = "' .
            $row['coordinates'] . '"
			AND planet_name' . (($moon == 0) ? ' NOT ' : '') .
            ' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
        $tmp_res = $db->query($query);
        if ($db->num_rows($tmp_res) > 0) {
            $tmp_row = $db->fetch_assoc($tmp_res);
            $row = array_merge($row, $tmp_row);
            $show['flotte'] = 1;
        }
    }
    foreach ($defs as $key => $value) {
        if ($row[$key] != -1) {
            $show['flotte'] = 1;
            $show['defense'] = 1;
            continue;
        }
    }
    if ($show['defense'] == 0) {
        $query = 'SELECT LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP FROM ogspy_parsedspy WHERE (LM <> -1 OR LLE <> -1
			OR LLO <> -1 OR CG <> -1 OR AI <> -1 OR PB <> -1 OR GB <> -1 OR MIC <> -1 OR MIC <> -1) AND coordinates = "' .
            $row['coordinates'] . '" AND planet_name' . (($moon == 0) ? ' NOT ' : '') .
            ' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
        $tmp_res = $db->query($query);
        if ($db->num_rows($tmp_res) > 0) {
            $tmp_row = $db->fetch_assoc($tmp_res);
            $row = array_merge($row, $tmp_row);
            $show['defense'] = 1;
        }
    }
    foreach ($bats as $key => $value) {
        if ($row[$key] != -1) {
            $show['flotte'] = 1;
            $show['defense'] = 1;
            $show['batiment'] = 1;
            continue;
        }
    }
    if ($show['batiment'] == 0) {
        $query = 'SELECT M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, Lab, Ter, Silo, DdR, BaLu, Pha, PoSa FROM ogpy_parsedspy WHERE (M <> -1 OR C <> -1 OR D <> -1 OR CES <> -1 OR CEF <> -1 OR UdR <> -1 OR UdN <> -1 OR
			CSp <> -1 OR HM <> -1 OR HC <> -1 OR HD <> -1 OR Lab <> -1 OR Ter <> -1 OR Silo <> -1 OR DdR <> -1 OR BaLu <> -1
			OR Pha <> -1 OR PoSa <> -1) AND coordinates = "' . $row['coordinates'] .
            '" AND planet_name' . (($moon == 0) ? ' NOT ' : '') .
            ' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
        $tmp_res = $db->query($query);
        if ($db->num_rows($tmp_res) > 0) {
            $tmp_row = $db->fetch_assoc($tmp_res);
            $row = array_merge($row, $tmp_row);
            $show['batiment'] = 1;
        }
    }
    foreach ($techs as $key => $value) {
        if ($row[$key] != -1) {
            $show['flotte'] = 1;
            $show['defense'] = 1;
            $show['batiment'] = 1;
            $show['recherche'] = 1;
            continue;
        }
    }
    if ($show['recherche'] == 0) {
        $query = 'SELECT Esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton,
			Expeditions FROM ogspy_parsedspy WHERE (Esp <> -1 OR Ordi <> -1 OR Armes <> -1 OR Bouclier <> -1 OR
			Protection <> -1 OR NRJ <> -1 OR Hyp <> -1 OR RC <> -1 OR RI <> -1 OR PH <> -1 OR Laser <> -1 OR Ions <> -1 OR
			Plasma <> -1 OR RRI <> -1 OR Graviton <> -1 OR Expeditions <> -1) AND coordinates = "' .
            $row['coordinates'] . '"
			AND planet_name' . (($moon == 0) ? ' NOT ' : '') .
            ' LIKE "%(Lune)%" ORDER BY dateRE DESC LIMIT 0,1';
        $tmp_res = $db->query($query);
        if ($db->num_rows($tmp_res) > 0) {
            $tmp_row = $db->fetch_assoc($tmp_res);
            $row = array_merge($row, $tmp_row);
            $show['recherche'] = 1;
        }
    }
    if ($show['flotte'] == 1) {
        $template .= '  <tr>
		<td class="l" colspan="4">Flotte</td>
	</tr>
	<tr>' . "\n";
        $count = 0;
        foreach ($flotte as $key => $value) {
            if ($row[$key] > 0) {
                $template .= '    <td class="c" style="text-align:right;">' . $flotte[$key] .
                    '</td>
		<th>' . $row[$key] . '</th>' . "\n";
                if ($count == 0) {
                    $count = 1;
                } else {
                    $template .= '  </tr>
	<tr>' . "\n";
                    $count = 0;
                }
            }
        }
        if ($count == 1)
            $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
        $template .= '  </tr>' . "\n";
    }
    if ($show['defense'] == 1) {
        $template .= '  <tr>
		<td class="l" colspan="4">Défense</td>
	</tr>
	<tr>' . "\n";
        $count = 0;
        foreach ($defs as $key => $value) {
            if ($row[$key] > 0) {
                $template .= '    <td class="c" style="text-align:right;">' . $defs[$key] .
                    '</td>
		<th>' . $row[$key] . '</th>' . "\n";
                if ($count == 0) {
                    $count = 1;
                } else {
                    $template .= '  </tr>
	<tr>' . "\n";
                    $count = 0;
                }
            }
        }
        if ($count == 1)
            $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
        $template .= '  </tr>' . "\n";
    }
    if ($show['batiment'] == 1) {
        $template .= '  <tr>
		<td class="l" colspan="4">Bâtiments</td>
	</tr>
	<tr>' . "\n";
        $count = 0;
        foreach ($bats as $key => $value) {
            if ($row[$key] > 0) {
                $template .= '    <td class="c" style="text-align:right;">' . $bats[$key] .
                    '</td>
		<th>' . $row[$key] . '</th>' . "\n";
                if ($count == 0) {
                    $count = 1;
                } else {
                    $template .= '  </tr>
	<tr>' . "\n";
                    $count = 0;
                }
            }
        }
        if ($count == 1)
            $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
        $template .= '  </tr>' . "\n";
    }
    if ($show['recherche'] == 1) {
        $template .= '  <tr>
		<td class="l" colspan="4">Recherche</td>
	</tr>
	<tr>' . "\n";
        $count = 0;
        foreach ($techs as $key => $value) {
            if ($row[$key] > 0) {
                $template .= '    <td class="c" style="text-align:right;">' . $techs[$key] .
                    '</td>
		<th>' . $row[$key] . '</th>' . "\n";
                if ($count == 0) {
                    $count = 1;
                } else {
                    $template .= '  </tr>
	<tr>' . "\n";
                    $count = 0;
                }
            }
        }
        if ($count == 1)
            $template .= '    <td class="c" style="text-align:right;">&nbsp;</td>
		<th>&nbsp;</th>' . "\n";
        $template .= '  </tr>' . "\n";
    }
    $template .= '  <tr>
		<th colspan="4">Probabilité de destruction de la flotte d\'espionnage :' . $row['proba'] .
        '%</th>
	</tr>
</table>';
    /// fin ajout div ( punbb
    $template .= '
</div>
</div>  ';
    //fin

    return ($template);
}
?>