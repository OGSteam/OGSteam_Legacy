##
## Sch�ma OGSMarket , version pr�liminaire
## 04/02/2007 Cr�ation
## mise � jour


## Taux de Change
INSERT INTO `market_config` (`name`, `value`) VALUES ('tauxmetal', '3'),('tauxcristal', '2'),('tauxdeuterium', '1');
## Visualisation des offres limit�e aux membres
INSERT INTO `market_config` (`name` , `value` ) VALUES ('view_trade', '0');
## URL Server
INSERT INTO `market_config` VALUES (null, 'users_adr_auth_db', '');



## Version du serveur
UPDATE `market_config` SET `value` = '0.6' WHERE  `name` = 'version';