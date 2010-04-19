// Nombre d'elements par lignes dans le tableau des groupes
var size_groups = 5;
// dans le tableau des membres d'un groupe
var size_membres = 5;
// dans le tableau des mods interdit d'un groupe
var size_mods = 5;
// ID du groupe selectionne
var current_group = 0;
// Nom du groupe selectionne
var current_group_name = '';
// Status courant du chargement
var loading = false;
// Membres du groupe courrant
var members = new Array();
// Mods interdit au groupe
var mods = new Array();
// Droit d'accès du groupe
var auth = new Array();
// Nom des options de configs
var link = new Array('', '', 'server_set_system', 'server_set_spy', 'server_set_rc', 'server_set_ranking', 'server_show_positionhided', 'ogs_connection', 'ogs_set_system', 'ogs_get_system', 'ogs_set_spy', 'ogs_get_spy', 'ogs_set_ranking', 'ogs_get_ranking');

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
function print(Id, t) {	
	if (document.getElementById(Id)) 
		document.getElementById(Id).innerHTML = t; 
}
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
// Afficher les groupes sous forme de tableau
function parse_groups() {
	var len = group_list.length;
	var str = '<'+'table width="400" align="center"><'+'tr>';
	for (i = 0; i < len; i++) {
		style = (group_id[i] == current_group ? 'color:lime;' : '');
		str += '<'+'th width="'+Math.round(450/size_groups)+'"><'+'a style="cursor:pointer;'+style+'" onclick="select_group('+group_id[i]+')">'+group_list[i]+'</'+'a></'+'th>';
		if ((i+1)%size_groups == 0) str += '</'+'tr>';
	}
	if ((i+1)%size_groups != 0) str += '</'+'tr>';
	str += '</'+'table>';
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
		// text = text.split(new RegExp(';', 'g'));
		parse_groups();
		// On test ce qui est retourné
		if (text == 'allready') print('info', message_lang[0]+message_lang[2]);
		else if (text == 'false') print('info', message_lang[0]+message_lang[1]);
		else if (text == 'invalid') print('info', message_lang[0]+message_lang[3]);
		else if (parseInt(text[0]) != 0) {
			print('info', message_lang[4]);
			
			// On ajoute alors a la fin du tableau des groupes, le nom du groupe. On le tri alors dans l'ordre alphabétique
			// On doit ensuite ajouter l'id du groupe dans le tableau des id des groupes, au même index que le nom dans le
			// tableau des noms de groupes. Il faut alors le parcourir pour trouver l'index
			// Problème encore non résolu. Il trie dabord avec les MAj en premier et les minuscules après... 
			group_list.push(text[1]);
			group_id.push(text[0]);
			//group_list.sort();
			
			//var l = group_list.length;
			//var key = 0;
			
			//for (i = 0; i < l; i++) {
			//	if (group_list[i] == text[1]) {
			//		key = i;
			//		break;
			//	}
			//}
			
			//group_id.insert(text[0], key);
			parse_groups();
			select_group(text[0]);
		}
		return;
	}
	
	//group_name = document.form.group_name.value;
	group_name = document.getElementById('group_name').value;
	if (group_name != '') {
		// Nom non valide
		if (!group_name.match(new RegExp('^[A-Za-z0-9-]{3,15}$', 'g'))) {
			print('info', message_lang[0]+message_lang[3]);
			return;
		}
		
		// On efface le contenu du nom du nouveau groupe
		//document.form.group_name.value = '';
		document.getElementById('group_name').value = '';
		// Envoit du groupe en Ajax
		send({action:'usergroup_create',ajax:'1',groupname:group_name},'create_group(json);');
	}
}

//-------------------------------------------
// Afficher les membres 
function parse_members() {
	if (members[0] == '' || members.length == 0) {
		print('group_members', message_lang[5]);
		return;
	}
	
	len = members.length;
	str = '';
	// On separe alors la ligne du membre pour recup son ID et PSeudo, puis on met a la suite de la variable le code HTML pour l'afficher
	for (i = 0; i < len; i++) {
		var a = new Array();
		a = members[i].split(new RegExp(',', 'g'));
		str += '<'+'span style="float:left; width:100px; text-align:center;">'+a[1]+' <'+'img src="images/drop.png" align="absmiddle" style="cursor:pointer" onclick="javascript:del_member('+a[0]+');" /></'+'span>';
	}
	// On met le code HTML de tous les membres dans la partie Group_members
	print('group_members', str);
}

//-------------------------------------------
// Afficher les mods 
function parse_mods() {
	if (mods[0] == '' || mods.length == 0) {
		print('group_mods', message_lang[6]);
		return;
	}
	
	len = mods.length;
	str = '';
	// On separe alors la ligne du mod pour recup son ID et tire, puis on met a la suite de la variable le code HTML pour l'afficher
	for (i = 0; i < len; i++) {
		var a = new Array();
		a = mods[i].split(new RegExp(',', 'g'));
		str += '<'+'span style="float:left; width:100px; text-align:center;">'+a[1]+' <'+'img src="images/drop.png" align="absmiddle" style="cursor:pointer" onclick="del_mod('+a[0]+');" /></'+'span>';
	}
	// On met le code HTML de tous les membres dans la partie Group_members
	print('group_mods', str);
}

