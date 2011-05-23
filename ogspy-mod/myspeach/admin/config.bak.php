<?php
//Mettez ici l adresse exact de votre site sans / a la fin :
//Metez votre véritable adresse, pas une redirection, ni une adresse du genre ulimit.

$my_ms["site"]="http://localhost";    //Votre site
$my_ms["repertoire"]="/myspeach";    //depuis la racine http
$my_ms["absolu_root"]=$_SERVER['DOCUMENT_ROOT'];    //si pas exact, mettez ici la racine de votre serveur

$my_ms["id_unique"]="id_test"; //identifiant unique, pour savoir si une nouvelle version de myspeach existe

$my_ms["admin_login"]="votre login";                 //Votre Login
$my_ms["admin_mdp"]="mot de passe";                //Votre mot de passe

$my_ms["msg_txt"]="message.txt";             //Le nom du fichier texte qui enregistre (ne pas changer)

$my_ms["version"]="3.0b";
$my_ms["copyright"]="<a href=\"http://www.graphiks.net/\" target=\"_blank\" title=\"MySpeach\">MySpeach</a>";

$my_ms["skin"]="saves/skin/default";    //le skin utilisé
?>