<?php
           
        if($_POST['CHK2'] == ON){
        
        require ('../admin/connexion.php');
        $quet=mysql_query("UPDATE users SET 
        prod_bg='".htmlentities($_POST['R2'])."', rvb_prod_r_1='240', rvb_prod_v_1='240', rvb_prod_b_1='240', rvb_prod_r_2='255', rvb_prod_v_2='255', rvb_prod_b_2='255', rvb_prod_r_3='240', rvb_prod_v_3='240', rvb_prod_b_3='240', rvb_prod_r_4='255', rvb_prod_v_4='255', rvb_prod_b_4='255', r_chiff_prod='0', v_chiff_prod='0', b_chiff_prod='0', r_txt_prod='0', v_txt_prod='0', b_txt_prod='0', prod_separ='".htmlentities($_POST['SepaProd'])."' WHERE id ='$id'");
        mysql_close();
                 
        }else{
        
        require ('../admin/connexion.php');
        $quet=mysql_query("UPDATE users SET 
        prod_bg='".htmlentities($_POST['R2'])."', rvb_prod_r_1='".htmlentities($_POST['CC13'])."', rvb_prod_v_1='".htmlentities($_POST['CC14'])."', rvb_prod_b_1='".htmlentities($_POST['CC15'])."', rvb_prod_r_2='".htmlentities($_POST['CC16'])."', rvb_prod_v_2='".htmlentities($_POST['CC17'])."', rvb_prod_b_2='".htmlentities($_POST['CC18'])."', rvb_prod_r_3='".htmlentities($_POST['CC19'])."', rvb_prod_v_3='".htmlentities($_POST['CC20'])."', rvb_prod_b_3='".htmlentities($_POST['CC21'])."', rvb_prod_r_4='".htmlentities($_POST['CC22'])."', rvb_prod_v_4='".htmlentities($_POST['CC23'])."', rvb_prod_b_4='".htmlentities($_POST['CC24'])."', r_chiff_prod='".htmlentities($_POST['CC28'])."', v_chiff_prod='".htmlentities($_POST['CC29'])."', b_chiff_prod='".htmlentities($_POST['CC30'])."', r_txt_prod='".htmlentities($_POST['CC25'])."', v_txt_prod='".htmlentities($_POST['CC26'])."', b_txt_prod='".htmlentities($_POST['CC27'])."' WHERE id ='$id'");
        mysql_close();
        
        } 

;?>
<?php echo $lng_be_aa ?>

<META http-EQUIV="Refresh" CONTENT="1; url=index.php?lng=<?php echo $lng ?>&page=galerie.php"> 
