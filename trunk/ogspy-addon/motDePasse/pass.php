<?php
echo "<html>\n<head>\n<title>Calcul mot de passe sha1(md5 (Mot de passe OGSpy)</title>\n</head>\n<body style='background: url(\"http://ogsteam.fr/forums/img/EpicBlue/background.jpg\");color: red;'>\n";
?>
<h1>Outils OGSpy : </h1>
<h2>Codage de mot de passe ogspy en SHA1(MD5(pass))</h2>
<?
if (isset($_GET["pass"])) {

	echo "<p>Le mot de passe '".$_GET["pass"]."' à pour codage OGSpy <b>".sha1(md5($_GET["pass"]))."</b> </p>";

}

?>

<p>
<form action="pass.php" method="get">
Mot de passe à coder : <input type="text" name='pass' value='<?php echo $_GET["pass"];?>'> 
<input type='submit' value="Coder ce mot de passe">
</form>
<br />
<a href='http://ogsteam.fr'>http://ogsteam.fr</a>
</body>
</html>
