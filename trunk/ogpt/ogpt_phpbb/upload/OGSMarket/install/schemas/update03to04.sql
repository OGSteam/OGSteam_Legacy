##
## Schéma OGSMarket , version préliminaire
## 04/06/2006 Création
## mise à jour

## Activation automatique du serveur
ALTER TABLE `market_trade` ADD `pos_user` INT NOT NULL DEFAULT '0';
ALTER TABLE `market_trade` ADD `pos_date` INT NOT NULL ;


##mise à jour entête
ALTER TABLE `market_config` CHANGE `value` `value` TEXT NOT NULL;
