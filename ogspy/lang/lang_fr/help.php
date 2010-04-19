<?php
$help['install_SQL'] = 'Saisissez ici les informations relative &agrave; votre serveur MySQL';
$help['install_SQL_hostname'] = 'L&apos;adresse du serveur MySQL, souvent <br/><i>localhost</i><br/> sinon un serveur <br/><i>sql.example.fr</i>';
$help['install_SQL_name'] = 'Le nom de votre base de donn&eacute;es. OGSpy ne va pas la cr&eacute;er, assurez-vous qu&apos;elle existe';
$help['install_SQL_userpass'] = 'Le nom d&apos;utilisateur et son mot de passe, pour pouvoir se connecter &agrave; ce serveur';
$help['install_SQL_prefix'] = 'Le mot par lequel le nom de chaque table commencera (utile pour les trier)';
$help['install_Admin'] = 'Saisissez ici le pseudo et le mot de passe du compte Admin';
$help['install_Config'] = 'Veillez configurer les options initiales de votre serveur OGSpy.<br/><i>Vous pourrez modifer ces options n&apos;importe quand une fois connect&eacute;</i>';
$help['install_Lang'] = 'Choisissez la langue par d&eacute;faut pour l&apos;affichage d&apos;OGSpy';
$help['install_Parsing'] = 'S&eacute;l&eacute;ctionnez la langue du serveur OGame associ&eacute;e.<br/>OGSpy l&apos;utilisera pour analyser les informations envoy&eacute;es';
$help['install_Module'] = 'Cochez les cases des modules que vous voulez imm&eacute;diatement installer.<br/>Les cases griss&eacute;es correspondent aux modules d&eacute;j&agrave; install&eacute;s.<br/><br/>L&apos;&eacute;tape suivante reviendra cette page, tant que des cases seront coch&eacute;es';
$help['admin_member_manager'] = 'Autorise la cr&eacute;ation, la mise &agrave; jour et la suppression des utilisateurs';
$help['admin_ranking_manager'] = 'Autorise la suppression des classements joueurs et alliances';
$help['admin_session_infini'] = 'Si vous choisissez des sessions ind&eacute;finies dans le temps, plusieurs individus ne pourront plus utiliser le m&ecirc;me compte en m&ecirc;me temps';
$help['home_commandant'] = 'Page empire du compte commandant';
$help['profile_skin'] = 'OGSpy utilise les m&ecirc;me skin qu&apos;OGame';
$help['profile_login'] = 'Doit contenir entre 3 et 15 caract&egrave;res (les caract&egrave;res sp&eacute;ciaux ne sont pas accept&eacute;s)';
$help['profile_password'] = 'Doit contenir entre 6 et 15 caract&egrave;res (les caract&egrave;res sp&eacute;ciaux ne sont pas accept&eacute;s)';
$help['help_galaxyphalanx'] = 'Chargez des rapports d&apos;espionnage pour afficher les phalanges hostiles';
$help['help_search'] = 'S&eacute;parez les termes par des virgules(,) et utiliser le caract&egrave;re <b>*</b> pour chercher des chaines incompl&ecirc;tes.';
$help['drop_sessions'] = 'Vide la table des sessions, cela all&eacute;ge l&apos;administration mais oblige tous les utilisateurs &agrave; se reconnecter.';
$help['profile_main_planet'] = 'La vue Galaxie sera ouverte directement sur ce syst&egrave;me solaire';
$help['profile_disable_ip_check'] = 'La v&eacute;rification de l&apos;adresse IP permet de vous prot&eacute;ger contre le vol de session.<br /><br />Si vous &ecirc;tes d&eacute;connect&eacute; r&eacute;guli&egrave;rement (AOL, Proxy, etc), d&eacute;sactivez la v&eacute;rification.<br /><br /><i>L&apos;option est disponible uniquement si l&apos;administrateur l&apos;a activ&eacute;e</i>';
$help['galaxy_phalanx'] = 'Chargez des rapports d&apos;espionnage pour afficher les phalanges hostiles';
$help['galaxy_mip'] = 'Ces informations sont bas&eacute;es sur les donn&eacute;es des espaces personnels des membres';
$help['help_ratioblock'] = 'Vous avez un ratio inferieur au seuil, vous ne pouvez pas acc&eacute;der aux mods';
$help['help_profileddr'] = 'Cocher si le d&eacute;p&ocirc;t de ravitaillement est pr&eacute;sent dans votre univers';
$help['mp_chose_reader'] = 'Utilisez les touches MAJ et CTRL afin de choisir plusieurs destinataires';
$help['mp_delete'] = 'Effacer vos messages envoy&eacute;s ne les efface pas chez le destinataire';
$help['mp_dest_read'] = '%1$s Messages lus par le destinataire<br/>%2$s Messages non lus par le destinataire';



