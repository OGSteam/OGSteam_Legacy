// ==UserScript==
// @name         E-UniverS : Compil
// @namespace    E-UniverS Scripts
// @description	 Ce script est une compliation des scripts de Max485 & Jormund qui ne sont pas encore integré a UniFox
// @author       Max485
// @version 	 0.1_2009-06-20
// @include      *beta*e-univers.org/index.php*
// @exclude	     *googleads.g.doubleclick.net*
// @exclude	     *beta*.e-univers.org/modos/*
// ==/UserScript==

/*
	Je tient a remercier Jormund qui m'a donnés les solutions a mes problemes sur le script :) 
	Et aussi pour ces scripts et son extenstion UniFox
		
	Script officiellement ajouté a UniFox via le SVN de OGSteam le Sam 20 Juin 2009 par Max485
*/



/**************************************************************************************************************************\
|***************************************** FONCTIONS PAR Max485 ***********************************************************|
\**************************************************************************************************************************/





/*******************************************************************************************\
|********************************     MODICATIONS     **************************************|
\*******************************************************************************************/

ufLog('Debut du script de Max485');

	
function uf_Max485(document)
{
	var action = uf_getGET('action', document.location.href); // On recupere l'action de la page

	var options = eval( ufGetPref('E-UniverS_Compil_Options', '') ); // Recupere les options
	
	if (!ufGetPref('E-UniverS_Compil_Options', false) || typeof options == "undefined") // Dans le cas ou les options ne sont pas enregistrés
	{
		// Si les options ne sont pas configurer, ont attribue des options par default
		var array_options = { 
								"agrandir_page" : true, 
								"agrandir_page_entiere" : false, 
								"supprimer_colo" : true, 
								"afficher_ressources_en_vol" : true, 
								"suppr_colo_pass_auto" : true, 
								"messages_mettre_lien_sur_coords" : true, 
								'messages_ajouter_historique_dans_message' : true,
								"messages_ajouter_separateur_milier_dans_rapports_espionnage" : true, 
								"messages_envoyer_message_alli" : true, 
								'messages_colorer_message_flotte_amical' : true,
								"simu_afficher_renta_defenseur" : true,
								'changer_planete_avec_fleche_haut_et_bas' : false,
								'envoyer_formulaire_via_touche_enterInConverto' : false,
								'envoyer_formulaire_via_touche_enterInFlotte' : false,
								'stats_changer_centaine_avec_fleches_gauche_droite' : false,
								'alliance_liste_members_rendre_les_coords_cliquable' : true,
								'simu_formater_rapport_de_combat' : true,
								'chantier_agrandir_zones_saisi' : true,
								'flotte_agrandir_zones_saisi' : true,
								'simu_agrandir_zones_saisi' : true,
								'messages_afficher_lien_sur_RC_pour_formater' : true,
								'afficher_pourcentage_points' : true,
							};

		ufSetCharPref('E-UniverS_Compil_Options', uneval(array_options) );
	}
	else if( document.location.href.match(/index\.php/) )// Lorsque les options sont bien enregistrés, et qu'on est sur le fichier index
	{		
		if(options['changer_planete_avec_fleche_haut_et_bas'] == true) // Dans le cas ou l'options pour changer de planete avec les touches haut et bas est activé
		{
			ufLog('ufM - Debut Execution => MENU_changer_planete_avec_fleche_haut_et_bas');
			MENU_changer_planete_avec_fleche_haut_et_bas(document);
			ufLog('ufM - Fin Execution => MENU_changer_planete_avec_fleche_haut_et_bas');
		}
				
		if(action == 'accueil' || !action) // Lorsque on est sur la page d'accueil
		{
			if(options['agrandir_page'] == true) // Si l'options pour agrandir la page est sur OUI
			{
				if(options['agrandir_page_entiere'] == true) // Dans ce cas on agrandi la page complete
				{
					ufLog('ufM - Debut Execution => ACCUEIL_agrandir_page_tous');
					ACCUEIL_agrandir_page_tous(document);
					ufLog('ufM - Fin Execution => ACCUEIL_agrandir_page_tous');
				}
				else if(options['agrandir_page_entiere'] == false)// Dans ce cas on aggrandi uniquement la partie evenement
				{
					ufLog('ufM - Debut Execution => ACCUEIL_agrandir_page_uniquement_evenement');
					ACCUEIL_agrandir_page_uniquement_evenement(document);
					ufLog('ufM - Fin Execution => ACCUEIL_agrandir_page_uniquement_evenement');
				}
			}
			
			if(options['supprimer_colo'] == true) // Si le joueur veut supprimer la liste des colos en image qui s'affiche en bas de la page
			{
				ufLog('ufM - Debut Execution => ACCUEIL_supprimer_colo');
				ACCUEIL_supprimer_colo(document);
				ufLog('ufM - Fin Execution => ACCUEIL_supprimer_colo');
			}
			
			if(options['afficher_ressources_en_vol'] == true)
			{
				ufLog('ufM - Debut Execution => ACCUEIL_afficher_ressources_en_vol');
				ACCUEIL_afficher_ressources_en_vol(document);
				ufLog('ufM - Fin Execution => ACCUEIL_afficher_ressources_en_vol');
			}		
			
			if(options['afficher_pourcentage_points'] == true)
			{
				ufLog('ufM - Debut Execution => ACCUEIL_afficher_pourcentage_points');
				ACCUEIL_afficher_pourcentage_points(document);
				ufLog('ufM - Fin Execution => ACCUEIL_afficher_pourcentage_points');
			}
		}
		else if(action == 'alliance' && uf_getGET('subaction', document.location.href) == 'listeMembres' && options['alliance_liste_members_rendre_les_coords_cliquable'] == true)
		{
			ufLog('ufM - Debut Execution => ALLIANCE_LISTE_MEMBERS_rendre_les_coords_cliquable');
			ALLIANCE_LISTE_MEMBERS_rendre_les_coords_cliquable(document);
			ufLog('ufM - Fin Execution => ALLIANCE_LISTE_MEMBERS_rendre_les_coords_cliquable');
		}
		else if(action == 'chantier' && options['chantier_agrandir_zones_saisi'] == true) // Si on est dans le Chantier (Flottes OU Defs)
		{
			ufLog('ufM - Debut Execution => CHANTIER_agrandir_zones_saisi');
			CHANTIER_agrandir_zones_saisi(document);
			ufLog('ufM - Fin Execution => CHANTIER_agrandir_zones_saisi');
		}
		else if(action == 'convert' && options['envoyer_formulaire_via_touche_enterInConverto'] == true)
		{
			ufLog('ufM - Debut Execution => CONVERTO_envoyer_formulaire_via_touche_enter');
			CONVERTO_envoyer_formulaire_via_touche_enter(document);
			ufLog('ufM - Fin Execution => CONVERTO_envoyer_formulaire_via_touche_enter');
		}
		else if(action == 'ecriremessages' && options['messages_ajouter_historique_dans_message'] == true) // Dans le cas ou on est sur la page pour ecrire un message et qu'on veulent mettre l'historique dans les messages
		{
			ufLog('ufM - Debut Execution => MESSAGES_ajouter_historique_dans_message');
			MESSAGES_ajouter_historique_dans_message(document);
			ufLog('ufM - Fin Execution => MESSAGES_ajouter_historique_dans_message');
		}
		else if( (action == 'flotte' || action == 'flotte2' || action == 'flotte4') ) // Si on est sur flotte2 (Là ou on saisi les ressources, coord, ...)
		{
			if(options['envoyer_formulaire_via_touche_enterInFlotte'] == true) // Dans le cas ou on veut valider les form en pressant entrée dans la page
			{
				ufLog('ufM - Debut Execution => FLOTTES_envoyer_formulaire_via_touche_enter');
				FLOTTES_envoyer_formulaire_via_touche_enter(document);
				ufLog('ufM - Fin Execution => FLOTTES_envoyer_formulaire_via_touche_enter');
			}
			
			if( ( action == 'flotte' || action == 'flotte2' ) && options['flotte_agrandir_zones_saisi'] == true) // Si on veut agrandir les zones de saisi des flottes
			{
				ufLog('ufM - Debut Execution => FLOTTES_agrandir_zones_saisi');
				FLOTTES_agrandir_zones_saisi(document, action);
				ufLog('ufM - Fin Execution => FLOTTES_agrandir_zones_saisi');
			}
		}
		else if(action == 'overview') // Si on est sur la Vue Globale
		{
		
			ufLog('ufM - Debut Execution => VUEGLOBAL_afficher_BBCode_avec_empire_formater_pour_forum');
			VUEGLOBAL_afficher_BBCode_avec_empire_formater_pour_forum(document);
			ufLog('ufM - Fin Execution => VUEGLOBAL_afficher_BBCode_avec_empire_formater_pour_forum');
			
			if( options['ajouter_somme_all_planetes'] == true )
			{
				ufLog('ufM - Debut Execution => VUEGLOBAL_ajouter_somme_all_planetes');
				VUEGLOBAL_ajouter_somme_all_planetes(document); // Permet de faire la somme des ressources de toutes les planetes sur la Vue Globale
				ufLog('ufM - Fin Execution => VUEGLOBAL_ajouter_somme_all_planetes');
			}
		}
		else if(action == 'messages') // Si on est sur la page des messages
		{
			if(options['messages_mettre_lien_sur_coords'] == true) // Dans ce cas, on veut tranformer les coordonnées en lien cliquable
			{
				ufLog('ufM - Debut Execution => MESSAGES_mettre_un_lien_sur_les_coords');
				MESSAGES_mettre_un_lien_sur_les_coords(document);
				ufLog('ufM - Fin Execution => MESSAGES_mettre_un_lien_sur_les_coords');
			}
			
			if(options['messages_ajouter_separateur_milier_dans_rapports_espionnage'] == true)
			{
				ufLog('ufM - Debut Execution => MESSAGES_ajouter_separateur_milier_dans_rapports_espionnage');
				MESSAGES_ajouter_separateur_milier_dans_rapports_espionnage(document);
				ufLog('ufM - Fin Execution => MESSAGES_ajouter_separateur_milier_dans_rapports_espionnage');
			}
			
			if(options['messages_envoyer_message_alli'] == true)
			{
				ufLog('ufM - Debut Execution => MESSAGES_afficher_form_pour_envoye_message_alli_et_lien_sur_chaque_messages_alli');
				MESSAGES_afficher_form_pour_envoye_message_alli_et_lien_sur_chaque_messages_alli(document);
				ufLog('ufM - Fin Execution => MESSAGES_afficher_form_pour_envoye_message_alli_et_lien_sur_chaque_messages_alli');
			}
			
			if(options['messages_ajouter_historique_dans_message'] == true)
			{
				ufLog('ufM - Debut Execution => MESSAGES_modifier_lien_ajouter_historique');
				MESSAGES_modifier_lien_ajouter_historique(document);
				ufLog('ufM - Fin Execution => MESSAGES_modifier_lien_ajouter_historique');
			}
			
			if(options['messages_colorer_message_flotte_amical'] == true)
			{			
				ufLog('ufM - Debut Execution => MESSAGES_colorer_message_flotte_amical');
				MESSAGES_colorer_message_flotte_amical(document);
				ufLog('ufM - Fin Execution => MESSAGES_colorer_message_flotte_amical');
			}
			
			if(ufGetPref('ufLogin', null) == 'Max485') // Fonction privé ...
			{
				MESSAGES_colorer_message_rapport_espionnage_VE_si_il_y_en_a_de_present(document)
			}
		}
		else if(action == 'renommer' && options['suppr_colo_pass_auto'] == true)
		{
			ufLog('ufM - Debut Execution => RENOMMER_pass_deja_ecrit_pour_supprimer_colo');
			RENOMMER_pass_deja_ecrit_pour_supprimer_colo(document);
			ufLog('ufM - Fin Execution => RENOMMER_pass_deja_ecrit_pour_supprimer_colo');
		}
		else if(action == 'optionsGM') // Lorsqu'on entre dans les configurations du script
		{
			ufLog('ufM - Debut Execution => OPTIONSGM_creer_pages');
			OPTIONSGM_creer_pages(document);
			ufLog('ufM - Fin Execution => OPTIONSGM_creer_pages');
		}
		else if(action == 'simu') // Si on est dans le simulateur
		{
			if(options['simu_afficher_renta_defenseur'] == true) // Si on veut afficher la renta du defenseur
			{
				ufLog('ufM - Debut Execution => SIMU_afficher_renta_defenseur');
				SIMU_afficher_renta_defenseur(document); // Pour afficher la renta du defenseur dans le simulateur
				ufLog('ufM - Fin Execution => SIMU_afficher_renta_defenseur');
			}
			
			if(options['simu_formater_rapport_de_combat'] == true) // Si on veut afficher un rapport de combat formaté en BBCode
			{
				ufLog('ufM - Debut Execution => uf_addJavaScript - ufM_simuConverter');
				// On appelle le fichier JS qui contient le script (Etant un script GM a l'origine et contenant trop de fonctions, il est plus simple de silmplement l'appeller
				uf_addJavaScript(document, 'chrome://unifox/content/ufM_simuConverter.js');
				ufLog('ufM - Fin Execution => uf_addJavaScript - ufM_simuConverter');
			}
			
			if(options['simu_agrandir_zones_saisi'] == true) // Si on veut agrandir les zones de saisis
			{
				ufLog('ufM - Debut Execution => SIMU_agrandir_zones_saisi');
				SIMU_agrandir_zones_saisi(document, options);
				ufLog('ufM - Fin Execution => SIMU_agrandir_zones_saisi');
			}
		}
		else if(action == 'stats' && options['stats_changer_centaine_avec_fleches_gauche_droite'])
		{
			ufLog('ufM - Debut Execution => STATS_changer_centaine_avec_fleches_gauche_droite');
			STATS_changer_centaine_avec_fleches_gauche_droite(document); // Permet de changer de centaines dans les stats avec les touche Left et Right
			ufLog('ufM - Fin Execution => STATS_changer_centaine_avec_fleches_gauche_droite');
			}
		// Dans le cas ou l'action n'est pas traité par le script, alors on effectue rien du tous
	}
	else if(document.location.href.match(/popup\.php/) ) // Dans le cas ou on est dans popup.php
	{
		if(action == 'message' && uf_getGET('id', document.location.href).match(/\d+/) && options['messages_afficher_lien_sur_RC_pour_formater'] == true) // Si on desire mettre un lien dans les RC pour pouvoir l'envoyer facilement dans le formateur de Jormund http://jormund.free.fr/e-univers/converter.html
		{
			ufLog('ufM - Debut Execution => MESSAGE_messages_afficher_lien_sur_RC_pour_formater');
			MESSAGE_messages_afficher_lien_sur_RC_pour_formater(document);
			ufLog('ufM - Fin Execution => MESSAGE_messages_afficher_lien_sur_RC_pour_formater');
		}
	}
}





