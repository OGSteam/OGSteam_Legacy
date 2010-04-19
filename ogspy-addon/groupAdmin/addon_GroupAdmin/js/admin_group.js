//-----------------------------
// Variables globales

// Nombre d'elements par lignes dans le tableau des groupes
var size_groups = 5;
// dans le tableau des membres d'un groupe
var size_membres = 5;
// ID du groupe selectionne
var current_group = 0;
// Nom du groupe selectionne
var current_group_name = '';
// Status courant du chargement
var loading = false;
// Membres du groupe courrant
var members = new Array();
// Nom des options de configs
var link = new Array('', '', 'server_set_system', 'server_set_spy', 'server_set_ranking', 'server_show_positionhided', 'ogs_connection', 'ogs_set_system', 'ogs_get_system', 'ogs_set_spy', 'ogs_get_spy', 'ogs_set_ranking', 'ogs_get_ranking');

//-----------------------------
// Fonctions

function tellerror(msg, url, linenumber){
	alert('Error: ['+msg+']\nLine: '+linenumber);
	return true;
}
window.onerror=tellerror

// Fonctions usuelles, tout est dans le nom ! 
function display() {	
	len = display.arguments.length;
	for (i = 0; i < len; i ++) {
		if (document.getElementById(display.arguments[i])) document.getElementById(display.arguments[i]).style.display = 'block'; 
	}
}
function hide() {	
	len = hide.arguments.length;
	for (i = 0; i < len; i ++) {
		if (document.getElementById(hide.arguments[i])) document.getElementById(hide.arguments[i]).style.display = 'none'; 
	}
}
function print(Id, t) {	if (document.getElementById(Id)) document.getElementById(Id).innerHTML = t; }

//-------------------------------------------
// Ajoute un élément dans le tableau existant, à la position indiquée.
// Fonction trouvée sur www.QuentinC.net
//
Array.prototype.insert = function (el, index) {
	var a = this.slice(0, index);
	var b = this.slice(index, this.length);
	var c = a.concat(new Array(el)).concat(b);
	this.length = 0;
	for (var i=0; i < c.length; i++) { this[i]=c[i]; }
	return this;
}

//-------------------------------------------
// Efface les éventuels blancs au début et à la fin de la chaîne.
// Fonction trouvée sur www.QuentinC.net
//
String.prototype.trim = function () {
	var reg = new RegExp("^\\s*");
	var reg2 = new RegExp("\\s*$");
	return this.replace(reg, "").replace(reg2, "");
}


//-------------------------------------------
// Envoi en get l'url "file" et renvoit le resultat vers la fonction "callback"
function send(file, callback) {
	// on affiche le chargement
	print('info', '<img src="images/ajax.gif" align="absmiddle" /> Chargement en cours...');
	loading = true;
	
	var xhr_object = null;
	if(window.XMLHttpRequest)
	xhr_object = new XMLHttpRequest(); 
	else if(window.ActiveXObject)
	xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else alert ('Votre navigateur ne supporte pas Ajax, veuillez poster sur le forum de l\'OGSteam votre problème');
	
	xhr_object.onreadystatechange = function() {
		if(xhr_object.readyState == 4) {
			// On enlève le chargement
			print('info', 'Chargement fini');
			loading = false;
			
			texte = xhr_object.responseText;
			
			// Si l'utilisateur est deloggé, ca renvoit : "\ndelog"... le \n etant en trop, on utilise trim
			// Pour afficher que l'on redirige l'utilisateur vers l'index
			if (texte.trim() == 'delog') {
				print('info', '<strong style="color:#FF0000;">Erreur:</strong> Votre session a expirée, vous allez être redirigé dans 5 secondes vers la page de login');
				setTimeout('document.location.href = document.location.href;', 5000);
				return;
			}
			
			// Autrement on appelle la fonction de callback
			eval(callback);
		}
	}

	xhr_object.open("GET", file, true); 
	xhr_object.send(null);
}

