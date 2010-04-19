<?php
/***********************************************************************
 * filename	:	cookies.php
 * desc.	:	Gestion des cookies
 * created	: 	mercredi 7 juin 2006, 16:22:05 (UTC+0200)
 *
 * *********************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

$cookieDate=time()+31536000; // Cookies valables un an

// Univers en cours
if (empty($_COOKIE["ogsm_c_uni"])){
	$_SESSION["osgm_uni"]=1;
	setcookie('ogsm_c_uni',1,$cookieDate);

} elseif (empty( $_SESSION["osgm_uni"])) {

	$_SESSION["osgm_uni"]=intval($_COOKIE["ogsm_c_uni"]);
	setcookie('ogsm_c_uni',intval($_COOKIE["ogsm_c_uni"]),$cookieDate);
}

if (!empty($ogs_uni)){

	$_SESSION["osgm_uni"]=intval($ogs_uni);
	setcookie('ogsm_c_uni',intval($ogs_uni),$cookieDate);
}

if (isset($ogs_skin)){
	$link_css=$ogs_skin;
	setcookie('ogsm_c_skin',$ogs_skin,$cookieDate);
}elseif (!empty($_COOKIE["ogsm_c_skin"])) {

	$link_css=$_COOKIE["ogsm_c_skin"];
	setcookie('ogsm_c_skin',$_COOKIE["ogsm_c_skin"],$cookieDate);
}
$current_uni=$Universes->get_universe($_SESSION["osgm_uni"]);

if (isset($_SESSION["username"])) {
	$Users->login($_SESSION["username"],$_SESSION["userpass"]);
	$Users->UpdateLastVisit();
}

?>
