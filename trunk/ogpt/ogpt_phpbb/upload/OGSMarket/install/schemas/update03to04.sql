##
## Sch�ma OGSMarket , version pr�liminaire
## 04/06/2006 Cr�ation
## mise � jour

## Activation automatique du serveur
ALTER TABLE `market_trade` ADD `pos_user` INT NOT NULL DEFAULT '0';
ALTER TABLE `market_trade` ADD `pos_date` INT NOT NULL ;


##mise � jour ent�te
ALTER TABLE `market_config` CHANGE `value` `value` TEXT NOT NULL;