//-------------------------------------------
// Afficher les groupes sous forme de tableau
function parse_groups() {
	var len = group_list.length;
	var str = '<table width="400" align="center"><tr>';
	for (i = 0; i < len; i++) {
		style = (group_id[i] == current_group ? ' style="color:lime;"' : '');
		str += '<th width="'+Math.round(450/size_groups)+'"><a href="javascript:void(0);" onclick="select_group('+group_id[i]+')"'+style+'>'+group_list[i]+'</a></th>';
		if ((i+1)%size_groups == 0) str += '</tr>';
	}
	if ((i+1)%size_groups != 0) str += '</tr>';
	str += '</table>';
	print('group_list', str);
}

//-------------------------------------------
// Fonction pour la création d'un groupe
function create_group() {
	
	// Empecher de changer de groupe lors d'un chargement
	if (loading) return;
	
	// [AJAX]
	if (create_group.arguments.length == 1) {
		text = create_group.arguments[0];
		
		// Le texte que l'on recoit est soit un nom ou si ca a marché : 
		// une chaine du type : [Id_groupe];[Nom] Donc il faut y separer
		text = text.split(new RegExp(';', 'g'));
		parse_groups();
		// On test ce qui est retourné
		if (text[0] == 'allready') print('info', '<strong style="color:#FF0000;">Erreur:</strong> Le groupe que vous tentez de créer existe déjà');
		else if (text[0] == 'false') print('info', '<strong style="color:#FF0000;">Erreur:</strong> Erreur fatale');
		else if (text[0] == 'invalid') print('info', '<strong style="color:#FF0000;">Erreur:</strong> Le nom du groupe est invalide');
		else if (parseInt(text[0]) != 0) {
			print('info', '<strong>Info: </strong>Groupe correctement créé');
			
			// On ajoute alors a la fin du tableau des groupes, le nom du groupe. On le tri alors dans l'ordre alphabétique
			// On doit ensuite ajouter l'id du groupe dans le tableau des id des groupes, au même index que le nom dans le
			// tableau des noms de groupes. Il faut alors le parcourir pour trouver l'index
			// Problème encore non résolu. Il trie dabord avec les MAj en premier et les minuscules après... 
			group_list.push(text[1]);
			group_list.sort();
			
			var l = group_list.length;
			var key = 0;
			
			for (i = 0; i < l; i++) {
				if (group_list[i] == text[1]) {
					key = i;
					break;
				}
			}
			
			group_id.insert(text[0], key);
			parse_groups();
			select_group(text[0]);
		}
		return;
	}
	
	group_name = document.form.group_name.value;
	if (group_name != '') {
		// Nom non valide
		if (!group_name.match(new RegExp('^[A-Za-z0-9-]{3,15}$', 'g'))) {
			print('info', '<strong style="color:#FF0000;">Erreur:</strong> Le nom du groupe n\'est pas valide');
			return;
		}
		
		// On efface le contenu du nom du nouveau groupe
		document.form.group_name.value = '';
		// Envoit du groupe en Ajax
		send('index.php?action=usergroup_create&ajax=1&groupname='+group_name, 'create_group(texte);');
	}
}

//-------------------------------------------
// Afficher les membres 
function parse_members(members) {
	if (members[0] == '' || members.length == 0) {
		print('group_members', 'Il n\'y a aucun membre dans ce groupe');
		return;
	}
	
	len = members.length;
	str = '';
	// On separe alors la ligne du membre pour recup son ID et PSeudo, puis on met a la suite de la variable le code HTML pour l'afficher
	for (i = 0; i < len; i++) {
		var a = new Array();
		a = members[i].split(new RegExp(',', 'g'));
		str += '<span style="float:left; width:100px; text-align:center;">'+a[1]+' <img src="images/drop.png" align="absmiddle" style="cursor:pointer" onclick="del_member('+a[0]+');" /></span>';
	}
	// On met le code HTML de tous les membres dans la partie Group_members
	print('group_members', str);
}

//-------------------------------------------
// Afficher le formulaire pour les droits
function parse_auth(auth) {
	for (i = 2; i < 13; i ++) {
		document.getElementById(link[i]).checked = (auth[i] == 1 ? true : false);
	}
}

