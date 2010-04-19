<?php
define('PUN_ROOT', './');
require PUN_ROOT . 'include/common.php';
/// fn ogpt
//require PUN_ROOT.'ogpt/include/attack.php';
// Load the index.php language file
require PUN_ROOT . 'lang/' . $pun_user['language'] . '/index.php';

/// si utilisateur n'est pas enregistré : redirection
if ($pun_user['is_guest']) {
    $redirection = "identifiez vous";
    redirect('index.php', $redirection);
}
$query = "SELECT `active` FROM ogspy_mod WHERE `action`='guerres' AND `active`='1' LIMIT 1";
if (!$db->num_rows($db->query($query))) {
    $redirection = "Mod Guerre non activé";
    redirect('index.php', $redirection);
}


/// si utilisateur n'a pas validé son mdp et pseudo ... : redirection
if ($pun_user['id_ogspy'] == '0') {
    $redirection = "remplissez votre acces ogspy";
    redirect('profil_ogs.php', $redirection);
}

$page_title = "guerre";
define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT . 'header.php';


//On vérifie que le mod est activé
//$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='guerres' AND `active`='1' LIMIT 1";

//Définitions
global $db;
global $table_prefix;
define("TABLE_GUERRES_LISTE", "ogspy_guerres_listes");
define("TABLE_GUERRES_ATTAQUES", "ogspy_guerres_attaques");
define("TABLE_GUERRES_RECYCLAGES", "ogspy_guerres_recyclages"); //Requete pour afficher la liste des guerres
$query = "SELECT guerre_id, guerre_ally_1, guerre_ally_2 FROM " .
    TABLE_GUERRES_LISTE . " ORDER BY guerre_id ASC";
$result = $db->query($query);

//Création du field pour selectionner la guerre
echo "<fieldset><legend><b><font color='#0080FF'> Selectionnez une guerre </font></b></legend>";
echo "Selectionnez la guerre pour laquelle vous souhaitez voir la liste des attaques et des recyclages :";
echo "<br>";
echo "<br>";
echo "<form action='list_attack.php' method='post'><input type='hidden' name='action' value='guerres'><input type='hidden' name='page' value='Liste des attaques'>";
echo "<select name='guerre'>";
echo "<br>";
echo "<br>";
echo "<option selected>Selectionnez une guerre</option><br>";

