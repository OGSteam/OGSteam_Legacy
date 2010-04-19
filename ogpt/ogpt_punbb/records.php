<?php
/***********************************************************************
MACHINE

************************************************************************/


define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
///ogpt
$lien="records.php";
$page_title = "records";
require_once  PUN_ROOT . 'ogpt/include/ogpt.php';;
/// fin ogpt

// Load the index.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/index.php';


define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';


/// si utilisateur n'est pas enregistré : redirection
if(	$pun_user['is_guest'] )
{
$redirection="identifiez vous";
redirect('index.php', $redirection);
}

/// si utilisateur n'a pas validé son mdp et pseudo ... : redirection
if ( $pun_user['id_ogspy'] ==  '0' )
{
$redirection="remplissez votre acces ogspy";
redirect('profil_ogs.php', $redirection);
}




?>
<?php

/// inspiré de bt_hof ogsteam /ogspy
///// array batiments
        $Building_Name  = array("M","C","D","CES","CEF","UdR","UdN","CSp","HM","HC","HD","Lab","Ter","Silo","BaLu","Pha","PoSa");
        $Building_Label = array("Mine de métal","Mine de Cristal","Synthétiseur de deutérium","Centrale électrique solaire","Centrale électrique de fusion","Usine de robots","Usine de nanites ","Chantier spatial","Hangar de métal","Hangar de cristal","Réservoir de deutérium","Laboratoire de recherche","Terraformeur","Silo de missiles ","Base Lunaire","Phalange de capteur","Porte de saut spatial");
        $Building_number = 16 ;
        $Building_icon  = array("1.gif","2.gif","3.gif","4.gif","12.gif","14.gif","15.gif","21.gif","22.gif","23.gif","24.gif","31.gif","33.gif","44.gif","41.gif","42.gif","43.gif");


	$Flottes_Name  = array("PT","GT","CLE","CLO","CR","VB","VC","REC","SE","BMD","DST","EDLM","TRA","SAT");
	$Flottes_Label = array("Petit Transporteur","Grand Transporteur","Chasseur Léger","Chasseur Lourd","Croiseur","Vaisseau de Bataille","Vaisseau de Colonisation","Recycleur","Sonde d'Espionnage","Bombardier","Destructeur","Etoile de la Mort","Traqueur","Satellite Solaire");
	$Flottes_number  = 13;
	$Flottes_icon  = array("202.gif","203.gif","204.gif","205.gif","206.gif","207.gif","208.gif","209.gif","210.gif","211.gif","213.gif","214.gif","215.gif","212.gif");


	$Tech_label     = array("Technologie Espionnage","Technologie Ordinateur","Technologie Armes","Technologie Bouclier","Protect. vaisseaux","Technologie Energie","Technologie Hyperespace","Réacteur à combustion","Réacteur à impulsion","Propulsion hyperespace","Technologie Laser","Technologie Ions","Technologie Plasma","Réseau de recherche","Technologie Expéditions","Technologie Graviton");
	$Tech_name      = array("Esp","Ordi","Armes","Bouclier","Protection","NRJ","Hyp","RC","RI","PH","Laser","Ions","Plasma","RRI","Expeditions","Graviton");
	$Tech_number      = 15;
        $Tech_icon      = array("106.gif","108.gif","109.gif","110.gif","111.gif","113.gif","114.gif","115.gif","117.gif","118.gif","120.gif","121.gif","122.gif","123.gif","124.gif","199.gif");

         $Game_label      = array( "Pertes attaquant","Pertes defenseurs","% de lune","Lunes créés","Pillage metal","Pillage cristal","Pillage deut","Recyclage metal","Recyclage cristal","Points");
	$Game_name       = array( "pertesA","pertesD","%lune","lune","pillageM","pillageC","pillageD","recyclageM","recyclageC","points");
	$Game_number       = 9;
   //	 	p

	$Def_label      = array( "Lance Missile","Laser Léger","Laser Lourd","Canon Gauss","Artillerie Ion","Lance Plasma","Missile Interception","Missile InterPlanétaire");
	$Def_name       = array( "LM","LLE","LLO","CG","AI","LP","MIC","MIP");
	$Def_number       = 7;
        $Def_icon       = array("401.gif","402.gif","403.gif","404.gif","405.gif","406.gif","502.gif","503.gif");


	$Div_label      = array( "Cases","Temperature","Cases sur lune","Temperature sur lune","Total Cases","Total Temperature");
	$Div_name       = array( "fields","temperature","fields","temperature","fields","temperature");
	$Div_where       = array( " planet_id <=9 ","planet_id <=9","planet_id >= 10 and planet_id <= 18","planet_id >= 10 and planet_id <= 18","planet_id >= 0 and planet_id <= 18","planet_id >= 0 and planet_id <= 18");
	$Div_number       = 5;



