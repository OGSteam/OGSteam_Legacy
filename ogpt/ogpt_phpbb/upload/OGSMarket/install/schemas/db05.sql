##
## Table utilisateur
##

CREATE TABLE `market_user` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur utilisateur',
`name` VARCHAR( 30 ) NOT NULL COMMENT 'Nom utilisateur',
`password` VARCHAR( 32 ) NOT NULL COMMENT 'md5 du mot de passe',
`regdate` INT( 11 ) NOT NULL COMMENT 'Date de creation',
`lastvisit` INT( 11 ) NOT NULL COMMENT 'Dernière visite',
`countconnect` INT( 11 ) NOT NULL COMMENT 'Decompte du nombre de connexion',
`email` VARCHAR( 250 ) NOT NULL COMMENT 'Email',
`msn` VARCHAR( 100 ) NOT NULL COMMENT 'Email MSN',
`pm_link` VARCHAR( 30 ) NOT NULL COMMENT 'Lien Message Prive',
`irc_nick` VARCHAR( 30 ) NOT NULL COMMENT 'Nick IRC',
`note` VARCHAR( 250) NOT NULL COMMENT 'Description User',
`account_type` VARCHAR( 10 ) NOT NULL DEFAULT 'internal' COMMENT 'Type de comptes',
`is_admin` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT 'Administrateur',
`is_moderator` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT 'Modérateur',
`is_active` ENUM('0','1') NOT NULL DEFAULT '1' COMMENT 'Est Actif'
);


##
## Table des univers
##


CREATE TABLE `market_univers` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur Univers',
`url` VARCHAR( 255 ) NOT NULL COMMENT 'URL de login',
`name` VARCHAR( 40 ) NOT NULL COMMENT 'Nom userfriendly de l''univers'
);


##
## Table des Trades
##

