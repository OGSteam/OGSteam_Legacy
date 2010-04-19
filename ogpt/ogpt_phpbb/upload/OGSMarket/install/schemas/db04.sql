##
## Schéma OGSMarket , version préliminaire
## 04/06/2006 CrÈation
##


##
## Table utilisateur
##

CREATE TABLE `user` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur utilisateur',
`name` VARCHAR( 30 ) NOT NULL COMMENT 'Nom utilisateur',
`password` VARCHAR( 32 ) NOT NULL COMMENT 'md5 du mot de passe',
`regdate` INT( 11 ) NOT NULL COMMENT 'Date de creation',
`lastvisit` INT( 11 ) NOT NULL COMMENT 'DerniËre visite',
`countconnect` INT( 11 ) NOT NULL COMMENT 'DÈcompte du nombre de connexion',
`email` VARCHAR( 250 ) NOT NULL COMMENT 'Email',
`msn` VARCHAR( 100 ) NOT NULL COMMENT 'Email MSN',
`pm_link` VARCHAR( 30 ) NOT NULL COMMENT 'Lien Message PrivÈ',
`irc_nick` VARCHAR( 30 ) NOT NULL COMMENT 'Nick IRC',
`note` VARCHAR( 250) NOT NULL COMMENT 'Description User',
`account_type` VARCHAR( 10 ) NOT NULL DEFAULT 'internal' COMMENT 'Type de comptes',
`is_admin` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Administrateur',
`is_moderator` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'ModÈrateur',
`is_active` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Est Actif'

) ENGINE = MYISAM COMMENT = 'Table des utilisateurs';


##
## Table des univers
##


CREATE TABLE `univers` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur Univers',
`url` VARCHAR( 255 ) NOT NULL COMMENT 'URL de login',
`name` VARCHAR( 40 ) NOT NULL COMMENT 'Nom userfriendly de l''univers'
) ENGINE = MYISAM ;


##
## Table des Trades
##

CREATE TABLE `trade` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur de l''échange',
`traderid` INT( 11 ) NOT NULL COMMENT 'Identificateur de l''utilisateur ',
`universid` INT( 11 ) NOT NULL COMMENT 'Identificateur de l''univers de l''échange',
`offer_metal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Offre en métal',
`offer_crystal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Offre en crystal',
`offer_deuterium` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Offre en deuterium',
`want_metal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Demande en métal',
`want_crystal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Demande en crystal',
`want_deuterium` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Demande en deuterium',
`creation_date` INT( 11 ) NOT NULL COMMENT 'Date de création del''offre',
`expiration_date` INT( 11 ) NOT NULL COMMENT 'Date d''expiration de l''offre',
`note` TEXT NULL COMMENT 'Note du vendeur pour son offre',
`deliver_g1` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Livrable en g1',
`deliver_g2` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Livrable en g2',
`deliver_g3` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Livrable en g3',
`deliver_g4` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Livrable en g4',
`deliver_g5` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Livrable en g5',
`deliver_g6` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Livrable en g6',
`deliver_g7` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Livrable en g7',
`deliver_g8` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Livrable en g8',
`deliver_g9` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Livrable en g9',
`refunding_g1` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Payable en g1',
`refunding_g2` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Payable en g2',
`refunding_g3` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Payable en g3',
`refunding_g4` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Payable en g4',
`refunding_g5` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Payable en g5',
`refunding_g6` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Payable en g6',
`refunding_g7` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Payable en g7',
`refunding_g8` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Payable en g8',
`refunding_g9` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Payable en g9'
) ENGINE = MYISAM COMMENT = 'Offres et Demandes';


##
## Table des Commentaires
##

CREATE TABLE `comment` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur du commentaire',
`tradeid` INT( 11 ) NOT NULL COMMENT 'Identificateur du trade auquel se rapporte le commentaire',
`userid` INT( 11 ) NOT NULL COMMENT 'Identificateur de l''utilisateur',
`replyed_id` INT( 11 ) NOT NULL COMMENT 'Identificateur eventuel du commentaire auquel on rÈpond',
`post` TEXT NOT NULL COMMENT 'Le corps du commentaire'
) ENGINE = MYISAM COMMENT = 'Commentaires / thread des offres demandes';

