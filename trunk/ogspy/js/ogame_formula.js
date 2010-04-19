//Production par heure
function production (building, level, temperature, NRJ) {
	switch (building) {
		case "M":
		result = 20 + 30 * level * Math.pow(1.1, level);
		break;

		case "C":
		result = 10 + 20 * level * Math.pow(1.1, level);
		break;

		case "D":
		result = 10 * level * Math.pow(1.1, level) * (-0.002 * temperature + 1.28);
		break;

		case "CES":
		result = 20 * level * Math.pow(1.1, level);
		break;

		case "CEF":
		result = 30 * level * Math.pow((1.05 + 0.01 * NRJ), level);
		break;

		default:
		result = 0;
		break;
	}

	return Math.round(result);
}

//Production des satellites
function production_sat (temperature) {
	return Math.floor((temperature / 4) + 20);
}

//Consommation d"énergie
function consumption (building, level) {
	switch (building) {
		case "M":
		result = 10 * level * Math.pow(1.1, level);
		break;

		case "C":
		result = 10 * level * Math.pow(1.1, level);
		break;

		case "D":
		result = 20 * level * Math.pow(1.1, level);
		break;

		case "CEF":
		result = 10 * level * Math.pow(1.1, level);
		break;

		default:
		result = 0;
		break;
	}

	return Math.round(result);
}
