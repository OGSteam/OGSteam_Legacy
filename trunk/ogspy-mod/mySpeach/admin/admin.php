<?php
##################################################################
#Copyrigh GUNNING Sky
#Modifiable à souhaits, à une seule condition :
#laisser le lien vers le site http://www.graphiks.net sur le chat.
#
#Version Originale non modifié
##################################################################
if(!file_exists("config.php")){
  exit('MySpeach non installé');
}

session_start();

include("config.php");
include("fonctions.php");
include("options.php");
include("setup.php");
/* test de connexion admin ou non */
if($_SESSION['My_admin_login']!=md5($my_ms['admin_login']) OR $_SESSION['My_admin_mdp']!=md5($my_ms['admin_mdp'])){
exit("<center><br><br><b>Vous n'est pas logguer</b><br><br><a href=\"index.php\">Connexion</a></center>");
}
$my_ms['root']="..";
$my_ms['cettepage']=htmlentities($_SERVER["REQUEST_URI"]);
$my_ms['cettepage']=str_replace("&amp;","&",$my_ms['cettepage']);

//include('../jscript.php');

if(isset($HTTP_GET_VARS['mod'])){
  $module=$HTTP_GET_VARS['mod'];
}elseif(isset($_GET['mod'])){
  $module=$_GET['mod'];
}else{
  $module='config';
}

if($module!=""){
str_replace("http","***",$module);
str_replace("www","***",$module);
str_replace("./","***",$module);
}
?>



<html>
<head>
<title>Configuration de MySpeach <?php echo $my_ms['version']; ?></title>
<link REL="STYLESHEET" HREF="css.css" TYPE="text/css">
</head>
<body bgcolor="#FEF2D6">
<div id="set">
<table class="goetic" width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="33%"><div align="left"><font size="2"><a href="admin_cookie.php?op=oui">Mettre le cookie ADMIN</a></font></div></td>
    <td width="33%"><div align="left"><font size="2"><a href="admin_cookie.php?op=non">D&eacute;truire le cookie ADMIN</a></font></div></td>
    <td width="33%"><div align="left"><a href="http://www.graphiks.net/" target="_blank">FAQ  - Aide pratique</a></div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center" valign="middle"> 
    <td height="31" colspan="3"><div align="center"><strong><font color="#663300">Options de Configuration</font></strong></div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">
	
	<div align="center"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="16%" height="30"><div align="center"><strong><a href="admin.php?mod=config">Configuration</a></strong></div></td>
            <td width="16%"><div align="center"><strong><a href="admin.php?mod=setup">Mise en page</a></font></div></td>
            <td width="16%"><div align="center"><strong><a href="admin.php?mod=options">Options</a></strong></div></td>
            <td width="16%"><div align="center"><strong><a href="admin.php?mod=smile">Smileys</a></strong></div></td>
            <td width="16%"><div align="center"><strong><a href="admin.php?mod=skins">Skins</a></strong></div></td>
            <td width="16%"><div align="center"><strong><a href="admin.php?mod=css">Css Editeur</a></strong></div></td>
          </tr>
        </table>
      </div>
	  
      <div align="center"></div>
      <?php
      if($module=='css') {
      $restore=my_MS_getrestorefiles('temp');
      $liste='<select name="changecss">';
      $liste.='<option value="">---</option>';
      if(count($restore)>0) {
        foreach($restore as $key=>$donnee) {
          $liste.='<option value="temp/'.$donnee.'">'.my_MS_datefr($donnee).'</option>';
        }
      }
      $liste.='<option value="styles.bak.css">CSS originel</option>';
      $liste.='</select>';
      $restauration='
                <form  method="post" action="restore.php">
                  Restaurer la page CSS du '.$liste.' 
                  <input type="submit" name="restore" value="restaurer">
                </form>
      ';
                
        echo '
        <div style="position:absolute;margin-left:350px;margin-top:25px">
          '.$restauration.'
        </div>';
      }
      ?>
      </td>
  </tr>
</table>



<br>



<table class="encadrer" id="encadrer" width="750" border="0" align="center">
<?php
print '<form  method="post" action="">';


