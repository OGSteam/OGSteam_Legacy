<?php
/***********************************************************************
MACHINE

************************************************************************/
// Make sure no one attempts to run this script "directly"
if (!defined('PUN'))
	exit;
// Tell admin_loader.php that this is indeed a plugin and that it is loaded
define('PUN_PLUGIN_LOADED', 1);
define('PLUGIN_URL', $_SERVER['REQUEST_URI']);

define('PUN_ROOT', './');
/// parser pour le texte des tutos...
require PUN_ROOT.'include/parser.php';
// Load the index.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/index.php';

define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';


/// variable globale ogpt
$request = "select * from ogpt";
$result = $db->query($request);
while (list($name, $value) = $db->fetch_row($result)) {
    $ogpt[$name] = stripslashes($value);
}



if (isset($_POST['couleur']))
{


///securisation 
$i=pun_trim($_POST['i']);
$db->query('UPDATE ogpt SET conf_value=\''.$i.'\' WHERE conf_name= \'i\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$iI=pun_trim($_POST['iI']);
$db->query('UPDATE ogpt SET conf_value=\''.$iI.'\' WHERE conf_name= \'iI\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$v=pun_trim($_POST['v']);
$db->query('UPDATE ogpt SET conf_value=\''.$v.'\' WHERE conf_name= \'v\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$d=pun_trim($_POST['d']);
$db->query('UPDATE ogpt SET conf_value=\''.$d.'\' WHERE conf_name= \'d\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$b=pun_trim($_POST['b']);
$db->query('UPDATE ogpt SET conf_value=\''.$b.'\' WHERE conf_name= \'b\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$iv=pun_trim($_POST['iv']);
$db->query('UPDATE ogpt SET conf_value=\''.$iv.'\' WHERE conf_name= \'iv\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$iIv=pun_trim($_POST['iIv']);
$db->query('UPDATE ogpt SET conf_value=\''.$iIv.'\' WHERE conf_name= \'iIv\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$bv=pun_trim($_POST['bv']);
$db->query('UPDATE ogpt SET conf_value=\''.$bv.'\' WHERE conf_name= \'bv\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$bvi=pun_trim($_POST['bvi']);
$db->query('UPDATE ogpt SET conf_value=\''.$bvi.'\' WHERE conf_name= \'bvi\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$bvIi=pun_trim($_POST['bvIi']);
$db->query('UPDATE ogpt SET conf_value=\''.$bvIi.'\' WHERE conf_name= \'bvIi\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());

$f=pun_trim($_POST['f']);
$db->query('UPDATE ogpt SET conf_value=\''.$f.'\' WHERE conf_name= \'f\'') or error('Unable to update couleur', __FILE__, __LINE__, $db->error());
/// fin secu


/// fin secu

/// regeeration du cache avant redirection :

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();


///redirection pour prise en compte dans la page
$redirection="Modifications prises en compte"; redirect(PLUGIN_URL, $redirection);



}





if (isset($_POST['admin_ogs']))
{


///securisation de nom et mdp
$galaxie=pun_trim($_POST['galaxie']);
$systeme=pun_trim($_POST['systeme']);
$prefix=pun_trim($_POST['prefixe']);


// verif numerique

if (!is_numeric($systeme)){$redirection="Nous ne nous comprennons plus 2"; redirect('index.php', $redirection);}
if (!is_numeric($galaxie)){$redirection="Nous ne nous comprennons plus 1"; redirect('index.php', $redirection);}



/// mise a jour du nb de galaxie et systeme
	$db->query('UPDATE '.$db->prefix.'config SET conf_value='.$galaxie.' WHERE conf_name= \'gal\'') or error('Unable to update board config', __FILE__, __LINE__, $db->error());

$db->query('UPDATE '.$db->prefix.'config SET conf_value='.$systeme.' WHERE conf_name=\'sys\'') or error('Unable to update board config', __FILE__, __LINE__, $db->error());

$db->query('UPDATE '.$db->prefix.'config SET conf_value=\''.$prefix.'\' WHERE conf_name=\'ogspy_prefix\'') or error('Unable to update board config', __FILE__, __LINE__, $db->error());

/// regeeration du cache avant redirection :

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();


///redirection pour prise en compte dans la page
$redirection="Modifications prises en compte"; redirect(PLUGIN_URL, $redirection);


}

/// mise a jour de l'ordre des modules

if (isset($_POST['mod_ogs']))
{
  ///premier filtre :
  $lien=pun_trim($_POST['lien']);
  $nom=pun_trim($_POST['nom']);
  $ordre=pun_trim($_POST['ordre']);
  $actif=pun_trim($_POST['actif']);
  //verif des valeurs numeriques
if (!is_numeric($ordre)){$redirection="Nous ne nous comprennons plus 4"; redirect('index.php', $redirection);}
if (!is_numeric($actif)){$redirection="Nous ne nous comprennons plus 5"; redirect('index.php', $redirection);}

  /// verif valeur null
  if ( $nom =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $lien =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $actif =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $ordre =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}

 //nom
 $sql = 'UPDATE mod_fofo_ogs SET title = \''.$nom.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update nom", __FILE__, __LINE__, $db->error());
 //ordre
 $sql = 'UPDATE mod_fofo_ogs SET ordre = \''.$ordre.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update nom", __FILE__, __LINE__, $db->error());

 //actif
 $sql = 'UPDATE mod_fofo_ogs SET actif = \''.$actif.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update nom", __FILE__, __LINE__, $db->error());


/// regeeration du cache avant redirection :

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();


///redirection pour prise en compte dans la page
$redirection="Modifications prises en compte"; redirect(PLUGIN_URL, $redirection);



}


if (isset($_POST['pan_ogs']))
{
  ///premier filtre :
  $lien=pun_trim($_POST['lien']);
  $ordre=pun_trim($_POST['ordre']);
  $actif=pun_trim($_POST['actif']);
    $secu=pun_trim($_POST['secu']);
  //verif des valeurs numeriques
if (!is_numeric($ordre)){$redirection="Nous ne nous comprennons plus 4"; redirect('index.php', $redirection);}
if (!is_numeric($actif)){$redirection="Nous ne nous comprennons plus 5"; redirect('index.php', $redirection);}
if (!is_numeric($secu)){$redirection="Nous ne nous comprennons plus 8"; redirect('index.php', $redirection);}

  /// verif valeur null
  if ( $secu =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $lien =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $actif =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}
  if ( $ordre =="" ){$redirection="Nous ne nous comprennons plus 6"; redirect('index.php', $redirection);}

 //secu
 $sql = 'UPDATE colonne SET secu = \''.$secu.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update secu", __FILE__, __LINE__, $db->error());
 //ordre
 $sql = 'UPDATE colonne SET ordre = \''.$ordre.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update ordre", __FILE__, __LINE__, $db->error());

 //actif
 $sql = 'UPDATE colonne SET actif = \''.$actif.'\'  WHERE lien = \''.$lien.'\' ';
 $query = $db->query($sql) or error("Impossible to update actif", __FILE__, __LINE__, $db->error());


/// regeeration du cache avant redirection :

	require_once PUN_ROOT.'include/cache.php';
	generate_config_cache();


///redirection pour prise en compte dans la page
$redirection="Modifications prises en compte"; redirect(PLUGIN_URL, $redirection);



}






// Display the admin navigation menu
generate_admin_menu($plugin);
?>
	



<div class="blockform"><h2><span> Administration forum / ogspy</span></h2><div class="box">


 <fieldset>
						<legend>paramettrez votre cartographie : </legend>
 <?php
echo'<p align="center">la cartographie est actuellement configuree pour :<br>'.$pun_config['gal'].' Galaxies <br> '.$pun_config['sys'].' systemes <br>';




  ?>

						<div class="infldset">


<form id="admin_ogs" method="post" action="<?php echo PLUGIN_URL; ?>">
   <div class="inform">


						<input type="hidden" name="admin_ogs"  accesskey="s" />
						<label class="conl">Nombre de galaxie  <br /><input type="text"  name="galaxie" size="2" maxlength="2" value="<?php echo''.$pun_config['gal'].''; ?>" /><br /></label>
						<label class="conl">Nombre de systeme <br /><input type="text"  name="systeme" size="3" maxlength="3"  value="<?php echo''.$pun_config['sys'].''; ?>" "/> <br /></label>
						<label class="conl">prefixe de votre ogspy  <br /><input type="text"  name="prefixe" size="20" maxlength="20" value="<?php echo''.$pun_config['ogspy_prefix'].''; ?>" /><br /></label>

			</div>







			<p><input type="submit"   /></p>
		</form>
</div>
   </fieldset>















<br />



	</div>
</div>



<div class="blockform"><h2><span> Administration forum / modules</span></h2><div class="box">


 <fieldset>
 <legend>modules actifs : </legend>



<form id="mod_ogs" method="post" action="<?php echo PLUGIN_URL; ?>">
                                                <input type="hidden" name="mod_ogs"  accesskey="s" />
                                                <select name="lien" tabindex="3"><?php $sql = 'SELECT *  FROM mod_fofo_ogs   ORDER BY ordre asc ';
   $result = $db->query($sql);
        while($mod = $db->fetch_assoc($result))
   {  echo ' 	<option value="'.$mod['lien'].'">'.$mod['title'].'</option> '; }
   echo ' </select>

						nom :<input type="text"  name="nom" size="20" maxlength="20" value="" />
						actif :<select name="actif" tabindex="3">
                                                <option value="1">oui</option>
                                                <option value="0">non</option>
                                                        </select>
						ordre :<select name="ordre" tabindex="2">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                        </select>
                                                <input type="submit"   />
</form> ';



echo '<table border="0" cellpadding="2" cellspacing="0" align="center"';
echo '<tr><th><b>nom</b></th><th><b>ordre</b></th><th><b>actif</b></th><th><b>lien</b></th><th><b>dev.(version)</b></th>';

   /// ableau recapitulatif des mod/liens
$sql = 'SELECT *  FROM mod_fofo_ogs   ORDER BY ordre asc ';
   $result = $db->query($sql);
        while($mod = $db->fetch_assoc($result))
   {


     echo'<tr>';
     echo'<td><center></center>'.$mod['title'].'</td>';
     echo' <td><center>'.$mod['ordre'].'</center></td>';
     if ( $mod['actif'] == 1 ) { echo ' <td><center>actif</center></td>';} else { echo ' <td><center>non actif</center></td>';}
     echo'<td><center>'.$mod['lien'].'</center></td>';
     echo'<td><center>'.$mod['developpeur'].' ('.$mod['version'].')</center></td>';
     echo '</tr> ';

   }
       echo'</table> ';

?>
 </fieldset>
  <br>




	</div>
</div>



<div class="blockform"><h2><span> Administration Galaxie</span></h2><div class="box">
<script type="text/javascript" src="ogpt/js/CP_Class.js"></script>
<script type="text/javascript">
window.onload = function()
{
 fctLoad();
}
window.onscroll = function()
{
 fctShow();
}
window.onresize = function()
{
 fctShow();
}
</script>

 <fieldset>
						<legend>paramettrez les couleurs du mod galaxie en fonction du statut : </legend>

						<div class="infldset">


<form name="objForm" id="couleur" method="post" action="<?php echo PLUGIN_URL; ?>">
   <div class="inform">

<link rel="stylesheet" type="text/css" href="style/ColorPicker.css" />
		<input type="hidden" name="couleur"  accesskey="s" />
				<label class="conl">statut : <font color="<?php echo''.$ogpt['i'].''; ?>">i</font>  <br />
						<input type="text"  name="i" size="7" maxlength="7" value="<?php echo''.$ogpt['i'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.i);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['iI'].''; ?>">iI</font> <br /> 
						<input type="text"  name="iI" size="7" maxlength="7" value="<?php echo''.$ogpt['iI'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.iI);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['d'].''; ?>">d</font>  <br />
						<input type="text"  name="d" size="7" maxlength="7" value="<?php echo''.$ogpt['d'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.d);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['v'].''; ?>">v</font>  <br />
						<input type="text"  name="v" size="7" maxlength="7" value="<?php echo''.$ogpt['v'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.v);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['iv'].''; ?>">iv</font>  <br />
						<input type="text"  name="iv" size="7" maxlength="7" value="<?php echo''.$ogpt['iv'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.iv);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['iIv'].''; ?>">iIv</font>  <br />
						<input type="text"  name="iIv" size="7" maxlength="7" value="<?php echo''.$ogpt['iIv'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.iIv);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['b'].''; ?>">b</font>  <br />
						<input type="text"  name="b" size="7" maxlength="7" value="<?php echo''.$ogpt['b'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.b);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['bv'].''; ?>">bv</font>  <br />
						<input type="text"  name="bv" size="7" maxlength="7" value="<?php echo''.$ogpt['bv'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.bv);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['bvi'].''; ?>">bvi</font>  <br />
						<input type="text"  name="bvi" size="7" maxlength="7" value="<?php echo''.$ogpt['bvi'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.bvi);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['bvIi'].''; ?>">bvIi</font>  <br />
						<input type="text"  name="bvIi" size="7" maxlength="7" value="<?php echo''.$ogpt['bvIi'].''; ?>" /><br />
						<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.bvIi);" style="cursor:pointer;"><br />
						</label>
				<label class="conl">statut : <font color="<?php echo''.$ogpt['f'].''; ?>">f</font>  <br />
							<input type="text"  name="f" size="7" maxlength="7" value="<?php echo''.$ogpt['f'].''; ?>" /><br />
							<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.f);" style="cursor:pointer;"><br />
							</label>
						
						
						

			</div>







			<p><input type="submit"   /></p>
		</form>
</div>
   </fieldset>















<br />



	</div>
</div>



<div class="blockform"><h2><span> Administration forum / panneaux</span></h2><div class="box">


 <fieldset>
 <legend>modules actifs : </legend>



<form id="pan_ogs" method="post" action="<?php echo PLUGIN_URL; ?>">
                                                <input type="hidden" name="pan_ogs"  accesskey="s" />
                                                <select name="lien" tabindex="3"><?php $sql = 'SELECT *  FROM colonne   ORDER BY ordre asc ';
   $result = $db->query($sql);
        while($mod = $db->fetch_assoc($result))
   {  echo ' 	<option value="'.$mod['lien'].'">'.$mod['title'].'</option> '; }
   echo ' </select>

						
						actif :<select name="actif" tabindex="3">
                                                <option value="1">oui</option>
                                                <option value="0">non</option>
                                                        </select>
                         	vue par :<select name="secu" tabindex="3">
                                                <option value="4">admin uniquement</option>
                                                <option value="3">acces ogspy</option>
												<option value="2">membres</option>
                                                <option value="0">autres</option>
                                                        </select>                               
						ordre :<select name="ordre" tabindex="2">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                        </select>
                                                <input type="submit"   />
</form> ';



echo '<table border="0" cellpadding="2" cellspacing="0" align="center"';
echo '<tr><th><b>nom</b></th><th><b>ordre</b></th><th><b>actif</b></th><th><b>lien</b></th><th><b>niveau de securite</b></th>';

   /// ableau recapitulatif des mod/liens
$sql = 'SELECT *  FROM colonne   ORDER BY ordre asc ';
   $result = $db->query($sql);
        while($mod = $db->fetch_assoc($result))
   {


     echo'<tr>';
     echo'<td><center></center>'.$mod['title'].'</td>';
     echo' <td><center>'.$mod['ordre'].'</center></td>';
     if ( $mod['actif'] == 1 ) { echo ' <td><center>actif</center></td>';} else { echo ' <td><center>non actif</center></td>';}
     echo'<td><center>'.$mod['lien'].'</center></td>';
   /// niveau de securite
	 if ( $mod['secu'] == 4 ) { echo ' <td><center>visible par admin seulement</center></td>';}
	 if ( $mod['secu'] == 3 ) { echo ' <td><center>visible par admin et utilisateur ogpt</center></td>';}
	 if ( $mod['secu'] == 2 ) { echo ' <td><center>visible par les membres du forum</center></td>';}
	 if ( $mod['secu'] == 0 ) { echo ' <td><center>visible par tous</center></td>';}

     echo '</tr> ';

   }
       echo'</table> ';

?>
 </fieldset>
  <br>




	</div>
</div>





  <div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>

    </div>

