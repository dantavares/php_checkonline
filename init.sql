-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: status_db
-- Tempo de geração: 22/03/2026 às 15:12
-- Versão do servidor: 11.8.6-MariaDB-ubu2404
-- Versão do PHP: 8.1.2-1ubuntu2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

USE status;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `status`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cmv_barueri`
--

CREATE TABLE `cmv_barueri` (
  `id` int(11) NOT NULL,
  `ip_pub` varchar(30) NOT NULL,
  `nvr_p` int(11) NOT NULL DEFAULT 8000,
  `nvr_http_p` int(11) NOT NULL DEFAULT 80,
  `unidade` varchar(30) DEFAULT NULL,
  `provedor` varchar(20) DEFAULT NULL,
  `ip_loc` varchar(20) DEFAULT NULL,
  `n_cam` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT '?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cmv_barueri`
--

INSERT INTO `cmv_barueri` (`id`, `ip_pub`, `nvr_p`, `nvr_http_p`, `unidade`, `provedor`, `ip_loc`, `n_cam`, `status`) VALUES
(1, 'nvr13.cv-barueri.dns.army', 8000, 80, 'NVR 13', 'America NET', '172.16.10.13', 6, 'OffLine'),
(2, 'nvr14.cv-barueri.dns.army', 8000, 80, 'NVR 14', 'America NET', '172.16.10.14', 16, 'OffLine'),
(3, 'nvr15.cv-barueri.dns.army', 8000, 80, 'NVR 15', 'America NET', '172.16.10.15', 16, 'OffLine'),
(4, 'nvr16.cv-barueri.dns.army', 8000, 80, 'NVR 16', 'America NET', '172.16.10.16', 16, 'OffLine'),
(5, 'nvr17.cv-barueri.dns.army', 8000, 80, 'NVR 17', 'America NET', '172.16.10.17', 15, 'OffLine'),
(6, 'nvr18.cv-barueri.dns.army', 8000, 80, 'NVR 18', 'America NET', '172.16.10.18', 14, 'OffLine'),
(7, 'nvr19.cv-barueri.dns.army', 8000, 80, 'NVR 19', 'America NET', '172.16.10.19', 8, 'OffLine'),
(8, 'nvr20.cv-barueri.dns.army', 8000, 80, 'NVR 20', 'America NET', '172.16.11.1', 32, 'OffLine'),
(9, 'nvr21.cv-barueri.dns.army', 8000, 80, 'NVR 21', 'America NET', '172.16.12.1', 5, 'OffLine'),
(10, 'nvr.casabranca.dns.army', 8000, 80, 'Casa Branca', 'NUVYON', '192.168.3.101', 15, 'OffLine');

-- --------------------------------------------------------

--
-- Estrutura para tabela `colors`
--