//-------------------------------------------
// Afficher la liste pour rajouter un joueur. Il n'y a que les joueurs non présents dans le groupe
function parse_list(members) {
	
	len = members.length;
	id = new Array();
	
	// On recupère l'id du joueur pour chaque joueur, et on le place dans un tableau appart en index
	for (i = 0; i < len; i ++) {
		s = members[i].split(new RegExp(',', 'g'));
		id[s[0]] = 1;
	}
	
	len = user_id.length;
	list_id = new Array();
	list_names = new Array();
	
	// On parcout le tableau user_id. Pour chaque ligne, on test si l'id du joueur n'est pas definie dans le tableau 'id' en index
	for (i = 0; i < len; i ++) {
		if (!id[user_id[i]]) {
			list_id.push(user_id[i]);
			list_names.push(user_names[i]);
		}
	}
	
	// On vide la liste
	document.getElementById('user').options.length = 0;
	
	// On la remplit ensuite avec les nouvelles valeurs
	len = list_id.length;
	for (i = 0; i < len; i ++) {
		document.getElementById('user').options[i] = new Option(list_names[i]);
		document.getElementById('user').options[i].value = list_id[i];
	}
	
}

//-------------------------------------------
// Selection d'un groupe -> affiche alors toutes ses infos
function select_group(id) {
	if (loading) return;
	// [AJAX]
	if (select_group.arguments.length == 2) {
		/*
			Le texte renvoyé est sous la forme : 
			
			[ID_membre],[Pseudo_membre]
			[ID_membre],[Pseudo_membre] [...]
			=
			[Id_groupe],[Nom_groupe],[Autorisations ...]
		
		*/
		text = select_group.arguments[1];
		// On separe déjà les membres des informations du groupe (id, nom + auth)
		text = text.split(new RegExp("\n=\n", 'g'));
		
		// On separe tous les membres dans un tableau [1 membre par ligne]
		members = text[0].split(new RegExp("\n", 'g'));
		
		// On separe les informations
		var auth = new Array();
		auth = text[1].split(new RegExp(",", 'g'));
		
		
		// Si il y a eu une erreur
		if (members[0] == 'false' || auth[0] == 'false') {
			print('info', '<strong style="color:#FF0000;">Erreur:</strong> Erreur fatale');
			return;
		}
		// Mise a jour des informations
		print('group_info', '');
		print('group_name1', auth[1]);
		print('group_name2', auth[1]);
		print('group_name3', auth[1]);
		document.getElementById('new_name').value = auth[1];
		
		current_group = auth[0];
		current_group_name = auth[1];
		
		// On parse les membres, les paramètres d'auth ainsi que la liste pour ajouter des membres
		parse_members(members);
		parse_auth(auth);
		parse_list(members);
		parse_groups();
		
		// Puis on affiche le tout
		hide('del_group2');
		display('group_auth_block', 'group_members_block', 'group_infos_block', 'del_group1');
		
		return;
	}
	
	// On ne recharge pas le même groupe que celui selectionné
	if (id != current_group) {
		send('index.php?action=usergroup_get&ajax=1&group_id='+id, 'select_group(0, texte);');
	}
}


function group_rename() {
	if (loading) return;
	// [AJAX]
	if (group_rename.arguments.length == 1) {
		text = group_rename.arguments[0];
		if (text == 'false') {
			print('info', '<strong style="color:#FF0000;">Erreur:</strong> Erreur fatale');
			return;
		}
		
		// On renomme alors dans le script
		print('group_name1', text);
		print('group_name2', text);
		print('group_name3', text);
		
		// Ainsi que dans le tableau des groupes :
		len = group_id.length;
		for (i = 0; i < len; i ++) {
			if (group_id[i] == current_group) key = i;
		}
		
		group_list[key] = text;
		
		// Et on réaffiche les groupes
		parse_groups();
		print('info', 'Le nom du groupe a été correctement changé');
		return;
	}
	
	new_name = document.getElementById('new_name').value;
	
	if (new_name != current_group_name) {
		// On test la validité
		if (!new_name.match(new RegExp('[A-Za-z0-9-]{3,15}', 'g'))) {
			print('info', '<strong style="color:#FF0000;">Erreur:</strong> Le nom du groupe n\'est pas valide');
			return;
		}
		
		// On envoit les infos
		send('index.php?action=usergroup_rename&ajax=1&group_id='+current_group+'&group_name='+new_name, 'group_rename(texte);');
	}
}

