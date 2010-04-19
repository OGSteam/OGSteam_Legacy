<?php
/***********************************************************************
MACHINE/capi/PunKC0rE

************************************************************************/
//a faire
//=> filtrer en fn du pun_user ( si c lui qui a envoyé ou non le cdr)
//=> different tri ( date nb rc etc ..)                                  Fait
//=> ajouter date                                                        Fait
//=> ajouter nb recyclo                                                  Fait
//=> voir dans option sur cdr pour les couleurs ...
//
define('PUN_ROOT', './');
require PUN_ROOT . 'include/common.php';

// Load the index.php language file
require PUN_ROOT . 'lang/' . $pun_user['language'] . '/index.php';

///ogpt
$lien = "cdr.php";
$page_title = "Champ de ruines";
require PUN_ROOT . 'ogpt/include/ogpt.php';
/// fin ogpt

define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT . 'header.php';


/***************************************************************************
modification : machine & PunKC0rE

***************************************************************************/
///composer d'une partie du code de galaxie de punogpt et une partie de cdr de ogspy
///paramettre de la galaxie
$gal_min = 1;
$gal_max = $pun_config['gal'] + 1;
//// systeme affiché de base si rien en paramettre ...
$galaxie = $pun_user['pm_g'];
/// verification des paramettre passé dans l'url ( $_get )

if (isset($_GET['action'])) {
    // mauvais paramettre pour action : non egale a galaxie
    if ($_GET['action'] !== "galaxie") {
        $redirection = "redirection suite a probleme1";
        redirect('cdr.php', $redirection);
    }

    /// verification valeur galaxie et systeme
    /// filtre divers :
    pun_trim($_GET["galaxie"]);
    /// valeur numerique
    if (is_numeric($_GET["galaxie"])) {
    } else {
        $redirection = "redirection suite a probleme2";
        redirect('cdr.php', $redirection);
    }
    ///verification des valeurs ( comprise dans les bornes des galaxies  ... :p )
    /// si veleur de galaxie inf a 1 => valeur 1 sup a 9 => 1
    if ($_GET["galaxie"] >= $gal_min && $_GET["galaxie"] < $gal_max) {
        $galaxie = $_GET["galaxie"];
    } else {
        $galaxie = 1;
    }

}
if (isset($_POST['T_Small']) && isset($_POST['C_Small']) && isset($_POST['t_med']) &&
    isset($_POST['C_med']) && isset($_POST['t_big']) && isset($_POST['C_big'])) {
    /// verif si c une valeur numerique
    if (!is_numeric($_POST['T_Small'])) {
        $redirection = "La taille des champs de ruines doit étre un nombre";
        redirect('cdr.php?option=on', $redirection);
    }
    if (!is_numeric($_POST['t_med'])) {
        $redirection = "La taille des champs de ruines doit étre un nombre";
        redirect('cdr.php?option=on', $redirection);
    }
    if (!is_numeric($_POST['t_big'])) {
        $redirection = "La taille des champs de ruines doit étre un nombre";
        redirect('cdr.php?option=on', $redirection);
    }

    $T_S = pun_trim($_POST['T_Small']);
    $C_S = pun_trim($_POST['C_Small']);
    $t_m = pun_trim($_POST['t_med']);
    $C_m = pun_trim($_POST['C_med']);
    $t_b = pun_trim($_POST['t_big']);
    $C_b = pun_trim($_POST['C_big']);

    // lancement de la requête
    $sql = 'UPDATE ' . $db->prefix . 'users SET small="' . $T_S . '", small_color="' .
        $C_S . '", medium="' . $t_m . '", medium_color="' . $C_m . '", big="' . $t_b .
        '", big_color="' . $C_b . '" WHERE id_ogspy="' . $pun_user['id_ogspy'] . '"';
    // on exécute la requête (mysql_query) et on affiche un message au cas où la requête ne se passait pas bien (or die)
    mysql_query($sql) or die('Erreur SQL !' . $sql . '<br />' . mysql_error());


    require_once PUN_ROOT . 'include/cache.php';
    generate_config_cache();


    ///redirection pour prise en compte dans la page
    $redirection = "Modifications prises en compte";
    redirect('cdr.php?option=on', $redirection);
}