//-------------------------------------------
// Afficher le formulaire pour les droits
function parse_auth() {
	for (i = 2, len = link.length; i < len; i ++) {
		document.getElementById(link[i]).checked = (auth[i] == 1 ? true : false);
	}
}

//-------------------------------------------
// Afficher la liste pour rajouter un joueur. Il n'y a que les joueurs non présents dans le groupe
function parse_list() {
	
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
	if(len>0){
		display('add_member1');
		hide('add_member2');
	} else {
		display('add_member2');
		hide('add_member1');
	}
	
}

//-------------------------------------------
// Afficher la liste pour rajouter un mod. Il n'y a que les mods non présents dans le groupe
function parse_list_mods() {
	len = mods.length;
	mod_ids = new Array();

	// On recupère l'id du joueur pour chaque joueur, et on le place dans un tableau appart en index
	for (i = 0; i < len; i ++) {
		s = mods[i].split(new RegExp(',', 'g'));
		mod_ids[s[0]] = 1;
	}
	len = mod_id.length;
	list_id = new Array();
	list_names = new Array();
	
	// On parcout le tableau user_id. Pour chaque ligne, on test si l'id du joueur n'est pas definie dans le tableau 'id' en index
	for (i = 0; i < len; i ++) {
		if (!mod_ids[mod_id[i]]) {
			list_id.push(mod_id[i]);
			list_names.push(mod_list[i]);
		}
	}
	
	// On vide la liste
	document.getElementById('module').options.length = 0;
	
	// On la remplit ensuite avec les nouvelles valeurs
	len = list_id.length;
	for (i = 0; i < len; i ++) {
		document.getElementById('module').options[i] = new Option(list_names[i]);
		document.getElementById('module').options[i].value = list_id[i];
	}
	if(len>0){
		display('add_mod1');
		hide('add_mod2');
	} else {
		display('add_mod2');
		hide('add_mod1');
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
			
			'members' : "ID,NAME", "ID,NAME",...
			'modules' : "ID,NAME", "ID,NAME",...
			'auth' : {contenu de la table USERGROUP sous forme de tableau}
		
		*/
		text = select_group.arguments[1];

		members = text['members'];
		mods = text['modules'];
		auth = text['auth'];
		// Si il y a eu une erreur
		if (auth[0] == 'false') {
			print('info', message_lang[0]+message_lang[1]);
			return;
		}
		// Mise a jour des informations
		print('group_info', '');
		print('group_name1', auth[1]);
		document.getElementById('new_name').value = auth[1];
		
		current_group = auth[0];
		current_group_name = auth[1];
		
		// On parse les membres, les paramètres d'auth ainsi que la liste pour ajouter des membres
		parse_members();
		parse_mods()
		parse_auth();
		parse_list();
		parse_list_mods()
		parse_groups();
		
		// Puis on affiche le tout
		hide('del_group2');
		display('group_auth_block', 'group_mods_block', 'group_members_block', 'group_infos_block', 'del_group1');
		
		return;
	}
	
	// On ne recharge pas le même groupe que celui selectionné
	if (id != current_group) {
		send({action:'usergroup_get',ajax:'1',group_id:id},'select_group(0, json);');
	}
}

