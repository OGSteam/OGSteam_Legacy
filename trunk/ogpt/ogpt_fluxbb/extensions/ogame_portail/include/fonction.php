<?php

/// convertion des chiffrre
function conv($number)
{
	return(number_format($number,0,'.',' '));
}


function ressource($number)
{
	if ($number ==1) return('Deuterium');
	else if ($number ==2) return('Cristal');
	else if ($number ==3) return('metal');
	else return('???????');
}










	



?>