//pour la couleur des CDR (verifie si l'utilisateur a un id_user sinon 0 par defaut)

$req = "SELECT * FROM " . $db->prefix . "users WHERE id_ogspy=" . $pun_user['id_ogspy'];
$req1 = mysql_query($req);
$tc = mysql_fetch_array($req1);


if (isset($_GET['option'])) {
?>
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
 <div class="blockform">
 <link rel="stylesheet" type="text/css" href="style/ColorPicker.css" />
	<h2><span>Configuration mod CDR        (<a href="cdr.php">Retour Champs de ruines</a>)</span></h2>
	<div class="box">

 <form name="objForm" id="couleur" method="post" action="cdr.php">
 <br> 
 
 <table width='20%'>
	<th class='c' colspan='2'><center><?php echo 'Couleur des Champs de ruines'; ?></center></th>
	<tr>
		<td width='20%'><?php echo '+ de '; ?> <input style="text-align:center" type="text" size="10" name="T_Small" value="<?php echo
'' . $tc['small'] . ''; ?>"/><?php echo
' unités'; ?></td>
		<td align='center' width='20%' BGCOLOR="<?php echo '' . $tc['small_color'] .
''; ?>">
			<input style="text-align:center" size="10" type="text" name="C_Small" maxlength="7" value="<?php echo
'' . $tc['small_color'] . ''; ?>"/>
<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.C_Small);" style="cursor:pointer;"></td>
	</tr>
	<tr>
		<td width='20%'><?php echo '+ de '; ?> <input style="text-align:center" type="text" size="10" name="t_med" value="<?php echo
'' . $tc['medium'] . ''; ?>"/><?php echo
' unités'; ?></td>
		<td align='center' width='20%' BGCOLOR="<?php echo '' . $tc['medium_color'] .
''; ?>">
			<input style="text-align:center" size="10" type="text" name="C_med" maxlength="7" value="<?php echo
'' . $tc['medium_color'] . ''; ?>"/>
<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.C_med);" style="cursor:pointer;"></td>
	</tr>
	<tr>
		<td width='20%'><?php echo '+ de '; ?> <input style="text-align:center" type="text" size="10" name="t_big" value="<?php echo
'' . $tc['big'] . ''; ?>"/><?php echo
' unités'; ?></td>
		<td align='center' width='20%' BGCOLOR="<?php echo '' . $tc['big_color'] . ''; ?>">
			<input style="text-align:center" size="10" type="text" name="C_big" maxlength="7" value="<?php echo
'' . $tc['big_color'] . ''; ?>"/>
<img src="ogpt/img/color.gif" width="21" height="20" border="0" onClick="fctShow(document.objForm.C_big);" style="cursor:pointer;"></td>
	</tr>


</table> <br>
	<input type='submit'>
</form>
    </div> </div>
	
