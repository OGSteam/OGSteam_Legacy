<?php
echo "<tr>
 	<td><h1><div align='center'><font color='white'><b>Bienvenu </b>".$user_data["username"]."!</h1></font></div></td>
    </tr>";
//----------------------
//if ($user_data["user_admin"] == 1 || $user_data["management_server"] == 1 || $user_data["management_user"] == 1) {
   require "includes/statsfuncsup.php";

//}
         echo "<tr>";
         echo "\t"."<td align='center'><a style='cursor:pointer' onmouseover=\"this.T_WIDTH=210;this.T_STICKY=true;this.T_TEMP=0;return escape('".$ratiolegend."')\">"
              ."Votre IdP : <font color='".$ratio_color."'>".$balise_ratio_open.formate_number($user_ratio).$balise_ratio_close."</font></a>".help("search_ratio_info")."</td>";
         echo "</tr>";



         //-----------------------------------------------




?>