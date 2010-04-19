<?php

///envoi des include necessaires
require_once PUN_ROOT . 'ogpt/include/fonction.php';
require_once PUN_ROOT . 'ogpt/include/empire.php';
require_once PUN_ROOT . 'ogpt/include/prod.php';
require_once PUN_ROOT . 'ogpt/include/re.php';
require_once PUN_ROOT . 'ogpt/include/rech.php';
require_once PUN_ROOT . 'ogpt/include/records.php';
require_once PUN_ROOT . 'ogpt/include/varally.php';
require_once PUN_ROOT . 'ogpt/include/galaxie.php';
/// fin des includes


/// variable globale ogpt
$request = "select * from ogpt";
$result = $db->query($request);
while (list($name, $value) = $db->fetch_row($result)) {
    $ogpt[$name] = stripslashes($value);
}


/// verification diverses

/// interdit au guest ( non inscrit )
if ($pun_user['is_guest']) {
    $redirection = "identifiez vous";
    redirect('index.php', $redirection);
}
/// fin de contrle guest


/// controle de l'identification ogspy

/// si utilisateur n'a pas validé son mdp et pseudo ... : redirection
if ($pun_user['id_ogspy'] == '0') {
    $redirection = "remplissez votre acces ogspy";
    redirect('profil_ogs.php', $redirection);
}


// fin decontrle

/// verification du mod en tant q'actif  si le lien est connu
if ($lien != "") {
    $sql = "select * from mod_fofo_ogs  where lien = '$lien' limit 1  ";
    $result = $db->query($sql);
    while ($mod = $db->fetch_assoc($result)) {
        if ($mod['actif'] == 0) {
            $redirection = "mod inactif";
            redirect('admin_ogs.php', $redirection);
        }
    }
}
// fin de la verif mod actif

/// mise a jour
if ($pun_user['g_id'] > PUN_MOD) {
    /// user de base osef
} else {
    /// admin
    if (file_exists(PUN_ROOT . "upgrade.php")) {
        $redirection = "une mise a jour est disponnible, veuillez l'executer<br> si cela a deja ete fait, il faut supprimer ce fichier";
        redirect('upgrade.php', $redirection);


    }
}


//// fin mise a jour



?>