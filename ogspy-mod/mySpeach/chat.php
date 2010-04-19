<?php
@session_start();
#################################################
# Copyrigh GUNNING Sky et Guillouet Bruno
# Modifiable a souhaits, a une seule condition :
#
#   ->  laisser le lien vers le site http://www.graphiks.net/ sur le chat.   <-
# 
# Version Originale non modifie
# Script est soumis a la licence CECCIL/GNU
#################################################


/* test si le chat est installé : */
if(!@file_exists($my_ms['root'].'/admin/config.php')){
  exit('<br /><p align="center">MySpeach n est pas encore installé.</p>');
}


//On inclu les fichiers de config
include($my_ms['root'].'/admin/config.php');
include($my_ms['root'].'/admin/options.php');
include($my_ms['root'].'/admin/setup.php');
include($my_ms['root'].'/admin/fonctions.php');

//::: Location de myspeach
  $my_ms['img_root']=$my_ms['repertoire'];

if(ereg('ifrance',$my_ms['root'])){
 include($my_ms['root'].'/jscript.php');
 }
/* definition de quelle est le dernier fichier de sauvegarde ($x)  */
$fp = fopen($my_ms['root'].'/saves/x.txt',"r");
$my_ms['x'] = fgets($fp,11);
fclose($fp);

($_COOKIE['myspeach_pseudo']!="")?$lepseudo=htmlentities($_COOKIE['myspeach_pseudo'], ENT_QUOTES):$lepseudo="Pseudo";
($my_ms["auto_refresh"]==1)?$refreshAutomatique="MY_MS_rafraichi(); ":$refreshAutomatique="";
my_MS_plus_un($lepseudo,$ip,$my_ms['root'].'/saves/ki.txt'); // envoi au compteur
if($_COOKIE['MS_config_col']!=""){
$choix_color=htmlentities($_COOKIE['MS_config_col'], ENT_QUOTES);
$lacouleur='MY_MS_block_clr(\''.$choix_color.'\');';
}
if($_COOKIE['MS_config_son']!=""){
$choix_son=htmlentities($_COOKIE['MS_config_son'], ENT_QUOTES);
$leson='MY_MS_cloche_droit();';
}else{ $choix_son="son";}
// si session pour vieux navigateur
 if($_SESSION['tst']=="norqst"){
  $lnk_smiley='<a href="javascript:void(0)" onclick="MY_MS_popup_smileys();">Plus</a>';
  $btn_form='<input tabindex="3" type="submit" name="myForm" value="GO !" />';
  ($my['af_historique']==1)?$btn_history='<a href="?f='.$my_ms["x"].'" target="_blank">Historique</a>':$btn_history='';
   //$lnk_couleurs='<img src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/pal.gif" alt="" title="Autres couleurs" onclick="MS_popTitle(\'Autres couleurs\');MS_ouvre(\'popupAddressbook\');return(false)"/>';
  $blok_ip='submit()';
}else{
   $return="false"; //pour up.php
   $dit_pseudo='MY_MS_request(\''.$my_ms['img_root'].'/ki.php?dit=\' + myspeach.MSpseudo.value,\'non\');';
   $part_pseudo='MY_MS_request(\''.$my_ms['img_root'].'/ki.php?part=\' + myspeach.MSpseudo.value,\'non\');';
   $dit_cookie='MY_MS_request(\''.$my_ms['img_root'].'/ki.php?dit='.$lepseudo.'\',\'non\');';
   $part_cookie='MY_MS_request(\''.$my_ms['img_root'].'/ki.php?part='.$lepseudo.'\',\'non\');';
   $lnk_smiley=' <a href="" onclick="MY_MS_request(\''.$my_ms['img_root'].'/smile.php?sm=ok&chm='.$my_ms['img_root'].'\',\'pop\');MY_MS_popTitle(\'Smileys\');MY_MS_ouvre(\'popupAddressbook\');return(false)">Plus</a>';
   $btn_form='<img class="go" src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/go.gif" tabindex="3" alt="Go!" name="myForm" align="center" onclick="'.$dit_pseudo.'MY_MS_checkForm();" />';
($my_ms['af_historique']==1)?$btn_history='<a href="" onclick="MY_MS_request(\''.$my_ms['img_root'].'/admin/histo.php?f='.$my_ms["x"].'&chm='.$my_ms['img_root'].'\',\'pop\');MY_MS_popTitle(\'Archives\');MY_MS_ouvre(\'popupAddressbook\');return(false)">Historique</a>':$btn_history='';
   $lnk_couleurs='<img src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/pal.gif" alt="" title="Autres couleurs" onclick="MY_MS_request(\''.$my_ms['img_root'].'/palette.php?chm='.$my_ms['img_root'].'&skin='.$my_ms['skin'].'\',\'pop\');MY_MS_popTitle(\'Autres couleurs\');MY_MS_ouvre(\'popupAddressbook\');return(false)"/>';
   $blok_ip='MY_MS_request(\''.$my_ms['img_root'].'/admin/blok_ip.php?slct_ip=\' +  this.options[this.selectedIndex].value,\'count\');';
 }

  //PreConf
  $my_ms['cettepage']=htmlentities($_SERVER["REQUEST_URI"], ENT_QUOTES);
  $my_ms['cettepage']=str_replace("&amp;","&",$my_ms['cettepage']);

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

  <head>
  <title>MySpeach</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="pragma" content="no-cache" />';

  //redirection pour le bon fonctionnement de lycos
  if(isset($_GET['f'])){
    print '<meta http-equiv="refresh" content="0; url='.$my_ms['img_root'].'/admin/histo.php?f='.$_GET['f'].'&xhr=non">';
    exit();
  }

  print '
   <script  type="text/javascript" src="'.$my_ms['img_root'].'/jscript.js"></script>
   <link href="'.$my_ms['img_root'].'/saves/styles.css" rel="stylesheet" type="text/css" />
   <style>';
	if(eregi("opera", $_SERVER['HTTP_USER_AGENT'])){ print '.petit_boutton {margin:-2px; font-size:0.9em;}';   }
  print '</style></head>

  <body onload="'.$leson.$lacouleur.$refreshAutomatique.'document.myspeach.MSmessage.focus();'.$dit_cookie.'" onunload="'.$part_cookie.'clearInterval();" onKeyDown="javascript:MY_MS_key(event);">
   ';

  print '<div id="MYtout" onmouseover="myms_overContextMenu = true" onmouseout="myms_overContextMenu = false" onmouseup="myms_overContextMenu = false;">';

