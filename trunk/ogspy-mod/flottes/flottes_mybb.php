<?php
/***************************************************************************
*   filename    : flottes_mybb.php
*   desc.       : 1.06
*   Author      : AirBAT
*   created     : 29/10/2007
*   modified    : AirBAT
*   last modif. : created
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

// def de qq variable
//define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");

// insertion des fonctions flotte
require_once("./mod/flottes/function_flottes.php");
require_once("./mod/flottes/flottes_inc.php");
require_once("./mod/flottes/flottes_lang.php");

global $CF,$CFO,$CFU,$CFP,$CFA,$CB1,$CB2,$CB3,$CB4,$CB5,$GA;

buttons_bar($pub_subaction);

global $nbj;

$nb_planete = find_nb_planete_user();

// total points
        $total=0;
        $i=1;
        $request = "SELECT ";
    
        foreach($mod_flottes_lang as $key => $value) {
            if (($key!="planet_name")&($key!="coordinates")&($key!="planet_id")){
                $request .= "(SUM(".$key.") * ".$vaisseaux[$i][1]." / 1000 ) + ";
                $i++;}
        }
        
        $request = substr($request, 0, strlen($request)-2);
        $request .= " as tot FROM ".TABLE_MOD_FLOTTES." WHERE user_id=".$user_data['user_id'];
        
        if ($result = $db->sql_query($request)){
            $total = mysql_fetch_row($result);
            if ($total[0]==''){$total=0;}
            else {$total=$total[0];}}

/////////////////////////////////////////////////////////
// Total flotte joueur

    $request = "SELECT ";
    foreach($mod_flottes_lang as $key => $value) {
        if (($key!="planet_name")&($key!="coordinates")&($key!="planet_id")){
            $request .= "SUM(".$key.") as ".$key.", ";}
    }
    $request = substr($request, 0, strlen($request)-2);
    $request .= " FROM ".TABLE_MOD_FLOTTES." WHERE user_id=".$user_data['user_id'];

/////////////////////////////////////////////////
if($result = $db->sql_query($request)) {
    while($ligne = mysql_fetch_row($result)) {
        $PT = $ligne[0];     
        $GT = $ligne[1]; 
        $CLE = $ligne[2];
        $CLO = $ligne[3];     
        $CR = $ligne[4]; 
        $VB = $ligne[5];
        $VC = $ligne[6];     
        $REC = $ligne[7]; 
        $SE = $ligne[8];
        $BMD = $ligne[9];     
        $DST = $ligne[10]; 
        $EDLM = $ligne[11];
        $TRA = $ligne[12];
        $sat = $ligne[13];
    }

	// On initialise tout à 0
	$mic = $mip = $pb = $gb = $lm = $lle = $llo = $cg = $ai = $lp = 0;
	
	// Boucle pour les planètes
	for ($i = 101 ; $i<=($nb_planete+100); $i++) {
		$mic += $user_defence[$i][$mic_lang];
		$mip += $user_defence[$i][$mip_lang];
		$pb += $user_defence[$i][$pb_lang];
		$gb += $user_defence[$i][$gb_lang];
		$lm += $user_defence[$i][$lm_lang];
		$lle += $user_defence[$i][$lle_lang];
		$llo += $user_defence[$i][$llo_lang];
		$cg += $user_defence[$i][$cg_lang];
		$ai += $user_defence[$i][$ai_lang];
		$lp += $user_defence[$i][$lp_lang];
	}
	
	// Boucle pour les lunes
	for ($i = 201 ; $i<=($nb_planete+100); $i++) {
		$mic += $user_defence[$i][$mic_lang];
		$mip += $user_defence[$i][$mip_lang];
		$pb += $user_defence[$i][$pb_lang];
		$gb += $user_defence[$i][$gb_lang];
		$lm += $user_defence[$i][$lm_lang];
		$lle += $user_defence[$i][$lle_lang];
		$llo += $user_defence[$i][$llo_lang];
		$cg += $user_defence[$i][$cg_lang];
		$ai += $user_defence[$i][$ai_lang];
		$lp += $user_defence[$i][$lp_lang];
	}

    //ajout de calcul
    $mic2 = $mic * $mic_rec;
    $mip2 = $mip * $mip_rec;
    $lm2 = $lm * $lm_rec;
    $lle2 = $lle * $lle_rec;
    $llo2 = $llo * $llo_rec;
    $ai2 = $ai * $ai_rec;
    $cg2 = $cg * $cg_rec;
    $lp2 = $lp * $lp_rec;
    $pb2 = $pb * $pb_rec;
    $gb2 = $gb * $gb_rec;
    
    $sat2M = $sat * $sat_rec[0];
    $PT2M = $PT * $PT_rec[0];
    $GT2M = $GT * $GT_rec[0];
    $CLE2M = $CLE * $CLE_rec[0];
    $CLO2M = $CLO * $CLO_rec[0];
    $CR2M = $CR * $CR_rec[0];
    $VB2M = $VB * $VB_rec[0];
    $VC2M = $VC * $VC_rec[0];
    $REC2M = $REC * $REC_rec[0];
    $SE2M = $SE * $SE_rec[0];
    $BMD2M = $BMD * $BMD_rec[0];
    $DST2M = $DST * $DST_rec[0];
    $EDLM2M = $EDLM * $EDLM_rec[0];
    $TRA2M = $TRA * $TRA_rec[0];
    
    $sat2C = $sat * $sat_rec[1];
    $PT2C = $PT * $PT_rec[1];
    $GT2C = $GT * $GT_rec[1];
    $CLE2C = $CLE * $CLE_rec[1];
    $CLO2C = $CLO * $CLO_rec[1];
    $CR2C = $CR * $CR_rec[1];
    $VB2C = $VB * $VB_rec[1];
    $VC2C = $VC * $VC_rec[1];
    $REC2C = $REC * $REC_rec[1];
    $SE2C = $SE * $SE_rec[1];
    $BMD2C = $BMD * $BMD_rec[1];
    $DST2C = $DST * $DST_rec[1];
    $EDLM2C = $EDLM * $EDLM_rec[1];
    $TRA2C = $TRA * $TRA_rec[1];
//ajout des ToTaux
    $gttf = $sat + $PT + $GT + $CLE + $CLO + $CR + $VB + $VC + $REC + $SE + $BMD + $DST + $EDLM + $TRA;
    $gttf2M = $sat2M + $PT2M + $GT2M + $CLE2M + $CLO2M + $CR2M + $VB2M + $VC2M + $REC2M + $SE2M + $BMD2M + $DST2M + $EDLM2M + $TRA2M;
    $gttf2MR=$gttf2M*$coef_rec;
    $gttf2C = $sat2C + $PT2C + $GT2C + $CLE2C + $CLO2C + $CR2C + $VB2C + $VC2C + $REC2C + $SE2C + $BMD2C + $DST2C + $EDLM2C + $TRA2C;
    $gttf2CR=$gttf2C*$coef_rec;
    $gttf2=$gttf2M+$gttf2C;
    $gttf2R=$gttf2MR+$gttf2CR;
    $nbrec=$gttf2R/$vaisseaux_lang[8][5];
    $gttd = $mic + $mip + $lm + $lle + $llo + $ai + $cg + $lp + $pb + $gb;
    $coutd2 = $lm2 + $lle2 + $llo2 + $ai2 + $cg2 + $lp2 + $pb2 + $gb2;
    $coutd = $coutd2 / 1000;
    $coutm = ($mic2 + $mip2) / 1000;
    if($gttf2 != 0)
        $txd = ($coutd2 * 100) / $gttf2;
    else
        $txd = 0;
////// Nom du joueur In Game
    $joueur=$user_data['user_stat_name'];
//// heure locale
    setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
    $date=strftime("%A %d %B %Y.");

/////// si le nom du joueur est pas null alors on va chercher ses statistiques flottes    
    if ($joueur!=''){
////// dernière date de Stat
        $out="";
        $dated=1;
        $fp=0;
        $fr=0;
        $query = "SELECT max(datadate) FROM ".TABLE_RANK_PLAYER_FLEET." WHERE player='".$joueur."'";
        if ($result = $db->sql_query($query)){
            if ( $val = mysql_fetch_row($result) ){
                $dated=$val[0];
            }
            else {
                $out="Pas de lecture date";
            }
        }
        else {
            $out="erreur base date";
        }
        if ($dated==''){
            $dated=$date+1;
        }
        $lastmodified = date('d/M/Y H:i',$dated);
        

//    echo "dated :".$dated." - ".$lastmodified;

        if (isset($dated)){
            $query  = "SELECT rank, points  FROM ".TABLE_RANK_PLAYER_FLEET." WHERE datadate=".$dated." AND player='".$joueur."'";
            if ($result = $db->sql_query($query)){    
                if ( $val = mysql_fetch_row($result) ){
                    $fr = $val[0];  // le classement flotte
//                    $fp = $val[1];   // les points flotte
                }
                else {
                    $out.=" - Pas de lecture stat ".$dated;
                    $fr=0;
                }
            }
            else {
                $out=" - erreur base stat";
                $fr=0;
            }
        }
        else {
            $out.=" - Pas de lecture stat dated";
            $fr=0;
        }
//        echo $out;
    }
    else {
        $joueur=$user_data['user_name'];
        $lastmodified=$date;
        $dated=0;
        $fr=0;
    }

// fin total joueur
//////////////////////////////////////////////////
        

        $header = '[align=center][size=large][color='.$CB2.'][b][i][u]Flotte de '.$joueur.' :[/u][/i][/b][/color][/size]';
        $footer1 = '[i][color='.$CB3.'] réalisé par le Mod Flottes d\'OGSpy le '.$date.'[/color][/i]';
        $footer2 = '[i][color='.$CB3.']Export MyBB par [u]AirBAT[/u].[/color][/i][/align]';
        
        $conv  = $header."\n";
        $conv .= "\n";
        if ($fr!=0){
        $conv .= '[i][color='.$CB1.']Classement par Vaisseaux: [/color][color='.$CB2.']'.$fr.' [/color][color='.$CB1.']ème au [/color][color='.$CB2.']'.$lastmodified.' [/color][color='.$CB1.']heure[/color][color='.$CB3.'] [/color][/i]'."\n";}
        
        else {
        $conv .= '[i][color='.$CB1.']Joueur non classé ou classement par Vaisseaux inexistant[/color][color='.$CB3.'] [/color][/i]'."\n";}
        $conv .= '[color='.$CB1.']Avec un total de [/color][color='.$CB2.']'.number_format($total, 0, ',', ' ').'[/color][color='.$CB1.'] points ou [/color][color='.$CB2.']'.number_format($total*1000, 0, ',', ' ').'[/color][color='.$CB1.'] ressources investies dans [/color][color='.$CB2.']'.$gttf.'[/color][color='.$CB1.'] vaisseaux.[/color]'."\n";
        $conv .= "\n";
        $conv .= '[b][color='.$CB4.']Vaisseaux de Guerre[/color][/b]'."\n";
        $conv .= "\n";
        $conv .= '[i][color='.$CB2.']'.$CLE.'[/color] [color='.$CB5.']'.$mod_flottes_lang["CLE"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$CLO.'[/color] [color='.$CB5.']'.$mod_flottes_lang["CLO"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$CR.'[/color] [color='.$CB5.']'.$mod_flottes_lang["CR"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$VB.'[/color] [color='.$CB5.']'.$mod_flottes_lang["VB"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$BMD.'[/color] [color='.$CB5.']'.$mod_flottes_lang["BMD"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$DST.'[/color] [color='.$CB5.']'.$mod_flottes_lang["DST"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$EDLM.'[/color] [color='.$CB5.']'.$mod_flottes_lang["EDLM"].'[/color]'."\n";
        if ($GA=='OGAME') {
        $conv .= '[color='.$CB2.']'.$TRA.'[/color] [color='.$CB5.']'.$mod_flottes_lang["TRA"].'[/color][/i]'."\n";
        }
        $conv .= "\n";
        $conv .= '[b][color='.$CB4.']Vaisseaux de Transport[/color][/b]'."\n";
        $conv .= "\n";
        $conv .= '[i][color='.$CB2.']'.$PT.'[/color] [color='.$CB5.']'.$mod_flottes_lang["PT"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$GT.'[/color] [color='.$CB5.']'.$mod_flottes_lang["GT"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$REC.'[/color] [color='.$CB5.']'.$mod_flottes_lang["REC"].'[/color][/i]'."\n";
        $conv .= "\n";
        $conv .= '[b][color='.$CB4.']Vaisseaux divers[/color][/b]'."\n";
        $conv .= "\n";
        $conv .= '[i][color='.$CB2.']'.$VC.'[/color] [color='.$CB5.']'.$mod_flottes_lang["VC"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$SE.'[/color] [color='.$CB5.']'.$mod_flottes_lang["SE"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$sat.'[/color] [color='.$CB5.']'.$mod_flottes_lang["SAT"].'[/color]'."\n";
        if ($GA=='UNIVERS') {
        $conv .= '[color='.$CB2.']'.$TRA.'[/color] [color='.$CB5.']'.$mod_flottes_lang["TRA"].'[/color]'."\n";
        }
        $conv .='[/i]'."\n";
        $conv .= '[color='.$CB1.']Valeurs recyclables : [/color][color='.$CB2.']'.number_format($gttf2MR, 0, ',', ' ').'[/color][color='.$CB1.'] de  '.$LANG["ogame_Metal"].' et [/color][color='.$CB2.']'.number_format($gttf2CR, 0, ',', ' ').'[/color][color='.$CB1.'] de '.$LANG["ogame_Crystal"].'  [/color]'."\n";
        $conv .='[color='.$CB1.']Soit un total d\'environ [/color][color='.$CB2.']'.number_format($nbrec, 0, ',', ' ').'[/color][color='.$CB1.'] '.$mod_flottes_lang["REC"].'(s)[/color]'."\n";
        $conv .= "\n";
        $conv .= '[color='.$CB1.']Et pour défendre cette flotte '.$joueur.' dispose de [/color][color='.$CB2.']'.$gttd.'[/color][color='.$CB1.'] pièces composées de:[/color]'."\n";
        $conv .= "\n";
        $conv .= '[b][color='.$CB4.']Missiles[/color][/b][color='.$CB5.'] ([/color][color='.$CB2.']'.number_format($coutm, 0, ',', ' ').'[/color][color='.$CB5.'] points)[/color]'."\n";
        $conv .= "\n";
        $conv .= '[i][color='.$CB2.']'.$mic.'[/color] [color='.$CB5.']'.$LANG["ogame_AntiBallisticMissiles"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$mip.'[/color] [color='.$CB5.']'.$LANG["ogame_InterplanetaryMissiles"].'[/color][/i]'."\n";
        $conv .= "\n";
        $conv .= '[b][color='.$CB4.']Défenses au sol[/color][/b][color='.$CB5.'] ([/color][color='.$CB2.']'.number_format($coutd, 0, ',', ' ').'[/color][color='.$CB5.'] points)[/color]'."\n";
        $conv .= "\n";
        $conv .= '[i][color='.$CB2.']'.$lm.'[/color] [color='.$CB5.']'.$LANG["ogame_RocketLauncher"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$lle.'[/color] [color='.$CB5.']'.$LANG["ogame_LightLaser"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$llo.'[/color] [color='.$CB5.']'.$LANG["ogame_HeavyLaser"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$ai.'[/color] [color='.$CB5.']'.$LANG["ogame_IonCannon"].'[/color]'."\n"; 
        $conv .= '[color='.$CB2.']'.$cg.'[/color] [color='.$CB5.']'.$LANG["ogame_GaussCannon"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$lp.'[/color] [color='.$CB5.']'.$LANG["ogame_PlasmaTuret"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$pb.'[/color] [color='.$CB5.']'.$LANG["ogame_SmallShield"].'[/color]'."\n";
        $conv .= '[color='.$CB2.']'.$gb.'[/color] [color='.$CB5.']'.$LANG["ogame_LargeShield"].'[/color][/i]'."\n";
        $conv .= "\n";
        $conv .= '[color='.$CB1.']Capacité de protection de flotte : [/color][size=16][color='.$CB2.']'.number_format($txd, 0, ',', ' ').'%[/color][/size]'."\n";
        $conv .= '[color=red][size=large]Attention[/size][/color] [size=small][i][color='.$CB5.']si vous etes inférieur à 100%, la valeur de votre défense ne couvre pas votre flotte[/color][/i][/size]'."\n";
        $conv .= "\n";

        $conv .= $footer1;
        $conv .= "\n";
        $conv .= $footer2;

//        echo 'Rapport converti<br><textarea rows=\'10\' cols=\'10\'>'.$conv.'</textarea>';
?>
    <form action='' method='POST' name='flottes'>
    <input type='hidden' name='action' value='mod_flottes' >
    <input type='hidden' name='permit' value='change' >
        <table width="100%">
            <tr align="center">
<!--                <td colspan='18'></td>   -->


                
                <td class='c' colspan='18'><b>Export MyBB Détaillé</b></td><br>
            </tr>

            <tr align="center">
                <th colspan='18'>
<?php
                    echo "<textarea name='flottes_conv' rows='30' id='flottes_conv' >".$conv."</textarea><br>";
?>

                    <div style="background-color : transparent; width: 49%; text-align : center; float: left;">
                    <input type="button" name="apercu" onClick="preview()" title="Aper&ccedil;u (ne fonctionne pas bien avec LDU)" value="Aper&ccedil;u"></div>
                    <td></td>

                </th>
            </tr>

<!-- fin BBcode  -->

        </table>
    </form>


<div style="border: 1px ridge white; padding: 5px; overflow: auto; visibility: hidden; position: absolute; width: 470px; height: 960px; top: 10px; left: 50%; margin-left: -235px; background-color: #000000;" id="message">
    <table width="100%">
    <tbody>
        <tr>
        <td><b id="note0">Aper&ccedil;u</b></td>
        <td align="right"><input type="button" name="fermer" onClick="closeMessage()" value="Fermer"></td>
        </tr>
    </tbody>
    </table>
    <div id="preview" style="background-color: #2e2e2e; padding: 10px; font-size : 12px; text-align: left;"> </div>
    <table width="100%">
    <tbody>
        <tr>
        <td align="left">Thanks to <a href="http://www.takanacity.com/" title="website of Takana's OGame Tools">Takana's Team</a> for this preview !</td>
        <td align="right"><input type="button" name="fermer" onClick="closeMessage()" value="Fermer"></td>
        </tr>
    </tbody>
    </table>
</div>

<?php
}    
?>