function group_rename() {
	if (loading) return;
	// [AJAX]
	if (group_rename.arguments.length == 1) {
		text = group_rename.arguments[0];
		if (text == 'false') {
			print('info', message_lang[0]+message_lang[1]);
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
		print('info', message_lang[7]);
		return;
	}
	
	new_name = document.getElementById('new_name').value;
	
	if (new_name != current_group_name) {
		// On test la validité
		if (!new_name.match(new RegExp('[A-Za-z0-9-]{3,15}', 'g'))) {
			print('info', message_lang[0]+message_lang[3]);
			return;
		}
		
		// On envoit les infos
		send({action:'usergroup_rename',ajax:'1',group_id:current_group,group_name:new_name},'group_rename(json);');
		//send('?action=usergroup_rename&amp;ajax=1&amp;group_id='+current_group+'&amp;group_name='+new_name, 'group_rename(json);');
	}
}

function group_delete() {
	if (loading) return;
	
	// [AJAX]
	if (group_delete.arguments.length == 1) {
		text = group_delete.arguments[0];
		
		if (text == 'false') {
			print('info', message_lang[0]+message_lang[1]);
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
		
		hide('group_auth_block', 'group_members_block', 'group_mods_block', 'group_infos_block', 'del_group2');
		print('info', message_lang[8]);
		
		return;
	}
	
	if (current_group == 1) {
		print('info', message_lang[0]+message_lang[9]);
		return;
	}
	
	// On envoit la suppression du groupe
	send({action:'usergroup_delete',ajax:'1',group_id:current_group}, 'group_delete(json);');
}

function add_member() {
	if (loading) return;
	// [AJAX]
	if (add_member.arguments.length == 1) {
		text = add_member.arguments[0];
		if (text == 'false') {
			print('info', message_lang[0]+message_lang[1]);
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
		parse_members();
		parse_list();
		
		print('info', message_lang[10])
		
		return;
	}
	
	// On recupère l'ID du joueur a inserer et on envoit
	id = document.getElementById('user').options[document.getElementById('user').selectedIndex].value;
	send({action:'usergroup_newmember',ajax:'1',group_id:current_group,user_id:id}, 'add_member(json);');
}

function add_mod() {
	if (loading) return;

	// [AJAX]
	if (add_mod.arguments.length == 1) {
		text = add_mod.arguments[0];
		if (text == 'false') {
			print('info', message_lang[0]+message_lang[1]);
			return;
		}
		
		// On supprime alors le mod de la liste et on l'affiche dans les membres
		len = mod_id.length;
		for (i = 0; i < len; i ++) {
			if (mod_id[i] == text) {
				mods.push(text+','+mod_list[i]);
				break;
			}
		}
		
		// Si le groupe ne contient pas de joueurs, members[0] est vide, ca fait alors bugger le script
		// Donc on le supprime alors
		if (mods[0] == '') mods.splice(0,1);
		
		mods.sort();
		parse_mods();
		parse_list_mods();
		
		print('info', message_lang[11])
		
		return;
	}
	
	// On recupère l'ID du joueur a inserer et on envoit
	id = document.getElementById('module').options[document.getElementById('module').selectedIndex].value;
	send({action:'usergroup_newmod',ajax:'1',group_id:current_group,mod_id:id}, 'add_mod(json);');
	//send('?action=usergroup_newmod&amp;ajax=1&amp;group_id='+current_group+'&amp;mod_id='+id, 'add_mod(json);');
}

function del_member(id) {
	if (loading) return;
	// [AJAX]
	if (del_member.arguments.length == 2) {
		text = del_member.arguments[1];
		if (text == 'false') {
			print('info', message_lang[0]+message_lang[1]);
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
		
		parse_members();
		parse_list();
		
		print('info', message_lang[12]);
		
		return;
	}
	
	send({action:'usergroup_delmember',ajax:'1',group_id:current_group,user_id:id}, 'del_member(0, json);');
}

function del_mod(id) {
	if (loading) return;
	
	// [AJAX]
	if (del_mod.arguments.length == 2) {
		text = del_mod.arguments[1];
		if (text == 'false') {
			print('info', message_lang[0]+message_lang[1]);
			return;
		}
		
		// On supprime alors l'utilisateur du group et on le rajoute dans la liste
		len = mods.length;
		for (i = 0; i < len; i ++) {
			t = mods[i].split(new RegExp(',', 'g'));
			if (t[0] == text) {
				mods.splice(i, 1);
				break;
			}
		}
		
		parse_mods();
		parse_list_mods();
		
		print('info', message_lang[13])
		
		return;
	}
	if(id<0)
		send({action:'usergroup_delmod',ajax:'1',group_id:current_group,cat_id:'1',mod_id:id}, 'del_mod(0,json);');
		//send('?action=usergroup_delmod&amp;ajax=1&amp;group_id='+current_group+'&amp;cat_id=1&amp;mod_id='+id, 'del_mod(0, json);');
	else
		send({action:'usergroup_delmod',ajax:'1',group_id:current_group,mod_id:id}, 'del_mod(0,json);');
		//send('?action=usergroup_delmod&amp;ajax=1&amp;group_id='+current_group+'&amp;mod_id='+id, 'del_mod(0, json);');
}

function set_auth() {
	if (loading) return;
	
	// [AJAX]
	if (set_auth.arguments.length == 1) {
		text = set_auth.arguments[0];
		if (text == 'false') {
			print('info', message_lang[0]+message_lang[1]);
			return;
		}
		
		print('info', message_lang[14]);
		
		return;
	}
	
	// On crée l'url. Pour chaque champ contenu dans link[] on test si il est coché ou pas. puis on rajoute a la suite
	url = '?action=usergroup_setauth&'+'ajax=1&'+'group_id='+current_group;
	for (var i = 2, len = link.length; i < len; i++) {
		url += '&'+link[i]+'='+ (document.getElementById(link[i]).checked ? 1 : 0);
	}
	
	send (url, 'set_auth(json);');
}

function send(param_array,return_function) {
		new Ajax.Request('?',{
			method: 'get',
			parameters:	param_array,
			onCreate:   function(){
				loading = true;
				print('info','<'+'img src="images/ajax.gif" align="absmiddle" />&nbsp;' + message_lang[15]); 
			},
			onSuccess: function(transport){
				loading = false;
				var json = transport.responseText.evalJSON(true);
				print('info',message_lang[16]);
				
				if (Object.toJSON(json).include('SyntaxError:') == false)
				{
					eval(return_function);
				}
				else
				{
					alert(json);
				}
			},
			onFailure: function()
			{
				alert('Something went wrong...');
			}
		});
}
parse_groups();