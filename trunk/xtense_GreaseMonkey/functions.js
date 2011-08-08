function displayOption(id){
	if(id=="Xtense_table_serveurs"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_table_pages").style.display="none";
	} else if(id=="Xtense_table_pages"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_table_serveurs").style.display="none";
	}
}