##
## Table des deals et contre-offres
##


CREATE TABLE `trade_deals` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur',
`tradeid` INT( 11 ) NOT NULL COMMENT 'Identificateur du trade',
`userid` INT( 11 ) NOT NULL COMMENT 'identificateur de l''utilisateur interressÈ',
`offer_metal` INT( 11 ) NOT NULL COMMENT 'Offre en mÈtal',
`offer_crystal` INT( 11 ) NOT NULL COMMENT 'Offre en crystal',
`offer_deuterium` INT( 11 ) NOT NULL COMMENT 'Offre en deutÈrium',
`note` TEXT NOT NULL COMMENT 'Note sur l''offre',
`creation_date` INT( 11 ) NOT NULL COMMENT 'Date de creation'
) ENGINE = MYISAM COMMENT = 'Deals et Contre-Offres';


##
## Tables du menu
##

CREATE TABLE `menu` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur de la variable config',
`name` VARCHAR( 20 ) NOT NULL COMMENT 'Nom de la variable config',
`value` VARCHAR( 255 ) NOT NULL COMMENT 'Valeur de la cariable config'
) ENGINE = MYISAM COMMENT = 'Configuration du serveur OGSMarket';

##
## Tables des Ogspy autorisés
##
CREATE TABLE `ogspy_auth` (
`id` INT NOT NULL AUTO_INCREMENT ,
`url` VARCHAR( 255 ) NOT NULL ,
`read_access` ENUM( '0', '1' ) DEFAULT '1' NOT NULL ,
`write_access` ENUM( '0', '1' ) DEFAULT '1' NOT NULL ,
`active` ENUM( '0', '1' ) DEFAULT '1' NOT NULL ,
`description` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `id` ) ,
UNIQUE (
`url`
)
);


##
## Table structure for table `sessions`
##

