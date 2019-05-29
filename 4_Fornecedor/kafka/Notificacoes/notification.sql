-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Tempo de geração: 29/05/2019 às 16:57
-- Versão do servidor: 5.7.22-log
-- Versão do PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `stagiopbd_dev`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `from` varchar(15) NOT NULL,
  `to` varchar(15) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(60) NOT NULL,
  `text` tinytext NOT NULL,
  `protocol` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `notification`
--

INSERT INTO `notification` (`id`, `from`, `to`, `datetime`, `title`, `text`, `protocol`) VALUES
(1, 'stagiopbd', 'supplier', '2019-05-29 14:31:23', 'ATENÇÃO FORNECEDORES: CÓDIGO VERDE', 'A cidade de São José dos Campos não teve quantidade significativa de exames e casos confirmados do Sarampo nos últimos 7 dias. A doença está controlada.', 'normal'),
(2, 'stagiopbd', 'supplier', '2019-05-29 16:57:21', 'ATENÇÃO FORNECEDORES: CÓDIGO AMARELO', 'A cidade de São José dos Campos realizou 315 exames para o Sarampo nos últimos 30 dias. Verifique fornecimento de medicamentos necessários na realização dos exames.', 'attention'),
(3, 'stagiopbd', 'supplier', '2019-05-29 16:57:21', 'ATENÇÃO FORNECEDORES: CÓDIGO VERMELHO', 'A cidade de São José dos Campos teve 81 casos confirmados para o Sarampo nos últimos 60 dias. Verifique fornecimento de medicamentos para controle da doença.', 'critical');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
