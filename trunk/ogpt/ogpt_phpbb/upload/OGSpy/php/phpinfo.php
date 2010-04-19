<?php
ob_start();
phpinfo();
$info = ob_get_contents();
ob_end_clean();
preg_match_all("=<body[^>]*>(.*)</body>=siU", $info, $tab);
$val_phpinfo = $tab[1][0];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<style type="text/css"><!--
body {background-color: #ffffff; color: #000000;}
body, td, th, h1, h2 {font-family: sans-serif;}
pre {margin: 0px; font-family: monospace;}
a:link {color: #000099; text-decoration: none;}
a:hover {text-decoration: underline;}
table {border-collapse: collapse;}
.center {text-align: center;}
.center table { margin-left: auto; margin-right: auto; text-align: left;}
.center th { text-align: center; !important }
td, th { border: 0px solid #525A73; font-size: 75%; vertical-align: baseline;}
h1 {font-size: 150%;}
h2 {font-size: 125%;}
.p {text-align: left;}
.e {background-color: #ccccff; font-weight: bold;}
.h {background-color: #9999cc; font-weight: bold;}
.v {background-color: #cccccc;}
i {color: #666666;}
hr {width: 600px; align: center; background-color: #cccccc; border: 0px; height: 1px;}
//--></style>
<title>PHP Info</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="styles.css" type="text/css">
</head>

<body>
<?php
$titre = "phpinfo";
function bouton($word) {
	$lenght=strlen($word);
	$start = 0;
	print("<table border='0' cellspacing='0' cellpadding='0'>");
	print("<tr><td><img src='images_easyphp/bouton_gauche.gif' width='4' height='26'></td><td background='images_easyphp/bouton_fond.gif'>"); 
	while($start<$lenght){
		$car=substr($word,$start,1);
		print("<img src='images_easyphp/lettre_".$car.".gif' border='0'>");
		$start++;
	} 
	print("</td><td><img src='images_easyphp/bouton_droit.gif' width='4' height='26'></td></tr></table>");
}
?>

<?php echo "$val_phpinfo"; ?> 
</body> 
</html> 