$toutMySpeach="";
$toutMySpeach.='
<div class="MYtout">

    <p class="MStitre" onmousedown="MY_MS_startLayerDrag(\'MYtout\')" onmouseup="MY_MS_endLayerDrag()">'.$my_ms["chat_titre"].'</p>
    <ul id="toti_ms" class="MSli">';

/* On ouvre le fichier message.txt  */
$tableau=file($my_ms['root']."/saves/".$my_ms['msg_txt']);
/* On compte le nombre de ligne */
$nblignes=count($tableau);

/* On ouvre le for avec qui continue tant qu'il est < que $nbr || affichage en fonction de $my_ms["lesens"] * */
if($my_ms["lesens"]=='down'){
  for($i=0; $i<$nblignes; $i++){
    include($my_ms['root'].'/up.php');
  }
}else{
  for($i=$nblignes; $i>=0; $i--){
    include($my_ms['root'].'/up.php');
  }
}

/* L'affichage est fini, on peut afficher le formulaire */
$toutMySpeach.='
    </ul>
';

echo $toutMySpeach;

echo '  
    ';
?>
    <!-- Le formulaire pour ajouter un message ? MySpeach-->
  <div id="temoin"  ></div>
<div class="My_basduchat">
    <form style="margin-top:2px;margin-bottom:0" name="myspeach" method="post" action="<?php echo $my_ms['img_root']; ?>/save.php" onsubmit="return MY_MS_checkForm(this)">
    <table id="pal"><tr><td rowspan="3">

      <input style="width:80px" style="margin-top:2px;margin-bottom:0" type="text" name="MSpseudo" maxlength="20" value="<?php echo $lepseudo; ?>" onfocus="<?php echo $part_pseudo; ?>this.value='';"  />
      </td>
      
