<?php

session_start();

if($type == 1) {

                      require ('../admin/connexion.php');
                      $select = mysql_query("SELECT * FROM users WHERE nom='".$nom."' AND uni='".$uni."' ");
                      $data = mysql_fetch_assoc($select);
                      
                        if(md5($pass) == $data['pass']) {
                                         
                          $quet=mysql_query("SELECT * FROM users WHERE nom='".$nom."' AND uni='".$uni."' ");
                          while ($result=mysql_fetch_array($quet))
                          $_SESSION['id'] = $result["id"];
                          
                          mysql_close();
                          
                          $_SESSION['sousdossier'] = perso;
                      
                          header("Location: login_perso_1.php");
                          exit;
                    
                    }else{
                    
                          echo ":-( ERREUR";
                    
                    }

}else{

                      require ('../admin/connexion.php');
                      $select = mysql_query("SELECT * FROM alli WHERE nom='".$nom."' AND uni='".$uni."' ");
                      $data = mysql_fetch_assoc($select);
                      
                          if(md5($pass) == $data['pass']) {
                          
                          $quet=mysql_query("SELECT * FROM alli WHERE nom='".$nom."' AND uni='".$uni."' ");
                          while ($result=mysql_fetch_array($quet))
                          $_SESSION['id'] = $result["id"];
                          
                          mysql_close();
                          
                          $_SESSION['sousdossier'] = alli;
                                                                               
                          header("Location: login_alli_1.php");
                          exit;
                          
                    }else{
                    
                          echo ":-( ERREUR";
                    
                    }            
                            
}

?>
