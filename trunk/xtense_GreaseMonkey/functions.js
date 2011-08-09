function displayOption(id){
	if(id=="Xtense_serveurs"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_pages").style.display="none";
	} else if(id=="Xtense_pages"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_serveurs").style.display="none";
	}
}