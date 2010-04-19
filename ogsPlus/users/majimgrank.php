<?php
  
        if($_POST['CHK1'] == ON){
        
        require ('../admin/connexion.php');
        $quet=mysql_query("UPDATE users SET 
        rank_bg='".htmlentities($_POST['R1'])."', rvb_rank_r_1='240', rvb_rank_v_1='240', rvb_rank_b_1='240', rvb_rank_r_2='255', rvb_rank_v_2='255', rvb_rank_b_2='255', rvb_rank_r_3='240', rvb_rank_v_3='240', rvb_rank_b_3='240', rvb_rank_r_4='255', rvb_rank_v_4='255', rvb_rank_b_4='255', r_chiff_rank='0', v_chiff_rank='0', b_chiff_rank='0', r_txt_rank='0', v_txt_rank='0', b_txt_rank='0', rank_separ='".htmlentities($_POST['SepaRank'])."' WHERE id ='$id'");
        mysql_close();
                 
        }else{
        
        require ('../admin/connexion.php');
        $quet=mysql_query("UPDATE users SET 
        rank_bg='".htmlentities($_POST['R1'])."', rvb_rank_r_1='".htmlentities($_POST['CC1'])."', rvb_rank_v_1='".htmlentities($_POST['CC2'])."', rvb_rank_b_1='".htmlentities($_POST['CC3'])."', rvb_rank_r_2='".htmlentities($_POST['CC4'])."', rvb_rank_v_2='".htmlentities($_POST['CC5'])."', rvb_rank_b_2='".htmlentities($_POST['CC6'])."', rvb_rank_r_3='".htmlentities($_POST['CC7'])."', rvb_rank_v_3='".htmlentities($_POST['CC8'])."', rvb_rank_b_3='".htmlentities($_POST['CC9'])."', rvb_rank_r_4='".htmlentities($_POST['CC10'])."', rvb_rank_v_4='".htmlentities($_POST['CC11'])."', rvb_rank_b_4='".htmlentities($_POST['CC12'])."', r_chiff_rank='".htmlentities($_POST['CC34'])."', v_chiff_rank='".htmlentities($_POST['CC35'])."', b_chiff_rank='".htmlentities($_POST['CC36'])."', r_txt_rank='".htmlentities($_POST['CC31'])."', v_txt_rank='".htmlentities($_POST['CC32'])."', b_txt_rank='".htmlentities($_POST['CC33'])."', rank_separ='".htmlentities($_POST['SepaRank'])."', prod_separ='".htmlentities($_POST['SepaProd'])."' WHERE id ='$id'");
        mysql_close();
              
        }
            
;?>
<?php echo $lng_be_aa ?>

<META http-EQUIV="Refresh" CONTENT="1; url=index.php?lng=<?php echo $lng ?>&page=galerie.php"> 