CREATE TABLE `colors` (
  `color_id` tinyint(4) NOT NULL,
  `exp` varchar(100) NOT NULL,
  `rgb` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `colors`
--

INSERT INTO `colors` (`color_id`, `exp`, `rgb`) VALUES
(4, '^ONLINE', '#859df4'),
(6, '^OFFLINE', '#f48686');

-- --------------------------------------------------------

--
-- Estrutura para tabela `diversos`
--

CREATE TABLE `diversos` (
  `id` int(11) NOT NULL,
  `ip_pub` varchar(30) NOT NULL,
  `nvr_p` int(11) NOT NULL DEFAULT 8000,
  `nvr_http_p` int(11) NOT NULL DEFAULT 80,
  `unidade` varchar(30) DEFAULT NULL,
  `provedor` varchar(20) DEFAULT NULL,
  `ip_loc` varchar(20) DEFAULT NULL,
  `n_cam` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT '?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `diversos`
--

INSERT INTO `diversos` (`id`, `ip_pub`, `nvr_p`, `nvr_http_p`, `unidade`, `provedor`, `ip_loc`, `n_cam`, `status`) VALUES
(1, 'hch07kpbqt8.sn.mynetname.net', 8291, 80, 'Global Midia', 'Joy', NULL, 0, 'OffLine'),
(2, 'hcs080skpm4.sn.mynetname.net', 8291, 80, 'UBS1', 'ARFIBER', NULL, 0, 'OffLine'),
(3, 'hcr088wjx6g.sn.mynetname.net', 8291, 80, 'UBS Alcides', 'ARFIBER', NULL, 0, 'OnLine'),
(4, 'hcs089j2h9d.sn.mynetname.net', 8291, 80, 'UBS Alcides 2', 'ARFIBER', NULL, 0, 'OnLine'),
(5, 'nvr.casabranca.dns.army', 8000, 80, 'Casa Branca', 'NUVYON', NULL, 0, 'OffLine');

-- --------------------------------------------------------

--
-- Estrutura para tabela `esc_aracoiaba`
--

CREATE TABLE `esc_aracoiaba` (
  `id` tinyint(4) NOT NULL,
  `ip_pub` varchar(20) DEFAULT NULL,
  `nvr_p` int(11) NOT NULL DEFAULT 8000,
  `alm_p` int(11) NOT NULL DEFAULT 8002,
  `unidade` varchar(50) DEFAULT NULL,
  `provedor` varchar(10) DEFAULT NULL,
  `ip_loc` varchar(20) DEFAULT NULL,
  `nvr_http_p` int(11) NOT NULL DEFAULT 8001,
  `n_cam` tinyint(4) NOT NULL DEFAULT 0,
  `status_nvr` varchar(10) NOT NULL DEFAULT '?',
  `status_al` varchar(10) NOT NULL DEFAULT '?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `esc_aracoiaba`
--

INSERT INTO `esc_aracoiaba` (`id`, `ip_pub`, `nvr_p`, `alm_p`, `unidade`, `provedor`, `ip_loc`, `nvr_http_p`, `n_cam`, `status_nvr`, `status_al`) VALUES
(1, '45.169.136.142', 8000, 8002, 'Albino Mariano Rodrigues', 'MegaNet', '192.168.0.138', 8001, 10, 'OnLine', 'OnLine'),
(2, '201.55.198.105', 8000, 8002, 'Alcebíades Leonel Machado', 'IP NET', '192.168.0.111', 8001, 11, 'OnLine', 'OnLine'),
(3, '45.180.80.156', 8000, 8002, 'Alfredo Emiliano Lourenço', 'AR Fiber', '192.168.0.114', 8001, 8, 'OnLine', 'OnLine'),
(4, '45.180.80.175', 8000, 8002, 'Antônio Caetano Leite', 'AR Fiber', '192.168.1.114', 8001, 16, 'OnLine', 'OnLine'),
(5, '45.180.80.172', 8000, 8002, 'Antônio Euzébio Gonçalves', 'AR Fiber', '192.168.1.114', 8001, 8, 'OnLine', 'OnLine'),
(6, '45.180.80.210', 8000, 8002, 'Aurea Duarte Rocha', 'AR Fiber', '192.168.0.179', 8001, 11, 'OnLine', 'OnLine'),
(7, '45.191.152.87', 8000, 8002, 'Benedito Delfino', 'Alginet', '192.168.1.104', 8001, 11, 'OnLine', 'OnLine'),
(8, '45.180.80.221', 8000, 8002, 'Benedito Antunes da Cruz (Barreiro)', 'AR Fiber', '192.168.1.200', 8001, 8, 'OnLine', 'OnLine'),
(9, '45.180.80.215', 8000, 8002, 'Cel. Antônio Rodrigues de Miranda', 'AR Fiber', '192.168.0.200', 8001, 8, 'OnLine', 'OnLine'),
(10, '45.180.80.209', 8000, 8002, 'Célia Miguel Nottolini', 'AR Fiber', '192.168.0.102', 8001, 12, 'OnLine', 'OnLine'),
(11, '45.180.80.188', 8000, 8002, 'Creusa Maria Cardoso Roldan (Centro ED.)', 'AR Fiber', '192.168.1.114', 8001, 8, 'OnLine', 'OnLine'),
(12, '45.191.152.65', 8000, 8002, 'Celso Charuri', 'Alginet', '192.168.0.186', 8001, 12, 'OnLine', 'OnLine'),
(13, '201.55.198.134', 8000, 8002, 'Eliane Aparecida Plens Cavalheiros', 'IP NET', '192.168.0.122', 8001, 12, 'OnLine', 'OnLine'),
(14, '45.180.80.202', 8000, 8002, 'Prof. Helena Rodrigues', 'AR Fiber', '192.168.1.104', 8001, 10, 'OnLine', 'OnLine'),
(15, '201.55.198.152', 8000, 8002, 'Honório Carriel Cleto', 'IP NET', '192.168.0.177', 8001, 10, 'OnLine', 'OnLine'),
(16, '45.180.80.212', 8000, 8002, 'Ligia de Paula Alvares', 'AR Fiber', '192.168.1.199', 8001, 10, 'OnLine', 'OnLine'),
(17, '45.180.80.165', 8000, 8002, 'Maria Coutinho Florenzano', 'AR Fiber', '192.168.1.112', 8001, 10, 'OnLine', 'OnLine'),
(18, '45.191.152.148', 8000, 8002, 'Maria de Souza Cruz', 'Alginet', '192.168.0.132', 8001, 12, 'OnLine', 'OnLine'),
(19, '45.180.80.208', 8000, 8002, 'Maria Mizue Nagaishi Florenzano', 'AR Fiber', '192.168.1.200', 8001, 16, 'OnLine', 'OnLine'),
(20, '45.180.80.201', 8000, 8002, 'Maria Silvia Florenzano', 'AR Fiber', '192.168.0.111', 8001, 16, 'OnLine', 'OnLine'),
(21, '45.180.80.213', 8000, 8002, 'Marisa Mascarenhas', 'AR Fiber', '192.168.0.103', 8001, 10, 'OnLine', 'OnLine'),
(22, '45.180.80.211', 8000, 8002, 'Pedro Ferreira Duarte Neto', 'AR Fiber', '192.168.0.102', 8001, 12, 'OnLine', 'OnLine'),
(23, '201.55.198.154', 8000, 8002, 'Rita Machado', 'IP NET', '192.168.0.171', 8001, 7, 'OnLine', 'OnLine'),
(24, '45.191.152.91', 8000, 8002, 'São Conrado (Roldan)', 'Alginet', '192.168.1.105', 8001, 16, 'OnLine', 'OnLine'),
(25, '45.180.80.220', 8084, 8284, 'Prof. Osmar Giacomelli', 'AR Fiber', '192.168.1.200', 84, 15, 'OnLine', 'OnLine'),
(26, '45.180.80.220', 8083, 8283, 'Secretaria de educação', 'AR Fiber', '192.168.1.201', 83, 4, 'OnLine', 'OnLine'),
(27, '45.180.80.222', 8085, 8002, 'Barracão da Secretaria', 'AR Fiber', '192.168.1.202', 85, 7, 'OnLine', 'OnLine'),
(28, '45.180.80.214', 84, 84, 'Guarda Municipal', 'AR Fiber', '192.168.10.100', 84, 1, 'OnLine', 'OnLine');

-- --------------------------------------------------------

--
-- Estrutura para tabela `invitations`
--

CREATE TABLE `invitations` (
  `invitation_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `invitation_key` varchar(255) NOT NULL,
  `p_list` varchar(30) NOT NULL DEFAULT '''[0]'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tables`
--

CREATE TABLE `tables` (
  `id` smallint(6) NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '?',
  `lstupt` datetime NOT NULL DEFAULT current_timestamp(),
  `isupt` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tables`
--

INSERT INTO `tables` (`id`, `name`, `lstupt`, `isupt`) VALUES
(1, 'esc_aracoiaba', '2026-03-22 11:50:23', 0),
(4, 'cmv_barueri', '2026-03-22 11:50:42', 0),
(5, 'diversos', '2026-03-22 11:51:00', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `invited_by` int(10) UNSIGNED DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `passkey` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `isadmin` tinyint(4) DEFAULT NULL,
  `p_list` text DEFAULT '[0]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Despejando dados para a tabela `users`
--
INSERT INTO `users` VALUES (1,0,'admin','$2y$10$JjDuoGbdvG8cy1wpG6BSAOR1sHEo8QwvOI5BfqejwyKovOI1WGZTy','9ce607b6aebbd5c38c78b38e9135ac50','dantavares@gmail.com',1, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cmv_barueri`
--
ALTER TABLE `cmv_barueri`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`color_id`);

--
-- Índices de tabela `diversos`
--
ALTER TABLE `diversos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `esc_aracoiaba`
--
ALTER TABLE `esc_aracoiaba`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`invitation_id`),
  ADD UNIQUE KEY `unique_index` (`email`,`invitation_key`),
  ADD KEY `invited` (`user_id`);

--
-- Índices de tabela `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cmv_barueri`
--
ALTER TABLE `cmv_barueri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `colors`
--
ALTER TABLE `colors`
  MODIFY `color_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `diversos`
--
ALTER TABLE `diversos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `esc_aracoiaba`
--
ALTER TABLE `esc_aracoiaba`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `invitations`
--
ALTER TABLE `invitations`
  MODIFY `invitation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tables`
--
ALTER TABLE `tables`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `invitations`
--
ALTER TABLE `invitations`
  ADD CONSTRAINT `invited` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
