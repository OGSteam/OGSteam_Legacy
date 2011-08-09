function displayOption(id){
	if(id=="Xtense_serveurs"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_pages").style.display="none";
		document.getElementById("Xtense_options").style.display="none";
		document.getElementById("Xtense_about").style.display="none";
		document.getElementById("menu_servers").style.color="white";
		document.getElementById("menu_pages").style.color="orange";
		document.getElementById("menu_options").style.color="orange";
		document.getElementById("menu_about").style.color="orange";		
	} else if(id=="Xtense_pages"){
		document.getElementById(id).style.display="block";		
		document.getElementById("Xtense_serveurs").style.display="none";
		document.getElementById("Xtense_options").style.display="none";
		document.getElementById("Xtense_about").style.display="none";
		document.getElementById("menu_servers").style.color="orange";
		document.getElementById("menu_pages").style.color="white";
		document.getElementById("menu_options").style.color="orange";
		document.getElementById("menu_about").style.color="orange";
	} else if(id=="Xtense_options"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_serveurs").style.display="none";		
		document.getElementById("Xtense_pages").style.display="none";
		document.getElementById("Xtense_about").style.display="none";
		document.getElementById("menu_servers").style.color="orange";
		document.getElementById("menu_pages").style.color="orange";
		document.getElementById("menu_options").style.color="white";
		document.getElementById("menu_about").style.color="orange";
	} else if(id=="Xtense_about"){
		document.getElementById(id).style.display="block";
		document.getElementById("Xtense_serveurs").style.display="none";
		document.getElementById("Xtense_pages").style.display="none";
		document.getElementById("Xtense_options").style.display="none";
		document.getElementById("menu_servers").style.color="orange";
		document.getElementById("menu_pages").style.color="orange";
		document.getElementById("menu_options").style.color="orange";
		document.getElementById("menu_about").style.color="white";
		
		
	}
}