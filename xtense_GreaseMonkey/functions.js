function displayOption(id){
	if(id=="Xtense_serveurs"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_pages").style.display="none";
		document.getElementById("Xtense_options").style.display="none";
		document.getElementById("Xtense_about").style.display="none";
		
	} else if(id=="Xtense_pages"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_serveurs").style.display="none";
		document.getElementById("Xtense_options").style.display="none";
		document.getElementById("Xtense_about").style.display="none";
	} else if(id=="Xtense_options"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_serveurs").style.display="none";
		document.getElementById("Xtense_pages").style.display="none";
		document.getElementById("Xtense_about").style.display="none";
	} else if(id=="Xtense_about"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_serveurs").style.display="none";
		document.getElementById("Xtense_pages").style.display="none";
		document.getElementById("Xtense_options").style.display="none";
	}
}