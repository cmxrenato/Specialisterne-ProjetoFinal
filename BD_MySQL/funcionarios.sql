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
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `matricula` varchar(50) NOT NULL,
  `setor` varchar(100) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `login`, `senha`, `nome`, `matricula`, `setor`, `criado_em`) VALUES
(8, 'renato@studioplay.com', '$2y$10$MaVVNBxnY18FhX0V6FU/IOleq4adrJN8MwnvMcQCBz31rIgr8/ZZa', 'Renato Leal', '235689', 'TI', '2025-04-14 23:49:12'),
(9, 'maria@studioplay.com', '$2y$10$BIhhJK14/lJReADtPWW5TuyEqqpD1DaMdVFn3.2I7rhVmKuaUYRXy', 'Maria Silva', '245741', 'TI', '2025-04-14 23:49:56'),
(10, 'joao@studioplay.com', '$2y$10$PxxB5ZglNVqD.nTIGX57Q.GsFpIx7deXHe4Up6ioEyxZVMoLKWQIG', 'João', '152163', 'DESIGN', '2025-04-14 23:50:30');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
