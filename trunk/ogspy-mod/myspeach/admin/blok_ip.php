<?
include("config.php");
include("options.php");

  $connect=0;
  if(isset($_COOKIE['ms_moderateur'])){
      $thisUser=$_COOKIE['ms_moderateur'];
      $temp=split(',',$my_ms['moderateur']);
      for($io=0; $io<count($temp); $io++){
        $testUser=$temp[$io];
        if($thisUser==$testUser){
          $connect=1;
        }
      }
  }

	$temp_login="my_".md5($my_ms['admin_login']);
	$temp_mdp="my_".md5($my_ms['admin_mdp']);
  if(isset($_COOKIE[$temp_login]) AND $_COOKIE[$temp_login]==$temp_mdp){
    $connect=1;
  }
  
  if($connect==0){
    exit;
  }
  
$ip=htmlentities($_GET['slct_ip']);
function blok_ip($ip){
$fichier="options.php";
$fp=fopen($fichier,'r');
while (!feof($fp)) {
$ligne=fgets($fp,255);

	if($ip!="clear"){ //si c'est une ip
		if(!ereg("ipstop",$ligne)){$a_ecrire.=$ligne; // on continue à lire
		}else{
		$sp=strpos($ligne,";") -1;
		$a_ecrire.=substr($ligne,0,$sp).','.$ip.'";'." \n"; // on ajoute l'ip
		$a_ecrire.="// IP ".$ip." bloquée le: ".date('d M Y')."\n"; // et le journal
		$info= 'ban: '.$ip;
		}
	}else{ // sinon c'est "clear"
		if(ereg("IP",$ligne)){$ligne="";$a_ecrire.=$ligne;} // on netoie le journal
		if(!ereg("ipstop",$ligne)){$a_ecrire.=$ligne; // on continue à lire
		}else{
		$a_ecrire.='$my_ms["ipstop"]="192.168.0.1";'." \n"; // on remet le code d'origine
		$info= 'Tout les ban sont lev&eacute;s';
		}
	}
}
fclose($fp);
$fpa=fopen($fichier,'w+');
fwrite($fpa,$a_ecrire);
fclose($fpa);
print '<span style="color:red">'.$info.'</span>';

}
blok_ip($ip);
if($_GET['xhr']=="no"){print '<script type="text/javascript">window.setTimeout("history.go(-1)",1500);</script>';}
?>
