-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 29-Nov-2021 às 12:37
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bludata`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `estado` varchar(250) NOT NULL,
  `cidade` varchar(250) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ucs2;

--
-- Extraindo dados da tabela `empresas`
--

INSERT INTO `empresas` (`id`, `nome`, `estado`, `cidade`, `cnpj`, `data`) VALUES
(1, 'Cafeteria', 'SC', 'Blumenau', '21.321.321/3213-14', '2021-11-29 09:12:56'),
(2, 'Pizzaria', 'PR', 'Alvorada', '30.440.388/0001-02', '2021-11-29 09:25:35'),
(3, 'Hamburgueria', 'RJ', 'Angra', '96.358.161/0001-20', '2021-11-29 09:26:26'),
(4, 'FarmÃ¡cia', 'SC', 'Blumenau', '09.296.745/0001-14', '2021-11-29 09:27:17'),
(5, 'Auto Escola', 'SC', 'Blumenau', '98.386.372/0001-00', '2021-11-29 09:28:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id` int(11) NOT NULL,
  `empresa` varchar(250) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `tipo_documento` varchar(30) NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `rg` varchar(20) NOT NULL,
  `data_nascimento` date NOT NULL,
  `telefones` text NOT NULL,
  `data_cadastro` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ucs2;

--
-- Extraindo dados da tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id`, `empresa`, `nome`, `tipo_documento`, `numero_documento`, `rg`, `data_nascimento`, `telefones`, `data_cadastro`) VALUES
(1, 'Cafeteria', 'MÃ¡quinas de cafÃ©', 'CNPJ', '86.348.887/0001-29', '', '0000-00-00', '(47) 9999-88888#(47) 8888-99999#', '2021-11-29 09:15:22'),
(2, 'Cafeteria', 'GrÃ£o de cafÃ©', 'CNPJ', '88.632.420/0001-31', '', '0000-00-00', '(47) 7777-88888#(47) 3333-22222#(47) 5555-44444#', '2021-11-29 09:17:21'),
(3, 'Cafeteria', 'Leite', 'CPF', '245.062.130-09', '48.587.839-2', '1979-11-10', '(47) 1111-99999#(47) 2222-11111#(47) 3333-11111#', '2021-11-29 09:21:13'),
(4, 'Cafeteria', 'CafÃ© Gourmet', 'CNPJ', '52.331.717/0001-10', '', '0000-00-00', '(47) 9999-99999#(47) 7777-77777#(47) 8888-88888#', '2021-11-29 09:23:00'),
(5, 'Cafeteria', 'AÃ§ucar', 'CNPJ', '95.994.677/0001-07', '', '0000-00-00', '(47) 3333-33333#', '2021-11-29 09:23:36'),
(6, 'Auto Escola', 'Carro', 'CNPJ', '87.908.229/0001-07', '', '0000-00-00', '(47) 5555-55555#', '2021-11-29 09:29:52'),
(7, 'Auto Escola', 'PÃ¡tio para manobras', 'CNPJ', '80.131.425/0001-79', '', '0000-00-00', '(46) 7777-77778#', '2021-11-29 09:31:11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `senha` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$2HmIvJMFxUIwq9ePVp4Oqe/fA2fzLlQQulOoyaoUCDYubBpZC5p/q');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
