-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: delivery
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `itens_pedido`
--

DROP TABLE IF EXISTS `itens_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `nome_produto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_produto` (`id_produto`),
  CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `itens_pedido_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itens_pedido`
--

LOCK TABLES `itens_pedido` WRITE;
/*!40000 ALTER TABLE `itens_pedido` DISABLE KEYS */;
INSERT INTO `itens_pedido` VALUES (3,48,2,1,39.90,'Pizza Calabresa'),(4,48,4,1,24.90,'Lasanha à Bolonhesa'),(5,48,6,1,42.00,'Pizza Quatro Queijos'),(6,49,4,1,24.90,'Lasanha à Bolonhesa'),(7,50,2,1,39.90,'Pizza Calabresa');
/*!40000 ALTER TABLE `itens_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `nome_cliente` varchar(100) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `forma_pagamento` enum('Dinheiro','Cartão','Pix') NOT NULL,
  `status` enum('Pendente','Preparando','Saiu para entrega','Entregue') DEFAULT 'Pendente',
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (48,26,'Kelvin','cuasdjiasdj','(12) 31231-2312','Dinheiro','Saiu para entrega','2025-06-10 14:16:55'),(49,26,'Kelvin','123123123123','(12) 31231-2321','Cartão','Pendente','2025-06-10 15:29:25'),(50,26,'Kelvin','111111111111','(11) 11111-1111','Dinheiro','Pendente','2025-06-10 15:50:44');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,'X-Burguer','Pão com hambúrguer, queijo e molho especial.',15.90,'_public/img/Xburger.jpg'),(2,'Pizza Calabresa','Pizza com calabresa fatiada, cebola e mussarela.',39.90,'_public/img/pizza.jpg'),(3,'Batata Frita Média','Porção média de batatas fritas crocantes.',12.00,'_public/img/Batatamedia.jpg'),(4,'Lasanha à Bolonhesa','Lasanha de carne com molho bolonhesa e queijo gratinado.',24.90,'_public/img/LasanhaBolonhesa.jpg'),(5,'Hambúrguer Duplo','Dois hambúrgueres com queijo, bacon e molho especial.',22.50,'_public/img/HamburguerDuplo.jpg'),(6,'Pizza Quatro Queijos','Pizza com mussarela, provolone, parmesão e gorgonzola.',42.00,'_public/img/Pizzaquatroqueijos.jpg'),(7,'Pastel de Carne','Pastel frito recheado com carne moída temperada.',6.50,'_public/img/PastelCarne.jpg'),(8,'Esfiha de Frango','Massa recheada com frango desfiado e temperos.',5.00,'_public/img/EsfihaFrango.jpg'),(9,'Empada de Palmito','Empada recheada com palmito cremoso.',6.00,'_public/img/EmpadaPalmito.jpg'),(10,'Coxinha de Frango','Coxinha com recheio de frango desfiado e massa crocante.',6.50,'_public/img/CoxinhaFrango.jpg');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('cliente','adm') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'adm','adm@adm','$2y$10$SjuECYXcq8hYdK5FaGNdAuxQy0v01lTBv5Codo1mH2HsabeXT.jCm','adm'),(3,'Kelvin','kelvinmlcardoso@gmail.com','$2y$10$0p1VBA/4bzCViy8wLuxYjOAPfu.yGJhWJz4/rtJMfalYODjmn9gkW','cliente'),(4,'Usuário 1','usuario1@email.com','$2y$10$L8MkA1fjpT.rH35q8/v1cu4VrSkZx9TG1rbiXzcnHx3FkfzzsOLd6','cliente'),(5,'Usuário 2','usuario2@email.com','$2y$10$L8MkA1fjpT.rH35q8/v1cu4VrSkZx9TG1rbiXzcnHx3FkfzzsOLd6','cliente'),(6,'Usuário 3','usuario3@email.com','$2y$10$L8MkA1fjpT.rH35q8/v1cu4VrSkZx9TG1rbiXzcnHx3FkfzzsOLd6','cliente'),(7,'Usuário 4','usuario4@email.com','$2y$10$L8MkA1fjpT.rH35q8/v1cu4VrSkZx9TG1rbiXzcnHx3FkfzzsOLd6','cliente'),(8,'Usuário 5','usuario5@email.com','$2y$10$L8MkA1fjpT.rH35q8/v1cu4VrSkZx9TG1rbiXzcnHx3FkfzzsOLd6','cliente'),(9,'Usuário 6','usuario6@email.com','$2y$10$L8MkA1fjpT.rH35q8/v1cu4VrSkZx9TG1rbiXzcnHx3FkfzzsOLd6','adm'),(10,'Usuário 7','usuario7@email.com','$2y$10$L8MkA1fjpT.rH35q8/v1cu4VrSkZx9TG1rbiXzcnHx3FkfzzsOLd6','cliente'),(11,'Usuário 8','usuario8@email.com','$2y$10$L8MkA1fjpT.rH35q8/v1cu4VrSkZx9TG1rbiXzcnHx3FkfzzsOLd6','cliente'),(12,'Usuário 9','usuario9@email.com','$2y$10$L8MkA1fjpT.rH35q8/v1cu4VrSkZx9TG1rbiXzcnHx3FkfzzsOLd6','adm'),(13,'Usuário 10','usuario10@email.com','$2y$10$L8MkA1fjpT.rH35q8/v1cu4VrSkZx9TG1rbiXzcnHx3FkfzzsOLd6','cliente'),(24,'Kelvin','kelvin@example.com','$2y$10$L8MkA1fjpT.rH35q8/v1cu4VrSkZx9TG1rbiXzcnHx3FkfzzsOLd6','cliente'),(25,'Kelvin','kelvin@kelvin','$2y$10$5UMXwLguYgVYAf3ELUXeMevAjXVylnWpGj0IvB7XpBbv6XxRrz3pO','cliente'),(26,'Kelvin','kelvin@kelvin.com','$2y$10$gx2Ia3S8ZKCqkYs1wBhAjuC25wqJLd9S70zqBr0vkNvx1tESDEjXq','cliente');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-10 13:08:26