<?php
} else {


    echo '<div class="blockform"><h2><span> Champs de Ruines    (<a href="cdr.php?option=on">Option</a>)          </span></h2> 	<div class="box">';
?>
<script type="text/javascript">
var index
function  sort_int(p1,p2) { return p1[index]-p2[index]; }			//fonction pour trier les nombres
function sort_char(p1,p2) { return ((p1[index]>=p2[index])<<1)-1; }	//fonction pour trier les strings

function TableOrder(e,Dec)  //Dec= 0:Croissant, 1:Décroissant
{ //---- Détermine : oCell(cellule) oTable(table) index(index cellule) -----//
	var FntSort = new Array()
	if(!e) e=window.event
	for(oCell=e.srcElement?e.srcElement:e.target;oCell.tagName!="TH";oCell=oCell.parentNode);	//determine la cellule sélectionnée
	for(oTable=oCell.parentNode;oTable.tagName!="TABLE";oTable=oTable.parentNode);				//determine l'objet table parent
	for(index=0;oTable.rows[0].cells[index]!=oCell;index++);									//determine l'index de la cellule

 //---- Copier Tableau Html dans Table JavaScript ----//
	var Table = new Array()
	for(r=1;r<oTable.rows.length;r++) Table[r-1] = new Array()

	for(c=0;c<oTable.rows[0].cells.length;c++)	//Sur toutes les cellules
	{	var Type;
		objet=oTable.rows[1].cells[c].innerHTML.replace(/<\/?[^>]+>/gi,"")
		if(objet.match(/^\d\d[\/-]\d\d[\/-]\d\d\d\d$/)) { FntSort[c]=sort_char; Type=0; } //date jj/mm/aaaa
		else if(objet.match(/^[0-9£€$\.\s-]+$/))		{ FntSort[c]=sort_int;  Type=1; } //nombre, numéraire
		else											{ FntSort[c]=sort_char; Type=2; } //Chaine de caractère

		for(r=1;r<oTable.rows.length;r++)		//De toutes les rangées
		{	objet=oTable.rows[r].cells[c].innerHTML.replace(/<\/?[^>]+>/gi,"")
			switch(Type)		
			{	case 0: Table[r-1][c]=new Date(objet.substring(6),objet.substring(3,5),objet.substring(0,2)); break; //date jj/mm/aaaa
				case 1: Table[r-1][c]=parseFloat(objet.replace(/[^0-9.-]/g,'')); break; //nombre
				case 2: Table[r-1][c]=objet.toLowerCase(); break; //Chaine de caractère
			}
			Table[r-1][c+oTable.rows[0].cells.length] = oTable.rows[r].cells[c].innerHTML
		}
	}

 //--- Tri Table ---//
	Table.sort(FntSort[index]);
	if(Dec) Table.reverse();

 //---- Copier Table JavaScript dans Tableau Html ----//
	for(c=0;c<oTable.rows[0].cells.length;c++)	//Sur toutes les cellules
		for(r=1;r<oTable.rows.length;r++)		//De toutes les rangées 
			oTable.rows[r].cells[c].innerHTML=Table[r-1][c+oTable.rows[0].cells.length];  
}
</script>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" height="5" id="carto">

 <tr><td><center>

    <form id="cdr" method="get" action="cdr.php">



<input type="hidden" name="action" value="galaxie" accesskey="s" />
                                                    Galaxie :       <br>
					<?php $future_galaxie_min = ($galaxie - 1);
    echo ' <a href="cdr.php?action=galaxie&galaxie=' . $future_galaxie_min . '">'; ?> <<<</a> 
<input type="text" name="galaxie" size="2" maxlength="2" value="<?php echo '' .
$galaxie . ''; ?>"/>
					<?php $future_galaxie_max = ($galaxie + 1);
    echo ' <a href="cdr.php?action=galaxie&galaxie=' . $future_galaxie_max . '">'; ?> >>></a>  







			<br><input type="submit"   name="affich" value="Afficher"/>
		</form>
</center></td></tr></table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" height="5" id=trier>
		
	<tr class=title>
		<th align="center" ><span onclick=TableOrder(event,0)>&#9660;</span>Coordonnées<span onclick=TableOrder(event,1)>&#9650;</span></th>
		<th align="center" class="c"><span onclick=TableOrder(event,0)>&#9660;</span>Nb de recycleurs<span onclick=TableOrder(event,1)>&#9650;</span></th>
		<th  align="center" class="c"><span onclick=TableOrder(event,0)>&#9660;</span>Total<span onclick=TableOrder(event,1)>&#9650;</span></th>
		<th  align="center" class="c"><span onclick=TableOrder(event,0)>&#9660;</span>Métal<span onclick=TableOrder(event,1)>&#9650;</span></th>
		<th  align="center" class="c"><span onclick=TableOrder(event,0)>&#9660;</span>Cristal<span onclick=TableOrder(event,1)>&#9650;</span></th>
		<th align="center" class="c"><span onclick=TableOrder(event,0)>&#9660;</span>date<span onclick=TableOrder(event,1)>&#9650;</span></th>
	</tr>
<?php

    $sql = 'SELECT *	 FROM ' . $pun_config["ogspy_prefix"] . 'cdr WHERE gal=' . $galaxie .
        ' ORDER BY coord asc ';
    $result = $db->query($sql);

    while ($carto = $db->fetch_assoc($result)) {
        $cdr_total = $carto['total'];
        $cdr_tot = number_format($carto['total'], 0, '', ' ');
        $cdr_metal = $carto['metal'];
        $cdr_met = number_format($carto['metal'], 0, '', ' ');
        $cdr_cristal = $carto['cristal'];
        $cdr_cri = number_format($carto['cristal'], 0, '', ' ');

        echo '<tr>
	<td  align="center" class="c" ><FONT size=1>' . $carto['gal'] . '' . $carto['coord'] .
            '</font></td>
	<td  align="center" class="c" ><FONT size=1>' . floor($carto['total'] / 20000 +
            1) . '</font></td> '; ?>
	<td  align="center" class="c" ><FONT size=1><?php if ($carto['total'] >= $tc['big'])
            echo "<span STYLE='color:{$tc['big_color']}'> {$cdr_tot}</span>";
        else
            if ($cdr_total >= $tc['medium'])
                echo "<span STYLE='color:{$tc['medium_color']}'> {$cdr_tot}</span>";
            else
                if ($cdr_total > $tc['small'])
                    echo "<span STYLE='color:{$tc['small_color']}'> {$cdr_tot}</span>";
                else
                    echo $cdr_tot; ?></font></td>
	
	<td  align="center" class="c" ><FONT size=1><?php if ($carto['metal'] >= $tc['big'])
            echo "<span STYLE='color:{$tc['big_color']}'> {$cdr_met}</span>";
        else
            if ($cdr_metal >= $tc['medium'])
                echo "<span STYLE='color:{$tc['medium_color']}'> {$cdr_met}</span>";
            else
                if ($cdr_metal > $tc['small'])
                    echo "<span STYLE='color:{$tc['small_color']}'> {$cdr_met}</span>";
                else
                    echo $cdr_met; ?></font></td>
    <td  align="center" class="c" ><FONT size=1><?php if ($carto['cristal'] >= $tc['big'])
            echo "<span STYLE='color:{$tc['big_color']}'> {$cdr_cri}</span>";
        else
            if ($cdr_cristal >= $tc['medium'])
                echo "<span STYLE='color:{$tc['medium_color']}'> {$cdr_cri}</span>";
            else
                if ($cdr_cristal > $tc['small'])
                    echo "<span STYLE='color:{$tc['small_color']}'> {$cdr_cri}</span>";
                else
                    echo $cdr_cri; ?></font></td>
<?php
        echo '
	<td  align="center" class="c" ><FONT size=1>' . date('d/m/Y  G\Hi', $carto['date']) .
            '</font></td>';
        echo '</tr>';
    }

?>
</table>
<br>
<table width='40%'>
                <tr>
					<td></td>
					<td BGCOLOR="<?php echo '' . $tc['small_color'] . ''; ?>" width='2%'></td>
                    <td width='10%'><?php echo ' + de ' . '' . number_format($tc['small'],
0, '', ' ') . ''; ?></td>
					<td BGCOLOR="<?php echo '' . $tc['medium_color'] . ''; ?>"width='2%'></td>
                    <td width='10%'><?php echo ' + de ' . '' . number_format($tc['medium'],
0, '', ' ') . ''; ?></td>
					<td BGCOLOR="<?php echo '' . $tc['big_color'] . ''; ?>"width='2%'></td>
                    <td width='10%'><?php echo ' + de ' . '' . number_format($tc['big'],
0, '', ' ') . ''; ?></td>
					<td></td>
				</tr>
</table>
 </div> </div>
<?php
}
?>
<div class="blockform">
	<h2><span>Propulsé par ogspy/<a href="http://www.ogsteam.fr">ogsteam</a></span></h2>
</div>

<?php
require PUN_ROOT . 'footer.php';
?>