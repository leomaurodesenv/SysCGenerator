-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
-- Versão do servidor: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

--
-- Database: `SysCGenerator`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `7_sgc_event`
--

CREATE TABLE `7_sgc_event` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner_certificate` varchar(200) NOT NULL,
  `event_certificate` varchar(200) NOT NULL,
  `place_certificate` varchar(200) NOT NULL,
  `date_certificate` varchar(200) NOT NULL,
  `workload_certificate` int(11) DEFAULT NULL,
  `layout_certificate` varchar(200) DEFAULT NULL,
  `programming_certificate` text,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Extraindo dados da tabela `7_sgc_event`
--

INSERT INTO `7_sgc_event` (`id`, `id_user`, `name`, `owner_certificate`, `event_certificate`, `place_certificate`, `date_certificate`, `workload_certificate`, `layout_certificate`, `programming_certificate`, `active`, `date`) VALUES
(1, 1, 'tag-exemplo-de-evento', 'Leonardo Mauro Inc.', 'Evento de Exemplo da Computação 1 - EEC XII (2016)', 'Centro de Convenções - Ponta Porã', '19 de Abril de 2016', 20, 'lm-layout_01', '<b>19/04/2015</b>\n<i>13:00h às 15:00h - Primeira aula</i>\n<i>15:00h - 15:30h - Café</i>\n<i>15:30h às 17:00h - Segunda aula</i>', 1, '2016-04-19 09:33:56'),
(2, 1, 'leo-mauro-arduino-cubo-magico', 'Programa de Educação Tutorial (PET) Fronteira', 'Minicurso de Arduino: Introdução a Eletrônica Básica', 'Universidade Federal de Mato Grosso do Sul (UFMS) - Campus de Ponta Porã', '01 de Novembro de 2016', 10, 'lm-layout_01', '<b>01/11/2015</b>\n<i>13:00h às 15:00h - Primeira aula</i>\nApresentação do Arduino e componentes\n<i>15:00h - 15:30h - Café</i>\n<i>15:30h às 17:00h - Segunda aula</i>\nRealização de atividades/tarefas\n<i>17:00h - 17:30h - Encerramento Minicurso</i>\n\n<b>02/11/2015</b>\n<i>13:00h às 15:00h - Atividade extraclasse</i>\n\n<b>03/11/2015</b>\n<i>13:00h às 15:00h - Atividade extraclasse</i>', 0, '2016-10-29 23:20:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `7_sgc_layout`
--

CREATE TABLE `7_sgc_layout` (
  `id` int(11) NOT NULL,
  `val_layout` varchar(200) NOT NULL,
  `option_layout` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `7_sgc_layout`
--

INSERT INTO `7_sgc_layout` (`id`, `val_layout`, `option_layout`) VALUES
(1, 'lm-layout_01', 'Layout 01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `7_sgc_participants`
--

CREATE TABLE `7_sgc_participants` (
  `id_partp` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `name_partp` varchar(100) NOT NULL,
  `cpf_partp` varchar(20) DEFAULT NULL,
  `email_partp` varchar(200) NOT NULL,
  `standard_partp` varchar(100) NOT NULL,
  `extra_partp` varchar(200) DEFAULT NULL,
  `date_partp` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Extraindo dados da tabela `7_sgc_participants`
--

INSERT INTO `7_sgc_participants` (`id_partp`, `id_event`, `name_partp`, `cpf_partp`, `email_partp`, `standard_partp`, `extra_partp`, `date_partp`, `active`) VALUES
(1, 1, 'Leonardo Mauro Pereira Moraes', '', 'leo.mauro.desenv@gmail.com', 'Participante', '', '2016-12-09 16:49:09', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `7_sgc_standard`
--

CREATE TABLE `7_sgc_standard` (
  `id_stand` int(11) NOT NULL,
  `val_stand` varchar(100) NOT NULL,
  `option_stand` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `7_sgc_standard`
--

INSERT INTO `7_sgc_standard` (`id_stand`, `val_stand`, `option_stand`) VALUES
(2, 'Ouvinte', 'Ouvinte'),
(1, 'Participante', 'Participante'),
(3, 'Ministrante', 'Ministrante'),
(4, 'Monitor', 'Monitor');

-- --------------------------------------------------------

--
-- Estrutura da tabela `7_sgc_user`
--

CREATE TABLE `7_sgc_user` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass_user` varchar(50) NOT NULL,
  `name_user` varchar(200) NOT NULL,
  `email_user` varchar(200) DEFAULT NULL,
  `phone_user` varchar(50) DEFAULT NULL,
  `institution_user` varchar(200) DEFAULT NULL,
  `acess_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `7_sgc_user`
--

INSERT INTO `7_sgc_user` (`id`, `user`, `pass_user`, `name_user`, `email_user`, `phone_user`, `institution_user`, `acess_user`) VALUES
(1, 'test', 'test', 'Leonardo Mauro', 'leo.mauro.desenv@gmail.com', '(99) 9999-9999', 'UFMS/CPPP', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `7_sgc_event`
--
ALTER TABLE `7_sgc_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `7_sgc_layout`
--
ALTER TABLE `7_sgc_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `7_sgc_participants`
--
ALTER TABLE `7_sgc_participants`
  ADD PRIMARY KEY (`id_partp`),
  ADD KEY `id_event` (`id_event`);

--
-- Indexes for table `7_sgc_standard`
--
ALTER TABLE `7_sgc_standard`
  ADD PRIMARY KEY (`id_stand`);

--
-- Indexes for table `7_sgc_user`
--
ALTER TABLE `7_sgc_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `7_sgc_event`
--
ALTER TABLE `7_sgc_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `7_sgc_layout`
--
ALTER TABLE `7_sgc_layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `7_sgc_participants`
--
ALTER TABLE `7_sgc_participants`
  MODIFY `id_partp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `7_sgc_standard`
--
ALTER TABLE `7_sgc_standard`
  MODIFY `id_stand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `7_sgc_user`
--
ALTER TABLE `7_sgc_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `7_sgc_event`
--
ALTER TABLE `7_sgc_event`
  ADD CONSTRAINT `7_sgc_event_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `7_sgc_user` (`id`);

--
-- Limitadores para a tabela `7_sgc_participants`
--
ALTER TABLE `7_sgc_participants`
  ADD CONSTRAINT `7_sgc_participants_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `7_sgc_event` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
