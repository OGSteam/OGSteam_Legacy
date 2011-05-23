<?php
  include($my_ms["root"].'/error.php');
?>

  <script langage="javascript">
<!--
  var my_ms_myroot = "<?php echo $my_ms['img_root'] ?>";
  var my_ms_myskin = "<?php echo $my_ms['skin'] ?>";
  var my_ms_mychmskin = "<?php echo $my_ms['img_root'].'/'.$my_ms['skin'] ?>";
  var my_ms_mycettepage = "<?php echo $my_ms['cettepage']; ?>";
  var myms_speed_fresh=<?php echo $my_ms["refresh_speed"] ?>;
  var myms_message=document.myspeach.MSmessage;
  var myms_max=<?php echo $my_ms["maxTexte"] ?>;
  var myms_pseudo=document.myspeach.MSpseudo.value;
  var myms_choix=<?php print '"'.$choix_son.'"'; ?>;
  var myms_error1=myms_error1==""?"Erreur de script 1":<?php print "'".$er1."'" ?>;
  var myms_error2=myms_error2==""?"Erreur de script 2":<?php print "'".$er2."'" ?>;
  var myms_error3=myms_error3==""?"Erreur de script 3":<?php print "'".$er3."'" ?>;
  var myms_error4=myms_error4==""?"Erreur de script 4":<?php print "'".$er4."'" ?>;


  var myms_actif = window.setInterval("MY_MS_tmps()",1000);
  var myms_i = 0;
  var myms_h =<?php print gmdate("H", time() + 3600*($my_ms['hDeca']+date("I")))*1; ?>;
  var myms_m =<?php print gmdate("i", time())*1; ?>;
  var myms_s= <?php print gmdate("s", time())*1; ?>;
  var myms_heure, myms_he, myms_mi, myms_se;
function MY_MS_tmps() {

	if(myms_s<59){myms_s++;}else{myms_s=0;
	if(myms_m<59){myms_m++;}else{myms_m=0;
	if(myms_h<23){myms_h++;}else{myms_h=0;
	} } }
	myms_i ++;
	myms_he=myms_h<10 ? '0' + myms_h : myms_h;
	myms_mi=myms_m<10 ? '0' + myms_m : myms_m;
	myms_se=myms_s<10 ? '0' + myms_s : myms_s;
	myms_heure= myms_he + ' : ' + myms_mi + ' : ' + myms_se ;
 	document.getElementById('hour').innerHTML =myms_heure;
  	if(myms_i >= 1000)  window.clearInterval(myms_actif);

}


//-->

</script>

<?php
  if(!isset($_SESSION['tst'])){
 ?>
  <script langage="javascript">
// ici on verifie si le navigateur connait XmlHttpRequest sinon on le redirige vers une page pour envoi de session
   var myms_xhr_obj = null;

	if(window.XMLHttpRequest) // Firefox
		myms_xhr_obj= new XMLHttpRequest();
	else if(window.ActiveXObject) // Internet Explorer
		myms_xhr_obj = new ActiveXObject("Microsoft.XMLHTTP");
	else {
    document.location.href=my_ms_myroot + "/message.php?cettepage=" + my_ms_mycettepage;
	}

  </script>

  <?php
  }
  ?>