function group_delete() {
	if (loading) return;
	
	// [AJAX]
	if (group_delete.arguments.length == 1) {
		text = group_delete.arguments[0];
		
		if (text == 'false') {
			print('info', '<strong style="color:#FF0000;">Erreur:</strong> Erreur fatale');
			return;
		}
		
		// La suppression du groupe est alors confirmée, on supprime le groupe dans la liste, et on enleve les SPAN des infos
		len = group_id.length;
		for (i = 0; i < len; i ++) {
			if (group_id[i] == current_group) {
				group_id.splice(i, 1);
				group_list.splice(i, 1);
				break;
			}
		}
		
		parse_groups();
		
		display('del_group1');
		hide('group_auth_block', 'group_members_block', 'group_infos_block', 'del_group2');
		print('info', 'Le groupe a été correctement supprimé');
		
		return;
	}
	
	if (current_group == 1) {
		print('info', '<strong style="color:#FF0000;">Erreur:</strong> Vous ne pouvez pas supprimer ce groupe');
		return;
	}
	
	// On envoit la suppression du groupe
	send('index.php?action=usergroup_delete&group_id='+current_group, 'group_delete(texte);')
}


function add_member() {
	if (loading) return;
	
	// [AJAX]
	if (add_member.arguments.length == 1) {
		text = add_member.arguments[0];
		if (text == 'false') {
			print('info', '<strong style="color:#FF0000;">Erreur:</strong> Erreur fatale');
			return;
		}
		
		// On supprime alors l'utilisateur de la liste et on l'affiche dans les membres
		len = user_id.length;
		for (i = 0; i < len; i ++) {
			if (user_id[i] == text) {
				members.push(text+','+user_names[i]);
				break;
			}
		}
		
		// Si le groupe ne contient pas de joueurs, members[0] est vide, ca fait alors bugger le script
		// Donc on le supprime alors
		if (members[0] == '') members.splice(0,1);
		
		members.sort();
		parse_members(members);
		parse_list(members);
		
		print('info', 'Utilisateur correctement ajouté au groupe')
		
		return;
	}
	
	// On recupère l'ID du joueur a inserer et on envoit
	id = document.getElementById('user').options[document.getElementById('user').selectedIndex].value;
	send('index.php?action=usergroup_newmember&group_id='+current_group+'&user_id='+id, 'add_member(texte);');
}

function del_member(id) {
	if (loading) return;
	
	// [AJAX]
	if (del_member.arguments.length == 2) {
		text = del_member.arguments[1];
		if (text == 'false') {
			print('info', '<strong style="color:#FF0000;">Erreur:</strong> Erreur fatale');
			return;
		}
		
		// On supprime alors l'utilisateur du group et on le rajoute dans la liste
		len = members.length;
		for (i = 0; i < len; i ++) {
			t = members[i].split(new RegExp(',', 'g'));
			if (t[0] == text) {
				members.splice(i, 1);
				break;
			}
		}
		
		parse_members(members);
		parse_list(members);
		
		print('info', 'Utilisateur correctement supprimé du groupe')
		
		return;
	}
	
	send('index.php?action=usergroup_delmember&group_id='+current_group+'&user_id='+id, 'del_member(0, texte);');
}


function set_auth() {
	if (loading) return;
	
	// [AJAX]
	if (set_auth.arguments.length == 1) {
		text = set_auth.arguments[0];
		if (text == 'false') {
			print('info', '<strong style="color:#FF0000;">Erreur:</strong> Erreur fatale');
			return;
		}
		
		print('info', 'Les permissions du groupe ont correctement été enregistrées');
		
		return;
	}
	
	// On crée l'url. Pour chaque champ contenu dans link[] on test si il est coché ou pas. puis on rajoute a la suite
	url = 'index.php?action=usergroup_setauth&group_id='+current_group;
	for (i = 2; i < 13; i ++) {
		url += '&'+link[i]+'='+ (document.getElementById(link[i]).checked ? 1 : 0);
	}
	
	send (url, 'set_auth(texte);');
}




