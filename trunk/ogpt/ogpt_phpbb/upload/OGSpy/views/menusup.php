
<!----    include, pas de balises <?php ?>
  
<!----    sup entête, bienvenu + pseudo
  
<!----     echo "<tr>
<!---- 	<td><h1><div align='center'><font color='white'><b>Bienvenu </b>".$user_data["user_name"]."!</h1></font></div></td>
<!----  </tr>";
  
  
  
  <!------------- AJOUT OGSCALC ----------------->
<tr>
	<td><div align="center"><a href="index.php?action=ogscalc">OGSCalc (<font color="green">Nouveau</font>)</a></div></td>
</tr>

<tr>
<td><div align="center"><a href="index?action=ogssign">OGSPY Sign (<font color="green">Nouveau</font>)</a></div></td>
</tr>

	<?php
        if ($user_data["user_moderator"] == 1 || $user_data["user_admin"] == 1) {
	    echo "<tr>";
            echo "\t"."<td><div align='center'><a href='index?action=sogsrov'>SOGS Rov (<blink><font color='green'>Nouveau</font></blink>)</a></div></td>";
            echo "</tr>";
        }

<!-----------FIN OGSCALC / OGSSIGN----------------------->

<tr>
	<td><img src="<?php echo $link_css;?>/gfx/user-menu.jpg" width="180" height="19"></td>
</tr>

<!----- -----------ajout options galaxytool ------------->

<tr>
    <td>
         <h1><font color='skyblue'><div align="center">Menu Galaxytool</div></font>
         <div align='center'><font color="skyblue">(expérimental)</font></div></h1>
    </td>
</tr>

<!--- -------------fin entête menu galaxytool ------------->
	<?php
        if ($user_data["user_moderator"] == 1 || $user_data["user_admin"] == 1) {

	     echo "<tr>";
	     echo "\t"."<td><div align='center'><a href='index.php?action=galtoolinsbdd'>Insérer dans la BDD(Admin)</a></div></td>";
	     echo "</tr>"; // <!---// - menu insertion dans bade de donneés galaxietool  ------>

        }


	//---- séparateur ajout option menu Axel
	echo "<tr>";

	//<!------------ Rechercher dans la BDD    ------->
	echo "</tr>";

	echo "\t"."<td><div align='center'><a href='index.php?action=galtooletatbdd'><font color='skyblue'>État de la BDD</font></a></div></td>";
	echo "</tr>";
	//<!------------ Etat de la BDD    ------->
	echo "</tr>";

	echo "\t"."<td><div align='center'><a href='index.php?action=galshow'><font color='skyblue'>Recherche dans la BDD</font></a></div></td>";
	echo "</tr>";


	//<!------------ Rechercher dans les Notes    ------->
	echo "<tr>";
	echo "\t"."<td><div align='center'><a href='index.php?action=galnotices&subaction=search'><font color='skyblue'>Rechercher dans les Notes</font></a></div></td>";
	echo "</tr>";
	//------------ Rechercher dans les Rapports
	echo "<tr>";
	echo "\t"."<td><div align='center'><a href='index.php?action=galreports&subaction=search'><font color='skyblue'>Rechercher dans les Rapports</font></a></div></td>";
	echo "</tr>";

	//<!--------  //---------- Rechercher dans les rapports ------------>

	echo "<tr>";
	echo "\t"."<td><div align='center'><a href='index.php?action=galview'><font color='skyblue'>Voir les Galaxies</font></a></div></td>";
	echo "</tr>";

        if ( $user_data["user_moderator"] == 1 || $user_data["user_admin"] == 1) {

	   echo "<tr>";
	   echo "\t"."<td><div align='center'><font color='#FFFFFF'><a href='index.php?action=galstats'>Classements</a></font></div></td>";
	   echo "</tr>";

        }

	echo "<tr>"; // séparateur : fin ajout option Axel
	?>
<!-------------SEPARATEUR MENU--------------------->
<tr>
    <td><div align='center'><a href="index.php?action=galallyhistory">Historique d'alliance</font></a></div></td>
</tr>
<!-------------FIN SEPARATEUR MENU--------------------->
	<td><img src="<?php echo $link_css;?>/gfx/user-menu.jpg" width="180" height="19"></td>
<!----//-------- fin options galaxytool ---------------------->

<!----//-------- MENU TELECHARGEMENTS ---------------------->
<tr>
	<td><div align="center"><a href="index.php?action=ogsdownloads"><b>
        <?php
          $targetfiledate = @filemtime('downloads/ogsplugin100.xpi') ;
          if ((date('d')-date('d', $targetfiledate))<1) {echo '<b><blink><font color="green">TÉLÉCHARGEMENTS </font></blink></b>';}
          else echo 'TÉLÉCHARGEMENTS ';
          if ((date('d')-date('d', $targetfiledate))<2) {echo '(<blink> <2 j.</blink>)';}
          elseif  ((date('d')-date('d', $targetfiledate))<5) {echo '(<blink> <5 j.</blink>)'; }
          elseif  ((date('d')-date('d', $targetfiledate))<8) {echo '(<blink> <8 j.</blink>)'; };
        ?>
        </b></a></div></td>
</tr>


<!-------------SEPARATEUR MENU--------------------->

<tr>
	<td><img src="<?php echo $link_css;?>/gfx/user-menu.jpg" width="180" height="19"></td>
</tr>

<!-------------SEPARATEUR MENU--------------------->

<tr>
	<td><div align="center"><a href="index.php?action=shoutbox"><b><u>Tchat interne</u> / Shoutbox</b></a></div></td>
</tr>

<!-------------SEPARATEUR MENU--------------------->

<tr>
	<td><img src="<?php echo $link_css;?>/gfx/user-menu.jpg" width="180" height="19"></td>
</tr>

<!-------------SEPARATEUR MENU--------------------->
<?php
     if ( $user_data["user_moderator"] == 1 || $user_data["user_admin"] == 1) {
        echo "<tr>";
        echo "\t"."<td><div align='center'><a href='index.php?action=ogsfaq'><b><u>Questions / Réponses</b></a></div></td>";
        echo "</tr>";
        echo "<tr>";
	echo "\t".'<td><img src="'.$link_css.'/gfx/user-menu.jpg" width="180" height="19"></td>';
        echo "</tr>";
     }
?>
<!-------------SEPARATEUR MENU--------------------->



<?php
if ($server_config["url_forum"] != "") {
   echo "<tr>";
   echo "<td><div align='center'><a href=".$server_config['url_forum']." target='_blank'><b>Forum Gene6</b></a></div></td>";
   echo "</tr>";
} ?>




<tr>
	<td><div align="center"><a href="http://ogame190.de/game/pranger.php?from=0" target="_blank">Piloris Univers 12</a></div></td>
</tr>

<tr>
	<td><div align="center"><a href="http://stat12.cblprod.net/" target="_blank">Serveur Stat12</a></div></td>
</tr>
<!----//------------------------------>
