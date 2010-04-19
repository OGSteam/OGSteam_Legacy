<?php
/***********************************************************************
 * filename	:	menu.php
 * desc.	:	Menu de Gauche
 * created	: 	05/06/2006 ericalens
 *
 * *********************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

//Définition des variables
$Cpriver = $server_config["menuprive"];
$Clogout = $server_config["menulogout"];
$Cautre = $server_config["menuautre"];
$CForum = $server_config["menuforum"];
$NForum = $server_config["nomforum"];
$AForum = $server_config["adresseforum"];
$type = $server_config["users_auth_type"];
?>
<?php
//home
?>
<div class="style">
<table border="0" cellpadding="2" cellspacing="0">
<tr align="center"><td class="c"><a href="index.php"><b>Accueil</b></a></td></tr>
<tr align="center"><td><b>Heure serveur</b><br><?php echo strftime("%a %d %b %H:%M:%S");?></td></tr>
<?php
//image du skin
?>
<tr>
	<td align="center"><img src="<?php echo $link_css;?>/gfx/ogame-produktion.jpg" width="100%" /></td>
</tr>
<tr>
	<td align="center">
<script>
	function redir(z1) {
	  eval("location='"+z1.options[z1.selectedIndex].value+"'");
	  }
 </script>

<?php
//sélection des univers
?>
	<select name='uni' onchange="redir(this);">

<?php
//sélection des univers
foreach ($Universes->universes_array() as $uni) {
		echo "\t\t<option value='index.php?action=listtrade&amp;uni=".$uni["id"]."'";
		if ($current_uni["id"]==$uni["id"]) echo " selected ";
		echo ">".$uni["name"]."</option>";
	}
?>
<?php
//voir les offres
?>

	</select>
	</td>
</tr>
<tr>
	<td><div align="center"><a href="index.php?action=listtrade">Voir les Offres</a></div></td>
</tr>

<?php
// Si l'utilisateur est loggé, logout/profile
 if (isset($user_data)) {
?>
	<tr><td><div align='center'><a href='index.php?action=newtrade'>Nouvelle Offre</a></div></td></tr>
	<tr>
	<td><div align="center"><a href="index.php?action=listusertrade">Voir mes Offres</a></div></td>
	</tr>
	<td align="center" background="<?php echo $link_css;?>/gfx/user-menu.jpg" width="100%"><color=blue><?php echo $Cpriver;?></color></td>
<?php
if (isset($user_data) && $user_data["is_admin"]==1) {
?>
<tr><td><div align='center'><a href='index.php?action=admin'>Administration</a></div></td></tr>
<?php
}
?>
	<tr><td><div align='center'><a href='index.php?action=editprofile'>Profil</a></div></td></tr>
</tr>
<?php
}
//Pas loguer
 if (isset($user_data)) {
} else
{
//sinon Boite de login
	echo "<form action='index.php' method='post'>\n"
	    ."\t<input type='hidden' name='action' value='login'>\n";
	echo "\t<tr><th>Nom</th></tr><tr>\n\t<td align='center' class='c'><input type='text' name='name'></td></tr>\n";
	echo "\t<tr><th>Password</th></tr><tr>\n\t<td align='center' class='c'><input type='password' name='password'></td></tr>\n";
	echo "\t<tr>\n\t<td align='center'><input type='submit' value='Envoyer'></td></tr>\n";
	echo "</form>\n";

	if ($type==internal){
?>
	<tr><td><div align="center"><a href='<?php if ($server_config["users_inscription_ur"]!='') echo $server_config["users_inscription_ur"] ; else echo "index.php?action=inscription"; ?>'>Inscription</a></div></td></tr>
<?php 
	}
}
?>

<?php
// Forum et chan?>
	<td align="center" background="<?php echo $link_css;?>/gfx/user-menu.jpg" width="100%"><color=blue><?php echo $CForum;?></color></td>
	<tr><td><div align='center'><a href=<?php echo $AForum;?> target="_blank"><?php echo $NForum;?></a></div></td></tr>
	<tr><td><div align='center'><a href='http://board.ogame.fr/' target="_blank">Forums OGame</a></div></td></tr>
	<tr><td><div align='center'><a href='index.php?action=pjirc' target="_blank">Java IRC</a></div></td></tr>
	<tr><td><div align='center'><a href='irc://irc.sorcery.net/ogsmarket' target="_blank">Lien IRC</a></div></td></tr>

<?php
// Si l'utilisateur est loggé, logout
 if (isset($user_data)) { ?>
	<td align="center" background="<?php echo $link_css;?>/gfx/user-menu.jpg" width="100%"><color=blue><?php echo $Clogout;?></color></td>
	<tr><td><div align='center'><a href='index.php?action=logout'>Logout</a></div></td></tr>
<?php
}
?>

<?php
// autre?>
	<td align="center" background="<?php echo $link_css;?>/gfx/user-menu.jpg" width="100%"><color=blue><?php echo $Cautre;?></color></td>
	<tr><td><div align='center'><a href='index.php?action=Convertisseur'>Convertisseur</a></div></td></tr>
	<tr><td><div align='center'><a href='index.php?action=contributeur'>Contribuateurs</a></div></td></tr>
	<tr><td><div align='center'><a href='index.php?action=FAQ'>FAQ</a></div></td></tr>
	<tr><td><div align='center'><a href='index.php?action=options'>Options</a></div></td></tr>

<?php
//utilisateur en ligne
?>
<?php $UserArray=$Users->OnlineUsers(900); ?>
<tr align="center"><td width="110">Online <?php echo "(".count($UserArray).")";?></td></tr>
<tr><td class='c'width="110">
<?php
  if ($UserArray ){
	foreach ($UserArray as $User){
		echo "<a href='index.php?action=profile&amp;id=".$User["id"]."'>".$User["name"]."</a>, ";
	}

  }
?>
</td></tr>
<tr><td>

<?php
//Fermeture des balises
?>
</td></tr>
</table>
</div>