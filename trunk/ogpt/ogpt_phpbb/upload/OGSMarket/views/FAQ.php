<?php
/***********************************************************************
 * filename	:	FAQ.php
 * desc.	:	
 * created	: 	11/07/06 Mirtador
 *
 * *********************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
//d�finition des variable
$Utype = $server_config["users_auth_type"];
$NForum = $server_config["nomforum"];
$AForum = $server_config["adresseforum"];
$servername = $server_config["servername"];

require_once("views/page_header.php");
?>
<table width="90%">
<tr><th>
<span style="font-family: Tahoma;">Tutoriel OGSMarket</span></span></strong></span><br>
<tr><th>
<p><br>
<span style="color: sienna;"><strong><span class="bbu">
<span style="font-family: Tahoma;">Pour proposer une offre:</span></span></strong></span><br>
<br>

<?php
if ($Utype==internal)
	{
?>
	<strong>Premi�re chose � faire: s'inscrire sur la cartographie: <font color="#FF0000"><?php echo $servername;?></font><br><br>
	<img alt="http://img364.imageshack.us/img364/9620/faq00mx8.jpg" src="http://img364.imageshack.us/img364/9620/faq00mx8.jpg" width="402" height="279"><br>
	Rien de tr�s compliqu�<br><br>


<?php
	}
else
	{
?>
	<strong>Premi�re chose � faire: s'inscrire sur le forum de <?php echo $NForum;?>:
	<a href="<?php echo $AForum;?>"><?php echo $AForum;?></a></strong><br>
	<strong>L'administrateur a  d�cid� de ne pas donner a ce OGmarket un propre base de donn�e de membres.</strong><br>
	<br>
	<a href="http://membres.lycos.fr/tibbo30/TutoOGSMarket/OGSMarket02bis.JPG">
	<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket02bis.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket02bis.JPG" width="825" height="355"></a><br>
	<strong>Comme vous le voyez rien de r�barbatif, ni de personnel, seulement une 
	adresse email valide.</strong><br>
	<br>
<?php
	}
?>
<strong>Une fois inscrit, logez vous...</strong><br>
<br>
<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket06.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket06.JPG" width="154" height="166"><br>
<br>
<strong>...et choisissez votre univers dans le menu d�roulant en haut � gauche 
de l'�cran.</strong><br>
<br>
<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket07.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket07.JPG" width="150" height="150"><br>
<br>
<strong>Cliquez alors sur &quot;<span style="color: orangered;">Nouvelle offre</span>&quot;.</strong><br>
<br>
<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket08.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket08.JPG" width="118" height="178"><br>
<br>
<br>
<strong>Un tableau appara�t alors:</strong><br>
<br>
&nbsp; &nbsp; *<strong>Dans la colonne &quot;<span style="color: orangered;">Offres</span>&quot; de 
gauche mettez ce que vous proposez en kilo (1000 devient 1, 1234 devient 1,234 
etc...). <br>
&nbsp; &nbsp; *Dans le colonne &quot;<span style="color: orangered;">Demandes</span>&quot; saisissez 
ce que vous d�sirez en �change, toujours en kilo. </strong><br>
&nbsp; &nbsp; *<strong>Changer le dur�e de l'offre dans la case &quot;<span style="color: orangered;">Expiration</span>&quot; 
si voulez que celle ci apparaissent plus de 24 sur le serveur.</strong><br>
&nbsp; &nbsp; *<strong>Un champ &quot;<span style="color: orangered;">Note</span>&quot; est 
disponible si vous voulez donner des informations suppl�mentaires, du genre 
&quot;Promo du si�cle&quot;, &quot;Affaire � saisir&quot;...</strong><br>
<br>
<strong>Cliquez enfin sur &quot;<span style="color: orangered;">Envoyer</span>&quot; pour 
mettre votre offre en ligne.</strong><br>
<br>
<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket09.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket09.JPG" width="478" height="508"><br>
<br>
<strong>Il est bien sur important de remplir de son &quot;<span style="color: orangered;">Profil</span>&quot; 
(dans le menu de gauche) afin que l'acheteur puisse vous contacter.<br>
<br>
Il est � noter que l'acheteur voit le taux de change dans la fen�tre principale, 
donc pas d'entourloupe possible...</strong><br>
<br>
<img class="postimg" src="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket10.JPG" alt="http://membres.lycos.fr/tibbo30//TutoOGSMarket/OGSMarket10.JPG" width="277" height="43"><br>
<br>
<strong>Vous pouvez utiliser ce logiciel afin de vous aider dans vos 
conversions: <a href="http://juper.free.fr/fear/ORC.exe">ORC</a></strong> <em>
(peut �tre faudrait il l'int�grer...)</em><br>
<br>
<strong>Il ne vous reste maintenant plus qu'� patienter.</strong><br>
<br>
<br>
<hr>Note de l'auteur (itea)
<hr>
<em>(tuto en cours de cr�ation, et en attente de la version d�finitive)</em><br>
<br>
Voil�, je me suis permis de faire un petit tuto pour expliquer rapidement le 
principe.<br>
Cependant, j'attend pour r�diger la partie &quot;Choisir une offre&quot; car celle ci 
n'est pas encore op�rationnelle. Mais cela ne devrait pas tarder si j'en juge 
l'effervescence que OGSMarket a cr��e.<br>
J'attend vos critiques <a href="http://ogs.servebbs.net/devteam/wiki/WikiFormatting">ICI</a>, surtout qu'il s'agit de mon premier tutorial.</p>
</tr></th>