/*******************************************************************************************\
|*********************************     FONCTIONS     ***************************************|
\*******************************************************************************************/

function ACCUEIL_afficher_pourcentage_points(document)
{
	var classement = ufEval("id('divpage')/center/table[3]/tbody/tr[1]/th[2]/table/tbody/tr", document);

	var points = new Array();

	for(var i=8;  i <= 12; i++) // On passe dans la boucle pour chaque tr correspondant au classement
	{
		// On recupere les points de chaque categorie
		/* Ancienne regex, ne marchant que si le joueur a entre 1M et 999M de points
			var p_temp = (/(\d+)&nbsp;(\d+)&nbsp;(\d+)/).exec(classement.snapshotItem(i).getElementsByTagName('th')[2].innerHTML);
			Nouvelle regex, créer le Mercredi 22 Juillet 2009, a la suite :
		*/
		var p_temp_regex = (/([\d|&nbsp;]+)/).exec(classement.snapshotItem(i).getElementsByTagName('th')[2].innerHTML);
		var p_temp = p_temp_regex[1].replace(/&nbsp;/g, ''); // Supprime les &nbsp; du code (Qui sont utilisé par le moteur PHP pour créer les espaces) en les remplacant par "du vide"
		points[i] = parseFloat(p_temp); // On change la valeur de type Chaine, en Nombre
	}

	// On transforme en %
	var points2 = new Array (
						( ( points[9] + points[10] ) / points[8] * 100 ), // On recupere le % de points fixe
						( points[9] / points[8] * 100 ), // Le % de points bat
						( points[10] / points[8] * 100 ), // Le % de points rech
						( points[11] / points[8] * 100 ), // Le % de points flotte
						( points[12] / points[8] * 100 ) // Le % de points def 
							);
	
	var nb = 0;

	for(var i=8; i <= 12; i++) // On passe dans chaque tr du classement
	{
		// Et on affiche les pourcent quand on passe le curseur sur le nom de la categorie qui correspond
		classement.snapshotItem(i).getElementsByTagName('th')[0].getElementsByTagName('a')[0].setAttribute('title', ( i==8 ? 'Fixe : ' : 'Pourcentage : ') + parseInt(points2[nb]) + ' %');
		
		nb++;
	}
}

