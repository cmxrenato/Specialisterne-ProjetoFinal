-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/04/2025 às 02:20
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `studioplay`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `id_pergunta` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `resposta` text NOT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `id_resposta_pai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pergunta` (`id_pergunta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `respostas_ibfk_1` FOREIGN KEY (`id_pergunta`) REFERENCES `perguntas` (`id`),
  ADD CONSTRAINT `respostas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `funcionarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