/* Page admin_parameters.php */
$help['admin_lang'] = 'Langue par d&eacute;faut du serveur.<br />Chaque nouvel inscris aura cette langue, ainsi que chaque membre actuel qui n&apos;aura jamais chang&eacute; son profil. Les membres qui ont modifi&eacute; leur profil garderont la langue qu&apos;ils ont choisie.';
$help['admin_lang_parsing'] = 'Choisissez ici la langue du serveur OGame assicoi&eacute; &agrave; cet OGSpy.<br />Cela ne changera rien &agrave; l&apos;affichage, mais seulement l&apos;interpr&eacute;tation des donn&eacute;es envoy&eacute;es par le Web.';
$help['admin_server_status'] = 'Lorsque le serveur est d&eacute;sactiv&eacute;, seul les membres avec le statut d&apos;administrateur ont acc&egrave;s aux fonctionnalit&eacute;s du serveur';
$help['admin_server_status_message'] = 'Le message sera affich&eacute; aux membres &quot;de base&quot; lorsque le serveur sera d&eacute;sactiv&eacute;';
$help['admin_check_ip'] = 'Certains utilisateurs subissent des d&eacute;connexions intempestives (AOL, Proxy, etc).<br />Activez cette option afin qu&apos;ils puissent d&eacute;sactiver la v&eacute;rification dans leur profil';
$help['admin_default_skin'] = '<i>ex: http://80.237.203.201/download/use/epicblue/</i>';
$help['admin_hidealliances'] = 'S&eacute;parez les alliances avec des virgules';
$help['admin_helpcolorallyhide'] = 'Doit &ecirc;tre le nom d&apos;une couleur en anglais ou son code hexad&eacute;cimal pr&eacute;c&eacute;d&eacute; d&apos;un #<br />Laissez vide pour activer le clignotement';
$help['admin_save_transaction'] = 'Les transactions correspondent aux :<br />- Syst&egrave;mes solaires<br />- Rapports d&apos;espionnage<br />- Classements joueurs et alliances';
$help['profile_galaxy'] = 'Doit contenir un nombre<br /> de 1 &agrave; 999';
$help['profile_speed_uni'] = 'Indiquez le multiplicateur de vitesse de votre univers (1 par d&eacute;faut)';
$help['profile_ddr'] = 'Cocher si le d&eacute;p&ocirc;t de ravitaillement est pr&eacute;sent dans votre univers';
$help['admin_LogPHPError'] = 'Surveillez vos journaux... peut prendre beaucoup de place !';
$help['admin_LogLangError'] = 'Permet de retrouver les chaines non traduite. Peut prendre beaucoup de place dans les journaux suivant le package langue install&eacute;.';

/* Page admin_affichage.php */
$help['admin_helpdisplaymip'] = 'Affiche ou cache les MIP des utilisateurs de OGSpy, mais ne les affichent qu&apos;&agrave; ceux qui peuvent voir les alliances prot&eacute;g&eacute;es';
$help['admin_helpdisplayfriendlyphalanx'] = 'Affiche ou cache les Phalanges Amies des utilisateurs de OGSpy, mais ne les affichent qu&apos;&agrave; ceux qui peuvent voir les alliances prot&eacute;g&eacute;es';
$help['admin_helpoptionmembers'] = 'Affiche ou cache le tableau de statistique des membres en bas de la page statistiques';
$help['admin_helpdisplaymbron'] = 'Affiche les (*) qui permettent de savoir qui est connect&eacute;<br />D&eacute;sactiv&eacute; si l&apos;affichage des membres n&apos;est pas activ&eacute;';
$help['admin_helpcolorally'] = '<i>Doit &ecirc;tre le nom d&apos;une couleur en anglais ou son code hexad&eacute;cimal pr&eacute;c&eacute;d&eacute; d&apos;un #</i>';
$help['admin_helpspecialcolortext'] = 'Choissisez le type de nom, Joueur ou Alliance, puis entrez un nom ou plus, s&eacute;par&eacute;s par des <b>,</b> (virgule)<br />Si vous inscrivez &quot;{Mine}&quot; avec le type Joueur, la couleur prendra effet sur le nom du membre qui affiche la page (en fonction de ce qu&apos;il a saisi dans son profil).';
$help['admin_helpdisplayregpannel'] = 'Affiche ou cache le tableau contenant le lien du forum de cet OGSpy';
$help['admin_helpboardlink'] = 'Lien d&apos;une section du forum, voire le PM de l&apos;administrateur OGSpy';
$help['admin_helpusermodconnexion'] = 'Module affich&eacute; lors de la connexion des utilisateurs de cet OGSpy';
$help['admin_helpadminmodconnexion'] = 'Module affich&eacute; lors de la connexion des administrateurs de cet OGSpy';

/* Page espace alliance */

$help['cartography_separate_with_commat'] = 'S&eacute;parez les noms avec des virgules';
?>