function ACCUEIL_agrandir_page_tous(document) // Permet d'agrandir entierement la page Vue Générale
{
	var divpage = document.getElementById('divpage');
	var tables = divpage.getElementsByTagName('table');
	tables[0].setAttribute('width', '100%');
	tables[1].setAttribute('width', '100%');
	tables[2].setAttribute('width', '100%');
	tables[3].setAttribute('width', '100%');
}

function ACCUEIL_agrandir_page_uniquement_evenement(document) // Permet sur la vue Generale, d'agrandir uniquement la partie Evenement
{
	// Lorsque une annonce est mise sur la vue generale, cela créer une table supplementaire, ce qui perturbe le numero des tables
	var table_evenement = ufEval("id('divpage')/center/table[1]", document).snapshotItem(0);

	if( !table_evenement.innerHTML.match(/Evènements/) ) // On verifie si dans la table 2 on voit "Evènements"
	{
		// Dans le cas ou on ne voit pas evenement sur la table 2, alors on utilse la table 1
		var table_evenement = ufEval("id('divpage')/center/table[2]", document).snapshotItem(0);
	}

	table_evenement.setAttribute('width', '100%'); // On agrandi la page au maximum de la taille possible
}

function ACCUEIL_supprimer_colo(document) // Supprime l'affichage des colos en bas de la Vue Generale
{
	// On recupere et on efface le texte "Planètes colonisées" qui devient inutile
	var texte_planetes_colos = ufEval("id('divpage')/center/table[3]/tbody/tr[4]", document);
	texte_planetes_colos.snapshotItem(0).innerHTML = '';
	
	// On recupere la table contenant les planetes, elle contien aussi de la pub
	var table_colo = ufEval("id('divpage')/center/table[4]/tbody/tr/td[1]", document);
	
	//var script_pub = table_colo.snapshotItem(0).getElementsByTagName('div')[0]; // On recupere le premier <div> qui contient les pub du jeu
	
	//table_colo.snapshotItem(0).innerHTML = '<center>' + script_pub.innerHTML + '</center>'; // On affiche les pub du jeu sans les planetes	
	table_colo.snapshotItem(0).innerHTML = '';
}

