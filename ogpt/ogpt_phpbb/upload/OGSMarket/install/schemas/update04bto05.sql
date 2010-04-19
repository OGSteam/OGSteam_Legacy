##
## Schéma OGSMarket , version préliminaire
## 04/02/2007 Création
## mise à jour


## Activation automatique des membres
INSERT INTO `market_config` VALUES(null, 'users_active', '0');

##Ajout table market_infos
CREATE TABLE `market_infos` (
  `id` int(11) NOT NULL auto_increment COMMENT 'Identificateur de la variable infos',
  `name` varchar(20) NOT NULL default '' COMMENT 'Nom de la variable infos',
  `value` longtext NOT NULL COMMENT 'Valeur de la variable infos',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM COMMENT='Infos diverses';

##Transfert du message d'accueil
INSERT INTO `market_infos` SELECT * FROM `market_config` WHERE `name` = 'home';
DELETE FROM `market_config` WHERE `name` = 'home';



## Version du serveur
UPDATE `market_config` SET `value` = '0.5' WHERE  `name` = 'version';