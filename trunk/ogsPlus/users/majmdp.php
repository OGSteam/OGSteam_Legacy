<?php

  require ('../admin/connexion.php');
  $select = mysql_query("SELECT pass FROM users WHERE id='".$id."' ");
  $data = mysql_fetch_assoc($select);

if(md5($_POST['pass1']) == $data['pass']) {

if(!empty($_POST['pass2'])) {

    if($_POST['pass2'] == $_POST['pass3']) {
        $quet=mysql_query("UPDATE users SET pass='".md5(htmlentities($_POST['pass3']))."' WHERE id ='$id'");
        mysql_close();
        
        echo "$lng_bf_aa.
        <META http-EQUIV=\"Refresh\" CONTENT=\"4; url=kick.php\">
        ";
        
    }else{

    echo "$lng_bf_ab";

    }
  
  }else{
  
  echo "$lng_bf_ab";
  
  }
  
}else{

echo "$lng_bf_ab";

}

?>

 <? mysql_close(); ?>