function ACCUEIL_afficher_ressources_en_vol(document) // Fait la somme des ressources en vol et l'affiche
{
	// ==UserScript==
	// @name           flyingResSum
	// @namespace      e-univers
	// @include        http://*.e-univers.org/index.php?action=accueil*
	// @include        http://*.projet42.org/index.php?action=accueil*
	// @version 	0.4.07052009
	// @author		MonkeyIsBack
	// @author		Jormund
	// @author		Magius
	// @author		Max485
	// ==/UserScript==

	var links = ufEval("id('divpage')/center/table[2]/tbody/tr/th[1]/span/a[6]",document);//avec UniFox
	if(links.snapshotLength==0) links = ufEval("id('divpage')/center/table[2]/tbody/tr/th[1]/span/a[4]",document);//sans UniFox

	var links_dest=ufEval("id('divpage')/center/table[2]/tbody/tr/th[1]/span/a[4]",document);//avec UniFox
	var links_mission=ufEval("id('divpage')/center/table[2]/tbody/tr/th[1]/span/a[1]",document);//avec UniFox

	var total = [0,0,0];
	var allRes = [];
	var allDest = [];
	var allMission = [];
	var marqueur_flight = [];

	//lecture des ressources
	for(var i=0;i<links.snapshotLength;i++)
	{
		var link = links.snapshotItem(i);
		var title = link.getAttribute('title');
		var resTemp = title.match(/[0-9]+/g);
		var inList = false;
		
		var link_dest = links_dest.snapshotItem(i);
		var dest = link_dest.getAttribute('href');
		var coord = dest.match(/[0-9]+/g);
		var inDest = false;
		
		var link_mission = links_mission.snapshotItem(i);
		var mission = link_mission.getAttribute('class');
			
		switch (mission)
		{
			case 'return owntransport':
				for(var k=0;k<allMission.length;k++)
				{
					if (marqueur_flight[k]==true && (allMission[k]=='flight owntransport'||allMission[k]=='transport') && allDest[k][0]==coord[0] && allDest[k][1]==coord[1] && allRes[k][0]==resTemp[0] && allRes[k][1]==resTemp[1] && allRes[k][2]==resTemp[2])
					{
						marqueur_flight[k] = false;
						inList = true;
						break;
					}
				}
				if(!inList)
				{
					allRes.push(resTemp);
					allDest.push(coord);
					allMission.push(mission);
					marqueur_flight.push(false);
				}
			break;
				
			case 'return owndeploy':
				for(var k=0;k<allMission.length;k++)
				{
					if (marqueur_flight[k]==true && allMission[k]=='flight owndeploy' && allDest[k][0]==coord[0] && allDest[k][1]==coord[1] && allRes[k][0]==resTemp[0] && allRes[k][1]==resTemp[1] && allRes[k][2]==resTemp[2])
					{
						marqueur_flight[k] = false;
						inList = true;
						break;
					}
				}
				if(!inList)
				{
					allRes.push(resTemp);
					allDest.push(coord);
					allMission.push(mission);
					marqueur_flight.push(false);
				}
			break;
				
			case 'return owncolony':
				for(var k=0;k<allMission.length;k++)
				{
					if (marqueur_flight[k]==true && allMission[k]=='flight owncolony' && allDest[k][0]==coord[0] && allDest[k][1]==coord[1] && allRes[k][0]==resTemp[0] && allRes[k][1]==resTemp[1] && allRes[k][2]==resTemp[2])
					{
						marqueur_flight[k] = false;
						inList = true;
						break;
					}
				}
				if(!inList)
				{
					allRes.push(resTemp);
					allDest.push(coord);
					allMission.push(mission);
					marqueur_flight.push(false);
				}
			break;
				
			case 'return ownharvest':
				for(var k=0;k<allMission.length;k++)
				{
					if (marqueur_flight[k]==true && allMission[k]=='flight ownharvest' && allDest[k][0]==coord[0] && allDest[k][1]==coord[1] && allRes[k][0]==resTemp[0] && allRes[k][1]==resTemp[1] && allRes[k][2]==resTemp[2])
					{
						marqueur_flight[k] = false;
						inList = true;
						break;
					}
				}
				if(!inList)
				{
					allRes.push(resTemp);
					allDest.push(coord);
					allMission.push(mission);
					marqueur_flight.push(false);
				}
			break;
				
			default :
				allRes.push(resTemp);
				allDest.push(coord);
				allMission.push(mission);
				if (mission.substr(0,6) == 'flight' || mission == 'transport')
					marqueur_flight.push(true);
				else
					marqueur_flight.push(false);
			break;
		}
	}
	//tri
	for(var i=0;i<allRes.length;i++)
	{
		var resTemp = allRes[i];
		for(var j = 0; j<3;j++)
		{
			total[j]+=parseInt(resTemp[j]);
		}
	}

	//écriture du résultat

	var tables=ufEval("id('divpage')/center/table[2]/tbody/tr/td",document);
	var table=tables.snapshotItem(0);

	var line = document.createElement('span');
	var cell = document.createElement('span');

	cell.innerHTML += ' - Ressources en vol : '+
		'<a title="'+uf_addFormat(total[0])+' Titane" >'+formatNumber(total[0])+'</a> / '+
		'<a title="'+uf_addFormat(total[1])+' Carbone" >'+formatNumber(total[1])+'</a> / '+
		'<a title="'+uf_addFormat(total[2])+' Tritium" >'+formatNumber(total[2])+'</a>';
		
	table.appendChild(line);
	line.appendChild(cell);


	//alert(cell.innerHTML);
		
}

function ALLIANCE_LISTE_MEMBERS_rendre_les_coords_cliquable(document) // Ajouter un lien vers la Galaxie sur les coordonnées dans la liste des joueurs de l'alliance
{
	var cells = ufEval("id('divpage')/table/tbody/tr/th[3]", document);

	var reg = /\[(\d*):(\d*):(\d*)\]/gi;
	for(var i=1; i < cells.snapshotLength; i++)
	{

		var cell=cells.snapshotItem(i);
		
		if(cell)
		{
			if(cell.innerHTML)
			{
				cell.innerHTML = cell.innerHTML.replace(reg,"<a href=\"?action=galaxie&galaxiec=$1&systemec=$2\">[$1:$2:$3]</a>");
			}
		}
	}
}

function CHANTIER_agrandir_zones_saisi(document)
{
	var subaction = uf_getGET('subaction', document.location.href);
	
	if(subaction == 'flotte' ) // Si on est sur la page des flottes
	{
		for(var i=1;i<=14;i++)
		{
			var inp=document.getElementsByName('idc_'+i);
			if(inp[0])
			{
				inp[0].setAttribute('maxlength','10');
				inp[0].setAttribute('size','12');
			}
		}
	}
	else if(subaction == 'def') // Si on est sur la page des def
	{

		for(var i=100;i<=110;i++)
		{
			var inp=document.getElementsByName('idc_'+i);
			if(inp[0])
			{
				inp[0].setAttribute('maxlength','10');
				inp[0].setAttribute('size','12');
			}
		}
	}
}

function CONVERTO_envoyer_formulaire_via_touche_enter(document)
{
	document.addEventListener('keydown',ufM_submitFleetOnFlotteorConvertoViaEnter,false);
}

function FLOTTES_agrandir_zones_saisi(document, action)
{
	if(action == 'flotte') // Si on est sur Flotte
	{
		for(var i=1;i<=14;i++)
		{
			var inp=document.getElementsByName('vaisseau'+i);
			if(inp[0])
			{
				inp[0].setAttribute('size','13');
			}
		}
	}
	else if(action == 'flotte2') // Si on est sur Flotte2
	{
		for(var i=1;i<=3;i++)
		{
			var inp=document.getElementsByName('ressource'+i+'_aff');
			if(inp[0])
			{
				inp[0].setAttribute('size','20');
			}
		}
	}
}

function FLOTTES_envoyer_formulaire_via_touche_enter(document)
{
	document.addEventListener('keydown',ufM_submitFleetOnFlotteorConvertoViaEnter,false);
}

function MENU_changer_planete_avec_fleche_haut_et_bas(document)
{
	if(
		!document.location.href.match(/action=galaxie/) // Si on est pas sur la galaxie
		&& !document.location.href.match(/action=flotte2/) // Ni sur la page d'envoye de flotte 2
		&& !document.location.href.match(/action=ecriremessages/) // Ni sur la page pour envoyer des messages
		&& !document.location.href.match(/action=alliance/) // Ni sur la page d'alliance
	)
	{
		 document.addEventListener('keydown', ufM_changerPlanetesViaUpOrDown, false);
	}
}

function MESSAGE_messages_afficher_lien_sur_RC_pour_formater(document) // Permet lors de l'affichage de RC, de l'envoyer dans le formateur de Jormund http://jormund.free.fr/e-univers/converter.html
{
	var c=document.createElement('center');
	c.innerHTML='<a href="http://jormund.free.fr/e-univers/converter.html" onclick="return false;">Convertisseur de RC</a>';
	document.body.insertBefore(c,document.body.firstChild);
	c.addEventListener('click',ufM_message_RC_sendToConverterBBCode,false);
	c=document.createElement('center');
	c.innerHTML='<a href="http://jormund.free.fr/e-univers/converter.html" onclick="return false;">Convertisseur de RC</a>';
	document.body.appendChild(c);
	c.addEventListener('click',ufM_message_RC_sendToConverterBBCode,false);
}

