<?php
define("IN_SPYOGAME", true);
require_once("common.php");
   if (is_dir('mod/myspeach/admin')) {
   rmdir('mod/myspeach/admin/maj');
   rmdir('mod/myspeach/admin/skins');
   remove_directory('mod/myspeach/admin/temp/');
   @unlink('mod/myspeach/admin/config.php');
}

   function remove_directory($dir) {
     if(substr($dir, -1, 1) == "/"){
       $dir = substr($dir, 0, strlen($dir) - 1);
     }
     if ($handle = opendir("$dir")) {
       while (false !== ($item = readdir($handle))) {
         if ($item != "." && $item != "..") {
           if (is_dir("$dir/$item")) { remove_directory("$dir/$item");  }
           else { unlink("$dir/$item"); }
         }
       }
       closedir($handle);
       rmdir($dir);
     }
   }
?>