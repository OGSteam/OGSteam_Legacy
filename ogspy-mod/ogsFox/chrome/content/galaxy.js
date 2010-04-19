// Rajoute le chiffre zéro pour les valeurs inférieures à 10 (mois, jour, heure, min, sec)
function aff_moins_dix(value)
{
	if (value < 10) return ("0" + value);
	return (value);
}

// Créer la date pour l'envoi vers OGSpy
function get_date()
{
	var now = new Date();
	var og_date = now.getFullYear() + "-";
	og_date += aff_moins_dix(now.getMonth() + 1) + "-";
	og_date += aff_moins_dix(now.getDate()) + " ";
	og_date += aff_moins_dix(now.getHours()) + ":";
	og_date += aff_moins_dix(now.getMinutes()) + ":";
	og_date += aff_moins_dix(now.getSeconds());
	return (og_date);
}

// Analyse chaque ligne de la galaxie et remplie la chaine à renvoyer
function readGalaxy(coords, lines) {
	var len = lines.length;
	var patt = /^(\d+)\x20\x09(?:(?:\x09?([^\(\x09]+)\x20)(?:\((?:[^\)]+)\)\x20)?)?(?:\x09(?:(M)(?:[^\x09]+))?)(?:\x09(?:[^\x09]*)?)(?:\x09(?:([^\x09\(]+)\x20)?(?:\(([^\)]*)\)\x20)?)(?:\x09(?:([^\x09\n]+)\x20)?).*$/;
	var ret = "";
	for (var i = 0; i < len; i++)
	{
		var res = patt.exec(lines[i]);
		if (res != null)
		{
			ret += coords + ":" + res[1] + "||"; //coords
			ret += get_date() + "||"; // date
			if (res[2] != undefined && res[2] != "Planète détruite") // nom planète
				ret += res[2];
			ret += "||";
			ret += (res[3] == undefined ? "0" : "1") + "||"; // lune ?
			ret += (res[4] == undefined ? "" : res[4]) + "||"; // joueur
			//ret += (res[5] == undefined ? "" : res[5]) + "||"; // TODO => status à implémenter correctement
			ret += (res[6] == undefined ? "" : res[6]) + "<|>"; // alliance
		}
	}
	if (DEBUG) alert("Datas :\n" + ret);
	return ret;
}

// Récupère les coordonnées du système et appelle les fonctions adéquates
function parseGalaxy(selection) {
	var resultat = pattern[0].exec(selection);
	var coords = resultat[1] + ":" + resultat[2];
	var lines = selection.split(/\r\n/);
	var datas = readGalaxy(coords, lines);
	sendDatas("postplanets", datas);
}