CREATE TABLE `sessions` (
        `id` int(11) NOT NULL auto_increment COMMENT 'Identificateur BD',
        `ip` varchar(13) NOT NULL COMMENT 'Adresse IP',
        `last_connect` int(11) NOT NULL COMMENT 'DerniËre connexion',
        PRIMARY KEY  (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

##
## Initialisation de la configuration par défaut (2 tables : config et infos)
##
CREATE TABLE `config` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur de la variable config',
`name` VARCHAR( 20 ) NOT NULL COMMENT 'Nom de la variable config',
`value` VARCHAR( 255 ) NOT NULL COMMENT 'Valeur de la cariable config'
) ENGINE = MYISAM COMMENT = 'Configuration du serveur OGSMarket';

CREATE TABLE `infos` (
  `id` int(11) NOT NULL auto_increment COMMENT 'Identificateur de la variable infos',
  `name` varchar(20) NOT NULL default '' COMMENT 'Nom de la variable infos',
  `value` longtext NOT NULL COMMENT 'Valeur de la variable infos',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM COMMENT='Infos diverses';


##Création du message d'acceuil par défaut

INSERT INTO `infos` ( `id` , `name` , `value` )
VALUES (
'1', 'home', '<p align="center"><b><font size="4">Bienvenu sur votre Market!</font></b></p>
<p align="center" style="margin-top: 0; margin-bottom: 0"><font size="4">
FÈlicitation! Vous venez de migrer vers OGMarket 0.4!</font></p>
<p align="center" style="margin-top: 0; margin-bottom: 0"><font size="4">Vous 
pourrez maintenant beaucoup plus personnaliser votre serveur gr‚ce au panneau 
dadministration!</font></p>
<p align="center" style="margin-top: 0; margin-bottom: 0"><font size="4">Vous 
devriez dËs maintenant pouvoir vous loguer gr‚ce au compte Admin</font></p>
<p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p align="center" style="margin-top: 0; margin-bottom: 0"><font size="4">nom:
<font color="#0000FF">Admin</font></font><font color="#0000FF"></font></p>
<p align="center" style="margin-top: 0; margin-bottom: 0"><font size="4">code:
<font color="#0000FF">administration</font> </font></p>'
);

##menu
INSERT INTO `config` VALUES(null,'menuprive','privÈ');
INSERT INTO `config` VALUES(null,'menulogout','logout');
INSERT INTO `config` VALUES(null,'adresseforum','Adresse de votre forum');
INSERT INTO `config` VALUES(null,'nomforum','nom de votre forum');
INSERT INTO `config` VALUES(null,'menuforum','Forum et IRC');
INSERT INTO `config` VALUES(null,'menuautre','autre');

## votre forum
INSERT INTO `config` VALUES(null,'forum','logout');

## le skin
INSERT INTO `config` VALUES(null,'skin','http://80.237.203.201/download/use/evolution/');

## Nombre maximum de trade par utilisateur et par univers autorisé (0 pour infini, attention au spam)
INSERT INTO `config` VALUES(null,'max_trade_by_universe','5');

## DurÈe maximum d'un trade (5 jours.... qu'on se retrouve pas avec des trades datant de 3 mois...)
INSERT INTO `config` VALUES(null,'max_trade_delay_seconds','432000');   /* soit 5 jours */

##Purge automatique des trades expirés et de leur commentaires (1=oui , 0 = Non)
INSERT INTO `config` VALUES(null,'autopurgeexpiredtrade','1');   

## Délai aprés expiration pour effacer les trades et commentaires
INSERT INTO `config` VALUES(null,'autopurgeexpiredtrade_delay','86400');   

## Nom du serveur , Afficher en titre de page Web
INSERT INTO `config` VALUES(null,'servername','OGMARKET');

## Version du serveur
INSERT INTO `config` VALUES(null,'version','0.2b');

##  Type authentification des utilisateurs
## internal,ogspy,punbb,phpbb
INSERT INTO `config` VALUES(null,'users_auth_type','internal');

## Activation automatique du serveur
INSERT INTO `config` VALUES(null,'Activ_auto','1');

## Activation automatique des membres
INSERT INTO `config` VALUES(null, 'users_active', '0');
## Information BD pour les authentification non "internal"
##Base de donnée
INSERT INTO `config` VALUES(null,'users_auth_db','');
## Table dans la base de donnée
INSERT INTO `config` VALUES(null,'users_auth_table','');
## User de cette BD dauthentification
INSERT INTO `config` VALUES(null,'users_auth_dbuser','');
## Url d inscription quand le type n est pas internal
INSERT INTO `config` VALUES(null,'users_inscription_url','');
## Mot de passe BD
INSERT INTO `config` VALUES(null,'users_auth_dbpassword','');
INSERT INTO `config` VALUES (null, 'market_read_access', '0');
INSERT INTO `config` VALUES (null, 'market_write_access', '0');
INSERT INTO `config` VALUES (null, 'market_password', '');

##création d'un compte admin
INSERT INTO `user` ( `id` , `name` , `password` , `regdate` , `lastvisit` , `countconnect` , `email` , `msn` , `pm_link` , `irc_nick` , `note` , `account_type` , `is_admin` , `is_moderator` , `is_active` )
VALUES (
'1', 'Admin', '372eeffaba2b5b61fb02513ecb84f1ff', '', '', '', '', '', '', '', '', 'internal', '1', '1', '1'
);

## nom des tables
ALTER TABLE `user` RENAME `market_user` ;
ALTER TABLE `univers` RENAME `market_univers` ;
ALTER TABLE `trade` RENAME `market_trade` ;
ALTER TABLE `comment` RENAME `market_comment` ;
ALTER TABLE `config` RENAME `market_config` ;
ALTER TABLE `infos` RENAME `market_infos` ;
ALTER TABLE `trade_deals` RENAME `market_trade_deals` ;
ALTER TABLE `ogspy_auth` RENAME `market_ogspy_auth` ;
ALTER TABLE `sessions` RENAME `market_sessions` ;
ALTER TABLE `menu` RENAME `market_menu` ;