CREATE TABLE `market_trade` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur de l''Žchange',
`traderid` INT( 11 ) NOT NULL COMMENT 'Identificateur de l''utilisateur ',
`universid` INT( 11 ) NOT NULL COMMENT 'Identificateur de l''univers de l''Žchange',
`offer_metal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Offre en mŽtal',
`offer_crystal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Offre en crystal',
`offer_deuterium` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Offre en deuterium',
`want_metal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Demande en mŽtal',
`want_crystal` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Demande en crystal',
`want_deuterium` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Demande en deuterium',
`creation_date` INT( 11 ) NOT NULL COMMENT 'Date de crŽation del''offre',
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
`refunding_g9` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Payable en g9',
`pos_user` INT NOT NULL DEFAULT '0',
`pos_date` INT NOT NULL 
);


##
## Table des Commentaires
##

CREATE TABLE `market_comment` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur du commentaire',
`tradeid` INT( 11 ) NOT NULL COMMENT 'Identificateur du trade auquel se rapporte le commentaire',
`userid` INT( 11 ) NOT NULL COMMENT 'Identificateur de l''utilisateur',
`replyed_id` INT( 11 ) NOT NULL COMMENT 'Identificateur eventuel du commentaire auquel on répond',
`post` TEXT NOT NULL COMMENT 'Le corps du commentaire'
);

##
## Table des deals et contre-offres
##


CREATE TABLE `market_trade_deals` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur',
`tradeid` INT( 11 ) NOT NULL COMMENT 'Identificateur du trade',
`userid` INT( 11 ) NOT NULL COMMENT 'identificateur de l''utilisateur interressé',
`offer_metal` INT( 11 ) NOT NULL COMMENT 'Offre en métal',
`offer_crystal` INT( 11 ) NOT NULL COMMENT 'Offre en crystal',
`offer_deuterium` INT( 11 ) NOT NULL COMMENT 'Offre en deutérium',
`note` TEXT NOT NULL COMMENT 'Note sur l''offre',
`creation_date` INT( 11 ) NOT NULL COMMENT 'Date de creation'
);


##
## Tables du menu
##

CREATE TABLE `market_menu` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur de la variable config',
`name` VARCHAR( 20 ) NOT NULL COMMENT 'Nom de la variable config',
`value` VARCHAR( 255 ) NOT NULL COMMENT 'Valeur de la cariable config'
);

##
## Tables des Ogspy autorise
##
CREATE TABLE `market_ogspy_auth` (
`id` INT NOT NULL AUTO_INCREMENT ,
`url` VARCHAR( 255 ) NOT NULL ,
`read_access` ENUM( '0', '1' ) DEFAULT '1' NOT NULL ,
`write_access` ENUM( '0', '1' ) DEFAULT '1' NOT NULL ,
`active` ENUM( '0', '1' ) DEFAULT '1' NOT NULL ,
`description` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `id` ) ,
 UNIQUE (`url`)
);


##
## Table structure for table `sessions`
##

CREATE TABLE `market_sessions` (
        `id` int(11) NOT NULL auto_increment COMMENT 'Identificateur BD',
        `ip` varchar(13) NOT NULL COMMENT 'Adresse IP',
        `last_connect` int(11) NOT NULL COMMENT 'Dernière connexion',
        PRIMARY KEY  (`id`)
);

##
## Initialisation de la configuration par defaut (2 tables : config et infos)
##
CREATE TABLE `market_config` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificateur de la variable config',
`name` VARCHAR( 20 ) NOT NULL COMMENT 'Nom de la variable config',
`value` VARCHAR( 255 ) NOT NULL COMMENT 'Valeur de la cariable config'
);

CREATE TABLE `market_infos` (
  `id` int(11) NOT NULL auto_increment COMMENT 'Identificateur de la variable infos',
  `name` varchar(20) NOT NULL default '' COMMENT 'Nom de la variable infos',
  `value` longtext NOT NULL COMMENT 'Valeur de la variable infos',
  PRIMARY KEY  (`id`)
);


##menu
INSERT INTO `market_config` VALUES(null,'menuprive','privé');
INSERT INTO `market_config` VALUES(null,'menulogout','logout');
INSERT INTO `market_config` VALUES(null,'adresseforum','Adresse de votre forum');
INSERT INTO `market_config` VALUES(null,'nomforum','nom de votre forum');
INSERT INTO `market_config` VALUES(null,'menuforum','Forum et IRC');
INSERT INTO `market_config` VALUES(null,'menuautre','autre');

## votre forum
INSERT INTO `market_config` VALUES(null,'forum','logout');

## le skin
INSERT INTO `market_config` VALUES(null,'skin','http://80.237.203.201/download/use/evolution/');

## Nombre maximum de trade par utilisateur et par univers autorisŽ (0 pour infini, attention au spam)
INSERT INTO `market_config` VALUES(null,'max_trade_by_universe','5');

## Durée maximum d'un trade (5 jours.... qu'on se retrouve pas avec des trades datant de 3 mois...)
INSERT INTO `market_config` VALUES(null,'max_trade_delay_seconds','432000');  

##Purge automatique des trades expirŽs et de leur commentaires (1=oui , 0 = Non)
INSERT INTO `market_config` VALUES(null,'autopurgeexpiredtrade','1');   

## DŽlai aprŽs expiration pour effacer les trades et commentaires
INSERT INTO `market_config` VALUES(null,'autopurgeexpiredtrade_delay','86400');   

## Nom du serveur , Afficher en titre de page Web
INSERT INTO `market_config` VALUES(null,'servername','OGSMARKET');

## Version du serveur
INSERT INTO `market_config` VALUES(null,'version','0.5');

##  Type authentification des utilisateurs
## internal,ogspy,punbb,phpbb
INSERT INTO `market_config` VALUES(null,'users_auth_type','internal');

## Activation automatique du serveur
INSERT INTO `market_config` VALUES(null,'Activ_auto','1');

## Activation automatique des membres
INSERT INTO `market_config` VALUES(null, 'users_active', '0');
## Information BD pour les authentification non internal
##Base de donnee
INSERT INTO `market_config` VALUES(null,'users_auth_db','');
## Table dans la base de donnŽe
INSERT INTO `market_config` VALUES(null,'users_auth_table','');
## User de cette BD dauthentification
INSERT INTO `market_config` VALUES(null,'users_auth_dbuser','');
## Url d inscription quand le type n est pas internal
INSERT INTO `market_config` VALUES(null,'users_inscription_url','');
## Mot de passe BD
INSERT INTO `market_config` VALUES(null,'users_auth_dbpassword','');
INSERT INTO `market_config` VALUES (null, 'market_read_access', '0');
INSERT INTO `market_config` VALUES (null, 'market_write_access', '0');
INSERT INTO `market_config` VALUES (null, 'market_password', '');


INSERT INTO `market_infos`
VALUES ('1', 'home', '<p align="center"><b><font size="4">Bienvenu sur votre Market!</font></b></p><p align="center"><font size="4">Félicitation! Vous venez d\'installer OGMarket 0.5!</font></p><p align="center"><font size="4">Vous pourrez maintenant beaucoup plus personnaliser votre serveur grâce au panneau d\'administration!</font></p><p align="center"><font size="4">Vous devriez dès maintenant pouvoir vous loguer grâce a votre compte Admin</font></p><p align="center"></p>'
);