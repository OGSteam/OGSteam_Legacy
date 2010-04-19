-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Serveur: members.ogplus.sql.free.fr
-- Généré le : Samedi 30 Septembre 2006 à 16:16
-- Version du serveur: 5.0.25
-- Version de PHP: 4.4.4
-- 
-- Base de données: `members_ogplus`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `bann` int(11) NOT NULL default '0',
  `pass` text collate latin1_general_ci NOT NULL,
  `lng` text collate latin1_general_ci NOT NULL,
  `time_reg` int(11) NOT NULL,
  `nom` text collate latin1_general_ci NOT NULL,
  `alli` text collate latin1_general_ci NOT NULL,
  `uni` int(11) NOT NULL,
  `tld` text collate latin1_general_ci NOT NULL,
  `uptime` int(11) NOT NULL,
  `ppts` int(11) NOT NULL,
  `progpts` text collate latin1_general_ci NOT NULL,
  `tpts` int(11) NOT NULL,
  `pvaiss` int(11) NOT NULL,
  `progvaiss` text collate latin1_general_ci NOT NULL,
  `tvaiss` int(11) NOT NULL,
  `prech` int(11) NOT NULL,
  `progrech` text collate latin1_general_ci NOT NULL,
  `trech` int(11) NOT NULL,
  `prod_bg` int(11) NOT NULL,
  `prod_separ` int(11) NOT NULL,
  `r_chiff_prod` int(11) NOT NULL,
  `v_chiff_prod` int(11) NOT NULL,
  `b_chiff_prod` int(11) NOT NULL,
  `r_txt_prod` int(11) NOT NULL,
  `v_txt_prod` int(11) NOT NULL,
  `b_txt_prod` int(11) NOT NULL,
  `rvb_prod_r_1` int(11) NOT NULL,
  `rvb_prod_r_2` int(11) NOT NULL,
  `rvb_prod_r_3` int(11) NOT NULL,
  `rvb_prod_r_4` int(11) NOT NULL,
  `rvb_prod_v_1` int(11) NOT NULL,
  `rvb_prod_v_2` int(11) NOT NULL,
  `rvb_prod_v_3` int(11) NOT NULL,
  `rvb_prod_v_4` int(11) NOT NULL,
  `rvb_prod_b_1` int(11) NOT NULL,
  `rvb_prod_b_2` int(11) NOT NULL,
  `rvb_prod_b_3` int(11) NOT NULL,
  `rvb_prod_b_4` int(11) NOT NULL,
  `p1m` int(11) NOT NULL,
  `p1c` int(11) NOT NULL,
  `p1d` int(11) NOT NULL,
  `p2m` int(11) NOT NULL,
  `p2c` int(11) NOT NULL,
  `p2d` int(11) NOT NULL,
  `p3m` int(11) NOT NULL,
  `p3c` int(11) NOT NULL,
  `p3d` int(11) NOT NULL,
  `p4m` int(11) NOT NULL,
  `p4c` int(11) NOT NULL,
  `p4d` int(11) NOT NULL,
  `p5m` int(11) NOT NULL,
  `p5c` int(11) NOT NULL,
  `p5d` int(11) NOT NULL,
  `p6m` int(11) NOT NULL,
  `p6c` int(11) NOT NULL,
  `p6d` int(11) NOT NULL,
  `p7m` int(11) NOT NULL,
  `p7c` int(11) NOT NULL,
  `p7d` int(11) NOT NULL,
  `p8m` int(11) NOT NULL,
  `p8c` int(11) NOT NULL,
  `p8d` int(11) NOT NULL,
  `p9m` int(11) NOT NULL,
  `p9c` int(11) NOT NULL,
  `p9d` int(11) NOT NULL,
  `rank_bg` int(11) NOT NULL,
  `rank_separ` int(11) NOT NULL,
  `r_chiff_rank` int(11) NOT NULL,
  `v_chiff_rank` int(11) NOT NULL,
  `b_chiff_rank` int(11) NOT NULL,
  `r_txt_rank` int(11) NOT NULL,
  `v_txt_rank` int(11) NOT NULL,
  `b_txt_rank` int(11) NOT NULL,
  `rvb_rank_r_1` int(11) NOT NULL,
  `rvb_rank_r_2` int(11) NOT NULL,
  `rvb_rank_r_3` int(11) NOT NULL,
  `rvb_rank_r_4` int(11) NOT NULL,
  `rvb_rank_v_1` int(11) NOT NULL,
  `rvb_rank_v_2` int(11) NOT NULL,
  `rvb_rank_v_3` int(11) NOT NULL,
  `rvb_rank_v_4` int(11) NOT NULL,
  `rvb_rank_b_1` int(11) NOT NULL,
  `rvb_rank_b_2` int(11) NOT NULL,
  `rvb_rank_b_3` int(11) NOT NULL,
  `rvb_rank_b_4` int(11) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4310 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4310 ;

-- 
-- Contenu de la table `users`
-- 

INSERT INTO `users` VALUES (1, 0, 'de6a990d4b8ff8de2071df71bdfad82f', 'fr', 1142965399, 'Demon', 'Evil', 69, 'omg', 1, 666, '+', 666, 666, '-', 666, 666, '*', 666, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 666, 666, 666, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `users` VALUES (2, 0, '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'fr', 1156532634, 'CC30', 'LEGTA', 29, 'sk', 1159625598, 1, '*', 900000000, 12000, '*', 1123456789, 5, '*', 1123456789, 25, 1, 0, 255, 0, 255, 0, 0, 240, 255, 240, 255, 240, 255, 240, 255, 240, 255, 240, 255, 111, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 1234567, 2, 2, 0, 0, 296, 0, 128, 192, 240, 255, 240, 255, 240, 255, 240, 255, 240, 255, 240, 255);
