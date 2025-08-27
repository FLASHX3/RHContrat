-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 28 avr. 2025 à 17:19
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Base de données : `rhcontrat`
--

-- --------------------------------------------------------
--
-- Structure de la table `contrats`
--

DROP TABLE IF EXISTS `contrats`;
CREATE TABLE IF NOT EXISTS `contrats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matricule` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_contrat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `poste` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_contrats` int NOT NULL,
  `duree_contrat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_prise_effet` date NOT NULL,
  `date_echeance` date NOT NULL,
  `dossier_complet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reconductible` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricule` (`matricule`)
) ENGINE = MyISAM AUTO_INCREMENT = 19 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Déchargement des données de la table `contrats`
--

INSERT INTO `contrats` (
    `id`,
    `matricule`,
    `nom`,
    `prenom`,
    `type_contrat`,
    `entite`,
    `service`,
    `poste`,
    `nombre_contrats`,
    `duree_contrat`,
    `date_prise_effet`,
    `date_echeance`,
    `dossier_complet`,
    `reconductible`
  )
VALUES (
    1,
    'M102dz',
    'NTEP',
    'Jean Kévin Walter',
    'CDD',
    'SCI SOTRADIC',
    'Informatique',
    'Support Informatique',
    1,
    '12',
    '2024-02-06',
    '2025-02-06',
    'oui',
    'oui'
  ),
  (
    2,
    'M102d',
    'YINDA',
    'Marie Euryale Loïca',
    'CDD',
    'SCI SOTRADIC',
    'Marketing',
    'Agent Marketing',
    1,
    '12',
    '2024-02-06',
    '2025-02-06',
    'oui',
    'oui'
  ),
  (
    3,
    'Xfjk',
    'NTEP',
    'Yvone Marie Espérenza',
    'CDD',
    'SCI SOTRADIC',
    'Direction',
    'Assistante de Direction',
    1,
    '12',
    '2024-02-06',
    '2025-02-06',
    'oui',
    'non'
  ),
  (
    4,
    'KBkj',
    'JBiu',
    'JKb',
    'CDD',
    'SCI SOTRADIC',
    'Audit',
    'Auditeur/rice',
    1,
    '12',
    '2024-02-06',
    '2025-02-06',
    'oui',
    'oui'
  ),
  (
    5,
    'Mkv58',
    'Nuked',
    'NIl',
    'CDD',
    'SCI SOTRADIC',
    'Comptabilité',
    'Comptable',
    1,
    '12',
    '2024-02-06',
    '2025-02-06',
    'oui',
    'oui'
  ),
  (
    6,
    'FHJG',
    'FTG',
    'GHGH',
    'CDD',
    'SCI SOTRADIC',
    'Approvisionement',
    'Responsable Administratif et Financier',
    1,
    '12',
    '2024-04-18',
    '2025-04-18',
    'oui',
    'non'
  ),
  (
    7,
    'KGkd',
    'Test',
    'Pretest',
    'CDD',
    'SCI SOTRADIC',
    'Sécurité',
    'Agent de Sécurité',
    1,
    '12',
    '2025-04-02',
    '2026-04-02',
    'oui',
    'oui'
  ),
  (
    8,
    'vrsbvs',
    'Testty',
    'pretest',
    'CDD',
    'SCI SOTRADIC',
    'Immobilier',
    'Dame de Chambre/Valet de Chambre',
    1,
    '12',
    '2025-04-14',
    '2026-04-14',
    'oui',
    'non'
  ),
  (
    9,
    'DJKD',
    'GADEU',
    'DONA BARBARA',
    'CDD',
    'SCI SOTRADIC',
    'Immobilier',
    'Dame de Chambre/Valet de Chambre',
    2,
    '12',
    '2025-04-16',
    '2026-04-16',
    'non',
    'non'
  ),
  (
    10,
    'IHIL',
    'jnil',
    'lknk',
    'CDD',
    'SCI SOTRADIC',
    'Immobilier',
    'Valet de Chambre/Dame de Chambre',
    42,
    '24',
    '2025-06-02',
    '2027-06-02',
    'non',
    'non'
  ),
  (
    11,
    'Bkue58',
    'Nhyf',
    'BKUD',
    'CDI',
    'SCI SOTRADIC',
    'Immobilier',
    'Dame de Chambre/Valet de Chambre',
    1,
    '1',
    '2024-01-01',
    '2025-01-01',
    'non',
    'oui'
  ),
  (
    12,
    'ghjtukg',
    'fjjkrf',
    'nfgj',
    'CDD',
    'SCI SOTRADIC',
    'Immobilier',
    'Dame de Chambre/Valet de Chambre',
    1,
    '12',
    '2025-01-18',
    '2026-01-18',
    'non',
    'oui'
  ),
  (
    13,
    'klNd7',
    'NTEP',
    'Wally',
    'CDD',
    'SCI SOTRADIC',
    'Informatique',
    'Support Informatique',
    9,
    '12',
    '2024-05-01',
    '2025-05-01',
    'oui',
    'oui'
  ),
  (
    14,
    'JYGK7',
    'Jien',
    'Ndiufh',
    'Stage Essaie',
    'SCI SOTRADIC',
    'Direction',
    'Assistante de Direction',
    1,
    '12',
    '2024-04-19',
    '2025-04-19',
    'oui',
    'oui'
  ),
  (
    15,
    'SCI202549',
    'DJUIDJIE NDASSI',
    'Olga Céleste ',
    'CDI',
    'SCI SOTRADIC',
    'Informatique',
    'Support Informatique',
    3,
    '12',
    '2024-06-22',
    '2025-06-22',
    'oui',
    'oui'
  ),
  (
    16,
    'SCIlne',
    'NOM',
    'PRENOM',
    'CDI',
    'WORD HR',
    'Sécurité',
    'Agent de Sécurité',
    12,
    '12',
    '2025-06-02',
    '2026-07-02',
    'oui',
    'oui'
  ),
  (
    18,
    'gdf',
    'gdd',
    'dfd',
    'Stage Professionel',
    'SCI SOTRADIC',
    'Marketing',
    'Agent Marketing',
    3,
    '12',
    '2025-04-15',
    '2026-04-15',
    'oui',
    'oui'
  );
