<?php

class system
{

     
    
    public static function get_system_by_row($id, $galaxy,$system,$row, $time)
    { 
      $retour = "(" . $galaxy . ", '" . $system . "', '" .$row . "',  '" . $id . "' ,  '" . $time . "' )";
    return $retour ; 
      
     } 
      
      
 public static function get_clean_up_system( $galaxy,$system, $time)
    { 
        $retour = "DELETE FROM " . TABLE_UNI . " ";
        $retour .= "WHERE galaxy = ".$galaxy." ";
        $retour .= "AND galaxy = ".$system." ";
        $retour .= "AND datadate != ".$time." ";
        
        return $retour;
       
      
     } 
      
      

}
