<?php
  
        if($_POST['DEF'] == CK){
        
        require ('../admin/connexion.php');
        $quet=mysql_query("UPDATE alli SET 
        bg='".htmlentities($_POST['R1'])."', rvb_r_1='240', rvb_v_1='240', rvb_b_1='240', rvb_r_2='255', rvb_v_2='255', rvb_b_2='255', rvb_r_3='240', rvb_v_3='240', rvb_b_3='240', rvb_r_4='255', rvb_v_4='255', rvb_b_4='255', rvb_r_5='240', rvb_v_5='240', rvb_b_5='240', r_chiff='0', v_chiff='0', b_chiff='0', r_txt='0', v_txt='0', b_txt='0', separ='".htmlentities($_POST['SepaRank'])."' WHERE id ='$id'");
        mysql_close();
                 
        }else{
        
        require ('../admin/connexion.php');
        $quet=mysql_query("UPDATE alli SET 
        bg='".htmlentities($_POST['R1'])."', rvb_r_1='".htmlentities($_POST['CC1'])."', rvb_v_1='".htmlentities($_POST['CC2'])."', rvb_b_1='".htmlentities($_POST['CC3'])."', rvb_r_2='".htmlentities($_POST['CC4'])."', rvb_v_2='".htmlentities($_POST['CC5'])."', rvb_b_2='".htmlentities($_POST['CC6'])."', rvb_r_3='".htmlentities($_POST['CC7'])."', rvb_v_3='".htmlentities($_POST['CC8'])."', rvb_b_3='".htmlentities($_POST['CC9'])."', rvb_r_4='".htmlentities($_POST['CC10'])."', rvb_v_4='".htmlentities($_POST['CC11'])."', rvb_b_4='".htmlentities($_POST['CC12'])."', rvb_r_5='".htmlentities($_POST['CC13'])."', rvb_v_5='".htmlentities($_POST['CC14'])."', rvb_b_5='".htmlentities($_POST['CC15'])."', r_chiff='".htmlentities($_POST['CC34'])."', v_chiff='".htmlentities($_POST['CC35'])."', b_chiff='".htmlentities($_POST['CC36'])."', r_txt='".htmlentities($_POST['CC31'])."', v_txt='".htmlentities($_POST['CC32'])."', b_txt='".htmlentities($_POST['CC33'])."', separ='".htmlentities($_POST['SepaRank'])."' WHERE id ='$id'");
        mysql_close();
              
        }

;?>
<?php echo $lng_be_aa ?>

<META http-EQUIV="Refresh" CONTENT="1; url=index.php?lng=<?php echo $lng ?>&page=galerie.php"> 