echo'<div class="blockform"><h2><span> Records : <a href="records.php">Batiments</a> | <a href="records.php?flottes">Flottes</a> | <a href="records.php?technos">Technologies</a> | <a href="records.php?defs">Defenses</a> | <a href="records.php?gameogame">GameOgame</a> | <a href="records.php?divers">Divers</a> | <a href="records.php?records">Classement records</a></span></h2><div class="box">';



    if (isset($_GET['flottes']))
{

$batiment=Create_HOF($Flottes_Name,$Flottes_Label,"Flottes","".$pun_config['ogspy_prefix']."mod_flottes",$Flottes_number,$Flottes_icon);
 echo ''.$batiment.'';
}

 else  if (isset($_GET['technos']))
{

$batiment=Create_HOF($Tech_name,$Tech_label,"Technologies","".$pun_config['ogspy_prefix']."user_technology",$Tech_number,$Tech_icon);
 echo ''.$batiment.'';
}


 else  if (isset($_GET['gameogame']))
{

$batiment=Create_game($Game_name,$Game_label,"Game Ogame","".$pun_config['ogspy_prefix']."game",$Game_number);
 echo ''.$batiment.'';
}


 else  if (isset($_GET['divers']))
{

$batiment=Create_Div($Div_name,$Div_label,"Divers","".$pun_config['ogspy_prefix']."user_building",$Div_number,$Div_where);
 echo ''.$batiment.'';
}

 else if (isset($_GET['defs']))
{


$batiment=Create_HOF($Def_name,$Def_label,"Défenses","".$pun_config['ogspy_prefix']."user_defence",$Def_number,$Def_icon );
 echo ''.$batiment.'';

}

 else if (isset($_GET['records']))
{
    $tableau='<table border="0" cellpadding="2" cellspacing="0" align="center">';
           $tableau .='<tr><th colspan="3">Classement Records</th></tr> ';
           $tableau .='<tr><th><b>Classement</b></th><th><b>nb de record</b></th><th><b>Pseudo(s)</b></th><th><b>Avatar</b></th></tr> ';
           $i=1;

 $sql2 ="select count(nom_record) as nb ,id_user from mod_fofo_records  group by id_user order by nb desc ";
		  $result2 =$db->query($sql2);
                  while($sum = $db->fetch_assoc($result2))

{

                $tableau .='<tr><th>'.$i.'</th><td><center>'.$sum['nb'].'</center></td><td>'.pseudo($sum['id_user']).'</td><td>';
                /// avatar

                $sql3 ='select * FROM '.$db->prefix.'users where id_ogspy  = \''.$sum['id_user'].'\'';
		  $result3 =$db->query($sql3);
                  while($av = $db->fetch_assoc($result3))

                  {

    $chemin="img/avatars";
    	if ($img_size = @getimagesize($pun_config['o_avatars_dir'].'/'.$av['id'].'.png'))

				 $tableau .='<img src="'.$pun_config['o_avatars_dir'].'/'.$av['id'].'.png" '.$img_size[3].' alt="" />';

			else if ($img_size2 = @getimagesize($pun_config['o_avatars_dir'].'/'.$av['id'].'.gif'))

				$tableau .= '<img src="'.$pun_config['o_avatars_dir'].'/'.$av['id'].'.gif" '.$img_size2[3].' alt="" />';

		else	 if ($img_size3 = @getimagesize($pun_config['o_avatars_dir'].'/'.$av['id'].'.jpg'))

				$tableau .= '<img src="'.$pun_config['o_avatars_dir'].'/'.$av['id'].'.jpg" '.$img_size3[3].' alt="" />';

                 

                  }







                $tableau .='</td></tr> ';
             $i=$i+1;
  }
   $tableau .='</table> ';
 echo ''.$tableau.'';

}

else
{
$user_Building=$pun_config['ogspy_prefix'];
$user_Building.="user_building";

$batiment=Create_HOF($Building_Name,$Building_Label,"Bâtiments",$user_Building,$Building_number,$Building_icon);
 echo ''.$batiment.'';
}
echo'</div></div>';



?>









<?php

$footer_style = 'index';
require PUN_ROOT.'footer.php';