function MESSAGES_afficher_form_pour_envoye_message_alli_et_lien_sur_chaque_messages_alli(document) // Permet d'envoyer des messages a l'alliance plus simplement, soit avec le form qui apparait en haut de la page message lorsque clique sur le lien pour l'afficher, soit en utilisant le bouton repondre qui s'affiche dans chaque messages envoyer par un membre de l'alliance
{
	/*
		Fonction créer par Jormund
	*/
	
	var form = ufEval("id('divpage')/form[1]",document);
	
	if(form.snapshotLength > 0)
	{
		try
		{
			//alert(i);
			form = form.snapshotItem(0);
			var div = form.parentNode;
			var newform = document.createElement('form');
			newform.setAttribute('action', '?action=alliance&subaction=envoimessage');
			newform.setAttribute('method', 'post');
			newform.innerHTML=
				    '<a name="allymessage" style="cursor : pointer;" onclick="toggledisplay(\'allymessage\')" >Message pour l\'alliance</a>'+
					'<table name="allymessage" style="display:none;">' +
						'<tr>'+
							'<td class="c" colspan="2"><a style="cursor : pointer;" onclick="toggledisplay(\'allymessage\')">Message pour l\'alliance</a></td>'+
						'</tr>'+
						'<tr>'+
							'<th>Objet</th>'+
							'<th><input name="objet" size="30" maxlength="40" type="text"></th>'+
						'</tr>'+
						'<tr>'+
							'<th colspan="2"><textarea name="msg" cols="100" rows="4" size="100" maxlength="2000" id="message"></textarea></th>'+
						'</tr>'+
						'<tr>'+
							'		<th colspan="2" >'+
							'		<a href="javascript: smiley(\' :mellow:\');"><img src="img/emoticons/mellow.gif"></a>'+
							'			<a href="javascript: smiley(\' :huh:\');"><img src="img/emoticons/huh.gif"></a>'+
							'			<a href="javascript: smiley(\' ^_^\');"><img src="img/emoticons/happy.gif"></a>'+
							'			<a href="javascript: smiley(\' :o\');"><img src="img/emoticons/ohmy.gif"></a>'+

							'			<a href="javascript: smiley(\' ;)\');"><img src="img/emoticons/wink.gif"></a>'+
							'			<a href="javascript: smiley(\' :P\');"><img src="img/emoticons/tongue.gif"></a>'+
							'			<a href="javascript: smiley(\' :D\');"><img src="img/emoticons/biggrin.gif"></a>'+
							'			<a href="javascript: smiley(\' :lol:\');"><img src="img/emoticons/laugh.gif"></a>'+
							'			<a href="javascript: smiley(\' B)\');"><img src="img/emoticons/cool.gif"></a>'+
							'			<a href="javascript: smiley(\' :rolleyes:\');"><img src="img/emoticons/rolleyes.gif"></a>'+
							'			<a href="javascript: smiley(\' -_-\');"><img src="img/emoticons/sleep.gif"></a>'+
							'			<a href="javascript: smiley(\' :)\');"><img src="img/emoticons/smile.gif"></a>'+
							'			<a href="javascript: smiley(\' :wub:\');"><img src="img/emoticons/wub.gif"></a>'+

							'			<a href="javascript: smiley(\' <_< \');"><img src="img/emoticons/dry.gif"></a>'+
							'			<a href="javascript: smiley(\' :angry:\');"><img src="img/emoticons/angry.gif"></a>'+
							'			<a href="javascript: smiley(\' :( \');"><img src="img/emoticons/sad.gif"></a>'+
							'			<a href="javascript: smiley(\' :unsure:\');"><img src="img/emoticons/unsure.gif"></a>'+
							'			<a href="javascript: smiley(\' :wacko:\');"><img src="img/emoticons/wacko.gif"></a>'+
							'			<a href="javascript: smiley(\' :blink:\');"><img src="img/emoticons/blink.gif"></a>'+
							'			<a href="javascript: smiley(\' :ph34r:\');"><img src="img/emoticons/ph34r.gif"></a>'+
							'			<a href="javascript: smiley(\' :blush:\');"><img src="img/emoticons/blush.gif"></a>'+
							'			<a href="javascript: smiley(\' :excl:\');"><img src="img/emoticons/excl.gif"></a>'+

							'			<a href="javascript: smiley(\' :mad:\');"><img src="img/emoticons/mad.gif"></a>'+
						'</th></tr>'+
						'<tr>'+
							'<th colspan="2"><input value="Envoyer" type="submit"></th>'+
						'	</tr>'+
					'	</table>';
					
			div.insertBefore(newform,form);
			var script = document.createElement('script');
			script.setAttribute('type',"text/javascript");
			script.innerHTML='function smiley(code)'+
							'{'+
								'document.getElementById(\'message\').value = document.getElementById(\'message\').value + code;'+
							'}'+
							'function toggledisplay(name)'+
							'{'+
								'var elems=document.getElementsByName(name);'+
								//'alert(elems.length);'+
								'for(var i=0;i<elems.length;i++)'+
								'{'+
									//'alert(elems[i].style.display);'+
									'if(typeof(elems[i].style.display)=="undefined")elems[i].style.display="none";'+
									'else if(elems[i].style.display !="none")elems[i].style.display="none";'+
									'else {;elems[i].style.display="block";}'+
								'}'+
							'}';
							
			div.appendChild(script);
			
			div.innerHTML+='';
			//alert(table.innerHTML);
		}
		
		catch(e)
		{
			alert(e)
		}
	}
	
	var pics = ufEval("id('divpage')/form[3]/table/tbody/tr/td[2]/a/img",document);
	
	for(var i=0;i<pics.snapshotLength;i++)
	{
		var img=pics.snapshotItem(i);
		var cell=img.parentNode.parentNode;
		
		if(cell.innerHTML.indexOf('(alliance)') >- 1)
		{
			cell.innerHTML+="<a href='?action=alliance&subaction=messagealliance'><img alt='Envoyer un message ï¿½ l\'alliance' src='http://www.project2501.org/skins/skin_bleu/img/m.gif' ";
		}
	}
	
	
	/*'function togglevisibility(name)'+
		'{'+
		'var elems=document.getElementsByName(name);'+
		//'alert(elems.length);'+
		'for(var i=0;i<elems.length;i++)'+
			'{'+
			//'alert(elems[i].style.visibility);'+
			'if(typeof(elems[i].style.visibility)=="undefined")elems[i].style.visibility="hidden";'+
			'else if(elems[i].style.visibility !="hidden")elems[i].style.visibility="hidden";'+
			'else {;elems[i].style.visibility="visible";}'+
			'}'+
		'}'+	
	*/
	
}