-- --------------------------------------------------------
--
-- Structure de la table `contrats_echus`
--

DROP TABLE IF EXISTS `contrats_echus`;
CREATE TABLE IF NOT EXISTS `contrats_echus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_contrat` int NOT NULL,
  `type_contrat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `poste` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `duree_contrat` int NOT NULL,
  `date_prise_effet` date NOT NULL,
  `date_echeance` date NOT NULL,
  `reconductible` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM AUTO_INCREMENT = 12 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Déchargement des données de la table `contrats_echus`
--

INSERT INTO `contrats_echus` (
    `id`,
    `id_contrat`,
    `type_contrat`,
    `entite`,
    `service`,
    `poste`,
    `duree_contrat`,
    `date_prise_effet`,
    `date_echeance`,
    `reconductible`
  )
VALUES (
    1,
    13,
    'CDD',
    'SCI SOTRADIC',
    'Gestion Immobilière',
    'Support Informatique',
    12,
    '2024-05-01',
    '2025-05-01',
    'oui'
  ),
  (
    2,
    13,
    'CDI',
    'SCI SOTRADIC',
    'Informatique',
    'Agent Commerciale',
    12,
    '2024-05-01',
    '2025-05-01',
    'non'
  ),
  (
    3,
    13,
    'CDI',
    'SCI SOTRADIC',
    'Informatique',
    'Support Informatique',
    12,
    '2024-05-01',
    '2025-05-01',
    'oui'
  ),
  (
    4,
    13,
    'CDD',
    'SCI SOTRADIC',
    'Approvisionement',
    'Agent Commerciale',
    12,
    '2024-05-01',
    '2025-05-01',
    'oui'
  ),
  (
    5,
    13,
    'CDD',
    'SCI SOTRADIC',
    'Approvisionement',
    'Agent Commerciale',
    12,
    '2024-05-01',
    '2025-05-01',
    'non'
  ),
  (
    6,
    13,
    'CDI',
    'SCI SOTRADIC',
    'Approvisionement',
    'Agent d\'approvisionement',
    12,
    '2024-05-01',
    '2025-05-01',
    'non'
  ),
  (
    7,
    13,
    'CDD',
    'SCI SOTRADIC',
    'Approvisionement',
    'Agent Commerciale',
    12,
    '2024-05-01',
    '2025-05-01',
    'non'
  ),
  (
    8,
    13,
    'CDD',
    'SCI SOTRADIC',
    'Marketing',
    'Agent Marketing',
    12,
    '2024-05-01',
    '2025-05-01',
    'oui'
  ),
  (
    9,
    15,
    'CDD',
    'SCI SOTRADIC',
    'Informatique',
    'Support Informatique',
    12,
    '2024-06-22',
    '2025-06-22',
    'oui'
  ),
  (
    10,
    18,
    'CDD',
    'SCI SOTRADIC',
    'Approvisionement',
    'autre',
    12,
    '2025-04-28',
    '2026-04-28',
    'non'
  ),
  (
    11,
    18,
    'CDI',
    'SCI SOTRADIC',
    'Approvisionement',
    'autre',
    12,
    '2025-04-28',
    '2026-04-28',
    'oui'
  );
-- --------------------------------------------------------
--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int NOT NULL,
  `service` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `poste` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `service`, `poste`)
VALUES (1, 'Approvisionement', 'Responsable Appro'),
  (
    2,
    'Approvisionement',
    'Agent d\'approvisionement'
  ),
  (3, 'Comptabilité', 'Comptable'),
  (
    4,
    'Comptabilité',
    'Responsable Administratif et Financier'
  ),
  (5, 'Comptabilité', 'Responsable Comptable'),
  (6, 'Informatique', 'Support Informatique'),
  (7, 'Direction', 'Assistante de Direction'),
  (8, 'Ressource Humaine', 'Ressource Humaine'),
  (
    9,
    'Ressource Humaine',
    'Responsable Ressource Humaine'
  ),
  (10, 'Audit', 'Auditeur/rice'),
  (
    11,
    'Immobilier',
    'Dame de Chambre/Valet de Chambre'
  ),
  (
    12,
    'Immobilier',
    'Responsable Gestion immobilier'
  ),
  (
    13,
    'Immobilier',
    'Gestionnaire Immobilier Associé'
  ),
  (14, 'Immobilier', 'Receptioniste/Concierge'),
  (
    15,
    'Immobilier',
    'Valet de Chambre/Dame de Chambre'
  ),
  (16, 'Marketing', 'Agent Marketing'),
  (17, 'Marketing', 'Agent Commerciale'),
  (18, 'Sécurité', 'Agent de Sécurité');
-- --------------------------------------------------------
--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `type`)
VALUES (
    1,
    'TCHINDA Rita',
    'tchinda_r',
    'admin2854',
    'super admin'
  ),
  (2, 'Mefura', 'mefura_a', 'adminrh', 'admin');
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;