while (list($guerre_id, $guerre_ally_1, $guerre_ally_2) = $db->fetch_row($result)) {
    //on recupère le nombre de guerre en cours
    $nb_guerres = mysql_num_rows($result);

    //Si ce  nombre est égal à 1 on selectionne cette guerre automatiquement
    //if ($nb_guerres == 1)$_POST['guerre'] = $guerre_id;

    echo "<option value='$guerre_id'>" . $guerre_ally_1 . " vs " . $guerre_ally_2 .
        "</option>";
}
echo "</select>";
echo "<input type='submit' value='Selectionnez'>";
echo "</form>";
echo "</fieldset><br><br>";
if (isset($_POST['guerre'])) {
    $_POST['guerre'] = intval($_POST['guerre']);

    //Requete pour afficher les resultats des attaques
    $query = "SELECT attack_id, attack_date, attack_name_A, attack_name_D, attack_coord, attack_metal, attack_cristal, attack_deut, attack_pertes_A, attack_pertes_D FROM " .
        TABLE_GUERRES_ATTAQUES . "  WHERE guerres_id=" . $_POST['guerre'] .
        " ORDER BY attack_date";
    $result = $db->query($query);

    //On recupère le nombre d'attaques
    $nb_attack = $db->num_rows($result);

    //Requete pour afficher les resultats des recyclages
    $query = "SELECT recy_id, recy_date, recy_coord, recy_metal, recy_cristal FROM " .
        TABLE_GUERRES_RECYCLAGES . " WHERE guerre_id=" . $_POST['guerre'] .
        " ORDER BY recy_date";
    $result2 = $db->query($query);

    //On recupère le nombre de recyclages
    $nb_recy = $db->num_rows($result2);

    //Création du field pour voir la liste des attaques
    echo "<fieldset><legend><b><font color='#0080FF'>Liste des attaques de la guerre selectionnée ";
    echo " : " . $nb_attack . " attaque(s) ";
    echo "</font></b></legend>";

    //Tableau donnant la liste des attaques
    echo "<table width='100% id='table1'>";
    echo "<tr>";
    echo "<td class=" . c . " align=" . center . "><b>Coord</b></td>";
    echo "<td class=" . c . " align=" . center . "><b>Date</b></td>";
    echo "<td class=" . c . " align=" . center . "><b>Nom Attaquant</b></td>";
    echo "<td class=" . c . " align=" . center . "><b>Nom Defenseur</b></td>";
    echo "<td class=" . c . " align=" . center . "><b>Métal Gagné</b></td>";
    echo "<td class=" . c . " align=" . center . "><b>Cristal Gagné</b></td>";
    echo "<td class=" . c . " align=" . center . "><b>Deuterium Gagné</b></td>";
    echo "<td class=" . c . " align=" . center . "><b>Pertes Attaquant</b></td>";
    echo "<td class=" . c . " align=" . center . "><b>Pertes Defenseur</b></td>";

    if (($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1)) {
        echo "<td class=" . c . " align=" . center .
            "><b><font color='#FF0000'>Supprimer</font></b></td>";
    }
    echo "</tr>";

    while (list($attack_id, $attack_date, $attack_name_A, $attack_name_D, $attack_coord,
        $attack_metal, $attack_cristal, $attack_deut, $attack_pertes_A, $attack_pertes_D) =
        $db->fetch_row($result)) {
        $attack_metal = number_format($attack_metal, 0, ',', ' ');
        $attack_cristal = number_format($attack_cristal, 0, ',', ' ');
        $attack_deut = number_format($attack_deut, 0, ',', ' ');
        $attack_pertes_A = number_format($attack_pertes_A, 0, ',', ' ');
        $attack_pertes_D = number_format($attack_pertes_D, 0, ',', ' ');
        echo "<th width='10%' align='center'>" . $attack_coord . "</th>";
        $attack_date = strftime("%d %b %Y %Hh%M", $attack_date);
        echo "<th width='10%' align='center'>" . $attack_date . "</th>";
        echo "<th width='10%' align='center'>" . $attack_name_A . "</th>";
        echo "<th width='10%' align='center'>" . $attack_name_D . "</th>";
        echo "<th width='10%' align='center'>" . $attack_metal . "</th>";
        echo "<th width='10%' align='center'>" . $attack_cristal . "</th>";
        echo "<th width='10%' align='center'>" . $attack_deut . "</th>";
        echo "<th width='10%' align='center'>" . $attack_pertes_A . "</th>";
        echo "<th width='10%' align='center'>" . $attack_pertes_D . "</th>";

        if (($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1)) {
            echo "<th width='5%' align='center' valign='middle'><form action='index.php' method='post'><input type='hidden' name='action' value='guerres'><input type='hidden' name='guerre' value='$pub_guerre'><input type='hidden' name='page' value='Liste des attaques'><input type='hidden' name='attack_id' value='$attack_id'><input type='submit'	value='Supprimer' name='B1' style='color: #FF0000'></form></th>";
        }

        echo "</tr>
		<tr>";
    }
    echo "</tr>";
    echo "</table>";

    echo "</fieldset>";
    echo "<br><br>";


    //Création du field pour voir la liste des recyclages
    echo "<fieldset><legend><b><font color='#0080FF'>Liste des recyclages de la guerre selectionnée ";
    echo " : " . $nb_recy . " recyclage(s) ";
    echo "</font></b></legend>";

    //Tableau donnant la liste des attaques
    echo "<table width='100% id='table1'>";
    echo "<tr>";
    echo "<td class=" . c . " align=" . center . "><b>Coord</b></td>";
    echo "<td class=" . c . " align=" . center . "><b>Date</b></td>";
    echo "<td class=" . c . " align=" . center . "><b>Métal Recyclé</b></td>";
    echo "<td class=" . c . " align=" . center . "><b>Cristal Recyclé</b></td>";

    if (($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1)) {
        echo "<td class=" . c . " align=" . center .
            "><b><font color='#FF0000'>Supprimer</font></b></td>";
    }
    echo "</tr>";

    while (list($recy_id, $recy_date, $recy_coord, $recy_metal, $recy_cristal) = $db->
        fetch_row($result2)) {
        $recy_metal = number_format($recy_metal, 0, ',', ' ');
        $recy_cristal = number_format($recy_cristal, 0, ',', ' ');
        echo "<th width='10%' align='center'>" . $recy_coord . "</th>";
        $recy_date = strftime("%d %b %Y %Hh%M", $recy_date);
        echo "<th width='10%' align='center'>" . $recy_date . "</th>";
        echo "<th width='10%' align='center'>" . $recy_metal . "</th>";
        echo "<th width='10%' align='center'>" . $recy_cristal . "</th>";


        if (($user_data[user_admin] == 1) || ($user_data[user_coadmin] == 1)) {
            echo "<th width='5%' align='center' valign='middle'><form action='index.php' method='post'><input type='hidden' name='action' value='guerres'><input type='hidden' name='guerre' value='$pub_guerre'><input type='hidden' name='page' value='Liste des attaques'><input type='hidden' name='recy_id' value='$recy_id'><input type='submit'	value='Supprimer' name='B1' style='color: #FF0000'></form></th>";
        }

        echo "</tr>
		<tr>";
    }
    echo "</tr>";
    echo "</table>";

    echo "</fieldset>";
    echo "<br><br>";
}

echo "<hr width='325px'>";
echo "<p align='center'>Module OGPT Guerre | Version 0.1 | Doudou |© 2008 |Adapté du mod ogspy guerre de Vérité</p>";

?>
<?php
$footer_style = 'index';
require PUN_ROOT . 'footer.php'
?>