function MESSAGES_modifier_lien_ajouter_historique(document) // Permet d'ajouter l'historique a l'URL des messages de joueurs, ou d'alliance
{
	var objetLien = ufEval("id('divpage')/form[3]/table/tbody/tr/td[2]/a", document); // Recupere tous les messages qui ont un URL dedans (Messages de joueurs, ou d'alliance)
	if(objetLien.snapshotLength == 0)
		var objetLien = ufEval("id('divpage')/form[2]/table/tbody/tr/td[2]/a", document);
	for(var i=0; i < objetLien.snapshotLength; i++) // Passe la boucle pour tous les messages trouvé
	{
		var lien = objetLien.snapshotItem(i); // Recupere les infos sur la balise de l'URL
		
		var lienHref = lien.href; // Recupere l'URL
		
		var msg = lien.parentNode.parentNode.nextSibling.getElementsByTagName('th')[0].innerHTML; // Recupere le message sur le tr suivant (parentNode permet de remonter les elements au dessus, jusqu'a etre dans le tr, et nextSibling permet de changer de tr

		// Remplace les ( et les ) par un "truc encoder" car sinon elle plante le script PHP du jeu
		msg =  msg.replace(/\(/g, '%sdzbkf'); 
		msg =  msg.replace(/\)/g, '%sdzbkg'); 
		msg = msg.replace(/=/g, '%fraufhzreu'); // On remplace les = aussi
		msg = msg.replace(/&/g, '%tzrezrrer'); // On remplace aussi les & car sinon il termine le $_GET['historique']
		msg = msg.replace(/#/g, '%fefefeqfqd');
		
		/*lienHref += '&historique='+encodeURI(msg); // On encore le message pour qu'il puisse etre envoyé par URL
		
		lien.setAttribute('href', encodeURI(lienHref)); // On change le lien (En le ré-encodant encore une fois, sinon ca deconne)*/
		var histo = encodeURI(encodeURI(msg)).substring(0,500);
		
		lienHref += '&historique='+histo;
		lien.setAttribute('href', lienHref);
	}
}

function MESSAGES_ajouter_historique_dans_message(document) // Permet d'ecrire l'historique dans le message
{
	var getHistorique = uf_getGET('historique', document.location.href); // Recupere l'historique du message
	
	if(getHistorique) // On effectue l'action que si un historique existe (Ce qui est simplement dans le cas d'une reponse a un message)
	{
		var formTextarea = document.getElementById('message'); // Recupere le textarea qui contient le message
		
		var msgQuote = decodeURI (decodeURI ( getHistorique ) ); // Decode l'URL (On effectue le decode deux fois, puisque on la encoder deux fois)

		// Remplace les ( et les ) par un "truc decoder" apres qu'elle est été transmise par un "truc encoder"
		msgQuote =  msgQuote.replace(/%sdzbkf/g, '('); 
		msgQuote =  msgQuote.replace(/%sdzbkg/g, ')'); 
		msgQuote = msgQuote.replace(/%fraufhzreu/g, '='); 
		msgQuote = msgQuote.replace(/%tzrezrrer/g, '&');
		msgQuote = msgQuote.replace(/%fefefeqfqd/g, '#');
		
		msgQuote = msgQuote.replace(/<br>/g, ''); // On remplace tous les <br> par du vide pour ne pas les afficher
		
		// On remplace chaque balise img des emoticones par les symboles des emoticones
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/mellow.gif">/g, ':mellow:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/huh.gif">/g, ' :huh:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/happy.gif">/g, '^_^');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/ohmy.gif">/g, ':o');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/wink.gif">/g, ';)');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/tongue.gif">/g, ':P');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/biggrin.gif">/g, ':D');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/laugh.gif">/g, ':lol:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/cool.gif">/g, 'B)');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/rolleyes.gif">/g, ':rolleyes:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/sleep.gif">/g, '-_-');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/smile.gif">/g, ':)');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/wub.gif">/g, ':wub:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/dry.gif">/g, '<_<');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/angry.gif">/g, ':angry:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/sad.gif">/g, ':(');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/unsure.gif">/g, ':unsure:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/wacko.gif">/g, ':wacko:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/blink.gif">/g, ':blink:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/ph34r.gif">/g, ':ph34r:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/blush.gif">/g, ':blush:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/excl.gif">/g, ':excl:');
		msgQuote = msgQuote.replace(/<img src="img\/emoticons\/mad.gif">/g, ':mad:');
		
		// On supprime les span du code
		msgQuote =  msgQuote.replace(/<span style=".+">/g, ''); 
		msgQuote =  msgQuote.replace(/<\/span>/g, ''); 

		// On ecrit le message dans le textarea
		formTextarea.innerHTML = 'Reponse \u00E0 : \n\n' + msgQuote + '\n\n======================================================\n\n';
	}
}

function MESSAGES_ajouter_separateur_milier_dans_rapports_espionnage(document) // Ajoute des espaces dans les rapports d'espionnages
{
	/*
		Créer par Jormund
	*/
	
	SEPARATOR = ' '; // Defini que le separateur est un espace
	
	var inputs = ufEval("id('divpage')/form/table/tbody/tr/th/table/tbody/tr/td[2]", document);
	for(var i=0; i < inputs.snapshotLength; i++)
	{
		try
		{
			//alert(i);
			var input = inputs.snapshotItem(i);
			input.innerHTML = uf_addFormat(input.innerHTML,SEPARATOR);
		}
		
		catch(e)
		{
			alert(i+"\n"+e);
		}
	}
	
	var inputs = ufEval("id('divpage')/form/table/tbody/tr/th/table/tbody/tr/td[4]", document);
	
	for(var i=0; i < inputs.snapshotLength; i++)
	{
		try
		{
			//alert(i);
			var input = inputs.snapshotItem(i);
			input.innerHTML = uf_addFormat(input.innerHTML);
		}
		
		catch(e)
		{
			alert(i+"\n"+e);
		}
	}
}

function MESSAGES_colorer_message_flotte_amical(document)
{
	/*
		Idée de rnocb sur le topic http://forum.e-univers.org/index.php?showtopic=24987
		Codé par Max485 le 2 Août 2009
	*/

	var messages = ufEval("id('divpage')/form[3]/table/tbody/tr/th", document); // Recupere tous les messages
	
	var nb_msg = messages.snapshotLength; // Compte le nombre de messages retourné
	
	for( i=0; i<nb_msg; i++) // Passe la boucle pour chaque messages
	{
		if(messages.snapshotItem(i).innerHTML.match(/Une flotte amical/gi) ) // Dans le cas ou dans un message, on trouve le texte "Une flotte amical"
		{
			messages.snapshotItem(i).setAttribute('style', 'color : ' + ufGetPref('ufM_messages_colorer_message_flotte_amical_color_texte', '#FFFF00') + '; background-color :' + ufGetPref('ufM_messages_colorer_message_flotte_amical_color_backgound', '#9400D3') + ';'); // On modifie la couleur du texte et de l'arriere plan
		}
	}
}

function MESSAGES_colorer_message_rapport_espionnage_VE_si_il_y_en_a_de_present(document)
{
	try
	{
		var messages = ufEval("id('divpage')/form[3]/table/tbody/tr/th", document); // Recupere tous les messages
		
		var nb_msg = messages.snapshotLength; // Compte le nombre de messages retourné
		
		// Met par default dans le select1 des messages "Supprimer les messages lus"
		var msgSelect1 = ufEval("id('divpage')/form[3]/table/tbody/tr[2]/th/select/option[2]", document);
		msgSelect1.snapshotItem(0).selected = true;
		
		// Met par default dans le select2 des messages "Supprimer les messages lus" dans le cas ou il y a 10 messages
		var msgSelect2 = ufEval("id('divpage')/form[3]/table/tbody/tr[24]/th/select/option[2]", document);
		if(msgSelect2.snapshotLength >= 1)
		{
			msgSelect2.snapshotItem(0).selected = true;
		}

		
		for( i=0; i < nb_msg; i++) // Passe la boucle pour chaque messages
		{
			if(messages.snapshotItem(i).innerHTML.match(/Vaisseaux en exploitation sur/i) && messages.snapshotItem(i).innerHTML.match(/Vaisseau Extracteur/i) ) // Dans le cas ou des VE ont été trouvé sur la planete Sonder
			{
				messages.snapshotItem(i).setAttribute('style', 'color : ' + ufGetPref('ufM_messages_colorer_message_flotte_amical_color_texte', '#FFFF00') + '; background-color :' + ufGetPref('ufM_messages_colorer_message_flotte_amical_color_backgound', '#9400D3') + ';'); // On modifie la couleur du texte et de l'arriere plan		
			}
			else if(messages.snapshotItem(i).innerHTML.match(/Votre flotte compos\u00E9e de \(\d+ Vaisseau Extracteur\) revient sur la plan\u00E8te/i) )
			{
				messages.snapshotItem(i).setAttribute('style', 'color : ' + ufGetPref('ufM_messages_colorer_message_flotte_amical_color_texte', '#FFFF00') + '; background-color :' + ufGetPref('ufM_messages_colorer_message_flotte_amical_color_backgound', '#9400D3') + ';'); // On modifie la couleur du texte et de l'arriere plan				
			}
		}
	}
	catch(e)
	{
		alert(e);
	}
}