<?php
if($my_ms["wisiwyg"]==1){
  $colour=array( '#000000', '#0000ff', '#339900', '#ff0000', '#ffffff', '#990099', '#ff99cc', '#ffcc00');
  for($i=0;$i<8;$i++){
  print '<td class="color" bgcolor="'.$colour[$i].'"><img src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/transp5px.gif" alt="" title="'.$colour[$i].'" onclick="MY_MS_bbcode(\''.$colour[$i].'\',\'col\')" ondblclick="MY_MS_block_clr(\''.$colour[$i].'\')"/></td>';
  if($i==2){print '
  <td align="top" rowspan="3"style="cursor:default;">
    <div id="chr_b" class="petit_boutton"  onclick="MY_MS_bbcode(\'b\',\'txt\')">&nbsp;</div>
    <div id="chr_i" class="petit_boutton"  onclick="MY_MS_bbcode(\'i\',\'txt\')">&nbsp;</div>
    <div id="chr_u" class="petit_boutton"  onclick="MY_MS_bbcode(\'u\',\'txt\')">&nbsp;</div>
  </td></tr><tr>';}
  
  if($i==5){print '</tr><tr>';}
  }
  print '<td>'. $lnk_couleurs.'</td>';
}
?>

</tr></table>

      <input style="width:220px" style="margin-top:2px;margin-bottom:0;" type="text" name="MSmessage" maxlength="<?php echo $my_ms['maxTexte']; ?>" onfocus="MY_MS_timer()"/>
      <input style="width:20px" style="margin-top:2px;margin-bottom:0;" type="text" name="nbcar" disabled="disabled" />
      <?php
      print $btn_form;

       ?>
      <!-- Fin du formulaire -->
      <input type="hidden" name="nbr" value="<?php echo $nblignes; ?>" />
      <input type="hidden" name="cettepage" value="<?php echo $my_ms['cettepage'] ?>" />
    </form>
<?php

if($my_ms['af_img_smileys']==1){
$my_ms['r']=$my_ms['img_root'];

    echo '
      <a href="javascript:MY_MS_emoticon(\':)\')"><img src="'.$my_ms["r"].'/smiley/smile.gif" border="0" alt="MySpeach" /></a>
      <a href="javascript:MY_MS_emoticon(\';)\')"><img src="'.$my_ms["r"].'/smiley/icon_wink.gif" border="0" alt="MySpeach" /></a>
      <a href="javascript:MY_MS_emoticon(\':cry:\')"><img src="'.$my_ms["r"].'/smiley/icon_cry2.gif" border="0" alt="MySpeach" /></a>
      <a href="javascript:MY_MS_emoticon(\':D\')"><img src="'.$my_ms["r"].'/smiley/smly_mdr011.gif" border="0" alt="MySpeach" /></a>
      <a href="javascript:MY_MS_emoticon(\':roll:\')"><img src="'.$my_ms["r"].'/smiley/icon_rolleyes.gif" border="0" alt="MySpeach" /></a>
      <a href="javascript:MY_MS_emoticon(\':dow:\')"><img src="'.$my_ms["r"].'/smiley/icon_hum.gif" border="0" alt="MySpeach" /></a>
      ';
      
      print $lnk_smiley;
}

    //Ne pas effacer :
    echo '
      <div class="link" style="align:center">
        '.$my_ms["copyright"].' ';
    
      ($my_ms['af_historique']==1)?print $btn_history:print '';

      ($my_ms['af_counter']==1)?print '<br /><span id="count">'.my_MS_compteur($my_ms['root']."/saves/ki.txt").'</span>':print '<br /><span id="count"></span>';

    echo '
      </div>';
?>
<a name="endPage">&nbsp;</a>

</div><!-- div .My_basduchat -->
</div><!-- div .MYtout -->
<?php include($my_ms['root']."/".$my_ms['skin']."/skin.php"); // cet include permet de rajouter des elements suplementaires lors de la création de skins ?>
</div> <!-- div #MYtout -->

    <div id="popupAddressbook" >
	<div class="barre"   onmousedown="MY_MS_startLayerDrag('popupAddressbook')" onmouseup="MY_MS_endLayerDrag()" ondblclick="MY_MS_reduit('popupAddressbook')">
		<span id="pop_titre"></span>
		<a href="javascript:void(0)" onclick="MY_MS_reduit('popupAddressbook')" title="Reduire">
		<img class="reduire"  src="<? print $my_ms['img_root'].'/'.$my_ms['skin'].'/reduire.gif' ?>" border="none" /></a>&nbsp;
		<a href="javascript:void(0)" onclick="MY_MS_ferme('popupAddressbook')" title="Fermer">
		<img class="fermer"  src="<? print $my_ms['img_root'].'/'.$my_ms['skin'].'/fermer.gif' ?>" border="none"  /></a>
	</div>
      <div id="pop">
      <?php // if($_SESSION['tst']=="norqst"){include($my_ms['root'].'/palette.php');}else{print 'Chargement de la page...';}  ?>
      Chargement de la page...
      </div>
    </div>
  </div>

<div id="contextMenu">
   <?php
   if($list_ip!=''){
   $select_ip='
   <div  style="float:left"><img src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/coche.gif" title="ban ip" />
  <form name="blok" method="get" action="'.$my_ms['img_root'].'/admin/blok_ip.php"><select id="slct_ip" name="slct_ip" onchange="'.$blok_ip.'">
   <option value="">Ban IP</option>
   '.$list_ip.'
   </select><form></div>
   <a href="'.$my_ms['img_root'].'/admin/blok_ip.php?slct_ip=clear&xhr=no"   onclick="MY_MS_request(\''.$my_ms['img_root'].'/admin/blok_ip.php?slct_ip=clear\',\'count\');return(false);">
   <div  style="clear:left"><img src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/coche2.gif" /> Netoyer les IP</div></a>
   ';
  }
   $cntxt_menu.=
   str_replace("Plus","<div><img src=\"".$my_ms['img_root']."/".$my_ms['skin']."/fleche.gif\" /> Smileys</div>",$lnk_smiley).'
   '.str_replace("Historique","<div><img src=\"".$my_ms['img_root']."/".$my_ms['skin']."/histo.gif\" /> Historique</div>",$btn_history).'
   <a href="" onclick="MY_MS_cloche_droit();return(false)"><div>
   <img src="'.$my_ms['img_root']."/".$my_ms['skin'].'/cloche.gif" border="0" title="son/popup"/><span id="cloche">
    <img src="'.$my_ms['img_root']."/".$my_ms['skin'].'/coche2.gif" border="0" title="son/popup"/>  Mode sonore</span></div></a>
   <hr><a href="'.$my_ms['img_root'].'/admin" target="_blank"><div> <img src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/cadena.gif" /> Admin</div>
   </a><div id="list_ip"> '.$select_ip.'</div>
   <hr><a href="http://www.graphiks.net/" target="_blank" title="graphiks"><div><img src="'.$my_ms['img_root'].'/'.$my_ms['skin'].'/aide.gif" /> Aide MySpeach</div></a>
   <a href="http://www.myspeach.com/" target="_blank" title="www.MySpeach.com"><div>&Agrave; propos de MySpeach</div></a>
   <hr><div style="font-size:0.7em;">Heure serveur</div><div  id="hour" style="text-align:center;"></div>
   <hr>';

   print $cntxt_menu;
   ?>
</div> <!-- div #contextMenu -->
<div id="debug"></div> <!-- A virer avant la mise en ligne -->

<?php if(!ereg('ifrance',$my_ms['root'])){
 include($my_ms['root'].'/jscript.php');
 } ?>
   
</body>
</html>