if((!$_POST)||(($_POST)&&($module=="css"))){ // pour retourner sur css quand c'est le cas
//Cas de config
  if($module=="config" OR $module==""){
  $module="config";
?>
    <tr>
      <td height="38"><font color="#990000"><strong>Configuration</strong></font></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td width="545" height="28">Votre <b>Login</b></td>
      <td width="144"><input name="url_id_unique" type="hidden" id="url_id_unique" value="<?php echo $my_ms["id_unique"]; ?>"> <input name="url_login" type="text" id="url_login" value="<?php echo $my_ms['admin_login']; ?>"></td>
    </tr>
          
    <tr> 
      <td width="545" height="28">Votre <b>Mot de passe</b></td>
      <td width="144"><input name="url_mdp" type="text" id="url_mdp" value="<?php echo $my_ms['admin_mdp']; ?>"></td>
    </tr>

    <tr> 
      <td width="545" height="28"><strong>Url du site </strong><font size="-1"><em><font color="#666666">(sans / &agrave; la fin)</font></em></td>
      <td width="144"><input name="url_site" type="text" id="url_site" value="<?php echo $my_ms['site']; ?>"></td>
    </tr>

    <tr> 
      <td width="545" height="28"><strong>Url depuis la racine </strong><font size="-1"><em><font color="#666666">(sans / &agrave; la fin ni au d&eacute;but)</font></em></td>
      <td width="144"><input name="url_repertoire" type="text" id="url_repertoire" value="<?php echo $my_ms['repertoire']; ?>"></td>
    </tr>
    
    <tr> 
      <td width="545" height="28"><strong>Nom du fichier texte </strong><font size="-1"><em><font color="#666666">(Par defaut : message.txt | modifier que si vous savez ce que vous faite.)</font></em></td>
      <td width="144"><input name="url_message" type="text" value="<?php echo $my_ms['msg_txt']; ?>"></td>
    </tr>

<?php
################################################################
################################################################
//Cas de gestion des SKINS
################################################################
################################################################
}elseif($module=="skins") {
    $outskins='';
    $tableau=file('http://www.graphiks.net/api/myspeach/liste.php');
    $nblignes=count($tableau);
    foreach($tableau as $urlskin) {
      $temp=explode('|',$urlskin);
      $outskins.='<option value="'.$temp[0].'">'.$temp[1].'</option>'."\n";
    }
    $temp=explode('/',$my_ms['skin']);
    $nbr=count($temp);
    $lesskins=my_MS_getSkins('../saves/skin/',$temp[(count($temp)-1)]);
?>

    <tr> 
      <td width="400" height="28">
        <strong>Les Skins installés </strong>
        <em>(Skins d&eacute;j&agrave; install&eacute;s)</em>
        <br />
        S&eacute;lectionner pour changer de skin.
        <br />&nbsp;<br />&nbsp;
      </td>
      <td><?php echo $lesskins; ?> <br />&nbsp;<br />&nbsp;</td>
    </tr>
    <tr> 
      <td valign="top" width="400" height="28">
        <strong>T&eacute;l&eacute;charger un nouveau skin</strong>
        <p>
          Liste de skin &agrave; t&eacute;l&eacute;charger du site <b>graphiks.net</b>. <br />
          Ces skins sont test&eacute;s et certifi&eacute;s sans codes malicieux. <br /><br />
          
          Une url entr&eacute;e librement doit provenir d'une source <u>s&ucirc;re</u> !
        </p>
      </td>
      <td>
        <br />
        Graphiks.net : <select name="remoteskin"><option value="">Sélectionner</option><?php echo $outskins; ?></select> <br />&nbsp;<br />
        Url libre : <input type="text" value="" name="remoteskin_2" />
      </td>
    </tr>
    
    <tr> 
      <td colspan="2">
        <br />&nbsp;<br />&nbsp;
      </td>
    </tr>

<?php
################################################################
################################################################
//Cas de GESTION des SMILEYS
################################################################
################################################################

}elseif($module=="smile"){
$module="smile";
print $set_form;
include("../saves/smileys.php");
$toutImage='';$TempArray='';

$toutImage = '<table border="1"><tr><td colspan="2"><b>Config actuelle</b></td></tr>';
foreach ($smileys as $signe => $image) {
    $TempArray[$image]=$signe;
    $image_smiley='<img border="0" src="../smiley/'.$smileys[$signe]. '.gif">'; 
    $toutImage .= '<tr><td>'.$image_smiley.'</td><td>'.$signe.'</td></tr>';
    }
$toutImage .= '</table>';
?>

          <tr> 
            <td height="38"><font color="#990000"><strong>Gestion des smileys</strong></font></td>
            <td></td>
          </tr>
          <tr valign="top">
            <td><br>
              <?php echo $toutImage; ?>
            </td>
          <td>
          
          <br>
          <table align="center" cellpadding="4" cellspacing="0" width="400"><tr><td colspan="2"><b>Modifi&eacute; la config</b></td></tr>
          <?php
          
    $repertoire = openDir("../smiley/");
    while ($rep = readDir($repertoire)) {
        if (($rep != ".")&&($rep != "..")&&($rep != "Thumbs.db")&&($rep != "index.php")) { 
        
            $u_image=str_replace(".gif","",$rep);
            echo '<tr><td><img src="../smiley/'.$rep.'" border="0"></td><td><input type="text" name="s_s['.$u_image.']" value="'.$TempArray[$u_image].'"></td></tr>';            
            
            }
        }
    closeDir($repertoire);
   ?>
   </table>
   
   <br><br>
   
          </td>
          </tr>
          

<?php
}


################################################################
################################################################
//Cas de setup
################################################################
################################################################
elseif($module=="setup"){
print $set_form;
		//include("../admin/".$module.".php");
?>
      <tr> 
        <td height="38"><strong><font color="#990000">Mise en page</font></strong><br></td>
        <td></td>
      </tr>
          
      <tr> 
        <td width="545"><strong>Titre du chat</strong><font color="#666666" size="-1"> <em>(par defaut: MySpeach)</em></font></td>
        <td width="144"><input name="url_chat_titre" type="text" id="url_chat_titre" value="<?php echo $my_ms['chat_titre']; ?>"></td>
      </tr>
      
      <tr> 
        <td width="545"><strong>Nombre de caracère par message [maximum] </strong><font color="#666666" size="-1"><em>(par defaut 150 caractères)</em></font></td>
        <td width="144"><input name="url_maxTexte_width" type="text" id="url_maxTexte_width" value="<?php echo $my_ms['maxTexte']; ?>"></td>
      </tr>
      
      <tr> 
        <td width="545"><strong>C&eacute;sure automatique&nbsp; </strong><font color="#666666" size="-1"><em>(Les  mots trop long (par defaut : 15))</em></font></td>
        <td width="144"><input name="url_tab_cesure" type="text" id="url_tab_cesure" value="<?php echo $my_ms['cesure']; ?>"></td>
      </tr>

      <tr> 
        <td width="545"><strong>Sens de l'affichage </strong><font color="#666666" size="-1"><em>(Du plus vieux au plus nouveau ou le contraire)</em></font></td>
        <td width="144">
          <?php
          $lessens='';
          $lessens['up']='Ascendant'; $lessens['down']='Descendant';
          
          echo '<select name="url_sens" id="url_sens">';
          echo '<option value="'.$my_ms['lesens'].'" selected>'.$lessens[$my_ms["lesens"]].' </option>';
          echo '<option value="down">Descendant</option>';
          echo '<option value="up">Ascendant </option>';
          echo '</select>';
          ?>
        </td>
      </tr>

<?php
}

################################################################
################################################################
## Cas options #
################################################################
################################################################

elseif($module=="options"){
print $set_form;
		include("../admin/".$module.".php");

?>
          <tr> 
            <td height="38"><strong><font color="#990000">Options</font></strong><br></td>
            <td></td>
          </tr>
    <tr> 
      <td width="545" height="28"><b>Décalage horaire</b> <br>
      <font size="-1"><em><font color="#666666">Par rapport &agrave; GMT (defaut +1)</font></td>
      <td width="144">
      <?php	
      $c=1;
      $nbrA=12;	
      echo '<select width="3" name="url_hDeca" id="url_hDeca">';
      echo '<option value="'.$my_ms['hDeca'].'">'.$my_ms['hDeca'].' </option>';
      while($c<=$nbrA){
           if($my_ms['hDeca']!=$c){
           echo '<option value="'.$c.'"> +'.$c.' </option>';
           }
      $c++;
      }
      $c=-1;
          while($c>=-12){
           if($my_ms['hDeca']!=$c){
           echo '<option value="'.$c.'"> '.$c.' </option>';
          }
      $c--;
      }
      echo '</select> &nbsp;&nbsp;'.gmdate("H:i", time() + 3600*($my_ms['hDeca']+date("I")));
      ?>
      </td>
    </tr>
    <?php
    ($my_ms["auto_refresh"]==1)?$refreshAuto='<option value="1" selected>Oui</option><option value="0">Non</option>':$refreshAuto='<option value="0" selected>Non</option><option value="1">Oui</option>';
    ?>
    <tr> 
      <td width="545" height="28"><strong>Refresh automatique ou non ?</strong><font size="-1"><br></td>
      <td width="144"><select width="3" name="url_refresh_auto" id="url_refresh_auto"><?php echo $refreshAuto ?></select></td>
    </tr>
    <tr> 
      <td width="545" height="28"><strong>Vitesse du refresh automatique</strong><font size="-1"><em><font color="#666666">(par defaut 4000 mls)</font></em><br></td>
      <td width="144"><input name="url_refresh_speed" type="text" id="url_refresh_speed" value="<?php echo $my_ms['refresh_speed']; ?>"></td>
    </tr>
    <tr valign="middle">   
      <td><strong>Afficher le compteur de connecté ?<br>
      </strong><font size="-1"><em><font color="#666666">(Apparai sous la forme : x online)</font></font></em><br></td>
      <td> 
<?php	
if($my_ms['af_counter']=="1"){
  $Kase="Oui";
  $Kase2="Non";
  $sec=0;
}
if($my_ms['af_counter']=="0"){
  $Kase="Non";
  $Kase2="Oui";
  $sec=1;
}
      echo '<select width="3" name="url_counter_on" id="url_counter_on">';
      echo '<option value="'.$my_ms['af_counter'].'" selected>'.$Kase.' </option>';
      echo '<option value="'.$sec.'">'.$Kase2.' </option>';
      echo '</select>';
      
$Kase=""; $sec="";
$Kase2=""; $sec="";
?>
      </td>
    </tr>
          
          
      <tr valign="middle">   
      <td><strong>Afficher l'historique ?<br>
        </strong><font size="-1"><em><font color="#666666">(Lien sur la page daccueil, visible ou non)</font><br></em></font></td>
      <td> 
      <?php	
if($my_ms['af_historique']=="1"){
  $Kase="Oui";
  $Kase2="Non";
  $sec=0;
}
if($my_ms['af_historique']=="0"){
  $Kase="Non";
  $Kase2="Oui";
  $sec=1;
}
      echo '<select width="3" name="url_historique_on" id="url_historique_on">';
      echo '<option value="'.$my_ms['af_historique'].'" selected>'.$Kase.' </option>';
      echo '<option value="'.$sec.'">'.$Kase2.' </option>';
      echo '</select>';
      
$Kase=""; $sec="";
$Kase2=""; $sec="";
?>
            </td>
          </tr>
      <tr valign="middle">   
      <td><strong>Afficher le lien SMILEYS ?<br>
        </strong><font size="-1"><em><font color="#666666">(Lien sur la page daccueil, visible ou non)</font><br></em></font></td>
      <td> 
              <?php	
if($my_ms['af_smiley']=="1"){
$Kase="Oui";
$Kase2="Non";
$sec=0;
}
if($my_ms['af_smiley']=="0"){
$Kase="Non";
$Kase2="Oui";
$sec=1;
}
      echo '<select width="3" name="url_smileys_on" id="url_smileys_on">';
      echo '<option value="'.$my_ms['af_smiley'].'" selected>'.$Kase.' </option>';
      echo '<option value="'.$sec.'">'.$Kase2.' </option>';
      echo '</select>';
	  
$Kase=""; $sec="";
$Kase2=""; $sec="";
?>
            </td>
        </tr>

      <tr valign="middle">   
      <td><strong>Afficher les options de mis en page ?<br>
        </strong><font size="-1"><em><font color="#666666">(gras, italique soulign&eacute; et couleurs)</font><br></em></font></td>
      <td> 
              <?php	
if($my_ms["wisiwyg"]=="1"){
$Kase="Oui";
$Kase2="Non";
$sec=0;
}
if($my_ms["wisiwyg"]=="0"){
$Kase="Non";
$Kase2="Oui";
$sec=1;
}
      echo '<select width="3" name="url_wisiwyg" id="url_wisiwyg">';
      echo '<option value="'.$my_ms["wisiwyg"].'" selected>'.$Kase.' </option>';
      echo '<option value="'.$sec.'">'.$Kase2.' </option>';
      echo '</select>';
	  
$Kase=""; $sec="";
$Kase2=""; $sec="";
?>
            </td>
        </tr>
        
      <tr valign="middle"> 
      <td>
        <strong>Afficher les smileys sur la page d'accueil?</strong><br> <font color="#666666" size="-1">(Les smileys, en dessous du formulaire, doivent etre visible ou non?)</font><br> <font size="-1"><em> </em></font></td>
      <td> 
      <?php	
if($my_ms['af_img_smileys']=="1"){
  $Kase="Oui";
  $Kase2="Non";
  $sec=0;
}
if($my_ms['af_img_smileys']=="0"){
  $Kase="Non";
  $Kase2="Oui";
  $sec=1;
}
      echo '<select width="3" name="url_style_smileys" id="url_style_smileys">';
      echo '<option value="'.$my_ms['af_img_smileys'].'" selected>'.$Kase.' </option>';
      echo '<option value="'.$sec.'">'.$Kase2.' </option>';
      echo '</select>';
?>
            </td>
          </tr>
          
          <tr> 
            <td width="545" height="28"><strong>Nbr de messages affich&eacute; </strong><font size="-1"><em><font color="#666666">(par defaut 8)</font></em><br></td>
            <td width="144"><input name="url_nbr" type="text" id="url_nbr" value="<?php echo $_nbr_; ?>"></td>
          </tr>
          
          <tr> 
            <td width="545" height="28"><strong>Type de lien</strong><font size="-1"><em><font color="#666666"> (par defaut 'lien')</font></em><br></td>
            <td width="144">
      <?php
      echo '<select width="3" name="url_linktype" id="url_linktype">';
      echo '<option value="'.$my_ms['typedelien'].'" selected>'.$my_ms['typedelien'].' </option>';
      echo '<option value="lien">Lien</option>';
      echo '<option value="url">Url</option>';
      echo '</select>';
      ?>
            </td>
          </tr>

          <tr> 
            <td height="28"><strong>Mots à interdire : </strong><em><font color="#666666" size="-1">(Séparer par des | (barre (alt Gr+6))</font></em></td>
            <td><input name="url_stop" type="text" id="url_stop" value="<?php echo $my_ms['stop']; ?>"></td>
          </tr>

          <tr> 
            <td height="28"><strong>Liste d'ips &agrave; bannir : </strong><em><font color="#666666" size="-1">(Séparer par des virgules)</font></em></td>
            <td><input name="url_ipstop" type="text" id="url_ipstop" value="<?php echo $my_ms['ipstop']; ?>"></td>
          </tr>
            <?php
            // Gestion des moderateurs
            // La var elle meme est juste : pseudo|motdepasse,pseudo2|motdepasse2, etc...
            // Donc, pas de | ou de , dans le login ou mot de passe.
            $all_modo='';
            $mod_temp=explode(',',$my_ms['moderateur']);
            // print_r($mod_temp);
            foreach ($mod_temp as $clf=>$data) {
              if($data!=""){
              $mod_user=explode('|',$data);
              $all_modo.='Login : <input name="modo_login[]" type="text" value="'.$mod_user['0'].'"> <br /> Mot de passe : <input name="modo_pass[]" type="text" value="'.$mod_user['1'].'"> <br />';
              }
              $all_modo.='<br>&nbsp;';
            }
            ?>
            
          <tr valign="top"> 
            <td height="28"><br>
              <strong>Liste de mod&eacute;rateurs : </strong><i>Supprimer en vidant le formulaire</i> <br />
              
              <a href="javascript:void()" onclick="montre('ajoutmodo','block');"><b>Ajouter un mod&eacute;rateur</i></a>
              <div id="ajoutmodo" style="display:none;margin:5px;width:300px;border:1px solid #999999;padding:3px;background-color:#EEEEEE">
              Login : <input name="modo_login[]" type="text"> <br /> 
              Mot de passe : <input name="modo_pass[]" type="text">
              <p class="closeshut"><a href="javascript:void()" onclick="montre('ajoutmodo','none');">Cacher</a></p>
              </div>
              
              </td>
            <td><br><?=$all_modo?></td>
          </tr>
<?php


################################################################
################################################################
//cas de editor css
}elseif($module=="css"){

if($_POST) {
    $post=$_POST;
    $tout=''; $lecommentaire='';

    foreach($post as $clef=>$valeur){
    
      if(eregi('_111_',$clef)){
        $lecommentaire=$valeur;
      }
      
      if($valeur!="" AND $clef!='admin_save' AND $clef!='module' AND !eregi('_111_',$clef)){
        $nclef=str_replace('123dot123','.',$clef);
        $nclef=str_replace('123space123',' ',$nclef);
        $nclef=trim($nclef);
        
        $tout.=trim($nclef).' { ';
        
          foreach($valeur as $clef2=>$attributs){
            if(trim($attributs)!=""){
              $tout.=trim($clef2).':'.trim($attributs).'; ';
            }
          }
        
        $tout.='} '.trim($lecommentaire).' '."\n";
        $lecommentaire='';
      }
    }

      $fp=fopen("../saves/styles.css","w+");
			fputs($fp,stripslashes($tout));
      fclose($fp);

      //sauvegarde en cas de restauration
        my_MS_countfilesandclean('temp',9);
        $fp=fopen("temp/".mktime(),"w+");
        fputs($fp,$tout);
        fclose($fp);
      //fin de la gestion des sauvegarde
}

$skin=explode('/',$my_ms['skin']);

echo '
      <tr> 
        <td height="38" colspan="2">
        <br />
        <strong><font color="#990000">Css Editor</font></strong><br>
        A chaque fois que vous changez la feuille de style, elle est enregistr&eacute;e. <br>
        Si vous voulez revenir &agrave; la version pr&eacute;c&eacute;dente, s&eacute;lectionnez la version dans le menu audessus et cliquer sur <b>restaurer</b> .
        <br />Skin actuel: <b>'.$skin[2].'</b>, pour ce skin l\'url des images est <b>'.$skin[1].'/'.$skin[2].'/nom_image</b><br />&nbsp;
        </td>
      </tr></tr><td colspan="2">
      <div style="height:550px;overflow:auto">
      ';
print '<iframe style="float:right;" src="ad_css.php" height="550px" width="300px" frameborder="0"></iframe>';
$tableau=file('../saves/styles.css');
foreach($tableau as $clef=>$ligne) {
  
    $temp=explode('{',$ligne);
    $nom=$temp[0];
    $temp2=$temp[1];
    $temp2=explode('}',$temp2);
    $data=$temp2[0];
    $commentaires=$temp2[1];

    $data=explode(';',$data);
        $nom_post=str_replace('.','123dot123',$nom);
    $nom_post=str_replace(' ','123space123',$nom_post);
    echo '

      <div><b><a href="javascript:void()" onclick="montre(\''.$nom_post.'\',\'block\');">'.$nom.'</a></b> &nbsp;&nbsp; <i>'.str_replace('/*','',str_replace('*/','',$commentaires)).'</i></div>

<div id="'. $nom_post.'" style="display:none;" >';

    foreach($data as $clef2=>$valeur) {
      if(trim($valeur)!=''){
      $temp3=explode(':',$valeur);
      
        $ceform='
        <input type="hidden" name="_111_'.$nom_post.'["cmt"]" value="'.$commentaires.'"/>
        '.$temp3[0].' :  <input type="text" name="'.$nom_post.'['.trim($temp3[0]).']" value="'.trim($temp3[1]).'"/>';

      echo $ceform.'<br />';
      }
    }
    echo '<p class="closeshut"><a href="javascript:void()" onclick="montre(\''.$nom_post.'\',\'none\');">Cacher</a></p></div>';

}
print '
  </div>
  </td></tr>';
#######################################################
#######################################################
//Fin des cas
}else{
exit("");
}
?>
          <tr>

            <td>
              <input name="url_rep" type="hidden" id="url_rep" value="<?php echo $my_ms['rep']; ?>">
              <input name="module" type="hidden" id="module" value="<?php echo $module; ?>">
            </td>

            <td>
              <br><input type="submit" name="admin_save" value="Editer la configuration &gt;&gt;">
            </td>
          </tr>

      </table>  
<?php
}else{
echo '<tr><td>';
}
?>



<!--  on enregistre : -->

<?PHP
###################################################################
###################################################################
if($_POST){

  if(isset($_POST['module'])){ $module=$_POST['module']; }else{ $module=''; }



	switch($module){





  //cas de editor CSS
  case 'skins':
  
  if(trim($_POST['remoteskin'])!=""){
    $remotefile=trim($_POST['remoteskin']);
  }elseif(trim($_POST['remoteskin_2'])!="") {
    $remotefile=trim($_POST['remoteskin_2']);
  }else{
    $remotefile='';
  }
  
  
  if(trim($remotefile)!=""){
    $temp=explode('/',$remotefile);
    $filename=$temp[count($temp)-1];
    $handle = fopen($remotefile, 'rb');
    while (!feof($handle)) {
      $contents.= fread($handle, 99999999999999);
    }
    fclose($handle);
    $fp=fopen("skins/$filename","w+");
    fputs($fp,$contents);
    fclose($fp);
    
    include('pclzip.lib.php');
    $oldumask = umask(0);
    $archive = new PclZip("skins/$filename");
    if ($archive->extract(PCLZIP_OPT_PATH, '../saves/skin',
                          PCLZIP_OPT_REMOVE_PATH, 'install/release') == 0) {
      die("Error : ".$archive->errorInfo(true));
    }
    umask($oldumask);
  }

  $leskin='saves/skin/'.addslashes($_POST['les_skins']);
  if($leskin!=$my_ms['skin']){
    $cssfile='../'.$leskin.'/styles.css';
    $handle = fopen ($cssfile, "r");
    $contents = fread ($handle, filesize ($cssfile));
    fclose ($handle);
    $fp=fopen("../saves/styles.css","w+");
    fputs($fp,$contents);
    fclose($fp);
    
$fp=fopen("config.php","w");
$data='<?php
//Mettez ici l adresse exact de votre site sans / a la fin :
//Metez votre véritable adresse, pas une redirection, ni une adresse du genre ulimit.

$my_ms["site"]="'.$my_ms["site"].'";    //Votre site
$my_ms["repertoire"]="'.$my_ms["repertoire"].'";    //depuis la racine http
$my_ms["absolu_root"]="'.$my_ms["absolu_root"].'";    //si pas exact, mettez ici la racine de votre serveur

$my_ms["id_unique"]="'.$my_ms["id_unique"].'"; //identifiant unique, pour savoir si une nouvelle version de myspeach existe

$my_ms["admin_login"]="'.$my_ms["admin_login"].'";                 //Votre Login
$my_ms["admin_mdp"]="'.$my_ms["admin_mdp"].'";                //Votre mot de passe

$my_ms["msg_txt"]="'.$my_ms["msg_txt"].'";             //Le nom du fichier texte qui enregistre (ne pas changer)

$my_ms["version"]="'.$my_ms['version'].'";
$my_ms["copyright"]="<a href=\"http://www.graphiks.net/\" target=\"_blank\" title=\"MySpeach\">MySpeach</a>";

$my_ms["skin"]="'.$leskin.'";    //le skin utilisé
?>
';
fputs($fp,$data);
fclose($fp);
  }


    echo '<br><br><center>Opération réussie [<b>'.$module.'</b>]. <br><a href="admin.php?mod='.$module.'">Retour</a><br><br></center>';
  break;
  
  
  
  
  //cas smileys
  case "smile":
    $T=$_POST['s_s'];
$complet = '<?php
$smileys=Array(';
    foreach ($T as $image1 => $signe1) {
      if($signe1!=""){
$complet .= "
  '".$signe1."' => '".$image1."', ";
      }
    }
$complet = rtrim($complet, ', ');
$complet .= "
);
?>
";
       
    $fp=fopen("../saves/smileys.php","w");
    $data=$complet;
    fputs($fp,$data);
    fclose($fp);

    echo '<br><br><center>Opération réussie [<b>'.$module.'</b>]. <br><a href="admin.php?mod='.$module.'">Retour</a><br><br></center>';
    break;





    //gestion skins
    case 'skins':

        echo '<br><br><center>Opération réussie [<b>'.$module.'</b>]. <br><a href="admin.php?mod='.$module.'">Retour</a><br><br></center>';
    break;




//Configuration
		case "config" : 
      $leskin='saves/skin/'.addslashes($_POST['les_skins']);
      if($leskin!=$my_ms['skin']){
        $cssfile='../'.$leskin.'/styles.css';
        $handle = fopen ($cssfile, "r");
        $contents = fread ($handle, filesize ($cssfile));
        fclose ($handle);
        
        $fp=fopen("../saves/styles.css","w+");
        fputs($fp,$contents);
        fclose($fp);
      }
      
$fp=fopen("$module.php","w");
$data='<?php
//Mettez ici l adresse exact de votre site sans / a la fin :
//Metez votre véritable adresse, pas une redirection, ni une adresse du genre ulimit.

$my_ms["site"]="'.$_POST['url_site'].'";    //Votre site
$my_ms["repertoire"]="'.$_POST['url_repertoire'].'";    //depuis la racine http
$my_ms["absolu_root"]="'.$_SERVER["DOCUMENT_ROOT"].'";    //si pas exact, mettez ici la racine de votre serveur

$my_ms["id_unique"]="'.$_POST['url_id_unique'].'"; //identifiant unique, pour savoir si une nouvelle version de myspeach existe

$my_ms["admin_login"]="'.$_POST['url_login'].'";                 //Votre Login
$my_ms["admin_mdp"]="'.$_POST['url_mdp'].'";                //Votre mot de passe

$my_ms["msg_txt"]="'.$_POST['url_message'].'";             //Le nom du fichier texte qui enregistre (ne pas changer)

$my_ms["version"]="'.$my_ms['version'].'";
$my_ms["copyright"]="<a href=\"http://www.graphiks.net/\" target=\"_blank\" title=\"MySpeach\">MySpeach</a>";

$my_ms["skin"]="'.$leskin.'";    //le skin utilisé
?>
';

			if(fputs($fp,$data)){
        fclose($fp);
        echo '<br><br><center>Opération réussie [<b>'.$module.'</b>]. <br><a href="admin.php?mod='.$module.'">Retour</a><br><br></center>';
			}else{
        echo '<br><br><center>Un problème est survenue. <br><a href="admin.php?mod='.$module.'">Retour</a><br><br></center>';
			}
		break;






    //option
		case "options" :
    
    $moderateur='';
    if(trim($_POST['modo_login'])!="" AND trim($_POST['modo_pass'])!="") {
      $modologin=stripslashes($_POST['modo_login']);
      $modopass=stripslashes($_POST['modo_pass']);

        foreach($_POST['modo_login'] as $clef=>$data) {
          if($data!=""){
          $temp_login[]=$data;
          }
        }
        foreach($_POST['modo_pass'] as $clef=>$data) {
          if($data!=""){
          $temp_pass[]=$data;
          }
        }
        if($temp_login[0]!='' AND $temp_pass[0]!=''){
        foreach($temp_login as $key=>$data) {
          if($data!=""){
          $moderateur.=$data.'|'.$temp_pass[$key].',';
          }
        }
        $moderateur=rtrim($moderateur,',');
        }

    }

$fp=fopen("$module.php","w");
$data='<?php
//Mot interdit d affichage sur le chat
//SURTOUT : Respecter le format -> pas d espace ou de | au debut et rien à la fin non plus !!!
//EX : pour rajouter un mot, tapez à la suite : |lemot
//mais surtout pas |lemot|
$my_ms["stop"]="'.$_POST['url_stop'].'";

/* ban par ip : ip séparé par une virgule */
$my_ms["ipstop"]="'.$_POST['url_ipstop'].'";

/* liste des moderateurs. ex : pseudo|motdepasse,pseudo2|motdepasse2   etc ... */
$my_ms["moderateur"]="'.$moderateur.'";

$my_ms["hDeca"]='.$_POST['url_hDeca'].';                 // Decalage horaire
$my_ms["auto_refresh"]='.$_POST['url_refresh_auto'].';            // Refresh autamatique ou non.
$my_ms["refresh_speed"]='.$_POST['url_refresh_speed'].';       // vitesse du refresh
$_nbr_='.$_POST['url_nbr'].';                      // Nombre de messages que vous voulez voir afficher
$my_ms["af_counter"]='.$_POST['url_counter_on'].';            // Afficher ou non le compteur de connecté
$my_ms["af_smiley"]=1;             // Afficher ou non les smileys?
$my_ms["af_historique"]='.$_POST['url_historique_on'].';         // Afficher ou non le lien vers l\'historique
$my_ms["af_img_smileys"]='.$_POST['url_style_smileys'].';        // Afficher ou non les smileys cliquable
$my_ms["typedelien"]="'.$_POST['url_linktype'].'";       // lien ou url (url affichera le vraiu lien cliquable, lien affichera juste le mot LIEN cliquable)
$my_ms["wisiwyg"]='.$_POST['url_wisiwyg'].';             // les boutons de mise en page
?>';  


			if(fputs($fp,$data)){
        fclose($fp);
        echo '<br><br><center>Opération réussie [<b>'.$module.'</b>]. <br><a href="admin.php?mod='.$module.'">Retour</a><br><br></center>';
			}else{
        echo '<br><br><center>Un problème est survenue. <br><a href="admin.php?mod='.$module.'">Retour</a><br><br></center>';
			}
		break;
    
		//setup
		case "setup" :
$fp=fopen("$module.php","w");
$data='<?php
$my_ms["chat_titre"]="'.$_POST['url_chat_titre'].'";               // Titre du chat (defaut MySpeach)
$my_ms["maxTexte"]='.$_POST['url_maxTexte_width'].';               // Nbr de caractere max par ligne
$my_ms["cesure"]='.$_POST['url_tab_cesure'].';                     // Coupe tous les mots qui sont plus lonbg que ce nbr de lettres
$my_ms["lesens"]="'.$_POST['url_sens'].'";                           // Sens d affichage du chat
?>';  


			if(fputs($fp,$data)){
        fclose($fp);
        echo '<br><br><center>Opération réussie [<b>'.$module.'</b>]. <br><a href="admin.php?mod='.$module.'">Retour</a><br><br></center>';
			}else{
        echo '<br><br><center>Un problème est survenue. <br><a href="admin.php?mod='.$module.'">Retour</a><br><br></center>';
			}
		break;
	}		

echo '</tr></td></table>';
}
?>




  <br><center>
  BackEnd de MySpeach Version <?php echo $my_ms['version']; ?><br>
Fais par <a href="http://www.graphiks.net">GUNNING Sky</a> et Guillouet Bruno
</center>
<br></div>
</body>
</html>

<script type="text/javascript">
function montre(id,vu) {
document.getElementById(id).style.display=vu;
}
</script>
