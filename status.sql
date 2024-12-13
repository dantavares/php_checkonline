SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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

-- --------------------------------------------------------

--
	-- Estrutura para tabela `hosp_upas_hortolandia`
--

CREATE TABLE `hosp_upas_hortolandia` (
	`id` int(11) NOT NULL,
	`ip_pub` varchar(20) NOT NULL,
	`nvr_p` int(11) NOT NULL DEFAULT 8000,
	`nvr_http_p` int(11) NOT NULL DEFAULT 8001,
	`unidade` varchar(30) DEFAULT NULL,
	`provedor` varchar(20) DEFAULT NULL,
	`ip_loc` varchar(20) DEFAULT NULL,
	`n_cam` tinyint(4) NOT NULL DEFAULT 0,
	`status` varchar(20) NOT NULL DEFAULT '?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
	-- Estrutura para tabela `invitations`
--

CREATE TABLE `invitations` (
	`invitation_id` int(10) UNSIGNED NOT NULL,
	`user_id` int(10) UNSIGNED NOT NULL,
	`email` varchar(255) NOT NULL,
	`invitation_key` varchar(255) NOT NULL
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
(1, 'esc_aracoiaba', '2024-12-13 20:45:53', 0),
(2, 'hosp_upas_hortolandia', '2024-12-13 20:45:11', 0),
(3, 'esc_itapecerica', '2024-12-13 20:46:19', 0);

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
INSERT INTO `users` (`user_id`, `invited_by`, `username`, `password`, `passkey`, `email`, `isadmin`, `p_list`) VALUES
(1,0,'admin','$2y$10$LINYtve1F9dD9ROUcvHBtOvvwzAyIaKIgGOFV3WJq20xeQYVWl98u','076c838bd016b22bd1cf0315b952433c','dantavares@gmail.com',1,NULL);

--
	-- Índices de tabela `colors`
--
ALTER TABLE `colors`
ADD PRIMARY KEY (`color_id`);

--
	-- Índices de tabela `esc_aracoiaba`
--
ALTER TABLE `esc_aracoiaba`
ADD PRIMARY KEY (`id`);

--
	-- Índices de tabela `hosp_upas_hortolandia`
--
ALTER TABLE `hosp_upas_hortolandia`
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
	-- AUTO_INCREMENT de tabela `tables`
--
ALTER TABLE `tables`
MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

--
	-- Índices de tabela `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`user_id`);

--
	-- AUTO_INCREMENT de tabela `colors`
--
ALTER TABLE `colors`
MODIFY `color_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
	-- AUTO_INCREMENT de tabela `esc_aracoiaba`
--
ALTER TABLE `esc_aracoiaba`
MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
	-- AUTO_INCREMENT de tabela `hosp_upas_hortolandia`
--
ALTER TABLE `hosp_upas_hortolandia`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
	-- AUTO_INCREMENT de tabela `invitations`
--
ALTER TABLE `invitations`
MODIFY `invitation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
	-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas `invitations`
--
ALTER TABLE `invitations`
ADD CONSTRAINT `invited` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