function MESSAGES_mettre_un_lien_sur_les_coords(document)
{
	var snap=ufEval("id('divpage')/form/table/tbody/tr/th",document);
	var reg = new RegExp('\\[(\\d+):(\\d+):(\\d+)\\]','g');
	//alert(snap.snapshotLength+ ' '+reg);
	for(var i = 0 ; i < snap.snapshotLength ; i++ ) {
		var cell = snap.snapshotItem(i);
		if(cell.innerHTML.match(reg)) {
			//alert(cell.innerHTML.match(reg));
			cell.innerHTML = cell.innerHTML.replace(reg,"<a href='?action=galaxie&amp;galaxiec=$1&amp;systemec=$2'>\[$1:$2:$3\]</a>");
		}
	}	
}

function RENOMMER_pass_deja_ecrit_pour_supprimer_colo(document) // Insere automatiquement le pass dans les cases prevu a cette effet pour supprimer une colonie
{
	/*
		Votre mot de passe est enregistré dans les options de GreaseMonkey la premiere fois que vous supprimer une colonie, 
		et les fois d'apres, il se ré-inscrit directement dans les cases lorsque vous vous trouvez sur la page pour 
		renommer / supprimer vos planetes
	*/
	
	var divpage = document.getElementById('divpage');
	var form_suppr = divpage.getElementsByTagName('form')[1]; // On recupere le formulaire correspondant a la suppression des planetes

	if (!ufGetPref('E-UniverS_Supprimer_colo', false) ) // Dans le cas ou le pass n'est pas enregistré
	{
		// Alors on les enregistre des que le joueur click sur le bouton Supprimer 
		form_suppr.addEventListener('submit', RENOMMER_pass_deja_ecrit_pour_supprimer_colo_GetID, false); 
	} 
	else // Dans le cas ou les identifiant sont enregistrer
	{
		form_suppr.getElementsByTagName('input')[0].value = ufDecrypt( ufGetPref('E-UniverS_Supprimer_colo', ''), 'dedeifvvf'); // On ecrit le pass dans la premiere case
		form_suppr.getElementsByTagName('input')[1].value = ufDecrypt( ufGetPref('E-UniverS_Supprimer_colo', ''), 'dedeifvvf'); // Puis on ecrit le pass dans la seconde case

		// On refait l'enregistrement, dans le cas ou le joueur aurait changé de mot de passe
		form_suppr.addEventListener('submit', RENOMMER_pass_deja_ecrit_pour_supprimer_colo_GetID, false); 
	}
}

function RENOMMER_pass_deja_ecrit_pour_supprimer_colo_GetID(event) // La fonction permettant d'enregistrer le pass dans les options de GM (Fonctionne avec la fonction ci dessus)
{
	var document = event.target.ownerDocument;
	
	var divpage = document.getElementById('divpage');
	var form_suppr = divpage.getElementsByTagName('form')[1]; // On recupere le formulaire correspondant a la suppression des planetes

	if(form_suppr.getElementsByTagName('input')[0].value == form_suppr.getElementsByTagName('input')[1].value ) // Dans le cas ou les pass corresponde bien, sinon c'est qu'il sont incorrect
	{
		ufSetCharPref('E-UniverS_Supprimer_colo', ufEncrypt( form_suppr.getElementsByTagName('input')[0].value, 'dedeifvvf') );
	}
}	

function SIMU_afficher_renta_defenseur(document) // Cette fonction permet d'afficher la rentabilité du defenseur dans le simulateur de combats
{
	/*
		Fonction par Jormund
		http://jormund.free.fr/e-univers/
	*/
	
	var elems = ufEval("id('divpage')/form/table[1]/tbody/tr/td[2]/table/tbody/tr[13]/th[2]", document);
	var cell = elems.snapshotItem(0);
	if(cell) 
	{
		var defLoss = uf_parseInt(cell.innerHTML);

		elems=ufEval("id('divpage')/form/table[1]/tbody/tr/td[2]/table/tbody/tr[18]/th[2]", document);
		cell = elems.snapshotItem(0);
		var cdr = uf_parseInt(cell.innerHTML);

		var renta = cdr-defLoss;
		renta = uf_addFormat(renta) + " unit&eacute;s";

		var table = cell.parentNode.parentNode;

		var line = document.createElement('tr');
		table.appendChild(line);
		line.innerHTML = '<td class="c" colspan="4">Rentabilit&eacute; du d&eacute;fenseur:</td>';

		line = document.createElement('tr');
		table.appendChild(line);
		line.innerHTML = '<th colspan="4">' + renta + '</th>';
	}
}

function SIMU_agrandir_zones_saisi(document, options)
{
	if(options['simu_agrandir_zones_saisi_dynamique'] == false)
	{
		var inputs=ufEval("id('divpage')/form/table[1]/tbody/tr/td[1]/table/tbody/tr/th/input[@type='text']",document);
		
		for(var i=0;i<inputs.snapshotLength;i++)
		{
			try
			{
				var input=inputs.snapshotItem(i);
				input.size='12';
			}
			catch(e)
			{
				alert(i+"\n"+e);
			}
		}
	}
	else
	{	
		var inputs=ufEval("id('divpage')/form/table[1]/tbody/tr/td[1]/table/tbody/tr/th/input",document);
		
		for(var i=0;i<inputs.snapshotLength;i++)
		{
			try
			{
				var input=inputs.snapshotItem(i);
				input.addEventListener("keyup",ufM_simu_enlargeInput,false);
				ufM_simu_enlargeInput2(input);
			}
			catch(e)
			{
				alert(i+"\n"+e);
			}
		}
	}
}

function STATS_changer_centaine_avec_fleches_gauche_droite(document)
{
	document.addEventListener('keydown', ufM_StatsChangerCentainesViaKeyLeftAndRight, false);
}

function VUEGLOBAL_afficher_BBCode_avec_empire_formater_pour_forum(document)
{	
	if(ufGetPref("ufDebugMode", false))
	{
		var tr_empire = ufEval("id('divpage')/table/tbody/tr", document);

		var nb_tr = tr_empire.snapshotLength;

		var empireTab = new Array();
		
		for(var p = 0; p < nb_tr; p++)
		{
			var th_empire = tr_empire.snapshotItem(p).getElementsByTagName('th');
			
			if(th_empire[0] != null)
			{
				var nb_th = th_empire.length;
				var th_name = (/<a>(.+)<\/a>/).exec(tr_empire.snapshotItem(p).getElementsByTagName('th')[0].innerHTML)[1];

				empireTab[th_name] = new Array();
				empireTab[th_name][0] = th_name;
				
				for(var j=1; j < nb_th; j++)
				{
					empireTab[th_name][j-1] = th_empire[j].innerHTML;
				}	
			}
			else
			{
				var th_name = tr_empire.snapshotItem(p).getElementsByTagName('td')[0].innerHTML;

				empireTab[th_name] = th_name;			
			}
			
			ufLog(th_name + '\n\n' + empireTab[th_name]);
		}

	}
}

