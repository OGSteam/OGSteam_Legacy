##
## Schéma OGSMarket , version préliminaire
## 04/06/2006 Création
##

##
##Création du message d'acceuil par défaut
##

INSERT INTO `market_config` ( `id` , `name` , `value` )
VALUES (
'41', 'home', '<p align="center"><b><font size="4">Bienvenu sur votre Market!</font></b></p>
<p align="center" style="margin-top: 0; margin-bottom: 0"><font size="4">
Félicitation! Vous venez de migrer vers OGMarket0.2b!</font></p>
<p align="center" style="margin-top: 0; margin-bottom: 0"><font size="4">Vous 
pourrez maintenant beaucoup plus personnaliser votre serveur grâce au panneau 
d'administration!</font></p>
<p align="center" style="margin-top: 0; margin-bottom: 0"><font size="4">Vous 
devriez dès maintenant pouvoir vous loguer grâce au compte Admin</font></p>
<p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p align="center" style="margin-top: 0; margin-bottom: 0"><font size="4">nom:
<font color="#0000FF">Admin</font></font><font color="#0000FF"></font></p>
<p align="center" style="margin-top: 0; margin-bottom: 0"><font size="4">code:
<font color="#0000FF">administration</font> </font></p>'
);

##
##menu par défaut
##

INSERT INTO `market_config` VALUES(null,'menuprive','privé');
INSERT INTO `market_config` VALUES(null,'menulogout','logout');
INSERT INTO `market_config` VALUES(null,'menuforum','Forum et IRC');
INSERT INTO `market_config` VALUES(null,'menuautre','autre');
INSERT INTO `market_config` VALUES(null,'adresseforum','Adresse de votre forum');
INSERT INTO `market_config` VALUES(null,'nomforum','nom de votre forum');
INSERT INTO `market_config` VALUES(null,'menuautre','autre');


