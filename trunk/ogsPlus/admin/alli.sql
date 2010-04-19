-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Serveur: members.ogplus.sql.free.fr
-- Généré le : Dimanche 01 Octobre 2006 à 13:33
-- Version du serveur: 5.0.25
-- Version de PHP: 4.4.4
-- 
-- Base de données: `members_ogplus`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `alli`
-- 

CREATE TABLE `alli` (
  `id` int(11) NOT NULL auto_increment,
  `bann` int(11) NOT NULL default '0',
  `pass` text collate latin1_general_ci NOT NULL,
  `lng` text collate latin1_general_ci NOT NULL,
  `time_reg` int(11) NOT NULL,
  `last_log` int(11) NOT NULL,
  `nom` text collate latin1_general_ci NOT NULL,
  `alli` text collate latin1_general_ci NOT NULL,
  `tag` text collate latin1_general_ci NOT NULL,
  `uni` int(11) NOT NULL,
  `tld` text collate latin1_general_ci NOT NULL,
  `uptime` int(11) NOT NULL,
  `mbrs` int(11) NOT NULL,
  `ppts` int(11) NOT NULL,
  `progpts` text collate latin1_general_ci NOT NULL,
  `tpts` int(11) NOT NULL,
  `tmpts` int(11) NOT NULL,
  `pvaiss` int(11) NOT NULL,
  `progvaiss` text collate latin1_general_ci NOT NULL,
  `tvaiss` int(11) NOT NULL,
  `tmvaiss` int(11) NOT NULL,
  `prech` int(11) NOT NULL,
  `progrech` text collate latin1_general_ci NOT NULL,
  `trech` int(11) NOT NULL,
  `tmrech` int(11) NOT NULL,
  `bg` int(11) NOT NULL,
  `separ` int(11) NOT NULL,
  `r_chiff` int(11) NOT NULL,
  `v_chiff` int(11) NOT NULL,
  `b_chiff` int(11) NOT NULL,
  `r_txt` int(11) NOT NULL,
  `v_txt` int(11) NOT NULL,
  `b_txt` int(11) NOT NULL,
  `rvb_r_1` int(11) NOT NULL,
  `rvb_r_2` int(11) NOT NULL,
  `rvb_r_3` int(11) NOT NULL,
  `rvb_r_4` int(11) NOT NULL,
  `rvb_v_1` int(11) NOT NULL,
  `rvb_v_2` int(11) NOT NULL,
  `rvb_v_3` int(11) NOT NULL,
  `rvb_v_4` int(11) NOT NULL,
  `rvb_b_1` int(11) NOT NULL,
  `rvb_b_2` int(11) NOT NULL,
  `rvb_b_3` int(11) NOT NULL,
  `rvb_b_4` int(11) NOT NULL,
  `rvb_r_5` int(11) NOT NULL,
  `rvb_v_5` int(11) NOT NULL,
  `rvb_b_5` int(11) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4310 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4310 ;

-- 
-- Contenu de la table `alli`
-- 

INSERT INTO `alli` VALUES (1, 0, '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'fr', 0, 1159698830, 'CC30', 'Lycée Agricole', 'LEGTA', 29, 'fr', 1159698119, 50, 123456789, '*', 123456789, 123456789, 123456789, '-', 123456789, 123456789, 123456789, '+', 123456789, 123456789, 17, 1, 0, 0, 0, 0, 0, 0, 240, 255, 240, 255, 240, 255, 240, 255, 240, 255, 240, 255, 240, 240, 240);