function VUEGLOBAL_ajouter_somme_all_planetes(document)
{
	/*
		Fonction créer par Jormund
	*/
	
	var rows=ufEval("id('divpage')/table/tbody/tr",document);
	
	var total=0;
	
	for(var i=10;i<13;i++)
	{
		var row=rows.snapshotItem(i);
		var cells=row.getElementsByTagName('th');
		var nb=0;
		
		for(var j=1;j<cells.length;j++)
		{
			string = cells[j].innerHTML;
			string = string.replace(/\D/g,'');
			
			//alert(cells[j].innerHTML);
			nb+= string ? parseInt(string) : 0;
		}
		
		var cell = document.createElement('th');
		total+=nb;
		cell.innerHTML=uf_addFormat(nb);
		row.appendChild(cell);
	}
	row=rows.snapshotItem(9);
	cell = document.createElement('th');
	cell.innerHTML=uf_addFormat(total);
	row.appendChild(cell);
}





/*******************************************************************************************\
|****************************     FONCTIONS NATIVE JS     **********************************|
\*******************************************************************************************/



function getParams(url) // Permet de recuperer les differents parametres passé en URL
{
	var params = [];
	if(url.indexOf('?') >= 0) 
	{
		url = url.split('?')[1];
		url = url.split('#')[0];
		url = url.split('&');
		for(var i=0; i < url.length; i++) 
		{
			params[url[i].split('=')[0]] = url[i].split('=')[1];
		}
	}
	return params;
}

function formatNumber(num) // Arrondi un nombre au Giga, Mega, ou Kilo suivant ce qui va le mieux
{
	if(num >= 100000000000) 
	{
		num = (Math.round(num/1000000000))+"G";
	}
	else if(num >= 10000000000) 
	{
		num = Math.round(num*10/1000000000)/10+"G";
	}
	else if(num >= 1000000000) 
	{
		num = Math.round(num*100/1000000000)/100+"G";
	}
	else if(num >= 100000000) 
	{
		num = Math.round(num/1000000)+"M";
	}
	else if(num >= 10000000) 
	{
		num = Math.round(num*10/1000000)/10+"M";
	}
	else if(num >= 1000000) 
	{
		num = Math.round(num*100/1000000)/100+"M";
	}
	else if(num >= 100000) 
	{
		num = Math.round(num/1000)+"K";
	}
	else if(num >= 10000) 
	{
		num = Math.round(num*10/1000)/10+"K";
	}
	else if(num >= 1000) 
	{
		num = Math.round(num*100/1000)/100+"K";
	}
	
	return num;
}

function ufM_changerPlanetesViaUpOrDown(event) // Permet de changer de planete quand la touche Left ou Right est pressé
{
	var document = event.target.ownerDocument;

	if(event.keyCode == 38) // Up
	{
		var select = document.getElementsByName('planete_select')[0];
		if(select != null && select.selectedIndex > 0)
		{
				document.location.href = select.options[select.selectedIndex-1].value;
		}
	}

	if(event.keyCode == 40) // Down
	{
		var select = document.getElementsByName('planete_select')[0];
		if(select != null && ( select.selectedIndex < ( select.length - 1) ) )
		{
			document.location.href = select.options[select.selectedIndex+1].value;
		}
	}
}

function ufM_submitFleetOnFlotteorConvertoViaEnter(event) // Permet d'envoyer le dernier form de la page quand Enter est pressé
{
	var document = event.target.ownerDocument;

	if(event.keyCode == 13) // Touche Enter
	{
		document.getElementsByTagName('form')[document.getElementsByTagName('form').length-1].submit();
	}
}

function ufM_StatsChangerCentainesViaKeyLeftAndRight(event) 
{
	var document = event.target.ownerDocument;

	if(event.keyCode == 37) //left
	{
		var select = document.getElementsByName('start')[0];
		
		if(select != null)
		{
			if(select.selectedIndex>0)
			{
				select.options[select.selectedIndex-1].selected=true;
				document.forms[0].submit();
			}
		}
	}

	if(event.keyCode == 39) //right
	{
		var select=document.getElementsByName('start')[0];
		if(select!=null)
		{
			if(select.selectedIndex<select.length-1)
			{
				select.options[select.selectedIndex+1].selected=true;
				document.forms[0].submit();
			}
		}
	}
}

function ufM_simu_enlargeInput(e) // Permet un agrandissement dynamique des zones de saisi dans le chantier
{
	var input=e.target;
	ufM_simu_enlargeInput2(input);
}

function ufM_simu_enlargeInput2(input) // Permet un agrandissement dynamique des zones de saisi dans le chantier
{
	var text=input.value;
	if(text=="" || typeof text=="undefined")var l=0;
	else var l=text.length;
	if(l==0)var newl=1;
	else var newl=Math.ceil(l*1.16-2.40)+1;//l-2;//
	if(newl<5)newl=3; // Dans le cas ou la case devrait etre reduite trop petite, on met une valeur mini
	input.setAttribute("size",newl+2);

}

function ufM_message_RC_sendToConverterBBCode(event)
{
	var document = event.target.ownerDocument;
	document.location.href='http://jormund.free.fr/e-univers/converter.html?rc='+escape(ufM_message_RC_getText(document));
}

function ufM_message_RC_getText(document)
{

	var Selection = window.getSelection();
	
	if (Selection==null) 
	{
		return "error";
	}
	
	if(Selection.rangeCount > 0) Selection.removeAllRanges();

	var range = document.createRange();
	range.selectNode(document.body);
	Selection.addRange(range);

	//--------------------------
	var text = Selection.toString();

	return text;
}



ufLog('Fin du script de Max485');



/*
function getPrevious (obj) {
	if (obj.previousSibling == null) return obj;
	var prev=obj.previousSibling;
	while (prev.nodeType!=1 && prev.previousSibling != null)
		prev=prev.previousSibling;
	return prev;
}
function getNext (obj) {
	if (obj.nextSibling == null) return obj;
	var next=obj.nextSibling;
	while (next.nodeType!=1 && next.nextSibling != null)
		next=next.nextSibling;
	return next;
}
var monobjet = document.getElementById("test"); // récupération de l'objet de départ
var previous = getPrevious(monobjet); //objet précédent
var next = getNext(monobjet); //objet suivant
*/



/*
function OGPlugin_RestartFirefox() {
       var appStartup = Components.interfaces.nsIAppStartup;
       Components.classes["@mozilla.org/toolkit/app-startup;1"]
                 .getService(appStartup)
                 .quit(appStartup.eRestart | appStartup.eAttemptQuit);
}  

function OGPlugin_ReloadChrome() {
         Components.classes["@mozilla.org/chrome/chrome-registry;1"]
                   .getService(Components.interfaces.nsIXULChromeRegistry)
                   .reloadChrome();
}

function OGPlugin_OpenExtensionManager() {
          window.openDialog("chrome://mozapps/content/extensions/extensions.xul?type=extensions",
           "ext", "chrome,dialog,centerscreen,resizable")
}
*/

